<? include "./include/header.inc.php"?>
<?
	require_once MALL_CONF_LIB."OrderAdmMgr.php";
	
	/*상품함수관련*/
	require_once MALL_PROD_FUNC;

	$orderMgr = new OrderMgr();

	$intO_NO		= $_POST["no"]				? $_POST["no"]				: $_REQUEST["no"];
	
	if (!$intO_NO){
		$db->disConnect();
		goClose($LNG_TRANS_CHAR["OS00002"]); //"주문정보가 존재하지 않습니다."
		exit;
	}

	$orderMgr->setO_NO($intO_NO);
	$orderRow = $orderMgr->getOrderView($db);
	$aryZip = explode("-",$orderRow['O_B_ZIP']);

?>
<style type="text/css">
	#contentArea{position:relative;min-width:450px;padding:10px}
</style>
<script type="text/javascript">
<!--
	$(document).ready(function(){
		
	});


	/* 우편번호 찾기 */
	function goZip(num)
	{
		var href = "?menuType=popup&mode=address&num="+num;
		window.open(href,'new','width=520px,height=450px,top=300px,left=400px,menubar=no,location=no,scrollbars=yes,status=no,resizable=no');
	}

	function goAct()
	{
		C_getAction("deliveryAddrUpdate","<?=$PHP_SELF?>");
	}
//-->
</script>
<div class="layerPopWrap">
	<div class="popTop">
		<h2><?=$LNG_TRANS_CHAR["OW00034"] //배송지 정보?></h2>			
		<a  href="javascript:parent.goPopClose();"><img src="/shopAdmin/himg/common/btn_pop_close.png" class="closeBtn"/></a>
		<div class="clear"></div>
	</div>
</div>

<div id="contentArea">
	<!-- (2) 베송지 정보 -->
	<div class="tableForm mt10">
	<form name="form" method="post">
	<input type="hidden" name="menuType" value="<?=$strMenuType?>">
	<input type="hidden" name="mode" value="<?=$strMode?>">
	<input type="hidden" name="act" value="<?=$strMode?>">
	<input type="hidden" name="oNo" value="<?=$intO_NO?>">
		<table>
			<colgroup>
				<col style="width:80px;"/>
				<col/>
			</colgroup>
			<tr>
				<th><?=$LNG_TRANS_CHAR["OW00035"] //받으실 분?></th>
				<td><input type="text" name="bname" id="bname" value="<?=$orderRow[O_B_NAME]?>" style="width:150px;" <?=$nBox?> ></td>
			</tr>
			<tr>
				<th><?=$LNG_TRANS_CHAR["OW00031"] //전화번호?></th>
				<td>
					<input type="text" name="bphone" id="bphone" value="<?=$orderRow[O_B_PHONE]?>" style="width:150px;" maxlength="20">
				</td>
			</tr>
			<tr>
				<th><?=$LNG_TRANS_CHAR["OW00032"] //핸드폰?></th>
				<td>
					<input type="text" name="bhp" id="bhp" value="<?=$orderRow[O_B_HP]?>" style="width:150px;" maxlength="20">
				</td>
			</tr>
			<tr>
				<th><?=$LNG_TRANS_CHAR["OW00036"] //주소?> </th>
				<td>
					<?if ($orderRow['O_USE_LNG'] == "KR"){?>
					<dl>
						<dd>
							<input type="input" id="bzip1" name="bzip1" class="defInput _w30" maxlength="3" readonly value="<?=$aryZip[0]?>"/> - <input type="input" id="bzip2" name="bzip2" class="defInput _w30" maxlength="3" readonly value="<?=$aryZip[1]?>"/> <a href="javascript:goZip(6);" class="btn_sml"><strong>우편번호</strong></a>
						</dd>
						<dd>
							<input type="input" id="baddr1" name="baddr1" class="defInput _w200" readonly value="<?=$orderRow[O_B_ADDR1]?>"/>
							<input type="input" id="baddr2" name="baddr2" class="defInput _w300" maxlength="100" value="<?=$orderRow[O_B_ADDR2]?>"/>
						</dd>
					</dl>
					<?}else{?>
					<dl>
						<dd>
							국가 : <?=drawSelectBoxMore("bcountry",$aryCountryList,$strJCountry,$design ="",$onchange="",$etc="",$firstItem="= Country =",$html="N")?>	
						</dd>
						<dd>
							주소 : <input type="input" id="baddr1" name="baddr1" class="defInput _w200"  value="<?=$strJAddr1?>"/>
						</dd>
						<dd>
							상세주소 : <input type="input" id="baddr2" name="baddr2" class="defInput _w200"  value="<?=$strJAddr1?>"/>
						</dd>
						<dd>
							city : <input type="input" id="bcity" name="bcity" class="defInput _w200"  value="<?=$strJAddr1?>"/>
						</dd>
						<dd>
							State : 
							<div id="divState1" <?=($strJCountry=="US")?"style=\"display:none\"":"";?>>
							<input type="input" id="bstate_1" name="bstate_1" class="defInput _w200" maxlength="50" value="<?=($strJState)? $strJState: "N/A";?>"/>
							</div>
							<div id="divState2" <?=($strJCountry!="US")?"style=\"display:none\"":"";?>>
								<?=drawSelectBoxMore("bstate_2",$aryCountryState,$strJState,$design="",$onchange="",$etc="",$firstItem="= State =",$html="N")?>
							</div>
						</dd>
						<dd>
							우편번호 : <input type="input" id="bzip1" name="bzip1" class="defInput _w200"  value="<?=$strJAddr1?>"/>
						</dd>
					</dl>
					<?}?>
				</td>
			</tr>
		</table>
	</form>
	</div>
	<!-- tableOrderForm -->
</div>
<div class="buttonWrap">
	<a class="btn_blue_big" href="javascript:goAct();"><strong><?=$LNG_TRANS_CHAR["CW00003"] //수정?></strong></a>
	<a class="btn_big" href="javascript:parent.goPopClose();"><strong><?=$LNG_TRANS_CHAR["CW00042"] //창닫기?></strong></a>
</div>
	
	<!-- ******************** contentsArea ********************** -->

</body>
</html>