<?
require_once MALL_CONF_LIB."ProductMgr.php";
require_once MALL_CONF_LIB."OrderMgr.php";
require_once MALL_CONF_LIB."MemberMgr.php";
require_once MALL_CONF_LIB."SiteMgr.php";

require_once MALL_SHOP . "/conf/order.inc.php";
require_once MALL_CONF_LIB."ShopOrderNewMgr.php";

if(is_file(MALL_SHOP."/conf/shop.manual.inc.php")):
	require_once MALL_SHOP."/conf/shop.manual.inc.php";
endif;

/*상품함수관련*/
require_once MALL_PROD_FUNC;

$orderMgr = new OrderMgr();
$productMgr = new ProductMgr();
$memberMgr = new MemberMgr();
$siteMgr = new SiteMgr();
$shopOrderMgr = new ShopOrderMgr();

$intPB_NO				= $_POST["cartNo"]				? $_POST["cartNo"]				: $_REQUEST["cartNo"];
$intPW_NO				= $_POST["wishNo"]				? $_POST["wishNo"]				: $_REQUEST["wishNo"];

$intQty					= $_POST["qty"]					? $_POST["qty"]					: $_REQUEST["qty"];

$intCartPage			= $_POST["cartPage"]			? $_POST["cartPage"]			: $_REQUEST["cartPage"];		// 퀵 장바구니 출력 페이지 설정

$result_array = array();

/*##################################### 주문하기 결제창 셋팅 #####################################*/
$intNo					= $_POST["no"]				? $_POST["no"]				: $_REQUEST["no"];

$strO_J_NAME			= $_POST["jname"]			? $_POST["jname"]			: $_REQUEST["jname"];
$strO_J_F_NAME			= $_POST["j_f_name"]		? $_POST["j_f_name"]		: $_REQUEST["j_f_name"];
$strO_J_L_NAME			= $_POST["j_l_name"]		? $_POST["j_l_name"]		: $_REQUEST["j_l_name"];
if (!$strO_J_NAME) {
	$strO_J_NAME = $strO_J_F_NAME;
	if ($strO_J_NAME) $strO_J_NAME .= " ";
	$strO_J_NAME .= $strO_J_L_NAME;
}

$strO_J_PHONE1			= $_POST["jphone1"]			? $_POST["jphone1"]			: $_REQUEST["jphone1"];
$strO_J_PHONE2			= $_POST["jphone2"]			? $_POST["jphone2"]			: $_REQUEST["jphone2"];
$strO_J_PHONE3			= $_POST["jphone3"]			? $_POST["jphone3"]			: $_REQUEST["jphone3"];
$strO_J_PHONE			= $strO_J_PHONE1;
if ($strO_J_PHONE2) $strO_J_PHONE .= "-".$strO_J_PHONE2;
if ($strO_J_PHONE3) $strO_J_PHONE .= "-".$strO_J_PHONE3;
if ($S_SITE_LNG == "KR" && !$strO_J_PHONE2 && !$strO_J_PHONE3) $strO_J_PHONE = "";

$strO_J_HP1				= $_POST["jhp1"]			? $_POST["jhp1"]			: $_REQUEST["jhp1"];
$strO_J_HP2				= $_POST["jhp2"]			? $_POST["jhp2"]			: $_REQUEST["jhp2"];
$strO_J_HP3				= $_POST["jhp3"]			? $_POST["jhp3"]			: $_REQUEST["jhp3"];
$strO_J_HP				= $strO_J_HP1;
if ($strO_J_HP2) $strO_J_HP .= "-".$strO_J_HP2;
if ($strO_J_HP3) $strO_J_HP .= "-".$strO_J_HP3;

$strO_J_MAIL			= $_POST["jmail"]			? $_POST["jmail"]			: $_REQUEST["jmail"];

$strO_B_NAME			= $_POST["bname"]			? $_POST["bname"]			: $_REQUEST["bname"];

$strO_B_PHONE1			= $_POST["bphone1"]			? $_POST["bphone1"]			: $_REQUEST["bphone1"];
$strO_B_PHONE2			= $_POST["bphone2"]			? $_POST["bphone2"]			: $_REQUEST["bphone2"];
$strO_B_PHONE3			= $_POST["bphone3"]			? $_POST["bphone3"]			: $_REQUEST["bphone3"];
$strO_B_PHONE			= $strO_B_PHONE1;
if ($strO_B_PHONE2) $strO_B_PHONE .= "-".$strO_B_PHONE2;
if ($strO_B_PHONE3) $strO_B_PHONE .= "-".$strO_B_PHONE3;
if ($S_SITE_LNG == "KR" && !$strO_B_PHONE2 && !$strO_B_PHONE3) $strO_B_PHONE = "";

$strO_B_HP1				= $_POST["bhp1"]			? $_POST["bhp1"]			: $_REQUEST["bhp1"];
$strO_B_HP2				= $_POST["bhp2"]			? $_POST["bhp2"]			: $_REQUEST["bhp2"];
$strO_B_HP3				= $_POST["bhp3"]			? $_POST["bhp3"]			: $_REQUEST["bhp3"];
$strO_B_HP				= $strO_B_HP1;
if ($strO_B_HP2) $strO_B_HP .= "-".$strO_B_HP2;
if ($strO_B_HP3) $strO_B_HP .= "-".$strO_B_HP3;

$strO_B_MAIL			= $_POST["bmail"]			? $_POST["bmail"]			: $_REQUEST["bmail"];
$strO_B_ZIP1			= $_POST["bzip1"]			? $_POST["bzip1"]			: $_REQUEST["bzip1"];
$strO_B_ZIP2			= $_POST["bzip2"]			? $_POST["bzip2"]			: $_REQUEST["bzip2"];
$strO_B_ZIP				= $strO_B_ZIP1;
if ($strO_B_ZIP2) $strO_B_ZIP .= "-".$strO_B_ZIP2;

$strO_B_MEMO			= $_POST["bmemo"]				? $_POST["bmemo"]				: $_REQUEST["bmemo"];

$strO_B_COUNTRY			= $_POST["bcountry"]			? $_POST["bcountry"]			: $_REQUEST["bcountry"];
$strO_B_CITY			= $_POST["bcity"]				? $_POST["bcity"]				: $_REQUEST["bcity"];
$strO_B_STATE1			= $_POST["bstate_1"]			? $_POST["bstate_1"]			: $_REQUEST["bstate_1"];
$strO_B_STATE2			= $_POST["bstate_2"]			? $_POST["bstate_2"]			: $_REQUEST["bstate_2"];
$strO_B_STATE = $strO_B_STATE1;
if ($strO_B_COUNTRY == "US") $strO_B_STATE = $strO_B_STATE2;

$strO_B_ADDR1			= $_POST["baddr1"]				? $_POST["baddr1"]				: $_REQUEST["baddr1"];
$strO_B_ADDR2			= $_POST["baddr2"]				? $_POST["baddr2"]				: $_REQUEST["baddr2"];

$strO_SETTLE			= $_POST["settle"]				? $_POST["settle"]				: $_REQUEST["settle"];
$strO_BANK_NAME			= $_POST["input_bank_name"]		? $_POST["input_bank_name"]		: $_REQUEST["input_bank_name"];
$strO_BANK				= $_POST["input_bank_code"]		? $_POST["input_bank_code"]		: $_REQUEST["input_bank_code"];
$strO_BANK_ACC			= $_POST["settle_bank_code"]	? $_POST["settle_bank_code"]	: $_REQUEST["settle_bank_code"];
$intO_USE_POINT			= $_POST["use_point"]			? $_POST["use_point"]			: $_REQUEST["use_point"];
$strO_USE_COUPON_NUM	= $_POST["use_coupon_num"]		? $_POST["use_coupon_num"]		: $_REQUEST["use_coupon_num"];
$intO_USE_COUPON		= $_POST["use_coupon"]			? $_POST["use_coupon"]			: $_REQUEST["use_coupon"];

/* 포인트 사용 구매 확인*/
$strOrderPayMethod		= $_POST["pay_method"]			? $_POST["pay_method"]		: $_REQUEST["pay_method"];

/* 주문시 배송비 선택할 수 있게 변경(배송비) */
$intDeliveryGroupPriceNo= $_POST["deliveryGroupPrice"]	? $_POST["deliveryGroupPrice"]	: $_REQUEST["deliveryGroupPrice"];


/* 배송국가에 따른 배송방법 나열*/
$strCountryAreaCode		= $_POST["areaCode"]			? $_POST["areaCode"]				: $_REQUEST["areaCode"];
/* 배송국가에 따른 배송방법을 선택한 값이나 DB에는 배송회사명으로 들어감 */
$strDeliveryMethod		= $_POST["deliveryWeightMethod"]? $_POST["deliveryWeightMethod"]	: $_REQUEST["deliveryWeightMethod"];
/* 무통장 입금시 현금영수증신청 */
$strO_CASH_YN			= $_POST["cash_yn_site"]		? $_POST["cash_yn_site"]			: $_REQUEST["cash_yn_site"];
$strCashMth				= $_POST["cashMth"]				? $_POST["cashMth"]					: $_REQUEST["cashMth"];

if ($strO_CASH_YN == "Y"){
	if ($strCashMth	== "1"){
		$strCashInfo1	= $_POST["cash_hp1"]			? $_POST["cash_hp1"]				: $_REQUEST["cash_hp1"];
		$strCashInfo2	= $_POST["cash_hp2"]			? $_POST["cash_hp2"]				: $_REQUEST["cash_hp2"];
		$strCashInfo3	= $_POST["cash_hp3"]			? $_POST["cash_hp3"]				: $_REQUEST["cash_hp3"];
	}

	if ($strCashMth	== "2"){
		$strCashInfo1	= $_POST["cash_no1"]			? $_POST["cash_no1"]				: $_REQUEST["cash_no1"];
		$strCashInfo2	= $_POST["cash_no2"]			? $_POST["cash_no2"]				: $_REQUEST["cash_no2"];
		$strCashInfo3	= $_POST["cash_no3"]			? $_POST["cash_no3"]				: $_REQUEST["cash_no3"];
		$strCashInfo4	= $_POST["cash_no4"]			? $_POST["cash_no4"]				: $_REQUEST["cash_no4"];
	}

	if ($strCashMth	== "3"){
		$strCashInfo1	= $_POST["cash_biz1"]			? $_POST["cash_biz1"]				: $_REQUEST["cash_biz1"];
		$strCashInfo2	= $_POST["cash_biz2"]			? $_POST["cash_biz2"]				: $_REQUEST["cash_biz2"];
		$strCashInfo3	= $_POST["cash_biz3"]			? $_POST["cash_biz3"]				: $_REQUEST["cash_biz3"];
	}

	$strO_CASH_INFO = $strCashInfo1."-".$strCashInfo2."-".$strCashInfo3;
	if ($strCashInfo4) $strO_CASH_INFO .= "-".$strCashInfo4;
}

/* 주문자가 선택한 쿠폰 발행 번호 (쿠폰 체크시 필요)*/
$aryCouponUseIssueNo = $_POST["couponUseIssueNo"]		? $_POST["couponUseIssueNo"]		: $_REQUEST["couponUseIssueNo"];

/* 쿠폰 정보 */
$strCouponCode		= $_POST["coupon_code"]			? $_POST["coupon_code"]			: $_REQUEST["coupon_code"];
$intCouponIssueNo	= $_POST["couponIssueNo"]		? $_POST["couponIssueNo"]		: $_REQUEST["couponIssueNo"];

/* 첫구매사은품 */
$aryFirstGiftNo		= $_POST["prodFirstGiftNo"]		? $_POST["prodFirstGiftNo"]		: $_REQUEST["prodFirstGiftNo"];
$aryFirstGiftOpt1	= $_POST["prodFirstGiftOpt1"]	? $_POST["prodFirstGiftOpt1"]	: $_REQUEST["prodFirstGiftOpt1"];
$aryFirstGiftOpt2	= $_POST["prodFirstGiftOpt2"]	? $_POST["prodFirstGiftOpt2"]	: $_REQUEST["prodFirstGiftOpt2"];

/* 구매금액에 따른 고객사은품 */
$aryGiftNo		= $_POST["prodGiftNo"]		? $_POST["prodGiftNo"]		: $_REQUEST["prodGiftNo"];
$aryGiftOpt1	= $_POST["prodGiftOpt1"]	? $_POST["prodGiftOpt1"]	: $_REQUEST["prodGiftOpt1"];
$aryGiftOpt2	= $_POST["prodGiftOpt2"]	? $_POST["prodGiftOpt2"]	: $_REQUEST["prodGiftOpt2"];

/* 회원 주소록 */
$strBasicAddr	= $_POST["basicAddr"]		? $_POST["basicAddr"]		: $_REQUEST["basicAddr"];

/* 비회원 주문정보 로그인 */
$strSearchOrderKey		= $_POST["searchOrderKey"]		? $_POST["searchOrderKey"]		: $_REQUEST["searchOrderKey"];
$strSearchOrderName		= $_POST["searchOrderName"]		? $_POST["searchOrderName"]		: $_REQUEST["searchOrderName"];

/* 통관개인정보 */
$strO_J_SHIPPING_NO_TYPE= $_POST["j_shipping_local"]	? $_POST["j_shipping_local"]	: $_REQUEST["j_shipping_local"];
$strO_J_SHIPPING_NO2	= $_POST["j_shipping_no2"]		? $_POST["j_shipping_no2"]		: $_REQUEST["j_shipping_no2"];
$strO_J_SHIPPING_NO1_1	= $_POST["j_shipping_no1_1"]	? $_POST["j_shipping_no1_1"]	: $_REQUEST["j_shipping_no1_1"];
$strO_J_SHIPPING_NO1_2	= $_POST["j_shipping_no1_2"]	? $_POST["j_shipping_no1_2"]	: $_REQUEST["j_shipping_no1_2"];

if ($strO_J_SHIPPING_NO_TYPE){
	if ($strO_J_SHIPPING_NO_TYPE == "1") $strOrderShippingNo = $strO_J_SHIPPING_NO1_1.$strO_J_SHIPPING_NO1_2;
	if ($strO_J_SHIPPING_NO_TYPE == "2") $strOrderShippingNo = $strO_J_SHIPPING_NO2;
}

if (!$intO_USE_POINT) $intO_USE_POINT	= 0;
if (!$intO_USE_COUPON) $intO_USE_COUPON	= 0;

if (!$g_member_no) $orderMgr->setM_NO(0);
else $orderMgr->setM_NO($g_member_no);

$orderMgr->setO_J_NAME($strO_J_NAME);
$orderMgr->setO_J_PHONE($strO_J_PHONE);
$orderMgr->setO_J_HP($strO_J_HP);
$orderMgr->setO_J_MAIL($strO_J_MAIL);
$orderMgr->setO_B_NAME($strO_B_NAME);
$orderMgr->setO_B_PHONE($strO_B_PHONE);
$orderMgr->setO_B_HP($strO_B_HP);
$orderMgr->setO_B_MAIL($strO_B_MAIL);
$orderMgr->setO_B_COUNTRY($strO_B_COUNTRY);
$orderMgr->setO_B_CITY($strO_B_CITY);
$orderMgr->setO_B_STATE($strO_B_STATE);
$orderMgr->setO_B_ZIP($strO_B_ZIP);
$orderMgr->setO_B_ADDR1($strO_B_ADDR1);
$orderMgr->setO_B_ADDR2($strO_B_ADDR2);
$orderMgr->setO_B_MEMO($strO_B_MEMO);
$orderMgr->setO_SETTLE($strO_SETTLE);
$orderMgr->setO_BANK_NAME($strO_BANK_NAME);
$orderMgr->setO_BANK($strO_BANK);
$orderMgr->setO_BANK_ACC($strO_BANK_ACC);
$orderMgr->setO_USE_POINT($intO_USE_POINT);
$orderMgr->setO_USE_COUPON_NUM($strO_USE_COUPON_NUM);
$orderMgr->setO_USE_COUPON($intO_USE_COUPON);
$orderMgr->setO_DELIVERY_COM($strDeliveryMethod);
$orderMgr->setO_CASH_YN($strO_CASH_YN);
$orderMgr->setO_CASH_AUTH_NO("");
$orderMgr->setO_CASH_INFO($strO_CASH_INFO);

if (!$strDevice) $strDevice = "w";
if ($strDevice == "mobile") $strDevice = "m";
$orderMgr->setO_PATH($strDevice);

/* PG (한국/포인트/무통장입금이 아닐때)*/
if ($S_SITE_LNG == "KR" && $strO_SETTLE != "B" && $strO_SETTLE != "P") $orderMgr->setO_PG($S_PG);
else if ($S_SITE_LNG != "KR" && $strO_SETTLE != "B" && $strO_SETTLE != "P") $orderMgr->setO_PG($strO_SETTLE);


/* 무통장 입금시 입금은행 */
$arySiteSettleBank		= explode("/",$S_BANK);
$arySiteForSettleBank	= explode("/",$S_FOR_BANK);

/* 여기에 추가되어야 함(메일관련) */
require_once $S_DOCUMENT_ROOT.$S_SHOP_HOME."/layout/mail/_config.inc.php";
require_once $S_DOCUMENT_ROOT."www/config/mail.func.php";
/* 여기에 추가되어야 함(메일관련) */

/* 여기에 추가되어야 함(문자관련) 2013.04.18 */
// 2015.01.15 kim hee sung sms v2.0 에서는 사용을 안합니다.
//	$smsConfFile = "{$S_DOCUMENT_ROOT}{$S_SHOP_HOME}/conf/smsInfo.conf.inc.php";
//	if(is_file($smsConfFile)):
//		require_once $smsConfFile;
//		require_once "{$S_DOCUMENT_ROOT}www/classes/sms/sms.func.class.php";
//		$smsFunc = new SmsFunc();
//	endif;
/* 여기에 추가되어야 함(문자관련) 2013.04.18 */


$productMgr->setP_LNG($S_SITE_LNG);


switch ($strAct){
	case "cartQty":
		// 장바구니 상품개수 변경

		## 상품개수 변경할 장바구니에 등록된 내용 불러오기
		$productMgr->setPB_ALL_NO($intPB_NO);
		$productMgr->setPB_ALL_SORT("Y");
		$aryProdBasketList = $productMgr->getProdBasketList($db);

		if (is_array($aryProdBasketList)){

			/* 품절 체크 */
			if ($aryProdBasketList[0][P_STOCK_OUT] == "Y"){

				$result[0][MSG] = $LNG_TRANS_CHAR["PS00007"]; //"이미 품절된 상품입니다.";
				$result[0][RET] = "N";

				$result_array = json_encode($result);
				$db->disConnect();
				echo $result_array;
				exit;
			}


			/* 수량 확인*/
			if ($intQty	<= 0){
				$result[0][MSG] = $LNG_TRANS_CHAR["PS00008"]; //"상품수량이 존재하지 않습니다.";
				$result[0][RET] = "N";

				$result_array = json_encode($result);
				$db->disConnect();
				echo $result_array;
				exit;
			}

			$productMgr->setP_CODE($aryProdBasketList[0][P_CODE]);
			$productMgr->setPOA_NO($aryProdBasketList[0][PB_OPT_NO]);
			$aryProdOptAttr = $productMgr->getProdOptAttr($db);

			/* 수량 체크(무제한상품이 아닐경우) */
			if ($aryProdBasketList[0][P_STOCK_LIMIT] == "N"){

				if (is_array($aryProdOptAttr)) $intProdQty = $aryProdOptAttr[0][POA_STOCK_QTY];
				else $intProdQty = $aryProdBasketList[0][P_QTY];

				if ($aryProdBasketList[0][P_QTY] > 0 && $intProdQty < $intQty){

					$result[0][MSG] = $LNG_TRANS_CHAR["PS00010"]; //"선택하신 옵션 상품 수량이 존재하지 않습니다.";
					$result[0][RET] = "N";

					$result_array = json_encode($result);
					$db->disConnect();
					echo $result_array;
					exit;
				}
			}

			if ($aryProdBasketList[0]["P_MIN_QTY"] > $intQty){
				$result[0][MSG] = callLangTrans($LNG_TRANS_CHAR["PS00020"],array($aryProdBasketList[0]["P_MIN_QTY"])); //"선택하신 상품 수량은 최소 {{단어1}} 이상 입력하셔야 합니다.";
				$result[0][RET] = "N";

				$result_array = json_encode($result);
				$db->disConnect();
				echo $result_array;
				exit;
			}

			// 2013.08.30 kim hee sung , 0 은 무한 입니다.
			// 애엽 사이트> 장바구니 페이지에서 수량 수정시 오류 발생.
			if ($aryProdBasketList[0]["P_MAX_QTY"] > 0 && $aryProdBasketList[0]["P_MAX_QTY"] < $intQty){
				$result[0][MSG] = callLangTrans($LNG_TRANS_CHAR["PS00021"],array($aryProdBasketList[0]["P_MAX_QTY"])); //"선택하신 상품 수량은 {{단어1}} 이상 구매하실 수 없습니다.";
				$result[0][RET] = "N";

				$result_array = json_encode($result);
				$db->disConnect();
				echo $result_array;
				exit;
			}

			$productMgr->setPB_NO($intPB_NO);
			$productMgr->setPB_QTY($intQty);
			$productMgr->getProdBasketQtyUpdate($db);

			$result[0][MSG] = $LNG_TRANS_CHAR["OS00067"];//"선택하신 상품의 수량이 변경되었습니다.";
			$result[0][RET] = "Y";

			if ($_REQUEST['type'] == "popCart"){
				/* 상품 장바구니 팝업 사용 */
				$productMgr->setPB_ALL_NO("");
				include WEB_FRWORK_JSON."/product.basket.popup.php";
				/* 상품 장바구니 팝업 사용 */
				$result[0]['POP_HTML']	= $strCartPopHtml;

				if ($S_FIX_ORDER_TOTAL_DISCOUNT_USE == "Y")
				{
					$result[0]['ORDER_TOTAL_DISCOUNT_HTML']	= $strOrderTotalDiscountHtml;
				}
			}

		} else {

			$result[0][MSG] = $LNG_TRANS_CHAR["OS00001"]; //"변경하실 장바구니 번호가 존재하지 않습니다.";
			$result[0][RET] = "N";
		}


		$result_array = json_encode($result);
		break;


	case "wishQty":

		$productMgr->setPW_ALL_NO($intPW_NO);
		$productMgr->setPW_ALL_SORT("Y");
		$aryProdWishList = $productMgr->getProdWishList($db);

		if (is_array($aryProdWishList)){

			/* 품절 체크 */
			if ($aryProdWishList[0][P_STOCK_OUT] == "Y"){

				$result[0][MSG] = $LNG_TRANS_CHAR["PS00007"]; //"이미 품절된 상품입니다.";
				$result[0][RET] = "N";

				$result_array = json_encode($result);
				$db->disConnect();
				echo $result_array;
				exit;
			}

			/* 수량 확인*/
			if ($intQty	<= 0){
				$result[0][MSG] = $LNG_TRANS_CHAR["PS00008"]; //"상품수량이 존재하지 않습니다.";
				$result[0][RET] = "N";

				$result_array = json_encode($result);
				$db->disConnect();
				echo $result_array;
				exit;
			}
			$productMgr->setP_CODE($aryProdWishList[0][P_CODE]);
			$productMgr->setPOA_NO($aryProdWishList[0][PW_OPT_NO]);
			$aryProdOptAttr = $productMgr->getProdOptAttr($db);

			/* 수량 체크(무제한상품이 아닐경우) */
			if ($aryProdWishList[0][P_STOCK_LIMIT] == "N"){

				if (is_array($aryProdOptAttr)) $intProdQty = $aryProdOptAttr[0][POA_STOCK_QTY];
				else $intProdQty = $aryProdWishList[0][P_QTY];

				if ($aryProdWishList[0][P_QTY] > 0 && $intProdQty < $intQty){

					$result[0][MSG] = $LNG_TRANS_CHAR["PS00008"]; //"상품수량이 존재하지 않습니다.";
					$result[0][RET] = "N";

					$result_array = json_encode($result);
					$db->disConnect();
					echo $result_array;
					exit;
				}
			}

			//wish 최소 수량 체크 남덕희
			if ($aryProdWishList[0]["P_MIN_QTY"] > $intQty){
				$result[0][MSG] = callLangTrans($LNG_TRANS_CHAR["PS00020"],array($aryProdWishList[0]["P_MIN_QTY"])); //"선택하신 상품 수량은 최소 {{단어1}} 이상 입력하셔야 합니다.";
				$result[0][RET] = "N";

				$result_array = json_encode($result);
				$db->disConnect();
				echo $result_array;
				exit;
			}

			//wish 최대 수량 체크 남덕희
			if ($aryProdWishList[0]["P_MAX_QTY"] > 0 && $aryProdWishList[0]["P_MAX_QTY"] < $intQty){
				$result[0][MSG] = callLangTrans($LNG_TRANS_CHAR["PS00021"],array($aryProdWishList[0]["P_MAX_QTY"])); //"선택하신 상품 수량은 {{단어1}} 이상 구매하실 수 없습니다.";
				$result[0][RET] = "N";

				$result_array = json_encode($result);
				$db->disConnect();
				echo $result_array;
				exit;
			}


			$productMgr->setPW_NO($intPW_NO);
			$productMgr->setPW_QTY($intQty);
			$productMgr->getProdWishQtyUpdate($db);

			/* 통합수량할인 update (2013.01.03)*/
//				if ($S_ALL_DISCOUNT_USE == "Y")
//				{
//					$intProdWishSalePrice		= $aryProdWishList[0]['P_SALE_PRICE'];
//					$intProdWishStockPrice		= $aryProdWishList[0]['P_STOCK_PRICE'];
//					$intProdWishPoint			= $aryProdWishList[0]['P_POINT'];
//					if ($aryProdWishList[0]['P_OPT'] != "1"){
//						if (is_array($aryProdOptAttr)) {
//							$intProdWishSalePrice		= $aryProdOptAttr[0]['POA_SALE_PRICE'];
//							$intProdWishStockPrice		= $aryProdOptAttr[0]['POA_STOCK_PRICE'];
//							$intProdWishPoint			= $aryProdOptAttr[0]['POA_POINT'];
//						}
//					}
//
//					$intProdWishPoint			= getProdPoint($intProdWishSalePrice, $intProdWishPoint, $aryProdWishList[0]['P_POINT_TYPE'], $aryProdWishList[0]['P_POINT_OFF1'], $aryProdWishList[0]['P_POINT_OFF2']);
//
//					$intProdWishSalePrice		= getProdAllDiscount($intProdWishSalePrice,$intQty);
//					$productMgr->setPB_PRICE($intProdWishSalePrice);
//					$productMgr->setPB_POINT($intProdWishPoint);
//					$productMgr->setPB_STOCK_PRICE($intProdWishStockPrice);
//					$productMgr->getProdWishPriceUpdate($db);
//				}


			$result[0][MSG] = $LNG_TRANS_CHAR["OS00067"];//"선택하신 상품의 수량이 변경되었습니다.";
			$result[0][RET] = "Y";

		} else {

			$result[0][MSG] = $LNG_TRANS_CHAR["OS00068"]; //"변경하실 위시리스트 번호가 존재하지 않습니다.";
			$result[0][RET] = "N";
		}


		$result_array = json_encode($result);
		break;

	case "order2":

		$result[0][O_KEY]		= "";
		$result[0][NO]			= "";
		$result[0][CART]		= "";
		$result[0][SETTLE]		= "";
		$result[0][TITLE]		= "";
		$result[0][CART_CNT]	= "";

		$aryCartNo				= $_POST["cartNo"]			? $_POST["cartNo"]			: $_REQUEST["cartNo"];
		$strBasketDirect		= $_POST["basketDirect"]	? $_POST["basketDirect"]	: $_REQUEST["basketDirect"];

		if (!$strO_SETTLE){
			$result[0][MSG] = $LNG_TRANS_CHAR["OS00026"]; //"주문 결제수단이 존재하지 않습니다."
			$result[0][RET] = "N";
			$result_array = json_encode($result);
			$db->disConnect();
			echo $result_array;
			exit;
		}

		if (!is_array($aryCartNo)){
			$db->disConnect();
			$result[0][MSG] = $LNG_TRANS_CHAR["OS00024"]; //"주문할 상품이 존재하지 않습니다."
			$result[0][RET] = "N";
			$result_array = json_encode($result);
			echo $result_array;
			exit;
		}

		/* 그룹 배송일때 배송비 구하기 */
		if ($S_SITE_LNG == "KR" && $S_DELIVERY_MTH == "G"){
			if (!$intDeliveryGroupPriceNo){
				$result[0][MSG] = $LNG_TRANS_CHAR["OS00025"]; //"주문하실 배송비를 선택하지 않으셨습니다."
				$result[0][RET] = "N";
				$result_array = json_encode($result);
				$db->disConnect();
				echo $result_array;
				exit;
			}

			$orderMgr->setDA_NO($intDeliveryGroupPriceNo);
			$intDeliveryGroupPrice	= $orderMgr->getOrderDelvieryInfo($db);
			if (!$intDeliveryGroupPrice) $intDeliveryGroupPrice = 0;
		}

		/* 쿠폰 금액을 사용시 쿠폰번호가 있는지 확인 */
		if ($intO_USE_COUPON > 0 && !is_array($aryCouponUseIssueNo)){
			$db->disConnect();
			$result[0][MSG] = $LNG_TRANS_CHAR["OS00051"]; //"쿠폰 번호가 존재하지 않습니다."
			$result[0][RET] = "N";
			$result_array = json_encode($result);
			echo $result_array;
			exit;
		}

		$intOrderTotalPrice		= 0; //주문금액
		$intOrderTotalQty		= 0; //주문수량
		$intOrderTotalPoint		= 0; //적립포인트
		$intOrderDeliveryTotalPrice = 0; //주문금액(그룹배송상품금액제외)

		/* 과세/비과세금액(2013.05.18) */
		$intOrderTaxTotalPrice		= 0;
		$intOrderTaxCnt				= 0;
		$intOrderNoTaxTotalPrice	= 0;
		$intOrderNoTaxCnt			= 0;
		/* 과세/비과세금액(2013.05.18) */

		/* 해외 결제시 배송비를 내는 상품 수*/
		$intForDeliveryPriceProdCnt = 0;

		for($i=1;$i<=5;$i++){
			$aryDeliveryPrice[$i] = 0;
		}

		$aryShopAccList = array(); //정산관련
		$aryOrderBasketList = array(); //할인관련
		if (is_array($aryCartNo)){
			$intOrderCount = 0; //주문상품수
			$strOrderTitle = 0; //주문상품타이틀
			$strAllCartNo  = "";
			$intOrderProdNoPointUseCnt = 0; //포인트사용금지상품수

			$aryCartProdQty		= array();
			for($i=0;$i<sizeof($aryCartNo);$i++){

				if ($aryCartNo[$i] > 0){

					$orderMgr->setPB_NO($aryCartNo[$i]);
					$cartRow = $orderMgr->getOrderBasketView($db);

					if ($cartRow)
					{
						if (!$aryCartProdQty[$cartRow['P_CODE']]) $aryCartProdQty[$cartRow['P_CODE']] =  $cartRow['PB_QTY'];
						else $aryCartProdQty[$cartRow['P_CODE']] = $aryCartProdQty[$cartRow['P_CODE']] + $cartRow['PB_QTY'];
					}
				}
			}

			$cartRow = "";
			for($i=0;$i<sizeof($aryCartNo);$i++){

				$intOrderPrice = 0;

				if ($aryCartNo[$i] > 0){

					$orderMgr->setPB_NO($aryCartNo[$i]);
					$cartRow = $orderMgr->getOrderBasketView($db);

					if (!$cartRow)
					{
						$db->disConnect();
						$result[0][MSG] = $LNG_TRANS_CHAR["OS00024"]; //"주문하실 상품의 정보가 존재하지 않습니다."
						$result[0][RET] = "N";
						$result_array = json_encode($result);
						echo $result_array;
						exit;
					}

					if ($cartRow[P_STOCK_OUT] == "Y"){
						$db->disConnect();
						$result[0][MSG] = callLangTrans($LNG_TRANS_CHAR["OS00028"],array($cartRow[P_NAME])); //"[".$cartRow[P_NAME]."] 상품은 품절된 상품입니다."
						$result[0][RET] = "N";
						$result_array = json_encode($result);
						echo $result_array;
						exit;
					}

					/* 주문수량의 상품의 전체합계에서 최대구매수량 제한 */
					if ($cartRow['P_MAX_QTY'] > 0 && ($aryCartProdQty[$cartRow['P_CODE']] > $cartRow['P_MAX_QTY'])){
						$db->disConnect();
						$result[0][MSG] = callLangTrans($LNG_TRANS_CHAR["PS00021"],array($cartRow["P_MAX_QTY"])); //"선택하신 상품 수량은 {{단어1}} 이상 구매하실 수 없습니다.";
						$result[0][RET] = "N";
						$result_array = json_encode($result);
						echo $result_array;
						exit;
					}

					/* 상품 옵션 확인 */
					if ($cartRow[PB_OPT_NO]){

						$productMgr->setP_CODE($cartRow[P_CODE]);
						$productMgr->setPOA_NO($cartRow[PB_OPT_NO]);
						$aryProdOptAttr = $productMgr->getProdOptAttr($db);

						$intProdOptAttrStock = ($aryProdOptAttr[0][POA_STOCK_QTY])?$aryProdOptAttr[0][POA_STOCK_QTY]:0;

						if ($cartRow[P_STOCK_LIMIT] == "N" || !$cartRow[P_STOCK_LIMIT]){
							if (($cartRow[P_QTY] > 0 && ($intProdOptAttrStock < $cartRow[PB_QTY])) || ($intProdOptAttrStock <= 0)){
								$db->disConnect();
								$result[0][MSG] = callLangTrans($LNG_TRANS_CHAR["OS00029"],array($cartRow[P_NAME],$aryProdOptAttr[0][POA_STOCK_QTY])); //"[".$cartRow[P_NAME]."] 상품의 재고량(".$aryProdOptAttr[0][POA_STOCK_QTY]."개)보다 주문수량이 많습니다."
								$result[0][RET] = "N";
								$result_array = json_encode($result);
								echo $result_array;
								exit;
							}
						}

						if (!$aryProdOptAttr[0][POA_SALE_PRICE]){
							$db->disConnect();
							$result[0][MSG] = callLangTrans($LNG_TRANS_CHAR["OS00030"],array($cartRow[P_NAME])); //"[".$cartRow[P_NAME]."] 상품은 가격미정 상품입니다."
							$result[0][RET] = "N";
							$result_array = json_encode($result);
							echo $result_array;
							exit;
						}

						/* 이벤트 할인가 적용 (2012.09.13) */
						if ($cartRow[P_EVENT_UNIT] && $cartRow[P_EVENT]){
							//$cartRow[PB_PRICE] = getProdEventPrice($cartRow[PB_PRICE],$cartRow[P_EVENT_UNIT],$cartRow[P_EVENT]);
						}

						/* 다중가격을 사용하지 않을때 */
						if ($cartRow[P_OPT] == "1"){
							$aryProdOptAttr[0][POA_SALE_PRICE] = $cartRow[P_SALE_PRICE];
						}
						$intCartSalePrice		= getProdDiscountPrice($cartRow,"3",$aryProdOptAttr[0][POA_SALE_PRICE]);

						/* 통합수량할인적용(2014.01.03) */
						if ($S_ALL_DISCOUNT_USE == "Y"){
							$intCartSalePrice	= getProdAllDiscount($intCartSalePrice,$cartRow[PB_QTY]);
						}

						$intProdPoint		= ($aryProdOptAttr[0]['POA_POINT']) ? $aryProdOptAttr[0]['POA_POINT'] : $cartRow[P_POINT];
						$intCartPoint		= getProdPoint($intCartSalePrice, $intProdPoint, $cartRow['P_POINT_TYPE'], $cartRow['P_POINT_OFF1'], $cartRow['P_POINT_OFF2']);
						$intCartStockPrice	= ($cartRow[P_OPT] == "1") ? $cartRow[P_STOCK_PRICE] : $aryProdOptAttr[0][POA_STOCK_PRICE];

						/* 상품 포인트를 특정 그룹에만 부여한다.(2013.08.22 : 애협) */
						if (is_array($S_FIX_PROD_POINT_VIEW_SPEC_GROUP_LIST)){
							if (!$g_member_login || !in_array($g_member_group,$S_FIX_PROD_POINT_VIEW_SPEC_GROUP_LIST)){
								$intCartPoint= 0;
							}
						}

						## 이벤트 상품시 적립포인트 지급 여부 확인
						$strCartProdEventYN = "N";
						$strCartProdEventYN = getProdEventInfo($cartRow);
						if ($strCartProdEventYN == "Y" && $S_EVENT_INFO[$cartRow['P_EVENT']]['GIVE_POINT'] == "N"){
							$intCartPoint = 0;
						}

						$intOrderPoint		= ($intCartPoint * $cartRow[PB_QTY]);
						$intOrderPrice      = ($intCartSalePrice * $cartRow[PB_QTY]); //할인가격 확인
						$intOrderStockPrice = ($intCartStockPrice * $cartRow[PB_QTY]); //입고가격

						$intOrderTotalPrice = $intOrderTotalPrice + ($intOrderPrice);
						$intOrderTotalQty	= $intOrderTotalQty + $cartRow[PB_QTY];
						$intOrderTotalPoint = $intOrderTotalPoint + $intOrderPoint;

						## 현재통화상품주문금액
						if ($S_ARY_CUR[$S_SITE_LNG]["USD"][2] == "Y") $intOrderPriceCur		= (getCurToPriceSave($intCartSalePrice,"US") * $cartRow[PB_QTY]);
						else $intOrderPriceCur		= (getCurToPriceSave($intCartSalePrice) * $cartRow[PB_QTY]); //현재통화상품주문금액
						$intOrderTotalPriceCur	= $intOrderTotalPriceCur	+ $intOrderPriceCur; //현재통화

						//배송비 그룹 배송이고 무료 배송이 아니면
						if ($S_SITE_LNG == "KR" && $S_DELIVERY_MTH == "G" && $cartRow[P_BAESONG_TYPE] != "2"){
							$intOrderDeliveryTotalPrice = $intOrderDeliveryTotalPrice + $intOrderPrice;
						}


					} else {
						/* 수량 체크 */
						if ($cartRow[P_STOCK_LIMIT] == "N" || !$cartRow[P_STOCK_LIMIT]){
							if (($cartRow[P_QTY] > 0 && $cartRow[P_QTY] < $cartRow[PB_QTY]) || ($cartRow['P_QTY'] <= 0)){
								$db->disConnect();
								$result[0][MSG] = $LNG_TRANS_CHAR["PS00010"]; //"선택하신 옵션 상품 수량이 존재하지 않습니다."
								$result[0][RET] = "N";
								$result_array = json_encode($result);
								echo $result_array;
								exit;
							}
						}

						/* 가격 체크 */
						if ($cartRow[P_SALE_PRICE] == 0){
							$db->disConnect();
							$result[0][MSG] = $LNG_TRANS_CHAR["PS00011"]; //"선택하신 옵션 상품은 가격 미정인 상품입니다."
							$result[0][RET] = "N";
							$result_array = json_encode($result);
							echo $result_array;
							exit;
						}

						/* 이벤트 할인가 적용 (2012.09.13) */
						if ($cartRow[P_EVENT_UNIT] && $cartRow[P_EVENT]){
							//$cartRow[P_SALE_PRICE] = getProdEventPrice($cartRow[P_SALE_PRICE],$cartRow[P_EVENT_UNIT],$cartRow[P_EVENT]);
						}

						$intCartSalePrice	= getProdDiscountPrice($cartRow,"3",$cartRow['P_SALE_PRICE']);
						/* 통합수량할인적용(2014.01.03) */
						if ($S_ALL_DISCOUNT_USE == "Y"){
							$intCartSalePrice	= getProdAllDiscount($intCartSalePrice,$cartRow[PB_QTY]);
						}

						/* 경매 상품 여부 확인 */
						if ($S_PRODUCT_AUCTION_USE == "Y"){
							$auctionParam				= "";
							$auctionParam['P_CODE']		= $cartRow[P_CODE];
							$prodAucRow					= $productMgr->getProdAuctionView($db,$auctionParam);

							if ((in_array($prodAucRow['P_AUC_STATUS'],array("2","4","5"))) && $prodAucRow['P_AUC_ORDER'] != "Y"){
								$intCartSalePrice		= $cartRow['PB_PRICE'];
							}

							if ($prodAucRow['P_AUC_ORDER'] == "Y"){
								$db->disConnect();
								$result[0][MSG] = $LNG_TRANS_CHAR["PS00033"]; //"해당 상품에 대한 경매가 종료되었거나 완료되었습니다."
								$result[0][RET] = "N";
								$result_array = json_encode($result);
								echo $result_array;
								exit;
							}
						}

						$intCartPoint		= getProdPoint($intCartSalePrice, $cartRow['P_POINT'], $cartRow['P_POINT_TYPE'], $cartRow['P_POINT_OFF1'], $cartRow['P_POINT_OFF2']);
						$intCartStockPrice	= $cartRow[P_STOCK_PRICE];

						/* 상품 포인트를 특정 그룹에만 부여한다.(2013.08.22 : 애협) */
						if (is_array($S_FIX_PROD_POINT_VIEW_SPEC_GROUP_LIST)){
							if (!$g_member_login || !in_array($g_member_group,$S_FIX_PROD_POINT_VIEW_SPEC_GROUP_LIST)){
								$intCartPoint= 0;
							}
						}

						## 이벤트 상품시 적립포인트 지급 여부 확인
						$strCartProdEventYN = "N";
						$strCartProdEventYN = getProdEventInfo($cartRow);
						if ($strCartProdEventYN == "Y" && $S_EVENT_INFO[$cartRow['P_EVENT']]['GIVE_POINT'] == "N"){
							$intCartPoint = 0;
						}

						$intOrderPoint		= ($intCartPoint * $cartRow[PB_QTY]);
						$intOrderPrice      = ($intCartSalePrice * $cartRow[PB_QTY]);
						$intOrderStockPrice = ($intCartStockPrice * $cartRow[PB_QTY]); //입고가격

						$intOrderTotalPrice = $intOrderTotalPrice + ($intOrderPrice);
						$intOrderTotalQty	= $intOrderTotalQty + $cartRow[PB_QTY];
						$intOrderTotalPoint = $intOrderTotalPoint + $intOrderPoint;

						if ($S_ARY_CUR[$S_SITE_LNG]["USD"][2] == "Y") $intOrderPriceCur		= (getCurToPriceSave($intCartSalePrice,"US") * $cartRow[PB_QTY]); //현재통화상품주문금액
						else $intOrderPriceCur		= (getCurToPriceSave($intCartSalePrice) * $cartRow[PB_QTY]); //현재통화상품주문금액
						$intOrderTotalPriceCur	= $intOrderTotalPriceCur	+ $intOrderPriceCur; //현재통화

						if ($S_SITE_LNG == "KR" && $S_DELIVERY_MTH == "G" && $cartRow[P_BAESONG_TYPE] != "2"){
							$intOrderDeliveryTotalPrice = $intOrderDeliveryTotalPrice + ($intCartSalePrice * $cartRow[PB_QTY]);
						}
					}

					/* 할인가격 담기 */
					$aryOrderBasketList[$cartRow['PB_NO']]['PRICE']			= $intCartSalePrice;
					$aryOrderBasketList[$cartRow['PB_NO']]['POINT']			= $intCartPoint;
					$aryOrderBasketList[$cartRow['PB_NO']]['STOCK_PRICE']	= $intCartStockPrice;
					/* 할인가격 담기 */

					/* 해외배송 : 수량별배송을 사용할 경우 맨처음 주문 상품의 배송비에 기본배송비를 더하기 위해 CART_COUNT를 배열 삽입 */
					if ($S_SITE_LNG != "KR"){
						if ($S_DELIVERY_FOR_MTH == "B"){
							if ($cartRow['P_BAESONG_TYPE'] == "4"){
								$cartRow['CART_COUNT'] = $i + 1;
							}
						}
					}

					/* 배송비설정*/
					$intDeliveryPrice = getProdDeliveryPrice($cartRow,$SHOP_ARY_DELIVERY,$intOrderPrice,$cartRow[PB_QTY]);
					if($S_SITE_LNG == "KR"){
						/* 고정배송비일경우 옵션/수량/금액에 상관없이 무조건 고정배송비 */
						if ($cartRow['P_BAESONG_TYPE'] == "3"){
							if (is_array($aryDeliveryFixProduct)) {
								if (!in_array($cartRow[P_CODE],$aryDeliveryFixProduct)) {
									$aryDeliveryFixProduct = array_push($aryDeliveryFixProduct, $cartRow[P_CODE]);
								} else {
									$intDeliveryPrice = 0;
								}
							} else $aryDeliveryFixProduct = array($cartRow[P_CODE]);
						}
					}

					$aryDeliveryPrice[$cartRow[P_BAESONG_TYPE]] += $intDeliveryPrice;

					/* 주문 장바구니 변경 데이터 */
					$aryOrderBasketList[$cartRow['PB_NO']]['P_NAME']		  = $cartRow[P_NAME];
					$aryOrderBasketList[$cartRow['PB_NO']]['P_BAESONG_TYPE']  = $cartRow[P_BAESONG_TYPE];
					$aryOrderBasketList[$cartRow['PB_NO']]['P_BAESONG_PRICE'] = $intDeliveryPrice;

					/* 배송비 (무게) 설정 */
					$intProdWeight = ($cartRow[P_WEIGHT]) ? $cartRow[P_WEIGHT] : "0";
					$intOrderProdWeight += ($intProdWeight * $cartRow[PB_QTY]);
					/* 배송비 (무게) 설정 */

					/* 상품 추가옵션 확인*/
					$productMgr->setP_CODE($cartRow[P_CODE]);
					$productMgr->setPB_NO($cartRow[PB_NO]);
					$aryProdAddAttrOpt = $productMgr->getProdBasketAddList($db);

					if (is_array($aryProdAddAttrOpt)){
						for($j=0;$j<sizeof($aryProdAddAttrOpt);$j++){

							if ($aryProdAddAttrOpt[$j][PBA_NO] > 0)
							{
								$productMgr->setP_CODE($cartRow[P_CODE]);
								$productMgr->setPAO_NO($aryProdAddAttrOpt[$j][PBA_OPT_NO]);
								$aryProdAddOptAttr = $productMgr->getProdAddOpt($db);

								$intOrderTotalPrice		= $intOrderTotalPrice + ($aryProdAddOptAttr[0][PAO_PRICE] * $aryProdAddAttrOpt[$j][PBA_OPT_QTY]);

								if ($S_ARY_CUR[$S_SITE_LNG]["USD"][2] == "Y") {
									$intOrderTotalPriceCur	= $intOrderTotalPriceCur + (getCurToPriceSave($aryProdAddOptAttr[0][PAO_PRICE],"US") * $aryProdAddAttrOpt[$j][PBA_OPT_QTY]); //현지통화
								} else {
									$intOrderTotalPriceCur	= $intOrderTotalPriceCur + (getCurToPriceSave($aryProdAddOptAttr[0][PAO_PRICE]) * $aryProdAddAttrOpt[$j][PBA_OPT_QTY]); //현지통화
								}

								/* 추가옵션도 재고 관리가 되어야 함 */
							}
						}
					}

					/* 입점몰일 경우 입점몰 총 가격 및 입고가격 확인 */
					if ($S_MALL_TYPE != "R"){
						if ($cartRow[P_SHOP_NO] >= 0){
							$aryShopAccList[$cartRow[P_SHOP_NO]]["STOCK_PRICE"] += $intOrderStockPrice;
							$aryShopAccList[$cartRow[P_SHOP_NO]]["SALE_PRICE"]	+= $intOrderPrice;
							$aryShopAccList[$cartRow[P_SHOP_NO]]["SALE_QTY"]	+= $cartRow[PB_QTY];
						}
					}

					$strAllCartNo .= $aryCartNo[$i].",";
					$intOrderCount++;
					if ($i == 0){
						$strOrderTitle = $cartRow[P_NAME];
					}

					/* 포인트 사용불가 상품 */
					if ($cartRow[P_POINT_NO_USE] == "Y") {
						$intOrderProdNoPointUseCnt++;
					}

					/* 상품 과세/부과세 확인(2013.05.21)*/
					if ($cartRow['P_TAX'] == "Y"){
						$intOrderTaxTotalPrice		+= $intOrderPrice;
						$intOrderTaxCnt++;
					}else {
						$intOrderNoTaxTotalPrice	+= $intOrderPrice;
						$intOrderNoTaxCnt++;
					}
					/* 상품 과세/부과세 확인(2013.05.21)*/

					/* 해외 결제시 배송비를 내는 경우와 안내는 경부 분리 */
					if ($S_SITE_LNG != "KR"){
						/* 프리스타일 사용 */
						if (is_array($S_FIX_ORDER_DELIVERY_PROD_CATE)){
							if (in_array(substr($cartRow['P_CATE'],0,3),$S_FIX_ORDER_DELIVERY_PROD_CATE)){
								$intForDeliveryPriceProdCnt++;
							}
						}
					}
				}
			}
		}

		if ($S_SITE_LNG != "KR"){
			/* 프리스타일 사용 */
			if (!is_array($S_FIX_ORDER_DELIVERY_PROD_CATE)){
				$intForDeliveryPriceProdCnt = $intOrderCount;
			}
		}


		if ($strAllCartNo) {
			$strAllCartNo = SUBSTR($strAllCartNo,0,STRLEN($strAllCartNo)-1);
		}


		/* 총주문의 상품가격합의 DISCOUNT 설정(bejewel)*/
		if ($S_FIX_ORDER_TOTAL_DISCOUNT_USE == "Y"){
			$discountParam						= "";
			$discountParam['PROD_TOTAL_PRICE']	= $intOrderTotalPrice;
			$intOrderPriceDiscountRate			= $productMgr->getProdTotalPriceMaxDiscountRate($db,$discountParam);
			$intOrderPriceDiscountPrice			= getProdTotalPriceAllDiscount($intOrderTotalPrice,$intOrderPriceDiscountRate);

			if ($intOrderPriceDiscountPrice > 0){
				$intOrderTotalPrice				= $intOrderTotalPrice		- $intOrderPriceDiscountPrice;
				$intOrderTotalPriceCur			= $intOrderTotalPriceCur	- getCurToPriceSave($intOrderPriceDiscountPrice);
			}
		}

		/* 사용포인트 확인 */
		if ($g_member_no && $S_POINT_USE1 == "Y"){
			$memberMgr->setM_NO($g_member_no);
			$memberRow = $memberMgr->getMemberView($db);
			if (!$memberRow){

				$db->disConnect();
				$result[0][MSG] = $LNG_TRANS_CHAR["OS00031"]; //"회원정보가 존재하지 않습니다."
				$result[0][RET] = "N";
				$result_array = json_encode($result);
				echo $result_array;
				exit;
			}

			if ($intO_USE_POINT > 0){

				$intOrderUseMinPoint = ($S_ARY_CUR[$S_SITE_LNG]["USD"][2] == "Y") ? getCurToPriceSave($S_POINT_MIN,"US") : getCurToPriceSave($S_POINT_MIN);
				if ($S_POINT_MIN >= $memberRow[M_POINT]){
					$db->disConnect();
					$result[0][MSG] = callLangTrans($LNG_TRANS_CHAR["OS00032"],array(getFormatPrice($intOrderUseMinPoint,2))); //"사용가능한 포인트는 ".NUMBER_FORMAT($S_POINT_MIN)."이상입니다."
					$result[0][RET] = "N";
					$result_array = json_encode($result);
					echo $result_array;
					exit;
				}

				$intOrderUseMaxPoint = ($S_ARY_CUR[$S_SITE_LNG]["USD"][2] == "Y") ? getCurToPriceSave($S_POINT_MAX,"US") : getCurToPriceSave($S_POINT_MAX);
				if ($intO_USE_POINT > $intOrderUseMaxPoint){
					$db->disConnect();
					$result[0][MSG] = callLangTrans($LNG_TRANS_CHAR["OS00033"],array(getFormatPrice($intOrderUseMaxPoint,2))); //"사용가능한 포인트는 ".NUMBER_FORMAT($S_POINT_MAX)."미만입니다."
					$result[0][RET] = "N";
					$result_array = json_encode($result);
					echo $result_array;
					exit;
				}

				$intMemberUsePoint = ($S_ARY_CUR[$S_SITE_LNG]["USD"][2] == "Y") ? getCurToPriceSave($memberRow[M_POINT],"US") : getCurToPriceSave($memberRow[M_POINT]);
				if ($intMemberUsePoint < $intO_USE_POINT){
					$db->disConnect();
					$result[0][MSG] = $LNG_TRANS_CHAR["OS00034"]; //"입력하신 사용포인트가 보유하신 포인트보다 많습니다."
					$result[0][RET] = "N";
					$result_array = json_encode($result);
					echo $result_array;
					exit;
				}
			}

			if ($intMemberUsePoint - $intO_USE_POINT < 0){
				$intO_USE_POINT = getCurToPriceSave($memberRow[M_POINT]);
			}

			$orderMgr->setO_USE_POINT($intO_USE_POINT);

			if ($S_ARY_CUR[$S_SITE_LNG]["USD"][2] == "Y") $orderMgr->setO_USE_CUR_POINT(getPriceToCur($intO_USE_POINT,"USD")); //현지통화->기준통화
			else $orderMgr->setO_USE_CUR_POINT(getPriceToCur($intO_USE_POINT)); //현지통화->기준통화
		}

		/* 주문금액 확인 */
		if ($intOrderTotalPrice == 0){
			$db->disConnect();
			$result[0][MSG] = $LNG_TRANS_CHAR["OS00024"]; //"주문할 상품이 없습니다."
			$result[0][RET] = "N";
			$result_array = json_encode($result);
			echo $result_array;
			exit;
		}

		## 2015.02.11 kim hee sung
		## 최소결제금액 체크
		if($g_member_group && $S_SITE_LNG == 'KR'):
			$intMinBuyPrice = $S_MEMBER_GROUP[$g_member_group]["G_MIN_BUY_PRICE"];
			$intMinBuyPrice = (int)$intMinBuyPrice;
			if($intMinBuyPrice && $intMinBuyPrice > $intOrderTotalPrice):
				$db->disConnect();
				$result[0][MSG] = $g_member_group_name . ' 그룹 회원 님은 ' . number_format($intMinBuyPrice) . "원 이상 구매가능합니다.";
				$result[0][RET] = "N";
				$result_array = json_encode($result);
				echo $result_array;
				exit;
			endif;
		endif;

		/* 주문명 구하기*/
		$orderMgr->setO_TOT_QTY($intOrderCount);
		if($intOrderCount > 1){
			$intOrderCount--;
			$strOrderTitle     = callLangTrans($LNG_TRANS_CHAR["OS00035"],array($strOrderTitle,$intOrderCount)); //$strOrderTitle."외 ".$intOrderCount."종"
		}
		$orderMgr->setO_J_TITLE($strOrderTitle);


		/* 배송비 구하기 (프로그램 다시 적용)*/
		$intOrderTotalDeliveryPrice = 0;
//			$intOrderTotalDeliveryPrice = getCartDeliveryPrice($aryDeliveryPrice,$intOrderTotalPrice,$SHOP_ARY_DELIVERY);

		if ($S_MALL_TYPE == "R") {
			$intOrderTotalDeliveryPrice = getCartDeliveryPrice($aryDeliveryPrice,$intOrderTotalPrice,$SHOP_ARY_DELIVERY);
			if ($S_SITE_LNG == "KR" && $S_DELIVERY_MTH == "G"){
				$intOrderTotalDeliveryPrice = $intOrderTotalDeliveryPrice + $intDeliveryGroupPrice;
			}
		} else {

			/* 입점몰 프랜차이즈 일때 (KR) */
			if ($S_SITE_LNG == "KR"){
				$productMgr->setPB_ALL_NO($strAllCartNo);
				$productMgr->setPB_DIRECT($strBasketDirect);

				$aryProdBasketShopList = $productMgr->getProdBasketShopList($db);
				$intOrderTotalDeliveryPrice = 0;

				$aryDeliveryFixProduct = ""; //고정배송비상품리스트
				if (is_array($aryProdBasketShopList)){
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

							/* 고정배송비일경우 옵션/수량/금액에 상관없이 무조건 고정배송비 */
							if ($prodBasketRow['P_BAESONG_TYPE'] == "3"){
								if (is_array($aryDeliveryFixProduct)) {
									if (!in_array($prodBasketRow[P_CODE],$aryDeliveryFixProduct)) {
										$aryDeliveryFixProduct = array_push($aryDeliveryFixProduct, $prodBasketRow[P_CODE]);
									} else {
										$intProdBasketDeliveryPrice = 0;
									}
								} else $aryDeliveryFixProduct = array($prodBasketRow[P_CODE]);
							}

							$aryDeliveryPrice[$prodBasketRow[P_BAESONG_TYPE]] += $intProdBasketDeliveryPrice;
						}

						$intProdBasketShopDeliveryTotal = getCartDeliveryPrice($aryDeliveryPrice,$value[BASKET_PRICE],$SHOP_ARY_DELIVERY,$value);
						$aryProdBasketShopList[$key][DELIVERY_PRICE] = $intProdBasketShopDeliveryTotal;
						$intOrderTotalDeliveryPrice = $intOrderTotalDeliveryPrice + $intProdBasketShopDeliveryTotal;

						$aryShopAccList[$key]["DELIVERY_PRICE"] = $intProdBasketShopDeliveryTotal;
					}
				}
			}
		}

		/* 배송가격이 무게이고 무료배송 상품 총 가격보다 작을때*/
		if ($S_SITE_LNG != "KR"){

			/* 무게별 배송 */
			if ($S_DELIVERY_FOR_MTH == "W")
			{
				$intOrderTotalDeliveryPrice = 0;
				$intOrderTotalDeliveryPrice = getCartDeliveryPrice($aryDeliveryPrice,$intOrderTotalPrice,$SHOP_ARY_DELIVERY);
				if ($intOrderTotalDeliveryPrice > 0 && $S_DELIVERY_FOR_MTH == "W"){
					/* 총 금액이 무료배송비기준금액보다 작을때 */
					$orderMgr->setO_DELIVERY_WEIGHT($intOrderProdWeight);
					$intOrderTotalDeliveryPrice = $orderMgr->getOrderDelvieryAreaPrice($db);

					if ($intOrderTotalDeliveryPrice == 0){
						if ($intForDeliveryPriceProdCnt > 0) { //프리스타일 (2013.11.10 추가)
							$db->disConnect();
							$result[0][MSG] = $LNG_TRANS_CHAR["OS00060"]; //"주문할 배송비가 존재하지 않습니다.";
							$result[0][RET] = "N";
							$result_array = json_encode($result);
							echo $result_array;
							exit;
						}
					}
				}
			}

			/* 수량별 배송(sojewel) */
			if ($S_DELIVERY_FOR_MTH == "B")
			{
				$intOrderTotalDeliveryPrice = getCartDeliveryPrice($aryDeliveryPrice,$intOrderTotalPrice,$SHOP_ARY_DELIVERY);
				if ($intOrderTotalDeliveryPrice >= 0){
					/* 총 금액이 무료배송비기준금액보다 작을때 */
					//$orderMgr->setO_DELIVERY_WEIGHT($intOrderProdWeight);
					//$intOrderTotalDeliveryPrice = $orderMgr->getOrderDelvieryAreaPrice($db);

					//if ($intOrderTotalDeliveryPrice >= 0){
					$intOrderTotalDeliveryPrice = $intOrderTotalDeliveryPrice + $S_FIX_DELIVERY_FOR_PRICE[$strDeliveryMethod];
					//}
				}
			}

			/* 배송정보 사용하지 않음 */
			if ($S_DELIVERY_FOR_MTH == "N"){
				if ($intForDeliveryPriceProdCnt == 0) $intOrderTotalDeliveryPrice = 0;
			}
		}

		/* 쿠폰 금액 구하기 */
		if ($intO_USE_COUPON > 0 && is_array($aryCouponUseIssueNo)){

			if (is_array($aryCouponUseIssueNo)){

				$strAllCouponUseIssueNoList = "";
				$intCouponTotalPrice = 0;
				for($i=0;$i<sizeof($aryCouponUseIssueNo);$i++){

					$orderMgr->setCOUPON_ISSUE_NO($aryCouponUseIssueNo[$i]);
					$aryCouponInfoList = $orderMgr->getOrderCouponList($db,"O");

					if ( $aryCouponInfoList[0][CU_USE] == '1' )			// 전체 적용
					{
						$intCouponPrice	= $aryCouponInfoList[0][CU_PRICE];
						if ($S_ARY_CUR[$S_SITE_LNG]["USD"][2] == "Y"){
							$intCouponPrice = getCurToPriceSave($aryCouponInfoList[0][CU_PRICE],"US");
						}

						if ($aryCouponInfoList[0][CU_PRICE_OFF] == "1") {
							$intOrderTotalPrice	= getPriceToCur($_POST["orderTotalPrice"]);
							$intCouponPrice		= getRoundUp($intOrderTotalPrice * ($intCouponPrice/100),2);
						}
					}
					else if ( $aryCouponInfoList[0][CU_USE] == '2' || $aryCouponInfoList[0][CU_USE] == '3' )	// 특정 카테고리, 상품
					{
						# 쿠폰이 적용되는 상품가격의 합산을 가져온다.
						$strPB_NO_LIST = substr( implode ( ',' , $aryCartNo ) , 0 , -1 ) ;
						$orderMgr->setPB_ALL_NO($strPB_NO_LIST);
						$orderMgr->setCOUPON_NO($aryCouponInfoList[0][CU_NO]);
						$coupon_param = array
						(
							'type'		=> $aryCouponInfoList[0][CU_USE] ,
						) ;
						$couponTargetCode = $orderMgr->getCouponApplyInfo( $db , $coupon_param ) ;
						$coupon_param['queryString'] = ' AND ' ;
						if ( $aryCouponInfoList[0][CU_USE] == 2 )
							$coupon_param['queryString'] .= ' ( ' ;
						else if ( $aryCouponInfoList[0][CU_USE] == 3 )
							$coupon_param['queryString'] .= ' A.P_CODE IN ( ' ;
						foreach ( $couponTargetCode as $ckey => $cval )
						{
							if ( empty ( $cval['CUA_CODE'] ) )
								continue ;
							if ( $aryCouponInfoList[0][CU_USE] == 2 )
								$coupon_param['queryString'] .= ' B.P_CATE LIKE \'' . $cval['CUA_CODE'] . '%\' OR' ;
							else if ( $aryCouponInfoList[0][CU_USE] == 3 )
								$coupon_param['queryString'] .= $cval['CUA_CODE'] . '  ,' ;
						}
						$coupon_param['queryString'] = substr ( $coupon_param['queryString'] , 0 , -3 ) ;
						$coupon_param['queryString'] .= ' ) ' ;

						$couponProdPriceSum = $orderMgr->getCouponProdPriceSum ( $db , $coupon_param ) ;

						$intCouponPrice	= $aryCouponInfoList[0][CU_PRICE];
						if ( $couponProdPriceSum['sumPrice'] <= $aryCouponInfoList[0][CU_PRICE] )
							$intCouponPrice	= $couponProdPriceSum['sumPrice'];

						if ($S_ARY_CUR[$S_SITE_LNG]["USD"][2] == "Y"){
							$intCouponPrice = getCurToPriceSave($aryCouponInfoList[0][CU_PRICE],"US");
						}

						if ($aryCouponInfoList[0][CU_PRICE_OFF] == "1") {
							$intOrderTotalPrice	= getPriceToCur($_POST["orderTotalPrice"]);
							$intCouponPrice		= getRoundUp( $couponProdPriceSum['sumPrice'] * ($intCouponPrice/100),2);
						}
					}

					$intCouponTotalPrice += $intCouponPrice;
					$strAllCouponUseIssueNoList .= $aryCouponUseIssueNo[$i].",";
				}
			}

			$intCouponTotalPriceOrg = $intCouponTotalPrice;
			$intCouponTotalPrice	= ($S_ARY_CUR[$S_SITE_LNG]["USD"][2] == "Y") ? getCurToPriceSave($intCouponTotalPrice,"US") : getCurToPriceSave($intCouponTotalPrice);
			if ($intO_USE_COUPON != $intCouponTotalPrice){
				$db->disConnect();
				$result[0][MSG] = $LNG_TRANS_CHAR["OS00059"]; //"쿠폰 사용 가능한 금액이 일치하지 않습니다
				$result[0][RET] = "N";
				$result_array = json_encode($result);
				echo $result_array;
				exit;
			}

			$orderMgr->setO_USE_COUPON($intO_USE_COUPON); //->현지통화
			$orderMgr->setO_USE_CUR_COUPON($intCouponTotalPriceOrg); //->기준통화
			//$orderMgr->setO_USE_CUR_COUPON(getPriceToCur($intO_USE_COUPON)); //->기준통화
		}

		/* 과세/비과세 */
		$intOrderTaxTotal = 0;
		if ($S_SITE_TAX == "Y"){
			$intOrderTaxTotal		= ($intOrderTotalPrice * 0.1);
			$intOrderTaxTotalCur	= ($intOrderTotalPriceCur * 0.1);
		}

		/* PG사 결제시 수수료 부여 */
		$intOrderPgCommissionTotal = 0;
		if ($S_PG_COMMISSION == "Y"){
			if ($S_PG_CARD_COMMISSION > 0){
				/* 엑심베이 결제/한국PG사의 카드 결제 */
				if ($strO_SETTLE == "X" || $strO_SETTLE == "C"){
					if ($S_SITE_LNG == "KR") $intOrderPgCommissionTotal = getRoundWonUp(($intOrderTotalPrice * $S_PG_CARD_COMMISSION/100));
					else $intOrderPgCommissionTotal = getRoundUp(($intOrderTotalPrice * $S_PG_CARD_COMMISSION/100),2);
				}
			}
		}


		/* 총결제금액확인(총주문금액 - (사용포인트 + 사용쿠폰금액) + 배송비 + 과세/비과세 + PG 수수료) => 현지금액*/
		//$intOrderTotalSPrice = getCurToPriceSave($intOrderTotalPrice + $intOrderTaxTotal + $intOrderPgCommissionTotal + $intOrderTotalDeliveryPrice) - ($intO_USE_POINT + $intO_USE_COUPON) ;
		if ($S_ARY_CUR[$S_SITE_LNG]["USD"][2] == "Y") {
			$intOrderTotalSPrice = $intOrderTotalPriceCur + $intOrderTaxTotalCur + getCurToPriceSave(($intOrderPgCommissionTotal + $intOrderTotalDeliveryPrice),"US") - ($intO_USE_POINT + $intO_USE_COUPON) ;
		} else {
			$intOrderTotalSPrice = $intOrderTotalPriceCur + $intOrderTaxTotalCur + getCurToPriceSave($intOrderPgCommissionTotal + $intOrderTotalDeliveryPrice) - ($intO_USE_POINT + $intO_USE_COUPON) ;
		}

		/* 회원등급별 할인혜택 */
		if ($S_SHOP_HOME == "demo2"){
			//echo $intOrderTotalSPrice;
			//echo $S_MEMBER_GROUP[$g_member_group]["DISCOUNT_ST"];
			//echo $intMemberGradeAddPoint;
			//exit;
		}

		$intMemberGradeDiscountPrice = $intMemberGradeAddPoint = 0;
		if(($g_member_login && $g_member_no) && ($S_MEMBER_GROUP[$g_member_group]["DISCOUNT_ST"] != "1")){

			/* 등급기준 : 주문금액 */
			$intMemberGradeOrderTotalPrice = 0;
			if ($S_MEMBER_GROUP[$g_member_group]["PRICE_ST"] == "P"){
				$intMemberGradeOrderTotalPrice = $intOrderTotalPrice + $intOrderTaxTotal + $intOrderTotalDeliveryPrice; //총주문금액 : 기준통화
			}

			if ($S_MEMBER_GROUP[$g_member_group]["PRICE_ST"] == "S"){
				$intMemberGradeOrderTotalPrice = getPriceToCur($intOrderTotalSPrice); //총결제금액 : 기준통화
			}

			/* 추가할인 */
			if ($S_MEMBER_GROUP[$g_member_group]["DISCOUNT_ST"] == "2" || $S_MEMBER_GROUP[$g_member_group]["DISCOUNT_ST"] == "4"){
				if ($intMemberGradeOrderTotalPrice >= $S_MEMBER_GROUP[$g_member_group]["DISCOUNT_PRICE"]){

					/* 할인혜택 단위 - % */
					if ($S_MEMBER_GROUP[$g_member_group]["DISCOUNT_UNIT"] == "1"){
						$intMemberGradeDiscountPrice = ($intMemberGradeOrderTotalPrice * ($S_MEMBER_GROUP[$g_member_group]["DISCOUNT_RATE"]/100));
					}

					/* 할인혜택 단위 - 원 */
					if ($S_MEMBER_GROUP[$g_member_group]["DISCOUNT_UNIT"] == "2"){
						$intMemberGradeDiscountPrice = $S_MEMBER_GROUP[$g_member_group]["DISCOUNT_RATE"];
					}

					/* 할인혜택 단위 (절삭)*/
					if ($S_MEMBER_GROUP[$g_member_group]["DISCOUNT_OFF"] == 1) {
						if (!$S_MEMBER_GROUP[$g_member_group]["DISCOUNT_POINT"]) $S_MEMBER_GROUP[$g_member_group]["DISCOUNT_POINT"] = "1";

						if ($S_ST_CUR == "KRW") {
							$intMemberGradeDiscountPrice = getTruncateDown($intMemberGradeDiscountPrice,$S_MEMBER_GROUP[$g_member_group]["DISCOUNT_POINT"]);
						} else {
							$intMemberGradeDiscountPrice = getTruncateDown($intMemberGradeDiscountPrice,-$S_MEMBER_GROUP[$g_member_group]["DISCOUNT_POINT"]);
						}

					}

					/* 할인혜택 단위 (반올림)*/
					if ($S_MEMBER_GROUP[$g_member_group]["DISCOUNT_OFF"] == 2) {
						if (!$S_MEMBER_GROUP[$g_member_group]["DISCOUNT_POINT"]) $S_MEMBER_GROUP[$g_member_group]["DISCOUNT_POINT"] = "1";

						if ($S_ST_CUR == "KRW") {
							$intMemberGradeDiscountPrice = round($intMemberGradeDiscountPrice,-$S_MEMBER_GROUP[$g_member_group]["DISCOUNT_POINT"]);
						} else {
							$intMemberGradeDiscountPrice = round($intMemberGradeDiscountPrice,$S_MEMBER_GROUP[$g_member_group]["DISCOUNT_POINT"]);
						}
					}
				}
			}

			/* 추가포인트 적립 */
			if ($S_MEMBER_GROUP[$g_member_group]["DISCOUNT_ST"] == "3" || $S_MEMBER_GROUP[$g_member_group]["DISCOUNT_ST"] == "4"){
				if ($intMemberGradeOrderTotalPrice >= $S_MEMBER_GROUP[$g_member_group]["POINT_PRICE"]){

					/* 추가포인트 단위 - % */
					if ($S_MEMBER_GROUP[$g_member_group]["POINT_UNIT"] == "1"){
						$intMemberGradeAddPoint = $intMemberGradeOrderTotalPrice * ($S_MEMBER_GROUP[$g_member_group]["POINT_RATE"]/100);
					}

					/* 추가포인트 단위 - 원 */
					if ($S_MEMBER_GROUP[$g_member_group]["POINT_UNIT"] == "2"){
						$intMemberGradeAddPoint = $S_MEMBER_GROUP[$g_member_group]["POINT_RATE"];
					}

					/* 추가포인트 단위 (절삭)*/
					if ($S_MEMBER_GROUP[$g_member_group]["POINT_OFF"] == 1) {
						if (!$S_MEMBER_GROUP[$g_member_group]["POINT_POINT"]) $S_MEMBER_GROUP[$g_member_group]["POINT_POINT"] = "0";

						if ($S_ST_CUR == "KRW") {
							$intMemberGradeAddPoint = getTruncateDown($intMemberGradeAddPoint,$S_MEMBER_GROUP[$g_member_group]["POINT_POINT"]);
						} else {
							$intMemberGradeAddPoint = getTruncateDown($intMemberGradeAddPoint,-$S_MEMBER_GROUP[$g_member_group]["POINT_POINT"]);
						}
					}

					/* 추가포인트 단위 (반올림)*/
					if ($S_MEMBER_GROUP[$g_member_group]["POINT_OFF"] == 2) {
						if (!$S_MEMBER_GROUP[$g_member_group]["POINT_POINT"]) $S_MEMBER_GROUP[$g_member_group]["POINT_POINT"] = "0";

						if ($S_ST_CUR == "KRW") {
							$intMemberGradeAddPoint = round($intMemberGradeAddPoint,-$S_MEMBER_GROUP[$g_member_group]["POINT_POINT"]);
						} else {
							$intMemberGradeAddPoint = round($intMemberGradeAddPoint,$S_MEMBER_GROUP[$g_member_group]["POINT_POINT"]);
						}
					}
				}
			}
		}

		/* 총결제금액 - 회원등급별 추가 할인금액 */
		if ($intMemberGradeDiscountPrice > 0) {
			$intOrderTotalSPrice = $intOrderTotalSPrice - getCurToPriceSave($intMemberGradeDiscountPrice);
		}

		/* 포인트/쿠폰으로 구매 */
		if ($strOrderPayMethod == "999999999999" && $intOrderTotalSPrice <= 0){
			$strO_SETTLE = "P";
			$orderMgr->setO_SETTLE($strO_SETTLE);
		}

		/* 적립금 지급 기준에 따른 포인트 */
		if ($S_POINT_USE1 == "Y") {

			if ($S_POINT_ST == "P") {
				/* 판매가 기준 */
				if ($intOrderTotalPrice < $S_POINT_ST_PRICE){
					$intOrderTotalPoint = 0;
				}
			} else {
				/* 결제가격 기준/ 결제방법이 포인트가 아니면 */
				if ($strO_SETTLE != "P"){
					if (getPriceToCur($intOrderTotalSPrice) < $S_POINT_ST_PRICE){
						$intOrderTotalPoint = 0;
					}
				} else {
					$intOrderTotalPoint = 0;
				}
			}

			/* 적립금을 사용한 주문은 상품적립금을 지급하지 않음 */
			if ($intO_USE_POINT > 0 && $S_POINT_USE2 == "N") {
				$intOrderTotalPoint = 0;
			}
		} else {
			/* 적림금 관리를 사용하지 않음 */
			$intOrderTotalPoint = 0;
		}

		/* 쿠폰사용금액이 있을 경우 적립금 사용유무 */
		if (getPriceToCur($intO_USE_COUPON) > 0 && $S_POINT_COUPON_USE == "N"){
			$intOrderTotalPoint = 0;
		}

		/* 회원 등급별 추가 적립금 지급 */
		if ($intMemberGradeAddPoint > 0) {
			$intOrderTotalPoint = $intOrderTotalPoint + $intMemberGradeAddPoint;
		}

		/* 주문정보 KEY 생성*/
		$strOrderKey = date("Ymd").STRTOUPPER(rand_code(5)).$orderMgr->getOrderKey($db);
		$orderMgr->setO_KEY($strOrderKey);
		$intDupKeyCnt = $orderMgr->getOrderDupKey($db);

		if ($intDupKeyCnt > 0){
			$strFlag = false;

			while($strFlag == false){

				$strOrderKey = date("Ymd").STRTOUPPER(rand_code(5)).$orderMgr->getOrderKey($db);
				$orderMgr->setO_KEY($strOrderKey);
				$intDupKeyCnt = $orderMgr->getOrderDupKey($db);

				if($intDupKeyCnt=="0"){
					$strFlag = true;
					break;
				}
			}
		}

		/* 주문정보 INSERT */


//			$orderMgr->setO_TOT_PRICE(getCurToPriceSave($intOrderTotalPrice)); //기준통화->현지통화
//			$orderMgr->setO_TAX_PRICE(getCurToPriceSave($intOrderTaxTotal)); //기준통화->현지통화

		$orderMgr->setO_TOT_PRICE($intOrderTotalPriceCur); //기준통화->현지통화
		$orderMgr->setO_TAX_PRICE($intOrderTaxTotalCur); //기준통화->현지통화

		$orderMgr->setO_TOT_DELIVERY_PRICE(getCurToPriceSave($intOrderTotalDeliveryPrice)); //기준통화->현지통화

		$orderMgr->setO_TOT_MEM_DISCOUNT_PRICE(getCurToPriceSave($intMemberGradeDiscountPrice)); //기준통화->현지통화

		$orderMgr->setO_TOT_SPRICE($intOrderTotalSPrice); //현지통화
		$orderMgr->setO_TOT_POINT(getCurToPriceSave($intOrderTotalPoint)); //기준통화->현지통화
		$orderMgr->setO_TOT_MEM_POINT(getCurToPriceSave($intMemberGradeAddPoint)); //기준통화->현지통화
		$orderMgr->setO_TOT_PG_COMMISSION(getCurToPriceSave($intOrderPgCommissionTotal)); //기준통화->현지통화

		$orderMgr->setO_TOT_CUR_PRICE($intOrderTotalPrice); //기준통화
		$orderMgr->setO_TOT_DELIVERY_CUR_PRICE($intOrderTotalDeliveryPrice);
		$orderMgr->setO_TAX_CUR_PRICE($intOrderTaxTotal);
		$orderMgr->setO_TOT_MEM_DISCOUNT_CUR_PRICE($intMemberGradeDiscountPrice);
		$orderMgr->setO_TOT_PG_CUR_COMMISSION($intOrderPgCommissionTotal);


		/* 기준통화 금액으로 변경시 원래 기준금액합에서만 빼는걸로 수정 (2013.08.05)*/
		$intOrderTotalPriceCurr = ($intOrderTotalPrice + $intOrderTaxTotal + $intOrderTotalDeliveryPrice + $intOrderPgCommissionTotal) - getPriceToCur($intO_USE_POINT) - getPriceToCur($intO_USE_COUPON) - $intMemberGradeDiscountPrice;
		$orderMgr->setO_TOT_CUR_SPRICE($intOrderTotalPriceCurr); //현지통화->기준통화

		$orderMgr->setO_TOT_CUR_POINT($intOrderTotalPoint);
		$orderMgr->setO_TOT_MEM_CUR_POINT($intMemberGradeAddPoint);

		if ($S_ARY_CUR[$S_SITE_LNG]["USD"][2] == "Y") {
			$intOrderTotalSPriceUsd = ($intOrderTotalPriceCur + getCurToPriceSave($intOrderTaxTotal,"US") + getCurToPriceSave($intOrderTotalDeliveryPrice,"US") + getCurToPriceSave($intOrderPgCommissionTotal,"US") -  $intO_USE_POINT - $intO_USE_COUPON) - getCurToPriceSave($intMemberGradeDiscountPrice,"US");
			if ($intOrderTotalSPrice == 0) $intOrderTotalSPriceUsd = 0;

			$orderMgr->setO_USE_CUR("USD"); //사용환율
			$orderMgr->setO_USE_CUR_RATE($S_ARY_CUR[$S_SITE_LNG]["USD"][0]); //환율정보(실제결제한환율)
			$orderMgr->setO_USE_CUR_ORG_RATE($S_ARY_CUR[$S_SITE_LNG][$S_SITE_CUR][0]);

			$orderMgr->setO_TOT_PRICE($intOrderTotalPriceCur); //기준통화->현지통화
			$orderMgr->setO_TOT_DELIVERY_PRICE(getCurToPriceSave($intOrderTotalDeliveryPrice,"US")); //기준통화->현지통화
			$orderMgr->setO_TAX_PRICE(getCurToPriceSave($intOrderTaxTotal,"US")); //기준통화->현지통화
			$orderMgr->setO_TOT_MEM_DISCOUNT_PRICE(getCurToPriceSave($intMemberGradeDiscountPrice,"US")); //기준통화->현지통화
			$orderMgr->setO_TOT_SPRICE($intOrderTotalSPriceUsd); //현지통화
			$orderMgr->setO_TOT_POINT(getCurToPriceSave($intOrderTotalPoint,"US")); //기준통화->현지통화
			$orderMgr->setO_TOT_MEM_POINT(getCurToPriceSave($intMemberGradeAddPoint,"US")); //기준통화->현지통화
			$orderMgr->setO_TOT_PG_CUR_COMMISSION(getCurToPriceSave($intOrderPgCommissionTotal,"US")); //기준통화->현지통화

			$intOrderTotalPriceCurr = ($intOrderTotalPrice + $intOrderTaxTotal + $intOrderTotalDeliveryPrice + $intOrderPgCommissionTotal) - getPriceToCur($intO_USE_POINT,"USD") - getPriceToCur($intO_USE_COUPON,"USD") - $intMemberGradeDiscountPrice;
			$orderMgr->setO_TOT_CUR_SPRICE($intOrderTotalPriceCurr); //현지통화->기준통화

		} else {
			$orderMgr->setO_USE_CUR($S_SITE_CUR); //사용환율
			$orderMgr->setO_USE_CUR_RATE($S_ARY_CUR[$S_SITE_LNG][$S_SITE_CUR][0]); //환율정보
			$orderMgr->setO_USE_CUR_ORG_RATE(0);
		}

		$orderMgr->setO_USE_LNG($S_SITE_LNG); //사용언어

		/* 무통장 입금시 계좌정보 */
		if ($strO_SETTLE == "B"){
			if ($S_SITE_LNG == "KR"){
				$strO_BANK_ACC = $arySiteSettleBank[$strO_BANK_ACC];
				$orderMgr->setO_BANK_ACC($strO_BANK_ACC);
			} else {
				$strO_BANK_ACC = $arySiteForSettleBank[$strO_BANK_ACC];
				$orderMgr->setO_BANK_ACC($strO_BANK_ACC);
			}
		}

		$orderMgr->getOrderInsert($db);
		$intO_NO = $db->getLastInsertID();
		$orderMgr->setO_NO($intO_NO);

		/* 상품 장바구니 -> 주문장바구니로 이동 */
		if ($strAllCartNo){
			//$strAllCartNo = SUBSTR($strAllCartNo,0,STRLEN($strAllCartNo)-1);
			$productMgr->setPB_ALL_NO($strAllCartNo);
			$productMgr->setPB_ALL_SORT("Y");

			$productMgr->setP_SHOP_NO(0);
			$aryProdBasketList = $productMgr->getProdBasketList($db);

			if (is_array($aryProdBasketList)){

				$strOrderCartInfoList = "";
				$strOrderCartNoList = "";
				for($i=0;$i<sizeof($aryProdBasketList);$i++){

					/* 할인가격 업데이트 */
					$productMgr->setPB_NO($aryProdBasketList[$i][PB_NO]);
					$productMgr->setPB_PRICE($aryOrderBasketList[$aryProdBasketList[$i][PB_NO]]['PRICE']);
					$productMgr->setPB_POINT($aryOrderBasketList[$aryProdBasketList[$i][PB_NO]]['POINT']);
					$productMgr->setPB_STOCK_PRICE($aryOrderBasketList[$aryProdBasketList[$i][PB_NO]]['STOCK_PRICE']);
					$productMgr->getProdBasketDisCountPriceUpdate($db);
					/* 할인가격 업데이트 */

					/* kcp 에스크로 결제에 필요한 변수설정 */
					$strOrderCartInfoList .= "seq=".($i+1);
					$strOrderCartInfoList .= chr('31')."ordr_numb=".($intO_NO."_".pushHeadZero(($i+1),4));
					$strOrderCartInfoList .= chr('31')."good_name=".$aryProdBasketList[$i][P_NAME];
					$strOrderCartInfoList .= chr('31')."good_cntx=".$aryProdBasketList[$i][PB_QTY];
					$strOrderCartInfoList .= chr('31')."good_amtx=".(($aryProdBasketList[$i][PB_QTY]*$aryProdBasketList[$i][PB_PRICE]) + $aryProdBasketList[$i][PB_ADD_OPT_PRICE]);
					if ($i != sizeof($aryProdBasketList) - 1) $strOrderCartInfoList .= chr('30');
					/* kcp 에스크로 결제에 필요한 변수설정 */

					/* 모바일 결제시 필요함 */
					$strOrderCartNoList .= $aryProdBasketList[$i][PB_NO].",";

					$orderMgr->setPB_NO($aryProdBasketList[$i][PB_NO]);
					$orderMgr->getOrderCartInsert($db);
					$intOC_NO = $db->getLastInsertID();

					if ($intOC_NO > 0){
						$orderMgr->setOC_NO($intOC_NO);
						$orderMgr->getOrderCartAddInsert($db);

						/* 상품명/배송방법/기본/고정배송비/ 변경 */
						if ($S_SHOP_ORDER_VERSION == "V2.0")
						{
							$cartParamUpdate							= "";
							$cartParamUpdate['OC_NO']					= $intOC_NO;
							$cartParamUpdate['OC_P_NAME']				= $aryOrderBasketList[$aryProdBasketList[$i][PB_NO]]['P_NAME'];
							$cartParamUpdate['OC_P_BAESONG_TYPE']		= $aryOrderBasketList[$aryProdBasketList[$i][PB_NO]]['P_BAESONG_TYPE'];
							$cartParamUpdate['OC_DELIVERY_PRICE']		= getCurToPriceSave($aryOrderBasketList[$aryProdBasketList[$i][PB_NO]]['P_BAESONG_PRICE']);
							$cartParamUpdate['OC_DELIVERY_CUR_PRICE']	= $aryOrderBasketList[$aryProdBasketList[$i][PB_NO]]['P_BAESONG_PRICE'];
							$orderMgr->getOrderCartUpdate($db,$cartParamUpdate);
						}

						/* 상품 추가 항목 */
						if ($S_SHOP_PROD_ADD_ITEM_VERSION == "V2.O"){
							$orderMgr->setOC_NO($intOC_NO);
							$orderMgr->getOrderCartItemInsert($db);
						}
					}

					/* 무통장 입금일때 , 포인트 구매일때 */
					if ($strO_SETTLE == "B" || $strO_SETTLE == "P"){
						/* 장바구니 삭제 */
						$productMgr->setPB_NO($aryProdBasketList[$i][PB_NO]);
						$productMgr->getProductBasketAddDelete($db);

						if ($S_SHOP_PROD_ADD_ITEM_VERSION == "V2.O"){
							$productMgr->getProductBasketItemDelete($db);
						}

						$productMgr->getProductBasketDelete($db);
					}
				}
			}
		}

		/* 첫구매고객일때 사은품 지급 */
		if($g_member_login && $g_member_no){
			$memberMgr->setM_NO($g_member_no);
			$memberOrderRow = $memberMgr->getMemberOrderCount($db);
			if ($memberOrderRow){
				$intMemberOrderJumunCnt = $memberOrderRow[JUMUN_CNT];
				$intMemberOrderDeliveryCnt = $memberOrderRow[DELIVERY_CNT];

				if ($intMemberOrderJumunCnt == 1 || $intMemberOrderDeliveryCnt == 0){

					if (is_array($aryFirstGiftNo)){
						for($i=0;$i<sizeof($aryFirstGiftNo);$i++){

							$productMgr->setGIFT_NO($aryFirstGiftNo[$i]);
							$prodGiftRow = $productMgr->getCusGiftView($db);

							$strProdGiftOpt = "";
							if ($prodGiftRow[CG_OPT_NM1]) $strProdGiftOpt .= $prodGiftRow[CG_OPT_NM1].":".$aryFirstGiftOpt1[$i];
							if ($prodGiftRow[CG_OPT_NM2]) $strProdGiftOpt .= "/".$prodGiftRow[CG_OPT_NM2].":".$aryFirstGiftOpt2[$i];

							$orderMgr->setGIFT_NO($aryFirstGiftNo[$i]);
							$orderMgr->setGIFT_OPT($strProdGiftOpt);
							$orderMgr->setGIFT_QTY(1);
							$orderMgr->getOrderGiftInsert($db);
						}
					}
				}
			}
		}

		/* 구매금액에 따른 고객 사은품 지급 */
		if (is_array($aryGiftNo) && (($S_GIFT_USE == "A") || ($S_GIFT_USE == "M" && $g_member_login && $g_member_no))){
			for($i=0;$i<sizeof($aryGiftNo);$i++){

				$productMgr->setGIFT_NO($aryGiftNo[$i]);
				$prodGiftRow = $productMgr->getCusGiftView($db);

				$strProdGiftOpt = "";
				if ($prodGiftRow[CG_OPT_NM1]) $strProdGiftOpt .= $prodGiftRow[CG_OPT_NM1].":".$aryGiftOpt1[$i];
				if ($prodGiftRow[CG_OPT_NM2]) $strProdGiftOpt .= "/".$prodGiftRow[CG_OPT_NM2].":".$aryGiftOpt2[$i];

				$orderMgr->setGIFT_NO($aryGiftNo[$i]);
				$orderMgr->setGIFT_OPT($strProdGiftOpt);
				$orderMgr->setGIFT_QTY(1);
				$orderMgr->getOrderGiftInsert($db);
			}
		}

		/* 입점몰일때 정산관련 데이터 INSERT */
		if ($S_MALL_TYPE != "R"){
			foreach ($aryShopAccList as $key => $value){
				//if ($key > 0){
				$orderMgr->setSH_NO($key);
				$shopRow = $orderMgr->getShopView($db);

				if ($shopRow[SH_COM_ACC_PRICE] == "S") {
					/* 판매가 기준 */
					$intAccStPrice = $value[SALE_PRICE];
					if ($S_ST_CUR == "KRW" || $S_ST_CUR == "JPY" || $S_ST_CUR == "RUB") {
						$intAccPrice = getRoundUp(($intAccStPrice - ($intAccStPrice * ($shopRow[SH_COM_ACC_RATE]/100))),0);
					} else {
						$intAccPrice = getRoundUp(($intAccStPrice - ($intAccStPrice * ($shopRow[SH_COM_ACC_RATE]/100))),2);
					}
				} else {
					$intAccStPrice = $value[STOCK_PRICE];
					$intAccPrice   = $intAccStPrice;
				}

				$orderMgr->setSO_TOT_PROD_CNT($value[SALE_QTY]);
				$orderMgr->setSO_TOT_PRICE(getCurToPriceSave($value[STOCK_PRICE]));
				$orderMgr->setSO_TOT_CUR_PRICE($value[STOCK_PRICE]);
				$orderMgr->setSO_TOT_SPRICE(getCurToPriceSave($value[SALE_PRICE]));
				$orderMgr->setSO_TOT_CUR_SPRICE($value[SALE_PRICE]);
				$orderMgr->setSO_TOT_APRICE(getCurToPriceSave($intAccPrice));
				$orderMgr->setSO_TOT_CUR_APRICE($intAccPrice);
				$orderMgr->setSO_TOT_DELIVERY_PRICE($value[DELIVERY_PRICE]);
				$orderMgr->setSO_TOT_DELIVERY_CUR_PRICE(getCurToPriceSave($value[DELIVERY_PRICE]));
				$orderMgr->getOrderAccInsert($db);
				//}
			}
		}

		/* 주소록 새로 입력 */
		if ($g_member_no && $g_member_login && $strBasicAddr == "Y"){
			$memberMgr->setM_NO($g_member_no);
			$memberMgr->setMA_TYPE("2");
			$memberMgr->setMA_NAME($strO_B_NAME);
			$memberMgr->setMA_PHONE($strO_B_PHONE);
			$memberMgr->setMA_HP($strO_B_HP);
			$memberMgr->setMA_ZIP($strO_B_ZIP);
			$memberMgr->setMA_COUNTRY($strO_B_COUNTRY);
			$memberMgr->setMA_ADDR1($strO_B_ADDR1);
			$memberMgr->setMA_ADDR2($strO_B_ADDR2);
			$memberMgr->setMA_CITY($strO_B_CITY);
			$memberMgr->setMA_STATE($strO_B_STATE);
			$memberMgr->getMemberAddrInsert($db);
		}

		/* 총주문의 상품가격합의 DISCOUNT 할인율/가격 UPDATE(bejewel)*/
		if ($S_FIX_ORDER_TOTAL_DISCOUNT_USE == "Y"){
			if (!$intOrderPriceDiscountRate) $intOrderPriceDiscountRate = 0;
			if (!$intOrderPriceDiscountPrice) $intOrderPriceDiscountPrice = 0;

			$discountParam							= "";
			$discountParam['O_NO']					= $intO_NO;
			$discountParam['DISCOUNT_RATE']			= $intOrderPriceDiscountRate;
			$discountParam['DISCOUNT_PRICE']		= $intOrderPriceDiscountPrice;
			$orderMgr->getOrderDiscountPriceUpdate($db,$discountParam);
		}

		/* 무통장/포인트 결제일때 */
		if ($strO_SETTLE == "B" || $strO_SETTLE == "P"){
			$strOrderSettleApprNo = "A".date("Ymd").STRTOUPPER(getCode(5));
			$orderMgr->setOS_APPR_NO($strOrderSettleApprNo);
			$intDupApprNoCnt = $orderMgr->getOrderDupApprNo($db);

			if ($intDupApprNoCnt > 0){
				$strFlag = false;

				while($strFlag == false){

					$strOrderSettleApprNo = "A".date("Ymd").STRTOUPPER(getCode(5));
					$orderMgr->setOS_APPR_NO($strOrderSettleApprNo);
					$intDupApprNoCnt = $orderMgr->getOrderDupApprNo($db);

					if($intDupApprNoCnt=="0"){
						$strFlag = true;
						break;
					}
				}
			}
			$orderMgr->setO_APPR_NO($strOrderSettleApprNo);
			$orderMgr->getOrderApprNoUpdate($db);

			/* 사용포인트 차감 (무통장결제)*/
			if ($g_member_no && $S_POINT_USE1 == "Y"){

				if ($orderMgr->getO_USE_POINT() > 0){
					$memberMgr->setM_POINT(-$orderMgr->getO_USE_CUR_POINT());
					$memberMgr->getMemberPointUpdate($db);

					/* 포인트 관리 데이터 INSERT */
					$orderMgr->setM_NO($g_member_no);
					$orderMgr->setB_NO(0);
					$orderMgr->setPT_TYPE('001');
					$orderMgr->setPT_POINT($memberMgr->getM_POINT());
					$orderMgr->setPT_MEMO($LNG_TRANS_CHAR["OW00096"]."[".$orderMgr->getO_KEY()."]"); //포인트사용구매
					$orderMgr->setPT_START_DT(date("Y-m-d"));
					$orderMgr->setPT_END_DT(date("Y-m-d"));
					$orderMgr->setPT_REG_IP($S_REOMTE_ADDR);
					$orderMgr->setPT_ETC('J1');
					$orderMgr->setPT_REG_NO(1);
					$orderMgr->setPT_POINT_USE_YEAR($S_POINT_USE_YEAR);

					$orderMgr->getOrderPointInsert($db);
				}
			}

			/* 쿠폰 사용 유무 체크 */
			if (is_array($aryCouponUseIssueNo) && $intO_USE_COUPON > 0){
				for($i=0;$i<sizeof($aryCouponUseIssueNo);$i++){
					$orderMgr->setCOUPON_ISSUE_NO($aryCouponUseIssueNo[$i]);
					$orderMgr->getOrderCouponUseUpdate($db);
				}
			}

			/* 상품 재고량 감소 */
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
							$productMgr->setPOA_STOCK_QTY(-$intOC_QTY);
							$productMgr->setPOA_NO($intOC_OPT_NO);
							$productMgr->getProdOptQtyUpdate($db);
						}

						/* 상품전체 수량 조절 */
						if ($strProdCode)
						{
							$intProdQty = $intProdStockQty - $intOC_QTY;
							if ($intProdQty < 0) $intOC_QTY = $intProdStockQty;

							$productMgr->setP_QTY(-$intOC_QTY);
							$productMgr->setP_CODE($strProdCode);
							$productMgr->getProdQtyUpdate($db);
						}
					}

					if ($aryOrderCartList[$j]["P_POINT_NO_USE"] == "Y") {
						$intOrderProdNoPointUseCnt++;
					}
				}
			}
			/* 상품 재고량 감소 */

			/* 포인트결제일 경우 포인트 적립(적립금관리사용유무) */
			if ($strO_SETTLE == "P")
			{
				if ($S_POINT_USE1 == "Y"){

					if (($intO_USE_POINT > 0 && $S_POINT_USE2 == "Y") || $intO_USE_POINT == 0) {

						if ($S_POINT_ORDER_STATUS == "S"){

							/* 사용포인트가 있고 적립금 사용시 상품적립금 지급 유무(Y) , 사용포인트가 없을 경우 단(포인트지급유무 주문상태는 결제완료)*/
							if ($intOrderTotalPoint > 0 && $g_member_no > 0){
								$memberMgr->setM_NO($g_member_no);
								$memberMgr->setM_POINT(getPriceToCur($intOrderTotalPoint));
								$memberMgr->getMemberPointUpdate($db);

								/* 포인트 관리 데이터 INSERT */
								$orderMgr->setM_NO($g_member_no);
								$orderMgr->setB_NO(0);
								$orderMgr->setPT_TYPE('002');
								$orderMgr->setPT_POINT($memberMgr->getM_POINT());
								$orderMgr->setPT_MEMO($LNG_TRANS_CHAR["OW00097"]."[".$strOrderKey."]"); //구매포인트적립
								$orderMgr->setPT_START_DT(date("Y-m-d"));
								$orderMgr->setPT_END_DT(date("Y-m-d",mktime(0,0,0,date("m"),date("d"),date("Y")+$S_POINT_USE_YEAR)));
								$orderMgr->setPT_REG_IP($S_REOMTE_ADDR);
								$orderMgr->setPT_ETC('');
								$orderMgr->setPT_REG_NO(1);
								$orderMgr->getOrderPointInsert($db);

								$orderMgr->setO_ADD_POINT("Y");
								$orderMgr->getOrderAddPointUpdate($db);

								/* 포인트 히스토리 추가해야 함*/
							}
						}
					}

					/* 첫구매 포인트 지급 확인(적립금 사용시 적립금 지급 유무:포인트사용금지인상품인경우포인트를 지급하지 않는다.) */
					if ($g_member_no && $S_POINT_ORDER_GIVE > 0 && $intMemberOrderJumunCnt == 0){
						$strOrderFirstPointGiveYN = "Y";
						if ($intO_USE_POINT > 0 && $S_POINT_USE2 != "Y"){
							$strOrderFirstPointGiveYN = "N";
						}

						if ($strOrderFirstPointGiveYN == "Y" && $intOrderProdNoPointUseCnt == 0){
							$memberMgr->setM_NO($g_member_no);
							$memberMgr->setM_POINT($S_POINT_ORDER_GIVE);
							$memberMgr->getMemberPointUpdate($db);

							/* 포인트 관리 데이터 INSERT */
							$orderMgr->setM_NO($g_member_no);
							$orderMgr->setB_NO(0);
							$orderMgr->setPT_TYPE('004');
							$orderMgr->setPT_POINT($memberMgr->getM_POINT());
							$orderMgr->setPT_MEMO($LNG_TRANS_CHAR["OW00104"]."[".$strOrderKey."]"); //첫구매포인트적립
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

				/* 승인데이터 INSERT */
				$orderMgr->setOS_STATUS("A");
				$orderMgr->setOS_APPR_NO($strOrderSettleApprNo);
				$orderMgr->setOS_TITLE($strOrderTitle);
				$orderMgr->setOS_USE_POINT(getPriceToCur($intO_USE_POINT));
				$orderMgr->setOS_USE_COUPON(getPriceToCur($intO_USE_COUPON));
				$orderMgr->setOS_TOT_PRICE($intOrderTotalPrice);
				$orderMgr->setOS_TOT_DELIVERY_PRICE($intOrderTotalDeliveryPrice);
				$orderMgr->setOS_TOT_TAX_PRICE($intOrderTaxTotal);
				$orderMgr->setOS_TOT_SPRICE(getPriceToCur($intOrderTotalSPrice));

				/* 적립포인트가 지급되지 않았을때에는 결제관리테이블에 적립포인트를 '0' 으로 입력 */
				if ($orderMgr->getO_ADD_POINT() == "Y") $orderMgr->setOS_TOT_POINT($intOrderTotalPoint);	else  $orderMgr->setOS_TOT_POINT(0);

				$orderMgr->setOS_SETTLE($strO_SETTLE);
				$orderMgr->getOrderSettleInsert($db);

				/* 결제 상태 변경 */
				$orderMgr->setO_STATUS("A");
				$orderMgr->getOrderStatusUpdate($db);

				/* 결제완료시 상품별 배송 배송준비중으로 변경(2014.01.10) */
				$orderMgr->getOrderCartDeliveryStatusUpdate($db);
				/* 결제 상태 변경(정산관련) */
				if ($S_MALL_TYPE != "R"){
					$orderMgr->setSO_DELIVERY_STATUS("B");
					$orderMgr->getOrderAccStatusUpdate($db);
				}

				/* 결제 완료 후 상품별 이용기간 INSERT */
				include MALL_HOME."/web/frwork/act/payOrderPeriodApproval.php";
				/* 결제 완료 후 상품별 이용기간 INSERT */

				/* 경매 상품 정보 UPDATE */
				$strAuctionMode = "1";
				include WEB_FRWORK_JSON."/order.auction.php";
				/* 경매 상품 정보 UPDATE */
			}

			/* 무통장/포인트 주문 메일 발송*/
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

			/* 무통장/포인트 주문 메일 발송*/
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
				$strSmsCode = "008"; // 무통장입금일때 SMS코드(현금 주문완료(고객용))
				if($strO_SETTLE == "P" && $orderRow['O_TOT_CUR_SPRICE'] <= 0) { $strSmsCode = "012"; } // 포인트 결제시 SMS코드

				if($SMS_TEXT_LIST && $SMS_TEXT_LIST[$strSmsCode] && $SMS_TEXT_LIST[$strSmsCode]['SM_AUTO'] == "Y"):

					## 문자 설정
					$strSmsMsg			= $SMS_TEXT_LIST[$strSmsCode]['SM_TEXT'];
					$strSmsMsg			= str_replace("{{고객명}}", $orderRow['O_J_NAME'], $strSmsMsg);
					$strSmsMsg			= str_replace("{{주문번호}}", $orderRow['O_KEY'], $strSmsMsg);
					$strSmsMsg			= str_replace("{{상점명}}", $S_SITE_KNAME, $strSmsMsg);
					$strSmsMsg			= str_replace("{{결제금액}}", getCurToPrice($orderRow['O_TOT_CUR_SPRICE'], $orderRow['O_USE_LNG']), $strSmsMsg);
					$strSmsMsg			= str_replace("{{계좌정보}}", $orderRow['O_BANK_ACC'], $strSmsMsg);

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

// 2015.01.15 kim hee sung 소스 정리 및 sms 작동 오류 수정
//				/** 2013.04.18 SMS 전송 모듈 추가 **/
//				## SMS 사용 , 한국어 페이지 인 경우 SMS 전송 실행
//				if($SMS_INFO['S_SMS_USE']=="Y" && $S_SITE_LNG == "KR"):
//					$smsMoney = $smsFunc->getSmsMoneySelect($db); // 머니 체크
//					if($smsMoney['VAL'] > 0):
//						/* 고객용 */
//						$smsCode			= "008";
//						if($orderRow['O_TOT_CUR_SPRICE'] <= 0) { $smsCode = "012"; } /* 2015.01.14 kim hee sung, 금액이 0원인경우 포인트로 구매한 경우입니다. 구매완료 sms로 변경합니다. */
//						$smsPhone			= str_replace("-","",$orderRow['O_J_HP']);
//						$smsCallBackPhone	= $S_COM_PHONE;
//						$smsMsg				= $SMS_TEXT_LIST[$smsCode]['SM_TEXT'];
//						$smsMsg				= str_replace("{{고객명}}", $orderRow['O_J_NAME'], $smsMsg);
//						$smsMsg				= str_replace("{{주문번호}}", $orderRow['O_KEY'], $smsMsg);
//						$smsMsg				= str_replace("{{상점명}}", $S_SITE_KNAME, $smsMsg);
//						$smsMsg				= str_replace("{{결제금액}}", getCurToPrice($orderRow['O_TOT_CUR_SPRICE'],$orderRow['O_USE_LNG']), $smsMsg);
//						//$smsMsg				= str_replace("{{계좌정보}}", $orderRow['O_BANK_ACC'], $smsMsg);
//						if($SMS_TEXT_LIST[$smsCode]['SM_AUTO'] == "Y"): //  자동발송 사용..
//							$smsFunc->goSendSms($smsPhone, $smsCallBackPhone, $smsMsg);
//							$smsFunc->getSmsMoneyMinusUpdate($db); // 머니 -1
//						endif;
//					else:
//						// sms 머니 부족.. 부분 처리..
//					endif;
//
//					$smsMoney = $smsFunc->getSmsMoneySelect($db); // 머니 체크
//					if($smsMoney['VAL'] > 0):
//						/* 관리자용 */
//						$smsCode			= "009";
//						$smsPhone			= str_replace("-","",$S_COM_HP);
//						$smsCallBackPhone	= $S_COM_PHONE;
//						$smsMsg				= $SMS_TEXT_LIST[$smsCode]['SM_TEXT'];
//						$smsMsg				= str_replace("{{고객명}}", $orderRow['O_J_NAME'], $smsMsg);
//						$smsMsg				= str_replace("{{주문번호}}", $orderRow['O_KEY'], $smsMsg);
//						$smsMsg				= str_replace("{{결제금액}}", getCurToPrice($orderRow['O_TOT_CUR_SPRICE'],$orderRow['O_USE_LNG']), $smsMsg);
//						if($SMS_TEXT_LIST[$smsCode]['SM_AUTO'] == "Y"): //  자동발송 사용..
//							$smsFunc->goSendSms($smsPhone, $smsCallBackPhone, $smsMsg);
//							$smsFunc->getSmsMoneyMinusUpdate($db); // 머니 -1
//						endif;
//					endif;
//
//				endif;
//				/** 2013.04.18 SMS 전송 모듈 추가 **/
		}

		/* 해외 배송시 배송회사 구하기(해외배송일때 배송회사를 알수없어서 추가되어야 할 사항) */
		if ($S_SITE_LNG != "KR" && $strDeliveryMethod)
		{
			$aryDeliveryComList["E"]	= "013";
			$aryDeliveryComList["K"]	= "014";
			$aryDeliveryComList["R"]	= "015";
			$aryDeliveryComList["F"]	= "016";
			$aryDeliveryComList["D"]	= "017";
			$aryDeliveryComList["T"]	= "018";
			$aryDeliveryComList["U"]	= "019";
			$aryDeliveryComList["X"]	= "020";
			$aryDeliveryComList["H"]	= "021";
			$aryDeliveryComList["S"]	= "022";
			$aryDeliveryComList["C01"]	= "023";
			$aryDeliveryComList["C02"]	= "024";
			$aryDeliveryComList["C03"]	= "025";

			$orderMgr->setO_DELIVERY_COM($aryDeliveryComList[$strDeliveryMethod]);
			$orderMgr->getOrderInputDeliveryUpdate($db);
		}

		/* 과세/비과세 적용 */
		$intOrderComplexTax = "N";
		$intOrderTaxTotalAllPrice = $intOrderNoTaxTotalAllPrice = $intOrderAddTaxTotalAllPrice = 0;
		/* 과세/비과세(2013.05.21)*/
		if ($intOrderNoTaxCnt > 0 && $intOrderTaxCnt == 0){
			/* 비과세 상품만 존재할 경우 */
			$intOrderComplexTax				= "Y";									//복합과세여부
			$intOrderTaxTotalAllPrice		= 0;									//과세금액
			$intOrderNoTaxTotalAllPrice		= getPriceToCur($intOrderTotalSPrice);	//비과세금액
			$intOrderAddTaxTotalAllPrice	= 0;									//부가가치세금액
		}
		else if ($intOrderNoTaxCnt > 0 && $intOrderTaxCnt > 0){
			/* 비과세 + 과세 상품만 존재할 경우 */
			$intOrderComplexTax				= "Y";
			/* 부가가치세(총주문금액 - 비과세금액) * 0.1 */
			$intOrderAddTaxTotalAllPrice	= getPriceToCur((getPriceToCur($intOrderTotalSPrice) - $intOrderNoTaxTotalPrice) * 0.1);
			$intOrderTaxTotalAllPrice		= getPriceToCur($intOrderTotalSPrice) - $intOrderNoTaxTotalPrice - $intOrderAddTaxTotalAllPrice;
			$intOrderNoTaxTotalAllPrice		= $intOrderNoTaxTotalPrice;	//비과세금액
		}
		/* 과세/비과세 적용 */

		/* 통관관련정보 UPDATE */
		if ($strOrderShippingNo && $S_ORDER_KOREA_SHIPPING_POLICY_USE == "Y"){
			$orderShippingNoParam					= "";
			$orderShippingNoParam['O_NO']			= $orderMgr->getO_NO();
			$orderShippingNoParam['O_SHIPPING_NO']	= $strOrderShippingNo;
			$orderMgr->getOrderShippingNoUpdate($db,$orderShippingNoParam);
		}


		$result[0][MSG]			= "";
		$result[0][RET]			= "Y";
		$result[0][O_KEY]		= $orderMgr->getO_KEY();
		$result[0][NO]			= $orderMgr->getO_NO(); //주문번호
		$result[0][CART]		= $strOrderCartInfoList;    //주문상품리스트
		$result[0][SETTLE]		= $strO_SETTLE;         //주문결제방법
		$result[0][TITLE]		= $strOrderTitle;
		$result[0][CART_CNT]	= $orderMgr->getO_TOT_QTY();
		$result[0][CART_NO]		= $strOrderCartNoList;

		$result[0][TAX_USE]		= $intOrderComplexTax;
		$result[0][TAX_PRICE]	= $intOrderTaxTotalAllPrice;
		$result[0][NOTAX_PRICE]	= $intOrderNoTaxTotalAllPrice;
		$result[0][ADDTAX_PRICE]= $intOrderAddTaxTotalAllPrice;

		if ($strO_SETTLE == "X"){
			/* 엑심베이 결제일때 */
			$strForSettleCur	= $S_SITE_CUR;
			$strForSettleLang	= $S_SITE_LNG;
			if ($S_SITE_CUR == "IDR" || $S_SITE_CUR == "CNY" || $S_SITE_CUR == "TWD") {
				$strForSettleCur = "USD";
				//$intOrderTotalSPrice = getCurToPrice(getPriceToCur($intOrderTotalSPrice),"US");
				$intOrderTotalSPrice = $intOrderTotalSPriceUsd;
			}
			if ($S_SITE_LNG == "ID" || $S_SITE_LNG == "US") $strForSettleLang = "EN";
			else if ($S_SITE_LNG == "TW") $strForSettleLang = "CN";

			if ($strForSettleLang == "EN"){
				$strEximbayLinkBuf	= $S_EXIMBAY_EN_SECRET_KEY. "?mid=" . $S_EXIMBAY_EN_MID ."&ref=" . $orderMgr->getO_KEY() ."&cur=" .$strForSettleCur ."&amt=" .$intOrderTotalSPrice;
			} else if ($strForSettleLang == "CN"){
				$strEximbayLinkBuf	= $S_EXIMBAY_CN_SECRET_KEY. "?mid=" . $S_EXIMBAY_CN_MID ."&ref=" . $orderMgr->getO_KEY() ."&cur=" .$strForSettleCur ."&amt=" .$intOrderTotalSPrice;
			} else if ($strForSettleLang == "JP"){
				$strEximbayLinkBuf	= $S_EXIMBAY_JP_SECRET_KEY. "?mid=" . $S_EXIMBAY_JP_MID ."&ref=" . $orderMgr->getO_KEY() ."&cur=" .$strForSettleCur ."&amt=" .$intOrderTotalSPrice;
			} else if ($strForSettleLang == "KR"){
				$strEximbayLinkBuf	= $S_EXIMBAY_KR_SECRET_KEY. "?mid=" . $S_EXIMBAY_KR_MID ."&ref=" . $orderMgr->getO_KEY() ."&cur=" .$strForSettleCur ."&amt=" .$intOrderTotalSPrice;
			}
			$strEximbayFgKey	= md5($strEximbayLinkBuf);

			$result[0]['EXIMBAY_FGKEY']		= $strEximbayFgKey;
			$result[0]['EXIMBAY_AMT']		= $intOrderTotalSPrice;
			$result[0]['EXIMBAY_BUYER']		= $strO_J_NAME;
			$result[0]['EXIMBAY_CART']		= $strAllCartNo;
			$result[0]['EXIMBAY_COUPON']	= $strAllCouponUseIssueNoList;
			$result[0]['EXIMBAY_TITLE']		= $strOrderTitle;
		}

		/* 모바일 결제시 상품 삭제시 필요 */
		$_SESSION["MOBILE_PRODUCT_CART"] = $orderMgr->getO_NO().":".$strOrderCartNoList;
		$_SESSION["MOBILE_ORDER_COUPON"] = $orderMgr->getO_NO().":".$strAllCouponUseIssueNoList;

		if ($S_PG == "A"){
			$AGS_HASHDATA = md5($S_PG_SITE_CODE . $orderMgr->getO_KEY() . NUMBER_FORMAT($intOrderTotalSPrice));
			$result[0]['AGS_HASHDATA'] = $AGS_HASHDATA;
		}

		## INIescrow 결제 result 설정
		## 2015.02.16 kim hee sung 소스 정리를 위해 다시 정의 합니다.
		if($S_PG == "I" && in_array($strO_SETTLE, array('C','A','T','M'))):

			## 기본설정
			$strIniMid = $S_PG_SITE_CODE;						// 상점아이디
			$strIniKey = $S_PG_SITE_KEY;						// 상점 키패스워드

			if ( $strO_SETTLE == 'T' )
			{
				$strIniMid = $S_PG_SITE_CODE2 ;						// 상점아이디
				$strIniKey = $S_PG_SITE_KEY2 ;						// 상점 키패스워드
			}
			$intIniPrice = $intOrderTotalSPrice;				// 결제금액

			## 결제모듈 설정
			require("../_INIescrow50/libs/INILib.php");
			$inipay = new INIpay50;

			$inipay->SetField("inipayhome", MALL_SHOP . "_INIescrow50");       // 이니페이 홈디렉터리(상점수정 필요)
			$inipay->SetField("type", "chkfake");								// 고정 (절대 수정 불가)
			$inipay->SetField("debug", "true");									// 로그모드("true"로 설정하면 상세로그가 생성됨.)
			$inipay->SetField("enctype","asym"); 								//asym:비대칭, symm:대칭(현재 asym으로 고정)

			$inipay->SetField("admin", $strIniKey); 							// 키패스워드(키발급시 생성, 상점관리자 패스워드와 상관없음)
			$inipay->SetField("checkopt", "false"); 							//base64함:false, base64안함:true(현재 false로 고정)

			$inipay->SetField("mid", $strIniMid);								// 상점아이디
			$inipay->SetField("price", $intIniPrice);							// 가격
			$inipay->SetField("nointerest", "no");								// 무이자여부(no:일반, yes:무이자)
			$inipay->SetField("quotabase", "선택:일시불:2개월:3개월:4개월:5개월:6개월:7개월:8개월:9개월:10개월:11개월:12개월");	//할부기간

			$inipay->startAction();

			## 결과 설정
			$strResultCode = $inipay->GetResult('ResultCode'); // ("00"이면 지불 성공)
			$strResultMsg = $inipay->GetResult('ResultMsg'); // (지불결과에 대한 설명)

			## euc-kr -> utf-8 으로 변경
			$strResultMsg = iconv("euc-kr","utf-8",$strResultMsg);

			if( $strResultCode != "00" ):

				$result[0][MSG] = "{$strResultMsg} 관리자에게 문의하세요";
				$result[0][RET] = "N";
				$result_array = json_encode($result);
				$db->disConnect();
				echo $result_array;
				exit;

			endif;

			## 세션정보 저장
			$_SESSION['INI_MID']		= $strIniMid;						//상점ID
			$_SESSION['INI_ADMIN']		= $strIniKey;						// 키패스워드(키발급시 생성, 상점관리자 패스워드와 상관없음)
			$_SESSION['INI_PRICE']		= $intIniPrice;						//가격
			$_SESSION['INI_RN']			= $inipay->GetResult("rn");			//고정 (절대 수정 불가)
			$_SESSION['INI_ENCTYPE']	= $inipay->GetResult("encfield");	//고정 (절대 수정 불가)

			## 페이지 전달 데이터
			$result = "";
			$result[0]['MSG']			= "";
			$result[0]['RET']			= "Y";
			$result[0]['SETTLE']		= $strO_SETTLE;					//주문결제방법
			$result[0]['NO']			= $orderMgr->getO_NO();			// 주문번호
			$result[0]['O_KEY']			= $orderMgr->getO_KEY();		// 주문키
			$result[0]['TITLE']			= $orderMgr->getO_J_TITLE();	// 상품명
			$result[0]['NAME']			= $orderMgr->getO_J_NAME();		// 구매자 성명
			$result[0]['MAIL1']			= $orderMgr->getO_J_MAIL();		// 구매자 이메일
			$result[0]['MAIL2']			= $orderMgr->getO_J_MAIL();		// 구매자 보호자 이메일
			$result[0]['HP']			= $orderMgr->getO_J_HP();		// 구매자 휴대폰 설정
			$result[0]['PRICE']			= $intIniPrice;					// 결제금액
			$result[0]['INI_CERTID']	= str_replace ( "\n" , "[[BR]]" , $inipay->GetResult("certid") ) ;				// 구매자 휴대폰 설정
			$result[0]['INI_ENCTYPE']	= str_replace ( "\n" , "[[BR]]" , $_SESSION['INI_ENCTYPE'] ) ;					// 결제금액

		endif;

		$result_array = json_encode($result);
		break;
	case "cartDel":
		$intPB_NO = $intNo;
		$productMgr->setPB_NO($intPB_NO);
		$productMgr->getProductBasketAddDelete($db);
		$productMgr->getProductBasketDelete($db);

		$result[0][MSG]			= "";
		$result[0][RET]			= "Y";

		$result_array = json_encode($result);
		break;

	case "deliveryGroupInfo":
		$orderMgr->setDA_TYPE("G");

		$aryOrderDeliveryGroupInfoList = $orderMgr->getOrderDelvieryGroupInfoList($db);

		if (is_array($aryOrderDeliveryGroupInfoList)){

			for($i=0;$i<sizeof($aryOrderDeliveryGroupInfoList);$i++){

				$result[$aryOrderDeliveryGroupInfoList[$i]["DA_NO"]]["ST_PRICE"]  = $aryOrderDeliveryGroupInfoList[$i][DA_PRICE];
				$result[$aryOrderDeliveryGroupInfoList[$i]["DA_NO"]]["CUR_PRICE"] = getCurToPriceSave($aryOrderDeliveryGroupInfoList[$i][DA_PRICE]);
			}
		}

		$result_array = json_encode($result);
		break;

	case "deliveryWeightInfo":

		if ($S_DELIVERY_FOR_MTH  == "W")
		{
			$orderMgr->setO_DELIVERY_WEIGHT($_REQUEST['prodWeight']);
			$intOrderTotalDeliveryPrice = $orderMgr->getOrderDelvieryAreaPrice($db);

			if ($S_ARY_CUR[$S_SITE_LNG]["USD"][2] == "Y") $result['DELIVERY_PRICE']	= getCurToPriceSave($intOrderTotalDeliveryPrice,"US");
			else $result['DELIVERY_PRICE']	= getCurToPriceSave($intOrderTotalDeliveryPrice);
		} elseif ($S_DELIVERY_FOR_MTH  == "B"){

			$result["E"] = $S_FIX_DELIVERY_FOR_PRICE["E"];
			$result["R"] = $S_FIX_DELIVERY_FOR_PRICE["R"];
			$result["F"] = $S_FIX_DELIVERY_FOR_PRICE["F"];
			$result["D"] = $S_FIX_DELIVERY_FOR_PRICE["D"];
			$result["T"] = $S_FIX_DELIVERY_FOR_PRICE["T"];
			$result["U"] = $S_FIX_DELIVERY_FOR_PRICE["U"];
			$result["X"] = $S_FIX_DELIVERY_FOR_PRICE["X"];
		}

		$result_array = json_encode($result);
		break;

	case "deliveryCountry":
		$aryDeliveryCountry = $orderMgr->getOrderCountryList($db);

		if (is_array($aryDeliveryCountry)){
			for($i=0;$i<sizeof($aryDeliveryCountry);$i++){
				//$result[$aryDeliveryCountry[$i][CT_CODE]] = $aryDeliveryCountry[$i][CT_AREA];

				$result[$aryDeliveryCountry[$i][CT_CODE]][$aryDeliveryCountry[$i][CZ_MTH]] = $aryDeliveryCountry[$i][CZ_ZONE];
			}
		}
		$result_array = json_encode($result);
		break;

	case "deliveryWeightMethod":

		if ($S_DELIVERY_FOR_MTH == "W")
		{
			/* 무게 배송 */
			$orderMgr->setDA_TYPE("W");
			//$orderMgr->setDA_AREA($strCountryAreaCode);
			$orderMgr->setO_B_COUNTRY($strCountryAreaCode);

			$aryDeliveryMethod = $orderMgr->getOrderDeliveryWeightMethodList($db);

			$arySiteDeliveryForComList = explode(",",$S_DELIVERY_FOR_COM);

			$strDeliveryMethodList = "<option value=\"\">:::".$LNG_TRANS_CHAR["OW00044"].":::</option>";
			if (is_array($aryDeliveryMethod)){
				for($i=0;$i<sizeof($aryDeliveryMethod);$i++){

					if (in_array($aryDeliveryMethod[$i][CODE],$arySiteDeliveryForComList)){
						$strDeliveryMethodList .= "<option value=\"".$aryDeliveryMethod[$i][CODE]."\">".$S_ARY_DELIVERY_METHOD[$aryDeliveryMethod[$i][CODE]]."</option>";
					}
				}
			}
		} else if ($S_DELIVERY_FOR_MTH == "T"){
			$strDeliveryMethodList  = "<option value=\"\">:::".$LNG_TRANS_CHAR["OW00044"].":::</option>";
			$strDeliveryMethodList .= "<option value=\"E\">".$LNG_TRANS_CHAR["OW00106"]."</option>";

		} else if ($S_DELIVERY_FOR_MTH == "B"){
			/* 해외 배송회사 배열 선언 */
			$aryDeliveryComList["E"]	= "013";
			$aryDeliveryComList["K"]	= "014";
			$aryDeliveryComList["R"]	= "015";
			$aryDeliveryComList["F"]	= "016";
			$aryDeliveryComList["D"]	= "017";
			$aryDeliveryComList["T"]	= "018";
			$aryDeliveryComList["U"]	= "019";
			$aryDeliveryComList["X"]	= "020";

			/* 기본배송비 정책 */
			$strDeliveryMethodList  = "<option value=\"\">:::".$LNG_TRANS_CHAR["OW00044"].":::</option>";

			$arrForDeliveryMth		= explode(",",$S_DELIVERY_FOR_COM);
			$arrDeliveryComAllList	= getCommCodeList("DELIVERY","Y");

			foreach($arrForDeliveryMth as $key => $val){
				$strDeliveryMethodList .= "<option value=\"".$val."\">".$arrDeliveryComAllList[$aryDeliveryComList[$val]]."</option>";
			}

		}

		$db->disConnect();
		echo $strDeliveryMethodList;
		exit;
		break;


	case "memberDiscount":
	case "orderUsePriceMark":


		/* 회원등급별 주문/결제금액 할인혜택 적용 */
		$result[0][O_TOT_SPRICE]				= 0;
		$result[0][O_TOT_MEM_DISCOUNT_PRICE]	= 0;
		$result[0][O_TOT_MEM_POINT]				= 0;
		$result[0][O_TOT_POINT]					= 0;
		$result[0][O_TOT_DELIVERY_PRICE]		= 0;

		$aryCartNo								= $_POST["cartNo"]			? $_POST["cartNo"]			: $_REQUEST["cartNo"];

		/* 그룹 배송일때 배송비 구하기 */
		if ($S_SITE_LNG == "KR" && $S_DELIVERY_MTH == "G"){
			if ($intDeliveryGroupPriceNo){
				$orderMgr->setDA_NO($intDeliveryGroupPriceNo);
				$intDeliveryGroupPrice	= $orderMgr->getOrderDelvieryInfo($db);
				if (!$intDeliveryGroupPrice) $intDeliveryGroupPrice = 0;
			}
		}

		$intOrderTotalPrice				= 0; //주문금액
		$intOrderTotalQty				= 0; //주문수량
		$intOrderTotalPoint				= 0; //적립포인트
		$intOrderDeliveryTotalPrice		= 0; //주문금액(그룹배송상품금액제외)

		$intOrderTotalPriceCur			= 0; //주문금액(현재통화)
		$intOrderDeliveryTotalPriceCur	= 0; //주문금액(그룹배송상품금액제외)(현재통화)
		$intOrderTotalPriceOrg			= 0;

		for($i=1;$i<=5;$i++){
			$aryDeliveryPrice[$i] = 0;
		}

		if (is_array($aryCartNo)){

			for($i=0;$i<sizeof($aryCartNo);$i++){

				$intOrderPrice = 0;

				if ($aryCartNo[$i] > 0){

					$orderMgr->setPB_NO($aryCartNo[$i]);
					$cartRow = $orderMgr->getOrderBasketView($db);

					if ($cartRow[PB_OPT_NO]){

						$productMgr->setP_CODE($cartRow[P_CODE]);
						$productMgr->setPOA_NO($cartRow[PB_OPT_NO]);
						$aryProdOptAttr = $productMgr->getProdOptAttr($db);

						/* 이벤트 할인가 적용 (2012.09.13) */
						if ($cartRow[P_EVENT_UNIT] && $cartRow[P_EVENT]){
							//$cartRow[PB_PRICE] = getProdEventPrice($cartRow[PB_PRICE],$cartRow[P_EVENT_UNIT],$cartRow[P_EVENT]);
						}

						//$intOrderPrice      = ($cartRow[PB_PRICE] * $cartRow[PB_QTY]);
						$intOrderPrice		= getProdDiscountPrice($cartRow,"3",$cartRow['PB_PRICE']); //할인가격 확인

						/* 통합수량할인적용 */
						if ($S_ALL_DISCOUNT_USE == "Y"){
							$intOrderPrice	= getProdAllDiscount($intOrderPrice,$cartRow[PB_QTY]);
						}

						## 현재통화상품금액
						if ($S_ARY_CUR[$S_SITE_LNG]["USD"][2] == "Y") $intOrderPriceCur	= (getCurToPriceSave($intOrderPrice,"US") * $cartRow[PB_QTY]);
						else $intOrderPriceCur = (getCurToPriceSave($intOrderPrice) * $cartRow[PB_QTY]);
						$intOrderPriceOrg	=  (getCurToPriceSave($intOrderPrice) * $cartRow[PB_QTY]);

						$intOrderPrice      = ($intOrderPrice * $cartRow[PB_QTY]);
						$intProdPoint		= ($aryProdOptAttr[0]['POA_POINT']) ? $aryProdOptAttr[0]['POA_POINT'] : $cartRow[P_POINT];
						$intOrderPoint		= (getProdPoint($intOrderPrice, $intProdPoint, $cartRow[P_POINT_TYPE], $cartRow[P_POINT_OFF1], $cartRow[P_POINT_OFF2])* $cartRow[PB_QTY]);

						/* 상품 포인트를 특정 그룹에만 부여한다.(2013.08.22 : 애협) */
						if (is_array($S_FIX_PROD_POINT_VIEW_SPEC_GROUP_LIST)){
							if (!$g_member_login || !in_array($g_member_group,$S_FIX_PROD_POINT_VIEW_SPEC_GROUP_LIST)){
								$intOrderPoint= 0;
							}
						}


						$intOrderTotalPrice		= $intOrderTotalPrice		+ ($intOrderPrice);
						$intOrderTotalQty		= $intOrderTotalQty			+ $cartRow[PB_QTY];
						$intOrderTotalPoint		= $intOrderTotalPoint		+ $intOrderPoint;

						$intOrderTotalPriceCur	= $intOrderTotalPriceCur	+ $intOrderPriceCur; //현재통화
						$intOrderTotalPriceOrg	= $intOrderTotalPriceOrg	+ $intOrderPriceOrg;

						//배송비 그룹 배송이고 무료 배송이 아니면
						if ($S_SITE_LNG == "KR" && $S_DELIVERY_MTH == "G" && $cartRow[P_BAESONG_TYPE] != "2"){
							$intOrderDeliveryTotalPrice		= $intOrderDeliveryTotalPrice + ($cartRow[PB_PRICE] * $cartRow[PB_QTY]);
							$intOrderDeliveryTotalPriceCur  = $intOrderDeliveryTotalPriceCur + ($cartRow['PB_PRICE'] * $cartRow['PB_QTY']); //현지통화

						}

					} else {

						/* 이벤트 할인가 적용 (2012.09.13) */
						if ($cartRow[P_EVENT_UNIT] && $cartRow[P_EVENT]){
							//$cartRow[P_SALE_PRICE] = getProdEventPrice($cartRow[P_SALE_PRICE],$cartRow[P_EVENT_UNIT],$cartRow[P_EVENT]);
						}

						//$intOrderPrice     = ($cartRow[P_SALE_PRICE] * $cartRow[PB_QTY]);
						$intOrderPrice		= getProdDiscountPrice($cartRow,"3",$cartRow['P_SALE_PRICE']);
						/* 통합수량할인적용 */
						if ($S_ALL_DISCOUNT_USE == "Y"){
							$intOrderPrice	= getProdAllDiscount($intOrderPrice,$cartRow[PB_QTY]);
						}

						/* 경매 상품 여부 확인 */
						if ($S_PRODUCT_AUCTION_USE == "Y"){
							$auctionParam				= "";
							$auctionParam['P_CODE']		= $cartRow[P_CODE];
							$prodAucRow					= $productMgr->getProdAuctionView($db,$auctionParam);

							if ((in_array($prodAucRow['P_AUC_STATUS'],array("2","4","5"))) && $prodAucRow['P_AUC_ORDER'] != "Y"){
								$intOrderPrice			= $cartRow['PB_PRICE'];
							}
						}

						## 현재통화상품금액
						if ($S_ARY_CUR[$S_SITE_LNG]["USD"][2] == "Y") $intOrderPriceCur	= (getCurToPriceSave($intOrderPrice,"US") * $cartRow[PB_QTY]);
						else $intOrderPriceCur = (getCurToPriceSave($intOrderPrice) * $cartRow[PB_QTY]);
						$intOrderPriceOrg	=  (getCurToPriceSave($intOrderPrice) * $cartRow[PB_QTY]);

						$intOrderPrice      = ($intOrderPrice * $cartRow[PB_QTY]);
						$intOrderPoint		= (getProdPoint($intOrderPrice, $cartRow[P_POINT], $cartRow[P_POINT_TYPE], $cartRow[P_POINT_OFF1], $cartRow[P_POINT_OFF2])* $cartRow[PB_QTY]);

						/* 상품 포인트를 특정 그룹에만 부여한다.(2013.08.22 : 애협) */
						if (is_array($S_FIX_PROD_POINT_VIEW_SPEC_GROUP_LIST)){
							if (!$g_member_login || !in_array($g_member_group,$S_FIX_PROD_POINT_VIEW_SPEC_GROUP_LIST)){
								$intOrderPoint= 0;
							}
						}

						$intOrderTotalPrice		= $intOrderTotalPrice + $intOrderPrice;
						$intOrderTotalQty		= $intOrderTotalQty + $cartRow[PB_QTY];
						$intOrderTotalPoint		= $intOrderTotalPoint + $intOrderPoint;

						$intOrderTotalPriceCur	= $intOrderTotalPriceCur	+ $intOrderPriceCur; //현재통화
						$intOrderTotalPriceOrg	= $intOrderTotalPriceOrg	+ $intOrderPriceOrg;

						if ($S_SITE_LNG == "KR" && $S_DELIVERY_MTH == "G" && $cartRow[P_BAESONG_TYPE] != "2"){
							$intOrderDeliveryTotalPrice		= $intOrderDeliveryTotalPrice + ($cartRow[P_SALE_PRICE] * $cartRow[PB_QTY]);

							$intOrderDeliveryTotalPriceCur  = $intOrderDeliveryTotalPriceCur + ($cartRow['P_SALE_PRICE'] * $cartRow['PB_QTY']); //현지통화
						}
					}

					/* 해외배송 : 수량별배송을 사용할 경우 맨처음 주문 상품의 배송비에 기본배송비를 더하기 위해 CART_COUNT를 배열 삽입 */
					if ($S_SITE_LNG != "KR"){
						if ($S_DELIVERY_FOR_MTH == "B"){
							if ($cartRow['P_BAESONG_TYPE'] == "4"){
								$cartRow['CART_COUNT'] = $i + 1;
							}
						}
					}

					/* 배송비설정*/
					$intDeliveryPrice = getProdDeliveryPrice($cartRow,$SHOP_ARY_DELIVERY,$intOrderPrice,$cartRow[PB_QTY]);
					if($S_SITE_LNG == "KR"){
						/* 고정배송비일경우 옵션/수량/금액에 상관없이 무조건 고정배송비 */
						if ($cartRow['P_BAESONG_TYPE'] == "3"){
							if (is_array($aryDeliveryFixProduct)) {
								if (!in_array($cartRow[P_CODE],$aryDeliveryFixProduct)) {
									$aryDeliveryFixProduct = array_push($aryDeliveryFixProduct, $cartRow[P_CODE]);
								} else {
									$intDeliveryPrice = 0;
								}
							} else $aryDeliveryFixProduct = array($cartRow[P_CODE]);
						}
					}
					$aryDeliveryPrice[$cartRow[P_BAESONG_TYPE]] += $intDeliveryPrice;


					/* 배송비 (무게) 설정 */
					$intProdWeight = ($cartRow[P_WEIGHT]) ? $cartRow[P_WEIGHT] : "0";
					$intOrderProdWeight += ($intProdWeight * $cartRow[PB_QTY]);
					/* 배송비 (무게) 설정 */

					/* 상품 추가옵션 확인*/
					$productMgr->setP_CODE($cartRow[P_CODE]);
					$productMgr->setPB_NO($cartRow[PB_NO]);
					$aryProdAddAttrOpt = $productMgr->getProdBasketAddList($db);

					if (is_array($aryProdAddAttrOpt)){
						for($j=0;$j<sizeof($aryProdAddAttrOpt);$j++){

							if ($aryProdAddAttrOpt[$j][PBA_NO] > 0)
							{
								$productMgr->setP_CODE($cartRow[P_CODE]);
								$productMgr->setPAO_NO($aryProdAddAttrOpt[$j][PBA_OPT_NO]);
								$aryProdAddOptAttr = $productMgr->getProdAddOpt($db);

								$intOrderTotalPrice		= $intOrderTotalPrice + ($aryProdAddOptAttr[0][PAO_PRICE] * $aryProdAddAttrOpt[$j][PBA_OPT_QTY]);

								if ($S_ARY_CUR[$S_SITE_LNG]["USD"][2] == "Y"){
									$intOrderTotalPriceCur	= $intOrderTotalPriceCur + (getCurToPriceSave($aryProdAddOptAttr[0][PAO_PRICE],"US") * $aryProdAddAttrOpt[$j][PBA_OPT_QTY]); //현지통화
								} else {
									$intOrderTotalPriceCur	= $intOrderTotalPriceCur + (getCurToPriceSave($aryProdAddOptAttr[0][PAO_PRICE]) * $aryProdAddAttrOpt[$j][PBA_OPT_QTY]); //현지통화
								}

								/* 추가옵션도 재고 관리가 되어야 함 */
							}
						}
					}

					$strAllCartNo .= $aryCartNo[$i].",";
				}
			}
		}

		if ($strAllCartNo) {
			$strAllCartNo = SUBSTR($strAllCartNo,0,STRLEN($strAllCartNo)-1);
		}

		/* 총주문의 상품가격합의 DISCOUNT 설정(bejewel)*/
		if ($S_FIX_ORDER_TOTAL_DISCOUNT_USE == "Y"){
			$discountParam						= "";
			$discountParam['PROD_TOTAL_PRICE']	= $intOrderTotalPrice;
			$intOrderPriceDiscountRate			= $productMgr->getProdTotalPriceMaxDiscountRate($db,$discountParam);
			$intOrderPriceDiscountPrice			= getProdTotalPriceAllDiscount($intOrderTotalPrice,$intOrderPriceDiscountRate);

			if ($intOrderPriceDiscountPrice > 0){
				$intOrderTotalPrice				= $intOrderTotalPrice		- $intOrderPriceDiscountPrice;
				$intOrderTotalPriceCur			= $intOrderTotalPriceCur	- getCurToPriceSave($intOrderPriceDiscountPrice);
			}
		}

		/* 배송비 구하기 (프로그램 다시 적용)*/
		$intOrderTotalDeliveryPrice = 0;

		if ($S_MALL_TYPE == "R") {

			$intOrderTotalDeliveryPrice = getCartDeliveryPrice($aryDeliveryPrice,$intOrderTotalPrice,$SHOP_ARY_DELIVERY);
			if ($S_SITE_LNG == "KR" && $S_DELIVERY_MTH == "G"){
				$intOrderTotalDeliveryPrice = $intOrderTotalDeliveryPrice + $intDeliveryGroupPrice;
			}

		} else {

			/* 입점몰 프랜차이즈 일때 (KR) */
			if ($S_SITE_LNG == "KR"){
				$productMgr->setPB_ALL_NO($strAllCartNo);

				$aryProdBasketShopList = $productMgr->getProdBasketShopList($db);
				$intOrderTotalDeliveryPrice = 0;
				$aryDeliveryFixProduct = "";
				if (is_array($aryProdBasketShopList)){
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

							if($S_SITE_LNG == "KR"){
								/* 고정배송비일경우 옵션/수량/금액에 상관없이 무조건 고정배송비 */
								if ($prodBasketRow['P_BAESONG_TYPE'] == "3"){
									if (is_array($aryDeliveryFixProduct)) {
										if (!in_array($prodBasketRow[P_CODE],$aryDeliveryFixProduct)) {
											$aryDeliveryFixProduct = array_push($aryDeliveryFixProduct, $prodBasketRow[P_CODE]);
										} else {
											$intProdBasketDeliveryPrice = 0;
										}
									} else $aryDeliveryFixProduct = array($prodBasketRow[P_CODE]);
								}
							}

							$aryDeliveryPrice[$prodBasketRow[P_BAESONG_TYPE]] += $intProdBasketDeliveryPrice;
						}

						$intProdBasketShopDeliveryTotal = getCartDeliveryPrice($aryDeliveryPrice,$value[BASKET_PRICE],$SHOP_ARY_DELIVERY,$value);
						$aryProdBasketShopList[$key][DELIVERY_PRICE] = $intProdBasketShopDeliveryTotal;
						$intOrderTotalDeliveryPrice = $intOrderTotalDeliveryPrice + $intProdBasketShopDeliveryTotal;
					}
				}
			}
		}

		/* 배송가격이 무게이고 무료배송 상품 총 가격보다 작을때(무게 및 기본배송)*/
		if ($S_SITE_LNG != "KR"){

			if ($S_DELIVERY_FOR_MTH == "W"){
				$intOrderTotalDeliveryPrice = 0;
				$intOrderTotalDeliveryPrice = getCartDeliveryPrice($aryDeliveryPrice,$intOrderTotalPrice,$SHOP_ARY_DELIVERY);
				if ($intOrderTotalDeliveryPrice > 0){
					$orderMgr->setO_DELIVERY_WEIGHT($intOrderProdWeight);
					$intOrderTotalDeliveryPrice = $orderMgr->getOrderDelvieryAreaPrice($db);
				}
			}

			if ($S_DELIVERY_FOR_MTH == "B"){
				$intOrderTotalDeliveryPrice = getCartDeliveryPrice($aryDeliveryPrice,$intOrderTotalPrice,$SHOP_ARY_DELIVERY);
				if ($intOrderTotalDeliveryPrice >= 0){
					$intOrderTotalDeliveryPrice = $intOrderTotalDeliveryPrice + $S_FIX_DELIVERY_FOR_PRICE[$strDeliveryMethod];
				}
			}

			if ($S_DELIVERY_FOR_MTH == "N"){
				$intOrderTotalDeliveryPrice = 0;
			}
		}


		/* 쿠폰 금액 구하기 */
		/*$intO_USE_COUPON = 0;
        if ($strO_USE_COUPON_NUM){
            $intO_USE_COUPON = 0;
        }*/

		if ($intO_USE_COUPON > 0 && is_array($aryCouponUseIssueNo)){
		}

		/* 과세/비과세 */
		$intOrderTaxTotal = 0;
		$intOrderTaxTotalCur = 0;
		if ($S_SITE_TAX == "Y"){
			$intOrderTaxTotal		= ($intOrderTotalPrice * 0.1);
			$intOrderTaxTotalCur	= ($intOrderTotalPriceCur * 0.1);
		}

		/* PG사 결제시 수수료 부여 */
		$intOrderPgCommissionTotal = 0;
		if ($S_PG_COMMISSION == "Y"){
			if ($S_PG_CARD_COMMISSION > 0){
				/* 엑심베이 결제/한국PG사의 카드 결제 */
				if ($strO_SETTLE == "X" || $strO_SETTLE == "C"){
					if ($S_SITE_LNG == "KR") $intOrderPgCommissionTotal = getRoundWonUp(($intOrderTotalPrice * $S_PG_CARD_COMMISSION/100));
					else $intOrderPgCommissionTotal = getRoundUp(($intOrderTotalPrice * $S_PG_CARD_COMMISSION/100),2);
				}
			}
		}

		/* 총결제금액확인(총주문금액 - (사용포인트 + 사용쿠폰금액) + 배송비 + PG사 결제 수수료) */
		//$intOrderTotalSPrice	= getCurToPriceSave($intOrderTotalPrice)		 + getCurToPriceSave($intOrderTaxTotal);
		//$intOrderTotalSPrice   += getCurToPriceSave($intOrderTotalDeliveryPrice) + getCurToPriceSave($intOrderPgCommissionTotal) - ($intO_USE_POINT + $intO_USE_COUPON) ;

		//$intOrderTotalOrgSPrice	= ($intOrderTotalPrice + $intOrderTaxTotal + $intOrderTotalDeliveryPrice + $intOrderPgCommissionTotal) - getCurToPriceSave($intO_USE_POINT + $intO_USE_COUPON,$S_ST_CUR) ;
		//$intO_USE_POINT = settype($intO_USE_POINT,"REAL");
		## 현재통화
		$intOrderTotalSPrice	= $intOrderTotalPriceCur + $intOrderTaxTotalCur + getCurToPriceSave($intOrderTotalDeliveryPrice + $intOrderPgCommissionTotal);
		$intOrderTotalSPrice    = $intOrderTotalSPrice - ($intO_USE_POINT + $intO_USE_COUPON);

		## 기준통화
		$intOrderTotalOrgSPrice	= ($intOrderTotalPrice + $intOrderTaxTotal + $intOrderTotalDeliveryPrice + $intOrderPgCommissionTotal);
		$intOrderTotalOrgSPrice = $intOrderTotalOrgSPrice - getCurToPriceSave($intO_USE_POINT + $intO_USE_COUPON,$S_ST_CUR);

		if ($S_ARY_CUR[$S_SITE_LNG]["USD"][2] == "Y"){
			$intOrderTotalSPrice	= $intOrderTotalPriceCur + $intOrderTaxTotalCur + getCurToPriceSave($intOrderTotalDeliveryPrice,"US") + getCurToPriceSave($intOrderPgCommissionTotal,"US") - ($intO_USE_POINT + $intO_USE_COUPON);
		}

		/* 회원등급별 할인혜택 */
		$intMemberGradeDiscountPrice = $intMemberGradeAddPoint = 0;
		if(($g_member_login && $g_member_no) && ($S_MEMBER_GROUP[$g_member_group]["DISCOUNT_ST"] != "1")){

			/* 등급기준 : 주문금액 */
			$intMemberGradeOrderTotalPrice = 0;
			if ($S_MEMBER_GROUP[$g_member_group]["PRICE_ST"] == "P"){
				$intMemberGradeOrderTotalPrice = $intOrderTotalPrice + $intOrderTaxTotal + $intOrderTotalDeliveryPrice + $intOrderPgCommissionTotal; //총주문금액 : 기준통화
			}

			if ($S_MEMBER_GROUP[$g_member_group]["PRICE_ST"] == "S"){
				$intMemberGradeOrderTotalPrice = getPriceToCur($intOrderTotalSPrice); //총결제금액 : 기준통화
			}

			/* 추가할인 */
			if ($S_MEMBER_GROUP[$g_member_group]["DISCOUNT_ST"] == "2" || $S_MEMBER_GROUP[$g_member_group]["DISCOUNT_ST"] == "4"){
				if ($intMemberGradeOrderTotalPrice >= $S_MEMBER_GROUP[$g_member_group]["DISCOUNT_PRICE"]){

					/* 할인혜택 단위 - % */
					if ($S_MEMBER_GROUP[$g_member_group]["DISCOUNT_UNIT"] == "1"){
						//$intMemberGradeDiscountPrice = (getPriceToCur($intOrderTotalSPrice) * ($S_MEMBER_GROUP[$g_member_group]["DISCOUNT_RATE"]/100));
						$intMemberGradeDiscountPrice = ($intMemberGradeOrderTotalPrice * ($S_MEMBER_GROUP[$g_member_group]["DISCOUNT_RATE"]/100));
					}

					/* 할인혜택 단위 - 원 */
					if ($S_MEMBER_GROUP[$g_member_group]["DISCOUNT_UNIT"] == "2"){
						$intMemberGradeDiscountPrice = $S_MEMBER_GROUP[$g_member_group]["DISCOUNT_RATE"];
					}

					/* 할인혜택 단위 (절삭)*/
					if ($S_MEMBER_GROUP[$g_member_group]["DISCOUNT_OFF"] == 1) {
						if (!$S_MEMBER_GROUP[$g_member_group]["DISCOUNT_POINT"]) $S_MEMBER_GROUP[$g_member_group]["DISCOUNT_POINT"] = "1";

						if ($S_ST_CUR == "KRW") {
							$intMemberGradeDiscountPrice = getTruncateDown($intMemberGradeDiscountPrice,$S_MEMBER_GROUP[$g_member_group]["DISCOUNT_POINT"]);
						} else {
							$intMemberGradeDiscountPrice = getTruncateDown($intMemberGradeDiscountPrice,-$S_MEMBER_GROUP[$g_member_group]["DISCOUNT_POINT"]);
						}
					}

					/* 할인혜택 단위 (반올림)*/
					if ($S_MEMBER_GROUP[$g_member_group]["DISCOUNT_OFF"] == 2) {
						if (!$S_MEMBER_GROUP[$g_member_group]["DISCOUNT_POINT"]) $S_MEMBER_GROUP[$g_member_group]["DISCOUNT_POINT"] = "1";
						if ($S_ST_CUR == "KRW") {
							$intMemberGradeDiscountPrice = round($intMemberGradeDiscountPrice,-$S_MEMBER_GROUP[$g_member_group]["DISCOUNT_POINT"]);
						} else {
							$intMemberGradeDiscountPrice = round($intMemberGradeDiscountPrice,$S_MEMBER_GROUP[$g_member_group]["DISCOUNT_POINT"]);
						}
					}
				}
			}

			/* 추가포인트 적립 */
			if ($S_MEMBER_GROUP[$g_member_group]["DISCOUNT_ST"] == "3" || $S_MEMBER_GROUP[$g_member_group]["DISCOUNT_ST"] == "4"){
				if ($intMemberGradeOrderTotalPrice >= $S_MEMBER_GROUP[$g_member_group]["POINT_PRICE"]){

					/* 추가포인트 단위 - % */
					if ($S_MEMBER_GROUP[$g_member_group]["POINT_UNIT"] == "1"){
						$intMemberGradeAddPoint = ($intMemberGradeOrderTotalPrice) * ($S_MEMBER_GROUP[$g_member_group]["POINT_RATE"]/100);
					}

					/* 추가포인트 단위 - 원 */
					if ($S_MEMBER_GROUP[$g_member_group]["POINT_UNIT"] == "2"){
						$intMemberGradeAddPoint = $S_MEMBER_GROUP[$g_member_group]["POINT_RATE"];
					}

					/* 추가포인트 단위 (절삭)*/
					if ($S_MEMBER_GROUP[$g_member_group]["POINT_OFF"] == 1) {
						if (!$S_MEMBER_GROUP[$g_member_group]["POINT_POINT"]) $S_MEMBER_GROUP[$g_member_group]["POINT_POINT"] = "0";
						if ($S_ST_CUR == "KRW") {
							$intMemberGradeAddPoint = getTruncateDown($intMemberGradeAddPoint,$S_MEMBER_GROUP[$g_member_group]["POINT_POINT"]);
						} else {
							$intMemberGradeAddPoint = getTruncateDown($intMemberGradeAddPoint,-$S_MEMBER_GROUP[$g_member_group]["POINT_POINT"]);
						}
					}

					/* 추가포인트 단위 (반올림)*/
					if ($S_MEMBER_GROUP[$g_member_group]["POINT_OFF"] == 2) {
						if (!$S_MEMBER_GROUP[$g_member_group]["POINT_POINT"]) $S_MEMBER_GROUP[$g_member_group]["POINT_POINT"] = "0";
						if ($S_ST_CUR == "KRW") {
							$intMemberGradeAddPoint = round($intMemberGradeAddPoint,-$S_MEMBER_GROUP[$g_member_group]["POINT_POINT"]);
						} else {
							$intMemberGradeAddPoint = round($intMemberGradeAddPoint,$S_MEMBER_GROUP[$g_member_group]["POINT_POINT"]);
						}
					}
				}
			}
		}

		/* 총결제금액 - 회원등급별 추가 할인금액 */
		if ($intMemberGradeDiscountPrice > 0) {
			$intOrderTotalOrgSPrice = $intOrderTotalOrgSPrice - $intMemberGradeDiscountPrice;

			if ($S_ARY_CUR[$S_SITE_LNG]["USD"][2] == "Y"){
				$intOrderTotalSPrice	= $intOrderTotalSPrice - getCurToPriceSave($intMemberGradeDiscountPrice,"US");
			} else {
				$intOrderTotalSPrice	= $intOrderTotalSPrice - getCurToPriceSave($intMemberGradeDiscountPrice);
			}
		}

		/* 적립금 지급 기준에 따른 포인트 */
		if ($S_POINT_USE1 == "Y") {

			if ($S_POINT_ST == "P") {
				/* 판매가 기준 */
				if ($intOrderTotalPrice < $S_POINT_ST_PRICE){
					$intOrderTotalPoint = 0;
				}
			} else {
				/* 결제가격 기준/ 결제방법이 포인트가 아니면 */
				if ($strO_SETTLE != "P"){
					if (getPriceToCur($intOrderTotalSPrice) < $S_POINT_ST_PRICE){
						$intOrderTotalPoint = 0;
					}
				} else {
					$intOrderTotalPoint = 0;
				}
			}

			/* 적립금을 사용한 주문은 상품적립금을 지금하지 않음 */
			if ($intO_USE_POINT > 0 && $S_POINT_USE2 == "N") {
				$intOrderTotalPoint = 0;
			}
		} else {
			/* 적림금 관리를 사용하지 않음 */
			$intOrderTotalPoint = 0;
		}

		/* 쿠폰사용금액이 있을 경우 적립금 사용유무 */
		if (getPriceToCur($intO_USE_COUPON) > 0 && $S_POINT_COUPON_USE == "Y"){
			$intOrderTotalPoint = 0;
		}

		/* 회원 등급별 추가 적립금 지급 */
		if ($intMemberGradeAddPoint > 0) {
			$intOrderTotalPoint = $intOrderTotalPoint + $intMemberGradeAddPoint;
		}

		if ($strAct == "orderUsePriceMark"){
			$result[0][O_TOT_MEM_DISCOUNT_PRICE]	= getCurToPriceSave($intMemberGradeDiscountPrice,"US");
			$result[0][O_TOT_MEM_POINT]				= getCurToPriceSave($intMemberGradeAddPoint,"US");
			$result[0][O_TOT_POINT]					= getCurToPriceSave($intOrderTotalPoint,"US");
			$result[0][O_TOT_DELIVERY_PRICE]		= getCurToPriceSave($intOrderTotalDeliveryPrice,"US");
			$result[0][O_TOT_TAX]					= getCurToPriceSave($intOrderTaxTotal,"US");
			$result[0][O_TOT_PG_COMMISSION]			= getCurToPriceSave($intOrderPgCommissionTotal,"US");

			$result[0][O_TOT_PRICE]					= $intOrderTotalPriceCur;
			$result[0][O_TOT_SPRICE]				= $intOrderTotalSPrice;

			$intOrderTotalOrgSPrice					= $intOrderTotalPriceOrg + getCurToPriceSave($intOrderTaxTotal);
			$intOrderTotalOrgSPrice					= $intOrderTotalOrgSPrice + getCurToPriceSave($intOrderTotalDeliveryPrice);
			$intOrderTotalOrgSPrice					= $intOrderTotalOrgSPrice + getCurToPriceSave($intOrderPgCommissionTotal);
			$intOrderTotalOrgSPrice					= $intOrderTotalOrgSPrice - getCurToPriceSave($intMemberGradeDiscountPrice);
			$intOrderTotalOrgSPrice					= $intOrderTotalOrgSPrice - getCurToPriceSave(getPriceToCur($intO_USE_POINT));
			$intOrderTotalOrgSPrice					= $intOrderTotalOrgSPrice - getCurToPriceSave(getPriceToCur($intO_USE_COUPON));

			if ($intOrderTotalSPrice == 0) $intOrderTotalOrgSPrice = 0;
			$result[0][O_TOT_SPRICE_ORG]			= $intOrderTotalOrgSPrice;
			$result[0][O_TOT_DELIVERY_PRICE_ORG]	= getCurToPriceSave($intOrderTotalDeliveryPrice);

			$intOrderTotalFirstPrice				= $intOrderTotalPriceCur + getCurToPriceSave($intOrderTaxTotal,"US") + getCurToPriceSave($intOrderPgCommissionTotal,"US");
			$result[0][O_TOT_FIRST_PRICE]			= $intOrderTotalFirstPrice;		//기준통화(상품총금액 + 세금 + PG커미션)

		} else{

			$result[0][O_TOT_PRICE]					= $intOrderTotalPriceCur;	//현재통화의 상품가격
			$result[0][O_TOT_SPRICE]				= $intOrderTotalSPrice;
			$result[0][O_TOT_MEM_DISCOUNT_PRICE]	= getCurToPriceSave($intMemberGradeDiscountPrice);
			$result[0][O_TOT_MEM_POINT]				= getCurToPriceSave($intMemberGradeAddPoint);
			$result[0][O_TOT_POINT]					= getCurToPriceSave($intOrderTotalPoint);
			$result[0][O_TOT_DELIVERY_PRICE]		= getCurToPriceSave($intOrderTotalDeliveryPrice);
			$result[0][O_TOT_TAX]					= getCurToPriceSave($intOrderTaxTotal);
			$result[0][O_TOT_PG_COMMISSION]			= getCurToPriceSave($intOrderPgCommissionTotal);

			$result[0][O_TOT_SPRICE_ORG]			= getCurToPriceSave($intOrderTotalOrgSPrice);		//기준통화 결제금액
			$result[0][O_TOT_DELIVERY_PRICE_ORG]	= getCurToPriceSave($intOrderTotalDeliveryPrice);	//기준통화 배송비

			$intOrderTotalFirstPrice				= $intOrderTotalPriceCur + $intOrderTaxTotalCur + getCurToPriceSave($intOrderPgCommissionTotal);
			$result[0][O_TOT_FIRST_PRICE]			= $intOrderTotalFirstPrice;		//기준통화(상품총금액 + 세금 + PG커미션)
		}

		$result_array = json_encode($result);
		break;

	case "couponCodeCheck":
		/* 쿠폰코드로 쿠폰확인하기 */
		$orderMgr->setCOUPON_CODE($strCouponCode);
		$orderMgr->setM_NO($g_member_no);
		$couponRow = $orderMgr->getOrderCouponCodeCheck($db);

		if ($couponRow){
			if ($couponRow[CI_USE] == "Y"){
				$result[0]["RET"]	 = "N";
				$result[0]["MSG"]	 = $LNG_TRANS_CHAR["OS00052"]; //이미 사용된 쿠폰입니다.
				$result_array = json_encode($result);
				$db->disConnect();
				echo $result_array;
				exit;
			}

			if (date("Y-m-d H:i:s") < $couponRow[CI_START_DT] || ($couponRow[CI_END_DT] != "" && date("Y-m-d H:i:s") > $couponRow[CI_END_DT])){
				$result[0]["RET"]	 = "N";
				$result[0]["MSG"]	 = $LNG_TRANS_CHAR["OS00053"]; //사용기간이 지난 쿠폰입니다.
				$result_array = json_encode($result);
				$db->disConnect();
				echo $result_array;
				exit;
			}

			$orderMgr->setCOUPON_NO($couponRow[CU_NO]);
			$couponInfoRow = $orderMgr->getCouponView($db);


			$intCouponPrice				= "";
			if ($couponInfoRow[CU_PRICE_OFF] == "1") $intCouponPrice = NUMBER_FORMAT($couponInfoRow[CU_PRICE])."%";
			else {
				if ($S_ARY_CUR[$S_SITE_LNG]["USD"][2] == "Y"){
					$intCouponPrice = getCurMark2("USD")." ".getCurToPrice($couponInfoRow[CU_PRICE]);
				} else {
					$intCouponPrice = getCurMark()." ".getCurToPrice($couponInfoRow[CU_PRICE]).getCurMark2();
				}
			}
			$result[0]["RET"]			= "Y";
			$result[0]["CI_NO"]			= $couponRow[CI_NO];
			$result[0]["COUPON_NAME"]	= $couponInfoRow[CU_NAME];
			$result[0]["COUPON_CODE"]	= $couponRow[CI_CODE];
			$result[0]["COUPON_PRICE"]	= $intCouponPrice;
			$result[0]["COUPON_GIGAN"]	= SUBSTR($couponRow[CI_START_DT],0,10)." ~ ".SUBSTR($couponRow[CI_END_DT],0,10);
			$result_array = json_encode($result);

		} else {
			$result[0]["RET"]	 = "N";
			$result[0]["MSG"]	 = $LNG_TRANS_CHAR["OS00051"]; //쿠폰이 존재하지 않습니다.쿠폰번호를 다시 확인해주세요.
			$result_array = json_encode($result);
		}
		break;

	case "couponInfo":
		$orderMgr->setCOUPON_ISSUE_NO($intCouponIssueNo);
		$aryCouponInfoList = $orderMgr->getOrderCouponList($db,"O");

		if (is_array($aryCouponInfoList))
		{

			$result[0]["COUPON_USE_EXP_CNT"]	= 0;
			$result[0]["COUPON_ERR_MSG2"]		= "";
			$result[0]["COUPON_USE"]			= $aryCouponInfoList[0][CU_USE];

			/* 특정 카테고리/상품 사용유무 확인 */
			if ($aryCouponInfoList[0][CU_USE] == "2" || $aryCouponInfoList[0][CU_USE] == "3"){

				$orderMgr->setCOUPON_NO($aryCouponInfoList[0][CU_NO]);
				$orderMgr->setCOUPON_USE($aryCouponInfoList[0][CU_USE]);

				$strPB_NO_LIST = "";
				for($i=0;$i<sizeof($intPB_NO);$i++){
					$strPB_NO_LIST .= $intPB_NO[$i].",";
				}

				if ($strPB_NO_LIST) {
					$strPB_NO_LIST = SUBSTR($strPB_NO_LIST,0,STRLEN($strPB_NO_LIST)-1);
					$orderMgr->setPB_ALL_NO($strPB_NO_LIST);
					$intCouponUseExpCnt = $orderMgr->getCouponExpUseCodeList($db);
					$result[0]["COUPON_USE_EXP_CNT"]	= $intCouponUseExpCnt;
					$result[0]["COUPON_ERR_MSG2"]		= $LNG_TRANS_CHAR["OS00056"];
				}
			}

			$intCouponLimitPrice				= getCurToPriceSave($aryCouponInfoList[0][CU_LIMIT_PRICE]);
			if ($S_ARY_CUR[$S_SITE_LNG]["USD"][2] == "Y"){
				$intCouponLimitPrice			= getCurToPriceSave($aryCouponInfoList[0][CU_LIMIT_PRICE],"US");
			}

			$result[0]["CI_NO"]					= $aryCouponInfoList[0][CI_NO];
			$result[0]["COUPON_LIMIT_PRICE"]	= $intCouponLimitPrice;
			$result[0]["COUPON_LIMIT_SETTLE"]	= $aryCouponInfoList[0][CU_LIMIT_SETTLE];
			$result[0]["COUPON_ERR_MSG1"]		= callLangTrans($LNG_TRANS_CHAR['OS00055'],array(getFormatPrice($intCouponLimitPrice,2)));



			/* 쿠폰 금액 확인 */
			/*
            $intCouponPrice	= getCurToPriceSave($aryCouponInfoList[0][CU_PRICE]);
            if ($S_ARY_CUR[$S_SITE_LNG]["USD"][2] == "Y"){
                $intCouponPrice = getCurToPriceSave($aryCouponInfoList[0][CU_PRICE],"US");
            }
            if ($aryCouponInfoList[0][CU_PRICE_OFF] == "1") {
                $intCouponPrice = getCurToPriceSave($aryCouponInfoList[0][CU_PRICE]);
                if ($S_ARY_CUR[$S_SITE_LNG]["USD"][2] == "Y"){
                    $intCouponPrice = getCurToPriceSave($aryCouponInfoList[0][CU_PRICE],"US");
                }

                    //$intOrderTotalPrice	= getPriceToCur($_POST["orderTotalPrice"]);

                $intCouponPrice		= getFormatPrice(getRoundUp($intOrderTotalPrice * ($intCouponPrice/100),2),2);
            }
            */

			// 쿠폰이 전체 적용처리되는 로직이다.
			// 쿠폰 한개를 사용하며
			// 해당 쿠폰의 각 상품별 적용여부 확인 ( 1 . 전체일 경우 배송비를 제외한 주문가격과 비교 후 최대 금액을 넘어서면 주문가격과 동일하게 설정한다.
			if ( $aryCouponInfoList[0][CU_USE] == '1' )			// 전체 적용
			{
				$intCouponPrice	= getCurToPriceSave($aryCouponInfoList[0][CU_PRICE]);
				if ($S_ARY_CUR[$S_SITE_LNG]["USD"][2] == "Y"){
					$intCouponPrice = getCurToPriceSave($aryCouponInfoList[0][CU_PRICE],"US");
				}
				if ($aryCouponInfoList[0][CU_PRICE_OFF] == "1") {
					$intCouponPrice = getCurToPriceSave($aryCouponInfoList[0][CU_PRICE]);
					if ($S_ARY_CUR[$S_SITE_LNG]["USD"][2] == "Y"){
						$intCouponPrice = getCurToPriceSave($aryCouponInfoList[0][CU_PRICE],"US");
					}
					$intCouponPrice		= getFormatPrice(getRoundUp($intOrderTotalPrice * ($intCouponPrice/100),2),2);
				}
			}
			else if ( $aryCouponInfoList[0][CU_USE] == '2' || $aryCouponInfoList[0][CU_USE] == '3' )	// 특정 카테고리, 상품
			{

				# 쿠폰이 적용되는 상품가격의 합산을 가져온다.
				$orderMgr->setPB_ALL_NO($strPB_NO_LIST);
				$coupon_param = array
				(
					'type'		=> $aryCouponInfoList[0][CU_USE] ,
				) ;
				$couponTargetCode = $orderMgr->getCouponApplyInfo( $db , $coupon_param ) ;

				$coupon_param['queryString'] = ' AND ' ;
				if ( $aryCouponInfoList[0][CU_USE] == 2 )
					$coupon_param['queryString'] .= ' ( ' ;
				else if ( $aryCouponInfoList[0][CU_USE] == 3 )
					$coupon_param['queryString'] .= ' A.P_CODE IN ( ' ;
				foreach ( $couponTargetCode as $ckey => $cval )
				{
					if ( empty ( $cval['CUA_CODE'] ) )
						continue ;
					if ( $aryCouponInfoList[0][CU_USE] == 2 )
						$coupon_param['queryString'] .= ' B.P_CATE LIKE \'' . $cval['CUA_CODE'] . '%\' OR' ;
					else if ( $aryCouponInfoList[0][CU_USE] == 3 )
						$coupon_param['queryString'] .= $cval['CUA_CODE'] . '  ,' ;
				}
				$coupon_param['queryString'] = substr ( $coupon_param['queryString'] , 0 , -3 ) ;
				$coupon_param['queryString'] .= ' ) ' ;

				$couponProdPriceSum = $orderMgr->getCouponProdPriceSum ( $db , $coupon_param ) ;
				$intCouponPrice	= getCurToPriceSave($aryCouponInfoList[0][CU_PRICE]);
				if ( $couponProdPriceSum['sumPrice'] <= $aryCouponInfoList[0][CU_PRICE] )
					$intCouponPrice	= getCurToPriceSave( $couponProdPriceSum['sumPrice'] );
				if ($S_ARY_CUR[$S_SITE_LNG]["USD"][2] == "Y"){
					$intCouponPrice = getCurToPriceSave($aryCouponInfoList[0][CU_PRICE],"US");
				}
				if ($aryCouponInfoList[0][CU_PRICE_OFF] == "1") {
					$intCouponPrice = getCurToPriceSave($aryCouponInfoList[0][CU_PRICE]);
					if ($S_ARY_CUR[$S_SITE_LNG]["USD"][2] == "Y"){
						$intCouponPrice = getCurToPriceSave($aryCouponInfoList[0][CU_PRICE],"US");
					}
					$intCouponPrice		= getFormatPrice(getRoundUp( $couponProdPriceSum['sumPrice'] * ($intCouponPrice/100),2),2);
				}

			}
			$result[0]["COUPON_PRICE"]	= $intCouponPrice;

			$result_array = json_encode($result);
		}

		break;

	case "couponTotPrice":
	case "couponTotApplyPrice";

		$orderMgr->setM_NO("");
		$aryCouponIssueNo = $_POST["chkNo"];
		$strPB_NO_LIST = '';
		for($i=0;$i<sizeof($intPB_NO);$i++){
			$strPB_NO_LIST .= $intPB_NO[$i].",";
		}
		$strPB_NO_LIST = SUBSTR($strPB_NO_LIST,0,STRLEN($strPB_NO_LIST)-1);
		$orderMgr->setPB_ALL_NO($strPB_NO_LIST);

		if (is_array($aryCouponIssueNo)){
			$intCouponTotalPrice = 0;
			for($i=0;$i<sizeof($aryCouponIssueNo);$i++){
				$orderMgr->setCOUPON_ISSUE_NO($aryCouponIssueNo[$i]);
				$aryCouponInfoList = $orderMgr->getOrderCouponList($db,"O");

				if ( $aryCouponInfoList[0][CU_USE] == '1' )			// 전체 적용
				{
					$intCouponPrice	= $aryCouponInfoList[0][CU_PRICE];
					if ($S_ARY_CUR[$S_SITE_LNG]["USD"][2] == "Y"){
						$intCouponPrice = getCurToPriceSave($aryCouponInfoList[0][CU_PRICE],"US");
					}

					if ($aryCouponInfoList[0][CU_PRICE_OFF] == "1") {
						$intOrderTotalPrice	= getPriceToCur($_POST["orderTotalPrice"]);
						$intCouponPrice		= getRoundUp($intOrderTotalPrice * ($intCouponPrice/100),2);
					}
				}
				else if ( $aryCouponInfoList[0][CU_USE] == '2' || $aryCouponInfoList[0][CU_USE] == '3' )	// 특정 카테고리, 상품
				{
					# 쿠폰이 적용되는 상품가격의 합산을 가져온다.
					$orderMgr->setPB_ALL_NO($strPB_NO_LIST);
					$orderMgr->setCOUPON_NO($aryCouponInfoList[0][CU_NO]);
					$coupon_param = array
					(
						'type'		=> $aryCouponInfoList[0][CU_USE] ,
					) ;
					$couponTargetCode = $orderMgr->getCouponApplyInfo( $db , $coupon_param ) ;
					$coupon_param['queryString'] = ' AND ' ;
					if ( $aryCouponInfoList[0][CU_USE] == 2 )
						$coupon_param['queryString'] .= ' ( ' ;
					else if ( $aryCouponInfoList[0][CU_USE] == 3 )
						$coupon_param['queryString'] .= ' A.P_CODE IN ( ' ;
					foreach ( $couponTargetCode as $ckey => $cval )
					{
						if ( empty ( $cval['CUA_CODE'] ) )
							continue ;
						if ( $aryCouponInfoList[0][CU_USE] == 2 )
							$coupon_param['queryString'] .= ' B.P_CATE LIKE \'' . $cval['CUA_CODE'] . '%\' OR' ;
						else if ( $aryCouponInfoList[0][CU_USE] == 3 )
							$coupon_param['queryString'] .= $cval['CUA_CODE'] . '  ,' ;
					}
					$coupon_param['queryString'] = substr ( $coupon_param['queryString'] , 0 , -3 ) ;
					$coupon_param['queryString'] .= ' ) ' ;

					$couponProdPriceSum = $orderMgr->getCouponProdPriceSum ( $db , $coupon_param ) ;
					$intCouponPrice	= $aryCouponInfoList[0][CU_PRICE];
					if ( $couponProdPriceSum['sumPrice'] <= $aryCouponInfoList[0][CU_PRICE] )
						$intCouponPrice	= $couponProdPriceSum['sumPrice'];
					if ($S_ARY_CUR[$S_SITE_LNG]["USD"][2] == "Y"){
						$intCouponPrice = getCurToPriceSave($aryCouponInfoList[0][CU_PRICE],"US");
					}

					if ($aryCouponInfoList[0][CU_PRICE_OFF] == "1") {
						$intOrderTotalPrice	= getPriceToCur($_POST["orderTotalPrice"]);
						$intCouponPrice		= getRoundUp( $couponProdPriceSum['sumPrice'] * ($intCouponPrice/100),2);
					}
				}

				$intCouponTotalPrice += $intCouponPrice;
			}
		}
		$result[0]["COUPON_TOTAL_PRICE"] = getFormatPrice($intCouponTotalPrice,2);
		$result_array = json_encode($result);

		break;

	case "buyNonList":

		$orderMgr->setSearchOrderKey($strSearchOrderKey);
		$orderMgr->setSearchOrderName($strSearchOrderName);

		$orderMgr->setSearchField($strSearchField);
		$orderMgr->setSearchKey($strSearchKey);

		$intTotal	= $orderMgr->getOrderTotal($db);

		$result[0]["RET"] = "N";
		if ($intTotal > 0){
			$result[0]["RET"] = "Y";
		}

		$result_array = json_encode($result);
		break;

	case "japanZip":

		$result[0]["RET"]		= "N";

		/* XML 파일 호출*/
		$xml_string = file_get_contents("http://www.eumshop.com/api/xml/shop.japan.zip.xml.php?searchKey=".$strO_B_ZIP1);
		$xml = simplexml_load_string($xml_string);

		for ($i=0;$i<sizeof($xml->ITEM);$i++){

			$strDo					= (string)$xml->ITEM[$i]->DO;
			$strSi					= (string)$xml->ITEM[$i]->SI;
			$strAddr				= (string)$xml->ITEM[$i]->ADDR;

			$result[0]["DO"]		= $strDo;
			$result[0]["SI"]		= $strSi;
			$result[0]["ADDR"]		= $strAddr;

			$result[0]["RET"]		= "Y";
		}

		$result_array = json_encode($result);
		break;

	case "couponReg":
		## 오프라인 쿠폰등 마이페이지에서 쿠폰등록하기

		$result[0]["RET"] = "N";
		$arySelectCouponNo = $_POST['chkNo'];
		if (is_array($arySelectCouponNo)){

			foreach($arySelectCouponNo  as $key => $val){

				if ($val > 0 && $g_member_no){
					$orderMgr->setM_NO($g_member_no);
					$orderMgr->setCOUPON_ISSUE_NO($val);
					$orderMgr->getOrderCouponRegUpdate($db);
				}
			}
			$result[0]["RET"] = "Y";
		}

		$result_array = json_encode($result);

		break;

	case "ceritySave":
	case "orderCartStatusSave":
		/** 주문상태변경 **/

		include "../conf/site_conf_inc.php";								// 환경설정 파일 include
		require MALL_HOME."/web/frwork/act/pp_ax_hub_lib.php";              // library [수정불가]

		## STEP 1.
		## 주문 장바구니 번호(ORDER_CART OC_NO)
		if(!$_GET['ocNo']):
			$result				= "";
			$result['mode']		= "__ERROR__";
			$result['text']		= "상품정보가 없습니다."; //"상품정보가 없습니다.";
			getJsonExit($result);
		endif;

		## STEP 2.
		## 구매상태 업데이트

		$intOC_NO						=  $_GET["ocNo"];
		$param							= "";
		$param['OC_NO']					= $intOC_NO;
		$param['OC_ORDER_STATUS']		= 'E';
		$param["OC_MOD_NO"]				= $g_member_no;

		## 구매완료
		$param["OC_E_REG_DT"]	= "Y";
		$re = $shopOrderMgr->getOrderCartStatusUpdate($db,$param);

		$intO_NO				= $shopOrderMgr->getOrderNo($db,$param);
		$param['OC_REG_NO']		= $g_member_no;
		$param['O_NO']			= $intO_NO;


		## 주문별 상태 UPDATE(마스터/입점사)
		if ($intO_NO > 0){

			$orderMgr->setO_NO($intO_NO);
			$orderRow			= $orderMgr->getOrderView($db);

			$strOrderPrevStatus	= $orderRow["O_STATUS"];

			$shopOrderMgr->getOrderStatusAllUpdate($db,$param);

		}


		/* HISTORY INSERT */
		$strOrderStatusMemo			= $_GET['orderStatusMemo'];
		if (!$strOrderStatusMemo){
			$strOrderStatusMemo		= "구매상태변경";
		}
		$strOrderStatusText			= $intOC_NO."/".$param['OC_ORDER_STATUS'];

		$param['m_no']				= $g_member_no;
		$param['h_tab']				= TBL_ORDER_MGR;
		$param['h_key']				= $intO_NO;
		$param['h_code']			= "002"; //구매상태
		$param['h_memo']			= $strOrderStatusMemo;
		$param['h_text']			= $strOrderStatusText;
		$param['h_reg_no']			= $g_member_no;
		$param['h_adm_no']			= $g_member_no;
		$shopOrderMgr->getOrderStatusHistoryUpdate($db,$param);
		/* HISTORY INSERT */



		if($re != 1):
			$result				= array();
			$result['mode']		= "__ERROR__";
			$result['text']		= $LNG_TRANS_CHAR["OS00099"]; //"구매상태를 업데이트 할수 없습니다.";
			getJsonExit($result);
		endif;

		$result				= array();
		$result['mode']		= "__SUCCESS__";
		$result['text']		= "구매 확정 하였습니다.";
		getJsonExit($result);


		break;


}
$db->disConnect();
if($result_array){
	echo $result_array;
}else{
	$result["mode"] = "__ERROR__";
	$result["text"] = "Error~!";
	getJsonExit($result);
}


function rand_code($nc, $a='ABCDEFGHIJKLMNOPQRSTUVWXYZ') {
	$l = strlen($a) - 1; $r = '';
	while($nc-->0) $r .= $a{mt_rand(0,$l)};
	return $r;
}
?>