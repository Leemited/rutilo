<?php
	include_once("../common.php");
	if(!$is_admin){
		alert("권한이 없습니다.");
	}
	if($mb_no==1){
		alert("관리자는 정지 시킬 수 없습니다.");
	}
	$now=date("Ymd");
	$fetch=sql_fetch("select * from `g5_member` where `mb_no`='{$mb_no}'");
	if($fetch['mb_intercept_date'] || $fetch['mb_leave_date']){
		sql_query("update `g5_member` set `mb_intercept_date`='', `mb_leave_date`='' where mb_no='{$mb_no}'");
	}else{
		sql_query("update `g5_member` set `mb_intercept_date`='{$now}' where mb_no='{$mb_no}'");
	}
	alert("변경 되었습니다.");
?>