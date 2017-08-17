
			<!-- (1) 기본정보 입력  -->
				<div class="regWrap">
					<table>
						<colgroup>
							<col style="width:110px;"/>
							<col/>
						</colgroup>
						<!--아이디-->
						<?if ($S_MEM_CERITY == "1"){?>
							<?if ($S_JOIN_ID["USE"] == "Y" && $S_JOIN_ID["MYPAGE"] == "Y"){?>
								<?if (!$S_JOIN_ID["GRADE"] || in_array($strMemberJoinType,$S_JOIN_ID["GRADE"])){?>
						<tr>
							<th><strong> </strong><?=$LNG_TRANS_CHAR["MW00001"] //아이디?></th>
							<td>
								<?if ($SHOP_MEMBER_ID_MODIFY_FLAG == "Y" && !$memberRow['M_ID']){?>
								<input type="text" id="id" name="id" class="defInput" maxlength="12"/>
								<a href="javascript:goIdChk();" class="btnIDChk">[<?=$LNG_TRANS_CHAR["MW00059"] //아이디중복확인?>]</a>
								<span class="tdTextGuide"><?=$LNG_TRANS_CHAR["MS00003"] //영문, 숫자 중 4자 이상 12자리 이하 사용?> </span>
								<?}else{?>
								<?=$memberRow[M_ID]?>
								<?}?>
							</td>
						</tr>
								<?}?>
							<?}?>
						<?}?>
						<!--아이디-->

						<!--이름-->
						<?if ($S_MEM_CERITY == "2"){?>
							<?if ($S_JOIN_NAME["USE"] == "Y" && $S_JOIN_NAME["MYPAGE"] == "Y"){?>
								<?if (!$S_JOIN_NAME["GRADE"] || in_array($strMemberJoinType,$S_JOIN_NAME["GRADE"])){?>
									<?if($S_SITE_LNG != "KR"): // 다국어 사용?>
						<tr>
							<th><strong></strong><?=$LNG_TRANS_CHAR["MW00012"] //성?> </th>
							<td><?=$memberRow[M_F_NAME]?></td>
						</tr>
									<?endif;?>
						<tr>
							<th><strong> </strong><?=$LNG_TRANS_CHAR["MW00004"] //이름?> </th>
							<td><?=$memberRow[M_L_NAME]?></td>
						</tr>
								<?}?>
							<?}?>
						<?}?>
						<!--이름-->
						<tr>
							<th><strong></strong><?=$LNG_TRANS_CHAR["MW00117"] //비밀번호?> </th>
							<td>
								<input type="password" id="pwd" name="pwd" class="defInput" maxlength="16"/>
							</td>
						</tr>
						<!--비밀번호-->
						<?if ($S_JOIN_PASS["USE"] == "Y" && $S_JOIN_PASS["MYPAGE"] == "Y"){?>
							<?if (!$S_JOIN_PASS["GRADE"] || in_array($strMemberJoinType,$S_JOIN_PASS["GRADE"])){?>
						<tr>
							<th><strong></strong><?=$LNG_TRANS_CHAR["MW00002"] //비밀번호확인1?> </th>
							<td>
								<input type="password" id="pwd1" name="pwd1" class="defInput" maxlength="16"/>
								<span class="tdTextGuide"><?=$LNG_TRANS_CHAR["MS00004"] //영문, 숫자, 특수문자 중 4자 이상 16자리 이하 사용?> </span>
							</td>
						</tr>
						<tr>
							<th><strong></strong><?=$LNG_TRANS_CHAR["MW00003"] //비밀번호확인2?> </th>
							<td>
								<input type="password" id="pwd2" name="pwd2" class="defInput" maxlength="16"/>
								<span class="tdTextGuide"><?=$LNG_TRANS_CHAR["MS00005"] //비밀번호를 한번더 입력해 주세요.?> </span>
							</td>
						</tr>
							<?}?>
						<?}?>
						<!--비밀번호-->
						
						<!--이름-->
						<?if ($S_MEM_CERITY == "1"){?>
							<?if ($S_JOIN_NAME["USE"] == "Y" && $S_JOIN_NAME["MYPAGE"] == "Y"){?>
								<?if (!$S_JOIN_NAME["GRADE"] || in_array($strMemberJoinType,$S_JOIN_NAME["GRADE"])){?>
									<?if($S_SITE_LNG != "KR"): // 다국어 사용?>
						<tr>
							<th><strong></strong><?=$LNG_TRANS_CHAR["MW00012"] //성?> </th>
							<td><?=$memberRow[M_F_NAME]?></td>
						</tr>
									<?endif;?>
						<tr>
							<th><strong></strong><?=$LNG_TRANS_CHAR["MW00004"] //이름?> </th>
							<td><?=$memberRow[M_L_NAME]?></td>
						</tr>
								<?}?>
							<?}?>
						<?}?>
						<!--이름-->
						<!-- 닉네임 -->
						<?if ($S_JOIN_NICKNAME["USE"] == "Y" && $S_JOIN_NICKNAME["MYPAGE"] == "Y"){?>
							<?if (!$S_JOIN_NICKNAME["GRADE"] || in_array($strMemberJoinType,$S_JOIN_NICKNAME["GRADE"])){?>
						<tr>
							<th><strong></strong><?=$LNG_TRANS_CHAR["MW00005"] //닉네임?></th>
							<td>
								<?=$memberRow[M_NICK_NAME]?>
							</td>
						</tr>
							<?}?>
						<?}?>
						<!-- 닉네임 -->
						<!-- 생년월일/음력/양력 -->
						<?if ($S_JOIN_BIRTH["USE"] == "Y" && $S_JOIN_BIRTH["MYPAGE"] == "Y"){?>
							<?if (!$S_JOIN_BIRTH["GRADE"] || in_array($strMemberJoinType,$S_JOIN_BIRTH["GRADE"])){?>
						<tr>
							<th><strong></strong><?=$LNG_TRANS_CHAR["MW00006"] //생년월일?></th>
							<td>
								<?if($S_SITE_LNG != "KR"):
									if($memberRow[M_BIRTH]):
										$temp = explode("-",$memberRow[M_BIRTH]);
										$memberRow[M_BIRTH] = "{$temp[2]}/{$temp[1]}/{$temp[0]} ({$LNG_TRANS_CHAR['CW00012']}/{$LNG_TRANS_CHAR['CW00011']}/{$LNG_TRANS_CHAR['CW00010']})";
										
									endif;?>
								<?endif;?>
								<?=$memberRow[M_BIRTH]?>
								<?if ($S_JOIN_BIRTH_CAL["USE"] == "Y" && $S_JOIN_BIRTH_CAL["MYPAGE"] == "Y"){?>
									<?if (!$S_JOIN_BIRTH_CAL["GRADE"] || in_array($strMemberJoinType,$S_JOIN_BIRTH_CAL["GRADE"])){?>
										<?=($memberRow[M_BIRTH_CAL]=="1")?$LNG_TRANS_CHAR["MW00015"]:$LNG_TRANS_CHAR["MW00016"];?>
									<?}?>
								<?}?>
							</td>
						</tr>
							<?}?>
						<?}?>
						<!-- 성별 -->
						<?if ($S_JOIN_SEX["USE"] == "Y" && $S_JOIN_SEX["MYPAGE"] == "Y"){?>
							<?if (!$S_JOIN_SEX["GRADE"] || in_array($strMemberJoinType,$S_JOIN_SEX["GRADE"])){?>
						<tr>
							<th><strong></strong><?=$LNG_TRANS_CHAR["MW00007"] //성별?></th>
							<td>
								<?=($memberRow[M_SEX]=="M")?$LNG_TRANS_CHAR["CW00008"]:$LNG_TRANS_CHAR["CW00009"];?>
							</td>
						</tr>
							<?}?>
						<?}?>
						<!-- 성별 -->
						<!-- 핸드폰 -->
						<?if ($S_JOIN_HP["USE"] == "Y" && $S_JOIN_HP["MYPAGE"] == "Y"){?>
							<?if (!$S_JOIN_HP["GRADE"] || in_array($strMemberJoinType,$S_JOIN_HP["GRADE"])){?>
						<tr>
							<th><strong>*</strong> <?=$LNG_TRANS_CHAR["MW00008"] //핸드폰?> </th>
							<td>
								<?if ($S_SITE_LNG == "KR"){?>
								<?=drawSelectBoxMore("hp1",$aryHp,$aryMemHp[0],$design ="defSelect",$onchange="",$etc="id=\"hp1\"",$firstItem="",$html="N")?>
								 -
								<input type="input" id="hp2" name="hp2" class="defInput _w50" maxlength="4" autoMove="hp3" value="<?=$aryMemHp[1]?>"/> -
								<input type="input" id="hp3" name="hp3" class="defInput _w50" maxlength="4" value="<?=$aryMemHp[2]?>"/>

								<!-- 휴대폰 인증 -->
								<?if($phoneCheck == "Y"):?>
								<span id="memberPhoneKeyRequest"><a href="javascript:goMemberPhoneKeyRequestEvent();">휴대폰 인증키 요청</a></span>
								<input type="text" name="phoneKey" value="" style="display:none;"/>
								<span id="memberPhoneKeyCheck" style="display:none;"><a href="javascript:goMemberPhoneKeyCheckEvent();">확인</a></span>
								<span id="memberPhoneKeyCountDown" data-seconds="10"></span>
								<input type="hidden" id="orgHp" value="<?="{$aryMemHp[0]}{$aryMemHp[1]}{$aryMemHp[2]}"?>"/>
								<?endif;?>
								<!-- 휴대폰 인증 -->

								<?}else{?>
								<input type="input" id="hp1" name="hp1" class="defInput _w200" maxlength="30" value="<?=$memberRow[M_HP]?>"/>
								<?}?>
								
								<?if ($S_JOIN_SMSYN["USE"] == "Y" && $S_JOIN_SMSYN["MYPAGE"] == "Y"){?>
									<?if (!$S_JOIN_SMSYN["GRADE"] || in_array($strMemberJoinType,$S_JOIN_SMSYN["GRADE"])){?>
								<span><input type="checkbox" name="smsYN" id="smsYN" value="Y"<?if($memberRow['M_SMSYN']=="Y"){echo " checked";}?>/> <?=$LNG_TRANS_CHAR["MS00007"] //SMS 정보를 수신합니다.?> </span>
									<?}?>
								<?}?>
							</td>
						</tr>
							<?}?>
						<?}?>
						<!-- 핸드폰 -->
						<!-- 전화번호 -->
						<?if ($S_JOIN_PHONE["USE"] == "Y" && $S_JOIN_PHONE["MYPAGE"] == "Y"){?>
							<?if (!$S_JOIN_PHONE["GRADE"] || in_array($strMemberJoinType,$S_JOIN_PHONE["GRADE"])){?>
								<?
								if($strMemberJoinType != '002')
								{
								?>
						<tr>
							<th><?=$LNG_TRANS_CHAR["MW00009"] //전화번호?></th>
							<td>
								<?if ($S_SITE_LNG == "KR"){?>
								<?=drawSelectBoxMore("phone1",$aryPhone,$aryMemPhone[0],$design ="defSelect",$onchange="",$etc="id=\"phone1\"",$firstItem="",$html="N")?>
								 -
								<input type="input" id="phone2" name="phone2" class="defInput _w50" maxlength="4" autoMove="phone3" value="<?=$aryMemPhone[1]?>"/> -
								<input type="input" id="phone3" name="phone3" class="defInput _w50" maxlength="4" value="<?=$aryMemPhone[2]?>"/>
								<?}else {?>
								<input type="input" id="phone1" name="phone1" class="defInput _w200" maxlength="30" value="<?=$memberRow[M_PHONE]?>"/>
								<?}?>
							</td>
						</tr>
								<?}?>
							<?}?>
						<?}?>
						<!-- 전화번호 -->
						<!-- 팩스번호 -->
						<?if ($S_JOIN_FAX["USE"] == "Y" && $S_JOIN_FAX["MYPAGE"] == "Y"){?>
							<?if (!$S_JOIN_FAX["GRADE"] || in_array($strMemberJoinType,$S_JOIN_FAX["GRADE"])){?>
						<tr>
							<th><?=$LNG_TRANS_CHAR["MW00017"] //팩스번호?></th>
							<td>
								<?if ($S_SITE_LNG == "KR"){?>
								<?=drawSelectBoxMore("fax1",$aryPhone,$aryMemFax[0],$design ="defSelect",$onchange="",$etc="",$firstItem="",$html="N")?>
								 -
								<input type="input" id="fax2" name="fax2" class="defInput _w50" maxlength="4" autoMove="fax3" value="<?=$aryMemFax[1]?>"/> -
								<input type="input" id="fax3" name="fax3" class="defInput _w50" maxlength="4" value="<?=$aryMemFax[2]?>"/>
								<?}else {?>
								<input type="input" id="fax1" name="fax1" class="defInput _w200" maxlength="30" value="<?=$memberRow[M_FAX]?>"/>
								<?}?>
							</td>
						</tr>
							<?}?>
						<?}?>
						<!-- 팩스번호 -->
						<!-- 이메일 -->
						<?if ($S_JOIN_MAIL["USE"] == "Y" && $S_JOIN_MAIL["MYPAGE"] == "Y"){?>
							<?if (!$S_JOIN_MAIL["GRADE"] || in_array($strMemberJoinType,$S_JOIN_MAIL["GRADE"])){?>
						<tr>
							<th><strong>*</strong> <?=$LNG_TRANS_CHAR["MW00010"] //이메일?> </th>
							<td>
								<input type="input" id="mail" name="mail" class="defInput _w300" maxlength="30" value="<?=$memberRow[M_MAIL]?>" <?=($S_MEM_CERITY=="2")?"readonly":"";?>/>
								<?if ($S_JOIN_MAILYN["USE"] == "Y" && $S_JOIN_MAILYN["MYPAGE"] == "Y"){?>
									<?if (!$S_JOIN_MAILYN["GRADE"] || in_array($strMemberJoinType,$S_JOIN_MAILYN["GRADE"])){?>
								<span><input type="checkbox" id="mailYN" name="mailYN" value="Y"<?if($memberRow['M_MAILYN']=="Y"){echo " checked";}?>/> <?=$LNG_TRANS_CHAR["MS00008"] //메일 정보를 수신합니다.?> </span>
									<?}?>
								<?}?>
							</td>
						</tr>
							<?}?>
						<?}?>
						<!-- 이메일 -->
						<!-- 주소 -->
						<?if ($S_JOIN_ADDR["USE"] == "Y" && $S_JOIN_ADDR["MYPAGE"] == "Y"){?>
							<?if (!$S_JOIN_ADDR["GRADE"] || in_array($strMemberJoinType,$S_JOIN_ADDR["GRADE"])){?>
								<?$nesIcon = "";?>
								<?if($S_JOIN_ADDR["NES"]=="Y"){$nesIcon = "*";}?>
								<?if ($S_SITE_LNG == "KR"){?>
						<tr>
							<th><strong><?=$nesIcon?></strong> <?=$LNG_TRANS_CHAR["MW00011"] //주소?> </th>
							<td>
								<dl>
									<dd><input type="input" id="zip1" name="zip1" class="defInput _w30" maxlength="3" readonly value="<?=$aryMemZip[0]?>"/> - <input type="input" id="zip2" name="zip2" class="defInput _w30" maxlength="3" readonly value="<?=$aryMemZip[1]?>"/> <a href="javascript:goZip(1);" class="btnIDChk">우편번호</a></dd>
									<dd class="mt5"><input type="input" id="addr1" name="addr1" class="defInput _w300" maxlength="200" readonly value="<?=$memberRow[M_ADDR]?>"/></dd>
									<dd class="mt5"><input type="input" id="addr2" name="addr2" class="defInput _w300" maxlength="200"value="<?=$memberRow[M_ADDR2]?>"/></dd>
								</dl>
							</td>
						</tr>
								<?}else{?>
						<tr>
							<th><strong><?=$nesIcon?></strong> <?=$LNG_TRANS_CHAR["MW00021"] //국가?> </th>
							<td>
								<?=drawSelectBoxMore("country",$aryCountryList,$memberRow[M_COUNTRY],$design ="",$onchange="",$etc="",$firstItem="= Country =",$html="N")?>
							</td>
						</tr>
						<tr>
							<th><strong>*</strong> <?=$LNG_TRANS_CHAR["MW00011"] //주소?> </th>
							<td>
								<dl>
									<dd><input type="input" id="addr1" name="addr1" class="defInput _w300" maxlength="200" value="<?=$memberRow[M_ADDR]?>"/></dd>
								</dl>
							</td>
						</tr>
						<tr>
							<th><strong><?=$nesIcon?></strong> <?=$LNG_TRANS_CHAR["MW00013"] //상세주소?> </th>
							<td>
								<dl>
									<dd><input type="input" id="addr2" name="addr2" class="defInput _w300" maxlength="200" value="<?=$memberRow[M_ADDR2]?>"/></dd>
								</dl>
							</td>
						</tr>
						<tr>
							<th><strong><?=$nesIcon?></strong> <?=$LNG_TRANS_CHAR["MW00022"] //도시?> </th>
							<td>
								<dl>
									<dd><input type="input" id="city" name="city" class="defInput _w300" maxlength="200" value="<?=$memberRow[M_CITY]?>"/></dd>
								</dl>
							</td>
						</tr>
						<tr>
							<th><strong><?=$nesIcon?></strong> <?=$LNG_TRANS_CHAR["MW00023"] //주?> </th>
							<td>
								<div id="divState1" <?=($memberRow[M_COUNTRY]=="US")?"style=\"display:none\"":"";?>>
									<input type="input" id="state_1" name="state_1" class="defInput _w200" maxlength="50" value="<?=($memberRow[M_STATE])?$memberRow[M_STATE]:"N/A";?>"/>
								</div>
								<div id="divState2" <?=($memberRow[M_COUNTRY]!="US")?"style=\"display:none\"":"";?>>
									<?=drawSelectBoxMore("state_2",$aryCountryState,$memberRow[M_STATE],$design="",$onchange="",$etc="",$firstItem="= State =",$html="N")?>
								</div>
							</td>
						</tr>
						<tr>
							<th><strong><?=$nesIcon?></strong> <?=$LNG_TRANS_CHAR["MW00014"] //우편번호?> </th>
							<td>
								<dl>
									<dd><input type="input" id="zip1" name="zip1" class="defInput _w100" maxlength="20" value="<?=$memberRow[M_ZIP]?>"></dd>
								</dl>
							</td>
						</tr>
								<?}?>
							<?}?>
						<?}?>
						<!-- 주소 -->
						<!-- 사진 -->
						<?if ($S_JOIN_PHOTO["USE"] == "Y" && $S_JOIN_PHOTO["MYPAGE"] == "Y"){?>
							<?if (!$S_JOIN_PHOTO["GRADE"] || in_array($strMemberJoinType,$S_JOIN_PHOTO["GRADE"])){?>
						<tr>
							<th><strong></strong> <?=$LNG_TRANS_CHAR["MW00018"] //사진?></th>
							<td>
								<input type="file" id="photo" name="photo"/>
							</td>
						</tr>
							<?}?>
						<?}?>
						<!-- 사진 -->
						<!-- 추천인 -->
						<?if ($S_JOIN_REC["USE"] == "Y" && $S_JOIN_REC["MYPAGE"] == "Y"){?>
							<?if (!$S_JOIN_REC["GRADE"] || in_array($strMemberJoinType,$S_JOIN_REC["GRADE"])){?>
						<tr>
							<th><?=$LNG_TRANS_CHAR["MW00019"] //추천인?></th>
							<td>
								<input type="input" id="rec_id" name="rec_id" class="defInput" maxlength="50" value="<?=$memberRow['M_REC_NAME']?>" readonly/>
							</td>
						</tr>
							<?}?>
						<?}?>
						<!-- 추천인 -->
						<!-- 회사명 -->
						<?if ($S_JOIN_COM["USE"] == "Y" && $S_JOIN_COM["MYPAGE"] == "Y"){?>
							<?if (!$S_JOIN_COM["GRADE"] || in_array($strMemberJoinType,$S_JOIN_COM["GRADE"])){?>
						<tr>
							<th><?=$LNG_TRANS_CHAR["MW00020"] //회사명?></th>
							<td>
								<input type="input" id="com_nm" name="com_nm" class="defInput" maxlength="50"/>
							</td>
						</tr>
							<?}?>
						<?}?>
						<!-- 회사명 -->
						<!-- TM ID -->
						<?if ($S_JOIN_TM_ID["USE"] == "Y" && $S_JOIN_TM_ID["JOIN"] == "Y"){?>
							<?if (!$S_JOIN_TM_ID["GRADE"] || in_array($strMemberJoinType,$S_JOIN_TM_ID["GRADE"])){?>
						<tr>
							<th><?=($S_JOIN_TM_ID["NES"]=="Y")?"<strong>*</strong>":"";?>TM코드</th>
							<td>
								<input type="input" id="tm_id" name="tm_id" class="defInput" maxlength="20" value="<?=$memberRow[M_TM_ID]?>" <?=($memberRow[M_TM_ID])?"readonly":"";?>/>
							</td>
						</tr>
							<?}?>
						<?}?>
						<!-- TM ID -->
						<?if ($S_JOIN_TMP_1["USE"] == "Y" && $S_JOIN_TMP_1["JOIN"] == "Y"){?>
							<?if (!$S_JOIN_TMP_1["GRADE"] || in_array($strMemberJoinType,$S_JOIN_TMP_1["GRADE"])){?>
						<tr>
							<th><?=($S_JOIN_TMP_1["NES"]=="Y")?"<strong>*</strong>":"";?> <?=$S_JOIN_TMP_1["NAME_".$S_SITE_LNG] //임시필드?></th>
							<td>
								<?if ($S_JOIN_TMP_1["TYPE"] == "T"){?>
								<input type="input" id="tmp1" name="tmp1" class="defInput _w200" maxlength="50" value="<?=$memberRow[M_TMP1]?>"/>
								<?}?>
								<?if ($S_JOIN_TMP_1["TYPE"] == "S"){
									$aryJoinTmp1Val = explode(";",$S_JOIN_TMP_1["TYPE_VAL"]);
								?>
								<?=drawSelectBox("tmp1",$aryJoinTmp1Val,$memberRow[M_TMP1],$design ="defSelect",$onchange="",$etc="",$LNG_TRANS_CHAR["CW00039"])?>
								<?}?>
							</td>
						</tr>
							<?}?>
						<?}?>
						<?if ($S_JOIN_TMP_2["USE"] == "Y" && $S_JOIN_TMP_2["JOIN"] == "Y"){?>
							<?if (!$S_JOIN_TMP_2["GRADE"] || in_array($strMemberJoinType,$S_JOIN_TMP_2["GRADE"])){?>
						<tr>
							<th><?=($S_JOIN_TMP_2["NES"]=="Y")?"<strong>*</strong>":"";?> <?=$S_JOIN_TMP_2["NAME_".$S_SITE_LNG] //임시필드?></th>
							<td>
								<input type="input" id="tmp2" name="tmp2" class="defInput _w200" maxlength="50" value="<?=$memberRow[M_TMP2]?>"/>
							</td>
						</tr>
							<?}?>
						<?}?>
						<?if ($S_JOIN_TMP_3["USE"] == "Y" && $S_JOIN_TMP_3["JOIN"] == "Y"){?>
							<?if (!$S_JOIN_TMP_3["GRADE"] || in_array($strMemberJoinType,$S_JOIN_TMP_3["GRADE"])){?>
						<tr>
							<th><?=($S_JOIN_TMP_3["NES"]=="Y")?"<strong>*</strong>":"";?> <?=$S_JOIN_TMP_4["NAME_".$S_SITE_LNG] //임시필드?></th>
							<td>
								<input type="input" id="tmp3" name="tmp3" class="defInput _w200" maxlength="50" value="<?=$memberRow[M_TMP3]?>"/>
							</td>
						</tr>
							<?}?>
						<?}?>
						<?if ($S_JOIN_TMP_4["USE"] == "Y" && $S_JOIN_TMP_4["JOIN"] == "Y"){?>
							<?if (!$S_JOIN_TMP_4["GRADE"] || in_array($strMemberJoinType,$S_JOIN_TMP_4["GRADE"])){?>
						<tr>
							<th><?=($S_JOIN_TMP_4["NES"]=="Y")?"<strong>*</strong>":"";?> <?=$S_JOIN_TMP_4["NAME_".$S_SITE_LNG] //임시필드?></th>
							<td>
								<input type="input" id="tmp4" name="tmp4" class="defInput _w200" maxlength="50" value="<?=$memberRow[M_TMP4]?>"/>
							</td>
						</tr>
							<?}?>
						<?}?>
						<?if ($S_JOIN_TMP_5["USE"] == "Y" && $S_JOIN_TMP_5["JOIN"] == "Y"){?>
							<?if (!$S_JOIN_TMP_5["GRADE"] || in_array($strMemberJoinType,$S_JOIN_TMP_5["GRADE"])){?>
						<tr>
							<th><?=($S_JOIN_TMP_5["NES"]=="Y")?"<strong>*</strong>":"";?> <?=$S_JOIN_TMP_5["NAME_".$S_SITE_LNG] //임시필드?></th>
							<td>
								<input type="input" id="tmp5" name="tmp5" class="defInput _w200" maxlength="50" value="<?=$memberRow[M_TMP5]?>"/>
							</td>
						</tr>
							<?}?>
						<?}?>
						<!--임시필드-->
					</table>
				</div>
				<?
				if ($S_JOIN_BUSI_INFO["USE"] == "Y")
				{
					if($strMemberJoinType == '005')
					{
					?>
				<h4 class="mt30"></h4>
				<div class="regWrap">
					<table>
						<colgroup>
							<col style="width:110px;"/>
							<col/>
						</colgroup>
						<!-- 상호명 -->
						<?if ($S_JOIN_BUSI_NM["USE"] == "Y" && $S_JOIN_BUSI_NM["MYPAGE"] == "Y"){?>
							<?if (!$S_JOIN_BUSI_NM["GRADE"] || in_array($strMemberJoinType,$S_JOIN_BUSI_NM["GRADE"])){?>
						<tr>
							<th><?=$LNG_TRANS_CHAR["MW00032"] //상호명?></th>
							<td>
								<input type="input" id="busi_nm" name="busi_nm" class="defInput" maxlength="50" value="<?=$memberRow[M_BUSI_NM]?>"/>
							</td>
						</tr>
							<?}?>
						<?}?>
						<!-- 상호명 -->
						<!-- 사업자번호 -->
						<?if ($S_JOIN_BUSI_NUM["USE"] == "Y" && $S_JOIN_BUSI_NUM["MYPAGE"] == "Y"){?>
							<?if (!$S_JOIN_BUSI_NUM["GRADE"] || in_array($strMemberJoinType,$S_JOIN_BUSI_NUM["GRADE"])){?>
						<tr>
							<th><?=$LNG_TRANS_CHAR["MW00033"] //사업자번호?></th>
							<td>
								<input type="input" id="busi_num1" name="busi_num1" class="defInput" maxlength="3" value="<?=$aryMemBusiNum[0]?>"/> -
								<input type="input" id="busi_num2" name="busi_num2" class="defInput" maxlength="2" value="<?=$aryMemBusiNum[1]?>"/> -
								<input type="input" id="busi_num3" name="busi_num3" class="defInput" maxlength="5" value="<?=$aryMemBusiNum[2]?>"/> -
							</td>
						</tr>
							<?}?>
						<?}?>
						<!-- 사업자번호 -->
						<!-- 업종 -->
						<?if ($S_JOIN_BUSI_UPJONG["USE"] == "Y" && $S_JOIN_BUSI_UPJONG["MYPAGE"] == "Y"){?>
							<?if (!$S_JOIN_BUSI_UPJONG["GRADE"] || in_array($strMemberJoinType,$S_JOIN_BUSI_UPJONG["GRADE"])){?>
						<tr>
							<th><?=$LNG_TRANS_CHAR["MW00034"] //업종?></th>
							<td><input type="input" id="busi_upj" name="busi_upj" class="defInput" maxlength="50" value="<?=$memberRow[M_BUSI_UPJ]?>"/></td>
						</tr>
							<?}?>
						<?}?>
						<!-- 업종 -->
						<!-- 업태 -->
						<?if ($S_JOIN_BUSI_UPTAE["USE"] == "Y" && $S_JOIN_BUSI_UPTAE["MYPAGE"] == "Y"){?>
							<?if (!$S_JOIN_BUSI_UPTAE["GRADE"] || in_array($strMemberJoinType,$S_JOIN_BUSI_UPTAE["GRADE"])){?>
						<tr>
							<th><?=$LNG_TRANS_CHAR["MW00035"] //업태?></th>
							<td><input type="input" id="busi_ute" name="busi_ute" class="defInput" maxlength="50" value="<?=$memberRow[M_BUSI_UTE]?>"/></td>
						</tr>
							<?}?>
						<?}?>
						<!-- 업태 -->
						<!-- 주소 -->
						<?if ($S_JOIN_BUSI_ADDR["USE"] == "Y" && $S_JOIN_BUSI_ADDR["MYPAGE"] == "Y"){?>
							<?if (!$S_JOIN_BUSI_ADDR["GRADE"] || in_array($strMemberJoinType,$S_JOIN_BUSI_ADDR["GRADE"])){?>
						<tr>
							<th><?=$LNG_TRANS_CHAR["MW00011"] //주소?></th>
							<td>
								<dl>
									<dd><input type="input" id="busi_zip1" name="busi_zip1" class="defInput _w30" maxlength="3" readonly value="<?=$aryMemBusiZip[0]?>"/> - <input type="input" id="busi_zip2" name="busi_zip2" class="defInput _w30" maxlength="3" readonly value="<?=$aryMemBusiZip[1]?>"/> <a href="javascript:goZip(3);"><img src="/himg/member/A0001/<?=$S_SITE_LNG_PATH?>/btn_search_zip.gif"/></a></dd>
									<dd><input type="input" id="busi_addr1" name="busi_addr1" class="defInput _w300" maxlength="200" readonly value="<?=$memberRow[M_BUSI_ADDR1]?>"/></dd>
									<dd><input type="input" id="busi_addr2" name="busi_addr2" class="defInput _w300" maxlength="200" value="<?=$memberRow[M_BUSI_ADDR2]?>"/></dd>
								</dl>
							</td>
						</tr>
							<?}?>
						<?}?>
						<!-- 주소 -->
					</table>
				</div>
					<?}?>
				<?}?>
				<?if ($S_JOIN_ADD_WED["USE"] == "Y" || $S_JOIN_ADD_WED_DAY["USE"] == "Y" || $S_JOIN_ADD_CHILD["USE"] == "Y" || $S_JOIN_ADD_JOB["USE"] == "Y" || $S_JOIN_ADD_CONCERN["USE"] == "Y" || $S_JOIN_ADD_TEXT["USE"] == "Y"){?> 
				<h4 class="mt30"><img src="/himg/member/A0001/<?=$S_SITE_LNG_PATH?>/tit_mem_reg_2.gif"/></h4>
				<div class="regWrap">
					<table>
						<colgroup>
							<col style="width:110px;"/>
							<col/>
						</colgroup>
						<!-- 결혼여부 -->
						<?if ($S_JOIN_ADD_WED["USE"] == "Y" && $S_JOIN_ADD_WED["MYPAGE"] == "Y"){?>
							<?if (!$S_JOIN_ADD_WED["GRADE"] || in_array($strMemberJoinType,$S_JOIN_ADD_WED["GRADE"])){?>
						<tr>
							<th><?=$LNG_TRANS_CHAR["MW00024"] //결혼여부?></th>
							<td><input type="radio" id="weddingYN" name="weddingYN" value="N" <?=($memberRow[M_WED] == "N")?"checked":"";?>/> <?=$LNG_TRANS_CHAR["MW00030"] //미혼?> <input type="radio" id="weddingYN" name="weddingYN" value="Y" <?=($memberRow[M_WED] == "Y")?"checked":"";?>/> <?=$LNG_TRANS_CHAR["MW00031"] //기혼?></td>
						</tr>
							<?}?>
						<?}?>
						<!-- 결혼여부 -->
						<!-- 결혼기념일 -->
						<?if ($S_JOIN_ADD_WED_DAY["USE"] == "Y" && $S_JOIN_ADD_WED_DAY["MYPAGE"] == "Y"){?>
							<?if (!$S_JOIN_ADD_WED_DAY["GRADE"] || in_array($strMemberJoinType,$S_JOIN_ADD_WED_DAY["GRADE"])){?>
						<tr>
							<th><?=$LNG_TRANS_CHAR["MW00025"] //결혼기념일?></th>
							<td>
								<input type="input" id="weddingDay1" name="weddingDay1" class="defInput _w50" maxlength="4" value="<?=$aryMemWedDay[0]?>"/><?=$LNG_TRANS_CHAR["CW00010"] //년?>
								<input type="input" id="weddingDay2" name="weddingDay2" class="defInput _w30" maxlength="2" value="<?=$aryMemWedDay[1]?>"/><?=$LNG_TRANS_CHAR["CW00011"] //월?>
								<input type="input" id="weddingDay3" name="weddingDay3" class="defInput _w30" maxlength="2" value="<?=$aryMemWedDay[2]?>"/><?=$LNG_TRANS_CHAR["CW00012"] //일?>
							</td>
						</tr>
							<?}?>
						<?}?>
						<!-- 결혼기념일 -->
						<!-- 자녀 -->
						<?if ($S_JOIN_ADD_CHILD["USE"] == "Y" && $S_JOIN_ADD_CHILD["MYPAGE"] == "Y"){?>
							<?if (!$S_JOIN_ADD_CHILD["GRADE"] || in_array($strMemberJoinType,$S_JOIN_ADD_CHILD["GRADE"])){?>
						<tr>
							<th><?=$LNG_TRANS_CHAR["MW00026"] //자녀수?></th>
							<td>
								<input type="input" id="child" name="child" class="defInput _w50" maxlength="4"/>
							</td>
						</tr>
							<?}?>
						<?}?>
						<!-- 자녀 -->
						<!-- 직업 -->
						<?if ($S_JOIN_ADD_JOB["USE"] == "Y" && $S_JOIN_ADD_JOB["MYPAGE"] == "Y"){?>
							<?if (!$S_JOIN_ADD_JOB["GRADE"] || in_array($strMemberJoinType,$S_JOIN_ADD_JOB["GRADE"])){?>
						<tr>
							<th><?=$LNG_TRANS_CHAR["MW00027"] //직업?></th>
							<td>
								<?=drawSelectBoxMore("job",$aryJob,"",$design ="defSelect",$onchange="",$etc="id=\"job\"",$LNG_TRANS_CHAR["MW00027"],$html="N")?>
							</td>
						</tr>
							<?}?>
						<?}?>
						<!-- 직업 -->
						<!-- 관심분야 -->
						<?if ($S_JOIN_ADD_CONCERN["USE"] == "Y" && $S_JOIN_ADD_CONCERN["MYPAGE"] == "Y"){?>
							<?if (!$S_JOIN_ADD_CONCERN["GRADE"] || in_array($strMemberJoinType,$S_JOIN_ADD_CONCERN["GRADE"])){?>
						<tr>
							<th><?=$LNG_TRANS_CHAR["MW00028"] //관심분야?></th>
							<td>
								<ul>
								<?if ($S_JOIN_ADD_CONCERN["GRADE"] == "T"){?>
								<input type="input" id="concern" name="concern" class="defInput _w200" maxlength="100"/>
								<?} else if ($S_JOIN_ADD_CONCERN["GRADE"] == "R"){?>
								<?=drawRadioBoxMulti("concern",$aryConcern,$aryChecked="",$design="",$aryReadonly="", $gap="&nbsp;",$onclick="")?>
								<?} else if ($S_JOIN_ADD_CONCERN["GRADE"] == "C"){?>
								<?=drawCheckBoxMulti("concern",$aryConcern,$aryChecked="",$design="",$aryReadonly="", $gap="&nbsp;",$onclick="")?>
								<?} else if ($S_JOIN_ADD_CONCERN["GRADE"] == "S"){?>
								<?=drawSelectBoxMore("concern",$aryConcern,"",$design ="defSelect",$onchange="",$etc="",$LNG_TRANS_CHAR["MW00028"],$html="N")?>
								<?}?>
								
								</ul>
							</td>
						</tr>
							<?}?>
						<?}?>
						<!-- 관심분야 -->
						<!-- 남기는 말씀 -->
						<?if ($S_JOIN_ADD_TEXT["USE"] == "Y" && $S_JOIN_ADD_TEXT["MYPAGE"] == "Y"){?>
							<?if (!$S_JOIN_ADD_TEXT["GRADE"] || in_array($strMemberJoinType,$S_JOIN_ADD_TEXT["GRADE"])){?>
						<tr>
							<th><?=$LNG_TRANS_CHAR["MW00029"] //남기는 말씀?></th>
							<td><textarea id="memo" name="memo" class="defInput" style="width:100%;height:50px;"></textarea></td>
						</tr>
							<?}?>
						<?}?>
						<!-- 남기는 말씀 -->
					</table>
				</div>
				<?}?>
				<div class="btnMemOut">
					<a href="javascript:goMypageDropoutMoveEvent()" class="btn_goPopOut"><span><?=$LNG_TRANS_CHAR["MW00067"]//회원탈퇴 신청?></span></a>
				</div>


			<?if ($S_MEM_FAMILY == "Y"){?>
				<div class="mypageExInfo">
					<?include "../layout/member/member_family_modify.inc.php";?>
				</div>
			<?}?>
			<? 
				if ($S_FIX_MEMBER_CATE_USE_YN == "Y"){
			?>
				<div>
					<?include "../layout/member/member_cate_join.inc.php";?>
				</div>
			<?
				}
			?>