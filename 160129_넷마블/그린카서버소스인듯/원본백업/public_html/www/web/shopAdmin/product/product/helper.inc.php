<?
	require_once MALL_CONF_LIB."CateMgr.php";
	require_once MALL_CONF_LIB."ProductAdmMgr.php";
	require_once MALL_CONF_LIB."SiteMgr.php";
	require_once MALL_CONF_LIB."MemberMgr.php";
	require_once MALL_CONF_LIB."DesignSetMgr.php";

	include_once MALL_HOME."/include/shopCom.conf.inc.php";
	require_once "../conf/site_skin_product.conf.inc.php";
	require_once "../conf/category.inc.php";

	$cateMgr = new CateMgr();
	$productMgr = new ProductAdmMgr();
	$siteMgr = new SiteMgr();
	$memberMgr = new MemberMgr();
	$designSetMgr = new DesignSetMgr();

	/*##################################### Parameter 셋팅 #####################################*/
	$strSearchField = $_POST["searchField"]		? $_POST["searchField"]		: $_REQUEST["searchField"];
	$strSearchKey	= $_POST["searchKey"]		? $_POST["searchKey"]		: $_REQUEST["searchKey"];
	$intPage		= $_POST["page"]			? $_POST["page"]			: $_REQUEST["page"];
	$intPageLine	= $_POST["pageLine"]		? $_POST["pageLine"]		: $_REQUEST["pageLine"];

	$strP_CODE		= $_POST["prodCode"]		? $_POST["prodCode"]		: $_REQUEST["prodCode"];
	$intPM_NO		= $_POST["prodImgNo"]		? $_POST["prodImgNo"]		: $_REQUEST["prodImgNo"];

	$strSearchHCode1		= $_POST["searchCate1"]				? $_POST["searchCate1"]				: $_REQUEST["searchCate1"];
	$strSearchHCode2		= $_POST["searchCate2"]				? $_POST["searchCate2"]				: $_REQUEST["searchCate2"];
	$strSearchHCode3		= $_POST["searchCate3"]				? $_POST["searchCate3"]				: $_REQUEST["searchCate3"];
	$strSearchHCode4		= $_POST["searchCate4"]				? $_POST["searchCate4"]				: $_REQUEST["searchCate4"];
	$strSearchLaunchStartDt = $_POST["searchLaunchStartDt"]		? $_POST["searchLaunchStartDt"]		: $_REQUEST["searchLaunchStartDt"];
	$strSearchLaunchEndDt	= $_POST["searchLaunchEndDt"]		? $_POST["searchLaunchEndDt"]		: $_REQUEST["searchLaunchEndDt"];
	$strSearchRepStartDt	= $_POST["searchRepStartDt"]		? $_POST["searchRepStartDt"]		: $_REQUEST["searchRepStartDt"];
	$strSearchRepEndDt		= $_POST["searchRepEndDt"]			? $_POST["searchRepEndDt"]			: $_REQUEST["searchRepEndDt"];
	$strSearchWebView		= $_POST["searchWebView"]			? $_POST["searchWebView"]			: $_REQUEST["searchWebView"];
	$strSearchMobileView	= $_POST["searchMobileView"]		? $_POST["searchMobileView"]		: $_REQUEST["searchMobileView"];

	$strSearchIcon1			= $_POST["searchIcon1"]				? $_POST["searchIcon1"]				: $_REQUEST["searchIcon1"];
	$strSearchIcon2			= $_POST["searchIcon2"]				? $_POST["searchIcon2"]				: $_REQUEST["searchIcon2"];
	$strSearchIcon3			= $_POST["searchIcon3"]				? $_POST["searchIcon3"]				: $_REQUEST["searchIcon3"];
	$strSearchIcon4			= $_POST["searchIcon4"]				? $_POST["searchIcon4"]				: $_REQUEST["searchIcon4"];
	$strSearchIcon5			= $_POST["searchIcon5"]				? $_POST["searchIcon5"]				: $_REQUEST["searchIcon5"];
	$strSearchIcon6			= $_POST["searchIcon6"]				? $_POST["searchIcon6"]				: $_REQUEST["searchIcon6"];
	$strSearchIcon7			= $_POST["searchIcon7"]				? $_POST["searchIcon7"]				: $_REQUEST["searchIcon7"];
	$strSearchIcon8			= $_POST["searchIcon8"]				? $_POST["searchIcon8"]				: $_REQUEST["searchIcon8"];
	$strSearchIcon9			= $_POST["searchIcon9"]				? $_POST["searchIcon9"]				: $_REQUEST["searchIcon9"];
	$strSearchIcon10		= $_POST["searchIcon10"]			? $_POST["searchIcon10"]			: $_REQUEST["searchIcon10"];

	$strSearchShopNo		= $_POST["searchShopNo"]			? $_POST["searchShopNo"]			: $_REQUEST["searchShopNo"];

	$strC_HCODE1			= $_POST["cateHCode1"]				? $_POST["cateHCode1"]				: $_REQUEST["cateHCode1"];
	$strC_HCODE2			= $_POST["cateHCode2"]				? $_POST["cateHCode2"]				: $_REQUEST["cateHCode2"];
	$strC_HCODE3			= $_POST["cateHCode3"]				? $_POST["cateHCode3"]				: $_REQUEST["cateHCode3"];
	$strC_HCODE4			= $_POST["cateHCode4"]				? $_POST["cateHCode4"]				: $_REQUEST["cateHCode4"];

	// 2013.07.15 브랜드 검색 추가
	$strSearchProdBrand		= $_POST["searchProdBrand"]			? $_POST["searchProdBrand"]			: $_REQUEST["searchProdBrand"];
	
	//사업자 선택국가확인
	$strProdShopCountry		= $_POST["prodShopCountry"]			? $_POST['prodShopCountry']			: $_REQUEST['prodShopCountry'];

/** 2013.06.25 kim hee sung, $strStLng 으로 변경됨. **/
//	$strProdLng				= $_POST["prodLang"]				? $_POST["prodLang"]				: $_REQUEST["prodLang"];
//	if(!$strProdLng) { $strProdLng = $S_ST_LNG; }

	$aryUseLng = explode("/", $S_USE_LNG);
	for($i=0;$i<sizeof($aryUseLng);$i++){
		if ($aryUseLng[$i] == "KR") $strUseLngKr = "Y";
		if ($aryUseLng[$i] == "US") $strUseLngUs = "Y";
		if ($aryUseLng[$i] == "ID") $strUseLngId = "Y";
		if ($aryUseLng[$i] == "CN") $strUseLngCn = "Y";
		if ($aryUseLng[$i] == "JP") $strUseLngJp = "Y";
		if ($aryUseLng[$i] == "FR") $strUseLngFr = "Y";
	}

	/* 해외주문 사용시 변수 설정(스크립트 사용) */
	$strForWeightYN = "N";
	if ($strUseLngUs == "Y" || $strUseLngId == "Y" || $strUseLngCn == "Y" || $strUseLngJp == "Y" || $strUseLngFr == "Y"){
		$strForWeightYN = "Y";
	}

	if ($strSearchShopNo == "") $strSearchShopNo = "-1";

	/*국가*/
	
	/* 20150624 add 기본 설정 언어가 한국일때  입점사 나라 영어로 셋팅 */
	if($S_SITE_LNG == "KR"){
		$S_SITE_LNG = "US";
		$S_SITE_LNG_P = "KR";
	}
	$aryCountryList		= getCountryList();

	if($S_SITE_LNG_P == "KR"){
		$S_SITE_LNG = "KR";
		$S_SITE_LNG_P = "";
	}
	/*##################################### Parameter 셋팅 #####################################*/

	switch($strMode){
		case "prodList":
			//echo $strIncludePath.$aryIncludeFolder[$strMode]."/help.prodList.".$strProductVersion.".inc.php";exit;
			include $strIncludePath.$aryIncludeFolder[$strMode]."/help.prodList.".$strProductVersion.".inc.php";

		break;

		case "prodModify":
		case "prodAuctionModify":

			## 페이지 언어 설정
			$strLang = $_GET['lang'];
			if(!$strLang) { $strLang = $S_ST_LNG; }

			/* 관리자 Sub Menu 권한 설정 */
			$strLeftMenuCode01 = "001";
			$strLeftMenuCode02 = "001";
			/* 관리자 Sub Menu 권한 설정 */

			/* 언어 선택 */
			$productMgr->setP_LNG($strStLng);

			$cateMgr->setCL_LNG($strStLng);
			$cateMgr->setC_LEVEL(1);
			$cateMgr->setC_HCODE("");
			//$cateMgr->setC_VIEW_YN("Y");
			$aryCate01 = $cateMgr->getCateLevelAry($db);

			$productMgr->setP_CODE($strP_CODE);
			$prodRow = $productMgr->getProdView($db);

			$cateMgr->setC_LEVEL(2);
			$cateMgr->setC_HCODE(SUBSTR($prodRow[P_CATE],0,3));
			//$cateMgr->setC_VIEW_YN("Y");
			$aryCate02 = $cateMgr->getCateLevelAry($db);

			$cateMgr->setC_LEVEL(3);
			$cateMgr->setC_HCODE(SUBSTR($prodRow[P_CATE],0,6));
			//$cateMgr->setC_VIEW_YN("Y");
			$aryCate03 = $cateMgr->getCateLevelAry($db);

			$cateMgr->setC_LEVEL(4);
			$cateMgr->setC_HCODE(SUBSTR($prodRow[P_CATE],0,9));
			//$cateMgr->setC_VIEW_YN("Y");
			$aryCate04 = $cateMgr->getCateLevelAry($db);


			$aryProdItem = $productMgr->getProdItem($db);

			$productMgr->setPO_TYPE("O");
			$aryProdOpt = $productMgr->getProdOpt($db);

			if (is_array($aryProdOpt)){
				for($i=0;$i<sizeof($aryProdOpt);$i++){
					if ($aryProdOpt[$i][PO_NO] > 0){
						$productMgr->setPO_NO($aryProdOpt[$i][PO_NO]);
						$aryProdOpt[$i][OPT_ATTR] = $productMgr->getProdOptAttr($db);
					}

					$intProdOptAttrRowCnt = 0;
					for($j=1;$j<=10;$j++){

						if ($aryProdOpt[$i]["PO_NAME".$j]){

							$productMgr->setPOA_ATTR_GROUP($j);
							if (!$intProdOptAttrRowCnt) $intProdOptAttrRowCnt = $productMgr->getProdOptAttrGroupLimitCount($db);
							else {

								if ($productMgr->getProdOptAttrGroupLimitCount($db) > $intProdOptAttrRowCnt){
									$intProdOptAttrRowCnt = $productMgr->getProdOptAttrGroupLimitCount($db);
								}
							}

							$aryProdOptAttrLimit[$aryProdOpt[$i][PO_NO]][$j] = $productMgr->getProdOptAttrGroupLimitDetail($db);

							$strProdOptAttrVal = "";
							if (is_array($aryProdOptAttrLimit[$aryProdOpt[$i][PO_NO]][$j])){
								for($k=0;$k<sizeof($aryProdOptAttrLimit[$aryProdOpt[$i][PO_NO]][$j]);$k++){
									$strProdOptAttrVal .= $aryProdOptAttrLimit[$aryProdOpt[$i][PO_NO]][$j][$k][POA_ATTR].";";
								}

								$strProdOptAttrVal = SUBSTR($strProdOptAttrVal,0,STRLEN($strProdOptAttrVal)-1);
								$aryProdOpt[$i]["PO_NAME_VAL".$j] = $strProdOptAttrVal;
							}
						} else {
							$aryProdOptAttrLimit[$aryProdOpt[$i][PO_NO]][$j] = array();
						}
					}
				}

			} else {
				$aryProdOpt = array();
			}

			$productMgr->setPO_NO(0);
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

			$intProdUrlImgCnt = "0";
			for($i=1;$i<=28;$i++)
			{
				if ($i == 1) {
					$strProdImgType = "main";
				} else if ($i == 2){
					$strProdImgType = "list";
				} else if ($i == 3){
					$strProdImgType = "view";
				} else if ($i == 4){
					$strProdImgType = "large";
				} else if ($i == 5){
					$strProdImgType = "mobile_main";
				} else if ($i == 6){
					$strProdImgType = "mobile_view";
				}  else if ($i >= 7 && $i <= 17){
					$strProdImgType = "view".($i-5);
				} else if ($i >= 18 && $i <= 28){
					$strProdImgType = "large".($i-16);
				}

				$productMgr->setPM_TYPE($strProdImgType);
				$aryProdImg[$i] = $productMgr->getProdImg($db);

				if (is_array($aryProdImg[$i])){
					if (SUBSTR($aryProdImg[$i][0]['PM_REAL_NAME'],0,4) == "http") $intProdUrlImgCnt++;
				}
			}

			## 2013.09.04 kim hee sung 동영상 URL 부분 추가
			if($S_FIX_PROD_VIEW_MOVIE_FLAG == "Y"):
				$productMgr->setPM_TYPE("movie1");
				$aryProdMovie[0]	= $productMgr->getProdImg($db);
				$strProdMovieUrl1	= "";
				if (is_array($aryProdMovie[0])){
					$strProdMovieUrl1 = $aryProdMovie[0][0]['PM_REAL_NAME'];
				}
			endif;

			for($i=1;$i<=3;$i++)
			{
				$productMgr->setPM_TYPE("file".$i);
				$aryProdFile[$i] = $productMgr->getProdImg($db);
			}

			/*제조사*/
			$productMgr->setColumn("P_MAKER");
			$aryProductMaker = $productMgr->getProductColGroupList($db);

			/*원산지*/
			$productMgr->setColumn("P_ORIGIN");
			$aryProductOrigin = $productMgr->getProductColGroupList($db);

			/*모델명*/
			$productMgr->setColumn("P_MODEL");
			$aryProductModel = $productMgr->getProductColGroupList($db);

			/*브랜드*/
			$aryProdBrandList = $productMgr->getProdBrandList($db, "OP_ARYTOTAL");

			/*메인진열관리*/
			$cateMgr->setIC_TYPE("MAIN");
			$aryProdMainDisplayList = $cateMgr->getProdDisplayList($db);

			/*서브진열관리*/
			$cateMgr->setIC_TYPE("SUB");
			$aryProdSubDisplayList = $cateMgr->getProdDisplayList($db);

			/*ICON관리*/
			$cateMgr->setIC_TYPE("ICON");
			$aryProdIconDisplayList = $cateMgr->getProdDisplayList($db);

			$aryProdListIconList = explode("/",$prodRow[P_LIST_ICON]);

			/* 상품 관련 옵션(관련 상품 리스트) 2013.03.14 추가(heesung) */
			$aryProdGrpList = $productMgr->getProdGrpList($db);
//			print_r($aryProdGrpList);

			/** 2103.06.27 kim hee sung, 상점정보 **/
			//if($a_admin_type == "S"): // 입점몰인 경우.
				require_once MALL_CONF_LIB."ShopMgr.php";
				$shopMgr = new ShopMgr();

				//$shopMgr->setSH_NO($a_admin_shop_no);
				$shopMgr->setSH_NO($prodRow[P_SHOP_NO]);
				$shopInfo = $shopMgr->getShopView($db);
			//endif;

			## 공통관리 항목 리스트
			## 2013.11.08 kim hee sung 내용 작성

			## 모듈 설정
			require_once MALL_HOME . "/module2/SiteComm.module.php";
			$siteComm						= new SiteCommModule($db);

			## 공통관리 리스트
			$param							= "";
			$siteCommArray					= $siteComm->getSiteCommSelectEx("OP_ARYTOTAL", $param);

			## 수수료
			$intProdAccPrice	= $intProdAccRate = 0;
			$intProdAccRate		= getRoundUp((($prodRow['P_SALE_PRICE'] - $prodRow['P_STOCK_PRICE'])/$prodRow['P_SALE_PRICE']) * 100,0);
			$intProdAccPrice	= $prodRow['P_SALE_PRICE'] - $prodRow['P_STOCK_PRICE'];

				## 판매가 할인율
				$intProdDiscountRate	= 0;
				if ($S_FIX_PRODUCT_DISCOUNT_RATE_SHOW == "Y"){
					if($row[$key]['P_CONSUMER_PRICE'] > 0.00001){
					$intProdDiscountRate= getRoundUp((($row['P_CONSUMER_PRICE'] - $row['P_SALE_PRICE'])/$row['P_CONSUMER_PRICE']) * 100,0);
					$strProdDiscountRateText = "<strong class='discountRate'>".$intProdDiscountRate."</strong><span class='rateSign'>%</span>";
					}
				}			
			
			
			## 상품고시
			if($S_PRODUCT_NOTIFY_USE && $strLang == "KR"):
				$param						= "";
				$param['P_CODE']			= $strP_CODE;
				$intProdNoticySaveDataCnt   = $productMgr->getProdNotifySelectEx($db,$param,"OP_COUNT");
				$param['PN_SORT']			= "Y";
				$arrProdNotifySaveData		= $productMgr->getProdNotifySelectEx($db,$param,"OP_ARYTOTAL");
			endif;

			if ($strMode == "prodAuctionModify"){
				$includeFile = $strIncludePath.$aryIncludeFolder[$strMode]."/prodModify.php";
			}

		break;

		case "prodWrite":
		case "prodAuctionWrite":

			/* 관리자 Sub Menu 권한 설정 */
			$strLeftMenuCode01 = "001";
			$strLeftMenuCode02 = "002";
			/* 관리자 Sub Menu 권한 설정 */

			## 페이지 언어 설정
			$strLang = $_GET['lang'];


			/** 2103.06.27 kim hee sung, 상점정보 **/
			if($a_admin_type == "S"){ // 입점몰인 경우.
				require_once MALL_CONF_LIB."ShopMgr.php";
				$shopMgr = new ShopMgr();

				$shopMgr->setSH_NO($a_admin_shop_no);
				$shopInfo = $shopMgr->getShopView($db);
				//입점사 국가별 기본언어설정

				if(!$strLang){
					$strShopLng = $shopInfo[SH_COM_COUNTRY];
					if(eregi($strShopLng, $S_USE_LNG)){
						$strStLng = $strShopLng;
					}else{
						$strStLng = 'US';
					}
				}
			}
			
			if(!$strLang) { $strLang = $S_ST_LNG; }


			/* 언어 선택 */
			$productMgr->setP_LNG($strStLng);

			$cateMgr->setCL_LNG($strStLng);

			

			/*제조사*/
			$productMgr->setColumn("P_MAKER");
			$aryProductMaker = $productMgr->getProductColGroupList($db);

			/*원산지*/
			$productMgr->setColumn("P_ORIGIN");
			$aryProductOrigin = $productMgr->getProductColGroupList($db);

			/*모델명*/
			$productMgr->setColumn("P_MODEL");
			$aryProductModel = $productMgr->getProductColGroupList($db);

			/*브랜드*/
			$aryProdBrandList = $productMgr->getProdBrandList($db, "OP_ARYTOTAL");

			$siteRow = $siteMgr->getSiteInfo($db);

			/*메인진열관리*/
			$cateMgr->setIC_TYPE("MAIN");
			$aryProdMainDisplayList = $cateMgr->getProdDisplayList($db);

			/*서브진열관리*/
			$cateMgr->setIC_TYPE("SUB");
			$aryProdSubDisplayList = $cateMgr->getProdDisplayList($db);

			/*ICON관리*/
			$cateMgr->setIC_TYPE("ICON");
			$aryProdIconDisplayList = $cateMgr->getProdDisplayList($db);

			/** 2103.06.27 kim hee sung, 상점정보 **/
			if($a_admin_type == "S"): // 입점몰인 경우.
				require_once MALL_CONF_LIB."ShopMgr.php";
				$shopMgr = new ShopMgr();

				$shopMgr->setSH_NO($a_admin_shop_no);
				$shopInfo = $shopMgr->getShopView($db);
			endif;

			## 공통관리 항목 리스트
			## 2013.11.08 kim hee sung 내용 작성

			## 모듈 설정
			require_once MALL_HOME . "/module2/SiteComm.module.php";
			$siteComm						= new SiteCommModule($db);

			## 공통관리 리스트
			$param							= "";
			$siteCommArray					= $siteComm->getSiteCommSelectEx("OP_ARYTOTAL", $param);

			if ($strMode == "prodAuctionWrite"){
				$includeFile = $strIncludePath.$aryIncludeFolder[$strMode]."/prodWrite.php";
			}
		break;
	}

?>
