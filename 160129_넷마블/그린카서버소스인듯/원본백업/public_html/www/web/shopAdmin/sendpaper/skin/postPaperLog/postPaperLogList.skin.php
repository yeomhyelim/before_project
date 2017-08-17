<?
	# 메일발송로그리스트
	# postMailLogList.skin.php
?>

<input type="hidden" name="pm_no" id="pm_no" value="" />

<div id="contentArea">
<div class="contentTop">
	<h2>발신내역</h2>
</div>
<br>

<!-- ******** 컨텐츠 ********* -->
<div class="tableList">
	<table>
		<tr>
			<th><input type="checkbox"/></th>
			<th>번호</th>
			<th>보낸사람ID</th>
			<th>받은사람ID</th>
			<th>확인유무(확인일자)</th>
			<th>작성일</th>
		</tr>
		<? while($row = mysql_fetch_array($memberPaperResult)) : 
			$strMP_CHECK = "미확인";
			if($row['MP_CHECK_DT']) :
				$strMP_CHECK = "확인";
				$row['MP_CHECK_DT'] = sprintf("(%s)", $row['MP_CHECK_DT']);
			endif;			?>
		<tr>
			<td><input type="checkbox"/></td>
			<td><?=$intListNum--?></td>
			<td><?=$row['MP_FROM_M_ID']?></td>
			<td><?=$row['MP_TO_M_ID']?></td>
			<td><?=$strMP_CHECK?><?=$row['MP_CHECK_DT']?></td>
			<td><?=$row['MP_REG_DT']?></td>
		</tr>	
		<? endwhile; ?>
	</table>
</div>

<br>
<!-- 페이지 -->
<div class="paginate">
	<?=drawPaging($intPage,$intPageLine,$intPageBlock,$intTotal,$intTotPage,$linkPage,"","")?>
</div>

<!-- 버튼 -->
<div style="text-align:left;margin-top:3px;">
	<a class="btn_big" href="javascript:postPaperListMoveClickEvent()" id="menu_auth_w" style=""><strong>뒤로</strong></a>
</div>
<!-- ******** 컨텐츠 ********* -->