<div class="orderBodyWrap">
	<div class="tableOrderForm">
		<h2 class="cartTitle"><span><?=$LNG_TRANS_CHAR["CW00013"] //구매내역?></span></h3>
		<div class="orderNumberWrap">
			<?=callLangTrans($LNG_TRANS_CHAR["OS00048"],array($orderRow[O_KEY]))?>
		</div>
		<!-- (2) 상단 서브 카테고리 -->
			<?include MALL_HOME."/include/subMenuTopImg.inc.php";?>
		<!-- (2) 상단 서브 카테고리 -->

		<!-- 결제완료 안내 -->
		<!-- 장바구니 시작 -->
			<?include MALL_HOME . "/mobile/mypage/order_cartEndList{$S_SHOP_ORDER_VERSION}.inc.php";?> 
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
						<th><?=$LNG_TRANS_CHAR["OW00010"] //이메일?></th>
						<td><?=$orderRow[O_J_MAIL]?></td>
					</tr>
				</table>
			</div>
		</div><!-- tableOrderForm -->						
	<!-- (1) 주문자 정보 -->

	<!-- (2) 베송지 정보 -->
		<div class="tableOrderForm">
			<div class="titBox"><span class="barRed"></span><span class="tit"><?=$LNG_TRANS_CHAR["OW00092"] //배송지 정보?></span></div>
			
			<div class="tableBox">
				<table class="tableFormType">
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
			</div>
		</div><!-- tableOrderForm -->
	<!-- (2) 배송지 정보 -->

	<!-- (3) 결제방법 정보 -->
		<div class="tableOrderForm">
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
			</div>
		</div><!-- tableOrderForm -->
	<!-- (3) 결제방법 정보 -->

	<!-- (4) 결제내역 정보 -->
		<div class="tableOrderForm">
			<div class="titBox"><span class="barRed"></span><span class="tit"><?=$LNG_TRANS_CHAR["OW00094"] //결제 내역?></span></div>
			<div class="tableBox">
				<ul class="priceInfo">
					<li>
						<span class="title"><?=$LNG_TRANS_CHAR["OW00051"] //상품가격?></span> 
						<span class="valueTxt">
							<?=getCurMark($orderRow['O_USE_CUR'])?> <strong><?=getFormatPrice($orderRow[O_TOT_PRICE],2,$orderRow['O_USE_CUR'])?><?=getCurMark2($orderRow['O_USE_CUR'])?></strong>
						</span><div class="clr"></div></li>
					<li>
						<span class="title"><?=$LNG_TRANS_CHAR["PW00012"] //배송비?></span>
						<span class="valueTxt"><?=getCurMark($orderRow['O_USE_CUR'])?> <strong><?=getFormatPrice($orderRow[O_TOT_DELIVERY_PRICE],2,$orderRow['O_USE_CUR'])?><?=getCurMark2($orderRow['O_USE_CUR'])?></strong></span><div class="clr"></div></li>
					<?if ($orderRow[M_NO]){?>
					<li>
						<span class="title"><?=$LNG_TRANS_CHAR["OW00045"] //사용포인트?></span>
						<span class="valueTxt"><strong><?=getFormatPrice($orderRow[O_USE_POINT],2,$orderRow['O_USE_CUR'])?> P</strong></span><div class="clr"></div></li>
					<?}?>
					<?if ($orderRow[O_USE_COUPON] > 0){?>
					<li>
						<span class="title"><?=$LNG_TRANS_CHAR["OW00081"] //사용쿠폰?></span>
						<span class="valueTxt"><?=getCurMark($orderRow['O_USE_CUR'])?><strong><?=getFormatPrice($orderRow[O_USE_COUPON],2,$orderRow['O_USE_CUR'])?><?=getCurMark2($orderRow['O_USE_CUR'])?></strong></span><div class="clr"></div></li>
					<?}?>
					<li class="totPayPrice">
						<span class="title"><?=$LNG_TRANS_CHAR["OW00026"] //결제금액?></span>
						<span class="valueTxt"><?=getCurMark($orderRow['O_USE_CUR'])?> <strong class="totPrice"><?=getFormatPrice($orderRow[O_TOT_SPRICE],2,$orderRow['O_USE_CUR'])?><?=getCurMark2($orderRow['O_USE_CUR'])?></strong></span><div class="clr"></div></li>
				</ul>
			</div>
		</div><!-- tableOrderForm -->
	<!-- (4) 결제내역 정보 -->
		<div class="myorderBtnWrap">
			<?if ($g_member_no){?>
				<a href="javascript:goBuyList()" class="btn_clist_ok btn_red"><?=$LNG_TRANS_CHAR["CW00001"] //확인?></a>
			<?}else{?>
				<a href="javascript:goBuyNonList()" class="btn_clist_ok btn_red"><?=$LNG_TRANS_CHAR["CW00001"] //확인?></a>
			<?}?>
			<?if ($SHOP_USER_ADD_MENU_USE == "Y" && $SHOP_USER_ADD_MENU_["ORDER"]["USE"] == "Y"){
				if ($orderUploadCheckRow['orderend'] != 1){
				?>
				<a href="./?menuType=order&mode=orderNextStep&step=1&oNo=<?=$orderRow['O_NO']?>" class="fileBigBtn"><span><?=$SHOP_USER_ADD_MENU_["ORDER"]["NAME_".$S_SITE_LNG]?></span></a>
			<?}}?>
		</div>
</div>