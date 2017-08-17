
<?
	require_once MALL_CONF_LIB."OrderAdmMgr.php";
	
	$orderMgr = new OrderMgr();
	
	if (!$intM_NO){
		$db->disConnect();
		goClose($LNG_TRANS_CHAR["CS00013"]); //"해당 회원정보가 존재하지 않습니다."
		exit;
	}
	
	$strSearchOrderStatus = $_REQUEST["searchOrderStatus"];

	$memberMgr->setM_NO($intM_NO);
	$orderMgr->setM_NO($intM_NO);
	if ($a_admin_type == "S"){
		$orderMgr->setP_SHOP_NO($a_admin_shop_no);
	}


	$memberRow = $memberMgr->getMemberView($db);

	$intPageBlock	= 10;
	$intPageLine	= 10;
	
	$orderMgr->setPageLine($intPageLine);
	$intOrderTotal	= $orderMgr->getOrderTotal($db);
	
	if ($strSearchOrderStatus){
		$orderMgr->setSearchOrderStatus($strSearchOrderStatus);
	}

	$intTotal	= $orderMgr->getOrderTotal($db);
	$intTotPage	= ceil($intTotal / $orderMgr->getPageLine());

	if(!$intPage)	$intPage =1;

	if ($intTotal==0) {
		$intFirst	= 1;
		$intLast	= 0;			
	} else {
		$intFirst	= $intPageLine *($intPage -1);
		$intLast	= $intPageLine * $intPage;
	}
	$orderMgr->setLimitFirst($intFirst);
	$result = $orderMgr->getOrderList($db);

	$intListNum = $intTotal - ($intPageLine *($intPage-1));	
	
	$linkPage  = "?menuType=$strMenuType&mode=$strMode";
	$linkPage .= "&memberNo=$intM_NO&tab={$_REQUEST['tab']}&searchOrderStatus=$strSearchOrderStatus&page=";

	$orderMgr->setSearchOrderStatus("C");
	$intOrderCancelTotal	= $orderMgr->getOrderTotal($db);

	$orderMgr->setSearchOrderStatus("MR");
	$intOrderBackTotal	= $orderMgr->getOrderTotal($db);

	$orderMgr->setSearchOrderStatus("A");
	$intOrderApprTotal	= $orderMgr->getOrderTotal($db);

	$orderMgr->setSearchOrderStatus("J");
	$intOrderWaitTotal	= $orderMgr->getOrderTotal($db);

	$orderMgr->setSearchOrderStatus("UI");
	$intOrderDeliveryTotal	= $orderMgr->getOrderTotal($db);

	$intOrderApprPrice = $orderMgr->getOrderApprMemberPrice($db);

	$aryDeliveryCom = getCommCodeList("DELIVERY","Y");
	$aryDeliveryUrl = getDeliveryUrlList();


?>

<style type="text/css">
	#contentArea{position:relative;min-width:450px;padding:10px}
</style>
<script type="text/javascript">
<!--
	$(document).ready(function(){
	});
	
	/* 주문정보 상세보기 */
	function goOrderView(no){
		
		//$.smartPop.open({  bodyClose: false, width: 800, height: 270, url: './?menuType=order&mode=popOrderView&no='+no, closeImg: {width:23, height:23} });
		var href = "./?menuType=order&mode=popOrderView&no="+no+"&path=M";
		window.open(href, "ORDER_INFO", "width=800px,height=800px,scrollbars=yes,status=yes");
	}

	
	/* 주문 상태로 링크 */
	function goOrderStatusList(status)
	{

		location.href = "./?menuType=member&mode=popMemberCrmView&tab=memberOrderList&memberNo=<?=$intM_NO?>&searchOrderStatus="+status;
	}

//-->
</script>

<div id="contentArea">
		<div class="orderSumTable">
			<div class="orderTopLeft">
				<table>
					<input type="hidden" name="searchOrderStatus" value="">
					<tr>
						<th colspan="5"><?=$LNG_TRANS_CHAR["MW00162"] //주문정보?></th>
					</tr>
					<tr>
						<td>
							<span class="left"><?=$LNG_TRANS_CHAR["MW00162"] //전체?>:</span>
							<span class="right"><a href="javascript:goOrderStatusList('');"><strong><?=$intOrderTotal?></strong></a><?=$LNG_TRANS_CHAR["MW00167"] //건?></span>
							<div class="clr"></div>
						</td>
						<td>
							<span class="left"><?=$LNG_TRANS_CHAR["MW00163"] //주문?>:</span>
							<span class="right"><a href="javascript:goOrderStatusList('MJ');"><strong><?=($intOrderApprTotal + $intOrderWaitTotal)?></strong></a><?=$LNG_TRANS_CHAR["MW00167"] //건?></span>
							<div class="clr"></div>
						</td>
						<td>
							<span class="left"><?=$LNG_TRANS_CHAR["MW00164"] //배송?>:</span>
							<span class="right"><a href="javascript:goOrderStatusList('UI');"><strong><?=$intOrderDeliveryTotal?></strong></a><?=$LNG_TRANS_CHAR["MW00167"] //건?></span>
							<div class="clr"></div>
						</td>
						<td>
							<span class="left"><?=$LNG_TRANS_CHAR["MW00165"] //반송?>:</span>
							<span class="right"><a href="javascript:goOrderStatusList('MR');"><strong><?=$intOrderBackTotal?></strong></a><?=$LNG_TRANS_CHAR["MW00167"] //건?></span>
							<div class="clr"></div>
						</td>
						<td>
							<span class="left"><?=$LNG_TRANS_CHAR["MW00166"] //취소?>:</span>
							<span class="right"><a href="javascript:goOrderStatusList('C');"><strong><?=$intOrderCancelTotal?></strong></a><?=$LNG_TRANS_CHAR["MW00167"] //건?></span>
							<div class="clr"></div>
						</td>
					</tr>
				</table>
			</div>

			<div class="orderTopRight">
				<table>
					<tr>
						<th><?=$LNG_TRANS_CHAR["MW00038"] //결제금액?></th>
					</tr>
					<tr>
						<td class="orderPriceNum"><strong><?=getCurToPrice($memberRow[M_BUY_PRICE],$S_SITE_LNG)?></strong>원</td>
					</tr>
				</table>
			</div>
			<div class="clr"></div>
		</div>

		<div class="tableList mt10">
				<table>
					<colgroup>
						<col style="width:160px;"/>
						<col/>
						<col style="width:90px;"/>
						<col style="width:110px;"/>
					</colgroup>
					<tr>
						<th><?=$LNG_TRANS_CHAR["MW00168"] //주문일자?>/<?=$LNG_TRANS_CHAR["MW00169"] //주문번호?></th>					
						<th><?=$LNG_TRANS_CHAR["MW00170"] //주문내역?></th>
						<th><?=$LNG_TRANS_CHAR["MW00171"] //주문상태?></th>
						<th><?=$LNG_TRANS_CHAR["MW00172"] //주문금액?></th>
					</tr>
					<!-- (1) -->
					<?if($intTotal=="0"){?>
					<tr>
						<td colspan="4"><?=$LNG_TRANS_CHAR["CS00001"] //등록된 데이터가 없습니다.?></td>
					</tr>		
					<?}?>
					<?
						while($row = mysql_fetch_array($result)){
							$strOrderSettle = $btnOrderCancel = $brnOrderCalOff = $brnOrderAccClear = "";
							if ($row[O_SETTLE] == "C") $strOrderSettle = $S_ARY_SETTLE_TYPE["C"]; //신용카드
							else if ($row[O_SETTLE] == "A") $strOrderSettle = $S_ARY_SETTLE_TYPE["A"]; //계좌이체
							else if ($row[O_SETTLE] == "T") $strOrderSettle = $S_ARY_SETTLE_TYPE["T"]; //가상계좌
							else if ($row[O_SETTLE] == "B") $strOrderSettle = $S_ARY_SETTLE_TYPE["B"]; //무통장입금"
							else if ($row[O_SETTLE] == "P") $strOrderSettle = $S_ARY_SETTLE_TYPE["P"]; //포인트/쿠폰

							if ($row[O_DELIVERY_COM] && $row[O_DELIVERY_NUM]){
								$strOrderDeliveryUrl = str_replace("{dev_no}",$row[O_DELIVERY_NUM],$aryDeliveryUrl[$row[O_DELIVERY_COM]]);
							}
							
							/* 주문내역 가지고 오기*/
							$orderMgr->setO_NO($row[O_NO]);
							$orderMgr->setOC_LIST_ARY("Y");
							$aryOrderCartList = $orderMgr->getOrderCartList($db);

							## 주문상태 설정
							$strOrderStatus		= $row['O_STATUS'];
							$strOrderStatus		= $S_ARY_SETTLE_STATUS[$strOrderStatus];
					?>
					<tr>
						<td class="alignLeft">
							<ul>
							<li><?=$row[O_REG_DT]?></li>
							<li><a href="javascript:goOrderView(<?=$row[O_NO]?>);"><strong><?=$row[O_KEY]?></strong></a></li>
							</ul>
						</td>
						<td class="alignLeft">
							<?//=$row['O_J_TITLE']?>
							<?
								if (is_array($aryOrderCartList)){
									for($i=0;$i<sizeof($aryOrderCartList);$i++){
									
										$orderMgr->setOC_NO($aryOrderCartList[$i][OC_NO]);
										$aryProdCartAddOptList = $orderMgr->getOrderCartAddList($db);

										$strCartOptAttrVal = "";
										for($kk=1;$kk<=10;$kk++){
											if ($aryOrderCartList[$i]["OC_OPT_ATTR".$kk]){
												$strCartOptAttrVal .= "/".$aryOrderCartList[$i]["OC_OPT_ATTR".$kk];
											}
										}
										$strCartOptAttrVal = " ".SUBSTR($strCartOptAttrVal,1);
										
										echo "<a href=\"../".strtolower($S_SITE_LNG)."/?menuType=product&mode=view&prodCode=".$aryOrderCartList[$i][P_CODE]."\" target=\"_blank\">".$aryOrderCartList[$i][P_NAME]."</a>".$strCartOptAttrVal." ".$aryOrderCartList[$i][OC_QTY]."개<br>";
									}
								}
							?>
							
							
							<?if ($strOrderDeliveryUrl){?><a class="btn_sml" href="<?=$strOrderDeliveryUrl?>" target="_blank"><strong><?=$LNG_TRANS_CHAR["OW00044"] //배송정보?></strong></a><?}?>
						</td>
						<td>
							<?=$strOrderStatus?><br>
							<?=$strOrderSettle?>
							<?if ($row[O_USE_POINT] > 0){?>
							<br><?=$LNG_TRANS_CHAR["OW00028"] //사용포인트?> : <?=getFormatPrice($row[O_USE_CUR_POINT],2)?>
							<?}?>
							<?if ($row[O_USE_COUPON] > 0){?>
							<br><?=$LNG_TRANS_CHAR["OW00028"] //사용쿠폰?> : <?=getFormatPrice($row[O_USE_CUR_COUPON],2)?>
							<?}?>
						</td>
						<td class="txtRedPrice alignRight">
							<?=getCurMark($S_ST_CUR)?> <?=getFormatPrice($row[O_TOT_CUR_SPRICE],2)?><?=getCurMark2($S_ST_CUR)?>
						</td>
					</tr>
					<?
						}
					?>
				</table>
		</div>
		<!-- Pagenate object --> 
		<div class="paginate" style="padding:10px">  
			<?=drawPaging($intPage,$intPageLine,$intPageBlock,$intTotal,$intTotPage,$linkPage,"","")?> 
		</div>  	
		<!-- Pagenate object --> 
</div>