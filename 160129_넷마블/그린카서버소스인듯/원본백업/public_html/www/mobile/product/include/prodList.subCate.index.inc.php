<?
	# 상품 리스트 / 메뉴 카테고리
	# prodList.subCate.index.inc.php
?>


<?
	$strUse			= $S_PRODUCT_SUB_CATE_USE;
	$strView		= $S_PRODUCT_SUB_CATE_VIEW;	
	$strCate1Mode	= $S_PRODUCT_CATE_L1_MODE;
	$strCate2Mode	= $S_PRODUCT_CATE_L2_MODE;
	$strCate3Mode	= $S_PRODUCT_CATE_L3_MODE;
	$strCate4Mode	= $S_PRODUCT_CATE_L4_MODE;


	if($strUse == "Y"):
		// 서브 카테고리 사용

		if($strCate1Mode == "T" || $strCate1Mode == "I"):
			$cateMgr->setCL_LNG($S_SITE_LNG);
			$cateMgr->setC_LEVEL(1);
			$aryCate1List = $cateMgr->getCateLevelAry($db);
		endif;

		if($strCate2Mode == "T" || $strCate2Mode == "I"):
			$cateMgr->setCL_LNG($S_SITE_LNG);
			$cateMgr->setC_LEVEL(2);
			$aryCate2List = $cateMgr->getCateLevelAry($db);
		endif;

		include "prodList.subCate.skin.html.php";
	endif;

?>

