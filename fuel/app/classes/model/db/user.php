<?php

class Model_Db_User extends Model_Db_Base
{

	// table
	protected static $_table_name = 'user';
	// columns
	protected static $_user_id = 'user_id';
	protected static $_user_name = 'user_name';
	protected static $_user_email = 'user_email';
	protected static $_user_password = 'user_password';
	protected static $_user_status = 'user_status';
	protected static $_user_created_at = 'user_created_at';
	protected static $_user_updated_at = 'user_updated_at';
	protected static $_user_deleted_at = 'user_deleted_at';
	// key
	protected static $_primary_key = 'user_id';

	public static function bySession()
	{
		$bean = Session::get('user');
		return $bean;
	}

	public static function byId($id)
	{
		parent::find_by_pk($id);
	}

	public static function anew()
	{
		$row = parent::forge();
		$row->user_created_at = Common::now(); // TODO
		return $row;
	}

	public function del_logical()
	{
		$row = parent::forge();
		$row->user_created_at = $now; // TODO
		return $row;
	}

	public static function byCustom($id = null)
	{
		$tmp = self::exec('select user_email from user where false', null, null, null, get_called_class());
		return $tmp;
	}

	public function get_email()
	{
		return $this->user_email;
	}

	public static function get_hospital_list($order, $limit, $offset, $c, $countonly = false)
	{
		$locationSearch = self::isLocationSearch($c);

		/*		 * **********************************
		 * SELECT
		 * ****************************************** */
		$p = array();
		$sql = "select ";
		if ($countonly)
		{
			$sql .= " count(mh.m_hospital_id) as count ";
		}
		else
		{
			$sql .= "	mh.m_hospital_id "
					. "	,mh.m_hospital_tel_free "
					. "	,mh.m_hospital_status "
					. "	,mhc.m_hospital_comment_detail "
					. "	,mhc.m_hospital_comment_title "
					. "	,mhi.m_hospital_image_1_thumbnail "
					. "	,vhe.* "
					. "	,vhr.* "
					. "	,mht.* "
					. " ,(select string_agg(m_features_item_display, '、') from t_hospital_features_relation thfr inner join m_features mf on mf.m_features_id = thfr.t_hospital_features_relation_features_id and mf.m_features_item_display <> '-' where thfr.t_hospital_features_relation_hospital_id = mh.m_hospital_id) as m_hospital_features "
			;
			if ($locationSearch)
			{
				$sql .= " ,point('" . $c["center"][0] . "','" . $c["center"][1] . "') <-> mh.m_hospital_coordinate as distance ";
			}
		}

		/*		 * **********************************
		 * FROM
		 * ****************************************** */
		$sql .= " from m_hospital mh ";
		$sql .= " left join m_hospital_comment mhc ";
		$sql .= "	on mhc.m_hospital_comment_hospital_id = mh.m_hospital_id ";
		$sql .= " left join m_hospital_director mhd ";
		$sql .= "	on mhd.m_hospital_director_hospital_id = mh.m_hospital_id ";


		/*		 * **********************************
		 * WHERE
		 * ****************************************** */
		$sql .= " where mh.m_hospital_status = " . HospitalStatus::VALID . " ";

		// 診療科目
		if (!empty($c["course_id"]))
		{
			$sql.= " and exists(select * from t_hospital_course_relation thcr where thcr.t_hospital_course_relation_hospital_id = mh.m_hospital_id and thcr.t_hospital_course_relation_course_id = :course_id) ";
			$p["course_id"] = intval($c["course_id"]);
		}


		// 曜日
		if (!empty($c["visit_days"]))
		{
			$tmp = Config::get("site.const.visit_days");
			$sql .= " and(false ";
			foreach ($c["visit_days"] as $id)
			{
				$sql .= " or mht.m_hospital_timetable_{$tmp[$id][0]} = true ";
			}
			$sql .= " ) ";
		}

		/*		 * **********************************
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

		/*		 * **********************************
		 * SELECT
		 * ****************************************** */
		$sql = "select";
		$sql .= " * ";
		$sql .= " ,mh.m_hospital_tel_ppc || '{$ppcSufix}' as m_hospital_tel_ppc_full ";
		$sql .= " ,(select string_agg(m_course_name, '／') from t_hospital_course_relation thcr left join m_course mc on mc.m_course_id = thcr.t_hospital_course_relation_course_id where thcr.t_hospital_course_relation_hospital_id = mh.m_hospital_id) as m_hospital_course ";
		$sql .= " ,(select string_agg(m_features_item_display, chr(10)) from t_hospital_features_relation thfr inner join m_features mf on mf.m_features_id = thfr.t_hospital_features_relation_features_id and mf.m_features_item_display <> '-' where thfr.t_hospital_features_relation_hospital_id = mh.m_hospital_id) as m_hospital_features ";
		$sql .= " ,(select count(*) from t_hospital_course_relation thcr where thcr.t_hospital_course_relation_hospital_id = mh.m_hospital_id and thcr.t_hospital_course_relation_course_id in(42,43,44,45)) as dentistry ";

		/*		 * **********************************
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

		/*		 * **********************************
		 * WHERE
		 * ****************************************** */
		$sql .= "where mh.m_hospital_id = :hospital_id ";
		$sql .= "	and mh.m_hospital_status in(" . HospitalStatus::VALID . "," . HospitalStatus::CLINIC . ") ";

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
				. "	substring(m_zipcode_code, 1, 2) as cd"
				. "	, m_zipcode_pref as name "
				. "from"
				. "	m_zipcode "
				. "group by"
				. "	name"
				. "	, cd "
				. "order by"
				. "	cd";

		return self::exec($sql);
	}

	/**
	 * 市区町村一覧を取得します
	 * @return type
	 */
	public static function getCityList_($prefCd)
	{
		$sql = "select"
				. "	substring(m_zipcode_code, 3, 3) as cd"
				. "	, m_zipcode_city as name"
				. "	, m_zipcode_city_kana as name_kana "
				. "from"
				. "	m_zipcode "
				. "where"
				. "	substring(m_zipcode_code, 1, 2) = :pref_cd "
				. "group by"
				. "	cd"
				. "	, name"
				. "	, name_kana "
				. "order by"
				. "	name_kana";

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
				. "	m_zipcode_zipcode as cd"
				. "	, m_zipcode_town as name"
				. "	, m_zipcode_town_kana as name_kana "
				. "from"
				. "	m_zipcode "
				. "where"
				. "	m_zipcode_code = :zipcode "
				. "	and substring(m_zipcode_zipcode, 6, 2) <> '00' "
				. "order by"
				. "	name_kana";

		$p["zipcode"] = $zipCd;
		return self::exec($sql, $p);
	}

	// </editor-fold>
}
