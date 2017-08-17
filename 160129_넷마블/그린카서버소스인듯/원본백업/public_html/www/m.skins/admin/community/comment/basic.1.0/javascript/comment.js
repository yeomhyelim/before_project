
/* 이벤트 정의 */
function goCommentPointGiveActEvent()		{ goCommentPointGiveAct("commentPointGive");		}
function goCommentCouponGiveActEvent()		{ goCommentCouponGiveAct("commentCouponGive");		}

function goCommentPointGiveAct(mode) {
	
	if(goCheckBox() <= 0) { alert("회원을 먼저 선택해주세요."); return false; }

	var  x = confirm("선택하신 회원에게 포인트를 발급 하시겠습니까?");
	if (x == true) { 
		goAct(mode);
	}
}

function goCommentCouponGiveAct(mode) {
	if(goCheckBox() <= 0) { alert("회원을 먼저 선택해주세요."); return false; }

	var  x = confirm("선택하신 회원에게 쿠폰을 발급 하시겠습니까?");
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