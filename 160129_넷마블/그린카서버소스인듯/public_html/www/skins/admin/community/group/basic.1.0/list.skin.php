	<h3>그룹 리스트</h3>

	<table style="border-left:1px solid #D2D0D0">
		<colgroup>
			<col width=40/>
			<col />
			<col />
			<col />
			<col />
			<col />
		</colgroup>
		<tr>
			<th>번호</th>
			<th>그룹명</th>
			<th>게시판 수</th>
			<th>대표 이미지</th>
			<th>서브 이미지</th>
			<th>관리</th>
		</tr>
		<? if($_REQUEST['list_total'] <= 0) : ?>
		<tr>
			<td colspan="6">등록된 내용이 없습니다.</td>
		</tr>
		<? else: ?>
		<? while($row = mysql_fetch_array($groupListResult)) : 
			$row['BG_FILE1']		= ($row['BG_FILE1']) ? sprintf("<img src=\"%s\"/>", $groupView->field['bg_file1_wpath'] . $row['BG_FILE1']) : "-";
			$row['BG_FILE2']		= ($row['BG_FILE2']) ? sprintf("<img src=\"%s\"/>", $groupView->field['bg_file1_wpath'] . $row['BG_FILE2']) : "-";				?>
		<tr>
			<td><?=$groupView->field['list_num']--?></td>
			<td><?=$row['BG_NAME']?></td>
			<td><?=$row['B_GRP_NO']?></td>
			<td><?=$row['BG_FILE1']?></td>
			<td><?=$row['BG_FILE2']?></td>
			<td>
				<a href="javascript:goGroupModifyMove('<?=$row['BG_NO']?>');" class="btn_blue_sml" id="menu_auth_m" style="display:none"><strong>수정</strong></a>
				<a href="javascript:goGroupDeleteAct('<?=$row['BG_NO']?>');"  class="btn_sml" id="menu_auth_d" style="display:none"><strong>삭제</strong></a>
			</td>
		</tr>
		<? endwhile; ?>
		<? endif; ?>
	</table>

