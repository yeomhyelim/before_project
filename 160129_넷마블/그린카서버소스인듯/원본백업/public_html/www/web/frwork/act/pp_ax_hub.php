<?php
// 2015.01.22 kim hee sung 테스트용
//	if($_SESSION['member_id'] == 'thav'):
//		ECHO  $trace_no . ' _ ' . $g_conf_home_dir . ' _ ' . $g_conf_site_cd . ' _ ' . $g_conf_site_key . ' _ ' . $tran_cd . ' _ ' . "" . ' _ ' .
//					  $g_conf_gw_url . ' _ ' . $g_conf_gw_port . ' _ ' . "payplus_cli_slib" . ' _ ' . $ordr_idxx . ' _ ' .
//					  $cust_ip . ' _ ' . "3"  . ' _ ' . 1 . ' _ ' . 0 . ' _ ' . $g_conf_key_dir . ' _ ' . $g_conf_log_dir;
//		exit;
//	endif;
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" >
    <head>
		<title>*** KCP [AX-HUB Version] ***</title>
        <script type="text/javascript">
            function goResult()
            {
                //var openwin = window.open( '/common/kcp/proc_win.html', 'proc_win', '' )
                document.pay_info.submit();
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
<?
    /* ============================================================================== */
    /* =   PAGE : 지불 요청 및 결과 처리 PAGE                                       = */
    /* = -------------------------------------------------------------------------- = */
    /* =   연동시 오류가 발생하는 경우 아래의 주소로 접속하셔서 확인하시기 바랍니다.= */
    /* =   접속 주소 : http://testpay.kcp.co.kr/pgsample/FAQ/search_error.jsp       = */
    /* = -------------------------------------------------------------------------- = */
    /* =   Copyright (c)  2010.02   KCP Inc.   All Rights Reserved.                 = */
    /* ============================================================================== */


    /* ============================================================================== */
    /* =   환경 설정 파일 Include                                                   = */
    /* = -------------------------------------------------------------------------- = */
    /* =   ※ 필수                                                                  = */
    /* =   테스트 및 실결제 연동시 site_conf_inc.php파일을 수정하시기 바랍니다.     = */
    /* = -------------------------------------------------------------------------- = */

    include MALL_SHOP . "/conf/site_conf_inc.php";       // 환경설정 파일 include
    require MALL_HOME . "/web/frwork/act/pp_ax_hub_lib.php";              // library [수정불가]

    /* = -------------------------------------------------------------------------- = */
    /* =   환경 설정 파일 Include END                                               = */
    /* ============================================================================== */
?>

<?
	setlocale(LC_CTYPE, 'ko_KR.euc-kr');

    /* ============================================================================== */
    /* =   01. 지불 요청 정보 설정                                                  = */
    /* = -------------------------------------------------------------------------- = */
	$req_tx         = $_POST[ "req_tx"         ]; // 요청 종류
	$tran_cd        = $_POST[ "tran_cd"        ]; // 처리 종류
	/* = -------------------------------------------------------------------------- = */
	$cust_ip        = getenv( "REMOTE_ADDR"    ); // 요청 IP
	$ordr_idxx      = $_POST[ "ordr_idxx"      ]; // 쇼핑몰 주문번호
	$good_name      = $_POST[ "good_name"      ]; // 상품명
	$good_mny       = $_POST[ "good_mny"       ]; // 결제 총금액
	/* = -------------------------------------------------------------------------- = */
    $res_cd         = "";                         // 응답코드
    $res_msg        = "";                         // 응답메시지
    $tno            = $_POST[ "tno"            ]; // KCP 거래 고유 번호
	$vcnt_yn        = $_POST[ "vcnt_yn"        ]; // 가상계좌 에스크로 사용 유무
    /* = -------------------------------------------------------------------------- = */
    $buyr_name      = $_POST[ "buyr_name"      ]; // 주문자명
    $buyr_tel1      = $_POST[ "buyr_tel1"      ]; // 주문자 전화번호
    $buyr_tel2      = $_POST[ "buyr_tel2"      ]; // 주문자 핸드폰 번호
    $buyr_mail      = $_POST[ "buyr_mail"      ]; // 주문자 E-mail 주소
    /* = -------------------------------------------------------------------------- = */
    $mod_type       = $_POST[ "mod_type"       ]; // 변경TYPE VALUE 승인취소시 필요
    $mod_desc       = $_POST[ "mod_desc"       ]; // 변경사유
    /* = -------------------------------------------------------------------------- = */
    $use_pay_method = $_POST[ "use_pay_method" ]; // 결제 방법
    $bSucc          = "";                         // 업체 DB 처리 성공 여부
    /* = -------------------------------------------------------------------------- = */
	$app_time       = "";                         // 승인시간 (모든 결제 수단 공통)
	$total_amount   = 0;                          // 복합결제시 총 거래금액
    $amount         = "";                         // KCP 실제 거래 금액
    /* = -------------------------------------------------------------------------- = */
    $card_cd        = "";                         // 신용카드 코드
    $card_name      = "";                         // 신용카드 명
    $app_no         = "";                         // 신용카드 승인번호
    $noinf          = "";                         // 신용카드 무이자 여부
    $quota          = "";                         // 신용카드 할부개월
    /* = -------------------------------------------------------------------------- = */
	$bank_name      = "";                         // 은행명
	$bank_code      = "";						  // 은행코드
	/* = -------------------------------------------------------------------------- = */
    $bankname       = "";                         // 입금할 은행명
    $depositor      = "";                         // 입금할 계좌 예금주 성명
    $account        = "";                         // 입금할 계좌 번호
	$va_date		= "";						  // 가상계좌 입금마감시간
    /* = -------------------------------------------------------------------------- = */
	$pnt_issue      = "";					      // 결제 포인트사 코드
	$pt_idno        = "";                         // 결제 및 인증 아이디
	$pnt_amount     = "";                         // 적립금액 or 사용금액
	$pnt_app_time   = "";                         // 승인시간
	$pnt_app_no     = "";                         // 승인번호
    $add_pnt        = "";                         // 발생 포인트
	$use_pnt        = "";                         // 사용가능 포인트
	$rsv_pnt        = "";                         // 총 누적 포인트
    /* = -------------------------------------------------------------------------- = */
	$commid         = "";                         // 통신사 코드
	$mobile_no      = "";                         // 휴대폰 코드
	/* = -------------------------------------------------------------------------- = */
	$tk_shop_id		= $_POST[ "tk_shop_id"     ]; // 가맹점 고객 아이디
	$tk_van_code    = "";                         // 발급사 코드
	$tk_app_no      = "";                         // 상품권 승인 번호
	/* = -------------------------------------------------------------------------- = */
    $cash_yn        = $_POST[ "cash_yn"        ]; // 현금영수증 등록 여부
    $cash_authno    = "";                         // 현금 영수증 승인 번호
    $cash_tr_code   = $_POST[ "cash_tr_code"   ]; // 현금 영수증 발행 구분
    $cash_id_info   = $_POST[ "cash_id_info"   ]; // 현금 영수증 등록 번호
	/* ============================================================================== */
    /* =   01-1. 에스크로 지불 요청 정보 설정                                       = */
    /* = -------------------------------------------------------------------------- = */
    $escw_used      = $_POST[  "escw_used"     ]; // 에스크로 사용 여부
    $pay_mod        = $_POST[  "pay_mod"       ]; // 에스크로 결제처리 모드
    $deli_term      = $_POST[  "deli_term"     ]; // 배송 소요일
    $bask_cntx      = $_POST[  "bask_cntx"     ]; // 장바구니 상품 개수
    $good_info      = $_POST[  "good_info"     ]; // 장바구니 상품 상세 정보
    $rcvr_name      = $_POST[  "rcvr_name"     ]; // 수취인 이름
    $rcvr_tel1      = $_POST[  "rcvr_tel1"     ]; // 수취인 전화번호
    $rcvr_tel2      = $_POST[  "rcvr_tel2"     ]; // 수취인 휴대폰번호
    $rcvr_mail      = $_POST[  "rcvr_mail"     ]; // 수취인 E-Mail
    $rcvr_zipx      = $_POST[  "rcvr_zipx"     ]; // 수취인 우편번호
    $rcvr_add1      = $_POST[  "rcvr_add1"     ]; // 수취인 주소
    $rcvr_add2      = $_POST[  "rcvr_add2"     ]; // 수취인 상세주소
	$escw_yn		= "";						  // 에스크로 여부

	/* ============================================================================== */
    /* =   01-1. 결제 지불 요청 정보 설정                                       = */
    /* = -------------------------------------------------------------------------- = */
	$aryCartNo				= $_POST[  "cartNo"		   ]; // 주문상품정보
    $intO_NO				= $_POST[  "order_no"      ]; // 주문번호
    $aryCouponUseIssueNo	= $_POST[  "couponUseIssueNo"      ]; // 사용한 쿠폰 발행번호

	if ($req_tx == "pay")
	{
		// 결제신청

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
	}

	$orderMgr->setO_NO($intO_NO);
	$orderRow = $orderMgr->getOrderView($db);


    /* = -------------------------------------------------------------------------- = */
    /* =   01. 지불 요청 정보 설정 END                                              = */
    /* ============================================================================== */

    /* ============================================================================== */
    /* =   02. 인스턴스 생성 및 초기화(변경 불가)                                   = */
    /* = -------------------------------------------------------------------------- = */
    /* =       결제에 필요한 인스턴스를 생성하고 초기화 합니다.                     = */
    /* = -------------------------------------------------------------------------- = */
    $c_PayPlus = new C_PP_CLI;

    $c_PayPlus->mf_clear();
    /* ------------------------------------------------------------------------------ */
	/* =   02. 인스턴스 생성 및 초기화 END											= */
	/* ============================================================================== */


    /* ============================================================================== */
    /* =   03. 처리 요청 정보 설정                                                  = */
    /* = -------------------------------------------------------------------------- = */
    /* = -------------------------------------------------------------------------- = */
    /* =   03-1. 승인 요청 정보 설정                                                = */
    /* = -------------------------------------------------------------------------- = */
	if ( $req_tx == "pay" )
    {
		/* 1004원은 실제로 업체에서 결제하셔야 될 원 금액을 넣어주셔야 합니다. 결제금액 유효성 검증 */
		if ($S_SHOP_HOME!="demo1" && $S_SHOP_HOME!="demo2"){
		$c_PayPlus->mf_set_ordr_data( "ordr_mony",  STR_REPLACE(',','',NUMBER_FORMAT($orderRow[O_TOT_SPRICE])) );
		}
		$c_PayPlus->mf_set_encx_data( $_POST[ "enc_data" ], $_POST[ "enc_info" ] );
    }

    /* = -------------------------------------------------------------------------- = */
    /* =   03-2. 취소/매입 요청                                                     = */
    /* = -------------------------------------------------------------------------- = */
    else if ( $req_tx == "mod" )
    {
        $tran_cd = "00200000";

		$tno = $orderRow[O_APPR_NO]; //주문번호로 거래번호 조회

        $c_PayPlus->mf_set_modx_data( "tno",      $tno      ); // KCP 원거래 거래번호
        $c_PayPlus->mf_set_modx_data( "mod_type", $mod_type ); // 원거래 변경 요청 종류
        $c_PayPlus->mf_set_modx_data( "mod_ip",   $cust_ip  ); // 변경 요청자 IP
        $c_PayPlus->mf_set_modx_data( "mod_desc", $mod_desc ); // 변경 사유
    }
	/* = -------------------------------------------------------------------------- = */
    /* =   03-3. 에스크로 상태변경 요청                                             = */
    /* = -------------------------------------------------------------------------- = */
    else if ($req_tx = "mod_escrow")
	{
		$tran_cd	= "00200000";
		$tno		= $orderRow[O_APPR_NO]; //주문번호로 거래번호 조회

		//echo $tno.":".$mod_type.":".$cust_ip.":".$mod_desc;
        $c_PayPlus->mf_set_modx_data( "tno",      $tno      );						// KCP 원거래 거래번호
        $c_PayPlus->mf_set_modx_data( "mod_type", $mod_type );						// 원거래 변경 요청 종류
        $c_PayPlus->mf_set_modx_data( "mod_ip",   $cust_ip  );						// 변경 요청자 IP
		//$c_PayPlus->mf_set_modx_data( "mod_desc", $mod_desc );						// 변경 사유

		if ($mod_type == "STE1")													// 상태변경 타입이 [배송요청]인 경우
        {
            $c_PayPlus->mf_set_modx_data( "deli_numb",   $_POST[ "deliveryCom" ] );   // 운송장 번호
            $c_PayPlus->mf_set_modx_data( "deli_corp",   $_POST[ "deliveryNo" ] );   // 택배 업체명
        }
        else if ($mod_type == "STE2" || $mod_type == "STE4") // 상태변경 타입이 [즉시취소] 또는 [취소]인 계좌이체, 가상계좌의 경우
        {
            if ($vcnt_yn == "Y")
            {
				$c_PayPlus->mf_set_modx_data( "refund_account",   $_POST[ "returnAcc" ] );		 // 환불수취계좌번호
                $c_PayPlus->mf_set_modx_data( "refund_nm",        $_POST[ "returnName" ] );      // 환불수취계좌주명
                $c_PayPlus->mf_set_modx_data( "bank_code",        $_POST[ "returnBank"      ] );      // 환불수취은행코드
			}
        }
    }
    /* = -------------------------------------------------------------------------- = */
    /* =   03-3. 에스크로 상태변경 요청 END                                         = */
    /* = -------------------------------------------------------------------------- = */

	/* ------------------------------------------------------------------------------ */
	/* =   03.  처리 요청 정보 설정 END  											= */
	/* ============================================================================== */

    /* ============================================================================== */
    /* =   04. 실행                                                                 = */
    /* = -------------------------------------------------------------------------- = */
    if ( $tran_cd != "" )
    {

        $c_PayPlus->mf_do_tx( $trace_no, $g_conf_home_dir, $g_conf_site_cd, $g_conf_site_key, $tran_cd, "",
                              $g_conf_gw_url, $g_conf_gw_port, "payplus_cli_slib", $ordr_idxx,
                              $cust_ip, "3" , 1, 0, $g_conf_key_dir, $g_conf_log_dir);

		$res_cd  = $c_PayPlus->m_res_cd;  // 결과 코드
		$res_msg = $c_PayPlus->m_res_msg; // 결과 메시지

    }
    else
    {
        $c_PayPlus->m_res_cd  = "9562";
        $c_PayPlus->m_res_msg = "연동 오류|Payplus Plugin이 설치되지 않았거나 tran_cd값이 설정되지 않았습니다.";
    }

    /* = -------------------------------------------------------------------------- = */
    /* =   04. 실행 END                                                             = */
    /* ============================================================================== */


    /* ============================================================================== */
    /* =   05. 승인 결과 값 추출                                                    = */
    /* = -------------------------------------------------------------------------- = */
    /* =   수정하지 마시기 바랍니다.                                                = */
    /* = -------------------------------------------------------------------------- = */
    if ( $req_tx == "pay" )
    {
        if( $res_cd == "0000" )
        {
            $tno       = $c_PayPlus->mf_get_res_data( "tno"       ); // KCP 거래 고유 번호
            $amount    = $c_PayPlus->mf_get_res_data( "amount"    ); // KCP 실제 거래 금액
			$pnt_issue = $c_PayPlus->mf_get_res_data( "pnt_issue" ); // 결제 포인트사 코드

    /* = -------------------------------------------------------------------------- = */
    /* =   05-1. 신용카드 승인 결과 처리                                            = */
    /* = -------------------------------------------------------------------------- = */
            if ( $use_pay_method == "100000000000" )
            {
                $card_cd   = $c_PayPlus->mf_get_res_data( "card_cd"   ); // 카드사 코드
                $card_name = $c_PayPlus->mf_get_res_data( "card_name" ); // 카드사 명
                $app_time  = $c_PayPlus->mf_get_res_data( "app_time"  ); // 승인시간
                $app_no    = $c_PayPlus->mf_get_res_data( "app_no"    ); // 승인번호
                $noinf     = $c_PayPlus->mf_get_res_data( "noinf"     ); // 무이자 여부
                $quota     = $c_PayPlus->mf_get_res_data( "quota"     ); // 할부 개월 수

                /* = -------------------------------------------------------------- = */
                /* =   05-1.1. 복합결제(포인트+신용카드) 승인 결과 처리             = */
                /* = -------------------------------------------------------------- = */
                if ( $pnt_issue == "SCSK" || $pnt_issue == "SCWB" )
                {
					$pt_idno      = $c_PayPlus->mf_get_res_data ( "pt_idno"      ); // 결제 및 인증 아이디
                    $pnt_amount   = $c_PayPlus->mf_get_res_data ( "pnt_amount"   ); // 적립금액 or 사용금액
	                $pnt_app_time = $c_PayPlus->mf_get_res_data ( "pnt_app_time" ); // 승인시간
	                $pnt_app_no   = $c_PayPlus->mf_get_res_data ( "pnt_app_no"   ); // 승인번호
	                $add_pnt      = $c_PayPlus->mf_get_res_data ( "add_pnt"      ); // 발생 포인트
                    $use_pnt      = $c_PayPlus->mf_get_res_data ( "use_pnt"      ); // 사용가능 포인트
                    $rsv_pnt      = $c_PayPlus->mf_get_res_data ( "rsv_pnt"      ); // 총 누적 포인트
					$total_amount = $amount + $pnt_amount;                          // 복합결제시 총 거래금액
                }
            }

    /* = -------------------------------------------------------------------------- = */
    /* =   05-2. 계좌이체 승인 결과 처리                                            = */
    /* = -------------------------------------------------------------------------- = */
            if ( $use_pay_method == "010000000000" )
            {
				$app_time  = $c_PayPlus->mf_get_res_data( "app_time"   );  // 승인 시간
                $bank_name = $c_PayPlus->mf_get_res_data( "bank_name"  );  // 은행명
                $bank_code = $c_PayPlus->mf_get_res_data( "bank_code"  );  // 은행코드
            }

    /* = -------------------------------------------------------------------------- = */
    /* =   05-3. 가상계좌 승인 결과 처리                                            = */
    /* = -------------------------------------------------------------------------- = */
            if ( $use_pay_method == "001000000000" )
            {

				$bank_code = $c_PayPlus->mf_get_res_data( "bankcode"  ); // 입금할 은행 이름
				$bankname  = $c_PayPlus->mf_get_res_data( "bankname"  ); // 입금할 은행 이름
                $depositor = $c_PayPlus->mf_get_res_data( "depositor" ); // 입금할 계좌 예금주
                $account   = $c_PayPlus->mf_get_res_data( "account"   ); // 입금할 계좌 번호
				$va_date   = $c_PayPlus->mf_get_res_data( "va_date"   ); // 가상계좌 입금마감시간
            }

    /* = -------------------------------------------------------------------------- = */
    /* =   05-4. 포인트 승인 결과 처리                                              = */
    /* = -------------------------------------------------------------------------- = */
            if ( $use_pay_method == "000100000000" )
            {
				$pt_idno      = $c_PayPlus->mf_get_res_data( "pt_idno"      ); // 결제 및 인증 아이디
                $pnt_amount   = $c_PayPlus->mf_get_res_data( "pnt_amount"   ); // 적립금액 or 사용금액
	            $pnt_app_time = $c_PayPlus->mf_get_res_data( "pnt_app_time" ); // 승인시간
	            $pnt_app_no   = $c_PayPlus->mf_get_res_data( "pnt_app_no"   ); // 승인번호
	            $add_pnt      = $c_PayPlus->mf_get_res_data( "add_pnt"      ); // 발생 포인트
                $use_pnt      = $c_PayPlus->mf_get_res_data( "use_pnt"      ); // 사용가능 포인트
                $rsv_pnt      = $c_PayPlus->mf_get_res_data( "rsv_pnt"      ); // 총 누적 포인트
            }

    /* = -------------------------------------------------------------------------- = */
    /* =   05-5. 휴대폰 승인 결과 처리                                              = */
    /* = -------------------------------------------------------------------------- = */
            if ( $use_pay_method == "000010000000" )
            {
                $app_time  = $c_PayPlus->mf_get_res_data( "hp_app_time"  ); // 승인 시간
				$commid    = $c_PayPlus->mf_get_res_data( "commid"	     ); // 통신사 코드
				$mobile_no = $c_PayPlus->mf_get_res_data( "mobile_no"	 ); // 휴대폰 번호
            }

    /* = -------------------------------------------------------------------------- = */
    /* =   05-6. 상품권 승인 결과 처리                                              = */
    /* = -------------------------------------------------------------------------- = */
            if ( $use_pay_method == "000000001000" )
            {
                $app_time    = $c_PayPlus->mf_get_res_data( "tk_app_time"  ); // 승인 시간
				$tk_van_code = $c_PayPlus->mf_get_res_data( "tk_van_code"  ); // 발급사 코드
				$tk_app_no   = $c_PayPlus->mf_get_res_data( "tk_app_no"    ); // 승인 번호
            }

    /* = -------------------------------------------------------------------------- = */
    /* =   05-7. 현금영수증 결과 처리                                               = */
    /* = -------------------------------------------------------------------------- = */
            $cash_authno  = $c_PayPlus->mf_get_res_data( "cash_authno"  ); // 현금 영수증 승인 번호
        }
	/* = -------------------------------------------------------------------------- = */
    /* =   05-8. 에스크로 여부 결과 처리                                            = */
    /* = -------------------------------------------------------------------------- = */
		$escw_yn = $c_PayPlus->mf_get_res_data( "escw_yn"  ); // 에스크로 여부
	}

	/* = -------------------------------------------------------------------------- = */
    /* =   05. 승인 결과 처리 END                                                   = */
    /* ============================================================================== */

	/* ============================================================================== */
    /* =   06. 승인 및 실패 결과 DB처리                                             = */
    /* = -------------------------------------------------------------------------- = */
	/* =       결과를 업체 자체적으로 DB처리 작업하시는 부분입니다.                 = */
    /* = -------------------------------------------------------------------------- = */
	$strLogText = "결제번호:".$orderMgr->getO_NO()."/DB오류:".$bSuccText."/res_cd=".$res_cd."/req_cd=".$req_cd."/req_tx=".$req_tx."/mod_type=".$mod_type;
	$strLogText .= "에러메세지:".ICONV("EUC-KR","UTF-8",$res_msg);
	orderWriteLog($strLogText,$S_SHOP_HOME);

	if ( $req_tx == "pay" )
    {

	/* = -------------------------------------------------------------------------- = */
    /* =   06-1. 승인 결과 DB 처리(res_cd == "0000")                                = */
    /* = -------------------------------------------------------------------------- = */
    /* =        각 결제수단을 구분하시어 DB 처리를 하시기 바랍니다.                 = */
    /* = -------------------------------------------------------------------------- = */
		if( $res_cd == "0000" )
        {
			// 06-1-1. 신용카드
			if ( $use_pay_method == "100000000000" )
            {
				// 06-1-1-1. 복합결제(신용카드 + 포인트)
				if ( $pnt_issue == "SCSK" || $pnt_issue == "SCWB" )
                {
				}
			}
			// 06-1-2. 계좌이체
			if ( $use_pay_method == "010000000000" )
            {
				/* 입금은행 UPDATE */
				$orderMgr->setO_BANK($bankname);
				$orderMgr->setO_BANK_ACC("");
				$orderMgr->getO_BANK_NAME("");
				$orderMgr->getO_BANK_VALID_DT("");
				$result = $orderMgr->getOrderInputUpdate($db);

				if (!$result) {
					$bSucc		= "false";
					$bSuccText	= "계좌이체 입금정보 UPDATE";
				}
			}
			// 06-1-3. 가상계좌
			if ( $use_pay_method == "001000000000" )
            {
				/* 가상계좌은행/계좌/예금주/마감일자 UPDATE */
				$orderMgr->setO_BANK($bank_code);
				$orderMgr->setO_BANK_ACC($account);
				$orderMgr->setO_BANK_NAME($depositor);
				$orderMgr->setO_BANK_VALID_DT($va_date);
				$result = $orderMgr->getOrderInputUpdate($db);
				if (!$result) {
					$bSucc		= "false";
					$bSuccText	= "가상계좌정보 UPDATE";
				}

				$orderMgr->setO_STATUS("J");
				$orderMgr->getOrderStatusUpdate($db);
			}
			// 06-1-4. 포인트
			if ( $use_pay_method == "000100000000" )
            {
			}
			// 06-1-5. 휴대폰
			if ( $use_pay_method == "000010000000" )
            {
			}
			// 06-1-6. 상품권
			 if ( $use_pay_method == "000000001000" )
            {
			}

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
					$strProdCode		= $aryOrderCartList[$j][P_CODE];
					$intOC_OPT_NO		= $aryOrderCartList[$j][OC_OPT_NO];
					$intOC_QTY			= $aryOrderCartList[$j][OC_QTY];
					$intProdStockQty	= $aryOrderCartList[$j][P_QTY];

					/* 무제한 상품이 아닌 경우 */
					if ($aryOrderCartList[$j][P_STOCK_LIMIT] != "Y"){
						/* 옵션별 수량 조절 */
						if ($intOC_OPT_NO > 0){
							$productMgr->setPOA_STOCK_QTY( $intOC_QTY * -1 );
							$productMgr->setPOA_NO($intOC_OPT_NO);

							/* 옵션 수량 체크 */
							$productMgr->set_option_type ( 'O' ) ;
							$pre_stock = $productMgr->getProdQtyCalc($db) ;
							if ( $pre_stock['PSQ'] < 0 )
							{
								$bSucc		= "false";
								$bSuccText	= "요청 상품 품절";
							}
							else
							{
								$result = $productMgr->getProdOptQtyUpdate($db);
								if (!$result) {
									$bSucc		= "false";
									$bSuccText	= "옵션별 수량 조절";
								}
							}


						}

						/* 상품전체 수량 조절 */
						if ($strProdCode)
						{
							$intProdQty = $intProdStockQty - $intOC_QTY;
							if ($intProdQty < 0 && $intProdStockQty > 0 ) $intOC_QTY = $intProdStockQty;

							$productMgr->setP_QTY( $intOC_QTY * -1 );
							$productMgr->setP_CODE($strProdCode);

							/* 옵션 수량 체크 */
							$productMgr->set_option_type ( 'P' ) ;
							$pre_stock = $productMgr->getProdQtyCalc($db) ;
							if ( $pre_stock['PSQ'] < 0 )
							{
								$bSucc		= "false";
								$bSuccText	= "요청 상품 품절";
							}
							else
							{
								$result = $productMgr->getProdQtyUpdate($db);

								if (!$result) {
									$bSucc		= "false";
									$bSuccText	= "상품전체 수량 조절";
								}
							}
						}
					}

					if ($aryOrderCartList[$j]["P_POINT_NO_USE"] == "Y") {
						$intOrderProdNoPointUseCnt++;
					}
				}
			}
			/* 상품 수량 체크 */

			/* 가상계좌가 아닐 경우 승인 처리*/
			if ($use_pay_method != "001000000000")
			{


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
				if ($S_MALL_TYPE == "M"){
					$orderMgr->setSO_DELIVERY_STATUS("B");
					$orderMgr->setO_STATUS("");
					$orderMgr->getOrderAccStatusUpdate($db);
				}

				/* 결제 완료 후 상품별 이용기간 INSERT */
				include MALL_HOME."/web/frwork/act/payOrderPeriodApproval.php";
				/* 결제 완료 후 상품별 이용기간 INSERT */
			}

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
				$orderMgr->setSO_DELIVERY_STATUS("");
				$orderMgr->setO_STATUS("");
				$orderMgr->getOrderAccStatusUpdate($db);
			}

			/* 경매 상품 정보 UPDATE */
			if ($S_PRODUCT_AUCTION_USE == "Y"){
				$strAuctionMode = "2";
				include WEB_FRWORK_JSON."/order.auction.php";
			}
			/* 경매 상품 정보 UPDATE */
			/*##################### 승인처리 DB 처리 추가 #####################*/
		}
	/* = -------------------------------------------------------------------------- = */
    /* =   06.-2 승인 및 실패 결과 DB처리                                             = */
    /* ============================================================================== */

		else if ( $req_cd != "0000" )
		{
			$bSucc		= "false";
			$bSuccText	= $req_cd;
		}

	} else {
		// $req_tx = mod, mod_escrow => 결제 취소

		if( $res_cd == "0000" )
		{
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

			if ( $req_tx == "mod" || $req_tx == "mod_escrow") {

				/* 즉시 취소 및 정산보류 */
				if ($mod_type == "STE3" || $mod_type == "STSC" || $mod_type == "STE2"){
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

				}

				/* 정산보류 후 취소 */
				if ($mod_type == "STE4")
				{
					$orderMgr->setO_CEL_STATUS("Y");
					$orderMgr->getOrderCancelStatusUpdate($db);
				}

				/* 가상계좌 입금전 주문취소 */
				if ($mod_type == "STE5")
				{

					$orderMgr->setO_STATUS("C");
					$orderMgr->setO_CEL_NO($strOrderSettleCelNo);
					$orderMgr->setO_CEL_MEMO($_POST["mod_desc"]);
					$orderMgr->setO_RETURN_BANK("");
					$orderMgr->setO_RETURN_ACC("");
					$orderMgr->setO_RETURN_NAME("");
					$orderMgr->setO_CEL_STATUS("Y");

					$orderMgr->setOS_APPR_NO($orderRow[O_APPR_NO]);
					$orderMgr->setOS_STATUS("C");
					$orderMgr->setOS_TITLE($orderRow[O_J_TITLE]);
					$orderMgr->setOS_USE_POINT($orderRow[O_USE_POINT]);
					$orderMgr->setOS_USE_COUPON($orderRow[O_USE_COUPON]);
					$orderMgr->setOS_TOT_PRICE($orderRow[O_TOT_PRICE]);
					$orderMgr->setOS_TOT_DELIVERY_PRICE($orderRow[O_TOT_DELIVERY_PRICE]);
					$orderMgr->setOS_TOT_TAX_PRICE($orderRow[O_TAX_PRICE]);
					$orderMgr->setOS_TOT_SPRICE($orderRow[O_TOT_SPRICE]);
					if ($orderMgr->getO_ADD_POINT() == "Y") $orderMgr->setOS_TOT_POINT($orderRow[O_TOT_POINT]);
					else  $orderMgr->setOS_TOT_POINT(0);
					$orderMgr->setOS_SETTLE($orderRow[O_SETTLE]);
					$result = $orderMgr->getOrderSettleInsert($db);
					if (!$result) {
						$bSucc		= "false";
						$bSuccText	= "가상계좌 발급계좌해지";
					}
					$orderMgr->setOS_CEL_NO($strOrderSettleCelNo);
					$result = $orderMgr->getOrderSettleUpdate($db);
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
			}


		} else if ( $req_cd != "0000" ){
			$bSucc		= "false";
			$bSuccText	= $req_cd;
		}


	}

	$strLogText = "결제번호:".$orderMgr->getO_NO()."/DB오류:".$bSuccText."/res_cd=".$res_cd."/req_cd=".$req_cd."/req_tx=".$req_tx."/mod_type=".$mod_type;
	orderWriteLog($strLogText,$S_SHOP_HOME);


	/* = -------------------------------------------------------------------------- = */
    /* =   06. 승인 및 실패 결과 DB 처리 END                                        = */
    /* = ========================================================================== = */


	/* = ========================================================================== = */
    /* =   07. 승인 결과 DB 처리 실패시 : 자동취소                                  = */
    /* = -------------------------------------------------------------------------- = */
    /* =      승인 결과를 DB 작업 하는 과정에서 정상적으로 승인된 건에 대해         = */
    /* =      DB 작업을 실패하여 DB update 가 완료되지 않은 경우, 자동으로          = */
    /* =      승인 취소 요청을 하는 프로세스가 구성되어 있습니다.                   = */
    /* =                                                                            = */
    /* =      DB 작업이 실패 한 경우, bSucc 라는 변수(String)의 값을 "false"        = */
    /* =      로 설정해 주시기 바랍니다. (DB 작업 성공의 경우에는 "false" 이외의    = */
    /* =      값을 설정하시면 됩니다.)                                              = */
    /* = -------------------------------------------------------------------------- = */

	// 승인 결과 DB 처리 에러시 bSucc값을 false로 설정하여 거래건을 취소 요청
	//$bSucc = "";

    if ( $req_tx == "pay" )
    {
		if( $res_cd == "0000" )
        {
			if ( $bSucc == "false" )
            {
                $c_PayPlus->mf_clear();

                $tran_cd = "00200000";

	/* ============================================================================== */
    /* =   07-1.자동취소시 에스크로 거래인 경우                                     = */
    /* = -------------------------------------------------------------------------- = */
				// 취소시 사용하는 mod_type
                $bSucc_mod_type = "";

                // 에스크로 가상계좌 건의 경우 가상계좌 발급취소(STE5)
                if ( $escw_yn == "Y" && $use_pay_method == "001000000000" )
				{
                    $bSucc_mod_type = "STE5";
				}
                // 에스크로 가상계좌 이외 건은 즉시취소(STE2)
                else if ( $escw_yn == "Y" )
				{
                    $bSucc_mod_type = "STE2";
				}
                // 에스크로 거래 건이 아닌 경우(일반건)(STSC)
                else
				{
                    $bSucc_mod_type = "STSC";
				}
	/* = -------------------------------------------------------------------------- = */
	/* =   07-1. 자동취소시 에스크로 거래인 경우 처리 END                           = */
    /* = ========================================================================== = */

                $c_PayPlus->mf_set_modx_data( "tno",      $tno                         );  // KCP 원거래 거래번호
                $c_PayPlus->mf_set_modx_data( "mod_type", $bSucc_mod_type              );  // 원거래 변경 요청 종류
                $c_PayPlus->mf_set_modx_data( "mod_ip",   $cust_ip                     );  // 변경 요청자 IP
                $c_PayPlus->mf_set_modx_data( "mod_desc", "가맹점 결과 처리 오류 - 가맹점에서 취소 요청" );  // 변경 사유

                $c_PayPlus->mf_do_tx( $tno,  $g_conf_home_dir, $g_conf_site_cd,
                                      $g_conf_site_key,  $tran_cd,    "",
                                      $g_conf_gw_url,  $g_conf_gw_port,  "payplus_cli_slib",
                                      $ordr_idxx, $cust_ip, "3" ,
                                      0, 0, $g_conf_key_dir, $g_conf_log_dir);

                $res_cd  = $c_PayPlus->m_res_cd;
                $res_msg = $c_PayPlus->m_res_msg;



				/*##################### 자동취소처리 DB 처리 추가 #####################*/
				$orderMgr->setO_STATUS("F");
				$orderMgr->getOrderStatusUpdate($db);
				/*##################### 자동취소처리 DB 처리 추가 #####################*/
            }
        }
	} else if ($req_tx == "mod"){

		if( $res_cd != "0000" || $bSucc == "false")
        {
			goErrMsg("주문취소시 에러가 발생하였습니다.관리자에게 문의바랍니다.");
			$db->disConnect();
			exit;
		}
	} else if ($req_tx == "mod_escrow"){

		if( $res_cd != "0000" || $bSucc == "false")
        {
			goErrMsg("주문취소시 에러가 발생하였습니다.관리자에게 문의바랍니다.");
			$db->disConnect();
			exit;
		}
	}
		// End of [res_cd = "0000"]
	/* = -------------------------------------------------------------------------- = */
    /* =   07. 승인 결과 DB 처리 END                                                = */
    /* = ========================================================================== = */


    /* ============================================================================== */
    /* =   08. 폼 구성 및 결과페이지 호출                                           = */
    /* ============================================================================== */

	/* 여기에 추가되어야 함(메일관련) */
	require_once $S_DOCUMENT_ROOT.$S_SHOP_HOME."/layout/mail/_config.inc.php";
	require_once $S_DOCUMENT_ROOT."www/config/mail.func.php";
	/* 여기에 추가되어야 함(메일관련) */

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

	$strReturnPageUrl = "./index.php";
	$strReturnMenuType = "order";
	$strReturnMode = "orderEnd";
	$strReturnAct = "";

	if ($req_tx == "mod" || $req_tx == "mod_escrow"){
		if ($_POST["returnMode"] == "admin") $strReturnPageUrl = "../shopAdmin/index.php";

		$strReturnMenuType = "order";
		$strReturnMode = "act";
		$strReturnAct = "orderCancel";
	} else {

		/* PG사 결제시 주문 메일 발송*/
		if ($res_cd == "0000" && $bSucc != "false"){

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

			//$strLogText = "결제번호:".$orderMgr->getO_NO()."/O_J_NAME:".$orderRow['O_J_NAME']."/O_J_MAIL=".$orderRow['O_J_MAIL'];
			//orderWriteLog($strLogText,$S_SHOP_HOME);


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
                // T: 가상계좌 일 경우 현금 주문완료 SMS 발송. 남덕희
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
                    //가상계좌 추가 남덕희
                    //KCP 에서 보내는 값이 euc-kr이라서 변환. 남덕희
                    $bankname           = iconv("euc-kr", "utf-8", $bankname); //은행명
                    $account           = iconv("euc-kr", "utf-8", $account);   //계좌번호
                    $bank_info          = $bankname.' '.$account.' ';
                    $strSmsMsg			= str_replace("{{계좌정보}}", $bank_info, $strSmsMsg);


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
				$strSmsCode = "013"; // 전자결재주문완료(관리자용)

				if($SMS_TEXT_LIST && $SMS_TEXT_LIST[$strSmsCode] && $SMS_TEXT_LIST[$strSmsCode]['SM_AUTO'] == "Y"):

					## 문자 설정
					$strSmsMsg			= $SMS_TEXT_LIST[$strSmsCode]['SM_TEXT'];
					$strSmsMsg			= str_replace("{{고객명}}", $orderRow['O_J_NAME'], $strSmsMsg);
					$strSmsMsg			= str_replace("{{결제금액}}", getCurToPrice($orderRow['O_TOT_CUR_SPRICE'],$orderRow['O_USE_LNG']), $strSmsMsg);
					$strSmsMsg			= str_replace("{{결제방법}}", $S_ARY_SETTLE_TYPE[$orderRow['O_SETTLE']], $strSmsMsg);

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
//			if($SMS_INFO['S_SMS_USE']=="Y" && $S_SITE_LNG == "KR"):
//				$smsMoney = $smsFunc->getSmsMoneySelect($db); // 머니 체크
//				if($smsMoney['VAL'] > 0):
//					$smsCode			= "012";
//					$smsPhone			= str_replace("-","",$orderRow['O_J_HP']);
//					$smsCallBackPhone	= $S_COM_PHONE;
//					$smsMsg				= $SMS_TEXT_LIST[$smsCode]['SM_TEXT'];
//					$smsMsg				= str_replace("{{상점명}}", $S_SITE_KNAME, $smsMsg);
//					$smsMsg				= str_replace("{{결제금액}}", getCurToPrice($orderRow['O_TOT_CUR_SPRICE'],$orderRow['O_USE_LNG']), $smsMsg);
//					$smsMsg				= str_replace("{{결제방법}}", $S_ARY_SETTLE_TYPE[$orderRow['O_SETTLE']], $smsMsg);
//					if($SMS_TEXT_LIST[$smsCode]['SM_AUTO'] == "Y"): //  자동발송 사용..
//						$smsFunc->goSendSms($smsPhone, $smsCallBackPhone, $smsMsg);
//						$smsFunc->getSmsMoneyMinusUpdate($db); // 머니 -1
//					endif;
//				else:
//					// sms 머니 부족.. 부분 처리..
//				endif;
//
//				/* 관리자 */
//				$smsMoney = $smsFunc->getSmsMoneySelect($db); // 머니 체크
//				if($smsMoney['VAL'] > 0):
//					$smsCode			= "013";
//					$smsPhone			= str_replace("-","",$S_COM_HP);
//					$smsCallBackPhone	= $S_COM_PHONE;
//					$smsMsg				= $SMS_TEXT_LIST[$smsCode]['SM_TEXT'];
//					$smsMsg				= str_replace("{{고객명}}", $orderRow['O_J_NAME'], $smsMsg);
//					$smsMsg				= str_replace("{{결제금액}}", getCurToPrice($orderRow['O_TOT_CUR_SPRICE'],$orderRow['O_USE_LNG']), $smsMsg);
//					$smsMsg				= str_replace("{{결제방법}}", $S_ARY_SETTLE_TYPE[$orderRow['O_SETTLE']], $smsMsg);
//					if($SMS_TEXT_LIST[$smsCode]['SM_AUTO'] == "Y"): //  자동발송 사용..
//						$smsFunc->goSendSms($smsPhone, $smsCallBackPhone, $smsMsg);
//						$smsFunc->getSmsMoneyMinusUpdate($db); // 머니 -1
//					endif;
//				else:
//					// sms 머니 부족.. 부분 처리..
//				endif;
//			endif;
			/** 2013.04.18 SMS 전송 모듈 추가 **/
		}
		/* PG사 결제시 주문 메일 발송*/
	}


?>
    <form name="pay_info" method="post" action="./index.php">
        <input type="hidden" name="site_cd"           value="<?=$g_conf_site_cd	?>">     <!-- 사이트코드 -->
		<input type="hidden" name="req_tx"            value="<?=$req_tx			?>">     <!-- 요청 구분 -->
		<input type="hidden" name="mod_type"          value="<?=$mod_type		?>">

        <input type="hidden" name="use_pay_method"    value="<?=$use_pay_method ?>">     <!-- 사용한 결제 수단 -->
        <input type="hidden" name="bSucc"             value="<?=$bSucc			?>">     <!-- 쇼핑몰 DB 처리 성공 여부 -->

        <input type="hidden" name="res_cd"            value="<?=$res_cd			?>">     <!-- 결과 코드 -->
        <input type="hidden" name="res_msg"           value="<?=ICONV("EUC-KR","UTF-8",$res_msg)		?>">     <!-- 결과 메세지 -->
        <input type="hidden" name="ordr_idxx"         value="<?=$ordr_idxx		?>">     <!-- 주문번호 -->
        <input type="hidden" name="tno"               value="<?=$tno			?>">     <!-- KCP 거래번호 -->
        <input type="hidden" name="good_mny"          value="<?=$good_mny		?>">     <!-- 결제금액 -->
        <input type="hidden" name="good_name"         value="<?=$good_name		?>">     <!-- 상품명 -->
        <input type="hidden" name="buyr_name"         value="<?=$buyr_name		?>">     <!-- 주문자명 -->
        <input type="hidden" name="buyr_tel1"         value="<?=$buyr_tel1		?>">     <!-- 주문자 전화번호 -->
        <input type="hidden" name="buyr_tel2"         value="<?=$buyr_tel2		?>">     <!-- 주문자 휴대폰번호 -->
        <input type="hidden" name="buyr_mail"         value="<?=$buyr_mail		?>">     <!-- 주문자 E-mail -->

        <input type="hidden" name="app_time"          value="<?=$app_time		?>">     <!-- 승인시간 -->
        <!-- 신용카드 정보 -->
		<input type="hidden" name="card_cd"           value="<?=$card_cd		?>">     <!-- 카드코드 -->
        <input type="hidden" name="card_name"         value="<?=$card_name		?>">     <!-- 카드명 -->
        <input type="hidden" name="app_no"            value="<?=$app_no			?>">     <!-- 승인번호 -->
		<input type="hidden" name="noinf"             value="<?=$noinf			?>">     <!-- 무이자여부 -->
		<input type="hidden" name="quota"             value="<?=$quota			?>">     <!-- 할부개월 -->
        <!-- 계좌이체 정보 -->
        <input type="hidden" name="bank_code"         value="<?=$bank_code		?>">     <!-- 은행코드 -->
		<input type="hidden" name="bank_name"         value="<?=$bank_name		?>">     <!-- 은행명 -->
        <!-- 가상계좌 정보 -->
        <input type="hidden" name="bankname"          value="<?=$bankname		?>">     <!-- 입금할 은행 -->
        <input type="hidden" name="depositor"         value="<?=$depositor		?>">     <!-- 입금할 계좌 예금주 -->
        <input type="hidden" name="account"           value="<?=$account		?>">     <!-- 입금할 계좌 번호 -->
        <input type="hidden" name="va_date"           value="<?=$va_date		?>">     <!-- 가상계좌 입금마감시간 -->
        <!-- 포인트 정보 -->
        <input type="hidden" name="pnt_issue"         value="<?=$pnt_issue		?>">     <!-- 포인트 서비스사 -->
        <input type="hidden" name="pt_idno"		      value="<?=$pt_idno		?>">     <!-- 결제 및 인증 아이디 -->
        <input type="hidden" name="pnt_amount"        value="<?=$pnt_amount		?>">     <!-- 적립금액 or 사용금액 -->
		<input type="hidden" name="pnt_app_time"      value="<?=$pnt_app_time	?>">     <!-- 승인시간 -->
        <input type="hidden" name="pnt_app_no"        value="<?=$pnt_app_no		?>">     <!-- 승인번호 -->
        <input type="hidden" name="add_pnt"           value="<?=$add_pnt		?>">     <!-- 발생 포인트 -->
        <input type="hidden" name="use_pnt"           value="<?=$use_pnt		?>">     <!-- 사용가능 포인트 -->
        <input type="hidden" name="rsv_pnt"           value="<?=$rsv_pnt		?>">     <!-- 총 누적 포인트 -->

        <!-- 휴대폰 정보 -->
		<input type="hidden" name="commid"            value="<?=$commid			?>">     <!-- 통신사 코드 -->
		<input type="hidden" name="mobile_no"         value="<?=$mobile_no		?>">     <!-- 휴대폰 번호 -->
        <!-- 상품권 정보 -->
		<input type="hidden" name="tk_van_code"       value="<?=$tk_van_code	?>">     <!-- 발급사 코드 -->
		<input type="hidden" name="tk_app_no"         value="<?=$tk_app_no		?>">     <!-- 승인 번호 -->
        <!-- 현금영수증 정보 -->
        <input type="hidden" name="cash_yn"           value="<?=$cash_yn		?>">     <!-- 현금 영수증 등록 여부 -->
        <input type="hidden" name="cash_authno"       value="<?=$cash_authno	?>">     <!-- 현금 영수증 승인 번호 -->
        <input type="hidden" name="cash_tr_code"      value="<?=$cash_tr_code	?>">     <!-- 현금 영수증 발행 구분 -->
        <input type="hidden" name="cash_id_info"      value="<?=$cash_id_info	?>">     <!-- 현금 영수증 등록 번호 -->

		<!-- 에스크로 정보 -->
        <input type="hidden" name="escw_yn"			  value="<?= $escw_yn		?>">     <!-- 에스크로 유무 -->
        <input type="hidden" name="deli_term"	  	  value="<?= $deli_term		?>">     <!-- 배송 소요일 -->
        <input type="hidden" name="bask_cntx"		  value="<?= $bask_cntx		?>">     <!-- 장바구니 상품 개수 -->
        <input type="hidden" name="good_info"		  value="<?= $good_info		?>">     <!-- 장바구니 상품 상세 정보 -->
        <input type="hidden" name="rcvr_name"		  value="<?= $rcvr_name		?>">     <!-- 수취인 이름 -->
        <input type="hidden" name="rcvr_tel1"		  value="<?= $rcvr_tel1		?>">     <!-- 수취인 전화번호 -->
        <input type="hidden" name="rcvr_tel2"		  value="<?= $rcvr_tel2		?>">     <!-- 수취인 휴대폰번호 -->
        <input type="hidden" name="rcvr_mail"		  value="<?= $rcvr_mail		?>">     <!-- 수취인 E-Mail -->
        <input type="hidden" name="rcvr_zipx"		  value="<?= $rcvr_zipx		?>">     <!-- 수취인 우편번호 -->
        <input type="hidden" name="rcvr_add1"		  value="<?= $rcvr_add1		?>">     <!-- 수취인 주소 -->
        <input type="hidden" name="rcvr_add2"		  value="<?= $rcvr_add2		?>">     <!-- 수취인 상세주소 -->

       <input type="hidden" name="oNo"				  value="<?= $intO_NO		?>">     <!-- 주문관리번호번호 -->
       <input type="hidden" name="menuType"		      value="<?=$strReturnMenuType?>">
       <input type="hidden" name="mode"				  value="<?=$strReturnMode?>">
       <input type="hidden" name="act"				  value="<?=$strReturnAct?>">
       <input type="hidden" name="bSuccText"		  value="<?=$bSuccText?>">			 <!-- DB처리오류 -->


	</form>
	<script type="text/javascript">
	<!--
		goResult();
	//-->
	</script>
    </body>
</html>