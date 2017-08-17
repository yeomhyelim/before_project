<?
	## 구매완료시 주문 상품 상태 update
	## STEP 2-1.
	## 주문 상품 정보

	$param								= "";
	$param['O_NO']						= $orderRow['O_NO'];
	$param['OC_DELIVERY_STATUS']		= "D";
	$result								= $shopOrderMgr->getOrderCartListVer2($db,"OP_LIST",$param);
	
	while($orderCartRow = mysql_fetch_array($result)){

		## 구매상태가 취소/교환/환불/구매완료/반품이 아닐 경우 
		if (!in_array(substr($orderCartRow['OC_ORDER_STATUS'],0,1),array("C","S","R","T","E"))){
			## STEP 2-2.
			## 주문 상품 정보
			$param							= "";
			$param['OC_NO']					= $orderCartRow['OC_NO'];
			$param["OC_ORDER_STATUS"]		= "E";
			$param["OC_MOD_NO"]				= 1;
			$param["OC_E_REG_DT"]			= "Y";
			$re = $shopOrderMgr->getOrderCartStatusUpdate($db,$param);

			## STEP 2-3.
			## 해당 주문 결제정보 변경
			$param							= "";
			$param['O_NO']					= $orderRow['O_NO'];
			$param['OC_NO']					= $orderCartRow['OC_NO'];
			$param["OC_REG_NO"]				= 1;
			$shopOrderMgr->getOrderStatusAllUpdateVer2($db,$param);
			
		}
	}

	/* 구매건수 , 구매금액 업데이트 */
	if ($orderRow['M_NO']){
		$memberMgr->setM_NO($orderRow['M_NO']);					// 회원번호
		$memberMgr->getMemberBuyUpdate($db);
	}
	/* 구매건수 , 구매금액 업데이트 */

?>