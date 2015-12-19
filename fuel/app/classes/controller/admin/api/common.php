<?php

class Controller_Admin_Api_Common extends Controller_Base_Api
{

	public function action_upload_image()
	{
		try
		{
			//throw new Exception("");
			$id = Input::post("id");
			$image = Input::post("image");

			$fileName = $id . "_" . System::ymdhism() . ".png";

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

