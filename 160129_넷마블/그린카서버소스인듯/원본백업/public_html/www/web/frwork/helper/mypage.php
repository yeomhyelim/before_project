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

	require_once $S_DOCUMENT_ROOT.$S_SHOP_HOME."/conf/site_skin_product.conf.inc.php";
	require_once $S_DOCUMENT_ROOT.$S_SHOP_HOME."/conf/product.inc.php";


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
	

// 2014.03.24 kim hee sung 사용자 정의 페이지로 이동함(sojewelish) 
// app 으로 제작 예정
//	/* 회원별 상품 좋아요 카테고리 리스트 */
//	if ($S_FIX_PRODUCT_LIST_LIKE_USE == "Y" && $g_member_no){
//		$param					= "";
//		$param['CATE_LNG']		= $S_SITE_LNG;
//		$param['M_NO']			= $g_member_no;
//		$aryMyProdLikeCateList	= $memberMgr->getMemberProdLikeList($db,"",$param);
//	}

	switch ($strMode)
	{
		case "droupout":
			// 회원 탈퇴

			## STEP 1.
			## 소요기간
			$settingRow = $memberMgr->getSettingView($db);

			## STEP 2.
			## 포인트 정보
			$memberMgr->setM_NO($g_member_no);
			$memberRow = $memberMgr->getMemberView($db);

		break;
		case "buyList":
			if (!$g_member_no)
			{
				if($S_MAIN_LAYERPOP_LOGIN_USE=="Y" && $strDevice != "m") {
					goUrl("","./");
				} else goUrl("","./?menuType=member&mode=login&returnMenu=mypage&returnMode=buyList&returnParam=searchOrderStatus^||^$strSearchOrderStatus");
				exit;
			}
			
			$orderMgr->setM_NO($g_member_no);
			$memberMgr->setM_NO($g_member_no);
			
			$strTabSelectClass1 = "";
			$strTabSelectClass2 = "";
			$strTabSelectClass3 = "";
			$strTabSelectClass4 = "";

			if ($strSearchOrderStatus == "") $strTabSelectClass1 = "class=\"selectedTab\""; 
			if ($strSearchOrderStatus == "UI") $strTabSelectClass2 = "class=\"selectedTab\""; 
			if ($strSearchOrderStatus == "E") $strTabSelectClass3 = "class=\"selectedTab\"";
			if ($strSearchOrderStatus == "R") $strTabSelectClass4 = "class=\"selectedTab\"";

			/* 상태별 주문 갯수 구하기*/
			//B준비, I중, D완 상태 
			$intOrderTotal	= $orderMgr->getOrderTotal($db);
			$orderMgr->setSearchOrderStatus("UI");
			$intOrderDeliveryTotal	= $orderMgr->getOrderTotal($db);

			//구매확정
			$orderMgr->setSearchOrderStatus("E");
			$intOrderEndTotal	= $orderMgr->getOrderTotal($db);


			//결제취소
			$orderMgr->setSearchOrderStatus("C");
			$intOrderCancelTotal	= $orderMgr->getOrderTotal($db);
			//반품??
			$orderMgr->setSearchOrderStatus("P");
			$intOrderBackTotal	= $orderMgr->getOrderTotal($db);
			//반품
			$orderMgr->setSearchOrderStatus("R");
			$intOrderReturnTotal	= $orderMgr->getOrderTotal($db);
			//환불
			$orderMgr->setSearchOrderStatus("T");
			$intOrderExchangeTotal	= $orderMgr->getOrderTotal($db);


			//결제완료
			$orderMgr->setSearchOrderStatus("A");
			$intOrderApprTotal	= $orderMgr->getOrderTotal($db);

			//가상계좌, 무통장주문완료
			$orderMgr->setSearchOrderStatus("J");
			$intOrderWaitTotal	= $orderMgr->getOrderTotal($db);
			


			//리스트 목록을 위해 초기화
			//$orderMgr->setSearchOrderStatus();
			

			/* 포인트 부분 */
			$memberRow = $memberMgr->getMemberView($db);

			/* 검색부분 */
			// 검색부분 사용안함 2015.05.29 kjp
			//$orderMgr->setSearchField($strSearchField);
			//$orderMgr->setSearchKey($strSearchKey);

			switch($strSearchOrderStatus){
				case('R') :
					$orderMgr->setSearchOrderStatus('AC');//취소상태
					break;
				case('E') : 
					$orderMgr->setSearchOrderStatus('E');//구매완료상태
					break;
				case('UI') : 
					$orderMgr->setSearchOrderStatus('UI');//배송상태
					break;
				case('J') : 
					$orderMgr->setSearchOrderStatus('J');//주문상태
					break;
				case('A') : 
					$orderMgr->setSearchOrderStatus('A');//결제완료상태
					break;
				default : 
					$orderMgr->setSearchOrderStatus('AO');//주문상태
					break;
			
			}

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
			if ($strMode == "buyView"){
				if (!$g_member_no)
				{
					if($S_MAIN_LAYERPOP_LOGIN_USE=="Y" && $strDevice != "m") {
						goUrl("","./");
					} else goUrl("","./?menuType=member&mode=login&returnMenu=mypage&returnMode=buyList");
					exit;
				}
			}

			$orderMgr->setO_NO($intO_NO);
			$orderRow = $orderMgr->getOrderView($db);

			$intCartTotal= $orderMgr->getOrderCartTotal($db);
			$orderMgr->setPageLine($intCartTotal);
			$orderMgr->setLimitFirst(0);

			$cartResult = $orderMgr->getOrderCartList($db);

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

			if ($S_SITE_LNG != "KR"){
				$aryCountryList		= getCountryList();			
				$aryCountryState	= getCommCodeList("STATE","");
				$strDeliveyState	= $orderRow[O_B_STATE];
				if ($orderRow[O_B_COUNTRY] == "US") $strDeliveyState = $aryCountryList[$orderRow[O_B_STATE]];
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

			/* 고객사은품 */
			$aryOrderGiftList = $orderMgr->getOrderGiftList($db);

			$aryDeliveryCom	= getCommCodeList("DELIVERY","Y");
			$aryDeliveryUrl	= getDeliveryUrlList();

			if ($SHOP_USER_ADD_MENU_USE == "Y" && $SHOP_USER_ADD_MENU_["ORDER"]["USE"] == "Y"){
				/*나피큐어*/
				$param = "";
				$param['O_NO'] = $orderRow['O_NO'];
				$orderUploadCheckRow = $orderMgr->getOrderUploadFileCheck($db,$param);				
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
		break;

		case "cartMyList":
			
			if (!$g_member_no)
			{
				if($S_MAIN_LAYERPOP_LOGIN_USE=="Y" && $strDevice != "m") {
					goUrl("","./");
				} else goUrl("","./?menuType=member&mode=login&returnMenu=mypage&returnMode=cartMyList");
				exit;
			}
			$productMgr->setSearchField($strSearchField);
			$productMgr->setSearchKey($strSearchKey);
			$productMgr->setM_NO($g_member_no);

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
			if (!$g_member_no)
			{
				if($S_MAIN_LAYERPOP_LOGIN_USE=="Y" && $strDevice != "m") {
					goUrl("","./");
				} else goUrl("","./?menuType=member&mode=login&returnMenu=mypage&returnMode=wishMyList");
				exit;
			}

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
				} else goUrl("","./?menuType=member&mode=login&returnMenu=mypage&returnMode=myInfo");
				exit;
			}
			$memberMgr->setM_NO($g_member_no);
			$memberRow = $memberMgr->getMemberView($db);
			//echo "<!--{$db->query} dddsds//-->";
			/* 그룹 항목 선택 */
			$strMemberJoinType = $memberRow['M_GROUP'];
			
			$aryMemHp		= explode("-",$memberRow['M_HP']);	// 휴대폰
			$aryMemPhone	= explode("-",$memberRow['M_PHONE']);	// 전화
			$aryMemFax		= explode("-",$memberRow['M_FAX']);	// 팩스
			$aryMemZip		= explode("-",$memberRow['M_ZIP']);	// 우편번호
			$aryMemWedDay	= explode("-",$memberRow['M_WED_DAY']);	// 결혼기념일
			$aryMemBusiNum	= explode("-",$memberRow['M_BUSI_NUM']);	// 사업자번호
			$aryMemBusiZip	= explode("-",$memberRow['M_BUSI_ZIP']);	// 사업자 우편번호

			$strSmsYN	= $memberRow['M_SMSYN'] == 'Y' ? "checked" : "";		// SMS 수신여부
			$strMailYN	= $memberRow['M_MAILYN'] == 'Y' ? "checked" : "";		//	메일 수신여부

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
			
			/* 소속 리스트 */
			if ($S_FIX_MEMBER_CATE_USE_YN == "Y"){
				
				## 회원소속관리 불러오기
				$fileName			= "{$S_DOCUMENT_ROOT}{$S_SHOP_HOME}/conf/member.cate.inc.php";
				//include_once $fileName;
				//member.cate.inc.php 파일 자체가 아예 없음.
				if(is_file($fileName)):
					require_once "$fileName";
				endif;

				require_once MALL_CONF_LIB."memberCateMgr.php";
				$memberCateMgr			= new MemberCateMgr();
				
				$param								= "";
				$param['M_NO']						= $g_member_no;
				$param['ORDER_BY']					= "C.C_CODE ASC";
				$param['MEMBER_CATE_MGR_JOIN']		= "Y";
				$memberCateJoinResult				= $memberCateMgr->getMemberCateJoinListEx($db, "OP_LIST", $param);
			}
			/** 휴대폰 인증 모듈(사용 가능 여부 체크) **/

			## STEP 1.
			## 휴대폰 인증 모듈(세션 초기화)
			$_SESSION['SESS_MEMBER_JOIN_MODE']		= "";
			$_SESSION['SESS_MEMBER_JOIN_CNT']		= "";
			$_SESSION['SESS_MEMBER_JOIN_TIME']		= "";
			$_SESSION['SESS_MEMBER_JOIN_KEY']		= "";
			$phoneCheck								= "Y";

			## STEP 2. 
			## 휴대폰 인증 모듈(사용 유무 체크)
//			require_once MALL_CONF_LIB."MemberMgr.php";	
//			$memberMgr		= new MemberMgr();
			$settingRow		= $memberMgr->getSettingView($db);
			if($settingRow['J_PHONE'] != "Y") { $phoneCheck = ""; }

			## STEP 3.
			## 휴대폰 인증 모듈(한국어 사이트 체크).
			if($S_SITE_LNG != "KR") { $phoneCheck = ""; }

			## STEP 4.
			## 휴대폰 인증 모듈(문자 발송 가능 건수 체크)
			require_once "{$S_DOCUMENT_ROOT}www/classes/sms/sms.func.class.php";
			$smsFunc		= new SmsFunc();
			$smsMoney		= $smsFunc->getSmsMoneySelect($db); // 머니 체크
			if($smsMoney['VAL'] <= 0) { $phoneCheck = ""; }
			
			/** 휴대폰 인증 모듈(사용 가능 여부 체크) **/
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
				} else goUrl("","./?menuType=member&mode=login&returnMenu=mypage&returnMode=myInfo");
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
				} else goUrl("","./?menuType=member&mode=login&returnMenu=mypage&returnMode=myInfo");
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
				} else goUrl("","./?menuType=member&mode=login&returnMenu=mypage&returnMode=couponList");
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

		case "prodList":


			$strSearchProdShare		= $_POST["lcateShare"]			? $_POST["lcateShare"]			: $_REQUEST["lcateShare"];

			$strSearchSort			= $_POST["sort"]				? $_POST["sort"]				: $_REQUEST["sort"];
			$strSearchIcon1			= $_POST["searchIcon1"]			? $_POST["searchIcon1"]			: $_REQUEST["searchIcon1"];
			$strSearchIcon2			= $_POST["searchIcon2"]			? $_POST["searchIcon2"]			: $_REQUEST["searchIcon2"];
			$strSearchIcon3			= $_POST["searchIcon3"]			? $_POST["searchIcon3"]			: $_REQUEST["searchIcon3"];
			$strSearchIcon4			= $_POST["searchIcon4"]			? $_POST["searchIcon4"]			: $_REQUEST["searchIcon4"];
			$strSearchIcon5			= $_POST["searchIcon5"]			? $_POST["searchIcon5"]			: $_REQUEST["searchIcon5"];
			$strSearchIcon6			= $_POST["searchIcon6"]			? $_POST["searchIcon6"]			: $_REQUEST["searchIcon6"];
			$strSearchIcon7			= $_POST["searchIcon7"]			? $_POST["searchIcon7"]			: $_REQUEST["searchIcon7"];
			$strSearchIcon8			= $_POST["searchIcon8"]			? $_POST["searchIcon8"]			: $_REQUEST["searchIcon8"];
			$strSearchIcon9			= $_POST["searchIcon9"]			? $_POST["searchIcon9"]			: $_REQUEST["searchIcon9"];
			$strSearchIcon10		= $_POST["searchIcon10"]		? $_POST["searchIcon10"]		: $_REQUEST["searchIcon10"];
			$strSearchColor			= $_POST["searchColor"]			? $_POST["searchColor"]			: $_REQUEST["searchColor"];
			$strSearchSize			= $_POST["searchSize"]			? $_POST["searchSize"]			: $_REQUEST["searchSize"];

			$strSearchStartPrice	= $_POST["searchStartPrice"]	? $_POST["searchStartPrice"]	: $_REQUEST["searchStartPrice"];
			$strSearchEndPrice		= $_POST["searchEndPrice"]		? $_POST["searchEndPrice"]		: $_REQUEST["searchEndPrice"];

			$strSearchListIcon		= $_POST["searchListIcon"]		? $_POST["searchListIcon"]		: $_REQUEST["searchListIcon"];

			$strSearchBrand			= $_POST["searchBrand"]			? $_POST["searchBrand"]			: $_REQUEST["searchBrand"];

			$productMgr->setP_LNG($S_SITE_LNG);


			$linkPage  = "?menuType=$strMenuType&mode=$strMode&lcate=$strSearchHCode1&mcate=$strSearchHCode2";
			$linkPage .= "&scate=$strSearchHCode3&fcate=$strSearchHCode4&lcateShare=$strSearchProdShare";
			$linkPage .= "&searchField=$strSearchField&searchKey=$strSearchKey";
			$linkPage .= "&searchIcon6=$strSearchIcon6&searchIcon7=$strSearchIcon7&searchIcon8=$strSearchIcon8";
			$linkPage .= "&sort=$strSearchSort&searchColor=$strSearchColor&searchSize=$strSearchSize";
			$linkPage .= "&searchStartPrice=$strSearchStartPrice&searchEndPrice=$strSearchEndPrice&searchListIcon=$strSearchListIcon";
			$linkPage .= "&searchBrand=$strSearchBrand&page=";

		break;

		case "auctionMyList":
			
			if (!$g_member_no)
			{
				if($S_MAIN_LAYERPOP_LOGIN_USE=="Y" && $strDevice != "mobile") {
					goUrl("","./");
				} else goUrl("","./?menuType=member&mode=login&returnMenu=mypage&returnMode=auctionMyList");
				exit;
			}

			## 클래스 설정
			$objProductAuctionModule	= new ProductAuctionModule($db);
			
			$param						= "";
			$param['M_NO']				= $g_member_no;
			$param['P_LNG']				= $S_SITE_LNG;

			$intPageBlock				= 10;
			$intPageLine				= 10;

			$intTotal					= $objProductAuctionModule->getProductAuctionMySelectEx("OP_COUNT",$param);
			$intTotPage					= ceil($intTotal / $intPageLine);

			if(!$intPage)	$intPage =1;

			if ($intTotal==0) {
				$intFirst	= 1;
				$intLast	= 0;			
			} else {
				$intFirst	= $intPageLine *($intPage -1);
				$intLast	= $intPageLine * $intPage;
			}
			
			$param['LIMIT_START']		= $intFirst;
			$param['LIMIT_END']			= $intPageLine;

			$result						= $objProductAuctionModule->getProductAuctionMySelectEx("OP_LIST",$param);
			$intListNum					= $intTotal - ($intPageLine *($intPage-1));		
			
			$linkPage					= "?menuType=$strMenuType&mode=$strMode";
			$linkPage                  .= "&searchField=$strSearchField&searchKey=$strSearchKey";
			$linkPage                  .= "&page=";
		break;

	}
?>

<script type="text/javascript">
<!--
	var intM_NO = "<?=$g_member_no?>";
	
	$(document).ready(function(){
		<?if ($strMode == "myInfo"){?>
		
		$('#pwd1').alphanumeric({allow:"!,*&^%$#@~;`-+:?/<>{}[]\\=."});
		$("#pwd1").css("ime-mode", "disabled"); 

		$('#pwd2').alphanumeric({allow:"!,*&^%$#@~;`-+:?/<>{}[]\\=."});
		$("#pwd2").css("ime-mode", "disabled"); 

		$('#birth1').numeric();
		$("#birth1").css("ime-mode", "disabled"); 

		$('#birth2').numeric();
		$("#birth2").css("ime-mode", "disabled"); 
		
		$('#birth3').numeric();
		$("#birth3").css("ime-mode", "disabled"); 
	
		$('#hp2').numeric();
		$("#hp2").css("ime-mode", "disabled"); 

		$('#hp3').numeric();
		$("#hp3").css("ime-mode", "disabled"); 

		$('#phone2').numeric();
		$("#phone2").css("ime-mode", "disabled"); 

		$('#phone3').numeric();
		$("#phone3").css("ime-mode", "disabled"); 

		$('#weddingDay1').numeric();
		$("#weddingDay1").css("ime-mode", "disabled"); 

		$('#weddingDay2').numeric();
		$("#weddingDay2").css("ime-mode", "disabled"); 

		$('#weddingDay3').numeric();
		$("#weddingDay3").css("ime-mode", "disabled"); 


		$("#mail").bind("blur", function() {
			if ($(this).val())
			{
				$.getJSON("./?menuType=member&mode=json&act=mailChk&mail="+$(this).val(),function(data){	
					if (data[0].RET == "N")
					{
						alert(data[0].MSG);
						$("#mail").val("");
						return;
					}
				});			
			}
		});

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

		// 비밀번호
		if($("#pwd1").val().length > 0){
			if($("#pwd1").val().length < 4){
				alert('<?= $LNG_TRANS_CHAR["MS00004"]; // ?>');
				$("#pwd1").focus();
				return;
			}
			if($("#pwd1").val() != $("#pwd2").val()){
				alert('<?= $LNG_TRANS_CHAR['MS00064']; ?>');
				$("#pwd1").focus();
				return;
			}
		}

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
				<?
				if($strMemberJoinType != '002')
				{
				?>
				<?if ($S_SITE_LNG != "KR"){?>
					if(!C_chkInput("phone1",true,"<?=$LNG_TRANS_CHAR['MW00009']?>",true)) return; 
				<?}else{?>
					if(!C_chkInput("phone2",true,"<?=$LNG_TRANS_CHAR['MW00009']?>",true)) return;
					if(!C_chkInput("phone3",true,"<?=$LNG_TRANS_CHAR['MW00009']?>",true)) return;
				<?}?>
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
				<?
				if($strMemberJoinType != '002')
				{
				?>
			if(!C_chkInput("busi_nm",true,"<?=$LNG_TRANS_CHAR['MW00032']?>",true)) return;
				<?}?>
			<?}?>
		<?}?>
		
		//사업자번호
		<?if ($S_JOIN_BUSI_NUM["USE"] == "Y" && $S_JOIN_BUSI_NUM["MYPAGE"] == "Y" && $S_JOIN_BUSI_NUM["NES"] == "Y"){?>
			<?if (!$S_JOIN_BUSI_NUM["GRADE"] || in_array($strMemberJoinType,$S_JOIN_BUSI_NUM["GRADE"])){?>
				<?
				if($strMemberJoinType != '002')
				{
				?>
			if(!C_chkInput("busi_num1",true,"<?=$LNG_TRANS_CHAR['MW00033']?>",true)) return;
			if(!C_chkInput("busi_num2",true,"<?=$LNG_TRANS_CHAR['MW00033']?>",true)) return;
			if(!C_chkInput("busi_num3",true,"<?=$LNG_TRANS_CHAR['MW00033']?>",true)) return;
				<?}?>
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


		<?if($phoneCheck == "Y"): /* 휴대폰 인증 */ ?>

		var orgHp  = $("input[id=orgHp]").val();
		var newHp  = $("select[name=hp1]").val() + $("input[name=hp2]").val() + $("input[name=hp3]").val();

		if(newHp != orgHp) {
			var disHp1 = $("select[name=hp1]").attr("disabled");
			var disHp2 = $("input[name=hp2]").attr("disabled");
			var disHp3 = $("input[name=hp3]").attr("disabled");
			if(!disHp1 || !disHp2 || !disHp3) { 
				alert("휴대폰 인증이 필요합니다.");
				return;
			}
		}

		$("select[name=hp1]").attr("disabled",false);
		$("input[name=hp2]").attr("disabled",false);
		$("input[name=hp3]").attr("disabled",false);
		<?endif;?>		
		
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
			
			doc.menuType.value = "order";
			doc.no.value = no;
			doc.mode.value = "act";
			doc.act.value = "moveBasket";
			doc.method = "post";
			doc.action = "<?=$PHP_SELF?>";
			doc.submit();
		}
	}


	function goBasketAll()
	{
		if (C_isNull(intM_NO))
		{
			alert("<?=$LNG_TRANS_CHAR['OS00014']?>"); //로그인을 하신 후 이용하실 수 있습니다.
			return;
		}

		if (!C_isNull(document.form["cartNo[]"]))
		{
			var strSelectNo = C_getCheckedCode(document.form["cartNo[]"]);
			if (C_isNull(strSelectNo))
			{
				alert("<?=$LNG_TRANS_CHAR['OS00012']?>"); //장바구니로 보낼 상품을 선택해주세요.
				return;
			}

			var doc = document.form;
			doc.menuType.value = "order";
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
			doc.menuType.value = "order";
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
			doc.menuType.value = "order";
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
			
			doc.menuType.value = "order";
			doc.no.value = no;
			doc.mode.value = "act";
			doc.act.value = "wishDel";
			doc.method = "post";
			doc.action = "<?=$PHP_SELF?>";
			doc.submit();
		}
	}
	
	
	function goWishDelAll()
	{
		if (C_isNull(intM_NO))
		{
			alert("<?=$LNG_TRANS_CHAR['OS00014']?>"); //로그인을 하신 후 이용하실 수 있습니다.
			return;
		}

		if (!C_isNull(document.form["cartNo[]"]))
		{
			var strSelectNo = C_getCheckedCode(document.form["cartNo[]"]);
			if (C_isNull(strSelectNo))
			{
				alert("<?=$LNG_TRANS_CHAR['OS00018']?>"); //장바구니로 보낼 상품을 선택해주세요.
				return;
			}

			var doc = document.form;
			doc.menuType.value = "order";
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

	// 수량 변경 (장바구니)
	function goQtyUpdate(mode, no)
	{
		var intQty = $('#'+mode+'Qty'+no).val();
		var strUrl = './?menuType=order&mode=json&act=' + mode + 'Qty&' + mode + 'No=' + no + '&qty=' + intQty;

		if(!intQty) {
			alert('변경할 수량을 선택하세요');
			return;
		}

		$.getJSON(strUrl, function(data){
//			console.log(data);
			var strRet = data[0]['RET'];
			var strMsg = data[0]['MSG'];
			if(strRet == "N") {
				alert(strMsg);
				location.reload();
			} else {
				location.reload();
			}
		});

	}

// 2014.06.16 kim hee sung 소스 정리
//	function goQtyUpdate(mode,no)
//	{
//		var intQty = parseInt($("#"+mode+"Qty"+no).val());
//		var strJsonParam = "cartQty&cartNo="+no+"&qty="+intQty;
//
//		if (mode == "wish")
//		{
//			var strJsonParam = "wishQty&wishNo="+no+"&qty="+intQty;
//		}
//
//		$.getJSON("./?menuType=order&mode=json&act="+strJsonParam,function(data){
//
//			location.reload();
//			//alert(data[0].MSG);
//			return;
//		})
//	}

	/* 장바구니 삭제 */
	function goCartDel(no)
	{
		var x = confirm("<?=$LNG_TRANS_CHAR['OS00017']?>"); //선택한 상품을 삭제하시겠습니까?
		if (x == true)
		{
			var doc = document.form;
			doc.menuType.value = "order";
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
				doc.returnMenu.value = "mypage";
				<?}?>
				doc.menuType.value = "order";
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
				
				doc.menuType.value = "order";
				doc.mode.value = "act";
				doc.act.value = "order1";
				doc.method = "post";
				doc.action = "<?=$PHP_SELF?>";
				doc.submit();
			}
		}
	}

	function goAjaxRet(name,result){

		if (name == "memberAddrDelete"){
			var data = eval(result);
			
			if (data[0].RET == "Y")
			{
				location.reload();
			}
		}
		else if(name == "memberPhoneKeyRequest") {
			var data = eval(result);
			if(data[0]['RET'] == "START"){
				// 인증키 등록 대기 시작
				$("input[name=phoneKey]").css({'display':''});
				$("#memberPhoneKeyCheck").css({'display':''});
				goStart();
			}else if(data[0]['RET'] == "OVER") {
				alert("문자 발송 가능 건수를 초과하였습니다. 잠시 후 다시 시도해 주세요");
			}
		}else if(name == "memberPhoneKeyCheck") {
			var data = eval(result);
			if(data[0]['RET'] == "WRONG"){
				alert("인증키가 일치하지않습니다.");
			}else if(data[0]['RET'] == "CORRECT"){
		//		$("span[id=memberPhoneKeyRequest]").html("휴대폰 인증 완료!!");
				$("span[id=memberPhoneKeyRequest]").html("");
				$("input[name=phoneKey]").css({'display':'none'});
				$("#memberPhoneKeyCheck").remove();
				$("#memberPhoneKeyCountDown").remove();
				$("select[name=hp1]").attr("disabled",true);
				$("input[name=hp2]").attr("disabled",true);
				$("input[name=hp3]").attr("disabled",true);
				alert("인증되었습니다.");
			}
		}else if(name == "memberPhoneKeyExpire") {
			var data = eval(result);
			if(data[0]['RET'] == "EXPIRE") {
				alert("인증키 만료되었습니다. 다시요청하시기 바랍니다.");
			}
		}else if (name == "prodLikeUpdate"){
			/* 좋아요 상품 */
			var data = eval(result);
			if (data[0].RET == "Y"){
				var prodLikeObj = $("#span_"+data[0].P_CODE);
				prodLikeObj.removeClass("ico_like");
				prodLikeObj.removeClass("ico_likeH");
				if (data[0].LIKE_TYPE == "Y") {
					prodLikeObj.addClass("ico_likeH");
				} else {
					prodLikeObj.addClass("ico_like");
				}
				return;
			} else {

				if (data[0].MSG == 'NO_MEMBER_LOGIN')
				{
					alert("<?=$LNG_TRANS_CHAR['OS00014']?>");
					return;
				}

				if (data[0].MSG == 'QUERY_ERROR')
				{
					alert("<?=$LNG_TRANS_CHAR['MS00029']?>");
					return;
				}
			}
		}else if (name == "prodLikeAllDelete"){
			/* 좋아요 상품 */
			var data = eval(result);
			if (data[0].RET == "Y"){
				location.reload();
				return;
			} else {

				if (data[0].MSG == 'NO_MEMBER_LOGIN')
				{
					alert("<?=$LNG_TRANS_CHAR['OS00014']?>");
					return;
				}

				if (data[0].MSG == 'QUERY_ERROR')
				{
					alert("<?=$LNG_TRANS_CHAR['MS00029']?>");
					return;
				}
			}
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

	function goMyOrderCerityOk(no)
	{
		C_openWindow('./?menuType=etc&mode=orderCerityOk&no='+no, "<?=$LNG_TRANS_CHAR['OW00100']?>", "500", "300"); //구매확정
	}
	
	/* 쇼핑계속하기 */
	function goProdList()
	{
		var doc = document.form;
		
		doc.menuType.value = "product";
		doc.mode.value = "list";
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

	/* 우편번호 찾기 */
	function goZip(num)
	{

		window.open('?menuType=etc&mode=address2&num=' + num,'new','width=600px,height=670px,top=300px,left=400px,toolbar=no,directories=no,scrollbars=no,resizable=no,status=no,menubar=no,location=no');

		//window.open('?menuType=etc&mode=address&num='+num,'new','width=490px,height=400px,top=300px,left=400px,menubar=no,location=no,scrollbars=yes,status=no,resizable=no');
	}
	

	/* 포인트 선물하기 창(2013.08.16) */
	function goMemberPointGift(){
		window.open('?menuType=etc&mode=popMemPointGift','MemberPointGift','width=600px,height=400px,top=300px,left=400px,menubar=no,location=no,scrollbars=yes,status=no,resizable=no');
	}
	
	/* 아이디 체크 */
	<?if ($SHOP_MEMBER_ID_MODIFY_FLAG == "Y"){?>
	function goIdChk()
	{
		var doc		= document.form;
		var strId	= doc.id.value;

		if(!C_chkInput("id",true,"아이디",true)) return;

		if ($("#id").val().length < 4 || $("#id").val().length > 12)
		{
			alert("<?=$LNG_TRANS_CHAR['MS00003']?>"); //"아이디는 영문, 숫자 중 4자 이상 12자리 이하 사용  가능합니다."
			doc.id.focus();
			return;
		}
				
		$.getJSON("./?menuType=member&mode=json&act=idChk&id="+strId,function(data){	
			
			alert(data[0].MSG);
			if (data[0].RET == "N")
			{
				doc.id.value = "";
				doc.id.focus();
				return;
			
			} else {
				strIdChkFlag = "Y";
			}
		});
	}
	<?}?>

	/* 쿠폰 등록하기 */
	function goCouponReg(){
		window.open('?menuType=etc&mode=popCouponReg','CouponReg','width=490px,height=400px,top=300px,left=400px,menubar=no,location=no,scrollbars=yes,status=no,resizable=no');
	}

	/* 주문목록페이지에서 주문 상품 중 다운로드 상품이 존재하면 파일다운로드 페이지 호출 */
	function goMyOrderProdDownload(no)
	{
		C_openWindow("/layout/userAdd/orderProdDownloadList.php?lang=<?=$S_SITE_LNG?>&no="+no, "상품다운로드", 500, 550);
	}

	/* 상품 좋아요 */
	function goProdLikeUpdate(prodCode){
		if (C_isNull(intM_NO))
		{
			alert("<?=$LNG_TRANS_CHAR['OS00014']?>");
			return;
		}

		var data			= new Array();
		
		data['prodCode']	= prodCode
		data['menuType']	= "product";
		data['mode']		= "json";
		data['act']			= "prodLikeUpdate";	

		//C_getSelfAction(data);
		C_getJsonAjaxAction("prodLikeUpdate","./index.php",data);
	}

	/* 상품 좋아요 전체삭제 */
	function goProdLikeAllDelete(){
		
		if (C_isNull(intM_NO))
		{
			alert("<?=$LNG_TRANS_CHAR['OS00014']?>");
			return;
		}

		var x = confirm("<?=$LNG_TRANS_CHAR['PS00018']?>");
		if (x == true)
		{
			var data			= new Array();
			
			data['menuType']	= "product";
			data['mode']		= "json";
			data['act']			= "prodLikeAllDelete";	

			C_getJsonAjaxAction("prodLikeAllDelete","./index.php",data);
		}
	}

	function goProdView(no)
	{
		<?if($strDevice=="m"){?>
		location.href = "./?menuType=product&mode=view&prodCode="+no;
		<?}else{?>
		
		var data			= new Array();
		
		data['prodCode']	= no
		data['menuType']	= "product";
		data['mode']		= "view";
		C_getSelfAction(data);		
		<?}?>
	}

	/* 입찰하기 리스트 */
	function goProdAuctionMyApplyList(prodCode)
	{
		var strUrl = "./?menuType=etc&mode=popProdAuctionApplyList&prodAucMyList=Y&prodCode="+prodCode;
		goOpenWinSmartPop(strUrl, "", 500, 500, "");
	}
//-->
</script>

<?if($strMode == "droupout"):?>
<script type="text/javascript">
<!--
	/* 회원 탈퇴 */
	function goMypageDroupoutActEvent() { goMypageDroupoutAct(); }

	function goMypageDroupoutAct() {
		var out_txt		= $("input[name=out_txt]").val();
		var pass		= $("input[name=pass]").val();
		if(!out_txt){
			alert("<?=$LNG_TRANS_CHAR['MS00046'] //탈퇴 사유를 입력하세요.?>");
			$("input[name=out_txt]").focus();
			return false;
		}
		if(!pass){
			alert("<?=$LNG_TRANS_CHAR['MS00047'] //비밀번호를 입력하세요.?>");
			$("input[name=pass]").focus();
			return false;
		}

		var doc = document.form;
		doc.menuType.value	= "member";
		doc.mode.value		= "act";
		doc.act.value		= "memberDroupout";
		doc.method			= "post";
		doc.action			= "<?=$PHP_SELF?>";
		doc.submit();
	}
//-->
</script>
<?endif;?>
<?if(in_array($strMode, array("dropout", "myInfo"))):?>
<script type="text/javascript">
<!--
	/* 회원 탈퇴 */
	function goMypageDropoutMoveEvent() { goMypageDropoutMove();	}

	function goMypageDropoutMove() {
		var url = "./?menuType=mypage&mode=popDropout";
		window.open(url, "", "width=500px,height=445px");
	}

//-->
</script>
<?endif;?>
<? 
	/** 휴대폰 인증키 관련 js **/
	if($phoneCheck == "Y"):
		include_once "{$S_DOCUMENT_ROOT}www/web/member/memberJoinFormCheckModule.js.php";
	endif;
?>