<?php

/**
 * 
 */
class Controller_Admin_Rest_Ajax_Trt extends Controller_Baseajax
{

	/**
	 * 直近のTRTデータを取得します
	 * @throws Exception
	 */
	public function action_get_recent_data()
	{
		try
		{
			$trtId = Input::post("trt_id");
			$trtDataList = Model_Db_Qcommon::getRecentTrtDataList($trtId);
			if (count($trtDataList) == 0)
			{
				throw new Exception("TRTデータ取得に失敗しました");
			}

			$this->response($trtDataList);
		}
		catch (Exception $e)
		{
			$this->error($e);
		}
	}

	/**
	 * 指定時間のTRTデータを取得します
	 */
	public function action_get_hour_data()
	{
		try
		{
			$trtId = Input::post("trt_id");
			$timeFrom = Input::post("measure_time_from");
			$timeTo = date("Y-m-d H:i:s", strtotime($timeFrom . " +72 hour"));
			$limit = Input::post("limit");
			$offset = Input::post("offset");

			$trtDataList = Model_Db_Qcommonadmin::getTrtDataList($trtId, $timeFrom, $timeTo, $limit, $offset);

			$res["measure_time_to"] = $timeTo;
			$res["trt_data_list"] = $trtDataList;

			ob_clean();
			$this->response($res);
		}
		catch (Exception $e)
		{
			$this->error($e);
		}
	}

	/**
	 * TRT補正値を更新します
	 */
	public function action_update_correction()
	{
		try
		{
			$trtDataId = Input::post("trt_data_id");
			$trtDataName = Input::post("trt_data_name");
			$trtDataValue = Input::post("trt_data_value");

			$trtData = Model_Db_Ttrtdata::find_by_pk($trtDataId);
			if (empty($trtData))
			{
				// error
			}
			$trtData->$trtDataName = $trtDataValue;
			if ($trtData->save() == 0)
			{
				throw new Exception("TRTデータ更新に失敗しました");
			}

			$this->response("");
		}
		catch (Exception $e)
		{
			$this->error($e);
		}
	}

	/**
	 * 指定時間のTRTデータを取得します
	 */
	public function action_get_analyze_data()
	{
		try
		{
			// ヒストリーマッチング
			$historyMatching = 2.4;
			$res["history_matching"] = $historyMatching;

			// サンプリング間隔
			$samplingInterval = 1;
			$res["sampling_interval"] = $samplingInterval;

			// 物件情報取得
			$propertyId = Input::post("property_id");
			$property = Model_Db_Tproperty::find_by_pk($propertyId);
			if (empty($property))
			{
				throw new Exception();
			}
			$res["property"] = $property;

			// TRTデータ取得
			$trtDataList = Model_Db_Qcommonadmin::getTrtDataList($property->t_property_trt_id, $property->t_property_measure_time_from, $property->t_property_measure_time_to);
			$dataCount = count($trtDataList);

			$dojoShokiOndo = $trtDataList[0]["t_trt_data_return_temperature"];


			// 平均循環温度
			$heikinJunkanOndo = 0;
			$i = 0;
			foreach ($trtDataList as &$trtData)
			{
				// 平均温度
				$heikinOndo = ($trtData["t_trt_data_send_temperature_correction"] + $trtData["t_trt_data_return_temperature_correction"]) / 2;
				$trtData["heikin_ondo"] = $heikinOndo;
				$heikinJunkanOndo +=$heikinOndo;

				// 温度差
				$ondoSa = $trtData["t_trt_data_send_temperature_correction"] - $trtData["t_trt_data_return_temperature_correction"];
				$trtData["ondo_sa"] = $ondoSa;

				// 秒数
				$sec = $i++ * 60;

				// Ln
				$ln = log($sec);
				//$trtData["ln"] = $ln;
			}
			$heikinJunkanOndo = $heikinJunkanOndo / $dataCount;

			// 熱交換量平均
			$kokanNetsuryoQ = 0;
			$kokanNetsuryoq = 0;
			foreach ($trtDataList as &$trtData)
			{
				// 補正流量
				$hoseiRyuryo = $trtData["t_trt_data_flow_correction"] / $samplingInterval;
				$trtData["hosei_ryuryo"] = $hoseiRyuryo;

				// 交換熱量
				$kokanNetsuryo = $hoseiRyuryo / 60 * $heikinJunkanOndo / 1000 * $trtData["ondo_sa"];
				$trtData["kokan_netsuryo"] = $kokanNetsuryo;
				$kokanNetsuryoQ += $kokanNetsuryo;

				// Q
				$q = $kokanNetsuryo / $property["t_property_borehole_heatexchange_length"] * 1000;
				$trtData["q"] = $q;
				$kokanNetsuryoq += $q;
			}
			$kokanNetsuryoQ = $kokanNetsuryoQ / $dataCount;
			$kokanNetsuryoq = $kokanNetsuryoq / $dataCount;


			// 回帰式係数
			//$regression["slope"] = $slope = $this->s_slope(array_column($trtDataList, "heikin_ondo"), array_column($trtDataList, "ln"));
			//$regression["intercept"] = $intercept = $this->s_intercept(array_column($trtDataList, "heikin_ondo"), array_column($trtDataList, "ln"));
			$regression["slope"] = $slope = 1.20940943;
			$regression["intercept"] = $intercept = 10.3258471;
			$res["kaikishiki_keisu"] = $regression;




			$boreholeChokkei = $property["t_property_borehole_diameter"];
			$yukoNetsuKokancho = $property["t_property_borehole_heatexchange_length"];
			$ryuryo = $property["t_property_borehole_flow"];
			$tubeNaikei = $property["t_property_borehole_diameter_inner"];
			$boreholeDepth = $property["t_property_borehole_depth"];

			$yukoNetsuDendoRitsuRambda = $kokanNetsuryoQ / (4 * 3.14 * $slope);
			$soilType = Config::get("const.soil_type");
			$hinetsu = $soilType[$property["t_property_soil_type_id"]][1];
			$mitsudo = $soilType[$property["t_property_soil_type_id"]][2];

			$netsuKakusanRitsuAlpha = $yukoNetsuDendoRitsuRambda / ($hinetsu * $mitsudo);

			$boreholeHankei = $boreholeChokkei / 2;

			$donenseiKeisu = 0;
			if ($heikinJunkanOndo < 50)
			{
				$donenseiKeisu = exp(-13.233 - 0.032516 * $heikinJunkanOndo + 0.000068997 * $heikinJunkanOndo * $heikinJunkanOndo + 0.0000069513 * $heikinJunkanOndo * $heikinJunkanOndo * $heikinJunkanOndo - 0.00000009386 * $heikinJunkanOndo * $heikinJunkanOndo * $heikinJunkanOndo * $heikinJunkanOndo);
			}
			else
			{
				if ($heikinJunkanOndo < 100)
				{
					$donenseiKeisu = exp(-13.618 - 0.015499 * $heikinJunkanOndo - 0.000022461 * $heikinJunkanOndo * $heikinJunkanOndo + 0.00000036334 * $heikinJunkanOndo * $heikinJunkanOndo * $heikinJunkanOndo);
				}
				else
				{
					$donenseiKeisu = exp(-13.698 - 0.016782 * $heikinJunkanOndo + 0.000034425 * $heikinJunkanOndo * $heikinJunkanOndo);
				}
			}
			$netsuDendoRitsu = ($heikinJunkanOndo < 100) ? (0.56871 + 0.0018421 * $heikinJunkanOndo - 0.0000070472 * $heikinJunkanOndo * $heikinJunkanOndo) : (0.60791 + 0.0012032 * $heikinJunkanOndo - 0.0000047025 * $heikinJunkanOndo * $heikinJunkanOndo);
			$teiatsuHiritsu = ($heikinJunkanOndo < 100) ? (4210.4 - 1.356 * $heikinJunkanOndo - 0.0035781 * pow($heikinJunkanOndo, 2)) : (4306.8 - 2.7913 * $heikinJunkanOndo + 0.018773 * pow($heikinJunkanOndo, 2));
			$mitsudo2 = ($heikinJunkanOndo < 100) ? (1000.5 - 0.068737 * $heikinJunkanOndo - 0.0035781 * pow($heikinJunkanOndo, 2)) : (1008.7 - 0.28735 * $heikinJunkanOndo - 0.0021643 * pow($heikinJunkanOndo, 2));

			$netsuKakusanRitsu = $netsuDendoRitsu / $teiatsuHiritsu / $mitsudo2;
			$prandtl = $donenseiKeisu / $netsuKakusanRitsu;

			$kannaiMenseki = pow(($tubeNaikei / 1000 / 2), 2) * pi();
			$ryusoku = $ryuryo / 1000 / 60 / $kannaiMenseki;
			$reynolds = $ryusoku * $tubeNaikei / 1000 / $donenseiKeisu;
			$netsuDentatsuRitsuH = ($netsuDendoRitsu / $tubeNaikei * 1000) * (0.023 * pow($reynolds, 0.8) * pow($prandtl, 0.4));



			$i = 0;
			foreach ($trtDataList as &$trtData)
			{
				$sec = $i++ * 60;

				$kokanNetsuryo = $trtData["t_trt_data_flow_correction"] / 60 * $teiatsuHiritsu / 1000 * $trtData["ondo_sa"];
				$trtData["kokan_netsuryo"] = $kokanNetsuryo;

				$z = $netsuKakusanRitsuAlpha * $sec / pow($boreholeHankei, 2);
				$g = 0;
				if ($z > 100)
				{
					$g = 0.1827 * log($z) + 0.0668;
				}
				else
				{
					if ($z > 1)
					{
						$g = (0.5414 * pow($z, 0.0986)) - 0.4166;
					}
					else
					{
						if ($z < 1)
						{
							$g = 0.1443 * pow($z, 0.3374) - 0.0162;
						}
					}
				}

				$tr = $dojoShokiOndo + ($kokanNetsuryo * 1000 * $g / ($historyMatching * $yukoNetsuKokancho));

				$kaisekikai = $tr - ($kokanNetsuryo * 1000 / ($boreholeChokkei * 3.14 * $boreholeDepth * $netsuDentatsuRitsuH));
				$trtData["kaiseki_kai"] = $kaisekikai;
			}

			// 一覧
			$res["trt_data_list"] = $trtDataList;

			// 計算結果
			$calcResult["kokan_netsuryo"] = $kokanNetsuryoQ;
			$calcResult["yuko_netsu_dendo_ritsu_lambda"] = $yukoNetsuDendoRitsuRambda;
			$calcResult["heikin_kokan_netsuryo"] = "TODO";
			$calcResult["netsu_teiko_r"] = "TODO";
			$calcResult["netsu_dentatsu_ritsu_h"] = $netsuDentatsuRitsuH;
			$calcResult["netsu_kakusan_ritsu_alpha"] = $netsuKakusanRitsuAlpha;
			$calcResult["saisho_kanetsu_jikan"] = "TODO";
			$calcResult["netsu_teiko_r"] = 0; //$netsuTeikoR; // TODO
			$calcResult["kokan_netsuryo_q"] = $kokanNetsuryoq;
			$calcResult["borehole_hankei"] = $boreholeHankei;
			$calcResult["dojo_shoki_ondo"] = $dojoShokiOndo;
			$calcResult["heikin_junkansui_ondo"] = $heikinJunkanOndo;
			$res["keisan_kekka"] = $calcResult;

			// 係数の計算結果
			$calcResultCoefficient["kannai_menseki"] = $kannaiMenseki;
			$calcResultCoefficient["ryusoku"] = $ryusoku;
			$calcResultCoefficient["donensei_keisu"] = $donenseiKeisu;
			$calcResultCoefficient["netsu_dendo_ritsu"] = $netsuDendoRitsu;
			$calcResultCoefficient["teiatsu_hinetsu"] = $teiatsuHiritsu;
			$calcResultCoefficient["mitsudo"] = $mitsudo2;
			$calcResultCoefficient["netsu_kakusan_ritsu"] = $netsuKakusanRitsu;
			$calcResultCoefficient["prandtl"] = $prandtl;
			$calcResultCoefficient["reynolds"] = $reynolds;
			$calcResultCoefficient["kannai_netsu_dentatsu_ritsu"] = $netsuDentatsuRitsuH;
			$res["keisan_kekka_keisu"] = $calcResultCoefficient;

			// TRT解析結果
			$analysisResult["yuko_netsu_dendo_ritsu"] = $yukoNetsuDendoRitsuRambda;
			$analysisResult["kokan_netsuryo_q"] = $kokanNetsuryoq;
			$analysisResult["netsu_teiko_r"] = 0; //$netsuTeikoR;
			$analysisResult["netsu_kakusan_ritsu_alpha"] = $netsuKakusanRitsuAlpha;
			$res["trt_kaiseki_kekka"] = $analysisResult;

			ob_clean();
			$this->response($res);
		}
		catch (Exception $e)
		{

			$this->error($e);
		}
	}

	private function s_intercept($list_y, $list_x)
	{
		if (count($list_x) < 2 || count($list_y) < 2 || count($list_x) != count($list_y))
		{
			return false;
		}
		$count = count($list_x);
		for ($i = 0; $i < $count; $i++)
		{
			$x = $list_x[$i];
			$y = $list_y[$i];
			$x_sum += $x;
			$y_sum += $y;
			$xx_sum += $x * $x;
			$xy_sum += $x * $y;
		}
		$a = ($count * $xy_sum - $x_sum * $y_sum) / ($count * $xx_sum - $x_sum * $x_sum);
		$b = ($y_sum - $a * $x_sum) / $count;

		return $b;
	}

	/**
	 * 回帰直線の傾きを求める
	 * （[y = a * x + b]の[a]を求める）
	 */
	private function s_slope($list_y, $list_x)
	{
		if (count($list_x) < 2 || count($list_y) < 2 || count($list_x) != count($list_y))
		{
			return false;
		}
		$count = count($list_x);
		for ($i = 0; $i < $count; $i++)
		{
			$x = $list_x[$i];
			$y = $list_y[$i];
			$x_sum += $x;
			$y_sum += $y;
			$xx_sum += $x * $x;
			$xy_sum += $x * $y;
		}
		$a = ($count * $xy_sum - $x_sum * $y_sum) / ($count * $xx_sum - $x_sum * $x_sum);
		$b = ($y_sum - $a * $x_sum) / $count;

		return $a;
	}

}
?>

