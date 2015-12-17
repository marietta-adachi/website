<?php

class Controller_Admin_User extends Controller_Base_Admin
{

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
			$count = Model_Db_User::search_count($d);
			$page = Page::get_page('admin/user', $d, $count, Config::get('admin.page_limit.user'));
			$list = Model_Db_User::search($d, $page->per_page, $page->offset);
			$page = $page->render();
		}

		$d['count'] = $count? : 0;
		$d['list'] = $list? : [];
		$d['order_list'] = Model_Db_User::$order;

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
		$d = $this->verify($this->get_form());
		if (!$d)
		{
			$this->action_edit();
			return;
		}

		if (!Model_Db_User::unique_email($d['email']))
		{
			$this->msg(['email' => 'このメールアドレスは使用されています']);
		}
		if (!Model_Db_User::unique_name($d['name']))
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

	public function action_do()
	{
		$this->transaction('update');
	}

	public function update()
	{
		$this->verify_csrf();

		$d = $this->verify($this->get_form());
		if (!$d)
		{
			$this->action_edit();
			return;
		}

		$now = Common::now();
		$user = null;
		if ($d['ope'] == Ope::ADD)
		{
			$user = Model_Db_User::anew();
			$user->user_password = Auth::hash_password(Str::random('alnum', 6));
		}
		else
		{
			$user = Model_Db_User::by_id($d['id']);
		}
		$user->user_name = $d['name'];
		$user->user_email = $d['email'];
		$user->user_status = $d['status'];
		$user->user_updated_at = $now;
		$user->save();

		$this->template->content = View_Smarty::forge('admin/user/do', $d);
	}

}
