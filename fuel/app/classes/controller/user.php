<?php

class Controller_User extends Controller_Basesite
{

	public function action_index()
	{

		$res = Model_Db_User::byCustom();

//throw new \HttpServerErrorException();
		$d['user_list'] =$res;
		$this->template->content = View_Smarty::forge('user', $d);
	}

	public function action_do()
	{
		if ($this->transaction('tran'))
		{
			$this->action_edit();
			return;
		}
	}

	public function tran()
	{

		$d = $this->check();
		if (false)
		{
			$this->set_error(['email' => 'xxx']);
		}
		if (false)
		{
			$this->set_error(['email' => 'xxx']);
		}
		if (false)
		{
			$this->set_error(['email' => 'xxx']);
		}
		if ($this->has_error())
		{
			return false;
		}


		$user = Model_Db_User::anew();
		$user->user_name = 'あだち　こう';
		$user->user_email = 'adachi@marietta.co.jp';
		$user->user_password = md5('123456');
		$user->user_status = 1;
		$user->save();

		return true;
	}

	public function action_do_transaction()
	{
		
		$d = $this->check();

		if (false)
		{
			$this->set_error(['email' => 'xxx']);
		}
		if (false)
		{
			$this->set_error(['email' => 'xxx']);
		}
		if (false)
		{
			$this->set_error(['email' => 'xxx']);
		}

		if ($this->has_error())
		{
			$this->action_edit();
			return;
		}
		
		
		
		$user = Model_Db_User::anew();
		$user->user_name = 'あだち　こう';
		$user->user_email = 'adachi@marietta.co.jp';
		$user->user_password = md5('123456');
		$user->user_status = 1;
		$user->save();

		if (false)
		{
			return false;
		}

		if (false)
		{
			throw new Exception();
		}

		$d['user_list'] = [];
		return View_Smarty::forge('user', $d);
	}

}
