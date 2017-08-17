					<div class="popupCartWrap" style="display:none" id="prodAddCart_<?=$strP_CODE?>">
						<div class="closeWrap">
							<div class="total">TOTAL : <span class="price" id="prodAddCartTotal"><?=$S_SITE_CUR_MARK1?>0</span></div>
							<a href="javascript:goAddCartCloseEvent('<?=$strAppID?>','<?=$strP_CODE?>');" class="btnClose">CLOSE</a>
							<div class="clr"></div>
						</div>

						<div class="optionArea" id="divOptionArea">
							<div class="option1Wrap" id="optionTable">

							</div>

							<div class="option2Wrap" id="optionTable2">
								<table class="optCntTable">
									<tbody>
										<tr>
											<td class="titCnt">Qty</td>
											<td class="cnt">
												<ul>
													<li><input type="text" id="qty" name="qty" value="1"></li>
													<li class="btnCntUpDown">
														<a href="javascript:goAddCartQtyEvent('<?=$strAppID?>','<?=$strP_CODE?>','up');"><img src="../himg/product/A0001/btn_prod_cnt_up.gif"></a>
														<a href="javascript:goAddCartQtyEvent('<?=$strAppID?>','<?=$strP_CODE?>','down');"><img src="../himg/product/A0001/btn_prod_cnt_down.gif"></a>
													</li>
												</ul>
											</td>
											<td class="price"><?=$S_SITE_CUR_MARK1?>0</td>
											<!--<td class="btnCntClose"><a href="#" class="btnClose"><img src="/upload/images/btn_close_b.gif" alt="닫기" /></a></td>//-->
										</tr>
									</tbody>
								</table>
							</div>
							<div class="btnWrap">
								<a href="javascript:goAddCartOptEvent('<?=$strAppID?>','<?=$strP_CODE?>');" class="btnCart">ADD TO CART</a>
							</div>
						</div>

						<div class="option3Wrap" id="optionTable3" style="display:none">
							<div class="txtBox">
								<?=$LNG_TRANS_CHAR['OS00013']?>
							</div>
							<div class="btnWrap">
								<a href="javascript:goAddCartMoveEvent();" class="btnConfirm" id="btnAddCartMove"><?=$LNG_TRANS_CHAR['CW00001']?></a>
								<a href="javascript:goAddCartCloseEvent('<?=$strAppID?>','<?=$strP_CODE?>');" class="btnClose"><?=$LNG_TRANS_CHAR['CW00034']?></a>
							</div>
						</div>
					</div>