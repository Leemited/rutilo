<?php
	include_once("../common.php");
	include_once(G5_PATH."/admin/head.php");
	if($id){
		$write=sql_fetch("select * from `gsw_delivery` where id='".$id."'");
	}
?>
<!-- 본문 start -->
<div id="wrap">
	<section>
		<header id="admin-title">
			<h1>배송비관리</h1>
			<hr />
		</header>
		<article id="admin_academy_write">
			<form action="<?php echo G5_URL."/admin/delivery_update.php"; ?>" name="branch_form" id="branch_form" method="post" enctype="multipart/form-data">
				<input type="hidden" name="id" value="<?php echo $id; ?>" />
				<input type="hidden" name="page" value="<?php echo $page; ?>" />
				<input type="hidden" name="search" value="<?php echo $search; ?>" />
				<div class="adm-table02">
					<table>
						<tr>
							<th>무게 *</th>
							<td><input type="text" name="weight" id="weight" required class="adm-input01 grid_100" value="<?php echo $write['weight']; ?>" placeholder="kg" onkeyup="return float_only(this);" /></td>
						</tr>
						<tr>
							<th>가격 *</th>
							<td><input type="text" name="price" id="price" required class="adm-input01 grid_100" value="<?php echo $write['price']; ?>" onkeyup="return number_only(this);" /></td>
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
