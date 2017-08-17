<?
	## 작성일 : 2013.06.13
	## 작성자 : kim hee sung
	## 내  용 : 소스 정리

	## STEP 1.
	## 사용 유무 체크
	$mainMenuUse = "Y";
	if(!is_array($S_ARY_CATE1)) { $mainMenuUse = "N"; }


	## STEP 2.
	## 카테고리 실행
	if($mainMenuUse == "Y"):

		if($MAIN_MENU_PRODUCT_COUNT_USE == "Y"):
			// 카테고리별 상품 개수 사용 하는 경우.
			if (!$productMgr){
				require_once MALL_CONF_LIB."ProductMgr.php";
				$productMgr		= new ProductMgr();
			}
			$param			= "";
			$aryCateTotal	= $productMgr->getProdTotalGroupbyCateEx($db, "OP_ARYLIST", $param);
		endif;
		echo "<ul class=\"cateList\">";

		foreach($S_ARY_CATE1 as $key => $cate1):

			$menu		= "";
			$cateTag	= "";

			if($cate1['VIEW'] == "N") { continue; }

			$menu = $cate1['NAME'];

// 2013.08.15 kim hee sung 모바일 모드에서는 이미지 사용 안함.(이사님 요청)
//			if($cate1['IMG1']):
//				$menu		= "<img src='{$cate1['IMG1']}'/>";
//			endif;
//
//			if($cate1['IMG1'] && $cate1['IMG2']):
//				$menu		= "<img src='{$cate1['IMG1']}' overImg='{$cate1['IMG2']}'/>";
//			endif;
			
			if($MAIN_MENU_PRODUCT_COUNT_USE == "Y"):
				// 카테고리별 상품 개수 사용 하는 경우.
				$cateTag	= "<span class='cntProd'>{$aryCateTotal[$cate1['CODE']]}</span>";
			endif;

			echo "<li><a href='./?menuType=product&mode=list&lcate={$cate1['CODE']}' class='mn{$key}'>{$menu}{$cateTag}</a></li>";
		endforeach;

		echo "</ul>";

	endif;
?>
