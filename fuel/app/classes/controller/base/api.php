<?php

class Controller_Base_Api extends Controller_Rest
{

	protected $_errors = [];
	protected $_body = null;

	public function before()
	{
		parent::before();
		Config::load('base');

		Logger::params();

		if (is_callable([$this, 'auth_redirect']))
		{
			if ($this->auth_redirect($this))
			{
				Response::redirect('api/auth/unauthenticated.json');
			}
		}
	}

	public function after($responce)
	{
		$responce = parent::after($responce);

		if (count($this->_errors) == 0)
		{
			$res['status'] = 'success';
		}
		else
		{
			$res['status'] = 'failed';
			$res['errors'] = $this->_errors;
		}
		$res['body'] = $this->_body;

		return $this->response($res);
	}

	protected function verify_csrf()
	{
		if (!Security::check_token())
		{
			$this->_errors[] = ApiError::TOKEN;
			return false;
		}
		return true;
	}

	protected function verify($validation, $param = [])
	{
		$param = array_merge(Input::all(), $param);
		if (!$validation->run($param))
		{
			$msg = [];
			foreach ($validation->error() as $k => $m)
			{
				$msg[] = $m;
			}
			$this->_errors[] = [ApiError::VALIDATION => implode('／', $msg)];
			return false;
		}
		return $validation->validated();
	}

	protected function is_login()
	{
		return !empty(Model_User::by_session());
	}

}

class ApiError
{

	const UNAUTHENTICATED = [10 => 'Unauthenticated'];
	const TOKEN = [20 => 'Invalid token'];
	const VALIDATION = 30;

}
