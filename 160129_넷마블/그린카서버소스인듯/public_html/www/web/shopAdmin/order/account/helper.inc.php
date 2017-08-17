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
	$intSH_NO					= $_POST["shopNo"]					? $_POST["shopNo"]					: $_REQUEST["shopNo"];

	$strSearchOrderEndStartDt	= $_POST["searchOrderEndStartDt"]	? $_POST["searchOrderEndStartDt"]	: $_REQUEST["searchOrderEndStartDt"];
	$strSearchOrderEndEndDt		= $_POST["searchOrderEndEndDt"]		? $_POST["searchOrderEndEndDt"]		: $_REQUEST["searchOrderEndEndDt"];

	$strSearchOrderAccStartDt	= $_POST["searchOrderAccStartDt"]	? $_POST["searchOrderAccStartDt"]	: $_REQUEST["searchOrderAccStartDt"];
	$strSearchOrderAccEndDt		= $_POST["searchOrderAccEndDt"]		? $_POST["searchOrderAccEndDt"]		: $_REQUEST["searchOrderAccEndDt"];

	$strSearchYN				= $_POST["searchYN"]				? $_POST["searchYN"]				: $_REQUEST["searchYN"];

	if ($a_admin_type == "S"){
		$strSearchCompany = $a_admin_shop_no;
	}
	
	/*##################################### Parameter 셋팅 #####################################*/

	switch($strMode){
		case "accList":

			/* 리스트 페이지 라인 쿠키 설정 */
			if (!$_REQUEST['pageLine']){
				$_REQUEST['pageLine'] = $_COOKIE["COOKIE_ADM_ORDER_ACC_LIST_LINE"] ? $_COOKIE["COOKIE_ADM_ORDER_ACC_LIST_LINE"] : 50;
			} else {
				setCookie("COOKIE_ADM_ORDER_ACC_LIST_LINE",$_REQUEST['pageLine'],time()+(86400 * 30),"/shopAdmin");
			}
			/* 리스트 페이지 라인 쿠키 설정 */
			
			/* 관리자 Sub Menu 권한 설정 */
			$strLeftMenuCode01 = "003";
			$strLeftMenuCode02 = "008";
			/* 관리자 Sub Menu 권한 설정 */

			/* 검색부분 */
			if (!$strSearchRegStartDt && $strSearchYN != "Y") $strSearchRegStartDt = date("Y-m-d",mktime(0,0,0,date("m"),1,date("Y")));
			if (!$strSearchRegEndDt && $strSearchYN != "Y") $strSearchRegEndDt = date("Y-m-d",mktime(0,0,0,date("m"),date("t",mktime(0, 0, 2, date("m"), 1,date("Y"))),date("Y")));

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
				} else {
					$arySearchSettleType = explode(",",str_replace("'","",$strSearchSettleType));
				}
				$accMgr->setSearchSettleType($strSearchSettleType);
			}
			
			/* 구매확정일자 검색 추가 */
			if ((!$strSearchOrderEndStartDt || !$strSearchOrderEndEndDt)  && $strSearchYN != "Y"){
				$strSearchOrderEndStartDt	= date("Y-m-d",mktime(0,0,0,date("m"),1,date("Y")));
				$strSearchOrderEndEndDt		= date("Y-m-d",mktime(0,0,0,date("m"),date("t",mktime(0, 0, 2, date("m"), 1,date("Y"))),date("Y")));
			}

			$param							= "";
			$param['ORDER_END_START_DT']	= $strSearchOrderEndStartDt;
			$param['ORDER_END_END_DT']		= $strSearchOrderEndEndDt;

			$param['ORDER_ACC_START_DT']	= $strSearchOrderAccStartDt;
			$param['ORDER_ACC_END_DT']		= $strSearchOrderAccEndDt;

			/* 검색부분 */

			$accMgr->setP_LNG($strAdmSiteLng);
			$strTitle = ($strSearchAccStatus=="Y") ? $LNG_TRANS_CHAR["OW00095"] : $LNG_TRANS_CHAR["OW00094"];
			
			$intPageBlock	= 10;
			$intPageLine	= $_REQUEST['pageLine'] ? $_REQUEST['pageLine'] : 50;
			$accMgr->setPageLine($intPageLine);
	
			$intTotal	= $accMgr->getAccTotal($db,$param);
			$intTotPage	= ceil($intTotal / $accMgr->getPageLine());

			if(!$intPage)	$intPage =1;

			if ($intTotal==0) {
				$intFirst	= 1;
				$intLast	= 0;			
			} else {
				$intFirst	= $intPageLine *($intPage -1);
				$intLast	= $intPageLine * $intPage;
			}
			$accMgr->setLimitFirst($intFirst);

			$result = $accMgr->getAccList($db,$param);
//			echo $db->query;

			$intListNum = $intTotal - ($intPageLine *($intPage-1));	
			
			$linkPage  = "?menuType=$strMenuType&mode=$strMode";
			$linkPage .= "&searchField=$strSearchField&searchKey=$strSearchKey";
			$linkPage .= "&searchRegStartDt=$strSearchRegStartDt&searchRegEndDt=$strSearchRegEndDt";
			$linkPage .= "&searchCompany=$strSearchCompany&searchAccStatus=$strSearchAccStatus";
			$linkPage .= "&searchSettleType=$strSearchSettleType";
			$linkPage .= "&searchOrderEndStartDt=$strSearchOrderEndStartDt&searchOrderEndEndDt=$strSearchOrderEndEndDt";
			$linkPage .= "&searchOrderAccStartDt=$strSearchOrderAccStartDt&searchOrderAccEndDt=$strSearchOrderAccEndDt";
			$linkPage .= "&searchYN=$strSearchYN";
			$linkPage .= "&page=";

			/* 입점몰 업체 */
			$aryShopList = $accMgr->getShopList($db);

			/* 총 금액 */
			$accSumRow = $accMgr->getAccSum($db,$param);
//			if ($S_REMOTE_ADDR == "106.245.166.61") echo $db->query;
			
			/* 국내/해외 사용중인 결제방법 */
			$arySiteSettle		= explode("/",$S_SETTLE);
			$arySiteForSettle	= explode("/",$S_FOR_PG);
		break;

		case "accPeriodList":
			
			/* 리스트 페이지 라인 쿠키 설정 */
			if (!$_REQUEST['pageLine']){
				$_REQUEST['pageLine'] = $_COOKIE["COOKIE_ADM_ORDER_ACC_PERIOD_LIST_LINE"] ? $_COOKIE["COOKIE_ADM_ORDER_ACC_PERIOD_LIST_LINE"] : 50;
			} else {
				setCookie("COOKIE_ADM_ORDER_ACC_PERIOD_LIST_LINE",$_REQUEST['pageLine'],time()+(86400 * 30),"/shopAdmin");
			}
			/* 리스트 페이지 라인 쿠키 설정 */

			/* 관리자 Sub Menu 권한 설정 */
			$strLeftMenuCode01 = "003";
			$strLeftMenuCode02 = "008";
			/* 관리자 Sub Menu 권한 설정 */

			/* 검색부분 */
			if (!$strSearchRegStartDt && $strSearchYN != "Y") $strSearchRegStartDt = date("Y-m-d",mktime(0,0,0,date("m"),1,date("Y")));
			if (!$strSearchRegEndDt && $strSearchYN != "Y") $strSearchRegEndDt = date("Y-m-d",mktime(0,0,0,date("m"),date("t",mktime(0, 0, 2, date("m"), 1,date("Y"))),date("Y")));

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
				} else {
					$arySearchSettleType = explode(",",str_replace("'","",$strSearchSettleType));
				}
				$accMgr->setSearchSettleType($strSearchSettleType);
			}

			/* 구매확정일자 검색 추가 */
			if ((!$strSearchOrderEndStartDt || !$strSearchOrderEndEndDt) && $strSearchYN != "Y"){
				$strSearchOrderEndStartDt	= date("Y-m-d",mktime(0,0,0,date("m"),1,date("Y")));
				$strSearchOrderEndEndDt		= date("Y-m-d",mktime(0,0,0,date("m"),date("t",mktime(0, 0, 2, date("m"), 1,date("Y"))),date("Y")));
			}

			$param							= "";
			$param['ORDER_END_START_DT']	= $strSearchOrderEndStartDt;
			$param['ORDER_END_END_DT']		= $strSearchOrderEndEndDt;

			$param['ORDER_ACC_START_DT']	= $strSearchOrderAccStartDt;
			$param['ORDER_ACC_END_DT']		= $strSearchOrderAccEndDt;

			/* 검색부분 */

			$strTitle = ($strSearchAccStatus=="Y") ? $LNG_TRANS_CHAR["OW00095"] : $LNG_TRANS_CHAR["OW00094"];

			$intPageBlock	= 10;
			$intPageLine	= $_REQUEST['pageLine'] ? $_REQUEST['pageLine'] : 50;
			$accMgr->setPageLine($intPageLine);
	
			$intTotal	= $accMgr->getAccPeriodTotal($db,$param);
			$intTotPage	= ceil($intTotal / $accMgr->getPageLine());

			if(!$intPage)	$intPage =1;

			if ($intTotal==0) {
				$intFirst	= 1;
				$intLast	= 0;			
			} else {
				$intFirst	= $intPageLine *($intPage -1);
				$intLast	= $intPageLine * $intPage;
			}
			$accMgr->setLimitFirst($intFirst);

			$result = $accMgr->getAccPeriodList($db,$param);
			$intListNum = $intTotal - ($intPageLine *($intPage-1));	
			
			$linkPage  = "?menuType=$strMenuType&mode=$strMode";
			$linkPage .= "&searchField=$strSearchField&searchKey=$strSearchKey";
			$linkPage .= "&searchRegStartDt=$strSearchRegStartDt&searchRegEndDt=$strSearchRegEndDt";
			$linkPage .= "&searchCompany=$strSearchCompany&searchAccStatus=$strSearchAccStatus";
			$linkPage .= "&searchSettleType=$strSearchSettleType";
			$linkPage .= "&searchOrderEndStartDt=$strSearchOrderEndStartDt&searchOrderEndEndDt=$strSearchOrderEndEndDt";
			$linkPage .= "&searchOrderAccStartDt=$strSearchOrderAccStartDt&searchOrderAccEndDt=$strSearchOrderAccEndDt";
			$linkPage .= "&searchYN=$strSearchYN";
			$linkPage .= "&page=";

			/* 입점몰 업체 */
			$aryShopList = $accMgr->getShopList($db);

			/* 총 금액 */
			$accSumRow = $accMgr->getAccSum($db,$param);
		
			/* 국내/해외 사용중인 결제방법 */
			$arySiteSettle		= explode("/",$S_SETTLE);
			$arySiteForSettle	= explode("/",$S_FOR_PG);
			
		break;


		case "accPeriodDetailList":
			/* 관리자 Sub Menu 권한 설정 */
			$strLeftMenuCode01 = "003";
			$strLeftMenuCode02 = "008";
			/* 관리자 Sub Menu 권한 설정 */
			
			/* 입점몰 업체 */
			$accMgr->setSH_NO($intSH_NO);
			$shopRow = $accMgr->getShopView($db);

			/* 검색부분 */
			$accMgr->setSearchField($strSearchField);
			$accMgr->setSearchKey($strSearchKey);
			$accMgr->setSearchRegStartDt($strSearchRegStartDt);
			$accMgr->setSearchRegEndDt($strSearchRegEndDt);
			$accMgr->setSearchCompany($intSH_NO);
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
				} else {
					$arySearchSettleType = explode(",",str_replace("'","",$strSearchSettleType));
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
			$strTitle  = "[".$shopRow[SH_COM_NAME]."]";
			$strTitle .= ($strSearchAccStatus=="Y") ? $LNG_TRANS_CHAR["OW00095"] : $LNG_TRANS_CHAR["OW00094"];
			//$strTitle .= "(".$strSearchRegStartDt." ~ ".$strSearchRegEndDt.")";
			
			/* shop 전체 */
			$accMgr->setLimitFirst(0);
			$accMgr->setPageLine(1);
			$totRet = $accMgr->getAccPeriodList($db,$param);
			
			$intPageBlock	= 10;
			$intPageLine	= 10;
			$accMgr->setPageLine($intPageLine);
	
			$intTotal	= $accMgr->getAccTotal($db,$param);
			$intTotPage	= ceil($intTotal / $accMgr->getPageLine());

			if(!$intPage)	$intPage =1;

			if ($intTotal==0) {
				$intFirst	= 1;
				$intLast	= 0;			
			} else {
				$intFirst	= $intPageLine *($intPage -1);
				$intLast	= $intPageLine * $intPage;
			}
			$accMgr->setLimitFirst($intFirst);

			$result = $accMgr->getAccList($db,$param);
			$intListNum = $intTotal - ($intPageLine *($intPage-1));	
			
			$linkPage  = "?menuType=$strMenuType&mode=$strMode";
			$linkPage .= "&searchField=$strSearchField&searchKey=$strSearchKey";
			$linkPage .= "&searchRegStartDt=$strSearchRegStartDt&searchRegEndDt=$strSearchRegEndDt";
			$linkPage .= "&searchCompany=$intSH_NO&searchAccStatus=$strSearchAccStatus";
			$linkPage .= "&searchOrderEndStartDt=$strSearchOrderEndStartDt&searchOrderEndEndDt=$strSearchOrderEndEndDt";
			$linkPage .= "&searchOrderAccStartDt=$strSearchOrderAccStartDt&searchOrderAccEndDt=$strSearchOrderAccEndDt";
			$linkPage .= "&searchYN=$strSearchYN";
			$linkPage .= "&shopNo=$intSH_NO&page=";

		break;

		case "accDateList":
		
			/* 관리자 Sub Menu 권한 설정 */
			$strLeftMenuCode01 = "003";
			$strLeftMenuCode02 = "008";
			/* 관리자 Sub Menu 권한 설정 */

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
			$strTitle = ($strSearchAccStatus=="Y") ? $LNG_TRANS_CHAR["OW00095"] : $LNG_TRANS_CHAR["OW00094"];

			$intPageBlock							= 10;
			$intPageLine							= 10;
			
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

			$intTotal								= $accMgr->getAccDateList($db,"OP_COUNT",$param);
			$intTotPage								= ceil($intTotal / $intPageLine);

			if(!$intPage)	$intPage =1;

			if ($intTotal==0) {
				$intFirst	= 1;
				$intLast	= 0;			
			} else {
				$intFirst	= $intPageLine *($intPage -1);
				$intLast	= $intPageLine * $intPage;
			}
			
			$param['ORDER_BY']						= "Y";
			$param['LIMIT']							= "{$intFirst},{$intPageLine}	";

			$result									= $accMgr->getAccDateList($db,"OP_LIST",$param);
//			echo $db->query;
			$intListNum								= $intTotal - ($intPageLine *($intPage-1));	
			
			$linkPage  = "?menuType=$strMenuType&mode=$strMode";
			$linkPage .= "&searchField=$strSearchField&searchKey=$strSearchKey";
			$linkPage .= "&searchRegStartDt=$strSearchRegStartDt&searchRegEndDt=$strSearchRegEndDt";
			$linkPage .= "&searchCompany=$strSearchCompany&searchAccStatus=$strSearchAccStatus";
			$linkPage .= "&searchSettleType=$strSearchSettleType&page=";

			/* 입점몰 업체 */
			$aryShopList = $accMgr->getShopList($db);

			/* 총 금액 */
			$param['ORDER_BY']	= "";
			$param['LIMIT']		= "";
			$accSumRow = $accMgr->getAccDateList($db,"OP_SELECT",$param);
		
			/* 국내/해외 사용중인 결제방법 */
			$arySiteSettle		= explode("/",$S_SETTLE);
			$arySiteForSettle	= explode("/",$S_FOR_PG);			
		
		break;
	}
?>