<div id="contentWrap" class="contentNBodyWrap">
	<div class="subNavWrap">
		<div class="navTit"><a href="#">전체카테고리</a></div>
	</div>
	<div class="viewContentWrap">
		<div class="prodTopAreaView">
			<h2><?= $LNG_TRANS_CHAR["MW00087"]; //회원약관동의 ?></h2>
			<div class="locationWrap">
				<ul>
					<li class="home">H</li>
					<li><?= $LNG_TRANS_CHAR["MW00090"]; //회원가입신청 ?></li>
					<li class="end"><?= $LNG_TRANS_CHAR["MW00087"]; //회원약관동의 ?></li>
				</ul>
			</div>
			<div class="clr"></div>
		</div>

		<div class="memberJoinWrap_new">
			<div class="memStep_1">
				<ul>
					<li class="step_1_on"><span><?= $LNG_TRANS_CHAR["MW00087"]; //회원약관동의 ?></span></li>
					<li class="step_2"><span><?= $LNG_TRANS_CHAR["MW00088"]; //회원정보입력 ?></span></li>
					<li class="step_3 endStep"><span><?= $LNG_TRANS_CHAR["MW00089"]; //회원가입완료 ?></span></li>
				</ul>
			</div>
			<? include "{$S_DOCUMENT_ROOT}www/web/member/include/memberJoin1.index.php"; ?>
		</div>
	</div>
	<div class="clr"></div>
</div>