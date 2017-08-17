<table border="1px">
	<colgroup>
		<col style="width:300px;"/>				
		<col />
		<col style="width:100px;background-color:#f1f7f9" />
	</colgroup>
	<tr>
		<th>KEYWORD</th>
		<th>접속자수</th>
	</tr>
	<?while($row = mysql_fetch_array($logRefererResult)):
		$barSize = $row['CNT'] * 1;
		if($barSize >= 1000) { $barSize = 1000; }		?>
	<tr>
		<td style="text-align:left"><?=strHanCutUtf2($row['KEYWORD'], 30)?></td>
		<td><?=$row['CNT']?></td>
	</tr>
	<?endwhile;?>
</table>