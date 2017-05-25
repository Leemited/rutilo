<?php
	include_once("../common.php");
	if(!$is_admin){
		alert("권한이 없습니다.");
	}
	$page=$_POST['page'];
	$id=$_POST['id'];
	$weight=$_POST['weight'];
	$price=$_POST['price'];
	if($id){
		$sql="update `gsw_delivery` set `weight`='{$weight}',`price`='{$price}' where `id`='{$id}';";
	}else{
		$sql="insert into `gsw_delivery` (`weight`,`price`) values ('{$weight}','{$price}');";
	}
	sql_query($sql);
	alert('저장되었습니다.',G5_URL."/admin/delivery.php?page=".$page);