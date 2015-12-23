<?php

class Controller_Admin_User extends Controller_Base_Admin
{

	use Controller_Base_Plugin_Auth;

	private function get_criteria_form()
	{
		$form = Fieldset::instance();
		if (count($form->field()) > 0)
		{
			return $form;
		}
		$form->add('freeword', 'フリーワード')->add_rule('max_length', 100);
		$form->add('status');
		$form->add('p');
		$form->add('per_page');
		$form->add('order');
		$form->add('init');
		return $form;
	}

	public function action_index()
	{
		$d = $this->verify_criteria($this->get_criteria_form());
		if ($d)
		{
			$d = $this->get_criteria($d, ['status' => [St::VALID, St::INVALID], 'order' => 'id']);
			$count = Model_User::count_by($d);
			$page = Page::get_page('admin/user', $d, $count);
			$list = Model_User::by($d, $page);
		}

		$d['count'] = $count? : 0;
		$d['list'] = $list? : [];
		$d['order_list'] = Model_User::$order;
		$d['offset'] = $page->offset;
		$d['per_page'] = $page->per_page;

		$this->template->content = View_Smarty::forge('admin/user/index', $d)->set_safe('pagination', $page);
	}

	private function get_form()
	{
		$form = Fieldset::instance();
		if (count($form->field()) > 0)
		{
			return $form;
		}
		$form->add('ope');
		$form->add('id');
		$form->add('name', 'お名前')->add_rule('required')->add_rule('max_length', 50);
		$form->add('email', 'メールアドレス')->add_rule('required');
		$form->add('status', 'ステータス')->add_rule('required');
		return $form;
	}

	public function action_edit()
	{
		$d = [];
		if ($this->is_post())
		{
			$d = $this->get_form()->repopulate()->input();
		}
		else
		{
			$d = Input::get();
			if ($d['ope'] == Ope::MODIFY)
			{
				$user = Model_User::by_id($d['id']);
				$d['id'] = $user->id;
				$d['name'] = $user->name;
				$d['email'] = $user->email;
				$d['status'] = $user->status;
			}
		}

		$d['js_params'] = json_encode(["b" => "bbbb", "a" => "aaaa"]);
		$this->_breadcrumbs = [
			[['B', Uri::create('admin/property')], ['B', Uri::create('admin/property')],],
			['B', Uri::create('admin/property')],
			'C',
		];
		$this->template->content = View_Smarty::forge('admin/user/edit', $d);
	}

	public function action_confirm()
	{
		$d = $this->verify($this->get_form());
		if (!$d)
		{
			$this->action_edit();
			return;
		}

		if (!Model_User::unique_email($d['id'],$d['email']))
		{
			$this->msg(['email' => 'このメールアドレスは使用されています']);
		}
		if (!Model_User::unique_name($d['id'],$d['name']))
		{
			$this->msg(['name' => 'この名前は使用されています']);
		}
		if ($this->has_error())
		{
			$this->action_edit();
			return;
		}

		$this->template->content = View_Smarty::forge('admin/user/confirm', $d);
	}

	public function action_do_()
	{
		$this->transaction('update');
	}

	public function action_do()
	{
		$this->verify_csrf();

		$d = $this->verify($this->get_form());
		if (!$d)
		{
			$this->action_edit();
			return;
		}

		$user = null;
		if ($d['ope'] == Ope::ADD)
		{
			$user = Model_User::forge();
			$user->password = Auth::hash_password('123456');//Str::random('alnum', 6));
		}
		else
		{
			$user = Model_User::by_id($d['id']);
		}
		$user->name = $d['name'];
		$user->email = $d['email'];
		$user->status = $d['status'];
		$user->save();

		$this->template->content = View_Smarty::forge('admin/user/do', $d);
	}

}
