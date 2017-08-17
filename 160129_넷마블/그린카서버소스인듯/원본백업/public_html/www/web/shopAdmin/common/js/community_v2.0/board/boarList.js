

	// 기능설정
	function goCommunityBoardListModifyMoveEvent(strBCode) {
	
		var data = new Object();
		data['mode'] = 'boardModifyBasic';
		data['b_code'] = strBCode;
		C_getAddLocationUrl(data);	
	}

	// 운영정지
	function goCommunityBoardListStopActEvent(strBCode) {

		// 다시한번 더 물어고기
		var x = confirm("커뮤니티를 운영정지 하시겠습니까?");
		if(!x) { return; }

		// 수정할 데이터 가져오기
		var data = new Object();
		data['menuType'] = 'community_v2.0';
		data['mode'] = 'json';
		data['act'] = 'boardStop';
		data['b_code'] = strBCode;

		$.ajax({
			url			: './'
		   ,data		: data
		   ,type		: 'POST'
		   ,dataType	: 'json'
		   ,success		: function(data) {	
					if(data['__STATE__'] == 'SUCCESS') {
			
						alert('삭제되었습니다.');
						location.reload();

					} else {
						alert(data);
					}
			   }
		});

	}

	// 페이지 이동
	function goCommunityBoardListMoveEvent(intPage) {

		var data = new Object();
		data['page'] = intPage;
		C_getAddLocationUrl(data);	
	}

	// 커뮤니티 추가
	function goCommunityBoardListWriteMoveEvent() {

		var data = new Object();
		data['mode'] = 'boardWrite';
		C_getAddLocationUrl(data);	
	}

	// 커뮤니티 파일 생성
	function goCommunityBoardListFileActEvent() {


		// 다시한번 더 물어고기
		var x = confirm("커뮤니티 리스트를 파일로 생성 하시겠습니까?");
		if(!x) { return; }

		// 수정할 데이터 가져오기
		var data = new Object();
		data['menuType'] = 'community_v2.0';
		data['mode'] = 'json';
		data['act'] = 'boardFileMake';

		$.ajax({
			url			: './'
		   ,data		: data
		   ,type		: 'POST'
		   ,dataType	: 'json'
		   ,success		: function(data) {	
					if(data['__STATE__'] == 'SUCCESS') {
			
						alert('생성되었습니다.');
						location.reload();

					} else {
						alert(data);
					}
			   }
		});
	}

	// 검색
	function goCommunityBoardListSearchMoveEvent() {

		// 기본서렂ㅇ
		var strSearchGroup = $('[name=searchGroup]').val();
		var strSearchKey = $('[name=searchKey]').val();
		var strSearchVal = $('[name=searchVal]').val();

		// 검색
		var data = new Object();
		data['searchGroup'] = strSearchGroup;
		data['searchKey'] = strSearchKey;
		data['searchVal'] = strSearchVal;
		data['page'] = '';
		C_getAddLocationUrl(data);	
	}