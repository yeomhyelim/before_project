	/**
	 *
	 * brandList - defaultSkin - script 파일
	 *
	 * @package		eumshop shopping mall
	 * @author		ExpressionEngine Dev YoungMi Park, HeeSung Kim
	 * @copyright	Copyright (c) 2012 - 2014, Eumshop, Inc.
	 * @license		http://www.eumshop.co.kr/user_guide/license.html
	 * @link		http://www.eumshop.co.kr
	 * @since		Version 1.0
	 * @filesource	/www/common/js/app/brandList/brandList.defaultSkin.js
	 * @manual		
	 * @history
	 *				2014.08.07 Kim Hee-Sung - 개발 완료
	 */

	/**
	 * 페이지 첫 시작시 실행
	 */
	function goBrandListDefaultSkinReadyMoveEvent(strAppID) {

		
	}

	// 페이지 이동
	function goBrandListDefaultSkinMoveEvent(strAppID, intPrNo) {

		var data = new Object();

		data['menuType'] = "product";
		data['mode'] = "brandList";
		data['pr_no'] = intPrNo;

		C_getAddLocationUrl(data);
	}