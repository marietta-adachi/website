<script>
	$(function () {




	});
</script>
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


{*
<form id="ma_form" method="get" action="admin/hospital">
<input type="hidden" name="search" value="1" />



フリーワード検索：<input type="text" name="free_word" value="{$free_word|default:''}" onkeydown="search();" /><br/>
ステータス：
{foreach from=HospitalStatus::$name key=k item=v}
<input type="checkbox" name="status[]" onchange="search_select()" value="{$k}" {if in_array($k, $status|default:array())}checked="checked"{/if}>{$v}
{/foreach}<br/>
</form>

<br/>
<input type="button" value="新規登録" onclick="location.href = 'admin/vendor/edit'" class="btn btn-primary btn-sizeFix"/>

<br/>
{$pagination|default}
<br/>
{$count}件
<div>
{if count($user_list) > 0}

{else}
該当データがありません。
{/if}
</div>
*}