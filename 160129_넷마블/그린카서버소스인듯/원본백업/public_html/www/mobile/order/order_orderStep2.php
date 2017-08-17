<div class="orderBodyWrap">
	<!-- 구매절차 -->
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
	<!-- 구매절차 -->

		<h2>주문신청확인</h2>

		<div class="orderPaymentInfo">
			<strong><?=$orderRow[O_J_NAME]?>님</strong>의 주문정보입니다.<br>
			내역을 확인하시고 결제 진행해 주세요.
		</div>
		<!-- 장바구니 시작 -->
		<?include sprintf("%s%s/order_orderStepCartList.inc.php", MALL_MOB_PATH, $strMenuType ); ?>
		<!-- 장바구니 끝 -->

		<!-- (1) 주문자 정보 -->
		<div class="tableOrderForm">
			<div class="titBox"><span class="barRed"></span><span class="tit"><?=$LNG_TRANS_CHAR["OW00091"] //주문자 정보?></span></div>
			<div class="tableBox">
				<table class="tableFormType">
					<colgroup>
						<col/>
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
						<col/>
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
	<!-- (4) 결제내역 정보 -->
		<div class="tableOrderForm mt30">
			<div class="titBox"><span class="barRed"></span><span class="tit"><?=$LNG_TRANS_CHAR["OW00094"] //결제 내역?></span></div>
			<div class="topalPriceInfoList">
				<ul class="priceInfo">
					<li>
						<span class="title"><?=$LNG_TRANS_CHAR["OW00051"] //상품가격?></span>
						<span class="valueTxt"><?=getCurMark()?>  <strong><?=getFormatPrice($orderRow[O_TOT_PRICE],2)?></strong><?=getCurMark2()?></span>
						<div class="clr"></div>
					</li>
					<?if ($orderRow[O_TAX_PRICE]>0){?>
					<li>
						<span class="title"><?=$LNG_TRANS_CHAR["OW00008"] //부과세?></span>
						<span class="valueTxt"><?=getCurMark()?>  <strong><?=getFormatPrice($orderRow[O_TAX_PRICE],2)?></strong><?=getCurMark2()?></span>
						<div class="clr"></div>
					</li>
					<?}?>
					<li>
						<span class="title"><?=$LNG_TRANS_CHAR["PW00012"] //배송비?></span>
						<span class="valueTxt"><?=getCurMark()?>  <strong><?=getFormatPrice($orderRow[O_TOT_DELIVERY_PRICE],2)?></strong><?=getCurMark2()?></span>
						<div class="clr"></div>
					</li>
					<?if ($orderRow[O_TOT_MEM_DISCOUNT_PRICE] > 0){?>
					<li>
						<span class="title"><?=$LNG_TRANS_CHAR["OW00070"] //추가할인금액?></span>
						<span class="valueTxt"><?=getCurMark()?>  <strong><?=getFormatPrice($orderRow[O_TOT_MEM_DISCOUNT_PRICE],2)?></strong><?=getCurMark2()?></span>
						<div class="clr"></div>
					</li>
					<?}?>
					<?if ($orderRow[M_NO] && $orderRow[O_USE_POINT] > 0){?>
					<li>
						<span class="title"><?=$LNG_TRANS_CHAR["OW00045"] //사용포인트?></span>  
						<span class="valueTxt"><strong><?=getFormatPrice($orderRow[O_USE_POINT],2)?></strong> P</span>
						<div class="clr"></div>
					</li><?}?>
					<?if ($orderRow[O_USE_COUPON] > 0){?>
					<li>
						<span class="title"><?=$LNG_TRANS_CHAR["OW00081"] //사용쿠폰?></span>  
						<span class="valueTxt"><?=getCurMark()?>  <strong><?=getFormatPrice($orderRow[O_USE_COUPON],2)?></strong><?=getCurMark2()?></span>
						<div class="clr"></div>
					</li><?}?>
					
					<li class="orderTotalPrice">
						<span class="title"><?=$LNG_TRANS_CHAR["OW00026"] //결제금액?></span>
						<span class="valueTxt"><?=getCurMark()?>  <strong class="totPrice"><?=getFormatPrice($orderRow[O_TOT_SPRICE],2)?></strong><?=getCurMark2()?></span>
						<div class="clr"></div>
					</li>
				</ul>			
			</div>
	
		</div><!-- tableOrderForm -->
	<!-- (4) 결제내역 정보 -->
</div>