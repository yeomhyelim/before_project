<?
	$g_member_login		= $_SESSION[SESS_MEMBER_LOGIN];
	$g_member_id		= $_SESSION[SESS_MEMBER_ID];
	$g_member_name		= $_SESSION[SESS_MEMBER_NAME];
	$g_member_last_name	= $_SESSION[SESS_MEMBER_LAST_NAME];
	$g_member_group		= $_SESSION[SESS_MEMBER_GROUP];
	$g_member_group_name= $_SESSION[SESS_MEMBER_GROUP_NAME];
	$g_member_no		= $_SESSION[SESS_MEMBER_NO];
	$g_member_email		= $_SESSION[SESS_MEMBER_EMAIL];
	$g_member_ipaddr	= $_SESSION[SESS_MEMBER_IPADDR];
	$g_member_level		= $_SESSION[SESS_MEMBER_LEVEL];
	$g_member_nickname	= $_SESSION[SESS_MEMBER_NICKNAME];

	$g_member_facebook_login = $_SESSION[SESS_MEMBER_FACEBOOK_LOGIN];

	$g_cart_prikey		= $_COOKIE["COOKIE_CART_PRIKEY"];
	$g_prod_today		= $_COOKIE["COOKIE_PROD_TODAY"];		/* 최근본상품 */
	
	/* 페이스북 로그인 정보 */
	require_once MALL_WEB_PATH."frwork/facebook/facebook.php";

	$facebook = new Facebook(array(
	  'appId'  => $S_SITE_FACEBOOK_APP_ID,
	  'secret' => $S_SITE_FACEBOOK_SECRET,
	  'cookie' => true, 
	));	


	if ($S_SITE_FACEBOOK_APP_ID && $S_SITE_FACEBOOK_SECRET){

		// Get User ID
		$strFaceBookUserId		= $facebook->getUser();
		$_facebook_access_token = "fb_".$S_SITE_FACEBOOK_APP_ID."_access_token"; // 토큰ID 
		$_facebook_user_id		= "fb_".$S_SITE_FACEBOOK_APP_ID."_user_id"; // 유저ID	

	}

	/* 모바일 결제시 필요한 상품 리스트 / 쿠폰리스트*/
	$strMobileOrderBasketNo		= $_SESSION["MOBILE_PRODUCT_CART"];
	$strMobileOrderCouponNo		= $_SESSION["MOBILE_ORDER_COUPON"];

	## 2015.02.09 kim hee sung
	## 상품가격 출력 설정
	##  관리자페이지 > 기본설정 > 주문및결제관리 > 상품가격노출 사용시 해당 그룹 회원에게만 가격 노출합니다.
	## 상품가격 출력 설정(그룹 배열화)
	if($S_PRICE_SHOW_MEMBER =='Y'):
		$isPriceHide = false;
		if(!$g_member_no) $isPriceHide = true; // 비회원
		if(!$S_PRICE_SHOW_GROUP) $isPriceHide = true; // 회원그룹이 없을때 2015.02.25 kim hee sung 요청사항
		if($S_PRICE_SHOW_GROUP) $S_PRICE_SHOW_GROUP = explode(",", $S_PRICE_SHOW_GROUP);
		if($S_PRICE_SHOW_GROUP && !in_array($g_member_group, $S_PRICE_SHOW_GROUP)) $isPriceHide = true; // 회원그룹
		$aryScriptData['priceHide'] = $isPriceHide;
	endif;	

	## 디버그 설정
	if($_GET['debug'])
		$_SESSION['debug'] = $_GET['debug'];

?>