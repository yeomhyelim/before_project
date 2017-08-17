<?
	require_once MALL_CONF_LIB."EumMgr.php";

	$eumMgr = new EumMgr();


	/*##################################### Parameter 셋팅 #####################################*/
	$strSearchField				= $_POST["searchField"]				? $_POST["searchField"]				: $_REQUEST["searchField"];
	$strSearchKey				= $_POST["searchKey"]				? $_POST["searchKey"]				: $_REQUEST["searchKey"];
	$strSearchDeliveryMth		= $_POST["searchDeliveryMth"]		? $_POST["searchDeliveryMth"]		: $_REQUEST["searchDeliveryMth"];
	$strSearchCountryZone		= $_POST["searchCountryZone"]		? $_POST["searchCountryZone"]		: $_REQUEST["searchCountryZone"];

	
	$intPage					= $_POST["page"]					? $_POST["page"]					: $_REQUEST["page"];
	$intPageLine				= $_POST["pageLine"]				? $_POST["pageLine"]				: $_REQUEST["pageLine"];
	
	/*##################################### Parameter 셋팅 #####################################*/
	
	switch($strMode){
		case "deliveryList":
			
			/* 관리자 Sub Menu 권한 설정 */
			$strLeftMenuCode01 = "";
			$strLeftMenuCode02 = "";
			/* 관리자 Sub Menu 권한 설정 */

			//if (!$strSearchRegStartDt) $strSearchRegStartDt = date("Y-m-d",mktime(0,0,0,date("m"),date("d")-10,date("Y")));
			//if (!$strSearchRegEndDt) $strSearchRegEndDt = date("Y-m-d");
	
			/* 국외 배송회사 설정 */
			$arrForDeliveryMthList	= $S_ARY_DELIVERY_METHOD;
			$arrForDeliveryMth		= explode(",",$S_DELIVERY_FOR_COM);
			$strForDeliveryInList	= "";
			if (is_array($arrForDeliveryMth)){
				$arrForDeliveryMthList = "";
				foreach($arrForDeliveryMth as $key => $val){
					$arrForDeliveryMthList[$val] = $S_ARY_DELIVERY_METHOD[$val];
					
					$strForDeliveryInList		.= "'{$val}',";
				}
				
				if ($strForDeliveryInList) $strForDeliveryInList = substr($strForDeliveryInList,0,strlen($strForDeliveryInList)-1);
				
			}

			/* 검색부분 */
			$param = "";
			$eumMgr->setSearchField($strSearchField);
			$eumMgr->setSearchKey($strSearchKey);
			$eumMgr->setSearchDeliveryMth($strSearchDeliveryMth);
			$eumMgr->setSearchCountryZone($strSearchCountryZone);
			
			$param['DELIVERY_FOR_COM_IN'] = $strForDeliveryInList;
			

			$intPageBlock	= 10;
			if(!$intPageLine) $intPageLine = 10;	
			$eumMgr->setPageLine($intPageLine);
			
			$intTotal	= $eumMgr->getDeliveryList($db,"deliveryCount",$param);
			if(!$intPage)	$intPage =1;

			$intTotPage	= ceil($intTotal / $eumMgr->getPageLine());
			if ($intTotal==0) {
				$intFirst	= 1;
				$intLast	= 0;			
			} else {
				$intFirst	= $intPageLine *($intPage -1);
				$intLast	= $intPageLine * $intPage;
			}
			$eumMgr->setLimitFirst($intFirst);
				
			$result = $eumMgr->getDeliveryList($db,"deliveryList",$param);
//			echo $db->query;
			$intListNum = $intTotal - ($intPageLine *($intPage-1));	
			
			$linkPage  = "?menuType=$strMenuType&mode=$strMode";
			$linkPage .= "&searchField=$strSearchField&searchKey=$strSearchKey";
			$linkPage .= "&searchDeliveryMth=$strSearchDeliveryMth&searchCountryZone=$strSearchCountryZone";
			$linkPage .= "&page=";
			
			if ($strSearchDeliveryMth){
				$aryCountryZoneSelectList = $eumMgr->getDeliveryMthZoneSelectList($db);
			}
			

		break;

	}
?>