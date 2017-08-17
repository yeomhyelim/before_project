function goSearchListMoveEvent()			{ goSearchListMove(); }

function goSearchListMove() {
	var data			= new Array(5);
	data['menuType']	= $("#menuType").val();
	data['mode']		= $("#mode").val();
	data['b_code']		= $("#b_code").val();
	data['searchKey']	= $("#searchKey").val();
	data['searchVal']	= $("#searchVal").val();

	if(!goCheckForm("search")) { return; }

	var href = "./?";
	for (var key in data) {
		if(!data[key]) { continue };
		href = href + key + "=" + data[key] + "&";
	}

	location.href = href;
}