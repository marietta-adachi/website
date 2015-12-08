<form method="post" action="{Uri::create("admin/auth/login")}" role="form">{Form::csrf()}
	<input type="text" name="code" value="{$code|default:''}" maxlength="20" placeholder="IDを入力してください。" /><br>
	<input type="password" name="password" value="{$password|default:''}" maxlength="20"  placeholder="パスワードを入力してください。" /><br>
	<input type="checkbox" name="keep_login" value=1 {if $keep_login|default:0 == 1}checked{/if}>パスワードを保存する<br>
	
	{if !empty($errors.code) > 0}
		{$errors.code|default:''}<br>
	{/if}
	{if !empty($errors.password) > 0}
		{$errors.password|default:''}<br>
	{/if}
	{if !empty($errors.other) > 0}
		{$errors.other|default:''} </p>
	{/if}

	<input type="submit" value="ログイン"/>
</form>