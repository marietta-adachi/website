<?php

class Controller_About extends Controller_Basesite
{

    public function action_index()
    {
	try
	{
	    $this->breadcrumb = array(array("トップ", Uri::create("/")),);
	    $this->template->content = View_Smarty::forge("about");
	}
	catch (Exception $e)
	{
	    $this->error($e);
	}
    }

}
