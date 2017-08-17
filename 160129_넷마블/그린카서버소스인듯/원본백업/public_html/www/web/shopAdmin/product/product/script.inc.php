<script type="text/javascript">
<!--
	var strInputBoxStyle = " class=\"nbox\" onfocus=\"this.className='sbox'\" onblur=\"this.className='nbox'\"";

	$(document).ready(function(){
		C_CallMenuAuthBtn("<?=$a_admin_no?>","<?=$strTopMenuCode?>","<?=$strLeftMenuCode01?>","<?=$strLeftMenuCode02?>");
		var strHCode = "";

		<?if (in_array($strMode,array("prodWrite","prodModify","prodAuctionWrite","prodAuctionModify"))){?>

			$('input[name=prodListIconStartDt]').simpleDatepicker();
			$('input[name=prodListIconEndDt]').simpleDatepicker();

			$("input[name='prodListIconView']").click(function() {
				$("#divProdIconStartEndDate").css("display","none");
				if ($(this).val() == 2)
				{
					$("#divProdIconStartEndDate").css("display","block");
				}
			});

			<?if ($strMode != "prodModify" && $strMode != "prodAuctionModify"){?>
			callCateList(1,"","","cateHCode1","<?=$strC_HCODE1?>");
			<?}?>

			$("#cateHCode1").change(function() {
				if ($(this).val())
				{
					callCateList(2,$(this).val(),"","cateHCode2","");
				}
			});

			$("#cateHCode2").change(function() {
				if ($(this).val())
				{
					strHCode = $("#cateHCode1 option:selected").val()+$(this).val();
					callCateList(3,strHCode,"","cateHCode3","");
				}
			});

			$("#cateHCode3").change(function() {
				if ($(this).val())
				{
					strHCode = $("#cateHCode1 option:selected").val()+$("#cateHCode2 option:selected").val()+$(this).val();
					callCateList(4,strHCode,"","cateHCode4","");
				}
			});

			$("input[name='prodSalePrice']").keyup(function(event) {
				goProdAccPriceCal();
				goProdDiscountPriceCal('1');
			});

			$("input[name='prodStockPrice']").keyup(function(event) {
				goProdAccPriceCal();
			});


			$("input[name='prodConsumerPrice']").keyup(function(event) {
				goProdDiscountPriceCal('2');
			});

			$("input[name='prodDiscountRate']").keyup(function(event) {
				goProdDiscountPriceCal('3');
			});

			<?if ($S_PRODUCT_AUCTION_USE == "Y"){ //경매관리?>
			$('input[name=prodAucStDt]').simpleDatepicker();
			$('input[name=prodAucEndDt]').simpleDatepicker();
			<?}?>
		<?}?>

		<?if ($strMode == "prodList"){?>
			$('input[name=searchLaunchStartDt]').simpleDatepicker();
			$('input[name=searchLaunchEndDt]').simpleDatepicker();
			$('input[name=searchRepStartDt]').simpleDatepicker();
			$('input[name=searchRepEndDt]').simpleDatepicker();
		<?}?>

		<?if (in_array($strMode,array("prodWrite","prodModify","prodAuctionWrite","prodAuctionModify"))){?>
			$('#prodOptAttrQty1[]').numeric();
			$("#prodOptAttrQty1[]").css("ime-mode", "disabled");

			$('#prodOptAttrSalePrice1[]').numeric();
			$("#prodOptAttrSalePrice1[]").css("ime-mode", "disabled");

			$('#prodOptAttrConsumerPrice1[]').numeric();
			$("#prodOptAttrConsumerPrice1[]").css("ime-mode", "disabled");

			$('#prodOptAttrStockPrice1[]').numeric();
			$("#prodOptAttrStockPrice1[]").css("ime-mode", "disabled");

			$('#prodOptAttrPoint1[]').numeric();
			$("#prodOptAttrPoint1[]").css("ime-mode", "disabled");

			$("input[name='prodOptType']").click(function() {
				var intProdOptTypeVal = $(this).val();

				if (intProdOptTypeVal == 1)
				{

					$("input[id^=prodOptAttrSalePrice]").attr("disabled", true);
					$("input[id^=prodOptAttrConsumerPrice]").attr("disabled", true);
					$("input[id^=prodOptAttrStockPrice]").attr("disabled", true);
					$("input[id^=prodOptAttrPoint]").attr("disabled", true);

				} else {

					$("input[id^=prodOptAttrSalePrice]").attr("disabled", false);
					$("input[id^=prodOptAttrConsumerPrice]").attr("disabled", false);
					$("input[id^=prodOptAttrStockPrice]").attr("disabled", false);
					$("input[id^=prodOptAttrPoint]").attr("disabled", false);

				}
			});


			$("#prodDelivery").live("click",function(){
				var intProdDeliveryVal = $(this).val();

				$("#divBaesongPrice").css("display", "none");

				if (intProdDeliveryVal == 3 || intProdDeliveryVal == 4 || intProdDeliveryVal == 5)
				{
					if (intProdDeliveryVal != "<?=$row[P_BAESONG_TYPE]?>")
					{
						$("#prodDeliveryPrice").val("");
					}
					$("#divBaesongPrice").css("display", "block");
				}
			});


			<? if ($strMode == "prodModify" || $strMode == "prodAuctionModify"){
				if ($prodRow[P_OPT] == "1"){
				?>
				$("input[id^=prodOptAttrSalePrice]").attr("disabled", true);
				$("input[id^=prodOptAttrConsumerPrice]").attr("disabled", true);
				$("input[id^=prodOptAttrStockPrice]").attr("disabled", true);
				$("input[id^=prodOptAttrPoint]").attr("disabled", true);
				<?}else{?>
				$("input[id^=prodOptAttrSalePrice]").attr("disabled", false);
				$("input[id^=prodOptAttrConsumerPrice]").attr("disabled", false);
				$("input[id^=prodOptAttrStockPrice]").attr("disabled", false);
				$("input[id^=prodOptAttrPoint]").attr("disabled", false);
				<?}?>
			<?}?>

			$("#btnProdOptAdd").live("click",function(){
				var objCopyRow = $("#tabProdOpt tr:eq(1)").clone();
				var intTrCnt = $("#tabProdOpt tr").length;

				if (intTrCnt > 10)
				{
					alert("<?=$LNG_TRANS_CHAR['PS00017']?>"); //옵션 속성은 10개이하만 등록 가능합니다.
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
				objCopyRow.find("input[id^=prodOptEss]").each(function(i){

					$(this).attr("id",$(this).attr("id").replace("prodOptEss1","prodOptEss"+intTrCnt));
					$(this).attr("name",$(this).attr("name").replace("prodOptEss1","prodOptEss"+intTrCnt));
				});

				objCopyRow.find("input[type^=text]").val("");
				objCopyRow.find("input[type^=hidden]").val("");
				objCopyRow.find("input[type^=checkbox]").val("");
				objCopyRow.find("input[type^=checkbox]").attr("checked", false);

				$("#tabProdOpt").append(objCopyRow);
			});

			$("#btnProdOptDel").live("click",function(){

				if ($("#tabProdOpt tr").length > 2)
				{
					$("#tabProdOpt tr:last").remove();
				}
			});

			$("#btnProdOptAttrAdd").live("click",function(){

				var objCopyRow = $("#tabProdOptAttr tr:eq(1)").clone();

				objCopyRow.find("input[type^=text]").val("");
				objCopyRow.find("input[type^=hidden]").val("");

				$("#tabProdOptAttr").append(objCopyRow);

			});

			$("#btnProdOptAttrDel").live("click",function(){

				if ($("#tabProdOptAttr tr").length > 2)
				{
					$("#tabProdOptAttr tr:last").remove();
				}

			});


			$("#btnProdImgAdd").live("click",function(){
				var objCopyRow	= $("#productDetailImage_1").clone();
				var rowLength	= $("tr[id^=productDetailImage_]").length;
				
				if (rowLength >= 3) {
					alert("<?=$LNG_TRANS_CHAR['PS00018']?>"); //상품이미지는/ 3개이하만 등록 가능합니다.
					return;
				}

				$(objCopyRow).find("a[id=btnProdImgAdd]").remove();
				$(objCopyRow).find("a[id=btnProdImgView]").remove();
				$(objCopyRow).find("a[id=btnProdImgDelete]").remove();
				$(objCopyRow).find("#prodImgBasic").attr("name","prodImg"+(rowLength+7));
				$(objCopyRow).find("#prodImgExpend").attr("name","prodImg"+(rowLength+18));

				$("#tabProdImg2").append(objCopyRow);
			});

<? /**		2013.04.05 추가이미지 -> 확대이미지로 변경
			$("#btnProdImgAdd").live("click",function(){
				var objCopyRow	= $("#tabProdImg tr:eq(0)").clone();
				var intTrCnt	= $("#tabProdImg tr").length;
				var intFileNo1	= intTrCnt + 18;

				if (intTrCnt > 12) {
					alert("<?=$LNG_TRANS_CHAR['PS00018']?>"); //상품이미지는 12개이하만 등록 가능합니다.
					return;
				}

				objCopyRow.find("th:eq(0)").html("<?=$LNG_TRANS_CHAR['PW00073']?>"+(intTrCnt+1)); //상세이미지
				objCopyRow.find("input[name=prodImg18]").attr("name", "prodImg"+intFileNo1);
				objCopyRow.find("a[id=btnProdImgAdd]").remove();
				objCopyRow.find("a[id=btnProdImgDel]").remove();
				objCopyRow.find("a[id=btnProdImgView]").remove();
				objCopyRow.find("a[id=btnProdImgDelete]").remove();

				$("#tabProdImg").append(objCopyRow);
			});
	**/ ?>

<? /**		2013.03.13 레이아웃 변경
			$("#btnProdImgAdd").live("click",function(){
				var objCopyRow	= $("#tabProdImg tr:eq(2)").clone();
				var intTrCnt	= $("#tabProdImg tr").length;
				var intRowNo	= intTrCnt - 1;
				var intFileNo1	= intRowNo + 5;
				var intFileNo2	= intRowNo + 16;

				if (intRowNo > 12)
				{
					alert("<?=$LNG_TRANS_CHAR['PS00018']?>"); //상품이미지는 12개이하만 등록 가능합니다.
					return;
				}

				objCopyRow.find("th:eq(0)").html("<?=$LNG_TRANS_CHAR['PW00073']?>"+intRowNo); //상세이미지
				objCopyRow.find("th:eq(1)").html("<?=$LNG_TRANS_CHAR['PW00074']?>"+intRowNo); //확대이미지

				objCopyRow.find("td:eq(0)").html("<input type=\"file\" id=\"prodImg"+intFileNo1+"\" name=\"prodImg"+intFileNo1+"\" value=\"\" style=\"height:20px;\" "+strInputBoxStyle+"/>");

				objCopyRow.find("td:eq(1)").html("<input type=\"file\" id=\"prodImg"+intFileNo2+"\" name=\"prodImg"+intFileNo2+"\" value=\"\" style=\"height:20px;\" "+strInputBoxStyle+"/></a>");

				$("#tabProdImg").append(objCopyRow);
			});
  **/ ?>
			$("#btnProdImgDel").live("click",function(){
				var objClickRow = $(this).parent().parent();
				var intTrCnt	= $("#tabProdImg tr").length;
				var intDelRowNo = intTrCnt - 1;

				if (intTrCnt < 4)
				{
					return;
				}

				if (!C_isNull($("#tabProdImg tr:eq("+(intDelRowNo)+")").find(".btn_sml").html()))
				{
					alert("<?=$LNG_TRANS_CHAR['PS00019']?>"); //먼저 이미지를 삭제해주세요.
					return;
				}
				$("#tabProdImg tr:eq("+(intDelRowNo)+")").remove();
			});


			function goProdOptRowResize(rowClass)
			{
				var intRowSpan = $("."+rowClass).length;
				$("."+rowClass+":first td:eq(0)").attr("rowspan",intRowSpan);
			}


			$("#btnProdAddOptValAdd").live("click",function(){

				var objClickRow = $(this).parent().parent();
				var strClickRowClass = objClickRow.attr("class");
				var intOptNo = strClickRowClass.replace("trProdAddOpt","");

				var objCopyRow = objClickRow.clone();
				objCopyRow.find("td:eq(0)").remove();
				objCopyRow.find("td:eq(0) > a > strong").text("-삭제");
				objCopyRow.find("td:eq(0) > a").removeClass();
				objCopyRow.find("td:eq(0) > a").addClass("btn_sml");
				//objCopyRow.find("td:eq(0) > a").attr("href","")
				objCopyRow.find("td:eq(0) > a").attr("id","btnProdAddOptValDel")
				objCopyRow.insertAfter($("#tabProdAddOpt ."+strClickRowClass+":last"));

				var objProdNewAddOptVal = objCopyRow.find("input[id^=prodAddOptVal]");
				objProdNewAddOptVal.attr("id","prodAddOptVal"+intOptNo+"[]");
				objProdNewAddOptVal.attr("name","prodAddOptVal"+intOptNo+"[]");

				var objProdNewAddOptPrice = objCopyRow.find("input[id^=prodAddOptPrice]");
				objProdNewAddOptPrice.attr("id","prodAddOptPrice"+intOptNo+"[]");
				objProdNewAddOptPrice.attr("name","prodAddOptPrice"+intOptNo+"[]");

				objCopyRow.find("input[id^=prodAddOptNo]").remove();
				objCopyRow.find("input[id^=prodAddOptAttrNo]").remove();

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

			function goProdAddOptRowResize(rowClass)
			{
				var intRowSpan = $("."+rowClass).length;
				$("."+rowClass+":first td:eq(0)").attr("rowspan",intRowSpan);
			}

			$("#prodImgUrlYN").live("click",function(){
				$("#tabProdImg2").css("display","none");
				$("#tabProdImg3").css("display","none");
				if ($(this).is(":checked"))
				{
					$("#tabProdImg3").css("display","");
				} else {
					$("#tabProdImg2").css("display","");
				}

				$("#prodImgFileYN").attr("checked",false);
			});

			$("#prodImgFileYN").live("click",function(){
				$("#tabProdImg2").css("display","none");
				$("#tabProdImg3").css("display","none");
				if ($(this).is(":checked"))
				{
					$("#tabProdImg2").css("display","");
				} else {
					$("#tabProdImg3").css("display","");
				}
				$("#prodImgUrlYN").attr("checked",false);
			});

			$("#btnProdUrlImgAdd").live("click",function(){
				var objCopyRow	= $("#productDetailUrlImage_1").clone();
				var rowLength	= $("tr[id^=productDetailUrlImage]").length;

				if (rowLength > 12) {
					alert("<?=$LNG_TRANS_CHAR['PS00018']?>"); //상품이미지는 12개이하만 등록 가능합니다.
					return;
				}

				$(objCopyRow).find("a[id=btnProdUrlImgAdd]").remove();
				$(objCopyRow).find("a[id=btnProdUrlImgView]").remove();
				$(objCopyRow).find("a[id=btnProdUrlImgDelete]").remove();
				$(objCopyRow).find("#prodUrlImgBasic").attr("name","prodUrlImg"+(rowLength+7));
				$(objCopyRow).find("#prodUrlImgExpend").attr("name","prodUrlImg"+(rowLength+18));

				$("#tabProdImg3").append(objCopyRow);
			});

		<?}?>


	});


	/* 이벤트 정의 */
	function goKrTabPageMove() { goTabPage("<?=$strMode?>", "KR"); }
	function goUsTabPageMove() { goTabPage("<?=$strMode?>", "US"); }
	function goJpTabPageMove() { goTabPage("<?=$strMode?>", "JP"); }
	function goCnTabPageMove() { goTabPage("<?=$strMode?>", "CN"); }
	function goIdTabPageMove() { goTabPage("<?=$strMode?>", "ID"); }
	function goFrTabPageMove() { goTabPage("<?=$strMode?>", "FR"); }

	/* 함수 정의 */
	function goTabPage(mode, lng) {
		location.href = "./?menuType=product&mode="+mode+"&prodCode=<?=$strP_CODE?>&prodLang="+lng+"&lang="+lng+"&pageLine=<?=$intPageLine?>";
	}


	function goOpenWindow(pcode)
	{
		var strParam = "../<?=strtolower($S_ST_LNG)?>/?menuType=product&mode=view&act=list&prodCode=" + pcode;
		window.open(strParam);
//		C_openWindow( strParam, "<?=$LNG_TRANS_CHAR['PW00001']?>", 1024, 768);
	}

	function goPopClose()
	{
		$.smartPop.close();
	}

	function callCateList(cateLevel,cateHCode,cateView,cateObj,cateSelected)
	{
//		alert(cateSelected);
		var strJsonParam = "menuType=<?=$strMenuType?>&mode=json&jsonMode=cateLevelList";
		strJsonParam += "&cateLevel="+cateLevel+"&cateHCode="+cateHCode+"&cateView="+cateView+"&cateLng=<?=$strStLng?>";

		$.ajax({
			type:"POST",
			url:"./index.php",
			data :strJsonParam,
			dataType:"json",
			success:function(data){
				var strCateSelectedText = "";
				if (cateLevel == "1")
				{
					strCateSelectedText = "<?=$LNG_TRANS_CHAR['PW00013']?>";
				} else if (cateLevel == "2")
				{
					strCateSelectedText = "<?=$LNG_TRANS_CHAR['PW00014']?>";
				} else if (cateLevel == "3")
				{
					strCateSelectedText = "<?=$LNG_TRANS_CHAR['PW00015']?>";
				} else if (cateLevel == "4")
				{
					strCateSelectedText = "<?=$LNG_TRANS_CHAR['PW00016']?>";
				}

				$("#"+cateObj).html("<option value=''>"+strCateSelectedText+"</option>");
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

	/* 상품추가정보 : 항목 추가 script.inc.php
	function goProdItemAdd()
	{

		var intLastItemNo = $("#trProdItemList tr:last").attr("class").replace("prodItem","");

		var intNewItemNo = parseInt(intLastItemNo)+1;
		var strNewItemHtml = "";
		var objProdNewItem = $("#trProdItemList tr:eq(0)").clone();
		objProdNewItem.removeClass();
		objProdNewItem.addClass("prodItem"+intNewItemNo);

		objProdNewItem.find("th:eq(0)").html("<?=$LNG_TRANS_CHAR['PW00062']?>"+intNewItemNo); //항목명
		objProdNewItem.find("th:eq(1)").html("<?=$LNG_TRANS_CHAR['PW00116']?>"+intNewItemNo); //항목설명

		strNewItemHtml  = "<input type=\"text\" "+strInputBoxStyle+" style=\"width:150px;\" id=\"prodItem[]\" name=\"prodItem[]\"/>";
		strNewItemHtml += " <a class=\"btn_sml\" href=\"javascript:goProdItemDel("+intNewItemNo+");\" id=\"btnItemAdd\"><strong>-삭제</strong></a>";
		objProdNewItem.find("td:eq(0)").html(strNewItemHtml);

		objProdNewItem.find("input[type^=text]").val("");
		objProdNewItem.find("input[type^=hidden]").val("");

		$("#trProdItemList").append(objProdNewItem);
	}
 */
function goProdItemAdd()
{

	var intLastItemNo = $("#trProdItemList tr:last").attr("class").replace("prodItem","");
	if(intLastItemNo > 2){
		alert("3개이상 등록 할 수 없습니다.");return;
	}
	var intNewItemNo = parseInt(intLastItemNo)+1;
	var objProdNewOpt = $("#trProdItemList tr:last").clone();
	objProdNewOpt.removeClass();
	objProdNewOpt.addClass("prodItem"+intNewItemNo);
	objProdNewOpt.find("a").remove();
	objProdNewOpt.find("td:eq(0)").append(" <a class=\"btn_sml\" href=\"javascript:goProdItemDel("+intNewItemNo+");\" id=\"btnItemAdd\"><strong>-삭제</strong></a>");
	$("#trProdItemList tbody").append(objProdNewOpt);

}

	function goProdItemAddVer2()
	{
		var intLastItemNo = $("#trProdItemList tr:last").attr("class").replace("prodItem","");
		if(intLastItemNo > 2){
			alert("3개이상 등록 할 수 없습니다.");return;
		}
		
		var intNewItemNo = parseInt(intLastItemNo)+1;
		var strNewItemHtml = "";
		var objProdNewItem = $("#trProdItemList tr:eq(1)").clone();
		objProdNewItem.removeClass();
		objProdNewItem.addClass("prodItem"+intNewItemNo);

		strNewItemHtml  = "<input type=\"text\" "+strInputBoxStyle+" style=\"width:150px;\" id=\"prodItem[]\" name=\"prodItem[]\"/>";
		strNewItemHtml += " <a class=\"btn_sml\" href=\"javascript:goProdItemDel("+intNewItemNo+");\" id=\"btnItemAdd\"><strong>-삭제</strong></a>";
		objProdNewItem.find("td:eq(0)").html(strNewItemHtml);

		objProdNewItem.find("input[type^=text]").val("");
		objProdNewItem.find("input[type^=hidden]").val("");

		$("#trProdItemList").append(objProdNewItem);
	}

	function goProdItemDel(no)
	{
		var intDelRow = no - 1;

		if (intDelRow > 0)
		{
			$(".prodItem"+no).remove();
		}
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

		if (objProdNewOpt.find("td:eq(1)").attr("rowspan") > 0)
		{
			objProdNewOpt.find("td:eq(0)").attr("rowspan","");
		}

		objProdNewOpt.find("td:eq(0) a").remove();

		objProdNewOpt.find("td:eq(1)").html("<input type=\"text\" "+strInputBoxStyle+"  style=\"width:120px;\" id=\"prodAddOptVal"+intNewOptNo+"[]\" name=\"prodAddOptVal"+intNewOptNo+"[]\" value=\"\"/> <a class=\"btn_blue_sml\" id=\"btnProdAddOptValAdd\"><strong>+<?=$LNG_TRANS_CHAR['CW00028']?></strong></a>");

		objProdNewOpt.find("td:eq(2)").html("<input type=\"text\" "+strInputBoxStyle+"  style=\"width:120px;\" id=\"prodAddOptPrice"+intNewOptNo+"[]\" name=\"prodAddOptPrice"+intNewOptNo+"[]\" value=\"\"/>");

		objProdNewOpt.find("input[id^=prodAddOptNo]").remove();
		objProdNewOpt.find("input[id^=prodAddOptAttrNo]").remove();

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
	function goProdAct(mode)
	{
//		var prodImg2		= $("#prodImg2").val();
//		var prodImgCopy		= $("#prodImgCopy").attr("checked");
//
//		if(prodImgCopy == "checked"){
//			 $("#prodImg1").val(prodImg2);
//			 $("#prodImg3").val(prodImg2);
//			 $("#prodImg4").val(prodImg2);
//			 $("#prodImg5").val(prodImg2);
//			 $("#prodImg6").val(prodImg2);
//		}
				
		
		
		if(!C_chkInput("prodName",true,"<?=$LNG_TRANS_CHAR['PW00002']?>",true)) return; //상품명

		<?if ($strForWeightYN == "Y"){?>
		//if(!C_chkInput("prodWeight",true,"<?=$LNG_TRANS_CHAR['PW00108']?>",true)) return; //상품무게
		<?}?>

		if(!C_chkInput("prodOrigin",true,"<?=$LNG_TRANS_CHAR['PW00005']; //원산지?>",true)) return; //원산지
	
		if(!C_chkInput("prodSaleMinQty",true,"<?=$LNG_TRANS_CHAR['PW00045'] //최소구매수량?>",true)) return; //최소구매수량

		if(!C_chkInput("prodSalePrice",true,"상품가",true)) return; //상품가

		//Ex. 10kg;20kg... 내용 없애기(goProdAct) 남덕희
		var EXprodVal = $("#prodOptVal1").val();
		if(EXprodVal.indexOf('Ex.') ==  0){
			$("#prodOptVal1").val('');
		}
		if(!C_chkInput("prodOptVal1",true,"<?=$LNG_TRANS_CHAR['PW00055']?>",true)) return; //상품옵션속성

		if($("#tabProdOptAttr").html() == ''){
			goProdOptAttrAdd();
		}

		//if(!C_chkInput("prodOptAttrQty1[]",true,"옵션속성별 모든 재고",true)) return; //상품옵션속성
		/*모든 속성 재고가 수량의 값을 넘는 지 확인.*/
		var noLimitChk = $("#prodStockLimit").is(":checked");
		var prodOptAttrQty1ValueCnt = 0;
		var prodOptAttrQty1NullChk = false;
		$('input[name="prodOptAttrQty1[]"]').each(function() // $('input[name^="nm"]').each(function()
		{
			if( $(this).val() == '' ){
				prodOptAttrQty1NullChk = true;
				return false;
			}else{
				prodOptAttrQty1ValueCnt += parseInt( $(this).val() );
			}
		});
		if(prodOptAttrQty1NullChk){ alert('옵션속성별 모든 재고를 입력해 주세요.'); return; }

		if(!noLimitChk){
			if($("#prodQty").val() < prodOptAttrQty1ValueCnt )
			{
				alert('옵션속성별 모든 재고 수량이 총 수량보다 많습니다.');
				$("#prodQty").focus();
				return false;
			}
		}

		/*모든 속성 재고가 수량의 값을 넘는 지 확인.*/


		<?
		if(!is_array($aryProdImg[4]))
		{
		?>
		if(!C_chkInput("prodImg4",true,"<?=$LNG_TRANS_CHAR['PW00074']?>",true)) return; //이미지
		<?}?>
		
		<? if ( $S_PRODUCT_NOTIFY_USE === 'Y') : // 입점형이 아닌 경우 ?>
		if ( typeof $('#notifyComm') != undefined && $('#notifyComm').length > 0 )
		{
			var require = false ;
			if ( $('#notifyComm').val() == '' )
			{
				$('#notifyComm').focus () ;
				return alert ( '상품고시 카테고리를 선택해 주십시오.' ) ;
			}

			$('#notifyComm').closest('table').next('table').find(':input').not('[type=hidden]').each(function(){
				if ( $(this).val() == '' )
					return require = true ;
			}) ;
			if ( require === true )
				return alert ( '상품고시정보는 필수 입력 사항입니다.' ) ;
		}
		<? endif ; ?>
		document.form.encoding = "multipart/form-data";
		C_getAction(mode,'<?=$PHP_SELF?>');
	}

	/* 상품목록 검색*/
	function goSearch(mode){
		$("input[name=page]").val("");
		C_getMoveUrl(mode,"get","<?=$PHP_SELF?>");
	}

	/* 상품정보 수정 호출*/
	function goProdModify(no,lang)
	{
//		var doc = document.form;
//		doc.prodCode.value = no;
//		doc.prodLang.value = lang;
//
//		C_getMoveUrl("prodModify","get","<?=$PHP_SELF?>");

		var data						= new Object();

		data['prodCode']				= no;
		data['prodLang']				= lang
		data['mode']					= "prodModify";

		C_getAddLocationUrl(data);
	}

	/* 상품정보 삭제*/
	function goProdDelete(no)
	{
		var doc = document.form;
		doc.prodCode.value = no;

		var x = confirm("<?=$LNG_TRANS_CHAR['CS00007']?>"); //선택한 상품을 삭제하시겠습니까?
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

	/* 상품 제조사/모델/원산지 선택시 input 박스 입력 */
	function goSelectInputVal(name)
	{
		if (name == "Brand")
		{
			$("#prod"+name).val($("#selectProd"+name).val());
//			$("#prod"+name+"Name").val($("#selectProd"+name+" option:selected").text());
//
//			if ($("#selectProd"+name).val() == "")
//			{
//				$("#prod"+name+"Name").val("");
//			}

		} else {
			$("#prod"+name).val($("#selectProd"+name).val());
		}
	}


	/* 상품 이미지 및 파일 삭제*/
	function goProdImgDel(no)
	{
		document.form.prodImgNo.value = no;

		var x = confirm("<?=$LNG_TRANS_CHAR['CS00007']?>"); //선택한 이미지 및 파일을 삭제하시겠습니까?
		if (x == true)
		{
			C_getAction("prodImgDel","<?=$PHP_SELF?>");
		}
	}

	/* 상품 목록 이동 */
	function goProdList()
	{
		var data = new Object();

		data['mode']	= "prodList";
		C_getAddLocationUrl(data);
//		C_getMoveUrl("prodList","post","<?=$PHP_SELF?>");
	}

	/* 상품 옵션 추가(New)*/
	function goProdOptAttrAdd(){

		<?if ($strMode == "prodModify" || $strMode == "prodAuctionModify"){?>
		if (!C_isNull($("#tabProdOpt").html()))
		{
			var x = confirm("<?=$LNG_TRANS_CHAR['PS00021']?>"); //이미 등록된 옵션 속성들이 존재합니다.옵션 속성들을 다시 설정하시면 이미 등록된 옵션 속성 정보가 삭제됩니다. 진행하시겠습니까?
			if (x==false)
			{
				return;
			}
		}
		<?}?>



		//Ex. 10kg;20kg... 내용 없애기 남덕희
		var EXprodVal = $("#prodOptVal1").val();
		if(EXprodVal.indexOf('Ex.') ==  0){
			$("#prodOptVal1").val('');
		}
		if(!C_chkInput("prodOptName1",true,"<?=$LNG_TRANS_CHAR['PW00054']?>",true)) return; //옵션명
		if(!C_chkInput("prodOptVal1",true,"<?=$LNG_TRANS_CHAR['PW00055']?>",true)) return; //옵션속성



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
		strHtml += "<th><?=$LNG_TRANS_CHAR['PW00017']?></th>";  //재고
		strHtml += "<th><?=$LNG_TRANS_CHAR['PW00115']?></th>";  //판매가격
		//strHtml += "<th><?=$LNG_TRANS_CHAR['PW00036']?></th>";  //소비자가격
		//strHtml += "<th><?=$LNG_TRANS_CHAR['PW00037']?></th>";  //입고가격
		//strHtml += "<th><?=$LNG_TRANS_CHAR['CW00034']?></th>";  //적립금
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
			//strHtml += "<td><input type=\"text\" style=\"width:120px;\" id=\"prodOptAttrConsumerPrice1[]\" name=\"prodOptAttrConsumerPrice1[]\" value=\"\" "+strProdOptAttrDisabled+"/></td>";
			//strHtml += "<td><input type=\"text\" style=\"width:120px;\" id=\"prodOptAttrStockPrice1[]\" name=\"prodOptAttrStockPrice1[]\" value=\"\" "+strProdOptAttrDisabled+"/></td>";
			//strHtml += "<td><input type=\"text\" style=\"width:120px;\" id=\"prodOptAttrPoint1[]\" name=\"prodOptAttrPoint1[]\" value=\"\" "+strProdOptAttrDisabled+"/></td>";
			strHtml += "</tr>";
		}

		$("#tabProdOptAttr").html(strHtml);
	}

	function goProdAllDelete()
	{
		C_getMultiCheck("prodAllDelete","<?=$PHP_SELF?>","<?=$LNG_TRANS_CHAR['CS00015']?>"); //데이터를 선택해주세요.
	}

	/* 상품 공유 설정 */
	function goProdShare(no)
	{
		$.smartPop.open({  bodyClose: false, width: 600, height: 500, url: './?menuType=product&mode=popProdShare&prodCode='+no, closeImg: {width:23, height:23} });
	}

	/* 상품 리스트 상품공유 목록 html insert */
	function goProdShareHtml(no,html)
	{
		$("#divProdShareHtml_"+no).html(html);
	}


	/* 상품복사 */
	function goProdCopy(no)
	{
		$.smartPop.open({  bodyClose: false, width: 700, height: 500, url: './?menuType=product&mode=popProdCopy&prodCode='+no, closeImg: {width:23, height:23} });
	}

	/* 상품일괄변경 */
	function goProdAllUpdate()
	{
		var strChkVal = C_getCheckedCode(document.form["chkNo[]"]);
		if (C_isNull(strChkVal))
		{
			alert("<?=$LNG_TRANS_CHAR['CS00017']?>"); //데이터를 선택해주세요.
			return;
		}

		C_getMultiCheck("prodAllUpdate","<?=$PHP_SELF?>","<?=$LNG_TRANS_CHAR['CS00017']?>"); //데이터를 선택해주세요.
	}

	/* 상품 카테고리 일괄변경 */
	function goProdCateUpdate()
	{
		var strChkVal = C_getCheckedCode(document.form["chkNo[]"]);
		if (C_isNull(strChkVal))
		{
			alert("<?=$LNG_TRANS_CHAR['CS00017']?>"); //데이터를 선택해주세요.
			return;
		}

		$.smartPop.open({  bodyClose: false, width: 600, height: 300, url: './?menuType=product&mode=popProdCateUpdate', closeImg: {width:23, height:23} });

	}

	<?
		if (in_array($strMode,array("prodWrite","prodModify","prodAuctionWrite","prodAuctionModify"))):
		include "script.prodWrite.php";
		endif;
	?>


	/** 2013.04.22 이벤트 함수 **/
	function goProdShareMultiMoveEvent() { goProdShareMultiMove();	}

	/** 2013.04.22 상품공유 일괄변경 */
	function goProdShareMultiMove() {

		var prodCodeMulti = "";
		$("input[id=chkNo]").each(function() {
			if($(this).attr("checked")=="checked") {
				if(prodCodeMulti) { prodCodeMulti = prodCodeMulti + ",";					}
									prodCodeMulti = prodCodeMulti + $(this).val();
			}
		});

		if(!prodCodeMulti) {
			alert("<?=$LNG_TRANS_CHAR['CS00017']?>"); //데이터를 선택해주세요.
			return;
		}

		$.smartPop.open({  bodyClose: false, width: 600, height: 500, url: './?menuType=product&mode=popProdShare&prodCodeMulti='+prodCodeMulti, closeImg: {width:23, height:23} });
	}

	/** public 함수 **/

	/**
	 * goCheckBox()
	 * 리스트 체크 박스 선택 개수 리턴
	 **/
	function goCheckBox() {
		var intCnt = 0;
		$("input[id=chkNo]").each(function() {
			if($(this).attr("checked")=="checked") {
				intCnt++;
			}
		});
		return intCnt;
	}

	function goProdListExcelMoveEvent() {
		var data = new Object();

		data['mode']	= "excel";
		data['act']		= "excelProdList";
		C_getAddLocationUrl(data);
	}

	function goProductSiteCommLoad() {
		var no					= $("select[id=siteComm] option:selected").val();
		var data				= new Object();
		if(!no) {
			alert("공통리스트를 선택하세요.");
			return;
		}

		data['menuType']		= "product";
		data['mode']			= "json";
		data['jsonMode']		= "productSiteCommLoad";
		data['no']				= no;

		$.ajax({
			url			: "./"
		   ,data		: data
		   ,type		: "POST"
		   ,dataType	: "json"
		   ,success		: function(data) {
				if(data['__STATE__'] == "SUCCESS") {
					var text		= data['DATA']['TEXT'];
					goProductProdAddTextEvent(text, 1);
//					editorInsertHTML(text,'new_prodWebText_iframe');
				} else {
					alert(data);
				}
		   }
		});
	}

	// 상품고시 불러오기
	function goProductNotifyCommLoad(prodCode) {

		var strProdNotifyCateCode= $("select[id=notifyComm] option:selected").val();
		if(!strProdNotifyCateCode) {
			alert("상품고시 카테고리를 선택하세요.");
			return;
		}

//		$("table[id^=trProdNotifyCateItem_").css("display","");
		var data				= new Object;
		data['menuType']		= "product";
		data['mode']			= "json";
		data['jsonMode']		= "productNotifyCommLoad";
		data['code']			= strProdNotifyCateCode;
		data['prodCode']		= prodCode;

		$.ajax({
			url			: "./"
		   ,data		: data
		   ,type		: "POST"
		   ,dataType	: "html"
		   ,success		: function(data) {
				$("#tableProdNotifyCateItem").html("");
				$("#tableProdNotifyCateItem").css("display","");
				$("#tableProdNotifyCateItem").append(data);
			}
		});
	}


	function goOrderEvent(order) {

		var data			= new Object();

		data['order']		= order;

		C_getAddLocationUrl(data);
	}

	//수수료
	function goProdAccPriceCal(e)
	{
		var intProdSalePrice	= $("#prodSalePrice").val();
		var intProdStockPrice	= $("#prodStockPrice").val();

		if (intProdSalePrice > 0 && intProdStockPrice > 0)
		{
			var intProdAccPrice	= (intProdSalePrice - intProdStockPrice);
			var intProdAccRate  = Math.ceil(((intProdSalePrice - intProdStockPrice) / intProdSalePrice) * 100);
			$("#prodAccPrice").val(intProdAccPrice);
			$("#prodAccRate").val(intProdAccRate);
		}
	}

	//소비자가 대비 판매가 할인율
	function goProdDiscountPriceCal(type)
	{
		var intProdConsumerPrice	= $("#prodConsumerPrice").val();
		var intProdSalekPrice		= $("#prodSalePrice").val();
	    var intProdDiscountRate		= $("#prodDiscountRate").val();
		var intProdDiscountPrice	= 0;

		switch(type){
			case "1":
			case "2":
				if (C_isNull(intProdConsumerPrice)) intProdConsumerPrice = 0
				if (intProdConsumerPrice == 0) intProdDiscountRate = 0;
				else{
					intProdDiscountRate		= Math.ceil(((intProdConsumerPrice - intProdSalekPrice) / intProdConsumerPrice) * 100);
				}
				$("#prodDiscountRate").val(intProdDiscountRate);
			break;


			case "3":
				if (C_isNull(intProdConsumerPrice)) intProdConsumerPrice = 0

				intProSalePrice			= Math.ceil(intProdConsumerPrice * (intProdDiscountRate / 100));
				$("#prodSalePrice").val(intProSalePrice);
			break;
		}
	}

	//추가항목타입 선택
	function goProdItemTypeSelect(obj){
		var selectObj = $(obj);
		var parentObj = $(obj).parent();

		parentObj.find("#divProdItemUserType").css("display","none");
		if (selectObj.val() == "U")
		{
			parentObj.find("#divProdItemUserType").css("display","");
		}
	}
//-->
</script>

