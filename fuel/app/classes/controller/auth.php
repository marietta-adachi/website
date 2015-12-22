<?php

class Controller_Auth extends Controller_Base_Site
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
		$d = [];
		if ($this->is_post())
		{
			$d = $this->get_form()->repopulate()->input();
		}
		$this->template->content = View_Smarty::forge('login', $d);
	}

	public function action_login()
	{
		$d = $this->verify($this->get_form());
		if (!$d)
		{
			$this->action_index();
			return;
		}

		if (!Model_Admin::login($d['email'], $d['password'], $d['remember']))
		{
			$this->msg('メールアドレスまたはパスワードが違います');
			$this->action_index();
			return;
		}

		return Response::redirect('index');
	}

	public function action_logout()
	{
		$Model_Admin::logout();
		return Response::redirect('/');
	}

}
