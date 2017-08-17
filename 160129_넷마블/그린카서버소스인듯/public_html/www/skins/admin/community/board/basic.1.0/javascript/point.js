
/* 이벤트 정의 */
function goPointWMultiFormAddEvent()		{ goPointWMultiFormAdd(); }
function goPointWMultiFormDeleteEvent(no)	{ goPointWMultiFormDelete(no); }
function goCouponWMultiFormAddEvent()		{ goCouponWMultiFormAdd(); }
function goCouponWMultiFormDeleteEvent(no)	{ goCouponWMultiFormDelete(no); }
function goCouponWSelectLayerPopEvent(no)	{ goCouponWSelectLayerPop(no); }
function goPointCMultiFormAddEvent()		{ goPointCMultiFormAdd(); }
function goPointCMultiFormDeleteEvent(no)	{ goPointCMultiFormDelete(no); }
function goCouponCMultiFormAddEvent()		{ goCouponCMultiFormAdd(); }
function goCouponCMultiFormDeleteEvent(no)	{ goCouponCMultiFormDelete(no); }
function goCouponCSelectLayerPopEvent(no)	{ goCouponCSelectLayerPop(no); }


function goPointWMultiFormAdd() {
	var no		= $("#point_w_multi").find("li").length;
	var code	= $("#point_w_multi_form").val();
	code		= $(code).attr("id","point_w_multi_"+(no));
	$(code).find("#no").text((no+1)+")");
	$(code).find("a#pointWMultiDelete").attr("href","javascript:goPointWMultiFormDeleteEvent('"+no+"')");
	$("#point_w_multi").append(code);
	$("#bi_point_w_multi_max").val(no+1);
}

function goPointWMultiFormDelete(no) {
	$("#point_w_multi_"+no).remove();
	$("#point_w_multi").find("li").each( function(index) {
		$(this).find("#no").text((index+1)+")");
		$(this).attr("id","point_w_multi_"+(index));
		$(this).find("a#pointWMultiDelete").attr("href","javascript:goPointWMultiFormDeleteEvent('"+index+"')");
	});

	var max		= $("#point_w_multi").find("li").length;
	$("#bi_point_w_multi_max").val(max);
}

function goCouponWMultiFormAdd() {
	var no		= $("#coupon_w_multi").find("li").length;
	var code	= $("#coupon_w_multi_form").val();
	code		= $(code).attr("id","coupon_w_multi_"+(no));
	$(code).find("#no").text((no+1)+")");
	$(code).find("a#couponWMultiSelect").attr("href","javascript:goCouponWSelectLayerPopEvent('"+no+"')");
	$(code).find("a#couponWMultiDelete").attr("href","javascript:goCouponWMultiFormDeleteEvent('"+no+"')");
	$("#coupon_w_multi").append(code);
	$("#bi_coupon_w_multi_max").val(no+1);
}

function goCouponWMultiFormDelete(no) {
	$("#coupon_w_multi_"+no).remove();
	$("#coupon_w_multi").find("li").each( function(index) {
		$(this).find("#no").text((index+1)+")");
		$(this).attr("id","coupon_w_multi_"+(index));
		$(this).find("a#couponWMultiDelete").attr("href","javascript:goCouponWMultiFormDeleteEvent('"+index+"')");
	});

	var max		= $("#coupon_w_multi").find("li").length;
	$("#bi_coupon_w_multi_max").val(max);
}

/*****/

function goPointCMultiFormAdd() {
	var no		= $("#point_c_multi").find("li").length;
	var code	= $("#point_c_multi_form").val();
	code		= $(code).attr("id","point_c_multi_"+(no));
	$(code).find("#no").text((no+1)+")");
	$(code).find("a#pointCMultiDelete").attr("href","javascript:goPointCMultiFormDeleteEvent('"+no+"')");
	$("#point_c_multi").append(code);
	$("#bi_point_c_multi_max").val(no+1);
}

function goPointCMultiFormDelete(no) {

	var gm_no = $("#point_c_multi_"+no).find("input[id=bi_point_c_multi_no]").val();
	var delete_gm_no_list = $("input[name=point_coupon_delete_list]").val();
	if(delete_gm_no_list) { delete_gm_no_list += ","; }
	delete_gm_no_list += gm_no;
	$("input[name=point_coupon_delete_list]").val(delete_gm_no_list);

	$("#point_c_multi_"+no).remove();
	$("#point_c_multi").find("li").each( function(index) {
		$(this).find("#no").text((index+1)+")");
		$(this).attr("id","point_c_multi_"+(index));
		$(this).find("a#pointCMultiDelete").attr("href","javascript:goPointCMultiFormDeleteEvent('"+index+"')");
	});

	var max		= $("#point_c_multi").find("li").length;
	$("#bi_point_c_multi_max").val(max);
}

function goCouponCMultiFormAdd() {
	var no		= $("#coupon_c_multi").find("li").length;
	var code	= $("#coupon_c_multi_form").val();
	code		= $(code).attr("id","coupon_c_multi_"+(no));
	$(code).find("#no").text((no+1)+")");
	$(code).find("a#couponCMultiSelect").attr("href","javascript:goCouponCSelectLayerPopEvent('"+no+"')");
	$(code).find("a#couponCMultiDelete").attr("href","javascript:goCouponCMultiFormDeleteEvent('"+no+"')");
	$("#coupon_c_multi").append(code);
	$("#bi_coupon_c_multi_max").val(no+1);
}

function goCouponCMultiFormDelete(no) {
	var gm_no = $("#coupon_c_multi_"+no).find("input[id=bi_coupon_c_multi_no]").val();
	var delete_gm_no_list = $("input[name=point_coupon_delete_list]").val();
	if(delete_gm_no_list) { delete_gm_no_list += ","; }
	delete_gm_no_list += gm_no;
	$("input[name=point_coupon_delete_list]").val(delete_gm_no_list);

	$("#coupon_c_multi_"+no).remove();
	$("#coupon_c_multi").find("li").each( function(index) {
		$(this).find("#no").text((index+1)+")");
		$(this).attr("id","coupon_c_multi_"+(index));
		$(this).find("a#couponCMultiSelect").attr("href","javascript:goCouponCSelectLayerPopEvent('"+index+"')");
		$(this).find("a#couponCMultiDelete").attr("href","javascript:goCouponCMultiFormDeleteEvent('"+index+"')");
	});

	var max		= $("#coupon_c_multi").find("li").length;
	$("#bi_coupon_c_multi_max").val(max);
}

/*****/

function goCouponCSelectLayerPop(multiNo) {
	if(!multiNo) { multiNo = "" }
	goSmartPop("./?menuType=member&mode=popCouponSearch&where=c&multiNo="+multiNo, 1280, 600);
}

function goCouponWSelectLayerPop(multiNo) {
	if(!multiNo) { multiNo = "" }
	goSmartPop("./?menuType=member&mode=popCouponSearch&where=w&multiNo="+multiNo, 1280, 600);
}

function goCouponCSelectLayerPopCallBack(obj) {
	if(!obj.mode) {
		alert("잠시후에 다시 시도해주세요.");
	} else {
		var where		= obj.data['where'];
		var multiNo		= obj.data['multiNo'];
		if(multiNo){
			$("input[id=bi_coupon_"+where+"_multi_title]").eq(multiNo).val(obj.data['cu_name']);
			$("input[id=bi_coupon_"+where+"_multi_coupon]").eq(multiNo).val(obj.data['cu_no']);
		}else{
			$("#bi_coupon_"+where+"_mark").val(obj.data['cu_name']);
			$("#bi_coupon_"+where+"_coupon").val(obj.data['cu_no']);
		}
	}
}