<?php

class Controller_Api_Auth extends Controller_Base_Api
{

	public function action_unauthenticated()
	{
		$this->_errors = ApiError::UNAUTHENTICATED;
	}

}
