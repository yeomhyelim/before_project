

function goOrderMemoModifyActEvent() {

	// 기본 설정
	var ubText			= $("textarea[name=ub_text]").val();
	var data			= $("#form").serializeArray();

	// 기본 설정 체크
	if(!ubText) {
		alert("상담내용을 작성하세요.");
		$("textarea[name=ub_text]").focus();
		return;
	}

	// 데이터 전달
	$.ajax({
		url			: "./"
	   ,data		: data
	   ,type		: "POST"
	   ,dataType	: "json"
	   ,success		: function(data) {	
							if(data['__STATE__'] == "SUCCESS") {
								alert("수정되었습니다.");
								goOrderMemoListMoveEvent();
							} else if(data['__STATE__'] == "FAIL") {
								alert("수정할수 없습니다. 관리자에게 문의하세요.");
							} else {
								alert(data);
							}
					   }
	});	

}

function goOrderMemoListMoveEvent() {

	var data = new Array();

	data['mode']		= "popOrderMemoList";

	goAddLocation(data);

}

