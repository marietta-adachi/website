<!DOCTYPE html>
<html lang="ja">
	<head>
		<meta charset="utf-8">
		<meta http-equiv="X-UA-Compatible" content="IE=edge">
		<meta name="viewport" content="width=device-width, initial-scale=1">
		<!-- The above 3 meta tags *must* come first in the head; any other head content must come *after* these tags -->
		<title>{$title}</title>
		<meta name="description" content="{$description}"/>
		<meta name="keywords" content="{$keywords}"/>

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


		{Asset::css('bootstrap/css/bootstrap.min.css')}
		{Asset::css('bootstrap/css/dashboard.css')}
		{Asset::css('base.css')}
		{Asset::js('bootstrap/js/bootstrap.min.js')}
		{Asset::js('jquery-1.11.3.min.js')}
		
		
		
		
		{*if !empty($facebook)}
		<meta property="og:title" content="{$facebook.title}" />
		<meta property="og:type" content="{$facebook.type}" />
		<meta property="og:description" content="{$facebook.description}" />
		<meta property="og:url" content="{$facebook.url}" />
		<meta property="og:image" content="{$facebook.image}" />
		<meta property="og:site_name" content="{$facebook.site_name}" />
		{/if*}

		<script type="text/javascript">
			var base_url = "{Uri::create("/")}";
		</script>
		{Security::js_fetch_token()}
	</head>
	<body id="{$screen}">
		{* Google tag manager *}
		{literal}
		{/literal}
		<input type="hidden" id="message" value="{$info|default:''}"/>
		{if Config::get("site.meta.display")}
			<font size="1">device：　{$device}<br/>title：　{$title}<br/>description：　{$description}<br/>keywords：　{$keywords}<br/>h1：　{$h1|default:""}<br/></font>
		{/if}

		<header>
		</header>

		{$content}

		<footer itemscope itemtype="http://schema.org/WPFooter">
		</footer>
	</body>
</html>