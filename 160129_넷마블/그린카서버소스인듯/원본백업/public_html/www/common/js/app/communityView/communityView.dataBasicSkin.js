
	// 뷰페이지 이동
	function goCommunityViewDataBasicSkinViewMoveEvent(intUbNo) {

		// 체크
		if(!intUbNo) { return; }

		var data		= new Object();

		data['ubNo']	= intUbNo;

		C_getAddLocationUrl(data);	
	}

	// 목록페이지 이동
	function goCommunityViewDataBasicSkinListMoveEvent(strAppID) { 
	
		var data		= new Object();

		data['mode']	= "dataList";
		data['ubNo']	= "";

		C_getAddLocationUrl(data);	

	}

	// 수정페이지 이동
	function goCommunityViewDataBasicSkinModifyMoveEvent(strAppID) { 
		
		// 기본 설정
		var intUbNo = objScriptData['APP'][strAppID]['UB_NO'];
		var intUbMemberNo = objScriptData['APP'][strAppID]['UB_M_NO'];
		var data = new Object();

		// 비회원글인경우 비밀번호 입력 페이지로 이동
		if(!intUbMemberNo || intUbMemberNo <= 0) {

			var data		= new Object();

			data['mode']	= 'dataPassword';
			data['next']	= 'dataModify';

			C_getAddLocationUrl(data);	
			return;
		}

		// 수정페이지 이동
		data['mode']	= "dataModify";
		data['ubNo']	= intUbNo;

		C_getAddLocationUrl(data);	

	}

	// 답변페이지 이동
	function goCommunityViewDataBasicSkinReplyMoveEvent(strAppID) {

		// 기본 설정
		var intUbNo = objScriptData['APP'][strAppID]['UB_NO'];
		var data = new Object();

		// 수정페이지 이동
		data['mode']	= "dataAnswer";
		data['ubNo']	= intUbNo;

		C_getAddLocationUrl(data);	
	}

	// 트위터 이동
	function goCommunityViewDataBasicSkinTwitterMoveEvent(strAppID) {

		var strUrl = 'https://twitter.com/share';

		window.open(strUrl, '', 'width=800px,height=500px');
	}

	// 페이스북 이동
	function goCommunityViewDataBasicSkinFacebookMoveEvent(strAppID) {

		var objFacebook = objScriptData['APP'][strAppID]['FACEBOOK'];
		var strAPP_ID = objFacebook['APP_ID'];
		var strSECRET = objFacebook['SECRET'];
		var strCAPTION = objFacebook['CAPTION'];
		var strDESCRIPTION = objFacebook['DESCRIPTION'];
		var strLINK = objFacebook['LINK'];
		var strPICTURE = objFacebook['PICTURE'];
		var strNAME = objFacebook['NAME'];

		var objData					= new Object();
		objData['appId']			= strAPP_ID;
		objData['link']				= strLINK;
		objData['picture']			= strPICTURE;
		objData['name']				= strNAME;
		objData['caption']			= strCAPTION;
		objData['description']		= strDESCRIPTION;
		objData['callbackFunc']		= goCommunityViewDataBasicSkinFacebookMoveCallbackEvent();

		facebook.init(objData);
		facebook.ui(objData);
		
	}

	// 페이스북 담벼락 시작할때 이벤트 
	function goCommunityViewDataBasicSkinFacebookMoveCallbackEvent(response) { }

	// 내용 삭제
	function goCommunityViewDataBasicSkinDeleteActEvent(strAppID) {
		
		// 기본 설정
		var objLanguage = objScriptData['APP'][strAppID]['LANGUAGE'];
		var strBCode = objScriptData['APP'][strAppID]['B_CODE'];
		var intUbNo = objScriptData['APP'][strAppID]['UB_NO'];
		var intUbMemberNo = objScriptData['APP'][strAppID]['UB_M_NO'];

		// 비회원글인경우 비밀번호 입력 페이지로 이동
		if(!intUbMemberNo || intUbMemberNo <= 0) {

			var data		= new Object();

			data['mode']	= 'dataPassword';
			data['next']	= 'dataDelete';

			C_getAddLocationUrl(data);	
			return;
		}

		// 한번더 물어보기
		var x = confirm(objLanguage['PS00018']); // 삭제 하시겠습니까?
		if(!x) { return; }

		// 전달
		var data = new Object();
		data['menuType'] = 'community';
		data['mode'] = 'json';
		data['act'] = 'dataDelete';
		data['b_code'] = strBCode;
		data['ub_no'] = intUbNo;

		$.ajax({
			url			: "./"
		   ,data		: data
		   ,type		: "POST"
		   ,dataType	: "json"
		   ,success		: function(data) {	
				
				if(data['__STATE__'] == "SUCCESS") {

					// 이동
					var data = new Object();
			
					data['mode'] = 'dataList';

					C_getAddLocationUrl(data);
					
				} else {
					var strMsg	= data['__MSG__'];
					if(!strMsg) { strMsg = data; }
					alert(strMsg);
				}

		    }
		});
	}

	// 비밀번호 폼 그리기(예정)
	function goCommunityViewDataBasicSkinPasswordFormDrawEvent(strAppID) {

	
	}
