<?
	if ($intOrderCartNo > 0){
		
		## 이미 변경된 주문상태가 다시 update 되는걸 막기 위해 처리
		$param					= "";
		$param['OC_NO']			= $intOrderCartNo;
		$param['OCS_STATUS']	= $strOrderCartStatus;
		$param['OCS_REG_NO']	= $a_admin_no;
		$orderCartStatusRow		= $shopOrderMgr->getOrderCartStatusList($db,"OP_LIST",$param);
		
		switch($strOrderCartStatus){
		
			case "B":
				if (!$orderCartStatusRow){
					$shopOrderMgr->getOrderCartStatusInsertUpdate($db,$param);
				}
			case "D";
				if (!$orderCartStatusRow){
					$shopOrderMgr->getOrderCartStatusInsertUpdate($db,$param);
				}
			break;

			case "I":
			
				if (!$orderCartStatusRow || ($orderCartStatusRow && $orderCartStatusRow['OCS_MAIL'] != "Y")){
					
					/* 해당 주문 상품에 해당하는 입점사번호 */
					$intSH_NO	= $shopOrderMgr->getOrderShopNo($db,$param);
										
					/* 해당 주문 상품에 해당하는 배송사/송장번호 */
					$param				= "";
					$param["O_USE_LNG"] = $orderRow["O_USE_LNG"];
					$param["OC_NO"]		= $intOrderCartNo;
					$param["O_NO"]		= $intO_NO;
					$orderCartRow		= $shopOrderMgr->getOrderCartList($db,"OP_SELECT",$param);
					
					/* 주문정보 */
					if ($orderCartRow['SOC_D_COM'] && $orderCartRow['SOC_D_NUM']){
						
						$orderMgr->setO_NO($intO_NO);
						$orderRow = $orderMgr->getOrderView($db);
						
						$param				= "";
						$param["O_USE_LNG"] = $orderRow["O_USE_LNG"];
						$param["OC_NO"]		= $intOrderCartNo;
						$param["O_NO"]		= $intO_NO;
						
						$param["SH_NO"]		= $intSH_NO;
						$cartResult			= $shopOrderMgr->getOrderCartList($db,"OP_RESULT",$param);
						$intCartTotal		= $cartResult["cnt"];

						/** 메일 전송 - 고객 주문 배송 메일 **/
						$strMailSendMode = "adm";
						$strMailMode = "orderDeliverySend";
						include WEB_FRWORK_ACT."orderMailCartForm.inc.php";

						
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
						/** 메일 전송 - 고객 주문 배송 메일 **/
					
						$param['OCS_MAIL'] == "Y";
						$shopOrderMgr->getOrderCartStatusInsertUpdate($db,$param);
					}

				}
			
			break;
		}
		
	}
?>