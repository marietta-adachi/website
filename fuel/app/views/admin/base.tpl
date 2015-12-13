<!DOCTYPE html>
<html lang="ja">
	<head>
		<meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
		<!-- Meta, title, CSS, favicons, etc. -->
		<meta charset="utf-8">
		<meta http-equiv="X-UA-Compatible" content="IE=edge">
		<meta name="viewport" content="width=device-width, initial-scale=1">

		<title>{$title|default}</title>
		<base href="{Uri::base()}">
		
		<!--[if lt IE 9]>
			<script src="../assets/js/ie8-responsive-file-warning.js"></script>
		<![endif]-->

		<!-- HTML5 shim and Respond.js for IE8 support of HTML5 elements and media queries -->
		<!--[if lt IE 9]>
			<script src="https://oss.maxcdn.com/html5shiv/3.7.2/html5shiv.min.js"></script>
			<script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
		<![endif]-->
		
		{Asset::add_path('assets/lib/','js')}
		{Asset::add_path('assets/lib/','css')}
		{Asset::add_path('assets/font/','css')}
		
		{* Bootstrap *}
		<!-- Bootstrap core CSS -->
		{Asset::css('gentelella/production/css/bootstrap.min.css')}
		{Asset::css('gentelella/production/fonts/css/font-awesome.min.css')}
		{Asset::css('gentelella/production/css/animate.min.css')}

		<!-- Custom styling plus plugins -->
		{Asset::css('gentelella/production/css/custom.css')}
		{Asset::css('gentelella/production/css/icheck/flat/green.css')}
		
		{Asset::js('gentelella/production/js/jquery.min.js')}
		{Asset::js('gentelella/production/js/custom.js')}
		
		
		{* CSS *}
		{Asset::css('base.css')}
		{Asset::css('admin/base.css')}
		{$page_css}

		{* JS *}
		{*Asset::js('jquery-2.1.4.min.js')*}
		{Asset::js('base.js')}
		{$page_js}
		
	</head>


	<body class="nav-md">
		<input type="hidden" id="message" value="{$info|default}">
		<div class="container body">
			<div class="main_container">
				
				{if $login || $screen == 'error/404' || $screen == 'error/404'}
					{$content}
				{else}
					<div class="col-md-3 left_col">
						{$menu}
					</div>

					<!-- top navigation -->
					<div class="top_nav">
						{$top}
					</div>
					<!-- /top navigation -->

					<!-- page content -->
					<div class="right_col" role="main">
						<div class="{$screen}">

							{$header}

							<div class="row">
								{$content}
							</div>

						</div>

						{$footer}

					</div>
					<!-- /page content -->
				{/if}
			</div>
		</div>
	</body>
</html>
