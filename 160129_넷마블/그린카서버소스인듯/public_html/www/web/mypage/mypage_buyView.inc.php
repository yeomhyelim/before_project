<script>
	function goOrderCeritySaveActEvent(no){

		var url				= "./?menuType=order&mode=json&act=ceritySave&ocNo="+no;

		$.getJSON(url,function(data){
			try {
				switch(data['mode']){
					case "__ERROR__":
						alert(data['text']);
						break;
					case "__SUCCESS__":
						alert(data['text']);
						location.reload();
						break;
				}
			} catch(e) {
				console.log("system error");
			} finally {
			}
		});

	}
</script>

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
		<?include sprintf("%s%s/mypage_cartEndList".$S_SHOP_ORDER_VERSION.".inc.php", MALL_WEB_PATH, $strMenuType ); ?>
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
					<td>
					[<?=$orderRow[O_B_ZIP]?>] <?=$orderRow[O_B_ADDR1]?> <?=$orderRow[O_B_ADDR2]?> <?=$orderRow[O_B_CITY]?> <?=$strDeliveyState?> <?=$aryCountryList[$orderRow[O_B_COUNTRY]]?>	
					</td>
				</tr>
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
				<?
				if ($orderRow[M_NO])
				{
				?>
				<!--tr>
					<th><?=$LNG_TRANS_CHAR["OW00032"] //적립포인트?></th>
					<td><?=getCurMark($orderRow['O_USE_CUR'])?> <strong class="priceBoldGray"><?=getFormatPrice($orderRow[O_TOT_CUR_POINT],2,$orderRow["O_USE_CUR"])?> P</strong></td>
				</tr//-->
				<?}?>
				<tr>
					<th><?=$LNG_TRANS_CHAR["OW00046"] //결제상태?></th>
					<td><?=$S_ARY_SETTLE_STATUS[$orderRow[O_STATUS]]?></td>
				</tr>
				<?if ($orderRow[O_SETTLE] == "B"){?>
				<tr>
					<th><?=$LNG_TRANS_CHAR["OW00071"] //입금계좌?></th>
					<td>
						<?=$orderRow[O_BANK_ACC]?> <?=$orderRow[O_BANK_NAME]?>
					</td>
				</tr>
				<?}?>
				<?if ($orderRow[O_SETTLE] == "T"){?>
				<tr>
					<th>가상계좌</th>
					<td>
						[<?=$strReturnBankName?>] <?=$orderRow[O_BANK_ACC]?>
						입금마감시간 : <?=SUBSTR($orderRow[O_BANK_VALID_DT],0,4)?>년 <?=SUBSTR($orderRow[O_BANK_VALID_DT],4,2)?>월 <?=SUBSTR($orderRow[O_BANK_VALID_DT],6,2)?>일 
					</td>
				</tr>
				<?}?>
				
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
							<li><span><?=$LNG_TRANS_CHAR["OW00051"] //상품가격?></span>: <?=getCurMark($orderRow["O_USE_CUR"])?> <strong><?=getFormatPrice($orderRow[O_TOT_PRICE],2,$orderRow["O_USE_CUR"])?></strong><?=getCurMark2($orderRow["O_USE_CUR"])?></li>
							
							<?if (!$S_FIX_ORDER_DELIVERY_INFO_YN || $S_FIX_ORDER_DELIVERY_INFO_YN == "Y"){ //주문시 배송정보를 사용하지 않을때?>

							<li><span><?=$LNG_TRANS_CHAR["PW00012"] //배송비?></span>: <?=getCurMark($orderRow["O_USE_CUR"])?> <strong><?=getFormatPrice($orderRow[O_TOT_DELIVERY_PRICE],2,$orderRow["O_USE_CUR"])?></strong><?=getCurMark2($orderRow["O_USE_CUR"])?></li>
							
							<?}?>

							<?if ($orderRow[O_TOT_MEM_DISCOUNT_PRICE] > 0){?>
							<li><span><?=$LNG_TRANS_CHAR["OW00070"] //추가할인금액?></span>: <?=getCurMark($orderRow["O_USE_CUR"])?> <?=getFormatPrice($orderRow[O_TOT_MEM_DISCOUNT_PRICE],2,$orderRow["O_USE_CUR"])?><?=getCurMark2($orderRow["O_USE_CUR"])?>
							</li>
							<?}?>
							
							<?if ($orderRow[M_NO] && $orderRow[O_USE_POINT] > 0){?><li><span><?=$LNG_TRANS_CHAR["OW00045"] //사용포인트?></span>: <strong><?=getFormatPrice($orderRow[O_USE_POINT],2,$orderRow["O_USE_CUR"])?></strong></li><?}?>
							<?if ($orderRow[O_USE_COUPON] > 0){?><li><span><?=$LNG_TRANS_CHAR["OW00081"] //사용쿠폰?></span>: <?=getCurMark($orderRow["O_USE_CUR"])?> 
							<strong><?=getFormatPrice($orderRow[O_USE_COUPON],2,$orderRow["O_USE_CUR"])?></strong><?=getCurMark2($orderRow["O_USE_CUR"])?></li><?}?>
							<li class="totPayPrice"><span><?=$LNG_TRANS_CHAR["OW00026"] //결제금액?></span>: <?=getCurMark($orderRow["O_USE_CUR"])?> <strong class="priceOrange"><?=getFormatPrice($orderRow[O_TOT_SPRICE],2,$orderRow["O_USE_CUR"])?><?=getCurMark2($orderRow["O_USE_CUR"])?></strong></li>
						</ul>
					</td>
				</tr>					
			</table>
		</div><!-- tableOrderForm -->
	<!-- (4) 결제내역 정보 -->
		<div class="btnCenter">
			<?if ($g_member_no){?>
			<a href="javascript:goBuyList()" class="okBigBtn"><span><?=$LNG_TRANS_CHAR["CW00001"] //확인?></span></a>
			<?}else{?>
			<a href="javascript:goBuyNonList()" class="okBigBtn"><span><?=$LNG_TRANS_CHAR["CW00001"] //확인?></span></a>
			<?}?>
			<?if ($SHOP_USER_ADD_MENU_USE == "Y" && $SHOP_USER_ADD_MENU_["ORDER"]["USE"] == "Y"){
				if ($orderUploadCheckRow['orderend'] != 1){
				?>
			<a href="./?menuType=order&mode=nextOrderStep&step=1&oNo=<?=$orderRow['O_NO']?>" class="mypageLinkBigBtn"><span><?=$SHOP_USER_ADD_MENU_["ORDER"]["NAME_".$S_SITE_LNG]?></span></a>
			<?}}?>
		</div>