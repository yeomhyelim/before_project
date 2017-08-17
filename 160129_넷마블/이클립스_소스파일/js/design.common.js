var _curIdx = 0;

$(document).ready(function () {

	$(".layer_area").parents(".body_bg_none").css("overflow-x","hidden");

	/* print */
	var bodyHeight = document.body.clientHeight;
	var $printTop = $(".pop_print_gray");
	var $printTopKo = $(".pop_print_gray_ko");
	var $printBlank = $(".pop_warp_print_blank");
	var mod;
	var nHeight = 971;
	var agent = navigator.userAgent.toLowerCase();

	if (agent.indexOf("chrome") != -1) {
		//alert("크롬 브라우저입니다.");
		nHeight = 958;
		$(".print_style").html("<style type='text/css' media='print'>@page {margin: 12.5mm 12.5mm 12.5mm 12.5mm;}</style>");
	}
	else if (agent.indexOf("firefox") != -1) {
		//alert("파이어폭스 브라우저입니다.");
		nHeight = 971;
		$(".print_style").html("<style type='text/css' media='print'>@page {margin: 12.5mm 12.5mm 12.5mm 12.5mm;}</style>");
	}
	else{
		$(".print_style").html("<style type='text/css' media='print'>@page {margin: 19.05mm;}</style>");
	}

	for(var i = 0; i< $printTop.length;i++){
		if($printTop[i].clientHeight <= nHeight){
			mod = nHeight-$printTop[i].clientHeight;
			$printBlank[i].style.height = mod+"px";
		}
		else{
			mod = $printTop[i].clientHeight%nHeight;
			$printBlank[i].style.height = (nHeight - mod)+"px";
		}
	}

	for(var i = 0; i< $printTopKo.length;i++){
		if($printTopKo[i].clientHeight <= nHeight){
			mod = nHeight-$printTopKo[i].clientHeight;
			$printBlank[i].style.height = mod+"px";
		}
		else{
			mod = $printTopKo[i].clientHeight%nHeight;
			$printBlank[i].style.height = (nHeight - mod)+"px";
		}
	}



	/* 상단메뉴 */
	$(".sub_top_content .tab_cont_btn").not(":first").hide();
	$(".sub_tab_cont").not(":first").hide();


	/* 슬라이드 edit_box */
	$(".cont_slide_box .edit_box").hide();
	$(".cont_slide_box .titlebox > a").click(function(){

		$(this).parent().toggleClass("on").next().slideToggle("fast").siblings(".edit_box").hide();
		$(this).parent().siblings(".cont_slide_box .titlebox ").find("a").removeClass("on");

		return false;

	});

	/* 슬라이드 변수값 이용

	$(".cont_slide_open dd").hide();
	$(".cont_slide_open dt > a").click(function(){
		var $on = $(this).parent().hasClass("on");

		$(".cont_slide_open dd").hide();
		$(".cont_slide_open dt").removeClass("on");
		$(".cont_slide_open dt").find("b").text("CLOSE");

		if(!$on){
			$(this).parent().next().show();
			$(this).parent().addClass("on");
			$(this).find("b").text("OPEN");
		}
		return false;
	});
 */

	/* 테이블 넘버 layer */
	$(".tbl_pos_rel .layer_num_exp").hide();
	$(".sub_top_content .btn_right .btn_order").click(function(){
		$(".tbl_pos_rel .layer_num_exp").toggle();
		return false;
	});


	/* 메인아이템설정 선택 유형 */
	$(".type_big_list li").not(":first").hide();
	$(".type_list li .layer_box").not(":first").hide();


	leftContBlock();

});


/* 즐겨찾기
function titStarLink(){
	if($(".sub_top_content .subtit .ico_star").hasClass("off") == true){
		$(".sub_top_content .subtit .ico_star").addClass("on");	
		$(".sub_top_content .subtit .ico_star").removeClass("off");	
		$(".sub_top_content .subtit .star_layer2").css("display","none");

		$(".sub_top_content .subtit .star_layer1").css("display","block");
		setTimeout(function () {$(".sub_top_content .subtit .star_layer1").hide()}, 1200);
	}else{
		$(".sub_top_content .subtit .ico_star").addClass("off");
		$(".sub_top_content .subtit .ico_star").removeClass("on");	
		$(".sub_top_content .subtit .star_layer1").css("display","none");

		$(".sub_top_content .subtit .star_layer2").css("display","block");
		setTimeout(function () {$(".sub_top_content .subtit .star_layer2").hide()}, 1200);
	}
}
 */


/* 상단메뉴 */
function tabGrayMenu(num){
	var $tabList = $(".tab_graybox .tablist li");

	for(var i=0;i<$tabList.length;i++){
		if(i == num){
			$tabList.eq(i).addClass("on");
			$(".tab_GrayCont"+i).show();
			$(".tab_GrayBtn"+i).show();
			$(".tabRadioCont"+i).show();
		}else{
			$tabList.eq(i).removeClass("on");
			$(".tab_GrayCont"+i).hide();
			$(".tab_GrayBtn"+i).hide();
			$(".tabRadioCont"+i).hide();
		}
	}
}



/* left 메뉴(기본/즐겨찾기/어드민) */
function left_Choice(num){
	var $sideList = $(".side_quick li");
	for(var i=0;i<$sideList.length;i++){
		$("#leftMenu"+i).hide();
		if(i == num){
			$("#leftMenu"+i).show();
			$(".side_quick li").eq(i).addClass("on");
		}else{
			$("#leftMenu"+i).hide();
			$(".side_quick li").eq(i).removeClass("on");
		}
	}
}

function leftContBlock(){
	var $sideList = $(".side_quick li");
	for(var i=1;i<$sideList.length;i++){
		$("#leftMenu"+i).hide();
	}
}



/* html용 그리드 대체 테이블 가로 스크롤 */
function f_scroll(num) {
	var x = $("#list"+num).scrollLeft();
	$("#intitle"+num).css("left",0 - x);
 }


 function f_scroll_others (num,other) {
	var x = $("#list"+num+"_"+other).scrollLeft();
	$("#intitle"+num+"_"+other).css("left",0 - x);
 }


/* 메인아이템설정 선택 유형 */
function mainType( idx ){
	var $typeList = $(".main_item_box .type_list li .layer_box");
	$typeBigList = $(".main_item_box .type_big_list li");
	
	// 기존에 선택된것 감추기
	if( _curIdx > -1 ){
		$( $typeBigList[ _curIdx ] ).hide();
		$( $typeList[ _curIdx ] ).hide();
	}
	// 다음에 선택할 번호 부여
	_curIdx = idx;

	// 다음에 선택할것 보이기
	$( $typeBigList[ _curIdx ] ).show();
	$( $typeList[ _curIdx ] ).show();
}