<? include "./include/header.inc.php"?>
<body>
<?
	require_once MALL_CONF_LIB."OrderAdmMgr2.php";
	
	$orderMgr = new OrderMgr2();

	$intOC_NO		= $_POST["no"]				? $_POST["no"]				: $_REQUEST["no"];
	
	if (!$intOC_NO){
		$db->disConnect();
		goClose($LNG_TRANS_CHAR["OS00002"]); //"주문정보가 존재하지 않습니다."
		exit;
	}

	$param["OC_NO"] = $intOC_NO;
	$row = $orderMgr->getShopOrderCartView($db,$param);

?>
<style type="text/css">
	#contentArea{position:relative;min-width:450px;padding:10px}
</style>
<script type="text/javascript">
<!--
	$(document).ready(function(){
		
	});

	function goOrderReturnAct()
	{
		if (!$("#shopOrderReturnStatus").val())
		{
			alert("구매상태를 선택해주세요.");
			return;
		}

		C_getAction("shopOrderReturnStatusUpdate","./index.php");	
	}
//-->
</script>
<div class="layerPopWrap">
	<div class="popTop">
		<h2>구매상태</h2>			
		<a  href="javascript:parent.goPopClose();"><img src="/shopAdmin/himg/common/btn_pop_close.png" class="closeBtn"/></a>
		<div class="clr"></div>
	</div>
</div>
<div id="contentArea">
<form name="form" id="form" method="post">
	<input type="hidden" name="menuType" value="<?=$strMenuType?>">
	<input type="hidden" name="mode" value="<?=$strMode?>">
	<input type="hidden" name="act" value="<?=$strMode?>">
	<input type="hidden" name="ocNo" value="<?=$intOC_NO?>">
	<!-- ******** 컨텐츠 ********* -->
	<div class="tableForm">
		<table>
			<tr>
				<th><?=$LNG_TRANS_CHAR["OW00002"] //주문번호?></th>
				<td><?=$row['O_KEY']?></td>
			</tr>
			<tr>
				<th><?=$LNG_TRANS_CHAR["OW00007"] //상품명?></th>
				<td><?=$row['P_NAME']?></td>
			</tr>
			<tr>
				<th>구매상태</th>
				<td>
					<select id="shopOrderReturnStatus" name="shopOrderReturnStatus">
						<option value="">선택</option>
						<?foreach($S_ARY_SETTLE_ORDER_STATUS as $key => $value):?>
						<option value="<?=$key?>"<?if($sRow['SO_ORDER_STATUS']==$key){echo " selected";}?>><?=$value?></option>
						<?endforeach;?>
					</select>
				</td>
			</tr>
			
		</table>
	</div><!-- tableList -->
	<div class="tableForm" style="margin-top:10px;display:none">
		<table>
			<tr>
				<th>환불은행</th>
				<td style="text-align:left;">
					<select name='returnBank' id="returnBank">
						<option value="" selected>선택</option>
						<option value="39">경남은행</option>
						<option value="34">광주은행</option>
						<option value="04">국민은행</option>
						<option value="03">기업은행</option>
						<option value="11">농협</option>
						<option value="31">대구은행</option>
						<option value="32">부산은행</option>
						<option value="45">새마을금고</option>
						<option value="07">수협</option>
						<option value="88">신한은행</option>
						<option value="48">신협</option>
						<option value="05">외환은행</option>
						<option value="20">우리은행</option>
						<option value="71">우체국</option>
						<option value="35">제주은행</option>
						<option value="81">하나은행</option>
						<option value="27">한국시티은행</option>
						<option value="54">HSBC</option>
						<option value="23">SC제일은행</option>
						<option value="02">산업은행</option>
						<option value="37">전북은행</option>
					</select>
				</td>
			</tr>
			<tr>
				<th>환불계좌</th>
				<td style="text-align:left;">
					<input type="text" <?=$nBox?> id="returnAcc" name="returnAcc"  style="width:150px;" maxlength="20" value="<?=$row[O_RETURN_ACC]?>"/>
				</td>
			</tr>
			<tr>
				<th>환불예금주</th>
				<td style="text-align:left;">
					<input type="text" <?=$nBox?> id="returnName" name="returnName"  style="width:150px;" maxlength="20" value="<?=$row[O_RETURN_NAME]?>"/>
				</td>
			</tr>
		</table>
	</div>

	<div class="buttonWrap">
		<a class="btn_blue_big" href="javascript:goOrderReturnAct();" id="menu_auth_w"><strong>구매상태변경</strong></a>
		<a class="btn_big" href="javascript:parent.goPopClose();"><strong><?=$LNG_TRANS_CHAR["CW00042"] //닫기?></strong></a>
	</div>
</form>
</div>
</body>
</html>