<?
	$no					= 1;

	// 상품 리스트

	/* 정의 */
	$strBrandListSkin	= $S_PRODUCT_BRAND_LIST1_DESIGN;
	$intWSize 			= $S_PRODUCT_BRAND_LIST1_IMG_SIZE_W;
	$intHSize			= $S_PRODUCT_BRAND_LIST1_IMG_SIZE_H;
	$intWList 			= $S_PRODUCT_BRAND_LIST1_IMG_VIEW_W;
	$intHList			= $S_PRODUCT_BRAND_LIST1_IMG_VIEW_H;
	$strWAlign			= $S_PRODUCT_BRAND_LIST1_WORD_ALIGN;
	$strMoney			= $S_PRODUCT_BRAND_LIST1_MONEY_TYPE;
	$strMoneyIcon		= $S_PRODUCT_BRAND_LIST1_MONEY_ICON;
	$strShow1			= $S_PRODUCT_BRAND_LIST1_SHOW_1;
	$strShow2			= $S_PRODUCT_BRAND_LIST1_SHOW_2;
	$strShow3			= $S_PRODUCT_BRAND_LIST1_SHOW_3;
	$strShow4			= $S_PRODUCT_BRAND_LIST1_SHOW_4;
	$strShow5			= $S_PRODUCT_BRAND_LIST1_SHOW_5;
	$strShow6			= $S_PRODUCT_BRAND_LIST1_SHOW_6;
	$strShow7			= $S_PRODUCT_BRAND_LIST1_SHOW_7;
	$strShow8			= $S_PRODUCT_BRAND_LIST1_SHOW_8;

	$strColor1			= $S_PRODUCT_BRAND_LIST1_COLOR_1;
	$strColor2			= $S_PRODUCT_BRAND_LIST1_COLOR_2;
	$strColor3			= $S_PRODUCT_BRAND_LIST1_COLOR_3;
	$strColor4			= $S_PRODUCT_BRAND_LIST1_COLOR_4;
	$strColor5			= $S_PRODUCT_BRAND_LIST1_COLOR_5;
	$strTitleShow		= $S_PRODUCT_BRAND_LIST1_TITLE_SHOW_USE;
	$intTitleMaxsize	= $S_PRODUCT_BRAND_LIST1_TITLE_MAXSIZE;

//	echo $intWSize.":".$intHSize;


	$intPR_NO			= $_POST["pr_no"]			? $_POST["pr_no"]			: $_REQUEST["pr_no"];

	/* 통화 */
	$strMoneyIconL		= "";
	$strMoneyIconR		= "";
	if($strMoney =="sign")		{ $strMoneyIconL = $S_SITE_CUR_MARK1; } 
	else if($strMoney =="won")	{ $strMoneyIconR = $S_SITE_CUR_MARK2; } 
	else if($strMoney =="icon")	{ $strMoneyIconL = sprintf(" <img src='/himg/icon/%s/%s'>", $S_SITE_LNG_PATH,$strMoneyIcon); } 
	else						{ $strMoneyIcon = ""; }

	/* 타이틀 */
	$strTitleCode		= "";
	if($strTitleShow == "style") { $strTitleCode = $strTitle; }
	else if($strTitleShow == "image") { $strTitleCode = sprintf("<img src='%s'/>", $strTitleFile); }

	/* 정보 세팅 */
	$productMgr->setP_BRAND($intPR_NO);
	$productMgr->setSearchHCode1($strSearchHCode1);
	$productMgr->setSearchHCode2($strSearchHCode2);
	$productMgr->setSearchHCode3($strSearchHCode3);
	$productMgr->setSearchHCode4($strSearchHCode4);

	$productMgr->setSearchField($strSearchField);
	$productMgr->setSearchKey($strSearchKey);
	
	$productMgr->setSearchWebView("Y");
	$productMgr->setSearchPriceView("Y");
	$productMgr->setSearchSort($strSearchSort);
	$productMgr->setSearchIcon1($strSearchIcon1);
	$productMgr->setSearchIcon2($strSearchIcon2);
	$productMgr->setSearchIcon3($strSearchIcon3);
	$productMgr->setSearchIcon4($strSearchIcon4);
	$productMgr->setSearchIcon5($strSearchIcon5);
	$productMgr->setSearchIcon6($strSearchIcon6);
	$productMgr->setSearchIcon7($strSearchIcon7);
	$productMgr->setSearchIcon8($strSearchIcon8);
	$productMgr->setSearchIcon9($strSearchIcon9);
	$productMgr->setSearchIcon10($strSearchIcon10);

	$productMgr->setSearchColor($strSearchColor);
	$productMgr->setSearchSize($strSearchSize);

	$productMgr->setSearchStartPrice(getPriceToCur($strSearchStartPrice));
	$productMgr->setSearchEndPrice(getPriceToCur($strSearchEndPrice));
	$productMgr->setP_SHOP_NO($intProductShopNo);

	/* 데이터 리스트 */
	$intTotal								= $productMgr->getProdTotal($db);													// 데이터 전체 개수 

	$intPageLine							= $intWList * $intHList;															// 리스트 개수 
	$intPage								= ( $intPage )				? $intPage		: 1;
	$intFirst								= ( $intTotal == 0 )		? 1				: $intPageLine * ( $intPage - 1 );
	$productMgr->setLimitFirst( $intFirst );
	$productMgr->setPageLine( $intPageLine );


	$result							= $productMgr->getProdList($db);	

	$intPageBlock					= 10;															// 블럭 개수 
	$intListNum						= $intTotal - ( $intPageLine * ( $intPage - 1 ) );				// 번호
	$intTotPage						= ceil( $intTotal / $intPageLine );
	/* 데이터 리스트 */


	/* 브랜드 정보 */
	$intPR_NO				= $_POST["pr_no"]			? $_POST["pr_no"]			: $_REQUEST["pr_no"];
	$productMgr->setPR_NO($intPR_NO);
	$brandRow				= $productMgr->getProdBrandView($db);
	$strSearchHCodeName1	= $brandRow['PR_NAME'];

	/** 2013.04.26 다국어 버전 추가 **/
	$strPL_LNG = $S_SITE_LNG;
	$productMgr->setPL_PR_NO($intPR_NO);
	$productMgr->setPL_LNG($strPL_LNG);
	$brandRowLng				= $productMgr->getProdBrandLngList($db, "OP_SELECT");
	if($brandRowLng['PL_PR_HTML']):
		$brandRow['PR_HTML']	= $brandRowLng['PL_PR_HTML'];
	endif;

	/* 2013.07.01 Top Include 추가 */
	if (file_exists("{$S_DOCUMENT_ROOT}{$S_SHOP_HOME}/layout/menu/brandListTopHtml.inc.php")){
		include "{$S_DOCUMENT_ROOT}{$S_SHOP_HOME}/layout/menu/brandListTopHtml.inc.php";
	}
	/* 2013.07.01 Top Include 추가 */
	
	/** 2013.04.26 다국어 버전 추가 **/
	echo "<div class=\"top_brand\">";
	echo $brandRow['PR_HTML'];
	echo "</div>";
	/* 브랜드 정보 */

	/* 카테고리명 */
	if ($strSearchHCode1){
		$cateMgr->setC_CODE($strSearchHCode1);
		$strSearchHCodeName1 = $cateMgr->getCateLevelName($db);
	}

	if($strSearchHCode1 && $strSearchHCode2):
		$cateMgr->setC_CODE($strSearchHCode1.$strSearchHCode2);
		$strSearchHCodeName2 = $cateMgr->getCateLevelName($db);
	endif;
	/* 카테고리명 */

	/**** 서브 카테고리 ****/
	include "brandList.subCate.index.inc.php";

	// 스킨
	if($intTotal == 0) :
		echo "<div class=\"noListWrap\">";
		echo $LNG_TRANS_CHAR["PS00001"]; //"등록된 상품이 없습니다.";	// 차후 페이지 제작
		echo "</div>";
	else :
		include "prodList.PL".SUBSTR($strBrandListSkin,2).".skin.html.php";
	endif;

	## 초기화
	$intWSize 			= "";
	$intHSize			= "";
	$intWList 			= "";
	$intHList			= "";
?>

