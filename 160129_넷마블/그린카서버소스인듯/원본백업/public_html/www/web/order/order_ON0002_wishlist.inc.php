		<?if ($g_member_no){?>
		<div class="cartListWrapBig mt40">
			<div class="cartTabWrap">
				<span class="tabBtn1">담아둔 상품(<?=NUMBER_FORMAT($intWishTotal)?>)</span>
				<span class="txtInfo">ㆍ지금바로 주문하지 않을 상품을 옮겨놓거나 담아두실 수 있습니다.</span>
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
						<th><input type="checkbox" name=""/></th>
						<th>상품정보</th>
						<th>상품금액</th>
						<th>수량</th>
						<th>합계</th>
						<th>비고</th>
					</tr>
					<?
					if ($intWishTotal == 0){
					?>
					<tr>
						<td colspan="6">WISH 리스트에 담긴 상품이 없습니다.</td>
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
								if ($wishRow[P_EVENT_UNIT] == "%") $strProdEventText = "(".$wishRow[P_EVENT]."% 할인가 적용)";
								else $strProdEventText = "(".$wishRow[P_EVENT]."원 할인가 적용)";
							}	
														
							?>
					<tr>
						<td><input type="checkbox" id="wishNo[]" name="wishNo[]" value="<?=$wishRow[PW_NO]?>"/></td>
						<td class="prodInfo">
							<img src=".<?=$wishRow[PM_REAL_NAME]?>" style="width:50px;"/>
							<ul>
								<li><?=$wishRow[P_NAME]?><?=$strProdEventText?></li>
								<li><?=$strWishOptAttrVal?></li>

								<?if (is_array($aryProdWishAddOptList)){
									for($k=0;$k<sizeof($aryProdWishAddOptList);$k++){
									
									?>
									<li>추가선택 : <?=$aryProdWishAddOptList[$k][PWA_OPT_NM]?></li>
								<?}}?>
							</ul>
							<div class="clear"></div>
						</td>
						<td>
							<strong class="priceBoldGray"><?=NUMBER_FORMAT($wishRow[PW_PRICE])?>원</strong>
							<?if ($wishRow[PW_ADD_OPT_PRICE] > 0){?><br>추가금액:<?=NUMBER_FORMAT($wishRow[PW_ADD_OPT_PRICE])?><?}?>
						</td>
						<td>
							<dl>
								<dd><input type="input" id="wishQty<?=$wishRow[PW_NO]?>" name="wishQty<?=$wishRow[PW_NO]?>" value="<?=$wishRow[PW_QTY]?>" class="defInput _w30" style="text-addgn:right;"/></dd>
								<dd>
									<a href="javascript:goQtyUpMinus('wish',1,<?=$wishRow[PW_NO]?>);"><img src="/himg/product/A0001/btn_cart_cnt_up.gif"/></a>
									<a href="javascript:goQtyUpMinus('wish',-1,<?=$wishRow[PW_NO]?>);"><img src="/himg/product/A0001/btn_cart_cnt_down.gif"/></a>
								</dd>
								<dd><a href="javascript:goQtyUpdate('wish',<?=$wishRow[PW_NO]?>);"><img src="/himg/product/A0001/btn_cart_cnt_modify.gif"/></a></dd> 
							</dl>
							
						</td>
						<td><strong class="priceOrange"><?=NUMBER_FORMAT($intWishPrice)?>원</strong></td>
						<td class="checkBtn">
							<a href="javascript:goBasket(<?=$wishRow[PW_NO]?>);"><img src="/himg/product/A0001/btn_cart_list_baguni.gif"/></a>
							<a href="javascript:goWishDel(<?=$wishRow[PW_NO]?>);"><img src="/himg/product/A0001/btn_cart_list_del.gif"/></a>
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
		<?}?>