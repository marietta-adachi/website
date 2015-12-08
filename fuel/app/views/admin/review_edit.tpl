<form method="post" id="ma_form">{Form::csrf()}
	<input type="hidden" name="review_id" value="{$review_id|default:''}" />

	病院名：<a href="{Uri::create("doctor/{$hospital.m_hospital_id}")}" target="_blank">{$hospital.m_hospital_name}</a><br/>
	ニックネーム：{$review.t_hospital_review_nickname}<br/>
	内容：		{$review.t_hospital_review_message}<br/>
	ステータス：
	{foreach from=ReviewStatus::$name key=k item=v}
        <input type="radio" name="status" value="{$k}" {if $k == ($status|default:ReviewStatus::INVALID)}checked="checked"{/if}>{$v}
	{/foreach}<br/>

	<hr/>
	<input type="button" class="btn btn-default btn-sizeFix" value="戻る" onclick="location.href='{Uri::create("admin/review")}';" />
	&nbsp;
	<input type="submit" class="btn btn-primary btn-sizeFix" onclick="document.getElementById('ma_form').action = '{Uri::create("admin/review/confirm")}';" value="確認する" />

</form>	
