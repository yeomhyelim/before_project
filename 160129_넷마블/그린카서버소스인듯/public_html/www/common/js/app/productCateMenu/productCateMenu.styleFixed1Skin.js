



	function goProductCateMenuStyleFixed1SkinShowEvent(strAppID, myThis) {

		// 기본 설정
		var objTarget = $('#' + strAppID);
		
		// 기존에 open 된것 닫기
		objTarget.find(".cate2-wrap").slideUp("slow");

		// 닫겨져 있으면 열기.
		if($(myThis).parent().find(".cate2-wrap").is(":hidden")) { 
			$(myThis).parent().find(".cate2-wrap").slideDown("slow").show();
		}	
	}

	function goProductCateMenuStyleFixed1SkinListMoveEvent(strCate1, strCate2, strCate3, strCate4) {

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