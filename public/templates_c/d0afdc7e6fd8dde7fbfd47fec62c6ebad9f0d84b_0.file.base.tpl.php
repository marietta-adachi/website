<?php
/* Smarty version 3.1.28-dev/77, created on 2015-12-08 13:48:48
  from "D:\workspace\website\fuel\app\views\admin\base.tpl" */

if ($_smarty_tpl->smarty->ext->_validateCompiled->decodeProperties($_smarty_tpl, array (
  'has_nocache_code' => false,
  'version' => '3.1.28-dev/77',
  'unifunc' => 'content_5666d1b09991b6_47268529',
  'file_dependency' => 
  array (
    'd0afdc7e6fd8dde7fbfd47fec62c6ebad9f0d84b' => 
    array (
      0 => 'D:\\workspace\\website\\fuel\\app\\views\\admin\\base.tpl',
      1 => 1449555313,
      2 => 'file',
    ),
  ),
  'includes' => 
  array (
  ),
),false)) {
function content_5666d1b09991b6_47268529 ($_smarty_tpl) {
?>
<!DOCTYPE html>
<html>
<head>
	<meta charset="utf-8">
	<meta http-equiv="X-UA-Compatible" content="IE=edge">
	<meta name="SKYPE_TOOLBAR" content="SKYPE_TOOLBAR_PARSER_COMPATIBLE" />
	<meta name="format-detection" content="telephone=no" />
	<meta name="viewport" content="width=device-width, initial-scale=1.0" />
	
	<meta name="author" content="MARIETTA">
	<meta http-equiv="Pragma" content="no-cache">
	<meta http-equiv="Cache-Control" content="no-cache">
	<title><?php echo $_smarty_tpl->tpl_vars['title']->value;?>
</title>



	
	<?php echo Asset::add_path("assets/lib/","js");?>

	<?php echo Asset::add_path("assets/lib/","css");?>

	<?php echo Asset::add_path("assets/font/","css");?>

	
	
	<link rel="apple-touch-icon-precomposed" href="<?php echo Uri::base();?>
assets/img/common/icon_512.png" />
	<link rel="apple-touch-icon" href="<?php echo Uri::base();?>
assets/img/common/icon_57.png" />
	<link rel="shortcut icon" href="<?php echo Uri::base();?>
favicon.ico" type="image/vnd.microsoft.icon" />
	<link rel="icon" href="<?php echo Uri::base();?>
favicon.ico" type="image/vnd.microsoft.icon" />

	
	<?php echo Asset::css("https://fonts.googleapis.com/css?family=Open+Sans");?>

	<?php echo Asset::css("bootstrap-3.3.5-dist/css/bootstrap.css");?>


	<?php echo Asset::css("bootstrap-3.3.5-dist/custom.css");?>

	<?php echo Asset::css("jquery-ui-1.11.4/jquery-ui.min.css");?>

	<?php echo Asset::css("datetimepicker-master/jquery.datetimepicker.css");?>

	<?php echo Asset::css("btn_custom.css");?>

	<?php echo Asset::css("base.css");?>

	<?php echo Asset::css("common.css");?>

	<?php echo Asset::css("admin.css");?>

	<?php echo $_smarty_tpl->tpl_vars['page_css']->value;?>


	

	
	<?php echo Asset::css("font-awesome-4.2.0/css/font-awesome.min.css");?>



	
	<?php echo Asset::js("jquery-1.11.0.js");?>

	<?php echo Asset::js("jquery-ui-1.11.4/jquery-ui.min.js");?>

	<?php echo Asset::js("datetimepicker-master/jquery.datetimepicker.js");?>

	<?php echo Asset::js("bootstrap-3.3.5-dist/js/bootstrap.min.js");?>

	<?php echo Asset::js("base.js");?>

	<?php echo Asset::js("jquery.metisMenu.js");?>

	<?php echo Asset::js("custom.js");?>

	<?php echo $_smarty_tpl->tpl_vars['page_js']->value;?>


	<!--[if lt IE 9]>
	
	
	
	<![endif]-->

	<?php echo '<script'; ?>
 type="text/javascript">
		var base_url = "<?php echo Uri::create("admin/");?>
";
	<?php echo '</script'; ?>
>
	<?php echo Security::js_fetch_token();?>


</head>

<body id="<?php echo $_smarty_tpl->tpl_vars['screen']->value;?>
">
	<div id="loading"><img src="<?php echo Uri::create("assets/img/common/loading.gif");?>
" ></div>
	<input type="hidden" id="message" value="<?php echo (($tmp = @$_smarty_tpl->tpl_vars['info']->value)===null||$tmp==='' ? '' : $tmp);?>
">
	<div id="wrapper" class="theme">
		<nav class="navbar navbar-default navbar-cls-top " role="navigation" style="margin-bottom: 0">
			<div class="navbar-header">
<?php if ($_smarty_tpl->tpl_vars['login']->value) {?>
				<button type="button" class="navbar-toggle theme" data-toggle="collapse" data-target=".sidebar-collapse">
					<span class="sr-only">Toggle navigation</span>
					<span class="icon-bar"></span>
					<span class="icon-bar"></span>
					<span class="icon-bar"></span>
				</button><?php }?>
				<h1>
					<a class="navbar-brand" href="<?php echo Uri::create("admin");?>
"><img width="200" src="<?php echo Uri::create("assets/img/common/logo.png");?>
" alt="ESTDOC" ></a>
				</h1>
			</div>
<?php if ($_smarty_tpl->tpl_vars['login']->value) {?>
			<div class="btn-box hidden-xs">
				<a href="<?php echo Uri::create("admin/auth/logout/".((string)$_smarty_tpl->tpl_vars['admin_id']->value));?>
" class="btn btn-default">ログアウト</a>
			</div>
<?php }?>
		</nav>
<?php if ($_smarty_tpl->tpl_vars['login']->value) {?>
		<nav class="navbar-default navbar-side" role="navigation">
			<div class="sidebar-collapse">
				<ul class="nav theme" id="main-menu">
					<li class="thumb_box">
						<img src="<?php echo Uri::create("assets/img/admin/find_user.png");?>
" class="user-image img-responsive" alt="<?php echo $_smarty_tpl->tpl_vars['admin_name']->value;?>
さん" >
						<span class="user-name"><?php echo $_smarty_tpl->tpl_vars['admin_name']->value;?>
さん</span>
					</li>
					<li <?php if (preg_match("/^admin-hospital(|-.*)"."$"."/",$_smarty_tpl->tpl_vars['screen']->value)) {?>class="select"<?php }?>>
						<a class="active-menu" href="<?php echo Uri::create("admin/hospital");?>
"><i class="fa fa-hospital-o"></i>病院管理</a>
					</li>
					<li <?php if (preg_match("/^admin-hospitalimport(|-.*)"."$"."/",$_smarty_tpl->tpl_vars['screen']->value)) {?>class="select"<?php }?>>
						<a class="active-menu" href="<?php echo Uri::create("admin/hospitalimport");?>
"><i class="fa fa-file-excel-o"></i>病院CSVインポート</a>
					</li>
					<li <?php if (preg_match("/^admin-review(|-.*)"."$"."/",$_smarty_tpl->tpl_vars['screen']->value)) {?>class="select"<?php }?>>
						<a class="active-menu" href="<?php echo Uri::create("admin/review");?>
"><i class="fa fa-comment-o"></i>口コミ管理</a>
					</li>
					<li <?php if (preg_match("/^admin-setting(|-.*)"."$"."/",$_smarty_tpl->tpl_vars['screen']->value)) {?>class="select"<?php }?>>
						<a class="active-menu" href="<?php echo Uri::create("admin/setting");?>
"><i class="fa fa-cog"></i>設定</a>
					</li>
					<li class="visible-xs">
						<a href="<?php echo Uri::create("admin/auth/logout/".((string)$_smarty_tpl->tpl_vars['admin_id']->value));?>
"><i class="fa fa-sign-out"></i>ログアウト</a>
					</li>
				</ul>
			</div>
		</nav>
<?php }?>

		
		<div id="page-wrapper">
			<div id="page-inner">
				<div class="row">
					<div class="col-md-12 title_box">
						<h2 class="theme_txt title"><?php echo $_smarty_tpl->tpl_vars['breadcrumb']->value;?>
</h2>
						
					</div>
				</div>
				<hr>
			
			<small><?php echo $_smarty_tpl->tpl_vars['content']->value;?>
</small>
			</div>
		</div>
		
		<footer class="theme_txt">
			CopyRightt&nbsp;&copy;&nbsp;2013 EST Doc Ltd. All right reserved.<br class="visible-xxs"> all rights reserved.
		</footer>
	</div>
</body>
</html><?php }
}
