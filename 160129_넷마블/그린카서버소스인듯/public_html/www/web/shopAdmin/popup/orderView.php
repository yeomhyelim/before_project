<?
	require_once MALL_CONF_LIB."OrderMgr.php";
	
	/*상품함수관련*/
	require_once MALL_PROD_FUNC;

	$orderMgr = new OrderMgr();

	$intO_NO		= $_POST["no"]				? $_POST["no"]				: $_REQUEST["no"];
	
	if (!$intO_NO){
		$db->disConnect();
		goClose($LNG_TRANS_CHAR["OS00002"]); //"주문정보가 존재하지 않습니다."
		exit;
	}

	$orderMgr->setO_NO($intO_NO);

	$orderRow = $orderMgr->getOrderView($db);

	$intCartTotal= $orderMgr->getOrderCartTotal($db);
	$orderMgr->setPageLine($intCartTotal);
	$orderMgr->setLimitFirst(0);

	$cartResult = $orderMgr->getOrderCartList($db);

?>
<? include "./include/header.inc.php"?>
<script type="text/javascript">
<!--
	$(document).ready(function(){
		
	});


//-->
</script>
<div id="contentArea">
	<table style="width:100%;">
		<tr>
			<td class="contentWrap">
				<!-- ******************** contentsArea ********************** -->
				<div class="layoutWrap">
					<div id="contentWrap">
						<div class="paymentInfo mt20">
							<ul>
								<li><?=callLangTrans($LNG_TRANS_CHAR["OS00001"],array($orderRow[O_KEY]))?> <!--주문번호는 <strong class="priceOrange"><?=$orderRow[O_KEY]?></strong>입니다.//--></li>
							</ul>
						</div>

						<!-- 결제완료 안내 -->
						<!-- 장바구니 시작 -->
						<? include MALL_WEB_PATH."/shopAdmin/popup/orderCartEndList.php";?>
						<!-- 장바구니 끝 -->

						<!-- (1) 주문자 정보 -->
						<div class="tableOrderForm mt10">
							<h4><?=$LNG_TRANS_CHAR["OW00030"] //주문자 정보?></h4>
							<table>
								<colgroup>
									<col style="width:100px;"/>
									<col/>
								</colgroup>
								<tr>
									<th><?=$LNG_TRANS_CHAR["OW00003"] //주문자명?></th>
									<td><?=$orderRow[O_J_NAME]?></td>
								</tr>
								<tr>
									<th><?=$LNG_TRANS_CHAR["OW00031"] //전화번호?></th>
									<td><?=$orderRow[O_J_PHONE]?></td>
								</tr>
								<tr>
									<th><?=$LNG_TRANS_CHAR["OW00032"] //핸드폰?></th>
									<td><?=$orderRow[O_J_HP]?></td>
								</tr>
								<tr>
									<th><?=$LNG_TRANS_CHAR["OW00033"] //이메일?></th>
									<td><?=$orderRow[O_J_MAIL]?></td>
								</tr>
							</table>
						</div><!-- tableOrderForm -->						
					<!-- (1) 주문자 정보 -->

					<!-- (2) 베송지 정보 -->
						<div class="tableOrderForm mt30">
							<h4><?=$LNG_TRANS_CHAR["OW00034"] //배송지 정보?></h4>
							
							<table>
								<colgroup>
									<col style="width:100px;"/>
									<col/>
								</colgroup>
								<tr>
									<th><?=$LNG_TRANS_CHAR["OW00035"] //받으실 분?></th>
									<td><?=$orderRow[O_B_NAME]?></td>
								</tr>
								<tr>
									<th><?=$LNG_TRANS_CHAR["OW00031"] //전화번호?></th>
									<td><?=$orderRow[O_B_PHONE]?></td>
								</tr>
								<tr>
									<th><?=$LNG_TRANS_CHAR["OW00032"] //핸드폰?></th>
									<td><?=$orderRow[O_B_HP]?></td>
								</tr>
								<tr>
									<th><?=$LNG_TRANS_CHAR["OW00033"] //이메일?></th>
									<td><?=$orderRow[O_B_MAIL]?></td>
								</tr>
								<tr>
									<th><?=$LNG_TRANS_CHAR["OW00036"] //주소?> </th>
									<td>[<?=$orderRow[O_B_ZIP]?>] <?=$orderRow[O_B_ADDR1]?> <?=$orderRow[O_B_ADDR2]?></td>
								</tr>
								<tr>
									<th><?=$LNG_TRANS_CHAR["OW00047"] //메모?> </th>
									<td><?=$orderRow[O_B_MEMO]?></td>
								</tr>
							</table>
						</div><!-- tableOrderForm -->
					<!-- (2) 배송지 정보 -->

					<!-- (3) 결제방법 정보 -->
						<div class="tableOrderForm mt30">
							<h4><?=$LNG_TRANS_CHAR["OW00006"] //결제방법?></h4>
							<table>
								<colgroup>
									<col style="width:100px;"/>
									<col/>
								</colgroup>
								<tr>
									<th><?=$LNG_TRANS_CHAR["OW00006"] //결제방법?></th>
									<td><?=$S_ARY_SETTLE_TYPE[$orderRow[O_SETTLE]]?></td>
								</tr>
								<tr>
									<th><?=$LNG_TRANS_CHAR["OW00037"] //적립포인트?></th>
									<td><?=getCurMark()?> <strong class="priceBoldGray"><?=getFormatPrice($orderRow[O_TOT_CUR_POINT],2)?></strong></td>
								</tr>
								<tr>
									<th><?=$LNG_TRANS_CHAR["OW00038"] //결제상태?></th>
									<td><?=$S_ARY_SETTLE_STATUS[$orderRow[O_STATUS]]?></td>
								</tr>

								
							</table>
						</div><!-- tableOrderForm -->
					<!-- (3) 결제방법 정보 -->

					<!-- (4) 결제내역 정보 -->
						<div class="tableOrderForm mt30">
							<h4><?=$LNG_TRANS_CHAR["OW00039"] //결제내역?></h4>
							<table>
								<colgroup>
									<col style="width:100px;"/>
									<col/>
								</colgroup>
								<tr>
									<th><?=$LNG_TRANS_CHAR["OW00008"] //결제금액?></th>
									<td>
										<ul class="priceInfo">
											<li><?=getCurMark()?>  <span><?=$LNG_TRANS_CHAR["OW00023"] //상품가격?></span>: <strong><?=getFormatPrice($orderRow[O_TOT_CUR_PRICE],2)?></strong></li>
											<li><?=getCurMark()?>  <span><?=$LNG_TRANS_CHAR["OW00027"] //배송비?></span>: <strong><?=NUMBER_FORMAT($orderRow[O_TOT_DELIVERY_CUR_PRICE])?></strong></li>
											<li><?=getCurMark()?>  <span><?=$LNG_TRANS_CHAR["OW00028"] //사용포인트?></span>: <strong><?=getFormatPrice($orderRow[O_USE_CUR_POINT],2)?></strong></li>							
											<li class="totPayPrice"><?=getCurMark()?>  <span><?=$LNG_TRANS_CHAR["OW00029"] //결제금액?></span>: <strong class="priceOrange"><?=getFormatPrice($orderRow[O_TOT_CUR_SPRICE],2)?></strong></li>
										</ul>
									</td>
								</tr>					
							</table>
						</div><!-- tableOrderForm -->
					<!-- (4) 결제내역 정보 -->
					</div>
					<div class="buttonWrap">
						<a class="btn_big" href="javascript:self.close();"><strong><?=$LNG_TRANS_CHAR["CW00042"] //창닫기?></strong></a>
					</div>
				</div>
				
				<!-- ******************** contentsArea ********************** -->
			</td>
		</tr>
	</table>
</div>
</body>
</html>