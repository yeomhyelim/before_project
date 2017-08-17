
(function($) {

	$(function() {
		$("[productSlider]").each(function() {
			$(this).productSlider();
		});
	});

	$.fn.productSlider = function() {
		var itemCnt			= $(this).attr("itemCnt");
		var play			= $(this).attr("play");
		var jcarousel		= $(this).find(".jcarousel");

		jcarousel
			.on('jcarousel:reload jcarousel:create', function () {

				var width = jcarousel.innerWidth();
				    width = width / itemCnt;

// 2014.04.07 kim hee sung 버그
//				if (width >= 600) {
//					width = width / itemCnt;
//				} else if (width >= 350) {
//					width = width / 2;
//				}

				jcarousel.jcarousel('items').css('width', width + 'px');
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
					return '<a href="#' + page + '"><span>' + page + '</span></a>';
				}
			});

		if(play == "auto") {
			// 자동 실행
			jcarousel.jcarousel({
				// Core configuration goes here
			})
			.jcarouselAutoscroll({
				interval: 3000,
				target: '+=1',
				autostart: true
			});
		}
		return this;
	}
})(jQuery);
