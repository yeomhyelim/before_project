
function goDataCancelMoveEvent() {

	var data		= new Array(5);

	data['mode']	= "view";

	goAddLocation(data);
}

function goDataModifyActEvent() {
	
	var data		= $("#formData").serializeArray();
	var type		= $("input[id=type]").val();
	var pass		= $("input[name=pass]").val();

	if(type == "nomember" && !pass) {
		alert("비밀번호를 입력하세요.");
		$("input[name=pass]").focus();
		return;
	}

	$.ajax({
		url			: "./"
	   ,data		: data
	   ,type		: "POST"
	   ,dataType	: "json"
	   ,success		: function(data) {	
							if(data['__STATE__'] == "SUCCESS") {
								alert("수정되었습니다.");
							} else {
								alert(data);
							}
					   }
	});
}