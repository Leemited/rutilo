<?php
	include_once("../common.php");
	include_once(G5_PATH."/admin/head.php");
	if($id){
		$write=sql_fetch("select * from `gsw_code` where id='".$id."'");
	}
?>
<!-- 본문 start -->
<div id="wrap">
	<section>
		<header id="admin-title">
			<h1>판매자관리</h1>
			<hr />
		</header>
		<article id="admin_academy_write">
			<form action="<?php echo G5_URL."/admin/seller_update.php"; ?>" name="branch_form" id="branch_form" method="post" enctype="multipart/form-data">
				<input type="hidden" name="id" value="<?php echo $id; ?>" />
				<input type="hidden" name="page" value="<?php echo $page; ?>" />
				<input type="hidden" name="sel" value="<?php echo $sel; ?>" />				
				<input type="hidden" name="search" value="<?php echo $search; ?>" />
				<div class="adm-table02">
					<table>
						<tr>
							<th>코드 *</th>
							<td><input type="text" name="code" id="code" required class="adm-input01 grid_100" value="<?php echo strtoupper($write['code']); ?>" /></td>
						</tr>
						<tr>
							<th>관리자 아이디 *</th>
							<td><input type="text" name="mb_id" id="mb_id" class="adm-input01 grid_100" value="<?php echo $write['mb_id']; ?>" /></td>
						</tr>
						<tr>
							<th>할인율 *</th>
							<td><input type="text" name="sale" id="sale" required class="adm-input01 grid_100" value="<?php echo $write['sale']; ?>" maxlength="2" onkeyup="return number_only(this);" placeholder="00%" /></td>
						</tr>
                        <tr>
                            <th>수수료 *</th>
                            <td><input type="text" name="fees" id="fees" required class="adm-input01 grid_100" value="<?php echo $write['fees']; ?>" maxlength="2" onkeyup="return number_only(this);" placeholder="00%"/></td>
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
