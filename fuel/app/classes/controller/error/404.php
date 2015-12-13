<?php

class Controller_Error_404 extends Controller_Basesite
{

	public function action_index()
	{
		$ext = Input::extension();
		Log::info('404：' . Input::uri() . '.' . $ext);

		// コンテンツの場合は404を返す
		$ext = Input::extension();
		if (in_array($ext, array('png', 'jpg', 'jpeg', 'gif', 'js', 'css', 'aspx', 'xml', 'json')))
		{
			header('HTTP/1.1 404 Not Found');
			exit;
		}

		$this->response_status = 404;
		$this->template->content = View_Smarty::forge('404');
	}

}
