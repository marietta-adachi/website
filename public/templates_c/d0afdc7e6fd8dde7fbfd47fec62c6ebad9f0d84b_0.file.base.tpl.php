<?php
/* Smarty version 3.1.28-dev/77, created on 2015-12-24 22:19:52
  from "D:\workspace\website\fuel\app\views\admin\base.tpl" */

if ($_smarty_tpl->smarty->ext->_validateCompiled->decodeProperties($_smarty_tpl, array (
  'has_nocache_code' => false,
  'version' => '3.1.28-dev/77',
  'unifunc' => 'content_567bf0f8eab201_83516106',
  'file_dependency' => 
  array (
    'd0afdc7e6fd8dde7fbfd47fec62c6ebad9f0d84b' => 
    array (
      0 => 'D:\\workspace\\website\\fuel\\app\\views\\admin\\base.tpl',
      1 => 1450963188,
      2 => 'file',
    ),
  ),
  'includes' => 
  array (
  ),
),false)) {
function content_567bf0f8eab201_83516106 ($_smarty_tpl) {
?>
<!DOCTYPE html>
<html lang="ja">
	<head>
		<meta charset="utf-8">
		<meta http-equiv="X-UA-Compatible" content="IE=edge">
		<meta name="viewport" content="width=device-width, initial-scale=1">
		<!-- The above 3 meta tags *must* come first in the head; any other head content must come *after* these tags -->
		<title><?php echo (($tmp = @$_smarty_tpl->tpl_vars['title']->value)===null||$tmp==='' ? '' : $tmp);?>
</title>
		<meta name="description" content="<?php echo (($tmp = @$_smarty_tpl->tpl_vars['description']->value)===null||$tmp==='' ? '' : $tmp);?>
"/>
		<meta name="keywords" content="<?php echo (($tmp = @$_smarty_tpl->tpl_vars['keywords']->value)===null||$tmp==='' ? '' : $tmp);?>
"/>
		<base href="<?php echo Uri::base();?>
">

		<!-- Bootstrap -->
		<link href="css/bootstrap.min.css" rel="stylesheet">

		<!-- HTML5 shim and Respond.js for IE8 support of HTML5 elements and media queries -->
		<!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
		<!--[if lt IE 9]>
		  <?php echo '<script'; ?>
 src="https://oss.maxcdn.com/html5shiv/3.7.2/html5shiv.min.js"><?php echo '</script'; ?>
>
		  <?php echo '<script'; ?>
 src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"><?php echo '</script'; ?>
>
		<![endif]-->

		
		<?php echo Asset::add_path("assets/lib/","js");?>

		<?php echo Asset::add_path("assets/lib/","css");?>

		<?php echo Asset::add_path("assets/font/","css");?>



		
		<?php echo Asset::css('bootstrap/css/bootstrap.min.css');?>

		<?php echo Asset::css('bootstrap/css/dashboard.css');?>

		
		<?php echo Asset::css('base.css');?>

		<?php echo Asset::css('admin/base.css');?>

		<?php echo $_smarty_tpl->tpl_vars['page_css']->value;?>

		
		

		
		<?php echo Asset::js('bootstrap/js/bootstrap.min.js');?>

		<?php echo Asset::js('jquery-1.11.3.min.js');?>

		
		<?php echo Asset::js('base.js');?>

		<?php echo $_smarty_tpl->tpl_vars['page_js']->value;?>

		<?php echo '<script'; ?>
 id="<?php echo $_smarty_tpl->tpl_vars['screen']->value;?>
-js" data-params="<?php echo (($tmp = @$_smarty_tpl->tpl_vars['js_params']->value)===null||$tmp==='' ? '' : $tmp);?>
">
			var pageParams;
			$(function () {
				pageParams = $('#<?php echo $_smarty_tpl->tpl_vars['screen']->value;?>
-js').data('params');
			});
		<?php echo '</script'; ?>
>
	</head>
	<body id="<?php echo $_smarty_tpl->tpl_vars['screen']->value;?>
">
		
		
		<?php if (!$_smarty_tpl->tpl_vars['login']->value || $_smarty_tpl->tpl_vars['screen']->value == 'error/404' || $_smarty_tpl->tpl_vars['screen']->value == 'error/404') {?>
			<?php echo $_smarty_tpl->tpl_vars['content']->value;?>

		<?php } else { ?>
			<nav class="navbar navbar-inverse navbar-fixed-top">
				<div class="container-fluid">
					<?php echo $_smarty_tpl->tpl_vars['header']->value;?>

				</div>
			</nav>

			<div class="container-fluid">
				<div class="row">
					<?php echo $_smarty_tpl->tpl_vars['menu']->value;?>

					<div class="col-sm-9 col-sm-offset-3 col-md-10 col-md-offset-2 main">
						<?php echo $_smarty_tpl->tpl_vars['content']->value;?>

						<input type="hidden" id="message" value="<?php echo (($tmp = @$_smarty_tpl->tpl_vars['info']->value)===null||$tmp==='' ? '' : $tmp);?>
"/>
					</div>
				</div>
			</div>

		<?php }?>


		<!--div class="mastfoot">
			<p class="pull-right">CopyRight (c) 2004- Marietta Corporation All Rights Reserved.</p>
		</div-->


	</body>
</html><?php }
}
