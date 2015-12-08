<?php

/**
 * Ajax用コントローラ
 */
class Controller_Admin_Rest_Ajax_Ul extends Controller_Baseajax
{

	public function action_chart()
	{
		try
		{
			//throw new Exception("");
			$id = Input::post("id");
			$image = Input::post("image");

			$fileName = $id . "_" . Common::nowTimestamp() . ".png";

			$res = File::create(APPPATH . "../../report/tmp/", $fileName, base64_decode(str_replace(' ', '+', $image)));
			if (!$res)
			{
				throw new FileException("画像の保存に失敗しました");
			}

			$this->response($fileName);
		}
		catch (Exception $e)
		{
			$this->error($e);
		}
	}

}
?>

