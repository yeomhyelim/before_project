<?php
	/**
	 * eumshop app - bannerSlider - default2Skin
	 *
	 * 움직이는 배너
	 *
	 * @package		eumshop shopping mall
	 * @author		ExpressionEngine Dev HeeSung Kim
	 * @copyright	Copyright (c) 2012 - 2013, Eumshop, Inc.
	 * @license		http://www.eumshop.com/user_guide/license.html
	 * @link		http://www.eumshop.com
	 * @since		Version 1.0
	 * @filesource
	 * @manual		&mode=bannerSlider&skin=default2Skin&code=TOP_BANNER&itemCnt=1
	 * @history
	 *				2014.05.27 kim hee sung - 개발 완료
	 */

	/**
	 * app id
	 */
	$intAppID					= $intAppID + 1; 
	$strAppID					= "BANNDER_SLIDER_{$intAppID}";
//	$strAppID					= "APP_ID_{$intAppID}";

	$aryScript[]				= "/common/jquery-sliders/source/jquery.slides.js";
	$aryScript[]				= "/common/js/app/bannerSlider/bannerSlider.default2Skin.js";
	$aryScriptEx[]				= "/common/jquery-sliders/source/jquery.slides.js";
	$aryScriptEx[]				= "/common/js/app/productSlider/bannerSlider.default2Skin.js";



	/**
	 * 움직이는 배너 코드 값이 없으면 사용 할 수 없습니다.
	 */
	 if(!$EUMSHOP_APP_INFO['code']):
		echo "code 값을 입력하세요.";
		exit;
	 endif;


	/**
	 * 슬라이더 배너 데이터 불러오기
	 */
	$S_SLIDER_INFO = "";
	include SHOP_HOME . "/conf/sliderBanner/sliderBanner_{$EUMSHOP_APP_INFO['code']}.conf.inc.php";
	$strLinkType				= $S_SLIDER_INFO['SB_LINK_TYPE'];
	if($strLinkType == "B") { $strLinkType = "_blank"; }

	/**
	 * 기본 설정
	 */
	$intSliderListLength			= 0;
	$intSliderItemCnt				= $EUMSHOP_APP_INFO['itemCnt'];
	$strPlay						= $EUMSHOP_APP_INFO['play'];
	

?>
<!-- bannder slider html code (<?php echo $strAppID?>) -->
<div id="<?php echo $strAppID?>">
	<div productSlider itemCnt="<?=$intSliderItemCnt?>" play="<?=$strPlay?>">
		<div class="jcarousel-wrapper">
			<div class="jcarousel">
				<ul>
<?foreach($S_SLIDER_INFO['SI_IMG'] as $key => $data):
	$strLink		= $S_SLIDER_INFO['SI_LINK'][$key];
	$strText		= $S_SLIDER_INFO['SI_TEXT'][$key];	?>
					<li><?if($strLink):?><a href="<?=$strLink?>" target="<?=-$strLinkType?>"><?endif;?><img src="/upload/slider/<?=$data?>"><?if($strLink):?></a><?endif;?></li>
<?endforeach;?>
				</ul>
			</div>

			<a href="#" class="jcarousel-control-prev"><span>&lsaquo;</span></a>
			<a href="#" class="jcarousel-control-next"><span>&rsaquo;</span></a>

			<p class="jcarousel-pagination"></p>
		</div>
	</div>
</div>
<!-- bannder slider html code (<?php echo $strAppID?>) -->
<?
	$S_SLIDER_INFO = "";
?>