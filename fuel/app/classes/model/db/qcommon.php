<?php

class Model_Db_Qcommon extends Model_Db_Qbase
{

    public static function getHospitalList($order, $limit, $offset, $condition, $countonly = false)
    {
	$locationSearch = self::isLocationSearch($condition);

	/*	 * **********************************
	 * SELECT
	 * ****************************************** */
	$p = array();
	$sql = "select ";
	if ($countonly)
	{
	    $sql .= " count(mh.m_hospital_id) as count "
		    ."	,avg(m_hospital_coordinate[0]) as lat "
		    ."	,avg(m_hospital_coordinate[1]) as lng ";
	}
	else
	{
	    $ppcSufix = self::getPpcSufix(@$condition["hsp"]);
	    $sql .= "	mh.m_hospital_id "
		    ."	,mh.m_hospital_tel_free "
		    ."	,mh.m_hospital_tel_ppc || '{$ppcSufix}' as m_hospital_tel_ppc "
		    ."	,mh.m_hospital_type "
		    ."	,mh.m_hospital_zipcode "
		    ."	,mh.m_hospital_address_1 "
		    ."	,mh.m_hospital_address_2 "
		    ."	,mh.m_hospital_coordinate "
		    ."	,mh.m_hospital_features "
		    ."	,mh.m_hospital_url "
		    ."	,mh.m_hospital_epark_reservation_url "
		    ."	,mh.m_hospital_medical "
		    ."	,mh.m_hospital_status "
		    ."	,mhc.m_hospital_comment_detail "
		    ."	,mhc.m_hospital_comment_title "
		    ."	,mhi.m_hospital_image_1_thumbnail "
		    ."	,vhe.* "
		    ."	,vhr.* "
		    ."	,mht.* "
		    ." ,(select string_agg(m_features_item_display, '、') from t_hospital_features_relation thfr inner join m_features mf on mf.m_features_id = thfr.t_hospital_features_relation_features_id and mf.m_features_item_display <> '-' where thfr.t_hospital_features_relation_hospital_id = mh.m_hospital_id) as m_hospital_features "
	    ;
	    if ($locationSearch)
	    {
		$sql .= " ,point('".$condition["center"][0]."','".$condition["center"][1]."') <-> mh.m_hospital_coordinate as distance ";
	    }
	}

	/*	 * **********************************
	 * FROM
	 * ****************************************** */
	$sql .= " from m_hospital mh ";

	// 住所検索用ビュー
	if (!empty($condition["town_code"]) ||
		!empty($condition["city_code"]) ||
		!empty($condition["pref_code_region"]) ||
		!empty($condition["area_id"]) ||
		!empty($condition["pref_code_area"]))
	{
	    $sql .= " inner join m_address ma ";
	    $sql .= "	on ma.m_address_code = mh.m_hospital_address_code ";
	}

	// コメントテーブル
	$sql .= " left join m_hospital_comment mhc ";
	$sql .= "	on mhc.m_hospital_comment_hospital_id = mh.m_hospital_id ";

	// 院長テーブル
	$sql .= " left join m_hospital_director mhd ";
	$sql .= "	on mhd.m_hospital_director_hospital_id = mh.m_hospital_id ";

	// 病院画像テーブル
	$sql .= " left join m_hospital_image mhi ";
	$sql .= "	on mhi.m_hospital_image_hospital_id = mh.m_hospital_id ";

	// 診療時間テーブル
	$sql .= " inner join m_hospital_timetable mht ";
	$sql .= "	on mht.m_hospital_timetable_hospital_id = mh.m_hospital_id ";

	// フリーワード検索用ビュー
	if (!empty($condition["free_word"]))
	{
	    $sql .= " inner join v_hospital vh ";
	    $sql .= "	on vh.v_hospital_id = mh.m_hospital_id ";
	}

	// 所要時間
	$sql .= " left join v_hospital_access_time_from_station vhatfs ";
	$sql .= "	on vhatfs.v_hospital_access_time_from_station_hospital_id = mh.m_hospital_id ";

	// 評価
	$sql .= " left join v_hospital_evaluate vhe ";
	$sql .= "	on vhe.v_hospital_evaluate_hospital_id = mh.m_hospital_id ";

	// 口コミ
	$sql .= " left join v_hospital_review vhr ";
	$sql .= "	on vhr.v_hospital_review_hospital_id = mh.m_hospital_id ";



	/*	 * **********************************
	 * WHERE
	 * ****************************************** */
	$sql .= " where mh.m_hospital_status = ".HospitalStatus::VALID." ";

	// 診療科目
	if (!empty($condition["course_id"]))
	{
	    $sql.= " and exists(select * from t_hospital_course_relation thcr where thcr.t_hospital_course_relation_hospital_id = mh.m_hospital_id and thcr.t_hospital_course_relation_course_id = :course_id) ";
	    $p["course_id"] = intval($condition["course_id"]);
	}

	// フリーワード
	if (!empty($condition["free_word"]))
	{
	    $word = $condition["free_word"];
	    $word = str_replace("　", " ", $word);
	    $word = explode(" ", $word);
	    $i = 0;
	    foreach ($word as $w)
	    {
		$i++;
		if (strpos($w, '駅') !== false)
		{
		    $sql .= " and vh.v_hospital_text like :free_word{$i} ";
		    $p["free_word{$i}"] = "%[".$w."%";
		}
		else
		{
		    $sql .= " and vh.v_hospital_text like :free_word{$i} ";
		    $p["free_word{$i}"] = "%".$w."%";
		}
	    }
	}

	// 曜日
	if (!empty($condition["visit_days"]))
	{
	    $tmp = Config::get("site.const.visit_days");
	    $sql .= " and(false ";
	    foreach ($condition["visit_days"] as $id)
	    {
		$sql .= " or mht.m_hospital_timetable_{$tmp[$id][0]} = true ";
	    }
	    $sql .= " ) ";
	}

	// 診療時間
	if (!empty($condition["visit_time"]))
	{
	    $tmp = Config::get("site.const.visit_time");
	    $sql .= " and(false ";
	    foreach ($condition["visit_time"] as $id)
	    {
		$sql .= " or mht.m_hospital_timetable_{$tmp[$id][0]} = true ";
	    }
	    $sql .= " ) ";
	}

	// こだわり
	if (!empty($condition["features"]))
	{
	    $tmp = array();
	    foreach ($condition["features"] as $v)
	    {
		$tmp[] = "'{$v}'";
	    }
	    $tmp = implode(",", $tmp);
	    $sql.= " and exists(select * from t_hospital_features_relation thfr where thfr.t_hospital_features_relation_hospital_id = mh.m_hospital_id and t_hospital_features_relation_features_id in({$tmp})) ";
	}

	// 予約可能日
	if (!empty($condition["reservable"]))
	{
	    $sql .= " and(false ";
	    foreach ($condition["reservable"] as $id)
	    {
		if ($id == 1)
		{
		    $sql .= " or mht.m_hospital_timetable_reservable_time_today >= '".date("H:i:s")."'";
		}
		else if ($id == 2)
		{
		    $sql .= " or mht.m_hospital_timetable_reservable_time_tomorrow is not null ";
		}
	    }
	    $sql .= " ) ";
	}

	// 住所
	if (!empty($condition["town_code"]))
	{
	    $sql.= " and ma.m_address_town_code = :town_code ";
	    $p["town_code"] = $condition["town_code"];
	}
	else if (!empty($condition["city_code"]))
	{
	    $sql.= " and ma.m_address_city_code = :city_code ";
	    $p["city_code"] = $condition["city_code"];
	}
	else if (!empty($condition["pref_code_region"]))
	{
	    $sql.= " and ma.m_address_pref_code = :pref_code_region ";
	    $p["pref_code_region"] = $condition["pref_code_region"];
	}

	// 路線
	if (!empty($condition["station_code"]))
	{
	    //$sql.= " and exists(select * from v_hospital_access vha where vha.v_hospital_access_hospital_id = mh.m_hospital_id and vha.v_hospital_access_station_gcode = (select distinct m_station_group_code from m_station ms where m_station_code = :station_code)) ";
	    //$p["station_code"] = $condition["station_code"];
	    // 駅のジオコード取得
	    $sqlSub = "select ms.m_station_lat, ms.m_station_lon from m_station ms where ms.m_station_code in :station_code ";
	    $geo = self::exec($sqlSub, array("station_code" => $condition["station_code"]), null, null, true);

	    $i = 0;
	    $m = 0.000008987690934843258;
	    $sql.= "  and ( false ";
	    foreach ($geo as $geoval)
	    {
		// 検索範囲算出（首都圏（東京駅から半径100km）か否か）
		$res = Model_Db_Qbase::exec("select point({$geoval["m_station_lat"]},{$geoval["m_station_lon"]}) @ circle(point(35.6813818,139.7660838),0.8987690934843258) as in");
		$radius = intval($res[0]["in"]) ? 1500 : 2500;

		// 駅範囲内の病院を検索
		$sql.= " or mh.m_hospital_coordinate @ circle(point(:lat{$i},:lon{$i}),:radius{$i}) ";
		$p["lat{$i}"] = $geoval["m_station_lat"];
		$p["lon{$i}"] = $geoval["m_station_lon"];
		$p["radius{$i}"] = $m * $radius;
		$i++;
	    }
	    $sql.= "  )";
	}
	else if (!empty($condition["railway_code"]))
	{
	    $sql.= " and exists(select * from v_hospital_access vha where vha.v_hospital_access_hospital_id = mh.m_hospital_id and vha.v_hospital_access_railway_code = :railway_code) ";
	    $p["railway_code"] = $condition["railway_code"];
	}
	else if (!empty($condition["pref_code_railway"]))
	{
	    $sql.= " and exists(select * from v_hospital_access vha where vha.v_hospital_access_hospital_id = mh.m_hospital_id and vha.v_hospital_access_pref_code = :pref_code_railway) ";
	    $p["pref_code_railway"] = $condition["pref_code_railway"];
	}

	// エリア
	if (!empty($condition["area_id"]))
	{
	    $sql.= " and exists (select * from m_area_city_relation macr where macr.m_area_city_relation_area_id = :area_id and macr.m_area_city_relation_city_code = ma.m_address_city_code) ";
	    $p["area_id"] = $condition["area_id"];
	}
	else if (!empty($condition["pref_code_area"]))
	{
	    $sql.= " and exists (select * from m_area_city_relation macr inner join m_area mar on mar.m_area_id = macr.m_area_city_relation_area_id and mar.m_area_prefecture_code = :pref_code_area where macr.m_area_city_relation_city_code = ma.m_address_city_code) ";
	    $p["pref_code_area"] = $condition["pref_code_area"];
	}

	// 現在地
	if (!empty($condition["area"]))
	{
	    $sql.= " and m_hospital_coordinate @ circle(point(:lat,:lon),:radius) ";

	    // 中心
	    $area = explode(",", $condition["area"]);
	    $p["lat"] = $area[0];
	    $p["lon"] = $area[1];

	    // 半径
	    $condition["radius"] = empty($condition["radius"]) ? 500 : $condition["radius"];
	    $m = 0.000008987690934843258;
	    $radius = $m * $condition["radius"];
	    $p["radius"] = $radius;
	}

	// 地図検索
	//$condition["bounds"] = "35.71573061493593,139.6726752954712,35.74360091286235,139.74348561346437";
	if (!empty($condition["bounds"]))
	{
	    $sql.= " and m_hospital_coordinate @ box(point (:lat1,:lon1), point (:lat2,:lon2)) ";
	    $tmp = explode(",", $condition["bounds"]);
	    $p["lat1"] = $tmp[0];
	    $p["lon1"] = $tmp[1];
	    $p["lat2"] = $tmp[2];
	    $p["lon2"] = $tmp[3];
	}

	// テスト病院は表示させない
	$testIds = Config::get("site.const.test_hospital_ids");
	$testIds = implode(",", $testIds);
	$sql .= " and mh.m_hospital_id not in ({$testIds}) ";

	/*	 * **********************************
	 * ORDER BY
	 * ****************************************** */
	if (!$countonly)
	{
	    $sub = "";
	    if (!empty($order))
	    {
		$tmp = explode("-", $order);
		$nulls = ($tmp[2] == "l") ? "nulls last" : "nulls first";
		$sub = "{$tmp[0]} {$tmp[1]} {$nulls},";
	    }

	    $sql .= " order by m_hospital_order, {$sub}  ";
	    $sql .= $locationSearch ? "distance " : "m_hospital_name ";
	}

	return self::exec($sql, $p, $limit, $offset);
    }

    public static function getHospital($hospitalId, $hsp = "")
    {
	$ppcSufix = self::getPpcSufix($hsp);

	/*	 * **********************************
	 * SELECT
	 * ****************************************** */
	$sql = "select";
	$sql .= " * ";
	$sql .= " ,mh.m_hospital_tel_ppc || '{$ppcSufix}' as m_hospital_tel_ppc_full ";
	$sql .= " ,(select string_agg(m_course_name, '／') from t_hospital_course_relation thcr left join m_course mc on mc.m_course_id = thcr.t_hospital_course_relation_course_id where thcr.t_hospital_course_relation_hospital_id = mh.m_hospital_id) as m_hospital_course ";
	$sql .= " ,(select string_agg(m_features_item_display, chr(10)) from t_hospital_features_relation thfr inner join m_features mf on mf.m_features_id = thfr.t_hospital_features_relation_features_id and mf.m_features_item_display <> '-' where thfr.t_hospital_features_relation_hospital_id = mh.m_hospital_id) as m_hospital_features ";
	$sql .= " ,(select count(*) from t_hospital_course_relation thcr where thcr.t_hospital_course_relation_hospital_id = mh.m_hospital_id and thcr.t_hospital_course_relation_course_id in(42,43,44,45)) as dentistry ";
	$sql .= "	, case "
		."		when mht.m_hospital_timetable_mon_time_1_from is null "
		."		and mht.m_hospital_timetable_tue_time_1_from is null "
		."		and mht.m_hospital_timetable_wed_time_1_from is null "
		."		and mht.m_hospital_timetable_thu_time_1_from is null "
		."		and mht.m_hospital_timetable_fri_time_1_from is null "
		."		and mht.m_hospital_timetable_sat_time_1_from is null "
		."		and mht.m_hospital_timetable_sun_time_1_from is null "
		."		and mht.m_hospital_timetable_hol_time_1_from is null "
		."		then false "
		."		else true "
		."		end as exists_time_1"
		."	, case "
		."		when mht.m_hospital_timetable_mon_time_2_from is null "
		."		and mht.m_hospital_timetable_tue_time_2_from is null "
		."		and mht.m_hospital_timetable_wed_time_2_from is null "
		."		and mht.m_hospital_timetable_thu_time_2_from is null "
		."		and mht.m_hospital_timetable_fri_time_2_from is null "
		."		and mht.m_hospital_timetable_sat_time_2_from is null "
		."		and mht.m_hospital_timetable_sun_time_2_from is null "
		."		and mht.m_hospital_timetable_hol_time_2_from is null "
		."		then false "
		."		else true "
		."		end as exists_time_2"
		."	, case "
		."		when mht.m_hospital_timetable_mon_time_3_from is null "
		."		and mht.m_hospital_timetable_tue_time_3_from is null "
		."		and mht.m_hospital_timetable_wed_time_3_from is null "
		."		and mht.m_hospital_timetable_thu_time_3_from is null "
		."		and mht.m_hospital_timetable_fri_time_3_from is null "
		."		and mht.m_hospital_timetable_sat_time_3_from is null "
		."		and mht.m_hospital_timetable_sun_time_3_from is null "
		."		and mht.m_hospital_timetable_hol_time_3_from is null "
		."		then false "
		."		else true "
		."		end as exists_time_3";

	/*	 * **********************************
	 * FROM
	 * ****************************************** */
	$sql .= " from m_hospital mh ";
	// 院長テーブル
	$sql .= " left join m_hospital_comment mhc ";
	$sql .= "	on mhc.m_hospital_comment_hospital_id = mh.m_hospital_id ";
	// 院長テーブル
	$sql .= " left join m_hospital_director mhd ";
	$sql .= "	on mhd.m_hospital_director_hospital_id = mh.m_hospital_id ";
	// 病院画像テーブル
	$sql .= " left join m_hospital_image mhi ";
	$sql .= "	on mhi.m_hospital_image_hospital_id = mh.m_hospital_id ";
	// 診療時間テーブル
	$sql .= " inner join m_hospital_timetable mht ";
	$sql .= "	on mht.m_hospital_timetable_hospital_id = mh.m_hospital_id ";
	// 住所マスタ
	$sql .= " left join m_address ma ";
	$sql .= "	on ma.m_address_code = mh.m_hospital_address_code ";

	/*	 * **********************************
	 * WHERE
	 * ****************************************** */
	$sql .= "where mh.m_hospital_id = :hospital_id ";
	$sql .= "	and mh.m_hospital_status in(".HospitalStatus::VALID.",".HospitalStatus::CLINIC.") ";

	$p["hospital_id"] = $hospitalId;
	//$p["status"] = HospitalStatus::VALID;
	return self::exec($sql, $p, null, null, true);
    }

    // <editor-fold defaultstate="collapsed" desc="住所系">
    /**
     * 都道府県一覧を取得します
     * @return type
     */
    public static function getPrefList_()
    {
	$sql = "select"
		."	substring(m_zipcode_code, 1, 2) as cd"
		."	, m_zipcode_pref as name "
		."from"
		."	m_zipcode "
		."group by"
		."	name"
		."	, cd "
		."order by"
		."	cd";

	return self::exec($sql);
    }

    /**
     * 市区町村一覧を取得します
     * @return type
     */
    public static function getCityList_($prefCd)
    {
	$sql = "select"
		."	substring(m_zipcode_code, 3, 3) as cd"
		."	, m_zipcode_city as name"
		."	, m_zipcode_city_kana as name_kana "
		."from"
		."	m_zipcode "
		."where"
		."	substring(m_zipcode_code, 1, 2) = :pref_cd "
		."group by"
		."	cd"
		."	, name"
		."	, name_kana "
		."order by"
		."	name_kana";

	$p["pref_cd"] = $prefCd;
	return self::exec($sql, $p);
    }

    /**
     * 町域一覧を取得します
     * @return type
     */
    public static function getTownList_($zipCd)
    {
	$sql = "select"
		."	m_zipcode_zipcode as cd"
		."	, m_zipcode_town as name"
		."	, m_zipcode_town_kana as name_kana "
		."from"
		."	m_zipcode "
		."where"
		."	m_zipcode_code = :zipcode "
		."	and substring(m_zipcode_zipcode, 6, 2) <> '00' "
		."order by"
		."	name_kana";

	$p["zipcode"] = $zipCd;
	return self::exec($sql, $p);
    }

    // </editor-fold>
}

?>
