
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


function goDataViewMove1(code, no)		{	goDataViewLocation1("dataView", code, no);			}		// 커뮤니티 글 보기(이동)
function goDataViewMove2(no)			{	goDataViewLocation2("dataView", no);				}		// 커뮤니티 글 보기(이동)
function goDataListMove()				{	goDataListLocation("dataList");						}		// 커뮤니티 글 보기(이동)
function goDataWriteMove()				{	goDataListLocation("dataWrite");					}		// 커뮤니티 글 보기(이동)
function goDataModifyMove()				{	goDataModifyLocation("dataModify");					}		// 커뮤니티 글 수정(이동)
function goDataAnswerMove(no)			{	goDataLocation("dataAnswer");						}		// 커뮤니티 글 답변(이동)

function goDataWriteAct()				{	goAct("dataWrite", "write");						}		// 커뮤니티 글 등록(액션)
function goDataModifyAct()				{	goAct("dataModify");								}		// 커뮤니티 글 등록(액션)
function goDataDeleteAct()				{	goDataDelete("dataDelete");							}		// 커뮤니티 글 삭제(액션)
function goDataAnswerAct()				{	goAct("dataAnswer");								}		// 커뮤니티 글 답변(액션)	

function goAttachedfileOpen()			{	goAttachedfile();									}		// 커뮤니티 첨부파일 윈도우창 열기
function goDataDeleteMultiActEvent()	{	goDataDeleteMultyActCheck("dataDeleteMulti");		}		// 커뮤니티 글 다중 삭제(액션)

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

function goAttachedfile() {
	var b_code		= $("#b_code").val();
	var url			= "./?menuType=community&mode=attachedfileWrite&target=pop&b_code="+b_code;
	window.open(url,'','width=400, height=500');
}

function goAttachedfileDelete(no) {
	$("#fl_file_"+no).find("img").remove();	
	$("#fl_file_"+no).find("a").remove();	
	$("#fl_file_"+no).find("input[id=fl_no]").attr("name","del_fl_no[]");
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
			var fileDeleteHref	= "javascript:goAttachedfileTempDeleteJson('"+f_sfname+"');";
			$("#fileList").after(appendText).next().attr("id","fileList_"+i);
			$("#fileList_"+i).find("li").attr("id", "fileList_"+i);
			$("#fileList_"+i).find("img").attr("src", imgSrc);
			$("#fileList_"+i).find("input[id=fl_temp_file]").attr("value", f_sfname); 
			$("#fileList_"+i).find("input[id=fl_temp_key]").attr("value", f_key); 
			$("#fileList_"+i).find("a").attr("href", fileDeleteHref); 
		} else {
			// 파일이 없으면
		}
	}
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