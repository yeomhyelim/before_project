<?
	## 설정
	$commentListResult					= $_REQUEST['result']['CommentMgr'];
?>

<table id="commentList_Table">
		<colgroup>
			<col width=40/>
			<col width=40/>
			<col width=120/>
			<col />
			<col width=80/>
			<col width=80/>
			<col width=80/>
			<col width=80/>
			<col width=130/>
		</colgroup>
		<tr>
			<th><input type="checkbox" id="checkAll"></th>
			<th>번호</th>
			<th>참여자</th>
			<th>참여내용</th>
			<th>포인트</th>
			<th>쿠폰</th>
			<th>참여횟수</th>
			<th>당첨횟수</th>
			<th>작성일자</th>
		</tr>
		<?if($_REQUEST['list_total']['CommentMgr'] <= 0):?>
		<tr>
			<td colspan="7">등록된 정보가 없습니다.</td>
		</tr>
		<?else: 
			$commentView		= new CommunityCommentView($db, $_REQUEST);
			while($row = mysql_fetch_array($commentListResult)) : 
				$aryFunc		= $commentView->getCM_FUNC_DECODER($row); 
				$lock			= $commentView->getLockAuthCheck($row);
				$intHidden		= $_REQUEST['BOARD_INFO']['bi_datalist_writer_hidden'];
				if($intHidden):
					$row['CM_NAME']	= mb_substr($row['CM_NAME'], 0, $intHidden, "UTF-8");
					$row['CM_NAME']	= str_pad($row['CM_NAME'], ($intHidden+3), "*");
					$row['CM_M_ID']	= mb_substr($row['CM_M_ID'], 0, $intHidden, "UTF-8");
					$row['CM_M_ID']	= str_pad($row['CM_M_ID'], ($intHidden+3), "*");
				endif;
		   ?>
		<tr>
			<td><input type="checkbox" name="check[]" id="check" value="<?=$row['CM_NO']?>"></td>
			<td><?=$_REQUEST['list_total']['CommentMgr']--?></td>
			<td><?=$row['CM_NAME']?>(<?=$row['CM_M_ID']?>)</td>
			<td>
			<?=strConvertCut($row['CM_TITLE'],0,"N")?><br>
			<?if($_REQUEST['BOARD_INFO']['bi_datawrite_form'] == "higheditor_full"):?>
				<?=strConvertCut($row['CM_TEXT'],0,"Y")?>
			<?else:?>
				<?=strConvertCut($row['CM_TEXT'],0,"N")?>
			<?endif;?>
			</td>
			<td><?=$row['PT_POINT']?></td>
			<td><?=$row['CM_CI_NO']?></td>
			<td><?=$row['CM_PART_CNT']?></td>
			<td><?=$row['CM_WIN_CNT']?></td>
			<td><?=date("Y.m.d", strtotime($row['CM_REG_DT']))?></td>
		</tr>
		<? endwhile; 
		   endif; ?>
</table>