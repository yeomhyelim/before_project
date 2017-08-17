<?
	require_once MALL_CONF_LIB."CateMgr.php";
	require_once MALL_CONF_LIB."ProductAdmMgr.php";
	
	$cateMgr = new CateMgr();		
	$productMgr = new ProductAdmMgr();		

	/*##################################### Parameter 셋팅 #####################################*/
	$strSearchField			= $_POST["searchField"]				? $_POST["searchField"]				: $_REQUEST["searchField"];
	$strSearchKey			= $_POST["searchKey"]				? $_POST["searchKey"]				: $_REQUEST["searchKey"];
	$intPage				= $_POST["page"]					? $_POST["page"]					: $_REQUEST["page"];
	$intPageLine			= $_POST["pageLine"]				? $_POST["pageLine"]				: $_REQUEST["pageLine"];

	$strP_CODE				= $_POST["prodCode"]				? $_POST["prodCode"]				: $_REQUEST["prodCode"];
	
	$strSearchHCode1		= $_POST["searchCateHCode1"]		? $_POST["searchCateHCode1"]		: $_REQUEST["searchCateHCode1"];
	$strSearchHCode2		= $_POST["searchCateHCode2"]		? $_POST["searchCateHCode2"]		: $_REQUEST["searchCateHCode2"];
	$strSearchHCode3		= $_POST["searchCateHCode3"]		? $_POST["searchCateHCode3"]		: $_REQUEST["searchCateHCode3"];
	$strSearchHCode4		= $_POST["searchCateHCode4"]		? $_POST["searchCateHCode4"]		: $_REQUEST["searchCateHCode4"];

	$strSearchStock1		= $_POST["searchStock1"]			? $_POST["searchStock1"]			: $_REQUEST["searchStock1"];
	$strSearchStock2		= $_POST["searchStock2"]			? $_POST["searchStock2"]			: $_REQUEST["searchStock2"];
	$strSearchStock3		= $_POST["searchStock3"]			? $_POST["searchStock3"]			: $_REQUEST["searchStock3"];
	
	$aryChkNo				= $_POST["chkNo"]					? $_POST["chkNo"]					: $_REQUEST["chkNo"];
	$strStockStatus			= $_POST["stockStatus"]				? $_POST["stockStatus"]				: $_REQUEST["stockStatus"];
	
	/*##################################### Parameter 셋팅 #####################################*/

	$strLinkPage  = "searchCateHCode1=$strSearchHCode1&searchCateHCode2=$strSearchHCode2";
	$strLinkPage .= "&searchCateHCode3=$strSearchHCode3&searchCateHCode4=$strSearchHCode4";
	$strLinkPage .= "&searchField=$strSearchField&searchKey=$strSearchKey";
	$strLinkPage .= "&searchStock1=$strSearchStock1";
	$strLinkPage .= "&searchStock2=$strSearchStock2";
	$strLinkPage .= "&searchStock3=$strSearchStock3&page=$intPage&pageLine=$intPageLine";
		
//	echo $strAct;

	switch ($strAct){

		case "autoStockUpdate":

			if (is_array($aryChkNo)){
				for($i=0;$i<sizeof($aryChkNo);$i++){
					
					$productMgr->setP_LNG($strStLng);
					$productMgr->setP_CODE($aryChkNo[$i]);
					$prodRow = $productMgr->getProdView($db);

					$strStock1 = $_POST["prodStock1_".$aryChkNo[$i]]	? $_POST["prodStock1_".$aryChkNo[$i]]	: $_REQUEST["prodStock1_".$aryChkNo[$i]];
					$strStock2 = $_POST["prodStock2_".$aryChkNo[$i]]	? $_POST["prodStock2_".$aryChkNo[$i]]	: $_REQUEST["prodStock2_".$aryChkNo[$i]];
					$strStock3 = $_POST["prodStock3_".$aryChkNo[$i]]	? $_POST["prodStock3_".$aryChkNo[$i]]	: $_REQUEST["prodStock3_".$aryChkNo[$i]];
					
					if (!$strStock1) $strStock1 = "N";
					if (!$strStock2) $strStock2 = "N";
					if (!$strStock3) $strStock3 = "N";
					
					if ($prodRow){
					
						if ($prodRow[P_OPT] == "1"){
							$intQty = $_POST["prodQty_".$aryChkNo[$i]]	? $_POST["prodQty_".$aryChkNo[$i]]	: $_REQUEST["prodQty_".$aryChkNo[$i]];							
						} else {
							$intQty = $productMgr->getProdOptTotQty($db); //->상품옵션총재고수
						}

						if ($strStock3 == "Y") {
							$intQty = 0; //무제한 상품이면 수량 0
							$strStock1 = "N";
						}

						$productMgr->setP_STOCK_OUT($strStock1);
						$productMgr->setP_RESTOCK($strStock2);
						$productMgr->setP_STOCK_LIMIT($strStock3);
						$productMgr->setP_QTY($intQty);
						$productMgr->getProdStockQtyUpdate($db);

						if ($prodRow[P_OPT] != "1" && $intQty == 0 && $strStock3 == "Y"){
							$productMgr->setPOA_STOCK_QTY(0);
							$productMgr->getProdStockOptQtyUpdate($db);
						}
					}
				}
			}

			//$strUrl = "./?menuType=".$strMenuType."&mode=prodStockList&".$strLinkPage;

			$strUrl = $_SERVER['HTTP_REFERER'];
		break;

// 2013.06.10 텍스트 오류인듯...
//		case "choickStockStatusUpdate":
		case "choiceStockStatusUpdate":
			
			if ($strStockStatus == "1") {
				$productMgr->setP_STOCK_OUT("Y");
			} else if ($strStockStatus == "2"){
				$productMgr->setP_RESTOCK("Y");
			} else if ($strStockStatus == "3"){
				$productMgr->setP_STOCK_LIMIT("Y");
			}

			if (is_array($aryChkNo)){
				for($i=0;$i<sizeof($aryChkNo);$i++){
					
					$productMgr->setP_LNG($strStLng);
					$productMgr->setP_CODE($aryChkNo[$i]);
					$prodRow = $productMgr->getProdView($db);
					
					if ($strStockStatus == "1" || $strStockStatus == "3") {
						$productMgr->setPOA_STOCK_QTY(0);
						$productMgr->getProdStockOptQtyUpdate($db);
					}

					$productMgr->getProdStockStatusOUpdate($db);
				}
			}
			
			//$strUrl = "./?menuType=".$strMenuType."&mode=prodStockList&".$strLinkPage;
			$strUrl = $_SERVER['HTTP_REFERER'];
		break;

		case "allStockStatusUpdate":

			if ($strStockStatus == "1") {
				$productMgr->setP_STOCK_OUT("Y");
			} else if ($strStockStatus == "2"){
				$productMgr->setP_RESTOCK("Y");
			} else if ($strStockStatus == "3"){
				$productMgr->setP_STOCK_LIMIT("Y");
			}

			/* 언어 선택 */
			$productMgr->setP_LNG($strStLng);

			/* 검색부분 */
			$productMgr->setSearchHCode1($strSearchHCode1);
			$productMgr->setSearchHCode2($strSearchHCode2);
			$productMgr->setSearchHCode3($strSearchHCode3);
			$productMgr->setSearchHCode4($strSearchHCode4);

			$productMgr->setSearchField($strSearchField);
			$productMgr->setSearchKey($strSearchKey);
			$productMgr->setSearchStock1($strSearchStock1);
			$productMgr->setSearchStock2($strSearchStock2);
			$productMgr->setSearchStock3($strSearchStock3);
			/* 검색부분 */

			$intTotal	= $productMgr->getProdTotal($db);
			$productMgr->setPageLine($intTotal);
			$productMgr->setLimitFirst(0);
			$result = $productMgr->getProdList($db);

			while($row = mysql_fetch_array($result)){
				$productMgr->setP_CODE($row[P_CODE]);
				$prodRow = $productMgr->getProdView($db);

				//$productMgr->getProdStockStatusOUpdate($db);
				
				if ($prodRow[P_OPT] != "1"){
					if ($strStockStatus == "1" || $strStockStatus == "3") {
						$productMgr->setPOA_STOCK_QTY(0);
						//$productMgr->getProdStockOptQtyUpdate($db);
					}
				}
			}

			//$strUrl = "./?menuType=".$strMenuType."&mode=prodStockList&".$strLinkPage;
			$strUrl = $_SERVER['HTTP_REFERER'];
		break;

		case "choiceStockViewStatusUpdate":
			
			$strViewStatus	= $_POST["viewStatus"]	? $_POST["viewStatus"]	: $_REQUEST["viewStatus"];
			
			$productMgr->setP_WEB_VIEW($strViewStatus);
			if (is_array($aryChkNo)){
				for($i=0;$i<sizeof($aryChkNo);$i++){
					
					if ($aryChkNo[$i]){
						$productMgr->setP_LNG($strStLng);
						$productMgr->setP_CODE($aryChkNo[$i]);
						$productMgr->getProdViewStatusUpdate($db);

					}
				}
			}
			
			$strUrl = $_SERVER['HTTP_REFERER'];

			//$strUrl = "./?menuType=".$strMenuType."&mode=prodStockList&".$strLinkPage;
		break;

		case "autoViewUpdate":

			$arySiteUseLng = explode("/",$S_USE_LNG);

			if (is_array($aryChkNo)){
				for($i=0;$i<sizeof($aryChkNo);$i++){
					
					$productMgr->setP_CODE($aryChkNo[$i]);
															
					## 상품다국어출력여부사용
					if ($S_PROD_MANY_LANG_VIEW == "Y"){
						for($j=0;$j<sizeof($arySiteUseLng);$j++){
							if ($arySiteUseLng[$j]){
								
								$strWebVeiwStatus	= $_POST["prodWebView".$arySiteUseLng[$j]."_".$aryChkNo[$i]];
								//$strMobViewStatus	= $_POST["prodMobView".$arySiteUseLng[$j]."_".$aryChkNo[$i]];
								if (!$strWebVeiwStatus) $strWebVeiwStatus = "N";
								//if (!$strMobViewStatus) $strMobViewStatus = "N";

								$productMgr->setP_WEB_VIEW($strWebVeiwStatus);
								$productMgr->setP_MOB_VIEW($strWebVeiwStatus);
								$productMgr->setP_LNG($arySiteUseLng[$j]);
								$productMgr->getProdInfoViewUpdate($db);
							}
						}
					}
				}
			}

			//$strUrl = "./?menuType=".$strMenuType."&mode=prodStockList&".$strLinkPage;
			
			$strUrl = $_SERVER['HTTP_REFERER'];
		break;

	}

?>