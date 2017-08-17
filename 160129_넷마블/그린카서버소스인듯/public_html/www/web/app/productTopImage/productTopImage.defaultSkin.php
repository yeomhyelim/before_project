<?php
	/**
	 * eumshop app - productTopImage - defaultSkin
	 *
	 * 상품 브랜드 리스트를 불러옵니다.
	 *
	 * @package		eumshop shopping mall
	 * @author		ExpressionEngine Dev HeeSung Kim
	 * @copyright	Copyright (c) 2012 - 2013, Eumshop, Inc.
	 * @license		http://www.eumshop.com/user_guide/license.html
	 * @link		http://www.eumshop.com
	 * @since		Version 1.0
	 * @filesource	/www/web/app/productTopImage/productTopImage.default.php
	 * @manual		menuType=app&mode=productTopImage&lcate=007&mcate=001&scate=&fcate=
	 * @history
	 *				2014.05.15 kim hee sung - 개발 완료
	 *				2014.06.15 kim hee sung - ajkorea mobile 작업을 하면서 language 값 받는 부분 수정
	 *										- 버그 수정(image 설정 부분 잘못되어 있었음)
	 */

	## 설정 파일 
	if(!$strAppID):
		$intAppID				= $intAppID + 1; 
		$strAppID				= "PRODUCT_TOP_IMAGE_{$intAppID}";
	endif;

	## 설정 파일 
	require_once MALL_SHOP . "/conf/site_skin_product.conf.inc.php";
	
	## 기본 설정
	$strAppCate1 = $_GET['lcate'];
	$strAppCate2 = $_GET['mcate'];
	$strAppCate3 = $_GET['scate'];
	$strAppCate4 = $_GET['fcate'];
	$strAppLang	 = $EUMSHOP_APP_INFO['lang'];
	$strAppTopUse = $S_PRODUCT_TOP_USE_OP;	
	$strAppImg = $S_PRODUCT_TOP_IMG;
	$strAppHtml = $S_PRODUCT_HTML_IMG;
	$strAppTopCat = $S_PRODUCT_TOP_CAT_OP;
	$aryCateImg = $S_ARY_CATE_IMG;
	$aryCateHtml = $S_ARY_CATE_HTML;

	## 언어 설정
	if(!$strAppLang) { $strAppLang = $S_SITE_LNG; }
	$strAppLangLower = strtolower($strAppLang);

	## 탑이미지 사용 유무 체크
	## A : 모든 상품페이지에 한개의 이미지만 적용
	## B : 카테고리별 이미지 업로드 적용
	if(!in_array($strAppTopUse, array("A", "B"))) { return; }

	## 카테고리별 이미지 정의하기
	if($strAppTopUse == "B"):
		$strAppImg = "";
		$strAppHtml = "";
		$strAppCate = "";
		for($i = 1; $i <= 4; $i++):
			if($strAppTopCat < $i) { continue; }

			$strAppCate .= ${"strAppCate{$i}"};			
			$strAppHtml = $aryCateHtml[$strAppCate]['TOP_HTML'];

			## IMAGE 설정
			$strAppImgTemp = $aryCateImg[$strAppCate]['TOP_IMG'];
			$strAppImgTemp = "/upload/layout/product/top/{$strAppLangLower}/{$strAppImgTemp}";
			if(!is_file(MALL_SHOP . $strAppImgTemp)) { continue; }
			$strAppImg = $strAppImgTemp;
		endfor;
	endif;

	## 이미지 출력하기
	if($strAppImg) { echo "<div class='prodTopImgWrap'><img src='{$strAppImg}'></div>"; }