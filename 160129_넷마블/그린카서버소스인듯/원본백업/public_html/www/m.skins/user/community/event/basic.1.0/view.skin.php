<?
	## 설정
	$dataSelectRow					= $_REQUEST['result']['DataMgr'];
	$attachedfileViewListResult		= $_REQUEST['result']['AttachedfileMgr'];
	##이름, 아이디 숨김 처림.
	$intHidden						= $_REQUEST['BOARD_INFO']['bi_datalist_writer_hidden'];
	if($intHidden):
	   $dataSelectRow['UB_NAME']	= mb_substr($dataSelectRow['UB_NAME'], 0, $intHidden, "UTF-8");
	   for($i=0;$i<3;$i++) { $dataSelectRow['UB_NAME'] .= "*"; }
	   $dataSelectRow['UB_M_ID']	= mb_substr($dataSelectRow['UB_M_ID'], 0, $intHidden, "UTF-8");
	   for($i=0;$i<3;$i++) { $dataSelectRow['UB_M_ID'] .= "*"; }
	endif;
?>

	<table>		
		<tr>
			<th>제목</th>
			<td colspan="3">
				<?=stripslashes($dataSelectRow['UB_TITLE'])?>
			</td>
		</tr>
		<tr>
			<th>기간</th>
			<td colspan="3">
				<?=(SUBSTR($dataSelectRow['UB_EVENT_S_DT'],0,4)!="0000")?date("Y년m월d일", strtotime($dataSelectRow['UB_EVENT_S_DT'])):"";?> ~ <?=(SUBSTR($dataSelectRow['UB_EVENT_E_DT'],0,4)!="0000")?date("Y년m월d일", strtotime($dataSelectRow['UB_EVENT_E_DT'])):"";?> 까지
			</td>
		</tr>
		<tr>
			<th>작성자 </th>
			<td>
				<?=$dataSelectRow['UB_NAME']?> 
				<?//if($dataSelectRow['UB_M_ID']) { echo "({$dataSelectRow['UB_M_ID']})"; }
				  //else { echo "(비회원)"; } ?>
			</td>
			<th>작성일</th>
			<td>
				<?=date("Y-m-d H:i:d", strtotime($dataSelectRow['UB_REG_DT']))?>
			</td>
		</tr>
	</table>
	<div>
		<?=stripslashes($dataSelectRow['UB_TEXT_MOBILE'])?>
	</div>
