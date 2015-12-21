<?php

trait Controller_Base_Plugin_Ssl
{

	public function ssl_redirect()
	{
		return Input::protocol() == 'http';
	}

}
