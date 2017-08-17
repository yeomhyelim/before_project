<?
	## 설정
	## 세션 정보 초기화.
	$_SESSION['SESS_MEMBER_JOIN_MODE']		= "";
	$_SESSION['SESS_MEMBER_JOIN_CNT']		= "";
	$_SESSION['SESS_MEMBER_JOIN_TIME']		= "";
	$_SESSION['SESS_MEMBER_JOIN_KEY']		= "";
?>

<?include_once "memberJoinFormCheckModule.php";?>

			<div class="joinWrap mt20">
			<!-- (1) 기본정보 입력  -->
				<h4 class="joinTit1"><span><?=$LNG_TRANS_CHAR["MW00046"] //회원기본 정보?></span></h4>
				<span class="txtInfo">  <?=$LNG_TRANS_CHAR["CS00002"] // * 는 필수입력 항목입니다.?></span>
				<div class="regWrap">
					<table>
						<colgroup>
							<col/>
							<col/>
						</colgroup>
						<!--아이디-->
						<?if ($S_MEM_CERITY == "1"){?>
							<?if ($S_JOIN_ID["USE"] == "Y" && $S_JOIN_ID["JOIN"] == "Y"){?>
								<?if (!$S_JOIN_ID["GRADE"] || in_array($strMemberJoinType,$S_JOIN_ID["GRADE"])){?>
									<tr>
										<th><?=($S_JOIN_ID["NES"]=="Y")?"<strong>*</strong>":"<strong></strong>";?>  <?=$LNG_TRANS_CHAR["MW00001"] //아이디?></th>
										<td>
											<input type="text" id="id" name="id" class="defInput" maxlength="12"/> <a href="javascript:goIdChk();" class="btnIDChk"><?=$LNG_TRANS_CHAR["MW00059"] //아이디중복확인?></a>
											<span class="tdTextGuide"><?=$LNG_TRANS_CHAR["MS00003"] //영문, 숫자 중 4자 이상 12자리 이하 사용?> </span>
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
							<th><?=($S_JOIN_NAME["NES"]=="Y")?"<strong>*</strong>":"<strong></strong>";?> <?=$LNG_TRANS_CHAR["MW00012"] //성?> </th>
							<td><input type="text" id="f_name" name="f_name" class="defInput" maxlength="20" /></td>
						</tr>
									<?endif;?>
						<tr>
							<th><?=($S_JOIN_NAME["NES"]=="Y")?"<strong>*</strong>":"<strong></strong>";?> <?=$LNG_TRANS_CHAR["MW00004"] //이름?> </th>
							<td><input type="text" id="l_name" name="l_name" class="defInput" maxlength="20" value="<?=$strRequestName?>"/></td>
						</tr>
								<?}?>
							<?}?>
						<?}?>
						<!--이름-->

						<!--비밀번호-->
						<?if ($S_JOIN_PASS["USE"] == "Y" && $S_JOIN_PASS["JOIN"] == "Y"){?>
							<?if (!$S_JOIN_PASS["GRADE"] || in_array($strMemberJoinType,$S_JOIN_PASS["GRADE"])){?>
						<tr>
							<th><?=($S_JOIN_ID["NES"]=="Y")?"<strong>*</strong>":"<strong></strong>";?> <?=$LNG_TRANS_CHAR["MW00002"] //비밀번호?> </th>
							<td>
								<input type="password" id="pwd1" name="pwd1" class="defInput" maxlength="16"/>
								<span class="tdTextGuide"><?=$LNG_TRANS_CHAR["MS00004"] //영문, 숫자, 특수문자 중 4자 이상 16자리 이하 사용?> </span>
							</td>
						</tr>
						<tr>
							<th><?=($S_JOIN_ID["NES"]=="Y")?"<strong>*</strong>":"<strong></strong>";?> <?=$LNG_TRANS_CHAR["MW00003"] //비밀번호 확인?> </th>
							<td>
								<input type="password" id="pwd2" name="pwd2" class="defInput" maxlength="16"/>
								<span class="tdTextGuide"><?=$LNG_TRANS_CHAR["MS00005"] //비밀번호를 한번더 입력해 주세요.?> </span>
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
							<th><?=($S_JOIN_NAME["NES"]=="Y")?"<strong>*</strong>":"<strong></strong>";?> <?=$LNG_TRANS_CHAR["MW00012"] //성?> </th>
							<td><input type="text" id="f_name" name="f_name" class="defInput" maxlength="20"/></td>
						</tr>
									<?endif;?>
						<tr>
							<th><?=($S_JOIN_NAME["NES"]=="Y")?"<strong>*</strong>":"<strong></strong>";?> <?=$LNG_TRANS_CHAR["MW00004"] //이름?> </th>
							<td><input type="text" id="l_name" name="l_name" class="defInput" maxlength="20"  value="<?=$strRequestName?>" <?=($strRequestSafeId)?"readonly":"";?>/></td>
						</tr>
								<?}?>
							<?}?>
						<?}?>
						<!--이름-->
						<!-- 닉네임 -->
						<?if ($S_JOIN_NICKNAME["USE"] == "Y" && $S_JOIN_NICKNAME["JOIN"] == "Y"){?>
							<?if (!$S_JOIN_NICKNAME["GRADE"] || in_array($strMemberJoinType,$S_JOIN_NICKNAME["GRADE"])){?>
						<tr>
							<th><?=($S_JOIN_NICKNAME["NES"]=="Y")?"<strong>*</strong>":"<strong></strong>";?> <?=$LNG_TRANS_CHAR["MW00005"] //닉네임?></th>
							<td>
								<input type="text" id="nickname" name="nickname" class="defInput" maxlength="16"/> <a href="javascript:goNickNameChk();"><img src="/himg/member/A0001/btn_check_nickname.gif"/></a>
								<span><?=$LNG_TRANS_CHAR["MS00006"] //한글, 영문, 숫자 중 4자 이상 16자리 이하 사용?> </span>
							</td>
						</tr>
							<?}?>
						<?}?>
						<!-- 닉네임 -->
						<!-- 생년월일/음력/양력 -->
						<?if ($S_JOIN_BIRTH["USE"] == "Y" && $S_JOIN_BIRTH["JOIN"] == "Y"){?>
							<?if (!$S_JOIN_BIRTH["GRADE"] || in_array($strMemberJoinType,$S_JOIN_BIRTH["GRADE"])){?>
						<tr>
							<th><?=($S_JOIN_BIRTH["NES"]=="Y")?"<strong>*</strong>":"<strong></strong>";?> <?=$LNG_TRANS_CHAR["MW00006"] //생년월일?></th>
							<td>
								<?if($S_SITE_LNG == "KR"):?>
								<input type="text" id="birth1" name="birth1" class="defInput _w50" maxlength="4" value="<?=$strBirth1?>" <?=($strRequestSafeId)?"readonly":"";?>/><?=$LNG_TRANS_CHAR["CW00010"] //년?>
								<input type="text" id="birth2" name="birth2" class="defInput _w30" maxlength="2" value="<?=$strBirth2?>" <?=($strRequestSafeId)?"readonly":"";?>/><?=$LNG_TRANS_CHAR["CW00011"] //월?>
								<input type="text" id="birth3" name="birth3" class="defInput _w30" maxlength="2" value="<?=$strBirth3?>" <?=($strRequestSafeId)?"readonly":"";?>/><?=$LNG_TRANS_CHAR["CW00012"] //일?>
								<?if ($S_JOIN_BIRTH_CAL["USE"] == "Y" && $S_JOIN_BIRTH_CAL["JOIN"] == "Y"){?>
									<?if (!$S_JOIN_BIRTH_CAL["GRADE"] || in_array($strMemberJoinType,$S_JOIN_BIRTH_CAL["GRADE"])){?>
								<input type="radio" id="birth_cal" name="birth_cal" value="1"/><?=$LNG_TRANS_CHAR["MW00015"] //음력?>
								<input type="radio" id="birth_cal" name="birth_cal" value="2" checked/><?=$LNG_TRANS_CHAR["MW00016"] //양력?>
									<?}?>
								<?}?>
								<?else:?>
								<input type="text" id="birth3" name="birth3" class="defInput _w30" maxlength="2"/>/
								<input type="text" id="birth2" name="birth2" class="defInput _w30" maxlength="2"/>/
								<input type="text" id="birth1" name="birth1" class="defInput _w50" maxlength="4"/> (<?=$LNG_TRANS_CHAR["CW00012"] //일?>/<?=$LNG_TRANS_CHAR["CW00011"] //월?>/<?=$LNG_TRANS_CHAR["CW00010"] //년?>)
								<?endif;?>
							</td>
						</tr>
							<?}?>
						<?}?>
						<!-- 성별 -->
						<?if ($S_JOIN_SEX["USE"] == "Y" && $S_JOIN_SEX["JOIN"] == "Y"){?>
							<?if (!$S_JOIN_SEX["GRADE"] || in_array($strMemberJoinType,$S_JOIN_SEX["GRADE"])){?>
						<tr>
							<th><?=($S_JOIN_SEX["NES"]=="Y")?"<strong>*</strong>":"<strong></strong>";?><?=$LNG_TRANS_CHAR["MW00007"] //성별?></th>
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
							<th><?=($S_JOIN_HP["NES"]=="Y")?"<strong>*</strong>":"<strong></strong>";?> <?=$LNG_TRANS_CHAR["MW00008"] //핸드폰?> </th>
							<td>
								<?if ($S_SITE_LNG == "KR"){?>
								<?=drawSelectBoxMore("hp1",$aryHp,$aryMemHp[0],$design ="defSelect",$onchange="",$etc="id=\"hp1\"",$firstItem="",$html="N")?>
								 -
								<input type="text" id="hp2" name="hp2" class="defInput _w50" maxlength="4" autoMove="hp3" value="<?=$aryMemHp[1]?>"/> -
								<input type="text" id="hp3" name="hp3" class="defInput _w50" maxlength="4" value="<?=$aryMemHp[2]?>"/>
								
								<!-- 휴대폰 인증 -->
								<?if($phoneCheck == "Y"):?>
								<span><a href="javascript:goMemberJoinMoveEvent();">휴대폰인증</a></span>
								<?endif;?>
								<!-- 휴대폰 인증 -->

								<?}else{?>
								<input type="text" id="hp1" name="hp1" class="defInput _w200" maxlength="30" value="<?=$memberRow[M_HP]?>"/>
								<?}?>
								
								<?if ($S_JOIN_SMSYN["USE"] == "Y" && $S_JOIN_SMSYN["JOIN"] == "Y"){?>
									<?if (!$S_JOIN_SMSYN["GRADE"] || in_array($strMemberJoinType,$S_JOIN_SMSYN["GRADE"])){?>
								<span><input type="checkbox" name="smsYN" id="smsYN" value="Y" checked/> <?=$LNG_TRANS_CHAR["MS00007"] //SMS 정보를 수신합니다.?> </span>
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
						<tr>
							<th><?=($S_JOIN_PHONE["NES"]=="Y")?"<strong>*</strong>":"<strong></strong>";?> <?=$LNG_TRANS_CHAR["MW00009"] //전화번호?></th>
							<td>
								<?if ($S_SITE_LNG == "KR"){?>
								<?=drawSelectBoxMore("phone1",$aryPhone,$aryMemPhone[0],$design ="defSelect",$onchange="",$etc="id=\"phone1\"",$firstItem="",$html="N")?>
								 -
								<input type="text" id="phone2" name="phone2" class="defInput _w50" maxlength="4" value="<?=$aryMemPhone[1]?>"/> -
								<input type="text" id="phone3" name="phone3" class="defInput _w50" maxlength="4" value="<?=$aryMemPhone[2]?>"/>
								<?}else {?>
								<input type="text" id="phone1" name="phone1" class="defInput _w200" maxlength="30" value="<?=$memberRow[M_PHONE]?>"/>
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
							<th><?=($S_JOIN_FAX["NES"]=="Y")?"<strong>*</strong>":"<strong></strong>";?> <?=$LNG_TRANS_CHAR["MW00017"] //팩스번호?></th>
							<td>
								<?if ($S_SITE_LNG == "KR"){?>
								<?=drawSelectBoxMore("fax1",$aryPhone,$aryMemFax[0],$design ="defSelect",$onchange="",$etc="",$firstItem="",$html="N")?>
								 -
								<input type="text" id="fax2" name="fax2" class="defInput _w50" maxlength="4" value="<?=$aryMemFax[1]?>"/> -
								<input type="text" id="fax3" name="fax3" class="defInput _w50" maxlength="4" value="<?=$aryMemFax[2]?>"/>
								<?}else {?>
								<input type="text" id="fax1" name="fax1" class="defInput _w200" maxlength="30" value="<?=$memberRow[M_FAX]?>"/>
								<?}?>
							</td>
						</tr>
							<?}?>
						<?}?>
						<!-- 팩스번호 -->
						<!-- 이메일 -->
						<?if ($S_JOIN_MAIL["USE"] == "Y" && $S_JOIN_MAIL["JOIN"] == "Y"){?>
							<?if (!$S_JOIN_MAIL["GRADE"] || in_array($strMemberJoinType,$S_JOIN_MAIL["GRADE"])){?>
						<tr>
							<th><?=($S_JOIN_MAIL["NES"]=="Y")?"<strong>*</strong>":"<strong></strong>";?> <?=$LNG_TRANS_CHAR["MW00010"] //이메일?> </th>
							<td>
								<input type="text" id="mail" name="mail" class="defInput _w300" maxlength="30"/>
								<?if ($S_JOIN_MAILYN["USE"] == "Y" && $S_JOIN_MAILYN["JOIN"] == "Y"){?>
									<?if (!$S_JOIN_MAILYN["GRADE"] || in_array($strMemberJoinType,$S_JOIN_MAILYN["GRADE"])){?>
								<span><input type="checkbox" id="mailYN" name="mailYN" value="Y" checked/> <?=$LNG_TRANS_CHAR["MS00008"] //메일 정보를 수신합니다.?> </span>
									<?}?>
								<?}?>
							</td>
						</tr>
							<?}?>
						<?}?>
						<!-- 이메일 -->
						<!-- 주소 -->
						<?if ($S_JOIN_ADDR["USE"] == "Y" && $S_JOIN_ADDR["JOIN"] == "Y"){?>
							<?if (!$S_JOIN_ADDR["GRADE"] || in_array($strMemberJoinType,$S_JOIN_ADDR["GRADE"])){?>
								<?if ($S_SITE_LNG == "KR"){?>
						<tr>
							<th><?=($S_JOIN_ADDR["NES"]=="Y")?"<strong>*</strong>":"<strong></strong>";?> <?=$LNG_TRANS_CHAR["MW00011"] //주소?> </th>
							<td>
								<dl>
									<dd><input type="text" id="zip1" name="zip1" class="defInput _w30" maxlength="3" readonly/> - <input type="text" id="zip2" name="zip2" class="defInput _w30" maxlength="3" readonly/> <a href="javascript:goZip(1);"><img src="/himg/member/A0001/<?=$S_SITE_LNG_PATH?>/btn_search_zip.gif"/></a></dd>
									<dd><input type="text" id="addr1" name="addr1" class="defInput _w300" maxlength="200" readonly/></dd>
									<dd><input type="text" id="addr2" name="addr2" class="defInput _w300" maxlength="200"/></dd>
								</dl>
							</td>
						</tr>
								<?}else{?>
						<tr>
							<th><?=($S_JOIN_ADDR["NES"]=="Y")?"<strong>*</strong>":"<strong></strong>";?> <?=$LNG_TRANS_CHAR["MW00021"] //국가?> </th>
							<td>
								<?=drawSelectBoxMore("country",$aryCountryList,$memberRow[M_COUNTRY],$design ="",$onchange="",$etc="",$firstItem="= Country =",$html="N")?>
							</td>
						</tr>
						<tr>
							<th><?=($S_JOIN_ADDR["NES"]=="Y")?"<strong>*</strong>":"<strong></strong>";?> <?=$LNG_TRANS_CHAR["MW00011"] //주소?> </th>
							<td>
								<dl>
									<dd><input type="text" id="addr1" name="addr1" class="defInput _w300" maxlength="200"/></dd>
								</dl>
							</td>
						</tr>
						<tr>
							<th><?=($S_JOIN_ADDR["NES"]=="Y")?"<strong>*</strong>":"<strong></strong>";?> <?=$LNG_TRANS_CHAR["MW00013"] //상세주소?> </th>
							<td>
								<dl>
									<dd><input type="text" id="addr2" name="addr2" class="defInput _w300" maxlength="200"/></dd>
								</dl>
							</td>
						</tr>
						<tr>
							<th><?=($S_JOIN_ADDR["NES"]=="Y")?"<strong>*</strong>":"<strong></strong>";?> <?=$LNG_TRANS_CHAR["MW00022"] //도시?> </th>
							<td>
								<dl>
									<dd><input type="text" id="city" name="city" class="defInput _w300" maxlength="200"/></dd>
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
							<th><?=($S_JOIN_ADDR["NES"]=="Y")?"<strong>*</strong>":"<strong></strong>";?> <?=$LNG_TRANS_CHAR["MW00014"] //우편번호?> </th>
							<td>
								<dl>
									<dd><input type="text" id="zip1" name="zip1" class="defInput _w100" maxlength="20"></dd>
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
							<th><?=($S_JOIN_PHOTO["NES"]=="Y")?"<strong>*</strong>":"<strong></strong>";?> <?=$LNG_TRANS_CHAR["MW00017"] //사진?></th>
							<td>
								<input type="file" id="photo" name="photo"/>
							</td>
						</tr>
							<?}?>
						<?}?>
						<!-- 사진 -->
						<!-- 추천인 -->
						<?if ($S_JOIN_REC["USE"] == "Y" && $S_JOIN_REC["JOIN"] == "Y"){?>
							<?if (!$S_JOIN_REC["GRADE"] || in_array($strMemberJoinType,$S_JOIN_REC["GRADE"])){?>
						<tr>
							<th><?=($S_JOIN_REC["NES"]=="Y")?"<strong>*</strong>":"<strong></strong>";?> <?=$LNG_TRANS_CHAR["MW00019"] //추천인?></th>
							<td>
								<input type="text" id="rec_id" name="rec_id" class="defInput" maxlength="50"/>
							</td>
						</tr>
							<?}?>
						<?}?>
						<!-- 추천인 -->
						<!-- 회사명 -->
						<?if ($S_JOIN_COM["USE"] == "Y" && $S_JOIN_COM["JOIN"] == "Y"){?>
							<?if (!$S_JOIN_COM["GRADE"] || in_array($strMemberJoinType,$S_JOIN_COM["GRADE"])){?>
						<tr>
							<th><?=($S_JOIN_COM["NES"]=="Y")?"<strong>*</strong>":"<strong></strong>";?> <?=$LNG_TRANS_CHAR["MW00020"] //회사명?></th>
							<td>
								<input type="text" id="com_nm" name="com_nm" class="defInput" maxlength="50"/>
							</td>
						</tr>
							<?}?>
						<?}?>
						<!-- 회사명 -->
						<!-- TM ID -->
						<?if ($S_JOIN_TM_ID["USE"] == "Y" && $S_JOIN_TM_ID["JOIN"] == "Y"){?>
							<?if (!$S_JOIN_TM_ID["GRADE"] || in_array($strMemberJoinType,$S_JOIN_TM_ID["GRADE"])){?>
						<tr>
							<th><?=($S_JOIN_TM_ID["NES"]=="Y")?"<strong>*</strong>":"<strong></strong>";?> TM코드</th>
							<td>
								<input type="text" id="tm_id" name="tm_id" class="defInput" maxlength="20"/>
							</td>
						</tr>
							<?}?>
						<?}?>
						<!-- TM ID -->
						<?if ($S_JOIN_TMP_1["USE"] == "Y" && $S_JOIN_TMP_1["JOIN"] == "Y"){?>
							<?if (!$S_JOIN_TMP_1["GRADE"] || in_array($strMemberJoinType,$S_JOIN_TMP_1["GRADE"])){?>
						<tr>
							<th><?=($S_JOIN_TMP_1["NES"]=="Y")?"<strong>*</strong>":"<strong></strong>";?> <?=$S_JOIN_TMP_1["NAME_".$S_SITE_LNG] //임시필드?></th>
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
							<th><?=($S_JOIN_TMP_2["NES"]=="Y")?"<strong>*</strong>":"<strong></strong>";?> <?=$S_JOIN_TMP_2["NAME_".$S_SITE_LNG] //임시필드?></th>
							<td>
								<input type="text" id="tmp2" name="tmp2" class="defInput _w200" maxlength="50"/>
							</td>
						</tr>
							<?}?>
						<?}?>
						<?if ($S_JOIN_TMP_3["USE"] == "Y" && $S_JOIN_TMP_3["JOIN"] == "Y"){?>
							<?if (!$S_JOIN_TMP_3["GRADE"] || in_array($strMemberJoinType,$S_JOIN_TMP_3["GRADE"])){?>
						<tr>
							<th><?=($S_JOIN_TMP_3["NES"]=="Y")?"<strong>*</strong>":"<strong></strong>";?> <?=$S_JOIN_TMP_4["NAME_".$S_SITE_LNG] //임시필드?></th>
							<td>
								<input type="text" id="tmp3" name="tmp3" class="defInput _w200" maxlength="50"/>
							</td>
						</tr>
							<?}?>
						<?}?>
						<?if ($S_JOIN_TMP_4["USE"] == "Y" && $S_JOIN_TMP_4["JOIN"] == "Y"){?>
							<?if (!$S_JOIN_TMP_4["GRADE"] || in_array($strMemberJoinType,$S_JOIN_TMP_4["GRADE"])){?>
						<tr>
							<th><?=($S_JOIN_TMP_4["NES"]=="Y")?"<strong>*</strong>":"<strong></strong>";?> <?=$S_JOIN_TMP_4["NAME_".$S_SITE_LNG] //임시필드?></th>
							<td>
								<input type="text" id="tmp4" name="tmp4" class="defInput _w200" maxlength="50"/>
							</td>
						</tr>
							<?}?>
						<?}?>
						<?if ($S_JOIN_TMP_5["USE"] == "Y" && $S_JOIN_TMP_5["JOIN"] == "Y"){?>
							<?if (!$S_JOIN_TMP_5["GRADE"] || in_array($strMemberJoinType,$S_JOIN_TMP_5["GRADE"])){?>
						<tr>
							<th><?=($S_JOIN_TMP_5["NES"]=="Y")?"<strong>*</strong>":"<strong></strong>";?> <?=$S_JOIN_TMP_5["NAME_".$S_SITE_LNG] //임시필드?></th>
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
				<h4 class="joinTit2 mt30"><span><?=$LNG_TRANS_CHAR["MW00049"] //사업자 정보?></span></h4>
				<div class="regWrap">
					<table>
						<colgroup>
							<col/>
							<col/>
						</colgroup>
						<!-- 상호명 -->
						<?if ($S_JOIN_BUSI_NM["USE"] == "Y" && $S_JOIN_BUSI_NM["JOIN"] == "Y"){?>
							<?if (!$S_JOIN_BUSI_NM["GRADE"] || in_array($strMemberJoinType,$S_JOIN_BUSI_NM["GRADE"])){?>
						<tr>
							<th><?=($S_JOIN_BUSI_NM["NES"]=="Y")?"<strong>*</strong>":"<strong></strong>";?> <?=$LNG_TRANS_CHAR["MW00032"] //상호명?></th>
							<td>
								<input type="text" id="busi_nm" name="busi_nm" class="defInput" maxlength="50" value="<?=$memberRow[BUSI_NM]?>"/>
							</td>
						</tr>
							<?}?>
						<?}?>
						<!-- 상호명 -->
						<!-- 사업자번호 -->
						<?if ($S_JOIN_BUSI_NUM["USE"] == "Y" && $S_JOIN_BUSI_NUM["JOIN"] == "Y"){?>
							<?if (!$S_JOIN_BUSI_NUM["GRADE"] || in_array($strMemberJoinType,$S_JOIN_BUSI_NUM["GRADE"])){?>
						<tr>
							<th><?=($S_JOIN_BUSI_NUM["NES"]=="Y")?"<strong>*</strong>":"<strong></strong>";?> <?=$LNG_TRANS_CHAR["MW00033"] //사업자번호?></th>
							<td>
								<input type="text" id="busi_num1" name="busi_num1" class="defInput" maxlength="3" value="<?=$aryMemBusiNum[0]?>"/> -
								<input type="text" id="busi_num2" name="busi_num2" class="defInput" maxlength="2" value="<?=$aryMemBusiNum[1]?>"/> -
								<input type="text" id="busi_num3" name="busi_num3" class="defInput" maxlength="5" value="<?=$aryMemBusiNum[2]?>"/> -
							</td>
						</tr>
							<?}?>
						<?}?>
						<!-- 사업자번호 -->
						<!-- 업종 -->
						<?if ($S_JOIN_BUSI_UPJONG["USE"] == "Y" && $S_JOIN_BUSI_UPJONG["JOIN"] == "Y"){?>
							<?if (!$S_JOIN_BUSI_UPJONG["GRADE"] || in_array($strMemberJoinType,$S_JOIN_BUSI_UPJONG["GRADE"])){?>
						<tr>
							<th><?=($S_JOIN_BUSI_UPJONG["NES"]=="Y")?"<strong>*</strong>":"<strong></strong>";?> <?=$LNG_TRANS_CHAR["MW00034"] //업종?></th>
							<td><input type="text" id="busi_upj" name="busi_upj" class="defInput" maxlength="50" value="<?=$memberRow[BUSI_UPJ]?>"/></td>
						</tr>
							<?}?>
						<?}?>
						<!-- 업종 -->
						<!-- 업태 -->
						<?if ($S_JOIN_BUSI_UPTAE["USE"] == "Y" && $S_JOIN_BUSI_UPTAE["JOIN"] == "Y"){?>
							<?if (!$S_JOIN_BUSI_UPTAE["GRADE"] || in_array($strMemberJoinType,$S_JOIN_BUSI_UPTAE["GRADE"])){?>
						<tr>
							<th><?=($S_JOIN_BUSI_UPTAE["NES"]=="Y")?"<strong>*</strong>":"<strong></strong>";?> <?=$LNG_TRANS_CHAR["MW00035"] //업태?></th>
							<td><input type="text" id="busi_ute" name="busi_ute" class="defInput" maxlength="50" value="<?=$memberRow[BUSI_UTE]?>"/></td>
						</tr>
							<?}?>
						<?}?>
						<!-- 업태 -->
						<!-- 주소 -->
						<?if ($S_JOIN_BUSI_ADDR["USE"] == "Y" && $S_JOIN_BUSI_ADDR["JOIN"] == "Y"){?>
							<?if (!$S_JOIN_BUSI_ADDR["GRADE"] || in_array($strMemberJoinType,$S_JOIN_BUSI_ADDR["GRADE"])){?>
						<tr>
							<th><?=($S_JOIN_BUSI_ADDR["NES"]=="Y")?"<strong>*</strong>":"<strong></strong>";?> <?=$LNG_TRANS_CHAR["MW00011"] //주소?></th>
							<td>
								<dl>
									<dd><input type="text" id="busi_zip1" name="busi_zip1" class="defInput _w30" maxlength="3" readonly value="<?=$aryMemBusiZip[0]?>"/> - <input type="text" id="busi_zip2" name="busi_zip2" class="defInput _w30" maxlength="3" readonly value="<?=$aryMemBusiZip[1]?>"/> <a href="javascript:goZip(3);"><img src="/himg/member/A0001/<?=$S_SITE_LNG_PATH?>/btn_search_zip.gif"/></a></dd>
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
							<th><?=($S_JOIN_ADD_WED["NES"]=="Y")?"<strong>*</strong>":"<strong></strong>";?> <?=$LNG_TRANS_CHAR["MW00024"] //결혼여부?></th>
							<td><input type="radio" id="weddingYN" name="weddingYN" value="N" <?=($memberRow[M_WED] == "N")?"checked":"";?>/> <?=$LNG_TRANS_CHAR["MW00030"] //미혼?> <input type="radio" id="weddingYN" name="weddingYN" value="Y" <?=($memberRow[M_WED] == "Y")?"checked":"";?>/> <?=$LNG_TRANS_CHAR["MW00031"] //기혼?></td>
						</tr>
							<?}?>
						<?}?>
						<!-- 결혼여부 -->
						<!-- 결혼기념일 -->
						<?if ($S_JOIN_ADD_WED_DAY["USE"] == "Y" && $S_JOIN_ADD_WED_DAY["JOIN"] == "Y"){?>
							<?if (!$S_JOIN_ADD_WED_DAY["GRADE"] || in_array($strMemberJoinType,$S_JOIN_ADD_WED_DAY["GRADE"])){?>
						<tr>
							<th><?=($S_JOIN_ADD_WED_DAY["NES"]=="Y")?"<strong>*</strong>":"<strong></strong>";?> <?=$LNG_TRANS_CHAR["MW00025"] //결혼기념일?></th>
							<td>
								<input type="text" id="weddingDay1" name="weddingDay1" class="defInput _w50" maxlength="4" value="<?=$aryMemWedDay[0]?>"/><?=$LNG_TRANS_CHAR["CW00010"] //년?>
								<input type="text" id="weddingDay2" name="weddingDay2" class="defInput _w30" maxlength="2" value="<?=$aryMemWedDay[1]?>"/><?=$LNG_TRANS_CHAR["CW00011"] //월?>
								<input type="text" id="weddingDay3" name="weddingDay3" class="defInput _w30" maxlength="2" value="<?=$aryMemWedDay[2]?>"/><?=$LNG_TRANS_CHAR["CW00012"] //일?>
							</td>
						</tr>
							<?}?>
						<?}?>
						<!-- 결혼기념일 -->
						<!-- 자녀 -->
						<?if ($S_JOIN_ADD_CHILD["USE"] == "Y" && $S_JOIN_ADD_CHILD["JOIN"] == "Y"){?>
							<?if (!$S_JOIN_ADD_CHILD["GRADE"] || in_array($strMemberJoinType,$S_JOIN_ADD_CHILD["GRADE"])){?>
						<tr>
							<th><?=($S_JOIN_ADD_CHILD["NES"]=="Y")?"<strong>*</strong>":"<strong></strong>";?> <?=$LNG_TRANS_CHAR["MW00026"] //자녀수?></th>
							<td>
								<input type="text" id="child" name="child" class="defInput _w50" maxlength="4"/>
							</td>
						</tr>
							<?}?>
						<?}?>
						<!-- 자녀 -->
						<!-- 직업 -->
						<?if ($S_JOIN_ADD_JOB["USE"] == "Y" && $S_JOIN_ADD_JOB["JOIN"] == "Y"){?>
							<?if (!$S_JOIN_ADD_JOB["GRADE"] || in_array($strMemberJoinType,$S_JOIN_ADD_JOB["GRADE"])){?>
						<tr>
							<th><?=($S_JOIN_ADD_JOB["NES"]=="Y")?"<strong>*</strong>":"<strong></strong>";?> <?=$LNG_TRANS_CHAR["MW00027"] //직업?></th>
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
							<th><?=($S_JOIN_ADD_CONCERN["NES"]=="Y")?"<strong>*</strong>":"<strong></strong>";?> <?=$LNG_TRANS_CHAR["MW00028"] //관심분야?></th>
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
							<th><?=($S_JOIN_ADD_TEXT["NES"]=="Y")?"<strong>*</strong>":"<strong></strong>";?> <?=$LNG_TRANS_CHAR["MW00029"] //남기는 말씀?></th>
							<td><textarea id="memo" name="memo" class="defInput" style="width:100%;height:50px;"></textarea></td>
						</tr>
							<?}?>
						<?}?>
						<!-- 남기는 말씀 -->
					</table>
				</div>
				<?}?>
			</div>