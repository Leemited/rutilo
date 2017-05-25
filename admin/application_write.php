<?php
	include_once("../common.php");
	include_once(G5_PATH."/admin/head.php");
	if($id){
		$write=sql_fetch("select * from `gsw_application` where id='".$id."'");
	}
	$academy_sql="select * from `gsw_academy`";
	$academy_query=sql_query($academy_sql);
	$i=0;
	while($academy_data=sql_fetch_array($academy_query)){
		$academy_array[$i]=$academy_data;
		$i++;
	}
?>
<!-- 본문 start -->
<div id="wrap">
	<section>
		<header id="admin-title">
			<h1>온라인신청관리</h1>
			<hr />
		</header>
		<article id="admin_academy_write">
			<form action="<?php echo G5_URL."/admin/application_update.php"; ?>" name="branch_form" id="branch_form" method="post" enctype="multipart/form-data">
				<input type="hidden" name="id" value="<?php echo $id; ?>" />
				<input type="hidden" name="page" value="<?php echo $page; ?>" />
				<input type="hidden" name="sel" value="<?php echo $sel; ?>" />
				<input type="hidden" name="search" value="<?php echo $search; ?>" />
				<input type="hidden" name="academy" value="<?php echo $academy; ?>" />
				<input type="hidden" name="status" value="<?php echo $status; ?>" />
				<div class="adm-table02">
					<table>
						<tr>
							<th>이름 *</th>
							<td><input type="text" name="mb_name" id="mb_name" required class="adm-input01 grid_100" value="<?php echo $write['mb_name']; ?>" /></td>
						</tr>
						<tr>
							<th>연락처 *</th>
							<td><input type="text" name="mb_hp" id="mb_hp" required class="adm-input01 grid_100" value="<?php echo $write['mb_hp']; ?>" /></td>
						</tr>
						<tr>
							<th>수강인원 *</th>
							<td><input type="text" name="person" id="person" required class="adm-input01 grid_100" value="<?php echo $write['person']; ?>" onkeyup="return number_only(this);" /></td>
						</tr>
						<tr>
							<th>수강일자 *</th>
							<td>
								<select name="academy_id" class="adm-input01 grid_100" id="academy_id">
									<option value="">아카데미 선택</option>
									<?php
									for($i=0;$i<count($academy_array);$i++){
									?>
									<option value="<?php echo $academy_array[$i]['id']; ?>"<?php echo $academy_array[$i]['id']==$write['academy_id']?" selected":""; ?>><?php echo $academy_array[$i]['name']; ?>(<?php echo $academy_array[$i]['start']; ?>~<?php echo $academy_array[$i]['end']; ?>)</option>
									<?php
									}
									?>
								</select>
							</td>
						</tr>
						<tr>
							<th>상태 *</th>
							<td>
								<select name="status" class="adm-input01 grid_100" id="status">
									<option value="">선택</option>
									<option value="0"<?php echo $status!=""&&$write['status']==0?" selected":""; ?>>대기</option>
									<option value="1"<?php echo $status!=""&&$write['status']==1?" selected":""; ?>>승인</option>
									<option value="-1"<?php echo $status!=""&&$write['status']==-1?" selected":""; ?>>취소</option>
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
<?php
	include_once(G5_PATH."/admin/tail.php");
?>
