<script type="text/javascript">
<!--

	var strInputBoxStyle = " class=\"nbox\" onfocus=\"this.className='sbox'\" onblur=\"this.className='nbox'\"";

	$(document).ready(function(){
		C_CallMenuAuthBtn("<?=$a_admin_no?>","<?=$strTopMenuCode?>","<?=$strLeftMenuCode01?>","<?=$strLeftMenuCode02?>");

		$('input[name=searchRegStartDt]').simpleDatepicker();
		$('input[name=searchRegEndDt]').simpleDatepicker();
	});

	/* 주문리스트 주문정보 펼치기 */
	function goOrderInfoListDisplay(no)
	{
		var strDisplay = $("#divOrderInfo_"+no).css("display");
		strDisplay = (strDisplay == "none") ? "block" : "none";

		var strDisplayText = (strDisplay == "none") ? "<?='상품정보열기'?>" : "<?='상품정보닫기'?>";

		$("#divOrderInfo_"+no).css("display",strDisplay);
		$("#btnOrderDisplay_"+no).text(strDisplayText);
	}

	function goOrderInfoListAllDisplay(state)
	{
		$.getJSON("./?menuType=orderM&mode=json&jsonMode=orderInfoDisplay&state="+state,function(data){
			$("div[id^=divOrderInfo_]").each(function(i) {
				var no				= $(this).attr("id").replace("divOrderInfo_","");
				var strDisplayText	= (state == "none") ? "<?='상품정보열기'?>" : "<?='상품정보닫기'?>";
				$("#divOrderInfo_"+no).css("display",state);
				$("#btnOrderDisplay_"+no).text(strDisplayText);
			});					
		});
	}

	/* [입금확인전] 결제상태변경 */
	function goOrderSettleStatusUpdate(no)
	{
		//결제상태를 [결제완료]로 변경하시겠습니까?
		if (!confirm("<?=$LNG_TRANS_CHAR['OS00028']?>")) {
			return;
		}

		var aryCnt	= (parseInt("<?=$intPageLine?>") * 4) + 5;
		var data	= new Array(aryCnt);
		var intCnt	= 0;

		data		= goSearchDataSet(data);

		if (!no)
		{
			$("input[id^=chkNo]").each(function() {
				if($(this).attr("checked")=="checked") {
					data["chkNo["+intCnt+"]"]	= $(this).val();
					intCnt++;
				}
			});
		} else {
			data["chkNo["+intCnt+"]"]	= no;
			intCnt++;
		}

		if (intCnt == 0)
		{
			alert("<?=$LNG_TRANS_CHAR['OS00013']?>"); //변경하실 주문정보를 선택 해주세요.
			return;
		}

		data['orderSettleStatus']	= "A";
		data['menuType']			= "orderM";
		data['mode']				= "act";
		data['act']					= "orderSettleStatus";
		data['page']				= $("input[name=page]").val();

		C_getSelfAction(data);
	}

	/* 상품 구매상태변경 */
	function goOrderStatusUpdate(no)
	{
//		if (!goOrderStatusSaveAllChk(no))
//		{
//			alert("변경하신 구매상태 데이터가 존재하지 않습니다."); //변경하신 구매상태 데이터가 존재하지 않습니다.
//			return;
//		}
//		
		var intOrderCartCnt		= $("div[id^=order_cart_order_]").length;
		var aryCnt				= (intOrderCartCnt * 10) + 5;
		var data				= new Array(aryCnt);
		var intCnt				= 0;

		if (!no)
		{
			$("div[id^=order_cart_order_]").each(function(i) {
				var intOC_NO					= $(this).attr("id").replace("order_cart_order_","");
				var strCartOrderStatus			= $(this).find("select#cartOrderStatus").val();
				var strDefaultCartOrderStatus	= $(this).find("select").attr("default");

				if (strCartOrderStatus != strDefaultCartOrderStatus) {
					data["chkNo["+intCnt+"]"]			= intOC_NO;
					data["orderStatus_"+intOC_NO]		= strCartOrderStatus;
					intCnt++;
				}
			});
		} else {

			data["chkNo["+intCnt+"]"]		= no;
			data["orderStatus_"+no]			= $("div[id=order_cart_order_"+no+"]").find("select#cartOrderStatus").val();
			intCnt++;
		}

		data['menuType']			= "orderM";
		data['mode']				= "json";
		data['jsonMode']			= "orderCartStatusSave";
		C_getSelfAction(data);
		return;

		var intCount		= 0;
		if (strOrderStatus.substring(0,1) == "C" || strOrderStatus.substring(0,1) == "S" || strOrderStatus.substring(0,1) == "R" || strOrderStatus.substring(0,1) == "T")
		{
			var x = confirm("<?=$LNG_TRANS_CHAR['OS00026']?>"); //구매상태 변경 사유를 입력하시겠습니까?
			if (x == true)
			{
				intCount++;
				$.smartPop.open({  bodyClose: false, width: 500, height: 270, url: './?menuType=order&mode=popOrderStatusMemo&ocNo='+no+'&status='+strOrderStatus, closeImg: {width:23, height:23} });
				return;
			}
		}


	}

	function goOrderStatusSaveAllChk(no)
	{
		var intModifyCnt		= 0;
		
		$("div[id^=order_cart_order_]").each(function(i) {
			var oc_no						= $(this).attr("id").replace("order_cart_order_","");
			var orderStatus					= $(this).find("select#cartOrderStatus").val();
			var defaultOrderStatus			= $(this).find("select").attr("default");
			
			if (orderStatus != defaultOrderStatus) {
				if ((no > 0 && no == oc_no) || C_isNull(no)) {
					intModifyCnt++;
				}
			}
		});

		if (intModifyCnt == 0) return false;
		else return true;
	}

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

			var strOrderCartDeliveryStatus			= $(this).find("select#cartDeliveryStatus").val();
			var strOrderCartDeliveryCom				= $(this).find("select#cartDeliveryCom").val();
			var strOrderCartDeliveryNum				= $(this).find("input#cartDeliveryNum").val();
			var strOrderCartDeliveryDefaultStatus   = $(this).find("select#cartDeliveryStatus").attr("default");
			
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
		data['menuType']			= "orderM";
		data['mode']				= "json";
		data['jsonMode']			= "orderCartDeliverySave";

		C_getSelfAction(data);
		//C_getJsonAjaxAction("orderCartDeliverySave","./index.php",data);

	}
	
	
	function goOrderCartDeliveryUpdate(oNo,ocNo,shopNo)
	{
		var intOrderCartCnt		= $("ul[id^=order_cart_delivery_"+oNo+"_]").length;
		var aryCnt				= (intOrderCartCnt * 10) + 5;
		var data				= new Array(aryCnt);
		var intCnt				= 0;
		
		if (!ocNo)
		{
			/* 전체배송정보변경 */
			var strJsonParam = "menuType=orderM&mode=json&jsonMode=orderCartNoSelect&oNo="+oNo+"&shopNo="+shopNo;
			$.getJSON("./?"+strJsonParam,function(data){
				
				for(var j=0;j<data.length;j++){
					
					if (j > 0) break;
					var strGotoSkip	= true;
					$("ul[id^=order_cart_delivery_"+oNo+"_"+data[j].OC_NO+"]").each(function(i) 
					{
						var strOrderCartDeliveryStatus	= $(this).find("select#cartDeliveryStatus").val();
						var strOrderCartDeliveryCom		= $(this).find("select#cartDeliveryCom").val();
						var strOrderCartDeliveryNum		= $(this).find("input#cartDeliveryNum").val();
						var strOrderCartDeliveryDefaultStatus   = $(this).find("select#cartDeliveryStatus").attr("default");
					
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

						data["deliveryStatus"]			= strOrderCartDeliveryStatus;
						data["deliveryCom"]				= strOrderCartDeliveryCom;
						data["deliveryNum"]				= strOrderCartDeliveryNum;
					});
				}

				if (!strGotoSkip)
				{
					return;
				}

				data["deliveryMth"] = "all";
				data["oNo"]			= oNo;
				data["shopNo"]		= shopNo;
				
				data['menuType']	= "orderM";
				data['mode']		= "json";
				data['jsonMode']	= "orderCartDeliverySave";
				
				C_getJsonAjaxAction("orderCartDeliverySave","./index.php",data);
		
			});

		} else {

			data["deliveryMth"]			= "each";
			data["oNo"]					= oNo;
			data["shopNo"]				= shopNo;
			data["cartNo"]				= ocNo;
					
			data["chkNo["+intCnt+"]"]	= ocNo;			
			var strGotoSkip				= true;
			$("ul[id^=order_cart_delivery_"+oNo+"_"+ocNo+"]").each(function(i) 
			{
				var strOrderCartDeliveryStatus			= $(this).find("select#cartDeliveryStatus").val();
				var strOrderCartDeliveryCom				= $(this).find("select#cartDeliveryCom").val();
				var strOrderCartDeliveryNum				= $(this).find("input#cartDeliveryNum").val();
				var strOrderCartDeliveryDefaultStatus   = $(this).find("select#cartDeliveryStatus").attr("default");

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

				data["deliveryStatus_"+ocNo]			= strOrderCartDeliveryStatus;
				data["deliveryCom_"+ocNo]				= strOrderCartDeliveryCom;
				data["deliveryNum_"+ocNo]				= strOrderCartDeliveryNum;
				data["deliveryOrderNo_"+ocNo]			= oNo;

			});
			
			if (!strGotoSkip)
			{
				return;
			}
			intCnt++;
		
			data['menuType']			= "orderM";
			data['mode']				= "json";
			data['jsonMode']			= "orderCartDeliverySave";
			
			C_getSelfAction(data);
			C_getJsonAjaxAction("orderCartDeliverySave","./index.php",data);
		}

	}
	
	/* ajax return process */
	function goAjaxRet(name,result)
	{
		if (name == "orderCartDeliverySave")
		{
			var data = eval("("+result+")");
			if (data.mode == "__ERROR__")
			{
				alert(data.text);
				return;
			} else if(data.mode == "__SUCCESS__"){
				alert("배송정보가 변경되었습니다.");
				return;
			}
		}
	}
	
	/* crm view call */
	function goMemberCrmView(no) {
		var href = "./?menuType=member&mode=popMemberCrmView&tab=memberOrderList&memberNo="+no;
		window.open(href, "CRM", "width=1100px,height=800px,scrollbars=yes");

	}
	
	/* 내역관리 call */
	function goOrderHistory(no)
	{
		$.smartPop.open({  bodyClose: false, width: 800, height: 270, url: './?menuType=orderM&mode=popOrderHistoryList&no='+no, closeImg: {width:23, height:23} });
	}

	/* 부분 취소 팝업창 오픈 */
	function goOrderPartCancel(no,cartNo)
	{
		$.smartPop.open({  bodyClose: false, width: 800, height: 270, url: './?menuType=orderM&mode=popOrderPartCancel&no='+no+"&cartNo="+cartNo, closeImg: {width:23, height:23} });
	}

	/* 배송정보(주소) 수정 */
	function goOrderDeliveryAddr(no)
	{
		$.smartPop.open({  bodyClose: false, width: 500, height: 270, url: './?menuType=orderM&mode=popOrderDeliveryAddr&no='+no, closeImg: {width:23, height:23} });
	}

	/* 주문정보 엑셀 다운로드 */
	function goExcel(mode)
	{
		var data				= new Array(50);
		data['menuType']		= "orderM";
		data['mode']			= "excel";
		data['act']				= mode;

		C_getSelfAction(data);
	}

	/* 주문취소 입력 */
	function goOrderCancel(no){
		$.smartPop.open({  bodyClose: false, width: 500, height: 270, url: './?menuType=order&mode=popOrderCancel&no='+no, closeImg: {width:23, height:23} });
	}

	/* 주문 취소 상태 update */
	function goOrderCancelOff(no,pg)
	{
		if (pg == "Y" || pg == "X")
		{
			$.smartPop.open({  bodyClose: false, width: 500, height: 270, url: './?menuType=order&mode=popOrderCancel&no='+no, closeImg: {width:23, height:23} });
		} else {
			$.smartPop.open({  bodyClose: false, width: 500, height: 270, url: './?menuType=order&mode=popOrderCancelInfo&no='+no, closeImg: {width:23, height:23} });

			/*var strMsg = "<?=$LNG_TRANS_CHAR['OS00004']?>"; //주문취소처리를 완료하시겠습니까?
			var x = confirm(strMsg);
			if (x == true)
			{
				document.form.oNo.value = no;
				C_getAction("orderCancelUpdate","<?=$PHP_SELF?>");
			}*/
		}
	}


	//--------------------------------------------
	function goOrderStatusSaveAllAct() {

		if (!confirm("구매상태를 일괄 수정하시겠습니까?")) {
			return false;
		}

		var cnt					= $("tr[id^=shop_order]").length;
		var aryCnt				= (cnt * 1) + 5;
		var data				= new Array(aryCnt);
		$("tr[id^=shop_order]").each(function(i) {
			var so_no						= $(this).attr("id").replace("shop_order_","");
			var orderStatus					= $(this).find("select#orderStatus").val();
			data["chkNo["+i+"]"]			= so_no;
			data["orderStatus_"+so_no]		= orderStatus;
		});

		data['menuType']			= "seller";
		data['mode']				= "act";
		data['act']					= "orderStatusSave";
		data['page']				= $("input[name=page]").val();
		C_getSelfAction(data);

	}



	function goSettleSaveAllAct() {

		if (!confirm("결제상태를 일괄 수정하시겠습니까?")) {
			return false;
		}

		var cnt					= $("tr[id^=order]").length;
		var aryCnt				= (cnt * 2) + 5;
		var data				= new Array(aryCnt);
		$("tr[id^=order]").each(function(i) {
			var o_no					= $(this).attr("id").replace("order_","");
			var settleStatus			= $(this).find("select#settleStatus").val();
			data["chkNo["+i+"]"]		= o_no;
			data["orderStatus_"+o_no]	= settleStatus;
		});

		data['menuType']			= "order";
		data['mode']				= "act";
		data['act']					= "orderStatus";
		data['page']				= $("input[name=page]").val();

		C_getSelfAction(data);
	}

	function goSettleSaveAct(o_no) {

		var data			= new Array(5);
		var code			= $("tr#order_"+o_no);
		var settleStatus	= $(code).find("select#settleStatus").val();

		data['menuType']			= "order";
		data['mode']				= "act";
		data['act']					= "orderStatus";
		data['oNo']					= o_no;
		data['orderStatus_'+o_no]	= settleStatus;

		C_getSelfAction(data);

// 2013.06.24 kim hee sung - 미완성...
//		var code			= $("tr#order_"+o_no);
//		var settleStatus	= $(code).find("select#settleStatus").val();
//		var url				= "./?menuType=order&mode=json&jsonMode=settleSave&o_no="+o_no+"&settleStatus="+settleStatus;
//		$.getJSON(url,function(data){
//			try {
//				switch(data['mode']){
//					case "__ERROR__":
//						alert(data['text']);
//					break;
//					case "__SUCCESS__":
//						alert(data['text']);
//					break;
//				}
//			} catch(e) {
//				console.log("system error");
//			} finally {
//			}
//		});
	}
	function goOrderStatusSaveAct(so_no) {
		var code			= $("tr#shop_order_"+so_no);
		var orderStatus		= $(code).find("select#orderStatus").val();
		var url				= "./?menuType=seller&mode=json&jsonMode=orderStatusSave&so_no="+so_no+"&orderStatus="+orderStatus;
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

	function goDeliverySaveAct(so_no) {
		var code			= $("tr#shop_order_"+so_no);
		var deliveryCom		= $(code).find("select#deliveryCom").val();
		var deliveryNum		= $(code).find("input#deliveryNum").val();
		var deliveryStatus	= $(code).find("select#deliveryStatus").val();
		var url				= "./?menuType=seller&mode=json&jsonMode=deliverySave&so_no="+so_no+"&deliveryCom="+deliveryCom+"&deliveryNum="+deliveryNum+
							  "&deliveryStatus="+deliveryStatus;

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


	/* 배송정보 입력 */
	function goOrderDeliveryUpdate(no)
	{
		//C_openWindow("./?menuType=popup&mode=orderDeliveryInput&no="+no,"<?=$LNG_TRANS_CHAR['OW00044']?>","500","300"); //배송정보입력
		$.smartPop.open({  bodyClose: false, width: 500, height: 270, url: './?menuType=order&mode=popOrderDeliveryInput&no='+no, closeImg: {width:23, height:23} });
	}




	/* 주문정보 상세보기 */
	function goOrderView(no){

		//C_openWindow("./?menuType=popup&mode=orderView&no="+no,"<?=$LNG_TRANS_CHAR['OW00012']?>","600","600"); //주문정보 T상세보기
		$.smartPop.open({  bodyClose: false, width: 800, height: 270, url: './?menuType=orderM&mode=popOrderView&no='+no, closeImg: {width:23, height:23} });
	}



	/* 주문 상태 변경 */
	function goOrderStatusOneUpdate(no)
	{
		var strMsg = "주문상태를 변경하시겠습니까?";
		var x = confirm(strMsg);
		if (x == true)
		{
			document.form.oNo.value = no;
			C_getAction("orderStatus","<?=$PHP_SELF?>");
		}
	}



	function goPopClose()
	{
		$.smartPop.close();
	}

	function goOrderDelete(no){
		var strMsg = "주문을 삭제하시겠습니까?";
		var x = confirm(strMsg);
		if (x == true)
		{
			document.form.oNo.value = no;
			C_getAction("orderDelete","<?=$PHP_SELF?>");
		}
	}

	function goOrderCeritySaveActEvent(no){

		var url				= "./?menuType=order&mode=json&jsonMode=ceritySave&ocNo="+no;

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

	function goOrderReturnEvent(no)
	{
		$.smartPop.open({  bodyClose: false, width: 800, height: 270, url: './?menuType=order&mode=popOrderReturn&no='+no, closeImg: {width:23, height:23} });
	}

//-->
</script>