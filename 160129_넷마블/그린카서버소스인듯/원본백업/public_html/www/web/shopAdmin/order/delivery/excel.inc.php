<?
	require_once MALL_CONF_LIB."OrderAdmMgr.php";
	require_once MALL_CONF_LIB."SiteMgr.php";

	$orderMgr = new OrderMgr();
	$siteMgr = new SiteMgr();

	/*##################################### Parameter 셋팅 #####################################*/
	$strSearchField				= $_POST["searchField"]				? $_POST["searchField"]				: $_REQUEST["searchField"];
	$strSearchKey				= $_POST["searchKey"]				? $_POST["searchKey"]				: $_REQUEST["searchKey"];
	$strSearchDay				= $_POST["searchDay"]				? $_POST["searchDay"]				: $_REQUEST["searchDay"];

	$strSearchOrderStatus		= $_POST["searchOrderStatus"]		? $_POST["searchOrderStatus"]		: $_REQUEST["searchOrderStatus"];
	$strSearchSettleType		= $_POST["searchSettleType"]		? $_POST["searchSettleType"]		: $_REQUEST["searchSettleType"];			// 결제방법
	$strSearchMemberType		= $_POST["searchMemberType"]		? $_POST["searchMemberType"]		: $_REQUEST["searchMemberType"];			// 회원구분(전체, 회원, 비회원)
	$arySearchDeliveryCom		= $_POST["searchDeliveryCom"]		? $_POST["searchDeliveryCom"]		: $_REQUEST["searchDeliveryCom"];			// 택배회사
	if($arySearchDeliveryCom):
		$strSearchDeliveryCom	= implode($arySearchDeliveryCom, "','");
		$strSearchDeliveryCom	= "'{$strSearchDeliveryCom}'";
	endif;
	
	$strSearchRegStartDt	= $_POST["searchRegStartDt"]	? $_POST["searchRegStartDt"]	: $_REQUEST["searchRegStartDt"];
	$strSearchRegEndDt		= $_POST["searchRegEndDt"]		? $_POST["searchRegEndDt"]		: $_REQUEST["searchRegEndDt"];

	$strSearchSettleC		= $_POST["searchSettleC"]	? $_POST["searchSettleC"]	: $_REQUEST["searchSettleC"];
	$strSearchSettleA		= $_POST["searchSettleA"]	? $_POST["searchSettleA"]	: $_REQUEST["searchSettleA"];
	$strSearchSettleT		= $_POST["searchSettleT"]	? $_POST["searchSettleT"]	: $_REQUEST["searchSettleT"];
	$strSearchSettleB		= $_POST["searchSettleB"]	? $_POST["searchSettleB"]	: $_REQUEST["searchSettleB"];
	/*##################################### Parameter 셋팅 #####################################*/
	
	switch($strAct){
		case "excelDeliveryFastList":
			//if (!$strSearchRegStartDt) $strSearchRegStartDt = date("Y-m-d",mktime(0,0,0,date("m"),date("d")-10,date("Y")));
			//if (!$strSearchRegEndDt) $strSearchRegEndDt = date("Y-m-d");
			
			if (!$strSearchOrderStatus) $strSearchOrderStatus = "UI";
			/* 검색부분 */

			$orderMgr->setSearchField($strSearchField);
			$orderMgr->setSearchKey($strSearchKey);
			$orderMgr->setSearchRegStartDt($strSearchRegStartDt);
			$orderMgr->setSearchRegEndDt($strSearchRegEndDt);

			$orderMgr->setSearchSettleC($strSearchSettleC);
			$orderMgr->setSearchSettleA($strSearchSettleA);
			$orderMgr->setSearchSettleT($strSearchSettleT);
			$orderMgr->setSearchSettleB($strSearchSettleB);

			$orderMgr->setSearchOrderStatus($strSearchOrderStatus);

//			$orderMgr->setSearchSettleType($strSearchSettleType);				// 결제방법
			$orderMgr->setSearchMemberType($strSearchMemberType);				// 회원구분
			$orderMgr->setSearchDeliveryCom($strSearchDeliveryCom);				// 택배회사
		
			/* 검색부분 */

			$intTotal	= $orderMgr->getOrderTotal($db);
			$orderMgr->setPageLine($intTotal);
			$orderMgr->setLimitFirst(0);
			$result = $orderMgr->getOrderList($db);
			
			$strExcelFileName = iconv("utf-8","euc-kr",date("Ymd")."_빠른송장관리");
		break;

	}

?>