/*
 * jQuery eumshop ajax plugin v1.0.0
 * http://www.eumshop.co.kr
 * developer : kim hee sung
 * history : 2013.08.18 - Ajax 개발
 * Copyright (c) 2013 eumshop
 *
 */

 (function($){

	$.fn.eumPost = function(option) {
		var myOption	= $.extend( {}, $.fn.eumPost.defaults, option );
		
		$.post(	myOption.url, 
				myOption.data, 
				function(data, status){
					if(status == "success"){
						myOption.success(data);
					}else{
						alert(status);
					}
				});
	};

	// 축소
	$.eumPost = $.fn.eumPost;
	
	// 디폴트 옵션
	$.fn.eumPost.defaults = {

	};	

 }(jQuery));

