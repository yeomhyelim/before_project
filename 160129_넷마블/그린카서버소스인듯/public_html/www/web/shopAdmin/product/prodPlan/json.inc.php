<?
	require_once MALL_CONF_LIB."CateMgr.php";
	require_once MALL_CONF_LIB."ProductAdmMgr.php";
	require_once MALL_CONF_LIB."MemberMgr.php";
	
	$cateMgr = new CateMgr();		
	$productMgr = new ProductAdmMgr();		
	$memberMgr = new MemberMgr();
	
	/*##################################### Parameter 셋팅 #####################################*/	
	
	switch ($strJsonMode){
		
		case "popPlanProdList":

			$aryProdList = $_POST['chkNo'];
			if (is_array($aryProdList)){
				
				$productMgr->setP_LNG($strStLng);
				$data		= "";
				$intCnt		= 0;
				
				for($i=0;$i<sizeof($aryProdList);$i++){
					
					$productMgr->setP_CODE($aryProdList[$i]);
					$productRow = $productMgr->getProdView($db);

					$strProdQty = number_format($row[P_QTY]);
					if ($productRow['P_QTY'] == 0){
						if ($productRow['P_STOCK_OUT'] == "Y"){
							$strProdQty = $LNG_TRANS_CHAR["PW00041"];	
						}

						if ($productRow['P_STOCK_LIMIT'] == "Y"){
							$strProdQty = $LNG_TRANS_CHAR["PW00020"];	
						}
					} 
					
					if ($productRow['P_CODE']){
						$data[$intCnt]['P_CODE']			= $productRow['P_CODE'];
						$data[$intCnt]['P_NAME']			= $productRow['P_NAME'];
						$data[$intCnt]['P_NUM']			= $productRow['P_NUM'];
						$data[$intCnt]['P_SALE_PRICE']		= getCurToPrice($productRow['P_SALE_PRICE'],$strStLng);
						
						$data[$intCnt]['P_REG_DT']			= $productRow['P_REG_DT'];
						$data[$intCnt]['P_QTY']				= $strProdQty;
						$data[$intCnt]['PM_REAL_NAME']		= $productRow['PM_REAL_NAME'];
						$intCnt++;
					}
				}
			}

			$result		= $data;
			$result_array		= json_encode($result);
			echo $result_array;	

		break;
	
	}
	


?>