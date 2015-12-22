<?php

trait Controller_Base_Plugin_Auth
{

	public function auth_redirect($controller)
	{
		return !$controller->is_login();
	}

}
