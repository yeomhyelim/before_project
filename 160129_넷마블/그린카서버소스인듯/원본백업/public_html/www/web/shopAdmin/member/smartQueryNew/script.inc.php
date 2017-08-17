<script type="text/javascript">
<!--
	var scriptLoadMsg	= "<?=$scriptLoadMsg?>";
	var query_max_cnt	= "<?=$query_max_cnt?>";
	var gMode			= "<?=$strMode?>";
	var myVar			= "";				
	var objWhereType	= "";

	// 이벤트 정의
	function goDataEditSearchMoveEvent(setNo)			{ goDataEditSearchMove(setNo);				}
	function goDataEditSearchActEvent()					{ goDataEditSearchAct();					}
	function goDataEditExcelMoveEvent()					{ goDataEditExcelMove();					}
	function goDataEditWhereWordAddEvent()				{ goDataEditWhereWordAdd();					}
	function goDataEditWhereWordDeleteEvent(obj)		{ goDataEditWhereWordDelete(obj);			}
//	function goDataEditWhereDateAddEvent()				{ goDataEditWhereDateAdd();					}
//	function goDataEditWhereDateDeleteEvent(obj)		{ goDataEditWhereDateDelete(obj);			}
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
	function goDataEditSelectValueGiveEvent(obj)		{ goDataEditSelectValueGive(obj);			}
	function goDataEditWhereWordRecMoveEvent()			{ goDataEditWhereWordRecMove();				}

	$(document).ready(function(){
//		window.name = gMode;
		if(gMode == "popDataEditSearchNew") {
			objWhereType  = $("select#whereType option");
			var whereMode = $("select#whereType option:selected").attr("mode");
			$("select#whereType option").remove();
			$(objWhereType).each(function() {
				var val		= $(this).val();
				var mode	= $(this).attr("mode");
				var text	= $(this).text();
				if(whereMode == mode){
					$("select#whereType").append("<option value='"+val+"' mode='"+mode+"'>"+text+"</option>");
				}
			});
		}
	});

	function goDataEditOrderAdd() {
		var code = $("ul[id=orderArea] > li").eq(0).clone();
		$(code).find("select[id=orderColumn]").attr("disabled", false);
		$(code).find("select[id=orderType]").attr("disabled", false);
		$("ul[id=orderArea]").append(code);
	}

	function goDataEditOrderDeleteEvent(obj) {
		var cnt = $("ul[id=orderArea] > li").length;
		if(cnt <= 1) { alert("1개 이상일때 삭제가 가능합니다."); return false; }

		$(obj).parent().remove();
	}

//	function goDataEditWhereDateAdd() {
//		var code = $("ul[id=whereDateArea] > li").eq(0).clone();
//		$(code).find("input[type=text]").val("");
//		$(code).find("select[id=whereLink]").attr("disabled", false);
//		$("ul[id=whereDateArea]").append(code);
//		$(code).find("input[id=whereDateStart]").simpleDatepicker();
//		$(code).find("input[id=whereDateEnd]").simpleDatepicker();
//	}

//	function goDataEditWhereDateDelete(obj) {
//		var cnt = $("ul[id=whereDateArea] > li").length;
//		if(cnt <= 1) { alert("1개 이상일때 삭제가 가능합니다."); return false; }
//
//		$(obj).parent().remove();
//
//		if(!$("ul[id=whereDateArea] > li").eq(0).find("select[id=whereLink]").attr("disabled")){
//			$("ul[id=whereDateArea] > li").eq(0).find("select[id=whereLink]").val("AND");
//			$("ul[id=whereDateArea] > li").eq(0).find("select[id=whereLink]").attr("disabled", true);
//		}
//	}


	function goDataEditWhereWordRecMove() {
		var num = $("input[name=num]").val();
		var href = "./?menuType=member&mode=popDataEditRec&num="+num;
		window.open(href, "popDataEditSms", "width=560px, height=350px");	
	}

	function goDataEditSelectValueGive(obj) {
		var value = $(obj).val();
		$(obj).parent().parent().find("input[id=whereWord]").val(value);
	}

	function goDataEditSearchMove(setNo) {
		var num = $("input[name=num]").val();
		var href = "./?menuType=member&mode=popDataEditSearchNew&num="+num+"&setNo="+setNo;
		window.open(href, "popDataEditSearch", "width=780px, height=700px");
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

	function goDataEditWhereColumnWordChange(obj) {
		var whereWordUser	= $(obj).find("option:selected").attr("whereWordUser");
		if(!whereWordUser) { 
			$(obj).parent().find("input[id=whereWord]").css({'display':''});
			$(obj).parent().find("span[id=whereWordUser]").html("");
		} else {
			var code			= $("textarea[id="+whereWordUser+"]").val();
			code				= $(code);
			//$("input[id=whereWord]").css({'display':'none'});
			$(obj).parent().find("span[id=whereWordUser]").html(code);
		}
			
		/****/
		var whereTypeMode	= $(obj).find("option:selected").attr("whereTypeMode");
		if(!whereTypeMode) { whereTypeMode = "default"; }
		$(obj).parent().find("select#whereType option").remove();
		$(objWhereType).each(function() {
			var val		= $(this).val();
			var mode	= $(this).attr("mode");
			var text	= $(this).text();

			if(whereTypeMode == mode){
				$(obj).parent().find("select#whereType").append("<option value='"+val+"' mode='"+mode+"'>"+text+"</option>");
			}
		});
		if(whereTypeMode == "date"){
			$(obj).parent().find("input[id=whereDateStart]").simpleDatepicker();
			$(obj).parent().find("input[id=whereDateEnd]").simpleDatepicker();
		}
	}

	function goDataEditSearchAct() {

		/** 출력 리스트 **/
		$("#de_select").attr('value','');
		$("#de_select_name").attr('value','');

		var de_select			= "";
		var de_select_name		= "";

		$("input[id=select]:checked").each(function() {
			var key			= $(this).attr('value');
			var cname		= $(this).attr('cname');

			if(de_select) { de_select = de_select + ", "; }
			if(de_select_name) { de_select_name = de_select_name + ", "; }

			de_select		= de_select + key;
			de_select_name	= de_select_name + cname;
		});

		$("#de_select").attr('value', de_select);
		$("#de_select_name").attr('value', de_select_name);

		/** 조건 리스트 **/
		$("#de_where").attr("value","");
		$("#de_where_join").attr("value","");
		
		var de_where			= $("#de_where").attr('script');
		var de_where_join		= $("#de_where_join").attr('script');

		$("ul[id=whereWordArea] > li").each(function() {
			var where			= "";
			var whereWord		= $(this).find("input[id=whereWord]").attr('value');
			var whereLink		= $(this).find("select[id=whereLink] option:selected").attr('value');
			var whereLinkNext	= $(this).next().find("select[id=whereLink] option:selected").attr('value');
			var whereLinkEnd	= "";
			var whereColumn		= $(this).find("select[id=whereColumn] option:selected").attr('value');
			var whereWordUser	= $(this).find("select[id=whereColumn] option:selected").attr('whereWordUser');
			var whereType		= $(this).find("select[id=whereType] option:selected").attr('value');
			
			if(whereColumn && whereWord){
				if(whereType == "is not null") {
					where = whereColumn + " is not null ";
				} else if(whereType == "like") {
					where = whereColumn + " " + whereType + " ('%" + whereWord + "%') ";
				} else {
					where = whereColumn + " " + whereType + " '" + whereWord + "' ";
				}
			}

			if(where) {
				if(whereLink && de_where) { de_where = de_where + whereLink + " "; }
				de_where = de_where + where;
			}
		});

		$("#de_where").attr("value", de_where);
		$("#de_where_join").attr("value", de_where_join);

		/** 정렬 리스트 **/
		var de_where			= "";

		$("#de_order").attr("value","");
		
		$("ul[id=orderArea] > li").each(function() {
			var order			= "";
			var orderColumn		= $(this).find("select[id=orderColumn] option:selected").attr('value');
			var orderType		= $(this).find("select[id=orderType] option:selected").attr('value');
			
			if(orderColumn && orderType) {
				order				= orderColumn + " " + orderType;
				if(de_where) { de_where = de_where + ", "; }
				de_where =de_where + order;
			}
		});

		$("#de_order").attr("value", de_where);

		document.form.mode.value	= "dataEditNew";
//		document.form.method		= "post";
		document.form.target		= opener.name;
		document.form.submit();

		opener.gMode	= "";
		$("div#btnArea").css({'display':'none'});
		$("div#loadingArea").css({'display':''});
		myVar			= setInterval(function(){myTimer()},1000);
	}

	function myTimer()
	{
		if(opener.gMode == "dataEditNew") {
			$("div#btnArea").css({'display':''});
			$("div#loadingArea").css({'display':'none'});
			alert("완료되었습니다.");
			clearInterval(myVar);
		}
	}
//-->
</script>

