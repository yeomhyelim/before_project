
<script type="text/javascript">
<!--
	var intMemberNo				= "<?=$g_member_no?>";

	var aryProdOpt				= "";									//json
	var aryProdOptName			= new Array(11);
	var aryProdOptAttr2			= "";									//json
	var aryProdOptAttr			= "";									//json
	var aryProdAddOpt			= "";
	var aryProdAddOptAttr		= "";
	var strProdOptType			= "";									//상품옵션종류
	var strProdCode				= "";
	var aryProdOptList			= "";									//js
	var aryProdAddOptList		= "";
	var strProdAddOptYN			= "N";
	var strProdStockLimit		= "N";									//재고관리함(무제한체크안됨)
	var strProdAllDiscountUse	= "<?=$S_ALL_DISCOUNT_USE?>";			//통합수량할인 사용유무(2014.01.02)
	var aryProdAllDiscount		= "";									//통합수량할인 배열(2014.01.02)

	var intProdQty				= 0;
	var strCartDivId			= 0;									//cartDivid(2013.05.24)
	<?if ($strMode == "view"){?>
		strProdOptType			= "<?=$prodRow[P_OPT]?>";				//상품옵션종류
		strProdCode				= "<?=$strP_CODE?>";					//상품코드
		intProdQty				= "<?=$prodRow[P_QTY]?>";				//상품재고
		strProdStockLimit		= "<?=$prodRow[P_STOCK_LIMIT]?>";
		intProdMinQty			= "<?=($prodRow[P_MIN_QTY])?$prodRow[P_MIN_QTY]:1;?>";
		intProdMaxQty			= "<?=($prodRow[P_MAX_QTY])?$prodRow[P_MAX_QTY]:0;?>";
	<?}?>

	$(document).ready(function(){

		<?if ($strMode == "view"){?>

			strProdAddOptYN = "<?=$prodRow[P_ADD_OPT]?>"; //추가옵션사용유무

			/* 통합수량할인 사용유무 및 */
			<?if ($S_ALL_DISCOUNT_USE == "Y"){?>
			$.getJSON("./?menuType=product&mode=json&act=prodAllDiscount&prodCode="+strProdCode,function(data){
				aryProdAllDiscount = data;
			});
			<?}?>

			/* 다중가격사용(일체형)*/
			$.getJSON("./?menuType=product&mode=json&act=prodOptAttr&prodCode=<?=$strP_CODE?>",function(data){
				aryProdOptAttr = data;
			});

			/* 다중옵션사용 */
			$.getJSON("./?menuType=product&mode=json&act=prodOpt&prodCode=<?=$strP_CODE?>",function(data){
				aryProdOpt = data;
			});

			<?if (is_array($aryProdOpt)){
				?>
				aryProdOptList = new Array(<?=sizeof($aryProdOpt)?>);
				<?
				for($i=0;$i<sizeof($aryProdOpt);$i++){
					?>
					aryProdOptList[<?=$i?>] = <?=$aryProdOpt[$i][PO_NO]?>;
					<?
				}
			  }?>

			/* 추가옵션사용 */
			if (strProdAddOptYN == "Y")
			{
				$.getJSON("./?menuType=product&mode=json&act=prodAddOpt&prodCode=<?=$strP_CODE?>",function(data){
					aryProdAddOpt = data;
				});

				$.getJSON("./?menuType=product&mode=json&act=prodAddOptAttr&prodCode=<?=$strP_CODE?>",function(data){
					aryProdAddOptAttr = data;
				});

				<?if (is_array($aryProdAddOpt)){
					?>
					aryProdAddOptList = new Array(<?=sizeof($aryProdAddOpt)?>);
					<?
					for($i=0;$i<sizeof($aryProdAddOpt);$i++){
						?>
						aryProdAddOptList[<?=$i?>] = <?=$aryProdAddOpt[$i][PO_NO]?>;
						<?
					}
				  }?>
			}

			/* 상품 장바구니 담기시 추가 2013.05.24*/
			$("#btnProdCartOptDel").live("click",function(){

				var intCartNo = $(this).parent().parent().parent().parent().find('input[name="cartOptNo[]"]').val();

				$(this).parent().parent().remove();

				if($("#divCartOptAttr_"+intCartNo).find("tr").length == 0 || C_isNull($("#divCartOptAttr_"+intCartNo).find('input[name="cartOptNo[]"]').val())){
					$("#divCartOptAttr_"+intCartNo).remove();
				}
				
				goSelectProdOptTotalHtml();
			});

			$("#0_cartQty").live("blur",function(){
				goProdQtyInputCall(0);
			});
			/* 상품 장바구니 담기시 추가 2013.05.24*/
		<?}?>


		$('body').on('click','.btnClose , .btnOff',function(){
			$(this).closest('#divPopupAlertWrap').remove();
		});

		$('body').on('click','#viewCartPage',function(){
			document.form.method = 'get';
			document.form.menuType.value = "order";
			document.form.mode.value = "cart";
			document.form.submit();
		});

		$('body').on('click','#viewWishPage',function(){
			document.form.method = 'get';
			document.form.menuType.value = "mypage";
			document.form.mode.value = "wishMyList";
			document.form.submit();
		});

		$('body').on('click', 'a[class*=product_order]' , function() {
			var data		= new Object () ,
				classname	= $(this).attr('class') ,
				gb			= $(this).data('order') ;

			if ( classname.indexOf('poa') != -1 )
				gb += 'D' ;
			//else if ( classname.indexOf('pod') != -1 )
			//	gb = '' ;
			else
				gb += 'A' ;
			data["sort"]	= gb ;
			C_getAddLocationUrl ( data ) ;
		}) ;

		//옵션 초기화. 20150828 남덕희
		$( "select[name^='cartOpt'] option:eq(0)").attr("selected", "selected");

	});

	function goSearchSort(gb) {


	}



// 2014.01.10 kim hee sung - old style
//	function goSearchSort(gb)
//	{
//		var doc = document.form;
//
//		doc.sort.value = gb;
//		doc.method = "get";
//		doc.action = "<?=$PHP_SELF?>";
//		doc.submit();
//	}

	/* 소스 정리중 ... */
	function goProdView(no)
	{
		<?php if($isPriceHide && !$S_PRICE_SHOW_VIEW):?>
		if(!strMemberLogin) {
			alert('<?php echo $LNG_TRANS_CHAR["MS00112"]; // 로그인이 필요합니다.?>');
			return;
		} else {
			alert('<?php echo $LNG_TRANS_CHAR["MS00130"]; // 권한이 없습니다.?>');
			return;
		}
		<?php endif;?>

		<?if($strDevice=="m" || $strDevice=="mobile"){?>
		location.href = "./?menuType=product&mode=view&prodCode="+no;
		<?}else{?>
		var doc 				= document.form;

		doc.prodCode.value 	= no;
		doc.mode.value 		= "view";
		doc.method 			= "get";
		doc.action 				= "<?=$PHP_SELF?>";
		doc.submit();
		<?}?>
	}
	/* 소스 정리중 ... */

	/* 필수사항 체크(2013.05.24) */
	function goNecsssaryCheck()
	{
		var intProdOptErrCnt= 0;
		var intProdOptEssCnt = 0;

		var intProdAddOptErrCnt = 0;
		var intProdAddOptEssCnt = 0;

		var intProdEssCnt	= 0;

		/* 필수사항 체크 여부 */
		if (!C_isNull(aryProdOptList) && aryProdOptList.length > 0)
		{
			for(var i=0;i<aryProdOptList.length;i++){

				var intPO_NO = aryProdOptList[i];
				var strProdOptEssYN = aryProdOpt[intPO_NO].PO_ESS;

				if (strProdOptEssYN == "Y"){
					intProdOptEssCnt++;
				}
			}
		}

		if (strProdAddOptYN == "Y")
		{
			if (!C_isNull(aryProdAddOptList) && aryProdAddOptList.length > 0)
			{
				for(var i=0;i<aryProdAddOptList.length;i++){

					var intPO_NO = aryProdAddOptList[i];
					var strProdAddOptEssYN = aryProdAddOpt[intPO_NO].PO_ESS;

					if (strProdAddOptEssYN == "Y") intProdAddOptEssCnt++;
				}
			}
		}

		$('div[id^="divCartOptAttr_"]').each(function(j){

			intProdOptErrCnt = 0;
			intProdAddOptErrCnt = 0;
			var aryCartOptNo = $(this).attr("id").split("_");
			var intCartOptNo= aryCartOptNo[1];

			$(this).find('input[name="cartOptNo[]"]').each(function(k){
				if ($(this).val() > 0)
				{
					intProdOptErrCnt++;
				};
			});

			$(this).find('input[name^="'+intCartOptNo+'cartAddOptNo_no_"]').each(function(k){
				if (!C_isNull($(this).val()))
				{
					intProdAddOptErrCnt++;
				}
			});

			if (intProdOptErrCnt != intProdOptEssCnt || intProdAddOptErrCnt < intProdAddOptEssCnt  )
			{
				intProdEssCnt++;
			}
		});


		/*품절여부확인*/
		if (("<?=$prodRow[P_STOCK_OUT]?>" == "Y") || ("<?=$prodRow[P_QTY]?>" == 0 && "<?=$prodRow[P_STOCK_LIMIT]?>" != "Y"))
		{
			alert("<?=$LNG_TRANS_CHAR['OS00028']?>"); //선택한 상품은 이미 품절된 상품입니다.
			return false;
		}

		if ($('div[id^="divCartOptAttr_"]').length == 0)intProdEssCnt++; //->옵션선택을 하나도 하지 않았을때...
		if (intProdEssCnt > 0)
		{
			alert("<?=$LNG_TRANS_CHAR['PS00009']?>"); //추가옵션을 하나 이상 선택해주세요.
			if ( $('.bottomOpenClose').hasClass('open') )
				return false ;

			$('.bottomOpenClose').addClass('open');
			$('.bottomViewMenuWrap').css('height','300px').find('.mainProdView').show();
			return false;
		}

		/*
		var intCartQty = $("#cartQty").val();
		if (intCartQty == 0)
		{
			alert("<?=$LNG_TRANS_CHAR['OS00005']?>"); //구매수량은 0 이상 입력하셔야 합니다.
			return false;
		}

		if (strProdStockLimit == "N" || C_isNull(strProdStockLimit))
		{

			var intProdMinQty = (C_isNull("<?=$prodRow[P_MIN_QTY]?>"))? 0 : "<?=$prodRow[P_MIN_QTY]?>";

			if (intProdQty > 0 && intCartQty < intProdMinQty)
			{
				alert("<?=$LNG_TRANS_CHAR['OS00069']?>"); //구매수량은 최소구매수량으로 입력하셔야 합니다.
				return false;
			}
		}
		*/

		<?
		//입력항목사용체크
		if ($S_FIX_PROD_BASIC_ITEM_USE != "Y"){
			if (is_array($aryProdItem)){
				for($i=0;$i<sizeof($aryProdItem);$i++){
					$strProdItemName		= $aryProdItem[$i][PI_NAME];
					$strProdItemType		= (!$aryProdItem[$i][PI_TYPE]) ? "B":$aryProdItem[$i][PI_TYPE];
					$strProdItemId			= "cartAddItem".$aryProdItem[$i][PI_NO];
					$strProdItemErrMsg		= callLangTrans($LNG_TRANS_CHAR["PS00023"],array($strProdItemName));
					if ($strProdItemType != "B"){
						if ($strProdItemType == "C")
						{
							?>
							if ($("input:checkbox[id=<?=$strProdItemId?>]:checked").length == 0)
							{
								alert("<?=$strProdItemErrMsg?>");
								return false;
							}
							<?
						}
						else if ($strProdItemType == "S")
						{
							?>
							if ($("select[name=<?=$strProdItemId?>]") == ""){
								alert("<?=$strProdItemErrMsg?>");
								return false;
							}
							<?
						}
						else if ($strProdItemType == "R")
						{
							?>
							if ($("input:radio[id=<?=$strProdItemId?>]:checked").length == 0){
								alert("<?=$strProdItemErrMsg?>");
								return false;
							}
							<?
						}
						else{
							?>
							if ($("#<?=$strProdItemId?>").val() == ""){
								alert("<?=$strProdItemErrMsg?>");
								return false;
							}
							<?
						}
					}
				}
			}
		}
		?>
		return true;
	}

	function openPopupModal ( $args )
	{

		if ( $args == '' )
			return ;

		if ( $('#divPopupAlertWrap').length > 0  )
			return ;

		var $divWrap = $('<div id="divPopupAlertWrap"></div>') ;
		var html = '<div class="addCartInfoContainer">' +
					'<div class="addCartInfoBox">' +
					'<div class="titPopBox">' +
						'<strong>' + $args['title'] + '</strong>' +
						'<a href="#" class="btnClose"><?=$LNG_TRANS_CHAR['CW00034'];//닫기?></a>' +
						'<div class="clr"></div>' +
					'</div>' +
					'<div class="addInBox">' +
						'<div class="addTxtInfo">' +
							'<ul>' +
								'<li><strong>' + $args['notice'] + '</strong></li>' +
								'<li>' + $args['action_notice'] + '</li>' +
							'</ul>' +
						'</div>' +
						'<div class="btnPopWrap">' +
							'<a href="#" id="'+ $args['action_id'] +'" class="btnOn">' + $args['action_name'] + '</a>' +
							'<a href="#" class="btnOff"><?=$LNG_TRANS_CHAR['CW00034'];//닫기?></a>' +
						'</div>' +
					'</div>' +
				'</div>' +
			'</div>';

		// 모바일과 틀림.
		<?if($strDevice=="m" || $strDevice=="mobile"){?>
		$divWrap.append(html).attr('class','divPopupAlertWrap');//.draggable({ handle:'.titPopBox',cursor: "move"}) ;
		<? } else {?>
		$divWrap.append(html).attr('class','divPopupAlertWrap').find('.addCartInfoContainer').draggable({ handle:'.titPopBox',cursor: "move"}) ;
		<? } ?>
		$divWrap.css('height', $(document).height());
		$('body').append($divWrap) ;
		$('.addCartInfoBox').css("margin-top", Math.max(0, (($(window).height() - $('.addCartInfoBox').outerHeight()) / 2) + $(window).scrollTop()) + "px");
	}

	/* 장바구니 담기(2013.05.24) */
	function goCart()
	{
		<?php if($isPriceHide):?>
		if(!strMemberLogin) {
			alert('<?php echo $LNG_TRANS_CHAR["MS00112"]; // 로그인이 필요합니다.?>');
			return;
		} else {
			alert('<?php echo $LNG_TRANS_CHAR["MS00130"]; // 권한이 없습니다.?>');
			return;
		}
		<?php endif;?>

		/* 필수사항 체크 여부 */
		if (!goNecsssaryCheck()) return;

		var doc = document.form;
		doc.menuType.value = "product";
		doc.mode.value = "json";
		doc.act.value = "cart";
		doc.method = "post";

<?if($S_SHOP_HOME == "demo2"){?>
//		doc.submit();
<?}?>

		var formData = $("#form").serialize();
		C_AjaxPost("cart","./index.php",formData,"post");
	}

	/* 바로 주문하기(2013.05.24) */
	function goCartOrder()
	{
		<?php if($isPriceHide):?>
		if(!strMemberLogin) {
			alert('<?php echo $LNG_TRANS_CHAR["MS00112"]; // 로그인이 필요합니다.?>');
			return;
		} else {
			alert('<?php echo $LNG_TRANS_CHAR["MS00130"]; // 권한이 없습니다.?>');
			return;
		}
		<?php endif;?>

		/* 필수사항 체크 여부 */
		if (!goNecsssaryCheck()) return;

		var doc = document.form;
		doc.menuType.value = "product";
		doc.mode.value = "json";
		doc.act.value = "cartOrder";
		doc.method = "post";

//		if ("<?=$S_SHOP_HOME?>" == "demo2")
//		{
//			doc.submit();
//			return;
//		}
		var formData = $("#form").serialize();
		C_AjaxPost("cartOrder","./index.php",formData,"post");
	}

	/* wish(2013.05.24) */
	function goWish()
	{
		<?php if($isPriceHide):?>
		if(!strMemberLogin) {
			alert('<?php echo $LNG_TRANS_CHAR["MS00112"]; // 로그인이 필요합니다.?>');
			return;
		} else {
			alert('<?php echo $LNG_TRANS_CHAR["MS00130"]; // 권한이 없습니다.?>');
			return;
		}
		<?php endif;?>

		if (C_isNull(intMemberNo))
		{
//			alert("<?=$LNG_TRANS_CHAR['OS00014']?>"); //로그인을 하신 후 이용하세요.
			var doc = document.form;
			doc.menuType.value = "member";
			doc.mode.value = "login";
			doc.submit();
			return;
		}

		/* 필수사항 체크 여부 */
		if (!goNecsssaryCheck()) return;

		var doc = document.form;
		doc.menuType.value = "product";
		doc.mode.value = "json";
		doc.act.value = "cartWish";
		doc.method = "post";
		//doc.submit();

		var formData = $("#form").serialize();
		C_AjaxPost("cartWish","./index.php",formData,"post");
	}

	/* 상품 리스트 이동*/
	function goProdList()
	{
		var doc = document.form;
		doc.mode.value = "list";
		doc.submit();
	}

	/* 2015.01.20 YOO.S.K
	 * 옵션의 길이를 체크해서 리턴한다.
	 */
	function getOptLength ()
	{
		if ( aryProdOptAttr !== undefined )
		{
			for ( var opt in aryProdOptAttr)
			{
				for ( i = 1 ; i <= 10 ; i++ )
					if ( aryProdOptAttr[opt]['POA_ATTR'+i] == '' )
						break ;
				break;
			}
			return i - 1 ;
		}
		return 0 ;
	}

	/* 옵션 선택(2013.05.24) product.script.mobile.php */
	function goSelectProdOpt(selObj,sort)
	{
		var intCartQty			= $("#cartQty").val();
		var arySelProdOpt		= selObj.split("_");
		var intProdOptNo		= arySelProdOpt[1];  //옵션번호
		var intNextSort			= sort + 1;			 //옵션다음순서

		if ($("#"+selObj+" option").length == 1)
		{
			if (aryProdOpt[intProdOptNo].PO_ESS == "Y")
			{
				alert("<?=$LNG_TRANS_CHAR['PS00009']?>"); //위의 필수선택 정보를 선택해주세요.
				return;
			}
		}

/*		if (C_isNull($("#"+selObj).val()))
		{
			$("#realPayPriceText").html(C_toNumberFormatString('<?=$prodRow[P_SALE_PRICE]?>',false)+"원");
			return;
		}
*/
		aryProdOptName[1]	= aryProdOpt[intProdOptNo].PO_NAME1;
		aryProdOptName[2]	= aryProdOpt[intProdOptNo].PO_NAME2;
		aryProdOptName[3]	= aryProdOpt[intProdOptNo].PO_NAME3;
		aryProdOptName[4]	= aryProdOpt[intProdOptNo].PO_NAME4;
		aryProdOptName[5]	= aryProdOpt[intProdOptNo].PO_NAME5;
		aryProdOptName[6]	= aryProdOpt[intProdOptNo].PO_NAME6;
		aryProdOptName[7]	= aryProdOpt[intProdOptNo].PO_NAME7;
		aryProdOptName[8]	= aryProdOpt[intProdOptNo].PO_NAME8;
		aryProdOptName[9]	= aryProdOpt[intProdOptNo].PO_NAME9;
		aryProdOptName[10]	= aryProdOpt[intProdOptNo].PO_NAME10;

		var aryProdOptAttrVal = new Array(11);
		var intProdOptCnt  = 0;
		for(var i=1;i<=10;i++){
			if (aryProdOptName[i])
			{
				intProdOptCnt++;
				var strProdAttrVal = $("#cartOpt"+i+"_"+intProdOptNo+" option:selected").val();
				if (C_isNull(strProdAttrVal))
				{
					strProdAttrVal = "";
				}

				if (i < intNextSort)
				{
					aryProdOptAttrVal[i] = strProdAttrVal;
				} else {
					aryProdOptAttrVal[i] = "";
				}
			} else {
				aryProdOptAttrVal[i] = "";
			}
		}

		var strJsonParam = "&optNo="+intProdOptNo;
		strJsonParam += "&optAttr1="+encodeURIComponent(aryProdOptAttrVal[1]);
		strJsonParam += "&optAttr2="+encodeURIComponent(aryProdOptAttrVal[2]);
		strJsonParam += "&optAttr3="+encodeURIComponent(aryProdOptAttrVal[3]);
		strJsonParam += "&optAttr4="+encodeURIComponent(aryProdOptAttrVal[4]);
		strJsonParam += "&optAttr5="+encodeURIComponent(aryProdOptAttrVal[5]);
		strJsonParam += "&optAttr6="+encodeURIComponent(aryProdOptAttrVal[6]);
		strJsonParam += "&optAttr7="+encodeURIComponent(aryProdOptAttrVal[7]);
		strJsonParam += "&optAttr8="+encodeURIComponent(aryProdOptAttrVal[8]);
		strJsonParam += "&optAttr9="+encodeURIComponent(aryProdOptAttrVal[9]);
		strJsonParam += "&optAttr10="+encodeURIComponent(aryProdOptAttrVal[10]);
		strJsonParam += "&optAttrSort="+intNextSort;
		if (strProdOptType != "2")
		{
			if (!C_isNull(aryProdOptName[intNextSort]))
			{
				$.getJSON("./?menuType=product&mode=json&act=prodOptAttr2"+strJsonParam,function(data){

					$("#cartOpt"+intNextSort+"_"+intProdOptNo).empty().data('options');

					var strSelectIndexText = ":: <?=$LNG_TRANS_CHAR['PW00010']?> ::"; //선택
					if (aryProdOpt[intProdOptNo].PO_ESS == "Y")
					{
						strSelectIndexText = ":: <?=$LNG_TRANS_CHAR['PW00009']?> ::"; //(필수) 선택
					}
					$("#cartOpt"+intNextSort+"_"+intProdOptNo).append("<option value=''>"+strSelectIndexText+"</option>");

					if ( getOptLength () == intNextSort )							// 다음 옵션이 마지막인 경우
						lastFlag = true ;
					for(var i=0;i<data[intProdOptNo][intNextSort].length;i++){
						$('#cartOpt' + intNextSort + '_' + intProdOptNo).append('<option value="' + data[intProdOptNo][intNextSort][i].POA_ATTR + '">' + data[intProdOptNo][intNextSort][i].POA_ATTR + ( lastFlag && '<?=$prodRow['P_STOCK_LIMIT']?>'!= 'Y' ? ' ( ' + data[intProdOptNo][intNextSort][i].POA_STOCK_QTY + 'EA )' : ''  ) + '</option>') ;
					}
				})

				return;
			} else {

				/* 옵션 마지막 선택 */
				if (intProdOptCnt == sort)
				{

					if (!C_isNull(intProdOptNo))
					{
						$.getJSON("./?menuType=product&mode=json&act=prodOptAttrNo"+strJsonParam,function(data){

							if ("<?=$prodRow[P_STOCK_LIMIT]?>" != "Y"){
								if ("<?=$prodRow[P_STOCK_OUT]?>" != "Y" && "<?=$prodRow[P_QTY]?> > 0"){

									var intCartQty = goProdTotalQtyCheck();
									if (intProdMaxQty > 0 && (intCartQty > intProdMaxQty))
									{
										alert("<?=callLangTrans($LNG_TRANS_CHAR['PS00024'],array($prodRow['P_MAX_QTY']))?>");
										return;
									}
									if (parseInt(data[0].POA_STOCK_QTY) < intCartQty)
									{
										alert("<?=$LNG_TRANS_CHAR['OS00029']?>"); //상품의 재고량("+data[0].POA_STOCK_QTY+"개)보다 구매수량이 많습니다.
										return;
									}
								}
							}

							//if (strProdOptType != "1"){

								var strProdOptVal		= "";
								for(var k=1;k<=intProdOptCnt;k++){

									if (k == 1) strProdOptVal += aryProdOpt[data[0].PO_NO].PO_NAME1+":"+data[0].POA_ATTR1;
									if (k == 2) strProdOptVal += aryProdOpt[data[0].PO_NO].PO_NAME2+":"+data[0].POA_ATTR2;
									if (k == 3) strProdOptVal += aryProdOpt[data[0].PO_NO].PO_NAME3+":"+data[0].POA_ATTR3;
									if (k == 4) strProdOptVal += aryProdOpt[data[0].PO_NO].PO_NAME4+":"+data[0].POA_ATTR4;
									if (k == 5) strProdOptVal += aryProdOpt[data[0].PO_NO].PO_NAME5+":"+data[0].POA_ATTR5;
									if (k == 6) strProdOptVal += aryProdOpt[data[0].PO_NO].PO_NAME6+":"+data[0].POA_ATTR6;
									if (k == 7) strProdOptVal += aryProdOpt[data[0].PO_NO].PO_NAME7+":"+data[0].POA_ATTR7;
									if (k == 8) strProdOptVal += aryProdOpt[data[0].PO_NO].PO_NAME8+":"+data[0].POA_ATTR8;
									if (k == 9) strProdOptVal += aryProdOpt[data[0].PO_NO].PO_NAME9+":"+data[0].POA_ATTR9;
									if (k == 10) strProdOptVal += aryProdOpt[data[0].PO_NO].PO_NAME10+":"+data[0].POA_ATTR10;

									if (k != intProdOptCnt) strProdOptVal += "<br>";
								}
							//}
							//strProdOptVal = aryProdOpt[data[0].PO_NO].PO_NAME1+":"+strProdOptVal;
							var intProdOptPrice2 = "";
							<?if($S_ARY_CUR[$S_SITE_LNG]["USD"][2] == "Y"){?>
							var intProdOptPrice = "<?if ($prodRow[P_EVENT] > 0 && getProdEventInfo($prodRow) == 'Y'){?><?=getProdDiscountPrice($prodRow,'1',0,'US')?><?}else{?><?=getCurToPrice($prodRow[P_SALE_PRICE],'US')?><?}?>";
								intProdOptPrice2 = "<?if ($prodRow[P_EVENT] > 0 && getProdEventInfo($prodRow) == 'Y'){?><?=getProdDiscountPrice($prodRow)?><?}else{?><?=getCurToPrice($prodRow[P_SALE_PRICE])?><?}?>";
							<?}else{?>
							var intProdOptPrice = "<?if ($prodRow[P_EVENT] > 0 && getProdEventInfo($prodRow) == 'Y'){?><?=getProdDiscountPrice($prodRow)?><?}else{?><?=getCurToPrice($prodRow[P_SALE_PRICE])?><?}?>";
							<?}?>
							if (strProdOptType != "1"){
								<?if($S_ARY_CUR[$S_SITE_LNG]["USD"][2] == "Y"){?>
								ntProdOptPrice  = data[0].POA_SALE_PRICE_USD;
								intProdOptPrice2 = data[0].POA_SALE_PRICE;
								<?}else{?>
								intProdOptPrice = data[0].POA_SALE_PRICE;
								<?}?>

							}

							goSelectProdOptHtml(data[0].POA_NO,strProdOptVal,intProdOptPrice,intProdOptPrice2);
						});
					}
				}
			}
		} else {

			/* 일체형 수량 체크*/
			var intProdOptAttrNo = $("#"+selObj+" option:selected").val();

			if ("<?=$prodRow[P_STOCK_LIMIT]?>" != "Y"){

				if ( intProdOptAttrNo == '' )
					return ;
				if ("<?=$prodRow[P_STOCK_OUT]?>" != "Y" && "<?=$prodRow[P_QTY]?> > 0"){
					var intCartQty = goProdTotalQtyCheck();
					if (intProdMaxQty > 0 && (intCartQty > intProdMaxQty))
					{
						alert("<?=callLangTrans($LNG_TRANS_CHAR['PS00024'],array($prodRow['P_MAX_QTY']))?>");
						return;
					}
					if ( typeof aryProdOptAttr[intProdOptAttrNo] !== undefined && parseInt(aryProdOptAttr[intProdOptAttrNo].POA_STOCK_QTY) < intCartQty)
					{
						alert("<?=$LNG_TRANS_CHAR['OS00029']?>");
						return;
					}
				}
			}


			var strProdOptVal = "";
			if ( intProdOptAttrNo != '' && typeof aryProdOptAttr[intProdOptAttrNo] !== undefined )
			{
				for ( var k = 1 ; k <= 10 ; k++ )
					strProdOptVal += (aryProdOptAttr[intProdOptAttrNo]['POA_ATTR' + k]) ? aryProdOptAttr[intProdOptAttrNo]['PO_NAME' + k] + ":" + aryProdOptAttr[intProdOptAttrNo]['POA_ATTR' + k] : "";

				/* 스크립트 호출 */
				var strProdOptValHtml = "<input type=\"text\" name=\""+intProdOptNo+"_cartOptVal1\" value=\""+aryProdOptAttr[intProdOptAttrNo].POA_ATTR1+"\">";
				<?if($S_ARY_CUR[$S_SITE_LNG]["USD"][2] == "Y"){?>
				goSelectProdOptHtml(intProdOptAttrNo,strProdOptVal,aryProdOptAttr[intProdOptAttrNo].POA_SALE_PRICE_USD,aryProdOptAttr[intProdOptAttrNo].POA_SALE_PRICE);
				<?}else{?>
				goSelectProdOptHtml(intProdOptAttrNo,strProdOptVal,aryProdOptAttr[intProdOptAttrNo].POA_SALE_PRICE,0);
				<?}?>
			}
		}

	}

	/* 상품 옵션 클릭시 담기(2013.05.24) */
	function goSelectProdOptHtml(optNo,optVal,optPrice,optPrice2)
	{
		/* 옵션 중복체크 */
		var intCartOptNoDupCnt = 0;
		$('input[name="cartOptNo[]"]').each(function(i){
			if ($(this).val() == optNo)
			{
				intCartOptNoDupCnt++;
			};
		});

		if (intCartOptNoDupCnt > 0)
		{
			strCartDivId = "divCartOptAttr_"+optNo;
			return;
		}
		/* 옵션 중복체크 */

		/* 추가옵션 재정리 */
		if (strProdAddOptYN == "Y" && optNo>0)
		{
			if (!C_isNull(aryProdAddOptList) && aryProdAddOptList.length > 0)
			{
				for(var i=0;i<aryProdAddOptList.length;i++){
					$("#cartAddOpt_"+aryProdAddOptList[i]).val("");
				}
			}
		}
		/* 추가옵션 재정리 */

		var strUpCountImg		= "";
		var strDownCountImg		= "";
		var strProdCartDelImg	= "<img src=\"../himg/product/A0001/btn_opt_del.gif\"/>";
		if ("<?=$strDevice?>" == "m")
		{
			strUpCountImg		= "<span>+</span>";
			strDownCountImg		= "<span>-</span>";
			strProdCartDelImg	= "[x]";
		}

		var strSelectProdOptHtml = "<div id=\"divCartOptAttr_"+optNo+"\" class=\"optionWrap\">";
		strSelectProdOptHtml += "<ul>";

		if (!C_isNull(optNo))
		{
			strSelectProdOptHtml += "<input type=\"hidden\" name=\"cartOptNo[]\" value=\""+optNo+"\">";
			strSelectProdOptHtml += "<input type=\"hidden\" name=\""+optNo+"_cartOptPrice\" id=\""+optNo+"_cartOptPrice\" value=\""+optPrice+"\">";
			strSelectProdOptHtml += "<input type=\"hidden\" name=\""+optNo+"_cartOptOrgPrice\" id=\""+optNo+"_cartOptOrgPrice\" value=\""+optPrice2+"\">";
		}
		
		strSelectProdOptHtml += "    <li class=\"optTitle\">"+optVal+"</li>";
		strSelectProdOptHtml += "            <li class=\"cntInputWrap\">";
			strSelectProdOptHtml += " &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;";
		strSelectProdOptHtml += "                <a href=\"javascript:goProdViewQtyChange("+optNo+",'down',1);\" class=\"down\"><span>-</span></a>";
		strSelectProdOptHtml += "                <input type=\"text\" id=\""+optNo+"_cartQty\" name=\""+optNo+"_cartQty\" value=\"<?=$prodRow[P_MIN_QTY]?>\" class=\"cntInputForm _w30\"/> ";
		strSelectProdOptHtml += "                <a href=\"javascript:goProdViewQtyChange("+optNo+",'up',1);\" class=\"up\"><span>+</span></a>";
		strSelectProdOptHtml += "            </li>";

		<?if($S_ARY_CUR[$S_SITE_LNG]["USD"][2] == "Y"){?>
			strSelectProdOptHtml += "    <li class=\"optPrice\"><?=getCurMark('USD')?> <strong id=\""+optNo+"_cartOptPriceMark\">"+optPrice+"</strong><?=getCurMark2('USD')?>(<?=$S_SITE_CUR_MARK1?><span id=\""+optNo+"_cartOptOrgPriceMark\">"+optPrice2+"</span>)";
		<?}else{?>
			strSelectProdOptHtml += "    <li class=\"optPrice\"><?=getCurMark()?> <strong id=\""+optNo+"_cartOptPriceMark\">"+optPrice+"</strong><?=$strTextPriceUnit?>";
		<?}?>
		strSelectProdOptHtml += "    <a id=\"btnProdCartOptDel\" class=\"cntDel\">"+strProdCartDelImg+"</a></li>";
		strSelectProdOptHtml += "</ul>";
		strSelectProdOptHtml += "</div>";

		$("#divSelectOpt").append(strSelectProdOptHtml);
		$("#"+optNo+"_cartOptPriceMark").formatCurrency({symbol: ''<?=($S_SITE_CUR=='KRW' || $S_SITE_CUR=='JPY' || $S_SITE_CUR=='RUB')?",roundToDecimalPlace:0":"";?>});
		$("#"+optNo+"_cartOptPrice").formatCurrency({symbol: ''<?=($S_SITE_CUR=='KRW' || $S_SITE_CUR=='JPY' || $S_SITE_CUR=='RUB')?",roundToDecimalPlace:0":"";?>});

		$("#"+optNo+"_cartQty").live("blur",function(){
			goProdQtyInputCall(optNo);
		});

		strCartDivId = $('div[id^="divCartOptAttr_"]').filter(":last").attr("id");
		goSelectProdOptTotalHtml();
	}

	/* 총 상품금액 표시 */
	function goSelectProdOptTotalHtml()
	{
		var intCartOptPriceTotal	= 0;
		var intCartOptOrgPriceTotal = 0;
		$('div[id^="divCartOptAttr_"]').each(function(i){
			var intCartOptNo				= 0;	//옵션번호
			var intCartOptPrice				= 0;	//옵션가격
			var intCartOptQty				= 0;	//옵션수량
			var intCartOptDiscountPrice		= 0;	//옵션별할인가격
			var intCartOptDiscountUsdPrice	= 0;	//옵션별할인가격(USD)
			var intCartOptDiscountRate		= 0;	//옵션별할인가격(%)
			var intCartAddOptPrice			= 0;	//추가옵션가격
			var intCartOptOrgPrice			= 0;	//옵션별가격(USD)
			var intCartAddOptOrgPrice		= 0;	//추가옵션별가격(USD)

			$(this).find('input[name="cartOptNo[]"]').each(function(j){
				intCartOptNo			= $(this).val();
				intCartOptQty			= parseInt($("#"+intCartOptNo+"_cartQty").val());

				/* 통합수량할인 사용유무에 따라서 가격 할인금액에 따라 discount start(2014.01.02)*/
				if (strProdAllDiscountUse == "Y")
				{
					for(var jj = 0;jj<aryProdAllDiscount.length;jj++){
						var intDiscountMinQty	= parseInt(aryProdAllDiscount[jj].MIN_QTY);																//최소수량
						var intDiscountMaxQty	= parseInt((aryProdAllDiscount[jj].MAX_QTY) ? aryProdAllDiscount[jj].MAX_QTY : 999999999999);				//최대수량
						//var intDiscountPrice	= aryProdAllDiscount[jj].DISCOUNT_PRICE;														//할인가격
						//var intDiscountUsdPrice	= aryProdAllDiscount[jj].DISCOUNT_USD_PRICE;													//할인가격(USD)
						var intDiscountRate		= aryProdAllDiscount[jj].DISCOUNT_RATE;

						if (intCartOptQty >= intDiscountMinQty && intCartOptQty <= intDiscountMaxQty)
						{
							//intCartOptDiscountPrice		= intDiscountPrice;
							//intCartOptDiscountUsdPrice	= intDiscountUsdPrice;
							intCartOptDiscountRate			= parseInt(intDiscountRate);
							break;
						}
					}
				}
				/* 통합수량할인 사용유무에 따라서 가격 할인금액에 따라 discount end(2014.01.02)*/

				if (intCartOptDiscountRate > 0)
				{

					var intCartOptDiscountPos	= 2;
					<? if ($S_SITE_CUR=='KRW' || $S_SITE_CUR=='JPY' || $S_SITE_CUR=='RUB'){?>
						intCartOptDiscountPos	= 0;
					<?}?>

					intCartOptDiscountPrice		=  C_getCeiling(parseFloat(C_removeComma($("#"+intCartOptNo+"_cartOptPrice").val(),true)) * (intCartOptDiscountRate/100),intCartOptDiscountPos);
					intCartOptDiscountUsdPrice	=  C_getCeiling(parseFloat(C_removeComma($("#"+intCartOptNo+"_cartOptOrgPrice").val(),true)) * (intCartOptDiscountRate/100),intCartOptDiscountPos);
				}

				intCartOptPrice			= intCartOptQty * (parseFloat(C_removeComma($("#"+intCartOptNo+"_cartOptPrice").val(),true)) - intCartOptDiscountPrice);
				intCartOptPriceTotal   += intCartOptPrice;

				<?if($S_ARY_CUR[$S_SITE_LNG]["USD"][2] == "Y"){?>
				intCartOptOrgPrice		 = intCartOptQty * (parseFloat(C_removeComma($("#"+intCartOptNo+"_cartOptOrgPrice").val(),true)) - intCartOptDiscountUsdPrice);
				intCartOptOrgPriceTotal += intCartOptOrgPrice;
				<?}?>
			});

			$(this).find('input[name^="'+intCartOptNo+'cartAddOptNo_no_"]').each(function(k){

				var aryCartAddOptNo  = $(this).attr("id").split("_");
				var aryCartAddOptNo2 = aryCartAddOptNo[2].split("[]");
				var intCartAddOptNo	= aryCartAddOptNo2[0];

				intCartAddOptPrice	+= parseInt($("input[name^='"+intCartOptNo+"cartAddOptNo_qty_']").eq(k).val()) * parseFloat(C_removeComma($("input[name^='"+intCartOptNo+"cartAddOptNo_price_']").eq(k).val(),true));

				intCartAddOptOrgPrice += parseInt($("input[name^='"+intCartOptNo+"cartAddOptNo_qty_']").eq(k).val()) * parseFloat(C_removeComma($("input[name^='"+intCartOptNo+"cartAddOptNoOrg_price_']").eq(k).val(),true));

			});

			var intCartPrice		= intCartOptPrice + intCartAddOptPrice;
			var intCartOrgPrice		= intCartOptOrgPrice + intCartAddOptOrgPrice;

			intCartOptPriceTotal += intCartAddOptPrice;
			intCartOptOrgPriceTotal += intCartAddOptOrgPrice;

			$(this).find("tr:eq(0) > td:eq(2) > strong").text(intCartPrice);
			$(this).find("tr:eq(0) > td:eq(2) > strong").formatCurrency({symbol: ''<?=($S_SITE_CUR=='KRW' || $S_SITE_CUR=='JPY' || $S_SITE_CUR=='RUB')?",roundToDecimalPlace:0":"";?>});

			$(this).find("tr:eq(0) > td:eq(2) > span").text(intCartOrgPrice);
			$(this).find("tr:eq(0) > td:eq(2) > span").formatCurrency({symbol: ''<?=($S_SITE_CUR=='KRW' || $S_SITE_CUR=='JPY' || $S_SITE_CUR=='RUB')?",roundToDecimalPlace:0":"";?>});

		});

		var strSelectProdOptTotalPriceHtml	= "";
		$("#divSelectOptTotalPrice").html("");
		if (intCartOptPriceTotal > 0)
		{

			
			<?if($S_ARY_CUR[$S_SITE_LNG]["USD"][2] == "Y"){?>
			strSelectProdOptTotalPriceHtml += "<table class=\"infoTable\">";
			strSelectProdOptTotalPriceHtml += "<tbody>";
			strSelectProdOptTotalPriceHtml += "<tr>";
			strSelectProdOptTotalPriceHtml += "<td>";
			strSelectProdOptTotalPriceHtml += "<?=$LNG_TRANS_CHAR['PW00042'];?>:";
			strSelectProdOptTotalPriceHtml += "<strong class=\"totalPriceTxt\"><?=getCurMark('USD');?></strong>  <strong id=\"cartOptTotalPrice\" class=\"totalPrice\">"+intCartOptPriceTotal+"</strong><strong class=\"totalPriceTxt\"><?=getCurMark2('USD')?></strong>";
			strSelectProdOptTotalPriceHtml += "<span class=\"totalPriceBold\">(<?=$S_SITE_CUR_MARK1?><span id=\"cartOptOrgTotalPrice\">"+intCartOptOrgPriceTotal+"</span>)</span>";
			strSelectProdOptTotalPriceHtml += "</td>";
			strSelectProdOptTotalPriceHtml += "</tr>";
			strSelectProdOptTotalPriceHtml += "</tbody>";
			strSelectProdOptTotalPriceHtml += "</table>";

			<?}else{?>
				strSelectProdOptTotalPriceHtml += "<table class=\"infoTable\">";
			strSelectProdOptTotalPriceHtml += "<tbody>";
			strSelectProdOptTotalPriceHtml += "<th><?=$LNG_TRANS_CHAR['PW00042'];?></th>";
			strSelectProdOptTotalPriceHtml += "<td>";
			strSelectProdOptTotalPriceHtml += "<strong class=\"totalPriceTxt\"><?=getCurMark()?></strong>  <strong id=\"cartOptTotalPrice\" class=\"totalPrice\">"+intCartOptPriceTotal+"</strong><strong class=\"totalPriceTxt\"><?=$strTextPriceUnit?></strong>";
			strSelectProdOptTotalPriceHtml += "</td>";
			strSelectProdOptTotalPriceHtml += "</tr>";
			strSelectProdOptTotalPriceHtml += "</tbody>";
			strSelectProdOptTotalPriceHtml += "</table>";
			<?}?>
				
			$("#divSelectOptTotalPrice").html(strSelectProdOptTotalPriceHtml);
			$("#cartOptTotalPrice").formatCurrency({symbol: ''<?=($S_SITE_CUR=='KRW' || $S_SITE_CUR=='JPY' || $S_SITE_CUR=='RUB')?",roundToDecimalPlace:0":"";?>});
			$("#cartOptOrgTotalPrice").formatCurrency({symbol: ''<?=($S_SITE_CUR=='KRW' || $S_SITE_CUR=='JPY' || $S_SITE_CUR=='RUB')?",roundToDecimalPlace:0":"";?>});

		} else {
			$('select[id^="cartOpt"]').val("");
			$('select[id^="cartAddOpt"]').val("");
		}
	}

	function goSelectProdAddOpt(selObj,no){

		if (strProdAddOptYN == "Y")
		{
			/* 옵션 필수사항 체크 */
			var intProdOptEssCnt = 0;
			var intProdOptErrCnt = 0;
			if (!C_isNull(aryProdOptList) && aryProdOptList.length > 0)
			{
				for(var i=0;i<aryProdOptList.length;i++){

					var intPO_NO = aryProdOptList[i];
					var strProdOptEssYN = aryProdOpt[intPO_NO].PO_ESS;

					if (strProdOptEssYN == "Y"){
						intProdOptEssCnt++;
					}

					$('div[id^="divCartOptAttr_"]').each(function(j){
						intProdOptErrCnt = 0;
						$(this).find('input[name="cartOptNo[]"]').each(function(k){
							if ($(this).val() > 0)
							{
								intProdOptErrCnt++;
							};
						});
					});
				}

				if (intProdOptEssCnt != intProdOptErrCnt)
				{
					if (!C_isNull(aryProdAddOptList) && aryProdAddOptList.length > 0)
					{
						$("#cartAddOpt_"+no).val("");
					}
					alert("<?=$LNG_TRANS_CHAR['PS00009']?>"); //추가옵션을 하나 이상 선택해주세요.
					return;
				}
			}
			/* 옵션 필수사항 체크 */

			if (!C_isNull(aryProdAddOptList) && aryProdAddOptList.length > 0)
			{
				var intProdAddOptEssCnt = 0;
				for(var i=0;i<aryProdAddOptList.length;i++){

					var intPO_NO = aryProdAddOptList[i];
					var strProdAddOptEssYN = aryProdAddOpt[intPO_NO].PO_ESS;

					//if (strProdAddOptEssYN == "Y")
					//{
						if ($("#cartAddOpt_"+intPO_NO+" option:selected").val() && intPO_NO == no)
						{
							var intPAO_NO	= $("#cartAddOpt_"+intPO_NO+" option:selected").val();
							var strPAO_TEXT = $("#cartAddOpt_"+intPO_NO+" option:selected").text();


							if ($('div[id^="divCartOptAttr_"]').length == 0)
							{
								goSelectProdOptHtml(0,"구매수량","<?if ($prodRow[P_EVENT] > 0 && getProdEventInfo($prodRow) == 'Y'){?><?=getCurToPrice($prodRow[P_SALE_PRICE])?><?}else{?><?=getProdDiscountPrice($prodRow)?><?}?>");
							}

							if (!strCartDivId)
							{
								strCartDivId = $('div[id^="divCartOptAttr_"]').filter(":last").attr("id");
							}

							$('div[id^="divCartOptAttr_"]').each(function(i){

								var aryCartOptNo = $(this).attr("id").split("_");
								var intCartOptNo= aryCartOptNo[1];
								var intCartAddOptIsCnt = 0;

								$(this).find("input[name^='"+intCartOptNo+"cartAddOptNo_no_"+intPO_NO+"[]']").each(function(n){

									if ($(this).val() == intPAO_NO)
									{
										intCartAddOptIsCnt++;
									}
								});

								if (strCartDivId == $(this).attr("id") && intCartAddOptIsCnt == 0)
								{
									var strUpCountImg		= "";
									var strDownCountImg		= "";
									var strProdCartDelImg	= "<img src=\"../himg/product/A0001/btn_opt_del.gif\"/>";

									if ("<?=$strDevice?>" == "m")
									{
										strUpCountImg		= "<span>+</span>";
										strDownCountImg		= "<span>-</span>";
										strProdCartDelImg	= "[x]";
									}

									var strSelectProdOptHtml = "";
									strSelectProdOptHtml += "<ul>";

									strSelectProdOptHtml += "<input type=\"hidden\" name=\""+intCartOptNo+"cartAddOptNo_no_"+intPO_NO+"[]\"  id=\""+intCartOptNo+"cartAddOptNo_no_"+intPO_NO+"[]\" value=\""+intPAO_NO+"\">";

									<?if($S_ARY_CUR[$S_SITE_LNG]["USD"][2] == "Y"){?>
									strSelectProdOptHtml += "<input type=\"hidden\" name=\""+intCartOptNo+"cartAddOptNo_price_"+intPO_NO+"[]\" id=\""+intCartOptNo+"cartAddOptNo_price_"+intPO_NO+"[]\" value=\""+aryProdAddOptAttr[intPAO_NO].PAO_PRICE_USD+"\">";

									strSelectProdOptHtml += "<input type=\"hidden\" name=\""+intCartOptNo+"cartAddOptNoOrg_price_"+intPO_NO+"[]\" id=\""+intCartOptNo+"cartAddOptNoOrg_price_"+intPO_NO+"[]\" value=\""+aryProdAddOptAttr[intPAO_NO].PAO_PRICE+"\">";
									<?}else{?>
									strSelectProdOptHtml += "<input type=\"hidden\" name=\""+intCartOptNo+"cartAddOptNo_price_"+intPO_NO+"[]\" id=\""+intCartOptNo+"cartAddOptNo_price_"+intPO_NO+"[]\" value=\""+aryProdAddOptAttr[intPAO_NO].PAO_PRICE+"\">";

									strSelectProdOptHtml += "<input type=\"hidden\" name=\""+intCartOptNo+"cartAddOptNoOrg_price_"+intPO_NO+"[]\" id=\""+intCartOptNo+"cartAddOptNoOrg_price_"+intPO_NO+"[]\" value=\"0\">";
									<?}?>

									strSelectProdOptHtml += "    <li class=\"optTitle\">"+strPAO_TEXT+"</li>";
									strSelectProdOptHtml += "        <li class=\"cntInputWrap\">";
									strSelectProdOptHtml += "                <a href=\"javascript:goProdViewQtyChange("+intPO_NO+",'add_down',1,"+intCartOptNo+","+intPAO_NO+");\"><span class=\"down\">-</span></a>";
									strSelectProdOptHtml += "                <input type=\"text\" id=\""+intCartOptNo+"cartAddOptNo_qty_"+intPO_NO+"[]\" name=\""+intCartOptNo+"cartAddOptNo_qty_"+intPO_NO+"[]\" value=\"<?=$prodRow[P_MIN_QTY]?>\" class=\"cntInputForm _w30\"/> ";
									strSelectProdOptHtml += "                <a href=\"javascript:goProdViewQtyChange("+intPO_NO+",'add_up',1,"+intCartOptNo+","+intPAO_NO+");\"><span class=\"plus\">+</span></a>";
									strSelectProdOptHtml += "            </li>";

									strSelectProdOptHtml += "    <li class=\"mngProd\"><a id=\"btnProdCartOptDel\" class=\"cntDel\">"+strProdCartDelImg+"</a></li>";
									strSelectProdOptHtml += "</ul>";

									$(this).find("table:eq(0)").append(strSelectProdOptHtml);

									$("input[id^='"+intCartOptNo+"cartAddOptNo_price_"+intPO_NO+"']").formatCurrency({symbol: ''<?=($S_SITE_CUR=='KRW' || $S_SITE_CUR=='JPY' || $S_SITE_CUR=='RUB')?",roundToDecimalPlace:0":"";?>});

									$(this).find("input[id='"+intCartOptNo+"cartAddOptNo_qty_"+intPO_NO+"[]']").live("blur",function(){
										goProdViewQtyChange(intPO_NO,"add",1,intCartOptNo,intPAO_NO);
									});

									/* rowspan */
									if($(this).find("tr:eq(0) > td:eq(2)").attr("rowspan")){
										$(this).find("tr:eq(0) > td:eq(2)").attr("rowspan","");
									}

									if ($(this).find("tr").length > 1)
									{
										$(this).find("tr:eq(0) > td:eq(2)").attr("rowspan",$(this).find("tr").length );
									}
									/* rowspan */
								}
							});

							goSelectProdOptTotalHtml();
						}
					//}
				}
			}
		}
	}

	/* 상품 옵션 클릭시 담기(2013.05.24) */

	/* 상품 상세 보기에서 up,down */
	function goProdViewQtyChange(optNo,type,prodMinQty,cartNo,cartAddOptNo)
	{
		if (C_isNull(cartNo)) cartNo = 0;
		if (C_isNull(cartAddOptNo)) cartAddOptNo = 0;

		var intProdQrgQty = 0;
		if (type == "add_up" || type == "add_down" || type == "add")
		{
			var intAddOptPos = 0;
			$("#divCartOptAttr_"+cartNo).find('input[name^="'+cartNo+'cartAddOptNo_no_"]').each(function(k){

				if ($(this).val() == cartAddOptNo)
				{
					intAddOptPos = k;
				}
				/*if ($(this).attr("id") == cartNo+"cartAddOptNo_no_"+optNo+"[]")
				{
					intAddOptPos = k;
				}*/
			});

			intProdQty = parseInt($("#divCartOptAttr_"+cartNo).find("input[name^='"+cartNo+"cartAddOptNo_qty_']").eq(intAddOptPos).val());
			//var intProdQty = parseInt($("#divCartOptAttr_"+cartNo).find("input[name='"+cartNo+"cartAddOptNo_qty_"+optNo+"[]'").val());
		} else {
			intProdQty = parseInt($("#"+optNo+"_cartQty").val());
		}

		intProdQrgQty = intProdQty;
		if ((optNo > 0 || !C_isNull(type)) && (type != "add"))
		{
			if (type == "up" || type == "add_up")
			{
				intProdQty++;

				if (type == "up")
				{
					var intCartQty = goProdTotalQtyCheck();
					if (intProdMaxQty > 0 && (intCartQty > intProdMaxQty))
					{
						alert("<?=callLangTrans($LNG_TRANS_CHAR['PS00024'],array($prodRow['P_MAX_QTY']))?>");
						return;
					}
				}

			} else if (type != ""){
				intProdQty--;
			}
		}

		if (intProdQty < prodMinQty)
		{
			intProdQty = prodMinQty;
		}

		if (type != "add_up" && type != "add_down" && type != "add") {
			$("#"+optNo+"_cartQty").val(intProdQty);
			var intCartOptPrice = intProdQty * parseFloat(C_removeComma($("#"+optNo+"_cartOptPrice").val(),true));
			$("#"+optNo+"_cartOptPriceMark").text(intCartOptPrice);
			$("#"+optNo+"_cartOptPriceMark").formatCurrency({symbol: ''<?=($S_SITE_CUR=='KRW' || $S_SITE_CUR=='JPY')?",roundToDecimalPlace:0":"";?>});
			$("#"+optNo+"_cartOptPrice").formatCurrency({symbol: ''<?=($S_SITE_CUR=='KRW' || $S_SITE_CUR=='JPY')?",roundToDecimalPlace:0":"";?>});
		} else {

			$("#divCartOptAttr_"+cartNo).find("input[name^='"+cartNo+"cartAddOptNo_qty_']").eq(intAddOptPos).val(intProdQty);

			//$("#"+cartNo+"cartAddOptNo_qty_"+optNo).val(intProdQty);

		}

		goSelectProdOptTotalHtml();
	}

	/* 상품당 전체 갯수 확인 */
	function goProdTotalQtyCheck()
	{
		var intProdTotalQty				= 0;
		$('div[id^="divCartOptAttr_"]').each(function(i){
			$(this).find('input[name="cartOptNo[]"]').each(function(j){
				var intCartOptNo		= $(this).val();
				var intCartOptQty		= parseInt($("#"+intCartOptNo+"_cartQty").val());
				intProdTotalQty			= intProdTotalQty + intCartOptQty;
			});
		});

		if (intProdTotalQty == 0) intProdTotalQty = parseInt(intProdMinQty);
		else intProdTotalQty = intProdTotalQty + parseInt(intProdMinQty);
		return intProdTotalQty;
	}

	/* 수량 input box 변경시 호출 */
	function goProdQtyInputCall(optNo)
	{
		var intQty						= parseInt($("#"+optNo+"_cartQty").val());
		var intProdTotalQty				= 0;
		$('div[id^="divCartOptAttr_"]').each(function(i){
			$(this).find('input[name="cartOptNo[]"]').each(function(j){
				var intCartOptNo		= $(this).val();
				var intCartOptQty		= parseInt($("#"+intCartOptNo+"_cartQty").val());
				intProdTotalQty			= intProdTotalQty + intCartOptQty;
			});
		});

		if (intQty < parseInt(intProdMinQty))
		{
			alert("<?=callLangTrans($LNG_TRANS_CHAR['PS00020'],array($prodRow['P_MIN_QTY']))?>");
			$("#"+optNo+"_cartQty").val(intProdMinQty);
		}

		if (intProdMaxQty > 0 && (intProdTotalQty > intProdMaxQty))
		{
			alert("<?=callLangTrans($LNG_TRANS_CHAR['PS00021'],array($prodRow['P_MAX_QTY']))?>");
			intQty = (intProdMaxQty - (intProdTotalQty - intQty));
			$("#"+optNo+"_cartQty").val(intQty);
		}
		goSelectProdOptTotalHtml();
	}

	function goAjaxRet(name,result) {

		var doc = document.form;
		var data = eval(result);
		var $args = {} ;

		if (name == "cartOrder")
		{
			if (data[0].RET == "Y")
			{
				$("#divSelectOpt").append(data[0].HTML);

				<?if ($g_member_no){?>
				doc.menuType.value = "order";
				doc.mode.value = "order";
				doc.submit();
				<?}else{?>
				doc.menuType.value = "member";
				doc.mode.value = "login";
				doc.submit();
				<?}?>
			} else {
				alert(data[0].MSG);
				return;
			}
		}
		else if (name == "cartWish")
		{
			if (data[0].RET == "Y")
			{
				//$args['title']			= '<?=$LNG_TRANS_CHAR['OW00120']?>' ;//관심상품 등록
				//$args['notice']			= '<?=$LNG_TRANS_CHAR['OS00089']?>' ;//선택하신 상품을 관심상품 목록에 넣었습니다.
				//$args['action_notice']	= '<?=$LNG_TRANS_CHAR['PS00016']?>' ;//담아두기 페이지로 이동하시겠습니까?
				//$args['action_id']		= 'viewWishPage' ;
				//$args['action_name']	= '<?=$LNG_TRANS_CHAR['OW00119']?>' ;//관심상품 보기
				//openPopupModal ( $args ) ;
				//alert로 수정 2015.05.22 kjp
				if(confirm("<?=$LNG_TRANS_CHAR['OS00089']?>\n<?=$LNG_TRANS_CHAR['PS00016']?>"))
				{
					document.form.method = 'get';
					document.form.menuType.value = "mypage";
					document.form.mode.value = "wishMyList";
					document.form.submit();
				}



			/*
				var x = confirm("<?=$LNG_TRANS_CHAR['PS00016']?>");

				if (x == true)
				{
					doc.menuType.value = "order";
					doc.mode.value = "cart";
					doc.submit();
				}
			*/
			} else {
				alert(data[0].MSG);
				return;
			}

		}
		else if (name == "cart")
		{
			if (data[0].RET == "Y")
			{
				if ("<?=$S_FIX_PRODUCT_CART_POP_USE?>" == "Y")
				{

					$("#divCartPopup").html(data[0].POP_HTML);
					$("#divCartPopup").css("display","");

					if ("<?=$S_FIX_ORDER_TOTAL_DISCOUNT_USE?>" == "Y"){
						$("#divOrderTotalDiscountWrap").css("display","");
						$("#divOrderTotalDiscount").html(data[0].ORDER_TOTAL_DISCOUNT_HTML);
					}

					$("#divCartPopup").trigger('mouseleave');

				} else {
					//$args['title']			= '<?=$LNG_TRANS_CHAR['OW00121']?>' ;//장바구니 담기
					//$args['notice']			= '<?=$LNG_TRANS_CHAR['OS00090']?>' ;//선택하신 상품이 장바구니에 담겼습니다.
					//$args['action_notice']	= '<?=$LNG_TRANS_CHAR['OS00013']?>' ;//장바구니 페이지로 이동하시겠습니까?
					//$args['action_id']		= 'viewCartPage' ;
					//$args['action_name']	= '<?=$LNG_TRANS_CHAR['OW00122']?>' ;//장바구니 보기
					//openPopupModal ( $args ) ;
					//alert로 수정 2015.05.22 kjp
					if(confirm("<?=$LNG_TRANS_CHAR['OS00090']?>\n<?=$LNG_TRANS_CHAR['OS00013']?>"))
					{
							document.form.method = 'get';
							document.form.menuType.value = "mypage";
							document.form.mode.value = "cartMyList";
							document.form.submit();
					}

					/*
					var x = confirm("<?=$LNG_TRANS_CHAR['OS00013']?>");
					if (x == true)
					{
						doc.menuType.value = "order";
						doc.mode.value = "cart";
						doc.submit();
					}
					*/
				}
			} else {
				alert(data[0].MSG);
				return;
			}
		}
		else if (name == "popCartDel")
		{
			/* 팝업 장바구니에서 상품 삭제 */
			$("#divCartPopup").html(data[0].POP_HTML);
			$("#divCartPopup").css("display","");
		}

		else if (name == "prodLikeUpdate")
		{
			/* 좋아요 상품 */
			if (data[0].RET == "Y"){
				var prodLikeObj = $("#span_"+data[0].P_CODE);
				prodLikeObj.removeClass("ico_like");
				prodLikeObj.removeClass("ico_likeH");
				if (data[0].LIKE_TYPE == "Y") {
					prodLikeObj.addClass("ico_likeH");
				} else {
					prodLikeObj.addClass("ico_like");
				}
				return;
			} else {

				if (data[0].MSG == 'NO_MEMBER_LOGIN')
				{
					alert("<?=$LNG_TRANS_CHAR['OS00014']?>");
					return;
				}

				if (data[0].MSG == 'QUERY_ERROR')
				{
					alert("<?=$LNG_TRANS_CHAR['MS00029']?>");
					return;
				}
			}
		}
	}
	/* ----------------- 2013.05.24 ------------------------ */

	/* 작은 이미지 클릭시, 큰이미지로 변경 */
	/* 달링카 상품 메인 페이지 */
	function goChagneImage(url) {
		$("#mainImage").attr("src", url);
	}

	/* 문자상담하기 버튼 클릭시 문자 전송*/
	function goSendSMS() {
		var hp = document.form.hp1.value + "-"  + document.form.hp2.value + "-" + document.form.hp3.value;
		var strJsonParam = "menuType=<?=$strMenuType?>&mode=json&act=sendSMS&hp=" + hp;

		$.ajax({
			type:"POST",
			url:"./index.php",
			data :strJsonParam,
			dataType:"json",
			success:function(data){
				alert(data[0].RET);
			}
		});
	}






	/* 2012.08.04 -- KIM HEE-SUNG -- REVIEW Function */



	function goScriptClick(pCode, bCode, page, bNo, act)
	{
		mode = "";
		switch (bCode) {
		case "<?=$D_PRODUCT_BCODE_01?>":
			mode = "prodReview";
		break;
		case "<?=$D_PRODUCT_BCODE_02?>":
			mode = "prodQA";
		break;
		}

		switch (act) {
		case "write":
			url = "./?menuType=board&mode="+mode+"&act=write&pCode="+pCode+"&bCode="+bCode+"&page="+page;
			C_openWindow(url, "글쓰기", 700, 550);
		break;
		case "modify":
			url = "./?menuType=etc&mode="+mode+"&act=modify&bNo="+bNo+"&bCode="+bCode+"&pCode="+pCode+"&page="+page;
			C_openWindow(url, "글쓰기", 700, 550);
		break;
		case "delete":
			url = "./?menuType=board&mode=json&act=divDelete&bNo="+bNo+"&bCode="+bCode+"&pCode="+pCode+"&page="+page;
			goDel(pCode, bCode, page, bNo, url);
		break;
		case "load":
			url = "./?menuType=board&mode=json&act=divModify&pCode="+pCode+"&bCode="+bCode+"&page="+page+"&bNo="+bNo;
			goLoad(bCode, url);
		break;
		case "read":
			$("tr[id^=trReviewContent]").css("display","none");
			$("tr[id^=trReviewButton]").css("display","none");
			$("#trReviewContent_"+bNo).css("display","block");
			$("#trReviewButton_"+bNo).css("display","block");
		break;
		}
	}

	/* REVIEW Data Delete */
	function goDel(pCode, bCode, page, bNo, url)
	{
		var x = confirm("선택한  이용 후기를 삭제하시겠습니까?");
		if (x == true)
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
					//$("#"+"REVIEW").html(xmlhttp.responseText);
					if(xmlhttp.responseText)
					{
						alert(xmlhttp.responseText);
						return;
					}

					goScriptClick(pCode, bCode, page, bNo, "load")
				}
			}

			xmlhttp.open("GET",url,true);
			xmlhttp.send();
		}
	}

	/* REVIEW ReLoad Data */
	function goLoad(divID, url)
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
				$("#"+divID).html(xmlhttp.responseText);
			}
		}

		//alert(linkPage);
		xmlhttp.open("GET", url, true);
		xmlhttp.send();
	}

	function goMsg()
	{
		alert("비밀글은 작성자만 조회할 수 있습니다.");
	}

	/* 2012.08.04 -- KIM HEE-SUNG -- REVIEW Function */


	/* 2012.10.20 -- KIM HEE-SUNG -- BBS Function ( NEW ) */
	function goTR_Delete(bCode) {
		modal_window();
	}


	/* 상품 색상/컬러 검색 */
	function goProdSorting(gb,val){
		var intCount		= 0;
		var strVal			= "";
		var strObjNm		= "";
		var strObjALinkNm	= "";
		var aryObjList		= "";
		var strSelectedVal  = "";

		if (gb == "color")
		{
			strObjNm = "searchColor";
			intCount = "<?=sizeof($S_ARY_PROD_COLOR)?>";
			strObjALinkNm = "aLinkProdSearchColor";
		}

		if (gb == "size")
		{
			strObjNm = "searchSize";
			intCount = "<?=sizeof($S_ARY_PROD_SIZE)?>";
			strObjALinkNm = "aLinkProdSearchSize";
		}

		aryObjList = $("#"+strObjNm).val().split("|");
		for(var i=0; i<intCount; i++){

			if (i == val)
			{
				strVal += ($("#"+strObjALinkNm+i).attr("class") == "selected") ? "N|":"Y|";
			} else{
				strVal += ($("#"+strObjALinkNm+i).attr("class") == "selected") ? "Y|":"N|";
			}
		}
		$("#"+strObjNm).val(strVal);

		var doc = document.form;
		doc.method = "get";
		doc.action = "<?=$PHP_SELF?>";
		doc.submit();
	}

	/* 상품상세보기에서 장바구니 담기 클릭시 팝업창에서 주문하기/삭제하기/닫기 */
	function goPopCartJumun()
	{
		var intCheckCnt	= 0;
		var data		= new Array($("input[id^=popCartNo]").length * 5);

		$("input[id^=popCartNo]").each(function(i){
			if ($(this).is(":checked")) {
				data["cartNo["+i+"]"] = $(this).val();
				intCheckCnt++;
			}
		});

		if (intCheckCnt == 0)
		{
			alert("<?=$LNG_TRANS_CHAR['OS00019']?>"); //주문하실 상품을 선택해주세요.
			return;
		}

		data['menuType']	= "order";
		data['mode']		= "act";
		data['act']			= "order1";
		if (C_isNull(intMemberNo))
		{
			data['menuType']	= "member";
			data['mode']		= "login";
			data['act']			= "";
		}

		C_getSelfAction(data);
	}

	function goPopCartDel(no)
	{
		var intCheckCnt	= 0;
		var data		= new Array($("input[id^=popCartNo]").length * 5);

		if (!C_isNull(no))
		{
			data["cartNo[0]"]	= no;
			intCheckCnt			= 1;

		} else {
			$("input[id^=popCartNo]").each(function(i){
				if ($(this).is(":checked")) {
					data["cartNo["+i+"]"] = $(this).val();
					intCheckCnt++;
				}
			});
		}

		if (intCheckCnt == 0)
		{
			alert("<?=$LNG_TRANS_CHAR['OS00018']?>"); //삭제하실 상품을 선택해주세요.
			return;
		}

		var x = confirm("<?=$LNG_TRANS_CHAR['OS00017']?>"); //선택한 상품을 삭제하시겠습니까?
		if (x == true)
		{
			data['menuType']	= "product";
			data['mode']		= "json";
			data['act']			= "cartDel";
			C_getJsonAjaxAction("popCartDel","./index.php",data);
		}
	}

	function goPopCartClose()
	{
		$("#divCartPopup").trigger('mouseenter');
		$("#divCartPopup").css("display","none");
	}

	/* 상품 좋아요 */
	function goProdLikeUpdate(prodCode){
		if (C_isNull(intMemberNo))
		{
			alert("<?=$LNG_TRANS_CHAR['OS00014']?>");
			return;
		}

		var data			= new Array();

		data['prodCode']	= prodCode
		data['menuType']	= "product";
		data['mode']		= "json";
		data['act']			= "prodLikeUpdate";

		//C_getSelfAction(data);
		C_getJsonAjaxAction("prodLikeUpdate","./index.php",data);
	}

	/* 대량구매버튼 링크 */
	function goCartBluk(prodCode)
	{
		window.open('?menuType=etc&mode=popProdLargeBuy&prodCode='+prodCode,'new','width=650px,height=450px,top=300px,left=400px,menubar=no,location=no,scrollbars=yes,status=no,resizable=no');

	}


	/* 수량 update */
	function goPopCartQtyUpMinus(gb1,gb2,no)
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
		var strJsonParam = "cartQty&cartNo="+no+"&qty="+intQty+"&type=popCart";

		$.getJSON("./?menuType=order&mode=json&act="+strJsonParam,function(data){

			if(data[0].RET == "N") {
				alert(data[0].MSG);
				return;
			}

			if ("<?=$S_FIX_PRODUCT_CART_POP_USE?>" == "Y")
			{
				$("#divCartPopup").html(data[0].POP_HTML);
				$("#divCartPopup").css("display","");

				if ("<?=$S_FIX_ORDER_TOTAL_DISCOUNT_USE?>" == "Y"){
					$("#divOrderTotalDiscount").html(data[0].ORDER_TOTAL_DISCOUNT_HTML);
				}
			}
		})
	}

		//2015.04.13 by.mk
	$(function() {

		//List view button handler
		$('#btnListView').on('click', function() {
			$('.prodNewListWrapB:eq(0)').show();
			$('.prodNewListWrapA:eq(0)').hide();
		});

		//Tile view button handler
		$('#btnTileView').on('click', function() {
			$('.prodNewListWrapB:eq(0)').hide();
			$('.prodNewListWrapA:eq(0)').show();
		});


		// 마우스 클릭시 popProductAllView 보여주고, 배경을 클릭하면 사라짐
		$('#allViewBox').on('click', function() {
			$('#popProductAllView').css('display', '');
		});

		$(document).mouseup(function (e) {
			var container = $("#popProductAllView");

			if (!container.is(e.target)  && container.has(e.target).length === 0)  {
				container.hide();
			}
		});

	});



	/* listwish */
	function goListWish(strProdCode, strP_STOCK_OUT, intP_QTY, strP_STOCK_LIMIT, strCartOptPrice, strCartOptOrgPrice, strP_MIN_QTY, strProdOpt, intSort, strPOA_ATTR1, strP_OPT,intP_MAX_QTY)
	{

		<?php if($isPriceHide):?>
		if(!strMemberLogin) {
			alert('<?php echo $LNG_TRANS_CHAR["MS00112"]; // 로그인이 필요합니다.?>');
			return;
		} else {
			alert('<?php echo $LNG_TRANS_CHAR["MS00130"]; // 권한이 없습니다.?>');
			return;
		}
		<?php endif;?>


		strProdOptType			= strP_OPT;				//상품옵션종류
		strProdCode				= strProdCode;			//상품코드
		intProdQty				= intP_QTY;				//상품재고
		strProdStockLimit		= strP_STOCK_LIMIT;
		intProdMinQty			= strP_MIN_QTY;
		intProdMaxQty			= intP_MAX_QTY;



		var aryProdOptAttr1 = "";
		var aryProdOpt1 = "";
		/* 다중가격사용(일체형)*/
		$.getJSON("./?menuType=product&mode=json&act=prodOptAttr&prodCode="+strProdCode,function(data){
			aryProdOptAttr1 = data;
		});
		/* 다중옵션사용 */
		$.getJSON("./?menuType=product&mode=json&act=prodOpt&prodCode="+strProdCode,function(data){
			aryProdOpt1 = data;
			
		});

		if (C_isNull(intMemberNo))
		{
//			alert("<?=$LNG_TRANS_CHAR['OS00014']?>"); //로그인을 하신 후 이용하세요.
			var doc = document.form;
			doc.menuType.value = "member";
			doc.mode.value = "login";
			doc.submit();
			return;
		}

		/*품절여부확인*/
		if ((strP_STOCK_OUT == "Y") || (intP_QTY == 0 && strP_STOCK_LIMIT != "Y"))
		{
			alert("<?=$LNG_TRANS_CHAR['OS00028']?>"); //선택한 상품은 이미 품절된 상품입니다.
			return false;
		}

		// 옵션체크
		//var intCartQty			= $("#cartQty").val();
		var intCartQty			= intP_QTY;
		var arySelProdOpt		= strProdOpt.split("_");
		var intProdOptNo		= arySelProdOpt[1];  //옵션번호
		var intNextSort			= intSort + 1;			 //옵션다음순서
		var intProdOptCnt  = 1;

		var strJsonParam = "&optNo="+intProdOptNo;
		//strJsonParam = "&prodCode="+strProdCode;
		
		//strJsonParam += "&optAttr1="+encodeURIComponent(aryProdOptAttrVal[1]);
		strJsonParam += "&optAttr1="+encodeURIComponent(strPOA_ATTR1);
		strJsonParam += "&optAttr2="+encodeURIComponent('');
		strJsonParam += "&optAttr3="+encodeURIComponent('');
		strJsonParam += "&optAttr4="+encodeURIComponent('');
		strJsonParam += "&optAttr5="+encodeURIComponent('');
		strJsonParam += "&optAttr6="+encodeURIComponent('');
		strJsonParam += "&optAttr7="+encodeURIComponent('');
		strJsonParam += "&optAttr8="+encodeURIComponent('');
		strJsonParam += "&optAttr9="+encodeURIComponent('');
		strJsonParam += "&optAttr10="+encodeURIComponent('');
		strJsonParam += "&optAttrSort="+intNextSort;

		if (strProdOptType != "2")
		{

			if (!C_isNull(aryProdOptName[intNextSort]))
			{

				$.getJSON("./?menuType=product&mode=json&act=prodOptAttr2"+strJsonParam,function(data){

					$("#cartOpt"+intNextSort+"_"+intProdOptNo).empty().data('options');

					var strSelectIndexText = ":: <?=$LNG_TRANS_CHAR['PW00010']?> ::"; //선택
					if (aryProdOpt1[intProdOptNo].PO_ESS == "Y")
					{
						strSelectIndexText = ":: <?=$LNG_TRANS_CHAR['PW00009']?> ::"; //(필수) 선택
					}
					$("#cartOpt"+intNextSort+"_"+intProdOptNo).append("<option value=''>"+strSelectIndexText+"</option>");

					if ( getOptLength () == intNextSort )							// 다음 옵션이 마지막인 경우
						lastFlag = true ;
					for(var i=0;i<data[intProdOptNo][intNextSort].length;i++){
						// 마지막옵션인 경우 수량을 표기해준다.
						$('#cartOpt' + intNextSort + '_' + intProdOptNo).append('<option value="' + data[intProdOptNo][intNextSort][i].POA_ATTR + '">' + data[intProdOptNo][intNextSort][i].POA_ATTR + ( lastFlag && '<?=$prodRow['P_STOCK_LIMIT']?>'!= 'Y' ? ' ( ' + data[intProdOptNo][intNextSort][i].POA_STOCK_QTY + 'EA )' : ''  ) + '</option>') ;
					}
				})

				return;
			} else {

				/* 옵션 마지막 선택 */
				if (intProdOptCnt == intSort)
				{
					if (!C_isNull(intProdOptNo))
					{
					//strProdCode,strP_STOCK_OUT,intP_QTY,strP_STOCK_LIMIT,strCartOptPrice,strCartOptOrgPrice,strP_MIN_QTY,strProdOpt,intSort
						$.getJSON("./?menuType=product&mode=json&act=prodOptAttrNo"+strJsonParam,function(data){
							if (strP_STOCK_LIMIT != "Y"){
								if (strP_STOCK_OUT != "Y" && intP_QTY > 0){
									var intCartQty = goProdTotalQtyCheck();
									if (intProdMaxQty > 0 && (intCartQty > intProdMaxQty))
									{
										alert("<?=callLangTrans($LNG_TRANS_CHAR['PS00024'],array($prodRow['P_MAX_QTY']))?>");
										return;
									}
									if (parseInt(data[0].POA_STOCK_QTY) < intCartQty)
									{
										alert("<?=$LNG_TRANS_CHAR['OS00029']?>"); //상품의 재고량("+data[0].POA_STOCK_QTY+"개)보다 구매수량이 많습니다.
										return;
									}
								}
							}
							//if (strProdOptType != "1"){

								var strProdOptVal		= "";
								for(var k=1;k<=intProdOptCnt;k++){

									if (k == 1) strProdOptVal += aryProdOpt1[data[0].PO_NO].PO_NAME1+":"+data[0].POA_ATTR1;
									//if (k == 2) strProdOptVal += aryProdOpt1[data[0].PO_NO].PO_NAME2+":"+data[0].POA_ATTR2;
									//if (k == 3) strProdOptVal += aryProdOpt1[data[0].PO_NO].PO_NAME3+":"+data[0].POA_ATTR3;
									//if (k == 4) strProdOptVal += aryProdOpt1[data[0].PO_NO].PO_NAME4+":"+data[0].POA_ATTR4;
									//if (k == 5) strProdOptVal += aryProdOpt1[data[0].PO_NO].PO_NAME5+":"+data[0].POA_ATTR5;
									//if (k == 6) strProdOptVal += aryProdOpt1[data[0].PO_NO].PO_NAME6+":"+data[0].POA_ATTR6;
									//if (k == 7) strProdOptVal += aryProdOpt1[data[0].PO_NO].PO_NAME7+":"+data[0].POA_ATTR7;
									//if (k == 8) strProdOptVal += aryProdOpt1[data[0].PO_NO].PO_NAME8+":"+data[0].POA_ATTR8;
									//if (k == 9) strProdOptVal += aryProdOpt1[data[0].PO_NO].PO_NAME9+":"+data[0].POA_ATTR9;
									//if (k == 10) strProdOptVal += aryProdOpt1[data[0].PO_NO].PO_NAME10+":"+data[0].POA_ATTR10;

									//if (k != intProdOptCnt) strProdOptVal += "<br>";
								}

							//}
							//strProdOptVal = aryProdOpt[data[0].PO_NO].PO_NAME1+":"+strProdOptVal;
							var intProdOptPrice2 = "";
							<?if($S_ARY_CUR[$S_SITE_LNG]["USD"][2] == "Y"){?>
							var intProdOptPrice = "<?if ($prodRow[P_EVENT] > 0 && getProdEventInfo($prodRow) == 'Y'){?><?=getProdDiscountPrice($prodRow,'1',0,'US')?><?}else{?><?=getCurToPrice($prodRow[P_SALE_PRICE],'US')?><?}?>";
								intProdOptPrice2 = "<?if ($prodRow[P_EVENT] > 0 && getProdEventInfo($prodRow) == 'Y'){?><?=getProdDiscountPrice($prodRow)?><?}else{?><?=getCurToPrice($prodRow[P_SALE_PRICE])?><?}?>";
							<?}else{?>
							var intProdOptPrice = "<?if ($prodRow[P_EVENT] > 0 && getProdEventInfo($prodRow) == 'Y'){?><?=getProdDiscountPrice($prodRow)?><?}else{?><?=getCurToPrice($prodRow[P_SALE_PRICE])?><?}?>";
							<?}?>
							if (strProdOptType != "1"){
								<?if($S_ARY_CUR[$S_SITE_LNG]["USD"][2] == "Y"){?>
								ntProdOptPrice  = data[0].POA_SALE_PRICE_USD;
								intProdOptPrice2 = data[0].POA_SALE_PRICE;
								<?}else{?>
								intProdOptPrice = data[0].POA_SALE_PRICE;
								<?}?>

							}

							goListSelectProdOptHtml(data[0].POA_NO,strProdOptVal,intProdOptPrice,intProdOptPrice2,intProdMinQty,strProdCode);
						});
					}
				}
			}
		} else {
			/* 일체형 수량 체크*/
			var intProdOptAttrNo = $("#"+selObj+" option:selected").val();

			if ("<?=$prodRow[P_STOCK_LIMIT]?>" != "Y"){

				if ( intProdOptAttrNo == '' )
					return ;
				if ("<?=$prodRow[P_STOCK_OUT]?>" != "Y" && "<?=$prodRow[P_QTY]?> > 0"){
					var intCartQty = goProdTotalQtyCheck();
					if (intProdMaxQty > 0 && (intCartQty > intProdMaxQty))
					{
						alert("<?=callLangTrans($LNG_TRANS_CHAR['PS00024'],array($prodRow['P_MAX_QTY']))?>");
						return;
					}
					if ( typeof aryProdOptAttr[intProdOptAttrNo] !== undefined && parseInt(aryProdOptAttr[intProdOptAttrNo].POA_STOCK_QTY) < intCartQty)
					{
						alert("<?=$LNG_TRANS_CHAR['OS00029']?>");
						return;
					}
				}
			}


			var strProdOptVal = "";
			if ( intProdOptAttrNo != '' && typeof aryProdOptAttr[intProdOptAttrNo] !== undefined )
			{
				for ( var k = 1 ; k <= 10 ; k++ )
					strProdOptVal += (aryProdOptAttr[intProdOptAttrNo]['POA_ATTR' + k]) ? aryProdOptAttr[intProdOptAttrNo]['PO_NAME' + k] + ":" + aryProdOptAttr[intProdOptAttrNo]['POA_ATTR' + k] : "";

				/* 스크립트 호출 */
				var strProdOptValHtml = "<input type=\"text\" name=\""+intProdOptNo+"_cartOptVal1\" value=\""+aryProdOptAttr[intProdOptAttrNo].POA_ATTR1+"\">";
				<?if($S_ARY_CUR[$S_SITE_LNG]["USD"][2] == "Y"){?>
				goListSelectProdOptHtml(intProdOptAttrNo,strProdOptVal,aryProdOptAttr[intProdOptAttrNo].POA_SALE_PRICE_USD,aryProdOptAttr[intProdOptAttrNo].POA_SALE_PRICE,intProdMinQty,strProdCode);
				<?}else{?>
				goListSelectProdOptHtml(intProdOptAttrNo,strProdOptVal,aryProdOptAttr[intProdOptAttrNo].POA_SALE_PRICE,0,intProdMinQty,strProdCode);
				<?}?>
			}
		}
		////////////

	
		

		/* 필수사항 체크 여부 */
		//if (!goListNecsssaryCheck(strP_STOCK_OUT,intP_QTY,strP_STOCK_LIMIT)) return;

		//goListSelectProdOptHtml(optNo,optVal,optPrice,optPrice2)
		
		
		//doc.submit();

		//var formData = $("#form").serialize();
		//C_AjaxPost("cartWish","./index.php",formData,"post");
	}

	function goListSelectProdOptHtml(optNo,optVal,optPrice,optPrice2,strP_MIN_QTY,strProdCode)
	{
		if(strP_MIN_QTY == 0 ){
			strP_MIN_QTY = 1;
		}
		var strSelectProdOptHtml = '';
		if (!C_isNull(optNo))
		{
			strSelectProdOptHtml += "<input type=\"hidden\" name=\"cartOptNo[]\" value=\""+optNo+"\">";

			strSelectProdOptHtml += "<input type=\"hidden\" name=\""+optNo+"_cartOptPrice\" id=\""+optNo+"_cartOptPrice\" value=\""+optPrice+"\">";
			strSelectProdOptHtml += "<input type=\"hidden\" name=\""+optNo+"_cartOptOrgPrice\" id=\""+optNo+"_cartOptOrgPrice\" value=\""+optPrice2+"\">";
			strSelectProdOptHtml += "      <input type=\"hidden\" id=\""+optNo+"_cartQty\" name=\""+optNo+"_cartQty\" value=\""+strP_MIN_QTY+"\"> ";
		}	
		
		$("#divSelectOpt").html(strSelectProdOptHtml);

		var doc = document.form;
		doc.menuType.value = "product";
		doc.mode.value = "json";
		doc.act.value = "cartWish";
		doc.prodCode.value = strProdCode;
		doc.method = "post";
		//var addCheck = $('input[name="cartOptNo[]"]').val();
		var addCheck = $("#divSelectOpt").html();
		if(!C_isNull(addCheck)){
			//alert('ccc');
			var formData = $("#form").serialize();
			C_AjaxPost("cartWish","./index.php",formData,"post");
		}
	//$_POST["cartAddItem".$intProdItemNo];
	//$_POST[$intProdOptAttrNo."cartAddOptNo_no_".$intPO_NO];
	//$_POST[$intProdOptAttrNo."cartAddOptNo_qty_".$intPO_NO];
		
	}

	function popProdInquiry(p_code) {
		var strUrl = './?menuType=product&mode=prodInquiry&prodCode=' + p_code;

		location.href=strUrl;
		/*$.smartPop.open({	url: strUrl,
							bodyClose: false, 
							width: 860, 
							height: 593,			
		});*/
	}

	function popImageDetail(p_code) {
		var strUrl = './?menuType=popup&mode=imageDetail&imageSrc=' + p_code;

		$.smartPop.open({	url: strUrl,
							bodyClose: false,
							isInstall : true,
		});
	}
	// 팝업 닫고 다시 로드
	function goLayoutPopCloseEvent() {

		$.smartPop.close();
		//goSkinSampleHtml(strSubPageCode);

	}
//-->
</script>