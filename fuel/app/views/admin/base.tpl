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

		{* GENTELELLA *}
		<!-- Bootstrap core CSS -->
		{Asset::css('gentelella/production/css/bootstrap.min.css')}
		{Asset::css('gentelella/production/fonts/css/font-awesome.min.css')}
		{Asset::css('gentelella/production/css/animate.min.css')}
		<!-- Custom styling plus plugins -->
		{Asset::css('gentelella/production/css/custom.css')}
		{Asset::css('gentelella/production/css/icheck/flat/green.css')}
		<!-- JS -->
		{Asset::js('gentelella/production/js/jquery.min.js')}
		{Asset::js('gentelella/production/js/custom.js')}


		{* CSS *********************************************************************************}
		{$page_css}
		{Asset::css('base.css')}
		{Asset::css('admin/base.css')}

		{* JS *********************************************************************************}
		<script id="{$screen}-js" data-params="{$page_params|default}">
			var pageParams;
			$(function () {
				pageParams = $('#{$screen}-js').data('params');
			});
		</script>
		{Asset::js('base.js')}
		{$page_js}
	</head>

	<body class="nav-md">
		{if !$login || $screen == 'error/404' || $screen == 'error/404'}
			{$content}
		{else}
			<div class="container body">
				<div class="main_container">
					<div class="col-md-3 left_col">
						{$menu}
					</div>
					<!--div class="top_nav">
						{$top}
					</div-->
					<div class="right_col" role="main">
						<div class="{$screen}">
							{$header}
							<div class="row">
								{$content}
							</div>
						</div>
						{$footer}
					</div>
					<input type="hidden" id="message" value="{$info|default}">
				</div>
			</div>
		{/if}
	</body>
	
</html>
