
var G_SLIDER_INTERVAL_ID = null;
var G_SLIDER_EVENT_USING = null;

$(document).ready(function() {

	if(typeof objScriptData == "object") {
		for(var strAppID in objScriptData['APP']) {
			G_APP_PARAM[strAppID] = new Object();
			G_APP_PARAM[strAppID] = objScriptData['APP'][strAppID];
		}
	}

	/**
	 * 작성일 : 2014.02.17
	 * 작성자 : kim hee sung
	 * 내  용 : app 시작 실행
	 */
	if(typeof G_APP_PARAM == "object") {
		for(var strAppID in G_APP_PARAM) {
			// 기본 설정
			var strMode				= G_APP_PARAM[strAppID]['MODE'];
			var strSkin				= G_APP_PARAM[strAppID]['SKIN'];	

			// 유효성 체크
			if(!strMode) { continue; }
			if(!strSkin) { continue; }

			// 함수명 만들고 실행
			var	funSnsSkin			= "go" + C_toUpperCaseOnlyFirst(strMode) + C_toUpperCaseOnlyFirst(strSkin) + "ReadyMoveEvent";  
			var isFunction			= jQuery.isFunction(window[funSnsSkin]);
			if(isFunction) { 
				window[funSnsSkin](strAppID); 
			}			
		}
	}

	/**
	 * 작성일 : 2014.06.27
	 * 작성자 : kim hee sung
	 * 내  용 : input 박스에 배경을 넣습니다.
	 */
	if($('[background-title]').length > 0) {
		$('[background-title]').each(function() {
			var strImg = $(this).attr("background-title");
			var strValue = $(this).val();
			if(strValue.length <= 0) { $(this).css('background', 'url(' + strImg + ') 5px center no-repeat'); }
			$(this).keyup(function() {
				var strValue = $(this).val();
				if(strValue.length <= 0) { $(this).css('background', 'url(' + strImg + ') 5px center no-repeat'); }
				else { $(this).css('background', ''); }
			});
		});
	}

	/**
	 * 작성일 : 2014.06.10
	 * 작성자 : kim hee sung
	 * 내  용 : select 박스 자동 선택
	 */
	if($("select[data-select]").length > 0) {
		$("select[data-select]").each(function() {
			var strSelectData	= $(this).attr("data-select");
			$(this).find("option[value="+strSelectData+"]").attr("selected", true);
		});
	}

	/**
	 * 작성일 : 2014.03.24
	 * 작성자 : kim hee sung
	 * 내  용 : 퀵메뉴 
	 * 사용법 : <div quick-menu="demo" top="100" top-first="500" speed="500" style="position:absolute;top:500px;border:1px solid">
	 *	quick-menu="퀵메뉴 아이디"
	 *	top="스크롤 내렸을대 top위치"
	 *	top-first="스크롤 0일때 위치"
	 *	speed="속도"
	 *	style="position은 반드시 absolte 형식이여야 하고, top 은 시작 위치"
	 */
	if($('[quick-menu]').length > 0) {
		
		$(window).scroll(function() {
			$('[quick-menu]').each(function() {

				var intTopPos = $(this).attr("top");
				var intTopPosFirst = $(this).attr("top-first");
				var intSpeed = $(this).attr("speed");

				if(!intTopPos) { intTopPos = "100"; }
				if(!intTopPosFirst) { intTopPosFirst = "100"; }
				if(!intSpeed) { intSpeed = "500"; }
				
				intTopPos = Number(intTopPos);
				intTopPosFirst = Number(intTopPosFirst);
				intSpeed = Number(intSpeed);

				var intQuickTopPos	= ($(document).scrollTop() < intTopPosFirst) ? intTopPosFirst : $(document).scrollTop() + intTopPos;

				$(this).stop().animate({ "top": intQuickTopPos + "px" }, intSpeed );

			});
		});
	}

	/**
	 * 작성일 : 2013.06.10
	 * 작성자 : kim hee sung
	 * 내  용 : 포커스 자동 이동
	 * 사용법 : <input type="text" maxlength="4" autoMove="nextInput"/>
	**/
	$("input[autoMove]").each( function() {
		var cnt = $(this).attr("maxlength");
		var id  = $(this).attr("autoMove");
		if(id && cnt>0){
			$(this).keyup( function() {
				var txt = $(this).val();
				var lng = C_getByteLength(txt);
				if(lng >= cnt) {
					$("#"+id).focus();
				}
			});
		}
	})

	/**
	 * 작성일 : 2013.06.10
	 * 작성자 : kim hee sung
	 * 내  용 : 전체 체크박스 클릭 하면, data_target 에 들어 있는 checkbox 를 모두 선택 혹은 제거
	 * 사용법 : <input type="checkbox" id="chkAll" data_target="wishNo"/>
	**/
	$("input#chkAll").each(function(){
		$(this).click(function() {
			var data_target = $(this).attr("data_target");
			if($(this).attr("checked") == "checked"){
				$("input[id^="+data_target+"]").each(function() {
					$(this).attr("checked",true);
				});
			}else{
				$("input[id^="+data_target+"]").each(function() {
					$(this).attr("checked",false);
				});
			}
		});
	});
	
	$("input#chkAll2").each(function(){
		$(this).click(function() {
			var data_target = $(this).attr("data_target");
			if($(this).attr("checked") == "checked"){
				$("input[id^="+data_target+"]:enabled").each(function() {
					$(this).attr("checked",true);
				});
			}else{
				$("input[id^="+data_target+"]:enabled").each(function() {
					$(this).attr("checked",false);
				});
			}
		});
	});
	

	/**
	 * 작성일 : 2013.06.11
	 * 작성자 : kim hee sung
	 * 내  용 : 마우스 in/out 이미지 벼경
	 * 사용법 : <img src='aa.gif' overImg='ee.gif'/>
	**/
	$("img[overImg]").each(function(){	
		$(this).hover(
			function() {
				var src1 = $(this).attr("src");
				var src2 = $(this).attr("overImg");
				$(this).attr("src", src2);
				$(this).attr("overImg", src1);
			}, 
			function() {
				var src1 = $(this).attr("src");
				var src2 = $(this).attr("overImg");
				$(this).attr("src", src2);
				$(this).attr("overImg", src1);
			}
		);
	});

	/**
	 * 작성일 : 2013.07.19
	 * 작성자 : kim hee sung
	 * 내  용 : 마우스 in 이미지 변경, out 일때, 변경된 이미지 유지
	 * 사용법 : <img src='aa.gif' inImg='ee.gif'/>
	**/
	$("img[inImg]").each(function(){	
		var src1 = $(this).attr("src");
		var src2 = $(this).attr("inImg");
		$(this).attr("srcBak", src1);
		
		$(this).hover(
			function() {
				$("img[inImg]").each(function(){
					var src1 = $(this).attr("srcBak");
					$(this).attr("src", src1);
				});
				var src2 = $(this).attr("inImg");
				$(this).attr("src", src2);
			}, 
			function() {
			}
		);

	});

	/**
	 * 작성일 : 2014.05.08
	 * 작성자 : kim hee sung
	 * 내  용 : 마우스 click 이미지 변경
	 * 사용법 : <img src='aa.gif' clickImg1='ee.gif' clickImg2='ee_on.gif' group='img1'/>
	**/
	$("img[clickImg1]").each(function(){	
		
		var strSrc = $(this).attr("src");
		var strImg2 = $(this).attr("clickImg2");
		if(!strImg2) { $(this).attr("clickImg2", strSrc); }

		$(this).click(function() {
			var img1	= $(this).attr("clickImg1");
			var group	= $(this).attr("group");
			if(group) {
				$('img[clickImg1][group=' + group + ']').each(function() {
					var img2	= $(this).attr("clickImg2");	
					$(this).attr("src", img2);
				});
			}
			$(this).attr("src", img1);
		}).hover(function() {
			var img1	= $(this).attr("clickImg1");
			var group	= $(this).attr("group");
			if(group) {
				$('img[clickImg1][group=' + group + ']').each(function() {
					var img2	= $(this).attr("clickImg2");	
					$(this).attr("src", img2);
				});
			}
			$(this).attr("src", img1);
		}, function() {
			var img1	= $(this).attr("clickImg1");
			var group	= $(this).attr("group");
			if(group) {
				$('img[clickImg1][group=' + group + ']').each(function() {
					var isOpen = $(this).parent().hasClass("open");
					var img1 = $(this).attr("clickImg1");	
					var img2 = $(this).attr("clickImg2");	
					$(this).attr("src", img2);
					if(isOpen) {
						$(this).attr("src", img1);
					}
				});
			}
		});
	});

	/**
	 * 작성일 : 2013.06.25
	 * 작성자 : kim hee sung
	 * 내  용 : 마우스 click 이미지 벼경
	 * 사용법 : <img src='aa.gif' clickImg='ee.gif'/>
	**/
	$("img[clickImg]").each(function(){	
		$(this).click(function() {
			var img1 = $(this).attr("src");
			var img2 = $(this).attr("clickImg");
			$(this).attr("src", img2);
			$(this).attr("clickImg", img1);
		});
	});

	/**
	 * 작성일 : 2013.07.19
	 * 작성자 : kim hee sung
	 * 내  용 : 마우스 in일때, targetImg 이미지 변경
	 * 사용법 : <img src='aa.gif' targetImg=".photoImg">
	**/
	$("img[targetImg]").each(function(){	
		$(this).hover(
			function() {
				var src = $(this).attr("src");
				var target = $(this).attr("targetImg");
				$(target).attr("src", src);
			}, 
			function() {
			}
		);
	});

	/**
	 * 작성일 : 2013.06.13
	 * 작성자 : kim hee sung
	 * 내  용 : 최초 시작시 input tag 에 포커스 자동 이동
	 * 사용법 : <input data-auto-focus/>
	**/
	$("[data-auto-focus]").focus();


	/**
	 * 작성일 : 2013.06.17
	 * 작성자 : kim hee sung
	 * 내  용 : input type=checkbox 에서 체크가 안되어 있을때 값넣는 소스
	 * 사용법 : <input type="checkbox" value="A" noValue="N"/>
	**/
//	$("input[noValue]").each(function(){
//		if($(this).attr("checked") != "checked"){
//			var noValue = $(this).attr("noValue");
//			$(this).attr("checked","true").val(noValue);
//		}
//	});


	/**
	 * 작성일 : 2013.07.02
	 * 작성자 : kim hee sung
	 * 내  용 : 마우스가 들어갔을때 보이고, 나갔을때 숨김 처리 하는 소스
	 * 사용법 : <a data-mouseEnter-show-mouseOver-hidden="sellerInfoArea">판매자정보</a>
	 *			<div id="sellerInfoArea" style="display:none">
	 *			</div>
	**/
	$("[data-mouseEnter-show-mouseOver-hidden]").each(function() {
		$(this).hover(
			function() {
				var targetId = $(this).attr("data-mouseEnter-show-mouseOver-hidden");
				$("#"+targetId).show();		
			}, 
			function() {
				var targetId = $(this).attr("data-mouseEnter-show-mouseOver-hidden");
				$("#"+targetId).hide();
			}
		);
	});

	/**
	 * 작성일 : 2013.10.02
	 * 작성자 : kim hee sung
	 * 내  용 : 마우스가 클릭하면, 해당 id 보이기
	 * 사용법 : <a data-mouseEnter-show="sellerInfoArea">판매자정보</a>
	 *			<div id="sellerInfoArea" style="display:none">
	 *			</div>
	**/
	$("[data-mouseEnter-show]").click(function() {
		
		$(this).parent().find("a").each(function() {
//			$(this).attr("class", "page");
			$(this).removeClass("page");
		});

//		$(this).attr("class", "page_on");
		$(this).addClass("page_on");

		$("[data-mouseEnter-show]").each(function() {
			var name = $(this).attr('data-mouseEnter-show');
			$("#"+name).css({'display':'none'});
		});

		var name = $(this).attr('data-mouseEnter-show');
		$("#"+name).css({'display':''});
	});

	/**
	 * 작성일 : 2014.01.03
	 * 작성자 : kim hee sung
	 * 내  용 : 마우스가 클릭하면, 해당 id 보이기, 단 그룹단위로 실행됨.
	 * 사용법 : <a data-mouseEnter-show2="sellerInfoArea">판매자정보</a>
	 *			<div id="sellerInfoArea" group="myGroup" style="display:none">
	 *			</div>
	**/
	if($("[data-mouseEnter-show2]").length > 0) {
		$("[data-mouseEnter-show2]").click(function() {

			var strID			= $(this).attr("data-mouseEnter-show2");
			var strDisplay		= $("#"+strID).css("display");
			var strGroup		= $("#"+strID).attr("group");
			if(strDisplay != "none") { return; }

			$("[data-mouseEnter-show2]").removeClass("open").removeClass("close").addClass("close");
			$("[group="+strGroup+"]").hide();

			if(strDisplay == "none")	{ $("#"+strID).show(); $(this).removeClass("close").addClass("open");		} 
			else						{ $("#"+strID).hide();		}

		});
	}

	/**
	 * 작성일 : 2014.12.09
	 * 작성자 : kim hee sung
	 * 내  용 : 버튼 클릭을 하면, toggle 기능이 됩니다.
	 * 사용법 : <a eum-toggle="sellerInfoArea">판매자정보</a>
	 *			<div id="sellerInfoArea" style="display:none">
	 *			</div>
	**/
	if($("[eum-toggle]").length > 0) {
		$("[eum-toggle]").click(function() {

			var strID = $(this).attr('eum-toggle');
			var strDisplay = $("#"+strID).css("display");
		
			$(this).removeClass('on');
			if(strDisplay == "none") {
				$(this).addClass('_on');
			}

			$('#' + strID).toggle();

		});
	}


	/**
	 * 작성일 : 2014.03.08
	 * 작성자 : kim hee sung
	 * 내  용 : 마우스가 다른곳에 있으면 auto-hide에 등록된 값만큼 경과후 숨김 처리
	 * 사용법 : <div id="sellerInfoArea" auto-hide="5000">
	 *			</div>
	**/
	if($("[auto-hide]").length > 0) {
		$("[auto-hide]").each(function() {
			$(this).hover(function() {	

				var intAutoID		= $(this).attr("auto-id");
				clearTimeout(intAutoID);

			}, function() {
				myThis				= $(this);

				var intAutoID		= myThis.attr("auto-id");
				clearTimeout(intAutoID);

				intAutoID		= setTimeout(function() {
					myThis.fadeOut(500);
				}, 5000);
				$(this).attr("auto-id", intAutoID);
			})
		});

		
	}

	/**
	 * 작성일 : 2013.07.03
	 * 작성자 : kim hee sung
	 * 내  용 : 모드 값에 따라서 class="selected" 추가
	 * 사용법 : <a href="#" data-menu-selected-id="main">링크</a> 
	**/
	$("[data-menu-selected-id]").each(function() {
		var strMode		= $("input[name=mode]").val();
		var strBtnId	= $(this).attr("data-menu-selected-id");
		if(strMode == strBtnId) {
			$(this).attr("class", "selected");
		}
	});

	/**
	 * 작성일 : 2013.07.11
	 * 작성자 : kim hee sung
	 * 내  용 : 마우스 오버시 겔린터 레이어 뛰움
	 * 사용법 : <input type="text" id="calendarLayer" readOnly>
	**/
	$('input[data-simple-datepicker]').each(function() {
		$(this).simpleDatepicker();
	});

	$('input[data-simple-datepicker-check]').each(function() {
		$(this).simpleDatepicker({ startdatelimit: 'y' , uselng:strSiteJsLng});
	});

	$('input[data-simple-datepicker-check-mobile]').each(function() {
		$(this).simpleDatepicker({startdatelimit: 'y' ,uselng:strSiteJsLng, center:true});	
	});

	/**
	 * 작성일 : 2013.07.03
	 * 작성자 : kim hee sung
	 * 내  용 : 엔터키 누르면 자동으로 함수 실행
	 * 사용법 : 
	**/
	$("[data-enter-event]").each(function() {
		$(this).keypress(function(event, obj) {
			if(event.which == 13) {
				var funcName = $(this).attr("data-enter-event");
				window[funcName]();
				return false;
			}
		});
	});

	/**
	 * 작성일 : 2013.07.19
	 * 작성자 : kim hee sung
	 * 내  용 : 숫자 키만 등록 가능합니다.
	 * 사용법 : 
	**/
	$("[data-only-number-key]").each(function() {
		$(this).numeric();
		$(this).css("ime-mode", "disabled"); 
	});

	$("[input-format=number]").each(function() {
		$(this).keydown(function(evt) {
			var e			= event || evt; // for trans-browser compatibility
			var charCode	= e.which || e.keyCode;
			
			if(charCode == 46) {
				return true;
			}

			if (charCode > 31 && (charCode < 48 || charCode > 57) && (charCode < 96 || charCode > 105) && (charCode < 37 || charCode > 40)) {
				return false;
			}

			return true;
		});		
	});

	/**
	 * 작성일 : 2013.08.05
	 * 작성자 : kim hee sung
	 * 내  용 : 메뉴의 마지막 tag에 endNav class 를 추가 합니다.
	 * 사용법 : <div data-add-class-endNav="mainMenu">
	**/
//	if($("[data-add-class-endNav]").length > 0) {
//		var aryDataList			= new Array(10);
//		$("[data-last-this-add-class]").each(function() {
//			var name			= $(this).attr("data-last-this-add-class");
//			if(!aryDataList[name])		{ aryDataList[name] = 1; }
//			else						{ aryDataList[name] = aryDataList[name] + 1; }
//		});
//		for(var key in aryDataList) {
//			var val = aryDataList[key];
//			$("[data-last-this-add-class="+key+"]").eq(val-1).addClass("endNav");
//		}
//		aryDataList = "";
//	}

	if($("[data-add-class-endNav]").length > 0) {
		var aryDataList			= new Array(10);
		$("[data-add-class-endNav]").each(function() {
			var key				= $(this).attr("data-add-class-endNav");
			$("[data-add-class-endNav="+key+"]:last").addClass("endNav");
		});
	}

	/**
	 * 작성일 : 2013.08.09
	 * 작성자 : kim hee sung
	 * 내  용 : 텝키를 클릭시, 이동되는것이 아니라, 텝 기능으로 처리
	 * 사용법 : <div data-textarea-tab-key-no-move>
	**/
	$("[data-textarea-tab-key-no-move]").each(function() {
		$(document).delegate('[data-textarea-tab-key-no-move]', 'keydown', function(e) {
			var keyCode = e.keyCode || e.which;
			if(keyCode == 9) {
				e.preventDefault();
				var start	= $(this).get(0).selectionStart;
				var end		= $(this).get(0).selectionEnd;

				$(this).val($(this).val().substring(0, start) + "\t" + $(this).val().substring(end));

				$(this).get(0).selectionStart	= start + 1;
				$(this).get(0).selectionEnd		= start + 1;
			}		
		});
	});

	if($("a.bookmark").length > 0){
		$("a.bookmark").click(function(event){
			
			var bookmarkUrl		= this.href;
			var bookmarkTitle	= this.title;
		
//			if($.browser.msie || $.browser.webkit){ 
			if (!!navigator.userAgent.match(/Trident\/7\./)) {
				// For IE11
				window.external.AddFavorite( bookmarkUrl, bookmarkTitle); 

			} else if($.browser.msie){ 
				// For IE Favorite
				window.external.AddFavorite( bookmarkUrl, bookmarkTitle); 
			}
			else if ($.browser.mozilla){ 
				// For Mozilla Firefox Bookmark
				window.sidebar.addPanel(bookmarkTitle, bookmarkUrl,"");
			} 
			else if($.browser.opera ){
				// For Opera Browsers
				$(this).attr("href",bookmarkUrl);
				$(this).attr("title",bookmarkTitle);
				$(this).attr("rel","sidebar");
				$(this).click();
			} 
			else{
				// for other browsers which does not support
//				alert('Please hold CTRL+D and click the link to bookmark it in your browser.');
				alert('즐겨찾기 단축키(CTRL+D)를 눌러서 추가해 주시기 바랍니다.');
			}

			return false;
		});
	}

	/**
	 * 작성일 : 2013.08.16
	 * 작성자 : kim hee sung
	 * 내  용 : 슬라이더(오른족, 왼쪽)
	 * 사용법 : <div class="topBannerWrap" slider="effect1"  style="width:263px;height:85px;border:0px solid #333;">
	 *				<div slider="item-list" style="position:absolute;left:15px;border:0px solid;width:233px;height:85px;overflow:hidden;display:none;">
	 *					 {{__SLIDER_1__}}
	 *				</div>
	 *				<a href="#" class="btnPrev" slider="goLeftItem"><img src="/upload/images/btn_tb_prev.gif"/></a>
	 *				<a href="#" class="btnNext" slider="goRightItem"><img src="/upload/images/btn_tb_next.gif"/></a>
	 *			</div>
	**/
	if($("[slider=effect1]").length > 0) {
		var length				= $("[slider=effect1]").length;
		G_SLIDER_INTERVAL_ID	= new Array(length);
		G_SLIDER_EVENT_USING	= new Array(length);
		
		$("[slider=effect1] > [slider=item-list]").each(function(i) {			
			$(this).find("li").css({"position":"absolute","left":"0px"});
			$(this).children("ul").children("li").css("display","none").eq(0).css("display","");
			$(this).css("display","");
			G_SLIDER_INTERVAL_ID[i] = setInterval(function() { sliderEffect1(i, "goLeft"); }, 5000);
		});

		$("[slider=effect1]").each(function(i) {
			$(this).hover(
			function() {
				clearInterval(G_SLIDER_INTERVAL_ID[i]);
			},
			function() {
				G_SLIDER_INTERVAL_ID[i] = setInterval(function()	{ sliderEffect1(i, "goLeft"); }, 5000);
			});
			$(this).find("[slider=goLeftItem]").click(function()	{ sliderEffect1(i, "goLeft");		});
			$(this).find("[slider=goRightItem]").click(function()	{ sliderEffect1(i, "goRight");		});
		});

		function sliderEffect1(i, way) {
			$("[slider=effect1]").eq(i).find("[slider=item-list]").each(function(){
				if(!G_SLIDER_EVENT_USING[i]) { 
					
					G_SLIDER_EVENT_USING[i]	= true;

					var showNo		= null;
					var width		= $(this).css("width").replace("px","");
						width		= Number(width);	
					var length		= $(this).children("ul").children("li").length;
					var showNext	= null;
					var left		= width;

					if(way == "goRight")	{ left		= -left;	}

					$(this).children("ul").children("li").each(function(no) {
						if($(this).css("display") != "none" && showNo == null)		{ showNo = no;						}
						else														{ $(this).css({"left":left+"px"});	}
					});

					if(!way || way == "goLeft") { showNext		= showNo + 1;	}
					else if(way == "goRight")	{ showNext		= showNo - 1;	}

					if(length <= showNext)		{ showNext = 0;					}
					if(0 > showNext)			{ showNext = length-1;			}
			
					$(this).children("ul").children("li").eq(showNo).stop().animate({ "left" : -left }, 500, "swing", function() { $(this).css("display","none");  });
					$(this).children("ul").children("li").eq(showNext).stop().css("display","").animate({ "left" : "0px"  }, 500, "swing", function() { G_SLIDER_EVENT_USING[i]	= false; } );
				}
			});
		}
	}

	if($("[slider=effect2]").length > 0) {
		var myEffectLength = $("[slider=effect2]").length;

		$("[slider=effect2]").each(function(i) {

			var myCnt		= $(this).attr("cnt");
			var myNo		= 0;
			var myCntPage	= 1;

			$(this).find(".item-list").each(function() {
// 2013.08.28 kim hee sung 하위 노드에 ul, li 가 포함된 개수까지 아려준다. [버그]
//								  $(this).find("ul > li").css("display","none")
//				var myLiLength  = $(this).find("ul > li").length; 
								  $(this).children("ul").children("li").css("display","none")
				var myLiLength  = $(this).children("ul").children("li").length;
				    myCntPage	= Math.ceil(myLiLength / myCnt);

				if(myCnt < myLiLength){
					$(this).children("ul").children("li").each(function(k) {
						var myWidth			= $(this).css("width").replace("px","");
							myWidth			= Number(myWidth);
						var mypaddingRight	= $(this).css("padding-right").replace("px","");
							mypaddingRight	= Number(mypaddingRight);
							
						if(myCnt > k){
							var myLeft		= (myWidth + mypaddingRight) * k;
							$(this).css({'display':'','left':myLeft+"px"});
						}else{
						}
					});
				}
			});

			$(this).find(".item-navi").each(function() {
				$(this).find("a").css("display","");
				var btnPrev			= $(this).find("a.btnPrev");
				var page			= $(this).find("a.page");
				var btnNext			= $(this).find("a.btnNext");
				$(this).find("a").remove();

				$(this).append(btnPrev);

				for(var m=0;m<myCntPage;m++){
					var pageClone = page.clone();
					pageClone.attr("number", m);
					pageClone.html("<span>"+(m+1)+"</span>");
					pageClone.click(function() {
						var number = $(this).attr("number");
						sliderEffect2(i, "goChange", number); 
					});
					$(this).append(pageClone);
				}

				$(this).append(btnNext);

				btnPrev.click(function() { sliderEffect2(i, "goChange", "prev"); });
				btnNext.click(function() { sliderEffect2(i, "goChange", "next"); });

			});


			var myId = setInterval(function()	{ sliderEffect2(i, "goChange", "next"); }, 5000);
			$(this).attr("no", myNo);
			$(this).find(".item-navi > .page_on").attr("class","page");
			$(this).find(".item-navi > .page").eq(0).attr("class","page_on");

			$(this).hover(	function() { clearInterval(myId); },
							function() { myId = setInterval(function() { sliderEffect2(i, "goChange", "next"); }, 5000); }
			);

		});	

		function sliderEffect2(i, action, way) {
			$("[slider=effect2]").eq(i).each(function() {
				var myNo		= Number($(this).attr("no"));
				var myCnt		= Number($(this).attr("cnt"));
				var myNoNext	= way;

				if(way == "next")		{ myNoNext		= myNo + 1;	}
				else if(way == "prev")	{ myNoNext		= myNo - 1;	}

				$(this).find(".item-list").each(function(){
					var myLiLength	= $(this).children("ul").children("li").length;
					var myCntPage	= Math.ceil(myLiLength / myCnt);
					var cnt			= 0;

					if(myNoNext >= myCntPage)	{ myNoNext = 0;				}
					else if(myNoNext < 0)		{ myNoNext = myCntPage-1;	}
				
					if(myCnt < myLiLength){
						$(this).children("ul").children("li").each(function(k) {
							var myWidth			= $(this).css("width").replace("px","");
								myWidth			= Number(myWidth);
							var mypaddingRight	= $(this).css("padding-right").replace("px","");
								mypaddingRight	= Number(mypaddingRight);

							if((myNo*myCnt) <= k && ((myNo*myCnt)+myCnt) > k) {
								$(this).stop().animate({ "opacity" : "0" }, 1, "swing", function() { $(this).css({"display":"none","opacity":"1"}); });
							}
						});

						$(this).children("ul").children("li").each(function(k) {
							var myWidth			= $(this).css("width").replace("px","");
								myWidth			= Number(myWidth);
							var mypaddingRight	= $(this).css("padding-right").replace("px","");
								mypaddingRight	= Number(mypaddingRight);

							if((myNoNext*myCnt) <= k && ((myNoNext*myCnt)+myCnt) > k) {
								var myLeft		= (myWidth + mypaddingRight) * cnt;
								$(this).css({"display":"","left":myLeft+"px","opacity":"0"});
								$(this).stop().animate({ "opacity" : "1" }, 500, "swing");
								cnt++;
							}
						});
					}
				});

				$(this).attr("no", myNoNext);

				$(this).find(".item-navi > .page_on").attr("class","page");
				$(this).find(".item-navi > .page").eq(myNoNext).attr("class","page_on");

				$(this).find(".item-navi2 > .page_on").attr("class","page");
				$(this).find(".item-navi2 > .page").eq(myNoNext).attr("class","page_on");
			});
		}
	}

	$("[onEnterKey]").each(function() {
		$(this).keydown(function(event) {
			if(event.which == 13) {
				var callbackFunc	= $(this).attr("onEnterKey");
				var param1			= $(this).attr("param1");
				
				if(!param1) { param1 = ""; }

				if(param1) {
					window[callbackFunc](param1);
				} else {
					window[callbackFunc]();
				}
			};
		});		
	});

	$(function() {
		if($("[slider=effect10]").length > 0) {
			$("[slider=effect10]").each(function() {
				var objTarget = $(this);
				var intSpeed = Number(objTarget.attr('speed'));
				setInterval(function() { sliderEffect10(objTarget); }, intSpeed);
			});
		}
	});
});

// 2014.03.27 kim hee sung 풀이미지 변경 효과
//		<div class="mainImgWrap" slider="effect10" idx="1" speed="3000">
//			<img src="/upload/images/bg_main01.jpg" class="img1">
//			<img src="/upload/images/bg_main02.jpg" class="img2">
//			<img src="/upload/images/bg_main03.jpg" class="img3">
//		</div>
function sliderEffect10(objTarget) {
	
	// 기본 설정
	var intIdx = Number(objTarget.attr('idx'));
	var intMax = objTarget.find('img').length;
	var intIdxNext = intIdx + 1;

	// 최대 개수보다 큰경우 처음으로.
	if(intIdxNext > intMax) { intIdxNext = 1; }

	// 효과
	objTarget.find("img").eq(intIdx-1).animate({opacity: 0.0}, 1000,function() { 	 
		objTarget.attr("idx", intIdxNext);
		for(var i=intMax, j=intIdxNext; i>=1; i--, j++) {
			// 최대 개수보가 큰경우 처음으로.
			if(j > intMax) { j = 1; }
			// z-index 설정
			objTarget.find("img").eq(i-1).css({'z-index':j});
		}
		objTarget.find("img").css({'opacity':'1.0'});
	});
}


