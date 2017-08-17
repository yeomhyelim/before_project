<?php

//	1. 아이디 찾기, 타입1, 한국어 => 성명(last name), 이메일
//	2. 아이디 찾기, 타입1, 다국어 => first name, last name, 이메일
//	3. 이메일 찾기, 타입2, 한국어 => 성명(last name), 핸드폰
//	4. 이메일 찾기, 타입2, 다국어 => first name, last name, 핸드폰
//
//	5. 비밀번호 찾기 타입1, 한국어 => 아이디, 성명, 이메일
//	6. 비밀번호 찾기 타입1, 다국어 => first name, last name, id, 이메일
//	7. 비밀번호 찾기 타입2, 한국어 => 성명, 이메일
//	8. 비밀번호 찾기 타입2, 다국어 => first name, last name, 이메일

	## 기본설정
	$intEmmCerity = $S_MEM_CERITY; // 1 - id type, 2 - email type
	$strSiteLang = $S_SITE_LNG; // 현제 페이지 언어
	$strFindIdPwdType = "";

	## 아이디/비밀번호 찾기 타입 설정
	if($intEmmCerity == 1) { $strFindIdPwdType = "id"; }
	else { $strFindIdPwdType = "email"; }
	
	if($strSiteLang == "KR") { $strFindIdPwdType = "{$strFindIdPwdType}_korea"; }
	else { $strFindIdPwdType = "{$strFindIdPwdType}_global"; }

	## 스크립트 설정
	$aryScriptEx[] = "/common/js/member/member.findIdPwd.js";

	## 언어 설정
	$aryLanguage['MS00052'] = $LNG_TRANS_CHAR["MS00052"]; // 이름을 입력하세요.
	$aryLanguage['MS00053'] = $LNG_TRANS_CHAR["MS00053"]; // 성명을 입력하세요.
	$aryLanguage['MS00054'] = $LNG_TRANS_CHAR["MS00054"]; // 휴대폰을 입력하세요.
	$aryLanguage['MS00055'] = $LNG_TRANS_CHAR["MS00055"]; // 이메일을 입력하세요.
	$aryLanguage['MS00056'] = $LNG_TRANS_CHAR["MS00056"]; // 아이디를 입력하세요.

	## 스크립트 데이터 설정
	$aryScriptData['LANGUAGE'] = $aryLanguage; 
?>
<div class="findWrap joinApplyWrap">	
	<?php if($strFindIdPwdType == "id_korea"):?>
		<h2><?=$LNG_TRANS_CHAR["MW00050"]//아이디 찾기?> / <?=$LNG_TRANS_CHAR["MW00051"]//비밀번호 찾기?></h2>
		<div class="titBox"><span class="barRed"></span><span class="tit"><?=$LNG_TRANS_CHAR["MW00050"]//아이디 찾기?></span></div>
		<div class="loginForm joinTableWrap" id="koreaId">
			<table class="tableFind">
				<tr>
					<th><label><?=$LNG_TRANS_CHAR["OW00039"] //이름?></label></th>
					<td><input type="text" name="firstName"  style="width:228px;" tabindex="210"></td>			
				</tr>
				<tr>
					<th><label><?=$LNG_TRANS_CHAR["MW00010"] //이메일?></label></th>
					<td>
						<div class="mailBox">
							<input type="text" name="pwdEmail1"  style="width:107px;"  tabindex="220" class="pwdEmail1"/>@<input type="text" name="pwdEmail2"  style="width:100px;"  tabindex="230" class="pwdEmail2"/>
						</div>
					</td>
				</tr>				
			</table>
		</div>
		<div class="joinBtnWrap">
			<a href="javascript:void(0);" onclick="goMemberFindIdPwdKoreaIdFindEvent();" class="btn_Login btn_black" tabindex="240"><?=$LNG_TRANS_CHAR["CW00001"] //확인?></a>
		</div>

		<div class="titBox"><span class="barRed"></span><span class="tit"><?=$LNG_TRANS_CHAR["MW00051"]//비밀번호 찾기?></span></div>
		<div class="loginForm joinTableWrap" id="koreaPwd">
			<table class="tableFind">
				<tr>
					<th><label><?=$LNG_TRANS_CHAR["MW00001"] //아이디?></label></th>
					<td><input type="text" name="pwdId" style="width:228px;"  tabindex="250"/></td>
				</tr>
				<tr>
					<th><label><?=$LNG_TRANS_CHAR["OW00039"] //이름?></label></th>
					<td><input type="text" name="pwdFirstName" style="width:228px;"  tabindex="260"/></td>
				</tr>
				<tr>
					<th><label><?=$LNG_TRANS_CHAR["MW00010"] //이메일?></label></th>
					<td>
						<div class="mailBox">
							<input type="text" name="pwdEmail1"  style="width:107px;"  tabindex="270" class="pwdEmail1"/>@<input type="text" name="pwdEmail2"  style="width:100px;"  tabindex="280" class="pwdEmail2"/>
						</div>
					</td>
				</tr>
			</table>
		</div>

		<div class="joinBtnWrap">
			<a href="javascript:void(0);" onclick="goMemberFindIdPwdKoreaPwdFindEvent()" class="btn_Login btn_black"  tabindex="290"><?=$LNG_TRANS_CHAR["CW00001"] //확인?></a>
			<div class="loading" style="display:none">
				<img src="/himg/etc/loading.gif">
			</div>	
		</div>

	<?php elseif($strFindIdPwdType == "email_korea"):?>
		<h2><?=$LNG_TRANS_CHAR["MW00050"]//아이디 찾기?></h2>
		<div class="loginForm" id="koreaEmail">
			<table class="tableFind">
				<tr>
					<th><label><?=$LNG_TRANS_CHAR["OW00039"] //이름?></label></th>
					<td><input type="text" name="firstName"  style="width:228px;" tabindex="210"></td>
				</tr>
				<tr>
					<th><?=$LNG_TRANS_CHAR["MW00010"] //이메일?></th>
					<td>
						<div class="mailBox">
							<input type="text" name="pwdEmail1"  style="width:107px;"  tabindex="220" class="pwdEmail1"/> @
							<input type="text" name="pwdEmail2"  style="width:100px;"  tabindex="230" class="pwdEmail2"/>
						</div>
					</td>
				</tr>
			</table>
		</div>
		<div class="joinBtnWrap">
			<a href="javascript:void(0);" onclick="goMemberFindIdPwdKoreaEmailFindEvent();" class="btn_Login btn_black" tabindex="240"><?=$LNG_TRANS_CHAR["CW00001"] //확인?></a>
		</div>

		<h2><?=$LNG_TRANS_CHAR["MW00051"]//비밀번호 찾기?></h2>
		<div class="loginForm" id="koreaPwd">
			<table class="tableFind">
				<tr>
					<th><label><?=$LNG_TRANS_CHAR["OW00039"] //이름?></label></th>
					<td><input type="text" name="pwdFirstName" style="width:228px;"  tabindex="250"/></td>
				</tr>
				<tr>
					<th><?=$LNG_TRANS_CHAR["MW00010"] //이메일?></th>
					<td>
						<div class="mailBox">
							<input type="text" name="pwdEmail1"  style="width:107px;"  tabindex="260" class="pwdEmail1"/> @
							<input type="text" name="pwdEmail2"  style="width:100px;"  tabindex="270" class="pwdEmail2"/>
						</div>
					</td>
				</tr>
			</table>
		</div>
		<div class="joinBtnWrap">
			<a href="javascript:void(0);" onclick="goMemberFindIdPwdKoreaPwdFindEvent()" class="btn_Login btn_black"  tabindex="280"><?=$LNG_TRANS_CHAR["CW00001"] //확인?></a>
			<div class="loading" style="display:none">
				<img src="/himg/etc/loading.gif">
			</div>	
		</div>
	<?php elseif($strFindIdPwdType == "id_global"):?>
		<h2><?=$LNG_TRANS_CHAR["MW00050"]//아이디 찾기?> / <?=$LNG_TRANS_CHAR["MW00051"]//비밀번호 찾기?></h2>		
		<div class="titBox"><span class="barRed"></span><span class="tit"><?=$LNG_TRANS_CHAR["MW00050"]//아이디 찾기?></span></div>
		<div class="loginForm joinTableWrap" id="globalId">
			<table class="tableFind">
				<tr>
					<th><label style="width:70px;"><?=$LNG_TRANS_CHAR["OW00038"] //이름?></label></th>
					<td><input type="text" name="firstName"  style="width:228px;" tabindex="210"></td>
				</tr>
				<tr>
					<th><label style="width:70px;"><?=$LNG_TRANS_CHAR["OW00039"] //성?></label></th>
					<td><input type="text" name="lastName"  style="width:228px;" tabindex="220"></td>
				</tr>
				<tr>
					<th><label style="width:70px;"><?=$LNG_TRANS_CHAR["MW00010"] //이메일?></label></th>
					<td>
						<div class="mailBox">
							<input type="text" name="pwdEmail1"  style="width:107px;"  tabindex="320"/> @
							<input type="text" name="pwdEmail2"  style="width:100px;"  tabindex="330"/>
						</div>
					</td>
				</tr>
			</table>
		</div>
		<div class="joinBtnWrap">
			<a href="javascript:void(0);" onclick="goMemberFindIdPwdGlobalIdFindEvent();" class="btn_Login btn_black" tabindex="240"><?=$LNG_TRANS_CHAR["CW00001"] //확인?></a>
			<div class="loading" style="display:none">
				<img src="/himg/etc/loading.gif">
			</div>
		</div>

		<div class="titBox"><span class="barRed"></span><span class="tit"><?=$LNG_TRANS_CHAR["MW00051"]//비밀번호 찾기?></span></div>
		<div class="loginForm joinTableWrap" id="globalPwd">
			<table class="tableFind">
				<tr>
					<th><label style="width:70px;"><?=$LNG_TRANS_CHAR["OW00038"] //이름?></label></th>
					<td><input type="text" name="pwdFirstName" style="width:228px;" tabindex="300"/></td>
				</tr>
				<tr>
					<th><label style="width:70px;"><?=$LNG_TRANS_CHAR["OW00039"] //성?></label></th>
					<td><input type="text" name="pwdLastName" style="width:228px;" tabindex="310"/></td>
				</tr>				
				<tr>
					<th><label style="width:70px;"><?=$LNG_TRANS_CHAR["MW00010"] //이메일?></label></th>
					<td>
						<div class="mailBox">
							<input type="text" name="pwdEmail1"  style="width:107px;"  tabindex="320"/> @
							<input type="text" name="pwdEmail2"  style="width:100px;"  tabindex="330"/>
						</div>
					</td>
				</tr>
			</table>
		</div>
		<div class="joinBtnWrap">
			<a href="javascript:void(0);" onclick="goMemberFindIdPwdGlobalPwdFindEvent()" class="btn_Login btn_black"  tabindex="280"><?=$LNG_TRANS_CHAR["CW00001"] //확인?></a>
			<div class="loading" style="display:none">
				<img src="/himg/etc/loading.gif">
			</div>	
		</div>
	<?php elseif($strFindIdPwdType == "email_global"):?>
		<h2><?=$LNG_TRANS_CHAR["MW00050"]//아이디 찾기?></h2>
		<div class="loginForm" id="globalEmail">
			<table>
				<tr>
					<th><label><?=$LNG_TRANS_CHAR["OW00038"] //이름?></label></th>
					<td><input type="text" name="firstName"  style="width:228px;" tabindex="210"></td>
				</tr>
				<tr>
					<th><label><?=$LNG_TRANS_CHAR["OW00039"] //성?></label></th>
					<td><input type="text" name="lastName"  style="width:228px;" tabindex="220"></td>
				</tr>
				<tr>
					<th><label><?=$LNG_TRANS_CHAR["MW00010"] //이메일?></label></th>
					<td>
						<div class="mailBox">
							<input type="text" name="pwdEmail1"  style="width:107px;"  tabindex="320"/> @
							<input type="text" name="pwdEmail2"  style="width:100px;"  tabindex="330"/>
						</div>
					</td>
				</tr>
			</table>
		</div>
		<div class="joinBtnWrap">
			<a href="javascript:void(0);" onclick="goMemberFindIdPwdGlobalEmailFindEvent();" class="loginBtn btn_black" tabindex="240"><?=$LNG_TRANS_CHAR["CW00001"] //확인?></a>
			<div class="loading" style="display:none">
				<img src="/himg/etc/loading.gif">
			</div>	
		</div>

		<h2><?=$LNG_TRANS_CHAR["MW00051"]//비밀번호 찾기?></h2>
		<div class="loginForm" id="globalPwd">
			<table>
				<tr>
					<th><label><?=$LNG_TRANS_CHAR["OW00038"] //이름?></label></th>
					<td><input type="input" name="pwdFirstName" style="width:228px;" tabindex="300"/></td>
				</tr>
				<tr>
					<th><label><?=$LNG_TRANS_CHAR["OW00039"] //성?></label></th>
					<td><input type="input" name="pwdLastName" style="width:228px;" tabindex="310"/></td>
				</tr>				
				<tr>
					<th><label><?=$LNG_TRANS_CHAR["MW00010"] //이메일?></label></th>
					<td>
						<div class="mailBox">
							<input type="text" name="pwdEmail1"  style="width:107px;"  tabindex="320"/> @
							<input type="text" name="pwdEmail2"  style="width:100px;"  tabindex="330"/>
						</div>
					</td>
				</tr>
			</table>
		</div>
		<div class="joinBtnWrap">
			<a href="javascript:void(0);" onclick="goMemberFindIdPwdKoreaPwdFindEvent()" class="btn_Login btn_black"  tabindex="280"><?=$LNG_TRANS_CHAR["CW00001"] //확인?></a>
			<div class="loading" style="display:none">
				<img src="/himg/etc/loading.gif">
			</div>	
		</div>
	<?php endif;?>
</div>