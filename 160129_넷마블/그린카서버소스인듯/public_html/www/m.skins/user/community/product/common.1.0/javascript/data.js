
/* 이벤트 정의 */
function goDataCancelMoveEvent()			{ goDataCancelMove("dataList");						}
function goDataWriteActEvent()				{ goDataWriteAct("dataWrite");						}
function goDataWriteMoveEvent()				{ goDataWriteMove("dataWrite");						}
function goDataListMoveEvent()				{ goDataListMove("dataList");						}
function goDataViewMoveEvent(no)			{ goDataViewMove("dataView", no);					}
function goDataModifyActEvent()				{ goDataModifyAct("dataModify");					}
function goDataModifyMoveEvent()			{ goDataModifyMove("dataModify");					}
function goDataDeleteActEvent()				{ goDataDeleteAct("dataDelete");					}

function goDataWriteAct(mode) {
	goAct(mode);
}

function goDataModifyAct(mode) {
	goAct(mode);
}

function goDataCancelMove() {
	var b_code		= $("#b_code").val();
	var page		= $("#page").val();
	var ub_no		= $("#ub_no").val();

	location.href	= "./?menuType=community&mode="+mode+"&b_code="+b_code+"&page="+page;
}

function goDataWriteMove(mode) {
	var b_code		= $("#b_code").val();
	var page		= $("#page").val();
	location.href	= "./?menuType=community&mode="+mode+"&b_code="+b_code+"&page="+page;
}


function goDataListMove(mode) {
	var b_code		= $("#b_code").val();
	var page		= $("#page").val();
	var ub_no		= $("#ub_no").val();

	location.href	= "./?menuType=community&mode="+mode+"&b_code="+b_code+"&page="+page;
}

function goDataViewMove(mode, no) {
	var b_code		= $("#b_code").val();
	var page		= $("#page").val();
	location.href	= "./?menuType=community&mode="+mode+"&b_code="+b_code+"&ub_no="+no+"&page="+page;
}


function goDataModifyMove(mode) {
	var b_code		= $("#b_code").val();
	var page		= $("#page").val();
	var ub_no		= $("#ub_no").val();

	location.href	= "./?menuType=community&mode="+mode+"&b_code="+b_code+"&ub_no="+ub_no+"&page="+page;
}

function goDataDeleteAct(mode) {
	var  x = confirm("삭제하시겠습니까?");
	if (x == true) { 
		goAct(mode);		
	}
}