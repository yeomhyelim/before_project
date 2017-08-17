
/* 이벤트 정의 */
function goTalkWriteEvent()					{ goTalkWriteJson("talkWrite", "goTalkWriteCallBack");				}		//      글 등록 액션
function goTalkDeleteEvent(no)				{ goTalkDeleteJson("talkDelete", "goTalkDeleteCallBack", no);		}		// 회원 글 삭제 액션
function goTalkModifyEvent(no)				{ goTalkModifyFormChange(no);										}		//      글 수정 폼으로 변경
function goTalkModifyActEvent(no)			{ goTalkModifyJson("talkModify", "goTalkModifyCallBack", no);		}		//      글 수정 액션
function goTalkCancelEvent(no)				{ goTalkModifyRollback(no);											}		//      글 수정 취소

/* ** Json ** */


/**
 * goTalkWriteJson(mode, callback)
 * mode			: 모드
 * callback		: json 수행 후 실행 함수
 * 글 삭제
 **/
function goTalkWriteJson(mode, callback) {
	
//	alert($(this).attr("href"));
//	return;
	goJson(mode, callback);
//	goAct(mode);
}


/**
 * goTalkDeleteJson(mode, callback, no)
 * mode			: 모드
 * callback		: json 수행 후 실행 함수
 * no			: 번호
 * 글 삭제
 **/
function goTalkDeleteJson(mode, callback, no) {
	var  x = confirm("삭제하시겠습니까?");
	if (x == true) { 
		$("input[name=ub_no]").val(no);
		goJson(mode, callback);
//		goAct(mode);
	}
}


/**
 * goTalkModifyJson(mode, callback, no)
 * mode			: 모드
 * callback		: json 수행 후 실행 함수
 * no			: 번호
 * 글 수정 액션
 **/
function goTalkModifyJson(mode, callback, no) {
	$("input[name=ub_no]").val(no);
	goJson(mode, callback);
//	goAct(mode);
}


/**
 * goTalkModifyRollback(no)
 * no			: 번호
 * 글 수정 취소
 **/
function goTalkModifyRollback(no) {
	$("#talk_modify_"+no).remove();	
	$("#talk_"+no).css({'display':''});	
}


/**
 * goTalkModifyFormChange(no)
 * no			: 번호
 * 글 수정 폼으로 변경
 **/
function goTalkModifyFormChange(no) {
	var ub_name		= $("#talk_"+no).find("#talkUbName").text();
	var ub_talk		= $("#talk_"+no).find("#talkUbTalk").html();
	var code		= $("#modify_form").val();
	    code		= $(code).attr("id","talk_modify_"+no);

	$(code).find("#talkUbName").text(ub_name);	
	$(code).find("#ub_talk_modify").html(ub_talk);	
	$(code).find("#nonmember_input").remove();
	$(code).find("#talkModify").attr("href","javascript:goTalkModifyActEvent('"+no+"')");
	$(code).find("#talkModifyCancel").attr("href","javascript:goTalkCancelEvent('"+no+"')");
	$("#talk_"+no).after(code);
	$("#talk_"+no).css({'display':'none'});
}

/* ** callBack ** */

/**
 * goTalkWriteCallBack(obj)
 * obj			: json 결과값.
 * 글 등록 콜백 결과
 **/
function goTalkWriteCallBack(obj) {
	if(!obj) { return; }
	if(!obj.mode) {
		alert("다시 입력해주세요.");
	} else {
		var no			= obj.data['UB_NO'];
		var ub_talk		= obj.data['UB_TALK'];
		var ub_name		= obj.data['UB_NAME'];
		var code		= $("#insert_form").val();
		    code		= $(code).attr("id","talk_"+no);
		
		$(code).find("th").text(ub_name);
		$(code).find("#talkUbTalk").text(ub_talk);
		$(code).find("#talkModify").attr("href","javascript:goTalkModifyEvent('"+no+"')");
		$(code).find("#talkDelete").attr("href","javascript:goTalkDeleteEvent('"+no+"')");
		$("#talkList_Table").prepend(code);		
	}
}

/**
 * goTalkModifyCallBack(obj)
 * obj			: json 결과값.
 * 글 수정 콜백 결과
 **/
function goTalkModifyCallBack(obj) {
	if(!obj.mode) {
		alert("수정 할수 없습니다.");
	} else {
		var no = obj.data['UB_NO'];
		$("#talk_modify_"+no).remove();
		$("#talk_"+no).css({"display":""});
		$("#talk_"+no).find("#talkUbName").text(obj.data['UB_NAME']);
		$("#talk_"+no).find("#talkUbTalk").text(obj.data['UB_TALK']);
		alert("수정되었습니다.");	
	}
}

/**
 * goTalkDeleteCallBack(obj)
 * obj			: json 결과값.
 * 글 삭제 콜백 결과
 **/
function goTalkDeleteCallBack(obj) {
	if(!obj.mode) {
		alert("삭제할 수 없습니다.");
		return;
	} else {
		var no = obj.data['UB_NO'];
		$("#talk_"+no).remove();
		alert("삭제되었습니다.");
	}

}

