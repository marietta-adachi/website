<form method="post" action="{Uri::create("admin/auth/login")}" role="form">{Form::csrf()}
	<input type="text" name="email" value="{$code|default}"/><br>
	<input type="password" name="password" value="{$password|default}"/><br>
	<input type="checkbox" name="remember" value=1 {if $remember|default:0 == 1}checked{/if}>ログイン状態を保存する<br>
	
	{$errors.email|default}
	{$errors.password|default}
	{$errors.other|default}
	<input type="submit" value="ログイン"/>
</form>