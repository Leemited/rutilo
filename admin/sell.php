<?php
	$p=true;
	include_once("../common.php");
	include_once(G5_PATH."/admin/head.php");
	if(!$is_admin)
		$code=$code2['code'];
	$where="";
	if($category!="")
		$where.=" and `category`='{$category}'";
	if($code!="")
		$where.=" and `code`='{$code}'";
	if($status!="")
		$where.=" and `status`='{$status}'";
	if($start!=""&&$end!="")
		$where.=" and s.`datetime`>='{$start} 00:00:00' and s.`datetime`<='{$end} 23:59:59'";
	if($sel!=""&&$search!="")
		$where.=" and `{$sel}` like '%{$search}%'";
	$total=sql_fetch("select count(*) as cnt from `gsw_order` where status<>0 and status>'0' {$where} order by `id` desc");
	if(!$page)
		$page=1;
    
	$total=$total['cnt'];
	$rows=10;
	$start=($page-1)*$rows;
	$total_page=ceil($total/$rows);
	$sql="select *,s.datetime as datetime,s.id as id,count(p.id) as pcount,s.price as price,s.mb_id as mb_id from `gsw_order` as s inner join `gsw_cart` as c on s.od_code=c.od_code left join `gsw_product` as p on c.product_id=p.id where s.status<>'0' and s.status>'0' {$where} group by s.od_code order by s.id desc";
	$query=sql_query($sql);
	$j=0;
	while($data=sql_fetch_array($query)){
		$list[$j]=$data;
		$list[$j]['num']=$total-($start)-$j;
		$j++;
	}
	$sql="select * from `gsw_category` order by `od` asc";
	$query=sql_query($sql);
	while($data=sql_fetch_array($query)){
		$cate[]=$data;
	}
	if(!$is_admin)
		$where=" where `code`='{$code2['code']}'";
	$code_sql="select * from `gsw_code` {$where}";
	$code_query=sql_query($code_sql);
	$i=0;
	while($code_data=sql_fetch_array($code_query)){
		$code_array[$i]=$code_data;
		$i++;
	}
	$colspan=13;
	if($is_admin)
		$colspan++;
?>
<style type="text/css">
	.grid_65{width:65% !important;display:inline-block;float:left;box-sizing:border-box;}
	.grid_475{width:47.5% !important;display:inline-block;float:left;box-sizing:border-box;}
	.grid_5{width:5% !important;display:inline-block;float:left;box-sizing:border-box;}
	#sell .search{margin-bottom:25px;}
	#sell .search form > div{margin-bottom:5px;}
</style>
<!-- 본문 start -->
<div id="wrap">
	<section>
		<header id="admin-title">
			<h1>매출관리</h1>
			<hr />
		</header>
		<article id="sell">
			<div class="grid_100 search">
				<form action="" method="get">
					<div class="grid_100 text-right">
						<!-- <select name="category" class="adm-input01" id="category">
							<option value="">선택</option>
							<?php for($i=0;$i<count($cate);$i++){ ?>
							<option value="<?php echo $cate[$i]['cate']; ?>" <?php echo $cate[$i]['cate']==$category?"selected":""; ?>><?php echo $cate[$i]['cate']; ?></option>
							<?php } ?>
						</select> -->
						<select name="code" class="adm-input01" id="code">
							<option value="">코드선택</option>
							<?php for($i=0;$i<count($code_array);$i++){ ?>
							<option value="<?php echo strtoupper($code_array[$i]['code']); ?>"<?php echo strtoupper($code_array[$i]['code'])==strtoupper($code)?" selected":""; ?>><?php echo strtoupper($code_array[$i]['code']); ?></option>
							<?php } ?>
						</select>
						<select name="status" class="adm-input01" id="status">
							<option value="">상태선택</option>
							<option value="1"<?php echo $status==1?" selected":""; ?>>물품 준비중</option>
							<option value="2"<?php echo $status==2?" selected":""; ?>>배송중</option>
							<option value="3"<?php echo $status==3?" selected":""; ?>>배송완료</option>
						</select>
					</div>
					<div class="grid_100">
						<div class="grid_475"><input type="text" name="start" id="start" class="adm-input01 grid_100" readonly placeholder="주문일" /></div>
						<span class="text-center grid_5 lh30">~</span>
						<div class="grid_475"><input type="text" name="end" id="end" class="adm-input01 grid_100" placeholder="주문일" readonly /></div>
					</div>
					<div class="grid_100">
						<div class="grid_20">
							<select name="sel" class="adm-input01 grid_100" id="sel">
								<option value="">검색선택</option>
								<option value="mb_name"<?php echo $status=="mb_name"?" selected":""; ?>>이름</option>
								<option value="mb_email"<?php echo $status=="mb_email"?" selected":""; ?>>이메일</option>
								<option value="mb_id"<?php echo $status=="mb_id"?" selected":""; ?>>아이디</option>
								<option value="re_name"<?php echo $status=="re_name"?" selected":""; ?>>받는사람</option>
								<option value="mb_addr"<?php echo $status=="mb_addr"?" selected":""; ?>>주소</option>
							</select>
						</div>
						<div class="grid_70"><input type="text" name="search" id="search" value="<?php echo $search; ?>" class="adm-input01 grid_100" /></div>
						<div class="grid_10"><input type="submit" class="grid_100 white lh30 btn" style="background:#666;border:none;" value="검색" /></div>
					</div>
				</form>
			</div>
			<div class="adm-table01">
				<table>
					<thead>
						<tr>
							<th rowspan="2" class="md_none">번호</th>
							<th rowspan="2" >결제일시</th>
							<th rowspan="2" >주문상품</th>
							<th rowspan="2" >이름</th>
							<th rowspan="2"  style="width:10%;">이메일</th>
							<th rowspan="2" >아이디</th>
							<th rowspan="2" >코드</th>
							<th rowspan="2" >받는사람</th>
							<th rowspan="2" style="width:25%;">주소</th>
							<th rowspan="2" class="md_none">배송비</th>
							<th class="md_none">가격</th>
							<th rowspan="2" >총가격</th>
							<th rowspan="2" >상태</th>
							<?php if($is_admin){ ?><th rowspan="2" >관리</th><?php } ?>
							<tr>
								<th class="md_none">정산금액</th>
							</tr>
						</tr>
					</thead>
					<tbody>
					<?php
						for($i=0;$i<count($list);$i++){
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
                                $sql1 = sql_query("select * from `gsw_code` where code='".$list[$i]['code']."'");
                                $query1=sql_fetch_array($sql1);
                                
                                $vat =  $list[$i]['price'] * 0.1; 
								$pvat = $list[$i]['price'] - $vat;
                                $settlement_price = $pvat * ($query1['fees']/100);
					?>
						<tr>
							<td rowspan="2" onclick="javascript:location.href='<?php echo G5_URL."/admin/sell_view.php?page=".$page."&id=".$list[$i]['id']."&category=".$category."&code=".$code."&status=".$status."&start=".$start."&end=".$end."&sel=".$sel."&search=".$search; ?>'" class="md_none"><?php echo $list[$i]['num']; ?></td>
							<td rowspan="2" onclick="javascript:location.href='<?php echo G5_URL."/admin/sell_view.php?page=".$page."&id=".$list[$i]['id']."&category=".$category."&code=".$code."&status=".$status."&start=".$start."&end=".$end."&sel=".$sel."&search=".$search; ?>'"><?php echo date("Y-m-d",strtotime($list[$i]['datetime'])); ?><br /><?php echo date("H:m:i",strtotime($list[$i]['datetime'])); ?></td>
							<td rowspan="2" onclick="javascript:location.href='<?php echo G5_URL."/admin/sell_view.php?page=".$page."&id=".$list[$i]['id']."&category=".$category."&code=".$code."&status=".$status."&start=".$start."&end=".$end."&sel=".$sel."&search=".$search; ?>'"><?php echo $list[$i]['title']; ?><?php if($list[$i]['pcount']>1){ ?> 외 <?php echo $list[$i]['pcount']-1 ?>제품<?php } ?></td>
							<td rowspan="2" onclick="javascript:location.href='<?php echo G5_URL."/admin/sell_view.php?page=".$page."&id=".$list[$i]['id']."&category=".$category."&code=".$code."&status=".$status."&start=".$start."&end=".$end."&sel=".$sel."&search=".$search; ?>'"><?php echo $list[$i]['mb_name']; ?></td>
							<td rowspan="2" onclick="javascript:location.href='<?php echo G5_URL."/admin/sell_view.php?page=".$page."&id=".$list[$i]['id']."&category=".$category."&code=".$code."&status=".$status."&start=".$start."&end=".$end."&sel=".$sel."&search=".$search; ?>'"><?php echo $list[$i]['mb_email']; ?></td>
							<td rowspan="2" onclick="javascript:location.href='<?php echo G5_URL."/admin/sell_view.php?page=".$page."&id=".$list[$i]['id']."&category=".$category."&code=".$code."&status=".$status."&start=".$start."&end=".$end."&sel=".$sel."&search=".$search; ?>'"><?php echo $list[$i]['mb_id']; ?></td>
							<td rowspan="2" onclick="javascript:location.href='<?php echo G5_URL."/admin/sell_view.php?page=".$page."&id=".$list[$i]['id']."&category=".$category."&code=".$code."&status=".$status."&start=".$start."&end=".$end."&sel=".$sel."&search=".$search; ?>'"><?php echo strtoupper($list[$i]['code']); ?></td>
							<td rowspan="2" onclick="javascript:location.href='<?php echo G5_URL."/admin/sell_view.php?page=".$page."&id=".$list[$i]['id']."&category=".$category."&code=".$code."&status=".$status."&start=".$start."&end=".$end."&sel=".$sel."&search=".$search; ?>'"><?php echo $list[$i]['re_name']; ?></td>
							<td rowspan="2" onclick="javascript:location.href='<?php echo G5_URL."/admin/sell_view.php?page=".$page."&id=".$list[$i]['id']."&category=".$category."&code=".$code."&status=".$status."&start=".$start."&end=".$end."&sel=".$sel."&search=".$search; ?>'"><?php echo $list[$i]['mb_addr']; ?></td>
							<td rowspan="2" onclick="javascript:location.href='<?php echo G5_URL."/admin/sell_view.php?page=".$page."&id=".$list[$i]['id']."&category=".$category."&code=".$code."&status=".$status."&start=".$start."&end=".$end."&sel=".$sel."&search=".$search; ?>'" class="md_none">¥ <?php echo number_format($list[$i]['delivery']); ?></td>
							<td onclick="javascript:location.href='<?php echo G5_URL."/admin/sell_view.php?page=".$page."&id=".$list[$i]['id']."&category=".$category."&code=".$code."&status=".$status."&start=".$start."&end=".$end."&sel=".$sel."&search=".$search; ?>'" class="md_none">¥ <?php echo number_format($list[$i]['price']); ?></td>
							<td rowspan="2" onclick="javascript:location.href='<?php echo G5_URL."/admin/sell_view.php?page=".$page."&id=".$list[$i]['id']."&category=".$category."&code=".$code."&status=".$status."&start=".$start."&end=".$end."&sel=".$sel."&search=".$search; ?>'">¥ <?php echo number_format($list[$i]['total_price']);?> 
					        </td>
							<td rowspan="2" onclick="javascript:location.href='<?php echo G5_URL."/admin/sell_view.php?page=".$page."&id=".$list[$i]['id']."&category=".$category."&code=".$code."&status=".$status."&start=".$start."&end=".$end."&sel=".$sel."&search=".$search; ?>'"><?php echo $act; ?></td>
							<?php if($is_admin){ ?>
							<td rowspan="2">
								<a href="<?php echo G5_URL."/admin/sell_write.php?page=".$page."&id=".$list[$i]['id']."&category=".$category."&code=".$code."&status=".$status."&start=".$start."&end=".$end."&sel=".$sel."&search=".$search; ?>">수정</a>
								<a href="javascript:del_confirm('<?php echo G5_URL."/admin/sell_delete.php?id=".$list[$i]['id']; ?>');">삭제</a>
							</td>
							<?php } ?>
							<tr>
								<td onclick="javascript:location.href='<?php echo G5_URL."/admin/sell_view.php?page=".$page."&id=".$list[$i]['id']."&category=".$category."&code=".$code."&status=".$status."&start=".$start."&end=".$end."&sel=".$sel."&search=".$search; ?>'" class="md_none">¥ <?php echo number_format($settlement_price); ?></td>
							</tr>
						</tr>
					<?php
						}
						if(count($list)==0){
							echo "<tr><td colspan='".$colspan."' class='text-center' style='padding:100px 0;'>목록이 없습니다</td></tr>";
						}
					?>
					</tbody>
				</table>
			</div>
			<?php
				if($total_page>1){
					$start_page=1;
					$end_page=$total_page;
					if($total_page>5){
						if($total_page<($page+2)){
							$start_page=$total_page-4;
							$end_page=$total_page;
						}else if($page>3){
							$start_page=$page-2;
							$end_page=$page+2;
						}else{
							$start_page=1;
							$end_page=5;
						}
					}
			?>
			<div class="num_list01">
				<ul>
				<?php if($page!=1){?>
					<li class="prev"><a href="<?php echo G5_URL."/admin/sell.php?page=".($page-1)."&category=".$category."&code=".$code."&status=".$status."&start=".$start."&end=".$end."&sel=".$sel."&search=".$search; ?>">&lt;</a></li>
				<?php } ?>
				<?php for($i=$start_page;$i<=$end_page;$i++){ ?>
					<li class="<?php echo $page==$i?"active":""; ?>"><a href="<?php echo G5_URL."/admin/sell.php?page=".$i."&category=".$category."&code=".$code."&status=".$status."&start=".$start."&end=".$end."&sel=".$sel."&search=".$search; ?>"><?php echo $i; ?></a></li>
				<?php } ?>
				<?php if($page<$total_page){?>
					<li class="next"><a href="<?php echo G5_URL."/admin/sell.php?page=".($page+1)."&category=".$category."&code=".$code."&status=".$status."&start=".$start."&end=".$end."&sel=".$sel."&search=".$search; ?>">&gt;</a></li>
				<?php } ?>
				</ul>
			</div>
			<?php
			}
			?>
			<div class="text-right mt20">
				<a href="<?php echo G5_URL."/admin/sell_excel.php?page=".$page."&act=1&category=".$category."&code=".$code."&status=".$status."&start=".$start."&end=".$end."&sel=".$sel."&search=".$search; ?>" class="adm-btn01">엑셀로 저장</a>
			</div>
		</article>
	</section>
</div>
<script src="//code.jquery.com/ui/1.11.4/jquery-ui.js"></script>
<link rel="stylesheet" href="//code.jquery.com/ui/1.11.4/themes/smoothness/jquery-ui.css">
<script type="text/javascript">
	$(function(){
		$( "#start" ).datepicker({
			dateFormat:"yy-mm-dd",
			onSelect: function( selectedDate ) {
				$( "#end" ).datepicker( "option", "minDate", selectedDate );
			}
		});
		$( "#end" ).datepicker({
			dateFormat:"yy-mm-dd",
			onSelect: function( selectedDate ) {
				$( "#start" ).datepicker( "option", "maxDate", selectedDate );
				var dateObject=new Date(selectedDate);
			}
		});
	});
	function del_confirm(url){
		if(confirm('삭제시 돌릴 수 없습니다.\n삭제하시겠습니까?')){
			location.href=url;
		}else{
			return false;
		}
	}
</script>
<?php
	include_once(G5_PATH."/admin/tail.php");
?>
