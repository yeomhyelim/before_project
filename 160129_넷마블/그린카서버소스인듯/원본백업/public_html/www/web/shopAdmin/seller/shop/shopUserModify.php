<?
	## 생년월일 설정
	$birth	= explode("-", $row['M_BIRTH']);
	$hp		= explode("-", $row['M_HP']);
?>
<div id="contentArea">
	<div class="contentTop">
		<h2><?=$LNG_TRANS_CHAR["SW00046"] //상점 사용자?></h2>
		<div class="clr"></div>
	</div>
	<!-- ******** 컨텐츠 ********* -->
	<div class="tableFormWrap">
		<!--  ****************  -->
		<h3 class="mt20"><?=$LNG_TRANS_CHAR["SW00047"] //사용자등록?></h3>
		<table class="tableForm">
			<tr>
				<th><?=$LNG_TRANS_CHAR["CW00024"] //ID?></th>
				<td>
					<input type="hidden" name="m_no" id="m_no" value="<?=$row['M_NO']?>" readonly>
					<input type="text" class="inbox _w200" name="m_id" id="m_id" readonly value="<?=$row['M_ID']?>"/>
				</td>
			</tr>
			<tr>
				<th><?=$LNG_TRANS_CHAR["CW00023"] //이름?></th>
				<td><input type="input" name="m_name" id="m_name" class="inbox _w200" maxlength="50" readonly value="<?=$row['M_NAME']?>"/></td>
			</tr>
			<!-- 생년월일/음력/양력 -->
			<?if($S_JOIN_BIRTH["USE"] == "Y" && $S_JOIN_BIRTH["JOIN"] == "Y"){?>
				<?if (!$S_JOIN_BIRTH["GRADE"] || in_array($strMemberJoinType,$S_JOIN_BIRTH["GRADE"])){?>
			<tr>
				<th><?=($S_JOIN_BIRTH["NES"]=="Y")?"<span class=\"mustItem\">":"";?> <?=$LNG_TRANS_CHAR["MW00012"] //생년월일?><?=($S_JOIN_BIRTH["NES"]=="Y")?"</span>":"";?></th>
				<td>
					<input type="input" id="birth1" name="birth1" class="defInput _w50" maxlength="4" value="<?=$birth[0]?>"/><?=$LNG_TRANS_CHAR["CW00012"] //년?>
					<input type="input" id="birth2" name="birth2" class="defInput _w30" maxlength="2" value="<?=$birth[1]?>"/><?=$LNG_TRANS_CHAR["CW00013"] //월?>
					<input type="input" id="birth3" name="birth3" class="defInput _w30" maxlength="2" value="<?=$birth[2]?>"/><?=$LNG_TRANS_CHAR["CW00014"] //일?>
					<?if ($S_JOIN_BIRTH_CAL["USE"] == "Y" && $S_JOIN_BIRTH_CAL["JOIN"] == "Y"){?>
						<?if (!$S_JOIN_BIRTH_CAL["GRADE"] || in_array($strMemberJoinType,$S_JOIN_BIRTH_CAL["GRADE"])){?>
					<input type="radio" id="birth_cal" name="birth_cal" value="1"<?if($row['M_BIRTH_CAL'] == 1){echo "checked"; }?>/><?=$LNG_TRANS_CHAR["MW00072"] //음력?>
					<input type="radio" id="birth_cal" name="birth_cal" value="2"<?if($row['M_BIRTH_CAL'] != 1){echo "checked"; }?>/><?=$LNG_TRANS_CHAR["MW00073"] //양력?>
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
				<th><?=($S_JOIN_SEX["NES"]=="Y")?"<span class=\"mustItem\">":"";?><?=$LNG_TRANS_CHAR["MW00069"] //성별?><?=($S_JOIN_SEX["NES"]=="Y")?"</span>":"";?></th>
				<td>
					<input type="radio" id="sex" name="sex" value="M"<?if($row['M_SEX'] == "M"){echo "checked"; }?>/> <?=$LNG_TRANS_CHAR["MW00024"] //남자?>
					<input type="radio" name="sex" id="sex" value="W"<?if($row['M_SEX'] == "W"){echo "checked"; }?>/> <?=$LNG_TRANS_CHAR["MW00025"] //여자?>
				</td>
			</tr>
				<?}?>
			<?}?>
			<!-- 성별 -->
			<!-- 핸드폰 -->
			<?if ($S_JOIN_HP["USE"] == "Y" && $S_JOIN_HP["JOIN"] == "Y"){?>
				<?if (!$S_JOIN_HP["GRADE"] || in_array($strMemberJoinType,$S_JOIN_HP["GRADE"])){?>
			<tr>
				<th><?=($S_JOIN_HP["NES"]=="Y")?"<span class=\"mustItem\">":"";?> <?=$LNG_TRANS_CHAR["MW00016"] //핸드폰?><?=($S_JOIN_HP["NES"]=="Y")?"</span>":"";?></th>
				<td>
					<?if ($S_SITE_LNG == "KR"){?>
					<?=drawSelectBoxMore("hp1",$aryHp,$hp[0],$design ="defSelect",$onchange="",$etc="id=\"hp1\"",$firstItem="",$html="N")?> -
					<input type="input" id="hp2" name="hp2" class="defInput _w50" maxlength="4" value="<?=$hp[1]?>"/> -
					<input type="input" id="hp3" name="hp3" class="defInput _w50" maxlength="4" value="<?=$hp[2]?>"/>
					<?}else{?>
					<input type="input" id="hp1" name="hp1" class="defInput _w200" maxlength="30" value="<?=$row['M_HP']?>"/>
					<?}?>

					<?if ($S_JOIN_SMSYN["USE"] == "Y" && $S_JOIN_SMSYN["JOIN"] == "Y"){?>
						<?if (!$S_JOIN_SMSYN["GRADE"] || in_array($strMemberJoinType,$S_JOIN_SMSYN["GRADE"])){?>
					<span><input type="checkbox" name="smsYN" id="smsYN" value="Y"<?if($row['M_SMSYN']=="Y"){echo " checked";}?>/> <?=$LNG_TRANS_CHAR["MS00014"] //SMS 정보를 수신합니다.?> </span>
						<?}?>
					<?}?>
				</td>
			</tr>
				<?}?>
			<?}?>
			<!-- 핸드폰 -->
			<!-- 이메일 -->
			<?if ($S_JOIN_MAIL["USE"] == "Y" && $S_JOIN_MAIL["JOIN"] == "Y"){?>
				<?if (!$S_JOIN_MAIL["GRADE"] || in_array($strMemberJoinType,$S_JOIN_MAIL["GRADE"])){?>
			<tr>
				<th><?=($S_JOIN_MAIL["NES"]=="Y")?"<span class=\"mustItem\">":"";?> <?=$LNG_TRANS_CHAR["MW00003"] //이메일?><?=($S_JOIN_MAIL["NES"]=="Y")?"</span>":"";?></th>
				<td>
					<input type="input" id="mail" name="mail" class="defInput _w300" maxlength="30" value="<?=$row['M_MAIL']?>"/>
					<?if ($S_JOIN_MAILYN["USE"] == "Y" && $S_JOIN_MAILYN["JOIN"] == "Y"){?>
						<?if (!$S_JOIN_MAILYN["GRADE"] || in_array($strMemberJoinType,$S_JOIN_MAILYN["GRADE"])){?>
					<span><input type="checkbox" id="mailYN" name="mailYN" value="Y"<?if($row['M_MAILYN']=="Y"){echo " checked";}?>/> <?=$LNG_TRANS_CHAR["MS00015"] //메일 정보를 수신합니다.?> </span>
						<?}?>
					<?}?>
				</td>
			</tr>
				<?}?>
			<?}?>
			<!-- 이메일 -->
			<tr>
				<th><?=$LNG_TRANS_CHAR["CW00029"] //메모?></th>
				<td><textarea name="user_memo" id="user_memo" class="inbox _w200"><?=$row[SU_MEMO]?></textarea></td>
			</tr>
			<tr>
				<th><?=$LNG_TRANS_CHAR["SW00048"] //최고관리자 여부?></th>
				<td>
					<?if ($a_admin_type != "S"){?>
					<input type="radio" name="user_type" id="user_type" value="A" <?=($row[SU_TYPE] == "A") ? "checked":"";?>><?=$LNG_TRANS_CHAR["SW00049"] //최고관리자?>
					<?}?>
					<input type="radio" name="user_type" id="user_type" value="P" <?=($row[SU_TYPE] == "P") ? "checked":"";?>><?=$LNG_TRANS_CHAR["SW00050"] //부관리자?>
				</td>
			</tr>
			<tr>
				<th><?=$LNG_TRANS_CHAR["SW00051"] //최고관리자 여부?></th>
				<td>
					<input type="radio" name="user_use" id="user_use" value="Y" <?=($row[SU_USE] == "Y") ? "checked":"";?>><?=$LNG_TRANS_CHAR["SW00052"] //사용함?>
					<input type="radio" name="user_use" id="user_use" value="N" <?=($row[SU_USE] == "N") ? "checked":"";?>><?=$LNG_TRANS_CHAR["SW00053"] //사용안함?>
				</td>
			</tr>
		</table>
	</div>

	<!-- style>#menu-container{position:fixed;top:512px;left:185px;width:100%;box-sizing:border-box;background: url(/shopAdmin/himg/common/table_th_bg.gif) right bottom repeat;}</style -->
    <script>
			var currentScrollTop=0;window.onload=function(){scrollController();$(window).on('scroll',function(){scrollController();});}
			function scrollController(){currentScrollTop=$(window).scrollTop();if(currentScrollTop<512){$('#blog-header-container').css('top',-(currentScrollTop));$('#menu-container').css('top',512-(currentScrollTop));if($('#menu-container').hasClass('fixed')){$('#menu-container').removeClass('fixed');$('#menu-container .menu-icon').removeClass('on');}}else{if(!$('#menu-container').hasClass('fixed')){$('#blog-header-container').css('top',-512);$('#menu-container').css('top',0);$('#menu-container').addClass('fixed');$('#menu-container .menu-icon').addClass('on');}}}
	</script>

	<div class="tableListLayerWrap">
		<h3 class="mt30"><?=$LNG_TRANS_CHAR["BW00079"] //권한?></h3>
		<div class="titInfoTxt"><?=$LNG_TRANS_CHAR["BS00027"] //추가하는 부관리자의 메뉴 권한을 설정해 주세요.?></div>
		<table class="tableList">
		<thead id="menu-container">
			<tr>
				<th rowspan="2" class="lowTh" style="width:170px;border-right:1px solid #7b859f"><?=$LNG_TRANS_CHAR["PW00279"]//대메뉴?></th>
				<th rowspan="2" class="lowTh" style="width:170px;border-right:1px solid #7b859f"><?=$LNG_TRANS_CHAR["PW00280"]//증메뉴?></th>
				<th rowspan="2" class="lowTh" style="width:170px;border-right:1px solid #7b859f"><?=$LNG_TRANS_CHAR["PW00281"]//소메뉴?></th>
				<th rowspan="2" class="lowTh" style="width:40px;border-right:1px solid #7b859f"><?=$LNG_TRANS_CHAR["BW00080"] //권한부여?></th>
				<th colspan="13" style="border-bottom:1px solid #e5e5e5;color:#FFF;"><?=$LNG_TRANS_CHAR["BW00081"] //Authority?></th>
			</tr>
			<tr>
				<th style="width:41px;"><?=$LNG_TRANS_CHAR["CW00002"] //등록?></th>
				<th style="width:41px;"><?=$LNG_TRANS_CHAR["CW00003"] //수정?></th>
				<th style="width:41px;"><?=$LNG_TRANS_CHAR["CW00004"] //삭제?></th>
				<th style="width:41px;"><?=$LNG_TRANS_CHAR["CW00030"] //엑셀?></th>
				<th style="width:41px;"><?=$LNG_TRANS_CHAR["CW00031"] //정산?></th>
				<th style="width:41px;"><?=$LNG_TRANS_CHAR["CW00032"] //SMS?></th>
				<th style="width:41px;"><?=$LNG_TRANS_CHAR["CW00033"] //Upload?></th>
				<th style="width:41px;"><?=$LNG_TRANS_CHAR["CW00034"] //Point?></th>
				<th style="width:41px;"><?=$LNG_TRANS_CHAR["CW00035"] //기타1?></th>
				<th style="width:41px;"><?=$LNG_TRANS_CHAR["CW00036"] //기타2?></th>
				<th style="width:41px;"><?=$LNG_TRANS_CHAR["CW00037"] //기타3?></th>
				<th style="width:41px;"><?=$LNG_TRANS_CHAR["CW00038"] //기타4?></th>
				<th style="width:43px;"><?=$LNG_TRANS_CHAR["CW00039"] //기타5?></th>
			</tr>
			</thead>
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
				<td  style="width:159px;" <?=$strMenuStyle_1?> class="alignLeft"><?=$strMenuName_1?></td>
				<td  style="width:159px;" <?=$strMenuStyle_2?> class="alignLeft"><?=$strMenuName_2?></td>
				<td  style="width:161px;" <?=$strMenuStyle_3?> class="alignLeft"><?=$strMenuName_3?></td>
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
			<!-- 커뮤니티 2013.07.25 kim hee sung 권한 설정 -->
			<?
				if (is_array($aryCommunityList)){
					for($i=0;$i<sizeof($aryCommunityList);$i++){

						if($aryCommunityList[$i]['MN_B_CODE']):
							if(!in_array($aryCommunityList[$i]['MN_B_CODE'], array("PROD_QNA","PROD_REVIEW","S_NOTICE","S_REQ","MY_QNA"))) { continue; }
						endif;

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

				## 게시판 관리는 입점사에게 제공하지 않습니다. (2013.07.25 kim hee sung)
				$aryCommunityAdmList = "";
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

	<div class="buttonLayerWrap">
		<a class="btn_new_blue" href="javascript:goAct('shopUserModify');" id="menu_auth_m"><strong class="ico_modify"><?=$LNG_TRANS_CHAR["CW00003"] //수정?></strong></a>
		<a class="btn_new_gray" href="./?menuType=seller&mode=shopUser&shopNo=<?=$_REQUEST['shopNo']?>"><strong class="ico_list"><?=$LNG_TRANS_CHAR["CW00001"] //목록?></strong></a>
		(<input type="checkbox" id="chkAll2" data_target="mn_"/> 전체권한)
	</div>

</div>
<!-- ******** 컨텐츠 ********* -->