<?php

class Controller_Error_500 extends Controller_Basesite
{

	public function action_index()
	{
		$ext = Input::extension();
		Log::info('500：' . Input::uri() . '.' . $ext);

		$this->response_status = 500;
		$this->template->content = View_Smarty::forge('500');
	}

}
