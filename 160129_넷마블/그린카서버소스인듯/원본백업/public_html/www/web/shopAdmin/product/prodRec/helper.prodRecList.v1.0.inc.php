<?
	require_once MALL_CONF_LIB."ProductAdmMgr.php";
	$productMgr = new ProductAdmMgr();		

	/*##################################### Parameter 셋팅 #####################################*/
	$strSearchField = $_POST["searchField"]		? $_POST["searchField"]		: $_REQUEST["searchField"];
	$strSearchKey	= $_POST["searchKey"]		? $_POST["searchKey"]		: $_REQUEST["searchKey"];
	$intPage		= $_POST["page"]			? $_POST["page"]			: $_REQUEST["page"];
	$intPageLine	= $_POST["pageLine"]		? $_POST["pageLine"]		: $_REQUEST["pageLine"];

	$strP_CODE		= $_POST["prodCode"]		? $_POST["prodCode"]		: $_REQUEST["prodCode"];
	
	$strSearchHCode1		= $_POST["searchCateHCode1"]		? $_POST["searchCateHCode1"]		: $_REQUEST["searchCateHCode1"];
	$strSearchHCode2		= $_POST["searchCateHCode2"]		? $_POST["searchCateHCode2"]		: $_REQUEST["searchCateHCode2"];
	$strSearchHCode3		= $_POST["searchCateHCode3"]		? $_POST["searchCateHCode3"]		: $_REQUEST["searchCateHCode3"];
	$strSearchHCode4		= $_POST["searchCateHCode4"]		? $_POST["searchCateHCode4"]		: $_REQUEST["searchCateHCode4"];

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
	
	$strProdOrder			= $_POST["order"]					? $_POST["order"]					: $_REQUEST["order"];
	if (!$strProdOrder) $strProdOrder = "default";
	/*##################################### Parameter 셋팅 #####################################*/
	
	/* 언어 선택 */
	$productMgr->setP_LNG($strStLng);

	/* 검색부분 */
	
	$productMgr->setSearchHCode1($strSearchHCode1);
	$productMgr->setSearchHCode2($strSearchHCode2);
	$productMgr->setSearchHCode3($strSearchHCode3);
	$productMgr->setSearchHCode4($strSearchHCode4);

	$productMgr->setSearchField($strSearchField);
	$productMgr->setSearchKey($strSearchKey);
	$productMgr->setSearchWebView($strSearchWebView);
	$productMgr->setSearchMobileView($strSearchMobileView);

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
	
	if ($a_admin_type == "S") $productMgr->setSearchShopNo($a_admin_shop_no);
	else {
		if ($strSearchShopNo && $strSearchShopNo != "0"){
			$productMgr->setSearchShopNo($strSearchShopNo);
		}
	}
	/* 검색부분 */

	$intPageBlock	= 10;
//			$intPageLine	= 10;
	if(!$intPageLine) $intPageLine = 10;			
	$productMgr->setPageLine($intPageLine);

	$intTotal	= $productMgr->getProdTotal($db);
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
	$productMgr->setSearchSort($strProdOrder);
	$result = $productMgr->getProdList($db);
	$intListNum = $intTotal - ($intPageLine *($intPage-1));		

	/* 진열장 */
	$cateMgr->setIC_TYPE("MAIN");
	$aryProdMainDisplayList = $cateMgr->getProdDisplayList($db);

	$cateMgr->setIC_TYPE("SUB");
	$aryProdSubDisplayList = $cateMgr->getProdDisplayList($db);

	$linkPage  = "?menuType=$strMenuType&mode=$strMode&searchCateHCode1=$strSearchHCode1&searchCateHCode2=$strSearchHCode2";
	$linkPage .= "&searchCateHCode3=$strSearchHCode3&searchCateHCode4=$strSearchHCode4";
	$linkPage .= "&searchField=$strSearchField&searchKey=$strSearchKey";
	$linkPage .= "&searchWebView=$strSearchWebView&searchMobileView=$strSearchMobileView";
	$linkPage .= "&searchIcon1=$strSearchIcon1";
	$linkPage .= "&searchIcon2=$strSearchIcon2";
	$linkPage .= "&searchIcon3=$strSearchIcon3";
	$linkPage .= "&searchIcon4=$strSearchIcon4";
	$linkPage .= "&searchIcon5=$strSearchIcon5";
	$linkPage .= "&searchIcon6=$strSearchIcon6";
	$linkPage .= "&searchIcon7=$strSearchIcon7";
	$linkPage .= "&searchIcon8=$strSearchIcon8";
	$linkPage .= "&searchIcon9=$strSearchIcon9";
	$linkPage .= "&searchIcon10=$strSearchIcon10&pageLine=$intPageLine&page=";


?>