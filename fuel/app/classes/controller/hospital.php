<?php

class Controller_Hospital extends Controller_Basesite
{

    private $order = array(
	"access" => array("v_hospital_access_time_from_station_min-asc-l", "駅から近い順"),
	"evaluate" => array("v_hospital_evaluate_total-desc-l", "評価が高い順"),
	"review" => array("v_hospital_review_count-desc-l", "口コミが多い順"),
    );

    private function validateCondition($c)
    {
	$val = Validation::instance();
	//$val->add("model_id", "")->add_rule("match_pattern", "/" . implode("|", array_keys(Config::get("const.trt_model"))) . "/");
	//$val->add("serial_id", "")->add_rule("max_length", 100);
	//$val->add("order", "")->add_rule("match_pattern", "/" . implode("|", array_keys($this->order)) . "/");
	if (!$val->run($c))
	{
	    //throw new Exception("検索条件が不正です");
	}
    }

    public function action_index($get = array())
    {
	try
	{
	    // 条件取得
	    list($c, $o, $p, $param) = $this->getCondition("hospital_search", $get);
	    $c = array_merge($c, $get);
	    $this->validateCondition($c);

	    // 件数取得（病院群の中心）
	    $summarize = Model_Db_Qcommon::getHospitalList(null, null, null, $c, true);
	    $summarize = $summarize[0];
	    $c["center"] = array($summarize["lat"], $summarize["lng"]);
	    $count = $summarize["count"];

	    if ($count == 0)
	    {
		$this->customTitle = "404 - Page Not Found";
		$this->response_status = 404;
		$this->template->content = View_Smarty::forge("404");
		return;
	    }

	    // 一覧取得
	    $pageLimit = Config::get("site.page_limit.hospital");
	    $page = Page::getPage("hospital/search?{$param}", $count, $p, $pageLimit);
	    $setOrder = "";
	    if (!empty($o))
	    {
		$setOrder = $this->order[$o][0];
	    }
	    else if (!$this->isTelTime())
	    {
		//tel不可時刻でソート変更
		$setOrder = "m_hospital_type, v_hospital_evaluate_total-desc-l";
	    }
	    $list = Model_Db_Qcommon::getHospitalList($setOrder, $page->per_page, $page->offset, $c);

	    // アクセス
	    foreach ($list as &$h)
	    {
		$h["m_hospital_access"] = Model_Db_Qcommon::getHospitalAccess($h["m_hospital_id"]);
		$h["m_hospital_coordinate"] = Common::point2array($h["m_hospital_coordinate"]);

		$hospitalCourse = Model_Db_Qcommon::getHospitalCourse($h["m_hospital_id"]);
		if (empty($hospitalCourse))
		{
		    //throw new Exception("診療科目取得に失敗しました");
		    $h["m_hospital_course"] = "";
		}
		else
		{
		    $h["m_hospital_course"] = implode("／", array_column($hospitalCourse, "m_course_name"));
		}

		//
		$h["features_list"] = Model_Db_Qcommon::getHospitalFeaturesList($h["m_hospital_id"]);
	    }

	    // 検索結果設定
	    $data = $c;
	    $data["hospital_list"] = $list;
	    $data["page_limit"] = $pageLimit;
	    $data["count_from"] = (($p - 1) * $pageLimit) + 1;
	    $data["count_to"] = min($p * $pageLimit, $count);
	    $data["count_all"] = $count;
	    $data["order_list"] = $this->order;
	    $data["selected_order"] = $o;

	    // 最近見た病院
	    $data["recently_hospital_list"] = $this->getRecentlyHospital();

	    // 診療科目一覧設定
	    $data["course_list"] = Model_Db_Qcommon::getCourceList();

	    // こだわり設定
	    $data["features_common_list"] = Model_Db_Qcommon::getFeaturesList(FeaturesType::COMMON);

	    // 電話可能時間帯
	    $data["tel_time"] = $this->isTelTime();

	    // 場所検索情報設定
	    $this->setArea($data);
	    $this->setRegion($data);
	    $this->setRailway($data);

	    //オプション用のURLを作成
	    $data["option_url"] = $this->setOptionUrl();

	    // TDHK設定
	    $this->setListTdhk($data);

	    //フッタ用リンク作成
	    $data["footer_url"] = $this->setFooterUrl($data);

	    $this->template->content = View_Smarty::forge("hospital", $data)->set_safe("pagination", $page->render());
	}
	catch (Exception $e)
	{
	    $this->error($e);
	}
    }


}
