function goDataViewMoveEvent(no, bCode) {
	var data = new Array();

	data['tab']		= "dataView";
	data['b_code']	= bCode;
	data['ubNo']	= no;

	goAddLocation(data);
}

function goDataAnswerWriteShowEvent() {
	$("#answerMode").css("display","");

	$("#viewBtnMode").css("display","none");
	$("#answerBtnMode").css("display","");
}

function goDataAnswerCancelShowEvent() {
	$("#answerMode").css("display","none");

	$("#viewBtnMode").css("display","");
	$("#answerBtnMode").css("display","none");
}

function goDataAnswerWriteActEvent(tab) {

	var title		= $("input[name=ub_title]").val();
	var text		= $("textarea[name=ub_text]").val();

	if(!title) {
		alert("제목을 입력하세요.");
		return;
	}

	if(!text) {
		alert("내용을 입력하세요.");
		return;
	}

	$("input[name=mode]").val("json");
	$("input[name=act]").val("dataAnswerWrite");
	$("input[name=ub_mode]").val(htmlYN);

	var data		= $("#form").serializeArray();
	
	$.ajax({
		url			: "./"
	   ,data		: data
	   ,type		: "POST"
	   ,dataType	: "json"
	   ,success		: function(data) {	
							if(data['__STATE__'] == "SUCCESS") {
								alert("답변이 등록되었습니다.");

								var data2		= new Array();
								data2['tab']	= tab;
								data2['page']	= 1;
								data2['ubNo']	= "";
								goAddLocation(data2);								
							} else {
								alert(data);
							}
					   }
	});
}

function goDataDeleteActEvent(no, bCode, tab) {
	var data		= new Object();
	var x			= confirm("삭제하시겠습니까?");
	if(!x) { return; }
	data['menuType']		= "member";
	data['mode']			= "json";
	data['act']				= "dataDelete";
	data['ub_no']			= no;
	data['b_code']			= bCode;

	$.ajax({
		url			: "./"
	   ,data		: data
	   ,type		: "POST"
	   ,dataType	: "json"
	   ,success		: function(data) {	
							if(data['__STATE__'] == "SUCCESS") {
								alert("삭제되었습니다.");

								var data2		= new Array();
								data2['tab']	= tab;
								data2['page']	= 1;
								data2['ubNo']	= "";
								goAddLocation(data2);
							} else if(data['__STATE__'] == "HAVE_ANS") {
								alert("답변글이 있는 경우 삭제 할 수 없습니다.");
							} else {
								alert(data);
							}
					   }
	});
}

function goDataListMoveEvent(tab) {
	var data = new Array();

	data['tab']		= tab;
	data['b_code']	= "";
	data['ubNo']	= "";

	goAddLocation(data);
}

function goDataModifyMoveEvent(no) {
	var data = new Array();

	data['tab']		= "dataModify";
	data['ubNo']	= no;

	goAddLocation(data);
}

function goDataModifyActEvent() {

	
	var title		= $("input[name=ub_title]").val();
	var text		= $("textarea[name=ub_text]").val();

	if(!title) {
		alert("제목을 입력하세요.");
		return;
	}

	if(!text) {
		alert("내용을 입력하세요.");
		return;
	}

	$("input[name=mode]").val("json");
	$("input[name=act]").val("dataModify");
	$("input[name=ub_mode]").val(htmlYN);

	var data		= $("#form").serializeArray();
	
	$.ajax({
		url			: "./"
	   ,data		: data
	   ,type		: "POST"
	   ,dataType	: "json"
	   ,success		: function(data) {	
							if(data['__STATE__'] == "SUCCESS") {
								alert("수정되었습니다.");
								var data2			= new Array();
								data2['tab']		= "dataView";
								goAddLocation(data2);
							} else {
								alert(data);
							}
					   }
	});

}


function goSendEmailActEvent() {

	// 기본 설정
	var data			= new Object();
	var sendName		= $("input[name=send_name]").val();
	var sendEmail		= $("input[name=send_email]").val();
	var receiveName		= $("input[name=receive_name]").val();
	var receiveEmail	= $("input[name=receive_mail]").val();
	var pmTitle			= $("input[name=pm_title]").val();
	var pmText			= $("textarea[name=pm_text]").val();
	var html			= $("input[name=html]:checked").val();
	var memberNo		= $("input[name=memberNo]").val();

	// 기본 설정 체크
	if(!sendName) {
		alert("보내는 사람 이름을 입력하세요.");
		$("input[name=send_name]").focus();
		return;
	}
	if(!sendEmail) {
		alert("보내는 사람 메일을 입력하세요.");
		$("input[name=send_email]").focus();
		return;
	}
	if(!receiveName) {
		alert("받는사람 사람 이름을 입력하세요.");
		$("input[name=receive_name]").focus();
		return;
	}
	if(!receiveEmail) {
		alert("받는사람 사람 이메일을 입력하세요.");
		$("input[name=receive_mail]").focus();
		return;
	}
	if(!pmTitle) {
		alert("메일 제목을 입력하세요.");
		$("input[name=pm_title]").focus();
		return;
	}
	if(!pmText) {
		alert("매일 내용을 입력하세요.");
		$("textarea[name=pm_text]").focus();
		return;
	}
	if(!html) { html = ""; }

	// 데이터 전달
	data['menuType']		= "member";
	data['mode']			= "json";
	data['act']				= "memberSendEmail2";
	data['sendName']		= sendName;
	data['sendEmail']		= sendEmail;
	data['receiveName']		= receiveName;
	data['receiveEmail']	= receiveEmail;
	data['title']			= pmTitle;
	data['text']			= pmText;
	data['html']			= html;
	data['memberNo']		= memberNo;

	$.ajax({
		url			: "./"
	   ,data		: data
	   ,type		: "POST"
	   ,dataType	: "json"
	   ,success		: function(data) {	
				if(data['__STATE__'] == "SUCCESS") {
					alert("이메일이 발송 되었습니다.");
					//location.reload();
					goMemberMailSendListMoveEvent();
				} else {
					alert(data);
				}
		   }
	});
}


function goSendSmsActEvent() {
	
	// 기본 설정
	var data		= new Object();
	var sendHp		= $("input[name=send_hp]").val();
	var sendName	= $("input[name=send_name]").val();
	var sendNo		= $("input[name=send_no]").val();
	var receiveHp	= $("input[name=receive_hp]").val();
	var smsText		= $("textarea[name=sms_text]").val();

	// 기본 설정 체크
	if(!sendHp) {
		alert("보내는 사람 연락처를 입력하세요.");
		$("input[name=send_hp]").focus();
		return;
	}
	if(!receiveHp) {
		alert("받는 사람 연락처를 입력하세요.");
		$("input[name=receive_hp]").focus();
		return;
	}
	if(!smsText) {
		alert("내용을 입력하세요.");
		$("textarea[name=sms_text]").focus();
		return;
	}

	// 데이터 전달
	data['menuType']		= "member";
	data['mode']			= "json";
	data['act']				= "memberSendSms";
	data['sendNo']			= sendNo;
	data['sendName']		= sendName;
	data['sendHp']			= sendHp;
	data['receiveHp']		= receiveHp;
	data['smsText']			= smsText;

	$.ajax({
		url			: "./"
	   ,data		: data
	   ,type		: "POST"
	   ,dataType	: "json"
	   ,success		: function(data) {	
				if(data['__STATE__'] == "SUCCESS") {
					alert("문자 발송이 되었습니다.");
				} else if(data['__STATE__'] == "NO_SMS_MONEY") {
					alert("문자 발송 금액이 부족합니다.");
				} else if(data['__STATE__'] == "NO_SMS_USE") {
					alert("문자 발송 권한이 없습니다.");
				} else if(data['__STATE__'] == "NO_SMS_TEXT") {
					alert("문자 발송 내용이 없습니다.");
				} else if(data['__STATE__'] == "NO_RECEIVE_HP") {
					alert("받는사람 연락처가 없습니다.");
				} else if(data['__STATE__'] == "NO_SEND_HP") {
					alert("보내는 사람 연락처가 없습니다.");
				} else {
					alert(data);
				}
		   }
	});
}

function goResultStateChangeActEvent(no) {

	// 기본 설정
	var data			= new Object();
	var resultState		= "";
	var resultState1	= $("tr[id=reportList_"+no+"]").find("select[name=resultState] option:checked").val();
	var resultState2	= $("tr[id=reportList_"+no+"]").find("input[name=resultState]").val();
	var b_code			= $("input[name=b_code]").val();

	if(resultState1) { resultState = resultState1; }
	if(resultState2) { resultState = resultState2; }



	// 데이터 전달
	data['menuType']		= "member";
	data['mode']			= "json";
	data['act']				= "resultStateChange";
	data['b_code']			= b_code;
	data['no']				= no;
	data['resultState']		= resultState;

	$.ajax({
		url			: "./"
	   ,data		: data
	   ,type		: "POST"
	   ,dataType	: "json"
	   ,success		: function(data) {	
				if(data['__STATE__'] == "SUCCESS") {
					alert("결과 상태가 변경되었습니다.");
				} else {
					alert(data);
				}
		   }
	});
}

function goMemberProdReportListSearch() {

	// 기본 설정
	var data				= new Object();
	var searchField			= $("select[id=searchField2] option:selected").val();
	var searchKey			= $("input[id=searchKey2]").val();
	var searchRegStartDt	= $("input[id=searchRegStartDt]").val();
	var searchRegEndDt		= $("input[id=searchRegEndDt]").val();
	var searchResultState	= $("select[id=searchResultState] option:selected").val();
	var searchCategoryState	= $("select[id=searchCategoryState] option:selected").val();

	// 기본 설정 체크
	if(!searchField)		{ searchField			= "";	}
	if(!searchKey)			{ searchKey				= "";	}
	if(!searchRegStartDt)	{ searchRegStartDt		= "";	}
	if(!searchRegEndDt)		{ searchRegEndDt		= "";	}
	if(!searchResultState)	{ searchResultState		= "";	}
	if(!searchCategoryState){ searchCategoryState	= "";	}

	// 데이터 전달
	data['searchField2']			= searchField;
	data['searchKey2']				= searchKey;
	data['searchRegStartDt']		= searchRegStartDt;
	data['searchRegEndDt']			= searchRegEndDt;
	data['searchResultState']		= searchResultState;
	data['searchCategoryState']		= searchCategoryState;

	// 이동
	goAddLocation(data);

}

function goMemberProdReportListExcelDownloadEvent() {

	// 기본 설정
	var data				= new Array();
	var searchField			= $("select[id=searchField2] option:checked").val();
	var searchKey			= $("input[id=searchKey2]").val();
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

function goSmsLengthCheckEvent(obj, maxByte) {

var str			= obj.value;
var str_len		= str.length;

var rbyte		= 0;
var rlen		= 0;
var one_char	= "";
var str2		= "";

for(var i=0; i<str_len; i++) {
	one_char = str.charAt(i);

	if(escape(one_char).length > 4) { rbyte += 2; }
	else { rbyte++;  }
	if(rbyte <= maxByte){ rlen = i+1; }
}

if(rbyte > maxByte){
    alert("한글 "+(maxByte/2)+"자 / 영문 "+maxByte+"자를 초과 입력할 수 없습니다.");
    str2 = str.substr(0,rlen);                                  //문자열 자르기
    obj.value = str2;
    fnChkByte(obj, maxByte);
}else{
  $("#smsLeng").html(rbyte + "/80");;
}

//	var smsLeng		= mb_length($("textarea[name=sms_text]").val());

//	$("#smsLeng").html(smsLeng + "/80");
}

function goMemberMailSendViewMoveEvent(no) {
	var data = new Array();

	data['tab']		= "memberMailSendView";
	data['plNo']	= no;

	goAddLocation(data);
}

function goMemberMailSendListMoveEvent() {
	var data = new Array();

	data['tab']		= "memberMailSendList";

	goAddLocation(data);
}

function goMemberMailSendMoveEvent() {
	var data = new Array();

	data['tab']		= "memberMailSend";

	goAddLocation(data);
}

function goResultModifyMoveEvent(intReportNo) {
	var data = new Array();

	data['tab']			= "memberProdReportModify";
	data['reportNo']	= intReportNo;

	goAddLocation(data);
}

function goReportDataModifyAct() {

	alert("A");
}