<form method="post" id="Feedback" class="ma_form">
{Form::csrf()}
	<input type="hidden" name="contact_type" value="{$contact_type}" />
	<input type="hidden" name="name" value="{$name}" />
	<input type="hidden" name="name_kana" value="{$name_kana}" />
	<input type="hidden" name="tel" value="{$tel}" />
	<input type="hidden" name="mail_address" value="{$mail_address}" />
	<input type="hidden" name="mail_address_confirm" value="{$mail_address_confirm}" />
	<input type="hidden" name="contact_detail" value="{$contact_detail}" />
{if $device=="other"}{*PC-------------------------------------------------------------------------------*}
<section class="container" id="Thanks">
	<div class="feedback">
		<ul id="breadcrumb" itemscope itemtype="http://data-vocabulary.org/Breadcrumb">
			<li><a href="{Uri::base()}" itemprop="url"><span itemprop="title">トップ</span></a></li>
			<li><span itemprop="title">お問い合わせ内容確認</span></li>
		</ul>
		<br>
		<div class="container block feedback_do" style=" padding:0; margin-top:20px; word-break: break-all;">
			<h1>以下の内容でメールを送信します。</h1>
			<dl style="padding: 20px 0; font-size: 14px;">
				<dt style="font-size:18px;">お問い合わせ項目</dt>
				<dd style="border-bottom:1px solid #E1E1E1; padding-bottom:10px;">
				{$contact_type_list[$contact_type]}
				</dd>
				<dt style="font-size:18px;">お名前</dt>
				<dd style="border-bottom:1px solid #E1E1E1; padding-bottom:10px;">
				{$name}（{$name_kana}）
				</dd>
				<dt style="font-size:18px;">電話番号</dt>
				<dd style="border-bottom:1px solid #E1E1E1; padding-bottom:10px;">
				{$tel}
				</dd>
				<dt style="font-size:18px;">メールアドレス</dt>
				<dd style="border-bottom:1px solid #E1E1E1; padding-bottom:10px;">
				{$mail_address}
				</dd>
				<dt style="font-size:18px;">メールアドレス（確認用）</dt>
				<dd style="border-bottom:1px solid #E1E1E1; padding-bottom:10px;">
				{$mail_address_confirm}
				</dd>
				<dt style="font-size:18px;">お問い合わせ内容</dt>
				<dd style="border-bottom:1px solid #E1E1E1; padding-bottom:10px; ">
				{$contact_detail|nl2br}<br/>
				</dd>
			</dl>
		</div>
		<div class="back_top">
			<input type="submit" class="button" onclick="document.getElementById('Feedback').action = '{Uri::create("contact/index")}';" value="戻る" />
			<input type="submit" class="button" onclick="document.getElementById('Feedback').action = '{Uri::create("contact/complete")}';" value="送信する" />
		</div>
	</div>
</section>
{else}{*PC以外------------------------------------------------------------------------------------------*}
<section class="container" id="Thanks">
	<h2 style="text-align:center; background-color:#007AC3; padding:20px 0; color:#FFFFFF;">以下の内容でメールを送信します。</h2>
		<div class="inner">
			<div class="container block" style="margin-bottom:20px;">
				<dl>
					<dt>お問い合わせ項目</dt>
					<dd>{$contact_type_list[$contact_type]}</dd>
				</dl>
				<dl>
					<dt>お名前</dt>
					<dd>{$name}（{$name_kana}）</dd>
				</dl>
				<dl>
					<dt>電話番号</dt>
					<dd>{$tel}</dd>
				</dl>
				<dl>
					<dt>メールアドレス</dt>
					<dd>{$mail_address}</dd>
				</dl>
				<dl>
					<dt>メールアドレス（確認用）</dt>
					<dd>{$mail_address_confirm}</dd>
				</dl>
				<dl>
					<dt>お問い合わせ内容</dt>
					<dd>{$contact_detail|nl2br}</dd>
				</dl>
			</div>
			<div style="margin-bottom:20px;" class="align_c">
				<input type="submit" class="btn to_send" onclick="document.getElementById('Feedback').action = '{Uri::create("contact/index")}';" value="戻る" />
				<input type="submit" class="btn to_send" onclick="document.getElementById('Feedback').action = '{Uri::create("contact/complete")}';" value="送信する" />
		</div>
	</div>
</section>
{/if}
</form>
