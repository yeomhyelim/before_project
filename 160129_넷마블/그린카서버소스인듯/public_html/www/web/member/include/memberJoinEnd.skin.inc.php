<?php
	## 기본 설정
	$strM_F_NAME = $row['M_F_NAME']; // 성(?)
	$strM_L_NAME = $row['M_L_NAME']; // 이름(?)

	## 이름 설정
	$strFullName = $strM_L_NAME;
	if($strM_F_NAME):
		if($strFullName) {$strFullName .= " "; }
		$strFullName .= $strM_F_NAME;
	endif;
	$strFullNameHtml = "<span class='fullName'>{$strFullName}</span>";



?>
		<div class="joinEndWrap mt20">
			<!-- (1) 기본정보 입력  -->
				<h4 class="titRegmemBasic"><span><?=$LNG_TRANS_CHAR["MW00046"] //회원기본 정보?></span></h4>
				<div class="regInfo">  <?=callLangTrans($LNG_TRANS_CHAR["MS00019"],array($strFullNameHtml))?> <!--<?=$row[M_NAME]?>님의 회원가입이 완료 되었습니다.//--></div>
				<div class="regWrap">
					<table>
						<colgroup>
							<col style="width:110px;"/>
							<col/>
						</colgroup>
						<!--아이디-->
						<?if ($S_MEM_CERITY == "1"){?>
							<?if ($S_JOIN_ID["USE"] == "Y" && $S_JOIN_ID["JOIN"] == "Y"){?>
								<?if (!$S_JOIN_ID["GRADE"] || in_array($strMemberJoinType,$S_JOIN_ID["GRADE"])){?>
						<tr>
							<th><?=($S_JOIN_ID["NES"]=="Y")?"<strong>*</strong>":"";?>  <?=$LNG_TRANS_CHAR["MW00001"] //아이디?></th>
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
							<th><?=($S_JOIN_NAME["NES"]=="Y")?"<strong>*</strong>":"";?> <?=$LNG_TRANS_CHAR["MW00004"] //이름?> </th>
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
							<th><?=($S_JOIN_NICKNAME["NES"]=="Y")?"<strong>*</strong>":"";?> <?=$LNG_TRANS_CHAR["MW00004"] //닉네임?></th>
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
							<th><?=($S_JOIN_BIRTH["NES"]=="Y")?"<strong>*</strong>":"";?> <?=$LNG_TRANS_CHAR["MW00006"] //생년월일?></th>
							<td>
								<?=SUBSTR($row[M_BIRTH],0,4)?>.<?=SUBSTR($row[M_BIRTH],5,2)?>.<?=SUBSTR($row[M_BIRTH],8)?>
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
							<th><?=($S_JOIN_SEX["NES"]=="Y")?"<strong>*</strong>":"";?> <?=$LNG_TRANS_CHAR["MW00007"] //성별?></th>
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
							<th><?=($S_JOIN_HP["NES"]=="Y")?"<strong>*</strong>":"";?> <?=$LNG_TRANS_CHAR["MW00008"] //핸드폰?> </th>
							<td>
								<?=$row[M_HP]?>
								
								<?if ($S_JOIN_SMSYN["USE"] == "Y" && $S_JOIN_SMSYN["JOIN"] == "Y"){?>
									<?if (!$S_JOIN_SMSYN["GRADE"] || in_array($strMemberJoinType,$S_JOIN_SMSYN["GRADE"])){?>
									<!--	<span><?=($row[M_SMSYN]=="Y")?$LNG_TRANS_CHAR["MW00057"]:"";?> </span>  -->
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
							<th><?=($S_JOIN_PHONE["NES"]=="Y")?"<strong>*</strong>":"";?> <?=$LNG_TRANS_CHAR["MW00009"] //전화번호?></th>
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
							<th><?=($S_JOIN_FAX["NES"]=="Y")?"<strong>*</strong>":"";?> <?=$LNG_TRANS_CHAR["MW00017"] //팩스번호?></th>
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
							<th><?=($S_JOIN_MAIL["NES"]=="Y")?"<strong>*</strong>":"";?> <?=$LNG_TRANS_CHAR["MW00010"] //이메일?> </th>
							<td>
								<?=$row[M_MAIL]?>
								<?if ($S_JOIN_MAILYN["USE"] == "Y" && $S_JOIN_MAILYN["JOIN"] == "Y"){?>
									<?if (!$S_JOIN_MAILYN["GRADE"] || in_array($strMemberJoinType,$S_JOIN_MAILYN["GRADE"])){?>
									<!--	<span><?=($row[M_MAILYN]=="Y")?$LNG_TRANS_CHAR["MW00058"]:"";?> </span>	-->
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
							<th><?=($S_JOIN_ADDR["NES"]=="Y")?"<strong>*</strong>":"";?> <?=$LNG_TRANS_CHAR["MW00011"] //주소?> </th>
							<td>
								<?=$row[M_ZIP]?> <?=$row[M_ADDR]?> <?=$row[M_ADDR2]?>
							</td>
						</tr>
								<?}else{?>
						<tr>
							<th><?=($S_JOIN_ADDR["NES"]=="Y")?"<strong>*</strong>":"";?> <?=$LNG_TRANS_CHAR["MW00021"] //국가?> </th>
							<td>
								<?=$aryCountryList[$row[M_COUNTRY]]?>
							</td>
						</tr>
						<tr>
							<th><?=($S_JOIN_ADDR["NES"]=="Y")?"<strong>*</strong>":"";?> <?=$LNG_TRANS_CHAR["MW00011"] //주소?> </th>
							<td>
								<?=$row[M_ADDR]?>
							</td>
						</tr>
						<tr>
							<th><?=($S_JOIN_ADDR["NES"]=="Y")?"<strong>*</strong>":"";?> <?=$LNG_TRANS_CHAR["MW00013"] //상세주소?> </th>
							<td>
								<?=$row[M_ADDR2]?>
							</td>
						</tr>
						<tr>
							<th><?=($S_JOIN_ADDR["NES"]=="Y")?"<strong>*</strong>":"";?> <?=$LNG_TRANS_CHAR["MW00022"] //도시?> </th>
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
							<th><?=($S_JOIN_ADDR["NES"]=="Y")?"<strong>*</strong>":"";?> <?=$LNG_TRANS_CHAR["MW00014"] //우편번호?> </th>
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
							<th><?=($S_JOIN_PHOTO["NES"]=="Y")?"<strong>*</strong>":"";?> <?=$LNG_TRANS_CHAR["MW00017"] //사진?></th>
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
							<th><strong></strong><?=$LNG_TRANS_CHAR["MW00019"] //추천인?></th>
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
							<th><?=($S_JOIN_COM["NES"]=="Y")?"<strong>*</strong>":"";?> <?=$LNG_TRANS_CHAR["MW00020"] //회사명?></th>
							<td>
								<?=$row[M_COM_NM]?>
							</td>
						</tr>
							<?}?>
						<?}?>
						<!-- 회사명 -->
						<!-- TM CODE -->
						<?if ($S_JOIN_TM_ID["USE"] == "Y" && $S_JOIN_TM_ID["JOIN"] == "Y"){?>
							<?if (!$S_JOIN_TM_ID["GRADE"] || in_array($strMemberJoinType,$S_JOIN_TM_ID["GRADE"])){?>
						<tr>
							<th><?=($S_JOIN_TM_ID["NES"]=="Y")?"<strong>*</strong>":"";?> TM코드</th>
							<td>
								<?=$row[M_TM_ID]?>
							</td>
						</tr>
							<?}?>
						<?}?>
						<!-- TM CODE -->
					</table>
				</div>
				<?if ($S_JOIN_BUSI_INFO["USE"] == "Y"){?>
				<h4 class="mt40"><?=$LNG_TRANS_CHAR["MW00049"] //사업자 정보?></h4>
				<div class="regWrap">
					<table>
						<colgroup>
							<col style="width:110px;"/>
							<col/>
						</colgroup>
						<!-- 상호명 -->
						<?if ($S_JOIN_BUSI_NM["USE"] == "Y" && $S_JOIN_BUSI_NM["JOIN"] == "Y"){?>
							<?if (!$S_JOIN_BUSI_NM["GRADE"] || in_array($strMemberJoinType,$S_JOIN_BUSI_NM["GRADE"])){?>
						<tr>
							<th><?=($S_JOIN_BUSI_NM["NES"]=="Y")?"<strong>*</strong>":"";?> <?=$LNG_TRANS_CHAR["MW00032"] //상호명?></th>
							<td>
								<?=$row['M_BUSI_NM']?>
							</td>
						</tr>
							<?}?>
						<?}?>
						<!-- 상호명 -->
						<!-- 사업자번호 -->
						<?if ($S_JOIN_BUSI_NUM["USE"] == "Y" && $S_JOIN_BUSI_NUM["JOIN"] == "Y"){?>
							<?if (!$S_JOIN_BUSI_NUM["GRADE"] || in_array($strMemberJoinType,$S_JOIN_BUSI_NUM["GRADE"])){?>
						<tr>
							<th><?=($S_JOIN_BUSI_NUM["NES"]=="Y")?"<strong>*</strong>":"";?> <?=$LNG_TRANS_CHAR["MW00033"] //사업자번호?></th>
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
							<th><?=($S_JOIN_BUSI_UPJONG["NES"]=="Y")?"<strong>*</strong>":"";?> <?=$LNG_TRANS_CHAR["MW00034"] //업종?></th>
							<td><?=$row[M_BUSI_UPJ]?></td>
						</tr>
							<?}?>
						<?}?>
						<!-- 업종 -->
						<!-- 업태 -->
						<?if ($S_JOIN_BUSI_UPTAE["USE"] == "Y" && $S_JOIN_BUSI_UPTAE["JOIN"] == "Y"){?>
							<?if (!$S_JOIN_BUSI_UPTAE["GRADE"] || in_array($strMemberJoinType,$S_JOIN_BUSI_UPTAE["GRADE"])){?>
						<tr>
							<th><?=($S_JOIN_BUSI_UPTAE["NES"]=="Y")?"<strong>*</strong>":"";?> <?=$LNG_TRANS_CHAR["MW00035"] //업태?></th>
							<td><?=$row[M_BUSI_UTE]?></td>
						</tr>
							<?}?>
						<?}?>
						<!-- 업태 -->
						<!-- 주소 -->
						<?if ($S_JOIN_BUSI_ADDR["USE"] == "Y" && $S_JOIN_BUSI_ADDR["JOIN"] == "Y"){?>
							<?if (!$S_JOIN_BUSI_ADDR["GRADE"] || in_array($strMemberJoinType,$S_JOIN_BUSI_ADDR["GRADE"])){?>
						<tr>
							<th><?=($S_JOIN_BUSI_ADDR["NES"]=="Y")?"<strong>*</strong>":"";?> <?=$LNG_TRANS_CHAR["MW00011"] //주소?></th>
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
				<?if ($S_JOIN_ADD_WED["JOIN"] == "Y" || $S_JOIN_ADD_WED_DAY["JOIN"] == "Y" || $S_JOIN_ADD_CHILD["JOIN"] == "Y" || $S_JOIN_ADD_JOB["JOIN"] == "Y" || $S_JOIN_ADD_CONCERN["JOIN"] == "Y" || $S_JOIN_ADD_TEXT["JOIN"] == "Y"){?> 
				<h4 class="mt40"><?=$LNG_TRANS_CHAR["MW00047"] //추가 정보?></h4>
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
							<th><?=($S_JOIN_ADD_WED["NES"]=="Y")?"<strong>*</strong>":"";?> <?=$LNG_TRANS_CHAR["MW00024"] //결혼여부?></th>
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
							<th><?=($S_JOIN_ADD_WED_DAY["NES"]=="Y")?"<strong>*</strong>":"";?> <?=$LNG_TRANS_CHAR["MW00025"] //결혼기념일?></th>
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
							<th><?=($S_JOIN_ADD_CHILD["NES"]=="Y")?"<strong>*</strong>":"";?> <?=$LNG_TRANS_CHAR["MW00026"] //자녀수?></th>
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
							<th><?=($S_JOIN_ADD_JOB["NES"]=="Y")?"<strong>*</strong>":"";?> <?=$LNG_TRANS_CHAR["MW00027"] //직업?></th>
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
							<th><?=($S_JOIN_ADD_CONCERN["NES"]=="Y")?"<strong>*</strong>":"";?> <?=$LNG_TRANS_CHAR["MW00028"] //관심분야?></th>
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
							<th><?=($S_JOIN_ADD_TEXT["NES"]=="Y")?"<strong>*</strong>":"";?> <?=$LNG_TRANS_CHAR["MW00029"] //남기는 말씀?></th>
							<td><?=$row[M_TEXT]?></td>
						</tr>
							<?}?>
						<?}?>
						<!-- 남기는 말씀 -->

						<!--임시필드-->
						<?if ($S_JOIN_TMP_1["USE"] == "Y" && $S_JOIN_TMP_1["JOIN"] == "Y"){?>
							<?if (!$S_JOIN_TMP_1["GRADE"] || in_array($strMemberJoinType,$S_JOIN_TMP_1["GRADE"])){?>
						<tr>
							<th><?=($S_JOIN_TMP_1["NES"]=="Y")?"<strong>*</strong>":"";?> <?=$S_JOIN_TMP_1["NAME_".$S_SITE_LNG] //임시필드?></th>
							<td>
								<?=$row[M_TMP1]?>
							</td>
						</tr>
							<?}?>
						<?}?>
						<?if ($S_JOIN_TMP_2["USE"] == "Y" && $S_JOIN_TMP_2["JOIN"] == "Y"){?>
							<?if (!$S_JOIN_TMP_2["GRADE"] || in_array($strMemberJoinType,$S_JOIN_TMP_2["GRADE"])){?>
						<tr>
							<th><?=($S_JOIN_TMP_2["NES"]=="Y")?"<strong>*</strong>":"";?> <?=$S_JOIN_TMP_2["NAME_".$S_SITE_LNG] //임시필드?></th>
							<td>
								<?=$row[M_TMP2]?>
							</td>
						</tr>
							<?}?>
						<?}?>
						<?if ($S_JOIN_TMP_3["USE"] == "Y" && $S_JOIN_TMP_3["JOIN"] == "Y"){?>
							<?if (!$S_JOIN_TMP_3["GRADE"] || in_array($strMemberJoinType,$S_JOIN_TMP_3["GRADE"])){?>
						<tr>
							<th><?=($S_JOIN_TMP_3["NES"]=="Y")?"<strong>*</strong>":"";?> <?=$S_JOIN_TMP_4["NAME_".$S_SITE_LNG] //임시필드?></th>
							<td>
								<?=$row[M_TMP3]?>
							</td>
						</tr>
							<?}?>
						<?}?>
						<?if ($S_JOIN_TMP_4["USE"] == "Y" && $S_JOIN_TMP_4["JOIN"] == "Y"){?>
							<?if (!$S_JOIN_TMP_4["GRADE"] || in_array($strMemberJoinType,$S_JOIN_TMP_4["GRADE"])){?>
						<tr>
							<th><?=($S_JOIN_TMP_4["NES"]=="Y")?"<strong>*</strong>":"";?> <?=$S_JOIN_TMP_4["NAME_".$S_SITE_LNG] //임시필드?></th>
							<td>
								<?=$row[M_TMP4]?>
							</td>
						</tr>
							<?}?>
						<?}?>
						<?if ($S_JOIN_TMP_5["USE"] == "Y" && $S_JOIN_TMP_5["JOIN"] == "Y"){?>
							<?if (!$S_JOIN_TMP_5["GRADE"] || in_array($strMemberJoinType,$S_JOIN_TMP_5["GRADE"])){?>
						<tr>
							<th><?=($S_JOIN_TMP_5["NES"]=="Y")?"<strong>*</strong>":"";?> <?=$S_JOIN_TMP_5["NAME_".$S_SITE_LNG] //임시필드?></th>
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
