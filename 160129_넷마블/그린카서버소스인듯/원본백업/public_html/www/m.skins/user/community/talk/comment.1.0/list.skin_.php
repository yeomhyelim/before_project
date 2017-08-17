	<table id="talkList_Table">
		<? if($dataView->field['list_total'] <= 0) : ?>
		<? else: 
		   while($row = mysql_fetch_array($dataListResult)) : ?>
		<tr id="talk_<?=$row['UB_NO']?>">
			<th style="width:160px" id="talkUbName"><?=$row['UB_NAME']?></th>
			<td colspan="2"><div id="talkUbTalk" style="display:inline;"><?=str_replace("\r\n","<br>",$row['UB_TALK'])?></div>
							<?if($row['UB_M_NO']): // 회원글 ?>
							<?if($_REQUEST['member_no'] == $row['UB_M_NO']):	// 글 작성자와 회원이 같은 경우. ?>
							<a id="talkModify" href="javascript:goTalkModifyEvent('<?=$row['UB_NO']?>')">수정</a>
							<a id="talkDelete" href="javascript:goTalkDeleteEvent('<?=$row['UB_NO']?>')">삭제</a>
							<?else: /// 글 작성자와 회원이 같은 경우.?>
							<!-- 수정 버튼 -->
							<!-- 삭제 버튼 -->
							<?endif;?>
							<?else: //비회원글 ?>
							<a id="talkModify" href="javascript:goPassFormForModify('<?=$row['UB_NO']?>')">수정</a>
							<a id="talkDelete" href="javascript:goPassFormForDelete('<?=$row['UB_NO']?>')">삭제</a>
							<?endif;?>
			</td>
		</tr>
		<? endwhile; 
		   endif; ?>
		<textarea id="insert_form" style="display:none;" alt="등록후폼">
		<tr id="talk_">
			<th id="talkUbName"></th>
			<td colspan="2"><div id="talkUbTalk" style="display:inline;"></div>
							<a id="talkModify" href="javascript:goPassFormForModify('')">수정</a>
							<a id="talkDelete" href="javascript:goPassFormForDelete('')">삭제</a></td>
		</tr>
		</textarea>
		<textarea id="password_form" style="display:none;" alt="비밀번호폼">
		<tr>
			<th id="talkUbName">수정</th>
			<td colspan="2">비밀번호 : <input type="text" name="ub_pass_check" id="ub_pass_check" style="width:100px">
							<a id="passwordOk">확인</a>
							<a id="passwordCancel">취소</a></td>
		</tr>
		</textarea>
		<textarea id="modify_form" style="display:none;" alt="수정폼">
		<tr>
			<th id="talkUbName">수정</th>
			<td>
				<div style="padding:0 0 5px 0;" id="nonmember_input">이름 : <input type="text" name="ub_name_modify" id="ub_name" style="width:100px">
																	 비밀번호 : <input type="text"  name="ub_pass_modify" id="ub_pass" style="width:100px">
																	 이메일 : <input type="text"  name="ub_mail_modify" id="ub_mail" style="width:200px"></div>
				<textarea style="width:100%;height:100px" name="ub_talk_modify" id="ub_talk_modify">&lt;/textarea>
			</td>
			<td style="width:50px">
				<a id="talkModify">수정</a><br>
				<a id="talkModifyCancel">취소</a>
			</td>
		</tr>
		</textarea>
	</table>
