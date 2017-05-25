<?php
	include_once("../common.php");
	include_once(G5_PATH."/admin/head.php");
	if(!$is_admin){
		alert("권한이 없습니다.",G5_URL);
	}
	$sql="select * from `g5_member` order by `mb_no` desc limit 0,5";
	$query=sql_query($sql);
	$j=0;
	while($data=sql_fetch_array($query)){
		$member_list[$j]=$data;
		$member_list[$j]['num']=$j+1;
		$j++;
	}
	$sql="select *,a.id as id,(select sum(person) from `gsw_application` as c where a.academy_id=c.academy_id and a.`id`>=c.`id` and a.status<>'-1') as sum_person from `gsw_application` as a inner join `gsw_academy` as b on a.academy_id=b.id where 1 order by a.`id` desc limit 0,5;";
	$query=sql_query($sql);
	$j=0;
	while($data=sql_fetch_array($query)){
		$application_list[$j]=$data;
		$application_list[$j]['num']=$j+1;
		$j++;
	}
?>
<!-- 본문 start -->
<div id="wrap">
	<section>
		<header id="admin-title">
			<h1>관리자페이지</h1>
			<hr />
		</header>
		<article>
			<h1 style="font-size:24px;margin-bottom:20px;font-weight:normal">회원관리 <a href="<?php echo G5_URL."/admin/member_list.php"; ?>" style="float:right;font-size:14px;vertical-align:bottom;margin-top:12px">더보기</a></h1>
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
						for($i=0;$i<count($member_list);$i++){
					?>
						<tr>
							<td class="md_none" onclick="location.href='<?php echo G5_URL."/admin/member_view.php?mb_no=".$member_list[$i]['mb_no']; ?>';"><?php echo $member_list[$i]['num']; ?></td>
							<td onclick="location.href='<?php echo G5_URL."/admin/member_view.php?mb_no=".$member_list[$i]['mb_no']; ?>';"><?php echo $member_list[$i]['mb_id']; ?></td>
							<td onclick="location.href='<?php echo G5_URL."/admin/member_view.php?mb_no=".$member_list[$i]['mb_no']; ?>';"><?php echo $member_list[$i]['mb_name']; ?></td>
							<td class="md_none" onclick="location.href='<?php echo G5_URL."/admin/member_view.php?mb_no=".$member_list[$i]['mb_no']; ?>';"><?php echo $member_list[$i]['mb_email']; ?></td>
							<td onclick="location.href='<?php echo G5_URL."/admin/member_view.php?mb_no=".$member_list[$i]['mb_no']; ?>';">+<?php echo $member_list[$i]['mb_1']; ?> <?php echo $member_list[$i]['mb_hp']; ?></td>
							<td onclick="location.href='<?php echo G5_URL."/admin/member_view.php?mb_no=".$member_list[$i]['mb_no']; ?>';"><?php echo strtoupper($member_list[$i]['mb_2']); ?></td>
							<td class="md_none" onclick="location.href='<?php echo G5_URL."/admin/member_view.php?mb_no=".$member_list[$i]['mb_no']; ?>';"><?php echo date("Y.m.d H:i",strtotime($member_list[$i]['mb_datetime'])); ?></td>
							<td class="md_none" onclick="location.href='<?php echo G5_URL."/admin/member_view.php?mb_no=".$member_list[$i]['mb_no']; ?>';"><?php echo date("Y.m.d H:i",strtotime($member_list[$i]['mb_today_login'])); ?></td>
							<td><a href="<?php echo G5_URL."/admin/member_stop.php?mb_no=".$member_list[$i]['mb_no']; ?>"><?php echo $member_list[$i]['mb_intercept_date']?"활성":"정지"; ?></a></td>
						</tr>
					<?php
						}
						if(count($member_list)==0){
							echo "<tr><td colspan='9' class='text-center' style='padding:100px 0;'>목록이 없습니다</td></tr>";
						}
					?>
					</tbody>
				</table>
			</div>
			<h1 style="font-size:24px;margin-bottom:20px;font-weight:normal;margin-top:30px">온라인신청관리 <a href="<?php echo G5_URL."/admin/application.php"; ?>" style="float:right;font-size:14px;vertical-align:bottom;margin-top:12px">더보기</a></h1>
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
						for($i=0;$i<count($application_list);$i++){
							$status="";
							switch($application_list[$i]['status']){
								case 0:$status="대기";break;
								case 1:$status="승인";break;
								case -1:$status="취소";break;
								default:$status="대기";break;
							}
					?>
						<tr>
							<td class="md_none"><?php echo $application_list[$i]['num']; ?></td>
							<td><?php echo $application_list[$i]['mb_name']; ?></td>
							<td><?php echo $application_list[$i]['mb_hp']; ?></td>
							<td><?php echo number_format($application_list[$i]['person']); ?>명<br />(<?php echo number_format($application_list[$i]['sum_person']); ?>/<?php echo number_format($application_list[$i]['recruit']); ?>)</td>
							<td><?php echo $application_list[$i]['name']; ?><br />(<?php echo $application_list[$i]['start']; ?>~<?php echo $application_list[$i]['end']; ?>)</td>
							<td><?php echo $status; ?></td>
							<td>
								<a href="<?php echo G5_URL."/admin/application_status.php?id=".$application_list[$i]['id']."&status=-1"; ?>">취소</a>
								<a href="<?php echo G5_URL."/admin/application_status.php?id=".$application_list[$i]['id']."&status=1"; ?>">승인</a><br />
								<a href="<?php echo G5_URL."/admin/application_write.php?page=".$page."&status=".$status."&sel=".$sel."&search=".$search."&academy=".$academy."&id=".$application_list[$i]['id']; ?>">수정</a>
								<a href="javascript:del_confirm('<?php echo G5_URL."/admin/application_delete.php?id=".$application_list[$i]['id']; ?>&page=<?php echo $page; ?>');">삭제</a>
							</td>
						</tr>
					<?php
						}
						if(count($application_list)==0){
							echo "<tr><td colspan='7' class='text-center' style='padding:100px 0;'>목록이 없습니다</td></tr>";
						}
					?>
					</tbody>
				</table>
			</div>
		</article>
	</section>
</div>
<?php
	include_once(G5_PATH."/admin/tail.php");
?>
