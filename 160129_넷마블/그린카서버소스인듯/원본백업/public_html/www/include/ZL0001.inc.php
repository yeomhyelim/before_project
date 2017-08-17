<?php 	

	$i = $strMainProdListIcon;
	$intWList 			= ${"S_MAIN_PRODLIST_IMG_VIEW_W_".$i};
	$intHList			= ${"S_MAIN_PRODLIST_IMG_VIEW_H_".$i};
	$intWSize 			= ${"S_MAIN_PRODLIST_IMG_SIZE_W_".$i};
	$intHSize			= ${"S_MAIN_PRODLIST_IMG_SIZE_H_".$i};
	
	$strTitleImg		= ${"S_MAIN_PRODLIST_TIT_".$i};

	$productMgr->setSearchIcon1("");
	$productMgr->setSearchIcon2("");
	$productMgr->setSearchIcon3("");
	$productMgr->setSearchIcon4("");
	$productMgr->setSearchIcon5("");
	$productMgr->setSearchIcon6("");
	$productMgr->setSearchIcon7("");
	$productMgr->setSearchIcon8("");
	$productMgr->setSearchIcon9("");
	$productMgr->setSearchIcon10("");
	
	$productMgr->setLimitFirst(0);
	
	$intPageLine 		= $intWList * $intHList;
	
	$productMgr->setPageLine($intPageLine);
	
	if( $i == 1 ) :
		$productMgr->setSearchIcon1("Y");							// 메인 신상품
		$strTitleName = "메인 신상품";
	elseif ($i == 2) :
		$productMgr->setSearchIcon2("Y");							// 메인 베스트상품
		$strTitleName = "메인 베스트상품";
	elseif ($i == 3) :
		$productMgr->setSearchIcon3("Y");							// 메인 추천상품
		$strTitleName = "메인 추천상품";
	elseif ($i == 4) :
		$productMgr->setSearchIcon4("Y");							// 메인 MD추천상품
		$strTitleName = "메인 MD추천상품";
	elseif ($strTag == "{{__subpage_new__}}" ) :
		$productMgr->setSearchIcon6("Y");							// 서브 신상품
		$strTitleName = "서브 신상품";
	elseif ($strTag == "{{__subpage_best__}}" ) :
		$productMgr->setSearchIcon7("Y");							// 서브 베스트상품
		$strTitleName = "서브 베스트상품";
	elseif ($strTag == "{{__subpage_recommend__}}" ) :
		$productMgr->setSearchIcon8("Y");							// 서브 추천상품
		$strTitleName = "서브 추천상품";
	elseif ($strTag == "{{__subpage_md__}}" ) :
		$productMgr->setSearchIcon9("Y");							// 서브 MD추천상품
		$strTitleName = "서브 MD추천상품";
	endif;
	
	$intProdRowCnt 	= $productMgr->getProdTotal($db);	
	$aryProdRow 	= $productMgr->getProdList($db);

	if($strTitleImg) :
		echo sprintf("<img src=\"%s\"/>", $strTitleImg);
	endif;

//	echo $strTitleName;
?>

<div class="mainProdList">

	<table>
		<? if ( $intProdRowCnt == 0 ) : ?>
		<tr>
			<td colspan="4"><?=$LNG_TRANS_CHAR["PS00001"]?></td>
		</tr>
		<? 
			else :
				$i = 1;
				while( $row = mysql_fetch_array( $aryProdRow ) ) : 
					
					$aryProdListIconList = explode("/",$row[P_LIST_ICON]);
					$tr 		= $i % $intWList;
					$style 	= ( $tr == 0 ) ? sprintf( "style='width:%spx;'", $intWSize ) : "";

					echo ( $tr == 1 ) ? "<tr>" : "";
		?>
					<td <?= $style ?>>
						<div class="prodWrap" style='width:<?=$intWSize?>px;'>
							<a href="javascript:goProdView('<?=$row[P_CODE]?>');">
								<img src="..<?=$row[PM_REAL_NAME]?>" style="width:<?=$intWSize?>px;height:<?=$intHSize?>px" class="listProdImg"/>
							</a>
							<ul <?= $style ?>>
								<li class="title"><a href="javascript:goProdView('<?=$row[P_CODE]?>');"><?=$row[P_NAME]?></a></li>
								<li class="priceOrg"><s><?=getCurMark()?>  <?=getCurToPrice($row[P_CONSUMER_PRICE])?></s></li>
								<li class="priceBoldGray"><?=getCurMark()?>  <?=getCurToPrice($row[P_SALE_PRICE])?></li>
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
					echo ( $tr == 0 ) ? "</tr>" : "";
					$i++;
				endwhile; 
			endif; 
		?>
	</table>
</div>
