<?
	require_once MALL_CONF_LIB."ShopOrderNewMgr.php";

	require_once MALL_CONF_LIB."ProductAdmMgr.php";
	require_once MALL_CONF_LIB."MemberAdmMgr.php";
	require_once MALL_CONF_LIB."SiteMgr.php";

	$shopOrderMgr = new ShopOrderMgr();
	$productMgr = new ProductAdmMgr();
	$memberMgr = new MemberMgr();
	$siteMgr = new SiteMgr();
	
	/*##################################### Parameter 셋팅 #####################################*/
	$intPage	= $_POST["page"] ? $_POST["page"]	: $_REQUEST["page"];

	/*##################################### Parameter 셋팅 #####################################*/
	switch($strMode){
		case "deliveryList":
		case "deliveryFastInput":

			/* 리스트 페이지 라인 쿠키 설정 */
			if (!$_REQUEST['pageLine']){
				$_REQUEST['pageLine'] = $_COOKIE["COOKIE_ADM_ORDER_DELIVERY_LIST_LINE"] ? $_COOKIE["COOKIE_ADM_ORDER_DELIVERY_LIST_LINE"] : 50;
			} else {
				setCookie("COOKIE_ADM_ORDER_DELIVERY_LIST_LINE",$_REQUEST['pageLine'],time()+(86400 * 30),"/shopAdmin");
			}
			/* 리스트 페이지 라인 쿠키 설정 */
		
			/* 관리자 Sub Menu 권한 설정 */
			$strLeftMenuCode01 = "001";
			$strLeftMenuCode02 = "001";
			/* 관리자 Sub Menu 권한 설정 */

			switch($_REQUEST['searchOrderStatus']){
				case "I":
					$strLeftMenuCode02  = "";
					$strMenuTitle		= $LNG_TRANS_CHAR["OW00149"]; //배송중목록
				break;
				case "D":
					$strLeftMenuCode02  = "";
					$strMenuTitle		= $LNG_TRANS_CHAR["OW00150"]; //배송완료목록
				break;
				default:
					$strLeftMenuCode02 = "";
					$strMenuTitle	   = $LNG_TRANS_CHAR["OW00148"]; //송장입력목록
				break;
			}
			
			## STEP 1.
			## 선언

			## 소속 국가 설정
			$strSearchNation						= $_REQUEST['searchNation'];
			
			if (!$_REQUEST['searchOrderStatus']) $_REQUEST['searchOrderStatus'] = "B";
			## STEP 2.
			## 주문 리스트
			$param									= "";
			$param['shopMallType']					= $S_MALL_TYPE;
			$param['searchField']					= $_REQUEST['searchField'];
			$param['searchKey']						= $_REQUEST['searchKey'];
			$param['searchMemberType']				= $_REQUEST['searchMemberType'];
			$param['searchRegStartDt']				= $_REQUEST['searchRegStartDt'];
			$param['searchRegEndDt']				= $_REQUEST['searchRegEndDt'];
			$param['searchSettleType']				= $_REQUEST['searchSettleType'];
			$param['searchDeliveryCom']				= $_REQUEST['searchDeliveryCom'];
			$param['searchDeliveryStatus']			= $_REQUEST['searchDeliveryStatus'];

			$param['searchOrderStatus']				= $_REQUEST['searchOrderStatus'];
			if (!$param['searchOrderStatus'] && in_array($param['searchDeliveryStatus'],array('B','I','D'))){
				$param['searchOrderStatus']			= $param['searchDeliveryStatus'];
			}
			$param['searchOrderMemo']				= $_REQUEST['searchOrderMemo'];

			## 입점사 검색
			if ($a_admin_type == "S" && $a_admin_shop_no){
				$param['searchShopNo']		= $a_admin_shop_no;
			} else {
				if ($S_MALL_TYPE != "R")
				{
					if ($_REQUEST['searchShop'] && $_REQUEST['searchShop'] != "undefined"){
						$param['searchShopNo'] = $_REQUEST['searchShop'];
					}
					
					## 영업사용/관리 입점몰 사용여부
					if ($ADMIN_SHOP_SELECT_USE == "Y")
					{
						if ($a_admin_tm == "Y" && $a_admin_shop_list) {
							/* 영업사원이며 tm 입점사관리 기능이 있을 경우 */
							$param['searchShopList'] = $a_admin_shop_list;
						}

						if ($_REQUEST['searchShop']  && $_REQUEST['searchShop'] != "undefined"){
							$param['searchShopList'] = "";
						}
					}
				}
			}
			
			## 소속 검색
			if ($S_FIX_MEMBER_CATE_USE_YN  == "Y")
			{
				## 설정
				require_once MALL_CONF_LIB."memberCateMgr.php";
				$memberCateMgr			= new MemberCateMgr();
				
				$strSearchNation						= $_POST["searchNation"]		? $_POST["searchNation"]		: $_REQUEST["searchNation"];
				$strSearchCate1							= $_POST["searchCate1"]			? $_POST["searchCate1"]			: $_REQUEST["searchCate1"];
				$strSearchCate2							= $_POST["searchCate2"]			? $_POST["searchCate2"]			: $_REQUEST["searchCate2"];
				$strSearchCate3							= $_POST["searchCate3"]			? $_POST["searchCate3"]			: $_REQUEST["searchCate3"];
				$strSearchCate4							= $_POST["searchCate4"]			? $_POST["searchCate4"]			: $_REQUEST["searchCate4"];
				
				if($strSearchNation || $strSearchCate1 || $strSearchCate2 || $strSearchCate3 || $strSearchCate4):
					
					## 검색 카테고리 설정
					$strSearchCateCode	= "";
					if($strSearchCate1) { $strSearchCateCode = $strSearchCate1; }
					if($strSearchCate2) { $strSearchCateCode = $strSearchCate2; }
					if($strSearchCate3) { $strSearchCateCode = $strSearchCate3; }
					if($strSearchCate4) { $strSearchCateCode = $strSearchCate4; }
				endif;

				if ($a_admin_level > 0): 
				
					$param2								= "";
					$param2['C_CODE_COLUMN_ARYLIST']	= "Y";
					$param2['M_NO']						= $a_admin_no;
					$arrSearchMemberCate				= $memberCateMgr->getMemberCateJoinListEx($db, "OP_ARYLIST", $param2);
				
				endif;
			}
			
			$param['searchMemberCate']				= $strSearchCateCode;
			$param['searchMemberNation']			= $strSearchNation;
			$param['searchMemberCateList']			= $arrSearchMemberCate;
		
			$intTotal								= $shopOrderMgr->getOrderDeliveryListEx($db, "OP_COUNT", $param);			// 데이터 전체 개수 
//			echo $db->query;
			$intPageLine							= $_REQUEST['pageLine'] ? $_REQUEST['pageLine'] : 50;						// 리스트 개수 
			$intPage								= ( $intPage )				? $intPage		: 1;
			$intFirst								= ( $intTotal == 0 )		? 0				: $intPageLine * ( $intPage - 1 );

			$param['order_by']						= "O.O_NO DESC";
			$param['limit']							= "{$intFirst},{$intPageLine}";
			$orderDeliveryListResult				= $shopOrderMgr->getOrderDeliveryListEx($db, "OP_LIST", $param);
//echo $db->query;

			$intPageBlock							= 10;																		// 블럭 개수 
			$intListNum								= $intTotal - ( $intPageLine * ( $intPage - 1 ) );							// 번호
			$intTotPage								= ceil( $intTotal / $intPageLine );

			## STEP 3.
			## 페이징 링크 주소
			$queryString	= explode("&", $_SERVER['QUERY_STRING']);
						
			$linkPage		= "";
			foreach($queryString as $string):
				list($key,$val)		= explode("=", $string);
				if($key == "page")	{ continue; }
				if($linkPage)		{ $linkPage .= "&"; }
				$linkPage		   .= $string;
			endforeach;
			$linkPage		= "./?{$linkPage}&page=";
			
			$aryDeliveryCom = getCommCodeList("DELIVERY");
			$siteRow = $siteMgr->getSiteInfo($db);

			If ($siteRow[S_SETTLE]){
				$arySiteSettle = explode("/",$siteRow[S_SETTLE]);
				if (is_array($arySiteSettle)){
					$intSiteSettleB = $intSiteSettleA = $intSiteSettleC = $intSiteSettleT = "";
					for($z=0;$z<sizeof($arySiteSettle);$z++){
						if ($arySiteSettle[$z] == "B"){
							$intSiteSettleB = "Y";
						}

						if ($arySiteSettle[$z] == "C"){
							$intSiteSettleC = "Y";
						}

						if ($arySiteSettle[$z] == "A"){
							$intSiteSettleA = "Y";
						}

						if ($arySiteSettle[$z] == "T"){
							$intSiteSettleT = "Y";
						}
					}
				}
			}
			
			
			/*배송회사*/
			$aryDeliveryComAll  = getCommCodeList("DELIVERY","Y");
			$aryDeliveryUrl		= getDeliveryUrlList();
		
			$aryDeliveryCom		= "";
			$temp				= explode(",", $S_DELIVERY_COM);
			foreach($temp as $key):
				$aryDeliveryCom[$key] = $aryDeliveryComAll[$key];
			endforeach;
			
			/*국가/주*/
			$aryCountryList		= getCountryList();			
			$aryCountryState	= getCommCodeList("STATE","");
			
			
			$includeFile = $strIncludePath.$aryIncludeFolder[$strMode]."/deliveryList.php";
		break;	

	}
?>