	<table style="border-left:1px solid #D2D0D0">
		<colgroup>
			<col width=40/>
			<col width=120/>
			<col />
			<col width=80/>
			<col width=100/>
			<col width=130/>
			<col width=100/>
		</colgroup>
		<tr>
			<th>번호</th>
			<th>코드</th>
			<th>제목</th>
			<th>그룹</th>
			<th>종류</th>
			<th>스킨</th>
			<th>관리</th>
		</tr>
		<? if($boardView->field['list_total'] <= 0) : ?>
		<tr>
			<td colspan="7">등록된 내용이 없습니다.</td>
		</tr>
		<? else: 
		   while($row = mysql_fetch_array($boardListResult)) : ?>
		<tr>
			<td><?=$boardView->field['list_total']--?></td>
			<td><?=$row['B_CODE']?></td>
			<td style="text-align:left;padding-left:10px;">이름 : <?=$row['B_NAME']?><br>
														   링크 : <a href="<?="http://{$S_HTTP_HOST}/{$S_SITE_LNG_PATH}/?menuType=community&b_code={$row['B_CODE']}"?>" target="_blank">
																  <?="http://{$S_HTTP_HOST}/{$S_SITE_LNG_PATH}/?menuType=community&b_code={$row['B_CODE']}"?></a></td>
			<td><?=($row['BG_NAME']) ? $row['BG_NAME'] : "-";?></td>
			<td><?=$row['B_KIND']?></td>
			<td><?=$row['B_SKIN']?></td>
			<td><a href="javascript:goBoardModifyMove('<?=$row['B_CODE']?>')" class="btn_blue_sml" id="menu_auth_m" style=""><strong>설정</strong></a>
				<a href="javascript:goBoardStopAct('<?=$row['B_CODE']?>')" class="btn_blue_sml" id="menu_auth_m" style=""><strong>정지</strong></a></td>
		</tr>
		<? endwhile; 
		   endif; ?>
	</table>
