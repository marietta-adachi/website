<div class="">
	<a class="hiddenanchor" id="toregister"></a>
	<a class="hiddenanchor" id="tologin"></a>

	<div id="wrapper">
		<div id="login" class="animate form">
			<section class="login_content">
				<form method="post" action="admin/auth/login" >{Form::csrf()}
					<h1>{Config::get('system.name')}</h1>
					<div>
						<input type="text" class="form-control" name="email" value="{$email|default}" placeholder="" required="" />
					</div>
					<div>
						<input type="password" class="form-control" name="password" value="{$password|default}" placeholder="" required="" />
					</div>
					<div class="checkbox">
						<label>
							<input type="checkbox" value="1" {if $remember|default:0 == 1}checked{/if}> ログイン状態を保存する
						</label>
					</div>
					<div>
						<a class="btn btn-default submit" href="index.html">Log in</a>
						<a class="reset_pass" href="#">パスワードをお忘れの方はこちら</a>
					</div>
					<div class="clearfix"></div>
					<div class="separator">

						<p class="change_link">New to site?
							<a href="#toregister" class="to_register"> Create Account </a>
						</p>
						<div class="clearfix"></div>
						<br />
						<div>
							<h1><i class="fa fa-paw" style="font-size: 26px;"></i> Gentelella Alela!</h1>

							<p>©2015 All Rights Reserved. Gentelella Alela! is a Bootstrap 3 template. Privacy and Terms</p>
						</div>
					</div>
				</form>
				<!-- form -->
			</section>
			<!-- content -->
		</div>

	</div>
</div>
{$errors.email|default}
{$errors.password|default}
{$errors.other|default}