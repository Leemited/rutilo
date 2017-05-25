<?php
	include_once("../common.php");
	include_once(G5_PATH."/admin/head.php");
	if($id){
		$write=sql_fetch("select * from `gsw_popup` where id='".$id."'");
	}
?>
<!-- 본문 start -->
<div id="wrap">
	<section>
		<header id="admin-title">
			<h1>팝업 관리</h1>
			<hr />
		</header>
		<article id="admin_academy_write">
			<form action="<?php echo G5_URL."/admin/popup_update.php"; ?>" name="branch_form" id="branch_form" method="post" enctype="multipart/form-data">
				<input type="hidden" name="id" value="<?php echo $id; ?>" />
				<input type="hidden" name="page" value="<?php echo $page; ?>" />
				<div class="adm-table02">
					<table>
						<tr>
							<th>팝업 *</th>
							<td><input type="file" name="popup" id="popup" <?php echo $id?"":"required"; ?> class="adm-input01 grid_100" value="<?php echo $write['popup']; ?>" /></td>
						</tr>
						<tr>
							<th>링크</th>
							<td><input type="text" name="link" id="link" class="adm-input01 grid_100" value="<?php echo $write['link']; ?>" /></td>
						</tr>
						<tr>
							<th>타겟</th>
							<td>
								<select name="target" id="target" class="adm-input01 grid_100">
									<option value="_self"<?php echo $write['target']=="_self"?" selected":""; ?>>_self(현재창 이동)</option>
									<option value="_blank"<?php echo $write['target']=="_blank"?" selected":""; ?>>_blank(새창 이동)</option>
								</select>
							</td>
						</tr>
						<tr>
							<th>시간</th>
							<td><input type="text" name="time" id="time" class="adm-input01 grid_100" value="<?php echo $write['time']?$write['time']:24; ?>" onkeyup="return number_only(this);" /></td>
						</tr>
						<tr>
							<th>상태</th>
							<td><label for="status"><input type="checkbox" name="status" id="status" value="0" <?php echo $write['status']!=0&&$write['status']==0?" checked":""; ?> /> 안보이게</label></td>
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
