	/**
	 *
	 * SNS 관련 함수 모음
	 *
	 * @package		eumshop shopping mall
	 * @author		ExpressionEngine Dev YoungMi Park, HeeSung Kim
	 * @copyright	Copyright (c) 2012 - 2014, Eumshop, Inc.
	 * @license		http://www.eumshop.co.kr/user_guide/license.html
	 * @link		http://www.eumshop.co.kr
	 * @since		Version 1.0
	 * @filesource	/common/js/classes/sns/SnsClass.js
	 * @manual		
	 * @history
	 *				2014.02.04 Kim Hee-Sung - 개발 완료
	 */

	/**
	 * 페이스북 관련 함수
	 */
	var facebook = new function() {

		this.init		= function(objData) {

			if(typeof FB == "object") { return; }

			var objInitData				= new Object();
			objInitData['appId']		= objData.appId;		// 앱 ID
			objInitData['status']		= true;					// 로그인 상태를 확인
			objInitData['cookie']		= true;					// 쿠키허용
			objInitData['xfbml']		= true;					// parse XFBML

			FB.init(objInitData);
		};
		
		this.ui			= function(objData) {

			if(typeof FB != "object") { return; }

			var objUiData				= new Object();
			objUiData['method']			= 'feed';
			objUiData['link']			= objData.link;
			objUiData['picture']		= objData.picture;
			objUiData['name']			= objData.name;
			objUiData['caption']		= objData.caption;
			objUiData['description']	= objData.description;

			FB.ui(objUiData, objData.callbackFunc);
		};

	};