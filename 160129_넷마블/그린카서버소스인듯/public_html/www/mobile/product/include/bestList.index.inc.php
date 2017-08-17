<?

	## 모듈 설정
	require_once MALL_HOME . "/module/ProductMgr.php";
	$productMgr = new ProductMgr($db);
	
	## 설정 파일 설정
	require_once MALL_SHOP . "/conf/site_skin_main.conf.inc.php";
	require_once MALL_SHOP . "/conf/product.inc.php";
	require_once MALL_SHOP . "/conf/order.inc.php";
	require_once MALL_PROD_FUNC;

//	$no				= 1;
	$strUse			= $S_ARY_MAIN_PRODLIST_USE[$no];
	$strTitle		= ${"S_MAIN_PRODLIST_TIT_{$no}"};

	if($strUse == "Y" && ($strTitle)) :
		// 베스트 상품
		
		/* 정의 */
		$intWSize 			= ${"S_MAIN_PRODLIST_IMG_SIZE_W_{$no}"};
		$intHSize			= ${"S_MAIN_PRODLIST_IMG_SIZE_H_{$no}"};
		if(!$intWList):
		$intWList 			= ${"S_MAIN_PRODLIST_IMG_VIEW_W_{$no}"};
		endif;
		if(!$intHList):
		$intHList			= ${"S_MAIN_PRODLIST_IMG_VIEW_H_{$no}"};
		endif;
		$strWAlign			= ${"S_MAIN_BEST_LIST{$no}_WORD_ALIGN"};
		$strMoney			= ${"S_MAIN_BEST_LIST{$no}_MONEY_TYPE"};
		$strMoneyIcon		= ${"S_MAIN_BEST_LIST{$no}_MONEY_ICON"};
		$strShow1			= ${"S_MAIN_BEST_LIST{$no}_SHOW_1"};
		$strShow2			= ${"S_MAIN_BEST_LIST{$no}_SHOW_2"};
		$strShow3			= ${"S_MAIN_BEST_LIST{$no}_SHOW_3"};
		$strShow4			= ${"S_MAIN_BEST_LIST{$no}_SHOW_4"};
		$strShow5			= ${"S_MAIN_BEST_LIST{$no}_SHOW_5"};
		$strShow6			= ${"S_MAIN_BEST_LIST{$no}_SHOW_6"};
		$strShow7			= ${"S_MAIN_BEST_LIST{$no}_SHOW_7"};
		$strShow8			= ${"S_MAIN_BEST_LIST{$no}_SHOW_8"};
		if(!$strColor1):
		$strColor1			= ${"S_MAIN_BEST_LIST{$no}_COLOR_1"};
		endif;
		if(!$strColor2):
		$strColor2			= ${"S_MAIN_BEST_LIST{$no}_COLOR_2"};
		endif;
		if(!$strColor3):
		$strColor3			= ${"S_MAIN_BEST_LIST{$no}_COLOR_3"};
		endif;
		if(!$strColor4):
		$strColor4			= ${"S_MAIN_BEST_LIST{$no}_COLOR_4"};
		endif;
		if($strColor5):
		$strColor5			= ${"S_MAIN_BEST_LIST{$no}_COLOR_5"};
		endif;
		$strTitleShow		= ${"S_MAIN_BEST_LIST{$no}_TITLE_SHOW_USE"};
		$strTitleFile		= ${"S_MAIN_BEST_LIST{$no}_TITLE_FILE_NAME"};
		$intTitleMaxsize	= ${"S_MAIN_BEST_LIST{$no}_TITLE_MAXSIZE"};


		/* 통화 */
		$strMoneyIconL		= "";
		$strMoneyIconR		= "";
		$strMoney				= "won";
		if($strMoney == "sign" || $strMoney == "won"){ 
			if ($S_SITE_LNG != "KR" && $S_SITE_LNG != "JP"  && $S_SITE_LNG != "RU"){
				$strMoneyIconL = $S_SITE_CUR_MARK2." ";
			} else {
				if ($S_SITE_LNG == "JP") $strMoneyIconR = $S_SITE_CUR_MARK1;
				else if ($S_SITE_LNG == "RU") $strMoneyIconR = $S_SITE_CUR_MARK1;
				else $strMoneyIconR = $S_SITE_CUR_MARK2;
			}
		} 
	    else if($strMoney =="icon")	{ $strMoneyIconL = sprintf(" <img src='/himg/icon/%s'>", $strMoneyIcon); } 
		else						{ $strMoneyIcon = ""; }

		/* 타이틀 */
		$strTitleCode		= "";
		if($strTitleShow == "style") { $strTitleCode = $strTitle; }
		else if($strTitleShow == "image") { $strTitleCode = ($strTitleFile) ? sprintf("<img src='%s'/>", $strTitleFile) : ""; }

		/* 기존에 등록된 데이터 삭제 */
		$productMgr->setSearchHCode1("");
		$productMgr->setSearchHCode2("");
		$productMgr->setSearchHCode3("");
		$productMgr->setSearchHCode4("");
		$productMgr->setSearchField("");
		$productMgr->setSearchKey("");
		$productMgr->setSearchWebView("");
		$productMgr->setSearchMobileView("Y");
		$productMgr->setSearchPriceView("");
		$productMgr->setSearchSort("");
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
		$productMgr->setP_BRAND($p_brand);
		$productMgr->setP_SHOP_NO($intProductShopNo);


		/* 상품 호출 개수 */
		$intPageLine 		= $intWList * $intHList;

		/* 베스트 상품 그룹(아이콘) 설정 */
		if( $no == 1 ) :
			$productMgr->setSearchIcon1("Y");
		elseif ($no == 2) :
			$productMgr->setSearchIcon2("Y");	
		elseif ($no == 3) :
			$productMgr->setSearchIcon3("Y");	
		elseif ($no == 4) :
			$productMgr->setSearchIcon4("Y");	
		elseif ($no == 5) :
			$productMgr->setSearchIcon5("Y");	
		endif;

		$productMgr->setPageLine($intPageLine);
		$intProdRowCnt 		= $productMgr->getProdTotal($db);	

		$aryProdRow 		= $productMgr->getProdList($db);
//		echo $db->query;

		// 스킨
		if($intProdRowCnt == 0) :
			echo "<div class=\"noListWrap\">";
			echo  $LNG_TRANS_CHAR["PS00001"] ;	// 등록된 상품이 없습니다.
			echo "</div>";
		else :
			//include "bestList." . ${"S_MAIN_BEST_LIST{$no}_DESIGN"} . ".skin.html.php";		
			?>
			<?
				# 베스트 상품 스킨 PB0001
				$strStyleDivName = "bestProdListWrap{$no}";
				$intWList ="2";
			?>



			<div class="prodListWrap">
				<ul>
					<? for($i=0;$i<$intHList;$i++): ?>
						<? for($j=0;$j<$intWList;$j++):	?>
						<li>
							<? $row = mysql_fetch_array($aryProdRow); 
							   if($row): 
							   
									$intP_SALE_PRICE = $row['P_SALE_PRICE'];
									$intP_CONSUMER_PRICE = $row['P_CONSUMER_PRICE'];

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
									<div <?=$divClass?>>
										<div class="bestIco_<?=$j?>">
										</div>
										<a href="javascript:goProdView('<?=$row['P_CODE']?>');"><img src="<?=$row['PM_REAL_NAME']?>" class="listProdImg"/></a>
										<?if ($row[P_EVENT] > 0 && getProdEventInfo($row) == "Y"){?>
											<?if ($S_EVENT_INFO[$row[P_EVENT]]["PRICE_TYPE"] == "1"){?>
											<div class="sailInfo">
												<strong><?=$S_EVENT_INFO[$row[P_EVENT]]["PRICE_MARK"]?></strong>%									
											</div>
											<?}?>
										<?}?>
										<div class="prodInfoSum">
											<dl>
												<? 
												   $iconTag = "";
												   $icon = explode("/", $row['P_LIST_ICON']);
												   for($x=0;$x<sizeof($icon);$x++):
													$iconTag .= $S_ARY_PRODUCT_LIST_ICON[$icon[$x]];
												   endfor; 

												   if($iconTag) { echo "<dd class=\"prodIcon\">{$iconTag}</dd>"; }
												?>
												<? if($row['P_COLOR_IMG']) : ?><dd class="color">
												<? foreach($row['P_COLOR_IMG'] as $url):?>
												<span><img src="<?=$url?>"/></span>
												<? endforeach;?>
												</dd><?endif;?><!--색상-->
												<? if($strShow8 == "Y") : ?><dd class="brandTit"><?=$row['P_BRAND_NAME']?></dd><?endif;?><!--브렌드-->								
												<? if($strShow1 == "Y") : ?><dd class="title"><a href="javascript:goProdView('<?=$row['P_CODE']?>');"><?=strHanCutUtf2($row[P_NAME], $intTitleMaxsize, "N")?></a></dd><?endif;?><!--상품명-->
												<? if($strShow7 == "Y") : ?><dd class="model"><?=$row['P_MODEL']?></dd><?endif;?><!--모델명-->
												<? if($strShow2 == "Y") : ?><dd class="comment"><?=$row['P_ETC']?></dd><?endif;?><!--상품설명-->
												<? if($intProdPoint>0 && $strShow3 == "Y") : ?><dd class="pricePoint"><?=getCurToPrice($intProdPoint)?></dd><?endif;?><!--적립금-->
												<? if($strShow4 == "Y") : ?>
													<dd class="priceConsumer"><s><?=$strMoneyIconL?><?=getCurToPrice($row['P_CONSUMER_PRICE'])?><?=$strMoneyIconR?></s></dd>
												<?endif;?><!--소비자가격-->
												<? if($strShow5 == "Y") : ?>
													<dd class="priceSale">
																<?if($row['P_PRICE_TEXT']): // 가격대체문구 ?>
																		<?=$row['P_PRICE_TEXT']?>
																<?else:?>		
																<?if ($S_ARY_CUR[$S_SITE_LNG]["USD"][2] == "Y"){?> 
																	<?=getCurMark("USD")?> <?=getProdDiscountPrice($row,"1",0,"US")?><?=getCurMark2("USD")?>(<?=$S_SITE_CUR_MARK1?><?=getProdDiscountPrice($row)?>)
																<?}else{?>
																	<?=$strMoneyIconL?> <?=getProdDiscountPrice($row)?><?=$strMoneyIconR?>
																<?}?>
															<?endif;?>
													</dd>
												<?endif;?><!--판매가격-->
											</dl>
										</div>
									</div>
								<!-- 상품 디자인 -->
							<? endif; ?>
						</li>
						<? endfor;	?>
					<? endfor; ?>
				</ul>
				<div class="clr"></div>
			</div>
			<?
		endif;

		## 초기화
		$intWSize 			= "";
		$intHSize			= "";
		$intWList 			= "";
		$intHList			= "";


	endif;
?>