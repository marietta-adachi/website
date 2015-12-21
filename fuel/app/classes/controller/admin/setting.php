<?php

class Controller_Admin_Settings extends Controller_Base_Admin
{

	use Controller_Base_Plugin_Auth;

	private function get_form($type)
	{
		$form = Fieldset::instance();
		if (count($form->field()) > 0)
		{
			return $form;
		}

		switch ($type)
		{
			case 'password':
				$form->add("email", "新しいメールアドレス");
				$form->add("email_match", "新しいメールアドレス（確認）");
				$form->add("password_crr", "現在のパスワード")->add_rule("required");
				$form->add("password", "新しいパスワード")->add_rule("required")->add_rule("min_length", 4)->add_rule("max_length", 30)->add_rule("valid_string", array("alpha", "numeric",));
				$form->add("password_match", "新しいパスワード（確認）")->add_rule("required")->add_rule("match_field", "password_new");
				break;
			case 'email':
				$form->add("email", "新しいメールアドレス")->add_rule("required")->add_rule("valid_email");
				$form->add("email_match", "新しいメールアドレス（確認）");
				$form->add("password_crr", "現在のパスワード");
				$form->add("password", "新しいパスワード");
				$form->add("password_match", "新しいパスワード（確認）");
				break;
		}
		return $form;
	}

	public function action_index($updated = false)
	{
		if (!$updated)
		{
			if ($this->is_post())
			{
				$d = $this->get_form()->repopulate()->input();
			}
		}
		$this->template->content = View_Smarty::forge("admin/settings/index", $d);
	}

	public function action_do_email()
	{
		$this->verify_csrf();

		$d = $this->verify($this->get_form('email'));
		if (!$d)
		{
			$this->action_index();
			return;
		}

		$admin = Model_Db_Admin::by_session();
		$admin->admin_email = $d["email"];
		$admin->admin_updated_at = System::now();
		$admin->save();

		// メール通知 ****************************************************
		$title = "管理者メールアドレス変更のお知らせ";
		$email = Email::forge();
		$email->clear_addresses();
		$email->from(Config::get("mail.addr_info"), Config::get("mail.addr_info_name"));
		$email->to($d["email"], $this->adminName() . "さん");
		$email->subject(Config::get("mail.prefix") . $title);

		$body = View_Smarty::forge("admin/settings/to_admin_1");
		$body->title = $title;
		$body->name = $this->adminName();
		$body->mail_address = $d["email"];

		$email->body($body);
		Common::sendmail($email);
		$this->msg(['complete', '入力したメールアドレス宛に確認メールを送信しました。\\nメールが届かない場合は、入力したメールアドレスを確認してください。']);

		$this->action_index(true);
	}

	public function action_do_password()
	{
		$this->verify_csrf();

		$d = $this->verify($this->get_form('password'));
		if (!$d)
		{
			$this->action_index();
			return;
		}

		$admin = Model_Db_Admin::by_session();
		if ($admin->admin_password != Auth::hash_password($d["password_crr"]))
		{
			$this->msg(['password_crr', '現在のパスワードが間違っています']);
			$this->action_index();
			return;
		}
		$admin->admin_password = Auth::hash_password($d["password"]);
		$admin->admin_updated_at = System::now();
		$admin->save();

		// メール通知 ****************************************************
		$title = "管理者パスワード変更のお知らせ";
		$email = Email::forge();
		$email->clear_addresses();
		$email->from(Config::get("mail.addr_info"), Config::get("mail.addr_info_name"));
		$email->to($this->adminMail(), $this->adminName() . "さん");
		$email->subject(Config::get("mail.prefix") . $title);

		$body = View_Smarty::forge("admin/settings/to_admin_2");
		$body->title = $title;
		$body->name = $this->adminName();
		$body->password = $d["password"];
		$email->body($body);
		Common::sendmail($email);

		$this->msg('complete', 'パスワードを更新しました');
		$this->action_index(true);
	}

}
