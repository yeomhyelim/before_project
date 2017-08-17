<script type="text/javascript">
<!--
	var intOrderTotalSPriceOrg		= "";
	var intOrderTotalFirstPrice		= 0;	//첫로딩시 주문금액

	var intOrderDeliveryPrice		= "";
	var aryOrderDeliveryGroupInfo	= ""; //상품배송(그룹배송)
	var aryOrderDeliveryWeightInfo	= ""; //상품배송(해외배송)
	var aryOrderDeliveryCountryInfo = ""; //상품배송국가
	var aryMemberAddrInfo			= ""; //회원주소록정보

	var intOrderMemDiscountPrice	= ""; //회원등급 추가할인금액
	var intOrderMemAddPoint	    	= ""; //회원등급 추가포인트적립금액
	var intOrderAddPoint	    	= ""; //총적립포인트
	var intOrderTaxPrice			= ""; //부과세
	var intOrderPgCommissionPrice	= ""; //PG수수료
	var intOrderTotalSPrice			= "";
	var intOrderPointUsePrice		= ""; //포인트결제가능한금액(포인트사용금지상품제외)
	var intOrderPointNoUseCnt		= "";
	var intOrderPointNoUsePrice		= "";

	$(document).ready(function(){
		intOrderTotalSPriceOrg		= document.form.good_mny.value;			//상품총가격
		intOrderTotalDeliveryPrice	= document.form.good_delivery.value;	//배송가격
		intOrderPointUsePrice		= document.form.good_point_use.value;   //포인트결제가능한금액
		intOrderPointNoUseCnt		= document.form.good_point_no_use_cnt.value;
		intOrderPointNoUsePrice		= document.form.good_point_no_use.value;

		$('#jphone2').numeric();
		$("#jphone2").css("ime-mode", "disabled");

		$('#jphone3').numeric();
		$("#jphone3").css("ime-mode", "disabled");

		$('#jhp2').numeric();
		$("#jhp2").css("ime-mode", "disabled");

		$('#jhp3').numeric();
		$("#jhp3").css("ime-mode", "disabled");

		$('#jmail').alphanumeric({allow:"-_.@"});
		$("#jmail").css("ime-mode", "disabled");

		$('#bphone2').numeric();
		$("#bphone2").css("ime-mode", "disabled");

		$('#bphone3').numeric();
		$("#bphone3").css("ime-mode", "disabled");

		$('#bhp2').numeric();
		$("#bhp2").css("ime-mode", "disabled");

		$('#bhp3').numeric();
		$("#bhp3").css("ime-mode", "disabled");

		$('#bmail').alphanumeric({allow:"-_.@"});
		$("#bmail").css("ime-mode", "disabled");

		<?if ($S_SITE_LNG != "KR" && $S_SITE_LNG != "JP" && $S_SITE_LNG != "RU"){?>
		$('#use_point').alphanumeric({allow:"."});
		<?}else{?>
		$('#use_point').numeric();
		<?}?>
		$("#use_point").css("ime-mode", "disabled");

		/* 첫구매 고객사은품 중복 체크 */
		$("input:checkbox[id^=prodFirstGiftNo]").click(function(){
			<?if ($S_MULTI_GIFT_USE == "N"){?>
			var intProdFirstGiftCnt = 0;
			$("input:checkbox[id^=prodFirstGiftNo]").each(function(){
				if ($(this).is(":checked")) intProdFirstGiftCnt++;
			});
			if (intProdFirstGiftCnt > 1)
			{
				alert("<?=$LNG_TRANS_CHAR['OS00062']?>"); //사은품은 한개이상 선택할 수 없습니다.
				$(this).attr("checked",false);
			}
			<?}?>
		});

		/* 구매금액에 따른 고객사은품 중복 체크 */
		$("input:checkbox[id^=prodGiftNo]").click(function(){
			<?if ($S_MULTI_GIFT_USE == "N"){?>
			var intProdGiftCnt = 0;
			$("input:checkbox[id^=prodGiftNo]").each(function(){
				if ($(this).is(":checked")) intProdGiftCnt++;
			});
			if (intProdGiftCnt > 1)
			{
				alert("<?=$LNG_TRANS_CHAR['OS00062']?>"); //사은품은 한개이상 선택할 수 없습니다.
				$(this).attr("checked",false);
			}
			<?}?>
		});

		/* 주소록 체크 */
		$("input[name='basicAddr']").click(function() {
			if ($(this).is(":checked") == true)
			{
				goMemberAddrPush($(this).val());
			}
		});

		/* 사용자 포인트 변경 */
		$("#use_point").bind("blur", function() {
			goOrderUsePointCheck();
		});

		/* 총 주문/결제금액에 따른 할인혜택 구하기 */
		document.form.mode.value		= "json";
		document.form.act.value			= "memberDiscount";

		<?if($S_SHOP_HOME == "kopocu"){?>
//		document.form.submit();
//		return;
		<?}?>
		var orderJsonData = $("#form").serialize();
		$.getJSON("./?"+orderJsonData,function(data){

			intOrderTotalSPriceOrg		= data[0].O_TOT_FIRST_PRICE;					//실결제금액(사용자포인트 + 사용자쿠폰 적용전)
			intOrderTotalSPrice			= data[0].O_TOT_SPRICE;							//실결제금액
			intOrderDeliveryPrice		= data[0].O_TOT_DELIVERY_PRICE;					//배송비
			intOrderMemDiscountPrice	= data[0].O_TOT_MEM_DISCOUNT_PRICE;				//추가할인금액
			intOrderMemAddPoint			= data[0].O_TOT_MEM_POINT;						//추가적립포인트
			intOrderAddPoint			= data[0].O_TOT_POINT;							//총포인트
			intOrderTaxPrice			= data[0].O_TOT_TAX;							//부과세
			intOrderPgCommissionPrice	= data[0].O_TOT_PG_COMMISSION;					//PG수수료

			goTotalPriceCalHtml();

		});

		/* 회원 주소록 가지고 오기*/
		<?if ($g_member_no && $g_member_login){?>
		$.getJSON("./?menuType=member&mode=json&act=memberAddrList",function(data){
			if (!C_isNull(data))
			{
				aryMemberAddrInfo = data;
			}
		});
		<?}?>

		if ("<?=$S_ORDER_KOREA_SHIPPING_POLICY_USE?>" == "Y"){
			//통관개인정보제공
			$('#j_shipping_no1_1').numeric();
			$("#j_shipping_no1_1").css("ime-mode", "disabled");

			$('#j_shipping_no1_2').numeric();
			$("#j_shipping_no1_2").css("ime-mode", "disabled");

			$('#j_shipping_no2').alphanumeric({allow:"."});
			$("#j_shipping_no2").css("ime-mode", "disabled");

			$("input[name='j_shipping_local']").click(function() {
				var strShippingNoType = $(this).val();

				$("div[id^='divOrderShippingNo']").css("display","none");
				$("input:text[id^='j_shipping_no']").val("");

				$("div[id='divOrderShippingNo"+strShippingNoType+"']").css("display","");
			});
		}
	});


	/* 우편번호 찾기 */
//	function goZip(num)
//	{
//		window.open('?menuType=etc&mode=address2&num=' + num,'new','width=600px,height=670px,top=300px,left=400px,toolbar=no,directories=no,scrollbars=no,resizable=no,status=no,menubar=no,location=no');
//
//		//window.open('?menuType=etc&mode=address&num='+num,'new','width=490px,height=400px,top=300px,left=400px,menubar=no,location=no,scrollbars=yes,status=no,resizable=no');
//	}

	/* 우편번호 찾기 */
	function goZip(num)
	{
		if(strDevice == "mobile") {

			var di = setIntDimension() ;
			var intwidth = di['intwidth'] ,
				intHeight = di['intHeight'] ;
			/*
			var ratio		= window.devicePixelRatio || 1 ,
				intwidth	= Number ( screen.width / ratio ) ,
				intHeight	= Number ( screen.height / ratio ) ;
			*/
			if(intHeight >= 200) {intHeight = intHeight - 100; }
			if(intwidth >= 200) {intwidth = intwidth - 50; }
			if(intHeight > 370) { intHeight = 370; }

			TINY.box.show({iframe:'./?menuType=etc&mode=address3&num='+num,boxid:'frameless',width:intwidth,height:intHeight,fixed:false,maskopacity:40})

		} else {

			var url = './?menuType=etc&mode=address2&num='+num;
//			var url = '/api/zip/zipCode.php?num='+num;
			window.open(url,'new','width=690px,height=400px,top=300px,left=400px,menubar=no,location=no,scrollbars=yes,status=no,resizable=no');

		}


	}


	/* 무통장 입금 체크 */
	function goSettle()
	{
		var strSettle = $(":radio[name='settle']:checked").val();
		
		<?if($S_SITE_LNG !="KR"){?>
		$("#divEximbayTextCN").css("display","none");
		$("#divEximbayTextUS").css("display","none");
		<?}?>

		if (strSettle == "B")
		{
			$("#trBankInfo").css("display","");
			$("#trEscrowInfo").css("display","none");
			$("#pay_method").val("");
		} else if (strSettle == "T") {
			$("#trEscrowInfo").css("display","");
			$("#trBankInfo").css("display","none");
			
			$("#pay_method").val("001000000000");
		} else {
			$("#trEscrowInfo").css("display","none");
			$("#trBankInfo").css("display","none");

			if (strSettle == "C"){
				$("#pay_method").val("100000000000");
			} else if (strSettle == "A") {
				$("#pay_method").val("010000000000");
			} else if (strSettle == "T") {
				$("#pay_method").val("001000000000");
			} else if (strSettle == "M") {
				$("#pay_method").val("000010000000");
			} else if (strSettle == "X") {
				<?if($S_SITE_LNG !="KR"){?>
				$("#divEximbayText<?=$S_SITE_LNG?>").css("display","");
				<?}?>
			}
		}

		$("#bank_name").val("");
		$("#bank_code").val("");

		<?if ($S_PG_COMMISSION == "Y" && ($S_PG_CARD_COMMISSION > 0)){?>
		goTotalPriceCal();
		<?}?>
	}

	/* 주문하기 */
	function goOrderAct()
	{
		if (C_isNull(intM_NO))
		{
			var strPolicyYN = $(":radio[name='agreeYN']:checked").val();
			if (C_isNull(strPolicyYN) || strPolicyYN == "N")
			{
				alert("<?=$LNG_TRANS_CHAR['MS00015']?>"); //[개인정보보호정책] 동의를 선택해주세요.
				return;
			}
		}

		<?if ($S_GIFT_USE != "N"){?>
		/* 고객사은품 */
		if ($("input:checkbox[id^=prodFirstGiftNo]").length > 0){
			var intProdFirstGiftCnt = 0;
			$("input:checkbox[id^=prodFirstGiftNo]").each(function(){
				if ($(this).is(":checked")) intProdFirstGiftCnt++;
			});

			if (intProdFirstGiftCnt == 0)
			{
				alert("<?=$LNG_TRANS_CHAR['OS00072']?>"); //사은품을 선택해주세요.
				return;
			}
		}

		if ($("input:checkbox[id^=prodGiftNo]").length > 0){
			var intProdGiftCnt = 0;
			$("input:checkbox[id^=prodGiftNo]").each(function(){
				if ($(this).is(":checked")) intProdGiftCnt++;
			});

			if (intProdGiftCnt == 0)
			{
				alert("<?=$LNG_TRANS_CHAR['OS00072']?>"); //사은품을 선택해주세요.
				return;
			}
		}
		<?}?>

		if ("<?=$S_ORDER_KOREA_SHIPPING_POLICY_USE?>" == "Y"){
			if(strSiteJsLng == "KR" || ($("#bcountry option:selected").val() == "KR")){
				var strShippingInfoYN = $("#j_shipping_no_agree:checked").val();

				if (strShippingInfoYN != "Y")
				{
					alert("통관개인정보제공 동의를 해주세요.");
					return;
				}

				if (strShippingInfoYN == "Y")
				{
					var strShippingNoType = $("input:radio[name='j_shipping_local']:checked").val();
					if (strShippingNoType == "1")
					{
						if (!$("#j_shipping_no1_1").val() || !$("#j_shipping_no1_2").val())
						{
							alert("주민번호를 입력해주세요.");
							return;
						}

						if (!C_isValidRegNo($("#j_shipping_no1_1").val()+$("#j_shipping_no1_2").val())){
							alert("주민번호를 정확히 입력해주세요.(13자리)");
							return;
						}
					}

					if (strShippingNoType == "2")
					{
						if (!$("#j_shipping_no2").val())
						{
							alert("여권번호 및 외국인등록번호를 입력해주세요.");
							return;
						}

						if ($("#j_shipping_no2").val().length < 7)
						{
							alert("여권번호 및 외국인등록번호는 최소 7자리이상 입력해주세요.");
							return;
						}
					}
				}
			}
		}

		if (!goOrderCheckForm()) return;

		var doc = document.form;
		doc.mode.value = "json";
		doc.act.value = "order2";

		var intOrderUsePoint  = (C_isNull($("#use_point").val())) ? 0:parseFloat($("#use_point").val());
		var intOrderUseCoupon = (C_isNull($("#use_coupon").val())) ? 0:parseFloat($("#use_coupon").val());
		var intOrderUsePrice  = intOrderUsePoint + intOrderUseCoupon;

		/* 주문 금액 = 0/ 사용포인트 금액 == 주문금액 일치/ 주문금액 - 사용포인트 < 회원보유포인트*/
		if ((doc.good_mny.value == 0) && (intOrderTotalSPrice == 0))
		{

			if (intM_NO > 0 && intOrderUsePoint > 0 && (intOrderUsePoint > parseFloat("<?=$intMemberUsePointTotal?>"))){
				alert("<?=$LNG_TRANS_CHAR['OS00034']?>"); //입력하신 사용포인트가 보유하신 포인트보다 많습니다.
				return;
			}

			/* 포인트 구매 */
			$("#pay_method").val("999999999999");
			$("#bank_name").val("");
			$("#bank_code").val("");

			var x = confirm("<?=$LNG_TRANS_CHAR['OS00021']?>"); //결제를 포인트 구매로 진행하시겠습니까?
			if (x != true)
			{
				return;
			}

		} else {
			var strSettle = $(":radio[name='settle']:checked").val();
			if (C_isNull(strSettle))
			{
				alert("<?=$LNG_TRANS_CHAR['OS00022']?>"); //결제방법을 선택해주세요.
				return;
			}

			if (strSettle == "B"){
				if (!$("#settle_bank_code").val())
				{
					alert("<?=$LNG_TRANS_CHAR['OS00023']?>"); //입금은행을(를) 선택해주세요.
					return;
				}
				if(!C_chkInput("input_bank_name",true,"<?=$LNG_TRANS_CHAR['OW00024']?>",false)) return; //입금자명
			}
		}

		doc.method = "post";
		doc.action = "<?=$PHP_SELF?>";

		<?php if($_SESSION['debug']):?>
//			doc.submit();
//			return;
		<?php endif;?>

		var formData = $("#form").serialize();
		goInitLoading("loading");
		C_AjaxPost("orderAct","./index.php",formData,"post");
	}

	function goAjaxRet(name,result){


		if (name == "orderAct")
		{
			var doc = document.form;
			var data = eval(result);

			if (data[0].RET == "Y")
			{
				goOrderPgAct(data);
			} else {
				goInitLoading("");
				alert(data[0].MSG);
				return;
			}
		} else if (name = "orderDeliveryMethod"){
			$("#deliveryWeightMethod").html(result);
		}
	}

	/* 주문 로빙바 구현 */
	function goInitLoading(loadingMode)
	{
		if(loadingMode == "loading") {
			$('#display_pay_button').hide();
			$('#display_pay_loading').show();
			// $("#btnOrderBuy").attr("href","javascript:alert('loading....');");
			// $("#btnOrderBuy").attr("src","../himg/etc/icon_loading.gif");
		} else {
			$('#display_pay_button').show();
			$('#display_pay_loading').hide();
			// $("#btnOrderBuy").attr("href","javascript:goOrderAct();");
			// $("#btnOrderBuy").attr("src","../himg/product/A0001/<?=$S_SITE_LNG_PATH?>/btn_order_buy.gif");
		}
	}

	/* 주문시 총 배송비 구하기 */
	function goDeliveryTotalPrice()
	{
		<?if($S_SITE_LNG == "KR"){
			switch($S_MALL_TYPE){
				case "R":
					if ($S_DELIVERY_MTH == "G"){
						##임대/독립형  그룹배송
						?>
						var intDeliveryGroupPriceNo	= $("#deliveryGroupPrice option:selected").val();
						if (!C_isNull(intDeliveryGroupPriceNo))
						{
							intOrderDeliveryPrice = aryOrderDeliveryGroupInfo[intDeliveryGroupPriceNo]["CUR_PRICE"];
						}
						<?
					}
				break;
				case "M":
					## 몰인몰
					?>
					intOrderDeliveryPrice = "<?=$intProdBasketDeliveryTotal?>";
					<?
				break;
			}
		} else {
			switch($S_DELIVERY_FOR_MTH){
				case "W":
					## 무게
					?>
					var strCallJsonParam = "&bcountry="+$("#bcountry option:selected").val();
					strCallJsonParam += "&prodWeigth="+$("#deliveryWeight").val();
					strCallJsonParam += "&deliveryWeightMethod="+$("#deliveryWeightMethod option:selected").val();

					$.getJSON("./?menuType=order&mode=json&act=deliveryWeightInfo"+strCallJsonParam,function(data){
						if (data.DELIVERY_PRICE == null){
							data.DELIVERY_PRICE = 0;
							alert("<?=$LNG_TRANS_CHAR['OS00075']?>"); //주문에 대한 배송비정보가 없습니다. 관리자에게 문의바랍니다.
						}
						intOrderDeliveryPrice = data.DELIVERY_PRICE;
						var intOrderUsePoint  = (C_isNull($("#use_point").val())) ? 0:parseFloat($("#use_point").val());
						if (intOrderUsePoint > 0)
						{
							goOrderUsePointCheck();
						} else {
							goTotalPriceCal();
						}
					});
					<?
				break;
				case "B":
					## 수량별 배송
					?>
					var strDeliveryWeightMethod		= $("#deliveryWeightMethod option:selected").val();
					if (!C_isNull(strDeliveryWeightMethod)){
						intOrderDeliveryPrice		= aryOrderDeliveryWeightInfo[strDeliveryWeightMethod];
					}

					goTotalPriceCal();
					<?
				break;
			}
		}
			?>
	}

	/* 총 결제금액 표시 */
	function goTotalPriceCal()
	{
		intOrderTotalSPrice		= parseFloat(intOrderTotalSPriceOrg);
		intOrderTotalSPrice		= parseFloat(intOrderTotalSPriceOrg) + parseFloat(intOrderDeliveryPrice) + parseFloat(intOrderTaxPrice) + parseFloat(intOrderPgCommissionPrice);

		if ($("#use_point").val() > 0)
		{
			intOrderTotalSPrice = intOrderTotalSPrice - parseFloat($("#use_point").val());
		}

		if ($("#use_coupon").val() > 0)
		{
			intOrderTotalSPrice = intOrderTotalSPrice - parseFloat($("#use_coupon").val());
		}

		/* 포인트/쿠폰 결제시 총 결제금액보다 클 경우는 주문금액을 0으로 처리*/
		if (intOrderTotalSPrice < 0) intOrderTotalSPrice = 0;


		/* 회원이고 회원그룹의 할인혜택이 있을때 */
		document.form.mode.value = "json";
		document.form.act.value = "memberDiscount";

		var orderJsonData = $("#form").serialize();
		$.getJSON("./?"+orderJsonData,function(data){
//				intOrderTotalSPriceOrg		= data[0].O_TOT_SPRICE;
			intOrderTotalSPrice			= data[0].O_TOT_SPRICE;
			intOrderDeliveryPrice		= data[0].O_TOT_DELIVERY_PRICE;
			intOrderMemDiscountPrice	= data[0].O_TOT_MEM_DISCOUNT_PRICE;
			intOrderMemAddPoint			= data[0].O_TOT_MEM_POINT;
			intOrderAddPoint			= data[0].O_TOT_POINT;
			intOrderTaxPrice			= data[0].O_TOT_TAX;
			intOrderPgCommissionPrice	= data[0].O_TOT_PG_COMMISSION;

			goTotalPriceCalHtml();
		});
	}

	function goTotalPriceCalHtml()
	{
		/* 주문 상품리스트 최종배송금액 변경 */
		<?if (!$S_FIX_ORDER_DELIVERY_INFO_YN || $S_FIX_ORDER_DELIVERY_INFO_YN == "Y"){ //주문시 배송정보를 사용하지 않을때?>
		$("#cartTotalDeliveryPrice").html(intOrderDeliveryPrice);
		$("#cartTotalDeliveryPrice").formatCurrency({symbol: ''<?=($S_SITE_CUR=='KRW' || $S_SITE_CUR=='JPY' || $S_SITE_CUR=='RUB')?",roundToDecimalPlace:0":"";?>});
		<?}?>

		/* 주문 상품리스트 최종결제금액변경 */
		$("#cartTotalPrice").html(intOrderTotalSPrice);
		$("#cartTotalPrice").formatCurrency({symbol: ''<?=($S_SITE_CUR=='KRW' || $S_SITE_CUR=='JPY' || $S_SITE_CUR=='RUB')?",roundToDecimalPlace:0":"";?>});

		$("#cartPgCommission").html("");
		$(".totOrderPgCommissionPrice").html("");
		$(".totOrderPgCommissionPrice").css("display","none");

		/* 주문내역 결제금액 */
		var strTotPayPriceHtml = "<span><?=$LNG_TRANS_CHAR['OW00026']?></span>: <strong class=\"priceOrange\">"+intOrderTotalSPrice+"</strong><?=getCurMark2()?>";
		<?if ($strDevice == "mobile"){?>
			strTotPayPriceHtml = "<span class=\"title\"><?=$LNG_TRANS_CHAR['OW00026']?></span><span class=\"valueTxt\"><strong class=\"priceOrange\">"+intOrderTotalSPrice+"</strong><?=getCurMark2()?></span><div class=\"clr\"></div>";
		<?}?>

		$(".totPayPrice").html(strTotPayPriceHtml);
		$(".totPayPrice .priceOrange").formatCurrency({symbol: '<?=getCurMark()?> '<?=($S_SITE_CUR=='KRW' || $S_SITE_CUR=='JPY' || $S_SITE_CUR=='RUB')?",roundToDecimalPlace:0":"";?>});

		$("#good_mny").val(intOrderTotalSPrice);
		$("#good_delivery").val(intOrderDeliveryPrice);

		/* 주문내역 PG사 수수료 */
		if (intOrderPgCommissionPrice > 0)
		{
			$("#cartPgCommission").html("(<?=$LNG_TRANS_CHAR['OW00112']?>:<?=getCurMark()?> <strong id=\"txtCartOrderPgCommissionPrice\">"+intOrderPgCommissionPrice+"</strong><?=getCurMark2()?>)");
			$("#txtCartOrderPgCommissionPrice").formatCurrency({symbol: ''<?=($S_SITE_CUR=='KRW' || $S_SITE_CUR=='JPY' || $S_SITE_CUR=='RUB')?",roundToDecimalPlace:0":"";?>});

			$(".totOrderPgCommissionPrice").css("display","");
			$(".totOrderPgCommissionPrice").html("<span><?=$LNG_TRANS_CHAR['OW00112']?></span>: <?=getCurMark()?> <strong id=\"txtOrderPgCommissionPrice\">"+intOrderPgCommissionPrice+"</strong><?=getCurMark2()?>");
			$("#txtOrderPgCommissionPrice").formatCurrency({symbol: ''<?=($S_SITE_CUR=='KRW' || $S_SITE_CUR=='JPY' || $S_SITE_CUR=='RUB')?",roundToDecimalPlace:0":"";?>});
		}

		/* 주문내역 추가 할인금액 */
		if (intOrderMemDiscountPrice > 0)
		{
			$(".totMemDiscountPrice").css("display","block");
			$(".totMemDiscountPrice").html("<span><?=$LNG_TRANS_CHAR['OW00070']?></span>: <?=getCurMark()?> <strong id=\"txtMemDiscountPrice\">"+intOrderMemDiscountPrice+"</strong><?=getCurMark2()?>");
			$("#txtMemDiscountPrice").formatCurrency({symbol: ''<?=($S_SITE_CUR=='KRW' || $S_SITE_CUR=='JPY' || $S_SITE_CUR=='RUB')?",roundToDecimalPlace:0":"";?>});
		}

		<?if (!$S_FIX_ORDER_DELIVERY_INFO_YN || $S_FIX_ORDER_DELIVERY_INFO_YN == "Y"){ //주문시 배송정보를 사용하지 않을때?>
		$("#txtDeliveryPrice").text(intOrderDeliveryPrice);
		$("#txtDeliveryPrice").formatCurrency({symbol: ''<?=($S_SITE_CUR=='KRW' || $S_SITE_CUR=='JPY' || $S_SITE_CUR=='RUB')?",roundToDecimalPlace:0":"";?>});
		<?}?>

		<?if ($S_SITE_CUR != "KRW"){?>
		$("#good_mny").formatCurrency({symbol: ''});
		$("#good_delivery").formatCurrency({symbol: ''});
		<?}?>

		<?if ($S_ARY_CUR[$S_SITE_LNG]["USD"][2] == "Y"){?>
			document.form.mode.value	= "json";
			document.form.act.value		= "orderUsePriceMark";

//			if (document.form.use_point.value)
//			{
//				document.form.method = "post";
//				document.form.submit();
//			}

			var orderJsonData = $("#form").serialize();
			$.getJSON("./?"+orderJsonData,function(data){

//				intOrderTotalSPriceOrg				= data[0].O_TOT_SPRICE;

				var intOrderTotalSUsdPrice			= data[0].O_TOT_SPRICE;
				var intOrderDeliveryUsdPrice		= data[0].O_TOT_DELIVERY_PRICE;
				var intOrderMemDiscountUsdPrice		= data[0].O_TOT_MEM_DISCOUNT_PRICE;
				var intOrderTaxUsdPrice				= data[0].O_TOT_TAX;
				var intOrderPgCommisionUsdPrice		= data[0].O_TOT_PG_COMMISSION;
				var intOrderDeliveryPriceOrg		= data[0].O_TOT_DELIVERY_PRICE_ORG;

				intOrderDeliveryPrice				= data[0].O_TOT_DELIVERY_PRICE;
				intOrderTotalSPrice					= data[0].O_TOT_SPRICE_ORG;
				//intOrderMemDiscountPrice			= data[0].O_TOT_MEM_DISCOUNT_PRICE;

				/* 주문 상품리스트 최종배송금액 변경 */
				$("#cartTotalDeliveryPrice").text(intOrderDeliveryUsdPrice);
				$("#cartTotalDeliveryOrgPrice").text(intOrderDeliveryPriceOrg);

				/* 주문 상품리스트 최종결제금액변경 */
				$("#cartTotalPrice").html("<?=getCurMark('USD')?> "+intOrderTotalSUsdPrice+"<?=getCurMark2('USD')?>");
				$("#cartTotalPrice").formatCurrency({symbol: ''<?=($S_SITE_CUR=='KRW' || $S_SITE_CUR=='JPY' || $S_SITE_CUR=='RUB')?",roundToDecimalPlace:0":"";?>});

				$("#cartTotalOrgPrice").html(intOrderTotalSPrice);
				$("#cartTotalOrgPrice").formatCurrency({symbol: ''<?=($S_SITE_CUR=='KRW' || $S_SITE_CUR=='JPY' || $S_SITE_CUR=='RUB')?",roundToDecimalPlace:0":"";?>});

				/* 주문내역 결제금액 */
				var strTotPayPriceHtml = "<span><?=$LNG_TRANS_CHAR['OW00026']?></span>: <strong class=\"priceOrange\">"+intOrderTotalSUsdPrice+"</strong><?=getCurMark2()?>";
				strTotPayPriceHtml += " (<?=$S_SITE_CUR_MARK1?><span>"+intOrderTotalSPrice+"</span>)";
				<?if ($strDevice == "mobile"){?>
					strTotPayPriceHtml = "<span class=\"title\"><?=$LNG_TRANS_CHAR['OW00026']?></span><span class=\"valueTxt\"><strong class=\"priceOrange\">"+intOrderTotalSUsdPrice+"</strong><?=getCurMark2()?>";
					strTotPayPriceHtml += " (<?=$S_SITE_CUR_MARK1?><span>"+intOrderTotalSPrice+"</span>)</span><div class=\"clr\"></div>";
				<?}?>

				$(".totPayPrice").html(strTotPayPriceHtml);
				$(".totPayPrice .priceOrange").formatCurrency({symbol: '<?=getCurMark("USD")?> '<?=($S_SITE_CUR=='KRW' || $S_SITE_CUR=='JPY' || $S_SITE_CUR=='RUB')?",roundToDecimalPlace:0":"";?>});
				<?if ($strDevice == "mobile"){?>
				//$(".totPayPrice > span:eq(2)").formatCurrency({symbol: ''<?=($S_SITE_CUR=='KRW' || $S_SITE_CUR=='JPY' || $S_SITE_CUR=='RUB')?",roundToDecimalPlace:0":"";?>});
				<?}else{?>
				$(".totPayPrice > span:eq(1)").formatCurrency({symbol: ''<?=($S_SITE_CUR=='KRW' || $S_SITE_CUR=='JPY' || $S_SITE_CUR=='RUB')?",roundToDecimalPlace:0":"";?>});
				<?}?>

				$("#cartPgCommission").html("");
				$(".totOrderPgCommissionPrice").html("");
				$(".totOrderPgCommissionPrice").css("display","none");

				/* 주문내역 PG사 수수료 */
				if (intOrderPgCommissionPrice > 0)
				{
					$("#cartPgCommission").html("(<?=$LNG_TRANS_CHAR['OW00112']?>:<?=getCurMark()?> <strong id=\"txtCartOrderPgCommissionPrice\">"+intOrderPgCommisionUsdPrice+"</strong><?=getCurMark2()?>)");
					$("#txtCartOrderPgCommissionPrice").formatCurrency({symbol: ''<?=($S_SITE_CUR=='KRW' || $S_SITE_CUR=='JPY' || $S_SITE_CUR=='RUB')?",roundToDecimalPlace:0":"";?>});

					$(".totOrderPgCommissionPrice").css("display","");
					$(".totOrderPgCommissionPrice").html("<span><?=$LNG_TRANS_CHAR['OW00112']?></span>: <?=getCurMark()?> <strong id=\"txtOrderPgCommissionPrice\">"+intOrderPgCommisionUsdPrice+"</strong><?=getCurMark2()?>");
					$("#txtOrderPgCommissionPrice").formatCurrency({symbol: ''<?=($S_SITE_CUR=='KRW' || $S_SITE_CUR=='JPY' || $S_SITE_CUR=='RUB')?",roundToDecimalPlace:0":"";?>});
				}

				/* 주문내역 추가 할인금액 */
				if (intOrderMemDiscountPrice > 0)
				{
					$(".totMemDiscountPrice").css("display","block");
					$(".totMemDiscountPrice").html("<span><?=$LNG_TRANS_CHAR['OW00070']?></span>: <?=getCurMark('USD')?> <strong id=\"txtMemDiscountPrice\">"+intOrderMemDiscountUsdPrice+"</strong><?=getCurMark2('USD')?>(<?=$S_SITE_CUR_MARK1?><span id=\"totMemDiscountOrgPrice\">"+intOrderMemDiscountPrice+"</span>)");
					$("#txtMemDiscountPrice").formatCurrency({symbol: ''<?=($S_SITE_CUR=='KRW' || $S_SITE_CUR=='JPY' || $S_SITE_CUR=='RUB')?",roundToDecimalPlace:0":"";?>});
					$("#totMemDiscountOrgPrice ").formatCurrency({symbol: ''<?=($S_SITE_CUR=='KRW' || $S_SITE_CUR=='JPY' || $S_SITE_CUR=='RUB')?",roundToDecimalPlace:0":"";?>});
				}

				$("#txtDeliveryPrice").text(intOrderDeliveryUsdPrice);
				$("#txtDeliveryPrice").formatCurrency({symbol: ''<?=($S_SITE_CUR=='KRW' || $S_SITE_CUR=='JPY' || $S_SITE_CUR=='RUB')?",roundToDecimalPlace:0":"";?>});

				$("#txtDeliveryOrgPrice").text(intOrderDeliveryPriceOrg);
				$("#txtDeliveryOrgPrice").formatCurrency({symbol: ''<?=($S_SITE_CUR=='KRW' || $S_SITE_CUR=='JPY' || $S_SITE_CUR=='RUB')?",roundToDecimalPlace:0":"";?>});


			});


		<?}?>
	}


	/* 포인트 사용시 체크 함수 */
	function goOrderUsePointCheck()
	{
		var intOrderUsePoint			= $("#use_point").val();
		var intOrderTotalPrice			= parseFloat(intOrderTotalSPriceOrg) + parseFloat(intOrderDeliveryPrice) + parseFloat(intOrderTaxPrice) + parseFloat(intOrderPgCommissionPrice);
		if (parseFloat(intOrderPointUsePrice) >= 0 && parseInt(intOrderPointNoUseCnt) > 0 && parseFloat(intOrderPointNoUsePrice) > 0)
		{
			intOrderTotalPrice			= parseFloat(intOrderPointUsePrice);
		}

		var intOrderUseCoupon			= (C_isNull($("#use_coupon").val())) ? 0 : parseFloat($("#use_coupon").val());

		intOrderTotalPrice				= intOrderTotalPrice - intOrderUseCoupon;
		/* 적립포인트 */
		$("#spanOrderAddPoint").html(C_toNumberFormatString($("#savePointTotal").val(),false));
		if (parseFloat(intOrderUsePoint) > parseFloat(<?=$intMemberUserAblePoint?>))
		{
			alert("<?=$LNG_TRANS_CHAR['OS00008']?>"); //사용가능하신 포인트 금액만큼 입력해주세요.
			$("#use_point").val("");
			goTotalPriceCal();
			return;
		}

		if (parseFloat(intOrderUsePoint) > parseFloat(intOrderTotalPrice))
		{
			alert("<?=$LNG_TRANS_CHAR['OS00009']?>"); //입력하신 포인트가 결제금액보다 큽니다.
			$("#use_point").val("");
			goTotalPriceCal();
			return;
		}

		if (parseFloat(intOrderUsePoint) > parseFloat(<?=$intUseMaxPoint?>))
		{
			alert("<?=callLangTrans($LNG_TRANS_CHAR['OS00010'],array(getFormatPrice($intUseMaxPoint,2)))?>"); //사용가능하신 포인트는 "+C_toNumberFormatString(<?=$S_POINT_MAX?>,false)+"보다 적어야 됩니다.
			$("#use_point").val("<?=$intUseMaxPoint?>");
			goTotalPriceCal();
			return;
		}

		if ('<?=$intCartPoint;?>' > 0 && "<?=$S_POINT_USE2?>" == "N" && parseFloat(intOrderUsePoint) > 0)
		{
			alert("<?=$LNG_TRANS_CHAR['OS00011']?>"); //결제시 포인트를 사용하시면 상품 적립포인트가 쌓이지 않습니다.
			$("#spanOrderAddPoint").html("0");
			goTotalPriceCal();
			return;
		}

		goTotalPriceCal();
	}


	/* 쿠폰 적용 팝업창 띄우기 */
	function goPopCounponList()
	{
		window.open('?menuType=etc&mode=popCouponList','coupon','width=640px,height=400px,top=300px,left=400px,menubar=no,location=no,scrollbars=yes,status=no,resizable=no');
	}

	/* 쿠폰 사용한 금액 가지고 오기 */
	function goCouponPriceApply(html,price)
	{
		$("#divCouponParam").html(html);
		$("#use_coupon").val(price);

		goTotalPriceCal();
	}

	/* 주문서에서 주소록 팝업창 열기 */
	function goMemberAddrList()
	{
		window.open('?menuType=etc&mode=popMemAddrList','MemberAddr','width=490px,height=400px,top=300px,left=400px,menubar=no,location=no,scrollbars=yes,status=no,resizable=no');
	}

	/* 주문 취소하기 */
	function goOrderCancel()
	{
		var doc = document.form;

		doc.menuType.value = "order";
		doc.mode.value = "cart";
		doc.act.value = "";
		doc.method = "post";
		doc.action = "<?=$PHP_SELF?>";
		doc.submit();
	}


//-->
</script>