



	function goProductCateMenuStyleFixed3SkinShowEvent(strAppID, myThis, target) {

		// 기본 설정
		var objTarget = $('#' + strAppID);

		// 기존에 open 된것 닫기
		objTarget.find("." + target).slideUp(0);

		//css 추가
		$(myThis).parent().find("." + target).removeClass(' on');
		$(myThis).parent().find("." + target).addClass(' hide');

		// 닫겨져 있으면 열기.
		if($(myThis).parent().find("." + target).is(":hidden")) {
			$(myThis).parent().find("." + target).slideDown(0).show();

			//css 추가
			$(myThis).parent().find("." + target).removeClass(' hide');
			$(myThis).parent().find("." + target).addClass(' on');
		}
	}

	function goProductCateMenuStyleFixed3SkinListMoveEvent(strCate1, strCate2, strCate3, strCate4) {

		var data = new Object();

		data['menuType'] = "product";
		data['mode'] = "list";
		data['lcate'] = strCate1;
		data['mcate'] = strCate2;
		data['scate'] = strCate3;
		data['fcate'] = strCate4;
		data['page'] = 1;

		C_getAddLocationUrl(data);
	}