<?php
	include_once("../common.php");
	include_once(G5_PATH."/admin/head.php");
	if($id){
		$write=sql_fetch("select * from `gsw_sub_category` where id='".$id."'");
	}
	$sql="select * from `gsw_category` order by `od` asc";
	$query=sql_query($sql);
	while($data=sql_fetch_array($query)){
		$cate[]=$data;
	}
?>
<!-- 본문 start -->
<div id="wrap">
	<section>
		<header id="admin-title">
			<h1>소분류관리</h1>
			<hr />
		</header>
		<article id="admin_academy_write">
			<form action="<?php echo G5_URL."/admin/sub_category_update.php"; ?>" name="branch_form" id="branch_form" method="post" enctype="multipart/form-data">
				<input type="hidden" name="id" value="<?php echo $id; ?>" />
				<input type="hidden" name="page" value="<?php echo $page; ?>" />
				<input type="hidden" name="category" value="<?php echo $category; ?>" />
				<div class="adm-table02">
					<table>
						<tr>
							<th>대분류 이름 *</th>
							<td>
								<select name="cate" id="cate" required class="adm-input01 grid_100">
									<option value="">선택</option>
									<?php for($i=0;$i<count($cate);$i++){ ?>
									<option value="<?php echo $cate[$i]['cate']; ?>" <?php echo $cate[$i]['cate']==$write['cate']?"selected":""; ?>><?php echo $cate[$i]['cate']; ?></option>
									<?php } ?>
								</select>
							</td>
						</tr>
						<tr>
							<th>소분류 이름 *</th>
							<td><input type="text" name="sub_cate" id="sub_cate" required class="adm-input01 grid_100" value="<?php echo $write['sub_cate']; ?>" /></td>
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
