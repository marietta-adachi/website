<?php

class Controller_About extends Controller_Base_Site
{

	public function action_index()
	{
		$this->breadcrumb = array(array("トップ", Uri::create("/")),);
		$this->template->content = View_Smarty::forge("about");
	}

}
