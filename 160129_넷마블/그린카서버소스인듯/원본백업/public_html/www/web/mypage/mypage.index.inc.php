<?

	$S_MEMBER_LOGIN_IMAGE_DESIGN					= ($S_MEMBER_LOGIN_IMAGE_DESIGN) ? $S_MEMBER_LOGIN_IMAGE_DESIGN : "ML0001";

	$arySkinFolder	= array(	"buyList"			=> "{$S_DOCUMENT_ROOT}{$S_SHOP_HOME}/layout/html/mypage_body_{$strMode}.inc.php",
								"buyView"			=> "{$S_DOCUMENT_ROOT}{$S_SHOP_HOME}/layout/html/mypage_body_{$strMode}.inc.php",
								"buyNonList"		=> "{$S_DOCUMENT_ROOT}{$S_SHOP_HOME}/layout/html/mypage_body_{$strMode}.inc.php",
								"buyNonView"		=> "{$S_DOCUMENT_ROOT}{$S_SHOP_HOME}/layout/html/mypage_body_{$strMode}.inc.php",
								"cartMyList"		=> "{$S_DOCUMENT_ROOT}{$S_SHOP_HOME}/layout/html/mypage_body_{$strMode}.inc.php",
								"wishMyList"		=> "{$S_DOCUMENT_ROOT}{$S_SHOP_HOME}/layout/html/mypage_body_{$strMode}.inc.php",
								"pointList"			=> "{$S_DOCUMENT_ROOT}{$S_SHOP_HOME}/layout/html/mypage_body_{$strMode}.inc.php",
								"couponList"		=> "{$S_DOCUMENT_ROOT}{$S_SHOP_HOME}/layout/html/mypage_body_{$strMode}.inc.php",
								"myInfo"			=> "{$S_DOCUMENT_ROOT}{$S_SHOP_HOME}/layout/html/mypage_body_{$strMode}.inc.php",
								"addrList"			=> "{$S_DOCUMENT_ROOT}{$S_SHOP_HOME}/layout/html/mypage_body_{$strMode}.inc.php",
								"community"			=> "{$S_DOCUMENT_ROOT}{$S_SHOP_HOME}/layout/html/mypage_body_{$strMode}.inc.php",
								"droupout"			=> "{$S_DOCUMENT_ROOT}{$S_SHOP_HOME}/layout/html/mypage_body_{$strMode}.inc.php",
								"prodList"			=> "{$S_DOCUMENT_ROOT}{$S_SHOP_HOME}/layout/html/mypage_body_{$strMode}.inc.php",
								"auctionMyList"		=> "{$S_DOCUMENT_ROOT}{$S_SHOP_HOME}/layout/html/mypage_body_{$strMode}.inc.php",

							);

	//페이지 제목 설정
	$arySkinName = array(
					"buyList"			=> $LNG_TRANS_CHAR["CW00085"],
					"buyView"			=> $LNG_TRANS_CHAR["CW00085"],
					"buyNonList"		=> "buyNonList",
					"buyNonView"		=> "buyNonView",
					"cartMyList"		=> "cartMyList",
					"wishMyList"		=> "wishMyList",
					"pointList"			=> "pointList",
					"couponList"		=> "couponList",
					"myInfo"			=> $LNG_TRANS_CHAR["CW00015"],
					"addrList"			=> $LNG_TRANS_CHAR["OW00085"],
					"community"			=> "community",
					"droupout"			=> "droupout",
					"prodList"			=> "prodList",
					"auctionMyList"		=> "auctionMyList",

					);

	$strB_NAME = $arySkinName[$strMode];
	if($strMode == "buyList" && $strSearchOrderStatus == "R"){
		$strB_NAME = $LNG_TRANS_CHAR["CW00020"];
	}

	if($arySkinFolder[$strMode]) :
		include $arySkinFolder[$strMode];
	else:
		include sprintf("%swww/web/%s/%s_%s.inc.php", $S_DOCUMENT_ROOT, $strMenuType, $strMenuType, $S_SKIN[$strSubSkinName] );
	endif;
	
 ?>

