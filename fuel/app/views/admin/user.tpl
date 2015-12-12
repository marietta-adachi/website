<form id="ma_form" method="get" action="{Uri::create("admin/hospital")}">
	<input type="hidden" name="search" value="1" />
	

	
	フリーワード検索：<input type="text" name="free_word" value="{$free_word|default:''}" onkeydown="search();" placeholder="病院名／住所など" /><br/>
	ステータス：
	{foreach from=HospitalStatus::$name key=k item=v}
        <input type="checkbox" name="status[]" onchange="search_select()" value="{$k}" {if in_array($k, $status|default:array())}checked="checked"{/if}>{$v}
	{/foreach}<br/>
</form>

<br/>
<input type="button" value="新規登録" onclick="location.href='{Uri::create("admin/vendor/edit")}'" class="btn btn-primary btn-sizeFix"/>

<br/>
{$pagination}
<br/>
{$count_all}件
<div>
	{if count($hospital_list) > 0}
		<table class="table">
			<thead>
				<tr>
					{*<th>ID</th>*}
					<th>医療機関名</th>
					<th>ステータス</th>
					<th>操作</th>
				</tr>
			</thead>
			<tbody>
			{foreach from=$hospital_list item=hospital}
				<tr>
					{*<td>{$hospital.m_hospital_id}</td>*}
					<td>{$hospital.m_hospital_name}</td>
					
					<td>{HospitalStatus::$name[$hospital.m_hospital_status]}</td>
					<td>
						{*<input type="button" class="btn btn-default btn-xs" onclick="location.href='{Uri::create("admin/hospital/edit/{EditMode::MOD}/{$hospital.m_hospital_id}")}';" value="詳細">*}
					</td>
				</tr>
			{/foreach}
			</tbody>
		</table>
	{else}
		該当データがありません。
	{/if}
</div>