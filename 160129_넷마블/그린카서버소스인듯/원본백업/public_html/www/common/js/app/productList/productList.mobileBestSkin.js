	/**
	 *
	 * productList - mobileBestSkin - script 파일
	 *
	 * @package		eumshop shopping mall
	 * @author		ExpressionEngine Dev YoungMi Park, HeeSung Kim
	 * @copyright	Copyright (c) 2012 - 2014, Eumshop, Inc.
	 * @license		http://www.eumshop.co.kr/user_guide/license.html
	 * @link		http://www.eumshop.co.kr
	 * @since		Version 1.0
	 * @filesource	/common/js/app/productList/productList.mobileBestSkin.js
	 * @manual		
	 * @history
	 *				2014.05.16 Kim Hee-Sung - 개발 완료
	 */

	/**
	 * 페이지 첫 시작시 실행
	 */
	function goProductListMobileBestSkinReadyMoveEvent(strAppID) {

	}
	

	// 상품 뷰페이지 이동
	function goProductListmobileBestSkinViewMoveEvent(strAppID, strPCode) {

		var isPriceHide				= G_APP_PARAM[strAppID]['PRICE_HIDE'];
		var S_PRICE_SHOW_VIEW		= G_APP_PARAM[strAppID]['S_PRICE_SHOW_VIEW'];

		if(isPriceHide && !S_PRICE_SHOW_VIEW) {
			if(!strMemberLogin) {
				alert('로그인이 필요합니다.');
				return;
			} else {
				alert('권한이 없습니다.');
				return;
			}
		}

		var data					= new Object();
		data['menuType']			= "product";
		data['mode']				= "view";
		data['prodCode']			= strPCode;

		C_getAddLocationUrl(data);
	}
