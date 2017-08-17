
/* 이벤트 정의 */
function goDataViewMoveEvent(no)		{	goDataViewLocation("dataView", no);		}		// 커뮤니티 글 보기(이동)
function goDataViewMove2Event(code, no)	{	goDataViewMove2(code, no);				}		// 커뮤니티 글 보기(이동), FAQ 게시판
function goDataWriteMove()				{	goDataLocation("dataWrite");			}		// 커뮤니티 글 등록(이동)
function goDataModifyMove()				{	goDataLocation("dataModify");			}		// 커뮤니티 글 수정(이동)
function goDataModifyMove2(no)			{	goDataLocation2("dataModify", no);		}		// 커뮤니티 글 수정(이동)
function goDataListMove()				{	goDataLocation("dataList");				}		// 커뮤니티 글 리스트(이동)
function goDataAnswerMove(no)			{	goDataLocation("dataAnswer");			}		// 커뮤니티 글 답변(이동)
function goDataMPasswordMove()			{	goDataLocation("dataMPassword");		}
function goDataDPasswordMove()			{	goDataLocation("dataDPassword");		}

function goDataWriteAct()			{	goAct("dataWrite");									}		// 커뮤니티 글 등록(액션)
function goDataModifyAct()			{	goAct("dataModify");								}		// 커뮤니티 글 수정(액션)
function goDataDeleteAct()			{	goDataDelete("dataDelete");							}		// 커뮤니티 글 삭제(액션)
function goDataDeleteAct2(no)		{	goDataDelete2("dataDelete", no);					}		// 커뮤니티 글 삭제(액션)
function goDataAnswerAct()			{	goAct("dataAnswer");								}		// 커뮤니티 글 답변(액션)	
function goDataPasswordJson()		{	goJson("dataPassword", "goDataPasswordCallBack");	}		// 비밀번호 체크
//function goDataMPasswordJson()		{	goAct("dataMPassword");	}	// 비밀번호 체크
//function goDataDPasswordJson()		{	goAct("dataDPassword");	}	// 비밀번호 체크

function goAttachedfileOpen()		{	goAttachedfile();									}																	// 커뮤니티 첨부파일 윈도우창 열기
function goAttachedfileTempDeleteJsonEvent(no) { goAttachedfileTempDeleteJson(no, "attachedfileTempFileDelete", "attachedfileTempFileDeleteCallBack"); }		// 커뮤니티 첨부파일 삭제


function goDataViewMove2(code, no) {
	$("#data_"+code).find("tr[id^=dataView_]").css({'display':'none'});
	$("#data_"+code).find("tr[id=dataView_"+no+"]").css({'display':''});
}

function goDataDelete2(mode, no) {
	$("#ub_no").val(no);
	goDataDelete(mode, no);
}

function goDataDelete(mode, no) {
	var  x = confirm("삭제하시겠습니까?");
	if (x == true) { 
		goAct(mode, false); 
	}
}

function goDataPasswordCallBack(obj) {
	if(!obj.mode) {
		alert("비밀번호가 틀렸습니다.");
		return;
	} else {
		var act = $("#password_act").val();
		window[act]($("#password_mode").val());
	}
}


function goDataViewLocation(mode, no) {
	$("#ub_no").val(no);
	goDataLocation(mode);
}

function goDataLocation2(mode, no) {
	$("#ub_no").val(no);
	goDataLocation(mode);
}

function goDataLocation(mode) {
	var b_code		= $("#b_code").val();
	var page		= $("#page").val();
	var ub_no		= $("#ub_no").val();

	location.href	= "./?menuType=community&mode="+mode+"&b_code="+b_code+"&ub_no="+ub_no+"&page="+page;
}

function goAttachedfile() {
	var b_code		= $("#b_code").val();
	var url			= "./?menuType=community&mode=attachedfileWrite&myTarget=pop&b_code="+b_code;
	window.open(url,'','width=400, height=500');
}

function goAttachedfileDelete(no) {
	$("#fl_file_"+no).find("img").remove();	
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
			$("#fileList_"+i).find("img").attr("src", imgSrc);
			$("#fileList_"+i).find("input[id=fl_temp_file]").attr("value", f_sfname); 
			$("#fileList_"+i).find("input[id=fl_temp_key]").attr("value", f_key); 
			$("#fileList_"+i).find("a").attr("href", fileDeleteHref); 
		} else {
			// 파일이 없으면
		}
	}
}

function attachedfileTempFileDeleteCallBack(obj) {
	if(obj.mode){
		var no = obj.data['no'];
		$("#fileList_"+no).remove();
	}
}