<?php

class Controller_Base_Admin extends Controller_Base_Tpl
{

	public $template = 'admin/base';
	protected $subsystem = 'admin';

	public function after($response)
	{
		$response = parent::after($response);
		$this->post($this->template->content->tplname(), 'admin');

		$user = $this->get_user();
		$this->template->set_global('menu', View_Smarty::forge("admin/parts/menu", []));
		$this->template->set_global('top', View_Smarty::forge("admin/parts/top", ['user' => $user]));
		$this->template->set_global('header', View_Smarty::forge("admin/parts/header", []));
		$this->template->set_global('footer', View_Smarty::forge("admin/parts/footer", []));

		
		Model_Operationlog::write('admin', $user, $this->request->action);

		return $response;
	}

	protected function is_login()
	{
		return !empty(Model_Admin::by_session());
	}

	protected function get_user()
	{
		return Model_Admin::by_session();
		
	}

}
