		<table border="1">
			<tr>
				<th><?=$LNG_TRANS_CHAR["EW00077"] //상품명?></th>
				<th><?="수량" //수량?></th>
				<th><?=$LNG_TRANS_CHAR["EW00060"] //매출금액?></th>
			</tr>
			<?
			$intTotal = $intProdQty = 0;
			if (is_array($aryOrderProdList)){
				
				for($i=0;$i<sizeof($aryOrderProdList);$i++){
					$intProdQty += $aryOrderProdList[$i][P_QTY];
					$intTotal += $aryOrderProdList[$i][P_PRICE];
					?>
			<tr>
				<td><?=$aryOrderProdList[$i][P_NAME]?></th>
				<td><?=NUMBER_FORMAT($aryOrderProdList[$i][P_QTY])?></td>
				<td><?=getFormatPrice($aryOrderProdList[$i][P_PRICE],2,$S_ST_CUR)?></td>
			</tr>
					<?
				}
			}
			?>
			<tr>
				<td><?=$LNG_TRANS_CHAR["EW00079"] //합계?></td>
				<td><?=NUMBER_FORMAT($intProdQty)?></td>
				<td><?=getFormatPrice($intTotal,2,$S_ST_CUR)?></td>
			</tr>
		</table>
