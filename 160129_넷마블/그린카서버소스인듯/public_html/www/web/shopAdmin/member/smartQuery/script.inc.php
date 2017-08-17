<script type="text/javascript">
<!--
	var scriptLoadMsg = "<?=$scriptLoadMsg?>";
	var query_max_cnt = "<?=$query_max_cnt?>";

	// 이벤트 정의
	function goDataEditSearchMoveEvent(setNo)			{ goDataEditSearchMove(setNo);				}
	function goDataEditSearchActEvent()					{ goDataEditSearchAct();					}
	function goDataEditExcelMoveEvent()					{ goDataEditExcelMove();					}
	function goDataEditWhereWordAddEvent()				{ goDataEditWhereWordAdd();					}
	function goDataEditWhereWordDeleteEvent(obj)		{ goDataEditWhereWordDelete(obj);			}
	function goDataEditWhereDateAddEvent()				{ goDataEditWhereDateAdd();					}
	function goDataEditWhereDateDeleteEvent(obj)		{ goDataEditWhereDateDelete(obj);			}
	function goDataEditWhereWordChangeEvent(obj)		{ goDataEditWhereWordChange(obj);			}
	function goDataEditWhereDateChangeEvent(obj)		{ goDataEditWhereDateChange(obj);			}
	function goDataEditOrderAddEvent()					{ goDataEditOrderAdd();						}
	function goDataEditOrderDeleteEvent(obj)			{ goDataEditOrderDelete(obj);				}
	function goDataEditWhereColumnWordChangeEvent(obj)	{ goDataEditWhereColumnWordChange(obj);		}
	function goDataEditWriteActEvent()					{ goDataEditWriteAct();						}
	function goDataEditSetChangeEvent(obj)				{ goDataEditSetChange(obj);					}
	function goDataEditModifyActEvent()					{ goDataEditModifyAct();					}
	function goDataEditDeleteActEvent()					{ goDataEditDeleteAct();					}
	function goDataEditSmsMoveEvent()					{ goDataEditSmsMove();						}
	function goDataEditEmailMoveEvent()					{ goDataEditEmailMove();					}
	function goDataEditSmsSendEvent()					{ goDataEditSmsSend();						}
	function goDataEditSmsCloseEvent()					{ goDataEditSmsClose();						}
	function goDataEditEmailSendEvent()					{ goDataEditEmailSend();					}
	function goDataEditEmailCloseEvent()				{ goDataEditEmailClose();					}
	function goPageMoveEvent(page)						{ goPageMove(page);							}
	function goDataEditProductSelectEvent(p_code)		{ goDataEditProductSelect(p_code);			}
	function goDataEditOrderStatusChangeEvent(obj)		{ goDataEditOrderStatusChange(obj);			}
	function goDataEditFamilyFeedChangeEvent(obj)		{ goDataEditFamilyFeedChange(obj);			}

	$(document).ready(function(){
		
		query_max_cnt = (query_max_cnt) ? query_max_cnt : 5;

		/** textarea 최대 길이 설정 **/
		$('textarea[maxlen]').live('keyup change', function() {  
			var str			= $(this).val(); 
			var str_len		= C_getByteLength(str);
			var mx			= parseInt($(this).attr('maxlen'));
			$("#textByte").text(str_len + "/" + mx);
			if (str_len >= mx) {  
				$("#textByte").text(str_len + "/" + mx);
				$(this).val(str.substr(0, str.length-2));
				alert(mx+" byte 까지 등록가능합니다.");
				return false;  
			}
		});

		/** 검색범위 **/
		$("input[id=whereDateStart]").simpleDatepicker();
		$("input[id=whereDateEnd]").simpleDatepicker();

		if(scriptLoadMsg) { 
			$("#loadingForm").css({'display':'none'});
//			$("#dataEditList").css({'display':''});
			alert(scriptLoadMsg);
		}

		var strMode = $("input[name=mode]").val();
		if(strMode == "popDataEditSms"){
			var doc		= opener.document.form;
			var total	= doc.total.value;
			if(!total) { total = 0; }
			total		= number_format(total);
			$("strong[id=total]").text(total+"명");
		}
	});

	function goDataEditFamilyFeedChange(obj) {
		var val = $(obj).val();
		$(obj).parent().find("input[id=whereWord]").val(val);	
	}

	function goDataEditOrderStatusChange(obj) {
		var val = $(obj).val();
		$(obj).parent().find("input[id=whereWord]").val(val);
	}

	function goDataEditProductSearchCallBack(form) {
		var p_code = form.p_code.value;
		$(gObj).parent().find("input[id=whereWord]").val(p_code);
		$("input[name=p_code]").val(p_code);
	}

	function goDataEditProductSelect(p_code) {
		$("input[name=p_code]").val(p_code);
		opener.goDataEditProductSearchCallBack(document.form);
		this.close();
	}

	function goPageMove(page) {
		var doc						= document.form;
		var mode					= "dataEdit";
		doc.page.value				= page;
		C_getMoveUrl(mode,"post","<?=$PHP_SELF?>");
	}

	function goDataEditEmailSend() {
		var doc						= document.form;
		var mode					= "dataEditEmail";
		doc.de_select.value			= opener.form.de_select.value;
		doc.de_select_name.value	= opener.form.de_select_name.value;
		doc.de_where.value			= opener.form.de_where.value;
		doc.de_order.value			= opener.form.de_order.value;
		doc.de_where_join.value		= opener.form.de_where_join.value;
		doc.num.value				= opener.form.num.value;
		doc.target					= "";

		/** 체크 **/
		if(!$("#pm_title").val()) {
			alert("제목을 입력하세요.");
			$("#pm_title").focus();
			return false;
		}

		if(!$("#pm_text").val()) {
			alert("내용을 입력하세요.");
			$("#pm_text").focus();
			return false;
		}
		var x = confirm("검색된 회원에게 메일발송 하시겠습니까?"); 
		if (x != true) { return false; }
		/** 체크 **/

		$("div[id=btnArea]").html("<img src='/shopAdmin/himg/common/loader_bar_type.gif'/>");
		C_getAction(mode,"<?=$PHP_SELF?>");
	}

	function goDataEditEmailClose() {
		this.close();		
	}
	
//	function goDataEditSmsCallBack(form) {
//		var doc						= document.form;
//		var mode					= "dataEditSms";
//		C_getMoveUrl(mode,"post","<?=$PHP_SELF?>");	
//	}

	function goDataEditSmsSend() {
		var doc						= document.form;
		var mode					= "dataEditSms";
		doc.de_select.value			= opener.form.de_select.value;
		doc.de_select_name.value	= opener.form.de_select_name.value;
		doc.de_where.value			= opener.form.de_where.value;
		doc.de_order.value			= opener.form.de_order.value;
		doc.de_where_join.value		= opener.form.de_where_join.value;
		doc.num.value				= opener.form.num.value;
		doc.target					= "";

		/** 체크 **/
		if(!$("#ps_text").val()) {
			alert("내용을 입력하세요.");
			$("#ps_text").focus();
			return false;
		}
		var x = confirm("검색된 회원에게 문자발송 하시겠습니까?"); 
		if (x != true) { return false; }
		/** 체크 **/

		$("div[id=btnArea]").html("<img src='/shopAdmin/himg/common/loader_bar_type.gif'/>");
		C_getAction(mode,"<?=$PHP_SELF?>");
	}
	
	function goDataEditSmsClose() {
		this.close();
	}

	function goDataEditEmailMove() {
		var total				= $("input[name=total]").val();
		if(!total || total <= 0){ alert("검색된 결과가 없습니다. 검색 이후 이용해 주세요."); return false; }

		var num = $("input[name=num]").val();
		var href = "./?menuType=member&mode=popDataEditEmail&num="+num;
		window.open(href, "popDataEditEmail", "width=700px, height=730px,scrollbars=yes");	
	}

	function goDataEditSmsMove() {
		var total				= $("input[name=total]").val();
		if(!total || total <= 0){ alert("검색된 결과가 없습니다. 검색 이후 이용해 주세요."); return false; }

		var num = $("input[name=num]").val();
		var href = "./?menuType=member&mode=popDataEditSms&num="+num;
		window.open(href, "popDataEditSms", "width=560px, height=350px,scrollbars=yes");	
	}

	function goDataEditDeleteAct() {
		var name	= $("select[name=setNo] option:selected").text();
		var x		= confirm("자주사용 등록하신 '" + name + "' 쿼리를 삭제하시겠습니까?"); 
		if (x != true) { return false; }
		self.close();
		opener.goDataEditDeleteActCallBack(document.form);
	}

	function goDataEditModifyAct() {
		$("input:disabled").each( function() {
			$(this).attr("disabled",false);
		});
		$("select:disabled").each( function() {
			$(this).attr("disabled",false);
		});
		C_getAction("dataEditModify","<?=$PHP_SELF?>");
	}

	function goDataEditSetChange(obj) {
		var setNo		= $(obj).val();
		var num			= $("input[name=num]").val();
		if(!setNo) { return false; }
		location.href	= "?menuType=member&mode=popDataEditSearch&num="+num+"&setNo="+setNo;
	}

	function goDataEditWriteAct() {
		$("input:disabled").each( function() {
			$(this).attr("disabled",false);
		});
		$("select:disabled").each( function() {
			$(this).attr("disabled",false);
		});
		C_getAction("dataEditWrite","<?=$PHP_SELF?>");
	}

	function goDataEditOrderDelete(obj) {
		var cnt = $("ul[id=orderArea] > li").length;
		if(cnt <= 1) { alert("1개 이상일때 삭제가 가능합니다."); return false; }
		$(obj).parent().remove();
	}

	function goDataEditOrderAdd() {
		var code = $("ul[id=orderArea] > li").eq(0).clone();
		$("ul[id=orderArea]").append(code);
	}

	var gObj = "";
	function goDataEditWhereColumnWordChange(obj) {
		var whereColumnType	= $(obj).find("option:selected").attr("type");
		if(whereColumnType == "where_order_buy_column") {
			$(obj).parent().find("input[id=whereWord]").attr('disabled',true);
			$(obj).parent().find("select[id=whereType]").attr('disabled',true);
			$(obj).parent().find("input[id=whereWord]").css({'display':''});
			$(obj).parent().find("select[id=orderStatus]").css({'display':'none'});
			$(obj).parent().find("select[id=familyFeed]").css({'display':'none'});
		} else if(whereColumnType == "where_prod_buy_column") {
			gObj = obj;
			$(obj).parent().find("input[id=whereWord]").attr('disabled',true);
			$(obj).parent().find("select[id=whereType]").attr('disabled',true);
			$(obj).parent().find("input[id=whereWord]").css({'display':''});
			$(obj).parent().find("select[id=orderStatus]").css({'display':'none'});
			$(obj).parent().find("select[id=familyFeed]").css({'display':'none'});
			var href = "./?menuType=member&mode=popProductSearch&cuNo=0";
			window.open(href,"","width=800px,height=600px,scrollbars=yes");
		} else if(whereColumnType == "o_status") {
			$(obj).parent().find("input[id=whereWord]").attr('disabled',true);
			$(obj).parent().find("select[id=whereType]").attr('disabled',true);
			$(obj).parent().find("input[id=whereWord]").css({'display':'none'});
			$(obj).parent().find("select[id=orderStatus]").css({'display':''});
			$(obj).parent().find("select[id=familyFeed]").css({'display':'none'});
		} else if(whereColumnType == "where_family_feed_column") {
			$(obj).parent().find("input[id=whereWord]").attr('disabled',true);
			$(obj).parent().find("select[id=whereType]").attr('disabled',true);
			$(obj).parent().find("input[id=whereWord]").css({'display':'none'});
			$(obj).parent().find("select[id=orderStatus]").css({'display':'none'});
			$(obj).parent().find("select[id=familyFeed]").css({'display':''});
			$("select[id=whereType]").val("=");
		} else {
			$(obj).parent().find("input[id=whereWord]").attr('disabled',false);
			$(obj).parent().find("select[id=whereType]").attr('disabled',false);
			$(obj).parent().find("input[id=whereWord]").css({'display':''});
			$(obj).parent().find("select[id=orderStatus]").css({'display':'none'});
			$(obj).parent().find("select[id=familyFeed]").css({'display':'none'});
		}
		$(obj).parent().find("input[id=whereWord]").val("");
	}

	function goDataEditWhereDateChangeEvent(obj) {
		var whereType = $(obj).val();
		if(whereType == "start") {
			$(obj).parent().find("input[id=whereDateStart]").attr('disabled',true);
			$(obj).parent().find("input[id=whereDateEnd]").attr('disabled',false);
		} else if(whereType == "end") {
			$(obj).parent().find("input[id=whereDateStart]").attr('disabled',false);
			$(obj).parent().find("input[id=whereDateEnd]").attr('disabled',true);
		} else {
			$(obj).parent().find("input[id=whereDateStart]").attr('disabled',false);
			$(obj).parent().find("input[id=whereDateEnd]").attr('disabled',false);
		}
	}

	function goDataEditWhereWordChange(obj) {
		var whereType = $(obj).val();
		if(whereType == "is not null") {
			$(obj).parent().find("input[id=whereWord]").attr('disabled',true);
		} else {
			$(obj).parent().find("input[id=whereWord]").attr('disabled',false);
		}
	}

	function goDataEditWhereWordAdd() {
		var code = $("ul[id=whereWordArea] > li").eq(0).clone();
		$(code).find("input[type=text]").val("");
		$(code).find("select[id=whereLink]").attr("disabled", false);
		$("ul[id=whereWordArea]").append(code);
	}

	function goDataEditWhereWordDelete(obj) {
		var cnt = $("ul[id=whereWordArea] > li").length;
		if(cnt <= 1) { alert("1개 이상일때 삭제가 가능합니다."); return false; }
		
		$(obj).parent().remove();

		if(!$("ul[id=whereWordArea] > li").eq(0).find("select[id=whereLink]").attr("disabled")){
			$("ul[id=whereWordArea] > li").eq(0).find("select[id=whereLink]").val("AND");
			$("ul[id=whereWordArea] > li").eq(0).find("select[id=whereLink]").attr("disabled", true);
		}
	}

	function goDataEditWhereDateDelete(obj) {
		var cnt = $("ul[id=whereDateArea] > li").length;
		if(cnt <= 1) { alert("1개 이상일때 삭제가 가능합니다."); return false; }

		$(obj).parent().remove();

		if(!$("ul[id=whereDateArea] > li").eq(0).find("select[id=whereLink]").attr("disabled")){
			$("ul[id=whereDateArea] > li").eq(0).find("select[id=whereLink]").val("AND");
			$("ul[id=whereDateArea] > li").eq(0).find("select[id=whereLink]").attr("disabled", true);
		}
	}

	function goDataEditWhereDateAdd() {
		var code = $("ul[id=whereDateArea] > li").eq(0).clone();
		$(code).find("input[type=text]").val("");
		$(code).find("select[id=whereLink]").attr("disabled", false);
		$("ul[id=whereDateArea]").append(code);
		$(code).find("input[id=whereDateStart]").simpleDatepicker();
		$(code).find("input[id=whereDateEnd]").simpleDatepicker();
	}

	function goDataEditExcelMove() {

		var total				= $("input[name=total]").val();
		if(!total || total <= 0){ alert("검색된 결과가 없습니다. 검색 이후 이용해 주세요."); return false; }

		var doc					= document.form;
		var mode				= "excel";
		doc.action				= "post";
//		doc.target				= "_blank";
		doc.act.value			= "dataEditExcel";
		C_getMoveUrl(mode,"post","<?=$PHP_SELF?>");
	}


	function goDataEditSearchMove(setNo) {
		var num = $("input[name=num]").val();
		var href = "./?menuType=member&mode=popDataEditSearch&num="+num+"&setNo="+setNo;
		window.open(href, "popDataEditSearch", "width=780px, height=700px,scrollbars=yes");
	}

	function goDataEditSearchAct() {
		
		/** select **/
		$("#de_select").attr('value','');
		$("#de_select_name").attr('value','');
		var de_select			= "";
		var de_select_name		= "";
		$("input[id=select]:checked").each(function() {
			var key			= $(this).attr('value');
			var fildName	= $(this).attr('fildName');

			if(de_select) { de_select = de_select + ", "; }
			if(de_select_name) { de_select_name = de_select_name + ", "; }

			de_select		= de_select + key;
			de_select_name	= de_select_name + fildName;
		});
		for(var i=1;i<=query_max_cnt;i++){
			$("input[id=select_family]:checked").each(function() {
				var key			= $(this).attr('value');
				var fildName	= $(this).attr('fildName');

				if(de_select) { de_select = de_select + ", "; }
				if(de_select_name) { de_select_name = de_select_name + ", "; }

				de_select = de_select + key + "_" + i;
				de_select_name	= de_select_name + fildName + "_" + i;
			});
		}
		$("#de_select").attr('value', de_select);
		$("#de_select_name").attr('value', de_select_name);

		/** where word **/
		$("#de_where").attr('value','');
		var de_where				= $("#de_where").attr('script');
		var de_where_join			= $("#de_where_join").attr('script');
		var where_join_use_check	= 0;
		$("ul[id=whereWordArea] > li").each(function() {
			var whereLink		= $(this).find("select[id=whereLink]").val();
			var whereLinkNext	= $(this).next().find("select[id=whereLink]").val();
			var whereLinkEnd	= "";
			var whereColumn		= $(this).find("select[id=whereColumn]").val();
			var whereColumnType	= $(this).find("select[id=whereColumn] option:selected").attr("type");
			var whereColumnTag	= $(this).find("select[id=whereColumn] option:selected").attr("tag");
			var whereWord		= $(this).find("input[id=whereWord]").val();
			var whereType		= $(this).find("select[id=whereType]").val();
			
			if(whereLink == "AND" && whereLinkNext == "OR") { whereLink = "AND ("; }
			if(whereLink == "OR" && (whereLinkNext == "AND" || !whereLinkNext)) { whereLinkEnd = ")"; }

			if(whereColumnTag) { whereColumn = whereColumnTag; }

			if(whereLink && whereColumn && whereType) {
				var	script		= "";
				if(whereColumnType == "where_family_column" || whereColumnType == "where_family_feed_column"){
					var script_temp = "";
					for(var i=1;i<=query_max_cnt;i++){
						if(whereType == "like"){
							script_temp		= whereColumn + "_" + i + " " + whereType + " ('%" + whereWord + "%') ";
						} else if(whereType == "is not null"){
							whereColumnTemp		= "( "+whereColumn+"_"+i+" IS NOT NULL AND "+whereColumn+"_"+i+" != '' )";
							script_temp		= whereColumnTemp + " ";
						} else {
							script_temp		= whereColumn + "_" + i + " " + whereType + " '" + whereWord + "' ";
						}
						if(script) { script = script + "OR "; }
						script = script + script_temp;		
					}
					script			= whereLink + " ( " + script + ")";
				}else if(whereColumnType == "where_order_buy_column"){
					if(whereColumn == "tag_use"){
						script					= whereLink + " " + whereColumnTag + " ";
						where_join_use_check	= 1;
					}
				}else if(whereColumnType == "where_prod_buy_column"){
					script		= whereLink + " " + whereColumn + " " + whereType + " '" + whereWord + "' ";
				}else{
					if(whereType == "like"){
						script		= whereLink + " " + whereColumn + " " + whereType + " ('%" + whereWord + "%') ";
					} else if(whereType == "is not null"){
						whereColumn	= "( "+whereColumn+" IS NOT NULL AND "+whereColumn+" != '' )";
						script		= whereLink + " " + whereColumn + " ";
					} else {
						script		= whereLink + " " + whereColumn + " " + whereType + " '" + whereWord + "' ";
					}
				}
				if(whereColumnType == "where_order_column" || whereColumnType == "where_prod_buy_column"){
					de_where_join		= de_where_join + script;
				}else{
					de_where			= de_where + script;
				}

				de_where				= de_where + whereLinkEnd;
			}	
		});




		/** where date **/
		$("ul[id=whereDateArea] > li").each(function() {
			var whereLink		= $(this).find("select[id=whereLink]").val();
			var whereLinkNext	= $(this).next().find("select[id=whereLink]").val();
			var whereLinkEnd	= "";
			var whereColumn		= $(this).find("select[id=whereColumn]").val();
			var whereColumnType	= $(this).find("select[id=whereColumn] option:selected").attr("type");
			var whereDateStart	= $(this).find("input[id=whereDateStart]").val();
			var whereDateEnd	= $(this).find("input[id=whereDateEnd]").val();
			var whereType		= $(this).find("select[id=whereType]").val();

			if(whereLink == "AND" && whereLinkNext == "OR") { whereLink = "AND ("; }
			if(whereLink == "OR" && (whereLinkNext == "AND" || !whereLinkNext)) { whereLinkEnd = ")"; }

			if(whereLink && whereColumn && whereType) {
				var	script		= "";
				var between		= "";
				if(whereType == "between"){
					between			= "BETWEEN DATE_FORMAT('"+whereDateStart+"','%Y-%m-%d 00:00:00') AND DATE_FORMAT('"+whereDateEnd+"','%Y-%m-%d 23:59:59')";
					script			= whereLink + " " + whereColumn + " " + between + " ";
				} else if(whereType == "start"){
					whereDateEnd	=  "2999-01-01";
					between			= "BETWEEN DATE_FORMAT('"+whereDateStart+"','%Y-%m-%d 00:00:00') AND DATE_FORMAT('"+whereDateEnd+"','%Y-%m-%d 23:59:59')";
					script			= whereLink + " " + whereColumn + " " + between + " ";
				} else if(whereType == "end"){
					whereDateStart	= "1900-01-01";
					between			= "BETWEEN DATE_FORMAT('"+whereDateStart+"','%Y-%m-%d 00:00:00') AND DATE_FORMAT('"+whereDateEnd+"','%Y-%m-%d 23:59:59')";
					script			= whereLink + " " + whereColumn + " " + between + " ";
				}
				if(whereColumnType == "where_order_date_column"){
					de_where_join	= de_where_join + script;
				}else{
					de_where		= de_where + script;
				}

				de_where			= de_where + whereLinkEnd;
			}
		});
		$("#de_where").attr('value', de_where);

//		if(where_join_use_check && de_where_join == ""){
//			de_where_join = "{code_1}";
//		}
		$("#de_where_join").attr('value', de_where_join);

		/** order by **/
		$("#de_order").attr('value','');
		var de_order			= $("#de_order").attr('script');
		$("ul[id=orderArea] > li").each(function() {
			var orderColumn		= $(this).find("select[id=orderColumn]").val();
			var orderType		= $(this).find("select[id=orderType]").val();
			if(orderColumn && orderType) {
				if(de_order) { de_order = de_order + ", "; }
				de_order		= de_order + orderColumn + " " + orderType + " ";
			}
		});
	
		$("#de_order").attr('value', de_order);

		if(where_join_use_check){
			var de_where_join = $("#de_where_join").attr('value');
			if(!de_where_join) {
			}
		}

//		return false;

	//	self.close();
		opener.goDataEditSearchCallBack(document.form);
		
	}

	function goDataEditSearchCallBack(form) {	
		var doc						= document.form;
		var mode					= "dataEdit";
		doc.de_select.value			= form.de_select.value;
		doc.de_select_name.value	= form.de_select_name.value;
		doc.de_where.value			= form.de_where.value;
		doc.de_order.value			= form.de_order.value;
		doc.de_where_join.value		= form.de_where_join.value;
		doc.num.value				= form.num.value;
		doc.p_code.value			= form.p_code.value;
		doc.page.value				= "";
		doc.target					= "";

		C_getMoveUrl(mode,"post","<?=$PHP_SELF?>");
		$(this.document).find("#loadingForm").css({'display':''});
//		$(this.document).find("#dataEditList").css({'display':'none'});
	}

	function goDataEditDeleteActCallBack(form) {

//		var act			= "./";
//		var mode		= "dataEditDelete";
//
//		doc.action		= act;
//		doc.mode.value	= "act";
//		doc.act.value	= mode;
//		doc.method		="post";
//		doc.submit();

		var doc						= document.form;
		doc.num.value				= form.num.value;
		doc.setNo.value				= form.setNo.value;
		C_getAction("dataEditDelete","<?=$PHP_SELF?>");	

	}


//-->
</script>

