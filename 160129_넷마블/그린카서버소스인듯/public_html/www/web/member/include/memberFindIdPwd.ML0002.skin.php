<?

//	$objEmailInfo = new EmailInfo();
//
//	$param = "";
//	$param['SEND_NAME'] = "hee sung kim";
//	$param['SEND_EMAIL'] = "thav@naver.com";
//	$param['RECEIVE_NAME'] = "park";
//	$param['RECEIVE_EMAIL'] = "ivetmi@eumshop.co.kr";
//	$param['TITLE'] = "aaaaa";
//	$param['TEXT'] = "bbbbb";
//	$objEmailInfo->goSendEmail($param);

	## 라벨 설정
	$strFirstNameLabel = $LNG_TRANS_CHAR["OW00038"]; //이름
	$strLastNameLabel = $LNG_TRANS_CHAR["OW00039"]; //성
	if($S_SITE_LNG == "KR"):
		$strFirstNameLabel = "";
		$strLastNameLabel = $LNG_TRANS_CHAR["OW00038"]; //이름
	endif;
?>
				<?if ($S_MEM_CERITY == "1"){?>
				<!-- 아이디찾기  -->
					<div class="loginForm findFormWrap findIdForm mt40">
						<div class="titWrap"><h3><?=$LNG_TRANS_CHAR["MW00050"] //아이디 찾기?></h3></div>
						<ul>	
							<?if($S_SITE_LNG != "KR"):?>
							<li class="name"><input type="text" name="searchId_F_Name" id="searchId_F_Name" tabindex="10" placeholder="FirstName"/></li>
							<li class="name"><input type="text" name="searchId_L_Name" id="searchId_L_Name" tabindex="20" placeholder="LastName"/></li>
							<li class="mail">								
								<input type="text" name="searchId_Mail1" id="searchId_Mail1" tabindex="30" placeholder="Email"/>@<input type="text" name="searchId_Mail2" id="searchId_Mail2" tabindex="40"/>											
							</li>	
							<li><a href="javascript:goSearchId();" class="loginBtn" tabindex="50"><span><?=$LNG_TRANS_CHAR["CW00001"] //확인?></span></a></li>
							<? else :?>
							<li class="name"><input type="text" name="searchId_L_Name" id="searchId_L_Name" tabindex="20" placeholder="이름"/></li>
							<li class="mail"><input type="text" name="searchId_Mail1" id="searchId_Mail1" tabindex="30" placeholder="Email"/><span>@</span><input type="text" name="searchId_Mail2" id="searchId_Mail2" tabindex="40"/></li>
							<li><a href="javascript:goSearchId();" class="loginBtn" tabindex="50"><span><?=$LNG_TRANS_CHAR["CW00001"] //확인?></span></a></li>
							<?endif;?>	
						</ul>
					</div><!-- loginForm -->
				<!-- 아이디찾기 // -->
				<?}?>

			

		<!-- 비밀번호찾기  -->
					<input type="hidden" name="searchPass_Type" id="searchPass_Type" value="searchPwd" tabindex="100"/>					
					<?if ($S_MEM_CERITY == "1"){?>
					<div class="loginForm findFormWrap findPwForm">
						<div class="titWrap"><h3><?=$LNG_TRANS_CHAR["MW00051"] //비밀번호 찾기?></h3></div>
						<? if($SMS_INFO['S_SMS_USE'] == "Y" && $SMS_TEXT_LIST['005']['SM_AUTO'] == "Y" && $S_SITE_LNG == 'KR') { ?>
							<div class="tabSearchPw">
								<a href="javascript:void(0);" onclick="goSearchPwdType(this, 'searchPwd')" class="on">이메일</a>
								<a href="javascript:void(0);" onclick="goSearchPwdType(this, 'searchPwdSms')">휴대폰</a>
								<div class="clr"></div>
							</div>
						<? } ?>
						<ul>
							<li class="name"><input type="input" name="searchPass_Id" id="searchPass_Id" tabindex="110" placeholder="ID"/></li>
							<?if($S_SITE_LNG!="KR"):?>
							<li class="name"><input type="input" name="searchPass_F_Name" id="searchPass_F_Name" tabindex="120" placeholder="FirstName"/></li>			
							<li class="name"><input type="input" name="searchPass_L_Name" id="searchPass_L_Name" tabindex="130" placeholder="LastName"/></li>
							<? else :?>
							<li class="name"><input type="input" name="searchPass_L_Name" id="searchPass_L_Name" tabindex="130" placeholder="이름"/></li>
							<?endif;?>
							<li id="searchPwd" class="mail">						
								<input type="text" name="searchPass_Mail1" id="searchPass_Mail1" tabindex="140" placeholder="Email"/>@
								<input type="text" name="searchPass_Mail2" id="searchPass_Mail2" tabindex="150"/>										
							</li>
							<li id="searchPwdSms" style="display:none;">				
								<label><?=$LNG_TRANS_CHAR["MW00008"]; //휴대폰?></label>
								<input type="text" name="searchPass_Hp1" id="searchPass_Hp1"  style="width:40px;" tabindex="160"/> - 
								<input type="text" name="searchPass_Hp2" id="searchPass_Hp2"  style="width:60px;" tabindex="170"/> - 
								<input type="text" name="searchPass_Hp3" id="searchPass_Hp3"  style="width:60px;" tabindex="180"/>										
							</li>
							<li><a href="javascript:goSearchPwd();" class="loginBtn" tabindex="190"><span><?=$LNG_TRANS_CHAR["CW00001"] //확인?></span></a></li>
						</ul>
					</div>
					<?}?>
				

					<?if ($S_MEM_CERITY == "2"){?>
					<? /**
						* 로그인 아이디가 이메일인 경우 $S_MEM_CERITY 값은 2가 됩니다.
						* 아이디가 이메일인경우 아이디 찾기는 없음, 비밀번호 찾기만 있음.	
						**/
					?>
					<div class="loginForm findEmail">
						<h3><?=$LNG_TRANS_CHAR["MW00050"] //아이디 찾기?></h3>
						<ul>
							<li>
								<label><?=$LNG_TRANS_CHAR["OW00038"] //이름?></label><input type="text" name="findIDName"  style="width:215px;">
								<a href="javascript:goMemberFindIdPwdFindEmailActEvent()" class="loginBtn"><?=$LNG_TRANS_CHAR["CW00001"] //확인?></a>
							</li>
							<li>
								<label><?=$LNG_TRANS_CHAR["MW00008"]; //휴대폰?></label>
								<select name="findIDHp1" class="selectForm">
									<option value="010">010</option>
									<option value="011">011</option>
									<option value="016">016</option>
									<option value="017">017</option>
									<option value="018">018</option>
									<option value="019">019</option>
								</select>-
								<input type="text" name="findIDHp2" style="width:72px;"> -
								<input type="text" name="findIDHp3" style="width:72px;"> 								
							</li>
						</ul>
					</div>


					<div class="loginForm findPasswd">
						<h3><?=$LNG_TRANS_CHAR["MW00051"] //비밀번호 찾기?></h3>
						<ul>							
							<?if ($S_MEMBER_PWD_FIND_ID_USE == "Y"){?>
							<li>
								<label><?=$LNG_TRANS_CHAR["MW00001"] //아이디?></label><input type="input" name="searchPass_Id" id="searchPass_Id"  style="width:100px;" tabindex="200"/>
								<a href="javascript:goSearchPwd();" class="loginBtn"  tabindex="240"><?=$LNG_TRANS_CHAR["CW00001"] //확인?></a>
							</li>
							<?}else{?>
							<li>
								<label><?=$LNG_TRANS_CHAR["OW00038"] //이름?></label><input type="input" name="searchPass_L_Name" id="searchPass_L_Name"  style="width:215px;" tabindex="200"/>
								<a href="javascript:goSearchPwd();" class="loginBtn"  tabindex="240"><?=$LNG_TRANS_CHAR["CW00001"] //확인?></a>
							</li>
							
							<?if($S_SITE_LNG!="KR"):?>
							<li>
								<label><?=$LNG_TRANS_CHAR["OW00039"] //성?></label><input type="input" name="searchPass_F_Name" id="searchPass_F_Name"  style="width:100px;" tabindex="210"/>
							</li>
							<?endif;?>
							<?}?>
							<li>
								<label><?=$LNG_TRANS_CHAR["MW00010"] //이메일?></label><input type="text" name="searchPass_Mail1" id="searchPass_Mail1"  style="width:100px;"  tabindex="220"/>@
								<input type="text" name="searchPass_Mail2" id="searchPass_Mail2"  style="width:100px;"  tabindex="230"/>														
							</li>
						</ul>
				</div><!-- loginForm -->
				<div class="clr"></div>
			<?}?>
		<!-- 비밀번호찾기//  -->

			