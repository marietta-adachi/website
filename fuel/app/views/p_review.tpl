{if $device=="other"}{*PC-------------------------------------------------------------------------------*}
<div id="Reviews">
	<h2>{$hospital.m_hospital_name}の口コミ</h2>
	
	<button class="button" id="post_review">口コミを投稿する</button>
	
	<ul id="review_list">
	</ul>
	<span id="no_review">{$hospital.m_hospital_name}の口コミはありません。</span>
</div>

<div id="review_dialog" title="{$hospital.m_hospital_name}のオススメ情報">
	{* 入力 *}
	<div id="form_review_edit">
		<h2>{$hospital.m_hospital_name}のオススメ情報を入力してください。</h2>
		<div id="ReviewAttention">
			
		</div>
		
		<input type="text" id="review_nickname" placeholder="ニックネーム"/><br>
		<div id="err_review_nickname" class="err">ニックネームを入力してください</div>
		<textarea id="review_message" rows="10" cols="50" maxlength="1000"  placeholder="ここにオススメ情報を記入してください"></textarea>
		<div id="err_review_message" class="err">オススメ情報を入力してください</div>
		<button class="button" id="review_confirm">確認</button>
	</div>
	
	{* 確認 *}
	<div id="form_review_confirm">
		<h2>この内容で投稿しますか？</h2>
		<dl>
			<dt>医療機関名 </dt>
			<dd >{$hospital.m_hospital_name}</dd>
			<dt>お名前 </dt>
			<dd id="review_nickname_c"></dd>
			<dt>投稿内容 </dt>
			<dd id="review_message_c"></dd>
		</dl>
		<br>
		<button type="button" class="button" id="review_complete">投稿する</button>
		<button type="button" class="button back" id="review_return">もどる</button>
	</div>
	
	{* 完了 *}
	<div id="form_review_complete">
		投稿ありがとうございます。<br/>
		掲載されるまでしばらくお待ちください。<br>
		<button type="button" class="button back" id="review_close">閉じる</button>
	</div>
</div>
{else}{*PC以外------------------------------------------------------------------------------------------*}
<ul id="review_list"></ul>
<span id="no_review">{$hospital.m_hospital_name}の口コミはありません。</span>
<button class="btn review full_size" id="post_review" style="border:none; box-shadow:none; background-color:#1DA1DA; color:#FFFFFF; text-shadow:none; border-radius:0;">口コミを投稿する</button>
{/if}

{if $device=="other"}{*PC-------------------------------------------------------------------------------*}
<script type="text/javascript">
$(function(){
	setReview();
	initReviewForm();
})

function setReview(){
	
	$.ajax({
		type: "POST",
		dataType: "json",
		url: base_url + "rest/ajax/review/get.json",
		data: {
			hospital_id: {$hospital.m_hospital_id},
		},
		success: function (data) {
			{* 投稿可否 *}
			$("#post_review").toggle(!data.reviewed);
			
			if(data.review.length > 0){
				var ul = $("#review_list");
				ul.show();
				ul.find("li").remove();
				for(var i in data.review){
					var li = "<li><b>" + data.review[i].t_hospital_review_nickname + "さんのコメント<time content='" + data.review[i].t_hospital_review_created_at + "'>【" + data.review[i].t_hospital_review_created_at + " 記入】</time></b>" + data.review[i].t_hospital_review_message + "</li>"
					ul.append(li);
				}
				$("#no_review").toggle(false);
			}else{
				console.log("no");
				$("#no_review").toggle(true);
				$("#review_list").toggle(false);
			}
		},
		error: function (data) {
			alert(data.responseJSON.message);
		}
	});
}

function initReviewForm(){
	$("#disp_review_coution").click(function(){
		$("#review_coution").toggleClass("on");
	});
	
	{* ダイアログ設定 *}
	$("#review_dialog").dialog({
		autoOpen: false,
		modal : true,
		width : 620,
		//height : 600,
	});
	
	{* 入力 *}
	$("#post_review").click(function(){
		$("#review_dialog").dialog("open");
		$("#review_nickname").val("");
		$("#review_message").val("");
		/*$("#err_review_nickname").text("");*/
		/*$("#err_review_message").text("");*/
		changeReviewForm("edit");
		/*$("header").addClass("dialog_on");
		$("#result_doctor").addClass("dialog_on");
		$("footer").addClass("dialog_on");
		$("#fixedHeader").addClass("dialog_on");*/
	});
	
	{* 戻る *}
	$("#review_return").click(function(){
		changeReviewForm("edit");
	});
	
	{* 確認 *}
	$("#review_confirm").click(function(){
		var nickname = $("#review_nickname").val();
		var message = $("#review_message").val();
		var err = false;
		if(nickname == ""){
			$("#err_review_nickname").css("display","block");
			err = true;
		}else{
			$("#err_review_nickname").css("display","none");
			err = false;
		}
		if(message == ""){
			$("#err_review_message").css("display","block");
			err = true;
		}else{
			$("#err_review_message").css("display","none");
			err = false;
		}
		if(err){
			return;
		}
		$("#review_nickname_c").text(nickname);
		$("#review_message_c").text(message);
		changeReviewForm("confirm");
	});
	
	{* 送信 *}
	$("#review_complete").click(function(){
		$.ajax({
			type: "POST",
			dataType: "json",
			url: base_url + "rest/ajax/review/regist.json",
			data: {
				hospital_id: {$hospital.m_hospital_id},
				nickname: $("#review_nickname").val(),
				message: $("#review_message").val(),
			},
			success: function (data) {
				changeReviewForm("complete");
			},
			error: function (data) {
				alert(data.responseJSON.message);
			}
		});
	});
	
	{* 閉じる *}
	$("#review_close").click(function(){
		$("#review_dialog").dialog("close");
		setReview();
	});
}

function changeReviewForm(mode){
	$("#form_review_edit").toggle(mode == "edit");
	$("#form_review_confirm").toggle(mode == "confirm");
	$("#form_review_complete").toggle(mode == "complete");
}

</script>
{else}{*PC以外------------------------------------------------------------------------------------------*}
<script type="text/javascript">
$(function(){
	setReview();
	initReviewForm();
})

function setReview(){
	
	$.ajax({
		type: "POST",
		dataType: "json",
		url: base_url + "rest/ajax/review/get.json",
		data: {
			hospital_id: {$hospital.m_hospital_id},
		},
		success: function (data) {
			{* 投稿可否 *}
			$("#post_review").toggle(!data.reviewed);
			
			if(data.review.length > 0){
				var ul = $("#review_list");
				ul.show();
				ul.find("li").remove();
				for(var i in data.review){
					var li = "<li><b>" + data.review[i].t_hospital_review_nickname + "さんのコメント</b><br>" + data.review[i].t_hospital_review_message + "<br><time content='" + data.review[i].t_hospital_review_created_at + "'>（" + data.review[i].t_hospital_review_created_at + "）</time></li>"
					ul.append(li);
				}
				$("#no_review").toggle(false);
			}else{
				console.log("no");
				$("#no_review").toggle(true);
				$("#review_list").toggle(false);
			}
		},
		error: function (data) {
			alert(data.responseJSON.message);
		}
	});
}

function initReviewForm(){
	$("#disp_review_coution").click(function(){
		$("#review_coution").toggleClass("on");
	});
	
	{* 入力 *}
	$("#post_review").click(function(){
		/*$("#review_dialog").dialog("open");*/
		$("#review_nickname").val("");
		$("#review_message").val("");
		/*$("#err_review_nickname").text("");*/
		/*$("#err_review_message").text("");*/
		changeReviewForm("edit");
		/*$("header").addClass("dialog_on");
		$("#result_doctor").addClass("dialog_on");
		$("footer").addClass("dialog_on");
		$("#fixedHeader").addClass("dialog_on");*/
	});
	
	{* 戻る *}
	$("#review_return").click(function(){
		changeReviewForm("edit");
	});
	
	{* 確認 *}
	$("#review_confirm").click(function(){
		var nickname = $("#review_nickname").val();
		var message = $("#review_message").val();
		var err = false;
		if(nickname == ""){
			$("#err_review_nickname").css("display","block");
			err = true;
		}else{
			$("#err_review_nickname").css("display","none");
			err = false;
		}
		if(message == ""){
			$("#err_review_message").css("display","block");
			err = true;
		}else{
			$("#err_review_message").css("display","none");
			err = false;
		}
		if(err){
			return;
		}
		$("#review_nickname_c").text(nickname);
		$("#review_message_c").text(message);
		changeReviewForm("confirm");
	});
	
	{* 送信 *}
	$("#review_complete").click(function(){
		$.ajax({
			type: "POST",
			dataType: "json",
			url: base_url + "rest/ajax/review/regist.json",
			data: {
				hospital_id: {$hospital.m_hospital_id},
				nickname: $("#review_nickname").val(),
				message: $("#review_message").val(),
			},
			success: function (data) {
				changeReviewForm("complete");
			},
			error: function (data) {
				alert(data.responseJSON.message);
			}
		});
	});
	
	{* 閉じる *}
	$("#review_close").click(function(){
		$("#review_dialog").hide();
		$(".star_box").hide();
		$("main").show();
		setReview();
	});
}

function changeReviewForm(mode){
	$("#form_review_edit").toggle(mode == "edit");
	$("#form_review_confirm").toggle(mode == "confirm");
	$("#form_review_complete").toggle(mode == "complete");
}


</script>

{/if}