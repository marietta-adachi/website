<?php

class Controller_Index extends Controller_Basesite
{

	public function action_index()
	{
		$this->template->content = View_Smarty::forge('index', []);
	}

}
