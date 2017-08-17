<?
    /* ============================================================================== */
    /* =   PAGE : 공통 통보 PAGE                                                    = */
    /* = -------------------------------------------------------------------------- = */
    /* =   연동시 오류가 발생하는 경우 아래의 주소로 접속하셔서 확인하시기 바랍니다.= */
    /* =   접속 주소 : http://testpay.kcp.co.kr/pgsample/FAQ/search_error.jsp       = */
    /* = -------------------------------------------------------------------------- = */
    /* =   Copyright (c)  2010.02   KCP Inc.   All Rights Reserved.                 = */
    /* ============================================================================== */
?>
<?
    /* ============================================================================== */
    /* =   01. 공통 통보 페이지 설명(필독!!)                                        = */
    /* = -------------------------------------------------------------------------- = */
    /* =   공통 통보 페이지에서는,                                                  = */
    /* =   가상계좌 입금 통보 데이터와 모바일안심결제 통보 데이터 등을 KCP를 통해   = */
    /* =   실시간으로 통보 받을 수 있습니다.                                        = */
    /* =                                                                            = */
    /* =   common_return 페이지는 이러한 통보 데이터를 받기 위한 샘플 페이지        = */
    /* =   입니다. 현재의 페이지를 업체에 맞게 수정하신 후, 아래 사항을 참고하셔서  = */
    /* =   KCP 관리자 페이지에 등록해 주시기 바랍니다.                              = */
    /* =                                                                            = */
    /* =   등록 방법은 다음과 같습니다.                                             = */
    /* =  - KCP 관리자페이지(admin.kcp.co.kr)에 로그인 합니다.                      = */
    /* =  - [쇼핑몰 관리] -> [정보변경] -> [공통 URL 정보] -> [공통 URL 변경 후]에  = */
    /* =    결과값은 전송받을 가맹점 URL을 입력합니다.                              = */
    /* ============================================================================== */


    /* ============================================================================== */
    /* =   02. 공통 통보 데이터 받기                                                = */
    /* = -------------------------------------------------------------------------- = */
    $site_cd      = $_POST [ "site_cd"  ];                 // 사이트 코드
    $tno          = $_POST [ "tno"      ];                 // KCP 거래번호
    $order_no     = $_POST [ "order_no" ];                 // 주문번호
    $tx_cd        = $_POST [ "tx_cd"    ];                 // 업무처리 구분 코드
    $tx_tm        = $_POST [ "tx_tm"    ];                 // 업무처리 완료 시간
    /* = -------------------------------------------------------------------------- = */
    $ipgm_name    = "";                                    // 주문자명
    $remitter     = "";                                    // 입금자명
    $ipgm_mnyx    = "";                                    // 입금 금액
    $bank_code    = "";                                    // 은행코드
    $account      = "";                                    // 가상계좌 입금계좌번호
    $op_cd        = "";                                    // 처리구분 코드
    $noti_id      = "";                                    // 통보 아이디
    /* = -------------------------------------------------------------------------- = */
	$refund_nm    = "";                                    // 환불계좌주명
    $refund_mny   = "";                                    // 환불금액
    $bank_code    = "";                                    // 은행코드
    /* = -------------------------------------------------------------------------- = */
    $st_cd        = "";                                    // 구매확인 코드
    $can_msg      = "";                                    // 구매취소 사유
    /* = -------------------------------------------------------------------------- = */
    $waybill_no   = "";                                    // 운송장 번호
    $waybill_corp = "";                                    // 택배 업체명
    /* = -------------------------------------------------------------------------- = */
    $cash_a_no    = "";                                    // 현금영수증 승인번호

    /* = -------------------------------------------------------------------------- = */
    /* =   02-1. 가상계좌 입금 통보 데이터 받기                                     = */
    /* = -------------------------------------------------------------------------- = */
	if ($order_no)
	{
		$orderMgr->setO_KEY($order_no);
		$intO_NO = $orderMgr->getOrderNo($db);
		$orderMgr->setO_NO($intO_NO);
		$orderRow = $orderMgr->getOrderView($db);
	}

	function orderWriteLog($strLogText,$strLogPath)
	{
		global $S_DOCUMENT_ROOT;

		$strlogFileName		 = date("Ymd").'_order.log';
		
		if(!file_exists($S_DOCUMENT_ROOT.$strLogPath."/logs/".$strlogFileName)) {
			$fp = fopen($S_DOCUMENT_ROOT.$strLogPath."/logs/".$strlogFileName,"w");
		} else {
			$fp = fopen($S_DOCUMENT_ROOT.$strLogPath."/logs/".$strlogFileName,"a");
		}
		flock( $fp, LOCK_EX );

		fwrite($fp,"#".date("Y-m-d H:i:s")."------------------------------------\n");
		fwrite($fp,$strLogText);
		fwrite($fp,"\n\n\n");

		flock( $fp, LOCK_UN );
		fclose($fp);		
	}
	
	$strResult = "0000";
	
	if ( $tx_cd == "TX00" )
    {
        $ipgm_name = $_POST[ "ipgm_name" ];                // 주문자명
        $remitter  = $_POST[ "remitter"  ];                // 입금자명
        $ipgm_mnyx = $_POST[ "ipgm_mnyx" ];                // 입금 금액
        $bank_code = $_POST[ "bank_code" ];                // 은행코드
        $account   = $_POST[ "account"   ];                // 가상계좌 입금계좌번호
        $op_cd     = $_POST[ "op_cd"     ];                // 처리구분 코드
        $noti_id   = $_POST[ "noti_id"   ];                // 통보 아이디
        $cash_a_no = $_POST[ "cash_a_no" ];                // 현금영수증 승인번호
    
//		$op_cd = "13";

	}

	/* = -------------------------------------------------------------------------- = */
    /* =   02-2. 가상계좌 환불 통보 데이터 받기                                     = */
    /* = -------------------------------------------------------------------------- = */
    else if ( $tx_cd == "TX01" )
	{
        $refund_nm  = $_POST[ "refund_nm"  ];               // 환불계좌주명
        $refund_mny = $_POST[ "refund_mny" ];               // 환불금액
        $bank_code  = $_POST[ "bank_code"  ];               // 은행코드
	}
    /* = -------------------------------------------------------------------------- = */
    /* =   02-3. 구매확인/구매취소 통보 데이터 받기                                  = */
    /* = ------------------------------------------------------------ -------------- = */
    else if ( $tx_cd == "TX02" )
	{
        $st_cd = $_POST[ "st_cd" ];						    // 구매확인 코드

        if ( $st_cd == "N"  )								// 구매확인 상태가 구매취소인 경우
		{
            $can_msg = $_POST[ "can_msg"   ];               // 구매취소 사유
		}
    }    
    /* = -------------------------------------------------------------------------- = */
    /* =   02-4. 배송시작 통보 데이터 받기                                           = */
    /* = -------------------------------------------------------------------------- = */
    else if ( $tx_cd == "TX03" )
	{

        $waybill_no   = $_POST[ "waybill_no"   ];           // 운송장 번호
        $waybill_corp = $_POST[ "waybill_corp" ];           // 택배 업체명
	}

    /* = -------------------------------------------------------------------------- = */
    /* =   02-5. 모바일안심결제 통보 데이터 받기                                    = */
    /* = -------------------------------------------------------------------------- = */
    else if ( $tx_cd == "TX08" )
    {
        $ipgm_mnyx = $_POST[ "ipgm_mnyx" ];                // 입금 금액
        $bank_code = $_POST[ "bank_code" ];                // 은행코드
    }
    /* ============================================================================== */


    /* ============================================================================== */
    /* =   03. 공통 통보 결과를 업체 자체적으로 DB 처리 작업하시는 부분입니다.      = */
    /* = -------------------------------------------------------------------------- = */
    /* =   통보 결과를 DB 작업 하는 과정에서 정상적으로 통보된 건에 대해 DB 작업에  = */
    /* =   실패하여 DB update 가 완료되지 않은 경우, 결과를 재통보 받을 수 있는     = */
    /* =   프로세스가 구성되어 있습니다.                                            = */
    /* =                                                                            = */
    /* =   * DB update가 정상적으로 완료된 경우                                     = */
    /* =   하단의 [04. result 값 세팅 하기] 에서 result 값의 value값을 0000으로     = */
    /* =   설정해 주시기 바랍니다.                                                  = */
    /* =                                                                            = */
    /* =   * DB update가 실패한 경우                                                = */
    /* =   하단의 [04. result 값 세팅 하기] 에서 result 값의 value값을 0000이외의   = */
    /* =   값으로 설정해 주시기 바랍니다.                                           = */
    /* = -------------------------------------------------------------------------- = */

    /* = -------------------------------------------------------------------------- = */
    /* =   03-1. 가상계좌 입금 통보 데이터 DB 처리 작업 부분                        = */
    /* = -------------------------------------------------------------------------- = */
    if ( $tx_cd == "TX00" )
    {
		orderWriteLog($tx_cd.":".$op_cd."=>".$order_no."/".$intO_NO."/".$tno."/".$ipgm_mnyx,$S_SHOP_HOME);

		/* 13(취소)가 아닌 것은 모두 입금으로 처리 */
		if ($op_cd != "13"){

			if (getCurToPriceSave($orderRow['O_TOT_CUR_SPRICE'],$orderRow['O_USE_LNG']) == $ipgm_mnyx && ($orderRow['O_STATUS'] == "J" || $orderRow['O_STATUS'] == "O")){
				
				$intOrderProdNoPointUseCnt = 0; //포인트사용금지상품수
				$orderMgr->setOC_LIST_ARY("Y");
				$aryOrderCartList = $orderMgr->getOrderCartList($db);
				if (is_array($aryOrderCartList)){
					for($j=0;$j<sizeof($aryOrderCartList);$j++){
						$strProdCode  = $aryOrderCartList[$j][P_CODE];
						$intOC_OPT_NO = $aryOrderCartList[$j][OC_OPT_NO];
						$intOC_QTY    = $aryOrderCartList[$j][OC_QTY];
						
						if ($aryOrderCartList[$j][P_STOCK_LIMIT] != "Y"){

							/* 옵션별 수량 조절 
							if ($intOC_OPT_NO > 0){
								$productMgr->setPOA_STOCK_QTY(-$intOC_QTY);
								$productMgr->setPOA_NO($intOC_OPT_NO);
								$result = $productMgr->getProdOptQtyUpdate($db);
								if (!$result) {
									$strResult  = "9999";
								}
							}

							/* 상품전체 수량 조절 
							if ($strProdCode)
							{
								$productMgr->setP_QTY(-$intOC_QTY);
								$productMgr->setP_CODE($strProdCode);
								$result = $productMgr->getProdQtyUpdate($db);

								if (!$result) {
									$strResult  = "9998";
								}
							}*/
						}

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
				
				/* 승인데이터 INSERT */
				$orderMgr->setM_NO($orderRow[M_NO]);
				$orderMgr->setOS_APPR_NO($orderRow[O_APPR_NO]);
				$orderMgr->setOS_TITLE($orderRow[O_J_TITLE]);
				$orderMgr->setOS_USE_POINT($orderRow[O_USE_POINT]);
				$orderMgr->setOS_USE_COUPON($orderRow[O_USE_COUPON]);
				$orderMgr->setOS_TOT_PRICE($orderRow[O_TOT_PRICE]);
				$orderMgr->setOS_TOT_DELIVERY_PRICE($orderRow[O_TOT_DELIVERY_PRICE]);
				$orderMgr->setOS_TOT_TAX_PRICE($orderRow[O_TAX_PRICE]);
				$orderMgr->setOS_TOT_SPRICE($orderRow[O_TOT_SPRICE]);
				
				/* 적립포인트가 지급되지 않았을때에는 결제관리테이블에 적립포인트를 '0' 으로 입력 */
				if ($orderMgr->getO_ADD_POINT() == "Y") $orderMgr->setOS_TOT_POINT($orderRow[O_TOT_POINT]);				
				else  $orderMgr->setOS_TOT_POINT(0);	
				
				$orderMgr->setOS_SETTLE($orderRow[O_SETTLE]);
				$orderMgr->setOS_STATUS("A");
				$result = $orderMgr->getOrderSettleInsert($db);
				if (!$result) {
					$strResult  = "9996";
				}

				$orderMgr->setO_STATUS("A");
				$result = $orderMgr->getOrderStatusUpdate($db);
				if (!$result) {
					$strResult  = "9996";
				}
				
				/* 결제완료시 상품별 배송 배송준비중으로 변경(2014.01.10) */
				$result = $orderMgr->getOrderCartDeliveryStatusUpdate($db);
				if (!$result) {
					$strResult  = "9996";
				}

				/* 입점몰일경우 shop_order so_order_status 값을 null로 처리 */
				if ($S_MALL_TYPE == "M"){
					$orderMgr->setSO_DELIVERY_STATUS("B");
					$orderMgr->setO_STATUS("");
					$orderMgr->getOrderAccStatusUpdate($db);
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
//						$strSmsMsg			= str_replace("{{계좌정보}}", $orderRow['O_BANK_ACC'], $strSmsMsg);

						## SMS 전송
						$param = '';
						$param['phone']			= $orderRow['O_J_HP'];		
						$param['callBack']		= $S_COM_PHONE;	
						$param['msg']			= $strSmsMsg;
						$param['siteName']		= $S_SITE_KNAME;
						$objSmsInfo->goSendSms($param);

					endif;

					## 관리자 SMS

					## 코드 설정
					$strSmsCode = "011";

					if($SMS_TEXT_LIST && $SMS_TEXT_LIST[$strSmsCode] && $SMS_TEXT_LIST[$strSmsCode]['SM_AUTO'] == "Y"):

						## 문자 설정
						$strSmsMsg			= $SMS_TEXT_LIST[$strSmsCode]['SM_TEXT'];
						$strSmsMsg			= str_replace("{{고객명}}", $orderRow['O_J_NAME'], $strSmsMsg);
						$strSmsMsg			= str_replace("{{결제금액}}", getCurToPrice($orderRow['O_TOT_CUR_SPRICE'],$orderRow['O_USE_LNG']), $strSmsMsg);
//						$strSmsMsg			= str_replace("{{계좌정보}}", $orderRow['O_BANK_ACC'], $strSmsMsg);

						## SMS 전송
						$param = '';
						$param['phone']			= $S_COM_HP;		
						$param['callBack']		= $S_COM_PHONE;	
						$param['msg']			= $strSmsMsg;
						$param['siteName']		= $S_SITE_KNAME;
						$objSmsInfo->goSendSms($param);

					endif;

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
//
//					$smsMoney = $smsFunc->getSmsMoneySelect($db); // 머니 체크
//					if($smsMoney['VAL'] > 0):
//						/* 관리자용 */
//						$smsCode			= "011";
//						$smsPhone			= str_replace("-","",$S_COM_HP);		
//						$smsCallBackPhone	= $S_COM_PHONE;
//						$smsMsg				= $SMS_TEXT_LIST[$smsCode]['SM_TEXT'];
//						$smsMsg				= str_replace("{{고객명}}", $orderRow['O_J_NAME'], $smsMsg);
//						$smsMsg				= str_replace("{{결제금액}}", getCurToPrice($orderRow['O_TOT_CUR_SPRICE'],$orderRow['O_USE_LNG']), $smsMsg);
//						if($SMS_TEXT_LIST[$smsCode]['SM_AUTO'] == "Y"): //  자동발송 사용..
//							$smsFunc->goSendSms($smsPhone, $smsCallBackPhone, $smsMsg);
//							$smsFunc->getSmsMoneyMinusUpdate($db); // 머니 -1
//						endif;
//					endif;
//				endif;
				/** 2013.04.18 SMS 전송 모듈 추가 **/

				/* 결제 완료 후 상품별 이용기간 INSERT */
				include MALL_HOME."/web/frwork/act/payOrderPeriodApproval.php";
				/* 결제 완료 후 상품별 이용기간 INSERT */
				

				orderWriteLog($op_cd,$S_SHOP_HOME);

			}

		} else {
			
			if ($orderRow['O_STATUS'] != 'C'){
				/* 취소데이터 INSERT */
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
				$orderMgr->setO_CEL_MEMO("가상계좌 취소[KCP]");
				$orderMgr->setO_RETURN_BANK($_POST[ "returnBank"      ]);
				$orderMgr->getO_RETURN_ACC($_POST[ "returnAcc" ]);
				$orderMgr->getO_RETURN_NAME($_POST[ "returnName"      ]);
				$orderMgr->setO_CEL_STATUS("Y");
				$result = $orderMgr->getOrderCancelUpdate($db);
				if (!$result) {
					$strResult  = "9995";
				}

				$orderMgr->setOS_APPR_NO($orderRow[O_APPR_NO]);
				$orderMgr->setOS_STATUS("C");
				$orderMgr->setOS_TITLE($orderRow[O_J_TITLE]);
				$orderMgr->setOS_USE_POINT($orderRow[O_USE_POINT]);
				$orderMgr->setOS_USE_COUPON($orderRow[O_USE_COUPON]);
				$orderMgr->setOS_TOT_PRICE($orderRow[O_TOT_PRICE]);
				$orderMgr->setOS_TOT_DELIVERY_PRICE($orderRow[O_TOT_DELIVERY_PRICE]);
				$orderMgr->setOS_TOT_TAX_PRICE($orderRow[O_TAX_PRICE]);
				$orderMgr->setOS_TOT_SPRICE($orderRow[O_TOT_SPRICE]);
				
				/* 적립포인트가 지급되지 않았을때에는 결제관리테이블에 적립포인트를 '0' 으로 입력 */
				if ($orderMgr->getO_ADD_POINT() == "Y") $orderMgr->setOS_TOT_POINT($orderRow[O_TOT_POINT]);				
				else  $orderMgr->setOS_TOT_POINT(0);
				$orderMgr->setOS_SETTLE($orderRow[O_SETTLE]);
				$result = $orderMgr->getOrderSettleInsert($db);
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
			}			
		}
    }
	/* = -------------------------------------------------------------------------- = */
    /* =   03-2. 가상계좌 환불 통보 데이터 DB 처리 작업 부분                        = */
    /* = -------------------------------------------------------------------------- = */
    else if ( $tx_cd == "TX01" )
    {
		/*$orderMgr->setO_STATUS("C");
		$orderMgr->setO_RETURN_BANK($bank_code);
		$orderMgr->setO_RETURN_ACC("");
		$orderMgr->setO_RETURN_NAME($refund_nm);
		$orderMgr->setO_CEL_STATUS("Y");
		$result = $orderMgr->getOrderCancelReturnUpdate($db);
		if (!$result) {
			$strResult  = "9701";
		}
		*/
		$strLogText = "가상계좌 환불통보 데이터 받기"."/$tx_cd";
		orderWriteLog($strLogText,$S_SHOP_HOME);
		
		/* 취소 상태 변경 
		$result = $orderMgr->setO_CEL_STATUS("Y");
		$orderMgr->getOrderCancelStatusUpdate($db);
		if (!$result) {
			$strResult  = "9701";
		}
		*/
    }
    /* = -------------------------------------------------------------------------- = */
    /* =   03-3. 구매확인/구매취소 통보 데이터 DB 처리 작업 부분                    = */
    /* = -------------------------------------------------------------------------- = */
    else if ( $tx_cd == "TX02" )
    {	
		orderWriteLog($tx_cd.":".$st_cd."=>".$order_no."/".$intO_NO."/".$tno."/".$ipgm_mnyx,$S_SHOP_HOME);

		//orderWriteLog($tx_cd.":".$st_cd."=>".$orderRow['O_NO'],$S_SHOP_HOME);

		if ($st_cd == "Y" || $st_cd == "S"){

//			if (!$S_FIX_AUTO_ORDER_VIRTUAL_PROCESS_USE || $S_FIX_AUTO_ORDER_VIRTUAL_PROCESS_USE == "Y")
//			{

				$orderMgr->setO_STATUS("E");
				$result = $orderMgr->getOrderStatusUpdate($db);
				if (!$result) {
					$strResult  = "9801";
				}

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
							$result = $couponMgr->getIssueInsert($db);

							if (!$result) {
								$strResult  = "9801";
							}
						}
					}
				}
				/* 구매 완료시 쿠폰 자동발급 데이터가 있으면 회원일때 쿠폰 발급 */

				/* 포인트 지급이 구매완료시 지급일때 지급 */
				$siteRow = $siteMgr->getSiteInfo($db);
				include MALL_HOME."/web/frwork/act/payOrderEndPointUpdate.php";

				/** 구매완료시 소속에게 포인트 주기 */
				if ($S_FIX_MEMBER_CATE_USE_YN == "Y" && $SHOP_POINT_MOVE_FLAG == "Y" && $S_FIX_MEMBER_CATE_POINT_GIVE_USE_YN == "Y"){
					$param			= "";
					$param["M_NO"]	= $orderRow['M_NO'];
					$aryOrderMemberCateList = $orderMgr->getOrderMemberCateList($db,$param);
					if ($orderRow['O_SETTLE'] == "P") $intOrderTotal	= $orderRow['O_TOT_CUR_PRICE'];
					else $intOrderTotal	= $orderRow['O_TOT_CUR_SPRICE'];

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

				/** 주문 상품 구매상태 변경 **/
				if ($S_SHOP_ORDER_VERSION == "V2.0"){
					include MALL_HOME."/web/frwork/act/payOrderEndCartStatusUpdate.php";
				} else {
					/** 몰인몰일 경우 입점사 구매상태 변경 **/
					if ($S_MALL_TYPE == "M"){
						if ($orderRow['O_USE_LNG'] == "KR"){
							include MALL_HOME."/web/frwork/act/payOrderEndMallStatusUpdate.php";
						}
					}
				}
//			}

		} else {
			
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
			//$orderMgr->setO_CEL_MEMO(iconv("euc-kr","utf-8",$can_msg));
			$orderMgr->setO_CEL_MEMO("KCP구매완료시스템연동");
			$orderMgr->setO_RETURN_BANK("");
			$orderMgr->setO_RETURN_ACC("");
			$orderMgr->setO_RETURN_NAME("");
			$orderMgr->setO_CEL_STATUS("P");
			$result = $orderMgr->getOrderCancelUpdate($db);
			if (!$result) {
				$strResult  = "9802";
			}
			
			$orderMgr->setOS_STATUS("C");
			$orderMgr->setOS_APPR_NO($orderRow[O_APPR_NO]);
			$orderMgr->setOS_CEL_NO($strOrderSettleCelNo);
			$result = $orderMgr->getOrderSettleUpdate($db);
			if (!$result) {
				$strResult  = "9803";
			}
		}
    }
    /* = -------------------------------------------------------------------------- = */
    /* =   03-4. 배송시작 통보 데이터 DB 처리 작업 부분                             = */
    /* = -------------------------------------------------------------------------- = */
    else if ( $tx_cd == "TX03" )
    {
		$strLogText = "가상계좌 배송시작 데이터 받기"."/$tx_cd";
		orderWriteLog($strLogText,$S_SHOP_HOME);

    }
    /* = -------------------------------------------------------------------------- = */
    /* =   03-5. 정산보류 통보 데이터 DB 처리 작업 부분                             = */
    /* = -------------------------------------------------------------------------- = */
    else if ( $tx_cd == "TX04" )
    {
		$strLogText = "가상계좌 정산보류 데이터 받기"."/$tx_cd";
		orderWriteLog($strLogText,$S_SHOP_HOME);
    }
    /* = -------------------------------------------------------------------------- = */
    /* =   03-6. 즉시취소 통보 데이터 DB 처리 작업 부분                             = */
    /* = -------------------------------------------------------------------------- = */
    else if ( $tx_cd == "TX05" )
    {
		$strLogText = "즉시취소 통보 데이터 받기"."/$tx_cd";
		orderWriteLog($strLogText,$S_SHOP_HOME);
	}
    /* = -------------------------------------------------------------------------- = */
    /* =   03-7. 취소 통보 데이터 DB 처리 작업 부분                                 = */
    /* = -------------------------------------------------------------------------- = */
    else if ( $tx_cd == "TX06" )
    {
		$strLogText = "취소 통보 데이터 받기"."/$tx_cd";
		orderWriteLog($strLogText,$S_SHOP_HOME);
    }
    /* = -------------------------------------------------------------------------- = */
    /* =   03-8. 발급계좌해지 통보 데이터 DB 처리 작업 부분                         = */
    /* = -------------------------------------------------------------------------- = */
    else if ( $tx_cd == "TX07" )
    {
    }
    /* = -------------------------------------------------------------------------- = */
    /* =   03-9. 모바일안심결제 통보 데이터 DB 처리 작업 부분                       = */
    /* = -------------------------------------------------------------------------- = */
    else if ( $tx_cd == "TX08" )
    {
    }
    /* ============================================================================== */

    /* ============================================================================== */
    /* =   04. result 값 세팅 하기                                                  = */
    /* ============================================================================== */
	

?>
<html><body><form><input type="text" name="result" value="<?=$strResult?>"></form></body></html>