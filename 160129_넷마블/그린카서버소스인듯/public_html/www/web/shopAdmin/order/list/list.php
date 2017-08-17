<div id="contentArea">
	<div class="contentTop">
		<h2><?=$LNG_TRANS_CHAR["OW00001"] //주문관리?></h2>
		<div class="clr"></div>
	</div>


	<!-- ******** 컨텐츠 ********* -->
	<div class="searchTableWrap">
		<?include "search.inc.php";?>
	</div>

	<div class="tableListWrap">
		<table class="tableList">
			<colgroup>
				<col width=40/>
				<col width=40/>
				<col width=150/>
				<col width=150/>
				<col width=150/>
				<col width=150/>
				<col />
				<col width=120/>
				<col width=120/>
				<col width=100/>
				<col width=100/>
				<col width=205/>
			</colgroup>
			<tr>
				<th><input type="checkbox" name="chkAll" value="Y" onclick="javascript:C_getCheckAll(this.checked)"/></th>
				<th><?=$LNG_TRANS_CHAR["CW00009"] //번호?></th>
				<th><?=$LNG_TRANS_CHAR["OW00002"] //주문번호?></th>
				<th><?=$LNG_TRANS_CHAR["OW00074"] //주문일시?></th>
				<th><?=$LNG_TRANS_CHAR["OW00075"] //총주문금액?></th>
				<th><?=$LNG_TRANS_CHAR["OW00027"] //배송비?></th>
				<th><?=$LNG_TRANS_CHAR["OW00003"] //주문자?></th>
				<th><?=$LNG_TRANS_CHAR["OW00009"] //거래번호?></th>
				<th><?=$LNG_TRANS_CHAR["OW00038"] //결제상태?></th>
				<th><?=$LNG_TRANS_CHAR["OW00010"] //주문상태?></th>
				<th><?=$LNG_TRANS_CHAR["CW00007"] //관리?></th>
			</tr>
			<?if ($intTotal == 0){?>
			<tr>
				<td colspan="11"><?=$LNG_TRANS_CHAR["CS00001"]?></td>
			</tr>
			<?}else{
				while($row = mysql_fetch_array($result)){
					$strOrderSettle = $btnOrderCancel = $brnOrderCalOff = $brnOrderAccClear = "";
					if ($row[O_SETTLE] == "C") $strOrderSettle = $S_ARY_SETTLE_TYPE["C"]; //"신용카드";
					else if ($row[O_SETTLE] == "A") $strOrderSettle = $S_ARY_SETTLE_TYPE["A"]; //"계좌이체";
					else if ($row[O_SETTLE] == "T") $strOrderSettle = $S_ARY_SETTLE_TYPE["T"]; //"가상계좌";
					else if ($row[O_SETTLE] == "B") $strOrderSettle = $S_ARY_SETTLE_TYPE["B"]; //"무통장입금";
					else if ($row[O_SETTLE] == "P") $strOrderSettle = $S_ARY_SETTLE_TYPE["P"]; //"포인트/쿠폰";
					else if ($row[O_SETTLE] == "Y") $strOrderSettle = $S_ARY_SETTLE_TYPE["Y"]; //"페이팔";
					else if ($row[O_SETTLE] == "X") $strOrderSettle = $S_ARY_SETTLE_TYPE["X"]; //"EXIMBAY";
					else if ($row[O_SETTLE] == "M") $strOrderSettle = $S_ARY_SETTLE_TYPE["M"]; //"휴대폰";

					/* 주문취소 버튼은 주문상태가 주문취소,반품완료,환불완료일때는 보이지 않는다 */
					$btnOrderCancel = "";
					if ($row[O_STATUS] != "C" && $row[O_STATUS] != "T" && $row[O_STATUS] != "E")
					{
						$strOrderCancelText = $LNG_TRANS_CHAR["OW00041"]; //"배송전취소";
						if ($row[O_STATUS] == "B" || $row[O_STATUS] == "I" || $row[O_STATUS] == "D"){
							$strOrderCancelText = $LNG_TRANS_CHAR["OW00042"]; //"배송후취소";
						}
						$btnOrderCancel = "<a class=\"btn_sml\" href=\"javascript:goOrderCancel(".$row[O_NO].");\" id=\"menu_auth_e1\" style=\"display:none\"><strong>".$strOrderCancelText."</strong></a>";
					}

					$btnOrderCancelOff = "";
					if ($row[O_STATUS] == "C")
					{
						$btnOrderCancelOff = "<a class=\"btn_sml\" href=\"javascript:goOrderCancelOff(".$row[O_NO].",'".$row[O_PG]."');\"  id=\"menu_auth_e1\" style=\"display:none\"><strong>".$LNG_TRANS_CHAR["OW00076"]."</strong></a>"; //취소완료
						if ($row[O_CEL_STATUS] == "N"){
							$btnOrderCancelOff = "<a class=\"btn_sml\" href=\"javascript:goOrderCancelOff(".$row[O_NO].",'".$row[O_PG]."');\"  id=\"menu_auth_e1\" style=\"display:none\"><strong>".$LNG_TRANS_CHAR["OW00077"]."</strong></a>"; //취소처리중
						} else if ($row[O_CEL_STATUS] == "P"){
							$btnOrderCancelOff = "<a class=\"btn_sml\" href=\"javascript:goOrderCancel(".$row[O_NO].");\"  id=\"menu_auth_e1\" style=\"display:none\"><strong>".$LNG_TRANS_CHAR["OW00078"]."</strong></a>"; //구매취소요청
						}
					}

					/* 결제 상태 */
					$strOrderSettleStatusText = "";
					if ($row[O_STATUS] == "J" || $row[O_STATUS] == "O"){
						$btnOrderSettleStatusUpdate = "<a class=\"btn_sml\" href=\"javascript:goOrderSettleStatusUpdate(".$row[O_NO].");\"><strong>".$LNG_TRANS_CHAR["OW00079"]."</strong></a>"; //입금확인전
					} else {
						$btnOrderSettleStatusUpdate = $LNG_TRANS_CHAR["OW00080"]; //"결제완료";
					}

					/* 주문내역 가지고 오기*/
					$orderMgr->setO_NO($row[O_NO]);
					$orderMgr->setOC_LIST_ARY("Y");
					$aryOrderCartList = $orderMgr->getOrderCartList($db);

					$strDeliveyState	= $row[O_B_STATE];
					if ($row[O_B_COUNTRY] == "US") $strDeliveyState = $aryCountryState[$row[O_B_STATE]];

					/* 사은품 내역 가지고 오기*/
					$aryOrderGiftList = $orderMgr->getOrderGiftList($db);

					if ($row['O_USE_LNG'] == "KR"){
						if ($row['O_PG'] == "K" && $row['O_SETTLE'] == "T"){
							$strReturnBankName = $aryTBank[$row['O_BANK']];
						}

						if ($row['O_PG'] == "A" && $row['O_SETTLE'] == "T"){
							$strReturnBankName = $S_ARY_RETURN_BANK[$row['O_BANK']];
						}
					}

					## 수령인 연락처 설정
					$strHp		= $row['O_B_HP'];
					if($strHp) { $strHp = "(연락처: {$strHp})"; }



				?>
			<tr>
				<td><input type="checkbox" id="chkNo[]" name="chkNo[]" value="<?=$row[O_NO]?>"></td>
				<td><?=$intListNum?></td>
				<td>
					<span><?=$row[O_KEY]?></span>
					<a class="btn_sml" href="javascript:goOrderView('<?=$row[O_NO]?>');"><span><?=$LNG_TRANS_CHAR["OW00012"] //상세보기?></span></a>
				</td>
				<td><span class="orderDate">[<?=$row[O_REG_DT]?>]</span></td>
				<td><span><?=getCurMark($S_ST_CUR)?></span> <strong><?=getFormatPrice($row[O_TOT_CUR_SPRICE],2,$row[O_USE_CUR])?><?=getCurMark2($S_ST_CUR)?></strong></td>
				<td>
					<?=getCurMark($S_ST_CUR)?> <?=getFormatPrice($row[O_TOT_DELIVERY_CUR_PRICE],2,$row[O_USE_CUR])?><?=getCurMark2($S_ST_CUR)?>
				</td>
				<td><?=$row[O_J_NAME]?><?=($row[M_NO])? "(".$row[M_ID].")":"";?></td>
				<td><?=$row[O_APPR_NO]?></td>
				<td><?=$btnOrderSettleStatusUpdate?></td>
				<td>
					<?if ($row[O_STATUS] == "R"|| $row[O_STATUS] == "T"){
						echo $S_ARY_SETTLE_STATUS[$row[O_STATUS]];
					}else{?>
					<?=drawSelectBoxMore("orderStatus_".$row[O_NO],$S_ARY_SETTLE_STATUS,$row[O_STATUS],$design ="defSelect",$onchange="",$etc="",$firstItem="",$html="N")?>
					<?}?>
				</td>
				<td rowspan="3" style="text-align:left;">
					<?if (!($row[O_STATUS] == "R" || $row[O_STATUS] == "T")){?>
					<a class="btn_sml" href="javascript:goOrderStatusOneUpdate('<?=$row[O_NO]?>');"><strong><?=$LNG_TRANS_CHAR["OW00081"] //주문상태변경?></strong></a>
					<?}?>
					<?if ($row[O_STATUS] == "A" || $row[O_STATUS] == "B" || $row[O_STATUS] == "I" || $row[O_STATUS] == "D"){?>
						<a class="btn_sml" href="javascript:goOrderDeliveryUpdate('<?=$row[O_NO]?>');" id="menu_auth_e2" style="display:none"><strong><?=$LNG_TRANS_CHAR["OW00044"] //배송정보?></strong></a>
					<?}?>
					<?=$btnOrderCancel?>
					<?=$btnOrderCancelOff?>
					<a class="btn_sml" href="javascript:goOrderDelete('<?=$row[O_NO]?>');" id="menu_auth_e2" style="display:none"><strong><?=$LNG_TRANS_CHAR["CW00004"] //삭제?></strong></a>
				</td>
			</tr>
			<tr>
				<td colspan="2"><?=$LNG_TRANS_CHAR["OW00082"] //결제?></td>
				<td colspan="8" style="text-align:left;line-height:18px">
					<strong><?=$strOrderSettle?></strong>
					<span class="txtRedPrice"><?=getCurMark($S_ST_CUR)?></span> <strong class="txtRedPrice"><?=getFormatPrice($row[O_TOT_CUR_SPRICE],2,$row[O_USE_CUR])?><?=getCurMark2($S_ST_CUR)?></strong>
					(<?=$LNG_TRANS_CHAR["OW00083"] //총 상품금액?> : <?=getCurMark($S_ST_CUR)?> <?=getFormatPrice($row[O_TOT_CUR_PRICE],2,$row[O_USE_CUR])?><?=getCurMark2($S_ST_CUR)?>
					<?if ($row[O_TAX_PRICE] > 0){?>
					+ <?=$LNG_TRANS_CHAR["OW00084"] //부과세?> : <?=getCurMark($S_ST_CUR)?> <?=getFormatPrice($row[O_TAX_CUR_PRICE],2,$row[O_USE_CUR])?><?=getCurMark2($S_ST_CUR)?>
					<?}?>
					<?if ($row[O_TOT_PG_COMMISSION] > 0){?>
					+ <?=$LNG_TRANS_CHAR["OW00157"] //수수료?> : <?=getCurMark($S_ST_CUR)?> <?=getFormatPrice($row[O_TOT_PG_CUR_COMMISSION],2,$row[O_USE_CUR])?><?=getCurMark2($S_ST_CUR)?>
					<?}?>
					<?if ($row[O_TOT_DELIVERY_PRICE] > 0){?>
					+ <?=$LNG_TRANS_CHAR["OW00027"] //배송비?> : <?=getCurMark($S_ST_CUR)?> <?=getFormatPrice($row[O_TOT_DELIVERY_CUR_PRICE],2,$row[O_USE_CUR])?><?=getCurMark2($S_ST_CUR)?>
					<?if($row['O_USE_LNG']!='KR' && $row['O_DELIVERY_COM']){?>(<?=$aryDeliveryComAll[$row['O_DELIVERY_COM']]?>)<?}?>
					<?}?>
					<?if ($row[O_TOT_MEM_DISCOUNT_PRICE] > 0){?>
					- <?=$LNG_TRANS_CHAR["OW00115"] //추가할인금액?> : <?=getCurMark($S_ST_CUR)?> <?=getFormatPrice($row[O_TOT_MEM_DISCOUNT_CUR_PRICE],2,$row[O_USE_CUR])?><?=getCurMark2($S_ST_CUR)?></strong>
					<?}?>

					<?if ($row[O_USE_POINT] > 0){?>
					- <?=$LNG_TRANS_CHAR["OW00028"] //사용포인트?> : <?=getFormatPrice($row[O_USE_CUR_POINT],2,$row[O_USE_CUR])?>
					<?}?>
					<?if ($row[O_USE_COUPON] > 0){?>
					- <?=$LNG_TRANS_CHAR["OW00028"] //사용쿠폰?> : <?=getFormatPrice($row[O_USE_CUR_COUPON],2,$row[O_USE_CUR])?>
					<?}?>
					)
					<br/>
					<?if ($row[O_SETTLE] == "B"){?>
					<?=$LNG_TRANS_CHAR["OW00085"] //입금계좌?> : <?=$row[O_BANK_ACC]?> <?=$LNG_TRANS_CHAR["OW00086"] //입금자명?> : <?=$row[O_BANK_NAME]?>
					<?}?>
					<?if ($row[O_SETTLE] == "T"){?>
					<?=$LNG_TRANS_CHAR["OW00085"] //입금계좌?> : <?=$strReturnBankName?> <?=$row[O_BANK_ACC]?>
					<?=$LNG_TRANS_CHAR["OW00087"] //입금마감시간?> : <?=SUBSTR($row[O_BANK_VALID_DT],0,4)?>-<?=SUBSTR($row[O_BANK_VALID_DT],4,2)?>- <?=SUBSTR($row[O_BANK_VALID_DT],6,2)?>
					<?}?>
				</td>
			</tr>
			<tr>
				<td colspan="2"><?=$LNG_TRANS_CHAR["OW00088"] //수령인?></td>
				<td colspan="8" style="text-align:left;">[<?=$row[O_B_NAME]?>] [<?=$row[O_B_ZIP]?>] <?=$row[O_B_ADDR1]?> <?=($row[O_B_ADDR2])? ",".$row[O_B_ADDR2]:""?> <?=($row[O_B_CITY])?",".$row[O_B_CITY]:"";?> <?=($strDeliveyState) ? ",".$strDeliveyState:"";?> <?=($aryCountryList[$row[O_B_COUNTRY]]) ? ",".$aryCountryList[$row[O_B_COUNTRY]] : "";?> <?=$strHp?>
				<?
					if ($row['O_CASH_YN'] == "Y"){
						echo "/현금영수증:".$row['O_CASH_INFO'];
						if ($row['O_CASH_AUTH_NO']) echo "(".$row['O_CASH_AUTH_NO'].")";
					}
				?>

				<?
					if($row[O_SHIPPING_NO2]){
						echo "/통관개인정보:".$row[O_SHIPPING_NO2];
				}?>
				</td>
			</tr>
			<tr>
				<td colspan="11" style="padding:0px;border-bottom:1px solid #5a5a5a;">
					<!-- 상품목록 -->
						<div class="orderInfoList">
							<table>
								<colgroup>
									<col style="width:83px;"/>
									<col/>
									<col style="width:200px;"/>
									<col style="width:200px;"/>
								</colgroup>
								<tr>
									<th colspan="2"><?=$LNG_TRANS_CHAR["OW00022"] //주문상품?></th>
									<th><?=$LNG_TRANS_CHAR["OW00025"] //수량?></th>
									<th><?=$LNG_TRANS_CHAR["OW00089"] //판매가?></th>
								</tr>
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
										$strCartOptAttrVal = SUBSTR($strCartOptAttrVal,1);

										$aryCartItemList = "";
										if ($S_SHOP_PROD_ADD_ITEM_VERSION == "V2.O"){
											$aryCartItemList = $orderMgr->getOrderCartItemList($db);
										}
								?>
								<tr>
									<td>
										<img src="<?=$aryOrderCartList[$i][PM_REAL_NAME]?>" style="width:50px;"/>
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
											<?
											if ($S_SHOP_PROD_ADD_ITEM_VERSION == "V2.O"){
												if (is_array($aryCartItemList)){
													for($k=0;$k<sizeof($aryCartItemList);$k++){
														?>
														<li><?=$aryCartItemList[$k]['OCI_ITEM_NM']?>:<?=$aryCartItemList[$k]['OCI_ITEM_VAL']?></li>
														<?
													}
												}
											}
											?>
										</ul>
										<div class="clr"></div>
									</td>
									<td><?=$aryOrderCartList[$i][OC_QTY]?></td>
									<td><?=getCurMark($S_ST_CUR)?> <?=getFormatPrice($aryOrderCartList[$i][OC_CUR_PRICE],2,$row[O_USE_CUR])?><?=getCurMark2($S_ST_CUR)?></td>
								</tr>
								<?}}?>
								<?if (is_array($aryOrderGiftList)){?>
								<?	for($j=0;$j<sizeof($aryOrderGiftList);$j++){?>
								<tr>
									<td><img src="<?=$aryOrderGiftList[$j][CG_FILE]?>" style="width:50px;"/></td>
									<td style="text-align:left;border-left:none;">
										<ul>
											<li><?=$aryOrderGiftList[$j][CG_NAME]?></li>
											<li><?=$aryOrderGiftList[$j][OG_OPT]?></li>
										</ul>
										<div class="clr"></div>
									</td>
									<td>
										<?=$aryOrderGiftList[$j][OG_QTY]?>
									</td>
									<td></td>
								</tr>
								<?	}?>
								<?}?>
							</table>
						</div>
					<!-- 상품목록 -->
				</td>
			</tr>
			<tr class="blankTr">
				<td colspan="11"></td>
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
	<div class="paginate">
		<?=drawPaging($intPage,$intPageLine,$intPageBlock,$intTotal,$intTotPage,$linkPage,"","")?>
	</div>
	<!-- Pagenate object -->
	<div class="buttonBoxWrap">
		<a class="btn_big" href="javascript:goOrderSettleStatusUpdate(0);"><strong><?=$LNG_TRANS_CHAR["OS00010"]; //선택하신 주문정보를 모두 [결제완료]로 변경?></strong></a> - <?=$LNG_TRANS_CHAR["OS00011"] //주문상태가 [주문완료]일때만 변경됨?>
		<div class="line_H"></div>
			<select id="orderStatus" name="orderStatus">
				<option value="">:::<?=$LNG_TRANS_CHAR["CW00041"] //선택?>:::</option>
				<option value="B"><?=$S_ARY_SETTLE_STATUS["B"] //배송준비중?></option>
				<option value="I"><?=$S_ARY_SETTLE_STATUS["I"] //배송중?></option>
				<option value="D"><?=$S_ARY_SETTLE_STATUS["D"] //배송완료?></option>
				<option value="E"><?=$S_ARY_SETTLE_STATUS["E"] //구매완료?></option>
				<option value="C"><?=$S_ARY_SETTLE_STATUS["C"] //주문취소?></option>
				<option value="R"><?=$S_ARY_SETTLE_STATUS["R"] //반품완료?></option>
				<option value="T"><?=$S_ARY_SETTLE_STATUS["T"] //환불완료?></option>
			</select>
			<a class="btn_big" href="javascript:goOrderStatusUpdate();"><strong><?=$LNG_TRANS_CHAR["OS00012"] //선택하신 주문정보 모두 변경?></strong></a>
	</div>
</div>
