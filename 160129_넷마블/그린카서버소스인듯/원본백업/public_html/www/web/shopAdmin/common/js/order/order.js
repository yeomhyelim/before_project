
	/* CRM */
	function goMemberCrmView(no, tab)
	{
		var href = "./?menuType=member&mode=popMemberCrmView&tab="+tab+"&memberNo="+no;
		window.open(href, "CRM", "width=1100px,height=800px,scrollbars=yes");
	}

	function goOrderMemoListEvent(no) {
		var href = "./?menuType=order&mode=popOrderMemoList&oNo="+no;
		window.open(href, "메모", "width=800px,height=460px,scrollbars=yes");
	}