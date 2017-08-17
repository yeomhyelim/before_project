
/* 이벤트 정의 */
function goDataWriteActEvent()				{ goDataWriteAct("dataWrite");						}
function goDataWriteMoveEvent()				{ goDataWriteMove("dataWrite");						}
function goDataListMoveEvent()				{ goDataListMove("dataList");						}
function goDataViewMoveEvent(no)			{ goDataViewMove("dataView", no);					}
function goDataDeleteActEvent(no)			{ goDataDeleteAct("dataDelete", no);				}
function goDataModifyMoveEvent(no)			{ goDataModifyMove("dataModify", no);				}


function goDataWriteAct(mode) {
	var myTarget = $("#myTarget").val();
	goAct(mode);
}

function goDataDeleteAct(mode, no) {
	var  x = confirm("삭제하시겠습니까?");
	if (x == true) { 
		$("input[name=menuType]").val("community");
		$("#ub_no").val(no);
		goAct(mode);
	}
}


function goDataWriteMove(mode) {
	var b_code		= $("#b_code").val();
	var page		= $("#page").val();
	var ub_p_code	= $("#ub_p_code").val();
	var href		= "./?menuType=community&myTarget=pop&mode="+mode+"&b_code="+b_code+"&ub_p_code="+ub_p_code+"&page="+page;
	var option		= "width=600px, height=550px";

	window.open(href,'',option);
}

function goDataListMove(mode) {
	var b_code		= $("#b_code").val();
	var page		= $("#page").val();
	location.href	= "./?menuType=community&mode="+mode+"&b_code="+b_code+"&page="+page;
}

function goDataModifyMove(mode, no) {
	var b_code		= $("#b_code").val();
	var page		= $("#page").val();
	var ub_p_code	= $("#ub_p_code").val();
	var href		= "./?menuType=community&myTarget=pop&mode="+mode+"&b_code="+b_code+"&ub_no="+no+"&ub_p_code="+ub_p_code+"&page="+page;
	var option		= "width=600px, height=550px";

	window.open(href,'',option);
}

function goDataViewMove(mode, no) {
	$("tr[id^=dataView_]").css({'display':'none'});
	$("tr[id=dataView_"+no+"]").css({'display':''});
}
