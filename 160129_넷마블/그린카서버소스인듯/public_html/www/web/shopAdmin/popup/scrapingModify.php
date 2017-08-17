<?
	require_once MALL_CONF_LIB."ProductMgr.php";
	require_once MALL_CONF_LIB."SiteMgr.php";
	require_once MALL_CONF_LIB."CateMgr.php";

	$productMgr		= new ProductMgr();	
	$siteMgr			= new SiteMgr();
	$cateMgr			= new CateMgr();		


	$strP_CODE		= $_POST["prodCode"]		? $_POST["prodCode"]		: $_REQUEST["prodCode"];
	$strProdLng		= $_POST["prodLang"]		? $_POST["prodLang"]		: $_REQUEST["prodLang"];

	if (!$strP_CODE){
		$db->disConnect();
		goClose("주문정보가 존재하지 않습니다.");
		exit;
	}

	$productMgr->setP_CODE($strP_CODE);


	/* Site Info */
	$prodRow = $productMgr->getProdTempView($db);

	$cateMgr->setC_LEVEL(1);
	$cateMgr->setC_HCODE("");
	//$cateMgr->setC_VIEW_YN("Y");
	$aryCate01 = $cateMgr->getCateLevelAry($db);

	$cateMgr->setC_LEVEL(2);
	$cateMgr->setC_HCODE(SUBSTR($prodRow[P_CATE],0,3));
	//$cateMgr->setC_VIEW_YN("Y");
	$aryCate02 = $cateMgr->getCateLevelAry($db);

	$cateMgr->setC_LEVEL(3);
	$cateMgr->setC_HCODE(SUBSTR($prodRow[P_CATE],0,6));
	//$cateMgr->setC_VIEW_YN("Y");
	$aryCate03 = $cateMgr->getCateLevelAry($db);

	$cateMgr->setC_LEVEL(4);
	$cateMgr->setC_HCODE(SUBSTR($prodRow[P_CATE],0,9));
	//$cateMgr->setC_VIEW_YN("Y");
	$aryCate04 = $cateMgr->getCateLevelAry($db);



	$aryProdItem = $productMgr->getProdItemTemp($db);
	

	for($i=1;$i<=28;$i++)
	{
		if ($i == 1) {
			$strProdImgType = "main";
		} else if ($i == 2){
			$strProdImgType = "list";
		} else if ($i == 3){
			$strProdImgType = "view";
		} else if ($i == 4){
			$strProdImgType = "large";
		} else if ($i == 5){
			$strProdImgType = "mobile_main";
		} else if ($i == 6){
			$strProdImgType = "mobile_view";
		}  else if ($i >= 7 && $i <= 17){
			$strProdImgType = "view".($i-5);
		} else if ($i >= 18 && $i <= 28){
			$strProdImgType = "large".($i-16);
		}
		
		$productMgr->setPM_TYPE($strProdImgType);
		$aryProdImg[$i] = $productMgr->getProdImgTemp($db);
	}



//////////////////////////////////////////////////////////////////////////////////

//	for($i=1;$i<=3;$i++)
//	{
//		$productMgr->setPM_TYPE("file".$i);
//		$aryProdFile[$i] = $productMgr->getProdImgTemp($db);
//	}

	/*제조사*/
	$productMgr->setColumn("P_MAKER");
	$aryProductMaker = $productMgr->getProductColGroupList($db);

	/*원산지*/
	$productMgr->setColumn("P_ORIGIN");
	$aryProductOrigin = $productMgr->getProductColGroupList($db);

	/*모델명*/
	$productMgr->setColumn("P_MODEL");
	$aryProductModel = $productMgr->getProductColGroupList($db);

	/*브랜드*/
	$aryProdBrandList = $productMgr->getProdBrandList($db);


//	$productMgr->setPM_TYPE("list");
//	$listImage		= $productMgr->getProdImgTempView($db);

//	$productMgr->setPM_TYPE("view");
//	$viewImage	= $productMgr->getProdImgTempView($db);

//	$productMgr->setPM_TYPE("introduce");
//	$editorRow = $productMgr->getProdImgTempView($db);



	$productMgr->setPT_TYPE("기본옵션");
	$opt1Row = $productMgr->getProdOptTempView($db);

	$productMgr->setPT_TYPE("안정장치관련 옵션");
	$opt2Row = $productMgr->getProdOptTempView($db);
	
	$productMgr->setPT_TYPE("음향/옵션관련 옵션");
	$opt3Row = $productMgr->getProdOptTempView($db);

	$productMgr->setPT_TYPE("기타옵션");
	$opt4Row = $productMgr->getProdOptTempView($db);

	$aryProdOpt[0][PO_NO]  = 1;
	$aryProdOpt[0][P_CODE] = $strP_CODE;
	$aryProdOpt[0][PO_TYPE] = "O";
	$aryProdOpt[0][PO_ESS] = 'Y';
	$aryProdOpt[0][PO_NAME1] = "기본옵션";
	$aryProdOpt[0][PO_NAME2] = "안정장치관련 옵션";
	$aryProdOpt[0][PO_NAME3] = "음향/옵션관련 옵션";
	$aryProdOpt[0][PO_NAME4] = "기타옵션";
	$prodRow[P_STOCK_LIMIT] = "Y";
	$prodRow[P_MIN_QTY] = "1";
	$prodRow[P_POINT_TYPE] = "2";


	$i = 0;
	foreach($opt1Row as $opt)
	{
		$aryProdOpt[0][OPT_ATTR][$i]['POA_ATTR1'] = $opt1Row[$i][PT_NAME];
		$aryProdOpt[0]["PO_NAME_VAL1"] .= $opt1Row[$i][PT_NAME] . ";";
		$i++;
	}

	$i = 0;
	foreach($opt2Row as $opt)
	{
		$aryProdOpt[0][OPT_ATTR][$i]['POA_ATTR2'] = $opt2Row[$i][PT_NAME];
		$aryProdOpt[0]["PO_NAME_VAL2"] .= $opt2Row[$i][PT_NAME] . ";";
		$i++;
	}

	$i = 0;
	foreach($opt3Row as $opt)
	{
		$aryProdOpt[0][OPT_ATTR][$i]['POA_ATTR3'] = $opt3Row[$i][PT_NAME];
		$aryProdOpt[0]["PO_NAME_VAL3"] .= $opt3Row[$i][PT_NAME] . ";";
		$i++;
	}

	$i = 0;
	foreach($opt4Row as $opt)
	{
		$aryProdOpt[0][OPT_ATTR][$i]['POA_ATTR4'] = $opt4Row[$i][PT_NAME];
		$aryProdOpt[0]["PO_NAME_VAL4"] .= $opt4Row[$i][PT_NAME] . ";";
		$i++;
	}

	foreach($editorRow as $img)
	{
		$prodRow[P_WEB_TEXT] .= "<img src='" . $img[PM_REAL_NAME] . "' />\r\n";
	}

	$prodRow[P_BAESONG_TYPE]			= "1";
	$prodRow[P_OPT]						= "1";
	$prodRow[P_WEB_VIEW]				= "Y";





?><?=$strC_HCODE1?>
<? include "./include/header.inc.php"?>
<script type="text/javascript">
<!--

	var strInputBoxStyle = " class=\"nbox\" onfocus=\"this.className='sbox'\" onblur=\"this.className='nbox'\"";

	$(document).ready(function(){
		
		/*-- 카테고리 선택--*/

		<?if ($strC_HCODE1 != ""){?>
		callCateList(1,"","","cateHCode1","<?=$strC_HCODE1?>");
		<?}?>
		<?if ($strC_HCODE1){?>
		callCateList(2,"<?=$strC_HCODE1?>","","cateHCode2","<?=$strC_HCODE2?>");
		<?}?>
		<?if ($strC_HCODE2){?>
		callCateList(3,"<?=$strC_HCODE1.$strC_HCODE2?>","","cateHCode3","<?=$strC_HCODE3?>");
		<?}?>
		<?if ($strC_HCODE3){?>
		callCateList(4,"<?=$strC_HCODE1.$strC_HCODE2.$strC_HCODE3?>","","cateHCode4","<?=$strC_HCODE4?>");
		<?}?>



		/*-- 카테고리 선택--*/
		
	});



	/*-- 상품옵션관리 추가버튼--*/
	$("#btnProdOptAdd").live("click",function(){
		var objCopyRow = $("#tabProdOpt tr:eq(1)").clone();
		var intTrCnt = $("#tabProdOpt tr").length;
		
		if (intTrCnt > 10)
		{
			alert("옵션 속성은 10개이하만 등록 가능합니다.");
			return;
		}
		
		objCopyRow.find("input[id^=prodOptName]").each(function(i){
			$(this).attr("id",$(this).attr("id").replace("prodOptName1","prodOptName"+intTrCnt));
			$(this).attr("name",$(this).attr("name").replace("prodOptName1","prodOptName"+intTrCnt));
		});

		objCopyRow.find("input[id^=prodOptVal]").each(function(i){
			$(this).attr("id",$(this).attr("id").replace("prodOptVal1","prodOptVal"+intTrCnt));
			$(this).attr("name",$(this).attr("name").replace("prodOptVal1","prodOptVal"+intTrCnt));
		});

		objCopyRow.find("input[type^=text]").val("");
		objCopyRow.find("input[type^=hidden]").val("");
		objCopyRow.find("input[type^=checkbox]").remove();

		$("#tabProdOpt").append(objCopyRow);
	});


	/*-- 상품옵션관리 삭제버튼--*/
	$("#btnProdOptDel").live("click",function(){
		
		if ($("#tabProdOpt tr").length > 2)
		{
			$("#tabProdOpt tr:last").remove();
		}						
	});


	/*-- 상품옵션관리 추가--*/
	$("#btnProdOptAttrAdd").live("click",function(){
		
		var objCopyRow = $("#tabProdOptAttr tr:eq(1)").clone();

		objCopyRow.find("input[type^=text]").val("");
		objCopyRow.find("input[type^=hidden]").val("");

		$("#tabProdOptAttr").append(objCopyRow);
					
	});

	/*-- 상품옵션간리 삭제 --*/
	$("#btnProdOptAttrDel").live("click",function(){
		
		if ($("#tabProdOptAttr tr").length > 2)
		{
			$("#tabProdOptAttr tr:last").remove();
		}
	
	});


	$("#btnProdAddOptValAdd").live("click",function(){
		
		var objClickRow = $(this).parent().parent();
		var strClickRowClass = objClickRow.attr("class");
		
		var objCopyRow = objClickRow.clone();
		objCopyRow.find("td:eq(0)").remove();
		objCopyRow.find("td:eq(0) > a > strong").text("-삭제")
		//objCopyRow.find("td:eq(0) > a").attr("href","")
		objCopyRow.find("td:eq(0) > a").attr("id","btnProdAddOptValDel")
		objCopyRow.insertAfter($("#tabProdAddOpt ."+strClickRowClass+":last"));
		
		objCopyRow.find("input[type^=text]").val("");
		objCopyRow.find("input[type^=hidden]").val("");

		goProdAddOptRowResize(strClickRowClass);
					
	});
	
	$("#btnProdAddOptValDel").live("click",function(){
		
		var objClickRow = $(this).parent().parent();
		var strClickRowClass = objClickRow.attr("class");
		
		if (objClickRow.find("td:eq(0)").attr("rowspan"))
		{
			if (objClickRow.next().hasClass(strClickRowClass))
			{
				//objClickRow.next().prepend(objClickRow.find("td:eq(0)"));
			}
		}
		objClickRow.remove();

		goProdAddOptRowResize(strClickRowClass);
					
	});

	$("#btnProdImgAdd").live("click",function(){
		var objCopyRow	= $("#tabProdImg tr:eq(2)").clone();
		var intTrCnt	= $("#tabProdImg tr").length;
		var intRowNo	= intTrCnt - 1;
		var intFileNo1	= intRowNo + 5;
		var intFileNo2	= intRowNo + 16;
		
		if (intRowNo > 12)
		{
			alert("상품이미지는 12개이하만 등록 가능합니다.");
			return;
		}
		
		objCopyRow.find("th:eq(0)").html("상세이미지"+intRowNo);
		objCopyRow.find("th:eq(1)").html("확대이미지"+intRowNo);

		objCopyRow.find("td:eq(0)").html("<input type=\"file\" id=\"prodImg"+intFileNo1+"\" name=\"prodImg"+intFileNo1+"\" value=\"\" style=\"height:20px;\" "+strInputBoxStyle+"/>");

		objCopyRow.find("td:eq(1)").html("<input type=\"file\" id=\"prodImg"+intFileNo2+"\" name=\"prodImg"+intFileNo2+"\" value=\"\" style=\"height:20px;\" "+strInputBoxStyle+"/></a>");
		
		$("#tabProdImg").append(objCopyRow);
		alert($("#tabProdImg").html());
	});

	function goProdAddOptRowResize(rowClass)
	{
		var intRowSpan = $("."+rowClass).length;
		$("."+rowClass+":first td:eq(0)").attr("rowspan",intRowSpan);
	}


	/* 상품추가옵션정보 : 옵션 추가 */
	function goProdAddOptAdd()
	{
		var intLastOptNo = $("#tabProdAddOpt tr:last").attr("class").replace("trProdAddOpt","");
		var intNewOptNo = parseInt(intLastOptNo)+1;
		
		var strNewOptHtml = "";
		var objProdNewOpt = $("#tabProdAddOpt tr:eq(1)").clone();
		objProdNewOpt.removeClass();
		objProdNewOpt.addClass("trProdAddOpt"+intNewOptNo);

		//objProdNewOpt.find("#btnProdAddOptAdd").remove();
		//objProdNewOpt.find("#btnProdAddOptDel").remove();
		
		/*var objProdNewAddOptName = objProdNewOpt.find("input[id=prodAddOptName[]");
		objProdNewAddOptName.attr("id",objProdNewAddOptName.attr("id").replace("prodAddOptName"+intLastOptNo,"prodAddOptName"+intNewOptNo));		
		objProdNewAddOptName.attr("name",objProdNewAddOptName.attr("name").replace("prodAddOptName"+intLastOptNo,"prodAddOptName"+intNewOptNo));*/
		

		var objProdNewAddOptVal = objProdNewOpt.find("input[id^=prodAddOptVal"+intLastOptNo+"]");
		objProdNewAddOptVal.attr("id",objProdNewAddOptVal.attr("id").replace("prodAddOptVal"+intLastOptNo,"prodAddOptVal"+intNewOptNo));
		objProdNewAddOptVal.attr("name",objProdNewAddOptVal.attr("name").replace("prodAddOptVal"+intLastOptNo,"prodAddOptVal"+intNewOptNo));
		
		var objProdNewAddOptPrice = objProdNewOpt.find("input[id^=prodAddOptPrice"+intLastOptNo+"]");
		objProdNewAddOptPrice.attr("id",objProdNewAddOptPrice.attr("id").replace("prodAddOptPrice"+intLastOptNo,"prodAddOptPrice"+intNewOptNo));
		objProdNewAddOptPrice.attr("name",objProdNewAddOptPrice.attr("name").replace("prodAddOptPrice"+intLastOptNo,"prodAddOptPrice"+intNewOptNo));
		
		objProdNewOpt.find("#btnProdAddOptAdd").remove();
		objProdNewOpt.find("input[type^=text]").val("");
		objProdNewOpt.find("input[type^=hidden]").val("");
		$("#tabProdAddOpt").append(objProdNewOpt);
	}

	/* 상품추가옵션정보 : 옵션 삭제(아래에서 하나씩 삭제) */
	function goProdAddOptDel()
	{
		var intLastOptNo = $("#tabProdAddOpt tr:last").attr("class").replace("trProdAddOpt","");
		var intDelRow = intLastOptNo - 1;

		if (intDelRow > 0)
		{
			$(".trProdAddOpt"+intLastOptNo).remove();
		}
	}

	/* 상품정보 등록/수정 */
//	function goProdAct(mode)
//	{
//		if(!C_chkInput("prodName",true,"상품명",true)) return;
//
//		document.form.encoding = "multipart/form-data";
//		C_getAction(mode,'<?=$PHP_SELF?>');
//	}
	
	/* 상품목록 검색*/
	function goSearch(mode){
		C_getMoveUrl(mode,"get","<?=$PHP_SELF?>");
	}

	/* 상품정보 수정 호출*/
	function goProdModify(no,lang)
	{
		var doc = document.form;
		doc.prodCode.value = no;
		doc.prodLang.value = lang;

		C_getMoveUrl("prodModify","get","<?=$PHP_SELF?>");
	}

	/* 상품정보 삭제*/
	function goProdDelete(no)
	{
		var doc = document.form;
		doc.prodCode.value = no;

		var x = confirm("선택한 상품을 삭제하시겠습니까?");
		if (x == true)
		{
			C_getAction("prodDelete",'<?=$PHP_SELF?>');
		}
	}
		
	/* 상품무제한체크 */
	function goStockLimit(chkObj)
	{
		if (chkObj.checked == true)
		{
			$("#prodQty").val("0");
			$("#prodQty").attr("disabled",true);
		} else {
			$("#prodQty").attr("disabled",false);
		}
	}

	/* 관심상품 팝업창 링크 */
	function goPopup(mode,popName,popWidth,popHeight,param)
	{
		C_openWindow("./?menuType=product&mode="+mode+param,popName, popWidth, popHeight);
	}

	/* 상품 제조사/모델/원산지 선택시 input 박스 입력 */
	function goSelectInputVal(name)
	{
		if (name == "Brand")
		{
			$("#prod"+name).val($("#selectProd"+name).val());
			$("#prod"+name+"Name").val($("#selectProd"+name+" option:selected").text());

			if ($("#selectProd"+name).val() == "")
			{
				$("#prod"+name+"Name").val("");
			}
					
		} else {
			$("#prod"+name).val($("#selectProd"+name).val());
		}
	}

	/* 상품 브랜드 관리*/
	function goBrandWrite()
	{
		C_getMoveUrl("prodBrandWrite","get","<?=$PHP_SELF?>");
	}

	function goProdBrandModify(no)
	{
		document.form.brandNo.value = no;
		C_getMoveUrl("prodBrandModify","get","<?=$PHP_SELF?>");
	}

	function goProdBrandDelete(no)
	{
		document.form.brandNo.value = no;
		
		var x = confirm("브랜드를 삭제하시겠습니까?");
		if (x == true)
		{
			C_getAction("prodBrandDelete","<?=$PHP_SELF?>");	
		}
	}

	
	function goProdBrandList()
	{
		C_getMoveUrl("prodBrandList","get","<?=$PHP_SELF?>");
	}

	function goProdBrandAct(mode)
	{
		if(!C_chkInput("brandName",true,"브랜드명",true)) return;
		
		document.form.encoding = "multipart/form-data";
		C_getAction(mode,"<?=$PHP_SELF?>");				
	}


	/* 상품 이미지 및 파일 삭제*/
	function goProdImgDel(no)
	{
		document.form.prodImgNo.value = no;
		
		var x = confirm("선택한 이미지 및 파일을 삭제하시겠습니까?");
		if (x == true)
		{
			C_getAction("prodImgDel","<?=$PHP_SELF?>");	
		}
	}
	
	/* 상품 목록 이동 */
	function goProdList()
	{
		C_getMoveUrl("prodList","get","<?=$PHP_SELF?>");
	}


	/* 상품정보 등록/수정 */
	function goProdAct(mode)
	{
		if(!C_chkInput("prodName",true,"상품명",true)) return;

		mode = "prodTempWrite";
		document.form.menuType.value = "product";
		document.form.mode.value = "act";
		document.form.act.value = "prodTempWrite";
		document.form.encoding = "multipart/form-data";

		C_getAction(mode,'<?=$PHP_SELF?>');
	}



	function callCateList(cateLevel,cateHCode,cateView,cateObj,cateSelected)
	{
		var strJsonParam = "menuType=product&mode=json&jsonMode=cateLevelList";
		strJsonParam += "&cateLevel="+cateLevel+"&cateHCode="+cateHCode+"&cateView="+cateView+"&cateLng=<?=$strStLng?>";
		
		$.ajax({				
			type:"POST",
			url:"./index.php",
			data :strJsonParam,
			dataType:"json", 
			success:function(data){	
				$("#"+cateObj).html("<option value=''>"+cateLevel+"차 카테고리 선택</option>");
				for(var i=0;i<data.length;i++){
					var strCateSelected = "";
					if (data[i].CATE_CODE == cateSelected)
					{
						strCateSelected = "selected";
					}
					$("#"+cateObj).append("<option value='"+data[i].CATE_CODE+"' "+strCateSelected+">"+data[i].CATE_NAME+"</option>");
				}
			}
		});
	}


	/* 상품추가정보 : 항목 추가 */ 
	function goProdItemAdd()
	{	
		var intLastItemNo = $("#trProdItemList tr:last").attr("class").replace("prodItem","");
		
		var intNewItemNo = parseInt(intLastItemNo)+1;
		var strNewItemHtml = "";
		var objProdNewItem = $("#trProdItemList tr:eq(0)").clone();
		objProdNewItem.removeClass();
		objProdNewItem.addClass("prodItem"+intNewItemNo);
		
		objProdNewItem.find("th:eq(0)").html("항목명"+intNewItemNo);
		objProdNewItem.find("th:eq(1)").html("항목설명"+intNewItemNo);
		
		strNewItemHtml  = "<input type=\"text\" "+strInputBoxStyle+" style=\"width:150px;\" id=\"prodItem[]\" name=\"prodItem[]\"/>";
		strNewItemHtml += " <a class=\"btn_sml\" href=\"javascript:goProdItemDel("+intNewItemNo+");\" id=\"btnItemAdd\"><strong>-삭제</strong></a>";
		objProdNewItem.find("td:eq(0)").html(strNewItemHtml);

		objProdNewItem.find("input[type^=text]").val("");
		objProdNewItem.find("input[type^=hidden]").val("");

		$("#trProdItemList").append(objProdNewItem);		
	}

	
	/* 상품추가정보 : 항목 삭제 */
	function goProdItemDel(no)
	{
		var intDelRow = no - 1;

		if (intDelRow > 0)
		{
			$(".prodItem"+no).remove();
		}
	}


	/* 상품 이미지 및 파일 삭제 (스크랩핑 DB)*/
	function goProdImgTempDel(no)
	{
		document.form.prodImgNo.value = no;
		document.form.mode.value = "prodModify";
		document.form.menuType.value = "product";
		
		var x = confirm("선택한 이미지 및 파일을 삭제하시겠습니까?");
		if (x == true)
		{
			C_getAction("prodImgTempDel","<?=$PHP_SELF?>");	
		}
	}


	/* 상품무제한체크 */
	function goStockLimit(chkObj)
	{
		if (chkObj.checked == true)
		{
			$("#prodQty").val("0");
			$("#prodQty").attr("disabled",true);
		} else {
			$("#prodQty").attr("disabled",false);
		}
	}




	/* 상품 옵션 추가(New)*/
	function goProdOptAttrAdd(){

		<?if ($strMode == "prodModify"){?>
		if (!C_isNull($("#tabProdOpt").html()))
		{
			var x = confirm("이미 등록된 옵션 속성들이 존재합니다.\r\n옵션 속성들을 다시 설정하시면 이미 등록된 옵션 속성 정보가 삭제됩니다. 진행하시겠습니까?");
			if (x==false)
			{
				return;
			}
		}
		<?}?>
		
		
		if(!C_chkInput("prodOptName1",true,"옵션명",true)) return;
		if(!C_chkInput("prodOptVal1",true,"옵션속성",true)) return;

		var intProdOptCnt = $("#tabProdOpt tr").length - 1;
		var aryProdOptVal = new Array(intProdOptCnt);
	
		var intProdOptAttrCnt = 1;
		for(var i=1;i<=intProdOptCnt;i++){
			var strProdOptVal = $("#prodOptVal"+i).val();
			aryProdOptVal[i] = strProdOptVal.split(";");
			
			intProdOptAttrCnt = intProdOptAttrCnt * aryProdOptVal[i].length;
		}
				
		/*배열선언*/
		var aryProdOptAttr = new Array(intProdOptAttrCnt);
		for(var i=0;i<=intProdOptAttrCnt+1;i++){
			aryProdOptAttr[i] = new Array(intProdOptCnt+1);
		}
		
		var intLoopCnt = intProdOptAttrCnt/aryProdOptVal[1].length;
		var intLoopIndex = 1;
		for(var i=0;i<aryProdOptVal[1].length;i++){
			for(var j=1;j<=intLoopCnt;j++){
				aryProdOptAttr[intLoopIndex][1] = aryProdOptVal[1][i];
				intLoopIndex++;
			}
		}

		/* 옵션이 하나 이상일때 */
		if (intProdOptCnt > 1)
		{
			intPreLoopCnt = intProdOptAttrCnt/aryProdOptVal[1].length;
			for(var k=2;k<aryProdOptVal.length;k++){
				
				intLoopCnt = intPreLoopCnt/aryProdOptVal[k].length;
				intLoopIndex = 1;
				if (k == intProdOptCnt)
				{
					//마지막 옵션일때
					intLoopCnt = intProdOptAttrCnt/intPreLoopCnt;
					for(var kk=1;kk<=(intProdOptAttrCnt/(aryProdOptVal[k].length * intLoopCnt));kk++){
						for(var j=1;j<=intLoopCnt;j++){

							for(var i=0;i<aryProdOptVal[k].length;i++){
								aryProdOptAttr[intLoopIndex][k] = aryProdOptVal[k][i];
								intLoopIndex++;
							}
						}
					}

				} else {

					for(var kk=1;kk<=(intProdOptAttrCnt/(aryProdOptVal[k].length * intLoopCnt));kk++){
						for(var i=0;i<aryProdOptVal[k].length;i++){
							for(var j=1;j<=intLoopCnt;j++){
								
								aryProdOptAttr[intLoopIndex][k] = aryProdOptVal[k][i];
								intLoopIndex++;
							}
						}
					}
				}
			}
		}
				
		var strHtml = "";
		strHtml += "<tr>";
		
		strHtml += "</tr>";
		for(var j=1;j<=intProdOptCnt;j++){
			strHtml += "<th>"+$("#prodOptName"+j).val()+"</th>";
		}
		strHtml += "<th>재고</th>";
		strHtml += "<th>판매가격</th>";
		strHtml += "<th>소비자가격</th>";
		strHtml += "<th>입고가격</th>";
		strHtml += "<th>적립금</th>";
		strHtml += "</tr>";
		
		var strProdOptAttrDisabled = "disabled";
		if ($(":radio[name=prodOptType]:checked").val() != "1") strProdOptAttrDisabled = "";
		for(var i=1;i<=intProdOptAttrCnt;i++){
			strHtml += "<tr>";
			for(var j=1;j<=intProdOptCnt;j++){
				strHtml += "<td><input type=\"text\" style=\"width:120px;\" id=\"prodOptAttrVal1_"+j+"[]\" name=\"prodOptAttrVal1_"+j+"[]\" value=\""+aryProdOptAttr[i][j]+"\" /></td>";
			}
			
			strHtml += "<td><input type=\"text\" style=\"width:90px;\" id=\"prodOptAttrQty1[]\" name=\"prodOptAttrQty1[]\" value=\"\"/></td>";
			strHtml += "<td><input type=\"text\" style=\"width:120px;\" id=\"prodOptAttrSalePrice1[]\" name=\"prodOptAttrSalePrice1[]\" value=\"\" "+strProdOptAttrDisabled+"/></td>";
			strHtml += "<td><input type=\"text\" style=\"width:120px;\" id=\"prodOptAttrConsumerPrice1[]\" name=\"prodOptAttrConsumerPrice1[]\" value=\"\" "+strProdOptAttrDisabled+"/></td>";
			strHtml += "<td><input type=\"text\" style=\"width:120px;\" id=\"prodOptAttrStockPrice1[]\" name=\"prodOptAttrStockPrice1[]\" value=\"\" "+strProdOptAttrDisabled+"/></td>";
			strHtml += "<td><input type=\"text\" style=\"width:120px;\" id=\"prodOptAttrPoint1[]\" name=\"prodOptAttrPoint1[]\" value=\"\" "+strProdOptAttrDisabled+"/></td>";
			strHtml += "</tr>";
		}
		$("#tabProdOptAttr").html(strHtml);


	}
//-->
</script>

<form name="form" id="form">

<input type="hidden" name="menuType" value="<?=$strMenuType?>">
<input type="hidden" name="mode" id="mode" value="<?=$strMode?>">
<input type="hidden" name="act" value="<?=$strMode?>">
<input type="hidden" name="prodLang" value="<?=$strProdLng?>">
<input type="hidden" name="prodCode" id="prodCode" value="<?=$strP_CODE?>">
<input type="hidden" name="p_use" id="p_use" value="Y">
<input type="hidden" name="prodImgNo" id="prodImgNo" value="">






<? include  MALL_WEB_PATH."shopAdmin/product/prodModify.php" ?>


</form>
