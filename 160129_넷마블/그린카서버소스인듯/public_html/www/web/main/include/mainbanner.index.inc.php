<?
	# 메인 이미지 배너 
	# mainbanner.index.inc.php
?>

<?

	$strUse			= $S_MAIN_SLIDER_USE;
	$strIncFile		= sprintf("%s%s/conf/sliderBanner/sliderBanner_MAIN_BANNER.conf.inc.php", $S_DOCUMENT_ROOT, $S_SHOP_HOME);

	## 버전 2.0 에서 추가된 부분
	if($S_LAYOUT_VERSION == "V2.0"):
		$strIncFile	= sprintf("%s%s/conf/sliderBanner/{$S_SITE_LNG_PATH}/sliderBanner_MAIN_BANNER.conf.inc.php", $S_DOCUMENT_ROOT, $S_SHOP_HOME);
		if(!is_file($strIncFile)):
			$strStLngLower = strtolower($S_ST_LNG);	
			$strIncFile	= sprintf("%s%s/conf/sliderBanner/{$strStLngLower}/sliderBanner_MAIN_BANNER.conf.inc.php", $S_DOCUMENT_ROOT, $S_SHOP_HOME);
		endif;
	endif;

	$strImgFolder	= "/upload/slider/";
	if($strUse && is_file($strIncFile)) :
		// 매인 이미지 배너 사용

		/* 설정 파일 로드 */
		include $strIncFile;

		/* 정의 */
		$strMotionUse		= $S_MAIN_SLIDER_MOTION_USE;
		$strMotionEffect	= $S_MAIN_SLIDER_MOTION_EFFECT;
		$sliderWidth		= $S_MAIN_SLIDER_IMAGE_SIZE_W;
		$sliderHeight		= $S_MAIN_SLIDER_IMAGE_SIZE_H;
		$sliderMotionType	= $S_MAIN_SLIDER_MOTION_TYPE;
		$linkType			= $S_SLIDER_INFO['SB_LINK_TYPE'];		// M => 현재 페이지 열기, B => 새창으로 열기, N => 연결 없음
		$img				= $S_SLIDER_INFO['SI_IMG'];
		$text				= $S_SLIDER_INFO['SI_TEXT'];
		$link				= $S_SLIDER_INFO['SI_LINK'];
		$effect				= "slide";

		if($linkType == "M"):
			$linkType		= "";
		elseif($linkType == "S"):
			$linkType		= "_blank";
		elseif($linkType == "N"):
			$link			= "";
		endif;

		/* 효과가 fade 인 경우...*/
		if($sliderMotionType == "fade"):
 		$effect				= "fade";
		$sliderMotionType	= "";
		endif;

		/* 모션 / 고정 스킨 */
		if($strMotionUse == "Y") :
			include "mainbanner.motion.{$strMotionEffect}.skin.html.php";
		else :
			include "mainbanner.motionFix.skin.html.php";
		endif;
		
	endif;

?>