
	function goAppDataViewMoveEvent(b_code, ub_no) {
		//var url				= "./?menuType=community&mode=dataView&b_code="+b_code+"&ub_no="+ub_no;
		//ubno변수명이 다름 2015.05.15
		var url				= "./?menuType=community&mode=dataView&b_code="+b_code+"&ubNo="+ub_no;
		location.href		= url;
	}