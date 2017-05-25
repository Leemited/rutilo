<?php
	include_once('../common.php');
	if(!$is_admin)
		alert("권한이 없습니다.");
	if(!$id || !$status)
		alert("잘못된 접근입니다.");
	$view=sql_fetch("select * from `gsw_order` where id='".$id."'");
	$sql="update `gsw_order` set `status`='{$status}' where `id`='{$id}';";
	if($view['status']>=0 && $status<0){
		$sql="update `gsw_order` set `status2`=`status`,`status`='{$status}' where `id`='{$id}';";
	}
	if($status=="-1"){
		$sql="update `gsw_order` set `status`=`status2` where `id`='{$id}';";
	}
	$query=sql_query($sql);
	alert('업데이트 되었습니다.');
?>