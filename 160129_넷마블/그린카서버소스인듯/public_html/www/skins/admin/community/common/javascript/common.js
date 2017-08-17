
//function goDataSearchListMoveEvent()			{ goDataSearchListMove();				}
function goBoardSearchListMoveEvent()			{ goBoardSearchListMove();				}
function goDataTransferActEvent()				{ goDataTransferAct();					}
function goDataListCntChangeEvent(obj)			{ goDataListCntChange(obj);				}

function goDataListCntChange(obj) {
	var data			= new Array(5);
	data['page_line']	= $(obj).val();
	goAddLocation(data);
}

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

//function goDataSearchListMove() {
//	var data			= new Array(5);
//	data['menuType']	= $("#menuType").val();
//	data['mode']		= $("#mode").val();
//	data['b_code']		= $("#b_code").val();
//	data['searchKey']	= $("#searchKey").val();
//	data['searchVal']	= $("#searchVal").val();
//
//	if(!goCheckForm("search")) { return; }
//
//	var href = "./?";
//	for (var key in data) {
//		if(!data[key]) { continue };
//		href = href + key + "=" + data[key] + "&";
//	}
//
//	location.href = href;
//}


function goDataSearchListMoveEvent() {


	// 기본 설정
	var data				= new Array();
	var searchKey			= $("select[id=searchKey] option:selected").val();
	var searchVal			= $("input[id=searchVal]").val();
	var searchRegStartDt	= $("input[id=searchRegStartDt]").val();
	var searchRegEndDt		= $("input[id=searchRegEndDt]").val();
	var searchCategoryState	= $("select[id=searchCategoryState] option:selected").val();
	var searchResultState	= $("select[id=searchResultState] option:selected").val();
	
	

	// 기본 설정 체크
	if(!searchKey)				{ searchKey				= "";	}
	if(!searchVal)				{ searchVal				= "";	}
	if(!searchRegStartDt)		{ searchRegStartDt		= "";	}
	if(!searchRegEndDt)			{ searchRegEndDt		= "";	}
	if(!searchCategoryState)	{ searchCategoryState	= "";	}
	if(!searchResultState)		{ searchResultState		= "";	}

	// 데이터 전달
	data['searchKey']				= searchKey;
	data['searchVal']				= searchVal;
	data['searchRegStartDt']		= searchRegStartDt;
	data['searchRegEndDt']			= searchRegEndDt;
	data['searchCategoryState']		= searchCategoryState;
	data['searchResultState']		= searchResultState;

	// 이동
	goAddLocation(data);

}
function goDataSearchResetListMoveEvent() {

	// 기본 설정
	var data				= new Array();

	// 데이터 전달
	data['searchKey']				= "";
	data['searchVal']				= "";
	data['searchRegStartDt']		= "";
	data['searchRegEndDt']			= "";
	data['searchCategoryState']		= "";
	data['searchResultState']		= "";



	// 이동
	goAddLocation(data);

}

function goDataUserReportListExcelDownloadEvent() {

	// 기본 설정
	var data				= new Array();
	var searchField			= $("select[id=searchKey] option:checked").val();
	var searchKey			= $("input[id=searchVal]").val();
	var searchRegStartDt	= $("input[id=searchRegStartDt]").val();
	var searchRegEndDt		= $("input[id=searchRegEndDt]").val();
	var searchResultState	= $("select[id=searchResultState] option:checked").val();

	// 기본 설정 체크
	if(!searchField)		{ searchField			= "";	}
	if(!searchKey)			{ searchKey				= "";	}
	if(!searchRegStartDt)	{ searchRegStartDt		= "";	}
	if(!searchRegEndDt)		{ searchRegEndDt		= "";	}
	if(!searchResultState)	{ searchResultState		= "";	}

	// 데이터 전달
	data['menuType']				= "member";
	data['mode']					= "excel";
	data['act']						= "excelMemberProdReportList";
	data['searchField2']			= searchField;
	data['searchKey2']				= searchKey;
	data['searchRegStartDt']		= searchRegStartDt;
	data['searchRegEndDt']			= searchRegEndDt;
	data['searchResultState']		= searchResultState;

	// 이동
	goAddLocation(data);

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