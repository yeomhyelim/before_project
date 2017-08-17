<?
	## 스크립트 리스트 설정
	$aryScript				= "";
	$aryScript[]			= "./common/js/order/order.js";
	$aryScript[]			= "./common/js/common2.js";

	## 가상계좌 입금은행
	$aryTBank				= getCommCodeList("BANK2");

?>
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

	$orderMgr->setO_NO($intO_NO);

	$orderRow = $orderMgr->getOrderView($db);

	if ($a_admin_type == "S")
	{
		$orderMgr->setP_SHOP_NO($a_admin_shop_no);
	}
	$intCartTotal= $orderMgr->getOrderCartTotal($db);
	$orderMgr->setPageLine($intCartTotal);
	$orderMgr->setLimitFirst(0);

	$cartResult = $orderMgr->getOrderCartList($db);

	/* 고객사은품 */
	$aryOrderGiftList = $orderMgr->getOrderGiftList($db);

	## 기본 설정
	$strMemberNo			= $orderRow['M_NO'];
	$strRegDate				= $orderRow['O_REG_DT'];
	$strApprDate			= $orderRow['O_APPR_DT'];	// 결제승인일자
	$strSettel				= $orderRow['O_SETTLE'];	// T : 가상 계좌
	$strBank				= $orderRow['O_BANK'];		// 가상꼐좌 코드
	$strBankAcc				= $orderRow['O_BANK_ACC'];	// 입금계좌

	## 가상계좌 설정
	$strBankName			= "";
	if($strSettel == "T"):
		$strBankName		= $aryTBank[$strBank];
	endif;

	## 주문일자 설정
	$strRegDate				= date("Y-m-d H:i:s", strtotime($strRegDate)); 
	$strApprDate			= ($strApprDate) ? date("Y-m-d H:i:s", strtotime($strApprDate)) : "";

	## 착불배송비 설정
	$aryProdCartShopList = $orderMgr->getOrderCartShopList($db);

	if (is_array($aryProdCartShopList)){
		foreach ($aryProdCartShopList as $key => $value){
		
			$aryProdShopRow = $value;					
			$orderMgr->setP_SHOP_NO($key);
			$orderMgr->setLimitFirst(0);
			$orderMgr->setPageLine($value['CART_CNT']);
			$orderCartRet = $orderMgr->getOrderCartList($db);

			while($orderCartShopRow = mysql_fetch_array($orderCartRet)){

				/* 착불배송비 설정 (14.09.03)*/
				if ($orderCartShopRow['P_BAESONG_TYPE'] == "5") {
					$aryProdCartShopList[$key]['AFTER_CHARGE_CNT'] += 1;
				}
			}
		}
	}

	$aryDeliveryCom	= getCommCodeList("DELIVERY","Y");
	$aryDeliveryUrl	= getDeliveryUrlList();

//print_r($orderRow);
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
	<table style="width:100%;">
		<tr>
			<td class="contentWrap">
				<!-- ******************** contentsArea ********************** -->
				<div class="layoutWrap">
					<div id="contentWrap">
						<!-- 장바구니 시작 -->
						<?if ($a_admin_type == "S"){?>
						<? include MALL_WEB_PATH."/shopAdmin/order/mallList/orderCartShopEndList.php";?>
						<?}else{?>
						<? include MALL_WEB_PATH."/shopAdmin/order/mallList/orderCartEndList.php";?>
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
									<th>주문일시</th>
									<td><?=$strRegDate?></td>
								</tr>
								<tr>
									<th><?=$LNG_TRANS_CHAR["OW00003"] //주문자명?></th>
									<td><?=$orderRow[O_J_NAME]?>
										<a class="btn_sml" href="javascript:goMemberCrmView('<?=$strMemberNo?>', 'memberOrderList');" id="menu_auth_m" style=""><strong>CRM</strong></a></td>
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
					<?if ($a_admin_type != "S"){?>
						<div class="tableOrderForm mt30">
							<h4><?=$LNG_TRANS_CHAR["OW00006"] //결제방법?></h4>
							<table>
								<colgroup>
									<col style="width:100px;"/>
									<col/>
								</colgroup>
								<tr>
									<th><?=$LNG_TRANS_CHAR["OW00006"] //결제방법?></th>
									<td><?=$S_ARY_SETTLE_TYPE[$orderRow[O_SETTLE]]?>
										<?if($strSettel == "T"):?>
										(<?=$strBankName?>, <?=$strBankAcc?>)
										<?endif;?>
									</td>
								</tr>
								<tr>
									<th><?=$LNG_TRANS_CHAR["OW00037"] //적립포인트?></th>
									<td><?=getCurMark()?> <strong class="priceBoldGray"><?=getFormatPrice($orderRow[O_TOT_CUR_POINT],2)?></strong></td>
								</tr>
								<tr>
									<th><?=$LNG_TRANS_CHAR["OW00038"] //결제상태?></th>
									<td><?=$S_ARY_SETTLE_STATUS[$orderRow[O_STATUS]]?></td>
								</tr>
								<?if($strApprDate):?>
								<tr>
									<th>결제 일자</th>
									<td><?=$strApprDate?></td>
								</tr>
								<?endif;?>
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
											<li><?=getCurMark($S_ST_CUR)?>  <span><?=$LNG_TRANS_CHAR["OW00023"] //상품가격?></span>: <strong><?=getFormatPrice($orderRow[O_TOT_CUR_PRICE],2)?><?=getCurMark2($S_ST_CUR)?></strong></li>
											
											<?if ($orderRow[O_TAX_PRICE]>0){?>
											<li><span><?=$LNG_TRANS_CHAR["OW00084"] //부과세?></span>: <?=getCurMark($S_ST_CUR)?>  <strong><?=getFormatPrice($orderRow[O_TAX_CUR_PRICE],2)?><?=getCurMark2($S_ST_CUR)?></strong></li>
											<?}?>

											<li><?=getCurMark($S_ST_CUR)?>  <span><?=$LNG_TRANS_CHAR["OW00027"] //배송비?></span>: <strong><?=getFormatPrice($orderRow[O_TOT_DELIVERY_CUR_PRICE],2)?><?=getCurMark2($S_ST_CUR)?></strong></li>
											
											<?if ($orderRow[O_TOT_MEM_DISCOUNT_PRICE] > 0){?>
											<li><span><?=$LNG_TRANS_CHAR["OW00115"] //추가할인금액?></span>: <?=getCurMark($S_ST_CUR)?>  <strong><?=getFormatPrice($orderRow[O_TOT_MEM_DISCOUNT_PRICE],2)?><?=getCurMark2($S_ST_CUR)?></strong></li>
											<?}?>
											<?if ($orderRow[O_USE_POINT] > 0){?>
											<li><span><?=$LNG_TRANS_CHAR["OW00028"] //사용포인트?></span>: <strong><?=getFormatPrice($orderRow[O_USE_CUR_POINT],2)?></strong></li>		
											<?}?>
											<?if ($orderRow[O_USE_COUPON] > 0){?><li><span><?=$LNG_TRANS_CHAR["OW00116"] //사용쿠폰?></span>: <?=getCurMark($S_ST_CUR)?> 
											<strong><?=getFormatPrice($orderRow[O_USE_COUPON],2)?><?=getCurMark2($S_ST_CUR)?></strong></li><?}?>

											<li class="totPayPrice"><?=getCurMark($S_ST_CUR)?>  <span><?=$LNG_TRANS_CHAR["OW00029"] //결제금액?></span>: <strong class="priceOrange"><?=getFormatPrice($orderRow[O_TOT_CUR_SPRICE],2)?><?=getCurMark2($S_ST_CUR)?></strong></li>
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
			</td>
		</tr>
	</table>
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