

		<!-- (2) 상단 서브 카테고리 -->
		<?include MALL_HOME."/include/subMenuTopImg.inc.php";?>
		<!-- (2) 상단 서브 카테고리 -->

		<div class="loginFormWrap">
			<!-- 로그인 폼 -->
			<div class="memberLogin mt50">
				<h4><img src="/himg/member/A0001/<?=$S_SITE_LNG_PATH?>/tit_sub_meber_1.gif"/></h4>
				<div class="loginForm mt10">
					<table>
					<?=$strInputCartHtml?>
					<input type="hidden" name="returnMenu" value="<?=$strReturnMenu?>">
					<input type="hidden" name="returnMode" value="<?=$strReturnMode?>">
						<tr>
							<td><label><?=($S_MEM_CERITY=="1")?$LNG_TRANS_CHAR["MW00001"]:$LNG_TRANS_CHAR["MW00010"]; //아이디?></label><input type="input" id="login_id" name="login_id" maxlength="50" tabindex="50" /></td>						
							<th rowspan="2" style="padding-left:10px;"><a href="javascript:goLogin();"><img src="/himg/member/A0001/<?=$S_SITE_LNG_PATH?>/btn_login.gif"/></a></th>
						</tr>
						<tr>
							<td><label><?=$LNG_TRANS_CHAR["MW00002"] //비밀번호?></label><input type="password" id="login_pwd" name="login_pwd" maxlength="20" tabindex="51" onkeydown="if(event.keyCode==13) goLogin();" /></td>
						</tr>
					</table>
				</div><!-- loginForm -->
				<div class="memNaviWrap">
					<dl>
						<dd><a href="./?menuType=member&mode=findIdPwd"><img src="/himg/member/A0001/<?=$S_SITE_LNG_PATH?>/txt_search_idpw.gif"/><img src="/himg/member/A0001/<?=$S_SITE_LNG_PATH?>/btn_go.gif"/></a></dd>
						<dd style="padding-left:40px;"><a href="./?menuType=member&mode=join1"><img src="/himg/member/A0001/<?=$S_SITE_LNG_PATH?>/txt_search_join.gif"/><img src="/himg/member/A0001/<?=$S_SITE_LNG_PATH?>/btn_go.gif"/></a></dd>
					</dl>
				</div>
				<?if ($S_MEM_CERITY=="2"){?>
				<!--<a href="javascript:goFacebookLogin();">Facebook Login</a>//-->
				<?}?>
			</div>
			<!-- 로그인 폼 -->

			<!-- 비회원 로그인 폼 -->
			<div class="nonMemberLogin">
				<?if (is_array($aryCartNo)){?>
					<h4><img src="/himg/member/A0001/<?=$S_SITE_LNG_PATH?>/tit_non_member_order.gif"/></h4>
					<div class="loginForm mt10">
						<a href="javascript:goNonMemberOrder();"><img src="/himg/member/A0001/<?=$S_SITE_LNG_PATH?>/txt_non_member_order.gif" style="vertical-align:middle"/><img src="/himg/member/A0001/<?=$S_SITE_LNG_PATH?>/btn_ok.gif" style="vertical-align:middle"/></a>
					</div><!-- loginForm -->
				<?}else{?>
					<h4><img src="/himg/member/A0001/<?=$S_SITE_LNG_PATH?>/tit_sub_meber_2.gif"/></h4>
					<div class="loginForm mt10">
						<label><?=$LNG_TRANS_CHAR["OW00015"] //주문자?></label><input type="input" name="searchOrderName" id="searchOrderName" style="width:60px" maxlength="30"/>
						<label><?=$LNG_TRANS_CHAR["OW00057"] //주문번호?></label><input type="input" name="searchOrderKey" id="searchOrderKey" maxlength="30"/>
						<a href="javascript:goNonOrderSearch();"><img src="/himg/member/A0001/<?=$S_SITE_LNG_PATH?>/btn_ok.gif" style="vertical-align:middle"/></a>
					</div><!-- loginForm -->
				<?}?>
			</div>
			<!-- 비회원 로그인 폼 -->
		</div><!-- loginFormWrap -->