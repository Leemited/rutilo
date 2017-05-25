<?php
	include_once("../common.php");
	if(!$is_admin){
		alert("권한이 없습니다.");
	}
	$page=$_POST['page'];
	$id=$_POST['id'];
	$cate=$_POST['cate'];
	$n_cate=sql_fetch("select * from `gsw_category` where `cate`='".$cate."' and `id`<>'".$id."'");
	$od=sql_fetch("select od from `gsw_category` order by od desc");
	$od=$od['od']+1;
	if($n_cate['cate']){
		alert("'".$n_cate['cate']."'는 이미 사용하고 있는 대분류입니다.");
	}
	if($id){
		$b_cate=sql_fetch("select * from `gsw_category` where id='".$id."'");
		$sql="update `gsw_category` set `cate`='{$cate}' where `id`='{$id}';";
	}else{
		$sql="insert into `gsw_category` (`cate`,`od`) values ('{$cate}','{$od}');";
	}
	sql_query($sql);
	if($id){
		sql_query("update `gsw_product` set `category`='{$cate}' where `category`='{$b_cate['cate']}';");
		sql_query("update `gsw_sub_category` set `cate`='{$cate}' where `cate`='{$b_cate['cate']}';");
		sql_query("update `gsw_category_banner` set `cate`='{$cate}' where `cate`='{$b_cate['cate']}';");
	}
	alert('저장되었습니다.',G5_URL."/admin/category.php?page=".$page."&search=".$search);