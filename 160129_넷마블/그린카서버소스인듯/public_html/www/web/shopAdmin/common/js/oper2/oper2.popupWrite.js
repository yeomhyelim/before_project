

	function goOper2PopupWriteActEvent() {
	
		// 기본 설정
		var strTitle		= $("input[name=po_title]").val();
		var intLangCnt		= $("input[name^=po_lang]:checked").length;

		// 기본 설정 체크
		if(!strTitle) {
			alert("제목을 입력하세요.");
			$("input[name=po_title]").focus();
			return;
		}

		if(intLangCnt <= 0) {
			alert("사용언어는 1개 이상 선택해야 합니다.");
			return;
		}

		$('#popupWrite').ajaxForm({
			beforeSubmit :	function() {
			},
			success		 :  function(data) {
									data =  $.parseJSON(data);
									if(data['__STATE__'] == "SUCCESS") {
										alert("등록되었습니다.");
										C_getGoBack();
									} else {
										alert(data);
									}
							   }
		}); 

		$('#popupWrite').submit();
		return;	
	}