<?
	$no				= 1;
	$strUse			= ${"S_PRODUCT_BRAND_MAIN{$no}_USE"};
	$strUse			= "Y";

	if($strUse == "Y") :

		/* 정의 */
		$intWSize 			= ${"S_PRODUCT_BRAND_MAIN{$no}_IMG_SIZE_W"};
		$intHSize			= ${"S_PRODUCT_BRAND_MAIN{$no}_IMG_SIZE_H"};
		$intWList 			= ${"S_PRODUCT_BRAND_MAIN{$no}_IMG_VIEW_W"};
		$intHList			= ${"S_PRODUCT_BRAND_MAIN{$no}_IMG_VIEW_H"};
		$strWAlign			= ${"S_PRODUCT_BRAND_MAIN{$no}_WORD_ALIGN"};
		$strMoney			= ${"S_PRODUCT_BRAND_MAIN{$no}_MONEY_TYPE"};
		$strMoneyIcon		= ${"S_PRODUCT_BRAND_MAIN{$no}_MONEY_ICON"};
		$strShow1			= ${"S_PRODUCT_BRAND_MAIN{$no}_SHOW_1"};
		$strShow2			= ${"S_PRODUCT_BRAND_MAIN{$no}_SHOW_2"};
		$strShow3			= ${"S_PRODUCT_BRAND_MAIN{$no}_SHOW_3"};
		$strShow4			= ${"S_PRODUCT_BRAND_MAIN{$no}_SHOW_4"};
		$strShow5			= ${"S_PRODUCT_BRAND_MAIN{$no}_SHOW_5"};
		$strShow6			= ${"S_PRODUCT_BRAND_MAIN{$no}_SHOW_6"};
		$strShow7			= ${"S_PRODUCT_BRAND_MAIN{$no}_SHOW_7"};
		$strShow8			= ${"S_PRODUCT_BRAND_MAIN{$no}_SHOW_8"};
		$strColor1			= ${"S_PRODUCT_BRAND_MAIN{$no}_COLOR_1"};
		$strColor2			= ${"S_PRODUCT_BRAND_MAIN{$no}_COLOR_2"};
		$strColor3			= ${"S_PRODUCT_BRAND_MAIN{$no}_COLOR_3"};
		$strColor4			= ${"S_PRODUCT_BRAND_MAIN{$no}_COLOR_4"};
		$strColor5			= ${"S_PRODUCT_BRAND_MAIN{$no}_COLOR_5"};
		$strTitleShow		= ${"S_PRODUCT_BRAND_MAIN{$no}_TITLE_SHOW_USE"};
		$strTitleFile		= ${"S_PRODUCT_BRAND_MAIN{$no}_TITLE_FILE_NAME"};

		$intPR_NO		= $_POST["pr_no"]			? $_POST["pr_no"]			: $_REQUEST["pr_no"];

		/* 데이터 리스트 */
		$intTotal								= $productMgr->getProdBrandList($db, "OP_COUNT");									// 데이터 전체 개수 

		$intPageLine							= $intWList * $intHList;															// 리스트 개수 
		$intPage								= ( $intPage )				? $intPage		: 1;
		$intFirst								= ( $intTotal == 0 )		? 1				: $intPageLine * ( $intPage - 1 );
		$productMgr->setLimitFirst( $intFirst );
		$productMgr->setPageLine( $intPageLine );


		$result							= $productMgr->getProdBrandList($db, "OP_LIST");	

		$intPageBlock					= 10;															// 블럭 개수 
		$intListNum						= $intTotal - ( $intPageLine * ( $intPage - 1 ) );				// 번호
		$intTotPage						= ceil( $intTotal / $intPageLine );
		/* 데이터 리스트 */

		include "brandMain." . $S_PRODUCT_BRAND_MAIN1_DESIGN . ".skin.html.php";

	endif;
?>

