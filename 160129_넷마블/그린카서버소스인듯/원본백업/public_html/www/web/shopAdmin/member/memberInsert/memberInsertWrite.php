<script type="text/javascript">
<!--
function memberGradeCheck(){

	var doc			= document.form;

	var ch = doc.memberGroup[1].checked;

	if(	ch ){

		$(".comView").show();

	}else{

		$(".comView").hide();

	}
}
//-->
</script>
<div id="contentArea">
	<div class="contentTop">
		<h2><?=$LNG_TRANS_CHAR["MM00021"]//회원추가등록?></h2>
		<div class="clr"></div>
	</div>
	<!-- ******** 컨텐츠 ********* -->
	<div class="tableFormWrap">
		<!--  ****************  -->
		<h3><?=$LNG_TRANS_CHAR["MW00241"]//회원정보?></h3>
		<table class="tableForm">
			<colgroup>
				<col style="width:110px;"/>
				<col/>
			</colgroup>
			<tr>
				<th><span class="mustItem">회원구분</span></th>
				<td>
					<input type="radio" name="memberGroup" value="002" onclick = "javascript:memberGradeCheck();" checked> 개인
					<input type="radio" name="memberGroup" value="005" onclick = "javascript:memberGradeCheck();"> 사업자
				</td>
			</tr>
			<!--아이디-->
			<?if ($S_MEM_CERITY == "1"){?>
				<?if ($S_JOIN_ID["USE"] == "Y" && $S_JOIN_ID["JOIN"] == "Y"){?>
					<?if (!$S_JOIN_ID["GRADE"] || in_array($strMemberJoinType,$S_JOIN_ID["GRADE"])){?>
			<tr>
				<th><?=($S_JOIN_ID["NES"]=="Y")?"<span class=\"mustItem\">":"";?>  <?=$LNG_TRANS_CHAR["CW00024"] //아이디?><?=($S_JOIN_ID["NES"]=="Y")?"</span>":"";?></th>
				<td>
					<input type="input" id="id" name="id" class="defInput" maxlength="12"/> <a href="javascript:goIdChk();" class="btn_TdinChk"><?=$LNG_TRANS_CHAR["EW00135"]//아이디중복검색?></a>
					<span><?=$LNG_TRANS_CHAR["MS00012"] //영문, 숫자 중 4자 이상 12자리 이하 사용?> </span>
				</td>
			</tr>
					<?}?>
				<?}?>
			<?}?>
			<!--아이디-->

			<!--이름-->
			<?if ($S_MEM_CERITY == "2"){?>
				<?if ($S_JOIN_NAME["USE"] == "Y" && $S_JOIN_NAME["JOIN"] == "Y"){?>
					<?if (!$S_JOIN_NAME["GRADE"] || in_array($strMemberJoinType,$S_JOIN_NAME["GRADE"])){?>
						<?if($S_SITE_LNG != "KR"): // 다국어 일때만?>
			<tr>
				<th><?=($S_JOIN_NAME["NES"]=="Y")?"<span class=\"mustItem\">":"";?> <?=$LNG_TRANS_CHAR["MW00096"] //성?> <?=($S_JOIN_NAME["NES"]=="Y")?"</span>":"";?></th>
				<td><input type="input" id="f_name" name="f_name" class="defInput" maxlength="20"/></td>
			</tr>
						<?php endif;?>
			<tr>
				<th><?=($S_JOIN_NAME["NES"]=="Y")?"<span class=\"mustItem\">":"";?> <?=$LNG_TRANS_CHAR["MW00097"] //이름?> <?=($S_JOIN_NAME["NES"]=="Y")?"</span>":"";?></th>
				<td><input type="input" id="l_name" name="l_name" class="defInput" maxlength="20"/></td>
			</tr>
					<?}?>
				<?}?>
			<?}?>
			<!--이름-->
			<!-- 이메일 -->
			<?if ($S_MEM_CERITY=="2"){?>
				<?if ($S_JOIN_MAIL["USE"] == "Y" && $S_JOIN_MAIL["JOIN"] == "Y"){?>
					<?if (!$S_JOIN_MAIL["GRADE"] || in_array($strMemberJoinType,$S_JOIN_MAIL["GRADE"])){?>
						<tr>
							<th><?=$LNG_TRANS_CHAR["BW00005"] //이메일?> </th>
							<td>
								<input type="text" id="mail" name="mail" class="defInput _w300" maxlength="30"/>
								<?if ($S_JOIN_MAILYN["USE"] == "Y" && $S_JOIN_MAILYN["JOIN"] == "Y"){?>
									<?if (!$S_JOIN_MAILYN["GRADE"] || in_array($strMemberJoinType,$S_JOIN_MAILYN["GRADE"])){?>
										<span class="txt_Minfo"><input type="checkbox" id="mailYN" name="mailYN" value="Y" checked/> <?=$LNG_TRANS_CHAR["MS00015"] //메일 정보를 수신합니다.?></span>
									<?}?>
								<?}?>
								<span class="tdTextGuide">로그인 아이디는 이메일을 사용합니다. 사용하시는 이메일을 등록해 주세요.</span>
							</td>
						</tr>
					<?}?>
				<?}?>
			<?}?>
			<!-- 이메일 -->

			<!--비밀번호-->
			<?if ($S_JOIN_PASS["USE"] == "Y" && $S_JOIN_PASS["JOIN"] == "Y"){?>
				<?if (!$S_JOIN_PASS["GRADE"] || in_array($strMemberJoinType,$S_JOIN_PASS["GRADE"])){?>
			<tr>
				<th><span class="mustItem"><?=$LNG_TRANS_CHAR["MW00011"] //비밀번호?> </span></th>
				<td>
					<input type="password" id="pwd1" name="pwd1" class="defInput" maxlength="16"/>
					<span><?=$LNG_TRANS_CHAR["MS00013"] //영문, 숫자, 특수문자 중 4자 이상 16자리 이하 사용?> </span>
				</td>
			</tr>
			<tr>
				<th><?=($S_JOIN_ID["NES"]=="Y")?"<span class=\"mustItem\">":"";?> <?=$LNG_TRANS_CHAR["MW00237"] //비밀번호 확인?> </th>
				<td>
					<input type="password" id="pwd2" name="pwd2" class="defInput" maxlength="16"/>
					<span class="tdTextGuide"><?=$LNG_TRANS_CHAR["MS00068"] //비밀번호를 한번더 입력해 주세요.?> </span>
				</td>
			</tr>
				<?}?>
			<?}?>
			<!--비밀번호-->
			
			<!--이름-->
			<?if ($S_MEM_CERITY == "1"){?>
				<?if ($S_JOIN_NAME["USE"] == "Y" && $S_JOIN_NAME["JOIN"] == "Y"){?>
					<?if (!$S_JOIN_NAME["GRADE"] || in_array($strMemberJoinType,$S_JOIN_NAME["GRADE"])){?>
			<tr>
				<th><?=($S_JOIN_NAME["NES"]=="Y")?"<span class=\"mustItem\">":"";?> <?=$LNG_TRANS_CHAR["MW00097"] //이름?> <?=($S_JOIN_NAME["NES"]=="Y")?"</span>":"";?></th>
				<td><input type="input" id="l_name" name="l_name" class="defInput" maxlength="20"/></td>
			</tr>
					<?}?>
				<?}?>
			<?}?>
			<!--이름-->
			<!-- 닉네임 -->
			<?if ($S_JOIN_NICKNAME["USE"] == "Y" && $S_JOIN_NICKNAME["JOIN"] == "Y"){?>
				<?if (!$S_JOIN_NICKNAME["GRADE"] || in_array($strMemberJoinType,$S_JOIN_NICKNAME["GRADE"])){?>
			<tr>
				<th><?=($S_JOIN_NICKNAME["NES"]=="Y")?"<span class=\"mustItem\">":"";?> <?=$LNG_TRANS_CHAR["MW00071"] //닉네임?><?=($S_JOIN_NICKNAME["NES"]=="Y")?"</span>":"";?></th>
				<td>
					<input type="input" id="nickname" name="nickname" class="defInput" maxlength="16"/> <a href="javascript:goNickNameChk();">[중복체크]</a>
					<span>한글, 영문, 숫자 중 4자 이상 16자리 이하 사용 </span>
				</td>
			</tr>
				<?}?>
			<?}?>
			<!-- 닉네임 -->
			<!-- 생년월일/음력/양력 -->
			<?if ($S_JOIN_BIRTH["USE"] == "Y" && $S_JOIN_BIRTH["JOIN"] == "Y"){?>
				<?if (!$S_JOIN_BIRTH["GRADE"] || in_array($strMemberJoinType,$S_JOIN_BIRTH["GRADE"])){?>
			<tr>
				<th><?=($S_JOIN_BIRTH["NES"]=="Y")?"<span class=\"mustItem\">":"";?> <?=$LNG_TRANS_CHAR["MW00012"] //생년월일?><?=($S_JOIN_BIRTH["NES"]=="Y")?"</span>":"";?></th>
				<td>
					<input type="input" id="birth1" name="birth1" class="defInput _w50" maxlength="4"/><?=$LNG_TRANS_CHAR["CW00012"] //년?>
					<input type="input" id="birth2" name="birth2" class="defInput _w30" maxlength="2"/><?=$LNG_TRANS_CHAR["CW00013"] //월?>
					<input type="input" id="birth3" name="birth3" class="defInput _w30" maxlength="2"/><?=$LNG_TRANS_CHAR["CW00014"] //일?>
					<?if ($S_JOIN_BIRTH_CAL["USE"] == "Y" && $S_JOIN_BIRTH_CAL["JOIN"] == "Y"){?>
						<?if (!$S_JOIN_BIRTH_CAL["GRADE"] || in_array($strMemberJoinType,$S_JOIN_BIRTH_CAL["GRADE"])){?>
					<input type="radio" id="birth_cal" name="birth_cal" value="1"/><?=$LNG_TRANS_CHAR["MW00072"] //음력?>
					<input type="radio" id="birth_cal" name="birth_cal" value="2" checked/><?=$LNG_TRANS_CHAR["MW00073"] //양력?>
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
					<input type="radio" id="sex" name="sex" value="M" checked/> <?=$LNG_TRANS_CHAR["MW00024"] //남자?> <input type="radio" name="sex" id="sex" value="W"/> <?=$LNG_TRANS_CHAR["MW00025"] //여자?>
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
					<?=drawSelectBoxMore("hp1",$aryHp,$aryMemHp[0],$design ="defSelect",$onchange="",$etc="id=\"hp1\"",$firstItem="",$html="N")?>
					 -
					<input type="input" id="hp2" name="hp2" class="defInput _w50" maxlength="4" value="<?=$aryMemHp[1]?>"/> -
					<input type="input" id="hp3" name="hp3" class="defInput _w50" maxlength="4" value="<?=$aryMemHp[2]?>"/>
					<?}else{?>
					<input type="input" id="hp1" name="hp1" class="defInput _w200" maxlength="30" value="<?=$memberRow[M_HP]?>"/>
					<?}?>
					
					<?if ($S_JOIN_SMSYN["USE"] == "Y" && $S_JOIN_SMSYN["JOIN"] == "Y"){?>
						<?if (!$S_JOIN_SMSYN["GRADE"] || in_array($strMemberJoinType,$S_JOIN_SMSYN["GRADE"])){?>
					<span><input type="checkbox" name="smsYN" id="smsYN" value="Y" checked/> <?=$LNG_TRANS_CHAR["MS00014"] //SMS 정보를 수신합니다.?> </span>
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
			<tr class="comView" style="display:none">
				<th><?=($S_JOIN_PHONE["NES"]=="Y")?"<span class=\"mustItem\">":"";?> <?=$LNG_TRANS_CHAR["MW00010"] //전화번호?><?=($S_JOIN_PHONE["NES"]=="Y")?"</span>":"";?></th>
				<td>
					<?if ($S_SITE_LNG == "KR"){?>
					<?=drawSelectBoxMore("phone1",$aryPhone,$aryMemPhone[0],$design ="defSelect",$onchange="",$etc="id=\"phone1\"",$firstItem="",$html="N")?>
					 -
					<input type="input" id="phone2" name="phone2" class="defInput _w50" maxlength="4" value="<?=$aryMemPhone[1]?>"/> -
					<input type="input" id="phone3" name="phone3" class="defInput _w50" maxlength="4" value="<?=$aryMemPhone[2]?>"/>
					<?}else {?>
					<input type="input" id="phone1" name="phone1" class="defInput _w200" maxlength="30" value="<?=$memberRow[M_PHONE]?>"/>
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
				<th><?=($S_JOIN_FAX["NES"]=="Y")?"<span class=\"mustItem\">":"";?> <?=$LNG_TRANS_CHAR["MW00074"] //팩스번호?><?=($S_JOIN_FAX["NES"]=="Y")?"</span>":"";?></th>
				<td>
					<?if ($S_SITE_LNG == "KR"){?>
					<?=drawSelectBoxMore("fax1",$aryPhone,$aryMemFax[0],$design ="defSelect",$onchange="",$etc="",$firstItem="",$html="N")?>
					 -
					<input type="input" id="fax2" name="fax2" class="defInput _w50" maxlength="4" value="<?=$aryMemFax[1]?>"/> -
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
			<?if ($S_MEM_CERITY=="1"){?>
				<?if ($S_JOIN_MAIL["USE"] == "Y" && $S_JOIN_MAIL["JOIN"] == "Y"){?>
					<?if (!$S_JOIN_MAIL["GRADE"] || in_array($strMemberJoinType,$S_JOIN_MAIL["GRADE"])){?>
						<tr>
							<th><span class="mustItem">이메일</span> </th>
							<td>
								<input type="text" id="mail" name="mail" class="defInput _w300" maxlength="30"/>
								<?if ($S_JOIN_MAILYN["USE"] == "Y" && $S_JOIN_MAILYN["JOIN"] == "Y"){?>
									<?if (!$S_JOIN_MAILYN["GRADE"] || in_array($strMemberJoinType,$S_JOIN_MAILYN["GRADE"])){?>
								<span class="txt_Minfo"><input type="checkbox" id="mailYN" name="mailYN" value="Y" checked/> 메일 정보를 수신합니다. </span>
									<?}?>
								<?}?>
							</td>
						</tr>
					<?}?>
				<?}?>
			<?}?>
			<!-- 이메일 -->
			<!-- 주소 -->
			<?if ($S_JOIN_ADDR["USE"] == "Y" && $S_JOIN_ADDR["JOIN"] == "Y"){?>
				<?if (!$S_JOIN_ADDR["GRADE"] || in_array($strMemberJoinType,$S_JOIN_ADDR["GRADE"])){?>
					<?if ($S_SITE_LNG == "KR"){?>
			<tr>
				<th><?=($S_JOIN_ADDR["NES"]=="Y")?"<span class=\"mustItem\">":"";?> <?=$LNG_TRANS_CHAR["MW00019"] //주소?><?=($S_JOIN_ADDR["NES"]=="Y")?"</span>":"";?></th>
				<td>
					<dl>
						<dd><input type="input" id="zip1" name="zip1" class="defInput _w30" maxlength="3" readonly/> - <input type="input" id="zip2" name="zip2" class="defInput _w30" maxlength="3" readonly/> <a href="javascript:goZip(4);" class="btn_TdinChk">우편번호검색</a></dd>
						<dd><input type="input" id="addr1" name="addr1" class="defInput _w300" maxlength="200" readonly/></dd>
						<dd><input type="input" id="addr2" name="addr2" class="defInput _w300" maxlength="200"/></dd>
					</dl>
				</td>
			</tr>
					<?}else{?>
			<tr>
				<th><?=($S_JOIN_NAME["NES"]=="Y")?"<span class=\"mustItem\">":"";?> <?=$LNG_TRANS_CHAR["MW00075"] //국가?><?=($S_JOIN_NAME["NES"]=="Y")?"</span>":"";?></th>
				<td>
					<?=drawSelectBoxMore("country",$aryCountryList,$memberRow[M_COUNTRY],$design ="",$onchange="",$etc="",$firstItem="= Country =",$html="N")?>
				</td>
			</tr>
			<tr>
				<th><?=($S_JOIN_ADDR["NES"]=="Y")?"<span class=\"mustItem\">":"";?> <?=$LNG_TRANS_CHAR["MW00019"] //주소?><?=($S_JOIN_ADDR["NES"]=="Y")?"</span>":"";?></th>
				<td>
					<dl>
						<dd><input type="input" id="addr1" name="addr1" class="defInput _w300" maxlength="200"/></dd>
					</dl>
				</td>
			</tr>
			<tr>
				<th><?=($S_JOIN_ADDR["NES"]=="Y")?"<span class=\"mustItem\">":"";?> <?=$LNG_TRANS_CHAR["MW00079"] //상세주소?><?=($S_JOIN_ADDR["NES"]=="Y")?"</span>":"";?></th>
				<td>
					<dl>
						<dd><input type="input" id="addr2" name="addr2" class="defInput _w300" maxlength="200"/></dd>
					</dl>
				</td>
			</tr>
			<tr>
				<th><?=($S_JOIN_ADDR["NES"]=="Y")?"<span class=\"mustItem\">":"";?> <?=$LNG_TRANS_CHAR["MW00076"] //도시?><?=($S_JOIN_ADDR["NES"]=="Y")?"</span>":"";?></th>
				<td>
					<dl>
						<dd><input type="input" id="city" name="city" class="defInput _w300" maxlength="200"/></dd>
					</dl>
				</td>
			</tr>
			<tr>
				<th><?=$LNG_TRANS_CHAR["MW00077"] //주?> </th>
				<td>
					<div id="divState1" <?=($memberRow[M_COUNTRY]=="US")?"style=\"display:none\"":"";?>>
						<input type="input" id="state_1" name="state_1" value="N/A" class="defInput _w200" maxlength="50" value="<?=$memberRow[M_STATE]?>"/>
					</div>
					<div id="divState2" <?=($memberRow[M_COUNTRY]!="US")?"style=\"display:none\"":"";?>>
						<?=drawSelectBoxMore("state_2",$aryCountryState,$memberRow[M_STATE],$design="",$onchange="",$etc="",$firstItem="= State =",$html="N")?>
					</div>
				</td>
			</tr>
			<tr>
				<th><?=($S_JOIN_ADDR["NES"]=="Y")?"<span class=\"mustItem\">":"";?> <?=$LNG_TRANS_CHAR["MW00078"] //우편번호?><?=($S_JOIN_ADDR["NES"]=="Y")?"</span>":"";?> </th>
				<td>
					<dl>
						<dd><input type="input" id="zip1" name="zip1" class="defInput _w100" maxlength="20"></dd>
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
				<th><?=($S_JOIN_PHOTO["NES"]=="Y")?"<span class=\"mustItem\">":"";?> <?=$LNG_TRANS_CHAR["MW00080"] //사진?><?=($S_JOIN_PHOTO["NES"]=="Y")?"</span>":"";?></th>
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
				<th><?=($S_JOIN_REC["NES"]=="Y")?"<span class=\"mustItem\">":"";?> <?=$LNG_TRANS_CHAR["MW00070"] //추천인?><?=($S_JOIN_REC["NES"]=="Y")?"</span>":"";?></th>
				<td>
					<input type="input" id="rec_id" name="rec_id" class="defInput" maxlength="50"/>
				</td>
			</tr>
				<?}?>
			<?}?>
			<!-- 추천인 -->
			<!-- 회사명 -->
			<?if ($S_JOIN_COM["USE"] == "Y" && $S_JOIN_COM["JOIN"] == "Y"){?>
				<?if (!$S_JOIN_COM["GRADE"] || in_array($strMemberJoinType,$S_JOIN_COM["GRADE"])){?>
			<tr>
				<th><?=($S_JOIN_COM["NES"]=="Y")?"<span class=\"mustItem\">":"";?> <?=$LNG_TRANS_CHAR["MW00081"] //회사명?><?=($S_JOIN_COM["NES"]=="Y")?"</span>":"";?></th>
				<td>
					<input type="input" id="com_nm" name="com_nm" class="defInput" maxlength="50"/>
				</td>
			</tr>
				<?}?>
			<?}?>
			<!-- 회사명 -->
			<?if ($S_JOIN_TMP_1["USE"] == "Y" && $S_JOIN_TMP_1["JOIN"] == "Y"){?>
				<?if (!$S_JOIN_TMP_1["GRADE"] || in_array($strMemberJoinType,$S_JOIN_TMP_1["GRADE"])){?>
			<tr>
				<th><?=($S_JOIN_TMP_1["NES"]=="Y")?"<span class=\"mustItem\">":"";?> <?=$S_JOIN_TMP_1["NAME_".$S_SITE_LNG] //임시필드?><?=($S_JOIN_TMP_1["NES"]=="Y")?"</span>":"";?></th>
				<td>
					<input type="input" id="tmp1" name="tmp1" class="defInput _w200" maxlength="50"/>
				</td>
			</tr>
				<?}?>
			<?}?>
			<?if ($S_JOIN_TMP_2["USE"] == "Y" && $S_JOIN_TMP_2["JOIN"] == "Y"){?>
				<?if (!$S_JOIN_TMP_2["GRADE"] || in_array($strMemberJoinType,$S_JOIN_TMP_2["GRADE"])){?>
			<tr>
				<th><?=($S_JOIN_TMP_2["NES"]=="Y")?"<span class=\"mustItem\">":"";?> <?=$S_JOIN_TMP_2["NAME_".$S_SITE_LNG] //임시필드?><?=($S_JOIN_TMP_2["NES"]=="Y")?"</span>":"";?></th>
				<td>
					<input type="input" id="tmp2" name="tmp2" class="defInput _w200" maxlength="50"/>
				</td>
			</tr>
				<?}?>
			<?}?>
			<?if ($S_JOIN_TMP_3["USE"] == "Y" && $S_JOIN_TMP_3["JOIN"] == "Y"){?>
				<?if (!$S_JOIN_TMP_3["GRADE"] || in_array($strMemberJoinType,$S_JOIN_TMP_3["GRADE"])){?>
			<tr>
				<th><?=($S_JOIN_TMP_3["NES"]=="Y")?"<span class=\"mustItem\">":"";?> <?=$S_JOIN_TMP_4["NAME_".$S_SITE_LNG] //임시필드?><?=($S_JOIN_TMP_3["NES"]=="Y")?"</span>":"";?></th>
				<td>
					<input type="input" id="tmp3" name="tmp3" class="defInput _w200" maxlength="50"/>
				</td>
			</tr>
				<?}?>
			<?}?>
			<?if ($S_JOIN_TMP_4["USE"] == "Y" && $S_JOIN_TMP_4["JOIN"] == "Y"){?>
				<?if (!$S_JOIN_TMP_4["GRADE"] || in_array($strMemberJoinType,$S_JOIN_TMP_4["GRADE"])){?>
			<tr>
				<th><?=($S_JOIN_TMP_4["NES"]=="Y")?"<span class=\"mustItem\">":"";?> <?=$S_JOIN_TMP_4["NAME_".$S_SITE_LNG] //임시필드?><?=($S_JOIN_TMP_4["NES"]=="Y")?"</span>":"";?></th>
				<td>
					<input type="input" id="tmp4" name="tmp4" class="defInput _w200" maxlength="50"/>
				</td>
			</tr>
				<?}?>
			<?}?>
			<?if ($S_JOIN_TMP_5["USE"] == "Y" && $S_JOIN_TMP_5["JOIN"] == "Y"){?>
				<?if (!$S_JOIN_TMP_5["GRADE"] || in_array($strMemberJoinType,$S_JOIN_TMP_5["GRADE"])){?>
			<tr>
				<th><?=($S_JOIN_TMP_5["NES"]=="Y")?"<span class=\"mustItem\">":"";?> <?=$S_JOIN_TMP_5["NAME_".$S_SITE_LNG] //임시필드?><?=($S_JOIN_TMP_5["NES"]=="Y")?"</span>":"";?></th>
				<td>
					<input type="input" id="tmp5" name="tmp5" class="defInput _w200" maxlength="50"/>
				</td>
			</tr>
				<?}?>
			<?}?>
			<tr>
				<th><span class="mustItem"> 보안문자</th>
				<td><input type="text" style="width:100px;"></td>
			</tr>
			<!--임시필드-->
		</table>
	</div>
	<?if ($S_JOIN_BUSI_INFO["USE"] == "Y"){?>
	<h4 class="mt30  comView" style="display:none"><?=$LNG_TRANS_CHAR["MW00082"] //사업자정보?></h4>
	<div class="tableForm  comView" style="display:none">
		<table>
			<colgroup>
				<col style="width:110px;"/>
				<col/>
			</colgroup>
			<!-- 상호명 -->
			<?if ($S_JOIN_BUSI_NM["USE"] == "Y" && $S_JOIN_BUSI_NM["MYPAGE"] == "Y"){?>
				<?if (!$S_JOIN_BUSI_NM["GRADE"] || in_array($strMemberJoinType,$S_JOIN_BUSI_NM["GRADE"])){?>
			<tr>
				<th><?=$LNG_TRANS_CHAR["MW00083"] //상호명?></th>
				<td>
					<input type="input" id="busi_nm" name="busi_nm" class="defInput" maxlength="50" value="<?=$row[BUSI_NM]?>"/>
				</td>
			</tr>
				<?}?>
			<?}?>
			<!-- 상호명 -->
			<!-- 사업자번호 -->
			<?if ($S_JOIN_BUSI_NUM["USE"] == "Y" && $S_JOIN_BUSI_NUM["MYPAGE"] == "Y"){?>
				<?if (!$S_JOIN_BUSI_NUM["GRADE"] || in_array($strMemberJoinType,$S_JOIN_BUSI_NUM["GRADE"])){?>
			<tr>
				<th><?=$LNG_TRANS_CHAR["MW00084"] //사업자번호?></th>
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
				<th><?=$LNG_TRANS_CHAR["MW00085"] //업종?></th>
				<td><input type="input" id="busi_upj" name="busi_upj" class="defInput" maxlength="50" value="<?=$row[BUSI_UPJ]?>"/></td>
			</tr>
				<?}?>
			<?}?>
			<!-- 업종 -->
			<!-- 업태 -->
			<?if ($S_JOIN_BUSI_UPTAE["USE"] == "Y" && $S_JOIN_BUSI_UPTAE["MYPAGE"] == "Y"){?>
				<?if (!$S_JOIN_BUSI_UPTAE["GRADE"] || in_array($strMemberJoinType,$S_JOIN_BUSI_UPTAE["GRADE"])){?>
			<tr>
				<th><?=$LNG_TRANS_CHAR["MW00086"] //업태?></th>
				<td><input type="input" id="busi_ute" name="busi_ute" class="defInput" maxlength="50" value="<?=$row[BUSI_UTE]?>"/></td>
			</tr>
				<?}?>
			<?}?>
			<!-- 업태 -->
			<!-- 주소 -->
			<?if ($S_JOIN_BUSI_ADDR["USE"] == "Y" && $S_JOIN_BUSI_ADDR["MYPAGE"] == "Y"){?>
				<?if (!$S_JOIN_BUSI_ADDR["GRADE"] || in_array($strMemberJoinType,$S_JOIN_BUSI_ADDR["GRADE"])){?>
			<tr>
				<th><?=$LNG_TRANS_CHAR["MW00019"] //주소?></th>
				<td>
					<dl>
						<dd><input type="input" id="busi_zip1" name="busi_zip1" class="defInput _w30" maxlength="3" readonly value="<?=$aryMemBusiZip[0]?>"/> - <input type="input" id="busi_zip2" name="busi_zip2" class="defInput _w30" maxlength="3" readonly value="<?=$aryMemBusiZip[1]?>"/> <a href="javascript:goZip(4);" class="btn_TdinChk">우편번호검색</a></dd>
						<dd><input type="input" id="busi_addr1" name="busi_addr1" class="defInput _w300" maxlength="200" readonly value="<?=$row[BUSI_ADDR1]?>"/></dd>
						<dd><input type="input" id="busi_addr2" name="busi_addr2" class="defInput _w300" maxlength="200" value="<?=$row[BUSI_ADDR2]?>"/></dd>
					</dl>
				</td>
			</tr>
				<?}?>
			<?}?>
			<!-- 주소 -->
		</table>
	</div>

	<?}?>

	<?if ($S_JOIN_ADD_WED["USE"] == "Y" || $S_JOIN_ADD_WED_DAY["USE"] == "Y" || $S_JOIN_ADD_CHILD["USE"] == "Y" || $S_JOIN_ADD_JOB["USE"] == "Y" || $S_JOIN_ADD_CONCERN["USE"] == "Y" || $S_JOIN_ADD_TEXT["USE"] == "Y"){?> 
	<h3 class="mt30">추가정보</h3>
	<div class="tableFormWrap">

		<table class="tableForm">
			<colgroup>
				<col style="width:110px;"/>
				<col/>
			</colgroup>
			<!-- 관심분야 -->
			<?if ($S_JOIN_ADD_CONCERN["USE"] == "Y" && $S_JOIN_ADD_CONCERN["JOIN"] == "Y"){?>
				<?if (!$S_JOIN_ADD_CONCERN["GRADE"] || in_array($strMemberJoinType,$S_JOIN_ADD_CONCERN["GRADE"])){?>
			<tr>
				<th><?=($S_JOIN_ADD_CONCERN["NES"]=="Y")?"<strong>*</strong>":"<strong></strong>";?> 관심분야</th>
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
			<?if ($S_JOIN_ADD_TEXT["USE"] == "Y" && $S_JOIN_ADD_TEXT["MYPAGE"] == "Y"){?>
				<?if (!$S_JOIN_ADD_TEXT["GRADE"] || in_array($strMemberJoinType,$S_JOIN_ADD_TEXT["GRADE"])){?>
			<tr>
				<th><?=$LNG_TRANS_CHAR["MW00092"] //남기는 말씀?></th>
				<td><?=$row[M_TEXT]?></td>
			</tr>
				<?}?>
			<?}?>
			<!-- 남기는 말씀 -->
		</table>
	</div>
	<?}?>
	
	<? 
	if ($S_FIX_MEMBER_CATE_USE_YN == "Y"){
	?>
	<h3 class="mt30">추가정보</h4>
	<div class="tableForm">
		<? include "../layout/member/admin_member_cate_join.php";?>
	</div>
	<?}?>
	<div class="buttonBoxWrap">
		<a class="btn_new_blue" href="javascript:goJoin();" id="menu_auth_w"><strong class="ico_write"><?=$LNG_TRANS_CHAR["CW00002"] //등록?></strong></a>
	</div>
	
</div>
<!-- ******** 컨텐츠 ********* -->