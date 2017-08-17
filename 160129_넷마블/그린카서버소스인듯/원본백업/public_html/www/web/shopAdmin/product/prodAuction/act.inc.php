<?
	## 클래스 설정
	$objProductAuctionModule	= new ProductAuctionModule($db);
	

	/*##################################### Parameter 셋팅 #####################################*/
	$strSearchField = $_POST["searchField"]		? $_POST["searchField"]		: $_REQUEST["searchField"];
	$strSearchKey	= $_POST["searchKey"]		? $_POST["searchKey"]		: $_REQUEST["searchKey"];
	$intPage		= $_POST["page"]			? $_POST["page"]			: $_REQUEST["page"];
	$intPageLine	= $_POST["pageLine"]		? $_POST["pageLine"]		: $_REQUEST["pageLine"];

	$strProdCode	= $_POST["prodCode"]		? $_POST["prodCode"]		: $_REQUEST["prodCode"];	
	
	$aryChkNo		= $_POST["chkNo"]			? $_POST["chkNo"]			: $_REQUEST["chkNo"];
	/*##################################### Parameter 셋팅 #####################################*/

	$strLinkPage = "";
	switch ($strAct) {
		case "prodAuctionApplySucess":
			
			if (!is_array($aryChkNo)){
				goErrMsg($LNG_TRANS_CHAR['CS00017']);
				exit;
			}

			foreach($aryChkNo as $key => $val){
				$intProdAucApplyNo		= $val;
				
				if ($intProdAucApplyNo > 0){
					$param						= "";
					$param['PAA_NO']			= $intProdAucApplyNo;
					$prodAucApplyRow			= $objProductAuctionModule->getProductAuctionApplySelectEx("OP_SELECT",$param);
					
					if (!$prodAucApplyRow){
						goErrMsg($LNG_TRANS_CHAR['CS00017']);
						exit;
					}
					
					## 낙찰상태 UPDATE
					$param['PAA_STATUS']		= "2";
					$result						= $objProductAuctionModule->getProductAuctionApplyUpdateEx($param);
					if (!$result){
						goErrMsg($LNG_TRANS_CHAR['CS00011']);
						exit;
					}

					## 낙찰정보 및 최고가 UPDATE
					$param['P_CODE']			= $prodAucApplyRow['P_CODE'];
					$param['P_AUC_PRICE']		= $prodAucApplyRow['PAA_PRICE'];
					$param['M_NO']				= $prodAucApplyRow['M_NO'];
					$param['P_AUC_SUC_PRICE']	= $prodAucApplyRow['PAA_PRICE'];
					$param['P_AUC_SUC_M_NO']	= $prodAucApplyRow['M_NO']; 
					$result						= $objProductAuctionModule->getProductAuctionMaxPriceUpdateEx($param);
					if (!$result){
						goErrMsg($LNG_TRANS_CHAR['CS00011']);
						exit;
					}
				}
			}
			
			$strUrl = $_SERVER['HTTP_REFERER'];
		break;
	}	


?>