		<!-- (2) 상단 서브 카테고리 -->
		<?include MALL_HOME."/include/subMenuTopImg.inc.php";?>
		<!-- (2) 상단 서브 카테고리 -->

		<div class="agreeWrap mt20">
			<!-- 약관동의 -->
				<h4><img src="/himg/member/A0001/<?=$S_SITE_LNG_PATH?>/tit_policy_1.gif"/></h4>
				<div class="policyForm" style="line-height:20px;">
					<?include "../conf/policy.use.".strtolower($S_SITE_LNG).".inc.php";?>
				</div>
				<div class="btnCenter">
					<input type="radio" id="policyYN" name="policyYN" value="Y"/> <?=$LNG_TRANS_CHAR["MS00001"] //동의합니다.?>
					<input type="radio" id="policyYN" name="policyYN" value="N" checked/> <?=$LNG_TRANS_CHAR["MS00002"] //동의 하지 않습니다..?>
				</div>
			<!-- 약관동의 -->			
		</div><!-- loginFormWrap -->

		<div class="agreeWrap mt20">
			<!-- 개인정보동의 -->
				<h4><img src="/himg/member/A0001/<?=$S_SITE_LNG_PATH?>/tit_policy_2.gif"/></h4>
				<div class="policyForm" style="line-height:20px;">
					<?include "../conf/policy.person.".strtolower($S_SITE_LNG).".inc.php";?>
				</div>
				<div class="btnCenter">
					<input type="radio" id="personYN" name="personYN" value="Y"/> <?=$LNG_TRANS_CHAR["MS00001"] //동의합니다.?>.
					<input type="radio" id="personYN" name="personYN" value="N" checked/> <?=$LNG_TRANS_CHAR["MS00002"] //동의 하지 않습니다..?>
				</div>
			<!-- 개인정보동의 -->			
		</div>
		<div class="btnCenter">
			<a href="javascript:goJoinAgree();"><img src="/himg/member/A0001/<?=$S_SITE_LNG_PATH?>/btn_reg_go_mem.gif"/></a>
			<a href="javascript:history.back();"><img src="/himg/member/A0001/<?=$S_SITE_LNG_PATH?>/btn_page_prev.gif"/></a>
		</div>