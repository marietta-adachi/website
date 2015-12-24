<div class="container">
	<form method="post" action="admin/auth/login" class="form-signin">{Form::csrf()}
        <h2 class="form-signin-heading">{Config::get('system.name')}</h2>
        <label for="inputEmail" class="sr-only">Email address</label>
        <input type="email" id="inputEmail" class="form-control" name="email" value="{$email|default}" placeholder="" required autofocus>
        <label for="inputPassword" class="sr-only">パスワード</label>
        <input type="password" id="inputPassword" class="form-control" name="password" value="{$password|default}" placeholder="" required>
        <div class="checkbox">
			<label>
				<input type="checkbox" value="1" {if $remember|default:0 == 1}checked{/if}> ログイン状態を保存する
			</label>
        </div>
        <button class="btn btn-lg btn-primary btn-block" type="submit">ログイン</button>
	</form>
	{$errors.email|default}
	{$errors.password|default}
	{$errors.other|default}

</div>


<!-- IE10 viewport hack for Surface/desktop Windows 8 bug -->
<script src="../../assets/js/ie10-viewport-bug-workaround.js"></script>