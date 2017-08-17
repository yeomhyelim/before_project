<!-- (1) 상품 타이틀 이미지 -->
	<?include MALL_HOME."/include/subMenuTopImg.inc.php";?>
<!-- (1) 상품 타이틀 이미지 -->

<!-- (2) 상단 서브 카테고리 -->
	<?include MALL_HOME."/include/subMenuTopCate.inc.php";?>
<!-- (2) 상단 서브 카테고리 -->

<!-- (3) 서브추천 상품 목록 -->
	<?
		if($aryProdSubList) :
			foreach($aryProdSubList as $prodSub) :
				if($prodSub['IC_USE'] == "Y") :
					$strTitleName			= $prodSub['IC_NAME'];
					$strMainProdListIcon	= $prodSub['IC_CODE'];
					include sprintf ( "%swww/include/%s.inc.php", $S_DOCUMENT_ROOT, $S_SKIN['PRODUCT_LIST'] );
				endif;
			endforeach;
		endif;

//		if ( $strSearchIcon6 == "Y" || $strSearchIcon7 == "Y" || $strSearchIcon8 == "Y" || $strSearchIcon9 =="Y" ) :
//		else :
//			for($i=1;$i<=4;$i++){
//				if ($S_ARY_SUB_PRODLIST_USE[$i] == "Y"){
//					include sprintf ( "%swww/include/".$S_SKIN_SUB_PRODLIST.".inc.php", $S_DOCUMENT_ROOT );
//				}
//			}
//		endif;
	?>
<!-- (3) 서브추천 상품 목록 -->
<div class="subProdList mt30">
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
				<td <?if ($k % $intPageDesignLine == 0) echo "style='width:".$S_PRODUCT_LIST_ISW."px;'";?>>
					<div class="prodWrap">
						<a href="javascript:goProdView('<?=$row[P_CODE]?>');"><img src=".<?=$row[PM_REAL_NAME]?>" style="width:<?=$S_PRODUCT_LIST_ISW?>px;height:<?=$S_PRODUCT_LIST_ISH?>px;" class="listProdImg"/></a>
						<?if ($row[P_EVENT] > 0 && getProdEventInfo($row) == "Y"){?>
							<?if ($S_EVENT_INFO[$row[P_EVENT]]["PRICE_TYPE"] == "1"){?>
							<div class="sailInfo">
								<?=$S_EVENT_INFO[$row[P_EVENT]]["PRICE_MARK"]?><span>%</span>
							</div>
							<?}?>
						<?}?>
						<ul style="width:<?=$S_PRODUCT_LIST_ISW?>px;">
							<li class="title"><a href="javascript:goProdView('<?=$row[P_CODE]?>');"><?=$row[P_NAME]?></a></li>
							<?if ($row[P_CONSUMER_PRICE]>0){?><li class="priceOrg"><s><?=NUMBER_FORMAT($row[P_CONSUMER_PRICE])?>원</s></li><?}?>
							<li class="priceBoldGray"><?=NUMBER_FORMAT($row[P_SALE_PRICE])?>원</li>
							<?if ($row[P_EVENT_UNIT] && $row[P_EVENT]){?>
							<!-- li>할인가 : <?=NUMBER_FORMAT(getProdEventPrice($row[P_SALE_PRICE],$row[P_EVENT_UNIT],$row[P_EVENT]))?></li -->
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


