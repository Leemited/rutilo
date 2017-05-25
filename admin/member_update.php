<?php
	include_once("../common.php");
	if(!$is_admin){
		alert("권한이 없습니다.");
	}
	$mb_no=$_POST['mb_no'];
	$mb_name=$_POST['mb_name'];
	$mb_password=$_POST['mb_password'];
	$mb_email=$_POST['mb_email'];
	$mb_hp=hyphen_hp_number($_POST['mb_hp']);
	$mb_1=$_POST['mb_1'];
	$mb_2=$_POST['mb_2'];
	if($mb_password){
		$mb_password_sql=", `mb_password`=password('".$mb_password."')";
	}
	$sql="update `g5_member` set `mb_name`='{$mb_name}',`mb_email`='{$mb_email}',`mb_hp`='{$mb_hp}',`mb_1`='{$mb_1}',`mb_2`='{$mb_2}'  where `mb_no`='{$mb_no}'";
	sql_query($sql);
	alert("수정 되었습니다.");