<?
	$memberMgr->setM_NO($intM_NO);
	$row = $memberMgr->getMemberView($db);

	$strSEND_NAME							= $S_SITE_NM;
	$strSEND_EMAIL							= $S_SITE_MAIL;

?>
<script type="text/javascript">
<!--
	function goAct() {
		// 액션
		if(!C_chkInput("pm_title",true,"제목",true)) return; //제목
		if(!C_chkInput("pm_text",true,"내용",true)) return; //내용



		//alert('보내기 작업중입니다.');
		//C_getAction("memberMailSend","<?=$PHP_SELF?>");
	}
//-->
</script>
<div id="contentArea" style="margin:0 20px 0 10px;">
	<div id="contentWrap">

		<div class="tableForm">
			<table>
				<tr>
					<th><?=$LNG_TRANS_CHAR["MW00154"] //보내는 사람 이름?></th>
					<td><input type="text" name="send_name" style="width:100%" value="<?=$strSEND_NAME?>"/></td>
				</tr>
				<tr>
					<th><?=$LNG_TRANS_CHAR["MW00155"] //보내는 사람 메일?></th>
					<td><input type="text" name="send_email" style="width:100%" value="<?=$strSEND_EMAIL?>"/></td>
				</tr>
				<tr>
					<th><?=$LNG_TRANS_CHAR["MW00156"] //받는사람 이름?></th>
					<td><input type="text" name="receive_name" style="width:100%" value="<?=$row[M_NAME]?>"/></td>
				</tr>
				<tr>
					<th><?=$LNG_TRANS_CHAR["MW00157"] //받는사람 메일?></th>
					<td><input type="text" name="receive_mail" style="width:100%" value="<?=$row[M_MAIL]?>"/></td>
				</tr>
				<tr>
					<th><?=$LNG_TRANS_CHAR["MW00158"] //제목?></th>
					<td><input type="text" name="pm_title" style="width:100%" value="<?=$postMailRow['PM_TITLE']?>" /></td>
				</tr>
				<tr>
					<th>설정</th>
					<td><input type="checkbox" name="html" value="Y"> HTML</td>
				</tr>
				<tr>
					<th><?=$LNG_TRANS_CHAR["MW00159"] //내용?></th>
					<td><textarea name="pm_text" id="pm_text" title=""  style="width:100%;height:300px" ><?=$postMailRow['PM_TEXT']?></textarea><br></td>
				</tr>
			</table>
		</div>
		<div class="buttonWrap">
			<a class="btn_blue_big" href="javascript:goSendEmailActEvent()" id="menu_auth_m" style=""><strong><?=$LNG_TRANS_CHAR["MW00160"] //보내기?></strong></a>
			<a class="btn_blue_big" href="javascript:goMemberMailSendListMoveEvent()" id="menu_auth_m" style=""><strong>목록</strong></a>
		</div>
	</div>
</div>