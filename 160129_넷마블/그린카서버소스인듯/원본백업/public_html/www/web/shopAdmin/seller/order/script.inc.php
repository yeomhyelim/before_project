<script type="text/javascript">
<!--

	function goOrderSaveActEvent(so_no) { goOrderSaveAct(so_no); }

	
	var strInputBoxStyle = " class=\"nbox\" onfocus=\"this.className='sbox'\" onblur=\"this.className='nbox'\"";

	$(document).ready(function(){
		C_CallMenuAuthBtn("<?=$a_admin_no?>","<?=$strTopMenuCode?>","<?=$strLeftMenuCode01?>","<?=$strLeftMenuCode02?>");
		
		$('input[name=searchRegStartDt]').simpleDatepicker();
		$('input[name=searchRegEndDt]').simpleDatepicker();

	});

	function goOrderSaveAct(so_no) {
		var code			= $("tr#order_"+so_no);
		var deliverCom		= $(code).find("input#deliverCom").val();
		var deliveryNum		= $(code).find("input#deliveryNum").val();
		var deliveryStatus	= $(code).find("select[id^=deliveryStatus]").val();
		var orderStatus		= $(code).find("select[id^=orderStatus]").val();
		var url				= "./?menuType=seller&mode=json&jsonMode=orderSave&so_no="+so_no+"&deliverCom="+deliverCom+"&deliveryNum="+deliveryNum+"&deliveryStatus="+deliveryStatus+"&orderStatus="+orderStatus;

		$.getJSON(url,function(data){	
			try {
				switch(data['mode']){
					case "__ERROR__":
						alert(data['text']);
					break;
					case "__SUCCESS__":
						alert(data['text']);
					break;
				}
			} catch(e) {
				console.log("system error");
			} finally {
			}
		});
	}

	function goSearch(mode)
	{
		C_getMoveUrl(mode,"get","<?=$PHP_SELF?>"); 
	}

	function goMoveUrl(mode,no)
	{
		if (!C_isNull(no))
		{
			
			if (mode == "shopUserModify")
			{
				document.form.shopUserNo.value = no;	
			} else {
				document.form.shopNo.value = no;
			}
			
		}
		C_getMoveUrl(mode,"get","<?=$PHP_SELF?>"); 
	}
	
	/* 배송정보 일괄변경 */
	function goDeliveryUpdate()
	{
		var val = C_getCheckedCode(document.form["chkNo[]"]);
			
		if(val == ""){
			alert("<?=$LNG_TRANS_CHAR['OS00013']?>"); //변경하실 주문정보를 선택 해주세요.
			return;
		} 

		var strMsg = "<?=$LNG_TRANS_CHAR['OS00014']?>"; //배송정보를 변경하시겠습니까?
		var x = confirm(strMsg);
		if (x == true)
		{
			C_getAction("deliveryUpdate","<?=$PHP_SELF?>");	
		}
	}

	/* 배송상태변경 */
	function goDeliveryStatusUpdate()
	{
		if (C_isNull($("#deliveryStatus").val()))
		{
			alert("<?=$LNG_TRANS_CHAR['SS00003']?>"); //변경하실 배송상태를 선택해주세요.
			return;
		}
		
		var x = confirm("<?=$LNG_TRANS_CHAR['SS00004']?>"); //목록에 있는 배송정보가 선태하신 배송상태로 변경됩니다. 진행하시겠습니까?
		if (x == true)
		{
			C_getCheckAll(true);
			C_getMultiCheck("deliveryStatusUpdate","<?=$PHP_SELF?>");
		}
	}
		
	function goOrderStatusUpdate()
	{
		if (C_isNull($("#orderStatus").val()))
		{
			alert("<?=$LNG_TRANS_CHAR['SS00005']?>"); //변경하실 구매상태를 선택해주세요.
			return;
		}
		
		var x = confirm("<?=$LNG_TRANS_CHAR['SS00006']?>"); //목록에 있는 구매정보가 선태하신 구매상태로 변경됩니다. 진행하시겠습니까?
		if (x == true)
		{
			C_getCheckAll(true);
			C_getMultiCheck("orderStatusUpdate","<?=$PHP_SELF?>");
		}
	}
	
	function goOrderUpdate()
	{
		var val = C_getCheckedCode(document.form["chkNo[]"]);
			
		if(val == ""){
			alert("<?=$LNG_TRANS_CHAR['OS00013']?>"); //변경하실 주문정보를 선택 해주세요.
			return;
		} 

		var strMsg = "<?=$LNG_TRANS_CHAR['SS00007']?>"; //구매정보를 변경하시겠습니까?
		var x = confirm(strMsg);
		if (x == true)
		{
			C_getAction("orderUpdate","<?=$PHP_SELF?>");	
		}
	}

	/* 주문정보 엑셀 다운로드 */
	function goExcel(mode)
	{
		var doc = document.form;
		doc.mode.value = "excel";
		doc.act.value = mode;
		doc.method = "get";
		doc.action = "<?=$PHP_SELF?>";
		doc.submit();
	}

	function goOrderView(no,comNo){

		$.smartPop.open({  bodyClose: false, width: 800, height: 270, url: './?menuType=order&mode=popOrderView&no='+no+"&comNo="+comNo, closeImg: {width:23, height:23, src:'/shopAdmin/himg/common/btn_pop_close.png'} });
	}

	function goPopClose()
	{		
		$.smartPop.close();
	}
//-->
</script>