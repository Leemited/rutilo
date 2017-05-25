<?php
	include_once('../common.php');
	if(!$is_admin){
		alert("권한이 없습니다.");
	}
	$page=$_POST['page'];
	$sel=$_POST['sel'];
	$search=$_POST['search'];
	$academy=$_POST['academy'];
	$status=$_POST['status'];
	$id=$_POST['id'];
	$mb_id=$_POST['mb_id'];
	$mb_name=$_POST['mb_name'];
	$mb_1=$_POST['mb_1'];
	$mb_hp=$_POST['mb_hp'];
	$mb_hp=$mb_hp;
	$person=$_POST['person'];
	$academy_id=$_POST['academy_id'];
	$status=$_POST['status'];
	/*
	if(!$academy_id){
		echo 1;
		return false;
	}
	
	$aca=sql_fetch("SELECT *,(select sum(person) from `gsw_application` as b where b.academy_id=a.id and `status`<>'-1') as application FROM `gsw_academy` as a WHERE id='{$academy_id}'");
	if(($aca['recruit']-$aca['application'])<$person){
		echo 2;
		return false;
	}*/
	if($id){
		$sql="update `gsw_application` set `mb_id`='{$mb_id}',`mb_name`='{$mb_name}',`mb_hp`='{$mb_hp}',`person`='{$person}',`academy_id`='{$academy_id}',`status`='{$status}' where `id`='{$id}';";
	}else{
		$sql="insert into `gsw_application` (`mb_id`,`mb_name`,`mb_hp`,`person`,`academy_id`,`status`,`datetime`) values('{$mb_id}','{$mb_name}','{$mb_hp}','{$person}','{$academy_id}','{$status}',NOW());";
	}
	$query=sql_query($sql);
	alert('업데이트 되었습니다.',G5_URL."/admin/application.php?page=".$page."&status=".$status."&sel=".$sel."&search=".$search."&academy=".$academy);