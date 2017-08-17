	/* 상품등록/수정 - 옵션 테이블 열기/닫기 */
	$(document).ready(function(){

		/* 이미지 복사 관련 */
		$("#prodImgCopy").change(function() {

			if($(this).attr("checked") == "checked"){
				$("#tabProdImg2").find("tr[id^=prodImgTrId]").each(function(i, t) {
					if(i!=0) { 
						$(t).find("input[type=file]").attr("disabled", true);
					}
				});
			} else {
				$("#tabProdImg2").find("tr[id^=prodImgTrId]").each(function(i, t) {
					if(i!=0) { 
						$(t).find("input[type=file]").attr("disabled", false);
					}
				});
			}
			
		});

		/* Openclose 관련 */
		var objGetData	= COOKIE.get('PRODUCT_OPEN_CLOSE');
		
		if(!objGetData) { return; }

		var aryGetData	= objGetData.split(",");
		
		for(var i=0;i<aryGetData.length;i++) {
			if(aryGetData[i]==1) {
				goFormOpenEvent(goOpenCloseKeyArray(i));
			}
		}
		
	});

	function goOpenCloseArray(objName) {
		var objAry					= new Array(6);
		objAry['prodOption']		= '0';
		objAry['addOption']			= '1';
		objAry['prodAdd']			= '2';
		objAry['mobileText']		= '3';
		objAry['prodHelpFile']		= '4';
		objAry['etcMemo']			= '5';

		return objAry[objName];		
	}

	function goOpenCloseKeyArray(objKey) {
		var objAry		= new Array(6);
		objAry[0]		= 'prodOption';
		objAry[1]		= 'addOption';
		objAry[2]		= 'prodAdd';
		objAry[3]		= 'mobileText';
		objAry[4]		= 'prodHelpFile';
		objAry[5]		= 'etcMemo';

		return objAry[objKey];		
	}


	function goFormOpenEvent(objName) { 
		var objBtn		= $("#"+objName+"Btn");
		var objArea		= $("#"+objName+"Area");

		$(objArea).css({'display':''});
		$(objBtn).attr("href", "javascript:goFormCloseEvent('"+objName+"')");
		$(objBtn).html("<span>닫기</span>");
		
		setOpenCloseCookie(objName, "1");
	}

	function goFormCloseEvent(objName) {

		var objBtn		= $("#"+objName+"Btn");
		var objArea		= $("#"+objName+"Area");

		$(objArea).css({'display':'none'});
		$(objBtn).attr("href", "javascript:goFormOpenEvent('"+objName+"')");
		$(objBtn).html("<span>열기</span>");

		setOpenCloseCookie(objName, "0");
	}

	function setOpenCloseCookie(objName, state) {
		/* 쿠키 관련 */
		var objNo		= goOpenCloseArray(objName);
		var objGetData	= COOKIE.get('PRODUCT_OPEN_CLOSE');
		var objSetData	= "0,0,0,0,0,0";

		if(objGetData) { objSetData = objGetData; }
		
		var arySetData		= objSetData.split(",");
		arySetData[objNo]	= state;
		objSetData			= arySetData.join(",");

		COOKIE.set('PRODUCT_OPEN_CLOSE', objSetData, 365);
	}


	var COOKIE = {
		set:function (n,v,e,t) {
			var expireDate = new Date();
			var cookieValue;
			
			switch ( t ) {
				case 'day' :
					expireDate.setDate(expireDate.getDate() + e);
					break;
				case 'hour' :
					expireDate.setTime(expireDate.getTime() + (e*60*60*1000));
					break;
				default :
					expireDate.setDate(expireDate.getDate() + e);
			}
			
			if ( e ) {
				cookieValue = escape(v)  + '; expires='+expireDate.toGMTString();
			} else {
				cookieValue = escape(v) ;
			}
			
			document.cookie = n + '=' + cookieValue + '; path=/';
		},
		
		get:function(n) {
			var cookies = document.cookie.split(';');
			var i, key, val, size, idx;
			
			size = cookies.length;
			
			for ( i=0; i<size; i++ ) {
				idx =  cookies[i].indexOf('=');
				key = cookies[i].substr(0, idx);
				val = cookies[i].substr(idx+1);			
				key = key.replace(/^\s+|\s+$/g,"");
				
				if ( key == n ) {
					return unescape(val);
				}
			}
		},
		
		del:function(n) {
			this.set(n,'',-1);
		}
	}


	function goSmartPop() {
		var prodLeng	= $("input[name=prodLang]").val(); 
		var url			= "./?menuType=product&mode=popProdRelated&leng=" + prodLeng;
		C_getTinyIFramePop(url);
	}

	function C_getTinyIFramePop(url) {
		TINY.box.show({
			 iframe			:url
			,boxid			:'frameless'
			,width			:800
			,height			:520
			,fixed			:false
			,maskid			:'bluemask'
			,maskopacity	:40
			,closejs		:function(){ }
		});
	}

//	function goProdRelatedCallback(obj) {
//		var code			= $("#prodRelatedListSampleCode").val();
//		var area			= $("#prodRelatedListArea");
//		var p_code			= "p_code_" + obj['P_CODE'];
//		var codeList		= $("#prodrelatedCodeList").val();
//
//		$(area).append(code).find("dl:last").attr("id", p_code);
//		$("#"+p_code).find("#pm_real_name").attr("src", obj['PM_REAL_NAME']);
//		$("#"+p_code).find("#p_code").text(obj['P_CODE']);
//		$("#"+p_code).find("#p_brand").text(obj['P_BRAND']);
//		$("#"+p_code).find("#p_name").text(obj['P_NAME']);
//		$("#"+p_code).find("#p_sale_price").text(obj['P_SALE_PRICE']);
//
//		if(codeList) { codeList = codeList + "," + obj['P_CODE']; }
//		else { codeList = obj['P_CODE']; }
//		$("#prodrelatedCodeList").val(codeList);
//	}

	function goProdRelatedCallback(obj) {
		var code			= $("#prodRelatedListSampleCode").val(); 
		var area			= $("#prodRelatedListArea");
		var p_code			= "p_code_" + obj['P_CODE'];
		var codeList		= $("#prodrelatedCodeList").val();
		
		code = $(code).attr("id", p_code);

		$(area).append(code);
		$("#"+p_code).find("#pm_real_name").attr("src", obj['PM_REAL_NAME']);
		$("#"+p_code).find("#p_code").text(obj['P_CODE']);
		$("#"+p_code).find("#p_brand").text(obj['P_BRAND']);
		$("#"+p_code).find("#p_name").text(obj['P_NAME']);
		$("#"+p_code).find("#p_sale_price").text(obj['P_SALE_PRICE']);

		if(codeList) { codeList = codeList + "," + obj['P_CODE']; }
		else { codeList = obj['P_CODE']; }
		$("#prodrelatedCodeList").val(codeList);
	}

	function getProdRelatedList() {
		var area			= $("#prodRelatedListArea");
		var intCnt			= $(area).find("ul").length;
		var obj				= new Array(intCnt);
		$(area).find("dl").each( function(i) {
			obj[i]						= new Array(5);
			obj[i]['P_CODE']			= $(this).find("#p_code").text();
			obj[i]['PM_REAL_NAME']		= $(this).find("#pm_real_name").attr("src");
			obj[i]['P_BRAND']			= $(this).find("#p_brand").text();
			obj[i]['P_NAME']			= $(this).find("#p_name").text();
			obj[i]['P_SALE_PRICE']		= $(this).find("#p_sale_price").text();
		});
		return obj;		
	}

	function getProdRelatedDelete(p_code) {
		$("#p_code_"+p_code).remove();
		var codeList		= $("#prodrelatedCodeList").val();
		var codeListNew		= "";
		var aryCodeList		=  codeList.split(",");
		var lan				= aryCodeList.length;
		for(var i=0; i<lan; i++) {
			if(p_code != aryCodeList[i]) {
				if(codeListNew) { codeListNew = codeListNew + "," + aryCodeList[i]; }
				else { codeListNew = aryCodeList[i]; }
			}
		}
		$("#prodrelatedCodeList").val(codeListNew);
	}



