
	function goCommunityListDefaultSkinViewMoveEvent(strBCode, intUBNo) {

		var data = new Object();
		data['mode'] = "dataView";
		data['b_code'] = strBCode;
		data['ub_no'] = intUBNo;
		C_getAddLocationUrl(data);
	}