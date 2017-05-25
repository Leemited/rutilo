<?php
	include_once("../common.php");
	if(!$is_admin){
		alert("권한이 없습니다.");
	}
	$page=$_POST['page'];
	$id=$_POST['id'];
	$link=$_POST['link'];
	$target=$_POST['target'];
	$time=$_POST['time'];
	$status=$_POST['status']!=""&&$_POST['status']==0?"0":"1";
	if($id)
		$data=sql_fetch("select * from `gsw_popup` where id='".$id."'");
	$dir=G5_DATA_PATH."/popup";
	@mkdir($dir, G5_DIR_PERMISSION);
	@chmod($dir, G5_DIR_PERMISSION);
	$filename1=time()."_popup.jpg";
	$path1=$dir."/".$filename1;
	if($_FILES['popup']['tmp_name']){
		image_resize_update($_FILES['popup']['tmp_name'],$_FILES['popup']['name'], $path1, 2000);
		$popup=$filename1;
		$popup_sql=",`popup`='".$filename1."'";
		@unlink($dir."/".$data['popup']);
	}
	if($id){
		$sql="update `gsw_popup` set `link`='{$link}',`target`='{$target}',`status`='{$status}',`time`='{$time}'{$popup_sql} where `id`='{$id}';";
	}else{
		$sql="insert into `gsw_popup` (`popup`,`link`,`target`,`status`,`time`) values ('{$popup}','{$link}','{$target}','{$status}','{$time}');";
	}
	sql_query($sql);
	alert('저장되었습니다.',G5_URL."/admin/popup.php?page=".$page);