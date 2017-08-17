<?			
			/* 사용 포인트 차감 */
			if ($orderRow[M_NO] && $S_POINT_USE1 == "Y" && $orderRow[O_USE_POINT] > 0){
				$memberMgr->setM_NO($orderRow[M_NO]);
				$memberMgr->setM_POINT(-$orderRow[O_USE_CUR_POINT]);
				$result = $memberMgr->getMemberPointUpdate($db);
				if (!$result) {
					$bSucc		= "false";
					$bSuccText	= "사용포인트차감";
				}
				
				/* 포인트 관리 데이터 INSERT */
				$orderMgr->setM_NO($orderRow[M_NO]);
				$orderMgr->setB_NO(0);
				$orderMgr->setPT_TYPE('001');
				$orderMgr->setPT_POINT(-$orderRow[O_USE_CUR_POINT]);
				$orderMgr->setPT_CUR_POINT($memberMgr->getM_POINT());
				$orderMgr->setPT_MEMO($LNG_TRANS_CHAR["OW00096"]."[".$orderMgr->getO_KEY()."]");
				$orderMgr->setPT_START_DT(date("Y-m-d"));
				$orderMgr->setPT_END_DT(date("Y-m-d"));
				$orderMgr->setPT_REG_IP($S_REOMTE_ADDR);
				$orderMgr->setPT_ETC('P1');
				$orderMgr->setPT_REG_NO(1);
				$orderMgr->getOrderPointInsert($db);
			}

			$intOrderProdNoPointUseCnt = 0; //포인트사용금지상품수
			$orderMgr->setOC_LIST_ARY("Y");
			$aryOrderCartList = $orderMgr->getOrderCartList($db);
			if (is_array($aryOrderCartList)){
				for($j=0;$j<sizeof($aryOrderCartList);$j++){
					$strProdCode		= $aryOrderCartList[$j][P_CODE];
					$intOC_OPT_NO		= $aryOrderCartList[$j][OC_OPT_NO];
					$intOC_QTY			= $aryOrderCartList[$j][OC_QTY];
					$intProdStockQty	= $aryOrderCartList[$j][P_QTY];
					
					/* 무제한 상품이 아닌 경우 */
					if ($aryOrderCartList[$j][P_STOCK_LIMIT] != "Y"){
						/* 옵션별 수량 조절 */
						if ($intOC_OPT_NO > 0){
							$productMgr->setPOA_STOCK_QTY(-$intOC_QTY);
							$productMgr->setPOA_NO($intOC_OPT_NO);
							$result = $productMgr->getProdOptQtyUpdate($db);
							if (!$result) {
								$bSucc		= "false";
								$bSuccText	= "옵션별 수량 조절";
							}
						}

						/* 상품전체 수량 조절 */
						if ($strProdCode)
						{
							$intProdQty = $intProdStockQty - $intOC_QTY;
							if ($intProdQty < 0) $intOC_QTY = $intProdStockQty;

							$productMgr->setP_QTY(-$intOC_QTY);
							$productMgr->setP_CODE($strProdCode);
							$result = $productMgr->getProdQtyUpdate($db);

							if (!$result) {
								$bSucc		= "false";
								$bSuccText	= "상품전체 수량 조절";
							}
						}
					}

					if ($aryOrderCartList[$j]["P_POINT_NO_USE"] == "Y"){
						$intOrderProdNoPointUseCnt++;
					}
				}
			}
			

			/* 포인트 적립(적립금관리사용유무) */
			if ($S_POINT_USE1 == "Y"){

				if (($orderRow[O_USE_POINT] > 0 && $S_POINT_USE2 == "Y") || $orderRow[O_USE_POINT] == 0) {

					if ($S_POINT_ORDER_STATUS == "S"){
				
						/* 사용포인트가 있고 적립금 사용시 상품적립금 지급 유무(Y) , 사용포인트가 없을 경우 단(포인트지급유무 주문상태는 결제완료)*/
						if ($orderRow[O_TOT_POINT] > 0 && $orderRow[M_NO] > 0){
							$memberMgr->setM_NO($orderRow[M_NO]);
							$memberMgr->setM_POINT($orderRow[O_TOT_CUR_POINT]);
							$result = $memberMgr->getMemberPointUpdate($db);
							if (!$result) {
								$bSucc		= "false";
								$bSuccText	= "회원 포인트 적립";
							}
							
							/* 포인트 관리 데이터 INSERT */
							$orderMgr->setM_NO($orderRow[M_NO]);
							$orderMgr->setB_NO(0);
							$orderMgr->setPT_TYPE('002');
							$orderMgr->setPT_POINT($orderRow[O_TOT_CUR_POINT]);
							$orderMgr->setPT_CUR_POINT($memberMgr->getM_POINT());
							$orderMgr->setPT_MEMO($LNG_TRANS_CHAR["OW00097"]."[".$orderMgr->getO_KEY()."]");
							$orderMgr->setPT_START_DT(date("Y-m-d"));
							$orderMgr->setPT_END_DT(date("Y-m-d",mktime(0,0,0,date("m"),date("d"),date("Y")+$S_POINT_USE_YEAR)));
							$orderMgr->setPT_REG_IP($S_REOMTE_ADDR);
							$orderMgr->setPT_ETC('P2');
							$orderMgr->setPT_REG_NO(1);
							$orderMgr->getOrderPointInsert($db);

							$orderMgr->setO_ADD_POINT("Y");
							$result = $orderMgr->getOrderAddPointUpdate($db);
							if (!$result) {
								$bSucc		= "false";
								$bSuccText	= "회원 포인트 적립 지급 유무";
							}

							/* 포인트 히스토리 추가해야 함*/
						}
					}
				}

				/* 첫구매 포인트 지급 확인(적립금 사용시 적립금 지급 유무에 따라 지급됨) */
				if ($orderRow[M_NO] > 0 && $S_POINT_ORDER_STATUS == "S"){
					$memberMgr->setM_NO($orderRow[M_NO]);
					$memberOrderRow = $memberMgr->getMemberOrderCount($db);
					$intMemberOrderJumunCnt = 99999;
					if ($memberOrderRow){
						$intMemberOrderJumunCnt = $memberOrderRow[JUMUN_CNT];
						$intMemberOrderDeliveryCnt = $memberOrderRow[DELIVERY_CNT];
					}

					if ((int)$S_POINT_ORDER_GIVE > 0 && $intMemberOrderJumunCnt == 0){
						$strOrderFirstPointGiveYN = "Y";
						if ($orderRow[O_USE_POINT] > 0 && $S_POINT_USE2 != "Y"){
							$strOrderFirstPointGiveYN = "N";
						}
						
						if ($strOrderFirstPointGiveYN == "Y" && $intOrderProdNoPointUseCnt == 0){
							$memberMgr->setM_NO($orderRow[M_NO]);
							$memberMgr->setM_POINT($S_POINT_ORDER_GIVE);
							$memberMgr->getMemberPointUpdate($db);
							
							/* 포인트 관리 데이터 INSERT */
							$orderMgr->setM_NO($orderRow[M_NO]);
							$orderMgr->setB_NO(0);
							$orderMgr->setPT_TYPE('004');
							$orderMgr->setPT_POINT($memberMgr->getM_POINT());
							$orderMgr->setPT_MEMO($LNG_TRANS_CHAR["OW00104"]."[".$orderRow["O_KEY"]."]"); //첫구매포인트적립
							$orderMgr->setPT_START_DT(date("Y-m-d"));
							$orderMgr->setPT_END_DT(date("Y-m-d",mktime(0,0,0,date("m"),date("d"),date("Y")+$S_POINT_USE_YEAR)));
							$orderMgr->setPT_REG_IP($S_REOMTE_ADDR);
							$orderMgr->setPT_ETC('FIRST');
							$orderMgr->setPT_REG_NO(1);
							$orderMgr->getOrderPointInsert($db);
							
							/* 첫구매 여부 update */
							$orderMgr->getOrderFirstUpdate($db,"Y");
						}
					}
				}
				/* 첫구매 포인트 지급 확인(적립금 사용시 적립금 지급 유무에 따라 지급됨) */
			}


			/* 승인데이터 INSERT */
			$orderMgr->setOS_APPR_NO($tno);
			$orderMgr->setOS_TITLE($orderRow[O_J_TITLE]);
			$orderMgr->setOS_USE_POINT($orderRow[O_USE_CUR_POINT]);
			$orderMgr->setOS_USE_COUPON($orderRow[O_USE_CUR_COUPON]);
			$orderMgr->setOS_TOT_PRICE($orderRow[O_TOT_CUR_PRICE]);
			$orderMgr->setOS_TOT_DELIVERY_PRICE($orderRow[O_TOT_DELIVERY_CUR_PRICE]);
			$orderMgr->setOS_TOT_TAX_PRICE($orderRow[O_TAX_CUR_PRICE]);
			$orderMgr->setOS_TOT_SPRICE($orderRow[O_TOT_CUR_SPRICE]);
			
			/* 적립포인트가 지급되지 않았을때에는 결제관리테이블에 적립포인트를 '0' 으로 입력 */
			if ($orderMgr->getO_ADD_POINT() == "Y") $orderMgr->setOS_TOT_POINT($orderRow[O_TOT_CUR_POINT]);				
			else  $orderMgr->setOS_TOT_POINT(0);	
			
			$orderMgr->setOS_SETTLE($orderRow[O_SETTLE]);
			$orderMgr->setOS_STATUS("A");
			$result = $orderMgr->getOrderSettleInsert($db);
			if (!$result) {
				$bSucc		= "false";
				$bSuccText	= "결제정보 INSERT ";
			}

			$orderMgr->setO_STATUS("A");
			$result = $orderMgr->getOrderStatusUpdate($db);
			if (!$result) {
				$bSucc		= "false";
				$bSuccText	= "주문정보 상태 UPDATE ";
			}

			/* 결제완료시 상품별 배송 배송준비중으로 변경(2014.01.10) */
			$result = $orderMgr->getOrderCartDeliveryStatusUpdate($db);
			if (!$result) {
				$bSucc		= "false";
				$bSuccText	= "주문정보 상태 UPDATE ";
			}
			
			$aryCartNo = $_SESSION["ORDER_DEL_BASKET"];
			if (is_array($aryCartNo) && $bSucc != "false"){
				$strAllCartNo  = "";
				for($i=0;$i<sizeof($aryCartNo);$i++){
					$strAllCartNo .= $aryCartNo[$i].",";
				}

				$strAllCartNo = SUBSTR($strAllCartNo,0,STRLEN($strAllCartNo)-1);					
				$productMgr->setPB_ALL_NO($strAllCartNo);
				$productMgr->setPB_ALL_SORT("Y");

				$aryProdBasketList = $productMgr->getProdBasketList($db);
				if (is_array($aryProdBasketList)){

					for($i=0;$i<sizeof($aryProdBasketList);$i++){
						/* 장바구니 삭제 */
						$productMgr->setPB_NO($aryProdBasketList[$i][PB_NO]);
						$result = $productMgr->getProductBasketAddDelete($db);
						if (!$result) {
							$bSucc		= "false";
							$bSuccText	= "장바구니옵션삭제";
						}

						if ($S_SHOP_PROD_ADD_ITEM_VERSION == "V2.O"){
							$result = $productMgr->getProductBasketItemDelete($db);
							if (!$result) {
								$bSucc		= "false";
								$bSuccText	= "장바구니항목삭제";
							}
						}
						
						$result = $productMgr->getProductBasketDelete($db);
						if (!$result) {
							$bSucc		= "false";
							$bSuccText	= "장바구니삭제";
						}
					}
				}

				$_SESSION["ORDER_DEL_BASKET"] = "";
			}
			
			$aryCouponUseIssueNo = $_SESSION["ORDER_COUPON_UPDATE"];
			if (is_array($aryCouponUseIssueNo) && $orderRow[O_USE_COUPON] > 0 && $bSucc != "false"){
				for($i=0;$i<sizeof($aryCouponUseIssueNo);$i++){
					$orderMgr->setCOUPON_ISSUE_NO($aryCouponUseIssueNo[$i]);
					$orderMgr->getOrderCouponUseUpdate($db);
				}
				$_SESSION["ORDER_COUPON_UPDATE"] = "";
			}

			/*사은품 수량 체크 */
			$aryOrderGiftList = $orderMgr->getOrderGiftList($db);
			if (is_array($aryOrderGiftList)){
				for($i=0;$i<sizeof($aryOrderGiftList);$i++){
					
					if ($aryOrderGiftList[$i][CG_STOCK] != "N" && $aryOrderGiftList[$i][CG_QTY] > 0){
						
						$orderMgr->setGIFT_NO($aryOrderGiftList[$i][CG_NO]);
						if ($aryOrderGiftList[$i][CG_QTY] >= $aryOrderGiftList[$i][OG_QTY])  $orderMgr->setGIFT_QTY($aryOrderGiftList[$i][OG_QTY]);
						else $orderMgr->setGIFT_QTY(0);
						$orderMgr->getOrderGiftQtyUpdate($db);
					}
				}
			}

			/* 거래번호 UPDATE */
			$orderMgr->setO_APPR_NO($tno);
			$orderMgr->getOrderApprNoUpdate($db);

			/* 에스크로 여부 UPDATE */
			$orderMgr->setO_ESCROW($escw_yn);
			$orderMgr->getOrderEscrowUpdate($db);

			/* 입점몰일경우 shop_order so_order_status 값을 null로 처리 */
			if ($S_MALL_TYPE == "M"){
				$orderMgr->setO_STATUS("");
				$orderMgr->getOrderAccStatusUpdate($db);
			}
			
			/* 경매 상품 정보 UPDATE */
//			if ($S_PRODUCT_AUCTION_USE == "Y"){
//				$strAuctionMode = "2";
//				include WEB_FRWORK_JSON."/order.auction.php";	
//			}
			/* 경매 상품 정보 UPDATE */

			/* PG사 결제시 주문 메일 발송*/
			$intO_NO = $orderRow[O_NO];
			$strMailMode = "orderSend";
			include WEB_FRWORK_ACT."orderMailForm.inc.php";

			/* PG사 결제시 주문 메일 발송*/
			$aryTAG_LIST['{{__받는사람이름__}}']	= $orderRow['O_J_NAME'];
			$aryTAG_LIST['{{__받는사람메일__}}']	= $orderRow['O_J_MAIL'];
			$aryTAG_LIST['{{__회원명__}}']			= $orderRow['O_J_NAME'];
			$aryTAG_LIST['{{__주문번호__}}']		= $orderRow['O_KEY'];
			$aryTAG_LIST['{{__주문상품내역__}}']	= $strOrderCartHtml;
			$aryTAG_LIST['{{__주문금액정보__}}']	= $strOrderCartPriceHtml;
			$aryTAG_LIST['{{__주문내역__}}']		= $strOrderInfoHtml;
			//goSendMail("007");
			/* PG사 결제시 주문 메일 발송*/
?>