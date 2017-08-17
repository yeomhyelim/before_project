		<?//if ($g_member_no){?>
		<?//주석요청.
		if (false){?>
		<div class="wishList_Area">
			<div class="cartListWrapBig mt40">
				<div class="cartTabWrap">
					<span class="tabBtn1"><?=$LNG_TRANS_CHAR["CW00005"] //담아둔 상품?>(<?=NUMBER_FORMAT($intWishTotal)?>)</span>
					<span class="txtInfo">ㆍ<?=$LNG_TRANS_CHAR["OS00003"] //지금바로 주문하지 않을 상품을 옮겨놓거나 담아두실 수 있습니다.?></span>
				</div>
				<div class="tableProdList mt10">
					<table>
						<colgroup>
							<col style="50px;"/>
							<col/>
							<col/>
							<col/>
							<col/>
							<col/>
						</colgroup>
						<tr>
							<th class="chkDiv"><input type="checkbox" id="chkAll" data_target="wishNo"/></th>
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
							<td colspan="6"><?=$LNG_TRANS_CHAR["OS00004"] //WISH 리스트에 담긴 상품이 없습니다.?></td>
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

								$aryProdWishItemList = "";
								if ($S_SHOP_PROD_ADD_ITEM_VERSION == "V2.O"){
									$aryProdWishItemList = $productMgr->getProdWishItemList($db);
								}

								$strProdEventText = "";
								if ($wishRow[P_EVENT_UNIT] && $wishRow[P_EVENT]){
									if ($wishRow[P_EVENT_UNIT] == "%") $strProdEventText = "(".callLangTrans($LNG_TRANS_CHAR["OS00002"],array($wishRow[P_EVENT],"%")).")";
									else $strProdEventText = "(".$S_SITE_CUR." ".callLangTrans($LNG_TRANS_CHAR["OS00002"],array($wishRow[P_EVENT],"")).")";
								}

								/* 상품에 착불가격이 있는 경우 */
								## P_BAESONG_TYPE = 1 : 기본 배송
								## P_BAESONG_TYPE = 2 : 무료 배송
								## P_BAESONG_TYPE = 3 : 고정 배송		배송비 보임
								## P_BAESONG_TYPE = 4 : 수량별 배송		배송비 보임
								## P_BAESONG_TYPE = 5 : 착불 배송		배송비 보임
								if($S_SITE_LNG == "KR"):
									$strBaesongPrice			= "";
										if($wishRow['P_BAESONG_TYPE'] == 1):
									elseif($wishRow['P_BAESONG_TYPE'] == 2):
									elseif($wishRow['P_BAESONG_TYPE'] == 3):
										$strBaesongPrice		= $wishRow['P_BAESONG_PRICE'];
										$strBaesongPrice		= "(고정배송비:" . getCurMark() . getCurToPrice($strBaesongPrice) . getCurMark2() . ")";
									elseif($cartRow['P_BAESONG_TYPE'] == 4):
										$strBaesongPrice		= $wishRow['P_BAESONG_PRICE'];
										$strBaesongPrice		= "(수량별배송비:" . getCurMark() . getCurToPrice($strBaesongPrice) . getCurMark2() . ")";
									elseif($cartRow['P_BAESONG_TYPE'] == 5):
										$strBaesongPrice		= $wishRow['P_BAESONG_PRICE'];
										$strBaesongPrice		= "(착불:" . getCurMark() . getCurToPrice($strBaesongPrice) . getCurMark2() . ")";
									endif;
								endif;

								?>
						<tr>
							<td><input type="checkbox" id="wishNo[]" name="wishNo[]" value="<?=$wishRow[PW_NO]?>"/></td>
							<td class="prodInfo">
								<a href="./?menuType=product&mode=view&prodCode=<?=$wishRow[P_CODE]?>"><img src="..<?=$wishRow[PM_REAL_NAME]?>" style="width:50px;"/></a>
								<ul>
									<li>
										<a href="./?menuType=product&mode=view&prodCode=<?=$wishRow[P_CODE]?>"><?=$wishRow[P_NAME]?><?=$strProdEventText?></a>
									</li>
									<li><?=$strWishOptAttrVal?></li>

									<?if (is_array($aryProdWishAddOptList)){
										for($k=0;$k<sizeof($aryProdWishAddOptList);$k++){

										?>
										<li><?=$LNG_TRANS_CHAR["OW00006"] //추가선택?> : <?=$aryProdWishAddOptList[$k][PWA_OPT_NM]?></li>
									<?}}?>
									<?
									if ($S_SHOP_PROD_ADD_ITEM_VERSION == "V2.O"){
										if (is_array($aryProdWishItemList)){
											for($k=0;$k<sizeof($aryProdWishItemList);$k++){
												?>
												<li><?=$aryProdWishItemList[$k]['PWI_ITEM_NM']?>:<?=$aryProdWishItemList[$k]['PWI_ITEM_VAL']?></li>
												<?
											}
										}
									}
									?>
									<?=$strBaesongPrice?>
								</ul>
								<div class="clear"></div>
							</td>
							<td>
								<?if ($S_ARY_CUR[$S_SITE_LNG]["USD"][2] == "Y"){?>
								<strong class="priceBoldGray"><?=getCurMark("USD")?> <?=getCurToPrice($wishRow[PW_PRICE],"US")?></strong>
								(<?=$S_SITE_CUR_MARK1?><?=getCurToPrice($wishRow[PW_PRICE])?>)
								<?if ($wishRow[PW_ADD_OPT_PRICE] > 0){?>
									<br><?=$LNG_TRANS_CHAR["OW00007"] //추가금액?>:<?=getCurMark("USD")?> <?=getCurToPrice($wishRow[PW_ADD_OPT_PRICE],"US")?>
									(<?=$S_SITE_CUR_MARK1?><?=getCurToPrice($wishRow[PW_ADD_OPT_PRICE])?>)
								<?}?>
								<?}else{?>
								<strong class="priceBoldGray"><?=getCurMark()?> <?=getCurToPrice($wishRow[PW_PRICE])?><?=getCurMark2()?></strong>
								<?if ($wishRow[PW_ADD_OPT_PRICE] > 0){?><br><?=$LNG_TRANS_CHAR["OW00007"] //추가금액?><?=getCurToPrice($wishRow[PW_ADD_OPT_PRICE])?><?=getCurMark2()?><?}?>
								<?}?>
							</td>
							<td>
								<dl>
									<dd><input type="input" id="wishQty<?=$wishRow[PW_NO]?>" name="wishQty<?=$wishRow[PW_NO]?>" value="<?=$wishRow[PW_QTY]?>" class="defInput _w30" style="text-align:center;"/></dd>
									<dd>
										<a href="javascript:goQtyUpMinus('wish',1,<?=$wishRow[PW_NO]?>);"><img src="/himg/product/A0001/btn_prod_cnt_up.gif"/></a>
										<a href="javascript:goQtyUpMinus('wish',-1,<?=$wishRow[PW_NO]?>);"><img src="/himg/product/A0001/btn_prod_cnt_down.gif"/></a>
									</dd>
									<a href="javascript:goQtyUpdate('wish',<?=$wishRow[PW_NO]?>);" class="cartCntModify"><span><?=$LNG_TRANS_CHAR["OW00072"] //수정?></span></a>
								</dl>

							</td>
							<td>
								<?if ($S_ARY_CUR[$S_SITE_LNG]["USD"][2] == "Y"){?>
								<strong class="priceOrange"><?=getCurMark("USD")?> <?=getCurToPrice($intWishPrice,"US")?></strong>
								(<?=$S_SITE_CUR_MARK1?><?=getCurToPrice($intWishPrice)?>)
								<?}else{?>
								<strong class="priceOrange"><?=getCurMark()?> <?=getCurToPrice($intWishPrice)?><?=getCurMark2()?></strong>
								<?}?>
							</td>
							<td>
								<a href="javascript:goBasket(<?=$wishRow[PW_NO]?>);" class="cartMovCartBtn"><span><?=$LNG_TRANS_CHAR["OW00090"] //장바구니로?></span></a>
								<a href="javascript:goWishDel(<?=$wishRow[PW_NO]?>);" class="cartListDelBtn"><span><?=$LNG_TRANS_CHAR["CW00036"] //삭제?></span></a>
							</td>
						</tr>
								<?
							}
						}
						?>
					</table>
					<div id="pagenate">
						<?=drawUserPaging($intWishPage,$intPageLine,$intPageBlock,$intWishTotal,$intWishTotPage,$linkWishPage,"","","",""," | ")?>
					</div>
				</div>
				<!-- tableProdList -->
			</div>
		<!-- cartListWrapBig -->
		</div>
		<?}?>