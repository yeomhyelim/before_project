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

	$strSearchField			= $_POST["searchField"]			? $_POST["searchField"]			: $_REQUEST["searchField"];
	$strSearchKey			= $_POST["searchKey"]			? $_POST["searchKey"]			: $_REQUEST["searchKey"];
	$strSearchOrderStatus   = $_POST["searchOrderStatus"]	? $_POST["searchOrderStatus"]	: $_REQUEST["searchOrderStatus"];

	$strSearchOrderKey		= $_POST["searchOrderKey"]		? $_POST["searchOrderKey"]		: $_REQUEST["searchOrderKey"];
	$strSearchOrderName		= $_POST["searchOrderName"]		? $_POST["searchOrderName"]		: $_REQUEST["searchOrderName"];

	$strSearchHCode1		= $_POST["lcate"]				? $_POST["lcate"]				: $_REQUEST["lcate"];
	$strSearchHCode2		= $_POST["mcate"]				? $_POST["mcate"]				: $_REQUEST["mcate"];
	$strSearchHCode3		= $_POST["scate"]				? $_POST["scate"]				: $_REQUEST["scate"];
	$strSearchHCode4		= $_POST["fcate"]				? $_POST["fcate"]				: $_REQUEST["fcate"];

	$intCartPage			= $_POST["cartPage"]			? $_POST["cartPage"]			: $_REQUEST["cartPage"];
	$intWishPage			= $_POST["wishPage"]			? $_POST["wishPage"]			: $_REQUEST["wishPage"];
	$intPage				= $_POST["page"]				? $_POST["page"]				: $_REQUEST["page"];
	
	$intPR_NO				= $_POST["pr_no"]				? $_POST["pr_no"]				: $_REQUEST["pr_no"]; //브랜드코드

//	$siteRow = $siteMgr->getSiteInfo($db);

	/*################주문공통단################*/ 
	include WEB_FRWORK_HELP."order.order.php";
	/*################주문공통단################*/ 

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
			
			$strPayFlag		  = $_GET[  "payFlag"		 ];		 // PAYPAL 결제
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
		break;

		case "buyList":
			if (!$g_member_no)
			{
				if($S_MAIN_LAYERPOP_LOGIN_USE=="Y" && $strDevice != "m") {
					goUrl("","./");
				} else goUrl("","./?menuType=member&mode=login&returnMenu=order&returnMode=buyList");
				exit;
			}
			
			$orderMgr->setM_NO($g_member_no);
			
			$strTabSelectClass1 = "";
			$strTabSelectClass2 = "";
			$strTabSelectClass3 = "";
			$strTabSelectClass4 = "";

			if ($strSearchOrderStatus == "") $strTabSelectClass1 = "class=\"selectedTab\""; 
			if ($strSearchOrderStatus == "UI") $strTabSelectClass2 = "class=\"selectedTab\""; 
			if ($strSearchOrderStatus == "E") $strTabSelectClass3 = "class=\"selectedTab\"";
			if ($strSearchOrderStatus == "R") $strTabSelectClass4 = "class=\"selectedTab\"";

			/* 상태별 주문 갯수 구하기*/
			$intOrderTotal	= $orderMgr->getOrderTotal($db);
			$orderMgr->setSearchOrderStatus("UI");
			$intOrderDeliveryTotal	= $orderMgr->getOrderTotal($db);

			$orderMgr->setSearchOrderStatus("E");
			$intOrderEndTotal	= $orderMgr->getOrderTotal($db);

			$orderMgr->setSearchOrderStatus("R");
			$intOrderBackTotal	= $orderMgr->getOrderTotal($db);

			$orderMgr->setSearchOrderStatus("A");
			$intOrderApprTotal	= $orderMgr->getOrderTotal($db);

			$orderMgr->setSearchOrderStatus("J");
			$intOrderWaitTotal	= $orderMgr->getOrderTotal($db);


			/* 검색부분 */
			$orderMgr->setSearchField($strSearchField);
			$orderMgr->setSearchKey($strSearchKey);
			$orderMgr->setSearchOrderStatus($strSearchOrderStatus);
			
			/* 검색부분 */
			$intPageBlock	= 10;
			$intPageLine	= 10;
			
			$orderMgr->setPageLine($intPageLine);
	
			$intTotal	= $orderMgr->getOrderTotal($db);
			$intTotPage	= ceil($intTotal / $orderMgr->getPageLine());

			if(!$intPage)	$intPage =1;

			if ($intTotal==0) {
				$intFirst	= 1;
				$intLast	= 0;			
			} else {
				$intFirst	= $intPageLine *($intPage -1);
				$intLast	= $intPageLine * $intPage;
			}
			$orderMgr->setLimitFirst($intFirst);

			$result = $orderMgr->getOrderList($db);
			$intListNum = $intTotal - ($intPageLine *($intPage-1));	
			
			$linkPage  = "?menuType=$strMenuType&mode=$strMode";
			$linkPage .= "&searchField=$strSearchField&searchKey=$strSearchKey";
			$linkPage .= "&searchOrderStatus=$strSearchOrderStatus&page=";
			
			/*배송회사*/
//			$aryDeliveryCom = getCommCodeList("DELIVERY");
			$aryDeliveryCom	= getCommCodeList("DELIVERY","Y");
			$aryDeliveryUrl	= getDeliveryUrlList();
		break;

		case "buyView":
		case "buyNonView";
			
			$orderMgr->setO_NO($intO_NO);
			$orderRow = $orderMgr->getOrderView($db);

			$intCartTotal= $orderMgr->getOrderCartTotal($db);
			$orderMgr->setPageLine($intCartTotal);
			$orderMgr->setLimitFirst(0);

			$cartResult = $orderMgr->getOrderCartList($db);

			/* 가상계좌 은행 */
			$aryTBank = getCommCodeList("BANK2");

			if ($S_SITE_LNG != "KR"){
				$aryCountryList		= getCountryList();			
				$aryCountryState	= getCommCodeList("STATE","");
				$strDeliveyState	= $orderRow[O_B_STATE];
				if ($orderRow[O_B_COUNTRY] == "US") $strDeliveyState = $aryCountryList[$orderRow[O_B_STATE]];
			}			

			/* 입점몰/프랜차이즈몰 */
			if ($S_MALL_TYPE != "R" && $S_SITE_LNG == "KR"){
				$aryProdCartShopList = $orderMgr->getOrderCartShopList($db);
			}

			/* 고객사은품 */
			$aryOrderGiftList = $orderMgr->getOrderGiftList($db);

		break;

		case "cartMyList":
			
			$productMgr->setSearchField($strSearchField);
			$productMgr->setSearchKey($strSearchKey);
			$productMgr->setPB_KEY($g_cart_prikey);

			$intPageBlock	= 10;
			$intPageLine	= 10;
			
			$productMgr->setPageLine($intPageLine);
	
			$intCartTotal	= $productMgr->getProdBasketTotal($db);
			$intCartTotPage	= ceil($intCartTotal / $productMgr->getPageLine());
			$productMgr->setPageLine($intCartTotal);

			if(!$intCartPage)	$intCartPage =1;

			if ($intCartTotal==0) {
				$intCartFirst	= 1;
				$intCartLast	= 0;			
			} else {
				$intCartFirst	= $intPageLine *($intCartPage -1);
				$intCartLast	= $intPageLine * $intCartPage;
			}
			$productMgr->setLimitFirst($intCartFirst);

			$cartResult = $productMgr->getProdBasketList($db);
			$intCartListNum = $intCartTotal - ($intPageLine *($intCartPage-1));		
			
			$linkCartPage  = "?menuType=$strMenuType&mode=$strMode";
			$linkCartPage .= "&searchField=$strSearchField&searchKey=$strSearchKey";
			$linkCartPage .= "&wishPage=$intWishPage&cartPage=";
			
			/* 입점몰/프랜차이즈 KR(장바구니에 담기 상품을 기준으로 입점몰번호로 배송비를 구한다 */
			if ($S_MALL_TYPE != "R" && $S_SITE_LNG == "KR"){
				$aryProdBasketShopList = $productMgr->getProdBasketShopList($db);
				
				$intProdBasketDeliveryTotal = 0;
				if (is_array($aryProdBasketShopList)){
					$intProdBasketDeliveryTotal = 0;
					foreach ($aryProdBasketShopList as $key => $value){
						for($i=1;$i<=5;$i++){
							$aryDeliveryPrice[$i] = 0;
						}

						$aryProdShopRow = $value;					
						$productMgr->setP_SHOP_NO($key);
						$productMgr->setLimitFirst(0);
						$productMgr->setPageLine($aryProdShopRow[BASKET_CNT]);
						$prodBasketRet = $productMgr->getProdBasketList($db);
						
						$intProdBasketDeliveryPrice = 0;
						$aryDeliveryPrice = null;
						while($prodBasketRow = mysql_fetch_array($prodBasketRet)){

							$intProdBasketPrice = ($prodBasketRow[PB_PRICE] * $prodBasketRow[PB_QTY]) + $prodBasketRow[PB_ADD_OPT_PRICE];
							$intProdBasketDeliveryPrice = getProdDeliveryPrice($prodBasketRow,$SHOP_ARY_DELIVERY,$intProdBasketPrice,$prodBasketRow[PB_QTY],$value);
							$aryDeliveryPrice[$prodBasketRow[P_BAESONG_TYPE]] += $intProdBasketDeliveryPrice;
						}
										
						$intProdBasketShopDeliveryTotal = getCartDeliveryPrice($aryDeliveryPrice,$value[BASKET_PRICE],$SHOP_ARY_DELIVERY,$value);
						$aryProdBasketShopList[$key][DELIVERY_PRICE] = $intProdBasketShopDeliveryTotal;
						$intProdBasketDeliveryTotal = $intProdBasketDeliveryTotal + $intProdBasketShopDeliveryTotal; 
					}
				}
			}
			
		break;

		case "wishMyList":

			/* wish 리스트 */	
			$intPageBlock	= 10;
			$intPageLine	= 10;

			$productMgr->setPageLine($intPageLine);
			if ($g_member_no){

				$productMgr->setM_NO($g_member_no);
				$intWishTotal	= $productMgr->getProdWishTotal($db);
				$intWishTotPage	= ceil($intWishTotal / $productMgr->getPageLine());

				if(!$intWishPage)	$intWishPage =1;

				if ($intWishTotal==0) {
					$intWishFirst	= 1;
					$intWishLast	= 0;			
				} else {
					$intWishFirst	= $intPageLine *($intWishPage -1);
					$intWishLast	= $intPageLine * $intWishPage;
				}
				$productMgr->setLimitFirst($intWishFirst);

				$wishResult = $productMgr->getProdWishList($db);
				$intWishListNum = $intWishTotal - ($intPageLine *($intWishPage-1));		
				
				$linkWishPage  = "?menuType=$strMenuType&mode=$strMode";
				$linkWishPage .= "&searchField=$strSearchField&searchKey=$strSearchKey";
				$linkWishPage .= "&wishPage=";
			}			
		break;

		case "myInfo":

			if (!$g_member_no)
			{
				if($S_MAIN_LAYERPOP_LOGIN_USE=="Y" && $strDevice != "m") {
					goUrl("","./");
				} else goUrl("","./?menuType=member&mode=login&returnMenu=order&returnMode=myInfo");
				exit;
			}
			$memberMgr->setM_NO($g_member_no);
			$memberRow = $memberMgr->getMemberView($db);

			$aryMemHp		= explode("-",$memberRow[M_HP]);	// 휴대폰
			$aryMemPhone	= explode("-",$memberRow[M_PHONE]);	// 전화
			$aryMemFax		= explode("-",$memberRow[M_FAX]);	// 팩스
			$aryMemZip		= explode("-",$memberRow[M_ZIP]);	// 우편번호
			$aryMemWedDay	= explode("-",$memberRow[M_WED_DAY]);	// 결혼기념일
			$aryMemBusiNum	= explode("-",$memberRow[M_BUSI_NUM]);	// 사업자번호
			$aryMemBusiZip	= explode("-",$memberRow[M_BUSI_ZIP]);	// 사업자 우편번호

			$strSmsYN	= $memberRow[M_SMSYN] == 'Y' ? "checked" : "";		// SMS 수신여부
			$strMailYN	= $memberRow[M_MAILYN] == 'Y' ? "checked" : "";		//	메일 수신여부

			$aryHp		= getCommCodeList("HP");			// 휴대폰 (콤보박스 리스트)
			$aryPhone	= getCommCodeList("PHONE");
			$aryJob		= getCommCodeList("JOB");
			$aryConcern	= getCommCodeList("CONCERN");

			/* 국가 리스트 */
			if ($S_SITE_LNG != "KR"){
				$aryCountryList		= getCountryList();			
				$aryCountryState	= getCommCodeList("STATE","");
			}

			/* 가족 관계 리스트 */
			if ($S_MEM_FAMILY == "Y"){
				$aryMemberFamilyList = $memberMgr->getMemberFamilyList($db);
			}

		break;

		case "buyNonList":

			if (!$strSearchOrderKey || !$strSearchOrderName)
			{
				$db->disConnect();
				goErrMsg($LNG_TRANS_CHAR['OS00006']); //주문자 및 주문번호가 존재하지 않습니다.
				exit;
			}

			/* 검색부분 */

			$orderMgr->setSearchOrderKey($strSearchOrderKey);
			$orderMgr->setSearchOrderName($strSearchOrderName);

			$orderMgr->setSearchField($strSearchField);
			$orderMgr->setSearchKey($strSearchKey);
			
			/* 검색부분 */
			$intPageBlock	= 10;
			$intPageLine	= 10;
			
			$orderMgr->setPageLine($intPageLine);
	
			$intTotal	= $orderMgr->getOrderTotal($db);
			$intTotPage	= ceil($intTotal / $orderMgr->getPageLine());

			if ($intTotal == 0){
				$db->disConnect();
				goErrMsg($LNG_TRANS_CHAR['OS00007']); //주문자 및 주문번호에 해당하는 주문내역이 존재하지 않습니다.
				exit;
			}
			
			if(!$intPage)	$intPage =1;

			if ($intTotal==0) {
				$intFirst	= 1;
				$intLast	= 0;			
			} else {
				$intFirst	= $intPageLine *($intPage -1);
				$intLast	= $intPageLine * $intPage;
			}
			$orderMgr->setLimitFirst($intFirst);

			$result = $orderMgr->getOrderList($db);
			$intListNum = $intTotal - ($intPageLine *($intPage-1));	
			
			$linkPage  = "?menuType=$strMenuType&mode=$strMode";
			$linkPage .= "&searchField=$strSearchField&searchKey=$strSearchKey";
			$linkPage .= "&searchOrderKey=$strSearchOrderKey&searchOrderName=$strSearchOrderName&page=";
			
			/*배송회사*/
			$aryDeliveryCom = getCommCodeList("DELIVERY");
		break;
		case "pointList":
			
			if (!$g_member_no)
			{
				if($S_MAIN_LAYERPOP_LOGIN_USE=="Y" && $strDevice != "m") {
					goUrl("","./");
				} else goUrl("","./?menuType=member&mode=login&returnMenu=order&returnMode=myInfo");
				exit;
			}
			$memberMgr->setM_NO($g_member_no);
			$pointMgr->setM_NO($g_member_no);

			$memberRow = $memberMgr->getMemberView($db);

			$intPageBlock = 10;
			$intPageLine  = 10;
			$pointMgr->setPageLine($intPageLine);
			$pointMgr->setSearchKey($strSearchKey);
			$pointMgr->setSearchField($strSearchField);
			$pointMgr->setSearchPointType($strSearchPointType);

			$intTotal	= $pointMgr->getPointTotal($db);
			
			$intTotPage	= ceil($intTotal / $pointMgr->getPageLine());

			if(!$intPage)	$intPage =1;

			if ($intTotal==0) {
				$intFirst	= 1;
				$intLast	= 0;			
			} else {
				$intFirst	= $intPageLine *($intPage -1);
				$intLast	= $intPageLine * $intPage;
			}
			$pointMgr->setLimitFirst($intFirst);

			$result = $pointMgr->getPointList($db);		

			$intListNum = $intTotal - ($intPageLine *($intPage-1));		
			
			$linkPage  = "?menuType=$strMenuType&mode=$strMode";
			$linkPage .= "&searchField=$strSearchField&searchKey=$strSearchKey";
			$linkPage .= "&searchPointType=$strSearchPointType";
			$linkPage .= "&page=";

			/* 포인트 종류 배열 */
			$aryPointTypeList = getCommCodeList('point');
			
			/* 포인트 소멸 일자 */
			$strPointEndDt = date("Y-m-d",mktime(0,0,0,date("m"),date("d"),date("Y")+1));
		break;

		case "addrList":
			
			if (!$g_member_no)
			{
				if($S_MAIN_LAYERPOP_LOGIN_USE=="Y" && $strDevice != "m") {
					goUrl("","./");
				} else goUrl("","./?menuType=member&mode=login&returnMenu=order&returnMode=myInfo");
				exit;
			}

			$memberMgr->setM_NO($g_member_no);
			$aryMemberAddrList = $memberMgr->getMemberAddrList($db);
			
			/* 국가 리스트 */
			$aryCountryList		= getCountryList();			
			$aryCountryState	= getCommCodeList("STATE","");
			
		break;

		case "couponList":
			if (!$g_member_no)
			{
				if($S_MAIN_LAYERPOP_LOGIN_USE=="Y" && $strDevice != "m") {
					goUrl("","./");
				} else goUrl("","./?menuType=member&mode=login&returnMenu=order&returnMode=couponList");
				exit;
			}
			$memberMgr->setM_NO($g_member_no);

			$intPageBlock = 10;
			$intPageLine  = 10;
			$memberMgr->setPageLine($intPageLine);
			
			$intTotal	= $memberMgr->getMemberCouponList($db,"Count");
			$intTotPage	= ceil($intTotal / $memberMgr->getPageLine());
			if(!$intPage)	$intPage =1;

			if ($intTotal==0) {
				$intFirst	= 1;
				$intLast	= 0;			
			} else {
				$intFirst	= $intPageLine *($intPage -1);
				$intLast	= $intPageLine * $intPage;
			}
			$memberMgr->setLimitFirst($intFirst);
			$result = $memberMgr->getMemberCouponList($db,"List");
			

			$intListNum = $intTotal - ($intPageLine *($intPage-1));		
			
			$linkPage  = "?menuType=$strMenuType&mode=$strMode";
			$linkPage .= "&page=";

		break;

	}
?>
<?if ($strMode=="order"){?>
<?if ($S_SITE_LNG == "KR" && !$strDevice && $strDevice != "m"){?>
<script type="text/javascript" src='<?=$g_conf_js_url?>'></script>
<script type="text/javascript">
<!--
	/* 플러그인 설치(확인) */

    StartSmartUpdate();

	/* Payplus Plug-in 실행 */
	function  jsf__pay( form )
	{
		var RetVal = false;

		if( document.Payplus.object == null )
		{
			openwin = window.open( "/common/kcp/chk_plugin.html", "chk_plugin", "width=420, height=100, top=300, left=300" );
		}

		/* Payplus Plugin 실행 */
		if ( MakePayMessage( form ) == true )
		{
			//openwin = window.open( "/common/kcp/proc_win.html", "proc_win", "width=449, height=209, top=300, left=300" );
			RetVal = true ;
		}
		
		else
		{
			/*  res_cd와 res_msg변수에 해당 오류코드와 오류메시지가 설정됩니다.
				ex) 고객이 Payplus Plugin에서 취소 버튼 클릭시 res_cd=3001, res_msg=사용자 취소
				값이 설정됩니다.
			*/
			res_cd  = document.form.res_cd.value ;
			res_msg = document.form.res_msg.value ;

			alert ( "Payplus Plug-in 실행 결과\n" + "res_cd = " + res_cd + "|" + "res_msg=" + res_msg ) ;
			goInitLoading("");

		}

		return RetVal ;
	}

	// Payplus Plug-in 설치 안내 
	function init_pay_button()
	{
		if( document.Payplus.object == null )
			document.getElementById("display_setup_message").style.display = "block" ;
		else
			document.getElementById("display_pay_button").style.display = "block" ;
	}

//-->
</script>
<?}?>
<?}?>
<script type="text/javascript">
<!--
	var intM_NO = "<?=$g_member_no?>";
	var intOrderTotalSPriceOrg = "";

	var intOrderDeliveryPrice		= "";
	var aryOrderDeliveryGroupInfo	= ""; //상품배송(그룹배송)
	var aryOrderDeliveryWeightInfo	= ""; //상품배송(해외배송)
	var aryOrderDeliveryCountryInfo = ""; //상품배송국가
	var aryMemberAddrInfo			= ""; //회원주소록정보

	var intOrderMemDiscountPrice	= ""; //회원등급 추가할인금액
	var intOrderMemAddPoint	    	= ""; //회원등급 추가포인트적립금액
	var intOrderAddPoint	    	= ""; //총적립포인트
	var intOrderTaxPrice			= ""; //부과세
	var intOrderTotalSPrice			= ""; 
	var intOrderPointUsePrice		= ""; //포인트결제가능한금액(포인트사용금지상품제외)
	var intOrderPointNoUseCnt		= "";
	var intOrderPointNoUsePrice		= "";
	
	$(document).ready(function(){

		<?if ($strMode=="order"){?>
		intOrderTotalSPriceOrg		= document.form.good_mny.value;			//상품총가격
		intOrderTotalDeliveryPrice	= document.form.good_delivery.value;	//배송가격
		intOrderPointUsePrice		= document.form.good_point_use.value;   //포인트결제가능한금액
		intOrderPointNoUseCnt		= document.form.good_point_no_use_cnt.value;
		intOrderPointNoUsePrice		= document.form.good_point_no_use.value;
		$('#jphone2').numeric();
		$("#jphone2").css("ime-mode", "disabled"); 

		$('#jphone3').numeric();
		$("#jphone3").css("ime-mode", "disabled"); 

		$('#jhp2').numeric();
		$("#jhp2").css("ime-mode", "disabled"); 

		$('#jhp3').numeric();
		$("#jhp3").css("ime-mode", "disabled"); 

		$('#jmail').alphanumeric({allow:"-_.@"});
		$("#jmail").css("ime-mode", "disabled"); 

		$('#bphone2').numeric();
		$("#bphone2").css("ime-mode", "disabled"); 

		$('#bphone3').numeric();
		$("#bphone3").css("ime-mode", "disabled"); 

		$('#bhp2').numeric();
		$("#bhp2").css("ime-mode", "disabled"); 

		$('#bhp3').numeric();
		$("#bhp3").css("ime-mode", "disabled"); 

		$('#bmail').alphanumeric({allow:"-_.@"});
		$("#bmail").css("ime-mode", "disabled"); 
		
		<?if ($S_SITE_LNG == "KR" || $S_SITE_LNG == "JP"){?>
		$('#use_point').numeric();
		$("#use_point").css("ime-mode", "disabled"); 
		<?}else{?>
		$('#use_point').alphanumeric({allow:"."});
		$("#use_point").css("ime-mode", "disabled"); 
		<?}?>
				
		/* 주소록 체크 */
		$("input[name='basicAddr']").click(function() {			
			if ($(this).is(":checked") == true)
			{	
				goMemberAddrPush($(this).val());
			}
		});	

		/* 사용자 포인트 변경 */
		$("#use_point").bind("blur", function() {
			
			// 2012.11.08 home 소스
			var intOrderTotalPrice		= intOrderTotalSPriceOrg;
			var intOrderDeliveryPrice	= goDeliveryTotalPrice();

			if (parseFloat(intOrderPointUsePrice) >= 0 && parseInt(intOrderPointNoUseCnt) > 0 && parseFloat(intOrderPointNoUsePrice) > 0)
			{
				intOrderTotalPrice		= parseFloat(intOrderPointUsePrice);
			}
			
			intOrderTotalPrice			= parseFloat(intOrderTotalPrice) + parseFloat(intOrderDeliveryPrice);
			<?if ($S_SITE_LNG == "KR" && ($S_DELIVERY_MTH == "N" || !$S_DELIVERY_MTH)){?>
			intOrderTotalPrice			= parseFloat(intOrderTotalPrice) - parseFloat(intOrderDeliveryPrice); //한국어이고 일반배송일때는 총가격에 배송비를 포함한다.			
			<?}?>
			
			/* 적립포인트 */
			$("#spanOrderAddPoint").html(C_toNumberFormatString($("#savePointTotal").val(),false));
			if (parseFloat($(this).val()) > parseFloat(<?=$intMemberUsePointTotal?>))
			{
				alert("<?=$LNG_TRANS_CHAR['OS00008']?>"); //사용가능하신 포인트 금액만큼 입력해주세요.
				$(this).val("");
				goTotalPriceCal();
				return;
			}

			if (parseFloat($(this).val()) > parseFloat(intOrderTotalPrice))
			{
				alert("<?=$LNG_TRANS_CHAR['OS00009']?>"); //입력하신 포인트가 결제금액보다 큽니다.
				$(this).val("");
				goTotalPriceCal();
				return;
			}

			if (parseFloat($(this).val()) > parseFloat(<?=$S_POINT_MAX?>))
			{
				alert("<?=callLangTrans($LNG_TRANS_CHAR['OS00010'],array($S_POINT_MAX))?>"); //사용가능하신 포인트는 "+C_toNumberFormatString(<?=$S_POINT_MAX?>,false)+"보다 적어야 됩니다.
				$(this).val("<?=$S_POINT_MAX?>");
				goTotalPriceCal();
				return;
			}

			if ("<?=$S_POINT_USE2?>" == "N" && $(this).val() > 0)
			{
				alert("<?=$LNG_TRANS_CHAR['OS00011']?>"); //결제시 포인트를 사용하시면 상품 적립포인트가 쌓이지 않습니다.
				$("#spanOrderAddPoint").html("0");
				goTotalPriceCal();
				return;
			}
			
			goTotalPriceCal();			
		});
		
		<?if ($S_SITE_LNG == "KR"){?>
		init_pay_button();
		
		$('#cash_hp2').numeric();
		$("#cash_hp2").css("ime-mode", "disabled"); 

		$('#cash_hp3').numeric();
		$("#cash_hp3").css("ime-mode", "disabled"); 

		$('#cash_no1').numeric();
		$("#cash_no1").css("ime-mode", "disabled"); 

		$('#cash_no2').numeric();
		$("#cash_no2").css("ime-mode", "disabled"); 

		$('#cash_no3').numeric();
		$("#cash_no3").css("ime-mode", "disabled"); 

		$('#cash_no4').numeric();
		$("#cash_no4").css("ime-mode", "disabled"); 


		$("input[name='cash_yn']").click(function() {			
			$("#divCash").css("display","none");
			if ($(this).is(":checked") == true)
			{	
				$("#divCash").css("display","block");
			}
		});
		
		$("#cashMth").change(function(){
			var strVal	= $("#cashMth option:selected").val();
			$("#divCashHp").css("display","none");
			$("#divCashNo").css("display","none");
			
			if (strVal == "1")
			{
				$("#divCashHp").css("display","block");
			}

			if (strVal == "2")
			{
				$("#divCashNo").css("display","block");
			}
		});

		<?if ($S_DELIVERY_MTH == "G"){?>
			$.getJSON("./?menuType=order&mode=json&act=deliveryGroupInfo",function(data){	
				aryOrderDeliveryGroupInfo = data;
			});
		<?}?>
		<?}?>
		
		/* 국가를 선택시 배송가능한 배송방법을 불러온다.*/
		<?if ($S_SITE_LNG != "KR"){?>
		$("#bcountry").change(function(){
			var strVal	= $("#bcountry option:selected").val();
				
			/* 배송국가에 따른 배송방법*/
			$("#deliveryWeightMethod").empty();
			//C_AjaxPost("orderDeliveryMethod","./index.php","menuType=order&mode=json&act=deliveryWeightMethod&areaCode="+aryOrderDeliveryCountryInfo[strVal],"post");	
			C_AjaxPost("orderDeliveryMethod","./index.php","menuType=order&mode=json&act=deliveryWeightMethod&areaCode="+strVal,"post");
			goTotalPriceCal();
			
			$("#divState1").css("display","block");
			$("#divState2").css("display","none");
			if (strVal == "US")
			{
				$("#divState1").css("display","none");
				$("#divState2").css("display","block");
			}
		});

		$("#deliveryWeightMethod").click(function() {
			var intSize = $("#deliveryWeightMethod option").size();
			if (intSize == 1)
			{
				alert("<?=$LNG_TRANS_CHAR['PS00014']?>"); //국가를 선택해주세요.
				return;
			}
		});

		$("#deliveryWeightMethod").change(function() {
			
			var strVal	= $("#deliveryWeightMethod option:selected").val();
			
			if (C_isNull(strVal))
			{
				alert("<?=$LNG_TRANS_CHAR['PS00015']?>"); //배송방법을 선택해주세요.
				return;
			}

			goTotalPriceCal();
		
		});
		
		/* 상품 무게에 따른 배송 가격 */
		$.getJSON("./?menuType=order&mode=json&act=deliveryWeightInfo",function(data){
			aryOrderDeliveryWeightInfo = data;
		});

		/* 상품 배송 국가 리스트 */
		$.getJSON("./?menuType=order&mode=json&act=deliveryCountry",function(data){	
			aryOrderDeliveryCountryInfo = data;

			if ($("#bcountry").val())
			{
				/* 배송국가에 따른 배송방법(이미 등록된 국가가 있을 경우 다시 배송방법 셋팅)*/
				$("#deliveryWeightMethod").empty();
				//C_AjaxPost("orderDeliveryMethod","./index.php","menuType=order&mode=json&act=deliveryWeightMethod&areaCode="+aryOrderDeliveryCountryInfo[$("#bcountry").val()],"post");
				C_AjaxPost("orderDeliveryMethod","./index.php","menuType=order&mode=json&act=deliveryWeightMethod&areaCode="+$("#bcountry").val(),"post");
				
				goTotalPriceCal();
			}
		});

		document.getElementById("display_pay_button").style.display = "block" ;


		/* 사용자 포인트 변경 */
		<?if ($S_SITE_LNG == "JP"){?>
		/*$("#bzip1").bind("blur", function() {
			$.getJSON("./?menuType=order&mode=json&act=japanZip&bzip1="+$(this).val(),function(data){	
				if (data[0].RET == "N")
				{
					alert("우편번호가 존재하지 않습니다.");
					return;
				}
				
				$("#bstate_1").val(data[0].DO);
				$("#bcity").val(data[0].SI);
				$("#baddr1").val(data[0].ADDR);

			});		
		});*/
		<?}?>
		<?}?>

		/* 총 주문/결제금액에 따른 할인혜택 구하기 */
		document.form.mode.value = "json";
		document.form.act.value = "memberDiscount";
		//document.form.submit();
		var orderJsonData = $("#form").serialize();
		$.getJSON("./?"+orderJsonData,function(data){	
			
			intOrderTotalSPriceOrg		= data[0].O_TOT_SPRICE;
			intOrderTotalSPrice			= data[0].O_TOT_SPRICE;
			intOrderDeliveryPrice		= data[0].O_TOT_DELIVERY_PRICE;
			intOrderMemDiscountPrice	= data[0].O_TOT_MEM_DISCOUNT_PRICE;
			intOrderMemAddPoint			= data[0].O_TOT_MEM_POINT;
			intOrderAddPoint			= data[0].O_TOT_POINT;
			intOrderTaxPrice			= data[0].O_TOT_TAX;

			goTotalPriceCalHtml();
			
		});

		/* 첫구매 고객사은품 중복 체크 */
		$("input:checkbox[id^=prodFirstGiftNo]").click(function(){ 
			<?if ($S_MULTI_GIFT_USE == "N"){?>
			var intProdFirstGiftCnt = 0;
			$("input:checkbox[id^=prodFirstGiftNo]").each(function(){    
				if ($(this).is(":checked")) intProdFirstGiftCnt++;
			});
			if (intProdFirstGiftCnt > 1)
			{
				alert("<?=$LNG_TRANS_CHAR['OS00062']?>"); //사은품은 한개이상 선택할 수 없습니다.
				$(this).attr("checked",false);
			}
			<?}?>
		});

		/* 구매금액에 따른 고객사은품 중복 체크 */
		$("input:checkbox[id^=prodGiftNo]").click(function(){ 
			<?if ($S_MULTI_GIFT_USE == "N"){?>
			var intProdGiftCnt = 0;
			$("input:checkbox[id^=prodGiftNo]").each(function(){    
				if ($(this).is(":checked")) intProdGiftCnt++;
			});
			if (intProdGiftCnt > 1)
			{
				alert("<?=$LNG_TRANS_CHAR['OS00062']?>"); //사은품은 한개이상 선택할 수 없습니다.
				$(this).attr("checked",false);
			}
			<?}?>
		});

		/* 회원 주소록 가지고 오기*/
		<?if ($g_member_no && $g_member_login){?>
		$.getJSON("./?menuType=member&mode=json&act=memberAddrList",function(data){	
			if (!C_isNull(data))
			{
				aryMemberAddrInfo = data;
			}
		});
		<?}?>

		<?}?>
		
		<?if ($strMode == "myInfo"){?>
		<?if ($S_SITE_LNG != "KR"){?>
		$("#country").change(function(){
			var strVal	= $("#country option:selected").val();
				
			$("#divState1").css("display","block");
			$("#divState2").css("display","none");
			if (strVal == "US")
			{
				$("#divState1").css("display","none");
				$("#divState2").css("display","block");
			}
		});
		<?}?>
		<?}?>
	});
	
	/* 회원 정보 수정 */
	function goMyInfoModify()
	{
		var doc			= document.form; 
		
		//핸드폰
		<?if ($S_JOIN_HP["USE"] == "Y" && $S_JOIN_HP["MYPAGE"] == "Y" && $S_JOIN_HP["NES"] == "Y"){?>
			<?if (!$S_JOIN_HP["GRADE"] || in_array($strMemberJoinType,$S_JOIN_HP["GRADE"])){?>
				<?if ($S_SITE_LNG != "KR"){?>
					if(!C_chkInput("hp1",true,"<?=$LNG_TRANS_CHAR['MW00008']?>",true)) return; //핸드폰
				<?}else{?>
					if(!C_chkInput("hp2",true,"<?=$LNG_TRANS_CHAR['MW00008']?>",true)) return; //핸드폰
					if(!C_chkInput("hp3",true,"<?=$LNG_TRANS_CHAR['MW00008']?>",true)) return;
				<?}?>
			<?}?>
		<?}?>

		//전화번호
		<?if ($S_JOIN_PHONE["USE"] == "Y" && $S_JOIN_PHONE["MYPAGE"] == "Y" && $S_JOIN_PHONE["NES"] == "Y"){?>
			<?if (!$S_JOIN_PHONE["GRADE"] || in_array($strMemberJoinType,$S_JOIN_PHONE["GRADE"])){?>
				<?if ($S_SITE_LNG != "KR"){?>
					if(!C_chkInput("phone1",true,"<?=$LNG_TRANS_CHAR['MW00009']?>",true)) return; 
				<?}else{?>
					if(!C_chkInput("phone2",true,"<?=$LNG_TRANS_CHAR['MW00009']?>",true)) return;
					if(!C_chkInput("phone3",true,"<?=$LNG_TRANS_CHAR['MW00009']?>",true)) return;
				<?}?>
			<?}?>
		<?}?>

		//Fax
		<?if ($S_JOIN_FAX["USE"] == "Y" && $S_JOIN_FAX["MYPAGE"] == "Y" && $S_JOIN_FAX["NES"] == "Y"){?>
			<?if (!$S_JOIN_FAX["GRADE"] || in_array($strMemberJoinType,$S_JOIN_FAX["GRADE"])){?>
				<?if ($S_SITE_LNG != "KR"){?>
					if(!C_chkInput("fax1",true,"<?=$LNG_TRANS_CHAR['MW00017']?>",true)) return; 
				<?}else{?>
					if(!C_chkInput("fax2",true,"<?=$LNG_TRANS_CHAR['MW00017']?>",true)) return;
					if(!C_chkInput("fax3",true,"<?=$LNG_TRANS_CHAR['MW00017']?>",true)) return;
				<?}?>
			<?}?>
		<?}?>

		//이메일
		<?if ($S_MEM_CERITY == "1"){?>
			<?if ($S_JOIN_MAIL["USE"] == "Y" && $S_JOIN_MAIL["MYPAGE"] == "Y" && $S_JOIN_MAIL["NES"] == "Y"){?>
				<?if (!$S_JOIN_MAIL["GRADE"] || in_array($strMemberJoinType,$S_JOIN_MAIL["GRADE"])){?>
					if(!C_chkInput("mail",true,"<?=$LNG_TRANS_CHAR['OW00011']?>",true)) return; //이메일
			
					if (!C_isValidEmail(doc.mail.value)) {
						alert("<?=$LNG_TRANS_CHAR['MS00009']?>"); //올바른 이메일 주소가 아닙니다.
						doc.mail.focus();
						return;
					}
				<?}?>
			<?}?>
		<?}?>

		//주소		
		<?if ($S_JOIN_ADDR["USE"] == "Y" && $S_JOIN_ADDR["MYPAGE"] == "Y" && $S_JOIN_ADDR["NES"] == "Y"){?>
			<?if (!$S_JOIN_ADDR["GRADE"] || in_array($strMemberJoinType,$S_JOIN_ADDR["GRADE"])){?>
				<?if ($S_SITE_LNG == "KR"){?>
				if(!C_chkInput("zip1",true,"<?=$LNG_TRANS_CHAR['MW00014']?>",true)) return;
				if(!C_chkInput("zip2",true,"<?=$LNG_TRANS_CHAR['MW00014']?>",true)) return;
				if(!C_chkInput("addr1",true,"<?=$LNG_TRANS_CHAR['MW00011']?>",true)) return;
				if(!C_chkInput("addr2",true,"<?=$LNG_TRANS_CHAR['MW00013']?>",true)) return;
				<?} else {?>
				var strCountry	= $("#country option:selected").val();
				if (C_isNull(strCountry))
				{
					alert("<?=$LNG_TRANS_CHAR['MS00030']?>"); //국가를 선택해주세요.
					return;
				}	

				if(!C_chkInput("addr1",true,"<?=$LNG_TRANS_CHAR['MW00011']?>",true)) return;
				if(!C_chkInput("addr2",true,"<?=$LNG_TRANS_CHAR['MW00013']?>",true)) return;
				if(!C_chkInput("city",true,"<?=$LNG_TRANS_CHAR['MW00022']?>",true)) return;
				if(!C_chkInput("zip1",true,"<?=$LNG_TRANS_CHAR['MW00014']?>",true)) return;
				<?}?>
			<?}?>
		<?}?>

		//사진
		<?if ($S_JOIN_PHOTO["USE"] == "Y" && $S_JOIN_PHOTO["MYPAGE"] == "Y" && $S_JOIN_PHOTO["NES"] == "Y"){?>
			<?if (!$S_JOIN_PHOTO["GRADE"] || in_array($strMemberJoinType,$S_JOIN_PHOTO["GRADE"])){?>
			if(!C_chkInput("photo",true,"<?=$LNG_TRANS_CHAR['MW00018']?>",true)) return;
			<?}?>
		<?}?>

		//추천인
		<?if ($S_JOIN_REC["USE"] == "Y" && $S_JOIN_REC["MYPAGE"] == "Y" && $S_JOIN_REC["NES"] == "Y"){?>
			<?if (!$S_JOIN_REC["GRADE"] || in_array($strMemberJoinType,$S_JOIN_REC["GRADE"])){?>
			if(!C_chkInput("rec_id",true,"<?=$LNG_TRANS_CHAR['MW00019']?>",true)) return;
			<?}?>
		<?}?>

		//회사명
		<?if ($S_JOIN_COM["USE"] == "Y" && $S_JOIN_COM["MYPAGE"] == "Y" && $S_JOIN_COM["NES"] == "Y"){?>
			<?if (!$S_JOIN_COM["GRADE"] || in_array($strMemberJoinType,$S_JOIN_COM["GRADE"])){?>
			if(!C_chkInput("com_nm",true,"<?=$LNG_TRANS_CHAR['MW00020']?>",true)) return;
			<?}?>
		<?}?>
		
		//상호명
		<?if ($S_JOIN_BUSI_INFO["USE"] == "Y"){?>
		<?if ($S_JOIN_BUSI_NM["USE"] == "Y" && $S_JOIN_BUSI_NM["MYPAGE"] == "Y" && $S_JOIN_BUSI_NM["NES"] == "Y"){?>
			<?if (!$S_JOIN_BUSI_NM["GRADE"] || in_array($strMemberJoinType,$S_JOIN_BUSI_NM["GRADE"])){?>
			if(!C_chkInput("busi_nm",true,"<?=$LNG_TRANS_CHAR['MW00032']?>",true)) return;
			<?}?>
		<?}?>
		
		//사업자번호
		<?if ($S_JOIN_BUSI_NUM["USE"] == "Y" && $S_JOIN_BUSI_NUM["MYPAGE"] == "Y" && $S_JOIN_BUSI_NUM["NES"] == "Y"){?>
			<?if (!$S_JOIN_BUSI_NUM["GRADE"] || in_array($strMemberJoinType,$S_JOIN_BUSI_NUM["GRADE"])){?>
			if(!C_chkInput("busi_num1",true,"<?=$LNG_TRANS_CHAR['MW00033']?>",true)) return;
			if(!C_chkInput("busi_num2",true,"<?=$LNG_TRANS_CHAR['MW00033']?>",true)) return;
			if(!C_chkInput("busi_num3",true,"<?=$LNG_TRANS_CHAR['MW00033']?>",true)) return;
			<?}?>
		<?}?>


		//업종
		<?if ($S_JOIN_BUSI_UPJONG["USE"] == "Y" && $S_JOIN_BUSI_UPJONG["MYPAGE"] == "Y" && $S_JOIN_BUSI_UPJONG["NES"] == "Y"){?>
			<?if (!$S_JOIN_BUSI_UPJONG["GRADE"] || in_array($strMemberJoinType,$S_JOIN_BUSI_UPJONG["GRADE"])){?>
			if(!C_chkInput("busi_upj",true,"<?=$LNG_TRANS_CHAR['MW00034']?>",true)) return;
			<?}?>
		<?}?>
		
		//업태
		<?if ($S_JOIN_BUSI_UPTAE["USE"] == "Y" && $S_JOIN_BUSI_UPTAE["MYPAGE"] == "Y" && $S_JOIN_BUSI_UPTAE["NES"] == "Y"){?>
			<?if (!$S_JOIN_BUSI_UPTAE["GRADE"] || in_array($strMemberJoinType,$S_JOIN_BUSI_UPTAE["GRADE"])){?>
			if(!C_chkInput("busi_ute",true,"<?=$LNG_TRANS_CHAR['MW00035']?>",true)) return;
			<?}?>
		<?}?>

		//주소
		<?if ($S_JOIN_BUSI_ADDR["USE"] == "Y" && $S_JOIN_BUSI_ADDR["MYPAGE"] == "Y" && $S_JOIN_BUSI_ADDR["NES"] == "Y"){?>
			<?if (!$S_JOIN_BUSI_ADDR["GRADE"] || in_array($strMemberJoinType,$S_JOIN_BUSI_ADDR["GRADE"])){?>
			if(!C_chkInput("busi_zip1",true,"<?=$LNG_TRANS_CHAR['MW00014']?>",true)) return;
			if(!C_chkInput("busi_zip2",true,"<?=$LNG_TRANS_CHAR['MW00014']?>",true)) return;
			if(!C_chkInput("busi_addr1",true,"<?=$LNG_TRANS_CHAR['MW00011']?>",true)) return;
			if(!C_chkInput("busi_addr2",true,"<?=$LNG_TRANS_CHAR['MW00013']?>",true)) return;
			<?}?>
		<?}?>
		<?}?>

		//결혼여부
		<?if ($S_JOIN_ADD_WED["USE"] == "Y" && $S_JOIN_ADD_WED["MYPAGE"] == "Y" && $S_JOIN_BUSI_ADDR["NES"] == "Y"){?>
			<?if (!$S_JOIN_ADD_WED["GRADE"] || in_array($strMemberJoinType,$S_JOIN_ADD_WED["GRADE"])){?>
			var strWed = $(":radio[name='weddingYN']:checked").val();
			if (!strWed)
			{
				alert("<?=$LNG_TRANS_CHAR['MS00031']?>"); //결혼여부를 선택해주세요.
				return;
			}
			<?}?>
		<?}?>
		
		//결혼기념일
		<?if ($S_JOIN_ADD_WED_DAY["USE"] == "Y" && $S_JOIN_ADD_WED_DAY["MYPAGE"] == "Y" && $S_JOIN_ADD_WED_DAY["NES"] == "Y"){?>
			<?if (!$S_JOIN_ADD_WED_DAY["GRADE"] || in_array($strMemberJoinType,$S_JOIN_ADD_WED_DAY["GRADE"])){?>
			if(!C_chkInput("weddingDay1",true,"<?=$LNG_TRANS_CHAR['MW00025']?>",true)) return;
			if(!C_chkInput("weddingDay2",true,"<?=$LNG_TRANS_CHAR['MW00025']?>",true)) return;
			if(!C_chkInput("weddingDay3",true,"<?=$LNG_TRANS_CHAR['MW00025']?>",true)) return;
			<?}?>
		<?}?>
		
		//자녀
		<?if ($S_JOIN_ADD_CHILD["USE"] == "Y" && $S_JOIN_ADD_CHILD["MYPAGE"] == "Y" && $S_JOIN_ADD_CHILD["NES"] == "Y"){?>
			<?if (!$S_JOIN_ADD_CHILD["GRADE"] || in_array($strMemberJoinType,$S_JOIN_ADD_CHILD["GRADE"])){?>
			if(!C_chkInput("child",true,"<?=$LNG_TRANS_CHAR['MW00026']?>",true)) return;
			<?}?>
		<?}?>
		
		//직업
		<?if ($S_JOIN_ADD_JOB["USE"] == "Y" && $S_JOIN_ADD_JOB["MYPAGE"] == "Y" && $S_JOIN_ADD_JOB["NES"] == "Y"){?>
			<?if (!$S_JOIN_ADD_JOB["GRADE"] || in_array($strMemberJoinType,$S_JOIN_ADD_JOB["GRADE"])){?>
			<?}?>
		<?}?>

		//관심분야
		<?if ($S_JOIN_ADD_CONCERN["USE"] == "Y" && $S_JOIN_ADD_CONCERN["MYPAGE"] == "Y" && $S_JOIN_ADD_CONCERN["NES"] == "Y"){?>
			<?if (!$S_JOIN_ADD_CONCERN["GRADE"] || in_array($strMemberJoinType,$S_JOIN_ADD_CONCERN["GRADE"])){?>
				<?if ($S_JOIN_ADD_CONCERN["TYPE"] == "T"){?>
				if(!C_chkInput("concern",true,"<?=$LNG_TRANS_CHAR['MW00028']?>",true)) return;
				<?} else if ($S_JOIN_ADD_CONCERN["TYPE"] == "R"){?>
				
				var strConcern = $(":radio[name='concern']:checked").val();
				if (!strConcern)
				{
					alert("<?=$LNG_TRANS_CHAR['MS00032']?>"); //관신분야를 선택해주세요.
					return;
				}
				<?} else if ($S_JOIN_ADD_CONCERN["TYPE"] == "C"){?>
				var strConcern = $(":checkbox[name='concern']:checked").val();
				if (!strConcern)
				{
					alert("<?=$LNG_TRANS_CHAR['MS00032']?>"); //관신분야를 선택해주세요.
					return;
				}
				<?} else if ($S_JOIN_ADD_CONCERN["TYPE"] == "S"){?>
				
				var strConcern	= $("#concern option:selected").val();
				if (C_isNull(strConcern))
				{
					alert("<?=$LNG_TRANS_CHAR['MS00032']?>"); //관신분야를 선택해주세요.
					return;
				}
				<?}?>
			<?}?>
		<?}?>

		<?if ($S_JOIN_ADD_TEXT["USE"] == "Y" && $S_JOIN_ADD_TEXT["MYPAGE"] == "Y" && $S_JOIN_ADD_TEXT["NES"] == "Y"){?>
			<?if (!$S_JOIN_ADD_TEXT["GRADE"] || in_array($strMemberJoinType,$S_JOIN_ADD_TEXT["GRADE"])){?>
			if(!C_chkInput("memo",true,"<?=$LNG_TRANS_CHAR['MW00029']?>",true)) return;
			<?}?>
		<?}?>

		<?if ($S_JOIN_TMP_1["USE"] == "Y" && $S_JOIN_TMP_1["MYPAGE"] == "Y" && $S_JOIN_TMP_1["NES"] == "Y"){?>
			<?if (!$S_JOIN_TMP_1["GRADE"] || in_array($strMemberJoinType,$S_JOIN_TMP_1["GRADE"])){?>
			if(!C_chkInput("tmp1",true,"<?=$S_JOIN_TMP_1['NAME'.$S_SITE_LNG]?>",true)) return;
			<?}?>
		<?}?>

		<?if ($S_JOIN_TMP_2["USE"] == "Y" && $S_JOIN_TMP_2["MYPAGE"] == "Y" && $S_JOIN_TMP_2["NES"] == "Y"){?>
			<?if (!$S_JOIN_TMP_2["GRADE"] || in_array($strMemberJoinType,$S_JOIN_TMP_2["GRADE"])){?>
			if(!C_chkInput("tmp2",true,"<?=$S_JOIN_TMP_2['NAME'.$S_SITE_LNG]?>",true)) return;
			<?}?>
		<?}?>
				
		<?if ($S_JOIN_TMP_3["USE"] == "Y" && $S_JOIN_TMP_3["MYPAGE"] == "Y" && $S_JOIN_TMP_3["NES"] == "Y"){?>
			<?if (!$S_JOIN_TMP_3["GRADE"] || in_array($strMemberJoinType,$S_JOIN_TMP_3["GRADE"])){?>
			if(!C_chkInput("tmp3",true,"<?=$S_JOIN_TMP_3['NAME'.$S_SITE_LNG]?>",true)) return;
			<?}?>
		<?}?>

		<?if ($S_JOIN_TMP_4["USE"] == "Y" && $S_JOIN_TMP_4["MYPAGE"] == "Y" && $S_JOIN_TMP_4["NES"] == "Y"){?>
			<?if (!$S_JOIN_TMP_4["GRADE"] || in_array($strMemberJoinType,$S_JOIN_TMP_4["GRADE"])){?>
			if(!C_chkInput("tmp4",true,"<?=$S_JOIN_TMP_4['NAME'.$S_SITE_LNG]?>",true)) return;
			<?}?>
		<?}?>

		<?if ($S_JOIN_TMP_5["USE"] == "Y" && $S_JOIN_TMP_5["MYPAGE"] == "Y" && $S_JOIN_TMP_5["NES"] == "Y"){?>
			<?if (!$S_JOIN_TMP_5["GRADE"] || in_array($strMemberJoinType,$S_JOIN_TMP_5["GRADE"])){?>
			if(!C_chkInput("tmp5",true,"<?=$S_JOIN_TMP_5['NAME'.$S_SITE_LNG]?>",true)) return;
			<?}?>
		<?}?>
		
		document.form.encoding = "multipart/form-data";

		doc.menuType.value = "member";
		doc.mode.value = "act";
		doc.act.value = "memberModify";
		doc.method = "post";
		doc.action = "<?=$PHP_SELF?>";
		doc.submit();
	}

	function goCartAllCheck(chkObj)
	{
		if (chkObj.checked == true)
		{			
			$('input[name="cartNo[]"]').attr("checked", true); 
		} else {
			
			$('input[name="cartNo[]"]').attr("checked", false); 
		}
	}

	/* wish -> basket */
	function goBasket(no)
	{
		var x = confirm("<?=$LNG_TRANS_CHAR['OS00013']?>"); //선택한 상품을 장바구니로 이동하시겠습니까?
		if (x == true)
		{
			var doc = document.form;

			doc.no.value = no;
			doc.mode.value = "act";
			doc.act.value = "moveBasket";
			doc.method = "post";
			doc.action = "<?=$PHP_SELF?>";
			doc.submit();
		}
	}

	/* 장바구니 -> wish */
	function goWish(no)
	{
		if (C_isNull(intM_NO))
		{
			alert("<?=$LNG_TRANS_CHAR['OS00014']?>"); //로그인을 하신 후 이용하실 수 있습니다.
			return;
		}
		var x = confirm("<?=$LNG_TRANS_CHAR['OS00015']?>"); //선택한 상품을 위시리스트로 이동하시겠습니까?
		if (x == true)
		{
			var doc = document.form;

			doc.no.value = no;
			doc.mode.value = "act";
			doc.act.value = "moveWish";
			doc.method = "post";
			doc.action = "<?=$PHP_SELF?>";
			doc.submit();
		}
	}

	function goWishAll()
	{
		if (!C_isNull(document.form["cartNo[]"]))
		{
			var strSelectNo = C_getCheckedCode(document.form["cartNo[]"]);
			if (C_isNull(strSelectNo))
			{
				alert("<?=$LNG_TRANS_CHAR['OS00016']?>"); //담아두실 상품을 선택해주세요.
				return;
			}

			var doc = document.form;

			doc.mode.value = "act";
			doc.act.value = "moveWish";
			doc.method = "post";
			doc.action = "<?=$PHP_SELF?>";
			doc.submit();		
		}
		
	}

	/* wish 삭제 */
	function goWishDel(no)
	{
		var x = confirm("<?=$LNG_TRANS_CHAR['OS00017']?>"); //선택한 상품을 삭제하시겠습니까?
		if (x == true)
		{
			var doc = document.form;

			doc.no.value = no;
			doc.mode.value = "act";
			doc.act.value = "wishDel";
			doc.method = "post";
			doc.action = "<?=$PHP_SELF?>";
			doc.submit();
		}
	}
	
	/* 수량 update */
	function goQtyUpMinus(gb1,gb2,no)
	{
		var inputObj = gb1+"Qty"+no;
		var intQty = parseInt($("#"+inputObj).val());
		intQty = intQty + (1 * gb2);
		
		if (intQty <= 0)
		{
			alert("<?=$LNG_TRANS_CHAR['OS00005']?>"); //수량은 '0'보다 커야 합니다.
			return;
		}
		
		$("#"+inputObj).val(intQty);
	}

	function goQtyUpdate(mode,no)
	{
		var intQty = parseInt($("#"+mode+"Qty"+no).val());
		var strJsonParam = "cartQty&cartNo="+no+"&qty="+intQty;
		
		if (mode == "wish")
		{
			var strJsonParam = "wishQty&wishNo="+no+"&qty="+intQty;
		}
		
		$.getJSON("./?menuType=order&mode=json&act="+strJsonParam,function(data){	
		
			location.reload();
			//alert(data[0].MSG);
			return;
		})
	}

	/* 장바구니 삭제 */
	function goCartDel(no)
	{
		var x = confirm("<?=$LNG_TRANS_CHAR['OS00017']?>"); //선택한 상품을 삭제하시겠습니까?
		if (x == true)
		{
			var doc = document.form;
			doc.no.value = no;
			doc.mode.value = "act";
			doc.act.value = "cartDel";
			doc.method = "post";
			doc.action = "<?=$PHP_SELF?>";
			doc.submit();
		}
	}

	function goProdView(no)
	{
		var doc = document.form;

		doc.prodCode.value = no;
		doc.mode.value = "view";
		doc.method = "get";
		doc.action = "<?=$PHP_SELF?>";
		doc.submit();
	}

	function goCartAllDel()
	{
		
		if (!C_isNull(document.form["cartNo[]"]))
		{
			var strSelectNo = C_getCheckedCode(document.form["cartNo[]"]);
			if (C_isNull(strSelectNo))
			{
				alert("<?=$LNG_TRANS_CHAR['OS00018']?>"); //삭제하실 상품을 선택해주세요.
				return;
			}

			var x = confirm("<?=$LNG_TRANS_CHAR['OS00017']?>"); //선택한 상품을 삭제하시겠습니까?
			if (x == true)
			{
				var doc = document.form;
				
				<?if($strMode == "cartMyList"){?>
				doc.returnMode.value = "cartMyList";
				doc.returnMenu.value = "order";
				<?}?>
				doc.mode.value = "act";
				doc.act.value = "cartAllDel";
				doc.method = "post";
				doc.action = "<?=$PHP_SELF?>";
				doc.submit();
			}
		}
	}

	function goOrderJumun()
	{
		var doc = document.form;
		if (C_isNull(intM_NO))
		{
			//레이어팝업 로그인 사용시
			<?if($S_MAIN_LAYERPOP_LOGIN_USE=="Y" && $strDevice != "m"){?>
				
				goLoginLayerpop('order');

			<?}else{?>

			doc.menuType.value = "member";
			doc.mode.value = "login";
			doc.act.value = "";
			doc.returnMenu.value = "order";
			doc.returnMode.value = "cart";
			doc.method = "post";
			doc.action = "<?=$PHP_SELF?>";
			doc.submit();
			<?}?>
			return;
		} else {

			if (!C_isNull(document.form["cartNo[]"]))
			{
				var strSelectNo = C_getCheckedCode(document.form["cartNo[]"]);
				if (C_isNull(strSelectNo))
				{
					alert("<?=$LNG_TRANS_CHAR['OS00019']?>"); //주문하실 상품을 선택해주세요.
					return;
				}

				doc.mode.value = "act";
				doc.act.value = "order1";
				doc.method = "post";
				doc.action = "<?=$PHP_SELF?>";
				doc.submit();
			}
		}
	}

	/* 우편번호 찾기 */
	function goZip(num)
	{
		window.open('?menuType=etc&mode=address&num='+num,'new','width=490px,height=400px,top=300px,left=400px,menubar=no,location=no,scrollbars=yes,status=no,resizable=no');
	}

	/* 주문정보과 배송지정보 동일체크 */
	function goOrderDeliveryChk()
	{
		<?if($S_SITE_LNG == "KR"){?>
		if ($("input:checkbox[id='jInfoYN']").is(":checked") == true)
		{
			$("#bname").val($("#jname").val());
			$("#bphone1").val($("#jphone1").val());
			$("#bphone2").val($("#jphone2").val());
			$("#bphone3").val($("#jphone3").val());
			$("#bhp1").val($("#jhp1").val());
			$("#bhp2").val($("#jhp2").val());
			$("#bhp3").val($("#jhp3").val());
			//$("#bmail").val($("#jmail").val());
		} else {
			$("#bname").val("");
			$("#bphone1").val("");
			$("#bphone2").val("");
			$("#bphone3").val("");
			$("#bhp1").val("");
			$("#bhp2").val("");
			$("#bhp3").val("");
			//$("#bmail").val("");
		}
		<?}else{?>
		if ($("input:checkbox[id='jInfoYN']").is(":checked") == true)
		{
			$("#bname").val($("#j_f_name").val()+" "+$("#j_l_name").val());
			$("#bphone1").val($("#jphone1").val());
			$("#bhp1").val($("#jhp1").val());
			//$("#bmail").val($("#jmail").val());
		} else {
			$("#bname").val("");
			$("#bphone1").val("");
			$("#bhp1").val("");
			//$("#bmail").val("");
		}
		<?}?>
	}

	function goMemberAddrPush(no){
		if (no != "Y")
		{
			$("#bname").val(aryMemberAddrInfo[no]["MA_NAME"]);
			$("#baddr1").val(aryMemberAddrInfo[no]["MA_ADDR1"]);
			$("#baddr2").val(aryMemberAddrInfo[no]["MA_ADDR2"]);

			<?if($S_SITE_LNG == "KR"){?>
			$("#bphone1").val(aryMemberAddrInfo[no]["MA_PHONE1"]);
			$("#bphone2").val(aryMemberAddrInfo[no]["MA_PHONE2"]);
			$("#bphone3").val(aryMemberAddrInfo[no]["MA_PHONE3"]);
			$("#bhp1").val(aryMemberAddrInfo[no]["MA_HP1"]);
			$("#bhp2").val(aryMemberAddrInfo[no]["MA_HP2"]);
			$("#bhp3").val(aryMemberAddrInfo[no]["MA_HP3"]);
			$("#bzip1").val(aryMemberAddrInfo[no]["MA_ZIP1"]);
			$("#bzip2").val(aryMemberAddrInfo[no]["MA_ZIP2"]);
			<?}else{?>
			$("#bphone1").val(aryMemberAddrInfo[no]["MA_PHONE"]);
			$("#bhp1").val(aryMemberAddrInfo[no]["MA_HP"]);
			$("#bzip1").val(aryMemberAddrInfo[no]["MA_ZIP"]);
			
			$("#bcountry").val(aryMemberAddrInfo[no]["MA_COUNTRY"]);
			$("#bcity").val(aryMemberAddrInfo[no]["MA_CITY"]);

			$("#bstate_1").val(aryMemberAddrInfo[no]["MA_STATE"]);
			$("#bstate_2").val(aryMemberAddrInfo[no]["MA_STATE"]);
			
			if (aryMemberAddrInfo[no]["MA_COUNTRY"] == "US"){
				$("#divState1").css("display","none");
				$("#divState2").css("display","block");
			} else {
				$("#divState1").css("display","block");
				$("#divState2").css("display","none");
			}
			<?}?>
		} else {

			$("#bname").val("");
			$("#baddr1").val("");
			$("#baddr2").val("");

			<?if($S_SITE_LNG == "KR"){?>
			$("#bphone1").val("02");
			$("#bphone2").val("");
			$("#bphone3").val("");
			$("#bhp1").val("010");
			$("#bhp2").val("");
			$("#bhp3").val("");
			$("#bzip1").val("");
			$("#bzip2").val("");
			<?}else{?>
			$("#bphone1").val("");
			$("#bhp1").val("");
			$("#bzip1").val("");
			
			$("#bcountry").val("");
			$("#bcity").val("");
			$("#bstate_1").val("");
			$("#bstate_2").val("");
			<?}?>
		}
	}
	
	/* 무통장 입금 체크 */
	function goSettle()
	{
		var strSettle = $(":radio[name='settle']:checked").val();

		if (strSettle == "B")
		{
			$("#trBankInfo").css("display","");
			$("#pay_method").val("");
		} else {
			$("#trBankInfo").css("display","none");
		
			if (strSettle == "C"){
				$("#pay_method").val("100000000000");
			} else if (strSettle == "A") {
				$("#pay_method").val("010000000000");
				
			} else if (strSettle == "T") {
				$("#pay_method").val("001000000000");
			}
		}

		$("#bank_name").val("");
		$("#bank_code").val("");
	}

	/* 주문하기 */
	function goOrderAct()
	{
		if (C_isNull(intM_NO))
		{
			var strPolicyYN = $(":radio[name='agreeYN']:checked").val();
			if (C_isNull(strPolicyYN) || strPolicyYN == "N")
			{
				alert("<?=$LNG_TRANS_CHAR['MS00015']?>"); //[개인정보보호정책] 동의를 선택해주세요.
				return;
			}
		}
		
		<?if ($S_SITE_LNG == "KR"){?>
		if(!C_chkInput("jname",true,"<?=$LNG_TRANS_CHAR['OW00015']?>",true)) return; //주문자명
		if(!C_chkInput("jphone2",true,"<?=$LNG_TRANS_CHAR['OW00016']?>",true)) return; //전화번호
		if(!C_chkInput("jphone3",true,"<?=$LNG_TRANS_CHAR['OW00016']?>",true)) return; //전화번호
		if(!C_chkInput("jhp2",true,"<?=$LNG_TRANS_CHAR['OW00010']?>",true)) return; //핸드폰
		if(!C_chkInput("jhp3",true,"<?=$LNG_TRANS_CHAR['OW00010']?>",true)) return; //핸드폰
		if(!C_chkInput("jmail",true,"<?=$LNG_TRANS_CHAR['OW00011']?>",true)) return; //이메일

		if(!C_chkInput("bname",true,"<?=$LNG_TRANS_CHAR['OW00017']?>",true)) return; //받는사람명
		if(!C_chkInput("bphone2",true,"<?=$LNG_TRANS_CHAR['OW00018']?>",true)) return; //받는사람 전화번호
		if(!C_chkInput("bphone3",true,"<?=$LNG_TRANS_CHAR['OW00018']?>",true)) return; //받는사람 전화번호
		if(!C_chkInput("bhp2",true,"<?=$LNG_TRANS_CHAR['OW00019']?>",true)) return; //받는사람 핸드폰
		if(!C_chkInput("bhp3",true,"<?=$LNG_TRANS_CHAR['OW00019']?>",true)) return; //받는사람 핸드폰
		if(!C_chkInput("bmail",true,"<?=$LNG_TRANS_CHAR['OW00020']?>",true)) return; //받는사람 이메일

		if(!C_chkInput("bzip1",true,"<?=$LNG_TRANS_CHAR['OW00021']?>",true)) return; //받는사람 우편번호
		if(!C_chkInput("bzip2",true,"<?=$LNG_TRANS_CHAR['OW00021']?>",true)) return; //받는사람 우편번호
		if(!C_chkInput("baddr1",true,"<?=$LNG_TRANS_CHAR['OW00022']?>",true)) return; //받는사람 주소
		if(!C_chkInput("baddr2",true,"<?=$LNG_TRANS_CHAR['OW00023']?>",true)) return; //받는사람 상세주소

		<?if ($S_DELIVERY_MTH == "G"){?>
			var intDeliveryGroupPriceNo	= $("#deliveryGroupPrice option:selected").val();
			
			if (C_isNull(intDeliveryGroupPriceNo))
			{
				alert("<?=$LNG_TRANS_CHAR['OS00025']?>"); //배송비를 선택해주세요.
				return;
			}
		<?}?>
		
		<?}else{?>
		
		if(!C_chkInput("j_f_name",true,"<?=$LNG_TRANS_CHAR['OW00038']?>",true)) return; //주문자명
		if(!C_chkInput("j_l_name",true,"<?=$LNG_TRANS_CHAR['OW00039']?>",true)) return; //전화번호
		if(!C_chkInput("jphone1",true,"<?=$LNG_TRANS_CHAR['OW00016']?>",true)) return; //전화번호
		if(!C_chkInput("jhp1",true,"<?=$LNG_TRANS_CHAR['OW00010']?>",true)) return; //핸드폰
		if(!C_chkInput("jmail",true,"<?=$LNG_TRANS_CHAR['OW00011']?>",true)) return; //이메일

		if(!C_chkInput("bname",true,"<?=$LNG_TRANS_CHAR['OW00017']?>",true)) return; //받는사람명
		if(!C_chkInput("bphone1",true,"<?=$LNG_TRANS_CHAR['OW00018']?>",true)) return; //받는사람 전화번호
		if(!C_chkInput("bhp1",true,"<?=$LNG_TRANS_CHAR['OW00019']?>",true)) return; //받는사람 핸드폰
		if(!C_chkInput("bmail",true,"<?=$LNG_TRANS_CHAR['OW00020']?>",true)) return; //받는사람 이메일
		
		var strCountry	= $("#bcountry option:selected").val();
		if (C_isNull(strCountry))
		{
			alert("<?=$LNG_TRANS_CHAR['OS00041']?>"); //국가를 선택해주세요.
			return;
		}	

		if(!C_chkInput("baddr1",true,"<?=$LNG_TRANS_CHAR['OW00022']?>",true)) return; //받는사람 주소
		if(!C_chkInput("baddr2",true,"<?=$LNG_TRANS_CHAR['OW00023']?>",true)) return; //받는사람 상세주소
		if(!C_chkInput("bcity",true,"<?=$LNG_TRANS_CHAR['OW00041']?>",true)) return; //받는사람 city
		
		var strState = "";
		if (strCountry == "US")
		{
			strState =  $("#bstate_2 option:selected").val();
		
			if (C_isNull(strState))
			{
				alert("<?=$LNG_TRANS_CHAR['OS00042']?>"); //State를 선택해주세요.
				return;
			}	
		}
		
		if(!C_chkInput("bzip1",true,"<?=$LNG_TRANS_CHAR['OW00021']?>",true)) return; //받는사람 우편번호

		<?if ($S_DELIVERY_FOR_MTH == "W" || $S_DELIVERY_FOR_MTH == "T"){?>
		var strDeliveryWeightMethod		= $("#deliveryWeightMethod option:selected").val();
		if (C_isNull(strDeliveryWeightMethod))
		{
			alert("<?=$LNG_TRANS_CHAR['OS00043']?>"); //배송방법을 선택해주세요.
			return;
		}
		<?}?>
		<?}?>
		var doc = document.form;
		doc.mode.value = "json";
		doc.act.value = "order2";

		var intOrderUsePoint  = (C_isNull($("#use_point").val())) ? 0:parseFloat($("#use_point").val());
		var intOrderUseCoupon = (C_isNull($("#use_coupon").val())) ? 0:parseFloat($("#use_coupon").val());
		var intOrderUsePrice  = intOrderUsePoint + intOrderUseCoupon;
		
		/* 주문 금액 = 0/ 사용포인트 금액 == 주문금액 일치/ 주문금액 - 사용포인트 < 회원보유포인트*/
		if ((doc.good_mny.value == 0) && (intOrderTotalSPrice == 0))
		{
			
			if (intM_NO > 0 && intOrderUsePoint > 0 && (intOrderUsePoint > parseFloat("<?=$intMemberUsePointTotal?>"))){
				alert("<?=$LNG_TRANS_CHAR['OS00034']?>"); //입력하신 사용포인트가 보유하신 포인트보다 많습니다.
				return;
			}
			
			/* 포인트 구매 */
			$("#pay_method").val("999999999999");
			$("#bank_name").val("");
			$("#bank_code").val("");

			var x = confirm("<?=$LNG_TRANS_CHAR['OS00021']?>"); //결제를 포인트 구매로 진행하시겠습니까?
			if (x != true)
			{
				return;
			}
			
		} else {
			var strSettle = $(":radio[name='settle']:checked").val();
			if (C_isNull(strSettle))
			{
				alert("<?=$LNG_TRANS_CHAR['OS00022']?>"); //결제방법을 선택해주세요.
				return;
			}
			
			if (strSettle == "B"){
				if (!$("#settle_bank_code").val())
				{
					alert("<?=$LNG_TRANS_CHAR['OS00023']?>"); //입금은행을(를) 선택해주세요.
					return;
				}
				if(!C_chkInput("input_bank_name",true,"<?=$LNG_TRANS_CHAR['OW00024']?>",false)) return; //입금자명
			}
		}
		
		<?if ($S_GIFT_USE != "N"){?>
		/* 고객사은품 */
		if ($("input:checkbox[id^=prodFirstGiftNo]").length > 0){
			var intProdFirstGiftCnt = 0;
			$("input:checkbox[id^=prodFirstGiftNo]").each(function(){    
				if ($(this).is(":checked")) intProdFirstGiftCnt++;
			});
			
			if (intProdFirstGiftCnt == 0)
			{
				alert("<?=$LNG_TRANS_CHAR['OS00072']?>"); //사은품을 선택해주세요.
				return;
			}
		}

		if ($("input:checkbox[id^=prodGiftNo]").length > 0){
			var intProdGiftCnt = 0;
			$("input:checkbox[id^=prodGiftNo]").each(function(){    
				if ($(this).is(":checked")) intProdGiftCnt++;
			});
			
			if (intProdGiftCnt == 0)
			{
				alert("<?=$LNG_TRANS_CHAR['OS00072']?>"); //사은품을 선택해주세요.
				return;
			}
		}
		<?}?>
		
		doc.method = "post";
		doc.action = "<?=$PHP_SELF?>";
//		doc.submit();
		
		var formData = $("#form").serialize();
		goInitLoading("loading");
		C_AjaxPost("orderAct","./index.php",formData,"post");	
	}

	function goAjaxRet(name,result){

		if (name == "orderAct")
		{			
			var doc = document.form;
			var data = eval(result);

			if (data[0].RET == "Y")
			{					
				
				<?if ($S_SITE_LNG == "KR"){?>
				doc.ordr_idxx.value	= data[0].O_KEY;
				doc.good_name.value	= data[0].TITLE;
				doc.ordr_idxx.value	= data[0].O_KEY;
				doc.good_info.value	= data[0].CART;
				doc.bask_cntx.value	= data[0].CART_CNT;
				doc.order_no.value	= data[0].NO;
				<?}else{?>
				doc.oNo.value	= data[0].NO;
				<?}?>
				
				if (data[0].SETTLE == "B" || data[0].SETTLE == "P")
				{
					doc.mode.value = "orderEnd";
					doc.act.value = "";
					doc.method = "post";
					doc.action = "<?=$PHP_SELF?>";
					doc.submit()

				} else {
					
					doc.method = "post";
					doc.action = "./index.php";
					doc.mode.value = "pg";
					doc.act.value = "pg";

					<?if ($S_SITE_LNG == "KR"){?>
					doc.buyr_name.value = doc.jname.value;
					doc.buyr_mail.value = doc.jmail.value;
					doc.buyr_tel1.value = doc.jphone1.value+"-"+doc.jphone2.value+"-"+doc.jphone3.value;
					doc.buyr_tel2.value = doc.jhp1.value+"-"+doc.jhp2.value+"-"+doc.jhp3.value;
					
					doc.rcvr_name.value = doc.bname.value;
					doc.rcvr_tel1.value = doc.bphone1.value+"-"+doc.bphone2.value+"-"+doc.bphone3.value;
					doc.rcvr_tel2.value = doc.bhp1.value+"-"+doc.bhp2.value+"-"+doc.bhp3.value;
					//doc.rcvr_mail.value = doc.bmail.value;
					doc.rcvr_zipx.value = doc.bzip1.value+doc.bzip2.value;
					doc.rcvr_add1.value = doc.baddr1.value;
					doc.rcvr_add2.value = doc.baddr2.value;
					if (jsf__pay(doc))
					{
						doc.submit();
					}
					<?}else{?>
					doc.submit();
					<?}?>
				}

			} else {
				goInitLoading("");
				alert(data[0].MSG);
				return;
			}
		} else if (name = "orderDeliveryMethod"){
			$("#deliveryWeightMethod").html(result);
		} else if (name = "memberAddrDelete"){
			var data = eval(result);
			
			if (data[0].RET == "Y")
			{
				location.reload();
			}
		}
	}
	
	/* 주문 로빙바 구현 */
	function goInitLoading(loadingMode)
	{
		if(loadingMode == "loading") {
			$("#btnOrderBuy").attr("src","../himg/etc/icon_loading.gif");
		} else {
			$("#btnOrderBuy").attr("src","../himg/product/A0001/<?=$S_SITE_LNG_PATH?>/btn_order_buy.gif");
		}
	}

	function goBuyList()
	{
		var doc = document.form;
		doc.mode.value = "buyList";
		doc.act.value = "";
		doc.method = "post";
		doc.action = "<?=$PHP_SELF?>";
		doc.submit();
	}

	function goBuyNonList()
	{
		var doc = document.form;
		doc.mode.value = "buyNonList";
		doc.act.value = "";
		doc.method = "post";
		doc.action = "<?=$PHP_SELF?>";
		doc.submit();
	}
	
	function goOrderView(mode,no)
	{
		var doc = document.form;

		doc.oNo.value = no;
		doc.mode.value = mode;
		doc.act.value = "";
		doc.method = "post";
		doc.action = "<?=$PHP_SELF?>";
		doc.submit();
	}

	function goMyOrderCancel(no)
	{
		C_openWindow('./?menuType=etc&mode=orderCancel&no='+no, "<?=$LNG_TRANS_CHAR['OW00025']?>", "500", "300"); //주문취소
	}
	
	/* 쇼핑계속하기 */
	function goProdList()
	{
		var doc = document.form;
		
		doc.menuType.value = "product";
		<?if (!$strSearchHCode1 || $strSearchHCode1 == "000"){?>
		doc.mode.value = "brandList";
		<?}else{?>
		doc.mode.value = "list";
		<?}?>
		doc.act.value = "";
		doc.method = "post";
		doc.action = "<?=$PHP_SELF?>";
		doc.submit();
		
	}

	/* 주문 취소하기 */
	function goOrderCancel()
	{
		var doc = document.form;
		
		doc.menuType.value = "order";
		doc.mode.value = "cart";
		doc.act.value = "";
		doc.method = "post";
		doc.action = "<?=$PHP_SELF?>";
		doc.submit();
		
	}

	/* 주문시 총 배송비 구하기 */
	function goDeliveryTotalPrice()
	{
		var intCartDeliveryPrice = 0;
		
		/* 국가 : 한국 / 그룹배송 */
		<?if ($S_SITE_LNG == "KR" && $S_DELIVERY_MTH == "G"){?>
		var intDeliveryGroupPriceNo	= $("#deliveryGroupPrice option:selected").val();
		if (!C_isNull(intDeliveryGroupPriceNo))
		{
			intCartDeliveryPrice = aryOrderDeliveryGroupInfo[intDeliveryGroupPriceNo]["CUR_PRICE"];
		}
		<?}?>

		<?if ($S_MALL_TYPE != "R" && $S_SITE_LNG == "KR"){?>
			intCartDeliveryPrice = "<?=$intProdBasketDeliveryTotal?>";
		<?}?>

		/* 국가 : 해외 / 무게배송 */
		<?if ($S_SITE_LNG != "KR" && $S_DELIVERY_FOR_MTH == "W"){?>
		var strDeliveryWeightMethod		= $("#deliveryWeightMethod option:selected").val();
		var strDeliveryWeightArea		= aryOrderDeliveryCountryInfo[$("#bcountry option:selected").val()][strDeliveryWeightMethod];
		var intDeliveryProductWeight	= $("#deliveryWeight").val();
		
		if (!C_isNull(strDeliveryWeightMethod))
		{
			if (!C_isNull(aryOrderDeliveryWeightInfo[strDeliveryWeightArea][strDeliveryWeightMethod]))
			{
				intCartDeliveryPrice = aryOrderDeliveryWeightInfo[strDeliveryWeightArea][strDeliveryWeightMethod][intDeliveryProductWeight];
			} else {
				alert("<?=$LNG_TRANS_CHAR['OS00075']?>"); //주문에 대한 배송비정보가 없습니다. 관리자에게 문의바랍니다.
				return;
			}
		}
		<?}?>
		if (C_isNull(intCartDeliveryPrice))
		{
			intCartDeliveryPrice = 0;
		}
		return intCartDeliveryPrice;
	}
	
	/* 총 결제금액 표시 */
	function goTotalPriceCal()
	{
		intOrderTotalSPrice		= parseFloat(intOrderTotalSPriceOrg);
		intOrderDeliveryPrice	= goDeliveryTotalPrice();
		intOrderTotalSPrice		= intOrderTotalSPrice + parseFloat(intOrderDeliveryPrice);

		<?if ($S_SITE_LNG == "KR" && ($S_DELIVERY_MTH == "N" || !$S_DELIVERY_MTH)){?>
		intOrderTotalSPrice		= parseFloat(intOrderTotalSPrice) - parseFloat(intOrderDeliveryPrice); //한국어이고 일반배송일때는 총가격에 배송비를 포함한다.			
		<?}?>
		//intOrderTotalSPrice			= parseFloat(intOrderTotalSPrice) + parseFloat(intOrderDeliveryPrice); //->총 결제금액
		//intOrderTotalSPrice			= parseFloat(intOrderTotalSPrice); //->총 결제금액
		
		if ($("#use_point").val() > 0)
		{
			intOrderTotalSPrice = intOrderTotalSPrice - parseFloat($("#use_point").val());
		}
		
		if ($("#use_coupon").val() > 0)
		{
			intOrderTotalSPrice = intOrderTotalSPrice - parseFloat($("#use_coupon").val());
		}
		
		/* 포인트/쿠폰 결제시 총 결제금액보다 클 경우는 주문금액을 0으로 처리*/
		if (intOrderTotalSPrice < 0) intOrderTotalSPrice = 0;
		
		
		/* 회원이고 회원그룹의 할인혜택이 있을때 */
		<?if(($g_member_login && $g_member_no) && ($S_MEMBER_GROUP[$g_member_group]["DISCOUNT_ST"] != "1")){?>
			document.form.mode.value = "json";
			document.form.act.value = "memberDiscount";
			
			var orderJsonData = $("#form").serialize();
			$.getJSON("./?"+orderJsonData,function(data){	
				intOrderTotalSPrice			= data[0].O_TOT_SPRICE;
				intOrderDeliveryPrice		= data[0].O_TOT_DELIVERY_PRICE;
				intOrderMemDiscountPrice	= data[0].O_TOT_MEM_DISCOUNT_PRICE;
				intOrderMemAddPoint			= data[0].O_TOT_MEM_POINT;
				intOrderAddPoint			= data[0].O_TOT_POINT;
				intOrderTaxPrice			= data[0].O_TOT_TAX;

				goTotalPriceCalHtml();
			});
		<?}else{?>
			goTotalPriceCalHtml();
		<?}?>
	}

	function goTotalPriceCalHtml()
	{
		/* 주문 상품리스트 최종배송금액 변경 */
		$("#cartTotalDeliveryPrice").html(intOrderDeliveryPrice);
		$("#cartTotalDeliveryPrice").formatCurrency({symbol: ''<?=($S_SITE_CUR=='KRW' || $S_SITE_CUR=='JPY' || $S_SITE_CUR=='RUB')?",roundToDecimalPlace:0":"";?>});
		
		/* 주문 상품리스트 최종결제금액변경 */
		$("#cartTotalPrice").html(intOrderTotalSPrice);
		$("#cartTotalPrice").formatCurrency({symbol: ''<?=($S_SITE_CUR=='KRW' || $S_SITE_CUR=='JPY' || $S_SITE_CUR=='RUB')?",roundToDecimalPlace:0":"";?>});
		
		/* 주문내역 결제금액 */
		$(".totPayPrice").html("<span><?=$LNG_TRANS_CHAR['OW00026']?></span>: <strong class=\"priceOrange\">"+intOrderTotalSPrice+"</strong><?=getCurMark2()?>");
		$(".totPayPrice .priceOrange").formatCurrency({symbol: '<?=getCurMark()?> '<?=($S_SITE_CUR=='KRW' || $S_SITE_CUR=='JPY' || $S_SITE_CUR=='RUB')?",roundToDecimalPlace:0":"";?>});
		
		$("#good_mny").val(intOrderTotalSPrice);
		$("#good_delivery").val(intOrderDeliveryPrice);
		
		/* 주문내역 추가 할인금액 */
		if (intOrderMemDiscountPrice > 0)
		{
			$(".totMemDiscountPrice").css("display","block");
			$(".totMemDiscountPrice").html("<span><?=$LNG_TRANS_CHAR['OW00070']?></span>: <?=getCurMark()?> <strong id=\"txtMemDiscountPrice\">"+intOrderMemDiscountPrice+"</strong><?=getCurMark2()?>");
			$("#txtMemDiscountPrice").formatCurrency({symbol: ''<?=($S_SITE_CUR=='KRW' || $S_SITE_CUR=='JPY' || $S_SITE_CUR=='RUB')?",roundToDecimalPlace:0":"";?>});
		}

		$("#txtDeliveryPrice").text(intOrderDeliveryPrice);
		$("#txtDeliveryPrice").formatCurrency({symbol: ''<?=($S_SITE_CUR=='KRW' || $S_SITE_CUR=='JPY' || $S_SITE_CUR=='RUB')?",roundToDecimalPlace:0":"";?>});

		<?if ($S_SITE_CUR != "KRW"){?>
		$("#good_mny").formatCurrency({symbol: ''});
		$("#good_delivery").formatCurrency({symbol: ''});
		<?}?>
	}


	/* 쿠폰 적용 팝업창 띄우기 */
	function goPopCounponList()
	{
		window.open('?menuType=etc&mode=popCouponList','coupon','width=490px,height=400px,top=300px,left=400px,menubar=no,location=no,scrollbars=yes,status=no,resizable=no');
	}

	/* 쿠폰 사용한 금액 가지고 오기 */
	function goCouponPriceApply(html,price)
	{
		$("#divCouponParam").html(html);
		$("#use_coupon").val(price);

		goTotalPriceCal();
	}

	/* 주소록 팝업창 띄우기 */
	function goPopMemberWrite(no)
	{
		window.open('?menuType=etc&mode=popMemAddrForm&no='+no,'MemberAddr','width=490px,height=400px,top=300px,left=400px,menubar=no,location=no,scrollbars=yes,status=no,resizable=no');
	}

	/* 주소록 삭제 */
	function goMemberAddrDelete(no)
	{
		$("#no").val(no);
		var x = confirm("<?=$LNG_TRANS_CHAR['OS00063']?>"); //선택한 주소록을 삭제하시겠습니까?
		if (x == true)
		{
			var doc = document.form;
			doc.menuType.value = "member"
			doc.mode.value = "json";
			doc.act.value = "memberAddrDelete";
			
			var formData = $("#form").serialize();
			C_AjaxPost("memberAddrDelete","./index.php",formData,"post");	
		}
	}

	/* 주문서에서 주소록 팝업창 열기 */
	function goMemberAddrList()
	{
		window.open('?menuType=etc&mode=popMemAddrList','MemberAddr','width=490px,height=400px,top=300px,left=400px,menubar=no,location=no,scrollbars=yes,status=no,resizable=no');
	}
//-->
</script>