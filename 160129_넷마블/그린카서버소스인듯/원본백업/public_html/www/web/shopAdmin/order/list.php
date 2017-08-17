<div id="contentArea">
	<div class="contentTop">
		<h2>주문관리</h2>
		<div class="clr"></div>
	</div>

	<!-- ******** 컨텐츠 ********* -->
	<div class="searchTableWrap">
		<div class="searchFormWrap">
			<select name="searchField" id="searchField">
				<option value="K" <?=($strSearchField=="K")?"selected":"";?>>주문번호</option>
				<option value="J" <?=($strSearchField=="J")?"selected":"";?>>주문자</option>
				<option value="M" <?=($strSearchField=="M")?"selected":"";?>>회원ID</option>
				<option value="B" <?=($strSearchField=="B")?"selected":"";?>>받는사람</option>
			</select>
			<input type="text" id="searchKey" name="searchKey" value="<?=$strSearchKey?>" <?=$nBox?>/>
			<a class="btn_blue_big" href="javascript:goSearch();"><strong>검색</strong></a>
		</div><!-- searchFormWrap -->
		<table>
			<tr>
				<th>회원구분</th>
				<td>
					<input type="radio" name="searchMemberType" value="all" checked> 전체
					<input type="radio" name="searchMemberType" value="member"<?=($strSearchMemberType=="member") ? "checked" : ""?>> 회원
					<input type="radio" name="searchMemberType" value="nonmember"<?=($strSearchMemberType=="nonmember") ? "checked" : ""?>> 비회원
				</td>
			</tr>
			<tr>
				<th>택배회사</th>
				<td>
					<?=drawCheckBox("searchDeliveryCom[]", $aryDeliveryComAll, $strSearchDeliveryCom, $design="", $readonly=false, $gap="&nbsp;", $colCnt=0, $onclick="")?>
				</td>
			</tr>
			<tr>
				<th>주문일</th>
				<td>
					<input type="text" <?=$nBox?>  style="width:80px;" id="searchRegStartDt" name="searchRegStartDt" maxlength="10" value="<?=$strSearchRegStartDt?>"//>
					~
					<input type="text" <?=$nBox?>  style="width:80px;" id="searchRegEndDt" name="searchRegEndDt" maxlength="10" value="<?=$strSearchRegEndDt?>"//>
					<span class="searchWrapImg">
						<a href="javascript:C_getSearchDay('T','<?=$strMode?>','','searchRegStartDt','searchRegEndDt');"><img src="/shopAdmin/himg/common/btn_sort_today.gif"/></a>
						<a href="javascript:C_getSearchDay('1','<?=$strMode?>','','searchRegStartDt','searchRegEndDt');"><img src="/shopAdmin/himg/common/btn_sort_week.gif"/></a>
						<a href="javascript:C_getSearchDay('2','<?=$strMode?>','','searchRegStartDt','searchRegEndDt');"><img src="/shopAdmin/himg/common/btn_sort_15.gif"/></a>
						<a href="javascript:C_getSearchDay('1M','<?=$strMode?>','','searchRegStartDt','searchRegEndDt');"><img src="/shopAdmin/himg/common/btn_sort_month.gif"/></a>
						<a href="javascript:C_getSearchDay('2M','<?=$strMode?>','','searchRegStartDt','searchRegEndDt');"><img src="/shopAdmin/himg/common/btn_sort_2month.gif"/></a>
						<a href="#"><img src="/shopAdmin/himg/common/btn_sort_all.gif"/></a>
					</span>
				</td>
			</tr>
			<tr>
				<th>결제방법</th>
				<td>
					<?if ($intSiteSettleC == "Y"){?>
					<input type="checkbox" id="searchSettleC" name="searchSettleC" value="Y" <?=($strSearchSettleC=="Y")?"checked":"";?>>신용카드
					<?}?>
					<?if ($intSiteSettleA == "Y"){?>
					<input type="checkbox" id="searchSettleA" name="searchSettleA" value="Y" <?=($strSearchSettleA=="Y")?"checked":"";?>>계좌이체
					<?}?>
					<?if ($intSiteSettleT == "Y"){?>
					<input type="checkbox" id="searchSettleT" name="searchSettleT" value="Y" <?=($strSearchSettleT=="Y")?"checked":"";?>>가상계좌
					<?}?>
					<?if ($intSiteSettleB == "Y"){?>
					<input type="checkbox" id="searchSettleB" name="searchSettleB" value="Y"<?=($strSearchSettleB=="Y")?"checked":"";?>>무통장입금
					<?}?>
				</td>
			</tr>
			<tr>
				<th>주문상태</th>
				<td>
					<?=drawSelectBoxMore("searchOrderStatus",$S_ARY_SETTLE_STATUS,$strSearchOrderStatus,$design ="defSelect",$onchange="",$etc="",$firstItem="주문상태선택",$html="N")?>
				</td>
			</tr>
			<tr>
				<th></th>
				<td><a class="btn_excel_big" href="javascript:goExcel('excelOrderList');" id="menu_auth_e" style="display:none:"><strong>엑셀 다운로드</strong></a></td>
			</tr>
		</table>
	</div>
	
	<div class="tableList">
		<table style="border-left:1px solid #D2D0D0">
			<colgroup>
				<col width=50/>
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
				<th>선택</th>
				<th>번호</th>
				<th>주문번호</th>
				<th>주문일시</th>
				<th>총 주문금액</th>
				<th>배송비</th>
				<th>주문자</th>
				<th>거래번호</th>
				<th>결제상태</th>
				<th>주문상태</th>
				<th>관리</th>
			</tr>
			<?if ($intTotal == 0){?>
			<tr>
				<td colspan="11">주문된 내역이 없습니다.</td>
			</tr>
			<?}else{
				while($row = mysql_fetch_array($result)){
					$strOrderSettle = $btnOrderCancel = $brnOrderCalOff = $brnOrderAccClear = "";
					if ($row[O_SETTLE] == "C") $strOrderSettle = "신용카드";
					else if ($row[O_SETTLE] == "A") $strOrderSettle = "계좌이체";
					else if ($row[O_SETTLE] == "T") $strOrderSettle = "가상계좌";
					else if ($row[O_SETTLE] == "B") $strOrderSettle = "무통장입금";
					else if ($row[O_SETTLE] == "P") $strOrderSettle = "포인트/쿠폰";
				
					/* 주문취소 버튼은 주문상태가 주문취소,반품완료,환불완료일때는 보이지 않는다 */
					$btnOrderCancel = "";
					if ($row[O_STATUS] != "C" && $row[O_STATUS] != "T" && $row[O_STATUS] != "E")
					{
						$strOrderCancelText = "배송전취소";
						if ($row[O_STATUS] == "B" || $row[O_STATUS] == "I" || $row[O_STATUS] == "D"){
							$strOrderCancelText = "배송후취소";
						} 
						$btnOrderCancel = "<a class=\"btn_sml\" href=\"javascript:goOrderCancel(".$row[O_NO].");\" id=\"menu_auth_e1\" style=\"display:none\"><strong>".$strOrderCancelText."</strong></a>";
					}
					
					$btnOrderCancelOff = "";
					if ($row[O_STATUS] == "C")
					{
						$btnOrderCancelOff = "취소완료";
						if ($row[O_CEL_STATUS] == "N"){
							$btnOrderCancelOff = "<a class=\"btn_sml\" href=\"javascript:goOrderCancelOff(".$row[O_NO].");\"  id=\"menu_auth_e1\" style=\"display:none\"><strong>취소처리중</strong></a>";
						} else if ($row[O_CEL_STATUS] == "P"){
							$btnOrderCancelOff = "<a class=\"btn_sml\" href=\"javascript:goOrderCancel(".$row[O_NO].");\"  id=\"menu_auth_e1\" style=\"display:none\"><strong>구매취소요청</strong></a>";
						}
					}

					/* 결제 상태 */
					$strOrderSettleStatusText = "";
					if ($row[O_STATUS] == "J" || $row[O_STATUS] == "O"){
						$btnOrderSettleStatusUpdate = "<a class=\"btn_sml\" href=\"javascript:goOrderSettleStatusUpdate(".$row[O_NO].");\"><strong>입금확인전</strong></a>";
					} else {
						$btnOrderSettleStatusUpdate = "결제완료";
					}

					/* 주문내역 가지고 오기*/
					$orderMgr->setO_NO($row[O_NO]);
					$orderMgr->setOC_LIST_ARY("Y");
					$aryOrderCartList = $orderMgr->getOrderCartList($db);

				?>
			<tr>
				<td><input type="checkbox" id="chkNo[]" name="chkNo[]" value="<?=$row[O_NO]?>"></td>
				<td><?=$intListNum?></td>
				<td>
					<span><?=$row[O_KEY]?></span>
					<a class="btn_sml" href="javascript:goOrderView('<?=$row[O_NO]?>');"><span>상세보기</span></a>
				</td>
				<td><span class="orderDate">[<?=$row[O_REG_DT]?>]</span></td>
				<td><span>￦</span> <strong><?=NUMBER_FORMAT($row[O_TOT_SPRICE])?></strong></td>
				<td><?=NUMBER_FORMAT($row[O_TOT_DELIVERY_PRICE])?></td>
			
				<td><?=$row[O_J_NAME]?><?=($row[M_NO])? "(".$row[M_ID].")":"";?></td>
				<td><?=$row[O_APPR_NO]?></td>
				<td><?=$btnOrderSettleStatusUpdate?></td>
				<td>
					<?if ($row[O_STATUS] == "C" || $row[O_STATUS] == "R"|| $row[O_STATUS] == "T"){
						echo $S_ARY_SETTLE_STATUS[$row[O_STATUS]];
					}else{?>
					<?=drawSelectBoxMore("orderStatus_".$row[O_NO],$S_ARY_SETTLE_STATUS,$row[O_STATUS],$design ="defSelect",$onchange="",$etc="",$firstItem="",$html="N")?>
					<?}?>
				</td>
				<td rowspan="3" style="text-align:left;">
					<?if (!($row[O_STATUS] == "C" && $row[O_STATUS] == "R" && $row[O_STATUS] == "T")){?>
					<a class="btn_sml" href="javascript:goOrderStatusOneUpdate('<?=$row[O_NO]?>');"><strong>주문상태변경</strong></a>
					<?}?>
					<?if ($row[O_STATUS] == "A" || $row[O_STATUS] == "B" || $row[O_STATUS] == "I" || $row[O_STATUS] == "D"){?>
						<a class="btn_sml" href="javascript:goOrderDeliveryUpdate('<?=$row[O_NO]?>');" id="menu_auth_e2" style="display:none"><strong>배송정보</strong></a>
					<?}?>
					<?=$btnOrderCancel?>
					<?=$btnOrderCancelOff?>
					<a class="btn_sml" href="javascript:goOrderDelete('<?=$row[O_NO]?>');" id="menu_auth_e2" style="display:none"><strong>삭제</strong></a>
				</td>
			</tr>
			<tr>
				<td colspan="2">결제</td>
				<td colspan="8" style="text-align:left;line-height:18px">
					<strong><?=$strOrderSettle?></strong> 
					<span class="txtRedPrice">￦</span> <strong class="txtRedPrice"><?=getCurToPrice($row[O_TOT_SPRICE],$row[O_USE_LNG])?></strong>
					(총 상품금액 : <?=NUMBER_FORMAT($row[O_TOT_PRICE])?> 
					<?if ($row[O_TAX_PRICE] > 0){?>
					+ 부과세 : <?=NUMBER_FORMAT($row[O_TAX_PRICE])?>
					<?}?>
					<?if ($row[O_TOT_DELIVERY_PRICE] > 0){?>
					+ 배송비 : <?=NUMBER_FORMAT($row[O_TOT_DELIVERY_PRICE])?>
					<?}?>
					<?if ($row[O_USE_POINT] > 0){?>
					- 사용포인트 : <?=NUMBER_FORMAT($row[O_USE_POINT])?>
					<?}?>
					)
					<br/>
					<?if ($row[O_SETTLE] == "B"){?> 
					입금계좌 : <?=$row[O_BANK_ACC]?> 입금자명 : <?=$row[O_BANK_NAME]?>
					<?}?>
					<?if ($row[O_SETTLE] == "T"){?>
					입금계좌 : <?=$aryTBank[$row[O_BANK]]?> <?=$row[O_BANK_ACC]?>
					입금마감시간 : <?=SUBSTR($row[O_BANK_VALID_DT],0,4)?>년 <?=SUBSTR($row[O_BANK_VALID_DT],4,2)?>월 <?=SUBSTR($row[O_BANK_VALID_DT],6,2)?>일
					<?}?>
				</td>
			</tr>
			<tr>
				<td colspan="2">수령인</td>
				<td colspan="8" style="text-align:left;"><?=$row[O_B_NAME]?> <?=$row[O_B_ADDR1]?> <?=$row[O_B_ADDR2]?></td>
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
									<th colspan="2">주문상품</th>
									<th>수량</th>
									<th>판매가</th>
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
												<li>추가선택 : <?=$aryProdCartAddOptList[$k][OCA_OPT_NM]?></li>
											<?}}?>
										</ul>
										<div class="clr"></div>
									</td>
									<td><?=$aryOrderCartList[$i][OC_QTY]?></td>
									<td><?=NUMBER_FORMAT($aryOrderCartList[$i][OC_PRICE])?></td>
								</tr>
								<?}}?>
							</table>
						</div>
					<!-- 상품목록 -->
				</td>
			</tr>
			<tr>
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
	<div style="text-align:left;margin-top:3px;">
		* 선택하신 주문정보를 모두 [결제완료]로 <a class="btn_big" href="javascript:goOrderSettleStatusUpdate(0);"><strong>변경</strong></a>(주문상태가 [주문완료]일때만 변경됨)
		* 선택하신 주문정보를 모두 
			<select id="orderStatus" name="orderStatus">
				<option value="">:::선택:::</option>
				<option value="B">배송준비중</option>
				<option value="I">배송중</option>
				<option value="D">배송완료</option>
				<option value="E">구매완료</option>
				<option value="C">주문취소</option>
				<option value="R">반품완료</option>
				<option value="T">환불완료</option>
			</select>로 <a class="btn_big" href="javascript:goOrderStatusUpdate();"><strong>변경</strong></a>
	</div>
</div>
