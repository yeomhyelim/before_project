<?
	# 관련 상품 스킨 (상품설명 위에 진열, 상품상세설명 하단에 진열)
	# relationList.PB0001.skin.html.php
?>

<style>
	div.relationProdListWrap table{width:100%;}

	div.relationProdListWrap .listProdImg{width:<?=$intWSize?>px;height:<?=$intHSize?>px;}
	div.relationProdListWrap .title{color:<?=$strColor1?>;}
	div.relationProdListWrap .comment{color:<?=$strColor2?>;}
	div.relationProdListWrap .pricePoint{color:<?=$strColor3?>;}
	div.relationProdListWrap .priceConsumer{color:<?=$strColor4?>}
	div.relationProdListWrap .priceSale{color:<?=$strColor5?>;}
</style>

<div class="relationProdListWrap">

	<table>
		<? for($i=0;$i<$intHList;$i++): ?>
		<tr>
			<? for($j=0;$j<$intWList;$j++):	?>
			<td>
				<? $row = mysql_fetch_array($aryProdRow); 
				   if($row): 
						if(!$row['PM_REAL_NAME']) { $row['PM_REAL_NAME'] = "/upload/product/20120821/prodImg2/2012082100006.jpg"; }		?>
					<!-- 상품 디자인 -->
					<div class="productInfoWrap">
						<img src=".<?=$row['PM_REAL_NAME']?>" class="listProdImg"/>
						<ul>
							<li class="title"><a href="javascript:goProdView('<?=$row['P_CODE']?>');"><?=$row[P_NAME]?></a></li><!--상품명-->
							<li class="comment"><?=$row['P_ETC']?></li><!--상품설명-->
							<li class="pricePoint"><?=$row['P_POINT']?></li><!--적립금-->
							<li class="priceConsumer"><s><?=getCurMark()?> <?=getCurToPrice($row['P_CONSUMER_PRICE'])?></s></li><!--소비자가격-->
							<li class="priceSale"><?=getCurMark()?> <?=getCurToPrice($row['P_SALE_PRICE'])?></li><!--판매가격-->
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