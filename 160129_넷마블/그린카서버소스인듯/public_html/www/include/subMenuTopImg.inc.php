<?

	$strSubMenuTopImg = "";
	if ($strMenuType == "product"){
		if ($S_PRODUCT_TOP_USE_OP != "N"){
			$strSubMenuTopImg = $S_PRODUCT_TOP_IMG;
			if ($S_PRODUCT_TOP_USE_OP == "C"){
				if ($S_PRODUCT_TOP_CAT_OP == "1"){
					$strSubMenuTopImg = $S_ARY_CATE_IMG[$strSearchHCode1]['TOP_IMG'];		
				} else if ($S_PRODUCT_TOP_CAT_OP == "2"){
					$strSubMenuTopImg = $S_ARY_CATE_IMG[$strSearchHCode1.$strSearchHCode2]['TOP_IMG'];
				} else if ($S_PRODUCT_TOP_CAT_OP == "2"){
					$strSubMenuTopImg = $S_ARY_CATE_IMG[$strSearchHCode1.$strSearchHCode2.$strSearchHCode3]['TOP_IMG'];
				} else if ($S_PRODUCT_TOP_CAT_OP == "4"){
					$strSubMenuTopImg = $S_ARY_CATE_IMG[$strSearchHCode1.$strSearchHCode2.$strSearchHCode3.$strSearchHCode4]['TOP_IMG'];
				}
			}
		}
		$strSubMenuTopImg = ($strSubMenuTopImg) ? "<div class=\"prodTopImageWrap\"><img src=\"".$strSubMenuTopImg."\"></div>":""; 
	} 


	/* 페이지별 TOP 이미지 출력 */
	$strTopUseOp		= sprintf("S_%s_TOP_USE_OP", strtoupper($strMenuType));
	$aryPageTopImg['A'] = sprintf("S_%s_TOP_IMG", strtoupper($strMenuType));
	$aryPageTopImg['C']	= sprintf("S_%s_%s_TOP_IMG", strtoupper($strMenuType), strtoupper($strMode));

	if($$strTopUseOp == "A" || $$strTopUseOp == "C") :
		if($$aryPageTopImg[$$strTopUseOp]) :
			echo sprintf("<img src=\"%s\">", $$aryPageTopImg[$$strTopUseOp]);
		endif;
	endif;
	/* 페이지별 TOP 이미지 출력 */
?>



<?=$strSubMenuTopImg?>
