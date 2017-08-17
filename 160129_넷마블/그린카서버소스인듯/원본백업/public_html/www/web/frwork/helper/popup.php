<?
	require_once MALL_CONF_LIB."CateMgr.php";
	require_once MALL_CONF_LIB."ProductMgr.php";
	require_once MALL_CONF_LIB."OrderMgr.php";
	require_once MALL_CONF_LIB."MemberMgr.php";
	require_once MALL_CONF_LIB."SiteMgr.php";

	require_once MALL_CONF_LIB."ShopMgr.php";

	require_once $S_DOCUMENT_ROOT.$S_SHOP_HOME."/conf/site_skin_product.conf.inc.php";
	require_once $S_DOCUMENT_ROOT.$S_SHOP_HOME."/conf/product.inc.php";
	require_once $S_DOCUMENT_ROOT.$S_SHOP_HOME."/conf/order.inc.php";

	/*상품함수관련*/
	require_once MALL_PROD_FUNC;

	if(is_file("{$S_DOCUMENT_ROOT}{$S_SHOP_HOME}/conf/shop.manual.inc.php")):
		require_once "{$S_DOCUMENT_ROOT}{$S_SHOP_HOME}/conf/shop.manual.inc.php";
	endif;

	$cateMgr		= new CateMgr();
	$productMgr		= new ProductMgr();
	$orderMgr		= new OrderMgr();
	$memberMgr		= new MemberMgr();
	$siteMgr		= new SiteMgr();

	$shopMgr		= new ShopMgr();


	$strImageSrc				= $_POST["imageSrc"]			? $_POST["imageSrc"]			: $_REQUEST["imageSrc"];


	$productMgr->setP_LNG($S_SITE_LNG);
	$cateMgr->setCL_LNG($S_SITE_LNG);

	switch ($strMode)
	{
		case "paperWrite":

		break;

		case "list":
		case "search":
		

			 /*원산지*/
			$productMgr->setColumn("P_ORIGIN");
			$aryProductOrigin = $productMgr->getProductColGroupList($db);

			$aryPriceFilter = array('EXW','FOB');

			$cateMgr->setC_LEVEL(1);
			$aryCategorys1 = $cateMgr->getCateLevelAry($db);
			for($i = 0; $i < sizeof($aryCategorys1); $i++){
				$aryCateNames1[$aryCategorys1[$i][CATE_CODE]] = $aryCategorys1[$i][CATE_NAME];
			}

			$cateMgr->setC_LEVEL(2);
			$aryCategorys2 = $cateMgr->getCateLevelAry($db);
			for($i = 0; $i < sizeof($aryCategorys2); $i++){
				$aryCateNames2[$aryCategorys2[$i][CATE_CODE]] = $aryCategorys2[$i][CATE_NAME];
			}

			$productMgr->setSearchHCode1($strSearchHCode1);
			$productMgr->setSearchHCode2($strSearchHCode2);
			$productMgr->setSearchHCode3($strSearchHCode3);
			$productMgr->setSearchHCode4($strSearchHCode4);
			$productMgr->setSearchProdShare($strSearchProdShare);

			$productMgr->setSearchField($strSearchField);
			$productMgr->setSearchKey($strSearchKey);

			if ($strDevice == "m") $productMgr->setSearchMobileView("Y");
			else $productMgr->setSearchWebView("Y");

			//$productMgr->setSearchWebView("Y");
			$productMgr->setSearchPriceView("Y");
			$productMgr->setSearchSort($strSearchSort);
			$productMgr->setSearchIcon1($strSearchIcon1);
			$productMgr->setSearchIcon2($strSearchIcon2);
			$productMgr->setSearchIcon3($strSearchIcon3);
			$productMgr->setSearchIcon4($strSearchIcon4);
			$productMgr->setSearchIcon5($strSearchIcon5);
			$productMgr->setSearchIcon6($strSearchIcon6);
			$productMgr->setSearchIcon7($strSearchIcon7);
			$productMgr->setSearchIcon8($strSearchIcon8);
			$productMgr->setSearchIcon9($strSearchIcon9);
			$productMgr->setSearchIcon10($strSearchIcon10);

			$productMgr->setSearchColor($strSearchColor);
			$productMgr->setSearchSize($strSearchSize);

			$productMgr->setSearchStartPrice(getPriceToCur($strSearchStartPrice));
			$productMgr->setSearchEndPrice(getPriceToCur($strSearchEndPrice));

			$productMgr->setSearchListIcon($strSearchListIcon);
			


			$arySearchLCate = $productMgr->searchVarCheck('searchLCate',$aryCategorys);

			$arySearchOrigin = $productMgr->searchVarCheck('searchOrigin',$aryProductOrigin);

			$arySearchType = $productMgr->searchVarCheck('searchType',$aryType);

			$arySearchPriceFilter = $productMgr->searchVarCheck('searchPriceFilter',$aryPriceFilter);

			$arySearchCreditGrade = $productMgr->searchVarCheck('searchCreditGrade',$aryCreditGradeImg);

			$arySearchSaleGrade = $productMgr->searchVarCheck('searchSaleGrade',$arySaleGradeImg);

			$arySearchLocusGrade = $productMgr->searchVarCheck('searchLocusGrade',$aryLocusGradeImg);


			$productMgr->setSearchLCate($arySearchLCate[0]);
			$productMgr->setSearchOrigin($arySearchOrigin[0]);
			$productMgr->setSearchType($arySearchType[0]);
			$productMgr->setSearchPriceFilter($arySearchPriceFilter[0]);
			$productMgr->setSearchCreditGrade($arySearchCreditGrade[0]);
			$productMgr->setSearchSaleGrade($arySearchSaleGrade[0]);
			$productMgr->setSearchLocusGrade($arySearchLocusGrade[0]);

			if($searchPageLine){
			$productMgr->setPageLine($searchPageLine);
			}
	
/*
			$intPageBlock		= 10;
			$intPageLine		= ($S_PRODUCT_LIST_IVW * $S_PRODUCT_LIST_IVH);
			$intPageDesignLine	= $S_PRODUCT_LIST_IVW;

			$productMgr->setPageLine($intPageLine);

			if ($strSearchProdShare == "Y") $intTotal	= $productMgr->getProdShareTotal($db);
			else $intTotal	= $productMgr->getProdTotal($db);
			$intTotPage	= ceil($intTotal / $productMgr->getPageLine());

			if(!$intPage)	$intPage =1;

			if ($intTotal==0) {
				$intFirst	= 1;
				$intLast	= 0;
			} else {
				$intFirst	= $intPageLine *($intPage -1);
				$intLast	= $intPageLine * $intPage;
			}
			$productMgr->setLimitFirst($intFirst);
			if ($strSearchProdShare == "Y") $result = $productMgr->getProdShareList($db);
			else $result = $productMgr->getProdList($db);
			$intListNum = $intTotal - ($intPageLine *($intPage-1));
*/

			$linkPage  = "?menuType=$strMenuType&mode=$strMode&lcate=$strSearchHCode1&mcate=$strSearchHCode2";
			$linkPage .= "&scate=$strSearchHCode3&fcate=$strSearchHCode4&lcateShare=$strSearchProdShare";
			$linkPage .= "&searchField=$strSearchField&searchKey=$strSearchKey";
			$linkPage .= "&searchIcon6=$strSearchIcon6&searchIcon7=$strSearchIcon7&searchIcon8=$strSearchIcon8";
			$linkPage .= "&sort=$strSearchSort&searchColor=$strSearchColor&searchSize=$strSearchSize";
			$linkPage .= "&searchStartPrice=$strSearchStartPrice&searchEndPrice=$strSearchEndPrice&searchListIcon=$strSearchListIcon";
			
			$linkPage .= "&searchOrigin=$strSearchOrigin";
			$linkPage .= "&searchType=$strSearchType";
			$linkPage .= "&searchPriceFilter=$strSearchPriceFilter";
			$linkPage .= "&searchCreditGrade1=$strSearchCreditGrade1";
			$linkPage .= "&searchCreditGrade2=$strSearchCreditGrade2";
			$linkPage .= "&searchCreditGrade3=$strSearchCreditGrade3";
			$linkPage .= "&searchSaleGrade1=$strSearchSaleGrade1";
			$linkPage .= "&searchSaleGrade2=$strSearchSaleGrade2";
			$linkPage .= "&searchSaleGrade3=$strSearchSaleGrade3";
			$linkPage .= "&searchLocusGrade1=$strSearchLocusGrade1";
			$linkPage .= "&searchLocusGrade2=$strSearchLocusGrade2";
			$linkPage .= "&searchPageLine=$strSearchPageLine";

			$linkPage .= "&searchBrand=$strSearchBrand&page=";




			/* 상품 카테고리별 추천 목록 */
			//$productMgr->setSearchIcon6("Y");
			//$productMgr->setLimitFirst(0);
			//$productMgr->setPageLine($D_PRODUCT_LIST_REC_LW * $D_PRODUCT_LIST_REC_LH);
			//$aryProdRecList = $productMgr->getProdSubList($db);

			/* 카테고리명 */
			if ($strSearchHCode1){
				$cateMgr->setC_CODE($strSearchHCode1);
				$strSearchHCodeName1 = $cateMgr->getCateLevelName($db);

				//카테고리별 관련 상품
				//$aryProdCateSellList = $productMgr->getProdCateSellList($db);
			}

			if($strSearchHCode2):
				$cateMgr->setC_CODE($strSearchHCode1.$strSearchHCode2);
				$strSearchHCodeName2 = $cateMgr->getCateLevelName($db);
			endif;

			if($strSearchHCode3):
				$cateMgr->setC_CODE($strSearchHCode1.$strSearchHCode2.$strSearchHCode3);
				$strSearchHCodeName3 = $cateMgr->getCateLevelName($db);
			endif;

			if($strSearchHCode4):
				$cateMgr->setC_CODE($strSearchHCode1.$strSearchHCode2.$strSearchHCode3.$strSearchHCode4);
				$strSearchHCodeName4 = $cateMgr->getCateLevelName($db);
			endif;

			/* 추천 상품 관련하여 */
			$cateMgr->setIC_TYPE("SUB");
			$aryProdSubList = $cateMgr->getProdDisplayList($db);


			// 카테고리
//			$strP_CATE			= $strSearchHCode1;
//			if ($strSearchHCode2) $strP_CATE .= $strSearchHCode2;
//			else $strP_CATE .= "000";

//			if ($strSearchHCode3) $strP_CATE .= $strSearchHCode3;
//			else $strP_CATE .= "000";

//			if ($strSearchHCode4) $strP_CATE .= $strSearchHCode4;
//			else $strP_CATE .= "000";

//			$designMgr->setTI_CATE_CODE($strP_CATE);
			// 카테고리

//			$topImage 				= $designMgr->getDesignTopImageView($db);
//			$strTopImageFileName = $topImage['TI_TOP_IMAGE'];


			// 추천 상품 관련하여
//			$designMgr->setPV_PAGE("subpage");
//			$subPageResult = $designMgr->getProdPageList($db);
		break;

		case "view":
			## 2015.02.09 kim hee sung
			## 상품가격 출력 설정
			##  관리자페이지 > 기본설정 > 주문및결제관리 > 상품가격노출 사용시 해당 그룹 회원에게만 가격 노출합니다.
			if($isPriceHide && !$S_PRICE_SHOW_VIEW):
				if(!$g_member_no) goUrl('로그인이 필요합니다.', './?menuType=member&mode=login');
				else goUrl('권한이 없습니다.', './');
			endif;

			## 페이지 언어 설정
			$strLang = $_GET['lang'];
			if(!$strLang) { $strLang = $S_SITE_LNG; }

			$productMgr->setP_CODE($strP_CODE);

			/* 좋아요 */
			if ($S_FIX_PRODUCT_LIST_LIKE_USE == "Y"){
				if ($g_member_no && $g_member_login){
					$productMgr->setM_NO($g_member_no);
					$productMgr->setSearchProdLike("prodList");
				}
			}
			$prodRow = $productMgr->getProdView($db);


			##FOB EXW 설정에따른 결제 단위 설절
			if($prodRow[P_PRICE_FILTER]=='FOB'){
				$strTextPriceUnit = '$';
			}else if($prodRow[P_PRICE_FILTER]=='EXW'){
				$strTextPriceUnit = getCurMark2();
			}

			## 카테고리 설정
			$_GET['lcate'] = substr($prodRow['P_CATE'], 0, 3);
			$_GET['mcate'] = substr($prodRow['P_CATE'], 3, 3);
			$_GET['scate'] = substr($prodRow['P_CATE'], 6, 3);
			$_GET['fcate'] = substr($prodRow['P_CATE'], 9, 3);
			if($_GET['lcate'] == "000") { $_GET['lcate'] = ""; }
			if($_GET['mcate'] == "000") { $_GET['mcate'] = ""; }
			if($_GET['scate'] == "000") { $_GET['scate'] = ""; }
			if($_GET['fcate'] == "000") { $_GET['fcate'] = ""; }

			/* edit 변수 지정 */
			$_EDIT['lcate'] = substr($prodRow['P_CATE'], 0, 3);
			$_EDIT['mcate'] = substr($prodRow['P_CATE'], 3, 3);
			$_EDIT['scate'] = substr($prodRow['P_CATE'], 6, 3);
			$_EDIT['fcate'] = substr($prodRow['P_CATE'], 9, 3);

			/* VIEW 이미지 리스트 */
			$productMgr->setPM_TYPE("view");
			$prodImgRow = $productMgr->getProdImg($db);

			if($strViewList){
			
			}else{
				$intPage = 1;
			}

			/* 카테고리 위치 표시 */
			if (!$strSearchHCode1) $strSearchHCode1 = substr($prodRow['P_CATE'], 0, 3);
			if (!$strSearchHCode2) $strSearchHCode2 = substr($prodRow['P_CATE'], 3, 3);
			if (!$strSearchHCode3) $strSearchHCode3 = substr($prodRow['P_CATE'], 6, 3);
			if (!$strSearchHCode4) $strSearchHCode4 = substr($prodRow['P_CATE'], 9, 3);

			$cateMgr->setC_CODE($strSearchHCode1);
			$strSearchHCodeName1 = $cateMgr->getCateLevelName($db);

			$cateMgr->setC_CODE($strSearchHCode1.$strSearchHCode2);
			$strSearchHCodeName2 = $cateMgr->getCateLevelName($db);

			$cateMgr->setC_CODE($strSearchHCode1.$strSearchHCode2.$strSearchHCode3);
			$strSearchHCodeName3 = $cateMgr->getCateLevelName($db);

			$cateMgr->setC_CODE($strSearchHCode1.$strSearchHCode2.$strSearchHCode3.$strSearchHCode4);
			$strSearchHCodeName4 = $cateMgr->getCateLevelName($db);

			/* 적립금 */
			$strProdSaleTotalPrice					= "";
			$strProdSaleTotalPriceLeftMark			= "";
			$strProdSaleTotalPriceRightMark			= "";

			$strProdSaleOrgTotalPrice				= "";
			$strProdSaleTotalOrgPriceLeftMark		= "";
			$strProdSaleTotalOrgPriceRightMark		= "";

			if ($prodRow[P_EVENT] > 0 && getProdEventInfo($prodRow) == "Y") $intProdSalePrice = getCurToPriceSave($prodRow['P_SALE_PRICE']);
			else $intProdSalePrice	= getProdDiscountPrice($prodRow,"2");

			$strProdSaleTotalPrice				= getFormatPrice($intProdSalePrice * $prodRow['P_MIN_QTY'],2);
			$strProdSaleTotalPriceLeftMark		= $strMoneyIconL;
			$strProdSaleTotalPriceRightMark		= $strMoneyIconR;

			if ($S_ARY_CUR[$S_SITE_LNG]["USD"][2] == "Y"){

				$strProdSaleOrgTotalPrice			= getFormatPrice($intProdSalePrice * $prodRow['P_MIN_QTY'],2);
				$strProdSaleTotalOrgPriceLeftMark	= $S_SITE_CUR_MARK1;
				$strProdSaleTotalOrgPriceRightMark	= "";

				if ($prodRow[P_EVENT] > 0 && getProdEventInfo($prodRow) == "Y") $intProdSalePrice = getCurToPriceSave($prodRow['P_SALE_PRICE'],'US');
				else $intProdSalePrice	= getProdDiscountPrice($prodRow,"2",0,"US");

				$strProdSaleTotalPrice				= getFormatPrice($intProdSalePrice * $prodRow['P_MIN_QTY'],2,"USD");
				$strProdSaleTotalPriceLeftMark		= getCurMark('USD');
				$strProdSaleTotalPriceRightMark		= "";
			}
			$intProdPoint = getProdPoint($intProdSalePrice, $prodRow[P_POINT], $prodRow[P_POINT_TYPE], $prodRow[P_POINT_OFF1], $prodRow[P_POINT_OFF2]);
			/* 상품 항목 설명 */
			$aryProdItem = $productMgr->getProdItem($db);

			/* 상품 옵션 */
			$productMgr->setP_LNG($S_SITE_LNG);
			$cateMgr->setCL_LNG($S_SITE_LNG);
			$productMgr->setPO_TYPE("O");
			$aryProdOpt = $productMgr->getProdOpt($db);

			if (is_array($aryProdOpt)){
				for($i=0;$i<sizeof($aryProdOpt);$i++){
					if ($aryProdOpt[$i][PO_NO] > 0){
						$productMgr->setPO_NO($aryProdOpt[$i][PO_NO]);

						/* 다중가격사용안함.다중가격분리형 */
						$aryProdOpt[$i]["OPT_ATTR1"] = $productMgr->getProdOptAttrGroup($db);

						/* 다중각격분리형 */
						$aryProdOpt[$i]["OPT_ATTR_ALL"] = $productMgr->getProdOptAttr($db);
					}
				}
			}

			/* 상품 추가 옵션*/
			if ($prodRow[P_ADD_OPT] == "Y"){
				$productMgr->setPO_TYPE("A");
				$aryProdAddOpt = $productMgr->getProdOpt($db);
				if (is_array($aryProdAddOpt)){
					for($i=0;$i<sizeof($aryProdAddOpt);$i++){
						if ($aryProdAddOpt[$i][PO_NO] > 0){
							$productMgr->setPO_NO($aryProdAddOpt[$i][PO_NO]);

							$aryProdAddOpt[$i][OPT_ATTR] = $productMgr->getProdAddOpt($db);
						}
					}
				}
			}

			/* 관심상품 나열 */
			$aryProdGrpList = $productMgr->getProdGrpList($db);

			/* 카테고리명 */
			if ($strSearchHCode1){
				//카테고리별 관련 상품
				$productMgr->setSearchHCode1($strSearchHCode1);
				$aryProdCateSellList = $productMgr->getProdCateSellList($db);
			}

			/* 배송관련/반품관련 */
			$siteMgr->setS_COL("S_PROD_DELIVERY_{$S_SITE_LNG}");
			$strProdDeliveryText = $siteMgr->getOneColText($db);
//			echo $db->query;
			if ($prodRow['P_SHOP_NO'] > 0 && $S_MALL_TYPE != 'R'){
				$productMgr->setP_SHOP_NO($prodRow['P_SHOP_NO']);
				$strProdDeliveryTextTemp = $productMgr->getProdDeliveryShopInfo($db);
				if($strProdDeliveryTextTemp) { $strProdDeliveryText = $strProdDeliveryTextTemp; }
//				echo $db->query;
			}

			$siteMgr->setS_COL("S_PROD_RETURN_{$S_SITE_LNG}");
			$strProdReturnText = $siteMgr->getOneColText($db);

			/* 공유카테고리 */
			$productMgr->setP_CATE($prodRow[P_CATE]);
			$aryProdShareCateInfo = $productMgr->getProdShareCateInfo($db);

			/* 입점사 상품일때 입점사 배송정보로 보여준다 */
			if ($prodRow['P_SHOP_NO'] > 0){
				$productMgr->setP_SHOP_NO($prodRow['P_SHOP_NO']);
				$prodShopInfo = $productMgr->getShopView($db);
			}

			/* 상품 고시정보 */
			if($S_PRODUCT_NOTIFY_USE && $strLang == "KR"):
				$param				= "";
				$param['P_CODE']	= $prodRow['P_CODE'];
				$param['PN_SORT']	= "Y";
				$arrProdNotifyInfo	= $productMgr->getProdNotifySelectEx($db,$param,"OP_ARYTOTAL");
			endif;


			##입점업체정보
			$shopMgr->setSH_NO($prodRow['P_SHOP_NO']);
			$shopRow =$shopMgr->getShopView($db);

			#인증서
			if($shopRow['SH_COM_FILE1']) {	$sh_file1	= "/upload/shop/file1/{$shopRow['SH_COM_FILE1']}";}
			if($shopRow['SH_COM_FILE2']) {	$sh_file2	= "/upload/shop/file2/{$shopRow['SH_COM_FILE2']}";}
			if($shopRow['SH_COM_FILE3']) {	$sh_file3	= "/upload/shop/file3/{$shopRow['SH_COM_FILE3']}";}
			if($shopRow['SH_COM_FILE4']) {	$sh_file4	= "/upload/shop/file4/{$shopRow['SH_COM_FILE4']}";}
			if($shopRow['SH_COM_FILE5']) {	$sh_file5	= "/upload/shop/file5/{$shopRow['SH_COM_FILE5']}";}

			#인증서
			if($shopRow['SH_COM_CERTIFICATES1_FILE']) {	$sh_certificates1	= "/upload/shop/certificates1/{$shopRow['SH_COM_CERTIFICATES1_FILE']}";}
			if($shopRow['SH_COM_CERTIFICATES2_FILE']) {	$sh_certificates2	= "/upload/shop/certificates2/{$shopRow['SH_COM_CERTIFICATES2_FILE']}";}
			if($shopRow['SH_COM_CERTIFICATES3_FILE']) {	$sh_certificates3	= "/upload/shop/certificates3/{$shopRow['SH_COM_CERTIFICATES3_FILE']}";}
			if($shopRow['SH_COM_CERTIFICATES4_FILE']) {	$sh_certificates4	= "/upload/shop/certificates4/{$shopRow['SH_COM_CERTIFICATES4_FILE']}";}
			if($shopRow['SH_COM_CERTIFICATES5_FILE']) {	$sh_certificates5	= "/upload/shop/certificates5/{$shopRow['SH_COM_CERTIFICATES5_FILE']}";}

			#view 상품리스트

			$linkPage  = "?menuType=$strMenuType&mode=$strMode&lcate=$strSearchHCode1&mcate=$strSearchHCode2";
			$linkPage .= "&scate=$strSearchHCode3&fcate=$strSearchHCode4&lcateShare=$strSearchProdShare";
			$linkPage .= "&searchField=$strSearchField&searchKey=$strSearchKey";
			$linkPage .= "&searchIcon6=$strSearchIcon6&searchIcon7=$strSearchIcon7&searchIcon8=$strSearchIcon8";
			$linkPage .= "&sort=$strSearchSort&searchColor=$strSearchColor&searchSize=$strSearchSize";
			$linkPage .= "&searchStartPrice=$strSearchStartPrice&searchEndPrice=$strSearchEndPrice&searchListIcon=$strSearchListIcon";
			$linkPage .= "&prodCode=$strP_CODE&viewList=Y";
			$linkPage .= "&searchBrand=$strSearchBrand&page=";

			## 상품옥션
			//include WEB_FRWORK_HELP."product.auction.php";(파일없음)

		break;

		case "prodInquiry":

			$productMgr->setP_CODE($strP_CODE);
			$prodRow = $productMgr->getProdView($db);


		break;

		case "brandList":
			$intPR_NO  = $_POST["pr_no"]			? $_POST["pr_no"]			: $_REQUEST["pr_no"];

			$linkPage  = "?menuType=$strMenuType&mode=$strMode&lcate=$strSearchHCode1&mcate=$strSearchHCode2";
			$linkPage .= "&scate=$strSearchHCode3&fcate=$strSearchHCode4&lcateShare=$strSearchProdShare";
			$linkPage .= "&searchField=$strSearchField&searchKey=$strSearchKey";
			$linkPage .= "&searchIcon6=$strSearchIcon6&searchIcon7=$strSearchIcon7&searchIcon8=$strSearchIcon8";
			$linkPage .= "&sort=$strSearchSort&searchColor=$strSearchColor&searchSize=$strSearchSize";
			$linkPage .= "&searchStartPrice=$strSearchStartPrice&searchEndPrice=$strSearchEndPrice&pr_no=$intPR_NO";
			$linkPage .= "&SearchBrand=$strSearchBrand&page=";
		break;
	}

	if($strDevice == "mobile") {
		//include "product.script.mobile.php";
	} else {
		//include "product.script.php";
	}

?>