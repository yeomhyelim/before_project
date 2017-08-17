<input type="hidden" name="searchStatus" value="<?=$strSearchStatus?>" />
<div id="contentArea">
	<div class="contentTop">
		<h2><?=$LNG_TRANS_CHAR["BW00078"] //부관리자 관리?></h2>
		<div class="clr"></div>
	</div>
	<br>
	<!-- ******** 컨텐츠 ********* -->

	<div class="tableForm">
		<table>
			<tr>
				<th><?=$LNG_TRANS_CHAR["CW00024"] //ID?></th>
				<td><?=($S_MEM_CERITY=="1")?$row[M_ID]:$row[M_MAIL];?>
					<!-- input type="text" class="inbox _w200" name="m_id" id="m_id" readonly value="<?=($S_MEM_CERITY=="1")?$row[M_ID]:$row[M_MAIL];?>"/ //-->
					<!-- a class="btn_sml" href="javascript:goAdminFind();"><strong>검색</strong></a>
					<span class="infoTxt">* 일반회원 가입먼저 진행 후 관리자로 전환 합니다..</span -->
				</td>
			</tr>
			<tr>
				<th><?=$LNG_TRANS_CHAR["CW00023"] //이름?></th>
				<td><!-- input type="input" name="m_u_name" id="m_u_name" class="inbox _w200" maxlength="50" readonly value="<?=$row[M_NAME]?>"/ //-->
					<?=$row[M_NAME]?></td>
			</tr>
			<tr>
				<th><?=$LNG_TRANS_CHAR["CW00025"] //연락처?></th>
				<td><!-- input type="input" name="m_phone" id="m_phone"  class="inbox _w200" maxlength="50" readonly value="<?=$row[M_PHONE]?>"/ //-->
					<?=$row[M_PHONE]?>
				</td>
			</tr>
			<tr>
				<th><?=$LNG_TRANS_CHAR["CW00029"] //메모?></th>
				<td><textarea name="a_memo" id="a_memo" class="inbox _w200"><?=$row[A_MEMO]?></textarea></td>
			</tr>
			<tr>
				<th><?=$LNG_TRANS_CHAR["BW00089"] //영업사원?></th>
				<td><input type="checkbox" name="a_tm" id="a_tm" value="Y" <?=($row[A_TM_YN]=="Y")?"checked":"";?>>
					<?if($ADMIN_SHOP_SELECT_USE == "Y"):?>
						<div id="shopSelectForm" style="<?if($row['A_TM_YN']!="Y"){ echo "display:none;"; }?>">
							<a href="javascript:goShopSelectWriteMove()" class="btn_sml"><strong>관리 입점몰 선택</strong></a>
							<input type="hidden" name="a_shop_list" id="selectList" value="<?=$row['A_SHOP_LIST']?>">
						</div>
					<?endif;?>
				</td>
			</tr>
		</table>
	</div><!-- tablForm -->
	<div class="tableList">
		<h3 class="mt30">authorize1</h3>
		<table>
			<tr>
				<th rowspan="2" class="lowTh">Depth 1</th>
				<th rowspan="2" class="lowTh">Depth 2</th>
				<th rowspan="2" class="lowTh">Depth 3</th>
				<th rowspan="2" class="lowTh"><?=$LNG_TRANS_CHAR["BW00080"] //권한부여?></th>
				<th colspan="13" style="border-bottom:1px solid #e5e5e5;color:#FFF;"><?=$LNG_TRANS_CHAR["BW00081"] //Authority?></th>
			</tr>
			<tr>
				<th><?=$LNG_TRANS_CHAR["CW00002"] //등록?></th>
				<th><?=$LNG_TRANS_CHAR["CW00003"] //수정?></th>
				<th><?=$LNG_TRANS_CHAR["CW00004"] //삭제?></th>
				<th><?=$LNG_TRANS_CHAR["CW00030"] //엑셀?></th>
				<th><?=$LNG_TRANS_CHAR["CW00031"] //정산?></th>
				<th><?=$LNG_TRANS_CHAR["CW00032"] //SMS?></th>
				<th><?=$LNG_TRANS_CHAR["CW00033"] //Upload?></th>
				<th><?=$LNG_TRANS_CHAR["CW00034"] //Point?></th>
				<th><?=$LNG_TRANS_CHAR["CW00035"] //기타1?></th>
				<th><?=$LNG_TRANS_CHAR["CW00036"] //기타2?></th>
				<th><?=$LNG_TRANS_CHAR["CW00037"] //기타3?></th>
				<th><?=$LNG_TRANS_CHAR["CW00038"] //기타4?></th>
				<th><?=$LNG_TRANS_CHAR["CW00039"] //기타5?></th>
			</tr>
			<?			
				for ($i=0;$i<sizeof($xml->ITEM);$i++){
					
					$intMN_NO		= $xml->ITEM[$i]->MN_NO;
					$intMN_LEVEL	= $xml->ITEM[$i]->MN_LEVEL;

					$strMenuNameKR	= $xml->ITEM[$i]->MN_NAME_KR;
					$strMenuNameUS	= $xml->ITEM[$i]->MN_NAME_US;
					$strMenuNameCN	= $xml->ITEM[$i]->MN_NAME_CN;
					$strMenuNameJP	= $xml->ITEM[$i]->MN_NAME_JP;
					$strMenuNameID	= $xml->ITEM[$i]->MN_NAME_ID;
					$strMenuNameFR	= $xml->ITEM[$i]->MN_NAME_FR;
					
					$strMN_AUTH_L	= $xml->ITEM[$i]->MN_AUTH_L;
					$strMN_AUTH_W	= $xml->ITEM[$i]->MN_AUTH_W;
					$strMN_AUTH_M	= $xml->ITEM[$i]->MN_AUTH_M;
					$strMN_AUTH_D	= $xml->ITEM[$i]->MN_AUTH_D;
					$strMN_AUTH_E	= $xml->ITEM[$i]->MN_AUTH_E;
					$strMN_AUTH_C	= $xml->ITEM[$i]->MN_AUTH_C;
					$strMN_AUTH_S	= $xml->ITEM[$i]->MN_AUTH_S;
					$strMN_AUTH_U	= $xml->ITEM[$i]->MN_AUTH_U;
					$strMN_AUTH_P	= $xml->ITEM[$i]->MN_AUTH_P;
					$strMN_AUTH_E1	= $xml->ITEM[$i]->MN_AUTH_E1;
					$strMN_AUTH_E2	= $xml->ITEM[$i]->MN_AUTH_E2;
					$strMN_AUTH_E3	= $xml->ITEM[$i]->MN_AUTH_E3;
					$strMN_AUTH_E4	= $xml->ITEM[$i]->MN_AUTH_E4;
					$strMN_AUTH_E5	= $xml->ITEM[$i]->MN_AUTH_E5;
					
					if ($intMN_NO == 6) continue; //->커뮤니티 관리제외

					for($j=1;$j<=3;$j++){
						if ($intMN_LEVEL == $j) {
							${"strMenuName_".$j}	= "<strong>".${"strMenuName".$strAdmSiteLng}."</strong>";
							${"strMenuStyle_".$j}	= "style=\"text-align:left;\"";
						} else {
							${"strMenuName_".$j}	= "";
							${"strMenuStyle_".$j}	= "";
						}
					}

			?>
			<tr>
				<td <?=$strMenuStyle_1?>><?=$strMenuName_1?></td>
				<td <?=$strMenuStyle_2?>><?=$strMenuName_2?></td>
				<td <?=$strMenuStyle_3?>><?=$strMenuName_3?></td>
				<td>
					<input type="checkbox" name="mn_no[]" id="mn_no[]" value="<?=$intMN_NO?>" onclick="javascript:setMenuUse(this,<?=$intMN_LEVEL?>);" <?=($intMN_NO == $memberAuthRow["$intMN_NO"][MN_NO])?"checked":"";?>>
				</td>
				<td>
					<input type="checkbox" name="mn_auth_w_<?=$intMN_NO?>" id="mn_auth_w_<?=$intMN_NO?>" value="Y" <?=($strMN_AUTH_W=="Y")?"":"disabled";?> <?=($memberAuthRow["$intMN_NO"][AM_W]=="Y")?"checked":"";?>>
				</td>
				<td>
					<input type="checkbox" name="mn_auth_m_<?=$intMN_NO?>" id="mn_auth_m_<?=$intMN_NO?>" value="Y" <?=($strMN_AUTH_M=="Y")?"":"disabled";?>
					<?=($memberAuthRow["$intMN_NO"][AM_M]=="Y")?"checked":"";?>>
				</td>
				<td>
					<input type="checkbox" name="mn_auth_d_<?=$intMN_NO?>" id="mn_auth_d_<?=$intMN_NO?>" value="Y" <?=($strMN_AUTH_D=="Y")?"":"disabled";?>
					<?=($memberAuthRow["$intMN_NO"][AM_D]=="Y")?"checked":"";?>>
				</td>
				<td>
					<input type="checkbox" name="mn_auth_e_<?=$intMN_NO?>" id="mn_auth_e_<?=$intMN_NO?>" value="Y" <?=($strMN_AUTH_E=="Y")?"":"disabled";?>
					<?=($memberAuthRow["$intMN_NO"][AM_E]=="Y")?"checked":"";?>>
				</td>
				<td>
					<input type="checkbox" name="mn_auth_c_<?=$intMN_NO?>" id="mn_auth_c_<?=$intMN_NO?>" value="Y" <?=($strMN_AUTH_C=="Y")?"":"disabled";?>
					<?=($memberAuthRow["$intMN_NO"][AM_C]=="Y")?"checked":"";?>>
				</td>
				<td>
					<input type="checkbox" name="mn_auth_s_<?=$intMN_NO?>" id="mn_auth_s_<?=$intMN_NO?>" value="Y" <?=($strMN_AUTH_S=="Y")?"":"disabled";?>
					<?=($memberAuthRow["$intMN_NO"][AM_S]=="Y")?"checked":"";?>>
				</td>
				<td>
					<input type="checkbox" name="mn_auth_u_<?=$intMN_NO?>" id="mn_auth_u_<?=$intMN_NO?>" value="Y" <?=($strMN_AUTH_U=="Y")?"":"disabled";?>
					<?=($memberAuthRow["$intMN_NO"][AM_U]=="Y")?"checked":"";?>>
				</td>
				<td>
					<input type="checkbox" name="mn_auth_p_<?=$intMN_NO?>" id="mn_auth_p_<?=$intMN_NO?>" value="Y" <?=($strMN_AUTH_P=="Y")?"":"disabled";?>
					<?=($memberAuthRow["$intMN_NO"][AM_P]=="Y")?"checked":"";?>>
				</td>
				<td>
					<input type="checkbox" name="mn_auth_e1_<?=$intMN_NO?>" id="mn_auth_e1_<?=$intMN_NO?>" value="Y" <?=($strMN_AUTH_E1=="Y")?"":"disabled";?>
					<?=($memberAuthRow["$intMN_NO"][AM_E1]=="Y")?"checked":"";?>>
				</td>
				<td>
					<input type="checkbox" name="mn_auth_e2_<?=$intMN_NO?>" id="mn_auth_e2_<?=$intMN_NO?>" value="Y" <?=($strMN_AUTH_E2=="Y")?"":"disabled";?>
					<?=($memberAuthRow["$intMN_NO"][AM_E2]=="Y")?"checked":"";?>>
				</td>
				<td>
					<input type="checkbox" name="mn_auth_e3_<?=$intMN_NO?>" id="mn_auth_e3_<?=$intMN_NO?>" value="Y" <?=($strMN_AUTH_E3=="Y")?"":"disabled";?>
					<?=($memberAuthRow["$intMN_NO"][AM_E3]=="Y")?"checked":"";?>>
				</td>
				<td>
					<input type="checkbox" name="mn_auth_e4_<?=$intMN_NO?>" id="mn_auth_e4_<?=$intMN_NO?>" value="Y" <?=($strMN_AUTH_E4=="Y")?"":"disabled";?>
					<?=($memberAuthRow["$intMN_NO"][AM_E4]=="Y")?"checked":"";?>>
				</td>
				<td>
					<input type="checkbox" name="mn_auth_e5_<?=$intMN_NO?>" id="mn_auth_e5_<?=$intMN_NO?>" value="Y" <?=($strMN_AUTH_E5=="Y")?"":"disabled";?>
					<?=($memberAuthRow["$intMN_NO"][AM_E5]=="Y")?"checked":"";?>>
				</td>
			</tr>
			<?}?>					
			<?			
				if (is_array($aryCommunityList)){
					for($i=0;$i<sizeof($aryCommunityList);$i++){

						$intMN_LEVEL	= $aryCommunityList[$i][MN_LEVEL];
						$intMN_NO		= $aryCommunityList[$i][MN_NO];
						
						if ($intMN_LEVEL == 2) {
							$intMN_NO		= 6000 + $aryCommunityList[$i][MN_NO];
						} else if ($intMN_LEVEL == 3) {
							$intMN_NO		= 5000 + (int)$aryCommunityList[$i][MN_NO];
						}
						
						$strMenuNameKR	= $aryCommunityList[$i][MN_NAME_KR];
						$strMenuNameUS	= $aryCommunityList[$i][MN_NAME_US];
						$strMenuNameCN	= $aryCommunityList[$i][MN_NAME_CN];
						$strMenuNameJP	= $aryCommunityList[$i][MN_NAME_JP];
						$strMenuNameID	= $aryCommunityList[$i][MN_NAME_ID];
						$strMenuNameFR	= $aryCommunityList[$i][MN_NAME_FR];
						
						$strMN_AUTH_L	= $aryCommunityList[$i][MN_AUTH_L];
						$strMN_AUTH_W	= $aryCommunityList[$i][MN_AUTH_W];
						$strMN_AUTH_M	= $aryCommunityList[$i][MN_AUTH_M];
						$strMN_AUTH_D	= $aryCommunityList[$i][MN_AUTH_D];
						$strMN_AUTH_E	= $aryCommunityList[$i][MN_AUTH_E];
						$strMN_AUTH_C	= $aryCommunityList[$i][MN_AUTH_C];
						$strMN_AUTH_S	= $aryCommunityList[$i][MN_AUTH_S];
						$strMN_AUTH_U	= $aryCommunityList[$i][MN_AUTH_U];
						$strMN_AUTH_P	= $aryCommunityList[$i][MN_AUTH_P];
						$strMN_AUTH_E1	= $aryCommunityList[$i][MN_AUTH_E1];
						$strMN_AUTH_E2	= $aryCommunityList[$i][MN_AUTH_E2];
						$strMN_AUTH_E3	= $aryCommunityList[$i][MN_AUTH_E3];
						$strMN_AUTH_E4	= $aryCommunityList[$i][MN_AUTH_E4];
						$strMN_AUTH_E5	= $aryCommunityList[$i][MN_AUTH_E5];
						
						for($j=1;$j<=3;$j++){
							if ($intMN_LEVEL == $j) {
								${"strMenuName_".$j}	= "<strong>".${"strMenuName".$strAdmSiteLng}."</strong>";
								${"strMenuStyle_".$j}	= "style=\"text-align:left;\"";
							} else {
								${"strMenuName_".$j}	= "";
								${"strMenuStyle_".$j}	= "";
							}
						}

						?>
				<tr>
					<td style="text-align:left;"><?=$strMenuName_1?></td>
					<td style="text-align:left;"><?=$strMenuName_2?></td>
					<td style="text-align:left;"><?=$strMenuName_3?></td>
					<td>
						<input type="checkbox" name="mn_no[]" id="mn_no[]" value="<?=$intMN_NO?>" onclick="javascript:setMenuUse(this,<?=$intMN_LEVEL?>);" <?=($intMN_NO == $memberAuthRow["$intMN_NO"][MN_NO])?"checked":"";?>>
					</td>
					<td>
						<input type="checkbox" name="mn_auth_w_<?=$intMN_NO?>" id="mn_auth_w_<?=$intMN_NO?>" value="Y" <?=($strMN_AUTH_W=="Y")?"":"disabled";?> <?=($memberAuthRow["$intMN_NO"][AM_W]=="Y")?"checked":"";?>>
					</td>
					<td>
						<input type="checkbox" name="mn_auth_m_<?=$intMN_NO?>" id="mn_auth_m_<?=$intMN_NO?>" value="Y" <?=($strMN_AUTH_M=="Y")?"":"disabled";?> <?=($memberAuthRow["$intMN_NO"][AM_M]=="Y")?"checked":"";?>>
					</td>
					<td>
						<input type="checkbox" name="mn_auth_d_<?=$intMN_NO?>" id="mn_auth_d_<?=$intMN_NO?>" value="Y" <?=($strMN_AUTH_D=="Y")?"":"disabled";?> <?=($memberAuthRow["$intMN_NO"][AM_D]=="Y")?"checked":"";?>>
					</td>
					<td>
						<input type="checkbox" name="mn_auth_e_<?=$intMN_NO?>" id="mn_auth_e_<?=$intMN_NO?>" value="Y" <?=($strMN_AUTH_E=="Y")?"":"disabled";?> <?=($memberAuthRow["$intMN_NO"][AM_E]=="Y")?"checked":"";?>>
					</td>
					<td>
						<input type="checkbox" name="mn_auth_c_<?=$intMN_NO?>" id="mn_auth_c_<?=$intMN_NO?>" value="Y" <?=($strMN_AUTH_C=="Y")?"":"disabled";?> <?=($memberAuthRow["$intMN_NO"][AM_C]=="Y")?"checked":"";?>>
					</td>
					<td>
						<input type="checkbox" name="mn_auth_s_<?=$intMN_NO?>" id="mn_auth_s_<?=$intMN_NO?>" value="Y" <?=($strMN_AUTH_S=="Y")?"":"disabled";?> <?=($memberAuthRow["$intMN_NO"][AM_S]=="Y")?"checked":"";?>>
					</td>
					<td>
						<input type="checkbox" name="mn_auth_u_<?=$intMN_NO?>" id="mn_auth_u_<?=$intMN_NO?>" value="Y" <?=($strMN_AUTH_U=="Y")?"":"disabled";?> <?=($memberAuthRow["$intMN_NO"][AM_U]=="Y")?"checked":"";?>>
					</td>
					<td>
						<input type="checkbox" name="mn_auth_p_<?=$intMN_NO?>" id="mn_auth_p_<?=$intMN_NO?>" value="Y" <?=($strMN_AUTH_P=="Y")?"":"disabled";?> <?=($memberAuthRow["$intMN_NO"][AM_P]=="Y")?"checked":"";?>>
					</td>
					<td>
						<input type="checkbox" name="mn_auth_e1_<?=$intMN_NO?>" id="mn_auth_e1_<?=$intMN_NO?>" value="Y" <?=($strMN_AUTH_E1=="Y")?"":"disabled";?> <?=($memberAuthRow["$intMN_NO"][AM_E1]=="Y")?"checked":"";?>>
					</td>
					<td>
						<input type="checkbox" name="mn_auth_e2_<?=$intMN_NO?>" id="mn_auth_e2_<?=$intMN_NO?>" value="Y" <?=($strMN_AUTH_E2=="Y")?"":"disabled";?> <?=($memberAuthRow["$intMN_NO"][AM_E2]=="Y")?"checked":"";?>>
					</td>
					<td>
						<input type="checkbox" name="mn_auth_e3_<?=$intMN_NO?>" id="mn_auth_e3_<?=$intMN_NO?>" value="Y" <?=($strMN_AUTH_E3=="Y")?"":"disabled";?> <?=($memberAuthRow["$intMN_NO"][AM_E3]=="Y")?"checked":"";?>>
					</td>
					<td>
						<input type="checkbox" name="mn_auth_e4_<?=$intMN_NO?>" id="mn_auth_e4_<?=$intMN_NO?>" value="Y" <?=($strMN_AUTH_E4=="Y")?"":"disabled";?> <?=($memberAuthRow["$intMN_NO"][AM_E4]=="Y")?"checked":"";?>>
					</td>
					<td>
						<input type="checkbox" name="mn_auth_e5_<?=$intMN_NO?>" id="mn_auth_e5_<?=$intMN_NO?>" value="Y" <?=($strMN_AUTH_E5=="Y")?"":"disabled";?> <?=($memberAuthRow["$intMN_NO"][AM_E5]=="Y")?"checked":"";?>>
					</td>
				</tr>
						<?
					}
				}

				if (is_array($aryCommunityAdmList)){
					for($i=0;$i<sizeof($aryCommunityAdmList);$i++){

						$intMN_LEVEL	= $aryCommunityAdmList[$i][MN_LEVEL];
						if ($intMN_LEVEL == 2) {
							$intMN_NO		= 6000 + $aryCommunityAdmList[$i][MN_NO];
						} else {
							$intMN_NO		= 5900 + $aryCommunityAdmList[$i][MN_NO];
						}

						$strMenuNameKR	= $aryCommunityAdmList[$i][MN_NAME_KR];
						$strMenuNameUS	= $aryCommunityAdmList[$i][MN_NAME_US];
						$strMenuNameCN	= $aryCommunityAdmList[$i][MN_NAME_CN];
						$strMenuNameJP	= $aryCommunityAdmList[$i][MN_NAME_JP];
						$strMenuNameID	= $aryCommunityAdmList[$i][MN_NAME_ID];
						$strMenuNameFR	= $aryCommunityAdmList[$i][MN_NAME_FR];
						
						$strMN_AUTH_L	= $aryCommunityAdmList[$i][MN_AUTH_L];
						$strMN_AUTH_W	= $aryCommunityAdmList[$i][MN_AUTH_W];
						$strMN_AUTH_M	= $aryCommunityAdmList[$i][MN_AUTH_M];
						$strMN_AUTH_D	= $aryCommunityAdmList[$i][MN_AUTH_D];
						$strMN_AUTH_E	= $aryCommunityAdmList[$i][MN_AUTH_E];
						$strMN_AUTH_C	= $aryCommunityAdmList[$i][MN_AUTH_C];
						$strMN_AUTH_S	= $aryCommunityAdmList[$i][MN_AUTH_S];
						$strMN_AUTH_U	= $aryCommunityAdmList[$i][MN_AUTH_U];
						$strMN_AUTH_P	= $aryCommunityAdmList[$i][MN_AUTH_P];
						$strMN_AUTH_E1	= $aryCommunityAdmList[$i][MN_AUTH_E1];
						$strMN_AUTH_E2	= $aryCommunityAdmList[$i][MN_AUTH_E2];
						$strMN_AUTH_E3	= $aryCommunityAdmList[$i][MN_AUTH_E3];
						$strMN_AUTH_E4	= $aryCommunityAdmList[$i][MN_AUTH_E4];
						$strMN_AUTH_E5	= $aryCommunityAdmList[$i][MN_AUTH_E5];
						
						for($j=1;$j<=3;$j++){
							if ($intMN_LEVEL == $j) {
								${"strMenuName_".$j}	= "<strong>".${"strMenuName".$strAdmSiteLng}."</strong>";
								${"strMenuStyle_".$j}	= "style=\"text-align:left;\"";
							} else {
								${"strMenuName_".$j}	= "";
								${"strMenuStyle_".$j}	= "";
							}
						}

						?>
				<tr>
					<td style="text-align:left;"><?=$strMenuName_1?></td>
					<td style="text-align:left;"><?=$strMenuName_2?></td>
					<td style="text-align:left;"><?=$strMenuName_3?></td>
					<td>
						<input type="checkbox" name="mn_no[]" id="mn_no[]" value="<?=$intMN_NO?>" onclick="javascript:setMenuUse(this,<?=$intMN_LEVEL?>);" <?=($intMN_NO == $memberAuthRow["$intMN_NO"][MN_NO])?"checked":"";?>>
					</td>
					<td>
						<input type="checkbox" name="mn_auth_w_<?=$intMN_NO?>" id="mn_auth_w_<?=$intMN_NO?>" value="Y" <?=($strMN_AUTH_W=="Y")?"":"disabled";?> <?=($memberAuthRow["$intMN_NO"][AM_W]=="Y")?"checked":"";?>>
					</td>
					<td>
						<input type="checkbox" name="mn_auth_m_<?=$intMN_NO?>" id="mn_auth_m_<?=$intMN_NO?>" value="Y" <?=($strMN_AUTH_M=="Y")?"":"disabled";?> <?=($memberAuthRow["$intMN_NO"][AM_M]=="Y")?"checked":"";?>>
					</td>
					<td>
						<input type="checkbox" name="mn_auth_d_<?=$intMN_NO?>" id="mn_auth_d_<?=$intMN_NO?>" value="Y" <?=($strMN_AUTH_D=="Y")?"":"disabled";?> <?=($memberAuthRow["$intMN_NO"][AM_D]=="Y")?"checked":"";?>>
					</td>
					<td>
						<input type="checkbox" name="mn_auth_e_<?=$intMN_NO?>" id="mn_auth_e_<?=$intMN_NO?>" value="Y" <?=($strMN_AUTH_E=="Y")?"":"disabled";?> <?=($memberAuthRow["$intMN_NO"][AM_E]=="Y")?"checked":"";?>>
					</td>
					<td>
						<input type="checkbox" name="mn_auth_c_<?=$intMN_NO?>" id="mn_auth_c_<?=$intMN_NO?>" value="Y" <?=($strMN_AUTH_C=="Y")?"":"disabled";?> <?=($memberAuthRow["$intMN_NO"][AM_C]=="Y")?"checked":"";?>>
					</td>
					<td>
						<input type="checkbox" name="mn_auth_s_<?=$intMN_NO?>" id="mn_auth_s_<?=$intMN_NO?>" value="Y" <?=($strMN_AUTH_S=="Y")?"":"disabled";?> <?=($memberAuthRow["$intMN_NO"][AM_S]=="Y")?"checked":"";?>>
					</td>
					<td>
						<input type="checkbox" name="mn_auth_u_<?=$intMN_NO?>" id="mn_auth_u_<?=$intMN_NO?>" value="Y" <?=($strMN_AUTH_U=="Y")?"":"disabled";?> <?=($memberAuthRow["$intMN_NO"][AM_U]=="Y")?"checked":"";?>>
					</td>
					<td>
						<input type="checkbox" name="mn_auth_p_<?=$intMN_NO?>" id="mn_auth_p_<?=$intMN_NO?>" value="Y" <?=($strMN_AUTH_P=="Y")?"":"disabled";?> <?=($memberAuthRow["$intMN_NO"][AM_P]=="Y")?"checked":"";?>>
					</td>
					<td>
						<input type="checkbox" name="mn_auth_e1_<?=$intMN_NO?>" id="mn_auth_e1_<?=$intMN_NO?>" value="Y" <?=($strMN_AUTH_E1=="Y")?"":"disabled";?> <?=($memberAuthRow["$intMN_NO"][AM_E1]=="Y")?"checked":"";?>>
					</td>
					<td>
						<input type="checkbox" name="mn_auth_e2_<?=$intMN_NO?>" id="mn_auth_e2_<?=$intMN_NO?>" value="Y" <?=($strMN_AUTH_E2=="Y")?"":"disabled";?> <?=($memberAuthRow["$intMN_NO"][AM_E2]=="Y")?"checked":"";?>>
					</td>
					<td>
						<input type="checkbox" name="mn_auth_e3_<?=$intMN_NO?>" id="mn_auth_e3_<?=$intMN_NO?>" value="Y" <?=($strMN_AUTH_E3=="Y")?"":"disabled";?> <?=($memberAuthRow["$intMN_NO"][AM_E3]=="Y")?"checked":"";?>>
					</td>
					<td>
						<input type="checkbox" name="mn_auth_e4_<?=$intMN_NO?>" id="mn_auth_e4_<?=$intMN_NO?>" value="Y" <?=($strMN_AUTH_E4=="Y")?"":"disabled";?> <?=($memberAuthRow["$intMN_NO"][AM_E4]=="Y")?"checked":"";?>>
					</td>
					<td>
						<input type="checkbox" name="mn_auth_e5_<?=$intMN_NO?>" id="mn_auth_e5_<?=$intMN_NO?>" value="Y" <?=($strMN_AUTH_E5=="Y")?"":"disabled";?> <?=($memberAuthRow["$intMN_NO"][AM_E5]=="Y")?"checked":"";?>>
					</td>
				</tr>
						<?
					}
				}


			?>
		</table>
</div>
<div class="buttonWrap" style="margin:0px;padding-top:5px;padding-bottom:5px;border-top:5px solid #5e5e6d;position:Fixed;left:175px;bottom:0px;width:100%;background:#fff;">
		<a  href="javascript:goAdminAct();" class="btn_blue_big" id="menu_auth_m" style="display:none"><strong><?=$LNG_TRANS_CHAR["CW00003"] //수정?></strong></a>
		<a  href="<?=$linkCancel?>" class="btn_big"><strong><?=$LNG_TRANS_CHAR["CW00008"] //취소?></strong></a>
	(<input type="checkbox" id="chkAll2" data_target="mn_"/> 전체권한)
</div>
