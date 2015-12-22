<?php

class Controller_User extends Controller_Base_Site
{

	public function action_index()
	{

		$res = Model_User::byCustom();

//throw new \HttpServerErrorException();
		$d['user_list'] =$res;
		$this->template->content = View_Smarty::forge('user', $d);
	}

	public function action_do()
	{

		if (!$this->check())
		{
			$this->set_error(['email' => 'xxx']);
		}
		
		if ($this->transaction('tran'))
		{
			$this->action_edit();
			return;
		}
	}

	public function tran()
	{
		$user = Model_User::anew();
		$user->user_name = 'あだち　こう';
		$user->user_email = 'adachi@marietta.co.jp';
		$user->user_password = md5('123456');
		$user->user_status = 1;
		$user->save();

		if (false)
		{
			throw new Exception();
		}


		$user = Model_User::anew();
		$user->user_name = 'あだち　こう';
		$user->user_email = 'adachi@marietta.co.jp';
		$user->user_password = md5('123456');
		$user->user_status = 1;
		$user->save();
		if (false)
		{
			throw new Exception();
		}
	}

}
