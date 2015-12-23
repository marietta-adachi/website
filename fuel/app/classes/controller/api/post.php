<?php

class Controller_Api_Review extends Controller_Base_Api
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

}
