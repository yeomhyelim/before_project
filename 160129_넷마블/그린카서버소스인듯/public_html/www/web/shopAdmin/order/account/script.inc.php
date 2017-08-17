<script type="text/javascript">
<!--
	var strInputBoxStyle = " class=\"nbox\" onfocus=\"this.className='sbox'\" onblur=\"this.className='nbox'\"";

	$(document).ready(function(){
		C_CallMenuAuthBtn("<?=$a_admin_no?>","<?=$strTopMenuCode?>","<?=$strLeftMenuCode01?>","<?=$strLeftMenuCode02?>");

		$('input[name=searchRegStartDt]').simpleDatepicker();
		$('input[name=searchRegEndDt]').simpleDatepicker();
		
		$('input[name=searchOrderEndStartDt]').simpleDatepicker();
		$('input[name=searchOrderEndEndDt]').simpleDatepicker();
		
	});
	

	function goMoveUrl(mode,accStatus)
	{
		if (accStatus)
		{
			$("#searchAccStatus").val(accStatus);
		}

		C_getMoveUrl(mode,"get","<?=$PHP_SELF?>");
	}
	/* 주문검색 */
	function goSearch(mode){		
		$("#page").val("");
		$("#searchYN").val("Y");
		C_getMoveUrl(mode,"get","<?=$PHP_SELF?>");
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

	/* 정산상태변경 */
	function goAccStatusUpdate(type)
	{
		var doc = document.form;
		doc.accStatusUpdateType.value = type;
		var strMsg = (type == "P") ? "<?=$LNG_TRANS_CHAR['OS00013']?>" : "<?=$LNG_TRANS_CHAR['OS00019']?>";

		var val = C_getCheckedCode(doc["chkNo[]"]);		
		if(val == ""){
			alert(strMsg); //변경하실 주문정보를 선택 해주세요.
			return;
		} 
		
		if (C_isNull($("#accStatus").val()))
		{
			alert("<?=$LNG_TRANS_CHAR['OS00016']?>"); //변경하실 상태를 선택해주세요.
			return;
		}

		var strMsg = "<?=$LNG_TRANS_CHAR['OS00017']?>"; //정산상태를 변경하시겠습니까?
		var x = confirm(strMsg);
		if (x == true)
		{
			C_getAction("accStatusUpdate","<?=$PHP_SELF?>");	
		}
	}
	
	/* 정산상세보기 */
	function goAccPeriodDetailList(no)
	{
		document.form.shopNo.value = no;
		C_getMoveUrl("accPeriodDetailList","get","<?=$PHP_SELF?>");
	}

	function goAllAccStatusUpdate()
	{
		var strMsg = "<?=$LNG_TRANS_CHAR['OS00020']?>"; //정산상태를 변경하시겠습니까?
		var x = confirm(strMsg);
		if (x == true)
		{
			C_getAction("accPeriodStatusUpdate","<?=$PHP_SELF?>");	
		}
	}

	function goPopClose()
	{		
		$.smartPop.close();
	}

	/* 주문정보 상세보기 */
	function goOrderView(no,shopNo){

		var strUrl = "./?menuType=order&mode=popOrderView&no="+no;
		if (C_isNull(shopNo))
		{
			strUrl += "&comNo="+shopNo;
		}

		$.smartPop.open({  bodyClose: false, width: 800, height: 270, url: strUrl, closeImg: {width:23, height:23, src:'/shopAdmin/himg/common/btn_pop_close.png'} });	
	}

	function goSearchDataSet(data)
	{
		data['searchField']				= $("select[id=searchField]").val();
		data['searchKey']				= $("input[id=searchKey]").val();

		data['searchRegStartDt']		= $("input[id=searchRegStartDt]").val();
		data['searchRegEndDt']			= $("input[id=searchRegEndDt]").val();
		data['searchOrderEndStartDt']	= $("input[id=searchOrderEndStartDt]").val();
		data['searchOrderEndEndDt']		= $("input[id=searchOrderEndEndDt]").val();
		data['searchCompany']			= $("select[id=searchCompany]").val();
		
		$("input:checkbox[id='searchSettleType']:checked").each(function(i) {
			data["searchSettleType["+i+"]"]	= $(this).val();
		});
	
		data['pageLine']				= ($("select[name=pageLine]").val()) ? $("select[name=pageLine]").val() : 50;
		
		return data;
	}

	function goInitMoveUrl(mode,accStatus)
	{
		
		var strUrl					= "./?menuType=order&mode="+mode;
		if (!accStatus)
		{
			accStatus				= "N";
		}		
		strUrl					   += "&searchAccStatus="+accStatus;
		location.href				= strUrl;
				
	}

//-->
</script>