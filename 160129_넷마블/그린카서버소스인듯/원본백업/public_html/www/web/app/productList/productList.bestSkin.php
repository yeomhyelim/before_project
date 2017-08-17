<?php
	/**
	 * eumshop app - productList - bestSkin
	 *
	 * 상품 베스트 상품을 불러옵니다.
	 * 디자인관리 추천상품 옵션을 따라갑니다.
	 *
	 * @package		eumshop shopping mall
	 * @author		ExpressionEngine Dev HeeSung Kim
	 * @copyright	Copyright (c) 2012 - 2013, Eumshop, Inc.
	 * @license		http://www.eumshop.com/user_guide/license.html
	 * @link		http://www.eumshop.com
	 * @since		Version 1.0
	 * @filesource	/www/web/app/productList/productList.bestSkin.php
	 * @manual		menuType=app&mode=productList&skin=bestSkin
	 * @history
	 *				2014.08.22 kim hee sung - 개발 완료
	 */

	## app id
	if(!$strAppID):
		$intAppID				= $intAppID + 1; 
		$strAppID				= "PRODUCT_LIST_{$intAppID}";
	endif;

	## 모듈 설정
	require_once MALL_HOME . "/config/product.func.php";
	$objProductMgrModule		= new ProductMgrModule($db);

	## 스크립트 설정
	$aryScriptEx[]				= "/common/js/app/productList/productList.bestSkin.js";

	## 기본 설정
	$intAppNo					= $EUMSHOP_APP_INFO['no'];
	$strAppType					= $EUMSHOP_APP_INFO['type']; // main or sub or brand
	$strAppHtml					= $EUMSHOP_APP_INFO['html'];
	$strAppLang					= $S_SITE_LNG; 
	$strAppLangLower			= strtolower($strAppLang);

	## 체크
	if(!$intAppNo) { return; }
	if(!$strAppType) { $strAppType = "main"; } 	
	if(!$strAppLang) { $strAppLang = $S_ST_LNG; }

	## 타입 설정
	$strAppType = strtoupper($strAppType);
	if(!in_array($strAppType, array("MAIN","SUB"))) { return; }

	## 아이콘 번호 설정
	$intIconNo = $intAppNo;
	if($strAppType == "SUB") { $intIconNo = $intIconNo + 5; }

	## 설정 정보 include
	include_once MALL_SHOP . "/conf/site_skin_main.conf.inc.php";
	include_once MALL_SHOP . "/conf/site_skin_product.conf.inc.php";

	## 옵션 설정
	$strAppUse				= ${"S_ARY_{$strAppType}_PRODLIST_USE"}[$intAppNo];
	$strAppTitle			= ${"S_{$strAppType}_PRODLIST_TIT_{$intAppNo}"};
	$intAppWSize 			= ${"S_{$strAppType}_PRODLIST_IMG_SIZE_W_{$intAppNo}"};
	$intAppHSize			= ${"S_{$strAppType}_PRODLIST_IMG_SIZE_H_{$intAppNo}"};
	$intAppWList 			= ${"S_{$strAppType}_PRODLIST_IMG_VIEW_W_{$intAppNo}"};
	$intAppHList			= ${"S_{$strAppType}_PRODLIST_IMG_VIEW_H_{$intAppNo}"};
	$strAppWAlign			= ${"S_{$strAppType}_BEST_LIST{$intAppNo}_WORD_ALIGN"};
	$strAppMoney			= ${"S_{$strAppType}_BEST_LIST{$intAppNo}_MONEY_TYPE"};
	$strAppMoneyIcon		= ${"S_{$strAppType}_BEST_LIST{$intAppNo}_MONEY_ICON"};
	$strAppShow1			= ${"S_{$strAppType}_BEST_LIST{$intAppNo}_SHOW_1"};
	$strAppShow2			= ${"S_{$strAppType}_BEST_LIST{$intAppNo}_SHOW_2"};
	$strAppShow3			= ${"S_{$strAppType}_BEST_LIST{$intAppNo}_SHOW_3"};
	$strAppShow4			= ${"S_{$strAppType}_BEST_LIST{$intAppNo}_SHOW_4"};
	$strAppShow5			= ${"S_{$strAppType}_BEST_LIST{$intAppNo}_SHOW_5"};
	$strAppShow6			= ${"S_{$strAppType}_BEST_LIST{$intAppNo}_SHOW_6"};
	$strAppShow7			= ${"S_{$strAppType}_BEST_LIST{$intAppNo}_SHOW_7"};
	$strAppShow8			= ${"S_{$strAppType}_BEST_LIST{$intAppNo}_SHOW_8"};
	$strAppColor1			= ${"S_{$strAppType}_BEST_LIST{$intAppNo}_COLOR_1"};
	$strAppColor2			= ${"S_{$strAppType}_BEST_LIST{$intAppNo}_COLOR_2"};
	$strAppColor3			= ${"S_{$strAppType}_BEST_LIST{$intAppNo}_COLOR_3"};
	$strAppColor4			= ${"S_{$strAppType}_BEST_LIST{$intAppNo}_COLOR_4"};
	$strAppColor5			= ${"S_{$strAppType}_BEST_LIST{$intAppNo}_COLOR_5"};
	$strAppTitleShow		= ${"S_{$strAppType}_BEST_LIST{$intAppNo}_TITLE_SHOW_USE"};
	$strAppTitleFile		= ${"S_{$strAppType}_BEST_LIST{$intAppNo}_TITLE_FILE_NAME"};
	$intAppTitleMaxsize		= ${"S_{$strAppType}_BEST_LIST{$intAppNo}_TITLE_MAXSIZE"};
	$strAppTurnUse			= ${"S_{$strAppType}_BEST_LIST{$intAppNo}_TURN_USE"};

	## 상품 출력 개수 설정
	if(!$intAppWList) { $intAppWList = 2; }
	if(!$intAppHList) { $intAppHList = 2; }
	$intPageLine		= $intAppWList * $intAppHList;

	## 체크
	if($strAppUse != "Y") {return; }

	## 통화 설정
	$strAppMoneyIconL		= "";
	$strAppMoneyIconR		= "";
	if($strAppMoney == "sign" || $strAppMoney == "won"){ 
		if ($strAppLang != "KR" && $strAppLang != "JP" && $strAppLang != "RU"){
			if ($strAppLang == "ES") $strAppMoneyIconL = $S_SITE_CUR_MARK1;
			else $strAppMoneyIconL = $S_SITE_CUR_MARK2." ";
		} else {
			if ($strAppLang == "JP") $strAppMoneyIconR = $S_SITE_CUR_MARK1;
			else if ($strAppLang == "RU") $strAppMoneyIconR = $S_SITE_CUR_MARK1;
			else $strAppMoneyIconR = $S_SITE_CUR_MARK2;
		}
	} 
	else if($strAppMoney =="icon")	{ $strAppMoneyIconL = sprintf(" <img src='/himg/icon/%s'>", $strAppMoneyIcon); } 
	else						{ $strAppMoneyIcon = ""; }

	## 데이터 불러오기
	$param							= "";
	$param['LNG']					= $strAppLang;
	$param['P_ICON'][]				= $intIconNo;
	$param['LIMIT']					= "{$intPageLine}";
	$param['P_WEB_VIEW']			= "Y";
	$param['PRODUCT_INFO_JOIN']		= "Y";
	$param['PRODUCT_IMG_JOIN']		= "Y";
//	$param['PRODUCT_IMG_JOIN2']		= "Y"; 
	$param['UBJ_JOIN']				= "Y";
	$param['PBR_JOIN']				= "Y";
	$aryProdList					= $objProductMgrModule->getProductMgrSelectEx("OP_ARYTOTAL", $param);

	## 체크
	if(!$aryProdList) { return; }

	if($strAppHtml = "N") { return; }
?>

aa