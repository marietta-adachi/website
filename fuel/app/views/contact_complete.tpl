{if $device=="other"}{*PC-------------------------------------------------------------------------------*}
<section class="container" id="Thanks">
	<div class="feedback">
		<ul id="breadcrumb" itemscope itemtype="http://data-vocabulary.org/Breadcrumb">
			<li><a href="/" itemprop="url"><span itemprop="title">トップ</span></a></li>
			<li><span itemprop="title">お問い合わせ内容送信完了</span></li>
		</ul>
		<br>
		<div class="container block feedback_do" style=" padding:0; margin-top:20px; word-break: break-all;">
			<h1>お問い合わせ内容送信完了</h1>
			<p style="padding: 100px 0; font-size: 16px;" class="align_c">
			お問い合わせを承りました。
			</p>
			<div class="back_top">
				<a href="{Uri::base()}" class="button"><span>トップへ戻る</span></a>
			</div>
		</div>
	</div>
</section>
{else}{*PC以外------------------------------------------------------------------------------------------*}
<section class="container" id="Thanks">
{*	<h2 style="text-align:center; background-color:#007AC3; padding:20px 0; color:#FFFFFF;">お問い合わせ内容送信完了</h2>*}
	<div class="inner">
		<p style="padding: 100px 0;" class="align_c">
		お問い合わせを承りました。
		</p>
		<div style="margin-bottom:20px;" class="align_c">
			<a href="{Uri::base()}" class="btn to_send"><span>トップへ戻る</span></a>
		</div>
	</div>
</section>
{/if}