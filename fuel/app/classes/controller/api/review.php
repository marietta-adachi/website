<?php

class Controller_Api_Review extends Controller_Base_Api
{

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
			$reviewList = Model_Db_Qcommon::getHospitalReviewList($hospitalId);

			$tmp = Cookie::get("review_" . $hospitalId);
			$res["reviewed"] = !empty($tmp);
			$res["review"] = $reviewList;
			$this->response($res);
		}
		catch (Exception $e)
		{
			$this->error($e);
		}
	}

	public function action_regist()
	{
		try
		{
			DB::start_transaction();
			//$this->checkCsrf();
			// バリデーションチェック
			$val = Validation::forge();
			$val->add("hospital_id", "病院ID")->add_rule("required");
			$val->add("nickname", "清潔感")->add_rule("required");
			$val->add("message", "内容")->add_rule("required");
			$param = $this->validate($val);

			$hospitalId = $param["hospital_id"];

			// 登録
			$review = Model_Db_Thospitalreview::forge();
			$review->t_hospital_review_hospital_id = $hospitalId;
			$review->t_hospital_review_nickname = $param["nickname"];
			$review->t_hospital_review_message = $param["message"];
			$review->t_hospital_review_status = ReviewStatus::CLOSED;
			$review->t_hospital_review_created_at = Common::now();
			if ($review->save() == 0)
			{
				throw new Exception("病院評価登録に失敗しました");
			}

			DB::query("refresh materialized view v_hospital_review")->execute();

			Cookie::set("review_" . $hospitalId, $hospitalId, Config::get("site.expire.review"));

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

