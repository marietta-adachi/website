<?php

class Controller_Baseadmin extends Controller_Base
{

    public $template = 'admin/base';

    public function before()
    {
	parent::before();
	$this->pre('admin');
    }

    public function after($response)
    {
	parent::after($response, 'admin');
	$this->post('admin');
	return $response;
    }

    protected function is_login()
    {
	$tmp = $this->get_user();
	return !empty($tmp);
    }

    protected function get_user()
    {
	$tmp = Session::get('admin');
	return $tmp;
    }

}
