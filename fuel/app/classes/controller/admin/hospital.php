<?php

/**
 * 
 */
class Controller_Admin_Hospital extends Controller_Baseadmin
{

    private $order = array(
	'v_hospital_evaluate_total-desc' => '医療機関名順',
	'v_hospital_-asc' => '医療機関ID順',
	'v_hospital_-asc' => '登録日順',
    );

    private function validateCondition($c)
    {
	$val = Validation::instance();
	$val->add('free_word', '')->add_rule('max_length', 100);
	if (!$val->run($c))
	{
	    throw new Exception('検索条件が不正です');
	}
    }

    public function action_index()
    {
	try
	{
	    $this->init_condition('admin_hospital_search', array('status' => array(HospitalStatus::VALID), 'order' => 'm_hospital_name-asc'));

	    list($c, $o, $p, $param) = $this->get_condition('hospital_search');
	    $this->validateCondition($c);

	    $count = Model_Db_Qcommon::get_list(null, null, null, $c, true);
	    $count = $count[0]['count'];

	    $page = Page::getPage('admin/hospital', $count, $p, Config::get('admin.page_limit.hospital'));
	    $list = Model_Db_Qcommon::get_list($o, $page->per_page, $page->offset, $c);

	    $data = $c;
	    $data['hospital_list'] = $list;
	    $data['count_all'] = $count;
	    $data['order_list'] = $this->order;
	    $data['selected_order'] = $o;
	    $this->template->content = View_Smarty::forge('admin/hospital', $data)->set_safe('pagination', $page->render());
	}
	catch (Exception $e)
	{
	    $this->error($e);
	}
    }

    private function get_form()
    {
	$form = Fieldset::instance();
	if (count($form->field()) > 0)
	{
	    return $form;
	}
	$form->add('mode', '編集モード');
	$form->add('id', 'ID');
	$form->add('name', '業者名')->add_rule('required')->add_rule('max_length', 50);
	$form->add('mail_address', 'メールアドレス')->add_rule('required');
	$form->add('status', 'ステータス')->add_rule('required');
	return $form;
    }

    public function action_edit($mode = EditMode::ADD, $id = null)
    {
	try
	{
	    if (Input::method() === 'POST')
	    {
		$form = $this->get_form();
		$form->repopulate();
		$data = $form->input();
	    }
	    else
	    {
		$data['mode'] = $mode;
		if ($mode == EditMode::MOD)
		{
		    $vendor = Model_Db_Mvendor::find_by_pk($id);
		    $data['id'] = $vendor->m_vendor_id;
		    $data['name'] = $vendor->m_vendor_name;
		    $data['address'] = $vendor->m_vendor_address;
		    $data['tel'] = $vendor->m_vendor_tel;
		    $data['mail_address'] = $vendor->m_vendor_mail_address;
		    $data['status'] = $vendor->m_vendor_status;
		}
		else
		{
		    
		}
	    }

	    $this->template->content = View_Smarty::forge('admin/user_edit', $data);
	}
	catch (Exception $e)
	{
	    $this->error($e);
	    $this->action_index();
	}
    }

    public function action_confirm()
    {
	try
	{
	    $val = $this->get_form()->validation();
	    if (!$val->run())
	    {
		$this->set_error($val);
	    }
	    $data = $val->validated();


	    if (false)
	    {
		$this->set_error(['mail_address' => 'このメールアドレスは既に使用されています']);
	    }

	    $this->check_error();


	    $this->template->content = View_Smarty::forge('admin/user_confirm', $data);
	}
	catch (Exception $e)
	{
	    $this->error($e);
	    $this->action_edit();
	}
    }

    public function action_do()
    {
	try
	{
	    $this->check_csrf();

	    $val = $this->get_form()->validation();
	    if (!$val->run())
	    {
		$this->invalid($val);
	    }
	    $data = $val->validated();

	    $now = Common::now();
	    $row = Model_Db_Mvendor::find_by_pk(intval($data['id']));
	    if (empty($row))
	    {
		$password = Str::random('alnum', 6);
		$row = Model_Db_Mvendor::forge();
		$row->m_vendor_created_at = $now;

		$row->m_vendor_password = $password;
		$row->m_vendor_hashed_password = Auth::hash_password($password);
	    }

	    $row->m_vendor_name = $data['name'];
	    $row->m_vendor_status = $data['status'];
	    $row->m_vendor_updated_at = $now;

	    if ($row->save() == 0)
	    {
		throw new Exception('業者マスタの登録に失敗しました');
	    }

	    $this->template->content = View_Smarty::forge('admin/vendor_complete', $data);
	}
	catch (Exception $e)
	{
	    $this->error($e);
	    $this->action_edit();
	}
    }

}
