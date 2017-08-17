<script type="text/javascript">
<!--
	var strLoginAdminType	= "<?=$a_admin_type?>";
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
		$.getJSON("./?menuType=order&mode=json&jsonMode=orderInfoDisplay&state="+state,function(data){
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
		data['menuType']			= "order";
		data['mode']				= "act";
		data['act']					= "orderSettleStatus";
		data['page']				= $("input[name=page]").val();

		C_getSelfAction(data);
	}

	/* 상품 구매상태변경 */
	function goOrderStatusUpdate(no)
	{
		if (!goOrderStatusSaveAllChk(no))
		{
			alert("변경하신 구매상태 데이터가 존재하지 않습니다."); //변경하신 구매상태 데이터가 존재하지 않습니다.
			return;
		}

		var intOrderCartCnt		= $("div[id^=order_cart_order_]").length;
		var aryCnt				= (intOrderCartCnt * 10) + 5;
		var data				= new Array(aryCnt);
		var intCnt				= 0;
		var intCancelCnt		= 0;
		var intEndCnt			= 0;

		if (!no)
		{
			$("div[id^=order_cart_order_]").each(function(i) {
				var intOC_NO					= $(this).attr("id").replace("order_cart_order_","");
				var strCartOrderStatus			= $(this).find("select#cartOrderStatus").val();
				var strDefaultCartOrderStatus	= $(this).find("select").attr("default");

				//취소완료는 배송전취소/배송후취소/부분취소사용시에만 사용
				if (strCartOrderStatus == "C2")
				{
					intCancelCnt++;
				}

				//구매완료버튼
				if (strCartOrderStatus == "E")
				{
					intEndCnt++;
				}

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

			if ($("div[id=order_cart_order_"+no+"]").find("select#cartOrderStatus").val() == "C2")
			{
				intCancelCnt++;
			}

			if ($("div[id=order_cart_order_"+no+"]").find("select#cartOrderStatus").val() == "E")
			{
				intEndCnt++;
			}
		}

		if (intCancelCnt > 0)
		{
			alert("[취소완료] 상태변경은 [배송전/배송후/부분취소] 버튼을 클릭해서 변경해주세요.");
			return;
		}

		if (strLoginAdminType == "S" && intEndCnt > 0)
		{
			alert("입점사에서는 [구매완료]로 상태를 변경하실 수 없습니다.");
			return;
		}

		data['menuType']			= "order";
		data['mode']				= "json";
		data['jsonMode']			= "orderCartStatusSave";
		C_getJsonAjaxAction("orderCartStatusSave","./index.php",data);

//		C_getSelfAction(data);

		return;
	}

	function goOrderStatusSaveAllChk(no)
	{
		var intModifyCnt		= 0;

		$("div[id^=order_cart_order_]").each(function(i) {
			var oc_no						= $(this).attr("id").replace("order_cart_order_","");
			var orderStatus					= $(this).find("select#cartOrderStatus").val();
			var defaultOrderStatus			= $(this).find("select#cartOrderStatus").attr("default");
			if (orderStatus != defaultOrderStatus) {
				if ((no > 0 && no == oc_no) || no == 0) {
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
		data['menuType']			= "order";
		data['mode']				= "json";
		data['jsonMode']			= "orderCartDeliverySave";

		//C_getSelfAction(data);
		C_getJsonAjaxAction("orderCartDeliverySave","./index.php",data);

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
			var strJsonParam = "menuType=order&mode=json&jsonMode=orderCartNoSelect&oNo="+oNo+"&shopNo="+shopNo;
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

				data['menuType']	= "order";
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

			data['menuType']			= "order";
			data['mode']				= "json";
			data['jsonMode']			= "orderCartDeliverySave";

			C_getJsonAjaxAction("orderCartDeliverySave","./index.php",data);
		}
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
			if (data.mode == "__SUCCESS__")
			{
				alert("구매상태가 변경되었습니다.");
				return;
			}
			if (data.text)
			{
				alert(data.text);
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
		$.smartPop.open({  bodyClose: false, width: 800, height: 270, url: './?menuType=order&mode=popOrderHistoryList&no='+no, closeImg: {width:23, height:23} });
	}

	/* 부분 취소 팝업창 오픈 */
	function goOrderPartCancel(no,cartNo)
	{
		$.smartPop.open({  bodyClose: false, width: 800, height: 270, url: './?menuType=order&mode=popOrderPartCancel&no='+no+"&cartNo="+cartNo, closeImg: {width:23, height:23} });
	}

	/* 배송정보(주소) 수정 */
	function goOrderDeliveryAddr(no)
	{
		$.smartPop.open({  bodyClose: false, width: 500, height: 270, url: './?menuType=order&mode=popOrderDeliveryAddr&no='+no, closeImg: {width:23, height:23} });
	}

	/* 주문정보 엑셀 다운로드 */
	function goExcel(mode)
	{
		var data				= new Array(50);
		data					= goSearchDataSet(data);

		<?if($_REQUEST["searchYN"]=="Y"){?>
		data['searchYN']		= "Y";
		<?}?>
		data['menuType']		= "order";
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



	/* 배송정보 입력 */
	function goOrderDeliveryUpdate(no)
	{
		//C_openWindow("./?menuType=popup&mode=orderDeliveryInput&no="+no,"<?=$LNG_TRANS_CHAR['OW00044']?>","500","300"); //배송정보입력
		$.smartPop.open({  bodyClose: false, width: 500, height: 270, url: './?menuType=order&mode=popOrderDeliveryInput&no='+no, closeImg: {width:23, height:23} });
	}




	/* 주문정보 상세보기 */
	function goOrderView(no){

		//C_openWindow("./?menuType=popup&mode=orderView&no="+no,"<?=$LNG_TRANS_CHAR['OW00012']?>","600","600"); //주문정보 T상세보기
		$.smartPop.open({  bodyClose: false, width: 800, height: 270, url: './?menuType=order&mode=popOrderView&no='+no, closeImg: {width:23, height:23} });
	}

	/* 레이어 창 닫기 */
	function goPopClose(reload)
	{
		if (reload == "Y")
		{
			location.reload();
		}
		$.smartPop.close();
	}

	/* 주문 삭제 */
	function goOrderDelete(no){
		var strMsg = "주문을 삭제하시겠습니까?";
		var x = confirm(strMsg);
		if (x == true)
		{
			var data				= new Array(5);

			data['menuType']		= "order";
			data['mode']			= "act";
			data["act"]				= "orderDelete";
			data["oNo"]				= no;

			C_getSelfAction(data);
		}
	}

	function goOrderReturnEvent(no)
	{
		$.smartPop.open({  bodyClose: false, width: 800, height: 270, url: './?menuType=order&mode=popOrderReturn&no='+no, closeImg: {width:23, height:23} });
	}

//-->
</script>