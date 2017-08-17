<script type="text/javascript">
<!--
	function goDeliverySaveActEvent(so_no)		{ goDeliverySaveAct(so_no);		}
	function goSettleSaveActEvent(o_no)			{ goSettleSaveAct(o_no);		}
	function goOrderStatusSaveActEvent(so_no)	{ goOrderStatusSaveAct(so_no);	}
	function goSettleSaveAllActEvent()			{ goSettleSaveAllAct();			}
	function goDeliverySaveAllActEvent()		{ goDeliverySaveAllAct();		}
	function goOrderStatusSaveAllActEvent()		{ goOrderStatusSaveAllMsgMove();	}


	var strInputBoxStyle = " class=\"nbox\" onfocus=\"this.className='sbox'\" onblur=\"this.className='nbox'\"";

	$(document).ready(function(){
		C_CallMenuAuthBtn("<?=$a_admin_no?>","<?=$strTopMenuCode?>","<?=$strLeftMenuCode01?>","<?=$strLeftMenuCode02?>");

		$('input[name=searchRegStartDt]').simpleDatepicker();
		$('input[name=searchRegEndDt]').simpleDatepicker();
	});

	function goOrderStatusSaveAllChk()
	{
		var intModifyCnt		= 0;

		$("div[id^=shop_order_cart_]").each(function(i) {
			var oc_no						= $(this).attr("id").replace("shop_order_cart_","");
			var orderStatus					= $(this).find("select#orderStatus").val();
			var defaultOrderStatus			= $(this).find("select").attr("default");			
			
			if (orderStatus != defaultOrderStatus) {
				intModifyCnt++;
			}
		});	
		
		if (intModifyCnt == 0) return false;
		else return true;
	}	

	function goOrderStatusSaveAllMsgMove()
	{
		if (!goOrderStatusSaveAllChk())
		{
			alert("변경된 데이터가 존재하지 않습니다.");
			return;
		}
		
		$.smartPop.open({  bodyClose: false, width: 500, height: 270, url: './?menuType=order&mode=popOrderStatusMemo&gb=all', closeImg: {width:23, height:23} });
	}

	function goOrderStatusSaveAllAct() {
		
		if (!goOrderStatusSaveAllChk())
		{
			alert("변경된 데이터가 존재하지 않습니다.");
			return;
		}
		
		var cnt					= $("div[id^=shop_order_cart_]").length;
		var aryCnt				= (cnt * 1) + 5;
		var data				= new Array(aryCnt);
		var intModifyCnt		= 0;

		$("div[id^=shop_order_cart_]").each(function(i) {
			var oc_no						= $(this).attr("id").replace("shop_order_cart_","");
			var orderStatus					= $(this).find("select#orderStatus").val();
			var defaultOrderStatus			= $(this).find("select").attr("default");			
			
			if (orderStatus != defaultOrderStatus) {
				data["chkNo["+i+"]"]			= oc_no;
				data["orderStatus_"+oc_no]		= orderStatus;
				intModifyCnt++;
			}
		});	
		
		data['menuType']			= "order";
		data['mode']				= "act";
		data['act']					= "orderStatusSave"; 
		data['page']				= $("input[name=page]").val();
		data['orderStatysMemo']		= $("#orderStatysMemo").val();
		C_getSelfAction(data);
	}
	
	function goDeliverySaveAllAct() {

		if (!confirm("배송정보를 일괄 수정하시겠습니까?")) {
			return false;
		}

		var cnt					= $("tr[id^=shop_order]").length;
		var aryCnt				= (cnt * 4) + 5;
		var data				= new Array(aryCnt);
		$("tr[id^=shop_order]").each(function(i) {
			var so_no						= $(this).attr("id").replace("shop_order_","");
			var deliveryStatus				= $(this).find("select#deliveryStatus").val();
			var deliveryCom					= $(this).find("select#deliveryCom").val();
			var deliveryNum					= $(this).find("input#deliveryNum").val();
			data["chkNo["+i+"]"]			= so_no;
			data["deliveryStatus_"+so_no]	= deliveryStatus;
			data["deliveryCom_"+so_no]		= deliveryCom;
			data["deliveryNum_"+so_no]		= deliveryNum;
		});	

		data['menuType']			= "order";
		data['mode']				= "act";
		data['act']					= "deliverySave"; 
		
		data['page']					= $("input[name=page]").val();
		data['searchField']				= $("select#searchField").val();
		data['searchKey']				= $("input#searchKey").val();
		data['searchMemberType']		= $("input#searchMemberType:checked").val();
		data['searchDeliveryStatus']	= $("select#searchDeliveryStatus").val();
		data['searchDeliveryCom']		= $("select#searchDeliveryCom").val();
		data['searchRegStartDt']		= $("input#searchRegStartDt").val();
		data['searchRegEndDt']			= $("input#searchRegEndDt").val();

		var searchSettleType			= "";
		$("input#searchSettleType:checked").each(function() {
			if(searchSettleType)		{ searchSettleType = searchSettleType + ","; }
			searchSettleType			= searchSettleType + $(this).val();
		});
		data['searchSettleType']		= searchSettleType;
		data['searchOrderStatus']		= $("input#searchOrderStatus").val();
		
		<?if ($S_FIX_MEMBER_CATE_USE_YN  == "Y"){?>
		data['searchNation']			= $("select#searchNation").val();
		data['searchCate1']				= $("select#searchCate1").val();
		data['searchCate2']				= $("select#searchCate2").val();
		data['searchCate3']				= $("select#searchCate3").val();
		data['searchCate4']				= $("select#searchCate4").val();
		<?}?>

		C_getSelfAction(data);
	}

	function goSettleSaveAllAct() {
		
		if (!confirm("주문상태를 일괄 수정하시겠습니까?")) {
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

		data['menuType']				= "order";
		data['mode']					= "act";
		data['act']						= "orderStatus"; 
		
		data['page']					= $("input[name=page]").val();
		data['searchField']				= $("select#searchField").val();
		data['searchKey']				= $("input#searchKey").val();
		data['searchMemberType']		= $("input#searchMemberType:checked").val();
		data['searchDeliveryStatus']	= $("select#searchDeliveryStatus").val();
		data['searchDeliveryCom']		= $("select#searchDeliveryCom").val();
		data['searchRegStartDt']		= $("input#searchRegStartDt").val();
		data['searchRegEndDt']			= $("input#searchRegEndDt").val();

		var searchSettleType			= "";
		$("input#searchSettleType:checked").each(function() {
			if(searchSettleType)		{ searchSettleType = searchSettleType + ","; }
			searchSettleType			= searchSettleType + $(this).val();
		});
		data['searchSettleType']		= searchSettleType;
		data['searchOrderStatus']		= $("input#searchOrderStatus").val();
		
		<?if ($S_FIX_MEMBER_CATE_USE_YN  == "Y"){?>
		data['searchNation']			= $("select#searchNation").val();
		data['searchCate1']				= $("select#searchCate1").val();
		data['searchCate2']				= $("select#searchCate2").val();
		data['searchCate3']				= $("select#searchCate3").val();
		data['searchCate4']				= $("select#searchCate4").val();
		<?}?>
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


	function goOrderStatusSaveAct(oc_no) {
		var code			= $("div#shop_order_cart_"+oc_no);
		var orderStatus		= $(code).find("select#orderStatus").val();
		var url				= "./?menuType=order&mode=json&jsonMode=orderStatusSave&oc_no="+oc_no+"&orderStatus="+orderStatus;
		
		var intCount		= 0;
		
		if (orderStatus.substring(0,1) == "C" || orderStatus.substring(0,1) == "S" || orderStatus.substring(0,1) == "R" || orderStatus.substring(0,1) == "T")
		{
			var x = confirm("구매상태 변경 사유를 입력하시겠습니까?");
			if (x == true)
			{
				intCount++;
				$.smartPop.open({  bodyClose: false, width: 500, height: 270, url: './?menuType=order&mode=popOrderStatusMemo&ocNo='+oc_no+'&status='+orderStatus, closeImg: {width:23, height:23} });
				return;
			}
		}

		if (intCount == 0)
		{
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
	}

	function goDeliverySaveAct(so_no) {
		var code			= $("tr#shop_order_"+so_no);
		var deliveryCom		= $(code).find("select#deliveryCom").val();
		var deliveryNum		= $(code).find("input#deliveryNum").val();
		var deliveryStatus	= $(code).find("select#deliveryStatus").val();
		var url				= "./?menuType=order&mode=json&jsonMode=deliverySave&so_no="+so_no+"&deliveryCom="+deliveryCom+"&deliveryNum="+deliveryNum+
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

	/* 주문상태변경 */
	function goOrderStatusUpdate()
	{
		C_getMultiCheck("orderStatus","<?=$PHP_SELF?>");
	}
	
	/* 배송정보 입력 */
	function goOrderDeliveryUpdate(no)
	{
		//C_openWindow("./?menuType=popup&mode=orderDeliveryInput&no="+no,"<?=$LNG_TRANS_CHAR['OW00044']?>","500","300"); //배송정보입력
		$.smartPop.open({  bodyClose: false, width: 500, height: 270, url: './?menuType=order&mode=popOrderDeliveryInput&no='+no, closeImg: {width:23, height:23} });
	}

	/* 주문취소 입력 */
	function goOrderCancel(no){

		//C_openWindow("./?menuType=order&mode=popOrderCancel&no="+no,"<?=$LNG_TRANS_CHAR['OW00049']?>","500","300"); //주문취소
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

	/* 주문검색 */
	function goSearch(){
		if(C_dataEmptyCheck()){ return false; }
		var data						= new Array(5);
		data['page']					= "1";
		data['searchField']				= $("select#searchField").val();
		data['searchKey']				= $("input#searchKey").val();
		data['searchMemberType']		= $("input#searchMemberType:checked").val();
		data['searchDeliveryStatus']	= $("select#searchDeliveryStatus").val();
		data['searchDeliveryCom']		= $("select#searchDeliveryCom").val();
		data['searchRegStartDt']		= $("input#searchRegStartDt").val();
		data['searchRegEndDt']			= $("input#searchRegEndDt").val();

		var searchSettleType			= "";
		$("input#searchSettleType:checked").each(function() {
			if(searchSettleType)		{ searchSettleType = searchSettleType + ","; }
			searchSettleType			= searchSettleType + $(this).val();
		});
		data['searchSettleType']		= searchSettleType;

		C_getAddLocationUrl(data);
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

	/* 결제상태변경 */
	function goOrderSettleStatusUpdate(no)
	{
		var doc = document.form;		

		if (no == 0)
		{
			var val = C_getCheckedCode(doc["chkNo[]"]);
			
			if(val == ""){
				alert("변경하실 주문정보를 선택 해주세요.");
				return;
			} 
		}

		var strMsg = "결제상태를 [결제완료]로 변경하시겠습니까?";
		var x = confirm(strMsg);
		if (x == true)
		{
			if (no > 0)
			{
				document.form.oNo.value = no;
				$("#orderStatus_"+no).val("A");

			} else {
				for(var i=0;i<doc["chkNo[]"].length;i++){
					$("#orderStatus_"+doc["chkNo[]"][i]).val("A");
				}
			}
			
			C_getAction("orderStatus","<?=$PHP_SELF?>");	
		}
	}

	function goPopClose(reload)
	{		
		if (reload == "Y")
		{
			location.reload();
		} else {
			$.smartPop.close();
		}
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
	
	/* 삭제 예정 함수 */
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

	function goOrderHistory(no)
	{
		$.smartPop.open({  bodyClose: false, width: 800, height: 270, url: './?menuType=order&mode=popOrderHistoryList&no='+no, closeImg: {width:23, height:23} });
	}
	


	/* 부분 취소 */
	function goOrderPartCancelEvent(no)
	{
		$.smartPop.open({  bodyClose: false, width: 800, height: 270, url: './?menuType=order&mode=popOrderPartCancel&no='+no, closeImg: {width:23, height:23} });

	}



	function goMemberCrmView(no) {
		var href = "./?menuType=member&mode=popMemberCrmView&tab=memberOrderList&memberNo="+no;
		window.open(href, "CRM", "width=1100px,height=800px,scrollbars=yes");

	}

	/* 배송정보(주소) 수정 */
	function goOrderDeliveryAddr(no)
	{
		$.smartPop.open({  bodyClose: false, width: 500, height: 270, url: './?menuType=order&mode=popOrderDeliveryAddr&no='+no, closeImg: {width:23, height:23} });
	}
//-->
</script>