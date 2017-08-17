<?
	/* 정의 */
	$strPCode			= $strP_CODE;
	$strShowType		= $S_PRODUCT_VIEW_IMAGE_SHOW_TYPE;
	$strViewImg			= $prodRow['PM_REAL_NAME'];
	$intVSizeW			= $S_PRODUCT_VIEW_ISW;
	$intVSizeH			= $S_PRODUCT_VIEW_ISH;
	$strOpenWinUse		= $S_PRODUCT_VIEW_IZOOM_USE;

	## 상세보기를 이미지가 아닌 동영상으로 보이게 하며 특정 카테고리에서만 동영상이 보이도록 처리
	if ($S_FIX_PROD_VIEW_MOVIE_FLAG == "Y" && !in_array(SUBSTR($prodRow['P_CATE'],0,3),$S_FIX_PROD_VIEW_MOVIE_CATE_NOT_LIST)){
		$productMgr->setPM_TYPE("movie1");
		$prodMovieRow = $productMgr->getProdImg($db);
		
		$strProdMovieUrl1 = $prodMovieRow[0]['PM_REAL_NAME'];
		
		include "prodView.MultyMovie.{$strShowType}.skin.html.php";
	}  else {
		

		if(in_array($strShowType, array("B"))) :
			// 다중이미지

			/* 정의 */
			$intMSizeW 			= $S_PRODUCT_IMG_MULTY_SIZE_W;
			$intMSizeH			= $S_PRODUCT_IMG_MULTY_SIZE_H;
			$intMListW 			= $S_PRODUCT_IMG_MULTY_VIEW_W;
			$intMListH			= $S_PRODUCT_IMG_MULTY_VIEW_H;


			/* 상품 호출 개수 */
			$intPageLine 		= $intMSizeW * $intMSizeH;

	// 2013.07.10 kim hee sung 모바일 이미지가 있는경우 버그 있음
	//		$productMgr->setP_CODE($strPCode);
	//		$productMgr->setPM_TYPE("view");
	//		$productMgr->setPageLine($intPageLine);
	//		$intMTotal	 		= $productMgr->getProdImg($db, "OP_COUNT");	
	//		$aryMResult 		= $productMgr->getProdImg($db, "OP_LIST");
	//		$productMgr->setPM_TYPE("large");
	//		$aryZResult			= $productMgr->getProdImg($db, "OP_ARYLIST");
			$param					= "";
			$param['P_CODE']		= $strPCode;
			$param['PM_TYPE_IN']	= "view";
			$intMTotal	 			= $productMgr->getProdImgListEx($db, "OP_COUNT", $param);	
			
			$param					= "";
			$param['P_CODE']		= $strPCode;
			$param['PM_TYPE_IN']	= "view";
			$param['LIMIT']			= "0, {$intPageLine}";
			$param['ORDER_BY']		= 'PI.PM_TYPE ASC';
			$aryMResult 			= $productMgr->getProdImgListEx($db, "OP_LIST", $param);

			$param					= "";
			$param['P_CODE']		= $strPCode;
			$param['PM_TYPE_IN']	= "large";
			$param['ORDER_BY']		= 'PI.PM_TYPE ASC';
			$aryZResult				= $productMgr->getProdImgListEx($db, "OP_ARYLIST", $param);

			$param					= "";
			$param['P_CODE']		= $strPCode;
			$param['PM_TYPE_IN']	= "movie";
			$param['ORDER_BY']		= 'PI.PM_TYPE ASC';
			$aryEResult				= $productMgr->getProdImgListEx($db, "OP_ARYLIST", $param);
			$strName				= "MultyImage";
			if($aryEResult):
				$strName		= "MultyMovie";
				$strViewImg		= $aryEResult['PM_REAL_NAME'];
			endif;

			// 스킨
			if($intMTotal == 0) :
				echo "<div class=\"noListWrap\">";
				echo $LNG_TRANS_CHAR["PS00001"]; //"등록된 상품이 없습니다.";	// 차후 페이지 제작
				echo "</div>";
			else :
				include "prodView.{$strName}.{$strShowType}.skin.html.php";
			endif;

		elseif(in_array($strShowType, array("A"))) :
			// 다중이미지 사용 - 상품 다중이미지 아이콘으로 표시

			include "prodView.MultyImage.{$strShowType}.skin.html.php";
		else:
			// 기본
			$productMgr->setP_CODE($strPCode);
			$productMgr->setPM_TYPE("large");
			$aryZResult			= $productMgr->getProdImg($db, "OP_SELECT");
			$strViewImg2		= $aryZResult['PM_REAL_NAME'];
			if(!$strViewImg2) { $strViewImg2 = $strViewImg; }

			/* 정의 */
			include "prodView.MultyImage.{$strShowType}.skin.html.php";

		endif;
	}

?>