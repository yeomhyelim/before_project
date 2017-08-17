	<!-- div class="cartTabWrap">
		<div class="tabAtvBtn">
			<a href="./?menuType=order&mode=buyList&searchOrderStatus=" <?=$strTabSelectClass1?>><?=$LNG_TRANS_CHAR["OW00047"] //전체?>(<?=NUMBER_FORMAT($intOrderTotal)?>)</a>
			<a href="./?menuType=order&mode=buyList&searchOrderStatus=UI" <?=$strTabSelectClass2?>><?=$LNG_TRANS_CHAR["OW00048"] //배송중 상품?>(<?=NUMBER_FORMAT($intOrderDeliveryTotal)?>)</a>
			<a href="./?menuType=order&mode=buyList&searchOrderStatus=E" <?=$strTabSelectClass3?>><?=$LNG_TRANS_CHAR["OW00049"] //구매완료 상품?>(<?=NUMBER_FORMAT($intOrderEndTotal)?>)</a>
			<a href="./?menuType=order&mode=buyList&searchOrderStatus=R" <?=$strTabSelectClass4?>><?=$LNG_TRANS_CHAR["OW00050"] //반품/환불/취소 상품?>(<?=NUMBER_FORMAT($intOrderBackTotal)?>)</a>
		</div>
	</div -->
	<!-- 주문현황 -->
	<?
	if ($strMode == "buyList"){
		$strOrderCnt1 = "orderCnt1";
		$strOrderCnt2 = "orderCnt2";
		$strOrderCnt3 = "orderCnt3";
		$strOrderCnt4 = "orderCnt4";
		if ($intOrderWaitTotal > 0)			{ $strOrderCnt1 = "orderCnt1_on"; }
		if ($intOrderApprTotal > 0)			{ $strOrderCnt2 = "orderCnt2_on"; }
		if ($intOrderDeliveryTotal > 0)		{ $strOrderCnt3 = "orderCnt3_on"; }
		if ($intOrderEndTotal > 0)			{ $strOrderCnt4 = "orderCnt4_on"; }

		if($strSearchOrderStatus == 'R')
		{
	?>
	<div class="orderCancelWrap">
		<!--div class="totalPointWrap">
			<strong>total:</strong> <strong class="txtCnt"><?=NUMBER_FORMAT($memberRow['M_POINT'])?></strong>
		</div>
		<<div class="totalCntWrap">
			<strong>total:</strong> <strong class="txtCnt"><?=($intOrderWaitTotal + $intOrderApprTotal + $intOrderDeliveryTotal + $intOrderEndTotal)?></strong>
		</div>//-->
		<div class="stateIconWrap">
			<ul>
				<li><div class="<?=$strOrderCnt1?>"><?=$LNG_TRANS_CHAR["MW00044"] //취소 ?> <strong>(<?=$intOrderCancelTotal;?>)</strong></div></li>
				<li><div class="<?=$strOrderCnt2?>"><?=$LNG_TRANS_CHAR["CW00087"] //반품 ?> <strong>(<?=$intOrderReturnTotal;?>)</strong></div></li>
				<li style="border-right:none;"><div class="<?=$strOrderCnt4?>"><?=$LNG_TRANS_CHAR["CW00088"] //CW00088 ?> <strong>(<?=$intOrderExchangeTotal;?>)</strong></div></li>
			<ul>
			<div class="clr"></div>
		</div>
		<div class="clr"></div>
	</div>
	<?
		}
		else
		{
	?>
	<div class="orderStateWrap">
		<!--div class="totalPointWrap">
			<strong>total:</strong> <strong class="txtCnt"><?=NUMBER_FORMAT($memberRow['M_POINT'])?></strong>
		</div>
		<<div class="totalCntWrap">
			<strong>total:</strong> <strong class="txtCnt"><?=($intOrderWaitTotal + $intOrderApprTotal + $intOrderDeliveryTotal + $intOrderEndTotal)?></strong>
		</div>//-->
		<div class="stateIconWrap">
			<ul>
				<li><div class="<?=$strOrderCnt1?>"><?=$LNG_TRANS_CHAR["CW00027"] //주문?> <strong>(<?=$intOrderWaitTotal?>)</strong></div></li>
				<li><div class="<?=$strOrderCnt2?>"><?=$LNG_TRANS_CHAR["CW00028"] //결제?> <strong>(<?=$intOrderApprTotal?>)</strong></div></li>
				<li><div class="<?=$strOrderCnt3?>"><?=$LNG_TRANS_CHAR["CW00029"] //배송?> <strong>(<?=$intOrderDeliveryTotal?>)</strong></div></li>
				<li style="border-right:none;"><div class="<?=$strOrderCnt4?>"><?=$LNG_TRANS_CHAR["CW00030"] //확인?> <strong>(<?=$intOrderEndTotal?>)</strong></div></li>
			<ul>
			<div class="clr"></div>
		</div>
		<div class="clr"></div>
	</div>
	<?
		}
	?>
	<!-- 주문현황 -->
	<?}?>
	<?if ($strSearchOrderStatus==""):?>
		<h4 class="orderState_1"><span><?=$LNG_TRANS_CHAR["CW00017"] //주문배송조회?></span></h4>
	<?elseif ($strSearchOrderStatus=="UI"):?>
		<h4 class="orderState_2"><span><?=$LNG_TRANS_CHAR["CW00018"] //배송중목록?></span></h4>
	<?elseif ($strSearchOrderStatus=="E"):?>
		<h4 class="orderState_3"><span><?=$LNG_TRANS_CHAR["CW00019"] //구매완료목록?></span></h4>
	<?elseif ($strSearchOrderStatus=="R"):?>
		<h4 class="orderState_4"><span><?=$LNG_TRANS_CHAR["CW00020"] //취소/반품/교환?></span></h4>
	<?endif;?>

	<div class="myOrderListWrap mt10">
		<table>
			<colgroup>
				<col style="width:80px;"/>
				<col/>
				<col/>
				<col/>
				<col/>
				<col/>
				<?if ($strSearchOrderStatus=="R"){?>
				<col/>
				<?}?>
			</colgroup>
			<thead>
			<tr>
				<th class="orderDateDiv"><?=$LNG_TRANS_CHAR["OS00065"] //주문일?></th>
				<th><?=$LNG_TRANS_CHAR["OW00001"] //상품정보?></th>
				<th><?=$LNG_TRANS_CHAR["OW00051"] //주문금액?></th>
				<th><?=$LNG_TRANS_CHAR["OW00003"] //수량?></th>
				<th><?=$LNG_TRANS_CHAR["OW00026"] //결제금액?></th>
				<th class="orderMngDiv"><?=$LNG_TRANS_CHAR["CW00007"] //관리?></th>
				<?if ($strSearchOrderStatus=="R"){?>
				<th class="ordeStateDiv"><?=$LNG_TRANS_CHAR["OW00053"] //취소여부?></th>
				<?}?>
			</tr>
			</thead>
			<?if ($intTotal == 0){?>
			<tr>
				<td colspan="7" class="dataNoList"><?=$LNG_TRANS_CHAR["OS00044"] //주문내역이 없습니다.?></td>
			</tr>
			<?}else{

				while($row = mysql_fetch_array($result)){
					$btnOrderCancel1 = $btnOrderCancel2 = $btnOrderOk = $strOrderCancelYN = $strOrderDeliveryUrl = "";

					/* 다운로드 형식의 상품을 결제했을 경우에는 주문취소/주문완료가 아닐 경우에는 모두 보이게 처리(프리스타일) */
					$btnOrderProdDownload		= "";
					$intOrderProdDownloadCnt	= 0;
					if ($S_FIX_PROD_LIST_USER_FLAG == "Y"){
						$param = "";
						$param['O_NO']				= $row['O_NO'];
						$param['PROD_CATE_NOT_IN']	= $S_FIX_PROD_VIEW_MOVIE_CATE_NOT_LIST;
						$intOrderProdDownloadCnt	= $orderMgr->getOrderCartDownLoadList($db,"OP_COUNT",$param);
						if ($intOrderProdDownloadCnt > 0){
							if (!in_array($row['O_STATUS'],array('J','O','C','R','T'))){
								if ($row['APPR_DAY'] < 4){
									$btnOrderProdDownload = "<a href=\"javascript:goMyOrderProdDownload(".$row['O_NO'].");\" class=\"download\"><span>Download</span></a>";
								}
							}
						}
					}

					$strOrderStatus = $row[O_STATUS];
					/*주문중,입금확인중,결제완료일때 취소가능*/
					if ($strOrderStatus == "J" || $strOrderStatus == "O" || $strOrderStatus == "A"){
						if ($intOrderProdDownloadCnt == 0){
							$btnOrderCancel1 = "<a href=\"javascript:goMyOrderCancel(".$row[O_NO].");\" class=\"btnOrderCancel\"><span>".$LNG_TRANS_CHAR["CW00051"]."</span></a>";
						}
					}

					/* 배송시작/배송중/배송완료일때 에스크로 결제일 경우 정산보류->주문취소신청*/
					if (($S_MALL_TYPE == "R" && ($strOrderStatus == "B" || $strOrderStatus== "I" || $strOrderStatus == "D")) || ($S_MALL_TYPE == "M" && $strOrderStatus == 'D')){
						if ($row['O_ESCROW'] == "Y"){
							//$btnOrderCancel2 = "<a href=\"javascript:goMyOrderCancel(".$row[O_NO].");\"><img src=\"/himg/mypage/A0001/btn_order_cancel.gif\"/></a>";
							//$btnOrderCancel2 = "<a href=\"".$S_KCP_BUY_NO.$g_conf_site_cd."&tno=".$row[O_APPR_NO]."&order_no=".$row[O_KEY]."\" target=\"_blank\"><img src=\"/himg/mypage/A0001/btn_order_cancel.gif\"/></a>";

							//$row['O_PG'] ( K : KCP )
							if ($row['O_PG'] == "K" && $S_MALL_TYPE == "R"){
								$btnOrderOk = "<a href=\"".$S_KCP_BUY_OK.$g_conf_site_cd."&tno=".$row[O_APPR_NO]."&order_no=".$row[O_KEY]."\" target=\"_blank\" class=\"btnBuyOkCheck\">".$LNG_TRANS_CHAR["OW00100"]."</a>";
							} else if ($row['O_PG'] == "A"){
								$btnOrderOk = "<a href=\"javascript:goMyOrderCerityOk(".$row['O_NO'].");\" class=\"btnBuyOkCheck\">".$LNG_TRANS_CHAR["OW00100"]."</a>";
							}
						}
					}



					if ($row[O_STATUS] == "C")
					{
						$strOrderCancelYN = "Y";
						if ($row[O_CEL_STATUS] != "Y"){
							$strOrderCancelYN = "N";
						}
					}

					if ($row[O_DELIVERY_COM] && $row[O_DELIVERY_NUM]){
						if ($S_SITE_LNG == "KR" && (!$row[O_PG] || $row[O_PG] == "K")){
							$strOrderDeliveryUrl = str_replace("{dev_no}",$row[O_DELIVERY_NUM],$aryDeliveryUrl[$row[O_DELIVERY_COM]]);
						}
					}

					$strStatusClassName = "";
					switch($row[O_STATUS]){
						case "J":
							$strStatusClassName = "iconOrderOk";
						break;
						case "O":
							$strStatusClassName = "iconBankIng";
						break;
						case "A":
							$strStatusClassName = "iconPayOk";
						break;
						case "B":
							$strStatusClassName = "iconDeliveryReady";
						break;
						case "I":
							$strStatusClassName = "iconDeliveryIng";
						break;
						case "D":
							$strStatusClassName = "iconDeliveryOk";
						break;
						case "E":
							$strStatusClassName = "iconBuyEnd";
						break;
						case "C":
							$strStatusClassName = "iconOrderCancel";
						break;
						case "R":
							$strStatusClassName = "iconOrderReject";
						break;
						case "T":
							$strStatusClassName = "iconPayBack";
						break;
					}
				?>
			<tr>
				<td><?=SUBSTR($row['O_REG_DT'],0,10)?></td>
				<td class="prodInfo"><!--상품정보-->
					<a href="javascript:goOrderView('<?=($strMode=="buyList")? "buyView":"buyNonView";?>',<?=$row['O_NO']?>);"><img src="<?=$row['PM_REAL_NAME']?>" style="width:50px;"/></a>
					<ul>
						<li>
							<a href="javascript:goOrderView('<?=($strMode=="buyList")? "buyView":"buyNonView";?>',<?=$row['O_NO']?>);"><?=$row['O_J_TITLE']?></a>
							<?=$btnOrderProdDownload?>
							<?
							/* 사진업로드하기버튼(나피큐어)*/
							if ($SHOP_USER_ADD_MENU_USE == "Y" && $SHOP_USER_ADD_MENU_["ORDER"]["USE"] == "Y"){
								$param = "";
								$param['O_NO'] = $row['O_NO'];
								$orderUploadCheckRow = $orderMgr->getOrderUploadFileCheck($db,$param);

								if ($orderUploadCheckRow['orderend'] != 1){
								?>
								<a href="./?menuType=order&mode=nextOrderStep&step=1&oNo=<?=$row['O_NO']?>" class="">[<span><?=$SHOP_USER_ADD_MENU_["ORDER"]["NAME_".$S_SITE_LNG]?></span>]</a>
								<?}else{?>
								<span>[사진등록완료]</span>
							<?}}?>
						</li>
					</ul>
					<div class="clear"></div>
				</td>
				<td><strong class="priceBoldGray"><?=getCurMark($row["O_USE_CUR"])?> <?=getFormatPrice($row[O_TOT_PRICE],2,$row["O_USE_CUR"])?><?=getCurMark2($row["O_USE_CUR"])?></strong></td>
				<td><?=NUMBER_FORMAT($row[O_PROD_QTY])?></td>
				<td><strong class="priceOrange"><?=getCurMark($row["O_USE_CUR"])?> <?=getFormatPrice($row[O_TOT_SPRICE],2,$row["O_USE_CUR"])?><?=getCurMark2($row["O_USE_CUR"])?></strong></td>
				<td class="checkOrderBtn">
					<span class="<?=$strStatusClassName?>"><strong><?=$S_ARY_SETTLE_STATUS[$row['O_STATUS']]?></strong></span>
					<?=$btnOrderCancel1?>
					<?=$btnOrderCancel2?>
					<?=$btnOrderOk?>
					<?if ($strOrderStatus == "I" || $strOrderStatus == "D"){?>
					<?if ($S_MALL_TYPE == "R"){?>
					<ul class="deliveryInfo">
						<li><strong><?=$aryDeliveryCom[$row[O_DELIVERY_COM]]?></strong></li>
						<li><strong><?=$row[O_DELIVERY_NUM]?></strong></li>
						<li><a href="<?=$strOrderDeliveryUrl?>" class="deliveryChkBtn" target="_blank"><span>배송추적</span></a></li>
					</ul>
					<?}?>
					<?}?>
				</td>
				<?if ($strSearchOrderStatus=="R"){?>
				<td><?=$strOrderCancelYN?></td>
				<?}?>
			</tr>
			<?
					$intListNum--;
				}
			?>
			<?}?>
		</table>
	</div>

	<div id="pagenate">
		<?=drawUserPaging($intPage,$intPageLine,$intPageBlock,$intTotal,$intTotPage,$linkPage,"","","",""," | ")?>
	</div>
