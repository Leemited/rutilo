<?php
	include_once("../common.php");
	include_once(G5_PATH."/admin/head.php");
	if($search!=""){
		$where="and `name` like '%{$search}%'";
	}
	$total=sql_fetch("select count(*) as cnt from `gsw_academy` where 1 {$where} order by `id` desc");
	if(!$page)
		$page=1;
	$total=$total['cnt'];
	$rows=10;
	$start=($page-1)*$rows;
	$total_page=ceil($total/$rows);
	$sql="select *,(select sum(person) from `gsw_application` as b where b.academy_id=a.id and `status`<>'-1') as application from `gsw_academy` as a where 1 {$where} order by `id` desc limit {$start},{$rows}";
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
			<h1>아카데미 관리</h1>
			<hr />
		</header>
		<article>
			<div class="grid_100" style="margin-bottom:30px">
				<form action="" method="get">
					<div class="grid_80 pl10"><input type="text" name="search" id="search" class="grid_100 adm-input01" placeholder="커리큘럼 이름" value="<?php echo $search; ?>" /></div>
					<div class="grid_20 pl10"><input type="submit" class="grid_100 white lh30 btn" style="background:#666;border:none;" value="검색" /></div>
				</form>
			</div>
			<div class="adm-table01">
				<table>
					<thead>
						<tr>
							<th class="md_none">번호</th>
							<th>커리큘럼이름</th>
							<th>인원</th>
							<th>수강일</th>
							<th>관리</th>
						</tr>
					</thead>
					<tbody>
					<?php
						for($i=0;$i<count($list);$i++){
					?>
						<tr>
							<td class="md_none" onclick="location.href='<?php echo G5_URL."/admin/academy_view.php?id=".$list[$i]['id']."&search=".$search."&page=".$page; ?>';"><?php echo $list[$i]['num']; ?></td>
							<td onclick="location.href='<?php echo G5_URL."/admin/academy_view.php?id=".$list[$i]['id']."&search=".$search."&page=".$page; ?>';"><?php echo $list[$i]['name']; ?></td>
							<td onclick="location.href='<?php echo G5_URL."/admin/academy_view.php?id=".$list[$i]['id']."&search=".$search."&page=".$page; ?>';"><?php echo number_format($list[$i]['application']); ?>/<?php echo number_format($list[$i]['recruit']); ?></td>
							<td onclick="location.href='<?php echo G5_URL."/admin/academy_view.php?id=".$list[$i]['id']."&search=".$search."&page=".$page; ?>';"><?php echo $list[$i]['start']; ?> ~ <?php echo $list[$i]['end']; ?></td>
							<td>
								<a href="<?php echo G5_URL."/admin/academy_write.php?id=".$list[$i]['id']."&search=".$search."&page=".$page; ?>">수정</a>
								<a href="javascript:del_confirm('<?php echo G5_URL."/admin/academy_delete.php?id=".$list[$i]['id']; ?>&page=<?php echo $page; ?>');">삭제</a>
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
					<li class="prev"><a href="<?php echo G5_URL."/admin/academy.php?page=".($page-1)."&search=".$search; ?>">&lt;</a></li>
				<?php } ?>
				<?php for($i=$start_page;$i<=$end_page;$i++){ ?>
					<li class="<?php echo $page==$i?"active":""; ?>"><a href="<?php echo G5_URL."/admin/academy.php?page=".$i."&search=".$search; ?>"><?php echo $i; ?></a></li>
				<?php } ?>
				<?php if($page<$total_page){?>
					<li class="next"><a href="<?php echo G5_URL."/admin/academy.php?page=".($page+1)."&search=".$search; ?>">&gt;</a></li>
				<?php } ?>
				</ul>
			</div>
			<?php
			}
			?>
			<div class="text-right mt20">
				<a href="<?php echo G5_URL."/admin/academy_write.php"; ?>" class="adm-btn01">추가하기</a>
			</div>
		</article>
	</section>
</div>
<script type="text/javascript">
	function del_confirm(url){
		if(confirm('삭제시 정보는 돌릴 수 없습니다.\n삭제후 해당하는 아카데미에 신청한 고객정보도 같이 삭제 되어 볼 수 없습니다.\n삭제 이전에 공지 해주십시오\n삭제하시겠습니까?')){
			location.href=url;
		}else{
			return false;
		}
	}
</script>
<?php
	include_once(G5_PATH."/admin/tail.php");
?>
