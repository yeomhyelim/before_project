
$(document).ready(function() {
	$("#bi_attachedfile_use").change(goAttachedFieldShow);
	$("#searchGroup").change(goBoardSearchGroupMove);
});


/* 이벤트 정의 */
function goBoardWriteMove()				{ goMove("boardWrite");					}			// 커뮤니티 추가
function goBoardListMoveEvent()			{ goBoardListMove();					}			// 취소
function goBoardWriteAct()				{ goAct("boardWrite", "write");			}			// 커뮤니티 추가
function goBoardDesignListMove()		{ alert("디자인 선택");					}			// 디자인 선택

function goBoardModifyMoveEvent(b_code)	{ goBoardModifyMove(b_code);			}			// 커뮤니티 설정
function goBoardStopAct(b_code)			{ goBoardStop(b_code, "boardStop");		}			// 커뮤니티 정지
function goBoardStartActEvent(b_code)	{ goBoardStartAct(b_code);				}			// 커뮤니티 사용
function goBoardDeleteActEvent(b_code)	{ goBoardDeleteAct(b_code);				}			// 커뮤니티 삭제


function goBoardListMove() {
	alert("작업중입니다.");
}

function goBoardModifyMove(b_code) {
	$("#mode").val("boardModifyBasic");
	$("#b_code").val(b_code);
	var data = new Array("menuType", "mode", "b_code", "page", "searchGroup", "searchKey", "searchVal");
	goLocation(data);
}

function goBoardSearchGroupMove() {
	var data			= new Array(5);
	data['menuType']	= $("#menuType").val();
	data['mode']		= $("#mode").val();
	data['searchGroup']	= $("#searchGroup").val();

	var href = "./?";
	for (var key in data) {
		if(!data[key]) { continue };
		href = href + key + "=" + data[key] + "&";
	}

	location.href = href;
}

function goBoardDeleteAct(b_code) {
	var  x = confirm("삭제하시겠습니까?");
	if (x == true) { 
		var mode = "boardDrop";
		$("#b_code").val(b_code); 
		goAct(mode); 
	}
}

function goMoveEx(b_code, mode) {
	$("#b_code").val(b_code); 
	goMove(mode);
}

function goBoardStop(b_code, mode) {
	$("#b_code").val(b_code); 
	goAct(mode);
}


function goBoardStartAct(b_code) {
	var  x = confirm("사용중으로 복구하시겠습니까?");
	if (x == true) { 
		var mode = "boardUse";
		$("#b_code").val(b_code); 
		goAct(mode);
	}
}



function goAttachedFieldShow() {
	var intCnt = $(this).val();
	fieldOnOff(intCnt, "attachedfile_name_field");
	fieldOnOff(intCnt, "attachedfile_key_field");
}

/* 함수 */
function fieldOnOff(intCnt, idName) {
	$("tr[id="+idName+"]").each(function(i) {
		if(i<intCnt){
			$(this).css("display","");
		}else{
			$(this).css("display","none");
		}
	});
}

