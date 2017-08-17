<?
	require_once MALL_CONF_LIB."OrderMgr.php";
	
	$orderMgr = new OrderMgr();

	$intO_NO		= $_POST["no"]				? $_POST["no"]				: $_REQUEST["no"];
	
	if (!$intO_NO){
		$db->disConnect();
		goClose($LNG_TRANS_CHAR["OS00002"]); //"주문정보가 존재하지 않습니다."
		exit;
	}

	$orderMgr->setO_NO($intO_NO);
	$row = $orderMgr->getOrderView($db);

	/*배송회사*/
	$aryDeliveryCom = getCommCodeList("DELIVERY","Y");

?>
<? include "./include/header.inc.php"?>
<script type="text/javascript">
<!--
	$(document).ready(function(){
		
	});

	function goOrderDeliveryInputAct()
	{
		if(!C_chkInput("deliveryCom",true,"<?=$LNG_TRANS_CHAR['OW00053']?>",false)) return; //배송회사
		if(!C_chkInput("deliveryNo",true,"<?=$LNG_TRANS_CHAR['OW00054']?>",true)) return; //배송번호
		
		document.form.menuType.value = "order";
		C_getAction("orderDelvieryIinput","<?=$PHP_SELF?>");				
	}
//-->
</script>
<div id="contentArea">
	<table style="width:100%;">
		<tr>
			<td class="contentWrap">
				<!-- ******************** contentsArea ********************** -->
					<div class="layoutWrap">
					<form name="form" id="form">
						<input type="hidden" name="menuType" value="<?=$strMenuType?>">
						<input type="hidden" name="mode" value="<?=$strMode?>">
						<input type="hidden" name="act" value="<?=$strMode?>">
						<input type="hidden" name="page" value="<?=$intPage?>">
						<input type="hidden" name="oNo" value="<?=$intO_NO?>">
					
						<div id="contentArea">
							<div class="contentTop">
								<h2><?=$LNG_TRANS_CHAR["OW00044"] //배송정보 입력/수정?></h2>
							</div>
							<!-- ******** 컨텐츠 ********* -->
							<div class="tableForm" style="margin-top:10px;">
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
										<th><?=$LNG_TRANS_CHAR["OW00053"] //배송회사?></th>
										<td>
											<?=drawSelectBoxMore("deliveryCom",$aryDeliveryCom,$row[O_DELIVERY_COM],"","",$firstItem="",$html="선택")?>
										</td>
									</tr>
									<tr>
										<th><?=$LNG_TRANS_CHAR["OW00054"] //배송번호?></th>
										<td>
											<input type="text" <?=$nBox?> id="deliveryNo" name="deliveryNo"  style="width:150px;" maxlength="20" value="<?=$row[O_DELIVERY_NUM]?>"/>
										</td>
									</tr>
								</table>
							</div><!-- tableList -->

							<div class="buttonWrap">
								<a class="btn_blue_big" href="javascript:goOrderDeliveryInputAct();;" id="menu_auth_w"><strong><?=$LNG_TRANS_CHAR["CW00002"] //등록?></strong></a>
								<a class="btn_big" href="javascript:self.close();"><strong><?=$LNG_TRANS_CHAR["CW00008"] //취소?></strong></a>
							</div>
						</div>
					</form>
					</div>
				<!-- ******************** contentsArea ********************** -->
			</td>
		</tr>
	</table>
</div>
</body>
</html>