<?php
	include_once("../common.php");
	if(!$is_admin){
		alert("권한이 없습니다.");
	}
	if(!$id){
		alert("잘못된 접근입니다.");
	}
	$view=sql_fetch("select * from `gsw_popup` where id='{$id}'");
	$dir=G5_DATA_PATH."/popup";
	@unlink($dir."/".$view['popup']);
	$sql="delete from `gsw_popup` where `id`='{$id}';";
	sql_query($sql);
	alert('삭제되었습니다.');