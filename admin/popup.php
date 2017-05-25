<?php
	include_once("../common.php");
	include_once(G5_PATH."/admin/head.php");
	$total=sql_fetch("select count(*) as cnt from `gsw_popup` where 1 {$where} order by `id` desc");
	if(!$page)
		$page=1;
	$total=$total['cnt'];
	$rows=10;
	$start=($page-1)*$rows;
	$total_page=ceil($total/$rows);
	$sql="select * from `gsw_popup` order by `id` desc limit {$start},{$rows}";
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
			<h1>팝업 관리</h1>
			<hr />
		</header>
		<article>
			<div class="adm-table01">
				<table>
					<thead>
						<tr>
							<th class="md_none">번호</th>
							<th style="width:50%;">팝업</th>
							<th>링크</th>
							<th>target</th>
							<th>시간</th>
							<th>상태</th>
							<th>관리</th>
						</tr>
					</thead>
					<tbody>
					<?php
						for($i=0;$i<count($list);$i++){
					?>
						<tr>
							<td class="md_none"><?php echo $list[$i]['num']; ?></td>
							<td><img src="<?php echo G5_DATA_URL."/popup/".$list[$i]['popup']; ?>" alt="popup" /></td>
							<td><?php echo $list[$i]['link']; ?></td>
							<td><?php echo $list[$i]['target']; ?></td>
							<td><?php echo $list[$i]['time']; ?></td>
							<td><?php echo $list[$i]['status']?"활성":"비활성"; ?></td>
							<td>
								<a href="<?php echo G5_URL."/admin/popup_write.php?id=".$list[$i]['id']."&search=".$search."&page=".$page; ?>">수정</a>
								<a href="javascript:del_confirm('<?php echo G5_URL."/admin/popup_delete.php?id=".$list[$i]['id']; ?>&page=<?php echo $page; ?>');">삭제</a>
							</td>
						</tr>
					<?php
						}
						if(count($list)==0){
							echo "<tr><td colspan='7' class='text-center' style='padding:100px 0;'>목록이 없습니다</td></tr>";
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
					<li class="prev"><a href="<?php echo G5_URL."/admin/popup.php?page=".($page-1); ?>">&lt;</a></li>
				<?php } ?>
				<?php for($i=$start_page;$i<=$end_page;$i++){ ?>
					<li class="<?php echo $page==$i?"active":""; ?>"><a href="<?php echo G5_URL."/admin/popup.php?page=".$i; ?>"><?php echo $i; ?></a></li>
				<?php } ?>
				<?php if($page<$total_page){?>
					<li class="next"><a href="<?php echo G5_URL."/admin/popup.php?page=".($page+1); ?>">&gt;</a></li>
				<?php } ?>
				</ul>
			</div>
			<?php
			}
			?>
			<div class="text-right mt20">
				<a href="<?php echo G5_URL."/admin/popup_write.php"; ?>" class="adm-btn01">추가하기</a>
			</div>
		</article>
	</section>
</div>
<script type="text/javascript">
	function del_confirm(url){
		if(confirm('삭제시 정보는 돌릴 수 없습니다.\n삭제하시겠습니까?')){
			location.href=url;
		}else{
			return false;
		}
	}
</script>
<?php
	include_once(G5_PATH."/admin/tail.php");
?>
