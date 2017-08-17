
	// 추가필드 수정
	function goCommunityBoardModifyUserfieldModifyActEvent() {

		// 기본설정
		var objTarget =$("#form");
		var strBCode = objTarget.find('[name=b_code]').val();

		// 체크
		if(!strBCode) {
			alert("게시판 코드가 없습니다.");
			return;
		}

		// 이동 경로 설정
		objTarget.find("input[name=mode]").val("json");
		objTarget.find("input[name=act]").val("boardModifyUserfield");
		
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

	// 리스트 페이지로 이동
	function goCommunityBoardModifyUserfieldListMoveEvent() {

		var data = new Object();
		data['mode'] = 'boardList';
		data['b_code'] = '';
		C_getAddLocationUrl(data);
		
	}

	// 필드 종류 변경
	function goCommunityBoardModifyUserfieldFieldKindChangeEvent(intIdx) {

		// 기본 설정
		var objTarget = $('tr[idx=' + intIdx + ']');
		var strKind = objTarget.find('select[id=fieldKindSelect]').val();
		
		// 필드 데이터, 필드 기본값 숨김
		objTarget.find('#fieldKindData').hide();
		objTarget.find('#fieldKindDefault').hide();

		// 선택박스인경우, 필드 데이터, 필드 기본값 보이기
		if(in_array(strKind, ['select','radio'])) {
			objTarget.find('#fieldKindData').show();
			objTarget.find('#fieldKindDefault').show();
		} 

	}