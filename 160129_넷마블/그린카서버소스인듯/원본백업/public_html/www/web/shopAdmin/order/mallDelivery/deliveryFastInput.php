<?
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

	## 배송 조회 URL 리스트
	$aryDeliveryUrl = getDeliveryUrlList();

	## 금액 표시
	$moneyMarkL		= getCurMark($S_ST_CUR);
	$moneyMarkR		= getCurMark2($S_ST_CUR);

	## 로그인 타입(관리자 or 입점사)
	$adminType		= $_SESSION['ADMIN_TYPE'];

?>
<div id="contentArea">
	<div class="contentTop">
		<h2><?=$strMenuTitle?><?//=$LNG_TRANS_CHAR["OW00091"] //빠른송장입력?></h2>
		<div class="clr"></div>
	</div>
	<!-- 검색 -->
	<div class="searchTableWrap">
	<? include "search.skin.inc.php"; ?>
	</div>
	<!-- 검색 -->
	<div class="tableList">
		<div class="tableListTopWrap">
			<?if(in_array($strMode, array("deliveryList"))):?>
			<a class="btn_sml" href="javascript:goDeliverySaveAllActEvent();"><strong>배송정보 수정</strong></a>
			<?endif;?>
			<?if(in_array($strMode, array("deliveryList")) && !$_REQUEST['searchOrderStatus']):?>
			<a class="btn_sml" href="javascript:goDeliveryExcelDownloadActEvent();"><strong>송장입력엑셀파일</strong></a>
			<a class="btn_sml" href="javascript:goDeliveryAllExcelDownloadActEvent();"><strong>엑셀다운로드</strong></a>
			<?endif;?>
			<?if(in_array($strMode, array("deliveryList")) && !$_REQUEST['searchOrderStatus']):?>
			<a class="btn_sml" href="javascript:goDeliveryExcelSaveActEvent();"><strong>엑셀파일 일괄수정</strong></a>
			<?endif;?>
			<?if(in_array($strMode, array("deliveryList")) && $_REQUEST['searchOrderStatus'] == "D"):?>
			<a class="btn_sml" href="javascript:goOrderStatusSaveCheckActEvent();"><strong>선택항목 구매완료</strong></a>
			<?endif;?>
			<input type="file" id="fileTest" style="display:none">
			<?if(in_array($strMode, array("deliveryList")) && $_REQUEST['searchOrderStatus'] == "I"):?>
			<a class="btn_sml" href="javascript:goDeliveryIngExcelDownloadActEvent();"><strong>엑셀다운로드</strong></a>
			<?endif;?>	
			
			<div class="selectedSort">
				<span class="spanTitle mt5"><?=$LNG_TRANS_CHAR["MW00063"] //목록수?>:</span>
				<select name="pageLine" style="vertical-align:middle;" onchange="javascript:goSearch();">
					<option value="10" <? if($intPageLine==10) echo 'selected';?>>10</option>
					<option value="20" <? if($intPageLine==20) echo 'selected';?>>20</option>
					<option value="30" <? if($intPageLine==30) echo 'selected';?>>30</option>
					<option value="40" <? if($intPageLine==40) echo 'selected';?>>40</option>
					<option value="50" <? if($intPageLine==50) echo 'selected';?>>50</option>
					<option value="60" <? if($intPageLine==60) echo 'selected';?>>60</option>
					<option value="70" <? if($intPageLine==70) echo 'selected';?>>70</option>
					<option value="80" <? if($intPageLine==80) echo 'selected';?>>80</option>
					<option value="90" <? if($intPageLine==90) echo 'selected';?>>90</option>
					<option value="100" <? if($intPageLine==100) echo 'selected';?>>100</option>
					<option value="200" <? if($intPageLine==200) echo 'selected';?>>200</option>
				</select>
			</div>
		<div class="clr"></div>
	</div>
	<!-- 주문 리스트 -->
	<div class="tableList">
		<table style="border-left:1px solid #D2D0D0">
			<colgroup>
				<col width=50/>
				<col width=50/>
				<col width=200/>
				<?if($strOrderInfoDisplayYN == "Y"): // master 로그인 ?>
				<col width=100/><? ## 입점사 2013.06.26 kim hee sung 입점사로 로그인 한경우, 숨김처리. ?>
				<?endif;?>
				<col width=200/>
				<col width=200/>
				<col width=100/>
				<col width=100/>
				<col width=200/>
				<!--col width=150/--><? ## 결제완료 2013.06.26 kim hee sung 디자인 변경으로 숨김처리. ?>
				<col width=200/>
				<?if(in_array($_REQUEST['searchOrderStatus'], array("D"))): // 배송완료목록에서만 보임?>
				<col width=200/>
				<?endif;?>
			</colgroup>
			<tr>
				<th><input type="checkbox" id="chkAll" data_target="deliveryNo"/></th>
				<th><?=$LNG_TRANS_CHAR["CW00009"] //번호?></th>
				<th><?=$LNG_TRANS_CHAR["OW00002"] //주문번호?>(<?=$LNG_TRANS_CHAR["OW00074"] //주문일시?>/<?="결제일시" //결제일시?>)</th>
				<?if($strOrderInfoDisplayYN == "Y"): // master 로그인 ?>
				<th><?="입점사"; //입점사?></th>
				<?endif;?>
				<th><?="상품정보"; //상품정보?></th>
				<th><?="주문금액"; //주문금액?></th>
				<th><?="배송비"; //배송비?></th>
				<th><?="배송회사"; //배송회사?></th>
				<th><?="송장번호"; //송장번호?></th>
				<!--th><?="결제상태"; //결제상태?></th-->
				<th><?="배송상태"; //배송상태?></th>
				<?if(in_array($_REQUEST['searchOrderStatus'], array("D"))):?>
				<th><?="구매상태"; //구매상태?></th>
				<?endif;?>
			</tr>
			<?while($row = mysql_fetch_array($deliveryResult)): // 배송 리스트

				  if($row['SH_NO'] == 0) { $row['ST_NAME'] = "본사"; }

				  // 배송회사 설정
				  $deliveryCom						= $aryDeliveryCom;
				  if($row['SH_COM_DELIVERY_COR']):								
					  $temp								= explode(",", $row['SH_COM_DELIVERY_COR']);
					  $deliveryCom						= "";
					  foreach($temp as $key):
						$deliveryCom[$key]				= $aryDeliveryComAll[$key];
					  endforeach;
				  endif;

				  // 주문금액
				  $orderPrice	= $row['SO_TOT_CUR_SPRICE'];
				  $orderPrice	= getFormatPrice($orderPrice, 2);
				  $orderPrice	= "{$moneyMarkL} {$orderPrice} {$moneyMarkR}";

				  // 배송금액
				  $deliveryprice	= $row['SO_TOT_DELIVERY_CUR_PRICE'];
				  $deliveryprice	= getFormatPrice($deliveryprice, 2);
				  $deliveryprice	= "{$moneyMarkL} {$deliveryprice} {$moneyMarkR}";	
				  
				  // 결제상태, 배송상태, 구매상태
				  $settleStatus			= $S_ARY_SETTLE_STATUS[$row['O_STATUS']];
				  $deliveryStatus		= $S_ARY_DELIVERY_STATUS[$row['SO_DELIVERY_STATUS']];
				  $orderStatus			= $S_ARY_SETTLE_ORDER_STATUS[$row['SO_ORDER_STATUS']];

				  if(!$settleStatus)	{ $settleStatus = "-"; }
				  if(!$deliveryStatus)	{ $deliveryStatus = "-"; }
				  if(!$orderStatus)		{ $orderStatus = "-"; }

				  // 배송 조회
				  $deliveryComUrl		= "";
				  if($row['SO_DELIVERY_COM'] && $row['SO_DELIVERY_NUM']):
				  $deliveryComUrl		= $aryDeliveryUrl[$row['SO_DELIVERY_COM']];
				  $deliveryComUrl		= str_replace("{dev_no}", $row['SO_DELIVERY_NUM'], $deliveryComUrl);
				  endif;

				  // 상품정보
				  $param				= "";
				  $param['o_no']		= $row['O_NO'];
				  $param['p_shop_no']	= $row['SH_NO'];
				  $param['product_all']	= "N"; 
				  $aryOrderShopCartList	= $shopOrderMgr->getOrderCartListEx($db,"OP_ARYTOTAL",$param);

			?>
 			<tr id="shop_order_<?=$row['SO_NO']?>">
				<td alt="선택" rowspan="2"><input type="checkbox" id="deliveryNo" value="<?=$row['SO_NO']?>"/></td>
				<td alt="번호" rowspan="2"><?=$intListNum--?></td>
				<td alt="주문일시, 주문일시"><?=$row['O_KEY']?><br>(<?=$row['O_REG_DT']?>)<?if($row['O_APPR_DT']){echo"<br>(".$row['O_APPR_DT'].")";}?></td>
				<?if($strOrderInfoDisplayYN == "Y"): // master 로그인 ?>
				<td alt="입점사"><?=$row['ST_NAME']?></td>
				<?endif;?>
				<td>
					<?
					if (is_array($aryOrderShopCartList)){
						for($kk=0;$kk<sizeof($aryOrderShopCartList);$kk++){

							$param = "";
							$param["oc_no"] = $aryOrderShopCartList[$kk]['OC_NO'];
							$aryProdCartAddOptList = $shopOrderMgr->getOrderCartAddList($db,$param);

							$strCartOptAttrVal = "";
							for($k=1;$k<=10;$k++){
								if ($aryOrderShopCartList[$kk]["OC_OPT_ATTR".$k]){
									$strCartOptAttrVal .= "/".$aryOrderShopCartList[$kk]["OC_OPT_ATTR".$k];
								}
							}
							$strCartOptAttrVal = SUBSTR($strCartOptAttrVal,1);
							
							$strDeliveryTypeName = "";
							if ($aryOrderShopCartList[$kk]['P_BAESONG_TYPE'] == "2") $strDeliveryTypeName = "무료배송";
							else if ($aryOrderShopCartList[$kk]['P_BAESONG_TYPE'] == "3") $strDeliveryTypeName = "배송비고정";
							else if ($aryOrderShopCartList[$kk]['P_BAESONG_TYPE'] == "4") $strDeliveryTypeName = "수량별배송";
							else if ($aryOrderShopCartList[$kk]['P_BAESONG_TYPE'] == "5") $strDeliveryTypeName = "착불";
							?>
							<ul class="prodInfoBox">
								<li class="imgWrap"><img src="<?=$aryOrderShopCartList[$kk]['PM_REAL_NAME']?>" style="width:50px;height:50px"></li>
								<li class="prodInfo">
									<?=$aryOrderShopCartList[$kk]['P_NAME']?> <?=$strCartOptAttrVal?>
									<?if (is_array($aryProdCartAddOptList)){
										for($k=0;$k<sizeof($aryProdCartAddOptList);$k++){
										
										?>
										<?=$LNG_TRANS_CHAR["OW00046"] //추가선택?> : <?=$aryProdCartAddOptList[$k][OCA_OPT_NM]?>
									<?}}?>

									/<?=$strDeliveryTypeName?>

								</li>
							</ul>
							<?
						}
					}
					?>
				</td>
				<td alt="주문금액"><?=$orderPrice?></td>
				<td alt="배송비"><?=$deliveryprice?></td>
				<td alt="배송회사">
					<?if(in_array($strMode, array("deliveryList"))):?>
					<select id="deliveryCom" style="width:100px">
						<option value="">선택</option>
						<?foreach($deliveryCom as $key => $value):?>
						<option value="<?=$key?>"<?if($key==$row['SO_DELIVERY_COM']){echo " selected";}?>><?=$value?></option>
						<?endforeach;?>
					</select>
					<?else:?>
					-
					<?endif;?>
				</td>
				<td alt="송장번호">
					<?if(in_array($strMode, array("deliveryList"))):?>
					   <input type="text" id="deliveryNum" value="<?=$row['SO_DELIVERY_NUM']?>"/>
					   <?if(in_array($_REQUEST['searchOrderStatus'], array("I","D"))):?>
						   <?if($deliveryComUrl):?>
						   <a class="btn_sml" href="<?=$deliveryComUrl?>" target="_blank"><strong>조회</strong></a>
						   <?else:?>
						   <a class="btn_sml" href="javascript:alert('조회 정보가 없습니다.')" target="_blank"><strong>조회</strong></a>
						   <?endif;?>
					   <?else:?>
					   <?endif;?>
					<?else:?>
					-
					<?endif;?>

				</td>
				<!--td alt="결제상태"><?=$settleStatus?></td-->
				<td alt="배송상태">
					 <?if(in_array($_REQUEST['searchOrderStatus'], array("I","D"))):?>
						<select id="deliveryStatus">
							<option value="">선택</option>
							<?foreach($S_ARY_DELIVERY_STATUS as $key => $value):?>
							<option value="<?=$key?>"<?if($key==$row['SO_DELIVERY_STATUS']){echo " selected";}?>><?=$value?></option>
							<?endforeach;?>
						</select>
					<?else:?>
						배송준비중
						<select id="deliveryStatus" style="display:none">
							<option value="">배송준비중</option>
						</select>
					<?endif;?>

				</td>
				<?if(in_array($_REQUEST['searchOrderStatus'], array("D"))):?>
				<td alt="구매상태">
				<a class="btn_sml" href="javascript:goOrderStatusSaveActEvent('<?=$row['SO_NO']?>');"><strong>구매완료</strong></a>
				</td>
				<?endif;?>
			</tr>
			<tr>
				<td colspan="2"><?=$LNG_TRANS_CHAR["OW00088"] //수령인?></td>
				<td colspan="11" style="text-align:left;">
					[<?=$row[O_B_NAME]?>] [<?=$row[O_B_ZIP]?>] <?=$row[O_B_ADDR1]?> <?=$row[O_B_ADDR2]?> [<?=$row[O_B_HP]?>] 
					<?if($a_admin_type == "A" && $row['M_NO'] > 0):?>
					<a class="btn_sml" href="javascript:goMemberCrmView('<?=$row['M_NO']?>');" id="menu_auth_m" style="display: inline-block;"><strong>CRM</strong></a>
					<?endif;?>
				</td>
			</tr>
			<?endwhile;?>
		</table>
	</div>
	<!-- Pagenate object --> 
	<div class="paginate">  
		<?=drawPaging($intPage,$intPageLine,$intPageBlock,$intTotal,$intTotPage,$linkPage,"","")?> 
	</div>  
	<!-- Pagenate object --> 
</div>





