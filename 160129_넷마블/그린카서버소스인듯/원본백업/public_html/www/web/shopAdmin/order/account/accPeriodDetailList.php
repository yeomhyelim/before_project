<div id="contentArea">
	<div class="contentTop">
		<h2><?=$strTitle?></h2>
		<div class="clr"></div>
	</div>
	<div class="tabImgWrap mt10">
		<a href="javascript:javascript:goInitMoveUrl('accList','<?=$strSearchAccStatus?>');" >주문별</a>	
		<a href="javascript:javascript:goInitMoveUrl('accPeriodList','<?=$strSearchAccStatus?>');" class="selected">주문기간별</a>
		<?if($S_SHOP_ORDER_VERSION=="V2.0"){?>
		<a href="javascript:javascript:goInitMoveUrl('accDateList','<?=$strSearchAccStatus?>');" <?=($strMode=="accDateList")?"class=\"selected\"":"";?>>구매일자별</a>
		<?}?>
	</div>

	<!-- ******** 컨텐츠 ********* -->
	<div class="tableList mt10">
		<table style="border-left:1px solid #D2D0D0">
			<colgroup>
				<col />
				<col width=100/>
				<col width=100/>
				<col width=150/>
				<col width=150/>
				<col width=150/>
				<col width=150/>
				<col width=150/>	
			</colgroup>
			<tr>
				<th><?=$LNG_TRANS_CHAR["OW00096"] //업체명?></th>
				<th><?=$LNG_TRANS_CHAR["OW00105"] //판매건수?></th>
				<th><?=$LNG_TRANS_CHAR["OW00106"] //판매수량?></th>
				<th><?="총입고가" //입고가격?></th>
				<th><?="총판매가" //판매가격?></th>
				<th><?="총배송비" //배송비?></th>
				<th><?="총정산금액" //정산금액?></th>
				<th><?="총수수료" //수수료?></th>
			</tr>
			<?if ($intTotal == 0){?>
			<tr>
				<td colspan="9"><?=$LNG_TRANS_CHAR["CS00001"]?></td>
			</tr>
			<?}else{
				while($row = mysql_fetch_array($totRet)){
					#총수수료
					$intTotOrderAccFeePrice = $row[TOT_SPRICE] - $row[TOT_APRICE];


				?>
			<tr>
				<td><?=$row[SH_COM_NAME]?></td>
				<td><?=NUMBER_FORMAT($row[TOT_CNT])?></td>
				<td><?=NUMBER_FORMAT($row[TOT_QTY])?></td>
				<td><?=getFormatPrice($row[TOT_PRICE])?></td>
				<td><?=getFormatPrice($row[TOT_SPRICE])?></td>
				<td><?=getFormatPrice($row[TOT_BPRICE])?></td>
				<td><?=getFormatPrice($row[TOT_APRICE]+$row[TOT_BPRICE])?></td>
				<td><?=getFormatPrice($intTotOrderAccFeePrice)?></td>
			</tr>
			<?
				}
			}
			?>
		</table>
	</div>
	
	<div class="tableList">
		<table style="border-left:1px solid #D2D0D0">
			<colgroup>
				<col width=50/>
				<col width=40/>
				<col width=150/>
				<col width=100/>
				<col />
				<col />
				<col width=100/>
				<col width=100/>
				<col width=100/>
				<col width=100/>
				<col width=100/>
				<col width=100/>
			</colgroup>
			<tr>
				<th><?=$LNG_TRANS_CHAR["CW00009"] //번호?></th>
				<th><?=$LNG_TRANS_CHAR["OW00002"] //주문번호?><br><?=$LNG_TRANS_CHAR["OW00074"] //주문일시?></th>
				<th><?=$LNG_TRANS_CHAR["OW00010"] //주문상태?></th>
				<th><?=$LNG_TRANS_CHAR["OW00096"] //업체명?></th>
				<th><?=$LNG_TRANS_CHAR["OW00022"] //상품정보?></th>
				<th><?="총입고가" //입고가격?></th>
				<th><?="총판매가" //판매가격?></th>
				<th><?="총배송비" //배송비?></th>
				<th><?="총정산금액" //정산금액?></th>	
				<th><?="총수수료" //수수료?></th>
				<th><?=$LNG_TRANS_CHAR["OW00109"] //정산상태?></th>
			</tr>
			<?if ($intTotal == 0){?>
			<tr>
				<td colspan="10"><?=$LNG_TRANS_CHAR["CS00001"]?></td>
			</tr>
			<?}else{
				while($row = mysql_fetch_array($result)){
					
					#총수수료
					$intTotOrderAccFeePrice = $row[SO_TOT_CUR_SPRICE] - $row[SO_TOT_CUR_APRICE];


					/* 주문내역 가지고 오기*/
					$accMgr->setO_NO($row[O_NO]);
					$accMgr->setSH_NO($row[SH_NO]);
					$aryOrderCartList = $accMgr->getOrderCartList($db);
					

				?>
			<tr>
				<td><?=$intListNum?></td>
				<td>
					<span><?=$row[O_KEY]?></span>
					<span class="orderDate">[<?=$row[O_REG_DT]?>]</span>
				</td>
				<td><?=$S_ARY_SHOP_ORDER_STATUS[$row[SO_ORDER_STATUS]]?></td>
				<td><?=$row[SH_COM_NAME]?></td>
				<td>
					<?
					if (is_array($aryOrderCartList)){
						for($i=0;$i<sizeof($aryOrderCartList);$i++){
							
							if ($i > 0 ) echo "<br>";
							//$orderMgr->setOC_NO($aryOrderCartList[$i][OC_NO]);
							//$aryProdCartAddOptList = $orderMgr->getOrderCartAddList($db);

							$strCartOptAttrVal = "";
							for($kk=1;$kk<=10;$kk++){
								if ($aryOrderCartList[$i]["OC_OPT_ATTR".$kk]){
									$strCartOptAttrVal .= "/".$aryOrderCartList[$i]["OC_OPT_ATTR".$kk];
								}
							}
							$strCartOptAttrVal = SUBSTR($strCartOptAttrVal,1);
						
							echo $aryOrderCartList[$i][P_NAME];
							if ($strCartOptAttrVal) echo "(".$strCartOptAttrVal.")";
							echo "/".$aryOrderCartList[$i][OC_QTY];
						}
					}
					?>
				</td>
				<td><?=getFormatPrice($row[SO_TOT_CUR_PRICE])?></td>
				<td><?=getFormatPrice($row[SO_TOT_CUR_SPRICE])?></td>
				<td><?=getFormatPrice($row[SO_TOT_DELIVERY_CUR_PRICE])?></td>
				<td><?=getFormatPrice($row[SO_TOT_CUR_APRICE]+$row[SO_TOT_DELIVERY_CUR_PRICE])?></td>
				<td><?=getFormatPrice($intTotOrderAccFeePrice)?></td>
				<td><?=(!$row[SO_ACC_STATUS]) ? "N": $row[SO_ACC_STATUS];?></td>
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
	
	<div style="text-align:left;margin-top:3px;">
		<?if ($strSearchAccStatus == "N"){?>
		<?if ($a_admin_type == "A"){?>
		<a class="btn_big" href="javascript:goAllAccStatusUpdate();"><strong><?=$LNG_TRANS_CHAR["OW00108"] //업체정산하기?></strong></a>
		<?}?>
		<?}?>
		<a class="btn_big" href="javascript:goMoveUrl('accPeriodList','<?=$strSearchAccStatus?>');"><strong><?=$LNG_TRANS_CHAR["CW00001"] //목록?></strong></a>
	</div>
	
</div>
