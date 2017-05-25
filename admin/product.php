<?php
	include_once("../common.php");
	include_once(G5_PATH."/admin/head.php");
	$where="";
	if($category!=""){
		$where.=" and `category` like '%{$category}%'";
	}
	if($search!=""){
		$where.=" and `title` like '%{$search}%' or `en_title` like '%{$search}%'";
	}
	$total=sql_fetch("select count(*) as cnt from `gsw_product` where 1 {$where} order by `id` desc");
	if(!$page)
		$page=1;
	$total=$total['cnt'];
	$rows=12;
	$start=($page-1)*$rows;
	$total_page=ceil($total/$rows);
	$sql="select *,(select sum(number) from `gsw_sell` as s where p.id=s.product_id and s.status<>'-1') as sell from `gsw_product` as p where 1 {$where} order by `order` asc,`id` desc limit {$start},{$rows}";
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
<style type="text/css">
	.list02{display:block;width:100%;}
	.list02 > div ul{display:table;width:100%;border-right:1px solid #ddd;border-top:1px solid #ddd;}
	.list02 > div ul li{width:25%;box-sizing:border-box;float:left;transition: all .2s ease-in-out;border-left:1px solid #ddd;border-bottom:1px solid #ddd;background:#fff;}
	.list02 > div ul li > a{display:block;width:100%;height:100%;position:relative;}
	.list02 > div ul li > a > span{position:absolute;top:0;left:0;width:55px;height:55px;display:block;background:#66c1ce;color:#fff;font-size:20px;text-align:center;padding:15px 0;box-sizing:border-box;z-index:2;}
	.list02 > div ul li > a .img{width:100%;height:250px;overflow:hidden;}
	.list02 > div ul li > a .img > div{width:100%;height:100%;z-index:1;display:table;table-layout:fixed;}
	.list02 > div ul li > a .img > div > div{display:table-cell;width:100%;text-align:center;vertical-align:middle;}
	.list02 > div ul li > a .img > div > div img{width:auto;max-width:100%;max-height:120%;transition: all .2s ease-in-out;margin:0 auto;}
	.list02 > div ul li > a:hover .img img{ transform: scale(1.12); }
	.list02 > div ul li > a .txt{padding-top:20px;text-align:center;letter-spacing:-0.05em;height:103px;box-sizing:border-box;}
	.list02 > div ul li > a .txt h4{font-family:"Malgun Gothic","MalgunGothic","맑은고딕","Nanum Gothic";font-weight:normal;font-size:14px;overflow:hidden;text-overflow: ellipsis;white-space: nowrap;}
	.list02 > div ul li > a .txt h3{font-family:"Malgun Gothic","MalgunGothic","맑은고딕","Nanum Gothic";font-weight:normal;font-size:24px;color:#f54b4b;}
	.list02 > div ul li .btn_group{display:table;width:100%;}
	.list02 > div ul li .btn_group a{width:50%;float:left;display:inline-block;text-align:center;font-size:16px;height:40px;background:#aaa;box-sizing:border-box;padding:10px 0;}
	.list02 > div ul li .out{width:100%;height:100%;background-image:url("../img/mask.png");position:absolute;top:0;left:0;z-index:2;color:#fff;text-align:center;font-size:24px;}
	.list02 > div ul li .out div{display:table;width:100%;height:100%;}
	.list02 > div ul li .out div p{display:table-cell;vertical-align:middle;}
	@media all and (max-width: 1600px){
		.list02 > div ul li{width:33.3%;}
	}
	@media all and (max-width: 1300px){
		.list02 > div ul li > a .img{height:220px;}
	}
	@media all and (max-width: 768px){
		.list02 > div ul li{width:50%;}
	}
	@media all and (max-width: 556px){
		.list02 > div ul li > a .img{height:185px;}
	}
	@media all and (max-width: 480px){
		.list02 > div ul li > a .img{height:150px;}
	}
</style>
<!-- 본문 start -->
<div id="wrap">
	<section>
		<header id="admin-title">
			<h1>제품관리</h1>
			<hr />
		</header>
		<article>
			<form action="" method="get">
				<div class="grid_100" style="margin-bottom:30px">
					<div class="grid_20">
						<select name="category" class="adm-input01 grid_100" id="category">
							<option value="">카테고리 선택</option>
							<?php for($i=0;$i<count($cate);$i++){ ?>
							<option value="<?php echo $cate[$i]['cate']; ?>" <?php echo $cate[$i]['cate']==$category?"selected":""; ?>><?php echo $cate[$i]['cate']; ?></option>
							<?php } ?>
						</select>
					</div>
					<div class="grid_70"><input type="text" name="search" id="search" value="<?php echo $search; ?>" class="adm-input01 grid_100" placeholder="상품이름" /></div>
					<div class="grid_10"><input type="submit" class="grid_100 white lh30 btn" style="background:#666;border:none;" value="검색" /></div>
				</div>
			</form>
			<div class="total text-right" style="margin-bottom:10px;font-size:16px;">TOTAL <?php echo number_format($total); ?></div>
			<div class="list02">
				<div>
					<ul>
					<?php
						for($i=0;$i<count($list);$i++){
					?>
						<li>
							<a href="<?php echo G5_URL."/admin/product_view.php?&id=".$list[$i]['id']."page=".$page."&category=".$category; ?>">
								<?php if($list[$i]['out'] || ($list[$i]['number']-$list[$i]['sell'])<=0){ ?><div class="out"><div><p>품절</p></div></div><?php } ?>
								<div class="img"><div><div><img src="<?php echo G5_DATA_URL."/product/".$list[$i]['photo']; ?>" alt="<?php echo $list[$i]['title']; ?>" /></div></div></div>
								<div class="txt">
									<h4><?php echo $list[$i]['title']; ?></h4>
									<h3><?php echo number_format($list[$i]['price']); ?></h3>
									<p>남은 수량 - <?php echo number_format($list[$i]['number']-$list[$i]['sell']); ?>개</p>
								</div>
							</a>
							<div class="btn_group"><a href="<?php echo G5_URL."/admin/product_write.php?id=".$list[$i]['id']."&page=".$page."&category=".$category; ?>">수정</a> <a href="javascript:del_confirm('<?php echo G5_URL."/admin/product_delete.php?&id=".$list[$i]['id']; ?>');" class="white" style="background:#666;">삭제</a></div>
						</li>
					<?php
						}
						if(count($list)==0){
							echo "<li class='grid_100 text-center'><div style='padding:100px 0;'>목록이 없습니다</div></li>";
						}
					?>
					</ul>
				</div>
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
				<?php if($start_page!=1){?>
					<li class="prev"><a href="<?php echo G5_URL."/admin/product.php?page=".($start_page-1)."&category=".$category."&search=".$search; ?>">&lt;&lt;</a></li>
				<?php } ?>
				<?php if($page!=1){?>
					<li class="prev"><a href="<?php echo G5_URL."/admin/product.php?page=".($page-1)."&category=".$category."&search=".$search; ?>">&lt;</a></li>
				<?php } ?>
				<?php for($i=$start_page;$i<=$end_page;$i++){ ?>
					<li class="<?php echo $page==$i?"active":""; ?>"><a href="<?php echo G5_URL."/admin/product.php?page=".$i."&category=".$category."&search=".$search; ?>"><?php echo $i; ?></a></li>
				<?php } ?>
				<?php if($page<$total_page){?>
					<li class="next"><a href="<?php echo G5_URL."/admin/product.php?page=".($page+1)."&category=".$category."&search=".$search; ?>">&gt;</a></li>
				<?php } ?>
				<?php if($end_page<=$total_page){?>
					<li class="next"><a href="<?php echo G5_URL."/admin/product.php?page=".($end_page+1)."&category=".$category."&search=".$search; ?>">&gt;&gt;</a></li>
				<?php } ?>
				</ul>
			</div>
			<?php
			}
			?>
			<div class="text-right mt20">
				<a href="<?php echo G5_URL."/admin/product_write.php"; ?>" class="adm-btn01">추가하기</a>
			</div>
		</article>
	</section>
</div>
<script type="text/javascript">
	function del_confirm(url){
		if(confirm('삭제시 돌릴 수 없습니다.\n삭제하신 제품의 매출 내역이 삭제됩니다.\n삭제 전 해당 제품 구입자에게 수정/공지 해주시기 바랍니다.\n삭제하시겠습니까?')){
			location.href=url;
		}else{
			return false;
		}
	}
</script>
<?php
	include_once(G5_PATH."/admin/tail.php");
?>
