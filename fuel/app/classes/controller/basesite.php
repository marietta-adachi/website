<?php

class Controller_Basesite extends Controller_Base
{

    public $template = 'base';

    public function before()
    {
	parent::before();
	$this->pre('site');
    }

    public function after($response)
    {
	parent::after($response);
	$this->post('site');
	//$this->set_facebook();
	//$this->set_twitter();
	return $response;
    }

    protected function is_login()
    {
	$tmp = $this->get_user();
	return !empty($tmp);
    }

    protected function get_user()
    {
	$tmp = Session::get('user');
	return $tmp;
    }

    protected function set_facebook($url = '', $image = '', $title = '', $description = '', $article = false)
    {
	$title = empty($title) ? Config::get('facebook.title') : $title;
	$description = empty($discription) ? Config::get('facebook.description') : $description;
	$url = empty($url) ? Uri::create('/', [], [], false) : $url;
	$image = empty($image) ? Uri::create('assets/img/common/logo_facebook.png', [], [], false) : $image;
	$type = $article ? 'article' : 'website';

	$ogp = array(
	    'title' => $title,
	    'type' => $type,
	    'description' => $description,
	    'url' => $url,
	    'image' => $image,
	    'site_name' => Config::get('system.name'),
	);

	$this->template->set_global('ogp', $ogp);
    }

    protected function set_twitter($title = '', $tags = [], $url = '')
    {
	$title = empty($title) ? Config::get('twitter.title') : $title;
	$tags = count($tags) == 0 ? Config::get('twitter.tags') : $tags;

	$twitter = array(
	    'title' => $title,
	    'tags' => implode(',', $tags),
	    'url' => empty($url) ? Uri::create('/', [], [], false) : $url,
	);

	$this->template->set_global('twitter', $twitter);
    }

}
