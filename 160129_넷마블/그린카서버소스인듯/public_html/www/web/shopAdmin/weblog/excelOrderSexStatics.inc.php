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
				<col />
				<col style="background-color:#f1f7f9" />
				<col />
				<col style="background-color:#f1f7f9" />
			</colgroup>
			<tr>
				<th rowspan="2" class="lowTh"><?=$LNG_TRANS_CHAR["EW00073"] //일별?></th>
				<th colspan="2"><?=$LNG_TRANS_CHAR["EW00086"] //남?></th>
				<th colspan="2"><?=$LNG_TRANS_CHAR["EW00087"] //여?></th>
			</tr>
			<tr>
				<th><?=$LNG_TRANS_CHAR["EW00089"] //건수?></th>
				<th><?=$LNG_TRANS_CHAR["EW00090"] //금액?></th>
				<th><?=$LNG_TRANS_CHAR["EW00089"] //건수?></th>
				<th><?=$LNG_TRANS_CHAR["EW00090"] //금액?></th>
			</tr>
			<?
			if (is_array($aryOrderSaleList)){

				for($i=1;$i<=2;$i++){
					$arrOrderSex[$i]["CNT"]		= 0;
					$arrOrderSex[$i]["PRICE"]	= 0;
				}
				for($i=0;$i<sizeof($aryOrderSaleList);$i++){
					for($j=1;$j<=2;$j++){
						$arrOrderSex[$j]["CNT"]		= $arrOrderSex[$j]["CNT"]	+ $aryOrderSaleList[$i]["M_ORDER_CNT".$j];
						$arrOrderSex[$j]["PRICE"]	= $arrOrderSex[$j]["PRICE"] + $aryOrderSaleList[$i]["M_ORDER_PRICE".$j];
					}
					?>
			<tr>
				<td><?=$aryOrderSaleList[$i][O_REG_DT]?></td>
				<td><?=NUMBER_FORMAT($aryOrderSaleList[$i][M_ORDER_CNT1])?></td>
				<td><?=getFormatPrice($aryOrderSaleList[$i][M_ORDER_PRICE1],2,$S_ST_CUR)?></td>
				<td><?=NUMBER_FORMAT($aryOrderSaleList[$i][M_ORDER_CNT2])?></td>
				<td><?=getFormatPrice($aryOrderSaleList[$i][M_ORDER_PRICE2],2,$S_ST_CUR)?></td>
			</tr>
					<?
				}
			}
			?>
			<tr>
				<td><?=$LNG_TRANS_CHAR["EW00079"] //합계?></td>
				<td><?=NUMBER_FORMAT($arrOrderSex[1]["CNT"])?></td>
				<td><?=getFormatPrice($arrOrderSex[1]["PRICE"],2,$S_ST_CUR)?></td>
				<td><?=NUMBER_FORMAT($arrOrderSex[2]["CNT"])?></td>
				<td><?=getFormatPrice($arrOrderSex[2]["PRICE"],2,$S_ST_CUR)?></td>
			</tr>
		</table>