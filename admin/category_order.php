<?php
	include_once("../common.php");
	if(!$is_admin){
		alert("권한이 없습니다.");
	}
	$view=sql_fetch("select od from `gsw_category` where id='{$id}'");
	if($od==0){
		$order=sql_fetch("select * from `gsw_category` where od < '{$view['od']}' order by od desc");
		if(!$order['od'])
			alert('더이상 순서를 올릴수 없습니다.');
	}else{
		$order=sql_fetch("select * from `gsw_category` where od > '{$view['od']}' order by od asc");
		if(!$order['od'])
			alert('더이상 순서를 내릴수 없습니다.');
	}
	sql_query("update `gsw_category` set `od`='{$view['od']}' where `id`='{$order['id']}'");
	sql_query("update `gsw_category` set `od`='{$order['od']}' where `id`='{$id}'");
	alert('변경 되었습니다.');