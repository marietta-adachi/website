<!DOCTYPE html>
<html>
<head>
	<meta charset="utf-8">
	<meta http-equiv="X-UA-Compatible" content="IE=edge">
	<meta name="SKYPE_TOOLBAR" content="SKYPE_TOOLBAR_PARSER_COMPATIBLE" />
	<meta name="format-detection" content="telephone=no" />
	<meta name="viewport" content="width=device-width, initial-scale=1.0" />
	{*<meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1, user-scalable=no" />*}
	<meta name="author" content="MARIETTA">
	<meta http-equiv="Pragma" content="no-cache">
	<meta http-equiv="Cache-Control" content="no-cache">
	<title>{$title}</title>
{*	<meta name='keywords' content='{$keywords}'>*}
{*	<meta name='description' content='{$description}'>*}

	{* その他assetsへのパスを定義 *}
	{Asset::add_path("assets/lib/","js")}
	{Asset::add_path("assets/lib/","css")}
	{Asset::add_path("assets/font/","css")}
	
	{* FAVICON *}
	<link rel="apple-touch-icon-precomposed" href="{Uri::base()}assets/img/common/icon_512.png" />
	<link rel="apple-touch-icon" href="{Uri::base()}assets/img/common/icon_57.png" />
	<link rel="shortcut icon" href="{Uri::base()}favicon.ico" type="image/vnd.microsoft.icon" />
	<link rel="icon" href="{Uri::base()}favicon.ico" type="image/vnd.microsoft.icon" />

	{* CSS *}
	{Asset::css("https://fonts.googleapis.com/css?family=Open+Sans")}
	{Asset::css("bootstrap-3.3.5-dist/css/bootstrap.css")}
{*	{Asset::css("bootstrap-3.3.5-dist/css/non-responsive.css")}*}
	{Asset::css("bootstrap-3.3.5-dist/custom.css")}
	{Asset::css("jquery-ui-1.11.4/jquery-ui.min.css")}
	{Asset::css("datetimepicker-master/jquery.datetimepicker.css")}
	{Asset::css("btn_custom.css")}
	{Asset::css("base.css")}
	{Asset::css("common.css")}
	{Asset::css("admin.css")}
	{$page_css}

	{*{if $device!="other"}
	<link type="text/css" media="screen and (orientation:portrait)" rel="stylesheet" href="{Uri::create("assets/css/portrait.css")}" class="cssfx" />
	{/if}*}

	{* FONT *}
	{Asset::css("font-awesome-4.2.0/css/font-awesome.min.css")}


	{* JS *}
	{Asset::js("jquery-1.11.0.js")}
	{Asset::js("jquery-ui-1.11.4/jquery-ui.min.js")}
	{Asset::js("datetimepicker-master/jquery.datetimepicker.js")}
	{Asset::js("bootstrap-3.3.5-dist/js/bootstrap.min.js")}
	{Asset::js("base.js")}
	{Asset::js("jquery.metisMenu.js")}
	{Asset::js("custom.js")}
	{$page_js}

	<!--[if lt IE 9]>
	{*Asset::js("lib/respond.min.js")*}
	{*Asset::js("lib/html5shiv.min.js")*}
	{*Asset::js("lib/cssfx.js")*}
	<![endif]-->

	<script type="text/javascript">
		var base_url = "{Uri::create("admin/")}";
	</script>
	{Security::js_fetch_token()}

</head>
{*$device*}
<body id="{$screen}">
	<div id="loading"><img src="{Uri::create("assets/img/common/loading.gif")}" ></div>
	<input type="hidden" id="message" value="{$info|default:''}">{* 更新後のメッセージ表示用 *}
	<div id="wrapper" class="theme">
		<nav class="navbar navbar-default navbar-cls-top " role="navigation" style="margin-bottom: 0">
			<div class="navbar-header">
{if $login}
				<button type="button" class="navbar-toggle theme" data-toggle="collapse" data-target=".sidebar-collapse">
					<span class="sr-only">Toggle navigation</span>
					<span class="icon-bar"></span>
					<span class="icon-bar"></span>
					<span class="icon-bar"></span>
				</button>{/if}
				<h1>
					<a class="navbar-brand" href="{Uri::create("admin")}"><img width="200" src="{Uri::create("assets/img/common/logo.png")}" alt="" ></a>
				</h1>
			</div>
{if $login}
			<div class="btn-box hidden-xs">
				<a href="{Uri::create("admin/auth/logout/{$admin_id}")}" class="btn btn-default">ログアウト</a>
			</div>
{/if}
		</nav>
{if $login}
		<nav class="navbar-default navbar-side" role="navigation">
			<div class="sidebar-collapse">
				<ul class="nav theme" id="main-menu">
					<li class="thumb_box">
						<img src="{Uri::create("assets/img/admin/find_user.png")}" class="user-image img-responsive" alt="{$admin_name}さん" >
						<span class="user-name">{$admin_name}さん</span>
					</li>
					<li {if preg_match("/^admin-hospital(|-.*)$/",$screen)}class="select"{/if}>
						<a class="active-menu" href="{Uri::create("admin/hospital")}"><i class="fa fa-hospital-o"></i>病院管理</a>
					</li>
					<li {if preg_match("/^admin-hospitalimport(|-.*)$/",$screen)}class="select"{/if}>
						<a class="active-menu" href="{Uri::create("admin/hospitalimport")}"><i class="fa fa-file-excel-o"></i>病院CSVインポート</a>
					</li>
					<li {if preg_match("/^admin-review(|-.*)$/",$screen)}class="select"{/if}>
						<a class="active-menu" href="{Uri::create("admin/review")}"><i class="fa fa-comment-o"></i>口コミ管理</a>
					</li>
					<li {if preg_match("/^admin-setting(|-.*)$/",$screen)}class="select"{/if}>
						<a class="active-menu" href="{Uri::create("admin/setting")}"><i class="fa fa-cog"></i>設定</a>
					</li>
					<li class="visible-xs">
						<a href="{Uri::create("admin/auth/logout/{$admin_id}")}"><i class="fa fa-sign-out"></i>ログアウト</a>
					</li>
				</ul>
			</div>
		</nav>
{/if}

		{* コンテンツ *}
		<div id="page-wrapper">
			<div id="page-inner">
				<div class="row">
					<div class="col-md-12 title_box">
						<h2 class="theme_txt title">{$breadcrumb}{*<a href="#">業者一覧</a>&nbsp;<span class="next">＞</span>&nbsp;<span>業者情報登録完了</span>*}</h2>
						{*<h5></h5>*}
					</div>
				</div>
				<hr>
			{*
			<h3>{$screentitle}</h3>
			{$breadcrumb}
			*}
			<small>{$content}</small>
			</div>
		</div>
		{* フッタ *}
		<footer class="theme_txt">
			
		</footer>
	</div>
</body>
</html>