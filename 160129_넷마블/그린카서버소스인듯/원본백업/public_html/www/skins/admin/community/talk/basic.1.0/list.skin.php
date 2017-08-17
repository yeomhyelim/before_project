<?
	## 설정
	$result			= $_REQUEST['result']['DataMgr']['listResult'];
	$list_total		= $_REQUEST['result']['DataMgr']['pageResult']['list_total'];
	$list_num		= $_REQUEST['result']['DataMgr']['pageResult']['list_num'];
	$field_use		= $_REQUEST['BOARD_INFO']['bi_datalist_datalist_field_use'];
?>

	<table style="border-left:1px solid #D2D0D0">
		<colgroup>
			<col width=40/>
			<col width=40/>
			<col width=60/>
			<col />
			<col width=80/>
			<col width=100/>
		</colgroup>
		<tr>
			<th><input type="checkbox" id="checkAll"></th>
			<th>번호</th>
			<th>옵션</th>
			<th>토크</th>
			<th>작성자</th>
			<th>작성일</th>
		</tr>
		<? if($list_total <= 0) : ?>
		<tr>
			<td colspan="6">등록된 내용이 없습니다.</td>
		</tr>
		<? else: 
		   while($row = mysql_fetch_array($result)) : 
			$row['UB_FUNC'] = $dataView->getUB_FUNC_DECODER($row);					?>
		<tr>
			<td><input type="checkbox" name="check[]" id="check" value="<?=$row['UB_NO']?>"></td>
			<td><?=$list_num--?></td>
			<td>
				<?if($row['UB_FUNC']['UB_FUNC_NOTICE']=="Y")	{ echo "N"; }?>
				<?if($row['UB_FUNC']['UB_FUNC_LOCK']=="Y")		{ echo "L"; }?>
				<?if($row['UB_FUNC']['UB_FUNC_ICON']=="Y")		{ echo "I"; }?>
			</td>
			<td style="text-align:left;padding-left:10px;"><a href="javascript:goDataViewMove2('<?=$row['UB_NO']?>')"><?=$row['UB_TALK']?></a></td>
			<td><?=$row['UB_NAME']?></td>
			<td><?=date("Y-m-d", strtotime($row['UB_REG_DT']))?></td>
		</tr>
		<? endwhile; 
		   endif; ?>
	</table>