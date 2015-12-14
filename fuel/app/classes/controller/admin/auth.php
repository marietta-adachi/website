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
		$form->add('email', 'メールアドレス')->add_rule('required')->add_rule('max_length', 30)->add_rule('valid_email');
		$form->add('password', 'パスワード')->add_rule('required')->add_rule('max_length', 30);
		$form->add('remember', 'パスワードを保存する')->add_rule('match_value', '1');
		return $form;
	}

	public function action_index()
	{
		$form = $this->get_form();
		if (Input::method() === 'POST')
		{
			$form->repopulate();
		}
		$data = $form->input();
		$this->template->content = View_Smarty::forge('admin/auth', $data);
	}

	public function action_login()
	{

		$d = $this->check();
		if (!$d)
		{
			$this->set_error($val);
			$this->action_index();
			return;
		}

		if (!Model_Db_Admin::login($d['email'], $d['password'], $d['remember']))
		{
			$this->set_error('IDまたはパスワードが違います');
			$this->action_index();
			return;
		}

		return Response::redirect('admin');
	}

	public function action_logout()
	{
		$Model_Db_Admin::logout();
		return Response::redirect('admin');
	}

}
