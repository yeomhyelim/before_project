<?
	require_once MALL_CONF_LIB."CateMgr.php";
	require_once MALL_CONF_LIB."ProductAdmMgr.php";
	
	$cateMgr = new CateMgr();		
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
	
	$strSearchSortCol		= $_POST["searchSortCol"]			? $_POST["searchSortCol"]			: $_REQUEST["searchSortCol"];
	$strSearchSort			= $_POST["searchSort"]				? $_POST["searchSort"]				: $_REQUEST["searchSort"];
	if (!$strSearchSort) $strSearchSort = "desc";
	if ($strSearchWebView == "A") $strSearchWebView = "";
	/*##################################### Parameter 셋팅 #####################################*/

	switch($strMode){

		case "prodWishList":

			/* 리스트 페이지 라인 쿠키 설정 */
			if (!$intPageLine){
				$intPageLine = $_COOKIE["COOKIE_ADM_PROD_WISH_LINE"] ? $_COOKIE["COOKIE_ADM_PROD_WISH_LINE"] : 50;
			} else {
				setCookie("COOKIE_ADM_PROD_WISH_LINE",$intPageLine,time()+(86400 * 30),"/shopAdmin");
			}
			/* 리스트 페이지 라인 쿠키 설정 */

			/* 관리자 Sub Menu 권한 설정 */
			$strLeftMenuCode01 = "";
			$strLeftMenuCode02 = "";
			/* 관리자 Sub Menu 권한 설정 */
			
			/* 언어 선택 */
			$productMgr->setP_LNG($strStLng);
			
			if ($strProductVersion  = "v2.0"){
				if ($strSearchHCode2) $strSearchHCode2 = substr($strSearchHCode2,3,3);
				if ($strSearchHCode3) $strSearchHCode3 = substr($strSearchHCode2,6,3);
				if ($strSearchHCode4) $strSearchHCode4 = substr($strSearchHCode2,9,3);
			}
			/* 검색부분 */
			$productMgr->setSearchHCode1($strSearchHCode1);
			$productMgr->setSearchHCode2($strSearchHCode2);
			$productMgr->setSearchHCode3($strSearchHCode3);
			$productMgr->setSearchHCode4($strSearchHCode4);

			$productMgr->setSearchField($strSearchField);
			$productMgr->setSearchKey($strSearchKey);
			$productMgr->setSearchWebView($strSearchWebView);
			$productMgr->setSearchMobileView($strSearchMobileView);

			$productMgr->setSearchSortCol($strSearchSortCol);
			$productMgr->setSearchSort($strSearchSort);

			/* 검색부분 */

			$intPageBlock	= 10;
//			$intPageLine	= 10;
			if(!$intPageLine) $intPageLine = 10;			
			$productMgr->setPageLine($intPageLine);
	
			$intTotal	= $productMgr->getProdWishCartTotal($db);
			$intTotPage	= ceil($intTotal / $productMgr->getPageLine());
			//echo $db->query;

			if(!$intPage)	$intPage =1;

			if ($intTotal==0) {
				$intFirst	= 1;
				$intLast	= 0;			
			} else {
				$intFirst	= $intPageLine *($intPage -1);
				$intLast	= $intPageLine * $intPage;
			}
			$productMgr->setLimitFirst($intFirst);

			$result = $productMgr->getProdWishCartList($db);
			//echo $db->query;
			$intListNum = $intTotal - ($intPageLine *($intPage-1));		
			
			$linkPage  = "?menuType=$strMenuType&mode=$strMode&searchCateHCode1=$strSearchHCode1&searchCateHCode2=$strSearchHCode2";
			$linkPage .= "&searchCateHCode3=$strSearchHCode3&searchCateHCode4=$strSearchHCode4";
			$linkPage .= "&searchField=$strSearchField&searchKey=$strSearchKey";
			$linkPage .= "&searchWebView=$strSearchWebView&searchMobileView=$strSearchMobileView";
			$linkPage .= "&searchSortCol=$strSearchSortCol&searchSort=$strSearchSort&pageLine=$intPageLine&page=";

			## 상품 출력(다국어)사용 여부
			if ($S_PROD_MANY_LANG_VIEW == "Y"){
				$aryUseLng		= explode("/",$S_USE_LNG);
				$intUseLngCount	= count($aryUseLng);
			}
		break;
	}
?>
