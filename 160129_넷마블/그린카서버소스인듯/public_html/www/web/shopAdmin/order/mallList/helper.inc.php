<?
	require_once MALL_CONF_LIB."ShopOrderMgr.php";
	require_once MALL_CONF_LIB."ProductAdmMgr.php";
	require_once MALL_CONF_LIB."MemberAdmMgr.php";
	require_once MALL_CONF_LIB."SiteMgr.php";

	$orderMgr = new ShopOrderMgr();
	$productMgr = new ProductAdmMgr();
	$memberMgr = new MemberMgr();
	$siteMgr = new SiteMgr();


	/*##################################### Parameter 셋팅 #####################################*/
	$strSearchField				= $_POST["searchField"]				? $_POST["searchField"]				: $_REQUEST["searchField"];
	$strSearchKey				= $_POST["searchKey"]				? $_POST["searchKey"]				: $_REQUEST["searchKey"];
	$strSearchDay				= $_POST["searchDay"]				? $_POST["searchDay"]				: $_REQUEST["searchDay"];

	$strSearchOrderStatus		= $_POST["searchOrderStatus"]		? $_POST["searchOrderStatus"]		: $_REQUEST["searchOrderStatus"];
	$strSearchSettleType		= $_POST["searchSettleType"]		? $_POST["searchSettleType"]		: $_REQUEST["searchSettleType"];			// 결제방법
	$strSearchMemberType		= $_POST["searchMemberType"]		? $_POST["searchMemberType"]		: $_REQUEST["searchMemberType"];			// 회원구분(전체, 회원, 비회원)
	$strSearchDeliveryCom		= $_POST["searchDeliveryCom"]		? $_POST["searchDeliveryCom"]		: $_REQUEST["searchDeliveryCom"];			// 택배회사
	$strSearchDeliveryStatus	= $_POST["searchDeliveryStatus"]	? $_POST["searchDeliveryStatus"]	: $_REQUEST["searchDeliveryStatus"];		// 택배회사

//	if($arySearchDeliveryCom):
//		$strSearchDeliveryCom	= implode($arySearchDeliveryCom, "','");
//		$strSearchDeliveryCom	= "'{$strSearchDeliveryCom}'";
//	endif;
	
	$strSearchRegStartDt	= $_POST["searchRegStartDt"]	? $_POST["searchRegStartDt"]	: $_REQUEST["searchRegStartDt"];
	$strSearchRegEndDt		= $_POST["searchRegEndDt"]		? $_POST["searchRegEndDt"]		: $_REQUEST["searchRegEndDt"];

	$strSearchSettleType	= $_POST["searchSettleType"]	? $_POST["searchSettleType"]	: $_REQUEST["searchSettleType"];
	
	$intPage				= $_POST["page"]			? $_POST["page"]			: $_REQUEST["page"];
	$intO_NO				= $_POST["oNo"]				? $_POST["oNo"]				: $_REQUEST["oNo"];

	/*##################################### Parameter 셋팅 #####################################*/

	switch($strMode){
		case "list":
			
			/* 리스트 페이지 라인 쿠키 설정 */
			if (!$_REQUEST['pageLine']){
				$_REQUEST['pageLine'] = $_COOKIE["COOKIE_ADM_ORDER_LIST_LINE"] ? $_COOKIE["COOKIE_ADM_ORDER_LIST_LINE"] : 50;
			} else {
				setCookie("COOKIE_ADM_ORDER_LIST_LINE",$_REQUEST['pageLine'],time()+(86400 * 30),"/shopAdmin");
			}
			/* 리스트 페이지 라인 쿠키 설정 */

			/* 관리자 Sub Menu 권한 설정 */
			$strLeftMenuCode01 = "001";
			$strLeftMenuCode02 = "001";
			/* 관리자 Sub Menu 권한 설정 */

			switch($strSearchOrderStatus){
				case "J":
					$strLeftMenuCode01  = "001";				
					$strLeftMenuCode02  = "002";
					$strMenuTitle		= "입금예정목록"; 
				break;
				case "A":
					$strLeftMenuCode01 = "001";
					$strLeftMenuCode02  = "003";
					$strMenuTitle		= "입금예정목록";
				break;
				case "I":
					$strLeftMenuCode02  = "004";
					$strMenuTitle		= "입금예정목록";
				break;
				case "D":
					$strLeftMenuCode02  = "005";
					$strMenuTitle		= "입금예정목록";
				break;
				case "R":
					$strLeftMenuCode01 = "004";
					$strLeftMenuCode02 = "006";
					$strMenuTitle		= "반품/교환신청목록";
				break;
				case "E":
					$strLeftMenuCode01 = "003";
					$strLeftMenuCode02 = "007";
					$strMenuTitle		= "구매확정목록";
				break;
				case "C":
					$strLeftMenuCode01 = "001";
					$strLeftMenuCode02 = "003";
					$strMenuTitle		= "취소신청목록";
				break;
				case "T":
					$strLeftMenuCode01 = "004";
					$strLeftMenuCode02 = "004";
					$strMenuTitle		= "환불신청목록";
				break;
				default:
					$strLeftMenuCode01 = "001";
					$strLeftMenuCode02 = "001";
					$strMenuTitle	   = "주문리스트";
				break;
			}
			//if (!$_REQUEST['searchRegStartDt']) $_REQUEST['searchRegStartDt'] = date("Y-m-")."01";
			if (!$_REQUEST['searchRegStartDt'] && $_REQUEST["searchYN"] != "Y") {
				$_REQUEST['searchRegStartDt'] = date("Y-m-d",mktime(0,0,0,date("m"),date("d")-7,date("Y")));
			}

			if (!$_REQUEST['searchRegEndDt'] && $_REQUEST["searchYN"] != "Y") {
				$_REQUEST['searchRegEndDt'] = date("Y-m-d");
			}

				
			## STEP 1.
			## 선언

			## 소속 국가 설정
			$strSearchNation						= $_REQUEST['searchNation'];

			## STEP 2.
			## 주문 리스트
			$param									= "";
			$param['searchField']					= $_REQUEST['searchField'];
			$param['searchKey']						= $_REQUEST['searchKey'];
			$param['searchMemberType']				= $_REQUEST['searchMemberType'];
			$param['searchRegStartDt']				= $_REQUEST['searchRegStartDt'];
			$param['searchRegEndDt']				= $_REQUEST['searchRegEndDt'];
			$param['searchSettleType']				= $_REQUEST['searchSettleType'];
			$param['searchDeliveryCom']				= $_REQUEST['searchDeliveryCom'];
			$param['searchDeliveryStatus']			= $_REQUEST['searchDeliveryStatus'];

			$param['searchOrderStatus']				= $strSearchOrderStatus;
			$param['searchOrderMemo']				= $_REQUEST['searchOrderMemo'];

			$strOrderInfoDisplayYN					= "Y"; //입점사이거나 영업사원이면서 관리몰이 있을 경우는 주문에 대한 상세정보를 알 수 없게 처리
			if ($a_admin_type == "S" && $a_admin_shop_no){
				$param['searchShopNo']	= $a_admin_shop_no;
				$strOrderInfoDisplayYN	= "N";
				$strOrderInfoShopNo		= $a_admin_shop_no;
			} else {
				if ($ADMIN_SHOP_SELECT_USE == "Y"){
					
					if ($_REQUEST['searchShop'] && $_REQUEST['searchShop'] != "undefined"){
						$param['searchShopNo'] = $_REQUEST['searchShop'];
					}
					
					if ($a_admin_tm == "Y" && $a_admin_shop_list) {
						/* 영업사원이며 tm 입점사관리 기능이 있을 경우 */
						$param['searchShopList'] = $a_admin_shop_list;
						$strOrderInfoDisplayYN	 = "N";
						$strOrderInfoShopNo		 = $a_admin_shop_list;
					}

					
				}
			}
			
			if ($S_FIX_MEMBER_CATE_USE_YN == "Y"){
				## 소속 검색
				if($_REQUEST['searchNation'] || $_REQUEST['searchCate1'] || $_REQUEST['searchCate2'] || $_REQUEST['searchCate3'] || $_REQUEST['searchCate4']):
					
					## 설정
					require_once MALL_CONF_LIB."memberCateMgr.php";
					$memberCateMgr			= new MemberCateMgr();

					## 검색 카테고리 설정
					$cateCode				= "";
					if($_REQUEST['searchCate1']) { $cateCode = $_REQUEST['searchCate1']; };
					if($_REQUEST['searchCate2']) { $cateCode = $_REQUEST['searchCate2']; };
					if($_REQUEST['searchCate3']) { $cateCode = $_REQUEST['searchCate3']; };
					if($_REQUEST['searchCate4']) { $cateCode = $_REQUEST['searchCate4']; };

					## 데이터
	//				$param								= "";
	//				$param['MEMBER_CATE_MGR_JOIN']		= "Y";
	//				$param['C_NATION']					= $_REQUEST['searchNation'];
	//				$param['C_CODE']					= $cateCode;
	//				$aryMemberCate						= $memberCateMgr->getMemberCateJoinListEx($db, "OP_ARYLIST", $param);		
	//				$searchMemberCate					= implode(",", $aryMemberCate);				
				endif;

				if ($a_admin_level > 0): 
				
					## 차수별 회원 소속 설정
					$searchCateCode						= $cateCode;
						
					## 설정
					require_once MALL_CONF_LIB."memberCateMgr.php";
					$memberCateMgr			= new MemberCateMgr();

					$param2								= "";
					$param2['C_CODE_COLUMN_ARYLIST']	= "Y";
					$param2['M_NO']						= $a_admin_no;
					$cateCode							= $memberCateMgr->getMemberCateJoinListEx($db, "OP_ARYLIST", $param2);
					
				endif;
			}
// 2013.12.20 KIM HEE SUNG 소스 정리
//			if ($S_FIX_MEMBER_CATE_USE_YN  == "Y"){
//				
//				## 설정
//				require_once MALL_CONF_LIB."memberCateMgr.php";
//				$memberCateMgr			= new MemberCateMgr();
//
//
//				## 소속 검색
//				$strSearchNation						= $_POST["searchNation"]		? $_POST["searchNation"]		: $_REQUEST["searchNation"];
//				$strSearchCate1							= $_POST["searchCate1"]			? $_POST["searchCate1"]			: $_REQUEST["searchCate1"];
//				$strSearchCate2							= $_POST["searchCate2"]			? $_POST["searchCate2"]			: $_REQUEST["searchCate2"];
//				$strSearchCate3							= $_POST["searchCate3"]			? $_POST["searchCate3"]			: $_REQUEST["searchCate3"];
//				$strSearchCate4							= $_POST["searchCate4"]			? $_POST["searchCate4"]			: $_REQUEST["searchCate4"];
//				if($strSearchNation || $strSearchCate1 || $strSearchCate2 || $strSearchCate3 || $strSearchCate4):
//					
//
//					## 검색 카테고리 설정
//					$cateCode				= "";
//					if($strSearchCate1) { $cateCode = $strSearchCate1; }
//					if($strSearchCate2) { $cateCode = $strSearchCate2; }
//					if($strSearchCate3) { $cateCode = $strSearchCate3; }
//					if($strSearchCate4) { $cateCode = $strSearchCate4; }
//
//					## 데이터
////					$param								= "";
//					$param['MEMBER_CATE_MGR_JOIN']		= "Y";
//					$param['searchMemberNation']		= $strSearchNation;
//					$param['M_CATE']					= $cateCode;
//				
//				elseif ($a_admin_level > 0): 
//				
//					## 차수별 회원 소속 설정
//						
//					$param2								= "";
//					$param2['C_CODE_COLUMN_ARYLIST']	= "Y";
//					$param2['M_NO']						= $a_admin_no;
//					$cateCode							= $memberCateMgr->getMemberCateJoinListEx($db, "OP_ARYLIST", $param2);
//					$param['M_CATE']					= $cateCode;
//				endif;
//			}

			$param['SEARCH_CATE']					= $searchCateCode;
			$param['SEARCH_NATION']					= $strSearchNation;
			$param['M_CATE']						= $cateCode;
			$intTotal								= $orderMgr->getOrderListEx($db, "OP_COUNT", $param);							// 데이터 전체 개수 
//			echo $db->query;
			$intPageLine							= $_REQUEST['pageLine'] ? $_REQUEST['pageLine'] : 50;																			// 리스트 개수 
			$intPage								= ( $intPage )				? $intPage		: 1;
			$intFirst								= ( $intTotal == 0 )		? 0				: $intPageLine * ( $intPage - 1 );

			$param['order_by']						= "A.O_NO DESC";
			$param['limit']							= "{$intFirst},{$intPageLine}";
			$orderListResult						= $orderMgr->getOrderListEx($db, "OP_LIST", $param);
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

			/*국가/주*/
			$aryCountryList		= getCountryList();			
			$aryCountryState	= getCommCodeList("STATE","");
			
			/* 가상계좌 입금은행 */
			$aryTBank			= getCommCodeList("BANK2");
		break;

	}
?>