
	// 페이지 첫 시작시 실행
	function goCommunityListMobileSkinReadyMoveEvent(strAppID) {



	}

	// 뷰페이지 이동
	function goCommunityListMobileSkinViewMoveEvent(strAppID, strBCode, intUBNo) {



	}

	// 페이지 이동
	function goCommunityListMobileSkinListMoveEvent(strAppID, intPage) {



	}

		// 뷰페이지 이동
	function goCommunityListMobileSkinViewMoveEvent(strAppID, intUbNo, strLockAuth) {

		// 기본 설정
		var data		= new Object();
		var strB_CODE	= G_APP_PARAM[strAppID]['B_CODE'];

		// 체크
		if(strLockAuth == "memberLock") { return; }
		else if(strLockAuth == "lock") {

			data['menuType'] = 'community';
			data['mode']	= 'dataPassword';
			data['next']	= 'dataView';
			data['b_code']	= strB_CODE;
			data['ubNo']	= intUbNo;

			C_getAddLocationUrl(data);	
			return;
		}

		data['menuType'] = 'community';
		data['mode']	= "dataView";
		data['b_code']	= strB_CODE;
		data['ubNo']	= intUbNo;

		C_getAddLocationUrl(data);	
	}