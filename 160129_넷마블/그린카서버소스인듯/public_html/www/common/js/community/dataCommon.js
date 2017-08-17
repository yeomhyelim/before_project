/* 이벤트 */
function goLoginPageMoveEvent(op)			{ goLoginPageMove(op);			}		
/* 실행 */

/**
 * goLoginPageMove(op)
 * op - Y : 로그인 팝업창 실행
 * op - N : 로그인 페이지 이동
 **/
function goLoginPageMove(op) {
	if(op == "Y") {
		goLoginLayerpop();		
	} else {
		// 로그인 모드 팝업이 아닌 경우
		alert(LNG_TRANS_CHAR['OS00014']);
//		window.parent.location.href = "./?menuType=member&mode=login";
		
		var data = new Array(5);
		data['menuType']		= "member";
		data['mode']			= "login";
		data['http_referer']	= parent.location.href;
		C_getSelfMove(data);
	}
}