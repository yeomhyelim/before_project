
/** 이벤트 정의 **/
function goCategoryWriteActEvent()			{ goFileAct("categoryWrite", "write");						}			// 카테고리 등록
function goCategoryModifyMoveEvent(no)		{ goCategoryModifyMove("boardModifyCategory", no);			}			// 카테고리 수정 이동
function goCategoryModifyActEvent()			{ goFileAct("categoryModify", "modify");					}			// 카테고리 수정 액션
function goCategoryDeleteActEvent(no)		{ goCategoryDeleteAct("categoryDelete", no);				}			// 카테고리 삭제
function goCategoryMoveEvent()				{ goCategoryLocation("boardModifyCategory", "OP_WRITE");	}			// 카테고리 수정 취소

/* ** Move ** */

function goCategoryModifyMove(mode, no) {
	$("input[name=bc_no]").val(no);
	goCategoryLocation(mode, "OP_MODIFY");
}


/* ** Act ** */

function goCategoryDeleteAct(mode, no) {
	var  x = confirm("삭제하시겠습니까?");
	if (x == true) { 
		$("input[name=bc_no]").val(no);
		goAct(mode); 
	}
}

function goCategoryModifyAct(mode, no) {
	$("input[name=bc_no]").val(no);
	goAct(mode); 
}

/* ** Json ** */

/* ** location ** */
function goCategoryLocation(mode, op) {
	var b_code		= $("#b_code").val();
	var page		= $("#page").val();
	var bc_no		= $("#bc_no").val();
	var aryHref		= { "OP_MODIFY" : "./?menuType=community&mode="+mode+"&b_code="+b_code+"&bc_no="+bc_no+"&page="+page,
						"OP_WRITE"  : "./?menuType=community&mode="+mode+"&b_code="+b_code+"&page="+page					}

	location.href	= aryHref[op];
}
