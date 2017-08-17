

	// 리스트 페이지로 이동
	function goCommunityBoardModifyScriptListMoveEvent() {

		var data = new Object();
		data['mode'] = 'boardList';
		data['b_code'] = '';
		C_getAddLocationUrl(data);
	}

	// 스크립트 데이터 수정
	function goCommunityBoardModifyScriptModifyActEvent() {

		// 기본설정
		var objTarget =$("#form");

		// 이동 경로 설정
		objTarget.find("input[name=mode]").val("json");
		objTarget.find("input[name=act]").val("boardModifyScript");
		
		var data = objTarget.serializeArray();

		// 데이터 전달
		
		$.ajax({
			url			: "./"
		   ,data		: data
		   ,type		: "POST"
		   ,dataType	: "json"
		   ,success		: function(data) {	
								if(data['__STATE__'] == "SUCCESS") {

									alert("수정되었습니다.");
									location.reload();
									
								} else {
									var strMsg = data['__MSG__'];
									if(!strMsg) { strMsg = data; }
									alert(data);
								}
						   }
		});
	}