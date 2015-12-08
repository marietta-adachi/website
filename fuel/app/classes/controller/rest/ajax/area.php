<?php

/**
 * 
 */
class Controller_Rest_Ajax_Area extends Controller_Baseajax
{

	public function action_get_pref()
	{
		try
		{
			$prefList = Model_Db_Mprefecture::find_all();
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

	public function action_get_city($prefCd)
	{
		try
		{
			$sql = "select mz.m_zipcode_code, mz.m_zipcode_city from m_zipcode mz where left(mz.m_zipcode_code, 2) = :pref_code group by mz.m_zipcode_code, mz.m_zipcode_city";
			$cityList = DB::query($sql)->parameters(array("pref_code" => $prefCd))->execute()->as_array();
			if (count($cityList) == 0)
			{
				throw new Exception("市区町村一覧取得に失敗しました");
			}

			$this->response($cityList);
		}
		catch (Exception $e)
		{
			$this->error($e);
		}
	}

	public function action_get_town($cityCd)
	{
		try
		{
			$sql = "select mz.m_zipcode_zipcode, mz.m_zipcode_town from m_zipcode mz where mz.m_zipcode_code = :city_code";
			$townList = DB::query($sql)->parameters(array("city_code" => $cityCd))->execute()->as_array();
			if (count($townList) == 0)
			{
				throw new Exception("町域一覧取得に失敗しました");
			}

			$this->response($townList);
		}
		catch (Exception $e)
		{
			$this->error($e);
		}
	}

}
?>

