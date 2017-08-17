<?
	## 설정
	include_once "{$_REQUEST['S_DOCUMENT_ROOT']}{$S_SHOP_HOME}/conf/community/category/category.{$_REQUEST['b_code']}.info.php";
	$dirPath = "/upload/community/category/";
	foreach($CATEGORY_LIST as $key => $category):
		$image1		= $category['bc_image_1'];
		$image2		= $category['bc_image_2'];
		$bc_name	= $category['bc_name'];
		if($image2) { $image2 = " overImg='{$dirPath}{$image2}'"; }
		if($image1) { $bc_name = "<img src='{$dirPath}{$image1}'{$image2}/>"; }
?>
<a href="javascript:goCategoryMoveEvent('<?=$key?>')"><?=$bc_name?></a>
<?
	endforeach;
?>
