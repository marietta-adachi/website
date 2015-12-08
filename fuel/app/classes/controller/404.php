<?php

class Controller_404 extends Controller_Basesite
{

	/**
	 * 404エラー時
	 */
	public function action_index()
	{
		$uri = Input::uri();
		$ext = Input::extension();
		Log::info("404：" . $uri . "." . $ext);

		// コンテンツの場合は404を返す
		$ext = Input::extension();
		if (in_array($ext, array("png", "jpg", "jpeg", "gif", "js", "css", "aspx", "xml", "json")))
		{
			header("HTTP/1.1 404 Not Found");
			exit;
		}

		// トップへリダイレクト
		//$url = (strstr($uri, "/admin")) ? "admin" : "/";
		//return Response::redirect($url);

		$this->customTitle = "404 - Page Not Found";
		$this->response_status = 404;
		$this->template->content = View_Smarty::forge("404");
	}

}
