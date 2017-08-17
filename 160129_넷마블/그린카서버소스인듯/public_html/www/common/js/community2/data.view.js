
function goDataListMoveEvent() {
	var data		= new Array(5);

	data['mode']	= "";

	goAddLocation(data);
}

function goDataModifyMoveEvent(no) {
	var type				= $("input[id=type]").val();

	if(type == "nomember") {
		var display			= $("#passwordArea").css("display");
		var pass			= $("#passwordArea [name=pass]").val();
		if(display == "none") {
			$("#passwordArea").css("display","");
			$("#passwordArea [name=pass]").focus();
		} else {
			if(!pass) {
				alert("비밀번호를 입력하세요.");
				$("#passwordArea [name=pass]").focus();
				return;
			} else {
				var data				= new Object();
				var bCode				= $("input[id=bCode]").val();

				data['menuType']		= "community2";
				data['mode']			= "json";
				data['act']				= "memberCheck";
				data['b_code']			= bCode;
				data['no']				= no;
				data['pass']			= pass;

				$.ajax({
					url			: "./"
				   ,data		: data
				   ,type		: "POST"
				   ,dataType	: "json"
				   ,success		: function(data) {	
							if(data['__STATE__'] == "SUCCESS") {
								var data		= new Array(5);
								data['mode']	= "modify";
								goAddLocation(data);
							} else if(data['__STATE__'] == "WRONG_PASS") {
								alert("비밀번호가 틀렸습니다.");
							} else {
								alert(data);
							}
					   }
				});
			}
		}
	} else if(type == "member") {
		alert("권한이 없습니다.");
	} else if(type == "my") {
		var data		= new Array(5);
		data['mode']	= "modify";
		goAddLocation(data);
	}
}

function goDataModifyCancelEvent() {
	$("#passwordArea [name=pass]").val("");
	$("#passwordArea").css("display","none");
}