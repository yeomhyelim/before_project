<?php if($S_SITE_FACEBOOK == "Y" && $S_SITE_FACEBOOK_APP_ID):?>
<?php $aryScriptEx[] = "http://connect.facebook.net/en_US/all.js";?>
<script>
	$(function() {
		FB.init({appId: "<?php echo $S_SITE_FACEBOOK_APP_ID?>", status: true, cookie: true});
	});

	<!--
	  $( document ).ready(function() {	
		<? if($strViewList){?>
		C_getTabChange('tab','2');
		C_getTabChange('comProd','2');
		<?}else{?>
		//goTabChange('tab','1');
		//goTabChange('prodDetail','1');
		C_getTabChange('tab','1');
		C_getTabChange('prodDetail','1');
		<?}?>
	});
</script>
<?php endif;?>

<h2><?=$LNG_TRANS_CHAR["MW00037"] //회원 로그인?></h2>

<!--<div class="tabBtnWrap">
	<a class="btn1 on" href="#;" onclick="C_getTabChange('tab','1')" id="btn-tab1">회원</a>
	<a class="btn2" href="#;" onclick="C_getTabChange('tab','2')" id="btn-tab2">비회원</a>
</div>-->

<div class="loginFormArea" id="tab1">
	<!-- 로그인 폼 -->	
	<div class="loginFormWrap">
		<!-- 로그인시 자판 참조 -->
			<!-- div class="keyboardInfoWrap">
				<a href="#">로그인용 한글자판 보기 <span>▼</span></a>
				<div class="keboardImg">
					<img src="/himg/mobile/key_img_KR.gif">
				</div>									
			</div -->
		<!-- 로그인시 자판 참조 -->

			<?=$strInputCartHtml?>
			<input type="hidden" name="returnMenu" value="<?=$strReturnMenu?>">
			<input type="hidden" name="returnMode" value="<?=$strReturnMode?>">
			<input type="hidden" name="returnParam" value="<?=$strReturnParam?>">

			<input type="text" id="login_id" name="login_id" value="<?php echo $strAutoLoginId;?>" maxlength="50" class="i_id" placeholder=" ID" />
			<input type="password" id="login_pwd" name="login_pwd" maxlength="20" class="i_pw" placeholder=" PW" onkeydown="if(event.keyCode==13) goLogin();" />
			
			<!--<span id="errMsg" style="color:#ff0000;" />-->
			
			<a href="javascript:goLogin();" class="btn_Login btn_red"><?=$LNG_TRANS_CHAR["MW00036"] //로그인?></a>
		
			<?if ($S_MEM_CERITY=="2"){?>
				<div class="snsLoginWrap">
					<a href="javascript:goFacebookLogin();" class="btn_facebook"><span>Login with Facebook</span></a>
				</div>
			<?}?>

			<div class="saveLogin">
				<input type="checkbox" name="chkAutoLogin" value="Y"<?php if($strAutoLoginId) { echo " checked";}?>/> <?=$LNG_TRANS_CHAR["MW00079"] //아이디 저장?>
				<a href="./?menuType=member&mode=findIdPwd" class=""><?=$LNG_TRANS_CHAR["MW00038"] //비밀번호 찾기?></a>
				<div class="clr"></div>
			</div>
	</div>

	<div class="joinBtnWrap">
		<p class="txtJoin"><?=$LNG_TRANS_CHAR["CW00046"] //아직 회원이 아니신가요? ?></p>
		<a href="./?menuType=member&mode=join1" class="btn_GoJoin btn_black"><?=$LNG_TRANS_CHAR["MW00053"] //회원가입?></a>		
	</div>
	<!-- 로그인 폼 -->
</div>

<div class="loginFormWrap" id="tab2" style="display:none;">
	<!-- 비회원 로그인 폼 -->
	<div class="nonMemberLogin">
		<?if (is_array($aryCartNo)){?>
			<div class="nonLoginForm">
				<p class="txtNonInfo"><?=$LNG_TRANS_CHAR["MW00055"] //비회원으로 주문합니다.?></p>
				<a href="javascript:goNonMemberOrder();" class="btn_nonLogin"><span><?=$LNG_TRANS_CHAR["MW00056"]//주문하기?></span></a>
			</div><!-- loginForm -->
		<?}else{?>
			<!--<h2><span><?=$LNG_TRANS_CHAR["MW00039"] // 비회원 로그인?><span></h2>-->
			<div class="nonLoginForm">						
				<div class="loginTableForm">
					<input type="text" name="searchOrderName" id="searchOrderName" maxlength="30" class="i_n_name"/>
					<input type="text" name="searchOrderKey" id="searchOrderKey" maxlength="30" class="i_n_ono"/>
					<a href="javascript:goNonOrderSearch();" class="btn_Login btn_red"><?=$LNG_TRANS_CHAR["CW00001"] //확인?></a>
				</div>
			</div><!-- loginForm -->
		<?}?>
	</div>
	<!-- 비회원 로그인 폼 -->
</div>
			

			
