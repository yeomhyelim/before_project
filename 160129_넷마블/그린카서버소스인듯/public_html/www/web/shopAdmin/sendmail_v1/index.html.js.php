<script type="text/javascript">
<!--

	$(document).ready(function() {
		C_CallMenuAuthBtn("<?=$a_admin_no?>","<?=$strTopMenuCode?>","<?=$strLeftMenuCode01?>","<?=$strLeftMenuCode02?>");

		/* TAB KEY */
		 $('textarea').keydown(function(e) {
			 if(e.keyCode == 9) { 
//				return false
			 }
		 });
	});

	/* 버튼 이벤트 */
	function goMoveUrl(mode,no,c)
	{
		switch (mode)
		{
		case "sendMailModify":
	
			$("div[id^=modifyText_]").css("display","block");
			$("div[id^=modifyEdit_]").css("display","none");
			$("#modifyEdit_"+no).css("display","block");
			$("#modifyText_"+no).css("display","none");		

		break;

		case "sendMailModifyOK":

			var url			= "./?";
			var param		= "";
			var doc			= document.form;
			var em_auto		= $(":radio[name='em_auto_"+c+"']:checked").val();
				
			param += "menuType=sendmail&mode=json&act="+mode+"&mailLng=<?=$strMailLng?>&em_no="+no+"&";
			param += "em_auto="+em_auto+"&";
			param += "em_title="+doc.em_title[c].value+"&";
			param += "em_text="+doc.em_text[c].value+"&";
			param += "em_sender="+doc.em_sender[c].value+"&";
			param += "em_send_code="+doc.em_send_code[c].value+"&"
			
			goMoveJson(mode, no, url, param);

		break;

		case "modifyCancel":

			$("div[id^=modifyText_]").css("display","block");
			$("div[id^=modifyEdit_]").css("display","none");

		break;

		case "emailUseType":
			var url				= "./?";
			var param			= "";
			var doc				= document.form;
			var s_emailUse		= $(":radio[name='s_emailUse']:checked").val();


			param += "menuType=sendmail&mode=json&act="+mode+"&mailLng=<?=$strMailLng?>&em_no="+no+"&";
			param += "s_emailUse="+s_emailUse+"&";

			goMoveJson(mode, no, url, param);

		break;
		}
	}

	function goMoveJson(mode, no, url, param)
	{
		if (window.XMLHttpRequest)
		{
			// code for IE7+, Firefox, Chrome, Opera, Safari
			xmlhttp = new XMLHttpRequest();
		}
		else
		{
			// code for IE6, IE5
			xmlhttp = new ActiveXObject("Microsoft.XMLHTTP");
		}

		xmlhttp.onreadystatechange=function()
		{
			if (xmlhttp.readyState==4 && xmlhttp.status==200)
			{
				if(xmlhttp.responseText)
				{
					switch (mode)
					{

					case "sendMailModifyOK":

						alert("<?=$LNG_TRANS_CHAR['CS00004']?>"); //수정이 왼료되었습니다.
						$("#modifyEdit_"+no).css("display","none");
						$("#modifyText_"+no).css("display","block");
						$("#modifyText_"+no).html(xmlhttp.responseText);

					break;

					case "emailUseType":

						alert("<?=$LNG_TRANS_CHAR['CS00004']?>"); //수정이 왼료되었습니다.

					break;
					}

					return;
				}
			}
		}
		
		xmlhttp.open("POST", url, false);
		xmlhttp.setRequestHeader("Content-Type", "application/x-www-form-urlencoded");
		xmlhttp.send(param);

	}
	
	/* 국가 선택시 */	
	function goSelectLang()
	{
		var strMode = $("#mode").val();
		
		document.form.method = "post";

		C_getMoveUrl(strMode,"post","<?=$PHP_SELF?>");
	}

	function goCollectionEmailExcelDowndownActEvent() {

		var data			= new Array();
		data['mode']		= "excel";
		data['act']			= "excelCollectionEmail";

		C_getAddLocationUrl(data);
	}

//-->
</script>