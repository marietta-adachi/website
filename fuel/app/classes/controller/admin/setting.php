<?php


class Controller_Admin_Setting extends Controller_Baseadmin
{


	private function get_form($type = 0)
	{
		$form = Fieldset::instance();
		if (count($form->field()) > 0)
		{
			return $form;
		}

		switch ($type)
		{
			case SettingType::PASSWORD:
				$form->add("mail_address_new", "新しいメールアドレス");
				$form->add("mail_address_new_confirm", "新しいメールアドレス（確認）");
				$form->add("password", "現在のパスワード")->add_rule("required");
				$form->add("password_new", "新しいパスワード")->add_rule("required")->add_rule("min_length", 4)->add_rule("max_length", 30)->add_rule("valid_string", array("alpha", "numeric",));
				$form->add("password_new_confirm", "新しいパスワード（確認）")->add_rule("required")->add_rule("match_field", "password_new");
				break;
			case SettingType::MAILADDRESS:
				$form->add("mail_address_new", "新しいメールアドレス")->add_rule("required")->add_rule("valid_email");
				$form->add("mail_address_new_confirm", "新しいメールアドレス（確認）");
				$form->add("password", "現在のパスワード");
				$form->add("password_new", "新しいパスワード");
				$form->add("password_new_confirm", "新しいパスワード（確認）");
				break;
			default:
				break;
		}
		return $form;
	}


	public function action_index($updated = false)
	{
		try
		{
			$data = array();
			if (!$updated)
			{
				$form = $this->getForm();
				if (Input::method() === "POST")
				{
					$form->repopulate();
				}
				$data = $form->input();
			}
			$this->template->content = View_Smarty::forge("admin/setting", $data);
		}
		catch (Exception $e)
		{
			$this->error($e);
		}
	}


	public function action_do($type = 0)
	{

		$this->checkCsrf("admin");

		try
		{
			DB::start_transaction();

			// 入力チェック
			$val = $this->getForm($type)->validation();
			if (!$val->run())
			{
				$this->invalid($val);
			}
			$data = $val->validated();
			$adminId = $this->adminId();

			// DB更新
			$admin = Model_Db_Madmin::find_by_pk($adminId);
			switch ($type)
			{
				case SettingType::MAILADDRESS:
					$admin->m_admin_mail_address = $data["mail_address_new"];
					break;
				case SettingType::PASSWORD:
					if ($admin->m_admin_hashed_password != Auth::hash_password($data["password"]))
					{
						$this->invalid2("password", "現在のパスワードが間違っています");
					}
					$admin->m_admin_hashed_password = Auth::hash_password($data["password_new"]);
					break;
				default:
			}
			$admin->m_admin_updated_at = System::now();

			if ($admin->save() == 0)
			{
				throw new Exception("設定情報更新に失敗しました");
			}

			// メール通知 ****************************************************
			switch ($type)
			{
				case SettingType::MAILADDRESS:
					$title = "管理者メールアドレス変更のお知らせ";
					$email = Email::forge();
					$email->clear_addresses();
					$email->from(Config::get("mail.addr_info"), Config::get("mail.addr_info_name"));
					$email->to($data["mail_address_new"], $this->adminName() . "さん");
					$email->subject(Config::get("mail.prefix") . $title);

					$body = View_Smarty::forge("admin/mail/setting_mail");
					$body->title = $title;
					$body->name = $this->adminName();
					$body->mail_address = $data["mail_address_new"];
					
					$email->body($body);
					Common::sendmail($email);
					break;
				case SettingType::PASSWORD:
					$title = "管理者パスワード変更のお知らせ";
					$email = Email::forge();
					$email->clear_addresses();
					$email->from(Config::get("mail.addr_info"), Config::get("mail.addr_info_name"));
					$email->to($this->adminMail(), $this->adminName() . "さん");
					$email->subject(Config::get("mail.prefix") . $title);

					$body = View_Smarty::forge("admin/mail/setting_password");
					$body->title = $title;
					$body->name = $this->adminName();
					$body->password = $data["password_new"];
					$email->body($body);
					Common::sendmail($email);
					break;
				default:
			}

			if ($type == SettingType::MAILADDRESS)
			{
				//$this->dispInfo("入力したメールアドレス宛に確認メールを送信しました。\\nメールが届かない場合は、入力したメールアドレスを確認してください。");
			}
			else
			{
				//$this->dispInfo(SettingType::$name[$type] . "を更新しました");
			}
			$this->action_index(true);
			DB::commit_transaction();
		}
		catch (Exception $e)
		{
			DB::rollback_transaction();
			$this->error($e);
			$this->action_index(false);
		}
	}

}
