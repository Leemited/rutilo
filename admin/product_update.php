<?php
	include_once("../common.php");
	$id=$_POST['id'];
	$page=$_POST['page'];
	$cate=$_POST['cate'];
	$sub_cate=$_POST['sub_cate'];
	$category=$_POST['category'];
	$sub_category=$_POST['sub_category'];
	$title=$_POST['title'];
	$en_title=$_POST['en_title'];
	$number=$_POST['number'];
	$show=$_POST['show']?"1":"0";
    $hospital=$_POST['hospital']?"2":"0";
    $persnal=$_POST['persnal']?"3":"0";
	$out=$_POST['out']?"1":"0";
	$price=$_POST['price'];
	$code=$_POST['code'];
	$sale=$_POST['sale'];
	$info=nl2br($_POST['info']);
	$weight=$_POST['weight'];
	$related=$_POST['related'];
	$order=(int)$_POST['order'];
	$content = substr(trim($_POST['content']),0,65536);
    $content = preg_replace("#[\\\]+$#", "", $content);
	$code_sale="";
	$related_product="";
	$catego="";
	for($i=0;$i<count($cate);$i++){
		if($i!=0)
			$catego.="|";
		$catego.=$cate[$i];
	}
	for($i=0;$i<count($code);$i++){
		if($i!=0)
			$code_sale.="||";
		$code_sale.=$code[$i]."|".$sale[$i];
	}
	for($i=0;$i<count($related);$i++){
		if($i!=0)
			$related_product.="|";
		$related_product.=$related[$i];
	}
	if($id)
		$data=sql_fetch("select * from `gsw_product` where id='".$id."'");
	$dir=G5_DATA_PATH."/product";
	@mkdir($dir, G5_DIR_PERMISSION);
	@chmod($dir, G5_DIR_PERMISSION);
	$filename1=time()."_product.jpg";
	$path1=$dir."/".$filename1;
	if($_FILES['photo']['tmp_name']){
		image_resize_update($_FILES['photo']['tmp_name'],$_FILES['photo']['name'], $path1, 2000);
		$photo=$filename1;
		$photo_sql=",`photo`='".$filename1."'";
		@unlink($dir."/".$data['photo']);
	}
	if($id){
		$sql="update `gsw_product` set `category`='{$catego}',`title`='{$title}',`en_title`='{$en_title}',`info`='{$info}',`number`='{$number}',`weight`='{$weight}',`order`='{$order}',`out`='{$out}',`show`='{$show}',`hospital`='{$hospital}',`persnal`='{$persnal}',`price`='{$price}',`code_sale`='{$code_sale}',`related_product`='{$related_product}',`content`='{$content}' {$photo_sql} where `id`='{$id}';";
	}else{
		$sql="insert into `gsw_product` (`category`,`title`,`en_title`,`info`,`number`,`out`,`show`,`hospital`,`persnal`,`price`,`weight`,`code_sale`,`related_product`,`photo`,`content`,`datetime`,`order`) VALUES ('{$catego}','{$title}','{$en_title}','{$info}','{$number}','{$out}','{$show}','{$hospital}','{$persnal}','{$price}','{$weight}','{$code_sale}','{$related_product}','{$photo}','{$content}',NOW(),'$order');";
	}
	sql_query($sql);
	alert('저장되었습니다.',G5_URL."/admin/product.php?page=".$page."&category=".$category."&sub_category=".$sub_category);
?>