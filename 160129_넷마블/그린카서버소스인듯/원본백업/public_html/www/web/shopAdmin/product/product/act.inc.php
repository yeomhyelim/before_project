<?
	require_once MALL_CONF_LIB."CateMgr.php";
	require_once MALL_CONF_LIB."ProductAdmMgr.php";
	require_once MALL_CONF_LIB."SiteMgr.php";
	require_once MALL_CONF_LIB."MemberMgr.php";
	require_once MALL_CONF_LIB."DesignSetMgr.php";

	require_once "../conf/site_skin_product.conf.inc.php";
	require_once "../conf/category.inc.php";

	// 이미지 관련 함수.
	require_once "{$S_DOCUMENT_ROOT}www/classes/image/image.func.class.php";

	$cateMgr = new CateMgr();
	$productMgr = new ProductAdmMgr();
	$siteMgr = new SiteMgr();
	$memberMgr = new MemberMgr();
	$designSetMgr = new DesignSetMgr();
// print_r($_POST);exit;
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

/** 2013.06.25 kim hee sung, $strStLng 으로 변경됨. **/
//	$strProdLng				= $_POST["prodLang"]				? $_POST["prodLang"]				: $_REQUEST["prodLang"];

	$strP_NAME				= $_POST["prodName"]			? $_POST["prodName"]			: $_REQUEST["prodName"];
	$strP_CATE				= $strC_HCODE1.$strC_HCODE2.$strC_HCODE3.$strC_HCODE4;

	$strP_NUM				= $_POST["prodViewCode"]		? $_POST["prodViewCode"]		: $_REQUEST["prodViewCode"];
	$strP_MAKER				= $_POST["prodMake"]			? $_POST["prodMake"]			: $_REQUEST["prodMake"];
	$strP_ORIGIN			= $_POST["prodOrigin"]			? $_POST["prodOrigin"]			: $_REQUEST["prodOrigin"];
	$strP_BRAND				= $_POST["prodBrand"]			? $_POST["prodBrand"]			: $_REQUEST["prodBrand"];
	$strP_MODEL				= $_POST["prodModel"]			? $_POST["prodModel"]			: $_REQUEST["prodModel"];
	$strP_LAUNCH_DT			= $_POST["prodLaunchDt"]		? $_POST["prodLaunchDt"]		: $_REQUEST["prodLaunchDt"];
	$strP_WEB_VIEW			= $_POST["prodWebViewYN"]		? $_POST["prodWebViewYN"]		: $_REQUEST["prodWebViewYN"];
	$strP_MOB_VIEW			= $_POST["prodMobViewYN"]		? $_POST["prodMobViewYN"]		: $_REQUEST["prodMobViewYN"];
	$strP_REP_DT			= $_POST["prodRepDt"]			? $_POST["prodRepDt"]			: $_REQUEST["prodRepDt"];
	$intP_ORDER				= $_POST["prodOrder"]			? $_POST["prodOrder"]			: $_REQUEST["prodOrder"];

	$intP_SALE_PRICE		= $_POST["prodSalePrice"]		? $_POST["prodSalePrice"]		: $_REQUEST["prodSalePrice"];
	$intP_CONSUMER_PRICE	= $_POST["prodConsumerPrice"]	? $_POST["prodConsumerPrice"]	: $_REQUEST["prodConsumerPrice"];
	$intP_STOCK_PRICE		= $_POST["prodStockPrice"]		? $_POST["prodStockPrice"]		: $_REQUEST["prodStockPrice"];


	$strP_PRICE_FILTER		= $_POST["priceFilter"]			? $_POST["priceFilter"]			: $_REQUEST["priceFilter"];
	$strP_PRICE_UNIT		= $_POST["prodUnit"]			? $_POST["prodUnit"]			: $_REQUEST["prodUnit"];
	$strP_CAS_NO			= $_POST["prodCASNo"]			? $_POST["prodCASNo"]			: $_REQUEST["prodCASNo"];
	$strP_OTHER_NAMES		= $_POST["prodOtherNames"]		? $_POST["prodOtherNames"]		: $_REQUEST["prodOtherNames"];
	$strP_TYPE				= $_POST["prodType"]			? $_POST["prodType"]			: $_REQUEST["prodType"];


	$intP_POINT				= $_POST["prodPoint"]			? $_POST["prodPoint"]			: $_REQUEST["prodPoint"];
	$strP_POINT_TYPE		= $_POST["prodPointType"]		? $_POST["prodPointType"]		: $_REQUEST["prodPointType"];
	$strP_POINT_OFF1		= $_POST["prodPointOff1"]		? $_POST["prodPointOff1"]		: $_REQUEST["prodPointOff1"];
	$strP_POINT_OFF2		= $_POST["prodPointOff2"]		? $_POST["prodPointOff2"]		: $_REQUEST["prodPointOff2"];
	$strP_POINT_NO_USE		= $_POST["prodPointNoUse"]		? $_POST["prodPointNoUse"]		: $_REQUEST["prodPointNoUse"];

	$intP_QTY				= $_POST["prodQty"]				? $_POST["prodQty"]				: $_REQUEST["prodQty"];
	$strP_STOCK_OUT			= $_POST["prodStockOut"]		? $_POST["prodStockOut"]		: $_REQUEST["prodStockOut"];
	$strP_RESTOCK			= $_POST["prodReStock"]			? $_POST["prodReStock"]			: $_REQUEST["prodReStock"];
	$strP_STOCK_LIMIT		= $_POST["prodStockLimit"]		? $_POST["prodStockLimit"]		: $_REQUEST["prodStockLimit"];

	$intP_MIN_QTY			= $_POST["prodSaleMinQty"]		? $_POST["prodSaleMinQty"]		: $_REQUEST["prodSaleMinQty"];
	$intP_MAX_QTY			= $_POST["prodSaleMaxQty"]		? $_POST["prodSaleMaxQty"]		: $_REQUEST["prodSaleMaxQty"];
	$strP_SAIL_UNIT			= $_POST["prodSaleUnit"]		? $_POST["prodSaleUnit"]		: $_REQUEST["prodSaleUnit"];
	$strP_TAX				= $_POST["prodTax"]				? $_POST["prodTax"]				: $_REQUEST["prodTax"];
	$strP_PRICE_TEXT		= $_POST["prodReplaceText"]		? $_POST["prodReplaceText"]		: $_REQUEST["prodReplaceText"];

	$strP_OPT				= $_POST["prodOptType"]			? $_POST["prodOptType"]			: $_REQUEST["prodOptType"];
	$strP_ADD_OPT			= $_POST["prodAddOpt"]			? $_POST["prodAddOpt"]			: $_REQUEST["prodAddOpt"];
	$strP_BAESONG_TYPE		= $_POST["prodDelivery"]		? $_POST["prodDelivery"]		: $_REQUEST["prodDelivery"];
	$intP_BAESONG_PRICE		= $_POST["prodDeliveryPrice"]	? $_POST["prodDeliveryPrice"]	: $_REQUEST["prodDeliveryPrice"];

	$strP_SEARCH_TEXT		= $_POST["prodKeyWord"]			? $_POST["prodKeyWord"]			: $_REQUEST["prodKeyWord"];
	$strP_ETC				= $_POST["prodEtc"]				? $_POST["prodEtc"]				: $_REQUEST["prodEtc"];
	$strP_WEB_TEXT			= $_POST["prodWebText"]			? $_POST["prodWebText"]			: $_REQUEST["prodWebText"];
	$strP_MOB_TEXT			= $_POST["prodMobileText"]		? $_POST["prodMobileText"]		: $_REQUEST["prodMobileText"];
	$strP_DELIVERY_TEXT		= $_POST["prodDeliveryText"]	? $_POST["prodDeliveryText"]	: $_REQUEST["prodDeliveryText"];
	$strP_RETURN_TEXT		= $_POST["prodReturnText"]		? $_POST["prodReturnText"]		: $_REQUEST["prodReturnText"];
	$strP_MEMO				= $_POST["prodMemo"]			? $_POST["prodMemo"]			: $_REQUEST["prodMemo"];

	$strP_WEIGHT			= $_POST["prodWeight"]			? $_POST["prodWeight"]			: $_REQUEST["prodWeight"];
	$strP_SCR				= $_POST["p_scr"]				? $_POST["p_scr"]				: $_REQUEST["p_scr"];

	$strP_LIST_ICON_VIEW	= $_POST["prodListIconView"]		? $_POST["prodListIconView"]		: $_REQUEST["prodListIconView"];
	$strP_LIST_ICON_ST1		= $_POST["prodListIconStartDt"]		? $_POST["prodListIconStartDt"]		: $_REQUEST["prodListIconStartDt"];
	$strP_LIST_ICON_ST2		= $_POST["prodListIconStartHour"]	? $_POST["prodListIconStartHour"]	: $_REQUEST["prodListIconStartHour"];
	$strP_LIST_ICON_ST3		= $_POST["prodListIconStartMin"]	? $_POST["prodListIconStartMin"]	: $_REQUEST["prodListIconStartMin"];
	$strP_LIST_ICON_ST		= $strP_LIST_ICON_ST1." ".$strP_LIST_ICON_ST2.":".$strP_LIST_ICON_ST3.":00";

	$strP_LIST_ICON_ET1		= $_POST["prodListIconEndDt"]		? $_POST["prodListIconEndDt"]		: $_REQUEST["prodListIconEndDt"];
	$strP_LIST_ICON_ET2		= $_POST["prodListIconEndHour"]		? $_POST["prodListIconEndHour"]		: $_REQUEST["prodListIconEndHour"];
	$strP_LIST_ICON_ET3		= $_POST["prodListIconEndMin"]		? $_POST["prodListIconEndMin"]		: $_REQUEST["prodListIconEndMin"];
	$strP_LIST_ICON_ET		= $strP_LIST_ICON_ET1." ".$strP_LIST_ICON_ET2.":".$strP_LIST_ICON_ET3.":00";

	$intP_REG_NO			= $a_admin_no;
	$intP_MOD_NO			= $a_admin_no;

	/* 상품추가정보 */
	$aryProdItemNo			= $_POST["prodItemNo"]			? $_POST["prodItemNo"]			: $_REQUEST["prodItemNo"];
	$aryProdItem			= $_POST["prodItem"]			? $_POST["prodItem"]			: $_REQUEST["prodItem"];
	$aryProdItemText		= $_POST["prodItemText"]		? $_POST["prodItemText"]		: $_REQUEST["prodItemText"];
	$aryProdItemType		= $_POST["prodItemType"]		? $_POST["prodItemType"]		: $_REQUEST["prodItemType"];
	$aryProdItemUserType	= $_POST["prodItemUserType"]	? $_POST["prodItemUserType"]	: $_REQUEST["prodItemUserType"];

	/* 상품옵션관리 */
	$aryProdOptNo			= $_POST["prodOptNo"]			? $_POST["prodOptNo"]					: $_REQUEST["prodOptNo"];
	$strProdOptName1		= $_POST["prodOptName1"]		? $_POST["prodOptName1"]				: $_REQUEST["prodOptName1"];
	$strProdOptName2		= $_POST["prodOptName2"]		? $_POST["prodOptName2"]				: $_REQUEST["prodOptName2"];
	$strProdOptName3		= $_POST["prodOptName3"]		? $_POST["prodOptName3"]				: $_REQUEST["prodOptName3"];
	$strProdOptName4		= $_POST["prodOptName4"]		? $_POST["prodOptName4"]				: $_REQUEST["prodOptName4"];
	$strProdOptName5		= $_POST["prodOptName5"]		? $_POST["prodOptName5"]				: $_REQUEST["prodOptName5"];
	$strProdOptName6		= $_POST["prodOptName6"]		? $_POST["prodOptName6"]				: $_REQUEST["prodOptName6"];
	$strProdOptName7		= $_POST["prodOptName7"]		? $_POST["prodOptName7"]				: $_REQUEST["prodOptName7"];
	$strProdOptName8		= $_POST["prodOptName8"]		? $_POST["prodOptName8"]				: $_REQUEST["prodOptName8"];
	$strProdOptName9		= $_POST["prodOptName9"]		? $_POST["prodOptName9"]				: $_REQUEST["prodOptName9"];
	$strProdOptName10		= $_POST["prodOptName10"]		? $_POST["prodOptName10"]				: $_REQUEST["prodOptName10"];
	$strProdOptEss			= $_POST["prodOptEss"]			? $_POST["prodOptEss"]					: $_REQUEST["prodOptEss"];

	/* 상품추가옵션관리 */
	$aryProdAddOptNo		= $_POST["prodAddOptNo"]		? $_POST["prodAddOptNo"]				: $_REQUEST["prodAddOptNo"];
	$aryProdAddOptName		= $_POST["prodAddOptName"]		? $_POST["prodAddOptName"]				: $_REQUEST["prodAddOptName"];
	$aryProdAddOptChk		= $_POST["prodAddOptChk"]		? $_POST["prodAddOptChk"]				: $_REQUEST["prodAddOptChk"];

	//계속등록(화면유지)
	$strAutoReg				= $_POST["autoReg"]						? $_POST["autoReg"]					: $_REQUEST["autoReg"];

	//복사할 상품 등록
	$strP_COPY_CODE			= $_POST["prodCopyCode"]				? $_POST["prodCopyCode"]			: $_REQUEST["prodCopyCode"];

	/* 선택 */
	$aryChkNo				= $_POST["chkNo"]						? $_POST["chkNo"]					: $_REQUEST["chkNo"];

	/* 공유카테고리 번호 */
	$intPS_NO				= $_POST["ps_no"]						? $_POST["ps_no"]					: $_REQUEST["ps_no"];


	$stProdImgCopy			= $_POST['prodImgCopy']					? $_POST['prodImgCopy']				: $_REQUEST["prodImgCopy"];
	$strProdrelatedCodeList	= $_POST['prodrelatedCodeList']			? $_POST['prodrelatedCodeList']		: $_REQUEST['prodrelatedCodeList'];

	/* 이미지 URL 사용여부 */
	$strProdImgUrlYN		= $_POST["prodImgUrlYN"]				? $_POST['prodImgUrlYN']			: $_REQUEST['prodImgUrlYN'];

	/* 경매관리 */
	$strProdAucStDt			= $_POST["prodAucStDt"]					? $_POST['prodAucStDt']				: $_REQUEST['prodAucStDt'];
	$strProdAucStHour		= $_POST["prodAucStHour"]				? $_POST['prodAucStHour']			: $_REQUEST['prodAucStHour'];
	$strProdAucStMinute		= $_POST["prodAucStMinute"]				? $_POST['prodAucStMinute']			: $_REQUEST['prodAucStMinute'];
	$strProdAucEndDt		= $_POST["prodAucEndDt"]				? $_POST['prodAucEndDt']			: $_REQUEST['prodAucEndDt'];
	$strProdAucEndHour		= $_POST["prodAucEndHour"]				? $_POST['prodAucEndHour']			: $_REQUEST['prodAucEndHour'];
	$strProdAucEndMinute	= $_POST["prodAucEndMinute"]			? $_POST['prodAucEndMinute']		: $_REQUEST['prodAucEndMinute'];

	$intProdAucStPrice		= $_POST["prodAucStPrice"]				? $_POST['prodAucStPrice']			: $_REQUEST['prodAucStPrice'];
	$intProdAucRightPrice	= $_POST["prodAucRightPrice"]			? $_POST['prodAucRightPrice']		: $_REQUEST['prodAucRightPrice'];
	$strProdAucStatus		= $_POST["prodAucStatus"]				? $_POST['prodAucStatus']			: $_REQUEST['prodAucStatus'];

	//사업자 선택국가확인
	$strProdShopCountry		= $_POST["prodShopCountry"]				? $_POST['prodShopCountry']			: $_REQUEST['prodShopCountry'];


	/*##################################### Parameter 셋팅 #####################################*/

	$strP_CODE			= strTrim($strP_CODE,25);
	$strP_COPY_CODE		= strTrim($strP_COPY_CODE,25);

	$strP_NAME			= strTrim($strP_NAME,"");
	$strP_NUM			= strTrim($strP_NUM,20);
	$strP_MAKER			= strTrim($strP_MAKER,50);
	$strP_ORIGIN		= strTrim($strP_ORIGIN,50);
	$strP_BRAND			= strTrim($strP_BRAND,50);
	$strP_MODEL			= strTrim($strP_MODEL,50);
	$strP_WEB_VIEW		= strTrim($strP_WEB_VIEW,1);
	$strP_MOB_VIEW		= strTrim($strP_MOB_VIEW,1);
	$strP_POINT_TYPE	= strTrim($strP_POINT_TYPE,1);
	$strP_POINT_OFF1	= strTrim($strP_POINT_OFF1,1);
	$strP_POINT_OFF2	= strTrim($strP_POINT_OFF2,1);
	$strP_POINT_NO_USE	= strTrim($strP_POINT_NO_USE,1);
	$strP_STOCK_OUT		= strTrim($strP_STOCK_OUT,1);
	$strP_RESTOCK		= strTrim($strP_RESTOCK,1);
	$strP_STOCK_LIMIT	= strTrim($strP_STOCK_LIMIT,1);
	$strP_TAX			= strTrim($strP_TAX,1);
	$strP_PRICE_TEXT	= strTrim($strP_PRICE_TEXT,50);
	$strP_OPT			= strTrim($strP_OPT,1);
	$strP_ADD_OPT		= strTrim($strP_ADD_OPT,1);
	$strP_BAESONG_TYPE	= strTrim($strP_BAESONG_TYPE,1);
	$strP_SEARCH_TEXT	= strTrim($strP_SEARCH_TEXT,"",true);
	$strP_ETC			= strTrim($strP_ETC,"",true);
	$strP_WEB_TEXT		= strTrim($strP_WEB_TEXT,"");
	$strP_MOB_TEXT		= strTrim($strP_MOB_TEXT,"");
	$strP_DELIVERY_TEXT = strTrim($strP_DELIVERY_TEXT,"");
	$strP_RETURN_TEXT	= strTrim($strP_RETURN_TEXT,"");
	$strP_MEMO			= strTrim($strP_MEMO,"",true);

	$strP_SCR			= strTrim($strP_SCR,1);

	$strP_WEB_VIEW		= IM_IsBlank($strP_WEB_VIEW,"N");
	$strP_MOB_VIEW		= IM_IsBlank($strP_MOB_VIEW,"N");
	$strP_POINT_TYPE	= IM_IsBlank($strP_POINT_TYPE,"1");
	$strP_STOCK_OUT		= IM_IsBlank($strP_STOCK_OUT,"N");
	$strP_RESTOCK		= IM_IsBlank($strP_RESTOCK,"N");
	$strP_STOCK_LIMIT	= IM_IsBlank($strP_STOCK_LIMIT,"N");
	$strP_TAX			= IM_IsBlank($strP_TAX,"N");
	$strP_ADD_OPT		= IM_IsBlank($strP_ADD_OPT,"N");
	$strP_WEIGHT		= IM_IsBlank($strP_WEIGHT,"0");
	$strP_POINT_NO_USE	= IM_IsBlank($strP_POINT_NO_USE,"N");



	$strP_CATE			= $strC_HCODE1;
	if ($strC_HCODE2) $strP_CATE .= $strC_HCODE2;
	else $strP_CATE .= "000";

	if ($strC_HCODE3) $strP_CATE .= $strC_HCODE3;
	else $strP_CATE .= "000";

	if ($strC_HCODE4) $strP_CATE .= $strC_HCODE4;
	else $strP_CATE .= "000";

	if ($strP_BAESONG_TYPE == "1" || $strP_BAESONG_TYPE == "2"){
		$intP_BAESONG_PRICE = 0;
	}

	## 다국어출력사용여부일때 웹/모바일 함께 사용
	if ($S_PROD_MANY_LANG_VIEW == "Y"){
		//$strP_MOB_VIEW = $strP_WEB_VIEW;
	}


	if($S_MALL_TYPE == "M"):
		$intShopNo = $a_admin_shop_no;
		if(!$intShopNo) { $intShopNo = 1; }
		$productMgr->setP_SHOP_NO($intShopNo);
	endif;
//	$productMgr->setP_SHOP_NO($a_admin_shop_no);
	$productMgr->setP_CODE($strP_CODE);
	$productMgr->setP_COPY_CODE($strP_COPY_CODE);
	$productMgr->setP_NAME($strP_NAME);
	$productMgr->setP_CATE($strP_CATE);
	$productMgr->setP_NUM($strP_NUM);
	$productMgr->setP_MAKER($strP_MAKER);
	$productMgr->setP_ORIGIN($strP_ORIGIN);
	$productMgr->setP_BRAND($strP_BRAND);
	$productMgr->setP_MODEL($strP_MODEL);
	$productMgr->setP_LAUNCH_DT($strP_LAUNCH_DT);
	$productMgr->setP_WEB_VIEW($strP_WEB_VIEW);
	$productMgr->setP_MOB_VIEW($strP_MOB_VIEW);
	$productMgr->setP_REP_DT($strP_REP_DT);
	$productMgr->setP_ORDER($intP_ORDER);
	$productMgr->setP_SALE_PRICE($intP_SALE_PRICE);
	$productMgr->setP_CONSUMER_PRICE($intP_CONSUMER_PRICE);
	$productMgr->setP_STOCK_PRICE($intP_STOCK_PRICE);

	$productMgr->setP_PRICE_FILTER($strP_PRICE_FILTER);
	$productMgr->setP_PRICE_UNIT($strP_PRICE_UNIT);
	$productMgr->setP_CAS_NO($strP_CAS_NO);
	$productMgr->setP_OTHER_NAMES($strP_OTHER_NAMES);
	$productMgr->setP_TYPE($strP_TYPE);

	$productMgr->setP_POINT($intP_POINT);
	$productMgr->setP_POINT_TYPE($strP_POINT_TYPE);
	$productMgr->setP_POINT_OFF1($strP_POINT_OFF1);
	$productMgr->setP_POINT_OFF2($strP_POINT_OFF2);
	$productMgr->setP_QTY($intP_QTY);
	$productMgr->setP_STOCK_OUT($strP_STOCK_OUT);
	$productMgr->setP_RESTOCK($strP_RESTOCK);
	$productMgr->setP_STOCK_LIMIT($strP_STOCK_LIMIT);
	$productMgr->setP_MIN_QTY($intP_MIN_QTY);
	$productMgr->setP_MAX_QTY($intP_MAX_QTY);
	$productMgr->setP_TAX($strP_TAX);
	$productMgr->setP_PRICE_TEXT($strP_PRICE_TEXT);
	$productMgr->setP_OPT($strP_OPT);
	$productMgr->setP_ADD_OPT($strP_ADD_OPT);
	$productMgr->setP_BAESONG_TYPE($strP_BAESONG_TYPE);
	$productMgr->setP_BAESONG_PRICE($intP_BAESONG_PRICE);
	$productMgr->setP_SEARCH_TEXT($strP_SEARCH_TEXT);
	$productMgr->setP_ETC($strP_ETC);
	$productMgr->setP_WEB_TEXT($strP_WEB_TEXT);
	$productMgr->setP_MOB_TEXT($strP_MOB_TEXT);
	$productMgr->setP_DELIVERY_TEXT($strP_DELIVERY_TEXT);
	$productMgr->setP_RETURN_TEXT($strP_RETURN_TEXT);
	$productMgr->setP_MEMO($strP_MEMO);
	$productMgr->setP_SCR($strP_SCR	);
	$productMgr->setP_WEIGHT($strP_WEIGHT);
	$productMgr->setP_ST_SIZE("");
	$productMgr->setP_LIST_ICON_VIEW($strP_LIST_ICON_VIEW);
	$productMgr->setP_LIST_ICON_ST($strP_LIST_ICON_ST);
	$productMgr->setP_LIST_ICON_ET($strP_LIST_ICON_ET);
	$productMgr->setP_POINT_NO_USE($strP_POINT_NO_USE);
	$productMgr->setP_REG_NO($a_admin_no);
	$productMgr->setP_MOD_NO($a_admin_no);
	$productMgr->setP_SAIL_UNIT($strP_SAIL_UNIT);


	//언어별 상품 등록순서 2015.05.13
	$aryRollCountry = array();
	$aryRollCountry['KR'] = array('KR', 'US', 'CN');
	$aryRollCountry['US'] = array('US', 'CN', 'KR');
	$aryRollCountry['CN'] = array('CN', 'US', 'KR');

	/*##################################### PRODUCT    #####################################*/

	$strLinkPage = "";
	switch ($strAct) {
		case "prodWrite":
		case "prodAuctionWrite":

			## 언어설정
			$strLang = $_POST['lang'];
			if (!$strLang) {
				$strLang = $strStLng;
			}

			/** 2103.06.27 kim hee sung, 상점정보 **/
			/** 설명 : 입점몰 상품 등록시 승인이 필요한 경우, 수정을 하면, 미승인 상태로 변경이 됩니다.(정훈씨 요청) **/
			// 입점몰인 경우.
			if ($a_admin_type == "S") {
				require_once MALL_CONF_LIB . "ShopMgr.php";
				$shopMgr = new ShopMgr();

				$shopMgr->setSH_NO($a_admin_shop_no);
				$shopInfo = $shopMgr->getShopView($db);

				// 바로노출 입점사인경우
				if ($shopInfo['SH_COM_PROD_AUTH'] == "Y") {
					$productMgr->setP_WEB_VIEW("Y");
					$productMgr->setP_MOB_VIEW("Y");
					$productMgr->setP_APPR("Y");
				}

				//입점사가 상품 포인트 입력 금지
				if ($S_FIX_MALL_PROD_POINT_INSERT == "N") {
					$productMgr->setP_POINT(0);
				}
			} else if ($a_admin_type == "A") {
				$productMgr->setP_WEB_VIEW("Y");
				$productMgr->setP_MOB_VIEW("Y");
				$productMgr->setP_APPR("Y");
			}

			// 입점몰인 경우.
			// print_r($productMgr);
			//echo $a_admin_level;
			//echo ":::";
			//echo $shopInfo['SH_COM_PROD_AUTH'];
//exit;
			/* 상품 코드 생성 */
			$strP_CODE = $productMgr->getProductCode($db);
			$productMgr->setP_CODE($strP_CODE);

			/** 2013.04.26 가격대체문구 데이터 업데이트 부분 추가 **/
			$productMgr->getProdPriceTextUpdate($db);

			/* 상품 기본정보 INSERT */
			$productMgr->getProdInsert($db);

			/* 상품 관련 옵션(관련 상품 등록) 2013.03.14 추가(heesung) */
			if ($strProdrelatedCodeList):
				$aryRelated = explode(",", $strProdrelatedCodeList);
				foreach ($aryRelated as $code):
					$productMgr->setPG_P_CODE($code);
					$productMgr->getProdGrpInsert($db);
				endforeach;
			endif;

			/* 상품 기본정보 언어별 INSERT */
			for ($j = 0; $j < sizeof($arySiteUseLng); $j++) {
				if ($arySiteUseLng[$j]) {
					$productMgr->setP_LNG($arySiteUseLng[$j]);
					$productMgr->getProdInfoInsert($db);
				}
			}

			## 상품다국어출력여부사용
			/*if ($S_PROD_MANY_LANG_VIEW == "Y"){
				for($j=0;$j<sizeof($arySiteUseLng);$j++){
					if ($arySiteUseLng[$j]){
						$productMgr->setP_LNG($arySiteUseLng[$j]);
						$productMgr->getProdInfoViewUpdate($db);
					}
				}
			}*/
			//상품다국어출력 조건이 다양하여 추가 2015.05.13
			if ($S_PROD_MANY_LANG_VIEW == "Y") {
				if ($strProdShopCountry == 'US' || $strProdShopCountry == 'CN')//입점사가 미국과 중국일때
				{
					if ($strStLng == 'KR') {
						$productMgr->setP_WEB_VIEW("N");
						$productMgr->setP_MOB_VIEW("N");
						$productMgr->setP_LNG('US');
						$productMgr->getProdInfoViewUpdate($db);
						$productMgr->setP_LNG('CN');
						$productMgr->getProdInfoViewUpdate($db);

						$productMgr->setP_WEB_VIEW("Y");
						$productMgr->setP_MOB_VIEW("Y");
						$productMgr->setP_LNG('KR');
						$productMgr->getProdInfoViewUpdate($db);


					} elseif ($strStLng == 'US') {
						$productMgr->setP_WEB_VIEW("N");
						$productMgr->setP_MOB_VIEW("N");
						$productMgr->setP_LNG('CN');
						$productMgr->getProdInfoViewUpdate($db);

						$productMgr->setP_WEB_VIEW("Y");
						$productMgr->setP_MOB_VIEW("Y");
						$productMgr->setP_LNG('KR');
						$productMgr->getProdInfoViewUpdate($db);
						$productMgr->setP_LNG('US');
						$productMgr->getProdInfoViewUpdate($db);
					} elseif ($strStLng == 'CN') {
						$productMgr->setP_WEB_VIEW("N");
						$productMgr->setP_MOB_VIEW("N");
						$productMgr->setP_LNG('US');
						$productMgr->getProdInfoViewUpdate($db);
						$productMgr->setP_LNG('KR');
						$productMgr->getProdInfoViewUpdate($db);

						$productMgr->setP_WEB_VIEW("Y");
						$productMgr->setP_MOB_VIEW("Y");
						$productMgr->setP_LNG('CN');
						$productMgr->getProdInfoViewUpdate($db);
					}
				} elseif ($strProdShopCountry == 'KR') //입점사가 한국일때
				{
					if ($strStLng == 'KR') {
						$productMgr->setP_WEB_VIEW("N");
						$productMgr->setP_MOB_VIEW("N");
						$productMgr->setP_LNG('US');
						$productMgr->getProdInfoViewUpdate($db);
						$productMgr->setP_LNG('CN');
						$productMgr->getProdInfoViewUpdate($db);

						$productMgr->setP_WEB_VIEW("Y");
						$productMgr->setP_MOB_VIEW("Y");
						$productMgr->setP_LNG('KR');
						$productMgr->getProdInfoViewUpdate($db);
					} elseif ($strStLng == 'US') {
						$productMgr->setP_WEB_VIEW("N");
						$productMgr->setP_MOB_VIEW("N");
						$productMgr->setP_LNG('KR');
						$productMgr->getProdInfoViewUpdate($db);
						$productMgr->setP_LNG('CN');
						$productMgr->getProdInfoViewUpdate($db);

						$productMgr->setP_WEB_VIEW("Y");
						$productMgr->setP_MOB_VIEW("Y");
						$productMgr->setP_LNG('US');
						$productMgr->getProdInfoViewUpdate($db);
					} elseif ($strStLng == 'CN') {
						$productMgr->setP_WEB_VIEW("N");
						$productMgr->setP_MOB_VIEW("N");
						$productMgr->setP_LNG('US');
						$productMgr->getProdInfoViewUpdate($db);
						$productMgr->setP_LNG('KR');
						$productMgr->getProdInfoViewUpdate($db);

						$productMgr->setP_WEB_VIEW("Y");
						$productMgr->setP_MOB_VIEW("Y");
						$productMgr->setP_LNG('CN');
						$productMgr->getProdInfoViewUpdate($db);
					}
				}
			}

			/* 상품 항목추가 INSERT */
			if (is_array($aryProdItem)) {

				for ($i = 0; $i < sizeof($aryProdItem); $i++) {

					$strPI_NAME = $aryProdItem[$i];
					$strPI_TEXT = $aryProdItemText[$i];
					$strPI_TYPE = $aryProdItemType[$i];
					$strPI_USER_TYPE = $aryProdItemUserType[$i];
					if ($strPI_TYPE == "U") $strPI_TYPE = $strPI_USER_TYPE;

					$strPI_NAME = strTrim($strPI_NAME, 50);
					$strPI_TEXT = strTrim($strPI_TEXT, 100);
					$intPI_ORDER = $i + 1;

					if ($strPI_NAME) {

						$paramItemData = "";
						$paramItemData['PI_TYPE'] = $strPI_TYPE;
						$productMgr->setPI_ORDER($intPI_ORDER);
						$productMgr->getProdItemInsert($db, $paramItemData);

						$intPI_NO = $db->getLastInsertID();
						$productMgr->setPI_NO($intPI_NO);

						/* 언어별 INSERT */
						for ($j = 0; $j < sizeof($arySiteUseLng); $j++) {
							if ($arySiteUseLng[$j]) {

								$productMgr->setPI_LNG($arySiteUseLng[$j]);
								$productMgr->setPI_NAME($strPI_NAME);
								$productMgr->setPI_TEXT($strPI_TEXT);
								$productMgr->getProdItemLngInsert($db);
							}
						}
					}
				}
			}

			/* 상품 옵션추가 INSERT */
			if ($strProdOptName1) {

				$strPO_TYPE = "O";
				if (!$strProdOptEss) $strProdOptEss = "N";

				$productMgr->setPO_NAME1($strProdOptName1);
				$productMgr->setPO_NAME2($strProdOptName2);
				$productMgr->setPO_NAME3($strProdOptName3);
				$productMgr->setPO_NAME4($strProdOptName4);
				$productMgr->setPO_NAME5($strProdOptName5);
				$productMgr->setPO_NAME6($strProdOptName5);
				$productMgr->setPO_NAME7($strProdOptName7);
				$productMgr->setPO_NAME8($strProdOptName8);
				$productMgr->setPO_NAME9($strProdOptName9);
				$productMgr->setPO_NAME10($strProdOptName10);
				$productMgr->setPO_TYPE($strPO_TYPE);
				$productMgr->setPO_ESS($strProdOptEss);

				$productMgr->getProdOptInsert($db);
				$intPO_NO = $db->getLastInsertID();
				$productMgr->setPO_NO($intPO_NO);

				/* 상품옵션속성 등록 */
				if ($intPO_NO > 0) {
					/* 언어별 INSERT */
					for ($j = 0; $j < sizeof($arySiteUseLng); $j++) {
						if ($arySiteUseLng[$j]) {
							$productMgr->setP_LNG($arySiteUseLng[$j]);
							$productMgr->getProdOptLngInsert($db);
						}
					}

					$intAttrNo = 1;
					$strProdOptAttrVal1 = "prodOptAttrVal" . $intAttrNo . "_1";
					$strProdOptAttrVal2 = "prodOptAttrVal" . $intAttrNo . "_2";
					$strProdOptAttrVal3 = "prodOptAttrVal" . $intAttrNo . "_3";
					$strProdOptAttrVal4 = "prodOptAttrVal" . $intAttrNo . "_4";
					$strProdOptAttrVal5 = "prodOptAttrVal" . $intAttrNo . "_5";
					$strProdOptAttrVal6 = "prodOptAttrVal" . $intAttrNo . "_6";
					$strProdOptAttrVal7 = "prodOptAttrVal" . $intAttrNo . "_7";
					$strProdOptAttrVal8 = "prodOptAttrVal" . $intAttrNo . "_8";
					$strProdOptAttrVal9 = "prodOptAttrVal" . $intAttrNo . "_9";
					$strProdOptAttrVal10 = "prodOptAttrVal" . $intAttrNo . "_10";
					$strProdOptAttrSalePrice = "prodOptAttrSalePrice" . $intAttrNo;
					$strProdOptAttrConsumerPrice = "prodOptAttrConsumerPrice" . $intAttrNo;
					$strProdOptAttrStockPrice = "prodOptAttrStockPrice" . $intAttrNo;
					$strProdOptAttrPoint = "prodOptAttrPoint" . $intAttrNo;
					$strProdOptAttrQty = "prodOptAttrQty" . $intAttrNo;

					$aryProdOptAttrVal1 = $_POST[$strProdOptAttrVal1] ? $_POST[$strProdOptAttrVal1] : $_REQUEST[$strProdOptAttrVal1];
					$aryProdOptAttrVal2 = $_POST[$strProdOptAttrVal2] ? $_POST[$strProdOptAttrVal2] : $_REQUEST[$strProdOptAttrVal2];
					$aryProdOptAttrVal3 = $_POST[$strProdOptAttrVal3] ? $_POST[$strProdOptAttrVal3] : $_REQUEST[$strProdOptAttrVal3];
					$aryProdOptAttrVal4 = $_POST[$strProdOptAttrVal4] ? $_POST[$strProdOptAttrVal4] : $_REQUEST[$strProdOptAttrVal4];
					$aryProdOptAttrVal5 = $_POST[$strProdOptAttrVal5] ? $_POST[$strProdOptAttrVal5] : $_REQUEST[$strProdOptAttrVal5];
					$aryProdOptAttrVal6 = $_POST[$strProdOptAttrVal6] ? $_POST[$strProdOptAttrVal6] : $_REQUEST[$strProdOptAttrVal6];
					$aryProdOptAttrVal7 = $_POST[$strProdOptAttrVal7] ? $_POST[$strProdOptAttrVal7] : $_REQUEST[$strProdOptAttrVal7];
					$aryProdOptAttrVal8 = $_POST[$strProdOptAttrVal8] ? $_POST[$strProdOptAttrVal8] : $_REQUEST[$strProdOptAttrVal8];
					$aryProdOptAttrVal9 = $_POST[$strProdOptAttrVal9] ? $_POST[$strProdOptAttrVal9] : $_REQUEST[$strProdOptAttrVal9];
					$aryProdOptAttrVal10 = $_POST[$strProdOptAttrVal10] ? $_POST[$strProdOptAttrVal10] : $_REQUEST[$strProdOptAttrVal10];
					$aryProdOptAttrSalePrice = $_POST[$strProdOptAttrSalePrice] ? $_POST[$strProdOptAttrSalePrice] : $_REQUEST[$strProdOptAttrSalePrice];
					$aryProdOptAttrConsumerPrice = $_POST[$strProdOptAttrConsumerPrice] ? $_POST[$strProdOptAttrConsumerPrice] : $_REQUEST[$strProdOptAttrConsumerPrice];
					$aryProdOptAttrStockPrice = $_POST[$strProdOptAttrStockPrice] ? $_POST[$strProdOptAttrStockPrice] : $_REQUEST[$strProdOptAttrStockPrice];
					$aryProdOptAttrPoint = $_POST[$strProdOptAttrPoint] ? $_POST[$strProdOptAttrPoint] : $_REQUEST[$strProdOptAttrPoint];
					$aryProdOptAttrQty = $_POST[$strProdOptAttrQty] ? $_POST[$strProdOptAttrQty] : $_REQUEST[$strProdOptAttrQty];


					if (is_array($aryProdOptAttrVal1)) {
						for ($j = 0; $j < sizeof($aryProdOptAttrVal1); $j++) {

							if ($strP_OPT == "1") {
								//다중가격사용안함
								$aryProdOptAttrSalePrice[$j] = 0;
								$aryProdOptAttrConsumerPrice[$j] = 0;
								$aryProdOptAttrStockPrice[$j] = 0;
								$aryProdOptAttrPoint[$j] = 0;
							}

							if (!$aryProdOptAttrSalePrice[$j]) $aryProdOptAttrSalePrice[$j] = 0;
							if (!$aryProdOptAttrConsumerPrice[$j]) $aryProdOptAttrConsumerPrice[$j] = 0;
							if (!$aryProdOptAttrStockPrice[$j]) $aryProdOptAttrStockPrice[$j] = 0;
							if (!$aryProdOptAttrPoint[$j]) $aryProdOptAttrPoint[$j] = 0;
							if (!$aryProdOptAttrQty[$j]) $aryProdOptAttrQty[$j] = 0;

							$productMgr->setPOA_ATTR1($aryProdOptAttrVal1[$j]);
							$productMgr->setPOA_ATTR2($aryProdOptAttrVal2[$j]);
							$productMgr->setPOA_ATTR3($aryProdOptAttrVal3[$j]);
							$productMgr->setPOA_ATTR4($aryProdOptAttrVal4[$j]);
							$productMgr->setPOA_ATTR5($aryProdOptAttrVal5[$j]);
							$productMgr->setPOA_ATTR6($aryProdOptAttrVal6[$j]);
							$productMgr->setPOA_ATTR7($aryProdOptAttrVal7[$j]);
							$productMgr->setPOA_ATTR8($aryProdOptAttrVal8[$j]);
							$productMgr->setPOA_ATTR9($aryProdOptAttrVal9[$j]);
							$productMgr->setPOA_ATTR10($aryProdOptAttrVal10[$j]);
							$productMgr->setPOA_SALE_PRICE($aryProdOptAttrSalePrice[$j]);
							$productMgr->setPOA_CONSUMER_PRICE($aryProdOptAttrConsumerPrice[$j]);
							$productMgr->setPOA_STOCK_PRICE($aryProdOptAttrStockPrice[$j]);
							$productMgr->setPOA_POINT($aryProdOptAttrPoint[$j]);
							$productMgr->setPOA_STOCK_QTY($aryProdOptAttrQty[$j]);
							$productMgr->getProdOptAttrInsert($db);
							$intPOA_NO = $db->getLastInsertID();
							$productMgr->setPOA_NO($intPOA_NO);

							/* 언어별 INSERT */
							for ($k = 0; $k < sizeof($arySiteUseLng); $k++) {
								if ($arySiteUseLng[$k]) {
									$productMgr->setP_LNG($arySiteUseLng[$k]);
									$productMgr->getProdOptAttrLngInsert($db);
								}
							}
						}
					}
				}
			}

			/* 상품 추가옵션추가 INSERT */
			if (($S_MALL_TYPE == "R") || ($S_MALL_TYPE == "M" && $S_PRODUCT_ADD_OPT_USE == "Y")) {
				if ($strP_ADD_OPT == "Y") {
					if (is_array($aryProdAddOptName)) {
						for ($i = 0; $i < sizeof($aryProdAddOptName); $i++) {

							$strAddOptNAME = $aryProdAddOptName[$i];
							$strPO_TYPE = "A";
							$strAddOptChk = $aryProdAddOptChk[$i];

							if (!$strAddOptChk) $strAddOptChk = "N";

							if ($strAddOptNAME) {
								$productMgr->setPO_NAME1($strAddOptNAME);
								$productMgr->setPO_NAME2("");
								$productMgr->setPO_NAME3("");
								$productMgr->setPO_NAME4("");
								$productMgr->setPO_NAME5("");
								$productMgr->setPO_NAME6("");
								$productMgr->setPO_NAME7("");
								$productMgr->setPO_NAME8("");
								$productMgr->setPO_NAME9("");
								$productMgr->setPO_NAME10("");
								$productMgr->setPO_TYPE($strPO_TYPE);
								$productMgr->setPO_ESS($strAddOptChk);
								$productMgr->getProdOptInsert($db);
								$intPO_NO = $db->getLastInsertID();
								$productMgr->setPO_NO($intPO_NO);

								if ($intPO_NO > 0) {

									/* 언어별 INSERT */
									for ($j = 0; $j < sizeof($arySiteUseLng); $j++) {
										if ($arySiteUseLng[$j]) {
											$productMgr->setP_LNG($arySiteUseLng[$j]);
											$productMgr->getProdOptLngInsert($db);
										}
									}

									$intAddOptNo = $i + 1;

									$strProdAddOptVal = "prodAddOptVal" . $intAddOptNo;
									$strProdAddOptPrice = "prodAddOptPrice" . $intAddOptNo;

									$aryProdAddOptVal = $_POST[$strProdAddOptVal] ? $_POST[$strProdAddOptVal] : $_REQUEST[$strProdAddOptVal];
									$aryProdAddOptPrice = $_POST[$strProdAddOptPrice] ? $_POST[$strProdAddOptPrice] : $_REQUEST[$strProdAddOptPrice];

									if (is_array($aryProdAddOptVal)) {
										for ($j = 0; $j < sizeof($aryProdAddOptVal); $j++) {

											if (!$aryProdAddOptVal[$j]) $aryProdAddOptVal[$j] = "";
											if (!$aryProdAddOptPrice[$j]) $aryProdAddOptPrice[$j] = 0;

											$productMgr->setPAO_NAME($aryProdAddOptVal[$j]);
											$productMgr->setPAO_PRICE($aryProdAddOptPrice[$j]);
											$productMgr->getProdAddOptInsert($db);
											$intPAO_NO = $db->getLastInsertID();
											$productMgr->setPAO_NO($intPAO_NO);

											/* 언어별 INSERT */
											for ($k = 0; $k < sizeof($arySiteUseLng); $k++) {
												if ($arySiteUseLng[$k]) {
													$productMgr->setP_LNG($arySiteUseLng[$k]);
													$productMgr->getProdAddOptLngInsert($db);
												}
											}

										}
									}
								}
							}

						}
					}
				}
			}

			/* 상품 이미지 INSERT */
			if ($strProdImgUrlYN == "Y") {

				for ($i = 1; $i <= 28; $i++) {
					if ($i == 1) {
						$strProdImgType = "main";
					} else if ($i == 2) {
						$strProdImgType = "list";
					} else if ($i == 3) {
						$strProdImgType = "view";
					} else if ($i == 4) {
						$strProdImgType = "large";        // 확대이미지
						$fresTemp = $fres;
					} else if ($i == 5) {
						$strProdImgType = "mobile_main";
					} else if ($i == 6) {
						$strProdImgType = "mobile_view";
					} else if ($i >= 7 && $i <= 17) {
						$strProdImgType = "view" . ($i - 5);
					} else if ($i >= 18 && $i <= 28) {
						$strProdImgType = "large" . ($i - 16);
					}

					$productMgr->setPM_TYPE($strProdImgType);
					$productMgr->setPM_SAVE_NAME("");
					$productMgr->setPM_REAL_NAME($_POST["prodUrlImg" . $i]);
					$productMgr->getProdImgInsert($db);
				}

			} else {
				$prodImgMakeFolderResult = getMakeFolder("product", substr($strP_CODE, 0, 8));
				if ($prodImgMakeFolderResult) {

					$strProductImgPath = "upload/product/" . substr($strP_CODE, 0, 8);
					for ($i = 1; $i <= 28; $i++) {

						if ($_FILES["prodImg" . $i][name]) {

							if (!getAllowImgFileExt($_FILES["prodImg" . $i][name])) {

								if ($strAct == "prodTempWrite") {
									$db->disConnect($LNG_TRANS_CHAR["CS00009"]);//첨부하신 파일은 확장자가 금지된 파일입니다.
									goClose();
									exit;
								}
								goErrMsg($LNG_TRANS_CHAR["CS00009"]);
								exit;
							}

							$strFileName = $_FILES["prodImg" . $i][name];
							$strFileTmpName = $_FILES["prodImg" . $i][tmp_name];
							$intFileSize = $_FILES["prodImg" . $i][size];
							$strFileType = $_FILES["prodImg" . $i][type];

							$fres = $fh->doUpload($strP_CODE, "../" . $strProductImgPath . "/prodImg" . $i, $strFileName, $strFileTmpName, $intFileSize, $strFileType);

							if ($fres) {

								if ($i == 1) {
									$strProdImgType = "main";
								} else if ($i == 2) {
									$strProdImgType = "list";
								} else if ($i == 3) {
									$strProdImgType = "view";
								} else if ($i == 4) {
									$strProdImgType = "large";        // 확대이미지
									$fresTemp = $fres;
								} else if ($i == 5) {
									$strProdImgType = "mobile_main";
								} else if ($i == 6) {
									$strProdImgType = "mobile_view";
								} else if ($i >= 7 && $i <= 17) {
									$strProdImgType = "view" . ($i - 5);
								} else if ($i >= 18 && $i <= 28) {
									$strProdImgType = "large" . ($i - 16);
								}

								/* 상세이미지 추가 리사이징 2015.05.28 */
								if ($i >= 7 && $i <= 17):
									$imageResize = new ImageFunc();
									$aryProdImg = array("view" . ($i - 5) => $i);
									$arySizeW = array("view" . ($i - 5) => $S_PRODLIST_IMG_SIZE_W);
									$arySizeH = array("view" . ($i - 5) => $S_PRODLIST_IMG_SIZE_H);
									$url1Org = "/" . $strProductImgPath . "/prodImg" . $i . "/" . $fres[file_real_name];
									$url1 = "/" . $strProductImgPath . "/prodImg" . $i . "/temp_" . $fres[file_real_name];
									copy("{$S_DOCUMENT_ROOT}{$S_SHOP_HOME}{$url1Org}", "{$S_DOCUMENT_ROOT}{$S_SHOP_HOME}{$url1}");
									foreach ($aryProdImg as $key => $val):
										// $url2				= "/{$strProductImgPath}/prodImg{$val}/{$fresTemp['file_real_name']}";
										$url2 = "/" . $strProductImgPath . "/prodImg" . $i . "/" . $fres[file_real_name];
										//					$copyRe				= copy("{$S_DOCUMENT_ROOT}{$S_SHOP_HOME}{$url1}", "{$S_DOCUMENT_ROOT}{$S_SHOP_HOME}/{$url2}");
										$copyRe = $imageResize->getImageResize("{$S_DOCUMENT_ROOT}{$S_SHOP_HOME}{$url1}", "{$S_DOCUMENT_ROOT}{$S_SHOP_HOME}/{$url2}", $arySizeW[$key], $arySizeH[$key]);
										@chmod("{$S_DOCUMENT_ROOT}{$S_SHOP_HOME}{$url2}", 0707);
										if ($copyRe):
											$productMgr->setPM_TYPE($key);
											$productMgr->setPM_SAVE_NAME($fres[file_real_name]);
											$productMgr->setPM_REAL_NAME($url2);
											$productMgr->getProdImgInsert($db);
										endif;
									endforeach;
									unlink("{$S_DOCUMENT_ROOT}{$S_SHOP_HOME}{$url1}");
								endif;
								/* 상세이미지 추가 리사이징 */

								/*
								$productMgr->setPM_TYPE($strProdImgType);
								$productMgr->setPM_SAVE_NAME($strFileName);
								$productMgr->setPM_REAL_NAME("/".$strProductImgPath."/prodImg".$i."/".$fres[file_real_name]);
								$productMgr->getProdImgInsert($db);
								*/
							}
						}
					}
				}

				/* 이미지 복사 기능 추가 (2013.3.12) */
				if ($stProdImgCopy == "Y"):
					$imageResize = new ImageFunc();
					$aryProdImg = array("main" => "1", "list" => "2", "view" => "3", "large" => "4", "mobile_main" => "5", "mobile_view" => "6");
					$arySizeW = array("main" => $S_PRODLIST_IMG_SIZE_W, "list" => $S_PRODLIST_IMG_SIZE_W, "view" => $S_PRODUCT_VIEW_ISW, "large" => $S_PRODUCT_VIEW_PISW, "mobile_main" => $S_PRODLIST_IMG_SIZE_W, "mobile_view" => $S_PRODUCT_VIEW_ISW);
					$arySizeH = array("main" => $S_PRODLIST_IMG_SIZE_H, "list" => $S_PRODLIST_IMG_SIZE_H, "view" => $S_PRODUCT_VIEW_ISH, "large" => $S_PRODUCT_VIEW_PISH, "mobile_main" => $S_PRODLIST_IMG_SIZE_H, "mobile_view" => $S_PRODUCT_VIEW_ISH);
					$url1Org = "/{$strProductImgPath}/prodImg4/{$fresTemp['file_real_name']}";
					$url1 = "/{$strProductImgPath}/prodImg4/temp_{$fresTemp['file_real_name']}";
					copy("{$S_DOCUMENT_ROOT}{$S_SHOP_HOME}{$url1Org}", "{$S_DOCUMENT_ROOT}{$S_SHOP_HOME}{$url1}");
					foreach ($aryProdImg as $key => $val):
						$url2 = "/{$strProductImgPath}/prodImg{$val}/{$fresTemp['file_real_name']}";
						//					$copyRe				= copy("{$S_DOCUMENT_ROOT}{$S_SHOP_HOME}{$url1}", "{$S_DOCUMENT_ROOT}{$S_SHOP_HOME}/{$url2}");
						$copyRe = $imageResize->getImageResize("{$S_DOCUMENT_ROOT}{$S_SHOP_HOME}{$url1}", "{$S_DOCUMENT_ROOT}{$S_SHOP_HOME}/{$url2}", $arySizeW[$key], $arySizeH[$key]);
						@chmod("{$S_DOCUMENT_ROOT}{$S_SHOP_HOME}{$url2}", 0707);
						if ($copyRe):
							$productMgr->setPM_TYPE($key);
							$productMgr->setPM_SAVE_NAME($fresTemp['file_name']);
							$productMgr->setPM_REAL_NAME($url2);
							$productMgr->getProdImgInsert($db);
						endif;
					endforeach;
					unlink("{$S_DOCUMENT_ROOT}{$S_SHOP_HOME}{$url1}");
				endif;
				/* 이미지 복사 기능 추가 (2013.3.12) */
			}

			/* 상품아이콘 INSERT */
			if ($a_admin_type == "A"):        // 2013.11.19 kim hee sung 리몰 요청으로 최고 관리자만 아이콘 설정 가능
				$strProdIcon = "";
				for ($i = 1; $i <= 10; $i++) {
					$strIconUseYN = $_POST["prodIcon" . $i] ? $_POST["prodIcon" . $i] : $_REQUEST["prodIcon" . $i];
					$strIconUseYN = IM_IsBlank($strIconUseYN, "N");
					$strProdIcon .= $strIconUseYN . "|";

					if ($i == 1) {
						$strIconType = "A";
					} else if ($i == 2) {
						$strIconType = "B";
					} else if ($i == 3) {
						$strIconType = "C";
					} else if ($i == 4) {
						$strIconType = "D";
					} else if ($i == 5) {
						$strIconType = "E";
					} else if ($i == 6) {
						$strIconType = "F";
					} else if ($i == 7) {
						$strIconType = "G";
					} else if ($i == 8) {
						$strIconType = "H";
					} else if ($i == 9) {
						$strIconType = "I";
					} else if ($i == 10) {
						$strIconType = "J";
					}

					$productMgr->setPC_TYPE($strIconType);
					$productMgr->setPC_USE($strIconUseYN);
					$productMgr->setPC_IMG("");
					$productMgr->getProdIconInsert($db);
				}

				if ($strProdIcon) {
					$productMgr->setP_ICON($strProdIcon);
					$productMgr->getProdDisplayIconUpdate($db);
				}
			endif;

			/* 상품 첨부파일 INSERT */
			$prodFileMakeFolderResult = getMakeFolder("product", substr($strP_CODE, 0, 8));
			if ($prodFileMakeFolderResult) {

				$strProductFilePath = "upload/product/" . substr($strP_CODE, 0, 8);
				for ($i = 1; $i <= 3; $i++) {

					if ($_FILES["prodFile" . $i][name]) {

						$strFileName = $_FILES["prodFile" . $i][name];
						$strFileTmpName = $_FILES["prodFile" . $i][tmp_name];
						$intFileSize = $_FILES["prodFile" . $i][size];
						$strFileType = $_FILES["prodFile" . $i][type];

						$fres = $fh->doUpload($strP_CODE, "../" . $strProductFilePath . "/prodFile" . $i, $strFileName, $strFileTmpName, $intFileSize, $strFileType);

						if ($fres) {
							$strProdFileType = "file" . $i;
							$productMgr->setPM_TYPE($strProdFileType);
							$productMgr->setPM_SAVE_NAME($strFileName);
							$productMgr->setPM_REAL_NAME("/" . $strProductFilePath . "/prodFile" . $i . "/" . $fres[file_real_name]);
							$productMgr->getProdImgInsert($db);
						}
					}
				}
			}

			/* 상품 아이콘(리스트) */
			$cateMgr->setIC_TYPE("ICON");
			$aryProdIconDisplayList = $cateMgr->getProdDisplayList($db);
			$strProdListIcon = "";
			if (is_array($aryProdIconDisplayList)) {
				for ($i = 0; $i < sizeof($aryProdIconDisplayList); $i++) {

					$strProdListIconNo = $aryProdIconDisplayList[$i]['IC_CODE'];
					$strProdListIconName = "prodListIcon_" . $aryProdIconDisplayList[$i]['IC_CODE'];

					$strProdListIconVal = $_POST[$strProdListIconName] ? $_POST[$strProdListIconName] : $_REQUEST[$strProdListIconName];

					if ($strProdListIconVal == "Y") {

						$strProdListIcon .= $strProdListIconNo . "/";
					}
				}
			}

			if ($strProdListIcon) {
				$productMgr->setP_LIST_ICON($strProdListIcon);
				$productMgr->getProdListIconUpdate($db);
			}

			/* 상품 색상 */
			if (is_array($S_ARY_PROD_COLOR)) {
				$strProdColorList = "";
				for ($i = 0; $i < sizeof($S_ARY_PROD_COLOR); $i++) {
					$strProdColorYN = $_POST["prodColor_" . $i];
					if ($strProdColorYN == "Y") $strProdColorList .= "Y|";
					else $strProdColorList .= "N|";
				}

				$productMgr->setP_COLOR($strProdColorList);
				$productMgr->getProdColorUpdate($db);
			}

			/* 상품 사이즈 */
			if (is_array($S_ARY_PROD_SIZE)) {
				$strProdSizeList = "";
				for ($i = 0; $i < sizeof($S_ARY_PROD_SIZE); $i++) {
					$strProdSizeYN = $_POST["prodSize_" . $i];
					if ($strProdSizeYN == "Y") $strProdSizeList .= "Y|";
					else $strProdSizeList .= "N|";
				}
				$productMgr->setP_SIZE($strProdSizeList);
				$productMgr->getProdSizeUpdate($db);
			}

			/* 상품 포인트 사용 불가 */
			$productMgr->getProdPointNoUseUpdate($db);

			## 2013.09.04 kin hee sung 동영상 URL 저장
			if ($S_FIX_PROD_VIEW_MOVIE_FLAG == "Y" && $_POST['prodMovie1']):

				$productMgr->setPM_TYPE("movie1");
				$productMgr->setPM_SAVE_NAME("");
				$productMgr->setPM_REAL_NAME($_POST['prodMovie1']);
				$productMgr->getProdImgInsert($db);
			endif;

			## 상품찾기 내용 등록
			if ($S_PRODUCT_SEARCH_USE == "Y"):
				$objProductSearchModule = new ProductSearchModule($db);
				$aryProductSearch = $_POST['productSearch'];
				$aryProductSearchData = "";
				if ($aryProductSearch):
					foreach ($aryProductSearch as $psKey => $psData):
						list($strCommGrp, $strCommCode) = explode("@", $psData);
						if ($aryProductSearchData[$strCommGrp]) {
							$aryProductSearchData[$strCommGrp] .= ",";
						}
						$aryProductSearchData[$strCommGrp] .= $strCommCode;
					endforeach;

					$param = "";
					$param['PS_P_CODE'] = $strP_CODE;
					$param['PS_PROD_SEARCH_1'] = $aryProductSearchData['PROD_SEARCH_1'];
					$param['PS_PROD_SEARCH_2'] = $aryProductSearchData['PROD_SEARCH_2'];
					$param['PS_PROD_SEARCH_3'] = $aryProductSearchData['PROD_SEARCH_3'];
					$param['PS_PROD_SEARCH_4'] = $aryProductSearchData['PROD_SEARCH_4'];
					$param['PS_PROD_SEARCH_5'] = $aryProductSearchData['PROD_SEARCH_5'];
					$param['PS_PROD_SEARCH_6'] = $aryProductSearchData['PROD_SEARCH_6'];
					$param['PS_PROD_SEARCH_7'] = $aryProductSearchData['PROD_SEARCH_7'];
					$param['PS_PROD_SEARCH_8'] = $aryProductSearchData['PROD_SEARCH_8'];
					$param['PS_PROD_SEARCH_9'] = $aryProductSearchData['PROD_SEARCH_9'];
					$param['PS_PROD_SEARCH_10'] = $aryProductSearchData['PROD_SEARCH_10'];
					$objProductSearchModule->getProductSearchInsertEx($param);
				endif;
			endif;


			## 상품경매관리사용여부
			if ($S_PRODUCT_AUCTION_USE == "Y" && $strAct == "prodAuctionWrite") {
				$prodAucParam = "";
				$prodAucParam['P_CODE'] = $strP_CODE;
				$prodAucParam['P_AUC_ST_DT'] = $strProdAucStDt . " " . $strProdAucStHour . ":" . $strProdAucStMinute . ":00";
				$prodAucParam['P_AUC_END_DT'] = $strProdAucEndDt . " " . $strProdAucEndHour . ":" . $strProdAucEndMinute . ":59";
				$prodAucParam['P_AUC_ST_PRICE'] = $intProdAucStPrice;
				$prodAucParam['P_AUC_RIGHT_PRICE'] = $intProdAucRightPrice;
				$prodAucParam['P_AUC_STATUS'] = $strProdAucStatus;
				$productMgr->getProdAucInsert($db, $prodAucParam);
			}

			## 상품고시
			if ($S_PRODUCT_NOTIFY_USE && $strLang == "KR"):
				$strPN_CODE = $_POST['pnCode'];
				$arrProdNotifyItemNo = $_POST['prodNotifyItemNo'];
				$arrProdNotifyItemName = $_POST['prodNotifyItemName'];
				$arrProdNotifyItemText = $_POST['prodNotifyItemText'];

				$strProdNotifyItemNoList = "";
				if (is_array($arrProdNotifyItemName)) {
					$param = "";
					$param['P_CODE'] = $strP_CODE;
					$productMgr->getProdNotifyDelete($db, $param);
					foreach ($arrProdNotifyItemName as $key => $strProdNotifyItemName) {
						$strProdNotifyItemText = $arrProdNotifyItemText[$key];
						$intProdNotifyNo = $arrProdNotifyItemNo[$key];

						$param['PN_CODE'] = $strPN_CODE;
						$param['PN_NAME'] = $strProdNotifyItemName;
						$param['PN_TEXT'] = $strProdNotifyItemText;
						$param['PN_ORDER'] = $key + 1;
						$productMgr->getProdNotifyInsertUpdate($db, $param);
					}
				}
			endif;

			$strLinkPage = "searchCate1=$strSearchHCode1&searchCate2=$strSearchHCode2";
			$strLinkPage .= "&searchCate3=$strSearchHCode3&searchCate4=$strSearchHCode4";
			$strLinkPage .= "&searchField=$strSearchField&searchKey=$strSearchKey&pageLine=$intPageLine";
			$strLinkPage .= "&searchLaunchStartDt=$strSearchLaunchStartDt&searchLaunchEndDt=$strSearchLaunchEndDt";
			$strLinkPage .= "&searchRepStartDt=$strSearchRepStartDt&searchRepEndDt=$strSearchRepEndDt";
			$strLinkPage .= "&searchWebView=$strSearchWebView&searchMobileView=$strSearchMobileView";
			$strLinkPage .= "&searchIcon1=$strSearchIcon1";
			$strLinkPage .= "&searchIcon2=$strSearchIcon2";
			$strLinkPage .= "&searchIcon3=$strSearchIcon3";
			$strLinkPage .= "&searchIcon4=$strSearchIcon4";
			$strLinkPage .= "&searchIcon5=$strSearchIcon5";
			$strLinkPage .= "&searchIcon6=$strSearchIcon6";
			$strLinkPage .= "&searchIcon7=$strSearchIcon7";
			$strLinkPage .= "&searchIcon8=$strSearchIcon8";
			$strLinkPage .= "&searchIcon9=$strSearchIcon9";
			$strLinkPage .= "&searchIcon10=$strSearchIcon10&searchShopNo=$strSearchShopNo&page=$intPage";

			/* 화면 계속 유지*/
			if ($strAutoReg == "Y") $strMode = "prodWrite";
			else $strMode = "prodList";

			if ($strAct == "prodAuctionWrite") {
				if ($strAutoReg == "Y") $strMode = "prodAuctionWrite";
				else $strMode = "prodAuctionList";
			}

			$strUrl = "./?menuType=" . $strMenuType . "&mode=" . $strMode . "&lang={$strStLng}&" . $strLinkPage;


			//국가리스트
			$aryCountryList = getCountryList();
			$aryCountryState = getCommCodeList("STATE", "");

			//국가코드명별 국가명설정
			$aryCountryListTotalAry = getCountryListTotalAry();
			for ($i = 0; $i < sizeof($aryCountryListTotalAry); $i++) {
				$aryCountryList[$aryCountryListTotalAry[$i][CT_CODE]] = $aryCountryListTotalAry[$i]["CT_NAME_{$strAdmSiteLng}"];
			}

			//언어별 상품 등록순서 처리 2015.05.13
			//if(!$strProdShopCountry) $strProdShopCountry = 'KR';
			$intCountry = array_search($strStLng, $aryRollCountry[$strProdShopCountry]);
			$intCountryCnt = $intCountry + 1;
			$strNextCountry = $aryRollCountry[$strProdShopCountry][$intCountryCnt];

			if ($strNextCountry) {
				$strAddProdCountryUrl = "./?menuType=" . $strMenuType . "&mode=prodModify&lang={$strNextCountry}&prodShopCountry={$strProdShopCountry}&prodCode=" . $strP_CODE . "&" . $strLinkPage;
			}

			//언어별 상품추가 체크
			if ($strAddProdCountryUrl) {
				$strProdCountryCheck = "";
				$strProdCountryCheck .= "<script>";
				$strProdCountryCheck .= "
				if(confirm('\"" . $aryCountryList[$strNextCountry] . "사이트\"에 정보를 등록하시겠습니까?')){
					location.href=\"" . $strAddProdCountryUrl . "\";
				}else{
					alert('제품등록이 완료되었습니다');
					location.href=\"" . $strUrl . "\";
				}
				";
				$strProdCountryCheck .= "</script>";
				echo $strProdCountryCheck;
				exit;
			}
			//goUrl($strMsg,$strUrl);

			break;

		case "prodModify":
		case "prodAuctionModify":

			## 상품찾기 내용 등록
			if ($S_PRODUCT_SEARCH_USE == "Y"):
				$objProductSearchModule = new ProductSearchModule($db);
				$aryProductSearch = $_POST['productSearch'];
				$aryProductSearchData = "";
				if ($aryProductSearch):
					foreach ($aryProductSearch as $psKey => $psData):
						list($strCommGrp, $strCommCode) = explode("@", $psData);
						if ($aryProductSearchData[$strCommGrp]) {
							$aryProductSearchData[$strCommGrp] .= ",";
						}
						$aryProductSearchData[$strCommGrp] .= $strCommCode;
					endforeach;
				endif;
				## 기존에 등록된 내용이 있는지 체크
				$param = "";
				$param['PS_P_CODE'] = $strP_CODE;
				$intProductSearchCnt = $objProductSearchModule->getProductSearchSelectEx("OP_COUNT", $param);

				## 데이터 등록
				$param = "";
				$param['PS_P_CODE'] = $strP_CODE;
				$param['PS_PROD_SEARCH_1'] = $aryProductSearchData['PROD_SEARCH_1'];
				$param['PS_PROD_SEARCH_2'] = $aryProductSearchData['PROD_SEARCH_2'];
				$param['PS_PROD_SEARCH_3'] = $aryProductSearchData['PROD_SEARCH_3'];
				$param['PS_PROD_SEARCH_4'] = $aryProductSearchData['PROD_SEARCH_4'];
				$param['PS_PROD_SEARCH_5'] = $aryProductSearchData['PROD_SEARCH_5'];
				$param['PS_PROD_SEARCH_6'] = $aryProductSearchData['PROD_SEARCH_6'];
				$param['PS_PROD_SEARCH_7'] = $aryProductSearchData['PROD_SEARCH_7'];
				$param['PS_PROD_SEARCH_8'] = $aryProductSearchData['PROD_SEARCH_8'];
				$param['PS_PROD_SEARCH_9'] = $aryProductSearchData['PROD_SEARCH_9'];
				$param['PS_PROD_SEARCH_10'] = $aryProductSearchData['PROD_SEARCH_10'];
				if ($intProductSearchCnt) {
					$objProductSearchModule->getProductSearchUpdateEx($param);
				} else {
					$objProductSearchModule->getProductSearchInsertEx($param);
				}
			endif;


			/** 2103.06.27 kim hee sung, 상점정보 **/
			/** 설명 : 입점몰 상품 등록시 승인이 필요한 경우, 수정을 하면, 미승인 상태로 변경이 됩니다.(정훈씨 요청) **/
			if ($a_admin_type == "S") {
				 // 입점몰인 경우.
				require_once MALL_CONF_LIB . "ShopMgr.php";
				$shopMgr = new ShopMgr();

				$shopMgr->setSH_NO($a_admin_shop_no);
				$shopInfo = $shopMgr->getShopView($db);

				if ($shopInfo['SH_COM_PROD_AUTH'] == "Y"): // 승인이 필요한 경우 (바로노출인 경우)
					//입점사 보임,안보임 수정이 안됨. 요청으로 주석. 남덕희
//					$productMgr->setP_WEB_VIEW("Y");
//					$productMgr->setP_MOB_VIEW("Y");
				endif;

				//입점사가 상품 포인트 입력 금지
				if ($S_FIX_MALL_PROD_POINT_INSERT == "N") {
					$productMgr->setP_POINT(0);
				}
			}

			$productMgr->setP_CODE($strP_CODE);


			#중국어 기준에서 영문상품 등록시 한국상품자동등록 2015.05.31 kjp
			if($aryRollCountry[$strProdShopCountry] == 'CN' && $strStLng=='US')
			{
				$productMgr->setP_LNG('KR');
				$productMgr->getProdUpdate($db) ;
			}

			/* 상품 언어 설정 */
			$productMgr->setP_LNG($strStLng);
			//MGR 업데이트 실행
			$productMgr->getProdUpdate($db) ;


			/** 2013.04.26 가격대체문구 데이터 업데이트 부분 추가 **/
			$productMgr->getProdPriceTextUpdate($db);
			//PRODUCT_INFO_ 업데이트
			$productMgr->getProdInfoUpdate($db);

			/* 상품 관련 옵션(관련 상품 등록) 2013.03.14 추가(heesung) */
			$productMgr->getProdGrpAllDelete($db);
			if($strProdrelatedCodeList):
				$aryRelated = explode(",", $strProdrelatedCodeList);
				foreach($aryRelated as $code):
					$productMgr->setPG_P_CODE($code);
					$productMgr->getProdGrpInsert($db);
				endforeach;
			endif;

			/* 상품 항목추가 Modify */
			if (is_array($aryProdItem)){
				$strProdItemNoList = "";
				$productMgr->setPI_LNG($strStLng);
				for($i=0;$i<sizeof($aryProdItem);$i++){

					$intPI_NO			= $aryProdItemNo[$i];
					$strPI_NAME			= $aryProdItem[$i];
					$strPI_TEXT			= $aryProdItemText[$i];
					$strPI_TYPE			= $aryProdItemType[$i];
					$strPI_USER_TYPE	= $aryProdItemUserType[$i];
					if ($strPI_TYPE == "U") $strPI_TYPE = $strPI_USER_TYPE;

					$strPI_NAME			= strTrim($strPI_NAME,50);
					$strPI_TEXT			= strTrim($strPI_TEXT,100);
					$intPI_ORDER		= $i+1;

					if ($strPI_NAME){

						$paramItemData				= "";
						$paramItemData['PI_TYPE']	= $strPI_TYPE;

						$productMgr->setPI_NO($intPI_NO);
						$productMgr->setPI_NAME($strPI_NAME);
						$productMgr->setPI_TEXT($strPI_TEXT);
						$productMgr->setPI_ORDER($intPI_ORDER);

						if ($intPI_NO > 0){

							$productMgr->setPI_LNG($strStLng);

							$productMgr->getProdItemUpdate($db,$paramItemData);
							$strProdItemNoList .= $intPI_NO.",";


						} else {

							/* 같은 순서에 있는 언어별 항목을 모두 삭제한다.*/
							$productMgr->getProdItemInsert($db,$paramItemData);
							$intPI_NO = $db->getLastInsertID();
							$productMgr->setPI_NO($intPI_NO);

							/* 언어별 INSERT */
							for($j=0;$j<sizeof($arySiteUseLng);$j++){
								if ($arySiteUseLng[$j]){
									$productMgr->setPI_LNG($arySiteUseLng[$j]);
									$productMgr->setPI_NAME($strPI_NAME);
									$productMgr->setPI_TEXT($strPI_TEXT);
									$productMgr->getProdItemLngInsert($db);
								}
							}

							$strProdItemNoList .= $intPI_NO.",";
						}
					}
				}

				if ($strProdItemNoList) {
					$productMgr->setPI_NO_ALL(SUBSTR($strProdItemNoList,0,STRLEN($strProdItemNoList)-1));

					for($j=0;$j<sizeof($arySiteUseLng);$j++){
						if ($arySiteUseLng[$j]){
							$productMgr->setPI_LNG($arySiteUseLng[$j]);
							$productMgr->getProdItemLngDelete($db);
						}
					}

					$productMgr->getProdItemAllDelete($db);

				} else {

					for($j=0;$j<sizeof($arySiteUseLng);$j++){
						if ($arySiteUseLng[$j]){
							$productMgr->setP_LNG($arySiteUseLng[$j]);
							$productMgr->getProdItemLngDelete($db);
						}
					}
					$productMgr->getProdItemAllDelete($db);
				}
			}

			/* 상품 옵션추가 Modify */
			if ($strProdOptName1){
				$intPO_NO		= $aryProdOptNo[0];

				$strPO_TYPE		= "O";
				if (!$strProdOptEss) $strProdOptEss = "N";

				$productMgr->setPO_NAME1($strProdOptName1);
				$productMgr->setPO_NAME2($strProdOptName2);
				$productMgr->setPO_NAME3($strProdOptName3);
				$productMgr->setPO_NAME4($strProdOptName4);
				$productMgr->setPO_NAME5($strProdOptName5);
				$productMgr->setPO_NAME6($strProdOptName6);
				$productMgr->setPO_NAME7($strProdOptName7);
				$productMgr->setPO_NAME8($strProdOptName8);
				$productMgr->setPO_NAME9($strProdOptName9);
				$productMgr->setPO_NAME10($strProdOptName10);
				$productMgr->setPO_TYPE($strPO_TYPE);
				$productMgr->setPO_ESS($strProdOptEss);

				if ($intPO_NO > 0) {

					$productMgr->setPO_NO($intPO_NO);

					/* 언어별 update */
					if ($strStLng == $S_ST_LNG){

						for($j=0;$j<sizeof($arySiteUseLng);$j++){
							$productMgr->setP_LNG($arySiteUseLng[$j]);
							$productMgr->getProdOptUpdate($db);
						}
					} else {
						$productMgr->setP_LNG($strStLng);
						$productMgr->getProdOptUpdate($db);
					}


				} else {

					$productMgr->getProdOptInsert($db);
					$intPO_NO = $db->getLastInsertID();
					$productMgr->setPO_NO($intPO_NO);

					/* 언어별 INSERT */
					for($j=0;$j<sizeof($arySiteUseLng);$j++){
						if ($arySiteUseLng[$j]){
							$productMgr->setP_LNG($arySiteUseLng[$j]);
							$productMgr->getProdOptLngInsert($db);
						}
					}
				}

				if ($intPO_NO > 0){

					$intAttrNo = 1;

					$intProdOptAttrNo				= "prodOptAttrNo".$intAttrNo;
					$strProdOptAttrVal1				= "prodOptAttrVal".$intAttrNo."_1";
					$strProdOptAttrVal2				= "prodOptAttrVal".$intAttrNo."_2";
					$strProdOptAttrVal3				= "prodOptAttrVal".$intAttrNo."_3";
					$strProdOptAttrVal4				= "prodOptAttrVal".$intAttrNo."_4";
					$strProdOptAttrVal5				= "prodOptAttrVal".$intAttrNo."_5";
					$strProdOptAttrVal6				= "prodOptAttrVal".$intAttrNo."_6";
					$strProdOptAttrVal7				= "prodOptAttrVal".$intAttrNo."_7";
					$strProdOptAttrVal8				= "prodOptAttrVal".$intAttrNo."_8";
					$strProdOptAttrVal9				= "prodOptAttrVal".$intAttrNo."_9";
					$strProdOptAttrVal10			= "prodOptAttrVal".$intAttrNo."_10";
					$strProdOptAttrSalePrice		= "prodOptAttrSalePrice".$intAttrNo;
					$strProdOptAttrConsumerPrice	= "prodOptAttrConsumerPrice".$intAttrNo;
					$strProdOptAttrStockPrice		= "prodOptAttrStockPrice".$intAttrNo;
					$strProdOptAttrPoint			= "prodOptAttrPoint".$intAttrNo;
					$strProdOptAttrQty				= "prodOptAttrQty".$intAttrNo;

					$aryProdOptAttrNo				= $_POST[$intProdOptAttrNo]				? $_POST[$intProdOptAttrNo]				: $_REQUEST[$intProdOptAttrNo];
					$aryProdOptAttrVal1				= $_POST[$strProdOptAttrVal1]			? $_POST[$strProdOptAttrVal1]			: $_REQUEST[$strProdOptAttrVal1];
					$aryProdOptAttrVal2				= $_POST[$strProdOptAttrVal2]			? $_POST[$strProdOptAttrVal2]			: $_REQUEST[$strProdOptAttrVal2];
					$aryProdOptAttrVal3				= $_POST[$strProdOptAttrVal3]			? $_POST[$strProdOptAttrVal3]			: $_REQUEST[$strProdOptAttrVal3];
					$aryProdOptAttrVal4				= $_POST[$strProdOptAttrVal4]			? $_POST[$strProdOptAttrVal4]			: $_REQUEST[$strProdOptAttrVal4];
					$aryProdOptAttrVal5				= $_POST[$strProdOptAttrVal5]			? $_POST[$strProdOptAttrVal5]			: $_REQUEST[$strProdOptAttrVal5];
					$aryProdOptAttrVal6				= $_POST[$strProdOptAttrVal6]			? $_POST[$strProdOptAttrVal6]			: $_REQUEST[$strProdOptAttrVal6];
					$aryProdOptAttrVal7				= $_POST[$strProdOptAttrVal7]			? $_POST[$strProdOptAttrVal7]			: $_REQUEST[$strProdOptAttrVal7];
					$aryProdOptAttrVal8				= $_POST[$strProdOptAttrVal8]			? $_POST[$strProdOptAttrVal8]			: $_REQUEST[$strProdOptAttrVal8];
					$aryProdOptAttrVal9				= $_POST[$strProdOptAttrVal9]			? $_POST[$strProdOptAttrVal9]			: $_REQUEST[$strProdOptAttrVal9];
					$aryProdOptAttrVal10			= $_POST[$strProdOptAttrVal10]			? $_POST[$strProdOptAttrVal10]			: $_REQUEST[$strProdOptAttrVal10];
					$aryProdOptAttrSalePrice		= $_POST[$strProdOptAttrSalePrice]		? $_POST[$strProdOptAttrSalePrice]		: $_REQUEST[$strProdOptAttrSalePrice];
					$aryProdOptAttrConsumerPrice	= $_POST[$strProdOptAttrConsumerPrice]	? $_POST[$strProdOptAttrConsumerPrice]	: $_REQUEST[$strProdOptAttrConsumerPrice];
					$aryProdOptAttrStockPrice		= $_POST[$strProdOptAttrStockPrice]		? $_POST[$strProdOptAttrStockPrice]		: $_REQUEST[$strProdOptAttrStockPrice];
					$aryProdOptAttrPoint			= $_POST[$strProdOptAttrPoint]			? $_POST[$strProdOptAttrPoint]			: $_REQUEST[$strProdOptAttrPoint];
					$aryProdOptAttrQty				= $_POST[$strProdOptAttrQty]			? $_POST[$strProdOptAttrQty]			: $_REQUEST[$strProdOptAttrQty];

					$strProdOptAttrNoList			= "";
					$intProdOptAttrLastNo			= ""; //->마지막옵션순서

					if (is_array($aryProdOptAttrVal1)){

						for($j=0;$j<sizeof($aryProdOptAttrVal1);$j++){
							if ($strP_OPT == "1") {
								//다중가격사용안함
								$aryProdOptAttrSalePrice[$j]		= 0;
								$aryProdOptAttrConsumerPrice[$j]	= 0;
								$aryProdOptAttrStockPrice[$j]		= 0;
								$aryProdOptAttrPoint[$j]			= 0;
							}

							if (!$aryProdOptAttrNo[$j]) $aryProdOptAttrNo[$j] = 0;
							if (!$aryProdOptAttrSalePrice[$j]) $aryProdOptAttrSalePrice[$j] = 0;
							if (!$aryProdOptAttrConsumerPrice[$j]) $aryProdOptAttrConsumerPrice[$j] = 0;
							if (!$aryProdOptAttrStockPrice[$j]) $aryProdOptAttrStockPrice[$j] = 0;
							if (!$aryProdOptAttrPoint[$j]) $aryProdOptAttrPoint[$j] = 0;
							if (!$aryProdOptAttrQty[$j]) $aryProdOptAttrQty[$j] = 0;

							$productMgr->setPOA_ATTR1($aryProdOptAttrVal1[$j]);
							$productMgr->setPOA_ATTR2($aryProdOptAttrVal2[$j]);
							$productMgr->setPOA_ATTR3($aryProdOptAttrVal3[$j]);
							$productMgr->setPOA_ATTR4($aryProdOptAttrVal4[$j]);
							$productMgr->setPOA_ATTR5($aryProdOptAttrVal5[$j]);
							$productMgr->setPOA_ATTR6($aryProdOptAttrVal6[$j]);
							$productMgr->setPOA_ATTR7($aryProdOptAttrVal7[$j]);
							$productMgr->setPOA_ATTR8($aryProdOptAttrVal8[$j]);
							$productMgr->setPOA_ATTR9($aryProdOptAttrVal9[$j]);
							$productMgr->setPOA_ATTR10($aryProdOptAttrVal10[$j]);
							$productMgr->setPOA_SALE_PRICE($aryProdOptAttrSalePrice[$j]);
							$productMgr->setPOA_CONSUMER_PRICE($aryProdOptAttrConsumerPrice[$j]);
							$productMgr->setPOA_STOCK_PRICE($aryProdOptAttrStockPrice[$j]);
							$productMgr->setPOA_POINT($aryProdOptAttrPoint[$j]);
							$productMgr->setPOA_STOCK_QTY($aryProdOptAttrQty[$j]);

							if ($aryProdOptAttrNo[$j] > 0 ) {

								$intPOA_NO = $aryProdOptAttrNo[$j];
								$productMgr->setPOA_NO($intPOA_NO);
								$productMgr->getProdOptAttrUpdate($db);

							} else {

								$productMgr->getProdOptAttrInsert($db);
								$intPOA_NO = $db->getLastInsertID();
								$productMgr->setPOA_NO($intPOA_NO);

								/* 언어별 속성 INSERT */
								for($k=0;$k<sizeof($arySiteUseLng);$k++){
									if ($arySiteUseLng[$k]){
										$productMgr->setP_LNG($arySiteUseLng[$k]);
										$productMgr->getProdOptAttrLngInsert($db);
									}
								}
							}

							if ($intPOA_NO > 0){
								$strProdOptAttrNoList .= $intPOA_NO.",";
							}
						}

						/* 기준언어일때만 삭제 */
						if ($S_ST_LNG == $strStLng){
							if ($strProdOptAttrNoList){
								$productMgr->setPOA_NO_ALL(SUBSTR($strProdOptAttrNoList,0,STRLEN($strProdOptAttrNoList)-1));

								/* 언어별 삭제 */
								for($j=0;$j<sizeof($arySiteUseLng);$j++){
									if ($arySiteUseLng[$j]){
										$productMgr->setP_LNG($arySiteUseLng[$j]);
										$productMgr->getProdOptAttrLangAllDelete($db);
									}
								}

								$productMgr->getProdOptAttrAllDelete($db);
							} else {
								for($j=0;$j<sizeof($arySiteUseLng);$j++){
									if ($arySiteUseLng[$j]){
										$productMgr->setP_LNG($arySiteUseLng[$j]);
										$productMgr->getProdOptAttrLangAllDelete($db);
									}
								}
								$productMgr->getProdOptAttrAllDelete($db);
							}
						}
					}

					/* 상품 옵션 등록/수정된 것 제외 삭제*/
					$strProdOptNoList .= $intPO_NO.",";
				}

				$productMgr->setP_LNG($strStLng);
				if ($S_ST_LNG == $strStLng){
					if ($strProdOptNoList){
						$productMgr->setPO_NO_ALL(SUBSTR($strProdOptNoList,0,STRLEN($strProdOptNoList)-1));

						for($j=0;$j<sizeof($arySiteUseLng);$j++){
							if ($arySiteUseLng[$j]){
								$productMgr->setP_LNG($arySiteUseLng[$j]);
								$productMgr->getProdOptLangAllDelete($db);
							}
						}

						$productMgr->getProdOptAllDelete($db);
					} else {
						$productMgr->getProdOptLangAllDelete($db);
						$productMgr->getProdOptAllDelete($db);
					}
				}
			} else {
				if ($S_ST_LNG == $strStLng){
					$productMgr->setPO_TYPE("O");
					for($j=0;$j<sizeof($arySiteUseLng);$j++){
						if ($arySiteUseLng[$j]){
							$productMgr->setP_LNG($arySiteUseLng[$j]);
							$productMgr->getProdOptLangAllDelete($db);
						}
					}
					$productMgr->getProdOptAllDelete($db);
				}
			}

			$productMgr->setP_LNG($strStLng);
			/* 상품 추가옵션추가 Modify */
			if (($S_MALL_TYPE == "R") || ($S_MALL_TYPE == "M" && $S_PRODUCT_ADD_OPT_USE == "Y")){

				if ($strP_ADD_OPT == "Y") {
					$productMgr->setP_LNG($strStLng);

					if (is_array($aryProdAddOptName)){

						$strProdOptNoList = "";
						for($i=0;$i<sizeof($aryProdAddOptName);$i++){

							$intPO_NO		= $aryProdAddOptNo[$i];
							$strAddOptNAME	= $aryProdAddOptName[$i];
							$strPO_TYPE		= "A";
							$strAddOptChk	= $aryProdAddOptChk[$i];

							if (!$strAddOptChk) $strAddOptChk = "N";

							$productMgr->setPO_NAME1($strAddOptNAME);
							$productMgr->setPO_NAME2("");
							$productMgr->setPO_TYPE($strPO_TYPE);
							$productMgr->setPO_ESS($strAddOptChk);

							if ($intPO_NO > 0){
								$productMgr->setPO_NO($intPO_NO);
								$productMgr->getProdOptUpdate($db);

								if ($strAddOptNAME) {
									$strProdOptNoList .= $intPO_NO.",";
								}
							} else {

								if ($strAddOptNAME) {

									$productMgr->getProdOptInsert($db);
									$intPO_NO = $db->getLastInsertID();
									$productMgr->setPO_NO($intPO_NO);

									/* 언어별 INSERT */
									for($j=0;$j<sizeof($arySiteUseLng);$j++){
										if ($arySiteUseLng[$j]){
											$productMgr->setP_LNG($arySiteUseLng[$j]);
											$productMgr->getProdOptLngInsert($db);
										}
									}

									/* 상품 옵션 등록/수정된 것 제외 삭제*/
									$strProdOptNoList .= $intPO_NO.",";
								}
							}


							if ($intPO_NO > 0) {
								$intAddOptNo = $i+1;

								$strProdAddOptNo	= "prodAddOptAttrNo".$intAddOptNo;
								$strProdAddOptVal	= "prodAddOptVal".$intAddOptNo;
								$strProdAddOptPrice	= "prodAddOptPrice".$intAddOptNo;

								$aryProdAddAttrOptNo	= $_POST[$strProdAddOptNo]			? $_POST[$strProdAddOptNo]			: $_REQUEST[$strProdAddOptNo];
								$aryProdAddOptVal		= $_POST[$strProdAddOptVal]			? $_POST[$strProdAddOptVal]			: $_REQUEST[$strProdAddOptVal];
								$aryProdAddOptPrice		= $_POST[$strProdAddOptPrice]		? $_POST[$strProdAddOptPrice]		: $_REQUEST[$strProdAddOptPrice];


								if (is_array($aryProdAddOptVal)){
									$strProdOptAttrNoList = "";

									for($j=0;$j<sizeof($aryProdAddOptVal);$j++){

										if (!$aryProdAddAttrOptNo[$j]) $aryProdAddAttrOptNo[$j] = 0;
										if (!$aryProdAddOptVal[$j]) $aryProdAddOptVal[$j] = "";
										if (!$aryProdAddOptPrice[$j]) $aryProdAddOptPrice[$j] = 0;

										$productMgr->setP_LNG($strStLng);
										$productMgr->setPAO_NAME($aryProdAddOptVal[$j]);
										$productMgr->setPAO_PRICE($aryProdAddOptPrice[$j]);

										//echo "1:".$productMgr->getPO_NO().":".$aryProdAddAttrOptNo[$j].":".$productMgr->getPAO_NAME()."<bR>";

										if ($aryProdAddAttrOptNo[$j] > 0){
											$intPAO_NO = $aryProdAddAttrOptNo[$j];
											$productMgr->setPAO_NO($intPAO_NO);
											$productMgr->getProdAddOptUpdate($db);

										} else {



											$productMgr->getProdAddOptInsert($db);
											$intPAO_NO = $db->getLastInsertID();
											$productMgr->setPAO_NO($intPAO_NO);

											/* 언어별 INSERT */
											for($k=0;$k<sizeof($arySiteUseLng);$k++){
												if ($arySiteUseLng[$k]){
													$productMgr->setP_LNG($arySiteUseLng[$k]);
													$productMgr->getProdAddOptLngInsert($db);
												}
											}
										}

										if ($intPAO_NO > 0 && $aryProdAddOptVal[$j]){
											$strProdOptAttrNoList .= $intPAO_NO.",";
										}
									}

									if ($S_ST_LNG == $strStLng){
										if ($strProdOptAttrNoList){
											$productMgr->setPAO_NO_ALL(SUBSTR($strProdOptAttrNoList,0,STRLEN($strProdOptAttrNoList)-1));

											for($j=0;$j<sizeof($arySiteUseLng);$j++){
												if ($arySiteUseLng[$j]){
													$productMgr->setP_LNG($arySiteUseLng[$j]);
													$productMgr->getProdAddOptAttrLangAllDelete($db);
												}
											}
											$productMgr->getProdAddOptAllDelete($db);
										} else {
											for($j=0;$j<sizeof($arySiteUseLng);$j++){
												if ($arySiteUseLng[$j]){
													$productMgr->setP_LNG($arySiteUseLng[$j]);
													$productMgr->getProdAddOptAttrLangAllDelete($db);
												}
											}
											$productMgr->getProdAddOptAllDelete($db);
										}
									}
								}
							}
						}



						if ($S_ST_LNG == $strStLng){

							if ($strProdOptNoList){
								$productMgr->setPO_NO_ALL(SUBSTR($strProdOptNoList,0,STRLEN($strProdOptNoList)-1));

								for($j=0;$j<sizeof($arySiteUseLng);$j++){
									if ($arySiteUseLng[$j]){
										$productMgr->setP_LNG($arySiteUseLng[$j]);
										$productMgr->getProdOptLangAllDelete($db);
									}
								}

								$productMgr->getProdOptAllDelete($db);
							} else {
								for($j=0;$j<sizeof($arySiteUseLng);$j++){
									if ($arySiteUseLng[$j]){
										$productMgr->setP_LNG($arySiteUseLng[$j]);
										$productMgr->getProdOptLangAllDelete($db);
									}
								}
								$productMgr->getProdOptAllDelete($db);
							}
						}
					}
				}
			}

			$productMgr->setP_LNG($strStLng);

			/* 상품 이미지 Modify */

			if ($strProdImgUrlYN == "Y"){

				for($i=1;$i<=28;$i++){


					if ($i == 1) {
						$strProdImgType = "main";
					} else if ($i == 2){
						$strProdImgType = "list";
					} else if ($i == 3){
						$strProdImgType = "view";
					} else if ($i == 4){
						$strProdImgType = "large";
						$fresTemp		= $fres;
					} else if ($i == 5){
						$strProdImgType = "mobile_main";
					} else if ($i == 6){
						$strProdImgType = "mobile_view";
					} else if ($i >= 7 && $i <= 17){
						$strProdImgType = "view".($i-5);
					} else if ($i >= 18 && $i <= 28){
						$strProdImgType = "large".($i-16);
					}


					$productMgr->setPM_TYPE($strProdImgType);
					$productMgr->setPM_SAVE_NAME("");
					$productMgr->setPM_REAL_NAME($_POST["prodUrlImg".$i]);

					$aryProdImg[$i] = $productMgr->getProdImg($db);

					if (is_array($aryProdImg[$i]) && $aryProdImg[$i][0][PM_NO] > 0){
						if ($_POST["prodUrlImg".$i] != $aryProdImg[$i][0][PM_REAL_NAME]){
							$fh->fileDelete("..".$aryProdImg[$i][0][PM_REAL_NAME]);
						}

						$productMgr->setPM_NO($aryProdImg[$i][0][PM_NO]);
						$productMgr->getProdImgDelete($db);
					}

					if ($_POST["prodUrlImg".$i]){
						$productMgr->getProdImgInsert($db);
					}
				}
			} else {
				$prodImgMakeFolderResult = getMakeFolder("product",substr($strP_CODE,0,8));
				if ($prodImgMakeFolderResult){

					$strProductImgPath = "upload/product/".substr($strP_CODE,0,8);
					for($i=1;$i<=28;$i++){

						if ($_FILES["prodImg".$i][name]){

							$productMgr->setP_LNG($strStLng);
							if (!getAllowImgFileExt($_FILES["prodImg".$i][name])){
								goErrMsg($LNG_TRANS_CHAR["CS00009"]);//첨부하신 파일은 확장자가 금지된 파일입니다.
								exit;
							}

							$strFileName	= $_FILES["prodImg".$i][name];
							$strFileTmpName = $_FILES["prodImg".$i][tmp_name];
							$intFileSize	= $_FILES["prodImg".$i][size];
							$strFileType	= $_FILES["prodImg".$i][type];

							$fres = $fh->doUpload($strP_CODE,"../".$strProductImgPath."/prodImg".$i,$strFileName,$strFileTmpName,$intFileSize,$strFileType);

							if($fres) {

								if ($i == 1) {
									$strProdImgType = "main";
								} else if ($i == 2){
									$strProdImgType = "list";
								} else if ($i == 3){
									$strProdImgType = "view";
								} else if ($i == 4){
									$strProdImgType = "large";
									$fresTemp		= $fres;
								} else if ($i == 5){
									$strProdImgType = "mobile_main";
								} else if ($i == 6){
									$strProdImgType = "mobile_view";
								} else if ($i >= 7 && $i <= 17){
									$strProdImgType = "view".($i-5);
								} else if ($i >= 18 && $i <= 28){
									$strProdImgType = "large".($i-16);
								}

								/* 상세이미지 추가 리사이징 2015.05.28 */
								if($i >= 7 && $i <= 17):
									$imageResize	= new ImageFunc();
									$aryProdImg		= array("view".($i-5) => $i );
									$arySizeW		= array("view".($i-5) => $S_PRODLIST_IMG_SIZE_W );
									$arySizeH		= array("view".($i-5) => $S_PRODLIST_IMG_SIZE_H );
									$url1Org		= "/".$strProductImgPath."/prodImg".$i."/".$fres[file_real_name];
									$url1			= "/".$strProductImgPath."/prodImg".$i."/temp_".$fres[file_real_name];
									copy("{$S_DOCUMENT_ROOT}{$S_SHOP_HOME}{$url1Org}", "{$S_DOCUMENT_ROOT}{$S_SHOP_HOME}{$url1}");
									foreach($aryProdImg as $key => $val):
										// $url2				= "/{$strProductImgPath}/prodImg{$val}/{$fresTemp['file_real_name']}";
										$url2				= "/".$strProductImgPath."/prodImg".$i."/".$fres[file_real_name];
					//					$copyRe				= copy("{$S_DOCUMENT_ROOT}{$S_SHOP_HOME}{$url1}", "{$S_DOCUMENT_ROOT}{$S_SHOP_HOME}/{$url2}");
										$copyRe				= $imageResize->getImageResize("{$S_DOCUMENT_ROOT}{$S_SHOP_HOME}{$url1}", "{$S_DOCUMENT_ROOT}{$S_SHOP_HOME}/{$url2}", $arySizeW[$key], $arySizeH[$key]);
										@chmod("{$S_DOCUMENT_ROOT}{$S_SHOP_HOME}{$url2}", 0707);
										if($copyRe):
											$productMgr->setPM_TYPE($key);
											$productMgr->setPM_SAVE_NAME($fres[file_real_name]);
											$productMgr->setPM_REAL_NAME($url2);
										//	$productMgr->getProdImgInsert($db);

												/* 삭제 코드 */
												$aryProdImg[$i] = $productMgr->getProdImg($db);
												if (is_array($aryProdImg[$i]) && $aryProdImg[$i][0][PM_NO] > 0){
													if($aryProdImg[$i][0][PM_REAL_NAME] != $url2):
														$fh->fileDelete("..".$aryProdImg[$i][0][PM_REAL_NAME]);
													endif;
													$productMgr->setPM_NO($aryProdImg[$i][0][PM_NO]);
													$productMgr->getProdImgDelete($db);
												}
												/* 삭제 코드 */
												$productMgr->getProdImgInsert($db);

										endif;
									endforeach;
									unlink("{$S_DOCUMENT_ROOT}{$S_SHOP_HOME}{$url1}");
								endif;
								/* 상세이미지 추가 리사이징 */

								/*
								$productMgr->setPM_TYPE($strProdImgType);
								$productMgr->setPM_SAVE_NAME($strFileName);
								$productMgr->setPM_REAL_NAME("/".$strProductImgPath."/prodImg".$i."/".$fres[file_real_name]);

								$aryProdImg[$i] = $productMgr->getProdImg($db);
								if (is_array($aryProdImg[$i]) && $aryProdImg[$i][0][PM_NO] > 0){
									$fh->fileDelete("..".$aryProdImg[$i][0][PM_REAL_NAME]);

									$productMgr->setPM_NO($aryProdImg[$i][0][PM_NO]);
									$productMgr->getProdImgDelete($db);
								}

								$productMgr->getProdImgInsert($db);
								*/
							}
						}
					}
				}

				/* 이미지 복사 기능 추가 (2013.3.12) */
				if($stProdImgCopy == "Y"):
					$imageResize	= new ImageFunc();
					$aryProdImg		= array("main" => "1", "list" => "2", "view" => "3", "large" => "4",  "mobile_main" => "5", "mobile_view" => "6" );
					$arySizeW		= array("main" => $S_PRODLIST_IMG_SIZE_W, "list" => $S_PRODLIST_IMG_SIZE_W, "view" => $S_PRODUCT_VIEW_ISW, "large" => $S_PRODUCT_VIEW_PISW, "mobile_main" => $S_PRODLIST_IMG_SIZE_W, "mobile_view" => $S_PRODUCT_VIEW_ISW );
					$arySizeH		= array("main" => $S_PRODLIST_IMG_SIZE_H, "list" => $S_PRODLIST_IMG_SIZE_H, "view" => $S_PRODUCT_VIEW_ISH, "large" => $S_PRODUCT_VIEW_PISH, "mobile_main" => $S_PRODLIST_IMG_SIZE_H, "mobile_view" => $S_PRODUCT_VIEW_ISH );
					$url1Org		= "/{$strProductImgPath}/prodImg4/{$fresTemp['file_real_name']}";
					$url1			= "/{$strProductImgPath}/prodImg4/temp_{$fresTemp['file_real_name']}";
					copy("{$S_DOCUMENT_ROOT}{$S_SHOP_HOME}{$url1Org}", "{$S_DOCUMENT_ROOT}{$S_SHOP_HOME}{$url1}");
					foreach($aryProdImg as $key => $val):
						$url2		= "/{$strProductImgPath}/prodImg{$val}/{$fresTemp['file_real_name']}";
	//					$copyRe		= copy("{$S_DOCUMENT_ROOT}{$S_SHOP_HOME}{$url1}", "{$S_DOCUMENT_ROOT}{$S_SHOP_HOME}/{$url2}");
						$pathUrl1Tmp = $S_DOCUMENT_ROOT.$S_SHOP_HOME.$url1;
						$pathUrl1Tmp = str_replace('/',DIRECTORY_SEPARATOR, $pathUrl1Tmp);
						$pathUrl2Tmp = $S_DOCUMENT_ROOT.$S_SHOP_HOME.$url2;
						$pathUrl2Tmp = str_replace('/',DIRECTORY_SEPARATOR, $pathUrl2Tmp);
						$copyRe		= $imageResize->getImageResize($pathUrl1Tmp, $pathUrl2Tmp, $arySizeW[$key], $arySizeH[$key]);
						@chmod($pathUrl2Tmp, 0707);
						if($copyRe):
							$productMgr->setPM_TYPE($key);
							$productMgr->setPM_SAVE_NAME($fresTemp['file_name']);
							$productMgr->setPM_REAL_NAME($url2);

							/* 삭제 코드 */
							$aryProdImg[$i] = $productMgr->getProdImg($db);
							if (is_array($aryProdImg[$i]) && $aryProdImg[$i][0][PM_NO] > 0){
								if($aryProdImg[$i][0][PM_REAL_NAME] != $url2):
									$fh->fileDelete("..".$aryProdImg[$i][0][PM_REAL_NAME]);
								endif;
								$productMgr->setPM_NO($aryProdImg[$i][0][PM_NO]);
								$productMgr->getProdImgDelete($db);
							}
							/* 삭제 코드 */
							$productMgr->getProdImgInsert($db);
						endif;
					endforeach;
					@unlink($pathUrl1Tmp);
				endif;
				/* 이미지 복사 기능 추가 (2013.3.12) */
			}

			## 2013.09.04 kin hee sung 동영상 URL 저장
			if($S_FIX_PROD_VIEW_MOVIE_FLAG == "Y" && $_POST['prodMovie']):
				$param						= "";
				$param['P_CODE']			= $_POST['prodCode'];
				$param['PM_TYPE']			= "movie1";
				$prodImgRow					= $productMgr->getProdImgEx($db, "OP_SELECT", $param);

				$param['PM_REAL_NAME']		= $_POST['prodMovie'];
				$param['PM_NO']				= $prodImgRow['PM_NO'];

				if($prodImgRow) { $productMgr->getProdImgUpdateEx($db, $param); }
				else			{ $productMgr->getProdImgInsertEx($db, $param); }
			endif;

			/* 상품아이콘 Modify */
			if($a_admin_type == "A"):	// 2013.11.19 kim hee sung 리몰 요청으로 최고 관리자만 아이콘 설정 가능
				$strProdIcon = "";
				for($i=1;$i<=10;$i++){
					$strIconUseYN = $_POST["prodIcon".$i]			? $_POST["prodIcon".$i]			: $_REQUEST["prodIcon".$i];
					$strIconUseYN = IM_IsBlank($strIconUseYN,"N");
					$strProdIcon .= $strIconUseYN."|";

					if ($i == 1){
						$strIconType = "A";
					} else if ($i == 2){
						$strIconType = "B";
					} else if ($i == 3){
						$strIconType = "C";
					} else if ($i == 4){
						$strIconType = "D";
					} else if ($i == 5){
						$strIconType = "E";
					} else if ($i == 6){
						$strIconType = "F";
					} else if ($i == 7){
						$strIconType = "G";
					} else if ($i == 8){
						$strIconType = "H";
					} else if ($i == 9){
						$strIconType = "I";
					} else if ($i == 10){
						$strIconType = "J";
					}

					$productMgr->setPC_TYPE($strIconType);
					$productMgr->setPC_USE($strIconUseYN);
					$productMgr->setPC_IMG("");
					$productMgr->getProdIconUpdate($db);
				}

				if ($strProdIcon){
					$productMgr->setP_ICON($strProdIcon);
					$productMgr->getProdDisplayIconUpdate($db);
				}
			endif;

			/* 상품 첨부파일 Modify */
			$prodFileMakeFolderResult = getMakeFolder("product",substr($strP_CODE,0,8));
			if ($prodFileMakeFolderResult){

				$strProductFilePath = "upload/product/".substr($strP_CODE,0,8);
				for($i=1;$i<=3;$i++){

					if ($_FILES["prodFile".$i][name]){

						$productMgr->setP_LNG($strStLng);
						$strFileName	= $_FILES["prodFile".$i][name];
						$strFileTmpName = $_FILES["prodFile".$i][tmp_name];
						$intFileSize	= $_FILES["prodFile".$i][size];
						$strFileType	= $_FILES["prodFile".$i][type];

						$fres = $fh->doUpload($strP_CODE,"../".$strProductFilePath."/prodFile".$i,$strFileName,$strFileTmpName,$intFileSize,$strFileType);
						if($fres) {

							$strProdFileType = "file".$i;
							$productMgr->setPM_TYPE($strProdFileType);
							$productMgr->setPM_SAVE_NAME($strFileName);
							$productMgr->setPM_REAL_NAME(DIRECTORY_SEPARATOR.$strProductFilePath.DIRECTORY_SEPARATOR."prodFile".$i.DIRECTORY_SEPARATOR.$fres[file_real_name]);

							$aryProdFile[$i] = $productMgr->getProdImg($db);
							if (is_array($aryProdFile[$i]) && $aryProdFile[$i][0][PM_NO] > 0){
								$fh->fileDelete("..".$aryProdFile[$i][0][PM_REAL_NAME]);
								$productMgr->setPM_NO($aryProdFile[$i][0][PM_NO]);
								$productMgr->getProdImgDelete($db);
							}

							$productMgr->getProdImgInsert($db);
						}
					}
				}
			}

			/* 상품 아이콘(리스트) */
				$cateMgr->setIC_TYPE("ICON");
				$aryProdIconDisplayList = $cateMgr->getProdDisplayList($db);
				$strProdListIcon = "";
				if (is_array($aryProdIconDisplayList)){
					for($i=0;$i<sizeof($aryProdIconDisplayList);$i++){

						$strProdListIconNo   = $aryProdIconDisplayList[$i]['IC_CODE'];
						$strProdListIconName = "prodListIcon_".$aryProdIconDisplayList[$i]['IC_CODE'];

						$strProdListIconVal = $_POST[$strProdListIconName] ? $_POST[$strProdListIconName] : $_REQUEST[$strProdListIconName];

						if ($strProdListIconVal == "Y"){

							$strProdListIcon .= $strProdListIconNo."/";
						}
					}

					$productMgr->setP_LIST_ICON($strProdListIcon);
					$productMgr->getProdListIconUpdate($db);
				}

			/* 상품 색상 */
			if (is_array($S_ARY_PROD_COLOR)){
				$strProdColorList = "";
				for($i=0;$i<sizeof($S_ARY_PROD_COLOR);$i++){
					$strProdColorYN = $_POST["prodColor_".$i];
					if ($strProdColorYN == "Y") $strProdColorList .= "Y|";
					else $strProdColorList .= "N|";
				}

				$productMgr->setP_COLOR($strProdColorList);
				$productMgr->getProdColorUpdate($db);
			}

			/* 상품 사이즈 */
			if (is_array($S_ARY_PROD_SIZE)){
				$strProdSizeList = "";
				for($i=0;$i<sizeof($S_ARY_PROD_SIZE);$i++){
					$strProdSizeYN = $_POST["prodSize_".$i];
					if ($strProdSizeYN == "Y") $strProdSizeList .= "Y|";
					else $strProdSizeList .= "N|";
				}
				$productMgr->setP_SIZE($strProdSizeList);
				$productMgr->getProdSizeUpdate($db);
			}

			/* 상품 포인트 사용 불가 */
			$productMgr->getProdPointNoUseUpdate($db);


			## 2013.09.04 kin hee sung 동영상 URL 저장
			if($S_FIX_PROD_VIEW_MOVIE_FLAG == "Y" && $_POST['prodMovie1']):

				$productMgr->setPM_TYPE("movie1");
				$aryProdMovie[0]	= $productMgr->getProdImg($db);

				if (is_array($aryProdMovie[0]) && $aryProdMovie[0][0][PM_NO] > 0){
					$productMgr->setPM_NO($aryProdMovie[0][0][PM_NO]);
					$productMgr->getProdImgDelete($db);
				}

				$productMgr->setPM_TYPE("movie1");
				$productMgr->setPM_SAVE_NAME("");
				$productMgr->setPM_REAL_NAME($_POST['prodMovie1']);
				$productMgr->getProdImgInsert($db);
			endif;

			## 상품다국어출력여부사용
			if ($S_PROD_MANY_LANG_VIEW == "Y"){
				$productMgr->setP_LNG($strStLng);
				$productMgr->getProdInfoViewUpdate($db);
			}

			## 상품경매관리사용여부
			if ($S_PRODUCT_AUCTION_USE == "Y" && $strAct == "prodAuctionModify"){
				$prodAucParam						= "";
				$prodAucParam['P_CODE']				= $strP_CODE;
				$prodAucParam['P_AUC_ST_DT']		= $strProdAucStDt." ".$strProdAucStHour.":".$strProdAucStMinute.":00";
				$prodAucParam['P_AUC_END_DT']		= $strProdAucEndDt." ".$strProdAucEndHour.":".$strProdAucEndMinute.":59";
				$prodAucParam['P_AUC_ST_PRICE']		= $intProdAucStPrice;
				$prodAucParam['P_AUC_RIGHT_PRICE']	= $intProdAucRightPrice;
				$prodAucParam['P_AUC_STATUS']		= $strProdAucStatus;
				$productMgr->getProdAucUpdate($db,$prodAucParam);
			}

			## 상품고시
			$strPN_CODE					= $_POST['pnCode'];
			$arrProdNotifyItemNo		= $_POST['prodNotifyItemNo'];
			$arrProdNotifyItemName		= $_POST['prodNotifyItemName'];
			$arrProdNotifyItemText		= $_POST['prodNotifyItemText'];

			$strProdNotifyItemNoList	= "";
			if (is_array($arrProdNotifyItemName)){
				$param						= "";
				$param['P_CODE']			= $strP_CODE;
				$productMgr->getProdNotifyDelete($db,$param);
				foreach($arrProdNotifyItemName as $key => $strProdNotifyItemName){
					$strProdNotifyItemText		= $arrProdNotifyItemText[$key];
					$intProdNotifyNo			= $arrProdNotifyItemNo[$key];

					$param['PN_CODE']			= $strPN_CODE;
					$param['PN_NAME']			= $strProdNotifyItemName;
					$param['PN_TEXT']			= $strProdNotifyItemText;
					$param['PN_ORDER']			= $key + 1 ;

					$productMgr->getProdNotifyInsertUpdate($db,$param);
				}
			}

			$strUrl = $_SERVER['HTTP_REFERER'];

			//국가리스트
			$aryCountryList		= getCountryList();
			$aryCountryState	= getCommCodeList("STATE","");

			//국가코드명별 국가명설정
			$aryCountryListTotalAry		= getCountryListTotalAry();
			for($i=0;$i< sizeof($aryCountryListTotalAry) ; $i++){
				$aryCountryList[$aryCountryListTotalAry[$i][CT_CODE]] = $aryCountryListTotalAry[$i]["CT_NAME_{$strAdmSiteLng}"];
			}

			//언어별 상품 등록순서 처리 2015.05.13
			//사용하면 에러.(shopAdmin 상품수정(act.inc.php) 남덕희
			//if(!$strProdShopCountry) $strProdShopCountry = 'KR';
			/*
			$intCountry = array_search($strStLng,$aryRollCountry[$strProdShopCountry]);
			$intCountryCnt = $intCountry + 1;
			$strNextCountry = $aryRollCountry[$strProdShopCountry][$intCountryCnt];

			if($strNextCountry)
			{
				$strAddProdCountryUrl = "./?menuType=".$strMenuType."&mode=prodModify&lang={$strNextCountry}&prodShopCountry={$strProdShopCountry}&prodCode=".$strP_CODE."&".$strLinkPage;
			}

			//언어별 상품추가 체크
			if($strAddProdCountryUrl)
			{
				$strProdCountryCheck = "";
				$strProdCountryCheck .= "<script>";
				$strProdCountryCheck .= "
				if(confirm('\"".$aryCountryList[$strNextCountry]." ".$LNG_TRANS_CHAR["PS00084"]."')){
					location.href=\"".$strAddProdCountryUrl."\";
				}else{
					alert('".$LNG_TRANS_CHAR["PS00083"]."');
					location.href=\"".$strUrl."\";
				}
				";
				$strProdCountryCheck .= "</script>";
				echo $strProdCountryCheck;
				exit;
			}else{
				echo "<script>alert('".$LNG_TRANS_CHAR["PS00083"]."');</script>";
			}
			*/
			echo "<script>alert('".$LNG_TRANS_CHAR["PS00083"]."');</script>"; //제품수정이 완료되었습니다.
//			$strLinkPage  = "searchCate1=$strSearchHCode1&searchCate2=$strSearchHCode2";
//			$strLinkPage .= "&searchCate3=$strSearchHCode3&searchCate4=$strSearchHCode4";
//			$strLinkPage .= "&searchField=$strSearchField&searchKey=$strSearchKey&lang={$strStLng}&pageLine=$intPageLine";
//			$strLinkPage .= "&searchLaunchStartDt=$strSearchLaunchStartDt&searchLaunchEndDt=$strSearchLaunchEndDt";
//			$strLinkPage .= "&searchRepStartDt=$strSearchRepStartDt&searchRepEndDt=$strSearchRepEndDt";
//			$strLinkPage .= "&searchWebView=$strSearchWebView&searchMobileView=$strSearchMobileView";
//			$strLinkPage .= "&searchIcon1=$strSearchIcon1";
//			$strLinkPage .= "&searchIcon2=$strSearchIcon2";
//			$strLinkPage .= "&searchIcon3=$strSearchIcon3";
//			$strLinkPage .= "&searchIcon4=$strSearchIcon4";
//			$strLinkPage .= "&searchIcon5=$strSearchIcon5";
//			$strLinkPage .= "&searchIcon6=$strSearchIcon6";
//			$strLinkPage .= "&searchIcon7=$strSearchIcon7";
//			$strLinkPage .= "&searchIcon8=$strSearchIcon8";
//			$strLinkPage .= "&searchIcon9=$strSearchIcon9";
//			$strLinkPage .= "&searchIcon10=$strSearchIcon10&page=$intPage&prodLang=$strStLng&lang=$strStLng";
//			$strLinkPage .= "&searchShopNo=$strSearchShopNo";
//

			$strUrl = "./?menuType=".$strMenuType."&mode=prodModify&prodCode=".$strP_CODE."&".$strLinkPage;

		break;


		case "prodDelete":

			$productMgr->setP_CODE($strP_CODE);

			/* 주문 상품 체크 */
			$intProdOrderCnt = $productMgr->getProdOrderCount($db);
			if ($intProdOrderCnt > 0){
				goErrMsg("주문된 상품이 존재합니다.");
				exit;
			}

			/* 이미지 삭제 */
			$strProductImgPath = "upload/product/".substr($strP_CODE,0,8);
			for($i=1;$i<=28;$i++){

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
				} else if ($i >= 7 && $i <= 17){
					$strProdImgType = "view".($i-5);
				} else if ($i >= 18 && $i <= 28){
					$strProdImgType = "large".($i-16);
				}

				$productMgr->setPM_TYPE($strProdImgType);
				$aryProdImg[$i] = $productMgr->getProdImg($db);

				if (is_array($aryProdImg[$i]) && $aryProdImg[$i][0][PM_NO] > 0){

					if (SUBSTR($aryProdImg[$i][0][PM_REAL_NAME],0,4) != "http"){
						$fh->fileDelete("..".$aryProdImg[$i][0][PM_REAL_NAME]);
					}

					$productMgr->setPM_NO($aryProdImg[$i][0][PM_NO]);
					$productMgr->getProdImgDelete($db);
				}
			}

			$productMgr->getProdIconAllDelete($db);

			/* 상품 ITEM 국가별 삭제 */
			for($k=0;$k<sizeof($arySiteUseLng);$k++){
				if ($arySiteUseLng[$k]){
					$productMgr->setPI_LNG($arySiteUseLng[$k]);
					$productMgr->getProdItemLngDelete($db);
				}
			}
			$productMgr->getProdItemAllDelete($db);


			/* 옵션 국가별 삭제 */
			$productMgr->setPO_TYPE("O");
			$aryProdOpt = $productMgr->getProdOpt($db);
			if (is_array($aryProdOpt)){
				for($i=0;$i<sizeof($aryProdOpt);$i++){
					if ($aryProdOpt[$i][PO_NO] > 0){
						$productMgr->setPO_NO($aryProdOpt[$i][PO_NO]);

						for($k=0;$k<sizeof($arySiteUseLng);$k++){
							if ($arySiteUseLng[$k]){
								$productMgr->setP_LNG($arySiteUseLng[$k]);
								$productMgr->getProdOptAttrLangAllDelete($db);
							}
						}
						$productMgr->getProdOptAttrAllDelete($db);
					}
				}
			}

			for($k=0;$k<sizeof($arySiteUseLng);$k++){
				if ($arySiteUseLng[$k]){
					$productMgr->setP_LNG($arySiteUseLng[$k]);
					$productMgr->getProdOptLangAllDelete($db);
				}
			}
			$productMgr->getProdOptAllDelete($db);

			$productMgr->setPO_TYPE("A");
			$aryProdAddOpt = $productMgr->getProdOpt($db);
			if (is_array($aryProdAddOpt)){
				for($i=0;$i<sizeof($aryProdAddOpt);$i++){
					if ($aryProdAddOpt[$i][PO_NO] > 0){
						$productMgr->setPO_NO($aryProdAddOpt[$i][PO_NO]);

						for($k=0;$k<sizeof($arySiteUseLng);$k++){
							if ($arySiteUseLng[$k]){
								$productMgr->setP_LNG($arySiteUseLng[$k]);
								$productMgr->getProdAddOptAttrLangAllDelete($db);
							}
						}
						$productMgr->getProdAddOptAllDelete($db);
					}
				}
			}
			for($k=0;$k<sizeof($arySiteUseLng);$k++){
				if ($arySiteUseLng[$k]){
					$productMgr->setP_LNG($arySiteUseLng[$k]);
					$productMgr->getProdOptLangAllDelete($db);
				}
			}
			$productMgr->getProdOptLangAllDelete($db);


			for($k=0;$k<sizeof($arySiteUseLng);$k++){
				if ($arySiteUseLng[$k]){
					$productMgr->setP_LNG($arySiteUseLng[$k]);
					$productMgr->getProdInfoLngDelete($db);
				}
			}

			$productMgr->getProdDelete($db);

			$strLinkPage  = "searchCate1=$strSearchHCode1&searchCate2=$strSearchHCode2";
			$strLinkPage .= "&searchCate3=$strSearchHCode3&searchCate4=$strSearchHCode4";
			$strLinkPage .= "&searchField=$strSearchField&searchKey=$strSearchKey&pageLine=$intPageLine";
			$strLinkPage .= "&searchLaunchStartDt=$strSearchLaunchStartDt&searchLaunchEndDt=$strSearchLaunchEndDt";
			$strLinkPage .= "&searchRepStartDt=$strSearchRepStartDt&searchRepEndDt=$strSearchRepEndDt";
			$strLinkPage .= "&searchWebView=$strSearchWebView&searchMobileView=$strSearchMobileView";
			$strLinkPage .= "&searchIcon1=$strSearchIcon1";
			$strLinkPage .= "&searchIcon2=$strSearchIcon2";
			$strLinkPage .= "&searchIcon3=$strSearchIcon3";
			$strLinkPage .= "&searchIcon4=$strSearchIcon4";
			$strLinkPage .= "&searchIcon5=$strSearchIcon5";
			$strLinkPage .= "&searchIcon6=$strSearchIcon6";
			$strLinkPage .= "&searchIcon7=$strSearchIcon7";
			$strLinkPage .= "&searchIcon8=$strSearchIcon8";
			$strLinkPage .= "&searchIcon9=$strSearchIcon9";
			$strLinkPage .= "&searchIcon10=$strSearchIcon10&page=$intPage&lang=$strStLng";
			$strLinkPage .= "&searchShopNo=$strSearchShopNo";

			$strUrl = "./?menuType=".$strMenuType."&mode=prodList&".$strLinkPage;
		break;


		case "prodAllDelete":

			if (is_array($aryChkNo)){
				for($p=0;$p<sizeof($aryChkNo);$p++){

					if ($aryChkNo[$p]) {

						$strP_CODE = $aryChkNo[$p];
						$productMgr->setP_CODE($strP_CODE);

						/* 주문 상품 체크 */
						$intProdOrderCnt = $productMgr->getProdOrderCount($db);
						if ($intProdOrderCnt > 0){
							continue;
						}

						/* 이미지 삭제 */
						$strProductImgPath = "upload/product/".substr($strP_CODE,0,8);
						for($i=1;$i<=28;$i++){

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
							} else if ($i >= 7 && $i <= 17){
								$strProdImgType = "view".($i-5);
							} else if ($i >= 18 && $i <= 28){
								$strProdImgType = "large".($i-16);
							}

							$productMgr->setPM_TYPE($strProdImgType);
							$aryProdImg[$i] = $productMgr->getProdImg($db);

							if (is_array($aryProdImg[$i]) && $aryProdImg[$i][0][PM_NO] > 0){
								if (substr($aryProdImg[$i][0][PM_REAL_NAME],0,4) != "http"){
									$fh->fileDelete("..".$aryProdImg[$i][0][PM_REAL_NAME]);
								}

								$productMgr->setPM_NO($aryProdImg[$i][0][PM_NO]);
								$productMgr->getProdImgDelete($db);
							}
						}

						$productMgr->getProdIconAllDelete($db);

						/* 상품 ITEM 국가별 삭제 */
						for($k=0;$k<sizeof($arySiteUseLng);$k++){
							if ($arySiteUseLng[$k]){
								$productMgr->setPI_LNG($arySiteUseLng[$k]);
								$productMgr->getProdItemLngDelete($db);
							}
						}
						$productMgr->getProdItemAllDelete($db);


						/* 옵션 국가별 삭제 */
						$productMgr->setPO_TYPE("O");
						$aryProdOpt = $productMgr->getProdOpt($db);
						if (is_array($aryProdOpt)){
							for($i=0;$i<sizeof($aryProdOpt);$i++){
								if ($aryProdOpt[$i][PO_NO] > 0){
									$productMgr->setPO_NO($aryProdOpt[$i][PO_NO]);

									for($k=0;$k<sizeof($arySiteUseLng);$k++){
										if ($arySiteUseLng[$k]){
											$productMgr->setP_LNG($arySiteUseLng[$k]);
											$productMgr->getProdOptAttrLangAllDelete($db);
										}
									}
									$productMgr->getProdOptAttrAllDelete($db);
								}
							}
						}

						for($k=0;$k<sizeof($arySiteUseLng);$k++){
							if ($arySiteUseLng[$k]){
								$productMgr->setP_LNG($arySiteUseLng[$k]);
								$productMgr->getProdOptLangAllDelete($db);
							}
						}
						$productMgr->getProdOptAllDelete($db);

						$productMgr->setPO_TYPE("A");
						$aryProdAddOpt = $productMgr->getProdOpt($db);
						if (is_array($aryProdAddOpt)){
							for($i=0;$i<sizeof($aryProdAddOpt);$i++){
								if ($aryProdAddOpt[$i][PO_NO] > 0){
									$productMgr->setPO_NO($aryProdAddOpt[$i][PO_NO]);

									for($k=0;$k<sizeof($arySiteUseLng);$k++){
										if ($arySiteUseLng[$k]){
											$productMgr->setP_LNG($arySiteUseLng[$k]);
											$productMgr->getProdAddOptAttrLangAllDelete($db);
										}
									}
									$productMgr->getProdAddOptAllDelete($db);
								}
							}
						}
						for($k=0;$k<sizeof($arySiteUseLng);$k++){
							if ($arySiteUseLng[$k]){
								$productMgr->setP_LNG($arySiteUseLng[$k]);
								$productMgr->getProdOptLangAllDelete($db);
							}
						}
						$productMgr->getProdOptLangAllDelete($db);


						for($k=0;$k<sizeof($arySiteUseLng);$k++){
							if ($arySiteUseLng[$k]){
								$productMgr->setP_LNG($arySiteUseLng[$k]);
								$productMgr->getProdInfoLngDelete($db);
							}
						}

						$productMgr->getProdDelete($db);
					}
				}
			}

			$strLinkPage  = "searchCate1=$strSearchHCode1&searchCate2=$strSearchHCode2";
			$strLinkPage .= "&searchCate3=$strSearchHCode3&searchCate4=$strSearchHCode4";
			$strLinkPage .= "&searchField=$strSearchField&searchKey=$strSearchKey&pageLine=$intPageLine";
			$strLinkPage .= "&searchLaunchStartDt=$strSearchLaunchStartDt&searchLaunchEndDt=$strSearchLaunchEndDt";
			$strLinkPage .= "&searchRepStartDt=$strSearchRepStartDt&searchRepEndDt=$strSearchRepEndDt";
			$strLinkPage .= "&searchWebView=$strSearchWebView&searchMobileView=$strSearchMobileView";
			$strLinkPage .= "&searchIcon1=$strSearchIcon1";
			$strLinkPage .= "&searchIcon2=$strSearchIcon2";
			$strLinkPage .= "&searchIcon3=$strSearchIcon3";
			$strLinkPage .= "&searchIcon4=$strSearchIcon4";
			$strLinkPage .= "&searchIcon5=$strSearchIcon5";
			$strLinkPage .= "&searchIcon6=$strSearchIcon6";
			$strLinkPage .= "&searchIcon7=$strSearchIcon7";
			$strLinkPage .= "&searchIcon8=$strSearchIcon8";
			$strLinkPage .= "&searchIcon9=$strSearchIcon9";
			$strLinkPage .= "&searchIcon10=$strSearchIcon10&page=$intPage&lang=$strStLng";
			$strLinkPage .= "&searchShopNo=$strSearchShopNo";

			$strUrl = "./?menuType=".$strMenuType."&mode=prodList&".$strLinkPage;

		break;


		case "prodImgDel":

			$productMgr->setPM_NO($intPM_NO);
			$row = $productMgr->getProdImgView($db);

			if ($row){
				$fh->fileDelete("..".$row[PM_REAL_NAME]);
				$productMgr->getProdImgDelete($db);
			}

			$strLinkPage  = "searchCate1=$strSearchHCode1&searchCateHCode2=$strSearch2";
			$strLinkPage .= "&searchCate3=$strSearchHCode3&searchCate4=$strSearchHCode4";
			$strLinkPage .= "&searchField=$strSearchField&searchKey=$strSearchKey&lang={$strStLng}&pageLine=$intPageLine";
			$strLinkPage .= "&searchLaunchStartDt=$strSearchLaunchStartDt&searchLaunchEndDt=$strSearchLaunchEndDt";
			$strLinkPage .= "&searchRepStartDt=$strSearchRepStartDt&searchRepEndDt=$strSearchRepEndDt";
			$strLinkPage .= "&searchWebView=$strSearchWebView&searchMobileView=$strSearchMobileView";
			$strLinkPage .= "&searchIcon1=$strSearchIcon1";
			$strLinkPage .= "&searchIcon2=$strSearchIcon2";
			$strLinkPage .= "&searchIcon3=$strSearchIcon3";
			$strLinkPage .= "&searchIcon4=$strSearchIcon4";
			$strLinkPage .= "&searchIcon5=$strSearchIcon5";
			$strLinkPage .= "&searchIcon6=$strSearchIcon6";
			$strLinkPage .= "&searchIcon7=$strSearchIcon7";
			$strLinkPage .= "&searchIcon8=$strSearchIcon8";
			$strLinkPage .= "&searchIcon9=$strSearchIcon9";
			$strLinkPage .= "&searchIcon10=$strSearchIcon10&page=$intPage&prodLang=$strStLng&lang=$strStLng";
			$strLinkPage .= "&searchShopNo=$strSearchShopNo";

			$strUrl = "./?menuType=".$strMenuType."&mode=prodModify&".$strLinkPage."&prodCode=".$strP_CODE;

		break;

	case "prodCopy":

			/* 상품 코드 생성 */
			$productMgr->setP_CODE($strP_CODE);
			$strP_COPY_CODE = $productMgr->getProductCode($db);
			$productMgr->setP_COPY_CODE($strP_COPY_CODE);


			/* 상품 기본정보,항목추가 INSERT */
			//$productMgr->getProdCopyInsert($db);
			$productMgr->getProdCopyInsert2($db);

			/* 언어별 INSERT */
			for($k=0;$k<sizeof($arySiteUseLng);$k++){
				if ($arySiteUseLng[$k]){
					$productMgr->setP_CODE($strP_CODE);
					$productMgr->setP_LNG($arySiteUseLng[$k]);
					$aryProdInfoRow = $productMgr->getProdInfoSelectEx($db);

					if ($aryProdInfoRow){
						$productMgr->setP_CODE($strP_COPY_CODE);
						$productMgr->setP_NAME($aryProdInfoRow['P_NAME']);
						$productMgr->setP_SEARCH_TEXT($aryProdInfoRow['P_SEARCH_TEXT']);
						$productMgr->setP_WEB_TEXT($aryProdInfoRow['P_WEB_TEXT']);
						$productMgr->setP_MOB_TEXT($aryProdInfoRow['P_MOB_TEXT']);
						$productMgr->setP_MEMO($aryProdInfoRow['P_MEMO']);
						$productMgr->setP_DELIVERY_TEXT($aryProdInfoRow['P_DELIVERY_TEXT']);
						$productMgr->setP_RETURN_TEXT($aryProdInfoRow['P_RETURN_TEXT']);
						$productMgr->setP_ETC($aryProdInfoRow['P_ETC']);
						$productMgr->setP_PRICE_TEXT($aryProdInfoRow['P_PRICE_TEXT']);
						//웹,모바일 뷰 기능 추가. 남덕희
						$productMgr->setP_WEB_VIEW($aryProdInfoRow['P_WEB_VIEW']);
						$productMgr->setP_MOB_VIEW($aryProdInfoRow['P_MOB_VIEW']);
						$productMgr->getProdInfoInsert($db);
					}
				}
			}
			$productMgr->setP_CODE($strP_CODE);


			/* 같은 상품호출 함수를 쓰기 위해서 파라미터 변수 선언 */
			$paramCopyData			= "";
			$paramCopyData['MODE']	= "COPY";

			/* 상품 옵션 INSERT */
			$productMgr->setPO_TYPE("O");
			$aryProdOptList = $productMgr->getProdOpt($db);
			if (is_array($aryProdOptList)){
				for($i=0;$i<sizeof($aryProdOptList);$i++){

					$productMgr->setPO_TYPE($aryProdOptList[$i][PO_TYPE]);
					$productMgr->setPO_ESS($aryProdOptList[$i][PO_ESS]);
					$productMgr->getProdOptInsert($db,$paramCopyData);
					$intPO_NO = $db->getLastInsertID();


					/* 언어별 INSERT */
					for($k=0;$k<sizeof($arySiteUseLng);$k++){
						if ($arySiteUseLng[$k]){
							$productMgr->setP_LNG($arySiteUseLng[$k]);
							$productMgr->setPO_NO($aryProdOptList[$i][PO_NO]);
							$aryProdOptNameList = $productMgr->getProdOpt($db);

							if (is_array($aryProdOptNameList)){
								for($kk=0;$kk<sizeof($aryProdOptNameList);$kk++){
									$productMgr->setPO_NAME1($aryProdOptNameList[$kk][PO_NAME1]);
									$productMgr->setPO_NAME2($aryProdOptNameList[$kk][PO_NAME2]);
									$productMgr->setPO_NAME3($aryProdOptNameList[$kk][PO_NAME3]);
									$productMgr->setPO_NAME4($aryProdOptNameList[$kk][PO_NAME4]);
									$productMgr->setPO_NAME5($aryProdOptNameList[$kk][PO_NAME5]);
									$productMgr->setPO_NAME6($aryProdOptNameList[$kk][PO_NAME6]);
									$productMgr->setPO_NAME7($aryProdOptNameList[$kk][PO_NAME7]);
									$productMgr->setPO_NAME8($aryProdOptNameList[$kk][PO_NAME8]);
									$productMgr->setPO_NAME9($aryProdOptNameList[$kk][PO_NAME9]);
									$productMgr->setPO_NAME10($aryProdOptNameList[$kk][PO_NAME10]);
									$productMgr->setPO_NO($intPO_NO);
									$productMgr->getProdOptLngInsert($db);
								}
							}
						}
					}

					$productMgr->setP_LNG("");
					$productMgr->setPO_NO($aryProdOptList[$i][PO_NO]);
					$aryProdOptAttrList = $productMgr->getProdOptAttr($db);
					if (is_array($aryProdOptAttrList)){
						for($j=0;$j<sizeof($aryProdOptAttrList);$j++){
							$productMgr->setPO_NO($intPO_NO);
							$productMgr->setPOA_SALE_PRICE($aryProdOptAttrList[$j][POA_SALE_PRICE]);
							$productMgr->setPOA_CONSUMER_PRICE($aryProdOptAttrList[$j][POA_CONSUMER_PRICE]);
							$productMgr->setPOA_STOCK_PRICE($aryProdOptAttrList[$j][POA_STOCK_PRICE]);
							$productMgr->setPOA_POINT($aryProdOptAttrList[$j][POA_POINT]);
							$productMgr->setPOA_STOCK_QTY($aryProdOptAttrList[$j][POA_STOCK_QTY]);
							$productMgr->getProdOptAttrInsert($db);
							$intPOA_NO = $db->getLastInsertID();

							/* 언어별 INSERT */
							for($k=0;$k<sizeof($arySiteUseLng);$k++){
								if ($arySiteUseLng[$k]){
									$productMgr->setP_LNG($arySiteUseLng[$k]);
									$productMgr->setPO_NO($aryProdOptList[$i][PO_NO]);
									$productMgr->setPOA_NO($aryProdOptAttrList[$j][POA_NO]);
									$aryProdOptAttrNameList = $productMgr->getProdOptAttr($db);
									if (is_array($aryProdOptAttrNameList)){
										for($kk=0;$kk<sizeof($aryProdOptAttrNameList);$kk++){
											$productMgr->setPOA_NO($intPOA_NO);

											$productMgr->setPOA_ATTR1($aryProdOptAttrNameList[$kk][POA_ATTR1]);
											$productMgr->setPOA_ATTR2($aryProdOptAttrNameList[$kk][POA_ATTR2]);
											$productMgr->setPOA_ATTR3($aryProdOptAttrNameList[$kk][POA_ATTR3]);
											$productMgr->setPOA_ATTR4($aryProdOptAttrNameList[$kk][POA_ATTR4]);
											$productMgr->setPOA_ATTR5($aryProdOptAttrNameList[$kk][POA_ATTR5]);
											$productMgr->setPOA_ATTR6($aryProdOptAttrNameList[$kk][POA_ATTR6]);
											$productMgr->setPOA_ATTR7($aryProdOptAttrNameList[$kk][POA_ATTR7]);
											$productMgr->setPOA_ATTR8($aryProdOptAttrNameList[$kk][POA_ATTR8]);
											$productMgr->setPOA_ATTR9($aryProdOptAttrNameList[$kk][POA_ATTR9]);
											$productMgr->setPOA_ATTR10($aryProdOptAttrNameList[$kk][POA_ATTR10]);

											$productMgr->getProdOptAttrLngInsert($db);
										}
									}
								}
							}

						}
					}
				}
			}
			/* 상품 옵션 INSERT */

			/* 추가옵션 */
			$productMgr->setPO_NO(0);
			$productMgr->setPO_TYPE("A");
			$aryProdAddOptList = $productMgr->getProdOpt($db);
			if (is_array($aryProdAddOptList)){

				for($i=0;$i<sizeof($aryProdAddOptList);$i++){
					$productMgr->setPO_TYPE($aryProdAddOptList[$i][PO_TYPE]);
					$productMgr->setPO_ESS($aryProdAddOptList[$i][PO_ESS]);
					$productMgr->getProdOptInsert($db,$paramCopyData);
					$intPO_NO = $db->getLastInsertID();

					/* 언어별 INSERT */
					for($k=0;$k<sizeof($arySiteUseLng);$k++){
						if ($arySiteUseLng[$k]){
							$productMgr->setP_LNG($arySiteUseLng[$k]);
							$productMgr->setPO_NO($aryProdAddOptList[$i][PO_NO]);
							$aryProdAddOptNameList = $productMgr->getProdOpt($db);

							if (is_array($aryProdAddOptNameList)){
								for($kk=0;$kk<sizeof($aryProdAddOptNameList);$kk++){
									$productMgr->setPO_NAME1($aryProdAddOptNameList[$kk][PO_NAME1]);
									$productMgr->setPO_NAME2($aryProdAddOptNameList[$kk][PO_NAME2]);
									$productMgr->setPO_NAME3($aryProdAddOptNameList[$kk][PO_NAME3]);
									$productMgr->setPO_NAME4($aryProdAddOptNameList[$kk][PO_NAME4]);
									$productMgr->setPO_NAME5($aryProdAddOptNameList[$kk][PO_NAME5]);
									$productMgr->setPO_NAME6($aryProdAddOptNameList[$kk][PO_NAME6]);
									$productMgr->setPO_NAME7($aryProdAddOptNameList[$kk][PO_NAME7]);
									$productMgr->setPO_NAME8($aryProdAddOptNameList[$kk][PO_NAME8]);
									$productMgr->setPO_NAME9($aryProdAddOptNameList[$kk][PO_NAME9]);
									$productMgr->setPO_NAME10($aryProdAddOptNameList[$kk][PO_NAME10]);
									$productMgr->setPO_NO($intPO_NO);
									$productMgr->getProdOptLngInsert($db);
								}
							}
						}
					}

					/* 추가 옵션 속성 시작 */
					$productMgr->setP_LNG("");
					$productMgr->setPAO_NO("");
					$productMgr->setPO_NO($aryProdAddOptList[$i][PO_NO]);
					$aryProdAddOptAttrList = $productMgr->getProdAddOpt($db);
					if (is_array($aryProdAddOptAttrList)){
						for($j=0;$j<sizeof($aryProdAddOptAttrList);$j++){
							$productMgr->setPO_NO($intPO_NO);
							$productMgr->setPAO_PRICE($aryProdAddOptAttrList[$j][PAO_PRICE]);
							$productMgr->getProdAddOptInsert($db);
							$intPAO_NO = $db->getLastInsertID();

							/* 언어별 INSERT */
							for($k=0;$k<sizeof($arySiteUseLng);$k++){
								if ($arySiteUseLng[$k]){
									$productMgr->setP_LNG($arySiteUseLng[$k]);
									$productMgr->setPO_NO($aryProdAddOptList[$i][PO_NO]);
									$productMgr->setPAO_NO($aryProdAddOptAttrList[$j][PAO_NO]);
									$aryProdAddOptAttrNameList = $productMgr->getProdAddOpt($db);

									if (is_array($aryProdAddOptAttrNameList)){
										for($kk=0;$kk<sizeof($aryProdAddOptAttrNameList);$kk++){
											$productMgr->setPAO_NO($intPAO_NO);
											$productMgr->setPAO_NAME($aryProdAddOptAttrNameList[$kk][PAO_NAME]);
											$productMgr->getProdAddOptLngInsert($db);
										}
									}
								}
							}
						}
					}
					/* 추가 옵션 속성 종료 */
				}
			}

			/* 상품 ITEM INSERT 시작 */
//			$productMgr->setP_LNG("");
//			$aryProdItemList = $productMgr->getProdItem($db);
//			if (is_array($aryProdItemList)){
//				for($i=0;$i<sizeof($aryProdItemList);$i++){
//					$productMgr->setPI_NO($aryProdItemList[$i][PI_NO]);
//					$productMgr->getProdCopyItemInsert($db);
//				}
//			}
			$productMgr->setP_LNG("");
			$aryProdItemList = $productMgr->getProdItem($db);
			if (is_array($aryProdItemList)){
				for($i=0;$i<sizeof($aryProdItemList);$i++){
					$productMgr->setPI_ORDER($aryProdItemList[$i][PI_ORDER]);
					$productMgr->getProdItemInsert($db,$paramCopyData);
					$intPI_NO = $db->getLastInsertID();

					for($k=0;$k<sizeof($arySiteUseLng);$k++){
						if ($arySiteUseLng[$k]){
							$productMgr->setP_LNG($arySiteUseLng[$k]);
							$productMgr->setPI_NO($aryProdItemList[$i][PI_NO]);
							$aryProdCopyItemList = $productMgr->getProdItem($db);
							if (is_array($aryProdCopyItemList)){
								$productMgr->setPI_LNG($arySiteUseLng[$k]);
								$productMgr->setPI_NAME($aryProdCopyItemList[0]['PI_NAME']);
								$productMgr->setPI_TEXT($aryProdCopyItemList[0]['PI_TEXT']);
								$productMgr->setPI_NO($intPI_NO);
								$productMgr->getProdItemLngInsert($db);
							}
						}
					}
				}
			}
			/* 상품 ITEM INSERT 종료 */

			/* 상품 이미지 INSERT */
			$prodImgMakeFolderResult = getMakeFolder("product",substr($strP_COPY_CODE,0,8));
			if ($prodImgMakeFolderResult){

				$strProductImgPath = "upload/product/".substr($strP_COPY_CODE,0,8);
				for($i=1;$i<=28;$i++){

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
					} else if ($i >= 7 && $i <= 17){
						$strProdImgType = "view".($i-5);
					} else if ($i >= 18 && $i <= 28){
						$strProdImgType = "large".($i-16);
					}

					$productMgr->setPM_TYPE($strProdImgType);
					$aryProdImgInfo = $productMgr->getProdImg($db);
					if (is_array($aryProdImgInfo)){
						if (SUBSTR($aryProdImgInfo[0][PM_REAL_NAME],0,4) == "http"){

							$productMgr->setPM_SAVE_NAME($aryProdImgInfo[0][PM_SAVE_NAME]);
							$productMgr->setPM_REAL_NAME($aryProdImgInfo[0][PM_REAL_NAME]);

							$productMgr->getProdCopyImgInsert($db);

						} else {
							$strFileExt = explode(".",$aryProdImgInfo[0][PM_SAVE_NAME]);
							$strFileExt	= strtolower($strFileExt[sizeOf($strFileExt)-1]);

							$productMgr->setPM_SAVE_NAME($aryProdImgInfo[0][PM_SAVE_NAME]);
							$productMgr->setPM_REAL_NAME("/".$strProductImgPath."/prodImg".$i."/".$strP_COPY_CODE.".".$strFileExt);

							$productMgr->getProdCopyImgInsert($db);

							copy($S_DOCUMENT_ROOT.$S_SHOP_HOME.$aryProdImgInfo[0][PM_REAL_NAME],$S_DOCUMENT_ROOT.$S_SHOP_HOME."/".$strProductImgPath."/prodImg".$i."/".$strP_COPY_CODE.".".$strFileExt);
						}
					}
				}
			}

			/* 상품 첨부파일 INSERT */
			$prodFileMakeFolderResult = getMakeFolder("product",substr($strP_COPY_CODE,0,8));
			if ($prodFileMakeFolderResult){

				$strProductFilePath = "upload/product/".substr($strP_COPY_CODE,0,8);
				for($i=1;$i<=3;$i++){

					$strProdFileType = "file".$i;
					$productMgr->setPM_TYPE($strProdFileType);
					$aryProdImgInfo = $productMgr->getProdImg($db);
					if (is_array($aryProdImgInfo)){
						$strFileExt = explode(".",$aryProdImgInfo[0][PM_SAVE_NAME]);
						$strFileExt	= strtolower($strFileExt[sizeOf($strFileExt)-1]);

						$productMgr->setPM_SAVE_NAME($aryProdImgInfo[0][PM_SAVE_NAME]);
						$productMgr->setPM_REAL_NAME("/".$strProductImgPath."/prodFile".$i."/".$strP_COPY_CODE.".".$strFileExt);
						$productMgr->getProdCopyImgInsert($db);

						copy($S_DOCUMENT_ROOT.$S_SHOP_HOME.$aryProdImgInfo[0][PM_REAL_NAME],$S_DOCUMENT_ROOT.$S_SHOP_HOME."/".$strProductImgPath."/prodFile".$i."/".$strP_COPY_CODE.".".$strFileExt);
					}
				}
			}


		//복사시 바로노출 입점사인경우 승인 처리. 남덕희
		// S : 입점몰, A : 최고관리자 (아마도...)
		if ($a_admin_type == "S") {
			require_once MALL_CONF_LIB . "ShopMgr.php";
			$shopMgr = new ShopMgr();

			$shopMgr->setSH_NO($a_admin_shop_no);
			$shopInfo = $shopMgr->getShopView($db);
			if ($shopInfo['SH_COM_PROD_AUTH'] == "Y") {
//				$productMgr->setP_WEB_VIEW("Y");
//				$productMgr->setP_MOB_VIEW("Y");
				$productMgr->setP_CODE($strP_COPY_CODE);
				$productMgr->setP_APPR("Y");
				$productMgr->getProdApprUpdate($db);
			}

		} else if ($a_admin_type == "A") {
//			$productMgr->setP_WEB_VIEW("Y");
//			$productMgr->setP_MOB_VIEW("Y");
			$productMgr->setP_CODE($strP_COPY_CODE);
			$productMgr->setP_APPR("Y");
			$productMgr->getProdApprUpdate($db);
		}



			$db->disConnect();

			goLayerPopClose($LNG_TRANS_CHAR["PS00025"]); //선택하신 상품이 복사되었습니다.
			exit;

		break;

		case "prodShareMultiInsert":

			## STEP 1.
			## 언어 설정
			$productMgr->setP_LNG($strStLng);

			## STEP 2.
			## 상품코드 분리
			$strP_CODE_MULTI	= $_POST["prodCodeMulti"]	? $_POST["prodCodeMulti"]	: $_REQUEST["prodCodeMulti"];
			$aryP_CODE			= explode(",", $strP_CODE_MULTI);
			foreach($aryP_CODE as $p_code):
				$productMgr->setP_CODE($p_code);
				$prodRow = $productMgr->getProdView($db);
				if($prodRow['P_CATE'] == $strP_CATE){ continue; }
				$intCnt = $productMgr->getProdShareDupCount($db);
				if($intCnt>0) { continue; }
				$productMgr->getProdShareInsert($db);

				/** 2103.06.27 kim hee sung, 상점정보 **/
				/** 설명 : 입점몰 상품 등록시 승인이 필요한 경우, 수정을 하면, 미승인 상태로 변경이 됩니다.(정훈씨 요청) **/
				if($a_admin_type == "S"): // 입점몰인 경우.
					require_once MALL_CONF_LIB."ShopMgr.php";
					$shopMgr = new ShopMgr();

					$shopMgr->setSH_NO($a_admin_shop_no);
					$shopInfo = $shopMgr->getShopView($db);

					if($shopInfo['SH_COM_PROD_AUTH'] == "Y"): // 승인이 필요한 경우
						$param['p_code']			= $p_code;
						$param['p_web_view']		= "N";
						$param['p_mob_view']		= "N";
						$productMgr->getProdViewUpdate($db, $param);
					endif;
				endif;
			endforeach;

			## STEP 3.
			## Json 전달
			$result[0][MSG]			= "";
			$result[0][RET]			= "Y";
			$result_array = json_encode($result);

			$db->disConnect();
			echo $result_array;
			exit;

		break;

		case "prodShareInsert":

			$result_array = array();

			$productMgr->setP_LNG($strStLng);
			$prodRow = $productMgr->getProdView($db);

			if ($prodRow[P_CATE] == $strP_CATE){
				$result[0][MSG]			= "이미 등록된 카테고리입니다.";
				$result[0][RET]			= "N";
				$result_array = json_encode($result);

				$db->disConnect();
				echo $result_array;
				exit;
			}


			$intCnt = $productMgr->getProdShareDupCount($db);
			if ($intCnt > 0) {

				$result[0][MSG]			= "이미 공유로 설정된 카테고리입니다.";
				$result[0][RET]			= "N";

				$result_array = json_encode($result);

				$db->disConnect();
				echo $result_array;
				exit;
			}

			$productMgr->getProdShareInsert($db);

			/** 2103.06.27 kim hee sung, 상점정보 **/
			/** 설명 : 입점몰 상품 등록시 승인이 필요한 경우, 수정을 하면, 미승인 상태로 변경이 됩니다.(정훈씨 요청) **/
			if($a_admin_type == "S"): // 입점몰인 경우.
				require_once MALL_CONF_LIB."ShopMgr.php";
				$shopMgr = new ShopMgr();

				$shopMgr->setSH_NO($a_admin_shop_no);
				$shopInfo = $shopMgr->getShopView($db);

				if($shopInfo['SH_COM_PROD_AUTH'] == "Y"): // 승인이 필요한 경우
					$param['p_code']			= $strP_CODE;
					$param['p_web_view']		= "N";
					$param['p_mob_view']		= "N";
					$productMgr->getProdViewUpdate($db, $param);
				endif;
			endif;

			$aryProdShareList  = $productMgr->getProdShareList($db);
			$strShareHtml = "<div id=\"divProdShareText_\"".$strP_CODE.">";
			if (is_array($aryProdShareList)){
				for($j=0;$j<sizeof($aryProdShareList);$j++){
					$strShareHtml .= "<span><font color='#ffffff'>상품공유:</font></span>".getCateName($aryProdShareList[$j][PS_P_CATE],$strStLng);
				}
			}
			$strShareHtml .= "</div>";
			$result[0][MSG]			= $strShareHtml;

			$result[0][RET]			= "Y";
			$result_array = json_encode($result);

			$db->disConnect();
			echo $result_array;
			exit;

		break;

		case "prodShareDelete":

			$productMgr->setPS_NO($intPS_NO);
			$productMgr->getProdShareDelete($db);

			$aryProdShareList  = $productMgr->getProdShareList($db);

			/** 2103.06.27 kim hee sung, 상점정보 **/
			/** 설명 : 입점몰 상품 등록시 승인이 필요한 경우, 수정을 하면, 미승인 상태로 변경이 됩니다.(정훈씨 요청) **/
			if($a_admin_type == "S"): // 입점몰인 경우.
				require_once MALL_CONF_LIB."ShopMgr.php";
				$shopMgr = new ShopMgr();

				$shopMgr->setSH_NO($a_admin_shop_no);
				$shopInfo = $shopMgr->getShopView($db);

				if($shopInfo['SH_COM_PROD_AUTH'] == "Y"): // 승인이 필요한 경우
					$param['p_code']			= $strP_CODE;
					$param['p_web_view']		= "N";
					$param['p_mob_view']		= "N";
					$productMgr->getProdViewUpdate($db, $param);
				endif;
			endif;

			$strShareHtml = "<div id=\"divProdShareText_\"".$strP_CODE.">";
			if (is_array($aryProdShareList)){
				for($j=0;$j<sizeof($aryProdShareList);$j++){
					$strShareHtml .= "<span><font color='#ffffff'>상품공유:</font></span>".getCateName($aryProdShareList[$j][PS_P_CATE],$strStLng);
				}
			}
			$strShareHtml .= "</div>";
			$result[0][MSG]			= $strShareHtml;
			$result_array = array();
			//$result[0][MSG]			= "";
			$result[0][RET]			= "Y";
			$result_array = json_encode($result);

			$db->disConnect();
			echo $result_array;
			exit;
		break;

		case "prodShareSave":

			$aryProdCode	= $_POST["prodCode"]		? $_POST["prodCode"]		: $_REQUEST["prodCode"];
			$strCATE_CODE	= $_POST["cateCode"]		? $_POST["cateCode"]		: $_REQUEST["cateCode"];
			$intCateLevel	= $_POST["cateLevel"]		? $_POST["cateLevel"]		: $_REQUEST["cateLevel"];

			$productMgr->setP_CATE($strCATE_CODE);
			$strProdCodeNoList = "";

			if (is_array($aryProdCode)){

				for($i=0;$i<sizeof($aryProdCode);$i++){
					$productMgr->setP_CODE($aryProdCode[$i]);

					if ($productMgr->getProdShareDupCount($db) == 0){
						$productMgr->getProdShareInsert($db);
						$intPS_NO = $db->getLastInsertID();
					} else {
						$intPS_NO = $productMgr->getProdShareNo($db);
					}
					$strProdCodeNoList .= $intPS_NO.",";
				}

				if ($strProdCodeNoList){
					$productMgr->setPS_NO_ALL(SUBSTR($strProdCodeNoList,0,STRLEN($strProdCodeNoList)-1));
					$productMgr->getProdShareAllDelete($db);
				}
			} else {
				$cateMgr->setCL_LNG($strStLng);
				$cateMgr->setC_CODE($strCATE_CODE);

				$aryProdShareList = $cateMgr->getCateShareList($db);
				for($i=0;$i<sizeof($aryProdShareList);$i++){
					$productMgr->setPS_NO($aryProdShareList[$i][PS_NO]);
					$productMgr->getProdShareDelete($db);
				}
			}

			$strUrl = "./?menuType=product&mode=popCateShareList&cateCode=".$strCATE_CODE."&cateLevel=".$intCateLevel;
		break;

		case "prodAllUpdate":

			if (is_array($aryChkNo)){
				for($p=0;$p<sizeof($aryChkNo);$p++){

					if ($aryChkNo[$p]) {

						$strP_CODE = $aryChkNo[$p];
						$productMgr->setP_CODE($strP_CODE);
						$productMgr->setP_LNG($strStLng);
						$prodRow = $productMgr->getProdView($db);

						$intP_SALE_PRICE		= $_POST["sale_price_".$strP_CODE]			? $_POST["sale_price_".$strP_CODE]			: $_REQUEST["sale_price_".$strP_CODE];
						$intP_CONSUMER_PRICE	= $_POST["consumer_price_".$strP_CODE]		? $_POST["consumer_price_".$strP_CODE]		: $_REQUEST["consumer_price_".$strP_CODE];
						$intP_STOCK_PRICE		= $_POST["stock_price_".$strP_CODE]			? $_POST["stock_price_".$strP_CODE]			: $_REQUEST["stock_price_".$strP_CODE];
						$intP_POINT				= $_POST["point_".$strP_CODE]				? $_POST["point_".$strP_CODE]				: $_REQUEST["point_".$strP_CODE];
						$intP_QTY				= $_POST["qty_".$strP_CODE]					? $_POST["qty_".$strP_CODE]					: $_REQUEST["qty_".$strP_CODE];

						if(!$intP_SALE_PRICE)		{ $intP_SALE_PRICE			= 0; }
						if(!$intP_CONSUMER_PRICE)	{ $intP_CONSUMER_PRICE		= 0; }
						if(!$intP_STOCK_PRICE)		{ $intP_STOCK_PRICE			= 0; }
						if(!$intP_POINT)			{ $intP_POINT				= 0; }
						if(!$intP_QTY)				{ $intP_QTY					= 0; }

						##무제한/품절 상품
						if($prodRow['P_STOCK_LIMIT'] == "Y" || $prodRow['P_STOCK_OUT'] == "Y"){
							$intP_QTY = 0;
						}

//						if ($intP_QTY == "0" || $intP_QTY == "무한대") {
//							$intP_QTY = 0;
//							$strP_STOCK_LIMIT = "Y";
//						} else {
//							if (is_numeric($intP_QTY)) {
//								$strP_STOCK_LIMIT = "N";
//							} else {
//								$intP_QTY = 0;
//								$strP_STOCK_LIMIT = "Y";
//							}
//						}

						$productMgr->setP_SALE_PRICE(STR_REPLACE(",","",$intP_SALE_PRICE));
						$productMgr->setP_CONSUMER_PRICE(STR_REPLACE(",","",$intP_CONSUMER_PRICE));
						$productMgr->setP_STOCK_PRICE(STR_REPLACE(",","",$intP_STOCK_PRICE));
						$productMgr->setP_POINT(STR_REPLACE(",","",$intP_POINT));
						$productMgr->setP_QTY($intP_QTY);
						$productMgr->getProdAllUpdate($db);
					}
				}
			}

			$strUrl = $_SERVER['HTTP_REFERER'];

/*			$strLinkPage  = "searchCate1=$strSearchHCode1&searchCate2=$strSearchHCode2";
			$strLinkPage .= "&searchCate3=$strSearchHCode3&searchCate4=$strSearchHCode4";
			$strLinkPage .= "&searchField=$strSearchField&searchKey=$strSearchKey&pageLine=$intPageLine";
			$strLinkPage .= "&searchLaunchStartDt=$strSearchLaunchStartDt&searchLaunchEndDt=$strSearchLaunchEndDt";
			$strLinkPage .= "&searchRepStartDt=$strSearchRepStartDt&searchRepEndDt=$strSearchRepEndDt";
			$strLinkPage .= "&searchWebView=$strSearchWebView&searchMobileView=$strSearchMobileView";
			$strLinkPage .= "&searchIcon1=$strSearchIcon1";
			$strLinkPage .= "&searchIcon2=$strSearchIcon2";
			$strLinkPage .= "&searchIcon3=$strSearchIcon3";
			$strLinkPage .= "&searchIcon4=$strSearchIcon4";
			$strLinkPage .= "&searchIcon5=$strSearchIcon5";
			$strLinkPage .= "&searchIcon6=$strSearchIcon6";
			$strLinkPage .= "&searchIcon7=$strSearchIcon7";
			$strLinkPage .= "&searchIcon8=$strSearchIcon8";
			$strLinkPage .= "&searchIcon9=$strSearchIcon9";
			$strLinkPage .= "&searchIcon10=$strSearchIcon10&page=$intPage";
			$strLinkPage .= "&searchShopNo=$strSearchShopNo";

			$strUrl = "./?menuType=".$strMenuType."&mode=prodList&".$strLinkPage;
*/
		break;

		case "prodCateUpdate":
			if (is_array($aryChkNo)){
				for($p=0;$p<sizeof($aryChkNo);$p++){

					if ($aryChkNo[$p]) {

						$productMgr->setP_CODE($aryChkNo[$p]);
						$productMgr->getProdCateUpdate($db);

						/** 2103.06.27 kim hee sung, 상점정보 **/
						/** 설명 : 입점몰 상품 등록시 승인이 필요한 경우, 수정을 하면, 미승인 상태로 변경이 됩니다.(정훈씨 요청) **/
						if($a_admin_type == "S"): // 입점몰인 경우.
							require_once MALL_CONF_LIB."ShopMgr.php";
							$shopMgr = new ShopMgr();

							$shopMgr->setSH_NO($a_admin_shop_no);
							$shopInfo = $shopMgr->getShopView($db);

							if($shopInfo['SH_COM_PROD_AUTH'] == "Y"): // 승인이 필요한 경우
								$param['p_code']			= $aryChkNo[$p];
								$param['p_web_view']		= "N";
								$param['p_mob_view']		= "N";
								$productMgr->getProdViewUpdate($db, $param);
							endif;
						endif;
					}
				}
			}

			$result_array = array();
			$result[0][RET]	= "Y";
			$result_array	= json_encode($result);

			$db->disConnect();
			echo $result_array;
			exit;

		break;



	}


?>