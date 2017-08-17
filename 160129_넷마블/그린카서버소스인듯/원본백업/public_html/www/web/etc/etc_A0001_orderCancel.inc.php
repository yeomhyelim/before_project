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
			/* 결제 완료 */			
			$strReqTx	= "mod";
			$strModType	= "STSC";
	
			if ($S_SITE_LNG == "KR")
			{
				switch ($row['O_PG']){
					case "K";
						if ($row['O_ESCROW'] == "Y"){							
							$strReqTx	= "mod_escrow";
							$strModType	= "STE2";
						}
					break;
					case "A":
						/*	신용카드가 바로 취소/일반결제(계좌이체/가상계좌)는 자동 취소가 되지 않으므로 관리자가 
							확인 후 취소 처리 됨(에스크로 결제는 구매취소요청으로 감)
						*/
						if ($row['O_ESCROW'] == "Y"){							
							$strReqTx	= "mod_escrow";
							$strModType	= "STE2";
						
						} else {
							if ($row['O_SETTLE'] != "C"){
								$strModType	= "STE3";
							}
						}
					break;
				}
			}
			/* 결제 완료 */
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

	$strAct = $strMenuType = $strMode = ""; 
	switch($row[O_SETTLE]){
		case "B":
		case "P":
			/* 무통장입금/포인트 결제 */
			$strMenuType = "order";
			$strMode	 = "act";
			$strAct		 = "orderCancel";
			/* 무통장입금/포인트 결제 */
		break;

		case "Y":
			/* 페이팔 결제			  */
			$strMenuType = "order";
			$strMode	 = "pg";
			$strAct		 = "void";
			/* 페이팔 결제			  */
		break;

		case "X":
			/* Eximbay 결제			  */
			$strMenuType = "order";
			$strMode	 = "pg";
			$strAct		 = "eximbayVoid";
			/* Eximbay 결제			  */
		
			$strForSettleCur	= $row['O_USE_CUR'];
			$strForSettleLang	= $row['O_USE_LNG'];
			if ($row['O_USE_CUR'] == "IDR") $strForSettleCur = "USD";
			if ($row['O_USE_LNG'] == "ID" || $row['O_USE_LNG'] == "US") $strForSettleLang = "EN";
			
			$strEximbayLinkBuf	= ${"S_EXIMBAY_".$strForSettleLang."_SECRET_KEY"}. "?mid=" . ${"S_EXIMBAY_".$strForSettleLang."_MID"} ."&ref=" . $row['O_KEY'] ."&cur=" .$strForSettleCur ."&amt=" .$row['O_TOT_SPRICE'];
			$strEximbayFgKey	= md5($strEximbayLinkBuf);
		
		break;

		case "C":
		case "A":
		case "T":
		case "M":
			/* 신용카드/계좌이체/가상계좌 */
			if ($row['O_PG'] == "K") {
				/* KCP */
				$strMenuType = "order";
				$strMode	 = "pg";
				$strAct		 = "pg";
				/* KCP */
			} else if ($row["O_PG"] == "A"){
				/* AGS */
				$strMenuType = "order";
				$strMode	 = "pg";
				$strAct		 = "agsCancel";

				if ($row['O_ESCROW'] == "Y"){
					$strMenuType = "order";
					$strMode	 = "pg";
					$strAct		 = "agsEscrow";
					
					$strAgsTrCode = "E400";
				}
				/* AGS */
			} else if ($row["O_PG"] == "N"){
				
				/* KSNET */
				$strMenuType = "order";
				$strMode	 = "pg";
				$strAct		 = "ksnetCancel";
				/* KSNET */
			} else if($row['O_PG'] == 'I') {
				$strMenuType = "order";
				$strMode	 = "pg";
				$strAct		 = "INIescrowCancel";
			}

			/* 신용카드/계좌이체/가상계좌 */
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
		<?if (($row[O_PG] != "Y" && $S_SITE_LNG == "KR") || ($row[O_PG] == "X")){?>
		if(!C_chkInput("mod_desc",true,"<?=$LNG_TRANS_CHAR['OW00059']?>",true)) return; //취소사유
		

		<?if ($S_SITE_LNG == "KR" && ($row[O_SETTLE] == "T" || $row[O_SETTLE] == "A" || $row[O_SETTLE] == "B") && ($row[O_STATUS] != "J" && $row[O_STATUS] != "O")){?>
		<?if ($row['O_PG'] == "A" && $row['O_ESCROW'] == "Y"){?><?}else{?>
		
		if(!C_chkInput("returnBank",true,"<?=$LNG_TRANS_CHAR['OW00054']?>",true)) return; //환불은행
		if(!C_chkInput("returnAcc",true,"<?=$LNG_TRANS_CHAR['OW00054']?>",true)) return; //환불계좌
		if(!C_chkInput("returnName",true,"<?=$LNG_TRANS_CHAR['OW00054']?>",true)) return; //환불예금주
		<?}}?>
		<?}?>

		<?if ($row['O_SETTLE'] == "X"){?>
			document.cancelForm.reason.value = document.form.mod_desc.value;
			document.cancelForm.param2.value = document.form.mod_desc.value;

			goInitLoading("loading");
			document.cancelForm.submit();
		<?}else{?>
		var doc = document.form;
		doc.method = "post";
		doc.action = "./index.php";
		doc.menuType.value = "<?=$strMenuType?>";
		doc.mode.value = "<?=$strMode?>";
		doc.act.value = "<?=$strAct?>";
		
		goInitLoading("loading");
		doc.submit();
		<?}?>
	}

	/* 주문 로빙바 구현 */
	function goInitLoading(loadingMode)
	{
		if(loadingMode == "loading") {
			$("#btnOrderCancel").attr("href","javascript:alert('loading....');");
		} else {
			$("#btnOrderCancel").attr("href","javascript:goOrderCancelAct();");
		}
	}
//-->
</script>
<body>
<div class="popContainer popOrderCancelWrap">
	<div class="cancelHight">
	<div class="titWrap"><h2><?=$LNG_TRANS_CHAR["OW00025"]; //주문최소?></h2></div>
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
	<input type="hidden" name="trcode"   value="<?=$strAgsTrCode?>" />

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
			<?if (($row[O_PG] != "Y" && $S_SITE_LNG == "KR") || ($row[O_PG] == "X" && $S_SITE_LNG != "KR")){?>
			<tr>
				<th><?=$LNG_TRANS_CHAR['OW00059'] //취소사유?></th>
				<td style="text-align:left;"><input type="input" id="mod_desc" name="mod_desc" class="defInput _w200" maxlength="50"/></td>
			</tr>
			<?if ($S_SITE_LNG == "KR" && ($row[O_SETTLE] == "T" || $row[O_SETTLE] == "A" || $row[O_SETTLE] == "B") && ($row[O_STATUS] != "J" && $row[O_STATUS] != "O")){?>
				<?if ($row['O_PG'] == "A" && $row['O_ESCROW'] == "Y"){?>
				<?} else {?>
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
			<?}?>
			<?}?>
			<?}?>
		</table>
		</div><!-- tableForm -->
	</div>
	<div class="btnCenter">		
		<a href="javascript:self.close();" class="popCloseBtn"><span><?=$LNG_TRANS_CHAR["CW00034"]; //닫기?></span></a>
		<a href="javascript:goOrderCancelAct();" class="popOrderCancelBtn" id="btnOrderCancel"><span><?=$LNG_TRANS_CHAR["CW00051"]; //주문최소?></span></a>
	</div>
	</div>
</div>
</form>
<?if ($row['O_SETTLE'] == "X"){?>
<form name="cancelForm" method="post" action="<?=$SITE_EXIMBAY_CANCEL_URL?>">
<input type="hidden" name="ver" id="ver" value="140">
<input type="hidden" name="mid" id="mid" value="<?=${"S_EXIMBAY_".$strForSettleLang."_MID"}?>">
<input type="hidden" name="txntype" id="txntype" value="VOID">
<input type="hidden" name="ref" value="<?=$row['O_KEY']?>"> <!--mandatory-->
<input type="hidden" name="cur" value="<?=$strForSettleCur?>">
<input type="hidden" name="amt" value="<?=$row['O_TOT_SPRICE']?>">
<input type="hidden" name="voidamt" value="<?=$row['O_TOT_SPRICE']?>">
<input type="hidden" name="transid" value="<?=$row['O_APPR_NO']?>">
<input type="hidden" name="reason" value="">
<input type="hidden" name="lang" value="<?=$strForSettleLang?>"> <!--mandatory-->
<input type="hidden" name="returnurl" id="returnurl" value="<?=$S_SITE_URL?>/common/eximbay/cancelReturn.php">
<input type="hidden" name="param1" id="param1" value="<?=$intO_NO?>">
<input type="hidden" name="param2" id="param2" value="">
<input type="hidden" name="param3" id="param3" value="<?=$S_SITE_LNG?>_U">
<input type="hidden" name="fgkey" value="<?=$strEximbayFgKey?>">
<input type="hidden" name="charset" value="UTF-8">
</form>
<?}?>
</body>
</html>