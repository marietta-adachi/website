<?php

/**
 * 管理サイト用基本コントローラ
 */
class Controller_Baseadmin extends Controller_Base
{

    public $template = 'admin/base';

    public function before()
    {
	parent::before('admin');
    }

    public function after($response)
    {
	return parent::after($response, 'admin');
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
