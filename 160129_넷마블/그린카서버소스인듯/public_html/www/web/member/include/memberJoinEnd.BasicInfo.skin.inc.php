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
							<th><?=($S_JOIN_SEX["NES"]=="Y")?"<strong>*</strong>":"";?><?=$LNG_TRANS_CHAR["MW00007"] //성별?></th>
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
										<span><?=($row[M_SMSYN]=="Y")?$LNG_TRANS_CHAR["MS00007"]:"";?> </span>
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
										<span><?=($row[M_MAILYN]=="Y")?$LNG_TRANS_CHAR["MS00008"]:"";?> </span>
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
								<?=$row[M_ADDR1]?>
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
							<th><?=($S_JOIN_REC["NES"]=="Y")?"<strong>*</strong>":"";?> <?=$LNG_TRANS_CHAR["MW00019"] //추천인?></th>
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
					</table>