<script type="text/javascript">
<!--

	var strInputBoxStyle = " class=\"nbox\" onfocus=\"this.className='sbox'\" onblur=\"this.className='nbox'\"";

	$(document).ready(function(){
		C_CallMenuAuthBtn("<?=$a_admin_no?>","<?=$strTopMenuCode?>","<?=$strLeftMenuCode01?>","<?=$strLeftMenuCode02?>");

		$('input[name=searchRegStartDt]').simpleDatepicker();
		$('input[name=searchRegEndDt]').simpleDatepicker();
	});

	/* 주문 상품별 배송정보 변경 */
	function goOrderCartDeliveryAllUpdate() {

		if (!confirm("배송정보를 일괄 수정하시겠습니까?")) {
			return;
		}

		var cnt					= $("ul[id^=order_cart_delivery_]").length;
		var aryCnt				= (cnt * 4) + 5;
		var data				= new Array(aryCnt);

		$("ul[id^=order_cart_delivery_]").each(function(i) {
			var strOrderCartDeliveryInfo			= $(this).attr("id").replace("order_cart_delivery_","");
			var arrOrderCartDeliveryInfo			= strOrderCartDeliveryInfo.split("_");
			var intOrderNo							= arrOrderCartDeliveryInfo[0];
			var intOrderCartNo						= arrOrderCartDeliveryInfo[1];
			var strOrderCartDeliveryStatus			= $(this).find('select[name="cartDeliveryStatus"]').val();
			var strOrderCartDeliveryCom				= $(this).find('select[name="cartDeliveryCom"]').val();
			var strOrderCartDeliveryNum				= $(this).find('input[name="cartDeliveryNum"]').val();
			var strOrderCartDeliveryDefaultStatus   = $(this).find('select[name="cartDeliveryStatus"]').attr("default");

			if (strOrderCartDeliveryStatus == "B")
			{
				if (strOrderCartDeliveryDefaultStatus == "I" || strOrderCartDeliveryDefaultStatus == "D")
				{
					alert("선택하신 배송정보 단계는 현재 배송정보 이전단계이므로 변경하실 수 없습니다.");
					strGotoSkip = false;
					return false;
				}
			}

			if (strOrderCartDeliveryStatus == "I")
			{
				if (strOrderCartDeliveryDefaultStatus == "D")
				{
					alert("선택하신 배송정보 단계는 현재 배송정보 이전단계이므로 변경하실 수 없습니다.");
					strGotoSkip = false;
					return false;
				}
			}

			if ((!strOrderCartDeliveryStatus || strOrderCartDeliveryStatus == "B") && strOrderCartDeliveryCom && strOrderCartDeliveryNum)
			{
				strOrderCartDeliveryStatus	= "I";
			}

			data["chkNo["+i+"]"]					= intOrderCartNo;

			data["deliveryStatus_"+intOrderCartNo]	= strOrderCartDeliveryStatus;
			data["deliveryCom_"+intOrderCartNo]		= strOrderCartDeliveryCom;
			data["deliveryNum_"+intOrderCartNo]		= strOrderCartDeliveryNum;
			data["deliveryOrderNo_"+intOrderCartNo]	= intOrderNo;


		});

		data["deliveryMth"]			= "each";
		data['menuType']			= "order";
		data['mode']				= "json";
		data['jsonMode']			= "orderCartDeliverySave";

		C_getJsonAjaxAction("orderCartDeliverySave","./index.php",data);
	}


	/* 상품 구매상태변경 */
	function goOrderStatusUpdate(no)
	{

		var isCheckCnt = 0;
		$("input[name^=chkNo]").each(function(){
			if ($(this).is(":checked")){
				isCheckCnt++;
			}
		});

		if (isCheckCnt == 0)
		{
			alert("구매확정을 하실 상품을 선택해주세요.");
			return;
		}

		var aryCnt				= (isCheckCnt * 10) + 5;
		var data				= new Array(aryCnt);
		var intCnt				= 0;


		$("input[name^=chkNo]").each(function(){
			if ($(this).is(":checked")){
				var intOC_NO						= $(this).val();
				data["chkNo["+intCnt+"]"]			= intOC_NO;
				data["orderStatus_"+intOC_NO]		= "E";
				intCnt++;
			}
		});

		data['menuType']			= "order";
		data['mode']				= "json";
		data['jsonMode']			= "orderCartStatusSave";

		C_getJsonAjaxAction("orderCartStatusSave","./index.php",data);

		return;
	}

	/* ajax return process */
	function goAjaxRet(name,result)
	{
		if (name == "orderCartDeliverySave")
		{
			var data = eval("("+result+")");
			if (data.text)
			{
				alert(data.text);
			}
		}

		if (name == "orderCartStatusSave")
		{
			var data = eval("("+result+")");
			if (data.mode == "__ERROR__")
			{
				alert(data.text);
				return;
			} else if(data.mode == "__SUCCESS__"){
				alert("선택하신 상품이 구매확정되었습니다.");
				return;
			}
		}
	}

	/* crm view call */
	function goMemberCrmView(no) {
		var href = "./?menuType=member&mode=popMemberCrmView&tab=memberOrderList&memberNo="+no;
		window.open(href, "CRM", "width=1100px,height=800px,scrollbars=yes");

	}

	/* 엑셀 다운로드 */
	function goExcel(mode)
	{
		var data				= new Array(50);
		data					= goSearchDataSet(data);
		data['menuType']		= "order";
		data['mode']			= "excel";
		data['act']				= mode;

		C_getSelfAction(data);
	}

	/* 엑셀 업로드 */
	function goExcelUpload()
	{
		$.smartPop.open({  bodyClose: false, width: 500, height: 270, url: './?menuType=order&mode=popExcelFileUpload', closeImg: {width:23, height:23} });
	}
	/* 레이어 창 닫기 */
	function goPopClose()
	{
		$.smartPop.close();
	}


//-->
</script>