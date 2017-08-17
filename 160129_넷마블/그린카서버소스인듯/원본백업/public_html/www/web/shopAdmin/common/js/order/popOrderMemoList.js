

function goProductViewPageMoveEvent(strPCode) {

	if(!strPCode) {
		alert("1개 이상의 상품이 설정되어 있습니다.");
		return;
	}

	var lng	= strSiteJsLng.toLowerCase();
	var url = "/" + lng + "/?menuType=product&mode=view&act=list&prodCode=" + strPCode;
	window.open(url);
}

function goOrderMemoWriteMoveEvent() {

	var data = new Array();

	data['mode']		= "popOrderMemoWrite";

	goAddLocation(data);
}

function goOrderMemoModifyMoveEvent(no) {

	var data = new Array();

	data['mode']		= "popOrderMemoModify";
	data['ub_no']		= no;

	goAddLocation(data);
}