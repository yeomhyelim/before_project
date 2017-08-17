
	// CRM View 화면 실행
	function goCommunityDataListCrmViewEvent(intMNo) {

		if(!intMNo) { return; }

		var strHref = "./?menuType=member&mode=popMemberCrmView&tab=memberOrderList&memberNo=" + intMNo;

		window.open(strHref, "CRM", "width=1100px,height=800px,scrollbars=yes");

	}

	// 내용 펼침 보기
	function goCommunityDataListTextToggleEvent(intUbNo) {

		$('[text-idx=' + intUbNo + ']').toggle();
	}

	// 페이지 이동
	function goCommunityDataListMoveEvent(intPage) {

		var data = new Object();

		data['page'] = intPage;

		C_getAddLocationUrl(data);	
	}

	// 뷰페이지 이동
	function goCommunityDataListViewMoveEvent(intUbNo) {

		var data = new Object();

		data['mode'] = "dataView";
		data['ubNo'] = intUbNo;
		data['ub_no'] = intUbNo;

		C_getAddLocationUrl(data);	
	}

	// 글쓰기 페이지 이동
	function goCommunityDataListWriteMoveEvent() {

		var data = new Object();

		data['mode'] = "dataWrite";

		C_getAddLocationUrl(data);	
	}

	// 선택내용삭제 (전체 삭제시 1페이지로 이동. 남덕희
	function goCommunityDataListDeleteActEvent() {

		// 기본설정
		var strBCode = $('[name=b_code]').val();

		// 삭제 리스트 만들기
		var strDeleteList = '';
		var strDeleteListCount = '';
		var strListTotal = $('[id=check]').length;

		$('[id=check]:checked').each(function(index) {
			var strNo = $(this).val();
			if(strDeleteList) { strDeleteList = strDeleteList + ","; }
			strDeleteList = strDeleteList + strNo;
			strDeleteListCount = index+1;
		});

		// 체크
		if(!strDeleteList) { return; }

		// 전달
		var data = new Object();
		data['menuType'] = 'community_v2.0';
		data['mode'] = 'json';
		data['act'] = 'dataDelete';
		data['deleteList'] = strDeleteList;
		data['b_code'] = strBCode;

		$.ajax({
			url			: "./"
		   ,data		: data
		   ,type		: "POST"
		   ,dataType	: "json"
		   ,success		: function(data) {	
				
				if(data['__STATE__'] == "SUCCESS") {
					if(strListTotal == strDeleteListCount )
					{
						var data = new Object();
						data['page'] = '';
						C_getAddLocationUrl(data);
					}else{
						location.reload();
					}

					
				} else {
					var strMsg	= data['__MSG__'];
					if(!strMsg) { strMsg = data; }
					alert(strMsg);
				}

		    }
		});
		

		
	}