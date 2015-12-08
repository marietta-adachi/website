<?php

/**
 * 管理サイトトップ用コントローラ
 */
class Controller_Admin_Index extends Controller_Baseadmin
{

	/**
	 * 画面を表示します
	 */
	public function action_index()
	{
		return Response::redirect("admin/hospital");
	}

}
