<?
	require_once MALL_CONF_LIB."CateMgr.php";
	require_once MALL_CONF_LIB."ProductMgr.php";
	require_once MALL_CONF_LIB."OrderMgr.php";
	require_once MALL_CONF_LIB."MemberMgr.php";
	require_once MALL_CONF_LIB."SiteMgr.php";

	require_once $S_DOCUMENT_ROOT.$S_SHOP_HOME."/conf/site_skin_product.conf.inc.php";
	require_once $S_DOCUMENT_ROOT.$S_SHOP_HOME."/conf/product.inc.php";
	require_once $S_DOCUMENT_ROOT.$S_SHOP_HOME."/conf/order.inc.php";

	/*상품함수관련*/
	require_once MALL_PROD_FUNC;

	$cateMgr		= new CateMgr();		
	$productMgr		= new ProductMgr();
	$orderMgr		= new OrderMgr();
	$memberMgr		= new MemberMgr();
	$siteMgr		= new SiteMgr();	

	$strSearchField = $_POST["searchField"]		? $_POST["searchField"]		: $_REQUEST["searchField"];
	$strSearchKey	= $_POST["searchKey"]		? $_POST["searchKey"]		: $_REQUEST["searchKey"];
	$intPage		= $_POST["page"]			? $_POST["page"]			: $_REQUEST["page"];
	$intPageLine	= $_POST["pageLine"]		? $_POST["pageLine"]		: $_REQUEST["pageLine"];
	$strP_CODE		= $_POST["prodCode"]		? $_POST["prodCode"]		: $_REQUEST["prodCode"];

	$productMgr->setP_LNG($S_SITE_LNG);
	$productMgr->setP_CODE($strP_CODE);
	$prodRow = $productMgr->getProdView($db);

	/* VIEW 이미지 리스트 */
	$productMgr->setPM_TYPE("list");
	$prodImgRow = $productMgr->getProdImg($db);		

	/* 카테고리 위치 표시 */
	$strSearchHCode1 = substr($prodRow['P_CATE'], 0, 3);
	$strSearchHCode2 = substr($prodRow['P_CATE'], 3, 3);
	$strSearchHCode3 = substr($prodRow['P_CATE'], 6, 3);
	$strSearchHCode4 = substr($prodRow['P_CATE'], 9, 3);

	$cateMgr->setC_CODE($strSearchHCode1);
	$strSearchHCodeName1 = $cateMgr->getCateLevelName($db);

	$cateMgr->setC_CODE($strSearchHCode1.$strSearchHCode2);
	$strSearchHCodeName2 = $cateMgr->getCateLevelName($db);

	$cateMgr->setC_CODE($strSearchHCode1.$strSearchHCode2.$strSearchHCode3);
	$strSearchHCodeName3 = $cateMgr->getCateLevelName($db);

	$cateMgr->setC_CODE($strSearchHCode1.$strSearchHCode2.$strSearchHCode3.$strSearchHCode4);
	$strSearchHCodeName4 = $cateMgr->getCateLevelName($db);

	/* 적립금 */
	$intProdPoint = getProdPoint($prodRow[P_SALE_PRICE], $prodRow[P_POINT], $prodRow[P_POINT_TYPE], $prodRow[P_POINT_OFF1], $prodRow[P_POINT_OFF2]);
	
	/* 상품 항목 설명 */
	$aryProdItem = $productMgr->getProdItem($db);

	/* 상품 옵션 */
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

?>

<? include "./include/header.inc.php"?>

<script type="text/javascript">
<!--
	$(document).ready(function(){

	});

	/* 이벤트 등록 */


	function goClose() {
		parent.goClose();
	}


//-->
</script>

		<div class="layerPopWrap">
			<div class="popTop">
				<h2>상품리스트 디자인</h2>			
				<a  href="javascript:goClose();"><img src="/shopAdmin/himg/common/btn_pop_close.png" class="closeBtn"/></a>
				<div class="clr"></div>
			</div>

			<div class="tableForm">
				<!-- ******** 컨텐츠 ********* -->
				<!-- 상품 탑 상세정보 -->
					<div class="prodDetail mt10" >	
						<dl>
							<dd class="detailImg">
							</dd>
							<dd class="multyImg" ><!-- 다중 이미지 -->
							
							</dd>
							<dd class="2013-02-132013-02-132013-02-132013-02-13">
								<table>
									<tr>
										<th colspan="2" class="titleWrap"><?=$prodRow[P_NAME]?></th>
									</tr>
									<?if ($prodRow[P_CONSUMER_PRICE] > 0){?><tr><th>소비자가</th><td> <?=getCurMark()?> <s class="priceOrg"><?=getCurToPrice($prodRow[P_CONSUMER_PRICE])?></s></td></tr><?}?>
									<tr><th><?if($S_PRODUCT_RENT == "Y" && $prodRow[P_STOCK_PRICE] != "1" ){echo $LNG_TRANS_CHAR["PW00003"]; }else{echo $LNG_TRANS_CHAR["PW00004"];} //임대가/판매가?></th><td>
									<?if ($prodRow[P_EVENT_UNIT] && $prodRow[P_EVENT]){?><s><?}?>
										<strong class="priceOrange _fs14" id="realPayPriceText"><?=getCurMark()?> <?=getProdDiscountPrice($prodRow)?></strong>
									<?if ($prodRow[P_EVENT_UNIT] && $prodRow[P_EVENT]){?></s><?}?></td></tr>
									<?if ($prodRow[P_EVENT_UNIT] && $prodRow[P_EVENT]){?>
										<tr><th><?=$LNG_TRANS_CHAR["PW00005"] //특별할인가?></th><td> <?=getCurMark()?> <strong class="priceOrange _fs14" id="realPayPriceTaxText"><?=getCurToPrice(getProdEventPrice($prodRow[P_SALE_PRICE],$prodRow[P_EVENT_UNIT],$prodRow[P_EVENT]))?></strong> <?=$LNG_TRANS_CHAR["PW00007"] //(10%할인)?></></td></tr>
									<?}?>
									<?if ($intProdPoint > 0){?>
									<tr><th><?=$LNG_TRANS_CHAR["PW00006"] //마일리지?></th><td>  <?=getCurMark()?> <img src="../himg/product/A0001/<?=$S_SITE_LNG_PATH?>/icon_point_green.gif" style="vertical-align:middle;"/> <?=getCurToPrice($intProdPoint)?> <?=$LNG_TRANS_CHAR["PW00008"] //포인트?></td></tr>	<?}?>				
									
									<?
									if ($prodRow[P_OPT] == "1" || $prodRow[P_OPT] == "3"){
										/* 다중가격사용안함 */

										if (is_array($aryProdOpt)){
											for($i=0;$i<sizeof($aryProdOpt);$i++){
												$intProdOptAttrCnt = sizeof($aryProdOpt[$i][OPT_ATTR]);
												for($kk=1;$kk<=10;$kk++){
													if ($aryProdOpt[$i]["PO_NAME".$kk]){
												?>
													<tr>
														<th><?=$aryProdOpt[$i]["PO_NAME".$kk]?></th>
														<td>
														<select id="cartOpt<?=$kk?>_<?=$aryProdOpt[$i][PO_NO]?>" name="cartOpt<?=$kk?>_<?=$aryProdOpt[$i][PO_NO]?>"  onchange="javascript:goSelectProdOpt('cartOpt<?=$kk?>_<?=$aryProdOpt[$i][PO_NO]?>',<?=$kk?>);">
															<option value="">:: <?=($aryProdOpt[$i][PO_ESS]=="Y")?$LNG_TRANS_CHAR["PW00008"]:$LNG_TRANS_CHAR["PW00009"]; //필수선택:선택?> ::</option>
															<?
																if ($aryProdOpt[$i]["OPT_ATTR".$kk]){
																	for($j=0;$j<sizeof($aryProdOpt[$i]["OPT_ATTR".$kk]);$j++){
															?>
															<option value="<?=$aryProdOpt[$i]["OPT_ATTR".$kk][$j][POA_ATTR1]?>"><?=$aryProdOpt[$i]["OPT_ATTR".$kk][$j][POA_ATTR1]?></option>
															<?
																	} //->for
																} //->if
															?>
														</select>
														</td>
													</tr>
												<?
													} //->if
												} //->for
											} //->for
										} //->if

									} else if ($prodRow[P_OPT] == "2") {
										/* 다중가격일체형 */
										
										if (is_array($aryProdOpt)){

											for($i=0;$i<sizeof($aryProdOpt);$i++){
												?>
													<tr>
														<th><?=$LNG_TRANS_CHAR["PW00010"] //옵션선택?></th>
														<td>
														<select id="cartOpt1_<?=$aryProdOpt[$i][PO_NO]?>" name="cartOpt1_<?=$aryProdOpt[$i][PO_NO]?>" onchange="javascript:goSelectProdOpt('cartOpt1_<?=$aryProdOpt[$i][PO_NO]?>');">
															<option value="">:: <?=($aryProdOpt[$i][PO_ESS]=="Y")?$LNG_TRANS_CHAR["PW00008"]:$LNG_TRANS_CHAR["PW00009"]; //필수선택:선택?> ::</option>
															<?
																if (is_array($aryProdOpt[$i][OPT_ATTR_ALL])){
																	for($j=0;$j<sizeof($aryProdOpt[$i][OPT_ATTR_ALL]);$j++){
																		
																		$strProdOptAttr = "";
																		for($kk=1;$kk<=10;$kk++){
																			if ($aryProdOpt[$i]["PO_NAME".$kk]){
																				$strProdOptAttr .= "/".$aryProdOpt[$i][OPT_ATTR_ALL][$j]["POA_ATTR".$kk];
																			} 
																		}

																		$strProdOptAttr = SUBSTR($strProdOptAttr,1);
															?>
															<option value="<?=$aryProdOpt[$i][OPT_ATTR_ALL][$j][POA_NO]?>"><?=$strProdOptAttr?></option>
															<?		}
																}
															?>
														</select>
														</td>
													</tr>
												<?
											}

										}
									}
							
									/* 추가옵션관리 */
									if ($prodRow[P_ADD_OPT] == "Y" && is_array($aryProdAddOpt)){
										for($i=0;$i<sizeof($aryProdAddOpt);$i++){
											?>
												<tr>
													<th><?=$aryProdAddOpt[$i][PO_NAME1]?></th><td>
													<select id="cartAddOpt_<?=$aryProdAddOpt[$i][PO_NO]?>" name="cartAddOpt_<?=$aryProdAddOpt[$i][PO_NO]?>"  >
														<option value="">:: <?=($aryProdAddOpt[$i][PO_ESS]=="Y")?$LNG_TRANS_CHAR["PW00008"]:$LNG_TRANS_CHAR["PW00009"];?> ::</option>
														<?for($j=0;$j<sizeof($aryProdAddOpt[$i][OPT_ATTR]);$j++){?>
														<option value="<?=$aryProdAddOpt[$i][OPT_ATTR][$j][PAO_NO]?>"><?=$aryProdAddOpt[$i][OPT_ATTR][$j][PAO_NAME]?></option>
														<?}?>
													</select>
												</td></tr>
											<?
										}
									}

									if (($S_SITE_LNG == "KR" && ($S_DELIVERY_MTH == "N" || !$S_DELIVERY_MTH)) || ($S_SITE_LNG != "KR" && $S_DELIVERY_FOR_MTH != "W")){
										
										if ($prodRow[P_BAESONG_TYPE] == "1"){
											if ($SHOP_ARY_DELIVERY["SHOP_DELIVERY_ST_PRICE"] > 0){
												if (($prodRow[P_SALE_PRICE] > $SHOP_ARY_DELIVERY["SHOP_DELIVERY_ST_PRICE"])){
									?>
									<tr>
										<th><?=$LNG_TRANS_CHAR["PW00012"] //배송비?></th>
										<td><?=$LNG_TRANS_CHAR["PW00013"] //무료?></td>
									</tr>
									<?	
												} else {

									?>
	
									<!--<tr>
										<th>예외지역배송</th>
										<td><input type="checkbox" id="cartDeliveryExp" name="cartDeliveryExp" value="Y"></td>
										(* 예외지역 배송일 경우 체크)
									</tr>//-->
									<?		}}} else if ($prodRow[P_BAESONG_TYPE] == "2"){
										if ($S_SITE_LNG == "KR" && $S_DELIVERY_MTH != "G"){		?>
									<tr>
										<th><?=$LNG_TRANS_CHAR["PW00012"] //배송비?></th><td> <?=$LNG_TRANS_CHAR["PW00016"] //무료배송?></td>
									</tr>
									<?		}} else if ($prodRow[P_BAESONG_TYPE] == "3"){?>
									<tr>
										<th><?=$LNG_TRANS_CHAR["PW00012"] //배송비?></th>
										<td><?=$LNG_TRANS_CHAR["PW00017"] //고정 배송비?> <?=getCurToPrice($prodRow[P_BAESONG_PRICE])?></td>
									</tr>
									<?		} else if ($prodRow[P_BAESONG_TYPE] == "4"){?>
									<tr>
										<th><?=$LNG_TRANS_CHAR["PW00012"] //배송비?></th>
										<td><?=$LNG_TRANS_CHAR["PW00018"] //수량별 배송?> <?=getCurToPrice($prodRow[P_BAESONG_PRICE])?></td>
									</tr>
									<?		} else if ($prodRow[P_BAESONG_TYPE] == "5"){?>
									<tr>
										<th><?=$LNG_TRANS_CHAR["PW00012"] //배송비?></th> <td><?=callLangTrans($LNG_TRANS_CHAR["PS00006"],array($S_SITE_CUR,getCurToPrice($prodRow[P_BAESONG_PRICE]))); //상품 수령 후 {{단어1}} {{단어2}} 지불?></td>
									</tr>
									<?		}
									} else {
									?>
									<tr>
										<th><?=$LNG_TRANS_CHAR["PW00012"] //배송비?></th>
										<td>배송비 설명 페이지 링크</td> 
									</tr>
									<?}?>
									<!-- 상품 항목 설명 -->
									<?
										if (is_array($aryProdItem)){
											
											for($i=0;$i<sizeof($aryProdItem);$i++){
											?>
									<tr>
										<th><?=$aryProdItem[$i][PI_NAME]?></th>
										<td><?=$aryProdItem[$i][PI_TEXT]?></td>
									</tr>
											<?
											}
										}
									?>
									<!-- 상품 항목 설명 -->
									<tr>
										<th class="prodCntSelect"><?=$LNG_TRANS_CHAR["PW00019"] //구매수량?></th>
										<td class="prodCntSelect"> 
											<div class="cntInputWrap">
											<input type="input" id="cartQty" name="cartQty" value="<?=$prodRow[P_MIN_QTY]?>" style="width:30px;padding:2px;border:1px solid #bebebe;"/> <?=$LNG_TRANS_CHAR["PW00020"] //개?> 
											</div>
										<strong class="btnCntUpDown">
											<a href="javascript:goProdViewQtyChange('up',<?=$prodRow[P_MIN_QTY]?>);"><img src="../himg/product/A0001/<?=$S_SITE_LNG_PATH?>/btn_prod_cnt_up.gif"/></a>
											<a href="javascript:goProdViewQtyChange('down',<?=$prodRow[P_MIN_QTY]?>);"><img src="../himg/product/A0001/<?=$S_SITE_LNG_PATH?>/btn_prod_cnt_down.gif"/></a>
										</strong>
										<div class="clr"></div>
										</td>
									</tr>
								</table>
		
							</dl>
						</dl>
					</div>
					<!-- 상품 탑 상세정보 -->
				<!-- ******** 컨텐츠 ********* -->
			</div>
		</div>
	</body>
</html>