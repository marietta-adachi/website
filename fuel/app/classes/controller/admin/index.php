<?php


class Controller_Admin_Index extends Controller_Base_Admin
{

	public function action_index()
	{
		$this->template->content = View_Smarty::forge('admin/index', []);
	}

}
