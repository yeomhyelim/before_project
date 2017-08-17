
	// 시작
	EditorJSLoader.ready(function (Editor) {

		// 기본 설정
		var objParam1 = new Object();
//		var objParam2 = new Object();

		// editor config 설정
		objParam1['form'] = 'form';
		objParam1['wrapper'] = 'tx_trex_container1';
		objParam1['dir'] = 'product/prodPlan';

//		objParam2['form'] = 'form';
//		objParam2['wrapper'] = 'tx_trex_container2';
//		objParam2['dir'] = 'productEtc/delRetHelp';
//		goEumEditor2Set(objParam1, objParam2);
		goEumEditor2Set(objParam1);

		// config 정보 불러오기
		var objConfig1 = goEumEditor2ConfigMake(1);
//		var objConfig2 = goEumEditor2ConfigMake(2);

		// text set
		var objTarget = $('form[name=form]');
		var strEditorText1 = objTarget.find('textarea[name=pp_html]').val();
//		var strEditorText2 = objTarget.find('textarea[name=pp_html]').val();
//		goEumEditor2TextSet(strEditorText1, strEditorText2);
		goEumEditor2TextSet(strEditorText1);

		// 데이터 실행
//		goEumEditor2Ready(objConfig1, objConfig2);
		goEumEditor2Ready(objConfig1);

	});


	// 저장
	function goProductProdPlanWriteActEvent() {

		// 기본설정
		var objTarget = $('form[name=form]');
	
		// 유효성 체크
		if(!goProductProdPlanWriteFormCheck()) { return; }

		// 전달
		C_getAction('prodPlanWrite','');
	}

	// 유효성 체크
	function goProductProdPlanWriteFormCheck() {


		// 기본 설정
		var objTarget = $('form[name=form]');
		var strEditorText1 = goEumEditor2Text(1);
//		var strEditorText2 = goEumEditor2Text(2);
		
		// 내용 설정
		objTarget.find('textarea[name=pp_html]').val(strEditorText1);
//		objTarget.find('textarea[name=pp_html]').val(strEditorText2);

		// 기본설정
		var strTitle = objTarget.find('[name=pp_title]').val();
		var strHtml = objTarget.find('[name=pp_html]').val();

		if(!strTitle) {
			alert('기획전명을 입력하세요.');
			objTarget.find('[name=pp_title]').focus();
			return;
		}
		if(!strHtml) {
			alert('내용을 입력하세요.');
			return;
		}

		return true;
	}