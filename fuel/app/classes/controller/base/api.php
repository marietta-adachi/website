<?php

class Controller_Base_Api extends Controller_Rest
{

	public function before()
	{
		parent::before();
		Config::load('base');

		foreach (Input::post() as $k => $v)
		{
			Log::info($k . '：' . $v);
		}
	}

	protected function checkCsrf($token = null)
	{
		if (!Security::check_token($token))
		{
			Logger::error(new Exception('CSRF Error'));
			//	Controller_Auth::logout();
			return Response::redirect();
		}
	}

	protected function validate($val, $value = null)
	{
		if (empty($value))
		{
			$value = Input::all();
		}

		if (!$val->run($value))
		{
			$msg = '';
			foreach ($val->error() as $f => $e)
			{
				$msg[] = $e;
			}
			throw new Exception(implode('／', $msg));
		}

		return $val->validated();
	}

	protected function error($e)
	{
		Logger::error($e);
		$this->response(array('message' => $e->getMessage(),), 500);
	}

}
