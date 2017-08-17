<script type="text/javascript">
	var intM_NO			= "<?=$g_member_no?>";

	$(document).ready(function(){

	});

	/* 장바구니 삭제 */
	function goCartAllCheck(chkObj)
	{
		if (chkObj.checked == true)
		{
			$('input[name="cartNo[]"]').attr("checked", true);
		} else {

			$('input[name="cartNo[]"]').attr("checked", false);
		}
	}

	/* wish -> basket */
	function goBasket(no)
	{
		var x = confirm("<?=$LNG_TRANS_CHAR['OS00013']?>"); //선택한 상품을 장바구니로 이동하시겠습니까?
		if (x == true)
		{
			var doc = document.form;

			doc.no.value = no;
			doc.mode.value = "act";
			doc.act.value = "moveBasket";
			doc.method = "post";
			doc.action = "<?=$PHP_SELF?>";
			doc.submit();
		}
	}

	/* 장바구니 -> wish */
	function goWish(no)
	{
		if (C_isNull(intM_NO))
		{
			alert("<?=$LNG_TRANS_CHAR['OS00014']?>"); //로그인을 하신 후 이용하실 수 있습니다.
			return;
		}
		var x = confirm("<?=$LNG_TRANS_CHAR['OS00015']?>"); //선택한 상품을 위시리스트로 이동하시겠습니까?
		if (x == true)
		{
			var doc = document.form;

			doc.no.value = no;
			doc.mode.value = "act";
			doc.act.value = "moveWish";
			doc.method = "post";
			doc.action = "<?=$PHP_SELF?>";
			doc.submit();
		}
	}

	function goWishAll()
	{
		if (C_isNull(intM_NO))
		{
			alert("<?=$LNG_TRANS_CHAR['OS00014']?>"); //로그인을 하신 후 이용하실 수 있습니다.
			return;
		}

		if (!C_isNull(document.form["cartNo[]"]))
		{
			var strSelectNo = C_getCheckedCode(document.form["cartNo[]"]);
			if (C_isNull(strSelectNo))
			{
				alert("<?=$LNG_TRANS_CHAR['OS00016']?>"); //담아두실 상품을 선택해주세요.
				return;
			}

			var doc = document.form;

			doc.mode.value = "act";
			doc.act.value = "moveWish";
			doc.method = "post";
			doc.action = "<?=$PHP_SELF?>";
			doc.submit();
		}

	}

	/* wish 삭제 */
	function goWishDel(no)
	{
		var x = confirm("<?=$LNG_TRANS_CHAR['OS00017']?>"); //선택한 상품을 삭제하시겠습니까?
		if (x == true)
		{
			var doc = document.form;

			doc.no.value = no;
			doc.mode.value = "act";
			doc.act.value = "wishDel";
			doc.method = "post";
			doc.action = "<?=$PHP_SELF?>";
			doc.submit();
		}
	}

	/* 수량 update */
	function goQtyUpMinus(gb1,gb2,no)
	{
		var inputObj = gb1+"Qty"+no;
		var intQty = parseInt($("#"+inputObj).val());
		intQty = intQty + (1 * gb2);

		if (intQty <= 0)
		{
			alert("<?=$LNG_TRANS_CHAR['OS00005']?>"); //수량은 '0'보다 커야 합니다.
			return;
		}

		$("#"+inputObj).val(intQty);
	}

	function goQtyUpdate(mode,no)
	{
		var intQty = parseInt($("#"+mode+"Qty"+no).val());
		var strJsonParam = "cartQty&cartNo="+no+"&qty="+intQty;

		if (mode == "wish")
		{
			var strJsonParam = "wishQty&wishNo="+no+"&qty="+intQty;
		}

//		$("body").html("./?menuType=order&mode=json&act="+strJsonParam);
		$.getJSON("./?menuType=order&mode=json&act="+strJsonParam,function(data){

			if(data[0].RET == "N") {
				alert(data[0].MSG);
				return;
			}

			document.form.submit();
			//location.reload();
		})
	}

	/* 장바구니 삭제 */
	function goCartDel(no)
	{
		var x = confirm("<?=$LNG_TRANS_CHAR['OS00017']?>"); //선택한 상품을 삭제하시겠습니까?
		if (x == true)
		{
			var doc = document.form;
			doc.no.value = no;
			doc.mode.value = "act";
			doc.act.value = "cartDel";
			doc.method = "post";
			doc.action = "<?=$PHP_SELF?>";
			doc.submit();
		}
	}

	function goProdView(no)
	{
		var doc = document.form;

		doc.prodCode.value = no;
		doc.mode.value = "view";
		doc.method = "get";
		doc.action = "<?=$PHP_SELF?>";
		doc.submit();
	}

	function goCartAllDel()
	{

		if (!C_isNull(document.form["cartNo[]"]))
		{
			var strSelectNo = C_getCheckedCode(document.form["cartNo[]"]);
			if (C_isNull(strSelectNo))
			{
				alert("<?=$LNG_TRANS_CHAR['OS00018']?>"); //삭제하실 상품을 선택해주세요.
				return;
			}

			var x = confirm("<?=$LNG_TRANS_CHAR['OS00017']?>"); //선택한 상품을 삭제하시겠습니까?
			if (x == true)
			{
				var doc = document.form;

				<?if($strMode == "cartMyList"){?>
				doc.returnMode.value = "cartMyList";
				doc.returnMenu.value = "order";
				<?}?>
				doc.mode.value = "act";
				doc.act.value = "cartAllDel";
				doc.method = "post";
				doc.action = "<?=$PHP_SELF?>";
				doc.submit();
			}
		}
	}

	function goOrderJumun()
	{
		var doc = document.form;

		if (!C_isNull(document.form["cartNo[]"]))
			{
				var strSelectNo = C_getCheckedCode(document.form["cartNo[]"]);
				if (C_isNull(strSelectNo))
				{
					alert("<?=$LNG_TRANS_CHAR['OS00019']?>"); //주문하실 상품을 선택해주세요.
					return;
				}
			}
		if (C_isNull(intM_NO))
		{
			//레이어팝업 로그인 사용시
			<?if($S_MAIN_LAYERPOP_LOGIN_USE=="Y" && $strDevice != "m"){?>

				goLoginLayerpop('order');

			<?}else{?>

			doc.menuType.value = "member";
			doc.mode.value = "login";
			doc.act.value = "";
			doc.returnMenu.value = "order";
			doc.returnMode.value = "cart";
			doc.method = "post";
			doc.action = "<?=$PHP_SELF?>";
			doc.submit();
			<?}?>
			return;
		} else {



				doc.mode.value = "act";
				doc.act.value = "order1";
				doc.method = "post";
				doc.action = "<?=$PHP_SELF?>";
				doc.submit();

		}
	}

	/* 쇼핑계속하기 */
	function goProdList()
	{
		var doc = document.form;

		doc.menuType.value = "product";
		doc.mode.value = "list";
		doc.act.value = "";
		doc.method = "post";
		doc.action = "<?=$PHP_SELF?>";
		doc.submit();
	}


	/* 견적내기 */
	function goOrderEstimate(){
		if (C_isNull(intM_NO))
		{
			var doc = document.form;
			doc.menuType.value = "member";
			doc.mode.value = "login";
			doc.act.value = "";
			doc.returnMenu.value = "order";
			doc.returnMode.value = "cart";
			doc.method = "post";
			doc.action = "<?=$PHP_SELF?>";
			doc.submit();
		} else {

			if (!C_isNull(document.form["cartNo[]"]))
			{
				var strSelectNo = C_getCheckedCode(document.form["cartNo[]"]);
				if (C_isNull(strSelectNo))
				{
					alert("<?=$LNG_TRANS_CHAR['OS00082']?>"); //견적내실 상품을 선택해주세요.
					return;
				}

				window.open('?menuType=etc&mode=popOrderEstiInput','ESTIMATE','width=490px,height=400px,top=300px,left=400px,menubar=no,location=no,scrollbars=no,status=no,resizable=no');
			}

		}
	}

</script>