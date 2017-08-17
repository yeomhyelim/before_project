<? include "./include/header.inc.php"?>
<body>
<?
	require_once MALL_CONF_LIB."OrderMgr.php";
	require_once "../conf/paypal_conf_inc.php";
	
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
	
	$strMenuType = "order";
	$strMode	 = "act";
	$strAct		 = $strActMode;
	$strActPage		= "./index.php";

	switch($row[O_SETTLE]){
		case "Y":
			if (($row[O_STATUS] == "J" || $row[O_STATUS] == "O" || $row[O_STATUS] == "A") || ($row[O_STATUS] == "C" && $row[O_CEL_STATUS] == "N")) {

				$strMenuType = "order";
				$strMode	 = "pg";
				$strAct		 = "void";
				$strActPage	= "../".strtolower($row['O_USE_LNG'])."/index.php";
			}

		break;

		case "X":
			
			/* 바로취소/ 취소요청중 */
			if (($row[O_STATUS] == "J" || $row[O_STATUS] == "O" || $row[O_STATUS] == "A") || ($row[O_STATUS] == "C" && $row[O_CEL_STATUS] == "N")) {
		
				/* Eximbay 결제			  */
				$strMenuType = "order";
				$strMode	 = "pg";
				$strAct		 = "eximbayVoid";
				$strActPage	 = "../".strtolower($row['O_USE_LNG'])."/index.php";
				/* Eximbay 결제			  */
			
				$strForSettleCur	= $row['O_USE_CUR'];
				$strForSettleLang	= $row['O_USE_LNG'];
				if ($row['O_USE_CUR'] == "IDR") $strForSettleCur = "USD";
				if ($row['O_USE_LNG'] == "ID" || $row['O_USE_LNG'] == "US") $strForSettleLang = "EN";

				$strEximbayLinkBuf	= $S_EXIMBAY_SECRET_KEY. "?mid=" . $S_EXIMBAY_MID ."&ref=" . $row['O_KEY'] ."&cur=" .$strForSettleCur ."&amt=" .$row['O_TOT_SPRICE'];
				$strEximbayFgKey	= md5($strEximbayLinkBuf);
			}		

		break;
	}
?>
<style type="text/css">
	#contentArea{position:relative;min-width:450px;padding:10px}
</style>
<script type="text/javascript">
<!--
	$(document).ready(function(){
		
	});

	function goOrderCancelAct()
	{
		if(!C_chkInput("mod_desc",true,"<?=$LNG_TRANS_CHAR['OW00048']?>",false)) return; //취소사유
	
		document.charset = "UTF-8";
			
		<?if($strAct == "eximbayVoid"){?>
		document.cancelForm.reason.value = document.form.mod_desc.value;
		document.cancelForm.param2.value = document.form.mod_desc.value;
		document.cancelForm.submit();

		<?} else {?>

		document.form.menuType.value = "<?=$strMenuType?>";
		document.form.mode.value = "<?=$strMode?>";
		document.form.act.value = "<?=$strAct?>";
		document.form.action = "<?=$strActPage?>";
		document.form.method = "post";
		document.form.siteLng.value = "<?=$row['O_USE_LNG']?>";
		document.form.submit();
		<?}?>
		//C_getAction("<?=$strActMode?>","./index.php");	
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
	<input type="hidden" name="page" value="<?=$intPage?>">
	<input type="hidden" name="oNo" value="<?=$intO_NO?>">
	<input type="hidden" name="userType" value="A">
	<input type="hidden" name="siteLng" value="">
	<input type="hidden" name="vcnt_yn" value="<?=($row[O_SETTLE]=="T")?"Y":"N";?>">
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
					<?if ($row[O_STATUS] == "C" && $row[O_CEL_STATUS] == "N"){?>
					<input type="hidden" <?=$nBox?> id="mod_desc" name="mod_desc"  style="width:300px;" maxlength="50" value="<?=$row[O_CEL_MEMO]?>"/>
					<?=$row['O_CEL_MEMO']?>
					<?}else{?>
					<input type="text" <?=$nBox?> id="mod_desc" name="mod_desc"  style="width:300px;" maxlength="50" value="<?=$row[O_CEL_MEMO]?>"/>
					<?}?>
				</td>
			</tr>
			<?if (($row[O_USE_LNG] == "KR") && ($row[O_SETTLE] == "T" || $row[O_SETTLE] == "A" || $row[O_SETTLE] == "B") && ($row[O_STATUS] != "J" && $row[O_STATUS] != "O")){?>
				<?if ($row['O_PG'] == "A" && $row['O_ESCROW'] == "Y"){?>
				<?} else {?>

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
			<?}}?>
		</table>
	</div><!-- tableList -->

	<div class="buttonWrap">
		<a class="btn_blue_big" href="javascript:goOrderCancelAct();" id="menu_auth_w"><strong><?=$LNG_TRANS_CHAR["CW00008"] //취소하기?></strong></a>
		<a class="btn_big" href="javascript:parent.goPopClose();"><strong><?=$LNG_TRANS_CHAR["CW00042"] //닫기?></strong></a>
	</div>
</form>
</div>
<?if ($row['O_SETTLE'] == "X"){?>
<form name="cancelForm" method="post" action="<?=$SITE_EXIMBAY_CANCEL_URL?>">
<input type="hidden" name="ver" id="ver" value="140">
<input type="hidden" name="mid" id="mid" value="<?=$S_EXIMBAY_MID?>">
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
<input type="hidden" name="param3" id="param3" value="<?=$S_SITE_LNG?>_A">
<input type="hidden" name="fgkey" value="<?=$strEximbayFgKey?>">
<input type="hidden" name="charset" value="UTF-8">
</form>
<?}?>
</body>
</html>