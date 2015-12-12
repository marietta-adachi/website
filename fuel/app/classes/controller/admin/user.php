<?php

class Controller_Admin_User extends Controller_Baseadmin
{

	private $order = array(
		'email' => ['user_email-desc', '順'],
		'name' => ['user_name-desc', '順'],
		'id' => ['user_id-desc', '順'],
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
		$this->init_condition(__METHOD__, array('status' => array(HospitalStatus::VALID), 'order' => 'm_hospital_name-asc'));

		list($c, $o, $p, $param) = $this->get_condition(__METHOD__);
		$this->validateCondition($c);

		$count = Model_Db_Qcommon::get_list(null, null, null, $c, true);
		$count = $count[0]['count'];

		$page = Page::getPage('admin/hospital', $count, $p, Config::get('admin.page_limit.hospital'));
		$list = Model_Db_Qcommon::get_list($o, $page->per_page, $page->offset, $c);

		$data = $c;
		$data['user_list'] = $list;
		$data['user_count'] = $count;
		$data['order_list'] = $this->order;
		$data['order'] = $o;
		$this->template->content = View_Smarty::forge('admin/user', $data)->set_safe('pagination', $page->render());
	}

	private function get_form()
	{
		$form = Fieldset::instance();
		if (count($form->field()) > 0)
		{
			return $form;
		}
		$form->add('mode', '');
		$form->add('id', '');
		$form->add('name', '')->add_rule('required')->add_rule('max_length', 50);
		$form->add('email', '')->add_rule('required');
		$form->add('status', '')->add_rule('required');
		return $form;
	}

	public function action_edit()
	{
		if ($this->is_post())
		{
			$d = $this->get_form()->repopulate()->input();
		}
		else
		{
			$d = Input::get();
			if ($d['mode'] == EditMode::MOD)
			{
				$user = Model_Db_User::find_by_pk($d['id']);
				$d['id'] = $user->user_id;
				$d['name'] = $user->user_name;
				$d['address'] = $user->user_address;
				$d['tel'] = $user->user_tel;
				$d['email'] = $user->user_email;
				$d['status'] = $user->user_status;
			}
		}

		$this->template->content = View_Smarty::forge('admin/user_edit', $d);
	}

	public function action_confirm()
	{
		$d = $this->check();

		if (false)
		{
			$this->set_error(['email' => 'xxx']);
		}
		if (false)
		{
			$this->set_error(['email' => 'xxx']);
		}
		if (false)
		{
			$this->set_error(['email' => 'xxx']);
		}

		if ($this->has_error())
		{
			$this->action_edit();
			return;
		}

		$this->template->content = View_Smarty::forge('admin/user_confirm', $d);
	}

	public function action_update()
	{
		$this->transaction('update');
	}

	public function update()
	{
		$d = $this->check();
		if (!$d)
		{
			$this->action_edit();
			return;
		}

		$now = Common::now();
		$user = Model_Db_User::byId($d['id']);
		if (empty($user))
		{
			$user = Model_Db_User::anew();
			$user->user_password = Auth::hash_password(Str::random('alnum', 6));
		}
		$user->user_name = $d['name'];
		$user->user_email = $d['email'];
		$user->user_status = $d['status'];
		$user->user_updated_at = $now;
		$user->save();

		$this->template->content = View_Smarty::forge('admin/user_do', $d);
	}

}
