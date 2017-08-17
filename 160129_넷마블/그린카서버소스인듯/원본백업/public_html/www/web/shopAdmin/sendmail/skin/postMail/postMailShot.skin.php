<?
	# 메일멤버검색
	# mailMemberSearch.skin.php
?>

<input type="hidden" name="pm_no" id="pm_no" value="<?=$intPM_NO?>" />

<div id="contentArea">
<div class="contentTop">
	<h2>메일발송관리</h2>
	<div class="clr"></div>
</div>
<br>

<!-- ******** 선택된 메일 ********* -->
<div class="tableForm">
	<table>
		<tr>
			<th>선택된 메일</th>
			<td><?=$postMailRow['PM_TITLE']?></td>
		</tr>	
		<tr>
			<th>보내는 사람 이름</th>
			<td><input type="text" name="send_name" style="width:300px" value="<?=$S_SITE_KNAME?>"/></td>
		</tr>
		<tr>
			<th>보내는 사람 메일</th>
			<td><input type="text" name="send_email" style="width:300px" value="<?=$S_SITE_MAIL?>"/></td>
		</tr>	
	</table>
</div>
<!-- ******** 선택된 메일 ********* -->

<!-- ******** 멤버 검색폼 ********* -->
<div class="searchTableWrap mt20">
	<?	include MALL_WEB_PATH."shopAdmin/member/member/search.inc.php"; ?>
</div>
<!-- ******** 멤버 검색폼 ********* -->
<br>
<!-- ******** 컨텐츠 ********* -->
<div class="tableListTopWrap">
	<span class="listCntNum">* <?=callLangTrans($LNG_TRANS_CHAR["MS00010"],array($intMemTotal))?><!--총 <strong><?=$intListNum?>명</strong>의 회원이 검색되었습니다.//--></span>
</div>

<div class="tableList">
	<table>
		<tr>
			<th><input type="checkbox" id="allCheck"/></th>
			<th>번호</th>
			<th>아이디</th>
			<th>이름</th>
			<th>회원그룹</th>
			<th>이메일</th>
			<th>메일수신여부</th>
			<th>가입일</th>
		</tr>
		<? while($row = mysql_fetch_array($memberListResult)) :  ?>
		<tr>
			<td><input type="checkbox" name="chkNo[]" value="<?=$row['M_NO']?>"/></td>
			<td><?=$intMemListNum--?></td>
			<td><?=$row['M_ID']?></td>
			<td><?=$row['M_F_NAME']?> <?=$row['M_L_NAME']?></td>
			<td><?=$row['G_NAME']?></td>
			<td><?=$row['M_MAIL']?></td>
			<td><?=$row['M_MAILYN']?></td>
			<td><?=date("Y.m.d", strtotime($row['M_REG_DT']))?></td>
		</tr>
		<? endwhile; ?>
	</table>
</div>

<!-- Pagenate object --> 
<div class="paginate mt20">  
	<?=drawPaging($intMemPage,$intPageLine,$intPageBlock,$intMemTotal,$intMemTotPage,$memLinkPage,"","")?> 
</div>  
<!-- Pagenate object -->
<div class="buttonWrap">
	<select name="sendType">
		<option value="A">선택된 회원에게 메일을 보냅니다.</option>
		<option value="B">검색된 회원에게 메일을 보냅니다.</option>
	</select>
	<a class="btn_blue_big" href="javascript:postMailShotSendActClickEvent()" id="menu_auth_m" style=""><strong>메일보내기</strong></a>
	<a class="btn_big" href="javascript:postMailViewMoveClickEvent()"><strong>취소</strong></a>
</div>
<!-- ******** 컨텐츠 ********* -->