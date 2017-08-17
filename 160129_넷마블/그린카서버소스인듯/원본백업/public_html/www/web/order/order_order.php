<!-- 장바구니 시작 -->
<?include "orderCartList.inc.php";?>
<!-- 장바구니 끝 -->

<!-- 고객사은품 시작 -->
<?include "orderGiftList.inc.php";?>
<!-- 고객사은품 끝 -->


<!-- 개인정보 수집동의(비회원 주문시 적용) -->
		<?if (!$g_member_no){?>
		<div class="orderAgreeWrap mt20">
			<!-- 개인정보동의 -->
				<h4 class="orderTit_0"><span><?=$LNG_TRANS_CHAR["MW00042"] //개인정보보호정책?></span></h4>
				<span class="txtInfo"><?=$LNG_TRANS_CHAR["OS00036"] //비회원 주문에 대한 개인정보 수집에 대한 동의 (자세한 내용은 “개인정보취급방침”을 확인하시기 바랍니다)?></span>

				<div class="policyForm">
					<?include "../conf/policy.person.".strtolower($S_SITE_LNG).".inc.php";?>
				</div>
				<div class="btnCenter">
					<input type="radio" id="agreeYN" name="agreeYN" value="Y"/> <?=$LNG_TRANS_CHAR["OS00037"] //동의합니다.?>
					<input type="radio" id="agreeYN" name="agreeYN" value="N" checked/> <?=$LNG_TRANS_CHAR["OS00038"] //동의 하지 않습니다.?>
				</div>
			<!-- 개인정보동의 -->
		</div>
		<!-- 개인정보 수집동의(비회원 주문시 적용) -->
		<?}?>
		<?
			// 한국 통관정책 사용(DCPRICE)
			if ($S_ORDER_KOREA_SHIPPING_POLICY_USE == "Y"){
				include "orderInfoInput.crn.inc.php";
			}

			if ($S_SITE_LNG == "KR"){
				include "orderInfoInput.inc.php";
			}else {
				include "orderInfoInput.for.inc.php";
			}
		?>

		<!-- (3) 결제방법 정보 -->
		<div class="tableOrderForm mt30">
			<h4 class="orderTit_1"><span><?=$LNG_TRANS_CHAR["OW00093"] //결제 정보?></span></h4>
			<table>
				<colgroup>
					<col style="width:100px;"/>
					<col/>
				</colgroup>
				<?if ($S_SITE_LNG == "KR"){?>
				<tr>
					<th><?=$LNG_TRANS_CHAR["OW00030"] //결제방법?></th>
					<td>
						<?if ($intSiteSettleX == "Y"){?>
						<input type="radio" id="settle" name="settle" value="X" onclick="javascript:goSettle();" checked/>카드결제(EximBay)
						<?}?>

						<?if ($S_PG != "X"){?>
							<?if ($intSiteSettleC == "Y"){?>
							<input type="radio" id="settle" name="settle" value="C" checked onclick="javascript:goSettle();"/><?=$LNG_TRANS_CHAR["OW00033"] //카드결제?>
							<?}?>
							<?if ($intSiteSettleA == "Y"){?>
							<input type="radio" id="settle" name="settle" value="A" onclick="javascript:goSettle();"/><?=$LNG_TRANS_CHAR["OW00034"] //실시간 계좌이체?>
							<?}?>
							<?if ($intSiteSettleT == "Y"){?>
							<input type="radio" id="settle" name="settle" value="T" onclick="javascript:goSettle();"/><?=$LNG_TRANS_CHAR["OW00035"] //가상계좌?>
							<?}?>
							<?if ($intSiteSettleM == "Y"){?>
							<!--<input type="radio" id="settle" name="settle" value="M" onclick="javascript:goSettle();"/><?=$LNG_TRANS_CHAR["OW00110"] //휴대폰?>-->
							<?}?>
						<?}?>

						<?if ($intSiteSettleB == "Y"){?>
						<input type="radio" id="settle" name="settle" value="B" onclick="javascript:goSettle();"/><?=$LNG_TRANS_CHAR["OW00031"] //무통장입금?>
						<?}?>
					</td>
				</tr>
				<tr id="trBankInfo" style="display:none">
					<th><?=$LNG_TRANS_CHAR["OW00031"] //무통장입금?></th>
					<td>
						<?=drawSelectBoxMore("settle_bank_code",$arySiteSettleBank,"",$design ="defSelect",$onchange="",$etc="","::".$LNG_TRANS_CHAR['OW00036']."::",$html="N")?>
						<!--
						<?=drawSelectBoxMore("input_bank_code",$aryBank,"",$design ="defSelect",$onchange="",$etc="","::".$LNG_TRANS_CHAR['OW00037']."::",$html="N")?>
						//-->
						<span class="inBankName"><?=$LNG_TRANS_CHAR["OW00024"] //입금자명?> : <input type="input" id="input_bank_name" name="input_bank_name" class="defInput _w100" maxlength="20" value="<?=$strJName?>"/></span>

						<?if ($S_SITE_LNG == "KR" && (!$S_ORDER_CASH_RECEIPT || $S_ORDER_CASH_RECEIPT == "Y")){?>
							<span class="cash_Rpt"><input type="checkbox" name="cash_yn_site" id="cash_yn_site" value="Y"> 현금영수증신청</span>
							<div id="divCash" style="display:none">
								<br>
								<select name="cashMth" id="cashMth">
									<option value="">발급방법</option>
									<option value="1" selected>휴대폰</option>
									<option value="2">카드번호</option>
									<option value="3">지출증빙용</option>
								</select>
								<span id="divCashHp">
									<?=drawSelectBoxMore("cash_hp1",$aryHp,"",$design ="defSelect",$onchange="",$etc="",$firstItem="",$html="N")?>
									<input type="input" id="cash_hp2" name="cash_hp2" class="defInput _w50" maxlength="4"/> -
									<input type="input" id="cash_hp3" name="cash_hp3" class="defInput _w50" maxlength="4"/>
								</span>
								<span id="divCashNo" style="display:none">
									<input type="input" id="cash_no1" name="cash_no1" class="defInput _w50" maxlength="4"/> -
									<input type="input" id="cash_no2" name="cash_no2" class="defInput _w50" maxlength="4"/> -
									<input type="input" id="cash_no3" name="cash_no3" class="defInput _w50" maxlength="4"/> -
									<input type="input" id="cash_no4" name="cash_no4" class="defInput _w50" maxlength="6"/>
								</span>
								<span id="divCashBiz" style="display:none">
									<input type="input" id="cash_biz1" name="cash_biz1" class="defInput _w50" maxlength="3"/> -
									<input type="input" id="cash_biz2" name="cash_biz2" class="defInput _w50" maxlength="2"/> -
									<input type="input" id="cash_biz3" name="cash_biz3" class="defInput _w50" maxlength="5"/>
								</span>
							</div>
						<?}?>
					</td>
				</tr>
				<tr id="trEscrowInfo" style="display:none">
					<td colspan="2">
						5일이내 입금이 되지 않으면 주문이 자동 취소됩니다.
					</td>
				</tr>
				<?} else {?>
				<tr>
					<th><?=$LNG_TRANS_CHAR["OW00030"] //결제방법?></th>
					<td>
						<?if ($intSiteSettleForB == "Y"){?>
						<input type="radio" id="settle" name="settle" value="B" onclick="javascript:goSettle();"/><?=$LNG_TRANS_CHAR["OW00031"] //무통장입금?>
						<?}?>
						<?if ($intSiteSettleY == "Y"){?>
						<input type="radio" id="settle" name="settle" value="Y" checked onclick="javascript:goSettle();"/>Paypal
						<?}?>
						<?if ($intSiteSettleX == "Y"){?>
						<input type="radio" id="settle" name="settle" value="X" onclick="javascript:goSettle();"/>EximBay
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
					<td><?=getCurMark()?> <span id="spanOrderAddPoint"><?=getCurToPrice($intCartPointTotal)?></span> P
					<input type="hidden" name="savePointTotal" id="savePointTotal" value="<?=$intCartPointTotal?>">
					</td>
				</tr>
				<?}?>
			</table>

			<?if ($S_SITE_LNG != "KR"){?>
				<!-- 엑심베이(중국어) 결제 사용시 안내 -->
				<div class="eximbayTxtInfo" style="display:none" id="divEximbayTextCN">
					<ul>
						<li class="tit">购买商品时 商品价与运费单独收取 </li>
						<li>EXIMBAY支持印有 支付宝， 银联， 快钱， 支付通， Visa(维萨)， Master card(万事达)， American Express(美国运通), <br>标志的信用卡进行支付(包括国内发行的信用卡）。</li>
						<li class="payInfoImg"><img src="/himg/common/pay_m_alipay_CN.gif"></li>
						<li>
							EXIMBAY是代理网店处理支付事宜的代理支付公司，所以您的信用卡账单上会显示本公司的名称 信用卡付款时，需要支付“国外使用手续费”。取消付款及退款时，大概需要2周左右才能完成到账。另外，其内容反映到信用卡账单，根据账单生成日期，大概需要1~2个月。信用卡部分取消及退款时，其处理方式是重新支付未取消的金额并退还最初支付的全部金额，详细内容可在下个月的账单中确认
						</li>
					</ul>
				</div>
				<!-- 엑심베이(영문) 결제 사용시 안내 -->
				<div class="eximbayTxtInfo" style="display:none" id="divEximbayTextUS">
					<ul>
						<li class="tit">The product price and the shipping fee is separate. minimum amount required for these payment method is the remaining amount without shipping charge.</li>
						<li>EXIMBAY  this  are available credit card for payment use : Visa, Master card, American Express, JCB, Union</li>
						<li class="payInfoImg"><img src="/himg/common/pay_m_alipay_US.gif"></li>
						<li>
							EXIMBAY is a payment gateway company providing service to online stores that authorizes credit card payments. Therefore such transactions will be shown as EXIMBAY on your billing statement. When using credit card, international transaction fees will be charged by the issuing bank. When making international credit card transactions, a transaction fee may be charged by the issuing bank. In the case of cancellation and refund, it can take up to 2 weeks to be reflected in your account and depending on the billing date, it may take 1-2 months to be seen on your billing statement. In the case of a partial refund, the difference will be charged on your credit card and the original transaction will be cancelled for the purpose of the refund. The cancelled transaction will be listed in the billing statement on the following month or you may contact the issuing bank directly for more details.
						</li>
					</ul>
				</div>
			<?}?>
		</div>
		<!-- tableOrderForm -->
		<!-- (3) 결제방법 정보 -->

		<!-- (4) 결제내역 정보 -->
		<div class="tableOrderForm mt30">
			<h4 class="orderTit_1"><span><?=$LNG_TRANS_CHAR["OW00094"] //결제 내역?></span></h4>
			<table>
				<colgroup>
					<col style="width:100px;"/>
					<col/>
				</colgroup>
				<tr>
					<th><?=$LNG_TRANS_CHAR["OW00026"] //결제금액?></th>
					<td>
						<ul class="priceInfo">

							<li>
								<span><?=$LNG_TRANS_CHAR["OW00051"] //상품가격?></span>:
								<?=$strPriceLeftMark?> <strong><?=$strCartPriceTotalText?></strong><?=$strPriceRightMark?><?=$strCartPriceTotalOrgText?>
							</li>
							<?if ($S_SITE_TAX == "Y"){?>
							<li>
								<span><?=$LNG_TRANS_CHAR["OW00008"] //부과세?></span>:
								<?=$strPriceLeftMark?> <strong><?=$strCartPriceTotalTaxText?><?=$strPriceRightMark?></strong><?=$strCartPriceTotalTaxOrgText?>
							</li>
							<?}?>
							<?if ($S_PG_COMMISSION == "Y" && ($S_PG_CARD_COMMISSION > 0)){?>
							<li class="totOrderPgCommissionPrice" style="display:none">
							</li>
							<?}?>

							<?if (!$S_FIX_ORDER_DELIVERY_INFO_YN || $S_FIX_ORDER_DELIVERY_INFO_YN == "Y"){?>
							<?if ($S_SITE_LNG == "KR" && ($S_DELIVERY_MTH == "N" || !$S_DELIVERY_MTH)){?>
							<li>
								<span><?=$LNG_TRANS_CHAR["PW00012"] //배송비?></span>:
								<?=$strPriceLeftMark?> <strong class="toPayDeliveryPrice"><?=$strCartDeliveryTotalText?></strong><?=$strPriceRightMark?>
								<?if($strCartPriceEndTotalOrgText){?>(<?=$S_SITE_CUR_MARK1?><?=$strCartDeliveryTotalOrgText?>)<?}?>
							</li>
							<?} else if ($S_SITE_LNG == "KR" && $S_DELIVERY_MTH == "G") {
								?>
								<li>
									<span><?=$LNG_TRANS_CHAR["PW00012"] //배송비?></span>:
									<?=drawSelectBoxMore("deliveryGroupPrice",$aryDeliveryGroupPriceList,"",$design ="",$onchange="javascript:goTotalPriceCal();",$etc="",$LNG_TRANS_CHAR["OW00027"],$html="N")?>
								</li>
							<?} else if ($S_SITE_LNG != "KR" && ($S_DELIVERY_FOR_MTH == "W" || $S_DELIVERY_FOR_MTH == "B")) {
								?>
								<li>
									<span><?=$LNG_TRANS_CHAR["OW00044"] //배송방법?></span>:
									<select name="deliveryWeightMethod" id="deliveryWeightMethod">
										<option value="">:::<?=$LNG_TRANS_CHAR["OW00044"]?>:::</option>
									</select>
								</li>
								<li>
									<span><?=$LNG_TRANS_CHAR["PW00012"] //배송비?></span>:
									<?=$strPriceLeftMark?> <strong id="txtDeliveryPrice">0</strong><?=$strPriceRightMark?>
									<?if ($S_ARY_CUR[$S_SITE_LNG]["USD"][2] == "Y"){?>(<?=$S_SITE_CUR_MARK1?><span id="txtDeliveryOrgPrice">0</span>)<?}?>
								</li>
							<?} else if ($S_SITE_LNG != "KR" && $S_DELIVERY_FOR_MTH == "T") {
									?>
								<li>
									<span><?=$LNG_TRANS_CHAR["OW00044"] //배송방법?></span>:
									<select name="deliveryWeightMethod" id="deliveryWeightMethod">
										<option value="">:::<?=$LNG_TRANS_CHAR["OW00044"]?>:::</option>
										<option value="E"><?=$LNG_TRANS_CHAR["OW00106"]?></option>
									</select>
								</li>
							<?}else if ($S_SITE_LNG != "KR" && $S_DELIVERY_FOR_MTH == "A") { //해외배송이 국내배송일 경우?>
							<li>
								<span><?=$LNG_TRANS_CHAR["PW00012"] //배송비?></span>:
								<?=$strPriceLeftMark?> <strong class="toPayDeliveryPrice"><?=$strCartDeliveryTotalText?></strong><?=$strPriceRightMark?>
								<?if($strCartPriceEndTotalOrgText){?>(<?=$S_SITE_CUR_MARK1?><?=$strCartDeliveryTotalOrgText?>)<?}?>
							</li>
							<?}?>
							<?}?>

							<li class="totMemDiscountPrice" style="display:none">
							</li>

							<li class="totPayPrice">
								<span><?=$LNG_TRANS_CHAR["OW00026"] //결제금액?></span>:
								<?=$strPriceLeftMark?> <strong class="priceOrange"><?=$strCartPriceEndTotalText?></strong><?=$strPriceRightMark?>
								<?if($strCartPriceEndTotalOrgText){?>(<?=$S_SITE_CUR_MARK1?><?=$strCartPriceEndTotalOrgText?>)<?}?>
							</li>
						</ul>
					</td>
				</tr>
				<?if ($g_member_no && $intMemberUsePointTotal >= $S_POINT_MIN && $S_POINT_USE1 == "Y"){?>
				<?
					if ($intCartPointUsePrice == 0 && $intCartPointNoUseCnt > 0 && $intCartPointNoUsePrice > 0){
					}else{
				?>

				<tr>
					<th><?=$LNG_TRANS_CHAR["OW00045"] //사용포인트?></th>
					<td><input type="input" id="use_point" name="use_point" class="defInput _w100" style="text-align:right"/> P
					<?if ($S_ARY_CUR[$S_SITE_LNG]["USD"][2] == "Y") {?>
					<span class="pointInfo">[ <?=callLangTrans($LNG_TRANS_CHAR["OS00040"],array(getCurToPrice($intMemberUsePointTotal,"US"))) //getCurToPrice($intMemberUsePointTotal)의 포인트가 있습니다. 사용할 금액을 입력해 주세요.?>]</span>
					<?}else{?>
					<span class="pointInfo">[ <?=callLangTrans($LNG_TRANS_CHAR["OS00040"],array(getCurToPrice($intMemberUsePointTotal))) //getCurToPrice($intMemberUsePointTotal)의 포인트가 있습니다. 사용할 금액을 입력해 주세요.?>]</span>
					<?}?>
					</td>
				</tr>
				<?}}?>
				<?if ($S_COUPON_USE == "Y"){?>
				<tr>
					<th><?=$LNG_TRANS_CHAR["OW00073"] //쿠폰할인?></th>
					<td><input type="input" id="use_coupon" name="use_coupon" class="defInput _w100" style="text-align:right" readonly/> <?=getCurMark2()?>
						<a href="javascript:goPopCounponList();"><strong>[<?=$LNG_TRANS_CHAR["OW00074"] //쿠폰적용?>]</strong></a>
					</td>
				</tr>
				<?}?>
				<!--
				<tr>
					<th>쿠폰</th>
					<td><input type="input" name="" class="defInput _w150"/> <a href="#"><img src="../himg/<?=$D_LAYOUT_HIMG?>/product/btn_pop_coupon.gif"/></a></td>
				</tr>//-->
			</table>
		</div>
		<!-- tableOrderForm -->
		<!-- (4) 결제내역 정보 -->
		<?if ($S_SITE_LNG == "KR"){?>
			<div class="btnCenter" id="display_setup_message" style="display:none">
				<span class="red">결제를 계속 하시려면 상단의 노란색 표시줄을 클릭</span>하시거나<br/>
				<a href="http://pay.kcp.co.kr/plugin/file_vista/PayplusWizard.exe"><span class="bold">[수동설치]</span></a>를 눌러 Payplus Plug-in을 설치하시기 바랍니다.<br/>
				[수동설치]를 눌러 설치하신 경우 <span class="red bold">새로고침(F5)키</span>를 눌러 진행하시기 바랍니다.
			</div>
		<?}?>
			<div class="btnCenter" id="display_pay_button" style="display:none;">
				<a href="javascript:goOrderAct();" class="payBigBtn" id="btnOrderBuy"><span><?=$LNG_TRANS_CHAR["OW00095"] //결제하기?></span></a>
				<a href="javascript:goOrderCancel();" class="cancelBigBtn"><span><?=$LNG_TRANS_CHAR["MW00044"] //취소?></span></a>
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
