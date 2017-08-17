
function goDataWriteActEvent() {
	var data		= $("#formData").serializeArray();

	$.ajax({
		url			: "./"
	   ,data		: data
	   ,type		: "POST"
	   ,dataType	: "json"
	   ,success		: function(data) {	
							if(data['__STATE__'] == "SUCCESS") {

								alert("등록되었습니다.");

								var data2			= new Array();
								var endMode			= data['END_MODE'];
								var no				= data['NO'];

								if(!endMode) {
									return; 
								}
						
								data2['mode']		= endMode;
								data2['ubNo']		= no;

								goAddLocation(data2);

							} else {
								alert(data);
							}
					   }
	});
}

function goDataCancelMoveEvent() {
	var data		= new Array(5);

	data['mode']	= "";

	goAddLocation(data);
}

function goAttachedFileOpenEvent(no) {

	var url = "./?menuType=community2&mode=attachedWrite&layout=pop&no=" + no;

	TINY.box.show({		 iframe 		: url
						,width			: 600
						,height			: 300
				})
}

function goAttachedWriteCallBackEvent(fileInfo) {
	var name		= fileInfo['name'];
	var dir			= fileInfo['dir'];
	var src			= dir + "/" + name;

	if(!name) {
		TINY.box.hide();
		return;
	}

	$("#demoImage").html("<img src='" + src + "'>");
	TINY.box.hide();
}