<?php
	include_once("../common.php");
	if(!$is_admin){
		alert("권한이 없습니다.");
	}
	$view=sql_fetch("select * from `gsw_product` where id='{$id}'");
	$dir=G5_DATA_PATH."/product";
	@unlink($dir."/".$view['photo']);
	sql_query("delete from `gsw_product` where `id`='{$id}'");
	alert('삭제 되었습니다.');