
/* 이벤트 정의 */
function goGroupWriteAct()			{	goFileAct("groupWrite");			}		// 커뮤니티 그룹 추가(액션)
function goGroupDeleteAct(no)		{	goGroupDelete("groupDelete", no);	}		// 커뮤니티 그룹 삭제(액션)
function goGroupModifyMove(no)		{	goGroupModify("groupModify", no);	}		// 커뮤니티 그룹 수정(이동)
function goGroupListMove(no)		{	goMove("groupWrite");				}		// 커뮤니티 그룹 취소(이동)
function goGroupModifyAct()			{	goFileAct("groupModify");			}		// 커뮤니티 그룹 수정(액션)

function goGroupDelete(mode, no) {
	var  x = confirm("삭제하시겠습니까?");
	if (x == true) {
		document.form.bg_no.value = no;
		goAct(mode);	
	}
}

function goGroupModify(mode, no) {
	document.form.bg_no.value = no;
	goMove(mode);	
}