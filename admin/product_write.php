<?php
	include_once("../common.php");
	include_once(G5_EDITOR_LIB);
	include_once(G5_PATH."/admin/head.php");
	if($id){
		$write=sql_fetch("select * from `gsw_product` where id='".$id."'");
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
	$sql="select * from `gsw_product` where `id`<>'{$id}' order by `id` desc";
	$query=sql_query($sql);
	while($data=sql_fetch_array($query)){
		$prod[]=$data;
	}
	$editor_html = editor_html('content', $write['content'], 1);
	$editor_js = '';
	$editor_js .= get_editor_js('content', 1);
	$editor_js .= chk_editor_js('content', 1);
	$write['code_sale_array']=explode("||",$write['code_sale']);
	$write['related_product_array']=explode("|",$write['related_product']);
	$write['category_arr']=explode("|",$write['category']);
	for($i=0;$i<count($write['code_sale_array']);$i++){
		$write['code_sale_array'][$i]=explode("|",$write['code_sale_array'][$i]);
	}
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
			<form action="<?php echo G5_URL."/admin/product_update.php"; ?>" onsubmit="return product_write_form(this);" name="product_form" id="product_form" method="post" enctype="multipart/form-data" autocomplete="off">
				<input type="hidden" name="id" value="<?php echo $id; ?>" />
				<input type="hidden" name="page" value="<?php echo $page; ?>" />
				<input type="hidden" name="category" value="<?php echo $category; ?>" />
				<input type="hidden" name="sub_category" value="<?php echo $sub_category; ?>" />
				<div class="adm-table02">
					<table>
						<tr>
							<th>제품명 *</th>
							<td>
								<input type="text" name="title" required id="title" class="adm-input01 grid_100" value="<?php echo $write['title']; ?>" />
							</td>
						</tr>
						<tr>
							<th>영문명 *</th>
							<td>
								<input type="text" name="en_title" required id="en_title" class="adm-input01 grid_100" value="<?php echo $write['en_title']; ?>" />
							</td>
						</tr>
						<tr>
							<th>노출 순서 *</th>
							<td>
								<input type="text" name="order" required id="order" class="adm-input01 grid_100" value="<?php echo $write['order']?$write['order']:"0"; ?>" />
								<p>숫자가 작을수록 앞에 노출됩니다. 숫자 -2147483648에서 214748364까지 입력 하실수 있습니다.</p>
							</td>
						</tr>
						<tr>
							<th>대분류1 *</th>
							<td>
								<div class="cate_div">
								<?php
								if($write['category']){
									for($i=0;$i<count($write['category_arr']);$i++){
										if($i==0)
											$required="required";
								?>
								<select name="cate[]" <?php echo $required; ?> class="adm-input01 grid_100">
									<option value="">선택</option>
									<?php for($j=0;$j<count($cate);$j++){ ?>
									<option value="<?php echo $cate[$j]['cate']; ?>" <?php echo $cate[$j]['cate']==$write['category_arr'][$i]?"selected":""; ?>><?php echo $cate[$j]['cate']; ?></option>
									<?php } ?>
								</select>
								<?php
									}
								}else{
								?>
								<select name="cate[]" required class="adm-input01 grid_100">
									<option value="">선택</option>
									<?php for($j=0;$j<count($cate);$j++){ ?>
									<option value="<?php echo $cate[$j]['cate']; ?>" <?php echo $cate[$j]['cate']==$write['category']?"selected":""; ?>><?php echo $cate[$j]['cate']; ?></option>
									<?php } ?>
								</select>
								<?php } ?>
								</div>
								<div class="text-right small_btn_group">
									<a href="javascript:cate_add();" style="width:50px;margin-top:3px;" class="bg_gray white btn lh30">추가</a>
									<a href="javascript:cate_del();" style="width:50px;margin-top:3px;" class="bg_gray white btn lh30">삭제</a>
								</div>
							</td>
						</tr>
						<tr>
							<th>정보 *</th>
							<td>
								<textarea name="info" id="info" cols="30" rows="10" class="adm-input01 grid_100" style="height:100px;" required><?php echo strip_tags($write['info']); ?></textarea>
							</td>
						</tr>
						<tr>
                             <th>제품 분류 *</th>
						    <td>
						    <label for="hospital"><input type="checkbox" name="hospital" id="hospital" value="2" <?php echo $write['hospital']!=""&&$write['hospital']==0?"":"checked"; ?> /> 병원용</label>
						    <label for="persnal"><input type="checkbox" name="persnal" id="persnal" value="3" <?php echo $write['persnal']!=""&&$write['persnal']==0?"":"checked"; ?> /> 일반용</label></td>
						</tr>
						<tr>
							<th>개수 *</th>
							<td>
								<input type="text" name="number" required id="number" class="adm-input01 grid_100" value="<?php echo $write['number']; ?>" onkeyup="return number_only(this);" />
							</td>
						</tr>
						<tr>
							<th>리스트 노출</th>
							<td>
								<label for="show"><input type="checkbox" name="show" id="show" value="1" <?php echo $write['show']!=""&&$write['show']==0?"":"checked"; ?> /> 보이기</label>
							</td>
						</tr>
						<tr>
							<th>품절</th>
							<td>
								<label for="out"><input type="checkbox" name="out" id="out" value="1" <?php echo $write['out']!=""&&$write['out']==1?"checked":""; ?> /> 품절</label>
							</td>
						</tr>
						<tr>
							<th>사진 *</th>
							<td>
								<input type="file" name="photo" id="photo" <?php echo $write['id']?"":"required"; ?> />
							</td>
						</tr>
						<tr>
							<th>소비자가 *</th>
							<td>
								<input type="text" name="price" required id="price" class="adm-input01 grid_100" value="<?php echo $write['price']; ?>" onkeyup="return number_only(this);" />
							</td>
						</tr>
						<tr>
							<th>무게 *</th>
							<td>
								<input type="text" name="weight" required id="weight" class="adm-input01 grid_100" value="<?php echo $write['weight']; ?>" placeholder="kg" onkeyup="return float_only(this);" />
							</td>
						</tr>
						<tr>
							<th>코드별 할인율</th>
							<td>
								<div class="code_sale_div">
									<?php
									if($write['code_sale']){
										for($i=0;$i<count($write['code_sale_array']);$i++){
									?>
									<div class="code_sale">
										<select name="code[]" id="code[]" class="adm-input01 grid_20">
											<option value="">선택</option>
											<?php for($j=0;$j<count($code);$j++){ ?>
											<option value="<?php echo $code[$j]['id']; ?>" <?php echo $code[$j]['id']==$write['code_sale_array'][$i][0]?"selected":""; ?>><?php echo $code[$j]['code']; ?></option>
											<?php } ?>
										</select>
										<input type="text" name="sale[]" id="sale[]" class="adm-input01 grid_80" maxlength="2" onkeyup="return number_only(this);" value="<?php echo $write['code_sale_array'][$i][1]; ?>" />
									</div>
									<?php
										}
									}else{
									?>
									<div class="code_sale">
										<select name="code[]" id="code[]" class="adm-input01 grid_20">
											<option value="">선택</option>
											<?php for($j=0;$j<count($code);$j++){ ?>
											<option value="<?php echo $code[$j]['id']; ?>"><?php echo $code[$j]['code']; ?></option>
											<?php } ?>
										</select>
										<input type="text" name="sale[]" id="sale[]" class="adm-input01 grid_80" maxlength="2" onkeyup="return number_only(this);" />
									</div>
									<?php } ?>
								</div>
								<div class="text-right small_btn_group">
									<a href="javascript:code_sale_add();" style="width:50px;margin-top:3px;" class="bg_gray white btn lh30">추가</a>
									<a href="javascript:code_sale_del();" style="width:50px;margin-top:3px;" class="bg_gray white btn lh30">삭제</a>
								</div>
							</td>
						</tr>
						<tr>
							<th>관련상품</th>
							<td>
								<div class="related_product">
									<?php
									if($write['related_product']){
										for($i=0;$i<count($write['related_product_array']);$i++){
									?>
									<select name="related[]" id="related[]" class="adm-input01 grid_100">
										<option value="">선택</option>
										<?php for($j=0;$j<count($prod);$j++){ ?>
										<option value="<?php echo $prod[$j]['id']; ?>" <?php echo $prod[$j]['id']==$write['related_product_array'][$i]?"selected":""; ?>><?php echo $prod[$j]['title']; ?></option>
										<?php } ?>
									</select>
									<?php
										}
									}else{
									?>
									<select name="related[]" id="related[]" class="adm-input01 grid_100">
										<option value="">선택</option>
										<?php for($j=0;$j<count($prod);$j++){ ?>
										<option value="<?php echo $prod[$j]['id']; ?>"><?php echo $prod[$j]['title']; ?></option>
										<?php } ?>
									</select>
									<?php } ?>
								</div>
								<div class="text-right small_btn_group">
									<a href="javascript:related_product_add();" style="width:50px;margin-top:3px;" class="bg_gray white btn lh30">추가</a>
									<a href="javascript:related_product_del();" style="width:50px;margin-top:3px;" class="bg_gray white btn lh30">삭제</a>
								</div>
							</td>
						</tr>
						<tr>
							<th>상세정보</th>
							<td style="background:#fff;padding:0;">
								<?php echo $editor_html; ?>
							</td>
						</tr>
						<tr>
							<th>* 영상올리는법</th>
							<td>
								스마트에디터의 하단 html 버튼을 누른후 아래 코드에 유튜브 소스 코드를 추가하여 붙여넣기하여 동영상 적용<br>
								<?php 
								echo "&lt;style&gt;<br>.embed-container { position: relative; padding-bottom: 56.25%; height: 0; overflow: hidden; max-width: 100%; height: auto; }<br>.embed-container iframe,.embed-container object,.embed-container embed { position: absolute; top: 0; left: 0; width: 100%; height: 100%; }<br>	&lt;/style&gt;<br>&lt;div class='embed-container'&gt;<br>유튜브 소스 코드<br>&lt;/div&gt;";
								?>
							</td>
						</tr>
					</table>
				</div>
				<div class="text-center mt20">
					<input type="submit" id="btn_submit" value="확인" class="adm-btn01" />
				</div>
			</form>
		</article>
	</section>
</div>
<script type="text/javascript">
	function product_write_form(f){
		<?php echo $editor_js;  ?>
		document.getElementById("btn_submit").disabled = "disabled";
		return true;
	}
	function cate_chage(){
		var cate=$("#cate").val();
		var len=$("#sub_cate option").length;
		for(i=1;i<len;i++){
			var data_cate=$("#sub_cate option").eq(i).attr("data-cate");
			if(data_cate!=cate){
				$("#sub_cate option").eq(i).hide();
			}else{
				$("#sub_cate option").eq(i).show();
			}
		}
	}
	function code_sale_add(){
		var div=$(".code_sale_div");
		var day=$(".code_sale_div > div").length;
		div.find("div:last").clone().appendTo(div);
	}
	function code_sale_del(){
		var div=$(".code_sale_div");
		var len=$(".code_sale_div > div").length;
		if(len<=1){
			alert("더이상 삭제하실수 없습니다.");
		}else{
			div.find('div:last').remove();
		}
	}
	function related_product_add(){
		var div=$(".related_product");
		var day=$(".related_product > select").length;
		div.find("select:last").clone().appendTo(div);
	}
	function related_product_del(){
		var div=$(".related_product");
		var len=$(".related_product > select").length;
		if(len<=1){
			alert("더이상 삭제하실수 없습니다.");
		}else{
			div.find('select:last').remove();
		}
	}
	function cate_add(){
		var div=$(".cate_div");
		var day=$(".cate_div > select").length;
		div.find("select:last").clone().appendTo(div);
	}
	function cate_del(){
		var div=$(".cate_div");
		var len=$(".cate_div > select").length;
		if(len<=1){
			alert("더이상 삭제하실수 없습니다.");
		}else{
			div.find('select:last').remove();
		}
	}
</script>
<?php
	include_once(G5_PATH."/admin/tail.php");
?>
