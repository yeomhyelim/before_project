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

	## app ID
	if(!$strAppID):
		$intAppID				= $intAppID + 1; 
		$strAppID				= "BANNER_SLIDER_{$intAppID}";
	endif;

	## 스크립트 설정
	$aryScriptEx[]				= "/common/bxslider-4-master/jquery.bxslider.js";
	$aryScriptEx[]				= "/common/js/app/bannerSlider/bannerSlider.default3Skin.js";

	## 기본 설정
	$strLang					= $S_SITE_LNG;
	$strLangLower				= strtolower($strLang);
	$strAppCode					= $EUMSHOP_APP_INFO['code'];
	$strSliderBanner1			= SHOP_HOME . "/conf/sliderBanner/sliderBanner_{$EUMSHOP_APP_INFO['code']}.conf.inc.php";
	$strSliderBanner2			= SHOP_HOME . "/conf/sliderBanner/{$strLangLower}/sliderBanner_{$EUMSHOP_APP_INFO['code']}.conf.inc.php";


	## 체크
	if(!$strAppCode) { return; }
	if(is_file($strSliderBanner2)) { $strSliderBanner1 = $strSliderBanner2; }

	##  슬라이더 배너 데이터 불러오기
	$S_SLIDER_INFO = "";
	include $strSliderBanner1;
	$strAppLinkType = $S_SLIDER_INFO['SB_LINK_TYPE'];
	if($strAppLinkType == "B") { $strAppLinkType = "_blank"; }
?>
<!-- eumshop app - bannerSlider - fullImageSkin (<?php echo $strAppID?>) : MOBILE -->
<script>

	 G_APP_PARAM['<?php echo $strAppID;?>']					= new Object();
	 G_APP_PARAM['<?php echo $strAppID;?>']['MODE']			= "<?php echo $strAppMode;?>";
	 G_APP_PARAM['<?php echo $strAppID;?>']['SKIN']			= "<?php echo $strAppSkin;?>"; 
		
</script>

<div id="<?php echo $strAppID?>">
	<ul class="app-slider">
		<?php foreach($S_SLIDER_INFO['SI_IMG'] as $key => $data):
			$strLink		= $S_SLIDER_INFO['SI_LINK'][$key];
			$strText		= $S_SLIDER_INFO['SI_TEXT'][$key];	?>
		<li><?php if($strLink):?><a href="<?php echo $strLink;?>" target="<?php echo $strLinkType;?>"><?endif;?><img src="/upload/slider/<?php echo $data;?>"><?php if($strLink):?></a><?php endif;?></li>
		<?php endforeach;?>
	</ul>
</div>
<!-- eumshop app - bannerSlider - fullImageSkin (<?php echo $strAppID?>) -->