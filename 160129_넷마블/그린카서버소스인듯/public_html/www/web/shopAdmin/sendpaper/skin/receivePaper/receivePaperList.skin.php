<?
	# 받은 쪽지 함(리스트)
	# /home/shop_eng/www/web/shopAdmin/sendpaper/skin/receivePaper/receivePaperList.skin.php
?>

<div id="contentArea">
<div class="contentTop">
	<h2>받은쪽지 함</h2>
</div>
<br>

<!-- ******** 컨텐츠(쪽지리스트) ********* -->
<!-- 버튼 -->
<div style="text-align:left;margin-top:3px;">
	<a class="btn_big" href="javascript:goReceivePaperMultiDeleteActEvent()" id="menu_auth_w" style=""><strong>삭제</strong></a>
	<a class="btn_big" href="javascript:goSendPaperWriteMultiMoveEvent()" id="menu_auth_w" style=""><strong>답변</strong></a>
</div>

<!-- 쪽지 리스트 -->
<div class="tableList">		
	<table>
		<colgroup>
			<col style="width:40px;"/>
			<col style="width:150px;"/>
			<col style="width:150px;"/>
			<col />
			<col style="width:150px;"/>	
		</colgroup>
		<tr>
			<th><input type="checkbox" id="chkAll" data_target="selfCheck"/></th>
			<th>보낸사람</th>
			<th>받은사람</th>
			<th>제목</th>
			<th>날짜</th>
		</tr>
		<? while($row = mysql_fetch_array($paperResult)) : 
			 $from_id		= $row['FROM_M_ID'] ;
			 $to_id			= $row['TO_M_ID'] ;
			 if(!$from_id)		{ $from_id		= $row['FROM_M_MAIL']; }
			 if(!$to_id)		{ $to_id		= $row['TO_M_MAIL']; }

//			 $check			= $row['MP_CHECK_DT'];
		?>
		<tr>
			<td><input type="checkbox" name="selfCheck[]" id="selfCheck" value="<?=$row['MP_NO']?>"/></td>
			<td><?=$row['FROM_M_L_NAME']?> <?=$row['FROM_M_F_NAME']?>(<?=$from_id?>)</td>
			<td><?=$row['TO_M_L_NAME']?> <?=$row['TO_M_F_NAME']?>(<?=$to_id?>)</td>
			<td style="text-align:left;padding:0 0 0 10px"><a href="./?menuType=sendpaper&mode=receivePaperView&mp_no=<?=$row['MP_NO']?>"><?=$row['MP_TITLE']?></a></td>
			<td><?=date("Y.m.d H:i", strtotime($row['MP_REG_DT']))?></td>
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

<!-- ******** 컨텐츠(쪽지리스트) ********* -->

