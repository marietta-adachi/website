<div class="left_col scroll-view">

	<div class="navbar nav_title" style="border: 0;">
		<a href="index.html" class="site_title"><i class="fa fa-hospital-o"></i> <span>{Config::get('system.name')}</span></a>
	</div>
	<div class="clearfix"></div>

	<!-- menu prile quick info -->
	<!--div class="profile">
		<div class="profile_pic">
			<img src="assets/img/admin/user.jpg" alt="..." class="img-circle profile_img">
		</div>
		<div class="profile_info">
			<span>aaa</span>
			<h2>{$user|default:'USER'}</h2>
		</div>
	</div-->
	<!-- /menu prile quick info -->

	<br />
	<!-- sidebar menu -->
	<div id="sidebar-menu" class="main_menu_side hidden-print main_menu">

		<div class="menu_section">
			<h3>General</h3>
			<ul class="nav side-menu">
				{*<li><a><i class="fa fa-home"></i> Home <span class="fa fa-chevron-down"></span></a>
					<ul class="nav child_menu" style="display: none">
						<li><a href="admin/user">Dashboard</a>
						</li>
						<li><a href="#">Dashboard2</a>
						</li>
						<li><a href="#">Dashboard3</a>
						</li>
					</ul>
				</li>
				<li><a><i class="fa fa-edit"></i> 病院管理	 <span class="fa fa-chevron-down"></span></a>
					<ul class="nav child_menu" style="display: none">
						<li><a href="#">General Form</a>
						</li>
						<li><a href="#">Advanced Components</a>
						</li>
					</ul>
				</li>*}
				<li {if preg_match("/^admin-user(|-.*)$/",$screen)}class="current-page"{/if}>
					<a href="admin/user"><i class="fa fa-laptop"></i>会員管理</a>
				</li>
				<li {if preg_match("/^admin-user(|-.*)$/",$screen)}class="current-page"{/if}>
					<a href="admin/user"><i class="fa fa-laptop"></i>物件管理</a>
				</li>
				<li {if preg_match("/^admin-user(|-.*)$/",$screen)}class="current-page"{/if}>
					<a href="admin/user"><i class="fa fa-laptop"></i>プラン管理</a>
				</li>
				<li {if preg_match("/^admin-setting(|-.*)$/",$screen)}class="current-page"{/if}>
					<a href="admin/setting"><i class="fa fa-laptop"></i>設定</a>
				</li>
			</ul>
		</div>
	</div>
	{*<li {if preg_match("/^admin-hospital(|-.*)$/",$screen)}class="select"{/if}>
	<a class="active-menu" href="{Uri::create("admin/hospital")}"><i class="fa fa-hospital-o"></i>病院管理</a>
	</li>*}
	<!-- /sidebar menu -->

	<!-- /menu footer buttons -->
	<div class="sidebar-footer hidden-small">
		{*<a data-toggle="tooltip" data-placement="top" title="Settings">
			<span class="glyphicon glyphicon-cog" aria-hidden="true"></span>
		</a>
		<a data-toggle="tooltip" data-placement="top" title="FullScreen">
			<span class="glyphicon glyphicon-fullscreen" aria-hidden="true"></span>
		</a>
		<a data-toggle="tooltip" data-placement="top" title="Lock">
			<span class="glyphicon glyphicon-eye-close" aria-hidden="true"></span>
		</a>*}
		<a data-toggle="tooltip" data-placement="top" title="Logout">
			<span class="glyphicon glyphicon-off" aria-hidden="true"></span>
		</a>
	</div>
	<!-- /menu footer buttons -->
</div>
