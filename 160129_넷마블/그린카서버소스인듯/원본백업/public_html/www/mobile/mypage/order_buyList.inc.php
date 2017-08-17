<?php
	/**
	 * eumshop - mobile - mypage - buyList
	 *
	 * 주문내역 리스트
	 *
	 * @package		eumshop shopping mall
	 * @author		ExpressionEngine Dev HeeSung Kim
	 * @copyright	Copyright (c) 2012 - 2013, Eumshop, Inc.
	 * @license		http://www.eumshop.com/user_guide/license.html
	 * @link		http://www.eumshop.com
	 * @since		Version 1.0
	 * @filesource	/www/mobile/mypage/order_buyList.inc.php
	 * @manual		
	 * @history
	 *				2014.06.16 kim hee sung - 소스 정리
	 */

	## 전체 주문개수
	## 주문 취소 개수는 포함되어 있지 않습니다.
	$strOrderTotal = $intOrderWaitTotal + $intOrderApprTotal + $intOrderDeliveryTotal + $intOrderEndTotal;
	$strOrderTotal = number_format($strOrderTotal);

	## 페이지 제목 설정
	$strPageTitle = $LNG_TRANS_CHAR["CW00027"]; // 주문배송조회
	if($strSearchOrderStatus == "UI") { $strPageTitle = $LNG_TRANS_CHAR["CW00029"]; } // 주문배송조회 
	else if($strSearchOrderStatus == "E") { $strPageTitle = $LNG_TRANS_CHAR["CW00030"]; } // 구매완료목록 
	else if($strSearchOrderStatus == "R") { $strPageTitle = $LNG_TRANS_CHAR["CW00020"]; } // 구매완료목록 
	else if($strSearchOrderStatus == "A") { $strPageTitle = $LNG_TRANS_CHAR["CW00028"]; } // 결제완료목록 

	## 주문 상세 페이지 설정
	$strViewType = "buyView";
	if(!$g_member_no) { $strViewType = "buyNonView"; }

?>
<?php if($strMode == "buyList"):?>

<!-- 제목 //-->
<h2><?php echo $strPageTitle;?></h2>
<!-- 제목 //-->

<!-- 주문현황 //-->
<div class="orderStateWrap">
	<div class="totalCntWrap">
		<a href="./?menuType=mypage&mode=buyList"><strong>Total:</strong> <strong class="txtCnt"><?php echo $strOrderTotal;?></strong></a>
	</div>
	<div class="stateIconWrap">
		<ul>
			<li  class="orderCnt1"><a href="./?menuType=mypage&mode=buyList&searchOrderStatus=J" class="orderIco1"><?php echo $LNG_TRANS_CHAR["CW00027"] //주문;?> <strong>(<?php echo $intOrderWaitTotal;?>)</strong></a></li>
			<li  class="orderCnt2"><a href="./?menuType=mypage&mode=buyList&searchOrderStatus=A" class="orderIco2"><?php echo $LNG_TRANS_CHAR["CW00028"] //결제;?> <strong>(<?php echo $intOrderApprTotal;?>)</strong></a></li>
			<li  class="orderCnt3"><a href="./?menuType=mypage&mode=buyList&searchOrderStatus=UI" class="orderIco3"><?php echo $LNG_TRANS_CHAR["CW00029"] //배송;?> <strong>(<?php echo $intOrderDeliveryTotal;?>)</strong></a></li>
			<li  class="orderCnt4"><a href="/?menuType=mypage&mode=buyList&searchOrderStatus=E" class="orderIco4"><?php echo $LNG_TRANS_CHAR["CW00030"] //확인;?> <strong>(<?php echo $intOrderEndTotal;?>)</strong></a></li>
		</ul>
		<div class="clr"></div>
	</div>
</div>
<!-- 주문현황 //-->
<?php endif;?>

<!-- 주문내역 //-->
<div class="myOrderListWrap">
	<?php if(!$intTotal):?>
	<div class="dataNoList"><?php echo $LNG_TRANS_CHAR["OS00044"]; //주문내역이 없습니다.?></div>
	<?php else:?>
	<?php while($row = mysql_fetch_array($result)):
			
			## 기본설정
			$intO_NO = $row['O_NO'];
			$strO_KEY = $row['O_KEY'];
			$strO_STATUS = $row['O_STATUS'];
			$strO_REG_DT = $row['O_REG_DT'];
			$strO_J_TITLE = $row['O_J_TITLE'];
			$intO_TOT_SPRICE = $row['O_TOT_SPRICE'];
			$intO_TOT_CUR_PRICE = $row['O_TOT_CUR_PRICE'];
			$intO_PROD_QTY = $row['O_PROD_QTY'];
			$strO_STATUS = $row['O_STATUS'];
			$strO_DELIVERY_COM = $row['O_DELIVERY_COM'];
			$strO_DELIVERY_NUM = $row['O_DELIVERY_NUM'];
			$strO_PG = $row['O_PG'];
			$strO_ESCROW = $row['O_ESCROW'];
			$strO_APPR_NO = $row['O_APPR_NO'];
			$strO_KEY = $row['O_KEY'];
			$strO_USE_CUR = $row['O_USE_CUR'];
			$strPM_REAL_NAME = $row['PM_REAL_NAME'];
			$strP_CODE = $row['P_CODE'];


			## 주문상태 설정
			$strSettleStatusName = $S_ARY_SETTLE_STATUS[$strO_STATUS];

			## 주문일 설정
			$strRegDate = date("Y-m-d", strtotime($strO_REG_DT));
	
			## 주문금액 설정
			$strPrice = getFormatPrice($intO_TOT_PRICE,2,$row['O_USE_CUR']);
			$strPrice = getCurMark($row['O_USE_CUR']) . " " . $strPrice . getCurMark2($row['O_USE_CUR']);
			
			## 결제금액 설정
			$strPayTotal = "";
			$strPayTotal = getFormatPrice($intO_TOT_SPRICE,2,$row['O_USE_CUR']);
			$strPayTotal = getCurMark($row['O_USE_CUR']) . " " . $strPayTotal . getCurMark2($row['O_USE_CUR']);

			## 주문 수량 설정
			$strProdQty = "";
			$strProdQty = number_format($intO_PROD_QTY);

			## 배송 정보 설정
			$strDeliveryCom = "";
			$strDeliveryNum = "";
			if(in_array($strO_STATUS, array("I","D")) && $strO_DELIVERY_COM && $strO_DELIVERY_NUM):
				$strDeliveryCom = $aryDeliveryCom[$strO_DELIVERY_COM];	
				$strDeliveryCom = "{$strDeliveryCom} 택배";
				$strDeliveryNum = $strO_DELIVERY_NUM;

				## 조회 URL 설정
//				if($strO_PG == "K"):
					$strDeliveryUrl = $aryDeliveryUrl[$strO_DELIVERY_COM];
					if($strDeliveryUrl):
						$strDeliveryNum = "<a href='{$strDeliveryUrl}{$strDeliveryNum}' class='priceBoldGray' target='_blank'>{$strDeliveryNum}</a>";
					endif;
//				endif;
			endif;

			## 주문 취소 설정
			## 주문중,입금확인중,결제완료일때 취소가능
			$btnOrderCancel = "";
			if(in_array($strO_STATUS, array("J","O","A"))):
				$btnOrderCancel = "<a href='javascript:goMyOrderCancel({$intO_NO})' class='btnOrderCancel'><span>{$LNG_TRANS_CHAR['CW00051']}</span></a>";
			endif;

			## 배송완료 사용자 체크 버튼 설정
			## 배송시작/배송중/배송완료
			$btnOrderOk = "";
			if(in_array($strO_STATUS, array("B","I","D")) && $strO_ESCROW == "Y" && $strO_PG == "K"):
				$btnOrderOk = "<a href='{$S_KCP_BUY_OK}{$g_conf_site_cd}&tno={$strO_APPR_NO}&order_no={$strO_KEY}' target='_blank'><img src='/himg/mypage/A0001/{$S_SITE_LNG_PATH}/btn_prod_delivery_ok.gif'/></a>";
			endif;
			
			## 나피큐어 추가 프로그램
			$btnOrderNextStep			= "";
			if ($SHOP_USER_ADD_MENU_USE == "Y" && $SHOP_USER_ADD_MENU_["ORDER"]["USE"] == "Y"){
				$param					= "";
				$param['O_NO']			= $row['O_NO'];
				$orderUploadCheckRow	= $orderMgr->getOrderUploadFileCheck($db,$param);				
				$btnOrderNextStep		= "<div class=\"btnWrap\"><span class='btnOrderNextStepEnd'>사진등록완료</span></a></div>";

				if ($orderUploadCheckRow['orderend'] != 1){
					$btnOrderNextStep		= "<a href=\"./?menuType=order&mode=orderNextStep&step=1&oNo={$row['O_NO']}\" class='btnOrderNextStepIng'>";
					$btnOrderNextStep      .= "<span>{$SHOP_USER_ADD_MENU_['ORDER']['NAME_'.$S_SITE_LNG]}</span></a>";
				}
			}
	?>
	<div class="myOrderList">
		<!-- 상품정보 //-->
		<div class="prodInfo">
			<div class="prodListImg"><a href="./?menuType=product&mode=view&prodCode=<?php echo $strP_CODE;?>"><img src="<?php echo $strPM_REAL_NAME;?>"/></a></div>
			<div>
				<!-- 주문상태, 주문일자 //-->
				<span class="icoStateWrap"><?php echo $strSettleStatusName;?></span> <span class="date"><?php echo $strRegDate;?></span>
				<!-- 주문상태, 주문일자 //-->
				<!-- 주문번호 //-->
				<span class="orderKey" onClick="goOrderView('<?php echo $strViewType;?>', <?php echo $intO_NO;?>)"><?php echo $strO_KEY;?></span>
				<!-- 주문번호 //-->
				<!-- 상품이름 //-->
				<span class="title"><?php echo $strO_J_TITLE;?></span>
				<!-- 상품이름 //-->
				<div class="orderCnt">
					<!-- 주문금액 //-->
					<strong class="price"><?php echo $strPrice;?></strong>
					<!-- 주문금액 //-->
					<!-- 수량 //-->
					(<strong><?php echo $strProdQty;?></strong>)
					<!-- 수량 //-->
					<!-- 결제금액 //-->
					<strong class="priceOrange"><?php echo $strPayTotal;?></strong>
					<!-- 결제금액 //-->
				</div>
				<?php if($strDeliveryCom):?>
				<!-- 배송 정보 //-->
				<div class="orderState">
					<ul>
						<li><span>배송사</span>: <?php echo $strDeliveryCom;?></li>
						<li><span>송장번호</span>: <?php echo $strDeliveryNum;?></li>
					</ul>
				</div>
				<!-- 배송 정보 //-->
				<?php endif;?>
			</div>
		</div>
		<!-- 상품정보 //-->
		<?php echo $btnOrderCancel; // 주문취소버튼?>
		<?php echo $btnOrderOk; // 배송 완료 버튼?>
		<?php echo $btnOrderNextStep; // 나피큐어 추가 프로그램 버튼?>

	</div>
	<?php endwhile;?>
	<div id="pagenate">
		<?=drawUserPaging($intPage,$intPageLine,$intPageBlock,$intTotal,$intTotPage,$linkPage,"","","","","")?>
	</div>
	<?php endif;?>
</div>
<!-- 주문내역 //-->

