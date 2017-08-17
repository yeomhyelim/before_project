<?
	require_once MALL_CONF_LIB."OrderAdmMgr.php";
	require_once MALL_CONF_LIB."ProductAdmMgr.php";
	require_once MALL_CONF_LIB."MemberAdmMgr.php";
	require_once MALL_CONF_LIB."SiteMgr.php";

	$orderMgr = new OrderMgr();
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

	$strSearchOrderPath		= $_POST["searchOrderPath"]	? $_POST["searchOrderPath"]	: $_REQUEST["searchOrderPath"];

	$intPage				= $_POST["page"]			? $_POST["page"]			: $_REQUEST["page"];
	$intO_NO				= $_POST["oNo"]				? $_POST["oNo"]				: $_REQUEST["oNo"];

	/*##################################### Parameter 셋팅 #####################################*/

	switch($strMode){
		case "list":

			/* 관리자 Sub Menu 권한 설정 */
			$strLeftMenuCode01 = "001";
			$strLeftMenuCode02 = "001";
			/* 관리자 Sub Menu 권한 설정 */

			switch($strSearchOrderStatus){
				case "J":
					$strLeftMenuCode01 = "001";
					$strLeftMenuCode02 = "002";
				break;
				case "A":
					$strLeftMenuCode02 = "003";
				break;
				case "I":
					$strLeftMenuCode02 = "004";
				break;
				case "D":
					$strLeftMenuCode02 = "005";
				break;
				case "R":
					$strLeftMenuCode01 = "004";
					$strLeftMenuCode02 = "006";
				break;
				case "E":
					$strLeftMenuCode01 = "003";
					$strLeftMenuCode02 = "007";
				break;
				default:
					$strLeftMenuCode01 = "001";
					$strLeftMenuCode02 = "001";
				break;
			}
			//if (!$strSearchRegStartDt) $strSearchRegStartDt = date("Y-m-d",mktime(0,0,0,date("m"),date("d")-10,date("Y")));
			//if (!$strSearchRegEndDt) $strSearchRegEndDt = date("Y-m-d");

			if($S_SHOP_HOME == "demo2"):
				// 2013.06.21 kim hee sung 주문관리 입점몰 추가 작업으로 소스 변경중...

				## STEP 1.
				## 선언
				require_once MALL_CONF_LIB."OrderAdmMgr2.php";
				$orderMgr2 = new OrderMgr2();

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
				$intTotal								= $orderMgr2->getOrderListEx($db, "OP_COUNT", $param);							// 데이터 전체 개수
				$intPageLine							= 10;																			// 리스트 개수
				$intPage								= ( $intPage )				? $intPage		: 1;
				$intFirst								= ( $intTotal == 0 )		? 0				: $intPageLine * ( $intPage - 1 );

				$param['order_by']						= "A.O_NO DESC";
				$param['limit']							= "{$intFirst},{$intPageLine}";
				$orderListResult						= $orderMgr2->getOrderListEx($db, "OP_LIST", $param);

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

				## STEP 3.
				## 스킨 url
				$includeFile	= "{$strIncludePath}{$aryIncludeFolder[$strMode]}/list_new.php";
				break;
			endif;

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
			$orderMgr->setSearchOrderPath($strSearchOrderPath);
			$orderMgr->setP_LNG($strStLng);

			/* 검색부분 */

			$intPageBlock	= 10;
			$intPageLine	= 10;

			$orderMgr->setPageLine($intPageLine);

			$intTotal	= $orderMgr->getOrderTotal($db);
			$intTotPage	= ceil($intTotal / $orderMgr->getPageLine());

			if(!$intPage)	$intPage =1;

			if ($intTotal==0) {
				$intFirst	= 1;
				$intLast	= 0;
			} else {
				$intFirst	= $intPageLine *($intPage -1);
				$intLast	= $intPageLine * $intPage;
			}
			$orderMgr->setLimitFirst($intFirst);

			$param  = "";
			$param['KOREA_POLICY_USE'] = $S_ORDER_KOREA_SHIPPING_POLICY_USE;
			$result = $orderMgr->getOrderList($db,$param);
//			echo '<!--  ' . $db->query . '  -->';
			$intListNum = $intTotal - ($intPageLine *($intPage-1));

			$linkPage  = "?menuType=$strMenuType&mode=$strMode";
			$linkPage .= "&searchField=$strSearchField&searchKey=$strSearchKey";
			$linkPage .= "&searchRegStartDt=$strSearchRegStartDt&searchRegEndDt=$strSearchRegEndDt";
			$linkPage .= "&searchSettleC=$strSearchSettleC&searchSettleA=$strSearchSettleA";
			$linkPage .= "&searchSettleT=$strSearchSettleT&searchSettleB=$strSearchSettleB";
			$linkPage .= "&searchOrderStatus=$strSearchOrderStatus";
			$linkPage .= "&page=";

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
			$aryDeliveryComAll = getCommCodeList("DELIVERY","Y");

			/*국가/주*/
			$aryCountryList		= getCountryList();
			$aryCountryState	= getCommCodeList("STATE","");

			/* 가상계좌 입금은행 */
			$aryTBank			= getCommCodeList("BANK2");

		break;

	}
?>