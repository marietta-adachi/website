<!DOCTYPE html>
<html lang="ja" xml:lang="ja" xmlns="http://www.w3.org/1999/xhtml" xmlns:og="http://ogp.me/ns#" xmlns:fb="http://www.facebook.com/2008/fbml">
    <head>
		<meta charset="utf-8"/>
		<title>{$title}</title>
		<meta name="description" content="{$description}"/>
		<meta name="keywords" content="{$keywords}"/>
		<!--[if IE]>
		<script src="//cdnjs.cloudflare.com/ajax/libs/html5shiv/3.7/html5shiv.min.js"></script>
		<![endif]-->

		{* assetsへのパス *}
		{Asset::add_path("assets/lib/","js")}
		{Asset::add_path("assets/lib/","css")}
		{Asset::add_path("assets/font/","css")}


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
