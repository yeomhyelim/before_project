<?
	require_once MALL_CONF_LIB."ShopMgr.php";
	require_once MALL_CONF_LIB."AdminMenu.php";
	require_once MALL_CONF_LIB."OrderAdmMgr.php";
	
	$shopMgr		= new ShopMgr();
	$adminMenu		= new AdminMenu();	
	$orderMgr		= new OrderMgr();			
	
	/*##################################### Parameter 셋팅 #####################################*/
	$strSearchField = $_POST["searchField"]		? $_POST["searchField"]		: $_REQUEST["searchField"];
	$strSearchKey	= $_POST["searchKey"]		? $_POST["searchKey"]		: $_REQUEST["searchKey"];
	$intPage		= $_POST["page"]			? $_POST["page"]			: $_REQUEST["page"];
	$intPageLine	= $_POST["pageLine"]		? $_POST["pageLine"]		: $_REQUEST["pageLine"];

	$strSearchMemberType	= $_POST["searchMemberType"]	? $_POST["searchMemberType"]	: $_REQUEST["searchMemberType"];			// 회원구분(전체, 회원, 비회원)	
	$strSearchRegStartDt	= $_POST["searchRegStartDt"]	? $_POST["searchRegStartDt"]	: $_REQUEST["searchRegStartDt"];
	$strSearchRegEndDt		= $_POST["searchRegEndDt"]		? $_POST["searchRegEndDt"]		: $_REQUEST["searchRegEndDt"];

	$strSearchSettleStatus		= $_POST["searchSettleStatus"]		? $_POST["searchSettleStatus"]		: $_REQUEST["searchSettleStatus"];
	$strSearchDeliveryStatus1	= $_POST["searchDeliveryStatus1"]	? $_POST["searchDeliveryStatus1"]	: $_REQUEST["searchDeliveryStatus1"];
	$strSearchDeliveryStatus2	= $_POST["searchDeliveryStatus2"]	? $_POST["searchDeliveryStatus2"]	: $_REQUEST["searchDeliveryStatus2"];
	$strSearchDeliveryStatus3	= $_POST["searchDeliveryStatus3"]	? $_POST["searchDeliveryStatus3"]	: $_REQUEST["searchDeliveryStatus3"];
	$strSearchOrderStatus1		= $_POST["searchOrderStatus1"]		? $_POST["searchOrderStatus1"]		: $_REQUEST["searchOrderStatus1"];
	$strSearchOrderStatus2		= $_POST["searchOrderStatus2"]		? $_POST["searchOrderStatus2"]		: $_REQUEST["searchOrderStatus2"];
	$strSearchOrderStatus3		= $_POST["searchOrderStatus3"]		? $_POST["searchOrderStatus3"]		: $_REQUEST["searchOrderStatus3"];
	$strSearchOrderStatus4		= $_POST["searchOrderStatus4"]		? $_POST["searchOrderStatus4"]		: $_REQUEST["searchOrderStatus4"];

	$intSH_NO			= $_POST["shopNo"]			? $_POST["shopNo"]			: $_REQUEST["shopNo"];	
	$intSO_NO			= $_POST["shopOrderNo"]		? $_POST["shopOrderNo"]		: $_REQUEST["shopOrderNo"];	

	$aryChkNo			= $_POST["chkNo"]			? $_POST["chkNo"]			: $_REQUEST["chkNo"];
	$strOrderStatus		= $_POST["orderStatus"]		? $_POST["orderStatus"]		: $_REQUEST["orderStatus"];
	$strDeliveryStatus	= $_POST["deliveryStatus"]	? $_POST["deliveryStatus"]	: $_REQUEST["deliveryStatus"];

	/*##################################### Parameter 셋팅 #####################################*/

	$shopMgr->setSH_NO($intSH_NO);
	$shopMgr->setSO_NO($intSO_NO);
	
	$strLinkPage  = "&searchField=$strSearchField&searchKey=$strSearchKey";
	$strLinkPage .= "&searchRegStartDt=$strSearchRegStartDt&searchRegEndDt=$strSearchRegEndDt";
	$strLinkPage .= "&searchDeliveryStatus1=$strSearchDeliveryStatus1&searchDeliveryStatus2=$strSearchDeliveryStatus2";
	$strLinkPage .= "&searchDeliveryStatus3=$strSearchDeliveryStatus3";
	$strLinkPage .= "&searchOrderStatus1=$strSearchOrderStatus1&searchOrderStatus2=$strSearchOrderStatus2";
	$strLinkPage .= "&searchOrderStatus3=$strSearchOrderStatus3&searchOrderStatus4=$strSearchOrderStatus4";
	$strLinkPage .= "&searchMemberType=$strSearchMemberType&searchSettleStatus=$strSearchSettleStatus&page=$intPage";
	
	switch ($strAct) {
		case "orderStatusSave":
			// 구매상태 일괄 수정

			## STEP 1.
			## 구매상태 정보 NO 값 설정
			$arySO_NO = $_POST['chkNo'];
			if(!is_array($arySO_NO)):
				echo "구매상태가 없습니다.";
				exit;
			endif;

			## STEP 2.
			## 구매상태 정보 업데이트
			foreach($arySO_NO as $so_no):
				$param['so_no']					= $so_no;
				$param['so_order_status']		= $_POST["orderStatus_{$so_no}"];
				$re								= $shopMgr->getOrderStatusUpdateEx($db, $param);
				if($re != 1):
					echo "구매상태 업데이트 실패 건이있습니다.({$so_no})";
					exit;
				endif;
			endforeach;

			$strUrl = "./?menuType=order&mode=list&page={$_POST['page']}";
		break;

		case "deliverySave":
			// 배송정보 일괄 수정

			## STEP 1.
			## 배송 정보 NO 값 설정
			$arySO_NO = $_POST['chkNo'];
			if(!is_array($arySO_NO)):
				echo "배송정보가 없습니다.";
				exit;
			endif;

			## STEP 2.
			## 배송관련 정보 업데이트
			foreach($arySO_NO as $so_no):
				$param['so_no']					= $so_no;
				$param['so_delivery_com']		= $_POST["deliveryCom_{$so_no}"];
				$param['so_delivery_num']		= $_POST["deliveryNum_{$so_no}"];
				$param['so_delivery_status']	= $_POST["deliveryStatus_{$so_no}"];
				$re								= $shopMgr->getDeliveryUpdateEx($db, $param);
				if($re != 1):
					echo "배송 정보 업데이트 실패 건이있습니다.({$so_no})";
					exit;
				endif;
			endforeach;

			/** 2013.06.25 kim hee sung 이전 주소로 이동 **/
			/** 변경 이유는 주문관리/주문리스트, 배송관리/빠른송장입력 2곳에서 사용중입니다.**/
			$strUrl = $_SERVER['HTTP_REFERER'];
//			$strUrl = "./?menuType=order&mode=list&page={$_POST['page']}";

		break;

		case "orderUpdate":
			if (is_array($aryChkNo)){
				for($i=0;$i<sizeof($aryChkNo);$i++){
				
					if ($aryChkNo[$i] > 0){
						$intSO_NO = $aryChkNo[$i];
						$shopMgr->setSO_NO($intSO_NO);
						$shopOrderRow = $shopMgr->getShopOrderView($db);
						$shopMgr->setO_NO($shopOrderRow[O_NO]);

						$strSO_ORDER_STATUS	= $_POST["orderStatus_".$intSO_NO];
						$shopMgr->setSO_ORDER_STATUS($strSO_ORDER_STATUS);
						$shopMgr->getOrderStatusUpdate($db);
						
						getOrderStatusUpdate($shopMgr,$strSO_ORDER_STATUS);
					}	
				}
			}

			$strUrl = "./?menuType=seller&mode=orderList".$strLinkPage;

		break;
		
		case "orderStatusUpdate":

			$shopMgr->setSO_ORDER_STATUS($strOrderStatus);

			if (is_array($aryChkNo)){
				for($i=0;$i<sizeof($aryChkNo);$i++){
				
					if ($aryChkNo[$i] > 0){
						$intSO_NO = $aryChkNo[$i];
						$shopMgr->setSO_NO($intSO_NO);
						$shopOrderRow = $shopMgr->getShopOrderView($db);
						$shopMgr->setO_NO($shopOrderRow[O_NO]);
						
						$shopMgr->getOrderStatusUpdate($db);
					
						getOrderStatusUpdate($shopMgr,$strOrderStatus);
					}
				}
			}

			$strUrl = "./?menuType=seller&mode=orderList".$strLinkPage;

		break;

		
		case "deliveryStatusUpdate":
			$shopMgr->setSO_DELIVERY_STATUS($strDeliveryStatus);

			if (is_array($aryChkNo)){
				for($i=0;$i<sizeof($aryChkNo);$i++){
				
					if ($aryChkNo[$i] > 0){
						$intSO_NO = $aryChkNo[$i];
						$shopMgr->setSO_NO($intSO_NO);
						$shopOrderRow = $shopMgr->getShopOrderView($db);
						$shopMgr->setO_NO($shopOrderRow[O_NO]);
						
						$shopMgr->getDeliveryStatusUpdate($db);
					
						/* 주문 상품이 모두 선택한 상태와 같아면 전체 주문상태도 바뀌어야 함 */
						getOrderStatusUpdate($shopMgr,$strDeliveryStatus);
					}
				}
			}

			$strUrl = "./?menuType=seller&mode=orderList".$strLinkPage;
		break;

		case "deliveryUpdate":
			// 배송 정보 변경
			
			## STEP 1.
			## 변경할 데이터 체크
			if(!is_array($aryChkNo)):
				echo "변경할 정보가 없습니다.";
				exit;
			endif;

			foreach($aryChkNo as $key => $so_no):
				if(!$so_no) { continue; }
				
				## STEP 2.
				## 주문 정보 불러오기
				$shopMgr->setSO_NO($so_no);
				$shopOrderRow	= $shopMgr->getShopOrderView($db);
				$sh_no			= $shopOrderRow['SH_NO'];

				## STEP 3.
				## 입점 업체 정보 불러오기
				$shopMgr->setSO_NO("");
				$shopMgr->setSH_NO($sh_no);
				$shopRow		=$shopMgr->getShopView($db);

				## STEP 4.
				## 배송 정보 변경
				$strSO_DELIVERY_COM		= $shopRow['SH_COM_DELIVERY_COR'];
				$strSO_DELIVERY_NUM		= $_POST["deliveryNum_{$so_no}"];
				$strSO_DELIVERY_STATUS	= $_POST["deliveryStatus_{$so_no}"];
				
				$shopMgr->setSO_NO($so_no);
				$shopMgr->setSO_DELIVERY_COM($strSO_DELIVERY_COM);
				$shopMgr->setSO_DELIVERY_NUM($strSO_DELIVERY_NUM);
				$shopMgr->setSO_DELIVERY_STATUS($strSO_DELIVERY_STATUS);
				$shopMgr->getDeliveryUpdate($db);

				## STEP 5.
				## ORDER_MGR 상태 변경				
//				$param['o_no']			= $shopOrderRow['O_NO'];
//				$orderListRow			= $orderMgr->getOrderListEx($db, "OP_SELECT", $param);
//				$o_status				= $orderListRow['O_STATUS'];
//				
//				$shopMgr->setO_NO($shopOrderRow['O_NO']);
//				$shopOrderAry			= $shopMgr->getShopOrderAllList($db);
//				$shop_o_status			= "";
//
//				foreach($aryShopOrderAllList as $key => $data):
//					$delivery_status	= $data['SO_DELIVERY_STATUS'];
//					if($delivery_status == "B"):
//						// 배송준비중
//						if(!in_array($shop_o_status, array("I")) { $shop_o_status = "B"; }
//					elseif($delivery_status == "I"):
//						// 배송중
//						$shop_o_status = "I";
//					elseif($delivery_status == "D"):
//						// 배송완료
//						if(!in_array($shop_o_status, array("B", "I")) { $shop_o_status = "D"; }
//					endif;
//				endforeach;
//
//				$shopMgr->setO_NO($shopOrderRow['O_NO']);
//				getOrderStatusUpdate($shopMgr, $strSO_DELIVERY_STATUS);
			endforeach;

			$strUrl = "./?menuType=seller&mode=orderList".$strLinkPage;
		break;
// 2013.06.20 kim hee sung 소스 정리
//		case "deliveryUpdate":
//			// 배송 정보 변경
//
//			if (is_array($aryChkNo)){
//				for($i=0;$i<sizeof($aryChkNo);$i++){
//				
//					if ($aryChkNo[$i] > 0){
//						$intSO_NO = $aryChkNo[$i];
//						$shopMgr->setSO_NO($intSO_NO);
//						$shopOrderRow = $shopMgr->getShopOrderView($db);
//						$shopMgr->setSH_NO($shopOrderRow['SH_NO']);
//						$shopRow =$shopMgr->getShopView($db);
//						
//						$strSO_DELIVERY_COM		= $shopRow[SH_COM_DELIVERY_COR];
//						$strSO_DELIVERY_NUM		= $_POST["deliveryNum_".$intSO_NO];
//						$strSO_DELIVERY_STATUS	= $_POST["deliveryStatus_".$intSO_NO];
//						if (!$shopRow[SO_DELIVERY_NUM]) $strSO_DELIVERY_STATUS = "I";
//						
//						$shopMgr->setSO_DELIVERY_COM($strSO_DELIVERY_COM);
//						$shopMgr->setSO_DELIVERY_NUM($strSO_DELIVERY_NUM);
//						$shopMgr->setSO_DELIVERY_STATUS($strSO_DELIVERY_STATUS);
//						$shopMgr->getDeliveryUpdate($db);
//
//						$shopMgr->setO_NO($shopOrderRow['O_NO']);
//						getOrderStatusUpdate($shopMgr,$strSO_DELIVERY_STATUS);
//					
//						/* 주문 상품이 모두 배송중이면 전체 주문상태를 배송중으로 바뀌어야 함 */
//					
//					}
//				}
//			}
//
//			$strUrl = "./?menuType=seller&mode=orderList".$strLinkPage;
//
//		break;

	}	


	/* 입점몰의 배송상태/구매상태에 따른 원주문상태 변경 */
	function getOrderStatusUpdate(&$shopMgr,$strStatus)
	{	
		global $db;

		$intCnt = $intShopCnt = 0;
		$aryShopOrderAllList = $shopMgr->getShopOrderAllList($db);
		$intShopCnt = sizeof($aryShopOrderAllList);
		
		if ($intShopCnt > 0){

			if ($strStatus == "B" || $strStatus == "I"){
				/* 배송준비중/배송중일때는 Master 주문상태를 바꿔준다. */
				$shopMgr->setO_STATUS($strStatus);
				$shopMgr->getOrderAllUpdate($db);
			} else {
				for($j=0;$j<sizeof($aryShopOrderAllList);$j++){
					if ($aryShopOrderAllList[$j][SO_ORDER_STATUS] == $strStatus) $intCnt++;
				}

				if ($intCnt == $intShopCnt) {
					$shopMgr->setO_STATUS($strStatus);
					$shopMgr->getOrderAllUpdate($db);
				}
			}
		}

		return true;
	}

?>