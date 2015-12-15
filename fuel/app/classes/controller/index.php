<?php

class Controller_Index extends Controller_Base_Site
{

	public function action_index()
	{
		$this->template->content = View_Smarty::forge('index', []);
	}

}
