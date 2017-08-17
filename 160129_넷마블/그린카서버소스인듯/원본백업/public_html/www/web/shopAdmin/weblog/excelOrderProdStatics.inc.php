		<table border="1">
			<tr>
				<th><?=$LNG_TRANS_CHAR["EW00077"] //상품명?></th>
				<th><?=$LNG_TRANS_CHAR["EW00075"] //주문수?></th>
				<th><?=$LNG_TRANS_CHAR["EW00076"] //주문수량?></th>
				<th><?=$LNG_TRANS_CHAR["EW00060"] //매출금액?></th>
			</tr>
			<?
			$intTotal = $intOrderTotCnt = $intOrderTotQty = 0;
			if (is_array($aryOrderProdList)){
				
				for($i=0;$i<sizeof($aryOrderProdList);$i++){
					$intOrderTotCnt  += $aryOrderProdList[$i][P_CNT];
					$intOrderTotQty  += $aryOrderProdList[$i][P_QTY];
					$intTotal        += $aryOrderProdList[$i][P_PRICE];
					?>
			<tr>
				<td><?=$aryOrderProdList[$i][P_NAME]?></th>
				<td><?=NUMBER_FORMAT($aryOrderProdList[$i][P_CNT])?></td>
				<td><?=NUMBER_FORMAT($aryOrderProdList[$i][P_QTY])?></td>
				<td><?=NUMBER_FORMAT($aryOrderProdList[$i][P_PRICE])?></td>
			</tr>
					<?
				}
			}
			?>
			<tr>
				<td><?=$LNG_TRANS_CHAR["EW00079"] //합계?></td>
				<td><?=NUMBER_FORMAT($intOrderTotCnt)?></td>
				<td><?=NUMBER_FORMAT($intOrderTotQty)?></td>
				<td><?=NUMBER_FORMAT($intTotal)?></td>
			</tr>
		</table>