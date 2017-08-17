

	// 움직이는 배너 수정
	function goLayoutSliderBannerListModifyMoveEvent(intSbNo) {
		
		var data =new Object();
		data['mode'] = 'sliderBannerModify';
		data['sb_no'] = intSbNo;
		C_getAddLocationUrl(data);
	}

	// 움직이는 배너 삭제
	function goLayoutSliderBannerListDeleteMoveEvent(intSbNo) {

		// 한번더 물어보기
		var x = confirm("삭제하시겠습니까?");
		if(!x) { return; }
		

		// 수정할 데이터 가져오기
		var data = new Object();
		data['menuType'] = 'layout_v2.0';
		data['mode'] = 'json';
		data['act'] = 'sliderBannerDelete';
		data['sb_no'] = intSbNo;

		$.ajax({
			url			: './'
		   ,data		: data
		   ,type		: 'POST'
		   ,dataType	: 'json'
		   ,success		: function(data) {	
								if(data['__STATE__'] == 'SUCCESS') {
									
									location.reload();

								} else {
									var strMsg = data['__MSG__'];
									if(!strMsg) { strMsg = data; }
									alert(strMsg);
								}
						   }
		});
	}
