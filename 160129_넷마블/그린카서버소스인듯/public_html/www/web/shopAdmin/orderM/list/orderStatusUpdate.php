<?
	switch($strOrderStatus){
		case "A":
			/* 결제완료 */
			$intOrderProdNoPointUseCnt = 0; //포인트사용금지상품수
			$orderMgr->setOC_LIST_ARY("Y");
			$aryOrderCartList = $orderMgr->getOrderCartList($db);
			if (is_array($aryOrderCartList)){
				for($j=0;$j<sizeof($aryOrderCartList);$j++){
					$strProdCode  = $aryOrderCartList[$j][P_CODE];
					$intOC_OPT_NO = $aryOrderCartList[$j][OC_OPT_NO];
					$intOC_QTY    = $aryOrderCartList[$j][OC_QTY];
					
					if ($aryOrderCartList[$j]["P_POINT_NO_USE"] == "Y"){
						$intOrderProdNoPointUseCnt++;
					}
				}
			}

			/* 포인트 적립(적립금관리사용유무) */
			if ($siteRow[S_POINT_USE1] == "Y"){

				if (($orderRow[O_USE_POINT] > 0 && $siteRow[S_POINT_USE2] == "Y") || $orderRow[O_USE_POINT] == 0) {

					if ($siteRow[S_POINT_ORDER_STATUS] == "S"){
				
						/* 사용포인트가 있고 적립금 사용시 상품적립금 지급 유무(Y) , 사용포인트가 없을 경우 단(포인트지급유무 주문상태는 결제완료)*/
						if ($orderRow[O_TOT_POINT] > 0 && $orderRow[M_NO] > 0 && $orderRow[O_ADD_POINT] != "Y"){
							$memberMgr->setM_NO($orderRow[M_NO]);
							$memberMgr->setM_POINT($orderRow[O_TOT_CUR_POINT]);
							$result = $memberMgr->getMemberPointUpdate(&$db);
							
							/* 포인트 관리 데이터 INSERT */
							$orderMgr->setM_NO($orderRow[M_NO]);
							$orderMgr->setB_NO(0);
							$orderMgr->setPT_TYPE('002');
							$orderMgr->setPT_POINT($memberMgr->getM_POINT());
							$orderMgr->setPT_MEMO($LNG_TRANS_CHAR["OW00126"]."[".$orderRow[O_KEY]."]"); //구매포인트적립
							$orderMgr->setPT_START_DT(date("Y-m-d"));
							$orderMgr->setPT_END_DT(date("Y-m-d",mktime(0,0,0,date("m"),date("d"),date("Y")+$siteRow[S_POINT_USE_YEAR])));
							$orderMgr->setPT_REG_IP($S_REOMTE_ADDR);
							$orderMgr->setPT_ETC('');
							$orderMgr->setPT_REG_NO(1);
							$orderMgr->getOrderPointInsert($db);

							$orderMgr->setO_ADD_POINT("Y");
							$result = $orderMgr->getOrderAddPointUpdate(&$db);

							/* 포인트 히스토리 추가해야 함*/
						}
					}
				}
				/* 첫구매 포인트 지급 확인(적립금 사용시 적립금 지급 유무에 따라 지급됨) */
				if ($orderRow[M_NO] > 0 && $siteRow[S_POINT_ORDER_STATUS] == "S"){
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
						
						if ($strOrderFirstPointGiveYN == "Y"){
							$memberMgr->setM_NO($orderRow[M_NO]);
							$memberMgr->setM_POINT($S_POINT_ORDER_GIVE);
							$memberMgr->getMemberPointUpdate($db);
							
							/* 포인트 관리 데이터 INSERT */
							$orderMgr->setM_NO($orderRow[M_NO]);
							$orderMgr->setB_NO(0);
							$orderMgr->setPT_TYPE('004');
							$orderMgr->setPT_POINT($memberMgr->getM_POINT());
							$orderMgr->setPT_MEMO($LNG_TRANS_CHAR["OW00118"]."[".$orderRow["O_KEY"]."]"); //첫구매포인트적립
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

			/* 승인데이터 INSERT */
			$orderMgr->setOS_STATUS("A");
			$orderMgr->setOS_APPR_NO($orderRow[O_APPR_NO]);
			$orderMgr->setOS_TITLE($orderRow[O_J_TITLE]);
			$orderMgr->setOS_USE_POINT($orderRow[O_USE_CUR_POINT]);
			$orderMgr->setOS_USE_COUPON($orderRow[O_USE_CUR_COUPON]);
			$orderMgr->setOS_TOT_PRICE($orderRow[O_TOT_CUR_PRICE]);
			$orderMgr->setOS_TOT_DELIVERY_PRICE($orderRow[O_TOT_DELIVERY_CUR_PRICE]);
			$orderMgr->setOS_TOT_TAX_PRICE($orderRow[O_TAX_CUR_PRICE]);
			$orderMgr->setOS_TOT_SPRICE($orderRow[O_TOT_CUR_SPRICE]);
			
			/* 적립포인트가 지급되지 않았을때에는 결제관리테이블에 적립포인트를 '0' 으로 입력 */
			if ($orderMgr->getO_ADD_POINT() == "Y") $orderMgr->setOS_TOT_POINT($orderRow[O_TOT_POINT]);	else  $orderMgr->setOS_TOT_POINT(0);	

			$orderMgr->setOS_SETTLE($orderRow[O_SETTLE]);
			$orderMgr->getOrderSettleInsert($db);

			if ($orderRow[O_SETTLE] == "B")
			{

				/** 메일 전송 - 입금확인(무통장 입금) **/
				$strMailSendMode = "adm";
				$strMailMode = "orderSend";
				include WEB_FRWORK_ACT."orderMailForm.inc.php";

				/** 메일 전송 - 고객 주문 취소 메일 **/
				$aryTAG_LIST['{{__받는사람이름__}}']	= $orderRow['O_J_NAME'];
				$aryTAG_LIST['{{__받는사람메일__}}']	= $orderRow['O_J_MAIL'];
				$aryTAG_LIST['{{__회원명__}}']			= $orderRow['O_J_NAME'];
				$aryTAG_LIST['{{__주문번호__}}']		= $orderRow['O_KEY'];
				$aryTAG_LIST['{{__주문상품내역__}}']	= $strOrderCartHtml;
				$aryTAG_LIST['{{__주문금액정보__}}']	= $strOrderCartPriceHtml;
				$aryTAG_LIST['{{__주문내역__}}']		= $strOrderInfoHtml;
				goSendMail("008");
				/** 메일 전송 **/


				## 2015.01.15 kim hee sung SMS 모듈 V2.0
				## 한국어 전용
				## 관리자페이지에서 SMS 사용함 설정된 경우

				## 설정파일 불러오기
				include_once rtrim(MALL_SHOP, '/') . '/conf/smsInfo.conf.inc.php';
	
				if($S_SITE_LNG == "KR" && $SMS_INFO['S_SMS_USE']=="Y"):

					## 사용자 SMS
					## 모듈 설정
					$objSmsInfo = new SmsInfo($db);

					## 코드 설정
					$strSmsCode = "010"; // 010 입금확인(고객용)


					if($SMS_TEXT_LIST && $SMS_TEXT_LIST[$strSmsCode] && $SMS_TEXT_LIST[$strSmsCode]['SM_AUTO'] == "Y"):

						## 문자 설정
						$strSmsMsg			= $SMS_TEXT_LIST[$strSmsCode]['SM_TEXT'];
						$strSmsMsg			= str_replace("{{상점명}}", $S_SITE_KNAME, $strSmsMsg);
						$strSmsMsg			= str_replace("{{결제금액}}", getCurToPrice($orderRow['O_TOT_CUR_SPRICE'],$orderRow['O_USE_LNG']), $strSmsMsg);

						## SMS 전송
						$param = '';
						$param['phone']			= $orderRow['O_J_HP'];		
						$param['callBack']		= $S_COM_PHONE;	
						$param['msg']			= $strSmsMsg;
						$param['siteName']		= $S_SITE_KNAME;
						$objSmsInfo->goSendSms($param);

					endif;

					## 관리자 SMS
					## 필요시 추가하세요..

				endif;

				/** 2013.04.18 SMS 전송 모듈 추가 **/
				## SMS 사용 , 한국어 페이지 인 경우 SMS 전송 실행
//				if($SMS_INFO['S_SMS_USE']=="Y" && $orderRow['O_USE_LNG'] == "KR"):
//					$smsMoney = $smsFunc->getSmsMoneySelect($db); // 머니 체크
//					if($smsMoney['VAL'] > 0):
//						$smsCode			= "010";
//						$smsPhone			= str_replace("-","",$orderRow['O_J_HP']);		
//						$smsCallBackPhone	= $S_COM_PHONE;
//						$smsMsg				= $SMS_TEXT_LIST[$smsCode]['SM_TEXT'];
//						$smsMsg				= str_replace("{{상점명}}", $S_SITE_KNAME, $smsMsg);
//						$smsMsg				= str_replace("{{결제금액}}", getCurToPrice($orderRow['O_TOT_CUR_SPRICE'],$orderRow['O_USE_LNG']), $smsMsg);
//						if($SMS_TEXT_LIST[$smsCode]['SM_AUTO'] == "Y"): //  자동발송 사용..
//							$smsFunc->goSendSms($smsPhone, $smsCallBackPhone, $smsMsg);
//							$smsFunc->getSmsMoneyMinusUpdate($db); // 머니 -1
//						endif;
//					else:
//						// sms 머니 부족.. 부분 처리..
//					endif;
//				endif;
				/** 2013.04.18 SMS 전송 모듈 추가 **/
			}			

			/* HISTORY INSERT (2013.07.01)*/
			$strOrderStatusMemo = "주문상태변경";
			$strOrderStatusText	= "";
			
			$param				= "";
			$param['m_no']		= $a_admin_no;
			$param['h_tab']		= TBL_ORDER_MGR;
			$param['h_key']		= $orderRow['O_NO'];
			$param['h_code']	= "001"; //주문상태
			$param['h_memo']	= $strOrderStatusMemo;
			$param['h_text']	= $strOrderStatus;
			$param['h_reg_no']	= $a_admin_no;
			$param['h_adm_no']	= $a_admin_no;			
			$shopOrderMgr->getOrderStatusHistoryUpdate($db,$param);
			/* HISTORY INSERT */
				
			/* 주문상태변경 */
			$orderMgr->setO_STATUS($strOrderStatus);
			$orderMgr->getOrderStatusUpdate($db);
			/* 주문상품별 배송준비중으로 변경(SHOP_ORDER_CART INSERT/UPDATE) */
			if (is_array($aryOrderCartList))
			{
				for($j=0;$j<sizeof($aryOrderCartList);$j++){
					$param							= "";
					$param["OC_NO"]					= $aryOrderCartList[$j]['OC_NO'];

					$param["OC_DELIVERY_STATUS"]	= "B";
					$param["OC_MOD_NO"]				= $a_admin_no;
					$shopOrderMgr->getOrderCartStatusUpdate($db,$param);
				}
			}
		break;

		case "I":
			//배송중

			if ($S_MALL_TYPE == "R")
			{
				/* AGS 결제이고 에스크로 결제일때 */
				if ($orderRow['O_PG'] == "A" && $orderRow['O_ESCROW'] == "Y"){
					$TrCode		= "E100";
					$userPage	= "A";
					include MALL_HOME."/web/frwork/act/agsPay/AGS_escrow_ing.php";
				}
				/* AGS 결제이고 에스크로 결제일때 */

				/* 가상계좌일경우 배송정보 update */
				if ($orderRow['O_PG'] == "K" && $orderRow['O_SETTLE'] == "T" && $orderRow['O_ESCROW'] == "Y"){
					
					$aryDeliveryCom			= getCommCodeList("DELIVERY","Y");
					$paramData				= "";
					$paramData['O_NO']		= $orderRow['O_NO'];
					$orderDeliveryInfo		= $shopOrderMgr->getOrderDeliverInfo($db,"OP_SELECT",$paramData);
					$req_tx					= "mod_escrow";
					$mod_type				= "STE1";
					$deli_corp				= $aryDeliveryCom[$orderDeliveryInfo['OC_DELIVERY_COM']];
					$deli_numb				= $orderDeliveryInfo['OC_DELIVERY_NUM'];

					if ($deli_corp && $deli_numb)
					{
						
						include MALL_HOME."/web/frwork/act/pp_ax_hub_adm.inc.php";     
						
						if ($res_cd != "0000" || $bSucc == "false")
						{
							/* 실패시 HISTORY INSERT */
							$strOrderStatusMemo = "가상계좌(KCP연동)";
							$strOrderStatusText	= $orderRow['O_NO'];

							$param['m_no']		= $a_admin_no;
							$param['h_tab']		= TBL_ORDER_MGR;
							$param['h_key']		= $orderRow['O_NO'];
							$param['h_code']	= "003"; //배송상태
							$param['h_memo']	= $strOrderStatusMemo;
							$param['h_text']	= $strOrderStatusText;
							$param['h_reg_no']	= $a_admin_no;
							$param['h_adm_no']	= $a_admin_no;
							$shopOrderMgr->getOrderStatusHistoryUpdate($db,$param);
							/* HISTORY INSERT */
						}
					}
				}
				/* 가상계좌일경우 배송정보 update */
			}
		break;

		case "D":
			
			// 배송완료
			$intOrderProdNoPointUseCnt = 0; //포인트사용금지상품수
			$orderMgr->setOC_LIST_ARY("Y");
			$aryOrderCartList = $orderMgr->getOrderCartList($db);
			if (is_array($aryOrderCartList)){
				for($j=0;$j<sizeof($aryOrderCartList);$j++){
					if ($aryOrderCartList[$j]["P_POINT_NO_USE"] == "Y"){
						$intOrderProdNoPointUseCnt++;
					}
				}
			}
			
			/* 적립금 지급 유무 상태가 배송완료일때 */
			/* 포인트 적립(적립금관리사용유무) */
			if ($siteRow[S_POINT_USE1] == "Y"){

				if (($orderRow[O_USE_POINT] > 0 && $siteRow[S_POINT_USE2] == "Y") || $orderRow[O_USE_POINT] == 0) {

					if ($siteRow[S_POINT_ORDER_STATUS] == "D"){
				
						/* 사용포인트가 있고 적립금 사용시 상품적립금 지급 유무(Y) , 사용포인트가 없을 경우 단(포인트지급유무 주문상태는 결제완료)*/
						if ($orderRow[O_TOT_POINT] > 0 && $orderRow[M_NO] > 0 && $orderRow[O_ADD_POINT] != "Y"){
							$memberMgr->setM_NO($orderRow[M_NO]);
							$memberMgr->setM_POINT($orderRow[O_TOT_CUR_POINT]);
							$result = $memberMgr->getMemberPointUpdate(&$db);
							
							/* 포인트 관리 데이터 INSERT */
							$orderMgr->setM_NO($orderRow[M_NO]);
							$orderMgr->setB_NO(0);
							$orderMgr->setPT_TYPE('002');
							$orderMgr->setPT_POINT($memberMgr->getM_POINT());
							$orderMgr->setPT_MEMO($LNG_TRANS_CHAR["OW00126"]."[".$orderRow[O_KEY]."]"); //구매포인트적립
							$orderMgr->setPT_START_DT(date("Y-m-d"));
							$orderMgr->setPT_END_DT(date("Y-m-d",mktime(0,0,0,date("m"),date("d"),date("Y")+$siteRow[S_POINT_USE_YEAR])));
							$orderMgr->setPT_REG_IP($S_REOMTE_ADDR);
							$orderMgr->setPT_ETC('');
							$orderMgr->setPT_REG_NO(1);
							$orderMgr->getOrderPointInsert($db);

							$orderMgr->setO_ADD_POINT("Y");
							$result = $orderMgr->getOrderAddPointUpdate(&$db);

							/* 포인트 히스토리 추가해야 함*/
						}
					}
				}
				
				/* 첫구매 포인트 지급 확인(적립금 사용시 적립금 지급 유무에 따라 지급됨) */
				if ($orderRow[M_NO] > 0 && $siteRow[S_POINT_ORDER_STATUS] == "D"){
					
					$memberMgr->setM_NO($orderRow[M_NO]);
					$memberOrderRow = $memberMgr->getMemberOrderCount($db);
					$intMemberOrderJumunCnt = 99999;
					if ($memberOrderRow){
						$intMemberOrderJumunCnt = $memberOrderRow[JUMUN_CNT];
						$intMemberOrderDeliveryCnt = $memberOrderRow[DELIVERY_CNT];
					}
					
					if ((int)$S_POINT_ORDER_GIVE > 0 && $intMemberOrderJumunCnt == 1 && $intOrderProdNoPointUseCnt == 0){
						$strOrderFirstPointGiveYN = "Y";
						if (($orderRow[O_USE_POINT] > 0 && $S_POINT_USE2 != "Y") || $orderRow["O_FIRST_YN"] == "Y"){
							$strOrderFirstPointGiveYN = "N";
						}
						
						if ($strOrderFirstPointGiveYN == "Y"){
							$memberMgr->setM_NO($orderRow[M_NO]);
							$memberMgr->setM_POINT($S_POINT_ORDER_GIVE);
							$memberMgr->getMemberPointUpdate($db);
							
							/* 포인트 관리 데이터 INSERT */
							$orderMgr->setM_NO($orderRow[M_NO]);
							$orderMgr->setB_NO(0);
							$orderMgr->setPT_TYPE('004');
							$orderMgr->setPT_POINT($memberMgr->getM_POINT());
							$orderMgr->setPT_MEMO($LNG_TRANS_CHAR["OW00118"]."[".$orderRow["O_KEY"]."]"); //첫구매포인트적립
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
			
			/* 적립금 지급 유무 상태가 배송완료일때 */
			if ($S_MALL_TYPE != "R")
			{
				/* AGS 결제이고 에스크로 결제일때 */
				if ($orderRow['O_PG'] == "A" && $orderRow['O_ESCROW'] == "Y"){
					$TrCode		= "E100";
					$userPage	= "A";
					include MALL_HOME."/web/frwork/act/agsPay/AGS_escrow_ing.php";
				}
				/* AGS 결제이고 에스크로 결제일때 */

				/* 가상계좌일경우 배송정보 update */
				if ($orderRow['O_PG'] == "K" && $orderRow['O_SETTLE'] == "T" && $orderRow['O_ESCROW'] == "Y"){
					
					$aryDeliveryCom			= getCommCodeList("DELIVERY","Y");
					$paramData				= "";
					$paramData['O_NO']		= $orderRow['O_NO'];
					$orderDeliveryInfo		= $shopOrderMgr->getOrderDeliverInfo($db,"OP_SELECT",$paramData);
					$req_tx					= "mod_escrow";
					$mod_type				= "STE1";
					$deli_corp				= $aryDeliveryCom[$orderDeliveryInfo['OC_DELIVERY_COM']];
					$deli_numb				= $orderDeliveryInfo['OC_DELIVERY_NUM'];

					if ($deli_corp && $deli_numb)
					{
						
						include MALL_HOME."/web/frwork/act/pp_ax_hub_adm.inc.php";     
						
						if ($res_cd != "0000" || $bSucc == "false")
						{
							/* 실패시 HISTORY INSERT */
							$strOrderStatusMemo = "가상계좌(KCP연동)";
							$strOrderStatusText	= $orderRow['O_NO'];

							$param['m_no']		= $a_admin_no;
							$param['h_tab']		= TBL_ORDER_MGR;
							$param['h_key']		= $orderRow['O_NO'];
							$param['h_code']	= "003"; //배송상태
							$param['h_memo']	= $strOrderStatusMemo;
							$param['h_text']	= $strOrderStatusText;
							$param['h_reg_no']	= $a_admin_no;
							$param['h_adm_no']	= $a_admin_no;
							$shopOrderMgr->getOrderStatusHistoryUpdate($db,$param);
							/* HISTORY INSERT */
						}
					}
				}
				/* 가상계좌일경우 배송정보 update */
			}
			
		break;

		case "E":	
			
			/* 구매 완료시 쿠폰 자동발급 데이터가 있으면 회원일때 쿠폰 발급 */
			if ($orderRow[M_NO] > 0){
				$couponMgr->setSearchCouponIssue("4");
				$couponMgr->setSearchCouponUse("Y");			
				$intCouponTotal = $couponMgr->getCouponTotal($db);
				$couponMgr->setLimitFirst(0);
				$couponMgr->setPageLine($intCouponTotal);
				
				if ($intCouponTotal > 0){
					$couponRet = $couponMgr->getCouponList($db);
					while($couponRow = mysql_fetch_array($couponRet)){
						$couponMgr->setCU_NO($couponRow[CU_NO]);

						$strCouponCode = $couponRow[CU_NO].strtoupper(getCode(10));
						$couponMgr->setCI_CODE($strCouponCode);
						$intDupCnt = $couponMgr->getCouponCodeDupCnt($db);
						if ($intDupCnt > 0){
							$strFlag = false;

							while($strFlag == false){

								$strCouponCode = $couponRow[CU_NO].strtoupper(getCode(10));
								$couponMgr->setCI_CODE($strCouponCode);
								$intDupCnt = $couponMgr->getCouponCodeDupCnt($db);
								
								if($intDupKeyCnt=="0"){
									$strFlag = true;
									break;
								}
							}
						}
						
						$couponMgr->setCU_NO($couponRow[CU_NO]);
						$couponMgr->setM_NO($orderRow[M_NO]);
						$couponMgr->setCI_REG_NO($a_admin_no);
						$couponMgr->setCI_USE_O_NO($orderRow['O_NO']);
						$couponMgr->getIssueInsert($db);
					}
				}
			}
			/* 구매 완료시 쿠폰 자동발급 데이터가 있으면 회원일때 쿠폰 발급 */
			/** 구매완료시 소속에게 포인트 주기 */
			if ($S_FIX_MEMBER_CATE_USE_YN == "Y" && $SHOP_POINT_MOVE_FLAG == "Y" && $S_FIX_MEMBER_CATE_POINT_GIVE_USE_YN == "Y"){
				$param			= "";
				$param["M_NO"]	= $orderRow['M_NO'];
				$aryOrderMemberCateList = $orderMgr->getOrderMemberCateList($db,$param);
				$intOrderTotal	= $orderRow['O_TOT_CUR_SPRICE'];
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
							
							if ($intPointDupCnt == 0){
								$memberMgr->setM_NO($intGiveMemNo);
								$memberMgr->setM_POINT($intPoint);
								$result = $memberMgr->getMemberPointUpdate(&$db);
								
								/* 포인트 관리 데이터 INSERT */
								$orderMgr->setM_NO($intGiveMemNo);
								$orderMgr->setB_NO(0);
								$orderMgr->setPT_TYPE('002');
								$orderMgr->setPT_POINT($memberMgr->getM_POINT());
								$orderMgr->setPT_MEMO($LNG_TRANS_CHAR["OW00126"]."[".$orderRow[O_KEY]."]"); //구매포인트적립
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


//			if ($orderRow['O_USE_LNG'] != "KR"){
//				$param = "";
//				$param['o_no']		= $orderRow["O_NO"];
//				$param['o_status']	= "E";
//				$param['o_reg_no']	= $a_admin_no;
//				$shopOrderMgr->getShopOrderStatusAllProcessUpdate($db,$param);
//			}
		break;
	}
	
	/* 구매건수 , 구매금액 업데이트 */
	if ($orderRow['M_NO']){
		$memberMgr->setM_NO($orderRow['M_NO']);					// 회원번호
		$memberMgr->getMemberBuyUpdate($db);
	}
//	/* 구매건수 , 구매금액 업데이트 */
?>