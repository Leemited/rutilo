<?php
	include_once("../common.php");
	if(!$is_admin){
		alert("권한이 없습니다.");
	}
	$page=$_POST['page'];
	$id=$_POST['id'];
	$category=$_POST['category'];
	$cate=$_POST['cate'];
	$sub_cate=$_POST['sub_cate'];
	$n_cate=sql_fetch("select * from `gsw_sub_category` where `cate`='".$cate."' and `sub_cate`='".$sub_cate."' and `id`<>'".$id."'");
	if($n_cate['sub_cate']){
		alert("'".$n_cate['sub_cate']."'는 이미 사용하고 있는 소분류입니다.");
	}
	$od=sql_fetch("select od from `gsw_sub_category` where `cate`='".$cate."' order by od desc");
	$od=$od['od']+1;
	if($id){
		$b_cate=sql_fetch("select * from `gsw_sub_category` where id='".$id."'");
		if($b_cate['cate']!=$cate){
			$od_sql=", od={$od}";
			sql_query("update `gsw_sub_category` set `od`=`od`-1 where `cate`='".$cate."' and `od`>'{$b_cate['od']}';");
		}
		$sql="update `gsw_sub_category` set `cate`='{$cate}',`sub_cate`='{$sub_cate}' {$od_sql} where `id`='{$id}';";
	}else{
		$sql="insert into `gsw_sub_category` (`cate`,`sub_cate`,`od`) values ('{$cate}','{$sub_cate}','{$od}');";
	}
	sql_query($sql);
	if($id){
		sql_query("update `gsw_product` set `sub_category`='{$sub_cate}' where `sub_category`='{$b_cate['sub_cate']}';");
		sql_query("update `gsw_category_banner` set `sub_cate`='{$sub_cate}' where `sub_cate`='{$b_cate['sub_cate']}';");
	}
	alert('저장되었습니다.',G5_URL."/admin/sub_category.php?page=".$page."&category=".$category);