<form method="post" id="ma_form">{Form::csrf()}
	<input type="hidden" name="mode" value="{$mode|default:''}" />
	<input type="hidden" name="id" value="{$id|default:''}" />
	
	業者名：		<input type="text" name="name" value="{$name|default:'株式会社マリエッタ'}" maxlength="30" placeholder="例）株式会社アグリクラスター" />{$errors.name|default:''}<br/>
	担当者名（姓）：<input type="text" name="person_name_sei" value="{$person_name_sei|default:'江田'}" maxlength="30" placeholder="例）亜久里" />{$errors.person_name_sei|default:''}<br/>
	担当者名（名）：<input type="text" name="person_name_mei" value="{$person_name_mei|default:'真里'}" maxlength="30" placeholder="例）太郎" />{$errors.person_name_mei|default:''}<br/>
	郵便番号：		<input type="text" name="zipcode" id="zipcode" value="{$zipcode|default:'1110053'}" maxlength="7" placeholder="例）3380001"/><input type="button" value="郵便番号から自動入力する" onclick="setAddress();" />{$errors.zipcode|default:''}<br/>
	都道府県：		<select name="pref_cd" id="pref" onchange="setCity()"></select>{$errors.pref_cd|default:''}<br/>
	市区町村：		<select name="city_cd" id="city" onchange="setTown()"></select>{$errors.city_cd|default:''}<br/>
	町域：			<select name="town_cd" id="town" onchange="setZipcode()"></select>{$errors.town_cd|default:''}<br/>
	番地・建物名：	<input type="text" name="address" value="{$address|default:'5-5-5'}" maxlength="" placeholder="例）2-5-35 IKビル2F"/>{$errors.address|default:''}<br/>
	電話番号：		<input type="text" name="tel" value="{$tel|default:'0312345678'}" maxlength="30" placeholder="例）0311112222" />{$errors.tel|default:''}<br/>
	メールアドレス：<input type="text" name="mail_address" value="{$mail_address|default:'adachi@marietta.co.jp'}" maxlength="30" placeholder="例）example@agricluster.com" />{$errors.mail_address|default:''}<br/>
	ステータス：
	{foreach from=VendorStatus::$name key=sid item=sname}
        <input type="radio" name="status" value="{$sid}" {if $sid == ($status|default:VendorStatus::VALID)}checked="checked"{/if}>{$sname}
	{/foreach}<br/>

	<hr/>
	<input type="button" class="btn btn-default btn-sizeFix" value="戻る" onclick="location.href='{Uri::create("admin/vendor")}';" />
	&nbsp;
	<input type="submit" class="btn btn-primary btn-sizeFix" onclick="document.getElementById('ma_form').action = '{Uri::create("admin/vendor/confirm")}';" value="確認する" />

</form>	
	
<script type="text/javascript">
$(function(){
	setAddress();
});
</script>