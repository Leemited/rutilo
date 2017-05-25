<?php
	include_once("../common.php");
	if(!$is_admin){
		alert("권한이 없습니다.");
	}
	if($mb_no==1){
		alert("관리자는 삭제 하실 수 없습니다.");
	}
	sql_query("delete from `g5_member` where mb_no='{$mb_no}'");
	alert("삭제 되었습니다.");
?>