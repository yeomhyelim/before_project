<?
	require_once MALL_CONF_LIB."OrderMgr.php";
	
	$orderMgr = new OrderMgr();

	$intO_NO		= $_POST["no"]				? $_POST["no"]				: $_REQUEST["no"];
	
	if (!$intO_NO){
		$db->disConnect();
		goClose($LNG_TRANS_CHAR["OS00044"]); //주문내역이 존재하지 않습니다.
		exit;
	}

	$orderMgr->setO_NO($intO_NO);
	$row = $orderMgr->getOrderView($db);
	
	$strReqTx = $strModType = "";
	switch ($row[O_STATUS]){
		case "J": //주문완료
		case "O": //입금확인중
			
			$strReqTx	= "mod";
			$strModType	= "STSC";
			
			if ($row[O_ESCROW] == "Y"){
				$strReqTx	= "mod_escrow";
				$strModType	= "STE2";

				if ($row[O_SETTLE] == "T"){
					if ($row[O_STATUS] == "J" || $row[O_STATUS] == "O"){
						$strModType	= "STE5";
					}
				}
			}
		
		break;

		case "A":
			
			$strReqTx	= "mod";
			$strModType	= "STSC";
			
			if ($row[O_ESCROW] == "Y"){
				$strReqTx	= "mod_escrow";
				$strModType	= "STE2";
			}

		break;

		case "B": //배송준비
		case "I": //배송중
		case "D": //배송완료
			
			if ($row[O_ESCROW] == "Y"){
				$strReqTx	= "mod_escrow";
				$strModType	= "STE3";
			} 
				
		break;
	}
?>
<? include "./include/header.inc.php";?>
<script type="text/javascript">
<!--
	/* 취소 버튼을 눌렀을 때 호출 */
    function  jsf__go_cancel( form )
    {
        var RetVal = false ;
        if ( form.tno.value.length < 14 )
        {
            alert( "KCP 거래 번호를 입력하세요" );
            form.tno.focus();
            form.tno.select();
        }
        else
        {
            //openwin = window.open( "proc_win.html", "proc_win", "width=449, height=209, top=300, left=300" );
            RetVal = true ;
        }
        return RetVal ;
    }

	function goOrderCancelAct()
	{
		<?if ($row[O_PG] != "Y" && $S_SITE_LNG == "KR"){?>
		if(!C_chkInput("mod_desc",true,"<?=$LNG_TRANS_CHAR['OW00059']?>",true)) return; //취소사유
		
		<?if (($row[O_SETTLE] == "T" || $row[O_SETTLE] == "A" || $row[O_SETTLE] == "B") && ($row[O_STATUS] != "J" && $row[O_STATUS] != "O")){?>
		if(!C_chkInput("returnBank",true,"<?=$LNG_TRANS_CHAR['OW00054']?>",true)) return; //환불은행
		if(!C_chkInput("returnAcc",true,"<?=$LNG_TRANS_CHAR['OW00054']?>",true)) return; //환불계좌
		if(!C_chkInput("returnName",true,"<?=$LNG_TRANS_CHAR['OW00054']?>",true)) return; //환불예금주
		<?}?>
		<?}?>

		<?if ($row[O_SETTLE] == "B"  || $row[O_SETTLE] == "P"){?>
		var doc = document.form;
		doc.method = "post";
		doc.action = "./index.php";
		doc.menuType.value = "order";
		doc.mode.value = "act";
		doc.act.value = "orderCancel";
		doc.submit();
		<?}else{?>
		var doc = document.form;
		doc.method = "post";
		doc.action = "./index.php";
		doc.menuType.value = "order";
		doc.mode.value = "pg";
		doc.act.value = "<?=($row[O_PG]=='K') ? 'pg':'void';?>";
		doc.submit();
		<?}?>
	}
//-->
</script>
<body>
<div class="popContainer">
	<div class="cancelHight">
	<h3><?=$LNG_TRANS_CHAR["OW00025"]; //주문최소?></h3>
	<form name='form' method='post'>
	<input type="hidden" name="menuType" value="<?=$strMenuType?>">
	<input type="hidden" name="mode" value="<?=$strMode?>">
	<input type="hidden" name="act" value="<?=$strMode?>">
	<input type="hidden" name="order_no" id="order_no" value="<?=$intO_NO?>">
	<input type="hidden" name="oNo" id="oNo" value="<?=$intO_NO?>">
	<input type="hidden" name="req_tx"   value="<?=$strReqTx?>"  />
	<input type="hidden" name="mod_type" value="<?=$strModType?>" />
	<input type="hidden" name="vcnt_yn" value="<?=($row[O_SETTLE]=="T")?"Y":"N";?>">
	<input type="hidden" name="payPg" value="<?=$row[O_PG]?>">
	<input type="hidden" name="returnMode"   value="" />

	<div class="tableOrderForm mt10">
		<div class="tableform">
		<table>
			<colgroup>
				<col style="width:100px;"/>
				<col/>
			</colgroup>
			<tr>
				<th><?=$LNG_TRANS_CHAR["OW00057"] //주문번호?></th>
				<td><?=$row[O_KEY]?></td>
			</tr>
			<tr>
				<th><?=$LNG_TRANS_CHAR["OW00058"] //상품명?></th>
				<td><?=$row[O_J_TITLE]?></td>
			</tr>
			<?if ($row[O_PG] != "Y" && $S_SITE_LNG == "KR"){?>
			<tr>
				<th>취소사유</th>
				<td><input type="input" id="mod_desc" name="mod_desc" class="defInput _w200" maxlength="50"/></td>
			</tr>
			<?if (($row[O_SETTLE] == "T" || $row[O_SETTLE] == "A" || $row[O_SETTLE] == "B") && ($row[O_STATUS] != "J" && $row[O_STATUS] != "O")){?>
			<tr>
				<th>환불은행</th>
				<td>
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
				<td>
					<input type="text" <?=$nBox?> id="returnAcc" name="returnAcc"  style="width:150px;" maxlength="20" value="<?=$row[O_RETURN_ACC]?>"/>
				</td>
			</tr>
			<tr>
				<th>환불예금주</th>
				<td>
					<input type="text" <?=$nBox?> id="returnName" name="returnName"  style="width:150px;" maxlength="20" value="<?=$row[O_RETURN_NAME]?>"/>
				</td>
			</tr>
			<?}?>
			<?}?>
		</table>
		</div><!-- tableForm -->
	</div>
	<div class="btnCenter">
		<a href="javascript:goOrderCancelAct();" class="pop_ChkOkBtn"><span><?=$LNG_TRANS_CHAR["CW00051"]; //주문최소?></span></a>
		<a href="javascript:self.close();" class="btn_popClose"><span><?=$LNG_TRANS_CHAR["CW00034"]; //닫기?></span></a>
	</div>
	</div>
</div>
</form>
</body>
</html>