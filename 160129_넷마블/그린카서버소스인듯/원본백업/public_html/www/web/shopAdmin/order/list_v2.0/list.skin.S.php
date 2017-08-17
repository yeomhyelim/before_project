<!-- <?php echo realpath(__FILE__);?> -->
	<div class="tableList">
		<table style="border-left:1px solid #D2D0D0">
			<colgroup>
				<col width=50/>
				<col width=50/>
				<col width=150/>
				<col width=100/>
				<col width=80/>
				<col width=50/>
				<col />
				<col width=80/>
				<col width=120/>
				<col width=100/>
				<col width=150/>
				<col width=120/>
				<col width=100/>
			</colgroup>
			<tr>
				<th><input type="checkbox" name="chkAll" value="Y" onclick="javascript:C_getCheckAll(this.checked)"/></th>
				<th><?=$LNG_TRANS_CHAR["CW00009"] //번호?></th>
				<th><?=$LNG_TRANS_CHAR["OW00002"] //주문번호?></th>
				<th><?=$LNG_TRANS_CHAR["OW00003"] //주문자?></th>
				<th><?= $LNG_TRANS_CHAR["MW00171"]; //주문상태?></th>
				<th colspan="2"><?= $LNG_TRANS_CHAR["OW00022"]; //상품정보 ?></th>
				<th><?= $LNG_TRANS_CHAR["OW00025"]; //수량 ?></th>
				<th><?= $LNG_TRANS_CHAR["OW00089"]; //판매가 ?></th>
				<th><?= $LNG_TRANS_CHAR["PW00064"]; //배송비 ?></th>
				<th><?= $LNG_TRANS_CHAR["OW00044"]; //배송정보 ?></th>
				<th><?= $LNG_TRANS_CHAR["SW00075"]; //배송상태 ?></th>
				<th><?= $LNG_TRANS_CHAR["OW00061"]; //총배송비 ?></th>
			</tr>
			<?if ($intTotal == 0){?>
			<tr>
				<td colspan="13"><?=$LNG_TRANS_CHAR["CS00001"]?></td>
			</tr>
			<?}else{
				while($row = mysql_fetch_array($orderListResult)){

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

					/* 결제 상태 */
					$strOrderSettleStatusText = "";
					if ($row[O_STATUS] == "J" || $row[O_STATUS] == "O"){
						$strOrderSettleStatusText = "<strong>".$LNG_TRANS_CHAR["OW00079"]."</strong>"; //입금확인전
					} else {
						if (in_array($row[O_STATUS],array("A","B","I","D"))){
							$strOrderSettleStatusText	= $LNG_TRANS_CHAR["OW00080"]; //"결제완료";
						} else if (in_array($row[O_STATUS],array("E","C","S","R","T"))){
							$strOrderSettleStatusText	= $S_ARY_SHOP_ORDER_STATUS[$row[O_STATUS]];
						}
					}

					/* 주문 입점사별 리스트 */
					$param					= "";
					$param['O_NO']			= $row['O_NO'];
					$param["O_USE_LNG"]		= $S_SITE_LNG;
					$param['O_SHOP_NO']		= $a_admin_shop_no;
					$aryOrderCartShopList	= $shopOrderMgr->getOrderCartShopInfo($db,$param);

					$intCartRowSpan			= $shopOrderMgr->getOrderCartList($db,"OP_COUNT",$param);
					$aryOrderCartList		= $shopOrderMgr->getOrderCartList($db,"OP_ARYTOTAL",$param);

					$strCartRowSpanHtml		= "";
					if ($intCartRowSpan > 1) $strCartRowSpanHtml = "rowspan=\"{$intCartRowSpan}\"";
			?>
			<tr>
				<td <?=$strCartRowSpanHtml?>><input type="checkbox" id="chkNo[]" name="chkNo[]" value="<?=$row[O_NO]?>"></td>
				<td <?=$strCartRowSpanHtml?>><?=$intListNum?></td>
				<td <?=$strCartRowSpanHtml?>>
					<span><?=$row[O_KEY]?></span>
					<span class="orderDate">[<?=$row[O_REG_DT]?>]</span>
					<a class="btn_sml" href="javascript:goOrderView('<?=$row[O_NO]?>');"><span><?=$LNG_TRANS_CHAR["OW00012"] //상세보기?></span></a>
					<a class="<?=($row['MEMO_CNT']) ? "btn_blue_sml":"btn_sml";?>" href="javascript:goOrderMemoListEvent('<?=$row['O_NO']?>');"><strong><?= $LNG_TRANS_CHAR["CW00029"]; //메모 ?><?=($row['MEMO_CNT']) ? "({$row['MEMO_CNT']})":"";?></strong></a>
				</td>
				<td <?=$strCartRowSpanHtml?>>
					<ul>
						<li><?=$row[O_J_NAME]?></li>
						<?=$strOrderMemberId?>
					</ul>
				</td <?=$strCartRowSpanHtml?>>
				<td <?=$strCartRowSpanHtml?>>
					<?=$strOrderSettleStatusText?>
				</td>
				<?
					if (is_array($aryOrderCartList)){
						for($i=0;$i<sizeof($aryOrderCartList);$i++){
							$intCartShopNo			= $a_admin_shop_no;
							## 추가상품정보
							$aryProdCartAddOptList  = "";
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
									$strCartDeliveryTypeName	 = "기본배송";
								break;
								case "2":
									$strCartDeliveryTypeName	 = "무료배송";
								break;
								case "3":
									$strCartDeliveryTypeName	 = "고정배송비";
									$strCartDeliveryTypeName	.= "(".getCurMark($S_ST_CUR).getFormatPrice($aryOrderCartList[$i]['OC_DELIVERY_CUR_PRICE'],2).getCurMark2($S_ST_CUR).")";

								break;
								case "4":
									$strCartDeliveryTypeName	 = "수량별배송";
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

							$temp							= explode(",", $aryOrderCartShopList[$intCartShopNo]['SH_COM_DELIVERY_COR']);
							$aryDeliveryCom					= "";
							foreach($temp as $val):
								//마스터 계정에서 택배설정을 체크 하지 않은 없체($aryDeliveryComAll)와 입점사 택배체크 업체 $aryDeliveryCom 비교. 남덕희 2015.08.17
								if($aryDeliveryComAll[$val]){
								$aryDeliveryCom[$val]		= $aryDeliveryComAll[$val];
								}
							endforeach;

							## 배송 조회
							$strCartDeliveryComUrl= "";
							if($aryOrderCartList[$i]['OC_DELIVERY_COM'] && $aryOrderCartList[$i]['OC_DELIVERY_NUM']):
								$strCartDeliveryComUrl		= $aryDeliveryUrl[$aryOrderCartList[$i]['OC_DELIVERY_COM']];
								$strCartDeliveryComUrl		= str_replace("{dev_no}", $aryOrderCartList[$i]['OC_DELIVERY_NUM'], $strCartDeliveryComUrl);
							endif;

							if ($i > 0) echo "<tr>";
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
				</td>
				<td>
					<?=$strCartDeliveryTypeName . $strCartDeliveryPayMthName?>
				</td>
				<td>
					<?if ($i == 0  && $aryOrderCartShopList[$intCartShopNo]['CART_CNT'] > 1){?>
					<a class="btn_sml" href="javascript:goOrderCartDeliveryUpdate(<?=$row['O_NO']?>,0,<?=$intCartShopNo?>);"><strong><?="전체배송정보변경" //전체배송정보변경?></strong></a>
					<?}?>
					<ul id="order_cart_delivery_<?=$row['O_NO']?>_<?=$aryOrderCartList[$i]['OC_NO']?>">
						<li>
							<select id="cartDeliveryStatus" default="<?=$aryOrderCartList[$i]['OC_DELIVERY_STATUS']?>">
								<option value=""><?= $LNG_TRANS_CHAR["SW00074"]; //배송상태 ?></option>
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
							<input type="text" id="cartDeliveryNum" value="<?=$aryOrderCartList[$i]['OC_DELIVERY_NUM']?>" style="width:120px">
							<?if ($aryOrderCartList[$i]['OC_DELIVERY_COM'] && $aryOrderCartList[$i]['OC_DELIVERY_NUM']){?>
								<a class="btn_sml" href="<?=$strCartDeliveryComUrl?>" target="_blank"><strong>배송추적</strong></a>
							<?}?>
						</li>
						<li>
							<a class="btn_sml" id="btnCartDeliverySave" href="javascript:goOrderCartDeliveryUpdate(<?=$row['O_NO']?>,'<?=$aryOrderCartList[$i]['OC_NO']?>','<?=$aryOrderCartList[$i]['P_SHOP_NO']?>');" <?=(SUBSTR($aryOrderCartList[$i]['OC_ORDER_STATUS'],0,1) == "C")?"disabled":"";?>><strong><?= $LNG_TRANS_CHAR["OW00174"]; //개별배송정보변경 ?></strong></a>
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
									<option value=""><?= $LNG_TRANS_CHAR["CW00041"]; //선택 ?></option>
									<option value="E" <?if($aryOrderCartList[$i]['OC_ORDER_STATUS']=="E"){echo "selected";}?>><?=$LNG_TRANS_CHAR["OW00139"] //구매완료?></option>
									<?foreach($S_ARY_SETTLE_ORDER_STATUS as $key => $value):?>
									<option value="<?=$key?>"<?if($aryOrderCartList[$i]['OC_ORDER_STATUS']==$key){echo " selected";}?>><?=$value?></option>
									<?endforeach;?>
								</select>
							</li>
							<?
								if (SUBSTR($aryOrderCartList[$i]['OC_ORDER_STATUS'],0,1) == "C"){
									if ($aryOrderCartList[$i]['OC_C_REQ_DT']){
										echo "<li>".$LNG_TRANS_CHAR["OW00140"].":".$aryOrderCartList[$i]['OC_C_REQ_DT']."</li>"; //취소신청일
									}
									if ($aryOrderCartList[$i]['OC_ORDER_STATUS']){
										echo "<li>".$LNG_TRANS_CHAR["OW00141"].":".$aryOrderCartList[$i]['OC_C_REG_DT']."</li>"; //취소완료일
									}
								}
							?>
							<li>
								<a class="btn_sml" href="javascript:goOrderStatusUpdate('<?=$aryOrderCartList[$i]['OC_NO']?>');"><strong><?=$LNG_TRANS_CHAR["SW00076"]; //구매상태변경?></strong></a>
							</li>
						</ul>
					</div>
				</td>
				<?if ($i == 0){?>
				<td <?=$strCartRowSpanHtml?>>
					<?=getCurMark($S_ST_CUR)?> <?=getFormatPrice($aryOrderCartShopList[$intCartShopNo]['SO_TOT_DELIVERY_CUR_PRICE'],2)?><?=getCurMark2($S_ST_CUR)?>
				</td>
				<?}?>
			</tr>

							<?


						}
					}
				?>
			<tr>
				<td colspan="2"><?=$LNG_TRANS_CHAR["OW00134"] //주문정보?></td>
				<td colspan="11" style="text-align:left;">
					<ul>
						<li>
							<?=$LNG_TRANS_CHAR["OW00030"]//주문자정보?> : <?=$row[O_J_MAIL]?>,<?=$row[O_J_HP]?> <?=(STRPOS($row[O_J_PHONE],"-") > 0) ? ",".$row[O_J_PHONE]:"";?>
						</li>
						<li>
							<?=$LNG_TRANS_CHAR["OW00034"]//배송지정보?> : [<?=$row[O_B_NAME]?>] [<?=$row[O_B_ZIP]?>] <?=$row[O_B_ADDR1]?> <?=$row[O_B_ADDR2]?> <?=$row[O_B_CITY]?> <?=$strDeliveyState?> <?=$aryCountryList[$row[O_B_COUNTRY]]?> <a class="btn_sml" href="javascript:goOrderDeliveryAddr('<?=$row['O_NO']?>');"><strong><?= $LNG_TRANS_CHAR["OW00176"]; //배송정보수정 ?></strong></a>
						</li>
					</ul>
				</td>
			</tr>
			<tr class="blankTr">
				<td colspan="13"></td>
			</tr>
			<?
					$intListNum--;
				}
			}
			?>
		</table>
	</div>