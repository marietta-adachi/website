<?php

class Controller_Api_Address extends Controller_Base_Api
{

	public function action_by_postcode($postcode)
	{
		$list = Model_Address::by_postcode($postcode);
		if (empty($list))
		{
			$this->error(new Exception());
		}
		$this->_body = $list;
	}

	public function action_prefs()
	{
		$this->_body = Model_Address::get_prefs();
	}

	public function action_cities($pref_id)
	{
		$this->_body = Model_Address::get_cities($pref_id);
	}

	public function action_towns($city_id)
	{
		$this->_body = Model_Address::get_towns($city_id);
	}

}
?>

