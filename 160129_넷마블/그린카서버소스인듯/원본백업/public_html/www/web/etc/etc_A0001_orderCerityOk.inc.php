<?
	require_once MALL_CONF_LIB."OrderMgr.php";
	require_once "../conf/paypal_conf_inc.php";
	
	$orderMgr = new OrderMgr();

	$intO_NO		= $_POST["no"]				? $_POST["no"]				: $_REQUEST["no"];
	
	if (!$intO_NO){
		$db->disConnect();
		goClose($LNG_TRANS_CHAR["OS00044"]); //주문내역이 존재하지 않습니다.
		exit;
	}

	$orderMgr->setO_NO($intO_NO);
	$row = $orderMgr->getOrderView($db);
?>
<? include "./include/header.inc.php";?>
<script type="text/javascript">
<!--
	$(document).ready(function(){
		
		$('#id_no').numeric();
		$("#id_no").css("ime-mode", "disabled"); 

	});	
	
	function goOrderCerityAct()
	{
		if(!C_chkInput("id_no",true,"<?=$LNG_TRANS_CHAR['OW00010']?>",true)) return; //휴대폰
		
		var doc = document.form;
		doc.method = "post";
		doc.action = "./index.php";
		doc.menuType.value = "order";
		doc.mode.value = "pg";
		doc.act.value = "agsEscrow";
		doc.submit();
	}
//-->
</script>
<body>
<div class="popContainer">
	<div class="cancelHight">
	<h2><?=$LNG_TRANS_CHAR["OW00100"]; //구매확정?></h2>
	<form name='form' method='post'>
	<input type="hidden" name="menuType" value="<?=$strMenuType?>">
	<input type="hidden" name="mode" value="<?=$strMode?>">
	<input type="hidden" name="act" value="<?=$strMode?>">
	<input type="hidden" name="order_no" id="order_no" value="<?=$intO_NO?>">
	<input type="hidden" name="oNo" id="oNo" value="<?=$intO_NO?>">
	<input type="hidden" name="trcode"   value="E200" />
	<div class="mt10">
		<div class="popTableList">
			<table>
				<colgroup>
					<col style="width:100px;"/>
					<col/>
				</colgroup>
				<tr>
					<th><?=$LNG_TRANS_CHAR["OW00057"] //주문번호?></th>
					<td style="text-align:left;"><?=$row[O_KEY]?></td>
				</tr>
				<tr>
					<th><?=$LNG_TRANS_CHAR["OW00058"] //상품명?></th>
					<td style="text-align:left;"><?=$row[O_J_TITLE]?></td>
				</tr>
				<tr>
					<th><?=$LNG_TRANS_CHAR["OW00010"] //휴대폰?></th>
					<td style="text-align:left;">
						<input type="text" <?=$nBox?> id="id_no" name="id_no"  style="width:150px;" maxlength="13" value=""/>
						<br>* <?=$LNG_TRANS_CHAR["OS00079"] //에스크로 결제시 입력하셨던 휴대폰번호를 입력해주세요.?>
					</td>
				</tr>
			</table>
		</div>
	</div>
	<div class="btnCenter">
		<a href="javascript:goOrderCerityAct();" class="popOrderCancelBtn"><span><?=$LNG_TRANS_CHAR["OW00100"]; //구매확정?></span></a>
		<a href="javascript:self.close();" class="popCloseBtn"><span><?=$LNG_TRANS_CHAR["CW00034"]; //닫기?></span></a>
	</div>
	</div>
</div>
</form>
</body>
</html>