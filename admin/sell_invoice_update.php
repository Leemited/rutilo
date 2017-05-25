<?php
	include_once('../common.php');
	if(!$is_admin)
		alert("권한이 없습니다.");
	$id=$_POST['id'];
	$company=$_POST['company'];
	$invoice=$_POST['invoice'];
	if($id){
		$sql="update `gsw_order` set `company`='{$company}',`invoice`='{$invoice}',`status`=2 where `id`='{$id}';";
	}else{
		alert("잘못된 접근입니다.");
	}
	$query=sql_query($sql);
	alert('업데이트 되었습니다.');
?>