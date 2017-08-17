
/**
 * Jquery 확장
 */
(function ($) {
	
	// Form 객체들의의 엘리먼트 값 가져오기
	$.fn.serializeObject = function()
	{
	    var o = {};
	    var a = this.serializeArray();
	    var inputValue = "";
	    $.each(a, function() {
	    	inputValue = this.value;
	    	//---------- Date형 Input Data unfomat처리 - start ----------
	    	if($('#' + this.name).hasClass('hasDatepicker') == true) {
	    		inputValue = inputValue.replace(/-/g, '');	//하이픈 제거
	    	}else if($('#' + this.name).hasClass('number') == true && $('#' + this.name).attr("mask") ) {
	    		inputValue = inputValue.replace(/,/g, '');	//,  제거
	    	}else{
	    		//html tag 제거
	    		inputValue = strip_tags( inputValue, "");
	    	}
	    	//---------- Date형 Input Data unfomat처리 - end   ----------
	        if (o[this.name] !== undefined) {
	            if (!o[this.name].push) {
	                o[this.name] = [o[this.name]];
	            }
	            o[this.name].push(inputValue || '');
	        } else {
	            o[this.name] = inputValue || '';
	        }
	    });
	    return o;
	};

	 

	///////////////////////////////////////////////////////   jqGrid 확장 - end   //////////////////////////////////////////////////////////////
})(jQuery);



function comma2(str) {
	str = String(str);
	var idx = str.indexOf( "." );
	if( idx == -1 ){
		return comma(str);
	}else{
		var str2 = str.substr( 0, str.indexOf( "." ));
		var str3 = str.substr( str.indexOf( "." ), str2.length);
	    
	    return str2.replace(/(\d)(?=(?:\d{3})+(?!\d))/g, '$1,') + str3 + "";
	}
	
}

//콤마찍기
function comma(str) {
    str = String(str);
    return str.replace(/(\d)(?=(?:\d{3})+(?!\d))/g, '$1,');
}

//콤마풀기
function uncomma(str) {
    str = String(str);
    // return str.replace(/[^\d]+/g, '');
    return str.replace(/,|\s+/g,'');
}


/**
 * 공백 문자를 제거
 */
String.prototype.trim = function()
{
   return this.replace(/^\s+|\s+$/g,"");
} // end of function

/*
 * null을 공백 또는 대체 문자로 리턴함.
 * @param s1 체크할 문자열
 * @param s2 대체할 문자열
 */
function nvl(s1, s2) {
    if(s1 == null || s1 == "" || s1 == "undefined") {
        if(s2 == null) {
            return "";
        } else {
            return s2.trim();
        }
    }
    if( typeof(s1) == "number"){
    	return s1;
    }else{
    	return s1.trim();
    }

}

/*
 * paramData : 조회할 공통 코드 정보
 * checkBoxDiv : 체크 박스가 위치할 DIV ID
 * checkboxNm : 그룹으로 묶을 명칭
 * changeFn : Change 이벤트시 실행할 Function
 */
function fnComCodeCheckBox(paramData, checkBoxDiv, checkboxNm, changeFn){
	if(!paramData) return;
	if(!checkBoxDiv) return;
	if(!checkboxNm) return;

	$.ajax({
		type : "POST",
		url : "/cmmn/selectCodeList.do",
		data : paramData,
		dataType: "json",
		async : false,
		contentType: "application/x-www-form-urlencoded;charset=utf-8",
		error : function(x, e, data) {
			var cd = x.status;
			if(cd == 0){
				cd = 990;
			}
			else if (e == 'parsererror') {
				cd = 991;
			} else if (e == 'timeout') {
				cd = 992;
			} else if(cd !=404 && cd != 500){
				cd = 999;
			}
			var alertMsg = "code:"+x.status+"\n"+"message:"+x.responseText+"\n"+"error:"+data;
			fnErrorMsg(cd, alertMsg, data);
		},
		success : function(data) {
			$('#'+checkBoxDiv).empty();
			for(var i = 0; i< data.list.length;i++){
				/*var radioText = "<input type='radio' id='"+radioNm+"_"+i+"' name='"+radioNm+"' class='input_radio left_zero' value='"+data.list[i].cmmnCd+"' onChange='"+callBackFn+"'/> <label for='"+radioNm+"_"+i+"'>"+data.list[i].cmmnCdNm+"</label>";
				$('#'+radioDiv).append(radioText);
				if(!isNull(callBackFn)){
					$("#" + radioNm+"_"+i).change(changeFn);
				}*/
				var checkbox = document.createElement('input');
				checkbox.type = 'checkbox';
				checkbox.name = checkboxNm;
				checkbox.id = checkboxNm+"_"+i;
				if(i==0){
					checkbox.className = 'input_check left_zero';
				}
				else{
					checkbox.className = 'input_check';
				}
				checkbox.value = data.list[i].cmmnCd;

				var label = document.createElement('label');
				label.htmlFor = checkbox.id;
				label.innerHTML = data.list[i].cmmnCdNm;

				$('#'+checkBoxDiv).append(checkbox);
				$('#'+checkBoxDiv).append(label);
				if($.isFunction(changeFn)){
					//$("#" + radioNm+"_"+i).change(changeFn);
					$("#" + checkboxNm+"_"+i).on("change",changeFn);
				}
			}
		}
	});
}

/*
 * 공통코드 조회(Data)
 * paramData
 * 	ex) var param ={"dvsnCmmnCd" : "MRKT_CD", "txVal" : "EFNT", "txValLikeFlag" : "Y"};
 *  fnComCode( param, callBackMrktCd );
 *  txValLikeFlag: txVal Like검색 여부 : 'Y'
 *  callBackMrktCd: 검색결과 callback 함수
 */
function fnComCode(paramData, callBackFunc ){
	if(!paramData) return;

	$.ajax({
		type : "POST",
		url : "/cmmn/selectCodeList.do",
		data : paramData,
		dataType: "json",
		async : false,
		contentType: "application/x-www-form-urlencoded;charset=utf-8",
		error : function(x, e, data) {
			var cd = x.status;
			if(cd == 0){
				cd = 990;
			}
			else if (e == 'parsererror') {
				cd = 991;
			} else if (e == 'timeout') {
				cd = 992;
			} else if(cd !=404 && cd != 500){
				cd = 999;
			}
			var alertMsg = "code:"+x.status+"\n"+"message:"+x.responseText+"\n"+"error:"+data;
			fnErrorMsg(cd, alertMsg, data);
		},
		success : function(data) {
			//alert( "$.isFunction(callBackMrktCd):" + $.isFunction(callBackFunc));
			if ($.isFunction(callBackFunc)) {
				callBackFunc(data);
			}
		}
	});
}

/*
 * paramData : 조회할 공통 코드 정보
 * radioDiv : 라이오 박스가 위치할 DIV ID
 * radioNm : 그룹으로 묶을 명칭
 * changeFn : Change 이벤트시 실행할 Function
 */
function fnComCodeRadio(paramData, radioDiv, radioNm, changeFn){
	if(!paramData) return;
	if(!radioDiv) return;
	if(!radioNm) return;

	$.ajax({
		type : "POST",
		url : "/cmmn/selectCodeList.do",
		data : paramData,
		dataType: "json",
		async : false,
		contentType: "application/x-www-form-urlencoded;charset=utf-8",
		error : function(x, e, data) {
			var cd = x.status;
			if(cd == 0){
				cd = 990;
			}
			else if (e == 'parsererror') {
				cd = 991;
			} else if (e == 'timeout') {
				cd = 992;
			} else if(cd !=404 && cd != 500){
				cd = 999;
			}
			var alertMsg = "code:"+x.status+"\n"+"message:"+x.responseText+"\n"+"error:"+data;
			fnErrorMsg(cd, alertMsg, data);
		},
		success : function(data) {
			$('#'+radioDiv).empty();
			for(var i = 0; i< data.list.length;i++){
				/*var radioText = "<input type='radio' id='"+radioNm+"_"+i+"' name='"+radioNm+"' class='input_radio left_zero' value='"+data.list[i].cmmnCd+"' onChange='"+callBackFn+"'/> <label for='"+radioNm+"_"+i+"'>"+data.list[i].cmmnCdNm+"</label>";
				$('#'+radioDiv).append(radioText);
				if(!isNull(callBackFn)){
					$("#" + radioNm+"_"+i).change(changeFn);
				}*/
				var radio = document.createElement('input');
				radio.type = 'radio';
				radio.name = radioNm;
				if(i==0){
					radio.className = 'input_radio left_zero';
				}
				else{
					radio.className = 'input_radio';
				}

				radio.id = radioNm+"_"+i;
				radio.value = data.list[i].cmmnCd;

				var label = document.createElement('label');
				label.htmlFor = radio.id;
				label.innerHTML = data.list[i].cmmnCdNm;

				$('#'+radioDiv).append(radio);
				$('#'+radioDiv).append(label);
				if($.isFunction(changeFn)){
					//$("#" + radioNm+"_"+i).change(changeFn);
					$("#" + radioNm+"_"+i).on("change",changeFn);
				}
			}
			$("#" + radioNm+"_0").click();
		}
	});
}

/*
 * paramData
 * var paramRadio ={"dvsnCmmnCd" : "SALE_MBLE_DVSN_CD", "txVal" : "UPLOAD"};
	fnComCodeRadio(paramRadio, 'saleMbleDvsnCd' ,fnSaleMbleDvsnCallBack);
 * comboId : select BOX ID
 * disAllYn : 전체 노출 여부
 * disStr : 1: 전체, 2: 선택
 * disType : 콤보 노출 타입(nm : 명(기본 - 생략가능), cd:코드)
 * txval: 조건
 */
function fnComCodeComboParam(paramData, comboId, disAllYn, disStr){
	if(!comboId) return;
	if(!disAllYn) disAllYn = false;
	var strCombo = "";
	if(!disStr) strCombo = '전체';
	else if (disStr == "2"){
		strCombo = '선택';
	}else{
		strCombo = '전체';
	}

	if(nvl( disStr, "") != ""){
		strCombo = disStr;
	}

	$.ajax({
		type : "POST",
		url : "/cmmn/selectCodeList.do",
		data : paramData,
		async : false,
		dataType: "json",
		contentType: "application/x-www-form-urlencoded;charset=utf-8",
		error : function(x, e, data) {
			var cd = x.status;
			if(cd == 0){
				cd = 990;
			}
			else if (e == 'parsererror') {
				cd = 991;
			} else if (e == 'timeout') {
				cd = 992;
			} else if(cd !=404 && cd != 500){
				cd = 999;
			}
			var alertMsg = "code:"+x.status+"\n"+"message:"+x.responseText+"\n"+"error:"+data;
			fnErrorMsg(cd, alertMsg, data);
		},
		success : function(data) {
			if(disAllYn){
				$("#"+comboId).append("<option value=''>" + strCombo + "</option>");
			}
			for(var i = 0; i< data.list.length;i++){
				$("#"+comboId).append("<option value='"+data.list[i].cmmnCd +"'>"+data.list[i].cmmnCdNm +"</option>");
			}
		}
	});
}

/*
 *  콤보 생성
 */

function fnMakeCombo(comboId, url,  paramData, disStr){
	$.ajax({
		type : "POST",
		url : url,
		data : paramData,
		async : false,
		dataType: "json",
		contentType: "application/x-www-form-urlencoded;charset=utf-8",
		error : function(x, e, data) {
			var cd = x.status;
			if(cd == 0){
				cd = 990;
			}
			else if (e == 'parsererror') {
				cd = 991;
			} else if (e == 'timeout') {
				cd = 992;
			} else if(cd !=404 && cd != 500){
				cd = 999;
			}
			var alertMsg = "code:"+x.status+"\n"+"message:"+x.responseText+"\n"+"error:"+data;
			fnErrorMsg(cd, alertMsg, data);
		},
		success : function(data) {
			
			if(!isNull(disStr)){
				$("#"+comboId).append("<option value=''>" + disStr + "</option>");
			}
			for(var i = 0; i< data.list.length;i++){
				$("#"+comboId).append("<option value='"+data.list[i].cd +"'>"+data.list[i].nm +"</option>");
			}
			
		}
	});
}
/*
 * dvsnCmmnCd : 공통코드
 * comboId : select BOX ID
 * disAllYn : 전체 노출 여부
 * disStr : 1: 전체, 2: 선택
 * disType : 콤보 노출 타입(nm : 명(기본 - 생략가능), cd:코드)
 */
function fnComCodeCombo(dvsnCmmnCd, comboId, disAllYn, disStr, disType, schParam){
	if(!dvsnCmmnCd) return;
	if(!comboId) return;
	if(!disAllYn) disAllYn = false;
	var strCombo = "";
	if(!disStr) strCombo = '전체';
	else if (disStr == "2"){
		strCombo = '선택';
	}else{
		strCombo = '전체';
	}

	var jsonData = {};
	jsonData["dvsnCmmnCd"] = dvsnCmmnCd;

	if(!isNull(disType)){
		jsonData["disType"] = disType;
	}
	if(!isNull(schParam)){
		jsonData["schParam"] = schParam;
	}

	if(!disStr) strCombo = '전체';

	$.ajax({
		type : "POST",
		url : "/cmmn/selectCodeList.do",
		data : jsonData,
		async : false,
		dataType: "json",
		contentType: "application/x-www-form-urlencoded;charset=utf-8",
		error : function(x, e, data) {
			var cd = x.status;
			if(cd == 0){
				cd = 990;
			}
			else if (e == 'parsererror') {
				cd = 991;
			} else if (e == 'timeout') {
				cd = 992;
			} else if(cd !=404 && cd != 500){
				cd = 999;
			}
			var alertMsg = "code:"+x.status+"\n"+"message:"+x.responseText+"\n"+"error:"+data;
			fnErrorMsg(cd, alertMsg, data);
		},
		success : function(data) {
			if(disAllYn){
				$("#"+comboId).append("<option value=''>" + strCombo + "</option>");
			}
			for(var i = 0; i< data.list.length;i++){
				$("#"+comboId).append("<option value='"+data.list[i].cmmnCd +"'>"+data.list[i].cmmnCdNm +"</option>");
			}

		}
	});
}

/*
* 공통코드 호출(disStr1의 값을 제거하고 필요값만 추출)
disStr1 : 제외값(ex:"10,20,30")
*/
function fnComCodeComboSp(dvsnCmmnCd, comboId, disAllYn, disStr, disStr1, disType){
	if(!dvsnCmmnCd) return;
	if(!comboId) return;
	if(!disAllYn) disAllYn = false;
	var strCombo = "";
	if(!disStr) strCombo = '전체';
	else if (disStr == "2"){
		strCombo = '선택';
	}else{
		strCombo = '전체';
	}

	var jsonData = {};
	jsonData["dvsnCmmnCd"] = dvsnCmmnCd;

	if(!isNull(disType)){
		jsonData["disType"] = disType;
	}

	$.ajax({
		type : "POST",
		url : "/cmmn/selectCodeList.do",
		data : jsonData,
		dataType: "json",
		async : false,
		contentType: "application/x-www-form-urlencoded;charset=utf-8",
		error : function(x, e, data) {
			var cd = x.status;
			if(cd == 0){
				cd = 990;
			}
			else if (e == 'parsererror') {
				cd = 991;
			} else if (e == 'timeout') {
				cd = 992;
			} else if(cd !=404 && cd != 500){
				cd = 999;
			}
			var alertMsg = "code:"+x.status+"\n"+"message:"+x.responseText+"\n"+"error:"+data;
			fnErrorMsg(cd, alertMsg, data);
		},
		success : function(data) {
			if(disAllYn){
				$("#"+comboId).append("<option value=''>" + strCombo + "</option>");
			}
			// 필요값만 추출
			var strSplit = disStr1.split(",");
			var chk = 0;
			for(var i = 0; i< data.list.length;i++){
				for(var k in strSplit){
					// 제거할 데이터 확인
					if(strSplit[k] == data.list[i].cmmnCd){
						chk += 1;
					}
				}
				// 데이터 셋팅
				if(chk == 0){
					$("#"+comboId).append("<option value='"+data.list[i].cmmnCd +"'>"+data.list[i].cmmnCdNm +"</option>");
				}
				chk = 0;
			}
		}
	});
}

/* 공통코드 콤보 change이벤트
 * 마스터 콤보값에 따라서 디테일 콤보값 변경
 * disStr1 : 공통코드 문자값과의 비교값
 */
function fnComCodeComboCh(dvsnCmmnCd, comboId, disAllYn, disStr, disStr1, disType){
	if(!dvsnCmmnCd) return;
	if(!comboId) return;
	if(!disAllYn) disAllYn = false;
	var strCombo = "";
	if(!disStr) strCombo = '전체';
	else if (disStr == "2"){
		strCombo = '선택';
	}else{
		strCombo = '전체';
	}

	var jsonData = {};
	jsonData["dvsnCmmnCd"] = dvsnCmmnCd;

	if(!isNull(disType)){
		jsonData["disType"] = disType;
	}

	$.ajax({
		type : "POST",
		url : "/cmmn/selectCodeList.do",
		data : jsonData,
		dataType: "json",
		async : false,
		contentType: "application/x-www-form-urlencoded;charset=utf-8",
		error : function(x, e, data) {
			var cd = x.status;
			if(cd == 0){
				cd = 990;
			}
			else if (e == 'parsererror') {
				cd = 991;
			} else if (e == 'timeout') {
				cd = 992;
			} else if(cd !=404 && cd != 500){
				cd = 999;
			}
			var alertMsg = "code:"+x.status+"\n"+"message:"+x.responseText+"\n"+"error:"+data;
			fnErrorMsg(cd, alertMsg, data);
		},
		success : function(data) {
			if(disAllYn){
				if(disStr1 == '' || disStr1 == null){
					$("#"+comboId).append("<option value=''>" + strCombo + "</option>");
				}else{
					$("#"+comboId).append("<option value=''>" + strCombo + "</option>");
					for(var i = 0; i< data.list.length;i++){
						if(disStr1 == data.list[i].txVal){
							$("#"+comboId).append("<option value='"+data.list[i].cmmnCd +"'>"+data.list[i].cmmnCdNm +"</option>");
						}
					}
				}
			}
		}
	});
}

// 달력 관련되어
/*
 * 기간 지정
 * from : 시작일
 * end  : 종료일
 * val  : 변수
 * fnOnChange : 월 선택 후 이벤트 처리
 * */
function fnRangeCal(from, to, fnOnChange){
	var dates = $( "#" +from  +" ,#" + to ).datepicker({
		dateFormat: 'yy-mm-dd',
		showOn: "button",
		buttonImage: "/images/button/btn_cal.gif",
		buttonImageOnly: true,
		buttonText: "Select date",
		onSelect: function( selectedDate ) {
			var option = this.id == from ? "minDate" : "maxDate",
			instance = $( this ).data( "datepicker" ),
			date = $.datepicker.parseDate(
										instance.settings.dateFormat ||
										$.datepicker._defaults.dateFormat,
										selectedDate, instance.settings );
			dates.not( this ).datepicker( "option", option, date );
			$( "#" + this.id ).val(selectedDate);
		},
		onClose : function (dateText, inst) {
	        if($.isFunction(fnOnChange)){
	        	fnOnChange();
	        }
	    },
	 	beforeShow: function(input, inst) {
	 		$(".ui-datepicker").removeClass("data_none");
	 		if ($(input).attr('readonly')) { return false; }
	 	}
	}).inputmask('9999-99-99');
	$( "#" +from +"").on("change",function(){
		var nowDate = this.value;
		nowDate = nowDate.replace(/-|_/gi,"");
		 
		var num_check=/^[0-9]*$/;
		if(num_check.test(nowDate)){
			if(nowDate.length!=8 && nowDate.length!=0){
				alert("날짜 형식이 틀립니다.");
				fnInitCal(cal, "");
			 }
			 else if(nowDate.length==8){
				var month = nowDate.substring(4,6);
				var	day   = nowDate.substring(6,8);
				if(month >12 || month <1){
					alert("날짜 형식이 틀립니다.");
					fnInitCal(cal, "");
				}
				else if(day >31 || day <1){
					alert("날짜 형식이 틀립니다.");
					fnInitCal(cal, "");
				}
			 }
		}else{
			alert("날짜 형식이 틀립니다.");
			fnInitCal(cal, "");
		}
	});
	
	$( "#" +to +"").on("change",function(){
		var nowDate = this.value;
		nowDate = nowDate.replace(/-|_/gi,"");
		 
		var num_check=/^[0-9]*$/;
		if(num_check.test(nowDate)){
			if(nowDate.length!=8 && nowDate.length!=0){
				alert("날짜 형식이 틀립니다.");
				fnInitCal(cal, "");
			 }
			 else if(nowDate.length==8){
				var month = nowDate.substring(4,6);
				var	day   = nowDate.substring(6,8);
				if(month >12 || month <1){
					alert("날짜 형식이 틀립니다.");
					fnInitCal(cal, "");
				}
				else if(day >31 || day <1){
					alert("날짜 형식이 틀립니다.");
					fnInitCal(cal, "");
				}
			 }
		}else{
			alert("날짜 형식이 틀립니다.");
			fnInitCal(cal, "");
		}
	});

	// 2015-08-19 LDC
	// inputmask 떄문에 선택된 값이 또는 입력된 값이 사라짐 마커 표시로만 나타나서 마커를 지움
	//$( "#" + from ).inputmask("9999-99-99");
	//$( "#" + to ).inputmask("9999-99-99");
}

function fnBaseCalChgArg(cal, fnOnChange, arg){
	$( "#" + cal ).datepicker({
		dateFormat: 'yy-mm-dd',
		showOn: "button",
		buttonImage: "/images/button/btn_cal.gif",
		buttonImageOnly: true,
		buttonText: "Select date",
		onSelect: function( selectedDate ) {
			$( "#" + cal ).val(selectedDate);
		},
		onClose : function (dateText, inst) {
	        if($.isFunction(fnOnChange)){
	        	var val = "";
	        	if(!isNull(arg)){
	        		val = arg;
	        	}
	        	fnOnChange(val);
	        }
	    },
	 	beforeShow: function(input, inst) {
	 		$(".ui-datepicker").removeClass("data_none");
	 		if ($(input).attr('readonly')) { return false; }
	 	}
	}).inputmask('9999-99-99');
	// 2015-08-19 LDC
	// inputmask 떄문에 선택된 값이 또는 입력된 값이 사라짐 마커 표시로만 나타나서 마커를 지움
	//$( "#" + cal ).inputmask("9999-99-99");
	$( "#" +cal +"").on("change",function(){
		var nowDate = this.value;
		nowDate = nowDate.replace(/-|_/gi,"");
		 
		var num_check=/^[0-9]*$/;
		if(num_check.test(nowDate)){
			if(nowDate.length!=8 && nowDate.length!=0){
				alert("날짜 형식이 틀립니다.");
				fnInitCal(cal, "");
			 }
			 else if(nowDate.length==8){
				var month = nowDate.substring(4,6);
				var	day   = nowDate.substring(6,8);
				if(month >12 || month <1){
					alert("날짜 형식이 틀립니다.");
					fnInitCal(cal, "");
				}
				else if(day >31 || day <1){
					alert("날짜 형식이 틀립니다.");
					fnInitCal(cal, "");
				}
			 }
		}else{
			alert("날짜 형식이 틀립니다.");
			fnInitCal(cal, "");
		}
	});
}

/*
 * 기간 지정
 * from : 시작일
 * end  : 종료일
 * val  : 변수
 * fnOnChange : 일 선택 후 이벤트 처리
 * */
function fnBaseCal(cal, fnOnChange){
	$( "#" + cal ).datepicker({
		dateFormat: 'yy-mm-dd',
		showOn: "button",
		buttonImage: "/images/button/btn_cal.gif",
		buttonImageOnly: true,
		buttonText: "Select date",
		onSelect: function( selectedDate ) {
			$( "#" + cal ).val(selectedDate);
		},
		onClose : function (dateText, inst) {
	        if($.isFunction(fnOnChange)){
	        	fnOnChange(cal);
	        }
	    },
	 	beforeShow: function(input, inst) {
	 		$(".ui-datepicker").removeClass("data_none");
	 		if ($(input).attr('readonly')) { return false; }
	 	}
	}).inputmask('9999-99-99');
	// 2015-08-19 LDC
	// inputmask 떄문에 선택된 값이 또는 입력된 값이 사라짐 마커 표시로만 나타나서 마커를 지움
	//$( "#" + cal ).inputmask("9999-99-99");
	$( "#" +cal +"").on("change",function(){
		var nowDate = this.value;
		nowDate = nowDate.replace(/-|_/gi,"");
		 
		var num_check=/^[0-9]*$/;
		if(num_check.test(nowDate)){
			if(nowDate.length!=8 && nowDate.length!=0){
				alert("날짜 형식이 틀립니다.");
				fnInitCal(cal, "");
			 }
			 else if(nowDate.length==8){
				var month = nowDate.substring(4,6);
				var	day   = nowDate.substring(6,8);
				if(month >12 || month <1){
					alert("날짜 형식이 틀립니다.");
					fnInitCal(cal, "");
				}
				else if(day >31 || day <1){
					alert("날짜 형식이 틀립니다.");
					fnInitCal(cal, "");
				}
			 }
		}else{
			alert("날짜 형식이 틀립니다.");
			fnInitCal(cal, "");
		}
	});
}


/*
 * 년,월 수정
 *
 * val  : 변수
 * */
function fnChangeCal(cal){
	 $( "#" + cal ).datepicker({
		dateFormat: 'yy-mm-dd',
		showOn: "button",
		buttonImage: "/images/button/btn_cal.gif",
		buttonImageOnly: true,
		changeMonth: true,
		changeYear: true,
		buttonText: "Select date",
		onSelect: function( selectedDate ) {
			$( "#" + cal ).val(selectedDate);
		},
	 	beforeShow: function(input, inst) {
	 		$(".ui-datepicker").removeClass("data_none");
	 		if ($(input).attr('readonly')) { return false; }
	 	}
	}).inputmask('9999-99-99');
	// 2015-08-19 LDC
	// inputmask 떄문에 선택된 값이 또는 입력된 값이 사라짐 마커 표시로만 나타나서 마커를 지움
	//$( "#" + cal ).inputmask("9999-99-99");
	 
	 $( "#" +cal +"").on("change",function(){
			var nowDate = this.value;
			nowDate = nowDate.replace(/-|_/gi,"");
			 
			var num_check=/^[0-9]*$/;
			if(num_check.test(nowDate)){
				if(nowDate.length!=8 && nowDate.length!=0){
					alert("날짜 형식이 틀립니다.");
					fnInitCal(cal, "");
				 }
				 else if(nowDate.length==8){
					var month = nowDate.substring(4,6);
					var	day   = nowDate.substring(6,8);
					if(month >12 || month <1){
						alert("날짜 형식이 틀립니다.");
						fnInitCal(cal, "");
					}
					else if(day >31 || day <1){
						alert("날짜 형식이 틀립니다.");
						fnInitCal(cal, "");
					}
				 }
			}else{
				alert("날짜 형식이 틀립니다.");
				fnInitCal(cal, "");
			}
		});
}


/**
 * @param date    : 기준날짜 ex)2015-12-01
 * @param addMon  : 더하거나 뺄 월  -1/1
 * @param div     : 구분자  - : 2015-12-01   ,  /  : 2015/12/01
 */
function fnAddMonth(date, addMon, div){
	var sDiv = "-";
	if(!isNull(div)){
		sDiv = div;
	}
	var sDt     = new Date(date.substring(5,7)+"/"+date.substring(8,10)+"/"+date.substring(0,4));
	
	sDt.setMonth(sDt.getMonth() + parseInt(addMon)); //
	
	var year = sDt.getFullYear();
	var month = sDt.getMonth() + 1;
	var day = sDt.getDate();
	
	if(month<10){
		month = "0" + month;
	}
	
	if(day<10){
		day = "0" + day;
	}
	return "" + year + sDiv + month + sDiv +day;
}

/*
 * fnInitCal('aaa', '2015-08-01')
 */
function fnInitCal(cal, val){
	var nowDate = val.replace(/-|_/gi,"");
	//alert(nowDate.length);
	var year, month, day;
	//alert(nowDate.substring(0,4) + " / " + nowDate.substring(5,6)+ " / " + nowDate.substring(7,8))
	if(nowDate.length == 8){
		year  = nowDate.substring(0,4);
		month = nowDate.substring(4,6);
		month = month -1;
		day   = nowDate.substring(6,8);
		$('#'+cal).datepicker('setDate', new Date(year, month, day));
		$('#'+cal).val(val);
	}
	else if(nowDate.length == 6){
		year  = nowDate.substring(0,4);
		month = nowDate.substring(4,6);
		month = month -1;
		day   = 1;
		$('#'+cal).datepicker('setDate', new Date(year, month, day));
		$('#'+cal).val(val);
	}
	else{
		$('#'+cal).datepicker('setDate', "");
		$('#'+cal).val("");
	}
	//new Date(year, month, 1);
	
	
}
/*
 * 월
 *
 * val  : 변수
 * fnOnChange : 월 선택 후 이벤트 처리
 * */
function fnMonCal(cal, fnOnChange){
	 $( "#" + cal ).datepicker({
		closeText: '선택',
		dateFormat: 'yy-mm',
		currentText: "이번달",
		//showOn: "button",
		showOn: 'both',
		showButtonPanel: true,
		showOtherMonths: true,
        selectOtherMonths: true,
		buttonImage: "/images/button/btn_cal.gif",
		buttonImageOnly: true,
		changeMonth: true,
		changeYear: true,
		buttonText: "Select date",
		onClose : function (dateText, inst) {
	        var month = $("#ui-datepicker-div .ui-datepicker-month :selected").val();
	        var year = $("#ui-datepicker-div .ui-datepicker-year :selected").val();
	        //$(this).datepicker( "option", "defaultDate", new Date(year, month, 1) );
	        $( "#" + cal ).datepicker('setDate', new Date(year, month, 1));
	        $( "#" + cal ).val($(this).val());
            
	        if($.isFunction(fnOnChange)){
	        	fnOnChange(cal);
	        }

	    },
	    onSelect: function( selectedDate ) {
	    	if($( "#" + cal ).val() != selectedDate){
	    		var nowDay = $( "#" + cal ).val();
	    		var year  = nowDay.substring(0,4);
 				var month = nowDay.substring(5,7)-1;
 				$(this).datepicker( "setDate", new Date(year, month, 1) );
 		       	$( "#" + cal ).val(nowDay);
	    	}
	    	else{
	    		$( "#" + cal ).val(selectedDate);
	    	}
		},
	 	beforeShow: function(input, inst) {
	 		var nowDay = $( "#" + cal ).val();
	 		var date =$( "#" + cal ).val();
	 		if(!isNull(nowDay)){
	 			nowDay = nowDay.replace(/-|_/gi,"");
	 			if(nowDay != "" && nowDay.length==6){
	 				var year  = nowDay.substring(0,4);
	 				var month = nowDay.substring(4,6)-1;
	 				$(this).datepicker( "option", "defaultDate", new Date(year, month, 1) );
	 		       	$( "#" + cal ).val(date);
	 			}
	 		}
	 		$(".ui-datepicker").addClass("data_none");
	 		//if ($(input).attr('readonly')) { return false; }
	 	}
	}).inputmask('9999-99');
	 /*
	 $( "#" + cal).load(function() {
		 alert(1);
	 });*/

	// 2015-08-19 LDC
	// inputmask 떄문에 선택된 값이 또는 입력된 값이 사라짐 마커 표시로만 나타나서 마커를 지움
	//$( "#" + cal ).inputmask("9999-99");
	 $( "#" +cal +"").on("change",function(){
			var nowDate = this.value;
			var date = this.value;
			nowDate = nowDate.replace(/-|_/gi,"");
			 
			var num_check=/^[0-9]*$/;
			if(num_check.test(nowDate)){
				if(nowDate.length!=6 && nowDate.length!=0){
					alert("날짜 형식이 틀립니다.");
					fnInitCal(cal, "");
				 }
				 else if(nowDate.length==6){
					var month = nowDate.substring(4,6);
					if(month >12 || month <1){
						alert("날짜 형식이 틀립니다.");
						fnInitCal(cal, "");
					}
				 }
				 else{
					 fnInitCal(cal, date);
				 }
			}else{
				alert("날짜 형식이 틀립니다.");
				fnInitCal(cal, "");
			}
		});
}


/*
 * 화면 리사이즈
 * */
function onResize(grid){
	var minHeight = 600;
	var minGridHegiht = 173;
	// 텝으로 인해 뒤에서 부터 리사이징
	for(var i = grid.length-1; i>=0; i--){

		var reParents = $("#gbox_" + grid[i]).parents(".tbl_height_box").width();
		var pWidth = 0;
		var pHeight = 0;
		if(reParents != null){
			pWidth = $("#gbox_" + grid[i]).parents(".tbl_height_box").width();
			pHeight = $("#gbox_" + grid[i]).parents(".tbl_height_box").height();

			$("#gbox_" + grid[i]).parents(".tbl-scroll-wrap").css({width : pWidth + "px", height: pHeight + "px"});

			// tbl_view_col 체크
			var reVal = $("#gbox_" + grid[i]).parents(".tbl_view_col").width();
			if(reVal != null){
				$("#gbox_" + grid[i]).parents(".tbl_view_col").css({width : pWidth + "px", height: pHeight + "px"});
			}

			// tbl_view_add_col 체크
			reVal = $("#gbox_" + grid[i]).parents(".tbl_view_add_col").width();
			if(reVal != null){
				$("#gbox_" + grid[i]).parents(".tbl_view_add_col").css({width : pWidth + "px", height: pHeight + "px"});
			}

			// tbl_view_row_col 체크
			reVal = $("#gbox_" + grid[i]).parents(".tbl_view_row_col").width();
			if(reVal != null){
				$("#gbox_" + grid[i]).parents(".tbl_view_row_col").css({width : pWidth + "px", height: pHeight + "px"});
			}


		}
		else{

			var pOffset = $("#gbox_" + grid[i]).parents(".tbl-scroll-wrap").offset();
			var bodyHeight = $(window).height();
			/*기본 사이즈보다 화면 내용이 클때 .. */
			if(minHeight>bodyHeight){
				bodyHeight= minHeight;
			}
			pHeight = bodyHeight- pOffset.top - 30 ;
			if(pHeight < minGridHegiht){
				pHeight = minGridHegiht;
			}
			/*기본 사이즈보다 화면 내용이 클때 .. */
			// 하단 고정값 체크
			var fotVal = $(".tbl_height_fot").height();

			if(fotVal == null){
				fotVal = 0;
			}

			$("#gbox_" + grid[i]).parents(".tbl-scroll-wrap").css({height: (pHeight - fotVal) + "px"});
			var reVal = $("#gbox_" + grid[i]).parents(".tbl_view_col").width();
			if(reVal != null){
				$("#gbox_" + grid[i]).parents(".tbl_view_col").css({height: (pHeight - fotVal) + "px"});
			}
			// tbl_view_add_col 체크
			reVal = $("#gbox_" + grid[i]).parents(".tbl_view_add_col").width();
			if(reVal != null){
				$("#gbox_" + grid[i]).parents(".tbl_view_add_col").css({height: (pHeight - fotVal) + "px"});
			}

			// tbl_view_row_col 체크
			reVal = $("#gbox_" + grid[i]).parents(".tbl_view_row_col").width();
			if(reVal != null){
				$("#gbox_" + grid[i]).parents(".tbl_view_row_col").css({height: (pHeight - fotVal) + "px"});
			}
		}
		var topWidth = $("#gbox_" + grid[i]).parents(".tbl-scroll-wrap").width() -2;
		var topHeight = $("#gbox_" + grid[i]).parents(".tbl-scroll-wrap").height() -3;
		var titleHeight = $("#gview_" + grid[i]).find(".ui-jqgrid-hdiv").height();
		var footerHeight = $("#gview_" + grid[i]).find(".ui-jqgrid-sdiv").height();
		footerHeight = (footerHeight == null) ? 0 : footerHeight;


		// box
		$("#gbox_" + grid[i]).css({width : topWidth + "px"});
		// view
		$("#gview_" + grid[i]).css({width : topWidth + "px"});
		// Title
		$("#gview_" + grid[i]).find(".ui-jqgrid-hdiv").css({width : topWidth + "px"});
		// Body
		// 그리드 전체 사이즈 변경으로 1px 줄어듬 (2015-09-08)
		$("#gview_" + grid[i]).find(".ui-jqgrid-bdiv").css({width : topWidth + "px", height: (topHeight-titleHeight-footerHeight-1) + "px"});
	}
}

function isNull(arg){
	return (typeof arg != "undefined" && arg != null && arg != "")?false:true;
}

//새창 여는 함수(Window)
function fnWindowOpen(asURL, asName, aiSizeW, aiSizeH)
{
	var intLeft = screen.width / 2 - aiSizeW / 2;
	var intTop  = screen.height / 2 - aiSizeH / 2;

	opt = ",toolbar=no,menubar=no,location=no,scrollbars=yes,status=yes";
	window.open(asURL, asName.replace(" ",""), "left=" + intLeft + ",top=" +  intTop + ",width=" + aiSizeW + ",height=" + aiSizeH  + opt);
}

/**********************************************************************************
 * 서버 날짜 가져오기
 *********************************************************************************/
function fnDataTime(){
	var res = {};
	$.ajax({
		type : "POST",
		url : "/cmmn/getDateTime.do",
		data : '',
		dataType: "json",
		async : false,
		contentType: "application/x-www-form-urlencoded;charset=utf-8",
		error : function(x, e, data) {
			var cd = x.status;
			if(cd == 0){
				cd = 990;
			}
			else if (e == 'parsererror') {
				cd = 991;
			} else if (e == 'timeout') {
				cd = 992;
			} else if(cd !=404 && cd != 500){
				cd = 999;
			}
			var alertMsg = "code:"+x.status+"\n"+"message:"+x.responseText+"\n"+"error:"+data;
			fnErrorMsg(cd, alertMsg, data);
		},
		success : function(data) {
			res["YY"] = data.date.substring(0,4);
			res["MM"] = data.date.substring(4,6);
			res["DD"] = data.date.substring(6,8);
			res["HH"] = data.date.substring(8,10);
			res["MI"] = data.date.substring(10,12);
			res["SS"] = data.date.substring(12,14);
			res["DATE"] = data.date.substring(0,8);
			res["DATE1"] = data.date.substring(0,4) +"-"+data.date.substring(4,6) +"-"+data.date.substring(6,8);
			res["MON"] = data.date.substring(0,4) +"-"+data.date.substring(4,6);
		}
	});
	return res;
}

/**********************************************************************************
* Function명 : gfnTodayDate()
* 설명 : 오늘날짜 구하기
* Params :
* Return : - 성공 =날짜값 ( 예 : 20150812 )
- 실패 =
**********************************************************************************/
function gfnTodayDate(sep){
	if(sep==null || sep=="") sep="";
	/*
	var _date = new Date();
	var _year = _date.getFullYear();
	var _month = ""+(_date.getMonth() + 1);
	var _day = ""+ _date.getDate();
	if(_month.length == 1) _month = "0" + _month;
	if((_day.length) == 1) _day = "0" + _day;

	 */
	// 서버 시간으로 변경
	var _date = fnDataTime();
	var _year = _date["YY"];
	var _month = _date["MM"];
	var _day = _date["DD"];

	var nDate = ""+_year +sep+ _month +sep+ _day;

	return nDate;
}
/**********************************************************************************
* Function명 : gfnLastDateNum()
* 설명 : 해당월의 마지막 날짜를 숫자로 구하기
* Params : 1. sDate : yyyyMMdd형태의 날짜 ( 예 : "20121122" )
* Return : - 성공 = 마지막 날짜 숫자값 ( 예 : 30 )
- 실패 =
**********************************************************************************/
function gfnLastDateNum(sDate){
	var nMonth, nLastDate;

	nMonth = parseInt(sDate.substr(4, 2), 10);
	if( nMonth == 1 || nMonth == 3 || nMonth == 5 || nMonth == 7 || nMonth == 8 || nMonth == 10 || nMonth == 12 ) {
		nLastDate = 31;
	} else if( nMonth == 2 ) {
		if( this.gfnIsLeapYear(sDate) == true ) {
			nLastDate = 29;
		} else {
			nLastDate = 28;
		}
	} else {
		nLastDate = 30;
	}
	return nLastDate;
}

/**********************************************************************************
* Function명 : gfnIsLeapYear()
* 설명 : 윤년여부 확인
* Params : 1. sDate : yyyyMMdd형태의 날짜 ( 예 : "20121122" )
* Return : sDate가 윤년인 경우 = true
- sDate가 윤년이 아닌 경우 = false
- sDate가 입력되지 않은 경우 = false
**********************************************************************************/
function gfnIsLeapYear(sDate){
	var ret;
	var nY;

	if(sDate == '' || sDate == null ) {
		return false;
	}
		nY = parseInt(sDate.substring(0, 4), 10);

	if ((nY % 4) == 0) {
		if ((nY % 100) != 0 || (nY % 400) == 0) {
			ret = true;
		} else {
			ret = false;
		}
	} else {
		ret = false;
	}

	return ret;
}

/**********************************************************************************
* Function명 :getMonthDate(date, type)
* 설명 : 당월 1일/ 마지막일자 구하기
* Params : 1. date : yyyyMMdd형태의 날짜 ( 예 : "20121122" ),
* 		   2. type : 0 : 당월1일 (예 : 2015-08-01)
*                    1 : 당월마지막일 (예 : 2015-08-31)
*                    null : 당월마지막일자( 예 : 31)
* Return : 년월일자 ( 예 : 2015-08-31, null : 31)
**********************************************************************************/
function getMonthDate(date, type) {
	var year,month ;
	var dt;

	if(isNull(date)){
		/*
		var d = new Date();
		year =  d.getYear();
		month =  d.getMonth()+1;
		*/
		var d = fnDataTime();
		year =  d["YY"];
		month =  d["MM"];
		dt = new Date(year, month-1, 0);
	}else{

		var temp = date.replace(/-|[/]| |:|[.]|,/gi,"");
		year = temp.substr(0, 4);
		month = temp.substr(4, 2);
		dt = new Date(year, month, 0);
	}
	if(isNull(type)){
    	return dt.getDate();
	}
	else if(type == 0){
		var res = year +"-"+ month +"-01";
		return res;
	}else if(type == 1){
		var res = year +"-"+ month +"-" + dt.getDate();
		return res;
	}
	else{
		return "";
	}
}

function getDateFormat(f, date){

	var weekName = ["일요일", "월요일", "화요일", "수요일", "목요일", "금요일", "토요일"];
	var d;

	if(isNull(date)){
		f = "yyyy-MM-dd";
		var date1 = fnDataTime();
		//d= new Date(date1["DATE"]);
		d = new Date(date1["YY"], date1["MM"]-1, date1["DD"]);
	}
	else if(date.length==8){
		d = new Date(date.substring(0,4), date.substring(4,6)-1, date.substring(6,8));
	}
	else{
		d = new Date(date);
	}
	String.prototype.string = function(len){var s = '', i = 0; while (i++ < len) { s += this; } return s;};
	String.prototype.zf = function(len){return "0".string(len - this.length) + this;};
	Number.prototype.zf = function(len){return this.toString().zf(len);};

	return f.replace(/(yyyy|yy|MM|dd|E|hh|mm|ss|a\/p)/gi, function($1) {
		switch ($1) {
			case "yyyy": return d.getFullYear();
			case "yy": return (d.getFullYear() % 1000).zf(2);
			case "MM": return (d.getMonth() + 1).zf(2);
			case "dd": return d.getDate().zf(2);
			case "E": return weekName[d.getDay()];
			case "HH": return d.getHours().zf(2);
			case "hh": return ((h = d.getHours() % 12) ? h : 12).zf(2);
			case "mm": return d.getMinutes().zf(2);
			case "ss": return d.getSeconds().zf(2);
			case "a/p": return d.getHours() < 12 ? "오전" : "오후";
			default: return $1;
		}
	});

}

//주민등록번호 유효성 검증
function fnValidRegNo(asValue)
{
	var arrRegNo = new Array(0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0);
	var intSum = 0;
	var intMod = 0;
	var i = 0;

	if (isNull(asValue)) return false;

	var strValue = asValue.toString().replace(/-/g, "");

	if (fntByteLength(strValue) == 10)
	{
		//return C_isValidCustNo(strValue);
		return false;
	}

	if (fntByteLength(strValue) != 13)
	{
		//ERR_MSG = "주민등록번호는 13자리 숫자입니다.";
		return false;
	}

	if (strValue == '0000000000000') return true;

	for (i = 0; i < 13; i++) arrRegNo[i] = strValue.substr(i, 1);

	for (i = 0; i < 12; i++) intSum += arrRegNo[i] * ((i > 7) ? (i - 6) : (i + 2));

	intMod = 11 - intSum % 11;

	if (intMod >= 10) intMod -= 10;

	if (intMod != arrRegNo[12])
	{
		//ERR_MSG = "올바르지 않은 주민등록번호입니다.";
		return false;
	}

	return true;
}

//사업자번호 유효성 검증
function fnValidCustNo(asValue)
{
	var intSumMod = 0;

	if (isNull(asValue)) return fas;

	var strValue = asValue.toString().replace(/-/g, "");

	if (fntByteLength(strValue) == 13)
	{
		//return C_isValidRegNo(strValue);
		return false;
	}

	if (fntByteLength(strValue) != 10 || !isNum(strValue))
	{
		//ERR_MSG = "사업자등록번호는 10자리 숫자입니다.";
		return false;
	}

	intSumMod += parseInt(strValue.substr(0, 1));
	intSumMod += parseInt(strValue.substr(1, 1)) * 3 % 10;
	intSumMod += parseInt(strValue.substr(2, 1)) * 7 % 10;
	intSumMod += parseInt(strValue.substr(3, 1)) * 1 % 10;
	intSumMod += parseInt(strValue.substr(4, 1)) * 3 % 10;
	intSumMod += parseInt(strValue.substr(5, 1)) * 7 % 10;
	intSumMod += parseInt(strValue.substr(6, 1)) * 1 % 10;
	intSumMod += parseInt(strValue.substr(7, 1)) * 3 % 10;
	intSumMod += Math.floor(parseInt(strValue.substr(8, 1)) * 5 / 10);
	intSumMod += parseInt(strValue.substr(8, 1)) * 5 % 10;
	intSumMod += parseInt(strValue.substr(9, 1));

	if (intSumMod % 10 != 0)
	{
		//ERR_MSG = "올바르지 않은 사업자등록번호입니다.";
		return false;
	}

	return	true;
}

/*
  입력값의 바이트 길이를 리턴
  ex) if (getByteLength(form.title) > 100) {
          alert("제목은 한글 50자(영문 100자) 이상 입력할 수 없습니다.");
      }
*/
function fntByteLength(asValue)
{
	var byteLength = 0;
	var	lsEsc = "%B2%B3%B4%B7%A8%AD%B1%D7%F7%B0%A7%B8%A1%BF%A4%B6%AE%C6%D0%AA%3F%3F%D8%BA%DE%BD%BC%BE%E6%F0%F8%DF%FE%B9";

	for (var i = 0; i < asValue.length; i++)
	{
		var oneChar = escape(asValue.charAt(i));

		if (oneChar.length == 1 )
		{
			byteLength ++;
		}
		else if (oneChar.indexOf("%u") != -1)
		{
			byteLength += 2;
		}
		else if (oneChar.indexOf("%") != -1)
		{
			if(lsEsc.indexOf(oneChar) != -1)
			{
				byteLength += 2;
			}
			else
			{
				byteLength += oneChar.length / 3;
			}
		}
	}

	return byteLength;
}

// 숫자검증
function isNum(asValue)
{
	if (isNull(asValue)) return false;

	for (var i = 0; i < asValue.length; i++)
	{
		if (asValue.charAt(i) < '0' || asValue.charAt(i) > '9')
		{
			return false;
		}
	}

	return true;
}

//숫자만 입력 받도록 하는 함수
//isNum과 function명이 중복되어 isNumber로 변경
function isNumber(){
   var key = event.keyCode;
   if(!(key==8||key==9||key==13||key==46||key==144||(key>=48&&key<=57)||key==110||key==190)){
        //alert('숫자만 입력 가능합니다');
        event.returnValue = false;
   }
}


// TypeMoney 체크
function fnTypeMoney(){
	$(".TypeMoney" )
		.focus(function() {
			var text = $(this).val();
			text = text.replaceAll(",", "");
			$(this).val(text);
		})
		.focusout(function() {
			var text = $(this).val();
			text = text.replaceAll(",", "").money();
			$(this).val(text);
		})
		.keypress(function(e) {
			 if( !( (event.keyCode >= 37 && event.keyCode<=57) || (event.keyCode >= 96 && event.keyCode <= 105)
			       || event.keyCode == 8  || event.keyCode == 9)  ){
			         event.returnValue=false;
			 }
		});
}

// 페이지 초기 세팅
// 페이지 타이틀, 페이지 내비, 페이지 즐겨찾기 여부
function fnPageInit(title, navi, menuId){
	alert(title+" / "+navi+" / "+menuId);

}
//년도 콤보 만들기.
//해당년도를 선택으로
function fnYearCombo(comboId, range){
	if(isNull(range)){
		range = 5;
	}
	var d = fnDataTime();
	var year = parseInt(d["YY"]);
	for(var i = year-range; i<= year+range; i++){
		if(i==year){
			$("#"+comboId).append("<option value='"+i+"' selected>" + i + "</option>");
		}
		else{
			$("#"+comboId).append("<option value='"+i+"'>" + i + "</option>");
		}
	}
}

//엑셀 파일을 올려서 리스트로 화면에서 받기.
// file <-- 파일 ID
// businessNm <-- 업무명
function fnExcelToList(file, businessNm){
	var formData = new FormData();
	formData.append("businessNm", businessNm);
	formData.append("excelFile", $("#"+file)[0].files[0]);
	
	//formData.append("excelFile", $("input[name="+file+"]")[0].files[0]);
	var resData ="";
	$.ajax({
		url: '/cmmn/uploadExcelToList.do',
		data: formData,
		processData: false,
		contentType: false,
		type: 'POST',
		error : function(x, e, data) {
			alert("업로드중에 오류가 발생하였습니다.\n업로드 양식을 확인하십시요.(ex.확장자확인)");
		},
		async : false,
		success: function(data){
			
			//alert(data);
			resData = data;
		}
	});
	return resData;
}

/*즐겨 찾기.*/
function fnFavoMenu(onLoadYn){
	var url = unescape(location.href);
	var paramArr = (url.substring(url.indexOf("?")+1,url.length)).split("&");
	var menuId="";
	for(var i = 0 ; i < paramArr.length ; i++){
		var temp = paramArr[i].split("="); //파라미터 변수명을 담음
		if(temp[0].toUpperCase() == "MENUID"){
			menuId = paramArr[i].split("=")[1];
			break;
		}
	}
	if (menuId == "") return;

	if(onLoadYn == 1){
		$.ajax({
			type : "POST",
			url : "/cmmn/selectFavoMenuCheck.do",
			data : {"menuId" : menuId},
			dataType: "json",
			async : false,
			contentType: "application/x-www-form-urlencoded;charset=utf-8",
			error : function(x, e, data) {
				var cd = x.status;
				if(cd == 0){
					cd = 990;
				}
				else if (e == 'parsererror') {
					cd = 991;
				} else if (e == 'timeout') {
					cd = 992;
				} else if(cd !=404 && cd != 500){
					cd = 999;
				}
				var alertMsg = "code:"+x.status+"\n"+"message:"+x.responseText+"\n"+"error:"+data;
				fnErrorMsg(cd, alertMsg, data);
			},
			success : function(data) {
				if(data == 1){
					$(".sub_top_content .subtit .ico_star").addClass("on");
					$(".sub_top_content .subtit .ico_star").removeClass("off");
					$(".sub_top_content .subtit .star_layer2").css("display","none");
					$(".sub_top_content .subtit .star_layer1").css("display","none");
				}
			}
		});
	}
	else{
		var addYn = "N";

		if($(".sub_top_content .subtit .ico_star").hasClass("off") == true){
			addYn = "Y";
		}

		$.ajax({
			type : "POST",
			url : "/cmmn/saveFavoMenu.do",
			data : {"menuId" : menuId, "addYn" : addYn},
			dataType: "json",
			async : false,
			contentType: "application/x-www-form-urlencoded;charset=utf-8",
			error : function(x, e, data) {
				var cd = x.status;
				if(cd == 0){
					cd = 990;
				}
				else if (e == 'parsererror') {
					cd = 991;
				} else if (e == 'timeout') {
					cd = 992;
				} else if(cd !=404 && cd != 500){
					cd = 999;
				}
				var alertMsg = "code:"+x.status+"\n"+"message:"+x.responseText+"\n"+"error:"+data;
				fnErrorMsg(cd, alertMsg, data);

			},
			success : function(data) {
				if($(".sub_top_content .subtit .ico_star").hasClass("off") == true){
					$(".sub_top_content .subtit .ico_star").addClass("on");
					$(".sub_top_content .subtit .ico_star").removeClass("off");
					$(".sub_top_content .subtit .star_layer2").css("display","none");
					$(".sub_top_content .subtit .star_layer1").css("display","block");
					setTimeout(function () {$(".sub_top_content .subtit .star_layer1").hide()}, 600);
				}else{
					$(".sub_top_content .subtit .ico_star").addClass("off");
					$(".sub_top_content .subtit .ico_star").removeClass("on");
					$(".sub_top_content .subtit .star_layer1").css("display","none");
					$(".sub_top_content .subtit .star_layer2").css("display","block");
					setTimeout(function () {$(".sub_top_content .subtit .star_layer2").hide()}, 600);
				}
			}
		});
	}
}

/*
 * dvsnCmmnCd : 분류코드
 * cmmnCd     : 공통코드
 */
function fnComCodeName(dvsnCmmnCd, cmmnCd, objTxt){
	if(!dvsnCmmnCd) return;
	if(!cmmnCd) return;

	var jsonData = {};
	jsonData["dvsnCmmnCd"] = dvsnCmmnCd;
	jsonData["cmmnCd"] = cmmnCd;

	$.ajax({
		type : "POST",
		url : "/cmmn/selectComCodeName.do",
		data : jsonData,
		async : true,
		dataType: "json",
		contentType: "application/x-www-form-urlencoded;charset=utf-8",
		error : function(x, e, data) {
			var cd = x.status;
			if(cd == 0){
				cd = 990;
			}
			else if (e == 'parsererror') {
				cd = 991;
			} else if (e == 'timeout') {
				cd = 992;
			} else if(cd !=404 && cd != 500){
				cd = 999;
			}
			var alertMsg = "code:"+x.status+"\n"+"message:"+x.responseText+"\n"+"error:"+data;
			fnErrorMsg(cd, alertMsg, data);
		},
		success : function(data) {
			if(data.list.length > 0){
				var strVal = data.list[0].cmmnCdNm;
				$(objTxt).text(strVal);
			}else{
				$(objTxt).text("");
			}
		}
	});
}

// Error Code
// -1 => DB Error
// 0 => network offline
// 1~10 => sucess
// 991 => parsererror
// 992 => timeout
// 404 => Requested URL not found.
// 500 => Internel Server Error
// 999 => 기타

function fnErrorMsg(cd, alertMsg, errorMsg){

	if (cd == 990) {
		alert('You are offline!!\n Please Check Your Network.');
	}else if (cd == 404) {
		alert('Requested URL not found.');
	} else if (cd == 500) {
		alert('Internel Server Error.');
	}else if(cd == 991){
		alert('Error.nParsing JSON Request failed.');
	}else if(cd == 992){
		alert('Request Time out.');
	} else {
		alert(alertMsg);
	}

}

//월 콤보 만들기.
// 해당월을 선택으로
function fnMonthCombo(comboId){
	var date = fnDataTime();
	//var now = new Date();
	var month = date["MM"];
	var strMm = "";

	for(var i = 1;  i<= 12; i++){
		strMm = i < 10?"0"+i:i;
		if(i==month){
			$("#"+comboId).append("<option value='"+strMm+"' selected>" + i + "월</option>");
		}
		else{
			$("#"+comboId).append("<option value='"+strMm+"'>" + i + "월</option>");
		}
	}
}



/*
 * 메시지 Argument 자동 처리
 * alert( 'fn_message( "{0}은(는) 필수항목 입니다.", "거래처")');
 */
function fn_message(message) {

	message = nvl( message, "");
	if (arguments.length > 1) {
		for (var n = 0; n < arguments.length -1; n++) {
			var arg = nvl( fn_message.arguments[n + 1], "");
			message = message.replaceAll("{" + n + "}", arg);
		}
	}
	return message;
}



/*
 * fsclYn : 회계년도
 * clsYn : 잠금여부
 * comboId : select BOX ID
 * disAllYn : 전체 노출 여부
 * disStr : 1: 전체, 2: 선택
 * disType : 콤보 노출 타입(nm : 명(기본 - 생략가능), cd:코드)
 * clsYn : 잠금여부
 * searchType  : 조회 타입 (필요에 따라 쿼리 조회조건을 추가)
 */
function fnComVerCombo(fsclYy, comboId, disAllYn, disStr, disType, clsYn, searchType){
	if(!fsclYy) return;
	if(!comboId) return;
	if(!disAllYn) disAllYn = false;
	var strCombo = "";
	if(!disStr) strCombo = '전체';
	else if (disStr == "2"){
		strCombo = '선택';
	}else{
		strCombo = '전체';
	}

	var jsonData = {};
	jsonData["fsclYy"] = fsclYy;

	if(!isNull(disType)){
		jsonData["disType"] = disType;
	}

	if(!isNull(clsYn)){
		jsonData["clsYn"] = clsYn;
	}

	if(!isNull(searchType)){
		jsonData["searchType"] = searchType;
	}

	if(!disStr) strCombo = '전체';

	$.ajax({
		type : "POST",
		url : "/cmmn/selectVerList.do",
		data : jsonData,
		async : false,
		dataType: "json",
		contentType: "application/x-www-form-urlencoded;charset=utf-8",
		error : function(x, e, data) {
			var cd = x.status;
			if(cd == 0){
				cd = 990;
			}
			else if (e == 'parsererror') {
				cd = 991;
			} else if (e == 'timeout') {
				cd = 992;
			} else if(cd !=404 && cd != 500){
				cd = 999;
			}
			var alertMsg = "code:"+x.status+"\n"+"message:"+x.responseText+"\n"+"error:"+data;
			fnErrorMsg(cd, alertMsg, data);
		},
		success : function(data) {
			$("#"+comboId).empty().data('options');
			if(disAllYn){
				$("#"+comboId).append("<option value=''>" + strCombo + "</option>");
			}
			for(var i = 0; i< data.list.length;i++){
				$("#"+comboId).append("<option value='"+data.list[i].code +"'>"+data.list[i].name +"</option>");
			}

		}
	});
}

function fnCreateExcel(gridId, opt, excelName, sheetName, sheetSytle){
	var $grid = $("#"+gridId);
	var excelList = $grid.getRowData();

	var IDs = $grid.getDataIDs();
	var row = $grid.getRowData(IDs[0]);

	var titleList = new Array();
	var dataTitle = new Array();
	var ii = 0;

	for ( var i in opt.headerString) {
		titleList[ii++] = opt.headerString[i];
	}
	ii = 0;
	for ( var i in row) {
		dataTitle[ii++] = i;
	}


	var $form = $('<form></form>');
	$form.hide();
	$form.attr('action', '/comn/createExcel.do');
	$form.attr('method', 'post');
	$("<input type='hidden' id='excelNm' name='excelNm' value='"+excelName+"'></input>").appendTo($form);
	$("<input type='hidden' id='sheetNm' name='sheetNm' value='"+sheetName+"'></input>").appendTo($form);
	$("<input type='hidden' id='sheetSt' name='sheetSt' value='"+sheetSytle+"'></input>").appendTo($form);
	$("<input type='hidden' id='titleList' name='titleList' value='"+JSON.stringify(titleList)+"'></input>").appendTo($form);
	$("<input type='hidden' id='titleList' name='dataTitle' value='"+JSON.stringify(dataTitle)+"'></input>").appendTo($form);
	$("<input type='hidden' id='excelList' name='excelList' value='"+JSON.stringify(excelList)+"'></input>").appendTo($form);
	$form.appendTo('body');
	$form.submit();
}

/**
* fnGridKeyValidation(gridId, options)
* 작성자   : KSM
* 작성일자 : 2015-10-30
* 개요    : grid object의 필수갑 입력 체크
* return  : true/false
*/
function fnGridKeyValidation(gridId, options){
	var $grid = $("#"+gridId);
	var rows = $grid.getDataIDs();
	
   for(var k=0; k<rows.length; k++){
		// 선언된 컬럼 갯수만큼 돌면서 required가 필수인 항목에 대한 필수값을 체크한다.
	    for (var i = 0; i < options.headerString.length; i++) {
	    	if(options.colModelRequired[i] ==  true ){
	    		if(isNull($grid.getCell(rows[k],options.colModelName[i]))){
	    			alert((k+1) + "행의 [" + options.headerString[i] + "] 은(는) 필수 입니다.");
	    			return false;
	    		}
	    	}
	    }
	}
   return true;

}

/**
* fnGridDupValidation(gridId, dupKeys)
* 작성자   : KSM
* 작성일자 : 2015-10-30
* 개요    : grid object의 중복값 입력 체크
* return  : true/false
*/
function fnGridDupValidation(gridId, dupKeys){
	var $grid = $("#"+gridId);
	var intDupChk = 0;
	var strKey = dupKeys.split(",");
	var rows = $grid.getDataIDs();

	for(var i=0; i<rows.length; i++){
		for(var j=1+i; j<rows.length; j++){
			intDupChk = 0;
			 for (var k = 0, o=strKey.length; k<o; k++) {
			          if (($grid.getCell(rows[i], strKey[k]) == $grid.getCell(rows[j], strKey[k]))) {
			        	  intDupChk++;
			          }
			      }
			 if (intDupChk == strKey.length){
				 alert((i+1) +" 행과 " + (j+1) + " 행이 중복됩니다.");
				 return false;
			 }
		}
	}

   return true;

}

/**
* fnCharTypeChk(data, types)
* 작성자   : HYUK JUN
* 작성일자 : 2015-11-08
* 개요    : 입력 가능한 문자열 체크
* 파라미터 : data - '문자열'
* 				types - 입력 가능 문자열 타입 Array
* 						- var types = new Array(); - 영문, 숫자만 가능인 경우
								types[0] = "en";
								types[1] = "num";
* return  : true/false
*/
function fnCharTypeChk(data, types)
{
	 for(var i = 0; i < data.length ; i++){
		 var validStr = false;
		 var str = data.substr(i,1);
		 for (var j = 0; j < types.length; j++) {
			 var regG = '';
			 if (types[j] == "kr") {
				 regG = /[-a-zA-Z0-9`~!@#$%^&*()<>{},.?/'"_=+\\|\[\]\:;]/;
				 if(!regG.test(str)){
					 //한글인 경우
					 validStr = true;
					 break;
				 }
			 }else if (types[j] == "en"){
				 regG = /[-a-zA-Z]/;
				 if(regG.test(str)){
					 //영문인 경우
					 validStr = true;
					 break;
				 }
			 }else if (types[j] == "num"){
				 regG = /[0-9]/;
				 if(regG.test(str)){
					 //숫자인 경우
					 validStr = true;
					 break;
				 }
			 }
		 }
		 if (validStr == false) {
			return false;
		}
	 }
	 return true;
}

/*****************************************************************
 * extend custom formter/unformat
 * colModelType : custom 선언
 * customParam  : customParam : {
 * 									[colModelName] : {
 * 										formatter  : [ function ]
 * 										unformat   : [ function ]
 * 									}
 * ex)
 * customParam : {
 *				closeFlag : {
 *					formatter : customCloseFlagFmt
 *				},
 *				saleOccuYyyymm : {
 *					formatter : customDataYyyyMmFmt,
 *					unformat: customDataYyyyMmUnfmt
 *				},
 *				postYyyymm : {
 *					formatter : customDataYyyyMmFmt,
 *					unformat: customDataYyyyMmUnfmt
 *				}
 *			},
 *****************************************************************/
/*
 * GRID formater
 * YYYYMM TO YYYY-MM
 */
function customDataYyyyMmFmt(cellvalue){
	cellvalue = nvl( cellvalue, "");
	if( cellvalue != ""){
		return cellvalue.substring( 0,4) + "-" + cellvalue.substring( 4,6);
	}
	return "";
}
/**
 * GRID unformat
 * YYYY-MM TO YYYYMM
 */
function customDataYyyyMmUnfmt(cellvalue){
	cellvalue = nvl( cellvalue, "");
	return cellvalue.replaceAll("-", "");
}

/*
 * GRID formater
 * YYYYMMDD TO YYYY-MM-DD
 */
function customDataYyyyMmDdFmt(cellvalue){
	cellvalue = nvl( cellvalue, "");
	if( cellvalue != ""){
		return cellvalue.substring( 0,4) + "-" + cellvalue.substring( 4,6) + "-" +  cellvalue.substring( 6,8);
	}
	return "";
}


/**
 * GRID unformat
 * YYYY-MM-DD TO YYYYMMDD, YYYY-MM TO YYYYMM
 */
function customDataDateUnfmt(cellvalue){
	cellvalue = nvl( cellvalue, "");
	return cellvalue.replaceAll("-", "");
}


/**
 * 파라미터 Merge
 * 예) getMergedObject($("#frm").serializeObject(),{Include:vInclude, SAL_BNS_TYPE_SCH:vSAL_BNS_TYPE}),
 */
function getMergedObject(obj){
	var ret = {};
	for(var i=0; i < arguments.length; i++){
		$.extend(true, ret, arguments[i]);
	}
	return ret;
}


/**
 * 그리드내 컬럼명으로 컬럼위치(순서)찾기
 * @param grid 해당 그리드
 * @param columnName 컬럼명(colModelName)
 */
function fnGetColumnIndexByName (grid, columnName) {
	var cm = grid.jqGrid('getGridParam', 'colModel'), i, l;
	for (i = 1, l = cm.length; i < l; i += 1) {
	  if (cm[i].name === columnName) {
	  	return i; // return the index
	  }
	}
	return -1;
};

/**
 * serializeArray >> serializeObject 변환
 * @param sdata serializeArray()데이터
 */
function fnGetArrayToObject (sdata) {
	var o = {};
	$.each(sdata, function() {
        if (o[this.name] !== undefined) {
            if (!o[this.name].push) {
                o[this.name] = [o[this.name]];
            }
            o[this.name].push(this.value || '');
        } else {
            o[this.name] = this.value || '';
        }
    });
	return o;
}


/*******************************************************************************************
 * TRANSACTION 데이터를 전송/저장하는 함수.
 * 예)
 * var param = {
		// 서비스ID - 사용자정의 콜백을 여러 함수가 공유할 때 분기 플래그로서 사용.
		svcId : 'closeMarket',
		strUrl: '/sale/saveCloseMarkets.do',
 		inDs : {
 			//전송할 데이터셋
 			// 그리드  또는
 			// 데이터 셋var ds_data = [{ id:'aaa', name:'bbb'}, {id:'ccc', name:'ddd'}]
 			// ds_data  	:	ds_data
 			closeMarketCdList : closeMarketCdList
 		},
		// 전송할 파라미터. 기본적으로 form의 전체 데이터수 조회 플래그(DO_COUNTTOT)와 form1의 데이터를 전송한다.
		//param : getMergedObject($("#frm").serializeObject(),{Include:vInclude, SAL_BNS_TYPE_SCH:vSAL_BNS_TYPE}),	//getMergedObject({DO_COUNTTOT:"false", LABL_DIV:0, MENU:vMenu, LANG:vLang}),
		param : {},//{closeMarketCodes:closeMarketCds},	//getMergedObject({DO_COUNTTOT:"false", LABL_DIV:0, MENU:vMenu, LANG:vLang}),
		// 조회 콜백 함수
		pCall : saveCallback,
		// 실행 이미지
		pLoad : true
	};

	transaction(param);

	//saveCallback
	function saveCallback(svcId, data, errCd, msgTp, msgCd, msgText){
	 	if(errCd != ERR_CD_SUCCESS){
	 		if( svcId == "closeMarket"){
	 			alert( "마감 처리를 실패 하였습니다.");
	 		}else if( svcId == "openMarket"){
	 			alert( "마감 취소를 실패하였습니다.");
	 		}
	 		return;
	 	}
	 	// 그리드 정보 bind
	 	if( svcId == "closeMarket"){
	 		alert( "마감 처리를 성공하였습니다.");
	 	}else if( svcId == "openMarket"){
			alert( "마감 취소를 성공하였습니다.");
		}

	 	fnSelectList();
	}

	*java
	*예) 파라미터와 그리드 데이터 셋 테스트는 아직 안함
	* paramVo.putAll( JsonUtil.saveJsonStringToEgovMap(paramMap.get("data").toString()));

 */
//로딩이미지 제어를 위한 변수 (ajax call이 발생할 때 마다 (+)해 주고 ajax complete시 (-)해서, complete시 0이 되면 로딩이미지를 닫는다.)
var ajaxCallCount = 0;

var	loaderPath = "/images/common/loding.gif";
/**
 *  ajax 호출 결과가 성공일 경우 응답의 ErrorMsg 값.
 */
var ERR_CD_SUCCESS = "0";	//ajax 호출 결과가 성공일 경우 응답의 ErrorMsg 값.
var ERR_CD_NO_AUTH = "-10";	//ajax 호출시 세션이 만료되었을 경우

/**
 * 	메세지 추출시 키값 정의
 */
var ERROR_CODE 			= "errorcode";			//수행결과 코드
/**
 *
 */
var MESSAGE_CODE 		= "SVC_MSG_CD";			//메세지 코드( 미사용)

var MESSAGE_TEXT 		= "SVC_MSG_TEXT"; 		//메세지( 미사용)
var ERROR_MESSAGE_CODE 	= "SVC_ERR_MSG_CD";		//에러메세지 코드( 미사용)
var ERROR_MESSAGE_TEXT 	= "SVC_ERR_MSG_TEXT";	//에러메세지(미사용)
var STATUS_MESSAGE_CODE = "SVC_STS_MSG_CD";		//상태바 메세지 코드( 미사용)
var STATUS_MESSAGE_TEXT = "SVC_STS_MSG_TEXT"; 	//상태바 메세지( 미사용)


function transaction(o){
	console.log("== Call transaction 0000000000000000000000000000000 start ==");
	//전송할 데이터 셋팅
	var data = {};
	//$.extend(data, o.param, o.inDs);

	console.log('---------- transaction data - start ----------');
	console.log(JSON.stringify(data));	//디버깅용 전송 파라미터 출력
	console.log('---------- transaction data - end -----------');
	// 그리드 또는 data set과 파라미터를 별개로 보낸다.
	data = {
			data : JSON.stringify(o.inDs),
			param : JSON.stringify(  o.param)
	};

	//call ajax
	$.ajax({

		url : o.strUrl,
		data : data,
		dataType : "json",
		type : "POST",
		contentType : "application/x-www-form-urlencoded;charset=utf-8",
		//contentType : "application/json",

		//async: false,
//		url : o.strUrl,
//		data : JSON.stringify(data),
//		type : "POST",
//		contentType : "application/json",
//		dataType : 'json',
		beforeSend : function(jqXHR, settings){
			console.log("transaction() beforeSend : " + jqXHR);
			openLoadingImage({pLoad: o.pLoad});	//로딩이미지 노출

			//jqXHR.setRequestHeader("Method", "POST");
			//console.log("transaction() beforeSend 1");
			//jqXHR.setRequestHeader("Content-Type", "application/x-www-form-urlencoded; charset=\"utf-8\";");
			//jqXHR.setRequestHeader("Content-Type", "application/json; charset=\"utf-8\";");
			//console.log("transaction() beforeSend 2");
		},
		complete: function(jqXHR, status) {
			console.log("transaction() complete : " + jqXHR.responseText);
			console.log("transaction() complete : " + status);

			closeLoadingImage();

            if ("success" == status) {
                console.log("transaction() complete SUCCESS:" + jqXHR.responseText);
            }

			var returnData;
			try{
				console.log("transaction() complete returnData1");
				returnData = JSON.parse(jqXHR.responseText);

				console.log("transaction() complete returnData:=" + returnData);
				//console.log("transaction() complete returnData.rows.data[0].POPUP:=" + returnData.rows.data[0].POPUP);

			}catch(e){
				console.log("transaction() complete returnData catch:" + e);
				returnData = {ERROR_CODE:-1,ERROR_MESSAGE_CODE: '-1', ERROR_MESSAGE_TEXT: ''};
			}

			//ajax 응답객체로부터 수행결과코드 및 출력해 주어야할 메세지를 선별하여 리턴.
			console.log("==transaction : getReturnMsg(retMsg)");
			var retMsg = getReturnMsg(returnData);
			//선별된 메세지를 타입에 맞추어 출력(alert or footer출력 등)
			//console.log("==transaction : outMessage(retMsg)");
			//outMessage(retMsg);

			//console.log("==transaction : if(retMsg.errCd == ERR_CD_NO_AUTH){");
			//세션 만료시 : 권한없음 에러코드일 경우 에러페이지로 페이지 이동 ERR_CD_NO_AUTH : -10
			if(retMsg.errCd == ERR_CD_NO_AUTH){
				console.log(" if(retMsg.errCd == ERR_CD_NO_AUTH){");
				//console.log("==transaction : "+ERR_CD_NO_AUTH);
				//goSessionExpiredPage({alert:false}); //outMessage()에서 alert처리를 하므로 false로 셋팅
			}

			//사용자정의 콜백 실행
			//if((retMsg.errCd == ERR_CD_SUCCESS) && $.isFunction(o.pCall)){
			//console.log("transaction : if($.isFunction(o.pCall)){ :" + o.pCall);
			if($.isFunction(o.pCall)){ //사용자정의 에러처리를 해야 할 수도 있기 때문에 수정함
				//console.log("transaction : o.pCall(o.svcId, returnData, retMsg.errCd, retMsg.msgTp, retMsg.msgCd, retMsg.msgText)");
				o.pCall(o.svcId, returnData, retMsg.errCd, retMsg.msgTp, retMsg.msgCd, retMsg.msgText);
			}
        },
        error : function(jqXHR, textStatus, errorThrown){
			console.log("error");
			closeLoadingImage();
			// 세션만료
			 if (jqXHR.status == 401) {

			 		console.log( "세션 만료");
				 	//alert("로그인 세션이 만료되었습니다. (staus : " + jqXHR.status+ ", " + errorThrown + ")");
				 	//alert( getMessage("MSG_89040"));
					//var t = getTopWindow(window);
					//var loginUrl = contextPath + "/sy/web/loginPage.do";

					//if(t.opener) {
					//	t.opener.parent.location.href = loginUrl;
					//	t.close();
					//} else {
					//	t.parent.location.href = loginUrl;
					//}

			// 권한없음
			 } else if (jqXHR.status == 403) {
				 console.log( "권한없음");
				 alert( "권한없음");
			  	//alert( getMessage("MSG_80010"));

			} else {
				if( nvl(errorThrown, "") == "" && jqXHR.status == 0){
					alert("서버와 연결이 끊어졌습니다. \n 로그인 화면으로 이동합니다.");
					console.log( "서버와 연결이 끊어졌습니다.");
					/* alert( getMessage("MSG_89050"));
					var t = getTopWindow(window);
					var loginUrl = contextPath + "/sy/web/loginPage.do";

					if(t.opener) {
						t.opener.parent.location.href = loginUrl;
						t.close();
					} else {
						t.parent.location.href = loginUrl;
					} */
				}else{

					console.log( " 요청 작업을 실패하였습니다.");
					alert("요청 작업을 실패하였습니다.  \n계속 발생시 시스템 관리자에게 문의하시기 바랍니다.");
					alert("Service Temporarily Unavailable (staus : " + jqXHR.status+ ", " + errorThrown + ")");
					//alert( getMessage("MSG_80270"));
				}

			}
        }

	});

}

/**
* 	로딩이미지 노출
* 	- ajaxCallCount 전역변수에 종속성을 가지고 있다.
*/
function openLoadingImage(o){
	console.log('==Call openLoadingImage start');
	console.log('@@ ajaxCallCount:'+ajaxCallCount);
	console.log('@@ o.pLoad :'+ o.pLoad);
	if(o && o.pLoad && ajaxCallCount <= 0){

		//로딩이미지 파일의 height 값을 입력한다.
		var imgHeight = o.imgHeight ? o.imgHeight : 35;

		//-------------------- 로딩이미지 수직위치 보정 - start -----------------------
		//프레임셋 혹은 상위 프레임에서 현재 페이지의 위쪽으로 점유하고 있는 높이가 있다면 로딩이미지의 수직 위치 지정시
		//해당 값들을 감해 주어야 한다. 이 보정값들은 프레임셋을 구성하고 있는 페이지(ex: viewMain.jsp), 혹은 iframe을 포함하고
		//있는 페이지(ex: statisticsWrapper.jsp)에 LOADIMG_OFFSET_Y 라는 이름의 변수로 지정되어 있다고 가정한다.
		//또한 부모 window가 스크롤바를 가지고 있다면 해당 window의 scrollTop에 대한 보정 작업도 해 주어야 한다.
		var offsetObj = getRecursiveParentOffset(window);

		//상위 window들이 현재 페이지의 위쪽을 차지하는 만큼의 height 합 (<=0)
		var offset = offsetObj.offset;

		//상위 window들이 가지고 있는 scrollTop의 합
		var scrollTop = offsetObj.scrollTop;
		//-------------------- 로딩이미지 수직위치 보정 - end -----------------------

		var $winTop = $(getTopWin(window)); //topmost window

		//브라우저에서 눈에 보이는 영역(viewport, 스크롤바 제외)의 height (Opera는 예외적으로 값을 얻어와야 한다.)
		var winTopHeight = getBrowser() != 'OPERA' ? $winTop.height() : $winTop[0].innerHeight;

		//로딩이미지가 뿌려질 top position
		var loaderTop = (winTopHeight / 2) - (imgHeight / 2) + offset + scrollTop;

		console.log('@@ winTopHeight: '+winTopHeight+', imgHeight: '+imgHeight+', offset: '+offset+', scrollTop: '+scrollTop+', loaderTop: '+loaderTop);

		var imgPath = o.imgPath ? o.imgPath : loaderPath;	//loaderPath는 includeJavaScript.jsp에 정의되어 있음.


		console.log('@@ imgPath : ' + imgPath);
		console.log('@@ loaderTop : ' + loaderTop);

		$.blockUI({
			message: '<img src="'+ imgPath +'" />',
			//메세지(로딩이미지를 감싸고 있는 box)영역에 대한 css
	        css: {
	        	top: loaderTop,
	       	    border: 'none',
	       	    backgroundColor: 'transparent',
	       	    opacity: 1 //로딩이미지 자체는 온전히 보여야 한다.
	       	},
	        //오버레이영역에 대한 css
		    overlayCSS:  {
		        opacity: 0,	//오버레이가 덮지 않는 것 처럼 보이면서 block한다.
		        cursor: 'wait' //오버레이영역의 커서 모양
		    }
		});

	}
	ajaxCallCount++;
	console.log('==Call openLoadingImage end');
}

/**
 * 	현재 브라우저 정보를 리턴한다.
 */
function getBrowser(){
	
	var agent = navigator.userAgent.toUpperCase();
	
	if(agent.indexOf('MSIE') >= 0){
		if(agent.indexOf('MSIE 7.0') >= 0){
			return 'IE_7';
		}else if(agent.indexOf('MSIE 8.0') >= 0){
			return 'IE_8';
		}else if(agent.indexOf('MSIE 9.0') >= 0){
			return 'IE_9';
		}else{
			return 'IE'; //기타 버전
		}
	}else if(agent.indexOf('FIREFOX') >= 0){
		return 'FIREFOX';
	//크롬과 사파리는 같이 웹킷을 사용하기 때문에 크롬을 찾는 구문이 위에 있어야 한다.
	}else if(agent.indexOf('CHROME') >= 0){
		return 'CHROME';
	}else if(agent.indexOf('SAFARI') >= 0){
		return 'SAFARI';
	}else if(agent.indexOf('OPERA') >= 0){
		return 'OPERA';
	}
}


/**
* 	로딩이미지 닫기
* 	- ajacCallCount 전역변수에 종속성을 가지고 있다.
*/
function closeLoadingImage(){
	console.log("==Call closeLoadingImage start ==");
	console.log('ajaxCallCount:'+ajaxCallCount);
	ajaxCallCount--;
	if(ajaxCallCount <= 0){
		$.unblockUI();
	}
	console.log('ajaxCallCount:'+ajaxCallCount);
	console.log("==Call closeLoadingImage end ==");
}

/**
 *	접근할 수 없는 윈도우 객체일 경우 true를 리턴한다.
 *
 *		자바스크립트에서는 다른 도메인의 window객체의 프로퍼티에 접근하는 것을 원칙적으로 금하고 있다.
 *		parent나 opener를 참조하려 할 때 parent나 opener가 다른 도메인의 소속일 경우 이런 상황을 만날 수 있는데,
 *		이럴 때 스크립트 에러로 인해 페이지가 멈추는 것을 막기 위해, 일부러 에러를 발생시킨 후 try~catch로 감싸주어
 *		접근 가능여부를 판별해서, 타 도메인 문서의 참조 가능성을 미연에 방지하도록 처리했다.
 *		타 도메인 윈도우의 프로퍼티를 참조하는 것은 대부분의 브라우저에서는 에러로 처리하지만,
 *		유독 webkit 계열에서는 에러로 처리되지 않는다. 그러므로 좀 더 확실한 에러발생 조건을 만들기 위해서 getElementById를 사용하였다.
 *
 *	@param w window객체
 */
function isInaccessibleWin(w){
	try{
		w.document.getElementById('');
	}catch(e){
		dc('@ window 프로퍼티 접근 불가 - 다른 도메인의 parent나 opener를 참조했을 수 있음');
		return true; //접근 불가
	}
	return false;
}

/**
 * 	최상위 윈도우가 다른 도메인에 존재할 경우 window.top 프로퍼티를 사용하면 접근에러가 발생하므로,
 *	다른 방식으로 topmost window 객체를 리턴하기 위해 만든 함수.
 */
function getTopWin(o){
	console.log('call getTopWin('+o+')');

	var p = o.parent;

	//재귀호출을 멈추는 조건 1 - (parent == self)
	if(p === o){
		console.log('@ parent가 self와 같으므로 재귀호출 종료 > return window name: '+o.name);
		return o;

	}else{

		//재귀호출을 멈추는 조건 2 - 현재 레벨의 parent가 다른 도메인 소속일 경우
		if(isInaccessibleWin(p)){
			console.log('@ parent가 다른 도메인 소속이므로 재귀호출 종료');
			return o;
		}

		//재귀호출
		return getTopWin(p);
	}

}


/**
 *		최상위 parent window까지 거슬러 올라가면서
 *		(1) 현재 window의 위쪽을 점유하고 있는 parent들의 height의 합을 리턴한다.
 * 		(2) parent들의 scrollTop을 리턴한다.
 * 			 실험 결과, 자기 자신 (window.self)의 scrollTop()은 보정값으로 넣지 않아야 정상적으로 동작했다.
 */
function getRecursiveParentOffset(o, po){

	//param object 초기화
	if(po == null){
		po = {};
		po['offset'] = 0;
		po['scrollTop'] = 0;
		po['lvl'] = 0; //레벨은 디버깅만을 위한 변수임.
	}
	console.log('@ getRecursiveParentOffset() > offset: '+po.offset+', scrollTop: '+po.scrollTop+', lvl: '+po.lvl);

	var p = o.parent;

	//재귀호출을 멈추는 조건 1 - (parent == self)
	if(p === o){
		console.log('@ parent가 self와 같으므로 재귀호출 종료 > window.name: '+ o.name);
		return po;

	}else{

		//재귀호출을 멈추는 조건 2 - 현재 레벨의 parent가 다른 도메인 소속일 경우
		if(isInaccessibleWin(p)){
			console.log('@ parent가 다른 도메인 소속이므로 재귀호출 종료');
			return po;
		}

		po['lvl']++;

		//scrollTop 더하기
		var pScrollTop = $(p).scrollTop();
		console.log('@@ parent '+po.lvl+' depth scrollTop: '+pScrollTop);
		po['scrollTop'] += pScrollTop;

		//LOADIMG_OFFSET_Y 더하기
		var pOffsetY = p.LOADIMG_OFFSET_Y;
		if(pOffsetY){
			po['offset'] += pOffsetY;
			console.log('@@ parent '+po.lvl+' depth LOADIMG_OFFSET_Y: '+pOffsetY);
		}

		return getRecursiveParentOffset(p, po); //재귀호출
	}

}

/**
 * Return Code 처리
 * return Code 만 사용중
 */
function getReturnMsg(returnData){
	//응답 객체에서 메세지 값을 읽어들이며 메세지를 조회해서 어떤 메세지를 뿌려주어야 할 지 정하고 메세지타입을 결정한다.
	//메세지 타입은 동시에 존재할 수 없고 한 요청에 하나만 존재할 수 있다. 그러므로 이 중에서 한 set의 msgTp, msgCd, msgText만 출력 대상이 된다.
	var errCd, normalMsgCd, normalMsgText, statusMsgCd, statusMsgText, errMsgCd, errMsgText, msgTp, msgCd, msgText;

	errCd 			= returnData[ERROR_CODE]; 					//결과 코드
	errMsgCd 		= returnData[ERROR_MESSAGE_CODE];	//에러메세지 코드
	errMsgText 		= returnData[ERROR_MESSAGE_TEXT];		//에러메세지
	normalMsgCd 	= returnData[MESSAGE_CODE];				//메세지 코드
	normalMsgText = returnData[MESSAGE_TEXT];				//메세지
	statusMsgCd 	= returnData[STATUS_MESSAGE_CODE];	//상태메세지 코드
	statusMsgText = returnData[STATUS_MESSAGE_TEXT];	//상태메세지

	if(errMsgCd !=null && errMsgCd.length > 0){
		msgTp = MSG_TP_ERR;	msgCd = errMsgCd; msgText = errMsgText;
	}else if(normalMsgCd !=null && normalMsgCd.length > 0){
		msgTp = MSG_TP_MSG;	 msgCd = normalMsgCd; msgText = normalMsgText;
	}else if(statusMsgCd !=null && statusMsgCd.length > 0){
		msgTp = MSG_TP_STATUS; msgCd = statusMsgCd; msgText = statusMsgText;
	}

	console.log( '====Call getReturnMsg errCd : '+errCd+'\nmsgTp:'+msgTp+'\nmsgCd:'+msgCd+'\nmsgText:'+msgText);
	return {errCd:errCd, msgTp:msgTp, msgCd:msgCd, msgText:msgText};
}

/**
 * Transaction End
 *******************************************************************************************/

/**
 * fnNumFormat(strNum, intLen)
 * 개    요 : 숫자 자리수 포맷-자릿수에 맞게 '0'를 채움
 * return값 : string
 */
 function fnNumFormat(strNum, intLen) {
     var strTmp = '' + strNum;
     var intLenNum = strTmp.length;
     var strRtnNum = '';

     if (intLenNum > intLen)
         return strTmp;

     for(i=0;i<intLen-intLenNum;i++) {
         strRtnNum = strRtnNum + '0';
     }

     return strRtnNum + strTmp;
 }

/**
 * fnGetRawData(strData)
 * 개    요 : 입력값에서 구분자인 '/', '.', '-',':' 등을 제거하여 리턴
 * return값 : string
 */
 function fnGetRawData(strData) {
     if (strData==null || strData == "")
         return "";
     strData = strData.replace(/\//g,"");
     strData = strData.replace(/-/g,"");
     strData = strData.replace(/\./g,"");
     strData = strData.replace(/\:/g,"");
     return strData;
 }

 /* html tag 제거 */
 function strip_tags (input, allowed) {
     allowed = (((allowed || "") + "").toLowerCase().match(/<[a-z][a-z0-9]*>/g) || []).join(''); // making sure the allowed arg is a string containing only tags in lowercase (<a><b><c>)
     var tags = /<\/?([a-z][a-z0-9]*)\b[^>]*>/gi,
         commentsAndPhpTags = /<!--[\s\S]*?-->|<\?(?:jsp)?[\s\S]*?\?>/gi;
     return input.replace(commentsAndPhpTags, '').replace(tags, function ($0, $1) { return allowed.indexOf('<' + $1.toLowerCase() + '>') > -1 ? $0 : '';
     });
 }


/**
 * fnAddDate(strFlg,intDiff,strCheckDate)
 * 개    요 : 년, 월, 일 에대한 i만큼의 전후 날짜 계산
 * 인    수 : 1. strFlg  : 구분 ("y":년, "m":월, "d":일)
 *            2. i       : (-i:before, +i:after) difference value
 *            3. strCheckDate : 날짜
 *            4. Delimitor : 구분자 기본값('-')
 * return값 : string YYYY-MM-DD
 */
 function fnAddDate(strFlg, i, strCheckDate, Delimitor) {

 	Delimitor = Delimitor==null?"-":Delimitor;
 	strCheckDate = fnGetRawData(strCheckDate);

 	var dateTypeVal = new Date(strCheckDate.substring(0,4),strCheckDate.substring(4,6)-1,strCheckDate.substring(6,8));

 	var retDate;

 	var nWeekDay=dateTypeVal.getDay();

 	if (strFlg.toUpperCase() == "Y") {
 		retDate = new Date(dateTypeVal.getFullYear() + eval(i),dateTypeVal.getMonth(),dateTypeVal.getDate());
 	}
 	else if (strFlg.toUpperCase() == "M") {
 		retDate = new Date(dateTypeVal.getFullYear(),dateTypeVal.getMonth() + eval(i),dateTypeVal.getDate());
 	}
 	else if (strFlg.toUpperCase() == "D") {
 		retDate = new Date(dateTypeVal.getFullYear(),dateTypeVal.getMonth(),dateTypeVal.getDate() + eval(i));
 	}
 	else{
 		retDate = new Date(dateTypeVal.getFullYear(),dateTypeVal.getMonth(),dateTypeVal.getDate());
 	}

 	return retDate.getFullYear() + Delimitor + fnNumFormat(retDate.getMonth()+1,2) + Delimitor + fnNumFormat(retDate.getDate(),2);
 }
 /*************************************
  * 전자 증빙
  *
  * @returns {String}
  */
 /*************************************
  * 전자 증빙
  * fnOpi(opiNo , eidtMode)
  * opiNo : 증빙번호, 
  * editMode : 모드 : 뷰어권한 EDIT(편집모드), VIEW(읽기전용모드), 
  * @returns {String}
  */
 function fnOpi(opiNo , eidtMode){
	 if(isNull(eidtMode)){
		 eidtMode = "EDIT";
	 }
	 var nRes ="";
	 $.ajax({
	 	 type : "POST",
	 	 url : "/cmmn/selectOpiCmnd.do",
	 	 data : {"opiNo" : opiNo},
	 	 async : false,
	 	 dataType: "json",
	 	 contentType: "application/x-www-form-urlencoded;charset=utf-8",
	 	 error : function(x, e, data) {
	 	 	 var cd = x.status;
	 	 	 if(cd == 0){
	 	 	 	cd = 990;
	 	 	 }
	 	 	 else if (e == 'parsererror') {
	 	 	 	cd = 991;
	 	 	 } else if (e == 'timeout') {
	 	 	 	cd = 992;
	 	 	 } else if(cd !=404 && cd != 500){
	 	 	 	cd = 999;
	 	 	 }
	 	 	 
	 	 	 var alertMsg = "code:"+x.status+"\n"+"message:"+x.responseText+"\n"+"error:"+data;
	 	 	 fnErrorMsg(cd, alertMsg, data);
	 	 },
	 	 success : function(data) {
	 	    nRes = data.jdocNo;
	 	    fnOpiPop(data, eidtMode);
	 	 }
	 });
	 
	 return nRes;
}

 /**
  * 증빙연계
  * @param data
  * @param eidtMode
  */
 var opiPop;
 function fnOpiPop(data, eidtMode){
 	/*var url = data.opiUrl+"/index.jsp";//?JdocNo=1234567890&SvrMode=PRD&ViewMode=EDIT";
 	var param = "?JdocNo="+data.jdocNo+"&SvrMode="+data.svrMode+"&ViewMode="+eidtMode;
 	var paramVal = {};
 	url = url+param;
 	var popupOpt ="dialogWidth:700px;dialogHeight:800px;scroll:no;status:no;center:yes;resizable:yes;";
 	var retVal = window.showModalDialog(url, paramVal, popupOpt, "fnOpenBack");
 	*/
 	var url = data.opiUrl+"/index.jsp";
 	var param = "?JdocNo="+data.jdocNo+"&SvrMode="+data.svrMode+"&ViewMode="+eidtMode;
 	url = url+param;
 	opiPop = window.open(url,"전자증빙",'toolbar=no, location=no, directories=no, status=no, menubar=no, scrollbars=no, resizable=no, copyhistory=no, width=750, height=800, top=100, left=100');
 }
/**
 * 파일 다운로드
 * @param mode      - M : 양식  , N : 일반
 * @param fileName  - 필수 
 * @param filePath  - 파일 위치 (N일땐 필수)
 */
function fnComnFileDownd(mode, fileName, filePath){
    //data can be string of parameters or array/object
    //split params into form inputs
	if(isNull(fileName)){
		alert("파일명을 입력하세요");
		return false;
	}
	if(mode != "M" && isNull(filePath)){
		alert("경로가 잘못되었습니다.");
		return false;
	}
    var url ="";
    var inputs = '';
    inputs += '<input type="hidden" name="mode" value="'+mode+'" />';
    inputs += '<input type="hidden" name="fileName" value="'+fileName+'" />';
    inputs += '<input type="hidden" name="filePath" value="'+filePath+'" />';
    //send request
    jQuery('<form action="/cmmn/downloadFile.do" method="post">' + inputs + '</form>').appendTo('body').submit().remove();
}


/**
 * 전자결재 팝업
 * @param data
 */


var elecPop;
function fnElecAppvPop(data){
	var bChk = true;
	if(typeof(elecPop)=='undefined' || elecPop.closed){
		bChk = false;
	}
	if(bChk){
		elecPop.close();
	}
	var url = data.url + "/ConLogin.aspx?mode=DRAFT";
	var param = "&userid="+data.emplId+"&gubun="+data.gubun+"&ConnKey="+data.ConnKey
	url = url+param;
	elecPop = window.open(url,"기안",'toolbar=no, location=no, directories=no, status=no, menubar=no, scrollbars=no, resizable=no, copyhistory=no, width=1000, height=700, top=100, left=100');
	
}
/**
 * 전자 결재 팝업창 열려있는지 확인
 * @returns {Boolean}
 */
function fnElecAppvPopOpenChk(){

	if(typeof(elecPop)=='undefined' || elecPop.closed){
		return false;
	}
	return true;
}
/**
 * 전자결재 팝업창 종료
 */
function fnElecAppvPopClose(){
	
	elecPop.close();
}

/**
 * 전자 결재 팝업창 활성화 
 */
function fnElecAppvPopfocus(){
	
	elecPop.focus();
}

/**
 * 전자 결재 재 상신 - 품의 번호 있을 경우.
 * @param rprtMakeCd
 */
function fnReElecAppvPop(rprtMakeCd){
	var bChk = true;
	if(fnElecAppvPopOpenChk()){
		fnElecAppvPopClose();
	}
	//if(typeof(elecPop)=='undefined' || elecPop.closed){
	$.ajax({
	 	 type : "POST",
	 	 url : "/cmmn/selectElecAppv.do",
	 	 data : {"rprtMakeCd" : rprtMakeCd},
	 	 async : false,
	 	 dataType: "json",
	 	 contentType: "application/x-www-form-urlencoded;charset=utf-8",
	 	 error : function(x, e, data) {
	 	 	 var cd = x.status;
	 	 	 if(cd == 0){
	 	 	 	cd = 990;
	 	 	 }
	 	 	 else if (e == 'parsererror') {
	 	 	 	cd = 991;
	 	 	 } else if (e == 'timeout') {
	 	 	 	cd = 992;
	 	 	 } else if(cd !=404 && cd != 500){
	 	 	 	cd = 999;
	 	 	 }
	 	 	 
	 	 	 var alertMsg = "code:"+x.status+"\n"+"message:"+x.responseText+"\n"+"error:"+data;
	 	 	 fnErrorMsg(cd, alertMsg, data);
	 	 },
	 	 success : function(data) {
	 		var url =  "";
	 			
	 		var param = "";
	 		
	 		url = data.url + "/ConLogin.aspx?mode=DRAFT";
	 		param = "&userid="+data.emplId+"&gubun="+data.gubun+"&ConnKey="+data.ConnKey;
	 		url = url+param;
	 		elecPop = window.open(url,"기안",'toolbar=no, location=no, directories=no, status=no, menubar=no, scrollbars=no, resizable=no, copyhistory=no, width=1000, height=700, top=100, left=100');
	 	 }
	 });
	//}
	//else{
	//	fnElecAppvPopfocus();
	//}	
}


/**
 * 파일명 가져오기
 * @param fileName
 * @returns
 */
function getFileName(fileName) {
	if (fileName) {
		if (fileName.length > 0) {
			var idx = fileName.lastIndexOf("\\");
			if (idx > -1) {
				return fileName.substring(idx + 1);
			}
		}
	}
	return "";
}

