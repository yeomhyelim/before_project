<?
	$no					= 1;

	// 상품 리스트

	/* 정의 */
	$intWSize 			= $S_PRODLIST_IMG_SIZE_W;
	$intHSize			= $S_PRODLIST_IMG_SIZE_H;
	$intWList 			= $S_PRODLIST_IMG_VIEW_W;
	$intHList			= $S_PRODLIST_IMG_VIEW_H;
	$strWAlign			= $S_PRODLIST_WORD_ALIGN;
	$strMoney			= $S_PRODLIST_MONEY_TYPE;
	$strMoneyIcon		= $S_PRODLIST_MONEY_ICON;
	$strShow1			= $S_PRODLIST_SHOW_1;
	$strShow2			= $S_PRODLIST_SHOW_2;
	$strShow3			= $S_PRODLIST_SHOW_3;
	$strShow4			= $S_PRODLIST_SHOW_4;
	$strShow5			= $S_PRODLIST_SHOW_5;
	$strColor1			= $S_PRODLIST_COLOR_1;
	$strColor2			= $S_PRODLIST_COLOR_2;
	$strColor3			= $S_PRODLIST_COLOR_3;
	$strColor4			= $S_PRODLIST_COLOR_4;
	$strColor5			= $S_PRODLIST_COLOR_5;
	$strTitleShow		= $S_PRODLIST_TITLE_SHOW_USE;
	$strTitleFile		= $S_PRODLIST_TITLE_FILE_NAME;
	$strNaviUse			= $S_PRODUCT_NAVI_USE_OP;

	/* 통화 */
	$strMoneyIconL		= "";
	$strMoneyIconR		= "";
	 $strMoney				= "won";
	if($strMoney == "sign" || $strMoney == "won"){ 
		if ($S_SITE_LNG != "KR" && $S_SITE_LNG != "JP"){
			$strMoneyIconL = $S_SITE_CUR_MARK2." ";
		} else {
			if ($S_SITE_LNG == "JP") $strMoneyIconR = $S_SITE_CUR_MARK1;
			else $strMoneyIconR = $S_SITE_CUR_MARK2;
		}
	} 
	else if($strMoney =="icon")	{ $strMoneyIconL = sprintf(" <img src='/himg/icon/%s'>", $strMoneyIcon); } 
	else						{ $strMoneyIcon = ""; }

	/* 타이틀 */
	$strTitleCode		= "";
	if($strTitleShow == "style") { $strTitleCode = $strTitle; }
	else if($strTitleShow == "image") { $strTitleCode = sprintf("<img src='%s'/>", $strTitleFile); }

	/* 정보 세팅 */
	$productMgr->setSearchHCode1($strSearchHCode1);
	$productMgr->setSearchHCode2($strSearchHCode2);
	$productMgr->setSearchHCode3($strSearchHCode3);
	$productMgr->setSearchHCode4($strSearchHCode4);

	$productMgr->setSearchField($strSearchField);
	$productMgr->setSearchKey($strSearchKey);

	$productMgr->setSearchMobileView("Y");	
	$productMgr->setSearchWebView("");
	$productMgr->setSearchPriceView("Y");
	$productMgr->setSearchSort($strSearchSort);
	$productMgr->setSearchIcon1($strSearchIcon1);
	$productMgr->setSearchIcon2($strSearchIcon2);
	$productMgr->setSearchIcon3($strSearchIcon3);
	$productMgr->setSearchIcon4($strSearchIcon4);
	$productMgr->setSearchIcon5($strSearchIcon5);
	$productMgr->setSearchIcon6($strSearchIcon6);
	$productMgr->setSearchIcon7($strSearchIcon7);
	$productMgr->setSearchIcon8($strSearchIcon8);
	$productMgr->setSearchIcon9($strSearchIcon9);
	$productMgr->setSearchIcon10($strSearchIcon10);

	$productMgr->setP_MOB_VIEW('Y');

	/* 데이터 리스트 */
	$intTotal	= $productMgr->getProdTotal($db);

	$intPageLine							= $intWList * $intHList;															// 리스트 개수 
	$intPage								= ( $intPage )				? $intPage		: 1;
	$intFirst								= ( $intTotal == 0 )		? 1				: $intPageLine * ( $intPage - 1 );
	$productMgr->setLimitFirst( $intFirst );
	$productMgr->setPageLine( $intPageLine );

	//$productMgr->setMOBILE_IMG_VIEW('Y');
	$result = $productMgr->getProdList($db);
//	echo $db->query;
	
	$intPageBlock					= 5;															// 블럭 개수 
	$intListNum						= $intTotal - ( $intPageLine * ( $intPage - 1 ) );				// 번호
	$intTotPage						= ceil( $intTotal / $intPageLine );
	/* 데이터 리스트 */
	
	// 스킨
	if($intTotal == 0) :
		echo "<div class=\"noListWrap\">";
		echo  $LNG_TRANS_CHAR["PS00001"] ;	// 등록된 상품이 없습니다.
		echo "</div>";
	else :
		//include "prodList." . $S_PRODLIST_DESIGN . ".skin.html.php";

//모바일 합계 자바스크립트로 처리. 남덕희
?>
<script>
	$('#PRODUCT_LOCATION_1').append('(<?=$intTotal?>)');
</script>
<form name="form" method="post" id="form">
	<input type="hidden" name="menuType" value="product">
	<input type="hidden" name="mode" value="list">
	<input type="hidden" name="act" value="list">
	<input type="hidden" name="page" value="">
	<input type="hidden" name="searchField" value="">
	<input type="hidden" name="searchKey" value="">
	<input type="hidden" name="lcate" value="001">
	<input type="hidden" name="mcate" value="">
	<input type="hidden" name="scate" value="">
	<input type="hidden" name="fcate" value="">
	<input type="hidden" name="sort" value="">
	<input type="hidden" name="prodCode" value="">
	<input type="hidden" name="searchIcon6" value="">
	<input type="hidden" name="searchIcon7" value="">
	<input type="hidden" name="searchIcon8" value="">
	<input type="hidden" name="searchIcon9" value="">
	<input type="hidden" name="searchColor" id="searchColor" value="">
	<input type="hidden" name="searchSize" id="searchSize" value="">
	<input type="hidden" name="pr_no" id="pr_no" value="">

	<input type="hidden" name="searchStartPrice" id="searchStartPrice" value="">
	<input type="hidden" name="searchEndPrice" id="searchEndPrice" value="">
<div class="prodMobileList">
	<ul>
		<? for($i=0,$k=0;$i<$intHList;$i++): ?>

			<? for($j=0;$j<$intWList;$j++):	?>
				<? $row = mysql_fetch_array($result); $k++;
				   if($row): 
						## 기본 설정
						$intP_QTY				= $row['P_QTY']; // 수량
						$strP_STOCK_OUT			= $row['P_STOCK_OUT']; // 품절여부
						$strP_RESTOCK			= $row['P_RESTOCK']; // 재입고여부
						$strP_STOCK_LIMIT		= $row['P_STOCK_LIMIT']; // 무제한상품
						$strPM_REAL_NAME		= $row['PM_REAL_NAME']; // 이미지1	(기본이미지)	
						$strPM_REAL_NAME2		= $row['PM_REAL_NAME2']; // 이미지2 (마우스 오버시 이미지)	
						$intP_SALE_PRICE		= $row['P_SALE_PRICE']; // 판매가격
						$intP_CONSUMER_PRICE	= $row['P_CONSUMER_PRICE']; // 소비자 가격
						$strP_QTY				= "";
						$strOverImage			= "";
						$strP_CATE				= $row['P_CATE']; // 이미지1	(기본이미지)	
						$strP_MAX_QTY			= $row['P_MAX_QTY'];
						$strP_OPT				= $row['P_OPT'];
						$strP_MIN_QTY			= $row['P_MIN_QTY'];
						$strP_CODE				= $row['P_CODE'];

						/* 입점사 상품일때 입점사 배송정보로 보여준다 */
						if ($row['P_SHOP_NO'] > 0){
							$productMgr->setP_SHOP_NO($row['P_SHOP_NO']);
							$rowShopInfo = $productMgr->getShopView($db);
						}

						$strSH_COM_CREDIT_GRADE_IMG	= $aryCreditGradeImg[$row['SH_COM_CREDIT_GRADE']];
						$strSH_COM_SALE_GRADE_IMG	= $arySaleGradeImg[$row['SH_COM_SALE_GRADE']];
						$strSH_COM_LOCUS_GRADE_IMG	= $aryLocusGradeImg[$row['SH_COM_LOCUS_GRADE']];

						## 소비자 가격 설정
						$strP_CONSUMER_PRICE = "";
						if($strShow4 == "Y" && $intP_SALE_PRICE != $intP_CONSUMER_PRICE):
							$strP_CONSUMER_PRICE = getCurToPrice($intP_CONSUMER_PRICE);
							$strP_CONSUMER_PRICE = $strMoneyIconL . $strP_CONSUMER_PRICE . $strMoneyIconR;
						endif;
						
						$strLCate = substr($strP_CATE,0,3);
						$cateMgr->setC_CODE($strLCate);
						$strCateName = $cateMgr->getCateLevelName($db);

						## 품절 여부 체크
						## 무제한 상품이 아니면서, 품절체크가 되었거나 상품 개수가 0일때 sold out
						$isSoldOut = false;
//						if($strP_STOCK_OUT == "Y" || ($intP_QTY <= 0 && $strP_STOCK_LIMIT == "Y")) { $isSoldOut = true; } 2014.07.28 kim hee sung 잘못된 공식
						if($strP_STOCK_LIMIT != "Y" && ($intP_QTY <= 0 || $strP_STOCK_OUT == "Y")) { $isSoldOut = true; }

						/* 상품 옵션 */
						$productMgr->setP_CODE($strP_CODE);
						$productMgr->setPO_TYPE("O");
						$aryProdOpt = $productMgr->getProdOpt($db);

						if (is_array($aryProdOpt)){
							for($i=0;$i<sizeof($aryProdOpt);$i++){
								if ($aryProdOpt[$i][PO_NO] > 0){
									$productMgr->setPO_NO($aryProdOpt[$i][PO_NO]);

									/* 다중가격사용안함.다중가격분리형 */
									$aryProdOpt[$i]["OPT_ATTR1"] = $productMgr->getProdOptAttrGroup($db);

									/* 다중각격분리형 */
									$aryProdOpt[$i]["OPT_ATTR_ALL"] = $productMgr->getProdOptAttr($db);
								}
							}
						}

											
						if ($strP_OPT == "1" || $strP_OPT == "3"){
							/* 다중가격사용안함 */

							if (is_array($aryProdOpt)){
								for($i=0;$i<sizeof($aryProdOpt);$i++){
									$intProdOptAttrCnt = sizeof($aryProdOpt[$i][OPT_ATTR]);
									for($kk=1;$kk<=10;$kk++){
										if ($aryProdOpt[$i]["PO_NAME".$kk]){
											if ($aryProdOpt[$i]["OPT_ATTR".$kk]){
												## 품절표시
												$strProdOptAttrSoldOut = ($prodRow['P_STOCK_LIMIT'] != "Y") ? "(".$LNG_TRANS_CHAR["PW00053"].":".$aryProdOpt[$i]['OPT_ATTR_ALL'][0]['POA_STOCK_QTY'].")" : "";
												if (($prodRow['P_STOCK_OUT'] == "Y") || ($aryProdOpt[$i]['OPT_ATTR_ALL'][0]['POA_STOCK_QTY'] == 0 && ($prodRow['P_STOCK_LIMIT'] != "Y"))) $strProdOptAttrSoldOut = "(".$LNG_TRANS_CHAR["PW00052"].")";
											} //->if

											$strPO_NO = 'cartOpt'.$kk.'_'.$aryProdOpt[$i][PO_NO];
											$strPOA_ATTR1 = $aryProdOpt[$i]["OPT_ATTR".$kk][0][POA_ATTR1];
											$strSort = $kk;
										} //->if
									} //->for
								} //->for

								$strProdOpt = "<span class=\"w_20\">";
								$strProdOpt .= $aryProdOpt[0]["PO_NAME1"];
								$strProdOpt .= "</span>";
								//echo sizeof($aryProdOpt[0]["OPT_ATTR1"]);
								for($i=0;$i < sizeof($aryProdOpt[0]["OPT_ATTR1"]);$i++){
									$strProdOpt .= $aryProdOpt[0]["OPT_ATTR1"][$i][POA_ATTR1]." "; //리스트 옵션 표시
								} //->for

							} //->if

						} else if ($strP_OPT == "2") {
							/* 다중가격일체형 */

							if (is_array($aryProdOpt)){

								for($i=0;$i<sizeof($aryProdOpt);$i++){
									if (is_array($aryProdOpt[$i][OPT_ATTR_ALL])){

										$strProdOptAttr = "";
										for($kk=1;$kk<=10;$kk++){
											if ($aryProdOpt[$i]["PO_NAME".$kk]){
												$strProdOptAttr .= "/".$aryProdOpt[$i][OPT_ATTR_ALL][0]["POA_ATTR".$kk];
											}
										}

										$strProdOptAttr = SUBSTR($strProdOptAttr,1);

										## 품절표시
										$strProdOptAttrSoldOut = ($prodRow['P_STOCK_LIMIT'] != "Y") ? "(".$LNG_TRANS_CHAR["PW00053"].":".$aryProdOpt[$i]['OPT_ATTR_ALL'][0]['POA_STOCK_QTY'].")" : "";
										if (($prodRow['P_STOCK_OUT'] == "Y") || ($aryProdOpt[$i]['OPT_ATTR_ALL'][0]['POA_STOCK_QTY'] == 0 && ($prodRow['P_STOCK_LIMIT'] != "Y"))) $strProdOptAttrSoldOut = "(".$LNG_TRANS_CHAR["PW00052"].")";

										$strPO_NO = 'cartOpt1_'.$aryProdOpt[$i][PO_NO];
										$strPOA_ATTR1 = $aryProdOpt[$i][OPT_ATTR_ALL][0][POA_NO];
										$strSort = $kk;



										for($j=0;$j<sizeof($aryProdOpt[$i][OPT_ATTR_ALL]);$j++)
										{

											$strProdOptAttr = "";
											for($kk=1;$kk<=10;$kk++){
												if ($aryProdOpt[$i]["PO_NAME".$kk]){
													$strProdOptAttr .= "/".$aryProdOpt[$i][OPT_ATTR_ALL][$j]["POA_ATTR".$kk];
												}
											}

											$strProdOptAttr = SUBSTR($strProdOptAttr,1);

											## 품절표시
											$strProdOptAttrSoldOut = ($strP_STOCK_LIMIT != "Y") ? "(".$LNG_TRANS_CHAR["PW00053"].":".$aryProdOpt[$i]['OPT_ATTR_ALL'][$j]['POA_STOCK_QTY'].")" : "";
											if (($strP_STOCK_OUT == "Y") || ($aryProdOpt[$i]['OPT_ATTR_ALL'][$j]['POA_STOCK_QTY'] == 0 && ($strP_STOCK_LIMIT != "Y"))) $strProdOptAttrSoldOut = "(".$LNG_TRANS_CHAR["PW00052"].")";

											$strProdOpt = $strProdOptAttr.$strProdOptAttrSoldOut; //리스트 옵션 표시
										}
									}
								}
							}
						}
					
						if ($S_ARY_CUR[$S_SITE_LNG]["USD"][2] == "Y")
						{
							//<input type="hidden" name="cartOptNo[]" value="0">
							//<input type="hidden" name="0_cartOptPrice" id="0_cartOptPrice" value="
							if ($prodRow['P_EVENT'] > 0 && getProdEventInfo($row[$key]) == "Y")
							{
								$strCartOptPrice = getCurToPrice($row[$key]['P_SALE_PRICE'],"US");
							}else{
								$strCartOptPrice = getProdDiscountPrice($row[$key],"1",0,"US");
							}


							//<input type="hidden" name="0_cartOptOrgPrice" id="0_cartOptOrgPrice" value="
							if ($prodRow['P_EVENT'] > 0 && getProdEventInfo($row[$key]) == "Y")
							{
								$strCartOptOrgPrice = getCurToPrice($row[$key]['P_SALE_PRICE']);
							}else{
								$strCartOptOrgPrice = getProdDiscountPrice($row[$key]);
							}
						}
						else
						{
							if ($prodRow['P_EVENT'] > 0 && getProdEventInfo($row[$key]) == "Y")
							{
								$strCartOptPrice = getCurToPrice($row[$key]['P_SALE_PRICE']);
							}else{
								$strCartOptPrice = getProdDiscountPrice($row[$key]);
							}
							
							$strCartOptOrgPrice = '0';
						}



						/* 상품 추가 옵션*/
						if ($prodRow[P_ADD_OPT] == "Y"){
							$productMgr->setPO_TYPE("A");
							$aryProdAddOpt = $productMgr->getProdOpt($db);
							if (is_array($aryProdAddOpt)){
								for($i=0;$i<sizeof($aryProdAddOpt);$i++){
									if ($aryProdAddOpt[$i][PO_NO] > 0){
										$productMgr->setPO_NO($aryProdAddOpt[$i][PO_NO]);

										$aryProdAddOpt[$i][OPT_ATTR] = $productMgr->getProdAddOpt($db);
									}
								}
							}
						}

						## 재고 수량 표시
						$strP_QTY = "";
						if($S_IS_QTY_SHOW == "Y"):
							## 제고 수량 설정
							if($intP_QTY) { $strP_QTY = "<span>".$LNG_TRANS_CHAR["PW00080"]."</span>" . $intP_QTY; }
						endif;

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

						/* 판매가격 및 판매가격에 해당하는 포인트 */
						$intProdSalePrice = 0;
						if ($S_ARY_CUR[$S_SITE_LNG]["USD"][2] == "Y"){
							$intProdSalePrice	= getProdDiscountPrice($row,"1",0,"US");
							$intProdPoint		= getProdPoint(str_replace(",","",$intProdSalePrice), $row['P_POINT'], $row['P_POINT_TYPE'], $row['P_POINT_OFF1'], $row['P_POINT_OFF2']); // 적립금
						} else {
							$intProdSalePrice	= getProdDiscountPrice($row);
							$intProdPoint		= getProdPoint(str_replace(",","",$intProdSalePrice), $row['P_POINT'], $row['P_POINT_TYPE'], $row['P_POINT_OFF1'], $row['P_POINT_OFF2']); // 적립금
						}

						## 적립금 설정
						$intProdPoint = getProdPoint($intP_SALE_PRICE, $intP_POINT, $strP_POINT_TYPE, $strP_POINT_OFF1, $strP_POINT_OFF2);
						$intProdPointMoney = 0;
						if($intProdPoint <= 0) { $strShow3 = ""; }
						if($strShow3 == "Y") { $intProdPointMoney = getCurToPrice($intProdPoint); }

						## 소비자가격 설정
						$strTextConsumerPrice = "";
						$strTextConsumerPriceUsd = "";
						if($intP_CONSUMER_PRICE > 0):
							$strTextConsumerPrice = getCurToPrice($intP_CONSUMER_PRICE);
							$strTextConsumerPrice = "{$strMoneyIconL}{$strTextConsumerPrice}{$strMoneyIconR}";
							if($S_ARY_CUR[$S_SITE_LNG]["USD"][2] == "Y") { $strTextConsumerPriceUsd = getCurMark("USD") . getCurToPrice($intP_CONSUMER_PRICE, "US") . getCurMark2("USD"); }
						endif;

						## 상품 가격 설정
						$strTextPriceUsd = "";
						
						if($strP_PRICE_FILTER=='FOB')
						{
							$strTextPrice = getCurMark("$").getProdDiscountPrice($row[$key],"1",0,"US");
							$strTextPrice = $strMoneyIconL.$strTextPrice;
							//$strTextPrice .= '$';
						}else{
							$strTextPrice = getProdDiscountPrice($row[$key]);
							$strTextPrice = $strMoneyIconL.$strTextPrice;
							$strTextPrice .= $strMoneyIconR;
						}
						if($S_ARY_CUR[$S_SITE_LNG]["USD"][2] == "Y") { $strTextPriceUsd = getCurMark("$") . getProdDiscountPrice($row[$key],"1",0,"US") . getCurMark2("USD"); }
						if($strP_PRICE_TEXT) { $strTextPrice = $strP_PRICE_TEXT; }

						## 이미지 설정
						if(!$strPM_REAL_NAME) { $strPM_REAL_NAME = "/himg/product/A0001/no_img.gif"; }

						## 2015.02.09 kim hee sung
						## 상품가격 출력 설정
						##  관리자페이지 > 기본설정 > 주문및결제관리 > 상품가격노출 사용시 해당 그룹 회원에게만 가격 노출합니다.
						if($isPriceHide):
							$strProdDiscountRateText = '';	
							$strTextPrice = '';
							$intProdPointMoney = '';
							$strTextConsumerPrice = ''; 
							$strTextConsumerPriceUsd = '';
							
							$strShow5 = '';
							$strP_CONSUMER_PRICE = '';
						endif;
						
				?>
				<?
						if ($strP_OPT == "1" || $strP_OPT == "3"){
							/* 다중가격사용안함 */

							if (is_array($aryProdOpt)){
								for($i=0;$i<sizeof($aryProdOpt);$i++){
									$intProdOptAttrCnt = sizeof($aryProdOpt[$i][OPT_ATTR]);
									for($kk=1;$kk<=10;$kk++){
										if ($aryProdOpt[$i]["PO_NAME".$kk]){
											if ($aryProdOpt[$i]["OPT_ATTR".$kk]){
												## 품절표시
												$strProdOptAttrSoldOut = ($prodRow['P_STOCK_LIMIT'] != "Y") ? "(".$LNG_TRANS_CHAR["PW00053"].":".$aryProdOpt[$i]['OPT_ATTR_ALL'][0]['POA_STOCK_QTY'].")" : "";
												if (($prodRow['P_STOCK_OUT'] == "Y") || ($aryProdOpt[$i]['OPT_ATTR_ALL'][0]['POA_STOCK_QTY'] == 0 && ($prodRow['P_STOCK_LIMIT'] != "Y"))) $strProdOptAttrSoldOut = "(".$LNG_TRANS_CHAR["PW00052"].")";
											} //->if

											$strPO_NO = 'cartOpt'.$kk.'_'.$aryProdOpt[$i][PO_NO];
											$strPOA_ATTR1 = $aryProdOpt[$i]["OPT_ATTR".$kk][0][POA_ATTR1];
											$strSort = $kk;
										} //->if
									} //->for
								} //->for
							} //->if

						} else if ($strP_OPT == "2") {
							/* 다중가격일체형 */

							if (is_array($aryProdOpt)){

								for($i=0;$i<sizeof($aryProdOpt);$i++){
									if (is_array($aryProdOpt[$i][OPT_ATTR_ALL])){

										$strProdOptAttr = "";
										for($kk=1;$kk<=10;$kk++){
											if ($aryProdOpt[$i]["PO_NAME".$kk]){
												$strProdOptAttr .= "/".$aryProdOpt[$i][OPT_ATTR_ALL][0]["POA_ATTR".$kk];
											}
										}

										$strProdOptAttr = SUBSTR($strProdOptAttr,1);

										## 품절표시
										$strProdOptAttrSoldOut = ($prodRow['P_STOCK_LIMIT'] != "Y") ? "(".$LNG_TRANS_CHAR["PW00053"].":".$aryProdOpt[$i]['OPT_ATTR_ALL'][0]['POA_STOCK_QTY'].")" : "";
										if (($prodRow['P_STOCK_OUT'] == "Y") || ($aryProdOpt[$i]['OPT_ATTR_ALL'][0]['POA_STOCK_QTY'] == 0 && ($prodRow['P_STOCK_LIMIT'] != "Y"))) $strProdOptAttrSoldOut = "(".$LNG_TRANS_CHAR["PW00052"].")";

										$strPO_NO = 'cartOpt1_'.$aryProdOpt[$i][PO_NO];
										$strPOA_ATTR1 = $aryProdOpt[$i][OPT_ATTR_ALL][0][POA_NO];
										$strSort = $kk;
									}
								}
							}
						}
					?>
					<li>
					<!-- 상품 디자인 -->
						<div class="productInfoWrap">
							<div class="prodListImg">
								<a href="javascript:goProdView('<?=$row['P_CODE']?>');"><img src="<?php echo $strPM_REAL_NAME;?>" class="listProdImg"/></a><!--상품이미지-->
								<!-- 품절 //-->
								<?php if($isSoldOut):?>
									<!--div class="soldout">Sold Out</div-->
									<div class="soldoutImg"><img src="/upload/images/img_soldout.png" /></div>
								<?php endif;?>
								<!-- 품절 //-->
								<div class="icoWrap">
									<!--<a href="javascript:goListWish('<?php echo $strP_CODE;?>','<?php echo $strP_STOCK_OUT;?>','<?php echo $intP_QTY;?>','<?php echo $strP_STOCK_LIMIT;?>','<?php echo $strCartOptPrice;?>','<?php echo $strCartOptOrgPrice;?>','<?php echo $strP_MIN_QTY;?>','<?=$strPO_NO?>',<?=$strSort?>,'<?=$strPOA_ATTR1?>','<?=$strP_OPT?>','<?=$strP_MAX_QTY?>');" alt="담아두기" title="담아두기" class="btnProdWish"><img src="/upload/images/ico_list_star1.png" alt="담아두기" title="담아두기"> <span class="ico_wish"><?= $LNG_TRANS_CHAR["PW00084"]; //담아두기 ?></span></a>-->
									<!--<img src="/upload/images/ico_list_chk1.png" alt="비교하기" title="비교하기"> <span class="ico_chk">비교하기</span>-->
								</div>
							</div>
							<?if ($row['P_EVENT'] > 0 && getProdEventInfo($row) == "Y"){?>
								<?if ($S_EVENT_INFO[$row['P_EVENT']]["PRICE_TYPE"] == "1"){?>
								<div class="sailInfo">
									<?=$S_EVENT_INFO[$row['P_EVENT']]["PRICE_MARK"]?><span>%</span>								
								</div>
								<?}?>
							<?}?>
							<div class="prodInfoSum" onclick="goProdView('<?=$row['P_CODE']?>');">
								<dl>
									<? if($row['P_COLOR_IMG']) : ?><dd class="color">
									<? foreach($row['P_COLOR_IMG'] as $url):?>
									<span><img src="<?=$url?>"/></span>
									<? endforeach;?>
									</dd><?endif;?>
									<!--색상-->
									<? if($strShow8 == "Y") : ?><dd class="brandTit"><span><?=$row['P_BRAND_NAME']?></span></dd><?endif;?><!--브렌드-->								
									<? if($strShow1 == "Y") : ?><dd class="title"><a href="javascript:goProdView('<?=$row['P_CODE']?>');"><span><?=strHanCutUtf2($row[P_NAME], $intTitleMaxsize, "N")?></span></a></dd><?endif;?><!--상품명-->
									<dd class="prodInfo">
										<ul class="info">
											<li><span class="tit"><?= $LNG_TRANS_CHAR["PW00028"]; //원산지 ?></span><strong><?=$aryCountryList[$row['P_ORIGIN']]?></strong><span class="bar">|</span></li>
											<li><span class="tit"><?= $LNG_TRANS_CHAR["CW00064"]; //카테고리 ?></span><strong><?=$strCateName?></strong></li>
										</ul>										
									</dd>
									<dd class="shopInfo">
										<ul class="info">
											<li class="infoName"><?=$rowShopInfo['SH_COM_NAME']?><span class="bar">|</span></li>
											<li><?=$aryCountryList[$rowShopInfo['SH_COM_COUNTRY']]?></li>
											<li class="shopIcoWrap">
												<img src="<?=$strSH_COM_CREDIT_GRADE_IMG;?>">
												<img src="<?=$strSH_COM_SALE_GRADE_IMG;?>">
												<img src="<?=$strSH_COM_LOCUS_GRADE_IMG;?>">
											</li>
										</ul>												
									</dd>
									
									<? if($strShow7 == "Y") : ?><dd class="model"><span><?=$row['P_MODEL']?></span></dd><?endif;?><!--모델명-->
									<? if($strShow2 == "Y") : ?><dd class="comment"><span><?=$row['P_ETC']?></span></dd><?endif;?><!--상품설명-->
									<? if($intProdPoint>0 && $strShow3 == "Y") : ?>
										<?if($strProdPointViewSpecGroupYN == "Y"){?>
										<dd class="pricePoint"><span><?=getCurToPrice($intProdPoint)?></span></dd><?}?>
									<?endif;?><!--적립금-->
									<? if($strP_CONSUMER_PRICE): // 소비자가격?>
										<dd class="priceConsumer"><s><span><?php echo $strP_CONSUMER_PRICE;?></span></s></dd>
									<?endif;?>
									<? if($strShow5 == "Y") : ?>
										<dd class="priceSale">
											<span>
											<?if($row['P_PRICE_TEXT']): // 가격대체문구 ?>
												<?=$row['P_PRICE_TEXT']?>
											<?else:?>		
												<?if ($S_ARY_CUR[$S_SITE_LNG]["USD"][2] == "Y"){?> 
												<?=getCurMark("USD")?> <?=$intProdSalePrice?><?=getCurMark2("USD")?>
												(<?=$S_SITE_CUR_MARK1?><?=getProdDiscountPrice($row)?>)
												<?}else{?>
												<?=$strMoneyIconL?> <?=$intProdSalePrice?><?=$strMoneyIconR?>
												<?}?>
											<?endif;?>
											</span>
										</dd>
									<?endif;?><!--판매가격-->
									<? if($row['P_LIST_ICON']):
											$icon		= explode("/", $row['P_LIST_ICON']);
											$iconTag	= "";
											for($x=0;$x<sizeof($icon);$x++):
												$iconTag .= $S_ARY_PRODUCT_LIST_ICON[$icon[$x]];
											endfor; 
											if($iconTag) { echo "<dd class=\"prodIcon\">{$iconTag}</dd>"; }
									   endif;
									?>
									<div class="clr"></div>
								</dl>
							</div>
							<div class="clr"></div>
						</div>
					<!-- 상품 디자인 -->
					</li>
				<? endif; ?>
			<? endfor;	?>

		<? if($intListNum <= $k) { break; } ?>
		<? endfor; ?>
	</ul>
	<div class="clr"></div>
</div>
</form>
<!--div class="btnMoreWrap">
	<a href="#" class="btnMore"><span>목록더보기</span></a>
</div-->

<div id="pagenate">
	<?=drawUserPaging($intPage,$intPageLine,$intPageBlock,$intTotal,$intTotPage,$linkPage,"","","","","")?>
</div>
<?
	endif;
?>