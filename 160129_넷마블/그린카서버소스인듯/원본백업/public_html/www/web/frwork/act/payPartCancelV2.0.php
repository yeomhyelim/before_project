<?
	$param["O_NO"]	= $intO_NO;
	$param["o_no"]	= $intO_NO;
	$orderMgr->setO_NO($intO_NO);
	$orderRow = $orderMgr->getOrderView($db);

	/* 회원정보 */
	if ($orderRow['M_NO'] > 0){
		$memberMgr->setM_NO($orderRow['M_NO']);
		$memberRow = $memberMgr->getMemberView($db);
	}
	
	/* 취소할 상품 리스트 */
	$aryCancelOrderCartList = $_POST["chkSocNo"];
	$strCancelOrderCartList = "";
	if (is_array($aryCancelOrderCartList)){
		for($i=0;$i<sizeof($aryCancelOrderCartList);$i++){
			$strCancelOrderCartList .= $aryCancelOrderCartList[$i].",";		
		}

		$strCancelOrderCartList = SUBSTR($strCancelOrderCartList,0,STRLEN($strCancelOrderCartList)-1);
		
		if (!$strCancelOrderCartList){
			$db->disConnect();
			goClose("취소할 상품이 존재하지 않습니다.");
			exit;
		}
	}

	$param["O_USE_LNG"] = $orderRow["O_USE_LNG"];
	$param["NOT_OC_NO"] = $strCancelOrderCartList;
	$param["O_SHOP_NO"]	= -1;
	$aryOrderCartList   = $shopOrderMgr->getOrderCartListVer2($db,"OP_ARYTOTAL",$param);

	if (!is_array($aryOrderCartList)){
		$db->disConnect();
		goClose("취소할 상품외에 주문된 상품이 존재하지 않습니다.전체취소로 진행해주세요.");
		exit;
	}

	$intOrderTotalPrice			= 0; //주문금액
	$intOrderTotalQty			= 0; //주문수량
	$intOrderTotalPoint			= 0; //적립포인트
	$intOrderDeliveryTotalPrice = 0; //주문금액(그룹배송상품금액제외)
	$intOrderCancelProdCnt		= 0; //부분취소된 상품 갯수

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
			if ($aryOrderCartList[$i]['OC_ORDER_STATUS'] != "C2"){
			
				$intOrderPoint		= ($aryOrderCartList[$i]['OC_CUR_POINT'] * $aryOrderCartList[$i]['OC_QTY']);
				$intOrderPrice      = ($aryOrderCartList[$i]['OC_CUR_PRICE'] * $aryOrderCartList[$i]['OC_QTY']); //할인가격 확인
				$intOrderStockPrice = ($aryOrderCartList[$i]['OC_STOCK_CUR_PRICE'] * $aryOrderCartList[$i]['OC_QTY']); //입고가격
				
				$intOrderTotalPrice = $intOrderTotalPrice + ($intOrderPrice);
				$intOrderTotalQty	= $intOrderTotalQty + $aryOrderCartList[$i]['OC_QTY'];
				$intOrderTotalPoint = $intOrderTotalPoint + $intOrderPoint;			
			
				/* 상품 추가 옵션 */
				$intOrderTotalPrice = $intOrderTotalPrice + $aryOrderCartList[$i]['OC_OPT_ADD_CUR_PRICE'];

				/* 입점몰일 경우 입점몰 총 가격 및 입고가격 확인 */
				if ($S_MALL_TYPE != "R"){
					if ($aryOrderCartList[$i][P_SHOP_NO] >= 0){
		
						$aryShopAccList[$aryOrderCartList[$i][P_SHOP_NO]]["STOCK_PRICE"]		+= $intOrderStockPrice;
						$aryShopAccList[$aryOrderCartList[$i][P_SHOP_NO]]["SALE_PRICE"]			+= $intOrderPrice;
						$aryShopAccList[$aryOrderCartList[$i][P_SHOP_NO]]["SALE_QTY"]			+= $aryOrderCartList[$i]['OC_QTY'];
					}
				}
			} else {
				$intOrderCancelProdCnt++;
			}
		}
	}


	/* 배송비 설정 */
	if ($S_MALL_TYPE != "R"){
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

	$aryParam["M_NO"]							= $orderRow["M_NO"];
	$aryParam["M_GROUP"]						= $memberRow["M_GROUP"];

	$aryParam["orderTotalPrice"]				= $intOrderTotalPrice;				//주문총상품금액
	$aryParam["orderTotTaxPrice"]				= $intOrderTaxTotal;				//주문시과세금액
	$aryParam["orderTotalDeliveryPrice"]		= $intOrderTotalDeliveryPrice;		//주문시배송총금액
	$aryParam["orderTotPgCommissionPrice"]		= $intOrderPgCommissionTotal;		//주문시총수수료

	$aryParam["orderTotalSPrice"]				= $intOrderTotalSPrice;				//주문금액(실제결제금액)
	$aryParam["orderUsePoint"]					= $intO_USE_POINT;					//주문시 사용된 포인트
	$aryParam["orderUseCoupon"]					= $intO_USE_COUPON;					//주문시 사용된 쿠폰 금액
	
	$aryParam["orderMoneyCurStType"]			= "Y";							//주문시 기준통화("Y")/언어통화("N")

	$intMemberGradeDiscountPrice = $intMemberGradeAddPoint = 0;	
	
	/* 회원등급별 할인혜택 */
	if ($orderRow["M_NO"] > 0){			
		$aryMemberDiscountGradeInfo		= getOrderMemberGradeDiscount($aryParam);

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
		if ($orderRow['O_SETTLE'] == "C") $strModType	= "RN07";
		else if ($orderRow['O_SETTLE'] == "A") $strModType	= "STPA";

	} else if ($intOrderTotalSPrice == 0) {
		$intOrderCancelPrice				= $orderRow["O_TOT_CUR_SPRICE"];
		$strModType							= "STSC";
		
		/* 해당주문건에서 취소된 건수가 하나라도 존재하면...전취취소시 부분취소로 변경한다.*/
		if ($intOrderCancelProdCnt > 0) {
			if ($orderRow['O_SETTLE'] == "C") $strModType	= "RN07";
			else if ($orderRow['O_SETTLE'] == "A") $strModType	= "STPA";
		}
	} else if ($intOrderTotalSPrice < 0){
		$intOrderCancelPrice				= $orderRow["O_TOT_CUR_SPRICE"];
		$intOrderRecoveryPoint				= ($intO_USE_POINT + $intO_USE_COUPON) - ($intOrderTotalPrice + $intOrderTotalDeliveryPrice - $intMemberGradeDiscountPrice);
		if ($orderRow['O_SETTLE'] == "C") $strModType	= "RN07";
		else if ($orderRow['O_SETTLE'] == "A") $strModType	= "STPA";
		
		/* 포인트/쿠폰결제일때 */
		if ($orderRow["O_TOT_CUR_SPRICE"] == 0 && $intO_USE_POINT ==  -$intOrderTotalSPrice){
			$strModType						= "STSC";
		}

		/* 포인트 결제일때 총사용포인트 조정필요 */
		if ($orderRow["O_TOT_CUR_SPRICE"] == 0 && $intO_USE_POINT > -$intOrderTotalSPrice){
			$intO_USE_POINT = $intO_USE_POINT + $intOrderTotalSPrice;
		}

		$intOrderTotalSPrice = 0; //결제시 총결제금액이 -로 들어갈수 없음
	}
	
	if ($intOrderCancelPrice != $_POST["totCancelPrice"]){
		$db->disConnect();
		goErrMsg("취소금액이 일치하지 않습니다.1".":".$intOrderCancelPrice.":".$_POST["totCancelPrice"]);
		exit;		
	}

	if ($strModType == "STSC"){
		$db->disConnect();
		goErrMsg("전체취소로 취소를 진행해주세요.");
		exit;			
	}

	/* PG 사 취소하기 */
	$strResultCode = "0000";
	switch ($orderRow["O_PG"]){
		case "K":
			/* 신용카드/계좌이체만 허용 */
			if ($orderRow["O_SETTLE"] == "C" || $orderRow["O_SETTLE"] == "A"){  
				/* KCP */
				include MALL_HOME."/web/frwork/act/kcp/pp_cli_hub.php";
				/* KCP */


			}
		break;
	}

	if ($strResultCode != "0000"){
		$db->disConnect();
		goErrMsg($strResultMsg."[".$strResultCode."]");
		exit;
	}
		
	if ($strResultCode == "0000"){
		
		/* 주문 Master update */
		$param["o_tot_price"]					= getCurToPriceSave($intOrderTotalPrice,$orderRow['O_USE_LNG']);
		$param["o_tot_delivery_price"]			= getCurToPriceSave($intOrderTotalDeliveryPrice,$orderRow['O_USE_LNG']);
		$param["o_tax_price"]					= getCurToPriceSave($intOrderTaxTotal,$orderRow['O_USE_LNG']);
		$param["o_tot_mem_discount_price"]		= getCurToPriceSave($intMemberGradeDiscountPrice,$orderRow['O_USE_LNG']);
		$param["o_tot_sprice"]					= getCurToPriceSave($intOrderTotalSPrice,$orderRow['O_USE_LNG']);
		$param["o_tot_mem_point"]				= getCurToPriceSave($intMemberGradeAddPoint,$orderRow['O_USE_LNG']);
		$param["o_use_point"]					= getCurToPriceSave($intO_USE_POINT,$orderRow['O_USE_LNG']);
		$param["o_use_coupon"]					= getCurToPriceSave($intO_USE_COUPON,$orderRow['O_USE_LNG']);
		$param["o_tot_point"]					= getCurToPriceSave($intOrderTotalPoint,$orderRow['O_USE_LNG']);
		$param["o_tot_pg_commission_price"]		= getCurToPriceSave($intOrderPgCommissionTotal,$orderRow['O_USE_LNG']);
	
		$param["o_tot_cur_price"]				= $intOrderTotalPrice;
		$param["o_tot_delivery_cur_price"]		= $intOrderTotalDeliveryPrice;
		$param["o_tax_cur_price"]				= $intOrderTaxTotal;
		$param["o_tot_mem_discount_cur_price"]	= $intMemberGradeDiscountPrice;
		$param["o_tot_cur_sprice"]				= $intOrderTotalSPrice;
		$param["o_tot_cur_point"]				= $intOrderTotalPoint;
		$param["o_tot_mem_cur_point"]			= $intMemberGradeAddPoint;
		$param["o_use_cur_point"]				= $intO_USE_POINT;
		$param["o_use_cur_coupon"]				= $intO_USE_COUPON;
		$param["o_tot_cur_point"]				= $intOrderTotalPoint;
		$param["o_tot_pg_commission_cur_price"]	= $intOrderPgCommissionTotal;

		$param["o_tot_qty"]						= $intOrderTotalQty;

		$shopOrderMgr->getOrderPartCancelMasterUpdate($db,$param);
		/* 주문 Master update */

		/* 주문 마스터 정산 update */
		$shopOrderMgr->getOrderPartCancelMasterSettleUpdate($db,$param);
		
		/* 이전 적립된 포인트 취소 */
		if ($orderRow['M_NO'] > 0 && $orderRow['O_TOT_CUR_POINT'] > 0 && $orderRow['O_ADD_POINT'] == "Y"){
			$memberMgr->setM_POINT(-$orderRow['O_TOT_CUR_POINT']);
			$memberMgr->getMemberPointUpdate($db);
			
			/* 포인트 관리 데이터 INSERT */
			$orderMgr->setM_NO($orderRow[M_NO]);
			$orderMgr->setB_NO(0);
			$orderMgr->setPT_TYPE('009');
			$orderMgr->setPT_POINT($memberMgr->getM_POINT());
			$orderMgr->setPT_MEMO($LNG_TRANS_CHAR["OW00061"]."[".$orderRow[O_KEY]."]"); //구매포인트적립된포인트취소
			$orderMgr->setPT_START_DT(date("Y-m-d"));
			$orderMgr->setPT_END_DT(date("Y-m-d"));
			$orderMgr->setPT_REG_IP($S_REOMTE_ADDR);
			$orderMgr->setPT_ETC('');
			$orderMgr->setPT_REG_NO(1);
			$orderMgr->getOrderPointInsert($db);
		}
		
		/* 부분취소로 인한 적립포인트 변경 다시 적립 */
		if ($intOrderTotalPoint > 0 && $orderRow['M_NO'] > 0 && $orderRow['O_ADD_POINT'] == "Y"){
						
			$memberMgr->setM_NO($orderRow[M_NO]);
			$memberMgr->setM_POINT($intOrderTotalPoint);
			$memberMgr->getMemberPointUpdate($db);

			/* 포인트 관리 데이터 INSERT */
			$orderMgr->setM_NO($orderRow[M_NO]);
			$orderMgr->setB_NO(0);
			$orderMgr->setPT_TYPE('002');
			$orderMgr->setPT_POINT($memberMgr->getM_POINT());
			$orderMgr->setPT_MEMO($LNG_TRANS_CHAR["OW00097"]."[".$orderRow[O_KEY]."]"); //포인트사용취소
			$orderMgr->setPT_START_DT(date("Y-m-d"));
			$orderMgr->setPT_END_DT(date("Y-m-d",mktime(0,0,0,date("m"),date("d"),date("Y")+$S_POINT_USE_YEAR)));
			$orderMgr->setPT_REG_IP($S_REOMTE_ADDR);
			$orderMgr->setPT_ETC('');
			$orderMgr->setPT_REG_NO(1);
			$orderMgr->getOrderPointInsert($db);
			
		}

		/* 사용포인트 복원 */
		if ($intOrderRecoveryPoint > 0){
			
			$memberMgr->setM_NO($orderRow[M_NO]);
			$memberMgr->setM_POINT($intOrderRecoveryPoint);
			$memberMgr->getMemberPointUpdate($db);

			/* 포인트 관리 데이터 INSERT */
			$orderMgr->setM_NO($orderRow[M_NO]);
			$orderMgr->setB_NO(0);
			$orderMgr->setPT_TYPE('003');
			$orderMgr->setPT_POINT($memberMgr->getM_POINT());
			$orderMgr->setPT_MEMO($LNG_TRANS_CHAR["OW00060"]."[".$orderRow[O_KEY]."]"); //포인트사용취소
			$orderMgr->setPT_START_DT(date("Y-m-d"));
			$orderMgr->setPT_END_DT(date("Y-m-d",mktime(0,0,0,date("m"),date("d"),date("Y")+$S_POINT_USE_YEAR)));
			$orderMgr->setPT_REG_IP($S_REOMTE_ADDR);
			$orderMgr->setPT_ETC('');
			$orderMgr->setPT_REG_NO(1);
			$orderMgr->getOrderPointInsert($db);
		}
		

		/* 입점몰일때 정산관련 데이터 INSERT */
		if ($S_MALL_TYPE != "R"){
			foreach ($aryShopAccList as $key => $value){
				//if ($key > 0){
					$orderMgr->setSH_NO($key);
					$shopRow = $orderMgr->getShopView($db);
					
					if ($shopRow[SH_COM_ACC_PRICE] == "S") $intAccStPrice = $value[SALE_PRICE];
					else $intAccStPrice = $value[STOCK_PRICE];

					$intAccPrice = getRoundUp(($intAccStPrice + ($intAccStPrice * ($shopRow[SH_COM_ACC_RATE]/100))),2);

					$orderMgr->setSO_TOT_PROD_CNT($value[SALE_QTY]);
					$orderMgr->setSO_TOT_PRICE(getCurToPriceSave($value[STOCK_PRICE]));
					$orderMgr->setSO_TOT_CUR_PRICE($value[STOCK_PRICE]);
					$orderMgr->setSO_TOT_SPRICE(getCurToPriceSave($value[SALE_PRICE]));
					$orderMgr->setSO_TOT_CUR_SPRICE($value[SALE_PRICE]);
					$orderMgr->setSO_TOT_APRICE(getCurToPriceSave($intAccPrice));
					$orderMgr->setSO_TOT_CUR_APRICE($intAccPrice);
					$orderMgr->setSO_TOT_DELIVERY_PRICE($value['DELIVERY_PRICE']);
					$orderMgr->setSO_TOT_DELIVERY_CUR_PRICE(getCurToPriceSave($value['DELIVERY_PRICE']));
					$orderMgr->getOrderAccUpdate($db);

				//}
			}
		}


		/* SHOP 주문 취소완료 */
		if (is_array($aryCancelOrderCartList)){
			for($i=0;$i<sizeof($aryCancelOrderCartList);$i++){
				
				$paramData						= "";
				$paramData['OC_NO']				= $aryCancelOrderCartList[$i];
				$paramData['OC_ORDER_STATUS']	= "C2";
				$paramData['OC_MOD_NO']			= $_POST["reg_no"];
				$shopOrderMgr->getOrderCartStatusUpdate($db,$paramData);
				
				$paramData						= "";
				$paramData['O_NO']				= $intO_NO;
				$paramData['OC_NO']				= $aryCancelOrderCartList[$i];
				$paramData['OC_REG_NO']			= $_POST["reg_no"];
				$paramData['OC_UPDATE_TYPE']	= "P";
				$shopOrderMgr->getOrderStatusAllUpdateVer2($db,$paramData);
				
				/* HISTORY INSERT */
				$strOrderStatusMemo = $_POST["mod_desc"]."[부분취소완료]";
				$strOrderStatusText	= $aryCancelOrderCartList[$i]."/C2";

				$param['m_no']		= $orderRow['M_NO'];
				$param['h_tab']		= TBL_ORDER_MGR;
				$param['h_key']		= $orderRow['O_NO'];
				$param['h_code']	= "002"; //구매상태
				$param['h_memo']	= $strOrderStatusMemo;
				$param['h_text']	= $strOrderStatusText;
				$param['h_reg_no']	= $_POST["reg_no"];
				$param['h_adm_no']	= $_POST["reg_no"];
				
				$shopOrderMgr->getOrderStatusHistoryUpdate($db,$param);
				/* HISTORY INSERT */
			}
		}

		if ($_POST["returnBank"] && $_POST["returnAcc"]){
			$param["returnBank"] = $_POST["returnBank"];
			$param["returnAcc"] = $_POST["returnAcc"];
			$param["returnName"] = $_POST["returnName"];
			$shopOrderMgr->getOrderPartCancelReturnUpdate($db,$param);
		}

		if ($strO_SETTLE != $orderRow["O_SETTLE"]){
			
			$param["settle"] = $strO_SETTLE;
			$shopOrderMgr->getOrderSettleUpdate($db,$param);

			/* HISTORY INSERT */
			$param['m_no']		= $a_admin_no;
			$param['h_tab']		= TBL_ORDER_MGR;
			$param['h_key']		= $intO_NO;
			$param['h_code']	= "003"; //결제방법변경
			$param['h_memo']	= "결제방법변경";
			$param['h_text']	= $orderRow['O_SETTLE']."/".$strO_SETTLE;
			$param['h_reg_no']	= $_POST["reg_no"];
			$param['h_adm_no']	= $_POST["reg_no"];
			
			$shopOrderMgr->getOrderStatusHistoryUpdate($db,$param);
			/* HISTORY INSERT */
		}


		/** 구매완료시 소속에게 포인트 주기 */
		if ($orderRow['O_STATUS'] == "E"){
			if ($S_FIX_MEMBER_CATE_USE_YN == "Y" && $SHOP_POINT_MOVE_FLAG == "Y" && $S_FIX_MEMBER_CATE_POINT_GIVE_USE_YN == "Y"){
				$param			= "";
				$param["O_NO"]	= $intO_NO;
				$param["o_no"]	= $intO_NO;
				$orderMgr->setO_NO($intO_NO);
				$orderRow = $orderMgr->getOrderView($db);
				
				$param["M_NO"]			= $orderRow['M_NO'];
				$aryOrderMemberCateList = $orderMgr->getOrderMemberCateList($db,$param);
				$intOrderTotal			= $orderRow['O_TOT_CUR_SPRICE'];
				if ($orderRow['O_TOT_CUR_SPRICE'] == 0) $intOrderTotal	= $orderRow['O_TOT_CUR_PRICE'];

				if (is_array($aryOrderMemberCateList)){

					for($i=0;$i<sizeof($aryOrderMemberCateList);$i++){
						$intPoint		= 0;
						$strPointType	= "";
						$intPointMark	= 0;
						$intGiveMemNo	= $aryOrderMemberCateList[$i]['C_M_NO']; //소속가상회원
						
						if ($orderRow['M_GROUP'] == "007"){
							/* 영업사원 */
							$strPointType	= $aryOrderMemberCateList[$i]['C_POINT_OFF'];
							$intPointMark	= $aryOrderMemberCateList[$i]['C_POINT'];
						} else {
							/* 영업사원 제외 회원 */
							$strPointType	= $aryOrderMemberCateList[$i]['C_POINT2_OFF'];
							$intPointMark	= $aryOrderMemberCateList[$i]['C_POINT2'];													
						}

						if ($strPointType == "1") $intPoint = ($intOrderTotal * ($intPointMark/100)); //%
						else $intPoint = $intPointMark;

						if ($S_ST_LNG == "KR") $intPoint = getTruncateDown($intPoint,0);
						else  $intPoint = getTruncateDown($intPoint,2);
						
						/* 소속에게 포인트 주기 */
						if ($intPoint > 0 && $intGiveMemNo > 0){
							
							/* 중복 체크 */
							$paramData					= "";
							$paramData["M_NO"]			= $intGiveMemNo;
							$paramData["O_NO"]			= $orderRow['O_NO'];
							$paramData["POINT_TYPE"]	= "002";
							$paramData["POINT_ETC"]		= "소속포인트";
							$intPointDupCnt				= $memberMgr->getMemberPointDupCnt($db,$paramData);
							

							/* 이전에 소속포인트가 주어진 경우 삭제하고 다시 소속포인트 준다. */
							if ($intPointDupCnt > 0){
								
								/* 주어진 소속포인트 차감 */
								$dupPointRow			= $memberMgr->getMemberPointDupCnt($db,$paramData,"OP_SELECT");
								
								$memberMgr->setM_POINT(-$dupPointRow['PT_POINT']);
								$memberMgr->getMemberPointUpdate($db);
								
								/* 포인트 관리 데이터 INSERT */
								$orderMgr->setM_NO($orderRow[M_NO]);
								$orderMgr->setB_NO(0);
								$orderMgr->setPT_TYPE('009');
								$orderMgr->setPT_POINT($memberMgr->getM_POINT());
								$orderMgr->setPT_MEMO($LNG_TRANS_CHAR["OW00061"]."[".$orderRow[O_KEY]."]"); //구매포인트적립된포인트취소
								$orderMgr->setPT_START_DT(date("Y-m-d"));
								$orderMgr->setPT_END_DT(date("Y-m-d"));
								$orderMgr->setPT_REG_IP($S_REOMTE_ADDR);
								$orderMgr->setPT_ETC('소속포인트');
								$orderMgr->setPT_REG_NO(1);
								$orderMgr->getOrderPointInsert($db);
								
								
								/* 다시 소속포인트 적립 */
								$memberMgr->setM_NO($intGiveMemNo);
								$memberMgr->setM_POINT($intPoint);
								$result = $memberMgr->getMemberPointUpdate($db);
								
								/* 포인트 관리 데이터 INSERT */
								$orderMgr->setM_NO($intGiveMemNo);
								$orderMgr->setB_NO(0);
								$orderMgr->setPT_TYPE('002');
								$orderMgr->setPT_POINT($memberMgr->getM_POINT());
								$orderMgr->setPT_MEMO($LNG_TRANS_CHAR["OW00097"]."[".$orderRow[O_KEY]."]"); //구매포인트적립
								$orderMgr->setPT_START_DT(date("Y-m-d"));
								$orderMgr->setPT_END_DT(date("Y-m-d",mktime(0,0,0,date("m"),date("d"),date("Y")+$siteRow[S_POINT_USE_YEAR])));
								$orderMgr->setPT_REG_IP($S_REOMTE_ADDR);
								$orderMgr->setPT_ETC('소속포인트');
								$orderMgr->setPT_REG_NO(1);
								$orderMgr->getOrderPointInsert($db);
							}
						}
						/* 소속에게 포인트 주기 */
					}
				}
			}
			/** 구매완료시 소속에게 포인트 주기 */
		}

		

		/** 메일 전송 - 고객 주문 취소 메일 **/
		$param					= "";
		$param["O_NO"]			= $orderRow["O_NO"];
		$param["O_USE_LNG"]		= $orderRow["O_USE_LNG"];
		$param["IN_OC_NO"]		= $strCancelOrderCartList;
		$param["O_SHOP_NO"]		= -9999;
		$aryOrderCancelCartList	= $shopOrderMgr->getOrderCartListVer2($db,"OP_ARYTOTAL",$param);
		
		if (is_array($aryOrderCancelCartList)){
			$strOrderCancelProdInfo = "";
			for($i=0;$i<sizeof($aryOrderCancelCartList);$i++){
				$strOrderCancelProdInfo .= $aryOrderCancelCartList[$i]["OC_P_NAME"]."/";
			}
			
			$strOrderCancelProdInfo = SUBSTR($strOrderCancelProdInfo,0,STRLEN($strOrderCancelProdInfo)-1);
			$strOrderCancelProdInfo = STR_REPLACE("/","<BR>",$strOrderCancelProdInfo);
		}
		
		$aryTAG_LIST['{{__받는사람이름__}}']	= $orderRow['O_J_NAME'];
		$aryTAG_LIST['{{__받는사람메일__}}']	= $orderRow['O_J_MAIL'];
		$aryTAG_LIST['{{__회원명__}}']			= $orderRow['O_J_NAME'];
		$aryTAG_LIST['{{__주문번호__}}']		= $orderRow['O_KEY'];
		$aryTAG_LIST['{{__주문상태표시__}}']	= "요청하신 주문의 상품이 취소되었습니다.";
		$aryTAG_LIST['{{__주문상품명__}}']		= $strOrderCancelProdInfo;
		$aryTAG_LIST['{{__주문취소일자__}}']	= date("Y-m-d");
		goSendMail("011");
		/** 메일 전송 - 고객 주문 취소 메일 **/
		
	}
	goLayerPopClose("주문취소가 완료되었습니다.");
	$db->disConnect();
	exit;
?>