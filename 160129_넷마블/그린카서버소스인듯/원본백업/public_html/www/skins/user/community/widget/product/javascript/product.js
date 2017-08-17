
/* 이벤트 정의 */
function goDataViewMoveEvent(b_code, ub_no)				{ goDataViewMove(b_code, ub_no);			}
function goDataWriteMoveEvent(b_code, ub_no)			{ goDataWriteMove(b_code, ub_no);			}
function goDataModifyMoveEvent(b_code, ub_no)			{ goDataModifyMove(b_code, ub_no);			}
function goDataDeleteMoveEvent(b_code, ub_no)			{ goDataDeleteMove(b_code, ub_no);			}
function goDataListPageMoveEvent(b_code, page)			{ goDataListPageMove(b_code, page);			}

function goDataDeleteActEvent(b_code, ub_no)			{ goDataDeleteAct(b_code, ub_no);			}

/* move */
function goDataViewMove(b_code, ub_no) {
	$("tr[id^=dataView_"+b_code+"_]").css({'display':'none'});
	$("tr[id=dataView_"+b_code+"_"+ub_no+"]").css({'display':''});
}

function goDataWriteMove(b_code, ub_no) {
	var	mode			= "dataWrite";
	var inputName		= new Array(1);
	var data			= new Array(5);
	data['menuType']	= "community";
	data['mode']		= mode;
	data['b_code']		= b_code;
	data['myTarget']	= "pop";
	href				= goMakUrl(inputName, data);
	window.open(href,'','width=600px,height=600px');
}

function goDataModifyMove(b_code, ub_no) {
	var	mode			= "dataModify";
	var inputName		= new Array(1);
	var data			= new Array(5);
	data['menuType']	= "community";
	data['mode']		= mode;
	data['b_code']		= b_code;
	data['ub_no']		= ub_no;
	data['myTarget']	= "pop";
	href				= goMakUrl(inputName, data);
	window.open(href,'','width=600px,height=600px');
}

function goDataDeleteMove(b_code, ub_no) {
	alert("delete");
}

function goDataListPageMove(b_code, page) {

//	var code = $("table[id=data_"+b_code+"]");
//	$(code).find("tr").remove();
}


/* act */
function goDataDeleteAct(b_code, ub_no) {
	alert("delete");
}
