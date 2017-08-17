$(document).ready(function(){
	//셀렉트박스
//	$(".select-ui select").selectbox();
	// 패밀리사이트
	$('.familySite .site-list').addClass('off').css('display','none');
	familysite();

});

// familysite
function familysite(){
	$('.familySite .familyBtn').click(function() {
		$(this).addClass('on');
		if ($('.familySite .site-list').hasClass('off')) {
			$('.familySite .site-list').removeClass('off');
			$('.familySite .site-list').slideDown();
		} else {
			$('.familySite .site-list').addClass('off');
			$('.familySite .site-list').slideUp();
			$(this).removeClass('on');
		}
		return false;
	});
	$('body').click(function(){
		$('.familySite .site-list').addClass('off');
		$('.familySite .site-list').slideUp();
		$('.familySite .familyBtn').removeClass('on');
	});
	
	WebFont.load({
	    custom: {
	            families: ['Nanum Gothic'],
	            urls: ['http://fonts.googleapis.com/earlyaccess/nanumgothic.css']
	        }
	     });
}


