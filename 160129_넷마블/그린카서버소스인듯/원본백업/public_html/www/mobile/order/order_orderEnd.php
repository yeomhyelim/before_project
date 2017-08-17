<div class="orderBodyWrap">
		<!--<div class="regStepWrap">
			<ul>
				<li class="step_1">
					<span><?=$LNG_TRANS_CHAR["PW00022"] //장바구니?></span>
					<div class="stepIco"></div>
				</li>
				<li class="step_2">
					<span><?=$LNG_TRANS_CHAR["CW00079"]//구매신청서?></span>
					<div class="stepIcoOn"></div>
				</li>
				<li class="step_3 stepOn">
					<span><?=$LNG_TRANS_CHAR["CW00019"] //구매완료?></span>
				</li>
			</ul>
			<div class="clr"></div>
		</div>-->

		<h2><?=$LNG_TRANS_CHAR["CW00019"] //구매완료?></h2>

		<div class="orderPaymentInfo">
			<?if ($strPayFlag == "success"){?>
			<ul>
				<li><strong><?=$orderRow[O_J_NAME]?>님</strong>의 주문이 완료 되었습니다.</li>
				<li>주문번호는 <strong class="orderNum"><?=$orderRow[O_KEY]?></strong>입니다.</li>
			</ul>
			<?}else{?>
			<ul>
				<li><strong><?=$orderRow[O_J_NAME]?>님</strong>의 주문이 실패 되었습니다.</li>
				<li><?=$res_msg?></li>
			</ul>
			<?}?>
		</div>
		<!-- 결제완료 안내 -->
		<!-- 장바구니 시작 -->
		<?include sprintf("%s%s/order_cartEndList.inc.php", MALL_MOB_PATH, $strMenuType ); ?>
		<!-- 장바구니 끝 -->
		<!-- (1) 주문자 정보 -->
		<div class="tableOrderForm mt10">
			<div class="titBox"><span class="barRed"></span><span class="tit"><?=$LNG_TRANS_CHAR["OW00091"] //주문자 정보?></span></div>
			<div class="tableBox">
				<table class="tableFormType">
					<colgroup>
						<col style="width:100px;"/>
						<col/>
					</colgroup>
					<tr>
						<th><?=$LNG_TRANS_CHAR["OW00015"] //주문자명?></th>
						<td><?=$orderRow[O_J_NAME]?></td>
					</tr>
					<tr>
						<th><?=$LNG_TRANS_CHAR["OW00016"] //전화번호?></th>
						<td><?=$orderRow[O_J_PHONE]?></td>
					</tr>
					<tr>
						<th><?=$LNG_TRANS_CHAR["OW00010"] //핸드폰?></th>
						<td><?=$orderRow[O_J_HP]?></td>
					</tr>
					<tr>
						<th><?=$LNG_TRANS_CHAR["OW00011"] //이메일?></th>
						<td><?=$orderRow[O_J_MAIL]?></td>
					</tr>
				</table>
			</div>
		</div><!-- tableOrderForm -->						
	<!-- (1) 주문자 정보 -->

	<!-- (2) 베송지 정보 -->
		<div class="tableOrderForm mt30">
			<div class="titBox"><span class="barRed"></span><span class="tit"><?=$LNG_TRANS_CHAR["OW00092"] //배송지 정보?></span></div>			
			<div class="tableBox">
				<table class="tableFormType">
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
			</div>
		</div><!-- tableOrderForm -->
	<!-- (2) 배송지 정보 -->

	<!-- (3) 결제방법 정보 -->
		<div class="tableOrderForm mt30">
			<div class="titBox"><span class="barRed"></span><span class="tit"><?=$LNG_TRANS_CHAR["OW00093"] //결제 정보?></span></div>
			<div class="tableBox">
				<table class="tableFormType">
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
							[<?=$aryTBank[$orderRow[O_BANK]]?>] <?=$orderRow[O_BANK_ACC]?>
							입금마감시간 : <?=SUBSTR($orderRow[O_BANK_VALID_DT],0,4)?>년 <?=SUBSTR($orderRow[O_BANK_VALID_DT],4,2)?>월 <?=SUBSTR($orderRow[O_BANK_VALID_DT],6,2)?>일 
						</td>
					</tr>
					<?}?>
				</table>
			</div>
		</div><!-- tableOrderForm -->
	<!-- (3) 결제방법 정보 -->

	<!-- (4) 결제내역 정보 -->
		<div class="titBox"><span class="barRed"></span><span class="tit"><?=$LNG_TRANS_CHAR["OW00094"] //결제 내역?></span></div>
		<div class="topalPriceInfoList">			
				<ul class="priceInfo">
					<li>
						<span class="title"><?=$LNG_TRANS_CHAR["OW00051"] //상품가격?></span> 
						<span class="valueTxt">
							<?=$strPriceLeftMark?> <strong><?=$strCartPriceTotalText?></strong><?=$strPriceRightMark?><?=$strCartPriceTotalOrgText?>
						</span><div class="clr"></div>
					</li>
					<?if ($orderRow[O_TAX_PRICE]>0){?>
					<li>
						<span class="title"><?=$LNG_TRANS_CHAR["OW00008"] //부과세?></span>
						<span class="valueTxt">
							<?=$strPriceLeftMark?> <strong><?=$strCartPriceTotalTaxText?></strong><?=$strPriceRightMark?><?=$strCartPriceTotalTaxOrgText?>
						</span><div class="clr"></div></li>
					<?}?>
					<li>
						<span class="title"><?=$LNG_TRANS_CHAR["PW00012"] //배송비?></span> 
						<span class="valueTxt">
							<?=$strPriceLeftMark?> <strong><?=$strCartDeliveryTotalText?></strong><?=$strPriceRightMark?><?=$strCartDeliveryTotalOrgText?>
						</span><div class="clr"></div></li>
					<?if ($orderRow[O_TOT_MEM_DISCOUNT_PRICE] > 0){?>
					<li>
						<span class="title"><?=$LNG_TRANS_CHAR["OW00070"] //추가할인금액?></span> 
						<span class="valueTxt">
							<?=$strPriceLeftMark?> <strong><?=$strCartMemberDiscountPriceText?></strong><?=$strPriceRightMark?><?=$strCartMemberDiscountPriceOrgText?>
						</span><div class="clr"></div>
					</li>
					<?}?>
					<?if ($orderRow[M_NO] && $orderRow[O_USE_POINT] > 0){?>
					<li>
						<span class="title"><?=$LNG_TRANS_CHAR["OW00045"] //사용포인트?></span>  
						<span class="valueTxt"><strong><?=getFormatPrice($orderRow[O_USE_POINT],2)?> P</strong></span><div class="clr"></div>
					</li>
					<?}?>
					<?if ($orderRow[O_USE_COUPON] > 0){?>
					<li>
						<span class="title"><?=$LNG_TRANS_CHAR["OW00081"] //사용쿠폰?></span>: <?=getCurMark()?> 
						<span class="valueTxt">
							<?=$strPriceLeftMark?> <strong><?=$strCartUseCouponPriceText?></strong><?=$strPriceRightMark?>
						</span> <div class="clr"></div>
					</li>
					<?}?>
					
					<li>
						<span class="title"><?=$LNG_TRANS_CHAR["OW00026"] //결제금액?></span>
						<span class="valueTxt">
							<?=$strPriceLeftMark?> <strong class="price"> <?=$strCartPriceEndTotalText?></strong><?=$strPriceRightMark?><?=$strCartPriceEndTotalOrgText?>
						</span><div class="clr"></div>
					</li>
				</ul>
		</div><!-- tableOrderForm -->
	<!-- (4) 결제내역 정보 -->

		<div class="orderBtnwWrap">
			<a href="./" class="payBigBtn btn_red"><span><?=$LNG_TRANS_CHAR["CW00001"] //확인?></span></a>
			<?if ($strPayFlag == "success" && $SHOP_USER_ADD_MENU_USE == "Y" && $SHOP_USER_ADD_MENU_["ORDER"]["USE"] == "Y"){?>
			<a href="./?menuType=order&mode=orderNextStep&step=1&oNo=<?=$orderRow['O_NO']?>" class="fileBigBtn"><span><?=$SHOP_USER_ADD_MENU_["ORDER"]["NAME_".$S_SITE_LNG] //파일업로드?></span></a>
			<?}else{?>
			<a href="./?menuType=mypage&mode=buyList" class="cancelBigBtn btn_black"><span><?=$LNG_TRANS_CHAR["MW00048"] //마이페이지 이동?></span></a>
			<?}?>
		</div>
</div>