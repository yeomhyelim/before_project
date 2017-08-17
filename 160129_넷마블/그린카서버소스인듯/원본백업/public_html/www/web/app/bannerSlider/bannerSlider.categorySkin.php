<?php

	/**
	 * eumshop app - bannerSlider - default3Skin
	 *
	 * 움직이는 배너
	 * 모바일 페이지에서 슬라이더 기능이 작동합니다.
	 *
	 * @package		eumshop shopping mall
	 * @author		ExpressionEngine Dev HeeSung Kim
	 * @copyright	Copyright (c) 2012 - 2013, Eumshop, Inc.
	 * @license		http://www.eumshop.com/user_guide/license.html
	 * @link		http://www.eumshop.com
	 * @since		Version 1.0
	 * @filesource	/www/web/app/bannerSlider/bannerSlider.default3Skin.php
	 * @manual		&mode=bannerSlider&skin=default3Skin&code=MAIN_BANNER
	 * @history
	 *				2014.06.15 kim hee sung - 개발 완료
	 */

	$strAppID ='';
	## app ID
	if(!$strAppID):
		$intAppID				= $intAppID + 1;
		$strAppID				= "BANNER_SLIDER_{$intAppID}";
	endif;

	## 스크립트 설정
	$aryScriptEx[]				= "../common/js/iscroll-5.1.3.js";
	//$aryScriptEx[]				= "/common/js/app/bannerSlider/bannerSlider.defaultSkin.js";
	$aryScriptEx[]				= "/common/js/app/bannerSlider/bannerSlider.categorySkin.js";

	## 기본 설정
	$strLang					= $S_SITE_LNG;
	$strLangLower				= strtolower($strLang);
	$strAppCode					= $EUMSHOP_APP_INFO['code'];

	include_once "{$S_DOCUMENT_ROOT}/conf/category.{$S_SITE_LNG_PATH}.inc.php";


	## 체크
	if(!$strAppCode) { return; }
	if(is_file($strSliderBanner2)) { $strSliderBanner1 = $strSliderBanner2; }


	## STEP 1.
	## 사용 유무 체크
	$mainMenuUse = "Y";
	if(!is_array($S_ARY_CATE1)) { $mainMenuUse = "N"; }


	## STEP 2.
	## 카테고리 실행
	if($mainMenuUse == "Y"){

		/*if($MAIN_MENU_PRODUCT_COUNT_USE == "Y"):
			// 카테고리별 상품 개수 사용 하는 경우.
			echo MALL_CONF_LIB."ProductMgr.php";
			require_once MALL_CONF_LIB."ProductMgr.php";
			$productMgr		= new ProductMgr();
			$param			= "";
			$aryCateTotal	= $productMgr->getProdTotalGroupbyCateEx($db, "OP_ARYLIST", $param);
		endif;
		print_r($aryCateTotal);*/

?>
		<nav id="topMenu">
		<ul id="scroller">
				<?php
				foreach($S_ARY_CATE1 as $key => $cate1)
				{
					$menu		= "";
					$cateTag	= "";

					if($cate1['VIEW'] == "N") { continue; }
					if($cate1['SHARE'] == "Y") { continue; }

					$menu = $cate1['NAME'];

					if($cate1['IMG1'])
					{
						$menu		= "<img src='{$cate1['IMG1']}'/>";
					}

					if($cate1['IMG1'] && $cate1['IMG2'])
					{
						$menu		= "<img src='{$cate1['IMG1']}' overImg='{$cate1['IMG2']}'/>";
					}
				?>
				<li><a href='./?menuType=product&mode=list&lcate=<?=$cate1['CODE']?>' class='mn<?=$key?>'><?=$menu.$cateTag?></a></li>
				<?php
				}
				?>

			</ul>
			<span id="scroller-left" class="scroller-arr-left" data-cclick="MOBILE_C,SCROLLER,LEFT,0"></span>
			<span id="scroller-right" class="scroller-arr-right active" data-cclick="MOBILE_C,SCROLLER,RIGHT,0"></span>
		</nav>
<?
}
?>