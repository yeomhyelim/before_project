<?

	$S_MEMBER_LOGIN_IMAGE_DESIGN					= ($S_MEMBER_LOGIN_IMAGE_DESIGN) ? $S_MEMBER_LOGIN_IMAGE_DESIGN : "ML0001";

	$arySkinFolder	= array(	
//								"buyList"			=> "{$S_DOCUMENT_ROOT}{$S_SHOP_HOME}/layout/html/mypage_body_{$strMode}.inc.php",
//								"buyNonList"		=> "{$S_DOCUMENT_ROOT}{$S_SHOP_HOME}/layout/html/order_body_{$strMode}.inc.php",
//								"buyView"			=> "{$S_DOCUMENT_ROOT}{$S_SHOP_HOME}/layout/html/mypage_body_{$strMode}.inc.php",
//								"buyNonView"		=> "{$S_DOCUMENT_ROOT}{$S_SHOP_HOME}/layout/html/order_body_{$strMode}.inc.php",
//								"cartMyList"		=> "{$S_DOCUMENT_ROOT}{$S_SHOP_HOME}/layout/html/mypage_body_{$strMode}.inc.php",
//								"wishMyList"		=> "{$S_DOCUMENT_ROOT}{$S_SHOP_HOME}/layout/html/mypage_body_{$strMode}.inc.php",
//								"pointList"			=> "{$S_DOCUMENT_ROOT}{$S_SHOP_HOME}/layout/html/mypage_body_{$strMode}.inc.php",
//								"couponList"		=> "{$S_DOCUMENT_ROOT}{$S_SHOP_HOME}/layout/html/mypage_body_{$strMode}.inc.php",
//								"myInfo"			=> "{$S_DOCUMENT_ROOT}{$S_SHOP_HOME}/layout/html/mypage_body_{$strMode}.inc.php",
//								"addrList"			=> "{$S_DOCUMENT_ROOT}{$S_SHOP_HOME}/layout/html/mypage_body_{$strMode}.inc.php",
//								"community"			=> "{$S_DOCUMENT_ROOT}{$S_SHOP_HOME}/layout/html/mypage_body_{$strMode}.inc.php",
								"cart"				=> MALL_SHOP."/layout/html/order_body_{$strMode}.inc.php",
								"order"				=> MALL_SHOP."/layout/html/order_body_{$strMode}.inc.php",
								"orderEnd"			=> MALL_SHOP."/layout/html/order_body_{$strMode}.inc.php",
								"nextOrderStep"		=> MALL_SHOP."/layout/html/order_body_{$strMode}.inc.php"
							);

	if($arySkinFolder[$strMode]) :
		include $arySkinFolder[$strMode];
	else:
		include sprintf("%swww/web/%s/%s_%s.inc.php", $S_DOCUMENT_ROOT, $strMenuType, $strMenuType, $S_SKIN[$strSubSkinName] );
	endif;
	
 ?>

