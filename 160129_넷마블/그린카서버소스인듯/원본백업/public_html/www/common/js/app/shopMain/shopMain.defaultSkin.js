
	// 뷰페이지 이동
	function goShopMainDefaultSkinMoveEvent(intShNo) {

		// 체크
		if(!intShNo) { return; }

		var data		= new Object();

		data['mode']	= "shopProdList";
		data['sh_no']	= intShNo;

		C_getAddLocationUrl(data);	
	}
