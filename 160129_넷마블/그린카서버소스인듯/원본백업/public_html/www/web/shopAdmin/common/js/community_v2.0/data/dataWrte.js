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
		var objTarget = $('form[name=writeForm]');

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

	// 리스트 페이지로 이동
	function goCommunityWriteListMoveEvent() {

		var data = new Object();

		data['mode'] = "dataList";

		C_getAddLocationUrl(data);	
	}

	// 등록
	function goCommunityWriteActEvent() {

		// 기본설정
		var objTarget = $('form[name=writeForm]');

		// 유효성 체크
		if(!goCommunityWriteFormCheck()) { return; }

		// 전달
		objTarget.find('[name=mode]').val('json');
		objTarget.find('[name=act]').val('dataWrite');
		var data = objTarget.serializeArray();

		$.ajax({
			url			: "./"
		   ,data		: data
		   ,type		: "POST"
		   ,dataType	: "json"
		   ,success		: function(data) {	
				
				if(data['__STATE__'] == "SUCCESS") {

					var strMsg = "등록되었습니다.";
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

	// 유효성 체크
	function goCommunityWriteFormCheck() {

		// 기본설정
		var objTarget = $('form[name=writeForm]');
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
			if(!strAlt) { strAlt = '필수항목'; } 
			if(in_array('empty', aryCheck) && !strVal) { 
				var strMsg = strAlt + '을 입력하세요.';
				if(strType == 'radio') { strMsg = strAlt + '은 필수 항목입니다.'; }
				alert(strMsg);
				$(this).focus();
				isStop = true;
				return;
			}
		});

		if(isStop) { return; }

		return true;

	}

	// 첨부파일
	function goCommunityDataWriteAtcFormToggleEvent() {

		// 기본설정
		var objTarget = $('form[name=writeForm]');

		// 선택된 파일 삭제
		objTarget.find('[name^=file_]').val('');

		// 토글
		objTarget.find('.atcForm').toggle();
		
	}

	// 업로드
	function goCommunityDataWriteAtcWriteActEvent() {

		// 기본설정
		var objTarget = $('form[name=writeForm]');

		// .체크
		var intCnt = 0;
		objTarget.find('[name^=file_]').each(function() {
			var strName = $(this).val();
			if(strName) { intCnt++; }
		});
		if(!intCnt) {
			alert('첨부파일을 선택하세요.');
			return;
		}

		// 데이타 설정
		objTarget.find('[name=mode]').val('json');
		objTarget.find('[name=act]').val('atcWrite');

		// 데이터 전달
		objTarget.ajaxForm({
			beforeSubmit :	function() {
			},
			success		 :  function(data) {
				data =  $.parseJSON(data);
				if(data['__STATE__'] == "SUCCESS") {

					goCommunityDataWriteAtcFileDrawEvent(data);
					goCommunityDataWriteAtcFormToggleEvent();

				} else {
					var strMsg = data['__MSG__'];
					if(!strMsg) { strMsg = data; }
					alert(strMsg);
				}
		   }
		}); 

		objTarget.submit();
	}

	// 첨부파일 업로드 이후 그리기
	function goCommunityDataWriteAtcFileDrawEvent(data) {

		// 기본설정
		var objTarget = $('form[name=writeForm]').find('.atcFileList');
		var aryFileList = data['__DATA__']['FILE'];

		// 기존에 있던 데이터 삭제
		objTarget.html('');

		// 그리기
		var strHtml = '';
		var intLength = aryFileList.length;
		var intCnt = 0;
		for(var i in aryFileList) {

			// 체크
			intCnt++;
			if(intCnt > intLength) { break; }
			
			// 기본 설정
			var strATC_KEY = aryFileList[i]['ATC_KEY']; 
			var strATC_DIR = aryFileList[i]['ATC_DIR']; 
			var strATC_FILE = aryFileList[i]['ATC_FILE']; 
			var aryRealName = strATC_FILE.split('_@_');
			var strHtmlTemp = aryRealName[1] + '\n';

			if(in_array(strATC_KEY, ['listImage','image','bigImage'])) {
				
				strHtmlTemp = '<img src="' + strATC_DIR + '/' + strATC_FILE + '" style="width:50px;height:50px">\n';

			} 

			strHtml = strHtml + 
					  '<li class="left">\n' + 
						strHtmlTemp + 
						'<a href="javascript:void(0);" onclick="goCommunityDataWriteAtcDeleteActEvent(' + i + ')">[X]</a>\n' + 
					  '</li>\n';

			
		}

		if(strHtml) { 
			strHtml = '<ul>\n' + 
					  		strHtml +
						 '<div class="clr"></div>' + 
					  '</ul>'; 
		}

		// 화면 출력
		objTarget.html(strHtml);
		
	}

	// 첨부파일 삭제
	function goCommunityDataWriteAtcDeleteActEvent(intNo) {

		// 기본설정
		var objTarget = $('form[name=writeForm]');
		var strB_CODE = objTarget.find('[name=b_code]').val();
		var strLANG = objTarget.find('[name=ub_lng]:checked').val();

		// 데이터 전달
		var data			= new Object();
		data['menuType']	= "community_v2.0";
		data['mode']		= "json";
		data['act']			= "atcDelete";
		data['b_code']		= strB_CODE;
		data['ub_lng']		= strLANG;
		data['no']			= intNo;

		$.ajax({
			url			: "./"
		   ,data		: data
		   ,type		: "POST"
		   ,dataType	: "json"
		   ,success		: function(data) {	
								if(data['__STATE__'] == "SUCCESS") {
								
									goCommunityDataWriteAtcFileDrawEvent(data);

								} else {
									var strMsg = data['__MSG__'];
									if(!strMsg) { strMsg = data; }
									alert(strMsg);
								}
						   }
		});

	}