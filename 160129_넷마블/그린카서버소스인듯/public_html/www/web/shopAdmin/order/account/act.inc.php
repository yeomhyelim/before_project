<?
	require_once MALL_CONF_LIB."AccountMgr.php";

	$accMgr = new AccountMgr();

	/*##################################### Parameter 셋팅 #####################################*/
	$strSearchField				= $_POST["searchField"]				? $_POST["searchField"]				: $_REQUEST["searchField"];
	$strSearchKey				= $_POST["searchKey"]				? $_POST["searchKey"]				: $_REQUEST["searchKey"];

	$strSearchCompnay			= $_POST["searchCompany"]			? $_POST["searchCompany"]			: $_REQUEST["searchCompany"];

	$strSearchRegStartDt		= $_POST["searchRegStartDt"]		? $_POST["searchRegStartDt"]		: $_REQUEST["searchRegStartDt"];
	$strSearchRegEndDt			= $_POST["searchRegEndDt"]			? $_POST["searchRegEndDt"]			: $_REQUEST["searchRegEndDt"];
	
	$strSearchAccStatus			= $_POST["searchAccStatus"]			? $_POST["searchAccStatus"]			: $_REQUEST["searchAccStatus"];
	$arySearchSettleType		= $_POST["searchSettleType"]		? $_POST["searchSettleType"]		: $_REQUEST["searchSettleType"];
	
	$intPage					= $_POST["page"]					? $_POST["page"]					: $_REQUEST["page"];
	$intSH_NO					= $_POST["shopNo"]					? $_POST["shopNo"]					: $_REQUEST["shopNo"];
		
	$aryChkNo					= $_POST["chkNo"]					? $_POST["chkNo"]					: $_REQUEST["chkNo"];
	$strAccStatus				= $_POST["accStatus"]				? $_POST["accStatus"]				: $_REQUEST["accStatus"];
	$strAccUpdateType			= $_POST["accStatusUpdateType"]		? $_POST["accStatusUpdateType"]		: $_REQUEST["accStatusUpdateType"];
		
	$strSearchOrderEndStartDt	= $_POST["searchOrderEndStartDt"]	? $_POST["searchOrderEndStartDt"]	: $_REQUEST["searchOrderEndStartDt"];
	$strSearchOrderEndEndDt		= $_POST["searchOrderEndEndDt"]		? $_POST["searchOrderEndEndDt"]		: $_REQUEST["searchOrderEndEndDt"];

	$strSearchOrderAccStartDt	= $_POST["searchOrderAccStartDt"]	? $_POST["searchOrderAccStartDt"]	: $_REQUEST["searchOrderAccStartDt"];
	$strSearchOrderAccEndDt		= $_POST["searchOrderAccEndDt"]		? $_POST["searchOrderAccEndDt"]		: $_REQUEST["searchOrderAccEndDt"];

	$strSearchYN				= $_POST["searchYN"]				? $_POST["searchYN"]				: $_REQUEST["searchYN"];

	/*##################################### Parameter 셋팅 #####################################*/

	$strLinkPage .= "&searchField=$strSearchField&searchKey=$strSearchKey";
	$strLinkPage .= "&searchRegStartDt=$strSearchRegStartDt&searchRegEndDt=$strSearchRegEndDt";
	$strLinkPage .= "&searchCompany=$strSearchCompnay&searchAccStatus=$strSearchAccStatus";
	$strLinkPage .= "&searchSettleType=$strSearchSettleType";
	$strLinkPage .= "&searchOrderEndStartDt=$strSearchOrderEndStartDt&searchOrderEndEndDt=$strSearchOrderEndEndDt";
	$strLinkPage .= "&searchOrderAccStartDt=$strSearchOrderAccStartDt&searchOrderAccEndDt=$strSearchOrderAccEndDt";
	$strLinkPage .= "&searchYN=$strSearchYN";
	$strLinkPage .= "&page=";

	switch ($strAct) {
		case "accStatusUpdate":
			$accMgr->setACC_STATUS($strAccStatus);
			if ($strAccUpdateType == "P"){
				if (is_array($aryChkNo)){
					for($i=0;$i<sizeof($aryChkNo);$i++){
					
						if ($aryChkNo[$i] > 0){
							$intSO_NO = $aryChkNo[$i];
							$accMgr->setSO_NO($intSO_NO);
							$accMgr->getAccStatusUpdate($db);

							/* 정산상태 history 담기 */
							$historyParam				= "";
							$historyParam['m_no']		= $a_admin_no;
							$historyParam['h_tab']		= "SHOP_ORDER";
							$historyParam['h_key']		= $intSO_NO;
							$historyParam['h_code']		= ""; //주문상태
							$historyParam['h_memo']		= "정산상태변경({$strAccStatus})";
							$historyParam['h_text']		= "";
							$historyParam['h_reg_no']	= $a_admin_no;
							$historyParam['h_adm_no']	= $a_admin_no;
							$accMgr->getOrderAccountHistoryUpdate($db,$historyParam);
						}
					}
				}
							
				$strUrl = "./?menuType=".$strMenuType."&mode=accList".$strLinkPage;
			
			} else if($strAccUpdateType == "D") {
				
				$accMgr->setSearchRegStartDt($strSearchRegStartDt);
				$accMgr->setSearchRegEndDt($strSearchRegEndDt);
				$accMgr->setSearchCompany($strSearchCompnay);
				$accMgr->setSearchAccStatus($strSearchAccStatus);
		
				if (is_array($aryChkNo)){
					for($i=0;$i<sizeof($aryChkNo);$i++){
					
						if ($aryChkNo[$i] > 0){
							$intSH_NO = $aryChkNo[$i];
							$accMgr->setSH_NO($intSH_NO);
							$accMgr->getAccStatusPeriodUpdate($db);

							/* 정산상태 history 담기 */
							$historyParam				= "";
							$historyParam['m_no']		= $a_admin_no;
							$historyParam['h_tab']		= "SHOP_ORDER_PERIOD";
							$historyParam['h_key']		= $intSH_NO;
							$historyParam['h_code']		= ""; //주문상태
							$historyParam['h_memo']		= "정산상태변경(accStatusUpdate)";
							$historyParam['h_text']		= $db->query;
							$historyParam['h_reg_no']	= $a_admin_no;
							$historyParam['h_adm_no']	= $a_admin_no;
							$accMgr->getOrderAccountHistoryUpdate($db,$historyParam);
						}
					}
				}

				$strUrl = "./?menuType=".$strMenuType."&mode=accPeriodList".$strLinkPage;
			}
			
		break;

		case "accPeriodStatusUpdate":

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

			$accMgr->setSearchRegStartDt($strSearchRegStartDt);
			$accMgr->setSearchRegEndDt($strSearchRegEndDt);
			$accMgr->setSearchCompany($strSearchCompnay);
			$accMgr->setSearchAccStatus("N");
			
			$accMgr->setACC_STATUS("Y");
			$accMgr->setSH_NO($intSH_NO);


			/* 구매확정일자 검색 추가 */
			$param							= "";
			$param['ORDER_END_START_DT']	= $strSearchOrderEndStartDt;
			$param['ORDER_END_END_DT']		= $strSearchOrderEndEndDt;

			$param['ORDER_ACC_START_DT']	= $strSearchOrderAccStartDt;
			$param['ORDER_ACC_END_DT']		= $strSearchOrderAccEndDt;

			$accMgr->getAccStatusPeriodUpdate($db,$param);
			
			/* 정산상태 history 담기 */
			$historyParam				= "";
			$historyParam['m_no']		= $a_admin_no;
			$historyParam['h_tab']		= "SHOP_ORDER_PERIOD";
			$historyParam['h_key']		= $intSH_NO;
			$historyParam['h_code']		= ""; //주문상태
			$historyParam['h_memo']		= "정산상태변경(accPeriodStatusUpdate)";
			$historyParam['h_text']		= $db->query;
			$historyParam['h_reg_no']	= $a_admin_no;
			$historyParam['h_adm_no']	= $a_admin_no;
			$accMgr->getOrderAccountHistoryUpdate($db,$historyParam);

			$strUrl = "./?menuType=".$strMenuType."&mode=accPeriodList".$strLinkPage;
		break;
	}
?>