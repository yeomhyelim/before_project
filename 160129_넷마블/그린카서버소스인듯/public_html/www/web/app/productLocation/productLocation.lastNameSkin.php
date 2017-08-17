<?php
	/**
	 * eumshop app - productLocation - lastNameSkin
	 *
	 * 상품 리스트 앱입니다.
	 *
	 * @package		eumshop shopping mall
	 * @author		ExpressionEngine Dev HeeSung Kim
	 * @copyright	Copyright (c) 2012 - 2013, Eumshop, Inc.
	 * @license		http://www.eumshop.com/user_guide/license.html
	 * @link		http://www.eumshop.com
	 * @since		Version 1.0
	 * @filesource	/www/web/app/productLocation/productLocation.lastNameSkin.php
	 * @manual		&mode=productLocation
	 * @history
	 *				2014.06.19 kim hee sung - 개발 완료
	 */

	## app id
	if(!$strAppID):
		$intAppID				= $intAppID + 1;
		$strAppID				= "PRODUCT_LOCATION_{$intAppID}";
	endif;

	## 모듈 설정
	$objProductMgrModule		= new ProductMgrModule($db);

	## 기본 설정
	$strAppLang					= $EUMSHOP_APP_INFO['lang'];
	$strAppCate1				= $EUMSHOP_APP_INFO['cate1'];
	$strAppCate2				= $EUMSHOP_APP_INFO['cate2'];
	$strAppCate3				= $EUMSHOP_APP_INFO['cate3'];
	$strAppCate4				= $EUMSHOP_APP_INFO['cate4'];
	$isAppProdCntShow			= $EUMSHOP_APP_INFO['prodCntShow'];
	$strAppHost					= $EUMSHOP_APP_INFO['host'];
	$strAppCate					= $strAppCate1 . $strAppCate2 . $strAppCate3 . $strAppCate4;
	if(!$isAppProdCntShow) { $isAppProdCntShow = false; }
	if(!$strAppCate) { return; }
	if(!$strAppLang) { $strAppLang = $S_SITE_LNG; }
	if(!$strAppHost) { $strAppHost = $strHostType; }
	$strAppLangLower			= strtolower($strAppLang);

	##  상품 카테고리 정보 불러오기
	include_once MALL_SHOP . "/conf/category.{$strAppLangLower}.inc.php";

	## 카테고리 이름 설정
	$strCateName				= $S_ARY_CATE_NAME[$strAppCate]['CATE_NM'];
	if(!$strCateName) { return; }

	## 상품 개수 구하기
//합계 안 맞음. 남덕희
//<!-- mobile\product\include\prodList.index.inc.php 에서 합계처리. -->
/*
	if($isAppProdCntShow):
		$param = "";
		$param['LNG'] = $strAppLang;

		if($strAppHost == "mobile"):
			$param['P_MOB_VIEW'] = "Y";
		else:
			$param['P_WEB_VIEW'] = "Y";
		endif;

		$param['P_CATE_LIKE'] = $strAppCate;
		$intProdCnt = $objProductMgrModule->getProductMgrSelectEx("OP_COUNT", $param);
		if(!$intProdCnt) { $intProdCnt = 0; }
		$intProdCnt = number_format($intProdCnt);
	endif;
*/
?>
<!-- eumshop app - productLocation - lastNameSkin (<?php echo $strAppID?>) -->
<!--
<div id="<?php echo $strAppID;?>">
<?php echo $strCateName;?><?php if($isAppProdCntShow):?>(<?php echo $intProdCnt;?>)<?php endif;?>
</div>
-->

<div id="PRODUCT_LOCATION_1">
	<?php echo $strCateName;?>
</div>
<!-- eumshop app - productLocation - lastNameSkin (<?php echo $strAppID?>) -->