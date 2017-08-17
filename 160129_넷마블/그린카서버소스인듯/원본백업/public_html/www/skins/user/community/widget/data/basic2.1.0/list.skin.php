<?
	## 설정
	$result			= $_REQUEST['result']['DataMgr']['listResult'];
	$list_total		= $_REQUEST['result']['DataMgr']['pageResult']['list_total'];
	$list_num		= $_REQUEST['result']['DataMgr']['pageResult']['list_num'];
?>

<table>
	<? if($list_total <= 0) : ?>
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
//		   if($_REQUEST['buttonLock']['dataAnswer']):
			   $step = "";
			   if($row['UB_ANS_STEP']):
				   $step = explode(",", $row['UB_ANS_STEP']);
				   $step = sizeof($step);
				   $step = str_pad("", $step, " ", STR_PAD_LEFT);	
				   $step = str_replace(" ", "&nbsp;", $step);
			   endif;
//			endif;
		   /*답변 관련*/

		   /* 신규날짜체크 */
		   $newImg = "";
		   if ( !strcmp ( substr ( $row[UB_REG_DT], 0, 10 ), date ( "Y-m-d" ) ) ) :	// 오늘 등록된 글인 경우, new 아이콘 표시
				$newImg			= "<img src=\"/images/common/icon_new.png\"/>";
		   endif;
		   /* 신규날짜체크 */
		   
		   $intTitleLen = $_REQUEST['BOARD_INFO']['bi_widget_datalist_title_len'];
	?>
	<tr>
		<th><a href="./?menuType=community&mode=dataView&b_code=<?=$_REQUEST['BOARD_INFO']['b_code']?>&ub_no=<?=$row['UB_NO']?>"><img src="<?=$row['FL_DIR'].$row['FL_NAME']?>"></a></th>
		<td>
			<?if($_REQUEST['BOARD_INFO']['bi_widget_datalist_field_use'][4]!="N"):?>
			<!--점수-->(<?=$row['UB_P_GRADE']?>)
			<?endif;?>
			<!--제목-->
			<a href="./?menuType=community&mode=dataView&b_code=<?=$_REQUEST['BOARD_INFO']['b_code']?>&ub_no=<?=$row['UB_NO']?>">
			<strong><?=strHanCutUtf2($row['UB_TITLE'],$intTitleLen,'N')?> <span><?=$row['UB_NAME']?></span></strong>
			<?if($step): // 답변깊이?><?=$step?><img src="/himg/board/A0001/icon_bbs_reply.png"><?endif;?>
			<p><?=strip_tags($row['UB_TEXT'])?></p>
			</a>
		</td>
	</tr>
	<? endwhile; 
	   endif; ?>
</table>