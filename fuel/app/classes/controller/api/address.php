<?php

class Controller_Api_Address extends Controller_Base_Api
{

	public function action_get_address($zipcode = null)
	{
		$list = Model_Db_Address::by_zip($zipcode);
		if (empty($list))
		{
			$this->error(new Exception());
		}
		$this->response($list);
	}

	public function action_prefs()
	{
		//$list = Model_Db_Address::get_prefs();
		$list = ["北海道", "青森", "岩手", "秋田",];
		if (empty($list))
		{
			$this->error(new Exception());
		}
		$this->response($list);
	}

	public function action_cities($pref_code)
	{
		//$list = Model_Db_Address::get_cities($pref_code);
		$list = ["川越市", "富士見市", "台東区", "墨田区",];
		if (empty($list))
		{
			$this->error(new Exception());
		}
		$this->response($list);
	}

	public function action_towns($city_code)
	{
		//$list = Model_Db_Address::get_towns($city_code);
		$list = ["笠幡", "ふじみ野東", "浅草橋",];
		if (empty($list))
		{
			$this->error(new Exception());
		}
		$this->response($list);
	}

}
?>

