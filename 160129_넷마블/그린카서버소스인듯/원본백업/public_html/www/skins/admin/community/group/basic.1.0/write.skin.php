	<h3>그룹 등록</h3>
	
	<table>
		</tr>
			<th> 그룹명 </th>
			<td style="text-align:left;padding-left:10px;">
				<input type="text" name="bg_name" id="bg_name" value="<?=$boardGroupRow['BG_NAME']?>"/></td>
		</tr>
		<tr>
			<th> 대표이미지 </th>
			<td style="text-align:left;padding-left:10px;">
				<input type="file" <?=$nBox?> id="bg_file1" name="bg_file1" style="height:20px;" onchange="fileUpload(this)"/><?=$strFileHtml1?>
				<input type="checkbox" id="bg_file1_del" name="bg_file1_del" value="Y"/> 기존 이미지 삭제
			</td>
		</tr>
		<tr>
			<th> 서브이미지 </th>
			<td style="text-align:left;padding-left:10px;">
				<input type="file" <?=$nBox?> id="bg_file2" name="bg_file2" style="height:20px;" onchange="fileUpload(this)"/><?=$strFileHtml2?>
				<input type="checkbox" id="bg_file2_del" name="bg_file2_del" value="Y"/> 기존 이미지 삭제
			</td>
		</tr>
	</table>

	<br>

	<a href="javascript:goGroupWriteAct()" class="btn_blue_big"  id="menu_auth_w" style="display:none"><strong>그룹 생성</strong></a>