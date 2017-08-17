<?
	require_once MALL_CONF_LIB."OrderAdmMgr.php";
	require_once MALL_CONF_LIB."ProductAdmMgr.php";
	require_once MALL_CONF_LIB."MemberAdmMgr.php";
	require_once MALL_CONF_LIB."SiteMgr.php";
	require_once MALL_CONF_LIB."CouponMgr.php";
	require_once MALL_CONF_LIB."ShopOrderMgr.php";
	require_once MALL_CONF_LIB."ShopMgr.php";

	$orderMgr = new OrderMgr();
	$productMgr = new ProductAdmMgr();
	$memberMgr = new MemberMgr();
	$siteMgr = new SiteMgr();
	$couponMgr = new CouponMgr();
	$shopOrderMgr = new ShopOrderMgr();
	$shopMgr		= new ShopMgr();
		
	/* 여기에 추가되어야 함(메일관련) */
	require_once $S_DOCUMENT_ROOT.$S_SHOP_HOME."/layout/mail/_config.inc.php";
	require_once $S_DOCUMENT_ROOT."www/config/mail.func.php";	
	/* 여기에 추가되어야 함(메일관련) */

	/* 여기에 추가되어야 함(문자관련) 2013.04.18 */
	$smsConfFile = "{$S_DOCUMENT_ROOT}{$S_SHOP_HOME}/conf/smsInfo.conf.inc.php";
	if(is_file($smsConfFile)):
		require_once $smsConfFile;
		require_once "{$S_DOCUMENT_ROOT}www/classes/sms/sms.func.class.php";
		$smsFunc = new SmsFunc();
	endif;
	/* 여기에 추가되어야 함(문자관련) 2013.04.18 */

	/*배송회사*/
	$aryDeliveryCom = getCommCodeList("DELIVERY","Y");

	$siteRow = $siteMgr->getSiteInfo($db);

	switch($strJsonMode):
	case "orderStatusSave":
		// 구매상태 변경
		// ./?menuType=seller&mode=json&jsonMode=orderStatusSave&so_no=31&orderStatus=E
		if(!$_REQUEST['oc_no']):
			$result				= "";
			$result['mode']		= "__ERROR__";
			$result['text']		= "입점사_주문관리번호가 없습니다.";
			getJsonExit($result);
		endif;

		## STEP 2.
		## 구매상태 업데이트
		$param							= "";
		$param['oc_no']					= $_REQUEST['oc_no'];
		$param['oc_order_status']		= $_REQUEST['orderStatus'];
		$strOrderStatusMemo				= $_REQUEST['orderStatusMemo'];

		if ($param['oc_order_status'])
		{
			if ($param['oc_order_status'] == "E"){
				
				$param["oc_status1"]	= "E";
				$param["oc_status2"]	= "";
				$param["oc_req_dt"]		= "";
				$param["oc_reg_dt"]		= "";
				$param["oc_reg_no"]		= $a_admin_no;
				
				$re = $shopOrderMgr->getOrderMallCerityUpdate($db,$param);
			} else {

				$strOrderReturnStatus1 = SUBSTR($param["oc_order_status"],0,1);
				$strOrderReturnStatus2 = SUBSTR($param["oc_order_status"],1);
						
				if ($param['oc_no'] > 0){

					$param["oc_status1"]	= $strOrderReturnStatus1;
					$param["oc_status2"]	= $strOrderReturnStatus2;
					$param["oc_reg_no"]		= $a_admin_no;
					
					$re = $shopOrderMgr->getOrderMallReturnUpdate($db,$param);
				}
			}
			
			$param['so_no']					= "";
			$param['update_type']			= "P";
			$param['reg_no']				= $a_admin_no;
			$intO_NO						= $shopOrderMgr->getOrderNo($db,$param);
			
			if ($intO_NO > 0){
				$orderMgr->setO_NO($intO_NO);
				$orderRow = $orderMgr->getOrderView($db);
				$strPreOrderStatus = $orderRow['O_STATUS'];

				$shopOrderMgr->getOrderStatusAllUpdate($db,$param);	
				/* 마스터 주문상태가 변경되었을때 포인트/쿠폰 작업을 진행한다*/
				if ($orderRow["O_USE_LNG"] == "KR"){

					include MALL_WEB_PATH."shopAdmin/order/mallList/orderMallStatusUpdate.php";
				}
			}
		}
		
		if($re != 1):
			$result				= "";
			$result['mode']		= "__ERROR__";
			$result['text']		= "구매상태를 업데이트 할수 없습니다.";
			getJsonExit($result);
		endif;
		
		/* HISTORY INSERT */
		if (!$strOrderStatusMemo){
			$strOrderStatusMemo = "구매상태변경";
		}
		$strOrderStatusText	= $param["oc_no"]."/".$param['oc_order_status'];

		$param['m_no']		= $a_admin_no;
		$param['h_tab']		= TBL_ORDER_MGR;
		$param['h_key']		= $intO_NO;
		$param['h_code']	= "002"; //구매상태
		$param['h_memo']	= $strOrderStatusMemo;
		$param['h_text']	= $strOrderStatusText;
		$param['h_reg_no']	= $a_admin_no;
		$param['h_adm_no']	= $a_admin_no;
		
		$shopOrderMgr->getOrderStatusHistoryUpdate($db,$param);
		/* HISTORY INSERT */

		$result				= "";
		$result['mode']		= "__SUCCESS__";
		$result['text']		= "변경되었습니다.";
		getJsonExit($result);	
	break;

	case "deliverySave":
		// 배송정보 수정
		// ./?menuType=seller&mode=json&jsonMode=deliverySave&so_no=22&deliveryCom=&deliveryNum=&deliveryStatus=

		## STEP 1.
		## 입력값 체크
		if(!$_REQUEST['so_no']):
			$result				= "";
			$result['mode']		= "__ERROR__";
			$result['text']		= "입점사_주문관리번호가 없습니다.";
			getJsonExit($result);
		endif;

		## STEP 2.
		## 배송관련 정보 업데이트
		$param['so_no']					= $_REQUEST['so_no'];
		$param['so_delivery_com']		= $_REQUEST['deliveryCom'];
		$param['so_delivery_num']		= $_REQUEST['deliveryNum'];
		$param['so_delivery_status']	= $_REQUEST['deliveryStatus'];
		$param['oc_no']					= "";
		$param['update_type']			= "B";
		$param['reg_no']				= $a_admin_no;

		$re								= $shopMgr->getDeliveryUpdateEx($db, $param);
		
		if($re != 1):
			$result				= "";
			$result['mode']		= "__ERROR__";
			$result['text']		= "배송관련 정보를 업데이트 할수 없습니다.";
			getJsonExit($result);
		endif;
		
		/* 마스터 주문상태 변경 */
		$intO_NO	= $shopOrderMgr->getOrderNo($db,$param);
			
		if ($intO_NO > 0){
			$orderMgr->setO_NO($intO_NO);
			$orderRow = $orderMgr->getOrderView($db);
			$strPreOrderStatus = $orderRow['O_STATUS'];
		
			$shopOrderMgr->getOrderStatusAllUpdate($db,$param);	
			if ($orderRow["O_USE_LNG"] == "KR"){
				/* 마스터 주문상태가 변경되었을때 포인트/쿠폰 작업을 진행한다*/
				include MALL_WEB_PATH."shopAdmin/order/mallList/orderMallStatusUpdate.php";
			}
		}
		/* 마스터 주문상태 변경 */

		/* HISTORY INSERT */
		$strOrderStatusMemo = "배송상태변경";
		$strOrderStatusText	= $param["so_no"]."/".$param['so_delivery_status'];

		$param['m_no']		= $a_admin_no;
		$param['h_tab']		= TBL_ORDER_MGR;
		$param['h_key']		= $intO_NO;
		$param['h_code']	= "003"; //배송상태
		$param['h_memo']	= $strOrderStatusMemo;
		$param['h_text']	= $strOrderStatusText;
		$param['h_reg_no']	= $a_admin_no;
		$param['h_adm_no']	= $a_admin_no;
		
		$shopOrderMgr->getOrderStatusHistoryUpdate($db,$param);
		/* HISTORY INSERT */
		
		/** 메일 전송 - 배송중 **/
		if ($param['so_delivery_status'] == "I"){
			/* 입점사별 정보 */
			$shopOrderRow = $shopOrderMgr->getShopOrderView($db,$param);
			
			/* 주문정보 */
			$intO_NO = $shopOrderRow["O_NO"];
			$orderMgr->setO_NO($intO_NO);
			$orderRow = $orderMgr->getOrderView($db);
			
			if ($orderRow['O_USE_LNG'] == "KR"){
				$param["o_use_lng"] = $orderRow["O_USE_LNG"];
				$param["shop_no"]	= $shopOrderRow["SH_NO"];
				$param["op"]		= "result";
				$param["o_no"]		= $intO_NO;
				$cartResult = $shopOrderMgr->getOrderCartList($db,$param);
				$intCartTotal= $cartResult["cnt"];

				$strMailSendMode = "adm";
				$strMailMode = "orderDeliverySend";
				include WEB_FRWORK_ACT."orderMailForm.inc.php";

				/** 메일 전송 - 고객 주문 취소 메일 **/
				$aryTAG_LIST['{{__받는사람이름__}}']	= $orderRow['O_J_NAME'];
				$aryTAG_LIST['{{__받는사람메일__}}']	= $orderRow['O_J_MAIL'];
				$aryTAG_LIST['{{__회원명__}}']			= $orderRow['O_J_NAME'];
				$aryTAG_LIST['{{__주문번호__}}']		= $orderRow['O_KEY'];
				$aryTAG_LIST['{{__주문상품내역__}}']	= $strOrderCartHtml;
				$aryTAG_LIST['{{__주문배송정보__}}']	= $strOrderInfoHtml;
				$aryTAG_LIST['{{__배송사__}}']			= $aryDeliveryCom[$shopOrderRow['SO_DELIVERY_COM']];
				$aryTAG_LIST['{{__운송장번호__}}']		= $shopOrderRow['SO_DELIVERY_NUM'];
				$aryTAG_LIST['{{__주문일자__}}']		= SUBSTR($orderRow['O_REG_DT'],0,10);

				goSendMail("013");

			}
		}
		/** 메일 전송 **/
	
		$result				= "";
		$result['mode']		= "__SUCCESS__";
		$result['text']		= "변경되었습니다.";
		getJsonExit($result);	
	break;
	case "partCancelCal":
		
		$intO_NO = $_POST["oNo"];
		
		$param["o_no"]	= $intO_NO;
		$orderMgr->setO_NO($intO_NO);
		$orderRow = $orderMgr->getOrderView($db);
		
		/* 취소할 상품 리스트 */
		$aryCancelOrderCartList = $_POST["chkSocNo"];
		$strCancelOrderCartList = "";
		if (is_array($aryCancelOrderCartList)){
			for($i=0;$i<sizeof($aryCancelOrderCartList);$i++){
				$strCancelOrderCartList .= $aryCancelOrderCartList[$i].",";		
			}

			$strCancelOrderCartList = SUBSTR($strCancelOrderCartList,0,STRLEN($strCancelOrderCartList)-1);
			
			if (!$strCancelOrderCartList){
				$result				= "";
				$result[0]['mode']		= "__ERROR__";
				$result[0]['text']		= "취소할 상품이 존재하지 않습니다..";
				getJsonExit($result);
			}
		}

		$param["o_use_lng"] = $orderRow["O_USE_LNG"];
		$param["not_oc_no"] = $strCancelOrderCartList;
		$param["shop_no"]	= -9999;
		$aryOrderCartList   = $shopOrderMgr->getOrderCartList($db,$param);

		if (!$aryOrderCartList){
			$result				= "";
			$result[0]['mode']		= "__ERROR__";
			$result[0]['text']		= "취소할 상품외에 주문된 상품이 존재하지 않습니다.\n전체취소로 진행해주세요.";
			getJsonExit($result);			
		}

		$intOrderTotalPrice		= 0; //주문금액
		$intOrderTotalQty		= 0; //주문수량
		$intOrderTotalPoint		= 0; //적립포인트
		$intOrderDeliveryTotalPrice = 0; //주문금액(그룹배송상품금액제외)

		for($i=1;$i<=5;$i++){
			$aryDeliveryPrice[$i] = 0;
		}
		
		$aryShopAccList = array(); //정산관련
		$aryOrderBasketList = array(); //할인관련

		if (is_array($aryOrderCartList)){
			$intOrderCount = 0; //주문상품수
			$strOrderTitle = 0; //주문상품타이틀
			$strAllCartNo  = "";
			$intOrderProdNoPointUseCnt = 0; //포인트사용금지상품수

			for($i=0;$i<sizeof($aryOrderCartList);$i++){
				
				if ($aryOrderCartList[$i]['SOC_STATUS'] != "C" && $aryOrderCartList[$i]['SOC_C_STATUS'] != "2"){
					$intOrderPoint		= ($aryOrderCartList[$i]['OC_CUR_POINT'] * $aryOrderCartList[$i]['OC_QTY']);
					$intOrderPrice      = ($aryOrderCartList[$i]['OC_CUR_PRICE'] * $aryOrderCartList[$i]['OC_QTY']); //할인가격 확인
					$intOrderStockPrice = ($aryOrderCartList[$i]['OC_STOCK_CUR_POINT'] * $aryOrderCartList[$i]['OC_QTY']); //입고가격
					
					$intOrderTotalPrice = $intOrderTotalPrice + ($intOrderPrice);
					$intOrderTotalQty	= $intOrderTotalQty + $aryOrderCartList[$i]['OC_QTY'];
					$intOrderTotalPoint = $intOrderTotalPoint + $intOrderPoint;			

					/* 상품 추가 옵션 */
					$intOrderTotalPrice = $intOrderTotalPrice + $aryOrderCartList[$i]['OC_OPT_ADD_CUR_PRICE'];

					/* 입점몰일 경우 입점몰 총 가격 및 입고가격 확인 */
					if ($S_MALL_TYPE != "R"){
						
						if ($aryOrderCartList[$i][P_SHOP_NO] >= 0){
							
							$aryShopAccList[$aryOrderCartList[$i][P_SHOP_NO]]["STOCK_PRICE"]    += $intOrderStockPrice;
							$aryShopAccList[$aryOrderCartList[$i][P_SHOP_NO]]["SALE_PRICE"]		+= $intOrderPrice;
							$aryShopAccList[$aryOrderCartList[$i][P_SHOP_NO]]["SALE_QTY"]	    += $aryOrderCartList[$i]['OC_QTY'];
						}
					}

					/* 포인트 사용불가 상품 */
					if ($aryOrderCartList[$i][P_POINT_NO_USE] == "Y") {
						$intOrderProdNoPointUseCnt++;
					}
				}
			}
		}	
		
		/* 배송비 설정 */
		if ($S_MALL_TYPE != "R"){
			foreach ($aryShopAccList as $key => $value){
				$aryShopAccList[$key]["DELIVERY_PRICE"] = $_POST["shopOrderDelivery_".$key];	
				$intOrderTotalDeliveryPrice	+= $aryShopAccList[$key]["DELIVERY_PRICE"];
			}
		}
		
		/* 과세/비과세 */
		$intOrderTaxTotal = 0;
		if ($S_SITE_TAX == "Y"){
			$intOrderTaxTotal = ($intOrderTotalPrice * 0.1);
		}

		/* 총결제금액확인(총주문금액 - (사용포인트 + 사용쿠폰금액) + 배송비) */
		$intO_USE_POINT			= $orderRow["O_USE_CUR_POINT"];
		$intO_USE_COUPON		= $orderRow["O_USE_CUR_COUPON"];
		
		$intOrderTotalSPrice	= ($intOrderTotalPrice + $intOrderTaxTotal + $intOrderTotalDeliveryPrice) - ($intO_USE_POINT + $intO_USE_COUPON) ;
		
		$aryParam["m_no"]							= $orderRow["M_NO"];
		$aryParam["m_group"]						= $orderRow["M_GROUP"];

		$aryParam["orderTotalPrice"]				= $intOrderTotalPrice;				//주문총상품금액
		$aryParam["orderTotTaxPrice"]				= $intOrderTaxTotal;				//주문시과세금액
		$aryParam["orderTotalDeliveryPrice"]		= $intOrderTotalDeliveryPrice;		//주문시배송총금액

		$aryParam["orderTotalSPrice"]				= $intOrderTotalSPrice;				//주문금액(실제결제금액)
		$aryParam["orderUsePoint"]					= $intO_USE_POINT;					//주문시 사용된 포인트
		$aryParam["orderUseCoupon"]					= $intO_USE_COUPON;					//주문시 사용된 쿠폰 금액
		
		$aryParam["orderMoneyCurStType"]			= "Y";							//주문시 기준통화("Y")/언어통화("N")

		$intMemberGradeDiscountPrice = $intMemberGradeAddPoint = 0;		
		/* 회원등급별 할인혜택 */
		if ($orderRow["M_NO"] > 0){			
			$aryMemberDiscountGradeInfo	 = getOrderMemberGradeDiscount($aryParam);

			$intMemberGradeDiscountPrice	= $aryMemberDiscountGradeInfo["DISCOUNT_PRICE"];
			$intMemberGradeAddPoint			= $aryMemberDiscountGradeInfo["ADD_POINT"];
		}

		/* 총결제금액 - 회원등급별 추가 할인금액 */
		if ($intMemberGradeDiscountPrice > 0) {
			$intOrderTotalSPrice = $intOrderTotalSPrice - getCurToPriceSave($intMemberGradeDiscountPrice);
		}

		/* 복원될 포인트 확인 */
		$strO_SETTLE = $orderRow["O_SETTLE"];
		if ($intOrderTotalSPrice <= 0){
			$strO_SETTLE = "P";
		}
		
		/* 적립금 지급 기준에 따른 포인트 */
		$aryParam["orderMemberGradeAddPoint"]	= $intMemberGradeAddPoint;
		$aryParam["orderSettle"]				= $strO_SETTLE;
		$intOrderTotalPoint						= getOrderMemberGivePoint($aryParam);
		
		/* 취소할 금액 */
		if ($intOrderTotalSPrice > 0){
			$intOrderCancelPrice				= $orderRow["O_TOT_CUR_SPRICE"] - ($intOrderTotalSPrice);	
		} else if ($intOrderTotalSPrice == 0) {
			$intOrderCancelPrice				= $orderRow["O_TOT_CUR_SPRICE"];
		} else if ($intOrderTotalSPrice < 0){
			$intOrderCancelPrice				= $orderRow["O_TOT_CUR_SPRICE"];
			$intOrderRecoveryPoint				= ($intO_USE_POINT + $intO_USE_COUPON) - ($intOrderTotalPrice + $intOrderTotalDeliveryPrice - $intMemberGradeDiscountPrice);
		}

		$result										= "";
		$result[0]['mode']							= "__SUCCESS__";

		$result[0]["o_tot_price"]					= getCurToPriceSave($intOrderTotalPrice,$orderRow['O_USE_LNG']);
		$result[0]["o_tot_delivery_price"]			= getCurToPriceSave($intOrderTotalDeliveryPrice,$orderRow['O_USE_LNG']);
		$result[0]["o_tax_price"]					= getCurToPriceSave($intOrderTaxTotal,$orderRow['O_USE_LNG']);
		$result[0]["o_tot_mem_discount_price"]		= getCurToPriceSave($intMemberGradeDiscountPrice,$orderRow['O_USE_LNG']);
		$result[0]["o_tot_sprice"]					= getCurToPriceSave($intOrderTotalSPrice,$orderRow['O_USE_LNG']);
		$result[0]["o_tot_mem_point"]				= getCurToPriceSave($intMemberGradeAddPoint,$orderRow['O_USE_LNG']);
		$result[0]["o_use_point"]					= getCurToPriceSave($intO_USE_POINT,$orderRow['O_USE_LNG']);
		$result[0]["o_use_coupon"]					= getCurToPriceSave($intO_USE_COUPON,$orderRow['O_USE_LNG']);
		$result[0]["o_tot_point"]					= getCurToPriceSave($intOrderTotalPoint,$orderRow['O_USE_LNG']);
		
		$result[0]["o_cancel_price"]				= getCurToPriceSave($intOrderCancelPrice,$orderRow['O_USE_LNG']);
		$result[0]["o_recovery_point"]				= getCurToPriceSave($intOrderRecoveryPoint,$orderRow['O_USE_LNG']);

		getJsonExit($result);	
		
	break;
	endswitch;


	$result				= "";
	$result['mode']		= "__ERROR__";
	$result['text']		= "JSON MODE 값이 없습니다.";
	getJsonExit($result);	

?>