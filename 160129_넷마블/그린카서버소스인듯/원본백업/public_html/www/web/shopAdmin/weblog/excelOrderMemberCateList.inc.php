		<table border="1">
			<tr>
				<th rowspan="2">소속1</th>
				<th rowspan="2">소속2</th>
				<th rowspan="2">총매출액</th>
				<th colspan="2">주문완료</th>
				<th colspan="2">결제완료</th>
				<th colspan="2">배송준비중</th>
				<th colspan="2">배송중</th>
				<th colspan="2">배송완료</th>
				<th colspan="2">구매완료</th>
				<th colspan="2">주문취소</th>
			</tr>
			<tr>
				<th>건수</th>
				<th>금액</th>
				<th>건수</th>
				<th>금액</th>
				<th>건수</th>
				<th>금액</th>
				<th>건수</th>
				<th>금액</th>
				<th>건수</th>
				<th>금액</th>
				<th>건수</th>
				<th>금액</th>
				<th>건수</th>
				<th>금액</th>
			</tr>
			<?
			if (is_array($aryOrderSaleList)){

				$aryOrderStatus['J']['CNT']		= 0;
				$aryOrderStatus['J']['PRICE']	= 0;

				$aryOrderStatus['A']['CNT']		= 0;
				$aryOrderStatus['A']['PRICE']	= 0;

				$aryOrderStatus['B']['CNT']		= 0;
				$aryOrderStatus['B']['PRICE']	= 0;

				$aryOrderStatus['I']['CNT']		= 0;
				$aryOrderStatus['I']['PRICE']	= 0;

				$aryOrderStatus['D']['CNT']		= 0;
				$aryOrderStatus['D']['PRICE']	= 0;

				$aryOrderStatus['E']['CNT']		= 0;
				$aryOrderStatus['E']['PRICE']	= 0;

				$aryOrderStatus['C']['CNT']		= 0;
				$aryOrderStatus['C']['PRICE']	= 0;

				$intOrderAllTotalPrice			= 0;

				for($i=0;$i<sizeof($aryOrderSaleList);$i++){

					$intOrderTotalPrice				= 0;
					$intOrderTotalPrice				= ($aryOrderSaleList[$i][O_STATUS_PRICE2] + $aryOrderSaleList[$i][O_STATUS_PRICE3] +
						$aryOrderSaleList[$i][O_STATUS_PRICE4] + $aryOrderSaleList[$i][O_STATUS_PRICE5] + $aryOrderSaleList[$i][O_STATUS_PRICE6]);
					
					if ($aryOrderSaleList[$i][C_LEVEL] > 1) {

						$intOrderAllTotalPrice		   += ($aryOrderSaleList[$i][O_STATUS_PRICE2] + $aryOrderSaleList[$i][O_STATUS_PRICE3] +
						$aryOrderSaleList[$i][O_STATUS_PRICE4] + $aryOrderSaleList[$i][O_STATUS_PRICE5] + $aryOrderSaleList[$i][O_STATUS_PRICE6]);

						$aryOrderStatus['J']['CNT']		= $aryOrderStatus['J']['CNT']   + $aryOrderSaleList[$i][O_STATUS_CNT1];
						$aryOrderStatus['J']['PRICE']	= $aryOrderStatus['J']['PRICE'] + $aryOrderSaleList[$i][O_STATUS_PRICE1];

						$aryOrderStatus['A']['CNT']		= $aryOrderStatus['A']['CNT']   + $aryOrderSaleList[$i][O_STATUS_CNT2];
						$aryOrderStatus['A']['PRICE']	= $aryOrderStatus['A']['PRICE'] + $aryOrderSaleList[$i][O_STATUS_PRICE2];

						$aryOrderStatus['B']['CNT']		= $aryOrderStatus['B']['CNT']   + $aryOrderSaleList[$i][O_STATUS_CNT3];
						$aryOrderStatus['B']['PRICE']	= $aryOrderStatus['B']['PRICE'] + $aryOrderSaleList[$i][O_STATUS_PRICE3];

						$aryOrderStatus['I']['CNT']		= $aryOrderStatus['I']['CNT']   + $aryOrderSaleList[$i][O_STATUS_CNT4];
						$aryOrderStatus['I']['PRICE']	= $aryOrderStatus['I']['PRICE'] + $aryOrderSaleList[$i][O_STATUS_PRICE4];

						$aryOrderStatus['D']['CNT']		= $aryOrderStatus['D']['CNT']   + $aryOrderSaleList[$i][O_STATUS_CNT5];
						$aryOrderStatus['D']['PRICE']	= $aryOrderStatus['D']['PRICE'] + $aryOrderSaleList[$i][O_STATUS_PRICE5];

						$aryOrderStatus['E']['CNT']		= $aryOrderStatus['E']['CNT']   + $aryOrderSaleList[$i][O_STATUS_CNT6];
						$aryOrderStatus['E']['PRICE']	= $aryOrderStatus['E']['PRICE'] + $aryOrderSaleList[$i][O_STATUS_PRICE6];

						$aryOrderStatus['C']['CNT']		= $aryOrderStatus['C']['CNT']   + $aryOrderSaleList[$i][O_STATUS_CNT7];
						$aryOrderStatus['C']['PRICE']	= $aryOrderStatus['C']['PRICE'] + $aryOrderSaleList[$i][O_STATUS_PRICE7];
					}

					?>
			<tr>
				<td style="text-align:left"><?=($aryOrderSaleList[$i][C_LEVEL] == 1) ? $aryOrderSaleList[$i][C_NAME] : "";?></td>
				<td style="text-align:left"><?=($aryOrderSaleList[$i][C_LEVEL] == 2) ? $aryOrderSaleList[$i][C_NAME] : "";?></td>
				<td><?=getFormatPrice($intOrderTotalPrice,2,$S_ST_CUR)?></td>
				<td><?=NUMBER_FORMAT($aryOrderSaleList[$i][O_STATUS_CNT1])?></td>
				<td><?=getFormatPrice($aryOrderSaleList[$i][O_STATUS_PRICE1],2,$S_ST_CUR)?></td>
				<td><?=NUMBER_FORMAT($aryOrderSaleList[$i][O_STATUS_CNT2])?></td>
				<td><?=getFormatPrice($aryOrderSaleList[$i][O_STATUS_PRICE2],2,$S_ST_CUR)?></td>
				<td><?=NUMBER_FORMAT($aryOrderSaleList[$i][O_STATUS_CNT3])?></td>
				<td><?=getFormatPrice($aryOrderSaleList[$i][O_STATUS_PRICE3],2,$S_ST_CUR)?></td>
				<td><?=NUMBER_FORMAT($aryOrderSaleList[$i][O_STATUS_CNT4])?></td>
				<td><?=getFormatPrice($aryOrderSaleList[$i][O_STATUS_PRICE4],2,$S_ST_CUR)?></td>
				<td><?=NUMBER_FORMAT($aryOrderSaleList[$i][O_STATUS_CNT5])?></td>
				<td><?=getFormatPrice($aryOrderSaleList[$i][O_STATUS_PRICE5],2,$S_ST_CUR)?></td>
				<td><?=NUMBER_FORMAT($aryOrderSaleList[$i][O_STATUS_CNT6])?></td>
				<td><?=getFormatPrice($aryOrderSaleList[$i][O_STATUS_PRICE6],2,$S_ST_CUR)?></td>
				<td><?=NUMBER_FORMAT($aryOrderSaleList[$i][O_STATUS_CNT7])?></td>
				<td><?=getFormatPrice($aryOrderSaleList[$i][O_STATUS_PRICE7],2,$S_ST_CUR)?></td>
			</tr>
					<?
				}
			}
			?>
			<tr>
				<td colspan="2"><?=$LNG_TRANS_CHAR["EW00079"] //합계?></td>
				<td><?=getFormatPrice($intOrderAllTotalPrice,2,$S_ST_CUR)?></td>												
				<td><?=NUMBER_FORMAT($aryOrderStatus['J']['CNT'])?></td>
				<td><?=getFormatPrice($aryOrderStatus['J']['PRICE'],2,$S_ST_CUR)?></td>
				<td><?=NUMBER_FORMAT($aryOrderStatus['A']['CNT'])?></td>
				<td><?=getFormatPrice($aryOrderStatus['A']['PRICE'],2,$S_ST_CUR)?></td>
				<td><?=NUMBER_FORMAT($aryOrderStatus['B']['CNT'])?></td>
				<td><?=getFormatPrice($aryOrderStatus['B']['PRICE'],2,$S_ST_CUR)?></td>
				<td><?=NUMBER_FORMAT($aryOrderStatus['I']['CNT'])?></td>
				<td><?=getFormatPrice($aryOrderStatus['I']['PRICE'],2,$S_ST_CUR)?></td>
				<td><?=NUMBER_FORMAT($aryOrderStatus['D']['CNT'])?></td>
				<td><?=getFormatPrice($aryOrderStatus['D']['PRICE'],2,$S_ST_CUR)?></td>
				<td><?=NUMBER_FORMAT($aryOrderStatus['E']['CNT'])?></td>
				<td><?=getFormatPrice($aryOrderStatus['E']['PRICE'],2,$S_ST_CUR)?></td>
				<td><?=NUMBER_FORMAT($aryOrderStatus['C']['CNT'])?></td>
				<td><?=getFormatPrice($aryOrderStatus['C']['PRICE'],2,$S_ST_CUR)?></td>
			</tr>
		</table>