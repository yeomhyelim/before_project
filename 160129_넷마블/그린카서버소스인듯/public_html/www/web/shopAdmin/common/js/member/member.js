
function goMemberReportWriteActEvent() {
	
	// 기본 설정
	var data			= new Object();
	var ubBcNo			= $("select[name=category] option:selected").val();
	var ubText			= $("textarea[name=text]").val();
	var memberNo		= $("input[name=memberNo]").val();


	// 기본 설정 체크
	if(!ubText) {
		alert("상담내용을 작성하세요.");
		$("textarea[name=ub_text]").focus();
		return;
	}

	if(!memberNo) {
		alert("회원 정보가 없습니다. 관리자에게 문의하세요.");
		return;
	}

	// 데이터 전달
	data['menuType']		= "member";
	data['mode']			= "json";
	data['act']				= "memberReportWrite";
	data['ub_bc_no']		= ubBcNo;
	data['ub_text']			= ubText;
	data['mNo']				= memberNo;

	$.ajax({
		url			: "./"
	   ,data		: data
	   ,type		: "POST"
	   ,dataType	: "json"
	   ,success		: function(data) {	
							if(data['__STATE__'] == "SUCCESS") {
								alert("등록되었습니다.");
								location.reload();
							} else if(data['__STATE__'] == "FAIL") {
								alert("등록할수 없습니다. 관리자에게 문의하세요.");
							} else {
								alert(data);
							}
					   }
	});

}


