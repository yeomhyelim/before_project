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
<?
/********************************************************************************
*
* 파일명 : AGS_pay_ing.php
* 최종수정일자 : 2012/04/30
*
* 올더게이트 플러그인에서 리턴된 데이타를 받아서 소켓결제요청을 합니다.
*
* Copyright AEGIS ENTERPRISE.Co.,Ltd. All rights reserved.
*
*
*  ※ 유의사항 ※
*  1.  "|"(파이프) 값은 결제처리 중 구분자로 사용하는 문자이므로 결제 데이터에 "|"이 있을경우
*   결제가 정상적으로 처리되지 않습니다.(수신 데이터 길이 에러 등의 사유)
********************************************************************************/
	
	
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
	$agspay = new agspay40;



	/****************************************************************************
	*
	* [3] AGS_pay.html 로 부터 넘겨받을 데이타
	*
	****************************************************************************/
	
	/*결제 지불 요청 정보 설정*/   
	$ordr_idxx				= $_POST["ordr_idxx"];			// 쇼핑몰 주문번호
    $intO_NO				= $_POST["order_no"];			// 주문번호
	
	$aryCartNo				= $_POST["cartNo"];				// 주문상품정보
    $aryCouponUseIssueNo	= $_POST["couponUseIssueNo"];	// 사용한 쿠폰 발행번호
	/*결제 지불 요청 정보 설정*/   

	foreach($_POST as $key => $row) $_POST[$key] = iconv("UTF-8", "EUC-KR", $row);
	/*공통사용*/
	//$agspay->SetValue("AgsPayHome","C:/htdocs/agspay");			//올더게이트 결제설치 디렉토리 (상점에 맞게 수정)
	$agspay->SetValue("AgsPayHome",$S_DOCUMENT_ROOT.$S_SHOP_HOME."/logs/agsPay");			//올더게이트 결제설치 디렉토리 (상점에 맞게 수정)
	$agspay->SetValue("StoreId",trim($_POST["StoreId"]));		//상점아이디
	$agspay->SetValue("log","true");							//true : 로그기록, false : 로그기록안함.
	$agspay->SetValue("logLevel","INFO");						//로그레벨 : DEBUG, INFO, WARN, ERROR, FATAL (해당 레벨이상의 로그만 기록됨)
	$agspay->SetValue("UseNetCancel","true");					//true : 망취소 사용. false: 망취소 미사용
	$agspay->SetValue("Type", "Pay");							//고정값(수정불가)
	$agspay->SetValue("RecvLen", 7);							//수신 데이터(길이) 체크 에러시 6 또는 7 설정. 
	
	$agspay->SetValue("AuthTy",trim($_POST["AuthTy"]));			//결제형태
	$agspay->SetValue("SubTy",trim($_POST["SubTy"]));			//서브결제형태
	$agspay->SetValue("OrdNo",trim($_POST["OrdNo"]));			//주문번호
	$agspay->SetValue("Amt",trim($_POST["Amt"]));				//금액
	$agspay->SetValue("UserEmail",trim($_POST["UserEmail"]));	//주문자이메일
	$agspay->SetValue("ProdNm",trim($_POST["ProdNm"]));			//상품명
	$AGS_HASHDATA 		= trim( $_POST["AGS_HASHDATA"] );		//암호화 HASHDATA
	$AGS_HASHDATA		= iconv("UTF-8", "EUC-KR",$AGS_HASHDATA);

	/*신용카드&가상계좌사용*/
	$agspay->SetValue("MallUrl",trim($_POST["MallUrl"]));		//MallUrl(무통장입금) - 상점 도메인 가상계좌추가
	$agspay->SetValue("UserId",trim($_POST["UserId"]));			//회원아이디

	/*신용카드사용*/
	$agspay->SetValue("OrdNm",trim($_POST["OrdNm"]));			//주문자명
	$agspay->SetValue("OrdPhone",trim($_POST["OrdPhone"]));		//주문자연락처
	$agspay->SetValue("OrdAddr",trim($_POST["OrdAddr"]));		//주문자주소 가상계좌추가
	$agspay->SetValue("RcpNm",trim($_POST["RcpNm"]));			//수신자명
	$agspay->SetValue("RcpPhone",trim($_POST["RcpPhone"]));		//수신자연락처
	$agspay->SetValue("DlvAddr",trim($_POST["DlvAddr"]));		//배송지주소
	$agspay->SetValue("Remark",trim($_POST["Remark"]));			//비고
	$agspay->SetValue("DeviId",trim($_POST["DeviId"]));			//단말기아이디
	$agspay->SetValue("AuthYn",trim($_POST["AuthYn"]));			//인증여부
	$agspay->SetValue("Instmt",trim($_POST["Instmt"]));			//할부개월수
	$agspay->SetValue("UserIp",$_SERVER["REMOTE_ADDR"]);		//회원 IP

	/*신용카드(ISP)*/
	$agspay->SetValue("partial_mm",trim($_POST["partial_mm"]));		//일반할부기간
	$agspay->SetValue("noIntMonth",trim($_POST["noIntMonth"]));		//무이자할부기간
	$agspay->SetValue("KVP_CURRENCY",trim($_POST["KVP_CURRENCY"]));	//KVP_통화코드
	$agspay->SetValue("KVP_CARDCODE",trim($_POST["KVP_CARDCODE"]));	//KVP_카드사코드
	$agspay->SetValue("KVP_SESSIONKEY",$_POST["KVP_SESSIONKEY"]);	//KVP_SESSIONKEY
	$agspay->SetValue("KVP_ENCDATA",$_POST["KVP_ENCDATA"]);			//KVP_ENCDATA
	$agspay->SetValue("KVP_CONAME",trim($_POST["KVP_CONAME"]));		//KVP_카드명
	$agspay->SetValue("KVP_NOINT",trim($_POST["KVP_NOINT"]));		//KVP_무이자=1 일반=0
	$agspay->SetValue("KVP_QUOTA",trim($_POST["KVP_QUOTA"]));		//KVP_할부개월

	/*신용카드(안심)*/
	$agspay->SetValue("CardNo",trim($_POST["CardNo"]));			//카드번호
	$agspay->SetValue("MPI_CAVV",$_POST["MPI_CAVV"]);			//MPI_CAVV
	$agspay->SetValue("MPI_ECI",$_POST["MPI_ECI"]);				//MPI_ECI
	$agspay->SetValue("MPI_MD64",$_POST["MPI_MD64"]);			//MPI_MD64

	/*신용카드(일반)*/
	$agspay->SetValue("ExpMon",trim($_POST["ExpMon"]));				//유효기간(월)
	$agspay->SetValue("ExpYear",trim($_POST["ExpYear"]));			//유효기간(년)
	$agspay->SetValue("Passwd",trim($_POST["Passwd"]));				//비밀번호
	$agspay->SetValue("SocId",trim($_POST["SocId"]));				//주민등록번호/사업자등록번호

	/*계좌이체사용*/
	$agspay->SetValue("ICHE_OUTBANKNAME",trim($_POST["ICHE_OUTBANKNAME"]));		//이체은행명
	$agspay->SetValue("ICHE_OUTACCTNO",trim($_POST["ICHE_OUTACCTNO"]));			//이체계좌번호
	$agspay->SetValue("ICHE_OUTBANKMASTER",trim($_POST["ICHE_OUTBANKMASTER"]));	//이체계좌소유주
	$agspay->SetValue("ICHE_AMOUNT",trim($_POST["ICHE_AMOUNT"]));				//이체금액

	/*핸드폰사용*/
	$agspay->SetValue("HP_SERVERINFO",trim($_POST["HP_SERVERINFO"]));	//SERVER_INFO(핸드폰결제)
	$agspay->SetValue("HP_HANDPHONE",trim($_POST["HP_HANDPHONE"]));		//HANDPHONE(핸드폰결제)
	$agspay->SetValue("HP_COMPANY",trim($_POST["HP_COMPANY"]));			//COMPANY(핸드폰결제)
	$agspay->SetValue("HP_ID",trim($_POST["HP_ID"]));					//HP_ID(핸드폰결제)
	$agspay->SetValue("HP_SUBID",trim($_POST["HP_SUBID"]));				//HP_SUBID(핸드폰결제)
	$agspay->SetValue("HP_UNITType",trim($_POST["HP_UNITType"]));		//HP_UNITType(핸드폰결제)
	$agspay->SetValue("HP_IDEN",trim($_POST["HP_IDEN"]));				//HP_IDEN(핸드폰결제)
	$agspay->SetValue("HP_IPADDR",trim($_POST["HP_IPADDR"]));			//HP_IPADDR(핸드폰결제)

	/*ARS사용*/
	$agspay->SetValue("ARS_NAME",trim($_POST["ARS_NAME"]));				//ARS_NAME(ARS결제)
	$agspay->SetValue("ARS_PHONE",trim($_POST["ARS_PHONE"]));			//ARS_PHONE(ARS결제)

	/*가상계좌사용*/
	$agspay->SetValue("VIRTUAL_CENTERCD",trim($_POST["VIRTUAL_CENTERCD"]));	//은행코드(가상계좌)
	$agspay->SetValue("VIRTUAL_DEPODT",trim($_POST["VIRTUAL_DEPODT"]));		//입금예정일(가상계좌)
	$agspay->SetValue("ZuminCode",trim($_POST["ZuminCode"]));				//주민번호(가상계좌)
	$agspay->SetValue("MallPage",trim($_POST["MallPage"]));					//상점 입/출금 통보 페이지(가상계좌)
	$agspay->SetValue("VIRTUAL_NO",trim($_POST["VIRTUAL_NO"]));				//가상계좌번호(가상계좌)

	/*에스크로사용*/
	$agspay->SetValue("ES_SENDNO",trim($_POST["ES_SENDNO"]));				//에스크로전문번호

	/*계좌이체(소켓) 결제 사용 변수*/
	$agspay->SetValue("ICHE_SOCKETYN",trim($_POST["ICHE_SOCKETYN"]));			//계좌이체(소켓) 사용 여부
	$agspay->SetValue("ICHE_POSMTID",trim($_POST["ICHE_POSMTID"]));				//계좌이체(소켓) 이용기관주문번호
	$agspay->SetValue("ICHE_FNBCMTID",trim($_POST["ICHE_FNBCMTID"]));			//계좌이체(소켓) FNBC거래번호
	$agspay->SetValue("ICHE_APTRTS",trim($_POST["ICHE_APTRTS"]));				//계좌이체(소켓) 이체 시각
	$agspay->SetValue("ICHE_REMARK1",trim($_POST["ICHE_REMARK1"]));				//계좌이체(소켓) 기타사항1
	$agspay->SetValue("ICHE_REMARK2",trim($_POST["ICHE_REMARK2"]));				//계좌이체(소켓) 기타사항2
	$agspay->SetValue("ICHE_ECWYN",trim($_POST["ICHE_ECWYN"]));					//계좌이체(소켓) 에스크로여부
	$agspay->SetValue("ICHE_ECWID",trim($_POST["ICHE_ECWID"]));					//계좌이체(소켓) 에스크로ID
	$agspay->SetValue("ICHE_ECWAMT1",trim($_POST["ICHE_ECWAMT1"]));				//계좌이체(소켓) 에스크로결제금액1
	$agspay->SetValue("ICHE_ECWAMT2",trim($_POST["ICHE_ECWAMT2"]));				//계좌이체(소켓) 에스크로결제금액2
	$agspay->SetValue("ICHE_CASHYN",trim($_POST["ICHE_CASHYN"]));				//계좌이체(소켓) 현금영수증발행여부
	$agspay->SetValue("ICHE_CASHGUBUN_CD",trim($_POST["ICHE_CASHGUBUN_CD"]));	//계좌이체(소켓) 현금영수증구분
	$agspay->SetValue("ICHE_CASHID_NO",trim($_POST["ICHE_CASHID_NO"]));			//계좌이체(소켓) 현금영수증신분확인번호

	/*계좌이체-텔래뱅킹(소켓) 결제 사용 변수*/
	$agspay->SetValue("ICHEARS_SOCKETYN", trim($_POST["ICHEARS_SOCKETYN"]));	//텔레뱅킹계좌이체(소켓) 사용 여부
	$agspay->SetValue("ICHEARS_ADMNO", trim($_POST["ICHEARS_ADMNO"]));			//텔레뱅킹계좌이체 승인번호       
	$agspay->SetValue("ICHEARS_POSMTID", trim($_POST["ICHEARS_POSMTID"]));		//텔레뱅킹계좌이체 이용기관주문번호
	$agspay->SetValue("ICHEARS_CENTERCD", trim($_POST["ICHEARS_CENTERCD"]));	//텔레뱅킹계좌이체 은행코드      
	$agspay->SetValue("ICHEARS_HPNO", trim($_POST["ICHEARS_HPNO"]));			//텔레뱅킹계좌이체 휴대폰번호   
	
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
			
	/*if (trim($_POST["Amt"]) != STR_REPLACE(',','',NUMBER_FORMAT($orderRow[O_TOT_SPRICE]))){
		goErrMsg("해당결제내역의 결제금액이 일치하지 않습니다. 비정상적인 결제내역입니다.");
		$db->disConnect();
		exit;	
	}*/


	/*결제 지불 요청 정보 설정*/   

	/****************************************************************************
	*
	* [4] 올더게이트 결제서버로 결제를 요청합니다.
	*
	****************************************************************************/
	$agspay->startPay();
	
	/****************************************************************************
	*
	* [5] 결제결과에 따른 상점DB 저장 및 기타 필요한 처리작업을 수행하는 부분입니다.
	*
	*	아래의 결과값들을 통하여 각 결제수단별 결제결과값을 사용하실 수 있습니다.
	*	
	*	-- 공통사용 --
	*	업체ID : $agspay->GetResult("rStoreId")
	*	주문번호 : $agspay->GetResult("rOrdNo")
	*	상품명 : $agspay->GetResult("rProdNm")
	*	거래금액 : $agspay->GetResult("rAmt")
	*	성공여부 : $agspay->GetResult("rSuccYn") (성공:y 실패:n)
	*	결과메시지 : $agspay->GetResult("rResMsg")
	*
	*	1. 신용카드
	*	
	*	전문코드 : $agspay->GetResult("rBusiCd")
	*	거래번호 : $agspay->GetResult("rDealNo")
	*	승인번호 : $agspay->GetResult("rApprNo")
	*	할부개월 : $agspay->GetResult("rInstmt")
	*	승인시각 : $agspay->GetResult("rApprTm")
	*	카드사코드 : $agspay->GetResult("rCardCd")
	*
	*	2.계좌이체(인터넷뱅킹/텔레뱅킹)
	*	에스크로주문번호 : $agspay->GetResult("ES_SENDNO") (에스크로 결제시)
	*
	*	3.가상계좌
	*	가상계좌의 결제성공은 가상계좌발급의 성공만을 의미하며 입금대기상태로 실제 고객이 입금을 완료한 것은 아닙니다.
	*	따라서 가상계좌 결제완료시 결제완료로 처리하여 상품을 배송하시면 안됩니다.
	*	결제후 고객이 발급받은 계좌로 입금이 완료되면 MallPage(상점 입금통보 페이지(가상계좌))로 입금결과가 전송되며
	*	이때 비로소 결제가 완료되게 되므로 결제완료에 대한 처리(배송요청 등)은  MallPage에 작업해주셔야 합니다.
	*	결제종류 : $agspay->GetResult("rAuthTy") (가상계좌 일반 : vir_n 유클릭 : vir_u 에스크로 : vir_s)
	*	승인일자 : $agspay->GetResult("rApprTm")
	*	가상계좌번호 : $agspay->GetResult("rVirNo")
	*
	*	4.핸드폰결제
	*	핸드폰결제일 : $agspay->GetResult("rHP_DATE")
	*	핸드폰결제 TID : $agspay->GetResult("rHP_TID")
	*
	*	5.ARS결제
	*	ARS결제일 : $agspay->GetResult("rHP_DATE")
	*	ARS결제 TID : $agspay->GetResult("rHP_TID")
	*
	****************************************************************************/
	if($agspay->GetResult("rSuccYn") == "y")
	{ 

		/* 결제금액 확인 */
		$strSaveHashData = md5($S_PG_SITE_CODE . $orderRow["O_KEY"] . NUMBER_FORMAT($orderRow["O_TOT_SPRICE"])); 
		if ($strSaveHashData != iconv("EUC-KR", "UTF-8",$AGS_HASHDATA)){
			$bSucc = "false";
			$bSuccText	= "결제금액변조";
		}

		if ($bSucc != "false")
		{
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


			if($agspay->GetResult("AuthTy") == "virtual"){

				//가상계좌결제의 경우 입금이 완료되지 않은 입금대기상태(가상계좌 발급성공)이므로 상품을 배송하시면 안됩니다. 

				/* 가상계좌은행/계좌/예금주/마감일자 UPDATE */
				$orderMgr->setO_BANK($agspay->GetResult("VIRTUAL_CENTERCD"));
				$orderMgr->setO_BANK_ACC($agspay->GetResult("rVirNo"));
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
				// 결제성공에 따른 상점처리부분
				//echo ("결제가 성공처리되었습니다. [" . $agspay->GetResult("rSuccYn")."]". $agspay->GetResult("rResMsg").". " );
				

				/* 계좌이체 */
				if ($orderRow["O_SETTLE"] == "A"){
					
					/* 입금은행 UPDATE */
					$orderMgr->setO_BANK($agspay->GetResult("ICHE_OUTBANKNAME"));
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
			$strOrderApprNo = $agspay->GetResult("rApprNo");
			if($agspay->GetResult("AuthTy") != "card") {
				
				$strOrderApprNo = "A".date("Ymd").STRTOUPPER(getCode(5));
				$orderMgr->setOS_APPR_NO($strOrderApprNo);
				$intDupApprNoCnt = $orderMgr->getOrderDupApprNo($db);
				
				if ($intDupApprNoCnt > 0){
					$strFlag = false;

					while($strFlag == false){

						$strOrderApprNo = "A".date("Ymd").STRTOUPPER(getCode(5));
						$orderMgr->setOS_APPR_NO($strOrderApprNo);
						$intDupApprNoCnt = $orderMgr->getOrderDupApprNo($db);
						
						if($intDupApprNoCnt=="0"){
							$strFlag = true;
							break;
						}
					}			
				}
			}

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
			if($agspay->GetResult("AuthTy") == "virtual") {
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

			/* 결제완료시 상품별 배송 배송준비중으로 변경(2014.01.10) */
			if($agspay->GetResult("AuthTy") != "virtual" && $orderMgr->getO_STATUS() == "A") {
				$result = $orderMgr->getOrderCartDeliveryStatusUpdate($db);
				if (!$result) {
					$bSucc		= "false";
					$bSuccText	= "주문정보 상태 UPDATE ";
				}
			}
			
			/* 거래번호/에스크로전문번호 UPDATE*/
			$orderMgr->setOS_DEAL_NO($agspay->GetResult("rDealNo"));
			$orderMgr->setOS_ES_SENDNO($agspay->GetResult("ES_SENDNO"));
			$orderMgr->setOS_CARD_CODE("");
			if($agspay->GetResult("AuthTy") == "card") {
				$orderMgr->setOS_CARD_CODE($agspay->GetResult("rCardCd"));
			} else {
				$orderMgr->setOS_CARD_CODE($agspay->GetResult("rICHEARS_POSMTID")); //->계좌이체 텔레뱅킹 기관(에스크로 취소시 인터넷/텔레뱅킹구분)
			}
			$orderMgr->getOrderSettleDealUpdate($db);
			/* 승인데이터 INSERT */
			
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
			if ($agspay->GetResult("ES_SENDNO")){
				$orderMgr->setO_ESCROW("Y");
				$orderMgr->getOrderEscrowUpdate($db);
			}

			/* 입점몰일경우 shop_order so_order_status 값을 null로 처리 */
			if ($S_MALL_TYPE == "M"){
				$orderMgr->setO_STATUS("");
				$orderMgr->getOrderAccStatusUpdate($db);
			}

		}

	}else{
		// 결제실패에 따른 상점처리부분
		echo ("결제가 실패처리되었습니다. [" . iconv("euc-kr","utf-8",$agspay->GetResult("rSuccYn"))."]". iconv("euc-kr","utf-8",$agspay->GetResult("rResMsg")).". " );
	}

	/*******************************************************************
	* [6] 결제가 정상처리되지 못했을 경우 $agspay->GetResult("NetCancID") 값을 이용하여                                     
	* 결제결과에 대한 재확인요청을 할 수 있습니다.
	* 
	* 추가 데이터송수신이 발생하므로 결제가 정상처리되지 않았을 경우에만 사용하시기 바랍니다. 
	*
	* 사용방법 :
	* $agspay->checkPayResult($agspay->GetResult("NetCancID"));
	*                           
	*******************************************************************/
	
	/*
	$agspay->SetValue("Type", "Pay"); // 고정
	$agspay->checkPayResult($agspay->GetResult("NetCancID"));
	*/
	
	/*******************************************************************
	* [7] 상점DB 저장 및 기타 처리작업 수행실패시 강제취소                                      
	*   
	* $cancelReq : "true" 강제취소실행, "false" 강제취소실행안함.
	*
	* 결제결과에 따른 상점처리부분 수행 중 실패하는 경우    
	* 아래의 코드를 참조하여 거래를 취소할 수 있습니다.
	*	취소성공여부 : $agspay->GetResult("rCancelSuccYn") (성공:y 실패:n)
	*	취소결과메시지 : $agspay->GetResult("rCancelResMsg")
	*
	* 유의사항 :
	* 가상계좌(virtual)는 강제취소 기능이 지원되지 않습니다.
	*******************************************************************/
	
	// 상점처리부분 수행실패시 $cancelReq를 "true"로 변경하여 
	// 결제취소를 수행되도록 할 수 있습니다.
	// $cancelReq의 "true"값으로 변경조건은 상점에서 판단하셔야 합니다.
	
	$cancelReq = "false";
	if ($bSucc == "false") $cancelReq = "true";
	
	if($cancelReq == "true")
	{
		$agspay->SetValue("Type", "Cancel"); // 고정
		$agspay->SetValue("CancelMsg", "DB FAIL"); // 취소사유
		$agspay->startPay();

		/*##################### 자동취소처리 DB 처리 추가 #####################*/	
		$orderMgr->setO_STATUS("F");
		$orderMgr->getOrderStatusUpdate($db);
		/*##################### 자동취소처리 DB 처리 추가 #####################*/
	}
	

	/* PG사 결제시 주문 메일 발송*/
	if ($agspay->GetResult("rSuccYn") == "y" && $cancelReq != "true"){

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
//		if($SMS_INFO['S_SMS_USE']=="Y" && $S_SITE_LNG == "KR"):
//			$smsMoney = $smsFunc->getSmsMoneySelect($db); // 머니 체크
//			if($smsMoney['VAL'] > 0):
//				$smsCode			= "012";
//				$smsPhone			= str_replace("-","",$orderRow['O_J_HP']);		
//				$smsCallBackPhone	= $S_COM_PHONE;
//				$smsMsg				= $SMS_TEXT_LIST[$smsCode]['SM_TEXT'];
//				$smsMsg				= str_replace("{{상점명}}", $S_SITE_KNAME, $smsMsg);
//				$smsMsg				= str_replace("{{결제금액}}", getCurToPrice($orderRow['O_TOT_CUR_SPRICE'],$orderRow['O_USE_LNG']), $smsMsg);
//				$smsMsg				= str_replace("{{결제방법}}", $S_ARY_SETTLE_TYPE[$orderRow['O_SETTLE']], $smsMsg);	
//				if($SMS_TEXT_LIST[$smsCode]['SM_AUTO'] == "Y"): //  자동발송 사용..
//					$smsFunc->goSendSms($smsPhone, $smsCallBackPhone, $smsMsg);
//					$smsFunc->getSmsMoneyMinusUpdate($db); // 머니 -1
//				endif;
//			else:
//				// sms 머니 부족.. 부분 처리..
//			endif;
//		endif;
		/** 2013.04.18 SMS 전송 모듈 추가 **/
	}
	/* PG사 결제시 주문 메일 발송*/

?>
	<div style="position:absolute; top:50%; left:50%; margin-top:-104px; margin-left:-224px;">
		<table width="449" height="209" cellpadding="0" cellspacing="0">
			<tr>
				<td><img src="/himg/kcp/processing.gif" name="pro" valign="middle"></td>
			</tr>
		</table>
	</div>

    <form name="pay_info" method="post" action="./index.php">

		<!-- 각 결제 공통 사용 변수 -->
		<input type=hidden name=AuthTy value="<?=$agspay->GetResult("AuthTy")?>">		<!-- 결제형태 -->
		<input type=hidden name=SubTy value="<?=$agspay->GetResult("SubTy")?>">			<!-- 서브결제형태 -->
		<input type=hidden name=rStoreId value="<?=$agspay->GetResult("rStoreId")?>">	<!-- 상점아이디 -->
		<input type=hidden name=rOrdNo value="<?=$agspay->GetResult("rOrdNo")?>">		<!-- 주문번호 -->
		<input type=hidden name=rProdNm value="<?=$agspay->GetResult("ProdNm")?>">		<!-- 상품명 -->
		<input type=hidden name=rAmt value="<?=$agspay->GetResult("rAmt")?>">			<!-- 결제금액 -->
		<input type=hidden name=rOrdNm value="<?=$agspay->GetResult("OrdNm")?>">		<!-- 주문자명 -->
		<input type=hidden name=AGS_HASHDATA value="<?=$AGS_HASHDATA?>">				<!-- 암호화 HASHDATA -->

		<input type=hidden name=rSuccYn value="<?=$agspay->GetResult("rSuccYn")?>">	<!-- 성공여부 -->
		<input type=hidden name=rResMsg value="<?=$agspay->GetResult("rResMsg")?>">	<!-- 결과메시지 -->
		<input type=hidden name=rApprTm value="<?=$agspay->GetResult("rApprTm")?>">	<!-- 결제시간 -->

		<!-- 신용카드 결제 사용 변수 -->
		<input type=hidden name=rBusiCd value="<?=$agspay->GetResult("rBusiCd")?>">		<!-- (신용카드공통)전문코드 -->
		<input type=hidden name=rApprNo value="<?=$agspay->GetResult("rApprNo")?>">		<!-- (신용카드공통)승인번호 -->
		<input type=hidden name=rCardCd value="<?=$agspay->GetResult("rCardCd")?>">	<!-- (신용카드공통)카드사코드 -->
		<input type=hidden name=rDealNo value="<?=$agspay->GetResult("rDealNo")?>">			<!-- (신용카드공통)거래번호 -->

		<input type=hidden name=rCardNm value="<?=$agspay->GetResult("rCardNm")?>">	<!-- (안심클릭,일반사용)카드사명 -->
		<input type=hidden name=rMembNo value="<?=$agspay->GetResult("rMembNo")?>">	<!-- (안심클릭,일반사용)가맹점번호 -->
		<input type=hidden name=rAquiCd value="<?=$agspay->GetResult("rAquiCd")?>">		<!-- (안심클릭,일반사용)매입사코드 -->
		<input type=hidden name=rAquiNm value="<?=$agspay->GetResult("rAquiNm")?>">	<!-- (안심클릭,일반사용)매입사명 -->

		<!-- 계좌이체 결제 사용 변수 -->
		<input type=hidden name=ICHE_OUTBANKNAME value="<?=$agspay->GetResult("ICHE_OUTBANKNAME")?>">		<!-- 이체은행명 -->
		<input type=hidden name=ICHE_OUTBANKMASTER value="<?=$agspay->GetResult("ICHE_OUTBANKMASTER")?>">	<!-- 이체계좌예금주 -->
		<input type=hidden name=ICHE_AMOUNT value="<?=$agspay->GetResult("ICHE_AMOUNT")?>">					<!-- 이체금액 -->

		<!-- 핸드폰 결제 사용 변수 -->
		<input type=hidden name=rHP_HANDPHONE value="<?=$agspay->GetResult("HP_HANDPHONE")?>">		<!-- 핸드폰번호 -->
		<input type=hidden name=rHP_COMPANY value="<?=$agspay->GetResult("HP_COMPANY")?>">			<!-- 통신사명(SKT,KTF,LGT) -->
		<input type=hidden name=rHP_TID value="<?=$agspay->GetResult("rHP_TID")?>">					<!-- 결제TID -->
		<input type=hidden name=rHP_DATE value="<?=$agspay->GetResult("rHP_DATE")?>">				<!-- 결제일자 -->

		<!-- ARS 결제 사용 변수 -->
		<input type=hidden name=rARS_PHONE value="<?=$agspay->GetResult("ARS_PHONE")?>">			<!-- ARS번호 -->

		<!-- 가상계좌 결제 사용 변수 -->
		<input type=hidden name=rVirNo value="<?=$agspay->GetResult("rVirNo")?>">					<!-- 가상계좌번호 -->
		<input type=hidden name=VIRTUAL_CENTERCD value="<?=$agspay->GetResult("VIRTUAL_CENTERCD")?>">	<!--입금가상계좌은행코드(우리은행:20) -->

		<!-- 이지스에스크로 결제 사용 변수 -->
		<input type=hidden name=ES_SENDNO value="<?=$agspay->GetResult("ES_SENDNO")?>">				<!-- 이지스에스크로(전문번호) -->


		<input type="hidden" name="req_tx"            value="pay">							<!-- 요청 구분 -->
        <input type="hidden" name="bSucc"             value="<?=$bSucc			?>">		<!-- 쇼핑몰 DB 처리 성공 여부 -->
        <input type="hidden" name="res_cd"            value="<?=($agspay->GetResult("rSuccYn") == "y")?"0000":"9999";?>">     <!-- 결과 코드 -->

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
?>