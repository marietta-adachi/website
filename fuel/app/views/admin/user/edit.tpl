<form method="post" id="ma_form" action="admin/user/confirm">
	<input type="hidden" name="ope" value="{$ope|default}" />
	<input type="hidden" name="id" value="{$id|default}" />

	お名前：		<input type="text" name="name" value="{$name|default}" maxlength="30" placeholder="" />{$msgs.name|default:''}<br/><br/>
	
	郵便番号：		<input type="text" name="zipcode" id="zipcode" value="{$zipcode|default}" maxlength="7" placeholder=""/><input type="button" id="auto_address" value="自動入力"/>{$msgs.zipcode|default}<br/>
	都道府県：		<select name="pref_code" id="pref"></select>{$msgs.pref_code|default}<br/>
	市区町村：		<select name="city_code" id="city"></select>{$msgs.city_code|default}<br/>
	町域：			<select name="town_code" id="town"></select>{$msgs.town_code|default}<br/>
	番地・建物名：	<input type="text" name="address" value="{$address|default}" maxlength="" placeholder=""/>{$msgs.address|default}<br/><br/>
	
	電話番号：		<input type="text" name="tel" value="{$tel|default}" maxlength="30" placeholder="" />{$msgs.tel|default}<br/>
	メールアドレス：<input type="text" name="email" value="{$email|default}" maxlength="30" placeholder="" />{$msgs.email|default}<br/><br/>
	
	ステータス：
	{foreach from=St::$name key=k item=v}
		<input type="radio" name="status" value="{$k}" {if $k == ($status|default:St::VALID)}checked="checked"{/if}>{$v}
	{/foreach}<br/>

	<hr/>
	<input type="button" class="btn btn-default btn-sizeFix" value="戻る" onclick="location.href = '{Uri::create("admin/user")}';" />
	&nbsp;
	<input type="submit" class="btn btn-primary btn-sizeFix"  value="確認する" />
	{*
	</form>	
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
	
	*}