
/* 이벤트 정의 */
//function goDataViewMove(no)			{	goDataView("dataView", no);		}		// 커뮤니티 글 보기(이동)
//function goDataWriteMove()			{	goMove("dataWrite");			}		// 커뮤니티 글 등록(이동)
//function goDataModifyMove()			{	goMove("dataModify");			}		// 커뮤니티 글 수정(이동)
//function goDataListMove()			{	goMove("dataList");				}		// 커뮤니티 글 리스트(이동)
//
//function goDataWriteAct()			{	goAct("dataWrite");				}		// 커뮤니티 글 등록(액션)
//function goDataModifyAct()			{	goAct("dataModify");			}		// 커뮤니티 글 수정(액션)
//function goDataDeleteAct()			{	goDataDelete("dataDelete");		}		// 커뮤니티 글 삭제(액션)
//
//function goDataView(mode, no) {
//	document.form.ub_no.value = no;
//	goMove(mode);
//}
//
//function goDataDelete(mode, no) {
//	var  x = confirm("삭제하시겠습니까?");
//	if (x == true) {
//		goAct(mode);	
//	}
//}

$(document).ready(function() {
	$("#checkAll").change(goCheckboxChange);
});


function goDataViewMove1(code, no)					{ goDataViewLocation1("dataView", code, no);		}		// 커뮤니티 글 보기(이동)
function goDataViewMove2(no)						{ goDataViewLocation2("dataView", no);				}		// 커뮤니티 글 보기(이동)
function goDataListMove()							{ goDataListLocation("dataList");					}		// 커뮤니티 글 보기(이동)
function goDataWriteMove()							{ goDataListLocation("dataWrite");					}		// 커뮤니티 글 보기(이동)
function goDataModifyMove()							{ goDataModifyLocation("dataModify");				}		// 커뮤니티 글 수정(이동)
function goDataAnswerMove(no)						{ goDataLocation("dataAnswer");						}		// 커뮤니티 글 답변(이동)
function goDataWriteAct()							{ goAct("dataWrite", "write");						}		// 커뮤니티 글 등록(액션)
function goDataModifyAct()							{ goAct("dataModify");								}		// 커뮤니티 글 등록(액션)
function goDataDeleteAct()							{ goDataDelete("dataDelete");						}		// 커뮤니티 글 삭제(액션)
function goDataAnswerAct()							{ goAct("dataAnswer");								}		// 커뮤니티 글 답변(액션)	
function goDataDownloadMoveEvent(b_code, no)		{ goDataDownloadMove(b_code, no);					}		// 파일 다운로드
function goDataWriteMobileAreaShowEvent()			{ goDataWriteMobileAreaShow();						}		// mobileArea 펼침
function goBoardModifyMoveEvent()					{ goBoardModifyMove();								}		// 기능설정 페이지로 이동
function goCommentExcelDownMoveEvent()				{ goCommentExcelDownMove("commentExcelDown");		}		// 이벤트댓글엑셀다운로드
function goDataDeleteMultiActEvent()				{ goDataDeleteMultyActCheck("dataDeleteMulti");		}		// 커뮤니티 글 다중 삭제(액션)
function goCommentPointGiveActEvent()				{ goCommentPointGiveAct();							}
function goCommentCouponGiveActEvent()				{ goCommentCouponGiveAct();							}
function goCommentPointCancelActEvent()				{ goCommentPointCancelAct();						}		// 포인트 발급 취소
function goCommentCouponCancelActEvent()			{ goCommentCouponCancelAct();						}		// 쿠폰 발급 취소
function goCommentDeleteMultiActEvent()				{ goCommentDeleteMultiAct();						}		// 코멘트 삭제
function goCommentListMoveEvent()					{ goCommentListMove();								}		// 이벤트 - 코멘트 리스트 이동
function goCategoryMoveEvent(bc_no)					{ goCategoryMove(bc_no);							}
function goDataViewShowEvent(no)					{ goDataViewShow(no);								}		// 커뮤니티 글 보기(펼침)

function goDataViewShow(no) {
	var display			= $("[id=textShow_"+no+"]").css("display");

	$("[id^=textShow_]").css("display","none");

	if(display == "none")	{	$("[id=textShow_"+no+"]").css("display", "");			} 
	else					{	$("[id=textShow_"+no+"]").css("display", "none");		}
}

function goCategoryMove(bc_no) {
	var inputName		= new Array("menuType", "mode", "b_code");
	var data			= new Array(5);
	data['ub_bc_no']	= bc_no;

	goLocation(inputName, data);
}

function goCommentListMove() {
	var mode		= "commentList";
	var b_code		= $("#b_code").val();
	var ub_no		= $("#ub_no").val();

	location.href	= "./?menuType=community&mode="+mode+"&b_code="+b_code+"&ub_no="+ub_no;
}

function goCommentDeleteMultiAct() {
	if(goCheckBox() <= 0) { alert("회원을 먼저 선택해주세요."); return false; }

	var mode	= "commentDeleteMulti";
	var x		= confirm("삭제 하시겠습니까?");
	if (x == true) {  goAct(mode); 	}	
}

function goCommentCouponCancelActEvent() {
	if(goCheckBox() <= 0) { alert("회원을 먼저 선택해주세요."); return false; }

	var mode	= "commentCouponCancel";
	var x		= confirm("쿠폰 발급을 취소 하시겠습니까?");
	if (x == true) {  goAct(mode); 	}	
}

function goCommentPointCancelAct() {
	if(goCheckBox() <= 0) { alert("회원을 먼저 선택해주세요."); return false; }

	var mode	= "commentPointCancel";
	var x		= confirm("포인트 발급을 취소 하시겠습니까?");
	if (x == true) {  goAct(mode); 	}
}

function goCommentPointGiveAct() {
	
	var gm_no = $("select[name=bi_point_c_multi_no]").val();
	if(typeof gm_no != "undefined"){
		if(gm_no == ""){
			alert("포인트 발급 정보를 선택하세요.");
			return false;
		}
		$("input[name=cm_point_gm_no]").val(gm_no);
	}

	if(goCheckBox() <= 0) { alert("회원을 선택해주세요."); return false; }

	var mode	= "commentPointGive";
	var x		= confirm("선택하신 회원에게 포인트를 발급 하시겠습니까?");
	if (x == true) {  goAct(mode); 	}
}

function goCommentCouponGiveAct(mode) {

	var gm_no = $("select[name=bi_coupon_c_multi_no]").val();
	if(typeof gm_no != "undefined"){
		if(gm_no == ""){
			alert("쿠폰 발급 정보를 선택하세요.");
			return false;
		}
		$("input[name=cm_coupon_gm_no]").val(gm_no);
	}

	if(goCheckBox() <= 0) { alert("회원을 먼저 선택해주세요."); return false; }

	var mode	= "commentCouponGive";
	var x		= confirm("선택하신 회원에게 쿠폰을 발급 하시겠습니까?");

	if (x == true) { 
		goAct(mode);
	}
}


function goCheckBox() {
	var intCnt = 0;
	$("input[id=check]").each(function() {
		if($(this).attr("checked")=="checked") {
			intCnt++;
		}
	});
	return intCnt;
}

function goBoardModifyMove() {
	var mode		= "boardModifyBasic";
	var b_code		= $("#b_code").val();

	location.href	= "./?menuType=community&mode="+mode+"&b_code="+b_code;
}

function goDataWriteMobileAreaShow() {
	var cssDisplay = $("#mobileArea").css("display");
	if(cssDisplay == "none"){
		$("#mobileArea").css({'display':''});
	}else{
		$("#mobileArea").css({'display':'none'});
	}
}

function goDataDownloadMove(b_code, no) {
	location.href = "./?menuType=popup&mode=download&b_code="+b_code+"&fl_no="+no;
}

function goDataDelete2(mode, no) {
	$("#ub_no").val(no);
	goDataDelete(mode, no);
}

function goDataDelete(mode, no) {
	var  x = confirm("삭제하시겠습니까?");
	if (x == true) { 
		goAct(mode); 
	}
}

function goDataViewLocation1(mode, code, no) {
	goDataLocation1(mode, code, no);
}

function goDataViewLocation2(mode, no) {
	var code	= $("#b_code").val();
	goDataLocation1(mode, code, no);
}

function goDataListLocation(mode) {
	var code	= $("#b_code").val();
	goDataLocation2(mode, code);
}

function goDataModifyLocation(mode) {
	var code	= $("#b_code").val();
	var no		= $("#ub_no").val();
	goDataLocation1(mode, code, no);
}


function goDataLocation1(mode, code, no)	{	location.href	= "./?menuType=community&mode="+mode+"&b_code="+code+"&ub_no="+no;		}
function goDataLocation2(mode, code)		{	location.href	= "./?menuType=community&mode="+mode+"&b_code="+code;					}

function goDataLocation(mode) {
	var b_code		= $("#b_code").val();
	var page		= $("#page").val();
	var ub_no		= $("#ub_no").val();

	location.href	= "./?menuType=community&mode="+mode+"&b_code="+b_code+"&ub_no="+ub_no+"&page="+page;
}



/**
 * goDataDeleteMultyActCheck()
 * 선택된 체크박스 데이터 삭제
 **/
function goDataDeleteMultyActCheck(mode) {

	var intCnt = 0;
	$("input[id=check]").each(function() {
		if($(this).attr("checked")=="checked") {
			intCnt++;
		}
	});
	
	if(intCnt <= 0) { 
		alert("선택항목이 없습니다.");
		return; 
	}

	goAct(mode);
}



/* 첨부파일 */
function goAttachedfileOpen()		{	goAttachedfile();									}																	// 커뮤니티 첨부파일 윈도우창 열기
function goAttachedfileTempDeleteJsonEvent(no) { goAttachedfileTempDeleteJson(no, "attachedfileTempFileDelete", "attachedfileTempFileDeleteCallBack"); }		// 커뮤니티 첨부파일 삭제

function goAttachedfile() {
	var b_code		= $("#b_code").val();
	var url			= "./?menuType=community&mode=attachedfileWrite&myTarget=pop&b_code="+b_code;
	window.open(url,'','width=400, height=500');
}

function goAttachedfileDelete(no) {
	$("#fl_file_"+no).find("img").remove();	
	$("#fl_file_"+no).find("span").remove();	
	$("#fl_file_"+no).find("a").remove();	
	$("#fl_file_"+no).find("input[id=fl_no]").attr("name","del_fl_no[]");
}

function goAttachedfileTempDeleteJson(no, mode, callBack ) {
	$("#attached_filetemp_del").val(no);
//	goAct(mode, false);
	goFileJson(mode, callBack);
}
	
function goAttachedfileCallBack(obj) {
	var appendText = $("#fileList_form").text();
//	$("#fileList").text("")
	for(var i=0;i<obj.length;i++) {
		if(obj[i].F_SFNAME) {
			// 파일이 있다면
			var imgSrc			= obj[i].F_WPATH + obj[i].F_SFNAME;
			var f_sfname		= obj[i].F_SFNAME;
			var f_key			= obj[i].F_KEY;
			var fileDeleteHref	= "javascript:goAttachedfileTempDeleteJsonEvent('"+i+"');";
			$("#fileList").after(appendText).next().attr("id","fileList_"+i);
			$("#fileList_"+i).find("li").attr("id", "fileList_"+i);
			if(f_key == "file"){
				$("#fileList_"+i).find("span").html(f_sfname);
				$("#fileList_"+i).find("img").remove();
			}else {
				$("#fileList_"+i).find("img").attr("src", imgSrc);
				$("#fileList_"+i).find("span").remove();
			}
			$("#fileList_"+i).find("input[id=fl_temp_file]").attr("value", f_sfname); 
			$("#fileList_"+i).find("input[id=fl_temp_key]").attr("value", f_key); 
			$("#fileList_"+i).find("a").attr("href", fileDeleteHref); 
		} else {
			// 파일이 없으면
		}
	}
}

function attachedfileTempFileDeleteCallBack(obj) {
	if(obj){
		if(obj.mode){
			var no = obj.data['no'];
			$("#fileList_"+no).remove();
		}
	}
}

function goCommentExcelDownMove(mode)
{
	$("input[name=myTarget]").val("excel");
	$("input[name=excelType]").val("commentList");
	goMove(mode);
}

/**
 * goCheckboxChange()
 * 체크박스 상태 변경
 **/
function goCheckboxChange() {
	if($(this).attr("checked")=="checked"){
		$("input[id=check]").attr("checked",true);
	} else {
		$("input[id=check]").attr("checked",false);
	}
}


function goDataIconWriteActEvent() {

	// 기본 설정
	var iconName	= $("select[id=iconName]").val();
	var intCnt		= $("input[id=check]:checked").length;

	// 기본 설정 체크
	if(!iconName) {
		alert("설정할 아이콘 이름을 선택하세요.");
		return;
	}	
	if(intCnt <= 0) { 
		alert("선택항목이 없습니다.");
		return; 
	}

	// 데이터 만들기
	var data				= new Object();
	var b_code				= $("input[id=b_code]").val();
	
	data['menuType']		= "community";
	data['mode']			= "json";
	data['act']				= "boardIconWrite";
	data['b_code']			= b_code;
	data['iconName']		= iconName;
	data['check']			= "";

	$("input[id=check]:checked").each(function() {
		var temp = $(this).val();
		if(data['check']) { data['check'] = data['check'] + ","; }
		data['check'] = data['check'] + temp; 
	});
	
	// 실행
	$.ajax({
		url			: "./"
	   ,data		: data
	   ,type		: "POST"
	   ,dataType	: "json"
	   ,success		: function(data) {	
							if(data['__STATE__'] == "SUCCESS") {
								alert("등록되었습니다.");
							} else {
								alert(data);
							}
					   }
	});
}