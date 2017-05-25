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
<script src="http://dmaps.daum.net/map_js_init/postcode.v2.js"></script>
<!-- 본문 start -->
<div id="wrap">
	<section>
		<header id="admin-title">
			<h1>기본정보관리</h1>
			<hr />
		</header>
		<article>
			<form action="<?php echo G5_URL."/admin/config_update.php"; ?>" method="post" name="config" id="config" method="post" enctype="multipart/form-data">
				<div class="adm-table02">
					<table>
						<tr>
							<th>대표자이름</th>
							<td>
								<input type="text" name="name" id="name" placeholder="대표자이름" class="adm-input01 grid_100" value="<?php echo $config['name']; ?>" />
							</td>
						</tr>
						<tr>
							<th>주소</th>
							<td>
								<div class="grid_100">
									<input type="text" name="addr1" id="addr1" placeholder="주소" required class="adm-input01 grid_40" value="<?php echo $config['addr1']; ?>" />
									<input type="text" name="addr2" id="addr2" placeholder="상세주소" class="adm-input01 grid_40" value="<?php echo $config['addr2']; ?>" />
									<button type="button" class="text-center grid_20 lh30 white bg_gray" onclick="win_zip('config', 'mb_zip', 'addr1', 'addr2', 'addr3', 'mb_addr_jibeon');" style="border:0;">주소 검색</button>
									<input type="hidden" name="mb_zip" id="reg_mb_addr2" class="frm_input frm_address" size="50">
									<input type="hidden" name="addr3" id="reg_mb_addr3" class="frm_input frm_address" size="50" readonly="readonly">
									<input type="hidden" name="mb_addr_jibeon">
								</div>
							</td>
						</tr>
						<tr>
							<th>전화번호</th>
							<td><input type="tel" name="tel" id="tel" placeholder="전화번호" class="adm-input01 grid_100" required value="<?php echo $config['tel']; ?>" /></td>
						</tr>
						<tr>
							<th>문의번호</th>
							<td><input type="call" name="call" id="tel_accident" placeholder="문의번호" class="adm-input01 grid_100" required value="<?php echo $config['call']; ?>" /></td>
						</tr>
						<tr>
							<th>상담가능시간</th>
							<td>
								<input type="text" name="time" id="time" placeholder="AM 09:00 ~ PM 06:00" class="adm-input01 grid_100" value="<?php echo $config['time']; ?>" />
							</td>
						</tr>
						<tr>
							<th>이메일</th>
							<td><input type="email" name="email" id="email" placeholder="이메일" class="adm-input01 grid_100" required value="<?php echo $config['email']; ?>" /></td>
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
<?php
	include_once(G5_PATH."/admin/tail.php");
?>
