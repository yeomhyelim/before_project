<?
	$bannerImageUrl 			= sprintf( "/upload/layout/product/banner/%s" , "20120921040404.jpg" );
?>

<!-- (1) 메인배너 -->
<div class="mainBanner alignRight">
	<img src="<?= $bannerImageUrl ?>"/>
</div>
<!-- (1) 메인배너 -->



<div class="mainProdList mt30">
	<!-- -->
	<div class="sortWrap">
		<h3> <strong><?=$strSearchHCodeName1?></strong> 총<strong><?=$intTotal?>개</strong>의 상품이 있습니다.</h3>
		<div class="sortBtn">
			<img src="./himg/product/A0001/txt_sort_price.gif"/>
			<a href="javascript:goSearchSort('RA');"><img src="./himg/product/A0001/btn_sort_down.gif"/></a><a href="javascript:goSearchSort('RD');"><img src="./himg/product/A0001/btn_sort_up.gif"/></a> 
			<img src="./himg/product/A0001/txt_sort_name.gif"/>
			<a href="javascript:goSearchSort('NA');"><img src="./himg/product/A0001/btn_sort_down.gif"/></a><a href="javascript:goSearchSort('ND');"><img src="./himg/product/A0001/btn_sort_up.gif"/></a> 
			<img src="./himg/product/A0001/txt_sort_point.gif"/>
			<a href="javascript:goSearchSort('PA');"><img src="./himg/product/A0001/btn_sort_down.gif"/></a><a href="javascript:goSearchSort('PD');"><img src="./himg/product/A0001/btn_sort_up.gif"/></a>
			<img src="./himg/product/A0001/txt_sort_brand.gif"/>
			<a href="javascript:goSearchSort('MA');"><img src="./himg/product/A0001/btn_sort_down.gif"/></a><a href="javascript:goSearchSort('MD');"><img src="./himg/product/A0001/btn_sort_up.gif"/></a> 
		</div>
		<div class="clear"></div>
	</div>
	<!-- -->
	<div class="prodList mt20">
		<table>
			<?if ($intTotal == 0){?>
			<tr>
				<td colspan="4">등록된 상품이 없습니다.</td>
			</tr>
			<?}else{
				
				$k = 1;
				while($row = mysql_fetch_array($result)){
					$aryProdListIconList = explode("/",$row[P_LIST_ICON]);
					if ($k % $intPageDesignLine == 1) echo "<tr>";
					?>
				<td <?if ($k % $intPageDesignLine == 0) echo "style='width:".$D_PRODUCT_LIST_IW."px;'";?>>
					<div class="prodWrap">
						<a href="javascript:goProdView('<?=$row[P_CODE]?>');"><img src=".<?=$row[PM_REAL_NAME]?>" style="width:<?=$D_PRODUCT_LIST_IW?>px;height:<?=$D_PRODUCT_LIST_IH?>px;" class="listProdImg"/></a>
						<ul>
							<li class="title"><a href="javascript:goProdView('<?=$row[P_CODE]?>');"><?=$row[P_NAME]?></a></li>
							<?if ($row[P_CONSUMER_PRICE]>0){?><li class="priceOrg"><s><?=NUMBER_FORMAT($row[P_CONSUMER_PRICE])?>원</s></li><?}?>
							<li class="priceBoldGray"><?=NUMBER_FORMAT($row[P_SALE_PRICE])?>원</li>
							<?if ($row[P_EVENT_UNIT] && $row[P_EVENT]){?>
							<!--<li>할인가 : <?=NUMBER_FORMAT(getProdEventPrice($row[P_SALE_PRICE],$row[P_EVENT_UNIT],$row[P_EVENT]))?></li>//-->
							<?}?>
							<?
								if(is_array($aryProdListIconList)){
									echo "<li>";
									for($n=0;$n<sizeof($aryProdListIconList);$n++){
										echo $S_ARY_PRODUCT_LIST_ICON[$aryProdListIconList[$n]];
									}
									echo "</li>";
								}
							?>
						</ul>
					</div>
				</td>					
					<?
					
					if ($k % $intPageDesignLine == 0) echo "</tr>";
					$k++;
				}

				for($k%$intPageDesignLine;$k<=$intPageDesignLine;$k++){
					echo "<td><div class=\"prodWrap\"></div></td>";
					if ($k % $intPageDesignLine == 0) echo "</tr>";
				}
			}
			?>
		</table>
		<div id="pagenate">
			<?=drawUserPaging($intPage,$intPageLine,$intPageBlock,$intTotal,$intTotPage,$linkPage,"","","",""," | ")?>
		</div>
	</div>
</div>

<!-- 2012.08.04 -- KIM HEE-SUNG -- REVIEW //-->
<!-- <input type="hidden" name="bCode" value="REVIEW" /> //-->
<!-- 2012.08.04 -- KIM HEE-SUNG -- REVIEW //-->
