
	// 페이지 첫 시작시 실행
	function goCommunityListDataBasicSkinReadyMoveEvent(strAppID) {
		
	}

	// 페이지 이동
	function goCommunityListDataBasicSkinListMoveEvent(strAppID, intPage) {

		var data		= new Object();

		if(!intPage) { return; }

		data['page']	= intPage;

		C_getAddLocationUrl(data);
	}

	// 검색
	function goCommunityListDataBasicSkinSearchMoveEvent(strAppID) {

		// 기본 설정
		var objTarget = $('#' + strAppID);
		var strSearchKey = objTarget.find('[id=searchKey]').val();
		var strSearchVal = objTarget.find('[id=searchVal]').val();
		if(!strSearchKey) { strSearchKey = ''; }
		if(!strSearchVal) { strSearchVal = ''; }

		var data		= new Object();

		data['searchKey']	= strSearchKey;
		data['searchVal']	= strSearchVal;
		data['page']		= '';

		C_getAddLocationUrl(data);

	}

	// 글쓰기 페이지 이동
	function goCommunityListDataBasicSkinWriteMoveEvent(strAppID) {

		var data		= new Object();

		data['mode']	= "dataWrite";

		C_getAddLocationUrl(data);	
	}

	// 뷰페이지 이동
	function goCommunityListDataBasicSkinViewMoveEvent(strAppID, intUbNo, strLockAuth) {

		// 기본 설정
		var data		= new Object();

		// 체크
		if(strLockAuth == "memberLock") { return; }
		else if(strLockAuth == "lock") {

			data['mode']	= 'dataPassword';
			data['next']	= 'dataView';
			data['ubNo']	= intUbNo;

			C_getAddLocationUrl(data);	
			return;
		}

		data['mode']	= "dataView";
		data['ubNo']	= intUbNo;

		C_getAddLocationUrl(data);	
	}