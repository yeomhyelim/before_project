
/* 이벤트 정의 */
function goDataWriteActEvent(code)			{ goDataWriteAct("dataWrite", code);					}
function goDataWriteMoveEvent(code)			{ goDataWriteMove("dataWrite", code);					}
function goDataListMoveEvent(code)			{ goDataListMove("dataList", code);						}
function goDataViewMoveEvent(code, no)		{ goDataViewMove("dataView", code, no);					}
function goDataDeleteActEvent(code, no)		{ goDataDeleteAct("dataDelete", code, no);				}
function goDataModifyMoveEvent(code, no)	{ goDataModifyMove("dataModify", code, no);				}

function goDataWriteAct(mode, code) {
	$("#b_code").val(code);
	var myTarget = $("#myTarget").val();
	goAct(mode);
}

function goDataDeleteAct(mode, code, no) {
	var  x = confirm("삭제하시겠습니까?");
	if (x == true) { 
		$("input[name=menuType]").val("community");
		$("input[name=b_code]").val(code);
		$("#ub_no").val(no);
		goAct(mode);
	}
}

function goDataWriteMove(mode, code) {
	var page		= $("#page").val();
	var ub_p_code	= $("#ub_p_code").val();
	var href		= "./?menuType=community&myTarget=pop&mode="+mode+"&b_code="+code+"&ub_p_code="+ub_p_code+"&page="+page;
	var option		= "width=600px, height=550px";

	window.open(href,'',option);
}

function goDataListMove(mode, code) {
	var page		= $("#page").val();
	location.href	= "./?menuType=community&mode="+mode+"&b_code="+code+"&page="+page;
}

function goDataModifyMove(mode, code, no) {
	var page		= $("#page").val();
	var ub_p_code	= $("#ub_p_code").val();
	var href		= "./?menuType=community&myTarget=pop&mode="+mode+"&b_code="+code+"&ub_no="+no+"&ub_p_code="+ub_p_code+"&page="+page;
	var option		= "width=600px, height=550px";

	window.open(href,'',option);
}

function goDataViewMove(mode, code, no) {
	$("tr[id^=dataView_"+code+"_]").css({'display':'none'});
	$("tr[id=dataView_"+code+"_"+no+"]").css({'display':''});
}