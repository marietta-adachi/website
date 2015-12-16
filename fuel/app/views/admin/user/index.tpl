<form id="ma_form" method="get" action="admin/user">
	<input type="hidden" name="search" value="1" />
	フリーワード：<input type="text" name="freeword" value="{$freeword|default}" onkeydown="search();" /><br/>
	ステータス：
	{foreach from=St::$name key=k item=v}
		<input type="checkbox" name="status[]" onchange="search_select()" value="{$k}" {if in_array($k, $status|default:[])}checked="checked"{/if}>{$v}
	{/foreach}<br/>
	<button type="submit" class="btn btn-primary">検索</button>
</form>
<div class="clearfix"></div>
<button type="button" class="btn btn-primary" onclick="location.href='admin/user/edit?ope={Ope::ADD}'">新規登録</button>

<div class="clearfix"></div>
{$pagination|default}
<div class="clearfix"></div>
{$count}件
<div>
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
					<td><button type="button" class="btn btn-default btn-xs" onclick="location.href = 'admin/user/edit?ope={Ope::MODIFY}&id={$row.user_id}'" >詳細</button></td>
				</tr>
				{/foreach}
			</tbody>
		</table>
	{else}
		該当データがありません。
	{/if}
</div>
<div class="clearfix"></div>
{*
<div class="col-md-12 col-sm-12 col-xs-12">
	<div class="x_panel">
		<div class="x_title">
			<h2>Basic Tables <small>basic table subtitle</small></h2>
			<ul class="nav navbar-right panel_toolbox">
				<li><a class="collapse-link"><i class="fa fa-chevron-up"></i></a>
				</li>
				<li class="dropdown">
					<a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-expanded="false"><i class="fa fa-wrench"></i></a>
					<ul class="dropdown-menu" role="menu">
						<li><a href="#">Settings 1</a>
						</li>
						<li><a href="#">Settings 2</a>
						</li>
					</ul>
				</li>
				<li><a class="close-link"><i class="fa fa-close"></i></a>
				</li>
			</ul>
			<div class="clearfix"></div>
		</div>
		<div class="x_content">

			<table class="table">
				<thead>
					<tr>
						<th>#</th>
						<th>First Name</th>
						<th>Last Name</th>
						<th>Username</th>
					</tr>
				</thead>
				<tbody>
					<tr>
						<th scope="row">1</th>
						<td>Mark</td>
						<td>Otto</td>
						<td>@mdo</td>
					</tr>
					<tr>
						<th scope="row">2</th>
						<td>Jacob</td>
						<td>Thornton</td>
						<td>@fat</td>
					</tr>
					<tr>
						<th scope="row">3</th>
						<td>Larry</td>
						<td>the Bird</td>
						<td>@twitter</td>
					</tr>
				</tbody>
			</table>

		</div>
	</div>
</div>
*}
<script>


</script>