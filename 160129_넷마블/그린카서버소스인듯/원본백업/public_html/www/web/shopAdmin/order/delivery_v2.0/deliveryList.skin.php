	<div class="tableListWrap">
		<table class="tableList">
			<colgroup>
				<col width=50/>
				<col width=150/>
				<?if ($S_MALL_TYPE != "R"){?><col width=120><?}?>
				<col width=50/>
				<col />
				<col width=80/>
				<col width=120/>
				<col width=120/>
				<col width=150/>
				<?if ($S_MALL_TYPE != "R"){?><col width=100/><?}?>
				<?if ($_REQUEST["searchOrderStatus"] == "D"){?><col width=80/><?}?>
			</colgroup>
			<tr>
				<th><?=$LNG_TRANS_CHAR["CW00009"] //번호?></th>
				<th><?=$LNG_TRANS_CHAR["OW00002"] //주문번호?> (<?= $LNG_TRANS_CHAR["OW00074"]; //주문일시 ?> / <?= $LNG_TRANS_CHAR["OW00151"]; //결제일시 ?>)</th>
				<?if ($S_MALL_TYPE != "R"){?><th><?= $LNG_TRANS_CHAR["SW00080"]; //입점사?></th><?}?>
				<th colspan="2"><?=$LNG_TRANS_CHAR["OW00022"]; //상품정보 ?></th>
				<th><?= $LNG_TRANS_CHAR["SW00059"]; //수량 ?></th>
				<th><?= $LNG_TRANS_CHAR["OW00089"]; //판매가 ?></th>
				<th><?= $LNG_TRANS_CHAR["PW00064"]; //배송비 ?></th>
				<th><?= $LNG_TRANS_CHAR["OW00044"]; //배송정보 ?></th>
				<?if ($S_MALL_TYPE != "R"){?><th><?= $LNG_TRANS_CHAR["OW00061"]; //총배송비 ?></th><?}?>
				<?if ($_REQUEST["searchOrderStatus"] == "D"){?><th><?= $LNG_TRANS_CHAR["OW00142"]; //구매확정 ?><input type="checkbox" name="chkAll" value="Y" onclick="javascript:C_getCheckAll(this.checked)"/></th><?}?>
			</tr>
			<?if ($intTotal == 0){?>
			<tr>
				<td colspan="13"><?=$LNG_TRANS_CHAR["CS00001"]?></td>
			</tr>
			<?}else{
				while($row = mysql_fetch_array($orderDeliveryListResult)){

					/* 주문자 CRM 연결 */
					$btnOrderMemberCrmLink = "";
					if ($a_admin_type == "A" && $row['M_NO'] > 0){
						$btnOrderMemberCrmLink = "<a class=\"btn_sml\" href=\"javascript:goMemberCrmView('".$row['M_NO']."');\" id=\"menu_auth_m\" style=\"display: inline-block;\"><strong>CRM</strong></a>";
					}

					/* 주문 입점사별 리스트 */
					if ($S_MALL_TYPE != "R"){
						$param								= "";
						$param['O_NO']						= $row['O_NO'];
						$param["O_USE_LNG"]					= $S_SITE_LNG;
						$param['O_SHOP_NO']					= $row['P_SHOP_NO'];

						if ($_REQUEST['searchOrderStatus'] && in_array($_REQUEST['searchOrderStatus'],array('B','I','D'))){
							$param['OC_DELIVERY_STATUS']	= $_REQUEST['searchOrderStatus'];
						}

						$aryOrderCartShopList	= $shopOrderMgr->getOrderCartShopInfo($db,$param);


					}

					$intCartRowSpan				= $row['P_SHOP_CNT'];

					//$param['OC_DELIVERY_STATUS']				= $_REQUEST['searchOrderStatus'];
					$param['OC_ORDER_STATUS_NOT_IN']		    = "'C1','S1','R1','T1','E','C2','S2','R2','T2'";
					if (!$param['searchOrderStatus'] && in_array($param['searchDeliveryStatus'],array('B','I','D'))){
						$param['OC_DELIVERY_STATUS']			= $param['searchDeliveryStatus'];
					}

					$aryOrderCartList			= $shopOrderMgr->getOrderCartList($db,"OP_ARYTOTAL",$param);
					//echo $db->query."<br><br>";

					$strCartRowSpanHtml			= "";
					if ($intCartRowSpan > 1) $strCartRowSpanHtml = "rowspan=\"{$intCartRowSpan}\"";



			?>
			<tr>
				<td <?=$strCartRowSpanHtml?>><?=$intListNum?></td>
				<td <?=$strCartRowSpanHtml?>>
					<ul>
						<li><span><?=$row[O_KEY]?></span></li>
						<li><span class="orderDate">[<?=$row[O_REG_DT]?>]</span></li>
						<?if ($row[O_APPR_DT]){?><li><span class="orderDate">[<?=$row[O_APPR_DT]?>]</span></li><?}?>
					</ul>
				</td>
				<?if ($S_MALL_TYPE != "R"){?><td <?=$strCartRowSpanHtml?>><?=$aryOrderCartShopList[$row['P_SHOP_NO']]['SH_COM_NAME']?></td><?}?>

				<?
					if (is_array($aryOrderCartList))
					{
						for($i=0;$i<sizeof($aryOrderCartList);$i++){

							$intCartShopNo			= $aryOrderCartList[$i]["P_SHOP_NO"];
							## 추가상품정보
							if ($aryOrderCartList[$i]["OC_OPT_ADD_CUR_PRICE"] > 0)
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
							if ($aryOrderCartList[$i]['OC_BAESONG_TYPE'] == "1") $strCartDeliveryPayMthName = "(주문시결제)";
							else if ($aryOrderCartList[$i]['OC_BAESONG_TYPE'] == "2") $strCartDeliveryPayMthName = "(착불)";

							$temp							= explode(",", $S_DELIVERY_COM);
							if ($row['P_SHOP_NO'] > 0) {
								$temp						= explode(",", $aryOrderCartShopList[$intCartShopNo]['SH_COM_DELIVERY_COR']);
							}

							$aryDeliveryCom					= "";
							foreach($temp as $key):
								$aryDeliveryCom[$key]		= $aryDeliveryComAll[$key];
							endforeach;

							## 배송 조회
							$strCartDeliveryComUrl= "";
							if($aryOrderCartList[$i]['OC_DELIVERY_COM'] && $aryOrderCartList[$i]['OC_DELIVERY_NUM']):
								$strCartDeliveryComUrl		= $aryDeliveryUrl[$aryOrderCartList[$i]['OC_DELIVERY_COM']];
								$strCartDeliveryComUrl		= str_replace("{dev_no}", $aryOrderCartList[$i]['OC_DELIVERY_NUM'], $strCartDeliveryComUrl);
							endif;

							if ($i  > 0) echo "<tr>";
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
							<li><?=$LNG_TRANS_CHAR["OW00046"] //추가선택?> : <?=$aryProdCartAddOptList[$k][OCA_OPT_NM]?></li>
						<?}}?>
					</ul>
					<div class="clr"></div>
				</td>
				<td>
					<?=$aryOrderCartList[$i]['OC_QTY']?>
				</td>
				<td>
					<?=getCurMark($S_ST_CUR)?> <?=getFormatPrice($aryOrderCartList[$i]['OC_CUR_PRICE'],2)?><?=getCurMark2($S_ST_CUR)?>
					<?if ($aryOrderCartList[$i][OC_OPT_ADD_PRICE] > 0){?><br><?=$LNG_TRANS_CHAR["OW00024"] //추가금액?>:<?=getCurMark($S_ST_CUR)?>  <?=getFormatPrice($aryOrderCartList[$i][OC_OPT_ADD_CUR_PRICE],2)?><?=getCurMark2($S_ST_CUR)?><?}?>
				</td>
				<td>
					<?=$strCartDeliveryTypeName?>
				</td>
				<td class="deliveryWrap">
					<ul id="order_cart_delivery_<?=$row['O_NO']?>_<?=$aryOrderCartList[$i]['OC_NO']?>">
						<li>
							<select name="cartDeliveryStatus" default="<?=$aryOrderCartList[$i]['OC_DELIVERY_STATUS']?>">
								<option value="">배송상태</option>
								<?foreach($S_ARY_DELIVERY_STATUS as $key => $value):?>
								<option value="<?=$key?>"<?if($aryOrderCartList[$i]['OC_DELIVERY_STATUS'] == $key){echo " selected";}?>><?=$value?></option>
								<?endforeach;?>
							</select>
							<select name="cartDeliveryCom">
								<option value=""><?=$LNG_TRANS_CHAR["OW00053"]//배송회사?></option>
								<?foreach($aryDeliveryCom as $key => $value):?>
								<option value="<?=$key?>"<?if(trim($aryOrderCartList[$i]['OC_DELIVERY_COM']) == $key){echo " selected";}?>><?=$value?></option>
								<?endforeach;?>
							</select>
						</li>
						<li>
							<input type="text" name="cartDeliveryNum" value="<?=$aryOrderCartList[$i]['OC_DELIVERY_NUM']?>" style="width:120px">
							<?if ($aryOrderCartList[$i]['OC_DELIVERY_COM'] && $aryOrderCartList[$i]['OC_DELIVERY_NUM']){?>
								<a class="btn_sml" href="<?=$strCartDeliveryComUrl?>" target="_blank"><strong>배송추적</strong></a>
							<?}?>
						</li>
						<?if ($aryOrderCartList[$i]['OC_DELIVERY_ST_DT']){?>
						<li>배송시작일:<?=$aryOrderCartList[$i]['OC_DELIVERY_ST_DT']?></li>
						<?}?>
						<?if ($aryOrderCartList[$i]['OC_DELIVERY_END_DT']){?>
						<li>배송완료일:<?=$aryOrderCartList[$i]['OC_DELIVERY_END_DT']?></li>
						<?}?>
					</ul>
				</td>
				<?if ($i  == 0 && $S_MALL_TYPE != "R"){?>
				<td <?=$strCartRowSpanHtml?>>
					<?=getCurMark($S_ST_CUR)?> <?=getFormatPrice($aryOrderCartShopList[$intCartShopNo]['SO_TOT_DELIVERY_CUR_PRICE'],2)?><?=getCurMark2($S_ST_CUR)?>
				</td>
				<?}?>
				<?if ($_REQUEST["searchOrderStatus"] == "D"){?>
				<td>
					<input type="checkbox" id="chkNo[]" name="chkNo[]" value="<?=$aryOrderCartList[$i]['OC_NO']?>">
				</td>
				<?}?>

							<?

							echo "</tr>";
						}
					}
				?>
			<tr>
				<td colspan="2"><?=$LNG_TRANS_CHAR["OW00134"] //주문정보?></td>
				<td colspan="10" style="text-align:left;">
					<ul>
						<li>
							<?=$LNG_TRANS_CHAR["OW00030"]//주문자정보?> : <?=$row[O_J_MAIL]?>,<?=$row[O_J_HP]?> <?=(STRPOS($row[O_J_PHONE],"-") > 0) ? ",".$row[O_J_PHONE]:"";?>
							<?=$btnOrderMemberCrmLink?>
							<a class="<?=($row['MEMO_CNT']) ? "btn_blue_sml":"btn_sml";?>" href="javascript:goOrderMemoListEvent('<?=$row['O_NO']?>');"><strong>메모<?=($row['MEMO_CNT']) ? "({$row['MEMO_CNT']})":"";?></strong></a>
						</li>
						<li>
							<?=$LNG_TRANS_CHAR["OW00034"]//배송지정보?> : [<?=$row[O_B_NAME]?>] [<?=$row[O_B_ZIP]?>] <?=$row[O_B_ADDR1]?> <?=$row[O_B_ADDR2]?> <?=$row[O_B_CITY]?> <?=$strDeliveyState?> <?=$aryCountryList[$row[O_B_COUNTRY]]?>
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