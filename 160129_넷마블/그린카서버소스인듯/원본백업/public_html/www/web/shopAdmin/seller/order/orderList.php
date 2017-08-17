<div id="contentArea">
	<div class="contentTop">
		<h2><?=$LNG_TRANS_CHAR["OW00001"] //주문관리?></h2>
		<div class="clr"></div>
	</div>

	<!-- ******** 컨텐츠 ********* -->
	<div class="searchTableWrap">
		<div class="searchFormWrap">
			<select name="searchField" id="searchField">
				<option value="K" <?=($strSearchField=="K")?"selected":"";?>><?=$LNG_TRANS_CHAR["OW00002"] //주문번호?></option>
				<option value="J" <?=($strSearchField=="J")?"selected":"";?>><?=$LNG_TRANS_CHAR["OW00003"] //주문자?></option>
				<option value="M" <?=($strSearchField=="M")?"selected":"";?>><?=$LNG_TRANS_CHAR["OW00004"] //회원ID?></option>
				<option value="B" <?=($strSearchField=="B")?"selected":"";?>><?=$LNG_TRANS_CHAR["OW00040"] //받는사람?></option>
			</select>
			<input type="text" id="searchKey" name="searchKey" value="<?=$strSearchKey?>" <?=$nBox?>/>
			<a class="btn_blue_big" href="javascript:goSearch('orderList');"><strong><?=$LNG_TRANS_CHAR["CW00027"]?></strong></a>
		</div><!-- searchFormWrap -->
		<table>
			<tr>
				<th><?=$LNG_TRANS_CHAR["OW00070"] //회원구분?></th>
				<td>
					<input type="radio" name="searchMemberType" value="all" checked> <?=$LNG_TRANS_CHAR["CW00022"] //전체?>
					<input type="radio" name="searchMemberType" value="member"<?=($strSearchMemberType=="member") ? "checked" : ""?>> <?=$LNG_TRANS_CHAR["OW00071"] //회원?>
					<input type="radio" name="searchMemberType" value="nonmember"<?=($strSearchMemberType=="nonmember") ? "checked" : ""?>> <?=$LNG_TRANS_CHAR["OW00072"] //비회원?>
				</td>
			</tr>
			<tr>
				<th><?=$LNG_TRANS_CHAR["OW00005"] //주문일?></th>
				<td>
					<input type="text" <?=$nBox?>  style="width:80px;" id="searchRegStartDt" name="searchRegStartDt" maxlength="10" value="<?=$strSearchRegStartDt?>"//>
					~
					<input type="text" <?=$nBox?>  style="width:80px;" id="searchRegEndDt" name="searchRegEndDt" maxlength="10" value="<?=$strSearchRegEndDt?>"//>
					<span class="searchWrapImg">
						<a class="btn_sml" href="javascript:C_getSearchDay('T','<?=$strMode?>','','searchRegStartDt','searchRegEndDt');"><strong><?=$LNG_TRANS_CHAR["CW00017"]?></strong></a>
						<a class="btn_sml" href="javascript:C_getSearchDay('1','<?=$strMode?>','','searchRegStartDt','searchRegEndDt');"><strong><?=$LNG_TRANS_CHAR["CW00018"]?></strong></a>
						<a class="btn_sml" href="javascript:C_getSearchDay('2','<?=$strMode?>','','searchRegStartDt','searchRegEndDt');"><strong><?=$LNG_TRANS_CHAR["CW00019"]?></strong></a>
						<a class="btn_sml" href="javascript:C_getSearchDay('1M','<?=$strMode?>','','searchRegStartDt','searchRegEndDt');"><strong><?=$LNG_TRANS_CHAR["CW00020"]?></strong></a>
						<a class="btn_sml" href="javascript:C_getSearchDay('2M','<?=$strMode?>','','searchRegStartDt','searchRegEndDt');"><strong><?=$LNG_TRANS_CHAR["CW00021"]?></strong></a>
						<a class="btn_sml" href="#"><strong><?=$LNG_TRANS_CHAR["CW00022"]?></strong></a>
					</span>
				</td>
			</tr>
			<tr>
				<th><?=$LNG_TRANS_CHAR["OW00038"] //결제상태?></th>
				<td>
					<input type="radio" name="searchSettleStatus" id="searchSettleStatus" value="" <?=(!$strSearchSettleStatus)?"checked":""?>> <?=$LNG_TRANS_CHAR["CW00022"] //전체?>
					<input type="radio" name="searchSettleStatus" id="searchSettleStatus" value="N" <?=($strSearchSettleStatus=="N")?"checked":""?>> <?=$LNG_TRANS_CHAR["SW00079"] //입금확인전?>
					<input type="radio" name="searchSettleStatus" id="searchSettleStatus" value="Y" <?=($strSearchSettleStatus=="Y")?"checked":""?>> <?=$LNG_TRANS_CHAR["SW00078"] //결제완료?>
				</td>
			</tr>
			<tr>
				<th><?=$LNG_TRANS_CHAR["SW00074"] //배송상태?></th>
				<td>
					<input type="checkbox" name="searchDeliveryStatus1" id="searchDeliveryStatus1" value="B" <?=($strSearchDeliveryStatus1=="B")?"checked":""?>> <?=$S_ARY_DELIVERY_STATUS["B"] //배송준비중?>
					<input type="checkbox" name="searchDeliveryStatus2" id="searchDeliveryStatus2" value="I" <?=($strSearchDeliveryStatus2=="I")?"checked":""?>> <?=$S_ARY_DELIVERY_STATUS["I"] //배송중?>
					<input type="checkbox" name="searchDeliveryStatus3" id="searchDeliveryStatus3" value="D" <?=($strSearchDeliveryStatus3=="D")?"checked":""?>> <?=$S_ARY_DELIVERY_STATUS["D"] //배송완료?>
				</td>
			</tr>
			<tr>
				<th><?=$LNG_TRANS_CHAR["SW00075"] //구매상태?></th>
				<td>
					<input type="checkbox" name="searchOrderStatus1" id="searchOrderStatus1" value="E" <?=($strSearchOrderStatus1=="E")?"checked":""?>> <?=$S_ARY_SETTLE_ORDER_STATUS["E"] //구매완료?>
					<input type="checkbox" name="searchOrderStatus2" id="searchOrderStatus2" value="R1" <?=($strSearchOrderStatus2=="R1")?"checked":""?>> <?=$S_ARY_SETTLE_ORDER_STATUS["R1"] //반품신청?>
					<input type="checkbox" name="searchOrderStatus3" id="searchOrderStatus3" value="R2" <?=($strSearchOrderStatus3=="R2")?"checked":""?>> <?=$S_ARY_SETTLE_ORDER_STATUS["R2"] //환불요청?>
					<input type="checkbox" name="searchOrderStatus4" id="searchOrderStatus4" value="R3" <?=($strSearchOrderStatus4=="R3")?"checked":""?>> <?=$S_ARY_SETTLE_ORDER_STATUS["R3"] //환불완료?>
				</td>
			</tr>
			<tr>
				<th></th>
				<td><a class="btn_excel_big" href="javascript:goExcel('excelOrderList');" id="menu_auth_e" style="display:none:"><strong>Excel Download</strong></a></td>
			</tr>
		</table>
	</div>
	<br>
	<div class="tableList">
		<table style="border-left:1px solid #D2D0D0">
			<colgroup>
				<col width=50/>
				<col width=40/>
				<col width=150/>
				<col width=150/>
				<col />
				<col width=150/>
				<col width=150/>
				<col width=120/>	
				<col width=120/>
				<col width=100/>
				<col width=100/>
			</colgroup>
			<tr>
				<th><input type="checkbox" name="chkAll" value="Y" onclick="javascript:C_getCheckAll(this.checked)"/></th>
				<th><?=$LNG_TRANS_CHAR["CW00009"] //번호?></th>
				<th><?=$LNG_TRANS_CHAR["OW00002"] //주문번호?></th>
				<th><?=$LNG_TRANS_CHAR["OW00074"] //주문일시?></th>
				<th><?=$LNG_TRANS_CHAR["SW00057"] //주문자?></th>
				<th><?=$LNG_TRANS_CHAR["OW00075"] //총주문금액?></th>
				<th><?=$LNG_TRANS_CHAR["SW00062"] //총정산금액?></th>
				<th><?=$LNG_TRANS_CHAR["OW00027"] //배송비?></th>
				<th><?=$LNG_TRANS_CHAR["OW00038"] //결제상태?></th>
				<th><?=$LNG_TRANS_CHAR["SW00042"] //배송업체?></th>
				<th><?=$LNG_TRANS_CHAR["SW00056"] //배송번호?></th>
				<th><?=$LNG_TRANS_CHAR["SW00074"] //배송상태?></th>
				<th><?=$LNG_TRANS_CHAR["SW00075"] //주문상태?></th>
			</tr>
			<?if ($intTotal == 0){?>
			<tr>
				<td colspan="14"><?=$LNG_TRANS_CHAR["CS00001"]?></td>
			</tr>
			<?}else{
				while($row = mysql_fetch_array($result)){

					/* 결제 상태 */
					$strOrderSettleStatusText = "";
					if ($row[O_STATUS] == "J" || $row[O_STATUS] == "O"){
						$strOrderSettleStatusText = $LNG_TRANS_CHAR["OW00079"]; //입금확인전
					} else {
						$strOrderSettleStatusText = $LNG_TRANS_CHAR["OW00080"]; //"결제완료";
					}

					/* 주문내역 가지고 오기*/
					$shopMgr->setO_NO($row[O_NO]);
					$shopMgr->setSH_NO($row[SH_NO]);
					$aryOrderCartList = $shopMgr->getShopOrderCartList($db);
					
					$strM_ID = ($S_MEM_CERITY=="1")?$row[M_ID]:$row[M_MAIL];
					
					## 배송 업체 설정
					$deliverCom = $row['SO_DELIVERY_COM'];
					if(!$row['SO_DELIVERY_COM']) { $deliverCom = $shopRow['SH_COM_DELIVERY_COR']; }
				?>
			<tr id="order_<?=$row[SO_NO]?>">
				<td><input type="checkbox" id="chkNo[]" name="chkNo[]" value="<?=$row[SO_NO]?>"></td>
				<td><?=$intListNum?></td>
				<td>
					<span><?=$row[O_KEY]?></span>
					<a class="btn_sml" href="javascript:goOrderView('<?=$row[O_NO]?>','<?=$row[SH_NO]?>');"><span><?=$LNG_TRANS_CHAR["OW00012"] //상세보기?></span></a>
				</td>
				<td><span class="orderDate">[<?=$row[O_REG_DT]?>]</span></td>
				<td style="text-align:left">
					<?=$row[O_J_NAME]?><?=($row[M_NO])? "(".$strM_ID.")":"";?>
					<br><?=$row[O_B_NAME]?> <?=$row[O_B_ADDR1]?> <?=$row[O_B_ADDR2]?>
				</td>
				<td><span><?=$S_ST_CUR_MARK1?></span> <strong><?=getFormatPrice($row[SO_TOT_CUR_SPRICE],2)?></strong></td>
				<td><span><?=$S_ST_CUR_MARK1?></span> <strong><?=getFormatPrice($row[SO_TOT_CUR_APRICE],2)?></strong></td>
				<td><?=getFormatPrice($row[SO_TOT_DELIVERY_CUR_PRICE],2)?></td>			
				<td><?=$strOrderSettleStatusText?></td>
				<td><?=$aryDeliveryCom[$deliverCom]; // 배송업체?>
					<input type="hidden" name="deliverCom_<?=$row[SO_NO]?>" id="deliverCom" value="<?=$deliverCom?>" />
				</td>
				<td>
					<input type="text" name="deliveryNum_<?=$row[SO_NO]?>" id="deliveryNum" value="<?=$row[SO_DELIVERY_NUM]?>">
				</td>
				<td>
					<?if ($row[O_STATUS] == "C" || $row[O_STATUS] == "R"|| $row[O_STATUS] == "T"){
					echo $S_ARY_SETTLE_STATUS[$row[O_STATUS]];
					}else{?>
					<?=drawSelectBoxMore("deliveryStatus_".$row[SO_NO],$S_ARY_DELIVERY_STATUS,$row[SO_DELIVERY_STATUS],$design ="defSelect",$onchange="",$etc="",$LNG_TRANS_CHAR["CW00041"],$html="N")?>
					<?}?>
				</td>
				<td>
					<?=drawSelectBoxMore("orderStatus_".$row[SO_NO],$S_ARY_SETTLE_ORDER_STATUS,$row[SO_ORDER_STATUS],$design ="defSelect",$onchange="",$etc="",$LNG_TRANS_CHAR["CW00041"],$html="N")?>
				</td>
			</tr>
			<tr>
				<td colspan="14" style="padding:0px;border-bottom:1px solid #5a5a5a;">
					<!-- 상품목록 -->
						<div class="orderInfoList">
							<table>
								<colgroup>
									<col style="width:120px;"/>
									<col/>
									<col style="width:200px;"/>
									<col style="width:200px;"/>
									<col style="width:200px;"/>
								</colgroup>
								<tr>
									<th colspan="2"><?=$LNG_TRANS_CHAR["SW00058"] //주문상품?></th>
									<th><?=$LNG_TRANS_CHAR["SW00059"] //수량?></th>
									<th><?=$LNG_TRANS_CHAR["SW00060"] //판매가?></th>
									<th><?=$LNG_TRANS_CHAR["SW00061"] //입고가?></th>			
								</tr>
								<?
								if (is_array($aryOrderCartList)){
									for($i=0;$i<sizeof($aryOrderCartList);$i++){
									
										$shopMgr->setOC_NO($aryOrderCartList[$i][OC_NO]);
										$aryProdCartAddOptList = $shopMgr->getShopOrderCartAddList($db);

										$strCartOptAttrVal = "";
										for($kk=1;$kk<=10;$kk++){
											if ($aryOrderCartList[$i]["OC_OPT_ATTR".$kk]){
												$strCartOptAttrVal .= $aryOrderCartList[$i]["OC_OPT_NM".$kk].":".$aryOrderCartList[$i]["OC_OPT_ATTR".$kk]."/";
											}
										}
										$strCartOptAttrVal = SUBSTR($strCartOptAttrVal,0,STRLEN($strCartOptAttrVal)-1);
								?>
								<tr>
									<td>
										<img src="<?=$aryOrderCartList[$i][PM_REAL_NAME]?>" style="width:100px;"/>
									</td>
									<td style="text-align:left;border-left:none;">										
										<ul>
											<li><?=$aryOrderCartList[$i][P_NAME]?></li>
											<li><?=$strCartOptAttrVal?></li>

											<?if (is_array($aryProdCartAddOptList)){
												for($k=0;$k<sizeof($aryProdCartAddOptList);$k++){
												
												?>
												<li><?=$LNG_TRANS_CHAR["OW00046"] //추가선택?> : <?=$aryProdCartAddOptList[$k][OCA_OPT_NM]?></li>
											<?}}?>
										</ul>
										<div class="clr"></div>
									</td>
									<td><?=$aryOrderCartList[$i][OC_QTY]?></td>
									<td><?=getFormatPrice($aryOrderCartList[$i][OC_CUR_PRICE],2)?></td>
									<td><?=getFormatPrice($aryOrderCartList[$i][OC_PRICE],2)?></td>
								</tr>
								<?}}?>
							</table>
						</div>
					<!-- 상품목록 -->
				</td>
			</tr>
			<?
					$intListNum--;
				}
			}
			?>
		</table>
	</div>
	<!-- tableList -->

	<!-- Pagenate object --> 
	<div class="paginate mt10">  
		<?=drawPaging($intPage,$intPageLine,$intPageBlock,$intTotal,$intTotPage,$linkPage,"","")?> 
	</div>  
	<!-- Pagenate object --> 
	<div style="text-align:left;margin-top:3px;">
		
		* <select id="deliveryStatus" name="deliveryStatus">
				<option value="">:::<?=$LNG_TRANS_CHAR["CW00041"] //선택?>:::</option>
				<option value="B"><?=$S_ARY_SETTLE_STATUS["B"] //배송준비중?></option>
				<option value="I"><?=$S_ARY_SETTLE_STATUS["I"] //배송중?></option>
				<option value="D"><?=$S_ARY_SETTLE_STATUS["D"] //배송완료?></option>
			</select> 
			<a class="btn_big" href="javascript:goDeliveryStatusUpdate();"><strong><?=$LNG_TRANS_CHAR["SS00001"] //선택하신 배송정보 모두 변경?></strong></a>
			<a class="btn_big" href="javascript:goDeliveryUpdate();"><strong><?=$LNG_TRANS_CHAR["SW00077"] //일괄배송정보변경?></strong></a>
		<br>
		* <select id="orderStatus" name="orderStatus">
				<option value="">:::<?=$LNG_TRANS_CHAR["CW00041"] //선택?>:::</option>
				<option value="E"><?=$S_ARY_SETTLE_ORDER_STATUS["E"] //구매완료?></option>
				<option value="R2"><?=$S_ARY_SETTLE_ORDER_STATUS["R2"] //환불요청?></option>
			</select> 
			<a class="btn_big" href="javascript:goOrderStatusUpdate();"><strong><?=$LNG_TRANS_CHAR["SS00002"] //선택하신 주문정보 모두 변경?></strong></a>
			<a class="btn_big" href="javascript:goOrderUpdate();"><strong><?=$LNG_TRANS_CHAR["SW00076"] //일괄구매정보변경?></strong></a>
	</div>
</div>
