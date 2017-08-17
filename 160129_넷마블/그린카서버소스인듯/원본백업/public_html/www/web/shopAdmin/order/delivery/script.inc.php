<script type="text/javascript">
<!--
	var strInputBoxStyle = " class=\"nbox\" onfocus=\"this.className='sbox'\" onblur=\"this.className='nbox'\"";

	$(document).ready(function(){
		C_CallMenuAuthBtn("<?=$a_admin_no?>","<?=$strTopMenuCode?>","<?=$strLeftMenuCode01?>","<?=$strLeftMenuCode02?>");

		$('input[name=searchRegStartDt]').simpleDatepicker();
		$('input[name=searchRegEndDt]').simpleDatepicker();
		
		
	});

	/* 주문검색 */
	function goSearch(){
		C_getMoveUrl("<?=$strMode?>","get","<?=$PHP_SELF?>");
	}

	/* 주문정보 상세보기 */
	function goOrderView(no){

		$.smartPop.open({  bodyClose: false, width: 800, height: 270, url: './?menuType=order&mode=popOrderView&no='+no, closeImg: {width:23, height:23} });	
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

	function goPopClose()
	{		
		$.smartPop.close();
	}

	/* 배송정보 일괄변경 */
	function goOrderDeliveryUpdate()
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
			C_getAction("orderDeliveryUpdate","<?=$PHP_SELF?>");	
		}
	}

	/* 배송정보 엑셀 업로드 변경 */
	function goOrderDelvieryExcelUpdate()
	{
		$.smartPop.open({  bodyClose: false, width: 500, height: 150, url: './?menuType=order&mode=popOrderDelvieryExcelUpload', closeImg: {width:23, height:23} });	
	}

	/* 주문상태변경 */
	function goOrderStatusUpdate()
	{
		if (C_isNull($("#orderDeliveryStatus").val()))
		{
			alert("<?=$LNG_TRANS_CHAR['OS00016']?>"); //변경하실 상태를 선택해주세요.
			return;
		}

		C_getMultiCheck("orderDeliveryStatusUpdate","<?=$PHP_SELF?>");
	}

//-->
</script>