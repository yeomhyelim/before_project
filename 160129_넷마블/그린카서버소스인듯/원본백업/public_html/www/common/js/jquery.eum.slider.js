/*
 * jQuery eumshop slider plugin v1.0.0
 * http://www.eumshop.co.kr
 * developer : kim hee sung
 * history : 2013.08.18 - 슬라이더 개발
 * Copyright (c) 2013 eumshop
 *
 */

 (function($){

	$.fn.eumSlider = function(options){

		return $(this).each(function () { run(this, options); });
		
	};

	function run(myThis, options) {

		// 설정
		var checkAddCnt			= 0;
		var options				= $.extend( {}, $.fn.eumSlider.defaults, options );
		options.itemLength		= $(myThis).find(".item-list").children("ul").children("li").length;
		options.itemPage		= Math.ceil(options.itemLength / options.itemCount); 

		// CSS 설정
		$(myThis).css({"border":"1px solid","width":options.containerWidth+"px","height":options.containerHeight+"px"});
		$(myThis).find(".item-list").css({"position":"absolute","overflow":"hidden","width":options.itemAreaWidth+"px","height":options.itemAreaHeight+"px"});
		$(myThis).find(".item-list").children("ul").children("li").css({"position":"absolute","left":"0px","top":"0px","display":"none"});
		$(myThis).find(".item-navi").css({"margin-top":"440px"});

		// 아이템 체크
		if(options.itemCount > options.itemLength)	{ checkAddCnt =  options.itemCount - options.itemLength;						}
		else										{ checkAddCnt = (options.itemPage * options.itemCount) - options.itemLength;	}

		// 아이템 부족 부분 추가
		if(checkAddCnt>0){
			for(var i=0;i<checkAddCnt;i++){
				$(myThis).find(".item-list").children("ul").append($(myThis).find(".item-list").children("ul").children("li").eq(i).clone());
			}
			options.itemLength		= $(myThis).find(".item-list").children("ul").children("li").length;
		}
		
		// 아이템 그리기
		var left = 0;
		for(var i=0;i<options.itemCount;i++){
			left = i * (options.itemWidth + options.itemPaddingLeft + options.itemPaddingRight); 
			top  = 0; 
			$(myThis).find(".item-list").children("ul").children("li").eq(i).css({"left":left+"px","top":top+"px","display":""});
		}

		// 네비게이터 그리기
		var pageClone		= "";
		var btnPrev			= $(myThis).find(".item-navi > a.btnPrev");
		var page			= $(myThis).find(".item-navi > a.page");
		var btnNext			= $(myThis).find(".item-navi > a.btnNext");
		
		// 네비게이터 삭제(삭제후 그리기)
		$(myThis).find(".item-navi > a.btnPrev").remove();
		$(myThis).find(".item-navi > a.page").remove();
		$(myThis).find(".item-navi > a.btnNext").remove();

		// 네비게이터 그리기
		btnPrev.attr("href", "prev");
		$(myThis).find(".item-navi").append(btnPrev);
		for(var i=0;i<options.itemPage;i++){
			pageClone = page.clone();
			pageClone.attr("href", i);
			if(options.startPage == i) { pageClone.removeClass("page").addClass("page_on");  }
			$(myThis).find(".item-navi").append(pageClone);
		}
		btnNext.attr("href", "next");
		$(myThis).find(".item-navi").append(btnNext);

		// 네비게이터 이벤트 추가
		$(myThis).find(".item-navi > a").click(function(){ 
			if(!options.checkUse){
				options.checkUse	= "Y";
				options.nextItem	= $(this).attr("href");
				animate(myThis, options);
			}
			return false;
		});

	}

	function animate(myThis, options){
		if(options.direction == "center"){
			$(myThis).find(".item-list").children("ul").children("li").each(function(itemNo){
				if($(this).css("display") == "none"){
					$(this).css({"display":"none","opacity":"0"});
				}else{
					$(this).stop().animate({ "opacity" : "0" }, 500, "swing", function() { $(this).css({"display":"none"}); });
				}
			});
			$(myThis).find(".item-list").children("ul").children("li").each(function(itemNo){
				if(options.nextItem == itemNo){
					$(this).css({"display":"","opacity":"0"});
					$(this).stop().animate({ "opacity" : "1" }, 500, "swing");
				}else{
				}
			});
		}else if(options.direction == "left" || options.direction == "right" || options.direction == "up" || options.direction == "down"){

			var myItemCount			= 0;
			var myLeftOne			= options.itemWidth + options.itemPaddingLeft + options.itemPaddingRight;
			var myLeft				= 0;
			var myTop				= 0;

			$(myThis).find(".item-list").children("ul").children("li").each(function(itemNo){
				myLeft				= itemNo % options.itemCount;
				if($(this).css("display") == "none"){
					if(options.direction == "left")			{ myLeft =   (myLeftOne * options.itemCount) + (myLeft * myLeftOne);  myTop  = 0;	}
					else if(options.direction == "right")	{ myLeft =  -(myLeftOne + (myLeft * myLeftOne)); myTop  = 0;						}
					$(this).css({"display":"none","left":myLeft,"top":myTop});
				}else{
					if(options.direction == "left")			{ myLeft = -((myLeftOne * options.itemCount) - (myLeft * myLeftOne));  myTop  = 0;	}
					else if(options.direction == "right")	{ myLeft =   (myLeftOne * options.itemCount) + (myLeft * myLeftOne);   myTop  = 0;	}
					$(this).stop().animate({"left":myLeft,"top":-myTop}, 5000, "swing", function() { $(this).css({"display":"none"}); });
				}
			});

			$(myThis).find(".item-list").children("ul").children("li").each(function(itemNo){
				var startItemNo		= options.nextItem * options.itemCount;
				var endItemNo		= ((options.nextItem + 1) * options.itemCount) - 1;
				myLeft				= itemNo % options.itemCount;

				if(startItemNo <= itemNo && endItemNo >= itemNo){
					myLeft =   (myLeftOne * options.itemCount) - (myLeft * myLeftOne);
					alert(myLeft);
					$(this).css({"display":""});
					$(this).stop().animate({"left":myLeft,"top":myTop}, 5000, "swing", function() { options.checkUse = ""; });
				}
			});



//			$(myThis).find(".item-list").children("ul").children("li").each(function(itemNo){
//
//				if($(this).css("display") == "none"){
//					if(options.direction == "left")			{ myLeft =  ((itemNo%options.itemCount)+options.itemCount) * (options.itemWidth + options.itemPaddingLeft + options.itemPaddingRight);   myTop  = 0;	}
//					else if(options.direction == "right")	{ myLeft = -(((itemNo%options.itemCount)+options.itemCount) * (options.itemWidth + options.itemPaddingLeft + options.itemPaddingRight));   myTop  = 0;	}
//					$(this).css({"display":"none","left":myLeft,"top":myTop});
//				}else{
//
//					myLeft = ((options.itemWidth + options.itemPaddingLeft + options.itemPaddingRight)  * options.itemCount);
//					myTop  = ((options.itemHeight + options.itemPaddingTop + options.itemPaddingBottom) * options.itemCount);
//
//					if(options.direction == "left")			{ myLeft =   myLeft - Number($(this).css("left").replace("px",""));   myTop  = 0;	}
//					else if(options.direction == "right")	{ myLeft = -(myLeft + Number($(this).css("left").replace("px","")));  myTop  = 0;	}
//					else if(options.direction == "up")		{ myTop  =    myTop - Number($(this).css("top").replace("px",""));	  myLeft = -(Number($(this).css("left").replace("px","")));	}
//					else if(options.direction == "down")	{ myTop  =  -(myTop - Number($(this).css("top").replace("px","")));	  myLeft = -(Number($(this).css("left").replace("px","")));	}
//				
//					$(this).stop().animate({"left":-myLeft,"top":-myTop}, 500, "swing", function() { $(this).css({"display":"none"}); });
//				}
//			});

//			var myItemCount			= 0;
//			var myLeft				= 0;
//			var myTop				= 0;
//			$(myThis).find(".item-list").children("ul").children("li").each(function(itemNo){
//				var startItemNo		= options.nextItem * options.itemCount;
//				var endItemNo		= ((options.nextItem + 1) * options.itemCount) - 1;
//				if(startItemNo <= itemNo && endItemNo >= itemNo){
//
//					if(options.direction == "left")			{ myLeft =   myItemCount * (options.itemWidth + options.itemPaddingLeft + options.itemPaddingRight);	myTop = 0;	}
//					else if(options.direction == "right")	{ myLeft = -(myItemCount * (options.itemWidth + options.itemPaddingLeft + options.itemPaddingRight));	myTop = 0;	}
//
//
//					$(this).css({"display":""});
//					$(this).stop().animate({"left":myLeft,"top":myTop}, 500, "swing", function() { options.checkUse = ""; });
//
//					myItemCount++;
//				}
//			});			
		}
	}

	function naviDraw(selectNo){

	}

	// 디폴트 옵션
	$.fn.eumSlider.defaults = {
		containerWidth		: 930,			// 슬라이더 콘테이너 가로 사이즈(px)
		containerHeight		: 562,			// 슬라이더 콘테이너 세로 사이즈(px)
		itemCount			: 1,			// 아이템 출력 개수
		itemAreaWidth		: 930,			// 슬라이더 아이템 공간 가로 사이즈(px)
		itemAreaHeight		: 362,			// 슬라이더 아이템 공간 세로 사이즈(px)
		itemWidth			: 301,			// 아이템 가로 사이즈(px)
		itemHeight			: 234,			// 아이템 세로 사이즈(px)
		itemPaddingLeft		: 0,			// 아이템 페딩 사이즈(px) - Left
		itemPaddingRight	: 15,			// 아이템 페딩 사이즈(px) - right
		itemPaddingTop		: 0,			// 아이템 페딩 사이즈(px) - Top
		itemPaddingBottom	: 0,			// 아이템 페딩 사이즈(px) - Bottom	
		direction			: "up",			// 슬라이더 방향(left, right, up, down, center) 
		startPage			: 0				// 시작 페이지 번호(0번 부터)
	};	

 }(jQuery));

