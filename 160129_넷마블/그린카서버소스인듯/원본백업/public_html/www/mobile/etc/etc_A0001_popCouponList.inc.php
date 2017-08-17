<?
	require_once MALL_CONF_LIB."OrderMgr.php";

	$orderMgr = new OrderMgr();
	require_once MALL_PROD_FUNC;


	if ($g_member_login && $g_member_no > 0)
	{
		$orderMgr->setM_NO($g_member_no);
		$aryMyCouponList = $orderMgr->getOrderCouponList($db,"M");
	}
?>
<? include "./include/header.inc.php";?>
<script type="text/javascript">
<!--
	//var intProdTotalPrice		= opener.intOrderTotalSPrice;			//총주문금액
	var intProdTotalPrice		= opener.intOrderTotalSPriceOrg	;
	var intDeliveryTotalPrice	= opener.intOrderDeliveryPrice;	//총배송비용
	var intOrderTotalPrice		= parseFloat(intProdTotalPrice) - parseFloat(intDeliveryTotalPrice);
	var intOrderCartCnt			= 0;

	$(document).ready(function(){
		var strHtml = "";
		$('input:hidden[id="cartNo[]"]',opener.document).each(function(){
			intOrderCartCnt++;
			strHtml += "<input type=\"hidden\" name=\"cartNo[]\" id=\"cartNo[]\" value=\""+this.value+"\">";
		});

		if (intOrderCartCnt == 0)
		{
			alert("<?=$LNG_TRANS_CHAR['OS00057']?>"); //쿠폰을 사용하실 수 없습니다.주문하실 주문내역이 존재하지 않습니다.
			self.close();
		}

		$("#divHiddenCartList").html(strHtml);
		$("#orderTotalPrice").val(intOrderTotalPrice);

	});

	function goCouponCheckOk()
	{
		if(!C_chkInput("coupon_code",true,"<?=$LNG_TRANS_CHAR['OW00075']?>",true)) return; //쿠폰번호

		document.form.menuType.value = "order";
		document.form.mode.value = "json";
		document.form.act.value="couponCodeCheck";
		var formData = $("#form").serialize();
		C_AjaxPost("couponCodeCheck","./index.php",formData,"post");

		/*
		var doc = document.form;
		doc.method = "post";
		doc.action = "<?=$PHP_SELF?>";
		doc.submit();
		*/
	}

	function goAjaxRet(name,result,lrgs){

		var doc = document.form;
		var data = eval(result);

		if (name == "couponCodeCheck")
		{
			if (data[0].RET == "N")
			{
				alert(data[0].MSG);
				$("#coupon_code").val("");
				return;
			}

			if (data[0].RET == "Y"){

				var intDupCnt = 0;
				$('input:checkbox[id="chkNo[]"]').each(function(){
					if (this.value == data[0].CI_NO)
					{
						intDupCnt++;
						return;
					}
				});

				if (intDupCnt > 0)
				{
					alert("<?=$LNG_TRANS_CHAR['OS00054']?>"); //쿠폰목록에 존재하는 쿠폰번호입니다.
				}

				if (intDupCnt == 0) {
					var strHtml = "";
					strHtml += "<tr>";
					strHtml += "	<td><input type=\"checkbox\" id=\"chkNo[]\" name=\"chkNo[]\" value=\""+data[0].CI_NO+"\"></td>";
					strHtml += "	<td>"+data[0].COUPON_CODE+"</td>";
					strHtml += "	<td>"+data[0].COUPON_NAME+"<br><?=$LNG_TRANS_CHAR['OW00078']?> : "+data[0].COUPON_GIGAN+"</td>";
					strHtml += "	<td>"+data[0].COUPON_PRICE+"</td>";
					strHtml += "</tr>";

					$("#tabCoupList").append(strHtml);
				}
			}
		}

		if (name == "couponTotApplyPrice")
		{
			var data = eval(result);
			opener.goCouponPriceApply(lrgs,data[0].COUPON_TOTAL_PRICE.replace(",",""));
			self.close();
		}

		if (name == "couponTotPrice")
		{
			$("#spanTotCouponPrice").css("display","block");
			$("#spanTotCouponPrice").text("<?=$LNG_TRANS_CHAR['OW00082']?> : "+data[0].COUPON_TOTAL_PRICE); //총 쿠폰사용금액
		}
	}

	function goCouponUseCheck(obj)
	{
		var doc = document.form;
		doc.menuType.value = "order";
		doc.mode.value = "json";
		doc.act.value="couponInfo";
		doc.couponIssueNo.value = obj.value;

		//doc.method = "post";
		//doc.submit();
		//return;
		//$("#spanTotCouponPrice").css("display","none");
		<?if ($S_COUPON_LIMIT == "2"){?>
		/* 중복 쿠폰을 사용할 수 없음 */
		var intChkCnt = 0;
		$('input:checkbox[id="chkNo[]"]').each(function(){
			if (this.checked) intChkCnt++;
		});

		if (intChkCnt > 1)
		{
			alert("<?=$LNG_TRANS_CHAR['OS00061']?>"); //쿠폰은 한개이상 사용하실 수 없습니다.

			$('input:checkbox[id="chkNo[]"]').each(function(){
				if (this.checked && $(this).val() == obj.value) {
					this.checked = false;
				}
			});

			return;
		}
		<?}?>

		var formData = $("#form").serialize();
		$.getJSON("./?"+formData,function(data){
			if (data[0].CI_NO > 0)
			{
				/* 주문금액이 쿠폰을 사용할 수 있는 주문금액보다 작을때 */
				if (data[0].COUPON_LIMIT_PRICE > 0 && (data[0].COUPON_LIMIT_PRICE > intOrderTotalPrice))
				{
					alert(data[0].COUPON_ERR_MSG1);
					doc.couponIssueNo.value = "";
					obj.checked = false;

					goCouponTotalPrice();
					return;
				}

				/* 특정 카테고리/상품에 사용할 수 있는 주문내역이 있는지 확인 */
				if (data[0].COUPON_USE != "1")
				{
					if (data[0].COUPON_USE_EXP_CNT == 0){
						alert(data[0].COUPON_ERR_MSG2);
						obj.checked = false;
						goCouponTotalPrice();
						return;
					}
				}

				goCouponTotalPrice();
			}
		});
	}

	function goCouponTotalPrice()
	{
		var doc = document.form;
		doc.menuType.value = "order";
		doc.mode.value = "json";
		doc.act.value="couponTotPrice";

		var formData = $("#form").serialize();
		C_AjaxPost("couponTotPrice","./index.php",formData,"post","");
	}

	function goOrderCouponApply()
	{
		var strHtml = "";
		$('input:checkbox[id="chkNo[]"]').each(function(){
			if (this.checked)
			{
				strHtml += "<input type=\"hidden\" name=\"couponUseIssueNo[]\" id=\"couponUseIssueNo[]\" value=\""+this.value+"\">";
			}
		});

		if (strHtml == "")
		{
			alert("<?=$LNG_TRANS_CHAR['OS00058']?>"); //선택하신 쿠폰이 없습니다.
			return;
		}

		var doc = document.form;
		doc.menuType.value = "order";
		doc.mode.value = "json";
		doc.act.value="couponTotPrice";
		//doc.method = "post";
		//doc.submit();

		var formData = $("#form").serialize();
		C_AjaxPost("couponTotApplyPrice","./index.php",formData,"post",strHtml);
	}

//-->
</script>
<body>
<div class="popContainer">
	<div class="couponHight">
		<h3><?=$LNG_TRANS_CHAR["CW00026"] //쿠폰목록?></h3>
		<form name='form' method='post' ID="form">
		<input type="hidden" name="menuType" value="order">
		<input type="hidden" name="mode" value="<?=$strMode?>">
		<input type="hidden" name="act" value="<?=$strMode?>">
		<input type="hidden" name="couponIssueNo" id="couponIssueNo" value="">
		<input type="hidden" name="orderTotalPrice" id="orderTotalPrice" value="">

			<div class="couponSearchWrap">
				<label><?=$LNG_TRANS_CHAR["OW00075"] //쿠폰번호?></label>
				<input type="input" id="coupon_code" name="coupon_code" maxlength="50"/>
				<span>
					<a href="javascript:goCouponCheckOk();" class="popSearchBtn"><?=$LNG_TRANS_CHAR["CW00061"] //검색?></a>
				</span>
			</div>

				<div class="popTableList">
						<ul id="tabCoupList">
							<?
							if (is_array($aryMyCouponList)){
								for($i=0;$i<sizeof($aryMyCouponList);$i++){
									$intCouponPrice = ($aryMyCouponList[$i][CU_PRICE_OFF] == "1") ? NUMBER_FORMAT($aryMyCouponList[$i][CU_PRICE])."%": getCurToPrice($aryMyCouponList[$i][CU_PRICE]);
									?>
								<li>
									<span class="couponNum">
										<input type="checkbox" id="chkNo[]" name="chkNo[]" value="<?=$aryMyCouponList[$i][CI_NO]?>" onclick="javascript:goCouponUseCheck(this);" class="chkBox">
										<?=$aryMyCouponList[$i][CI_CODE]?>
									</span>

									<span><?=$aryMyCouponList[$i][CU_NAME]?></span>
									<span><?=$LNG_TRANS_CHAR["OW00078"] //유효기간?> : <?=SUBSTR($aryMyCouponList[$i][CI_START_DT],0,10)?> ~ <?=SUBSTR($aryMyCouponList[$i][CI_END_DT],0,10)?></span>
									<strong class="priceOrange"><?=$intCouponPrice?></strong>
								</li>
									<?
								}
							}
							?>
						</ul>
						<span id="spanTotCouponPrice" class="useCouponInfo" style="display:none"></span>
				</div><!-- tableForm -->

			<div class="btnClose">
				<a href="javascript:goOrderCouponApply();" class="pop_ChkOkBtn"><?=$LNG_TRANS_CHAR["OW00074"] //쿠폰적용?></a>
				<a href="javascript:self.close();" class="btn_popClose"><?=$LNG_TRANS_CHAR["CW00034"] //닫기?></a>
			</div>
		</div>
		<div id="divHiddenCartList">
		</div>
	</div>
</div>
</form>
</body>
</html>