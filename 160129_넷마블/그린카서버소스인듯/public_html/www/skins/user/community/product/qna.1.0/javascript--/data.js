
/* 이벤트 정의 */
function goDataWriteActEvent()				{ goDataWriteAct("dataWrite");						}
function goDataWriteMoveEvent()				{ goDataWriteMove("dataWrite");						}
function goDataListMoveEvent()				{ goDataListMove("dataList");						}
function goDataViewMoveEvent(no)			{ goDataViewMove("dataView", no);					}
function goDataModifyActEvent()				{ goDataModifyAct("dataModify");					}
function goDataModifyMoveEvent()			{ goDataModifyMove("dataModify");					}

function goDataWriteAct(mode) {
	goAct(mode);
}

function goDataModifyAct(mode) {
	goAct(mode);
}

function goDataWriteMove(mode) {
	var b_code		= $("#b_code").val();
	var page		= $("#page").val();
	location.href	= "./?menuType=community&mode="+mode+"&b_code="+b_code+"&page="+page;
}


function goDataListMove(mode) {
	var b_code		= $("#b_code").val();
	var page		= $("#page").val();
	location.href	= "./?menuType=community&mode="+mode+"&&ub_no="+ub_no+"b_code="+b_code+"&page="+page;
}

function goDataViewMove(mode, no) {
	var b_code		= $("#b_code").val();
	var page		= $("#page").val();
	location.href	= "./?menuType=community&mode="+mode+"&b_code="+b_code+"&ub_no="+no+"&page="+page;
}
