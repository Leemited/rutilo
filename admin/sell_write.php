<?php
	include_once("../common.php");
	include_once(G5_PATH."/admin/head.php");
	if($id){
		$write=sql_fetch("select * from `gsw_order` where id='".$id."'");
	}
	$sql="select *,c.id as id,c.number as number,p.number as total,c.price as cprice from `gsw_cart` as c inner join `gsw_product` as p on c.product_id=p.id where `od_code`='{$write['od_code']}' order by c.datetime desc";
	$query=sql_query($sql);
	$i=0;
	while($data=sql_fetch_array($query)){
		$list[$i]=$data;
		$i++;
	}

    $sql1 = sql_fetch("select * from `gsw_code` where code='".$list[$i]['code']."'");
    $query1=sql_query($sql1);
    $i=0;
    while($data=sql_fetch_array($query1)){
        $list1[$i]=$data;
        $i++;
    }    
    $totp = $list[$i]['total_price'] - $list[$i]['delivery'];
    $vat =  $totp * 0.011;                        
    $settlement_price = $vat * $list1[$i]['fees'];
?>
<!-- 본문 start -->
<div id="wrap">
	<section id="mall_buy">
		<header id="admin-title">
			<h1><?php echo $write['status']<0?"환불관리":"판매관리"; ?></h1>
			<hr />
		</header>
		<article id="admin_academy_write">
			<form action="<?php echo G5_URL."/admin/sell_update.php"; ?>" method="post" enctype="multipart/form-data">
				<input type="hidden" name="id" value="<?php echo $id; ?>" />
				<input type="hidden" name="category" value="<?php echo $category; ?>" />
				<input type="hidden" name="code" value="<?php echo $code; ?>" />
				<input type="hidden" name="start" value="<?php echo $start; ?>" />
				<input type="hidden" name="end" value="<?php echo $end; ?>" />
				<input type="hidden" name="sel" value="<?php echo $sel; ?>" />
				<input type="hidden" name="search" value="<?php echo $search; ?>" />
				<div class="adm-table02 mt20">
					<table>
						<tr>
							<th>가격</th>
							<td>
								<input type="text" name="price" id="price" value="<?php echo $write['price']; ?>" onkeyup="return number_only(this);" class="adm-input01 grid_100" />
							</td>
						</tr>
						<tr>
							<th>배송비</th>
							<td>
								<input type="text" name="delivery" id="delivery" value="<?php echo $write['delivery']; ?>" onkeyup="return number_only(this);" class="adm-input01 grid_100" />
							</td>
						</tr>
						<tr>
							<th>총가격</th>
							<td>
								<input type="text" name="total_price" id="total_price" value="<?php echo $write['total_price']; ?>" onkeyup="return number_only(this);" class="adm-input01 grid_100" />
							</td>
						</tr>
						
					</table>
				</div>
				<div class="adm-table02 mt10">
					<table>
						<tr>
							<th>이름</th>
							<td><input type="text" name="mb_name" id="mb_name" class="adm-input01 grid_100" required value="<?php echo $write['mb_name']; ?>" /></td>
						</tr>
						<tr>
							<th>이메일</th>
							<td><input type="text" name="mb_email" id="mb_email" class="adm-input01 grid_100" required value="<?php echo $write['mb_email']; ?>" /></td>
						</tr>
						<tr>
							<th>전화번호</th>
							<td><input type="text" name="mb_hp" id="mb_hp" class="adm-input01 grid_100" required title="전화번호" value="<?php echo $write['mb_hp']; ?>" /></td>
						</tr>
					</table>
				</div>
				<div class="adm-table02 mt10">
					<table>
						<tr>
							<th>주소</th>
							<td><input type="text" name="mb_addr" id="mb_addr" required class="adm-input01 grid_100" value="<?php echo $write['mb_addr']; ?>" /></td>
						</tr>
						<tr>
							<th>받는분</th>
							<td><input type="text" name="re_name" id="re_name" required class="adm-input01 grid_100" value="<?php echo $write['re_name']; ?>" /></td>
						</tr>
						<tr>
							<th>연락처</th>
							<td><input type="text" name="re_hp" id="re_hp" required class="adm-input01 grid_100" value="<?php echo $write['re_hp']; ?>" /></td>
						</tr>
						<tr>
							<th>배송시 요청사항</th>
							<td><input type="text" name="content" id="content" class="adm-input01 grid_100"  value="<?php echo $write['content']; ?>" /></td>
						</tr>
						<tr>
							<th>송장번호</th>
							<td>
								<div class="grid_100">
									<input type="text" name="company" class="adm-input01 grid_20"  value="<?php echo $write['company']; ?>" title="배송회사" placeholder="배송회사" />
									<input type="text" name="invoice" id="invoice" class="adm-input01 grid_80"  value="<?php echo $write['invoice']; ?>" />
								</div>
							</td>
						</tr>
					</table>
				</div>
				<?php if($write['status']<0){ ?>
				<div class="table02">
					<h2>환불정보</h2>
					<table>
						<tr>
							<th>사유</th>
							<td>
								<select name="reason" id="reason" class="adm-input01 grid_100">
									<option value="">환불사유 선택</option>
									<option value="제품에 하자가 있음" data-label="제품에 하자가 있음" <?php echo $write['reason']=="제품에 하자가 있음"?"selected":""; ?>>제품에 하자가 있음</option>
									<option value="단순변심" data-label="단순변심" <?php echo $write['reason']=="단순변심"?"selected":""; ?>>단순변심</option>
									<option value="기타" data-label="기타" <?php echo $write['reason']=="기타"?"selected":""; ?>>기타</option>
								</select>
							</td>
						</tr>
						<tr>
							<th>계좌번호</th>
							<td>
								<div class="grid_100">
									<input type="text" name="bank" class="adm-input01 grid_20"  value="<?php echo $write['bank']; ?>" title="은행" placeholder="은행" />
									<input type="text" name="account" id="account" class="adm-input01 grid_80"  value="<?php echo $write['account']; ?>" />
								</div>
							</td>
						</tr>
						<tr>
							<th>내용</th>
							<td><textarea name="refund_content" id="refund_content" cols="30" rows="10" class="adm-input01 grid_100" placeholder="상세한 내용을 입력하세요" style="height:160px;"><?php strip_tags($write['refund_content']); ?></textarea></td>
						</tr>
					</table>
				</div>
				<?php } ?>
				<div class="text-center mt20">
					<input type="submit" value="확인" class="adm-btn01" />
				</div>
			</form>
		</article>
	</section>
</div>
<?php
	include_once(G5_PATH."/admin/tail.php");
?>
