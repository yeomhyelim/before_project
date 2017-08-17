		<table border="1">
			<colgroup>
				<col style="width:80px;"/>				
				<col />
				<col style="background-color:#f1f7f9" />
				<col />
				<col style="background-color:#f1f7f9" />
				<col />
				<col style="background-color:#f1f7f9" />
				<col />
				<col style="background-color:#f1f7f9" />
				<col />
				<col style="background-color:#f1f7f9" />
				<col />
				<col style="background-color:#f1f7f9" />
				<col />
				<col style="background-color:#f1f7f9" />
			</colgroup>
			<tr>
				<th rowspan="2" class="lowTh"><?=$LNG_TRANS_CHAR["EW00073"] //일별?></th>
				<th colspan="2">10대</th>
				<th colspan="2">20대</th>
				<th colspan="2">30대</th>
				<th colspan="2">40대</th>
				<th colspan="2">50대</th>
				<th colspan="2"><?=$LNG_TRANS_CHAR["EW00081"] //60대이상?></th>
			</tr>
			<tr>
				<th><?=$LNG_TRANS_CHAR["EW00089"] //건수?></th>
				<th><?=$LNG_TRANS_CHAR["EW00090"] //금액?></th>
				<th><?=$LNG_TRANS_CHAR["EW00089"] //건수?></th>
				<th><?=$LNG_TRANS_CHAR["EW00090"] //금액?></th>
				<th><?=$LNG_TRANS_CHAR["EW00089"] //건수?></th>
				<th><?=$LNG_TRANS_CHAR["EW00090"] //금액?></th>
				<th><?=$LNG_TRANS_CHAR["EW00089"] //건수?></th>
				<th><?=$LNG_TRANS_CHAR["EW00090"] //금액?></th>
				<th><?=$LNG_TRANS_CHAR["EW00089"] //건수?></th>
				<th><?=$LNG_TRANS_CHAR["EW00090"] //금액?></th>
				<th><?=$LNG_TRANS_CHAR["EW00089"] //건수?></th>
				<th><?=$LNG_TRANS_CHAR["EW00090"] //금액?></th>
			</tr>
			<?
			if (is_array($aryOrderSaleList)){
				for($i=1;$i<=6;$i++){
					$arrOrderAge[$i]["CNT"]		= 0;
					$arrOrderAge[$i]["PRICE"]	= 0;
				}
				for($i=0;$i<sizeof($aryOrderSaleList);$i++){

					for($j=1;$j<=6;$j++){
						$arrOrderAge[$j]["CNT"]		= $arrOrderAge[$j]["CNT"]	+ $aryOrderSaleList[$i]["M_ORDER_CNT".$j];
						$arrOrderAge[$j]["PRICE"]	= $arrOrderAge[$j]["PRICE"] + $aryOrderSaleList[$i]["M_ORDER_PRICE".$j];
					}
					?>
			<tr>
				<td><?=$aryOrderSaleList[$i][O_REG_DT]?></td>
				<td><?=NUMBER_FORMAT($aryOrderSaleList[$i][M_ORDER_CNT1])?></td>
				<td><?=getFormatPrice($aryOrderSaleList[$i][M_ORDER_PRICE1],2,$S_ST_CUR)?></td>
				<td><?=NUMBER_FORMAT($aryOrderSaleList[$i][M_ORDER_CNT2])?></td>
				<td><?=getFormatPrice($aryOrderSaleList[$i][M_ORDER_PRICE2],2,$S_ST_CUR)?></td>
				<td><?=NUMBER_FORMAT($aryOrderSaleList[$i][M_ORDER_CNT3])?></td>
				<td><?=getFormatPrice($aryOrderSaleList[$i][M_ORDER_PRICE3],2,$S_ST_CUR)?></td>
				<td><?=NUMBER_FORMAT($aryOrderSaleList[$i][M_ORDER_CNT4])?></td>
				<td><?=getFormatPrice($aryOrderSaleList[$i][M_ORDER_PRICE4],2,$S_ST_CUR)?></td>
				<td><?=NUMBER_FORMAT($aryOrderSaleList[$i][M_ORDER_CNT5])?></td>
				<td><?=getFormatPrice($aryOrderSaleList[$i][M_ORDER_PRICE5],2,$S_ST_CUR)?></td>
				<td><?=NUMBER_FORMAT($aryOrderSaleList[$i][M_ORDER_CNT6])?></td>
				<td><?=getFormatPrice($aryOrderSaleList[$i][M_ORDER_PRICE6],2,$S_ST_CUR)?></td>
			</tr>
					<?
				}
			}
			?>
			<tr>
				<td><?=$LNG_TRANS_CHAR["EW00079"] //합계?></td>
				<td><?=NUMBER_FORMAT($arrOrderAge[1]["CNT"])?></td>
				<td><?=getFormatPrice($arrOrderAge[1]["PRICE"],2,$S_ST_CUR)?></td>
				<td><?=NUMBER_FORMAT($arrOrderAge[2]["CNT"])?></td>
				<td><?=getFormatPrice($arrOrderAge[2]["PRICE"],2,$S_ST_CUR)?></td>
				<td><?=NUMBER_FORMAT($arrOrderAge[3]["CNT"])?></td>
				<td><?=getFormatPrice($arrOrderAge[3]["PRICE"],2,$S_ST_CUR)?></td>
				<td><?=NUMBER_FORMAT($arrOrderAge[4]["CNT"])?></td>
				<td><?=getFormatPrice($arrOrderAge[4]["PRICE"],2,$S_ST_CUR)?></td>
				<td><?=NUMBER_FORMAT($arrOrderAge[5]["CNT"])?></td>
				<td><?=getFormatPrice($arrOrderAge[5]["PRICE"],2,$S_ST_CUR)?></td>
				<td><?=NUMBER_FORMAT($arrOrderAge[6]["CNT"])?></td>
				<td><?=getFormatPrice($arrOrderAge[6]["PRICE"],2,$S_ST_CUR)?></td>
			</tr>
		</table>