<div id="contentArea">
	<div class="contentTop">
		<h2><?=$LNG_TRANS_CHAR["BW00082"] //최고관리자?></h2>
		<div class="clr"></div>
	</div>
	<br>
	<!-- ******** 컨텐츠 ********* -->
		<div class="tableForm">
			<table>
				<tr>
					<th><?=$LNG_TRANS_CHAR["BW00083"] //관리자명?></th>
					<td><input type="input"  class="inbox _w200" name="m_name" value="<?=$strM_NAME?>"/></td>
				</tr>
				<tr>
					<th><?=$LNG_TRANS_CHAR["BW00084"] //현재 비밀번호?></th>
					<td><input type="password"  class="inbox _w200" name="m_now_pwd" id="m_now_pwd"/></td>
				</tr>
				<tr>
					<th><?=$LNG_TRANS_CHAR["BW00085"] //신규 비밀번호?></th>
					<td><input type="password"  class="inbox _w200" name="m_new_pwd1" id="m_new_pwd1"/></td>
				</tr>
				<tr>
					<th><?=$LNG_TRANS_CHAR["BW00086"] //재입력 신규 비밀번호?></th>
					<td><input type="password"  class="inbox _w200" name="m_new_pwd2" id="m_new_pwd2"/></td>
				</tr>
				<tr>
					<th><?=$LNG_TRANS_CHAR["SW00081"] //관리자 아이콘?></th>
					<td><?php if($strAdminLogoFile):?>
						<img src="<?php echo $strAdminLogoFile;?>"/>
						<?php endif;?>
						<input type="file" name="m_admin_logo"/>
						<?php if($strAdminLogoFile):?>
						<input type="checkbox" name="m_admin_logo_del" value="Y"> <?=$LNG_TRANS_CHAR["CW00004"]	//삭제?>
						<?php endif;?>
					</td>
				</tr>
			</table>
		</div>
	</div>
	<div class="buttonWrap">
		<a  href="javascript:goMoveUrl('admin','');" id="menu_auth_m" style="display:none"  class="btn_Big_Blue"><strong><?=$LNG_TRANS_CHAR["CW00051"] //적용하기?></strong></a>
	</div>

	<div class="noticeInfoWrap">
		<ul>
			<li>- <?=$LNG_TRANS_CHAR["BS00013"] //최고 관리자의 접속 비밀번호를 설정합니다.?> </li>
			<li>- <?=$LNG_TRANS_CHAR["BS00014"] //쇼핑몰 오픈 후 비밀번호를 꼭 변경해 주시고 보안을 위하여 일정 기간을 정해 변경해 주시기 바랍니다.?> </li>
		</ul>
	</div>
</div>