<?
	# 메일발송리스트
	# postMailList.skin.php
?>

<input type="hidden" name="pm_no" id="pm_no" value="" />


<div class="contentTop">
	<h2><?=$LNG_TRANS_CHAR["MM00033"]//메일발송관리?></h2>
	<div class="clr"></div>
</div>
<br>

<!-- ******** 컨텐츠 ********* -->
<div class="tableListWrap">
	<table class="tableList">
		<colgroup>
			<col width=30/>
			<col width=50/>
			<col />
			<col width=80/>
			<col width=80/>
			<col width=250/>			
		</colgroup>
		<tr>
			<th><input type="checkbox" id="allCheck"/></th>
			<th><?=$LNG_TRANS_CHAR["CW00009"]//번호?></th>
			<th><?=$LNG_TRANS_CHAR["MW00158"]//제목?></th>
			<th><?=$LNG_TRANS_CHAR["MM00129"]//발송건수?></th>
			<th><?=$LNG_TRANS_CHAR["CW00026"]//등록일?></th>
			<th><?=$LNG_TRANS_CHAR["MM00130"]//관리?></th>
		</tr>
		<? while($row = mysql_fetch_array($postMailResult)) :  ?>
		<tr>
			<td><input type="checkbox" name="selfCheck[]" value="<?=$row['PM_NO']?>"/></td>
			<td><?=$intListNum--?></td>
			<td><a href="javascript:postMailViewMoveClickEvent('<?=$row['PM_NO']?>')"><?=$row['PM_TITLE']?></a></td>
			<td><?=$row['PM_TOTAL_CNT']?></td>
			<td><?=date("Y.m.d", strtotime($row['PM_REG_DT']))?></td>
			<td>
				<a class="btn_big" href="javascript:postMailViewMoveClickEvent('<?=$row['PM_NO']?>')" id="menu_autd_m"><strong><?=$LNG_TRANS_CHAR["OW00012"]//상세보기?></strong></a>				
				<a class="btn_big" href="javascript:postMailLogListMoveClickEvent('<?=$row['PM_NO']?>')" id="menu_autd_m"><strong><?=$LNG_TRANS_CHAR["MM00128"]//발송내역?></strong></a>
				<a class="btn_big" href="javascript:postMailDeleteActClickEvent('<?=$row['PM_NO']?>')" id="menu_autd_m"><strong><?=$LNG_TRANS_CHAR["CW00004"]//삭제?></strong></a>
			</td>
		</tr>	
		<? endwhile; ?>
	</table>
</div>
<!-- 페이지 -->
<div class="paginate">
	<?=drawPaging($intPage,$intPageLine,$intPageBlock,$intTotal,$intTotPage,$linkPage,"","")?>
</div>

<!-- 버튼 -->
<div class="buttonBoxWrap">
	<a class="btn_new_blue" href="javascript:postMailWriteMoveClickEvent()" id="menu_auth_w"><strong class="ico_write"><?=$LNG_TRANS_CHAR["CW00002"]//등록?></strong></a>
</div>
<!-- ******** 컨텐츠 ********* -->