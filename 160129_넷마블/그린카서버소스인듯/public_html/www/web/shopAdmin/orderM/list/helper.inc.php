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

			## STEP 1.
			## 선언
			if (!$_REQUEST['searchRegStartDt'] && $_REQUEST["searchYN"] != "Y") {
				$_REQUEST['searchRegStartDt'] = date("Y-m-d",mktime(0,0,0,date("m"),date("d")-7,date("Y")));
			}

			if (!$_REQUEST['searchRegEndDt'] && $_REQUEST["searchYN"] != "Y") {
				$_REQUEST['searchRegEndDt'] = date("Y-m-d");
			}

			## 소속 국가 설정
			$strSearchNation						= $_REQUEST['searchNation'];


			include $strIncludePath.$aryIncludeFolder[$strMode]."/list.helper.inc.php";

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

			/* 가상계좌 입금은행 */
			$aryTBank			= getCommCodeList("BANK2");

		break;

	}
?>