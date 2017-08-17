<?
	# 메일발송리스트
	# postMailList.skin.php
?>

<input type="hidden" name="ps_no" id="ps_no" value="<?=$intPS_NO?>" />

<div id="contentArea">
<div class="contentTop">
	<h2>문자발송관리</h2>
	<div class="clr"></div>
</div>

<div class="newLayerBox">
	<!-- ******** 컨텐츠(문자리스트) ********* -->
	<table border="0" style="width:100%">
		<tr>
			<td style="width:100px">
				<div class="autoSmsWrap">
					<div class='sendSmsWrap'>
						<div class='smsFormWrap'>
							<textarea name='ps_text' id='ps_text' maxlen="80"></textarea>
							<p><strong id="textByte">0/80</strong> Byte</p>
						</div>
						<div style="text-align:center;">
							<a class="btn_big" href="javascript:postSmsWriteActClickEvent()" id="btn_postSms_insert"><strong>신규 등록</strong></a>
							<a class="btn_big" href="javascript:postSmsModifyActClickEvent()" id="btn_postSms_Modify" style="display:none"><strong>수정</strong></a>
							<a class="btn_big" href="javascript:postSmsCancelScriptClickEvent()" id="btn_postSms_Cancel" style="display:none"><strong>취소</strong></a>
						</div>
					</div>
				</div>
			</td>
			<td valign="top">	
				<!-- 문자 리스트 -->
				<div class="tableListWrap">		
					<table class="tableList">
						<colgroup>
							<!--col style="width:40px;"/-->
							<col style="width:60px;"/>
							<col/>
							<col style="width:150px;"/>
							<col style="width:80px;"/>
							<col style="width:300px;"/>	
						</colgroup>
						<tr>
							<!--th><input type="checkbox" id="allCheck"/></th-->
							<th>번호</th>
							<th>메시지</th>
							<th>발송건수</th>
							<th>등록일</th>
							<th>관리</th>
						</tr>
						<? while($row = mysql_fetch_array($postSmsResult)) :  ?>
						<tr>
							<!--td><input type="checkbox" name="selfCheck[]" value="<?=$row['PS_NO']?>"/></td-->
							<td><?=$intListNum--?></td>
							<td style="text-align:left;padding:0 0 0 10px" id="ps_text_<?=$row['PS_NO']?>"><a href="javascript:postSmsSelectScriptClickEvent('<?=$row['PS_NO']?>')"><?=$row['PS_TEXT']?></a></td>
							<td><?=$row['PS_TOTAL_CNT']?></td>
							<td><?=date("Y.m.d", strtotime($row['PS_REG_DT']))?></td>
							<td>
								<a class="btn_big" href="javascript:postSmsSelectScriptClickEvent('<?=$row['PS_NO']?>')" id="menu_autd_m"><strong>선택</strong></a>
								<a class="btn_big" href="javascript:postSmsDeleteActClickEvent('<?=$row['PS_NO']?>')" id="menu_autd_m"><strong>삭제</strong></a>							
								<a class="btn_big" href="javascript:postSmsLogListMoveClickEvent('<?=$row['PS_NO']?>')" id="menu_autd_m"><strong>발송내역</strong></a>
							</td>
						</tr>	
						<? endwhile; ?>
					</table>
				</div>	
				<!-- 문자 리스트 -->
			</td>
		</tr>
	</table>
</div>

<!-- 페이지 -->
<div class="paginate">
	<?=drawPaging($intPage,$intPageLine,$intPageBlock,$intTotal,$intTotPage,$linkPage,"","")?>
</div>

<!-- ******** 컨텐츠(문자리스트) ********* -->

<!-- ******** 멤버 검색폼 ********* -->
<div class="searchTableWrap">
	<?include MALL_WEB_PATH."shopAdmin/member/member/search.inc.php";?>
</div>
<!-- ******** 멤버 검색폼 ********* -->
<br>
<!-- ******** 컨텐츠 ********* -->

<div class="buttonBoxWrap">
	<?//=callLangTrans($LNG_TRANS_CHAR["MS00010"],array($intMemTotal))?><!--총 <strong><?=$intListNum?>명</strong>의 회원이 검색되었습니다.//-->
	<select name="sendType">
		<option value="A">선택된 회원에게 문자를 보냅니다.</option>
		<option value="B">검색된 회원에게 문자를 보냅니다.</option>
	</select>
	<a class="btn_new_blue" href="javascript:postSmsShotSendActClickEvent()" id="menu_auth_m"><strong class="ico_sms">문자보내기</strong></a>
</div>

<div class="tableListWrap">
	<table class="tableList">
		<colgroup>
			<col width="70"/>
			<col width="80"/>
			<col/>
			<col/>
			<col/>
			<col/>
			<col/>
			<col/>
		</colgroup>
		<tr>
			<th><input type="checkbox" id="allCheck"/></th>
			<th>번호</th>
			<th>아이디</th>
			<th>이름</th>
			<th>회원그룹</th>
			<th>연락처</th>
			<th>문자수신여부</th>
			<th>가입일</th>
		</tr>
		<? while($row = mysql_fetch_array($memberListResult)) :  ?>
		<tr>
			<td><input type="checkbox" name="chkNo[]" value="<?=$row['M_NO']?>"/></td>
			<td><?=$intMemListNum--?></td>
			<td><?=$row['M_ID']?></td>
			<td><?=$row['M_F_NAME']?> <?=$row['M_L_NAME']?></td>
			<td><?=$row['G_NAME']?></td>
			<td><?=$row['M_PHONE']?></td>
			<td><?=$row['M_SMSYN']?></td>
			<td><?=date("Y.m.d", strtotime($row['M_REG_DT']))?></td>
		</tr>
		<? endwhile; ?>
	</table>
</div>
<!-- Pagenate object --> 
<div class="paginate"> 
	<?=drawPaging($intMemPage,$intMemPageLine,$intPageBlock,$intMemTotal,$intMemTotPage,$memLinkPage,"goPostPageMoveEvent","")?> 
</div>  
<!-- Pagenate object -->


<div class="buttonBoxWrap">
	<select name="sendType">
		<option value="A">선택된 회원에게 문자를 보냅니다.</option>
		<option value="B">검색된 회원에게 문자를 보냅니다.</option>
	</select>
	<a class="btn_new_blue" href="javascript:postSmsShotSendActClickEvent()" id="menu_auth_m"><strong class="ico_sms">문자보내기</strong></a>
</div>
<!-- ******** 컨텐츠 ********* -->