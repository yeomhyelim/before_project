<div id="contentWrap">
	<div class="subNavWrap">
		<div class="navTit">
			<strong>Customer</strong>
			<p><?= $LNG_TRANS_CHAR["CW00104"]; //고객센터 ?></p>
		</div>
		<ul class="cusNavList">
			<!--
			<li><a href="./?menuType=community&b_code=NOTICE">136601 소식1</a></li>
			<li><a href="./?menuType=community&b_code=MY_QNA">1:1문의</a></li>
			<li><a href="./?menuType=community&b_code=FAQ">자주묻는 질문</a></li>
			<li><a href="./?menuType=contents&mode=userPage&id=00009">입점 및 제휴안내</a></li>
			<li><a href="./?menuType=shop&mode=shopApplyReg">입점신청</a></li>
			<li><a href="./?menuType=member&mode=agreement">이용약관</a></li>
			<li><a href="./?menuType=member&mode=private" class="selected">개인정보취급방침</a></li>
			-->
			<li><a href="./?menuType=community&amp;b_code=NOTICE"><?= $LNG_TRANS_CHAR["CW00105"]; //136601 소식 ?></a></li>
			<li><a href="./?menuType=community&amp;b_code=MY_QNA"><?= $LNG_TRANS_CHAR["CW00023"]; //1:1문의 ?></a></li>
			<li><a href="./?menuType=community&amp;b_code=FAQ"><?= $LNG_TRANS_CHAR["CW00106"]; //자주묻는 질문 ?></a></li>
			<li><a href="./?menuType=contents&amp;mode=userPage&amp;id=00009"><?= $LNG_TRANS_CHAR["CW00107"]; //입점 및 제휴안내 ?></a></li>
			<li><a href="./?menuType=shop&amp;mode=shopApplyReg"><?= $LNG_TRANS_CHAR["CW00108"]; //입점신청 ?></a></li>
			<li><a href="./?menuType=member&amp;mode=agreement"><?= $LNG_TRANS_CHAR["MW00041"]; //이용약관 ?></a></li>
			<li><a href="./?menuType=member&amp;mode=private"><?= $LNG_TRANS_CHAR["CW00109"]; //개인정보취급방침 ?></a></li>
		</ul>
		<div class="navBottomLine"></div>
		<? include sprintf ( "%s%s/layout/html/customer_ico.inc.php", $S_DOCUMENT_ROOT, $S_SHOP_HOME ); ?>
	</div>
	<div class="rightContentWrap">
		<div class="prodTopAreaView">
			<h2><?= $LNG_TRANS_CHAR["CW00109"]; //개인정보취급방침 ?></h2>
			<div class="locationWrap">
				<ul>
					<li class="home">H</li>
					<li><?= $LNG_TRANS_CHAR["CW00104"]; //고객센터 ?></li>
					<li class="end"><?= $LNG_TRANS_CHAR["CW00109"]; //개인정보취급방침 ?></li>
				</ul>
			</div>
			<div class="clr"></div>
		</div>
		<div class="clr"></div>
		<div class="boxGray"><? include "{$S_DOCUMENT_ROOT}{$S_SHOP_HOME}/conf/policy.person.{$S_SITE_LNG_PATH}.inc.php"; ?></div>

	</div>
	<div class="clr"></div>
</div>
