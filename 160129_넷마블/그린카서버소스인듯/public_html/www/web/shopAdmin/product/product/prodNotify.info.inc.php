<?
	## 고시정보를 사용 유무 설정
	if(!$S_PRODUCT_NOTIFY_USE) { return; }

	## 상품고시정보
	include MALL_ADMIN."/product/product.notify.info.inc.php";

	if (!$strP_CODE) $strP_CODE = "";

	## 언어설정
	$strLang = $_GET['lang'];
	if(!$strLang) { $strLang = $S_ST_LNG; }

	## 한국어 체크
	## 한국어에서만 지원합니다.
	if($strLang != "KR") { return; }

	## 상품고시 카테고리 부분
	$strPN_CODE = '';
	if($arrProdNotifySaveData && $arrProdNotifySaveData[0] && $arrProdNotifySaveData[0]['PN_CODE']):
		$strPN_CODE = $arrProdNotifySaveData[0]['PN_CODE'];
	endif;
?>
	<div class="tableFormWrap">
		<h3>상품고시정보</h3>
		<table class="tableForm">
			<colgroup>
				<col width="200"/>
				<col/>
			</colgroup>
			<tr>
				<th>상품고시 카테고리</th>
				<td>
					<select name="pnCode" id="notifyComm" onchange="javascript:goProductNotifyCommLoad('<?=$strP_CODE?>');">
						<option value="">=== 상품고시 ===</option>
						<?foreach($arrProdNotiCate as $key => $strProdNotifyCateName):?>
						<option value="<?=$key?>"<?php if($strPN_CODE==$key){echo " selected";}?>><?=$strProdNotifyCateName?></option>
						<?endforeach;?>
					</select>
				</td>
			</tr>
		</table>
		<table class="tableForm" id="tableProdNotifyCateItem" <?=($intProdNoticySaveDataCnt > 0)?"":"style=\"display:none\"";?>>
			<colgroup>
				<col width="200"/>
				<col/>
			</colgroup>
			<?if (is_array($arrProdNotifySaveData)){
				foreach($arrProdNotifySaveData as $key => $prodNotifyData){
					$intProdNotifyItemNo	= $prodNotifyData['PN_NO'];
					$strProdNotifyItemName	= $prodNotifyData['PN_NAME'];
					$strProdNotifyItemText	= $prodNotifyData['PN_TEXT'];
				?>
			<tr>
				<th><?=$strProdNotifyItemName?></th>
				<td>
					<input type="hidden" name="prodNotifyItemNo[]" id="prodNotifyItemNo[]" value="<?=$intProdNotifyItemNo?>">
					<input type="hidden" name="prodNotifyItemName[]" id="prodNotifyItemName[]" value="<?=$strProdNotifyItemName?>">
					<input type="text" class="nbox"  style="width:98%;" id="prodNotifyItemText[]" name="prodNotifyItemText[]" value="<?=$strProdNotifyItemText?>"/>
				</td>
			</tr>
			<?}}?>
		</table>
	</div>
