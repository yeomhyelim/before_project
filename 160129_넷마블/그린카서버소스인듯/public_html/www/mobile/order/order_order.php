<?php
	
	## 언어 설정
	$strLang = $S_SITE_LNG;
	$strLangLower = strtolower($strLang);

?>
		<!--<div class="regStepWrap">
			<ul>
				<li class="step_1">
					<span><?=$LNG_TRANS_CHAR["PW00022"] //장바구니?></span>
					<div class="stepIco"></div>
				</li>
				<li class="step_2 stepOn">
					<span><?=$LNG_TRANS_CHAR["CW00079"]//구매신청서?></span>
					<div class="stepIcoOn"></div>
				</li>
				<li class="step_3">
					<span><?=$LNG_TRANS_CHAR["CW00019"] //구매완료?></span>
				</li>
			</ul>
			<div class="clr"></div>
		</div>-->

		<h2><?=$LNG_TRANS_CHAR["CW00079"]//구매신청서?></h2>

		<!-- 장바구니 시작 -->
			<?include MALL_MOB_PATH."order/orderCartList.inc.php";?>
		<!-- 장바구니 끝 -->

		<!-- 고객사은품 시작 -->
			<?include MALL_MOB_PATH."order/orderGiftList.inc.php";?>
		<!-- 고객사은품 끝 -->


		<!-- 개인정보 수집동의(비회원 주문시 적용) -->
		<?if (!$g_member_no){?>
		<div class=" mt20">
			<!-- 개인정보동의 -->
				<div class="titBox"><span class="barRed"></span><span class="tit"><?=$LNG_TRANS_CHAR["MW00042"] //개인정보보호정책?></span></div>
				<div class="agreeWrap">
					<span class="txtInfo"><?=$LNG_TRANS_CHAR["OS00036"] //비회원 주문에 대한 개인정보 수집에 대한 동의 (자세한 내용은 “개인정보취급방침”을 확인하시기 바랍니다)?></span>
					
					<div class="policyForm">						
						<?include MALL_SHOP . "/conf/policy.person.{$strLangLower}.inc.php";?>
					</div>
					<div class="btnCenter">
						<input type="radio" id="agreeYN" name="agreeYN" value="Y"/> <?=$LNG_TRANS_CHAR["OS00037"] //동의합니다.?>
						<input type="radio" id="agreeYN" name="agreeYN" value="N" checked/> <?=$LNG_TRANS_CHAR["OS00038"] //동의 하지 않습니다.?>
					</div>
				</div>
			<!-- 개인정보동의 -->			
		</div>
		<!-- 개인정보 수집동의(비회원 주문시 적용) -->
		<?}?>
		<?
			if ($S_SITE_LNG == "KR"){
				include "orderInfoInput.inc.php";
			}else {
				include "orderInfoInput.for.inc.php";
			}
		?>

		<!-- (3) 결제방법 정보 -->
		<div class="tableOrderForm mt30">
			<div class="titBox"><span class="barRed"></span><span class="tit"><?=$LNG_TRANS_CHAR["OW00093"] //결제 정보?></span></div>
			<div class="tableBox">
				<table class="tableFormType">
					<?if ($S_SITE_LNG == "KR"){?>
					<tr>
						<th><?=$LNG_TRANS_CHAR["OW00030"] //결제방법?></th>
						<td>
							<ul>
								<?if ($intSiteSettleC == "Y"){?>
									<li><input type="radio" id="settle" name="settle" value="C" checked onclick="javascript:goSettle();"/> <?=$LNG_TRANS_CHAR["OW00033"] //카드결제?></li>
								<?}?>
								<?if ($intSiteSettleA == "Y"){?>
									<li><input type="radio" id="settle" name="settle" value="A" onclick="javascript:goSettle();"/> <?=$LNG_TRANS_CHAR["OW00034"] //실시간 계좌이체?></li>
								<?}?>
								<?if ($intSiteSettleT == "Y"){?>
									<li><input type="radio" id="settle" name="settle" value="T" onclick="javascript:goSettle();"/> <?=$LNG_TRANS_CHAR["OW00035"] //가상계좌?></li>
								<?}?>
								<?if ($intSiteSettleB == "Y"){?>
									<li><input type="radio" id="settle" name="settle" value="B" onclick="javascript:goSettle();"/> <?=$LNG_TRANS_CHAR["OW00031"] //무통장입금?></li>
								<?}?>

								<!--
								<?if ($intSiteSettleM == "Y"){?>
									<li><input type="radio" id="settle" name="settle" value="M" onclick="javascript:goSettle();"/><?=$LNG_TRANS_CHAR["OW00110"] //휴대폰?></li>
								<?}?>
								-->
							</ul>
						</td>
					</tr>
					<tr id="trBankInfo" class="trBankInfo" style="display:none">
						<th><?=$LNG_TRANS_CHAR["OW00031"] //무통장입금?></th>
						<td>
							<p class="infoTitTxt"><?=$LNG_TRANS_CHAR["OW00037"] //입금은행?></p>
							<?=drawSelectBoxMore("settle_bank_code",$arySiteSettleBank,"",$design ="defSelect",$onchange="",$etc="style='width:100%;/*background:none;*/'","::".$LNG_TRANS_CHAR['OW00036']."::",$html="N")?>
							<!--
							<?=drawSelectBoxMore("input_bank_code",$aryBank,"",$design ="defSelect",$onchange="",$etc="","::".$LNG_TRANS_CHAR['OW00037']."::",$html="N")?>
							//-->
							<p class="infoTitTxt"><?=$LNG_TRANS_CHAR["OW00024"] //입금자명?><input type="text" id="input_bank_name" name="input_bank_name" class="i_w" maxlength="20" value="<?=$strJName?>"/></p>

							<?if ($S_SITE_LNG == "KRR"){?>
								<p><input type="checkbox" name="cash_yn" id="cash_yn" value="Y"> 현금영수증신청</p>
								<div id="divCash" style="display:none">
									<br>
									<select name="cashMth" id="cashMth">
										<option value="">발급방법</option>
										<option value="1" selected>휴대폰</option>
										<option value="2">카드번호</option>
									</select>
									<span id="divCashHp">
										<?=drawSelectBoxMore("cash_hp1",$aryHp,"",$design ="defSelect",$onchange="",$etc="",$firstItem="",$html="N")?>
										<input type="tel" id="cash_hp2" name="cash_hp2" class="i_tel" maxlength="4"/> -
										<input type="tel" id="cash_hp3" name="cash_hp3" class="i_tel" maxlength="4"/>
									</span>
									<span id="divCashNo" style="display:none">
										<input type="tel" id="cash_no1" name="cash_no1" class="i_tel" maxlength="4"/> - 
										<input type="tel" id="cash_no2" name="cash_no2" class="i_tel" maxlength="4"/> - 
										<input type="tel" id="cash_no3" name="cash_no3" class="i_tel" maxlength="4"/> - 
										<input type="tel" id="cash_no4" name="cash_no4" class="i_tel" maxlength="6"/>
									</span>
								</div>
							<?}?>
						</td>
					</tr>
					<?} else {?>
					<tr>
						<th><?=$LNG_TRANS_CHAR["OW00030"] //결제방법?></th>
						<td>
							<?if ($intSiteSettleForB == "Y"){?>
							<input type="radio" id="settle" name="settle" value="B" onclick="javascript:goSettle();"/><?=$LNG_TRANS_CHAR["OW00031"] //무통장입금?><br />
							<?}?>
							<?if ($intSiteSettleY == "Y"){?>
							<input type="radio" id="settle" name="settle" value="Y" checked onclick="javascript:goSettle();"/>Paypal<br />
							<?}?>
							<?if ($intSiteSettleX == "Y"){?>
							<input type="radio" id="settle" name="settle" value="X" onclick="javascript:goSettle();"/>EximBay<br />
							<?}?>
						</td>
					</tr>
					<tr id="trBankInfo" style="display:none">
						<th><?=$LNG_TRANS_CHAR["OW00031"] //무통장입금?></th>
						<td>
							<?=drawSelectBoxMore("settle_bank_code",$arySiteForSettleBank,"",$design ="defSelect",$onchange="",$etc="","::".$LNG_TRANS_CHAR['OW00036']."::",$html="N")?>
							<!-- <?=drawSelectBoxMore("input_bank_code",$aryBank,"",$design ="defSelect",$onchange="",$etc="","::".$LNG_TRANS_CHAR['OW00037']."::",$html="N")?> //-->
							<span class="inBankName"><?=$LNG_TRANS_CHAR["OW00024"] //입금자명?> : <input type="input" id="input_bank_name" name="input_bank_name" class="defInput _w100" maxlength="20" value="<?=$strJName?>"/></span>
							<div class="bankInfoTxt"></div>
						</td>
					</tr>
					<?}?>
					<?if ($g_member_no && $S_POINT_USE1 == "Y"){?>
					<tr>
						<th><?=$LNG_TRANS_CHAR["OW00032"] //적립포인트?></th>
						<td><span id="spanOrderAddPoint"><?=getCurMark()?> <?=getCurToPrice($intCartPointTotal)?></span>
						<input type="hidden" name="savePointTotal" id="savePointTotal" value="<?=$intCartPointTotal?>">
						</td>
					</tr>
					<?}?>
				</table>
			</div>
		</div>
		<!-- tableOrderForm -->
		<!-- (3) 결제방법 정보 -->

		<!-- (4) 결제내역 정보 -->
		<div class="tableOrderForm">
			<div class="titBox"><span class="barRed"></span><span class="tit"><?=$LNG_TRANS_CHAR["OW00094"] //결제 내역?></span></div>
				<div class="topalPriceInfoList">
					<ul class="priceInfo">
						<li>
							<span class="title"><?=$LNG_TRANS_CHAR["OW00051"] //상품가격?></span>
							<span class="valueTxt">
								<?=$strPriceLeftMark?> <strong><?=$strCartPriceTotalText?></strong><?=$strPriceRightMark?><?=$strCartPriceTotalOrgText?>
							</span>
							<div class="clr"></div>
						</li>
						<?if ($S_SITE_TAX == "Y"){?>
						<li>
							<span class="title"><?=$LNG_TRANS_CHAR["OW00008"] //부과세?></span>
							<span class="valueTxt">
								<?=$strPriceLeftMark?> <strong><?=$strCartPriceTotalTaxText?><?=$strPriceRightMark?></strong><?=$strCartPriceTotalTaxOrgText?>
							</span>
							<div class="clr"></div></li>
						<?}?>
						<?if ($S_SITE_LNG == "KR" && ($S_DELIVERY_MTH == "N" || !$S_DELIVERY_MTH)){?>
						<li>
							<span class="title"><?=$LNG_TRANS_CHAR["PW00012"] //배송비?></span>
							<span class="valueTxt">
								<?=$strPriceLeftMark?> <strong class="toPayDeliveryPrice"><?=$strCartDeliveryTotalText?></strong><?=$strPriceRightMark?>
							</span><div class="clr"></div></li>
						<?} else if ($S_SITE_LNG == "KR" && $S_DELIVERY_MTH == "G") {
							?>
							<li>
								<span class="title"><?=$LNG_TRANS_CHAR["PW00012"] //배송비?></span>
								<span class="valueTxt"></span><div class="clr"></div>
						<?} else if ($S_SITE_LNG != "KR" && $S_DELIVERY_FOR_MTH == "W") {
							?>
							<li>
								<span class="title"><?=$LNG_TRANS_CHAR["OW00044"] //배송방법?></span>
								<span class="valueTxt">
									<select name="deliveryWeightMethod" id="deliveryWeightMethod" style="width: 170px;">
										<option value="">:::<?=$LNG_TRANS_CHAR["OW00044"]?>:::</option>
									</select>
								</span>
								<div class="clr"></div>
							</li>
							<li>
								<span class="title"><?=$LNG_TRANS_CHAR["PW00012"] //배송비?></span>
								<span class="valueTxt">
									<?=$strPriceLeftMark?> <strong id="txtDeliveryPrice">0</strong><?=$strPriceRightMark?>
									<?if ($S_ARY_CUR[$S_SITE_LNG]["USD"][2] == "Y"){?>(<?=$S_SITE_CUR_MARK1?><span id="txtDeliveryOrgPrice">0</span>)<?}?>
								</span><div class="clr"></div>
							</li>
						<?}?>

						<li class="totMemDiscountPrice" style="display:none">
						</li>
						<li class="orderTotalPrice">
							<span class="title"><?=$LNG_TRANS_CHAR["OW00009"] //결제총액?></span>   
							<span class="valueTxt">
								<?=$strPriceLeftMark?> <strong class="totPrice"><?=$strCartPriceEndTotalText?></strong><?=$strPriceRightMark?>
								<?if($strCartPriceEndTotalOrgText){?>(<?=$S_SITE_CUR_MARK1?><?=$strCartPriceEndTotalOrgText?>)<?}?>
							</span>
							<div class="clr"></div>
						</li>
					</ul>
				</div>
				<table class="tableFormType">
					<?if ($g_member_no && $intMemberUsePointTotal >= $S_POINT_MIN && $S_POINT_USE1 == "Y"){?>
					<?
						if ($intCartPointUsePrice == 0 && $intCartPointNoUseCnt > 0 && $intCartPointNoUsePrice > 0){
						}else{
					?>
					<tr>
						<th><?=$LNG_TRANS_CHAR["OW00045"] //사용포인트?></th>
						<td><input type="tel" id="use_point" name="use_point" class="i_85"/> <?=getCurMark2()?>  <div><?=callLangTrans($LNG_TRANS_CHAR["OS00040"],array(getCurToPrice($intMemberUsePointTotal))) //getCurToPrice($intMemberUsePointTotal)의 포인트가 있습니다. 사용할 금액을 입력해 주세요.?></div>
						<!-- a href="javascript:goPopCounponList();" class="btn_Coupon"><?=$LNG_TRANS_CHAR["OW00115"]//포인트사용?></a -->
						</td>
					</tr>
					<?}}?>
					<?if ($S_COUPON_USE == "Y"){?>
					<tr>
						<th><?=$LNG_TRANS_CHAR["OW00073"] //쿠폰할인?></th>
						<td>
							<input type="text" id="use_coupon" name="use_coupon" class="i_w85" readonly/> <?=getCurMark2()?> 
							<a href="javascript:goPopCounponList();" class="btn_Coupon"><?=$LNG_TRANS_CHAR["OW00074"] //쿠폰적용?></a>
						</td>
					</tr>
					<?}?>
					<!--
					<tr>
						<th>쿠폰</th>
						<td><input type="text" name="" class="defInput _w150"/> <a href="#"><img src="../himg/<?=$D_LAYOUT_HIMG?>/product/btn_pop_coupon.gif"/></a></td>
					</tr>//-->
				</table>
			</div>
			<!-- tableOrderForm -->
			<!-- (4) 결제내역 정보 -->
			<div class="orderBtnwWrap" id="display_pay_button">
				<a href="javascript:goOrderAct();" class="payBigBtn btn_red" id="btnOrderBuy"><?=$LNG_TRANS_CHAR["OW00095"] //결제하기?></a>
				<a href="javascript:goOrderCancel();" class="cancelBigBtn btn_gray"><?=$LNG_TRANS_CHAR["MW00044"] //취소?></a>
			</div>
<?
	if ($S_SITE_LNG == "KR"){
		include "orderSettle.inc.php";
	}else {
		include "orderSettle.for.inc.php";
	}
?>
		<!-- 쿠폰 적용 번호 가지고 오기 -->
		<div id="divCouponParam">
		</div>
		<!-- 쿠폰 적용 번호 가지고 오기 -->
<script type="text/javascript">
<!--
	intOrderTotalSPriceOrg		= "<?=getCurToPriceSave($intCartPriceEndTotal)?>";			//상품총가격
	intOrderTotalDeliveryPrice	= "<?=getCurToPriceSave($intDeliveryTotal)?>";	//배송가격

	intOrderPointUsePrice		= document.form.good_point_use.value;   //포인트결제가능한금액
	intOrderPointNoUseCnt		= document.form.good_point_no_use_cnt.value;
	intOrderPointNoUsePrice		= document.form.good_point_no_use.value;

//-->
</script>