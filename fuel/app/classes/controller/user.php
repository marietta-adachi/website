<?php

class Controller_User extends Controller_Basesite
{

	public function action_index()
	{

		$d['user_list'] = Model_Db_User::find_all();
		$this->template->content = View_Smarty::forge('user', $d);
	}

	//public function update()
	public function action_update_t()
	{

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
		$d['tpl'] = 'user';
		return View_Smarty::forge('user', $d);
	}

}
