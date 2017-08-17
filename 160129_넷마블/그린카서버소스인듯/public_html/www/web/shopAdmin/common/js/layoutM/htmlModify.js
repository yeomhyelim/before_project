

	$(function(){

		// html browser - 파일/폴더 리스트
		goLayoutMHtmlModifyHtmlBrowser();
		
		// 폴더생성, 파일생성, 새이름 저장
		$(".dialog").dialog({autoOpen:false,modal:true,height:400});

	});

	// html browser - 파일리스트
	function goLayoutMHtmlModifyHtmlBrowser() {
		var strLng = $("input[name=lang]").val();
		var script = './?menuType=layoutM&mode=json&act=fileList&folderOnly=N&lang=' + strLng;

		$('.htmlBrowser').fileTree({
			script : script
		},function(myThis, file, act) {
			
			if(act == "folder") { return; }
			else if(act == "fileDelete") {
				var x = confirm("삭제하시겠습니까?");
				if(!x) { return; }
			}

			var url				= './';
			var data			= new Object();	
			data['menuType']	= "layoutM";
			data['mode']		= "json";
			data['act']			= act;
			data['lang']		= strLng;
			data['file']		= file;	
			$.ajax({
				url			: "./"
			   ,data		: data
			   ,type		: "POST"
			   ,dataType	: "json"
			   ,success		: function(data) {	
						if(data['__STATE__'] == "SUCCESS") {
							
							// 파일명 설정
							$("input[id=file]").val(file);

							// 코드 출력
							editor.doc.setValue(data['__DATA__']['html']);
							
							// 백업 리스트 설정
							$("select[id=bakList]").html('<option value="">이전 기록</option>');
							if(data['__DATA__']['bakList']) {
								for(var key in data['__DATA__']['bakList']) {
									var strName = data['__DATA__']['bakList'][key]['name'];
									var strKey = data['__DATA__']['bakList'][key]['key'];
									var strHtml = '<option value="' + strKey + '">' + strName + '</option>'
									$("select[id=bakList]").append(strHtml);
								}
							}

						} else {
							alert(data);
						}
				   }
			});
		});
	}

	// folder browser - 폴더 리스트
	function goLayoutMHtmlModifyFolderBrowser() {
		var strLng = $("input[name=lang]").val();
		var script = './?menuType=layoutM&mode=json&act=fileList&folderOnly=Y&lang=' + strLng;

		$('.folderBrowser').fileTree({
			script : script
		},function(myThis, file, act) {
			$("#dirName").val(file);
		});
	}

	// 폴더 생성
	function goLayoutMHtmlMakeFolderMoveEvent() {
		$(".dialog").dialog("open");

		// folder browser - 폴더 리스트
		goLayoutMHtmlModifyFolderBrowser();
	}

	function goLayoutMHtmlModifyActEvent() {

		var data = new Object();	
		var strLng = $("input[name=lang]").val();
		var strFile = $("input[id=file]").val();
		var strHtml = editor.doc.getValue();
		data['menuType']	= "layoutM";
		data['mode']		= "json";
		data['act']			= "htmlModify";
		data['lang']		= strLng;
		data['file']		= strFile;
		data['html']		= strHtml;	
		$.ajax({
			url			: "./"
		   ,data		: data
		   ,type		: "POST"
		   ,dataType	: "json"
		   ,success		: function(data) {	
					
					if(data['__STATE__'] == "SUCCESS") {
						if(data['__MSG__']) { alert(data['__MSG__']); }
					} else {
						if(data['__MSG__']) { alert(data['__MSG__']); }
						else { alert(data); }
					}
			   }
		});
	}


	function goLayoutMHtmlBakFileReadEvent() {
		var data = new Object();	
		var strLng = $("input[name=lang]").val();
		var strFile = $("input[id=file]").val();
		var strBakFile = $("select[id=bakList]").val();
		var strHtml = editor.doc.getValue();
		data['menuType']	= "layoutM";
		data['mode']		= "json";
		data['act']			= "bakFileRead";
		data['lang']		= strLng;
		data['file']		= strFile;
		data['bakFile']		= strBakFile;
//		data['html']		= strHtml;	
		$.ajax({
			url			: "./"
		   ,data		: data
		   ,type		: "POST"
		   ,dataType	: "json"
		   ,success		: function(data) {	
					
					if(data['__STATE__'] == "SUCCESS") {
						// 코드 출력
						editor.doc.setValue(data['__DATA__']['html']);
					} else {
						if(data['__MSG__']) { alert(data['__MSG__']); }
						else { alert(data); }
					}
			   }
		});
	}







	var editor = CodeMirror.fromTextArea(document.getElementById("code"), {
		name: "htmlmixed",
        scriptTypes: [{matches: /\/x-handlebars-template|\/x-mustache/i, mode: null},
                      {matches: /(text|application)\/(x-)?vb(a|script)/i, mode: "vbscript"}]
		,lineNumbers		: true
		,theme				: "cobalt"
		,extraKeys: {
			"F11": function(cm) { goLayoutMHtmlModifyFullScreenEvent(); },
			"Esc": function(cm) { goLayoutMHtmlModifyFullScreenEvent(); }
		  }
	});

	function goLayoutMHtmlModifyFullScreenEvent() {
		
		var objData = $(".my-fullscreen");
		var strHtml = '<div class="my-fullscreen">' + objData.html() + '</div>';
//
//		$("#topArea").css("display","none");
//		$("#contentArea").css("display","none");
//		$("#footerArea").css("display","none");
//		$("body").append(objData);

		$(".CodeMirror-fullscreen").find(".my-fullscreen").remove();
		editor.setOption("fullScreen", !editor.getOption("fullScreen"));
		$(".CodeMirror-fullscreen").prepend(strHtml);

	}
//		,extraKeys: {
//			"F11": function(cm) {
//			  cm.setOption("fullScreen", !cm.getOption("fullScreen"));
//			},
//			"Esc": function(cm) {
//			  if (cm.getOption("fullScreen")) cm.setOption("fullScreen", false);
//			}
//		  }