<?php
	include_once("../common.php");
	if(!$is_admin){
		alert("권한이 없습니다.");
	}
	$page=$_POST['page'];
	$id=$_POST['id'];
	$link=$_POST['link'];
	$target=$_POST['target'];
	$status=$_POST['status']!=""&&$_POST['status']==0?"0":"1";
	if($id)
		$data=sql_fetch("select * from `gsw_banner` where id='".$id."'");
	$dir=G5_DATA_PATH."/banner";
	@mkdir($dir, G5_DIR_PERMISSION);
	@chmod($dir, G5_DIR_PERMISSION);
	$filename1=time()."_banner.jpg";
	$path1=$dir."/".$filename1;
	if($_FILES['banner']['tmp_name']){
		image_resize_update($_FILES['banner']['tmp_name'],$_FILES['banner']['name'], $path1);
		$banner=$filename1;
		$banner_sql=",`banner`='".$filename1."'";
		@unlink($dir."/".$data['banner']);
	}
	if($id){
		$sql="update `gsw_banner` set `link`='{$link}',`target`='{$target}',`status`='{$status}'{$banner_sql} where `id`='{$id}';";
	}else{
		$sql="insert into `gsw_banner` (`banner`,`link`,`target`,`status`) values ('{$banner}','{$link}','{$target}','{$status}');";
	}
	sql_query($sql);
	alert('저장되었습니다.',G5_URL."/admin/banner.php?page=".$page);