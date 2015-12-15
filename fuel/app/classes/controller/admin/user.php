<?php

class Controller_Admin_User extends Controller_Base_Admin
{

	private $order = array(
		'id' => ['user_id-asc', '順'],
		'name' => ['user_name-asc', '順'],
		'email' => ['user_email-asc', '順'],
	);

	private function get_validation()
	{
		$val = Validation::instance();
		$val->add('freeword', 'フリーワード')->add_rule('max_length', 100);
		$val->add('status', 'ステータス');
		return $val;
	}

	public function action_index()
	{
		$this->init_condition(['status' => [Status::VALID, Status::INVALID], 'order' => 'id']);
		$d = $this->get_condition();

		$count = 0;
		$list = [];
		$page = null;
		if ($this->check_condition($d, $this->get_validation()))
		{
			$count = Model_Db_User::search_count($d);
			$page = Page::get_page('admin/user', $d, $count, Config::get('admin.page_limit.user'));
			$list = Model_Db_User::search($d, $this->order[$d['order']][0], $page->per_page, $page->offset);
			$page = $page->render();
		}

		$d['user_count'] = $count;
		$d['user_list'] = $list;
		$d['order_list'] = $this->order;

		$this->template->content = View_Smarty::forge('admin/user/index', $d)->set_safe('pagination', $page);
	}

	private function get_form()
	{
		$form = Fieldset::instance();
		if (count($form->field()) > 0)
		{
			return $form;
		}
		$form->add('operation', '');
		$form->add('id', '');
		$form->add('name', 'お名前')->add_rule('required')->add_rule('max_length', 50);
		$form->add('email', 'メールアドレス')->add_rule('required');
		$form->add('status', 'ステータス')->add_rule('required');
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
			if ($d['operation'] == Operation::MODIFY)
			{
				$user = Model_Db_User::by_id($d['id']);
				$d['id'] = $user->user_id;
				$d['name'] = $user->user_name;
				$d['email'] = $user->user_email;
				$d['status'] = $user->user_status;
			}
		}

		//$d['js_params'] = json_encode([]);

		$this->template->content = View_Smarty::forge('admin/user/edit', $d);
	}

	public function action_confirm()
	{
		$d = $this->check($this->get_form());
		if (!$d)
		{
			$this->action_edit();
			return;
		}

		if (!Model_Db_User::unique_email($d['email']))
		{
			$this->set_error(['email' => 'このメールアドレスは使用されています']);
		}
		if (!Model_Db_User::unique_name($d['name']))
		{
			$this->set_error(['name' => 'この名前は使用されています']);
		}
		if ($this->has_error())
		{
			$this->action_edit();
			return;
		}

		$this->template->content = View_Smarty::forge('admin/user/confirm', $d);
	}

	public function action_update()
	{
		$this->transaction('update');
	}

	public function update()
	{
		$d = $this->check($this->get_form());
		if (!$d)
		{
			$this->action_edit();
			return;
		}

		$now = Common::now();
		$user = Model_Db_User::by_id($d['id']);
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

		$this->template->content = View_Smarty::forge('admin/user/do', $d);
	}

}
