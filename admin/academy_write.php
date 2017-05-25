<?php
	include_once("../common.php");
	include_once(G5_PATH."/admin/head.php");
	if($id){
		$write=sql_fetch("select * from `gsw_academy` where id='".$id."'");
	}
	$write['schedule_array']=explode("||",$write['schedule']);
	for($i=0;$i<count($write['schedule_array']);$i++){
		$write['schedule_array'][$i]=explode("|",$write['schedule_array'][$i]);
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
			<form action="<?php echo G5_URL."/admin/academy_update.php"; ?>" name="branch_form" id="branch_form" method="post" enctype="multipart/form-data">
				<input type="hidden" name="id" value="<?php echo $id; ?>" />
				<input type="hidden" name="page" value="<?php echo $page; ?>" />
				<input type="hidden" name="search" value="<?php echo $search; ?>" />
				<div class="adm-table02">
					<table>
						<tr>
							<th>커리큘럼 이름 *</th>
							<td><input type="text" name="name" id="name" required class="adm-input01 grid_100" value="<?php echo $write['name']; ?>" /></td>
						</tr>
						<tr>
							<th>인원 *</th>
							<td><input type="text" name="recruit" id="recruit" required class="adm-input01 grid_100" value="<?php echo $write['recruit']; ?>" onkeyup="return number_only(this);" /></td>
						</tr>
						<tr>
							<th>기간 *</th>
							<td>
								<div class="grid_100">
									<input type="text" name="start" id="start" required class="adm-input01 grid_45" value="<?php echo $write['start']; ?>" readonly />
									<span class="lh30 grid_10 text-center">~</span>
									<input type="text" name="end" id="end" required class="adm-input01 grid_45" value="<?php echo $write['end']; ?>" readonly />
								</div>
							</td>
						</tr>
					</table>
					<table class="mt20 schedule">
						<?php
							if($write['schedule']){
							for($i=0;$i<count($write['schedule_array']);$i++){
						?>
						<tr>
							<th><?php echo $i+1; ?>일</th>
							<td>
							<?php
								for($j=0;$j<count($write['schedule_array'][$i]);$j++){
									$write['schedule_array'][$i][$j]=explode("//",$write['schedule_array'][$i][$j]);
							?>
								<div class="content">
									<div class="grid_100">
										<input type="text" name="time[<?php echo $i?>][]" id="time" value="<?php echo $write['schedule_array'][$i][$j][0] ?>" required class="adm-input01 grid_30 time" placeholder="시간 ex) 12:00 ~ 14:00" />
										<label class="lh30 grid_10 text-center"><input type="checkbox" name="bold[<?php echo $i?>][]" <?php echo $write['schedule_array'][$i][$j][1]?"checked":"" ?> class="bold" id="bold_<?php echo $i."_".$j;?>" value="1" />굵게 표시</label>
										<input type="text" name="title[<?php echo $i?>][]" id="title" required class="adm-input01 grid_60 title" value="<?php echo $write['schedule_array'][$i][$j][2] ?>" placeholder="강의 제목" />
									</div>
									<div class="grid_100">
										<textarea name="con[<?php echo $i?>][]" id="con" class="adm-input01 grid_100 con" style="height:100px;" placeholder="강의 내용" cols="30" rows="10"><?php echo strip_tags($write['schedule_array'][$i][$j][3]); ?></textarea>
									</div>
								</div>
							<?php } ?>
							</td>
						</tr>
						<?php
							}
						?>
							
						<?php }else{ ?>
						<tr>
							<th>1일</th>
							<td>
								<div class="content">
									<div class="grid_100">
										<input type="text" name="time[0][]" id="time" required class="adm-input01 grid_30 time" placeholder="시간 ex) 12:00 ~ 14:00" />
										<label class="lh30 grid_10 text-center"><input type="checkbox" name="bold[0][]" class="bold" id="bold_0_0" value="1" />굵게 표시</label>
										<input type="text" name="title[0][]" id="title" required class="adm-input01 grid_60 title" placeholder="강의 제목" />
									</div>
									<div class="grid_100">
										<textarea name="con[0][]" id="con" class="adm-input01 grid_100 con" style="height:100px;" placeholder="강의 내용" cols="30" rows="10"></textarea>
									</div>
								</div>
							</td>
						</tr>
						<?php } ?>
					</table>
					<div class="mt10 text-right small_btn_group">
						<a href="javascript:schedule_day_add();" class="bg_black white">일추가</a>
						<a href="javascript:schedule_day_del();" class="bg_black white">일삭제</a>
						<a href="javascript:schedule_time_add();">시간추가</a>
						<a href="javascript:schedule_time_del();">시간삭제</a>
					</div>
				</div>
				<div class="text-center mt20">
					<input type="submit" value="확인" class="adm-btn01" />
				</div>
			</form>
		</article>
	</section>
</div>
<script src="//code.jquery.com/ui/1.11.4/jquery-ui.js"></script>
<link rel="stylesheet" href="//code.jquery.com/ui/1.11.4/themes/smoothness/jquery-ui.css">
<script type="text/javascript">
	$(function(){
		$( "#start" ).datepicker({
			dateFormat:"yy-mm-dd",
			minDate: 0,
			onSelect: function( selectedDate ) {
				$( "#end" ).datepicker( "option", "minDate", selectedDate );
			}
		});
		$( "#end" ).datepicker({
			dateFormat:"yy-mm-dd",
			minDate: 0,
			onSelect: function( selectedDate ) {
				$( "#start" ).datepicker( "option", "maxDate", selectedDate );
				var dateObject=new Date(selectedDate);
			}
		});
	});
	function schedule_day_add(){
		var table=$(".schedule");
		var day=$(".schedule tr").length;
		table.find("tr:last").clone().appendTo(table);
		table.find("tr:last th").html((day+1)+"일");
		table.find("tr:last .time").attr("name","time["+day+"][]");
		table.find("tr:last .bold").attr("name","bold["+day+"][]");
		table.find("tr:last .title").attr("name","title["+day+"][]");
		table.find("tr:last .con").attr("name","con["+day+"][]");
	}
	function schedule_day_del(){
		var table=$(".schedule");
		var day=$(".schedule tr").length;
		if(day<=1){
			alert("더이상 삭제하실수 없습니다.");
		}else{
			table.find('tr:last').remove();
		}
	}
	function schedule_time_add(){
		var td=$(".schedule tr:last td");
		var time=$(".schedule tr:last .content").length;
		td.find(".content:last").clone().appendTo(td);
	}
	function schedule_time_del(){
		var td=$(".schedule tr:last td");
		var time=$(".schedule tr:last td .content").length;
		if(time<=1){
			alert("더이상 삭제하실수 없습니다.");
		}else{
			td.find('.content:last').remove();
		}
	}
</script>
<?php
	include_once(G5_PATH."/admin/tail.php");
?>
