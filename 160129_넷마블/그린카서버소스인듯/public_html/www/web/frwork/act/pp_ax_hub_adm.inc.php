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
	
    /* = -------------------------------------------------------------------------- = */
    /* =   환경 설정 파일 Include END                                               = */
    /* ============================================================================== */
?>

<?
	setlocale(LC_CTYPE, 'ko_KR.euc-kr');
    /* ============================================================================== */
    /* =   01. 지불 요청 정보 설정                                                  = */
    /* = -------------------------------------------------------------------------- = */
	$tran_cd        = $_POST[ "tran_cd"        ]; // 처리 종류
	/* = -------------------------------------------------------------------------- = */
	$cust_ip        = getenv( "REMOTE_ADDR"    ); // 요청 IP
	/* = -------------------------------------------------------------------------- = */
    $res_cd         = "";                         // 응답코드
    $res_msg        = "";                         // 응답메시지
    
	$bSucc          = "";                         // 업체 DB 처리 성공 여부
    
	/* = -------------------------------------------------------------------------- = */
	
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
    /* =   03-2. 취소/매입 요청                                                     = */
    /* = -------------------------------------------------------------------------- = */
    if ( $req_tx == "mod" )
    {
        $tran_cd = "00200000";
		$tno = $orderRow[O_APPR_NO]; //주문번호로 거래번호 조회
		
		$c_PayPlus->mf_set_modx_data( "tno",      $tno      ); // KCP 원거래 거래번호
        $c_PayPlus->mf_set_modx_data( "mod_type", $mod_type ); // 원거래 변경 요청 종류
        $c_PayPlus->mf_set_modx_data( "mod_ip",   $cust_ip  ); // 변경 요청자 IP
        $c_PayPlus->mf_set_modx_data( "mod_desc", $_POST[ "mod_desc" ]); // 변경 사유


    }

	/* = -------------------------------------------------------------------------- = */
    /* =   03-3. 에스크로 상태변경 요청                                             = */
    /* = -------------------------------------------------------------------------- = */
    else if ($req_tx = "mod_escrow")
	{
		$tran_cd = "00200000";
		$tno = $orderRow[O_APPR_NO]; //주문번호로 거래번호 조회
		
		$c_PayPlus->mf_set_modx_data( "tno",      $tno      );						// KCP 원거래 거래번호
        $c_PayPlus->mf_set_modx_data( "mod_type", $mod_type );						// 원거래 변경 요청 종류
        $c_PayPlus->mf_set_modx_data( "mod_ip",   $cust_ip  );						// 변경 요청자 IP
        //$c_PayPlus->mf_set_modx_data( "mod_desc", $_POST[ "mod_desc" ] );			// 변경 사유 
		
		if ($mod_type == "STE1")													// 상태변경 타입이 [배송요청]인 경우
        {
			if (!$_POST[ "deliveryCom" ]) $_POST[ "deliveryCom" ] = $deli_corp;
			if (!$_POST[ "deliveryNo" ]) $_POST[ "deliveryNo" ] = $deli_numb;

            $c_PayPlus->mf_set_modx_data( "deli_numb",   $_POST[ "deliveryNo" ] );   // 운송장 번호
            $c_PayPlus->mf_set_modx_data( "deli_corp",   $_POST[ "deliveryCom" ] );   // 택배 업체명
        }
        else if ($mod_type == "STE2" || $mod_type == "STE4") // 상태변경 타입이 [즉시취소] 또는 [취소]인 계좌이체, 가상계좌의 경우
        {
			
		    if ($vcnt_yn == "Y")
            {
                if (!$strReturnBank) $strReturnBank = $_POST[ "returnBank"      ];
				if (!$strReturnName) $strReturnName = $_POST[ "returnName"      ];
				if (!$strReturnAcc) $strReturnAcc = $_POST[ "returnAcc"      ];
								
				$c_PayPlus->mf_set_modx_data( "refund_account",   trim($strReturnAcc) );		// 환불수취계좌번호
                $c_PayPlus->mf_set_modx_data( "refund_nm",        trim(str_replace(" ","",$strReturnName)) );     // 환불수취계좌주명
				$c_PayPlus->mf_set_modx_data( "bank_code",        $strReturnBank);      // 환불수취은행코드				
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
        $c_PayPlus->mf_do_tx( $trace_no, $g_conf_home_dir, $g_conf_site_cd, "", $tran_cd, "",
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
    /* =   06. 승인 및 실패 결과 DB처리                                             = */
    /* = -------------------------------------------------------------------------- = */
	/* =       결과를 업체 자체적으로 DB처리 작업하시는 부분입니다.                 = */
    /* = -------------------------------------------------------------------------- = */
	if ( $req_tx == "mod" || $req_tx == "mod_escrow") {
		
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
				
			/* 즉시 취소 및 정산보류 */
			if ($mod_type == "STE3" || $mod_type == "STSC" || $mod_type == "STE2"){ 
				
				if (!$strReturnBank) $strReturnBank = $_POST[ "returnBank"      ];
				if (!$strReturName) $strReturName = $_POST[ "returnName"      ];
				if (!$strReturnAcc) $strReturnAcc = $_POST[ "returnAcc"      ];

				$orderMgr->setO_CEL_NO($strOrderSettleCelNo);
				$orderMgr->setO_CEL_MEMO($_POST[ "mod_desc"      ]);
				$orderMgr->setO_RETURN_BANK($strReturnBank);
				$orderMgr->setO_RETURN_ACC($strReturnAcc);
				$orderMgr->setO_RETURN_NAME($strReturName);
				
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
				if (!$strReturnBank) $strReturnBank = $_POST[ "returnBank"      ];
				if (!$strReturName) $strReturName = $_POST[ "returnName"      ];
				if (!$strReturnAcc) $strReturnAcc = $_POST[ "returnAcc"      ];
				
				$orderMgr->setO_CEL_STATUS("Y");
				$orderMgr->setO_RETURN_BANK($strReturnBank);
				$orderMgr->setO_RETURN_ACC($strReturnAcc);
				$orderMgr->setO_RETURN_NAME($strReturName);
				$orderMgr->getOrderCancelReturnUpdate($db);
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
				$result = $orderMgr->getOrderCancelUpdate($db);
				if (!$result) {
					$bSucc		= "false";
					$bSuccText	= "가상계좌해지 취소정보 update";
				}
			}
		}
	}
//
//	$strLogText = "배송정보insert(결제번호):".$orderMgr->getO_NO()."/DB오류:".$bSuccText."/res_cd=".$res_cd."/req_cd=".$req_cd."/req_tx=".$req_tx."/mod_type=".$mod_type."/res_cd=".$res_cd."/".ICONV("EUC-KR","UTF-8",$res_msg);
//	orderWriteLog($strLogText,$S_SHOP_HOME);
//	
//	$strLogPath			 = $S_SHOP_HOME;
//	$strlogFileName		 = date("Ymd").'_order.log';
//		
//	if(!file_exists($S_DOCUMENT_ROOT.$strLogPath."/logs/".$strlogFileName)) {
//		$fp = fopen($S_DOCUMENT_ROOT.$strLogPath."/logs/".$strlogFileName,"w");
//	} else {
//		$fp = fopen($S_DOCUMENT_ROOT.$strLogPath."/logs/".$strlogFileName,"a");
//	}
//
//	flock( $fp, LOCK_EX );
//	fwrite($fp,"#".date("Y-m-d H:i:s")."------------------------------------\n");
//	fwrite($fp,$strLogText);
//	fwrite($fp,"\n\n\n");
//
//	flock( $fp, LOCK_UN );
//	fclose($fp);		

	/* = -------------------------------------------------------------------------- = */
    /* =   06. 승인 및 실패 결과 DB 처리 END                                        = */
    /* = ========================================================================== = */

	// 승인 결과 DB 처리 에러시 bSucc값을 false로 설정하여 거래건을 취소 요청
	//$bSucc = ""; 

	/* = -------------------------------------------------------------------------- = */
    /* =   07. 승인 결과 DB 처리 END                                                = */
    /* = ========================================================================== = */


    /* ============================================================================== */
    /* =   08. 폼 구성 및 결과페이지 호출                                           = */
    /* ============================================================================== */


?>
