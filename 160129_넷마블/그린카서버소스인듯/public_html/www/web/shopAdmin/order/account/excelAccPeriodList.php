<table border="1">
	<colgroup>
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
	</colgroup>
	<tr>
		<th><?=getEuckrString($LNG_TRANS_CHAR["CW00009"]) //번호?></th>
		<th><?=getEuckrString($LNG_TRANS_CHAR["OW00096"]) //업체명?></th>
		<th><?=getEuckrString($LNG_TRANS_CHAR["OW00105"]) //판매건수?></th>
		<th><?=getEuckrString($LNG_TRANS_CHAR["OW00106"]) //판매수량?></th>
		<th>총입고가</th>
		<th>총판매가</th>
		<th>총배송비</th>
		<th>총정산금액</th>
		<th>총수수료</th>	
	</tr>
	<?if ($intTotal == 0){?>
	<tr>
		<td colspan="9"><?=getEuckrString($LNG_TRANS_CHAR["CS00001"])?></td>
	</tr>
	<?}else{
		while($row = mysql_fetch_array($result)){
			
			if (!$row['SH_COM_NAME']) $row['SH_COM_NAME'] = "본사";

			#총수수료
			$intTotOrderAccFeePrice = $row[TOT_SPRICE] - $row[TOT_APRICE];
		?>
	<tr>
		<td><?=$intListNum?></td>
		<td><?=getEuckrString($row[SH_COM_NAME])?></td>
		<td><?=NUMBER_FORMAT($row[TOT_CNT])?></td>
		<td><?=NUMBER_FORMAT($row[TOT_QTY])?></td>
		<td><?=getFormatPrice($row[TOT_PRICE])?></td>
		<td><?=getFormatPrice($row[TOT_SPRICE])?></td>
		<td><?=getFormatPrice($row[TOT_BPRICE])?></td>
		<td><?=getFormatPrice($row[TOT_APRICE]+$row[TOT_BPRICE])?></td>
		<td><?=getFormatPrice($intTotOrderAccFeePrice)?></td>
	</tr>
	<?
			$intListNum++;
		}
	}
	?>
</table>