
	// 페이지 첫 시작시 실행
	function goCommunityViewMobileSkinReadyMoveEvent(strAppID) {

		// 언어 설정
		var objLanguage	= G_APP_PARAM[strAppID]['LANGUAGE'];

		// 제목 설정
		var strBName = G_APP_PARAM[strAppID]['B_NAME'];
		$('[appID=' + strAppID + '].app-title').html(strBName);
		
		// 이미지 슬라이더 설정
		$('.app-slider').bxSlider();
	}

	// 리스트 페이지 이동
	function goCommunityViewMobileSkinListMoveEvent() {

		var data = new Object(); 
		data['menuType'] = "community";
		data['mode'] = "dataList";
		C_getAddLocationUrl(data);		
	}