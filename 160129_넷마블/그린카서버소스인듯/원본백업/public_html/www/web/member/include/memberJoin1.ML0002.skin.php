<div class="joinStepWrap">
		
		<!-- 전체 동의 -->
		<div class="agreeWrap mt40">
			<div class="checkBoxWrap"> <?= $LNG_TRANS_CHAR["MS00162"]; //[전체동의] 회원가입 약관에 모두 동의합니다. ?>
    	<input type="checkbox" name="agreement" id="agreement" onclick="goAllCheck();" /></div>
		</div>
		<!-- 전체 동의 -->
		
		<div class="agreeWrap mt20">
			<!-- 약관동의 -->

					<div class="titTerms"><span><?=$LNG_TRANS_CHAR["MW00041"] //이용약관?></span></div>
					<div class="policyForm" style="line-height:20px;">
						<div class="boxForm">
						<?include "../conf/policy.use.".strtolower($S_SITE_LNG).".inc.php";?>
						</div>
						<div class="checkBoxWrap">
							<input type="radio" id="policyYN" name="policyYN" value="Y"/> <?=$LNG_TRANS_CHAR["MS00001"] //동의합니다.?>
							<input type="radio" id="policyYN" name="policyYN" value="N" checked/> <?=$LNG_TRANS_CHAR["MS00002"] //동의 하지 않습니다..?>
						</div>					
					</div>
					<div class="clear"></div>
				
			<!-- 약관동의 -->			
		</div><!-- loginFormWrap -->
		

		<div class="agreeWrap mt40">
			<!-- 개인정보동의 -->
				<div class="titPrivate"><span><?=$LNG_TRANS_CHAR["MW00042"] //개인정보보호를 위한 이용자 동의사항?></span></div>
				<div class="policyForm" style="line-height:20px;">
					<div class="boxForm">
					<?include "../conf/policy.person.".strtolower($S_SITE_LNG).".inc.php";?>
					</div>
					<div class="checkBoxWrap">
					<input type="radio" id="personYN" name="personYN" value="Y"/> <?=$LNG_TRANS_CHAR["MS00001"] //동의합니다.?>
					<input type="radio" id="personYN" name="personYN" value="N" checked/> <?=$LNG_TRANS_CHAR["MS00002"] //동의 하지 않습니다..?>
				</div>
				</div>
				<div class="clear"></div>
				
				
			<!-- 개인정보동의 -->			
		</div>
		<div class="btnCenter mt40">
			<a href="./?menuType=main" class="cancelBigBtn"><span><?=$LNG_TRANS_CHAR["MW00044"] //취소?></span></a>
			<a href="javascript:goJoinAgree();" class="nextBigBtn"><span><?=$LNG_TRANS_CHAR["MW00043"] //다음?></span></a>
		</div>
</div>
		