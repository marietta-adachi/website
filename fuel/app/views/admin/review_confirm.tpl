<form method="post" id="ma_form">{Form::csrf()}
	<input type="hidden" name="review_id" value="{$review_id}" />
	<input type="hidden" name="status" value="{$status}" />

	病院名：<a href="{Uri::create("doctor/{$hospital.m_hospital_id}")}" target="_blank">{$hospital.m_hospital_name}</a><br/>
	ニックネーム：{$review.t_hospital_review_nickname}<br/>
	内容：		{$review.t_hospital_review_message}<br/>
	ステータス：{ReviewStatus::$name[$status]}<hr/>

	<input type="submit" class="btn btn-default nonConfirmBtn" onclick="document.getElementById('ma_form').action = '{Uri::create("admin/review/edit")}';" value="戻る" />
	&nbsp;
	<input type="submit" class="btn btn-primary confirmBtn" onclick="document.getElementById('ma_form').action = '{Uri::create("admin/review/complete")}';" value="更新する" />
</form>