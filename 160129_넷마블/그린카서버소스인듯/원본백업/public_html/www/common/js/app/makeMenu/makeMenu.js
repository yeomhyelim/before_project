
	$(function() {

		$("[id^=APP_ID_]").each(function() {
			
			var strAppEvent		= $(this).attr("appEvent");

			/** 2013.12.16 kim hee sung IE7 에서 strAppEvent[0] 형식으로 사용 안됨. **/
			var aryAppEvent		= new Array();
			aryAppEvent[0]		= strAppEvent.substring(0,1);
			aryAppEvent[1]		= strAppEvent.substring(1,2);
			aryAppEvent[2]		= strAppEvent.substring(2,3);
			aryAppEvent[3]		= strAppEvent.substring(3,4);

			for(var i=0;i<4;i++) {

				if(aryAppEvent[i] != "O") { continue; }

				$(this).find(".menuCate"+(i+1)+" li.cate"+(i+1)).each(function(idx) {
					var no = i+1;		
					$(this).hover(
						function() {
							var strImg1 = $(this).find("img").attr("src");
							var strImg2 = $(this).find("img").attr("src2");
							$(this).find("img").attr("src", strImg2);
							$(this).find("img").attr("src2", strImg1);

							$(this).find(".menuCate"+(no+1)).css("display","");
						}, 
						function() {
							var strImg1 = $(this).find("img").attr("src");
							var strImg2 = $(this).find("img").attr("src2");
							$(this).find("img").attr("src", strImg2);
							$(this).find("img").attr("src2", strImg1);

							$(this).find(".menuCate"+(no+1)).css("display","none");
						}
					);
				});
			}
		});


	});