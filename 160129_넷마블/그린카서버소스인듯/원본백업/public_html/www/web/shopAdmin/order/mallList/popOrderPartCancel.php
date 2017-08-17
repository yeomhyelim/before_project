<? include "./include/header.inc.php"?>
<?

	require_once MALL_CONF_LIB."OrderAdmMgr.php";
	require_once MALL_CONF_LIB."ShopOrderMgr.php";
	require_once "../conf/paypal_conf_inc.php";

	$orderMgr = new OrderMgr();
	$shopOrderMgr = new ShopOrderMgr();

	$intO_NO		= $_POST["no"]				? $_POST["no"]				: $_REQUEST["no"];

	if (!$intO_NO){
		$db->disConnect();
		goClose($LNG_TRANS_CHAR["OS00002"]); //"주문정보가 존재하지 않습니다."
		exit;
	}

	$orderMgr->setO_NO($intO_NO);
	$row = $orderMgr->getOrderView($db);

	$param['o_no']			= $row['O_NO'];
	$param['order_by']		= "SO.SH_NO ASC";
	$intShopOrderListTotal	= $shopOrderMgr->getShopOrderListEx($db, "OP_COUNT", $param);
	$shopOrderListResult	= $shopOrderMgr->getShopOrderListEx($db, "OP_LIST", $param);


?>
<body>
<style type="text/css">
	#contentArea{position:relative;min-width:450px;padding:10px}
</style>
<script type="text/javascript">
<!--
	$(document).ready(function(){
	});
	
	/* 취소할 금액 계산 */
	function goOrderCancelCalAct()
	{
		var intChkCnt = 0;
		$("input:checkbox[id^=chkSocNo]").each(function(){ 
			if ($(this).is(":checked"))
			{
				intChkCnt++;
			}
		});		
		
		if (intChkCnt == 0)
		{
			alert("부분취소할 상품을 선택해주세요.");
			return;
		}
		document.form.menuType.value = "order";
		document.form.mode.value = "json";
		document.form.jsonMode.value = "partCancelCal";
//		document.form.submit();

		var formData = $("#form").serialize();
		C_AjaxPost("partCancelCal","./index.php",formData,"post");	
	}

	function goAjaxRet(name,result){
		if (name == "partCancelCal")
		{		
			var doc = document.form;
			var data = eval(result);
			
			if (data[0]["mode"] == "__SUCCESS__")
			{
				$("#totCancelPrice").val(data[0]["o_cancel_price"]);
				$("#recoveryPoint").val(data[0]["o_recovery_point"]);
			} else {
				alert(data[0]["text"]);
				return;
			}
		} 
	}
	

	function goOrderCancelAct()
	{
		document.form.menuType.value = "order";
		document.form.mode.value = "pg";
		document.form.act.value = "partCancel";
		document.form.action = "../kr/index.php";
		document.form.method = "post";
		document.form.submit();

	}
//-->
</script>
<div class="layerPopWrap">
	<div class="popTop">
		<h2><?=$LNG_TRANS_CHAR["OW00049"] //주문취소?></h2>			
		<a  href="javascript:parent.goPopClose();"><img src="/shopAdmin/himg/common/btn_pop_close.png" class="closeBtn"/></a>
		<div class="clr"></div>
	</div>
</div>
<div id="contentArea">
<form name="form" id="form" method="post">
	<input type="hidden" name="menuType" value="<?=$strMenuType?>">
	<input type="hidden" name="mode" value="<?=$strMode?>">
	<input type="hidden" name="act" value="<?=$strMode?>">
	<input type="hidden" name="jsonMode" value="">

	<input type="hidden" name="oNo" value="<?=$intO_NO?>">
	<input type='hidden' name='req_tx' value='mod'>
	<input type='hidden' name='mod_type' value='RN07'>
	<input type='hidden' name='payPg' value='<?=$row['O_PG']?>'>
	<input type='hidden' name='tno' value='<?=$row['O_APPR_NO']?>' size='20' maxlength='14'>
	<input type='hidden' name='reg_no' value='<?=$a_admin_no?>' size='20' maxlength='14'>
	<input type="hidden" name="totSettlePrice" id="totSettlePrice" value="<?=$row['O_TOT_SPRICE']?>">

	<!-- ******** 컨텐츠 ********* -->
	<div class="tableForm">
		<table>
			<tr>
				<th><?=$LNG_TRANS_CHAR["OW00002"] //주문번호?></th>
				<td><?=$row[O_KEY]?></td>
			</tr>
			<tr>
				<th><?=$LNG_TRANS_CHAR["OW00007"] //상품명?></th>
				<td><?=$row[O_J_TITLE]?></td>
			</tr>
			<tr>
				<th><?=$LNG_TRANS_CHAR["OW00048"] //취소사유?></th>
				<td>
					<input type="text" <?=$nBox?> id="mod_desc" name="mod_desc"  style="width:300px;" maxlength="50" value="<?=$row[O_CEL_MEMO]?>"/>
				</td>
			</tr>
			<tr>
				<th><?=$LNG_TRANS_CHAR["OW00050"] //환불은행?></th>
				<td>
					<select name='returnBank'>
						<option value="" selected>선택</option>
						<option value="39" <?=($row["O_RETURN_BANK"]=="39")?"selected":"";?>>경남은행</option>
						<option value="34" <?=($row["O_RETURN_BANK"]=="34")?"selected":"";?>>광주은행</option>
						<option value="04" <?=($row["O_RETURN_BANK"]=="04")?"selected":"";?>>국민은행</option>
						<option value="03" <?=($row["O_RETURN_BANK"]=="03")?"selected":"";?>>기업은행</option>
						<option value="11" <?=($row["O_RETURN_BANK"]=="11")?"selected":"";?>>농협</option>
						<option value="31" <?=($row["O_RETURN_BANK"]=="31")?"selected":"";?>>대구은행</option>
						<option value="32" <?=($row["O_RETURN_BANK"]=="32")?"selected":"";?>>부산은행</option>
						<option value="45" <?=($row["O_RETURN_BANK"]=="45")?"selected":"";?>>새마을금고</option>
						<option value="07" <?=($row["O_RETURN_BANK"]=="07")?"selected":"";?>>수협</option>
						<option value="88" <?=($row["O_RETURN_BANK"]=="88")?"selected":"";?>>신한은행</option>
						<option value="48" <?=($row["O_RETURN_BANK"]=="48")?"selected":"";?>>신협</option>
						<option value="05" <?=($row["O_RETURN_BANK"]=="05")?"selected":"";?>>외환은행</option>
						<option value="20" <?=($row["O_RETURN_BANK"]=="20")?"selected":"";?>>우리은행</option>
						<option value="71" <?=($row["O_RETURN_BANK"]=="71")?"selected":"";?>>우체국</option>
						<option value="35" <?=($row["O_RETURN_BANK"]=="35")?"selected":"";?>>제주은행</option>
						<option value="81" <?=($row["O_RETURN_BANK"]=="81")?"selected":"";?>>하나은행</option>
						<option value="27" <?=($row["O_RETURN_BANK"]=="27")?"selected":"";?>>한국시티은행</option>
						<option value="54" <?=($row["O_RETURN_BANK"]=="54")?"selected":"";?>>HSBC</option>
						<option value="23" <?=($row["O_RETURN_BANK"]=="23")?"selected":"";?>>SC제일은행</option>
						<option value="02" <?=($row["O_RETURN_BANK"]=="02")?"selected":"";?>>산업은행</option>
						<option value="37" <?=($row["O_RETURN_BANK"]=="37")?"selected":"";?>>전북은행</option>
					</select>
				</td>
			</tr>
			<tr>
				<th><?=$LNG_TRANS_CHAR["OW00051"] //환불계좌?></th>
				<td>
					<input type="text" <?=$nBox?> id="returnAcc" name="returnAcc"  style="width:150px;" maxlength="20" value="<?=$row[O_RETURN_ACC]?>"/>
				</td>
			</tr>
			<tr>
				<th><?=$LNG_TRANS_CHAR["OW00052"] //환불예금주?></th>
				<td>
					<input type="text" <?=$nBox?> id="returnName" name="returnName"  style="width:150px;" maxlength="20" value="<?=$row[O_RETURN_NAME]?>"/>
				</td>
			</tr>
		</table>	
	</div>
	<?if ($intShopOrderListTotal > 0){?>
	<div class="tableList" style="margin-top:10px;">
		<table>
			<tr>
				<th>입점사</th>
				<th>선택</th>
				<th>상품정보</th>
				<th>상품금액</th>
				<th>수량</th>
				<th>구매상태</th>
				<th>배송상태/배송비</th>
			</tr>
			<?
				while($shopOrderListRow = mysql_fetch_array($shopOrderListResult)){
					
					if($shopOrderListRow['SH_NO'] == 0) { $shopOrderListRow['ST_NAME'] = "본사"; }

					$param								= "";
					$param['o_no']						= $row['O_NO'];
					$param['p_shop_no']					= $shopOrderListRow['SH_NO'];
					$param['order_by']					= "OC.OC_NO ASC";
					$intShopOrderCartListTotal			= $shopOrderMgr->getOrderCartListEx($db, "OP_COUNT", $param);
					$aryShopOrderCartList				= $shopOrderMgr->getOrderCartListEx($db, "OP_ARYTOTAL", $param);
					
					$intRowSpan = $intShopOrderCartListTotal;
					$strRowSpanHtml = "";
					if ($intRowSpan > 1){
						$strRowSpanHtml = "rowspan=\"".$intRowSpan."\"";
					}
					

					if ($shopOrderListRow['SH_NO'] > 0 ) $intShopOrderDeliveryPrice = $shopOrderListRow['SH_COM_DELIVERY_PRICE'];
					else $intShopOrderDeliveryPrice = $S_DELIVERY_FEE;
			?>
			<tr>
				<td <?=$strRowSpanHtml?>><?=$shopOrderListRow['ST_NAME']?></td>
				<td><input type="checkbox" name="chkSocNo[]" id="chkSocNo[]" value="<?=$aryShopOrderCartList[0]['OC_NO']?>" <?=($aryShopOrderCartList[0]['SOC_STATUS'] == "C" && $aryShopOrderCartList[0]['SOC_C_STATUS'] == "2" )?"disabled":"";?>></td>
				<td>
					<img src="<?=$aryShopOrderCartList[0]['PM_REAL_NAME']?>" style="width:50px;height:50px"><br>
					<?=$aryShopOrderCartList[0]['P_NAME']?>
				</td>
				<td>
					<span id="spanOrderCartPrice_<?=$aryShopOrderCartList[0]['OC_NO']?>"><?=getFormatPrice($aryShopOrderCartList[0]['OC_CUR_PRICE'],2)?></span>	
				</td>
				<td>
					<span id="spanOrderCartQty_<?=$aryShopOrderCartList[0]['OC_NO']?>"><?=$aryShopOrderCartList[0]['OC_QTY']?></span>
				</td>
				<td>
					<?=$S_ARY_SETTLE_ORDER_STATUS[$aryShopOrderCartList[0]['SOC_STATUS'].$aryShopOrderCartList[0]['SOC_'.$aryShopOrderCartList[0]['SOC_STATUS'].'_STATUS']]?>
				</td>
				<td <?=$strRowSpanHtml?>>
					<?=$S_ARY_DELIVERY_STATUS[$shopOrderListRow['SO_DELIVERY_STATUS']]?>
					<select name="shopOrderDelivery_<?=$shopOrderListRow['SH_NO']?>" id="shopOrderDelivery_<?=$shopOrderListRow['SH_NO']?>">
						<option value="0">배송비</option>
						<?if ($intShopOrderDeliveryPrice>0){?>
						<option value="<?=$intShopOrderDeliveryPrice?>" <?=($shopOrderListRow['SO_TOT_DELIVERY_CUR_PRICE'] == $intShopOrderDeliveryPrice) ? "selected":"";?>><?=getFormatPrice($intShopOrderDeliveryPrice,2)?></option>
						<?}?>
						<?if ($intShopOrderDeliveryPrice>0 && $shopOrderListRow['SO_TOT_DELIVERY_CUR_PRICE'] > 0 && $shopOrderListRow['SO_TOT_DELIVERY_CUR_PRICE'] != $intShopOrderDeliveryPrice){?>
						<option value="<?=$shopOrderListRow['SO_TOT_DELIVERY_CUR_PRICE']?>"><?=getFormatPrice($shopOrderListRow['SO_TOT_DELIVERY_CUR_PRICE'],2)?></option>
						<?}?>
					</select>
				</td>
			</tr>
			<?
					if ($intShopOrderCartListTotal > 1)
					{
						for($i=1;$i<sizeof($aryShopOrderCartList);$i++){
			?>
			<tr>
				<td><input type="checkbox" name="chkSocNo[]" id="chkSocNo[]" value="<?=$aryShopOrderCartList[$i]['OC_NO']?>" <?=($aryShopOrderCartList[$i]['SOC_STATUS'] == "C" && $aryShopOrderCartList[$i]['SOC_C_STATUS'] == "2" )?"disabled":"";?>></td>
				<td>
					<img src="<?=$aryShopOrderCartList[$i]['PM_REAL_NAME']?>" style="width:50px;height:50px"><br>
					<?=$aryShopOrderCartList[$i]['P_NAME']?>
				</td>
				<td>
					<span id="spanOrderCartPrice_<?=$aryShopOrderCartList[$i]['OC_NO']?>"><?=getFormatPrice($aryShopOrderCartList[$i]['OC_CUR_PRICE'],2)?></span>
				</td>
				<td>
					<span id="spanOrderCartQty_<?=$aryShopOrderCartList[$i]['OC_NO']?>"><?=$aryShopOrderCartList[$i]['OC_QTY']?></span>
				</td>
				<td>
					<?=$S_ARY_SETTLE_ORDER_STATUS[$aryShopOrderCartList[$i]['SOC_STATUS'].$aryShopOrderCartList[$i]['SOC_'.$aryShopOrderCartList[$i]['SOC_STATUS'].'_STATUS']]?>
				</td>
			</tr>
						<?
						}
					}
				}
			?>
		</table>
	</div>
	<?}?>
	
	<div class="tableForm">
		<table>
			<tr>
				<th>총상품금액</th>
				<td>
					<?=getFormatPrice($row['O_TOT_PRICE'],2)?>
				</td>
			</tr>
			<tr>
				<th>총배송비</th>
				<td>
					<?=getFormatPrice($row['O_TOT_DELIVERY_PRICE'],2)?>
				</td>
			</tr>
			<?if($row['O_TAX_PRICE']>0){?>
			<tr>
				<th>총과세금액</th>
				<td>
					<?=getFormatPrice($row['O_TAX_PRICE'],2)?>
				</td>
			</tr>
			<?}?>
			<?if($row['O_TOT_MEM_DISCOUNT_PRICE'] > 0){?>
			<tr>
				<th>총할인금액</th>
				<td>
					<?=getFormatPrice($row['O_TOT_MEM_DISCOUNT_PRICE'],2)?>
				</td>
			</tr>
			<?}?>
			<?if($row[O_USE_POINT] > 0){?>
			<tr>
				<th>사용포인트</th>
				<td>
					<?=getFormatPrice($row[O_USE_POINT],2)?>
				</td>
			</tr>
			<?}?>
			<?if ($row[O_USE_COUPON] > 0){?>
			<tr>
				<th>사용쿠폰</th>
				<td><?=getFormatPrice($row[O_USE_COUPON],2)?></td>
			</tr>
			<?}?>
			<tr>
				<th>총결제금액</th>
				<td>
					<?=getFormatPrice($row['O_TOT_SPRICE'],2)?>
				</td>
			</tr>
		</table>
	</div>
	<div class="tableForm">
		<table>
			<tr>
				<th>총취소금액</th>
				<td>
					<input type="text" name="totCancelPrice" id="totCancelPrice" value="" readonly>
				</td>
			</tr>
			<tr>
				<th>복원포인트</th>
				<td><input type="text" name="recoveryPoint" id="recoveryPoint" value="" readonly></td>
			</tr>
		</table>	
	</div>
	<div class="helpTxt">
		<ul>
			<li>* PG사 부분취소 연동은 KCP(신용카드)만 가능합니다. </li>
			<li>* 부분취소는 배송상태와 무관하게 진행됩니다. 배송상태를 확인 후 진행해주세요.</li>
			<li>* 입점사별 상품을 취소시 배송비가 변경되었을 경우 배송비를 직접 선택해주셔야 합니다.</li>
			<li>* 전체 주문을 취소할 경우 [전체취소]를 이용하여 취소해주세요. </li>
		</ul>
	</div>

	<div class="buttonWrap">
		<a class="btn_blue_big" href="javascript:goOrderCancelCalAct();" id="menu_auth_w"><strong>잔액계산</strong></a>

		<a class="btn_blue_big" href="javascript:goOrderCancelAct();" id="menu_auth_w"><strong><?=$LNG_TRANS_CHAR["CW00080"] //취소하기?></strong></a>
		<a class="btn_big" href="javascript:parent.goPopClose();"><strong><?=$LNG_TRANS_CHAR["CW00042"] //닫기?></strong></a>
	</div>
</form>
</div>
</body>
</html>