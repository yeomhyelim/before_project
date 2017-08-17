<?
	require_once MALL_CONF_LIB."OrderAdmMgr.php";
	require_once MALL_CONF_LIB."ProductAdmMgr.php";
	require_once MALL_CONF_LIB."MemberAdmMgr.php";
	require_once MALL_CONF_LIB."SiteMgr.php";
	require_once MALL_CONF_LIB."CouponMgr.php";
	require_once MALL_CONF_LIB."ShopOrderNewMgr.php";
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
	case "orderCartStatusSave":
		/** 주문상태변경 **/

		include "../conf/site_conf_inc.php";								// 환경설정 파일 include
		require MALL_HOME."/web/frwork/act/pp_ax_hub_lib.php";              // library [수정불가]
		
		## STEP 1.
		## 주문 장바구니 번호(ORDER_CART OC_NO)
		if(!$_POST['chkNo']):
			$result				= "";
			$result['mode']		= "__ERROR__";
			$result['text']		= "상품정보가 없습니다."; //"상품정보가 없습니다.";
			getJsonExit($result);
		endif;

		## STEP 2.
		## 구매상태 업데이트
		$aryOrderCartNoList = $_POST["chkNo"];
		$aryOrderNoList		= "";
		if (is_array($aryOrderCartNoList)){
			foreach($aryOrderCartNoList as $key => $val){
				$intOC_NO						= $val;
			
				$param							= "";
				$param['OC_NO']					= $intOC_NO;
				$param['OC_ORDER_STATUS']		= $_POST['orderStatus_'.$intOC_NO];
				$param["OC_MOD_NO"]				= $a_admin_no;

				if ($param['OC_ORDER_STATUS'])
				{			
					## 구매완료
					if (in_array($param['OC_ORDER_STATUS'],array("E"))){
										
						$re = $shopOrderMgr->getOrderCartStatusUpdate($db,$param);					
					} else {
						$re = $shopOrderMgr->getOrderCartReturnUpdate($db,$param);
					}
								
					$intO_NO				= $shopOrderMgr->getOrderNo($db,$param);
					$param['OC_REG_NO']		= $a_admin_no;
					$param['O_NO']			= $intO_NO;
					$aryOrderNoList[$key]	= $intO_NO;
					
					## 주문별 상태 UPDATE(마스터/입점사)
					if ($intO_NO > 0){
						
						$orderMgr->setO_NO($intO_NO);
						$orderRow			= $orderMgr->getOrderView($db);
						$strOrderPrevStatus	= $orderRow["O_STATUS"];

						$shopOrderMgr->getOrderStatusAllUpdate($db,$param);	
						
						/* 마스터 주문상태가 변경되었을때 포인트/쿠폰 작업을 진행한다*/
						include MALL_WEB_PATH."shopAdmin/orderM/list/orderMallStatusUpdate.php";
					}
				}

				/* HISTORY INSERT */
				$strOrderStatusMemo			= $_POST['orderStatusMemo'];
				if (!$strOrderStatusMemo){
					$strOrderStatusMemo		= "구매상태변경";
				}
				$strOrderStatusText			= $intO_NO."/".$intOC_NO."/".$_POST['orderStatus_'.$intOC_NO];

				$param['m_no']				= $a_admin_no;
				$param['h_tab']				= TBL_ORDER_CART;
				$param['h_key']				= $intOC_NO;
				$param['h_code']			= "002"; //구매상태
				$param['h_memo']			= $strOrderStatusMemo;
				$param['h_text']			= $strOrderStatusText;
				$param['h_reg_no']			= $a_admin_no;
				$param['h_adm_no']			= $a_admin_no;
				$shopOrderMgr->getOrderStatusHistoryUpdate($db,$param);
				/* HISTORY INSERT */
			}
		}
		
		if($re != 1):
			$result					= "";
			$result[0]['mode']		= "__ERROR__";
			$result[0]['text']		= $LNG_TRANS_CHAR["OS00099"]; //"구매상태를 업데이트 할수 없습니다.";
			getJsonExit($result);
		endif;
		
		$result				= "";
		$result['mode']		= "__SUCCESS__";
		$result['text']		= ".";
		getJsonExit($result);	
	break;
	
	case "orderCartDeliverySave":

		## STEP 1.
		## 배송정보변경방법 확인
		if (!$_POST["deliveryMth"])
		{
			$result				= "";
			$result['mode']		= "__ERROR__";
			$result['text']		= "배송정보변경방법을 선택하지 않으셨습니다."; //"입점사_주문관리번호가 없습니다.";
			getJsonExit($result);
		}
		
		## STEP 2.
		## 전체 배송정보 업데이트
		if ($_POST["deliveryMth"] == "all")
		{
			$intO_NO			= $_POST["oNo"];
			$intO_SHOP_NO		= $_POST["shopNo"];

			$strDeliveryStatus	= $_POST['deliveryStatus'];
			$strDeliveryCom		= $_POST['deliveryCom'];
			$strDeliveryNum		= $_POST['deliveryNum'];
			
			$param				= "";
			$param['O_NO']		= $intO_NO;
			$param['O_SHOP_NO'] = $intO_SHOP_NO;
			$aryOrderCartNoList = $shopOrderMgr->getOrderCartNoList($db,$param);
			
			if (is_array($aryOrderCartNoList)){
				$strDeliverySendCartNo	= "";

				for($i=0;$i<sizeof($aryOrderCartNoList);$i++)
				{
					$param							= "";
					$param["OC_NO"]					= $aryOrderCartNoList[$i]["OC_NO"];
					$param["O_SHOP_NO"]				= -1;
					$param["O_USE_LNG"]				= $S_SITE_LNG;
					$orderCartRow					= $shopOrderMgr->getOrderCartList($db,"OP_SELECT",$param);
					if (!$orderCartRow) continue;
					
					if (($strDeliveryStatus != $orderCartRow['OC_DELIVERY_STATUS']) || ($strDeliveryCom != $orderCartRow['OC_DELIVERY_COM']) || ($strDeliveryNum != $orderCartRow['OC_DELIVERY_NUM']))
					{
						## 이전 단계의 배송상태로 변경 불가능 체크
						if ($strDeliveryStatus == "B")
						{
							if (in_array($orderCartRow['OC_DELIVERY_STATUS'],array("I","D"))){
								$result				= "";
								$result['mode']		= "__ERROR__";
								$result['text']		= "배송준비중 상태로 변경하실 수 없습니다."; //"배송준비중 상태로 변경하실 수 없습니다.";
								getJsonExit($result);
							}
						}
						## 배송중으로 변경시 체크
						if ($strDeliveryStatus == "I"){
							if (in_array($orderCartRow['OC_DELIVERY_STATUS'],array("D"))){
								$result				= "";
								$result['mode']		= "__ERROR__";
								$result['text']		= "배송중 상태로 변경하실 수 없습니다."; //"배송중 상태로 변경하실 수 없습니다.";
								getJsonExit($result);
							}

							if (!$strDeliveryCom || !$strDeliveryNum){
								$result				= "";
								$result['mode']		= "__ERROR__";
								$result['text']		= "배송회사/송장번호를 입력하셔야 배송중으로 변경하실 수 있습니다."; //"배송회사/송장번호를 입력하셔야 배송중으로 변경할 수 있습니다.";
								getJsonExit($result);
							}
						}

						## 배송완료로 변경시 체크
						if ($strDeliveryStatus == "D")
						{
							if (!in_array($orderCartRow['OC_DELIVERY_STATUS'],array("I")))
							{
								$result				= "";
								$result['mode']		= "__ERROR__";
								$result['text']		= "이전배송상태가 배송중 상태가 아닙니다."; //"이전배송상태가 배송중 상태가 아닙니다.";
								getJsonExit($result);
							}
						
							if (!$orderCartRow['OC_DELIVERY_COM'] || !$orderCartRow['OC_DELIVERY_NUM']){
								$result				= "";
								$result['mode']		= "__ERROR__";
								$result['text']		= "배송회사/송장번호 데이터가 존재하지 않습니다."; //"배송회사/송장번호 데이터가 존재하지 않습니다.";
								getJsonExit($result);
							}
						}
						
						## update 
						$param							= "";
						$param["O_NO"]					= $orderCartRow[$i]["O_NO"];
						$param["OC_NO"]					= $aryOrderCartNoList[$i]["OC_NO"];
						$param["OC_DELIVERY_STATUS"]	= $strDeliveryStatus;
						$param["OC_DELIVERY_COM"]		= $strDeliveryCom;
						$param["OC_DELIVERY_NUM"]		= $strDeliveryNum;
						$param["OC_MOD_NO"]				= $a_admin_no;
						$param["OC_REG_NO"]				= $a_admin_no;

						if ($strDeliveryStatus == "I") {
							$param["OC_DELIVERY_ST_DT"]	= $S_NOW_TIME_FORMAT2;
						}

						if ($strDeliveryStatus == "D") {
							$param["OC_DELIVERY_END_DT"]= $S_NOW_TIME_FORMAT2;
						}

						$shopOrderMgr->getOrderCartStatusUpdate($db,$param);
						
						## 주문별 상태 UPDATE(마스터/입점사)
						if ($orderCartRow["O_NO"] > 0){
							
							/* 이메일 발송 내역 */
							if ($strDeliveryStatus == "I") 
							{
								/* 주문 내역 */
								if (is_array($arrOrderSendMail)) array_push($arrOrderSendMail, $intO_NO);
								else $arrOrderSendMail = array($intO_NO);
								
								/* 주문 장바구니 내역 */
								if (is_array($arrOrderCartSendMail[$intO_NO])) {
									if (!in_array($aryOrderCartNoList[$i]["OC_NO"],$arrOrderCartSendMail[$intO_NO])) array_push($arrOrderCartSendMail[$intO_NO], $aryOrderCartNoList[$i]["OC_NO"]);
								} else $arrOrderCartSendMail[$intO_NO] = array($aryOrderCartNoList[$i]["OC_NO"]);
							}
							/* 이메일 발송 내역 */

							$intO_NO = $orderCartRow["O_NO"];
							$orderMgr->setO_NO($intO_NO);
							$orderRow			= $orderMgr->getOrderView($db);
							$strOrderPrevStatus	= $orderRow["O_STATUS"];

							$shopOrderMgr->getOrderStatusAllUpdate($db,$param);	
							
							/* 마스터 주문상태가 변경되었을때 포인트/쿠폰 작업을 진행한다*/
							include MALL_WEB_PATH."shopAdmin/orderM/list/orderMallStatusUpdate.php";
						}
					}
				}

				if ($strDeliverySendCartNo)
				{
					$strDeliverySendCartNo							= SUBSTR($strDeliverySendCartNo,0,STRLEN($strDeliverySendCartNo)-1);
					$aryOrderCartDeliverySendList[0]['O_NO']		= $intO_NO;
					$aryOrderCartDeliverySendList[0]['SH_NO']		= $intO_SHOP_NO;
					$aryOrderCartDeliverySendList[0]['SEND_LIST']	= $strDeliverySendCartNo;
				}
			}
		} 
		
		## 개별 배송정보 업데이트
		if ($_POST["deliveryMth"] == "each")
		{
			if(!$_POST['chkNo']):
				$result				= "";
				$result['mode']		= "__ERROR__";
				$result['text']		= "주문 상품정보가 없습니다."; //"주문 상품정보가 없습니다.";
				getJsonExit($result);
			endif;

			$aryOrderCartNoList					 = $_POST["chkNo"];
			$aryOrderCartDeliverySendList		 = "";
			if (is_array($aryOrderCartNoList))
			{
				foreach($aryOrderCartNoList as $key => $val){
					$intOC_NO			= $val;

					$strDeliveryStatus	= $_POST['deliveryStatus_'.$intOC_NO];
					$strDeliveryCom		= $_POST['deliveryCom_'.$intOC_NO];
					$strDeliveryNum		= $_POST['deliveryNum_'.$intOC_NO];
					
					$param				= "";
					$param["OC_NO"]		= $intOC_NO;
					$param["O_SHOP_NO"]	= -1;
					$param["O_USE_LNG"] = $S_SITE_LNG;
					$orderCartRow		= $shopOrderMgr->getOrderCartList($db,"OP_SELECT",$param);
					if (!$orderCartRow) continue;
					
					if (($strDeliveryStatus != $orderCartRow['OC_DELIVERY_STATUS']) || ($strDeliveryCom != $orderCartRow['OC_DELIVERY_COM']) || ($strDeliveryNum != $orderCartRow['OC_DELIVERY_NUM']))
					{
						## 이전 단계의 배송상태로 변경 불가능 체크
						if ($strDeliveryStatus == "B")
						{
							if (in_array($orderCartRow['OC_DELIVERY_STATUS'],array("I","D"))){
								$result				= "";
								$result['mode']		= "__ERROR__";
								$result['text']		= "배송준비중 상태로 변경하실 수 없습니다."; //"배송준비중 상태로 변경하실 수 없습니다.";
								getJsonExit($result);
							}
							
							/* 배송준비중일때 배송회사/송장번호를 UPDATE 불가능 */
							$strDeliveryCom			= "";
							$strDeliveryNum			= "";
						}

						## 배송중으로 변경시 체크
						if ($strDeliveryStatus == "I"){
							if (in_array($orderCartRow['OC_DELIVERY_STATUS'],array("D"))){
								$result				= "";
								$result['mode']		= "__ERROR__";
								$result['text']		= "배송중 상태로 변경하실 수 없습니다."; //"배송중 상태로 변경하실 수 없습니다.";
								getJsonExit($result);
							}

							if (!$strDeliveryCom || !$strDeliveryNum){
								$result				= "";
								$result['mode']		= "__ERROR__";
								$result['text']		= "배송회사/송장번호를 입력하셔야 배송중으로 변경하실 수 있습니다."; //"배송회사/송장번호를 입력하셔야 배송중으로 변경할 수 있습니다.";
								getJsonExit($result);
							}
						}

						## 배송완료로 변경시 체크
						if ($strDeliveryStatus == "D")
						{
							if (!in_array($orderCartRow['OC_DELIVERY_STATUS'],array("I")))
							{
								$result				= "";
								$result['mode']		= "__ERROR__";
								$result['text']		= "이전배송상태가 배송중 상태가 아닙니다."; //"이전배송상태가 배송중 상태가 아닙니다.";
								getJsonExit($result);
							}
						
							if (!$orderCartRow['OC_DELIVERY_COM'] || !$orderCartRow['OC_DELIVERY_NUM']){
								$result				= "";
								$result['mode']		= "__ERROR__";
								$result['text']		= "배송회사/송장번호 데이터가 존재하지 않습니다."; //"배송회사/송장번호 데이터가 존재하지 않습니다.";
								getJsonExit($result);
							}
						}
						
						## update
						## 1. 저장된 배송상태와 변경할 배송상태가 틀릴 경우
						## 2. 저장된 배송정보와 변경할 배송정보가 틀릴 경우
					
						if ($strDeliveryCom && $strDeliveryNum)
						{
							$param							= "";
							$param["O_NO"]					= $orderCartRow["O_NO"];
							$param["OC_NO"]					= $intOC_NO;
							$param["OC_DELIVERY_STATUS"]	= $strDeliveryStatus;
							$param["OC_DELIVERY_COM"]		= $strDeliveryCom;
							$param["OC_DELIVERY_NUM"]		= $strDeliveryNum;
							
							$param["OC_MOD_NO"]				= $a_admin_no;
							$param["OC_REG_NO"]				= $a_admin_no;

							if ($strDeliveryStatus == "I") {
								$param["OC_DELIVERY_ST_DT"]	= $S_NOW_TIME_FORMAT2;
								$strDeliverySendCartNo		= $intOC_NO;
							}

							if ($strDeliveryStatus == "D") {
								$param["OC_DELIVERY_END_DT"]= $S_NOW_TIME_FORMAT2;
							}

							$shopOrderMgr->getOrderCartStatusUpdate($db,$param);
							

						
							## 주문별 상태 UPDATE(마스터/입점사)
							if ($orderCartRow["O_NO"] > 0){
								
								/* 이메일 발송 내역 */
								if ($strDeliveryStatus == "I") 
								{
									/* 주문 내역 */
									if (is_array($arrOrderSendMail)) array_push($arrOrderSendMail, $intO_NO);
									else $arrOrderSendMail = array($intO_NO);
									
									/* 주문 장바구니 내역 */
									if (is_array($arrOrderCartSendMail[$intO_NO])) {
										if (!in_array($intOC_NO,$arrOrderCartSendMail[$intO_NO])) array_push($arrOrderCartSendMail[$intO_NO], $intOC_NO);
									} else $arrOrderCartSendMail[$intO_NO] = array($intOC_NO);
								}
								/* 이메일 발송 내역 */								
								
								$intO_NO = $orderCartRow["O_NO"];
								$orderMgr->setO_NO($intO_NO);
								$orderRow			= $orderMgr->getOrderView($db);
								$strOrderPrevStatus	= $orderRow["O_STATUS"];
					
								$shopOrderMgr->getOrderStatusAllUpdate($db,$param);	
								
								/* 마스터 주문상태가 변경되었을때 포인트/쿠폰 작업을 진행한다*/
								include MALL_WEB_PATH."shopAdmin/orderM/list/orderMallStatusUpdate.php";
							}

						}
					}
				}
			}				
		}
		
		## STEP 3.
		## 배송중으로 상태 변경 및 이메일 전송
		if (is_array($arrOrderSendMail)){
			$arrOrderSendMail = array_unique($arrOrderSendMail);
			foreach($arrOrderSendMail as $key => $val){
				
				$intO_NO			= $val;
				$strOrderCartNo		= "";
				foreach($arrOrderCartSendMail[$intO_NO] as $cartKey => $cartVal){
					$strOrderCartNo .= $cartVal.",";
				}
				if ($strOrderCartNo) $strOrderCartNo = substr($strOrderCartNo,0,strlen($strOrderCartNo)-1);
				
				if ($intO_NO > 0 && $strOrderCartNo)
				{
					
					/** 메일 전송 - 고객 주문 배송 메일 **/
					$orderMgr->setO_NO($intO_NO);
					$orderRow = $orderMgr->getOrderView($db);
					
					$param				= "";
					$param["O_NO"]		= $intO_NO;
					$param["O_USE_LNG"] = $orderRow["O_USE_LNG"];
					$param["OC_NO"]		= "";
					$param["IN_OC_NO"]	= $strOrderCartNo;				
					$param["O_SHOP_NO"]	= -1;
					$cartResult			= $shopOrderMgr->getOrderCartList($db,"OP_RESULT",$param);
					$intCartTotal		= $cartResult["cnt"];

					if ($S_MALL_TYPE != "R"){
						$param['O_NO']		= $intO_NO;
						$aryCartShopInfo	= $shopOrderMgr->getOrderCartShopInfo($db,$param);
					}

					/** 메일 전송 - 고객 주문 배송 메일 **/
					$strMailSendMode	= "adm";
					$strMailMode		= "orderDeliverySend";
					include WEB_FRWORK_ACT."orderCartMailForm.v2.0.inc.php";
					
					$aryTAG_LIST['{{__받는사람이름__}}']	= $orderRow['O_J_NAME'];
					$aryTAG_LIST['{{__받는사람메일__}}']	= $orderRow['O_J_MAIL'];
					$aryTAG_LIST['{{__회원명__}}']			= $orderRow['O_J_NAME'];
					$aryTAG_LIST['{{__주문번호__}}']		= $orderRow['O_KEY'];
					$aryTAG_LIST['{{__주문상품내역__}}']	= $strOrderCartHtml;
					$aryTAG_LIST['{{__주문배송정보__}}']	= $strOrderInfoHtml;
					$aryTAG_LIST['{{__배송사__}}']			= "";
					$aryTAG_LIST['{{__운송장번호__}}']		= "";
					$aryTAG_LIST['{{__주문일자__}}']		= SUBSTR($orderRow['O_REG_DT'],0,10);
					
					goSendMail("013");
					/** 메일 전송 - 고객 주문 배송 메일 **/
				}
			}
		}

		$result				= "";
		$result['mode']		= "__SUCCESS__";
		$result['text']		= ".";
		getJsonExit($result);	

	break;

	case "orderInfoDisplay":
		/** 주문상품정보 모두 펼치기 및 닫기 */

		if ($_REQUEST["state"] == "block"){
			setCookie("COOKIE_ADM_ORDER_LIST_DISPLAY","block",time()+(86400 * 30),"/shopAdmin");
		} else {
			setCookie("COOKIE_ADM_ORDER_LIST_DISPLAY","none",time()+(86400 * 30),"/shopAdmin");
		}

		$result				= "";
		$result['mode']		= "__SUCCESS__";
		$result['text']		= ".";
		getJsonExit($result);	

	break;

	case "orderCartNoSelect":
		$intO_NO			= $_REQUEST["oNo"];
		$intO_SHOP_NO		= $_REQUEST["shopNo"];

		$param				= "";
		$param['O_NO']		= $intO_NO;
		$param['O_SHOP_NO'] = $intO_SHOP_NO;
		$aryOrderCartNoList = $shopOrderMgr->getOrderCartNoList($db,$param);
		
		getJsonExit($aryOrderCartNoList);	

	break;
	case "partCancelCal":
		
		$intO_NO		= $_POST["oNo"];
		
		$param["O_NO"]	= $intO_NO;
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

		$param["O_USE_LNG"] = $orderRow["O_USE_LNG"];
		$param["NOT_OC_NO"] = $strCancelOrderCartList;
		$param["O_SHOP_NO"]	= -1;
		$aryOrderCartList   = $shopOrderMgr->getOrderCartList($db,"OP_ARYTOTAL",$param);

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
				
				if ($aryOrderCartList[$i]['OC_ORDER_STATUS'] != "C2")
				{
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
						
						if ($aryOrderCartList[$i][P_SHOP_NO] >= 0)
						{
							
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
		if ($S_MALL_TYPE != "R")
		{
			foreach ($aryShopAccList as $key => $value){
				$aryShopAccList[$key]["DELIVERY_PRICE"] = $_POST["cartOrderDelivery_".$key];	
				$intOrderTotalDeliveryPrice	+= $aryShopAccList[$key]["DELIVERY_PRICE"];
			}
		}
		
		/* 과세/비과세 */
		$intOrderTaxTotal = 0;
		if ($S_SITE_TAX == "Y"){
			$intOrderTaxTotal = ($intOrderTotalPrice * 0.1);
		}

		/* PG사 결제시 수수료 부여 */
		$intOrderPgCommissionTotal = 0;
		if ($S_PG_COMMISSION == "Y"){
			if ($S_PG_CARD_COMMISSION > 0){
				/* 엑심베이 결제/한국PG사의 카드 결제 */
				if ($orderRow['O_PG'] == "X" || $orderRow['O_SETTLE'] == "C")
				{
					if ($orderRow['O_USE_LNG'] == "KR") $intOrderPgCommissionTotal = getRoundWonUp(($intOrderTotalPrice * $S_PG_CARD_COMMISSION/100));
					else $intOrderPgCommissionTotal = getRoundUp(($intOrderTotalPrice * $S_PG_CARD_COMMISSION/100),2);
				}
			}
		}

		/* 총결제금액확인(총주문금액 - (사용포인트 + 사용쿠폰금액) + 배송비) */
		$intO_USE_POINT			= $orderRow["O_USE_CUR_POINT"];
		$intO_USE_COUPON		= $orderRow["O_USE_CUR_COUPON"];
		
		$intOrderTotalSPrice	= ($intOrderTotalPrice + $intOrderTaxTotal + $intOrderTotalDeliveryPrice + $intOrderPgCommissionTotal) - ($intO_USE_POINT + $intO_USE_COUPON) ;
		
		$aryParam["m_no"]							= $orderRow["M_NO"];
		$aryParam["m_group"]						= $orderRow["M_GROUP"];

		$aryParam["orderTotalPrice"]				= $intOrderTotalPrice;				//주문총상품금액
		$aryParam["orderTotTaxPrice"]				= $intOrderTaxTotal;				//주문시과세금액
		$aryParam["orderTotalDeliveryPrice"]		= $intOrderTotalDeliveryPrice;		//주문시배송총금액
		$aryParam["orderTotPgCommissionPrice"]		= $intOrderPgCommissionTotal;		//주문시총수수료

		$aryParam["orderTotalSPrice"]				= $intOrderTotalSPrice;				//주문금액(실제결제금액)
		$aryParam["orderUsePoint"]					= $intO_USE_POINT;					//주문시 사용된 포인트
		$aryParam["orderUseCoupon"]					= $intO_USE_COUPON;					//주문시 사용된 쿠폰 금액
		
		$aryParam["orderMoneyCurStType"]			= "Y";								//주문시 기준통화("Y")/언어통화("N")

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
		$result[0]["o_tot_pg_commission_price"]		= getCurToPriceSave($intOrderPgCommissionTotal,$orderRow['O_USE_LNG']);
		
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