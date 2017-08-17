	<?if($_REQUEST['buttonLock'][2]):	// 사용 권한이 없을 때?>
	<table id="talkWrite_Table">
		<tr>
			<th>7자토크</th>
			<td>
				<!--div style="padding:0 0 5px 0;">이름 : <input type="text" name="ub_name" id="ub_name" style="width:100px">
												비밀번호 : <input type="text"  name="ub_pass" id="ub_pass" style="width:100px">
												이메일 : <input type="text"  name="ub_mail" id="ub_mail" style="width:200px"></div-->
				<textarea style="width:100%;height:100px" id="ub_talk" name="ub_talk" alt="내용" check="Y"></textarea>
			</td>
			<td style="width:50px">
				<a class="btn_big" href="javascript:goTalkWriteEvent();" id="menu_auth_w" style=""><strong>등록</strong></a>
			</td>
		</tr>
	</table>
	<?else:  // 사용 권한이 있을 때?>
	<table id="talkWrite_Table">
		<tr>
			<th>7자토크</th>
			<td>
				<textarea style="width:100%;height:100px" id="ub_talk" name="ub_talk" onClick="goLoginLayerpop()" readOnly></textarea>
			</td>
			<td style="width:50px">
				<a class="btn_big" href="javascript:goLoginLayerpop();" id="menu_auth_w" style=""><strong>등록</strong></a>
			</td>
		</tr>
	</table>
	<?endif;?>