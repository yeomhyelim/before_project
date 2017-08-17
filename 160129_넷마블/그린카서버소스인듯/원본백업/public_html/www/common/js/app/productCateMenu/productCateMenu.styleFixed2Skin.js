
	function goProductCateMenuStyleFixed2SkinListMoveEvent(strCate1, strCate2, strCate3, strCate4) {

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