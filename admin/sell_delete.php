<?php
	include_once('../common.php');
	if(!$is_admin)
		alert("권한이 없습니다.");
	if(!$id)
		alert("잘못된 접근입니다.");
	//$view=sql_fetch("select *,s.datetime as datetime,s.id as id,s.number as number,s.content as content from `gsw_sell` as s inner join `gsw_product` as p on s.product_id=p.id where s.id='".$id."'");
	$sql="delete from `gsw_order` where `id`='{$id}';";
	$query=sql_query($sql);
	alert('삭제 되었습니다.');
?>