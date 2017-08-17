<? include "./include/header.inc.php"?>
<?
	require_once MALL_CONF_LIB."ProductAdmMgr.php";

	$productMgr = new ProductAdmMgr();		

	$strP_CODE		= $_POST["prodCode"]		? $_POST["prodCode"]		: $_REQUEST["prodCode"];

	$productMgr->setP_LNG($strStLng);
	$productMgr->setP_CODE($strP_CODE);
	$prodRow = $productMgr->getProdView($db);

	$productMgr->setPO_TYPE("O");
	$aryProdOpt = $productMgr->getProdOpt($db);
	if (is_array($aryProdOpt)){
		for($i=0;$i<sizeof($aryProdOpt);$i++){
			if ($aryProdOpt[$i][PO_NO] > 0){
				$productMgr->setPO_NO($aryProdOpt[$i][PO_NO]);
				$aryProdOpt[$i][OPT_ATTR] = $productMgr->getProdOptAttr($db);
			}
			
			$intProdOptAttrRowCnt = 0;
			for($j=1;$j<=10;$j++){
			
				if ($aryProdOpt[$i]["PO_NAME".$j]){
					
					$productMgr->setPOA_ATTR_GROUP($j);
					if (!$intProdOptAttrRowCnt) $intProdOptAttrRowCnt = $productMgr->getProdOptAttrGroupLimitCount($db);
					else {

						if ($productMgr->getProdOptAttrGroupLimitCount($db) > $intProdOptAttrRowCnt){
							$intProdOptAttrRowCnt = $productMgr->getProdOptAttrGroupLimitCount($db);
						}
					}
			
					$aryProdOptAttrLimit[$aryProdOpt[$i][PO_NO]][$j] = $productMgr->getProdOptAttrGroupLimitDetail($db);
					
					$strProdOptAttrVal = "";
					if (is_array($aryProdOptAttrLimit[$aryProdOpt[$i][PO_NO]][$j])){
						for($k=0;$k<sizeof($aryProdOptAttrLimit[$aryProdOpt[$i][PO_NO]][$j]);$k++){
							$strProdOptAttrVal .= $aryProdOptAttrLimit[$aryProdOpt[$i][PO_NO]][$j][$k][POA_ATTR].";";
						}

						$strProdOptAttrVal = SUBSTR($strProdOptAttrVal,0,STRLEN($strProdOptAttrVal)-1);
						$aryProdOpt[$i]["PO_NAME_VAL".$j] = $strProdOptAttrVal;
					}
				} else {
					$aryProdOptAttrLimit[$aryProdOpt[$i][PO_NO]][$j] = array();
				}
			}
		}

	} else {
		$aryProdOpt = array();
	}
			

?>
<style type="text/css">
	#contentArea{position:relative;min-width:500px;padding:10px}
</style>
<script type="text/javascript">
<!--
	var strInputBoxStyle = " class=\"nbox\" onfocus=\"this.className='sbox'\" onblur=\"this.className='nbox'\"";

	$(document).ready(function(){
		
		$('input[id^=prodOptAttrQty1]').numeric();
		$("input[id^=prodOptAttrQty1]").css("ime-mode", "disabled"); 

		$("input[id^=prodOptAttrQty1]").blur(function(){ 
			var intQty = 0;	
			$("input[id^=prodOptAttrQty1]").each(function(){ 
				intQty = intQty + parseInt($(this).val());
				$("#spanTotQty").text(C_toNumberFormatString(intQty,false));
			});
		});
	});

	function goStockOptUdate()
	{
		var x = confirm("옵션 수량을 변경하시겠습니까?");
		if (x == true)
		{
			var doc = document.form;
			doc.mode.value = "json";
			doc.act.value = "";
			doc.jsonMode.value = "optStockUpdate";
			var formData = $("#form").serialize();
			C_AjaxPost("optStockUpdate","./index.php",formData,"post");		
		}
	}

	function goClose()
	{
		parent.location.reload();
		parent.goPopClose();
	}

	function goAjaxRet(name,result){

		if (name == "optStockUpdate")
		{			
			var doc = document.form;
			var data = eval(result);
			
			parent.goStockOptTotQtySet(doc.prodCode.value,data[0].QTY);
		}
	}
//-->
</script>
<div class="layerPopWrap">
	<div class="popTop">
		<h2>[<?=$prodRow[P_NAME]?>] 옵션 재고관리</h2>			
		<a  href="javascript:parent.goPopClose();"><img src="/shopAdmin/himg/common/btn_pop_close.png" class="closeBtn"/></a>
		<div class="clr"></div>
	</div>
</div>
<div id="contentArea">
<form name="form" id="form">
<input type="hidden" name="menuType" value="<?=$strMenuType?>">
<input type="hidden" name="mode" value="<?=$strMode?>">
<input type="hidden" name="act" value="<?=$strMode?>">
<input type="hidden" name="page" value="<?=$intPage?>">	
<input type="hidden" name="prodCode" id="prodCode" value="<?=$strP_CODE?>">	
<input type="hidden" name="jsonMode" id="jsonMode" value="">
	<!-- ******** 컨텐츠 ********* -->
	<div class="tableList">
		<table>
			<colgroup>
				<col/>
				<col style="width:90px;"/>
			</colgroup>
			<tr>
			<?
			for ($i=1;$i<=10;$i++){
					$strProdOptName = $aryProdOpt[0]["PO_NAME".$i];
					if ($strProdOptName){
						echo "<th>".$strProdOptName."</th>";
					}
				}?>
				<th><?=$LNG_TRANS_CHAR["PW00017"] //재고?></th>
			</tr>
			<?
				$intProdOptAttrCnt = $intProdOptAttrQty = 0;
				for($i=0;$i<sizeof($aryProdOpt);$i++){
					$intProdOptNo = $i + 1;
					$intProdOptAttrCnt = sizeof($aryProdOpt[$i][OPT_ATTR]);
					if (is_array($aryProdOpt[$i][OPT_ATTR])) {
						for($j=0;$j<sizeof($aryProdOpt[$i][OPT_ATTR]);$j++){
			?>
			<tr >
				<input type="hidden" id="prodOptAttrNo<?=$intProdOptNo?>[]" name="prodOptAttrNo<?=$intProdOptNo?>[]" value="<?=$aryProdOpt[$i][OPT_ATTR][$j][POA_NO]?>">
				<?
				for ($kk=1;$kk<=10;$kk++){
					$strProdOptName = $aryProdOpt[0]["PO_NAME".$kk];
					if ($strProdOptName){
						$intProdOptAttrQty = $intProdOptAttrQty + $aryProdOpt[$i][OPT_ATTR][$j][POA_STOCK_QTY];
						?>
				<td>
					<?=$aryProdOpt[$i][OPT_ATTR][$j]["POA_ATTR".$kk]?>
				</td>						
						<?
					}
				}
				?>
				<td>
					<input type="text" <?=$nBox?>  style="width:90px;text-align:right" id="prodOptAttrQty1[]" name="prodOptAttrQty1[]" value="<?=$aryProdOpt[$i][OPT_ATTR][$j][POA_STOCK_QTY]?>" />
				</td>
			</tr>
			<?
						}
					}
				}
			?>
			<tr>
				<td colspan="2" style="text-align:right">총 재고 수량의 합 : <span id="spanTotQty"><?=NUMBER_FORMAT($intProdOptAttrQty)?></span></td>
			</tr>
			<tr>
				<td colspan="2" style="text-align:right"><a class="btn_blue_sml" href="javascript:goStockOptUdate();"><strong>옵션재고수량변경하기</strong></a></td>
			</tr>
		</table>
	</div>

</form>
</div>
</body>
</html>