<div class="col-md-12 col-sm-12 col-xs-12">
	<div class="x_panel">
		<div class="x_title">
			<h2>Form Design <small>different form elements</small></h2>
			<div class="clearfix"></div>
		</div>
		<div class="x_content">
			
			<br>
			<form id="demo-form2" data-parsley-validate="" class="form-horizontal form-label-left" novalidate="">

				<div class="form-group">
					<label class="control-label col-md-3 col-sm-3 col-xs-12" for="first-name">お名前<span class="required">*</span>
					</label>
					<div class="col-md-6 col-sm-6 col-xs-12">
						<input type="text" id="first-name" required="required" class="form-control col-md-7 col-xs-12" data-parsley-id="6496"><ul class="parsley-errors-list" id="parsley-id-6496"></ul>
					</div>
				</div>
				<div class="form-group">
					<label class="control-label col-md-3 col-sm-3 col-xs-12" for="last-name">メールアドレス<span class="required">*</span>
					</label>
					<div class="col-md-6 col-sm-6 col-xs-12">
						<input type="text" id="last-name" name="last-name" required="required" class="form-control col-md-7 col-xs-12" data-parsley-id="8972"><ul class="parsley-errors-list" id="parsley-id-8972"></ul>
					</div>
				</div>
				<div class="form-group">
					<label for="middle-name" class="control-label col-md-3 col-sm-3 col-xs-12">Middle Name / Initial</label>
					<div class="col-md-6 col-sm-6 col-xs-12">
						<input id="middle-name" class="form-control col-md-7 col-xs-12" type="text" name="middle-name" data-parsley-id="3142"><ul class="parsley-errors-list" id="parsley-id-3142"></ul>
					</div>
				</div>
				<div class="form-group">
					<label class="control-label col-md-3 col-sm-3 col-xs-12">Gender</label>
					<div class="col-md-6 col-sm-6 col-xs-12">
						<div id="gender" class="btn-group" data-toggle="buttons">
							<label class="btn btn-default" data-toggle-class="btn-primary" data-toggle-passive-class="btn-default">
								<input type="radio" name="gender" value="male" data-parsley-multiple="gender" data-parsley-id="6816"> &nbsp; Male &nbsp;
							</label><ul class="parsley-errors-list" id="parsley-id-multiple-gender"></ul>
							<label class="btn btn-primary active" data-toggle-class="btn-primary" data-toggle-passive-class="btn-default">
								<input type="radio" name="gender" value="female" checked="" data-parsley-multiple="gender" data-parsley-id="6816"> Female
							</label>
						</div>
					</div>
				</div>
				<div class="form-group">
					<label class="control-label col-md-3 col-sm-3 col-xs-12">Date Of Birth <span class="required">*</span>
					</label>
					<div class="col-md-6 col-sm-6 col-xs-12">
						<input id="birthday" class="date-picker form-control col-md-7 col-xs-12" required="required" type="text" data-parsley-id="8384"><ul class="parsley-errors-list" id="parsley-id-8384"></ul>
					</div>
				</div>
				<div class="ln_solid"></div>
				<div class="form-group">
					<div class="col-md-6 col-sm-6 col-xs-12 col-md-offset-3">
						<button type="submit" class="btn btn-primary">Cancel</button>
						<button type="submit" class="btn btn-success">Submit</button>
					</div>
				</div>

			</form>
		</div>
	</div>
</div>

{*
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
	
*}