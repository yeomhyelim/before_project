<?
	# 브랜드 상품 리스트 / 서브 카테고리
	# prodList.subCate.index.inc.php
?>


<?
	$strUse			= $S_BRAND_LIST_SUB_CATE_USE;
	$strView		= $S_BRAND_LIST_SUB_CATE_VIEW;	
	$strCate1Mode	= $S_BRAND_LIST_CATE_L1_MODE;
	$strCate2Mode	= $S_BRAND_LIST_CATE_L2_MODE;
	$strCate3Mode	= $S_BRAND_LIST_CATE_L3_MODE;
	$strCate4Mode	= $S_BRAND_LIST_CATE_L4_MODE;

	if($strUse == "Y"):
		// 서브 카테고리 사용
		if(is_array($S_ARY_CATE1)) :
			include "brandList.subCate.skin.html.php";
		endif;
	endif;

?>



