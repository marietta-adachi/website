<?php

/**
 * 病院評価関連API
 */
class Controller_Rest_Ajax_Evaluate extends Controller_Baseajax
{

	/**
	 * 指定病院の評価を取得します
	 */
	public function action_get()
	{
		try
		{
			// バリデーションチェック
			$val = Validation::forge();
			$val->add("hospital_id", "病院ID")->add_rule("required");
			$param = $this->validate($val);

			// 取得
			$hospitalId = $param["hospital_id"];
			$evaluate = Model_Db_Qcommon::getHospitalEvaluate($param["hospital_id"]);
			if (count($evaluate) == 0)
			{
				$res["evaluate"] = array("v_hospital_evaluate_count" => 0);
				//throw new Exception("");
			}
			else
			{
				$res["evaluate"] = $evaluate[0];
			}

			$tmp = Cookie::get("evaluate_" . $hospitalId);
			$res["evaluated"] = !empty($tmp);


			$this->response($res);
		}
		catch (Exception $e)
		{
			$this->error($e);
		}
	}

	/**
	 * 
	 * @throws Exception
	 */
	public function action_regist()
	{
		try
		{
			DB::start_transaction();

			// バリデーションチェック
			$val = Validation::forge();
			$val->add("hospital_id", "病院ID")->add_rule("required");
			$val->add("evaluate_clean", "清潔感")->add_rule("required");
			$val->add("evaluate_wait", "待ち時間")->add_rule("required");
			$val->add("evaluate_total", "総合")->add_rule("required");
			$param = $this->validate($val);

			// 登録
			$hospitalId = $param["hospital_id"];
			$evaluate = Model_Db_Thospitalevaluate::forge();
			$evaluate->t_hospital_evaluate_hospital_id = $hospitalId;
			$evaluate->t_hospital_evaluate_clean = $param["evaluate_clean"];
			$evaluate->t_hospital_evaluate_wait = $param["evaluate_wait"];
			$evaluate->t_hospital_evaluate_total = $param["evaluate_total"];
			$evaluate->t_hospital_evaluate_status = EvaluateStatus::VALID;
			$evaluate->t_hospital_evaluate_created_at = Common::now();
			if ($evaluate->save() == 0)
			{
				throw new Exception("病院評価登録に失敗しました");
			}

			// ビュー更新
			DB::query("refresh materialized view v_hospital_evaluate")->execute();

			Cookie::set("evaluate_" . $hospitalId, $hospitalId, Config::get("site.expire.evaluate"));

			$this->response();
			DB::commit_transaction();
		}
		catch (Exception $e)
		{
			DB::rollback_transaction();
			$this->error($e);
		}
	}

}
?>

