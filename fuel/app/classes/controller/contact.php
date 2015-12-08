<?php

class Controller_Contact extends Controller_Basesite
{

    private $contactType = array(
	1 => "システムについて",
	2 => "医療機関について",
	3 => "その他お問い合わせ",
    );

    /**
     * 入力フォーム定義を取得します
     * @return type
     */
    private function getEditForm()
    {
	$form = Fieldset::instance();
	if (count($form->field()) > 0)
	{
	    return $form;
	}
	$form->add("contact_type", "お問い合わせ項目")->add_rule("required")->add_rule("match_pattern", "/".implode("|", array_keys($this->contactType))."/");
	$form->add("name", "お名前")->add_rule("required")->add_rule("max_length", 50);
	$form->add("name_kana", "お名前（フリガナ）")->add_rule("required")->add_rule("max_length", 50)->add_rule("valid_katakana");
	$form->add("tel", "電話番号")->add_rule("required")->add_rule("valid_tel");
	$form->add("mail_address", "メールアドレス")->add_rule("required")->add_rule("valid_email");
	$form->add("mail_address_confirm", "メールアドレス（確認）")->add_rule("required")->add_rule("match_field", "mail_address");
	$form->add("contact_detail", "お問い合わせ内容")->add_rule("required")->add_rule("max_length", 1000);
	$form->add("agree", "同意")->add_rule("match_value", 1);
	return $form;
    }

    /**
     * 入力画面を表示します
     * @param type $mode
     * @param type $trtId
     */
    public function action_index()
    {
	try
	{
	    $data = array();
	    if (Input::method() === "POST")
	    {
		// バリデーションエラー
		$form = $this->getEditForm();
		$form->repopulate();
		$data = $form->input();
	    }

	    $data["contact_type_list"] = $this->contactType;

	    $this->breadcrumb = array(array("トップ", Uri::create("/")),);
	    $this->template->content = View_Smarty::forge("contact_edit", $data);
	}
	catch (Exception $e)
	{
	    $this->error($e);
	    $this->action_index();
	}
    }

    /**
     * 入力内容を確認します
     */
    public function action_confirm()
    {
	try
	{
	    // 入力チェック
	    $val = $this->getEditForm()->validation();
	    if (!$val->run())
	    {
		$this->invalid($val);
	    }
	    $data = $val->validated();


	    // 同意チェック
	    if (empty($data["agree"]))
	    {
		$this->invalid2("agree", "お問い合わせには同意が必要です");
	    }


	    $data["contact_type_list"] = $this->contactType;

	    $this->template->content = View_Smarty::forge("contact_confirm", $data);
	}
	catch (Exception $e)
	{
	    $this->error($e);
	    $this->action_index();
	}
    }

    /**
     * 送信処理を行います
     * @return type
     * @throws Exception
     */
    public function action_complete()
    {
	try
	{
	    $this->checkCsrf();

	    // 入力チェック
	    $val = $this->getEditForm()->validation();
	    if (!$val->run())
	    {
		$this->invalid($val);
	    }
	    $data = $val->validated();


	    // メール通知（サンクス） ****************************************************
	    $title = "お問い合わせを承りました";
	    $email = Email::forge();
	    $email->clear_addresses();
	    $email->from(Config::get("mail.account.help.addr"), Config::get("mail.account.help.name"));
	    $email->to($data["mail_address"], $data["name"]."様");
	    $email->subject(Config::get("mail.prefix").$title);
	    $body = View_Smarty::forge("mail/contact_complete");
	    $body->data = $data;
	    $body->contact_type_list = $this->contactType;
	    $email->body($body);
	    Common::sendmail($email);

	    // メール通知（管理者） ****************************************************
	    $title = "お問い合わせ";
	    $email = Email::forge();
	    $email->clear_addresses();
	    $email->from($data["mail_address"], $data["name"]."様");
	    $email->to(Config::get("mail.account.help.addr"), Config::get("mail.account.help.name"));
	    $email->subject(Config::get("mail.prefix").$title);
	    $body = View_Smarty::forge("mail/contact_complete_admin");
	    $body->data = $data;
	    $body->contact_type_list = $this->contactType;
	    $email->body($body);
	    Common::sendmail($email);

	    $this->template->content = View_Smarty::forge("contact_complete", $data);
	}
	catch (Exception $e)
	{
	    $this->error($e);
	    $this->action_index();
	}
    }

}
