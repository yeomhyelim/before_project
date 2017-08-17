<?
	require_once MALL_CONF_LIB."ProductMgr.php";
	require_once MALL_CONF_LIB."OrderMgr.php";
	require_once MALL_CONF_LIB."MemberMgr.php";
	require_once MALL_CONF_LIB."SiteMgr.php";
	require_once MALL_CONF_LIB."PointMgr.php";

	require_once $S_DOCUMENT_ROOT.$S_SHOP_HOME."/conf/member.inc.php";
	require_once $S_DOCUMENT_ROOT.$S_SHOP_HOME."/conf/order.inc.php";
	require_once $S_DOCUMENT_ROOT.$S_SHOP_HOME."/conf/site_conf_inc.php";
	require_once $S_DOCUMENT_ROOT.$S_SHOP_HOME."/conf/site_skin_order.conf.inc.php";
	require_once $S_DOCUMENT_ROOT.$S_SHOP_HOME."/conf/site_skin_member.conf.inc.php";
	require_once $S_DOCUMENT_ROOT.$S_SHOP_HOME."/conf/paypal_conf_inc.php";

	if(is_file("{$S_DOCUMENT_ROOT}{$S_SHOP_HOME}/conf/shop.manual.inc.php")):
		require_once "{$S_DOCUMENT_ROOT}{$S_SHOP_HOME}/conf/shop.manual.inc.php";
	endif;

	/*상품함수관련*/
	require_once MALL_PROD_FUNC;

	$orderMgr = new OrderMgr();
	$productMgr = new ProductMgr();
	$memberMgr = new MemberMgr();
	$siteMgr = new SiteMgr();
	$pointMgr = new PointMgr();

	$strP_CODE				= $_POST["prodCode"]			? $_POST["prodCode"]			: $_REQUEST["prodCode"];
	$intO_NO				= $_POST["oNo"]					? $_POST["oNo"]					: $_REQUEST["oNo"];

	$intPB_NO				= $_POST["cartNo"]				? $_POST["cartNo"]				: $_REQUEST["cartNo"];
	$intPW_NO				= $_POST["wishNo"]				? $_POST["wishNo"]				: $_REQUEST["wishNo"];

	$intNo					= $_POST["no"]					? $_POST["no"]					: $_REQUEST["no"];

	$strSearchHCode1		= $_POST["lcate"]				? $_POST["lcate"]				: $_REQUEST["lcate"];
	$strSearchHCode2		= $_POST["mcate"]				? $_POST["mcate"]				: $_REQUEST["mcate"];
	$strSearchHCode3		= $_POST["scate"]				? $_POST["scate"]				: $_REQUEST["scate"];
	$strSearchHCode4		= $_POST["fcate"]				? $_POST["fcate"]				: $_REQUEST["fcate"];

	$intCartPage			= $_POST["cartPage"]			? $_POST["cartPage"]			: $_REQUEST["cartPage"];
	$intWishPage			= $_POST["wishPage"]			? $_POST["wishPage"]			: $_REQUEST["wishPage"];
	$intPage				= $_POST["page"]				? $_POST["page"]				: $_REQUEST["page"];


	/*################주문공통단################*/
	include WEB_FRWORK_HELP."order.order.php";
	/*################주문공통단################*/

//	echo $strMode;

	switch ($strMode)
	{
		case "orderEnd":
			/* ============================================================================== */
			/* =   지불 결과                                                                = */
			/* = -------------------------------------------------------------------------- = */
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
			$va_date          = $_POST[ "va_date"        ];      // 가상계좌 입금마감일자
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
			//휴대폰
			$commid			  = $_POST[ "commid"		 ];      // 통신사 코드
			$mobile_no		  = $_POST[ "mobile_no"      ];      // 휴대폰 번호
			/* = -------------------------------------------------------------------------- = */
			//상품권
			$tk_van_code	  = $_POST[ "tk_van_code"    ];      // 발급사 코드
			$tk_app_no		  = $_POST[ "tk_app_no"      ];      // 승인 번호
			/* = -------------------------------------------------------------------------- = */
			// 현금영수증
			$cash_yn          = $_POST[ "cash_yn"        ];      //현금영수증 등록 여부
			$cash_authno      = $_POST[ "cash_authno"    ];      //현금영수증 승인 번호
			$cash_tr_code     = $_POST[ "cash_tr_code"   ];      //현금영수증 발행 구분
			$cash_id_info     = $_POST[ "cash_id_info"   ];      //현금영수증 등록 번호
			/* = -------------------------------------------------------------------------- = */
			// 에스크로
			$escw_yn          = $_POST[  "escw_yn"       ];      // 에스크로 사용 여부
			$deli_term        = $_POST[  "deli_term"     ];      // 배송 소요일
			$bask_cntx        = $_POST[  "bask_cntx"     ];      // 장바구니 상품 개수
			$good_info        = $_POST[  "good_info"     ];      // 장바구니 상품 상세 정보
			$rcvr_name        = $_POST[  "rcvr_name"     ];      // 수취인 이름
			$rcvr_tel1        = $_POST[  "rcvr_tel1"     ];      // 수취인 전화번호
			$rcvr_tel2        = $_POST[  "rcvr_tel2"     ];      // 수취인 휴대폰번호
			$rcvr_mail        = $_POST[  "rcvr_mail"     ];      // 수취인 E-Mail
			$rcvr_zipx        = $_POST[  "rcvr_zipx"     ];      // 수취인 우편번호
			$rcvr_add1        = $_POST[  "rcvr_add1"     ];      // 수취인 주소
			$rcvr_add2        = $_POST[  "rcvr_add2"     ];      // 수취인 상세주소

			$bSuccText        = $_POST[  "bSuccText"     ];      // 업체 DB 정상처리 오류 정보

			$strPayFlag		  = $_POST["payFlag"] ? $_POST["payFlag"] : $_REQUEST["payFlag"]; // PAYPAL 결제
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
			if ($orderRow['O_USE_LNG'] == "KR"){
				if ($orderRow['O_PG'] == "K"){
					$aryTBank = getCommCodeList("BANK2");

					$strReturnBankName = $aryTBank[$orderRow['O_BANK']];
				}

				if ($orderRow['O_PG'] == "A"){
					$strReturnBankName = $S_ARY_RETURN_BANK[$orderRow['O_BANK']];
				}
			}
			/* 가상계좌 은행명 */


			if (($orderRow[O_SETTLE] == "B" || $orderRow[O_SETTLE] == "P") && $orderRow[O_APPR_NO]){
				$strPayFlag = "success";
			}

			if ($S_SITE_LNG != "KR"){
				$aryCountryList		= getCountryList();
				$aryCountryState	= getCommCodeList("STATE","");
				$strDeliveyState = $orderRow[O_B_STATE];
				if ($orderRow[O_B_COUNTRY] == "US") $strDeliveyState = $aryCountryState[$orderRow[O_B_STATE]];

				if ($orderRow['O_DELIVERY_COM']){
					$aryDeliveryCom = getCommCodeList("DELIVERY","Y");
					$strDeliveryCom = $aryDeliveryCom[$orderRow['O_DELIVERY_COM']];
				}
			}

			$strSettleMethod = $S_ARY_SETTLE_TYPE[$orderRow[O_SETTLE]];
			if ($orderRow[O_USE_POINT] > 0 && $orderRow[O_SETTLE] != "P"){
				$strSettleMethod .= " + Point";
			}

			/* 입점몰/프랜차이즈몰 */
			if ($S_MALL_TYPE != "R" && $S_SITE_LNG == "KR"){
				$aryProdCartShopList = $orderMgr->getOrderCartShopList($db);

				if (is_array($aryProdCartShopList)){
					foreach ($aryProdCartShopList as $key => $value){

						$aryProdShopRow = $value;
						$orderMgr->setP_SHOP_NO($key);
						$orderMgr->setLimitFirst(0);
						$orderMgr->setPageLine($value['CART_CNT']);
						$orderCartRet = $orderMgr->getOrderCartList($db);

						while($orderCartShopRow = mysql_fetch_array($orderCartRet)){

							/* 착불배송비 설정 (14.09.03)*/
							if ($orderCartShopRow['P_BAESONG_TYPE'] == "5") {
								$aryProdCartShopList[$key]['AFTER_CHARGE_CNT'] += 1;
							}
						}
					}
				}
			}

			/* 배송지정보 보여주기 확인 */
			$strOrderDeliveryInfoViewYN = "Y";
			if ($S_FIX_ORDER_DELIVERY_INFO_YN == "N" && $S_SITE_LNG == "KR"){
				$strOrderDeliveryInfoViewYN = "N";
				/* 배송비가 존재하는 상품 카테고리가 존재할 경우 배송정보가 존재하면 */
				if (is_array($S_FIX_ORDER_DELIVERY_PROD_CATE)){
					if ($orderRow['O_B_NAME'] && $orderRow['O_B_HP'] && $orderRow['O_B_ADDR1']){
						$strOrderDeliveryInfoViewYN = "Y";
					}
				}
			}

			if ($S_SITE_LNG != "KR"){
				$strOrderDeliveryInfoViewYN = "N";
				if ($S_DELIVERY_FOR_MTH != "N") {
					$strOrderDeliveryInfoViewYN = "Y";
				} else {
					if (is_array($S_FIX_ORDER_DELIVERY_PROD_CATE)){
						if ($orderRow['O_B_NAME'] && $orderRow['O_B_HP'] && $orderRow['O_B_ADDR1']){
							$strOrderDeliveryInfoViewYN = "Y";
						}
					}
				}
			}

			include WEB_FRWORK_HELP."order.orderEnd.cart.inc.php";

		break;

		case "nextOrderStep":

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

	/*################공통 자바스크립트################*/
	include WEB_FRWORK_JS.$strMenuType.".js.php";
	/*################공통 자바스크립트################*/

	/*################모드별 자바스크립트################*/


//	if ($S_REMOTE_ADDR == "106.245.166.61"){
//	include WEB_FRWORK_JS."order_".$strMode.".demo.js.php";
//	}else{
//	include WEB_FRWORK_JS."order_".$strMode.".js.php";
//	}

	include WEB_FRWORK_JS."order_".$strMode.".js.php";

	/*################모드별 자바스크립트################*/

	if ($strMode == "order"){

		$strModeLngJsFile = "kr";
		if ($S_SITE_LNG != "KR"){
			$strModeLngJsFile = "for";
		}

//		if ($S_REMOTE_ADDR == "106.245.166.61"){
//			include WEB_FRWORK_JS."order_".$strMode.".".$strModeLngJsFile.".demo.js.php";
//		}
		include WEB_FRWORK_JS."order_".$strMode.".".$strModeLngJsFile.".js.php";

		if ($S_SITE_LNG == "KR")
			include WEB_FRWORK_JS . 'order_' . $strMode . '.' . $S_PG . '.js.php' ;
	}

?>
