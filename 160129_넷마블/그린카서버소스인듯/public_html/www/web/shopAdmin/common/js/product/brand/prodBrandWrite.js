
	// 시작
	$(function() {
		
		// 기본 설정
		var objParam = new Object();
		var objConfig = null;

		// editor config 설정
		objParam['form'] = 'form';
		objParam['wrapper'] = 'tx_trex_container1';
		objParam['dir'] = 'product/brand';
		goEumEditor2Set(objParam);

		// config 정보 불러오기
		var objConfig = goEumEditor2ConfigMake(1);

		// 데이터 실행
		goEumEditor2Ready(objConfig);

	});

	// 등록
	function goProductBrandWriteActEvent() {
		
		// 기본 설정
		var objTarget = $('form[name=form]');
		var strEditorText = goEumEditor2Text(1);
		
		// 내용 설정
		objTarget.find('textarea[name=pr_html]').val(strEditorText);

		// 등록
		goAct('prodBrandWrite');
	}

	