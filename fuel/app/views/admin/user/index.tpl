<form action="admin/user">
	<div class="row">
		<div class="col-xs-12">

			<div class="form-group">
				<label for="freeword">フリーワード：</label>
				<input type="text" id="freeword" class="form-control text" name="freeword" value="{$freeword|default}"/>
			</div>
			<div class="form-group">
				<label for="status">ステータス：</label>
				{foreach from=St::$name key=k item=v}
					<input type="checkbox" id="status" class="selection" name="status[]" value="{$k}" {if in_array($k, $status|default:[])}checked="checked"{/if}>{$v}
				{/foreach}

				<!--label for="selection">Selection:</label>
				<select id="selection" class="form-control">
					<option>AAA
					<option>BBB
				</select-->
			</div>
			<!--button type="submit" class="btn btn-primary">検索</button-->

		</div>
	</div>
</form>
<div class="row">
	<div class="col-xs-3">
		<button type="button" class="btn btn-primary" onclick="location.href = 'admin/user/edit?ope={Ope::ADD}'">新規登録</button>
	</div>
</div>

<ul class="nav navbar-right panel_toolbox">
	<li>
		{$count}件
	</li>
	<li>
		{$pagination|default}
	</li>
</ul>
<div class="table-responsive">
	{if count($list) > 0}
		<table class="table table-hover">
			<thead>
				<tr>
					<th>ID</th>
					<th>お名前</th>
					<th>メールアドレス</th>
					<th>ステータス</th>
					<th>詳細</th>
				</tr>
			</thead>
			<tbody>
				{foreach from=$list item=row}
					<tr>
						<th scope="row">{$row.id}</th>
						<td>{$row.name}</td>
						<td>{$row.email}</td>
						<td>{St::$name[$row.status]}</td>
						<td><button type="button" class="btn btn-default btn-s" onclick="location.href = 'admin/user/edit?id={$row.id}&ope={Ope::MODIFY}'" >詳細</button></td>
					</tr>
				{/foreach}
			</tbody>
		</table>
	{else}
		該当データがありません。
	{/if}
</div>

