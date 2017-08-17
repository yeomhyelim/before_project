    "use strict";
    var iscroll;
    var actArrw = function() {
        $('#scroller-left,#scroller-right').addClass('active');
        0 === iscroll.x ? $("#scroller-left").removeClass("active")
                : iscroll.x === iscroll.maxScrollX &&
                $("#scroller-right").removeClass("active");
    }

    var selectedTopmenu = "top-menu0";

    $(document).ready(function() {
        $('#main-banner').click(function() {
            if(!($(this).attr("href"))){
                coupangApp.go('', 'homeBanner');
            }
        });

        /**
         *	GNB 선택 후 선택한 메뉴가 스크롤이 필요한 경우
         *	TODO: scrolltopage를 이용하게 되면 페이지 로딩 시 강제로 스크롤을 하게 되서 애니메이션 효과 발생
         *	그대로 두느냐? 아예 로딩 시 iscroll객체 생성 시 기본값을 주느냐? 선택...
         **/

        var _menuIndex = $("#scroller li a").index($("." + selectedTopmenu));
        iscroll.goToPage(_menuIndex, 0, 0);
        actArrw();

        /* Flicking */
        if($('#todayshot-section').hasClass('isFlicking')){
            var panelTime;

            $("#todayshotList").touchSlider({
                speed : 400,
                flexible : true,
                rolling : true,
                page : 1,
                initComplete : function (e) {
                    $("#todayshotIndicator").html("");
                    $("#todayshotList ul li").each(function (i, el) {
                        if((i+1) % e._view == 0) {
                            $("#todayshotIndicator").append('<li></li>');
                        }
                    });
                    $('#todayshotList img').load(function(){$(window).trigger('resize')});
                },
                counter : function (e) {
                    $("#todayshotIndicator li").removeClass("on").eq(e.current-1).addClass("on");
                    clearInterval(panelTime);
                    panelTime = setInterval(function(){$("#todayshotList").get(0).animate(-1,true)},3000);
                },
                custom : function (){
                    clearInterval(panelTime);
                },
                onTouchEnd : function() {
//                    todayshotList_show_cnt++;
                }
            });

            panelTime = setInterval(function(){$("#todayshotList").get(0).animate(-1,true)},5000);

            $(window).bind({
                resize : function() {
                    $("#todayshotList").height($("#todayshotList img").height());
                },
                load : function() {
                    $("#todayshotList").height($("#todayshotList img").height());
                }
            });
        };
        /* //Flicking */
    });

    /* v3. script */
    if($('#topMenu').size() > 0 && $('#scroller').size() > 0){
        $('#scroller').width(document.getElementById('scroller').scrollWidth + 52);

        var scrollOption = {
            snap : 'li',
            scrollX : true,
            scrollY : false,
            eventPassthrough : true
        };
        if(navigator.userAgent.match(/iphone/i) ||
                navigator.userAgent.match(/ipad/i)){
            scrollOption.useTransform = false;
        }
        iscroll = new IScroll('#topMenu', scrollOption);
        iscroll.on('scrollEnd', actArrw);
        $('#scroller-left,#scroller-right').click(function() {
            $(this).hasClass("scroller-arr-left") ? iscroll.prev() : iscroll.next();
        });
    }