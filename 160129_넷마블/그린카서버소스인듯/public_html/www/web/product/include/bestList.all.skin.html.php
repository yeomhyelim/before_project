<?
	# 베스트 상품 스킨 PB0001
	$strStyleDivName = "bestProdListWrap{$no}";
?>

<style>
	.<?=$strStyleDivName?> .title{color:<?=$strColor1?>;}
	.<?=$strStyleDivName?> .comment{color:<?=$strColor2?>;}
	.<?=$strStyleDivName?> .pricePoint{color:<?=$strColor3?>;}
	.<?=$strStyleDivName?> .priceConsumer{color:<?=$strColor4?>}
	.<?=$strStyleDivName?> .priceSale{color:<?=$strColor5?>;}
</style>

<div class="bestProdListWrap<?=$no?>">
	<div class="bestTitle"><?=$strTitleCode?></div>

	<div class="prodListWrap">
	<table>
		<? for($i=0;$i<$intHList;$i++): ?>
		<tr>
			<? for($j=0;$j<$intWList;$j++):	?>
			<td<? if($j==($intWList-1)) { echo sprintf(" style='width:%dpx'", $intWSize); } ?>>
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
						<div class="productInfoWrap" style="width:<?=$intWSize?>px;text-align:<?=$strWAlign?>">
							<div class="bestIco_<?=$j?>">
							</div>
							<a href="javascript:goProdView('<?=$row['P_CODE']?>');"><img src="<?=$row['PM_REAL_NAME']?>" class="listProdImg" style="width:<?=$intWSize?>px;height:<?=$intHSize?>px;"/></a>
							<?if ($row[P_EVENT] > 0 && getProdEventInfo($row) == "Y"){?>
								<?if ($S_EVENT_INFO[$row[P_EVENT]]["PRICE_TYPE"] == "1"){?>
								<div class="sailInfo">
									<strong><?=$S_EVENT_INFO[$row[P_EVENT]]["PRICE_MARK"]?></strong>%									
								</div>
								<?}?>
							<?}?>
							<div class="prodInfoSum">
								<ul <?= $style ?>>
									<? $icon = explode("/", $row['P_LIST_ICON']);
									   for($x=1;$x<=10;$x++):
										if(in_array($x, $icon)) { $iconTag .= $S_ARY_PRODUCT_LIST_ICON[$x]; };
									   endfor; 
									   if($iconTag) { echo "<li class=\"prodIcon\">{$iconTag}</li>"; }
									?>
									<? if($row['P_COLOR_IMG']) : ?><li class="color">
									<? foreach($row['P_COLOR_IMG'] as $url):?>
									<span><img src="<?=$url?>"/></span>
									<? endforeach;?>
									</li><?endif;?><!--색상-->
									<li class="brandTit"><?=$row['P_BRAND_NAME']?></li><!--브렌드-->								
									<li class="title"><a href="javascript:goProdView('<?=$row['P_CODE']?>');"><?=strHanCutUtf2($row[P_NAME], $intTitleMaxsize, "N")?></a></li><!--상품명-->
									<? if($strShow7 == "Y") : ?><li class="model"><?=$row['P_MODEL']?></li><?endif;?><!--모델명-->
									<? if($strShow2 == "Y") : ?><li class="comment"><?=$row['P_ETC']?></li><?endif;?><!--상품설명-->
									<? if($intProdPoint>0 && $strShow3 == "Y") : ?><li class="pricePoint"><?=getCurToPrice($intProdPoint)?></li><?endif;?><!--적립금-->
									<li class="priceConsumer"><s><?=$strMoneyIconL?><?=getCurToPrice($row['P_CONSUMER_PRICE'])?><?=$strMoneyIconR?></s></li><!--소비자가격-->
									<li class="priceSale">
																	<?if($row['P_PRICE_TEXT']): // 가격대체문구 ?>
																		<?=$row['P_PRICE_TEXT']?>
																	<?else:?>		
																		<?=$strMoneyIconL?><?=getProdDiscountPrice($row)?><?=$strMoneyIconR?>
																	<?endif;?>
																</li><!--판매가격-->
								</ul>
							</div>
						</div>
					<!-- 상품 디자인 -->
				<? endif; ?>
			</td>
			<? endfor;	?>
		</tr>
		<? endfor; ?>
	</table>
	</div>


</div>