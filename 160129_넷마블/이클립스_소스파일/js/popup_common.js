

// PC : 프로젝트
// DT : 귀속팀   (귀속조직)
// DE : 귀속부서 (귀속본부)
// CU : 거래처
// CO : 국가
// GM : 게임명
// IV : 인보이스
// CT : 계약
// HR : 사원
// AC : 계정명
// TA : 비용항목
function fnShortCutSearch(searchParam, type, param, fnName){

	var url = "";
	if(isNull(fnName))
	{ fnName = ""; }
	
	var paramVal = "";

	if(type == "PC")			//프로젝트
	{
		url = "/cmmn/searchProjectCd.do";
		
		var schBsnsTyCd = getQueryVariable(param, "schBsnsTyCd");
		var schDmstFrgnTyCd = getQueryVariable(param, "schDmstFrgnTyCd");
		var schSrvcTyCd = getQueryVariable(param, "schSrvcTyCd");
		var prjtLvl = getQueryVariable(param, "lvl");
		var useYn = getQueryVariable(param, "useyn");
		var rsltFillYn = getQueryVariable(param, "rsltFillYn");
		var cstmCd = getQueryVariable(param, "cstmCd");
		
		
		paramVal =
		{
			"schBsnsTyCd" : schBsnsTyCd,
			"schDmstFrgnTyCd" : schDmstFrgnTyCd,
			"schSrvcTyCd" : schSrvcTyCd,
			"prjtLvl" : prjtLvl,
			"useYn" : useYn,
			"rsltFillYn" : rsltFillYn,
			"cstmCd" : cstmCd
		};
		
	}
	else if(type == "DT")		//귀속조직
	{
		
		var makeDateTo = "";
		var makeDateFrom = "";
		if(!isNull(getQueryVariable(param, "makeDateTo")))
		{
			makeDateTo = String(getQueryVariable(param, "makeDateTo"));
			makeDateTo = makeDateTo.replace(/-/g,"");
		}
		if(!isNull(getQueryVariable(param, "makeDateFrom")))
		{
			makeDateFrom = String(getQueryVariable(param, "makeDateFrom"));
			makeDateFrom = makeDateFrom.replace(/-/g,"");
		}

		
		var a3 = getQueryVariable(param, "a3");
		var departCd = getQueryVariable(param, "departCd");
		
		paramVal =
		{
			"makeDateTo" : makeDateTo,
			"makeDateFrom" : makeDateFrom,
			"a3" : a3,
			"departCd" : departCd,
		};
		
		url = "/cmmn/searchCostCntrNm.do";
	}
	else if(type == "DE")		//귀속부서
	{
		url = "/cmmn/searchBlngCntrNm.do";
	}
	else if(type == "CU")		//거래처
	{
		
		
		var cstmTyCd = getQueryVariable(param, "cstmTyCd");
		
		
		paramVal =
		{
			"cstmTyCd" : cstmTyCd,
		};
		
		cstmTyCd = "";
		
		url = "/cmmn/searchCustomerNm.do";
	}
	else if(type == "CO")		//국가
	{
		url = "/cmmn/searchCountryNm.do";
	}
	else if(type == "GM")		//게임
	{
		var bsnsTyCd = getQueryVariable(param, "bsnsTy");
		paramVal =
		{
			"bsnsTyCd" : bsnsTyCd,
		};
		
		bsnsTyCd= "";
		
		url = "/cmmn/searchGameNm.do";
	}
	else if(type == "IV")
	{
		url = "";
	}
	else if(type == "CT")		//계약
	{
		var ctrtTy = getQueryVariable(param, "ctrtTy");
		paramVal =
		{
			"ctrtTy" : ctrtTy,
		};
		
		ctrtTy ="";
		
		url = "/cmmn/serachContractNm.do";
	}
	else if(type == "HR")		//사원
	{
		url = "/cmmn/searchHrNm.do";
	}
	else if(type == "AC") 		//계정
	{
		url = "/cmmn/searchAccountNm.do";
	}
	else if(type == "SC")		//자회사
	{
		url = "/rifc/searchSubCpnyNm.do";
	}
	else if(type == "TA")		//비용항목
	{
		url = "/cmmn/searchTitleOfAccountNm.do";
	}
	else if(type == "ERP")
	{
		
		
		var saleTy = getQueryVariable(param, "saleTy");
		var slipGrupCd = getQueryVariable(param, "slipGrupCd");
		
		
		paramVal =
		{
			"saleType" : saleTy,
			"slipGrupCd" : slipGrupCd
		};
		
		
		if(saleTy == "RFND")
		{
			//alert("여기들어오니?1");
			url = "/cmmn/searchErpNoRfnd.do";
		}	
		else
		{
			url = "/cmmn/searchErpNo.do";
		
		}
	
		
	}
	else if(type == "CR")		//수신자
	{
		
		var cstmCd = getQueryVariable(param, "getCstmCd");
		paramVal =
		{
			"cstmCd" : cstmCd,
		};
		
		cstmCd = "";
		
		url = "/cmmn/searchCstmRecv.do";
	}

	
	$.ajax({
		type : "POST",
		url : url,
		data : {"searchParam" : searchParam, "paramVal" : paramVal},
		dataType: "json",
		contentType: "application/x-www-form-urlencoded;charset=utf-8",
		error : function(x, e, data) {
			alert("data1 ::"+data);
			if (x.status == 0) {
				alert('You are offline!!\n Please Check Your Network.');
			} else if (x.status == 404) {
				alert('Requested URL not found.');
			} else if (x.status == 500) {
				alert('Internel Server Error.');
			} else if (e == 'parsererror') {
				alert('Error.nParsing JSON Request failed.');
			} else if (e == 'timeout') {
				alert('Request Time out.');
			} else {
				alert('Unknow Error.n' + x.responseText);
			}
		},
		success : function(data) {

			//alert("Jonathan ::" + data.list.length );

			if(data.list.length == 0)
			{
				alert("조건에 해당하는 값이 없습니다.");

				if(type == "PC")
				{
					if(param == "pop=true")
					{
						fnProjectCdOnPopup(searchParam, param, "", fnName);	//프로젝트 팝업 띄우기
					}
					else
					{
						fnProjectCdPopup(searchParam, param, "", fnName);	//프로젝트 팝업 띄우기
					}


				}
				else if(type == "DT")
				{
					//alert("팀");
					//data.list[0].nSel = getQueryVariable(param, "index");
					if("true" == getQueryVariable(param, "pop") )
					{
						fnDepartTeamOnPopup(searchParam, param, "", fnName); 	// 귀속팀 팝업 띄우기
					}
					else
					{
						fnDepartTeamPopup(searchParam, param, "", fnName); 	// 귀속팀 팝업 띄우기
					}
					
				}
				else if(type == "DE")
				{
					//alert("부서");
					fnDepartPopup(searchParam, param, "", fnName); 	// 귀속부서 팝업 띄우기
				}
				else if(type == "CU")
				{
					
					if("true" == getQueryVariable(param, "pop") )
					{
						//alert("Jonathan :: " + fnName);
						fnCustomerOnPopup(searchParam, param, "", fnName); 	// 팝업위에 거래처 팝업 띄우기
						
					}
					else
					{
						fnCustomerPopup(searchParam, param, "", fnName); 	// 거래처 팝업 띄우기
					}
					/*
					
					if(param == "pop=true")
					{
						fnCustomerOnPopup(searchParam, param, "", fnName); // 개발사(거래처) 팝업 띄우기
					}
					else
					{
						//alert("4");
						fnCustomerPopup(searchParam, param, "", fnName); // 개발사(거래처) 팝업 띄우기
					}
					*/
				}
				else if(type == "CO")
				{
					fnCountryPopup(searchParam, param, "", fnName); // 국가 팝업 띄우기
				}
				else if(type == "GM")
				{
					//fnGameNmPopup(gameNm, getParam , paramVal, fnName)
					fnGameNmPopup(searchParam, param, "", fnName);
				}
				else if(type == "IV")
				{

				}
				else if(type == "CC")
				{

				}
				else if(type == "CT")
				{
					if("true" == getQueryVariable(param, "pop") )
					{
						fnContractOnPopup(searchParam, param, "", fnName); 	// 팝업위에 사원 팝업 띄우기
						
					}
					else
					{
						fnContractPopup(searchParam, param, "", fnName); // 사원 팝업 띄우기
					}
					
					
					//fnContractPopup(searchParam, param, "", fnName);
				}
				else if(type == "HR")
				{
					if("true" == getQueryVariable(param, "pop") )
					{
						fnHrPopupOnPopup(searchParam, param, "", fnName); 	// 팝업위에 사원 팝업 띄우기
						
					}
					else
					{
						fnHrPopup(searchParam, param, "", fnName); // 사원 팝업 띄우기
					}
					
					
					//fnHrPopup(searchParam, param, "", fnName); // 사원 팝업 띄우기
				}
				else if(type == "AC")
				{
					fnAccountPopup(searchParam, param, "", fnName); // 계정 팝업 띄우기
				}
				else if(type == "SC")
				{
					fnSubCpnyCdPopup(searchParam, param, "", fnName);
				}
				else if(type == "TA")
				{
					fnTitleofAccountPop(searchParam, param, "", fnName);
				}
				else if(type == "ERP" || type == "RFND" || type == "ESTM")
				{
					fnErpPopup(searchParam, param, "", fnName);
				}
				else if(type == "CR")
				{
					fnCustomerReceiverPopup(searchParam, param, "", fnName);
				}
				


			}
			else if(data.list.length > 1)	// 검색된 값이 2개 이상일때 팝업
			{
				if(type == "PC")
				{
					if(param == "pop=true")
					{
						fnProjectCdOnPopup(searchParam, param, "", fnName);	//프로젝트 팝업 띄우기
					}
					else
					{
						fnProjectCdPopup(searchParam, param, "", fnName);	//프로젝트 팝업 띄우기
					}

				}
				else if(type == "DT")
				{
					//alert("팀");
					if("true" == getQueryVariable(param, "pop") )
					{
						fnDepartTeamOnPopup(searchParam, param, "", fnName); 	// 귀속팀 팝업 띄우기
					}
					else
					{
						fnDepartTeamPopup(searchParam, param, "", fnName); 	// 귀속팀 팝업 띄우기
					}
				}
				else if(type == "DE")
				{
					//alert("부서");
					fnDepartPopup(searchParam, param, "", fnName); 	// 귀속부서 팝업 띄우기
				}
				else if(type == "CU")
				{
					/*
					if(param == "pop=true")
					{
						fnCustomerOnPopup(searchParam, param, "", fnName); // 개발사(거래처) 팝업 띄우기
					}
					else
					{
						fnCustomerPopup(searchParam, param, "", fnName); // 개발사(거래처) 팝업 띄우기
					}
					*/
					if("true" == getQueryVariable(param, "pop") )
					{
						fnCustomerOnPopup(searchParam, param, "", fnName); 	// 팝업위에 거래처 팝업 띄우기
						
					}
					else
					{
						fnCustomerPopup(searchParam, param, "", fnName); 	// 거래처 팝업 띄우기
					}


				}
				else if(type == "CO")
				{
					fnCountryPopup(searchParam, param, "", fnName); // 국가 팝업 띄우기
				}
				else if(type == "GM")
				{
					fnGameNmPopup(searchParam, param, "", fnName);
				}
				else if(type == "IV")
				{

				}
				else if(type == "CC")
				{

				}
				else if(type == "CT")
				{
					
					if("true" == getQueryVariable(param, "pop") )
					{
						fnContractOnPopup(searchParam, param, "", fnName); 	// 팝업위에 사원 팝업 띄우기
						
					}
					else
					{
						fnContractPopup(searchParam, param, "", fnName); // 사원 팝업 띄우기
					}
					
					
					
					//fnContractPopup(searchParam, param, "", fnName);
				}
				else if(type == "HR")
				{
					if("true" == getQueryVariable(param, "pop") )
					{
						fnHrPopupOnPopup(searchParam, param, "", fnName); 	// 팝업위에 사원 팝업 띄우기
						
					}
					else
					{
						fnHrPopup(searchParam, param, "", fnName); // 사원 팝업 띄우기
					}
					
					//fnHrPopup(searchParam, param, "", fnName); // 사원 팝업 띄우기
				}
				else if(type == "AC")
				{
					fnAccountPopup(searchParam, param, "", fnName); // 계정 팝업 띄우기
				}
				else if(type == "SC")
				{
					fnSubCpnyCdPopup(searchParam, param, "", fnName);
				}
				else if(type == "TA")
				{
					fnTitleofAccountPop(searchParam, param, "", fnName);
				}
				else if(type == "ERP" || type == "RFND" || type == "ESTM")
				{
					fnErpPopup(searchParam, param, "", fnName);
				}
				else if(type == "CR")
				{
					fnCustomerReceiverPopup(searchParam, param, "", fnName);
				}

			}
			else				// 검색된 값이 1개 일때 값을 넣어준다.
			{
				if(type == "PC")
				{
					if (param.indexOf("pcd=1") != -1)
					{
						if(fnName == null || isNull(fnName) || fnName == "" || fnName == "undefined")
						{
							fnName = "fnProjectCdPopup1CallBack";
						}
						data.list[0].index = getQueryVariable(param, "index");
						fnGoFunction(fnName, data.list[0]);
						//fnProjectCdPopup1CallBack(data.list[0]);	// 개발사1 관련 값들 넣어주기
					}
					else if (param.indexOf("pcd=2") != -1)
					{
						if(fnName == null || isNull(fnName) || fnName == "" || fnName == "undefined")
						{
							fnName = "fnProjectCdPopup2CallBack";
						}
						data.list[0].index = getQueryVariable(param, "index");
						fnGoFunction(fnName, data.list[0]);
						//fnProjectCdPopup2CallBack(data.list[0]);	// 개발사2 관련 값들 넣어주기
					}
					else
					{
						if(fnName == null || isNull(fnName) || fnName == "" || fnName == "undefined")
						{
							fnName = "fnProjectCdPopupCallBack";
						}
						data.list[0].index = getQueryVariable(param, "index");
						fnGoFunction(fnName, data.list[0]);
						//fnProjectCdPopupCallBack(data.list[0]);	//프로젝트 관련 값들 넣어주기
					}


				}
				else if(type == "DT")
				{
					if(fnName == null || isNull(fnName) || fnName == "" || fnName == "undefined")
					{
						fnName = "fnGetDepartTeamData";
					}
					fnGoFunction(fnName, data.list[0]);
					//fnGetDepartTeamData(data.list[0]);	// 귀속팀 관련 값들 넣어주기
				}
				else if(type == "DE")
				{
					if(fnName == null || isNull(fnName) || fnName == "" || fnName == "undefined")
					{
						fnName = "fnGetDepartData";
					}
					fnGoFunction(fnName, data.list[0]);
					//fnGetDepartData(data.list[0]);	// 귀속팀 관련 값들 넣어주기
				}
				else if(type == "CO")
				{
					if(fnName == null || isNull(fnName) || fnName == "" || fnName == "undefined")
					{
						fnName = "fnGetCountryData";
					}
					data.list[0].index = getQueryVariable(param, "index");
					fnGoFunction(fnName, data.list[0]);
					//fnGetCountryData(data.list[0]);	// 국가 관련 값들 넣어주기
				}
				else if(type == "CU")
				{
					if (param.indexOf("dev=1") != -1)
					{
						if(fnName == null || isNull(fnName) || fnName == "" || fnName == "undefined")
						{
							fnName = "fnGetCustomer1Data";
						}
						fnGoFunction(fnName, data.list[0]);
						//fnGetCustomer1Data(data.list[0]);	// 개발사1 관련 값들 넣어주기
					}
					else if (param.indexOf("dev=2") != -1)
					{
						if(fnName == null || isNull(fnName) || fnName == "" || fnName == "undefined")
						{
							fnName = "fnGetCustomer2Data";
						}
						fnGoFunction(fnName, data.list[0]);
						//fnGetCustomer2Data(data.list[0]);	// 개발사2 관련 값들 넣어주기
					}
					else if (param.indexOf("dev=3") != -1)
					{
						if(fnName == null || isNull(fnName) || fnName == "" || fnName == "undefined")
						{
							fnName = "fnGetCustomer3Data";
						}
						fnGoFunction(fnName, data.list[0]);
						//fnGetCustomer3Data(data.list[0]);	// 개발사3 관련 값들 넣어주기
					}
					else
					{
						if(fnName == null || isNull(fnName) || fnName == "" || fnName == "undefined")
						{
							fnName = "fnGetCustomerData";
						}
						data.list[0].index = getQueryVariable(param, "index");
						fnGoFunction(fnName, data.list[0]);
						//fnGetCustomerData(data.list[0]);	// 거래처 관련 값들 넣어주기
					}
				}
				else if(type == "HR")
				{
					if(fnName == null || isNull(fnName) || fnName == "" || fnName == "undefined")
					{
						fnName = "fnGetHrData";
					}
					data.list[0].index = getQueryVariable(param, "index");
					fnGoFunction(fnName, data.list[0]);
					//fnGetHrData(data.list[0]);	// 사원 관련 값들 넣어주기
				}
				else if(type == "AC")
				{
					if(fnName == null || isNull(fnName) || fnName == "" || fnName == "undefined")
					{
						fnName = "fnGetAccountData";
					}
					fnGoFunction(fnName, data.list[0]);
					//fnGetAccountData(data.list[0]);	// 사원 관련 값들 넣어주기
				}
				else if(type == "SC")
				{
					if(fnName == null || isNull(fnName) || fnName == "" || fnName == "undefined")
					{
						fnName = "fnSubCpnyData";
					}
					fnGoFunction(fnName, data.list[0]);
					//fnSubCpnyData(data.list[0]);
				}
				else if(type == "GM")
				{
					if(fnName == null || isNull(fnName) || fnName == "" || fnName == "undefined")
					{
						fnName = "fnGameNmPopupData";
					}
					fnGoFunction(fnName, data.list[0]);
					//fnGameNmPopup(searchParam, param, "", fnName);
				}
				else if(type == "CT")
				{
					
					if(fnName == null || isNull(fnName) || fnName == "" || fnName == "undefined")
					{
						fnName = "fnContractPopup";
					}
					
					data.list[0].nSel = getQueryVariable(param, "nSel");
					fnGoFunction(fnName, data.list[0]);
				}
				else if(type == "TA")
				{
					
					if(fnName == null || isNull(fnName) || fnName == "" || fnName == "undefined")
					{
						fnName = "fnGetTitleOfAccountData";
					}
					var list = {
							list : data.list[0]
					}
					//alert(list.list.hkont);
					fnGoFunction(fnName, list);
				}
				else if(type == "ERP" || type == "RFND" || type == "ESTM")
				{
					if(fnName == null || isNull(fnName) || fnName == "" || fnName == "undefined")
					{
						fnName = "fnErpNoData";
					}
					fnGoFunction(fnName, data.list[0]);
					//fnContractPopup(searchParam, param, "", fnName);
				}
				else if(type == "CR")
				{
					if(fnName == null || isNull(fnName) || fnName == "" || fnName == "undefined")
					{
						fnName = "fnCustomerReceiverData";
					}
					data.list[0].index = getQueryVariable(param, "index");
					fnGoFunction(fnName, data.list[0]);
					//fnCustomerReceiverPopup(searchParam, param, "", fnName);
				}
				
				

			}


		}
	});
}



function getQueryVariable(param, variable) {
	var query = param;
	var vars = query.split("&");
	for (var i=0;i<vars.length;i++) {
		var pair = vars[i].split("=");
			if (pair[0] == variable) {
			return pair[1];
		}
	}
}
	


function fnProjectCdPopup(prjtNm, getParam , paramVal, fnName){
	//alert("prjtNm :: " + prjtNm);
	
	var encodPrjtNm = encodeURI(encodeURIComponent(prjtNm));

	//alert("encodPrjtNm :: " + encodPrjtNm);

	//alert("Jonathan  " + paramVal.a);,""

	var url = "/cmmn/cmmnProjectCdPop.do";
	var param="prjtNm=" + encodPrjtNm+ "&" + getParam;
	var popUrl = "";
	if(param != ""){
		popUrl = url + "?" +param;
	}
	else{
		popUrl = url;
	}

	var parmaPop = {

	};

	if(paramVal){
		parmaPop = paramVal;
	}

	var popupOpt ="dialogWidth:780px;dialogHeight:358px;scroll:no;status:no;center:yes;resizable:yes;";
	
	

	if (param.indexOf("pcd=1") !=-1)
	{
		if(fnName == null || isNull(fnName) || fnName == "" || fnName == "undefined")
		{
			fnName = "fnProjectCdPopup1CallBack";
		}
		
		var ProjectCdPopup1CallBack = window.showModalDialog(popUrl, parmaPop, popupOpt, fnName);
		if(ProjectCdPopup1CallBack)
		{
			fnGoFunction(fnName,ProjectCdPopup1CallBack);
		}
	}
	else if (param.indexOf("pcd=2") !=-1)
	{
		if(fnName == null || isNull(fnName) || fnName == "" || fnName == "undefined")
		{
			fnName = "fnProjectCdPopup2CallBack";
		}
		
		var ProjectCdPopup2CallBack = window.showModalDialog(popUrl, parmaPop, popupOpt, "fnProjectCdPopup2CallBack");
		if(ProjectCdPopup2CallBack)
		{
			fnGoFunction(fnName,ProjectCdPopup2CallBack);
		}
	}
	else
	{
		if(fnName == null || isNull(fnName) || fnName == "" || fnName == "undefined")
		{
			fnName = "fnProjectCdPopupCallBack";
		}

		var ProjectCdPopupCallBack = window.showModalDialog(popUrl, parmaPop, popupOpt, fnName);
		if(ProjectCdPopupCallBack)
		{
			// 각 항목에 넣기
			fnGoFunction(fnName, ProjectCdPopupCallBack);
		}
	}
	/*
	var ProjectCdPopupCallBack = window.showModalDialog(popUrl, parmaPop, popupOpt, "fnProjectCdPopupCallBack");
	if(ProjectCdPopupCallBack)
	{
		// 각 항목에 넣기
		fnProjectCdPopupCallBack(ProjectCdPopupCallBack);
	}
	 */
}


//프로젝트 코드 팝업 위에 팝업
function fnProjectCdOnPopup(prjtNm, getParam , paramVal, fnName){
	//alert("prjtNm :: " + prjtNm);

	if(fnName == null || isNull(fnName) || fnName == "" || fnName == "undefined")
	{
		fnName = "fnProjectCdPopupCallBack";
	}
	
	var encodPrjtNm = encodeURI(encodeURIComponent(prjtNm));

	//alert("encodPrjtNm :: " + encodPrjtNm);

	var url = "/cmmn/cmmnProjectCdPop.do";
	var param="prjtNm=" + encodPrjtNm+ "&" + getParam;
	var popUrl = "";
	if(param != ""){
		popUrl = url + "?" +param;
	}
	else{
		popUrl = url;
	}
	var parmaVal = {

	};
	var popupOpt ="dialogWidth:780px;dialogHeight:358px;scroll:no;status:no;center:yes;resizable:yes;";
	var ProjectCdPopupCallBack = window.showModalDialogPop(popUrl, parmaVal, popupOpt, fnName);
	if(ProjectCdPopupCallBack)
	{
		// 각 항목에 넣기
		fnGoFunction(fnName, ProjectCdPopupCallBack);
	}

}

//귀속팀 팝업 띄우기
function fnDepartTeamPopup(teamNm, getParam , paramVal, fnName){
	//alert("prjtNm :: " + prjtNm);
	if(fnName == null || isNull(fnName) || fnName == "" || fnName == "undefined")
	{
		fnName = "fnGetDepartTeamData";
	}

	var encodNm = encodeURI(encodeURIComponent(teamNm));

	//alert("encodPrjtNm :: " + encodPrjtNm);

	var url = "/cmmn/cmmnDepartTeamPop.do";
	var param="teamNm=" + encodNm + "&" + getParam;
	var popUrl = "";
	if(param != ""){
		popUrl = url + "?" +param;
	}
	else{
		popUrl = url;
	}
	var parmaPop = {

	};
	if(paramVal){
		parmaPop = paramVal;
	}
	var popupOpt ="dialogWidth:635px;dialogHeight:358px;scroll:no;status:no;center:yes;resizable:yes;";
	var DepartTeamPopupCallBack = window.showModalDialog(popUrl, parmaPop, popupOpt, fnName);
	if(DepartTeamPopupCallBack)
	{
		fnGoFunction(fnName, DepartTeamPopupCallBack);
		//fnGetDepartTeamData(DepartTeamPopupCallBack);
	}

}





//귀속팀 팝업 위에 팝업 ( 법인카드 사용내역 ) 
function fnDepartTeamOnPopup(teamNm, getParam , paramVal, fnName){
	//alert("prjtNm :: " + prjtNm);
	if(fnName == null || isNull(fnName) || fnName == "" || fnName == "undefined")
	{
		fnName = "fnGetDepartTeamData";
	}

	var encodNm = encodeURI(encodeURIComponent(teamNm));

	//alert("encodPrjtNm :: " + encodPrjtNm);

	var url = "/cmmn/cmmnDepartTeamPop.do";
	var param="teamNm=" + encodNm + "&" + getParam;
	var popUrl = "";
	if(param != ""){
		popUrl = url + "?" +param;
	}
	else{
		popUrl = url;
	}
	var parmaPop = {

	};
	if(paramVal){
		parmaPop = paramVal;
	}
	var popupOpt ="dialogWidth:635px;dialogHeight:358px;scroll:no;status:no;center:yes;resizable:yes;";
	var DepartTeamPopupCallBack = window.showModalDialogPop(popUrl, parmaPop, popupOpt, fnName);
	if(DepartTeamPopupCallBack)
	{
		fnGoFunction(fnName, DepartTeamPopupCallBack);
		//fnGetDepartTeamData(DepartTeamPopupCallBack);
	}

}






//귀속부서 팝업 띄우기
function fnDepartPopup(departNm, getParam , paramVal, fnName){
	//alert("prjtNm :: " + prjtNm);

	if(fnName == null || isNull(fnName) || fnName == "" || fnName == "undefined")
	{
		fnName = "fnGetDepartData";
	}


	var encodNm = encodeURI(encodeURIComponent(departNm));

	//alert("encodPrjtNm :: " + encodPrjtNm);

	var url = "/cmmn/cmmnDepartPop.do";
	var param="bsnsDeptNm=" + encodNm + "&" + getParam;
	var popUrl = "";
	if(param != ""){
		popUrl = url + "?" +param;
	}
	else{
		popUrl = url;
	}
	var parmaPop = {

	};
	if(paramVal){
		parmaPop = paramVal;
	}
	var popupOpt ="dialogWidth:635px;dialogHeight:328px;scroll:no;status:no;center:yes;resizable:yes;";
	var DepartPopupCallBack = window.showModalDialog(popUrl, parmaPop, popupOpt, fnName);
	if(DepartPopupCallBack)
	{
		fnGoFunction(fnName, DepartPopupCallBack);
		//fnGetDepartData(DepartPopupCallBack);
	}

}


//거래처 팝업 띄우기 (인보이스 팝업의 팝업)fnCustomerOnPopup
function fnCustomerOnPopup(customerNm, getParam , paramVal, fnName){
	//alert("prjtNm :: " + prjtNm);
	//alert("Jonathan123");
	if(fnName == null || isNull(fnName) || fnName == "" || fnName == "undefined")
	{
		fnName = "fnGetCustomerData";
	}
	
	var encodNm = encodeURI(encodeURIComponent(customerNm));

	//alert("encodPrjtNm :: " + encodPrjtNm);
	

	var url = "/cmmn/cmmnCustomerPop.do";
	var param="customerNm=" + encodNm + "&" + getParam;
	var popUrl = "";
	if(param != ""){
		popUrl = url + "?" +param;
	}
	else{
		popUrl = url;
	}
	var parmaPop = {

	};
	if(paramVal){
		parmaPop = paramVal;
	}
	var popupOpt ="dialogWidth:1075px;dialogHeight:336px;scroll:no;status:no;center:yes;resizable:yes;";

	var CustomerPopupCallBack = window.showModalDialogPop(popUrl, parmaPop, popupOpt, fnName);
	if(CustomerPopupCallBack)
	{
		fnGoFunction(fnName, CustomerPopupCallBack);
	}


}

//개발사(거래처) 팝업 띄우기
function fnCustomerPopup(customerNm, getParam , paramVal, fnName){

	

	//alert("fnName :: " + fnName);
	var encodNm = encodeURI(encodeURIComponent(customerNm));

	//alert("encodPrjtNm :: " + encodPrjtNm);

	var url = "/cmmn/cmmnCustomerPop.do";
	var param="customerNm=" + encodNm + "&" + getParam;
	var popUrl = "";
	if(param != ""){
		popUrl = url + "?" +param;
	}
	else{
		popUrl = url;
	}
	var parmaPop = {

	};
	if(paramVal){
		parmaPop = paramVal;
	}
	var popupOpt ="dialogWidth:1075px;dialogHeight:356px;scroll:no;status:no;center:yes;resizable:yes;";
	
	
	if (param.indexOf("dev=1") !=-1)
	{
		if(fnName == null || isNull(fnName) || fnName == "" || fnName == "undefined")
		{
			fnName = "fnGetCustomer1Data";
		}
		var Customer1PopupCallBack = window.showModalDialog(popUrl, parmaPop, popupOpt, fnName);
		if(Customer1PopupCallBack)
		{
			fnGoFunction(fnName, Customer1PopupCallBack);
		}
	}
	else if (param.indexOf("dev=2") !=-1)
	{
		if(fnName == null || isNull(fnName) || fnName == "" || fnName == "undefined")
		{
			fnName = "fnGetCustomer2Data";
		}
		var Customer2PopupCallBack = window.showModalDialog(popUrl, parmaPop, popupOpt, fnName);
		if(Customer2PopupCallBack)
		{
			fnGoFunction(fnName, Customer2PopupCallBack);
		}
	}
	else if (param.indexOf("dev=3") !=-1)
	{
		if(fnName == null || isNull(fnName) || fnName == "" || fnName == "undefined")
		{
			fnName = "fnGetCustomer3Data";
		}
		var Customer3PopupCallBack = window.showModalDialog(popUrl, parmaPop, popupOpt, fnName);
		if(Customer3PopupCallBack)
		{
			fnGoFunction(fnName, Customer3PopupCallBack);
		}
	}
	else
	{
		if(fnName == null || isNull(fnName) || fnName == "" || fnName == "undefined")
		{
			//alert("joanthan2");
			fnName = "fnGetCustomerData";
		}
		//alert("fnName2 :: " + fnName);
		
		var CustomerPopupCallBack = window.showModalDialog(popUrl, parmaPop, popupOpt, fnName);
		if(CustomerPopupCallBack)
		{
			//alert("customer :: ");
			fnGoFunction(fnName, CustomerPopupCallBack);
			//fnGetCustomerData(CustomerPopupCallBack);
		}
	}

}


//사원 팝업 띄우기 (인보이스 팝업의 팝업)
function fnHrPopupOnPopup(hrNm, getParam , paramVal, fnName){
	//alert("prjtNm :: " + prjtNm);

	if(fnName == null || isNull(fnName) || fnName == "" || fnName == "undefined")
	{
		fnName = "fnGetHrData";
	}
	
	var encodNm = encodeURI(encodeURIComponent(hrNm));

	//alert("encodPrjtNm :: " + encodPrjtNm);

	var url = "/cmmn/cmmnHrPop.do";
	var param="hrNm=" + encodNm + "&" + getParam;
	var popUrl = "";
	if(param != ""){
		popUrl = url + "?" +param;
	}
	else{
		popUrl = url;
	}
	var parmaPop = {

	};
	if(paramVal){
		parmaPop = paramVal;
	}
	var popupOpt ="dialogWidth:780px;dialogHeight:358px;scroll:no;status:no;center:yes;resizable:yes;";
	var HrPopupCallBack = window.showModalDialogPop(popUrl, parmaPop, popupOpt, fnName);
	if(HrPopupCallBack)
	{
		fnGoFunction(fnName, HrPopupCallBack);
	}

}






//사원 팝업 띄우기
function fnHrPopup(hrNm, getParam , paramVal, fnName){
	//alert("prjtNm :: " + prjtNm);
	if(fnName == null || isNull(fnName) || fnName == "" || fnName == "undefined")
	{
		fnName = "fnGetHrData";
	}

	
	
	var encodNm = encodeURI(encodeURIComponent(hrNm));

	//alert("encodPrjtNm :: " + encodPrjtNm);

	var url = "/cmmn/cmmnHrPop.do";
	var param="hrNm=" + encodNm + "&" + getParam;
	var popUrl = "";
	if(param != ""){
		popUrl = url + "?" +param;
	}
	else{
		popUrl = url;
	}
	var parmaPop = {

	};
	if(paramVal){
		parmaPop = paramVal;
	}
	var popupOpt ="dialogWidth:780px;dialogHeight:358px;scroll:no;status:no;center:yes;resizable:yes;";
	var HrPopupCallBack = window.showModalDialog(popUrl, parmaPop, popupOpt, fnName);
	if(HrPopupCallBack)
	{
		fnGoFunction(fnName, HrPopupCallBack);
	}

}



//국가 팝업 띄우기
function fnCountryPopup(NmCd, getParam , paramVal, fnName){
	//alert("prjtNm :: " + prjtNm);
	if(fnName == null || isNull(fnName) || fnName == "" || fnName == "undefined")
	{
		fnName = "fnGetCountryData";
	}



	var encodNm = encodeURI(encodeURIComponent(NmCd));

	//alert("encodPrjtNm :: " + encodPrjtNm);

	var url = "/cmmn/cmmnCountryPop.do";
	var param="NmCd=" + encodNm + "&" + getParam;
	var popUrl = "";
	if(param != ""){
		popUrl = url + "?" +param;
	}
	else{
		popUrl = url;
	}
	var parmaPop = {

	};
	if(paramVal){
		parmaPop = paramVal;
	}
	var popupOpt ="dialogWidth:780px;dialogHeight:348px;scroll:no;status:no;center:yes;resizable:yes;";
	var CountryPopupCallBack = window.showModalDialog(popUrl, parmaPop, popupOpt, fnName);
	if(CountryPopupCallBack)
	{
		fnGoFunction(fnName, CountryPopupCallBack);
		//fnGetCountryData(CountryPopupCallBack);
	}

}





//예외국가 팝업 띄우기
function fnCountryExceptPopup(NmCd, getParam , paramVal, fnName){
	//alert("prjtNm :: " + prjtNm);
	if(fnName == null || isNull(fnName) || fnName == "" || fnName == "undefined")
	{
		fnName = "fnGetExceptCountryData";
	}



	var encodNm = encodeURI(encodeURIComponent(NmCd));

	//alert("encodPrjtNm :: " + encodPrjtNm);

	var url = "/ctrt/ctrtCountryExceptPopup.do";
	var param="NmCd=" + encodNm + "&" + getParam;
	var popUrl = "";
	if(param != ""){
		popUrl = url + "?" +param;
	}
	else{
		popUrl = url;
	}
	var parmaPop = {

	};
	if(paramVal){
		parmaPop = paramVal;
	}
	var popupOpt ="dialogWidth:780px;dialogHeight:348px;scroll:no;status:no;center:yes;resizable:yes;";
	var CountryExceptPopupCallBack = window.showModalDialog(popUrl, parmaPop, popupOpt, fnName);
	if(CountryExceptPopupCallBack)
	{
		fnGoFunction(fnName, CountryExceptPopupCallBack);
		//fnGetCountryData(CountryPopupCallBack);
	}

}






//계약 팝업 띄우기
function fnContractPopup(ctrtNm, getParam , paramVal, fnName){
	//alert("prjtNm :: " + prjtNm);

	if(fnName == null || isNull(fnName) || fnName == "" || fnName == "undefined")
	{
		fnName = "fnGetContractData";
	}

	
	var encodNm = encodeURI(encodeURIComponent(ctrtNm));
	

	//alert("encodPrjtNm :: " + encodPrjtNm);

	var url = "/ctrt/ctrtContractPop.do";
	var param="ctrtNm=" + encodNm + "&" + getParam;
	var popUrl = "";
	if(param != ""){
		popUrl = url + "?" +param;
	}
	else{
		popUrl = url;
	}
	var parmaPop = {

	};
	if(paramVal){
		parmaPop = paramVal;
	}
	var popupOpt ="dialogWidth:1075px;dialogHeight:386px;scroll:no;status:no;center:yes;resizable:yes;";
	var ContractPopupCallBack = window.showModalDialog(popUrl, parmaPop, popupOpt, fnName);
	if(ContractPopupCallBack)
	{
		fnGoFunction(fnName, ContractPopupCallBack);
	}

}





//계약 팝업 띄우기 (팝업의 팝업)
function fnContractOnPopup(ctrtCd, getParam , paramVal, fnName){
	//alert("prjtNm :: " + prjtNm);

	if(fnName == null || isNull(fnName) || fnName == "" || fnName == "undefined")
	{
		fnName = "fnGetContractData";
	}

	var encodNm = encodeURI(encodeURIComponent(ctrtCd));

	//alert("encodPrjtNm :: " + encodPrjtNm);

	var url = "/ctrt/ctrtContractPop.do";
	var param="ctrtNm=" + encodNm + "&" + getParam;
	var popUrl = "";
	if(param != ""){
		popUrl = url + "?" +param;
	}
	else{
		popUrl = url;
	}
	var parmaPop = {

	};
	if(paramVal){
		parmaPop = paramVal;
	}
	//alert("fnName ;:: " + fnName);
	var popupOpt ="dialogWidth:1075px;dialogHeight:366px;scroll:no;status:no;center:yes;resizable:yes;";
	var ContractPopupCallBack = window.showModalDialogPop(popUrl, parmaPop, popupOpt, fnName);
	if(ContractPopupCallBack)
	{
		//alert("Jonathan ");
		fnGoFunction(fnName, ContractPopupCallBack);
	}

}



function fnGoFunction(fnName, ContractPopupCallBack)
{

	//alert("Joantnsdlfkj ::  	" + fnName);
	window[fnName](ContractPopupCallBack);
	
	//fnName(ContractPopupCallBack);
}


//계정 팝업 띄우기
function fnAccountPopup(accountCd, getParam , paramVal, fnName){
	//alert("accountCd :: " + accountCd);
	if(fnName == null || isNull(fnName) || fnName == "" || fnName == "undefined")
	{
		fnName = "fnGetAccountData";
	}
	
	
	var encodNm = encodeURI(encodeURIComponent(accountCd));

	//alert("encodPrjtNm :: " + encodPrjtNm);

	var url = "/cmmn/cmmnAccountCdPop.do";
	var param="acctNm=" + encodNm + "&" + getParam;
	var popUrl = "";
	if(param != ""){
		popUrl = url + "?" +param;
	}
	else{
		popUrl = url;
	}
	var parmaPop = {

	};
	if(paramVal){
		parmaPop = paramVal;
	}
	var popupOpt ="dialogWidth:655px;dialogHeight:350px;scroll:no;status:no;center:yes;resizable:yes;";
	var AccountPopupCallBack = window.showModalDialog(popUrl, parmaPop, popupOpt, fnName);
	if(AccountPopupCallBack)
	{
		fnGoFunction(fnName, AccountPopupCallBack);
	}

}





//계산서 수신자
function fnCustomerReceiverPopup(recNm, getParam , paramVal, fnName){
	//alert("accountCd :: " + accountCd);


	if(fnName == null || isNull(fnName) || fnName == "" || fnName == "undefined")
	{
		fnName = "fnCustomerReceiverData";
	}



	var encodNm = encodeURI(encodeURIComponent(recNm));




	var url = "/cmmn/cmmnCustomerReceiverPop.do";
	var param="recNm=" + encodNm + "&" + getParam;
	var popUrl = "";
	if(param != ""){
		popUrl = url + "?" +param;
	}
	else{
		popUrl = url;
	}
	var parmaPop = {

	};
	if(paramVal){
		parmaPop = paramVal;
	}
	var popupOpt ="dialogWidth:900px;dialogHeight:358px;scroll:no;status:no;center:yes;resizable:yes;";
	var CstmReceivPopupCallBack = window.showModalDialog(popUrl, parmaPop, popupOpt, fnName);
	if(CstmReceivPopupCallBack)
	{
		fnGoFunction(fnName, CstmReceivPopupCallBack);
	}

}






//자회사 팝업 띄우기
function fnSubCpnyCdPopup(cpnyNm, getParam , paramVal, fnName){
	//alert("prjtNm :: " + prjtNm);
	if(fnName == null || isNull(fnName) || fnName == "" || fnName == "undefined")
	{
		fnName = "fnSubCpnyData";
	}

	

	var encodNm = encodeURI(encodeURIComponent(cpnyNm));

	//alert("encodPrjtNm :: " + encodPrjtNm);

	var url = "/rifc/rifcSubCpnyCdPopup.do";
	var param="schCd="+encodNm +"&schNm="+encodNm;

	var popUrl = "";
	if(param != ""){
		popUrl = url + "?" +param;
	}
	else{
		popUrl = url;
	}
	var parmaPop = {

	};
	if(paramVal){
		parmaPop = paramVal;
	}
	var popupOpt ="dialogWidth:635px;dialogHeight:358px;scroll:no;status:no;center:yes;resizable:yes;";
	var popupCallBack = window.showModalDialog(popUrl, parmaPop, popupOpt, fnName);
	if(popupCallBack)
	{
		fnGoFunction(fnName, popupCallBack);
	}
}

//자회사 팝업 띄우기2 for ( 자회사재무제표 자회사손익계산서 )
function fnSubCpnyCdPopup2(cpnyNm, getParam , paramVal, fnName){
	
	if(fnName == null || isNull(fnName) || fnName == "" || fnName == "undefined")
	{
		fnName = "fnSubCpnyData";
	}
	

	var encodNm = encodeURI(encodeURIComponent(cpnyNm));
	var url = "/rifc/rifcSubCpnyCdPopup.do";

	var encodNm = encodeURI(encodeURIComponent(cpnyNm));

	//alert("encodPrjtNm :: " + encodPrjtNm);

	var url = "/rifc/rifcSubCpnyCdPopup.do";
	var param="schCd="+encodNm +"&schNm="+encodNm;
	 param+=getParam;


	var popUrl = "";
	if(param != ""){
		popUrl = url + "?" +param;
	}
	else{
		popUrl = url;
	}
	var parmaPop = {

	};
	if(paramVal){
		parmaPop = paramVal;
	}
	var popupOpt ="dialogWidth:635px;dialogHeight:358px;scroll:no;status:no;center:yes;resizable:yes;";
	var popupCallBack = window.showModalDialog(popUrl, parmaPop, popupOpt, fnName);
	if(popupCallBack)
	{
		fnGoFunction(fnName, popupCallBack);
	}
}




//비용 항목
function fnTitleofAccountPop(NmCd, getParam , paramVal, fnName){
	//alert("prjtNm :: " + prjtNm);

	if(fnName == null || isNull(fnName) || fnName == "" || fnName == "undefined")
	{
		fnName = "fnGetTitleOfAccountData";
	}

	var encodNm = encodeURI(encodeURIComponent(NmCd));

	//alert("encodPrjtNm :: " + encodPrjtNm);

	var url = "/cmmn/cmmnTitleOfAccountPop.do";
	var param="NmCd=" + encodNm + "&" + getParam;
	var popUrl = "";
	if(param != ""){
		popUrl = url + "?" +param;
	}
	else{
		popUrl = url;
	}
	var parmaPop = {

	};
	if(paramVal){
		parmaPop = paramVal;
	}
	//alert("fnName ;:: " + fnName);
	var popupOpt ="dialogWidth:700px;dialogHeight:346px;scroll:no;status:no;center:yes;resizable:yes;";
	var ContractPopupCallBack = window.showModalDialog(popUrl, parmaPop, popupOpt, fnName);
	if(ContractPopupCallBack)
	{
		//alert("Jonathan ");
		fnGoFunction(fnName, ContractPopupCallBack);
	}

}









//게임명
function fnGameNmPopup(gameNm, getParam , paramVal, fnName){
	//alert("prjtNm :: " + prjtNm);

	//alert("prjtNm :: " + prjtNm);
	if(fnName == null || isNull(fnName) || fnName == "" || fnName == "undefined")
	{
		fnName = "fnGameNmPopupData";
	}



	var encodNm = encodeURI(encodeURIComponent(gameNm));

	//alert("encodPrjtNm :: " + encodPrjtNm);

	var url = "/cmmn/cmmnGamePop.do";
	var param="gameNm=" + encodNm + "&" + getParam;
	var popUrl = "";
	if(param != ""){
		popUrl = url + "?" +param;
	}
	else{
		popUrl = url;
	}
	var parmaPop = {

	};
	if(paramVal){
		parmaPop = paramVal;
	}
	var popupOpt ="dialogWidth:900px;dialogHeight:358px;scroll:no;status:no;center:yes;resizable:yes;";
	var GamePopupCallBack = window.showModalDialog(popUrl, parmaPop, popupOpt, fnName);
	if(GamePopupCallBack)
	{
		fnGoFunction(fnName, GamePopupCallBack);
		//fnGetCountryData(CountryPopupCallBack);
	}


}





//ERP 번호 201512000042
function fnErpPopup(erpNo, getParam , paramVal, fnName){
	//alert("prjtNm :: " + prjtNm);

	if(fnName == null || isNull(fnName) || fnName == "" || fnName == "undefined")
	{
		fnName = "fnErpNoData";
	}

	//alert("encodPrjtNm :: " + encodPrjtNm);

	var url = "/cmmn/cmmnErpPop.do";
	var param="erpNo=" + erpNo + "&" + getParam;
	var popUrl = "";
	if(param != ""){
		popUrl = url + "?" +param;
	}
	else{
		popUrl = url;
	}
	var parmaPop = {

	};
	if(paramVal){
		parmaPop = paramVal;
	}
	//alert("fnName ;:: " + fnName);
	var popupOpt ="dialogWidth:1080px;dialogHeight:358px;scroll:no;status:no;center:yes;resizable:yes;";
	var ErpPopupCallBack = window.showModalDialog(popUrl, parmaPop, popupOpt, fnName);
	if(ErpPopupCallBack)
	{
		//alert("Jonathan ");
		fnGoFunction(fnName, ErpPopupCallBack);
	}

}





