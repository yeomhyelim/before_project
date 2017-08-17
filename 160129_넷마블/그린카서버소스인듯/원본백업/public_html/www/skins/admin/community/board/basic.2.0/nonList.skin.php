	<table>
		<colgroup>
			<col width=40/>
			<col width=60/>
			<col />
			<col width=100/>
		</colgroup>
		<tr>
			<th>번호</th>
			<th colspan="2">게시판정보</th>
			<th>관리</th>
		</tr>
		<? if($boardView->field['list_total']['BoardMgr'] <= 0) : ?>
		<tr>
			<td colspan="7">등록된 내용이 없습니다.</td>
		</tr>
		<? else: 
		   while($row = mysql_fetch_array($boardListResult)) : ?>
		<tr>
			<td><?=$boardView->field['list_total']['BoardMgr']--?></td>
			<td  class="vTop noRboder">
				<img src="/shopAdmin/himg/layout/sample/board_type_<?=$row['B_KIND']?>_<?=$row['B_SKIN']?>.gif">
				<?//=$row['B_KIND']?>
			</td>
			<td class="alignLeft">
				<ul class="inTdUlList">
					<li><span>타이틀</span>: <strong><?=$row['B_NAME']?></strong></li>
					<li><span>관리그룹</span>: <?=($row['BG_NAME']) ? $row['BG_NAME'] : "-";?></li>
					<li><span>코드명</span>: <?=$row['B_CODE']?></li>
					<li><span>디자인</span>: <?=$row['B_SKIN']?></li>
					<li><span></span><a href="<?="http://{$S_HTTP_HOST}/{$S_SITE_LNG_PATH}/?menuType=community&b_code={$row['B_CODE']}"?>" target="_blank" class="btn_sml"><strong style="font-weight:normal;">게시판 보기 ></strong></a></li>
				</ul>
			</td>
			<td><a href="javascript:goBoardStartActEvent('<?=$row['B_CODE']?>')" class="btn_blue_sml" id="menu_auth_m"><strong>운영복구</strong></a>
				<a href="javascript:goBoardDeleteActEvent('<?=$row['B_CODE']?>')" class="btn_sml" id="menu_auth_m"><strong>완전삭제</strong></a></td>
		</tr>
		<? endwhile; 
		   endif; ?>
	</table>
