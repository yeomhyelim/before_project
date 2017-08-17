
var fileInfo		= "";
function goFileChangeEvent() {

	$("#writeForm input[name=act]").val("fileUpload");

	$('#writeForm').ajaxForm({
		beforeSubmit :	function() {
		},
		success		 :  function(data) {
								data =  $.parseJSON(data);
								if(data['__STATE__'] == "SUCCESS") {

									fileInfo		= data['DATA'][0];

									var width		= fileInfo['width'];
									var height		= fileInfo['height'];
									var src			= fileInfo['dir'] + "/" + fileInfo['name'];

									$("#demoImage").html("<img src='" + src + "'>");
									$("input[id=width]").val(width);
									$("input[id=height]").val(height);
								} else {
									alert(data);
								}
						   }
    }); 

	$('#writeForm').submit();
	return;	

}

function goSizeChangeEvent() {

	var width		= $("input[id=width]").val();
	var height		= $("input[id=height]").val();
	var data		= new Object();

	if(!fileInfo) {
		alert("변경할 이미지가 없습니다.");
		return;
	}

	if(!width) {
		alert("가로 사이즈를 설정하세요.");
		$("input[id=width]").focus();
		return;
	}

	if(!height) {
		alert("세로 사이즈를 설정하세요.");
		$("input[id=height]").focus();
		return;
	}

	data['menuType']		= "community2";
	data['mode']			= "json";
	data['act']				= "imageSizeChange";
	data['file']			= fileInfo['name'];
	data['width']			= width;
	data['height']			= height;

	$.ajax({
		url			: "./"
	   ,data		: data
	   ,type		: "POST"
	   ,dataType	: "json"
	   ,success		: function(data) {	
							if(data['__STATE__'] == "SUCCESS") {

								alert("등록되었습니다.");

							} else {
								alert(data);
							}
					   }
	});
}

function goSizeCheckEvent(id) {

	var orgWidth		= fileInfo['width'];
	var orgHeight		= fileInfo['height'];
	var width			= $("input[id=width]").val();
	var height			= $("input[id=height]").val();
	var same			= $("input[id=same]:checked").val();
	var temp			= 0;

	if(same != "Y") { return; }
	if(!orgWidth)	{ return; }
	if(!orgHeight)	{ return; }

	width				= Number(width);
	height				= Number(height);

	if(id == "width") {
		temp			= width * orgHeight;
		temp			= temp / orgWidth;
		temp			= Math.round(temp);
		$("input[id=height]").val(temp);
	} else if(id == "height") {
		temp			= height * orgWidth;
		temp			= temp / orgHeight;
		temp			= Math.round(temp);
		$("input[id=width]").val(temp);
	}

}

function goAttachedCancelEvent() {

	var data				= new Object();
	var name				= fileInfo['name'];

	if(!name) { 
		window.parent.TINY.box.hide();
		return;
	}

	data['menuType']		= "community2";
	data['mode']			= "json";
	data['act']				= "tempImageDelete";
	data['file']			= name;

	$.ajax({
		url			: "./"
	   ,data		: data
	   ,type		: "POST"
	   ,dataType	: "json"
	   ,success		: function(data) {	
							if(data['__STATE__'] == "SUCCESS") {

								window.parent.TINY.box.hide();

							} else {
								alert(data);
							}
					   }
	});

}

function goAttachedUseEvent() {
	window.parent.goAttachedWriteCallBackEvent(fileInfo);
}