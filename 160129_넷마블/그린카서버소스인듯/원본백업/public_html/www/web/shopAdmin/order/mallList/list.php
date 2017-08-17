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
		<h2><?=$strMenuTitle?><?//=$LNG_TRANS_CHAR["OW00001"] //주문관리?></h2>
		<div class="clr"></div>
	</div>
	<!-- 검색 -->
	<div class="searchTableWrap">
	<? include "search.skin.inc.php"; ?>
	</div>

	<div class="tableList">
		<div class="tableListTopWrap">
			<?if ($strOrderInfoDisplayYN == "Y"){?><a class="btn_sml" href="javascript:goSettleSaveAllActEvent();"><strong><?=$LNG_TRANS_CHAR["OW00154"] //주문상태 수정?></strong></a><?}?>
			<a class="btn_sml" href="javascript:goDeliverySaveAllActEvent();"><strong><?=$LNG_TRANS_CHAR["OW00155"] //배송정보 수정?></strong></a>
			<a class="btn_sml" href="javascript:goOrderStatusSaveAllActEvent();"><strong><?=$LNG_TRANS_CHAR["OW00156"] //구매상태 수정?></strong></a>
			<?if ($strOrderInfoDisplayYN == "Y"){?>
			<a class="btn_excel_big" href="javascript:goExcel('excelOrderList');" id="menu_auth_e" style="display:none:"><strong>Excel Download</strong></a>
			<?}else{?>
			<a class="btn_excel_big" href="javascript:goExcel('excelOrderMallList');" id="menu_auth_e" style="display:none:"><strong>Excel Download</strong></a>
			<?}?>
			
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
	<!-- 검색 -->
	<!-- 주문 리스트 -->
	<div class="tableList">
		<table style="border-left:1px solid #D2D0D0">
			<colgroup>
				<col width=40/>
				<col width=50/>
				<col width=150/>
				<col width=190/>
				<?if ($strOrderInfoDisplayYN == "Y"){?><col width=190/><?}?>
				<col width=100/>
				<col width=100/>
				<col width=200/>
				<col width=150/>
				<col width=50/>
				<col width=200/>
				<col width=150/>
				<?if ($strOrderInfoDisplayYN == "Y"){?><col width=100/><?}?>
			</colgroup>
			<tr>
				<th><input type="checkbox" id="chkAll" data_target="orderNo"/></th>
				<th><?=$LNG_TRANS_CHAR["CW00009"] //번호?></th>
				<th><?=$LNG_TRANS_CHAR["OW00002"] //주문번호?>(<?=$LNG_TRANS_CHAR["OW00074"] //주문일시?>)</th>
				<th><?="주문정보"; //주문정보?></th>
				<?if ($strOrderInfoDisplayYN == "Y"){?><th><?="결제정보"; //결제정보?></th><?}?>
				<th><?="주문상태"; //주문상태?></th>
				<th><?="입점사"; //입점사?></th>
				<th><?=$LNG_TRANS_CHAR["OW00022"] //상품정보?></th>
				<th><?=$LNG_TRANS_CHAR["OW00023"] //상품금액?></th>
				<th><?=$LNG_TRANS_CHAR["OW00025"] //수량?></th>
				<th><?="배송정보" //배송정보?></th>
				<th><?="구매상태" //구매상태?></th>
				<?if ($strOrderInfoDisplayYN == "Y"){?><th><?=$LNG_TRANS_CHAR["CW00007"] //관리?></th><?}?>
			</tr>
			<?while($row = mysql_fetch_array($orderListResult)): // 주문 리스트 

				$strDeliveyState = $row[O_B_STATE];
				if ($row['O_B_COUNTRY'] == "US") $strDeliveyState = $aryCountryState[$row['O_B_STATE']];

				$param								= "";
				$param['searchField']				= $_REQUEST['searchField'];
				$param['searchKey']					= $_REQUEST['searchKey'];
				$param['searchDeliveryStatus']		= $_REQUEST['searchDeliveryStatus'];
				$param['searchDeliveryCom']			= $_REQUEST['searchDeliveryCom'];
				$param['searchShopNo']				= $strOrderInfoShopNo;
				$param['o_no']						= $row['O_NO'];
				$param['order_by']					= "SO.SH_NO ASC";
				$shopOrderListTotal					= $orderMgr->getShopOrderListEx($db, "OP_COUNT", $param);
				$shopOrderListResult				= $orderMgr->getShopOrderListEx($db, "OP_LIST", $param);
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
				
				/* 회원 소속 */
				$strMemberCateList = $strMemberCateName_1 = $strMemberCateName_2 = $strMemberCateName_3 = "";
				if ($S_FIX_MEMBER_CATE_USE_YN  == "Y"){

					$param								= "";
					$param['M_NO']						= $row['M_NO'];
					$param['ORDER_BY']					= "C.C_CODE ASC";
					$param['MEMBER_CATE_MGR_JOIN']		= "Y";
					$aryMemberCateList					= $memberCateMgr->getMemberCateJoinListEx($db, "OP_ARYTOTAL", $param);
					
					if (is_array($aryMemberCateList)){
						foreach($aryMemberCateList as $key => $memberCateRow){
							//if ($key > 0) continue;
							$intMemberCateLevel	= strlen($memberCateRow['C_CODE']) / 3;
							//$strMemberCateList	= "";
							for($i = 1; $i<=3; $i++):
								if($intMemberCateLevel >= $i):
									$strCateCode		 = substr($memberCateRow['C_CODE'], 0, $i*3);
									${"strMemberCateName_".$i} = $MEMBER_CATE[$strCateCode]['C_NAME'];								
								endif;
							endfor;

							$strMemberCateList .= "소속 : ";
							$strMemberCateList .= $strMemberCateName_1;
							$strMemberCateList .= ($strMemberCateName_2)? " > {$strMemberCateName_2}":"";
							$strMemberCateList .= ($strMemberCateName_3)? " > {$strMemberCateName_3}":"";
							$strMemberCateList .= "<BR>";
						}
					}				
				}
				/* 회원 소속 */

				## 기본설정
				$intMemberNo		= $row['M_NO'];
			?>
			<tr id="order_<?=$row['O_NO']?>">
				<td alt="선택"><input type="checkbox" id="orderNo"/></td>
				<td alt="번호"><?=$intListNum--?></td>
				<td alt="주문번호(주문일시)">
					<?=$row['O_KEY']; // 주문번호?><br>(<?=$row['O_REG_DT']?>)
					<br><a class="btn_sml" href="javascript:goOrderView('<?=$row[O_NO]?>','<?=$a_admin_shop_no?>');"><span><?=$LNG_TRANS_CHAR["OW00012"] //상세보기?></span></a>
					<br><a class="<?=($row['MEMO_CNT']) ? "btn_blue_sml":"btn_sml";?>" href="javascript:goOrderMemoListEvent('<?=$row['O_NO']?>');"><strong>메모<?=($row['MEMO_CNT']) ? "({$row['MEMO_CNT']})":"";?></strong></a>

				</td>
				<td alt="주문정보" style="text-align:left;">
					주문자 : <?=$row['O_J_NAME'] // 주문자명?><br>
					아이디 : <?=$row['M_ID'] // 아이디?><?=(!$row['M_ID'])?"(".$row['M_NAME'].")":"";?><br>
					메일 : <?=$row['O_J_MAIL'] // 메일?><br>
					연락처1 : <?=$row['O_J_PHONE'] // 연락처1?><br>
					연락처2	: <?=$row['O_J_HP'] // 연락처2?><br>
					<?=$strMemberCateList?>
					<?if($a_admin_type == "A" && $intMemberNo > 0):?>
					<a class="btn_sml" href="javascript:goMemberCrmView('<?=$intMemberNo?>');" id="menu_auth_m" style="display: inline-block;"><strong>CRM</strong></a>
					<?endif;?>
				</td>
				<?if ($strOrderInfoDisplayYN == "Y"){?>
				<td alt="결제정보" style="text-align:left;">
					결제방법:<?=$strOrderSettle // 결제방법?>
					<?
						$settle = $row['O_SETTLE'];
						if ($settle == "B"):
							//입금계좌, 입금자명
							echo "<br>{$LNG_TRANS_CHAR['OW00085']}:{$row[O_BANK_ACC]} <br>{$LNG_TRANS_CHAR['OW00086']} : {$row['O_BANK_NAME']}";
						elseif ($settle == "T"):
							// 입금계좌, 입금마감시간
							$bankValidDT = date("Y-m-d", strtotime($row['O_BANK_VALID_DT']));
							echo "<br>{$LNG_TRANS_CHAR['OW00085']}:".$aryTBank[$row['O_BANK']]." {$row[O_BANK_ACC]} <br>{$LNG_TRANS_CHAR['OW00087']} : {$bankValidDT}";
						endif;
						
						if ($row['O_APPR_DT']){
							echo "<br>결제일자:".$row['O_APPR_DT'];
						}

						if ($row['O_CASH_YN'] == "Y"){
							echo " 현금영수증:".$row['O_CASH_INFO'];
							if ($row['O_CASH_AUTH_NO']) echo "<br>(".$row['O_CASH_AUTH_NO'].")";
						}
					
					?>
					
				</td>
				<?}?>
				<td alt="결제상태">
					<select id="settleStatus">
						<option value="">선택</option>
						<?foreach($S_ARY_SETTLE_STATUS as $key => $value):?>
						<option value="<?=$key?>"<?if($row['O_STATUS']==$key){echo " selected";}?>><?=$value?></option>
						<?endforeach;?>
					</select>
					<?if ($strOrderInfoDisplayYN == "Y"){?><a class="btn_sml" href="javascript:goSettleSaveActEvent('<?=$row['O_NO']?>')"><strong>수정</strong></a><?}?>
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
							   //echo $db->query;
							   $orderCartListResult					= $orderMgr->getOrderCartListEx($db, "OP_LIST", $param);
//							   ECHO $db->query."<br>";
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

									$strDeliveryTypeName = "";
									if ($ocRow['P_BAESONG_TYPE'] == "2") $strDeliveryTypeName = "무료배송";
									else if ($ocRow['P_BAESONG_TYPE'] == "3") $strDeliveryTypeName = "배송비고정";
									else if ($ocRow['P_BAESONG_TYPE'] == "4") $strDeliveryTypeName = "수령별배송";
									else if ($ocRow['P_BAESONG_TYPE'] == "5") $strDeliveryTypeName = "착불";
									else $strDeliveryTypeName = "기본배송";

									// 배송 조회
									$deliveryComUrl		= "";
									if($sRow['SO_DELIVERY_COM'] && $sRow['SO_DELIVERY_NUM']):
									$deliveryComUrl		= $aryDeliveryUrl[$sRow['SO_DELIVERY_COM']];
									$deliveryComUrl		= str_replace("{dev_no}", $sRow['SO_DELIVERY_NUM'], $deliveryComUrl);
									endif;

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

								<?if ($strDeliveryTypeName){?>/ <?=$strDeliveryTypeName?><?}?>
							</td>
							<td alt="수량"><?=$ocRow['OC_QTY']?></td>
							<td rowspan="<?=$orderCartListTotal?>" alt="배송상태" style="text-align:left;">
							  배송요금:<?=$moneyMarkL?> <?=getFormatPrice($sRow['SO_TOT_DELIVERY_CUR_PRICE'],2)?><?=$moneyMarkR?><br>
							  배송상태:
								<select id="deliveryStatus">
								  <option value="">선택</option>
								  <?foreach($S_ARY_DELIVERY_STATUS as $key => $value):?>
								  <option value="<?=$key?>"<?if($sRow['SO_DELIVERY_STATUS'] == $key){echo " selected";}?>><?=$value?></option>
								  <?endforeach;?>
								<select><br>
							  배송회사:
								<select id="deliveryCom">
								  <option value="">선택</option>
								  <?foreach($deliveryCom as $key => $value):?>
								  <option value="<?=$key?>"<?if($sRow['SO_DELIVERY_COM'] == $key){echo " selected";}?>><?=$value?></option>
								  <?endforeach;?>
								</select><br>
							  배송번호:<input type="text" id="deliveryNum" value="<?=$sRow['SO_DELIVERY_NUM']?>"><br>
							 <?if ($deliveryComUrl){?>
							 <a class="btn_sml" href="<?=$deliveryComUrl?>" target="_blank"><strong>배송추적</strong></a>
							 <?}?>
							  <a class="btn_sml" href="javascript:goDeliverySaveActEvent('<?=$sRow['SO_NO']?>')"><strong>수정</strong></a>
							
							</td>
							
							<td alt="구매상태">
								<!--<a class="btn_sml" href="javascript:goOrderCeritySaveActEvent(<?=$ocRow['OC_NO']?>);"><strong>구매확정</strong></a>
								<a class="btn_sml" href="javascript:goOrderReturnEvent(<?=$ocRow['OC_NO']?>);"><strong>반품/교환/취소</strong></a>//-->
								<div id="shop_order_cart_<?=$ocRow['OC_NO']?>">
									<select id="orderStatus" default="<?=$ocRow['SOC_STATUS'].$ocRow['SOC_'.$ocRow['SOC_STATUS'].'_STATUS']?>">
										<option value="">선택</option>
										<option value="E" <?if($ocRow['SOC_STATUS']=="E"){echo "selected";}?>>구매완료</option>
										<?foreach($S_ARY_SETTLE_ORDER_STATUS as $key => $value):?>
										<option value="<?=$key?>"<?if($ocRow['SOC_STATUS'].$ocRow['SOC_'.$ocRow['SOC_STATUS'].'_STATUS']==$key){echo " selected";}?>><?=$value?></option>
										<?endforeach;?>
									</select>
									<a class="btn_sml" href="javascript:goOrderStatusSaveActEvent('<?=$ocRow['OC_NO']?>')"><strong>수정</strong></a>
									<?
										if ($ocRow['SOC_STATUS'] == "C"){
											if ($ocRow['SOC_C_REQ_DT']){
												echo "<br>취소신청일:".$ocRow['SOC_C_REQ_DT'];
											}
											if ($ocRow['SOC_C_REG_DT']){
												echo "<br>취소완료일:".$ocRow['SOC_C_REG_DT'];
											}
										}
									?>
								</div>
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

								$strDeliveryTypeName = "";
								if ($ocRow['P_BAESONG_TYPE'] == "2") $strDeliveryTypeName = "무료배송";
								else if ($ocRow['P_BAESONG_TYPE'] == "3") $strDeliveryTypeName = "배송비고정";
								else if ($ocRow['P_BAESONG_TYPE'] == "4") $strDeliveryTypeName = "수령별배송";
								else if ($ocRow['P_BAESONG_TYPE'] == "5") $strDeliveryTypeName = "착불";
								else $strDeliveryTypeName = "기본배송";
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
								<?if ($strDeliveryTypeName){?>/ <?=$strDeliveryTypeName?><?}?>
								
							</td>
							<td alt="수량"><?=$ocRow['OC_QTY']?></td>
							<td alt="구매상태">
								<div id="shop_order_cart_<?=$ocRow['OC_NO']?>" >
									<select id="orderStatus" default="<?=$ocRow['SOC_STATUS'].$ocRow['SOC_'.$ocRow['SOC_STATUS'].'_STATUS']?>">
										<option value="">선택</option>
										<option value="E" <?if($ocRow['SOC_STATUS']=="E"){echo "selected";}?>>구매완료</option>
										<?foreach($S_ARY_SETTLE_ORDER_STATUS as $key => $value):?>
										<option value="<?=$key?>"<?if($ocRow['SOC_STATUS'].$ocRow['SOC_'.$ocRow['SOC_STATUS'].'_STATUS']==$key){echo " selected";}?>><?=$value?></option>
										<?endforeach;?>
									</select>
									<a class="btn_sml" href="javascript:goOrderStatusSaveActEvent('<?=$ocRow['OC_NO']?>')"><strong>수정</strong></a>
									
									<?if ($strOrderInfoDisplayYN == "Y"){?>
									<!-- <a class="btn_sml" href="javascript:goOrderPartCancelEvent(<?=$row['O_NO']?>,'<?=$ocRow['OC_NO']?>');"><strong>부분취소</strong></a>//-->
									<?}?>
								
									<?
										if ($ocRow['SOC_STATUS'] == "C"){
											if ($ocRow['SOC_C_REQ_DT']){
												echo "<br>취소신청일:".$ocRow['SOC_C_REQ_DT'];
											}
											if ($ocRow['SOC_C_REG_DT']){
												echo "<br>취소완료일:".$ocRow['SOC_C_REG_DT'];
											}
										}
									?>
								
								</div>
							</td>
						</tr>
						<?    endwhile;
							endif;
						  endwhile;
						  
						  
						  ?>
						 <tr>
							<td colspan="6"  style="text-align:left;">
								<?if ($strOrderInfoDisplayYN == "Y"){?>
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
								<?}?>
								<div>
								<?=$LNG_TRANS_CHAR["OW00088"] //수령인?> [<?=$row[O_B_NAME]?>] [<?=$row[O_B_ZIP]?>] <?=$row[O_B_ADDR1]?> <?=$row[O_B_ADDR2]?> <?=$row[O_B_CITY]?> <?=$strDeliveyState?> <?=$aryCountryList[$row[O_B_COUNTRY]]?> <a class="btn_sml" href="javascript:goOrderDeliveryAddr('<?=$row['O_NO']?>');"><strong>배송정보수정</strong></a>
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
						
					</table>	
				</td>
				<?endif;?>
				<?if ($strOrderInfoDisplayYN == "Y"){?>
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