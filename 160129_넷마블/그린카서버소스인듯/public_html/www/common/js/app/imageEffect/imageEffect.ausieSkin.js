	/**
	 *
	 * imageEffect - ausieSkin - script 파일
	 *
	 * @package		eumshop shopping mall
	 * @author		ExpressionEngine Dev YoungMi Park, HeeSung Kim
	 * @copyright	Copyright (c) 2012 - 2014, Eumshop, Inc.
	 * @license		http://www.eumshop.co.kr/user_guide/license.html
	 * @link		http://www.eumshop.co.kr
	 * @since		Version 1.0
	 * @filesource	/home/shop_eng/www/common/js/app/imageEffect/imageEffect.ausieSkin.js
	 * @manual		
	 * @history
	 *				2014.05.13 Kim Hee-Sung - 개발 완료
	 */

	/**
	 * 페이지 첫 시작시 실행
	 */
	function goImageEffectAusieSkinReadyMoveEvent(strAppID) {

		// 기본 설정
		var objTarget = $("#" + strAppID);
		var strWidth = "";
		var strHeight = "";
		var isLock = false;

		// 이미지 hover 이벤트
		objTarget.find(".item img").hover(function() {

			if(isLock) { return }
			isLock = true;

			// 기본 설정
			var t = $(this).parent().attr("t");
			var effect = $(this).parent().attr("effect");
			var src = $(this).parent().attr("src");
			var href = $(this).parent().attr("href");
			var strHtml = '<img src="' + src + '" class="' + effect + ' ' + t + 'e">';
			if(href) {
				strHtml = '<a href="' + href + '">' + strHtml + '</a>';
				$(this).parent().wrap('<a href="' + href + '"></a>');
			}

			// 코드에 추가
			objTarget.find('.' + t).append(strHtml);
			
			// 좌표값 설정
			strWidth = objTarget.find('.' + t + 'e').css("left");
			strHeight = objTarget.find('.' + t + 'e').css("top");
			
			// 애니메이션 효과(보이기)
			objTarget.find('.' + t + 'e').stop().animate({top : '0px', left : '0px', opacity : 1}, 100);

			// 변경된 이미지 이벤트
			objTarget.find('.' + t + 'e').hover(function(e) {

				// 실행하려는 이벤트 스톱
				objTarget.find('.' + t + 'e').stop();	

			}, function() {
				
				isLock = false;
				
				// 애니메이션 화과(숨기기)
				objTarget.find('.' + t + 'e').stop().animate({top:strHeight, left:strWidth, opacity : 0}, 100, function() {
					// 삭제
					$(this).remove();
				});
			});

		}, function() {	

			// 기본 설정
			var t = $(this).parent().attr("t");

				isLock = false;

			// 애니메이션 화과(숨기기)
			objTarget.find('.' + t + 'e').stop().animate({top:strHeight, left:strWidth, opacity : 0}, 100, function() {
				// 삭제
				$(this).remove();
			});
		});
	}


