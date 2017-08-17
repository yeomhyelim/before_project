<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" >
    <head>
		<title>*** KCP [AX-HUB Version] ***</title>
        <script type="text/javascript">
            function goResult()
            {
                //var openwin = window.open( '/common/kcp/proc_win.html', 'proc_win', '' )
                document.pay_info.submit()
                //openwin.close()
            }

            // 결제 중 새로고침 방지 샘플 스크립트 (중복결제 방지)
            function noRefresh()
            {
                /* CTRL + N키 막음. */
                if ((event.keyCode == 78) && (event.ctrlKey == true))
                {
                    event.keyCode = 0;
                    return false;
                }
                /* F5 번키 막음. */
                if(event.keyCode == 116)
                {
                    event.keyCode = 0;
                    return false;
                }
            }
            document.onkeydown = noRefresh ;
        </script>
    </head>
	<body onBlur="window.document.pro.focus();"> 

<? include MALL_HOME."/web/frwork/act/ksnet/KSPayWebHost.inc";?>
<?
    $rcid       = $_POST["reWHCid"];
    $rctype     = $_POST["reWHCtype"];
    $rhash      = $_POST["reWHHash"];

	$ipg = new KSPayWebHost($rcid, null);

	$authyn		= "";
	$trno		= "";
	$trddt		= "";
	$trdtm		= "";
	$amt		= "";
	$authno		= "";
	$msg1		= "";
	$msg2		= "";
	$ordno		= "";
	$isscd		= "";
	$aqucd		= "";
	$temp_v		= "";
	$result		= "";
	$halbu		= "";
	$cbtrno		= "";
	$cbauthno	= "";

	$resultcd =  "";

	//업체에서 추가하신 인자값을 받는 부분입니다
	$ordr_idxx				= $_POST["ordr_idxx"];			// 쇼핑몰 주문번호
    $intO_NO				= $_POST["order_no"];			// 주문번호
	
	$aryCartNo				= $_POST["cartNo"];				// 주문상품정보
    $aryCouponUseIssueNo	= $_POST["couponUseIssueNo"];	// 사용한 쿠폰 발행번호

	/* 주문번호 중복 확인 */
	$orderMgr->setO_KEY($ordr_idxx);
	$intDupKeyCnt = $orderMgr->getOrderDupKey($db);
	if ($intDupKeyCnt != 1)
	{
		goErrMsg("해당결제내역은 이미 처리된 요청이거나 비정상적인 결제내역입니다. 마이페이지에서 확인 후 이상내역 발견시 관리자에 문의해 주시기바랍니다.(1)");
		$db->disConnect();
		exit;
	}

	/* 이미 결제된 주문인지 확인(중복결제처리됨)*/
	$intDupNoCnt = $orderMgr->getOrderDupNo($db);
	if ($intDupNoCnt != 1)
	{
		goErrMsg("해당결제내역은 이미 처리된 요청이거나 비정상적인 결제내역입니다. 마이페이지에서 확인 후 이상내역 발견시 관리자에 문의해 주시기바랍니다.(2)");
		$db->disConnect();
		exit;
	}

	/* 주문번호에 해당하는 주문관리번호와 화면단의 주문관리번호 일치 여부 확인*/
	$intNewO_NO	= $orderMgr->getOrderNo($db);
	if ($intO_NO != $intNewO_NO)
	{
		goErrMsg("해당결제내역은 이미 처리된 요청이거나 비정상적인 결제내역입니다. 마이페이지에서 확인 후 이상내역 발견시 관리자에 문의해 주시기바랍니다.(3)");
		$db->disConnect();
		exit;
	}

	/* 주문한 상품 목록 배열 확인 */
	if (!is_array($aryCartNo)){
		goErrMsg("해당결제내역에 필요한 필수사항이 존재하지 않습니다. 비정상적인 결제내역입니다.");
		$db->disConnect();
		exit;
	}

	$orderMgr->setO_NO($intO_NO);
	$orderRow = $orderMgr->getOrderView($db);
			
//	if (trim($_POST["sndAmount"]) != STR_REPLACE(',','',NUMBER_FORMAT($orderRow[O_TOT_SPRICE]))){
//		goErrMsg("해당결제내역의 결제금액이 일치하지 않습니다. 비정상적인 결제내역입니다.");
//		$db->disConnect();
//		exit;	
//	}

	if ($ipg->kspay_send_msg("1"))
	{
		$authyn		= $ipg->kspay_get_value("authyn");
		$trno		= $ipg->kspay_get_value("trno"  ); //거래번호
		$trddt		= $ipg->kspay_get_value("trddt" ); //거리일자
		$trdtm		= $ipg->kspay_get_value("trdtm" ); //거리시간
		$amt		= $ipg->kspay_get_value("amt"   );
		$authno		= $ipg->kspay_get_value("authno");
		$msg1		= $ipg->kspay_get_value("msg1"  );
		$msg2		= $ipg->kspay_get_value("msg2"  );
		$ordno		= $ipg->kspay_get_value("ordno" ); //주문번호
		$isscd		= $ipg->kspay_get_value("isscd" );
		$aqucd		= $ipg->kspay_get_value("aqucd" );
		$temp_v		= "";
		$result		= $ipg->kspay_get_value("result"); //결제수단
		$halbu		= $ipg->kspay_get_value("halbu");
		$cbtrno		= $ipg->kspay_get_value("cbtrno");
		$cbauthno	= $ipg->kspay_get_value("cbauthno");
		
		if (!empty($msg1)) $msg1 = iconv("EUC-KR","UTF-8", $msg1);
		if (!empty($msg2)) $msg2 = iconv("EUC-KR","UTF-8", $msg2);

		if (!empty($authyn) && 1 == strlen($authyn))
		{
			if ($authyn == "O")
			{
				$resultcd = "0000";

				/*##################### 승인처리 DB 처리 추가 #####################*/
				/* 사용 포인트 차감 */
				if ($orderRow[M_NO] && $S_POINT_USE1 == "Y" && $orderRow[O_USE_POINT] > 0){
					$memberMgr->setM_NO($orderRow[M_NO]);
					$memberMgr->setM_POINT(-$orderRow[O_USE_CUR_POINT]);
					$result = $memberMgr->getMemberPointUpdate($db);
					if (!$result) {
						$bSucc		= "false";
						$bSuccText	= "회원 포인트 차감";
					}
					
					/* 포인트 관리 데이터 INSERT */
					$orderMgr->setM_NO($orderRow[M_NO]);
					$orderMgr->setB_NO(0);
					$orderMgr->setPT_TYPE('001');
					$orderMgr->setPT_POINT($memberMgr->getM_POINT());
					$orderMgr->setPT_MEMO("포인트사용구매[".$orderMgr->getO_KEY()."]");
					$orderMgr->setPT_START_DT(date("Y-m-d"));
					$orderMgr->setPT_END_DT(date("Y-m-d"));
					$orderMgr->setPT_REG_IP($S_REOMTE_ADDR);
					$orderMgr->setPT_ETC('P1');
					$orderMgr->setPT_REG_NO(1);
					$orderMgr->getOrderPointInsert($db);
				}

				/* 쿠폰 사용 유무 체크 */
				if (is_array($aryCouponUseIssueNo) && $orderRow[O_USE_COUPON] > 0){
					for($i=0;$i<sizeof($aryCouponUseIssueNo);$i++){
						$orderMgr->setCOUPON_ISSUE_NO($aryCouponUseIssueNo[$i]);
						$orderMgr->getOrderCouponUseUpdate($db);
					}
				}

				/* 상품 수량 체크 */
				$intOrderProdNoPointUseCnt = 0; //포인트사용금지상품수
				$orderMgr->setOC_LIST_ARY("Y");
				$aryOrderCartList = $orderMgr->getOrderCartList($db);
				if (is_array($aryOrderCartList)){
					for($j=0;$j<sizeof($aryOrderCartList);$j++){
						$strProdCode  = $aryOrderCartList[$j][P_CODE];
						$intOC_OPT_NO = $aryOrderCartList[$j][OC_OPT_NO];
						$intOC_QTY    = $aryOrderCartList[$j][OC_QTY];
						
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
								$productMgr->setP_QTY(-$intOC_QTY);
								$productMgr->setP_CODE($strProdCode);
								$result = $productMgr->getProdQtyUpdate($db);

								if (!$result) {
									$bSucc		= "false";
									$bSuccText	= "상품전체 수량 조절";
								}
							}
						}

						if ($aryOrderCartList[$j]["P_POINT_NO_USE"] == "Y") {
							$intOrderProdNoPointUseCnt++;
						}
					}
				}
				/* 상품 수량 체크 */


				if($orderRow["O_SETTLE"] == "T"){

					//가상계좌결제의 경우 입금이 완료되지 않은 입금대기상태(가상계좌 발급성공)이므로 상품을 배송하시면 안됩니다. 

					/* 가상계좌은행/계좌/예금주/마감일자 UPDATE */
					$orderMgr->setO_BANK($authno);
					$orderMgr->setO_BANK_ACC($isscd);
					$orderMgr->setO_BANK_NAME("");
					$orderMgr->setO_BANK_VALID_DT(date("Ymd", strtotime(date("Y-m-d")." 5 day")));
					$result = $orderMgr->getOrderInputUpdate($db);
					if (!$result) {
						$bSucc		= "false";
						$bSuccText	= "가상계좌정보 UPDATE";
					}

					$orderMgr->setO_STATUS("J");
					$orderMgr->getOrderStatusUpdate($db);
				
				}else{
				
					/* 계좌이체 */
					if ($orderRow["O_SETTLE"] == "A"){
						
						/* 입금은행 UPDATE */
						$orderMgr->setO_BANK($authno);
						$orderMgr->setO_BANK_ACC("");
						$orderMgr->getO_BANK_NAME("");
						$orderMgr->getO_BANK_VALID_DT("");
						$result = $orderMgr->getOrderInputUpdate($db);

						if (!$result) {
							$bSucc		= "false";
							$bSuccText	= "계좌이체 입금정보 UPDATE";
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
									$orderMgr->setPT_POINT($memberMgr->getM_POINT());
									$orderMgr->setPT_MEMO("구매포인트적립[".$orderMgr->getO_KEY()."]");
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
				}
				
				/* 승인데이터 INSERT */
				$strOrderApprNo = $trno;
				$orderMgr->setOS_APPR_NO($strOrderApprNo);
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
				$orderMgr->setO_STATUS("A");

				if($orderRow['O_SETTLE'] == "T") {
					$orderMgr->setOS_STATUS("J");
					$orderMgr->setO_STATUS("J");
				} 
				
				$result = $orderMgr->getOrderSettleInsert($db);
				if (!$result) {
					$bSucc		= "false";
					$bSuccText	= "결제정보 INSERT ";
				}
				
				$result = $orderMgr->getOrderStatusUpdate($db);
				if (!$result) {
					$bSucc		= "false";
					$bSuccText	= "주문정보 상태 UPDATE ";
				}
				
				if ($orderMgr->getO_STATUS() == "A"){
					$result = $orderMgr->getOrderCartDeliveryStatusUpdate($db);
					if (!$result) {
						$bSucc		= "false";
						$bSuccText	= "주문정보 상태 UPDATE ";
					}
				}

				/* 상품삭제 */
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
							
							$result = $productMgr->getProductBasketDelete($db);
							if (!$result) {
								$bSucc		= "false";
								$bSuccText	= "장바구니삭제";
							}
						}
					}
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
				$orderMgr->setO_APPR_NO($strOrderApprNo);
				$orderMgr->getOrderApprNoUpdate($db);
				
				/* 에스크로 여부 UPDATE */
				if ($orderRow['O_SETTLE'] == "T"){
					$orderMgr->setO_ESCROW("Y");
					$orderMgr->getOrderEscrowUpdate($db);
				}

				/* 입점몰일경우 shop_order so_order_status 값을 null로 처리 */
				if ($S_MALL_TYPE == "M"){
					$orderMgr->setO_STATUS("");
					$orderMgr->getOrderAccStatusUpdate($db);
				}

				/* PG사 결제시 주문 메일 발송*/
				if ($resultcd == "0000"){

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
					goSendMail("007");
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
						// T: 가상계좌 일 경우
						if($orderRow['O_SETTLE']=='T'){
							$strSmsCode = "008"; // 현금 주문완료(고객용)
						}else{
							$strSmsCode = "012"; // 전자결재주문완료(고객용)
						}

						if($SMS_TEXT_LIST && $SMS_TEXT_LIST[$strSmsCode] && $SMS_TEXT_LIST[$strSmsCode]['SM_AUTO'] == "Y"):

							## 문자 설정
							$strSmsMsg			= $SMS_TEXT_LIST[$strSmsCode]['SM_TEXT'];
							$strSmsMsg			= str_replace("{{상점명}}", $S_SITE_KNAME, $strSmsMsg);
							$strSmsMsg			= str_replace("{{결제금액}}", getCurToPrice($orderRow['O_TOT_CUR_SPRICE'],$orderRow['O_USE_LNG']), $strSmsMsg);
							$strSmsMsg			= str_replace("{{결제방법}}", $S_ARY_SETTLE_TYPE[$orderRow['O_SETTLE']], $strSmsMsg);

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
//					if($SMS_INFO['S_SMS_USE']=="Y" && $S_SITE_LNG == "KR"):
//						$smsMoney = $smsFunc->getSmsMoneySelect($db); // 머니 체크
//						if($smsMoney['VAL'] > 0):
//							$smsCode			= "012";
//							$smsPhone			= str_replace("-","",$orderRow['O_J_HP']);		
//							$smsCallBackPhone	= $S_COM_PHONE;
//							$smsMsg				= $SMS_TEXT_LIST[$smsCode]['SM_TEXT'];
//							$smsMsg				= str_replace("{{상점명}}", $S_SITE_KNAME, $smsMsg);
//							$smsMsg				= str_replace("{{결제금액}}", getCurToPrice($orderRow['O_TOT_CUR_SPRICE'],$orderRow['O_USE_LNG']), $smsMsg);
//							$smsMsg				= str_replace("{{결제방법}}", $S_ARY_SETTLE_TYPE[$orderRow['O_SETTLE']], $smsMsg);	
//							if($SMS_TEXT_LIST[$smsCode]['SM_AUTO'] == "Y"): //  자동발송 사용..
//								$smsFunc->goSendSms($smsPhone, $smsCallBackPhone, $smsMsg);
//								$smsFunc->getSmsMoneyMinusUpdate($db); // 머니 -1
//							endif;
//						else:
//							// sms 머니 부족.. 부분 처리..
//						endif;
//					endif;
					/** 2013.04.18 SMS 전송 모듈 추가 **/
				}
				/* PG사 결제시 주문 메일 발송*/

			}else
			{
				$resultcd	= trim($authno);
				$bSuccText	= $msg1."[".$msg2."]";
			}

			//$ipg->kspay_send_msg("3"); // 정상처리가 완료되었을 경우 호출합니다.(이 과정이 없으면 일시적으로 kspay_send_msg("1")을 호출하여 거래내역 조회가 가능합니다.)
		}
	}
?>
	<div style="position:absolute; top:50%; left:50%; margin-top:-104px; margin-left:-224px;">
		<table width="449" height="209" cellpadding="0" cellspacing="0">
			<tr>
				<td><img src="/himg/kcp/processing.gif" name="pro" valign="middle"></td>
			</tr>
		</table>
	</div>

    <form name="pay_info" method="post" action="/kr/index.php">

		<!-- 각 결제 공통 사용 변수 -->
		<input type="hidden" name="req_tx"            value="pay">							<!-- 요청 구분 -->
        <input type="hidden" name="bSucc"             value="<?=$bSucc			?>">		<!-- 쇼핑몰 DB 처리 성공 여부 -->
        <input type="hidden" name="res_cd"            value="<?=($resultcd == "0000")?"0000":"9999";?>">     <!-- 결과 코드 -->

        <input type="hidden" name="oNo"				  value="<?=$intO_NO		?>">     <!-- 주문관리번호번호 -->
        <input type="hidden" name="menuType"		  value="order">					
        <input type="hidden" name="mode"		      value="orderEnd">					 
        <input type="hidden" name="act"				  value="">
        <input type="hidden" name="bSuccText"		  value="<?=$bSuccText?>">			 <!-- DB처리오류 -->

	</form>
	<script type="text/javascript">
	<!--
		goResult();
	//-->
	</script>
	</body> 
</html>
