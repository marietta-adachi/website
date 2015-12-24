<div class="col-sm-3 col-md-2 sidebar">

	<h4>{$user.name|default}</h4>
	<span>{$user.last_login|default}</span>
	<hr/>

	<ul class="nav nav-sidebar">
		<li {if preg_match("/^admin-user(|-.*)$/",$screen)}class="active"{/if}>
			<a href="admin/user?init=1"><i class="fa fa-laptop"></i>会員</a>
		</li>
		<li {if preg_match("/^admin-plan(|-.*)$/",$screen)}class="active"{/if}>
			<a href="admin/plan?init=1"><i class="fa fa-laptop"></i>プラン</a>
		</li>
	</ul>
	<ul class="nav nav-sidebar">
		<li {if preg_match("/^admin-price(|-.*)$/",$screen)}class="active"{/if}>
			<a href="admin/plan?init=1"><i class="fa fa-laptop"></i>料金プラン</a>
		</li>
		<li {if preg_match("/^admin-order(|-.*)$/",$screen)}class="active"{/if}>
			<a href="admin/plan?init=1"><i class="fa fa-laptop"></i>注文履歴</a>
		</li>
	</ul>
</div>