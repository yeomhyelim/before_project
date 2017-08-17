<?
	## 설정
	$listImg		= "";
	$result			= $_REQUEST['result'][$tableName]['listResult'];
	$list_total		= $_REQUEST['result'][$tableName]['pageResult']['list_total'];
	$list_num		= $_REQUEST['result'][$tableName]['pageResult']['list_num'];
	if($_REQUEST['BOARD_INFO']['bi_attachedfile_use']):
		if(in_array("listImage", $_REQUEST['BOARD_INFO']['bi_attachedfile_key'])) { $listImg = 1; } /* 리스트 이미지 사용 할 때 */
	endif;
?>
	<table>
		<colgroup>
			<!--col width=40/-->
			<col width=40/>
			<col />
			<col width=80/>
			<col width=100/>
			<col width=60/>
		</colgroup>
		<tr>
			<!--th><input type="checkbox"></th-->
			<th>번호</th>
			<th>제목</th>
			<th>시작일</th>
			<th>종료일</th>
			<th>조회수</th>
		</tr>
		<? if($list_total <= 0) : ?>
		<tr>
			<td colspan="6">등록된 내용이 없습니다.</td>
		</tr>
		<? else: 
		   while($row = mysql_fetch_array($result)) :

			 
		?>
		<tr>
			<!--td><input type="checkbox"></td-->
			<td><?=$dataView->field['list_num']--?></td>
			<td style="text-align:left;padding-left:10px;">
				<a href="javascript:goDataViewMoveEvent('<?=$row['UB_NO']?>')">
					
					<?=strConvertCut($row['UB_TITLE'],42,'N')?>
				</a>
			</td>
			<td><?=(SUBSTR($row['UB_EVENT_S_DT'],0,4)!="0000")?date("Y-m-d", strtotime($row['UB_EVENT_S_DT'])):"";?></td>
			<td><?=(SUBSTR($row['UB_EVENT_E_DT'],0,4)!="0000")?date("Y-m-d", strtotime($row['UB_EVENT_E_DT'])):"";?></td>
			<td><?=NUMBER_FORMAT($row['UB_READ'])?></td>
		</tr>
		<? endwhile; 
		   endif; ?>
	</table>
