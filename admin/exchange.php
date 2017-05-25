<?php
	include_once("../common.php");
	include_once(G5_PATH."/admin/head.php");
	$config=sql_fetch("select * from gsw_config");
?>
<style type="text/css">
	.grid_20{width:20% !important;display:inline-block;float:left;box-sizing:border-box;}
	.text-center{text-align:center !important;}
	.lh30{line-height:30px !important;}
	.white{color:#fff !important;}
	.bg_gray{background:#666 !important;}
	.mt20{margin-top:20px !important;}
</style>
<!-- 본문 start -->
<div id="wrap">
	<section>
		<header id="admin-title">
			<h1>환율관리</h1>
			<hr />
		</header>
		<article>
			<form action="<?php echo G5_URL."/admin/exchange_update.php"; ?>" method="post" name="config" id="config" method="post" enctype="multipart/form-data">
				<div class="adm-table02">
					<table>
						<tr>
							<th>1000원당 위안</th>
							<td>
								<input type="text" name="exchange2" id="exchange2" placeholder="1000원당 중국통화" class="adm-input01 grid_100" value="<?php echo round((1000/$config['exchange']),4); ?>" />
							</td>
						</tr>
					
						<tr>
							<th>1위안당 한국통화</th>
							<td>
								<input type="text" name="exchange" id="exchange" placeholder="1위안당 한국통화" class="adm-input01 grid_100" value="<?php echo round($config['exchange'],4); ?>" />
							</td>
						</tr>
						<tr>
							<th>1000원당 달러</th>
							<td>
								<input type="text" name="exchange4" id="exchange4" placeholder="1000원당 달러" class="adm-input01 grid_100" value="<?php echo round((1000/$config['usexchange']),4); ?>" />
							</td>
						</tr>
						<tr>
							<th>1달러당 한국통화</th>
							<td>
								<input type="text" name="exchange3" id="exchange3" placeholder="1달러당 한국통화" class="adm-input01 grid_100" value="<?php echo round($config['usexchange'],4); ?>" />
							</td>
						</tr>
						<tr>
							<th>1달러당 위안</th>
							<td>
								<input type="text" name="exchange5" id="exchange5" placeholder="1위안당 한국통화" class="adm-input01 grid_100" value="<?php echo round($config['usexchange']/$config['exchange'],4); ?>" readonly="true"/>
							</td>
						</tr>
					</table>
				</div>
				<div class="text-center mt20">
					<input type="submit" value="확인" class="adm-btn01" />
				</div>
			</form>
		</article>
	</section>
</div>
<script type="text/javascript">
	$(function(){
		$("#exchange").keyup(function(){
			var exchange=$("#exchange").val();
			var exchange2=1000/exchange;
			exchange2=parseFloat(Math.round(exchange2 * 100)/100).toFixed(2)
			$("#exchange2").val(exchange2);
		});
		$("#exchange2").keyup(function(){
			var exchange2=$("#exchange2").val();
			var exchange=1000/exchange2;
			exchange=parseFloat(Math.round(exchange * 100)/100).toFixed(2)
			$("#exchange").val(exchange);
		});
		$("#exchange3").keyup(function(){
			var exchange3=$("#exchange3").val();
			var exchange4=1000/exchange3;
			exchange4=parseFloat(Math.round(exchange4 * 100)/100).toFixed(2)
			$("#exchange4").val(exchange4);
		});
		$("#exchange4").keyup(function(){
			var exchange4=$("#exchange4").val();
			var exchange3=1000/exchange4;
			exchange3=parseFloat(Math.round(exchange3 * 100)/100).toFixed(2)
			$("#exchange3").val(exchange3);
		});
	});
</script>
<?php
	include_once(G5_PATH."/admin/tail.php");
?>
