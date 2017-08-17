

function goCommentDataWriteActEvent() {
	var data		= $("#formComment").serializeArray();
	var name		= $("input[name=commentName]").val();
	var email		= $("input[name=commentEmail]").val();
	var password	= $("input[name=commentPassword]").val();
	var text		= $("textarea[name=commentText]").val();

	if(!name) {
		alert("이름을 입력하세요.");
		$("input[name=commentName]").focus();
		return;
	}

	if(!email) {
		alert("이메일을 입력하세요.");
		$("input[name=commentEmail]").focus();
		return;
	}

	if(!password) {
		alert("비밀번호를 입력하세요.");
		$("input[name=commentPassword]").focus();
		return;
	}

	if(!text) {
		alert("내용을 입력하세요.");
		$("textarea[name=commentText]").focus();
		return;
	}

	$.ajax({
		url			: "./"
	   ,data		: data
	   ,type		: "POST"
	   ,dataType	: "json"
	   ,success		: function(data) {	
							if(data['__STATE__'] == "SUCCESS") {

								alert("등록되었습니다.");

							} else {
								alert(data);
							}
					   }
	});

}