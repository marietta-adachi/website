<?php
/* Smarty version 3.1.28-dev/77, created on 2015-12-15 15:29:55
  from "D:\workspace\website\fuel\app\views\admin\base.tpl" */

if ($_smarty_tpl->smarty->ext->_validateCompiled->decodeProperties($_smarty_tpl, array (
  'has_nocache_code' => false,
  'version' => '3.1.28-dev/77',
  'unifunc' => 'content_567023e34c7640_33313764',
  'file_dependency' => 
  array (
    'd0afdc7e6fd8dde7fbfd47fec62c6ebad9f0d84b' => 
    array (
      0 => 'D:\\workspace\\website\\fuel\\app\\views\\admin\\base.tpl',
      1 => 1450189792,
      2 => 'file',
    ),
  ),
  'includes' => 
  array (
  ),
),false)) {
function content_567023e34c7640_33313764 ($_smarty_tpl) {
?>
<!DOCTYPE html>
<html lang="ja">
	<head>
		<meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
		<!-- Meta, title, CSS, favicons, etc. -->
		<meta charset="utf-8">
		<meta http-equiv="X-UA-Compatible" content="IE=edge">
		<meta name="viewport" content="width=device-width, initial-scale=1">

		<title><?php echo (($tmp = @$_smarty_tpl->tpl_vars['title']->value)===null||$tmp==='' ? '' : $tmp);?>
</title>
		<base href="<?php echo Uri::base();?>
">

		<!--[if lt IE 9]>
			<?php echo '<script'; ?>
 src="../assets/js/ie8-responsive-file-warning.js"><?php echo '</script'; ?>
>
		<![endif]-->

		<!-- HTML5 shim and Respond.js for IE8 support of HTML5 elements and media queries -->
		<!--[if lt IE 9]>
			<?php echo '<script'; ?>
 src="https://oss.maxcdn.com/html5shiv/3.7.2/html5shiv.min.js"><?php echo '</script'; ?>
>
			<?php echo '<script'; ?>
 src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"><?php echo '</script'; ?>
>
		<![endif]-->

		<?php echo Asset::add_path('assets/lib/','js');?>

		<?php echo Asset::add_path('assets/lib/','css');?>

		<?php echo Asset::add_path('assets/font/','css');?>


		
		<!-- Bootstrap core CSS -->
		<?php echo Asset::css('gentelella/production/css/bootstrap.min.css');?>

		<?php echo Asset::css('gentelella/production/fonts/css/font-awesome.min.css');?>

		<?php echo Asset::css('gentelella/production/css/animate.min.css');?>

		<!-- Custom styling plus plugins -->
		<?php echo Asset::css('gentelella/production/css/custom.css');?>

		<?php echo Asset::css('gentelella/production/css/icheck/flat/green.css');?>

		<!-- JS -->
		<?php echo Asset::js('gentelella/production/js/jquery.min.js');?>

		<?php echo Asset::js('gentelella/production/js/custom.js');?>



		
		<?php echo $_smarty_tpl->tpl_vars['page_css']->value;?>

		<?php echo Asset::css('base.css');?>

		<?php echo Asset::css('admin/base.css');?>


		
		<?php echo '<script'; ?>
 id="<?php echo $_smarty_tpl->tpl_vars['screen']->value;?>
-js" data-params="<?php echo (($tmp = @$_smarty_tpl->tpl_vars['page_params']->value)===null||$tmp==='' ? '' : $tmp);?>
">
			var pageParams;
			$(function () {
				pageParams = $('#<?php echo $_smarty_tpl->tpl_vars['screen']->value;?>
-js').data('params');
			});
		<?php echo '</script'; ?>
>
		<?php echo Asset::js('base.js');?>

		<?php echo $_smarty_tpl->tpl_vars['page_js']->value;?>

	</head>

	<body class="nav-md">
		<?php if (!$_smarty_tpl->tpl_vars['login']->value || $_smarty_tpl->tpl_vars['screen']->value == 'error/404' || $_smarty_tpl->tpl_vars['screen']->value == 'error/404') {?>
			<?php echo $_smarty_tpl->tpl_vars['content']->value;?>

		<?php } else { ?>
			<div class="container body">
				<div class="main_container">
					<div class="col-md-3 left_col">
						<?php echo $_smarty_tpl->tpl_vars['menu']->value;?>

					</div>
					<!--div class="top_nav">
						<?php echo $_smarty_tpl->tpl_vars['top']->value;?>

					</div-->
					<div class="right_col" role="main">
						<div class="<?php echo $_smarty_tpl->tpl_vars['screen']->value;?>
">
							<?php echo $_smarty_tpl->tpl_vars['header']->value;?>

							<div class="row">
								<?php echo $_smarty_tpl->tpl_vars['content']->value;?>

							</div>
						</div>
						<?php echo $_smarty_tpl->tpl_vars['footer']->value;?>

					</div>
					<input type="hidden" id="message" value="<?php echo (($tmp = @$_smarty_tpl->tpl_vars['info']->value)===null||$tmp==='' ? '' : $tmp);?>
">
				</div>
			</div>
		<?php }?>
	</body>
	
</html>
<?php }
}
