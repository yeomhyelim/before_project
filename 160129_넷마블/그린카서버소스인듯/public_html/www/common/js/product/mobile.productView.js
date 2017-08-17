
	$(function() {

		var intProductSliderCnt = $('.product-slider li').length;

		// 이미지 슬라이더 설정
		if(intProductSliderCnt > 1)
			$('.product-slider').bxSlider({
				auto: false,
                autoStart: false
		});

		//구매하기옵션버튼
		$('.bottomOpenClose').click(function() {
			var isOpen = $(this).hasClass('open');
			if(isOpen) {
				$(this).removeClass('open');
				$('.bottomViewMenuWrap').css('height','65px').find('.mainProdView').hide();
			} else {
				$(this).addClass('open');
				$('.bottomViewMenuWrap').css('height','300px').find('.mainProdView').show();
			}
		});
	});