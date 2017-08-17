
	function goOper2PopupWriteMoveEvent() {

		var data			= new Array();

		data['mode']		= "popupWrite";

		C_getAddLocationUrl(data);	
	}

	function goOper2PopupModifyMoveEvent(po_no) {
		var data			= new Array();

		data['mode']		= "popupModify";
		data['po_no']		= po_no;

		C_getAddLocationUrl(data);	
	}

	function goOper2PopupDeleteActEvent(po_no) {
		var x			= confirm("삭제 하시겠습니까?");
		if(!x) { return; }

		var data				= new Object();
		data['menuType']		= "oper2";
		data['mode']			= "json";
		data['act']				= "popupDelete";
		data['po_no']			= po_no;

		$.ajax({
			url			: "./"
		   ,data		: data
		   ,type		: "POST"
		   ,dataType	: "json"
		   ,success		: function(data) {	
								if(data['__STATE__'] == "SUCCESS") {
//									alert("삭제되었습니다.");
									C_getReLoad();
								} else {
									alert(data);
								}
						   }
		});	
	}