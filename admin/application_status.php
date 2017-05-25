<?php
	include_once("../common.php");
	if(!$is_admin){
		alert("권한이 없습니다.");
	}
	if(!$id || !isset($status) || $status==""){
		alert("잘못된 접근입니다.");
	}
	$sql="update `gsw_application` set `status`='{$status}' where `id`='{$id}';";
	sql_query($sql);
	alert('업데이트되었습니다.');