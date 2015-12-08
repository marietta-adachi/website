<form method="post" id="ma_form" enctype="multipart/form-data">{Form::csrf()}
	<input type="hidden" name="csv_type" value="{$csv_type}" />
	<div class="row">
		<div class="col-md-12">
			<label>{CsvType::$name[$csv_type]}CSV</label><span class="attention">*</span>
			<input type="file" id="csv" name="csv" multiple><span class="attention">{$errors.csv|default:''}</span><br/>
		</div>
	</div>
	<hr/>
	<div class="row btn_box">
		<div class="col-md-12 right_box">
			<input type="submit" class="btn btn-default btn-sizeFix" onclick="document.getElementById('ma_form').action = '{Uri::create("admin/hospitalimport")}';" value="戻る" />
			<input type="submit" class="btn btn-primary btn-sizeFix" onclick="document.getElementById('ma_form').action = '{Uri::create("admin/hospitalimport/confirm")}';" value="確認" />
		</div>
	</div>
</form>

<script type="text/javascript">
$(function(){
	
	// ファイルサイズチェック
	$('#csv').bind('change', function() {
		// 合計ファイルサイズを算出
		var size = 0;
		jQuery.each(this.files, function() {
			size += this.size;
		});
		
		// ファイルサイズチェック
		var mb = 10;
		if(size > (1048576 * mb)) {
			$('#csv').val('');
			alert('アップロードできるファイルのサイズは' + mb + 'MBまでです。');
		}
	});
});
</script>