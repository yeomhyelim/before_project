
	// 시작
	EditorJSLoader.ready(function (Editor) {

		// 기본 설정
		var objParam1 = new Object();
		var objParam2 = new Object();

		// editor config 설정
		objParam1['form'] = 'form';
		objParam1['wrapper'] = 'tx_trex_container1';
		objParam1['dir'] = 'productEtc/delRetHelp';

		objParam2['form'] = 'form';
		objParam2['wrapper'] = 'tx_trex_container2';
		objParam2['dir'] = 'productEtc/delRetHelp';
		goEumEditor2Set(objParam1, objParam2);

		// config 정보 불러오기
		var objConfig1 = goEumEditor2ConfigMake(1);
		var objConfig2 = goEumEditor2ConfigMake(2);

		// text set
		var objTarget = $('form[name=form]');
		var strEditorText1 = objTarget.find('textarea[name=s_prod_delivery]').val();
		var strEditorText2 = objTarget.find('textarea[name=s_prod_return]').val();
		goEumEditor2TextSet(strEditorText1, strEditorText2);

		// 데이터 실행
		goEumEditor2Ready(objConfig1, objConfig2);

	});

	// 수정
	function goProductEtcDelRetHelpModifyActEvent() {

		// 기본 설정
		var objTarget = $('form[name=form]');
		var strEditorText1 = goEumEditor2Text(1);
		var strEditorText2 = goEumEditor2Text(2);
		
		// 내용 설정
		objTarget.find('textarea[name=s_prod_delivery]').val(strEditorText1);
		objTarget.find('textarea[name=s_prod_return]').val(strEditorText2);

		// 수정
		goMoveUrl('delRetHelpModify');
	}
	