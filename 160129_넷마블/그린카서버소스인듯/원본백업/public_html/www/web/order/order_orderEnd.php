		<div class="paymentInfo mt20">
			<?if ($strPayFlag == "success"){?>
			<ul>
				<li><?=callLangTrans($LNG_TRANS_CHAR['OS00070'],array($orderRow[O_J_NAME]))?></li>
				<li><?=callLangTrans($LNG_TRANS_CHAR['OS00048'],array($orderRow[O_KEY]))?></li>
			</ul>
			<?}else{?>
			<ul>
				<li><?=callLangTrans($LNG_TRANS_CHAR['OS00071'],array($orderRow[O_J_NAME]))?></li>
				<li><?$res_msg_bsucc?></li>
			</ul>
			<?}?>
		</div>
		<!-- 결제완료 안내 -->
		<!-- 장바구니 시작 -->
		<?include sprintf("%s%s/order_cartEndList.inc.php", MALL_WEB_PATH, $strMenuType ); ?>
		<!-- 장바구니 끝 -->

		<!-- (1) 주문자 정보 -->
		<div class="tableOrderForm mt10">
			<h4 class="orderTit_order"><span><?=$LNG_TRANS_CHAR["OW00091"] //주문자 정보?></span></h4>
			<table>
				<colgroup>
					<col style="width:100px;"/>
					<col/>
				</colgroup>
				<tr>
					<th><?=$LNG_TRANS_CHAR["OW00015"] //주문자명?></th>
					<td><?=$orderRow[O_J_NAME]?></td>
				</tr>
				<?if ($orderRow[O_J_PHONE]){?>
				<tr>
					<th><?=$LNG_TRANS_CHAR["OW00016"] //전화번호?></th>
					<td><?=$orderRow[O_J_PHONE]?></td>
				</tr>
				<?}?>
				<tr>
					<th><?=$LNG_TRANS_CHAR["OW00010"] //핸드폰?></th>
					<td><?=$orderRow[O_J_HP]?></td>
				</tr>
				<tr>
					<th><?=$LNG_TRANS_CHAR["OW00011"] //이메일?></th>
					<td><?=$orderRow[O_J_MAIL]?></td>
				</tr>
			</table>
		</div><!-- tableOrderForm -->
	<!-- (1) 주문자 정보 -->

	<!-- (2) 베송지 정보 -->
		<?if ($strOrderDeliveryInfoViewYN == "Y"){?>
		<div class="tableOrderForm mt30">
			<h4 class="orderTit_Address"><span><?=$LNG_TRANS_CHAR["OW00092"] //배송지 정보?></span></h4>
			<table>
				<colgroup>
					<col style="width:100px;"/>
					<col/>
				</colgroup>
				<tr>
					<th><?=$LNG_TRANS_CHAR["OW00017"] //받는사람명?></th>
					<td><?=$orderRow[O_B_NAME]?></td>
				</tr>
				<tr>
					<th><?=$LNG_TRANS_CHAR["OW00018"] //전화번호?></th>
					<td><?=$orderRow[O_B_PHONE]?></td>
				</tr>
				<tr>
					<th><?=$LNG_TRANS_CHAR["OW00019"] //핸드폰?></th>
					<td><?=$orderRow[O_B_HP]?></td>
				</tr>
				<!--<tr>
					<th><?=$LNG_TRANS_CHAR["OW00020"] //이메일?></th>
					<td><?=$orderRow[O_B_MAIL]?></td>
				</tr>//-->
				<?if ($S_SITE_LNG != "KR"){?>
				<tr>
					<th><?=$LNG_TRANS_CHAR["OW00040"] //국가?></th>
					<td>
						<?=$aryCountryList[$orderRow[O_B_COUNTRY]]?>
					</td>
				</tr>
				<?}?>
				<tr>
					<th><?=$LNG_TRANS_CHAR["OW00021"] //우편번호?></th>
					<td>
						<?=$orderRow[O_B_ZIP]?>
					</td>
				</tr>
				<tr>
					<th><?=$LNG_TRANS_CHAR["OW00022"] //주소?></th>
					<td>
						<?=$orderRow[O_B_ADDR1]?>
					</td>
				</tr>
				<tr>
					<th><?=$LNG_TRANS_CHAR["OW00023"] //상세주소?></th>
					<td>
						<?=$orderRow[O_B_ADDR2]?>
					</td>
				</tr>
				<?if ($S_SITE_LNG != "KR"){?>
				<tr>
					<th><?=$LNG_TRANS_CHAR["OW00041"] //City?></th>
					<td>
						<?=$orderRow[O_B_CITY]?>
					</td>
				</tr>
				<tr>
					<th><?=$LNG_TRANS_CHAR["OW00042"] //State?></th>
					<td>
						<?=$strDeliveyState?>
					</td>
				</tr>
				<?}?>
				<tr>
					<th><?=$LNG_TRANS_CHAR["OW00028"] //메모?> </th>
					<td><?=$orderRow[O_B_MEMO]?></td>
				</tr>
			</table>
		</div><!-- tableOrderForm -->
	<!-- (2) 배송지 정보 -->
		<?}?>


	<!-- (3) 결제방법 정보 -->
		<div class="tableOrderForm mt30">
			<h4 class="orderTit_1"><span><?=$LNG_TRANS_CHAR["OW00093"] //결제 정보?></span></h4>
			<table>
				<colgroup>
					<col style="width:100px;"/>
					<col/>
				</colgroup>
				<tr>
					<th><?=$LNG_TRANS_CHAR["OW00030"] //결제방법?></th>
					<td><?=$S_ARY_SETTLE_TYPE[$orderRow[O_SETTLE]]?></td>
				</tr>
				<?if ($orderRow[M_NO]){?>
				<tr>
					<th><?=$LNG_TRANS_CHAR["OW00032"] //적립포인트?></th>
					<td><strong class="priceBoldGray"><?=getCurMark()?> <?=getFormatPrice($orderRow[O_TOT_POINT],2)?> P</strong></td>
				</tr>
				<?}?>
				<tr>
					<th><?=$LNG_TRANS_CHAR["OW00046"] //결제상태?></th>
					<td><?=$S_ARY_SETTLE_STATUS[$orderRow[O_STATUS]]?></td>
				</tr>
				<?if ($orderRow[O_SETTLE] == "T" && $orderRow[O_STATUS] == "J"){?>
				<tr>
					<th><?=$LNG_TRANS_CHAR["OW00035"] //가상계좌?></th>
					<td>
						[<?=$strReturnBankName?>] <?=$orderRow[O_BANK_ACC]?>
						입금마감시간 : <?=SUBSTR($orderRow[O_BANK_VALID_DT],0,4)?>년 <?=SUBSTR($orderRow[O_BANK_VALID_DT],4,2)?>월 <?=SUBSTR($orderRow[O_BANK_VALID_DT],6,2)?>일
					</td>
				</tr>
				<?}?>
				<?if($orderRow['O_CASH_YN'] == "Y"):?>
				<tr>
					<th><?="현금영수증" //현금영수증?></th>
					<td>
						<?=$orderRow['O_CASH_INFO']?>
					</td>
				</tr>
				<?endif;?>
			</table>
		</div><!-- tableOrderForm -->
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

							<?if ($orderRow['O_TAX_PRICE']>0){?>
							<li>
								<span><?=$LNG_TRANS_CHAR["OW00008"] //부과세?></span>:
								<?=$strPriceLeftMark?> <strong><?=$strCartPriceTotalTaxText?></strong><?=$strPriceRightMark?><?=$strCartPriceTotalTaxOrgText?>
							</li>
							<?}?>

							<?if ($orderRow[O_TOT_PG_COMMISSION]>0){?>
							<li>
								<span><?=$LNG_TRANS_CHAR["OW00112"] //수수료?></span>:
								<?=$strPriceLeftMark?> <strong><?=$strCartPricePgCommissionText?></strong><?=$strPriceRightMark?><?=$strCartPricePgCommissionOrgText?>
							</li>
							<?}?>

							<li>
								<span><?=$LNG_TRANS_CHAR["PW00012"] //배송비?></span>:
								<?=$strPriceLeftMark?> <strong><?=$strCartDeliveryTotalText?></strong><?=$strPriceRightMark?><?=$strCartDeliveryTotalOrgText?>
							</li>

							<?if ($orderRow['O_TOT_MEM_DISCOUNT_PRICE'] > 0){?>
							<li>
								<span><?=$LNG_TRANS_CHAR["OW00070"] //추가할인금액?></span>:
								<?=$strPriceLeftMark?> <strong><?=$strCartMemberDiscountPriceText?></strong><?=$strPriceRightMark?><?=$strCartMemberDiscountPriceOrgText?>
							</li>
							<?}?>

							<?if ($orderRow[M_NO] && $orderRow[O_USE_POINT] > 0){?>
							<li>
								<span><?=$LNG_TRANS_CHAR["OW00045"] //사용포인트?></span>:
								<strong><?=getFormatPrice($orderRow['O_USE_POINT'],2)?></strong> P</li>
							<?}?>

							<?if ($orderRow[O_USE_COUPON] > 0){?>
							<li>
								<span><?=$LNG_TRANS_CHAR["OW00081"] //사용쿠폰?></span>:
								<?=$strPriceLeftMark?> <strong><?=$strCartUseCouponPriceText?></strong><?=$strPriceRightMark?>
							</li>
							<?}?>

							<li class="totPayPrice">
								<span><?=$LNG_TRANS_CHAR["OW00026"] //결제금액?></span>:
								<?=$strPriceLeftMark?> <strong class="priceOrange"> <?=$strCartPriceEndTotalText?></strong><?=$strPriceRightMark?><?=$strCartPriceEndTotalOrgText?>
							</li>


						</ul>
					</td>
				</tr>
			</table>
		</div><!-- tableOrderForm -->
	<!-- (4) 결제내역 정보 -->
		<?if ($S_FIX_ORDER_END_MYPAGE_LINK == "Y"){?>
		<div class="btnCenter">
			<a href="./?menuType=mypage&mode=buyList" class="orderOkBigBtn"><span><?=$LNG_TRANS_CHAR["CW00001"] //확인?></span></a>
		</div>
		<?}else{?>
		<div class="btnCenter">
			<a href="./" class="orderOkBigBtn"><span><?=$LNG_TRANS_CHAR["CW00001"] //확인?></span></a>
			<?if ($strPayFlag == "success" && $SHOP_USER_ADD_MENU_USE == "Y" && $SHOP_USER_ADD_MENU_["ORDER"]["USE"] == "Y"){?>
			<a href="./?menuType=order&mode=nextOrderStep&step=1&oNo=<?=$orderRow['O_NO']?>" class="mypageLinkBigBtn"><span><?=$SHOP_USER_ADD_MENU_["ORDER"]["NAME_".$S_SITE_LNG]?></span></a>
			<?}else{?>
			<a href="./?menuType=mypage&mode=buyList" class="mypageLinkBigBtn"><span><?=$LNG_TRANS_CHAR["MW00048"] //마이페이지 이동?></span></a>
			<?}?>
		</div>
		<?}?>