		<table border="1">
			<tr>
				<th><?=$LNG_TRANS_CHAR["EW00077"] //상품명?></th>
				<th><?=$LNG_TRANS_CHAR["EW00090"] //가격?></th>
				<th><?=$LNG_TRANS_CHAR["OW00059"] //총건수?></th>
				<th><?=$S_ARY_SETTLE_STATUS["J"] //주문완료?></th>
				<th><?=$S_ARY_SETTLE_STATUS["A"] //결제완료?></th>
				<th><?=$S_ARY_SETTLE_STATUS["B"] //배송준비중?></th>
				<th><?=$S_ARY_SETTLE_STATUS["I"] //배송중?></th>
				<th><?=$S_ARY_SETTLE_STATUS["D"] //배송완료?></th>
				<th><?=$S_ARY_SETTLE_STATUS["E"] //구매완료?></th>
				<th><?=$S_ARY_SETTLE_STATUS["C"] //주문취소?></th>
			</tr>
			<?
			if (is_array($aryOrderSaleList)){
				
				for($i=0;$i<=7;$i++){
					$aryOrderStatus[$i]["CNT"]		= 0;
					$aryOrderStatus[$i]["PRICE"]	= 0;
				}
				
				$intTotProdSalePrice = 0;
				for($i=0;$i<sizeof($aryOrderSaleList);$i++){
					
					$aryOrderSaleList[$i]["O_STATUS_CNT"] = ($aryOrderSaleList[$i]["O_STATUS_CNT1"] + $aryOrderSaleList[$i]["O_STATUS_CNT2"] + $aryOrderSaleList[$i]["O_STATUS_CNT3"] + $aryOrderSaleList[$i]["O_STATUS_CNT4"] + $aryOrderSaleList[$i]["O_STATUS_CNT5"] + $aryOrderSaleList[$i]["O_STATUS_CNT6"] + $aryOrderSaleList[$i]["O_STATUS_CNT7"]);

					for($j=0;$j<=7;$j++){
						$intOrderStatusCnt				= ($j == 0) ? $aryOrderSaleList[$i]["O_STATUS_CNT"]		: $aryOrderSaleList[$i]["O_STATUS_CNT".$j];
						$intOrderStatusPrice			= ($j == 0) ? $aryOrderSaleList[$i]["O_STATUS_PRICE"]	: $aryOrderSaleList[$i]["O_STATUS_PRICE".$j];

						$aryOrderStatus[$j]["CNT"]		= $aryOrderStatus[$j]["CNT"]	+ $intOrderStatusCnt;
						$aryOrderStatus[$j]["PRICE"]	= $aryOrderStatus[$j]["PRICE"]  + $intOrderStatusPrice;
					}

					$intTotProdSalePrice += $aryOrderSaleList[$i][P_SALE_PRICE];
					?>
			<tr>
				<td style="text-align:left" rowspan="2">
					<?=$aryOrderSaleList[$i][P_NAME]?>
				</td>
				<td rowspan="2"><?=NUMBER_FORMAT($aryOrderSaleList[$i][P_SALE_PRICE])?></td>
				<td><?=NUMBER_FORMAT($aryOrderSaleList[$i][O_STATUS_CNT])?></td>
				<td><?=NUMBER_FORMAT($aryOrderSaleList[$i][O_STATUS_CNT1])?></td>
				<td><?=NUMBER_FORMAT($aryOrderSaleList[$i][O_STATUS_CNT2])?></td>
				<td><?=NUMBER_FORMAT($aryOrderSaleList[$i][O_STATUS_CNT3])?></td>
				<td><?=NUMBER_FORMAT($aryOrderSaleList[$i][O_STATUS_CNT4])?></td>
				<td><?=NUMBER_FORMAT($aryOrderSaleList[$i][O_STATUS_CNT5])?></td>
				<td><?=NUMBER_FORMAT($aryOrderSaleList[$i][O_STATUS_CNT6])?></td>
				<td><?=NUMBER_FORMAT($aryOrderSaleList[$i][O_STATUS_CNT7])?></td>
			</tr>
			<tr>
				<td><?=getFormatPrice($aryOrderSaleList[$i][O_STATUS_PRICE],2,$S_ST_CUR)?></td>
				<td><?=getFormatPrice($aryOrderSaleList[$i][O_STATUS_PRICE1],2,$S_ST_CUR)?></td>
				<td><?=getFormatPrice($aryOrderSaleList[$i][O_STATUS_PRICE2],2,$S_ST_CUR)?></td>
				<td><?=getFormatPrice($aryOrderSaleList[$i][O_STATUS_PRICE3],2,$S_ST_CUR)?></td>
				<td><?=getFormatPrice($aryOrderSaleList[$i][O_STATUS_PRICE4],2,$S_ST_CUR)?></td>
				<td><?=getFormatPrice($aryOrderSaleList[$i][O_STATUS_PRICE5],2,$S_ST_CUR)?></td>
				<td><?=getFormatPrice($aryOrderSaleList[$i][O_STATUS_PRICE6],2,$S_ST_CUR)?></td>
				<td><?=getFormatPrice($aryOrderSaleList[$i][O_STATUS_PRICE7],2,$S_ST_CUR)?></td>
			</tr>

					<?
				}
			}
			?>
			<tr>
				<td rowspan="2">
					<?=$LNG_TRANS_CHAR["EW00079"] //합계?>
				</td>
				<td rowspan="2">
					<?=NUMBER_FORMAT($intTotProdSalePrice)?>
				</td>
				<td><?=NUMBER_FORMAT($aryOrderStatus[0]["CNT"])?></td>
				<td><?=NUMBER_FORMAT($aryOrderStatus[1]["CNT"])?></td>
				<td><?=NUMBER_FORMAT($aryOrderStatus[2]["CNT"])?></td>
				<td><?=NUMBER_FORMAT($aryOrderStatus[3]["CNT"])?></td>
				<td><?=NUMBER_FORMAT($aryOrderStatus[4]["CNT"])?></td>
				<td><?=NUMBER_FORMAT($aryOrderStatus[5]["CNT"])?></td>
				<td><?=NUMBER_FORMAT($aryOrderStatus[6]["CNT"])?></td>
				<td><?=NUMBER_FORMAT($aryOrderStatus[7]["CNT"])?></td>
			</tr>
			<tr>
				<td><?=getFormatPrice($aryOrderStatus[0]["PRICE"],2,$S_ST_CUR)?></td>
				<td><?=getFormatPrice($aryOrderStatus[1]["PRICE"],2,$S_ST_CUR)?></td>
				<td><?=getFormatPrice($aryOrderStatus[2]["PRICE"],2,$S_ST_CUR)?></td>
				<td><?=getFormatPrice($aryOrderStatus[3]["PRICE"],2,$S_ST_CUR)?></td>
				<td><?=getFormatPrice($aryOrderStatus[4]["PRICE"],2,$S_ST_CUR)?></td>
				<td><?=getFormatPrice($aryOrderStatus[5]["PRICE"],2,$S_ST_CUR)?></td>
				<td><?=getFormatPrice($aryOrderStatus[6]["PRICE"],2,$S_ST_CUR)?></td>
				<td><?=getFormatPrice($aryOrderStatus[7]["PRICE"],2,$S_ST_CUR)?></td>
			</tr>
		</table>