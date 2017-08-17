
	// 시작
	EditorJSLoader.ready(function (Editor) {

		// 기본 설정
		var objParam = new Object();

		// editor config 설정
		objParam['form'] = 'form';
		objParam['wrapper'] = 'tx_trex_container1';
		objParam['dir'] = 'product/brand';
		goEumEditor2Set(objParam);

		// config 정보 불러오기
		var objConfig = goEumEditor2ConfigMake(1);

		// text set
		var objTarget = $('form[name=form]');
		var strEditorText = objTarget.find('textarea[name=pr_html]').val();
		goEumEditor2TextSet(strEditorText);

		// 데이터 실행
		goEumEditor2Ready(objConfig);

	});

	// 수정
	function goProductBrandModifyActEvent() {
		
		// 기본 설정
		var objTarget = $('form[name=form]');
		var strEditorText = goEumEditor2Text(1);
		
		// 내용 설정
		objTarget.find('textarea[name=pr_html]').val(strEditorText);

		// 수정
		goAct('prodBrandModify');
	}

	