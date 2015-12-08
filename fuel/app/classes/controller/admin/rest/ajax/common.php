<?php

/**
 * Ajax用共通コントローラ
 */
class Controller_Admin_Rest_Ajax_Common extends Controller_Baseajax
{

	/**
	 * 住所情報を取得します
	 * @param type $zipcode
	 * @throws Exception
	 */
	public function action_get_address($zipcode = null)
	{
		try
		{
			$addressList = Model_Db_Mzipcode::find(array('select' => array('m_zipcode_code as code', 'm_zipcode_zipcode as zipcode'), 'where' => array('m_zipcode_zipcode' => $zipcode)));
			if (empty($addressList))
			{
				throw new Exception("住所情報の取得に失敗しました");
			}

			$this->response($addressList);
		}
		catch (Exception $e)
		{
			$this->error($e);
		}
	}

	/**
	 * 都道府県一覧を取得します
	 * @throws Exception
	 */
	public function action_get_pref()
	{
		try
		{
			$prefList = Model_Db_Qcommon::getPrefList();
			if (empty($prefList))
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

	/**
	 * 市区町村一覧を取得します
	 * @param type $prefCd
	 * @return type
	 */
	public function action_get_city($prefCd)
	{
		try
		{
			$cityList = Model_Db_Qcommon::getCityList($prefCd);
			if (empty($cityList))
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

	/**
	 * 町域一覧を取得します
	 * @param type $zipCd
	 * @return type
	 */
	public function action_get_town($zipCd)
	{
		try
		{
			$townList = Model_Db_Qcommon::getTownList($zipCd);
			if (empty($townList))
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

