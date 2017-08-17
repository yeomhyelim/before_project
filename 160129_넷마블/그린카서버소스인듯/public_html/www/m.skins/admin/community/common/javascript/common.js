function goDataSearchListMoveEvent()			{ goDataSearchListMove(); }
function goBoardSearchListMoveEvent()			{ goBoardSearchListMove(); }
function goDataTransferActEvent()				{ goDataTransferAct(); }

function goDataTransferAct() {
	var intCnt = goCheckBox();
	if(intCnt <= 0) {
		alert("선택된 데이터가 없습니다.");
		return false;
	}

	var b_code_transfer = $("select[name=b_code_transfer]").val();
	if(!b_code_transfer){
		alert("이동할 게시판이 없습니다.");
		return false;
	}

	var  x = confirm("선택한 내용을 이동하시겠습니까?");
	if (x == true) { 
		var mode = "dataTransfer";
		goAct(mode);
	}
}

function goDataSearchListMove() {
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

function goBoardSearchListMove() {
	var data			= new Array(5);
	data['menuType']	= $("#menuType").val();
	data['mode']		= $("#mode").val();
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