
	function goCeosbInterviewModifyActEvent() {

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
		$("input[name=act]").val("ceosbInterviewModify");

		$('#form').ajaxForm({
			beforeSubmit :	function() {
			},
			success		 :  function(data) {
					data =  $.parseJSON(data);
					if(data['__STATE__'] == "SUCCESS") {

						alert("수정되었습니다.");
						
						goCeosbInterviewViewMoveEvent();

					} else {
						if(data['__MSG__']) { alert(data['__MSG__']); }
						else { alert(data); }
					}
			   }
		}); 

		$('#form').submit();
		return;	
	}

	function goCeosbInterviewViewMoveEvent() {

		var data2			= new Array();

		data2['mode']		= "ceosbInterviewView";

		goAddLocation(data2);
	}