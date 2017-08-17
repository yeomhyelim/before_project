		<!-- (2) 상단 서브 카테고리 -->
		<?include MALL_HOME."/include/subMenuTopImg.inc.php";?>
		<!-- (2) 상단 서브 카테고리 -->

		<div class="paymentInfo mt20">
			<ul>
				<li><?=callLangTrans($LNG_TRANS_CHAR["OS00048"],array($orderRow[O_KEY]))?></li>
			</ul>
		</div>
		<!-- 결제완료 안내 -->
		<!-- 장바구니 시작 -->
		<?include sprintf("%s%s/order_cartEndList.inc.php", MALL_WEB_PATH, $strMenuType ); ?>
		<!-- 장바구니 끝 -->

		<!-- (1) 주문자 정보 -->
		<div class="tableOrderForm mt10">
			<h4><img src="/himg/product/A0001/<?=$S_SITE_LNG_PATH?>/tit_sub_cart_order_1.gif"/></h4>
			<table>
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
					<th><?=$LNG_TRANS_CHAR["OW00010"] //이메일?></th>
					<td><?=$orderRow[O_J_MAIL]?></td>
				</tr>
			</table>
		</div><!-- tableOrderForm -->						
	<!-- (1) 주문자 정보 -->

	<!-- (2) 베송지 정보 -->
		<div class="tableOrderForm mt30">
			<h4><img src="/himg/product/A0001/<?=$S_SITE_LNG_PATH?>/tit_sub_cart_order_2.gif"/></h4>
			
			<table>
				<colgroup>
					<col style="width:100px;"/>
					<col/>
				</colgroup>
				<tr>
					<th><?=$LNG_TRANS_CHAR["OW00017"] //받으실 분?></th>
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
				<tr>
					<th><?=$LNG_TRANS_CHAR["OW00022"] //주소?> </th>
					<td>[<?=$orderRow[O_B_ZIP]?>] <?=$orderRow[O_B_ADDR1]?> <?=$orderRow[O_B_ADDR2]?> <?=$orderRow[O_B_CITY]?> <?=$strDeliveyState?> <?=$aryCountryList[$orderRow[O_B_COUNTRY]]?>
						
					</td>
				</tr>
				<tr>
					<th><?=$LNG_TRANS_CHAR["OW00028"] //메모?> </th>
					<td><?=$orderRow[O_B_MEMO]?></td>
				</tr>
			</table>
		</div><!-- tableOrderForm -->
	<!-- (2) 배송지 정보 -->

	<!-- (3) 결제방법 정보 -->
		<div class="tableOrderForm mt30">
			<h4><img src="/himg/product/A0001/<?=$S_SITE_LNG_PATH?>/tit_sub_cart_order_3.gif"/></h4>
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
					<td><?=getCurMark()?> <strong class="priceBoldGray"><?=getCurToPrice($orderRow[O_TOT_CUR_POINT])?></strong></td>
				</tr>
				<?}?>
				<tr>
					<th><?=$LNG_TRANS_CHAR["OW00046"] //결제상태?></th>
					<td><?=$S_ARY_SETTLE_STATUS[$orderRow[O_STATUS]]?></td>
				</tr>
				<?if ($orderRow[O_SETTLE] == "B"){?>
				<tr>
					<th><?=$LNG_TRANS_CHAR["OW00071"] //입금계좌?></th>
					<td>
						<?=$orderRow[O_BANK_ACC]?>
					</td>
				</tr>
				<?}?>
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
			<h4><img src="/himg/product/A0001/<?=$S_SITE_LNG_PATH?>/tit_sub_cart_order_4.gif"/></h4>
			<table>
				<colgroup>
					<col style="width:100px;"/>
					<col/>
				</colgroup>
				<tr>
					<th><?=$LNG_TRANS_CHAR["OW00026"] //결제금액?></th>
					<td>
						<ul class="priceInfo">
							<li><span><?=$LNG_TRANS_CHAR["OW00051"] //상품가격?></span>: <?=getCurMark()?> <strong><?=getCurToPrice($orderRow[O_TOT_CUR_PRICE])?></strong></li>
							<li><span><?=$LNG_TRANS_CHAR["PW00012"] //배송비?></span>: <?=getCurMark()?> <strong><?=getCurToPrice($orderRow[O_TOT_DELIVERY_CUR_PRICE])?></strong></li>
							<?if ($orderRow[M_NO]){?><li><span><?=$LNG_TRANS_CHAR["OW00045"] //사용포인트?></span>: <?=getCurMark()?> <strong><?=getCurToPrice($orderRow[O_USE_CUR_POINT])?></strong></li><?}?>
							<?if ($orderRow[O_USE_COUPON] > 0){?><li><span><?=$LNG_TRANS_CHAR["OW00081"] //사용쿠폰?></span>: <?=getCurMark()?> 
							<strong><?=getFormatPrice($orderRow[O_USE_COUPON],2)?></strong></li><?}?>
							<li class="totPayPrice"><span><?=$LNG_TRANS_CHAR["OW00026"] //결제금액?></span>: <?=getCurMark()?> <strong class="priceOrange"><?=getCurToPrice($orderRow[O_TOT_CUR_SPRICE])?></strong></li>
						</ul>
					</td>
				</tr>					
			</table>
		</div><!-- tableOrderForm -->
	<!-- (4) 결제내역 정보 -->