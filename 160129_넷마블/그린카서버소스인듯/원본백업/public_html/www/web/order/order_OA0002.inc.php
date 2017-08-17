		<!-- (2) 상단 서브 카테고리 -->
		<?include MALL_HOME."/include/subMenuTopImg.inc.php";?>
		<!-- (2) 상단 서브 카테고리 -->

		<div class="paymentInfo mt20">
			<ul>
				<li>주문번호는 <strong class="priceOrange"><?=$orderRow[O_KEY]?></strong>입니다.</li>
			</ul>
		</div>
		<!-- 결제완료 안내 -->
		<!-- 장바구니 시작 -->
		<?if ($S_SHOP_HOME == "prostar" && $orderRow[O_NO] <= 616){?>
		<? include MALL_WEB_PATH."/shopAdmin/popup/prostar_orderCartEndList.php";?>
		<?}else{?>
		<?include sprintf("%s%s/order_cartEndList.inc.php", MALL_WEB_PATH, $strMenuType ); ?>
		<?}?>
		<!-- 장바구니 끝 -->

		<!-- (1) 주문자 정보 -->
		<div class="tableOrderForm mt10">
			<h4><img src="/himg/product/A0001/tit_sub_cart_order_1.gif"/></h4>
			<table>
				<colgroup>
					<col style="width:100px;"/>
					<col/>
				</colgroup>
				<tr>
					<th>주문자명</th>
					<td><?=$orderRow[O_J_NAME]?></td>
				</tr>
				<tr>
					<th>전화번호</th>
					<td><?=$orderRow[O_J_PHONE]?></td>
				</tr>
				<tr>
					<th>핸드폰</th>
					<td><?=$orderRow[O_J_HP]?></td>
				</tr>
				<tr>
					<th>이메일</th>
					<td><?=$orderRow[O_J_MAIL]?></td>
				</tr>
			</table>
		</div><!-- tableOrderForm -->						
	<!-- (1) 주문자 정보 -->

	<!-- (2) 베송지 정보 -->
		<div class="tableOrderForm mt30">
			<h4><img src="/himg/product/A0001/tit_sub_cart_order_2.gif"/></h4>
			
			<table>
				<colgroup>
					<col style="width:100px;"/>
					<col/>
				</colgroup>
				<tr>
					<th>받으실 분</th>
					<td><?=$orderRow[O_B_NAME]?></td>
				</tr>
				<tr>
					<th>전화번호</th>
					<td><?=$orderRow[O_B_PHONE]?></td>
				</tr>
				<tr>
					<th>핸드폰</th>
					<td><?=$orderRow[O_B_HP]?></td>
				</tr>
				<!--<tr>
					<th>이메일</th>
					<td><?=$orderRow[O_B_MAIL]?></td>
				</tr>//-->
				<tr>
					<th>주소 </th>
					<td>[<?=$orderRow[O_B_ZIP]?>] <?=$orderRow[O_B_ADDR1]?> <?=$orderRow[O_B_ADDR2]?></td>
				</tr>
				<tr>
					<th>메모 </th>
					<td><?=$orderRow[O_B_MEMO]?></td>
				</tr>
			</table>
		</div><!-- tableOrderForm -->
	<!-- (2) 배송지 정보 -->

	<!-- (3) 결제방법 정보 -->
		<div class="tableOrderForm mt30">
			<h4><img src="/himg/product/A0001/tit_sub_cart_order_3.gif"/></h4>
			<table>
				<colgroup>
					<col style="width:100px;"/>
					<col/>
				</colgroup>
				<tr>
					<th>결제방법</th>
					<td><?=$S_ARY_SETTLE_TYPE[$orderRow[O_SETTLE]]?></td>
				</tr>
				<?if ($orderRow[M_NO]){?>
				<tr>
					<th>적립포인트</th>
					<td><strong class="priceBoldGray"><?=NUMBER_FORMAT($orderRow[O_TOT_POINT])?>원</strong></td>
				</tr>
				<?}?>
				<tr>
					<th>결제상태</th>
					<td><?=$S_ARY_SETTLE_STATUS[$orderRow[O_STATUS]]?></td>
				</tr>
				<?if ($orderRow[O_SETTLE] == "T"){?>
				<tr>
					<th>가상계좌</th>
					<td>
						[<?=$aryTBank[$orderRow[O_BANK]]?>] <?=$orderRow[O_BANK_ACC]?>
						입금마감시간 : <?=SUBSTR($orderRow[O_BANK_VALID_DT],0,4)?>년 <?=SUBSTR($orderRow[O_BANK_VALID_DT],4,2)?>월 <?=SUBSTR($orderRow[O_BANK_VALID_DT],6,2)?>일 
					</td>
				</tr>
				<?}?>
				
			</table>
		</div><!-- tableOrderForm -->
	<!-- (3) 결제방법 정보 -->

	<!-- (4) 결제내역 정보 -->
		<div class="tableOrderForm mt30">
			<h4><img src="/himg/product/A0001/tit_sub_cart_order_4.gif"/></h4>
			<table>
				<colgroup>
					<col style="width:100px;"/>
					<col/>
				</colgroup>
				<tr>
					<th>결제금액</th>
					<td>
						<ul class="priceInfo">
							<li><span>상품가격</span>: <strong><?=NUMBER_FORMAT($orderRow[O_TOT_PRICE])?>원</strong></li>
							<li><span>배송비</span>: <strong><?=NUMBER_FORMAT($orderRow[O_TOT_DELIVERY_PRICE])?>원</strong></li>
							<?if ($orderRow[M_NO]){?><li><span>사용포인트</span>: <strong><?=NUMBER_FORMAT($orderRow[O_USE_POINT])?>원</strong></li><?}?>							
							<li class="totPayPrice"><span>결제금액</span>: <strong class="priceOrange"><?=NUMBER_FORMAT($orderRow[O_TOT_SPRICE])?>원</strong></li>
						</ul>
					</td>
				</tr>					
			</table>
		</div><!-- tableOrderForm -->
	<!-- (4) 결제내역 정보 -->