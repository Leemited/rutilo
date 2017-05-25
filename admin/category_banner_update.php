<?php
	include_once("../common.php");
	if(!$is_admin){
		alert("권한이 없습니다.");
	}
	$page=$_POST['page'];
	$id=$_POST['id'];
	$category=$_POST['category'];
	$sub_category=$_POST['sub_category'];
	$cate=$_POST['cate'];
	$od=sql_fetch("select * from `gsw_category_banner` where `cate`='".$cate."' order by od desc");
	$od=$od['od']+1;
	if($id)
		$b_cate=sql_fetch("select * from `gsw_category_banner` where id='".$id."'");
	$dir=G5_DATA_PATH."/cate_banner";
	@mkdir($dir, G5_DIR_PERMISSION);
	@chmod($dir, G5_DIR_PERMISSION);
	$filename1=time()."_banner.jpg";
	$path1=$dir."/".$filename1;
	if($_FILES['banner']['tmp_name']){
		image_resize_update($_FILES['banner']['tmp_name'],$_FILES['banner']['name'], $path1, 2000);
		$banner=$filename1;
		$banner_sql=",`banner`='".$filename1."'";
		@unlink($dir."/".$b_cate['banner']);
	}
	if($id){
		if($b_cate['cate']!=$cate){
			$od_sql=", od={$od}";
		}
		$sql="update `gsw_category_banner` set `cate`='{$cate}' {$od_sql} {$banner_sql} where `id`='{$id}';";
	}else{
		$sql="insert into `gsw_category_banner` (`banner`,`cate`,`od`) values ('{$banner}','{$cate}','{$od}');";
	}
	sql_query($sql);
	alert('저장되었습니다.',G5_URL."/admin/category_banner.php?page=".$page."&category=".$category."&sub_category=".$sub_category);