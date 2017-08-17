<?php
	/**
	 * eumshop app - bannerSlider - fullImageSkin
	 *
	 * 움직이는 배너
	 *
	 * @package		eumshop shopping mall
	 * @author		ExpressionEngine Dev HeeSung Kim
	 * @copyright	Copyright (c) 2012 - 2013, Eumshop, Inc.
	 * @license		http://www.eumshop.com/user_guide/license.html
	 * @link		http://www.eumshop.com
	 * @since		Version 1.0
	 * @filesource	/www/web/app/bannerSlider/bannerSlider.fullImageSkin.php
	 * @manual		&mode=bannerSlider&skin=fullImageSkin&code=TOP_BANNER&itemCnt=1&navi=TOP_BANNER_NAVI
	 * @history
	 *				2014.01.02 kim hee sung - 개발 완료
	 */

	/**
	 * app id
	 */
	if(!$strAppID):
		$intAppID				= $intAppID + 1; 
		$strAppID				= "BANNER_SLIDER_{$intAppID}";
	endif;

	## 스크립트 설정
	$aryScript[]				= "/common/bxslider-4-master/jquery.bxslider.js";
	$aryScript[]				= "/common/js/app/bannerSlider/bannerSlider.fullImageSkin.js";
//	$aryScript[]				= "/common/woothemes-FlexSlider/jquery.flexslider.js";
	$aryScriptEx[]				= "/common/bxslider-4-master/jquery.bxslider.js";
	$aryScriptEx[]				= "/common/js/app/bannerSlider/bannerSlider.fullImageSkin.js";
//	$aryScriptEx[]				= "/common/woothemes-FlexSlider/jquery.flexslider.js";

	## 기본설정
	$strLang						= $S_SITE_LNG;
	$strLangLower					= strtolower($strLang);
	$intSliderListLength			= 0;
	$intSliderItemCnt				= $EUMSHOP_APP_INFO['itemCnt'];
	$strPlay						= $EUMSHOP_APP_INFO['play'];
	$strEffect						= $EUMSHOP_APP_INFO['effect'];
	$strNavi						= $EUMSHOP_APP_INFO['navi'];
	$strNavi2						= $EUMSHOP_APP_INFO['navi2'];
	$strAutoControls				= $EUMSHOP_APP_INFO['autoControls'];
	$strSliderBanner1				= SHOP_HOME . "/conf/sliderBanner/sliderBanner_{$EUMSHOP_APP_INFO['code']}.conf.inc.php";
	$strSliderBanner2				= SHOP_HOME . "/conf/sliderBanner/{$strLangLower}/sliderBanner_{$EUMSHOP_APP_INFO['code']}.conf.inc.php";
	$strSliderBanner1Navi			= SHOP_HOME . "/conf/sliderBanner/sliderBanner_{$strNavi}.conf.inc.php";
	$strSliderBanner2Navi			= SHOP_HOME . "/conf/sliderBanner/{$strLangLower}/sliderBanner_{$strNavi}.conf.inc.php";
	$strSliderBanner1Navi2			= SHOP_HOME . "/conf/sliderBanner/sliderBanner_{$strNavi2}.conf.inc.php";
	$strSliderBanner2Navi2			= SHOP_HOME . "/conf/sliderBanner/{$strLangLower}/sliderBanner_{$strNavi2}.conf.inc.php";
	if(!$strEffect) { $strEffect = "fade"; }
	if(!$strAutoControls) { $strAutoControls = false; }


	## conf 파일 설정
	if(is_file($strSliderBanner2)) { $strSliderBanner1 = $strSliderBanner2; }
	if(is_file($strSliderBanner2Navi)) { $strSliderBanner1Navi = $strSliderBanner2Navi; }
	if(is_file($strSliderBanner2Navi2)) { $strSliderBanner1Navi2 = $strSliderBanner2Navi2; }
	
	## 슬라이더 배너 데이터 불러오기
	$S_SLIDER_INFO = "";
	include $strSliderBanner1;
	$arySliderInfo = $S_SLIDER_INFO;
	$strLinkType = $arySliderInfo['SB_LINK_TYPE'];
	if($strLinkType == "B") { $strLinkType = "_blank"; }
	if($strLinkType == "M") { $strLinkType = ""; }

	## 슬라이더 배너 데이터 불러오기
	if($strSliderBanner1Navi):
		$S_SLIDER_INFO = "";
		@include $strSliderBanner1Navi;
		$arySliderNaviInfo = $S_SLIDER_INFO;
	endif;

	## 슬라이더 배너 데이터 불러오기(마우스오버)
	if($strSliderBanner1Navi2):
		$S_SLIDER_INFO = "";
		@include $strSliderBanner1Navi2;
		$arySliderNaviInfo2 = $S_SLIDER_INFO;
	endif;

?>
<style>
/*
	div.sliderBannerWarp {position:absolute;left:50%;top:0;margin-left:-955px;overflow:hidden;}
	div.sliderBannerWarp li{text-align:center;}
	div.sliderBannerWarp .flex-control-nav{position:absolute;top:400px;left:50%;z-index:99999;}
*/
	div.sliderBannerWarp {height:354px;overflow:hidden;}
</style>
<!-- eumshop app - bannerSlider - fullImageSkin (<?php echo $strAppID?>) -->
<script>
	G_APP_PARAM['<?php echo $strAppID;?>']					= new Object();
	G_APP_PARAM['<?php echo $strAppID;?>']['MODE']			= "<?php echo $strAppMode;?>";
	G_APP_PARAM['<?php echo $strAppID;?>']['SKIN']			= "<?php echo $strAppSkin;?>"; 
	G_APP_PARAM['<?php echo $strAppID;?>']['EFFECT']		= "<?php echo $strEffect;?>"; 
	G_APP_PARAM['<?php echo $strAppID;?>']['AUTO_CONTROLS']	= "<?php echo $strAutoControls;?>"; 
</script>
<div id="<?php echo $strAppID?>">
	<div class="sliderBannerArea" style="position: relative;">
	<!-- 오른쪽 클릭 막기 div -->
	<div style="position: absolute;width: 300px; height: 354px; right: 0; z-index: 99999;"></div>	
		<div class="sliderBannerWarp">
			<ul class="slides">
				<?foreach($arySliderInfo['SI_IMG'] as $key => $data):
					$strLink		= $arySliderInfo['SI_LINK'][$key];
					$strText		= $arySliderInfo['SI_TEXT'][$key];	?>
									<li><?if($strLink):?><a href="<?=$strLink?>" target="<?=$strLinkType?>"><?endif;?><img src="/upload/slider/<?=$data?>"><?if($strLink):?></a><?endif;?></li>
				<?endforeach;?>
			</ul>
		</div>
		<?php if($arySliderNaviInfo):?>
		<div class="slides_navi">
			<div class="slides_naviWrap">
			<?php foreach($arySliderNaviInfo['SI_IMG'] as $key => $data):
					
					if( $arySliderNaviInfo2 && $arySliderNaviInfo2['SI_IMG']):
						$strOverImg = $arySliderNaviInfo2['SI_IMG'][$key];
						if($strOverImg) { $strOverImg = " overImg=\"/upload/slider/{$strOverImg}\""; }
					endif;
			?>
			 <a data-slide-index="<?php echo $key;?>" href="" class="navi_<?php echo $key;?>"><img src="/upload/slider/<?php echo $data;?>"<?php echo $strOverImg;?>></a>
			 <?php endforeach;?>
			 </div>
		</div>
		<?php endif;?>
	</div>
</div>
<!-- eumshop app - bannerSlider - fullImageSkin (<?php echo $strAppID?>) -->
