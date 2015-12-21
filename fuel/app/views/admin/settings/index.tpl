<form method="post" id="ma_form">{Form::csrf()}
	<h4>管理者パスワード</h4>
	現在のパスワード：<input type="password" name="password" value="{$password|default:''}" maxlength="30" />{$errors.password|default:''}<br/>
	新しいパスワード：<input type="password" name="password_new" value="{$password_new|default:''}" maxlength="30" placeholder="半角英数4文字以上で入力してください"/>{$errors.password_new|default:''}<br/>
	新しいパスワード（確認）：<input type="password" name="password_new_confirm" value="{$password_new_confirm|default:''}" maxlength="30" placeholder="確認のためもう一度入力してください"/>{$errors.password_new_confirm|default:''}<br/>
	{$errors.other_password|default:''}
	<br/>
	<button type="submit" class="btn btn-primary btn-sizeFix" onclick="document.getElementById('ma_form').action = '{Uri::create("admin/setting/update/{SettingType::PASSWORD}")}';" class="button_theme">変更する</button>
	
	<hr/>
	<h4>管理者メールアドレス</h4>
	新しいメールアドレス：<input type="text" name="mail_address_new" value="{$mail_address_new|default:''}" maxlength="255" placeholder="例）"/>{$errors.mail_address_new|default:''}<br/>
	新しいメールアドレス（確認）：<input type="text" name="mail_address_new_confirm" value="{$mail_address_new_confirm|default:''}" maxlength="255" placeholder="確認のためもう一度入力してください"/>{$errors.mail_address_new_confirm|default:''}<br/>
	{$errors.other_mail_address|default:''}
	<br/>
	<button type="submit" class="btn btn-primary btn-sizeFix" onclick="document.getElementById('ma_form').action = '{Uri::create("admin/setting/update/{SettingType::MAILADDRESS}")}';" class="button_theme">変更する</button>
</form>