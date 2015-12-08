<?php

/**
 * 管理サイト共通クエリ実行クラス
 */
class Model_Db_Qcommonadmin extends Model_Db_Qbase
{

	/**
	 * 口コミを検索します
	 * @param type $order
	 * @param type $limit
	 * @param type $offset
	 * @param type $condition
	 * @param type $countonly
	 * @return type
	 */
	public static function getReviewList($order, $limit, $offset, $condition, $countonly = false)
	{
		$p = array();

		/* SELECT */
		$sql = "select ";
		if ($countonly)
		{
			$sql .= " count(*) ";
		}
		else
		{
			$sql .= " * ";
		}

		/* FROM */
		$sql .= " from t_hospital_review thr ";
		$sql .= " inner join m_hospital mh ";
		$sql .= "	on mh.m_hospital_id = thr.t_hospital_review_hospital_id ";


		/* WHERE */
		// フリーワード
		if (!empty($condition["free_word"]))
		{
			$sql .= " and (thr.t_hospital_review_message like :free_word ";
			$sql .= " or thr.t_hospital_review_nickname like :free_word ";
			$sql .= " or mh.m_hospital_name like :free_word) ";
			$p["free_word"] = "%" . $condition["free_word"] . "%";
		}

		// ステータス
		if (!empty($condition["status"]))
		{
			$sql .= " and thr.t_hospital_review_status in (" . implode(",", $condition["status"]) . ") ";
		}

		/* ORDER BY */
		if (!$countonly && !empty($order))
		{
			$tmp = explode("-", $order);
			$sql .= " order by {$tmp[0]} {$tmp[1]}, t_hospital_review_id desc";
		}

		return self::exec($sql, $p, $limit, $offset);
	}

}

?>
