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
		
		<div class="prodGiftWrap" >	
			<h4 class="orderTit_gift"><span><?=$LNG_TRANS_CHAR["OW00102"] //첫구매 고객용 사은품?></h4>
			<span class="giftTxtInfo">
				<?=$LNG_TRANS_CHAR["OS00073"] //첫 상품 구매 고객님께 제공되는 사은품 리스트 입니다.<br/>원하시는 상품을 선택하신 후 주문 신청해 주세요.?>
			</span>
			<table>
		<?
				for($i=0;$i<sizeof($aryProdFirstGiftList);$i++){
					$aryGiftOptAttr1 = explode(";",$aryProdFirstGiftList[$i][CG_OPT_ATTR1]);
					$aryGiftOptAttr2 = explode(";",$aryProdFirstGiftList[$i][CG_OPT_ATTR2]);
					
					if ($i%5==0) echo "<tr>";
			?>
					<td>
						<div class="giftProdList">
							<img src="..<?=$aryProdFirstGiftList[$i][CG_FILE]?>" class="listImg"/>
							<ul>
								<li class="giftTitle"><input type="checkbox" name="prodFirstGiftNo[]" id="prodFirstGiftNo[]" value="<?=$aryProdFirstGiftList[$i][CG_NO]?>"> <?=$aryProdFirstGiftList[$i][CG_NAME]?></li>
								<?if ($aryProdFirstGiftList[$i][CG_OPT_NM1]){?>
								<li>
									<?=$aryProdFirstGiftList[$i][CG_OPT_NM1]?>
									<?=drawSelectBox("prodFirstGiftOpt1[]",$aryGiftOptAttr1,$selected ="",$design ="",$onchange="",$etc="",$LNG_TRANS_CHAR["PW00011"])?>
								</li>
								<?}?>
								<?if ($aryProdFirstGiftList[$i][CG_OPT_NM2]){?>
								<li>
									<?=$aryProdFirstGiftList[$i][CG_OPT_NM2]?></th>
									<?=drawSelectBox("prodFirstGiftOpt2[]",$aryGiftOptAttr2,$selected ="",$design ="",$onchange="",$etc="",$LNG_TRANS_CHAR["PW00011"])?>
								</li>
								<?}?>
							</ul>
						</div>
					</td>
				<?
					if ($i%5==4) echo "</tr>";
				}
			
			?>
				</table>
		</div>
				<?
			}
		}

		/* 고객사은품 */
		$productMgr->setGIFT_FIRST_TYPE("'N'");
		$aryProdGiftList = $productMgr->getCusGiftList($db);
		
		if (is_array($aryProdGiftList) && (($S_GIFT_USE == "A") || ($S_GIFT_USE == "M" && $g_member_login && $g_member_no))){
?>
		<div class="prodGiftWrap mt10" >	
			<h4 class="orderTit_gift"><span><?=$LNG_TRANS_CHAR["OW00103"] //고객 사은품?></h4>
			<span class="giftTxtInfo">
				<?=$LNG_TRANS_CHAR["OS00074"] //상품 구매 고객님께 제공되는 사은품 리스트 입니다.<br/>원하시는 상품을 선택하신 후 주문 신청해 주세요.?>
			</span>
			<table>
<?
			for($i=0;$i<sizeof($aryProdGiftList);$i++){
				$aryGiftOptAttr1 = explode(";",$aryProdGiftList[$i][CG_OPT_ATTR1]);
				$aryGiftOptAttr2 = explode(";",$aryProdGiftList[$i][CG_OPT_ATTR2]);
?>
				<tr>
					<td>
						<div class="giftProdList">
							<img src="..<?=$aryProdGiftList[$i][CG_FILE]?>" style="width:100px;height:100px">
							<ul>
								<li class="giftTitle"><input type="checkbox" name="prodGiftNo[]" id="prodGiftNo[]" value="<?=$aryProdGiftList[$i][CG_NO]?>"> <?=$aryProdGiftList[$i][CG_NAME]?></li>
								<?if ($aryProdGiftList[$i][CG_OPT_NM1]){?>
								<li>	
									<?=$aryProdGiftList[$i][CG_OPT_NM1]?>
									<?=drawSelectBox("prodGiftOpt1[]",$aryGiftOptAttr1,$selected ="",$design ="",$onchange="",$etc="",$LNG_TRANS_CHAR["PW00011"])?>
								</li>
								<?}?>
								<?if ($aryProdGiftList[$i][CG_OPT_NM2]){?>
								<li>
									<?=$aryProdGiftList[$i][CG_OPT_NM2]?></th>
									<?=drawSelectBox("prodGiftOpt2[]",$aryGiftOptAttr2,$selected ="",$design ="",$onchange="",$etc="",$LNG_TRANS_CHAR["PW00011"])?>
								</li>
								<?}?>
							</ul>
						</div>
					</td>
				</tr>
			<?}?>
			</table>
		</div>
			<?
		}
	}
?>