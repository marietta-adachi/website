<?php

class Controller_Admin_Auth extends Controller_Baseadmin
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
	try
	{
	    $val = $this->get_form()->validation();
	    if (!$val->run())
	    {
		$this->set_error($val);
	    }
	    $data = $val->validated();

	    $admin = Model_Db_Admin::find_one_by(array('admin_email' => $data['email'], 'admin_status' => AdminStatus::VALID,));
	    if (empty($admin))
	    {
		$this->set_error('IDまたはパスワードが違います');
	    }
	    if ($admin->admin_password != Auth::hash_password($data['password']))
	    {
		$this->set_error('IDまたはパスワードが違います');
	    }

	    // start session
	    Session::create();
	    $close = !(boolean) $data['remember'];
	    Session::set('expire_on_close', $close);
	    Session::set('admin', $admin);

	    return Response::redirect('admin');
	}
	catch (Exception $e)
	{
	    $this->error($e);
	    $this->action_index();
	}
    }

    public function action_logout()
    {
	try
	{
	    $this->logout();
	    return Response::redirect('admin');
	}
	catch (Exception $e)
	{
	    $this->error($e);
	}
    }

    public static function logout()
    {
	Cookie::delete('');
	Session::destroy();
    }

}
