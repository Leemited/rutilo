<?php
	include_once("../common.php");
	include_once(G5_PATH."/admin/head.php");
	if($id){
		$view=sql_fetch("select * from `gsw_academy` where id='".$id."'");
	}
	$view['schedule_array']=explode("||",$view['schedule']);
	for($i=0;$i<count($view['schedule_array']);$i++){
		$view['schedule_array'][$i]=explode("|",$view['schedule_array'][$i]);
	}
?>
<!-- 본문 start -->
<div id="wrap">
	<section>
		<header id="admin-title">
			<h1>아카데미 관리</h1>
			<hr />
		</header>
		<article id="admin_academy_write">
			<div class="adm-table02">
				<table>
					<tr>
						<th>커리큘럼 이름 *</th>
						<td><?php echo $view['name']; ?></td>
					</tr>
					<tr>
						<th>인원 *</th>
						<td><?php echo number_format($view['recruit']); ?></td>
					</tr>
					<tr>
						<th>기간 *</th>
						<td>
							<div class="grid_100">
								<?php echo $view['start']; ?> ~ <?php echo $view['end']; ?>
							</div>
						</td>
					</tr>
				</table>
				<table class="mt20 schedule">
					<?php
						for($i=0;$i<count($view['schedule_array']);$i++){
					?>
					<tr>
						<th><?php echo $i+1; ?>일</th>
						<td>
						<?php
							for($j=0;$j<count($view['schedule_array'][$i]);$j++){
								$view['schedule_array'][$i][$j]=explode("//",$view['schedule_array'][$i][$j]);
						?>
							<div class="content" style="padding:5px 0">
								<div class="grid_100">
									<div class="grid_20">
										<?php echo $view['schedule_array'][$i][$j][0] ?>
									</div>
									<div class="grid_80">
										<div<?php echo $view['schedule_array'][$i][$j][1]?" class='bold'":"" ?>><?php echo $view['schedule_array'][$i][$j][2] ?></div>
										<p><?php echo $view['schedule_array'][$i][$j][3]; ?></p>
									</div>
								</div>
							</div>
						<?php } ?>
						</td>
					</tr>
					<?php
						}
					?>
				</table>
			</div>
			<div class="text-center mt20">
				<a href="<?php echo G5_URL."/admin/academy.php?page=".$page."&search=".$search; ?>" class="adm-btn01 bg_gray">목록</a> <a href="<?php echo G5_URL."/admin/academy_write.php?id=".$id."&page=".$page."&search=".$search; ?>" class="adm-btn01">수정</a>
			</div>
		</article>
	</section>
</div>
<?php
	include_once(G5_PATH."/admin/tail.php");
?>
