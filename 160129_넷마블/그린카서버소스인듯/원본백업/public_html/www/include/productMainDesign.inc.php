<?php 	

	$intWList 			= $D_PRODUCT_OP[$strTag]['W_LIST'];
	$intHList			= $D_PRODUCT_OP[$strTag]['H_LIST'];
	$intWSize 			= $D_PRODUCT_OP[$strTag]['W_SIZE'];
	$intHSize			= $D_PRODUCT_OP[$strTag]['H_SIZE'];
		
	$productMgr->setLimitFirst(0);
	
	$intPageLine 		= $intWList * $intHList;
	
	$productMgr->setPageLine($intPageLine);
	
	if( $strTag == "{{__main_new__}}" ) :
		$productMgr->setSearchIcon1("Y");							// 메인 신상품
		$strTitleName = "메인 신상품";
	elseif ($strTag == "{{__main_best__}}" ) :
		$productMgr->setSearchIcon2("Y");							// 메인 베스트상품
		$strTitleName = "메인 베스트상품";
	elseif ($strTag == "{{__main_recommend__}}" ) :
		$productMgr->setSearchIcon3("Y");							// 메인 추천상품
		$strTitleName = "메인 추천상품";
	elseif ($strTag == "{{__main_md__}}" ) :
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
	$aryProdRow 		= $productMgr->getProdList($db);

	//echo $strTitleName;
?>



<div class="mainProdList">

	<table>
		<? if ( $intProdRowCnt == 0 ) : ?>
		<tr>
			<td colspan="4">등록된 상품이 없습니다.</td>
		</tr>
		<? 
			else :
				$i = 1;
				while( $row = mysql_fetch_array( $aryProdRow ) ) : 
					$tr 		= $i % $intWList;
					$style 	= ( $tr == 0 ) ? sprintf( "style='width:%spx;'", $intWSize ) : "";

					echo ( $tr == 1 ) ? "<tr>" : "";
		?>
					<td <?= $style ?>>
						<div class="prodWrap" <?= $style ?> >
							<a href="javascript:goProdView('<?=$row[P_CODE]?>');">
								<img src="..<?=$row[PM_REAL_NAME]?>" style="width:<?=$intWSize?>px;height:<?=$intHSize?>px" class="listProdImg"/>
							</a>
							<ul <?= $style ?>>
								<li class="title"><a href="javascript:goProdView('<?=$row[P_CODE]?>');"><?=$row[P_NAME]?></a></li>
								<li class="priceOrg"><s><?=NUMBER_FORMAT($row[P_CONSUMER_PRICE])?>원</s></li>
								<li class="priceBoldGray"><?=NUMBER_FORMAT($row[P_SALE_PRICE])?>원</li>
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