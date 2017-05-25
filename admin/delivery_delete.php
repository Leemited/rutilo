<?php
	include_once("../common.php");
	if(!$is_admin){
		alert("권한이 없습니다.");
	}
	if(!$id)
		alert("잘못된 접근입니다.");
	sql_query("delete from gsw_delivery where id='{$id}'");
	alert('삭제되었습니다.');