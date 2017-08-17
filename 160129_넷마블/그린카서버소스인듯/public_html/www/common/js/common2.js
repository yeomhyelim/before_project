	/**
	 * goAddLocation(data)
	 * 기존 주소의 파라미터 + data
	 * 단, DATA 값이 존제하면 업데이트
	 **/
	function goAddLocation(data) {
		var href   = "";
		var param  = G_PHP_PARAM.split('&');
		for(var par in param){
			var am = param[par].split('=');
			if(am[1] == "") { continue; }	
			for(var val in data){
				if(am[0] == val) { 
					am[1]		= data[val];
					data[val]	= "";
					break;
				}
			}
			if(href) { href = href + "&"; }
			href = href + am[0] + "=" + am[1];
		}
		for(var val in data){
			if(data[val] == "") { continue; }
			if(href) { href = href + "&"; }
			href = href + val + "=" + data[val];
		}
		location.href = "./?" + href;
	}

	function goPageMoveEvent(page) {
	
		var data		= new Array();

		if(!page) { return; }

		data['page']	= page;

		goAddLocation(data);
	}