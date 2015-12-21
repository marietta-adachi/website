<?php

class Controller_Base_Tpl extends Controller_Template
{

	protected $_custom_title = '';
	protected $_custom_keyword = [[], 0];
	protected $_custom_description = '';
	protected $_breadcrumbs = [];
	protected $_h1 = '';
	protected $_messages = [];

	public function router($method, $params)
	{
		Config::load('base');

		if (is_callable([$this, 'auth_redirect']))
		{
			if ($this->auth_redirect($this->is_login()))
			{
				return Response::redirect($this->subsystem . '/auth');
			}
		}
		if (is_callable([$this, 'ssl_redirect']))
		{
			if ($this->ssl_redirect())
			{
				return Response::redirect(Uri::create(Input::uri(), [], [], true));
			}
		}

		$function = 'action_' . $this->request->action;
		$this->$function($params);
	}

	protected function post($tplname, $layer = '')
	{
		// screen
		Log::info($tplname);
		$tmp[] = 'site';
		if (!empty($layer)) $tmp[] = $layer;
		$tmp[] = 'meta';
		$meta = Config::get(implode('.', $tmp));

		$this->set_assets($tplname);

		// TDHK
		$this->set_title($meta, $tplname);
		$this->set_keywords($meta, $tplname);
		$this->set_description($meta, $tplname);
		$this->set_breadcrumbs(@$meta['screens'][$tplname][0]);
		$this->template->set_safe('h1', $this->_h1);

		$this->template->set_global('screen', str_replace('/', '-', $tplname));
		$this->template->set_global('screen_name', @$meta['screens'][$tplname][0]);
		$this->template->set_global('status_code', $this->response_status);

		// error
		$this->template->set_global('msgs', $this->_messages);

		// device
		$this->template->set_global('device', System::get_device());

		// login
		$this->template->set_global('login', $this->is_login());
		$this->template->set_global('user', $this->get_user());
	}

	protected function set_title($meta, $tplname)
	{
		if (!array_key_exists($tplname, $meta['screens']))
		{
			return '';
		}

		$tmp = $meta['screens'][$tplname];
		$tmp = $this->_custom_title . $tmp[0];
		$title = $meta['title'];
		$siteName = empty($tmp) ? $title : (empty($title) ? '' : '｜' . $title);
		$tmp = $tmp . $siteName;
		$this->template->set_global('title', $tmp);
	}

	protected function set_keywords($meta, $tplname)
	{
		if (!array_key_exists($tplname, $meta['screens']))
		{
			return '';
		}

		// 共通キーワード追加
		$keywords = $meta['keywords'];

		// 画面毎のキーワード追加
		$tmp = $meta['screens'][$tplname];
		$idx = count($keywords);
		if (is_numeric($tmp[1][0]))
		{
			$idx = $tmp[1][0];
		}
		array_splice($keywords, $idx, null, $tmp[1][1]);

		// 動的キーワード追加
		$add_keys = $this->_custom_keyword[0];
		if (count($add_keys) > 0)
		{
			array_splice($keywords, $this->_custom_keyword[1], null, $add_keys);
		}

		$tmp = implode(',', $keywords);
		$this->template->set_global('keywords', $tmp);
	}

	protected function set_description($meta, $tplname)
	{
		if (!array_key_exists($tplname, $meta['screens']))
		{
			return '';
		}
		$tmp = $meta['screens'][$tplname];
		$tmp = $this->_custom_description . $tmp[2] . $meta['description'];
		$this->template->set_global('description', $tmp);
	}

	protected function set_breadcrumbs($title)
	{
		/*
		  sample
		  $this->_breadcrumbs = [
		  [['B', Uri::create('admin/property')],['B', Uri::create('admin/property')],],
		  ['B', Uri::create('admin/property')],
		  'C',
		  ];
		 */

		$list = [];
		$position = 1;
		$add_title = true;
		foreach ($this->_breadcrumbs as $item)
		{
			if (is_array($item))
			{
				if (is_array(@$item[0]))
				{
					$tmp = [];
					foreach ($item as $parts)
					{
						$tmp[] = '<a itemprop="item" href="' . $parts[1] . '">'
								. '<span itemprop="name">' . $parts[0] . '</span>'
								. '</a>';
					}
					$list[] = implode('／', $tmp)//&nbsp;
							. '<meta itemprop="position" content="' . $position . '" />';
				}
				else
				{
					$list[] = '<a itemprop="item" href="' . $item[1] . '">'
							. '<span itemprop="name">' . $item[0] . '</span>'
							. '</a>'
							. '<meta itemprop="position" content="' . $position . '" />';
				}
			}
			else
			{

				$list[] = '<a itemprop="item" href="#">'
						. '<span itemprop="name">' . $item . '</span>'
						. '</a>'
						. '<meta itemprop="position" content="' . $position . '" />';
				$add_title = false;
			}
			$position++;
		}

		if ($add_title && !empty($title))
		{

			$list[] = '<a itemprop="item" href="#">'
					. '<span itemprop="name">' . $title . '</span>'
					. '</a>'
					. '<meta itemprop="position" content="' . $position . '" />';
		}

		$html = '<ul id="breadcrumbs-three" itemscope itemtype="http://schema.org/BreadcrumbList">'
				. '<li itemprop="itemListElement" itemscope itemtype="http://schema.org/ListItem">'
				. implode('</li><li itemprop="itemListElement" itemscope itemtype="http://schema.org/ListItem">', $list)
				. '</li>'
				. '</ul>';

		$this->template->set_safe('breadcrumb', $html);
	}

	protected function set_assets($tplname)
	{
		//Log::info('screen：' . $screen);
		if (Asset::find_file($tplname . '.css', 'css'))
		{
			$this->template->set_safe('page_css', Asset::css($tplname . '.css'));
		}
		else
		{
			$this->template->set_safe('page_css', '');
		}

		if (Asset::find_file($tplname . '.js', 'js'))
		{
			$this->template->set_safe('page_js', Asset::js($tplname . '.js'));
		}
		else
		{
			$this->template->set_safe('page_js', '');
		}
	}

	protected function is_post()
	{
		return (Input::method() == 'POST');
	}

	protected function verify_criteria($form)
	{
		$val = $form->validation();
		if (!$val->run())
		{
			$this->msg($val);
			return false;
		}
		return $val->validated();
	}

	protected function verify_csrf()
	{
		if (!Security::check_token())
		{
			Logger::error(new Exception('CSRF Error'));
			Response::redirect('/');
		}
	}

	protected function verify($form, $through = false)
	{

		$val = $form->validation();
		if (!$val->run())
		{
			$this->msg($val);
			if ($through)
			{
				return $val->input();
			}
			else
			{
				return false;
			}
		}
		return $val->validated();
	}

	protected function msg($obj)
	{
		if ($obj instanceof Validation)
		{
			foreach ($obj->error() as $field => $err)
			{
				$this->_messages[$field] = $err->get_message();
			}
		}
		elseif (is_array($obj))
		{
			foreach ($obj as $field => $err)
			{
				$this->_messages[$field] = $err;
			}
		}
		else
		{
			$this->_messages['other'] = $obj;
		}
	}

	protected function has_error()
	{
		return count($this->_messages) > 0;
	}

	protected function set_info($msg)
	{
		$this->template->set_global('info', $msg);
	}

	protected function get_criteria($in, $initialize = [])
	{
		$bt = debug_backtrace();
		$key = $bt[1]['class'] . '/' . $bt[1]['function'];

		$c = Util::get_cookie($key);
		$c = empty($c) ? [] : $c;
		if (count($in) > 0)
		{
			// 初期表示の場合
			if (!empty($in['init']))
			{
				$in = $initialize;
			}

			// 不要条件を取り除く
			$disuse = array_diff_key($c, $in);
			foreach ($disuse as $k => $v)
			{
				unset($c[$k]);
			}
		}
		$c = array_merge($c, $in);
		Util::set_cookie($key, $c);

		return $c;
	}

	protected function transaction($action)
	{
		DB::start_transaction();
		try
		{
			$res = $this->$action();
			if (!$res)
			{
				DB::rollback_transaction();
				return false;
			}
			DB::commit_transaction();
		}
		catch (Exception $e)
		{
			DB::rollback_transaction();
			throw new \HttpServerErrorException();
		}
	}

	protected function get_upload_file($config)
	{
		try
		{
			Upload::process($config);
		}
		catch (Exception $e)
		{
			return null; // 未ログイン = アップロードなし = なにもしない
		}

		if (!Upload::is_valid())
		{
			$files = Upload::get_errors();
			foreach ($files as $f)
			{
				foreach ($f['errors'] as $e)
				{
					if ($e['error'] == 4)
					{
						// no upload
						continue;
					}
					else
					{
						$this->set_error([$f['field'] => 'ファイル形式が不正です'], true);
					}
				}
			}

			if ($this->has_error())
			{
				return false;
			}
		}

		return Upload::get_files();
	}

	/* public function special()
	  {
	  $action = $this->request->action;
	  $tmp = explode('_', $action);
	  $type = $tmp[count($tmp) - 1];

	  switch ($type)
	  {
	  case 'do':
	  $action = 'action_' . $action . '_transaction';
	  if (is_callable([$this, $action]))
	  {
	  DB::start_transaction();
	  try
	  {
	  $view = $this->$action();
	  if (!$view)
	  {
	  throw new Exception();
	  }
	  DB::commit_transaction();
	  }
	  catch (Exception $e)
	  {
	  DB::rollback_transaction();
	  }
	  }
	  else
	  {
	  throw new \HttpNotFoundException();
	  }
	  break;
	  default:
	  break;
	  }

	  $this->template->content = $view;
	  } */
}
