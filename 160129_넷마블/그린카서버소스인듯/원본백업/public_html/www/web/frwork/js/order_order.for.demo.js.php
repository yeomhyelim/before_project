<script type="text/javascript">
<!--	
	$(document).ready(function(){
							
		var strDeliveryForMth = "<?=$S_DELIVERY_FOR_MTH?>";
		if ((strDeliveryForMth != "N"))
		{
			$("#bcountry").change(function(){
				goCountryDeliveryMthSelect();

				/* 통관정책 보여주기 */
				if (strSiteJsLng != "KR" && "<?=$S_ORDER_KOREA_SHIPPING_POLICY_USE?>" == "Y")
				{
					$("#divOrderCrnForm").css("display","none");
					if (strVal == "KR")
					{
						$("#divOrderCrnForm").css("display","");
						$("input:text[id^='j_shipping_no']").val("");
					}
				}
			});

			$("#deliveryWeightMethod").click(function() {
				var intSize = $("#deliveryWeightMethod option").size();
				if (intSize == 1)
				{
					alert("<?=$LNG_TRANS_CHAR['PS00014']?>"); //국가를 선택해주세요.
					return;
				}
			});

			$("#deliveryWeightMethod").change(function() {
				
				var strVal	= $("#deliveryWeightMethod option:selected").val();
				
				if (C_isNull(strVal))
				{
					alert("<?=$LNG_TRANS_CHAR['PS00015']?>"); //배송방법을 선택해주세요.
					return;
				}

				goDeliveryTotalPrice();
			});

			/* 처음 호출시 국가에 대한 배송방법 호출 */
			if ($("#bcountry").val())
			{
				goCountryDeliveryMthSelect();
			}
			
			<?if ($S_SITE_LNG != "KR" && $S_DELIVERY_FOR_MTH == "B"){?>
			/* 상품 무게에 따른 배송 가격 */
			$.getJSON("./?menuType=order&mode=json&act=deliveryWeightInfo",function(data){
				aryOrderDeliveryWeightInfo = data;
			});
			<?}?>
		}

		document.getElementById("display_pay_button").style.display = "block" ;

	});
	

	/* 주문정보과 배송지정보 동일체크 */
	function goOrderDeliveryChk()
	{
		if ($("input:checkbox[id='jInfoYN']").is(":checked") == true)
		{
			$("#bname").val($("#j_f_name").val()+" "+$("#j_l_name").val());
			$("#bphone1").val($("#jphone1").val());
			$("#bhp1").val($("#jhp1").val());
			//$("#bmail").val($("#jmail").val());
		} else {
			$("#bname").val("");
			$("#bphone1").val("");
			$("#bhp1").val("");
			//$("#bmail").val("");
		}
	}

	function goMemberAddrPush(no){
		if (no != "Y")
		{
			$("#bphone1").val(aryMemberAddrInfo[no]["MA_PHONE"]);
			$("#bhp1").val(aryMemberAddrInfo[no]["MA_HP"]);
			$("#bzip1").val(aryMemberAddrInfo[no]["MA_ZIP"]);
			
			$("#bcountry").val(aryMemberAddrInfo[no]["MA_COUNTRY"]);
			$("#bcity").val(aryMemberAddrInfo[no]["MA_CITY"]);

			$("#bstate_1").val(aryMemberAddrInfo[no]["MA_STATE"]);
			$("#bstate_2").val(aryMemberAddrInfo[no]["MA_STATE"]);
			
			if (aryMemberAddrInfo[no]["MA_COUNTRY"] == "US"){
				$("#divState1").css("display","none");
				$("#divState2").css("display","block");
			} else {
				$("#divState1").css("display","block");
				$("#divState2").css("display","none");
			}

			/* 배송국가에 따른 배송방법*/
			$("#deliveryWeightMethod").empty();
			C_AjaxPost("orderDeliveryMethod","./index.php","menuType=order&mode=json&act=deliveryWeightMethod&areaCode="+$("#bcountry").val(),"post");
			if ($("#bcountry").val())
			{
				goTotalPriceCal();
			}
			/* 배송국가에 따른 배송방법*/
		} else {

			$("#bphone1").val("");
			$("#bhp1").val("");
			$("#bzip1").val("");
			
			$("#bcountry").val("");
			$("#bcity").val("");
			$("#bstate_1").val("");
			$("#bstate_2").val("");
		}
	}
	
	/* 주문하기 */
	function goOrderCheckForm()
	{
		if(!C_chkInput("j_f_name",true,"<?=$LNG_TRANS_CHAR['OW00038']?>",true)) return false; //주문자명
		if(!C_chkInput("j_l_name",true,"<?=$LNG_TRANS_CHAR['OW00039']?>",true)) return false; //주문자명
//		if(!C_chkInput("jphone1",true,"<?=$LNG_TRANS_CHAR['OW00016']?>",true)) return false; //전화번호
		if(!C_chkInput("jhp1",true,"<?=$LNG_TRANS_CHAR['OW00010']?>",true)) return false; //핸드폰
		if(!C_chkInput("jmail",true,"<?=$LNG_TRANS_CHAR['OW00011']?>",true)) return false; //이메일
		
		<?if ((in_array($S_DELIVERY_FOR_MTH,array("W","T","B","A")))){?>
		if (parseInt($("#orderCartDeliveryProdCnt").val()) > 0){
		
			if(!C_chkInput("bname",true,"<?=$LNG_TRANS_CHAR['OW00017']?>",true)) return false; //받는사람명
			if(!C_chkInput("bphone1",true,"<?=$LNG_TRANS_CHAR['OW00018']?>",true)) return false; //받는사람 전화번호
			if(!C_chkInput("bhp1",true,"<?=$LNG_TRANS_CHAR['OW00019']?>",true)) return false; //받는사람 핸드폰
			if(!C_chkInput("bmail",true,"<?=$LNG_TRANS_CHAR['OW00020']?>",true)) return false; //받는사람 이메일
			
			var strCountry	= $("#bcountry option:selected").val();
			if (C_isNull(strCountry))
			{
				alert("<?=$LNG_TRANS_CHAR['OS00041']?>"); //국가를 선택해주세요.
				return false;
			}	

			if(!C_chkInput("baddr1",true,"<?=$LNG_TRANS_CHAR['OW00022']?>",true)) return false; //받는사람 주소
			if(!C_chkInput("baddr2",true,"<?=$LNG_TRANS_CHAR['OW00023']?>",true)) return false; //받는사람 상세주소
			if(!C_chkInput("bcity",true,"<?=$LNG_TRANS_CHAR['OW00041']?>",true)) return false; //받는사람 city
			
			var strState = "";
			if (strCountry == "US")
			{
				strState =  $("#bstate_2 option:selected").val();
			
				if (C_isNull(strState))
				{
					alert("<?=$LNG_TRANS_CHAR['OS00042']?>"); //State를 선택해주세요.
					return false;
				}	
			}
			
			if(!C_chkInput("bzip1",true,"<?=$LNG_TRANS_CHAR['OW00021']?>",true)) return false; //받는사람 우편번호
				
			<?if($S_DELIVERY_FOR_MTH != "A"){?>
			var strDeliveryWeightMethod		= $("#deliveryWeightMethod option:selected").val();
			if (C_isNull(strDeliveryWeightMethod))
			{
				alert("<?=$LNG_TRANS_CHAR['OS00043']?>"); //배송방법을 선택해주세요.
				return false;
			}
			<?}?>
		}
		<?}?>
		
		return true;
	}

	function goOrderPgAct(data)
	{
		var doc = document.form;
		
		doc.oNo.value	= data[0].NO;
		doc.payPg.value = data[0].SETTLE; 
		
		if (data[0].SETTLE == "B" || data[0].SETTLE == "P")
		{
			doc.payFlag.value = "success";
			doc.mode.value = "orderEnd";
			doc.act.value = "";
			doc.method = "post";
			doc.action = "<?=$PHP_SELF?>";
			doc.submit()

		} else {
			
			doc.method = "post";
			doc.action = "./index.php";
			doc.mode.value = "pg";
			doc.act.value = "pg";
				
			if (data[0].SETTLE == "Y") {
				<?if ($S_WINDOW_FRAME_USE == "Y"){?>
				doc.target="_parent"
				<?}?>
				doc.submit();
			} else if (data[0].SETTLE == "X"){
				
				var frm = document.regForm;

				frm.ref.value		= data[0].O_KEY;
				frm.fgkey.value		= data[0].EXIMBAY_FGKEY;
				frm.amt.value		= data[0].EXIMBAY_AMT;
				frm.param1.value	= data[0].EXIMBAY_CART;
				frm.param2.value	= data[0].EXIMBAY_COUPON;
				frm.buyer.value		= data[0].EXIMBAY_BUYER;
				frm.tel.value		= doc.jhp1.value;
				frm.email.value		= doc.jmail.value;
				frm.product.value	= data[0].EXIMBAY_TITLE;
					
				frm.rescode.value = "";
				frm.resmsg.value = "";
				frm.authcode.value = "";
				frm.cardco.value = "";
				frm.action = "<?=$SITE_EXIMBAY_PAY_URL?>";

				document.charset = "euc-kr";
				
				window.open("", "payment2", "scrollbars=yes,status=no,toolbar=no,resizable=yes,location=no,menu=no,width=800,height=470");
				frm.target = "payment2";
				frm.submit();	

				document.charset = "utf-8";
			}
		}
	}

	//국가선택에 따른 배송방법가져오기
	function goCountryDeliveryMthSelect()
	{
		var strVal	= $("#bcountry option:selected").val();
		
		$("#divState1").css("display","block");
		$("#divState2").css("display","none");
		if (strVal == "US")
		{
			$("#divState1").css("display","none");
			$("#divState2").css("display","block");
		}
		
		/* 배송국가에 따른 배송방법*/
		$("#deliveryWeightMethod").empty();	
		C_AjaxPost("orderDeliveryMethod","./index.php","menuType=order&mode=json&act=deliveryWeightMethod&areaCode="+strVal,"post");
	}

//-->
</script>
