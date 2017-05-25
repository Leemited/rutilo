<?php
	$code2=sql_fetch("select * from `gsw_code` where mb_id='".$member['mb_id']."'");
	if(!$is_admin && !$code2['id']){
		@alert("권한이 없습니다.",G5_URL);
	}else if(!$is_admin && $code2['id'] && !$p){
		goto_url(G5_URL."/admin/sell.php?code=".$code2['code']);
	}
?>
<!doctype html>
<html lang="ko">
	<head>
		<meta name="viewport" content="width=device-width,initial-scale=1.0,minimum-scale=0,maximum-scale=1.0,user-scalable=yes">
		<meta http-equiv="X-UA-Compatible" content="IE=10,chrome=1">
		<title>관리자페이지</title>
		<link href="<?php echo G5_CSS_URL; ?>/owl.carousel.css" type="text/css" rel="stylesheet" />
		<link href="<?php echo G5_CSS_URL; ?>/style.css" type="text/css" rel="stylesheet" />
		<link href="<?php echo G5_CSS_URL; ?>/admin.css" type="text/css" rel="stylesheet" />
		<!-- 웹폰트 -->
		<link href='http://fonts.googleapis.com/earlyaccess/nanumgothic.css' rel='stylesheet' type='text/css'>
		<!--[if lt IE 9]>
			<script src="http://html5shiv.googlecode.com/svn/trunk/html5.js"></script>
		<![endif]-->
		<script src="<?php echo G5_JS_URL ?>/jquery-1.8.3.min.js"></script>
		<script src="<?php echo G5_JS_URL ?>/common.js"></script>
		<script src="<?php echo G5_JS_URL ?>/wrest.js"></script>
		<script src="<?php echo G5_JS_URL ?>/jquery.ba-hashchange.js"></script>
		<script src="<?php echo G5_JS_URL ?>/script.js"></script>
		<script src="<?php echo G5_JS_URL ?>/owl.carousel.js"></script>
		<style type="text/css">/* SIR 지운아빠 */

		/* 방문자 집계 */
		#visit {border-bottom:1px dotted #666;border-top:1px dotted #666;background:#434343;}
		#visit div {margin:0 auto;width:202px;zoom:1}
		#visit div:after {display:block;visibility:hidden;clear:both;content:""}
		#visit dl {float:left;margin:0 0 0 10px;padding:0}
		#visit dt {float:left;margin:0;padding:10px 0 10px;font-size:12px;}
		#visit dd {float:left;margin:0 30px 0 0;padding:10px;font-size:12px;}
		#visit a {display:inline-block;padding:10px;text-decoration:none}
		#visit a:focus, #visit a:hover {}
		#visit br {display:block;}

		.tbl_head01 {padding:10px;}
		.tbl_head01 .current_connect_tbl{width:100%;}
		.tbl_head01 .current_connect_tbl td{padding:10px;}
		</style>
		<script>
		// 자바스크립트에서 사용하는 전역변수 선언
		var g5_url       = "<?php echo G5_URL ?>";
		var g5_bbs_url   = "<?php echo G5_BBS_URL ?>";
		var g5_is_member = "<?php echo isset($is_member)?$is_member:''; ?>";
		var g5_is_admin  = "<?php echo isset($is_admin)?$is_admin:''; ?>";
		var g5_is_mobile = "<?php echo G5_IS_MOBILE ?>";
		var g5_bo_table  = "<?php echo isset($bo_table)?$bo_table:''; ?>";
		var g5_sca       = "<?php echo isset($sca)?$sca:''; ?>";
		var g5_editor    = "<?php echo ($config['cf_editor'] && $board['bo_use_dhtml_editor'])?$config['cf_editor']:''; ?>";
		var g5_cookie_domain = "<?php echo G5_COOKIE_DOMAIN ?>";
		<?php
		if ($is_admin) {
			echo 'var g5_admin_url = "'.G5_ADMIN_URL.'";'.PHP_EOL;
		}
		?>
		</script>
		<style type="text/css">
			.adm-table02 table th{width:160px;}
			@media all and (max-width: 1120px){
				body{background:none;}
				aside{width:100%;height:115px;padding:0;background:#434343;position:relative;}
				header{margin-bottom:0;padding:20px 0;}
				header > a{margin:0 auto;position:relative;}
				header > div{text-align:right;position:absolute;right:20px;top:20px;}
				#copy{display:none;}
				#admin-menu{width:100%;height:48px;margin-top:5px;}
				#admin-menu li{width:20%;float:left;text-align:center;position:relative;}
				.list-title{font-size:14px;}
				#visit{display:none;}
				.list-item{background:#434343;position:absolute;width:100%;z-index:2;}
				.list-item div{text-align:center;text-indent:0;}
				#wrap > section{margin:0;padding:20px;}
			}
			@media all and (max-width: 900px){
				.md_none{display:none !important;}
				#admin-menu{height:96px;}
				#admin-menu li{width:33.33%;}
				aside{height:157px;}
				.list-item{position:absolute;width:100%;}
				#admin-title h1{font-size:24px;}
				#admin-title{margin-bottom:0;padding-top:0;}
				.adm-btn01{line-height:30px;height:30px;font-size:14px;}
			}
			@media all and (max-width: 480px){
				header{padding-top:30px;}
				header > div{top:10px;right:10px;font-size:11px;}
				aside{height:165px;}
				.list-title{font-size:13px;}
				#wrap > section{padding:10px;}
				.adm-table02 table th{width:30%;padding:10px;font-size:12px;}
				.adm-table02 table td{padding:7px;font-size:11px;}
				#admin-title{padding:10px 0;margin-bottom:0;}
				#admin-title hr{margin:0;padding:0;}
				#admin-title h1{font-size:20px;}
				.adm-table01 table th{font-size:12px;height:35px;}
				.adm-table01 table td{font-size:11px;height:30px;}
				.adm-btn01{line-height:25px;height:25px;font-size:12px;}
			}
		</style>
	</head>
	<?
	include_once(G5_LIB_PATH.'/visit.lib.php');
	include_once(G5_LIB_PATH.'/connect.lib.php');
	?>
	<body>
		<div class="modal"></div>
		<div class="small_modal"></div>
		<div class="msg"></div>
		<!-- 메뉴 start -->
		<aside>
			<header>
				<?php if($is_admin){ ?><a href="<?php echo G5_URL."/admin"; ?>">관리자페이지</a><?php }else{?><a href="<?php echo G5_URL."/admin/sell.php"; ?>" class="seller">판매자페이지</a><?php } ?>
				<div><a href="<?php echo G5_URL; ?>">홈페이지</a><span>|</span><a href="<?php echo G5_BBS_URL."/logout.php"; ?>">로그아웃</a></div>
			</header>
			<ul data-accordion-group id="admin-menu">
			<?php if($is_admin){ ?>
				<li class="accordion" data-accordion>
					<div data-control class="list-title">사이트관리</div>
					<div data-content class="list-item">
						<div><a href="<?php echo G5_URL."/admin/config.php"; ?>">기본정보관리</a></div>
						<div><a href="<?php echo G5_URL."/admin/banner.php"; ?>">배너관리</a></div>
						<div><a href="<?php echo G5_URL."/admin/popup.php"; ?>">팝업관리</a></div>
					</div>
				</li>
				<li class="accordion" data-accordion>
					<div data-control class="list-title">회원관리</div>
					<div data-content class="list-item">
						<div><a href="<?php echo G5_URL."/admin/member_list.php"; ?>">회원관리</a></div>
						<div><a href="<?php echo G5_URL."/admin/seller.php"; ?>">판매자관리</a></div>
					</div>
				</li>
				<li class="accordion" data-accordion>
					<div data-control class="list-title">온라인신청관리</div>
					<div data-content class="list-item">
						<div><a href="<?php echo G5_URL."/admin/academy.php"; ?>">아카데미관리</a></div>
						<div><a href="<?php echo G5_URL."/admin/application.php"; ?>">온라인신청관리</a></div>
					</div>
				</li>
				<li class="accordion" data-accordion>
					<div data-control class="list-title">제품관리</div>
					<div data-content class="list-item">
						<div><a href="<?php echo G5_URL."/admin/category.php"; ?>">대분류관리</a></div>
						<div><a href="<?php echo G5_URL."/admin/category_banner.php"; ?>">배너관리</a></div>
						<div><a href="<?php echo G5_URL."/admin/product.php"; ?>">제품관리</a></div>
						<div><a href="<?php echo G5_URL."/admin/delivery.php"; ?>">배송비관리</a></div>
						<div><a href="<?php echo G5_URL."/admin/exchange.php"; ?>">환율관리</a></div>
						<div><a href="<?php echo G5_URL."/admin/promotioncode.php"; ?>">프로모션 코드</a></div>
					</div>
				</li>
				<li class="accordion" data-accordion>
					<div data-control class="list-title">판매관리</div>
					<div data-content class="list-item">
						<div><a href="<?php echo G5_URL."/admin/sell.php"; ?>">매출관리</a></div>
						<div><a href="<?php echo G5_URL."/admin/refund.php"; ?>">환불관리</a></div>
					</div>
				</li>
				<li class="accordion last-item" data-accordion>
					<div><?=visit("basic")?></div>
					<div><?=connect("basic")?></div>
				</li>
			<?php
				}else{
					if($code2['id']){
			?>
					<li class="accordion" data-accordion>
						<div class="list-title" style="background:none;"><a href="<?php echo G5_URL."/admin/sell.php"; ?>">매출관리</a></div>
					</li>
			<?php
					}
				}
			?>
			</ul>
			<div id="copy">&copy; GORLLA SMARTWAY All Rights Reserved.</div>
		</aside>
		<!-- 메뉴 end -->