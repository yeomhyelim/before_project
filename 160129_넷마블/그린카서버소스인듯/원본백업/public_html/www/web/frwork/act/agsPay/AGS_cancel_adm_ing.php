<?
/**********************************************************************************************
*
* 파일명 : AGS_cancel_ing.php
* 작성일자 : 2009/04/01
* 
* 올더게이트 플러그인에서 리턴된 데이타를 받아서 소켓취소요청을 합니다.
*
* Copyright AEGIS ENTERPRISE.Co.,Ltd. All rights reserved.
*
**********************************************************************************************/ 

	/****************************************************************************
	*
	* [1] 라이브러리(AGSLib.php)를 인클루드 합니다.
	*
	****************************************************************************/
	require MALL_HOME."/web/frwork/act/agsPay/lib/AGSLib.php";
	
	/****************************************************************************
	*
	* [2]. agspay4.0 클래스의 인스턴스를 생성합니다.
	*
	****************************************************************************/
	$orderSettleRow = $orderMgr->getOrderSettleView($db);
	if ($orderRow["O_SETTLE"] == "C"){
		$strAuthTy	= "card";
		$strSubTy	= "visa3d";
		if (in_array($orderSettleRow["OS_CARD_CODE"],array("0100","0202","0203","0205","0206","0207","0302","0303","0110","0200"))){
			$strSubTy = "isp";
		}
	}
	

	$agspay = new agspay40;

	/****************************************************************************
	*
	* [3] AGS_pay.html 로 부터 넘겨받을 데이타
	*
	****************************************************************************/
	/*공통사용*/
	$agspay->SetValue("AgsPayHome",$S_DOCUMENT_ROOT.$S_SHOP_HOME."/logs/agsPay");			//올더게이트 결제설치 디렉토리 (상점에 맞게 수정)

	$agspay->SetValue("log","true");							//true : 로그기록, false : 로그기록안함.
	$agspay->SetValue("logLevel","INFO");						//로그레벨 : DEBUG, INFO, WARN, ERROR, FATAL (해당 레벨이상의 로그만 기록됨)
	$agspay->SetValue("Type", "Cancel");						//고정값(수정불가)
	$agspay->SetValue("RecvLen", 7);							//수신 데이터(길이) 체크 에러시 6 또는 7 설정. 
	
	$agspay->SetValue("StoreId",trim(iconv("UTF-8","EUC-KR",$S_PG_SITE_CODE)));		//상점아이디
	$agspay->SetValue("AuthTy",trim(iconv("UTF-8","EUC-KR",$strAuthTy)));			//결제형태
	$agspay->SetValue("SubTy",trim(iconv("UTF-8","EUC-KR",$strSubTy)));			//서브결제형태
	$agspay->SetValue("rApprNo",trim(iconv("UTF-8","EUC-KR",$orderRow["O_APPR_NO"])));			//승인번호
	$agspay->SetValue("rApprTm",trim(iconv("UTF-8","EUC-KR",SUBSTR(STR_REPLACE("-","",$orderSettleRow["OS_APPR_DT"]),0,8))));			//승인일자
	$agspay->SetValue("rDealNo",trim(iconv("UTF-8","EUC-KR",$orderSettleRow["OS_DEAL_NO"])));			//거래번호
	
	/****************************************************************************
	*
	* [4] 올더게이트 결제서버로 결제를 요청합니다.
	*
	****************************************************************************/
	$agspay->startPay();

	/****************************************************************************
	*
	* [5] 취소요청결과에 따른 상점DB 저장 및 기타 필요한 처리작업을 수행하는 부분입니다.
	*
	* 신용카드결제 취소결과가 정상적으로 수신되었으므로 DB 작업을 할 경우 
	* 결과페이지로 데이터를 전송하기 전 이부분에서 하면된다.
	*
	* 여기서 DB 작업을 해 주세요.
	* 취소성공여부 : $agspay->GetResult("rCancelSuccYn") (성공:y 실패:n)
	* 취소결과메시지 : $agspay->GetResult("rCancelResMsg")
	*
	****************************************************************************/		
		
	if($agspay->GetResult("rCancelSuccYn") != "y")
	{ 
		$bSucc = "false";
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
		$orderMgr->setO_CEL_MEMO($mod_desc);
		$orderMgr->setO_RETURN_BANK($_POST[ "returnBank"      ]);
		$orderMgr->setO_RETURN_ACC($_POST[ "returnAcc" ]);
		$orderMgr->setO_RETURN_NAME($_POST[ "returnName"      ]);
		
		if ($mod_type == "STE3") $orderMgr->setO_CEL_STATUS("N");
		else $orderMgr->setO_CEL_STATUS("Y");

		$result = $orderMgr->getOrderCancelUpdate($db);
		if (!$result) {
			$bSucc		= "false";
			$bSuccText	= "주문취소";
		}

		$orderMgr->setOS_STATUS("C");
		$orderMgr->setOS_CEL_NO($strOrderSettleCelNo);
		$result = $orderMgr->getOrderSettleCancelStatusUpdate($db);
		if (!$result) {
			$bSucc		= "false";
			$bSuccText	= "주문취소";
		}
	}
?>
