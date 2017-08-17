
<script language="javascript" src="../common/js/jquery.plugin.min.js"></script>
<script language="javascript" src="../common/js/jquery.countdown.min.js"></script>
<?include WEB_FRWORK_JS."product.auction.js.php";?>
<div class="prodDetailWrap">
	<!-- 상품 탑 상세정보 -->
	<div class="prodDetail2 mt10" >
		<dl>
			<dd class="detailImg">
				<? include sprintf ( "%swww/web/product/include/prodView.MultyImage.index.inc.php", $S_DOCUMENT_ROOT  ); ?>
			</dd>
			<!-- dd class="multyImg" ></dd -->
			<dd class="detailInfo">
				<div class="infoTableWrap">
				<table class="infoTable">
					<tr class="titleInfoRow">
						<th colspan="2" class="titleWrap">
							<?=$prodRow[P_NAME]?>
							<? $icon = explode("/", $prodRow['P_LIST_ICON']);
							   for($x=0;$x<sizeof($icon);$x++):
								//if(in_array($x, $icon)) { $iconTag .= $S_ARY_PRODUCT_LIST_ICON[$x]; };
								$iconTag .= $S_ARY_PRODUCT_LIST_ICON[$icon[$x]];
							   endfor;
							   if($iconTag) { echo "<span class=\"prodIcon\">{$iconTag}</span"; }
							?>
						</th>
					</tr>
					<?if($strShow2=="Y" && $prodRow[P_ETC]):?>
					<tr>
						<th colspan="2"><span  class="viewComment"><?=$prodRow[P_ETC]?></span></th>
					</tr>
					<?endif;?>
					<tr>
						<th><?=$LNG_TRANS_CHAR["PW00054"] //시작가?></th>
						<td>
							<?=$strMoneyIconL?><?=getCurToPrice($prodAucRow[P_AUC_ST_PRICE])?><?=$strMoneyIconR?>
						</td>
					</tr>
					<tr>
						<th><?=$LNG_TRANS_CHAR["PW00055"] //현재가?></th>
						<td>
							<?=$strMoneyIconL?><?=getCurToPrice($prodAucRow[P_AUC_BEST_PRICE])?><?=$strMoneyIconR?>
						</td>
					</tr>
					<tr>
						<th><?=$LNG_TRANS_CHAR["PW00056"] //즉시구매가?></th>
						<td>
							<?=$strMoneyIconL?><?=getCurToPrice($prodAucRow[P_AUC_RIGHT_PRICE])?><?=$strMoneyIconR?>
						</td>
					</tr>
					<tr>
						<th><?=$LNG_TRANS_CHAR["PW00057"] //입찰수?></th>
						<td>
							<?=number_format($intProdAucApplyCnt)?>회
							<a href="javascript:goProdAuctionApplyList('<?=$strP_CODE?>');">[<?=$LNG_TRANS_CHAR["PW00067"]//경매기록보기?>]</a>
						</td>
					</tr>
					<?if((!in_array($prodAucRow['P_AUC_STATUS'],array("4","5")))){?>
					<tr>
						<th><?=$LNG_TRANS_CHAR["PW00059"] //남은시간?></th>
						<td>

							<div id="auctionCountdown" class="count" style="background:none;"></div>
							<script type="text/javascript">
							$(document).ready(function() {
								var d = <?=$intProdAucRemainTime?>;
								var layout  ='<span class="remainDate"><span>{dn}</span><span class="remainHide">일</span></span>';
									layout +='<div>';
									layout +='	<span>{hnn}</span>';
									layout +='	<span class="remainHide">시간</span>';
									layout +='</div>';
									layout +='<div>';
									layout +='	<span>{mnn}</span>';
									layout +='	<span class="remainHide">분</span>';
									layout +='</div>';
									layout +='<div>';
									layout +='	<span>{snn}</span>';
									layout +='	<span class="remainHide">초</span>';
									layout +='</div>';
								$('#auctionCountdown').countdown({until: d, format: 'dHMS', labels:['','','','','','',''],layout:layout});
							});
							</script>
						</td>
					</tr>
					<?}?>
					<?
					if (($S_SITE_LNG == "KR" && ($S_DELIVERY_MTH == "N" || !$S_DELIVERY_MTH)) || ($S_SITE_LNG != "KR" && $S_DELIVERY_FOR_MTH != "W")){
						if ($prodRow[P_BAESONG_TYPE] == "1"){
							$intShopDeliveryStPrice = $SHOP_ARY_DELIVERY["SHOP_DELIVERY_ST_PRICE"];
							if ($prodRow['P_SHOP_NO'] > 0 && $prodShopInfo['SH_COM_DELIVERY'] == 'S'){
								$intShopDeliveryStPrice = $prodShopInfo['SH_COM_DELIVERY_ST_PRICE'];
							}

							if ($intShopDeliveryStPrice > 0){
								if (($prodRow[P_SALE_PRICE] > $intShopDeliveryStPrice)){
					?>
					<tr class="deliveryFreeInfoRow">
						<th><?=$LNG_TRANS_CHAR["PW00012"] //배송비?></th>
						<td><?=$LNG_TRANS_CHAR["PW00013"] //무료?></td>
					</tr>
					<?
								} else {

					?>
					<tr class="deliveryPriceInfoRow">
						<th><?=$LNG_TRANS_CHAR["PW00012"] //배송비?></th>
						<td><?=($prodRow['P_SHOP_NO'] > 0 && $prodShopInfo['SH_COM_DELIVERY'] == 'S' ) ? getCurToPrice($prodShopInfo['SH_COM_DELIVERY_PRICE']) : getCurToPrice($SHOP_ARY_DELIVERY["SHOP_DELIVERY_PRICE"]);?></td>
					</tr>
					<tr class="deliveryConditionInfoRow">
						<th><?=$LNG_TRANS_CHAR["PW00014"] //배송비무료조건?></th>
						<td>
							<?if ($prodRow['P_SHOP_NO'] > 0 && $prodShopInfo['SH_COM_DELIVERY'] == 'S'){?>
							<?=callLangTrans($LNG_TRANS_CHAR["PS00003"],array(getCurToPrice($prodShopInfo['SH_COM_DELIVERY_ST_PRICE']))); //{{단어1}}이상 구매시?>
							<?}else{?>
							<?=callLangTrans($LNG_TRANS_CHAR["PS00003"],array(getCurToPrice($SHOP_ARY_DELIVERY["SHOP_DELIVERY_ST_PRICE"]))); //{{단어1}}이상 구매시?>
							<?}?>
						</td>
					</tr>
					<?if(!$S_DELIVERY_PAY_TYPE):?>
					<input type="hidden" name="cartDelivery" id="cartDelivery" value="1">
					<?endif;?>
					<?		}}} else if ($prodRow[P_BAESONG_TYPE] == "2"){
						if ($S_SITE_LNG == "KR" && $S_DELIVERY_MTH != "G"){		?>
					<tr>
						<th><?=$LNG_TRANS_CHAR["PW00012"] //배송비?></th>
						<td><?=$LNG_TRANS_CHAR["PW00016"] //무료배송?></td>
					</tr>
					<?		}} else if ($prodRow[P_BAESONG_TYPE] == "3"){?>
					<tr>
						<th><?=$LNG_TRANS_CHAR["PW00012"] //배송비?></th>
						<td><?=$LNG_TRANS_CHAR["PW00017"] //고정 배송비?> <?=getCurToPrice($prodRow[P_BAESONG_PRICE])?><?=getCurMark2()?></td>
					</tr>
					<?		} else if ($prodRow[P_BAESONG_TYPE] == "4"){?>
					<tr>
						<th><?=$LNG_TRANS_CHAR["PW00012"] //배송비?></th>
						<td><?=$LNG_TRANS_CHAR["PW00018"] //수량별 배송?> <?=getCurToPrice($prodRow[P_BAESONG_PRICE])?><?=getCurMark2()?></td>
					</tr>
					<?		} else if ($prodRow[P_BAESONG_TYPE] == "5"){?>
					<tr>
						<th><?=$LNG_TRANS_CHAR["PW00012"] //배송비?></th>
						<td>
							<?if ($prodRow[P_BAESONG_PRICE] > 0){?>
							<?=callLangTrans($LNG_TRANS_CHAR["PS00006"],array($strMoneyIconL,getCurToPrice($prodRow[P_BAESONG_PRICE]),$strMoneyIconR)); //상품 수령 후 {{단어1}} {{단어2}} 지불?>
							<?}else{?>
							<?=callLangTrans($LNG_TRANS_CHAR["PS00006"],array("","","")); //상품 수령 후 {{단어1}} {{단어2}} 지불?>
							<?}?>
						</td>
					</tr>
					<?		}
					}
					?>
					<?if((in_array($prodAucRow['P_AUC_STATUS'],array("4","5"))) && $prodAucRow['P_AUC_SUC_M_NO']){?>
					<tr>
						<th><?=$LNG_TRANS_CHAR["PW00069"] //낙찰자?></th>
						<td>
							<?=$strProdAucSucMemberName?>
						</td>
					</tr>
					<?}else{?>
					<?if ($strProdAucBestMemberName){?>
					<tr>
						<th><?=$LNG_TRANS_CHAR["PW00060"] //최고가 입찰가?></th>
						<td>
							<?=$strProdAucBestMemberName?>
						</td>
					</tr>
					<?}}?>
				</table>


				<?if(($prodRow[P_QTY]>0 || $prodRow[P_STOCK_LIMIT] == "Y") && $prodRow[P_STOCK_OUT] != "Y" && !is_array($aryProdOpt)){?>
				<div id="divSelectOpt">
					<div id="divCartOptAttr_0">
						<input type="hidden" name="cartOptNo[]" value="0">
						<?if ($S_ARY_CUR[$S_SITE_LNG]["USD"][2] == "Y"){?>
						<input type="hidden" name="0_cartOptPrice" id="0_cartOptPrice" value="<?if ($prodRow[P_EVENT] > 0 && getProdEventInfo($prodRow) == "Y"){?><?=getCurToPrice($prodRow[P_SALE_PRICE],"US")?><?}else{?><?=getProdDiscountPrice($prodRow,"1",0,"US")?><?}?>">
						<input type="hidden" name="0_cartOptOrgPrice" id="0_cartOptOrgPrice" value="<?if ($prodRow[P_EVENT] > 0 && getProdEventInfo($prodRow) == "Y"){?><?=getCurToPrice($prodRow[P_SALE_PRICE])?><?}else{?><?=getProdDiscountPrice($prodRow)?><?}?>">
						<?}else{?>
						<input type="hidden" name="0_cartOptPrice" id="0_cartOptPrice" value="<?if ($prodRow[P_EVENT] > 0 && getProdEventInfo($prodRow) == "Y"){?><?=getCurToPrice($prodRow[P_SALE_PRICE])?><?}else{?><?=getProdDiscountPrice($prodRow)?><?}?>">
						<input type="hidden" name="0_cartOptOrgPrice" id="0_cartOptOrgPrice" value="0">
						<?}?>
						<input type="hidden" id="0_cartQty" name="0_cartQty" value="<?=$prodRow[P_MIN_QTY]?>" class="cntInputForm"/>
					</div>
				</div>
				<div class="totalPriceWrap" id="divSelectOptTotalPrice">
				</div>
				<?}else{?>
				<div class="optionValueWrap" id="divSelectOpt">
				</div>
				<div class="totalPriceWrap" id="divSelectOptTotalPrice">
				</div>
				<?}?>
				<!-- 구매버튼 -->
				</div><!-- 테이블Wrap 추가-->
				<div class="orderBtnWrap mt40">
					<?if($prodAucRow['P_AUC_STATUS'] == "2"){?>
					<a href="javascript:goProdAuctionApply('<?=$strP_CODE?>');" class="btnProdBuy"><span><?=$LNG_TRANS_CHAR["PW00061"] //입찰하기?></span></a>
					<a href="javascript:goProdAuctionOrder('<?=$strP_CODE?>');" class="btnProdBuy"><span><?=$LNG_TRANS_CHAR["PW00062"] //즉시구매?></span></a>
					<?}else if((in_array($prodAucRow['P_AUC_STATUS'],array("4","5"))) && $prodAucRow['P_AUC_ORDER'] != "Y"){?>
						<?if ($prodAucRow['P_AUC_SUC_M_NO'] == $g_member_no){?>
						<a href="javascript:goProdAuctionOrder('<?=$strP_CODE?>');" class="btnProdBuy"><span><?=$LNG_TRANS_CHAR["PW00021"] //구매하기?></span></a>
						<?}else{?>
						<span><?=$LNG_TRANS_CHAR["PW00068"] //경매종료?></span>
						<?}?>
					<?}?>
				</div>
				<!-- 구매버튼 -->
			</dd>
		</dl>
	</div>
	<div class="clear"></div>
	<!-- 상품 탑 상세정보 -->
</div>

