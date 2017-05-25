<?php
	include_once("../common.php");
	include_once(G5_PATH."/admin/head.php");
	$where="";
	if($sel!="" && $search!=""){
		$where.="and `{$sel}` like '%{$search}%'";
	}
	if($mb_2!=""){
		$where.="and `mb_2` = '{$mb_2}'";
	}
	$total=sql_fetch("select count(*) as cnt from `g5_member` where 1 {$where} order by `mb_no` desc");
	if(!$page)
		$page=1;
	$total=$total['cnt'];
	$rows=10;
	$start=($page-1)*$rows;
	$total_page=ceil($total/$rows);
	$sql="select * from `g5_member` where 1 {$where} order by `mb_no` desc limit {$start},{$rows}";
	$query=sql_query($sql);
	$j=0;
	while($data=sql_fetch_array($query)){
		$list[$j]=$data;
		$list[$j]['num']=$total-($start)-$j;
		$j++;
	}
	$code_sql="select * from `gsw_code`";
	$code_query=sql_query($code_sql);
	$i=0;
	while($code_data=sql_fetch_array($code_query)){
		$code_array[$i]=$code_data;
		$i++;
	}
?>
<!-- 본문 start -->
<div id="wrap">
	<section>
		<header id="admin-title">
			<h1>회원관리</h1>
			<hr />
		</header>
		<article>
			<div class="grid_100 text-right" style="margin-bottom:20px">
				<select name="code" class="adm-input01" id="code" onchange="javascript:location.href='<?php echo G5_URL."/admin/member_list.php?page=".$page."&sel=".$sel."&search=".$search."&mb_2="; ?>'+this.value;">
					<option value="">코드선택</option>
					<?php
					for($i=0;$i<count($code_array);$i++){
					?>
					<option value="<?php echo $code_array[$i]['code']; ?>"<?php echo $code_array[$i]['id']==$mb_2?" selected":""; ?>><?php echo $code_array[$i]['code']; ?></option>
					<?php
					}
					?>
				</select>
			</div>
			<div class="grid_100" style="margin-bottom:30px">
				<form action="" method="get">
					<div class="grid_15">
						<select name="sel" id="sel" class="grid_100 adm-input01">
							<option value="mb_id" <?php echo $sel=="mb_id"?"selected":""; ?>>아이디</option>
							<option value="mb_name" <?php echo $sel=="mb_name"?"selected":""; ?>>이름</option>
							<option value="mb_hp" <?php echo $sel=="mb_hp"?"selected":""; ?>>휴대폰번호</option>
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
							<th>아이디</th>
							<th>이름</th>
							<th class="md_none">이메일</th>
							<th>휴대폰번호</th>
							<th>코드</th>
							<th class="md_none">가입일</th>
							<th class="md_none">최종접속일</th>
							<th>관리</th>
						</tr>
					</thead>
					<tbody>
					<?php
						for($i=0;$i<count($list);$i++){
					?>
						<tr>
							<td class="md_none" onclick="location.href='<?php echo G5_URL."/admin/member_view.php?page=".$page."&sel=".$sel."&search=".$search."&mb_2=".$mb_2."&mb_no=".$list[$i]['mb_no']; ?>';"><?php echo $list[$i]['num']; ?></td>
							<td onclick="location.href='<?php echo G5_URL."/admin/member_view.php?page=".$page."&sel=".$sel."&search=".$search."&mb_2=".$mb_2."&mb_no=".$list[$i]['mb_no']; ?>';"><?php echo $list[$i]['mb_id']; ?></td>
							<td onclick="location.href='<?php echo G5_URL."/admin/member_view.php?page=".$page."&sel=".$sel."&search=".$search."&mb_2=".$mb_2."&mb_no=".$list[$i]['mb_no']; ?>';"><?php echo $list[$i]['mb_name']; ?></td>
							<td class="md_none" onclick="location.href='<?php echo G5_URL."/admin/member_view.php?page=".$page."&sel=".$sel."&search=".$search."&mb_2=".$mb_2."&mb_no=".$list[$i]['mb_no']; ?>';"><?php echo $list[$i]['mb_email']; ?></td>
							<td onclick="location.href='<?php echo G5_URL."/admin/member_view.php?page=".$page."&sel=".$sel."&search=".$search."&mb_2=".$mb_2."&mb_no=".$list[$i]['mb_no']; ?>';">+<?php echo $list[$i]['mb_1']; ?> <?php echo $list[$i]['mb_hp']; ?></td>
							<td onclick="location.href='<?php echo G5_URL."/admin/member_view.php?page=".$page."&sel=".$sel."&search=".$search."&mb_2=".$mb_2."&mb_no=".$list[$i]['mb_no']; ?>';"><?php echo strtoupper($list[$i]['mb_2']); ?></td>
							<td class="md_none" onclick="location.href='<?php echo G5_URL."/admin/member_view.php?page=".$page."&sel=".$sel."&search=".$search."&mb_2=".$mb_2."&mb_no=".$list[$i]['mb_no']; ?>';"><?php echo date("Y.m.d H:i",strtotime($list[$i]['mb_datetime'])); ?></td>
							<td class="md_none" onclick="location.href='<?php echo G5_URL."/admin/member_view.php?page=".$page."&sel=".$sel."&search=".$search."&mb_2=".$mb_2."&mb_no=".$list[$i]['mb_no']; ?>';"><?php echo date("Y.m.d H:i",strtotime($list[$i]['mb_today_login'])); ?></td>
							<td><a href="<?php echo G5_URL."/admin/member_stop.php?mb_no=".$list[$i]['mb_no']; ?>"><?php echo $list[$i]['mb_intercept_date']?"활성":"정지"; ?></a></td>
						</tr>
					<?php
						}
						if(count($list)==0){
							echo "<tr><td colspan='9' class='text-center' style='padding:100px 0;'>목록이 없습니다</td></tr>";
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
					<li class="prev"><a href="<?php echo G5_URL."/admin/member_list.php?page=".($page-1)."&sel=".$sel."&search=".$search."&mb_2=".$mb_2; ?>">&lt;</a></li>
				<?php } ?>
				<?php for($i=$start_page;$i<=$end_page;$i++){ ?>
					<li class="<?php echo $page==$i?"active":""; ?>"><a href="<?php echo G5_URL."/admin/member_list.php?page=".$i."&sel=".$sel."&search=".$search."&mb_2=".$mb_2; ?>"><?php echo $i; ?></a></li>
				<?php } ?>
				<?php if($page<$total_page){?>
					<li class="next"><a href="<?php echo G5_URL."/admin/member_list.php?page=".($page+1)."&sel=".$sel."&search=".$search."&mb_2=".$mb_2; ?>">&gt;</a></li>
				<?php } ?>
				</ul>
			</div>
			<?php
			}
			?>
		</article>
	</section>
</div>
<script type="text/javascript">
	function del_confirm(url){
		if(confirm('삭제시 회원정보는 돌릴 수 없습니다.\n삭제하시겠습니까?')){
			location.href=url;
		}else{
			return false;
		}
	}
</script>
<?php
	include_once(G5_PATH."/admin/tail.php");
?>
