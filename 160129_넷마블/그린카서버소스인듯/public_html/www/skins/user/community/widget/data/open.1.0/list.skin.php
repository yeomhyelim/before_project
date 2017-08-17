<?
	## 설정
	$result			= $_REQUEST['result']['DataMgr']['listResult'];
	$list_total		= $_REQUEST['result']['DataMgr']['pageResult']['list_total'];
	$list_num		= $_REQUEST['result']['DataMgr']['pageResult']['list_num'];
?>

<table id="data_<?=$_REQUEST['BOARD_INFO']['b_code']?>">
	<tr>
		<th><span class="title">제목</span></th>
		<th class="typeDiv"><span class="type">구분</span></th>
		<?if($_REQUEST['BOARD_INFO']['bi_widget_datalist_field_use'][4]!="N"):?>
		<!--점수--><th>점수</th>
		<?endif;?>
	</tr>
		<? if($list_total <= 0) : ?>
		<tr>
			<td colspan="3" class="noData">등록된 내용이 없습니다.</td>
		</tr>
		<? else: 
		   while($row = mysql_fetch_array($result)) :
			   $aryFunc			= $dataView->getUB_FUNC_DECODER($row);
			   $lock			= $dataView->getLockAuthCheck($row);
			   $intHidden		= $_REQUEST['BOARD_INFO']['bi_datalist_writer_hidden'];
			   if($intHidden):
				   $row['UB_NAME']	= mb_substr($row['UB_NAME'], 0, $intHidden, "UTF-8");
				   $row['UB_NAME']	= str_pad($row['UB_NAME'], ($intHidden+3), "*");
				   $row['UB_M_ID']	= mb_substr($row['UB_M_ID'], 0, $intHidden, "UTF-8");
				   $row['UB_M_ID']	= str_pad($row['UB_M_ID'], ($intHidden+3), "*");
			   endif;
			   /*답변 관련*/
//			   if($_REQUEST['buttonLock']['dataAnswer']):
				   $step = "";
				   if($row['UB_ANS_STEP']):
					   $step = explode(",", $row['UB_ANS_STEP']);
					   $step = sizeof($step);
					   $step = str_pad("", $step, " ", STR_PAD_LEFT);	
					   $step = str_replace(" ", "&nbsp;", $step);
				   endif;
//				endif;
			   /*답변 관련*/
		?>
		<tr id="dataList_<?=$row['UB_NO']?>">
			<td class="Qlist">
				<?if($step): // 답변깊이?><?=$step?><img src="/himg/board/A0001/icon_bbs_reply.png"><?endif;?>
				<?if($aryFunc['UB_FUNC_NOTICE']=="Y"): // 공지글?><img src="/himg/board/A0001/icon_bbs_notice.png"><?endif;?>
				<?if($lock['member'] == 1 && $lock['check'] == 0 && $aryFunc['UB_FUNC_LOCK']=="Y"): // 회원글 비밀글?>
					<a href="javascript:alert('권한이 없습니다.')"><img src="/himg/board/A0001/icon_bbs_lock.png"><?=strConvertCut($row['UB_TITLE'],50,'N')?></a>
				<?else:?>
					<a href="javascript:goWidgetOpenMoveEvent('<?=$_REQUEST['b_code']?>','<?=$row['UB_NO']?>')">
						<?if($aryFunc['UB_FUNC_LOCK']=="Y"): // 비밀글?><img src="/himg/board/A0001/icon_bbs_lock.png"><?endif;?>
						<?=strConvertCut($row['UB_TITLE'],50,'N')?>
						<?if($lock['member'] && $lock['check']): // 자신글?><?endif;?>
					</a>
				<?endif;?>		
			</td>
			<td class="cate"><? include "{$_REQUEST['S_DOCUMENT_ROOT']}www/skins/user/community/category/include.1.0/combobox.row.inc.skin.php" ?></td>
			<?if($_REQUEST['BOARD_INFO']['bi_widget_datalist_field_use'][4]!="N"):?>
			<!--점수--><td><?=$row['UB_P_GRADE']?></td>
			<?endif;?>
		</tr>
		<tr id="dataView_<?=$row['UB_NO']?>" style="display:none">
			<td class="Alist" colspan="2">
				<?=stripslashes($row['UB_TEXT'])?>
			</td>
		</tr>
		<? endwhile; 
		   endif; ?>		
</table>