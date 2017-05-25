<?php
	include_once("../common.php");
	if(!$is_admin){
		alert("권한이 없습니다.");
	}
	$page=$_POST['page'];
	$id=$_POST['id'];
	$name=$_POST['name'];
	$recruit=$_POST['recruit'];
	$start=$_POST['start'];
	$end=$_POST['end'];
	$time=$_POST['time'];
	$bold=$_POST['bold'];
	$title=$_POST['title'];
	$con=$_POST['con'];
	$search=$_POST['search'];
	$schedule="";
	for($i=0;$i<count($time);$i++){
		if($i!=0)
			$schedule.="||";
		for($j=0;$j<count($time[$i]);$j++){
			if($j!=0)
				$schedule.="|";
			$bold[$i][$j]=$bold[$i][$j]?1:0;
			$schedule.=$time[$i][$j]."//".$bold[$i][$j]."//".$title[$i][$j]."//".nl2br($con[$i][$j]);
		}
	}
	if($id){
		$sql="update `gsw_academy` set `name`='{$name}',`recruit`='{$recruit}',`start`='{$start}',`end`='{$end}',`schedule`='{$schedule}' where `id`='{$id}';";
	}else{
		$sql="insert into `gsw_academy` (`name`,`recruit`,`start`,`end`,`schedule`,`datetime`) values ('{$name}','{$recruit}','{$start}','{$end}','{$schedule}',NOW());";
	}
	sql_query($sql);
	alert('저장되었습니다.',G5_URL."/admin/academy.php?page=".$page."&search=".$search);