<?php
	include_once("../common.php");
	include_once(G5_PATH."/admin/head.php");
	$where="";
	if($search!=""&&$sel!=""){
		$where="and `{$sel}` like '%{$search}%'";
	}
	if($academy_id){
		$where.="and a.`academy_id` = '{$academy_id}'";
	}
	if($status){
		$where.="and a.`status` = '{$status}'";
	}
	$total=sql_fetch("select count(*) as cnt from `gsw_application` as a inner join `gsw_academy` as b on a.academy_id=b.id where 1 {$where} order by a.`id` desc");
	if(!$page)
		$page=1;
	$total=$total['cnt'];
	$rows=10;
	$start=($page-1)*$rows;
	$total_page=ceil($total/$rows);
	$sql="select *,a.id as id,(select sum(person) from `gsw_application` as c where a.academy_id=c.academy_id and a.`id`>=c.`id` and a.status<>'-1') as sum_person from `gsw_application` as a inner join `gsw_academy` as b on a.academy_id=b.id where 1 {$where} order by a.`id` desc limit {$start},{$rows};";
	$query=sql_query($sql);
	$j=0;
	while($data=sql_fetch_array($query)){
		$list[$j]=$data;
		$list[$j]['num']=$total-($start)-$j;
		$j++;
	}
	$academy_sql="select * from `gsw_academy`";
	$academy_query=sql_query($academy_sql);
	$i=0;
	while($academy_data=sql_fetch_array($academy_query)){
		$academy_array[$i]=$academy_data;
		$i++;
	}
?>
<!-- 본문 start -->
<div id="wrap">
	<section>
		<header id="admin-title">
			<h1>온라인신청관리</h1>
			<hr />
		</header>
		<article>
			<div class="grid_100 text-right" style="margin-bottom:20px">
				<select name="status" class="adm-input01" id="status" onchange="javascript:location.href='<?php echo G5_URL."/admin/application.php?page=".$page."&sel=".$sel."&search=".$search."&academy=".$academy."&status="; ?>'+this.value;">
					<option value="">상태 선택</option>
					<option value="0"<?php echo $status!=""&&$status==0?" selected":""; ?>>대기</option>
					<option value="1"<?php echo $status!=""&&$status==1?" selected":""; ?>>승인</option>
					<option value="-1"<?php echo $status!=""&&$status==-1?" selected":""; ?>>취소</option>
				</select>
				<select name="academy_id" class="adm-input01" id="academy_id" onchange="javascript:location.href='<?php echo G5_URL."/admin/application.php?page=".$page."&sel=".$sel."&search=".$search."&status=".$status."&academy="; ?>'+this.value;">
					<option value="">아카데미 선택</option>
					<?php
					for($i=0;$i<count($academy_array);$i++){
					?>
					<option value="<?php echo $academy_array[$i]['id']; ?>"<?php echo $academy_array[$i]['id']==$academy?" selected":""; ?>><?php echo $academy_array[$i]['name']; ?>(<?php echo $academy_array[$i]['start']; ?>~<?php echo $academy_array[$i]['end']; ?>)</option>
					<?php
					}
					?>
				</select>
			</div>
			<div class="grid_100" style="margin-bottom:30px">
				<form action="" method="get">
					<div class="grid_15 pl10">
						<select name="sel" id="sel" class="grid_100 adm-input01">
							<option value="">선택</option>
							<option value="mb_name">이름</option>
							<option value="mb_hp">연락처</option>
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
							<th>이름</th>
							<th>연락처</th>
							<th>수강인원</th>
							<th>희망수강일</th>
							<th>상태</th>
							<th>관리</th>
						</tr>
					</thead>
					<tbody>
					<?php
						for($i=0;$i<count($list);$i++){
							$status="";
							switch($list[$i]['status']){
								case 0:$status="대기";break;
								case 1:$status="승인";break;
								case -1:$status="취소";break;
								default:$status="대기";break;
							}
					?>
						<tr>
							<td class="md_none"><?php echo $list[$i]['num']; ?></td>
							<td><?php echo $list[$i]['mb_name']; ?></td>
							<td><?php echo $list[$i]['mb_hp']; ?></td>
							<td><?php echo number_format($list[$i]['person']); ?>명<br />(<?php echo number_format($list[$i]['sum_person']); ?>/<?php echo number_format($list[$i]['recruit']); ?>)</td>
							<td><?php echo $list[$i]['name']; ?><br />(<?php echo $list[$i]['start']; ?>~<?php echo $list[$i]['end']; ?>)</td>
							<td><?php echo $status; ?></td>
							<td>
								<a href="<?php echo G5_URL."/admin/application_status.php?id=".$list[$i]['id']."&status=-1"; ?>">취소</a>
								<a href="<?php echo G5_URL."/admin/application_status.php?id=".$list[$i]['id']."&status=1"; ?>">승인</a><br />
								<a href="<?php echo G5_URL."/admin/application_write.php?page=".$page."&status=".$status."&sel=".$sel."&search=".$search."&academy=".$academy."&id=".$list[$i]['id']; ?>">수정</a>
								<a href="javascript:del_confirm('<?php echo G5_URL."/admin/application_delete.php?id=".$list[$i]['id']; ?>&page=<?php echo $page; ?>');">삭제</a>
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
					<li class="prev"><a href="<?php echo G5_URL."/admin/application.php?page=".($page-1); ?>">&lt;</a></li>
				<?php } ?>
				<?php for($i=$start_page;$i<=$end_page;$i++){ ?>
					<li class="<?php echo $page==$i?"active":""; ?>"><a href="<?php echo G5_URL."/admin/application.php?page=".$i; ?>"><?php echo $i; ?></a></li>
				<?php } ?>
				<?php if($page<$total_page){?>
					<li class="next"><a href="<?php echo G5_URL."/admin/application.php?page=".($page+1); ?>">&gt;</a></li>
				<?php } ?>
				</ul>
			</div>
			<?php
			}
			?>
			<div class="text-right mt20">
				<a href="<?php echo G5_URL."/admin/application_write.php"; ?>" class="adm-btn01">추가하기</a>
			</div>
		</article>
	</section>
</div>
<script type="text/javascript">
	function del_confirm(url){
		if(confirm('삭제시 정보는 돌릴 수 없습니다.\n삭제 이전에 공지 해주십시오\n삭제하시겠습니까?')){
			location.href=url;
		}else{
			return false;
		}
	}
</script>
<?php
	include_once(G5_PATH."/admin/tail.php");
?>
