
/* 이벤트 */
function goDataViewMoveEvent(ub_no)	{ goDataViewMove(ub_no);	}
function goDataWriteMoveEvent()		{ goDataWriteMove();		}
function goDataCancelMoveEvent()	{ goDataCancelMove();		}
function goDataListMoveEvent()		{ goDataListMove();			}

function goDataWriteActEvent()		{ goDataWriteAct();			}


/* 실행 */
function goDataViewMove(ub_no) {
	var	mode1		= "dataView";
	var inputName	= new Array("menuType", "mode", "b_code");
	var data		= new Array(5);
	data['mode1']	= mode1;
	data['ub_no']	= ub_no;
//	goLocation(inputName, data);
}

function goDataWriteMove() {
	var	mode1		= "dataWrite";
	var inputName	= new Array("menuType", "mode", "b_code");
	var data		= new Array(5);
	data['mode1']	= mode1;
	goLocation(inputName, data);
}

function goDataListMove() {
	var	mode1		= "dataList";
	var inputName	= new Array("menuType", "mode", "b_code");
	var data		= new Array(5);
	data['mode1']	= mode1;
	goLocation(inputName, data);
}

function goDataCancelMove() {
	var	mode1		= "dataList";
	var inputName	= new Array("menuType", "mode", "b_code");
	var data		= new Array(5);
	data['mode1']	= mode1;
	goLocation(inputName, data);
}


function goDataWriteAct() {
	var	mode		= "dataWrite";	
}


/* common */
function goLocation(inputName, data) {
	href			= goMakUrl(inputName, data);
	location.href	= href;
}

/**
 * goAct(mode, check)
 * mode		=>  false : 체크 안함, null, 
 **/
function goAct(mode, check) {
	// 액션
	if(!goCheckForm(check)) { return; }
	C_getAction(mode, G_PHP_SELF);
}

function goMakUrl(inputName, data) {
	var href	= "./?";
	for (var key in inputName) {
		var input = $("input[name="+inputName[key]+"]");
		var type  = $(input).attr("type");
		if(type == "hidden" || type == "text"){
			var val = $(input).val();
			if(val) { 
				href = href + inputName[key] + "=" + val + "&";
				continue;
			}
		}
	}
	for (var key in data) {
		href = href + key + "=" + data[key] + "&";
	}
	return href;
}

function C_getAction(mode,act){
	var doc				= document.form;
	doc.action			= act;
	doc.mode.value		= "act";
	doc.act.value		= mode;
	doc.method			="post";
	doc.submit();
}

function goCheckForm(check) {

	if(check == "false") { return 1; }
	if(check == null) { check = "Y"; }
	var goStop = "go";

	$("select[check="+check+"]").each(function() {
		if(!$(this).val()) {
			alert($(this).attr("alt") + "을(를) 입력하세요.");
			$(this).focus();
			goStop = "stop";
			return false;
		}
	});

	if(goStop == "stop") { return false; }

	$("input").each(function() {
		if($(this).attr("alt") && $(this).attr("check") == check){
			if($(this).attr("type")=="text" || $(this).attr("type")=="password"){
				if(!$(this).val()){
					alert($(this).attr("alt") + "을(를) 입력하세요.");
					$(this).focus();
					goStop = "stop";
					return false;
				}
			}
		}
	});

	if(goStop == "stop") { return false; }

	$("textarea").each(function() {
		if($(this).attr("alt") && $(this).attr("check") == check){
			if(!$(this).val()){
				alert($(this).attr("alt") + "을(를) 입력하세요.");
				$(this).focus();
				goStop = "stop";
				return false;
			}
		}
	});

 	if(goStop == "stop") { return false; }

	return goStop;

}