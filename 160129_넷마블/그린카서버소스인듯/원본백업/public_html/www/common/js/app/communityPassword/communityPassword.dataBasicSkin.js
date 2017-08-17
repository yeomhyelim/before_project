

	// 취소
	function goCommunityPasswordDataBasicSkinCancelMoveEvent(strAppID) {

		history.back(-1);
//		var data		= new Object();

//		data['mode']	= "dataView";

//		C_getAddLocationUrl(data);	
	}

	// 비밀번호 확인
	function goCommunityPasswordDataBasicSkinCheckActEvent(strAppID) {

		// 기본설정
		var strBCode = objScriptData['APP'][strAppID]['B_CODE'];
		var intUbNo = objScriptData['APP'][strAppID]['UB_NO'];
		var strNext = objScriptData['APP'][strAppID]['NEXT'];
		var objTarget = $('#' + strAppID);
		var strUbPass = objTarget.find('[name=ub_pass]').val();

		// 체크
		if(!strUbPass) {
			alert('비밀번호를 입력하세요.');
			objTarget.find('[name=ub_pass]').focus();
			return;
		}

		// 전달
		var data = new Object();
		data['menuType'] = 'community';
		data['mode'] = 'json';
		data['act'] = 'dataPasswordCheck';
		data['b_code'] = strBCode;
		data['ub_no'] = intUbNo;
		data['ub_pass'] = strUbPass;

		$.ajax({
			url			: "./"
		   ,data		: data
		   ,type		: "POST"
		   ,dataType	: "json"
		   ,success		: function(data) {	
				
				if(data['__STATE__'] == "SUCCESS") {

					if(strNext == 'dataDelete') { goCommunityPasswordDataBasicSkinDeleteActEvent(strAppID); 	}
					else if(strNext == 'dataModify') { goCommunityPasswordDataBasicSkinModifyMoveEvent(strAppID); 	}
					else if(strNext == 'dataView') { goCommunityPasswordDataBasicSkinViewMoveEvent(strAppID); 	}
					
					
				} else {
					var strMsg	= data['__MSG__'];
					if(!strMsg) { strMsg = data; }
					alert(strMsg);
				}

		    }
		});
	}

	// 내용 삭제
	function goCommunityPasswordDataBasicSkinDeleteActEvent(strAppID) {
	
		// 기본 설정
		var objLanguage = objScriptData['APP'][strAppID]['LANGUAGE'];
		var strBCode = objScriptData['APP'][strAppID]['B_CODE'];
		var intUbNo = objScriptData['APP'][strAppID]['UB_NO'];

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

	// 수정 페이지로 이동
	function goCommunityPasswordDataBasicSkinModifyMoveEvent(strAppID) {

		// 기본 설정
		var intUbNo = objScriptData['APP'][strAppID]['UB_NO'];
		var data = new Object();

		// 수정페이지 이동
		data['mode']	= "dataModify";
		data['ubNo']	= intUbNo;

		C_getAddLocationUrl(data);	
	}

	// 뷰 페이지로 이동
	function goCommunityPasswordDataBasicSkinViewMoveEvent(strAppID) {

		// 기본 설정
		var intUbNo = objScriptData['APP'][strAppID]['UB_NO'];
		var data = new Object();

		// 수정페이지 이동
		data['mode']	= "dataView";
		data['ubNo']	= intUbNo;

		C_getAddLocationUrl(data);	

	}