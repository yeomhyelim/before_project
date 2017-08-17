
	// 시작 
	$(document).ready(function(e) {
		$('#menu-left').mmenu({
			isMenu		: false
		});
	});

	// 검색창 or 타이틀창 변경
	function goLayoutDefaultSearchFormShowEvent() {
		$('.titleWrap').toggle();
		$('.searchWrap').toggle();
		$('.searchWrap').find('[name=searchText]').focus();
	}

	// 검색
	function goLayoutDefaultSearchMoveEvent() {
		
		// 기본 설정
		var strSearchText = $('.searchWrap').find('[name=searchText]').val();
		var strUrl = '/?menuType=product&mode=search&searchField=N&searchKey=' + strSearchText;
		
		// 체크
		if(!strSearchText) {
			alert("검색어를 입력하세요.");
			$('.searchWrap').find('[name=searchText]').focus();
			return;
		}

		// 이동
		location.href = strUrl;


	}