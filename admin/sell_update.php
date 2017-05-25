<?php
	include_once('../common.php');
	if(!$is_admin)
		alert("권한이 없습니다.");
	$page=$_POST['page'];
	$category=$_POST['category'];
	$code=$_POST['code'];
	$start=$_POST['start'];
	$end=$_POST['end'];
	$sel=$_POST['sel'];
	$search=$_POST['search'];
	$price=$_POST['price'];
	$delivery=$_POST['delivery'];
	$total_price=$_POST['total_price'];
	$mb_name=$_POST['mb_name'];
	$mb_email=$_POST['mb_email'];
	$mb_hp=$_POST['mb_hp'];
	$mb_addr=$_POST['mb_addr'];
	$re_name=$_POST['re_name'];
	$re_hp=$_POST['re_hp'];
	$content=$_POST['content'];
	$company=$_POST['company'];
	$invoice=$_POST['invoice'];
	$reason=$_POST['reason'];
	$account=$_POST['account'];
	$refund_content=$_POST['refund_content'];
	$view=sql_fetch("select * from `gsw_sell` where id='".$id."'");

	if($id){
		$sql="update `gsw_order` set `price`='{$price}',`delivery`='{$delivery}',`total_price`='{$total_price}',`mb_name`='{$mb_name}',`mb_email`='{$mb_email}',`mb_hp`='{$mb_hp}',`mb_addr`='{$mb_addr}',`re_name`='{$re_name}',`re_hp`='{$re_hp}',`content`='{$content}',`company`='{$company}',`invoice`='{$invoice}',`reason`='{$reason}',`account`='{$account}',`refund_content`='{$refund_content}' where `id`='{$id}';";
	}else{
		alert("잘못된 접근입니다.");
	}
	$query=sql_query($sql);
	if($view['status']>=0)
		$href=G5_URL."/admin/sell.php?page=".$page."&category=".$category."&code=".$code."&status=".$status."&start=".$start."&end=".$end."&sel=".$sel."&search=".$search;
	else
		$href=G5_URL."/admin/refund.php?page=".$page."&category=".$category."&code=".$code."&status=".$status."&start=".$start."&end=".$end."&sel=".$sel."&search=".$search;
	alert('업데이트 되었습니다.',$href);
?>