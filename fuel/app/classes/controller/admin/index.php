<?php


class Controller_Admin_Index extends Controller_Baseadmin
{

	public function action_index()
	{
		$this->template->content = View_Smarty::forge('admin/index', []);
	}

}
