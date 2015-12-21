<?php

class Controller_Admin_Index extends Controller_Base_Admin
{

	use Controller_Base_Plugin_Auth;

	public function action_index()
	{
		$this->template->content = View_Smarty::forge('admin/index', []);
	}

}
