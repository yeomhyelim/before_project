	/**
	 *
	 * bannerSlider - multiSkin - script 파일
	 *
	 * @package		eumshop shopping mall
	 * @author		ExpressionEngine Dev YoungMi Park, HeeSung Kim
	 * @copyright	Copyright (c) 2012 - 2014, Eumshop, Inc.
	 * @license		http://www.eumshop.co.kr/user_guide/license.html
	 * @link		http://www.eumshop.co.kr
	 * @since		Version 1.0
	 * @filesource	/common/js/app/bannerSlider/bannerSlider.multiSkin.js
	 * @manual		
	 * @history
	 *				2015.01.26 Kim Hee-Sung - 개발 완료
	 */

	/**
	 * 페이지 첫 시작시 실행
	 */
	function goBannerSliderMultiSkinReadyMoveEvent(strAppID) {

		var objTarget = $("#" + strAppID);
		var intCnt = objTarget.find('.slides_navi').length;
		var strEffect = G_APP_PARAM[strAppID]['EFFECT'];
		var strPlay = G_APP_PARAM[strAppID]['PLAY'];

		if(strPlay == 'true' || strPlay == true || strPlay == 1) {
			strPlay = true;
		} else {
			strPlay = false;
		}

		if(intCnt) {
			objTarget.find('.slides').bxSlider({
				mode: strEffect,
				auto: strPlay,
				autoDelay: 3000,
				pause: 3000,
				pagerCustom: objTarget.find('.slides_navi'),
				onSlideBefore: function($slideElement, oldIndex, newIndex) {
					objTarget.find('.sliderPage .now').text(newIndex+1);
				}
			});
		} else {
			objTarget.find('.slides').bxSlider({
				mode: strEffect,
				auto: strPlay,
				autoDelay: 3000,
				pause: 3000,
				onSlideBefore: function($slideElement, oldIndex, newIndex) {
					objTarget.find('.sliderPage .now').text(newIndex+1);
				}
			});
		}

	}