<div class="col-md-12 col-sm-12 col-xs-12">
	<div class="x_panel">
		<div class="x_content">
			<form action="admin/user">
				<input type="text" class="text" name="freeword" value="{$freeword|default}"/>
				{foreach from=St::$name key=k item=v}
					<input type="checkbox" class="selection" name="status[]" value="{$k}" {if in_array($k, $status|default:[])}checked="checked"{/if}>{$v}
				{/foreach}<br/>
				<!--button type="submit" class="btn btn-primary">検索</button-->
			</form>
			<div class="clearfix"></div>
			<ul class="nav navbar-right panel_toolbox">
				<li>
					<button type="button" class="btn btn-primary" onclick="location.href = 'admin/user/edit?ope={Ope::ADD}'">新規登録</button>
				</li>
			</ul>
			<div class="clearfix"></div>
		</div>
		<div class="x_content">
			{if count($list) > 0}
				<table class="table">
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
								<th scope="row">{$row.user_id}</th>
								<td>{$row.user_name}</td>
								<td>{$row.user_email}</td>
								<td>{$row.user_status}</td>
								<td><button type="button" class="btn btn-default btn-s" onclick="location.href = 'admin/user/edit?ope={Ope::MODIFY}&id={$row.user_id}'" >詳細</button></td>
							</tr>
						{/foreach}
					</tbody>
				</table>
			{else}
				該当データがありません。
			{/if}
			
		</div>
		<ul class="nav navbar-right panel_toolbox">
			<li>
				{$count}件
			</li>
			<li>
				{$pagination|default}
			</li>
		</ul>

	</div>
</div>
