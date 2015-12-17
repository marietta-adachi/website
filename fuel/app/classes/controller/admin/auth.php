<?php

class Controller_Admin_Auth extends Controller_Base_Admin
{

	private function get_form()
	{
		$form = Fieldset::instance();
		if (count($form->field()) > 0)
		{
			return $form;
		}
		$form->add('email', 'メールアドレス')->add_rule('required')->add_rule('valid_email');
		$form->add('password', 'パスワード')->add_rule('required')->add_rule('max_length', 30);
		$form->add('remember', 'パスワードを保存する')->add_rule('match_value', '1');
		return $form;
	}

	public function action_index()
	{
		$form = $this->get_form();
		if ($this->is_post())
		{
			$form->repopulate();
		}
		$d = $form->input();
		$this->template->content = View_Smarty::forge('admin/login', $d);
	}

	public function action_login()
	{

		$d = $this->check($this->get_form());
		if (!$d)
		{
			$this->action_index();
			return;
		}

		if (!Model_Db_Admin::login($d['email'], $d['password'], $d['remember']))
		{
			$this->set_error('メールアドレスまたはパスワードが違います');
			$this->action_index();
			return;
		}

		return Response::redirect('admin');
	}

	public function action_logout()
	{
		Model_Db_Admin::logout();
		return Response::redirect('admin');
	}

}
