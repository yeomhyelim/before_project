<?
	require_once MALL_CONF_LIB."ProductMgr.php";
	require_once MALL_CONF_LIB."OrderMgr.php";
	require_once MALL_CONF_LIB."MemberMgr.php";
	require_once MALL_CONF_LIB."CouponMgr.php";
	require_once MALL_CONF_LIB."ShopOrderMgr.php";
	require_once MALL_CONF_LIB."ShopMgr.php";
	require_once MALL_CONF_LIB."SiteMgr.php";

	require_once $S_DOCUMENT_ROOT.$S_SHOP_HOME."/conf/order.inc.php";

	/*상품함수관련*/
	require_once MALL_PROD_FUNC;
	/*주문함수관련*/
	require_once MALL_ORDER_FUNC;

	$orderMgr = new OrderMgr();
	$productMgr = new ProductMgr();
	$memberMgr = new MemberMgr();
	$couponMgr = new CouponMgr();
	$shopOrderMgr = new ShopOrderMgr();
	$shopMgr		= new ShopMgr();
	$siteMgr = new SiteMgr();

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

	if(is_file("{$S_DOCUMENT_ROOT}{$S_SHOP_HOME}/conf/shop.manual.inc.php")):
		require_once "{$S_DOCUMENT_ROOT}{$S_SHOP_HOME}/conf/shop.manual.inc.php";
	endif;

	if (!$g_member_no) $orderMgr->setM_NO(0);
	else $orderMgr->setM_NO($g_member_no);

	$intO_NO	= $_POST["oNo"]					? $_POST["oNo"]					: $_REQUEST["oNo"];
	$strPayPg	= $_POST["payPg"]				? $_POST["payPg"]				: $_REQUEST["payPg"];

	$strLinkPage = "";
	switch ($strAct) {

		case "pg":

			switch ($strPayPg){
				case "K":
					/* KCP */
					include MALL_HOME."/web/frwork/act/pp_ax_hub.php";
					/* KCP */
				break;
				case "Y":
					/* 페이팔 */
					include MALL_HOME."/web/frwork/act/payPalReviewOrder.php";
					/* 페이팔 */
				break;
				case "A":
					/* AgsPay */
					include MALL_HOME."/web/frwork/act/agsPay/AGS_pay_ing.php";
					/* AgsPay */
				break;
				case "N":
					/* AgsPay */
					include MALL_HOME."/web/frwork/act/ksnet/kspay_wh_result.php";
					/* AgsPay */
				break;
			}
			exit;
		break;

		case "pgReturn":

			switch ($SHOP_PAY_PG){
				case "K":
					include MALL_HOME."/web/frwork/act/common_return.php";
				break;

				case "A":
				case "N":
					/* 올더게이트 / KSNET 같이 씀 */
					include MALL_HOME."/web/frwork/act/agsPay/AGS_VirAcctResult.php";
				break;
			}
		break;

		case "void":
			/* paypal cancel */
			include MALL_HOME."/web/frwork/act/payPalDoVoid.php";

			$db->disConnect();
			exit;
		break;
		case "payPalIpn":
			/* paypal log */
			include MALL_HOME."/web/frwork/act/payPalIpnReceive.php";
		break;

		case "pgApproval":
			switch ($S_PG){
				case "K":
					if ($strDevice == "m" || $strDevice == "mobile"){
						require_once $S_DOCUMENT_ROOT.$S_SHOP_HOME."/conf/site_conf_inc.php";
						include MALL_HOME."/web/frwork/pay/kcp/order_approval.php";
					}
				break;
			}
			exit;
		break;

		case "pg_mobile":
			switch ($strPayPg){
				case "K":
					include MALL_HOME."/web/frwork/act/kcp/m.pp_ax_hub.php";
				break;
			}
			exit;

		break;

		case "eximbayReturn":
			include MALL_HOME."/web/frwork/act/eximbay/return.php";
		break;
		case "eximbayStatus":
			include MALL_HOME."/web/frwork/act/eximbay/status.php";
		break;
		case "eximbayCancelReturn":
			include MALL_HOME."/web/frwork/act/eximbay/cancelReturn.php";
		break;

		case "agsCancel":
			include MALL_HOME."/web/frwork/act/agsPay/AGS_cancel_ing.php";
		break;

		case "agsEscrow":
			$TrCode = $_POST["trcode"];

			include MALL_HOME."/web/frwork/act/agsPay/AGS_escrow_ing.php";
		break;

		case "partCancel":

			include MALL_HOME."/web/frwork/act/payPartCancel".$S_SHOP_ORDER_VERSION.".php";

			exit;
		break;

		case "ksnetCancel":
			include MALL_HOME."/web/frwork/act/ksnet/KSPayCancelPost.php";

			exit;
		break;

		case "INIescrowResult":
			// inipay50 결제 결과
			include MALL_SHOP . '_INIescrow50/source/orderResult.iniescrow.inc.php';
			exit;
		break;
		case "INIescrowCancel":
			// inipay50 결제 취소
			include MALL_SHOP . '_INIescrow50/source/orderCancel.iniescrow.inc.php';
		break;
	}

	$db->disConnect();

	goUrl($strMsg,$strUrl);

?>