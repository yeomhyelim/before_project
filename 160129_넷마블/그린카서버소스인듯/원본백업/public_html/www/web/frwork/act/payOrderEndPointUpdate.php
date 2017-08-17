<?
			/* 포인트 적립(적립금관리사용유무) */
			if ($siteRow[S_POINT_USE1] == "Y"){

				if (($orderRow[O_USE_POINT] > 0 && $siteRow[S_POINT_USE2] == "Y") || $orderRow[O_USE_POINT] == 0) {

					if ($siteRow[S_POINT_ORDER_STATUS] == "E"){
				
						/* 사용포인트가 있고 적립금 사용시 상품적립금 지급 유무(Y) , 사용포인트가 없을 경우 단(포인트지급유무 주문상태는 결제완료)*/
						if ($orderRow[O_TOT_POINT] > 0 && $orderRow[M_NO] > 0 && $orderRow[O_ADD_POINT] != "Y"){
							$memberMgr->setM_NO($orderRow[M_NO]);
							$memberMgr->setM_POINT($orderRow[O_TOT_CUR_POINT]);
							$result = $memberMgr->getMemberPointUpdate($db);
							
							/* 포인트 관리 데이터 INSERT */
							$orderMgr->setM_NO($orderRow[M_NO]);
							$orderMgr->setB_NO(0);
							$orderMgr->setPT_TYPE('002');
							$orderMgr->setPT_POINT($memberMgr->getM_POINT());
							$orderMgr->setPT_MEMO($LNG_TRANS_CHAR["OW00097"]."[".$orderRow[O_KEY]."]"); //구매포인트적립
							$orderMgr->setPT_START_DT(date("Y-m-d"));
							$orderMgr->setPT_END_DT(date("Y-m-d",mktime(0,0,0,date("m"),date("d"),date("Y")+$siteRow[S_POINT_USE_YEAR])));
							$orderMgr->setPT_REG_IP($S_REOMTE_ADDR);
							$orderMgr->setPT_ETC('');
							$orderMgr->setPT_REG_NO(1);
							$orderMgr->getOrderPointInsert($db);

							$orderMgr->setO_ADD_POINT("Y");
							$result = $orderMgr->getOrderAddPointUpdate($db);

							/* 포인트 히스토리 추가해야 함*/
						}
					}
				}

				/* 첫구매 포인트 지급 확인(적립금 사용시 적립금 지급 유무에 따라 지급됨) */
				if ($orderRow[M_NO] > 0 && $siteRow[S_POINT_ORDER_STATUS] == "E"){
					$memberMgr->setM_NO($orderRow[M_NO]);
					$memberOrderRow = $memberMgr->getMemberOrderCount($db);
					$intMemberOrderJumunCnt = 99999;
					if ($memberOrderRow){
						$intMemberOrderJumunCnt = $memberOrderRow[JUMUN_CNT];
						$intMemberOrderDeliveryCnt = $memberOrderRow[DELIVERY_CNT];
					}

					if ((int)$S_POINT_ORDER_GIVE > 0 && $intMemberOrderJumunCnt == 1 && $intOrderProdNoPointUseCnt == 0){
						$strOrderFirstPointGiveYN = "Y";
						if ($orderRow[O_USE_POINT] > 0 && $S_POINT_USE2 != "Y"){
							$strOrderFirstPointGiveYN = "N";
						}
						
						if ($strOrderFirstPointGiveYN == "Y" && $orderRow['O_FIRST_YN'] != "Y"){
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
?>