

/* 이벤트 정의 */
function goCommentModifyMoveEvent(cm_no)		{ goCommentModifyMove(cm_no);		}

function goCommentWriteActEvent()				{ goCommentWriteAct();				}
function goCommentDeleteActEvent(cm_no)			{ goCommentDeleteAct(cm_no);		}
function goCommentModifyActEvent(cm_no)			{ goCommentModifyAct(cm_no);		}

function goCommentPasswordCancelEvent(cm_no)	{ goCommentPasswordCancel(cm_no);	}
function goCommentModifyCancelEvent(cm_no)		{ goCommentModifyCancel(cm_no);		}

function goCommentModifyPassEvent(cm_no)		{ goCommentModifyPass(cm_no);		}
function goCommentDeletePassEvent(cm_no)		{ goCommentDeletePass(cm_no);		}
function goCommentLoginMoveEvent()				{ goCommentLoginMove();				}

/* 이벤트 수행 */
function goCommentLoginMove() {
	alert("로그인 후 이용하실 수 있습니다.");
	location.href = "./?menuType=member&mode=login&returnMenu=community";
//	location.href = "./?menuType=member&mode=login&returnMenu=community&returnMode=dataView&&b_code=REQ&&ub_no=3&&page=1";
}

function goCommentModifyMove(cm_no) {
	var code		= $("#commentList_"+cm_no);
	var cm_m_no		= $(code).attr("cm_m_no");
	
	if(cm_m_no <= 0){
		/* 비회원 비밀번호 폼 그리기(수정) */
		$("#commentListArea").find("#commentModifyDiv").remove();
		$("#commentListArea").find("#commentPasswordDiv").remove();
		var pwdCode = $("#commentPasswordForm").val();
		pwdCode		= $(pwdCode);
		$(pwdCode).find("a[id=commentPasswordOK]").attr("href", "javascript:goCommentModifyPassEvent('"+cm_no+"')");
		$(pwdCode).find("a[id=commentPasswordCancel]").attr("href", "javascript:goCommentPasswordCancelEvent('"+cm_no+"')");
		$(pwdCode).find("input[id=cm_pass_check]").attr("check", "password");
		$(code).append(pwdCode);
	}else{
		/* 회원 수정 폼 그리기 */
		var mode		= "commentModifyEdit";
		var callBack	= "commentModifyEditCallBack";
		$("#cm_no").val(cm_no);
	//	goAct(mode);	
		goJson(mode, callBack, false); 
	}
}

function goCommentWriteAct() {
	/* 회원, 비회원 글 등록 */
	var	mode		= "commentWrite";
	var callBack	= "commentWriteCallBack";
//	goAct(mode, "write");	
	goJson(mode, callBack, "write"); 
}

function goCommentModifyAct(cm_no) {
	/* 회원이 코멘트 수정 후 */
	var	mode		= "commentModify";
	var callBack	= "commentModifyCallBack";
	$("#cm_no").val(cm_no);
//	goAct(mode, "modify");	
	goJson(mode, callBack, "modify"); 	
}

function goCommentDeleteAct(cm_no) {
	var mode		= "commentDelete";
	var callBack	= "commentDeleteCallBack";
	var code		= $("#commentList_"+cm_no);
	var cm_m_no		= $(code).attr("cm_m_no");
	if(cm_m_no <= 0){
		/* 비회원 비밀번호 폼 그리기(삭제) */
		$("#commentListArea").find("#commentModifyDiv").remove();
		$("#commentListArea").find("#commentPasswordDiv").remove();
		var pwdCode = $("#commentPasswordForm").val();
		pwdCode		= $(pwdCode);
		$(pwdCode).find("a[id=commentPasswordOK]").attr("href", "javascript:goCommentDeletePassEvent('"+cm_no+"')");
		$(pwdCode).find("a[id=commentPasswordCancel]").attr("href", "javascript:goCommentPasswordCancelEvent('"+cm_no+"')");
		$(pwdCode).find("input[id=cm_pass_check]").attr("check", "password");
		$(code).append(pwdCode);
	}else{
		/* 회원 글 삭제 */
		var  x = confirm("삭제하시겠습니까?");
		if (x == true) { 
			$("#cm_no").val(cm_no);
			goJson(mode, callBack, false); 			
		}
	}
}

function goCommentModifyPass(cm_no) {
	/* 비회원 수정 비밀번호 체크 */
	var mode		= "commentModifyPass";
	var callBack	= "commentModifyEditCallBack";
	$("#cm_no").val(cm_no);
	goJson(mode, callBack, "password"); 
}

function goCommentDeletePass(cm_no) {
	/* 비회원 삭제 비밀번호 체크 및 삭제 */
	var mode		= "commentDelete";
	var callBack	= "commentDeleteCallBack";
	$("#cm_no").val(cm_no);
//	goAct(mode, "password");
	goJson(mode, callBack, "password");
}

function goCommentPasswordCancel(cm_no) {
	/* 비회원 수정, 삭제 비밀번호 폼에서 취소 액션 */
	$("#commentPasswordDiv").remove();
}

function goCommentModifyCancel(cm_no) {
	/* 회원, 비회원 수정 폼에서 취소 액션 */
	$("#commentListArea").find("#commentModifyDiv").remove();
}

/* 이벤트 콜백 수행 */
function commentWriteCallBack(obj) {
	/* 글쓰기 콜백 */
	if(obj.mode != 1) {
		alert("글등록 할 수 없습니다.");
	}else{
		var cm_no		= obj.data['cm_no'];
		var cm_name		= obj.data['cm_name'];
		var cm_m_id		= obj.data['cm_m_id'];
		var cm_mail		= obj.data['cm_mail'];
		var cm_func		= obj.data['cm_func'];
		var cm_m_no		= obj.data['cm_m_no'];
		var cm_title	= obj.data['cm_title'];
		var cm_text		= obj.data['cm_text'];
		if(cm_m_no <= 0){
			/* 비회원이 작성한 글 리스트 폼 그리기*/
			var code		= $("#commentListArea");
			var listCode	= $("#commentListForm").val();
			listCode		= $(listCode);
			$(listCode).attr("id", "commentList_"+cm_no);
//			$(listCode).attr("cm_m_no", cm_m_no);
			$(listCode).find("#cm_name").text(cm_name);
			$(listCode).find("#cm_text").html(cm_text);
			$(listCode).find("a[id=commentModify]").attr("href", "javascript:goCommentModifyMoveEvent('"+cm_no+"')");
			$(listCode).find("a[id=commentDelete]").attr("href", "javascript:goCommentDeleteActEvent('"+cm_no+"')");
			$(code).prepend(listCode);
			$("#commentWrite").find("input[id=cm_name]").val("");
			$("#commentWrite").find("input[id=cm_pass]").val("");
			$("#commentWrite").find("textarea[id=cm_text]").val("");
//			alert("등록되었습니다.");
		}else{
			/* 회원이 작성한 글 리스트 폼 그리기 */
			var code		= $("#commentListArea");
			var listCode	= $("#commentListForm").val();
			listCode		= $(listCode);
			$(listCode).attr("id", "commentList_"+cm_no);
			$(listCode).attr("cm_m_no", cm_m_no);
			$(listCode).find("#cm_name").text(cm_name);
			$(listCode).find("#cm_text").html(cm_text);
			$(listCode).find("a[id=commentModify]").attr("href", "javascript:goCommentModifyMoveEvent('"+cm_no+"')");
			$(listCode).find("a[id=commentDelete]").attr("href", "javascript:goCommentDeleteActEvent('"+cm_no+"')");
			$(code).prepend(listCode);
			$("#commentWrite").find("textarea[id=cm_text]").val("");
//			alert("등록되었습니다."); /* 2013.04.09 메시지 삭제 - 요청 */
		}
	}
}


function commentModifyEditCallBack(obj) {
	/* 회원이 내용 수정(수정폼으로 변경) */
	if(obj.mode != 1) {
		$("#commentListArea").find("#commentPasswordDiv").remove();
		alert("비밀번호가 틀렸습니다.");
	}else{
		var cm_no		= obj.data['cm_no'];
		var cm_name		= obj.data['cm_name'];
		var cm_m_id		= obj.data['cm_m_id'];
		var cm_mail		= obj.data['cm_mail'];
		var cm_func		= obj.data['cm_func'];
		var cm_m_no		= obj.data['cm_m_no'];
		var cm_title	= obj.data['cm_title'];
		var cm_text		= obj.data['cm_text'];
		if(cm_m_no <= 0){
			/* 비회원이 작성한 글 리스트 폼 그리기*/
			$("#commentListArea").find("#commentModifyDiv").remove();
			$("#commentListArea").find("#commentPasswordDiv").remove();
			var code		= $("#commentList_"+cm_no);
			var modifyCode	= $("#commentModifyForm").val();
			modifyCode		= $(modifyCode);
//			$(modifyCode).find("#cm_name_modify").val(cm_name);
//			$(modifyCode).find("#cm_pass_modify").val();
			$(modifyCode).find("#cm_name").remove();
			$(modifyCode).find("#cm_pass").remove();
			$(modifyCode).find("#cm_text_modify").val(cm_text);
			$(modifyCode).find("a[id=commentModifyOk]").attr("href", "javascript:goCommentModifyActEvent('"+cm_no+"')");
			$(modifyCode).find("a[id=commentModifyCancel]").attr("href", "javascript:goCommentModifyCancelEvent('"+cm_no+"')");
			$(code).append(modifyCode);
		}else{
			/* 회원이 작성한 글 리스트 폼 그리기 */
			$("#commentListArea").find("#commentModifyDiv").remove();
			var code		= $("#commentList_"+cm_no);
			var modifyCode	= $("#commentModifyForm").val();
			modifyCode		= $(modifyCode);
			$(modifyCode).find("#cm_name").remove();
			$(modifyCode).find("#cm_pass").remove();
			$(modifyCode).find("#cm_text_modify").val(cm_text);
			$(modifyCode).find("a[id=commentModifyOk]").attr("href", "javascript:goCommentModifyActEvent('"+cm_no+"')");
			$(modifyCode).find("a[id=commentModifyCancel]").attr("href", "javascript:goCommentModifyCancelEvent('"+cm_no+"')");
			$(code).append(modifyCode);
		}
	}
}

function commentModifyCallBack(obj) {
	/* 수정 콜백 */
	if(obj.mode != 1) {
		$("#commentListArea").find("#commentModifyDiv").remove();
		alert("비밀번호가 틀렸습니다.");
	}else{
		var cm_no		= obj.data['cm_no'];
		var cm_name		= obj.data['cm_name'];
		var cm_m_id		= obj.data['cm_m_id'];
		var cm_mail		= obj.data['cm_mail'];
		var cm_func		= obj.data['cm_func'];
		var cm_m_no		= obj.data['cm_m_no'];
		var cm_title	= obj.data['cm_title'];
		var cm_text		= obj.data['cm_text'];
		if(cm_m_no <= 0){
			/* 비회원이 수정한 글 리스트 폼 그리기*/
			var code = $("#commentListArea").find("#commentList_"+cm_no);
			$(code).find("#cm_text").html(cm_text);
			$("#commentListArea").find("#commentModifyDiv").remove();
//			alert("수정되었습니다.");
		}else{
			/* 회원이 수정한 글 리스트 폼 그리기 */
			var code = $("#commentListArea").find("#commentList_"+cm_no);
			$(code).find("#cm_text").html(cm_text);
			$("#commentListArea").find("#commentModifyDiv").remove();
//			alert("수정되었습니다.");
		}
	}
}

function commentDeleteCallBack(obj) {
	/* 내용 삭제 콜백  */
	if(obj.mode != 1) {
		$("#commentListArea").find("#commentPasswordDiv").remove();
		alert("비밀번호가 틀렸습니다.");
	}else{
		var cm_no		= obj.data['cm_no'];
		$("#commentList_"+cm_no).remove();
//		alert("삭제되었습니다.");
	}

}

function commentModifyPassCallBack(obj) {
	/* 비회원 수정 비회원 비밀번호 체크 후 콜백 */
	alert(obj.mode)
}

function commentDeletePassCallBack(obj) {
	/* 비회원 삭제 비회원 비밀번호 체크 후 콜백 */
	alert(obj.mode);
}