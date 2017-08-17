		<table id="dataEditList" border="1px">
			<?if(mysql_error()):?>
			<tr>
				<th></th>
			</tr>
			<tr>
				<td>문법 오류...</td>
			</tr>
			<?else:?>
			<tr>
				<?if(is_array($de_select_name)):?>
				<th>번호</th>
				<?foreach($de_select_name as $column):?>
				<th><?=$column?></th>
				<?endforeach;?>
				<?else:?>
				<th>컬럼명</th>
				<th>컬럼명</th>
				<th>컬럼명</th>
				<th>컬럼명</th>
				<?endif;?>
			</tr>
			<?while($row = mysql_fetch_array($result)):?>
			<tr><?if(is_array($de_select)):?>
				<td><?=$intTotal--?></td>
				<?foreach($de_select as $column):?>
				<td><?=$row[$column]?></td>
				<?endforeach;?>
				<?else:?>
				<td>데이타</td>
				<td>데이타</td>
				<td>데이타</td>
				<td>데이타</td>
				<?endif;?>
			</tr>
			<?endwhile;?>
			<?endif;?>
		</table>