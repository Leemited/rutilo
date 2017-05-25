<?php
	include_once("../common.php");
	include_once(G5_PATH."/admin/head.php");
	if($category!=""){
		$where="and `cate`='{$category}'";
	}
	$total=sql_fetch("select count(*) as cnt from `gsw_sub_category` where 1 {$where} order by `od` asc");
	if(!$page)
		$page=1;
	$total=$total['cnt'];
	$rows=10;
	$start=($page-1)*$rows;
	$total_page=ceil($total/$rows);
	$sql="select *, (select od from `gsw_category` as c where c.cate=s.cate) as cod from `gsw_sub_category` as s where 1 {$where} order by `cod`, `od` asc limit {$start},{$rows}";
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
?>
<!-- 본문 start -->
<div id="wrap">
	<section>
		<header id="admin-title">
			<h1>소분류관리</h1>
			<hr />
		</header>
		<article>
			<div class="grid_100 text-right" style="margin-bottom:30px">
				<select name="status" class="adm-input01" id="category" onchange="javascript:location.href='<?php echo G5_URL."/admin/sub_category.php?page=".$page."&category="; ?>'+this.value;">
					<option value="">선택</option>
					<?php for($i=0;$i<count($cate);$i++){ ?>
					<option value="<?php echo $cate[$i]['cate']; ?>" <?php echo $cate[$i]['cate']==$category?"selected":""; ?>><?php echo $cate[$i]['cate']; ?></option>
					<?php } ?>
				</select>
			</div>
			<div class="adm-table01">
				<table>
					<thead>
						<tr>
							<th class="md_none">번호</th>
							<th>대분류</th>
							<th>소분류</th>
							<th>순서</th>
							<th>관리</th>
						</tr>
					</thead>
					<tbody>
					<?php
						for($i=0;$i<count($list);$i++){
					?>
						<tr>
							<td class="md_none"><?php echo $list[$i]['num']; ?></td>
							<td><?php echo $list[$i]['cate']; ?></td>
							<td><?php echo $list[$i]['sub_cate']; ?></td>
							<td><a href="<?php echo G5_URL."/admin/sub_category_order.php?id=".$list[$i]['id']."&od=0"; ?>" style="width:25px;background:#ddd;border:1px solid #aaa;line-height:25px;" class="btn text-center">▲</a> <a href="<?php echo G5_URL."/admin/sub_category_order.php?id=".$list[$i]['id']."&od=1"; ?>" style="width:25px;background:#ddd;border:1px solid #aaa;line-height:25px;" class="btn text-center">▼</a></td>
							<td>
								<a href="<?php echo G5_URL."/admin/sub_category_write.php?page=".$page."&id=".$list[$i]['id']."&category=".$category; ?>">수정</a>
								<a href="javascript:del_confirm('<?php echo G5_URL."/admin/sub_category_delete.php?id=".$list[$i]['id']; ?>&page=<?php echo $page; ?>');">삭제</a>
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
					<li class="prev"><a href="<?php echo G5_URL."/admin/sub_category.php?page=".($page-1)."&category=".$category; ?>">&lt;</a></li>
				<?php } ?>
				<?php for($i=$start_page;$i<=$end_page;$i++){ ?>
					<li class="<?php echo $page==$i?"active":""; ?>"><a href="<?php echo G5_URL."/admin/sub_category.php?page=".$i."&category=".$category; ?>"><?php echo $i; ?></a></li>
				<?php } ?>
				<?php if($page<$total_page){?>
					<li class="next"><a href="<?php echo G5_URL."/admin/sub_category.php?page=".($page+1)."&category=".$category; ?>">&gt;</a></li>
				<?php } ?>
				</ul>
			</div>
			<?php
			}
			?>
			<div class="text-right mt20">
				<a href="<?php echo G5_URL."/admin/sub_category_write.php"; ?>" class="adm-btn01">추가하기</a>
			</div>
		</article>
	</section>
</div>
<script type="text/javascript">
	function del_confirm(url){
		if(confirm('삭제시 돌릴 수 없습니다.\n제품관리, 소분류 관리 및 배너관리에서 해당사항 수정해주시기 바랍니다.\n삭제하시겠습니까?')){
			location.href=url;
		}else{
			return false;
		}
	}
</script>
<?php
	include_once(G5_PATH."/admin/tail.php");
?>
