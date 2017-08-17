		<div class="agreeWrap mt20">
			<!-- 약관동의 -->
				<h4 class="agreeTit"><span><?php echo $LNG_TRANS_CHAR["MW00086"];//가입약관 ?></span></h4>
				<div class="policyForm" style="line-height:20px;">
					<div class="boxForm">
						<?include "../conf/policy.shop.".strtolower($S_SITE_LNG).".inc.php";?>
					</div>
				</div>
				<div class="btnCenter">
					<input type="radio" id="policyYN" name="policyYN" value="Y"/> <?=$LNG_TRANS_CHAR["MS00001"] //동의합니다.?>
					<input type="radio" id="policyYN" name="policyYN" value="N" checked/> <?=$LNG_TRANS_CHAR["MS00002"] //동의 하지 않습니다..?>
				</div>
			<!-- 약관동의 -->			
		</div><!-- loginFormWrap -->
		<div class="btnCenter">
			<a href="./?menuType=main" class="cancelBigBtn"><?=$LNG_TRANS_CHAR["MW00044"] //취소?></a>
			<a href="javascript:goShopApplyAgree();" class="nextBigBtn"><?=$LNG_TRANS_CHAR["MW00043"] //다음신청?></a>
		</div>