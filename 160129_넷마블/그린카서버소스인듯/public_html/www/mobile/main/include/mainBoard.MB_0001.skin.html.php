<!-- 게시판(공지사항) -->
<div id="board" class="board_notice">
	<ul>
		<? while ( $row = mysql_fetch_array ( $result1 ) ) : 
			$row['B_TITLE'] = strConvertCut2($row['B_TITLE'], 0, "Y" ); ?>
		<li><span class="listDateWrap"><?=date("Y.m.d", strtotime($row['B_REG_DT']))?></span><a href="/<?=$S_SITE_LNG_PATH?>/?menuType=board&mode=view&bNo=<?=$row['B_NO']?>&bCode=<?=$MAIN_BOARD['CODE']?>">
			<?=strHanCutUtf($row['B_TITLE'],$MAIN_BOARD['TEXT_LENGTH'])?></a></li>
		<? endwhile; ?>
	</ul>
</div>