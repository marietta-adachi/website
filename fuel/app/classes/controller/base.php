<?php

class Controller_Base extends Controller_Template
{

    protected $_custom_title = '';
    protected $_custom_keyword = [[], 0];
    protected $_custom_description = '';
    protected $_breadcrumb = [];
    protected $_h1 = '';
    protected $_errors = [];

    public function pre($type)
    {
	Config::load('base');

	$action = strtolower(str_replace('Controller_', '', $this->request->controller.'_'.$this->request->action));
	$this->debug_param($action);


	$tmp = Config::get($type.'.ssl');
	if (Input::protocol() == 'http')
	{
	    $ssl = false;
	    if (array_key_exists('on', $tmp))
	    {
		$ssl = in_array($action, $tmp['on']);
	    }
	    else
	    {
		$ssl = !in_array($action, $tmp['off']);
	    }
	    if ($ssl)
	    {
		$url = Uri::create(Input::uri(), [], [], true);
		Log::info('HTTPS Redirect : '.$url);
		return Response::redirect($url);
	    }
	}
	else if (Input::protocol() == 'https')
	{
	    $http = false;
	    if (array_key_exists('on', $tmp))
	    {
		$http = !in_array($action, $tmp['on']);
	    }
	    else
	    {
		$http = in_array($action, $tmp['off']);
	    }
	    if ($http)
	    {
		$url = Uri::create(Input::uri(), [], [], false);
		Log::info('HTTP Redirect : '.$url);
		return Response::redirect($url);
	    }
	}

	// authentication
	$no_auth_action = Config::get($type.'.auth');
	$path = ($type == 'site') ? '' : $type;
	if ($this->is_login())
	{
	    $act = array_diff($no_auth_action, $both_auth_action);
	    if (in_array($action, $act))
	    {
		return Response::redirect($path);
	    }
	}
	else
	{
	    if (!in_array($action, $no_auth_action))
	    {
		return Response::redirect($path.'/auth');
	    }
	}
    }

    public function post($type)
    {
	// screen
	$tplname = $this->template->content->tplname();
	Log::info($tplname);
	$meta = Config::get($type.'.meta');

	$this->set_assets($tplname);

	// TDHK
	$this->set_title($meta, $tplname);
	$this->set_keywords($meta, $tplname);
	$this->set_description($meta, $tplname);
	$this->set_breadcrumb(@$meta['screens'][$tplname][0]);
	$this->template->set_safe('h1', $this->_h1);

	$this->template->set_global('screen', str_replace('/', '-', $tplname));
	$this->template->set_global('screentitle', @$meta['screens'][$tplname][0]);
	$this->template->set_global('status_code', $this->response_status);

	// error
	$this->template->set_global('errors', $this->_errors);

	// device
	$this->template->set_global('device', Common::get_device());

	// login
	$this->template->set_global('login', $this->is_login());
	$this->template->set_global('user', $this->get_user());
    }

    public function set_title($meta, $tplname)
    {
	if (!array_key_exists($tplname, $meta['screens']))
	{
	    return '';
	}

	$tmp = $meta['screens'][$tplname];
	$tmp = $this->_custom_title.$tmp[0];
	$title = $meta['title'];
	$siteName = empty($tmp) ? $title : (empty($title) ? '' : '｜'.$title);
	$tmp = $tmp.$siteName;
	$this->template->set_global('title', $tmp);
    }

    public function set_keywords($meta, $tplname)
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

    public function set_description($meta, $tplname)
    {
	if (!array_key_exists($tplname, $meta['screens']))
	{
	    return '';
	}
	$tmp = $meta['screens'][$tplname];
	$tmp = $this->_custom_description.$tmp[2].$meta['description'];
	$this->template->set_global('description', $tmp);
    }

    protected function set_breadcrumb($title)
    {
	/*
	  sample
	  $list = array(
	  array(array('B', Uri::create('admin/property')),array('B', Uri::create('admin/property')),),
	  array('B', Uri::create('admin/property')),
	  'C',
	  );
	 */

	$list = [];
	$position = 1;
	$add_title = true;
	foreach ($this->_breadcrumb as $item)
	{
	    if (is_array($item))
	    {
		if (is_array(@$item[0]))
		{
		    $tmp = [];
		    foreach ($item as $parts)
		    {
			$tmp[] = '<a itemprop="item" href="'.$parts[1].'">'
				.'<span itemprop="name">'.$parts[0].'</span>'
				.'</a>';
		    }
		    $list[] = implode('／', $tmp)//&nbsp;
			    .'<meta itemprop="position" content="'.$position.'" />';
		}
		else
		{
		    $list[] = '<a itemprop="item" href="'.$item[1].'">'
			    .'<span itemprop="name">'.$item[0].'</span>'
			    .'</a>'
			    .'<meta itemprop="position" content="'.$position.'" />';
		}
	    }
	    else
	    {

		$list[] = '<a itemprop="item" href="#">'
			.'<span itemprop="name">'.$item.'</span>'
			.'</a>'
			.'<meta itemprop="position" content="'.$position.'" />';
		$add_title = false;
	    }
	    $position++;
	}

	if ($add_title && !empty($title))
	{

	    $list[] = '<a itemprop="item" href="#">'
		    .'<span itemprop="name">'.$title.'</span>'
		    .'</a>'
		    .'<meta itemprop="position" content="'.$position.'" />';
	}

	$html = '<ol id="breadcrumb" itemscope itemtype="http://schema.org/BreadcrumbList">'
		.'<li itemprop="itemListElement" itemscope itemtype="http://schema.org/ListItem">'
		.implode('</li><li itemprop="itemListElement" itemscope itemtype="http://schema.org/ListItem">', $list)
		.'</li>'
		.'</ol>';

	$this->template->set_safe('breadcrumb', $html);
    }

    protected function set_assets($tplname)
    {
	//Log::info('screen：' . $screen);
	if (Asset::find_file($tplname.'.css', 'css'))
	{
	    $this->template->set_safe('page_css', Asset::css($tplname.'.css'));
	}
	else
	{
	    $this->template->set_safe('page_css', '');
	}

	if (Asset::find_file($tplname.'.js', 'js'))
	{
	    $this->template->set_safe('page_js', Asset::js($tplname.'.js'));
	}
	else
	{
	    $this->template->set_safe('page_js', '');
	}
    }

    protected function set_info($msg)
    {
	$this->template->set_global('info', $msg);
    }

    protected function set_error($obj, $through = false)
    {
	if ($obj instanceof Validation)
	{
	    foreach ($obj->error() as $field => $err)
	    {
		$this->_errors[$field] = $err->get_message();
	    }
	}
	elseif (is_array($obj))
	{
	    foreach ($obj as $field => $err)
	    {
		$this->_errors[$field] = $err;
	    }
	}
	else
	{
	    $this->_errors['other'] = $obj;
	}

	if (!$through)
	{
	    throw new Exception();
	}
    }

    protected function check_error()
    {
	if (count($this->_errors) > 0)
	{
	    throw new Exception();
	}
    }

    protected function check_csrf($token = null)
    {
	if (!Security::check_token($token))
	{
	    Common::error(new Exception('CSRF Error'));
	    return Response::redirect('/');
	}
    }

    protected function error($e, $redirect = '/')
    {
	$msg = $e->getMessage();
	if (!empty($msg))
	{
	    Common::error($e);

	    // サーバエラーを発生し、トップへ
	    //throw new HttpServerErrorException;
	    return Response::redirect($redirect);
	}
	else
	{
	    // フォームのバリデーションエラーなので何もしない
	}
    }

    protected function init_condition($key, $value = [])
    {
	$flg = Input::param('search');
	if (empty($flg))
	{
	    //Session::set($key, $value);
	    Common::setCookie($key, $value);
	}
    }

    protected function get_condition($key, $another = [])
    {
	$pageFirst = false;

	//$c = Session::get($key);
	$c = Common::getCookie($key);

	$c = empty($c) ? [] : $c;

	// 今回の条件で不要になった条件を取り除く
	$in = array_merge(Input::param(), $another); // パラメータ以外の条件あればマージ
	if (count($in) > 0)
	{
	    $pageFirst = true;
	    $disuse = array_diff_key($c, $in); // 外された条件を抽出
	    foreach ($disuse as $k => $v)
	    {
		unset($c[$k]); // 外された分を削除
	    }
	}
	// 更に今回の条件をマージし、セッションに保存しておく
	$c = array_merge($c, $in);
	//Session::set($key, $c);
	Common::setCookie($key, $c);


	// ページャ用のgetパラメータを生成
	$param = [];
	foreach ($c as $k => $v)
	{
	    if (is_array($v))
	    {
		foreach ($v as $item)
		{
		    $param[] = $k.'[]='.$item;
		}
	    }
	    else
	    {
		if ($k == 'p')
		{
		    continue;
		}
		$param[] = $k.'='.$v;
	    }
	}
	$param = implode('&', $param);


	return [$c, @$c['order'], max(@$c['p'], 1), $param];
    }

    protected function get_upload_file($config)
    {
	try
	{
	    // アップロード処理
	    Upload::process($config);
	}
	catch (Exception $e)
	{
	    return null; // 未ログイン = アップロードなし = なにもしない
	}

	// バリデーションチェック
	if (!Upload::is_valid())
	{
	    $files = Upload::get_errors();
	    foreach ($files as $f)
	    {
		foreach ($f['errors'] as $e)
		{
		    if ($e['error'] == 4)
		    {
			// アップロードしてない場合はスルー
			continue;
		    }
		    else
		    {
			$this->set_error([$f['field'] => 'ファイル形式が不正です'], true);
		    }
		}
	    }

	    $this->checkError();
	}

	$ret = Upload::get_files();
	return $ret;
    }

    protected function debug_param($action)
    {
	Log::info('ACTION：'.$action);
	foreach (Input::all() as $k => $v)
	{
	    if (is_array($v))
	    {
		foreach ($v as $k2 => $v2)
		{
		    Log::info($k.'：'.$v2);
		}
	    }
	    else
	    {
		Log::info($k.'：'.$v);
	    }
	}

	// routes.phpの名前付きパラメータ確認
	foreach ($this->params() as $k => $v)
	{
	    Log::info($k.'：'.$v);
	}
    }

}
