<?
	switch($strAct):
		case "excelDeliveryFastList":
		case "excelDeliveryList":

		case "excelDeliveryAllFastList":
			// 빠른송장입력
			// 2013.06.24 kim hee sung 빠른송장입력, 입점몰 버전
			
			## STEP 1.
			## 선언
			require_once MALL_CONF_LIB."ShopOrderMgr.php";
			$shopOrderMgr = new ShopOrderMgr();

			## STEP 2.
			## 배송 리스트
			$param['searchField']				= $_REQUEST['searchField'];
			$param['searchKey']					= $_REQUEST['searchKey'];
			$param['searchMemberType']			= $_REQUEST['searchMemberType'];
			$param['searchRegStartDt']			= $_REQUEST['searchRegStartDt'];
			$param['searchRegEndDt']			= $_REQUEST['searchRegEndDt'];
			$param['searchSettleType']			= $_REQUEST['searchSettleType'];
			$param['searchDeliveryCom']			= $_REQUEST['searchDeliveryCom'];
			$param['searchDeliveryStatus']		= $_REQUEST['searchDeliveryStatus'];
			$param['o_status']						= "A,B,I,D,E";
			$param['so_delivery_status_in']			= "B";
			$param['so_delivery_status_null']		= "Y";
			$param['so_order_status_in']			= "J,A";
			$param['so_order_status_null']			= "Y";

			if($_SESSION['ADMIN_TYPE'] == "S"):
				// 입점몰인 경우
				$param['sh_no']						= $_SESSION['ADMIN_SHOP_NO'];
				if(!$param['sh_no']):
					echo "입점몰 정보가 없습니다.";
					exit;
				endif;
			endif;

			$strOrderInfoDisplayYN					= "Y"; //입점사이거나 영업사원이면서 관리몰이 있을 경우는 주문에 대한 상세정보를 알 수 없게 처리
			if ($a_admin_type == "S" && $a_admin_shop_no){
				$param['sh_no']			= $a_admin_shop_no;
				$strOrderInfoDisplayYN	= "N";
				$strOrderInfoShopNo		= $a_admin_shop_no;
			} else {
				if ($ADMIN_SHOP_SELECT_USE == "Y"){
					
					if ($_REQUEST['searchShop'] && $_REQUEST['searchShop'] != "undefined"){
						$param['sh_no'] = $_REQUEST['searchShop'];
					}
					
					if ($a_admin_tm == "Y" && $a_admin_shop_list) {
						/* 영업사원이며 tm 입점사관리 기능이 있을 경우 */
						$param['sh_no'] = $a_admin_shop_list;
						$strOrderInfoDisplayYN	 = "N";
						$strOrderInfoShopNo		 = $a_admin_shop_list;
					}
				}
			}


			/** 2013.06.26 kim hee sung 배송중목록,배송완료목록을 위한 변수, 단, 추구 변수값 변경이 필요함 **/
			if($_REQUEST['searchOrderStatus']):
				$param['o_status']				= "";
				$param['so_delivery_status_in'] = $_REQUEST['searchOrderStatus'];
			endif;

			$deliveryResult						= $shopOrderMgr->getDeliveryListEx($db, "OP_LIST", $param);

			## STEP 3.
			## 결로 설정
			if ($strAct == "excelDeliveryFastList") $strExcelFileName	= iconv("utf-8","euc-kr",date("Ymd")."_송장입력목록");
			else $strExcelFileName	= iconv("utf-8","euc-kr",date("Ymd")."_배송중목록");
			break;
		break;
	endswitch;
?>