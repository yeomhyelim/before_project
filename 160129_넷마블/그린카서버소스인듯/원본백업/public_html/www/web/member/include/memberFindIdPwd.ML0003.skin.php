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

<?php if($strFindIdPwdType == "email_korea"):?>
<div class="loginForm" id="koreaEmail">
	<h3><?=$LNG_TRANS_CHAR["MW00050"] //아이디 찾기?></h3>
	<table>
		<tr>
			<td><label><?=$LNG_TRANS_CHAR["OW00039"] //이름?></label>
				<input type="text" name="firstName"  style="width:228px;" tabindex="210">
			</td>
			<th rowspan="3"><a href="javascript:void(0);" onclick="goMemberFindIdPwdKoreaEmailFindEvent();" class="loginBtn" tabindex="230"><?=$LNG_TRANS_CHAR["CW00001"] //확인?></a></th>
		</tr>
		<tr>
			<td><label><?=$LNG_TRANS_CHAR["MW00008"]; //휴대폰?></label>
				<input type="text" name="phone" style="width:228px;" tabindex="220"> 
			</td>
		</tr>
	</table>
</div>

<div class="loginForm" id="koreaPwd">
	<h3><?=$LNG_TRANS_CHAR["MW00051"] //비밀번호 찾기?></h3>
	<table>
		<tr>
			<td><label><?=$LNG_TRANS_CHAR["OW00039"] //이름?></label>
				<input type="input" name="pwdFirstName" style="width:228px;"  tabindex="250"/>
			</td>
			<th rowspan="3"><a href="javascript:void(0);" onclick="goMemberFindIdPwdKoreaPwdFindEvent()" class="loginBtn"  tabindex="280"><?=$LNG_TRANS_CHAR["CW00001"] //확인?></a>
							<div class="loading" style="display:none">
								<img src="/himg/etc/loading.gif">
							</div>	
			</th>
		</tr>
		<tr>
			<td><label><?=$LNG_TRANS_CHAR["MW00010"] //이메일?></label>
				<input type="text" name="pwdEmail1"  style="width:107px;"  tabindex="260" class="pwdEmail1"/> @
				<input type="text" name="pwdEmail2"  style="width:100px;"  tabindex="270" class="pwdEmail2"/>
			</td>							
		</tr>
	</table>
</div>
<?php elseif($strFindIdPwdType == "email_global"):?>
<div class="loginForm" id="globalEmail">
	<h3><?=$LNG_TRANS_CHAR["MW00050"] //아이디 찾기?></h3>
	<table>
		<tr>
			<td><label><?=$LNG_TRANS_CHAR["OW00038"] //이름?></label>
				<input type="text" name="firstName"  style="width:228px;" tabindex="210">
			</td>
			<th rowspan="3"><a href="javascript:void(0);" onclick="goMemberFindIdPwdGlobalEmailFindEvent();" class="loginBtn" tabindex="240"><?=$LNG_TRANS_CHAR["CW00001"] //확인?></a></th>
		</tr>
		<tr>
			<td><label><?=$LNG_TRANS_CHAR["OW00039"] //성?></label>
				<input type="text" name="lastName"  style="width:228px;" tabindex="220">
			</td>
		</tr>
		<tr>
			<td><label><?=$LNG_TRANS_CHAR["MW00008"]; //휴대폰?></label>
				<input type="text" name="phone" style="width:228px;" tabindex="230"> 
			</td>
		</tr>
	</table>
</div>

<div class="loginForm" id="globalPwd">
	<h3><?=$LNG_TRANS_CHAR["MW00051"] //비밀번호 찾기?></h3>
	<table>
		<tr>
			<td><label><?=$LNG_TRANS_CHAR["OW00038"] //이름?></label>
				<input type="input" name="pwdFirstName" style="width:228px;" tabindex="300"/>
			</td>
			<th rowspan="3"><a href="javascript:void(0);" onclick="goMemberFindIdPwdGlobalPwdFindEvent();" class="loginBtn" tabindex="340"><?=$LNG_TRANS_CHAR["CW00001"] //확인?></a>
							<div class="loading" style="display:none">
								<img src="/himg/etc/loading.gif">
							</div>
			</th>
		</tr>
		<tr>
			<td><label><?=$LNG_TRANS_CHAR["OW00039"] //성?></label>
				<input type="input" name="pwdLastName" style="width:228px;" tabindex="310"/>
			</td>
		</tr>
		<tr>
			<td><label><?=$LNG_TRANS_CHAR["MW00010"] //이메일?></label>
				<input type="text" name="pwdEmail1" style="width:107px;" tabindex="320"/> @
				<input type="text" name="pwdEmail2" style="width:100px;" tabindex="330"/>
			</td>							
		</tr>
	</table>
</div>
<?php endif;?>