<?
	# 관련 상품 스킨 (상품상세설명 우측에 진열)
	# relationList.PB0001.C.skin.html.php		
?>

<style>
	.bestList tr td{width:<?=${"S_MAIN_PRODLIST_IMG_SIZE_W_{$no}"}?>px;height:<?=${"S_MAIN_PRODLIST_IMG_SIZE_H_{$no}"}?>px;text-align:<?=${"S_MAIN_BEST_LIST{$no}_WORD_ALIGN"}?>}
	.bestList .listProdImg{width:<?=$intWSize?>px;height:<?=$intHSize?>px;}
	.bestList .title{color:<?=$strColor1?>;}
	.bestList .comment{color:<?=$strColor2?>;}
	.bestList .pricePoint{color:<?=$strColor3?>;}
	.bestList .priceConsumer{color:<?=$strColor4?>}
	.bestList .priceSale{color:<?=$strColor5?>;font-weight:bold;font-family:verdana;}
</style>

<div class="bestList">

	<table border="0">
		<? for($i=0;$i<$intHList;$i++): ?>
		<tr>
			<? for($j=0;$j<$intWList;$j++):	?>
			<td>
				<? $row = mysql_fetch_array($aryProdRow); 
				   if($row): 
						if(!$row['PM_REAL_NAME']) { $row['PM_REAL_NAME'] = "/upload/product/20120821/prodImg2/2012082100006.jpg"; }		?>
					<!-- 상품 디자인 -->
						<img src="<?=$row['PM_REAL_NAME']?>" class="listProdImg"/>
						<?if ($row[P_EVENT] > 0 && getProdEventInfo($row) == "Y"){?>
							<?if ($S_EVENT_INFO[$row[P_EVENT]]["PRICE_TYPE"] == "1"){?>
							<div class="sailInfo">
								<?=$S_EVENT_INFO[$row[P_EVENT]]["PRICE_MARK"]?>%									
							</div>
							<?}?>
						<?}?>
						<ul <?= $style ?>>
							<li class="title"><a href="javascript:goProdView('<?=$row['P_CODE']?>');"><?=strHanCutUtf2($row['P_NAME'], $intTitleMaxsize, "N")?></a></li><!--상품명-->
							<li class="comment"><?=$row['P_ETC']?></li><!--상품설명-->
							<li class="pricePoint"><?=$row['P_POINT']?></li><!--적립금-->
							<li class="priceConsumer"><s><?=getCurMark()?> <?=getCurToPrice($row['P_CONSUMER_PRICE'])?></s></li><!--소비자가격-->
							<li class="priceSale"><?=getCurMark()?> <?=getCurToPrice($row['P_SALE_PRICE'])?></li><!--판매가격-->
							<?if($row['P_STOCK_OUT']=="Y"){?>
							<li class="soldout"><?php echo $LNG_TRANS_CHAR["PW00041"];?></li><!--품절-->
							<?}?>
						</ul>
					<!-- 상품 디자인 -->
				<? endif; ?>
			</td>
			<? endfor;	?>
		</tr>
		<? endfor; ?>
	</table>


</div>