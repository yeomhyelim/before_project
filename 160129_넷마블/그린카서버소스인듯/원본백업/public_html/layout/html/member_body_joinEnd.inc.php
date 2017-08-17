<div id="contentWrap" class="contentNBodyWrap">
	<div class="subNavWrap">
		<div class="navTit"><a href="#">전체카테고리</a></div>
	</div>
	<div class="viewContentWrap">
		<div class="prodTopAreaView">
			<h2><?= $LNG_TRANS_CHAR["MW00089"]; //회원가입완료 ?></h2>
			<div class="locationWrap">
				<ul>
					<li class="home">H</li>
					<li><?= $LNG_TRANS_CHAR["MW00090"]; //회원가입신청 ?></li>
					<li class="end"><?= $LNG_TRANS_CHAR["MW00089"]; //회원가입완료 ?></li>
				</ul>
			</div>
			<div class="clr"></div>
		</div>

		<div class="memberJoinWrap_new">
			<div class="memStep_3">
				<ul>
					<li class="step_1"><span><?= $LNG_TRANS_CHAR["MW00087"]; //회원약관동의 ?></span></li>
					<li class="step_2"><span><?= $LNG_TRANS_CHAR["MW00088"]; //회원정보입력 ?></spen></li>
					<li class="step_3_on endStep"><span><?= $LNG_TRANS_CHAR["MW00089"]; //회원가입완료 ?></spen></li>
				</ul>
			</div>
			<h2 style="margin-top:25px;"><?= $LNG_TRANS_CHAR["MW00089"]; //회원가입완료 ?></h2>
			<div class="endBoxWrap">
				<div class="joinImg"><img src="/upload/images/img_mem_end.jpg"></div>
				<div class="joinINfoTxt">
					<!-- <div class="tit"><?=$strM_ID?>님의 회원가입을 진심으로 축하합니다.</div> -->
					<div class="tit"><?=callLangTrans($LNG_TRANS_CHAR["MS00019"],array($strM_ID))?> <!--<?=$row[M_NAME]?>님의 회원가입이 완료 되었습니다.//--></div>
					<p>
						<!--136601의 회원이 되신 것을 환영합니다.<br>
						앞으로 136601 웹사이트를 자유롭게 이용하실 수 있습니다. -->
						<?= $LNG_TRANS_CHAR["MS00159"]; ?>
					</p>
				</div>
			</div>

			<div class="btnCenter mt30">
				<a href="/<?= $S_SITE_LNG_PATH ?>" class="nextBigBtn"><?= $LNG_TRANS_CHAR["MW00094"]; //메인 바로가기 ?></a>
			</div>
		</div>
	</div>
	<div class="clr"></div>
</div>
