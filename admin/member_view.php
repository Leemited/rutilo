<?php
	include_once("../common.php");
	include_once(G5_PATH."/admin/head.php");
?>
<?php
	$mb_no=$_GET['mb_no'];
	if(!$mb_no){
		@alert('회원 번호가 없습니다.');
	}
	$mb=sql_fetch("select * from g5_member where mb_no='{$mb_no}';");
?>
 <script src="<?php echo G5_JS_URL ?>/jquery.register_form.js"></script>
<!-- 본문 start -->
<div id="wrap">
	<section>
		<header id="admin-title">
			<h1>회원관리</h1>
			<hr />
		</header>
		<article>
			<div class="adm-table02">
				<form action="<?php echo G5_URL."/admin/member_update.php"; ?>" method="post" id="fregisterform" name="fregisterform" onsubmit="return fregisterform_submit(this);">
					<input type="hidden" name="mb_no" value="<?php echo $mb_no?>" />
					<table>
						<tr>
							<th>아이디</th>
							<td><input type="text" name="mb_id" value="<?php echo $mb['mb_id'] ?>" id="reg_mb_id"class="adm-input01 grid_100" minlength="3" readonly maxlength="20" placeholder="아이디를 입력하세요."></td>
						</tr>
						<tr>
							<th>이름</th>
							<td><input type="text" name="mb_name" value="<?php echo $mb['mb_name'] ?>" id="mb_name"class="adm-input01 grid_100" minlength="3" maxlength="20" placeholder="아이디를 입력하세요."></td>
						</tr>
						<tr>
							<th>비밀번호</th>
							<td><input type="password" name="mb_password" id="reg_mb_password" <?php echo $required ?> class="adm-input01 grid_100" minlength="3" maxlength="20" placeholder="비밀번호를 입력하세요. (8~20자)"></td>
						</tr>
						<tr>
							<th>이메일</th>
							<td><input type="email" name="mb_email" value="<?php echo $mb['mb_email'] ?>" id="reg_mb_email" <?php echo $required ?> class="adm-input01 grid_100" minlength="3" placeholder="이메일을 입력하세요"></td>
						</tr>
						<tr>
							<th>휴대폰 번호</th>
							<td>
								<select name="mb_1" id="mb_1" class="adm-input01 grid_20 light_gray" required>
									<option value="">국가코드</option>
									<option value="86" data-label="+86" <?php echo $mb['mb_1']=="86"?"selected":""; ?>>+86</option>
									<option value="852" data-label="+852" <?php echo $mb['mb_1']=="852"?"selected":""; ?>>+852</option>
									<option value="82" data-label="+82" <?php echo $mb['mb_1']=="82"?"selected":""; ?>>+82</option>
								</select>
								<input type="text" name="mb_hp" id="reg_mb_hp" value="<?php echo $mb['mb_hp']; ?>" class="adm-input01 grid_80" onkeyup="return number_only(this);" placeholder="휴대폰 번호는 '-'를 생략하고 작성해주세요" />
							</td>
						</tr>
						<tr>
							<th>코드</th>
							<td><input type="text" name="mb_2" id="mb_2" value="<?php echo strtoupper($mb['mb_2']); ?>" class="adm-input01 grid_100"  /></td>
						</tr>
						<tr>
							<th>상태</th>
							<td>
							<?php if($mb['mb_leave_date']){ ?>
								탈퇴 (<?php echo date("Y년 m월 d일",strtotime($mb['mb_leave_date'])); ?>)
							<?php }else{ ?>
								<?php echo $mb['mb_intercept_date']?"정지 (".date("Y년 m월 d일",strtotime($mb['mb_intercept_date'])).")":"활성"; ?>
							<?php } ?>
								<a href="<?php echo G5_URL."/admin/member_stop.php?mb_no=".$mb_no; ?>" class="btn white bg_gray color_white font_size_12" style="padding:3px 7px;float:right">변경</a>
							</td>
						</tr>
						<tr>
							<th>가입일</th>
							<td>
							<?php echo date("Y.m.d H:i",strtotime($mb['mb_datetime'])); ?>
							</td>
						</tr>
						<tr>
							<th>최종접속일</th>
							<td>
							<?php echo date("Y.m.d H:i",strtotime($mb['mb_today_login'])); ?>
							</td>
						</tr>
					</table>
					<div class="grid_100 mt20 text-center">
						<a href="<?php echo G5_URL."/admin/member_list.php?page=".$page."&sel=".$sel."&search=".$search."&mb_2=".$mb_2; ?>" class="btn adm-btn01" style="background:#aaa;">취소</a>
						<input type="submit" value="수정" id="btn_submit" class="btn adm-btn01" accesskey="s">
					</div>
				</form>
			</div>
		</article>
	</section>
</div>
<script src="http://dmaps.daum.net/map_js_init/postcode.v2.js"></script>
<script type="text/javascript">
	function fregisterform_submit(f){
		if (f.mb_password.value.length > 0) {
            if (f.mb_password.value.length < 8) {
                alert("비밀번호를 8글자 이상 입력하십시오.");
                f.mb_password.focus();
                return false;
            }
        }
		 // E-mail 검사
        if ((f.mb_email.defaultValue != f.mb_email.value)) {
            var msg = reg_mb_email_check();
            if (msg) {
                alert(msg);
                f.reg_mb_email.select();
                return false;
            }
        }
		
		if (f.mb_name.value.length < 1) {
			alert("이름을 입력하십시오.");
			f.mb_name.focus();
			return false;
		}
		// 휴대폰번호 체크
        var msg = reg_mb_hp_check();
        if (msg) {
            alert(msg);
            f.reg_mb_hp.select();
            return false;
        }
	}
</script>
<?php
	include_once(G5_PATH."/admin/tail.php");
?>
