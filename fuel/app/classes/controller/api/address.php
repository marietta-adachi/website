<?php

class Controller_Api_Address extends Controller_Base_Api
{

	//use Controller_Base_Plugin_Auth;

	public function action_update()
	{
		if (!$this->verify_csrf())
		{
			return;
		}

		$val = Validation::forge();
		$val->add('name')->add_rule('required');
		$val->add('email')->add_rule('required');
		$val->add('message')->add_rule('required');
		$d = $this->verify($val);
		if (!$d)
		{
			return;
		}

		$user = Model_User::forge();
		$user->name = $d['nickname'];
		$user->email = $d['message'];
		$user->status = St::VALID;
		$user->save();
		$this->_body = $user->id;

		//DB::start_transaction();
		//DB::commit_transaction();
		//DB::rollback_transaction();
	}

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

