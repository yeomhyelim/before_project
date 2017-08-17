<?
	/* 정의 */
	$strPCode			= $strP_CODE;
	$strShowType		= $S_PRODUCT_VIEW_IMAGE_SHOW_TYPE;
	$strViewImg			= $prodRow['PM_REAL_NAME'];
	$intVSizeW			= $S_PRODUCT_VIEW_ISW;
	$intVSizeH			= $S_PRODUCT_VIEW_ISH;
	$strOpenWinUse		= $S_PRODUCT_VIEW_IZOOM_USE;


	if(in_array($strShowType, array("B"))) :
		// 다중이미지

		/* 정의 */
		$intMSizeW 			= $S_PRODUCT_IMG_MULTY_SIZE_W;
		$intMSizeH			= $S_PRODUCT_IMG_MULTY_SIZE_H;
		$intMListW 			= $S_PRODUCT_IMG_MULTY_VIEW_W;
		$intMListH			= $S_PRODUCT_IMG_MULTY_VIEW_H;


		/* 상품 호출 개수 */
		$intPageLine 		= $intMSizeW * $intMSizeH;

		$productMgr->setP_CODE($strPCode);
		$productMgr->setPM_TYPE("view");
		$productMgr->setPageLine($intPageLine);
		$intMTotal	 		= $productMgr->getProdImg($db, "OP_COUNT");	
		$aryMResult 		= $productMgr->getProdImg($db, "OP_LIST");
		
		// 스킨
		if($intMTotal == 0) :
			echo "<div class=\"noListWrap\">";
			echo "등록된 상품이 없습니다.";	// 차후 페이지 제작
			echo "</div>";
		else :
			include "prodView.MultyImage.{$strShowType}.skin.html.php";
		endif;

	elseif(in_array($strShowType, array("A"))) :
		// 다중이미지 사용 - 상품 다중이미지 아이콘으로 표시

		include "prodView.MultyImage.{$strShowType}.skin.html.php";
	else:
		// 기본
		
		/* 정의 */		
		echo "<img src='$strViewImg' width='$intVSizeW' height='$intVSizeH'/>";

	endif;

?>