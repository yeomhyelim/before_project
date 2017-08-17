
/* 이벤트 */
function goDataWriteMoveEvent()					{ goDataWriteMove();				}
function goDataViewMoveEvent(ub_no)				{ goDataViewMove(ub_no);			}	
function goDataViewMoveEvent2(ub_no)			{ goDataViewMove2(ub_no);			}	
function goDataCancelMoveEvent()				{ goDataCancelMove();				}
function goDataViewPassMoveEvent(ub_no)			{ goDataViewPassMove(ub_no);		}
function goDataWriteActEvent()					{ goDataWriteAct();					}
function goDataViewPassCancelMoveEvent()		{ goDataViewPassCancelMove();		}
function goDataViewPassActEvent()				{ goDataViewPassAct();				}
function goDataModifyMoveEvent()				{ goDataModifyMove();				}
function goDataDeleteActEvent(ub_m_no)			{ goDataDeleteAct(ub_m_no);			}
function goDataDeleteAct2Event(ub_m_no, ub_no)	{ goDataDeleteAct2(ub_m_no, ub_no);	}
function goDataModifyMove2Event(ub_no)			{ goDataModifyMove2(ub_no);			}
function goDataModifyCancelMoveEvent()			{ goDataModifyCancelMove();			}
function goDataListMoveEvent()					{ goDataListMove();					}
function goDataModifyActEvent()					{ goDataModifyAct();				}
function goDataAnswerMoveEvent()				{ goDataAnswerMove();				}
function goDataAnswerCancelEvent()				{ goDataModifyCancelMove();			}
function goDataAnswerActEvent()					{ goDataAnswerAct();				}
function goSearchListMoveEvent()				{ goSearchListMove();				}
function goDataPasswordActEvent()				{ goDataPasswordAct();				}
function goDataPasswordCancelMoveEvent()		{ goDataPasswordCancelMove();		}
function goSecretTextMoveEvent()				{ goSecretTextMove();				}
function goSecretTextCancelMoveEvent()			{ goSecretTextCancelMove();			}
function goDataPrveListMoveEvent(ub_no)			{ goDataPrveListMove(ub_no);		}
function goDataNextListMoveEvent(ub_no)			{ goDataNextListMove(ub_no);		}
function goDataDownloadMoveEvent(b_code, no)	{ goDataDownloadMove(b_code, no);	}
function goCategoryMoveEvent(bc_no)				{ goCategoryMove(bc_no);			}
function goDataWriteAuthEvent()					{ goDataWriteAuthMove();			}


/* 실행 */
function goCategoryMove(bc_no) {
	var inputName		= new Array("menuType", "mode", "b_code","bodyClass");
	var data			= new Array(5);
	data['ub_bc_no']	= bc_no;

	goLocation(inputName, data);
}

function goDataDownloadMove(b_code, no) {
	location.href = "./?menuType=etc&mode=download&b_code="+b_code+"&fl_no="+no;
}

function goDataNextListMove(ub_no) {
	goDataViewMove(ub_no);
}

function goDataPrveListMove(ub_no) {
	goDataViewMove(ub_no);
}

function goSecretTextMove() {
	$("div[id=secretTextForm]").remove();
	var code = $("textarea[id=secretTextForm]").val();
		code = $(code);
	$("body").append(code);

	var x = (window.event.clientX + $(window).scrollLeft() + 10) + "px";
	var y = (window.event.clientY + $(window).scrollTop() + 10) + "px";
	$("div[id=secretTextForm]").css({'left':x,'top':y});
	
}

function goSecretTextCancelMove() {
	$("div[id=secretTextForm]").remove();
}

function goDataPasswordAct() {
	var act			= "dataPassword";
	var ub_no		= $("input[name=ub_no]").val();
	var ub_pass		= $("input[name=ub_pass]").val();
	var inputName	= new Array("menuType", "b_code", "myTarget", "ub_p_code","bodyClass");
	var data		= new Array(5);
	data['act']		= act;
	data['mode']	= "json";
	data['ub_no']	= ub_no;
	data['ub_pass']	= ub_pass;
	var href		= goMakJsonUrl(inputName, data);
	var	mode		= $("input[name=password_mode]").val();
	if(mode == "dataModify"){
		goJsonLocation(act, "dataPasswordModifyCallBack", href);
	}else if(mode == "dataDelete") {
		goJsonLocation(act, "dataPasswordDeleteCallBack", href);
	}
}

function goDataPasswordCancelMove() {
	var	mode		= "dataView";
	var ub_no		= $("input[name=ub_no]").val();
	var inputName	= new Array("menuType", "b_code", "page", "myTarget", "ub_p_code","bodyClass");
	var data		= new Array(5);
	data['mode']	= mode;
	data['ub_no']	= ub_no;
	var href		= goMakUrl(inputName, data);
	goLocation(inputName, data);
}

function goSearchListMove() {
	var	mode		= "dataList";
	var ub_no		= $("input[name=ub_no]").val();
	var inputName	= new Array("menuType", "b_code", "page", "myTarget", "searchKey", "searchVal", "ub_p_code","bodyClass");
	var data		= new Array(5);
	data['mode']	= mode;
	data['ub_no']	= ub_no;
	var href		= goMakUrl(inputName, data);
	goLocation(inputName, data);
}

function goDataAnswerAct() {
	var	mode		= "dataAnswer";	
	var check		= "answer";
	goAct(mode, check);	
}

function goDataAnswerMove() {
	var	mode		= "dataAnswer";
	var ub_no		= $("input[name=ub_no]").val();
	var inputName	= new Array("menuType", "b_code", "page", "myTarget", "ub_p_code","bodyClass");
	var data		= new Array(5);
	data['mode']	= mode;
	data['ub_no']	= ub_no;
	var href		= goMakUrl(inputName, data);
	goLocation(inputName, data);
}

function goDataModifyAct() {
	var	mode		= "dataModify";	
	var check		= "modify";
	goAct(mode, check);	
}

function goDataListMove() {
	var	mode		= "dataList";
	var inputName	= new Array("menuType", "b_code", "page", "myTarget", "ub_p_code","bodyClass");
	var data		= new Array(5);
	data['mode']	= mode;
	var href		= goMakUrl(inputName, data);
	goLocation(inputName, data);	
}

function goDataModifyCancelMove() {
	var	mode		= "dataView";
	var ub_no		= $("input[name=ub_no]").val();
	var inputName	= new Array("menuType", "b_code", "myTarget", "ub_p_code","bodyClass");
	var data		= new Array(5);
	data['mode']	= mode;
	data['ub_no']	= ub_no;
	var href		= goMakUrl(inputName, data);
	goLocation(inputName, data);	
}

function goDataModifyMove() {
	var	mode		= "dataModify";
	var ub_no		= $("input[name=ub_no]").val();
	var inputName	= new Array("menuType", "b_code", "myTarget", "ub_p_code","bodyClass");
	var data		= new Array(5);
	data['mode']	= mode;
	data['ub_no']	= ub_no;
	var href		= goMakUrl(inputName, data);
	goLocation(inputName, data);	
}

function goDataModifyMove2(ub_no) {
	var	mode		= "dataModify";
	var inputName	= new Array("menuType", "b_code", "myTarget", "ub_p_code","bodyClass");
	var data		= new Array(5);
	data['mode']	= mode;
	data['ub_no']	= ub_no;
	var href		= goMakUrl(inputName, data);
	goLocation(inputName, data);	
}

function goDataDeleteAct2(ub_m_no, ub_no) {
	$("input[name=ub_no]").val(ub_no);
	goDataDeleteAct(ub_m_no);
}


function goDataDeleteAct(no_m_no) {
	var	mode		= "dataDelete";
	var x			= true;
	if(no_m_no > 0)	{ x = confirm(LNG_TRANS_CHAR['PS00018']);		}		// 삭제하시겠습니까?
	if(x == true)	{ goAct(mode, false);  							}
}

function goDataViewPassAct() {
	var act			= "dataPassword";
	var callBack	= "dataDataViewPassCallBack";
	var ub_no		= $("input[name=pass_ub_no]").val();
	var ub_pass		= $("input[name=pass_ub_pass]").val();
	var inputName	= new Array("menuType", "b_code", "myTarget", "ub_p_code","bodyClass");
	var data		= new Array(5);
	data['act']		= act;
	data['mode']	= "json";
	data['ub_no']	= ub_no;
	data['ub_pass']	= ub_pass;
	var href = goMakJsonUrl(inputName, data);
	goJsonLocation(act, callBack, href);
}

function goDataViewPassCancelMove() {
	$("div[id=passwordForm]").remove();
}

function goDataViewPassMove(ub_no) {

	$("div[id=passwordForm]").remove();
	var code = $("textarea[id=passwordForm]").val();
		code = $(code);
	$("body").append(code);

	/** 2013.04.17 IE에서 오류
	 * var x = (window.event.x + 10) + "px";
	 * var y = (window.event.y + 10) + "px";
     **/

	var x = (window.event.clientX + $(window).scrollLeft() + 10) + "px";
	var y = (window.event.clientY + $(window).scrollTop() + 10) + "px";
	$("input[name=pass_ub_no]").val(ub_no);
	$("div[id=passwordForm]").css({'left':x,'top':y});
}

function goDataViewMove(ub_no) {
	var	mode		= "dataView";
	var inputName	= new Array("menuType", "b_code", "myTarget", "ub_p_code","bodyClass");
	var data		= new Array(5);
	data['mode']	= mode;
	data['ub_no']	= ub_no;
	goLocation(inputName, data);
}

function goDataViewMove2(ub_no) {
	var display = $("#Alist_"+ub_no).css("display");
//	$("tr[id^=Alist_]").css({'display':'none'});

	if(display == "none"){
		$("#Alist_"+ub_no).css({'display':''});
	}else {
		$("#Alist_"+ub_no).css({'display':'none'});
	}
}

function goDataWriteMove() {
	var	mode		= "dataWrite";
	var inputName	= new Array("menuType", "b_code", "myTarget", "ub_p_code","bodyClass");
	var data		= new Array(5);
	data['mode']	= mode;
	goLocation(inputName, data);
}

function goDataWriteAuthMove(){
	alert(LNG_TRANS_CHAR['CW00076']); //상품을 구매하신 회원만 글을 등록하실 수 있습니다.
	return;
}

function goDataWriteAct() {
	var	mode		= "dataWrite";	
	var check		= "write";
	goAct(mode, check);	
}

function goDataCancelMove() {
	var	mode		= "dataList";
	var inputName	= new Array("menuType", "b_code", "myTarget", "ub_p_code","bodyClass");
	var data		= new Array(5);
	data['mode']	= mode;
	goLocation(inputName, data);
}

/* 콜백 */
function dataDataViewPassCallBack(obj) {
	if(obj.mode != 1) {
		alert(LNG_TRANS_CHAR['MS00011']);  // 비밀번호가 일치하지 않습니다.
	}else{
		var mode		= "dataView";
		var ub_no		= $("input[name=pass_ub_no]").val();
		var inputName	= new Array("menuType", "b_code", "myTarget", "ub_p_code","bodyClass");
		var data		= new Array(5);
		data['mode']	= mode;
		data['ub_no']	= ub_no;
		goLocation(inputName, data);		
	}
}

function dataPasswordModifyCallBack(obj) {
	if(obj.mode != 1) {
		alert(LNG_TRANS_CHAR['MS00011']);  //비밀번호가 일치하지 않습니다.
	}else{
		var	mode		= "dataModify";
		var ub_no		= $("input[name=ub_no]").val();
		var inputName	= new Array("menuType", "b_code", "myTarget", "ub_p_code","bodyClass");
		var data		= new Array(5);
		data['mode']	= mode;
		data['ub_no']	= ub_no;
		var href		= goMakUrl(inputName, data);
		goLocation(inputName, data);			
	}
}

function dataPasswordDeleteCallBack(obj) {
	if(obj.mode != 1) {
		alert($LNG_TRANS_CHAR['MS00011']); //비밀번호가 일치하지 않습니다.
	}else{
		var	act			= "dataDelete";
		var inputName	= new Array("menuType", "b_code", "ub_no", "myTarget", "ub_p_code","bodyClass");
		var data		= new Array(5);
		data['act']		= act;
		data['mode']	= "json";
		var href		= goMakJsonUrl(inputName, data);
//		location.href	= "./?" + href;
		goJsonLocation(act, "dataDeleteCallBack", href);
	}
}

function dataDeleteCallBack(obj) {
	if(obj.mode != 1) {
		alert($LNG_TRANS_CHAR['CW00073']); //시스템 장애로 삭제할 수 없습니다.
	}else{
		var	mode		= "dataList";
		var inputName	= new Array("menuType", "b_code", "myTarget", "ub_p_code","bodyClass");
		var data		= new Array(5);
		data['mode']	= mode;
		var href		= goMakUrl(inputName, data);
		goLocation(inputName, data);
	}
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
	$("#fl_file_"+no).find("span").remove();	
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
	if(obj.mode){
		var no = obj.data['no'];
		$("#fileList_"+no).remove();
	}
}