
function goDataWriteMoveEvent() {
	var data		= new Array(5);

	data['mode']	= "write";

	goAddLocation(data);
}

function goDataViewMoveEvent(no) {
	var data		= new Array(5);

	data['ubNo']	= no;
	data['mode']	= "view";

	goAddLocation(data);
}



function goSearchMoveEvent() {
	var data			= new Array();
	var searchField		= $("select[id=searchField] option:selected").val();
	var searchKey		= $("input[id=searchKey]").val();

	data['searchField']	= searchField;
	data['searchKey']	= searchKey;
	data['page']		= "";

	goAddLocation(data);
}