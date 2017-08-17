
			<div class="myInfoTableWrap">
			<!-- (1) 기본정보 입력  -->
				<div class="myInfoTable">
					<table class="tableFormType">
						<!--아이디-->
						<?if ($S_MEM_CERITY == "1"){?>
							<?if ($S_JOIN_ID["USE"] == "Y" && $S_JOIN_ID["MYPAGE"] == "Y"){?>
								<?if (!$S_JOIN_ID["GRADE"] || in_array($strMemberJoinType,$S_JOIN_ID["GRADE"])){?>
									<tr>
										<th><?=$LNG_TRANS_CHAR["MW00001"] //아이디?></th>
										<td><?=$memberRow[M_ID]?></td>
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
											<th><?=$LNG_TRANS_CHAR["MW00012"] //성?> </th>
											<td><?=$memberRow[M_F_NAME]?></td>
										</tr>
									<?endif;?>
										<tr>
											<th><?=$LNG_TRANS_CHAR["MW00004"] //이름?> </th>
											<td><?=$memberRow[M_L_NAME]?></td>
										</tr>
								<?}?>
							<?}?>
						<?}?>
						<!--이름-->
						<tr>
							<th><?=$LNG_TRANS_CHAR["MW00117"] //기본비밀번호?> </th>
							<td>
								<input type="password" id="pwd" name="pwd" class="i_w" maxlength="16"/>
							</td>
						</tr>
						<!--비밀번호-->
						<?if ($S_JOIN_PASS["USE"] == "Y" && $S_JOIN_PASS["MYPAGE"] == "Y"){?>
							<?if (!$S_JOIN_PASS["GRADE"] || in_array($strMemberJoinType,$S_JOIN_PASS["GRADE"])){?>
								<tr>
									<th><?=$LNG_TRANS_CHAR["MW00002"] //비밀번호?> </th>
									<td>
										<input type="password" id="pwd1" name="pwd1" class="i_w" maxlength="16"/>
										<div class="tdTextGuide"><?=$LNG_TRANS_CHAR["MS00004"] //영문, 숫자, 특수문자 중 4자 이상 16자리 이하 사용?> </div>
									</td>
								</tr>
								<tr>
									<th><?=$LNG_TRANS_CHAR["MW00003"] //비밀번호 확인?> </th>
									<td>
										<input type="password" id="pwd2" name="pwd2" class="i_w" maxlength="16"/>
										<div class="tdTextGuide"><?=$LNG_TRANS_CHAR["MS00005"] //비밀번호를 한번더 입력해 주세요.?> </div>
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
									<th><?=$LNG_TRANS_CHAR["MW00012"] //성?> </th>
									<td><?=$memberRow[M_F_NAME]?></td>
								</tr>
											<?endif;?>
								<tr>
									<th><?=$LNG_TRANS_CHAR["MW00004"] //이름?> </th>
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
									<th><?=$LNG_TRANS_CHAR["MW00005"] //닉네임?></th>
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
										<th><?=$LNG_TRANS_CHAR["MW00006"] //생년월일?></th>
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
									<th><?=$LNG_TRANS_CHAR["MW00007"] //성별?></th>
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
									<th><?=$LNG_TRANS_CHAR["MW00008"] //핸드폰?> <strong>*</strong></th>
									<td>
										<?if ($S_SITE_LNG == "KR"){?>
										<?=drawSelectBoxMore("hp1",$aryHp,$aryMemHp[0],$design ="defSelect",$onchange="",$etc="id=\"hp1\"",$firstItem="",$html="N")?>
										 -
										<input type="tel" id="hp2" name="hp2" class="i_tel" maxlength="4" value="<?=$aryMemHp[1]?>"/> -
										<input type="tel" id="hp3" name="hp3" class="i_tel" maxlength="4" value="<?=$aryMemHp[2]?>"/>
										<?}else{?>
										<input type="input" id="hp1" name="hp1" class="i_w" maxlength="30" value="<?=$memberRow[M_HP]?>"/>
										<?}?>
										
										<?if ($S_JOIN_SMSYN["USE"] == "Y" && $S_JOIN_SMSYN["MYPAGE"] == "Y"){?>
											<?if (!$S_JOIN_SMSYN["GRADE"] || in_array($strMemberJoinType,$S_JOIN_SMSYN["GRADE"])){?>
												<div><input type="checkbox" name="smsYN" id="smsYN" value="Y" checked/> <?=$LNG_TRANS_CHAR["MS00007"] //SMS 정보를 수신합니다.?> </div>
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
									<tr>
										<th><?=$LNG_TRANS_CHAR["MW00009"] //전화번호?></th>
										<td class="number">
											<?if ($S_SITE_LNG == "KR"){?>
											<?=drawSelectBoxMore("phone1",$aryPhone,$aryMemPhone[0],$design ="defSelect",$onchange="",$etc="id=\"phone1\"",$firstItem="",$html="N")?>
											 -
											<input type="tel" id="phone2" name="phone2" class="i_tel" maxlength="4" value="<?=$aryMemPhone[1]?>"/> -
											<input type="tel" id="phone3" name="phone3" class="i_tel" maxlength="4" value="<?=$aryMemPhone[2]?>"/>
											<?}else {?>
												<input type="input" id="phone1" name="phone1" class="i_w" maxlength="30" value="<?=$memberRow[M_PHONE]?>"/>
											<?}?>
										</td>
									</tr>
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
											<input type="tel" id="fax2" name="fax2" class="i_tel" maxlength="4" value="<?=$aryMemFax[1]?>"/> -
											<input type="tel" id="fax3" name="fax3" class="i_tel" maxlength="4" value="<?=$aryMemFax[2]?>"/>
											<?}else {?>
											<input type="input" id="fax1" name="fax1" class="i_w" maxlength="30" value="<?=$memberRow[M_FAX]?>"/>
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
										<th><?=$LNG_TRANS_CHAR["MW00010"] //이메일?> <strong>*</strong> </th>
										<td>
											<input type="email" id="mail" name="mail" class="i_w" maxlength="30" value="<?=$memberRow[M_MAIL]?>" <?=($S_MEM_CERITY=="2")?"readonly":"";?>/>
											<?if ($S_JOIN_MAILYN["USE"] == "Y" && $S_JOIN_MAILYN["MYPAGE"] == "Y"){?>
												<?if (!$S_JOIN_MAILYN["GRADE"] || in_array($strMemberJoinType,$S_JOIN_MAILYN["GRADE"])){?>
													<div class="emailChk"><input type="checkbox" id="mailYN" name="mailYN" value="Y" checked/> <?=$LNG_TRANS_CHAR["MS00008"] //메일 정보를 수신합니다.?> </div>
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
								<?if ($S_SITE_LNG == "KR"){?>
									<tr>
										<th><?=$LNG_TRANS_CHAR["MW00011"] //주소?> <strong>*</strong></th>
										<td>
											<dl>
												<dd class="zipCodeWrap"><input type="tel" id="zip1" name="zip1" class="i_wz" maxlength="3" readonly value="<?=$aryMemZip[0]?>"/> - 
												<input type="tel" id="zip2" name="zip2" class="i_wz" maxlength="3" readonly value="<?=$aryMemZip[1]?>"/> 
												<a href="javascript:goZip(1);" class="btn_Addr"><span><?=$LNG_TRANS_CHAR["MW00014"] //우편번호?></span></a></dd>
												<dd><input type="text" id="addr1" name="addr1" class="i_w" maxlength="200" readonly value="<?=$memberRow[M_ADDR]?>"/></dd>
												<dd><input type="text" id="addr2" name="addr2" class="i_w" maxlength="200"value="<?=$memberRow[M_ADDR2]?>"/></dd>
											</dl>
										</td>
									</tr>
								<?}else{?>
									<tr>
										<th><?=$LNG_TRANS_CHAR["MW00021"] //국가?> <strong>*</strong></th>
										<td>
											<?=drawSelectBoxMore("country",$aryCountryList,$memberRow[M_COUNTRY],$design ="",$onchange="",$etc="",$firstItem="= Country =",$html="N")?>
										</td>
									</tr>
									<tr>
										<th><?=$LNG_TRANS_CHAR["MW00011"] //주소?> <strong>*</strong></th>
										<td>
											<dl>
												<dd><input type="input" id="addr1" name="addr1" class="defInput _w300" maxlength="200" value="<?=$memberRow[M_ADDR]?>"/></dd>
											</dl>
										</td>
									</tr>
									<tr>
										<th><?=$LNG_TRANS_CHAR["MW00013"] //상세주소?> <strong>*</strong></th>
										<td>
											<dl>
												<dd><input type="input" id="addr2" name="addr2" class="defInput _w300" maxlength="200" value="<?=$memberRow[M_ADDR2]?>"/></dd>
											</dl>
										</td>
									</tr>
									<tr>
										<th><?=$LNG_TRANS_CHAR["MW00022"] //도시?> <strong>*</strong></th>
										<td>
											<dl>
												<dd><input type="input" id="city" name="city" class="defInput _w300" maxlength="200" value="<?=$memberRow[M_CITY]?>"/></dd>
											</dl>
										</td>
									</tr>
									<tr>
										<th><?=$LNG_TRANS_CHAR["MW00023"] //주?> <strong>*</strong></th>
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
										<th><?=$LNG_TRANS_CHAR["MW00014"] //우편번호?> <strong>*</strong></th>
										<td>
											<dl>
												<dd><input type="tel" id="zip1" name="zip1" class="defInput _w100" maxlength="20" value="<?=$memberRow[M_ZIP]?>"></dd>
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
										<th><?=$LNG_TRANS_CHAR["MW00017"] //사진?></th>
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
											<input type="input" id="rec_id" name="rec_id" class="defInput" maxlength="50"/>
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
										<th><?=($S_JOIN_TM_ID["NES"]=="Y")?"<strong>*</strong>":"";?> TM코드</th>
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
										<th> <?=$S_JOIN_TMP_1["NAME_".$S_SITE_LNG] //임시필드?></th>
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
										<th><?=$S_JOIN_TMP_4["NAME_".$S_SITE_LNG] //임시필드?></th>
										<td>
											<input type="input" id="tmp3" name="tmp3" class="defInput _w200" maxlength="50" value="<?=$memberRow[M_TMP3]?>"/>
										</td>
									</tr>
							<?}?>
						<?}?>
						<?if ($S_JOIN_TMP_4["USE"] == "Y" && $S_JOIN_TMP_4["JOIN"] == "Y"){?>
							<?if (!$S_JOIN_TMP_4["GRADE"] || in_array($strMemberJoinType,$S_JOIN_TMP_4["GRADE"])){?>
									<tr>
										<th><?=$S_JOIN_TMP_4["NAME_".$S_SITE_LNG] //임시필드?></th>
										<td>
											<input type="input" id="tmp4" name="tmp4" class="defInput _w200" maxlength="50" value="<?=$memberRow[M_TMP4]?>"/>
										</td>
									</tr>
							<?}?>
						<?}?>
						<?if ($S_JOIN_TMP_5["USE"] == "Y" && $S_JOIN_TMP_5["JOIN"] == "Y"){?>
							<?if (!$S_JOIN_TMP_5["GRADE"] || in_array($strMemberJoinType,$S_JOIN_TMP_5["GRADE"])){?>
									<tr>
										<th><?=$S_JOIN_TMP_5["NAME_".$S_SITE_LNG] //임시필드?></th>
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
					if($strMemberJoinType=='005')
					{
				?>
				<div class="titBox mt30"><span class="barRed"></span><span class="tit">추가정보</span></div>
				<div class="regWrap myInfoTableWrap">
					<div class="myInfoTable tableFormType">
						<table>
							<colgroup>
								<col />
								<col/>
							</colgroup>
							<!-- 상호명 -->
							<?if ($S_JOIN_BUSI_NM["USE"] == "Y" && $S_JOIN_BUSI_NM["MYPAGE"] == "Y"){?>
								<?if (!$S_JOIN_BUSI_NM["GRADE"] || in_array($strMemberJoinType,$S_JOIN_BUSI_NM["GRADE"])){?>
							<tr>
								<th><?=$LNG_TRANS_CHAR["MW00032"] //상호명?></th>
								<td>
									<input type="text" id="busi_nm" name="busi_nm" class="defInput i_w" maxlength="50" value="<?=$memberRow[M_BUSI_NM]?>"/>
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
								<td class="number">
									<input type="tel" id="busi_num1" name="busi_num1" class="defInput" maxlength="3" value="<?=$aryMemBusiNum[0]?>"/> -
									<input type="tel" id="busi_num2" name="busi_num2" class="defInput" maxlength="2" value="<?=$aryMemBusiNum[1]?>"/> -
									<input type="tel" id="busi_num3" name="busi_num3" class="defInput" maxlength="5" value="<?=$aryMemBusiNum[2]?>"/>
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
								<td><input type="input" id="busi_upj" name="busi_upj" class="defInput i_w" maxlength="50" value="<?=$memberRow[BUSI_UPJ]?>"/></td>
							</tr>
								<?}?>
							<?}?>
							<!-- 업종 -->
							<!-- 업태 -->
							<?if ($S_JOIN_BUSI_UPTAE["USE"] == "Y" && $S_JOIN_BUSI_UPTAE["MYPAGE"] == "Y"){?>
								<?if (!$S_JOIN_BUSI_UPTAE["GRADE"] || in_array($strMemberJoinType,$S_JOIN_BUSI_UPTAE["GRADE"])){?>
							<tr>
								<th><?=$LNG_TRANS_CHAR["MW00035"] //업태?></th>
								<td><input type="input" id="busi_ute" name="busi_ute" class="defInput i_w" maxlength="50" value="<?=$memberRow[BUSI_UTE]?>"/></td>
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
										<dd class="zipCodeWrap"><input type="tel" id="busi_zip1" name="busi_zip1" class="defInput _w30" maxlength="3" readonly value="<?=$aryMemBusiZip[0]?>"/> - <input type="tel" id="busi_zip2" name="busi_zip2" class="defInput _w30" maxlength="3" readonly value="<?=$aryMemBusiZip[1]?>"/> <a href="javascript:goZip(3);" class="btn_Addr">우편번호</a></dd>
										<dd><input type="input" id="busi_addr1" name="busi_addr1" class="defInput _w300" maxlength="200" readonly value="<?=$memberRow[BUSI_ADDR1]?>"/></dd>
										<dd><input type="input" id="busi_addr2" name="busi_addr2" class="defInput _w300" maxlength="200" value="<?=$memberRow[BUSI_ADDR2]?>"/></dd>
									</dl>
								</td>
							</tr>
								<?}?>
							<?}?>
							<!-- 주소 -->
						</table>
					</div>
				</div>

				<?
					}
				}
				?>
				<?if ($S_JOIN_ADD_WED["USE"] == "Y" || $S_JOIN_ADD_WED_DAY["USE"] == "Y" || $S_JOIN_ADD_CHILD["USE"] == "Y" || $S_JOIN_ADD_JOB["USE"] == "Y" || $S_JOIN_ADD_CONCERN["USE"] == "Y" || $S_JOIN_ADD_TEXT["USE"] == "Y"){?> 
				<div class="titBox mt30"><span class="barRed"></span><span class="tit">추가정보</span></div>
				<div class="regWrap myInfoTableWrap">
					<div class="myInfoTable tableFormType">
						<table>
							<colgroup>
								<col />
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
									<input type="tel" id="child" name="child" class="defInput _w50" maxlength="4"/>
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
						<!--<div class="etcBtn"><a href="#">회원탈퇴</a></div>//-->
					</div>
				</div>
				<?}?>


			<?if ($S_MEM_FAMILY == "Y"){?>
			<script type="text/javascript">
			<!--
				function goMemberFamilyAdd(){
					var intCnt = $("div[id^=divMemberFmy]").size() + 1;
					
					var stsrCopyId  = "divMemberFmy"+intCnt;
					var strCopyHtml = $("#divMemberFmy1").html();
					var intMF_NO    = $("#divMemberFmy1").find("input[type^=hidden").val();
					
					
					$("#divMemberFamilyList").append($('<div />').attr('id', stsrCopyId));
					$("#"+stsrCopyId).html(strCopyHtml);

					$("#"+stsrCopyId).find("#btnMemberFamilyDel").attr("href","javascript:goMemberFamilyDel("+intCnt+");");
					$("#"+stsrCopyId).find("input[type^=text]").each(function(i){
						$(this).attr("id",$(this).attr("id").replace("_"+intMF_NO,"[]"));
						$(this).attr("name",$(this).attr("name").replace("_"+intMF_NO,"[]"));
						$(this).val("");
					});

					$("#"+stsrCopyId).find("input[type^=checkbox]").each(function(i){
						$(this).attr("id",$(this).attr("id").replace("_"+intMF_NO,"[]"));
						$(this).attr("name",$(this).attr("name").replace("_"+intMF_NO,"[]"));
					});

					$("#"+stsrCopyId).find("input[type^=radio]").each(function(i){
						$(this).attr("id",$(this).attr("id").replace("_"+intMF_NO,"[]"));
						$(this).attr("name",$(this).attr("name").replace("_"+intMF_NO,"[]"));
					});
					
					$("#"+stsrCopyId).find("input[type^=hidden]").remove();				
				}

				function goMemberFamilyDel(no){
					if (no == 1) {
						alert("아기정보를 삭제하실 수 없습니다.");
						return;
					}

					$("#divMemberFmy"+no).remove();
				}
			//-->
			</script>
			<div class="joinWrap mt20">
				<div class="addBabyInfo">
					<h3>우리아기 정보</h3>
					<a href="javascript:goMemberFamilyAdd();" class="addBtn"><span>아기정보 추가</span></a>
					<div class="clear"></div>
					<span>우리아기 정보를 입력하시면 아이배냇에서 준비한 임신/출산/육아 안내 책자등 아기월령에 맞추어 다양한 선물을 받아보실 수 있습니다.</span>
				</div>
				<div id="divMemberFamilyList">
					<?if (is_array($aryMemberFamilyList)){
						for($i=0;$i<sizeof($aryMemberFamilyList);$i++){
							$intMF_NO = $aryMemberFamilyList[$i][MF_NO];
							$aryMemberFamilyDay = explode("-",$aryMemberFamilyList[$i][MF_DAY]);
					?>
					<div class="regWrap mt10" id="divMemberFmy<?=($i+1)?>">
						<table>
							<colgroup>
								<col/>
								<col/>
							</colgroup>
							<tr>
								<td colspan="2">
									<a href="javascript:goMemberFamilyDel(1)" id="btnMemberFamilyDel">[아기정보삭제]</a>
									<input type="hidden" name="fa_no[]" id="fa_no[]" value="<?=$aryMemberFamilyList[$i][MF_NO]?>">
								</td>
							</tr>
							<tr>
								<th>아기이름(태명)</th>
								<td>
									<input type="text" id="fa_name_<?=$intMF_NO?>" name="fa_name_<?=$intMF_NO?>" class="defInput" maxlength="20" value="<?=$aryMemberFamilyList[$i][MF_NAME]?>"/>
									<div class="addChkWrap">
										<input type="checkbox" name="fa_name_yet_<?=$intMF_NO?>" id="fa_name_yet_<?=$intMF_NO?>" value="1" <?=($aryMemberFamilyList[$i][MF_NAME_YET]=="1")?"checked":"";?>> 이름(태명)지정
									</div>
								</td>
							</tr>
							<tr>
								<th>출생일 또는 예정일</th>
								<td>
									<input type="tel" id="fa_day1_<?=$intMF_NO?>" name="fa_day1_<?=$intMF_NO?>" class="defInput _w30" maxlength="4" value="<?=$aryMemberFamilyDay[0]?>"/><?=$LNG_TRANS_CHAR["CW00010"] //년?>
									<input type="tel" id="fa_day2_<?=$intMF_NO?>" name="fa_day2_<?=$intMF_NO?>" class="defInput _w30" maxlength="2" value="<?=$aryMemberFamilyDay[1]?>"/><?=$LNG_TRANS_CHAR["CW00011"] //월?>
									<input type="tel" id="fa_day3_<?=$intMF_NO?>" name="fa_day3_<?=$intMF_NO?>" class="defInput _w30" maxlength="2" value="<?=$aryMemberFamilyDay[2]?>"/><?=$LNG_TRANS_CHAR["CW00012"] //일?>
								</td>
							</tr>
							<tr>
								<th>이용(출산예정)병원</th>
								<td>
									<input type="text" id="fa_hosp_<?=$intMF_NO?>" name="fa_hosp_<?=$intMF_NO?>" class="defInput" maxlength="50" value="<?=$aryMemberFamilyList[$i][MF_HOSP]?>"/>
									<input type="checkbox" name="fa_hosp_yet_<?=$intMF_NO?>" id="fa_hosp_yet_<?=$intMF_NO?>" value="1" <?=($aryMemberFamilyList[$i][MF_HOSP_YET]=="1")?"checked":"";?>> 이용(출산예정)병원 없음
								</td>
							</tr>
							<tr>
								<th>시기별맞춤정보</th>
								<td>
									선택한 아기정보에 대한 맞춤 서비스를 제공 받으시겠습니까?
									<input type="radio" name="fa_info_<?=$intMF_NO?>" id="fa_info_<?=$intMF_NO?>" value="1"  <?=($aryMemberFamilyList[$i][MF_INFO]=="1")?"checked":"";?>> 예
									<input type="radio" name="fa_info_<?=$intMF_NO?>" id="fa_info_<?=$intMF_NO?>" value="0"  <?=($aryMemberFamilyList[$i][MF_INFO]=="0")?"checked":"";?>> 아니오
								</td>
							</tr>
							<tr>
								<th>성별</th>
								<td>
									<input type="radio" name="fa_sex_<?=$intMF_NO?>" id="fa_sex_<?=$intMF_NO?>" value="P"  <?=($aryMemberFamilyList[$i][MF_SEX]=="P")?"checked":"";?>> 임신중
									<input type="radio" name="fa_sex_<?=$intMF_NO?>" id="fa_sex_<?=$intMF_NO?>" value="M"  <?=($aryMemberFamilyList[$i][MF_SEX]=="M")?"checked":"";?>> 남
									<input type="radio" name="fa_sex_<?=$intMF_NO?>" id="fa_sex_<?=$intMF_NO?>" value="F"  <?=($aryMemberFamilyList[$i][MF_SEX]=="F")?"checked":"";?>> 여
								</td>
							</tr>
						</table>
					</div>
					<?}?>
				</div>
				<?}else{?>
				<div class="regWrap mt10" id="divMemberFmy1">
						<table>
							<colgroup>
								<col/>
								<col/>
							</colgroup>
							<tr>
								<th>아기이름(태명)</th>
								<td>
									<input type="input" id="fa_name[]" name="fa_name[]" class="defInput" maxlength="20" value=""/>
									<div class="addChkWrap">
										<input type="checkbox" name="fa_name_yet[]" id="fa_name_yet[]" value="1"> 이름(태명)지정
										<a href="javascript:goMemberFamilyDel('<?=$cnt?>')" id="btnMemberFamilyDel" class="delBtn" style="padding:3px 10px;">삭제</a>
									</div>
								</td>
							</tr>
							<tr>
								<th>출생일 또는 예정일</th>
								<td>
									<input type="tel" id="fa_day1[]" name="fa_day1[]" class="defInput _w30" maxlength="4" value=""/><?=$LNG_TRANS_CHAR["CW00010"] //년?>
									<input type="tel" id="fa_day2[]" name="fa_day2[]" class="defInput _w30" maxlength="2"/><?=$LNG_TRANS_CHAR["CW00011"] //월?>
									<input type="tel" id="fa_day3[]" name="fa_day3[]" class="defInput _w30" maxlength="2"/><?=$LNG_TRANS_CHAR["CW00012"] //일?>
								</td>
							</tr>
							<tr>
								<th>이용(출산예정)병원</th>
								<td>
									<input type="input" id="fa_hosp[]" name="fa_hosp[]" class="defInput" maxlength="50" value=""/>
									<div class="addChkWrap">
										<input type="checkbox" name="fa_hosp_yet[]" id="fa_hosp_yet[]" value="1"> 이용(출산예정)병원 없음
									</div>
								</td>
							</tr>
							<tr>
								<th>시기별맞춤정보</th>
								<td>
									선택한 아기정보에 대한 맞춤 서비스를 제공 받으시겠습니까?
									<input type="radio" name="fa_info[]" id="fa_info[]" value="1" checked> 예
									<input type="radio" name="fa_info[]" id="fa_info[]" value="0"> 아니오
								</td>
							</tr>
							<tr>
								<th>성별</th>
								<td>
									<input type="radio" name="fa_sex[]" id="fa_sex[]" value="P" checked> 임신중
									<input type="radio" name="fa_sex[]" id="fa_sex[]" value="M"> 남
									<input type="radio" name="fa_sex[]" id="fa_sex[]" value="F"> 여
								</td>
							</tr>
						</table>
					</div>
				</div>
				<?}?>
			</div>	
			<?}?>
			</div>