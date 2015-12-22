<?php

class Controller_Api_Railway extends Controller_Base_Api
{

	public function action_get_pref()
	{
		try
		{
			$prefList = Model_Mprefecture::find_all();
			if (count($prefList) == 0)
			{
				throw new Exception("都道府県一覧取得に失敗しました");
			}

			$this->response($prefList);
		}
		catch (Exception $e)
		{
			$this->error($e);
		}
	}

	public function action_get_railway($prefCd)
	{
		try
		{
			$sql = "select"
					. "	mr.m_railway_code"
					. "	, mr.m_railway_name "
					. "from"
					. "	m_station ms "
					. "	inner join m_railway mr "
					. "		on mr.m_railway_code = ms.m_station_railway_code "
					. "where"
					. "	to_char(ms.m_station_pref_code, 'FM00') = :pref_code "
					. "group by"
					. "	mr.m_railway_code"
					. "	, mr.m_railway_name "
					. "order by"
					. "	mr.m_railway_name";

			$railwayList = DB::query($sql)->parameters(array("pref_code" => $prefCd))->execute()->as_array();
			if (count($railwayList) == 0)
			{
				throw new Exception("路線一覧取得に失敗しました");
			}

			$this->response($railwayList);
		}
		catch (Exception $e)
		{
			$this->error($e);
		}
	}

	public function action_get_station($railwayCd)
	{
		try
		{
			$sql = "select"
					. "	* "
					. "from"
					. "	m_station ms "
					. "where"
					. "	ms.m_station_railway_code = :railway_code "
					. "order by"
					. "	ms.m_station_name";

			$stationList = DB::query($sql)->parameters(array("railway_code" => $railwayCd))->execute()->as_array();
			if (count($stationList) == 0)
			{
				throw new Exception("駅一覧取得に失敗しました");
			}

			$this->response($stationList);
		}
		catch (Exception $e)
		{
			$this->error($e);
		}
	}

	public function action_get_suggest_station($free_word)
	{
		try
		{
			$sql = "select case when m_station_name in (select m_station_name from (
						select m_station_name
						from m_station ms left join m_prefecture mp on ms.m_station_pref_code = mp.m_prefecture_code 
						where ms.m_station_name like :m_station_name 
						group by m_station_name, m_station_pref_code) as wk
						group by m_station_name
						having count(*) > 1)
						then m_station_name ||'駅('||m_prefecture_name||')' 
						else m_station_name ||'駅' 
						end as value
						from m_station ms left join m_prefecture mp on ms.m_station_pref_code = mp.m_prefecture_code 
						where ms.m_station_name like :m_station_name||'%' 
						group by m_station_name, m_station_pref_code, mp.m_prefecture_name
			 			order by m_station_name";

			$stationList = DB::query($sql)->parameters(array("m_station_name" => $free_word . "%"))->execute()->as_array();

			$this->response($stationList);
		}
		catch (Exception $e)
		{
			$this->error($e);
		}
	}

}
?>

