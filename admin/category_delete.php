<?php
	include_once("../common.php");
	if(!$is_admin){
		alert("권한이 없습니다.");
	}
	$view=sql_fetch("select od from `gsw_category` where id='{$id}'");
	sql_query("update `gsw_category` set `od`=`od`-1 where od > '{$view['od']}'");
	sql_query("delete from `gsw_category` where `id`='{$id}'");
	alert('삭제 되었습니다.');