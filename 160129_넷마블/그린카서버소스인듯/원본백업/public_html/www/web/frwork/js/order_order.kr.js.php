<script type="text/javascript">
<!--	
	$(document).ready(function(){
				
		$('#cash_hp2').numeric();
		$("#cash_hp2").css("ime-mode", "disabled"); 

		$('#cash_hp3').numeric();
		$("#cash_hp3").css("ime-mode", "disabled"); 

		$('#cash_no1').numeric();
		$("#cash_no1").css("ime-mode", "disabled"); 

		$('#cash_no2').numeric();
		$("#cash_no2").css("ime-mode", "disabled"); 

		$('#cash_no3').numeric();
		$("#cash_no3").css("ime-mode", "disabled"); 

		$('#cash_no4').numeric();
		$("#cash_no4").css("ime-mode", "disabled"); 

		$("input[name='cash_yn_site']").click(function() {			
			$("#divCash").css("display","none");
			if ($(this).is(":checked") == true)
			{	
				$("#divCash").css("display","block");
			}
		});
		
		$("#cashMth").change(function(){
			var strVal	= $("#cashMth option:selected").val();
			if (strVal == "")
			{
				strVal = "1";
				$("#cashMth").val("1");
			}

			$("#divCashHp").css("display","none");
			$("#divCashNo").css("display","none");
			$("#divCashBiz").css("display","none");
			
			if (strVal == "1")
			{
				$("#divCashHp").css("display","");
			}

			if (strVal == "2")
			{
				$("#divCashNo").css("display","");
			}

			if (strVal == "3")
			{
				$("#divCashBiz").css("display","");
			}
		});

		<?if ($S_DELIVERY_MTH == "G"){?>
			$.getJSON("./?menuType=order&mode=json&act=deliveryGroupInfo",function(data){	
				aryOrderDeliveryGroupInfo = data;
			});
		<?}?>
		
		$(".exMemoInsert").click(function(){
			var exMemoText = $(this).text();
			$('#bmemo').html(exMemoText.substring(2));
		});

//		setTimeout("init_pay_button();",300);
		document.getElementById("display_pay_button").style.display = "block" ;
	});
	

	/* 주문정보과 배송지정보 동일체크 */
	function goOrderDeliveryChk()
	{
		if ($("input:checkbox[id='jInfoYN']").is(":checked") == true)
		{
			$("#bname").val($("#jname").val());
			$("#bphone1").val($("#jphone1").val());
			$("#bphone2").val($("#jphone2").val());
			$("#bphone3").val($("#jphone3").val());
			$("#bhp1").val($("#jhp1").val());
			$("#bhp2").val($("#jhp2").val());
			$("#bhp3").val($("#jhp3").val());
		} else {
			$("#bname").val("");
			$("#bphone1").val("");
			$("#bphone2").val("");
			$("#bphone3").val("");
			$("#bhp1").val("");
			$("#bhp2").val("");
			$("#bhp3").val("");
		}
	}

	/* 20150624 배송지와 주문자 정보 ( 주문자명, 전화번호, 휴대폰 동일 처리 ) */
	function goOrderDeliveryChk2(){
			
		var strOrderDelivery = $(":checkbox[name='orderDelivery']:checked").val();
		
		if(strOrderDelivery){
						
			$("#jname").val($("#bname").val());
			
			$("#jphone1").val($("#bphone1").val());
			$("#jphone2").val($("#bphone2").val());
			$("#jphone3").val($("#bphone3").val());
			
			$("#jhp1").val($("#bhp1").val());
			$("#jhp2").val($("#bhp2").val());
			$("#jhp3").val($("#bhp3").val());
			
			//$("#jmail").val("");
			
			
		}else{
			$("#jname").val("");
			
			$("#jphone1").val("");
			$("#jphone2").val("");
			$("#jphone3").val("");
			
			$("#jhp1").val("");
			$("#jhp2").val("");
			$("#jhp3").val("");
			
			//$("#jmail").val("");
		}
		
	}

	function goMemberAddrPush(no){
		if (no != "Y")
		{
			$("#bname").val(aryMemberAddrInfo[no]["MA_NAME"]);
			$("#baddr1").val(aryMemberAddrInfo[no]["MA_ADDR1"]);
			$("#baddr2").val(aryMemberAddrInfo[no]["MA_ADDR2"]);

			$("#bphone1").val(aryMemberAddrInfo[no]["MA_PHONE1"]);
			$("#bphone2").val(aryMemberAddrInfo[no]["MA_PHONE2"]);
			$("#bphone3").val(aryMemberAddrInfo[no]["MA_PHONE3"]);
			$("#bhp1").val(aryMemberAddrInfo[no]["MA_HP1"]);
			$("#bhp2").val(aryMemberAddrInfo[no]["MA_HP2"]);
			$("#bhp3").val(aryMemberAddrInfo[no]["MA_HP3"]);
			$("#bzip1").val(aryMemberAddrInfo[no]["MA_ZIP1"]);
			$("#bzip2").val(aryMemberAddrInfo[no]["MA_ZIP2"]);
		} else {

			$("#bname").val("");
			$("#baddr1").val("");
			$("#baddr2").val("");

			$("#bphone1").val("02");
			$("#bphone2").val("");
			$("#bphone3").val("");
			$("#bhp1").val("010");
			$("#bhp2").val("");
			$("#bhp3").val("");
			$("#bzip1").val("");
			$("#bzip2").val("");
		}
	}
	
	/* 주문하기 */
	function goOrderCheckForm()
	{
		if(!C_chkInput("jname",true,"<?=$LNG_TRANS_CHAR['OW00015']?>",true)) return false; //주문자명
//		if(!C_chkInput("jphone2",true,"<?=$LNG_TRANS_CHAR['OW00016']?>",true)) return false; //전화번호
//		if(!C_chkInput("jphone3",true,"<?=$LNG_TRANS_CHAR['OW00016']?>",true)) return false; //전화번호
		if(!C_chkInput("jhp2",true,"<?=$LNG_TRANS_CHAR['OW00010']?>",true)) return false; //핸드폰
		if(!C_chkInput("jhp3",true,"<?=$LNG_TRANS_CHAR['OW00010']?>",true)) return false; //핸드폰
		if(!C_chkInput("jmail",true,"<?=$LNG_TRANS_CHAR['OW00011']?>",true)) return false; //이메일
		
		<?if (!$S_FIX_ORDER_DELIVERY_INFO_YN || $S_FIX_ORDER_DELIVERY_INFO_YN == "Y"){ //주문시 배송정보를 사용하지 않을때?>
		if(!C_chkInput("bname",true,"<?=$LNG_TRANS_CHAR['OW00017']?>",true)) return false; //받는사람명
//		if(!C_chkInput("bphone2",true,"<?=$LNG_TRANS_CHAR['OW00018']?>",true)) return false; //받는사람 전화번호
//		if(!C_chkInput("bphone3",true,"<?=$LNG_TRANS_CHAR['OW00018']?>",true)) return false; //받는사람 전화번호
		if(!C_chkInput("bhp2",true,"<?=$LNG_TRANS_CHAR['OW00019']?>",true)) return false; //받는사람 핸드폰
		if(!C_chkInput("bhp3",true,"<?=$LNG_TRANS_CHAR['OW00019']?>",true)) return false; //받는사람 핸드폰

		if(!C_chkInput("bzip1",true,"<?=$LNG_TRANS_CHAR['OW00021']?>",true)) return false; //받는사람 우편번호
		if(!C_chkInput("bzip2",true,"<?=$LNG_TRANS_CHAR['OW00021']?>",true)) return false; //받는사람 우편번호
		if(!C_chkInput("baddr1",true,"<?=$LNG_TRANS_CHAR['OW00022']?>",true)) return false; //받는사람 주소
		if(!C_chkInput("baddr2",true,"<?=$LNG_TRANS_CHAR['OW00023']?>",true)) return false; //받는사람 상세주소

		<?if ($S_DELIVERY_MTH == "G"){?>
			var intDeliveryGroupPriceNo	= $("#deliveryGroupPrice option:selected").val();
			
			if (C_isNull(intDeliveryGroupPriceNo))
			{
				alert("<?=$LNG_TRANS_CHAR['OS00025']?>"); //배송비를 선택해주세요.
				return false;
			}
		<?}?>

		<?}else{
			if (is_array($S_FIX_ORDER_DELIVERY_PROD_CATE) && $intDeliveryPriceProdCnt > 0){
			?>
		if(!C_chkInput("bname",true,"<?=$LNG_TRANS_CHAR['OW00017']?>",true)) return false; //받는사람명
		if(!C_chkInput("bhp2",true,"<?=$LNG_TRANS_CHAR['OW00019']?>",true)) return false; //받는사람 핸드폰
		if(!C_chkInput("bhp3",true,"<?=$LNG_TRANS_CHAR['OW00019']?>",true)) return false; //받는사람 핸드폰

		if(!C_chkInput("bzip1",true,"<?=$LNG_TRANS_CHAR['OW00021']?>",true)) return false; //받는사람 우편번호
		if(!C_chkInput("bzip2",true,"<?=$LNG_TRANS_CHAR['OW00021']?>",true)) return false; //받는사람 우편번호
		if(!C_chkInput("baddr1",true,"<?=$LNG_TRANS_CHAR['OW00022']?>",true)) return false; //받는사람 주소
		if(!C_chkInput("baddr2",true,"<?=$LNG_TRANS_CHAR['OW00023']?>",true)) return false; //받는사람 상세주소
			<?}?>
		<?}?>
		
		return true;
	}

	function goOrderPgAct(data)
	{
		var doc = document.form;
		
		doc.ordr_idxx.value	= data[0].O_KEY;
		doc.good_name.value	= data[0].TITLE;
		doc.order_no.value	= data[0].NO;
		
		if (data[0].SETTLE == "B" || data[0].SETTLE == "P")
		{
			doc.mode.value = "orderEnd";
			doc.act.value = "";
			doc.method = "post";
			doc.action = "<?=$PHP_SELF?>";
			doc.submit()

		} else {
						
			<?if ($S_PG == "K"){?>
				doc.good_info.value	= data[0].CART;
				doc.bask_cntx.value	= data[0].CART_CNT;
			
				<?//if($SHOP_ORDER_PG_TAX_FLAG == "Y"){?>
				if (data[0].TAX_USE == "Y")
				{
					doc.comm_tax_mny.value	= data[0].TAX_PRICE;
					doc.comm_vat_mny.value	= data[0].ADDTAX_PRICE;
					doc.comm_free_mny.value = data[0].NOTAX_PRICE;
				}
				<?//}?>
				
				<?if (!$strDevice && $strDevice != "m" && $strDevice != "mobile"){?>

				doc.method = "post";
				doc.action = "./index.php";
				doc.mode.value = "pg";
				doc.act.value = "pg";

				doc.buyr_name.value = doc.jname.value;
				doc.buyr_mail.value = doc.jmail.value;
				doc.buyr_tel1.value = doc.jphone1.value+"-"+doc.jphone2.value+"-"+doc.jphone3.value;
				doc.buyr_tel2.value = doc.jhp1.value+"-"+doc.jhp2.value+"-"+doc.jhp3.value;
				
				<?if (!$S_FIX_ORDER_DELIVERY_INFO_YN || $S_FIX_ORDER_DELIVERY_INFO_YN == "Y"){ //주문시 배송정보를 사용하지 않을때?>
				doc.rcvr_name.value = doc.bname.value;
				doc.rcvr_tel1.value = doc.bphone1.value+"-"+doc.bphone2.value+"-"+doc.bphone3.value;
				doc.rcvr_tel2.value = doc.bhp1.value+"-"+doc.bhp2.value+"-"+doc.bhp3.value;
				//doc.rcvr_mail.value = doc.bmail.value;
				doc.rcvr_zipx.value = doc.bzip1.value+doc.bzip2.value;
				doc.rcvr_add1.value = doc.baddr1.value;
				doc.rcvr_add2.value = doc.baddr2.value;
				<?}?>

				if (jsf__pay(doc))
				{
					doc.submit();
				}
				
				<?}else{?>
				doc.good_cart.value = data[0].CART_NO;
				doc.mode.value = "orderStep1";
				doc.act.value = "";
				doc.method = "post";
				doc.action = "<?=$PHP_SELF?>";
				doc.submit();
				<?}?>
			<?}?>
			
			/* AGS START */
			<?if ($S_PG == "A"){?>
			
				<?if (!$strDevice && $strDevice != "m"){?>

				doc.method = "post";
				doc.action = "./index.php";
				doc.mode.value = "pg";
				doc.act.value = "pg";

				if (data[0].SETTLE == "C")
				{
					doc.Job.value = "onlycard";
				}
				else if (data[0].SETTLE == "A")
				{
					doc.Job.value = "onlyiche";
				}
				else if (data[0].SETTLE == "T")
				{
					doc.Job.value = "onlyvirtual";
				}

				doc.OrdNo.value = data[0].O_KEY;
				doc.Amt.value = doc.good_mny.value;
				//doc.Amt.value = 1000;
				doc.ProdNm.value = data[0].TITLE;
				doc.UserEmail.value = doc.jmail.value;
				doc.SubjectData.value = doc.StoreNm.value+";"+doc.ProdNm.value+";"+doc.Amt.value+";";

				doc.UserId.value = ""; //현금영수증발행부분
				
				doc.OrdNm.value			= doc.jname.value;
				doc.OrdPhone.value		= doc.jphone1.value+"-"+doc.jphone2.value+"-"+doc.jphone3.value;
				doc.OrdAddr.value		= doc.baddr1.value+" "+doc.baddr2.value;
				doc.RcpNm.value			= doc.bname.value;
				doc.RcpPhone.value		= doc.bhp1.value+"-"+doc.bhp2.value+"-"+doc.bhp3.value;
				doc.DlvAddr.value		= doc.baddr1.value+" "+doc.baddr2.value;
				doc.Remark.value		= doc.bmemo.value;
				doc.AGS_HASHDATA.value	= data[0].AGS_HASHDATA;
				
				if (C_isNull(intM_NO))
				{
					doc.UserId.value = "NON_"+data[0].NO;
				} else {
					<?if ($S_MEM_CERITY == "2"){?>
					doc.UserId.value = "U_"+data[0].NO;
					<?}else{?>
					doc.UserId.value = "<?=$g_member_id?>";
					<?}?>
				}

				Pay(form);

				<?}?>
			<?}?>
			/* AGS END */

			/* KSNET START */
			<?if ($S_PG == "N"){?>
				<?if (!$strDevice && $strDevice != "m"){?>
				doc.method = "post";
				doc.action = "./index.php";
				doc.mode.value = "pg";
				doc.act.value = "pg";

				if (data[0].SETTLE == "C")
				{
					doc.sndPayMethod.value = "1000000000";
				}
				else if (data[0].SETTLE == "A")
				{
					doc.sndPayMethod.value = "0010000000";
				}
				else if (data[0].SETTLE == "T")
				{
					doc.sndPayMethod.value = "0100000000";
				}

				doc.sndOrdernumber.value	= data[0].O_KEY;
				doc.sndGoodname.value		= data[0].TITLE;
				//doc.sndAmount.value			= doc.good_mny.value;
				doc.sndOrdername.value		= doc.jname.value;
				doc.sndEmail.value			= doc.jmail.value;
				doc.sndMobile.value			= doc.jhp1.value+doc.jhp2.value+doc.jhp3.value;

				_pay(document.form);
				<?}?>
			<?}?>
			/* KSNET END */

			/* EXIMBAY START */
			<?if ($S_PG == "X"){?>
			
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
			
			<?}?>
			/* EXIMBAY END */

			<?php  if($S_PG == 'I') echo "goINIescrowPay(data);"; /* INIescrow */ ?>


		}

	}
//-->
</script>