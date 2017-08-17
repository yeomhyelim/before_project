<?
	## 설정
	$result			= $_REQUEST['result']['DataMgr']['listResult'];
	$list_total		= $_REQUEST['result']['DataMgr']['pageResult']['list_total'];
	$list_num		= $_REQUEST['result']['DataMgr']['pageResult']['list_num'];
?>
	<ul>
		<? if($list_total <= 0) : ?>
		<li>
			<?php echo $LNG_TRANS_CHAR["CS00001"];?>
		</li>
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

			   /* 신규날짜체크 */
			   $newImg = "";
			   if ( !strcmp ( substr ( $row[UB_REG_DT], 0, 10 ), date ( "Y-m-d" ) ) ) :	// 오늘 등록된 글인 경우, new 아이콘 표시
					$newImg			= "<img src=\"/himg/board/icon/icon_new.png\"/>";
			   endif;
			   /* 신규날짜체크 */
			   
			   $intTitleLen = $_REQUEST['BOARD_INFO']['bi_widget_datalist_title_len'];
		?>
		<li>
			<!--td><input type="checkbox"></td-->
			<?if($_REQUEST['BOARD_INFO']['bi_widget_datalist_field_use'][0]!="N"):?>
			<!--번호--><?=$list_num--?>
			<?endif;?>
			<!--제목-->
				<?if($step): // 답변깊이?><?=$step?><img src="/himg/board/A0001/icon_bbs_reply.png"><?endif;?>
				<!--<?if($aryFunc['UB_FUNC_NOTICE']=="Y"): // 공지글?><img src="/himg/board/A0001/icon_bbs_notice.png"><?endif;?>//-->
				<?if($lock['member'] == 1 && $lock['check'] == 0 && $aryFunc['UB_FUNC_LOCK']=="Y"): // 회원글 비밀글?>
				<a href="javascript:alert('권한이 없습니다.')"><img src="/himg/board/A0001/icon_bbs_lock.png"><?=strHanCutUtf2($row['UB_TITLE'],$intTitleLen,'N')?></a>
				<?else:?>
				<a href="./?menuType=community&mode=dataView&b_code=<?=$_REQUEST['BOARD_INFO']['b_code']?>&ub_no=<?=$row['UB_NO']?>">
					<?if($aryFunc['UB_FUNC_LOCK']=="Y"): // 비밀글?><img src="/himg/board/A0001/icon_bbs_lock.png"><?endif;?>
					<?=strHanCutUtf2($row['UB_TITLE'],$intTitleLen,'N')?>
					<!--<?if($lock['member'] && $lock['check']): // 자신글?>[내글]<?endif;?>//-->
				</a>
				<?endif;?>
				<?=$newImg?>
			<?if($_REQUEST['BOARD_INFO']['bi_widget_datalist_field_use'][1]!="N"):?>
				<?if($_REQUEST['BOARD_INFO']['bi_datalist_writer_show'][0]=="Y"):?>
				<!--작성자(성명)--><?=$row['UB_NAME']?>
				<?endif;?>
				<?if($_REQUEST['BOARD_INFO']['bi_datalist_writer_show'][1]=="Y"):?>
				<!--작성자(아이디)--><?=$row['UB_M_ID']?>
				<?endif;?>
			<?endif;?>
			<?if($_REQUEST['BOARD_INFO']['bi_widget_datalist_field_use'][4]!="N"):?>
			<!--점수--><?=$row['UB_P_GRADE']?>
			<?endif;?>
			<?if($_REQUEST['BOARD_INFO']['bi_widget_datalist_field_use'][2]!="N"):?>
			<!--작성일--><span class="date"><?=date("Y-m-d", strtotime($row['UB_REG_DT']))?></span>
			<?endif;?>
			<?if($_REQUEST['BOARD_INFO']['bi_widget_datalist_field_use'][3]!="N"):?>
			<!--조회수--><?=$row['UB_READ']?>
			<?endif;?>
		</li>
		<? endwhile; 
		   endif; ?>
	</ul>

