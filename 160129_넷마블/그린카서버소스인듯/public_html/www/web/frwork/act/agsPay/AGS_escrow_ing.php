<?php
/**********************************************************************************************
*
* 파일명 : AGS_escrow_ing.php
* 작성일자 : 2009/3/20
*
* 리턴된 데이타를 받아서 소켓결제요청을 합니다.
*
* Copyright AEGIS ENTERPRISE.Co.,Ltd. All rights reserved.
*
**********************************************************************************************/

/** Function Library **/ 
require MALL_HOME."/web/frwork/act/agsPay/lib/aegis_Func.php";


/****************************************************************************
*
* [1] 올더게이트 에스크로 결제시 사용할 로컬 통신서버 IP/Port 번호
*
* $IsDebug : 1:수신,전송 메세지 Print 0:사용안함
* $LOCALADDR : 올더게이트 서버와 통신을 담당하는 암호화Process가 위치해 있는 IP (220.85.12.74)
* $LOCALPORT : 포트
* $ENCTYPE : E : 올더게이트 에스크로
* $CONN_TIMEOUT : 암호화 데몬과 접속 Connect타임아웃 시간(초)
* $READ_TIMEOUT : 데이터 수신 타임아웃 시간(초)
* 
****************************************************************************/

$IsDebug = 0;
$LOCALADDR  = "220.85.12.74";
$LOCALPORT  = "29760";
$ENCTYPE    = "E";
$CONN_TIMEOUT = 10;
$READ_TIMEOUT = 30;


/****************************************************************************
*
* [2] AGS_escrow.html 로 부터 넘겨받을 데이타
*
****************************************************************************/
if (!$intO_NO)
{
	goErrMsg("결제내역이 존재하지 않습니다.");
	$db->disConnect();
	exit;
}

$orderMgr->setO_NO($intO_NO);
$orderRow = $orderMgr->getOrderView($db);

$orderSettleRow = $orderMgr->getOrderSettleView($db);

if (!$TrCode){
	$TrCode = trim($_POST["trcode"]);                   //거래코드
}

/* 결제종류 */
switch ($orderRow['O_SETTLE']){
	case "C":
		$PayKind = "01";
	break;
	case "A":
		$PayKind = "02";
		if ($orderSettleRow['OS_CARD_CODE']) $PayKind = "04";
	break;
	case "T":
		$PayKind = "03";
	break;
}


$RetailerId = $S_PG_SITE_CODE;			//상점ID

$DealTime = SUBSTR(str_replace("-","",$orderRow['O_REG_DT']),0,8);				//결제일자

$SendNo = $orderSettleRow['OS_ES_SENDNO'];					//거래고유번호

$IdNo = trim($_POST["id_no"]);						//주민등록번호

$mod_type = $_POST["mod_type"];


/****************************************************************************
*
* [3] 데이타의 유효성을 검사합니다.
*
****************************************************************************/
$ERRMSG = "";

if( empty( $TrCode ) || $TrCode == "" )
{
	$ERRMSG .= "거래코드 입력여부 확인요망 <br>";		//거래코드
}

if( empty( $PayKind ) || $PayKind == "" )
{
	$ERRMSG .= "결제종류 입력여부 확인요망 <br>";		//결제종류
}

if( empty( $RetailerId ) || $RetailerId == "" )
{
	$ERRMSG .= "상점아이디 입력여부 확인요망 <br>";		//상점아이디
}

if( empty( $DealTime ) || $DealTime == "" )
{
	$ERRMSG .= "결제일자 입력여부 확인요망 <br>";		//결제시간
}

if( empty( $SendNo ) || $SendNo == "" )
{
	$ERRMSG .= "거래고유번호 입력여부 확인요망 <br>";	//거래고유번호
}

if ($ERRMSG){
	goErrMsg($ERRMSG);
	$db->disConnect();
	exit;
}

if( strlen($ERRMSG) == 0 )
{
	/****************************************************************************
    * TrCode = "E100" 발송완료
	* TrCode = "E200" 구매확인
	* TrCode = "E300" 구매거절
	* TrCode = "E400" 결제취소
	****************************************************************************/

	/****************************************************************************
	*
	* [4] 발송완료/구매확인/구매거절/결제취소요청 (E100/E101)/(E200/E201)/(E300/E301)/(E400/E401)
	* 
	* -- 데이터 길이는 매뉴얼 참고
	* 
	* -- 발송완료 요청 전문 포멧
	* + 데이터길이(6) + 자체 ESCROW 구분(1) + 데이터
	* + 데이터 포멧(데이터 구분은 "|"로 한다.)
	* 거래코드(10)	| 결제종류(2)	| 업체ID(20)	| 주민등록번호(13) | 
	* 결제일자(8)	| 거래고유번호(6)	| 
	* 
	* -- 발송완료 응답 전문 포멧
	* + 데이터길이(6) + 데이터
	* + 데이터 포멧(데이터 구분은 "|"로 한다.
	* 거래코드(10)	|결제종류(2)	| 업체ID(20)	| 결과코드(2)	| 결과 메시지(100)	| 
	*    
	*****************************************************************************/

	$ENCTYPE = "E";

	/****************************************************************************
	* 전송 전문 Make
	****************************************************************************/
	
	$sDataMsg = $ENCTYPE.
		$TrCode."|".
		$PayKind."|".
		$RetailerId."|".
		$IdNo."|".
		$DealTime."|".
		$SendNo."|";

	$sSendMsg = sprintf( "%06d%s", strlen( $sDataMsg ), $sDataMsg );
	
	/****************************************************************************
	* 
	* 전송 메세지 프린트
	* 
	****************************************************************************/
	
	if( $IsDebug == 1 )
	{
		print $sSendMsg."<br>";
	}

	/****************************************************************************
	* 
	* 암호화Process와 연결을 하고 승인 데이터 송수신
	* 
	****************************************************************************/
	
	$fp = fsockopen( $LOCALADDR, $LOCALPORT , &$errno, &$errstr, $CONN_TIMEOUT );
	
	
	if( !$fp )
	{
		/** 연결 실패로 인한 거래실패 메세지 전송 **/
		
		$rSuccYn = "n";
		$rResMsg = "연결 실패로 인한 거래실패";
	}
	else 
	{
		/** 연결에 성공하였으므로 데이터를 받는다. **/
		
		$rResMsg = "연결에 성공하였으므로 데이터를 받는다.";
		
		
		/** 승인 전문을 암호화Process로 전송 **/
		
		fputs( $fp, $sSendMsg );
		
		socket_set_timeout($fp, $READ_TIMEOUT);
		
		/** 최초 6바이트를 수신해 데이터 길이를 체크한 후 데이터만큼만 받는다. **/
		
		$sRecvLen = fgets( $fp, 7 );
		$sRecvMsg = fgets( $fp, $sRecvLen + 1 );
	
		/****************************************************************************
		*
		* 데이터 값이 정상적으로 넘어가지 않을 경우 이부분을 수정하여 주시기 바랍니다.
		* PHP 버전에 따라 수신 데이터 길이 체크시 페이지오류가 발생할 수 있습니다
		* 에러메세지:수신 데이터(길이) 체크 에러 통신오류에 의한 승인 실패
		* 데이터 길이 체크 오류시 아래와 같이 변경하여 사용하십시오
		* $sRecvLen = fgets( $fp, 6 );
		* $sRecvMsg = fgets( $fp, $sRecvLen );
		*
		****************************************************************************/

		/** 소켓 close **/
		
		fclose( $fp );
	}
	
	/****************************************************************************
	* 
	* 수신 메세지 프린트
	* 
	****************************************************************************/
	
	if( $IsDebug == 1 )	
	{
		print $sRecvMsg."<br>";
	}
	
	if( strlen( $sRecvMsg ) == $sRecvLen )
	{
		/** 수신 데이터(길이) 체크 정상 **/
		
		$RecvValArray = array();
		$RecvValArray = explode( "|", $sRecvMsg );
		
		$rTrCode        = $RecvValArray[0];
		$rPayKind       = $RecvValArray[1];
		$rRetailerId    = $RecvValArray[2];
		$rSuccYn        = $RecvValArray[3];
		$rResMsg        = $RecvValArray[4];
		
		/****************************************************************************
		*
		* 에스크로 통신 결과가 정상적으로 수신되었으므로 DB 작업을 할 경우 
		* 결과페이지로 데이터를 전송하기 전 이부분에서 하면된다.
		*
		* TrCode = "E101" 발송완료응답
		* TrCode = "E201" 구매확인응답
		* TrCode = "E301" 구매거절응답
		* TrCode = "E401" 취소요청응답
		*
		* 여기서 DB 작업을 해 주세요.
		* 주의) $rSuccYn 값이 'y' 일경우 에스크로배송등록및구매확인성공
		* 주의) $rSuccYn 값이 'n' 일경우 에스크로배송등록및구매확인실패
		* DB 작업을 하실 경우 $rSuccYn 값이 'y' 또는 'n' 일경우에 맞게 작업하십시오. 
		*
		****************************************************************************/
		
		if ($rTrCode == "E401"){
			$bSucc = "false";
			
			if ($rSuccYn == "y"){
				$bSucc = "";
				
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
				
				if ( $mod_type == "STE2" || $mod_type == "STE3")
				{
					$orderMgr->setO_CEL_NO($strOrderSettleCelNo);
					$orderMgr->setO_CEL_MEMO($_POST[ "mod_desc"      ]);
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
				}

				if ( $mod_type == "STE4")
				{
					$orderMgr->setO_CEL_STATUS("Y");
					$orderMgr->getOrderCancelStatusUpdate($db);
				}

				if ( $mod_type == "STE5")
				{
					$orderMgr->setO_STATUS("C");
					$orderMgr->setO_CEL_NO($strOrderSettleCelNo);
					$orderMgr->setO_CEL_MEMO($_POST["mod_desc"]);
					$orderMgr->setO_RETURN_BANK("");
					$orderMgr->setO_RETURN_ACC("");
					$orderMgr->setO_RETURN_NAME("");
					$orderMgr->setO_CEL_STATUS("Y");

					$orderMgr->setOS_STATUS("C");
					$orderMgr->setOS_CEL_NO($strOrderSettleCelNo);
					$result = $orderMgr->getOrderSettleCancelStatusUpdate($db);

					if (!$result) {
						$bSucc		= "false";
						$bSuccText	= "가상계좌 결제정보 update";
					}

					$result = $orderMgr->getOrderCancelUpdate($db);
					if (!$result) {
						$bSucc		= "false";
						$bSuccText	= "가상계좌해지 취소정보 update";
					}
				}
			} else {
				$bSucc = "false";
				$rResMsg = iconv("euc-kr","utf-8",$rResMsg);
			}
		} else if($rTrCode == "E201"){
			if ($rSuccYn == "y")
			{
				
				/* 구매완료 */
				$bSucc = "";
				$orderMgr->setO_STATUS("E");
				$result = $orderMgr->getOrderStatusUpdate($db);

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

				
				$strMsg = "선택하신 주문정보가 [구매확정]으로 변경되었습니다.";
				if (!$result) {
					$strMsg == "구매확정 update 오류";
				}
				
				goPopReflash($strMsg);
				$db->disConnect();
				exit;
			} else {
				$bSucc = "false";
				$rResMsg = iconv("euc-kr","utf-8",$rResMsg);
			}
		} else if($rTrCode == "E101"){
			/* 발송완료 */
			if ($rSuccYn == "y") $bSucc = "";
			else {
				$bSucc = "false";
				$rResMsg = iconv("euc-kr","utf-8",$rResMsg);
			}
		} else if($rTrCode == "E301"){
			/* 구매거절 */
			if ($rSuccYn == "y") {
				$bSucc = "";
				
				include MALL_HOME."/web/frwork/act/payCancel.php";

				goPopReflash("구매거절이 등록되었습니다.");
				$db->disConnect();
				exit;


			} else {
				$bSucc = "false";
				$rResMsg = iconv("euc-kr","utf-8",$rResMsg);
			}
		}
		
	}
	else
	{
		/** 수신 데이터(길이) 체크 에러시 통신오류에 의한 승인 실패로 간주 **/
		$bSucc = "false";		
		$rSuccYn = "n";
		$rResMsg = "수신 데이터(길이) 체크 에러 통신오류에 의한 승인 실패";
	}
}
else
{
	$bSucc = "false";
	$rSuccYn = "n";
	$rResMsg = iconv("euc-kr","utf-8",$ERRMSG);
}


if ($bSucc == "false"){
	if (!$rResMsg) $rResMsg = $bSuccText;
	goErrMsg($rResMsg);
	$db->disConnect();
	exit;
}


	if ($userPage != "A")
	{
?>
<html>
<head>
</head>
<body onload="javascript:frmAGS_escrow_ing.submit();">
<form name=frmAGS_escrow_ing method=post action="./index.php">
<input type=hidden name=rTrCode value="<?=$rTrCode?>">
<input type=hidden name=rPayKind value="<?=$rPayKind?>">
<input type=hidden name=rRetailerId value="<?=$rRetailerId?>">
<input type=hidden name=rSuccYn value="<?=$rSuccYn?>">
<input type=hidden name=rResMsg value="<?=$rResMsg?>">

<input type="hidden" name="oNo"				  value="<?= $intO_NO		?>">  
<input type="hidden" name="menuType"		  value="order">					
<input type="hidden" name="mode"			  value="act">					 
<input type="hidden" name="act"				  value="orderCancel">
<input type="hidden" name="mod_type"          value="<?=$mod_type		?>">     

</form>
</body>
</html>
<?}?>