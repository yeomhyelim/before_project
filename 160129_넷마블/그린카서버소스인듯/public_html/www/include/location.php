<?
	if($strMenuType == "product") :
		// 상품 현재위치

		$strLocation = "<a href='./'>HOME</a>";
		
		if($strMode == "brandMain" || $strMode == "brandList") :
			if($S_SHOP_HOME == "linksday"):
			$strLocation .= " / <a href='./?menuType=product&mode=brandList&pr_no={$brandPR_NO}'>BRAND</a>";
			else:
			$strLocation .= " / <a href='./?menuType=product&mode=brandMain'>BRAND</a>";
			endif;
		endif;

		if($strMode == "brandList") :
			/* 브랜드 정보 */
			$intPR_NO			= $_POST["pr_no"]			? $_POST["pr_no"]			: $_REQUEST["pr_no"];
			$productMgr->setPR_NO($intPR_NO);
			$brandRow			= $productMgr->getProdBrandView($db);
			/* 브랜드 정보 */
			$strLocation .= " / <a href='./?menuType=product&mode=brandList&pr_no={$intPR_NO}'>{$brandRow['PR_NAME']}</a>";
		else:	

			if($strSearchHCodeName1) :
				$strLocation .= " / <a href='./?menuType={$strMenuType}&mode=list&page=1&lcate={$strSearchHCode1}&mcate=&scate=&fcate'>{$strSearchHCodeName1}</a>"; 
			endif;

			if($strSearchHCodeName2) :
				$strLocation .= " / <a href='./?menuType={$strMenuType}&mode=list&page=1&lcate={$strSearchHCode1}&mcate={$strSearchHCode2}&scate=&fcate'>{$strSearchHCodeName2}</a>"; 
			endif;

			if($strSearchHCodeName3) :
				$strLocation .= " / <a href='./?menuType={$strMenuType}&mode=list&page=1&lcate={$strSearchHCode1}&mcate={$strSearchHCode2}&scate={$strSearchHCode3}'>{$strSearchHCodeName3}</a>"; 
			endif;

			if($strSearchHCodeName4) :
				$strLocation .= " / <a href='./?menuType={$strMenuType}&mode=list&page=1&lcate={$strSearchHCode1}&mcate={$strSearchHCode2}&scate={$strSearchHCode3}&fcate={$strSearchHCode4}'>{$strSearchHCodeName4}</a>"; 
			endif;

		endif;
		/* 공유 카테고리 */
		if ($strMode == "view" && is_array($aryProdShareCateInfo)){
			/*for($j=0;$j<sizeof($aryProdShareCateInfo);$j++){
				$strProdShareHCode1 = SUBSTR($aryProdShareCateInfo[$j][P_CATE],0,3);
				$strProdShareHCode2 = SUBSTR($aryProdShareCateInfo[$j][P_CATE],3,3);
				$strProdShareHCode3 = SUBSTR($aryProdShareCateInfo[$j][P_CATE],6,3);
				$strProdShareHCode4 = SUBSTR($aryProdShareCateInfo[$j][P_CATE],9,3);
				
				//$strLocation .= "<br><a href='./'>HOME</a>";

				if ($strProdShareHCode1){
					$strLocation .= " / <a href='./?menuType={$strMenuType}&mode=list&page=1&lcate={$strProdShareHCode1}&mcate=&scate=&fcate='>".$S_ARY_CATE_NAME[$strProdShareHCode1]['CATE_NM']."</a>"; 
				}

				if ($strProdShareHCode2 && $strProdShareHCode2 != "000"){
					$strLocation .= " / <a href='./?menuType={$strMenuType}&mode=list&page=1&lcate={$strProdShareHCode1}&mcate={$strProdShareHCode2}&scate=&fcate='>".$S_ARY_CATE_NAME[$strProdShareHCode1.$strProdShareHCode2]['CATE_NM']."</a>"; 
				}
			
				if ($strProdShareHCode3 && $strProdShareHCode3 != "000"){
					$strLocation .= " / <a href='./?menuType={$strMenuType}&mode=list&page=1&lcate={$strProdShareHCode1}&mcate={$strProdShareHCode2}&scate={$strProdShareHCode3}&fcate='>".$S_ARY_CATE_NAME[$strProdShareHCode1.$strProdShareHCode2.$strProdShareHCode3]['CATE_NM']."</a>"; 
				}

				if ($strProdShareHCode4 && $strProdShareHCode4 != "000"){
					$strLocation .= " / <a href='./?menuType={$strMenuType}&mode=list&page=1&lcate={$strProdShareHCode1}&mcate={$strProdShareHCode2}&scate={$strProdShareHCode3}&fcate={$strProdShareHCode4}'>".$S_ARY_CATE_NAME[$strProdShareHCode1.$strProdShareHCode2.$strProdShareHCode3.$strProdShareHCode4]['CATE_NM']."</a>"; 
				}
				
				if ($j==0) break;
			}*/
		}

		echo $strLocation;		
	
	elseif($strMenuType == "board") :

		$strLocation = "<a href='./'>HOME</a>";

		if($strB_CODE):
			$strLocation .= " / <a href='./?menuType=board&mode=list&bCode={$aryBoardSet[0]['B_CODE']}'>{$aryBoardSet[0]['B_TITLE']}</a>";
		endif;

		echo $strLocation;	

	elseif($strMenuType == "mypage") :
		
		$strLocation = "<a href='./'>HOME</a>";

		if($strMode == "buyNonList"):
			$strLocation .= " / 비회원 주문관리";	
		elseif($stMode == "buyNonView"):
			$strLocation .= " / 비회원 주문상세";
		endif;

		echo $strLocation;	

	endif;


?>

