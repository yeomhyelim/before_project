		<div class="regStepWrap">
			<ul>
				<li class="step_1">
					<span><?=$LNG_TRANS_CHAR["MW00040"] //약관동의?></span>
					<div class="stepIco"></div>
				</li>
				<li class="step_2">
					<span><?=$LNG_TRANS_CHAR["CW00047"] //회원가입신청?></span>
					<div class="stepIcoOn"></div>
				</li>
				<li class="step_3 stepOn">
					<span><?=$LNG_TRANS_CHAR["MW00080"] //가입완료?></span>
				</li>
			</ul>
			<div class="clr"></div>
		</div>

		<div class="joinApplyWrap">
			<!-- (1) 기본정보 입력  -->
				<div class="titBox"><span class="barRed"></span><span class="tit"><?=$LNG_TRANS_CHAR["MW00046"] //회원기본 정보?></span></div>
				<div class="memRegInfo">
					<span class="ico_smile"></span>
					<p><?=callLangTrans($LNG_TRANS_CHAR["MS00019"],array($row[M_F_NAME]." ".$row[M_L_NAME]))//님의 회원가입이 완료 되었습니다.?></p>
				</div>
				<div class="joinTableWrap">
					<table class="tableFormType">

						<!--아이디-->
						<?if ($S_MEM_CERITY == "1"){?>
							<?if ($S_JOIN_ID["USE"] == "Y" && $S_JOIN_ID["JOIN"] == "Y"){?>
								<?if (!$S_JOIN_ID["GRADE"] || in_array($strMemberJoinType,$S_JOIN_ID["GRADE"])){?>
								<tr>
									<th><?=$LNG_TRANS_CHAR["MW00001"] //아이디?><strong>*</strong></th>
									<td>
										<?=$row[M_ID]?>
									</td>
								</tr>
								<?}?>
							<?}?>
						<?}?>
						<!--아이디-->

						<!--이름-->
						<?if ($S_JOIN_NAME["USE"] == "Y" && $S_JOIN_NAME["JOIN"] == "Y"){?>
							<?if (!$S_JOIN_NAME["GRADE"] || in_array($strMemberJoinType,$S_JOIN_NAME["GRADE"])){?>
									<tr>
										<th><?=$LNG_TRANS_CHAR["MW00004"] //이름?><strong>*</strong> </th>
										<td><?=$row[M_F_NAME]?> <?=$row[M_L_NAME]?></td>
									</tr>
							<?}?>
						<?}?>
						<!--이름-->

						<!--이름-->
						<!-- 닉네임 -->
						<?if ($S_JOIN_NICKNAME["USE"] == "Y" && $S_JOIN_NICKNAME["JOIN"] == "Y"){?>
							<?if (!$S_JOIN_NICKNAME["GRADE"] || in_array($strMemberJoinType,$S_JOIN_NICKNAME["GRADE"])){?>
									<tr>
										<th><?=$LNG_TRANS_CHAR["MW00005"] //닉네임?><?=($S_JOIN_NICKNAME["NES"]=="Y")?"<strong>*</strong>":"";?> </th>
										<td>
											<?=$row[M_NICK_NAME]?>
										</td>
									</tr>
							<?}?>
						<?}?>
						<!-- 닉네임 -->
						<!-- 생년월일/음력/양력 -->
						<?if ($S_JOIN_BIRTH["USE"] == "Y" && $S_JOIN_BIRTH["JOIN"] == "Y"){?>
							<?if (!$S_JOIN_BIRTH["GRADE"] || in_array($strMemberJoinType,$S_JOIN_BIRTH["GRADE"])){?>
									<tr>
										<th> <?=$LNG_TRANS_CHAR["MW00006"] //생년월일?><?=($S_JOIN_BIRTH["NES"]=="Y")?"<strong>*</strong>":"";?></th>
										<td>
											<?=SUBSTR($row[M_BIRTH],0,4)?><?=$LNG_TRANS_CHAR["CW00010"]?> <?=SUBSTR($row[M_BIRTH],5,2)?><?=$LNG_TRANS_CHAR["CW00011"]?> <?=SUBSTR($row[M_BIRTH],8)?><?=$LNG_TRANS_CHAR["CW00012"]?>
											<?if ($S_JOIN_BIRTH_CAL["USE"] == "Y" && $S_JOIN_BIRTH_CAL["JOIN"] == "Y"){?>
												<?if (!$S_JOIN_BIRTH_CAL["GRADE"] || in_array($strMemberJoinType,$S_JOIN_BIRTH_CAL["GRADE"])){?>
													<?=($row[M_BIRTH_CAL]=="1")?$LNG_TRANS_CHAR["MW00015"]:$LNG_TRANS_CHAR["MW00016"];?>
												<?}?>
											<?}?>
										</td>
									</tr>
							<?}?>
						<?}?>
						<!-- 성별 -->
						<?if ($S_JOIN_SEX["USE"] == "Y" && $S_JOIN_SEX["JOIN"] == "Y"){?>
							<?if (!$S_JOIN_SEX["GRADE"] || in_array($strMemberJoinType,$S_JOIN_SEX["GRADE"])){?>
									<tr>
										<th><?=$LNG_TRANS_CHAR["MW00007"] //성별?><?=($S_JOIN_SEX["NES"]=="Y")?"<strong>*</strong>":"";?></th>
										<td>
											<?=($row[M_SEX]=="M")?$LNG_TRANS_CHAR["CW00008"]:$LNG_TRANS_CHAR["CW00009"];?>
										</td>
									</tr>
							<?}?>
						<?}?>
						<!-- 성별 -->
						<!-- 핸드폰 -->
						<?if ($S_JOIN_HP["USE"] == "Y" && $S_JOIN_HP["JOIN"] == "Y"){?>
							<?if (!$S_JOIN_HP["GRADE"] || in_array($strMemberJoinType,$S_JOIN_HP["GRADE"])){?>
									<tr>
										<th><?=$LNG_TRANS_CHAR["MW00008"] //핸드폰?><?=($S_JOIN_HP["NES"]=="Y")?"<strong>*</strong>":"";?> </th>
										<td>
											<?=$row[M_HP]?>
											
											<?if ($S_JOIN_SMSYN["USE"] == "Y" && $S_JOIN_SMSYN["JOIN"] == "Y"){?>
												<?if (!$S_JOIN_SMSYN["GRADE"] || in_array($strMemberJoinType,$S_JOIN_SMSYN["GRADE"])){?>
													<p><?=($row[M_SMSYN]=="Y")?$LNG_TRANS_CHAR["MS00007"].": YES":"";?> </p>
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
										<th><?=$LNG_TRANS_CHAR["MW00009"] //전화번호?><?=($S_JOIN_PHONE["NES"]=="Y")?"<strong>*</strong>":"";?></th>
										<td>
											<?=$row[M_PHONE]?>
										</td>
									</tr>
							<?}?>
						<?}?>
						<!-- 전화번호 -->
						<!-- 팩스번호 -->
						<?if ($S_JOIN_FAX["USE"] == "Y" && $S_JOIN_FAX["JOIN"] == "Y"){?>
							<?if (!$S_JOIN_FAX["GRADE"] || in_array($strMemberJoinType,$S_JOIN_FAX["GRADE"])){?>
									<tr>
										<th><?=$LNG_TRANS_CHAR["MW00017"] //팩스번호?><?=($S_JOIN_FAX["NES"]=="Y")?"<strong>*</strong>":"";?></th>
										<td>
											<?=$row[M_FAX]?>
										</td>
									</tr>
							<?}?>
						<?}?>
						<!-- 팩스번호 -->
						<!-- 이메일 -->
						<?if ($S_JOIN_MAIL["USE"] == "Y" && $S_JOIN_MAIL["JOIN"] == "Y"){?>
							<?if (!$S_JOIN_MAIL["GRADE"] || in_array($strMemberJoinType,$S_JOIN_MAIL["GRADE"])){?>
									<tr>
										<th><?=$LNG_TRANS_CHAR["MW00010"] //이메일?><?=($S_JOIN_MAIL["NES"]=="Y")?"<strong>*</strong>":"";?> </th>
										<td>
											<?=$row[M_MAIL]?>
											<?if ($S_JOIN_MAILYN["USE"] == "Y" && $S_JOIN_MAILYN["JOIN"] == "Y"){?>
												<?if (!$S_JOIN_MAILYN["GRADE"] || in_array($strMemberJoinType,$S_JOIN_MAILYN["GRADE"])){?>
													<p><?=($row[M_MAILYN]=="Y")?$LNG_TRANS_CHAR["MS00008"].": YES":"";?> </p>
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
											<th><?=$LNG_TRANS_CHAR["MW00011"] //주소?><?=($S_JOIN_ADDR["NES"]=="Y")?"<strong>*</strong>":"";?> </th>
											<td>
												<?=$row[M_ZIP]?> <?=$row[M_ADDR]?> <?=$row[M_ADDR2]?>
											</td>
										</tr>
												<?}else{?>
										<tr>
											<th><?=$LNG_TRANS_CHAR["MW00021"] //국가?><?=($S_JOIN_ADDR["NES"]=="Y")?"<strong>*</strong>":"";?> </th>
											<td>
												<?=$aryCountryList[$row[M_COUNTRY]]?>
											</td>
										</tr>
										<tr>
											<th><?=$LNG_TRANS_CHAR["MW00011"] //주소?><?=($S_JOIN_ADDR["NES"]=="Y")?"<strong>*</strong>":"";?> </th>
											<td>
												<?=$row[M_ADDR1]?>
											</td>
										</tr>
										<tr>
											<th><?=$LNG_TRANS_CHAR["MW00013"] //상세주소?><?=($S_JOIN_ADDR["NES"]=="Y")?"<strong>*</strong>":"";?> </th>
											<td>
												<?=$row[M_ADDR2]?>
											</td>
										</tr>
										<tr>
											<th><?=$LNG_TRANS_CHAR["MW00022"] //도시?><?=($S_JOIN_ADDR["NES"]=="Y")?"<strong>*</strong>":"";?> </th>
											<td>
												<?=$row[M_CITY]?>
											</td>
										</tr>
										<tr>
											<th><?=$LNG_TRANS_CHAR["MW00023"] //주?> </th>
											<td>
												<?if ($row[M_COUNTRY] == "US") { echo $aryCountryState[$row[M_STATE]];}
												  else { echo $row[M_STATE];}
												?>
											</td>
										</tr>
										<tr>
											<th><?=$LNG_TRANS_CHAR["MW00014"] //우편번호?><?=($S_JOIN_ADDR["NES"]=="Y")?"<strong>*</strong>":"";?> </th>
											<td>
												<?=$row[M_ZIP]?>
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
									<th><?=$LNG_TRANS_CHAR["MW00017"] //사진?><?=($S_JOIN_PHOTO["NES"]=="Y")?"<strong>*</strong>":"";?></th>
									<td>
										<?=($row[M_PHOTO])?"<img src=\"../upload/member/".$row[M_PHOTO]."\" border=\"0\" style=\"width:100px;height:100px\"":"";?>
									</td>
								</tr>
							<?}?>
						<?}?>
						<!-- 사진 -->
						<!-- 추천인 -->
						<?if ($S_JOIN_REC["USE"] == "Y" && $S_JOIN_REC["JOIN"] == "Y"){?>
							<?if (!$S_JOIN_REC["GRADE"] || in_array($strMemberJoinType,$S_JOIN_REC["GRADE"])){?>
								<tr>
									<th><?=$LNG_TRANS_CHAR["MW00019"] //추천인?><?=($S_JOIN_REC["NES"]=="Y")?"<strong>*</strong>":"";?></th>
									<td>
										<?=$row[M_REC_NAME]?>
									</td>
								</tr>
							<?}?>
						<?}?>
						<!-- 추천인 -->
						<!-- 회사명 -->
						<?if ($S_JOIN_COM["USE"] == "Y" && $S_JOIN_COM["JOIN"] == "Y"){?>
							<?if (!$S_JOIN_COM["GRADE"] || in_array($strMemberJoinType,$S_JOIN_COM["GRADE"])){?>
								<tr>
									<th><?=$LNG_TRANS_CHAR["MW00020"] //회사명?><?=($S_JOIN_COM["NES"]=="Y")?"<strong>*</strong>":"";?></th>
									<td>
										<?=$row[M_COM_NM]?>
									</td>
								</tr>
							<?}?>
						<?}?>
						<!-- TM CODE -->
						<?if ($S_JOIN_TM_ID["USE"] == "Y" && $S_JOIN_TM_ID["JOIN"] == "Y"){?>
							<?if (!$S_JOIN_TM_ID["GRADE"] || in_array($strMemberJoinType,$S_JOIN_TM_ID["GRADE"])){?>
								<tr>
									<th>TM코드<?=($S_JOIN_TM_ID["NES"]=="Y")?"<strong>*</strong>":"";?></th>
									<td>
										<?=$row[M_TM_ID]?>
									</td>
								</tr>
							<?}?>
						<?}?>
						<!-- TM CODE -->
					</table>
				</div>
				<?if ($S_SITE_LNG == "KR"){?>
				<?if ($S_JOIN_BUSI_INFO["USE"] == "Y"){?>
				<?if ($row[M_BUSI_NM] != ""){?>
				<div class="titBox"><span class="barRed"></span><span class="tit">사업자정보</span></div>
				<div class="joinTableWrap">
					<table class="tableFormType">
						<!-- 상호명 -->
						<?if ($S_JOIN_BUSI_NM["USE"] == "Y" && $S_JOIN_BUSI_NM["JOIN"] == "Y"){?>
							<?if (!$S_JOIN_BUSI_NM["GRADE"] || in_array($strMemberJoinType,$S_JOIN_BUSI_NM["GRADE"])){?>
								<tr>
									<th><?=$LNG_TRANS_CHAR["MW00032"] //상호명?><?=($S_JOIN_BUSI_NM["NES"]=="Y")?"<strong>*</strong>":"";?></th>
									<td>
										<?=$row[M_BUSI_NM]?>
									</td>
								</tr>
							<?}?>
						<?}?>
						<!-- 상호명 -->
						<!-- 사업자번호 -->
						<?if ($S_JOIN_BUSI_NUM["USE"] == "Y" && $S_JOIN_BUSI_NUM["JOIN"] == "Y"){?>
							<?if (!$S_JOIN_BUSI_NUM["GRADE"] || in_array($strMemberJoinType,$S_JOIN_BUSI_NUM["GRADE"])){?>
								<tr>
									<th><?=$LNG_TRANS_CHAR["MW00033"] //사업자번호?><?=($S_JOIN_BUSI_NUM["NES"]=="Y")?"<strong>*</strong>":"";?></th>
									<td>
										<?=$row[M_BUSI_NUM]?>
									</td>
								</tr>
							<?}?>
						<?}?>
						<!-- 사업자번호 -->
						<!-- 업종 -->
						<?if ($S_JOIN_BUSI_UPJONG["USE"] == "Y" && $S_JOIN_BUSI_UPJONG["JOIN"] == "Y"){?>
							<?if (!$S_JOIN_BUSI_UPJONG["GRADE"] || in_array($strMemberJoinType,$S_JOIN_BUSI_UPJONG["GRADE"])){?>
								<tr>
									<th><?=$LNG_TRANS_CHAR["MW00034"] //업종?><?=($S_JOIN_BUSI_UPJONG["NES"]=="Y")?"<strong>*</strong>":"";?></th>
									<td><?=$row[M_BUSI_UPJ]?></td>
								</tr>
							<?}?>
						<?}?>
						<!-- 업종 -->
						<!-- 업태 -->
						<?if ($S_JOIN_BUSI_UPTAE["USE"] == "Y" && $S_JOIN_BUSI_UPTAE["JOIN"] == "Y"){?>
							<?if (!$S_JOIN_BUSI_UPTAE["GRADE"] || in_array($strMemberJoinType,$S_JOIN_BUSI_UPTAE["GRADE"])){?>
								<tr>
									<th><?=$LNG_TRANS_CHAR["MW00035"] //업태?><?=($S_JOIN_BUSI_UPTAE["NES"]=="Y")?"<strong>*</strong>":"";?></th>
									<td><?=$row[M_BUSI_UTE]?></td>
								</tr>
							<?}?>
						<?}?>
						<!-- 업태 -->
						<!-- 주소 -->
						<?if ($S_JOIN_BUSI_ADDR["USE"] == "Y" && $S_JOIN_BUSI_ADDR["JOIN"] == "Y"){?>
							<?if (!$S_JOIN_BUSI_ADDR["GRADE"] || in_array($strMemberJoinType,$S_JOIN_BUSI_ADDR["GRADE"])){?>
								<tr>
									<th><?=$LNG_TRANS_CHAR["MW00011"] //주소?><?=($S_JOIN_BUSI_ADDR["NES"]=="Y")?"<strong>*</strong>":"";?></th>
									<td>
										<?=$row[M_BUSI_ZIP]?> <?=$row[M_BUSI_ADDR]?> <?=$row[M_BUSI_ADDR2]?>
									</td>
								</tr>
							<?}?>
						<?}?>
						<!-- 주소 -->
					</table>
				</div>
				<?}?>
				<?}?>
				<?}?>
				<?if ($S_JOIN_ADD_WED["JOIN"] == "Y" || $S_JOIN_ADD_WED_DAY["JOIN"] == "Y" || $S_JOIN_ADD_CHILD["JOIN"] == "Y" || $S_JOIN_ADD_JOB["JOIN"] == "Y" || $S_JOIN_ADD_CONCERN["JOIN"] == "Y" || $S_JOIN_ADD_TEXT["JOIN"] == "Y"){?> 
				<div class="titBox"><span class="barRed"></span><span class="tit">추가정보</span></div>
				<div class="joinTableWrap">
					<table class="tableFormType">
						<!-- 결혼여부 -->
						<?if ($S_JOIN_ADD_WED["USE"] == "Y" && $S_JOIN_ADD_WED["JOIN"] == "Y"){?>
							<?if (!$S_JOIN_ADD_WED["GRADE"] || in_array($strMemberJoinType,$S_JOIN_ADD_WED["GRADE"])){?>
						<tr>
							<th><?=$LNG_TRANS_CHAR["MW00024"] //결혼여부?><?=($S_JOIN_ADD_WED["NES"]=="Y")?" <strong>*</strong>":"";?></th>
							<td>
								<?=($row[M_WED]=="Y")?$LNG_TRANS_CHAR["MW00031"]:$LNG_TRANS_CHAR["MW00030"];?>
							</td>
						</tr>
							<?}?>
						<?}?>
						<!-- 결혼여부 -->
						<!-- 결혼기념일 -->
						<?if ($S_JOIN_ADD_WED_DAY["USE"] == "Y" && $S_JOIN_ADD_WED_DAY["JOIN"] == "Y"){?>
							<?if (!$S_JOIN_ADD_WED_DAY["GRADE"] || in_array($strMemberJoinType,$S_JOIN_ADD_WED_DAY["GRADE"])){?>
						<tr>
							<th><?=$LNG_TRANS_CHAR["MW00025"] //결혼기념일?><?=($S_JOIN_ADD_WED_DAY["NES"]=="Y")?" <strong>*</strong>":"";?></th>
							<td>
								<?=$row[M_WED_DAY]?>
							</td>
						</tr>
							<?}?>
						<?}?>
						<!-- 결혼기념일 -->
						<!-- 자녀 -->
						<?if ($S_JOIN_ADD_CHILD["USE"] == "Y" && $S_JOIN_ADD_CHILD["JOIN"] == "Y"){?>
							<?if (!$S_JOIN_ADD_CHILD["GRADE"] || in_array($strMemberJoinType,$S_JOIN_ADD_CHILD["GRADE"])){?>
						<tr>
							<th><?=$LNG_TRANS_CHAR["MW00026"] //자녀수?><?=($S_JOIN_ADD_CHILD["NES"]=="Y")?" <strong>*</strong>":"";?></th>
							<td>
								<?=$row[M_CHILD]?>
							</td>
						</tr>
							<?}?>
						<?}?>
						<!-- 자녀 -->
						<!-- 직업 -->
						<?if ($S_JOIN_ADD_JOB["USE"] == "Y" && $S_JOIN_ADD_JOB["JOIN"] == "Y"){?>
							<?if (!$S_JOIN_ADD_JOB["GRADE"] || in_array($strMemberJoinType,$S_JOIN_ADD_JOB["GRADE"])){?>
						<tr>
							<th><?=$LNG_TRANS_CHAR["MW00027"] //직업?><?=($S_JOIN_ADD_JOB["NES"]=="Y")?" <strong>*</strong>":"";?></th>
							<td>
								<?=$aryJob[$row[M_JOB]]?>
							</td>
						</tr>
							<?}?>
						<?}?>
						<!-- 직업 -->
						<!-- 관심분야 -->
						<?if ($S_JOIN_ADD_CONCERN["USE"] == "Y" && $S_JOIN_ADD_CONCERN["JOIN"] == "Y"){?>
							<?if (!$S_JOIN_ADD_CONCERN["GRADE"] || in_array($strMemberJoinType,$S_JOIN_ADD_CONCERN["GRADE"])){?>
						<tr>
							<th><?=$LNG_TRANS_CHAR["MW00028"] //관심분야?><?=($S_JOIN_ADD_CONCERN["NES"]=="Y")?" <strong>*</strong>":"";?></th>
							<td>
								<?if ($S_JOIN_ADD_CONCERN["TYPE"] == "T"){?>
									<?=$row[M_CONCERN]?>
								<?}else{?>
									<?=$strConcern?>
								<?}?>
							</td>
						</tr>
							<?}?>
						<?}?>
						<!-- 관심분야 -->
						<!-- 남기는 말씀 -->
						<?if ($S_JOIN_ADD_TEXT["USE"] == "Y" && $S_JOIN_ADD_TEXT["JOIN"] == "Y"){?>
							<?if (!$S_JOIN_ADD_TEXT["GRADE"] || in_array($strMemberJoinType,$S_JOIN_ADD_TEXT["GRADE"])){?>
						<tr>
							<th><?=$LNG_TRANS_CHAR["MW00029"] //남기는 말씀?><?=($S_JOIN_ADD_TEXT["NES"]=="Y")?" <strong>*</strong>":"";?></th>
							<td><?=$row[M_TEXT]?></td>
						</tr>
							<?}?>
						<?}?>
						<!-- 남기는 말씀 -->

						<!--임시필드-->
						<?if ($S_JOIN_TMP_1["USE"] == "Y" && $S_JOIN_TMP_1["JOIN"] == "Y"){?>
							<?if (!$S_JOIN_TMP_1["GRADE"] || in_array($strMemberJoinType,$S_JOIN_TMP_1["GRADE"])){?>
						<tr>
							<th><?=$S_JOIN_TMP_1["NAME_".$S_SITE_LNG] //임시필드?><?=($S_JOIN_TMP_1["NES"]=="Y")?" <strong>*</strong>":"";?></th>
							<td>
								<?=$row[M_TMP1]?>
							</td>
						</tr>
							<?}?>
						<?}?>
						<?if ($S_JOIN_TMP_2["USE"] == "Y" && $S_JOIN_TMP_2["JOIN"] == "Y"){?>
							<?if (!$S_JOIN_TMP_2["GRADE"] || in_array($strMemberJoinType,$S_JOIN_TMP_2["GRADE"])){?>
						<tr>
							<th><?=$S_JOIN_TMP_2["NAME_".$S_SITE_LNG] //임시필드?><?=($S_JOIN_TMP_2["NES"]=="Y")?" <strong>*</strong>":"";?></th>
							<td>
								<?=$row[M_TMP2]?>
							</td>
						</tr>
							<?}?>
						<?}?>
						<?if ($S_JOIN_TMP_3["USE"] == "Y" && $S_JOIN_TMP_3["JOIN"] == "Y"){?>
							<?if (!$S_JOIN_TMP_3["GRADE"] || in_array($strMemberJoinType,$S_JOIN_TMP_3["GRADE"])){?>
						<tr>
							<th><?=$S_JOIN_TMP_4["NAME_".$S_SITE_LNG] //임시필드?><?=($S_JOIN_TMP_3["NES"]=="Y")?" <strong>*</strong>":"";?></th>
							<td>
								<?=$row[M_TMP3]?>
							</td>
						</tr>
							<?}?>
						<?}?>
						<?if ($S_JOIN_TMP_4["USE"] == "Y" && $S_JOIN_TMP_4["JOIN"] == "Y"){?>
							<?if (!$S_JOIN_TMP_4["GRADE"] || in_array($strMemberJoinType,$S_JOIN_TMP_4["GRADE"])){?>
						<tr>
							<th><?=$S_JOIN_TMP_4["NAME_".$S_SITE_LNG] //임시필드?><?=($S_JOIN_TMP_4["NES"]=="Y")?" <strong>*</strong>":"";?></th>
							<td>
								<?=$row[M_TMP4]?>
							</td>
						</tr>
							<?}?>
						<?}?>
						<?if ($S_JOIN_TMP_5["USE"] == "Y" && $S_JOIN_TMP_5["JOIN"] == "Y"){?>
							<?if (!$S_JOIN_TMP_5["GRADE"] || in_array($strMemberJoinType,$S_JOIN_TMP_5["GRADE"])){?>
						<tr>
							<th><?=$S_JOIN_TMP_5["NAME_".$S_SITE_LNG] //임시필드?><?=($S_JOIN_TMP_5["NES"]=="Y")?" <strong>*</strong>":"";?></th>
							<td>
								<?=$row[M_TMP5]?>
							</td>
						</tr>
							<?}?>
						<?}?>
						<!--임시필드-->
					</table>
				</div>
				<?}?>
					
		</div><!-- loginFormWrap -->
		<div class="joinBtnWrap btn2Box">
			<a href="./"  class="btn_gray"><?=$LNG_TRANS_CHAR["CW00001"] //확인?></a></a>
			<a href="./?menuType=member&mode=login" class="btn_red"><?=$LNG_TRANS_CHAR["CW00045"]//로그인?></a>			
		</div>