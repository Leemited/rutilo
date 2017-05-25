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
	$sql="select * from `gsw_sub_category` order by `od` asc";
	$query=sql_query($sql);
	while($data=sql_fetch_array($query)){
		$cate2[]=$data;
	}
?>
<!-- 본문 start -->
<div id="wrap">
	<section>
		<header id="admin-title">
			<h1>배너관리</h1>
			<hr />
		</header>
		<article id="admin_academy_write">
			<form action="<?php echo G5_URL."/admin/category_banner_update.php"; ?>" name="branch_form" id="branch_form" method="post" enctype="multipart/form-data">
				<input type="hidden" name="id" value="<?php echo $id; ?>" />
				<input type="hidden" name="page" value="<?php echo $page; ?>" />
				<input type="hidden" name="category" value="<?php echo $category; ?>" />
				<input type="hidden" name="sub_category" value="<?php echo $sub_category; ?>" />
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
							<th>배너 *</th>
							<td>
								<input type="file" name="banner" id="banner" <?php $id?"":"required"; ?> />
							</td>
						</tr>
						<tr>
							<th>링크</th>
							<td>
								<input type="text" name="link" id="link" class="adm-input01 grid_100" value="<?php echo $write['link']; ?>" />
							</td>
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
		cate_chage();
		$("#cate").change(function(){
			cate_chage();
		});
	});
	function cate_chage(){
			var cate=$("#cate").val();
			var len=$("#sub_cate option").length;
			for(i=1;i<len;i++){
				var data_cate=$("#sub_cate option").eq(i).attr("data-cate");
				if(data_cate!=cate){
					$("#sub_cate option").eq(i).hide();
				}else{
					$("#sub_cate option").eq(i).show();
				}
			}
		}
</script>
<?php
	include_once(G5_PATH."/admin/tail.php");
?>
