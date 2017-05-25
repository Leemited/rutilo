<?php
	include_once("../common.php");
	include_once(G5_PATH."/admin/head.php");
	if($sel!="" && $search!=""){
		$where="and `{$sel}` like '%{$search}%'";
	}
	$total=sql_fetch("select count(*) as cnt from `gsw_code` where 1 {$where} order by `id` desc");
	if(!$page)
		$page=1;
	$total=$total['cnt'];
	$rows=10;
	$start=($page-1)*$rows;
	$total_page=ceil($total/$rows);
	$sql="select * from `gsw_code` where 1 {$where} order by `id` desc limit {$start},{$rows}";
	$query=sql_query($sql);
	$j=0;
	while($data=sql_fetch_array($query)){
		$list[$j]=$data;
		$list[$j]['num']=$total-($start)-$j;
		$j++;
	}
?>
<!-- 본문 start -->
<div id="wrap">
	<section>
		<header id="admin-title">
			<h1>판매자관리</h1>
			<hr />
		</header>
		<article>
			<div class="grid_100" style="margin-bottom:30px">
				<form action="" method="get">
					<div class="grid_15">
						<select name="sel" id="sel" class="grid_100 adm-input01">
							<option value="">선택</option>
							<option value="mb_id" <?php echo $sel=="mb_id"?"selected":""; ?>>관리자 아이디</option>
							<option value="code" <?php echo $sel=="code"?"selected":""; ?>>코드</option>
						</select>
					</div>
					<div class="grid_75 pl10"><input type="text" name="search" id="search" class="grid_100 adm-input01" value="<?php echo $search; ?>" /></div>
					<div class="grid_10 pl10"><input type="submit" class="grid_100 white lh30 btn" style="background:#666;border:none;" value="검색" /></div>
				</form>
			</div>
			<div class="adm-table01">
				<table>
					<thead>
						<tr>
							<th class="md_none">번호</th>
							<th>코드</th>
							<th>관리자아이디</th>
							<th>할인율</th>
							<th>수수료</th>
							<th>관리</th>
							
						</tr>
					</thead>
					<tbody>
					<?php
						for($i=0;$i<count($list);$i++){
					?>
						<tr>
							<td class="md_none"><?php echo $list[$i]['num']; ?></td>
							<td><?php echo strtoupper($list[$i]['code']); ?></td>
							<td><?php echo $list[$i]['mb_id']; ?></td>
							<td><?php echo number_format($list[$i]['sale']); ?>%</td>
							<td><?php echo number_format($list[$i]['fees']); ?>%</td>
							
							<td>
								<a href="<?php echo G5_URL."/admin/seller_write.php?page=".$page."&status=".$status."&sel=".$sel."&search=".$search."&id=".$list[$i]['id']; ?>">수정</a>
								<a href="javascript:del_confirm('<?php echo G5_URL."/admin/seller_delete.php?id=".$list[$i]['id']; ?>&page=<?php echo $page; ?>');">삭제</a>
							</td>
						</tr>
					<?php
						}
						if(count($list)==0){
							echo "<tr><td colspan='5' class='text-center' style='padding:100px 0;'>목록이 없습니다</td></tr>";
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
					<li class="prev"><a href="<?php echo G5_URL."/admin/seller.php?page=".($page-1)."&status=".$status."&sel=".$sel."&search=".$search; ?>">&lt;</a></li>
				<?php } ?>
				<?php for($i=$start_page;$i<=$end_page;$i++){ ?>
					<li class="<?php echo $page==$i?"active":""; ?>"><a href="<?php echo G5_URL."/admin/seller.php?page=".$i."&status=".$status."&sel=".$sel."&search=".$search; ?>"><?php echo $i; ?></a></li>
				<?php } ?>
				<?php if($page<$total_page){?>
					<li class="next"><a href="<?php echo G5_URL."/admin/seller.php?page=".($page+1)."&status=".$status."&sel=".$sel."&search=".$search; ?>">&gt;</a></li>
				<?php } ?>
				</ul>
			</div>
			<?php
			}
			?>
			<div class="text-right mt20">
				<a href="<?php echo G5_URL."/admin/seller_write.php"; ?>" class="adm-btn01">추가하기</a>
			</div>
		</article>
	</section>
</div>
<script type="text/javascript">
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
