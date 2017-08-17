<? include "./include/header.inc.php"?>
<?
	require_once MALL_CONF_LIB."OrderAdmMgr.php";
	
	/*상품함수관련*/
	require_once MALL_PROD_FUNC;

	$orderMgr = new OrderMgr();

	$intO_NO		= $_POST["no"]				? $_POST["no"]				: $_REQUEST["no"];
	$intSH_NO		= $_POST["comNo"]			? $_POST["comNo"]			: $_REQUEST["comNo"];
	$strReqPath		= $_POST["path"]			? $_POST["path"]			: $_REQUEST["path"];
	
	if (!$intO_NO){
		$db->disConnect();
		goClose($LNG_TRANS_CHAR["OS00002"]); //"주문정보가 존재하지 않습니다."
		exit;
	}

	/* 기준언어가 KR이 아닐 경우 확인 */
	$orderMgr->setP_LNG($strStLng);
	$orderMgr->setO_NO($intO_NO);

	$orderRow = $orderMgr->getOrderView($db);

	$intCartTotal= $orderMgr->getOrderCartTotal($db);
	$orderMgr->setPageLine($intCartTotal);
	$orderMgr->setLimitFirst(0);

	$cartResult = $orderMgr->getOrderCartList($db);

	/* 고객사은품 */
	$aryOrderGiftList = $orderMgr->getOrderGiftList($db);


?>
<style type="text/css">
	#contentArea{position:relative;min-width:750px;padding:10px}
</style>
<script type="text/javascript">
<!--
	$(document).ready(function(){
		
	});
//-->
</script>
<div class="layerPopWrap">
	<div class="popTop">
		<h2><?=callLangTrans($LNG_TRANS_CHAR["OS00001"],array($orderRow[O_KEY]))?> <!--주문번호는 <strong class="priceOrange"><?=$orderRow[O_KEY]?></strong>입니다.//--></h2>			
		<a  href="javascript:parent.goPopClose();"><img src="/shopAdmin/himg/common/btn_pop_close.png" class="closeBtn"/></a>
		<div class="clr"></div>
	</div>
</div>

<div id="contentArea">
<form name="form" method="post">
<input type="hidden" name="no" value="<?=$intO_NO?>">
	<table style="width:100%;">
		<tr>
			<td class="contentWrap">
				<!-- ******************** contentsArea ********************** -->
				<div class="layoutWrap">
					<div id="contentWrap">
						<!-- 장바구니 시작 -->
						<?if (!$intSH_NO || $intSH_NO == 0){?>
						<? include MALL_WEB_PATH."/shopAdmin/order/list/orderCartEndList.php";?>
						<?}?>
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
					<?if (!$intSH_NO || $intSH_NO == 0){?>
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
								<?if($orderRow['O_STATUS'] == "C"): // 주문취소 사유 ?>
								<tr>
									<th>주문취소 사유</th>
									<td><?=$orderRow['O_CEL_MEMO']?></td>
								</tr>
								<?endif;?>
								<?if ($orderRow[O_CASH_YN] == "Y"){?>
								<tr>
									<th>현금영수증</th>
									<td>
										현금요청번호 : <?=$orderRow[O_CASH_INFO]?>
										현금승인번호 : <?=$orderRow[O_CASH_AUTH_NO]?>
									</td>
								</tr>	
								<?}?>
							</table>
						</div>
					
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
											<li><span><?=$LNG_TRANS_CHAR["OW00023"] //상품가격?></span>: <?=getCurMark($S_ST_CUR)?>  <strong><?=getFormatPrice($orderRow[O_TOT_CUR_PRICE],2,$S_ST_CUR)?><?=getCurMark2($S_ST_CUR)?></strong></li>
											
											<?if ($orderRow[O_TAX_PRICE]>0){?>
											<li><span><?=$LNG_TRANS_CHAR["OW00084"] //부과세?></span>: <?=getCurMark($S_ST_CUR)?>  <strong><?=getFormatPrice($orderRow[O_TAX_CUR_PRICE],2,$S_ST_CUR)?><?=getCurMark2($S_ST_CUR)?></strong></li>
											<?}?>
											
											<?if ($orderRow[O_TOT_PG_COMMISSION]>0){?>
											<li><span><?=$LNG_TRANS_CHAR["OW00157"] //수수료?></span>: <?=getCurMark($S_ST_CUR)?>  <strong><?=getFormatPrice($orderRow[O_TOT_PG_CUR_COMMISSION],2,$S_ST_CUR)?><?=getCurMark2($S_ST_CUR)?></strong></li>
											<?}?>


											<li><span><?=$LNG_TRANS_CHAR["OW00027"] //배송비?></span>: <?=getCurMark($S_ST_CUR)?>  <strong><?=getFormatPrice($orderRow[O_TOT_DELIVERY_CUR_PRICE],2,$S_ST_CUR)?><?=getCurMark2($S_ST_CUR)?></strong></li>
											
											<?if ($orderRow[O_TOT_MEM_DISCOUNT_PRICE] > 0){?>
											<li><span><?=$LNG_TRANS_CHAR["OW00115"] //추가할인금액?></span>: <?=getCurMark($S_ST_CUR)?>  <strong><?=getFormatPrice($orderRow[O_TOT_MEM_DISCOUNT_PRICE],2,$S_ST_CUR)?><?=getCurMark2($S_ST_CUR)?></strong></li>
											<?}?>
											<?if ($orderRow[O_USE_POINT] > 0){?>
											<li><span><?=$LNG_TRANS_CHAR["OW00028"] //사용포인트?></span>: <strong><?=getFormatPrice($orderRow[O_USE_CUR_POINT],2)?></strong></li>		
											<?}?>
											<?if ($orderRow[O_USE_COUPON] > 0){?><li><span><?=$LNG_TRANS_CHAR["OW00116"] //사용쿠폰?></span>: <?=getCurMark($S_ST_CUR)?> 
											<strong><?=getFormatPrice($orderRow[O_USE_COUPON],2,$S_ST_CUR)?><?=getCurMark2($S_ST_CUR)?></strong></li><?}?>

											<li class="totPayPrice"><span><?=$LNG_TRANS_CHAR["OW00029"] //결제금액?></span>: <?=getCurMark($S_ST_CUR)?>  <strong class="priceOrange"><?=getFormatPrice($orderRow[O_TOT_CUR_SPRICE],2,$S_ST_CUR)?><?=getCurMark2($S_ST_CUR)?></strong></li>
										</ul>
									</td>
								</tr>					
							</table>
						</div>
						<?}?>
						<!-- tableOrderForm -->
						<!-- (4) 결제내역 정보 -->
					</div>
				</div>
				<!-- 추가 프로그램 -->
				<?
					if ($SHOP_USER_ADD_MENU_["ORDER"]["USE"] == "Y"){
							
						include "{$S_DOCUMENT_ROOT}{$S_SHOP_HOME}/layout/userAdd/userOrder/orderNextStepInfo.php";
					}
				?>
				<!-- 추가 프로그램 -->
			</td>
		</tr>
	</table>
</form>
</div>
<div class="buttonWrap">
	<?if ($strReqPath == "M"){?>
	<a class="btn_big" href="javascript:self.close();"><strong><?=$LNG_TRANS_CHAR["CW00042"] //창닫기?></strong></a>
	<?}else{?>
	<a class="btn_big" href="javascript:parent.goPopClose();"><strong><?=$LNG_TRANS_CHAR["CW00042"] //창닫기?></strong></a>
	<?}?>
</div>
	
	<!-- ******************** contentsArea ********************** -->

</body>
</html>