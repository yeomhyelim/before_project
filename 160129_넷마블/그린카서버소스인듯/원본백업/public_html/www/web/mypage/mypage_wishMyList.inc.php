<?if ($g_member_no){?>
	<div class="titWishBox">
		<h4 class="titWish"><span><?=$LNG_TRANS_CHAR["CW00005"] //담아둔 상품?></span><strong>(<?=NUMBER_FORMAT($intWishTotal)?>)</strong></h4>
		<span class="txtInfo">ㆍ<?=$LNG_TRANS_CHAR["OS00003"] //지금바로 주문하지 않을 상품을 옮겨놓거나 담아두실 수 있습니다.?></span>
	</div>

	<div class="myOrderListWrap mt10">
		<table>
					<colgroup>
						<col width="25px;"/>
						<col/>
						<col/>
						<col/>
						<col/>
						<col width="112px" />
					</colgroup>
					<tr>
						<th class="chkDiv"><input type="checkbox" id="chkAll" data_target="cartNo"/></th>
						<th><?=$LNG_TRANS_CHAR["OW00001"] //상품정보?></th>
						<th><?=$LNG_TRANS_CHAR["OW00002"] //상품금액?></th>
						<th class="amountDiv"><?=$LNG_TRANS_CHAR["OW00003"] //수량?></th>
						<th><?=$LNG_TRANS_CHAR["OW00004"] //합계?></th>
						<th class="mngDiv"></th>
					</tr>
					<?
					if ($intWishTotal == 0){
					?>
					<tr>
						<td colspan="6" class="dataNoList"><?=$LNG_TRANS_CHAR["OS00004"] //WISH 리스트에 담긴 상품이 없습니다.?></td>
					</tr>
					<?
					} else {
						$intWishPrice = $intWishPriceTotal = 0;
						while ($wishRow = mysql_fetch_array($wishResult)){

							$intWishPrice = ($wishRow[PW_PRICE] * $wishRow[PW_QTY]) + $wishRow[PW_ADD_OPT_PRICE];
							$intWishPriceTotal += $intWishPrice;

							$productMgr->setPW_NO($wishRow[PW_NO]);
							$aryProdWishAddOptList = $productMgr->getProdWishAddList($db);

							$strWishOptAttrVal = "";
							for($kk=1;$kk<=10;$kk++){
								if ($wishRow["PW_OPT_ATTR".$kk]){
									$strWishOptAttrVal .= "/".$wishRow["PW_OPT_ATTR".$kk];
								}
							}
							$strWishOptAttrVal = SUBSTR($strWishOptAttrVal,1);

							$strProdEventText = "";
							if ($wishRow[P_EVENT_UNIT] && $wishRow[P_EVENT]){
								if ($wishRow[P_EVENT_UNIT] == "%") $strProdEventText = "(".callLangTrans($LNG_TRANS_CHAR["OS00002"],array($wishRow[P_EVENT],"%")).")";
								else $strProdEventText = "(".$S_SITE_CUR." ".callLangTrans($LNG_TRANS_CHAR["OS00002"],array($wishRow[P_EVENT],"")).")";
							}

							?>
					<tr>
						<td><input type="checkbox" id="cartNo[]" name="cartNo[]" value="<?=$wishRow[PW_NO]?>"/></td><?//wishNo[]?>
						<td class="prodInfo">
							<a href="./?menuType=product&mode=view&prodCode=<?=$wishRow[P_CODE]?>"><img src="<?=$wishRow[PM_REAL_NAME]?>" style="width:50px;"/></a>
							<ul>
								<li><a href="./?menuType=product&mode=view&prodCode=<?=$wishRow[P_CODE]?>"><?=$wishRow[P_NAME]?><?=$strProdEventText?></a></li>
								<li><?=$strWishOptAttrVal?></li>

								<?if (is_array($aryProdWishAddOptList)){
									for($k=0;$k<sizeof($aryProdWishAddOptList);$k++){

									?>
									<li><?=$LNG_TRANS_CHAR["OW00006"] //추가선택?> : <?=$aryProdWishAddOptList[$k][PWA_OPT_NM]?></li>
								<?}}?>
							</ul>
							<div class="clear"></div>
						</td>
						<td>
							<strong class="priceBoldGray"><?=getCurMark()?> <?=getCurToPrice($wishRow[PW_PRICE])?></strong>
							<?if ($wishRow[PW_ADD_OPT_PRICE] > 0){?><br><?=$LNG_TRANS_CHAR["OW00007"] //추가금액?>:<?=getCurMark()?> <?=getCurToPrice($wishRow[PW_ADD_OPT_PRICE])?><?}?>
						</td>
						<td class="wishQtyWrap">
							<dl>
								<dd><input type="input" id="wishQty<?=$wishRow[PW_NO]?>" name="wishQty<?=$wishRow[PW_NO]?>" value="<?=$wishRow[PW_QTY]?>" class="defInput _w30" style="text-addgn:right;"/></dd>
								<dd>
									<a href="javascript:goQtyUpMinus('wish',1,<?=$wishRow[PW_NO]?>);"><img src="/himg/product/A0001/btn_prod_cnt_up.gif"/></a>
									<a href="javascript:goQtyUpMinus('wish',-1,<?=$wishRow[PW_NO]?>);"><img src="/himg/product/A0001/btn_prod_cnt_down.gif"/></a>
								</dd>
								<dd class="cartCntModifyBox"><a href="javascript:goQtyUpdate('wish',<?=$wishRow[PW_NO]?>);" class="cartCntModify"><span><?=$LNG_TRANS_CHAR["OW00072"] //수정?></span></a></dd>
							</dl>
							<div class="clr"></div>
						</td>
						<td><strong class="priceOrange"><?=getCurMark()?> <?=getCurToPrice($intWishPrice)?></strong></td>
						<td class="checkBtn">
							<a href="javascript:goBasket(<?=$wishRow[PW_NO]?>);" class="cartMovCartBtn"><span><?=$LNG_TRANS_CHAR["OW00090"] //장바구니?></span></a>
							<a href="javascript:goWishDel(<?=$wishRow[PW_NO]?>);" class="cartListDelBtn"><span><?=$LNG_TRANS_CHAR["CW00036"] //삭제?></span></a>
						</td>
					</tr>
							<?
						}
					}
					?>
				</table>
				<div align="right" style="padding-top:10px;">
					<a href="javascript:goBasketAll();" class="cartMovCartBtn"><span><?=$LNG_TRANS_CHAR["OW00090"] //장바구니?></span></a>
					<a href="javascript:goWishDelAll();" class="cartListDelBtn"><span><?=$LNG_TRANS_CHAR["CW00036"] //장바구니?></span></a>
				</div>
				<div id="pagenate">
					<?=drawUserPaging($intWishPage,$intPageLine,$intPageBlock,$intWishTotal,$intWishTotPage,$linkWishPage,"","","",""," | ")?>
				</div>
			</div>
			<!-- tableProdList -->
		<?}?>
