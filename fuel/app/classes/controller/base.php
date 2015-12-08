<?php

class Controller_Base extends Controller_Template
{

    protected $_errors = [];
    protected $_action = '';
    protected $_screen = '';
    protected $_custom_title = '';
    protected $_custom_keyword = [[], 0];
    protected $_custom_description = '';
    protected $_h1 = '';
    protected $_breadcrumb = [];

    public function pre($type)
    {
	Config::load('base');

	$this->_action = $this->action_name();
	$this->debug_param();


	$tmp = Config::get($type.'.ssl');
	if (Input::protocol() == 'http')
	{
	    $ssl = false;
	    if (array_key_exists('on', $tmp))
	    {
		$ssl = in_array($this->_action, $tmp['on']);
	    }
	    else
	    {
		$ssl = !in_array($this->_action, $tmp['off']);
	    }
	    if ($ssl)
	    {
		$url = Uri::create(Input::uri(), [], [], true);
		Log::info('http2https：'.$url);
		return Response::redirect($url);
	    }
	}
	else if (Input::protocol() == 'https')
	{
	    $http = false;
	    if (array_key_exists('on', $tmp))
	    {
		$http = !in_array($this->_action, $tmp['on']);
	    }
	    else
	    {
		$http = in_array($this->_action, $tmp['off']);
	    }
	    if ($http)
	    {
		$url = Uri::create(Input::uri(), [], [], false);
		Log::info('https2http：'.$url);
		return Response::redirect($url);
	    }
	}

	$no_auth_action = Config::get($type.'.auth');
	$path = ($type == 'site') ? '' : $type;
	if ($this->is_login())
	{
	    $act = array_diff($no_auth_action, $both_auth_action);
	    if (in_array($this->_action, $act))
	    {
		return Response::redirect($path);
	    }
	}
	else
	{
	    if (!in_array($this->_action, $no_auth_action))
	    {
		return Response::redirect($path.'/auth');
	    }
	}
    }

    public function post($type)
    {
	// screen
	$view = $this->template->content;
	$screen = $view->tplname();
	Log::info($screen);
	$sInfo = Config::get($type.'.screen_info');
	$this->template->set_global('screen', str_replace('/', '-', $screen));
	$this->template->set_global('title', $this->get_title($screen, $this->_custom_title, $type));
	$this->template->set_global('keywords', $this->get_keywords($screen, $this->_custom_keyword, $type));
	$this->template->set_global('description', $this->get_description($screen, $this->_custom_description, $type));
	$this->template->set_global('screentitle', @$sInfo[$screen][0]);
	$this->template->set_safe('breadcrumb', $this->get_breadcrumb(@$sInfo[$screen][0]));
	$this->template->set_safe('h1', $this->_h1);
	$this->template->set_global('status_code', $this->response_status);
	$this->set_assets($screen);

	// error
	$this->template->set_global('errors', $this->_errors);

	// device
	$this->template->set_global('device', Common::get_device());

	// login
	$this->template->set_global('login', $this->is_login());
	$this->template->set_global('user', $this->get_user());
    }

    public function after($response)
    {
	if (false)
	{
	    // キャッシュさせない（ブラウザバックなどでリロードさせたい場合があるため）
	    $response->set_header('Cache-Control', 'no-cache, no-store, max-age=0, must-revalidate');
	    $response->set_header('Expires', 'Mon, 26 Jul 1997 05:00:00 GMT');
	    $response->set_header('Pragma', 'no-cache');
	}
	return $response;
    }

    public function get_title($screen, $custom_title, $site = 'site')
    {
	$sInfo = Config::get($site.'.screen_info');
	if (!array_key_exists($screen, $sInfo))
	{
	    return '';
	}

	$tmp = $sInfo[$screen];
	$tmp = $custom_title.$tmp[0];
	$commonTitle = Config::get($site.'.common_title');
	$siteName = empty($tmp) ? $commonTitle : (empty($commonTitle) ? '' : '｜'.$commonTitle);
	$tmp = $tmp.$siteName;
	return $tmp;
    }

    public function get_keywords($screen, $custom_keyword, $site = 'site')
    {
	$sInfo = Config::get($site.'.screen_info');
	if (!array_key_exists($screen, $sInfo))
	{
	    return '';
	}

	// 共通キーワード追加
	$keywords = Config::get($site.'.common_keywords');

	// 画面毎のキーワード追加
	$tmp = $sInfo[$screen];
	$idx = count($keywords);
	if (is_numeric($tmp[1][0]))
	{
	    $idx = $tmp[1][0];
	}
	array_splice($keywords, $idx, null, $tmp[1][1]);

	// 動的キーワード追加
	$addKeys = $custom_keyword[0];
	if (count($addKeys) > 0)
	{
	    array_splice($keywords, $custom_keyword[1], null, $addKeys);
	}

	return implode(',', $keywords);
    }

    public function get_description($screen, $custom_description, $site = 'site')
    {
	$sInfo = Config::get($site.'.screen_info');
	if (!array_key_exists($screen, $sInfo))
	{
	    return '';
	}

	$tmp = $sInfo[$screen];
	$tmp = $custom_description.$tmp[2].Config::get($site.'.common_description');
	return $tmp;
    }

    protected function get_breadcrumb($title)
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

	return $html;
    }

    protected function set_assets($screen)
    {
	//Log::info('screen：' . $screen);
	if (Asset::find_file($screen.'.css', 'css'))
	{
	    $this->template->set_safe('page_css', Asset::css($screen.'.css'));
	}
	else
	{
	    $this->template->set_safe('page_css', '');
	}

	if (Asset::find_file($screen.'.js', 'js'))
	{
	    $this->template->set_safe('page_js', Asset::js($screen.'.js'));
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

    protected function debug_param()
    {
	Log::info('ACTION：'.$this->_action);
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

    public function action_name()
    {
	return strtolower(str_replace('Controller_', '', $this->request->controller.'_'.$this->request->action));
    }

}
