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
	
	$aryChkNo				= $_POST["chkNo"]					? $_POST["chkNo"]					: $_REQUEST["chkNo"];
	$strViewStatus			= $_POST["viewStatus"]				? $_POST["viewStatus"]				: $_REQUEST["viewStatus"];
	
	/*##################################### Parameter 셋팅 #####################################*/

	$strLinkPage  = "searchCateHCode1=$strSearchHCode1&searchCateHCode2=$strSearchHCode2";
	$strLinkPage .= "&searchCateHCode3=$strSearchHCode3&searchCateHCode4=$strSearchHCode4";
	$strLinkPage .= "&searchField=$strSearchField&searchKey=$strSearchKey";
	$strLinkPage .= "&searchWebView=$strSearchWebView&searchMobileView=$strSearchMobileView&page=$intPage";
			
//	echo $strAct;

	switch ($strAct){

// 2013.06.10 링크 오류
//		case "choickViewStatusUpdate":
		case "choiceViewStatusUpdate":

			if(in_array($strViewStatus, array("WY", "WN"))):
				$strViewStatus = ($strViewStatus == "WY") ? "Y" : "N";
				$productMgr->setP_WEB_VIEW($strViewStatus);
				if (is_array($aryChkNo)){
					for($i=0;$i<sizeof($aryChkNo);$i++){
						
						if ($aryChkNo[$i]){
							$productMgr->setP_LNG($strStLng);
							$productMgr->setP_CODE($aryChkNo[$i]);
							$productMgr->getProdViewStatusUpdate($db);
						}
					}
				};
			elseif(in_array($strViewStatus, array("MY", "MN"))):
				$strViewStatus = ($strViewStatus == "MY") ? "Y" : "N";
				$productMgr->setP_MOB_VIEW($strViewStatus);
				if (is_array($aryChkNo)){
					for($i=0;$i<sizeof($aryChkNo);$i++){
						
						if ($aryChkNo[$i]){
							$productMgr->setP_LNG($strStLng);
							$productMgr->setP_CODE($aryChkNo[$i]);
							$productMgr->getProdMobileViewStatusUpdate($db);
						}
					}
				};
			endif;

			$strUrl = "./?menuType=".$strMenuType."&mode=prodViewList&".$strLinkPage;
		break;

		case "allViewStatusUpdate":
			$productMgr->setP_WEB_VIEW($strViewStatus);

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

			/* 검색부분 */
			$intTotal	= $productMgr->getProdTotal($db);
			$productMgr->setPageLine($intTotal);
			$productMgr->setLimitFirst(0);
			$result = $productMgr->getProdList($db);

			while($row = mysql_fetch_array($result)){
				$productMgr->setP_CODE($row[P_CODE]);
				$productMgr->getProdViewStatusUpdate($db);
			}

			$strUrl = "./?menuType=".$strMenuType."&mode=prodViewList&".$strLinkPage;

		break;
	}

?>