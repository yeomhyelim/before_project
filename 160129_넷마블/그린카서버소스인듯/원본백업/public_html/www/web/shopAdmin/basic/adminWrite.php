<script type="text/javascript">
<!--
	$(document).ready(function() {

	});
//-->
</script>
<div id="contentArea">
	<div class="contentTop">
		<h2><?=$LNG_TRANS_CHAR["BW00078"] //부관리자 관리?> </h2>
		<div class="clr"></div>
	</div>
	<br>
	<!-- ******** 컨텐츠 ********* -->

	<div class="tableFormWrap">
		<table class="tableForm">
			<tr>
				<th><?=$LNG_TRANS_CHAR["CW00024"] //ID?></th>
				<td>
					<input type="text" class="inbox _w200" name="m_id" id="m_id" readonly value="<?=$row[M_MAIL]?>" onclick="javascript:goAdminFind();"/>
					<a class="btn_blue_sml" href="javascript:goAdminFind();"><strong><?=$LNG_TRANS_CHAR["BW00091"] //관리자검색?></strong></a>
					<div class="helpTxt">
						<ul>
							<li>- <?=$LNG_TRANS_CHAR["BS00023"] //회원목록에서 <strong>관리자 그룹</strong>으로 수정된 회원만 검색됩니다.?></li>
							<li>- <?=$LNG_TRANS_CHAR["BS00024"] //대상회원의 그룹을 변경하시려면 회원관리 페이지로 가셔서 수정해 주세요.?>
							<a href="./?menuType=member&mode=memberList"><?=$LNG_TRANS_CHAR["BW00090"] //회원관리?> <span style="font-size:9px;">▶</span></a></li>
						</ul>
					</div>
				</td>
			</tr>
			<tr>
				<th><?=$LNG_TRANS_CHAR["CW00023"] //이름?></th>
				<td>
					<input type="input" name="m_name" id="m_name" class="inbox _w200" maxlength="50" readonly value="<?=$row[M_U_NAME]?>"/>
					<!-- div class="helpTxt">
						<ul>
							<li>- <?=$LNG_TRANS_CHAR["BS00025"] //관리자외 영업회원으로 지정하는 옵션입니다.?></li>
							<li>- <?=$LNG_TRANS_CHAR["BS00026"] //현재 기능은 제공되지 않고 있으며 향후 <strong>업데이트 예정옵션</strong>입니다.?></li>
						</ul>
					</div-//-->
				</td>
			</tr>
			<tr>
				<th><?=$LNG_TRANS_CHAR["CW00025"] //연락처?></th>
				<td><input type="input" name="m_phone" id="m_phone"  class="inbox _w200" maxlength="50" readonly value="<?=$row[M_PHONE]?>"/></td>
			</tr>
			<tr>
				<th><?=$LNG_TRANS_CHAR["CW00029"] //메모?></th>
				<td><textarea name="a_memo" id="a_memo" class="inbox _w200"><?=$row[A_MEMO]?></textarea></td>
			</tr>
			<!-- tr>
				<th><?=$LNG_TRANS_CHAR["BW00089"] //영업사원?></th>
				<td><input type="checkbox" name="a_tm" id="a_tm" value="Y">
					<?if($ADMIN_SHOP_SELECT_USE == "Y"):?>
					<div id="shopSelectForm" style="display:none">
						<a href="javascript:goShopSelectWriteMove()" class="btn_sml"><strong>관리 입점몰 선택</strong></a>
						<input type="hidden" name="a_shop_list" id="selectList" value="">
					</div>
					<?endif;?>
				</td>
			</tr -->
		</table>
	</div><!-- tablForm -->

    <script>
			var currentScrollTop=0;window.onload=function(){scrollController();$(window).on('scroll',function(){scrollController();});}
			function scrollController(){currentScrollTop=$(window).scrollTop();if(currentScrollTop<430){$('#blog-header-container').css('top',-(currentScrollTop));$('#menu-container').css('top',430-(currentScrollTop));if($('#menu-container').hasClass('fixed')){$('#menu-container').removeClass('fixed');$('#menu-container .menu-icon').removeClass('on');}}else{if(!$('#menu-container').hasClass('fixed')){$('#blog-header-container').css('top',-430);$('#menu-container').css('top',0);$('#menu-container').addClass('fixed');$('#menu-container .menu-icon').addClass('on');}}}
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
				<td  style="width:159px;" <?=$strMenuStyle_1?> class="alignLeft"><?=$strMenuName_1?></td>
				<td  style="width:159px;" <?=$strMenuStyle_2?> class="alignLeft"><?=$strMenuName_2?></td>
				<td  style="width:161px;" <?=$strMenuStyle_3?> class="alignLeft"><?=$strMenuName_3?></td>
				<td>
					<input type="checkbox" name="mn_no[]" id="mn_no[]" value="<?=$intMN_NO?>" onclick="javascript:setMenuUse(this,<?=$intMN_LEVEL?>);" <?=($intMN_NO == $menuRow01[AM_MN_NO])?"checked":"";?>>
				</td>
				<td>
					<input type="checkbox" name="mn_auth_w_<?=$intMN_NO?>" id="mn_auth_w_<?=$intMN_NO?>" value="Y" <?=($strMN_AUTH_W=="Y")?"":"disabled";?> <?=($menuRow01[AM_W]=="Y")?"checked":"";?>>
				</td>
				<td>
					<input type="checkbox" name="mn_auth_m_<?=$intMN_NO?>" id="mn_auth_m_<?=$intMN_NO?>" value="Y" <?=($strMN_AUTH_M=="Y")?"":"disabled";?>
					<?=($menuRow01[AM_M]=="Y")?"checked":"";?>>
				</td>
				<td>
					<input type="checkbox" name="mn_auth_d_<?=$intMN_NO?>" id="mn_auth_d_<?=$intMN_NO?>" value="Y" <?=($strMN_AUTH_D=="Y")?"":"disabled";?>
					<?=($menuRow01[AM_D]=="Y")?"checked":"";?>>
				</td>
				<td>
					<input type="checkbox" name="mn_auth_e_<?=$intMN_NO?>" id="mn_auth_e_<?=$intMN_NO?>" value="Y" <?=($strMN_AUTH_E=="Y")?"":"disabled";?>
					<?=($menuRow01[AM_E]=="Y")?"checked":"";?>>
				</td>
				<td>
					<input type="checkbox" name="mn_auth_c_<?=$intMN_NO?>" id="mn_auth_c_<?=$intMN_NO?>" value="Y" <?=($strMN_AUTH_C=="Y")?"":"disabled";?>
					<?=($menuRow01[AM_C]=="Y")?"checked":"";?>>
				</td>
				<td>
					<input type="checkbox" name="mn_auth_s_<?=$intMN_NO?>" id="mn_auth_s_<?=$intMN_NO?>" value="Y" <?=($strMN_AUTH_S=="Y")?"":"disabled";?>
					<?=($menuRow01[AM_S]=="Y")?"checked":"";?>>
				</td>
				<td>
					<input type="checkbox" name="mn_auth_u_<?=$intMN_NO?>" id="mn_auth_u_<?=$intMN_NO?>" value="Y" <?=($strMN_AUTH_U=="Y")?"":"disabled";?>
					<?=($menuRow01[AM_U]=="Y")?"checked":"";?>>
				</td>
				<td>
					<input type="checkbox" name="mn_auth_p_<?=$intMN_NO?>" id="mn_auth_p_<?=$intMN_NO?>" value="Y" <?=($strMN_AUTH_P=="Y")?"":"disabled";?>
					<?=($menuRow01[AM_P]=="Y")?"checked":"";?>>
				</td>
				<td>
					<input type="checkbox" name="mn_auth_e1_<?=$intMN_NO?>" id="mn_auth_e1_<?=$intMN_NO?>" value="Y" <?=($strMN_AUTH_E1=="Y")?"":"disabled";?>
					<?=($menuRow01[AM_E1]=="Y")?"checked":"";?>>
				</td>
				<td>
					<input type="checkbox" name="mn_auth_e2_<?=$intMN_NO?>" id="mn_auth_e2_<?=$intMN_NO?>" value="Y" <?=($strMN_AUTH_E2=="Y")?"":"disabled";?>
					<?=($menuRow01[AM_E2]=="Y")?"checked":"";?>>
				</td>
				<td>
					<input type="checkbox" name="mn_auth_e3_<?=$intMN_NO?>" id="mn_auth_e3_<?=$intMN_NO?>" value="Y" <?=($strMN_AUTH_E3=="Y")?"":"disabled";?>
					<?=($menuRow01[AM_E3]=="Y")?"checked":"";?>>
				</td>
				<td>
					<input type="checkbox" name="mn_auth_e4_<?=$intMN_NO?>" id="mn_auth_e4_<?=$intMN_NO?>" value="Y" <?=($strMN_AUTH_E4=="Y")?"":"disabled";?>
					<?=($menuRow01[AM_E4]=="Y")?"checked":"";?>>
				</td>
				<td>
					<input type="checkbox" name="mn_auth_e5_<?=$intMN_NO?>" id="mn_auth_e5_<?=$intMN_NO?>" value="Y" <?=($strMN_AUTH_E5=="Y")?"":"disabled";?>
					<?=($menuRow01[AM_E5]=="Y")?"checked":"";?>>
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
						<input type="checkbox" name="mn_no[]" id="mn_no[]" value="<?=$intMN_NO?>" onclick="javascript:setMenuUse(this,<?=$intMN_LEVEL?>);" >
					</td>
					<td>
						<input type="checkbox" name="mn_auth_w_<?=$intMN_NO?>" id="mn_auth_w_<?=$intMN_NO?>" value="Y" <?=($strMN_AUTH_W=="Y")?"":"disabled";?>>
					</td>
					<td>
						<input type="checkbox" name="mn_auth_m_<?=$intMN_NO?>" id="mn_auth_m_<?=$intMN_NO?>" value="Y" <?=($strMN_AUTH_M=="Y")?"":"disabled";?>>
					</td>
					<td>
						<input type="checkbox" name="mn_auth_d_<?=$intMN_NO?>" id="mn_auth_d_<?=$intMN_NO?>" value="Y" <?=($strMN_AUTH_D=="Y")?"":"disabled";?>>
					</td>
					<td>
						<input type="checkbox" name="mn_auth_e_<?=$intMN_NO?>" id="mn_auth_e_<?=$intMN_NO?>" value="Y" <?=($strMN_AUTH_E=="Y")?"":"disabled";?>>
					</td>
					<td>
						<input type="checkbox" name="mn_auth_c_<?=$intMN_NO?>" id="mn_auth_c_<?=$intMN_NO?>" value="Y" <?=($strMN_AUTH_C=="Y")?"":"disabled";?>>
					</td>
					<td>
						<input type="checkbox" name="mn_auth_s_<?=$intMN_NO?>" id="mn_auth_s_<?=$intMN_NO?>" value="Y" <?=($strMN_AUTH_S=="Y")?"":"disabled";?>>
					</td>
					<td>
						<input type="checkbox" name="mn_auth_u_<?=$intMN_NO?>" id="mn_auth_u_<?=$intMN_NO?>" value="Y" <?=($strMN_AUTH_U=="Y")?"":"disabled";?>>
					</td>
					<td>
						<input type="checkbox" name="mn_auth_p_<?=$intMN_NO?>" id="mn_auth_p_<?=$intMN_NO?>" value="Y" <?=($strMN_AUTH_P=="Y")?"":"disabled";?>>
					</td>
					<td>
						<input type="checkbox" name="mn_auth_e1_<?=$intMN_NO?>" id="mn_auth_e1_<?=$intMN_NO?>" value="Y" <?=($strMN_AUTH_E1=="Y")?"":"disabled";?>>
					</td>
					<td>
						<input type="checkbox" name="mn_auth_e2_<?=$intMN_NO?>" id="mn_auth_e2_<?=$intMN_NO?>" value="Y" <?=($strMN_AUTH_E2=="Y")?"":"disabled";?>>
					</td>
					<td>
						<input type="checkbox" name="mn_auth_e3_<?=$intMN_NO?>" id="mn_auth_e3_<?=$intMN_NO?>" value="Y" <?=($strMN_AUTH_E3=="Y")?"":"disabled";?>>
					</td>
					<td>
						<input type="checkbox" name="mn_auth_e4_<?=$intMN_NO?>" id="mn_auth_e4_<?=$intMN_NO?>" value="Y" <?=($strMN_AUTH_E4=="Y")?"":"disabled";?>>
					</td>
					<td>
						<input type="checkbox" name="mn_auth_e5_<?=$intMN_NO?>" id="mn_auth_e5_<?=$intMN_NO?>" value="Y" <?=($strMN_AUTH_E5=="Y")?"":"disabled";?>>
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
						<input type="checkbox" name="mn_no[]" id="mn_no[]" value="<?=$intMN_NO?>" onclick="javascript:setMenuUse(this,<?=$intMN_LEVEL?>);" >
					</td>
					<td>
						<input type="checkbox" name="mn_auth_w_<?=$intMN_NO?>" id="mn_auth_w_<?=$intMN_NO?>" value="Y" <?=($strMN_AUTH_W=="Y")?"":"disabled";?> >
					</td>
					<td>
						<input type="checkbox" name="mn_auth_m_<?=$intMN_NO?>" id="mn_auth_m_<?=$intMN_NO?>" value="Y" <?=($strMN_AUTH_M=="Y")?"":"disabled";?>>
					</td>
					<td>
						<input type="checkbox" name="mn_auth_d_<?=$intMN_NO?>" id="mn_auth_d_<?=$intMN_NO?>" value="Y" <?=($strMN_AUTH_D=="Y")?"":"disabled";?>>
					</td>
					<td>
						<input type="checkbox" name="mn_auth_e_<?=$intMN_NO?>" id="mn_auth_e_<?=$intMN_NO?>" value="Y" <?=($strMN_AUTH_E=="Y")?"":"disabled";?>>
					</td>
					<td>
						<input type="checkbox" name="mn_auth_c_<?=$intMN_NO?>" id="mn_auth_c_<?=$intMN_NO?>" value="Y" <?=($strMN_AUTH_C=="Y")?"":"disabled";?>>
					</td>
					<td>
						<input type="checkbox" name="mn_auth_s_<?=$intMN_NO?>" id="mn_auth_s_<?=$intMN_NO?>" value="Y" <?=($strMN_AUTH_S=="Y")?"":"disabled";?>>
					</td>
					<td>
						<input type="checkbox" name="mn_auth_u_<?=$intMN_NO?>" id="mn_auth_u_<?=$intMN_NO?>" value="Y" <?=($strMN_AUTH_U=="Y")?"":"disabled";?>>
					</td>
					<td>
						<input type="checkbox" name="mn_auth_p_<?=$intMN_NO?>" id="mn_auth_p_<?=$intMN_NO?>" value="Y" <?=($strMN_AUTH_P=="Y")?"":"disabled";?>>
					</td>
					<td>
						<input type="checkbox" name="mn_auth_e1_<?=$intMN_NO?>" id="mn_auth_e1_<?=$intMN_NO?>" value="Y" <?=($strMN_AUTH_E1=="Y")?"":"disabled";?>>
					</td>
					<td>
						<input type="checkbox" name="mn_auth_e2_<?=$intMN_NO?>" id="mn_auth_e2_<?=$intMN_NO?>" value="Y" <?=($strMN_AUTH_E2=="Y")?"":"disabled";?>>
					</td>
					<td>
						<input type="checkbox" name="mn_auth_e3_<?=$intMN_NO?>" id="mn_auth_e3_<?=$intMN_NO?>" value="Y" <?=($strMN_AUTH_E3=="Y")?"":"disabled";?>>
					</td>
					<td>
						<input type="checkbox" name="mn_auth_e4_<?=$intMN_NO?>" id="mn_auth_e4_<?=$intMN_NO?>" value="Y" <?=($strMN_AUTH_E4=="Y")?"":"disabled";?>>
					</td>
					<td>
						<input type="checkbox" name="mn_auth_e5_<?=$intMN_NO?>" id="mn_auth_e5_<?=$intMN_NO?>" value="Y" <?=($strMN_AUTH_E5=="Y")?"":"disabled";?>>
					</td>
				</tr>
						<?
					}
				}


			?>
		</table>
	</div>
<div class="buttonLayerWrap">
	<a  href="javascript:goAdminAct();" class="btn_new_blue" id="menu_auth_w" style="display:none"><strong class="ico_write"><?=$LNG_TRANS_CHAR["CW00002"]	 //등록?></strong></a>
	<a  href="<?=$linkCancel?>" class="btn_new_gray"><strong class="ico_cancel"><?=$LNG_TRANS_CHAR["CW00008"] //취소?></strong></a>
	(<input type="checkbox" id="chkAll2" data_target="mn_"/> <?=$LNG_TRANS_CHAR["PW00278"] //전체권한 적용?>)
</div>