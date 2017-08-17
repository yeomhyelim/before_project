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

<div class="eventTableList">
	<table>
		<? if($list_total <= 0) : ?>
		<tr>
			<td colspan="3" class="noData">등록된 내용이 없습니다.</td>
		</tr>
		<? else: 
				while($row = mysql_fetch_array($result, MYSQL_ASSOC)):
					$imgsrc = $row['FL_DIR'] . $row['FL_NAME'];
					$title	= $row['UB_TITLE'];
					$d_day   = getDateDiff(date("Y-m-d", time()), date("Y-m-d", strtotime($row['UB_EVENT_E_DT'])));		
		?>
				<tr class="<?if($d_day>0){echo "endEvent";}?>">			
					<!-- 내용 -->
					<td class="listImg"><a href="javascript:goDataViewMoveEvent('<?=$row['UB_NO']?>')"><img src="<?=$imgsrc?>"/></a></td>
					<td class="eventInfo">
						<ul>							
							<li class="title">
								<span><img src="/images/board/tit_event_tit.gif"/></span>
								<strong>
									<?=stripslashes($title)?>
									<?if($d_day<=0):		// 진행중?>
										<img src="/images/common/icon_event_ing.png" class="iconState"/>
									<?else:				// 종료?>
										<img src="/images/common/icon_event_end.png" class="iconState"/>
									<?endif;?>
								</strong>								
							</li>
							<li class="dateInfo"><span><img src="/images/board/tit_event_date.gif"/></span>
								<?=date("Y년m월d일", strtotime($row['UB_EVENT_S_DT']));?> ~ 
								<?=date("Y년m월d일", strtotime($row['UB_EVENT_E_DT']));?> 까지
							</li>
							<li class="eventInfo"><?=stripslashes($row['UB_EXPLAIN'])?></li>
							<li class="eventInfo"><a href="javascript:goDataViewMoveEvent('<?=$row['UB_NO']?>')"><img src="/images/common/btn_event_more.png"/></a></li>							
						</ul>
						
					</td>
					<td class="readCnt">조회: <?=NUMBER_FORMAT($row['UB_READ'])?></td>
					<!-- 내용 -->
				</tr>
		<?		endwhile;	
		   endif;				?>

	</table>
</div><!-- eventTableList -->
