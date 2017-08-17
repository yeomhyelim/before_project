<?
	## 설정
	$result			= $_REQUEST['result']['DataMgr']['listResult'];
	$list_total		= $_REQUEST['result']['DataMgr']['pageResult']['list_total'];
	$list_num		= $_REQUEST['result']['DataMgr']['pageResult']['list_num'];
?>
	<table id="data_<?=$_REQUEST['BOARD_INFO']['b_code']?>">
		<colgroup>
			<!--col width=40/-->
			<?if($_REQUEST['BOARD_INFO']['bi_datalist_field_use'][0]!="N"):?>
				<col width=40/>
			<?endif;?>
			<col /><!--제목-->
			<?if($_REQUEST['BOARD_INFO']['bi_datalist_field_use'][1]!="N"):?>
				<?if($_REQUEST['BOARD_INFO']['bi_datalist_writer_show'][0]=="Y"):?>
					<col width=80/>
				<?endif;?>
				<?if($_REQUEST['BOARD_INFO']['bi_datalist_writer_show'][1]=="Y"):?>
					<col width=80/>
				<?endif;?>
			<?endif;?>
			<?if($_REQUEST['BOARD_INFO']['bi_datalist_field_use'][2]!="N"):?>
				<col width=80/>
			<?endif;?>
			<?if($_REQUEST['BOARD_INFO']['bi_datalist_field_use'][3]!="N"):?>
				<col width=60/>
			<?endif;?>
		</colgroup>
		<tr>
			<!--th><input type="checkbox"></th-->
			<?if($_REQUEST['BOARD_INFO']['bi_datalist_field_use'][0]!="N"):?>
				<th>번호</th>
			<?endif;?>
				<th>제목</th>
			<?if($_REQUEST['BOARD_INFO']['bi_datalist_field_use'][1]!="N"):?>
				<?if($_REQUEST['BOARD_INFO']['bi_datalist_writer_show'][0]=="Y"):?>
					<th>작성자</th>
				<?endif;?>
				<?if($_REQUEST['BOARD_INFO']['bi_datalist_writer_show'][1]=="Y"):?>
					<th>아이디</th>
				<?endif;?>
			<?endif;?>
			<?if($_REQUEST['BOARD_INFO']['bi_datalist_field_use'][2]!="N"):?>
				<th>작성일</th>
			<?endif;?>
			<?if($_REQUEST['BOARD_INFO']['bi_datalist_field_use'][3]!="N"):?>
				<th>조회수</th>
			<?endif;?>
		</tr>
		<? if($list_total <= 0) : ?>
		<tr>
			<td colspan="6" class="noData">등록된 내용이 없습니다.</td>
		</tr>
		<? else: 
		   while($row = mysql_fetch_array($result)) :
			   $aryFunc			= $dataView->getUB_FUNC_DECODER($row);
			   $lock			= $dataView->getLockAuthCheck($row);
//			   $buttonLock		= $dataView->getButtonLockEx($row, "dataWrite");
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
			<!--td><input type="checkbox"></td-->
			<?if($_REQUEST['BOARD_INFO']['bi_datalist_field_use'][0]!="N"):?>
			<!--번호--><td><?=$list_num--?></td>
			<?endif;?>
			<!--제목-->
			<td style="text-align:left;padding-left:10px;">
				<?if($step): // 답변깊이?><?=$step?><img src="/himg/board/A0001/icon_bbs_reply.png"><?endif;?>
				<?if($aryFunc['UB_FUNC_NOTICE']=="Y"): // 공지글?><img src="/himg/board/A0001/icon_bbs_notice.png"><?endif;?>
				<?if($lock['member'] == 1 && $lock['check'] == 0 && $aryFunc['UB_FUNC_LOCK']=="Y"): // 회원글 비밀글?>
					<a href="javascript:alert('권한이 없습니다.')"><img src="/himg/board/A0001/icon_bbs_lock.png"><?=strConvertCut($row['UB_TITLE'],50,'N')?></a>
				<?else:?>
					<a href="javascript:goDataViewMove2Event('<?=$_REQUEST['b_code']?>','<?=$row['UB_NO']?>')">
						<?if($aryFunc['UB_FUNC_LOCK']=="Y"): // 비밀글?><img src="/himg/board/A0001/icon_bbs_lock.png"><?endif;?>
						<?=strConvertCut($row['UB_TITLE'],50,'N')?>
						<?if($lock['member'] && $lock['check']): // 자신글?><?endif;?>
					</a>
				<?endif;?>
			</td>
			<?if($_REQUEST['BOARD_INFO']['bi_datalist_field_use'][1]!="N"):?>
				<?if($_REQUEST['BOARD_INFO']['bi_datalist_writer_show'][0]=="Y"):?>
				<!--작성자(성명)--><td><?=$row['UB_NAME']?></td>
				<?endif;?>
				<?if($_REQUEST['BOARD_INFO']['bi_datalist_writer_show'][1]=="Y"):?>
				<!--작성자(아이디)--><td><?=$row['UB_M_ID']?></td>
				<?endif;?>
			<?endif;?>
			<?if($_REQUEST['BOARD_INFO']['bi_datalist_field_use'][2]!="N"):?>
			<!--작성일--><td><?=date("Y-m-d", strtotime($row['UB_REG_DT']))?></td>
			<?endif;?>
			<?if($_REQUEST['BOARD_INFO']['bi_datalist_field_use'][3]!="N"):?>
			<!--조회수--><td><?=NUMBER_FORMAT($row['UB_READ'])?></td>
			<?endif;?>
		</tr>
		<tr id="dataView_<?=$row['UB_NO']?>" style="display:none">
			<td colspan="7" style="text-align:left;padding-left:50px;">
				<?=stripslashes($row['UB_TEXT'])?>
				<?if($lock['check']==0):?>
				<?else:?>
				<div><a href="javascript:goDataModifyMove2('<?=$row['UB_NO']?>')">[수정]</a>
					 <a href="javascript:goDataDeleteAct2('<?=$row['UB_NO']?>')">[삭제]</a></div>
				<?endif;?>
			</td>
		</tr>
		<? endwhile; 
		   endif; ?>
	</table>

