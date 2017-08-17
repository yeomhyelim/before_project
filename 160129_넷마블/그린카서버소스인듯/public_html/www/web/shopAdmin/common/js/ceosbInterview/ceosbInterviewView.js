
	function goCeosbInterviewListMoveEvent() {
		data			= new Array();

		data['mode']	= "ceosbInterviewList";
		data['icCode']	= "";

		goAddLocation(data);
	}

	function goCeosbInterviewModifyMoveEvent() {
		data			= new Array();

		data['mode']	= "ceosbInterviewModify";

		goAddLocation(data);
	}

	function goCeosbInterviewDeleteActEvent(strICCode) {

		var data		= new Object();
		var x			= confirm("삭제하시겠습니까?");
		if(!x) { return; }

		
		data['menuType']		= "product";
		data['mode']			= "json";
		data['act']				= "ceosbInterviewDelete";
		data['icCode']			= strICCode;

		$.ajax({
			url			: "./"
		   ,data		: data
		   ,type		: "POST"
		   ,dataType	: "json"
		   ,success		: function(data) {	
								if(data['__STATE__'] == "SUCCESS") {
									alert("삭제되었습니다.");
									goCeosbInterviewListMoveEvent();
								} else {
									if(data['__MSG__']) { alert(data['__MSG__']); }
									else			{ alert(data); }
								}
						   }
		});
		
	}