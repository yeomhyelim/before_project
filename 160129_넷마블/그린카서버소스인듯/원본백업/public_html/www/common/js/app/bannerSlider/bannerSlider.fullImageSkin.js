	/**
	 *
	 * bannerSlider - fullImageSkin - script 파일
	 *
	 * @package		eumshop shopping mall
	 * @author		ExpressionEngine Dev YoungMi Park, HeeSung Kim
	 * @copyright	Copyright (c) 2012 - 2014, Eumshop, Inc.
	 * @license		http://www.eumshop.co.kr/user_guide/license.html
	 * @link		http://www.eumshop.co.kr
	 * @since		Version 1.0
	 * @filesource	/common/js/app/bannerSlider/bannerSlider.fullImageSkin.js
	 * @manual		
	 * @history
	 *				2014.05.23 Kim Hee-Sung - 개발 완료
	 */

	/**
	 * 페이지 첫 시작시 실행
	 */
	function goBannerSliderFullImageSkinReadyMoveEvent(strAppID) {

		// 기본설정
		var objTarget = $("#" + strAppID);
		var intCnt = objTarget.find('.slides_navi').length;
		var autoControls = G_APP_PARAM[strAppID]['AUTO_CONTROLS'];
		var autoEffect = G_APP_PARAM[strAppID]['EFFECT'];

		// autoControls 설정
		if(!autoControls || autoControls == false || autoControls == 'false')
			autoControls = false;
		else
			autoControls = true;

		// 슬라이더
		if(intCnt) {
			objTarget.find('.slides').bxSlider({
				mode:autoEffect,
				auto: true,
				autoDelay: 3000,
				autoControls: autoControls,
				pause: 3000,
				pagerCustom: objTarget.find('.slides_navi')
			});
		} else {
			objTarget.find('.slides').bxSlider({
				mode:autoEffect,
				auto: true,
				autoDelay: 3000,
				autoControls: autoControls,
				pause: 3000
			});
		}

	}


