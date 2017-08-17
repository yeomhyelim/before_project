<?
	## 추가로 작업을 해야 하는 부분
	##		-> 주문시, 배송비가 DB에 등록되지 않음.

	## 배송비 지급 타입 설정
   $deliveryType[1]		= $LNG_TRANS_CHAR["OW00129"]; //"선불"
   $deliveryType[2]		= $LNG_TRANS_CHAR["OW00130"]; //"후불"

	## 설정
	## 배송회사 리스트
	if(!$aryDeliveryComAll):
	$aryDeliveryComAll = getCommCodeList("DELIVERY", "Y");
	endif;
	$aryDeliveryCom		= "";
	$temp				= explode(",", $S_DELIVERY_KR_COM);
	foreach($temp as $key):
		$aryDeliveryCom[$key] = $aryDeliveryComAll[$key];
	endforeach;

	## 금액 표시
	$moneyMarkL		= getCurMark($S_ST_CUR);
	$moneyMarkR		= getCurMark2($S_ST_CUR);
?>
<div id="contentArea">
	<div class="contentTop">
		<h2><?=$LNG_TRANS_CHAR["OW00001"] //주문관리?></h2>
		<div class="clr"></div>
	</div>
	<div class="tabImgWrap mt10">
		<a href="javascript:javascript:goMoveUrl('shopModify','<?=$intSH_NO?>');">기본정보</a>	
		<a href="javascript:javascript:goMoveUrl('shopSetting','<?=$intSH_NO?>');">배솔설정</a>
		<a href="javascript:javascript:goMoveUrl('shopUser','<?=$intSH_NO?>');">관리자등록</a>
		<a href="javascript:javascript:goMoveUrl('shopSite','<?=$intSH_NO?>');"  >기타설정</a>	
		<a href="javascript:javascript:goMoveUrl('shopProdList','<?=$intSH_NO?>');"  >상품정보</a>
		<a href="javascript:javascript:goMoveUrl('shopOrderList','<?=$intSH_NO?>');" class="selected">주문정보</a>	
	</div>

	<!-- 검색 -->
	<div class="searchTableWrap">
	<? include MALL_WEB_PATH."shopAdmin/order/mallList/search.skin.inc.php"; ?>
	</div>
	<!-- 주문 리스트 -->
	<div class="tableList mt10">
		<table style="border-left:1px solid #D2D0D0">
			<colgroup>
				<col width=50/>
				<col width=50/>
				<col width=200/>
				<col width=200/>
				<?if ($a_admin_type != "S"){?><col width=200/><?}?>
				<col width=100/>
				<col width=100/>
				<col width=200/>
				<col width=150/>
				<col width=50/>
				<col width=200/>
				<col width=150/>
				<?if ($a_admin_type != "S"){?><col width=100/><?}?>
			</colgroup>
			<tr>
				<th><input type="checkbox" id="chkAll" data_target="orderNo"/></th>
				<th><?=$LNG_TRANS_CHAR["CW00009"] //번호?></th>
				<th><?=$LNG_TRANS_CHAR["OW00002"] //주문번호?>(<?=$LNG_TRANS_CHAR["OW00074"] //주문일시?>)</th>
				<th><?="주문정보"; //주문정보?></th>
				<?if ($a_admin_type != "S"){?><th><?="결제정보"; //결제정보?></th><?}?>
				<th><?="주문상태"; //주문상태?></th>
				<th><?="입점사"; //입점사?></th>
				<th><?=$LNG_TRANS_CHAR["OW00022"] //상품정보?></th>
				<th><?=$LNG_TRANS_CHAR["OW00023"] //상품금액?></th>
				<th><?=$LNG_TRANS_CHAR["OW00025"] //수량?></th>
				<th><?="배송정보" //배송정보?></th>
				<th><?="구매상태" //구매상태?></th>
				<?if ($a_admin_type != "S"){?><th><?=$LNG_TRANS_CHAR["CW00007"] //관리?></th><?}?>
			</tr>
			<?while($row = mysql_fetch_array($orderListResult)): // 주문 리스트 
				$param								= "";
				$param['searchField']				= $_REQUEST['searchField'];
				$param['searchKey']					= $_REQUEST['searchKey'];
				$param['searchDeliveryStatus']		= $_REQUEST['searchDeliveryStatus'];
				$param['searchDeliveryCom']			= $_REQUEST['searchDeliveryCom'];
				$param['searchShopNo']				= $a_admin_shop_no;
				$param['o_no']						= $row['O_NO'];
				$param['order_by']					= "SO.SH_NO ASC";
				$shopOrderListTotal	= $orderMgr->getShopOrderListEx($db, "OP_COUNT", $param);
				$shopOrderListResult = $orderMgr->getShopOrderListEx($db, "OP_LIST", $param);

				if($shopOrderListTotal <= 0 ) { continue; } /* 2013.06.28 kim hee sung 입점사에서 상품 구매 정보가 없으면 표시 안함(검색에서 유용하게 사용중..) */

				/** 결제 개산 **/
				$strOrderSettle = $S_ARY_SETTLE_TYPE[$row['O_SETTLE']];		// 결제방법

				/* 주문취소 버튼은 주문상태가 주문취소,반품완료,환불완료일때는 보이지 않는다 */
				$btnOrderCancel = "";
				if ($row['O_STATUS'] != "C" && $row['O_STATUS'] != "R" && $row['O_STATUS'] != "T" && $row['O_STATUS'] != "E")
				{
					$strOrderCancelText = $LNG_TRANS_CHAR["OW00041"]; //"배송전취소";
					if ($row['O_STATUS'] == "B" || $row['O_STATUS'] == "I" || $row['O_STATUS'] == "D"){
						$strOrderCancelText = $LNG_TRANS_CHAR["OW00042"]; //"배송후취소";
					} 
					$btnOrderCancel = "<a class=\"btn_sml\" href=\"javascript:goOrderCancel(".$row['O_NO'].");\" id=\"menu_auth_e1\" style=\"display:none\"><strong>".$strOrderCancelText."</strong></a>";
				}

				$btnOrderCancelOff = "";
				if ($row['O_STATUS'] == "C")
				{
					$btnOrderCancelOff = "<a class=\"btn_sml\" href=\"javascript:goOrderCancelOff(".$row['O_NO'].",'".$row['O_PG']."');\"  id=\"menu_auth_e1\" style=\"display:none\"><strong>".$LNG_TRANS_CHAR["OW00076"]."</strong></a>"; //취소완료
					if ($row['O_CEL_STATUS'] == "N"){
						$btnOrderCancelOff = "<a class=\"btn_sml\" href=\"javascript:goOrderCancelOff(".$row['O_NO'].",'".$row['O_PG']."');\"  id=\"menu_auth_e1\" style=\"display:none\"><strong>".$LNG_TRANS_CHAR["OW00077"]."</strong></a>"; //취소처리중
					} else if ($row['O_CEL_STATUS'] == "P"){
						$btnOrderCancelOff = "<a class=\"btn_sml\" href=\"javascript:goOrderCancel(".$row['O_NO'].");\"  id=\"menu_auth_e1\" style=\"display:none\"><strong>".$LNG_TRANS_CHAR["OW00078"]."</strong></a>"; //구매취소요청
					}
				}
			?>
			<tr id="order_<?=$row['O_NO']?>">
				<td alt="선택"><input type="checkbox" id="orderNo"/></td>
				<td alt="번호"><?=$intListNum--?></td>
				<td alt="주문번호(주문일시)">
					<?=$row['O_KEY']; // 주문번호?><br>(<?=date("Y-m-d", strtotime($row['O_REG_DT'])); // 주문일?>)
					<a class="btn_sml" href="javascript:goOrderView('<?=$row[O_NO]?>','<?=$a_admin_shop_no?>');"><span><?=$LNG_TRANS_CHAR["OW00012"] //상세보기?></span></a>
				</td>
				<td alt="주문정보" style="text-align:left;">
					주문자 : <?=$row['O_J_NAME'] // 주문자명?><br>
					아이디 : <?=$row['M_ID'] // 아이디?><br>
					메일 : <?=$row['M_MAIL'] // 메일?><br>
					연락처1 : <?=$row['M_PHONE'] // 연락처1?><br>
					연락처2	: <?=$row['M_HP'] // 연락처2?><br>
				</td>
				<?if ($a_admin_type != "S"){?>
				<td alt="결제정보" style="text-align:left;">
					결제방법 : <?=$strOrderSettle // 결제방법?><br>
					<?
						$settle = $row['O_SETTLE'];
						if ($settle == "B"):
							//입금계좌, 입금자명
							echo "{$LNG_TRANS_CHAR['OW00085']} : {$row[O_BANK_ACC]} {$LNG_TRANS_CHAR['OW00086']} : {$row['O_BANK_NAME']}";
						elseif ($settle == "T"):
							// 입금계좌, 입금마감시간
							$bankValidDT = date("Y-m-d", strtotime($row['O_BANK_VALID_DT']));
							echo "{$LNG_TRANS_CHAR['OW00085']} : {$strReturnBankName} {$row[O_BANK_ACC]} {$LNG_TRANS_CHAR['OW00087']} : {$bankValidDT}";
						endif;
					
						if ($row['O_CASH_YN'] == "Y"){
							echo " 현금영수증:".$row['O_CASH_INFO'];
							if ($row['O_CASH_AUTH_NO']) echo "(".$row['O_CASH_AUTH_NO'].")";
						}
					?>
				</td>
				<?}?>
				<td alt="결제상태">
					<?=$S_ARY_SETTLE_STATUS[$row['O_STATUS']]?>
				</td>				
				<?if($shopOrderListTotal <= 0):?>
				<td colspan="6">
					등록된 주문 정보가 없습니다.(입점몰 이전의 주문)
				</td>
				<?else:?>
				<td colspan="6" style="padding:0;vertical-align:top;height:120px;">
					<table style="height:100%">
						<colgroup>
							<col width=100/>
							<col width=200/>
							<col width=150/>
							<col width=50/>
							<col width=200/>
							<col width=150/>
							<col width=100/>
						</colgroup>
						<?while($sRow = mysql_fetch_array($shopOrderListResult)):
						   if($sRow['SH_NO'] == 0) { $sRow['ST_NAME'] = "본사"; }
						   $param								= "";
						   $param['o_no']						= $row['O_NO'];
						   $param['p_shop_no']					= $sRow['SH_NO'];
						   $param['order_by']					= "OC.OC_NO ASC";
						   if (in_array($strSearchOrderStatus,array("E","C","R","T"))){
								$param["in_soc_status"] = "'".$strSearchOrderStatus."'";
								if ($strSearchOrderStatus == "R"){
									$param["in_soc_status"] = "'R','S'";
								}
							}
						   $orderCartListTotal					= $orderMgr->getOrderCartListEx($db, "OP_COUNT", $param);
						   $orderCartListResult					= $orderMgr->getOrderCartListEx($db, "OP_LIST", $param);
						  
						   if($orderCartListTotal > 0):
							  $ocRow							= mysql_fetch_array($orderCartListResult);
							  if(!$ocRow['OC_DELIVERY_TYPE']) { $ocRow['OC_DELIVERY_TYPE'] = 1; }
							  $totalPrice						= ($ocRow['OC_CUR_PRICE'] * $ocRow['OC_QTY']);
							  $deliveryCom						= $aryDeliveryCom;
							  if($sRow['SH_COM_DELIVERY_COR']):								
								  $temp								= explode(",", $sRow['SH_COM_DELIVERY_COR']);
								  $deliveryCom						= "";
								  foreach($temp as $key):
									$deliveryCom[$key]				= $aryDeliveryComAll[$key];
								  endforeach;
							  endif;

								$param = "";
								$param["oc_no"] = $ocRow['OC_NO'];
								$aryProdCartAddOptList = $orderMgr->getOrderCartAddList($db,$param);

								$strCartOptAttrVal = "";
								for($kk=1;$kk<=10;$kk++){
									if ($ocRow["OC_OPT_ATTR".$kk]){
										$strCartOptAttrVal .= "/".$ocRow["OC_OPT_ATTR".$kk];
									}
								}
								$strCartOptAttrVal = SUBSTR($strCartOptAttrVal,1);
						?>
						<tr id="shop_order_<?=$sRow['SO_NO']?>">
							<td rowspan="<?=$orderCartListTotal?>" alt="입점사"><?=$sRow['ST_NAME']?></td>
							<td alt="상품정보" style="text-align:left;">
								<img src="<?=$ocRow['PM_REAL_NAME']?>" style="width:50px;height:50px"><br>
								<?=$ocRow['P_NAME']?> <?=$strCartOptAttrVal?>
								<?if (is_array($aryProdCartAddOptList)){
									for($k=0;$k<sizeof($aryProdCartAddOptList);$k++){
									
									?>
									<li><?=$LNG_TRANS_CHAR["OW00046"] //추가선택?> : <?=$aryProdCartAddOptList[$k][OCA_OPT_NM]?></li>
								<?}}?>
							</td>
							<td alt="상품금액">
								<?=$moneyMarkL?> <?=getFormatPrice($ocRow['OC_CUR_PRICE'], 2)?> <?=$moneyMarkR?>
								<?if ($ocRow[OC_OPT_ADD_PRICE]){?><?=$LNG_TRANS_CHAR["OW00024"] //추가금액?>:<?=$moneyMarkL?>  <?=getFormatPrice($ocRow[OC_OPT_ADD_CUR_PRICE],2)?><?=$moneyMarkR?><?}?>	
							</td>
							<td alt="수량"><?=$ocRow['OC_QTY']?></td>
							<td rowspan="<?=$orderCartListTotal?>" alt="배송상태" style="text-align:left;">
							  배송요금:<?=$moneyMarkL?> <?=getFormatPrice($sRow['SO_TOT_DELIVERY_CUR_PRICE'],2)?><?=$moneyMarkR?><br>
							  배송상태:<?=$S_ARY_DELIVERY_STATUS[$sRow['SO_DELIVERY_STATUS']]?><br>
							  배송회사:<?=$deliveryCom[$sRow['SO_DELIVERY_COM']]?><br>
							  배송번호:<?=$sRow['SO_DELIVERY_NUM']?>
							</td>
							
							<td alt="구매상태">
								<?if($ocRow['SOC_STATUS']=="E"){echo "구매완료";}?>
								<?=$S_ARY_SETTLE_ORDER_STATUS[$ocRow['SOC_STATUS'].$ocRow['SOC_'.$ocRow['SOC_STATUS'].'_STATUS']]?>
							</td>
						</tr> 
						<?  endif;
						    if($orderCartListTotal > 1):
							  while($ocRow = mysql_fetch_array($orderCartListResult)):
							    $totalPrice		= $totalPrice + ($ocRow['OC_CUR_PRICE']*$ocRow['OC_QTY']);  
								
								$param = "";
								$param["oc_no"] = $ocRow['OC_NO'];
								$aryProdCartAddOptList = $orderMgr->getOrderCartAddList($db,$param);

								$strCartOptAttrVal = "";
								for($kk=1;$kk<=10;$kk++){
									if ($ocRow["OC_OPT_ATTR".$kk]){
										$strCartOptAttrVal .= "/".$ocRow["OC_OPT_ATTR".$kk];
									}
								}
								$strCartOptAttrVal = SUBSTR($strCartOptAttrVal,1);
								?>
						<tr>
							<td alt="상품정보" style="text-align:left;">
								<img src="<?=$ocRow['PM_REAL_NAME']?>" style="width:50px;height:50px"><br>
								<?=$ocRow['P_NAME']?> <?=$strCartOptAttrVal?>
								<?if (is_array($aryProdCartAddOptList)){
									for($k=0;$k<sizeof($aryProdCartAddOptList);$k++){
									
									?>
									<li><?=$LNG_TRANS_CHAR["OW00046"] //추가선택?> : <?=$aryProdCartAddOptList[$k][OCA_OPT_NM]?></li>
								<?}}?>
							</td>
							<td alt="상품금액">
								<?=$moneyMarkL?> <?=getFormatPrice($ocRow['OC_CUR_PRICE'], 2)?> <?=$moneyMarkR?>
								<?if ($ocRow[OC_OPT_ADD_PRICE]){?><?=$LNG_TRANS_CHAR["OW00024"] //추가금액?>:<?=$moneyMarkL?>  <?=getFormatPrice($ocRow[OC_OPT_ADD_CUR_PRICE],2)?><?=$moneyMarkR?><?}?>	
							</td>
							<td alt="수량"><?=$ocRow['OC_QTY']?></td>
							<td alt="구매상태">
								<?if($ocRow['SOC_STATUS']=="E"){echo "구매완료";}?>
								<?=$S_ARY_SETTLE_ORDER_STATUS[$ocRow['SOC_STATUS'].$ocRow['SOC_'.$ocRow['SOC_STATUS'].'_STATUS']]?>
							</td>
						</tr>
						<?    endwhile;
							endif;
						  endwhile;
						  
						  if ($a_admin_type != "S"){
						  ?>
						 <tr>
							<td colspan="6"  style="text-align:left;">
								<strong><?=$strOrderSettle // 결제 방법?></strong> 
								<strong class="txtRedPrice"><?=$moneyMarkL?> <?=getFormatPrice($row['O_TOT_CUR_SPRICE'],2)?> <?=$moneyMarkR?></strong>
								<?
									// 총 상품 금액
									$price = $row['O_TOT_CUR_PRICE'];
									$text = "";
									if ($price > 0):
										$price = getFormatPrice($price, 2);
										if($text) { $text .= " + "; }
										$text .= "{$LNG_TRANS_CHAR['OW00083']} : {$moneyMarkL} {$price} {$moneyMarkR}";
									endif;

									// 부과세
									$price = $row['O_TAX_CUR_PRICE'];
									if ($price > 0):
										$price = getFormatPrice($price, 2);
										if($text) { $text .= " + "; }
										$text .= "{$LNG_TRANS_CHAR['OW00084']} : {$moneyMarkL} {$price} {$moneyMarkR}";
									endif;

									// 배송비
									$price = $row['O_TOT_DELIVERY_CUR_PRICE'];
									if ($price > 0):
										$price = getFormatPrice($price, 2);
										if($text) { $text .= " + "; }
										$text .= "{$LNG_TRANS_CHAR['OW00027']} : {$moneyMarkL} {$price} {$moneyMarkR}";
									endif;

									// 추가할인금액
									$price = $row['O_TOT_MEM_DISCOUNT_PRICE'];
									if ($price > 0):
										$price = getFormatPrice($price, 2);
										if($text) { $text .= " - "; }
										$text .= "{$LNG_TRANS_CHAR['OW00115']} : {$moneyMarkL} {$price} {$moneyMarkR}";
									endif;

									// 사용포인트
									$price = $row['O_USE_CUR_POINT'];
									if ($price > 0):
										$price = getFormatPrice($price, 2);
										if($text) { $text .= " - "; }
										$text .= "{$LNG_TRANS_CHAR['OW00028']} : {$moneyMarkL} {$price} {$moneyMarkR}";
									endif;

									// 사용쿠폰
									$price = $row['O_USE_CUR_COUPON'];
									if ($price > 0):
										$price = getFormatPrice($price, 2);
										if($text) { $text .= " - "; }
										$text .= "{$LNG_TRANS_CHAR['OW00028']} : {$moneyMarkL} {$price} {$moneyMarkR}";
									endif;

									echo "( {$text} )";
								?>
								<!-- 총 구매 금액 : <?=getCurMark($S_ST_CUR)?> <?=getFormatPrice($totalPrice, 2)?> <?=getCurMark2($S_ST_CUR)?> -->								
								<div>
								<?=$LNG_TRANS_CHAR["OW00088"] //수령인?> [<?=$row[O_B_NAME]?>] [<?=$row[O_B_ZIP]?>] <?=$row[O_B_ADDR1]?> <?=$row[O_B_ADDR2]?> <?=$row[O_B_CITY]?> <?=$strDeliveyState?> <?=$aryCountryList[$row[O_B_COUNTRY]]?>
								<?
								if ($row["O_USE_LNG"] != "KR" && ($row['O_STATUS'] == "A" || $row['O_STATUS'] == "B" || $row['O_STATUS'] == "I" || $row['O_STATUS'] == "D" || $row['O_STATUS'] == "E")){
									if ($row[O_DELIVERY_COM] && $row[O_DELIVERY_NUM]){
										$strOrderDeliveryUrl = str_replace("{dev_no}",$row[O_DELIVERY_NUM],$aryDeliveryUrl[$row[O_DELIVERY_COM]]);
										echo " / ".$aryDeliveryComAll[$row[O_DELIVERY_COM]]."<a href=\"".$strOrderDeliveryUrl."\" target=\"_blank\">(".$row[O_DELIVERY_NUM].")</a>";
									}
								}
								?>
								</div>
							</td>
						 </tr>
						 <?}?>
					</table>	
				</td>
				<?endif;?>
				<?if ($a_admin_type != "S"){?>
				<td>
					<?=$btnOrderCancel?>
					<?=$btnOrderCancelOff?>
					<?if ($row['O_USE_LNG'] == "KR"){?>
					<?if (!in_array($row["O_STATUS"],array("E","C"))){?> 
						<a class="btn_sml" href="javascript:goOrderPartCancelEvent('<?=$row['O_NO']?>');"><strong>부분취소</strong></a>
					<?}?>
					<a class="btn_sml" href="javascript:goOrderHistory('<?=$row['O_NO']?>');"><strong>내역관리</strong></a>
					<?}?>
					<?if ($row["O_USE_LNG"] != "KR" && ($row['O_STATUS'] == "A" || $row['O_STATUS'] == "B" || $row['O_STATUS'] == "I" || $row['O_STATUS'] == "D")){?>
						<a class="btn_sml" href="javascript:goOrderDeliveryUpdate('<?=$row[O_NO]?>');" id="menu_auth_e2" style="display:none"><strong>해외배송정보</strong></a>
					<?}?>
					<a class="btn_sml" href="javascript:goOrderDelete('<?=$row['O_NO']?>');"><strong>삭제</strong></a>
				</td>
				<?}?>
			</tr>
			<?endwhile;?>
		</table>
	</div>
	<!-- 주문 리스트 -->
	
	<!-- Pagenate object --> 
	<div class="paginate">  
		<?=drawPaging($intPage,$intPageLine,$intPageBlock,$intTotal,$intTotPage,$linkPage,"","")?> 
	</div>  
	<!-- Pagenate object --> 
</div>