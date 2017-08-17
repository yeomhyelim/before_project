<?
	# 메일발송리스트
	# postMailList.skin.php
?>

<input type="hidden" name="pp_no" id="pp_no" value="<?=$intPP_NO?>" />

<div id="contentArea">
<div class="contentTop">
	<h2>쪽지발송관리</h2>
</div>
<br>

<!-- ******** 컨텐츠(쪽지리스트) ********* -->
<!-- 쪽지 리스트 -->
<div class="tableList">		
	<table>
		<colgroup>
			<col style="width:40px;"/>
			<col style="width:60px;"/>
			<col/>
			<col style="width:150px;"/>
			<col style="width:80px;"/>
			<col style="width:150px;"/>	
		</colgroup>
		<tr>
			<th><input type="checkbox" id="allCheck"/></th>
			<th>번호</th>
			<th>제목</th>
			<th>전달건수</th>
			<th>등록일</th>
			<th>관리</th>
		</tr>
		<? while($row = mysql_fetch_array($postPaperResult)) :  ?>
		<tr>
			<td><input type="checkbox" name="selfCheck[]" value="<?=$row['PP_NO']?>"/></td>
			<td><?=$intListNum--?></td>
			<td style="text-align:left;padding:0 0 0 10px" id="PP_text_<?=$row['PP_NO']?>"><a href="javascript:postPaperViewClickEvent('<?=$row['PP_NO']?>')"><?=$row['PP_TITLE']?></a></td>
			<td><?=$row['PP_TOTAL_CNT']?></td>
			<td><?=date("Y.m.d", strtotime($row['PP_REG_DT']))?></td>
			<td>
				<a class="btn_big" href="javascript:postPaperDeleteActClickEvent('<?=$row['PP_NO']?>')" id="menu_autd_m" style=""><strong>삭제</strong></a>
				<a class="btn_big" href="javascript:postPaperLogListMoveClickEvent('<?=$row['PP_NO']?>')" id="menu_autd_m" style=""><strong>발송내역</strong></a>
			</td>
		</tr>	
		<? endwhile; ?>
	</table>
</div>	
<!-- 쪽지 리스트 -->
<br>
<!-- 페이지 -->
<div class="paginate">
	<?=drawPaging($intPage,$intPageLine,$intPageBlock,$intTotal,$intTotPage,$linkPage,"","")?>
</div>

<!-- 버튼 -->
<div style="text-align:left;margin-top:3px;">
	<a class="btn_big" href="javascript:postPaperWriteMoveClickEvent()" id="menu_auth_w" style=""><strong>쪽지 쓰기</strong></a>
</div>
<!-- ******** 컨텐츠(쪽지리스트) ********* -->

