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

	$aryChkNo				= $_POST["chkNo"]					? $_POST["chkNo"]					: $_REQUEST["chkNo"];
	
	$strIconUseYN1			= $_POST["chkIcon1"]				? $_POST["chkIcon1"]				: $_REQUEST["chkIcon1"];
	$strIconUseYN2			= $_POST["chkIcon2"]				? $_POST["chkIcon2"]				: $_REQUEST["chkIcon2"];
	$strIconUseYN3			= $_POST["chkIcon3"]				? $_POST["chkIcon3"]				: $_REQUEST["chkIcon3"];
	$strIconUseYN4			= $_POST["chkIcon4"]				? $_POST["chkIcon4"]				: $_REQUEST["chkIcon4"];
	$strIconUseYN5			= $_POST["chkIcon5"]				? $_POST["chkIcon5"]				: $_REQUEST["chkIcon5"];
	$strIconUseYN6			= $_POST["chkIcon6"]				? $_POST["chkIcon6"]				: $_REQUEST["chkIcon6"];
	$strIconUseYN7			= $_POST["chkIcon7"]				? $_POST["chkIcon7"]				: $_REQUEST["chkIcon7"];
	$strIconUseYN8			= $_POST["chkIcon8"]				? $_POST["chkIcon8"]				: $_REQUEST["chkIcon8"];
	$strIconUseYN9			= $_POST["chkIcon9"]				? $_POST["chkIcon9"]				: $_REQUEST["chkIcon9"];
	$strIconUseYN10			= $_POST["chkIcon10"]				? $_POST["chkIcon10"]				: $_REQUEST["chkIcon10"];

	$strProdOrder			= $_POST["order"]					? $_POST["order"]					: $_REQUEST["order"];
	if (!$strProdOrder) $strProdOrder = "default";

	/*##################################### Parameter 셋팅 #####################################*/

	$strLinkPage  = "searchCateHCode1=$strSearchHCode1&searchCateHCode2=$strSearchHCode2";
	$strLinkPage .= "&searchCateHCode3=$strSearchHCode3&searchCateHCode4=$strSearchHCode4";
	$strLinkPage .= "&searchField=$strSearchField&searchKey=$strSearchKey";
	$strLinkPage .= "&searchIcon1=$strSearchIcon1";
	$strLinkPage .= "&searchIcon2=$strSearchIcon2";
	$strLinkPage .= "&searchIcon3=$strSearchIcon3";
	$strLinkPage .= "&searchIcon4=$strSearchIcon4";
	$strLinkPage .= "&searchIcon5=$strSearchIcon5";
	$strLinkPage .= "&searchIcon6=$strSearchIcon6";
	$strLinkPage .= "&searchIcon7=$strSearchIcon7";
	$strLinkPage .= "&searchIcon8=$strSearchIcon8";
	$strLinkPage .= "&searchIcon9=$strSearchIcon9";
	$strLinkPage .= "&order=$strProdOrder&pageLine=$intPageLine";
	$strLinkPage .= "&searchWebView=$strSearchWebView&searchMobileView=$strSearchMobileView&page=$intPage";
	
	switch ($strAct){

		case "autoRecUpdate":
			if (is_array($aryChkNo)){
				for($i=0;$i<sizeof($aryChkNo);$i++){
					$strP_CODE = $aryChkNo[$i];
					$productMgr->setP_LNG($strStLng);
					$productMgr->setP_CODE($strP_CODE);

					$strProdIcon = "";
					for($j=1;$j<=10;$j++){
						$strIconName = "prodIcon".$j."_".$strP_CODE;
						$strIconUseYN = $_POST[$strIconName] ? $_POST[$strIconName]	: $_REQUEST[$strIconName];
						$strIconUseYN = IM_IsBlank($strIconUseYN,"N");
						$strProdIcon .= $strIconUseYN."|";
					}

					if ($strProdIcon){
						$productMgr->setP_ICON($strProdIcon);
						$productMgr->getProdDisplayIconUpdate($db);
					}
				}
			}

			$strUrl = "./?menuType=".$strMenuType."&mode=prodRecList&".$strLinkPage;
		break;

		case "choiceRecUpdate":
			if (is_array($aryChkNo)){
				for($i=0;$i<sizeof($aryChkNo);$i++){
					
					$productMgr->setP_LNG($strStLng);
					$productMgr->setP_CODE($aryChkNo[$i]);

					$strProdIcon = "";
					for($j=1;$j<=10;$j++){
						$strIconUseYN	  = ${"strIconUseYN".$j};
						$strIconUseYN = IM_IsBlank($strIconUseYN,"N");
						$strProdIcon .= $strIconUseYN."|";
					}

					if ($strProdIcon){
						$productMgr->setP_ICON($strProdIcon);
						$productMgr->getProdDisplayIconUpdate($db);
					}
				}
			}
			$strUrl = "./?menuType=".$strMenuType."&mode=prodRecList&".$strLinkPage;
		break;

		case "allRecUpdate":

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
			/* 검색부분 */

			$intTotal	= $productMgr->getProdTotal($db);
			$productMgr->setPageLine($intTotal);
			$productMgr->setLimitFirst(0);
			$result = $productMgr->getProdList($db);

			while($row = mysql_fetch_array($result)){
				$productMgr->setP_CODE($row[P_CODE]);
				
				$strProdIcon = "";
				for($j=1;$j<=10;$j++){
					$strIconUseYN = ${"strIconUseYN".$j};
					$strIconUseYN = IM_IsBlank($strIconUseYN,"N");

					if ($strIconUseYN == "N" && $row["ICON".$j] == "Y") $strIconUseYN = "Y";
					$strProdIcon .= $strIconUseYN."|";
				}

				if ($strProdIcon){
					$productMgr->setP_ICON($strProdIcon);
					$productMgr->getProdDisplayIconUpdate($db);
				}
			}

			$strUrl = "./?menuType=".$strMenuType."&mode=prodRecList&".$strLinkPage;

		break;

		case "choiceRecUpdate2":
			
			$strProdRecItemList = $_POST['recItemList'];
			$aryProdRecItemList = explode(",",$strProdRecItemList);

			$strProdRecStatus	= $_POST['recStatus'];
			if (is_array($aryChkNo)){
				for($i=0;$i<sizeof($aryChkNo);$i++){
					
					$productMgr->setP_LNG($strStLng);
					$productMgr->setP_CODE($aryChkNo[$i]);
					$row = $productMgr->getProdView($db);
					
					$strProdIcon = "";
					for($j=1;$j<=10;$j++){
						if (in_array($j,$aryProdRecItemList)) $strIconUseYN = $strProdRecStatus;
						else $strIconUseYN = $row['ICON'.$j];

						$strProdIcon .= $strIconUseYN."|";
					}

					if ($strProdIcon){
						$productMgr->setP_ICON($strProdIcon);
						$productMgr->getProdDisplayIconUpdate($db);
					}
				}
			}

			$strUrl = $_SERVER['HTTP_REFERER'];
		break;
	}

?>