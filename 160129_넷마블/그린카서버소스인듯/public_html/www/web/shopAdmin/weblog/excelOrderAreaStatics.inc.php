		<table border="1">
			<tr>
				<th rowspan="2" class="lowTh"><?=$LNG_TRANS_CHAR["EW00073"] //일별?></th>
				<th colspan="2">강원</th>
				<th colspan="2">경기</th>
				<th colspan="2">경남</th>
				<th colspan="2">경북</th>
				<th colspan="2">광주</th>
				<th colspan="2">대구</th>
				<th colspan="2">대전</th>
				<th colspan="2">부산</th>
				<th colspan="2">서울</th>
				<th colspan="2">울산</th>
				<th colspan="2">인천</th>
				<th colspan="2">전남</th>
				<th colspan="2">전북</th>
				<th colspan="2">제주</th>
				<th colspan="2">충남</th>
				<th colspan="2">충북</th>
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
				for($i=1;$i<=16;$i++){
					$arrOrderArea[$i]["CNT"]		= 0;
					$arrOrderArea[$i]["PRICE"]	= 0;
				}

				for($i=0;$i<sizeof($aryOrderSaleList);$i++){
					for($j=1;$j<=16;$j++){
						$arrOrderArea[$j]["CNT"]	= $arrOrderArea[$j]["CNT"]	+ $aryOrderSaleList[$i]["M_ORDER_CNT".$j];
						$arrOrderArea[$j]["PRICE"]	= $arrOrderArea[$j]["PRICE"] + $aryOrderSaleList[$i]["M_ORDER_PRICE".$j];
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
				<td><?=NUMBER_FORMAT($aryOrderSaleList[$i][M_ORDER_CNT7])?></td>
				<td><?=getFormatPrice($aryOrderSaleList[$i][M_ORDER_PRICE7],2,$S_ST_CUR)?></td>
				<td><?=NUMBER_FORMAT($aryOrderSaleList[$i][M_ORDER_CNT8])?></td>
				<td><?=getFormatPrice($aryOrderSaleList[$i][M_ORDER_PRICE8],2,$S_ST_CUR)?></td>
				<td><?=NUMBER_FORMAT($aryOrderSaleList[$i][M_ORDER_CNT9])?></td>
				<td><?=getFormatPrice($aryOrderSaleList[$i][M_ORDER_PRICE9],2,$S_ST_CUR)?></td>
				<td><?=NUMBER_FORMAT($aryOrderSaleList[$i][M_ORDER_CNT10])?></td>
				<td><?=getFormatPrice($aryOrderSaleList[$i][M_ORDER_PRICE10],2,$S_ST_CUR)?></td>
				<td><?=NUMBER_FORMAT($aryOrderSaleList[$i][M_ORDER_CNT11])?></td>
				<td><?=getFormatPrice($aryOrderSaleList[$i][M_ORDER_PRICE11],2,$S_ST_CUR)?></td>
				<td><?=NUMBER_FORMAT($aryOrderSaleList[$i][M_ORDER_CNT12])?></td>
				<td><?=getFormatPrice($aryOrderSaleList[$i][M_ORDER_PRICE12],2,$S_ST_CUR)?></td>
				<td><?=NUMBER_FORMAT($aryOrderSaleList[$i][M_ORDER_CNT13])?></td>
				<td><?=getFormatPrice($aryOrderSaleList[$i][M_ORDER_PRICE13],2,$S_ST_CUR)?></td>
				<td><?=NUMBER_FORMAT($aryOrderSaleList[$i][M_ORDER_CNT14])?></td>
				<td><?=getFormatPrice($aryOrderSaleList[$i][M_ORDER_PRICE14],2,$S_ST_CUR)?></td>
				<td><?=NUMBER_FORMAT($aryOrderSaleList[$i][M_ORDER_CNT15])?></td>
				<td><?=getFormatPrice($aryOrderSaleList[$i][M_ORDER_PRICE15],2,$S_ST_CUR)?></td>
				<td><?=NUMBER_FORMAT($aryOrderSaleList[$i][M_ORDER_CNT16])?></td>
				<td><?=getFormatPrice($aryOrderSaleList[$i][M_ORDER_PRICE16],2,$S_ST_CUR)?></td>
			
			</tr>
					<?
				}
			}
			?>
			<tr>
				<td><?=$LNG_TRANS_CHAR["EW00079"] //합계?></td>
				<?for($i=1;$i<=16;$i++){?>
				<td><?=NUMBER_FORMAT($arrOrderArea[$i]["CNT"])?></td>
				<td><?=getFormatPrice($arrOrderArea[$i]["PRICE"],2,$S_ST_CUR)?></td>
				<?}?>
			</tr>
		</table>