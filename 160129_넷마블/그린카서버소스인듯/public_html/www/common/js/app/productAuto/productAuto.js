
	$(window).scroll(function() {
		$("[id^=PRODUCT_AUTO]").each(function() {
			
			// 기본 설정
			var intScrollTop		= $(window).scrollTop();	
			var intHeight			= $(this).height() - $(window).height();
			var isLock				= $(this).attr("lock");

			// top 초기화
			if(!intScrollTop) { intScrollTop = 0; }

			if (!isLock && intScrollTop >= intHeight) {
				goProductListLoadActEvent($(this));
			}
		});
	});

	function goProductListLoadActEvent(objThis) {

		var data			= new Object();
		data['menuType']	= "product";
		data['mode']		= "json";
		data['act']			= "productListLoad";

		$(objThis).attr("lock", true)
		objThis.find("ul").append("<li class='loading'>잠시만 기다려주세요.</li>");

		$.ajax({
			url			: "./"
		   ,data		: data
		   ,type		: "POST"
		   ,dataType	: "json"
		   ,success		: function(data) {	
			   					
								// 시작
								objThis.find(".loading").remove();

								if(data['__STATE__'] == "SUCCESS") {
									
									goProductDataMake(objThis, data['DATA']);

								} else {
//									alert(data['__MSG__']);
									alert(data);
								}

								// 종료
								$(objThis).attr("lock", "")
						   }
		});
	}

	function goProductDataMake(objThis, objData) {

		for(var key in objData) {
			
			var strImg		= objData[key]['PM_REAL_NAME'];
			strImg			= "<img src='" + strImg + "' style='width:200px;height:300px'>"

			$(objThis).find("ul").append("<li>" + strImg + "</li>");
			
		}

	}