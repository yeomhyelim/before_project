<?
	if (!$orderRow['O_CEL_NO']){
		/* 취소승인번호 */
		$strOrderSettleCelNo = "C".date("Ymd").STRTOUPPER(getCode(5));
		$orderMgr->setO_CEL_NO($strOrderSettleCelNo);
		$orderMgr->setO_STATUS("C");
		$intDupCelNoCnt = $orderMgr->getOrderDupCancelNo($db);

		if ($intDupCelNoCnt > 0){
			$strFlag = false;

			while($strFlag == false){

				$strOrderSettleCelNo = "C".date("Ymd").STRTOUPPER(getCode(5));
				$orderMgr->setO_CEL_NO($strOrderSettleCelNo);
				$intDupCelNoCnt = $orderMgr->getOrderDupCancelNo($db);
				
				if($intDupCelNoCnt=="0"){
					$strFlag = true;
					break;
				}
			}			
		}

		$orderMgr->setO_CEL_NO($strOrderSettleCelNo);
		$orderMgr->setO_CEL_MEMO($_POST['mod_desc']);
		$orderMgr->setO_RETURN_BANK($_POST[ "returnBank"      ]);
		$orderMgr->setO_RETURN_ACC($_POST[ "returnAcc" ]);
		$orderMgr->setO_RETURN_NAME($_POST[ "returnName"      ]);
		$orderMgr->setO_CEL_STATUS("Y");
		$result = $orderMgr->getOrderCancelUpdate($db);

		$orderMgr->setOS_APPR_NO($orderRow[O_APPR_NO]);
		$orderMgr->setOS_CEL_NO($strOrderSettleCelNo);
		$orderMgr->getOrderSettleUpdate($db);
	} else {
		$orderMgr->setO_CEL_STATUS("Y");
		$orderMgr->getOrderCancelStatusUpdate($db);
	}

	/* 수량 조절 */
	$orderMgr->setOC_LIST_ARY("Y");
	$aryOrderCartList = $orderMgr->getOrderCartList($db);
			
	if (is_array($aryOrderCartList)){
		for($j=0;$j<sizeof($aryOrderCartList);$j++){
			$strProdCode  = $aryOrderCartList[$j][P_CODE];
			$intOC_OPT_NO = $aryOrderCartList[$j][OC_OPT_NO];
			$intOC_QTY    = $aryOrderCartList[$j][OC_QTY];
			
			if ($aryOrderCartList[$j][P_STOCK_LIMIT] != "Y"){
				/* 옵션별 수량 조절 */
				if ($intOC_OPT_NO > 0){
					$productMgr->setPOA_STOCK_QTY($intOC_QTY);
					$productMgr->setPOA_NO($intOC_OPT_NO);
					$productMgr->getProdOptQtyUpdate($db);
				}

				/* 상품전체 수량 조절 */
				if ($strProdCode)
				{
					$productMgr->setP_QTY($intOC_QTY);
					$productMgr->setP_CODE($strProdCode);
					$productMgr->getProdQtyUpdate($db);
				}
			}
		}
	}

	/* 포인트 적립 취소 */
	if ($orderRow[O_TOT_POINT] > 0 && $orderRow[M_NO] > 0 && $orderRow[O_ADD_POINT] == "Y"){
		$memberMgr->setM_NO($orderRow[M_NO]);
		$memberMgr->setM_POINT(-$orderRow[O_TOT_CUR_POINT]);
		$memberMgr->getMemberPointUpdate($db);

		/* 포인트 히스토리 추가해야 함*/
		/* 포인트 관리 데이터 INSERT */
		$orderMgr->setM_NO($orderRow[M_NO]);
		$orderMgr->setB_NO(0);
		$orderMgr->setPT_TYPE('009');
		$orderMgr->setPT_POINT(-$orderRow[O_TOT_POINT]);
		$orderMgr->setPT_CUR_POINT($memberMgr->getM_POINT());
		$orderMgr->setPT_MEMO($LNG_TRANS_CHAR["OW00061"]."[".$orderRow[O_KEY]."]");
		$orderMgr->setPT_START_DT(date("Y-m-d"));
		$orderMgr->setPT_END_DT(date("Y-m-d"));
		$orderMgr->setPT_REG_IP($S_REOMTE_ADDR);
		$orderMgr->setPT_ETC('');
		$orderMgr->setPT_REG_NO(1);
		$orderMgr->getOrderPointInsert($db);
	}

	/* 첫상품구매 포인트 적립 취소 */
	if ($orderRow[O_FIRST_YN] == "Y"){
		$orderMgr->setM_NO($orderRow[M_NO]);
		$intOrderFirstPoint = $orderMgr->getOrderFirstPoint($db);
		if ($intOrderFirstPoint > 0){
			$memberMgr->setM_NO($orderRow[M_NO]);
			$memberMgr->setM_POINT(-$intOrderFirstPoint);
			$memberMgr->getMemberPointUpdate($db);

			/* 포인트 히스토리 추가해야 함*/
			/* 포인트 관리 데이터 INSERT */
				$orderMgr->setM_NO($orderRow[M_NO]);
				$orderMgr->setB_NO(0);
				$orderMgr->setPT_TYPE('005');
				$orderMgr->setPT_POINT($memberMgr->getM_POINT());
				$orderMgr->setPT_MEMO($LNG_TRANS_CHAR["OW00105"]."[".$orderRow[O_KEY]."]"); //구매포인트적립취소
				$orderMgr->setPT_START_DT(date("Y-m-d"));
				$orderMgr->setPT_END_DT(date("Y-m-d"));
				$orderMgr->setPT_REG_IP($S_REOMTE_ADDR);
				$orderMgr->setPT_ETC('');
				$orderMgr->setPT_REG_NO(1);
				$orderMgr->getOrderPointInsert($db);
			/* 포인트 관리 데이터 INSERT */
		}
	}


	/* 사용포인트 적립 복원*/
	if ($orderRow[O_USE_POINT] > 0){
		$memberMgr->setM_NO($orderRow[M_NO]);
		$memberMgr->setM_POINT($orderRow[O_USE_CUR_POINT]);
		$memberMgr->getMemberPointUpdate($db);

		/* 포인트 관리 데이터 INSERT */
		$orderMgr->setM_NO($orderRow[M_NO]);
		$orderMgr->setB_NO(0);
		$orderMgr->setPT_TYPE('003');
		$orderMgr->setPT_POINT($orderRow[O_USE_POINT]);
		$orderMgr->setPT_CUR_POINT($memberMgr->getM_POINT());
		$orderMgr->setPT_MEMO($LNG_TRANS_CHAR["OW00060"]."[".$orderRow[O_KEY]."]");
		$orderMgr->setPT_START_DT(date("Y-m-d"));
		$orderMgr->setPT_END_DT(date("Y-m-d",mktime(0,0,0,date("m"),date("d"),date("Y")+$siteRow[S_POINT_USE_YEAR])));
		$orderMgr->setPT_REG_IP($S_REOMTE_ADDR);
		$orderMgr->setPT_ETC('');
		$orderMgr->setPT_REG_NO(1);
		$orderMgr->getOrderPointInsert($db);
	}
	
	/* 쿠폰 사용 복원 */
	if ($orderRow[O_USE_COUPON] > 0){
		$orderMgr->getOrderCouponUseCancelUpdate($db);
	}
	
	if (!$strMsg) $strMsg = $LNG_TRANS_CHAR["OS00045"];

	/** 메일 전송 - 고객 주문 취소 메일 **/
	$aryTAG_LIST['{{__받는사람이름__}}']	= $orderRow['O_B_NAME'];
	$aryTAG_LIST['{{__받는사람메일__}}']	= $orderRow['O_B_MAIL'];
	$aryTAG_LIST['{{__회원명__}}']			= $orderRow['O_B_NAME'];
	$aryTAG_LIST['{{__주문번호__}}']		= $orderRow['O_KEY'];
	$aryTAG_LIST['{{__주문상태표시__}}']	= $strMsg;
	$aryTAG_LIST['{{__주문상품명__}}']		= $orderRow['O_J_TITLE'];
	$aryTAG_LIST['{{__주문취소일자__}}']	= date("Y-m-d");
	goSendMail("010");
	/** 메일 전송 **/
?>