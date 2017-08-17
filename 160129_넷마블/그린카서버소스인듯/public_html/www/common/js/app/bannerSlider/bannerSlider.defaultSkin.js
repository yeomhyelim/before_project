	/**
	 *
	 * bannerSlider - defaultSkin - script 파일
	 *
	 * @package		eumshop shopping mall
	 * @author		ExpressionEngine Dev YoungMi Park, HeeSung Kim
	 * @copyright	Copyright (c) 2012 - 2014, Eumshop, Inc.
	 * @license		http://www.eumshop.co.kr/user_guide/license.html
	 * @link		http://www.eumshop.co.kr
	 * @since		Version 1.0
	 * @filesource	/common/js/app/bannerSlider/bannerSlider.defaultSkin.js
	 * @manual		
	 * @history
	 *				2014.05.23 Kim Hee-Sung - 개발 완료
	 */

	/**
	 * 페이지 첫 시작시 실행
	 */
	function goBannerSliderDefaultSkinReadyMoveEvent(strAppID) {
		
		var objTarget = $('#' + strAppID);
		objTarget.bannerSlider(strAppID);	
	}


	(function($) {

		$.fn.bannerSlider = function(strAppID) {

			var itemCnt			= 1;
			var play			= G_APP_PARAM[strAppID]['PLAY'];
			var jcarousel		= $(this).find(".jcarousel");

			jcarousel
				.on('jcarousel:reload jcarousel:create', function () {

					var width = jcarousel.innerWidth();
					var height = jcarousel.innerHeight();
						width = width / itemCnt;
						height = height / itemCnt;

					$(this).find("li").css('width', width + 'px');
					$(this).find("li").css('height', height + 'px');
				})
				.jcarousel({
					wrap: 'circular'
				});

			$(this).find('.jcarousel-control-prev')
				.jcarouselControl({
					target: '-=' + itemCnt
				});

			$(this).find('.jcarousel-control-next')
				.jcarouselControl({
					target: '+=' + itemCnt
				});

			$(this).find('.jcarousel-pagination')
				.on('jcarouselpagination:active', 'a', function() {
					$(this).addClass('active');
				})
				.on('jcarouselpagination:inactive', 'a', function() {
					$(this).removeClass('active');
				})
				.on('click', function(e) {
					e.preventDefault();
				})
				.jcarouselPagination({
					perPage: itemCnt,
					item: function(page) {
						return '<a href="#' + page + '">111<span>' + page + '</span></a>';
					}
				});

			if(play == "auto") {
				// 자동 실행
				jcarousel.jcarousel({
					// Core configuration goes here
				})
				.jcarouselAutoscroll({
					interval: 3000,
					target: '+=' + itemCnt,
					autostart: true
				});
			}

			return this;
		}
	})(jQuery);
