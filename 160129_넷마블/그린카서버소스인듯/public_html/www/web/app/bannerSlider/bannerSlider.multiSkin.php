<?php
	/**
	 * eumshop app - bannerSlider - multiSkin
	 *
	 * 움직이는 배너 여러 이미지
	 *
	 * @package		eumshop shopping mall
	 * @author		ExpressionEngine Dev HeeSung Kim
	 * @copyright	Copyright (c) 2012 - 2013, Eumshop, Inc.
	 * @license		http://www.eumshop.com/user_guide/license.html
	 * @link		http://www.eumshop.com
	 * @since		Version 1.0
	 * @filesource	/www/web/app/bannerSlider/bannerSlider.multiSkin.php
	 * @manual		menuType=app&mode=bannerSlider&skin=multiSkin&code=SLIDER_2;SLIDER_3;SLIDER_4&effect=horizontal&play=true
	 * @history
	 *				2015.01.26 kim hee sung - 개발 완료
	 */
	
	## app id
	if(!$strAppID):
		$intAppID				= $intAppID + 1; 
		$strAppID				= "BANNER_SLIDER_{$intAppID}";
	endif;

	## 스크립트 설정
	$aryScriptEx[]				= "/common/bxslider-4-master/jquery.bxslider.js";
	$aryScriptEx[]				= "/common/js/app/bannerSlider/bannerSlider.multiSkin.js";

	## 언어설정
	$strLang					= $S_SITE_LNG;
	$strLangLower				= strtolower($strLang);

	## 기본설정
	$strAppCode					= $EUMSHOP_APP_INFO['code'];
	$strEffect					= $EUMSHOP_APP_INFO['effect']; // 'horizontal', 'vertical', 'fade'
	$strPlay					= $EUMSHOP_APP_INFO['play'];
	$strSliderPage				= $EUMSHOP_APP_INFO['sliderPage'];
	if(!$strEffect) { $strEffect = 'fade'; }
	if(!$strPlay) { $strPlay = false; }

	## 코드 정의
	if(!$strAppCode) { return; }
	$aryAppCode = explode(';', $strAppCode);

	## 배너 정보 가져오기
	$S_SLIDER_INFO = '';
	$aryAppBannerList = '';
	foreach($aryAppCode as $key => $code):
		if(!$code) { continue; }
		include MALL_SHOP . '/conf/sliderBanner/' . $strLangLower . '/sliderBanner_' . $code . '.conf.inc.php';
		$aryAppBannerList[] = $S_SLIDER_INFO;
		$S_SLIDER_INFO = '';
	endforeach;

	## script data 만들기
	$aryAppParam = "";
	$aryAppParam['MODE'] = $strAppMode;
	$aryAppParam['SKIN'] = $strAppSkin;
	$aryAppParam['EFFECT'] = $strEffect;
	$aryAppParam['PLAY'] = $strPlay;
	$aryScriptData['APP'][$strAppID] = $aryAppParam;

?>
<div id="<?php echo $strAppID?>">
	<div class="sliderBannerArea">
		<div class="sliderBannerWarp">
			<ul class="slides">
				<?php foreach($aryAppBannerList as $bKey => $arySliderInfo):
					$strLinkType = $arySliderInfo['SB_LINK_TYPE'];
					if($strLinkType == "B") { $strLinkType = "_blank"; }
					if($strLinkType == "M") { $strLinkType = ""; }				
				?>
				<li>
					<?php foreach($arySliderInfo['SI_IMG'] as $sKey => $data):
							$strLink		= $arySliderInfo['SI_LINK'][$sKey];
							$strText		= $arySliderInfo['SI_TEXT'][$sKey];		?>
					<div class="slideItem slideItem_<?php echo $sKey;?>"><?if($strLink):?><a href="<?php echo $strLink;?>" target="<?php echo $strLinkType;?>"><?endif;?><img src="/upload/slider/<?php echo $data?>"><?php if($strLink):?></a><?php endif;?></div>
					<?php endforeach;?>
					<div class="clr"></div>
				</li>
				<?php endforeach;?>
			</ul>
			<?php if($strSliderPage):?>
			<div class="sliderPage"><span class="now">1</span>/<span span="total"><?php echo sizeof($aryAppBannerList);?></span></div>
			<?php endif;?>
		</div>
	</div>
</div>
				