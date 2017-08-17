	<table>
		<?for($i=0;$i<$_REQUEST['BOARD_INFO']['bi_attachedfile_use'];$i++):?>
		<tr>
			<th><?=$_REQUEST['BOARD_INFO']['bi_attachedfile_name'][$i]?></th>
			<td>
				<input type="file" name="file[]" <?=$nBox?>   />
				<input type="hidden" name="key[]"  value="<?=$_REQUEST['BOARD_INFO']['bi_attachedfile_key'][$i]?>"  />
			</td>
		</tr>
		<?endfor;?>
	</table>