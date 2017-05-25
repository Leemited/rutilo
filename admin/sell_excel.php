<?php
include_once("../common.php");
header( "Content-type: application/vnd.ms-excel" );   
header( "Content-type: application/vnd.ms-excel; charset=utf-8");  
header( "Content-Disposition: attachment; filename = sell.xls" );   
header( "Content-Description: PHP4 Generated Data" );   
$where="";
if($code!="")
	$where.=" and `code`='{$code}'";
if($status!="")
	$where.=" and `status`='{$status}'";
if($start!=""&&$end!="")
	$where.=" and s.`datetime`>='{$start} 00:00:00' and s.`datetime`<='{$end} 23:59:59'";
if($sel!=""&&$search!="")
	$where.=" and `{$sel}` like '%{$search}%'";
if($act==1)
	$where.=" and `status`>=0";
else
	$where.=" and `status`<0";
$sql="select *,s.datetime as datetime,s.id as id,count(p.id) as pcount,s.price as price,s.mb_id as mb_id from `gsw_order` as s inner join `gsw_cart` as c on s.od_code=c.od_code left join `gsw_product` as p on c.product_id=p.id where s.status<>'0' and s.status>'0' {$where} group by s.od_code order by s.id desc";
$query = sql_query($sql);  
while($data = mysql_fetch_array($query)) {
	$list[]=$data;
}
// 테이블 상단 만들기  
$EXCEL_STR = "  
<table border='1'>  
<tr>  
	<th>결제일시</th>
	<th>주문상품</th>
	<th>이름</th>
	<th>이메일</th>
	<th>아이디</th>
	<th>받는사람</th>
	<th>주소</th>
	<th>배송비</th>
	<th>가격/정산가격</th>
	<th>총가격</th>
	<th>상태</th>
</tr>";  
for($i=0;$i<count($list);$i++) {  
	$act="";
	switch($list[$i]['status']){
		case "0":$act="결제대기";break;
		case "1":$act="물품 준비중";break;
		case "2":$act="배송중";break;
		case "3":$act="배송완료";break;
		case "-1":$act="승인대기";break;
		case "-2":$act="배송대기";break;
		case "-3":$act="입금대기";break;
		case "-4":$act="환불완료";break;
		default:$act="";break;
	}
	$title=$list[$i]['pcount']>1?$list[$i]['title']." 외 ".($list[$i]['pcount']-1)."제품":$list[$i]['title'];
   $EXCEL_STR .= "
   <tr>  
	<td>".date("Y-m-d",strtotime($list[$i]['datetime']))."<br />".date("H:m:i",strtotime($list[$i]['datetime']))."</td>
	<td>".$title."</td>
	<td>".$list[$i]['mb_name']."</td>
	<td>".$list[$i]['mb_email']."</td>
	<td>".$list[$i]['mb_id']."</td>
	<td>".$list[$i]['re_name']."</td>
	<td>".$list[$i]['mb_addr']."</td>
	<td>¥ ".number_format($list[$i]['delivery'])."</td>
	<td>¥ ".number_format($list[$i]['price'])."/ ¥".number_format($list[$i]['settlement_price'])."</td>
	<td>¥ ".number_format($list[$i]['total_price'])."</td>
	<td>".$act."</td>
   </tr>  
   ";  
}  
  
$EXCEL_STR .= "</table>";  
  
echo "<meta content=\"application/vnd.ms-excel; charset=UTF-8\" name=\"Content-type\"> ";  
echo $EXCEL_STR;  
?>