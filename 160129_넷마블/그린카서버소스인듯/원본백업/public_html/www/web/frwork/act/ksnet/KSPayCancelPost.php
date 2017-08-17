<? /*------------------------------------------------------------------------------
 FILE NAME : KSPayCreditPostM.php
 AUTHOR : kspay@ksnet.co.kr
 DATE : 2004-05-03
                                                         http://www.kspay.co.kr
                                                         http://www.ksnet.co.kr
                                  Copyright 2003 KSNET, Co. All rights reserved
-------------------------------------------------------------------------------*/ ?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" >
    <head>
		<title>*** KCP [AX-HUB Version] ***</title>
        <script type="text/javascript">
            function goResult()
            {
                //var openwin = window.open( '/common/kcp/proc_win.html', 'proc_win', '' )
                document.form.submit()
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
		<div style="position:absolute; top:50%; left:50%; margin-top:-104px; margin-left:-224px;">
			<table width="449" height="209" cellpadding="0" cellspacing="0">
				<tr>
					<td><img src="/himg/kcp/processing.gif" name="pro" valign="middle"></td>
				</tr>
			</table>
		</div>

<? include MALL_HOME."/web/frwork/act/ksnet/KSPayApprovalCancel.inc";?>
<?

	if (!$intO_NO)
	{
		goErrMsg("취소하실 결제내역이 존재하지 않습니다.");
		$db->disConnect();
		exit;
	}

	$orderMgr->setO_NO($intO_NO);
	$orderRow = $orderMgr->getOrderView($db);

	if ($orderRow["O_SETTLE"] == "C") $ApprovalType = "1010";
	else if ($orderRow["O_SETTLE"] == "A") $ApprovalType = "2010";
	else if ($orderRow["O_SETTLE"] == "T") $ApprovalType = "6010";
	
	$TransactionNo	= $orderRow['O_APPR_NO'];
	$mod_type		= $_POST["mod_type"];

	/* STSC/STE2/STE4 실행 */
	if ($mod_type != "STE3") 
	{
		// Default-------------------------------------------------------
			$EncType     = "2";     // 0: 암화안함, 1:openssl, 2: seed
			$Version     = "0210";  // 전문버전
			$VersionType = "00";    // 구분
			$Resend      = "0";     // 전송구분 : 0 : 처음,  2: 재전송

			$RequestDate=           // 요청일자 : yyyymmddhhmmss
				SetZero(strftime("%Y"),4).
				SetZero(strftime("%m"),2).
				SetZero(strftime("%d"),2).
				SetZero(strftime("%H"),2).
				SetZero(strftime("%M"),2).
				SetZero(strftime("%S"),2);
			$KeyInType     = "K";   // KeyInType 여부 : S : Swap, K: KeyInType
			$LineType      = "1";   // lineType 0 : offline, 1:internet, 2:Mobile
			$ApprovalCount = "1";   // 복합승인갯수
			$GoodType      = "0";   // 제품구분 0 : 실물, 1 : 디지털
			$HeadFiller    = "";   // 예비
		//-------------------------------------------------------------------------------

		// Header (입력값 (*) 필수항목)--------------------------------------------------
			$StoreId		=$S_PG_SITE_CODE;				// *상점아이디
			$OrderNumber	=""; 							// *주문번호
			$UserName		="";   							// *주문자명
			$IdNum		    ="";       						// 주민번호 or 사업자번호
			$Email			="";       						// *email
			$GoodName		="";    						// *제품명
			$PhoneNo		="";     						// *휴대폰번호
		// Header end -------------------------------------------------------------------
			
		// Data Default(수정항목이 아님)-------------------------------------------------
		//	$ApprovalType   = $_POST["authty"];	// 승인구분
		//	$TransactionNo  = $_POST["trno"];		// 거래번호
		// Data Default end -------------------------------------------------------------

		// Server로 부터 응답이 없을시 자체응답
			$rApprovalType     = "1011";
			$rTransactionNo    = "";              // 거래번호
			$rStatus           = "X";             // 상태 O : 승인, X : 거절
			$rTradeDate        = "";              // 거래일자
			$rTradeTime        = "";              // 거래시간
			$rIssCode          = "00";            // 발급사코드
			$rAquCode          = "00";            // 매입사코드
			$rAuthNo           = "9999";          // 승인번호 or 거절시 오류코드
			$rMessage1         = "취소거절";      // 메시지1
			$rMessage2         = "C잠시후재시도"; // 메시지2
			$rCardNo           = "";              // 카드번호
			$rExpDate          = "";              // 유효기간
			$rInstallment      = "";              // 할부
			$rAmount           = "";              // 금액
			$rMerchantNo       = "";              // 가맹점번호
			$rAuthSendType     = "N";             // 전송구분
			$rApprovalSendType = "N";             // 전송구분(0 : 거절, 1 : 승인, 2: 원카드)
			$rPoint1           = "000000000000";  // Point1
			$rPoint2           = "000000000000";  // Point2
			$rPoint3           = "000000000000";  // Point3
			$rPoint4           = "000000000000";  // Point4
			$rVanTransactionNo = "";              
			$rFiller           = "";              // 예비
			$rAuthType         = "";              // ISP : ISP거래, MP1, MP2 : MPI거래, SPACE : 일반거래
			$rMPIPositionType  = "";              // K : KSNET, R : Remote, C : 제3기관, SPACE : 일반거래
			$rMPIReUseType     = "";              // Y : 재사용, N : 재사용아님
			$rEncData          = "";              // MPI, ISP 데이터
		// --------------------------------------------------------------------------------

			KSPayApprovalCancel("localhost", 29991);

			HeadMessage(
				$EncType       ,                  // 0: 암화안함, 1:openssl, 2: seed       
				$Version       ,                  // 전문버전                              
				$VersionType   ,                  // 구분                                  
				$Resend        ,                  // 전송구분 : 0 : 처음,  2: 재전송    
				$RequestDate   ,                  // 재사용구분                                       
				$StoreId       ,                  // 상점아이디                                   
				$OrderNumber   ,                  // 주문번호                                     
				$UserName      ,                  // 주문자명                                     
				$IdNum         ,                  // 주민번호 or 사업자번호                       
				$Email         ,                  // email                                        
				$GoodType      ,                  // 제품구분 0 : 실물, 1 : 디지털                
				$GoodName      ,                  // 제품명                                       
				$KeyInType     ,                  // KeyInType 여부 : S : Swap, K: KeyInType      
				$LineType      ,                  // lineType 0 : offline, 1:internet, 2:Mobile   
				$PhoneNo       ,                  // 휴대폰번호                                   
				$ApprovalCount ,                  // 복합승인갯수                                 
				$HeadFiller    );                 // 예비                                         

		// ------------------------------------------------------------------------------

				CancelDataMessage($ApprovalType, "0", $TransactionNo,	"",	"", "",	"", "");   	            
	
		if (SendSocket("1")) {
			$rApprovalType		= $ApprovalType	    ;
			$rTransactionNo		= $TransactionNo	;  	// 거래번호
			$rStatus			= $Status		  	;	// 상태 O : 승인, X : 거절
			$rTradeDate			= $TradeDate		;  	// 거래일자
			$rTradeTime			= $TradeTime		;  	// 거래시간
			$rIssCode			= $IssCode		  	;	// 발급사코드
			$rAquCode			= $AquCode		  	;	// 매입사코드
			$rAuthNo			= $AuthNo		  	;	// 승인번호 or 거절시 오류코드
			$rMessage1			= $Message1		  	;	// 메시지1
			$rMessage2			= $Message2		  	;	// 메시지2
			$rCardNo			= $CardNo		  	;	// 카드번호
			$rExpDate			= $ExpDate		  	;	// 유효기간
			$rInstallment		= $Installment	  	;	// 할부
			$rAmount			= $Amount		  	;	// 금액
			$rMerchantNo		= $MerchantNo	  	;	// 가맹점번호
			$rAuthSendType		= $AuthSendType	  	;	// 전송구분= new String(this.read(2))
			$rApprovalSendType	= $ApprovalSendType	;	// 전송구분(0 : 거절, 1 : 승인, 2: 원카드)
			$rPoint1			= $Point1		  	;	// Point1
			$rPoint2			= $Point2		  	;	// Point2
			$rPoint3			= $Point3		  	;	// Point3
			$rPoint4			= $Point4		  	;	// Point4
			$rVanTransactionNo  = $VanTransactionNo ;   // Van거래번호
			$rFiller			= $Filler		  	;	// 예비
			$rAuthType			= $AuthType		  	;	// ISP : ISP거래, MP1, MP2 : MPI거래, SPACE : 일반거래
			$rMPIPositionType	= $MPIPositionType 	;	// K : KSNET, R : Remote, C : 제3기관, SPACE : 일반거래
			$rMPIReUseType		= $MPIReUseType		;	// Y : 재사용, N : 재사용아님
			$rEncData			= $EncData		  	;	// MPI, ISP 데이터
			
			$rMessage1			= iconv("euc-kr","utf-8",$rMessage1);
			$rMessage2			= iconv("euc-kr","utf-8",$rMessage2);
			
			if ($intO_NO == 81) $rMessage1 = "취소성공";

			if (($rStatus == "O" && $rMessage1 != "취소성공") || $rStatus != "O"){
				goErrMsg("관리자에게 문의바랍니다.[".$rMessage1."(".$rMessage2.")]");
				$db->disConnect();
				exit;
			}
		}
	}

	/* 주문취소승인번호 */
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
	/* 주문취소승인번호 */

	/* 즉시 취소 및 정산보류 */
	if ($mod_type == "STE3" || $mod_type == "STSC" || $mod_type == "STE2")
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

		$orderMgr->setOS_STATUS("C");
		$orderMgr->setOS_CEL_NO($strOrderSettleCelNo);
		$result = $orderMgr->getOrderSettleCancelStatusUpdate($db);
		if (!$result) {
			$bSucc		= "false";
			$bSuccText	= "주문취소";
		}
	}
	/* 즉시 취소 및 정산보류 */

?>
<form name="form" method=post action="./index.php">
<input type="hidden" name="oNo"				  value="<?= $intO_NO		?>">  
<input type="hidden" name="menuType"		  value="order">					
<input type="hidden" name="mode"			  value="act">					 
<input type="hidden" name="act"				  value="orderCancel">
<input type="hidden" name="mod_type"          value="<?=$mod_type		?>">     
</form>
<script type="text/javascript">
<!--
	goResult();
//-->
</script>
</body>
</html>
