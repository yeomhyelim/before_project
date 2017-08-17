	<table>
		<colgroup>
			<!--col width=40/-->
			<col width=120/>
			<col />
			<col width=80/>
			<col width=100/>
			<col width=100/>
		</colgroup>
		<tr>
			<!--th><input type="checkbox"></th-->
			<th>번호</th>
			<th>제목</th>
			<th>작성자</th>
			<th>작성일</th>
			<th>조회수</th>
		</tr>
		<? if($dataView->field['list_total'] <= 0) : ?>
		<tr>
			<td colspan="6">등록된 내용이 없습니다.</td>
		</tr>
		<? else: 
		   while($row = mysql_fetch_array($dataListResult)) :
			   $lock = $dataView->getLockCheck($row);
			   $step = "";
			   if($row['UB_ANS_STEP']):
				   $step = explode(",", $row['UB_ANS_STEP']);
				   $step = sizeof($step);
				   $step = str_pad("", $step, " ", STR_PAD_LEFT);	
				   $step = str_replace(" ", "&nbsp;", $step);
			   endif;
		?>
		<tr>
			<!--td><input type="checkbox"></td-->
			<td><?=$dataView->field['list_num']--?></td>
			<td style="text-align:left;padding-left:10px;">
				<a href="javascript:goDataViewMoveEvent('<?=$row['UB_NO']?>')">
					<?if($step): // 댓글깊이?><?=$step?><img src="/himg/board/A0001/icon_bbs_reply.png"><?endif;?>
					<?if($lock!="000"): // 비밀글?><img src="/himg/board/A0001/icon_bbs_lock.png"><?endif;?>
					<?=stripslashes($row['UB_TITLE'])?>
				</a>
			</td>
			<td><?=$row['UB_NAME']?></td>
			<td><?=date("Y-m-d", strtotime($row['UB_REG_DT']))?></td>
			<td><?=NUMBER_FORMAT($row['UB_READ'])?></td>
		</tr>
		<? endwhile; 
		   endif; ?>
	</table>
