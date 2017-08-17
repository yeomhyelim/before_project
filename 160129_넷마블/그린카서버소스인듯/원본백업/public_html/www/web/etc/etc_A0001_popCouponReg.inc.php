<?
	require_once MALL_CONF_LIB."OrderMgr.php";
	
	$orderMgr = new OrderMgr();

	if (!$g_member_login || !$g_member_no){
		goClose($LNG_TRANS_CHAR["OS00014"]);
		exit;
	}
?>
<? include "./include/header.inc.php";?>
<script type="text/javascript">
<!--
	
	$(document).ready(function(){
		
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

		if (name == "couponReg")
		{	
			var data = eval(result);
			
			if (data[0].RET == "Y")
			{
				opener.location.reload();
				self.close();
			} else {
				alert("<=$LNG_TRANS_CHAR['OS00081']?>");
				return;
			}
		}
	}

	function goCouponRegAct()
	{
		var intSelectCoupontCnt = 0;
		$('input:checkbox[id="chkNo[]"]').each(function(){
			if (this.checked)
			{
				intSelectCoupontCnt++;
			}
		});	
		
		if (intSelectCoupontCnt == 0)
		{
			alert("<?=$LNG_TRANS_CHAR['OS00058']?>"); //선택하신 쿠폰이 없습니다.
			return;
		}
		
		var doc = document.form;
		doc.menuType.value = "order";
		doc.mode.value = "json";
		doc.act.value="couponReg";
//		doc.method = "post";
//		doc.submit();
		
		var formData = $("#form").serialize();
		C_AjaxPost("couponReg","./index.php",formData,"post");
	}

//-->
</script>
<body>
<div class="popContainer">
<form name='form' method='post' ID="form">
<input type="hidden" name="menuType" value="order">
<input type="hidden" name="mode" value="<?=$strMode?>">
<input type="hidden" name="act" value="<?=$strMode?>">
<input type="hidden" name="couponIssueNo" id="couponIssueNo" value="">
<input type="hidden" name="orderTotalPrice" id="orderTotalPrice" value="">

	<div class="couponHight">
		<h2><?=$LNG_TRANS_CHAR["CW00026"] //쿠폰목록?></h2>

			<div class="popTableList">
				<table>
					<colgroup>
						<col style="width:100px;"/>
						<col/>
					</colgroup>
					<tr>
						<th><?=$LNG_TRANS_CHAR["OW00075"] //쿠폰번호?></th>
						<td>
							<input type="input" id="coupon_code" name="coupon_code" class="defInput _w200" maxlength="50"/>
							<a href="javascript:goCouponCheckOk();" class="popSearchBtn"><?=$LNG_TRANS_CHAR["CW00061"] //검색?></a>
						</td>
					</tr>
				</table>
			</div>
			
				<div class="popTableList">
						<table id="tabCoupList">
							<colgroup>
								<col style="width:40px;"/>
								<col/>
								<col/>
								<col/>
							</colgroup>
							<tr>
								<th></th>
								<th><?=$LNG_TRANS_CHAR["OW00075"] //쿠폰번호?></th>
								<th><?=$LNG_TRANS_CHAR["OW00076"] //쿠폰명?></th>
								<th><?=$LNG_TRANS_CHAR["OW00077"] //쿠폰금액?></th>
							</tr>
						</table>
						<span id="spanTotCouponPrice" class="useCouponInfo" style="display:none"></span>
				</div><!-- tableForm -->
				
			<div class="btnCenter">				
				<a href="javascript:goCouponRegAct();" class="popChkOkBtn"><?=$LNG_TRANS_CHAR["OW00107"] //쿠폰등록?></a>
				<a href="javascript:self.close();" class="popCloeBtn"><?=$LNG_TRANS_CHAR["CW00034"] //닫기?></a>
			</div>
		</div>
		<div id="divHiddenCartList">
		</div>
	</div>
</div>
</form>
</body>
</html>