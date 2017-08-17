	//상품장바구니담기
	function goAddCartEvent(strAppID,prodCode,prodOptCnt)
	{
		var objLanguage				= G_APP_PARAM[strAppID]['LANGUAGE'];

		var data					= new Object();

//		data['menuType']			= "product";
//		data['mode']				= "json";
//		data['act']					= "cart";
//		data['prodCode']			= prodCode;		
		

		data['appId']				= strAppID;	
		data['menuType']			= "product";
		data['mode']				= "json";
		data['act']					= "prodAddCartHtml";
		data['prodCode']			= prodCode;	
		data['callPage']			= "main";

			
//			C_getSelfAction(data);	
//			return;
		$.ajax({
			url			: "./"
		   ,data		: data
		   ,type		: "POST"
		   ,dataType	: "json"
		   ,success		: function(data){
								if (data[0].RET == "Y")
								{
									
									$("div[id^=prodAddCart_]").css("display","none");
									$("#prodAddCart_"+prodCode).css("display","");
									$("#prodAddCart_"+prodCode).find("#optionTable").html(data[0].HTML);
									
									G_APP_PARAM[strAppID]['PRODUCT_OPT']			= data[0].PROD_OPT_JSON;
									G_APP_PARAM[strAppID]['PRODUCT_ROW']			= data[0].PROD_ROW_JSON;
									G_APP_PARAM[strAppID]['PRODUCT_OPT_ATTR']		= data[0].PROD_OPT_ATTR_JSON;
									G_APP_PARAM[strAppID]['PRODUCT_ADD_OPT']		= data[0].PROD_ADD_OPT_JSON;
									G_APP_PARAM[strAppID]['PRODUCT_ADD_OPT_ATTR']	= data[0].PROD_ADD_OPT_ATTR_JSON;
									
									$("#prodAddCart_"+prodCode).find("#qty").live("blur",function(){
										goAddCartQtyEvent(strAppID,prodCode,"");
									});

									goAddCartTotal(strAppID,prodCode);
								}		 					
						  }	
		});
		return;
	}
	
	//상품옵션change
	function goAddCartSelectEvent(strAppID,strProdCode,selObj,sort){
		var intCartQty			= 1;		
		var arySelProdOpt		= selObj.split("_");
		var intProdOptNo		= arySelProdOpt[1];  //옵션번호
		var intNextSort			= sort + 1;			 //옵션다음순서
	
		var aryProdOptName		= new Object();
		var aryProdOptAttrVal	= new Object();

		var aryProdRow			= JSON.parse(G_APP_PARAM[strAppID]['PRODUCT_ROW']);
		var aryProdOpt			= JSON.parse(G_APP_PARAM[strAppID]['PRODUCT_OPT']);
		var aryProdOptAttr		= G_APP_PARAM[strAppID]['PRODUCT_OPT_ATTR'];
		var objLanguage			= G_APP_PARAM[strAppID]['LANGUAGE'];

		aryProdOptName[1]		= aryProdOpt[intProdOptNo].PO_NAME1;
		aryProdOptName[2]		= aryProdOpt[intProdOptNo].PO_NAME2;
		aryProdOptName[3]		= aryProdOpt[intProdOptNo].PO_NAME3;
		aryProdOptName[4]		= aryProdOpt[intProdOptNo].PO_NAME4;
		aryProdOptName[5]		= aryProdOpt[intProdOptNo].PO_NAME5;
		aryProdOptName[6]		= aryProdOpt[intProdOptNo].PO_NAME6;
		aryProdOptName[7]		= aryProdOpt[intProdOptNo].PO_NAME7;
		aryProdOptName[8]		= aryProdOpt[intProdOptNo].PO_NAME8;
		aryProdOptName[9]		= aryProdOpt[intProdOptNo].PO_NAME9;
		aryProdOptName[10]		= aryProdOpt[intProdOptNo].PO_NAME10;
		
		var intProdOptCnt  = 0;
		for(var i=1;i<=10;i++){
			if (aryProdOptName[i])
			{
				intProdOptCnt++;
				var strProdAttrVal = $("#cartOpt"+i+"_"+intProdOptNo+" option:selected").val();
				if (C_isNull(strProdAttrVal))
				{
					strProdAttrVal = "";
				}

				if (i < intNextSort)
				{
					aryProdOptAttrVal[i] = strProdAttrVal;
				} else {
					aryProdOptAttrVal[i] = "";
				}
			} else {
				aryProdOptAttrVal[i] = "";
			}
		}

		var strJsonParam = "&optNo="+intProdOptNo;
		strJsonParam += "&optAttr1="+encodeURIComponent(aryProdOptAttrVal[1]);
		strJsonParam += "&optAttr2="+encodeURIComponent(aryProdOptAttrVal[2]);
		strJsonParam += "&optAttr3="+encodeURIComponent(aryProdOptAttrVal[3]);
		strJsonParam += "&optAttr4="+encodeURIComponent(aryProdOptAttrVal[4]);
		strJsonParam += "&optAttr5="+encodeURIComponent(aryProdOptAttrVal[5]);
		strJsonParam += "&optAttr6="+encodeURIComponent(aryProdOptAttrVal[6]);
		strJsonParam += "&optAttr7="+encodeURIComponent(aryProdOptAttrVal[7]);
		strJsonParam += "&optAttr8="+encodeURIComponent(aryProdOptAttrVal[8]);
		strJsonParam += "&optAttr9="+encodeURIComponent(aryProdOptAttrVal[9]);
		strJsonParam += "&optAttr10="+encodeURIComponent(aryProdOptAttrVal[10]);
		strJsonParam += "&optAttrSort="+intNextSort;

		if (aryProdRow.P_OPT != "2")
		{
			if (!C_isNull(aryProdOptName[intNextSort]))
			{
				$.getJSON("./?menuType=product&mode=json&act=prodOptAttr2"+strJsonParam,function(data){	
					
					$("#cartOpt"+intNextSort+"_"+intProdOptNo).empty().data('options'); 

					var strSelectIndexText = ":: " + objLanguage['PW00010'] + " ::"; //선택
					if (aryProdOpt[intProdOptNo].PO_ESS == "Y")
					{
						strSelectIndexText = ":: " + objLanguage['PW00010'] + " ::"; //(필수) 선택
					}
					$("#cartOpt"+intNextSort+"_"+intProdOptNo).append("<option value=''>"+strSelectIndexText+"</option>");

					for(var i=0;i<data[intProdOptNo][intNextSort].length;i++){
						$("#cartOpt"+intNextSort+"_"+intProdOptNo).append("<option value='"+data[intProdOptNo][intNextSort][i].POA_ATTR+"'>"+data[intProdOptNo][intNextSort][i].POA_ATTR+"</option>");
					}
				})
				
				return;
			} else {

				/* 옵션 마지막 선택 */
				if (intProdOptCnt == sort)
				{
					
					if (!C_isNull(intProdOptNo))
					{
						$.getJSON("./?menuType=product&mode=json&act=prodOptAttrNo"+strJsonParam,function(data){	
						
							if (aryProdRow.P_STOCK_LIMIT != "Y"){
								if (aryProdRow.P_STOCK_OUT != "Y" && aryProdRow.P_QTY > 0){
									if (parseInt(data[0].POA_STOCK_QTY) < 1)
									{
										alert(objLanguage['OS00029']); //상품의 재고량("+data[0].POA_STOCK_QTY+"개)보다 구매수량이 많습니다.
										return;
									}
								}
							}
								
							var strProdOptVal		= "";
							for(var k=1;k<=intProdOptCnt;k++){

								if (k == 1) strProdOptVal += aryProdOpt[data[0].PO_NO].PO_NAME1+":"+data[0].POA_ATTR1;
								if (k == 2) strProdOptVal += aryProdOpt[data[0].PO_NO].PO_NAME2+":"+data[0].POA_ATTR2;
								if (k == 3) strProdOptVal += aryProdOpt[data[0].PO_NO].PO_NAME3+":"+data[0].POA_ATTR3;
								if (k == 4) strProdOptVal += aryProdOpt[data[0].PO_NO].PO_NAME4+":"+data[0].POA_ATTR4;
								if (k == 5) strProdOptVal += aryProdOpt[data[0].PO_NO].PO_NAME5+":"+data[0].POA_ATTR5;
								if (k == 6) strProdOptVal += aryProdOpt[data[0].PO_NO].PO_NAME6+":"+data[0].POA_ATTR6;
								if (k == 7) strProdOptVal += aryProdOpt[data[0].PO_NO].PO_NAME7+":"+data[0].POA_ATTR7;
								if (k == 8) strProdOptVal += aryProdOpt[data[0].PO_NO].PO_NAME8+":"+data[0].POA_ATTR8;
								if (k == 9) strProdOptVal += aryProdOpt[data[0].PO_NO].PO_NAME9+":"+data[0].POA_ATTR9;
								if (k == 10) strProdOptVal += aryProdOpt[data[0].PO_NO].PO_NAME10+":"+data[0].POA_ATTR10;
								
								if (k != intProdOptCnt) strProdOptVal += "<br>";
							}

							var intProdOptPrice		= "";
							var intProdOptPrice2	= "";
							if (G_APP_PARAM[strAppID]['SITE_LNG_USD_YN'] == "Y")
							{
								intProdOptPrice		= aryProdRow.P_SALE_PRICE_USD;
								intProdOptPrice2	= aryProdRow.P_SALE_PRICE;

							} else {
								intProdOptPrice		= aryProdRow.P_SALE_PRICE;
							}

							if (aryProdRow.P_OPT != "1"){ 
								if (G_APP_PARAM[strAppID]['SITE_LNG_USD_YN'] == "Y"){
									intProdOptPrice  = data[0].POA_SALE_PRICE_USD;
									intProdOptPrice2 = data[0].POA_SALE_PRICE;
								} else {
									intProdOptPrice = data[0].POA_SALE_PRICE;
								}
							}
							
							goAddCartDrawHtml(strAppID,strProdCode,data[0].POA_NO,strProdOptVal,intProdOptPrice,intProdOptPrice2);
						});
					}
				}
			}
		} else {
			
			/* 일체형 수량 체크*/
			var intProdOptAttrNo = $("#"+selObj+" option:selected").val();	
			
			if (aryProdRow.P_STOCK_LIMIT != "Y"){
				if (aryProdRow.P_STOCK_OUT != "Y" && aryProdRow.P_QTY > 0){
					if (parseInt(aryProdOptAttr[intProdOptAttrNo].POA_STOCK_QTY) < 1)
					{
						alert(objLanguage['OS00029']); //상품의 재고량("+data[0].POA_STOCK_QTY+"개)보다 구매수량이 많습니다.
						return;
					}
				}
			}
			
			if (G_APP_PARAM[strAppID]['SITE_LNG_USD_YN'] == "Y"){
				goAddCartDrawHtml(strAppID,strProdCode,intProdOptAttrNo,"",aryProdOptAttr[intProdOptAttrNo].POA_SALE_PRICE_USD,aryProdOptAttr[intProdOptAttrNo].POA_SALE_PRICE);
			}else {
				goAddCartDrawHtml(strAppID,strProdCode,intProdOptAttrNo,"",aryProdOptAttr[intProdOptAttrNo].POA_SALE_PRICE,0);
			}
			
		}
	}

	//상품옵션정보그리기
	function goAddCartDrawHtml(strAppID,strProdCode,intOptNo,strProdOptVal,intProdOptPrice,intProdOptPrice2){
		var strProdOptHiddenHtml	= "<input type=\"hidden\" name=\"cartOptNo\" id=\"cartOptNo\" value=\""+intOptNo+"\">";
		var objAddCart				= $("#prodAddCart_"+strProdCode);
	
		if ($("#prodAddCart_"+strProdCode).find("#cartOptNo").val())
		{
			$("#prodAddCart_"+strProdCode).find("#cartOptNo").val(intOptNo);
		} else {
			objAddCart.find("#optionTable").append(strProdOptHiddenHtml);
		}
		
		goAddCartTotal(strAppID,strProdCode);
	}

	//상품옵션총합구하기
	function goAddCartTotal(strAppID,prodCode){
		var aryProdRow				= JSON.parse(G_APP_PARAM[strAppID]['PRODUCT_ROW']);

		var aryProdOptAttr			= G_APP_PARAM[strAppID]['PRODUCT_OPT_ATTR'];
		
		var intProdOptAttrNo		= $("#cartOptNo").val();
		var intProdOptPrice			= 0;
		var intProdQty				= parseInt($("#prodAddCart_"+prodCode).find("#qty").val());
		
		if (!C_isNull(aryProdOptAttr))
		{		
			if (intProdOptAttrNo > 0)
			{	
				if (aryProdRow.P_OPT == 1)
				{
					intProdOptPrice			= aryProdRow.P_SALE_PRICE;
					if (G_APP_PARAM[strAppID]['SITE_LNG_USD_YN'] == "Y"){
						intProdOptPrice		= aryProdRow.P_SALE_PRICE_USD;
					}
				} else {
					intProdOptPrice			= aryProdOptAttr[intProdOptAttrNo].POA_SALE_PRICE;
					if (G_APP_PARAM[strAppID]['SITE_LNG_USD_YN'] == "Y"){
						intProdOptPrice		= aryProdOptAttr[intProdOptAttrNo].POA_SALE_PRICE_USD;
					}
				}
			} else {
				intProdOptPrice				= aryProdRow.P_SALE_PRICE;
				if (G_APP_PARAM[strAppID]['SITE_LNG_USD_YN'] == "Y"){
					intProdOptPrice			= aryProdRow.P_SALE_PRICE_USD;
				}
			}
		} else {
			intProdOptPrice				= aryProdRow.P_SALE_PRICE;
			if (G_APP_PARAM[strAppID]['SITE_LNG_USD_YN'] == "Y"){
				intProdOptPrice			= aryProdRow.P_SALE_PRICE_USD;
			}		
		}
		
		//총옵션합계
		intProdOptPrice					= (parseFloat(C_removeComma(intProdOptPrice)) * intProdQty);
		
		var intProdAddOptPrice		= 0;
		$("#prodAddCart_"+prodCode).find("#optionTable").find("input[id^=cartAddOptNo_no_]").each(function(){
			var objProdAddOptPrice		= $(this).attr("name").replace("_no_","_price_");
			var objProdAddOptOrgPrice	= $(this).attr("name").replace("_no_","Org_price_");
			
			intProdAddOptPrice			= parseFloat(C_removeComma(intProdAddOptPrice)) + parseFloat(C_removeComma($("#"+objProdAddOptPrice).val()));
		});

		var intProdTotalPrice			= parseFloat(intProdOptPrice) + parseFloat(intProdAddOptPrice);
		
		$("#prodAddCart_"+prodCode).find("#prodAddCartTotal").text(intProdTotalPrice);				   
		if (G_APP_PARAM[strAppID]['SITE_CUR'] == "KRW" || G_APP_PARAM[strAppID]['SITE_CUR'] == "JPY" || G_APP_PARAM[strAppID]['SITE_CUR'] == "RUB")
		{
			$("#prodAddCart_"+prodCode).find("#prodAddCartTotal").formatCurrency({symbol: '',roundToDecimalPlace:0});
		} else {
			$("#prodAddCart_"+prodCode).find("#prodAddCartTotal").formatCurrency({symbol: ''});
		}
		intProdTotalPrice = $("#prodAddCart_"+prodCode).find("#prodAddCartTotal").text();
		
		var strProdAddCartPricTotal		= G_APP_PARAM[strAppID]['SITE_CUR_MARK1'] + intProdTotalPrice + G_APP_PARAM[strAppID]['SITE_CUR_MARK2'];		
		$("#prodAddCart_"+prodCode).find("#prodAddCartTotal").text(strProdAddCartPricTotal);	
		$("#prodAddCart_"+prodCode).find("#optionTable2").find(".price").html(strProdAddCartPricTotal);
	}

	//상품옵션장바구니ACT
	function goAddCartOptEvent(strAppID,prodCode)
	{
		var objLanguage					= G_APP_PARAM[strAppID]['LANGUAGE'];

		var data						= new Object();

		data['menuType']				= "product";
		data['mode']					= "json";
		data['act']						= "cart";
		data['prodCode']				= prodCode;		
		
		var intProdOptNo				= (!C_isNull($("#cartOptNo").val())) ? $("#cartOptNo").val() : "0";
		data['cartOptNo[0]']			= intProdOptNo;
		data[intProdOptNo+'_cartQty']	= $("#prodAddCart_"+prodCode).find("#qty").val();
		
		$("#prodAddCart_"+prodCode).find("#optionTable").find("input[id^=cartAddOptNo_no_]").each(function(){
			data[intProdOptNo+$(this).attr("name")+"[0]"] = $(this).val();
			data[intProdOptNo+$(this).attr("name").replace("_no_","_qty_")+"[0]"] = "1";
		});
		
		$.ajax({
			url			: "./"
		   ,data		: data
		   ,type		: "POST"
		   ,dataType	: "json"
		   ,success		: function(data) {	

							if (data[0].RET == "Y")
								{
									//$("#prodAddCart_"+prodCode).css("display","none");
									$("#prodAddCart_"+prodCode).find("#optionTable").html("");
									$("#prodAddCart_"+prodCode).find("#divOptionArea").css("display","none");
									$("#prodAddCart_"+prodCode).find("#optionTable3").css("display","");

								} else {

									$("#prodAddCart_"+prodCode).find("#divOptionArea").css("display","none");
									$("#prodAddCart_"+prodCode).find("#optionTable3").css("display","");

									$("#prodAddCart_"+prodCode).find("#optionTable3 .txtBox").html(data[0].MSG);
									$("#prodAddCart_"+prodCode).find("#optionTable3 #btnAddCartMove").css("display","none");
									
									return;
								} 					
						  }	
		});
	}


	//상품추가옵션선택
	function goAddCartAddSelectEvent(strAppID,prodCode,selObj,no){
		
		var aryProdRow			= JSON.parse(G_APP_PARAM[strAppID]['PRODUCT_ROW']);
		var aryProdOpt			= JSON.parse(G_APP_PARAM[strAppID]['PRODUCT_OPT']);
		var aryProdAddOpt		= JSON.parse(G_APP_PARAM[strAppID]['PRODUCT_ADD_OPT']);
		var aryProdAddOptAttr	= JSON.parse(G_APP_PARAM[strAppID]['PRODUCT_ADD_OPT_ATTR']);
		var	aryProdAddOptList	= new Object();

		if (!C_isNull(aryProdAddOpt) && aryProdAddOpt.length > 0)
		{
			for(var i=0;i<aryProdAddOpt.length;i++){
				aryProdAddOptList[i] = aryProdAddOpt[$i][PO_NO];
			}
		}
		
		if (aryProdRow.P_ADD_OPT == "Y")
		{			
			
			/* 옵션 필수사항 체크 */
			var intProdOptEssCnt = 0;
			var intProdOptErrCnt = 0; 
			if (!C_isNull(aryProdOptList) && aryProdOptList.length > 0)
			{							
				for(var i=0;i<aryProdOptList.length;i++){
				
					var intPO_NO		= aryProdOptList[i];
					var strProdOptEssYN = aryProdOpt[intPO_NO].PO_ESS;
					
					if (strProdOptEssYN == "Y"){
						intProdOptEssCnt++;
					}
					
					var intProdOptNo	= $("#cartOptNo").val();
					if (intProdOptNo > 0 )
					{
						intProdOptErrCnt++;
					}
				}
				
				if (intProdOptEssCnt != intProdOptErrCnt)
				{
					if (!C_isNull(aryProdAddOptList) && aryProdAddOptList.length > 0)
					{
						$("#cartAddOpt_"+no).val("");
					}
					alert("<?=$LNG_TRANS_CHAR['PS00009']?>"); //추가옵션을 하나 이상 선택해주세요.
					return;
				}
			}
			/* 옵션 필수사항 체크 */
			var intPAO_NO =  $("#cartAddOpt_"+no+" option:selected").val();
			var intProdAddOptAttrPrice1 = (G_APP_PARAM[strAppID]['SITE_LNG_USD_YN'] == "Y") ? aryProdAddOptAttr[intPAO_NO].PAO_PRICE_USD : aryProdAddOptAttr[intPAO_NO].PAO_PRICE;
			var intProdAddOptAttrPrice2 = (G_APP_PARAM[strAppID]['SITE_LNG_USD_YN'] == "Y") ? aryProdAddOptAttr[intPAO_NO].PAO_PRICE : 0;
			
			var strCartAddOptAttrHidden = "<input type=\"hidden\" name=\"cartAddOptNo_no_"+no+"\"  id=\"cartAddOptNo_no_"+no+"\" value=\""+intPAO_NO+"\">";
				strCartAddOptAttrHidden += "<input type=\"hidden\" name=\"cartAddOptNo_price_"+no+"\"  id=\"cartAddOptNo_price_"+no+"\" value=\""+intProdAddOptAttrPrice1+"\">";
				strCartAddOptAttrHidden += "<input type=\"hidden\" name=\"cartAddOptNoOrg_price_"+no+"\"  id=\"cartAddOptNoOrg_price_"+no+"\" value=\""+intProdAddOptAttrPrice2+"\">";
			
			if ($("#prodAddCart_"+prodCode).find("#optionTable").find("#cartAddOptNo_no_"+no).val())
			{
				$("#prodAddCart_"+prodCode).find("#optionTable").find("#cartAddOptNo_no_"+no).val(intPAO_NO);
				$("#prodAddCart_"+prodCode).find("#optionTable").find("#cartAddOptNo_price_"+no).val(intProdAddOptAttrPrice1);
				$("#prodAddCart_"+prodCode).find("#optionTable").find("#cartAddOptNoOrg_price_"+no).val(intProdAddOptAttrPrice2);

			} else{
				$("#prodAddCart_"+prodCode).find("#optionTable").append(strCartAddOptAttrHidden);
			}
			
			//alert($("#prodAddCart_"+prodCode).find("#optionTable").html());
			goAddCartTotal(strAppID,prodCode);
		}		
	}
	
	//수량업데이트
	function goAddCartQtyEvent(strAppID,prodCode,type){
		var intProdQty		= parseInt($("#prodAddCart_"+prodCode).find("#qty").val());
		var aryProdRow		= JSON.parse(G_APP_PARAM[strAppID]['PRODUCT_ROW']);
		var intProdMinQty	= aryProdRow.P_MIN_QTY;
		
		if (!intProdQty) intProdQty = 1;
		
		if (type != "")
		{		
			if (type == "up")
			{
				intProdQty = intProdQty + 1;
			} else {
				intProdQty = intProdQty - 1;
			}
		}

		if (intProdQty < intProdMinQty)
		{
			intProdQty = intProdMinQty;
		}

		$("#prodAddCart_"+prodCode).find("#qty").val(intProdQty);
		goAddCartTotal(strAppID,prodCode);
	}

	//레이어창 닫기
	function goAddCartCloseEvent(strAppID,prodCode){

		var objLanguage				= G_APP_PARAM[strAppID]['LANGUAGE'];

		var strProdAddCartPricTotal		= G_APP_PARAM[strAppID]['SITE_CUR_MARK1'] + 0 + G_APP_PARAM[strAppID]['SITE_CUR_MARK2'];

		$("#prodAddCart_"+prodCode).css("display","none");
		$("#prodAddCart_"+prodCode).find("#optionTable").html("");
		$("#prodAddCart_"+prodCode).find("#divOptionArea").css("display","");
		$("#prodAddCart_"+prodCode).find("#optionTable2 .price").html(strProdAddCartPricTotal);
		$("#prodAddCart_"+prodCode).find("#optionTable3").css("display","none");

		$("#prodAddCart_"+prodCode).find("#optionTable3 .txtBox").html(objLanguage['OS00013']);
		$("#prodAddCart_"+prodCode).find("#optionTable3 #btnAddCartMove").css("display","");
	}

	//장바구니창으로 이동
	function goAddCartMoveEvent(){
		var data					= new Object();
		data['menuType']			= "order";
		data['mode']				= "cart";
		data['act']					= "";

		C_getAddLocationUrl(data);	
	}