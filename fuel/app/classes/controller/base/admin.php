<?php

class Controller_Base_Admin extends Controller_Base_Base
{

	public $template = 'admin/base';

	public function before()
	{
		parent::before();
		$this->pre('admin');
	}

	public function after($response)
	{
		$response = parent::after($response, 'admin');
		$this->post('admin', $this->template->content->tplname());

		$this->template->set_global('menu', View_Smarty::forge("admin/parts/menu", []));
		$this->template->set_global('top', View_Smarty::forge("admin/parts/top", []));
		$this->template->set_global('header', View_Smarty::forge("admin/parts/header", []));
		$this->template->set_global('footer', View_Smarty::forge("admin/parts/footer", []));

		Model_Db_Operationlog::write('admin', Model_Db_Admin::by_session(), $this->request->action);

		return $response;
	}

	protected function is_login()
	{
		return !empty(Model_Db_Admin::by_session());
	}

	protected function get_user()
	{
		return Model_Db_Admin::by_session();
	}

}
