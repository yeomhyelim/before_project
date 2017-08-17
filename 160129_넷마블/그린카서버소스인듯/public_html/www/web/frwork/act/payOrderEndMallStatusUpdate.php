<?
	## 구매완료시 입점사 상태 update
	## STEP 2-1.
	## 입점몰 주문 정보
	$param								= "";
	$param['o_no']						= $orderRow['O_NO'];
	$param['searchDeliveryStatus']		= "D";
	$result								= $shopOrderMgr->getShopOrderListEx($db, "OP_LIST", $param);
	
	while($shopOrderRow = mysql_fetch_array($result)){
		
		## STEP 2-2.
		## 입점몰 주문 정보
		$param				= "";
		$param['o_no']		= $orderRow['O_NO'];
		$param['p_shop_no']	= $shopOrderRow['SH_NO'];
		$orderCartResult	= $shopOrderMgr->getOrderCartListEx($db, "OP_LIST", $param);

		while($orderCartRow = mysql_fetch_array($orderCartResult)):

			$param							= "";
			$param['oc_no']					= $orderCartRow['OC_NO'];
			$param["oc_status1"]			= "E";
			$param["oc_status2"]			= "";
			$param["oc_req_dt"]				= "";
			$param["oc_reg_dt"]				= "";
			$param["oc_reg_no"]				= 1;
			
			$re = $shopOrderMgr->getOrderMallCerityUpdate($db,$param);
		endwhile;

		## STEP 2-3.
		## 해당 주문 결제정보 변경
		$param							= "";
		$param['so_no']					= $shopOrderRow['SO_NO'];
		$param['so_order_status']		= "E";
		$re								= $shopMgr->getOrderStatusUpdateEx($db, $param);
				
		/* 구매건수 , 구매금액 업데이트 */
		if ($orderRow['M_NO']){
			$memberMgr->setM_NO($orderRow['M_NO']);					// 회원번호
			$memberMgr->getMemberBuyUpdate($db);
		}
		/* 구매건수 , 구매금액 업데이트 */
	}
?>