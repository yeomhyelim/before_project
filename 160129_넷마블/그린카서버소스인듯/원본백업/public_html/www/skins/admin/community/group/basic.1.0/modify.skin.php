	<h3>그룹 수정</h3>
	
	<table>
		</tr>
			<th> 그룹명 </th>
			<td style="text-align:left;padding-left:10px;">
				<input type="text" name="bg_name" id="bg_name" value="<?=$groupSelectRow['BG_NAME']?>"/></td>
		</tr>
		<tr>
			<th> 대표이미지 </th>
			<td style="text-align:left;padding-left:10px;">
				<input type="file" <?=$nBox?> id="bg_file1" name="bg_file1" style="height:20px;" onchange="fileUpload(this)"/>
				<input type="checkbox" id="bg_file1_del" name="bg_file1_del" value="Y"/> 기존 이미지 삭제
				<? if($groupSelectRow['BG_FILE1']): ?>
				<img src="<?=$_REQUEST['bg_file1_wpath'].$groupSelectRow['BG_FILE1']?>"/>
				<? endif;?>
			</td>
		</tr>
		<tr>
			<th> 서브이미지 </th>
			<td style="text-align:left;padding-left:10px;">
				<input type="file" <?=$nBox?> id="bg_file2" name="bg_file2" style="height:20px;" onchange="fileUpload(this)"/>
				<input type="checkbox" id="bg_file2_del" name="bg_file2_del" value="Y"/> 기존 이미지 삭제
				<? if($groupSelectRow['BG_FILE2']): ?>
				<img src="<?=$_REQUEST['bg_file2_wpath'].$groupSelectRow['BG_FILE2']?>"/>
				<? endif;?>
			</td>
		</tr>
	</table>

	<br>

	<a href="javascript:goGroupModifyAct()" class="btn_blue_big"  id="menu_auth_m" style="display:none"><strong>그룹 수정</strong></a>
	<a href="javascript:goGroupListMove()" class="btn_blue_big" ><strong>취소</strong></a>