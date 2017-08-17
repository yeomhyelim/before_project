	/**
	 *
	 * bannerSlider - default3Skin - script 파일
	 *
	 * @package		eumshop shopping mall
	 * @author		ExpressionEngine Dev YoungMi Park, HeeSung Kim
	 * @copyright	Copyright (c) 2012 - 2014, Eumshop, Inc.
	 * @license		http://www.eumshop.co.kr/user_guide/license.html
	 * @link		http://www.eumshop.co.kr
	 * @since		Version 1.0
	 * @filesource	/common/js/app/bannerSlider/bannerSlider.default3Skin.js
	 * @manual
	 * @history
	 *				2014.06.15 Kim Hee-Sung - 개발 완료
	 */

	/**
	 * 페이지 첫 시작시 실행
	 */
	function goBannerSliderDefault3SkinReadyMoveEvent(strAppID) {

		var objTarget = $('#' + strAppID);

		objTarget.find(".app-slider").bxSlider({
            auto:false,
            pager: true,
            touchEnabled: true,
            controls:true //전 후 콘트롤 보이기 안보이기

		});
	}
