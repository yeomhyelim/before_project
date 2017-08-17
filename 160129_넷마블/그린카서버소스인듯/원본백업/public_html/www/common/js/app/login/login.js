
//	$(function() {
//
//		$("[id^=LOGIN_]").each(function() {
//			
////			var id = $(this).find("input[name=login_id").val();
//			
////			if(!id) { $(this).find("input[name=login_id").focus(); }
////			else    { $(this).find("input[name=login_pw").focus(); }
//		});
//
//
//	});

	function goLoginActEvent() {
		
		var id		= $("input[name=login_id]").val();
		var pw		= $("input[name=login_pw]").val();
		var saveID	= $("input[name=login_save_id]:checked").val(); if(!saveID) { saveID = ""; }

		if(!id) {
			alert("아이디를 입력하세요.");
			$("input[name=login_id]").focus();
			return;
		}

		if(!pw) {
			alert("비밀번호를 입력하세요.");
			$("input[name=login_pw]").focus();
			return;
		}

		var data			= new Object();
		data['menuType']	= "member";
		data['mode']		= "json";
		data['act']			= "login";
		data['id']			= id;
		data['pw']			= pw;
		data['saveID']		= saveID;

		$.ajax({
			url			: "./"
		   ,data		: data
		   ,type		: "POST"
		   ,dataType	: "json"
		   ,success		: function(data) {	
								if(data['__STATE__'] == "SUCCESS") {
									location.reload();
								} else {
									if(data['__MSG__']) { alert(data['__MSG__']); }
									else				{ alert(data['__MSG__']); }
								}
						   }
		});
	}

	function goLogoutActEvent() {

		var data			= new Object();
		data['menuType']	= "member";
		data['mode']		= "json";
		data['act']			= "logout";

		$.ajax({
			url			: "./"
		   ,data		: data
		   ,type		: "POST"
		   ,dataType	: "json"
		   ,success		: function(data) {	
								if(data['__STATE__'] == "SUCCESS") {
									location.reload();
								} else {
									if(data['__MSG__']) { alert(data['__MSG__']); }
									else				{ alert(data['__MSG__']); }
								}
						   }
		});
	}