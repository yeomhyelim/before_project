<?
	require_once MALL_CONF_LIB."ShopMgr.php";
	
	$shopMgr = new ShopMgr();
		
	/*##################################### Parameter 셋팅 #####################################*/
	$strSearchField = $_POST["searchField"]		? $_POST["searchField"]		: $_REQUEST["searchField"];
	$strSearchKey	= $_POST["searchKey"]		? $_POST["searchKey"]		: $_REQUEST["searchKey"];
	$intPage		= $_POST["page"]			? $_POST["page"]			: $_REQUEST["page"];
	$intPageLine	= $_POST["pageLine"]		? $_POST["pageLine"]		: $_REQUEST["pageLine"];

	$strSearchMemberType	= $_POST["searchMemberType"]	? $_POST["searchMemberType"]	: $_REQUEST["searchMemberType"];			// 회원구분(전체, 회원, 비회원)	
	$strSearchRegStartDt	= $_POST["searchRegStartDt"]	? $_POST["searchRegStartDt"]	: $_REQUEST["searchRegStartDt"];
	$strSearchRegEndDt		= $_POST["searchRegEndDt"]		? $_POST["searchRegEndDt"]		: $_REQUEST["searchRegEndDt"];

	$strSearchSettleStatus		= $_POST["searchSettleStatus"]		? $_POST["searchSettleStatus"]		: $_REQUEST["searchSettleStatus"];
	$strSearchDeliveryStatus1	= $_POST["searchDeliveryStatus1"]	? $_POST["searchDeliveryStatus1"]	: $_REQUEST["searchDeliveryStatus1"];
	$strSearchDeliveryStatus2	= $_POST["searchDeliveryStatus2"]	? $_POST["searchDeliveryStatus2"]	: $_REQUEST["searchDeliveryStatus2"];
	$strSearchDeliveryStatus3	= $_POST["searchDeliveryStatus3"]	? $_POST["searchDeliveryStatus3"]	: $_REQUEST["searchDeliveryStatus3"];
	$strSearchOrderStatus1		= $_POST["searchOrderStatus1"]		? $_POST["searchOrderStatus1"]		: $_REQUEST["searchOrderStatus1"];
	$strSearchOrderStatus2		= $_POST["searchOrderStatus2"]		? $_POST["searchOrderStatus2"]		: $_REQUEST["searchOrderStatus2"];
	$strSearchOrderStatus3		= $_POST["searchOrderStatus3"]		? $_POST["searchOrderStatus3"]		: $_REQUEST["searchOrderStatus3"];
	$strSearchOrderStatus4		= $_POST["searchOrderStatus4"]		? $_POST["searchOrderStatus4"]		: $_REQUEST["searchOrderStatus4"];

	$intSH_NO				= $_POST["shopNo"]				? $_POST["shopNo"]				: $_REQUEST["shopNo"];	

	/*##################################### Parameter 셋팅 #####################################*/
	$shopMgr->setP_LNG($S_SITE_LNG);
	/* 샵관리자로 로그인한 경우 */
	if ($a_admin_type == "S" && $a_admin_shop_no > 0){
		$intSH_NO = $a_admin_shop_no;
		$shopMgr->setSH_NO($a_admin_shop_no);
	}
	/* 데이터 리스트 */
	
	switch($strAct){
		case "excelOrderList":
			
			$strSearchDeliveryStatus = "";
			if ($strSearchDeliveryStatus1) $strSearchDeliveryStatus .= "'".$strSearchDeliveryStatus1."',";
			if ($strSearchDeliveryStatus2) $strSearchDeliveryStatus .= "'".$strSearchDeliveryStatus2."',";
			if ($strSearchDeliveryStatus3) $strSearchDeliveryStatus .= "'".$strSearchDeliveryStatus3."',";
			if ($strSearchDeliveryStatus) $strSearchDeliveryStatus = SUBSTR($strSearchDeliveryStatus,0,STRLEN($strSearchDeliveryStatus)-1);

			$strSearchOrderStatus = "";
			if ($strSearchOrderStatus1) $strSearchOrderStatus .= "'".$strSearchOrderStatus1."',";
			if ($strSearchOrderStatus2) $strSearchOrderStatus .= "'".$strSearchOrderStatus2."',";
			if ($strSearchOrderStatus3) $strSearchOrderStatus .= "'".$strSearchOrderStatus3."',";
			if ($strSearchOrderStatus4) $strSearchOrderStatus .= "'".$strSearchOrderStatus4."',";
			if ($strSearchOrderStatus) $strSearchOrderStatus = SUBSTR($strSearchOrderStatus,0,STRLEN($strSearchOrderStatus)-1);

			$shopMgr->setSearchField($strSearchField);
			$shopMgr->setSearchKey($strSearchKey);
			$shopMgr->setSearchRegStartDt($strSearchRegStartDt);
			$shopMgr->setSearchRegEndDt($strSearchRegEndDt);
			$shopMgr->setSearchMemberType($strSearchMemberType);				// 회원구분
			$shopMgr->setSearchSettleStatus($strSearchSettleStatus);
			$shopMgr->setSearchDeliveryStatus($strSearchDeliveryStatus);
			$shopMgr->setSearchOrderStatus($strSearchOrderStatus);

			$intTotal								= $shopMgr->getShopOrderTotal( $db );
			$shopMgr->setLimitFirst(0);
			$shopMgr->setPageLine($intTotal);

			$result									= $shopMgr->getShopOrderList( $db );		
			/* 배송업체 */
			$aryDeliveryCom = getCommCodeList("DELIVERY_All","Y");
			
			$strExcelFileName = iconv("utf-8","euc-kr",date("Ymd")."_입점주문관리");
		break;

	}

?>