<?php

class Controller_Base_Site extends Controller_Base_Tpl
{

	public $template = 'base';

	public function after($response)
	{
		$response = parent::after($response);
		$this->post($this->template->content->tplname());
		return $response;
	}

	protected function is_login()
	{
		return !empty(Model_Db_User::by_session());
	}

	protected function get_user()
	{
		return Model_Db_User::by_session();
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
