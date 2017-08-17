

	// 페이지 첫 시작시 실행
	function goCommunityMenuMobileSkinReadyMoveEvent(strAppID) {

		goCommunityMenuMobileSkinSliderMenuEvent(strAppID);
		
	}	

	// 메듀를 슬라이더 형태로 설정합니다.
	function goCommunityMenuMobileSkinSliderMenuEvent(strAppID) {

		// 기본설정
		var objTarget = $('#' + strAppID);
		
		// 2차 메뉴 숨김
		objTarget.find('.cate2-wrap').hide();

		// 1차 메뉴 클릭시 2차 메뉴 보임
		objTarget.find('.cate1-item').click(function() {

			$(this).find('.cate2-wrap').slideToggle();	
		});

	}