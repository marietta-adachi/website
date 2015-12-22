<?php

trait Controller_Base_Plugin_Ssl
{

	private $allow = [
		'admin/auth/index',
	];

	public function ssl_redirect($controller)
	{
		if (Input::protocol() == 'http')
		{
			if (!array_key_exists($this->request->route->translation, $this->allow))
			{
				return true;
			}
		}

		return false;
	}

}
