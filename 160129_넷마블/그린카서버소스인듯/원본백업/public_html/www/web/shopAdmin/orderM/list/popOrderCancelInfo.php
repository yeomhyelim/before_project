<? include "./include/header.inc.php"?>
<body>
<?
	require_once MALL_CONF_LIB."OrderAdmMgr.php";
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
		var strMsg = "<?=$LNG_TRANS_CHAR['OS00004']?>"; //주문취소처리를 완료하시겠습니까?
		var x = confirm(strMsg);
		if (x == true)
		{
			C_getAction("orderCancelUpdate","<?=$PHP_SELF?>");	
		}
	}
//-->
</script>
<div class="layerPopWrap">
	<div class="popTop">
		<h2><?=$LNG_TRANS_CHAR["OW00049"] //주문취소?></h2>			
		<a  href="javascript:parent.goPopClose();"><img src="/shopAdmin/himg/common/btn_pop_close.png" class="closeBtn"/></a>
		<div class="clear"></div>
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
				<td><?=$row['O_CEL_MEMO']?>
				</td>
			</tr>
			<?if ($row['O_RETURN_BANK'] && $row['O_RETURN_ACC']){?>
			<tr>
				<th><?=$LNG_TRANS_CHAR["OW00050"] //환불은행?></th>
				<td>
					<?=($row['O_USE_LNG']=="KR")?$S_ARY_RETURN_BANK[$row['O_RETURN_BANK']]:$row['O_RETURN_BANK'];?>/<?=$row['O_RETURN_ACC']?>/<?=$row['O_RETURN_NAME']?>
				</td>
			</tr>
			<?}?>
		</table>
	</div><!-- tableList -->

	<div class="buttonWrap">
		<?if($row['O_CEL_STATUS'] != "Y"){?><a class="btn_blue_big" href="javascript:goOrderCancelAct();" id="menu_auth_w"><strong><?=$LNG_TRANS_CHAR["OW00125"] //취소처리완료?></strong></a><?}?>
		<a class="btn_big" href="javascript:parent.goPopClose();"><strong><?=$LNG_TRANS_CHAR["CW00042"] //닫기?></strong></a>
	</div>
</form>
</div>
</body>
</html>