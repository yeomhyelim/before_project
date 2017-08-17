
	// 댓글 등록
	function goDataViewCommentLayoutWriteActEvent() {

		// 기본 설정
		var strCommentText = $("[name=commentText]").val();
		var strB_CODE = $("[name=b_code]").val();
		var intUB_NO = $("[name=ub_no]").val();
		
		// 체크
		if(!strCommentText) {
			alert("댓글을 입력하세요.");
			$("[name=commentText]").focus();
			return;
		}
		if(!strB_CODE) {
			alert("게시판 정보가 없습니다. 관리자에게 문의하세요.");
			return;
		}
		if(!intUB_NO) {
			alert("게시글 정보가 없습니다. 관리자에게 문의하세요.");
			return;
		}

		alert(strCommentText);
	}