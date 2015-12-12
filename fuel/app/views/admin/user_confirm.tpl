<form method="post" id="ma_form">{Form::csrf()}
	<input type="hidden" name="mode" value="{$mode}" />
	<input type="hidden" name="id" value="{$id}" />
	<input type="hidden" name="name" value="{$name}" />
	<input type="hidden" name="person_name_sei" value="{$person_name_sei}" />
	<input type="hidden" name="person_name_mei" value="{$person_name_mei}" />
	<input type="hidden" name="zipcode" value="{$zipcode}" />
	<input type="hidden" name="address" value="{$address}" />
	<input type="hidden" name="tel" value="{$tel}" />
	<input type="hidden" name="mail_address" value="{$mail_address}" />
	<input type="hidden" name="status" value="{$status}" />

	{assign trt_model_list Config::get("const.vendor_model")}
	業者名：{$name}<br/>
	担当者名：{$person_name_sei}{$person_name_mei}<br/>
	住所：{$address_all}<br/>
	電話番号：{$tel}<br/>
	メールアドレス：{$mail_address}<br/>
	ステータス：{VendorStatus::$name[$status]}<hr/>

	<input type="submit" class="btn btn-default nonConfirmBtn" onclick="document.getElementById('ma_form').action = '{Uri::create("admin/vendor/edit")}';" value="戻る" />
	&nbsp;
	<input type="submit" class="btn btn-primary confirmBtn" onclick="document.getElementById('ma_form').action = '{Uri::create("admin/vendor/complete")}';" value="{if $mode == EditMode::ADD}登録する{else}更新する{/if}" />
</form>