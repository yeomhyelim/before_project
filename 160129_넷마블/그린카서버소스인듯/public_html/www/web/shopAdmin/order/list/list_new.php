<?
	## 추가로 작업을 해야 하는 부분
	##		-> 주문시, 배송비가 DB에 등록되지 않음.

	## 배송비 지급 타입 설정
   $deliveryType[1]		= "선불";
   $deliveryType[2]		= "후불";

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
	<!-- 검색 -->
	<div class="searchTableWrap">
	<? include "search.skin.inc.php"; ?>
	</div>
	
	<!-- 검색 -->
	<a class="btn_sml" href="javascript:goSettleSaveAllActEvent();"><strong>결제상태 수정</strong></a>
	<a class="btn_sml" href="javascript:goDeliverySaveAllActEvent();"><strong>배송정보 수정</strong></a>
	<a class="btn_sml" href="javascript:goOrderStatusSaveAllActEvent();"><strong>구매상태 수정</strong></a>
	<!-- 주문 리스트 -->
	<div class="tableList">
		<table style="border-left:1px solid #D2D0D0">
			<colgroup>
				<col width=50/>
				<col width=50/>
				<col width=200/>
				<col width=200/>
				<col width=200/>
				<col width=100/>
				<col width=100/>
				<col width=200/>
				<col width=150/>
				<col width=50/>
				<col width=200/>
				<col width=150/>
				<col width=100/>
			</colgroup>
			<tr>
				<th><input type="checkbox" id="chkAll" data_target="orderNo"/></th>
				<th><?=$LNG_TRANS_CHAR["CW00009"] //번호?></th>
				<th><?=$LNG_TRANS_CHAR["OW00002"] //주문번호?>(<?=$LNG_TRANS_CHAR["OW00074"] //주문일시?>)</th>
				<th><?="주문정보"; //주문정보?></th>
				<th><?="결제정보"; //결제정보?></th>
				<th><?="결제상태"; //결제상태?></th>
				<th><?="입점사"; //입점사?></th>
				<th><?=$LNG_TRANS_CHAR["OW00022"] //상품정보?></th>
				<th><?=$LNG_TRANS_CHAR["OW00023"] //상품금액?></th>
				<th><?=$LNG_TRANS_CHAR["OW00025"] //수량?></th>
				<th><?="배송정보" //배송정보?></th>
				<th><?="구매상태" //구매상태?></th>
				<th><?=$LNG_TRANS_CHAR["CW00007"] //관리?></th>
			</tr>
			<?while($row = mysql_fetch_array($orderListResult)): // 주문 리스트 
				$param								= "";
				$param['searchField']				= $_REQUEST['searchField'];
				$param['searchKey']					= $_REQUEST['searchKey'];
				$param['searchDeliveryStatus']		= $_REQUEST['searchDeliveryStatus'];
				$param['searchDeliveryCom']			= $_REQUEST['searchDeliveryCom'];
				$param['o_no']						= $row['O_NO'];
				$param['order_by']					= "SO.SH_NO ASC";
				$shopOrderListTotal	= $orderMgr2->getShopOrderListEx($db, "OP_COUNT", $param);
				$shopOrderListResult = $orderMgr2->getShopOrderListEx($db, "OP_LIST", $param);

				/** 결제 개산 **/
				$strOrderSettle = $S_ARY_SETTLE_TYPE[$row['O_SETTLE']];		// 결제방법


			?>
			<tr id="order_<?=$row['O_NO']?>">
				<td alt="선택"><input type="checkbox" id="orderNo"/></td>
				<td alt="번호"><?=$intListNum--?></td>
				<td alt="주문번호(주문일시)"><?=$row['O_KEY']; // 주문번호?>(<?=date("Y-m-d", strtotime($row['O_REG_DT'])); // 주문일?>)</td>
				<td alt="주문정보" style="text-align:left;">
					주문자 : <?=$row['O_J_NAME'] // 주문자명?>
					아이디 : <?=$row['M_ID'] // 아이디?>
					메일 : <?=$row['M_MAIL'] // 메일?>
					연락처1 : <?=$row['M_PHONE'] // 연락처1?>
					연락처2	: <?=$row['M_HP'] // 연락처2?>
				</td>
				<td alt="결제정보" style="text-align:left;">
					결제방법 : <?=$strOrderSettle // 결제방법?>
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
					?>
				</td>
				<td alt="결제상태">
					<select id="settleStatus">
						<option value="">선택</option>
						<?foreach($S_ARY_SETTLE_PIECE_STATUS as $key => $value):?>
						<option value="<?=$key?>"<?if($row['O_STATUS']==$key){echo " selected";}?>><?=$value?></option>
						<?endforeach;?>
					</select>
					<a class="btn_sml" href="javascript:goSettleSaveActEvent('<?=$row['O_NO']?>')"><strong>수정</strong></a>
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
						   $orderCartListTotal					= $orderMgr2->getOrderCartListEx($db, "OP_COUNT", $param);
						   $orderCartListResult					= $orderMgr2->getOrderCartListEx($db, "OP_LIST", $param);
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
						?>
						<tr id="shop_order_<?=$sRow['SO_NO']?>">
							<td rowspan="<?=$orderCartListTotal?>" alt="입점사"><?=$sRow['ST_NAME']?></td>
							<td alt="상품정보" style="text-align:left;">
								<img src="<?=$ocRow['PM_REAL_NAME']?>" style="width:50px;height:50px">
								상품코드 : <?=$ocRow['P_CODE']?>
							</td>
							<td alt="상품금액"><?=$moneyMarkL?> <?=getFormatPrice($ocRow['OC_CUR_PRICE'], 2)?> <?=$moneyMarkR?></td>
							<td alt="수량"><?=$ocRow['OC_QTY']?></td>
							<td rowspan="<?=$orderCartListTotal?>" alt="배송상태" style="text-align:left;">
							  배송요금:<?=$moneyMarkL?> <?=getFormatPrice($ocRow['OC_DELIVERY_CUR_PRICE'],2)?><?=$moneyMarkR?>(<?=$deliveryType[$ocRow['OC_DELIVERY_TYPE']] // 배송비 지급 방식?>)
							  배송상태:
								<select id="deliveryStatus">
								  <option value="">선택</option>
								  <?foreach($S_ARY_DELIVERY_STATUS as $key => $value):?>
								  <option value="<?=$key?>"<?if($sRow['SO_DELIVERY_STATUS'] == $key){echo " selected";}?>><?=$value?></option>
								  <?endforeach;?>
								<select>
							  배송회사:
								<select id="deliveryCom">
								  <option value="">선택</option>
								  <?foreach($deliveryCom as $key => $value):?>
								  <option value="<?=$key?>"<?if($sRow['SO_DELIVERY_COM'] == $key){echo " selected";}?>><?=$value?></option>
								  <?endforeach;?>
								</select>
							  배송번호:<input type="text" id="deliveryNum" value="<?=$sRow['SO_DELIVERY_NUM']?>">
							  <a class="btn_sml" href="javascript:goDeliverySaveActEvent('<?=$sRow['SO_NO']?>')"><strong>수정</strong></a>
							</td>
							<td alt="구매상태">
								<?if (!$ocRow['SOC_STATUS']){?>
								<a class="btn_sml" href="javascript:goOrderCeritySaveActEvent(<?=$ocRow['OC_NO']?>);"><strong>구매확정</strong></a>
								<a class="btn_sml" href="javascript:goOrderReturnEvent(<?=$ocRow['OC_NO']?>);"><strong>반품/교환/취소</strong></a>

								<select id="orderStatus">
									<option value="">선택</option>
									<?foreach($S_ARY_SETTLE_ORDER_STATUS as $key => $value):?>
									<option value="<?=$key?>"<?if($sRow['SO_ORDER_STATUS']==$key){echo " selected";}?>><?=$value?></option>
									<?endforeach;?>
								</select>
								<a class="btn_sml" href="javascript:goOrderStatusSaveActEvent('<?=$sRow['SO_NO']?>')"><strong>수정</strong></a>
								<?}else{?>
									<?if ($ocRow['SOC_STATUS'] == "E"){?>
										구매확정
									<?}?>
								<?}?>
							</td>
						</tr> 
						<?  endif;
						    if($orderCartListTotal > 1):
							  while($ocRow = mysql_fetch_array($orderCartListResult)):
							    $totalPrice		= $totalPrice + ($ocRow['OC_CUR_PRICE']*$ocRow['OC_QTY']);  ?>
						<tr>
							<td alt="상품정보" style="text-align:left;">
								<img src="<?=$ocRow['PM_REAL_NAME']?>" style="width:50px;height:50px">
								상품코드 : <?=$ocRow['P_CODE']?>
							</td>
							<td alt="상품금액"><?=$moneyMarkL?> <?=getFormatPrice($ocRow['OC_CUR_PRICE'], 2)?> <?=$moneyMarkR?></td>
							<td alt="수량"><?=$ocRow['OC_QTY']?></td>
							<td alt="구매상태">
								<select id="orderStatus">
									<option value="">선택</option>
									<?foreach($S_ARY_SETTLE_ORDER_STATUS as $key => $value):?>
									<option value="<?=$key?>"<?if($sRow['SO_ORDER_STATUS']==$key){echo " selected";}?>><?=$value?></option>
									<?endforeach;?>
								</select>
								<a class="btn_sml" href="javascript:goOrderStatusSaveActEvent('<?=$sRow['SO_NO']?>')"><strong>수정</strong></a>
							</td>
						</tr>
						<?    endwhile;
							endif;
						  endwhile;?>
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
									$price = $row['O_TAX_CUR_PRICE'];
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
							</td>
						 </tr>
					</table>	
				</td>
				<?endif;?>
				<td><a class="btn_sml" href="javascript:goOrderDelete('<?=$row['O_NO']?>');"><strong>삭제</strong></a></td>
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