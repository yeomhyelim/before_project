<!-- (2) 상단 서브 카테고리 -->
<?include MALL_HOME."/include/subMenuTopImg.inc.php";?>
<!-- (2) 상단 서브 카테고리 -->

<!-- 장바구니 시작 -->
<?include "orderCartList.inc.php";?>
<!-- 장바구니 끝 -->

<!-- 개인정보 수집동의(비회원 주문시 적용) -->
		<?if (!$g_member_no){?>
		<div class="agreeWrap mt20">
			<!-- 개인정보동의 -->
				<h4><img src="../himg/member/A0001/<?=$S_SITE_LNG_PATH?>/tit_policy_2.gif"/> <span><?=$LNG_TRANS_CHAR["OS00036"] //비회원 주문에 대한 개인정보 수집에 대한 동의 (자세한 내용은 “개인정보취급방침”을 확인하시기 바랍니다)?></span></h4>
				
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
			if ($S_SITE_LNG == "KR"){
				include "orderInfoInput.inc.php";
			}else {
				include "orderInfoInput.for.inc.php";
			}
		?>

		<!-- (3) 결제방법 정보 -->
		<div class="tableOrderForm mt30">
			<h4><img src="../himg/product/A0001/<?=$S_SITE_LNG_PATH?>/tit_sub_cart_order_3.gif"/></h4>
			<table>
				<colgroup>
					<col style="width:100px;"/>
					<col/>
				</colgroup>
				<?if ($S_SITE_LNG == "KR"){?>
				<tr>
					<th><?=$LNG_TRANS_CHAR["OW00030"] //결제방법?></th>
					<td>
						<?if ($intSiteSettleC == "Y"){?>
						<input type="radio" id="settle" name="settle" value="C" checked onclick="javascript:goSettle();"/><?=$LNG_TRANS_CHAR["OW00033"] //카드결제?>
						<?}?>
						<?if ($intSiteSettleA == "Y"){?>
						<input type="radio" id="settle" name="settle" value="A" onclick="javascript:goSettle();"/><?=$LNG_TRANS_CHAR["OW00034"] //실시간 계좌이체?>
						<?}?>
						<?if ($intSiteSettleT == "Y"){?>
						<input type="radio" id="settle" name="settle" value="T" onclick="javascript:goSettle();"/><?=$LNG_TRANS_CHAR["OW00035"] //가상계좌?>
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
						<?=$LNG_TRANS_CHAR["OW00024"] //입금자명?> : <input type="input" id="input_bank_name" name="input_bank_name" class="defInput _w100" maxlength="20" value="<?=$strJName?>"/>

						<?if ($S_SITE_LNG == "KR"){?>
							<span><input type="checkbox" name="cash_yn" id="cash_yn" value="Y"> 현금영수증신청</span>
							<div id="divCash" style="display:none">
								<br>
								<select name="cashMth" id="cashMth">
									<option value="">발급방법</option>
									<option value="1" selected>휴대폰</option>
									<option value="2">카드번호</option>
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
							</div>
						<?}?>
					</td>
				</tr>
				<?} else {?>
				<tr>
					<th><?=$LNG_TRANS_CHAR["OW00030"] //결제방법?></th>
					<td>
						<?if ($S_FOR_PG == "Y"){?>
						<input type="radio" id="settle" name="settle" value="Y" checked/>Paypal
						<?}?>
					</td>
				</tr>
				<?}?>
				<?if ($g_member_no && $siteRow[S_POINT_USE1] == "Y"){?>
				<tr>
					<th><?=$LNG_TRANS_CHAR["OW00032"] //적립포인트?></th>
					<td><span id="spanOrderAddPoint"><?=getCurMark()?> <?=getCurToPrice($intCartPointTotal)?></span>
					<input type="hidden" name="savePointTotal" id="savePointTotal" value="<?=$intCartPointTotal?>">
					</td>
				</tr>
				<?}?>
			</table>
		</div>
		<!-- tableOrderForm -->
		<!-- (3) 결제방법 정보 -->

		<!-- (4) 결제내역 정보 -->
		<div class="tableOrderForm mt30">
			<h4><img src="../himg/product/A0001/<?=$S_SITE_LNG_PATH?>/tit_sub_cart_order_4.gif"/></h4>
			<table>
				<colgroup>
					<col style="width:100px;"/>
					<col/>
				</colgroup>
				<tr>
					<th><?=$LNG_TRANS_CHAR["OW00026"] //결제금액?></th>
					<td>
						<ul class="priceInfo">
							<li><span><?=$LNG_TRANS_CHAR["OW00043"] //상품가격?></span>: <?=getCurMark()?> <strong><?=getCurToPrice($intCartPriceTotal)?></strong></li>
							<?if ($S_SITE_TAX == "Y"){?>
							<li><span><?=$LNG_TRANS_CHAR["OW00008"] //부과세?></span>: <?=getCurMark()?>  <strong><?=getCurToPrice($intCartPriceTotal * 0.1)?></strong></li>
							<?}?>
							<?if ($S_SITE_LNG == "KR" && ($S_DELIVERY_MTH == "N" || !$S_DELIVERY_MTH)){?>
							<li><span><?=$LNG_TRANS_CHAR["PW00012"] //배송비?></span>: <?=getCurMark()?>  <strong class="toPayDeliveryPrice"><?=getCurToPrice($intDeliveryTotal)?></strong></li>
							<?} else if ($S_SITE_LNG == "KR" && $S_DELIVERY_MTH == "G") {
								?>
								<li><span><?=$LNG_TRANS_CHAR["PW00012"] //배송비?></span>: <?=drawSelectBoxMore("deliveryGroupPrice",$aryDeliveryGroupPriceList,"",$design ="",$onchange="javascript:goTotalPriceCal();",$etc="",$LNG_TRANS_CHAR["OW00027"],$html="N")?>
							<?} else if ($S_SITE_LNG != "KR" && $S_DELIVERY_FOR_MTH == "W") {
								?>
								<li><span><?=$LNG_TRANS_CHAR["OW00044"] //배송방법?></span>: 
									<select name="deliveryWeightMethod" id="deliveryWeightMethod">
										<option value="">:::<?=$LNG_TRANS_CHAR["OW00044"]?>:::</option>
									</select>
								<li><span><?=$LNG_TRANS_CHAR["PW00012"] //배송비?></span>: <?=getCurMark()?> <strong id="txtDeliveryPrice">0</strong>
							<?}?>

							<li class="totMemDiscountPrice" style="display:none">
							</li>
							<li class="totPayPrice"><span><?=$LNG_TRANS_CHAR["OW00026"] //결제금액?></span>: <?=getCurMark()?>  <strong class="priceOrange"><?=getCurToPrice($intCartPriceEndTotal)?></strong></li>

						</ul>
					</td>
				</tr>
				<?if ($g_member_no && $intMemberUsePointTotal >= $siteRow[S_POINT_MIN] && $siteRow[S_POINT_USE1] == "Y"){?>
				<tr>
					<th><?=$LNG_TRANS_CHAR["OW00045"] //사용포인트?></th>
					<td><input type="input" id="use_point" name="use_point" class="defInput _w150" style="text-align:right"/> <?=getCurMark()?>  <strong><?=callLangTrans($LNG_TRANS_CHAR["OS00040"],array(getCurToPrice($intMemberUsePointTotal))) //getCurToPrice($intMemberUsePointTotal)의 포인트가 있습니다. 사용할 금액을 입력해 주세요.?></strong></td>
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
			<a href="javascript:goOrderAct();" ><img src="../himg/product/A0001/<?=$S_SITE_LNG_PATH?>/btn_order_buy.gif" id="btnOrderBuy"/></a>
			<a href="javascript:goOrderCancel();"><img src="../himg/product/A0001/<?=$S_SITE_LNG_PATH?>/btn_order_cancel.gif"/></a>
		</div>
<?
	if ($S_SITE_LNG == "KR"){
		include "orderSettle.inc.php";
	}else {
		include "orderSettle.for.inc.php";
	}
?>
