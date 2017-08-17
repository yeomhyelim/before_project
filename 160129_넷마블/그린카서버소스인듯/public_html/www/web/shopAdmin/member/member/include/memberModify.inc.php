<?
	/*상품함수관련*/
	require_once MALL_PROD_FUNC;
	
	if (!$intM_NO){
		$db->disConnect();
		goClose($LNG_TRANS_CHAR["CS00013"]); //"해당 회원정보가 존재하지 않습니다."
		exit;
	}

	/* 관리자 Sub Menu 권한 설정 */
	$strTopMenuCode	   = "003";
	$strLeftMenuCode01 = "001";
	$strLeftMenuCode02 = "001";
	/* 관리자 Sub Menu 권한 설정 */

	$memberMgr->setM_NO($intM_NO);
	$row = $memberMgr->getMemberView($db);

	$aryMemberGroup = $memberMgr->getGroupList($db);

	$aryPhone	= explode("-",$row[M_PHONE]);
	$aryHp		= explode("-",$row[M_HP]);
	$aryZip		= explode("-",$row[M_ZIP]);

	$aryCountryList		= getCountryList();			
	$aryCountryState	= getCommCodeList("STATE","");

	$aryJob		= getCommCodeList("JOB");
	$aryConcern	= getCommCodeList("CONCERN");

	$aryJoinConcern = explode(",",$row[M_CONCERN]);
	$strConcern = "";
	if ($row[M_CONCERN] && is_array($aryJoinConcern)){
		
		for($i=0;$i<sizeof($aryJoinConcern);$i++){
			$strConcern .= $aryConcern[$aryJoinConcern[$i]].",";
		}
		echo substr($strConcern,0,strlen($strConcern)-1);
	}

	$strJob = $aryJob[$row[M_JOB]];

	// setting
	if(!$row['M_BUY_PRICE'])	{ $row['M_BUY_PRICE'] = 0; }
	if(!$row['M_BUY_CNT'])		{ $row['M_BUY_CNT'] = 0; }

	/* 가족관계 */
	if ($S_MEM_FAMILY == "Y"){
		$memberMgr->setJI_GB("M");
		$aryFamilyItemList = $memberMgr->getJoinItemList($db);
		$aryMemberFamilyList = $memberMgr->getMemberFamilyList($db);
		
	}

	$aryMemBusiNum		= explode("-",$row[M_BUSI_NUM]);
	$aryMemBusiZip		= explode("-",$row[M_BUSI_ZIP]);

?>

<style type="text/css">
	#contentArea{position:relative;min-width:450px;padding:10px}
</style>
<script type="text/javascript">
<!--
	$(document).ready(function(){
		C_CallMenuAuthBtn("<?=$a_admin_no?>","<?=$strTopMenuCode?>","<?=$strLeftMenuCode01?>","<?=$strLeftMenuCode02?>");
		
		$("#country").change(function(){
			var strVal	= $("#country option:selected").val();
				
			$("#divState1").css("display","block");
			$("#divState2").css("display","none");
			if (strVal == "US")
			{
				$("#divState1").css("display","none");
				$("#divState2").css("display","block");
			}
		});
	});
	
	function goZip(num)
	{
		window.open('?menuType=popup&mode=address&num='+num,'new','width=520px,height=450px,top=300px,left=400px,menubar=no,location=no,scrollbars=yes,status=no,resizable=no');
	}

	function goMemberAct(mode)
	{
		C_getAction(mode,"<?=$PHP_SELF?>");
	}
//-->
</script>

<div id="contentArea">
	<div class="tableForm">
		<table>
			<!--아이디-->
			<?if ($S_MEM_CERITY == "1"){?>
				<?if ($S_JOIN_ID["USE"] == "Y" && $S_JOIN_ID["MYPAGE"] == "Y"){?>
					<?if (!$S_JOIN_ID["GRADE"] || in_array($strMemberJoinType,$S_JOIN_ID["GRADE"])){?>
			<tr>
				<th><?=$LNG_TRANS_CHAR["CW00024"] //아이디?></th>
				<td colspan="3">
					<?=$row[M_ID]?>
				</td>
			</tr>
					<?}?>
				<?}?>
			<?}?>
			<!--아이디-->

			<!--이름-->
			<?if ($S_JOIN_NAME["USE"] == "Y" && $S_JOIN_NAME["MYPAGE"] == "Y"){?>
				<?if (!$S_JOIN_NAME["GRADE"] || in_array($strMemberJoinType,$S_JOIN_NAME["GRADE"])){?>
			<tr>
				<th><?=$LNG_TRANS_CHAR["MW00002"] //이름?> </th>
				<td colspan="3"><?=$row[M_NAME]?></td>
			</tr>
				<?}?>
			<?}?>
			<!--이름-->

			<!--비밀번호-->
			<?if ($S_JOIN_PASS["USE"] == "Y" && $S_JOIN_PASS["MYPAGE"] == "Y"){?>
				<?if (!$S_JOIN_PASS["GRADE"] || in_array($strMemberJoinType,$S_JOIN_PASS["GRADE"])){?>
			<tr>
				<th><?=$LNG_TRANS_CHAR["MW00011"] //비밀번호?> </th>
				<td colspan="3"><input type="password" <?=$nBox?>  style="width:150px;" id="pwd" name="pwd" value="" maxlength="20"/></td>
			</tr>
				<?}?>
			<?}?>
			<!--비밀번호-->
			
			<!--이름-->
			<!-- 닉네임 -->
			<?if ($S_JOIN_NICKNAME["USE"] == "Y" && $S_JOIN_NICKNAME["MYPAGE"] == "Y"){?>
				<?if (!$S_JOIN_NICKNAME["GRADE"] || in_array($strMemberJoinType,$S_JOIN_NICKNAME["GRADE"])){?>
			<tr>
				<th><?=$LNG_TRANS_CHAR["MW00071"] //닉네임?></th>
				<td colspan="3">
					<?=$row[M_NICK_NAME]?>
				</td>
			</tr>
				<?}?>
			<?}?>
			<!-- 닉네임 -->
			<!-- 생년월일/음력/양력 -->
			<?if ($S_JOIN_BIRTH["USE"] == "Y" && $S_JOIN_BIRTH["MYPAGE"] == "Y"){?>
				<?if (!$S_JOIN_BIRTH["GRADE"] || in_array($strMemberJoinType,$S_JOIN_BIRTH["GRADE"])){?>
			<tr>
				<th><?=$LNG_TRANS_CHAR["MW00012"] //생년월일?></th>
				<td colspan="3">
					<?=$row[M_BIRTH]?>
					<?if ($S_JOIN_BIRTH_CAL["USE"] == "Y" && $S_JOIN_BIRTH_CAL["MYPAGE"] == "Y"){?>
						<?if (!$S_JOIN_BIRTH_CAL["GRADE"] || in_array($strMemberJoinType,$S_JOIN_BIRTH_CAL["GRADE"])){?>
							<?=($row[M_BIRTH_CAL]=="1")?$LNG_TRANS_CHAR["MW00072"]:$LNG_TRANS_CHAR["MW00073"];?>
						<?}?>
					<?}?>

					<!-- 성별 -->
					<?if ($S_JOIN_SEX["USE"] == "Y" && $S_JOIN_SEX["MYPAGE"] == "Y"){?>
						<?if (!$S_JOIN_SEX["GRADE"] || in_array($strMemberJoinType,$S_JOIN_SEX["GRADE"])){?>
				
						[<?=$LNG_TRANS_CHAR["MW00013"] //성별?>:
							<?=($row[M_SEX]=="M")?$LNG_TRANS_CHAR["MW00024"]:"";?>
							<?=($row[M_SEX]=="W")?$LNG_TRANS_CHAR["MW00025"]:"";?>]
				
						<?}?>
					<?}?>
					<!-- 성별 -->
				</td>
			</tr>
				<?}?>
			<?}?>
			
			<!-- 핸드폰 -->
			<?if ($S_JOIN_HP["USE"] == "Y" && $S_JOIN_HP["MYPAGE"] == "Y"){?>
				<?if (!$S_JOIN_HP["GRADE"] || in_array($strMemberJoinType,$S_JOIN_HP["GRADE"])){?>
			<tr>
				<th><?=$LNG_TRANS_CHAR["MW00016"] //핸드폰?> </th>
				<td colspan="3">
					<input type="text" <?=$nBox?>  style="width:150px;" id="hp1" name="hp1" value="<?=$row[M_HP]?>" maxlength="30"/>
					<?if ($S_JOIN_SMSYN["USE"] == "Y" && $S_JOIN_SMSYN["MYPAGE"] == "Y"){?>
						<?if (!$S_JOIN_SMSYN["GRADE"] || in_array($strMemberJoinType,$S_JOIN_SMSYN["GRADE"])){?>
					<span><input type="checkbox" name="smsYN" id="smsYN" value="Y" <?=($row[M_SMSYN]=="Y")?"checked":"";?>/> <?=$LNG_TRANS_CHAR["MW00017"] //SMS 정보를 수신합니다.?> </span>
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
				<th><?=$LNG_TRANS_CHAR["MW00010"] //전화번호?></th>
				<td colspan="3">
					<input type="text" <?=$nBox?>  style="width:150px;" id="phone1" name="phone1" value="<?=$row[M_PHONE]?>" maxlength="30"/>
				</td>
			</tr>
				<?}?>
			<?}?>
			<!-- 전화번호 -->
			<!-- 팩스번호 -->
			<?if ($S_JOIN_FAX["USE"] == "Y" && $S_JOIN_FAX["MYPAGE"] == "Y"){?>
				<?if (!$S_JOIN_FAX["GRADE"] || in_array($strMemberJoinType,$S_JOIN_FAX["GRADE"])){?>
			<tr>
				<th><?=$LNG_TRANS_CHAR["MW00074"] //팩스번호?></th>
				<td colspan="3">
					<input type="text" <?=$nBox?>  style="width:150px;" id="fax1" name="fax1" value="<?=$row[M_FAX]?>" maxlength="30"/>
				</td>
			</tr>
				<?}?>
			<?}?>
			<!-- 팩스번호 -->
			<!-- 이메일 -->
			<?if ($S_JOIN_MAIL["USE"] == "Y" && $S_JOIN_MAIL["MYPAGE"] == "Y"){?>
				<?if (!$S_JOIN_MAIL["GRADE"] || in_array($strMemberJoinType,$S_JOIN_MAIL["GRADE"])){?>
			<tr>
				<th><?=$LNG_TRANS_CHAR["MW00003"] //이메일?> </th>
				<td colspan="3">
					<input type="input" id="mail" name="mail" class="defInput _w300" maxlength="30" value="<?=$row[M_MAIL]?>" <?=($S_MEM_CERITY=="2")?"readonly":"";?>/>
					<?if ($S_JOIN_MAILYN["USE"] == "Y" && $S_JOIN_MAILYN["MYPAGE"] == "Y"){?>
						<?if (!$S_JOIN_MAILYN["GRADE"] || in_array($strMemberJoinType,$S_JOIN_MAILYN["GRADE"])){?>
					<span><input type="checkbox" id="mailYN" name="mailYN" value="Y" <?=($row[M_MAILYN]=="Y")?"checked":"";?>/> <?=$LNG_TRANS_CHAR["MW00018"] //메일 정보를 수신합니다.?> </span>
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
			<?if($S_USE_LNG!="KR"):?>
			<tr>
				<th><?=$LNG_TRANS_CHAR["MW00075"] //국가?> </th>
				<td colspan="3">
					<?=$aryCountryList[$row[M_COUNTRY]]?>
				</td>
			</tr>
			<?endif;?>
			<tr>
				<th><?=$LNG_TRANS_CHAR["MW00019"] //주소?> </th>
				<td colspan="3">
					<ul>
						<li><?=$LNG_TRANS_CHAR["MW00078"] //우편번호?> [ <?=$row[M_ZIP]?> ]</li> 
						<li><?=$row[M_ADDR]?> <?=$row[M_ADDR2]?></li>
					</ul>
				</td>
			</tr>
			<?if($S_USE_LNG!="KR"):?>
			<tr>
				<th><?=$LNG_TRANS_CHAR["MW00076"] //도시?> </th>
				<td colspan="3">
					<?=$LNG_TRANS_CHAR["MW00076"] //도시?>: <?=$row[M_CITY]?> / <?=$LNG_TRANS_CHAR["MW00077"] //주?>: <?=($row[M_COUNTRY]=="US") ? $aryCountryState[$row[M_STATE]]:$row[M_STATE];?>
				</td>
			</tr>
			<?endif;?>
				<?}?>
			<?}?>
			<!-- 주소 -->
			<!-- 사진 -->
			<?if ($S_JOIN_PHOTO["USE"] == "Y" && $S_JOIN_PHOTO["MYPAGE"] == "Y"){?>
				<?if (!$S_JOIN_PHOTO["GRADE"] || in_array($strMemberJoinType,$S_JOIN_PHOTO["GRADE"])){?>
				<tr>
					<th><?=$LNG_TRANS_CHAR["MW00080"] //사진?></th>
					<td colspan="3">
						<?=($row[M_PHOTO])?"<img src=\"../upload/member/".$row[M_PHOTO]."\" border=\"0\" style=\"width:100px;height:100px\">":"";?>
					</td>
				</tr>
				<?}?>
			<?}?>
			<!-- 사진 -->
			<!-- 추천인 -->
			<?if ($S_JOIN_REC["USE"] == "Y" && $S_JOIN_REC["MYPAGE"] == "Y"){?>
				<?if (!$S_JOIN_REC["GRADE"] || in_array($strMemberJoinType,$S_JOIN_REC["GRADE"])){?>
				<tr>
					<th><?=$LNG_TRANS_CHAR["MW00070"] //추천인?></th>
					<td colspan="3">
						<?=$row[M_REC_NAME]?>
					</td>
				</tr>
				<?}?>
			<?}?>
			<!-- 추천인 -->
			<!-- 회사명 -->
			<?if ($S_JOIN_COM["USE"] == "Y" && $S_JOIN_COM["MYPAGE"] == "Y"){?>
				<?if (!$S_JOIN_COM["GRADE"] || in_array($strMemberJoinType,$S_JOIN_COM["GRADE"])){?>
				<tr>
					<th><?=$LNG_TRANS_CHAR["MW00081"] //회사명?></th>
					<td colspan="3">
						<?=$row[M_COM_NM]?>
					</td>
				</tr>
				<?}?>
			<?}?>
			<!-- 회사명 -->
			<!-- TM_ID -->
			<?if ($S_JOIN_TM_ID["USE"] == "Y" && $S_JOIN_TM_ID["MYPAGE"] == "Y"){?>
				<?if (!$S_JOIN_TM_ID["GRADE"] || in_array($strMemberJoinType,$S_JOIN_TM_ID["GRADE"])){?>
			<tr>
				<th><?=$S_JOIN_TM_ID["NAME_KR"]?></th>
				<td colspan="3">
					<input type="input" id="tm_id" name="tm_id" style="width:150px;" maxlength="20" value="<?=$row[M_TM_ID]?>"/>
				</td>
			</tr>
				<?}?>
			<?}?>
			<!-- TM_ID -->
			<tr>
				<th><?=$LNG_TRANS_CHAR["MW00006"] //그룹?></th>
				<td>
					<select name="group" id="group">
					<?
						if (is_array($aryMemberGroup)){
							for($i=0;$i<sizeof($aryMemberGroup);$i++){
								if ($aryMemberGroup[$i][G_CODE] != "001"){
									$strSelected = ($row[M_GROUP] == $aryMemberGroup[$i][G_CODE]) ? "selected":"";

									echo "<option value=\"".$aryMemberGroup[$i][G_CODE]."\"".$strSelected.">".$aryMemberGroup[$i][G_NAME]."</option>";
								}
							}
						}
					?>
					</select>
				</td>
				<th><?=$LNG_TRANS_CHAR["CW00006"] //승인?></th>
				<td>
					<?=($row[M_AUTH]=="Y")?$LNG_TRANS_CHAR["CW00006"]:$LNG_TRANS_CHAR["CW00040"]; //승인/미승인?>
				</td>
			</tr>
			<tr>
				<th><?=$LNG_TRANS_CHAR["CW00034"] //포인트?></th>
				<td>
					<?=getCurMark($S_ST_CUR)?><?=getFormatPrice($row[M_POINT],2)?><?=getCurMark2($S_ST_CUR)?>
				</td>
				<th><?=$LNG_TRANS_CHAR["MW00021"] //총구매금액?></th>
				<td>
					<?=getCurMark($S_ST_CUR)?><?=number_format($row[M_BUY_PRICE]);?><?=getCurMark2($S_ST_CUR)?>
				</td>
			</tr>
			<tr>
				<th><?=$LNG_TRANS_CHAR["MW00022"] //총구매횟수?></th>
				<td>
					<?=$row[M_BUY_CNT]?>회
				</td>
				<th><?=$LNG_TRANS_CHAR["MW00023"] //총방문횟수?></th>
				<td>
					<?=$row[M_VISIT_CNT]?>회
				</td>
			</tr>
			<?
				if ($row[M_OUT] == "Y") {
			?>
			<tr>
				<th><?=$LNG_TRANS_CHAR["MW00009"] //회원탈퇴및삭제일?></th>
				<td colspan="3">
					<?=$row[M_OUT_DT]?>
				</td>
			</tr>
			<?
				}	
			?>
		</table>
	</div>
	<?//if ($S_JOIN_BUSI_INFO["USE"] == "Y"){?>
	<?
	//사업자정보가 다른 테이블임.
	if (false){?>
	<h4 class="mt30"><?=$LNG_TRANS_CHAR["MW00082"] //사업자정보?></h4>
	<div class="tableForm">
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
					<input type="input" id="busi_nm" name="busi_nm" class="defInput" maxlength="50" value="<?=$row[M_BUSI_NM]?>"/>
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
					<input type="input" id="busi_num3" name="busi_num3" class="defInput" maxlength="5" value="<?=$aryMemBusiNum[2]?>"/>
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
				<td><input type="input" id="busi_upj" name="busi_upj" class="defInput" maxlength="50" value="<?=$row[M_BUSI_UPJ]?>"/></td>
			</tr>
				<?}?>
			<?}?>
			<!-- 업종 -->
			<!-- 업태 -->
			<?if ($S_JOIN_BUSI_UPTAE["USE"] == "Y" && $S_JOIN_BUSI_UPTAE["MYPAGE"] == "Y"){?>
				<?if (!$S_JOIN_BUSI_UPTAE["GRADE"] || in_array($strMemberJoinType,$S_JOIN_BUSI_UPTAE["GRADE"])){?>
			<tr>
				<th><?=$LNG_TRANS_CHAR["MW00086"] //업태?></th>
				<td><input type="input" id="busi_ute" name="busi_ute" class="defInput" maxlength="50" value="<?=$row[M_BUSI_UTE]?>"/></td>
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
						<dd><input type="input" id="busi_zip1" name="busi_zip1" class="defInput _w30" maxlength="3" readonly value="<?=$aryMemBusiZip[0]?>"/> - <input type="input" id="busi_zip2" name="busi_zip2" class="defInput _w30" maxlength="3" readonly value="<?=$aryMemBusiZip[1]?>"/> <a href="javascript:goZip(5);"><img src="/himg/member/A0001/<?=$S_SITE_LNG_PATH?>/btn_search_zip.gif"/></a></dd>
						<dd><input type="input" id="busi_addr1" name="busi_addr1" class="defInput _w300" maxlength="200" readonly value="<?=$row[M_BUSI_ADDR1]?>"/></dd>
						<dd><input type="input" id="busi_addr2" name="busi_addr2" class="defInput _w300" maxlength="200" value="<?=$row[M_BUSI_ADDR2]?>"/></dd>
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
	<h4 class="mt30"><?=$LNG_TRANS_CHAR["MW00161"] //추가정보?></h4>
	<div class="tableForm">

		<table>
			<colgroup>
				<col style="width:110px;"/>
				<col/>
			</colgroup>
			<!-- 결혼여부 -->
			<?if ($S_JOIN_ADD_WED["USE"] == "Y" && $S_JOIN_ADD_WED["MYPAGE"] == "Y"){?>
				<?if (!$S_JOIN_ADD_WED["GRADE"] || in_array($strMemberJoinType,$S_JOIN_ADD_WED["GRADE"])){?>
			<tr>
				<th><?=$LNG_TRANS_CHAR["MW00087"] //결혼여부?></th>
				<td>
					<?=($row[M_WED] == "Y")?$LNG_TRANS_CHAR["MW00094"]:$LNG_TRANS_CHAR["MW00093"];?>
				</td>
			</tr>
				<?}?>
			<?}?>
			<!-- 결혼여부 -->
			<!-- 결혼기념일 -->
			<?if ($S_JOIN_ADD_WED_DAY["USE"] == "Y" && $S_JOIN_ADD_WED_DAY["MYPAGE"] == "Y"){?>
				<?if (!$S_JOIN_ADD_WED_DAY["GRADE"] || in_array($strMemberJoinType,$S_JOIN_ADD_WED_DAY["GRADE"])){?>
			<tr>
				<th><?=$LNG_TRANS_CHAR["MW00088"] //결혼기념일?></th>
				<td>
					<?=$row[M_WED_DAY]?>
				</td>
			</tr>
				<?}?>
			<?}?>
			<!-- 결혼기념일 -->
			<!-- 자녀 -->
			<?if ($S_JOIN_ADD_CHILD["USE"] == "Y" && $S_JOIN_ADD_CHILD["MYPAGE"] == "Y"){?>
				<?if (!$S_JOIN_ADD_CHILD["GRADE"] || in_array($strMemberJoinType,$S_JOIN_ADD_CHILD["GRADE"])){?>
			<tr>
				<th><?=$LNG_TRANS_CHAR["MW00089"] //자녀수?></th>
				<td>
					<?=$row[M_CHILD]?>
				</td>
			</tr>
				<?}?>
			<?}?>
			<!-- 자녀 -->
			<!-- 직업 -->
			<?if ($S_JOIN_ADD_JOB["USE"] == "Y" && $S_JOIN_ADD_JOB["MYPAGE"] == "Y"){?>
				<?if (!$S_JOIN_ADD_JOB["GRADE"] || in_array($strMemberJoinType,$S_JOIN_ADD_JOB["GRADE"])){?>
			<tr>
				<th><?=$LNG_TRANS_CHAR["MW00090"] //직업?></th>
				<td>
					<?=$strJob?>
				</td>
			</tr>
				<?}?>
			<?}?>
			<!-- 직업 -->
			<!-- 관심분야 -->
			<?if ($S_JOIN_ADD_CONCERN["USE"] == "Y" && $S_JOIN_ADD_CONCERN["MYPAGE"] == "Y"){?>
				<?if (!$S_JOIN_ADD_CONCERN["GRADE"] || in_array($strMemberJoinType,$S_JOIN_ADD_CONCERN["GRADE"])){?>
			<tr>
				<th><?=$LNG_TRANS_CHAR["MW00091"] //관심분야?></th>
				<td>
					<?=$strConcern?>
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
	<?if ($S_JOIN_TMP_1["USE"] == "Y" || $S_JOIN_TMP_2["USE"] == "Y" || $S_JOIN_TMP_3["USE"] == "Y" || $S_JOIN_TMP_4["USE"] == "Y" || $S_JOIN_TMP_5["USE"] == "Y"){?> 
	<div>
	<h4 class="mt30"><?=$LNG_TRANS_CHAR["MW00161"] //추가정보?></h4>
	<div class="tableForm">
		<table>
			<colgroup>
				<col style="width:110px;"/>
				<col/>
			</colgroup>
			<!-- TMP1 -->
			<?if ($S_JOIN_TMP_1["USE"] == "Y"){?>
				<?if (!$S_JOIN_TMP_1["GRADE"] || in_array($strMemberJoinType,$S_JOIN_TMP_1["GRADE"])){?>
			<tr>
				<th><?=$S_JOIN_TMP_1["NAME_".$strAdmSiteLng]?></th>
				<td>
					<?=$row['M_TMP1']?>
				</td>
			</tr>
				<?}?>
			<?}?>
			<!-- TMP2 -->
			<?if ($S_JOIN_TMP_2["USE"] == "Y"){?>
				<?if (!$S_JOIN_TMP_2["GRADE"] || in_array($strMemberJoinType,$S_JOIN_TMP_2["GRADE"])){?>
			<tr>
				<th><?=$S_JOIN_TMP_2["NAME_".$strAdmSiteLng]?></th>
				<td>
					<?=$row['M_TMP2']?>
				</td>
			</tr>
				<?}?>
			<?}?>
			<!-- TMP3 -->
			<?if ($S_JOIN_TMP_3["USE"] == "Y"){?>
				<?if (!$S_JOIN_TMP_3["GRADE"] || in_array($strMemberJoinType,$S_JOIN_TMP_3["GRADE"])){?>
			<tr>
				<th><?=$S_JOIN_TMP_3["NAME_".$strAdmSiteLng]?></th>
				<td>
					<?=$row['M_TMP3']?>
				</td>
			</tr>
				<?}?>
			<?}?>
			<!-- TMP4 -->
			<?if ($S_JOIN_TMP_4["USE"] == "Y"){?>
				<?if (!$S_JOIN_TMP_4["GRADE"] || in_array($strMemberJoinType,$S_JOIN_TMP_4["GRADE"])){?>
			<tr>
				<th><?=$S_JOIN_TMP_4["NAME_".$strAdmSiteLng]?></th>
				<td>
					<?=$row['M_TMP4']?>
				</td>
			</tr>
				<?}?>
			<?}?>
			<!-- TMP5 -->
			<?if ($S_JOIN_TMP_5["USE"] == "Y"){?>
				<?if (!$S_JOIN_TMP_5["GRADE"] || in_array($strMemberJoinType,$S_JOIN_TMP_5["GRADE"])){?>
			<tr>
				<th><?=$S_JOIN_TMP_5["NAME_".$strAdmSiteLng]?></th>
				<td>
					<?=$row['M_TMP5']?>
				</td>
			</tr>
				<?}?>
			<?}?>

		</table>
	</div>
	<?}?>
	<?if ($S_MEM_FAMILY == "Y"){?>
		<?include "../layout/member/member_family_info.inc.php";?>
	<?}?>
	<div class="btnCenter">
		<a class="btn_Big_Blue" href="javascript:goMemberAct('memberModify');" id="menu_auth_m" style="display:none"><strong><?=$LNG_TRANS_CHAR["CW00051"] //적용하기?></strong></a>
	</div>

	<? 
		if ($S_FIX_MEMBER_CATE_USE_YN == "Y"){
			include "memberCateJoinList.inc.php"; 
		}
	?>