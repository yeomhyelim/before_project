<?
	switch ($strMode)
	{
		case "orderStep1":
		
			$intO_NO         = $_POST[ "order_no"       ]; // 쇼핑몰 O_NO
			$strOrderIdx	 = $_POST[ "ordr_idxx"		];
			$strNextStep	 = $_POST[ "nextStep"		]; //주문페이지에서 들어오는 경로와 결제단 취소/return 에서 들어오는 경우 구분
			$strOrderCartNo	 = $_POST[ "good_cart"		]; //주문시장바구니번호
			
			if ($strNextStep != "orderStep2"){
				if (!$intO_NO){
					$orderMgr->setO_KEY($strOrderIdx);
					$intO_NO = $orderMgr->getOrderNo($db);
					
					if ($S_SITE_LNG == "KR" && $S_PG == "K"){
						if (!$intO_NO){
							$param_opt_1 = $_POST[ "param_opt_1"    ]; // 기타 파라메터 추가 부분
							
							if ($param_opt_1){
								$intO_NO = $param_opt_1;
							}
						}
					}
				}
			}
			
			if (!$intO_NO){
				goErrMsg("주문번호가 존재하지 않습니다.");
				exit;
			}
			
			$orderMgr->setO_NO($intO_NO);
			$orderRow = $orderMgr->getOrderView($db);

			$intCartTotal= $orderMgr->getOrderCartTotal($db);
			$orderMgr->setPageLine($intCartTotal);
			$orderMgr->setLimitFirst(0);

			$cartResult = $orderMgr->getOrderCartList($db);
		
		break;
		case "orderEnd":

			$site_cd          = $_POST[ "site_cd"        ];      // 사이트코드
			$req_tx           = $_POST[ "req_tx"         ];      // 요청 구분(승인/취소)
			$use_pay_method   = $_POST[ "use_pay_method" ];      // 사용 결제 수단
			$bSucc            = $_POST[ "bSucc"          ];      // 업체 DB 정상처리 완료 여부
			/* = -------------------------------------------------------------------------- = */
			$res_cd           = $_POST[ "res_cd"         ];      // 결과코드
			$res_msg          = $_POST[ "res_msg"        ];      // 결과메시지
			$res_msg_bsucc    = "";
			/* = -------------------------------------------------------------------------- = */
			$ordr_idxx        = $_POST[ "ordr_idxx"      ];      // 주문번호
			$tno              = $_POST[ "tno"            ];      // KCP 거래번호
			$good_mny         = $_POST[ "good_mny"       ];      // 결제금액
			$good_name        = $_POST[ "good_name"      ];      // 상품명
			$buyr_name        = $_POST[ "buyr_name"      ];      // 구매자명
			$buyr_tel1        = $_POST[ "buyr_tel1"      ];      // 구매자 전화번호
			$buyr_tel2        = $_POST[ "buyr_tel2"      ];      // 구매자 휴대폰번호
			$buyr_mail        = $_POST[ "buyr_mail"      ];      // 구매자 E-Mail
			/* = -------------------------------------------------------------------------- = */
			// 공통
			$pnt_issue        = $_POST[ "pnt_issue"      ];      // 포인트 서비스사
			$app_time         = $_POST[ "app_time"       ];      // 승인시간 (공통)
			/* = -------------------------------------------------------------------------- = */
			// 신용카드
			$card_cd          = $_POST[ "card_cd"        ];      // 카드코드
			$card_name        = $_POST[ "card_name"      ];      // 카드명
			$noinf			  = $_POST[ "noinf"          ];      // 무이자 여부
			$quota            = $_POST[ "quota"          ];      // 할부개월
			$app_no           = $_POST[ "app_no"         ];      // 승인번호
			/* = -------------------------------------------------------------------------- = */
			// 계좌이체
			$bank_name        = $_POST[ "bank_name"      ];      // 은행명
			$bank_code        = $_POST[ "bank_code"      ];      // 은행코드
			/* = -------------------------------------------------------------------------- = */
			// 가상계좌
			$bankname         = $_POST[ "bankname"       ];      // 입금할 은행
			$depositor        = $_POST[ "depositor"      ];      // 입금할 계좌 예금주
			$account          = $_POST[ "account"        ];      // 입금할 계좌 번호
			/* = -------------------------------------------------------------------------- = */
			// 포인트
			$pt_idno          = $_POST[ "pt_idno"        ];      // 결제 및 인증 아이디
			$add_pnt          = $_POST[ "add_pnt"        ];      // 발생 포인트
			$use_pnt          = $_POST[ "use_pnt"        ];      // 사용가능 포인트
			$rsv_pnt          = $_POST[ "rsv_pnt"        ];      // 총 누적 포인트
			$pnt_app_time     = $_POST[ "pnt_app_time"   ];      // 승인시간
			$pnt_app_no       = $_POST[ "pnt_app_no"     ];      // 승인번호
			$pnt_amount       = $_POST[ "pnt_amount"     ];      // 적립금액 or 사용금액
			/* = -------------------------------------------------------------------------- = */
			//상품권
			$tk_van_code	  = $_POST[ "tk_van_code"    ];      // 발급사 코드
			$tk_app_no		  = $_POST[ "tk_app_no"      ];      // 승인 번호
			/* = -------------------------------------------------------------------------- = */
			//휴대폰
			$commid			  = $_POST[ "commid"		 ];      // 통신사 코드
			$mobile_no		  = $_POST[ "mobile_no"      ];      // 휴대폰 번호
			/* = -------------------------------------------------------------------------- = */
			// 현금영수증
			$cash_yn          = $_POST[ "cash_yn"        ];      //현금영수증 등록 여부
			$cash_authno      = $_POST[ "cash_authno"    ];      //현금영수증 승인 번호
			$cash_tr_code     = $_POST[ "cash_tr_code"   ];      //현금영수증 발행 구분
			$cash_id_info     = $_POST[ "cash_id_info"   ];      //현금영수증 등록 번호

			$bSuccText        = $_POST[  "bSuccText"     ];      // 업체 DB 정상처리 오류 정보
			
			$strPayFlag		  = $_POST["payFlag"]		? $_POST["payFlag"]		: $_REQUEST["payFlag"];  // PAYPAL 결제		
			/* = -------------------------------------------------------------------------- = */
			
			/* ============================================================================== */
			/* =   가맹점 측 DB 처리 실패시 상세 결과 메시지 설정                           = */
			/* = -------------------------------------------------------------------------- = */
			
			if($req_tx == "pay")
			{
				//업체 DB 처리 실패
				if($bSucc == "false")
				{
					if ($res_cd == "0000")
					{
						$res_msg_bsucc = "결제는 정상적으로 이루어졌지만 업체에서 결제 결과를 처리하는 중 오류가 발생하여 시스템에서 자동으로 취소 요청을 하였습니다. <br> 업체로 문의하여 확인하시기 바랍니다.";
					}
					else
					{
						$res_msg_bsucc = "결제는 정상적으로 이루어졌지만 업체에서 결제 결과를 처리하는 중 오류가 발생하여 시스템에서 자동으로 취소 요청을 하였으나, <br> <b>취소가 실패 되었습니다.</b><br> 업체로 문의하여 확인하시기 바랍니다.";
					}
				}
			}


			/* ============================================================================== */
			if($req_tx == "pay")
			{
				//업체 DB 처리 실패
				$strPayFlag = "success";
				if($bSucc == "false")
				{
					$strPayFlag = "fail";
					if ($res_cd == "0000")
					{
						$res_msg_bsucc = "결제는 정상적으로 이루어졌지만 업체에서 결제 결과를 처리하는 중 오류가 발생하여 시스템에서 자동으로 취소 요청을 하였습니다. <br> 업체로 문의하여 확인하시기 바랍니다.(".$bSuccText.")";
					}
					else
					{
						$res_msg_bsucc = "결제는 정상적으로 이루어졌지만 업체에서 결제 결과를 처리하는 중 오류가 발생하여 시스템에서 자동으로 취소 요청을 하였으나, <br> <b>취소가 실패 되었습니다.</b><br> 업체로 문의하여 확인하시기 바랍니다.(".$bSuccText.")";
					}
				}
			}
			
			
			if ($strPayFlag != "success"){
				$res_msg_bsucc = "[".$_SESSION['curl_error_no']."]:".$_SESSION['curl_error_msg'];
			}

			if (!$intO_NO) {
				$intO_NO = $_POST["order_no"] ? $_POST["order_no"]	: $_REQUEST["order_no"];
			}
			$orderMgr->setO_NO($intO_NO);
			$orderRow = $orderMgr->getOrderView($db);

			$intCartTotal= $orderMgr->getOrderCartTotal($db);
			$orderMgr->setPageLine($intCartTotal);
			$orderMgr->setLimitFirst(0);

			$cartResult = $orderMgr->getOrderCartList($db);
			
			/* 고객사은품 */
			$aryOrderGiftList = $orderMgr->getOrderGiftList($db);

			/* 가상계좌 은행명 */
			$aryTBank = getCommCodeList("BANK2");

			if ($orderRow[O_SETTLE] == "P" && $orderRow[O_APPR_NO]){
				$strPayFlag = "success";
			}
			
			if ($S_SITE_LNG != "KR"){
				$aryCountryList		= getCountryList();			
				$aryCountryState	= getCommCodeList("STATE","");
				$strDeliveyState = $orderRow[O_B_STATE];
				if ($orderRow[O_B_COUNTRY] == "US") $strDeliveyState = $aryCountryState[$orderRow[O_B_STATE]];
			}			
						
			$strSettleMethod = $S_ARY_SETTLE_TYPE[$orderRow[O_SETTLE]];
			if ($orderRow[O_USE_POINT] > 0 && $orderRow[O_SETTLE] != "P"){
				$strSettleMethod .= " + Point"; 
			}

			/* 입점몰/프랜차이즈몰 */
			if ($S_MALL_TYPE != "R" && $S_SITE_LNG == "KR"){
				$aryProdCartShopList = $orderMgr->getOrderCartShopList($db);
			}
			
			include WEB_FRWORK_HELP."order.orderEnd.cart.inc.php";

		break;

		case "orderNextStep":
			$intO_NO = $_REQUEST["oNo"];
			if (!$intO_NO){
				goErrMsg("주문번호가 존재하지 않습니다.");
				return;
			}

			$orderMgr->setO_NO($intO_NO);
			$orderRow = $orderMgr->getOrderView($db);

			$intCartTotal= $orderMgr->getOrderCartTotal($db);
			$orderMgr->setPageLine($intCartTotal);
			$orderMgr->setLimitFirst(0);

			$cartResult = $orderMgr->getOrderCartList($db);
	
			/* 고객사은품 */
			$aryOrderGiftList = $orderMgr->getOrderGiftList($db);

		break;
	}
?>
