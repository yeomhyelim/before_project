<?
	require_once MALL_CONF_LIB."MemberAdmMgr.php";
	require_once MALL_CONF_LIB."CouponMgr.php";

	$memberMgr	= new MemberMgr();
	$couponMgr	= new CouponMgr();

	$intCU_NO	= $_POST["cuNo"]				? $_POST["cuNo"]				: $_REQUEST["cuNo"];
	
	switch($strAct){
		case "excelCouponIssueList":
			
			$couponMgr->setCU_NO($intCU_NO);

			/* 쿠폰 발급 목록 */
			$intTotal	= $couponMgr->getCouponIssueTotal($db);
			$couponMgr->setLimitFirst(0);
			$couponMgr->setPageLine($intTotal);

			$result = $couponMgr->getCouponIssueList($db);
			$strExcelFileName = iconv("utf-8","euc-kr",date("Ymd")."_쿠폰발급리스트");
			
		break;

	}
?>