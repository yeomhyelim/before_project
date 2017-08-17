<?	

	$strSubSkinName		= STRTOUPPER($strMenuType)."_".STRTOUPPER($strMode); 
	$strCssCode			= $S_SKIN[$strSubSkinName];

	//&&가 아닌 || 이 맞을듯 확인해봐야함 2015.05.29 kjp
	if (($strMenuType == "product" && $strMode == "planMain") || ($strMenuType == "product" && $strMode == "prodInquiry")){
		$strCssCode			= $S_SKIN["PRODUCT_LIST"];		
	}

	$aryCssCode			= array(	"MAIN_LIST"			=> "main"//,				// 메인화면
									//"ETC_ADDRESS"		=> "etc_address",		// 우편번호	
								);
	
	$aryCssCode2		= array(	"ORDER_BUYLIST"			=> "member",			// 구매내역
									"ORDER_BUYVIEW"			=> "member",			// 구매내역(상세)
									"ORDER_CARTMYLIST"		=> "member",			// 장바구니
									"ORDER_WISHMYLIST"		=> "member",			// 담아둔상품
									"ORDER_POINTLIST"		=> "member",			// 포인트관리
									"ORDER_COUPONLIST"		=> "member",			// 쿠폰관리
									"ORDER_MYINFO"			=> "member",			// 내정보변경
									"ORDER_ADDRLIST"		=> "member",			// 주소록관리
									"ORDER_BUYNONLIST"		=> "member",			// 구매내역(비회원)
									"ORDER_COMMUNITY"		=> "member"				// 커뮤니티(MyPage)
								);
	$strCssFileName		= $aryCssCode[$strSubSkinName];
	$strCssFileName2	= $aryCssCode2[$strSubSkinName];

	if($strCssFileName) :
//		$strCssHref = sprintf("/common/css/%s.css", $strCssFileName);
		$strMyCssHref = sprintf("/layout/css/%s.css", $strCssFileName);
	elseif($strCssFileName2):
		$strCssCode = substr($strCssCode, 2);
		$strCssHref = sprintf("/common/css/%s/%s_%s.css", $strCssFileName2, $strCssFileName2, $strCssCode);	
	else :
		if ($strMenuType != "etc"):
			
			$strCssCode = substr($strCssCode, 2);
			$strCssHref = sprintf("/common/css/%s/%s_%s.css", $strMenuType, $strMenuType, $strCssCode);

		endif;

		
	endif;

	/** 2013.04.16 mypage , order 분리 **/
	if($strMenuType == "mypage" || $strLayout == "mypage" || $strMenuType == "shop"):
		$strCssCode  = substr($S_SKIN['ORDER_MYINFO'],2);
		$strCssHref = "/common/css/member/member_{$strCssCode}.css";
	endif;

	$arySiteUseCss = explode("/",$S_USE_LNG);

?>
	<link rel="stylesheet" type="text/css" href="/layout/css/layout_style.css"/>
	<link rel="stylesheet" type="text/css" href="/common/css/jquery.smartPop.css" />
<?if($strCssHref):?>
	<link rel="stylesheet" type="text/css" href="<?=$strCssHref?>"/>
<?endif;?>
<?if($strMyCssHref):?>
	<link rel="stylesheet" type="text/css" href="<?=$strMyCssHref?>"/>
<?endif?>
<?if(in_array($strMode, array("buyView", "buyNonView"))):?>
	<link rel="stylesheet" type="text/css" href="/common/css/order/order_<?=$strCssCode?>.css"/>
<?endif;?>
<?if (sizeof($arySiteUseCss) >= 2){?>
	<link rel="stylesheet" type="text/css" href="/layout/css/style_<?=$S_SITE_LNG_PATH?>.css"/>
<?}?>