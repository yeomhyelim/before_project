

	// 정렬 방식 변경
	function goProductListSortChangeMoveEvent(myThis) {

		// 기본 설정
		var strSort = $(myThis).val();

		// 이동
		var data = new Object();
		data['sort'] = strSort;
		C_getAddLocationUrl(data);		
	}

	// 리스트 class 변경
	function goProductListClassChangeMoveEvent(strClass) {
		
		// class 삭제
		$('.prodList').removeClass('prodThumbList');
		$('.prodList').removeClass('prodLineList');
		$('.prodList').addClass(strClass);

		// 쿠키 설정
		C_SetCookie('prodListSkin', strClass);
	}