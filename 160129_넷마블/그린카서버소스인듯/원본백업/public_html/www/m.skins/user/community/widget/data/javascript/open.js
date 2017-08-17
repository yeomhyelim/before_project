function goWidgetOpenMoveEvent(code, no)	{	goWidgetOpenMove(code, no);				}		// 커뮤니티 글 보기(이동), FAQ 게시판

function goWidgetOpenMove(code, no) {
	$("#data_"+code).find("tr[id^=dataView_]").css({'display':'none'});
	$("#data_"+code).find("tr[id=dataView_"+no+"]").css({'display':''});
}