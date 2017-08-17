	/**
	 *
	 * productList - mobilePlanMainSkin - script 파일
	 *
	 * @package		eumshop shopping mall
	 * @author		ExpressionEngine Dev YoungMi Park, HeeSung Kim
	 * @copyright	Copyright (c) 2012 - 2014, Eumshop, Inc.
	 * @license		http://www.eumshop.co.kr/user_guide/license.html
	 * @link		http://www.eumshop.co.kr
	 * @since		Version 1.0
	 * @filesource	/common/js/app/productList/productList.mobilePlanMainSkin.js
	 * @manual		
	 * @history
	 *				2014.06.19 Kim Hee-Sung - 개발 완료
	 */

	/**
	 * 페이지 첫 시작시 실행
	 */
	function goProductListMobilePlanMainSkinReadyMoveEvent(strAppID) {

	}
	

	// 상품 뷰페이지 이동
	function goProductListMobilePlanMainSkinViewMoveEvent(strAppID, strPCode) {

		var data					= new Object();
		data['menuType']			= "product";
		data['mode']				= "view";
		data['prodCode']			= strPCode;

		C_getAddLocationUrl(data);
	}