
	// 리스트 페이지 이동
	function goCommunityDataViewListMoveEvent() {

		var data = new Object();

		data['mode'] = "dataList";

		C_getAddLocationUrl(data);	
	}

	// 수정
	function goCommunityDataViewModifyMoveEvent() {

		var data = new Object();

		data['mode'] = "dataModify";

		C_getAddLocationUrl(data);	

	}

	// 답변
	function goCommunityDataViewAnswerMoveEvent() {

		var data = new Object();

		data['mode'] = "dataAnswer";

		C_getAddLocationUrl(data);	

	}

	// CRM 페이지 이동
	function goCommunityDataViewCRMMoveEvent(intNo) {
		
		var strUrl = './?menuType=member&mode=popMemberCrmView&tab=memberOrderList&memberNo=' + intNo;
		window.open(strUrl, "CRM", "width=1100px,height=800px,scrollbars=yes");

	}

	// 삭제
	function goCommunityDataViewDeleteActEvent(intNo) {

		// 한번더 물어보기
		var x = confirm("삭제하시겠습니까?");
		if(!x) { return; }

		// 기본설정
		var objTarget = $('.tableFormWrap');
		var intUbNo = objTarget.find('[name=ubNo]').val();
		var strBCode = objTarget.find('[name=b_code]').val();
		
		// 데이터 전달
		var data			= new Object();
		data['menuType']	= "community_v2.0";
		data['mode']		= "json";
		data['act']			= "dataDelete";
		data['b_code']		= strBCode;
		data['ubNo']		= intUbNo;

		$.ajax({
			url			: "./"
		   ,data		: data
		   ,type		: "POST"
		   ,dataType	: "json"
		   ,success		: function(data) {	
								if(data['__STATE__'] == "SUCCESS") {
								
									// 이동
									var data = new Object();
							
									data['mode'] = 'dataList';

									C_getAddLocationUrl(data);

								} else {
									var strMsg = data['__MSG__'];
									if(!strMsg) { strMsg = data; }
									alert(strMsg);
								}
						   }
		});

	}

