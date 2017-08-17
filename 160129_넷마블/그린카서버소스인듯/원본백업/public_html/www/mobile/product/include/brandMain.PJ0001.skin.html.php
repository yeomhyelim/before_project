<?
	# 브랜드 메인 스킨 PJ0001
?>

<style>
	.brandMainListWrap table{width:100%;}
	.brandMainListWrap table td{vertical-align:top;padding-bottom:20px;text-align:<?=$strWAlign?>;}
	.brandMainListWrap .listProdImg{width:<?=$intWSize?>px;height:<?=$intHSize?>px;}
	.brandMainListWrap .title{color:<?=$strColor1?>;}
	.brandMainListWrap .comment{color:<?=$strColor2?>;}
	.brandMainListWrap .pricePoint{color:<?=$strColor3?>;}
	.brandMainListWrap .priceConsumer{color:<?=$strColor4?>}
	.brandMainListWrap .priceSale{color:<?=$strColor5?>;}
</style>

<div class="brandMainListWrap">
	<table>
		<? for($i=0,$k=0;$i<$intHList;$i++): ?>
		<tr>
			<? for($j=0;$j<$intWList;$j++):	?>
			<td<? if($j==($intWList-1)) { echo sprintf(" style='width:%dpx'", $intWSize); } ?>>
				<? $row = mysql_fetch_array($result); $k++;

				   if($row):										?>
					<!-- 브랜드 디자인 -->
						<a href="./?menuType=product&mode=brandList&pr_no=<?=$row['PR_NO']?>"><img src="<?=$row['PR_LIST_IMG']?>" class="listProdImg"/></a><!--브랜드목록이미지-->
						<?if($strShow1 == "Y"):?>
							<spend class="title"><?=$row['PR_NAME']?></spend>
						<?endif;?>
					<!-- 브랜드 디자인 -->
				<? endif; ?>
			</td>
			<? endfor;	?>
		</tr>
		<? if($intTotal <= $k) { break; } ?>
		<? endfor; ?>
	</table>
</div>



