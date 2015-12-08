<form id="ma_form" method="get" action="{Uri::create("admin/review")}">
	<input type="hidden" name="search" value="1" />
	フリーワード検索：<input type="text" name="free_word" value="{$free_word|default:''}" onkeydown="search();" placeholder="" /><br/>
	ステータス：
	{foreach from=ReviewStatus::$name key=k item=v}
        <input type="checkbox" name="status[]" onchange="search_select()" value="{$k}" {if in_array($k, $status|default:array())}checked="checked"{/if}>{$v}
	{/foreach}<br/>
	
	<div class="col-lg-7 col-md-4">
		<div class="form-group form-inline">
		<label>並び替え</label><br>
		<select class="form-control" name="order" onchange="search_select()">
			{foreach from=$order_list key=k item=v}
			<option value="{$k}" {if $k == $selected_order}selected{/if}>{$v}</option>
			{/foreach}
		</select>
		</div>
	</div>
</form>

<br/>
{$pagination}
<br/>
{$count_all}件
<div>
	{if count($review_list) > 0}
		<table class="table">
			<thead>
				<tr>
					{*<th>ID</th>*}
					<th>投稿日</th>
					<th>ニックネーム</th>
					<th>病院名</th>
					<th>口コミ</th>
					<th>ステータス</th>
					<th>操作</th>
				</tr>
			</thead>
			<tbody>
			{foreach from=$review_list item=review}
				<tr>
					{*<td>{$review.t_hospital_review_id}</td>*}
					<td>{$review.t_hospital_review_created_at}</td>
					<td>{$review.t_hospital_review_nickname}</td>
					<td>{$review.m_hospital_name}</td>
					<td>{$review.t_hospital_review_message}</td>
					<td>{ReviewStatus::$name[$review.t_hospital_review_status]}</td>
					<td>
						<input type="button" class="btn btn-default btn-xs" onclick="location.href='{Uri::create("admin/review/edit/{$review.t_hospital_review_id}")}';" value="詳細">
					</td>
				</tr>
			{/foreach}
			</tbody>
		</table>
	{else}
		該当データがありません。
	{/if}
</div>