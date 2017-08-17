	
	// 기본 설정
	var eumEditor2Conf1 = null;
	var eumEditor2Conf2 = null;
	var eumEditor2Text1 = null;
	var eumEditor2Text2 = null;

	// config set
//	objParam['form'];
//	objParam['wrapper'];
//	objParam['dir'];
	function goEumEditor2Set(objConf1, objConf2) {

		if(objConf1) {
			if(!objConf1['form']) { objConf1['form'] = 'form'; }
			if(!objConf1['wrapper']) { objConf1['wrapper'] = 'tx_trex_container'; }
			eumEditor2Conf1 = objConf1;
		} 

		if(objConf2) {
			if(!objConf2['form']) { objConf2['form'] = 'form'; }
			if(!objConf2['wrapper']) { objConf2['wrapper'] = 'tx_trex_container'; }
			eumEditor2Conf2 = objConf2;
		} 
	}

	// get config
	function goEumEditorGet(idx) {
		
		     if(idx == 1) { return eumEditor2Conf1; }
		else if(idx == 2) { return eumEditor2Conf2; }

	}
	
	// set text
	function goEumEditor2TextSet(strText1, strText2) {

		eumEditor2Text1 = strText1;
		eumEditor2Text2 = strText2;

	}

	// get text
	function goEumEditor2TextGet(idx) {

		     if(idx == 1) { return eumEditor2Text1; }
		else if(idx == 2) { return eumEditor2Text2; }
	}

	// config make
	function goEumEditor2ConfigMake(idx) {

		// 기본설정
		var initializedId = idx;
		var eumEditor2Conf = goEumEditorGet(idx);
		var form = eumEditor2Conf['form'];
		var wrapper = eumEditor2Conf['wrapper'];

		// null conf return
		if(!eumEditor2Conf) { return; }
		if(!form) { return; }
		if(!wrapper) { return; }

		var config = {
			txHost: '', /* 런타임 시 리소스들을 로딩할 때 필요한 부분으로, 경로가 변경되면 이 부분 수정이 필요. ex) http://xxx.xxx.com */
			txPath: '', /* 런타임 시 리소스들을 로딩할 때 필요한 부분으로, 경로가 변경되면 이 부분 수정이 필요. ex) /xxx/xxx/ */
			txService: 'sample', /* 수정필요없음. */
			txProject: 'sample', /* 수정필요없음. 프로젝트가 여러개일 경우만 수정한다. */
			initializedId: initializedId, /* 대부분의 경우에 빈문자열 */
			wrapper: wrapper, /* 에디터를 둘러싸고 있는 레이어 이름(에디터 컨테이너) */
			form: form + "", /* 등록하기 위한 Form 이름 */
			txIconPath: "/common/eumEditor2/images/icon/editor/", /*에디터에 사용되는 이미지 디렉터리, 필요에 따라 수정한다. */
			txDecoPath: "/common/eumEditor2/images/deco/contents/", /*본문에 사용되는 이미지 디렉터리, 서비스에서 사용할 때는 완성된 컨텐츠로 배포되기 위해 절대경로로 수정한다. */
			canvas: {
				styles: {
					color: "#123456", /* 기본 글자색 */
					fontFamily: "굴림", /* 기본 글자체 */
					fontSize: "10pt", /* 기본 글자크기 */
					backgroundColor: "#fff", /*기본 배경색 */
					lineHeight: "1.5", /*기본 줄간격 */
					padding: "8px" /* 위지윅 영역의 여백 */
				},
				showGuideArea: false
			},
			events: {
				preventUnload: false
			},
			sidebar: {
				capacity: {
					available: 1024 * 1024 * 20,
					maximum: 1024 * 1024 * 20
				},
				attacher: {
					image: {
						popPageUrl: './?menuType=etc&mode=eumEditor2Image'
					}
				},
				attachbox: {
					show: true
				}
			},
			size: {
				//contentWidth: 100 /* 지정된 본문영역의 넓이가 있을 경우에 설정 */
			}
		};

		return config;
		
	}



	// 실행
	function goEumEditor2Ready(objConfig1, objConfig2) {

		// 첫번째 에디터 설정
		if(objConfig1) {

			// 첫번째 에디터 실행
			new Editor(objConfig1);

			// 첫번째 에디터 로드 완료 이벤트
			Editor.getCanvas().observeJob(Trex.Ev.__IFRAME_LOAD_COMPLETE, function() {

				// 사진 첨부시 해당 에디터에 이미지 삽입
				Editor.getToolbar().observeJob(Trex.Ev.__TOOL_CLICK, function (type) {
					Editor.switchEditor(1);
				});

				// 수정 데이터 그리기
				goEumEditor2DataDraw(1);

				if(objConfig2) {

					// 두번째 에디터 실행
					new Editor(objConfig2);

					// 두번째 에디터 로드 완료 이벤트
					Editor.getCanvas().observeJob(Trex.Ev.__IFRAME_LOAD_COMPLETE, function(ev) {

						// 사진 첨부시 해당 에디터에 이미지 삽입
						Editor.getToolbar().observeJob(Trex.Ev.__TOOL_CLICK, function (type) {
							Editor.switchEditor(2);
						});

						// 수정 데이터 그리기
						goEumEditor2DataDraw(2);

					});
				}

			});

		}

	}

	// 데이터 로드 하기
	function goEumEditor2DataDraw(idx) {

		Editor.switchEditor(idx);

		Editor.modify({
			"content": goEumEditor2TextGet(idx)
		});	
	}

	// 텍스트 전달
	function goEumEditor2Text(idx) {

		// 모듈 설정
		var validator = new Trex.Validator();

		// 에디터 선택
		Editor.switchEditor(idx);

		// 에디터 기본 설정
		var strContent = Editor.getContent();

		// 내용 체크
		if(!validator.exists(strContent)) { strContent = ''; }

		return strContent;
	}