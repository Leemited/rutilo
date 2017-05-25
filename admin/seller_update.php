<?php
	include_once('../common.php');
	if(!$is_admin){
		alert("권한이 없습니다.");
	}
	$page=$_POST['page'];
	$sel=$_POST['sel'];
	$search=$_POST['search'];
	$id=$_POST['id'];
	$mb_id=$_POST['mb_id'];
	$code=$_POST['code'];
	$sale=$_POST['sale'];
    $fees=$_POST['fees'];
	if($id){
		$sql="update `gsw_code` set `mb_id`='{$mb_id}',`code`='{$code}',`sale`='{$sale}',`fees`='{$fees}' where `id`='{$id}';";
	}else{
		$sql="insert into `gsw_code` (`mb_id`,`code`,`sale`,`fees`) values('{$mb_id}','{$code}','{$sale}','{$fees}');";
	}
	$query=sql_query($sql);
	alert('업데이트 되었습니다.',G5_URL."/admin/seller.php?page=".$page."&status=".$status."&sel=".$sel."&search=".$search);