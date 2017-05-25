<?php
	include_once("../common.php");
	if(!$is_admin){
		alert("권한이 없습니다.");
	}
	$exchange=$_POST['exchange'];
	$usexchange=$_POST['exchange3'];
	sql_query("update `gsw_config` set `exchange`='{$exchange}', `usexchange`='{$usexchange}';");
	alert('저장되었습니다.');