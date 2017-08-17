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

		if($strCate3Mode == "T" || $strCate3Mode == "I"):
			$cateMgr->setCL_LNG($S_SITE_LNG);
			$cateMgr->setC_LEVEL(3);
			$aryCate3List = $cateMgr->getCateLevelAry($db);
		endif;

		if($strCate4Mode == "T" || $strCate4Mode == "I"):
			$cateMgr->setCL_LNG($S_SITE_LNG);
			$cateMgr->setC_LEVEL(4);

			if (!$strSearchHCode3) {
				
				if (!$cate1No){
					foreach($S_ARY_CATE1 as $no => $data):
						if($data['CODE'] == $cate1):
							$cate1No	= $no;
							break;
						endif;
					endforeach;
				}

				if (!$cate2No){
					foreach($S_ARY_CATE2[$cate1No] as $no => $data):
						if($data['CODE'] == $cate1.$cate2):
							$cate2No	= $no;
						endif;
					endforeach;
				}

				$cate3 = $S_ARY_CATE3[$cate1No][$cate2No][0][CODE];
			} else {
				$cate3 = $strSearchHCode1.$strSearchHCode2.$strSearchHCode3;
			}

			$cateMgr->setC_HCODE($cate3);
			$aryCate4List = $cateMgr->getCateLevelAry($db);
		endif;

		include "prodList.subCate.skin.html.php";
	endif;

?>

