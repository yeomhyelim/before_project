<script type="text/javascript">
<!--
	function goDeliverySaveAllActEvent()			{ goDeliverySaveAllAct();				}
	function goDeliveryExcelDownloadActEvent()		{ goDeliveryExcelDownloadAct();			}
	function goDeliveryExcelSaveActEvent()			{ goDeliveryExcelSaveAct();				}
	function goOrderStatusSaveCheckActEvent()		{ goOrderStatusSaveCheckAct();			}
	function goOrderStatusSaveActEvent(so_no)		{ goOrderStatusSaveAct(so_no);			}
	function goDeliveryIngExcelDownloadActEvent()	{ goDeliveryIngExcelDownloadAct();		}

	function goDeliveryAllExcelDownloadActEvent()	{ goDeliveryExcelAllDownloadAct();			}

	var strInputBoxStyle = " class=\"nbox\" onfocus=\"this.className='sbox'\" onblur=\"this.className='nbox'\"";

	$(document).ready(function(){
		C_CallMenuAuthBtn("<?=$a_admin_no?>","<?=$strTopMenuCode?>","<?=$strLeftMenuCode01?>","<?=$strLeftMenuCode02?>");

		$('input[name=searchRegStartDt]').simpleDatepicker();
		$('input[name=searchRegEndDt]').simpleDatepicker();
	});

	function goOrderStatusSaveActEvent(so_no) {
		
		if (!confirm("구매완료 하시겠습니까?")) {
			return false;
		}

		var data				= new Array(5);

		data["chkNo[0]"]			= so_no;
		data['menuType']			= "order";
		data['mode']				= "act";
		data['act']					= "orderBuyAccept"; 
		data['page']				= $("input[name=page]").val();
		C_getSelfAction(data);
	}

	function goOrderStatusSaveCheckAct() {

		// 체크
		var orderStatusCnt		= $("input#deliveryNo:checked").length;
		
		if(orderStatusCnt <= 0) {
			alert("데이터를 선택하세요.");
			return false;
		}

		if (!confirm("선택항목을 구매완료 하시겠습니까?")) {
			return false;
		}

		// 전달
		var cnt					= orderStatusCnt;
		var aryCnt				= (cnt * 1) + 5;
		var data				= new Array(aryCnt);
		$("input#deliveryNo:checked").each(function(i) {
			var oc_no						= $(this).val();
			data["chkNo["+i+"]"]			= oc_no;
		});

		data['menuType']			= "order";
		data['mode']				= "act";
		data['act']					= "orderBuyAccept"; 
		data['page']				= $("input[name=page]").val();
		C_getSelfAction(data);
	}
	

	function goDeliveryExcelSaveAct() {
 		var fileName				= "excelFile";
		var data					= new Array(5);

		data['menuType']			= "order";
		data['mode']				= "act";
		data['act']					= "orderDeliveryExcelUpdate"; 

		$.smartPop.open({  bodyClose: false, width: 500, height: 270, url: './?menuType=order&mode=popExcelFileUpload', closeImg: {width:23, height:23} });

//		getSelfFileAction(data, fileName);
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

	function goDeliveryExcelDownloadAct() {
		var data				= new Array(5);

		data['menuType']			= "order";
		data['mode']				= "excel";
		data['act']					= "excelDeliveryFastList"; 

		/** 2013.06.26 kim hee sung 검색 옵션 추가 **/
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

		C_getSelfMove(data);
	}


	function goDeliveryExcelAllDownloadAct() {
		var data				= new Array(5);

		data['menuType']			= "order";
		data['mode']				= "excel";
		data['act']					= "excelDeliveryAllFastList"; 

		/** 2013.06.26 kim hee sung 검색 옵션 추가 **/
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

		C_getSelfMove(data);
	}



	function goDeliveryIngExcelDownloadAct() {
		var data					= new Array(5);

		data['menuType']			= "order";
		data['mode']				= "excel";
		data['act']					= "excelDeliveryList"; 

		/** 2013.06.26 kim hee sung 검색 옵션 추가 **/
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

		<?if($_REQUEST['searchOrderStatus']):?>
		data['searchOrderStatus']		= "<?=$_REQUEST['searchOrderStatus']?>";
		<?endif;?>

		C_getSelfMove(data);
	}


	function goDeliverySaveAllAct() {

		if (!confirm("배송정보를 일괄 수정하시겠습니까?")) {
			return false;
		}

		var cnt					= $("tr[id^=shop_order_]").length;
		var aryCnt				= (cnt * 4) + 5;
		var data				= new Array(aryCnt);
		$("tr[id^=shop_order_]").each(function(i) {
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
		data['page']				= $("input[name=page]").val();
		C_getSelfAction(data);
	}


	function getSelfFileAction(data, fileName) {
		var form = $("<form></form>").css({'display':'none'});
		form.attr("enctype","multipart/form-data");
		form.attr("method","post");
		form.attr("action","./");
		form.attr("name","tempForm");
		form.appendTo('body');

		for(var name in data){
			var value	= data[name];
			var input	= "<input type='hidden' name='"+name+"' value='"+value+"'/>";
			form.append(input);
		}
		var input1	= "<input type='file' name='"+fileName+"'/>";

		form.append(input1);	
		
		if($.browser.msie) {
//			form.find("input[name="+fileName+"]").change(function() {
//				form.submit();
//			});
//			alert("익스플로에서는 지원하지 안습니다.");
		} else {
			form.find("input[name="+fileName+"]").change(function() {
				form.submit();
			});
			form.find("input[name="+fileName+"]").click();
		}
	}

	function goMemberCrmView(no) {
		var href = "./?menuType=member&mode=popMemberCrmView&tab=memberOrderList&memberNo="+no;
		window.open(href, "CRM", "width=1100px,height=800px,scrollbars=yes");
	}

//-->
</script>