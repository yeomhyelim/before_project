function C_getCheckAll(val,target){
	var doc = document.form;
	
	if (C_isNull(target))
	{
		target = "chkNo[]";
	}
	var obj = doc[target];
	
	if(!C_isNull(obj) && !C_isNull(obj.length)){
		if (obj.length>0){
			for (i=0; i<=obj.length-1; i++){
				obj[i].checked=val;
			}
		}else{
			obj.checked=val;
		}
	} else {
		obj.checked = val;
	}
	return true;
}

function C_getMultiCheck(mode,act,msg){
	var doc = document.form;		
	var val = C_getCheckedCode(doc["chkNo[]"]);
		
	if (C_isNull(msg))
	{
		msg = "데이터를 선택해주세요.";
	}
	if(val==""){
		alert(msg);
		return;
	}else{
		C_getAction(mode,act);
	}
}

function C_getAjax(mode,act){
	var doc = document.form;

	doc.act.value = mode;
	doc.mode.value = act;
	
	var formData = $("#form").serialize();

	C_AjaxPost(mode,"./index.php",formData,"post");	
}

function C_getExcel(url){
	var doc = document.form;
	
	doc.action = url;
	doc.method = "post";
	doc.submit();
}

function C_getZip(num){
	window.open('../pop/address.php?num='+num,'new','width=480px,height=330px,menubar=no,location=no,scrollbars=yes,status=no,resizable=no'); 
}

//날짜문자열을 인자2만큼의 이전 달을 구한다.
function C_agoMonth(AddMonth,dateType)
{
	var aoDate = new Date();
	
	var year  = aoDate.getFullYear();
	var month = aoDate.getMonth() + 1 + (AddMonth); // 1월=0,12월=11이므로 1 더함
	var day   = aoDate.getDate();
		
	var lastDay = 32 - ( new Date(year,month,33).getDate());
	var day = (day > lastDay) ? lastDay : day;

	if (month <= 0)
	{
		year	= year - 1;
		month	= (12 + month);
	}

    if (("" + month).length == 1) { month = "0" + month; }
	if (("" + day).length   == 1) { day   = "0" + day;   }
	

	if (dateType == "Ymd")
	{
		return ("" + year + "-" + month + "-" + day);
	} else {
		return ("" + year + "-" + month);
	}
}


function C_agoMonthFirstDay(AddMonth)
{
	return C_agoMonth(AddMonth,"Ym") + "-01";
}

function C_agoMonthLastDay(AddMonth)
{
	var intLastDay = C_getEndDay(C_agoMonth(AddMonth) + "-01");
	
	return (C_agoMonth(AddMonth,"Ym") + "-" + intLastDay);
}

function C_getSearchDay(gb,mode,type,objStartDt,objEndDt){
	var loadDt = new Date(); //현재 날짜 및 시간

	var sDate	= "";
	var eDate	= "";
	var nYear	= "";
	var nMonth	= "";
	var nDay	= "";
	var doc = document.form;
	
	if (C_isNull(type))
	{
		
		with(doc){
			switch(gb){
				case "T":
					sDate= C_getNowDateString(10);
					eDate= C_getNowDateString(10);
				break;
				case "1":
					
					sDate=C_agoDay(C_getNowDateString(10),7);
					eDate=C_getNowDateString(10);

				break;
				case "2":
					sDate=C_agoDay(C_getNowDateString(10),15);
					eDate=C_getNowDateString(10);
				break;
				case "3":
					sDate=C_agoDay(C_getNowDateString(10),21);
					eDate=C_getNowDateString(10);
				break;
				case "1M":
					sDate= C_agoMonth(-1,"Ymd");
					eDate=C_getNowDateString(10);
				break;
				case "2M":
					sDate= C_agoMonth(-2,"Ymd");
					eDate=C_getNowDateString(10);
				break;
				case "A":
					sDate="";
					eDate="";
				break;
			}
			
			$("#"+objStartDt).val(sDate);
			$("#"+objEndDt).val(eDate);
		}
	} else if (type == "M"){
		
		$("#"+objStartDt).val(C_agoMonthFirstDay(gb));
		$("#"+objEndDt).val(C_agoMonthLastDay(gb));
	}

	if (C_isNull(mode))
	{
		doc.mode.value = "list";
	} 

//	doc.searchDay.value = gb;
//	doc.method="get";
//	doc.action = "";
//	doc.submit();
}



function C_CallMenuAuthBtn(no,code1,code2,code3)
{
//	alert(no);
//	alert(code1);
//	alert(code2);
//	alert(code3);

	var objMenuAuthBtn_L	= document.getElementById("menu_auth_l");
	var objMenuAuthBtn_W	= document.getElementById("menu_auth_w");
	var objMenuAuthBtn_M	= document.getElementById("menu_auth_m");
	var objMenuAuthBtn_D	= document.getElementById("menu_auth_d");
	var objMenuAuthBtn_E	= document.getElementById("menu_auth_e");
	var objMenuAuthBtn_C	= document.getElementById("menu_auth_c");
	var objMenuAuthBtn_S	= document.getElementById("menu_auth_s");
	var objMenuAuthBtn_P	= document.getElementById("menu_auth_p");
	var objMenuAuthBtn_U	= document.getElementById("menu_auth_u");

	var objMenuAuthBtn_E1	= document.getElementById("menu_auth_e1");
	var objMenuAuthBtn_E2	= document.getElementById("menu_auth_e2");
	var objMenuAuthBtn_E3	= document.getElementById("menu_auth_e3");
	var objMenuAuthBtn_E4	= document.getElementById("menu_auth_e4");
	var objMenuAuthBtn_E5	= document.getElementById("menu_auth_e5");

	if (intAdminLevel == 0 )
	{
		if(!C_isNull(objMenuAuthBtn_W))
		{
			$("a[id^=menu_auth_w]").each(function(index){
				$(this).css("display","inline-block");
			});		
		}
		
		if(!C_isNull(objMenuAuthBtn_M))
		{
			$("a[id^=menu_auth_m]").each(function(index){
				$(this).css("display","inline-block");
			});		
		}

		if(!C_isNull(objMenuAuthBtn_D))
		{
			$("a[id^=menu_auth_d]").each(function(index){
				$(this).css("display","inline-block");
			});		
		}

		if(!C_isNull(objMenuAuthBtn_E))
		{
			$("a[id^=menu_auth_e]").each(function(index){
				$(this).css("display","inline-block");
			});		
		}

		if(!C_isNull(objMenuAuthBtn_C))
		{
			$("a[id^=menu_auth_c]").each(function(index){
				$(this).css("display","inline-block");
			});		
		}

		if(!C_isNull(objMenuAuthBtn_S))
		{
			$("a[id^=menu_auth_s]").each(function(index){
				$(this).css("display","inline-block");
			});		
		}

		
		if(!C_isNull(objMenuAuthBtn_P))
		{
			$("a[id^=menu_auth_p]").each(function(index){
				$(this).css("display","inline-block");
			});
		}

		if(!C_isNull(objMenuAuthBtn_U))
		{
			$("a[id^=menu_auth_u]").each(function(index){
				$(this).css("display","inline-block");
			});
		}

		if(!C_isNull(objMenuAuthBtn_E1))
		{
			$("a[id^=menu_auth_e1]").each(function(index){
				$(this).css("display","inline-block");
			});
		}

		if(!C_isNull(objMenuAuthBtn_E2))
		{
			$("a[id^=menu_auth_e2]").each(function(index){
				$(this).css("display","inline-block");
			});
		}

		if(!C_isNull(objMenuAuthBtn_E3))
		{
			$("a[id^=menu_auth_e3]").each(function(index){
				$(this).css("display","inline-block");
			});
		}

		if(!C_isNull(objMenuAuthBtn_E4))
		{
			$("a[id^=menu_auth_e4]").each(function(index){
				$(this).css("display","inline-block");
			});
		}

		if(!C_isNull(objMenuAuthBtn_E5))
		{
			$("a[id^=menu_auth_e5]").each(function(index){
				$(this).css("display","inline-block");
			});
		}
		
	} else {

		// ./?menuType=menu&mode=json&no=38&code1=010&code2=001&code3=
//		alert(no);
//		alert(code1);
//		alert(code2);
//		alert(code3);
		$.getJSON("./?menuType=menu&mode=json",{"no":no,"code1":code1,"code2":code2,"code3":code3 },function(data){
			if (data[0].RET == "Y")
			{
				strMenuAuthBtn_L	= data[0].AUTH_L;
				strMenuAuthBtn_W	= data[0].AUTH_W;
				strMenuAuthBtn_M	= data[0].AUTH_M;
				strMenuAuthBtn_D	= data[0].AUTH_D;
				strMenuAuthBtn_E	= data[0].AUTH_E;
				strMenuAuthBtn_C	= data[0].AUTH_C;
				strMenuAuthBtn_S	= data[0].AUTH_S;
				strMenuAuthBtn_P	= data[0].AUTH_P;
				strMenuAuthBtn_U	= data[0].AUTH_U;

				strMenuAuthBtn_E1	= data[0].AUTH_E1;
				strMenuAuthBtn_E2	= data[0].AUTH_E2;
				strMenuAuthBtn_E3	= data[0].AUTH_E3;
				strMenuAuthBtn_E4	= data[0].AUTH_E4;
				strMenuAuthBtn_E5	= data[0].AUTH_E5;

				if(!C_isNull(objMenuAuthBtn_W) && strMenuAuthBtn_W == "Y")
				{
					$("a[id^=menu_auth_w]").each(function(index){
						$(this).css("display","inline-block");
					});	
				}
				
				if(!C_isNull(objMenuAuthBtn_M) && strMenuAuthBtn_M == "Y")
				{
					$("a[id^=menu_auth_m]").each(function(index){
						$(this).css("display","inline-block");
					});
				}

				if(!C_isNull(objMenuAuthBtn_D) && strMenuAuthBtn_D == "Y")
				{
					$("a[id^=menu_auth_d]").each(function(index){
						$(this).css("display","inline-block");
					});
				}
			
				if(!C_isNull(objMenuAuthBtn_E) && strMenuAuthBtn_E == "Y")
				{
					$("a[id^=menu_auth_e]").each(function(index){
						$(this).css("display","inline-block");
					});
				}

				if(!C_isNull(objMenuAuthBtn_C) && strMenuAuthBtn_C == "Y")
				{
					$("a[id^=menu_auth_c]").each(function(index){
						$(this).css("display","inline-block");
					});
				}

				if(!C_isNull(objMenuAuthBtn_S) && strMenuAuthBtn_S == "Y")
				{
					$("a[id^=menu_auth_s]").each(function(index){
						$(this).css("display","inline-block");
					});
				}

				if(!C_isNull(objMenuAuthBtn_P) && strMenuAuthBtn_P == "Y")
				{
					$("a[id^=menu_auth_p]").each(function(index){
						$(this).css("display","inline-block");
					});
				}

				if(!C_isNull(objMenuAuthBtn_U) && strMenuAuthBtn_U == "Y")
				{
					$("a[id^=menu_auth_u]").each(function(index){
						$(this).css("display","inline-block");
					});
				}

				if(!C_isNull(objMenuAuthBtn_E1) && strMenuAuthBtn_E1 == "Y")
				{
					$("a[id^=menu_auth_e1]").each(function(index){
						$(this).css("display","inline-block");
					});
				}

				if(!C_isNull(objMenuAuthBtn_E2) && strMenuAuthBtn_E2 == "Y")
				{
					$("a[id^=menu_auth_e2]").each(function(index){
						$(this).css("display","inline-block");
					});
				}

				if(!C_isNull(objMenuAuthBtn_E3) && strMenuAuthBtn_E3 == "Y")
				{
					$("a[id^=menu_auth_e3]").each(function(index){
						$(this).css("display","inline-block");
					});
				}

				if(!C_isNull(objMenuAuthBtn_E4) && strMenuAuthBtn_E4 == "Y")
				{
					$("a[id^=menu_auth_e4]").each(function(index){
						$(this).css("display","inline-block");
					});
				}

				if(!C_isNull(objMenuAuthBtn_E5) && strMenuAuthBtn_E5 == "Y")
				{
					$("a[id^=menu_auth_e5]").each(function(index){
						$(this).css("display","inline-block");
					});
				}			
			} else {
				$("html").empty();
				alert("메뉴권한이 없는 관리자입니다.");
				history.back();
				return;
			}
		});
	}
}
// 2013.07.21 kim hee sung 커뮤니티 js 에서 중복으로 사용됨
//	function goAct(mode) {
//		// 액션
//		C_getJsonTest(mode, G_PHP_SELF);
//	}

	function C_getJsonTest(mode,act){
		var doc = document.form;

		doc.action				= act;
		doc.mode.value			= "json";
//		doc.act.value			= mode;
		doc.jsonMode.value		= mode;
		doc.method				="post";
		doc.submit();
	}

	function goJson(mode, callbackFunc) {
		// Json 액션
		C_getJson(mode, callbackFunc, G_PHP_SELF);
	}

	/**
	 * 해더 부분 때문에 fileupload 가 실행 안됨.
	 * **/
	function C_getJson(mode, callbackFunc, act) {

		var doc					= document.form;
		doc.mode.value			= "json";
//		doc.act.value			= mode;
		doc.jsonMode.value		= mode;

		var formData			= $("form[name=form]").serialize();
		var myAjax				= newXMLHttpRequest(); 

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

	function goFTPFileUploadMoveEvent() {
		window.open("./?menuType=popup&mode=popFileUpload", "", "width=790px,height=450px");
	}