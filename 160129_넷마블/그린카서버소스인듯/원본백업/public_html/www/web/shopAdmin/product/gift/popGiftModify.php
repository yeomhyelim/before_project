<? include "./include/header.inc.php"?>
<?
	require_once MALL_CONF_LIB."ProductAdmMgr.php";	
	require_once MALL_CONF_LIB."SiteMgr.php";

	$productMgr = new ProductAdmMgr();		
	$siteMgr = new SiteMgr();		
	
	$intCG_NO			= $_POST["no"]		? $_POST["no"]			: $_REQUEST["no"];
	$strGiftLng			= $_POST["giftLng"]	? $_POST["giftLng"]		: $_REQUEST["giftLng"];
	
	$siteRow = $siteMgr->getSiteInfoView($db);
	$aryUseLng = explode("/",$siteRow[S_USE_LNG]);

	$productMgr->setCG_NO($intCG_NO);
	$row = $productMgr->getGiftView($db);
	
	$aryGiftLngList = $productMgr->getGiftLngList($db);

	$giftLngRow = array();
	if (is_array($aryGiftLngList)){
		for($i=0;$i<sizeof($aryGiftLngList);$i++){
			$giftLngRow[$aryGiftLngList[$i][CG_LNG]]["NAME"]		=  $aryGiftLngList[$i][CG_NAME];
			$giftLngRow[$aryGiftLngList[$i][CG_LNG]]["OPT_NM1"]		=  $aryGiftLngList[$i][CG_OPT_NM1];
			$giftLngRow[$aryGiftLngList[$i][CG_LNG]]["OPT_NM2"]		=  $aryGiftLngList[$i][CG_OPT_NM2];
			$giftLngRow[$aryGiftLngList[$i][CG_LNG]]["OPT_ATTR1"]	=  $aryGiftLngList[$i][CG_OPT_ATTR1];
			$giftLngRow[$aryGiftLngList[$i][CG_LNG]]["OPT_ATTR2"]	=  $aryGiftLngList[$i][CG_OPT_ATTR2];
		}
	}
?>
<style type="text/css">
	#contentArea{position:relative;min-width:550px;padding:10px}
</style>
<script type="text/javascript">
<!--

	$(document).ready(function(){
		C_CallMenuAuthBtn("<?=$a_admin_no?>","<?=$strTopMenuCode?>","<?=$strLeftMenuCode01?>","<?=$strLeftMenuCode02?>");
			
		$('input[name=eventStartDt]').simpleDatepicker();
		$('input[name=eventEndDt]').simpleDatepicker();
	
		$("#type").live("click",function(){
			
			$("#divDiscountPeriodN").css("display", "none");
			$("#divDiscountPeriodG").css("display", "none");
			
			$("#divDiscountPeriod"+$(this).val()).css("display", "block");			
		});		
	});
	
	function goAct(mode)
	{
		if(!C_chkInput("name",true,"<?=$LNG_TRANS_CHAR['PW00145']?>",true)) return; //사은품명

		document.form.encoding = "multipart/form-data";
		C_getAction(mode,'<?=$PHP_SELF?>');
	}

	function goClose()
	{
		parent.location.reload();
	}

	function goFileDel()
	{
		var x = confirm("파일을 삭제하시겠습니까?");
		if (x == true)
		{
			C_getAction('giftFileDel','<?=$PHP_SELF?>');
		}
	}
//-->
</script>
<div class="layerPopWrap">
	<div class="popTop">
		<h2><?=$LNG_TRANS_CHAR["PW00179"] //사은품 수정?></h2>			
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
<input type="hidden" name="no" id="no" value="<?=$intCG_NO?>">
<input type="hidden" name="giftLng" id="giftLng" value="<?=$strGiftLng?>">
<input type="hidden" name="each_use" id="each_use" value="N">
	<!-- ******** 컨텐츠 ********* -->
	<div class="tableForm">
		<table>
			<tr>
				<th><?=$LNG_TRANS_CHAR["PW00145"] //사은품명?></th>
				<td>
					<input type="text" <?=$nBox?>  style="width:300px;" id="name" name="name" value="<?=$giftLngRow[$strGiftLng]["NAME"]?>"/>
				</td>
			</tr>
			<!--
			<tr>
				<th><?=$LNG_TRANS_CHAR["PW00146"] //개별 상품기능?></th>
				<td>
					<input type="radio" name="each_use" id="each_use" value="N" <?=($row[CG_EACH_USE]=="N")?"checked":"";?>><?=$LNG_TRANS_CHAR["CW00011"] //사용안함?>
					<input type="radio" name="each_use" id="each_use" value="Y" <?=($row[CG_EACH_USE]=="Y")?"checked":"";?>><?=$LNG_TRANS_CHAR["CW00010"] //사용?>
				</td>
			</tr>//-->
			<tr>
				<th><?=$LNG_TRANS_CHAR["PW00147"] //첫구매 사은품?></th>
				<td>
					<input type="radio" name="first_gift" id="first_gift" value="N" <?=($row[CG_FIRST_GIFT]=="N")?"checked":"";?>><?=$LNG_TRANS_CHAR["CW00011"] //사용안함?>
					<input type="radio" name="first_gift" id="first_gift" value="O" <?=($row[CG_FIRST_GIFT]=="O")?"checked":"";?>><?=$LNG_TRANS_CHAR["PW00159"] //주문기준으로 사용함?>
					<input type="radio" name="first_gift" id="first_gift" value="D" <?=($row[CG_FIRST_GIFT]=="D")?"checked":"";?>><?=$LNG_TRANS_CHAR["PW00160"] //배송기준으로 사용함?>				
				</td>
			</tr>
			<!--<tr>
				<th><?=$LNG_TRANS_CHAR["PW00148"] //수량별 추가 상품기능?></th>
				<td>
					<input type="radio" name="qty_use" id="qty_use" value="N" checked><?=$LNG_TRANS_CHAR["CW00011"] //사용안함?>
					<input type="radio" name="qty_use" id="qty_use" value="Y"><?=$LNG_TRANS_CHAR["CW00010"] //사용?>
				</td>
			</tr>//-->
			<tr>
				<th><?=$LNG_TRANS_CHAR["PW00149"] //구매가격범위?></th>
				<td>
					<input type="text" <?=$nBox?>  style="width:100px;" id="startPrice" name="startPrice" value="<?=$row[CG_ST_PRICE]?>"/>
					<select name="price_type" id="price_type">
						<option value="1" <?=($row[CG_PRICE_TYPE]=="1")?"selected":"";?>><?=$LNG_TRANS_CHAR["PW00157"] //부터(이상)?></option>
						<option value="2" <?=($row[CG_PRICE_TYPE]=="2")?"selected":"";?>><?=$LNG_TRANS_CHAR["PW00158"] //이상 모든가격?></option>
					</select>
					~
					<input type="text" <?=$nBox?>  style="width:100px;" id="endPrice" name="endPrice" value="<?=$row[CG_END_PRICE]?>"/>
				</td>
			</tr>
			
			<tr>
				<th><?=$LNG_TRANS_CHAR["PW00150"] //재고수량?></th>
				<td>
					<input type="radio" name="stock_use" id="stock_use" value="N" <?=($row[CG_STOCK]=="N")?"checked":"";?>><?=$LNG_TRANS_CHAR["CW00011"] //사용안함?>
					<input type="radio" name="stock_use" id="stock_use" value="Y" <?=($row[CG_STOCK]=="Y")?"checked":"";?>><?=$LNG_TRANS_CHAR["PW00161"] //갯수?>
					<input type="text" <?=$nBox?>  style="width:100px;" id="qty" name="qty" value="<?=$row[CG_QTY]?>"/>
				</td>
			</tr>
			
			<tr>
				<th><?=$LNG_TRANS_CHAR["PW00151"] //선택제한?></th>
				<td>
					<input type="radio" name="limit_use" id="limit_use" value="N" <?=($row[CG_LIMIT]=="N")?"checked":"";?>><?=$LNG_TRANS_CHAR["CW00011"] //사용안함?>
					<input type="radio" name="limit_use" id="limit_use" value="Y" <?=($row[CG_LIMIT]=="Y")?"checked":"";?>><?=$LNG_TRANS_CHAR["PW00161"] //갯수?>
					<input type="text" <?=$nBox?>  style="width:100px;" id="limit_qty" name="limit_qty" value="<?=$row[CG_LIMIT_QTY]?>"/>
				</td>
			</tr>
			
			<tr>
				<th><?=$LNG_TRANS_CHAR["PW00152"] //옵션1?></th>
				<td>
					<table>
						<tr>
							<th><?=$LNG_TRANS_CHAR["PW00153"] //옵션명?></th>
							<td><input type="text" <?=$nBox?>  style="width:100px;" id="opt_nm1" name="opt_nm1" value="<?=$giftLngRow[$strGiftLng]["OPT_NM1"]?>"/></td>
						</tr>
						<tr>
							<th><?=$LNG_TRANS_CHAR["PW00154"] //속성?></th>
							<td><input type="text" <?=$nBox?>  style="width:300px;" id="opt_attr1" name="opt_attr1" value="<?=$giftLngRow[$strGiftLng]["OPT_ATTR1"]?>"/></td>
						</tr>	
					</table>
				</td>
			</tr>
			
			<tr>
				<th><?=$LNG_TRANS_CHAR["PW00155"] //옵션2?></th>
				<td>
					<table>
						<tr>
							<th><?=$LNG_TRANS_CHAR["PW00153"] //옵션명?></th>
							<td><input type="text" <?=$nBox?>  style="width:100px;" id="opt_nm2" name="opt_nm2" value="<?=$giftLngRow[$strGiftLng]["OPT_NM2"]?>"/></td>
						</tr>
						<tr>
							<th><?=$LNG_TRANS_CHAR["PW00154"] //속성?></th>
							<td><input type="text" <?=$nBox?>  style="width:300px;" id="opt_attr2" name="opt_attr2" value="<?=$giftLngRow[$strGiftLng]["OPT_ATTR2"]?>"/></td>
						</tr>
					</table>
				</td>
			</tr>
			<tr>
				<th><?=$LNG_TRANS_CHAR["PW00156"] //사은품이미지?></th>
				<td>
					<input type="file" <?=$nBox?>  id="gift_file" name="gift_file" value=""/>
					<?if ($row[CG_FILE]){?><a href="javascript:goFileDel();">[X]</a><?}?>
				</td>
			</tr>
			<tr>
				<th><?=$LNG_TRANS_CHAR["OW00162"] //사은품 보임?></th>
				<td>
					<input type="radio" name="view" id="view" value="Y" <?=($row[CG_VIEW]=="Y")?"checked":"";?>><?=$LNG_TRANS_CHAR["OW00163"] //화면 표시함?>
					<input type="radio" name="view" id="view" value="N" <?=($row[CG_VIEW]=="N")?"checked":"";?>><?=$LNG_TRANS_CHAR["OW00164"] //화면 표시 안함?>
				</td>
			</tr>
		</table>
	</div>
	<div class="buttonWrap">
		<a class="btn_blue_big" href="javascript:goAct('giftModify');" id="menu_auth_m"><strong><?=$LNG_TRANS_CHAR["CW00003"] //수정?></strong></a>
		<a class="btn_big" href="javascript:goClose();"><strong><?=$LNG_TRANS_CHAR["CW00042"] //닫기?></strong></a>
	</div>
</form>
</div>
</body>
</html>