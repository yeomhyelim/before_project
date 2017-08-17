			<!-- 로그인 폼 -->
				
<!--<h2>LOGIN</h2>-->

<div class="loginForm">
	<?=$strInputCartHtml?>
	<input type="hidden" name="returnMenu" value="<?=$strReturnMenu?>">
	<input type="hidden" name="returnMode" value="<?=$strReturnMode?>">
	<input type="hidden" name="returnParam" value="<?=$strReturnParam?>">
	<ul>
		<!--<li><input type="radio"> 회원 <input type="radio"> 비회원</li>-->
		<li><input type="input" id="login_id" name="login_id" value="<?php echo $strAutoLoginId;?>" maxlength="50" tabindex="50" class="i_w" placeholder=" ID" /></li>
		<li><input type="password" id="login_pwd" name="login_pwd" maxlength="20" tabindex="51" onkeydown="if(event.keyCode==13) goLogin();" class="i_w" placeholder=" PW" /></li>
		<li><a href="javascript:goLogin();" class="loginBtn">LOGIN</a></li>
		<li>
			<div class="left">
				<input type="checkbox" name="chkAutoLogin" value="Y"<?php if($strAutoLoginId) { echo " checked";}?>/> <?php echo $LNG_TRANS_CHAR["MW00079"]; // 아이디저장?>
			</div>
			<div class="right">
				<a href="./?menuType=member&mode=findIdPwd" target="_top" class="btnFindPw"><?=$LNG_TRANS_CHAR["MW00038"] //비밀번호 찾기?></a>
			</div>
			<div class="clr"></div>
		</li>
	</ul>
</div><!-- loginForm -->
<div class="txtJoin">
	<?= $LNG_TRANS_CHAR["MS00161"]; //아직 136601 회원이 아니신가요? ?><a href="./?menuType=member&mode=join1" target="_top" class="btnRegMem"><?=$LNG_TRANS_CHAR["MW00053"] //회원가입?></a> 
</div>