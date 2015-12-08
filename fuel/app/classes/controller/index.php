<?php

class Controller_Index extends Controller_Basesite
{

    public function action_index()
    {
	try
	{
	 
	    $this->template->content = View_Smarty::forge("index", []);
	}
	catch (Exception $e)
	{
	    $this->error($e);
	}
    }

}
