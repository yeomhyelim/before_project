<?
	# 베스트 상품 스킨 PB0003
	$strStyleDivName = "bestList{$no}";
?>

<style>
	.<?=$strStyleDivName?> tr td{vertical-align:top;}
	.<?=$strStyleDivName?> .listProdImg{width:<?=$intWSize?>px;height:<?=$intHSize?>px;}
	.<?=$strStyleDivName?> .title{color:<?=$strColor1?>;}
	.<?=$strStyleDivName?> .comment{color:<?=$strColor2?>;}
	.<?=$strStyleDivName?> .pricePoint{color:<?=$strColor3?>;}
	.<?=$strStyleDivName?> .priceConsumer{color:<?=$strColor4?>}
	.<?=$strStyleDivName?> .priceSale{color:<?=$strColor5?>;}

	.<?=$strStyleDivName?> div.productInfoWrap{width:<?=${"S_MAIN_PRODLIST_IMG_SIZE_W_{$no}"}?>px;margin-bottom:20px;text-align:<?=${"S_MAIN_BEST_LIST{$no}_WORD_ALIGN"}?>}
	.<?=$strStyleDivName?> div.productInfoWrap ul{margin-top:5px;}
	.<?=$strStyleDivName?> div.productInfoWrap ul li{padding: 2px 0;}
	.<?=$strStyleDivName?> div.productInfoWrap ul li img{vertical-align:middle;margin-top:-1px;margin-right:3px;}
</style>

<div class="bestList<?=$no?>">
	<div class="bestTitle"><?=$strTitleCode?></div>

	<table border="0">
		<? for($i=0;$i<$intHList;$i++): ?>
		<tr>
			<? for($j=0;$j<$intWList;$j++):	?>
			<td>
				<? $row = mysql_fetch_array($aryProdRow); 
				   if($row): 
						/* 색상 */
						if($row['P_COLOR'] && $strShow6):
							$row['P_COLOR'] = explode("|",$row['P_COLOR']);
							foreach($row['P_COLOR'] as $key => $val):
								if($val != "Y") { continue; }
								if($S_ARY_PROD_COLOR[$key]['USE'] != "Y") { continue; }
								$row['P_COLOR_IMG'][] = $S_ARY_PROD_COLOR[$key]['IMG'];
							endforeach;
						endif;
						/* 색상 */
						$intProdPoint = getProdPoint($row['P_SALE_PRICE'], $row['P_POINT'], $row['P_POINT_TYPE'], $row['P_POINT_OFF1'], $row['P_POINT_OFF2']); // 적립금	
						if(!$row['PM_REAL_NAME']) { $row['PM_REAL_NAME'] = "/upload/product/20120821/prodImg2/2012082100006.jpg"; }		?>
					<!-- 상품 디자인 -->
						<div class="productInfoWrap">
							<a href="javascript:goProdView('<?=$row['P_CODE']?>');"><img src="<?=$row['PM_REAL_NAME']?>" class="listProdImg"/></a>
							<?if ($row[P_EVENT] > 0 && getProdEventInfo($row) == "Y"){?>
								<?if ($S_EVENT_INFO[$row[P_EVENT]]["PRICE_TYPE"] == "1"){?>
								<div class="sailInfo">
									<?=$S_EVENT_INFO[$row[P_EVENT]]["PRICE_MARK"]?>%									
								</div>
								<?}?>
							<?}?>
							<ul <?= $style ?>>
								<? 
								   $iconTag = "";
								   $icon = explode("/", $row['P_LIST_ICON']);
								   for($x=0;$x<sizeof($icon);$x++):
									$iconTag .= $S_ARY_PRODUCT_LIST_ICON[$icon[$x]];
								   endfor; 
								   if($iconTag) { echo "<li class=\"prodIcon\">{$iconTag}</li>"; }
								?>
								<? if($row['P_COLOR_IMG']) : ?><li class="color">
								<? foreach($row['P_COLOR_IMG'] as $url):?>
								<span><img src="<?=$url?>"/></span>
								<? endforeach;?>
								</li><?endif;?><!--색상-->
								<? if($strShow8 == "Y") : ?><li class="brandTit"><?=$row['P_BRAND_NAME']?></li><?endif;?><!--브렌드-->
								<? if($strShow7 == "Y") : ?><li class="model"><?=$row['P_MODEL']?></li><?endif;?><!--모델명-->
								<? if($strShow1 == "Y") : ?><li class="title"><a href="javascript:goProdView('<?=$row['P_CODE']?>');"><?=strHanCutUtf2($row['P_NAME'], $intTitleMaxsize, "N")?></a></li><?endif;?><!--상품명-->
								<? if($strShow2 == "Y") : ?><li class="comment"><?=$row['P_ETC']?></li><?endif;?><!--상품설명-->
								<? if($intProdPoint>0 && $strShow3 == "Y") : ?><li class="pricePoint"><?=getCurToPrice($intProdPoint)?></li><?endif;?><!--적립금-->
								<? if($strShow4 == "Y" && $row['P_CONSUMER_PRICE'] > 0 && $row['P_CONSUMER_PRICE'] != $row['P_SALE_PRICE']) : ?>
									<li class="priceConsumer">
										<s><?=$strMoneyIconL?><?=getCurToPrice($row['P_CONSUMER_PRICE'])?><?=$strMoneyIconR?></s>
									</li><?endif;?><!--소비자가격-->
								<? if($strShow5 == "Y") : ?><li class="priceSale">
																<?if($row['P_PRICE_TEXT']): // 가격대체문구 ?>
																	<?=$row['P_PRICE_TEXT']?>
																<?else:?>		
																	<?if ($S_ARY_CUR[$S_SITE_LNG]["USD"][2] == "Y"){?> 
																	<?=getCurMark("USD")?> <?=getProdDiscountPrice($row,"1",0,"US")?><?=getCurMark2("USD")?>
																	(<?=$S_SITE_CUR_MARK1?><?=getProdDiscountPrice($row)?>)
																	<?}else{?>
																	<?=$strMoneyIconL?> <?=getProdDiscountPrice($row)?><?=$strMoneyIconR?>
																	<?}?>
																<?endif;?>
															</li><?endif;?><!--판매가격-->
							</ul>
						</div>
					<!-- 상품 디자인 -->
				<? endif; ?>
			</td>
			<? endfor;	?>
		</tr>
		<? endfor; ?>
	</table>


</div>