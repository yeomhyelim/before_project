<table border="1">
	<tr>
		<th><?=iconv("utf-8","euc-kr",$LNG_TRANS_CHAR["OW00002"])?></th>
		<th><?=iconv("utf-8","euc-kr",$LNG_TRANS_CHAR["OW00053"])?></th>
		<th><?=iconv("utf-8","euc-kr",$LNG_TRANS_CHAR["OW00090"])?></th>
	</tr>
	<?if ($intTotal == 0){?>
	<tr>
		<td colspan="35"><?=iconv("utf-8","euc-kr",$LNG_TRANS_CHAR["CS00001"])?></td>
	</tr>
	<?}else{
		$index = 1;
		while($row = mysql_fetch_array($result)){

		?>
	<tr>
		<td><?=$row[O_KEY]?></td>
		<td></td>
		<td></td>
	</tr>
	<?}}?>
</table>