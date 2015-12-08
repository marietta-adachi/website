<form method="post" id="ma_form">{Form::csrf()}
	
	<input type="hidden" name="csv_type" value="{$csv_type}" />
	
	{if count($error_list) == 0}
	<div class="row">
		<p>以下のデータを取り込みます。</p>
		<div class="table-responsive">
			<table class="table table-striped table-bordered">
				<tr>
					<th width="20%">ファイル名</th>
					<td>{$file_name}</td>
				</tr>
				<tr>
					<th width="20%">データ件数</th>
					<td>{$count_all}</td>
				</tr>
			</table>
		</div>
	</div>
	<hr/>
	<div class="row btn_box">
		<div class="col-md-12 right_box">
			<input type="submit" class="btn btn-default btn-sizeFix nonConfirmBtn" onclick="document.getElementById('ma_form').action = '{Uri::create("admin/hospitalimport/edit")}';" value="戻る" />
			<input type="submit" class="btn btn-primary btn-sizeFix confirmBtn" onclick="document.getElementById('ma_form').action = '{Uri::create("admin/hospitalimport/complete")}';" value="取り込む" />
		</div>
	</div>

	{else}
	<div class="row">
		<p>エラーデータがあります。修正後したのち再インポートしてください。</p>
		<div class="table-responsive">
			<table class="table table-striped table-bordered">
				<tr>
					<th width="20%">ファイル名</th>
					<td>{$file_name}</td>
				</tr>
				<tr>
					<th width="20%">測定データ数</th>
					<td>{$count_all}</td>
				</tr>
				<tr>
					<th width="20%">正常データ</th>
					<td>{$count_valid}</td>
				</tr>
				<tr>
					<th width="20%">異常データ</th>
					<td>{$count_invalid}</td>
				</tr>
			</table>
		</div>
	</div>
	<br/>
	<div class="row">
		<label>エラー詳細</label><br>
		<table class="table table-striped table-bordered">
		{foreach from=$error_list item=error}
			<tr>
				<th width="20%">{$error[0]}行目</th>
				<td>{$error[1]}</span></td>
			</tr>
		{/foreach}
		</table>
		<a href="{Uri::create("tmp/{$error_file_name}")}" target="_blank">エラーファイルをダウンロード（{$error_file_name}）</a>
	</div>
	<hr/>
	<div class="row btn_box">
		<div class="col-md-12 right_box">
			<input type="submit" class="btn btn-default btn-sizeFix nonConfirmBtn" onclick="document.getElementById('ma_form').action = '{Uri::create("admin/hospitalimport/edit")}';" value="戻る" /><br/>
		</div>
	</div>
	{/if}
	
</form>