{if $device=="other"}{*PC-------------------------------------------------------------------------------*}
<section class="container" id="Input">
	{$breadcrumb}
	<br>
	<div class="feedback">
		<div class="container block" style=" padding:0;">
			<h1>お問い合わせ</h1>
			<form method="post" id="Feedback" class="ma_form">
			{Form::csrf()}
{if $errors}
<div class="margin_b40">
{if $errors.contact_type|default:''}<p class="error align_c">{$errors.contact_type}</p>{/if}
{if $errors.name|default:''}<p class="error align_c">{$errors.name}</p>{/if}
{if $errors.name_kana|default:''}<p class="error align_c">{$errors.name_kana}</p>{/if}
{if $errors.tel|default:''}<p class="error align_c">{$errors.tel}</p>{/if}
{if $errors.mail_address|default:''}<p class="error align_c">{$errors.mail_address}</p>{/if}
{if $errors.mail_address_confirm|default:''}<p class="error align_c">{$errors.mail_address_confirm}</p>{/if}
{if $errors.contact_detail|default:''}<p class="error align_c">{$errors.contact_detail}</p>{/if}
{if $errors.agree|default:''}<p class="error align_c">{$errors.agree}</p>{/if}
</div>
{/if}
				<label for="contact_type" class="control-label">お問い合わせ項目</label>
				<select name="contact_type">
					<option value="">選択してください</option>
{foreach from=$contact_type_list key=k item=v}
					<option value="{$k}" {if $k == $contact_type|default:''}selected{/if}>{$v}</option>
{/foreach}
				</select>
				<br>
				<label for="name" class="control-label">お名前</label>
				<input type="text" name="name" value="{$name|default:''}" maxlength="50" placeholder="例）広州&nbsp;届" />
				<br>
				<label for="name_kana" class="control-label">お名前（フリガナ）</label>
				<input type="text" name="name_kana" value="{$name_kana|default:''}" maxlength="50" placeholder="例）エス&nbsp;トドク" />
				<br>
				<label for="tel" class="control-label">電話番号</label>
				<input type="text" name="tel" value="{$tel|default:''}" maxlength="15" placeholder="例）03-3261-7105" />
				<br>
				<label for="mail_address" class="control-label">メールアドレス</label>
				<input type="text" name="mail_address" value="{$mail_address|default:''}" maxlength="255" placeholder="例）example@aa.jp" />
				<br>
				<label for="mail_address_confirm" class="control-label">メールアドレス（確認）</label>
				<input type="text" name="mail_address_confirm" value="{$mail_address_confirm|default:''}" maxlength="255" placeholder="確認のためもう一度入力してください" />
				<br>
				<label for="contact_detail" class="control-label">お問い合わせ内容</label>
				<textarea name="contact_detail" cols="40" rows="5" maxlength="1000" placeholder="お問い合わせ内容を入力してください">{$contact_detail|default:''}</textarea>
				<br>
				
				<div class="txt_center" style="margin-top:60px; font-size:18px; margin-bottom:60px;">
					<input type="checkbox" name="agree" value="1" />
					私は、<a href="{Uri::create("terms")}" target="_blank">利用規約</a>および<a href="{Uri::create("privacy")}" target="_blank">個人情報保護方針</a>に同意し、問い合わせます。<br>
					<br>
					<input type="submit" class="button send" onclick="document.getElementById('Feedback').action = '{Uri::create("contact/confirm")}';" value="確認画面へ" />
				</div>
			</form>
		</div>
	</div>
</section>
{else}{*PC以外------------------------------------------------------------------------------------------*}
<main style="padding:15px;">
	<form method="post" id="Feedback" class="ma_form">

{Form::csrf()}
{if $errors}
<div class="margin_b40">
{if $errors.contact_type|default:''}<p class="error align_c">{$errors.contact_type}</p>{/if}
{if $errors.name|default:''}<p class="error align_c">{$errors.name}</p>{/if}
{if $errors.name_kana|default:''}<p class="error align_c">{$errors.name_kana}</p>{/if}
{if $errors.tel|default:''}<p class="error align_c">{$errors.tel}</p>{/if}
{if $errors.mail_address|default:''}<p class="error align_c">{$errors.mail_address}</p>{/if}
{if $errors.mail_address_confirm|default:''}<p class="error align_c">{$errors.mail_address_confirm}</p>{/if}
{if $errors.contact_detail|default:''}<p class="error align_c">{$errors.contact_detail}</p>{/if}
{if $errors.agree|default:''}<p class="error align_c">{$errors.agree}</p>{/if}
</div>
{/if}

		<label for="contact_type">お問い合わせ項目</label>
		<select name="contact_type">
			<option value="">選択してください</option>
{foreach from=$contact_type_list key=k item=v}
			<option value="{$k}" {if $k == $contact_type|default:''}selected{/if}>{$v}</option>
{/foreach}
		</select>
		<label for="name">お名前</label>
		<input type="text" name="name" value="{$name|default:''}" maxlength="50" placeholder="例）広州&nbsp;届" />
		<br>
		<label for="name_kana">お名前（フリガナ）</label>
		<input type="text" name="name_kana" value="{$name_kana|default:''}" maxlength="50" placeholder="例）エス&nbsp;トドク" />
		<br>
		<label for="tel">電話番号</label>
		<input type="text" name="tel" value="{$tel|default:''}" maxlength="15" placeholder="例）03-3261-7105" />
		<br>
		<label for="mail_address">メールアドレス</label>
		<input type="text" name="mail_address" value="{$mail_address|default:''}" maxlength="255" placeholder="例）example@aaaa.jp" />
		<br>
		<label for="mail_address_confirm">メールアドレス（確認）</label>
		<input type="text" name="mail_address_confirm" value="{$mail_address_confirm|default:''}" maxlength="255" placeholder="確認のためもう一度入力してください" />
		<br>
		<label for="contact_detail">お問い合わせ内容</label>
		<textarea name="contact_detail" cols="40" rows="5" maxlength="1000" placeholder="お問い合わせ内容を入力してください">{$contact_detail|default:''}</textarea>
		
		<div class="txt_center">
			<label for="agree" class="check mb10">
				<input type="checkbox" name="agree" id="agree" value="1" />私は、<a href="{Uri::create("terms")}" target="_blank">利用規約</a>および<a href="{Uri::create("privacy")}" target="_blank">プライバシーポリシー</a>の個人情報保護方針に同意し、問い合わせます。
			</label>
			<input type="submit" class="btn go block full_size send to_send" onclick="document.getElementById('Feedback').action = '{Uri::create("contact/confirm")}';" value="確認画面へ" />
		</div>
	</form>
</main>
{/if}