<?
	require_once MALL_CONF_LIB."ProductMgr.php";
	require_once MALL_CONF_LIB."ShopMgr.php";

	$productMgr		= new ProductMgr();
	$shopMgr		= new ShopMgr();

	## 베스트 상품 설정
	require_once MALL_SHOP . "/conf/site_skin_main.conf.inc.php";
	require_once MALL_SHOP . "/conf/product.inc.php";
	require_once MALL_SHOP . "/conf/order.inc.php";
	require_once MALL_PROD_FUNC;

//	$no				= 1;
	$strUse			= $S_ARY_MAIN_PRODLIST_USE[$no];
	$strTitle		= ${"S_MAIN_PRODLIST_TIT_{$no}"};

	## 2014.08.26 kim hee sung 진열장관리와 디자인관리/세부페이지 통합으로 설정 부분 변경
	## 사용을 원하시는 경우. $S_PRODUCT_ICON_WITH_DESIGN 옵션 추가 후, 진열장 관리 다시 저장
	if($S_PRODUCT_ICON_WITH_DESIGN == "Y"):
		include MALL_SHOP . "/conf/conf/product.inc.php";
		if($S_ARY_PRODUCT_LIST_MAIN):
			if($S_ARY_PRODUCT_LIST_MAIN[$no]):
				## 기본설정
				$strUse = $S_ARY_PRODUCT_LIST_MAIN[$no]['USE'];
				$strTitle = $S_ARY_PRODUCT_LIST_MAIN[$no]['NAME'];
			endif;
		endif;
	endif;

	if($strUse == "Y" && ($strTitle)) :
		// 베스트 상품

		/* 정의 */
		$intWSize 			= ${"S_MAIN_PRODLIST_IMG_SIZE_W_{$no}"};
		$intHSize			= ${"S_MAIN_PRODLIST_IMG_SIZE_H_{$no}"};
		if(!$intWList):
		$intWList 			= ${"S_MAIN_PRODLIST_IMG_VIEW_W_{$no}"};
		endif;
		if(!$intHList):
		$intHList			= ${"S_MAIN_PRODLIST_IMG_VIEW_H_{$no}"};
		endif;
		$strWAlign			= ${"S_MAIN_BEST_LIST{$no}_WORD_ALIGN"};
		$strMoney			= ${"S_MAIN_BEST_LIST{$no}_MONEY_TYPE"};
		$strMoneyIcon		= ${"S_MAIN_BEST_LIST{$no}_MONEY_ICON"};
		$strShow1			= ${"S_MAIN_BEST_LIST{$no}_SHOW_1"};
		$strShow2			= ${"S_MAIN_BEST_LIST{$no}_SHOW_2"};
		$strShow3			= ${"S_MAIN_BEST_LIST{$no}_SHOW_3"};
		$strShow4			= ${"S_MAIN_BEST_LIST{$no}_SHOW_4"};
		$strShow5			= ${"S_MAIN_BEST_LIST{$no}_SHOW_5"};
		$strShow6			= ${"S_MAIN_BEST_LIST{$no}_SHOW_6"};
		$strShow7			= ${"S_MAIN_BEST_LIST{$no}_SHOW_7"};
		$strShow8			= ${"S_MAIN_BEST_LIST{$no}_SHOW_8"};
		if(!$strColor1):
		$strColor1			= ${"S_MAIN_BEST_LIST{$no}_COLOR_1"};
		endif;
		if(!$strColor2):
		$strColor2			= ${"S_MAIN_BEST_LIST{$no}_COLOR_2"};
		endif;
		if(!$strColor3):
		$strColor3			= ${"S_MAIN_BEST_LIST{$no}_COLOR_3"};
		endif;
		if(!$strColor4):
		$strColor4			= ${"S_MAIN_BEST_LIST{$no}_COLOR_4"};
		endif;
		if($strColor5):
		$strColor5			= ${"S_MAIN_BEST_LIST{$no}_COLOR_5"};
		endif;
		$strTitleShow		= ${"S_MAIN_BEST_LIST{$no}_TITLE_SHOW_USE"};
		$strTitleFile		= ${"S_MAIN_BEST_LIST{$no}_TITLE_FILE_NAME"};
		$intTitleMaxsize	= ${"S_MAIN_BEST_LIST{$no}_TITLE_MAXSIZE"};
		$strTurnUse			= ${"S_MAIN_BEST_LIST{$no}_TURN_USE"};


		/* 통화 */
		$strMoneyIconL		= "";
		$strMoneyIconR		= "";
		if($strMoney == "sign" || $strMoney == "won"){ 
			if ($S_SITE_LNG != "KR" && $S_SITE_LNG != "JP" && $S_SITE_LNG != "RU"){
				if ($S_SITE_LNG == "ES") $strMoneyIconL = $S_SITE_CUR_MARK1;
				else $strMoneyIconL = $S_SITE_CUR_MARK2."";
			} else {
				if ($S_SITE_LNG == "JP") $strMoneyIconR = $S_SITE_CUR_MARK1;
				else if ($S_SITE_LNG == "RU") $strMoneyIconR = $S_SITE_CUR_MARK1;
				else $strMoneyIconR = $S_SITE_CUR_MARK2;
			}
		} 
		else if($strMoney =="icon")	{ $strMoneyIconL = sprintf(" <img src='/himg/icon/%s'>", $strMoneyIcon); } 
		else						{ $strMoneyIcon = ""; }

		/* 타이틀 */
		$strTitleCode		= "";
		if($strTitleShow == "style") { $strTitleCode = $strTitle; }
		else if($strTitleShow == "image") { $strTitleCode = ($strTitleFile) ? sprintf("<img src='%s'/>", $strTitleFile) : ""; }

		## 2013.12.13 kim hee sung 속도가 느려서 쿼리 부분 변경
		## 모듈 실행
		//require_once MALL_HOME . "/module2/ProductMgr.module.php";
		if(!$productMgrModule):
		//$productMgrModule				= new ProductMgrModule($db);
		endif;

		/* 상품 호출 개수 */
		$intPageLine 					= $intWList * $intHList;

		## 데이터 불러오기
		$param							= "";
		$param['LNG']					= $S_SITE_LNG;
		$param['P_ICON'][]				= $no;
		$param['LIMIT']					= "0,{$intPageLine}";
		$param['SH_COM_MAIN']			= "Y";
		$param['P_WEB_VIEW']			= "Y";
		$param['PRODUCT_INFO_JOIN']		= "Y";
		$param['PRODUCT_IMG_JOIN']		= "Y";
		$param['PRODUCT_IMG_JOIN2']		= "Y";
		$param['UBJ_JOIN']				= "Y";
		$param['P_CATE_LIKE']			= $strCateLike;
		$param['P_MANY_LNG_VIEW']		= $S_PROD_MANY_LANG_VIEW; //다국어출력여부	
		//$intProdRowCnt					= $productMgrModule->getProductMgrSelectEx("OP_COUNT", $param);
		//$aryProdRow						= $productMgrModule->getProductMgrSelectEx("OP_LIST", $param);
		//echo "<!--" . $db->query . "-->";

		$shopMgr->setP_LNG($S_SITE_LNG);

		$shopMgr->setSearchComAuth('Y');
		$shopMgr->setSH_COM_MAIN('Y');
		$shopMgr->setLimitFirst('0');
		$shopMgr->setPageLine('10');
		
		$shopResult =$shopMgr->getShopList($db);
		
		// 스킨
		if($intProdRowCnt == 0) :
			echo "<div class=\"noListWrap\">";
			echo  $LNG_TRANS_CHAR["PS00001"] ;	// 등록된 상품이 없습니다.
			echo "</div>";
		else :

			## 리스트의 장바구니 사용
			if($S_PROD_ADD_CART_USE == "Y"){
				## strAppId 선언
				$strAppID = ${"S_MAIN_BEST_LIST{$no}_DESIGN"}."_{$no}";
				//include WEB_FRWORK_HELP."product.addCart.php";
			}

			if (${"S_FIX_MAIN_PROD_BEST_".$no."_SCROLL_FLAG"} == "Y"){
				include "bestList." . ${"S_MAIN_BEST_LIST{$no}_DESIGN"} . ".skin.scroll.html.php";
			} else {
				//include "bestList." . ${"S_MAIN_BEST_LIST{$no}_DESIGN"} . ".skin.html.php";	
				include "bestList.skin.html.php";		
			}
		endif;

		## 초기화
		$intWSize 			= "";
		$intHSize			= "";
		$intWList 			= "";
		$intHList			= "";
	endif;
?>