<!DOCTYPE html>
<html lang="ja">
	<head>
		<meta charset="utf-8">
		<meta http-equiv="X-UA-Compatible" content="IE=edge">
		<meta name="viewport" content="width=device-width, initial-scale=1">
		<!-- The above 3 meta tags *must* come first in the head; any other head content must come *after* these tags -->
		<title>{$title|default}</title>
		<meta name="description" content="{$description|default}"/>
		<meta name="keywords" content="{$keywords|default}"/>
		<base href="{Uri::base()}">

		<!-- Bootstrap -->
		<link href="css/bootstrap.min.css" rel="stylesheet">

		<!-- HTML5 shim and Respond.js for IE8 support of HTML5 elements and media queries -->
		<!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
		<!--[if lt IE 9]>
		  <script src="https://oss.maxcdn.com/html5shiv/3.7.2/html5shiv.min.js"></script>
		  <script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
		<![endif]-->

		{* assetsへのパス *}
		{Asset::add_path("assets/lib/","js")}
		{Asset::add_path("assets/lib/","css")}
		{Asset::add_path("assets/font/","css")}


		{* CSS ********************************************************************************}
		{Asset::css('bootstrap/css/bootstrap.min.css')}
		{Asset::css('bootstrap/css/dashboard.css')}
		
		{Asset::css('base.css')}
		{Asset::css('admin/base.css')}
		{$page_css}
		
		

		{* JS *********************************************************************************}
		{Asset::js('bootstrap/js/bootstrap.min.js')}
		{Asset::js('jquery-1.11.3.min.js')}
		
		{Asset::js('base.js')}
		{$page_js}
		<script id="{$screen}-js" data-params="{$js_params|default}">
			var pageParams;
			$(function () {
				pageParams = $('#{$screen}-js').data('params');
			});
		</script>
	</head>
	<body id="{$screen}">
		
		
		{if !$login || $screen == 'error/404' || $screen == 'error/404'}
			{$content}
		{else}
			<nav class="navbar navbar-inverse navbar-fixed-top">
				<div class="container-fluid">
					{$header}
				</div>
			</nav>

			<div class="container-fluid">
				<div class="row">
					{$menu}
					<div class="col-sm-9 col-sm-offset-3 col-md-10 col-md-offset-2 main">
						{$content}
						<input type="hidden" id="message" value="{$info|default}"/>
					</div>
				</div>
			</div>

		{/if}


		<!--div class="mastfoot">
			<p class="pull-right">CopyRight (c) 2004- Marietta Corporation All Rights Reserved.</p>
		</div-->


	</body>
</html>