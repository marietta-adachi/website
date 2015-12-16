<form method="post" id="main_form">{Form::csrf()}
	<input type="hidden" name="ope" value="{$ope}" />
	<input type="hidden" name="id" value="{$id}" />
	<input type="hidden" name="name" value="{$name}" />
	<input type="hidden" name="email" value="{$email}" />
	<input type="hidden" name="status" value="{$status}" />

	お名前：{$name}<br/>
	メールアドレス：{$email}<br/>
	ステータス：{St::$name[$status]}<hr/>

	<button type="submit" class="btn btn-default" onclick="document.getElementById('main_form').action = 'admin/user/edit';">戻る</button>
	&nbsp;
	<button type="submit" class="btn btn-primary" onclick="document.getElementById('main_form').action = 'admin/user/do';" >{if $ope == Ope::ADD}登録する{else}更新する{/if}</button>
</form>