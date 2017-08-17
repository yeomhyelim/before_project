<script type="text/javascript">
<!--
	var strInputBoxStyle = " class=\"nbox\" onfocus=\"this.className='sbox'\" onblur=\"this.className='nbox'\"";
	var productCate = new Array(4);

	$(document).ready(function(){
		C_CallMenuAuthBtn("<?=$a_admin_no?>","<?=$strTopMenuCode?>","<?=$strLeftMenuCode01?>","<?=$strLeftMenuCode02?>");

	});
	
	function goOpenWindow(pcode) 
	{
		var strParam = "../?menuType=product&mode=view&act=list&prodCode=" + pcode;
		C_openWindow( strParam, "<?=$LNG_TRANS_CHAR['PW00001']?>", 1024, 768);
	}

	/* 선택수정 항목설정(v2.0)*/
	function goProdStockUpdate()
	{
		var strChkVal	= C_getCheckedCode(document.form["chkNo[]"]);
		if (C_isNull(strChkVal))
		{
			alert("<?=$LNG_TRANS_CHAR['CS00017']?>"); //데이터를 선택해주세요.
			return;
		}
				
		$.smartPop.open({  bodyClose: false, width: 550, height: 150, url: './?menuType=product&mode=popProdStockUpdate', closeImg: {width:23, height:23, src:'/shopAdmin/himg/common/btn_pop_close.png'} });
	}
	
	function goProdStockUpdateAct(stockStatus,viewStatus){
		var intCnt	= 0;
		var data	= new Array(10);
		$("input[id^=chkNo]").each(function() {
			if($(this).attr("checked")=="checked") {
				var strProdCode				= $(this).val();
				data["chkNo["+intCnt+"]"]	= strProdCode;
				intCnt++;
			}
		});

		data['stockStatus']			= stockStatus;
		data['viewStatus']			= viewStatus;
		data['menuType']			= "product";
		data['mode']				= "json";
		data['jsonMode']			= "choiceStockStatusUpdateVersion2.0";
		data['page']				= $("input[name=page]").val();

		C_getJsonAjaxAction("choiceStockStatusUpdateVersion2.0","./index.php",data);
	}
	
	function goAjaxRet(name,result){

		if (name == "choiceStockStatusUpdateVersion2.0")
		{			
			var doc = document.form;
			var data = eval(result);
			if (data[0].RET == "Y")
			{
				location.reload();
				return;
			}
		}
	}

	/* 선택없이 클릭으로 입력한 재고수량 변경 */
	function goAutoStockUpdate()
	{
		var x = confirm("<?=$LNG_TRANS_CHAR['PS00047']?>"); //변경된 재고수량을 변경하시겠습니까?
		if (x == true)
		{
			C_getCheckAll(true);
			C_getAction("autoStockUpdate","<?=$PHP_SELF?>");
		}
	}

	/* 선택없이 클릭으로 입력한 출력정보 변경 */
	function goAutoViewUpdate()
	{
		var x = confirm("<?=$LNG_TRANS_CHAR['PS00048']?>"); //변경된 상품출력정보를 변경하시겠습니까?
		if (x == true)
		{
			C_getCheckAll(true);
			C_getAction("autoViewUpdate","<?=$PHP_SELF?>");
		}
	}

	/* 일시/품절관리 옵션재고설정 */
	function goProdOptStock(no)
	{
		$.smartPop.open({  bodyClose: false, width: 550, height: 500, url: './?menuType=product&mode=popProdOptStock&prodCode='+no, closeImg: {width:23, height:23, src:'/shopAdmin/himg/common/btn_pop_close.png'} });
	}

	function goPopClose()
	{		
		$.smartPop.close();
	}
	


	function goStockClick(no,code)
	{
		if ($("#prodStock"+no+"_"+code).is(":checked"))
		{
			$("#prodQty_"+code).val(0);
		} else {
			
			var strJsonParam = "menuType=<?=$strMenuType?>&mode=json&jsonMode=stockTotQty&prodCode="+code;
			$.ajax({				
				type:"POST",
				url:"./index.php",
				data :strJsonParam,
				dataType:"json", 
				success:function(data){	
					$("#prodQty_"+code).val(data[0].QTY);
				}
			});
		}
	}

	/* 옵션재고팝업창에 총 변경된 수량 받기 */
	function goStockOptTotQtySet(code,qty){
		$("#prodQty_"+code).val(qty);
	}

	function goStockStatusChoick()
	{
		var strStockStatus = $("#stockStatus option:selected").val();
		
		if (C_isNull(strStockStatus))
		{
			alert("변경하실 재고상태를 선택해주세요.");
			return;
		}

		var doc			= document.form;		
		var strChkVal	= C_getCheckedCode(doc["chkNo[]"]);

		if (C_isNull(strChkVal))
		{
			alert("<?=$LNG_TRANS_CHAR['CS00017']?>"); //데이터를 선택해주세요.
			return;
		}


		C_getAction("choiceStockStatusUpdate","<?=$PHP_SELF?>");
	}

	function goStockStatusAll()
	{
		
		var strStockStatus = $("#stockStatus option:selected").val();
		
		if (C_isNull(strStockStatus))
		{
			alert("변경하실 재고상태를 선택해주세요.");
			return;
		}

		var x = confirm("검색된 전체 상품 재고 상태를 변경하시겠습니까?");
		if (x == true)
		{
			C_getAction("allStockStatusUpdate","<?=$PHP_SELF?>");
		}
	}

	function goViewStatusChoick()
	{
		var strViewStatus = $("#viewStatus option:selected").val();
		
		if (C_isNull(strViewStatus))
		{
			alert("변경하실 출력상태를 선택해주세요.");
			return;
		}

		var doc			= document.form;		
		var strChkVal	= C_getCheckedCode(doc["chkNo[]"]);

		if (C_isNull(strChkVal))
		{
			alert("<?=$LNG_TRANS_CHAR['CS00017']?>"); //데이터를 선택해주세요.
			return;
		}


		C_getAction("choiceStockViewStatusUpdate","<?=$PHP_SELF?>");
	}
//-->
</script>