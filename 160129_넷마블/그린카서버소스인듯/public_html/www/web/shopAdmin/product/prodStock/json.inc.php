<?
	require_once MALL_CONF_LIB."ProductAdmMgr.php";

	$productMgr = new ProductAdmMgr();		
	
	/*##################################### Parameter 셋팅 #####################################*/	
	$strP_CODE				= $_POST["prodCode"]		? $_POST["prodCode"]		: $_REQUEST["prodCode"];
	$aryChkNo				= $_POST["chkNo"]			? $_POST["chkNo"]			: $_REQUEST["chkNo"];
	$strStockStatus			= $_POST["stockStatus"]		? $_POST["stockStatus"]		: $_REQUEST["stockStatus"];
	$strViewStatus			= $_POST["viewStatus"]		? $_POST["viewStatus"]		: $_REQUEST["viewStatus"];
	
	switch ($strJsonMode){
		
		case "stockTotQty":
			
			$productMgr->setP_LNG($strStLng);
			$productMgr->setP_CODE($strP_CODE);
			$prodRow = $productMgr->getProdView($db);
			
			$intQty = 0;
			if ($prodRow){
					
				if ($prodRow[P_OPT] == "1"){
					$intQty = $prodRow[P_QTY];							
				} else {
					$intQty = $productMgr->getProdOptTotQty($db);
				}
			}
			
			$result[0][QTY] = $intQty;
			$result_array = json_encode($result);
			echo $result_array;			
		break;
		
		case "optStockUpdate":
			
			$productMgr->setP_LNG($strStLng);
			$productMgr->setP_CODE($strP_CODE);
			$prodRow = $productMgr->getProdView($db);

			$productMgr->setPO_TYPE("O");
			$aryProdOpt = $productMgr->getProdOpt($db);
			if (is_array($aryProdOpt)){
				for($i=0;$i<sizeof($aryProdOpt);$i++){
					if ($aryProdOpt[$i][PO_NO] > 0){
						$productMgr->setPO_NO($aryProdOpt[$i][PO_NO]);

						$intAttrNo = 1;
						$intProdOptAttrNo	= "prodOptAttrNo".$intAttrNo;
						$strProdOptAttrQty	= "prodOptAttrQty".$intAttrNo;
						$aryProdOptAttrNo	= $_POST[$intProdOptAttrNo]	 ? $_POST[$intProdOptAttrNo]  : $_REQUEST[$intProdOptAttrNo];
						$aryProdOptAttrQty	= $_POST[$strProdOptAttrQty] ? $_POST[$strProdOptAttrQty] : $_REQUEST[$strProdOptAttrQty];
				
						for($j=0;$j<sizeof($aryProdOptAttrNo);$j++){
							if (!$aryProdOptAttrQty[$j]) $aryProdOptAttrQty[$j] = 0;
							$productMgr->setPOA_STOCK_QTY($aryProdOptAttrQty[$j]);

							$intPOA_NO = $aryProdOptAttrNo[$j];
							$productMgr->setPOA_NO($intPOA_NO);
							$productMgr->getProdStockOptQtyUpdate($db);
						}
					}
				}
			}

			$intQty = $productMgr->getProdOptTotQty($db);
			$productMgr->setP_QTY($intQty);
			$productMgr->getProdQtyUpdate($db);
			
			$result[0][RET] = "Y";
			$result[0][QTY] = $intQty;
			$result_array = json_encode($result);
			echo $result_array;			

		break;

		case "choiceStockStatusUpdateVersion2.0":
			
			$arySiteUseLng = explode("/",$S_USE_LNG);

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
					
					## 재고상태변경
					if ($strStockStatus == "1" || $strStockStatus == "3") {
						$productMgr->setPOA_STOCK_QTY(0);
						$productMgr->getProdStockOptQtyUpdate($db);
					}
					$productMgr->getProdStockStatusOUpdate($db);

					## 출력상태변경
					$productMgr->setP_WEB_VIEW($strViewStatus);
					$productMgr->setP_MOB_VIEW($strViewStatus);
					$productMgr->getProdViewStatusUpdate($db);
					
					## 상품다국어출력여부사용
					if ($S_PROD_MANY_LANG_VIEW == "Y"){
						for($j=0;$j<sizeof($arySiteUseLng);$j++){
							if ($arySiteUseLng[$j]){
								$productMgr->setP_LNG($arySiteUseLng[$j]);
								$productMgr->getProdInfoViewUpdate($db);
							}
						}
					}
				}
			}
			
			$result[0][RET] = "Y";
			$result_array = json_encode($result);
			echo $result_array;
			
		break;

	}

?>