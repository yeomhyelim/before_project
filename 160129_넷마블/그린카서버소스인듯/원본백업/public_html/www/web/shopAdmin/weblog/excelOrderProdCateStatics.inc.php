		<table border="1">
			<tr>
				<th><?=$LNG_TRANS_CHAR["EW00074"] //카테고리명?></th>
				<th><?=$LNG_TRANS_CHAR["EW00075"] //주문수?></th>
				<th><?=$LNG_TRANS_CHAR["EW00076"] //주문수량?></th>
				<th><?=$LNG_TRANS_CHAR["EW00060"] //매출금액?></th>
			</tr>
			<?
			$intTotal = $intCateTotCnt = $intCateTotQty = 0;
			if (is_array($aryOrderProdCateList)){
				
				for($i=0;$i<sizeof($aryOrderProdCateList);$i++){
					$intCateTotCnt  += $aryOrderProdCateList[$i][CATE_CNT];
					$intCateTotQty  += $aryOrderProdCateList[$i][CATE_QTY];
					$intTotal		+= $aryOrderProdCateList[$i][CATE_PRICE];
					?>
			<tr>
				<td><?=$aryOrderProdCateList[$i][CATE_NAME]?></th>
				<td><?=NUMBER_FORMAT($aryOrderProdCateList[$i][CATE_CNT])?></td>
				<td><?=NUMBER_FORMAT($aryOrderProdCateList[$i][CATE_QTY])?></td>
				<td><?=getFormatPrice($aryOrderProdCateList[$i][CATE_PRICE],2,$S_ST_CUR)?></td>
			</tr>
					<?
				}
			}
			?>
			<tr>
				<td><?=$LNG_TRANS_CHAR["EW00079"] //합계?></td>
				<td><?=NUMBER_FORMAT($intCateTotCnt)?></td>
				<td><?=NUMBER_FORMAT($intCateTotQty)?></td>
				<td><?=getFormatPrice($intTotal,2,$S_ST_CUR)?></td>
			</tr>
		</table>