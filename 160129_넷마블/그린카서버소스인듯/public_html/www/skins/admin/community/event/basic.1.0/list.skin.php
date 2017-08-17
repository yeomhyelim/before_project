<?
	## 설정
	$result			= $_REQUEST['result']['DataMgr']['listResult'];
	$list_total		= $_REQUEST['result']['DataMgr']['pageResult']['list_total'];
?>
	<table style="border-left:1px solid #D2D0D0">
		<colgroup>
			<col width=40/>
			<col width=60/>
			<col width=100/>
			<col />
			<col width=100/>
			<col width=100/>
		</colgroup>
		<tr>
			<th><input type="checkbox" id="checkAll"></th>
			<th>번호</th>
			<th>이미지</th>
			<th>제목</th>
			<th>등록일</th>
			<th>조회수</th>
		</tr>
		<? if($list_total <= 0) : ?>
		<tr>
			<td colspan="6">등록된 내용이 없습니다.</td>
		</tr>
		<? else: 
		   while($row = mysql_fetch_array($result)) : ?>
		   		   <?//print_r($row['UB_EVENT_S_DT']);?>
		<tr>
			<td><input type="checkbox" name="check[]" id="check" value="<?=$row['UB_NO']?>"></td>
			<td><?=$dataView->field['list_num']--?></td>
			<td><img src="<?=$row['FL_DIR'].$row['FL_NAME']?>" style="width:100px"></td>
			<td style="text-align:left;padding-left:10px;">
				<a href="javascript:goDataViewMove2('<?=$row['UB_NO']?>')">
				<li>기간 : <?=date("Y-m-d", strtotime($row['UB_EVENT_S_DT']))?> 부터 <?=date("Y-m-d", strtotime($row['UB_EVENT_E_DT']))?> 까지
				<li>제목 : <?=$row['UB_TITLE']?></li>
				<li>설명 : <?=$row['UB_EXPLAIN']?></li>
				</a>
			</td>
			<td><?=date("Y-m-d", strtotime($row['UB_REG_DT']))?></td>
			<td><?=$row['UB_READ']?></td>
		</tr>
		<? endwhile; 
		   endif; ?>
	</table>
