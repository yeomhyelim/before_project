	/**
	 *
	 * brandList - sliderSkin - script 파일
	 *
	 * @package		eumshop shopping mall
	 * @author		ExpressionEngine Dev YoungMi Park, HeeSung Kim
	 * @copyright	Copyright (c) 2012 - 2014, Eumshop, Inc.
	 * @license		http://www.eumshop.co.kr/user_guide/license.html
	 * @link		http://www.eumshop.co.kr
	 * @since		Version 1.0
	 * @filesource	/common/js/app/brandList/brandList.sliderSkin.js
	 * @manual		
	 * @history
	 *				2014.05.14 Kim Hee-Sung - 개발 완료
	 */

	/**
	 * 페이지 첫 시작시 실행
	 */
	function goBrandListSliderSkinReadyMoveEvent(strAppID) {

        var jcarousel = $('#' + strAppID).find('.jcarousel');
		var itemCnt = G_APP_PARAM[strAppID]['ITEM_CNT'];
		var moveCnt = G_APP_PARAM[strAppID]['MOVE_CNT'];

        jcarousel.on('jcarousel:reload jcarousel:create', function () {
			var width = jcarousel.innerWidth();
			
			width = width / itemCnt;
            jcarousel.jcarousel('items').css('width', width + 'px');
		}).jcarousel({
			wrap: 'circular'
        });
		
        jcarousel.find('.jcarousel-control-prev').jcarouselControl({
			target: '-=' + moveCnt
		});

        jcarousel.find('.jcarousel-control-next').jcarouselControl({
			target: '+=' + moveCnt
		});

        jcarousel.find('.jcarousel-pagination').on('jcarouselpagination:active', 'a', function() {
			$(this).addClass('active');
		}).on('jcarouselpagination:inactive', 'a', function() {
			$(this).removeClass('active');
		}).on('click', function(e) {
			e.preventDefault();
		}).jcarouselPagination({
			perPage: moveCnt,
			item: function(page) {
				return '<a href="#' + page + '">' + page + '</a>';
			}
		});
			
	}





