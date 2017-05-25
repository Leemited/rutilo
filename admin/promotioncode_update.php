<?php
	include_once("../common.php");
	if(!$is_admin){
		alert("권한이 없습니다.");
	}
	$page=$_POST['page'];
	$id=$_POST['id'];
	$code=$_POST['code'];
	$state=$_POST['state'];
    print_r($state);
	if($id){
		$sql="update `gsw_promotion` set `code`='{$code}',`state`='{$state}' where `id`='{$id}';";
	}else{
		$sql="insert into `gsw_promotion` (`code`,`state`) values ('{$code}','{$state}');";
	}
	sql_query($sql);
	alert('저장되었습니다.',G5_URL."/admin/promotioncode.php?page=".$page);