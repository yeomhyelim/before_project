<?
	if (is_array($aryProdGrpList)){
?>
<div class="mainProdList mt20">
	<div class="prodList">
		<table>
			<?
			for($i=0;$i<sizeof($aryProdGrpList);$i++){
				
				if ($i % 4 == 0) echo "<tr>";
				?>
				<td <?echo "style='width:".$S_PRODUCT_LIST_ISW."px;height:".$S_PRODUCT_LIST_ISH."px;'";?>>
					<!-- (1)prod -->
					<div class="prodWrap">
						<a href="javascript:goProdView('<?=$aryProdGrpList[$i][P_CODE]?>');"><img src=".<?=$aryProdGrpList[$i][PM_REAL_NAME]?>"/></a>
						<ul>
							<li class="title"><a href="javascript:goProdView('<?=$aryProdGrpList[$i][P_CODE]?>');"><?=strConvertCut($aryProdGrpList[$i][P_NAME],$D_PRODUCT_LIST_SUBJ_LEN,'N')?></a></li>
							<li class="priceOrg"><s><?=NUMBER_FORMAT($aryProdGrpList[$i][P_CONSUMER_PRICE])?>원</s></li>
							<li class="priceBoldGray"><?=NUMBER_FORMAT($aryProdGrpList[$i][P_SALE_PRICE])?>원</li>
							<?if ($aryProdGrpList[$i][P_EVENT_UNIT] && $aryProdGrpList[$i][P_EVENT]){?>
							<li>할인가 : <?=NUMBER_FORMAT(getProdEventPrice($aryProdGrpList[$i][P_SALE_PRICE],$aryProdGrpList[$i][P_EVENT_UNIT],$aryProdGrpList[$i][P_EVENT]))?></li>
							<?}?>
						</ul>
					</div><!-- prodWrap -->
					<!-- (1)prod -->
				</td>
				<?

				if ($i % 4 == 3) echo "</tr>";
			}

			for($i%4;$i<4;$i++){
					echo "<td><div class=\"prodWrap\"></div></td>";
					if ($i % 4 == 3) echo "</tr>";
			}
			?>
		</table>
	</div>
</div>
<?}?>