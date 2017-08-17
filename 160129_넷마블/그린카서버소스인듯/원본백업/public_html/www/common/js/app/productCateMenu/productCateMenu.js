
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

				if(aryAppEvent[i] == 'C') {

					$(this).find(".productCate"+(i+1)+" li.cate"+(i+1)).each(function(idx) {
						var no = i+1;
//						$(this).click(function() {
//							var toggle = $(this).attr('toggle');
//							alert(toggle);
//							if(!toggle || toggle == 'undefined') {
//								$(this).attr('toggle','open');
//							} else {
//								$(this).attr('toggle','');
//							}
//						});

					});


				} else if(aryAppEvent[i] == 'O') {

					$(this).find(".productCate"+(i+1)+" li.cate"+(i+1)).each(function(idx) {
						var no = i+1;		
						
						$(this).find(".productCate3:gt(0)").css("display","none");

						$(this).hover(
							function() {
							
								$(this).addClass('on');

								var strImg1 = $(this).find("img").attr("src");
								var strImg2 = $(this).find("img").attr("src2");
								$(this).find("img").attr("src", strImg2);
								$(this).find("img").attr("src2", strImg1);
					
								if(no == 2) {
									$(this).closest(".productCate2").find('.productCate3').css("display","none");
								}


								$(this).find(".productCate"+(no+1)).css("display","");
								
							}, 
							function() {
								
								$(this).removeClass('on');

								var strImg1 = $(this).find("img").attr("src");
								var strImg2 = $(this).find("img").attr("src2");
								$(this).find("img").attr("src", strImg2);
								$(this).find("img").attr("src2", strImg1);

								if(no == 2) {
									return;
								}

								
								$(this).find(".productCate"+(no+1)).css("display","none");
							}
						);
					});

				}
			}
		});


	});