<?
	if ($S_SITE_LNG == "KR"){
		switch ($S_PG){
			case "K":
				/* kcp와 통신후 kcp 서버에서 전송되는 결제 요청 정보*/
				$req_tx          = $_POST[ "req_tx"         ]; // 요청 종류          
				$res_cd          = $_POST[ "res_cd"         ]; // 응답 코드          
				$tran_cd         = $_POST[ "tran_cd"        ]; // 트랜잭션 코드      
				$ordr_idxx       = $_POST[ "ordr_idxx"      ]; // 쇼핑몰 주문번호    
				$good_name       = $_POST[ "good_name"      ]; // 상품명             
				$good_mny        = $_POST[ "good_mny"       ]; // 결제 총금액        
				$buyr_name       = $_POST[ "buyr_name"      ]; // 주문자명           
				$buyr_tel1       = $_POST[ "buyr_tel1"      ]; // 주문자 전화번호    
				$buyr_tel2       = $_POST[ "buyr_tel2"      ]; // 주문자 핸드폰 번호 
				$buyr_mail       = $_POST[ "buyr_mail"      ]; // 주문자 E-mail 주소 
				$use_pay_method  = $_POST[ "use_pay_method" ]; // 결제 방법          
				$enc_info        = $_POST[ "enc_info"       ]; // 암호화 정보        
				$enc_data        = $_POST[ "enc_data"       ]; // 암호화 데이터  
				$van_code        = $_POST[ "van_code"       ];
				$cash_yn         = $_POST[ "cash_yn"        ];
				$cash_tr_code    = $_POST[ "cash_tr_code"   ];
				
				$rcvr_name		 = $_POST[ "rcvr_name"		]; // 수취인 이름
				$rcvr_tel1		 = $_POST[ "rcvr_tel1"		]; // 수취인 전화번호
				$rcvr_tel2		 = $_POST[ "rcvr_tel2"		]; // 수취인 휴대폰번호
				$rcvr_mail		 = $_POST[ "rcvr_mail"		]; // 수취인 E-Mail
				$rcvr_zipx		 = $_POST[ "rcvr_zipx"		]; // 수취인 우편번호
				$rcvr_add1		 = $_POST[ "rcvr_add1"		]; // 수취인 주소
				$rcvr_add2		 = $_POST[ "rcvr_add2"		]; // 수취인 상세주소

				/*
				 * 기타 파라메터 추가 부분 - Start -
				 */
				$param_opt_1     = $_POST[ "param_opt_1"    ]; // 기타 파라메터 추가 부분
				$param_opt_2     = $_POST[ "param_opt_2"    ]; // 기타 파라메터 추가 부분
				$param_opt_3     = $_POST[ "param_opt_3"    ]; // 기타 파라메터 추가 부분
				/*
				 * 기타 파라메터 추가 부분 - End -
				 */
				
				/*
				 * 과세/비과세
				 */
				$comm_tax_mny	= $_POST[ "comm_tax_mny"    ];
				$comm_vat_mny	= $_POST[ "comm_vat_mny"    ];
				$comm_free_mny	= $_POST[ "comm_free_mny"    ];
				
				if ($strNextStep != "orderStep2"){
					if ($enc_data == "" || $enc_info == "" || $tran_cd == ""){
						/* 주문정보 KEY 생성*/
						$strOrderIdx = date("Ymd").STRTOUPPER(getOrderRandCode(5)).$orderMgr->getOrderKey($db);
						$orderMgr->setO_KEY($strOrderIdx);
						$intDupKeyCnt = $orderMgr->getOrderDupKey($db);
						
						if ($intDupKeyCnt > 0){
							$strFlag = false;

							while($strFlag == false){

								$strOrderIdx = date("Ymd").STRTOUPPER(getOrderRandCode(5)).$orderMgr->getOrderKey($db);
								$orderMgr->setO_KEY($strOrderIdx);
								$intDupKeyCnt = $orderMgr->getOrderDupKey($db);
								
								if($intDupKeyCnt=="0"){
									$strFlag = true;
									break;
								}
							}			
						}

						$orderMgr->setO_KEY($strOrderIdx);
						$orderMgr->getOrderCopyUpdate($db);

						$ordr_idxx = $strOrderIdx;
					}
				}
						
				$tablet_size      = "1.0"; // 화면 사이즈 조정 - 기기화면에 맞게 수정(갤럭시탭,아이패드 - 1.85, 스마트폰 - 1.0)

				if ($orderRow[O_SETTLE] == "C"){					
					$strPayMethod		= "CARD";
					$strPayActionResult = "card";
					$strPayEscw			= "N";
					$strPayUsePayMth	= "100000000000";
					$strPayMode			= "N";

					$includeOrderStep1File = MALL_MOB_PATH."order/kcp/order_payMth.php";
				} else if ($orderRow[O_SETTLE] == "A"){
					$strPayMethod		= "BANK";
					$strPayActionResult = "acnt";
					$strPayEscw			= "N";
					$strPayUsePayMth	= "010000000000";
					$strPayMode			= "O";

					$includeOrderStep1File = MALL_MOB_PATH."order/kcp/order_payMth.php";
				} else if ($orderRow[O_SETTLE] == "T"){
				
					$strPayMethod		= "VCNT";
					$strPayActionResult = "vcnt";
					$strPayEscw			= ($S_PG_ESCROW != "N") ? "Y" : "N";
					$strPayUsePayMth	= "001000000000";	
					$strPayMode			= "O";
							
					$includeOrderStep1File = MALL_MOB_PATH."order/kcp/order_payMth.php";
				} else if ($orderRow[O_SETTLE] == "M"){
				
					$strPayMethod		= "MOBX";
					$strPayActionResult = "mobx";
					$strPayEscw			= "N";
					$strPayUsePayMth	= "000010000000";	
					$strPayMode			= "N";
							
					$includeOrderStep1File = MALL_MOB_PATH."order/kcp/order_payMth.php";
				}
				
				$orderMgr->setOC_LIST_ARY("Y");
				$aryProdBasketList = $orderMgr->getOrderCartList($db);
				$intProdCnt = 0;
				if (is_array($aryProdBasketList)){

					$strOrderCartInfoList = "";
					for($i=0;$i<sizeof($aryProdBasketList);$i++){

						/* kcp 에스크로 결제에 필요한 변수설정 */
						$strOrderCartInfoList .= "seq=".($i+1);
						$strOrderCartInfoList .= "{+}"."ordr_numb=".($intO_NO."_".pushHeadZero(($i+1),4));
						$strOrderCartInfoList .= "{+}"."good_name=".$aryProdBasketList[$i][P_NAME];
						$strOrderCartInfoList .= "{+}"."good_cntx=".$aryProdBasketList[$i][OC_QTY];
						$strOrderCartInfoList .= "{+}"."good_amtx=".(($aryProdBasketList[$i][OC_QTY]*$aryProdBasketList[$i][OC_PRICE]) + $aryProdBasketList[$i][OC_ADD_OPT_PRICE]);
						if ($i != sizeof($aryProdBasketList) - 1) $strOrderCartInfoList .= "{-}";
						
						$intProdCnt++;
					}
				}

				/* 입점몰/프랜차이즈몰 */
				if ($S_MALL_TYPE != "R" && $S_SITE_LNG == "KR"){
					$param					= "";
					$param['O_NO']			= $intO_NO;
					$arrOrderCartShopList	= $orderMgr->getOrderCartShopSumList($db,$param);
				}

			break;
		}
	}

	include $includeOrderStep1File;
	function unichr($dec) { 
	  if ($dec < 128) { 
		$utf = chr($dec); 
	  } else if ($dec < 2048) { 
		$utf = chr(192 + (($dec - ($dec % 64)) / 64)); 
		$utf .= chr(128 + ($dec % 64)); 
	  } else { 
		$utf = chr(224 + (($dec - ($dec % 4096)) / 4096)); 
		$utf .= chr(128 + ((($dec % 4096) - ($dec % 64)) / 64)); 
		$utf .= chr(128 + ($dec % 64)); 
	  } 
	  return $utf;
	 } 
?>
