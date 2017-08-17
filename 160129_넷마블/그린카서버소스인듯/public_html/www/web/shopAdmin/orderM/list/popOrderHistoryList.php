<? include "./include/header.inc.php"?>
<?
	require_once MALL_CONF_LIB."OrderAdmMgr.php";
	require_once MALL_CONF_LIB."ShopOrderNewMgr.php";
	
	/*상품함수관련*/
	require_once MALL_PROD_FUNC;

	$orderMgr = new OrderMgr();
	$shopOrderMgr = new ShopOrderMgr();

	$intO_NO		= $_POST["no"]				? $_POST["no"]				: $_REQUEST["no"];
	
	if (!$intO_NO){
		$db->disConnect();
		goClose($LNG_TRANS_CHAR["OS00002"]); //"주문정보가 존재하지 않습니다."
		exit;
	}

	$orderMgr->setO_NO($intO_NO);
	$orderRow = $orderMgr->getOrderView($db);	
	
	$param["o_no"] = $intO_NO;
	$aryOrderHistoryList = $shopOrderMgr->getOrderHistoryList($db,"OP_ARYTOTAL",$param);
?>
<style type="text/css">
	#contentArea{position:relative;min-width:750px;padding:10px}
</style>
<script type="text/javascript">
<!--
	$(document).ready(function(){
		
	});
//-->
</script>
<div class="layerPopWrap">
	<div class="popTop">
		<h2><?=$LNG_TRANS_CHAR["OW00133"] //내역관리?><a  href="javascript:parent.goPopClose();"><img src="/shopAdmin/himg/common/btn_pop_close.png" class="closeBtn"/></a>
		<div class="clear"></div>
	</div>
</div>
<div id="contentArea">
	<div class="tableForm" style="margin-top:10px;">
		<table>
			<tr>
				<th><?=$LNG_TRANS_CHAR["OW00002"] //주문번호?></th>
				<td><?=$orderRow[O_KEY]?></td>
			</tr>
			<tr>
				<th><?=$LNG_TRANS_CHAR["OW00007"] //상품명?></th>
				<td><?=$orderRow[O_J_TITLE]?></td>
			</tr>
		</table>
	</div>
	<div class="tableList" style="margin-top:10px;">
		<table>
			<tr>
				<th>번호</th>
				<th>구분</th>
				<th>사유</th>
				<th>입점사</th>
				<th>등록자</th>
				<th>등록일</th>
			</tr>
			<?
				if (is_array($aryOrderHistoryList)){
					$intNum = sizeof($aryOrderHistoryList);
					for($i=0;$i<sizeof($aryOrderHistoryList);$i++){
					
						$strHistoryGubun = $strHistoryName = $strHistoryText = $param = "";
						if ($aryOrderHistoryList[$i]['H_CODE'] == "002"){
							$strHistoryGubun = "구매상태";

							$aryHistroyText = explode("/",$aryOrderHistoryList[$i]['H_TEXT']);
							if ($aryOrderHistoryList[$i]['H_TEXT']){
								$param["oc_no"] = $aryHistroyText[0];
								$shopOrderCartRow = $shopOrderMgr->getShopOrderCartView($db,$param);
								
								$strHistoryText	= $S_ARY_SETTLE_ORDER_STATUS[$aryHistroyText[1]];
							}
						} else if ($aryOrderHistoryList[$i]['H_CODE'] == "003"){
							$strHistoryGubun = "배송상태";
							
							$aryHistroyText = explode("/",$aryOrderHistoryList[$i]['H_TEXT']);
							if ($aryOrderHistoryList[$i]['H_TEXT']){
								if ($aryHistroyText[0] > 0){
									$param["so_no"] = $aryHistroyText[0];
									$shopOrderCartRow = $shopOrderMgr->getShopOrderView($db,$param);
									$strHistoryText	= $S_ARY_DELIVERY_STATUS[$aryHistroyText[1]];
								}
							}
						}else if ($aryOrderHistoryList[$i]['H_CODE'] == "001"){
							$strHistoryGubun = "주문상태";
							$strHistoryText	= $S_ARY_SETTLE_STATUS[$aryOrderHistoryList[$i]['H_TEXT']];

							$orderMgr->setO_NO($aryOrderHistoryList[$i]['H_KEY']);
							$shopOrderCartRow = $orderMgr->getOrderView($db);
							if ($shopOrderCartRow['M_NO'] == $aryOrderHistoryList[$i]['M_NO']) $shopOrderCartRow['ST_NAME'] = "사용자";
						}

						$strHistoryName = $aryOrderHistoryList[$i]['M_NAME'];
						if ($S_MEM_CERITY == "1") $strHistoryName .= "(".$aryOrderHistoryList[$i]['M_ID'].")";						
					
						if (!$shopOrderCartRow['ST_NAME']) $shopOrderCartRow['ST_NAME'] = "본사";
					
					?>
			<tr>
				<td><?=$intNum--?></td>
				<td><?=$strHistoryGubun?></td>
				<td><?=strConvertCut2($aryOrderHistoryList[$i]['H_MEMO'],0,"N")?></td>
				<td><?=$shopOrderCartRow['ST_NAME']?><br><?=($strHistoryText)?"[".$strHistoryText."]":"";?></td>
				<td><?=$strHistoryName?></td>
				<td><?=$aryOrderHistoryList[$i]['H_REG_DT']?></td>
			</tr>
					<?
					}
				}
			?>
		</table>
	</div>
</div>
<div class="buttonWrap">
	<a class="btn_big" href="javascript:parent.goPopClose();"><strong><?=$LNG_TRANS_CHAR["CW00042"] //창닫기?></strong></a>
</div>
	
	<!-- ******************** contentsArea ********************** -->

</body>
</html>