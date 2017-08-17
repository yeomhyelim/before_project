<?
	require_once MALL_CONF_LIB."CateMgr.php";
	require_once MALL_CONF_LIB."ProductMgr.php";
	require_once MALL_CONF_LIB."OrderMgr.php";
	require_once MALL_CONF_LIB."MemberMgr.php";
	require_once MALL_CONF_LIB."SiteMgr.php";

	require_once $S_DOCUMENT_ROOT.$S_SHOP_HOME."/conf/site_skin_product.conf.inc.php";
	require_once $S_DOCUMENT_ROOT.$S_SHOP_HOME."/conf/product.inc.php";
	require_once $S_DOCUMENT_ROOT.$S_SHOP_HOME."/conf/order.inc.php";

	/*상품함수관련*/
	require_once MALL_PROD_FUNC;

	if(is_file("{$S_DOCUMENT_ROOT}{$S_SHOP_HOME}/conf/shop.manual.inc.php")):
		require_once "{$S_DOCUMENT_ROOT}{$S_SHOP_HOME}/conf/shop.manual.inc.php";
	endif;

	//입점사의 type, 국가, 등급관련 설정 2015.05.14
	include_once sprintf( "%s/www/include/shopCom.conf.inc.php", $S_DOCUMENT_ROOT);

	$cateMgr		= new CateMgr();
	$productMgr		= new ProductMgr();
	$orderMgr		= new OrderMgr();
	$memberMgr		= new MemberMgr();
	$siteMgr		= new SiteMgr();

	$strP_CODE				= $_POST["prodCode"]			? $_POST["prodCode"]			: $_REQUEST["prodCode"];

	$strSearchField			= $_POST["searchField"]			? $_POST["searchField"]			: $_REQUEST["searchField"];
	$strSearchKey			= $_POST["searchKey"]			? $_POST["searchKey"]			: $_REQUEST["searchKey"];
	$intPage				= $_POST["page"]				? $_POST["page"]				: $_REQUEST["page"];
	$strViewList			= $_POST["viewList"]			? $_POST["viewList"]			: $_REQUEST["viewList"];
	$strComView				= $_POST["comView"]			? $_POST["comView"]			: $_REQUEST["comView"];

	$intSearchPageLine		= $_POST["searchPageLine"]		? $_POST["searchPageLine"]		: $_REQUEST["searchPageLine"];

	$strSearchHCode1		= $_POST["lcate"]				? $_POST["lcate"]				: $_REQUEST["lcate"];
	$strSearchHCode2		= $_POST["mcate"]				? $_POST["mcate"]				: $_REQUEST["mcate"];
	$strSearchHCode3		= $_POST["scate"]				? $_POST["scate"]				: $_REQUEST["scate"];
	$strSearchHCode4		= $_POST["fcate"]				? $_POST["fcate"]				: $_REQUEST["fcate"];
	$strSearchProdShare		= $_POST["lcateShare"]			? $_POST["lcateShare"]			: $_REQUEST["lcateShare"];

	$strSearchSort			= $_POST["sort"]				? $_POST["sort"]				: $_REQUEST["sort"];
	$strSearchIcon1			= $_POST["searchIcon1"]			? $_POST["searchIcon1"]			: $_REQUEST["searchIcon1"];
	$strSearchIcon2			= $_POST["searchIcon2"]			? $_POST["searchIcon2"]			: $_REQUEST["searchIcon2"];
	$strSearchIcon3			= $_POST["searchIcon3"]			? $_POST["searchIcon3"]			: $_REQUEST["searchIcon3"];
	$strSearchIcon4			= $_POST["searchIcon4"]			? $_POST["searchIcon4"]			: $_REQUEST["searchIcon4"];
	$strSearchIcon5			= $_POST["searchIcon5"]			? $_POST["searchIcon5"]			: $_REQUEST["searchIcon5"];
	$strSearchIcon6			= $_POST["searchIcon6"]			? $_POST["searchIcon6"]			: $_REQUEST["searchIcon6"];
	$strSearchIcon7			= $_POST["searchIcon7"]			? $_POST["searchIcon7"]			: $_REQUEST["searchIcon7"];
	$strSearchIcon8			= $_POST["searchIcon8"]			? $_POST["searchIcon8"]			: $_REQUEST["searchIcon8"];
	$strSearchIcon9			= $_POST["searchIcon9"]			? $_POST["searchIcon9"]			: $_REQUEST["searchIcon9"];
	$strSearchIcon10		= $_POST["searchIcon10"]		? $_POST["searchIcon10"]		: $_REQUEST["searchIcon10"];
	$strSearchColor			= $_POST["searchColor"]			? $_POST["searchColor"]			: $_REQUEST["searchColor"];
	$strSearchSize			= $_POST["searchSize"]			? $_POST["searchSize"]			: $_REQUEST["searchSize"];

	$strSearchStartPrice	= $_POST["searchStartPrice"]	? $_POST["searchStartPrice"]	: $_REQUEST["searchStartPrice"];
	$strSearchEndPrice		= $_POST["searchEndPrice"]		? $_POST["searchEndPrice"]		: $_REQUEST["searchEndPrice"];

	$strSearchListIcon		= $_POST["searchListIcon"]		? $_POST["searchListIcon"]		: $_REQUEST["searchListIcon"];

	$strSearchBrand			= $_POST["searchBrand"]			? $_POST["searchBrand"]			: $_REQUEST["searchBrand"];
	$strSearchAuction		= $_POST["useAuction"]			? $_POST["useAuction"]			: $_REQUEST["useAuction"];



	$strSearchOrigin			= $_POST["searchOrigin"]				? $_POST["searchOrigin"]				: $_REQUEST["searchOrigin"];
	$strSearchType1				= $_POST["searchType1"]					? $_POST["searchType1"]					: $_REQUEST["searchType1"];
	$strSearchType2				= $_POST["searchType2"]					? $_POST["searchType2"]					: $_REQUEST["searchType2"];
	$strSearchType3				= $_POST["searchType3"]					? $_POST["searchType3"]					: $_REQUEST["searchType3"];
	$strSearchPriceFilter		= $_POST["searchPriceFilter"]			? $_POST["searchPriceFilter"]			: $_REQUEST["searchPriceFilter"];
	$strSearchCreditGrade1		= $_POST["searchCreditGrade1"]			? $_POST["searchCreditGrade1"]			: $_REQUEST["searchCreditGrade1"];
	$strSearchCreditGrade2		= $_POST["searchCreditGrade2"]			? $_POST["searchCreditGrade2"]			: $_REQUEST["searchCreditGrade2"];
	$strSearchCreditGrade3		= $_POST["searchCreditGrade3"]			? $_POST["searchCreditGrade3"]			: $_REQUEST["searchCreditGrade3"];
	$strSearchSaleGrade1		= $_POST["searchSaleGrade1"]			? $_POST["searchSaleGrade1"]			: $_REQUEST["searchSaleGrade1"];
	$strSearchSaleGrade2		= $_POST["searchSaleGrade2"]			? $_POST["searchSaleGrade2"]			: $_REQUEST["searchSaleGrade2"];
	$strSearchSaleGrade3		= $_POST["searchSaleGrade3"]			? $_POST["searchSaleGrade3"]			: $_REQUEST["searchSaleGrade3"];
	$strSearchLocusGrade1		= $_POST["searchLocusGrade1"]			? $_POST["searchLocusGrade1"]			: $_REQUEST["searchLocusGrade1"];
	$strSearchLocusGrade2		= $_POST["searchLocusGrade2"]			? $_POST["searchLocusGrade2"]			: $_REQUEST["searchLocusGrade2"];
	
	$strSearchSubKey			= $_POST["searchSubKey"]				? $_POST["searchSubKey"]			: $_REQUEST["searchSubKey"];

	$strSearchPageLine			= $_POST["searchPageLine"]				? $_POST["searchPageLine"]			: $_REQUEST["searchPageLine"];


	$productMgr->setP_LNG($S_SITE_LNG);
	$cateMgr->setCL_LNG($S_SITE_LNG);

	$aryCountryList		= getCountryList();			
	$aryCountryState	= getCommCodeList("STATE","");
	switch ($strMode)
	{
		case "paperWrite":

		break;

		case "list":
		case "search":
			//검색버튼 누를때마다 page 1로 변경 되도록 추가. 남덕희
			if($intPage)$productMgr->setLimitFirst($intPage);

			 /*원산지*/
			$productMgr->setColumn("P_ORIGIN");
			$aryProductOrigin = $productMgr->getProductColGroupList($db);

			$aryPriceFilter = array('EXW','FOB');

			$cateMgr->setC_LEVEL(1);
			$aryCategorys1 = $cateMgr->getCateLevelAry($db);
			for($i = 0; $i < sizeof($aryCategorys1); $i++){
				$aryCateNames1[$aryCategorys1[$i]['CATE_CODE']] = $aryCategorys1[$i]['CATE_NAME'];
			}

			$cateMgr->setC_LEVEL(2);
			$aryCategorys2 = $cateMgr->getCateLevelAry($db);
			for($i = 0; $i < sizeof($aryCategorys2); $i++){
				$aryCateNames2[$aryCategorys2[$i]['CATE_CODE']] = $aryCategorys2[$i]['CATE_NAME'];
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
			


			$arySearchLCate = $productMgr->searchVarCheck('searchLCate',$aryCategorys1);
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

			/* 상품 비교하기 리스트 */
			//다른페이지로 갈때 비교하기 초기화 2015.06.23 kjp
			if(isset($intPage)){
				$strProdCompareCookie = $_COOKIE["prodCompare"];
				$aryProdCompareCookie = explode("|",$strProdCompareCookie);
				$intProdCompareCookieCnt = sizeof($aryProdCompareCookie)-1;
			}else{
				echo '
				<script type="text/javascript">
				//<![CDATA[
				C_DelCookie("prodCompare");
				$("#prodCompare").val("");
				//]]>
				</script>
				';
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
			$linkPage .= "&searchType1=$strSearchType1";
			$linkPage .= "&searchType2=$strSearchType2";
			//제조/공급사 삭제요청 페이지이동. 남덕희
			//$linkPage .= "&searchType3=$strSearchType3";

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

		//원산지 검색 링크 추가 남덕희
		if($arySearchOrigin[1]){
			for($i=0;$i<count($arySearchOrigin[1]);$i++){
				$linkPage .= '&searchOrigin'.($i+1).'='.$arySearchOrigin[1][$i];
			}
		}

		//카테고리 검색 링크 추가 남덕희
		if($arySearchLCate[1]){
			for($i=0;$i<count($arySearchLCate[1]);$i++){
				$linkPage .= '&searchLCate'.($i+1).'='.$arySearchLCate[1][$i];
			}
		}

		//즉시구매 검색 링크 추가 남덕희
		if($arySearchPriceFilter[1]){
			for($i=0;$i<count($arySearchPriceFilter[1]);$i++){
				$linkPage .= '&searchPriceFilter'.($i+1).'='.$arySearchPriceFilter[1][$i];
			}
		}

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

			if($mobie_view == 'Y')
			{
			$productMgr->setMOBILE_IMG_VIEW('Y');
			}

			$prodRow = $productMgr->getProdView($db);

			/* 입점사 상품일때 입점사 배송정보로 보여준다 */
			if ($prodRow['P_SHOP_NO'] > 0)
			{
				$productMgr->setP_SHOP_NO($prodRow['P_SHOP_NO']);
				$productMgr->setP_LNG($S_SITE_LNG);
				$prodShopInfo = $productMgr->getShopView($db);
			}
			## 기본변수설정 2015.05.15
			/* 웹,모바일에서 사용 */
			$intSH_NO					= $prodRow['P_SHOP_NO'];

			$strP_NAME					= $prodRow['P_NAME'];
			$strViewImg					= $prodRow['PM_REAL_NAME'];
			$intP_SALE_PRICE			= $prodRow['P_SALE_PRICE'];
			$intP_POINT					= $prodRow['P_POINT'];
			$strP_MAKER					= $prodRow["P_MAKER"]; // 제조사
			$strP_ORIGIN				= $prodRow["P_ORIGIN"]; // 원산지
			$strP_BRAND_NAME			= $prodRow["P_BRAND_NAME"]; // 브랜드
			$strP_MIN_QTY				= $prodRow["P_MIN_QTY"]; // 브랜드
			$strP_CONSUMER_PRICE		= $prodRow['P_CONSUMER_PRICE'];
			$strP_STOCK_PRICE			= $prodRow['P_STOCK_PRICE'];
			$strP_OPT					= $prodRow['P_OPT'];
			$strP_EVENT_UNIT			= $prodRow['P_EVENT_UNIT'];
			$strP_EVENT					= $prodRow['P_EVENT'];
			$strP_MODEL					= $prodRow['P_MODEL'];//모델
			$strP_ADD_OPT				= $prodRow['P_ADD_OPT'];
			$strP_STOCK_LIMIT			= $prodRow['P_STOCK_LIMIT'];
			$strP_QTY					= $prodRow['P_QTY'];
			$strP_STOCK_OUT				= $prodRow['P_STOCK_OUT'];
			$strP_BAESONG_TYPE			= $prodRow['P_BAESONG_TYPE'];
			$intP_BAESONG_PRICE			= $prodRow['P_BAESONG_PRICE'];
			$strP_CATE					= $prodRow['P_CATE'];
			$strP_CAS_NO				= $prodRow['P_CAS_NO'];
			$strP_OTHER_NAMES			= $prodRow['P_OTHER_NAMES'];
			$strP_PRICE_FILTER			= $prodRow['P_PRICE_FILTER'];
			$strP_PRICE_UNIT			= $prodRow['P_PRICE_UNIT'];
			$strP_TYPE					= $prodRow['P_TYPE'];
			$strP_SAIL_UNIT				= $prodRow['P_SAIL_UNIT'];

			$strSH_COM_NAME				= $prodShopInfo['SH_COM_NAME'];//회사명
			$strSH_COM_INTRO1			= $prodShopInfo['SH_COM_INTRO1'];
			$strSH_COM_INTRO2			= $prodShopInfo['SH_COM_INTRO2'];
			$strSH_COM_COUNTRY			= $prodShopInfo['SH_COM_COUNTRY'];//국가
			$strSH_COM_CATEGORY			= $prodShopInfo['SH_COM_CATEGORY'];//type
			$strSH_COM_REP_NM			= $prodShopInfo['SH_COM_REP_NM'];
			$strSH_COM_PHONE			= $prodShopInfo['SH_COM_PHONE'];//대표전화
			$strSH_COM_FAX				= $prodShopInfo['SH_COM_FAX'];//대표팩스
			$strSH_COM_ADDR				= $prodShopInfo['SH_COM_ADDR'];//회사주소
			$strSH_COM_MAIL				= $prodShopInfo['SH_COM_MAIL'];//회사이메일
			$strSH_COM_NUM				= $prodShopInfo['SH_COM_NUM'];//사업자번호
			$strSH_COM_SITE				= $prodShopInfo['SH_COM_SITE'];//웹사이트
			$strSH_COM_FOUNDED			= $prodShopInfo['SH_COM_FOUNDED'];//설립연도
			$strSH_COM_NUMBER			= $prodShopInfo['SH_COM_NUMBER'];//직원수
			$strSH_COM_TOTAL_SALE		= $prodShopInfo['SH_COM_TOTAL_SALE'];//연간총매출랙
			$strSH_COM_RATE				= $prodShopInfo['SH_COM_RATE'];//수출비율
			$strSH_COM_TOTAL_PRODUCTION	= $prodShopInfo['SH_COM_TOTAL_PRODUCTION'];//연간총생산량
			$strSH_COM_SIZE				= $prodShopInfo['SH_COM_SIZE'];
			$strSH_COM_LOCAL			= $prodShopInfo['SH_COM_LOCAL'];
			$strSH_COM_RD				= $prodShopInfo['SH_COM_RD'];
			$strSH_COM_CATE				= $prodShopInfo['SH_COM_CATE'];
			$strSH_COM_CERTIFICATES1	= $prodShopInfo['SH_COM_CERTIFICATES1'];
			$strSH_COM_CERTIFICATES2	= $prodShopInfo['SH_COM_CERTIFICATES2'];
			$strSH_COM_CERTIFICATES3	= $prodShopInfo['SH_COM_CERTIFICATES3'];
			$strSH_COM_CERTIFICATES4	= $prodShopInfo['SH_COM_CERTIFICATES4'];
			$strSH_COM_CERTIFICATES5	= $prodShopInfo['SH_COM_CERTIFICATES5'];
			$strSH_COM_DELIVERY			= $prodShopInfo['SH_COM_DELIVERY'];
			$strSH_COM_DELIVERY_PRICE	= $prodShopInfo['SH_COM_DELIVERY_PRICE'];
			$strSH_COM_DELIVERY_ST_PRICE= $prodShopInfo['SH_COM_DELIVERY_ST_PRICE'];
			$strSH_COM_DELIVERY_PRICE	= $prodShopInfo['SH_COM_DELIVERY_PRICE'];

			$strSH_COM_CREDIT_GRADE_IMG	= $aryCreditGradeImg[$prodShopInfo['SH_COM_CREDIT_GRADE']];
			$strSH_COM_SALE_GRADE_IMG	= $arySaleGradeImg[$prodShopInfo['SH_COM_SALE_GRADE']];
			$strSH_COM_LOCUS_GRADE_IMG	= $aryLocusGradeImg[$prodShopInfo['SH_COM_LOCUS_GRADE']];


			/* 웹에서만 사용 */
			$strP_PRICE_UNIT			= $prodRow['P_PRICE_UNIT'];
			$strP_CAS_NO				= $prodRow['P_CAS_NO'];
			$strP_OTHER_NAMES			= $prodRow['P_OTHER_NAMES'];

			$strSH_COM_REP_NM			= $prodShopInfo['SH_COM_REP_NM'];


			$curToP_CONSUMER_PRICE		= getCurToPrice($strP_CONSUMER_PRICE);

			//배송비관련조건
			if ($intSH_NO > 0 && $strSH_COM_DELIVERY == 'S')
			{
				$strFreeDeliveryCondition = callLangTrans($LNG_TRANS_CHAR["PS00003"],array(getCurToPrice($strSH_COM_DELIVERY_ST_PRICE))); //{{단어1}}이상 구매시
				$strDeliveryOrder = callLangTrans($LNG_TRANS_CHAR["PS00004"],array(getCurToPrice($strSH_COM_DELIVERY_PRICE))); //주문시 {{단어1}} 결제
			}
			else
			{
				$strFreeDeliveryCondition = callLangTrans($LNG_TRANS_CHAR["PS00003"],array(getCurToPrice($SHOP_ARY_DELIVERY["SHOP_DELIVERY_ST_PRICE"]))); //{{단어1}}이상 구매시
				$strDeliveryOrder = callLangTrans($LNG_TRANS_CHAR["PS00004"],array(getCurToPrice($strSH_COM_DELIVERY_PRICE))); //주문시 {{단어1}} 결제
			}


			#	strP_BAESONG_TYPE == 5 의 배송비 설정
			if ($intP_BAESONG_PRICE > 0)
			{
				$strProdDeliveryAfter = callLangTrans($LNG_TRANS_CHAR["PS00006"],array($strMoneyIconL,getCurToPrice($intP_BAESONG_PRICE),$strMoneyIconR)); //상품 수령 후 {{단어1}} {{단어2}} 지불
			}
			else
			{
				$strProdDeliveryAfter = callLangTrans($LNG_TRANS_CHAR["PS00006"],array("","","")); //상품 수령 후 {{단어1}} {{단어2}} 지불
			}

			## 카테고리 설정
			$_GET['lcate'] = substr($strP_CATE, 0, 3);
			$_GET['mcate'] = substr($strP_CATE, 3, 3);
			$_GET['scate'] = substr($strP_CATE, 6, 3);
			$_GET['fcate'] = substr($strP_CATE, 9, 3);
			if($_GET['lcate'] == "000") { $_GET['lcate'] = ""; }
			if($_GET['mcate'] == "000") { $_GET['mcate'] = ""; }
			if($_GET['scate'] == "000") { $_GET['scate'] = ""; }
			if($_GET['fcate'] == "000") { $_GET['fcate'] = ""; }

			/* edit 변수 지정 */
			$_EDIT['lcate'] = substr($strP_CATE, 0, 3);
			$_EDIT['mcate'] = substr($strP_CATE, 3, 3);
			$_EDIT['scate'] = substr($strP_CATE, 6, 3);
			$_EDIT['fcate'] = substr($strP_CATE, 9, 3);

			/* VIEW 이미지 리스트 */
			$productMgr->setPM_TYPE("view");
			$prodImgRow = $productMgr->getProdImg($db);

			if($strViewList){
			
			}else{
				$intPage = 1;
			}

			/* 카테고리 위치 표시 */
			if (!$strSearchHCode1) $strSearchHCode1 = substr($strP_CATE, 0, 3);
			if (!$strSearchHCode2) $strSearchHCode2 = substr($strP_CATE, 3, 3);
			if (!$strSearchHCode3) $strSearchHCode3 = substr($strP_CATE, 6, 3);
			if (!$strSearchHCode4) $strSearchHCode4 = substr($strP_CATE, 9, 3);

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

			// 통화 구분. 남덕희
			$strTextPriceUnit = getCurMarkFilter($strP_PRICE_FILTER, $S_SITE_LNG);

			if ($strP_EVENT > 0 && getProdEventInfo($prodRow) == "Y"){
				$intProdSalePrice = getCurToPriceSave($prodRow['P_SALE_PRICE']);
			}else{
				##FOB EXW 설정에따른 결제 단위 설정
				if($strP_PRICE_FILTER=='FOB')
				{
					$intProdSalePrice	= getProdDiscountPrice($prodRow,"2",0,"US");
					//$strTextPriceUnit = '$';
				}
				else if($strP_PRICE_FILTER=='EXW')
				{
					$intProdSalePrice	= getProdDiscountPrice($prodRow,"2");
					//$strTextPriceUnit = getCurMark2();
				}
				
			}

			$strProdSaleTotalPrice				= getFormatPrice($intProdSalePrice * $prodRow['P_MIN_QTY'],2);
			$strProdSaleTotalPriceLeftMark		= $strMoneyIconL;
			$strProdSaleTotalPriceRightMark		= $strMoneyIconR;

			if ($S_ARY_CUR[$S_SITE_LNG]["USD"][2] == "Y"){

				$strProdSaleOrgTotalPrice			= getFormatPrice($intProdSalePrice * $prodRow['P_MIN_QTY'],2);
				$strProdSaleTotalOrgPriceLeftMark	= $S_SITE_CUR_MARK1;
				$strProdSaleTotalOrgPriceRightMark	= "";

				if ($strP_EVENT > 0 && getProdEventInfo($prodRow) == "Y") $intProdSalePrice = getCurToPriceSave($prodRow['P_SALE_PRICE'],'US');
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
			$productMgr->setP_CATE($strP_CATE);
			$aryProdShareCateInfo = $productMgr->getProdShareCateInfo($db);

			

			/* 상품 고시정보 */
			if($S_PRODUCT_NOTIFY_USE && $strLang == "KR"):
				$param				= "";
				$param['P_CODE']	= $strP_CODE;//$prodRow['P_CODE'];
				$param['PN_SORT']	= "Y";
				$arrProdNotifyInfo	= $productMgr->getProdNotifySelectEx($db,$param,"OP_ARYTOTAL");
			endif;


			#인증서
			if($prodShopInfo['SH_COM_FILE1']) {	$sh_file1	= "/upload/shop/file1/{$prodShopInfo['SH_COM_FILE1']}";}
			if($prodShopInfo['SH_COM_FILE2']) {	$sh_file2	= "/upload/shop/file2/{$prodShopInfo['SH_COM_FILE2']}";}
			if($prodShopInfo['SH_COM_FILE3']) {	$sh_file3	= "/upload/shop/file3/{$prodShopInfo['SH_COM_FILE3']}";}
			if($prodShopInfo['SH_COM_FILE4']) {	$sh_file4	= "/upload/shop/file4/{$prodShopInfo['SH_COM_FILE4']}";}
			if($prodShopInfo['SH_COM_FILE5']) {	$sh_file5	= "/upload/shop/file5/{$prodShopInfo['SH_COM_FILE5']}";}

			#인증서
			if($prodShopInfo['SH_COM_CERTIFICATES1_FILE']) {	$sh_certificates1	= "/upload/shop/certificates1/{$prodShopInfo['SH_COM_CERTIFICATES1_FILE']}";}
			if($prodShopInfo['SH_COM_CERTIFICATES2_FILE']) {	$sh_certificates2	= "/upload/shop/certificates2/{$prodShopInfo['SH_COM_CERTIFICATES2_FILE']}";}
			if($prodShopInfo['SH_COM_CERTIFICATES3_FILE']) {	$sh_certificates3	= "/upload/shop/certificates3/{$prodShopInfo['SH_COM_CERTIFICATES3_FILE']}";}
			if($prodShopInfo['SH_COM_CERTIFICATES4_FILE']) {	$sh_certificates4	= "/upload/shop/certificates4/{$prodShopInfo['SH_COM_CERTIFICATES4_FILE']}";}
			if($prodShopInfo['SH_COM_CERTIFICATES5_FILE']) {	$sh_certificates5	= "/upload/shop/certificates5/{$prodShopInfo['SH_COM_CERTIFICATES5_FILE']}";}

			#파일확장자 확인
			function fileExtCheck($strFileName){
				$aryImageExt = array("jpg","gif","png");
				$aryFileName = explode(".",$strFileName);
				$intFileEx = sizeof($aryFileName);
				$intFileEx = $intFileEx-1;
				if(in_array($aryFileName[$intFileEx], $aryImageExt)){
					$strfileLinkName = "javascript:popImageDetail('{$strFileName}')";
				}else{
					$strfileLinkName = $strFileName;
				}
				return $strfileLinkName;
			}

			
			

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
		#상품문의하기
		case "prodInquiry":

			$productMgr->setP_CODE($strP_CODE);
			$prodRow = $productMgr->getProdView($db);

		break;
		#상품비교하기
		case "prodCompare":

			//$productMgr->setP_CODE($strP_CODE);
			//$prodRow = $productMgr->getProdView($db);

			/* 상품 비교하기 리스트 */
			$strProdCompareCookie = $_COOKIE["prodCompare"];
			$aryProdCompareCookie = explode("|",$strProdCompareCookie);
			$intProdCompareCookieCnt = sizeof($aryProdCompareCookie)-1;

			#상품
			$strProdCodeWhere = "";
			for($i =0; $i < $intProdCompareCookieCnt; $i++){
				
				if($i != 0){
					$strProdCodeWhere .= ",";
				}
				if($i >= 0){
					$strProdCodeWhere .= "'";
				}

				$strProdCodeWhere .= $aryProdCompareCookie[$i];

				if($i != $intProdCompareCookieCnt){
					$strProdCodeWhere .= "'";
				}
			}
			//상품수 재설정 (기존에 한게 더 많이 들어감)
			$intProdCompareCookieCnt = $intProdCompareCookieCnt-1;
			$productMgr->setP_LNG($S_SITE_LNG);
			//비교하기상품이 없을때에도 상품이 표시되기에 있을때만 실행
			if($strProdCodeWhere)
			{
				$param= "";
				$param['SHOP_JOIN'] = "Y";
				$param['PROD_INFO_JOIN'] = "Y";
				$param['P_LNG']				= $S_SITE_LNG;
				$param['P_CODE_IN'] = $strProdCodeWhere;
				$prodCompareListResult = $productMgr ->getProdListEx($db,"OP_LIST",$param);
			}
	/**/
			$cateMgr->setCL_LNG($S_SITE_LNG);



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
		include "product.script.mobile.php";
	} else {
		include "product.script.php";
	}

?>