			<div class="loginFormWrap">
				<?if ($S_MEM_CERITY == "1"){?>
				<!-- 아이디찾기  -->
				<div class="memberLogin mt50">
					<h4><img src="/himg/member/A0001/<?=$S_SITE_LNG_PATH?>/tit_find_id.gif"/></h4>
					<div class="loginForm mt10">
						<table>		
							<tr>
								<th><?=$LNG_TRANS_CHAR["MW00004"] //이름?></th>
								<td style="text-align:left;"><input type="text" name="searchId_L_Name" id="searchId_L_Name" style="width:100px;"/></td>
								<td rowspan="2" style="vertical-align:bottom;">
									<a href="javascript:goSearchId();"><img src="/himg/member/A0001/<?=$S_SITE_LNG_PATH?>/btn_ok.gif"></a>
								</td>
							</tr>
							<tr>
								<th><?=$LNG_TRANS_CHAR["MW00010"]; //이메일?></th>
								<td style="text-align:left;">
									<input type="text" name="searchId_Mail1" id="searchId_Mail1"  style="width:100px;"/>@
									<input type="text" name="searchId_Mail2" id="searchId_Mail2"  style="width:100px;"/>
								</td>							
							</tr>	
						</table>
					</div><!-- loginForm -->
				</div><!-- memberLogin -->
				<!-- 아이디찾기 // -->
				<?}?>

				<!-- 비밀번호찾기  -->
				<div class="memberLogin mt50">
					<input type="hidden" name="searchPass_Type" id="searchPass_Type" value="searchPwd"/>
					<h4><img src="/himg/member/A0001/<?=$S_SITE_LNG_PATH?>/tit_find_pass.gif"/></h4>
					<?if ($S_MEM_CERITY == "1"){?>
					<? if($arySmsRow['SM_AUTO'] == "Y") { ?>
						<div class="tabSearchPw mt20">
							<a href="javascript:goSearchPwdType('searchPwd')"><img src="/himg/member/A0001/<?=$S_SITE_LNG_PATH?>/tab_search_email.gif" alt="이메일"/></a>
							<a href="javascript:goSearchPwdType('searchPwdSms')"><img src="/himg/member/A0001/<?=$S_SITE_LNG_PATH?>/tab_search_phone.gif" alt="휴대폰"/></a>
						</div>
					<? } ?>
					<div class="loginForm">
					<table>
						<tr>
							<th>아이디</th>
							<td style="text-align:left;">
								<input type="input" name="searchPass_Id" id="searchPass_Id"  style="width:100px;" />
							</td>
							<td rowspan="4" style="vertical-align:bottom;">
								<a href="javascript:goSearchPwd();"><img src="/himg/member/A0001/<?=$S_SITE_LNG_PATH?>/btn_ok.gif"></a>
							</td>
						</tr>
						<tr>
							<th>성명</th>
							<td style="text-align:left;">
								<input type="input" name="searchPass_L_Name" id="searchPass_L_Name"  style="width:100px;"/>
							</td>
						</tr>
						<tr id="searchPwd">
							<th>이메일</th>
							<td style="text-align:left;">
								<input type="text" name="searchPass_Mail1" id="searchPass_Mail1"  style="width:100px;" />@
								<input type="text" name="searchPass_Mail2" id="searchPass_Mail2"  style="width:100px;" />
							</td>							
						</tr>
						<tr id="searchPwdSms" style="display:none;">
							<th>휴대폰</th>
							<td style="text-align:left;">
								<input type="text" name="searchPass_Hp1" id="searchPass_Hp1"  style="width:40px;"/> - 
								<input type="text" name="searchPass_Hp2" id="searchPass_Hp2"  style="width:60px;" /> - 
								<input type="text" name="searchPass_Hp3" id="searchPass_Hp3"  style="width:60px;" />
							</td>							
						</tr>
					</table>
					<?}?>
					<?if ($S_MEM_CERITY == "2"){?>
					<div class="loginForm">
					<table>
						<tr>
							<th><?=$LNG_TRANS_CHAR["MW00004"] //이름?></th>
							<td style="text-align:left;">
								<input type="input" name="searchPass_L_Name" id="searchPass_L_Name"  style="width:100px;"/>
							</td>
							<td rowspan="2" style="vertical-align:bottom;">
								<a href="javascript:goSearchPwd();"><img src="/himg/member/A0001/<?=$S_SITE_LNG_PATH?>/btn_ok.gif"></a>
							</td>
						</tr>
						<tr>
							<th><?=$LNG_TRANS_CHAR["MW00010"] //이메일?></th>
							<td style="text-align:left;">
								<input type="text" name="searchPass_Mail1" id="searchPass_Mail1"  style="width:100px;" />@
								<input type="text" name="searchPass_Mail2" id="searchPass_Mail2"  style="width:100px;" />
							</td>							
						</tr>
					</table>
					<?}?>

					</div><!-- loginForm -->
				</div><!-- memberLogin -->
				<!-- 비밀번호찾기//  -->
			</div>
			