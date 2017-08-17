
	// 에디터 글쓰기 설정
	var rootDir 	= "/common/eumEditor/highgardenEditor";
	var uploadImg 	= "/editor/board";
	var uploadFile 	= "/kr/";
	var htmlYN		= "Y";

	// 시작
	EditorJSLoader.ready(function (Editor) {

		// 기본 설정
		var objParam1 = new Object();
//		var objParam2 = new Object();
		var objTarget = $('form[name=answerForm]');

		// editor config 설정
		objParam1['form'] = 'tx_editor_form';
		objParam1['wrapper'] = 'tx_trex_container1';
		objParam1['dir'] = objTarget.find('[name=editorDir]').val();

//		objParam2['form'] = 'form';
//		objParam2['wrapper'] = 'tx_trex_container2';
//		objParam2['dir'] = 'productEtc/delRetHelp';
//		goEumEditor2Set(objParam1, objParam2);
		goEumEditor2Set(objParam1);

		// config 정보 불러오기
		var objConfig1 = goEumEditor2ConfigMake(1);
//		var objConfig2 = goEumEditor2ConfigMake(2);

		// text set
		var strEditorText1 = objTarget.find('textarea[name=ub_text]').val();
//		var strEditorText2 = objTarget.find('textarea[name=sc_text]').val();
//		goEumEditor2TextSet(strEditorText1, strEditorText2);
		goEumEditor2TextSet(strEditorText1);

		// 데이터 실행
//		goEumEditor2Ready(objConfig1, objConfig2);
		goEumEditor2Ready(objConfig1);

	});

	// 답변쓰기 취소
	function goCommunityAnswerDataBasicSkinCancelMoveEvent(strAppID) {
		
		var data = new Object();

		data['mode'] = "dataView";

		C_getAddLocationUrl(data);

	}

	// 답변쓰기 액션
	function goCommunityAnswerDataBasicSkinAnswerActEvent(strAppID) {

		// 기본설정
		var objLanguage = G_APP_PARAM[strAppID]['LANGUAGE'];
		var objTarget = $('#' + strAppID).find('[name=answerForm]');

		// 유효성 체크
		if(!goCommunityAnswerDataBasicSkinWriteFormCheck(strAppID)) { return; }

		// 전달
		objTarget.find('[name=mode]').val('json');
		objTarget.find('[name=act]').val('dataAnswer');
		var data = objTarget.serializeArray();

		$.ajax({
			url			: "./"
		   ,data		: data
		   ,type		: "POST"
		   ,dataType	: "json"
		   ,success		: function(data) {	
				
				if(data['__STATE__'] == "SUCCESS") {

					var strMsg = objLanguage['BS00001']; // 등록되었습니다.
					alert(strMsg);

					// 이동
					var data = new Object();
			
					data['mode'] = "dataList";

					C_getAddLocationUrl(data);
					
				} else {
					var strMsg	= data['__MSG__'];
					if(!strMsg) { strMsg = data; }
					alert(strMsg);
				}

		    }
		});
	}

	// 답변쓰기 유효성 체크
	function goCommunityAnswerDataBasicSkinWriteFormCheck(strAppID) {

		// 기본설정
		var objLanguage = objScriptData['APP'][strAppID]['LANGUAGE'];
		var objTarget = $('#' + strAppID).find('[name=answerForm]');
		var isStop = false;

		// 에디터 체크
		var strEditorText1 = goEumEditor2Text(1);
		objTarget.find('textarea[name=ub_text]').val(strEditorText1);

		// 체크
		objTarget.find('[check]').each(function() {
			
			// 기본 설정
			var strType = $(this).attr('type');
			var strName = $(this).attr('name');
			var strVal = $(this).val();
			var strCheck = $(this).attr('check');
			var strAlt = $(this).attr('alt');
			var aryCheck = strCheck.split('|');
			if(!strType) { strType = $(this)[0].localName; }
			
			// 라디오 박스 값 설정하기
			if(strType == 'radio') {
				var strVal = objTarget.find('input:radio[name=' + strName + ']:checked').val();
				if(!strVal) { strVal = ''; }
			}
			
			// 체크
			if(isStop) { return; }
			if(!strCheck) { return; }
			if(!strAlt) { strAlt = objLanguage['MW00103']; } // 필수항목
			if(in_array('empty', aryCheck) && !strVal) { 
				var strMsg = callLangTrans(objLanguage['MS00104'], [strAlt]); // {{단어1}}을 입력하세요.
				if(strType == 'radio') { callLangTrans(objLanguage['MS00107'], [strAlt]); } // {{단어1}}은 필수 항목입니다.
				alert(strMsg);
				$(this).focus();
				isStop = true;
				return;
			}
		});

		if(isStop) { return; }

		return true;

	}