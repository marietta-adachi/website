<?php

class Controller_Baseadmin extends Controller_Base
{

	public $template = 'admin/base';

	public function before()
	{
		parent::before();
		$this->pre('admin');
	}

	public function after($response)
	{
		$response = parent::after($response, 'admin');
		$this->post('admin',$this->template->content->tplname());
		return $response;
	}

	protected function is_login()
	{
		return !empty(Model_Db_Admin::bySession());
	}

	protected function get_user()
	{
		return Model_Db_Admin::bySession();
	}

}
