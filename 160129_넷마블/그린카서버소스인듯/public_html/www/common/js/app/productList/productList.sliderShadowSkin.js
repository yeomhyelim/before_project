	/**
	 *
	 * productList - sliderShadowSkin - script 파일
	 *
	 * @package		eumshop shopping mall
	 * @author		ExpressionEngine Dev YoungMi Park, HeeSung Kim
	 * @copyright	Copyright (c) 2012 - 2014, Eumshop, Inc.
	 * @license		http://www.eumshop.co.kr/user_guide/license.html
	 * @link		http://www.eumshop.co.kr
	 * @since		Version 1.0
	 * @filesource	/common/js/app/productList/productList.sliderShadowSkin.js
	 * @manual		
	 * @history
	 *				2015.01.22 Kim Hee-Sung - 개발 완료
	 */

	/**
	 * 페이지 첫 시작시 실행
	 */
	function goProductListSliderShadowSkinReadyMoveEvent(strAppID) {

		var objTarget = $("#" + strAppID);
		var intMax	= G_APP_PARAM[strAppID]['MAX'];
		var intMin	= G_APP_PARAM[strAppID]['MIN'];
		var intW	= G_APP_PARAM[strAppID]['W'];
		var intH	= G_APP_PARAM[strAppID]['H'];
		var intMove = G_APP_PARAM[strAppID]['MOVE'];
		var intSPoint = G_APP_PARAM[strAppID]['S_POINT'];
		intMove = Number(intMove);
		intSPoint = Number(intSPoint);

		// 첫번째 링크
		var pCode = objTarget.find('.slides li').eq(0).attr('pCode');
		var qty = objTarget.find('.slides li').eq(0).attr('qty');
		var link = './?menuType=product&mode=view&prodCode=' + pCode;
		$('.' + strAppID + '_qty').html(qty);
		$('.' + strAppID + '_link').attr('href', link);

		var objSlider = objTarget.find('.slides').bxSlider({
//			mode:'fade',
			auto: true,
			autoDelay: 3000,
			pause: 3000,
			moveSlides: intMove,
			maxSlides: intMax,
			minSlides: intMin,
			slideWidth: intW,
			slideMargin: intH,
			responsive: true,
			onSlideBefore : function(objData, oldIndex, newIndex , slider ) {
				
				var oindx = intSPoint + (intMove * oldIndex);
				var dindx = intSPoint + (intMove * newIndex);
				$('.slides li').stop().animate({ opacity: 0.4 }, 200);
				for(var i=dindx; i<(dindx+intMove); i++) {
					$('.slides li').eq(i).animate({ opacity: 1 }, 200);
				}	

			},
			onSliderLoad : function(currentIndex) {
				var dindx = intSPoint;
				$('.slides li').stop().animate({ opacity: 0.4 }, 200);
				for(var i=dindx; i<(dindx+intMove); i++) {
					$('.slides li').eq(i).animate({ opacity: 1 }, 200);
				}	
			}				
		});

	}
	

	// 상품 뷰페이지 이동
	function goProductListSliderShadowSkinViewMoveEvent(strAppID, strPCode) {

		var data					= new Object();
		data['menuType']			= "product";
		data['mode']				= "view";
		data['prodCode']			= strPCode;

		C_getAddLocationUrl(data);
	}