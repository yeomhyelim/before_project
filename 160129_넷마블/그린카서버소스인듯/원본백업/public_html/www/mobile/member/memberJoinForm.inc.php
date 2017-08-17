<?php if($S_SITE_FACEBOOK == "Y" && $S_SITE_FACEBOOK_APP_ID):?>
<?php $aryScriptEx[] = "http://connect.facebook.net/en_US/all.js";?>
<?php $aryScriptEx[] = "/common/js/jquery.countdown.js";?>
<script>
	$(function() {
		FB.init({appId: "<?php echo $S_SITE_FACEBOOK_APP_ID?>", status: true, cookie: true});
	});
</script>
<?php endif;?>
	<div class="regStepWrap">
			<ul>
				<li class="step_1">
					<span><?=$LNG_TRANS_CHAR["MW00040"] //약관동의?></span>
					<div class="stepIco"></div>
				</li>
				<li class="step_2 stepOn">
					<span><?=$LNG_TRANS_CHAR["CW00047"] //회원가입신청?></span>
					<div class="stepIcoOn"></div>
				</li>
				<li class="step_3">
					<span><?=$LNG_TRANS_CHAR["MW00080"] //가입완료?></span>
				</li>
			</ul>
			<div class="clr"></div>
		</div>


			<div class="joinApplyWrap">
					<?if ($S_MEM_CERITY == "2"){?>
						<h4><span><?=$LNG_TRANS_CHAR["MS00049"] //페이스북으로 회원가입?></span></h4>

						<!-- 페이스북 회원가입 안내-->
						<div class="snsLoginWrap">
							<p class="faceBookTxt"><span><?=$LNG_TRANS_CHAR["MS00050"] //페이스북 계정으로 회원가입이 가능합니다.  아래 버튼을 클릭 하세요.?></p>
							<a href="javascript:goFacebookLogin();" class="btn_facebook"><span>Sign-in with Facebook</span></a>
							<div class="orWrap"><div class="orTxt">OR</div></div>
						</div>
					<?}?>

				<div class="titBox"><span class="barRed"></span><span class="tit"><?=$LNG_TRANS_CHAR["MW00046"] //회원기본 정보?></span></div>
				<div class="txtInfo">  <?=$LNG_TRANS_CHAR["CS00002"] // * 는 필수입력 항목입니다.?></div>
			<!-- (1) 기본정보 입력  -->
				<div class="joinTableWrap">
					<table class="tableFormType">
					<tr>
							<th><?= $LNG_TRANS_CHAR["MW00091"]; //회원구분 ?><strong>*</strong></th>
							<td class="memSelect">	
								<input type="radio" name="memberGroup" value="002" onclick = "javascript:memberGradeCheck();" checked/><span><?= $LNG_TRANS_CHAR["MW00092"]; //개인 ?></span>
								<input type="radio" name="memberGroup" value="005" onclick = "javascript:memberGradeCheck();"/><span><?= $LNG_TRANS_CHAR["MW00093"]; //사업자 ?></span>
							</td>
						</tr>

						<!--아이디-->
						<?if ($S_MEM_CERITY == "1"){?>
							<?if ($S_JOIN_ID["USE"] == "Y" && $S_JOIN_ID["JOIN"] == "Y"){?>
								<?if (!$S_JOIN_ID["GRADE"] || in_array($strMemberJoinType,$S_JOIN_ID["GRADE"])){?>
									<tr>
										<th><?=$LNG_TRANS_CHAR["MW00001"] //아이디?><strong>*</strong></th>
										<td>
											<input type="text" id="id" name="id" class="i_w" maxlength="12"/> <a href="javascript:goIdChk();" class="btn_chk_id"><?=$LNG_TRANS_CHAR["MW00059"]//아이디검색?></a>
											<p class="tdTextGuide"><?=$LNG_TRANS_CHAR["MS00003"] //영문, 숫자 중 4자 이상 12자리 이하 사용?> </p>
										</td>
									</tr>			
								<?}?>
							<?}?>
						<?}?>
						<!--아이디-->

						<!--이름 (이메일 로그인)-->
						<?if ($S_MEM_CERITY == "2"){?>
							<?if ($S_JOIN_NAME["USE"] == "Y" && $S_JOIN_NAME["JOIN"] == "Y"){?>
								<?if (!$S_JOIN_NAME["GRADE"] || in_array($strMemberJoinType,$S_JOIN_NAME["GRADE"])){?>
									<?if($S_SITE_LNG != "KR"): // 다국어 일때만?>
										<tr>
											<th><?=$LNG_TRANS_CHAR["MW00012"] //성?> <strong>*</strong></th>
											<td><input type="text" id="f_name" name="f_name" class="i_w" maxlength="20"/></td>
										</tr>
													<?endif;?>
										<tr>
											<th><?=$LNG_TRANS_CHAR["MW00004"] //이름?> <strong>*</strong></th>
											<td><input type="text" id="l_name" name="l_name" class="i_w" maxlength="20" value="<?=$strRequestName?>"/></td>
										</tr>
								<?}?>
							<?}?>
						<?}?>
						<!--이름-->

						<!-- 이메일 로그인 이용시 -->
						<?if ($S_MEM_CERITY=="2"){?>
							<?if ($S_JOIN_MAIL["USE"] == "Y" && $S_JOIN_MAIL["JOIN"] == "Y"){?>
								<?if (!$S_JOIN_MAIL["GRADE"] || in_array($strMemberJoinType,$S_JOIN_MAIL["GRADE"])){?>
										<tr>
											<th><?=$LNG_TRANS_CHAR["MW00010"] //이메일?><?=($S_JOIN_MAIL["NES"]=="Y")?" <strong>*</strong>":"<strong></strong>";?> </th>
											<td>
												<input type="email" id="mail" name="mail" class="i_w" maxlength="30"/>
												<p class="tdTextGuide">로그인 아이디는 이메일을 사용합니다. 사용하시는 이메일을 등록해 주세요. </p>
												<?if ($S_JOIN_MAILYN["USE"] == "Y" && $S_JOIN_MAILYN["JOIN"] == "Y"){?>
													<?if (!$S_JOIN_MAILYN["GRADE"] || in_array($strMemberJoinType,$S_JOIN_MAILYN["GRADE"])){?>
													<p class="emailChk"><input type="checkbox" id="mailYN" name="mailYN" value="Y" checked/> <?=$LNG_TRANS_CHAR["MS00008"] //메일 정보를 수신합니다.?> </p>
													<?}?>
												<?}?>
											</td>
										</tr>
								<?}?>
							<?}?>
						<?}?>
						<!-- 이메일 로그인 이용시 -->

						<!--비밀번호-->
						<?if ($S_JOIN_PASS["USE"] == "Y" && $S_JOIN_PASS["JOIN"] == "Y"){?>
							<?if (!$S_JOIN_PASS["GRADE"] || in_array($strMemberJoinType,$S_JOIN_PASS["GRADE"])){?>
									<tr>
										<th><?=$LNG_TRANS_CHAR["MW00002"] //비밀번호?> <strong>*</strong></th>
										<td>
											<input type="password" id="pwd1" name="pwd1" class="i_w" maxlength="16"/>
											<p class="tdTextGuide"><?=$LNG_TRANS_CHAR["MS00004"] //영문, 숫자, 특수문자 중 4자 이상 16자리 이하 사용?> </p>
										</td>
									</tr>
									<tr>
										<th><?=$LNG_TRANS_CHAR["MW00003"] //비밀번호 확인?> <strong>*</strong></th>
										<td>
											<input type="password" id="pwd2" name="pwd2" class="i_w" maxlength="16"/>
											<p class="tdTextGuide"><?=$LNG_TRANS_CHAR["MS00005"] //비밀번호를 한번더 입력해 주세요.?> </p>
										</td>
									</tr>
							<?}?>
						<?}?>
						<!--비밀번호-->

						<!--이름(아이디 로그인)-->
						<?if ($S_MEM_CERITY == "1"){?>
							<?if ($S_JOIN_NAME["USE"] == "Y" && $S_JOIN_NAME["JOIN"] == "Y"){?>
								<?if (!$S_JOIN_NAME["GRADE"] || in_array($strMemberJoinType,$S_JOIN_NAME["GRADE"])){?>
									<?if($S_SITE_LNG != "KR"): // 다국어 일때만?>
										<tr>
											<th><?=$LNG_TRANS_CHAR["MW00012"] //성?> <strong>*</strong></th>
											<td><input type="text" id="f_name" name="f_name" class="i_w" maxlength="20"/></td>
										</tr>
									<?endif;?>
										<tr>
											<th><?=$LNG_TRANS_CHAR["MW00004"] //이름?> <strong>*</strong></th>
											<td><input type="text" id="l_name" name="l_name" class="i_w" maxlength="20" value="<?=$strRequestName?>"/></td>
										</tr>
								<?}?>
							<?}?>
						<?}?>
						<!--이름-->
						<!-- 닉네임 -->
						<?if ($S_JOIN_NICKNAME["USE"] == "Y" && $S_JOIN_NICKNAME["JOIN"] == "Y"){?>
							<?if (!$S_JOIN_NICKNAME["GRADE"] || in_array($strMemberJoinType,$S_JOIN_NICKNAME["GRADE"])){?>
									<tr>
										<th><?=$LNG_TRANS_CHAR["MW00005"] //닉네임?> <strong>*</strong></th>
										<td>
											<input type="text" id="nickname" name="nickname"  class="i_w" maxlength="16"/> <a href="javascript:goNickNameChk();"  class="btn_Addr"><span>중복검색</span></a>
											<p class="tdTextGuide"><?=$LNG_TRANS_CHAR["MS00006"] //한글, 영문, 숫자 중 4자 이상 16자리 이하 사용?> </p>
										</td>
									</tr>
							<?}?>
						<?}?>
						<!-- 닉네임 -->
						<!-- 생년월일/음력/양력 -->
						<?if ($S_JOIN_BIRTH["USE"] == "Y" && $S_JOIN_BIRTH["JOIN"] == "Y"){?>
							<?if (!$S_JOIN_BIRTH["GRADE"] || in_array($strMemberJoinType,$S_JOIN_BIRTH["GRADE"])){?>
									<tr>
										<th><?=$LNG_TRANS_CHAR["MW00006"] //생년월일?> <strong>*</strong></th>
										<td>
											<?if($S_SITE_LNG == "KR"):?>
											<input type="tel" id="birth1" name="birth1" class="i_date" maxlength="4" value="<?=$strBirth1?>" <?=($strRequestSafeId)?"readonly":"";?>/><?=$LNG_TRANS_CHAR["CW00010"] //년?>
											<input type="tel" id="birth2" name="birth2" class="i_date" maxlength="2" value="<?=$strBirth2?>" <?=($strRequestSafeId)?"readonly":"";?>/><?=$LNG_TRANS_CHAR["CW00011"] //월?>
											<input type="tel" id="birth3" name="birth3" class="i_date" maxlength="2" value="<?=$strBirth3?>" <?=($strRequestSafeId)?"readonly":"";?>/><?=$LNG_TRANS_CHAR["CW00012"] //일?>
											<?if ($S_JOIN_BIRTH_CAL["USE"] == "Y" && $S_JOIN_BIRTH_CAL["JOIN"] == "Y"){?>
												<?if (!$S_JOIN_BIRTH_CAL["GRADE"] || in_array($strMemberJoinType,$S_JOIN_BIRTH_CAL["GRADE"])){?>
													<p>
														<input type="radio" id="birth_cal" name="birth_cal" value="1"/><?=$LNG_TRANS_CHAR["MW00015"] //음력?>
														<input type="radio" id="birth_cal" name="birth_cal" value="2" checked/><?=$LNG_TRANS_CHAR["MW00016"] //양력?>
													</p>
												<?}?>
											<?}?>
											<?else:?>
											<input type="tel" id="birth3" name="birth3" class="i_date" maxlength="2"/>/
											<input type="tel" id="birth2" name="birth2" class="i_date" maxlength="2"/>/
											<input type="tel" id="birth1" name="birth1" class="i_date" maxlength="4"/> (<?=$LNG_TRANS_CHAR["CW00012"] //일?>/<?=$LNG_TRANS_CHAR["CW00011"] //월?>/<?=$LNG_TRANS_CHAR["CW00010"] //년?>)
											<?endif;?>
										</td>
									</tr>
							<?}?>
						<?}?>
						<!-- 성별 -->
						<?if ($S_JOIN_SEX["USE"] == "Y" && $S_JOIN_SEX["JOIN"] == "Y"){?>
							<?if (!$S_JOIN_SEX["GRADE"] || in_array($strMemberJoinType,$S_JOIN_SEX["GRADE"])){?>
									<tr>
										<th><?=$LNG_TRANS_CHAR["MW00007"] //성별?> <strong>*</strong></th>
										<td>
											<input type="radio" id="sex" name="sex" value="M" <?=($strSex == "M" || !$strSex)?"checked":"";?>/> <?=$LNG_TRANS_CHAR["CW00008"] //남자?> <input type="radio" name="sex" id="sex" value="W" <?=($strSex == "W")?"checked":"";?>/> <?=$LNG_TRANS_CHAR["CW00009"] //여자?>
										</td>
									</tr>
							<?}?>
						<?}?>
						<!-- 성별 -->
						<!-- 핸드폰 -->
						<?if ($S_JOIN_HP["USE"] == "Y" && $S_JOIN_HP["JOIN"] == "Y"){?>
							<?if (!$S_JOIN_HP["GRADE"] || in_array($strMemberJoinType,$S_JOIN_HP["GRADE"])){?>
						<tr>
							<th><?=$LNG_TRANS_CHAR["MW00008"] //핸드폰?> <?=($S_JOIN_HP["NES"]=="Y")?"<strong>*</strong>":"<strong></strong>";?></th>
							<td>
								<?if ($S_SITE_LNG == "KR"){?>
								<?=drawSelectBoxMore("hp1",$aryHp,$aryMemHp[0],$design ="telSelect",$onchange="",$etc="id=\"hp1\"",$firstItem="",$html="N")?>
								 -
								<input type="tel" id="hp2" name="hp2"  class="i_tel" maxlength="4" autoMove="hp3" value="<?=$aryMemHp[1]?>"/> -
								<input type="tel" id="hp3" name="hp3"  class="i_tel" maxlength="4" value="<?=$aryMemHp[2]?>"/>

								<!-- 휴대폰 인증 -->
								<?if($phoneCheck == "Y"):?>
									<span id="memberPhoneKeyRequest"><a href="javascript:goMemberPhoneKeyRequestEvent();" class="btnIDChk">휴대폰 인증</a></span>
									<div style="padding: 3px 0;color:#55ac20" id="memberPhoneKeyMsg">
										* 사용할 휴대푠 번호를 정확히 입력한 후 인증 버튼을 눌러주세요.
									</div>
									<input type="text" name="phoneKey" value="" style="display:none;"/>
										<span class="btnSmsChkOk" id="memberPhoneKeyCheck" style="display:none;">
											<a href="javascript:goMemberPhoneKeyCheckEvent();" class="btnIDChk">확인</a>
											<span style="font-weight:bold;font-size:14px;" id="memberPhoneKeyCountDown" data-seconds="10"></span>
											<div style="padding: 3px 0;color:#55ac20">
											* 고객님이 입력하신 휴대폰 번호로 <strong>인증번호를 발송</strong>하였습니다.<br>
											&nbsp;&nbsp;&nbsp;&nbsp;인증번호를 확인한 후 입력해 주세요.<br>
											* 간혹 스팸문자로 인식되어 도착되지 않는경우가 있습니다.  메시지가 전송되지 않는경우 스팸관리를 확인해 주세요.

										</div>
										</span>


								<?endif;?>
								<!-- 휴대폰 인증 -->

								<?}else{?>
								<input type="text" id="hp1" name="hp1" class="defInput _w200" maxlength="30" value="<?=$memberRow[M_HP]?>"/>
								<?}?>

								<?if ($S_JOIN_SMSYN["USE"] == "Y" && $S_JOIN_SMSYN["JOIN"] == "Y"){?>
									<?if (!$S_JOIN_SMSYN["GRADE"] || in_array($strMemberJoinType,$S_JOIN_SMSYN["GRADE"])){?>
									<p class="txt_Minfo"><input type="checkbox" name="smsYN" id="smsYN" value="Y" checked/> <?=$LNG_TRANS_CHAR["MS00007"] //SMS 정보를 수신합니다.?> </p>
									<?}?>
								<?}?>
							</td>
						</tr>
							<?}?>
						<?}?>
						<!-- 핸드폰 -->
						<!-- 전화번호 -->
						<?if ($S_JOIN_PHONE["USE"] == "Y" && $S_JOIN_PHONE["JOIN"] == "Y"){?>
							<?if (!$S_JOIN_PHONE["GRADE"] || in_array($strMemberJoinType,$S_JOIN_PHONE["GRADE"])){?>
									<tr class="comView" style="display:none;">
										<th><?=$LNG_TRANS_CHAR["MW00009"] //전화번호?><?=($S_JOIN_PHONE["NES"]=="Y")?"<strong>*</strong>":"<strong></strong>";?></th>
										<td>
											<?if ($S_SITE_LNG == "KR"){?>
											<?=drawSelectBoxMore("phone1",$aryPhone,$aryMemPhone[0],$design ="telSelect",$onchange="",$etc="id=\"phone1\"",$firstItem="",$html="N")?>
											 -
											<input type="tel" id="phone2" name="phone2" class="i_tel" maxlength="4" value="<?=$aryMemPhone[1]?>"/> -
											<input type="tel" id="phone3" name="phone3" class="i_tel" maxlength="4" value="<?=$aryMemPhone[2]?>"/>
											<?}else {?>
												<input type="text" id="phone1" name="phone1" class="i_w" maxlength="30" value="<?=$memberRow[M_PHONE]?>"/>
											<?}?>
										</td>
									</tr>
							<?}?>
						<?}?>
						<!-- 전화번호 -->
						<!-- 팩스번호 -->
						<?if ($S_JOIN_FAX["USE"] == "Y" && $S_JOIN_FAX["JOIN"] == "Y"){?>
							<?if (!$S_JOIN_FAX["GRADE"] || in_array($strMemberJoinType,$S_JOIN_FAX["GRADE"])){?>
									<tr>
										<th><?=$LNG_TRANS_CHAR["MW00017"] //팩스번호?><?=($S_JOIN_FAX["NES"]=="Y")?"<strong>*</strong>":"<strong></strong>";?></th>
										<td>
											<?if ($S_SITE_LNG == "KR"){?>
											<?=drawSelectBoxMore("fax1",$aryPhone,$aryMemFax[0],$design ="defSelect",$onchange="",$etc="",$firstItem="",$html="N")?>
											 -
											<input type="tel" id="fax2" name="fax2" class="i_tel" maxlength="4" value="<?=$aryMemFax[1]?>"/> -
											<input type="tel" id="fax3" name="fax3" class="i_tel" maxlength="4" value="<?=$aryMemFax[2]?>"/>
											<?}else {?>
												<input type="text" id="fax1" name="fax1" class="i_w" maxlength="30" value="<?=$memberRow[M_FAX]?>"/>
											<?}?>
										</td>
									</tr>
							<?}?>
						<?}?>
						<!-- 팩스번호 -->
						<!-- 이메일 -->
						<?if ($S_MEM_CERITY=="1"){?>
							<?if ($S_JOIN_MAIL["USE"] == "Y" && $S_JOIN_MAIL["JOIN"] == "Y"){?>
								<?if (!$S_JOIN_MAIL["GRADE"] || in_array($strMemberJoinType,$S_JOIN_MAIL["GRADE"])){?>
										<tr>
											<th><?=$LNG_TRANS_CHAR["MW00010"] //이메일?><?=($S_JOIN_MAIL["NES"]=="Y")?"<strong>*</strong>":"<strong></strong>";?> </th>
											<td>
												<input type="email" id="mail" name="mail" class="i_w" maxlength="100"/>
												<?if ($S_JOIN_MAILYN["USE"] == "Y" && $S_JOIN_MAILYN["JOIN"] == "Y"){?>
													<?if (!$S_JOIN_MAILYN["GRADE"] || in_array($strMemberJoinType,$S_JOIN_MAILYN["GRADE"])){?>
													<p class="emailChk"><input type="checkbox" id="mailYN" name="mailYN" value="Y" checked/> <?=$LNG_TRANS_CHAR["MS00008"] //메일 정보를 수신합니다.?> </p>
													<?}?>
												<?}?>
											</td>
										</tr>
								<?}?>
							<?}?>
						<?}?>
						<!-- 이메일 -->
						<!-- 주소 -->
						<?if ($S_JOIN_ADDR["USE"] == "Y" && $S_JOIN_ADDR["JOIN"] == "Y"){?>
							<?if (!$S_JOIN_ADDR["GRADE"] || in_array($strMemberJoinType,$S_JOIN_ADDR["GRADE"])){?>
								<?if ($S_SITE_LNG == "KR"){?>
									<tr>
										<th><?=$LNG_TRANS_CHAR["MW00011"] //주소?><?=($S_JOIN_ADDR["NES"]=="Y")?"<strong>*</strong>":"<strong></strong>";?></th>
										<td>
											<div class="zipCodeWrap">
													<input type="tel" id="zip1" name="zip1" maxlength="3" readonly/>
													<span>-</span>
													<input type="tel" id="zip2" name="zip2" maxlength="3" readonly/>
												<div class="clr"></div>
											</div>
											<a href="javascript:goZip(1);" class="btn_Addr"><span>우편번호검색</span></a>
											<dl>

												<dd><input type="text" id="addr1" name="addr1" class="i_w" maxlength="200" readonly/></dd>
												<dd><input type="text" id="addr2" name="addr2" class="i_w" maxlength="200"/></dd>
											</dl>
										</td>
									</tr>
								<?}else{?>
									<tr>
										<th><?=$LNG_TRANS_CHAR["MW00021"] //국가?><?=($S_JOIN_ADDR["NES"]=="Y")?"<strong>*</strong>":"<strong></strong>";?></th>
										<td>
											<?=drawSelectBoxMore("country",$aryCountryList,$memberRow[M_COUNTRY],$design ="",$onchange="",$etc="",$firstItem="= Country =",$html="N")?>
										</td>
									</tr>
									<tr>
										<th><?=$LNG_TRANS_CHAR["MW00011"] //주소?><?=($S_JOIN_ADDR["NES"]=="Y")?"<strong>*</strong>":"<strong></strong>";?> </th>
										<td>
											<dl>
												<dd><input type="text" id="addr1" name="addr1" class="i_w" maxlength="200"/></dd>
											</dl>
										</td>
									</tr>
									<tr>
										<th><?=$LNG_TRANS_CHAR["MW00013"] //상세주소?><?=($S_JOIN_ADDR["NES"]=="Y")?"<strong>*</strong>":"<strong></strong>";?> </th>
										<td>
											<dl>
												<dd><input type="text" id="addr2" name="addr2" class="i_w" maxlength="200"/></dd>
											</dl>
										</td>
									</tr>
									<tr>
										<th><?=$LNG_TRANS_CHAR["MW00022"] //도시?><?=($S_JOIN_ADDR["NES"]=="Y")?"<strong>*</strong>":"<strong></strong>";?> </th>
										<td>
											<dl>
												<dd><input type="text" id="city" name="city" class="i_w" maxlength="200"/></dd>
											</dl>
										</td>
									</tr>
									<tr>
										<th><?=$LNG_TRANS_CHAR["MW00023"] //주?> </th>
										<td>
											<div id="divState1" <?=($memberRow[M_COUNTRY]=="US")?"style=\"display:none\"":"";?>>
												<input type="text" id="state_1" name="state_1" value="N/A" class="defInput _w200" maxlength="50" value="<?=$memberRow[M_STATE]?>"/>
											</div>
											<div id="divState2" <?=($memberRow[M_COUNTRY]!="US")?"style=\"display:none\"":"";?>>
												<?=drawSelectBoxMore("state_2",$aryCountryState,$memberRow[M_STATE],$design="",$onchange="",$etc="",$firstItem="= State =",$html="N")?>
											</div>
										</td>
									</tr>
									<tr>
										<th><?=$LNG_TRANS_CHAR["MW00014"] //우편번호?><?=($S_JOIN_ADDR["NES"]=="Y")?"<strong>*</strong>":"<strong></strong>";?> </th>
										<td>
											<dl>
												<dd><input type="tel" id="zip1" name="zip1" class="defInput _w100" maxlength="20"></dd>
											</dl>
										</td>
									</tr>
								<?}?>
							<?}?>
						<?}?>
						<!-- 주소 -->
						<!-- 사진 -->
						<?if ($S_JOIN_PHOTO["USE"] == "Y" && $S_JOIN_PHOTO["JOIN"] == "Y"){?>
							<?if (!$S_JOIN_PHOTO["GRADE"] || in_array($strMemberJoinType,$S_JOIN_PHOTO["GRADE"])){?>
									<tr>
										<th><?=$LNG_TRANS_CHAR["MW00018"] //사진?><?=($S_JOIN_PHOTO["NES"]=="Y")?"<strong>*</strong>":"<strong></strong>";?></th>
										<td>
											<input type="file" id="photo" name="photo" class="i_w"/>
										</td>
									</tr>
							<?}?>
						<?}?>
						<!-- 사진 -->
						<!-- 추천인 -->
						<?if ($S_JOIN_REC["USE"] == "Y" && $S_JOIN_REC["JOIN"] == "Y"){?>
							<?if (!$S_JOIN_REC["GRADE"] || in_array($strMemberJoinType,$S_JOIN_REC["GRADE"])){?>
									<tr>
										<th><?=$LNG_TRANS_CHAR["MW00019"] //추천인?><?=($S_JOIN_REC["NES"]=="Y")?"<strong>*</strong>":"<strong></strong>";?></th>
										<td>
											<input type="text" id="rec_id" name="rec_id"  class="i_w" maxlength="50"/>
										</td>
									</tr>
							<?}?>
						<?}?>
						<!-- 추천인 -->
						<!-- 회사명 -->
						<?if ($S_JOIN_COM["USE"] == "Y" && $S_JOIN_COM["JOIN"] == "Y"){?>
							<?if (!$S_JOIN_COM["GRADE"] || in_array($strMemberJoinType,$S_JOIN_COM["GRADE"])){?>
									<tr>
										<th><?=$LNG_TRANS_CHAR["MW00020"] //회사명?><?=($S_JOIN_COM["NES"]=="Y")?"<strong>*</strong>":"<strong></strong>";?></th>
										<td>
											<input type="text" id="com_nm" name="com_nm" class="i_w" maxlength="50"/>
										</td>
									</tr>
							<?}?>
						<?}?>
						<!-- 회사명 -->
						<!-- TM ID -->
						<?if ($S_JOIN_TM_ID["USE"] == "Y" && $S_JOIN_TM_ID["JOIN"] == "Y"){?>
							<?if (!$S_JOIN_TM_ID["GRADE"] || in_array($strMemberJoinType,$S_JOIN_TM_ID["GRADE"])){?>
									<tr>
										<th> TM코드<?=($S_JOIN_TM_ID["NES"]=="Y")?"<strong>*</strong>":"<strong></strong>";?></th>
										<td>
											<input type="text" id="tm_id" name="tm_id" class="i_w" maxlength="20"/>
										</td>
									</tr>
							<?}?>
						<?}?>
						<!-- TM ID -->
						<?if ($S_JOIN_TMP_1["USE"] == "Y" && $S_JOIN_TMP_1["JOIN"] == "Y"){?>
							<?if (!$S_JOIN_TMP_1["GRADE"] || in_array($strMemberJoinType,$S_JOIN_TMP_1["GRADE"])){?>
									<tr>
										<th><?=$S_JOIN_TMP_1["NAME_".$S_SITE_LNG] //임시필드?><?=($S_JOIN_TMP_1["NES"]=="Y")?"<strong>*</strong>":"<strong></strong>";?></th>
										<td>
											<?if ($S_JOIN_TMP_1["TYPE"] == "T"){?>
											<input type="text" id="tmp1" name="tmp1" class="defInput _w200" maxlength="50"/>
											<?}?>
											<?if ($S_JOIN_TMP_1["TYPE"] == "S"){
												$aryJoinTmp1Val = explode(";",$S_JOIN_TMP_1["TYPE_VAL"]);
											?>
											<?=drawSelectBox("tmp1",$aryJoinTmp1Val,$selected ="",$design ="defSelect",$onchange="",$etc="",$LNG_TRANS_CHAR["CW00039"])?>
											<?}?>
										</td>
									</tr>
							<?}?>
						<?}?>
						<?if ($S_JOIN_TMP_2["USE"] == "Y" && $S_JOIN_TMP_2["JOIN"] == "Y"){?>
							<?if (!$S_JOIN_TMP_2["GRADE"] || in_array($strMemberJoinType,$S_JOIN_TMP_2["GRADE"])){?>
									<tr>
										<th><?=$S_JOIN_TMP_2["NAME_".$S_SITE_LNG] //임시필드?><?=($S_JOIN_TMP_2["NES"]=="Y")?"<strong>*</strong>":"<strong></strong>";?></th>
										<td>
											<input type="text" id="tmp2" name="tmp2" class="defInput _w200" maxlength="50"/>
										</td>
									</tr>
							<?}?>
						<?}?>
						<?if ($S_JOIN_TMP_3["USE"] == "Y" && $S_JOIN_TMP_3["JOIN"] == "Y"){?>
							<?if (!$S_JOIN_TMP_3["GRADE"] || in_array($strMemberJoinType,$S_JOIN_TMP_3["GRADE"])){?>
									<tr>
										<th><?=$S_JOIN_TMP_4["NAME_".$S_SITE_LNG] //임시필드?><?=($S_JOIN_TMP_3["NES"]=="Y")?"<strong>*</strong>":"<strong></strong>";?></th>
										<td>
											<input type="text" id="tmp3" name="tmp3" class="defInput _w200" maxlength="50"/>
										</td>
									</tr>
							<?}?>
						<?}?>
						<?if ($S_JOIN_TMP_4["USE"] == "Y" && $S_JOIN_TMP_4["JOIN"] == "Y"){?>
							<?if (!$S_JOIN_TMP_4["GRADE"] || in_array($strMemberJoinType,$S_JOIN_TMP_4["GRADE"])){?>
									<tr>
										<th><?=$S_JOIN_TMP_4["NAME_".$S_SITE_LNG] //임시필드?><?=($S_JOIN_TMP_4["NES"]=="Y")?"<strong>*</strong>":"<strong></strong>";?></th>
										<td>
											<input type="text" id="tmp4" name="tmp4" class="defInput _w200" maxlength="50"/>
										</td>
									</tr>
							<?}?>
						<?}?>
						<?if ($S_JOIN_TMP_5["USE"] == "Y" && $S_JOIN_TMP_5["JOIN"] == "Y"){?>
							<?if (!$S_JOIN_TMP_5["GRADE"] || in_array($strMemberJoinType,$S_JOIN_TMP_5["GRADE"])){?>
									<tr>
										<th><?=$S_JOIN_TMP_5["NAME_".$S_SITE_LNG] //임시필드?><?=($S_JOIN_TMP_5["NES"]=="Y")?"<strong>*</strong>":"<strong></strong>";?></th>
										<td>
											<input type="text" id="tmp5" name="tmp5" class="defInput _w200" maxlength="50"/>
										</td>
									</tr>
							<?}?>
						<?}?>
						<!--임시필드-->
					</table>
				</div><!-- regWrap -->


				<?if ($S_JOIN_BUSI_INFO["USE"] == "Y"){?>
				<div class="titBox mt30 comView" style="display:none;"><span class="barRed"></span><span class="tit"><?=$LNG_TRANS_CHAR["MW00049"] //사업자 정보?></span></div>
				<div class="regWrap joinTableWrap comView" style="display:none;">
					<table class="tableFormType">
						<colgroup>
							<col/>
							<col/>
						</colgroup>
						<!-- 상호명 -->
						<?if ($S_JOIN_BUSI_NM["USE"] == "Y" && $S_JOIN_BUSI_NM["JOIN"] == "Y"){?>
							<?if (!$S_JOIN_BUSI_NM["GRADE"] || in_array($strMemberJoinType,$S_JOIN_BUSI_NM["GRADE"])){?>
						<tr>
							<th><?=$LNG_TRANS_CHAR["MW00032"] //상호명?><?=($S_JOIN_BUSI_NM["NES"]=="Y")?"<strong>*</strong>":"<strong></strong>";?></th>
							<td>
								<input type="text" id="busi_nm" name="busi_nm" class="i_w" maxlength="50" value="<?=$memberRow[BUSI_NM]?>"/>
							</td>
						</tr>
							<?}?>
						<?}?>
						<!-- 상호명 -->
						<!-- 사업자번호 -->
						<?if ($S_JOIN_BUSI_NUM["USE"] == "Y" && $S_JOIN_BUSI_NUM["JOIN"] == "Y"){?>
							<?if (!$S_JOIN_BUSI_NUM["GRADE"] || in_array($strMemberJoinType,$S_JOIN_BUSI_NUM["GRADE"])){?>
						<tr>
							<th><?=$LNG_TRANS_CHAR["MW00033"] //사업자번호?><?=($S_JOIN_BUSI_NUM["NES"]=="Y")?"<strong>*</strong>":"<strong></strong>";?></th>
							<td class="number">
								<input type="text" id="busi_num1" name="busi_num1" class="i_w" maxlength="3" value="<?=$aryMemBusiNum[0]?>"/> -
								<input type="text" id="busi_num2" name="busi_num2" class="i_w" maxlength="2" value="<?=$aryMemBusiNum[1]?>"/> -
								<input type="text" id="busi_num3" name="busi_num3" class="i_w" maxlength="5" value="<?=$aryMemBusiNum[2]?>"/>
							</td>
						</tr>
							<?}?>
						<?}?>
						<!-- 사업자번호 -->
						<!-- 업종 -->
						<?if ($S_JOIN_BUSI_UPJONG["USE"] == "Y" && $S_JOIN_BUSI_UPJONG["JOIN"] == "Y"){?>
							<?if (!$S_JOIN_BUSI_UPJONG["GRADE"] || in_array($strMemberJoinType,$S_JOIN_BUSI_UPJONG["GRADE"])){?>
						<tr>
							<th><?=$LNG_TRANS_CHAR["MW00034"] //업종?><?=($S_JOIN_BUSI_UPJONG["NES"]=="Y")?"<strong>*</strong>":"<strong></strong>";?></th>
							<td><input type="text" id="busi_upj" name="busi_upj" class="i_w" maxlength="50" value="<?=$memberRow[BUSI_UPJ]?>"/></td>
						</tr>
							<?}?>
						<?}?>
						<!-- 업종 -->
						<!-- 업태 -->
						<?if ($S_JOIN_BUSI_UPTAE["USE"] == "Y" && $S_JOIN_BUSI_UPTAE["JOIN"] == "Y"){?>
							<?if (!$S_JOIN_BUSI_UPTAE["GRADE"] || in_array($strMemberJoinType,$S_JOIN_BUSI_UPTAE["GRADE"])){?>
						<tr>
							<th><?=$LNG_TRANS_CHAR["MW00035"] //업태?><?=($S_JOIN_BUSI_UPTAE["NES"]=="Y")?"<strong>*</strong>":"<strong></strong>";?></th>
							<td><input type="text" id="busi_ute" name="busi_ute" class="i_w" maxlength="50" value="<?=$memberRow[BUSI_UTE]?>"/></td>
						</tr>
							<?}?>
						<?}?>
						<!-- 업태 -->
						<!-- 주소 -->
						<?if ($S_JOIN_BUSI_ADDR["USE"] == "Y" && $S_JOIN_BUSI_ADDR["JOIN"] == "Y"){?>
							<?if (!$S_JOIN_BUSI_ADDR["GRADE"] || in_array($strMemberJoinType,$S_JOIN_BUSI_ADDR["GRADE"])){?>
						<tr>
							<th><?=$LNG_TRANS_CHAR["MW00011"] //주소?><?=($S_JOIN_BUSI_ADDR["NES"]=="Y")?"<strong>*</strong>":"<strong></strong>";?></th>
							<td>
								<dl>
									<dd><input type="tel" id="busi_zip1" name="busi_zip1" class="defInput _w30" maxlength="3" readonly value="<?=$aryMemBusiZip[0]?>"/> - <input type="tel" id="busi_zip2" name="busi_zip2" class="defInput _w30" maxlength="3" readonly value="<?=$aryMemBusiZip[1]?>"/> <a href="javascript:goZip(3);"><img src="/himg/member/A0001/<?=$S_SITE_LNG_PATH?>/btn_search_zip.gif"/></a></dd>
									<dd><input type="text" id="busi_addr1" name="busi_addr1" class="defInput _w300" maxlength="200" readonly value="<?=$memberRow[BUSI_ADDR1]?>"/></dd>
									<dd><input type="text" id="busi_addr2" name="busi_addr2" class="defInput _w300" maxlength="200" value="<?=$memberRow[BUSI_ADDR2]?>"/></dd>
								</dl>
							</td>
						</tr>
							<?}?>
						<?}?>
						<!-- 주소 -->
					</table>
				</div><!-- regWrap -->
				<?}?>

				<?if ($S_JOIN_ADD_WED["JOIN"] == "Y" || $S_JOIN_ADD_WED_DAY["JOIN"] == "Y" || $S_JOIN_ADD_CHILD["JOIN"] == "Y" || $S_JOIN_ADD_JOB["JOIN"] == "Y" || $S_JOIN_ADD_CONCERN["JOIN"] == "Y" || $S_JOIN_ADD_TEXT["JOIN"] == "Y"){?>
				<h4 class="joinTit3"><span><?=$LNG_TRANS_CHAR["MW00047"] //추가 정보?></span></h4>
				<div class="regWrap">
					<table>
						<colgroup>
							<col style="width:110px;"/>
							<col/>
						</colgroup>
						<!-- 결혼여부 -->
						<?if ($S_JOIN_ADD_WED["USE"] == "Y" && $S_JOIN_ADD_WED["JOIN"] == "Y"){?>
							<?if (!$S_JOIN_ADD_WED["GRADE"] || in_array($strMemberJoinType,$S_JOIN_ADD_WED["GRADE"])){?>
						<tr>
							<th><?=$LNG_TRANS_CHAR["MW00024"] //결혼여부?><?=($S_JOIN_ADD_WED["NES"]=="Y")?"<strong>*</strong>":"<strong></strong>";?></th>
							<td><input type="radio" id="weddingYN" name="weddingYN" value="N" <?=($memberRow[M_WED] == "N")?"checked":"";?>/> <?=$LNG_TRANS_CHAR["MW00030"] //미혼?> <input type="radio" id="weddingYN" name="weddingYN" value="Y" <?=($memberRow[M_WED] == "Y")?"checked":"";?>/> <?=$LNG_TRANS_CHAR["MW00031"] //기혼?></td>
						</tr>
							<?}?>
						<?}?>
						<!-- 결혼여부 -->
						<!-- 결혼기념일 -->
						<?if ($S_JOIN_ADD_WED_DAY["USE"] == "Y" && $S_JOIN_ADD_WED_DAY["JOIN"] == "Y"){?>
							<?if (!$S_JOIN_ADD_WED_DAY["GRADE"] || in_array($strMemberJoinType,$S_JOIN_ADD_WED_DAY["GRADE"])){?>
						<tr>
							<th><?=$LNG_TRANS_CHAR["MW00025"] //결혼기념일?><?=($S_JOIN_ADD_WED_DAY["NES"]=="Y")?"<strong>*</strong>":"<strong></strong>";?></th>
							<td>
								<input type="tel" id="weddingDay1" name="weddingDay1" class="defInput _w50" maxlength="4" value="<?=$aryMemWedDay[0]?>"/><?=$LNG_TRANS_CHAR["CW00010"] //년?>
								<input type="tel" id="weddingDay2" name="weddingDay2" class="defInput _w30" maxlength="2" value="<?=$aryMemWedDay[1]?>"/><?=$LNG_TRANS_CHAR["CW00011"] //월?>
								<input type="tel" id="weddingDay3" name="weddingDay3" class="defInput _w30" maxlength="2" value="<?=$aryMemWedDay[2]?>"/><?=$LNG_TRANS_CHAR["CW00012"] //일?>
							</td>
						</tr>
							<?}?>
						<?}?>
						<!-- 결혼기념일 -->
						<!-- 자녀 -->
						<?if ($S_JOIN_ADD_CHILD["USE"] == "Y" && $S_JOIN_ADD_CHILD["JOIN"] == "Y"){?>
							<?if (!$S_JOIN_ADD_CHILD["GRADE"] || in_array($strMemberJoinType,$S_JOIN_ADD_CHILD["GRADE"])){?>
						<tr>
							<th><?=$LNG_TRANS_CHAR["MW00026"] //자녀수?><?=($S_JOIN_ADD_CHILD["NES"]=="Y")?"<strong>*</strong>":"<strong></strong>";?></th>
							<td>
								<input type="tel" id="child" name="child" class="defInput _w50" maxlength="4"/>
							</td>
						</tr>
							<?}?>
						<?}?>
						<!-- 자녀 -->
						<!-- 직업 -->
						<?if ($S_JOIN_ADD_JOB["USE"] == "Y" && $S_JOIN_ADD_JOB["JOIN"] == "Y"){?>
							<?if (!$S_JOIN_ADD_JOB["GRADE"] || in_array($strMemberJoinType,$S_JOIN_ADD_JOB["GRADE"])){?>
						<tr>
							<th><?=$LNG_TRANS_CHAR["MW00027"] //직업?><?=($S_JOIN_ADD_JOB["NES"]=="Y")?"<strong>*</strong>":"<strong></strong>";?></th>
							<td>
								<?=drawSelectBoxMore("job",$aryJob,"",$design ="defSelect",$onchange="",$etc="id=\"job\"",$LNG_TRANS_CHAR["MW00027"],$html="N")?>
							</td>
						</tr>
							<?}?>
						<?}?>
						<!-- 직업 -->
						<!-- 관심분야 -->
						<?if ($S_JOIN_ADD_CONCERN["USE"] == "Y" && $S_JOIN_ADD_CONCERN["JOIN"] == "Y"){?>
							<?if (!$S_JOIN_ADD_CONCERN["GRADE"] || in_array($strMemberJoinType,$S_JOIN_ADD_CONCERN["GRADE"])){?>
						<tr>
							<th><?=$LNG_TRANS_CHAR["MW00028"] //관심분야?><?=($S_JOIN_ADD_CONCERN["NES"]=="Y")?"<strong>*</strong>":"<strong></strong>";?></th>
							<td>
								<ul>
								<?if ($S_JOIN_ADD_CONCERN["TYPE"] == "T"){?>
								<input type="text" id="concern" name="concern" class="defInput _w200" maxlength="100"/>
								<?} else if ($S_JOIN_ADD_CONCERN["TYPE"] == "R"){?>
								<?=drawRadioBoxMulti("concern",$aryConcern,$aryChecked="",$design="",$aryReadonly="", $gap="&nbsp;",$onclick="")?>
								<?} else if ($S_JOIN_ADD_CONCERN["TYPE"] == "C"){?>
								<?=drawCheckBoxMulti("concern",$aryConcern,$aryChecked="",$design="",$aryReadonly="", $gap="&nbsp;",$onclick="")?>
								<?} else if ($S_JOIN_ADD_CONCERN["TYPE"] == "S"){?>
								<?=drawSelectBoxMore("concern",$aryConcern,"",$design ="defSelect",$onchange="",$etc="",$LNG_TRANS_CHAR["MW00028"],$html="N")?>
								<?}?>

								</ul>
							</td>
						</tr>
							<?}?>
						<?}?>
						<!-- 관심분야 -->
						<!-- 남기는 말씀 -->
						<?if ($S_JOIN_ADD_TEXT["USE"] == "Y" && $S_JOIN_ADD_TEXT["JOIN"] == "Y"){?>
							<?if (!$S_JOIN_ADD_TEXT["GRADE"] || in_array($strMemberJoinType,$S_JOIN_ADD_TEXT["GRADE"])){?>
							<tr>
								<th><?=$LNG_TRANS_CHAR["MW00029"] //남기는 말씀?><?=($S_JOIN_ADD_TEXT["NES"]=="Y")?"<strong>*</strong>":"<strong></strong>";?></th>
								<td><textarea id="memo" name="memo" class="i_w" style="width:100%;height:50px;"></textarea></td>
							</tr>
							<?}?>
						<?}?>
						<!-- 남기는 말씀 -->
					</table>
				</div>
				<?}?>
			</div>