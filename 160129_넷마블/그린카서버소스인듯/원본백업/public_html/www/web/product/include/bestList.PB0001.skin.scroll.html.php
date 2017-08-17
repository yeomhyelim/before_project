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

<?
	## 설정

	## 2013.10.10 박영미 추가
	## 메인베스트상품 스크롤 사용유무
	## http://nafigure.eumshop.co.kr -> slider 사용 중입니다. 속도 (4000 -> 8000으로 변경, 고객요청)
	## 다른 사이트에서 사용을 원하시면 옵션으로 변경하도록 변경하시기 바랍니다.
?>
<script language="javascript" type="text/javascript" src="../common/js/slides.jquery.js"></script>
<script>
	$(function(){
		// Initialize Slides
		$('#mainProdBestList_motion<?=$no?>').slides({
			container: 'prodListWrap',
			generatePagination: false,
			play: 8000,
			pause: 8000,
			slideSpeed: 2000,
			start: 1,
			effect:'slide'
			,ways:'up'
		});
	});
</script>

<div class="bestProdListWrap<?=$no?>" id="mainProdBestList_motion<?=$no?>">
	<div class="bestTitle"><?=$strTitleCode?></div>

	<div class="prodListWrap">

		<?for($i=0;$i<$intHList;$i++): ?>
		<div class="slide">
		<table>			
			<tr>
				<? for($j=0;$j<$intWList;$j++):	?>
				<td<? if($j==($intWList-1)) { echo sprintf(" style='width:%dpx'", $intWSize); } ?>>
					<? if(!$row) { $row = mysql_fetch_array($aryProdRow); }
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
							<? $divClass = "class='productInfoWrap'";	if($j==($intWList-1)) { $divClass = "class='productInfoWrap endProdList'"; } ?>
							<div <?=$divClass?>  style="width:<?=$intWSize?>px;text-align:<?=$strWAlign?>">
								<div class="bestIco_<?=$j?>">
								</div>
								<?
								## 상세보기를 이미지가 아닌 동영상으로 보이게 하며 특정 카테고리에서만 동영상이 보이도록 처리
								if ($S_FIX_PROD_VIEW_MOVIE_FLAG == "Y" && !in_array(SUBSTR($row['P_CATE'],0,3),$S_FIX_PROD_VIEW_MOVIE_CATE_NOT_LIST)){
									$productMgr->setP_CODE($row['P_CODE']);
									$productMgr->setPM_TYPE("movie1");
									$prodMovieRow = $productMgr->getProdImg($db);
									
									$strProdMovieUrl1 = $prodMovieRow[0]['PM_REAL_NAME'];
									?>
								<iframe width="<?=$intWSize?>" height="<?=$intHSize?>" src="<?=$strProdMovieUrl1?>" frameborder="0" allowfullscreen></iframe>
									<?
								} else {
								?>
								<a href="javascript:goProdView('<?=$row['P_CODE']?>');"><img src="<?=$row['PM_REAL_NAME']?>" class="listProdImg" style="width:<?=$intWSize?>px;height:<?=$intHSize?>px;"/></a>
								<?}?>
								<?if ($row[P_EVENT] > 0 && getProdEventInfo($row) == "Y"){?>
									<?if ($S_EVENT_INFO[$row[P_EVENT]]["PRICE_TYPE"] == "1"){?>
									<div class="sailInfo">
										<strong><?=$S_EVENT_INFO[$row[P_EVENT]]["PRICE_MARK"]?></strong>%									
									</div>
									<?}?>
								<?}?>
								<div class="prodInfoSum">
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
										<? if($strShow1 == "Y") : ?><li class="title"><a href="javascript:goProdView('<?=$row['P_CODE']?>');"><?=strHanCutUtf2($row[P_NAME], $intTitleMaxsize, "N")?></a></li><?endif;?><!--상품명-->
										<? if($strShow7 == "Y") : ?><li class="model"><?=$row['P_MODEL']?></li><?endif;?><!--모델명-->
										<? if($strShow2 == "Y") : ?><li class="comment"><?=$row['P_ETC']?></li><?endif;?><!--상품설명-->
										<? if($intProdPoint>0 && $strShow3 == "Y") : ?><li class="pricePoint"><?=getCurToPrice($intProdPoint)?></li><?endif;?><!--적립금-->
										<? if($strShow4 == "Y") : ?><li class="priceConsumer"><s><?=$strMoneyIconL?><?=getCurToPrice($row['P_CONSUMER_PRICE'])?><?=$strMoneyIconR?></s></li><?endif;?><!--소비자가격-->
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
							</div>
						<!-- 상품 디자인 -->
					<? endif; ?>
				</td>
				<?php $row = mysql_fetch_array($aryProdRow); ?>
				<? endfor;	?>
			</tr>
		</table>
		</div>
		<?php if(!$row) { break; }?>
		<? endfor; ?>
	</div>
</div>