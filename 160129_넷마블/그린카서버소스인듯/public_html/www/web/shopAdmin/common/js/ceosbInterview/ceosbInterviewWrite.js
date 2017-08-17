
	function goCeosbInterviewWriteActEvent() {

		// 기본 설정
		var title		= $("input[name=title]").val();

		// 기본 설정 체크
		if(!title) { 
			alert("제목을 입력하세요.");
			$("input[name=title]").focus();
			return;
		}

		// 설정
		$('#form').attr("method", "post");
		$('#form').attr("enctype", "multipart/form-data");
		$("input[name=mode]").val("json");
		$("input[name=act]").val("ceosbInterviewWrite");

		$('#form').ajaxForm({
			beforeSubmit :	function() {
			},
			success		 :  function(data) {
					data =  $.parseJSON(data);
					if(data['__STATE__'] == "SUCCESS") {

						alert("등록되었습니다.");
						
						var data2			= new Array();

						data2['mode']		= "ceosbInterviewList";

						goAddLocation(data2);

					} else {
						alert(data);
					}
			   }
		}); 

		$('#form').submit();
		return;	
	
	}

	function goCeosbInterviewCancelMoveEvent() {
	
		var data = new Array();

		data['mode'] = "ceosbInterviewList";

		goAddLocation(data);
	}