<?
	
	function makeProductPageFile()
	{
		global $db, $prodpageMgr;

		/* 상품리스트 설정값 호출 */
		$setingRow = $prodpageMgr->getProdpageList($db);

		$responseText .= "<?\n\n";
		
		while($aRow = mysql_fetch_array($setingRow))
		{
			$intPV_NO				= $aRow[PV_NO];
			$intPV_PAGE				= $aRow[PV_PAGE];
			$strPV_MODUL_TYPE		= $aRow[PV_MODUL_TYPE];
			$intPV_DESIGN_NO		= $aRow[PV_DESIGN_NO];
			$strPV_MODUL_NAME		= $aRow[PV_MODUL_NAME];
			$strPV_IMAGE_FILE		= $aRow[PV_IMAGE_FILE];
			$intPV_IMAGE_SIZE_W		= $aRow[PV_IMAGE_SIZE_W];
			$intPV_IMAGE_SIZE_H		= $aRow[PV_IMAGE_SIZE_H];
			$intPV_IMAGE_CNT_W		= $aRow[PV_IMAGE_CNT_W];
			$intPV_IMAGE_CNT_H		= $aRow[PV_IMAGE_CNT_H];
			$intPPV_MODUL_TEXT		= $aRow[PV_MODUL_TEXT];
			$strPV_LIST_CATE		= $aRow[PV_LIST_CATE];
			$intPV_VIEW_FUNCTION	= $aRow[PV_VIEW_FUNCTION];
			$strPV_USE				= $aRow[PV_USE];
			$intPV_ORDER			= $aRow[PV_ORDER];
			
			

			switch($intPV_PAGE){
				case "main":
					$responseText .= "	/**** 메인 ".strtoupper($strPV_MODUL_TYPE)."상품리스트 *********************/\n";
					$responseText .= "	\$D_PRODUCT_MAIN_".strtoupper($strPV_MODUL_TYPE)."_YN = '".$strPV_USE."';			//메인 ".strtoupper($strPV_MODUL_TYPE)."목록 사용여부\n\n";

					$responseText .= "	\$D_PRODUCT_MAIN_".strtoupper($strPV_MODUL_TYPE)."_IW = '".$intPV_IMAGE_SIZE_W."';			//메인 ".strtoupper($strPV_MODUL_TYPE)."상품 이미지 넓이\n";
					$responseText .= "	\$D_PRODUCT_MAIN_".strtoupper($strPV_MODUL_TYPE)."_IH = '".$intPV_IMAGE_SIZE_H."';			//메인 ".strtoupper($strPV_MODUL_TYPE)."상품 이미지 높이\n";
					$responseText .= "	\$D_PRODUCT_MAIN_".strtoupper($strPV_MODUL_TYPE)."_LW = '".$intPV_IMAGE_CNT_W."';			//메인 ".strtoupper($strPV_MODUL_TYPE)."상품 가로 상품수\n";
					$responseText .= "	\$D_PRODUCT_MAIN_".strtoupper($strPV_MODUL_TYPE)."_LH = '".$intPV_IMAGE_CNT_H."';			//메인 ".strtoupper($strPV_MODUL_TYPE)."상품 라인수\n\n\n";
				break;

				case "subpage":
					$responseText .= "	/**** 서브페이지 ".strtoupper($strPV_MODUL_TYPE)."상품리스트 *********************/\n";
					$responseText .= "	\$D_PRODUCT_MAIN_".strtoupper($strPV_MODUL_TYPE)."_YN = '".$strPV_USE."';			//메인 ".strtoupper($strPV_MODUL_TYPE)."목록 사용여부\n\n";

					$responseText .= "	\$D_PRODUCT_SUB_".strtoupper($strPV_MODUL_TYPE)."_IW = '".$intPV_IMAGE_SIZE_W."';			//메인 ".strtoupper($strPV_MODUL_TYPE)."상품 이미지 넓이\n";
					$responseText .= "	\$D_PRODUCT_SUB_".strtoupper($strPV_MODUL_TYPE)."_IH = '".$intPV_IMAGE_SIZE_H."';			//메인 ".strtoupper($strPV_MODUL_TYPE)."상품 이미지 높이\n";
					$responseText .= "	\$D_PRODUCT_SUB_".strtoupper($strPV_MODUL_TYPE)."_LW = '".$intPV_IMAGE_CNT_W."';			//메인 ".strtoupper($strPV_MODUL_TYPE)."상품 가로 상품수\n";
					$responseText .= "	\$D_PRODUCT_SUB_".strtoupper($strPV_MODUL_TYPE)."_LH = '".$intPV_IMAGE_CNT_H."';			//메인 ".strtoupper($strPV_MODUL_TYPE)."상품 라인수\n\n\n";
				break;

				case "prodlist":
					$responseText .= "	/**** 상품리스트 **********************/\n";

					$responseText .= "	\$D_PRODUCT_LIST_DESIGN = '".$strPV_MODUL_TYPE."';				//상품목록 디자인\n";
					$responseText .= "	\$D_PRODUCT_LIST_FUNCTION = '".$intPV_MODUL_FUNCTION."';				//이미지보기 기능\n";
					$responseText .= "	\$D_PRODUCT_LIST_CATE = '".$strPV_LIST_CATE."';				//서브 카테고리 기능\n\n";

					$responseText .= "	\$D_PRODUCT_LIST_IW = '".$intPV_IMAGE_SIZE_W."';			//상품목록 이미지 넓이\n";
					$responseText .= "	\$D_PRODUCT_LIST_IH = '".$intPV_IMAGE_SIZE_H."';			//상품목록 이미지 높이\n";
					$responseText .= "	\$D_PRODUCT_LIST_LW = '".$intPV_IMAGE_CNT_W."';			//상품목록 가로 상품수\n";
					$responseText .= "	\$D_PRODUCT_LIST_LH = '".$intPV_IMAGE_CNT_H."';			//상품목록 라인수\n\n\n";
				break;

				case "prodview":
					$responseText .= "	/**** 상품상세보기 **********************/\n";

					$responseText .= "	\$D_PRODUCT_VIEW_DESIGN = '".$strPV_MODUL_TYPE."';				//상품목록 디자인\n";
					$responseText .= "	\$D_PRODUCT_VIEW_FUNCTION = '".$intPV_MODUL_FUNCTION."';				//이미지보기 기능\n";
					$responseText .= "	\$D_PRODUCT_LIST_CATE = '".$strPV_LIST_CATE."';				//서브 카테고리 기능\n\n";

					$responseText .= "	\$D_PRODUCT_VIEW_IW = '".$intPV_IMAGE_SIZE_W."';			//상품상세 이미지 넓이\n";
					$responseText .= "	\$D_PRODUCT_VIEW_IH = '".$intPV_IMAGE_SIZE_H."';			//상품상세 이미지 높이\n";
					$responseText .= "	\$D_PRODUCT_VIEW_LW = '".$intPV_IMAGE_CNT_W."';			//상품상세 가로 상품수\n";
					$responseText .= "	\$D_PRODUCT_VIEW_LH = '".$intPV_IMAGE_CNT_H."';			//상품상세 라인수\n\n\n";
				break;

			}//switch
			

		} // while

		$responseText .= "?>";


		/* make the file */
		$file = "../conf/layout.inc.php";
		@chmod($file,0707);
		$fw = fopen($file, "w");
		fwrite($fw, $responseText);	
		fclose($fw);
		/* 파일 생성 */			
		
	}
	?>