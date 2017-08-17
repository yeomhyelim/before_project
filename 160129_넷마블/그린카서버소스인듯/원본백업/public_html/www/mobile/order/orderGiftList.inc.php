<?
	if ($S_GIFT_USE != "N"){
		
		/* 사은품 금액이 상품구매금액이면 상품금액/ 상품 총 주문금액 */
		$intOrderGiftTotal = ($S_GIFT_PRICE == "P") ? $intCartPriceTotal : $intCartPriceEndTotal; 
		$productMgr->setGIFT_LIMIT_PRICE($intOrderGiftTotal);
		
		/* 첫구매 사은품(회원일때) */
		if ($g_member_login && $g_member_no > 0 && ($intMemberOrderJumunCnt == 0 || $intMemberOrderDeliveryCnt == 0)){
			
			$strGiftFirstType = "";
			if ($intMemberOrderJumunCnt == 0){
				$strGiftFirstType .= "'O',";	//주문기준
			}
			if ($intMemberOrderDeliveryCnt == 0){
				$strGiftFirstType .= "'D',";	//배송기준
			}
			$strGiftFirstType = SUBSTR($strGiftFirstType,0,STRLEN($strGiftFirstType)-1);
						
			$productMgr->setGIFT_FIRST_TYPE($strGiftFirstType);
			$aryProdFirstGiftList = $productMgr->getCusGiftList($db);
			
			if (is_array($aryProdFirstGiftList)){
?>
		<div class="prodDetail mt10" >	
<?
				for($i=0;$i<sizeof($aryProdFirstGiftList);$i++){
					$aryGiftOptAttr1 = explode(";",$aryProdFirstGiftList[$i][CG_OPT_ATTR1]);
					$aryGiftOptAttr2 = explode(";",$aryProdFirstGiftList[$i][CG_OPT_ATTR2]);

						?>
			<dl>
				<dd class="detailImg">
					<input type="checkbox" name="prodFirstGiftNo[]" id="prodFirstGiftNo[]" value="<?=$aryProdFirstGiftList[$i][CG_NO]?>">
					<img src="..<?=$aryProdFirstGiftList[$i][CG_FILE]?>" style="width:100px;height:100px">
				</dd>
				<dd class="detailInfo">
					<table border="0">
						<tr>
							<th colspan="2" class="titleWrap"><?=$aryProdFirstGiftList[$i][CG_NAME]?></th>
						</tr>
						<?if ($aryProdFirstGiftList[$i][CG_OPT_NM1]){?>
						<tr>
							<th><?=$aryProdFirstGiftList[$i][CG_OPT_NM1]?></th>
							<td>
								<?=drawSelectBox("prodFirstGiftOpt1[]",$aryGiftOptAttr1,$selected ="",$design ="",$onchange="",$etc="",$LNG_TRANS_CHAR["PW00011"])?>
							</td>
						</tr>
						<?}?>
						<?if ($aryProdFirstGiftList[$i][CG_OPT_NM2]){?>
						<tr>
							<th><?=$aryProdFirstGiftList[$i][CG_OPT_NM2]?></th>
							<td>
								<?=drawSelectBox("prodFirstGiftOpt2[]",$aryGiftOptAttr2,$selected ="",$design ="",$onchange="",$etc="",$LNG_TRANS_CHAR["PW00011"])?>
							</td>
						</tr>
						<?}?>
					</table>
				</dd>
			</dl>
					<?
				}
				?>
		</div>
				<?
			}
		}

		/* 고객사은품 */
		$productMgr->setGIFT_FIRST_TYPE("'N'");
		$aryProdGiftList = $productMgr->getCusGiftList($db);
		
		if (is_array($aryProdGiftList) && (($S_GIFT_USE == "A") || ($S_GIFT_USE == "M" && $g_member_login && $g_member_no))){
?>
		<div class="prodDetail mt10" >	
<?
			for($i=0;$i<sizeof($aryProdGiftList);$i++){
				$aryGiftOptAttr1 = explode(";",$aryProdGiftList[$i][CG_OPT_ATTR1]);
				$aryGiftOptAttr2 = explode(";",$aryProdGiftList[$i][CG_OPT_ATTR2]);
?>
			<dl>
				<dd class="detailImg">
					<input type="checkbox" name="prodGiftNo[]" id="prodGiftNo[]" value="<?=$aryProdGiftList[$i][CG_NO]?>">
					<img src="..<?=$aryProdGiftList[$i][CG_FILE]?>" style="width:100px;height:100px">
				</dd>
				<dd class="detailInfo">
					<table border="0">
						<tr>
							<th colspan="2" class="titleWrap"><?=$aryProdGiftList[$i][CG_NAME]?></th>
						</tr>
						<?if ($aryProdGiftList[$i][CG_OPT_NM1]){?>
						<tr>
							<th><?=$aryProdGiftList[$i][CG_OPT_NM1]?></th>
							<td>
								<?=drawSelectBox("prodGiftOpt1[]",$aryGiftOptAttr1,$selected ="",$design ="",$onchange="",$etc="",$LNG_TRANS_CHAR["PW00011"])?>
							</td>
						</tr>
						<?}?>
						<?if ($aryProdGiftList[$i][CG_OPT_NM2]){?>
						<tr>
							<th><?=$aryProdGiftList[$i][CG_OPT_NM2]?></th>
							<td>
								<?=drawSelectBox("prodGiftOpt2[]",$aryGiftOptAttr2,$selected ="",$design ="",$onchange="",$etc="",$LNG_TRANS_CHAR["PW00011"])?>
							</td>
						</tr>
						<?}?>
					</table>
				</dd>
			</dl>
			<?}?>
		</div>
			<?
		}
	}
?>