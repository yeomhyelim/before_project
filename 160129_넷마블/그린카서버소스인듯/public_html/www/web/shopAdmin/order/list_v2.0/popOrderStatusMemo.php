<? include "./include/header.inc.php"?>
<body>
<?
	require_once MALL_CONF_LIB."OrderMgr.php";
	require_once "../conf/paypal_conf_inc.php";
	
	$orderMgr = new OrderMgr();
	
	$intOC_NO		= $_POST["ocNo"]	? $_POST["ocNo"]				: $_REQUEST["ocNo"];
	$strStatus		= $_REQUEST["status"];
	$strGb			= $_REQUEST["gb"];	

	if ($strGb != "all")
	{
		if (!$intOC_NO){
			$db->disConnect();
			goClose($LNG_TRANS_CHAR["OS00002"]); //"주문정보가 존재하지 않습니다."
			exit;
		}

		if (!$strStatus){
			$db->disConnect();
			goClose($LNG_TRANS_CHAR["OS00025"]); //"변경할 구매 상태가 존재하지 않습니다."
			exit;
		}
	}
?>
<style type="text/css">
	#contentArea{position:relative;min-width:450px;padding:10px}
</style>
<script type="text/javascript">
<!--
	$(document).ready(function(){
		
	});

	function goOrderStatusMemoAct()
	{
		if(!C_chkInput("orderStatusMemo",true,"<?=$LNG_TRANS_CHAR['OW00132']?>",false)) return; //변경사유
		
		<?if ($strGb == "all"){?>
		
			parent.document.form.orderStatysMemo.value = document.form.orderStatusMemo.value;
			parent.goOrderStatusSaveAllAct();
			
		<?} else {?>

			var url				= "./?menuType=order&mode=json&jsonMode=orderStatusSave&oc_no=<?=$intOC_NO?>&orderStatus=<?=$strStatus?>&orderStatusMemo="+encodeURIComponent(document.form.orderStatusMemo.value);
			$.getJSON(url,function(data){	
				try {
					switch(data['mode']){
						case "__ERROR__":
							alert(data['text']);
						break;
						case "__SUCCESS__":
							alert(data['text']);
							parent.location.reload();
						break;
					}
				} catch(e) {
					console.log("system error");
				} finally {
				}
			});
		<?}?>
	}
//-->
</script>
<div class="layerPopWrap">
	<div class="popTop">
		<h2><?=$LNG_TRANS_CHAR["OW00131"] //구매상태변경?></h2>			
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
	<input type="hidden" name="oc_no" value="<?=$intOC_NO?>">
	<input type="hidden" name="orderStatus" value="<?=$strStatus?>">
	<!-- ******** 컨텐츠 ********* -->
	<div class="tableForm">
		<table>
			<tr>
				<th><?=$LNG_TRANS_CHAR["OW00132"] //변경사유?></th>
				<td>
					<textarea name="orderStatusMemo" id="orderStatusMemo" style="width:100%;height:80px"></textarea>
				</td>
			</tr>
		</table>
	</div><!-- tableList -->

	<div class="buttonWrap">
		<a class="btn_blue_big" href="javascript:goOrderStatusMemoAct();" id="menu_auth_w"><strong><?=$LNG_TRANS_CHAR["CW00078"] //변경하기?></strong></a>
		<a class="btn_big" href="javascript:parent.goPopClose();"><strong><?=$LNG_TRANS_CHAR["CW00042"] //닫기?></strong></a>
	</div>
</form>
</div>
</body>
</html>