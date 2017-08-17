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
			require_once MALL_CONF_LIB."ProductMgr.php";
			$productMgr		= new ProductMgr();
			$param			= "";
			$aryCateTotal	= $productMgr->getProdTotalGroupbyCateEx($db, "OP_ARYLIST", $param);
		endif;
		
		foreach($S_ARY_CATE1 as $key => $cate1):

			$menu		= "";
			$cateTag	= "";

			if($cate1['VIEW'] == "N") { continue; }
			if($cate1['SHARE'] == "Y") { continue; }

			$menu = $cate1['NAME'];

			if($cate1['IMG1']):
				$menu		= "<img src='{$cate1['IMG1']}'/>";
			endif;

			if($cate1['IMG1'] && $cate1['IMG2']):
				$menu		= "<img src='{$cate1['IMG1']}' overImg='{$cate1['IMG2']}'/>";
			endif;
			
//			if($MAIN_MENU_PRODUCT_COUNT_USE == "Y"):
//				// 카테고리별 상품 개수 사용 하는 경우.
//				$cateTag	= "<span class='cntProd'>{$aryCateTotal[$cate1['CODE']]}</span>";
//			endif;

			echo "<a href='./?menuType=product&mode=list&lcate={$cate1['CODE']}' class='mn{$key}'>{$menu}{$cateTag}</a>";

		endforeach;

	endif;

?>





<?
// <a href="" class='mn1'>rkskek<span class="cntProd"></span></a>
// 2013.06.13 소스 정리
//	if (is_array($S_ARY_CATE1)){
//		for($intTopMnNo = 0; $intTopMnNo<sizeof($S_ARY_CATE1); $intTopMnNo++){
//			if($S_ARY_CATE1[$intTopMnNo]['VIEW'] == "N") { continue; }
//			$strTopMenuMouseOver = $strTopMenuMouseOut = "";
//
//			if ($S_ARY_CATE1[$intTopMnNo][IMG2]){
//				$strTopMenuMouseOver = "onmouseover=\"cateMouseOverOut(this,'".$S_ARY_CATE1[$intTopMnNo][IMG2]."')\"";
//				$strTopMenuMouseOut = "onmouseout=\"cateMouseOverOut(this,'".$S_ARY_CATE1[$intTopMnNo][IMG1]."')\"";
//			}
//
//			if ($S_ARY_CATE1[$intTopMnNo][IMG1]){
//				$strTopMenu  = "<img src=\"".$S_ARY_CATE1[$intTopMnNo][IMG1]."\" "; 
//				$strTopMenu .= $strTopMenuMouseOver." ".$strTopMenuMouseOut.">";
//			} else {
//				$strTopMenu = $S_ARY_CATE1[$intTopMnNo][NAME];
//			}
//
//			echo "<a href=\"./?menuType=product&mode=list&lcate=".$S_ARY_CATE1[$intTopMnNo][CODE];			
//			echo "\" class=\"mn1\">".$strTopMenu."</a>";
//		}
//	}


?>