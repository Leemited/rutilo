<?php
	$p=true;
	include_once("../common.php");
	include_once(G5_PATH."/admin/head.php");
	if($id){
		$view=sql_fetch("select * from `gsw_order` where id='".$id."'");
	}
	$sql="select *,c.id as id,c.number as number,p.number as total,c.price as cprice from `gsw_cart` as c inner join `gsw_product` as p on c.product_id=p.id where `od_code`='{$view['od_code']}' order by c.datetime desc";
	$query=sql_query($sql);
	$i=0;
	while($data=sql_fetch_array($query)){
		$list[$i]=$data;
		$i++;
	}
	if(!$id)
		alert('잘못된 접근입니다.');
	if(!$view['id'])
		alert('이미 삭제된 매출내역입니다.');
	if(!$is_admin && $view['code']!=$code2['code'])
		alert('권한이 없습니다.');
	$act="";
	switch($view['status']){
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
?>
<!-- 본문 start -->
<div id="wrap">
	<section>
		<header id="admin-title">
			<h1><?php echo $view['status']<0?"환불관리":"판매관리"; ?></h1>
			<hr />
		</header>
		<article id="mall_buy">
			<div class="price_info" id="order">
				<table>
					<thead>
						<tr>
							<th class="ld_hidden info">상품정보</th>
							<th class="num">개수</th>
							<th class="price">판매가</th>
						</tr>
					</thead>
					<tbody>
					
					<?php
						$total_num=0;
						$total_price=0;
						$vat = 0;
						$settlement_price=0;
						for($i=0;$i<count($list);$i++){
							$number=$list[$i]['number'];
							$price=$list[$i]['cprice'];
							$total_num+=$number;
							$total_price+=$price;
					?>
						<tr>
							<td class="info">
								<div>
									<div class="img"><div><div><img src="<?php echo G5_DATA_URL."/product/".$list[$i]['photo']; ?>" alt="<?php echo $list[$i]['title']; ?>" /></div></div>  </div>
									<div class="title">
										<h4><?php echo str_replace("|","/",$list[$i]['category']); ?></h4>
										<h3><?php echo $list[$i]['title']; ?></h3>
									</div>
								</div>
							</td>
							<td class="num"><?php echo number_format($number); ?></td>
							<td class="price">¥ <?php echo number_format($price,0); ?></td>
						</tr>
					<?php
					}   
                        $sql1 = sql_query("select * from `gsw_code` where code='".$view['code']."'");
                        $query1=sql_fetch_array($sql1);
                        $vat =  $total_price * 0.1; 
						$pvat = $total_price - $vat;
						$settlement_price = $pvat * ($query1['fees']/100);
					?>
					</tbody>
					<tfoot>
						<tr>
							<td class="info text-left">총갯수 / 총가격</td>
							<td class="num"><?php echo number_format($total_num); ?></td>
							<td class="price">¥ <?php echo number_format($total_price); ?></td>
						</tr>
						<tr>
							<td class="info text-left">정산가격</td>
							<td class="num"></td>
							<td class="price">¥ <?php echo number_format($settlement_price); ?></td>
						</tr>
						<tr>
							<td class="info text-left">배송비 / 결제가격</td>
							<td class="num">¥ <?php echo number_format($view['delivery']); ?></td>
							<td class="price">¥ <?php echo number_format($view['total_price']); ?></td>
						</tr>
					</tfoot>
				</table>
			</div>
			<div class="adm-table02 mt10">
				<table>
					<tr>
						<th>상태</th>
						<td>
							<?php echo $act; ?> 
							<?php if($is_admin){ ?>
								<?php if($view['status']<0 && $view['status']!=-4){?>
								<a href="<?php echo G5_URL."/admin/sell_status.php?id=".$id."&status=-1"; ?>" class="white btn" style="background:#666;border:none;padding:5px 10px;">환불취소</a>
								<?php } ?>
								<?php if($view['status']>=-1){?>
								<a href="<?php echo G5_URL."/admin/sell_status.php?id=".$id."&status=-2"; ?>" class="white btn" style="background:#666;border:none;padding:5px 10px;">&nbsp;환&nbsp;&nbsp;불&nbsp;</a>
								<?php } ?>
								<?php if($view['status']==2){?>
								<a href="<?php echo G5_URL."/admin/sell_status.php?id=".$id."&status=3"; ?>" class="white btn" style="background:#666;border:none;padding:5px 10px;">배송완료</a>
								<?php } ?>
								<?php if($view['status']==-2){?>
								<a href="<?php echo G5_URL."/admin/sell_status.php?id=".$id."&status=-3"; ?>" class="white btn" style="background:#666;border:none;padding:5px 10px;">입금대기</a>
								<?php } ?>
								<?php if($view['status']==-3){?>
								<a href="<?php echo G5_URL."/admin/sell_status.php?id=".$id."&status=-4"; ?>" class="white btn" style="background:#666;border:none;padding:5px 10px;">환불완료</a>
								<?php } ?>
							<?php } ?>
						</td>
					</tr>
					<tr>
						<th>아이디</th>
						<td><?php echo $view['mb_id']; ?></td>
					</tr>
					<tr>
						<th>이름</th>
						<td><?php echo $view['mb_name']; ?></td>
					</tr>
					<tr>
						<th>이메일</th>
						<td><?php echo $view['mb_email']; ?></td>
					</tr>
					<tr>
						<th>전화번호</th>
						<td><?php echo $view['mb_hp']; ?></td>
					</tr>
				</table>
			</div>
			<div class="adm-table02 mt10">
				<table>
					<tr>
						<th>주소</th>
						<td><?php echo $view['mb_addr']; ?></td>
					</tr>
					<tr>
						<th>받는분</th>
						<td><?php echo $view['re_name']; ?></td>
					</tr>
					<tr>
						<th>연락처</th>
						<td><?php echo $view['re_hp']; ?></td>
					</tr>
					<tr>
						<th>배송시 요청사항</th>
						<td><?php echo $view['content']; ?></td>
					</tr>
					<tr>
						<th>송장번호</th>
						<td>
						<?php
						if($view['status']==1 && $is_admin){
						?>
							<form action="<?php echo G5_URL."/admin/sell_invoice_update.php"; ?>" method="post">
								<input type="hidden" name="id" value="<?php echo $id; ?>" />
								<div class="grid_100">
									<div class="grid_20"><input type="text" name="company" id="company_input" value="<?php echo $view['company']; ?>" class="adm-input01 grid_100" placeholder="택배회사" /></div>
									<div class="grid_70"><input type="text" name="invoice" id="invoice" value="<?php echo $view['invoice']; ?>" class="adm-input01 grid_100" placeholder="송장번호" /></div>
									<div class="grid_10"><input type="submit" class="grid_100 white lh30 btn" style="background:#666;border:none;" value="확인" /></div>
								</div>
							</form>
						<?php
						}else{
						echo $view['company']." ".$view['invoice'];
						}
						?>
						</td>
					</tr>
				</table>
			</div>
			<?php if($view['status']<0){ ?>
			<div class="adm-table02 mt10">
				<table>
					<tr>
						<th>사유</th>
						<td>
							<?php echo $view['reason']; ?>
						</td>
					</tr>
					<tr>
						<th>계좌번호</th>
						<td>
							<?php echo $view['bank']; ?> <?php echo $view['account']; ?>
						</td>
					</tr>
					<tr>
						<th>내용</th>
						<td><?php echo $view['refund_content']; ?></td>
					</tr>
				</table>
			</div>
			<?php }
			if($view['status']>=0)
				$href=G5_URL."/admin/sell.php?page=".$page."&category=".$category."&code=".$code."&status=".$status."&start=".$start."&end=".$end."&sel=".$sel."&search=".$search;
			else
				$href=G5_URL."/admin/refund.php?page=".$page."&category=".$category."&code=".$code."&status=".$status."&start=".$start."&end=".$end."&sel=".$sel."&search=".$search;
			?>
			<div class="text-center mt20">
				<a href="<?php echo $href; ?>" class="adm-btn01" style="background:#666;">목록</a>
				<?php if($is_admin){ ?>
				<a href="<?php echo G5_URL."/admin/sell_write.php?page=".$page."&id=".$id."&category=".$category."&code=".$code."&status=".$status."&start=".$start."&end=".$end."&sel=".$sel."&search=".$search; ?>" class="adm-btn01">수정</a>
				<?php } ?>
			</div>
		</article>
	</section>
</div>
<?php
	include_once(G5_PATH."/admin/tail.php");
?>
