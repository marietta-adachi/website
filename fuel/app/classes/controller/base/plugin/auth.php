<?php

trait Controller_Base_Plugin_Auth
{

	public function auth_redirect($is_login)
	{
		return !$is_login;
	}

}
