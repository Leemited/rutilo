<?php
	include_once("../common.php");
	include_once(G5_EDITOR_LIB);
	include_once(G5_PATH."/admin/head.php");
	if($id){
		$view=sql_fetch("select * from `gsw_product` where id='".$id."'");
	}
	$sql="select * from `gsw_category` order by `od` asc";
	$query=sql_query($sql);
	while($data=sql_fetch_array($query)){
		$cate[]=$data;
	}
	$sql="select * from `gsw_sub_category` order by `od` asc";
	$query=sql_query($sql);
	while($data=sql_fetch_array($query)){
		$cate2[]=$data;
	}
	$sql="select * from `gsw_code` order by `id` desc";
	$query=sql_query($sql);
	while($data=sql_fetch_array($query)){
		$code[]=$data;
	}
	$sql="select * from `gsw_product` order by `id` desc";
	$query=sql_query($sql);
	while($data=sql_fetch_array($query)){
		$prod[]=$data;
	}
	$view['code_sale_array']=explode("||",$view['code_sale']);
	for($i=0;$i<count($view['code_sale_array']);$i++){
		$view['code_sale_array'][$i]=explode("|",$view['code_sale_array'][$i]);
	}
	$view['cate_array']=explode("|",$view['category']);
?>
<style type="text/css">
	.sound_only,.cke_sc{display:none;}
</style>
<!-- 본문 start -->
<div id="wrap">
	<section>
		<header id="admin-title">
			<h1>제품관리</h1>
			<hr />
		</header>
		<article id="admin_academy_write">
			<div class="adm-table02">
				<table>
					<tr>
						<th>제품명 *</th>
						<td>
							<?php echo $view['title']; ?>
						</td>
					</tr>
					<tr>
						<th>영문명 *</th>
						<td>
							<?php echo $view['en_title']; ?>
						</td>
					</tr>
					<tr>
						<th>대분류 *</th>
						<td>
							<?php
							if($view['category']){
								for($i=0;$i<count($view['cate_array']);$i++){
							?>
							<div><?php echo $view['cate_array'][$i]; ?></div>
							<?php
								}
							}
							?>
						</td>
					</tr>
					<tr>
						<th>노출 순서 *</th>
						<td>
							<?php echo $view['order']; ?>
						</td>
					</tr>
					<tr>
						<th>정보 *</th>
						<td>
							<?php echo $view['info']; ?>
						</td>
					</tr>
					<tr>
						<th>개수 *</th>
						<td>
							<?php echo number_format($view['number']); ?>
						</td>
					</tr>
					<tr>
						<th>리스트 노출</th>
						<td>
							<?php echo $view['show']!=""&&$view['show']==1?"노출":"숨기기"; ?>
						</td>
					</tr>
					<tr>
						<th>제품분류 *</th>
						<td>
							<?php echo $view['hospital']!=""&&$view['hospital']==2?"병원용":"일반용"; ?>
						</td>
					</tr>
					<tr>
						<th>품절</th>
						<td>
							<?php echo $view['out']!=""&&$view['out']==0?"-":"품절"; ?>
						</td>
					</tr>
					<tr>
						<th>사진 *</th>
						<td>
							<img src="<?php echo G5_DATA_URL."/product/".$view['photo']; ?>" alt="<?php echo $view['title']; ?>" />
						</td>
					</tr>
					<tr>
						<th>소비자가 *</th>
						<td>
							<?php echo number_format($view['price'],2); ?>
						</td>
					</tr>
					<tr>
						<th>무게 *</th>
						<td>
							<?php echo number_format($view['weight'],2); ?>kg
						</td>
					</tr>
					<tr>
						<th>코드별 할인율</th>
						<td>
							<?php
							if($view['code_sale']){
								for($i=0;$i<count($view['code_sale_array']);$i++){
							?>
							<div>
								<?php for($j=0;$j<count($code);$j++){ ?>
								<?php echo $code[$j]['id']==$view['code_sale_array'][$i][0]?$code[$j]['code']:""; ?> - 
								<?php } ?>
								<?php echo $view['code_sale_array'][$i][1]; ?>%
							</div>
							<?php
								}
							}
							?>
						</td>
					</tr>
					<tr>
						<th>관련상품</th>
						<td>
							<?php
							if($view['related_product']){
								for($i=0;$i<count($view['related_product_array']);$i++){
							?>
							<div><?php echo $code[$j]['id']==$view['related_product_array'][$i]?$prod[$j]['title']:""; ?></div>
							<?php
								}
							}
							?>
						</td>
					</tr>
					<tr>
						<th>상세정보</th>
						<td>
							<?php echo $view['content']; ?>
						</td>
					</tr>
				</table>
			</div>
			<div class="text-center mt20">
				<a href="<?php echo G5_URL."/admin/product.php?page=".$page."&category=".$category."&sub_category=".$sub_category; ?>" class="adm-btn01 bg_gray" >목록</a>
				<a href="<?php echo G5_URL."/admin/product_write.php?id=".$id."&page=".$page."&category=".$category."&sub_category=".$sub_category; ?>" class="adm-btn01" >수정</a>
			</div>
		</article>
	</section>
</div>
<?php
	include_once(G5_PATH."/admin/tail.php");
?>
