
	function goEmailModifyMoveEvent(id) {
		
		if(!id) { return; }

		goEmailCancelMoveEvent(id);
		
		$("table[id=view_"+id+"]").css("display","none");
		$("table[id=modify_"+id+"]").css("display","");
	}

	function goEmailCancelMoveEvent(id) {

		if(!id) { return; }
		
		$("table[id^=view_]").css("display","");
		$("table[id^=modify_]").css("display","none");
	}

	function goEmailModifyActEvent(id) {

		if(!id) { return; }

		var x					= confirm("수정하시겠습니까?");
		if(!x) { return; }

		var data				= new Object();
		var em_auto				= $("input[name=em_auto_"+id+"]:checked").val();
		var em_sender			= $("input[name=em_sender_"+id+"]").val();
		var em_recipient		= $("input[name=em_recipient_"+id+"]").val();
		var em_title			= $("input[name=em_title_"+id+"]").val();
		var em_text				= $("textarea[name=em_text_"+id+"]").val();

		data['menuType']		= "sendmail";
		data['mode']			= "json";
		data['act']				= "sendmailModify";
		data['em_no']			= id;
		data['em_auto']			= em_auto;
		data['em_sender']		= em_sender;
		data['em_recipient']	= em_recipient;
		data['em_title']		= em_title;
		data['em_text']			= em_text;

		$.ajax({
			url			: "./"
		   ,data		: data
		   ,type		: "POST"
		   ,dataType	: "json"
		   ,success		: function(data) {	
								if(data['__STATE__'] == "SUCCESS") {
									alert("수정되었습니다.");
									goEmailCancelMoveEvent(id);
									$("[id=view_title_"+id+"]").html(em_title);
								} else {
									alert(data);
								}
						   }
		});
	
	}

	function goEmailUseModifyActEvent() {
		

		var data				= new Object();
		var s_email_use			= $("input[name=s_email_use]:checked").val();

		data['menuType']		= "sendmail";
		data['mode']			= "json";
		data['act']				= "sendmailUseModify";
		data['s_email_use']		= s_email_use;

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