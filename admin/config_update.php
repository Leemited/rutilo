<?php
	include_once("../common.php");
	if(!$is_admin){
		alert("권한이 없습니다.");
	}
	$name=$_POST['name'];
	$addr1=$_POST['addr1'];
	$addr2=$_POST['addr2'];
	$tel=$_POST['tel'];
	$call=$_POST['call'];
	$time=$_POST['time'];
	$email=$_POST['email'];
	sql_query("update `gsw_config` set `name`='{$name}',`addr1`='{$addr1}',`addr2`='{$addr2}',`tel`='{$tel}',`call`='{$call}',`time`='{$time}',`email`='{$email}';");
	alert('저장되었습니다.');