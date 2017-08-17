/*mouseR button***************************************************************/
if(jQuery) (function(){$.extend($.fn, {rightClick: function(handler) {$(this).each( function() {$(this).mousedown( function(e) {var evt = e;$(this).mouseup( function() {$(this).unbind('mouseup');if( evt.button == 2 ) {handler.call( $(this), evt );return false;} else {return true;}});});$(this)[0].oncontextmenu = function() {return false;}});return $(this);},rightMouseDown: function(handler) {$(this).each( function() {$(this).mousedown( function(e) {if( e.button == 2 ) {handler.call( $(this), e );return false;} else {return true;}});$(this)[0].oncontextmenu = function() {return false;}});return $(this);},rightMouseUp: function(handler) {$(this).each( function() {$(this).mouseup( function(e) {if( e.button == 2 ) {handler.call( $(this), e );return false;} else {return true;}});$(this)[0].oncontextmenu = function() {return false;}});return $(this);},noContext: function() {$(this).each( function() {$(this)[0].oncontextmenu = function() {return false;}});return $(this);}});})(jQuery);
/*****************************************************************************/

/*hotkey**********************************************************************/
(function(jQuery){jQuery.fn.__bind__=jQuery.fn.bind;jQuery.fn.__unbind__=jQuery.fn.unbind;jQuery.fn.__find__=jQuery.fn.find;var hotkeys={version:'0.7.9',override:/keypress|keydown|keyup/g,triggersMap:{},specialKeys:{27:'esc',9:'tab',32:'space',13:'return',8:'backspace',145:'scroll',20:'capslock',144:'numlock',19:'pause',45:'insert',36:'home',46:'del',35:'end',33:'pageup',34:'pagedown',37:'left',38:'up',39:'right',40:'down',109:'-',112:'f1',113:'f2',114:'f3',115:'f4',116:'f5',117:'f6',118:'f7',119:'f8',120:'f9',121:'f10',122:'f11',123:'f12',191:'/'},shiftNums:{"`":"~","1":"!","2":"@","3":"#","4":"$","5":"%","6":"^","7":"&","8":"*","9":"(","0":")","-":"_","=":"+",";":":","'":"\"",",":"<",".":">","/":"?","\\":"|"},newTrigger:function(type,combi,callback){var result={};result[type]={};result[type][combi]={cb:callback,disableInInput:false};return result;}};hotkeys.specialKeys=jQuery.extend(hotkeys.specialKeys,{96:'0',97:'1',98:'2',99:'3',100:'4',101:'5',102:'6',103:'7',104:'8',105:'9',106:'*',107:'+',109:'-',110:'.',111:'/'});jQuery.fn.find=function(selector){this.query=selector;return jQuery.fn.__find__.apply(this,arguments);};jQuery.fn.unbind=function(type,combi,fn){if(jQuery.isFunction(combi)){fn=combi;combi=null;}
if(combi&&typeof combi==='string'){var selectorId=((this.prevObject&&this.prevObject.query)||(this[0].id&&this[0].id)||this[0]).toString();var hkTypes=type.split(' ');for(var x=0;x<hkTypes.length;x++){delete hotkeys.triggersMap[selectorId][hkTypes[x]][combi];}}
return this.__unbind__(type,fn);};jQuery.fn.bind=function(type,data,fn){var handle=type.match(hotkeys.override);if(jQuery.isFunction(data)||!handle){return this.__bind__(type,data,fn);}
else{var result=null,pass2jq=jQuery.trim(type.replace(hotkeys.override,''));if(pass2jq){result=this.__bind__(pass2jq,data,fn);}
if(typeof data==="string"){data={'combi':data};}
if(data.combi){for(var x=0;x<handle.length;x++){var eventType=handle[x];var combi=data.combi.toLowerCase(),trigger=hotkeys.newTrigger(eventType,combi,fn),selectorId=((this.prevObject&&this.prevObject.query)||(this[0].id&&this[0].id)||this[0]).toString();trigger[eventType][combi].disableInInput=data.disableInInput;if(!hotkeys.triggersMap[selectorId]){hotkeys.triggersMap[selectorId]=trigger;}
else if(!hotkeys.triggersMap[selectorId][eventType]){hotkeys.triggersMap[selectorId][eventType]=trigger[eventType];}
var mapPoint=hotkeys.triggersMap[selectorId][eventType][combi];if(!mapPoint){hotkeys.triggersMap[selectorId][eventType][combi]=[trigger[eventType][combi]];}
else if(mapPoint.constructor!==Array){hotkeys.triggersMap[selectorId][eventType][combi]=[mapPoint];}
else{hotkeys.triggersMap[selectorId][eventType][combi][mapPoint.length]=trigger[eventType][combi];}
this.each(function(){var jqElem=jQuery(this);if(jqElem.attr('hkId')&&jqElem.attr('hkId')!==selectorId){selectorId=jqElem.attr('hkId')+";"+selectorId;}
jqElem.attr('hkId',selectorId);});result=this.__bind__(handle.join(' '),data,hotkeys.handler)}}
return result;}};hotkeys.findElement=function(elem){if(!jQuery(elem).attr('hkId')){if(jQuery.browser.opera||jQuery.browser.safari){while(!jQuery(elem).attr('hkId')&&elem.parentNode){elem=elem.parentNode;}}}
return elem;};hotkeys.handler=function(event){var target=hotkeys.findElement(event.currentTarget),jTarget=jQuery(target),ids=jTarget.attr('hkId');if(ids){ids=ids.split(';');var code=event.which,type=event.type,special=hotkeys.specialKeys[code],character=!special&&String.fromCharCode(code).toLowerCase(),shift=event.shiftKey,ctrl=event.ctrlKey,alt=event.altKey||event.originalEvent.altKey,mapPoint=null;for(var x=0;x<ids.length;x++){if(hotkeys.triggersMap[ids[x]][type]){mapPoint=hotkeys.triggersMap[ids[x]][type];break;}}
if(mapPoint){var trigger;if(!shift&&!ctrl&&!alt){trigger=mapPoint[special]||(character&&mapPoint[character]);}
else{var modif='';if(alt)modif+='alt+';if(ctrl)modif+='ctrl+';if(shift)modif+='shift+';trigger=mapPoint[modif+special];if(!trigger){if(character){trigger=mapPoint[modif+character]||mapPoint[modif+hotkeys.shiftNums[character]]||(modif==='shift+'&&mapPoint[hotkeys.shiftNums[character]]);}}}
if(trigger){var result=false;for(var x=0;x<trigger.length;x++){if(trigger[x].disableInInput){var elem=jQuery(event.target);if(jTarget.is("input")||jTarget.is("textarea")||jTarget.is("select")||elem.is("input")||elem.is("textarea")||elem.is("select")){return true;}}
result=result||trigger[x].cb.apply(this,[event]);}
return result;}}}};window.hotkeys=hotkeys;return jQuery;})(jQuery);
/*****************************************************************************/

/*-------------------- 윈도우 관련 함수 --------------------*/
// 새창 여는 함수(Window)
function C_openWindow(asURL, asName, aiSizeW, aiSizeH)
{
	var intLeft = screen.width / 2 - aiSizeW / 2;
	var intTop  = screen.height / 2 - aiSizeH / 2;
	
	opt = ",toolbar=no,menubar=no,location=no,scrollbars=yes,status=yes";
	window.open(asURL, asName.replace(" ",""), "left=" + intLeft + ",top=" +  intTop + ",width=" + aiSizeW + ",height=" + aiSizeH  + opt);
}

function C_openImage(asURL, asName, aiSizeW, aiSizeH)
{
	var intLeft = screen.width / 2 - aiSizeW / 2;
	var intTop  = screen.height / 2 - aiSizeH / 2;

	opt = ",toolbar=no,menubar=no,location=no,scrollbars=no,status=yes";
	window.open(asURL, asName, "left=" + intLeft + ",top=" +  intTop + ",width=" + aiSizeW + ",height=" + aiSizeH  + opt);
}

/*-------------------- 유효성 관련 함수 --------------------*/
// 입력값이 NULL인지 체크
function C_isNull(asValue)
{
    if (asValue == null || asValue == undefined || asValue.toString().replace(/ /g,"") == "")
    {
        return true;
    }
    
    return false;
}

// 숫자검증
function C_isNum(asValue)
{
	if (C_isNull(asValue)) return false;

	for (var i = 0; i < asValue.length; i++)
	{
		if (asValue.charAt(i) < '0' || asValue.charAt(i) > '9')
		{
			return false;
		}
	}
	
	return true;
}

// 영문자검증
function C_isAlpha(asValue)
{
	if (C_isNull(asValue)) return false
	
	for (var i = 0; i < asValue.length; i++)
	{
		if (!((asValue.charAt(i) >='a' && asValue <= 'z') || (asValue.charAt(i) >= 'A' && asValue <= 'Z')))
		{
			return false;
		}
	}

	return true;
}

// 한글검증
function C_isHangul(asValue)
{
	if (C_isNull(asValue)) return false;
	
	for (var i = 0; i < asValue.length; i++)
	{
		var c = escape(asValue.charAt(i));
		if (c.indexOf("%u") != -1)
		{
			return true;
		}
	}
	return false;

	/*
	if (C_isNull(asValue)) return false;
	
	for (var i = 0; i < asValue.length; i++)
	{
		var c = escape(asValue.charAt(i));
		alert(c.indexOf("%u"));
		if (c.indexOf("%u") == -1)
		{
			return false;
		}
	}
	return true;	
	*/
}

/*
  입력값이 이메일 형식인지 체크
  ex) if (!C_isValidEmail(form.email.value)) {
          alert("올바른 이메일 주소가 아닙니다.");
      }
*/
function C_isValidEmail(asValue)
{
	var strFormat = /^((\w|[\-\.])+)@((\w|[\-\.])+)\.([A-Za-z]+)$/;
	return C_isValidFormat(asValue, strFormat);
}

// 입력값이 전화번호 형식(숫자-숫자-숫자)인지 체크
function C_isValidPhone(asValue) {
	var strFormat = /^(\d+)-(\d+)-(\d+)$/;
	return C_isValidFormat(asValue, strFormat);
}

//주민등록번호 유효성 검증
function C_isValidRegNo(asValue)
{
	var arrRegNo = new Array(0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0);
	var intSum = 0;
	var intMod = 0;
	var i = 0;
	
	if (C_isNull(asValue)) return true;
	
	var strValue = asValue.toString().replace(/-/g, "");
	
	if (C_getByteLength(strValue) == 10)
	{
		return C_isValidCustNo(strValue);
	}

	if (C_getByteLength(strValue) != 13 || !C_isNum(strValue))
	{
		ERR_MSG = "주민등록번호는 13자리 숫자입니다.";
		return false;
	}

	if (strValue == '0000000000000') return true;
	
	for (i = 0; i < 13; i++) arrRegNo[i] = strValue.substr(i, 1);
	
	for (i = 0; i < 12; i++) intSum += arrRegNo[i] * ((i > 7) ? (i - 6) : (i + 2));
	
	intMod = 11 - intSum % 11;
	
	if (intMod >= 10) intMod -= 10;
	
	if (intMod != arrRegNo[12])
	{
		ERR_MSG = "올바르지 않은 주민등록번호입니다.";
		return false;
	}
	
	return true;
}

//사업자번호 유효성 검증
function C_isValidCustNo(asValue)
{
	var intSumMod = 0;
	
	if (C_isNull(asValue)) return true;
	
	var strValue = asValue.toString().replace(/-/g, "");
	
	if (C_getByteLength(strValue) == 13)
	{
		return C_isValidRegNo(strValue);
	}
	
	if (C_getByteLength(strValue) != 10 || !C_isNum(strValue))
	{
		ERR_MSG = "사업자등록번호는 10자리 숫자입니다.";
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
		ERR_MSG = "올바르지 않은 사업자등록번호입니다.";
		return false;
	}
	
	return	true;
}


/*-------------------- 문자열 관련 함수 --------------------*/
// 캐릭터 타입 검증 'H'-한글, 'E'-영문, 'N'-숫자, 'Z'-기타
function C_getCharType(asValue)
{
	var bolHan = false;
	var bolAlp = false;
	var bolNum = false;
	var bolEtc = false;
	
	var retStr = "";

	if (C_isNull(asValue))
	{
		return "";
	}
	
	for (var i = 0; i < asValue.length; i++)
	{
		if (C_isAlpha(asValue.charAt(i)))
		{
			bolAlp = true;
			retStr += "E";
		}
		else if (C_isNum(asValue.charAt(i)))
		{
			bolNum = true;
			retStr += "N";
		}
		else if (C_isHangul(asValue.charAt(i)))
		{
			bolHan = true;
			retStr += "H";
		}
		else
		{
			bolEtc = true;
			retStr += "Z";
		}
	}
	
	return retStr;
}

/*
  입력값에 특정 문자(chars)가 있는지 체크
  특정 문자를 허용하지 않으려 할 때 사용
  ex) if (containsChars(form.name,"!,*&^%$#@~;")) {
          alert("이름 필드에는 특수 문자를 사용할 수 없습니다.");
      }
*/
function C_containsChars(asValue)
{
	var asChars = "!,*&^%$#@~;`-+:?/<>{}[]\\=";
	for (var i = 0; i < asValue.length; i++)
	{
		if (asChars.indexOf(asValue.charAt(i)) != -1)	return true;
	}
	
	return false;
}


/*
특수문자및 숫자사용 체크
*/
function C_containsCharsNum(asValue)
{
	var asChars = "!,*&^%$#@~;`-+:?/<>{}[]\\=0123456789.";
	for (var i = 0; i < asValue.length; i++)
	{
		if (asChars.indexOf(asValue.charAt(i)) != -1)	return true;
	}
	
	return false;
}



/*
한글만사용 체크
*/
function C_containsCharsNumKOR(asValue)
{
	var asChars = "ABCDEFGHIJKLMNOPQRSTUVWXYZabcdefghijklmnopqrstuvwxyz1234567890!,*&^%$#@~;`-+:?/<>{}[]\\=.";
	for (var i = 0; i < asValue.length; i++)
	{
		if (asChars.indexOf(asValue.charAt(i)) != -1)	return true;
	}
	
	return false;
}



/*
  입력값이 특정 문자(chars)만으로 되어있는지 체크
  특정 문자만 허용하려 할 때 사용
  ex) if (!C_containsCharsOnly("M", "MW")) {
          alert("성별 필드에는 M,W 문자만 사용할 수 있습니다.");
      }
*/
function C_containsCharsOnly(asValue, asChars)
{
	for (var i = 0; i < asValue.length; i++)
	{
		if (asChars.indexOf(asValue.charAt(i)) == -1) return false;
	}
	
	return true;
}

/*
  입력값이 사용자가 정의한 포맷 형식인지 체크
  자세한 format 형식은 자바스크립트의 'regular expression'을 참조
*/
function C_isValidFormat(asValue, asFormat)
{
	if (C_isNull(asValue)) return true;
	if (asValue.search(asFormat) != -1) return true; //올바른 포맷 형식

	return false;
}

/*
  입력값의 바이트 길이로 짜르기
  ex) if (getByteLength(form.title) > 100) {
          alert("제목은 한글 50자(영문 100자) 이상 입력할 수 없습니다.");
      }
*/
function C_getByteCut(asValue, max, tail)
{
	var byteText = '';
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

		if(byteLength > max) { break; }

		byteText += asValue.charAt(i);

	}
	
	return byteText;
}

/*
  입력값의 바이트 길이를 리턴
  ex) if (getByteLength(form.title) > 100) {
          alert("제목은 한글 50자(영문 100자) 이상 입력할 수 없습니다.");
      }
*/
function C_getByteLength(asValue)
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

// 문자열에 있는 특정문자패턴을 다른 문자패턴으로 바꾸는 함수.
function C_Replace(asTarget, asSearch, asReplace)
{
	var strTemp = "";

	for (var i = 0 ; i < asTarget.length ; i++)
	{
		if (asTarget.charAt(i) != asSearch)
		{
			strTemp = strTemp + asTarget.charAt(i);
		}
		else
		{
			strTemp = strTemp + asReplace;
		}
	}
	
	return strTemp;
}

// 문자열에서 좌우 공백제거
function C_Trim(asValue)
{
	var intStart = 0;
	var intEnd   = 0;

	for (var i = 0 ; i < asValue.length ; i++)
	{
		if (asValue.charAt(i) != " ")
		{
			intStart = i;
			break;
		}
	}
	
	for (var j = asValue.length - 1 ; j >= 0 ; j--)
	{
		if (asValue.charAt(j) != " ")
		{
			intEnd = j + 1;
			break;
		}
	}
	
	return asValue.substring(intStart, intEnd);
}

// 문자열을 숫자 포맷으로 변경한다.(abDot : true(소수점 포함), false(소수점 미포함))
function C_toNumberFormatString(asValue, abDot)
{
	if (C_isNull(asValue)) return "";
	
	//var intNumber = parseFloat(C_removeComma(asValue), 10);
	var intNumber = C_removeComma(asValue, abDot);
	var bolMinus = false;
	var bolDot = false;
	var dotPos;
	var dotU;
	var dotD;
	var commaFlag;
	var strOut = "";

	if (intNumber < 0)
	{
		intNumber *= -1; 
		bolMinus = true;
	}
	
	if (intNumber.toString().indexOf(".") > -1)
	{
		if (abDot == false)
		{
			intNumber = intNumber.substring(0, intNumber.toString().indexOf("."));
		}
	}

	if (intNumber.toString().indexOf(".") > -1)
	{
		dotPos = intNumber.toString().split(".");
		//dotU = dotPos[0];
		dotU = Number(dotPos[0], 10).toString();
		dotD = dotPos[1];
		bolDot = true;
	}
	else
	{
		//dotU = intNumber.toString();
		dotU = Number(intNumber.toString(), 10).toString();
		dotD = "";
	}

	commaFlag = dotU.length % 3;
	
	if (commaFlag)
	{
		strOut = dotU.substring(0, commaFlag);
		if (dotU.length > 3) strOut += ",";
	}
	
	for (var i = commaFlag; i < dotU.length; i+=3)
	{
		strOut += dotU.substring(i, i + 3) ;
		if (i < dotU.length - 3) strOut += ",";
	}
	
	if (bolMinus) strOut = "-" + strOut;
	if (bolDot) strOut = strOut + "." + dotD;
	
	return strOut;
}

// 입력값에서 콤마 및 공백을 없앤다.(abDot : true(소수점 포함), false(소수점 미포함))
function C_removeComma(asValue, abDot)
{
	var intNumber = asValue.toString().replace(/,/g, "").replace(/ /g, "");
	
	if (intNumber.toString().indexOf(".") > -1)
	{
		if (abDot == false)
		{
			intNumber = intNumber.substring(0, intNumber.toString().indexOf("."));
		}
	}
	
    return intNumber;
}
//입력값에서 콤마 및 공백을 없애고 숫자형식 문자열을 되돌린다.
function	C_getNumberTypeString(asValue)
{
	var		lsRet = C_removeComma(asValue,false);
	if(C_isNull(lsRet))
	{
		return "0";
	}
	else
	{
		return lsRet;
	}
}
// Left 빈자리 만큼 strPadChar 을 붙인다.
function C_LPad(strValue, intLength, strPadChar)
{
	var strTemp = "";
	var intPadCnt = intLength - strValue.length;
	
	for (var i = 0; i < intPadCnt; i++) strTemp += strPadChar;
	
	return strTemp + strValue;
}

// Right 빈자리 만큼 strPadChar 을 붙인다.
function C_RPad(strValue, intLength, strPadChar)
{
	var strTemp = "";
	var intPadCnt = intLength - strValue.length;
	
	for (var i = 0; i < intPadCnt; i++) strTemp += strPadChar;
	
	return strValue + strTemp;
}

// 대문자변환
function C_toUpperCase(asValue)
{
	if(C_isNull(asValue)) return asValue;
	return asValue.toUpperCase();
}

// 첫글자 대문자변환
 function C_toUpperCaseOnlyFirst(asValue) {
	if(C_isNull(asValue)) { return asValue; }
	return asValue.substring(0, 1).toUpperCase() + asValue.substring(1, asValue.length);
 }

// 소문자변환
function C_toLowerCase(asValue)
{
	if(C_isNull(asValue)) return asValue;
	return asValue.toLowerCase();
}

/*
문자열을 입력한 포맷으로 변경한다.
ex) alert(C_StringFM("123456789", "xxx-xxx-xxxx"));
*/
function C_StringFM(strValue, strFormat)
{
	var strData;
	var strPattern;
	var intLen;
	var intPos;
	
	intPos = -1;
	strPattern = /-/g;
	
	if (strValue == null || strValue.length < 1 || strFormat == null || strFormat.length < 1) return strValue;

	strData = strValue.replace(strPattern, "");

	intLen = strData.length;

	if (intLen != strFormat.replace(strPattern, "").length) return strValue;

	while (true)
	{
		intPos = strFormat.indexOf("-", intPos + 1);

		if (intPos < 1) break;
		
		strData = strData.substr(0, intPos) + "-" + strData.substr(intPos);
	}

	return strData;
}

// 한글변환시 bolTag에 true를 넘기고 서버 코딩에서 사용시 반드시 디코딩한다.
function C_Encode(strValue, bolTag)
{
	return bolTag == true ? escape(encodeURI(strValue)) : encodeURI(strValue) ;
}

// 한글이 인코딩된 경우 bolTag에 true를 넘긴다.
function C_Decode(strValue, bolTag)
{
	return bolTag == true ? decodeURI(unescape(strValue)) : decodeURI(strValue);
}


//영문,숫자만 입력 체크
function C_HangulChk(Ev)
{
	var ev_code = (window.netscape)? Ev.which: event.keyCode;
	if ( !(ev_code == 0 || ev_code == 8 || ev_code == 94 || ev_code == 95 || (ev_code > 47 && ev_code < 58) || (ev_code > 96 && ev_code < 123))) {
		alert("숫자, 영어, '_'만 가능");
		if(window.netscape){
			Ev.preventDefault();
		} else {
			event.returnValue = false;
		}
		return false;
	} else {
		return true;
	}
}

/*-------------------- 날짜, 시간 관련 함수 --------------------*/
// 유효한(존재하는) 년(年)인지 체크
function C_isValidYear(yyyy)
{
	var intYear = parseInt(yyyy, 10);
	return (intYear >= 1900 && intYear <= 2999);
}

// 유효한(존재하는) 월(月)인지 체크
function C_isValidMonth(mm)
{
	var intMonth = parseInt(mm, 10);
	return (intMonth >= 1 && intMonth <= 12);
}

// 유효한(존재하는) 일(日)인지 체크
function C_isValidDay(yyyy, mm, dd)
{
	var intMonth = parseInt(mm, 10) - 1;
	var intDay = parseInt(dd, 10);	
	var arrLastDay = new Array(31, 28, 31, 30, 31, 30, 31, 31, 30, 31, 30, 31);
	
	if ((yyyy % 4 == 0 && yyyy % 100 != 0) || yyyy % 400 == 0) arrLastDay[1] = 29;	
	
	return (intDay >= 1 && intDay <= arrLastDay[intMonth]);
}

// 유효한(존재하는) 시(時)인지 체크
function C_isValidHour(hh)
{
	var intHour = parseInt(hh, 10);
	return (intHour >= 1 && intHour <= 24);
}

// 유효한(존재하는) 분(分)인지 체크
function C_isValidMin(mi)
{
	var intMin = parseInt(mi, 10);
	return (intMin >= 1 && intMin <= 60);
}

// 입력된 날짜값에서 '-', '/', '.', ':', ' '(공백)을 없앤다.
function C_removeDateTimeFormat(asValue)
{
	return asValue.toString().replace(/-/g, "").replace(/\//g, "").replace(/\./g, "").replace(/:/g, "").replace(/ /g, "");
}

/*
  유효하는(존재하는) 날짜 인지 체크
  ex) var date = form.date.value; //'20010231'
      if (!C_isValidDate(date)) {
          alert("올바른 날짜가 아닙니다.");
      }
 */
function C_isValidDate(asDate)
{
	if (C_isNull(asDate)) return true;
	
	var strDate = C_removeDateTimeFormat(asDate);
	var year  = "";
	var month = "";
	var day   = "";
	var hour  = "";
	var min   = "";
	
	if (strDate.length == 6)
	{
		year  = strDate.substr(0,4);
		month = strDate.substr(4,2);
		
		if (parseInt(year, 10) >= 1900 && C_isValidMonth(month)) return true;
	}
	else if (strDate.length == 8)
	{
		year  = strDate.substr(0,4);
		month = strDate.substr(4,2);
		day   = strDate.substr(6,2);
		
		if (parseInt(year, 10) >= 1900 && C_isValidMonth(month) && C_isValidDay(year,month,day)) return true;
	}
	else if (strDate.length == 12)
	{
		year  = strDate.substr(0,4);
		month = strDate.substr(4,2);
		day   = strDate.substr(6,2);
		hour  = strDate.substr(8,2);
		min   = strDate.substr(10,2);
		
		if (parseInt(year, 10) >= 1900 && C_isValidMonth(month) && C_isValidDay(year, month, day) &&
			C_isValidHour(hour) && C_isValidMin(min)) return true;
	}

	return false;
}


//날짜문자열을 인자2만큼의 이전 날을 구한다.
function C_agoDay(asDate,addDay)
{
	if (!C_isValidDate(asDate)) return "";

	var strNowDate = C_removeDateTimeFormat(asDate);

	var yyyy = strNowDate.substr(0,4);
	var mm	 = eval(strNowDate.substr(4,2) + "- 1") ;
	var dd	 = strNowDate.substr(6,2);

	var strNextDate = new Date(yyyy, mm, eval(dd + '-' + addDay));

	return  C_toDateString(strNextDate,10) ;
}

/*
  Date 스트링을 자바스크립트 Date 객체로 변환
  ex) alert(C_toDate("20040329"));
 */
function C_toDate(asDate)
{
	var strDate = C_removeDateTimeFormat(asDate);
	var year  = "";
	var month = "";
	var day   = "";
	var hour  = "";
    var min   = "";
	
	if (strDate.length == 6)
	{
		year  = strDate.substr(0,4);
		month = strDate.substr(4,2) - 1; // 1월=0,12월=11
		
		return new Date(year, month, 1);
	}
	else if (strDate.length == 8)
	{
		year  = strDate.substr(0,4);
		month = strDate.substr(4,2) - 1; // 1월=0,12월=11
		day   = strDate.substr(6,2);
		
		return new Date(year, month, day);
	}
	else if (strDate.length == 12)
	{
		year  = strDate.substr(0,4);
		month = strDate.substr(4,2) - 1; // 1월=0,12월=11
		day   = strDate.substr(6,2);
		hour  = strDate.substr(8,2);
	    min   = strDate.substr(10,2);
		
		return new Date(year, month, day, hour, min);
	}
	
	return null;
}

/*
  자바스크립트 Date 객체를 Date 스트링(20031225)으로 변환
  ex) var date = new Date();
      alert(C_toDateString(date, 8));
 */
function C_toDateString(aoDate, aiLength)
{
	var year  = aoDate.getFullYear();
	var month = aoDate.getMonth() + 1; // 1월=0,12월=11이므로 1 더함
	var day   = aoDate.getDate();
	var hour  = aoDate.getHours();
    var min   = aoDate.getMinutes();
    
    if (("" + month).length == 1) { month = "0" + month; }
	if (("" + day).length   == 1) { day   = "0" + day;   }
	if (("" + hour).length  == 1) { hour  = "0" + hour;  }
    if (("" + min).length   == 1) { min   = "0" + min;   }
	
	if (aiLength == 8)
	{
		return ("" + year + month + day)
	}
	else if (aiLength == 10)
	{
		return ("" + year + "-" + month + "-" + day)
	}
	else if (aiLength == 12)
	{
		return ("" + year + month + day + hour + min)
	}
	
	return "";
}

/*
  Date 스트링을 yyyy-mm-dd 포맷의 스트링으로 변환.
  ex) alert(C_toDateFormatString("20040329"));
 */
function C_toDateFormatString(asDate)
{
	var strDate = C_removeDateTimeFormat(asDate);
	var strTemp = "";
	
	if (strDate.length == 6)
	{
		strTemp += strDate.substr(0,4);
		strTemp += "-";
		strTemp += strDate.substr(4,2);
	}
	else if (strDate.length == 8)
	{
		strTemp += strDate.substr(0,4);
		strTemp += "-";
		strTemp += strDate.substr(4,2);
		strTemp += "-";
		strTemp += strDate.substr(6,2);
	}
	else if (strDate.length == 12)
	{
		strTemp += strDate.substr(0,4);
		strTemp += "-";
		strTemp += strDate.substr(4,2);
		strTemp += "-";
		strTemp += strDate.substr(6,2);
		strTemp += " ";
		strTemp += strDate.substr(8,2);
		strTemp += ":";
		strTemp += strDate.substr(10,2);
	}
	else
	{
		strTemp = asDate;
	}
	
	return strTemp;
}

// 현재 시각을 Date String 형식으로 리턴 (20040329)
function C_getNowDateString(aiLength)
{
	return C_toDateString(new Date(), aiLength);
}

// 현재 시각을 Date Format String 형식으로 리턴 (2004-03-29)
function C_getNowDateFormatString(aiLength)
{
	return C_toDateFormatString(C_toDateString(new Date(), aiLength));
}

// 현재 시각을 지정한 구분자를 Date Format String 형식으로 리턴 (YYYY-MM) 예 delimiter -
function getYearMonth(delimiter)
{
	var strYear = C_getYear();
	var strMonth = C_getMonth();
			
	var strYearMonth = strYear + ''+ delimiter + ''+ strMonth;
	return strYearMonth;
}
// 현재 年을 YYYY형식으로 리턴
function C_getYear()
{
	return C_getNowDateString(12).substr(0,4);
}

// 현재 月을 MM형식으로 리턴
function C_getMonth()
{
	return C_getNowDateString(12).substr(4,2);
}

// 현재 日을 DD형식으로 리턴
function C_getDay()
{
	return C_getNowDateString(12).substr(6,2);
}

// 현재 時를 HH형식으로 리턴
function C_getHour()
{
	return C_getNowDateString(12).substr(8,2);
}


// 현재 日의 요일을 구한다.
function C_getToDayOfWeek()
{
	var week = new Array('일','월','화','수','목','금','토');
	var now  = new Date();
	var day  = now.getDay(); //일요일=0,월요일=1,...,토요일=6

	return week[day];
}

// 특정날짜의 요일을 구한다.
function C_getDayOfWeek(asDate)
{
	var week = new Array('일','월','화','수','목','금','토');
	var now  = C_toDate(asDate);
	var day  = now.getDay(); //일요일=0,월요일=1,...,토요일=6

	return week[day];
}

// 현재날짜의 데이트+시각을 구한다
function C_getDateTime()
{
   var d, s = "";

   d = new Date();
   s += C_getNowDateString(8); 
   s += d.getHours();
   s += d.getMinutes();
   s += d.getSeconds();
   s += d.getMilliseconds();
   return(s);
}

//월의 끝 일자 얻기
function C_getEndDay(asDate)
{
	var arrLastDay = new Array(31, 28, 31, 30, 31, 30, 31, 31, 30, 31, 30, 31);
	var strDate = C_removeDateTimeFormat(asDate);
	var year = parseInt(strDate.substr(0,4), 10);
	var month = parseInt(strDate.substr(4,2), 10);
	
	if ((year % 4 == 0 && year % 100 != 0) || year % 400 == 0) arrLastDay[1] = 29;	

	return arrLastDay[month - 1];
}

//월의 끝 일자 얻기(yyyymmdd로 리턴)
function C_getEndDate(asDate)
{
	var strDate = C_removeDateTimeFormat(asDate);

	var year	= strDate.substr(0,4);
	var month	= strDate.substr(4,2);
	var Day		= C_getEndDay(strDate);
	var EndDate = C_toDateFormatString(year+month+Day)
	
	return EndDate;
}

//시작일자와 종료일자를 비교(종료일자가 크면 true, 시작일자가 크면 false)
function C_compareDateFT(asFDate, asTDate)
{
	if (!C_isValidDate(asFDate) || !C_isValidDate(asTDate)) return true;
	
	var iFDate = parseFloat(C_removeDateTimeFormat(asFDate));
	var iTDate = parseFloat(C_removeDateTimeFormat(asTDate));
	
	if (isNaN(iFDate) || isNaN(iTDate)) return true;
	
	return iFDate <= iTDate ? true : false;
}

//시작일자와 종료일자를 계산해서 몇년, 몇월, 몇일이 차이가 나는지 계산(결과값은 배열로 넘긴다)
function C_calcDateFT(asFromDate, asToDate)
{
	if (!C_isValidDate(asFromDate) || !C_isValidDate(asToDate)) return null;
	
	var lsFromDate = C_removeDateTimeFormat(asFromDate);
	var lsToDate = C_removeDateTimeFormat(asToDate);
	
	if (isNaN(parseFloat(lsFromDate)) || isNaN(parseFloat(lsToDate))) return null;
	
	var larrRet = new Array(3);
	var liFromDay = 0;
	var liToDay = 0;
	var liTemp = 0;
	var liYear = 0;
	var liMonth = 0;
	var liDay = 0;
	
	liFromDay = (parseFloat(lsFromDate.substr(0, 4)) * 365) + (parseFloat(lsFromDate.substr(4, 2)) * 30) + parseFloat(lsFromDate.substr(6, 2));
	liToDay = (parseFloat(lsToDate.substr(0, 4)) * 365) + (parseFloat(lsToDate.substr(4, 2)) * 30) + parseFloat(lsToDate.substr(6, 2));
	
	liTemp = Math.abs(liToDay - liFromDay);
	
	// 년 계산
	if (liTemp >= 365)
	{
		liYear = parseInt(liTemp / 365);
		liTemp = (liTemp % 365);
	}
	else
	{
		liYear = 0;
	}
	
	// 월 계산
	if (liTemp >= 30)
	{
		liMonth = parseInt(liTemp / 30);
		liTemp = (liTemp % 30);
	}
	else
	{
		liMonth = 0;
	}
	
	liDay = liTemp;
	
	larrRet[0] = liYear;
	larrRet[1] = liMonth;
	larrRet[2] = liDay;
	if (liMonth == 12)
	{
		larrRet[0] = larrRet[0] + 1;
		larrRet[1] = 0;
	}
	
	return larrRet;
}

/*-------------------- 전화번호 관련 함수 --------------------*/
// 전화번호 국번검증
function C_isValidPhoneNum(asPhoneNum)
{
	if (C_isNull(asPhoneNum)) return false;

	if (asPhoneNum != "02" && asPhoneNum != "031" && asPhoneNum != "032" && asPhoneNum != "033" && asPhoneNum != "041" &&
		asPhoneNum != "042" && asPhoneNum != "043" && asPhoneNum != "051" && asPhoneNum != "052" && asPhoneNum != "053" &&
		asPhoneNum != "054" && asPhoneNum != "055" && asPhoneNum != "061" && asPhoneNum != "062" && asPhoneNum != "063" &&
		asPhoneNum != "064" && asPhoneNum != "011" && asPhoneNum != "016" && asPhoneNum != "017" && asPhoneNum != "018" &&
		asPhoneNum != "019" && asPhoneNum != "010")
	{
		ERR_MSG = "잘못된 전화번호 국번입니다.";
		return false;
	}

	return true;
	
}


/*-------------------- 콤보박스 관련 함수 --------------------*/
// 콤보박스 초기화
function C_intiCombo(aCbo)
{
	while (aCbo.options.length > 0)
	{
		for (var i = 0; i < aCbo.options.length; i++)
		{
			aCbo.remove(i);
		}
	}
}


// 해당 배열의 값으로 콤보박스 설정
function C_setArrayCombo(aCbo, aArr)
{
	var oOption = null;
	var arrTemp = null;
	
	C_intiCombo(aCbo);
	
	if (aArr == null || aArr.length < 1) return;
	
	for (var i = 0; i < aArr.length; i++)
	{
		oOption = document.createElement("OPTION");
		arrTemp = aArr[i].split("\t");
		
		oOption.value = arrTemp[0];
		oOption.text = arrTemp[1];
		aCbo.add(oOption);
	}
}

// 해당 배열의 값으로 콤보박스 설정(전체포함)
function C_setArrayComboAll(aCbo, aArr, asAllString)
{
	var oOption = null;
	var arrTemp = null;
	
	C_intiCombo(aCbo);
	
	oOption = document.createElement("OPTION");
	oOption.value = "";
	oOption.text  = C_isNull(asAllString) ? "ALL" : asAllString;
	aCbo.add(oOption);
	
	if (aArr == null || aArr.length < 1) return;
	

	for (var i = 0; i < aArr.length; i++)
	{
		oOption = document.createElement("OPTION");
		arrTemp = aArr[i].split("\t");
		
		oOption.value = arrTemp[0];
		oOption.text = arrTemp[1];
		aCbo.add(oOption);
	}
}

//해당 콤보 옵션 삭제
function C_deleteCombo(aCbo, asAllString)
{
	while (aCbo.options.length > 0)
	{
		for (var i = 0; i < aCbo.options.length; i++)
		{
			aCbo.remove(i);
		}
	}
	
	oOption = document.createElement("OPTION");
	oOption.value	= "";
	oOption.text	= C_isNull(asAllString) ? "ALL" : asAllString;
	aCbo.add(oOption);
}

// on_click시 원하는 페이지로 이동
function C_link(msg, url){
	location.href=url;
}


// 셀렉트박스 선택시 onchange
function C_selChange(form,url) {

	var form=eval("document."+form);
	form.action = url;
	form.submit();
}

// 퀵셀렉트박스 선택시 onchange
function C_selQuickChange(targ,selObj,restore){ //v3.0
  
  eval(targ+".location='"+selObj.options[selObj.selectedIndex].value+"'");
  if (restore) selObj.selectedIndex=0;

}


// 체크박스, 라디오버튼에 선택된값이 있을경우 선택된 값을 콤마(,)로 연결하여 반환
function C_getCheckedCode(obj, delimiter){
	selectSeq = "";
	//var obj = document.getElementsByName(obj);

	if (delimiter==undefined){
		delimiter = ",";
	}

	if (obj.length>0){
		
		for (i=0; i<obj.length; i++){
			if(obj[i].checked==true){
				if(selectSeq==""){
					selectSeq = obj[i].value;
				}else{
					selectSeq = selectSeq + delimiter + obj[i].value;
				}
			}
		}
	}else{
		if(obj.checked==true){
			selectSeq = obj.value;
		}
	}
	return selectSeq;
}



// 텍스트박스에 내용이 이력되었는지 검사
// obj:검사할 텍스트박스명
// showMessage:(true,false)입력이 안된경우 메시지보여줄지
// name:메시지보여줄때 항목명
// ex) if(!chkInput("name", true, "적용분야")) return;
function C_chkInput(obj_id, showMessage, name, focus){
	bFlag = true;

	if (C_isNull(strSiteJsLng))
	{
		strSiteJsLng = "KR";
	}

	if (C_isNull(focus)) focus = true;
	
	var obj = document.getElementById(obj_id);	
	
	// 2014.06.13 kim hee sung - add - input 태그가 없으면 정지되는 현상때문에 추가함.
	if(!obj) { return true; }

	if(obj.value == ""){
		if(showMessage){
			
			if (strSiteJsLng == "KR")
			{
				alert(name+"(을)를 입력해 주세요.");
			} 
			else if (strSiteJsLng == "US" || strSiteJsLng == "AU")
			{
				alert("Please enter your "+name);
			}
			else if (strSiteJsLng == "JP")
			{
				
				alert(name+"を入力してください。");
			}
			else if (strSiteJsLng == "CN")
			{
				alert("请输入"+name);
			}else if (strSiteJsLng == "RU"){
				alert("Please enter your "+name);
			}
		}
		if (focus)
		{
			obj.focus();
		}
		bFlag = false;
	}
	return bFlag;
}



//라디오박스 체크
function C_radioInput(obj_id, showMessage, name){
	bFlag = false;
	
	if (C_isNull(strSiteJsLng))
	{
		strSiteJsLng = "KR";
	}

	var obj = document.getElementsByName(obj_id);
	for(var i=0;i<obj.length;i++)
	{
		if(obj[i].checked == true) {
			bFlag = true;
			break;
		}
	}
	
	if (!bFlag)
	{
		if(showMessage){
			
			if (strSiteJsLng == "KR")
			{
				alert(name+"(을)를 선택해 주세요.");
			} 
			else if (strSiteJsLng == "US")
			{
				alert("Please choose your "+name);
			}
			else if (strSiteJsLng == "JP")
			{	
				alert(name+"を選択してください。");
			}
			else if (strSiteJsLng == "CN")
			{	
				alert("Please choose your "+name);
			}
			else if (strSiteJsLng == "RU")
			{
				alert("Please choose your "+name);
			}
		}
	}
	return bFlag;
}

// 키입력당시에 숫자만 입력되었는지 확인
function C_chkKeypressNum() {

	if (event.keyCode < 45 || event.keyCode > 57) event.returnValue = false;
}


// text박스 maxlength 다음 text 박스로 포커스 이동
// 예제)onKeyUp="nextFocus('formSign','jumin1','jumin2')"
function C_nextFocus(sFormName,sNow,sNext) {
	var sForm = 'document.'+ sFormName +'.'
	var oNow = eval(sForm + sNow);

	if (typeof oNow == 'object') {
		if ( oNow.value.length == oNow.maxLength) {
			var oNext = eval(sForm + sNext);

			if ((typeof oNext) == 'object')
				oNext.focus();
		}
	}
}

//키입력시 숫자만 체크
function C_chkKeyUpNum(obj) {

	if (C_isNull(strSiteJsLng))
	{
		strSiteJsLng = "KR";
	}

	if (!C_isNull(obj.value) && !C_isNum(obj.value))
	{
		if (strSiteJsLng == "KR")
		{
			alert("숫자만 입력하세요");
		} 
		else if (strSiteJsLng == "US")
		{
			alert("Please enter only numbers.");
		}
		obj.value = "";
		return;
	}
}

function C_getFileAction(mode,act){
	var doc = document.form;

	doc.action		= act;
	doc.mode.value	= "act";
	doc.act.value	= mode;
	doc.method		="post";	
	doc.encoding	= "multipart/form-data";
	doc.submit();
}

function C_getAction(mode,act){
	var doc = document.form;

	doc.action = act;
	doc.mode.value = "act";
	doc.act.value = mode;
	doc.method="post";
	doc.submit();
}

function C_getJsonAction(mode,act){
	var doc = document.form;

	doc.action = act;
	doc.mode.value = "json";
	doc.jsonMode.value = mode;
	doc.method="post";
	doc.submit();
}

function C_getMoveUrl(mode,method,act){
	var doc			= document.form;
	doc.action		= act;
	doc.mode.value	= mode;
	doc.method		= method;
	doc.submit();
}



function C_GetCookie( name ) { 
	var nameOfCookie = name + "="; 
	var x = 0; 
	while ( x <= document.cookie.length ){ 
		var y = (x+nameOfCookie.length); 
		if ( document.cookie.substring( x, y ) == nameOfCookie ) { 
			if ( (endOfCookie=document.cookie.indexOf( ";", y )) == -1 ) 
				endOfCookie = document.cookie.length; 
			return unescape( document.cookie.substring( y, endOfCookie ) ); 
		} 	
		x = document.cookie.indexOf( " ", x ) + 1; 
		if ( x == 0 ) 
			break; 
	} 
	return ""; 
}

function C_SetCookie(cKey, cValue) {
    var date = new Date(); 
    var validity = 7;
    date.setDate(date.getDate() + validity);
    document.cookie = cKey + '=' + escape(cValue) + ';expires=' + date.toGMTString();

}

function C_DelCookie(cKey) { 
    var date = new Date(); 
    var validity = -1;
    date.setDate(date.getDate() + validity);
    document.cookie = cKey + "=;expires=" + date.toGMTString();
}


function C_AjaxPost(name,url,params,method,lrgs) {

	if (C_isNull(lrgs))
	{
		lrgs = "";
	}

	C_AjaxPostEx(name,url,params,method, true,lrgs);
}

function C_AjaxPostEx(name, url, params, method, asynch, lrgs)
{
	if (window.XMLHttpRequest) {
		//code for IE7+, Firefox, Chrome, Opera, Safari
		xmlhttp=new XMLHttpRequest();
	}
	else {
		// code for IE6, IE5
		xmlhttp=new ActiveXObject("Microsoft.XMLHTTP");
	}

	xmlhttp.open(method, url, asynch);

	xmlhttp.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
	xmlhttp.setRequestHeader("Content-length", params.length);
	xmlhttp.setRequestHeader("Connection", "close");

	xmlhttp.onreadystatechange = function() 
	{
		if(xmlhttp.readyState == 4) {
			if (xmlhttp.status == 200) {
				if (name == "topProdSearch")
				{
					location.href = "./?menuType=product&mode=search&searchField=N&searchKey="+encodeURIComponent($("#topSearchKeyword").val());	
				} else {					
					goAjaxRet(name,xmlhttp.responseText,lrgs);
				}
			} // status==200
		} // readystate
	}; // onreadystate
	xmlhttp.send(params);
}

function C_topProdSearch(){

	if (C_isNull(strSiteJsLng))
	{
		strSiteJsLng = "KR";
	}

	if (strSiteJsLng == "KR")
	{
		var strAlertText = "검색어";
	}
		
	if (strSiteJsLng == "US")
	{
		strAlertText = "Search Text";
	}

	if (strSiteJsLng == "CN")
	{
		strAlertText = "Search Text";
	}

	if (strSiteJsLng == "JP")
	{
		strAlertText = "Search Text";
	}

	if (strSiteJsLng == "RU")
	{
		strAlertText = "Search Text";
	}

	if(!C_chkInput("topSearchKeyword",true,strAlertText,true)) return;	
	
	C_AjaxPost("topProdSearch","./?menuType=main&mode=json&act=topProdSearch","topSearchKeyword="+encodeURIComponent($("#topSearchKeyword").val()),"post"); 
}

// 3자리 마다 쉼표만 찍어주는 number_format 함수
function number_format( number )
{
  var nArr = String(number).split('').join(',').split('');
  for( var i=nArr.length-1, j=1; i>=0; i--, j++)  if( j%6 != 0 && j%2 == 0) nArr[i] = '';
  return nArr.join('');
 }


/**
 * 작성일 : 2013.06.13
 * 작성자 : kim hee sung
 * 내  용 : 공백 체크
 **/
function C_dataEmptyCheck() {
	
	var check = "";
	$("[data-empty-check]").each(function() {
		if(!check){
			var value	= $(this).val();
			var text	= $(this).attr("data-empty-check");
			if(!value) {
				alert(text);
				$(this).focus();
				check = "1";
			}
		}
	});

	return check;
}

/**
 * 2013.06.22 kim hee sung
 * C_getAddLocationUrl(data)
 * 기존 주소의 파라미터 + data
 * 단, DATA 값이 존제하면 업데이트
 * 2014.08.01 kim hee sung, IE9 버전에서 split 할때 쓰레기 데이터가 마지막 배열값으로 들어가집니다.
 **/
function C_getAddLocationUrl(data) {

	var href   = "";
	var param  = G_PHP_PARAM.split('&');
	var paramCnt = param.length;
	var i = 0;
	for(var par in param){

		// IE Bug
		if(paramCnt == i) { continue; } i++;
		
		var am = param[par].split('=');
		if(am[1] == "") { continue; }	
		for(var val in data){
			if(am[0] == val) { 
				am[1]		= data[val];
				data[val]	= "";
				break;
			}
		}
		if(href) { href = href + "&"; }
		href = href + am[0] + "=" + am[1];
	}
		

	for(var val in data){
		if(data[val] == "") { continue; }
		if(href) { href = href + "&"; }
		href = href + val + "=" + data[val];
	}

	location.href = "./?" + href;
}

/**
 * 2013.06.24 kim hee sung
 * C_getSelfAction(data)
 * form 문은 생성하여 post 방식으로 데이터 넘김
 **/
function C_getSelfAction(data){
	var form = $("<form></form>");
	form.attr("method","post");
	form.attr("action","./");
	form.appendTo('body');
	
	for(var name in data){
		var value	= data[name];
		var input	= "<input type='hidden' name='"+name+"' value='"+value+"'/>";
		form.append(input);
	}

	form.submit();
}

/**
 * 2013.06.24 kim hee sung
 * C_getSelfMove(data)
 * form 문은 생성하여 get 방식으로 데이터 넘김
 **/
function C_getSelfMove(data){
	var form = $("<form></form>");
	form.attr("method","get");
	form.attr("action","./");
	
	var strTarget = (data['_target']) ? data['_target'] : "_top";
	form.attr("target",strTarget);
	
	form.appendTo('body');
	
	for(var name in data){
		var value	= data[name];
		var input	= "<input type='hidden' name='"+name+"' value='"+value+"'/>";
		form.append(input);
	}

	form.submit();
}

function C_getJsonAjaxAction(name,url,data) {
	var href   = "";
	var param  = G_PHP_PARAM.split('&');
	for(var val in data){
		if(data[val] == "") { continue; }
		if(href) { href = href + "&"; }
		href = href + val + "=" + data[val];
	}
	
	C_AjaxPost(name,url,href,"post","");
}

/**
 * 2013.06.24 kim hee sung
 * C_getEscrowPopMoveUrl(data)
 * form 문은 생성하여 get 방식으로 데이터 넘김(에스크로 pg사 팝업창 연결)
 **/
function C_getEscrowPopMoveUrl(data,url,target){
	var form = $("<form></form>");
	form.attr("method","post");
	form.attr("action",url);
	if (target)
	{
		form.attr("target",target);
	}
	form.appendTo('body');
	
	for(var name in data){
		var value	= data[name];
		var input	= "<input type='hidden' name='"+name+"' value='"+value+"'/>";
		form.append(input);
	}

	form.submit();
}

/**
 * 2013.11.07 Kim hyun Ju
 *  C_getTabChange(myTarget, no) 
 * 버튼 클릭시 페이지 이동
 **/
function C_getTabChange(myTarget, no) {
	$("[id^="+myTarget+"]").css("display","none");
	$("[id="+myTarget+no+"]").css("display","");

	$("[id^=btn-"+myTarget+"]").removeClass("on");
	$("[id=btn-"+myTarget+no+"]").addClass("on");
}
/**
 * 2013.12.04 kim hee sung
 *  C_getPopup(url, sizeW, sizeH)
 * 윈도우 팝업 뛰우기
 **/
function C_getPopup(strUrl, sizeW, sizeH) {
    var LeftPosition		=(screen.width-sizeW)/2;
    var TopPosition		=(screen.height-sizeH)/2;

    window.open(strUrl, "", "TOP="+TopPosition+",LEFT="+LeftPosition+",WIDTH="+sizeW+",HEIGHT="+sizeH);
}

function C_getCeiling(n, pos) 
{
	if (pos == 0)
	{		
		var num		= (Math.ceil(n / 10) * 10);
	} else { 
		
		var digits	= Math.pow(10, pos);
		var num		= Math.ceil(n * digits) / digits;
		return num.toFixed(pos);
	}

	return num.toFixed(pos);
}


function sleep(delay) {
	var start = new Date().getTime();
	while (new Date().getTime() < start + delay);
}

/**
 * 2014.01.10 kim hee sung
 * C_getGoBack()
 * 뒤로가기
 **/
function C_getGoBack() {
	location.href = document.referrer;
}

/**
 * 2014.01.10 kim hee sung
 * C_getReLoad()
 * 다시로드
 **/
function C_getReLoad() {
	location.reload();
}

function C_getPageMoveEvent(page) {

	var data		= new Object();

	if(!page) { return; }

	data['page']	= page;

	C_getAddLocationUrl(data);
}

/**
 * 2014.06.14 kim hee sung
 * C_getHostTypeChangeActEvent()
 * 호스트 변경
 **/
function C_getHostTypeChangeActEvent(strHostType) {

	var data					= new Object();
	data['menuType']			= "main";
	data['mode']				= "json";
	data['act']					= "hostTypeModify";
	data['hostType']			= strHostType;

	$.ajax({
		url			: "./"
	   ,data		: data
	   ,type		: "POST"
	   ,dataType	: "json"
	   ,success		: function(data) {	

		   if(data['__STATE__'] == "SUCCESS") {
				var strHref = data['__DATA__']['URL'];
				if(!strHref) { strHref = "/"; }
				location.href = strHref;
		   } else {
				alert(data);
		   }

		}
	})
}

/**
 * 2014.06.27 kim hee sung
 * C_getCart()
 * 장바구니 페이지로 이동
 **/
function C_getCartMoveEvent() {

	var data = new Object();
	data['menuType'] = "order";
	data['mode'] = "cart";

	C_getSelfAction(data);
}

/**
 * 2014.07.18 kim hee sung
 * in_array(needle, haystack, argStrict)
 **/
function in_array(needle, haystack, argStrict) {
  //  discuss at: http://phpjs.org/functions/in_array/
  // original by: Kevin van Zonneveld (http://kevin.vanzonneveld.net)
  // improved by: vlado houba
  // improved by: Jonas Sciangula Street (Joni2Back)
  //    input by: Billy
  // bugfixed by: Brett Zamir (http://brett-zamir.me)
  //   example 1: in_array('van', ['Kevin', 'van', 'Zonneveld']);
  //   returns 1: true
  //   example 2: in_array('vlado', {0: 'Kevin', vlado: 'van', 1: 'Zonneveld'});
  //   returns 2: false
  //   example 3: in_array(1, ['1', '2', '3']);
  //   example 3: in_array(1, ['1', '2', '3'], false);
  //   returns 3: true
  //   returns 3: true
  //   example 4: in_array(1, ['1', '2', '3'], true);
  //   returns 4: false

  var key = '',
    strict = !! argStrict;

  //we prevent the double check (strict && arr[key] === ndl) || (!strict && arr[key] == ndl)
  //in just one for, in order to improve the performance 
  //deciding wich type of comparation will do before walk array
  if (strict) {
    for (key in haystack) {
      if (haystack[key] === needle) {
        return true;
      }
    }
  } else {
    for (key in haystack) {
      if (haystack[key] == needle) {
        return true;
      }
    }
  }

  return false;
}

/**
 * 2014.07.18 kim hee sung
 * callLangTrans(strText, aryData)
 * 문장 언어 변경
 **/
function callLangTrans(strText, aryData) {

	for(var i in aryData) {

		// 기본설정
		var bb = 1;
		var strTemp1 = '{{단어' + (Number(i) + 1) + '}}';
		var strTemp2 = aryData[i];		
		var objTemp1 = new RegExp(strTemp1, 'gi');
		strText = strText.replace(objTemp1, strTemp2);
	}

	return strText;
}

function fnOpenBrowser(url) {

	var filter = "win16|win32|win64|mac";
	if( navigator.platform  ){
	
		if( filter.indexOf(navigator.platform.toLowerCase())<0 ){
				try{
					if(fnCheckiPhone()){ //아이폰

							if( fnUserAgent() ){
								//var url = "/";
						 		//window.location = "snTec://login?URL="+url+"§†M_ID="+$("#login_id").val()+"§†API_URL=http://222.122.20.23/mobileApi.php";
						 		window.location = "sntec://nbrowser?url="+url;
						 		
						 		return;
							}
						 	
				 	}else{//안드로이드
				 			//window.SNT.setLogin($("#login_id").val());
				 			window.SNT.setOpenBrowser(url);
				 			return;
				 	}
				 	
				 	
				} catch(err) {
				}
		}
	}
		window.open(url);
		
	
}

function fnCheckiPhone() {
 var isios=(/(ipod|iphone|ipad)/i).test(navigator.userAgent);//ios

 if( isios ) return true;
 else return false;
}

function fnUserAgent() {
    userAgent = new String(navigator.userAgent);
    var versionStr = "none";
    
   if(userAgent.search("Safari") > -1) {
      versionStr = "Mozilla/4.0";
      return false;
   } else {
      versionStr = "What is yout UA?";
      return true;
   }
}