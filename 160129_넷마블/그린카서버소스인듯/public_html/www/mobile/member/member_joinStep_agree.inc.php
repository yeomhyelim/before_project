<?php
	
	## 언어 설정
	$strLang = $S_SITE_LNG;
	$strLangLower = strtolower($strLang);

?>
<script>
	function goPolicyView(strClassName) {
		$('.' + strClassName).toggle();
	}
</script>
<div class="joinFormAgree">
		<div class="regStepWrap">
			<ul>
				<li class="step_1 stepOn">
					<span><?=$LNG_TRANS_CHAR["MW00040"] //약관동의?></span>
					<div class="stepIcoOn"></div>
				</li>
				<li class="step_2">
					<span><?=$LNG_TRANS_CHAR["CW00047"] //회원가입신청?></span>
					<div class="stepIco"></div>
				</li>
				<li class="step_3">
					<span><?=$LNG_TRANS_CHAR["MW00080"] //가입완료?></span>
				</li>
			</ul>
			<div class="clr"></div>
		</div>
		<div class="agreeWrap">
			<!-- 약관동의 -->
				<div class="titBox"><span class="barRed"></span><span class="tit"><?=$LNG_TRANS_CHAR["MW00041"] //이용약관?></span></div>
				<div class="policyFormWrap">
					<div class="policyForm">
						<?php include MALL_SHOP . "/conf/policy.use.{$strLangLower}.inc.php";?>
					</div>
					<a href="javascript:goPolicyView('popPolicyUse')" class="btn_detail_view"><?=$LNG_TRANS_CHAR["MW00081"]//내용전체보기?></a>
				</div>
				<div class="chkMem">
					<input type="radio" id="policyYN" name="policyYN" value="Y" checked/> <?=$LNG_TRANS_CHAR["MS00001"] //동의합니다.?>
					<input type="radio" id="policyYN" name="policyYN" value="N"/> <?=$LNG_TRANS_CHAR["MS00002"] //동의 하지 않습니다..?>
				</div>
			<!-- 약관동의 -->			
		</div><!-- loginFormWrap -->

		<div class="agreeWrap">
			<!-- 개인정보동의 -->
				<div class="titBox"><span class="barRed"></span><span class="tit"><?=$LNG_TRANS_CHAR["MW00042"] //개인정보보호정책 동의?></span></div>
				<div class="policyFormWrap">
					<div class="policyForm">
						<?php include MALL_SHOP . "/conf/policy.person.{$strLangLower}.inc.php";?>
					</div>
					<a href="javascript:goPolicyView('popPolicyPerson')" class="btn_detail_view"><?=$LNG_TRANS_CHAR["MW00081"]//내용전체보기?></a>
				</div>				
				<div class="chkMem">
					<input type="radio" id="personYN" name="personYN" value="Y" checked/> <?=$LNG_TRANS_CHAR["MS00001"] //동의합니다.?>
					<input type="radio" id="personYN" name="personYN" value="N"/> <?=$LNG_TRANS_CHAR["MS00002"] //동의 하지 않습니다..?>
				</div>
			<!-- 개인정보동의 -->			
		</div>
		<?if ($S_SITE_LNG == "KR" && $settingRow[J_JUMIN] == "Y" || $settingRow[J_IPIN] == "Y"){?>
		<div class="agreeWrap mt10">	
			<h4>실명인증</h4>
			<div class="chkNameWrap">
				<span class="txtChkInfo"><?=$S_SITE_NM?>은 고객님의 <strong>개인정보 보호</strong>와 <strong>안전한 거래</strong>를 위하여 실명확인제를 실시하고 있습니다.</span>
				<div class="chkForm">
					<input type="radio" name="memCerityMth" id="memCerityMth" value="N" checked>실명확인
					<input type="radio" name="memCerityMth" id="memCerityMth" value="I">아이핀
				</div>
				<div class="chkNameTxt">
					<strong>주민등록법 제 21조(벌칙) 제2항 9호 (시행일 2006.9.25)</strong><br>
					2006년 9월 25일부터 개정된 주민등록법에 의해 타인의 주민번호를 도용하여 온라인 회원가입을 하는 등 다른 사람의<br>
					주민등록번호를 부정사용자는 3년 이하의 징역 또는 1천만원 이하의 벌금이 부과될 수 있습니다.
				</div>
			</div>
		</div>
		<?}?>
		<div class="joinBtnWrap btn2Box">
			<a href="javascript:history.back();" class="btn_gray"><strong><?=$LNG_TRANS_CHAR["MW00044"]//취소?></strong></a>
			<a href="javascript:goJoinAgree();" class="btn_red"><strong><?=$LNG_TRANS_CHAR["MW00043"]//다음?></strong></a>			
		</div>
</div>

<div class="popPolicyUse">
	<div class="popPolicyBoxWrap">
				<div class="title">
					<h2><?=$LNG_TRANS_CHAR["MW00041"] //이용약관?></h2>
					<a href="javascript:goPolicyView('popPolicyUse')">X</a>
				</div>
				<div class="policyBox"><?php include MALL_SHOP . "/conf/policy.use.{$strLangLower}.inc.php";?></div>
				<div class="title2">
					<h2><?=$LNG_TRANS_CHAR["MW00041"] //이용약관?></h2>
					<a href="javascript:goPolicyView('popPolicyUse')">X</a>
				</div>
	</div>
</div>
<div class="popPolicyPerson">
	<div class="popPolicyBoxWrap">
				<div class="title">
					<h2><?=$LNG_TRANS_CHAR["MW00042"] //개인정보보호정책 동의?></h2>
					<a href="javascript:goPolicyView('popPolicyPerson')">X</a>
				</div>
				<div class="policyBox"><?php include MALL_SHOP . "/conf/policy.person.{$strLangLower}.inc.php";?></div>
				<div class="title2">
					<h2><?=$LNG_TRANS_CHAR["MW00042"] //개인정보보호정책 동의?></h2>
					<a href="javascript:goPolicyView('popPolicyPerson')">X</a>
				</div>
		</div>
</div>