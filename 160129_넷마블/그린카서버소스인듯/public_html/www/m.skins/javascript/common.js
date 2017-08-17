	/**
	 * goJsonLocation(mode, callbackFunc, inputName, data)
	 * json 으로 데이터 호룿 및 페이지 그리기
	 * mode			: mode
	 * callbackFunc	: 콜백
	 **/
	function goJsonLocation(mode, callbackFunc, href) {
		C_getJsonLocation(mode, href, callbackFunc, G_PHP_SELF);
	}

	function goLocation(inputName, data) {
		href			= goMakUrl(inputName, data);
		location.href	= href;
	}
	
	function goMakUrl(inputName, data) {
		var href = goMakJsonUrl(inputName, data);
		return "./?" + href;
	}

	function goMakJsonUrl(inputName, data) {
		var href	= "";
		for (var key in inputName) {
			var input = $("#"+inputName[key]);
			var type  = $(input).attr("type");
			if(type == "hidden" || type == "text" || type == "password"){
				var val = $(input).val();
				if(val) { 
					href = href + inputName[key] + "=" + val + "&";
					continue;
				}
			}else {
				$("select[name="+inputName[key]+"]").each(function() {
					if($(this).val()) {
						href = href + inputName[key] + "=" + $(this).val() + "&";						
					}
				});
			}
		}
		for (var key in data) {
			href = href + key + "=" + data[key] + "&";
		}
		return href;
	}

	function goFileAct(mode, check) {
		// 액셕(파일 포함)
		document.form.enctype	= "multipart/form-data";
		goAct(mode, check)
	}
	
	function goFileJson(mode, callbackFunc) {
		// Json 액션(파일 포함)
		document.form.enctype	= "multipart/form-data";
		C_getFileJson(mode, callbackFunc, G_PHP_SELF);
	}

	function goFileActJson(mode, callbackFunc) {
		// Json 액션(파일 포함) act 페이지
		document.form.enctype	= "multipart/form-data";
		C_getFileActJson(mode, callbackFunc, G_PHP_SELF);
	}
	
	function goMove(mode) {
		// 이동
		C_getMoveUrl(mode,"get", G_PHP_SELF);
	}

	function goPostMove(mode) {
		// 이동
		C_getMoveUrl(mode,"post", G_PHP_SELF);
	}

	/**
	 * goAct(mode, check)
	 * mode		=>  false : 체크 안함, null, 
	 **/
	function goAct(mode, check) {
		// 액션
		if(!goCheckForm(check)) { return; }
		C_getAction(mode, G_PHP_SELF);
	}

	function goJson(mode, callbackFunc, check) {
		// Json 액션
		if(!goCheckForm(check)) { return; }
		C_getJson(mode, callbackFunc, G_PHP_SELF);
	}

	function C_getMoveUrl(mode,method,act){
		var doc				= document.form;
		doc.action			= act;
		doc.mode.value		= mode;
		doc.method			= method;
		doc.submit();
	}

	function C_getAction(mode,act){
		var doc				= document.form;
		doc.action			= act;
		doc.mode.value		= "act";
		doc.act.value		= mode;
		doc.method			="post";
		doc.submit();
	}

	function C_getFileActJson(mode, callbackFunc, act) {
		C_getFileJsonEx(mode, callbackFunc, act, "act");
	}

	function C_getFileJson(mode, callbackFunc, act) {
		C_getFileJsonEx(mode, callbackFunc, act, "json");
	}

	function C_getFileJsonEx(mode, callbackFunc, act, mode2) {

		var doc				= document.form;
		doc.mode.value		= mode2;
		doc.act.value		= mode;

		try {
			/* IE9 사용 안됨. */
			var form		= document.getElementById("form");
			var formData	= new FormData(form);
//			var formData	= $("#form").serialize();

		} catch (e1) {
			/* IE9 사용 처리. */
			$('form').ajaxForm({

				delegation	: true,
				dataType	: 'json',
				success		: function(obj) {
					window[callbackFunc](obj);
				}
			}); 
			$("form").submit();
			return false;
		}

		var myAjax			= newXMLHttpRequest(); 

		if(!myAjax) {alert("사용 오류!! 잠시후에 다시 이용하세요."); return; }

		myAjax.open("post", "./", false);
		myAjax.onreadystatechange = function(){
			if(myAjax.readyState == 4 && myAjax.status == 200) {
				var obj = jQuery.parseJSON(myAjax.responseText);
				window[callbackFunc](obj);
			}
		};

		myAjax.send(formData);
	}


	/**
	 * 해더 부분 때문에 fileupload 가 실행 안됨.
	 * **/
	function C_getJson(mode, callbackFunc, act) {

		var doc				= document.form;
		doc.mode.value		= "json";
		doc.act.value		= mode;

		var formData		= $("form[name=form]").serialize();
		C_getJsonLocation(mode, formData, callbackFunc, act)
	}
		
	/**
	 * formData 외부에서 받기
	 * **/
	function C_getJsonLocation(mode, formData, callbackFunc, act) {

		var myAjax			= newXMLHttpRequest(); 

		if(!myAjax) {alert("사용 오류!! 잠시후에 다시 이용하세요."); return; }

		myAjax.open("post", act, false);
		myAjax.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
		myAjax.setRequestHeader("Content-length", formData.length);
		myAjax.setRequestHeader("Connection", "close");
		myAjax.onreadystatechange = function(){
			if(myAjax.readyState == 4 && myAjax.status == 200) {
				var obj = jQuery.parseJSON(myAjax.responseText);
				window[callbackFunc](obj);
			}			
		};

		myAjax.send(formData);
	}

	/**
	 * newXMLHttpRequest()
	 * XMLHttpRequest 공용함수 
	 **/
	function newXMLHttpRequest(){

		var myAjax = null;

		try {
			myAjax = new XMLHttpRequest();
		} catch (e1) {
			try {
				myAjax = new ActiveXObject("Msxml2.XMLHTTP");
			} catch (e2) {
				try {
					myAjax = new ActiveXObject("Microsoft.XMLHTTP");
				} catch (e3) {
					myAjax = null;
				}
			}
		} 

		return myAjax;
	}

function goCheckForm(check) {

	if(check == "false") { return 1; }
	if(check == null) { check = "Y"; }
	var goStop = "go";

	$("select[check="+check+"]").each(function() {
		if(!$(this).val()) {
			alert($(this).attr("alt") + "을(를) 입력하세요.");
			$(this).focus();
			goStop = "stop";
			return false;
		}
	});

	if(goStop == "stop") { return false; }

	$("input").each(function() {
		if($(this).attr("alt") && $(this).attr("check") == check){
			if($(this).attr("type")=="text" || $(this).attr("type")=="password"){
				if(!$(this).val()){
					alert($(this).attr("alt") + "을(를) 입력하세요.");
					$(this).focus();
					goStop = "stop";
					return false;
				}
			}
		}
	});

	if(goStop == "stop") { return false; }

	$("textarea").each(function() {
		if($(this).attr("alt") && $(this).attr("check") == check){
			if(!$(this).val()){
				alert($(this).attr("alt") + "을(를) 입력하세요.");
				$(this).focus();
				goStop = "stop";
				return false;
			}
		}
	});

 	if(goStop == "stop") { return false; }

	return goStop;

}


/**
 * cateMouseOverOut(obj,img)
 * 마우스 오버/아웃 이미지 변경
 **/
function cateMouseOverOut(obj,img) {
	obj.src = img;
}


/**
 * goSmartPop()
 * 레이어 팝업
 **/
 function goSmartPop(strUrl, width, height) {

	$.smartPop.open({  
				bodyClose	: false, 
				width		: width, 
				height		: height, 
				conOptUse	:'N',	// 배경 투명하게..
				url			: strUrl				});
 }


/**
 * goPopClose()
 * 레이어 팝업 닫기
 **/
 function goPopClose() {
	$.smartPop.close();
 }

/**
 * goCheckBox()
 * 리스트 체크 박스 선택 개수 리턴
 **/
function goCheckBox() {
	var intCnt = 0;
	$("input[id=check]").each(function() {
		if($(this).attr("checked")=="checked") {
			intCnt++;
		}
	});
	return intCnt;
}