<!-- <?php echo realpath(__FILE__);?> -->
	<div class="tableListWrap">
		<table class="tableList">
			<colgroup>
				<col width=50/>
				<col width=50/>
				<col width=150/>
				<col width=120/>
				<col width=100/>
				<col />
				<col />
				<col width=100/>
				<col width=120/>
				<col width=100/>
			</colgroup>
			<tr>
				<th><input type="checkbox" name="chkAll" value="Y" onclick="javascript:C_getCheckAll(this.checked)"/></th>
				<th><?=$LNG_TRANS_CHAR["CW00009"] //번호?></th>
				<th><?=$LNG_TRANS_CHAR["OW00002"] //주문번호?></th>
				<th><?=$LNG_TRANS_CHAR["OW00003"] //주문자?></th>
				<th><?="결제방법" //결제방법?></th>
				<th><?=$LNG_TRANS_CHAR["OW00075"] //총주문금액?></th>
				<th><?=$LNG_TRANS_CHAR["OW00061"] //총배송비?></th>
				<th><?=$LNG_TRANS_CHAR["OW00009"] //거래번호?></th>
				<th><?="주문상태" //주문상태?></th>
				<th><?=$LNG_TRANS_CHAR["CW00007"] //관리?></th>
			</tr>
			<?if ($intTotal == 0){?>
			<tr>
				<td colspan="10"><?=$LNG_TRANS_CHAR["CS00001"]?></td>
			</tr>
			<?}else{
				while($row = mysql_fetch_array($orderListResult)){

					$strOrderSettle = $btnOrderCancel = $strOrdreMemberId = "";
					if ($row['O_SETTLE'] == "C") $strOrderSettle = $S_ARY_SETTLE_TYPE["C"]; //"신용카드";
					else if ($row['O_SETTLE'] == "A") $strOrderSettle = $S_ARY_SETTLE_TYPE["A"]; //"계좌이체";
					else if ($row['O_SETTLE'] == "T") $strOrderSettle = $S_ARY_SETTLE_TYPE["T"]; //"가상계좌";
					else if ($row['O_SETTLE'] == "B") $strOrderSettle = $S_ARY_SETTLE_TYPE["B"]; //"무통장입금";
					else if ($row['O_SETTLE'] == "P") $strOrderSettle = $S_ARY_SETTLE_TYPE["P"]; //"포인트/쿠폰";
					else if ($row['O_SETTLE'] == "Y") $strOrderSettle = $S_ARY_SETTLE_TYPE["Y"]; //"페이팔";
					else if ($row['O_SETTLE'] == "X") $strOrderSettle = $S_ARY_SETTLE_TYPE["X"]; //"EXIMBAY";

					/* 주문취소 버튼은 주문상태가 주문취소,반품완료,환불완료일때는 보이지 않는다 */
					$btnOrderCancel = "";
					if (!in_array($row['O_STATUS'],array("C","R","T","S","E")))
					{
						$strOrderCancelText = $LNG_TRANS_CHAR["OW00041"]; //"배송전취소";
						if (in_array($row['O_STATUS'],array("B","I","D"))){
							$strOrderCancelText = $LNG_TRANS_CHAR["OW00042"]; //"배송후취소";
						}
						$btnOrderCancel = "<a class=\"btn_sml\" href=\"javascript:goOrderCancel(".$row[O_NO].");\" id=\"menu_auth_e1\" style=\"display:none\"><strong>".$strOrderCancelText."</strong></a>";
					}

					$btnOrderCancelOff = "";
					if ($row['O_STATUS'] == "C")
					{
						$btnOrderCancelOff = "<a class=\"btn_sml\" href=\"javascript:goOrderCancelOff(".$row[O_NO].",'".$row[O_PG]."');\"  id=\"menu_auth_e1\" style=\"display:none\"><strong>".$LNG_TRANS_CHAR["OW00076"]."</strong></a>"; //취소완료
						if ($row['O_CEL_STATUS'] == "N"){
							$btnOrderCancelOff = "<a class=\"btn_sml\" href=\"javascript:goOrderCancelOff(".$row[O_NO].",'".$row[O_PG]."');\"  id=\"menu_auth_e1\" style=\"display:none\"><strong>".$LNG_TRANS_CHAR["OW00077"]."</strong></a>"; //취소처리중
						} else if ($row['O_CEL_STATUS'] == "P"){
							$btnOrderCancelOff = "<a class=\"btn_sml\" href=\"javascript:goOrderCancel(".$row[O_NO].");\"  id=\"menu_auth_e1\" style=\"display:none\"><strong>".$LNG_TRANS_CHAR["OW00078"]."</strong></a>"; //구매취소요청
						}
					}

					/* 주문/결제 상태 */
					$btnOrderSettleStatusUpdate = "";
					if ($row[O_STATUS] == "J" || $row[O_STATUS] == "O"){
						if ($row['O_SETTLE'] != "T") $btnOrderSettleStatusUpdate = "<a class=\"btn_sml\" href=\"javascript:goOrderSettleStatusUpdate(".$row[O_NO].");\"><strong>".$LNG_TRANS_CHAR["OW00079"]."</strong></a>"; //입금확인전
						else $btnOrderSettleStatusUpdate = "<strong>".$LNG_TRANS_CHAR["OW00079"]."</strong>";
					} else {
						$btnOrderSettleStatusUpdate = $S_ARY_SETTLE_STATUS[$row[O_STATUS]];

					}

					/* 주문자 아이디 */
					$strOrderMemberId = "";
					if ($S_MEM_CERITY == "1") {
						if ($row['M_NO'] > 0){
							$strOrderMemberId  = "<li>(";
							if ($row['M_ID']) $strOrderMemberId .= $row['M_ID']."/";
							if ($row['M_NAME']) $strOrderMemberId .= $row['M_NAME'];
							$strOrderMemberId .= ")</li>";
						}
					}

					/* 주문자 CRM 연결 */
					$btnOrderMemberCrmLink = "";
					if ($a_admin_type == "A" && $row['M_NO'] > 0){
						$btnOrderMemberCrmLink = "<li><a class=\"btn_sml\" href=\"javascript:goMemberCrmView('".$row['M_NO']."');\" id=\"menu_auth_m\" style=\"display: inline-block;\"><strong>CRM</strong></a></li>";
					}

					/* 주문내역 정보 가지고 오기*/
					$strDeliveyState	= $row[O_B_STATE];
					if ($row[O_B_COUNTRY] == "US") $strDeliveyState = $aryCountryList[$row[O_B_STATE]];

					if ($row['O_USE_LNG'] == "KR"){
						if ($row['O_PG'] == "K" && $row['O_SETTLE'] == "T"){
							$strReturnBankName = $aryTBank[$row['O_BANK']];
						}

						if ($row['O_PG'] == "A" && $row['O_SETTLE'] == "T"){
							$strReturnBankName = $S_ARY_RETURN_BANK[$row['O_BANK']];
						}
					}

					/* 회원 소속 */
					$strMemberCateList = $strMemberCateName_1 = $strMemberCateName_2 = $strMemberCateName_3 = "";
					if ($S_FIX_MEMBER_CATE_USE_YN  == "Y")
					{
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

								$strMemberCateList .= $strMemberCateName_1;
								$strMemberCateList .= ($strMemberCateName_2)? " > {$strMemberCateName_2}":"";
								$strMemberCateList .= ($strMemberCateName_3)? " > {$strMemberCateName_3}":"";
								$strMemberCateList .= " / ";
							}

							if ($strMemberCateList) $strMemberCateList = substr($strMemberCateList,0,strlen($strMemberCateList)-3);
						}
					}
					/* 회원 소속 */

					/* 주문 입점사별 리스트 */
					$param				= "";
					$param['O_NO']		= $row['O_NO'];
					$param["O_USE_LNG"] = $S_SITE_LNG;

					if ($S_MALL_TYPE != "R"){
						## 주문 입점사별 정보
						$param['O_SHOP_NO']	= "-1";

						if ($_REQUEST['searchShop'] && $_REQUEST['searchShop'] != "undefined"){
							$param['O_SHOP_NO'] = $_REQUEST['searchShop'];
						}

						## 영업사용/관리 입점몰 사용여부
						if ($ADMIN_SHOP_SELECT_USE == "Y")
						{
							if ($a_admin_tm == "Y" && $a_admin_shop_list) {
								/* 영업사원이며 tm 입점사관리 기능이 있을 경우 */
								$param['O_SHOP_NO'] = $a_admin_shop_list;
							}
						}
						$aryOrderCartShopList	= $shopOrderMgr->getOrderCartShopInfo($db,$param);
					}

					/* 사은품 내역 가지고 오기*/
					$aryOrderGiftList = $shopOrderMgr->getOrderGiftList($db,$param);

					/* 해당 주문 상품 정보 가지고 오기 */
					$aryOrderCartList = $shopOrderMgr->getOrderCartList($db,"OP_ARYTOTAL",$param);



			?>
			<tr>
				<td><input type="checkbox" id="chkNo[]" name="chkNo[]" value="<?=$row[O_NO]?>"></td>
				<td><?=$intListNum?></td>
				<td>
					<span><?=$row[O_KEY]?></span>
					<span class="orderDate">[<?=$row[O_REG_DT]?>]</span>
					<a class="btn_sml" href="javascript:goOrderView('<?=$row[O_NO]?>');"><span><?=$LNG_TRANS_CHAR["OW00012"] //상세보기?></span></a>
					<a class="<?=($row['MEMO_CNT']) ? "btn_blue_sml":"btn_sml";?>" href="javascript:goOrderMemoListEvent('<?=$row['O_NO']?>');"><strong>메모<?=($row['MEMO_CNT']) ? "({$row['MEMO_CNT']})":"";?></strong></a>

				</td>
				<td>
					<ul>
						<li><?=$row[O_J_NAME]?></li>
						<?=$strOrderMemberId?>
						<?=$btnOrderMemberCrmLink?>
					</ul>
				</td>
				<td>
					<ul>
						<li><?=$strOrderSettle?></li>
						<?=($row['O_APPR_DT']) ? "<li>({$row['O_APPR_DT']})</li>" : "";?>
					</ul>
				</td>
				<td><span><?=getCurMark($S_ST_CUR)?></span> <strong><?=getFormatPrice($row[O_TOT_CUR_SPRICE],2)?><?=getCurMark2($S_ST_CUR)?></strong></td>
				<td><?=getCurMark($S_ST_CUR)?> <?=getFormatPrice($row[O_TOT_DELIVERY_CUR_PRICE],2)?><?=getCurMark2($S_ST_CUR)?></td>
				<td>
					<?=$row[O_APPR_NO]?>
				</td>

				<td>
					<?=$btnOrderSettleStatusUpdate?>
				</td>
				<td>

					<?=$btnOrderCancel?>
					<?=$btnOrderCancelOff?>
					<?if ($row['O_USE_LNG'] == "KR"){?>
					<?if (!in_array($row["O_STATUS"],array("C"))){?>
						<a class="btn_sml" href="javascript:goOrderPartCancel('<?=$row['O_NO']?>');"><strong>부분취소</strong></a>
					<?}?>
					<a class="btn_sml" href="javascript:goOrderHistory('<?=$row['O_NO']?>');"><strong>내역관리</strong></a>
					<?}?>
					<?if ($row["O_USE_LNG"] != "KR" && ($row['O_STATUS'] == "A" || $row['O_STATUS'] == "B" || $row['O_STATUS'] == "I" || $row['O_STATUS'] == "D")){?>
						<!--<a class="btn_sml" href="javascript:goOrderDeliveryUpdate('<?=$row[O_NO]?>');" id="menu_auth_e2" style="display:none"><strong>해외배송정보</strong></a>//-->
					<?}?>
					<a class="btn_sml" href="javascript:goOrderDelete('<?=$row['O_NO']?>');" id="menu_auth_d" style="display:none"><strong>삭제</strong></a>

				</td>
			</tr>
			<tr>
				<td colspan="2"><?="결제정보" //결제정보?></td>
				<td colspan="8" style="text-align:left;line-height:18px">
					<strong><?=$strOrderSettle?></strong>
					<span class="txtRedPrice"><?=getCurMark($S_ST_CUR)?></span> <strong class="txtRedPrice"><?=getFormatPrice($row[O_TOT_CUR_SPRICE],2)?><?=getCurMark2($S_ST_CUR)?></strong>
					(<?=$LNG_TRANS_CHAR["OW00083"] //총 상품금액?> : <?=getCurMark($S_ST_CUR)?> <?=getFormatPrice($row[O_TOT_CUR_PRICE],2)?><?=getCurMark2($S_ST_CUR)?>
					<?if ($row[O_TAX_PRICE] > 0){?>
					+ <?=$LNG_TRANS_CHAR["OW00084"] //부과세?> : <?=getCurMark($S_ST_CUR)?> <?=getFormatPrice($row[O_TAX_CUR_PRICE],2)?><?=getCurMark2($S_ST_CUR)?>
					<?}?>

					<?if ($row[O_TOT_PG_COMMISSION] > 0){?>
					+ <?=$LNG_TRANS_CHAR["OW00157"] //수수료?> : <?=getCurMark($S_ST_CUR)?> <?=getFormatPrice($row[O_TOT_PG_CUR_COMMISSION],2)?><?=getCurMark2($S_ST_CUR)?>
					<?}?>

					<?if ($row[O_TOT_DELIVERY_PRICE] > 0){?>
					+ <?=$LNG_TRANS_CHAR["OW00027"] //배송비?> : <?=getCurMark($S_ST_CUR)?> <?=getFormatPrice($row[O_TOT_DELIVERY_CUR_PRICE],2)?><?=getCurMark2($S_ST_CUR)?>
					<?}?>
					<?if ($row[O_TOT_MEM_DISCOUNT_PRICE] > 0){?>
					- <?=$LNG_TRANS_CHAR["OW00115"] //추가할인금액?> : <?=getCurMark($S_ST_CUR)?> <?=getFormatPrice($row[O_TOT_MEM_DISCOUNT_CUR_PRICE],2)?><?=getCurMark2($S_ST_CUR)?></strong>
					<?}?>

					<?if ($row[O_USE_POINT] > 0){?>
					- <?=$LNG_TRANS_CHAR["OW00028"] //사용포인트?> : <?=getFormatPrice($row[O_USE_CUR_POINT],2)?>
					<?}?>
					<?if ($row[O_USE_COUPON] > 0){?>
					- <?=$LNG_TRANS_CHAR["OW00028"] //사용쿠폰?> : <?=getFormatPrice($row[O_USE_CUR_COUPON],2)?>
					<?}?>
					)
					<?if ($row[O_SETTLE] == "B"){?>
					<br/><?=$LNG_TRANS_CHAR["OW00085"] //입금계좌?> : <?=$row[O_BANK_ACC]?> <?=$LNG_TRANS_CHAR["OW00086"] //입금자명?> : <?=$row[O_BANK_NAME]?>
					<?}?>
					<?if ($row[O_SETTLE] == "T"){?>
					<br/><?=$LNG_TRANS_CHAR["OW00085"] //입금계좌?> : <?=$strReturnBankName?> <?=$row[O_BANK_ACC]?>
					<?=$LNG_TRANS_CHAR["OW00087"] //입금마감시간?> : <?=date("Y-m-d", strtotime($row['O_BANK_VALID_DT']))?>
					<?}?>
					<?
					if ($row['O_CASH_YN'] == "Y"){
						echo "현금영수증 : ".$row['O_CASH_INFO'];
						if ($row['O_CASH_AUTH_NO']) echo "(".$row['O_CASH_AUTH_NO'].")";
					}
					?>
				</td>
			</tr>
			<tr>
				<td colspan="2"><?=$LNG_TRANS_CHAR["OW00134"] //주문정보?></td>
				<td colspan="8" style="text-align:left;">
					<ul>
						<li>
							<?=$LNG_TRANS_CHAR["OW00030"]//주문자정보?> : <?=$row[O_J_MAIL]?>,<?=$row[O_J_HP]?> <?=(STRPOS($row[O_J_PHONE],"-") > 0) ? ",".$row[O_J_PHONE]:"";?>
							<?if ($strMemberCateList){?>(소속 : <?=$strMemberCateList?>)<?}?>
						</li>
						<li>
							<?=$LNG_TRANS_CHAR["OW00034"]//배송지정보?> : [<?=$row[O_B_NAME]?>] [<?=$row[O_B_ZIP]?>] <?=$row[O_B_ADDR1]?> <?=$row[O_B_ADDR2]?> <?=$row[O_B_CITY]?> <?=$strDeliveyState?> <?=$aryCountryList[$row[O_B_COUNTRY]]?>
							<a class="btn_sml" href="javascript:goOrderDeliveryAddr('<?=$row['O_NO']?>');"><strong>배송정보수정</strong></a>
							<a class="btn_sml" href="javascript:goOrderInfoListDisplay(<?=$row['O_NO']?>);"><span id="btnOrderDisplay_<?=$row['O_NO']?>"?><?=($_COOKIE["COOKIE_ADM_ORDER_LIST_DISPLAY"]=="block") ? "상품정보닫기": "상품정보열기";?></span></a>
						</li>

					</ul>
				</td>
			</tr>
			<tr>
				<td colspan="10" style="padding:0px;border-bottom:1px solid #5a5a5a;">
					<!-- 상품목록 -->
						<div class="orderInfoList" <?=($_COOKIE["COOKIE_ADM_ORDER_LIST_DISPLAY"]=="block") ? "": "style=\"display:none\"";?> id="divOrderInfo_<?=$row['O_NO']?>">
							<table>
								<colgroup>
									<?if ($S_MALL_TYPE != "R"){?>
									<col style="width:100px;"/>
									<?}?>
									<col style="width:50px;"/>
									<col />
									<col style="width:80px;"/>
									<col style="width:130px;"/>
									<col style="width:130px;"/>
									<col style="width:250px;"/>
									<col style="width:150px;"/>
								</colgroup>
								<tr>
									<?if ($S_MALL_TYPE != "R"){?>
									<th><?=$LNG_TRANS_CHAR["SW00080"] //입점사?></th>
									<?}?>
									<th colspan="2"><?=$LNG_TRANS_CHAR["OW00022"] //주문상품?></th>
									<th><?=$LNG_TRANS_CHAR["OW00025"] //수량?></th>
									<th><?=$LNG_TRANS_CHAR["OW00089"] //판매가?></th>
									<th><?="배송비" //배송비?></th>
									<th><?=$LNG_TRANS_CHAR["OW00044"] //배송정보?></th>
									<th><?="구매상태" //구매상태?></th>
									<?if ($S_MALL_TYPE != "R"){?>
									<th><?="총배송비" //총배송비?></th>
									<?}?>
								</tr>
							<?

								if (is_array($aryOrderCartList)){
									$intCartShopNo = "";
									for($i=0;$i<sizeof($aryOrderCartList);$i++){
										## 추가상품정보
										$aryProdCartAddOptList = "";
										if ($aryOrderCartList[$i]["OC_OPT_ADD_CUR_PRICE"] >= 0)
										{
											$param				= "";
											$param['OC_NO']		= $aryOrderCartList[$i]["OC_NO"];
											$aryProdCartAddOptList = $shopOrderMgr->getOrderCartAddList($db,"OP_ARYTOTAL",$param);
										}

										## 상품옵션정보
										$strCartOptAttrVal = "";
										for($kk=1;$kk<=10;$kk++){
											if ($aryOrderCartList[$i]["OC_OPT_ATTR".$kk]){
												$strCartOptAttrVal .= "/".$aryOrderCartList[$i]["OC_OPT_ATTR".$kk];
											}
										}
										$strCartOptAttrVal = SUBSTR($strCartOptAttrVal,1);

										## 상품배송정보
										$strCartDeliveryTypeName = "";
										switch($aryOrderCartList[$i]['OC_P_BAESONG_TYPE']){
											case "1":
												$strCartDeliveryTypeName	= "기본배송";
											break;
											case "2":
												$strCartDeliveryTypeName	= "무료배송";
											break;
											case "3":
												$strCartDeliveryTypeName	= "고정배송비";
												$strCartDeliveryTypeName   .= "(".getCurMark($S_ST_CUR).getFormatPrice($aryOrderCartList[$i]['OC_DELIVERY_CUR_PRICE'],2).getCurMark2($S_ST_CUR).")";
											break;
											case "4":
												$strCartDeliveryTypeName	= "수량별배송";
											break;
											case "5":
												$strCartDeliveryTypeName	 = "착불";
												$strCartDeliveryTypeName	.= "(".getCurMark($S_ST_CUR).getFormatPrice($aryOrderCartList[$i]['OC_DELIVERY_CUR_PRICE'],2).getCurMark2($S_ST_CUR).")";
											break;
										}

										## 배송비지불방법
										$strCartDeliveryPayMthName	= "";
										if ($aryOrderCartList[$i]['OC_DELIVERY_TYPE'] == "1") $strCartDeliveryPayMthName = "(주문시결제)";
										else if ($aryOrderCartList[$i]['OC_DELIVERY_TYPE'] == "2") $strCartDeliveryPayMthName = "(착불)";

										if ($S_MALL_TYPE != "R"){
											$intCartRowSpan = 0;
											if (($intCartShopNo != "0" && !$intCartShopNo) || ($intCartShopNo != $aryOrderCartList[$i]['P_SHOP_NO'])) {
												$intCartShopNo	= ($aryOrderCartList[$i][P_SHOP_NO])?$aryOrderCartList[$i][P_SHOP_NO]:"0";
												$intCartRowSpan = $aryOrderCartShopList[$intCartShopNo][CART_CNT];
											}else {
												$intCartRowSpan = 0;
											}

											if($aryOrderCartShopList[$intCartShopNo]['SH_COM_DELIVERY_COR'])
											{
												$temp							= explode(",", $aryOrderCartShopList[$intCartShopNo]['SH_COM_DELIVERY_COR']);
												$aryDeliveryCom					= "";
												foreach($temp as $key):
													$aryDeliveryCom[$key]		= $aryDeliveryComAll[$key];
												endforeach;
											}
										}

										## 배송 조회
										$strCartDeliveryComUrl= "";
										if($aryOrderCartList[$i]['OC_DELIVERY_COM'] && $aryOrderCartList[$i]['OC_DELIVERY_NUM']):
											$strCartDeliveryComUrl		= $aryDeliveryUrl[$aryOrderCartList[$i]['OC_DELIVERY_COM']];
											$strCartDeliveryComUrl		= str_replace("{dev_no}", $aryOrderCartList[$i]['OC_DELIVERY_NUM'], $strCartDeliveryComUrl);
										endif;
										?>
								<tr>
									<?
										if ($S_MALL_TYPE != "R" && $intCartRowSpan>=1)
										{
									?>
									<td <?=($intCartRowSpan>=1)?"rowspan=\"$intCartRowSpan\"":"";?>>
										<?=$aryOrderCartShopList[$intCartShopNo]['ST_NAME']?>
									</td>
									<?
										}
									?>
									<td alt="상품이미지" style="text-align:left;">
										<img src="<?=$aryOrderCartList[$i]['PM_REAL_NAME']?>" style="width:50px;height:50px">
									</td>
									<td alt="상품정보" style="text-align:left;">
										<ul>
											<li><?=$aryOrderCartList[$i]['OC_P_NAME']?></li>
											<li><?=$strCartOptAttrVal?></li>
											<?if (is_array($aryProdCartAddOptList)){
												for($k=0;$k<sizeof($aryProdCartAddOptList);$k++){
												?>
												<li><?=$LNG_TRANS_CHAR["OW00046"] //추가선택?> : <?=$aryProdCartAddOptList[$k][OCA_OPT_NM]?> * <?=$aryProdCartAddOptList[$k][OCA_OPT_QTY]?></li>
											<?}}?>
											<li><span><?=$LNG_TRANS_CHAR["PW00176"] //상품번호?>:<?=$aryOrderCartList[$i]['P_CODE']?></li>
										</ul>
										<div class="clr"></div>
									</td>
									<td>
										<?=$aryOrderCartList[$i]['OC_QTY']?>
									</td>
									<td>
										<?=getCurMark($S_ST_CUR)?> <?=getFormatPrice($aryOrderCartList[$i]['OC_CUR_PRICE'],2)?><?=getCurMark2($S_ST_CUR)?>

										<?if ($aryOrderCartList[$i][OC_OPT_ADD_PRICE] > 0){?><?=$LNG_TRANS_CHAR["OW00024"] //추가금액?>:<?=getCurMark($S_ST_CUR)?>  <?=getFormatPrice($aryOrderCartList[$i][OC_OPT_ADD_CUR_PRICE],2)?><?=getCurMark2($S_ST_CUR)?><?}?>

									</td>
									<td>
										<?=$strCartDeliveryTypeName . $strCartDeliveryPayMthName?>
									</td>
									<td>
										<?if ($S_MALL_TYPE == "R"){?>
											<?if ($i == 0){?>
											<a class="btn_sml" href="javascript:goOrderCartDeliveryUpdate(<?=$row['O_NO']?>,0,0);"><strong><?="전체배송정보변경" //전체배송정보변경?></strong></a>
											<?}?>
										<?}else{
											if ($intCartRowSpan >= 1 && $aryOrderCartShopList[$intCartShopNo]['CART_CNT'] > 1){
											?>
											<a class="btn_sml" href="javascript:goOrderCartDeliveryUpdate(<?=$row['O_NO']?>,0,<?=$intCartShopNo?>);"><strong><?="전체배송정보변경" //전체배송정보변경?></strong></a>
											<?}?>
										<?}?>
										<ul id="order_cart_delivery_<?=$row['O_NO']?>_<?=$aryOrderCartList[$i]['OC_NO']?>">
											<li>
												<select id="cartDeliveryStatus" default="<?=$aryOrderCartList[$i]['OC_DELIVERY_STATUS']?>">
													<option value="">배송상태</option>
													<?foreach($S_ARY_DELIVERY_STATUS as $key => $value):?>
													<option value="<?=$key?>"<?if($aryOrderCartList[$i]['OC_DELIVERY_STATUS'] == $key){echo " selected";}?>><?=$value?></option>
													<?endforeach;?>
												</select>
												<select id="cartDeliveryCom" style="width:120px">
													<option value=""><?=$LNG_TRANS_CHAR["OW00053"]//배송회사?></option>
													<?foreach($aryDeliveryCom as $key => $value):?>
													<option value="<?=$key?>"<?if(trim($aryOrderCartList[$i]['OC_DELIVERY_COM']) == $key){echo " selected";}?>><?=$value?></option>
													<?endforeach;?>
												</select>
											</li>
											<li>
												<input type="text" id="cartDeliveryNum" value="<?=$aryOrderCartList[$i]['OC_DELIVERY_NUM']?>" class="deliveryNoForm">
												<?if ($aryOrderCartList[$i]['OC_DELIVERY_COM'] && $aryOrderCartList[$i]['OC_DELIVERY_NUM']){?>
												 <a class="btn_sml" href="<?=$strCartDeliveryComUrl?>" target="_blank"><strong>배송추적</strong></a>
												<?}?>
											</li>
											<li>
												<a class="btn_sml" id="btnCartDeliverySave" href="javascript:goOrderCartDeliveryUpdate(<?=$row['O_NO']?>,'<?=$aryOrderCartList[$i]['OC_NO']?>','<?=$aryOrderCartList[$i]['P_SHOP_NO']?>');" <?=(SUBSTR($aryOrderCartList[$i]['OC_ORDER_STATUS'],0,1) == "C")?"disabled":"";?>><strong><?="개별배송정보변경" //개별배송정보변경?></strong></a>
											</li>
											<?if ($aryOrderCartList[$i]['OC_DELIVERY_ST_DT']){?>
											<li>배송시작일:<?=$aryOrderCartList[$i]['OC_DELIVERY_ST_DT']?></li>
											<?}?>
											<?if ($aryOrderCartList[$i]['OC_DELIVERY_END_DT']){?>
											<li>배송완료일:<?=$aryOrderCartList[$i]['OC_DELIVERY_END_DT']?></li>
											<?}?>
										</ul>
									</td>
									<td>
										<div id="order_cart_order_<?=$aryOrderCartList[$i]['OC_NO']?>">
											<ul>
												<li>
													<select id="cartOrderStatus" default="<?=$aryOrderCartList[$i]['OC_ORDER_STATUS']?>">
														<option value="">선택</option>
														<option value="E" <?if($aryOrderCartList[$i]['OC_ORDER_STATUS']=="E"){echo "selected";}?>><?=$LNG_TRANS_CHAR["OW00139"] //구매완료?></option>
														<?foreach($S_ARY_SETTLE_ORDER_STATUS as $key => $value):?>
														<option value="<?=$key?>"<?if($aryOrderCartList[$i]['OC_ORDER_STATUS']==$key){echo " selected";}?>><?=$value?></option>
														<?endforeach;?>
													</select>
												</li>

												<li>
													<a class="btn_sml" href="javascript:goOrderStatusUpdate('<?=$aryOrderCartList[$i]['OC_NO']?>');"><strong><?="구매상태변경" //구매상태변경?></strong></a>
												</li>
												<?
													if (SUBSTR($aryOrderCartList[$i]['OC_ORDER_STATUS'],0,1) == "C")
													{
														if ($aryOrderCartList[$i]['OC_C_REQ_DT']){
															echo "<li>".$LNG_TRANS_CHAR["OW00140"].":".$aryOrderCartList[$i]['OC_C_REQ_DT']."</li>"; //취소신청일
														}
														if ($aryOrderCartList[$i]['OC_C_REG_DT']){
															echo "<li>".$LNG_TRANS_CHAR["OW00141"].":".$aryOrderCartList[$i]['OC_C_REG_DT']."</li>"; //취소완료일
														}
													}
												?>
												<?if ($aryOrderCartList[$i]['OC_E_REG_DT']){?>
												<li>구매확정일자<?=$aryOrderCartList[$i]['OC_E_REG_DT']?></li>
												<?}?>
											</ul>
										</div>
									</td>
									<?
										if ($S_MALL_TYPE != "R" && $intCartRowSpan>=1)
										{
									?>
									<td <?=($intCartRowSpan>=1)?"rowspan=\"$intCartRowSpan\"":"";?>>
										<?=getCurMark($S_ST_CUR)?> <?=getFormatPrice($aryOrderCartShopList[$intCartShopNo]['SO_TOT_DELIVERY_CUR_PRICE'],2)?><?=getCurMark2($S_ST_CUR)?>
									</td>
									<?
										}
									?>

								</tr>
										<?
									}

								}
							?>
								<!-- 주문 사은품 시작 //-->
								<?if (is_array($aryOrderGiftList)){?>
								<?	for($j=0;$j<sizeof($aryOrderGiftList);$j++){?>
								<tr>
									<?if ($S_MALL_TYPE != "R"){?>
									<td></td>
									<?}?>
									<td>
										<img src="<?=$aryOrderGiftList[$j][CG_FILE]?>" style="width:50px;"/>
									</td>
									<td style="text-align:left;border-left:none;">
										<ul>
											<li><?=$aryOrderGiftList[$j][CG_NAME]?></li>
											<li><?=$aryOrderGiftList[$j][OG_OPT]?></li>
										</ul>
										<div class="clr"></div>
									</td>
									<td><?=$aryOrderGiftList[$j][OG_QTY]?></td>
									<td></td>
									<td></td>
									<td></td>
									<td></td>
								</tr>
								<?	}}?>
								<!-- 주문 사은품 종료 //-->
							</table>
						</div>
					<!-- 상품목록 -->
				</td>
			</tr>
			<tr class="blankTr">
				<td colspan="10"></td>
			</tr>
			<?
					$intListNum--;
				}
			}
			?>
		</table>
	</div>