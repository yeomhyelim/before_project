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

	$strActMode = "orderCancel";
	if ($row[O_STATUS] == "C" && $row[O_CEL_STATUS] == "P"){
		$strActMode = "orderCancelUpdate";
	}

?>
<? include "./include/header.inc.php"?>
<script type="text/javascript">
<!--
	$(document).ready(function(){
		
	});

	function goOrderCancelAct()
	{
		if(!C_chkInput("mod_desc",true,"<?=$LNG_TRANS_CHAR['OW00048']?>",false)) return; //취소사유
		
		document.charset = "UTF-8";
		document.form.menuType.value = "order";
		C_getAction("<?=$strActMode?>","./index.php");	
	
	}
//-->
</script>
	<table style="width:100%;">
		<tr>
			<td class="contentWrap">
				<!-- ******************** contentsArea ********************** -->
					<div class="layoutWrap">
					<form name="form" id="form" method="post">
						<input type="hidden" name="menuType" value="<?=$strMenuType?>">
						<input type="hidden" name="mode" value="<?=$strMode?>">
						<input type="hidden" name="act" value="<?=$strMode?>">
						<input type="hidden" name="page" value="<?=$intPage?>">
						<input type="hidden" name="oNo" value="<?=$intO_NO?>">
						<div id="contentArea">
							<div class="contentTop">
								<h2><?=$LNG_TRANS_CHAR["OW00049"] //주문취소?></h2>
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
										<th><?=$LNG_TRANS_CHAR["OW00048"] //취소사유?></th>
										<td>
											<input type="text" <?=$nBox?> id="mod_desc" name="mod_desc"  style="width:300px;" maxlength="50" value="<?=$row[O_CEL_MEMO]?>"/>
										</td>
									</tr>
									<?if (($row[O_SETTLE] == "T" || $row[O_SETTLE] == "A" || $row[O_SETTLE] == "B") && ($row[O_STATUS] != "J" && $row[O_STATUS] != "O")){?>

									<tr>
										<th><?=$LNG_TRANS_CHAR["OW00050"] //환불은행?></th>
										<td>
											<select name='returnBank'>
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
									<?}?>
								</table>
							</div><!-- tableList -->

							<div class="buttonWrap">
								<a class="btn_blue_big" href="javascript:goOrderCancelAct();;" id="menu_auth_w"><strong><?=$LNG_TRANS_CHAR["CW00008"] //취소하기?></strong></a>
								<a class="btn_big" href="javascript:self.close();"><strong><?=$LNG_TRANS_CHAR["CW00042"] //닫기?></strong></a>
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