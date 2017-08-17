<?php

	## 모듈 설정
	$objProductImgModule = new ProductImgModule($db);

	## 스크립트 설정
	$aryScriptEx[]		= "/common/bxslider-4-master/jquery.bxslider.js";
	$aryScriptEx[]		= "/common/js/product/mobile.productView.js";
	$aryScriptEx[]		= "/common/js/sns.js";
	$aryScriptEx[]		= "/common/js/kakao.link.js";

	## 기본 설정
	//$strPCode				= $_GET['prodCode'];//???

	$aryViewImageList	= array('view', "view1", "view2", "view3", "view4", "view5", "view6", "view7", "view8", "view9");

	## 상품이미지 리스트
	$param = "";
	$param['P_CODE'] = $strP_CODE;
	$aryProductImgList = $objProductImgModule->getProductImgSelectEx("OP_ARYTOTAL", $param);
	$intProductImgTotal = sizeof($aryProductImgList);

	## 통화
	$strMoney			= $S_PRODLIST_MONEY_TYPE;
	$strMoneyIcon		= $S_PRODLIST_MONEY_ICON;
	$strMoneyIconL		= "";
	$strMoneyIconR		= "";
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

	## 포인트
	$strProdPoint = "";
	if($intP_POINT):
		$intProdPoint = ($intP_POINT/100) * $intP_SALE_PRICE;
		$strProdPoint = getCurToPrice($intProdPoint);
		$strProdPoint = "{$strProdPoint} {$LNG_TRANS_CHAR['PW00008']}"; // 포인트
	endif;


	## sns 설정
	$strSnsUse			= $S_PRODUCT_VIEW_SNS_USE;
	if($strSnsUse == "Y") :
		$strSnsLink				= sprintf("%s/%s/?menuType=product&mode=view&prodCode=%s", $S_SITE_URL, $S_SITE_LNG_PATH, $strP_CODE);
		$strSnsName				= $prodRow['P_NAME'];
		if($prodImgRow):
			$strSnsImg			= sprintf("%s", $prodImgRow[0]['PM_REAL_NAME']);
			if(substr($strSnsImg,0,4) != "http") { $strSnsImg = "{$S_SITE_URL}{$strSnsImg}"; }
		endif;
		$arySns['facebook']		= $S_PRODUCT_VIEW_SNS_FACEBOOK;
		$arySns['twitter']		= $S_PRODUCT_VIEW_SNS_TWITTER;
		$arySns['m2day']		= $S_PRODUCT_VIEW_SNS_M2DAY;
	endif;

?>
<?
if(!$g_member_no)
{
	$loginCheck = "javascript:loginCheck();";
}
else
{
	$loginCheck = "javascript:popProdInquiry({$strP_CODE});";
}
?>
<?php if($strSnsUse == "Y" && $S_PRODUCT_VIEW_SNS_FACEBOOK == "Y"){?>
<?php// $aryScriptEx[] = "http://connect.facebook.net/en_US/all.js"; ?>

<script>
	//FB.init({appId: "<?php echo $S_SITE_FACEBOOK_APP_ID;?>", status: true, cookie: true});

	$( document ).ready(function() {

		<? if($strViewList){?>
		C_getTabChange('tab','2');
		C_getTabChange('comProd','2');
		<?
		}
		else
		{?>
			<?
			if($strComView){
			?>
			//C_getTabChange('tab','2');
			C_getTabChange('comProd','1');
			<?
			}else{
			?>
			//goTabChange('tab','1');
			//goTabChange('prodDetail','1');
			C_getTabChange('tab','1');
			C_getTabChange('prodDetail','1');
			<?
			}
			?>
		<?
		}
		?>

	});
	<!--
	function loginCheck(pCode){
		alert('로그인후 이용가능합니다.');
		location.href="./?menuType=member&mode=login";
	}
	//-->
</script>

<style>
/** 장바구니/관심상품 팝업 **/
div.divPopupAlertWrap {
						position:absolute; width:100%; height:100%; top:0 ; left:0 ; margin:0 ; padding:0 ; background-color:#eee; text-align:center; background: rgba(0, 0, 0, 0.5) !important;
						/*
						IE8이하는 rgba가 동작하지 않기 때문에 배경 투명도 적용을 위해 filter의 gradient을 대체 이용한다.
						컬러값 60000000의 8자리 숫자의 의미: 앞 60 불투명도, 나머지 6자리 컬러값.
						startColorstr와 endColorstr의 색을 같게 하여 배경 투명도 처리를 하는것.
						하지만 원래는 그라데이션 처리하는 기법이기 때문에 같은 60% 투명도라고 해도 약간의 차이는 있다.
						*/
						 filter:progid:DXImageTransform.Microsoft.gradient(startColorstr=#60000000,endColorstr=#60000000);
						zoom: 1; /* 일반적이진 않지만 ie6, 7 에서 적용 안되는경우 선언. */
		}
</style>
<?php }?>

<div class="tabBtnWrap">
	<!--<a class="btn1 on" href="javascript:void(0);" onclick="C_getTabChange('tab','1')" id="btn-tab1"><?=$LNG_TRANS_CHAR["PW00088"] //제품정보 ?></a>
	<a class="btn2" href="javascript:void(0);" onclick="C_getTabChange('tab','2')" id="btn-tab2"><?=$LNG_TRANS_CHAR["PW00089"] //회사소개 ?></a>-->
	<a class="btn1 <?=(!$strComView) ? 'on' : '' ;?>" href="/?menuType=product&mode=view&prodCode=<?=$strP_CODE?>" ><?=$LNG_TRANS_CHAR["PW00088"] //제품정보 ?></a>
	<a class="btn2 <?=($strComView) ? 'on' : '' ;?>" href="/?menuType=product&mode=view&comView=Y&prodCode=<?=$strP_CODE?>" ><?=$LNG_TRANS_CHAR["PW00089"] //회사소개 ?></a>
</div>

<div class="mainProdView" id="tab1" <?=($strComView) ? 'style="display:none"' : '' ;?>>
	<div class="prodDetailView" >
		<!-- 슬라이더 이미지 //-->
		<div class="multyImageSelect">
			<ul class="product-slider">
				<?php foreach($aryProductImgList as $key => $data){

						## 기본 설정
						$strPM_TYPE = $data['PM_TYPE'];
						$strPM_REAL_NAME = $data['PM_REAL_NAME'];

						## 체크
						if(!in_array($strPM_TYPE, $aryViewImageList)) { continue; }
				?>
				<li><img src="<?=$strPM_REAL_NAME?>"></li>
				<?php }?>
			</ul>
		</div>
		<!-- 슬라이더 이미지 //-->

		<!-- 상세설명 영역 -->
		<div class="detailInfo">
			<div class="tableWrap">
				<table class="infoTable shopIcoTable">
					<tr>
						<th><?= $LNG_TRANS_CHAR["PW00082"]; //업체명 ?></th>
						<td><?php echo $strSH_COM_NAME;?></td>
					</tr>
					<tr>
						<th><?= $LNG_TRANS_CHAR["PW00083"]; //등급 ?></th>
						<td>
							<img src="<?=$strSH_COM_CREDIT_GRADE_IMG;?>">
							<img src="<?=$strSH_COM_SALE_GRADE_IMG?>">
							<img src="<?=$strSH_COM_LOCUS_GRADE_IMG?>">
						</td>
					</tr>
				</table>
			</div>
			<div class="tableWrap">
				<table class="infoTable">
					<?php if($strP_ORIGIN):?>
					<tr>
						<th><?=$LNG_TRANS_CHAR["PW00028"] //원산지?></th>
						<td><?php echo $aryCountryList[$strP_ORIGIN];?></td>
					</tr>
					<?php endif;?>
					<tr>
						<th><?= $LNG_TRANS_CHAR["CW00064"]; //카테고리 ?></th>
						<td><?php echo $strSearchHCodeName1;?></td>
					</tr>
					<?if($strP_MIN_QTY){?>
					<tr>
						<th><?= $LNG_TRANS_CHAR["PW00090"]; //최소구매수량 ?></th>
						<td><?php echo $strP_MIN_QTY;?> <?=$strP_SAIL_UNIT?></td>
					</tr>
					<?}?>
					<?if($strP_CAS_NO){?>
					<tr>
						<th>CAS No</th>
						<td><?php echo $strP_CAS_NO;?></td>
					</tr>
					<?}?>
					<?if($strP_OTHER_NAMES){?>
					<tr>
						<th>Other<br/>Names</th>
						<td><?php echo $strP_OTHER_NAMES;?></td>
					</tr>
					<?}?>
					<?php if(!$isPriceHide):?>
					<?if ($strP_CONSUMER_PRICE > 0){?>
					<tr>
						<th><?=$LNG_TRANS_CHAR["PW00002"] //소비자가?></th>
						<td><?=$strMoneyIconL?><s class="priceOrg"><?=getCurToPrice($strP_CONSUMER_PRICE);?><?=$strMoneyIconR?></s></td>
					</tr>
					<?}?>
					<tr>
						<th><?if($S_PRODUCT_RENT == "Y" && $strP_STOCK_PRICE != "1" ){echo $LNG_TRANS_CHAR["PW00003"]; }else{echo $LNG_TRANS_CHAR["PW00081"];} //임대가/판매가?></th>
						<td class="prodInfoSellPrice">
							<?if ($strP_EVENT_UNIT && $strP_EVENT){?><s><?}?>
								<?
								if($strP_PRICE_FILTER=='FOB'){
									echo getCurMark("$");
								}else{
									echo $strMoneyIconL;
								}
								?><strong class="sellPrice" id="realPayPriceText"> <?

								if($strP_PRICE_FILTER=='FOB'){
									//echo getProdDiscountPrice($prodRow,"1",0,"US");
									echo number_format($prodRow['P_SALE_PRICE']);
								}else{
									echo getProdDiscountPrice($prodRow);
								}

								?></strong><?
												if($strP_PRICE_FILTER=='FOB'){
													//echo '$';
												}else{
													echo $strMoneyIconR;
												}
												?>
												<? if($strP_PRICE_UNIT){?>	(1<?=$strP_PRICE_UNIT?> 당)	<?}?>
							<?if ($strP_EVENT_UNIT && $strP_EVENT){?></s><?}?>
						</td>
					</tr>
					<?if ($strP_EVENT_UNIT && $strP_EVENT){?>
						<tr>
							<th><?=$LNG_TRANS_CHAR["PW00005"] //특별할인가?></th>
							<td> <?=$strMoneyIconL?><strong class="priceOrange _fs14" id="realPayPriceTaxText"><?=getCurToPrice(getProdEventPrice($intP_SALE_PRICE,$strP_EVENT_UNIT,$strP_EVENT))?></strong> <?=$LNG_TRANS_CHAR["PW00007"] //(10%할인)?><?=$strMoneyIconR?>
							</td>
						</tr>
					<?}?>
					<?php if($strProdPoint):?>
					<tr>
						<th><?=$LNG_TRANS_CHAR["OW00065"] //포인트?></th>
						<td><?php echo $strProdPoint;?></td>
					</tr>
					<?php endif;?>
					<?php endif;?>
					<?php if($strP_MAKER):?>
					<tr>
						<th><?=$LNG_TRANS_CHAR["PW00026"] //제조사?></th>
						<td><?php echo $strP_MAKER;?></td>
					</tr>
					<?php endif;?>

					<?php if($strP_BRAND_NAME):?>
					<tr>
						<th><?=$LNG_TRANS_CHAR["PW00027"] //브랜드?></th>
						<td><?php echo $strP_BRAND_NAME;?></td>
					</tr>
					<?php endif;?>
					<?if ($prodRow["P_MODEL"]){?>
					<tr>
						<th><?=$LNG_TRANS_CHAR["PW00029"]; //모델?></th>
						<td><?=$strP_MODEL;?></td>
					</tr>
					<?}?>
					<?php if(!$isPriceHide):?>
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
												<option value="">:: <?=($aryProdOpt[$i][PO_ESS]=="Y")?$LNG_TRANS_CHAR["PW00009"]:$LNG_TRANS_CHAR["PW00010"]; //필수선택:선택?> ::</option>
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
												<option value="">:: <?=($aryProdOpt[$i][PO_ESS]=="Y")?$LNG_TRANS_CHAR["PW00009"]:$LNG_TRANS_CHAR["PW00010"]; //필수선택:선택?> ::</option>
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
										<th><?=$aryProdAddOpt[$i][PO_NAME1]?></th>
										<td>
										<select id="cartAddOpt_<?=$aryProdAddOpt[$i][PO_NO]?>" name="cartAddOpt_<?=$aryProdAddOpt[$i][PO_NO]?>"  onchange="javascript:goSelectProdAddOpt(this,<?=$aryProdAddOpt[$i][PO_NO]?>);">
											<option value="">:: <?=($aryProdAddOpt[$i][PO_ESS]=="Y")?$LNG_TRANS_CHAR["PW00009"]:$LNG_TRANS_CHAR["PW00010"];?> ::</option>
											<?for($j=0;$j<sizeof($aryProdAddOpt[$i][OPT_ATTR]);$j++){?>
											<option value="<?=$aryProdAddOpt[$i][OPT_ATTR][$j][PAO_NO]?>"><?=$aryProdAddOpt[$i][OPT_ATTR][$j][PAO_NAME]?></option>
											<?}?>
										</select>
										</td>
									</tr>
								<?
							}
						}

					if (($S_SITE_LNG == "KR" && ($S_DELIVERY_MTH == "N" || !$S_DELIVERY_MTH)) || ($S_SITE_LNG != "KR" && $S_DELIVERY_FOR_MTH != "W")){
						if ($prodRow[P_BAESONG_TYPE] == "1"){
							$intShopDeliveryStPrice = $SHOP_ARY_DELIVERY["SHOP_DELIVERY_ST_PRICE"];
							if ($prodRow['P_SHOP_NO'] > 0 && $prodShopInfo['SH_COM_DELIVERY'] == 'S'){
								$intShopDeliveryStPrice = $prodShopInfo['SH_COM_DELIVERY_ST_PRICE'];
							}

							if ($intShopDeliveryStPrice > 0){
								if (($prodRow[P_SALE_PRICE] > $intShopDeliveryStPrice)){
					?>
					<tr class="deliveryFreeInfoRow">
						<th><?=$LNG_TRANS_CHAR["PW00012"] //배송비?></th>
						<td><?=$LNG_TRANS_CHAR["PW00013"] //무료?></td>
					</tr>
					<?
								} else {

					?>
					<tr class="deliveryPriceInfoRow">
						<th><?=$LNG_TRANS_CHAR["PW00012"] //배송비?></th>
						<td><?=($prodRow['P_SHOP_NO'] > 0 && $prodShopInfo['SH_COM_DELIVERY'] == 'S' ) ? getCurToPrice($prodShopInfo['SH_COM_DELIVERY_PRICE']) : getCurToPrice($SHOP_ARY_DELIVERY["SHOP_DELIVERY_PRICE"]);?></td>
					</tr>
					<tr class="deliveryConditionInfoRow">
						<th><?=$LNG_TRANS_CHAR["PW00014"] //배송비무료조건?></th>
						<td>
							<?if ($prodRow['P_SHOP_NO'] > 0 && $prodShopInfo['SH_COM_DELIVERY'] == 'S'){?>
							<?=callLangTrans($LNG_TRANS_CHAR["PS00034"],array(getCurToPrice($prodShopInfo['SH_COM_DELIVERY_ST_PRICE']))); //{{단어1}}이상 구매시?>
							<?}else{?>
							<?=callLangTrans($LNG_TRANS_CHAR["PS00034"],array(getCurToPrice($SHOP_ARY_DELIVERY["SHOP_DELIVERY_ST_PRICE"]))); //{{단어1}}이상 구매시?>
							<?}?>
						</td>
					</tr>
					<?if(!$S_DELIVERY_PAY_TYPE):?>
					<tr class="deliveryPayInfoRow">
						<th><?=$LNG_TRANS_CHAR["PW00015"] //배송비결제여부?></th>
						<td>
							<select id="cartDelivery" name="cartDelivery">
								<?if ($prodRow['P_SHOP_NO'] > 0 && $prodShopInfo['SH_COM_DELIVERY'] == 'S'){?>
								<option value="1">::<?=callLangTrans($LNG_TRANS_CHAR["PS00004"],array(getCurToPrice($prodShopInfo["SH_COM_DELIVERY_PRICE"]))); //주문시 {{단어1}} 결제?>
								<?}else{?>
								<option value="1">::<?=callLangTrans($LNG_TRANS_CHAR["PS00004"],array(getCurToPrice($SHOP_ARY_DELIVERY["SHOP_DELIVERY_PRICE"]))); //주문시 {{단어1}} 결제?>
								<?}?>
								 ::</option>
								<option value="2">::<?=$LNG_TRANS_CHAR["PS00005"]?> ::</option>
							</select>
						</td>
					</tr>
					<?endif;?>
					<!--<tr>
						<th>예외지역배송</th>
						<td><input type="checkbox" id="cartDeliveryExp" name="cartDeliveryExp" value="Y"></td>
						(* 예외지역 배송일 경우 체크)
					</tr>//-->
					<?		}}} else if ($prodRow[P_BAESONG_TYPE] == "2"){
						if ($S_SITE_LNG == "KR" && $S_DELIVERY_MTH != "G"){		?>
					<tr>
						<th><?=$LNG_TRANS_CHAR["PW00012"] //배송비?></th>
						<td><?=$LNG_TRANS_CHAR["PW00016"] //무료배송?></td>
					</tr>
					<?		}} else if ($prodRow[P_BAESONG_TYPE] == "3"){?>
					<tr>
						<th><?=$LNG_TRANS_CHAR["PW00012"] //배송비?></th>
						<td><?=$LNG_TRANS_CHAR["PW00017"] //고정 배송비?> <?=getCurToPrice($prodRow[P_BAESONG_PRICE])?><?=getCurMark2()?></td>
					</tr>
					<?		} else if ($prodRow[P_BAESONG_TYPE] == "4"){?>
					<tr>
						<th><?=$LNG_TRANS_CHAR["PW00012"] //배송비?></th>
						<td><?=$LNG_TRANS_CHAR["PW00018"] //수량별 배송?> <?=getCurToPrice($prodRow[P_BAESONG_PRICE])?><?=getCurMark2()?></td>
					</tr>
					<?		} else if ($prodRow[P_BAESONG_TYPE] == "5"){?>
					<tr>
						<th><?=$LNG_TRANS_CHAR["PW00012"] //배송비?></th>
						<td>
							<?if ($prodRow[P_BAESONG_PRICE] > 0){?>
							<?=callLangTrans($LNG_TRANS_CHAR["PS00006"],array($strMoneyIconL,getCurToPrice($prodRow[P_BAESONG_PRICE]),$strMoneyIconR)); //상품 수령 후 {{단어1}} {{단어2}} 지불?>
							<?}else{?>
							<?=callLangTrans($LNG_TRANS_CHAR["PS00006"],array("","","")); //상품 수령 후 {{단어1}} {{단어2}} 지불?>
							<?}?>
						</td>
					</tr>
					<?		}
					} else {
					?>
					<!--<tr>
						<th><?=$LNG_TRANS_CHAR["PW00012"] //배송비?></th>
						<td>배송비 설명 페이지 링크</td>
					</tr>//-->
					<?}?>
					<!-- 상품 항목 설명 -->
					<?
					if ($S_FIX_PROD_BASIC_ITEM_USE != "Y"){
						if (is_array($aryProdItem)){

							for($i=0;$i<sizeof($aryProdItem);$i++){

								$strProdItemType		= (!$aryProdItem[$i][PI_TYPE]) ? "B":$aryProdItem[$i][PI_TYPE];
								$arrProdItemTypeText	= explode(";",$aryProdItem[$i][PI_TEXT]);
							?>
					<tr>
						<th><?=$aryProdItem[$i][PI_NAME]?></th>
						<td>
							<?if(!$strProdItemType || ($strProdItemType == "B")){?>
							<?=$aryProdItem[$i][PI_TEXT]?>
							<?}elseif($strProdItemType == "C"){?>
							<?=drawCheckBox("cartAddItem".$aryProdItem[$i][PI_NO],$arrProdItemTypeText,"","",false, "&nbsp;", $colCnt=0,$onclick="")?>
							<?}elseif($strProdItemType == "S"){?>
							<?=drawSelectBox("cartAddItem".$aryProdItem[$i][PI_NO],$arrProdItemTypeText,"","","",$etc="",$firstItem="",$firstItemValue="")?>
							<?}elseif($strProdItemType == "R"){?>
							<?=drawRadioBox("cartAddItem".$aryProdItem[$i][PI_NO],$arrProdItemTypeText,"","",false, $gap="&nbsp;", $colCnt=0, $etc="",$onchange="")?>
							<?}else{?>
							<input type="text" name="cartAddItem<?=$aryProdItem[$i][PI_NO]?>"  id="cartAddItem<?=$aryProdItem[$i][PI_NO]?>" value="" maxlength="100"
							<?=($strProdItemType == "D")?"data-simple-datepicker-check-mobile readonly":"";?>>
							<?}?>

						</td>
					</tr>
							<?
							}
						}
					}
					?>
					<?
					/*
					?>
					<!-- 상품 항목 설명 -->
						<tr class="snsShareIcon">
							<th><?=$LNG_TRANS_CHAR["CW00033"] //SNS공유?></th>
							<td class="snsWrap">
									<!-- a href="javascript:goKakaoTalk('<?=$strSnsName?>', '<?=$strSnsLink?>')"><img src="/himg/mobile/ico_kakaotalk.png" class="snsIconImg"/></a //-->
									<a href="javascript:goKakaoStory('<?=$strSnsName?>', '<?=$strSnsLink?>','<?=$strSnsImg?>')"><img src="/himg/mobile/ico_kakaostory.png" class="snsIconImg"/></a>
								<!-- sns -->
								<?if($arySns['twitter']=="Y"):?>
									<a href="javascript:goTwitter('<?=$strSnsName?>', '<?=$strSnsLink?>')"><img src="/himg/mobile/ico_twitter.png" class="snsIconImg"/></a>
								<?endif;?>
								<?if($arySns['facebook']=="Y"):?>
									<a href="javascript:goFacebook('<?=$strSnsLink?>', '<?=$strSnsImg?>', '<?=$S_SITE_KNAME?>', '<?=$strSnsName?>', '')"><img src="/himg/mobile/ico_facebook.png" class="snsIconImg"/></a>
								<?endif;?>
								<?if($arySns['m2day']=="Y"):?>
									<!-- a href="javascript:goMe2Day('<?=$strSnsName?>', '<?=$strSnsLink?>')"><img src="/himg/mobile/ico_black_m2day.gif"></a //-->
								<?endif;?>
							</td>
						</tr>
					<?*/?>
						<?php endif;?>
					</table>
					<?php if(!$isPriceHide):?>
					<?if(($prodRow[P_QTY]>0 || $prodRow[P_STOCK_LIMIT] == "Y") && $prodRow[P_STOCK_OUT] != "Y" && !is_array($aryProdOpt)){?>
					<div class="optionValueWrap" id="divSelectOpt">
						<div id="divCartOptAttr_0" class="optionWrap">
							<input type="hidden" name="cartOptNo[]" value="0">
							<input type="hidden" name="0_cartOptPrice" id="0_cartOptPrice" value="<?if ($prodRow[P_EVENT] > 0 && getProdEventInfo($prodRow) == "Y"){?><?=getCurToPrice($prodRow[P_SALE_PRICE])?><?}else{?><?=getProdDiscountPrice($prodRow)?><?}?>">
							<input type="hidden" name="0_cartOptOrgPrice" id="0_cartOptOrgPrice" value="0">
							<table>
								<tr>
									<th class="optTit"><?=$LNG_TRANS_CHAR["PW00019"] //구매수량?></th>
									<td class="optCnt">
										<ul class="cntInputWrap">
											<li>
												<input type="input" id="0_cartQty" name="0_cartQty" value="<?=$prodRow[P_MIN_QTY]?>" class="cntInputForm"/>
											</li>
											<li class="btnCntUpDown">
												<a href="javascript:goProdViewQtyChange(0,'up',1);" class="up"><span></span></a>
												<a href="javascript:goProdViewQtyChange(0,'down',1);" class="down"><span></span></a>
											</li>
										</ul>
									</td>
									<td class="optPrice">
										<?=$strMoneyIconL?><strong id="0_cartOptPriceMark"><?if ($prodRow[P_EVENT] > 0 && getProdEventInfo($prodRow) == "Y"){?><?=getCurToPrice($prodRow[P_SALE_PRICE])?><?}else{?><?=getProdDiscountPrice($prodRow)?><?}?></strong><?=$strMoneyIconR?>
									</td>
								</tr>
							</table>
						</div>
					</div>
					<div class="totalPriceWrap" id="divSelectOptTotalPrice">
						<?=$LNG_TRANS_CHAR["PW00042"]; //총상품금액?>:
						<strong class="totalPriceTxt"><?=$strMoneyIconL?></strong>
						<strong id="cartOptTotalPrice" class="totalPrice"><?if ($prodRow[P_EVENT] > 0 && getProdEventInfo($prodRow) == "Y"){?><?=getCurToPrice($prodRow[P_SALE_PRICE])?><?}else{?><?=getProdDiscountPrice($prodRow)?><?}?></strong><strong class="totalPriceTxt"><?=$strMoneyIconR?></strong>
					</div>
					<?}else{?>
					<div class="optionValueWrap" id="divSelectOpt">
					</div>
					<div class="totalPriceWrap" id="divSelectOptTotalPrice">
					</div>
					<?}?>
					<?php endif;?>
				</table>
			</div>
		</div><!-- detailInfo -->
		<!-- (3) 구매버튼 -->
		<div class="orderBtnWrap">
			<a href="javascript:<?=($strP_PRICE_FILTER == 'FOB')? "alert('$LNG_TRANS_CHAR[MS00163]');" : 'goCartOrder();' ;?>" class="btnProdBuy btn_red"><span><?=$LNG_TRANS_CHAR["PW00021"] //상품구매?></span></a>
			<div class="btnBox btn3Wrap">
				<a href="javascript:<?=($strP_PRICE_FILTER == 'FOB')? "alert('$LNG_TRANS_CHAR[MS00163]');" : 'goCart();' ;?>" class="btnCart btn_gray"><span><?=$LNG_TRANS_CHAR["PW00022"] //장바구니?></span></a>
				<?//if($strP_PRICE_FILTER == 'EXW'){?>
				<a href="javascript:<?=($strP_PRICE_FILTER == 'FOB')? "alert('$LNG_TRANS_CHAR[MS00163]');" : 'goWish();' ;?>" class="btnWish btn_gray"><span><?=$LNG_TRANS_CHAR["PW00023"] //담아두기?></span></a>
				<a href="<?=$loginCheck?>" class="btnProdQna btn_gray"><span><?=$LNG_TRANS_CHAR["PW00108"]; //문의하기 ?></span></a>
				<?//}?>
			</div>
		</div>
		<!-- (3) 구매버튼 -->
	</div><!-- prodDetailView -->
	<div class="clr"></div>
	<!-- 상세설명 영역 -->

	<!-- start: 탭버튼 -->
	<div class="detailInfoTab2Wrap">
		<a href="#;" onclick="C_getTabChange('prodDetail','1')" id="btn-prodDetail1" class="btn1"><span><?=$LNG_TRANS_CHAR["OW00001"] //상세정보?></span></a>
		<a href="#;" onclick="C_getTabChange('prodDetail','2')" id="btn-prodDetail2" class="btn2 on"><span><?=$LNG_TRANS_CHAR["CW00032"] //배송&교환반품안내?></span></a>
		<div class="clr"></div>
	</div>
	<!-- end: 탭버튼 -->

	<!-- 상품정보 -->
	<script>
		function mobile_download(url,file_type) {
			var filter = "win16|win32|win64|mac";
			if (navigator.platform) {
				if (filter.indexOf(navigator.platform.toLowerCase()) < 0) {
					try {
						if (fnCheckiPhone()) { //아이폰
							//agent safari 체크
							if (fnUserAgent()) {
								//window.location = "snTec://login?URL="+url+"§†M_ID="+$("#login_id").val()+"§†API_URL=http://222.122.20.23/mobileApi.php";
								window.location = "snTec://attachFile?URL=" + url + "§†type=" + file_type;
								return;
							}

						} else {//안드로이드
							window.SNT.attachFile(url,file_type);
						}


					} catch (err) {
					}
				}
			}
		}
	</script>
	<div class="detailArea" id="prodDetail1">
		<?=($prodRow['P_MOB_TEXT'])?$prodRow['P_MOB_TEXT']:$prodRow['P_WEB_TEXT'];?>

		<div style="margin-top:10px;">
			<?=$prodRow['P_WEB_TEXT']?>
			<?
			//상품 안내용 첨부파일 추가. 남덕희
			for($i=1;$i<=3;$i++)
			{
				$productMgr->setP_CODE($strP_CODE);
				$productMgr->setPM_TYPE("file".$i);
				$aryProdFile[$i] = $productMgr->getProdImg($db);
			}

			for($z=1;$z<=3;$z++){
				if (is_array($aryProdFile[$z]) && $aryProdFile[$z][0]['PM_NO'] > 0){
					//$EXT = getFileExt($aryProdFile[$z][0]['PM_SAVE_NAME']);
					$fileInfo = pathinfo($aryProdFile[$z][0]['PM_REAL_NAME']);
					?>
					<?=$LNG_TRANS_CHAR["CW00058"] //첨부파일?>
					: <a href="javascript:mobile_download('<?=$S_SITE_URL?>/kr/?menuType=popup&mode=prodFileDown&no=<?=$aryProdFile[$z][0]['PM_NO']?>','<?=$fileInfo['extension']?>')"><?=$aryProdFile[$z][0]['PM_SAVE_NAME']?></a>
					<!--
					<a href="/kr/?menuType=popup&mode=prodFileDown&no=<?=$aryProdFile[$z][0]['PM_NO']?>"><?=$aryProdFile[$z][0]['PM_SAVE_NAME']?></a>
					-->
				<?}?><br>
			<?}?>
		</div>

		<div class="clr"></div>
	</div>
	<!-- 상품정보 -->

	<!-- 배송정보 -->
	<div class="prodDetailDelivery" id="prodDetail2">
		<!--<h5><?=$LNG_TRANS_CHAR["CW00032"] //배송&교환반품안내?></h5>-->
		<?=$strProdDeliveryText?>
	</div>
		<!-- 배송정보 -->

	<?
	/*
	?>
	<!-- 상품리뷰 -->
	<div id="productReview" class="txtInfo hide" group="productTab">
		<h5><?php echo $LNG_TRANS_CHAR["CW00082"] // 상품리뷰?></h5>
		<?php
		$EUMSHOP_APP_INFO					= "";
		$EUMSHOP_APP_INFO['name']			= "상품리뷰";
		$EUMSHOP_APP_INFO['mode']			= "communityList";
		$EUMSHOP_APP_INFO['skin']			= "mobileSkin";
		$EUMSHOP_APP_INFO['bCode']			= "PROD_REVIEW";
		$EUMSHOP_APP_INFO['column']			= "번호;제목;작성자;작성일;내용";
		$EUMSHOP_APP_INFO['pCode']			= $strP_CODE;
		$EUMSHOP_APP_INFO['linkType']		= "toggle";
		include "{$S_DOCUMENT_ROOT}www/web/app/index.php";
		?>
	</div>
	<!-- 상품리뷰 -->

	<!-- 상품QNA -->
	<div id="productQnA" class="txtInfo hide" group="productTab">
		<h5><?php echo $LNG_TRANS_CHAR["CW00083"] // 상품QNA?></h5>
		<?php
		$EUMSHOP_APP_INFO					= "";
		$EUMSHOP_APP_INFO['name']			= "상품QNA";
		$EUMSHOP_APP_INFO['mode']			= "communityList";
		$EUMSHOP_APP_INFO['skin']			= "mobileSkin";
		$EUMSHOP_APP_INFO['bCode']			= "PROD_QNA";
		$EUMSHOP_APP_INFO['column']			= "번호;제목;작성자;작성일;내용";
		$EUMSHOP_APP_INFO['pCode']			= $strP_CODE;
		$EUMSHOP_APP_INFO['linkType']		= "toggle";
		include "{$S_DOCUMENT_ROOT}www/web/app/index.php";
		?>
	</div>
	<!-- 상품QNA -->
	<?
	*/
	?>
</div>

<div class="mainProdInfoView companyInfoViewWrap" id="tab2">
	<div class="companyInfo_1">
		<div class="topInfoWrap">
			<p class="title"><?=$strSH_COM_NAME?></p>
			<p class="info"><?=$strSH_COM_INTRO1?></p>

			<div class="photo"><img src="<?=$sh_file4?>" ><!--img src="/upload/images/bg_m_photo.jpg"/--></div>
		</div>

		<div class="shopSumInfoWrap">
			<div class="shopSumInfo tableBox">
				<table class="shopInfoTable">
					<tr>
						<th><?= $LNG_TRANS_CHAR["PW00083"]; //등급 ?></th>
						<td>
							<img src="<?=$strSH_COM_CREDIT_GRADE_IMG?>">
							<img src="<?=$strSH_COM_SALE_GRADE_IMG?>">
							<img src="<?=$strSH_COM_LOCUS_GRADE_IMG?>">
						</td>
					</tr>
					<tr>
						<th><?= $LNG_TRANS_CHAR["PW00082"]; //업체명 ?></th>
						<td><?=$strSH_COM_NAME?></td>
					</tr>
					<tr>
						<th><?= $LNG_TRANS_CHAR["MW00021"]; //국가 ?></th>
						<td><?=$aryCountryList[$strSH_COM_COUNTRY];?></td>
					</tr>
					<tr>
						<th>TYPE</th>
						<td><?=$aryType[$strSH_COM_CATEGORY];?></td>
					</tr>
					<tr class="lastRow">
						<th><?= $LNG_TRANS_CHAR["SW00040"]; //웹사이트 ?></th>
						<td><a onclick="fnOpenBrowser('http://<?=$strSH_COM_SITE?>');" ><?=$strSH_COM_SITE?></a></td>
					</tr>
				</table>
			</div><!-- (4) shopSumInfo //-->

			<div class="btnCenter btn2Box">
				<a href="tel:<?=$strSH_COM_PHONE?>" class="btn_red"><?= $LNG_TRANS_CHAR["PW00093"]; //전화문의 ?></a>
				<a href="mailto:<?=$strSH_COM_MAIL?>" class="btn_red"><?= $LNG_TRANS_CHAR["PW00094"]; //메일문의 ?></a>
			</div>

			<div class="infoTxtWrap">
				<p class="title"><span>>></span> <?=$strSH_COM_NAME?></p>
				<div class="artcle">	<?=strHanCutUtf2($strSH_COM_INTRO2,350)?></div>
			</div>
		</div>

		<div class="detailInfoTab2Wrap">
			<a href="#;" onclick="C_getTabChange('comProd','1')" id="btn-comProd1" class="on btn1" ><span><?= $LNG_TRANS_CHAR["PW00092"]; //회사정보 ?></span></a>
			<a href="#;" onclick="C_getTabChange('comProd','2')" id="btn-comProd2" class="btn2"><span><?= $LNG_TRANS_CHAR["PW00088"]; //제품정보 ?></span></a>
			<div class="clr"></div>
		</div>

		<div class="shopSumInfoWrap shopInfoBoxArea" id="comProd1">
			<div class="infoTableWrap tableBox">
				<table class="comInfoTable">
					<tr>
						<th><?= $LNG_TRANS_CHAR["MW00021"]; //국가 ?></th>
						<td><?=$aryCountryList[$strSH_COM_COUNTRY];?></td>
					</tr>
					<tr>
						<th>Type</th>
						<td><?=$aryType[$strSH_COM_CATEGORY];?></td>
					</tr>
					<tr>
						<th><?= $LNG_TRANS_CHAR["PW00082"]; //업체명 ?></th>
						<td><?=$strSH_COM_NAME?></td>
					</tr>
					<tr>
						<th><?= $LNG_TRANS_CHAR["MW00064"]; //대표자 ?></th>
						<td><?=$strSH_COM_REP_NM?></td>
					</tr>
					<tr>
						<th><?= $LNG_TRANS_CHAR["SW00007"]; //대표전화 ?></th>
						<td class="ico_comNumber"><a href="tel:02-1234-5678"><?=$strSH_COM_PHONE?></a></td>
					</tr>
					<tr>
						<th><?= $LNG_TRANS_CHAR["SW00008"]; //대표팩스 ?></th>
						<td><?=$strSH_COM_FAX?></td>
					</tr>
					<tr>
						<th><?= $LNG_TRANS_CHAR["SW00015"]; //회사주소 ?></th>
						<td class="ico_comAddr"><?=$strSH_COM_ADDR?></td>
					</tr>
					<tr>
						<th>E-mail</th>
						<td class="ico_comMail" onclick="location.href='mailto:<?=$strSH_COM_MAIL?>'"><?=$strSH_COM_MAIL?></td>
					</tr>
					<tr>
						<th><?= $LNG_TRANS_CHAR["SW00012"]; //사업자번호 ?></th>
						<td><?=$strSH_COM_NUM?></td>
					</tr>
					<tr>
						<th><?= $LNG_TRANS_CHAR["SW00040"]; //웹사이트 ?></th>
						<td><a onclick="fnOpenBrowser('http://<?=$strSH_COM_SITE?>');"><?=$strSH_COM_SITE?></a></td>
					</tr>
					<tr>
						<th><?= $LNG_TRANS_CHAR["SW00041"]; //설립연도 ?></th>
						<td><?=$strSH_COM_FOUNDED?><?= $LNG_TRANS_CHAR["CW00010"]; //년 ?></td>
					</tr>
					<tr>
						<th><?= $LNG_TRANS_CHAR["SW00042"]; //직원수 ?></th>
						<td><?=$strSH_COM_NUMBER?><?= $LNG_TRANS_CHAR["SW00058"]; //명 ?></td>
					</tr>
					<tr>
						<th><?= $LNG_TRANS_CHAR["SW00043"]; //연간 총 매출액 ?></th>
						<td><?=$strSH_COM_TOTAL_SALE?></td>
					</tr>
					<tr class="lastRow">
						<th><?= $LNG_TRANS_CHAR["SW00044"]; //수출비율 ?></th>
						<td><?=$strSH_COM_RATE?></td>
					</tr>
					<tr class="lastRow">
						<th><?= $LNG_TRANS_CHAR["SW00045"]; //연간 총 생산량 ?></th>
						<td><?=$strSH_COM_TOTAL_PRODUCTION?></td>
					</tr>
				</table>
			</div>
			<script>
			function graphImgToggle(){
				var graphImgDisplay = $(".shopInfo2Box .graphImg").css("display");
				if(graphImgDisplay == 'none'){
					$(".shopInfo2Box .graphImg").css({"display":""});
					$(".shopInfo2Box .toggle").html('<?= $LNG_TRANS_CHAR["PW00105"]; //닫기 ?>');
				}else{
					$(".shopInfo2Box .graphImg").css({"display":"none"});
					$(".shopInfo2Box .toggle").html('<?= $LNG_TRANS_CHAR["PW00104"]; //열기 ?>');
				}
			}
			</script>
			<div class="shopInfo2Box">
				<h3><?= $LNG_TRANS_CHAR["SW00046"]; //주요 유통 시장 ?><span class="toggle" onclick="javascript:graphImgToggle();"><?= $LNG_TRANS_CHAR["PW00104"]; //열기 ?></span></h3>
				<div class="graphImg" style="display:none">
					<?
					for($i=1;$i <= $aryEntryCnt ; $i++){
					?>
					<ul>
						<li><?php echo $aryEntry["SH_COM_COUNTRY{$i}"];?></li>
						<li><?php echo $prodShopInfo["SH_COM_COUNTRY{$i}"];?>%</li>
					</ul>
					<?
					}
					?>
				</div>
			</div>

			<div class="companyInfo_tb companyInfo_tb2 tableBox">
				<table class="comInfoTable">
					<tr>
						<tr>
							<th><?= $LNG_TRANS_CHAR["SW00047"]; //공장크기 ?></th>
							<td><?=$strSH_COM_SIZE;?>㎡</td>
						</tr>
						<th><?= $LNG_TRANS_CHAR["SW00048"]; //공장위치 ?></th>
						<td><?=$strSH_COM_LOCAL;?></td>
					</tr>
					<tr>
						<th><?= $LNG_TRANS_CHAR["SW00062"]; //R&D직원수 ?></th>
						<td><?=$strSH_COM_RD;?><?= $LNG_TRANS_CHAR["SW00058"]; //명 ?></td>
					</tr>
					<tr>
						<th><?= $LNG_TRANS_CHAR["SW00063"]; //Production Capacity ?></th>
						<td><?=$strSH_COM_CATE;?></td>
					</tr>
					<tr class="lastRow">
						<th><?= $LNG_TRANS_CHAR["SW00051"]; //인증서 ?></th>
						<td class="ico_comDownload">

						<?if($sh_certificates1):?>
						<div>
						<a href="<?=fileExtCheck($sh_certificates1);?>"><?=$prodShopInfo[SH_COM_CERTIFICATES1]?></a>
						<!--img src="<?=$sh_certificates1?>" style="width:70px;height:70px"-->
						</div>
						<?endif;?>
						<?if($sh_certificates2):?>
						<div>
						<a href="<?=fileExtCheck($sh_certificates2);?>"><?=$prodShopInfo[SH_COM_CERTIFICATES2]?></a>
						<!--img src="<?=$sh_certificates2?>" style="width:70px;height:70px"-->
						</div>
						<?endif;?>
						<?if($sh_certificates3):?>
						<div>
						<a href="<?=fileExtCheck($sh_certificates3);?>"><?=$prodShopInfo[SH_COM_CERTIFICATES3]?></a>
						<!--img src="<?=$sh_certificates3?>" style="width:70px;height:70px"-->
						</div>
						<?endif;?>
						<?if($sh_certificates4):?>
						<div>
						<a href="<?=fileExtCheck($sh_certificates4);?>"><?=$prodShopInfo[SH_COM_CERTIFICATES4]?></a>
						<!--img src="<?=$sh_certificates4?>" style="width:70px;height:70px"-->
						</div>
						<?endif;?>
						<?if($sh_certificates5):?>
						<div>
						<a href="<?=fileExtCheck($sh_certificates5);?>"><?=$prodShopInfo[SH_COM_CERTIFICATES5]?></a>
						<!--img src="<?=$sh_certificates5?>" style="width:70px;height:70px"-->
						</div>
						<?endif;?>
						</td>
					</tr>
				</table>
			</div>
		</div>
		<div class="shopInfoBoxArea" id="comProd2" style="display:none;">
		<?
		$no				= 1;
		// 상품 리스트

		/* 정의 */

		$intHList=5;
		$intWList = 2;

		if (!$intWSize) $intWSize 			= $S_PRODLIST_IMG_SIZE_W;
		if (!$intHSize) $intHSize			= $S_PRODLIST_IMG_SIZE_H;
		if (!$intWList) $intWList 			= $S_PRODLIST_IMG_VIEW_W;
		if (!$intHList) $intHList			= $S_PRODLIST_IMG_VIEW_H;
		$strWAlign							= $S_PRODLIST_WORD_ALIGN;
		$strMoney							= $S_PRODLIST_MONEY_TYPE;
		$strMoneyIcon						= $S_PRODLIST_MONEY_ICON;
		$strShow1							= $S_PRODLIST_SHOW_1;
		$strShow2							= $S_PRODLIST_SHOW_2;
		$strShow3							= $S_PRODLIST_SHOW_3;
		$strShow4							= $S_PRODLIST_SHOW_4;
		$strShow5							= $S_PRODLIST_SHOW_5;
		$strShow6							= $S_PRODLIST_SHOW_6;
		$strShow7							= $S_PRODLIST_SHOW_7;
		$strShow8							= $S_PRODLIST_SHOW_8;
		$strColor1							= $S_PRODLIST_COLOR_1;
		$strColor2							= $S_PRODLIST_COLOR_2;
		$strColor3							= $S_PRODLIST_COLOR_3;
		$strColor4							= $S_PRODLIST_COLOR_4;
		$strColor5							= $S_PRODLIST_COLOR_5;
		$strTitleShow						= $S_PRODLIST_TITLE_SHOW_USE;
		$strTitleFile						= $S_PRODLIST_TITLE_FILE_NAME;
		$strNaviUse							= $S_PRODUCT_NAVI_USE_OP;
		$intTitleMaxsize					= $S_PRODLIST_TITLE_MAXSIZE;

		$viewProductMgr = new ProductMgr();
		$listDataParam	 = "";

		$viewProductMgr->setP_SHOP_NO($prodRow[P_SHOP_NO]);
		$viewProductMgr->setSearchWebView('Y');
		//모바일 보임 상품만 출력 추가. 남덕희
		$viewProductMgr->setP_MOB_VIEW('Y');

		/* 데이터 리스트 */
		$intTotal	= $viewProductMgr->getProdTotal($db,$strMode,$listDataParam);
		//echo $db->query;
		$intPageLine							= $intWList * $intHList;															// 리스트 개수
		$intPage								= ( $intPage )				? $intPage		: 1;
		$intFirst								= ( $intTotal == 0 )		? 1				: $intPageLine * ( $intPage - 1 );
		$viewProductMgr->setLimitFirst( $intFirst );
		if ($strProdListAllView == "Y") $viewProductMgr->setPageLine( $intTotal );
		else $viewProductMgr->setPageLine( $intPageLine );

		$result = $viewProductMgr->getProdList($db,$strMode,$listDataParam);

		$intPageBlock					= 10;															// 블럭 개수
		$intListNum						= $intTotal - ( $intPageLine * ( $intPage - 1 ) );				// 번호
		$intTotPage						= ceil( $intTotal / $intPageLine );
		/* 데이터 리스트 */


		$aryProdShopCateCount = $viewProductMgr -> getProdShopCateGroup($db);

		$aryProdCount = array();
		$intProdCountTotal = 0;
		for($i = 0; $i < sizeof($aryProdShopCateCount); $i++){
			$aryProdCount[$aryProdShopCateCount[$i][P_LCATE]] = $aryProdShopCateCount[$i][P_CATE_COUNT];
			$intProdCountTotal += $aryProdShopCateCount[$i][P_CATE_COUNT];
		}

		$cateMgr -> setC_LEVEL('1');
		$cateMgr -> setCL_VIEW_YN('Y');
		$aryCategorys = $cateMgr -> getCateLevelAry($db);
		$aryCateNames = array();
		for($i = 0; $i < sizeof($aryCategorys); $i++){
			$aryCateNames[$aryCategorys[$i][CATE_CODE]] = $aryCategorys[$i][CATE_NAME];
		}

		$row = array();
		while ( $_row = mysql_fetch_array($result) ) {
			array_push($row, $_row);
		}

		?>
		<!--제품정보-->
		<div class="companyProdViewWrap" id="comProd2" style="display:none;">
			<?
			if(sizeof($aryCategorys) > 0 ){
			?>
			<div class="comProdInfoTableWrap">
				<div class="comProdCntWrap">
				<!-- 총 <span><?php echo (!$intProdCountTotal) ? 0 : number_format($intProdCountTotal);?></span>개의 제품을 보유하고 있습니다.-->
				<?= callLangTrans($LNG_TRANS_CHAR["MS00160"],array( (!$intProdCountTotal) ? 0 : number_format($intProdCountTotal) )); ?>
				</div>
				<table class="comProdInfoTable">
					<tr>
						<?
						for($i =0; $i<sizeof($aryCategorys);$i++){
						?>
						<td class="prodCnt">
						<?
							if($aryProdCount[$aryCategorys[$i][CATE_CODE]]){
								echo $aryProdCount[$aryCategorys[$i][CATE_CODE]];
							}else{
								echo '0';
							}
						?>
						</td>
						<?}?>
					</tr>
					<tr>
						<?
						for($i =0; $i<sizeof($aryCategorys);$i++){
						?>
						<td><?=$aryCategorys[$i][CATE_NAME];?></td>
						<?}?>
					</tr>
				</table>
			</div>
			<?}?>

			<div class="prodNewListWrapB">
				<!--table class="listTypeTable"--><!--- class="listTypeTable"-->
				<!--start loop-->
				<? for($i=0,$k=0;$i<$intHList;$i++){ ?>
						<tr>
					<? for($j=0;$j<$intWList;$j++){	?>
							<td<? if($j==($intWList-1)) { echo sprintf(" style='width:%dpx'", $intWSize); } ?> class="pInfoBox">
						<?
							$k++;
							$di = $k-1;

							if($row[$di]):

								## 기본 설정
								$strViewP_CODE			= $row[$di]['P_CODE'];
								$strViewP_NAME			= $row[$di]['P_NAME'];
								$intViewP_GRADE			= $row[$di]['P_GRADE'];
								$intViewP_GRADE_CNT		= $row[$di]['P_GRADE_CNT'];
								$strViewP_COLOR			= $row[$di]['P_COLOR'];
								$intViewP_SALE_PRICE	= $row[$di]['P_SALE_PRICE'];
								$intViewP_POINT			= $row[$di]['P_POINT'];
								$strViewP_POINT_TYPE	= $row[$di]['P_POINT_TYPE'];
								$strViewP_POINT_OFF1	= $row[$di]['P_POINT_OFF1'];
								$strViewP_POINT_OFF2	= $row[$di]['P_POINT_OFF2'];
								$strViewPM_REAL_NAME	= $row[$di]['PM_REAL_NAME'];
								$strViewPM_REAL_NAME2	= $row[$di]['PM_REAL_NAME2']; // 이미지2 (마우스 오버시 이미지)
								$strViewP_EVENT			= $row[$di]['P_EVENT'];
								$strViewP_LIST_ICON		= $row[$di]['P_LIST_ICON'];
								$strViewP_COLOR_IMG		= $row[$di]['P_COLOR_IMG'];
								$strViewP_BRAND_NAME	= $row[$di]['P_BRAND_NAME'];
								$strViewP_MODEL			= $row[$di]['P_MODEL'];
								$strViewP_ETC			= $row[$di]['P_ETC'];
								$intViewP_CONSUMER_PRICE = $row[$di]['P_CONSUMER_PRICE'];
								$strViewP_PRICE_TEXT	= $row[$di]['P_PRICE_TEXT'];
								$intViewP_QTY			= $row[$di]['P_QTY']; // 수량
								$strViewP_STOCK_OUT		= $row[$di]['P_STOCK_OUT']; // 품절여부
								$strViewP_RESTOCK		= $row[$di]['P_RESTOCK']; // 재입고여부
								$strViewP_STOCK_LIMIT	= $row[$di]['P_STOCK_LIMIT']; // 무제한상품
								$strViewP_BAESONG_TYPE	= $row[$di]['P_BAESONG_TYPE']; // 배송타입
								$strViewP_MEMO			= $row[$di]['P_MEMO'];

								$strViewP_PRICE_FILTER	= $row[$di]['P_PRICE_FILTER'];
								$strViewP_PRICE_UNIT	= $row[$di]['P_PRICE_UNIT'];
								$strViewP_CAS_NO		= $row[$di]['P_CAS_NO'];
								$strViewP_OTHER_NAMES	= $row[$di]['P_OTHER_NAMES'];
								$strViewP_MIN_QTY		= $row[$di]['P_MIN_QTY'];
								$strViewP_ORIGIN		= $row[$di]['P_ORIGIN'];
								//$strSH_COM_NAME			= $row[$di]['SH_COM_NAME'];
								//$strSH_COM_CATEGORY		= $row[$di]['SH_COM_CATEGORY'];
								//$strSH_COM_CREDIT_GRADE = $row[$di]['SH_COM_CREDIT_GRADE'];
								//$strSH_COM_SALE_GRADE	= $row[$di]['SH_COM_SALE_GRADE'];
								//$strSH_COM_LOCUS_GRADE	= $row[$di]['SH_COM_LOCUS_GRADE'];
								//$strSH_COM_COUNTRY		= $row[$di]['SH_COM_COUNTRY'];

								$strP_CATE		= substr($row[$di]['P_CATE'],0,3);


								if ($strSearchHCode1){
									$cateMgr->setC_CODE($strSearchHCode1);
									$strSearchHCodeName1 = $cateMgr->getCateLevelName($db);

									//카테고리별 관련 상품
									//$aryProdCateSellList = $productMgr->getProdCateSellList($db);
								}

								/* 상품 옵션 */
								//$viewProductMgr->setP_LNG($S_SITE_LNG);
								//$cateMgr->setCL_LNG($S_SITE_LNG);

								$viewProductMgr->setP_CODE($strViewP_CODE);
								$viewProductMgr->setPO_TYPE("O");
								$aryViewProdOpt = $viewProductMgr->getProdOpt($db);

								if (is_array($aryViewProdOpt)){
									for($g=0;$g<sizeof($aryViewProdOpt);$g++){
										if ($aryViewProdOpt[$g][PO_NO] > 0){
											$viewProductMgr->setPO_NO($aryViewProdOpt[$g][PO_NO]);

											/* 다중가격사용안함.다중가격분리형 */
											$aryViewProdOpt[$g]["OPT_ATTR1"] = $viewProductMgr->getProdOptAttrGroup($db);

											/* 다중각격분리형 */
											$aryViewProdOpt[$g]["OPT_ATTR_ALL"] = $viewProductMgr->getProdOptAttr($db);
										}
									}
								}

								/* 상품 추가 옵션*/
								if ($prodRow[P_ADD_OPT] == "Y"){
									$productMgr->setPO_TYPE("A");
									$aryViewProdAddOpt = $viewProductMgr->getProdOpt($db);
									if (is_array($aryViewProdAddOpt)){
										for($h=0;$h<sizeof($aryViewProdAddOpt);$h++){
											if ($aryViewProdAddOpt[$h][PO_NO] > 0){
												$viewProductMgr->setPO_NO($aryViewProdAddOpt[$h][PO_NO]);

												$aryViewProdAddOpt[$h][OPT_ATTR] = $viewProductMgr->getProdAddOpt($db);
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

								## 색상 설정
								$aryP_COLOR_IMG = "";
								if($strP_COLOR && $strShow6):
									$aryP_COLOR = explode("|", $strP_COLOR);
									foreach($aryP_COLOR as $key => $val):
										if($val != "Y") { continue; }
										if($S_ARY_PROD_COLOR[$key]['USE'] != "Y") { continue; }
										$aryP_COLOR_IMG[] = $S_ARY_PROD_COLOR[$key]['IMG'];
									endforeach;
								endif;

								## 적립금 설정
								$intProdPoint = getProdPoint($intViewP_SALE_PRICE, $intViewP_POINT, $strViewP_POINT_TYPE, $strViewP_POINT_OFF1, $strViewP_POINT_OFF2);

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
								$strTextPrice = '<strong>' . getProdDiscountPrice($row[$di]) . '</strong>';
								$strTextPrice = $strMoneyIconL . $strTextPrice ;

								if($strViewP_PRICE_FILTER=='FOB'){
								$strTextPrice = getCurMark("$").$strTextPrice;
								}else{
								$strTextPrice .= $strMoneyIconR;
								}

								if($S_ARY_CUR[$S_SITE_LNG]["USD"][2] == "Y") { $strTextPriceUsd = getCurMark("$") . getProdDiscountPrice($row[$di],"1",0,"US") . getCurMark2("USD"); }
								if($strP_PRICE_TEXT) { $strTextPrice = $strP_PRICE_TEXT; }

								## 이미지 설정
								if(!$strViewPM_REAL_NAME) { $strViewPM_REAL_NAME = "/himg/product/A0001/no_img.gif"; }

								## 마우스 오버시 변경 이미지 설정
								$strViewOverImage = "";
								if($strTurnUse == "Y" && $strViewPM_REAL_NAME2):
									$strViewOverImage = " overImg='{$strPM_REAL_NAME2}'";
								endif;

								## 리스트 이미지를 동영상으로 보이게 하며 특정 카테고리에서만 동영상이 보이도록 처리
								$strProdMovieUrl = "";
								if($S_FIX_PROD_VIEW_MOVIE_FLAG == "Y" && !in_array(SUBSTR($row[$di]['P_CATE'],0,3),$S_FIX_PROD_VIEW_MOVIE_CATE_NOT_LIST)):
									$productMgr->setP_CODE($strP_CODE);
									$productMgr->setPM_TYPE("movie1");
									$prodMovieRow = $productMgr->getProdImg($db);
									$strProdMovieUrl = $prodMovieRow[0]['PM_REAL_NAME'];
								endif;

								## 이벤트 정보
								$strViewEvent = "";
								if($strViewP_EVENT > 0 && getProdEventInfo($row[$di]) == "Y"):
									if($S_EVENT_INFO[$strViewP_EVENT]["PRICE_TYPE"] == "1"):
										$strViewEvent = $S_EVENT_INFO[$row[$di][P_EVENT]]["PRICE_MARK"];
									endif;
								endif;

								## 아이콘 설정
								$iconTag = "";
								$icon = explode("/", $strP_LIST_ICON);
								for($x=0; $x<sizeof($icon); $x++):
									$iconTag .= $S_ARY_PRODUCT_LIST_ICON[$icon[$x]];
								endfor;

								## 상품명 설정
								$strViewP_NAME = strHanCutUtf2($strViewP_NAME, $intTitleMaxsize, "N");

								## 평점 설정
								$intViewGrade = 0;
								if($intViewP_GRADE && $intViewP_GRADE_CNT){
									$intViewGrade = $intViewP_GRADE / $intViewP_GRADE_CNT;
								}


								## td style 설정
								$strStyleTD = "";
								if($j==($intWList-1)) { $strStyleTD = "width:{$intWSize}px"; }

								## div class 설정
								$strClassDiv = "productInfoWrap";
								if($j==($intWList-1)) { $strClassDiv .= " endProdList"; }

								## div style 설정
								$strStyleDiv = "width:{$intWSize}px;text-align:{$strWAlign}";


								## 판매가 할인율
								$intProdDiscountRate	= 0;
								if ($S_FIX_PRODUCT_DISCOUNT_RATE_SHOW == "Y"){
									if($row[$key]['P_CONSUMER_PRICE'] > 0.00001){
									$intProdDiscountRate= getRoundUp((($row[$di]['P_CONSUMER_PRICE'] - $row[$di]['P_SALE_PRICE'])/$row[$di]['P_CONSUMER_PRICE']) * 100,0);
									$strProdDiscountRateText = "<strong class='discountRate'>".$intProdDiscountRate."</strong><span class='rateSign'>%</span>";
									}
								}

								## 무료배송아이콘표시
								$strProdFreeDeliveryText = "";
								if ($S_FIX_PRODUCT_FREE_DELIVERY_SHOW == "Y"){
									if ($strP_BAESONG_TYPE == "2"){
										$strProdFreeDeliveryText = "무료배송";
									}
								}

								## 2015.02.09 kim hee sung
								## 상품가격 출력 설정
								##  관리자페이지 > 기본설정 > 주문및결제관리 > 상품가격노출 사용시 해당 그룹 회원에게만 가격 노출합니다.
								if($isPriceHide):
									$strProdDiscountRateText = '';
									$strTextPrice = '';
									$intProdPointMoney = '';
									$strTextConsumerPrice = '';
									$strTextConsumerPriceUsd = '';
								endif;
							?>
								<table class="productInfoWrap">
									<tr>
										<td colspan="2" class="titBox">
											<a href="javascript:goProdView('<?php echo $strViewP_CODE;?>');"><?=$strViewP_NAME?></a>
										</td>
									</tr>
									<tr>
										<td class="prodImgWrap">
											<a href="javascript:goProdView('<?php echo $strViewP_CODE;?>');"><img src="<?php echo $strViewPM_REAL_NAME;?>" class="listProdImg"/></a>
											<!--div class="icoWrap">
												<img src="/upload/images/ico_list_star1.png"> <span class="ico_wish">담아두기</span>
												<img src="/upload/images/ico_list_chk1.png"> <span class="ico_chk">비교하기</span>
											</div-->
										</td>

										<td class="prodInfoWrap">
											<ul class="prodInfo1"><?php echo $aryCategory;?>
												<li><span><?= $LNG_TRANS_CHAR["PW00028"]; //원산지 ?></span><?php echo $aryCountryList[$strViewP_ORIGIN]?></li>
												<li><span><?= $LNG_TRANS_CHAR["CW00064"]; //카테고리 ?></span><?php echo $aryCateNames[$strP_CATE]?></li>
											</ul>
											<ul class="addINfo">
												<li class="option"><span><?= $LNG_TRANS_CHAR["PW00081"]; //가격 ?></span><?
														if($strShow5 == "Y") {
															if($strTextPriceUsd) {
																echo $strTextPrice; // 가격
																echo ' / ';
																echo $strTextPriceUsd; // USD 달러
															}
															else {
																echo $strTextPrice;// 가격
															}
															if($strViewP_PRICE_UNIT){
																echo '(1';
																echo $strViewP_PRICE_UNIT;
																echo ' 당)';
															}
														}
													?>
												</li>
												<!--<li><span>CAS No.</span><?php echo $strP_CAS_NO?></li>-->
												<li class="packing"><?
													if ($row[$di][P_OPT] == "1" || $row[$di][P_OPT] == "3"){

														/* 다중가격사용안함 */

														if (is_array($aryViewProdOpt)){
														$strViewProdOpt = "<span class=\"w_20\">";
														$strViewProdOpt .= $aryViewProdOpt[0]["PO_NAME1"];
														$strViewProdOpt .= "</span>";
														//echo sizeof($aryProdOpt[0]["OPT_ATTR1"]);
															for($r=0;$r < sizeof($aryViewProdOpt[0]["OPT_ATTR1"]);$r++){
																$strViewProdOpt .= " ".$aryViewProdOpt[0]["OPT_ATTR1"][$r][POA_ATTR1];
															} //->for

															echo $strViewProdOpt;
														} //->if

													} else if ($prodRow[P_OPT] == "2") {
														/* 다중가격일체형 */

														if (is_array($aryViewProdOpt)){

															for($r=0;$r<sizeof($aryViewProdOpt);$r++){
																?>
																	<tr>
																		<th><?=$LNG_TRANS_CHAR["PW00010"] //옵션선택?></th>
																		<td>
																		<select id="cartOpt1_<?=$aryViewProdOpt[$r][PO_NO]?>" name="cartOpt1_<?=$aryViewProdOpt[$r][PO_NO]?>" onchange="javascript:goSelectProdOpt('cartOpt1_<?=$aryViewProdOpt[$r][PO_NO]?>');">
																			<option value="">:: <?=($aryViewProdOpt[$r][PO_ESS]=="Y")?$LNG_TRANS_CHAR["PW00009"]:$LNG_TRANS_CHAR["PW00010"]; //필수선택:선택?> ::</option>
																			<?
																				if (is_array($aryViewProdOpt[$r][OPT_ATTR_ALL])){
																					for($p=0;$p<sizeof($aryViewProdOpt[$r][OPT_ATTR_ALL]);$p++){

																						$strViewProdOptAttr = "";
																						for($kk=1;$kk<=10;$kk++){
																							if ($aryViewProdOpt[$r]["PO_NAME".$kk]){
																								$strViewProdOptAttr .= "/".$aryViewProdOpt[$i][OPT_ATTR_ALL][$p]["POA_ATTR".$kk];
																							}
																						}

																						$strViewProdOptAttr = SUBSTR($strViewProdOptAttr,1);

																						## 품절표시
																						$strViewProdOptAttrSoldOut = ($prodRow['P_STOCK_LIMIT'] != "Y") ? "(".$LNG_TRANS_CHAR["PW00053"].":".$aryViewProdOpt[$r]['OPT_ATTR_ALL'][$p]['POA_STOCK_QTY'].")" : "";
																						if (($prodRow['P_STOCK_OUT'] == "Y") || ($aryViewProdOpt[$r]['OPT_ATTR_ALL'][$p]['POA_STOCK_QTY'] == 0 && ($prodRow['P_STOCK_LIMIT'] != "Y"))) $strViewProdOptAttrSoldOut = "(".$LNG_TRANS_CHAR["PW00052"].")";
																			?>
																			<option value="<?=$aryViewProdOpt[$r][OPT_ATTR_ALL][$p][POA_NO]?>"><?=$strViewProdOptAttr?><?=$strViewProdOptAttrSoldOut?></option>
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
													?>
												</li>
												<li class="cnt"><span class="w_93">최소구매수량</span><?php echo $strViewP_MIN_QTY?></li>
											</ul>
										</td>
									</tr>
								</table>
							<? endif; ?>
							</td>
							<? }	?>
						</tr>
						<? if($intListNum <= $k) { break; } ?>
						<? } ?>
					</table>
					<?if ($strProdListAllView != "Y"){?>
					<div id="pagenate">
						<?=drawPaging($intPage,$intPageLine,$intPageBlock,$intTotal,$intTotPage,$linkPage,"","","","","")?>
					</div>
					<? if ( $S_SHOP_MORE_VIEW_USE == 'Y' && $intTotPage > 1 ) { ?><a href="<?=$_SERVER['PHP_SELF']?>&page=2" id="btnProductMore" class="btnProductMore">더보기</a><? } ?>
					<?}?>

				</div>
				<!-- End list view -->

			</div>

			<div class="clr"></div>
		</div>
	</div>
</div>
