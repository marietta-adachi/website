<?php

/**
 * 予約関連API
 */
class Controller_Rest_Ajax_Reservation extends Controller_Baseajax
{

	public function action_get_timetable()
	{
		try
		{
			// バリデーションチェック
			$val = Validation::forge();
			$val->add("hospital_id", "病院ID")->add_rule("required");
			$val->add("start_time", "開始日時");
			$val->add("days", "表示期間日数");
			$param = $this->validate($val);

			$days = empty($param["days"]) ? 7 : intval($param["days"]);


			// 厚生局ID取得
			$hospitalId = $param["hospital_id"];
			$hospital = Model_Db_Mhospital::find_by_pk($hospitalId);
			if (empty($hospital))
			{
				throw new Exception("");
			}

			if(empty($param["start_time"])){
				$startTime = strtotime(Common::now());
				if(date("G") < 7 || date("G") > 20){
					$startTime = $startTime + 86400;
				}
			}else{
				$startTime = intval($param["start_time"]);
			}

			// $startTime = empty($param["start_time"]) ? strtotime(Common::now()) : intval($param["start_time"]);

			// BOOKサーバよりタイムテーブルを取得
			$curl = Request::forge(Config::get("host.book") . "/api/schedule/doctors.json", "curl");
			$p["pid"] = $hospital->m_hospital_public_id; //130283036
			$p["ts"] = $startTime;
			$curl->set_params($p);
			$curl->set_method("get");
			$curl->set_option(CURLOPT_SSL_VERIFYPEER, false);
			$curl->set_option(CURLOPT_SSL_VERIFYHOST, false);
			Log::info("url：" . Config::get("host.book") . "/api/schedule/doctors.json");
			Log::info("pid：" . $p["pid"]);
			Log::info("ts：" . $p["ts"]);
			$response = $curl->execute()->response();
			if (substr($response->status, 0, 1) != 2)
			{
				throw new Exception("診療時間取得に失敗しました（" . $response->status . "）");
			}
			else if ($response->status == 204)
			{
				$this->response();
				return;
			}
			$body = $response->body();

			// 有効なタイムテーブルを取得
			$doctors = array();
			foreach ($body as $d)
			{
				if (array_key_exists("id", $d))
				{
					$doctors[] = $d;
				}
			}

			$res = null;
			if (count($doctors) > 0)
			{
				$week = array("日", "月", "火", "水", "木", "金", "土");
				$table = array();
				$availables = array_column($doctors, "available");
				foreach ($availables as $available)
				{
					/* 7日分のタイムテーブルを作成 */
					$d = 0;
					foreach ($available as $k => $v)
					{
						$date = date("Y-m-d", $k);
						$date2 = ($date == date("Y-m-d")) ? "本日" : date("n/j", $k) . "（" . $week[date("w", $k)] . "）";
						if (count($v) > 0)
						{
							foreach ($v as $h => $ms)
							{
								foreach ($ms as $m => $flag)
								{
									$m = str_pad($m, 2, "0", STR_PAD_LEFT);
									$table[$date2]["{$h}:{$m}"] = Uri::create("reservation/edit/{$hospitalId}/" . urlencode("{$date} {$h}:{$m}:00"));
								}
							}
						}
						else
						{
							if (!isset($table[$date2]))
							{
								$table[$date2] = null; // 電話問い合わせ
							}
						}
						$d++;
						if ($d == $days)
						{
							break;
						}
					}
				}


				$res["timetable"] = $table;

				/* 翌週／前週分の開始時間を設定 */
				$startDate = strtotime(date("Y-m-d", $startTime));
				$nextTime = strtotime("+{$days} day", $startDate);
				$prevTime = strtotime("-{$days} day", $startDate);
				$nowTime = strtotime(Common::now());
				if ($prevTime <= $nowTime)
				{
					// 過去分は表示させない
					$prevTime = $nowTime;
				}
				if ($startDate == strtotime(Common::today()))
				{
					// 1日目が本日の場合は前週リンク非表示に
					$prevTime = null;
				}
				$res["prev_time"] = $prevTime;
				$res["next_time"] = $nextTime;
			}

			$this->response($res);
		}
		catch (Exception $e)
		{
			$this->error($e);
		}
	}

}
