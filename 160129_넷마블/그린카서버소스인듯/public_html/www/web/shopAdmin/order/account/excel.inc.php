<?
	require_once MALL_CONF_LIB."AccountMgr.php";

	$accMgr = new AccountMgr();

	/*##################################### Parameter 셋팅 #####################################*/
	$strSearchField				= $_POST["searchField"]				? $_POST["searchField"]				: $_REQUEST["searchField"];
	$strSearchKey				= $_POST["searchKey"]				? $_POST["searchKey"]				: $_REQUEST["searchKey"];

	$strSearchCompany			= $_POST["searchCompany"]			? $_POST["searchCompany"]			: $_REQUEST["searchCompany"];

	$strSearchRegStartDt		= $_POST["searchRegStartDt"]		? $_POST["searchRegStartDt"]		: $_REQUEST["searchRegStartDt"];
	$strSearchRegEndDt			= $_POST["searchRegEndDt"]			? $_POST["searchRegEndDt"]			: $_REQUEST["searchRegEndDt"];
	
	$strSearchAccStatus			= $_POST["searchAccStatus"]			? $_POST["searchAccStatus"]			: $_REQUEST["searchAccStatus"];
	$arySearchSettleType		= $_POST["searchSettleType"]		? $_POST["searchSettleType"]		: $_REQUEST["searchSettleType"];
	
	$intPage					= $_POST["page"]					? $_POST["page"]					: $_REQUEST["page"];

	$strSearchOrderEndStartDt	= $_POST["searchOrderEndStartDt"]	? $_POST["searchOrderEndStartDt"]	: $_REQUEST["searchOrderEndStartDt"];
	$strSearchOrderEndEndDt		= $_POST["searchOrderEndEndDt"]		? $_POST["searchOrderEndEndDt"]		: $_REQUEST["searchOrderEndEndDt"];

	$strSearchOrderAccStartDt	= $_POST["searchOrderAccStartDt"]	? $_POST["searchOrderAccStartDt"]	: $_REQUEST["searchOrderAccStartDt"];
	$strSearchOrderAccEndDt		= $_POST["searchOrderAccEndDt"]		? $_POST["searchOrderAccEndDt"]		: $_REQUEST["searchOrderAccEndDt"];

	if ($a_admin_type == "S"){
		$strSearchCompany = $a_admin_shop_no;
	}
	/*##################################### Parameter 셋팅 #####################################*/

	
	switch($strAct){
		case "excelAccList":
		case "excelAccPeriodList":
		case "excelAccList2":
			/* 검색부분 */
			$accMgr->setSearchField($strSearchField);
			$accMgr->setSearchKey($strSearchKey);
			$accMgr->setSearchRegStartDt($strSearchRegStartDt);
			$accMgr->setSearchRegEndDt($strSearchRegEndDt);
			$accMgr->setSearchCompany($strSearchCompany);
			$accMgr->setSearchAccStatus($strSearchAccStatus);

			if (is_array($arySearchSettleType) || $arySearchSettleType){
				$strSearchSettleType = $arySearchSettleType;
				if (is_array($arySearchSettleType)){
					$strSearchSettleType = "";
					foreach($arySearchSettleType as $key => $val){
						if ($val){
							$strSearchSettleType .= "'".$val."',";
						}
					}
					
					if ($strSearchSettleType){
						$strSearchSettleType = substr($strSearchSettleType,0,strlen($strSearchSettleType)-1);
					}
				}
				$accMgr->setSearchSettleType($strSearchSettleType);
			}

			/* 구매확정일자 검색 추가 */
			$param							= "";
			$param['ORDER_END_START_DT']	= $strSearchOrderEndStartDt;
			$param['ORDER_END_END_DT']		= $strSearchOrderEndEndDt;

			$param['ORDER_ACC_START_DT']	= $strSearchOrderAccStartDt;
			$param['ORDER_ACC_END_DT']		= $strSearchOrderAccEndDt;

			/* 검색부분 */

			$accMgr->setP_LNG($strAdmSiteLng);
			
			if ($strAct == "excelAccList" || $strAct == "excelAccList2"){
				$intTotal	= $accMgr->getAccTotal($db,$param);
				$intPageBlock	= 10;
				$accMgr->setPageLine($intTotal);
				$accMgr->setLimitFirst(0);

				$result = $accMgr->getAccList($db,$param);
				//if ($S_REMOTE_ADDR == "106.245.166.61") {echo $db->query; exit;}

			} else {
				$intTotal	= $accMgr->getAccPeriodTotal($db,$param);
				$intPageBlock	= 10;
				$accMgr->setPageLine($intTotal);
				$accMgr->setLimitFirst(0);

				$result = $accMgr->getAccPeriodList($db,$param);
			}
			
			$intListNum = 1;
			$strExcelFileName = iconv("utf-8","euc-kr",date("Ymd")."_정산내역");

		break;

		case "excelAccDateList":
		
			/* 검색부분 */
			if (!$strSearchRegStartDt) $strSearchRegStartDt = date("Y-m-d",mktime(0,0,0,date("m"),1,date("Y")));
			if (!$strSearchRegEndDt) $strSearchRegEndDt = date("Y-m-d",mktime(0,0,0,date("m"),date("t",mktime(0, 0, 2, date("m"), 1,date("Y"))),date("Y")));

			if (is_array($arySearchSettleType) || $arySearchSettleType){
				$strSearchSettleType = $arySearchSettleType;
				if (is_array($arySearchSettleType)){
					$strSearchSettleType = "";
					foreach($arySearchSettleType as $key => $val){
						if ($val){
							$strSearchSettleType .= "'".$val."',";
						}
					}
					
					if ($strSearchSettleType){
						$strSearchSettleType = substr($strSearchSettleType,0,strlen($strSearchSettleType)-1);
					}
				} else {
					$arySearchSettleType = explode(",",str_replace("'","",$strSearchSettleType));
				}
				$accMgr->setSearchSettleType($strSearchSettleType);
			}

			/* 검색부분 */
			$param									= "";
			$param['O_USE_LNG']						= $S_SITE_LNG;
			$param['SEARCH_ACC_STATUS']				= $strSearchAccStatus;
			$param['SEARCH_ORDER_END_ST_DT']		= $strSearchRegStartDt;
			$param['SEARCH_ORDER_END_END_DT']		= $strSearchRegEndDt;
			$param['SEARCH_SHOP']					= $strSearchCompany;
			$param['SEARCH_FIELD']					= $strSearchField;
			$param['SEARCH_KEY']					= $strSearchKey;
				
			if (is_array($arySearchSettleType) || $arySearchSettleType){
				$strSearchSettleType = $arySearchSettleType;
				if (is_array($arySearchSettleType)){
					$strSearchSettleType = "";
					foreach($arySearchSettleType as $key => $val){
						if ($val){
							$strSearchSettleType .= "'".$val."',";
						}
					}
					
					if ($strSearchSettleType){
						$strSearchSettleType = substr($strSearchSettleType,0,strlen($strSearchSettleType)-1);
					}
				} else {
					$arySearchSettleType = explode(",",str_replace("'","",$strSearchSettleType));
				}
				$param['SEARCH_SETTLE']				= $strSearchSettleType;
			}

			$param['ORDER_BY']						= "Y";
			$result									= $accMgr->getAccDateList($db,"OP_LIST",$param);
			
			/* 입점몰 업체 */
			$aryShopList = $accMgr->getShopList($db);
			
			$strExcelFileName = iconv("utf-8","euc-kr",date("Ymd")."_구매일자별정산내역");

		break;
	}
?>