<?php
 /***************************************************************************************************************
 * 올더게이트로부터 가상계좌 입/출금 데이타를 받아서 상점에서 처리 한 후 
 * 올더게이트로 다시 응답값을 리턴하는 페이지입니다.
 * 상점 DB처리 부분을 업체에 맞게 수정하여 작업하시기 바랍니다.
***************************************************************************************************************/

/*********************************** 올더게이트로 부터 넘겨 받는 값들 시작 *************************************/
$trcode     = trim( $_POST["trcode"] );					    //거래코드
$service_id = trim( $_POST["service_id"] );					//상점아이디
$orderdt    = trim( $_POST["orderdt"] );				    //승인일자
$virno      = trim( $_POST["virno"] );				        //가상계좌번호
$deal_won   = trim( $_POST["deal_won"] );					//입금액
$ordno		= trim( $_POST["ordno"] );                      //주문번호
$inputnm	= trim( $_POST["inputnm"] );					//입금자명

$deal_no	= trim( $_POST["deal_no"] );					//ksnet 거래번호

/*********************************** 올더게이트로 부터 넘겨 받는 값들 끝 *************************************/

//$trcode     = "1";					    //거래코드
//$service_id = "celecon";					//상점아이디
//$orderdt    = "2013-06-21 15:34:34";				    //승인일자
//$virno      = "87039012981984";				        //가상계좌번호
//$deal_won   = 1000;					//입금액
//$ordno		= "20130621UMCTZ00001";                      //주문번호
//$inputnm	= "박영미";	

/***************************************************************************************************************
 * 상점에서 해당 거래에 대한 처리 db 처리 등....
 *
 * trcode = "1" ☞ 일반가상계좌 입금통보전문
 * trcode = "2" ☞ 일반가상계좌 취소통보전문
 *
***************************************************************************************************************/
	$strResult = "0000";
	
	if ($ordno && !$deal_no) {
		$orderMgr->setO_KEY($ordno);
		$intO_NO = $orderMgr->getOrderNo($db);
	} else if (!$ordno && $deal_no){
		/*ksnet 같이 쓰기 때문에 */
		$orderMgr->setO_APPR_NO($deal_no);
		$intO_NO = $orderMgr->getOrderNo($db);
	}

	if ($intO_NO > 0)
	{
		$orderMgr->setO_NO($intO_NO);
		$orderRow = $orderMgr->getOrderView($db);
		
		$S_SITE_LNG = $orderRow['O_USE_LNG'];
		if ($trcode == "1"){
			
			/* 입금통보 DB 처리 */
			if (getCurToPriceSave($orderRow['O_TOT_CUR_SPRICE'],$orderRow['O_USE_LNG']) == $deal_won){
				
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
				
				/* 포인트 적립 */
				if ($S_POINT_USE1 == "Y"){

					if (($orderRow[O_USE_POINT] > 0 && $S_POINT_USE2 == "Y") || $orderRow[O_USE_POINT] == 0) {

						if ($S_POINT_ORDER_STATUS == "S"){
					
							/* 사용포인트가 있고 적립금 사용시 상품적립금 지급 유무(Y) , 사용포인트가 없을 경우 단(포인트지급유무 주문상태는 결제완료)*/
							if ($orderRow[O_TOT_POINT] > 0 && $orderRow[M_NO] > 0){
								$memberMgr->setM_NO($orderRow[M_NO]);
								$memberMgr->setM_POINT($orderRow[O_TOT_POINT]);
								$result = $memberMgr->getMemberPointUpdate($db);
								if (!$result) {
									$strResult  = "9997";
								}

								$orderMgr->setO_ADD_POINT("Y");
								$result = $orderMgr->getOrderAddPointUpdate($db);
								if (!$result) {
									$strResult  = "9991";
								}
								/* 포인트 히스토리 추가해야 함*/
								/* 포인트 관리 데이터 INSERT */
								$orderMgr->setM_NO($orderRow[M_NO]);
								$orderMgr->setB_NO(0);
								$orderMgr->setPT_TYPE('002');
								$orderMgr->setPT_POINT($memberMgr->getM_POINT());
								$orderMgr->setPT_MEMO("구매포인트적립[".$orderRow[O_KEY]."]");
								$orderMgr->setPT_START_DT(date("Y-m-d"));
								$orderMgr->setPT_END_DT(date("Y-m-d",mktime(0,0,0,date("m"),date("d"),date("Y")+$S_POINT_USE_YEAR)));
								$orderMgr->setPT_REG_IP($S_REOMTE_ADDR);
								$orderMgr->setPT_ETC('');
								$orderMgr->setPT_REG_NO(1);
								$result = $orderMgr->getOrderPointInsert($db);
								if (!$result) {
									$strResult  = "9996";
								}
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
				
				/* 승인데이터 상태 UPDATE */
				$orderMgr->setOS_STATUS("A");
				$result = $orderMgr->getOrderSettleStatusUpdate($db);
				if (!$result) {
					$strResult  = "9996";
				}
				/* 승인데이터 상태 UPDATE */

				$orderMgr->setO_STATUS("A");
				$result = $orderMgr->getOrderStatusUpdate($db);
				if (!$result) {
					$strResult  = "9996";
				}

				$result = $orderMgr->getOrderCartDeliveryStatusUpdate($db);
				if (!$result) {
					$strResult  = "9996";
				}

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
					$strSmsCode = "010"; // 입금확인(고객용)

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
// 2015.01.15 kim hee sung 소스 정리 및 sms 작동 오류 수정
//				if($SMS_INFO['S_SMS_USE']=="Y" && $S_SITE_LNG == "KR"):
//					$smsMoney = $smsFunc->getSmsMoneySelect($db); // 머니 체크
//					if($smsMoney['VAL'] > 0):
//						$smsCode			= "010";
//						$smsPhone			= str_replace("-","",$orderRow['O_J_HP']);		
//						$smsCallBackPhone	= $S_COM_PHONE;
//						$smsMsg				= $SMS_TEXT_LIST[$smsCode]['SM_TEXT'];
//						$smsMsg				= str_replace("{{상점명}}", $S_SITE_KNAME, $smsMsg);
//						$smsMsg				= str_replace("{{결제금액}}", getCurToPrice($orderRow['O_TOT_CUR_SPRICE'],$orderRow['O_USE_LNG']), $smsMsg);
//						//$smsMsg				= str_replace("{{계좌정보}}", $orderRow['O_BANK_ACC'], $smsMsg);	
//						if($SMS_TEXT_LIST[$smsCode]['SM_AUTO'] == "Y"): //  자동발송 사용..
//							$smsFunc->goSendSms($smsPhone, $smsCallBackPhone, $smsMsg);
//							$smsFunc->getSmsMoneyMinusUpdate($db); // 머니 -1
//						endif;
//					else:
//						// sms 머니 부족.. 부분 처리..
//					endif;
//				endif;
				/** 2013.04.18 SMS 전송 모듈 추가 **/

			} else {
				$strResult  = "9999";
			}
			/* 입금통보 DB 처리 */

		
		}

		if ($trcode == "2"){
			/* 입금취소 DB 처리 */
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
			$orderMgr->setO_CEL_MEMO("가상계좌 취소[AGS]");
			$orderMgr->setO_RETURN_BANK("");
			$orderMgr->getO_RETURN_ACC("");
			$orderMgr->getO_RETURN_NAME("");
			$orderMgr->setO_CEL_STATUS("Y");
			$result = $orderMgr->getOrderCancelUpdate($db);
			if (!$result) {
				$strResult  = "9995";
			}

			$orderMgr->setOS_STATUS("C");
			$result = $orderMgr->getOrderSettleStatusUpdate($db);
			if (!$result) {
				$strResult  = "9994";
			}

			$result = $orderMgr->getOrderStatusUpdate($db);
			if (!$result) {
				$strResult  = "9993";
			}

			$orderMgr->setOS_APPR_NO($orderRow[O_APPR_NO]);
			$orderMgr->setOS_CEL_NO($strOrderSettleCelNo);
			$result = $orderMgr->getOrderSettleUpdate($db);
			if (!$result) {
				$strResult  = "9996";
			}
			/* 입금취소 DB 처리 */
		}
	} else {
		$strResult = "9999";
	}


/******************************************처리 결과 리턴******************************************************/
$rResMsg  = "";
$rSuccYn  = "y";// 정상 : y 실패 : n

if ($strResult != "0000") $rSuccYn  = "n";

//정상처리 경우 거래코드|상점아이디|주문일시|가상계좌번호|처리결과|
$rResMsg .= $trcode."|";
$rResMsg .= $service_id."|";
$rResMsg .= $orderdt."|";
$rResMsg .= $virno."|";
$rResMsg .= $rSuccYn."|";

echo $rResMsg;
/******************************************처리 결과 리턴******************************************************/
?> 