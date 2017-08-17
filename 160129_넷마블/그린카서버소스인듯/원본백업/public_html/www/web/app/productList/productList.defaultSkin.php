<?php
	/**
	 * eumshop app - productList - defaultSkin
	 *
	 * 상품 리스트를 불러옵니다.
	 *
	 * @package		eumshop shopping mall
	 * @author		ExpressionEngine Dev HeeSung Kim
	 * @copyright	Copyright (c) 2012 - 2013, Eumshop, Inc.
	 * @license		http://www.eumshop.com/user_guide/license.html
	 * @link		http://www.eumshop.com
	 * @since		Version 1.0
	 * @filesource	/www/web/app/productList/productList.defaultSkin.php
	 * @manual		menuType=app&mode=productList
	 * @history
	 *				2014.05.14 kim hee sung - 개발 완료
	 */

	## app id
	if(!$strAppID):
		$intAppID				= $intAppID + 1; 
		$strAppID				= "PRODUCT_LIST_{$intAppID}";
	endif;

	## 스크립트 설정
	$aryScriptEx[]				= "/common/js/app/productList/productList.defaultSkin.js";

	## 모둘 설정
	require_once MALL_CONF_LIB . "ProductMgr.php";
	$objProductListModule		= new ProductListModule($db);
	$objShopSiteModule			= new ShopSiteModule($db);
	$productMgr = new ProductMgr();

	## 기본설정
	$strAppHtml				= $EUMSHOP_APP_INFO['html'];
	$strAppGet				= $EUMSHOP_APP_INFO['get'];
	$intAppPageLine			= $EUMSHOP_APP_INFO['pageLine'];
	$intAppSH_NO			= $EUMSHOP_APP_INFO['sh_no']; // 입점사 번호
	$strLang				= $S_SITE_LNG;
	$strLangLower			= strtolower($strLang);


	## POST 설정
	if($strAppGet != "N"):
		$strSort				= $_GET["sort"];
		$strP_CODE				= $_GET["prodCode"];
		$strSearchField			= $_GET["searchField"];
		$strSearchKey			= $_GET["searchKey"];
		$intPage				= $_GET["page"];
		$strSearchHCode1		= $_GET["lcate"];
		$strSearchHCode2		= $_GET["mcate"];
		$strSearchHCode3		= $_GET["scate"];
		$strSearchHCode4		= $_GET["fcate"];
		$strSearchProdShare		= $_GET["lcateShare"];
		$strSearchSort			= $_GET["sort"];
		$strSearchIcon1			= $_GET["searchIcon1"];
		$strSearchIcon2			= $_GET["searchIcon2"];
		$strSearchIcon3			= $_GET["searchIcon3"];
		$strSearchIcon4			= $_GET["searchIcon4"];
		$strSearchIcon5			= $_GET["searchIcon5"];
		$strSearchIcon6			= $_GET["searchIcon6"];
		$strSearchIcon7			= $_GET["searchIcon7"];
		$strSearchIcon8			= $_GET["searchIcon8"];
		$strSearchIcon9			= $_GET["searchIcon9"];
		$strSearchIcon10		= $_GET["searchIcon10"];
		$strSearchColor			= $_GET["searchColor"];
		$strSearchSize			= $_GET["searchSize"];
		$strSearchStartPrice	= $_GET["searchStartPrice"];
		$strSearchEndPrice		= $_GET["searchEndPrice"];
		$strSearchListIcon		= $_GET["searchListIcon"];
		$strSearchBrand			= $_GET["searchBrand"];
		$intPageLine			= $_GET["pageLine"];
		$intAppPR_NO			= $_GET['pr_no']; // 브랜드 번호
		$intAppSH_NO			= $_GET['sh_no']; // 입점사 번호

		## 추가검색어사용
		for($i=1;$i<=10;$i++){
			${"strAddSearchList".$i} = $_GET["prodSearchCode".$i];
		}
	endif;



	## 설정 파일 
	require_once MALL_SHOP . "/conf/site_skin_product.conf.inc.php";
	require_once MALL_PROD_FUNC; // 상품함수관련

	## 기본 설정 정의
	if (!$intWSize) $intWSize 			= $S_PRODLIST_IMG_SIZE_W;
	if (!$intHSize) $intHSize			= $S_PRODLIST_IMG_SIZE_H;
	if (!$intWList) $intWList 			= $S_PRODLIST_IMG_VIEW_W;
	if (!$intHList) $intHList			= $S_PRODLIST_IMG_VIEW_H;
	$strWAlign							= $S_PRODLIST_WORD_ALIGN;
	$strMoney							= $S_PRODLIST_MONEY_TYPE;
	$strMoneyIcon						= $S_PRODLIST_MONEY_ICON;
	$strShow1							= $S_PRODLIST_SHOW_1;
	$strShow2							= $S_PRODLIST_SHOW_2;
	$strShow3							= $S_PRODLIST_SHOW_3;
	$strShow4							= $S_PRODLIST_SHOW_4;
	$strShow5							= $S_PRODLIST_SHOW_5;
	$strShow6							= $S_PRODLIST_SHOW_6;
	$strShow7							= $S_PRODLIST_SHOW_7;
	$strShow8							= $S_PRODLIST_SHOW_8;
	$strColor1							= $S_PRODLIST_COLOR_1;
	$strColor2							= $S_PRODLIST_COLOR_2;
	$strColor3							= $S_PRODLIST_COLOR_3;
	$strColor4							= $S_PRODLIST_COLOR_4;
	$strColor5							= $S_PRODLIST_COLOR_5;
	$strTitleShow						= $S_PRODLIST_TITLE_SHOW_USE;
	$strTitleFile						= $S_PRODLIST_TITLE_FILE_NAME;
	$strNaviUse							= $S_PRODUCT_NAVI_USE_OP;
	$intTitleMaxsize					= $S_PRODLIST_TITLE_MAXSIZE;


	## 세로줄 설정
	if($intWList && $intPageLine):
		$intHList = $intPageLine / $intWList;
	endif;

	## 통화 정의
	$strMoneyIconL		= "";
	$strMoneyIconR		= "";
	if($strMoney == "sign" || $strMoney == "won"){ 
		$strMoneyIconL = getCurMark();
		$strMoneyIconR = getCurMark2();
	} 
	else if($strMoney =="icon")	{ $strMoneyIconL = sprintf(" <img src='/himg/icon/%s'>", $strMoneyIcon); } 
	else						{ $strMoneyIcon = ""; }

	## 타이틀 정의
	$strTitleCode		= "";
	if($strTitleShow == "style") { $strTitleCode = $strTitle; }
	else if($strTitleShow == "image") { $strTitleCode = sprintf("<img src='%s'/>", $strTitleFile); }

	## 상품 포인트 보여줄때 특정 그룹만 보여주는지에 대한 처리 
	$strProdPointViewSpecGroupYN = "N";
	if ($strShow3 == "Y"){
		if (is_array($S_FIX_PROD_POINT_VIEW_SPEC_GROUP_LIST)){
			if ($g_member_login && in_array($g_member_group,$S_FIX_PROD_POINT_VIEW_SPEC_GROUP_LIST)){
				$strProdPointViewSpecGroupYN = "Y";
			}
		} else {
			$strProdPointViewSpecGroupYN = "Y";
		}
	}
	
	## 데이터 정의
	$prodListParam			= "";
	$prodListParam["P_LNG"] = $S_SITE_LNG;
	
	##1.카테고리
	$prodListParam["P_CATE"]	= "";
	if ($strSearchHCode1 || $strSearchHCode2 || $strSearchHCode3 || $strSearchHCode4){
		$prodListParam["P_CATE"] = $strSearchHCode1.$strSearchHCode2.$strSearchHCode3.$strSearchHCode4;
	}

	##2.브랜드
	if ($strSearchBrand){
		$prodListParam['P_BRAND'] = $strSearchBrand; 
	}else if($intAppPR_NO) {
		$prodListParam['P_BRAND'] = $intAppPR_NO; 
	}

	##3.입점사 검색
	if ($intProductShopNo){
		$prodListParam['P_SHOP_NO'] = $intProductShopNo; 
	}else if($intAppSH_NO) {
		$prodListParam['P_SHOP_NO'] = $intAppSH_NO; 
	}

	## 4.상품출시일 검색(사용자)
	if ($strSearchLaunchStartDt && $strSearchLaunchEndDt){
		$prodListParam['P_LAUNCH_START_DT'] = $strSearchLaunchStartDt;
		$prodListParam['P_LAUNCH_END_DT']	= $strSearchLaunchEndDt;
	}
	## 5.상품등록일 검색(사용자)
	if ($strSearchRepStartDt && $strSearchRepEndDt){
		$prodListParam['P_REP_START_DT']	= $strSearchRepStartDt;
		$prodListParam['P_REP_END_DT']		= $strSearchRepEndDt;
	}
	## 6.상품웹보임
	$prodListParam['P_WEB_VIEW']			= "Y";
	
	## 7.모바일보임
	if ($strProdMobView == "Y"){
		$prodListParam['P_MOB_VIEW']		= "Y";
	}

	## 8.상품아이콘검색
	$strProdIcon							= "";
	if ($strSearchIcon1 || $strSearchIcon2 || $strSearchIcon3 || $strSearchIcon4 || $strSearchIcon5 || $strSearchIcon6 || $strSearchIcon7 || $strSearchIcon8 || $strSearchIcon9 || $strSearchIcon10){ 
		for($i=1;$i<=10;$i++){
			if (${"strSearchIcon".$i}) $strProdIcon .= "Y|";
			else $strProdIcon .= "N|";
		}
		if ($strProdIcon) $prodListParam['P_ICON'] = $strProdIcon; 
	}

	## 9.상품컬러검색
	if ($strSearchColor){
		$prodListParam['P_COLOR'] = $strSearchColor;
	}

	## 10.상품사이즈검색
	if ($strSearchColor){
		$prodListParam['P_SIZE'] = $strSearchSize;
	}

	## 11. 가격검색
	if ($strSearchStartPrice && $strSearchEndPrice){
		if ($S_FIX_PROD_SEARCH_PRICE_ST_CUR != "Y"){
			$strSearchStartPrice = getPriceToCur($strSearchStartPrice);
			$strSearchEndPrice = getPriceToCur($strSearchEndPrice);
		}

		$prodListParam['P_START_PRICE'] = $strSearchStartPrice;
		$prodListParam['P_END_PRICE'] = $strSearchEndPrice;
	}

	## 12.상품리스트아이콘
	if ($strSearchListIcon){
		$prodListParam['P_LIST_ICON'] = $strSearchListIcon;
	}

	## 13.상품검색
	if ($strSearchField && $strSearchKey){
		$prodListParam['P_SEARCH_KEY'] = $strSearchKey;
		$prodListParam['P_SEARCH_FIELD'] = $strSearchField;
	}

	## 14.상품좋아요
	if ($S_FIX_PRODUCT_LIST_LIKE_USE == "Y" && ($g_member_no && $g_member_login)){
		$prodListParam['M_NO'] = $g_member_no;
		if (!$strSearchProdLikeType) $strSearchProdLikeType = "prodList";
		$prodListParam['P_PROD_LIKE'] = $strSearchProdLikeType;
	}

	## 15.상품정렬
	if ($strSearchSort){
		$prodListParam['P_SEARCH_SORT'] = $strSearchSort;
		if ($strSearchSort == "BD") $prodListParam['P_REVIEW_SHOW'] = 'Y';
		if ($strSearchSort == "SD") $prodListParam['P_ORDER_SHOW']	= 'Y';
	}

	##상품테이블정의
	$prodListParam['P_IMG_SHOW']	= "Y";
	$prodListParam['P_BRAND_SHOW']	= "Y";	
	
	##상품리스트 리뷰보이기 사용
	if ($S_PROD_REVIEW_USE == "Y"){
		$prodListParam['P_REVIEW_SHOW'] = 'Y';
	}

	##상품리스트 ADD_CART 사용
	if ($S_PROD_ADD_CART_USE == "Y"){
		$prodListParam['P_OPT_SHOW']	= 'Y';
	}

	##상품검색
	if ($S_PRODUCT_SEARCH_USE == "Y"){
		$prodListParam['P_ADD_SEARCH_SHOW'] = "Y";

		for($i=1;$i<=10;$i++){			
			$strAddSearchWord		= ${"strAddSearchList".$i};

			if ($strAddSearchWord){
				$prodListParam['P_ADD_SEARCH'.$i] = $strAddSearchWord;
			}
		}
	}

	##상품리스트 다국어출력 사용
	if ($S_PROD_MANY_LANG_VIEW == "Y"){
		$prodListParam['P_MANY_LNG_VIEW'] = "Y";
	}

	## 데이터 불러오기
	$intAppPage							= $intPage;
	$intAppTotal						= $objProductListModule->getProductListSelectEx("OP_COUNT",$prodListParam);											// 데이터 전체 개수 
	$intAppPageLine						= ( $intAppPageLine )		? $intAppPageLine	: $intWList * $intHList;
	$intAppPageLine						= ( $intAppPageLine )		? $intAppPageLine	: 10;										// 리스트 개수 
	$intAppPage							= ( $intAppPage )			? $intAppPage		: 1;
	$intAppFirst						= ( $intAppTotal == 0 )		? 0					: $intAppPageLine * ( $intAppPage - 1 );

	$prodListParam['LIMIT']				= $intAppFirst;

//	$productMgr->setLimitFirst($intAppFirst);
	if($strProdListAllView == "Y") { $intAppPageLine = $intTotal; }
//	$productMgr->setPageLine($intAppPageLine);
	$prodListParam['LIMIT_LINE']		= $intAppPageLine;

	$param['P_SEARCH_SORT']				= $strSort;
	$resAppResult						= $objProductListModule->getProductListSelectEx("OP_LIST",$prodListParam);
//	echo $db->query;

	$intAppPageBlock					= 10;																				// 블럭 개수 
	$intAppListNum						= $intAppTotal - ( $intAppPageLine * ( $intAppPage - 1 ) );							// 번호
	$intAppTotPage						= ceil( $intAppTotal / $intAppPageLine );

	## paging 설정
	$intAppPage				= $intAppPage;									// 현재 페이지
	$intAppTotPage			= $intAppTotPage;								// 전체 페이지 수
	$intAppTotBlock			= ceil($intAppTotPage / $intAppPageBlock);		// 전체 블럭 수
	$intAppBlock			= ceil($intAppPage / $intAppPageBlock);			// 현재 블럭
	$intAppPrevBlock		= (($intAppBlock - 2) * $intAppPageBlock) + 1;	// 이전 블럭
	$intAppNextBlock		= ($intAppBlock * $intAppPageBlock) + 1;		// 다음 블럭
	$intAppFirstBlock		= (($intAppBlock - 1) * $intAppPageBlock) + 1;	// 현재 블럭 시작 시저
	$intAppLastBlock		= $intAppBlock * $intAppPageBlock;				// 현재 블럭 종료 시점
	if($intAppFirstBlock <= 0) { $intAppFirstBlock	= 1; }
	if($intAppPrevBlock  <= 0) { $intAppPrevBlock		= 1; }
	if($intAppNextBlock >= $intAppTotPage) { $intAppNextBlock	= $intAppTotPage; }
	if($intAppLastBlock >= $intAppTotPage) { $intAppLastBlock	= $intAppTotPage; }

	## 페이지 시작/마지막 번호 설정
	$intAppFirstNo			= ($intAppPage <= 1) ? $intAppPage : (($intAppPage - 1) * $intAppPageLine);
	$intAppLastNo			= $intAppPage * $intAppPageLine;
	if(!$intAppFirstNo) { $intAppFirstNo = ""; }
	if($intAppLastNo > $intAppTotal) { $intAppLastNo = $intAppTotal; }

	## 페이지명 설정
	$strProductListName = "";
	if($intAppSH_NO):

		## 임점사 정보 불러오기
		$param = "";
		$param['SH_NO'] = $intAppSH_NO;
		$aryRow = $objShopSiteModule->getShopSiteSelectEx("OP_SELECT", $param);
		$strST_NAME = $aryRow['ST_NAME'];
		$strST_NAME_ENG = $aryRow['ST_NAME_ENG'];

		## 페이지명 설정
		$strProductListName = $strST_NAME;
		if($strLang != "KR") { $strProductListName = $strST_NAME_ENG; }
	endif;

	## 다국어 언어별 문장 설정
	$aryLanguage			= "";
	$aryLanguage['OS00013']	= $LNG_TRANS_CHAR['OS00013'];
	$aryLanguage['PW00010']	= $LNG_TRANS_CHAR['PW00010'];
	$aryLanguage['PW00009']	= $LNG_TRANS_CHAR['PW00009'];
	$aryLanguage['OS00029']	= $LNG_TRANS_CHAR['OS00029'];

	$aryLanguage['CW00034']	= $LNG_TRANS_CHAR['CW00034'];
	$aryLanguage['CW00001']	= $LNG_TRANS_CHAR['CW00001'];
	
	$aryLanguage['MW00043']	= $LNG_TRANS_CHAR['MW00043']; // 다음
	$aryLanguage['MW00052']	= $LNG_TRANS_CHAR['MW00052']; // 이전
	
	$aryLanguage['PW00033']	= $LNG_TRANS_CHAR['PW00033']; // new arrivals
	$aryLanguage['PW00030']	= $LNG_TRANS_CHAR['PW00030']; // best sellers
	$aryLanguage['PW00031']	= $LNG_TRANS_CHAR['PW00031']; // accumulated sales
	$aryLanguage['PW00034']	= $LNG_TRANS_CHAR['PW00034']; // price:low to high
	$aryLanguage['PW00035']	= $LNG_TRANS_CHAR['PW00035']; // price:high to low

	## 화페단위표시
	$arrSiteCurUnitMark		= getCurUnitMark();
	$strSiteCurUintLeftMark	= $arrSiteCurUnitMark["L"];
	$strSiteCurUintRightMark= $arrSiteCurUnitMark["R"];

	if($strAppHtml == "N") { return; }
?>
<!-- eumshop app - productList - defaultSkin (<?php echo $strAppID?>) -->
<style>
	div.prodNewListWrap table{width:100%;}
	div.prodNewListWrap tr td{vertical-align:top;}
	div.prodNewListWrap .listProdImg{width:<?=$intWSize?>px;height:<?=$intHSize?>px;}
	div.prodNewListWrap .title{color:<?=$strColor1?>;}
	div.prodNewListWrap .comment{color:<?=$strColor2?>;}
	div.prodNewListWrap .pricePoint{color:<?=$strColor3?>;}
	div.prodNewListWrap .priceConsumer{color:<?=$strColor4?>}
	div.prodNewListWrap .priceSale{color:<?=$strColor5?>;}
	div.productInfoWrap{width:<?=$intWSize?>px;margin-bottom:20px;text-align:<?=$strWAlign?>}
</style>
<script>
	G_APP_PARAM['<?php echo $strAppID;?>']							= new Object();
	G_APP_PARAM['<?php echo $strAppID;?>']['LANGUAGE']				= <?php echo json_encode($aryLanguage);?>; 
	G_APP_PARAM['<?php echo $strAppID;?>']['MODE']					= "<?php echo $strAppMode;?>";
	G_APP_PARAM['<?php echo $strAppID;?>']['SKIN']					= "<?php echo $strAppSkin;?>"; 
	G_APP_PARAM['<?php echo $strAppID;?>']['TOTAL']					= "<?php echo $intAppTotal;?>"; 
	G_APP_PARAM['<?php echo $strAppID;?>']['NO_FIRST']				= "<?php echo $intAppFirstNo;?>"; 
	G_APP_PARAM['<?php echo $strAppID;?>']['NO_LAST']				= "<?php echo $intAppLastNo;?>"; 

	G_APP_PARAM['<?php echo $strAppID;?>']['PAGE']					= "<?php echo $intAppPage;?>"; 
	G_APP_PARAM['<?php echo $strAppID;?>']['PREV_BLOCK']			= "<?php echo $intAppPrevBlock;?>"; 
	G_APP_PARAM['<?php echo $strAppID;?>']['NEXT_BLOCK']			= "<?php echo $intAppNextBlock;?>"; 
	G_APP_PARAM['<?php echo $strAppID;?>']['FIRST_BLOCK']			= "<?php echo $intAppFirstBlock;?>"; 
	G_APP_PARAM['<?php echo $strAppID;?>']['LAST_BLOCK']			= "<?php echo $intAppLastBlock;?>"; 
	G_APP_PARAM['<?php echo $strAppID;?>']['SORT']					= "<?php echo $strSort;?>"; 
	G_APP_PARAM['<?php echo $strAppID;?>']['PAGE_LINE']				= "<?php echo $intPageLine;?>"; 

	

	G_APP_PARAM['<?php echo $strAppID;?>']['PRODUCT_LIST_NAME']		=  "<?php echo $strProductListName;?>";
	G_APP_PARAM['<?php echo $strAppID;?>']['PRODUCT_OPT']			=  new Object();
	G_APP_PARAM['<?php echo $strAppID;?>']['PRODUCT_OPT_ATTR']		=  new Object();
	G_APP_PARAM['<?php echo $strAppID;?>']['PRODUCT_ROW']			=  new Object();
	G_APP_PARAM['<?php echo $strAppID;?>']['SITE_CUR']				=  "<?php echo $S_SITE_CUR?>";	
	G_APP_PARAM['<?php echo $strAppID;?>']['SITE_LNG_USD_YN']		=  "<?php echo $S_ARY_CUR[$S_SITE_LNG]['USD'][2]?>";
	G_APP_PARAM['<?php echo $strAppID;?>']['SITE_CUR_MARK1']		=  "<?php echo $strSiteCurUintLeftMark?>";
	G_APP_PARAM['<?php echo $strAppID;?>']['SITE_CUR_MARK2']		=  "<?php echo $strSiteCurUintRightMark?>";
	G_APP_PARAM['<?php echo $strAppID;?>']['PRODUCT_ADD_OPT']		=  new Object();
	G_APP_PARAM['<?php echo $strAppID;?>']['PRODUCT_ADD_OPT_ATTR']	=  new Object();
</script>
<?php if($strMenuType == "app"):?>
페이지이름 : <span class="product-list-name" appID="<?php echo $strAppID;?>"></span>
전체 개수 : <span class="product-list-total" appID="<?php echo $strAppID;?>"></span>
시작 번호 : <span class="product-list-no-first" appID="<?php echo $strAppID;?>"></span>
종료 번호 : <span class="product-list-no-last" appID="<?php echo $strAppID;?>"></span>
페이지 : <span class="product-list-paginate" appID="<?php echo $strAppID;?>"></span>
정렬 : <span class="product-list-sort" appID="<?php echo $strAppID;?>"></span>
출력개수 : <span class="product-list-pageline" appID="<?php echo $strAppID;?>"></span>
<?php endif;?>
<div class="prodNewListWrap">
	<table>
		<?php for($i=0;$i<$intHList;$i++):?>
		<tr>
			<?php for($j=0;$j<$intWList;$j++):

				## 데이터 설정
				$row = mysql_fetch_array($resAppResult); 
				
				## 기본 설정
				$strP_CODE = $row['P_CODE'];
				$strP_NAME = $row['P_NAME'];
				$intP_GRADE = $row['P_GRADE'];
				$intP_GRADE_CNT = $row['P_GRADE_CNT'];
				$strP_COLOR = $row['P_COLOR'];
				$intP_SALE_PRICE = $row['P_SALE_PRICE'];
				$intP_POINT = $row['P_POINT'];
				$strP_POINT_TYPE = $row['P_POINT_TYPE'];
				$strP_POINT_OFF1 = $row['P_POINT_OFF1'];
				$strP_POINT_OFF2 = $row['P_POINT_OFF2'];
				$strPM_REAL_NAME = $row['PM_REAL_NAME'];
				$strP_EVENT = $row['P_EVENT'];
				$strP_LIST_ICON = $row['P_LIST_ICON'];
				$strP_COLOR_IMG = $row['P_COLOR_IMG'];
				$strP_BRAND_NAME = $row['P_BRAND_NAME'];
				$strP_MODEL = $row['P_MODEL'];
				$strP_ETC = $row['P_ETC'];
				$intP_CONSUMER_PRICE = $row['P_CONSUMER_PRICE'];
				$strP_PRICE_TEXT = $row['P_PRICE_TEXT'];
				$intP_OPT_CNT	= $row['P_OPT_CNT'];

				## 색상 설정
				$aryP_COLOR_IMG = "";
				if($strP_COLOR && $strShow6):
					$aryP_COLOR = explode("|", $strP_COLOR);
					foreach($aryP_COLOR as $key => $val):
						if($val != "Y") { continue; }
						if($S_ARY_PROD_COLOR[$key]['USE'] != "Y") { continue; }
						$aryP_COLOR_IMG[] = $S_ARY_PROD_COLOR[$key]['IMG'];
					endforeach;
				endif;

				## 적립금 설정
				$intProdPoint = getProdPoint($intP_SALE_PRICE, $intP_POINT, $strP_POINT_TYPE, $strP_POINT_OFF1, $strP_POINT_OFF2);
				$intProdPointMoney = 0;
				if($intProdPoint <= 0) { $strShow3 = ""; }
				if($strShow3 == "Y") { $intProdPointMoney = getCurToPrice($intProdPoint); }

				## 소비자가격 설정
				$strTextConsumerPrice = "";
				$strTextConsumerPriceUsd = "";
				if($intP_CONSUMER_PRICE > 0):
					$intP_CONSUMER_PRICE = getCurToPrice($intP_CONSUMER_PRICE);
					$strTextConsumerPrice = "{$strMoneyIconL}{$intP_CONSUMER_PRICE}{$strMoneyIconR}";
					if($S_ARY_CUR[$S_SITE_LNG]["USD"][2] == "Y") { $strTextConsumerPriceUsd = getCurMark("USD") . getCurToPrice($intP_CONSUMER_PRICE, "US") . getCurMark2("USD"); }
				endif;

				## 상품 가격 설정
				$strTextPriceUsd = "";
				$strTextPrice = $strMoneyIconL . getProdDiscountPrice($row) . $strMoneyIconR;
				if($S_ARY_CUR[$S_SITE_LNG]["USD"][2] == "Y") { $strTextPriceUsd = getCurMark("USD") . getProdDiscountPrice($row,"1",0,"US") . getCurMark2("USD"); }
				if($strP_PRICE_TEXT) { $strTextPrice = $strP_PRICE_TEXT; } 

				## 이미지 설정
				if(!$strPM_REAL_NAME) { $strPM_REAL_NAME = "/upload/product/20120821/prodImg2/2012082100006.jpg"; }

				## 리스트 이미지를 동영상으로 보이게 하며 특정 카테고리에서만 동영상이 보이도록 처리
				$strProdMovieUrl = "";
				if($S_FIX_PROD_VIEW_MOVIE_FLAG == "Y" && !in_array(SUBSTR($row['P_CATE'],0,3),$S_FIX_PROD_VIEW_MOVIE_CATE_NOT_LIST)):
					$productMgr->setP_CODE($strP_CODE);
					$productMgr->setPM_TYPE("movie1");
					$prodMovieRow = $productMgr->getProdImg($db);
					$strProdMovieUrl = $prodMovieRow[0]['PM_REAL_NAME'];
				endif;

				## 이벤트 정보
				$strEvent = "";
				if($strP_EVENT > 0 && getProdEventInfo($row) == "Y"):
					if($S_EVENT_INFO[$strP_EVENT]["PRICE_TYPE"] == "1"):
						$strEvent = $S_EVENT_INFO[$row[P_EVENT]]["PRICE_MARK"];
					endif;
				endif;

				## 아이콘 설정
				$iconTag = "";
				$icon = explode("/", $strP_LIST_ICON);
				for($x=0; $x<sizeof($icon); $x++):
					$iconTag .= $S_ARY_PRODUCT_LIST_ICON[$icon[$x]];
				endfor;
				
				## 상품명 설정
				$strP_NAME = strHanCutUtf2($strP_NAME, $intTitleMaxsize, "N"); 

				## 평점 설정
				if($intP_GRADE > 0 && $intP_GRADE_CNT > 0){
					$intGrade = $intP_GRADE / $intP_GRADE_CNT;
				}else{
					$intGrade = 0;
				}

				## td style 설정
				$strStyleTD = "";
				if($j==($intWList-1)) { $strStyleTD = "width:{$intWSize}px"; }

				## div class 설정
				$strClassDiv = "productInfoWrap";
				if($j==($intWList-1)) { $strClassDiv .= " endProdList"; }

				## div style 설정
				$strStyleDiv = "width:{$intWSize}px;text-align:{$strWAlign}";


				if($_SERVER['HTTP_HOST'] == "ausieshop.eumshop.co.kr"):
					$strShow9 = "Y";
					$strShow10 = "Y";
				endif;
			?>
			<td style="<?php echo $strStyleTD;?>">
			<?php if($row):?>
				<div class="<?php echo $strClassDiv?>" style="<?php echo $strStyleDiv;?>">
					<div class="bestIco_<?php echo $j;?>"></div>
					<?php if($strProdMovieUrl):?>
					<iframe width="<?php echo $intWSize?>" height="<?php echo $intHSize?>" src="<?php echo $strProdMovieUrl1?>" frameborder="0" allowfullscreen></iframe>
					<?php else:?>
					<a href="javascript:goProductListDefaultSkinViewMoveEvent('<?php echo $row['P_CODE']?>');"><img src="<?php echo $row['PM_REAL_NAME']?>" class="listProdImg" style="width:<?php echo $intWSize?>px;height:<?php echo $intHSize?>px;"/></a>
					<?php endif;?>
					<?php if($strShow9 == "Y"):?>
					<div class="icoScore">
						<img src="/himg/board/icon/icon_star_<?php echo $intGrade;?>.png" class="iconGrade"> <?php echo $intP_GRADE_CNT;?>
					</div>
					<?php endif;?>
					<?php if($strShow10 == "Y"):?>
					<a href="javascript:goProductListDefaultSkinAddCartEvent('<?=$strAppID;?>','<?=$strP_CODE?>','<?=$intP_OPT_CNT?>');" class="btnAddCart">ADD TO CART</a>
					<?php endif;?>
					<?php if($strEvent):?>
					<div class="sailInfo">
						<strong><?php echo $strEvent;?></strong>%									
					</div>
					<?php endif;?>
					<div class="prodInfoSum">
						<ul>
							<?php if($iconTag):?>
							<li class="prodIcon">
								<?php echo $iconTag;?>
								<div class='clr'></div>
							</li>
							<?php endif;?>
							<?php if($aryP_COLOR_IMG):?>
							<li class="color">
								<?php foreach($strP_COLOR_IMG as $url):?>
								<span><img src="<?php echo $url?>"/></span>
								<?php endforeach;?>
							</li>
							<?php endif;?>
							<?php if($strShow8 == "Y"):?>
							<li class="brandTit"><?php echo $strP_BRAND_NAME; // 브렌드?></li>
							<?php endif;?>
							<?php if($strShow1 == "Y"):?>
							<li class="title"><a href="javascript:goProductListDefaultSkinViewMoveEvent('<?php echo $strP_CODE?>');"><?php echo $strP_NAME;?></a></li>
							<?php endif;?>
							<?php if($strShow7 == "Y"):?>
							<li class="model"><?php echo $strP_MODEL; // 모델명?></li>
							<?php endif;?>
							<?if($strShow2 == "Y"):?>
							<li class="comment"><?php echo $strP_ETC; // 상품설명?></li>
							<?php endif;?>
							<?php if($strShow3 == "Y"):?>
							<li class="pricePoint"><?php echo $intProdPointMoney; // 적립금?></li>
							<?php endif;?>
							<?php if($strShow4 == "Y"):?>
								<?php if($strTextConsumerPriceUsd):?>
								<li class="priceConsumerUsd"><s><?php echo $strTextConsumerPriceUsd // 소비자가격(USD)?></s></li>
								<li class="priceConsumer"><s>(<?php echo $strTextConsumerPrice; // 소비자가격?>)</s></li>
								<?php else:?>
								<li class="priceConsumer"><s><?php echo $strTextConsumerPrice; // 소비자가격?></s></li>
								<?php endif;?>	
							<?php endif;?>
							<?php if($strShow5 == "Y"):?>
								<?php if($strTextPriceUsd):?>
								<li class="priceSaleUsd"><span><?php echo $strTextPriceUsd // USD 달러?></span></li>
								<li class="priceSale"><span>(<?php echo $strTextPrice; // 가격?>)</span></li>
								<?php else:?>
								<li class="priceSale"><span><?php echo $strTextPrice; // 가격?></span></li>
								<?php endif;?>	
							<?php endif;?>
						</ul>
					</div>
					<div class="clr"></div>
					<div class="prodAddInfo"></div>

					<!-- popup Cart -->
					<div class="popupCartWrap" style="display:none" id="prodAddCart_<?=$strP_CODE?>">
						<div class="closeWrap">
							<div class="total">TOTAL : <span class="price" id="prodAddCartTotal"><?=$S_SITE_CUR_MARK1?>0</span></div>
							<a href="javascript:goProductListDefaultSkinAddCartCloseEvent('<?=$strAppID?>','<?=$strP_CODE?>');" class="btnClose">CLOSE</a>
							<div class="clr"></div>
						</div>

						<div class="optionArea" id="divOptionArea">
							<div class="option1Wrap" id="optionTable">
								
							</div>
							
							<div class="option2Wrap" id="optionTable2">					
								<table class="optCntTable">
									<tbody>
										<tr>
											<td class="titCnt">Qty</td>
											<td class="cnt">
												<ul>
													<li><input type="text" id="qty" name="qty" value="1"></li>
													<li class="btnCntUpDown">
														<a href="javascript:goProductListDefaultSkinAddCartQtyEvent('<?=$strAppID?>','<?=$strP_CODE?>','up');"><img src="../himg/product/A0001/btn_prod_cnt_up.gif"></a>
														<a href="javascript:goProductListDefaultSkinAddCartQtyEvent('<?=$strAppID?>','<?=$strP_CODE?>','down');"><img src="../himg/product/A0001/btn_prod_cnt_down.gif"></a>
													</li>
												</ul>
											</td>
											<td class="price"><?=$S_SITE_CUR_MARK1?>0</td>
											<!--<td class="btnCntClose"><a href="#" class="btnClose"><img src="/upload/images/btn_close_b.gif" alt="닫기" /></a></td>//-->
										</tr>									
									</tbody>
								</table>					
							</div>
							<div class="btnWrap">
								<a href="javascript:goProductListDefaultSkinAddCartOptEvent('<?=$strAppID?>','<?=$strP_CODE?>');" class="btnCart">ADD TO CART</a>
							</div>
						</div>

						<div class="option3Wrap" id="optionTable3" style="display:none">					
							<div class="txtBox">
								<?=$LNG_TRANS_CHAR['OS00013']?>
							</div>
							<div class="btnWrap">
								<a href="javascript:goProductListDefaultSkinAddCartMoveEvent();" class="btnConfirm" id="btnAddCartMove"><?=$LNG_TRANS_CHAR['CW00001']?></a>
								<a href="javascript:goProductListDefaultSkinAddCartCloseEvent('<?=$strAppID?>','<?=$strP_CODE?>');" class="btnClose"><?=$LNG_TRANS_CHAR['CW00034']?></a>
							</div>
						</div>
					</div>
				</div>
				<!-- popup Cart -->
				</div>
				<?php endif; ?>
			</td>
			<?php endfor;	?>
		</tr>
		<?php if(!$row) { break; }?>
		<?php endfor; ?>
	</table>
</div>
<!-- eumshop app - productList - defaultSkin (<?php echo $strAppID?>) -->