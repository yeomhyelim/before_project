
<div class="subNavWrap">
	<div class="navTit">
		<a href="./?menuType=contents&mode=userPage&id=00005">
		<strong>Customer</strong>
		<p><?= $LNG_TRANS_CHAR["CW00104"]; //고객센터 ?></p>
		</a>
	</div>
	<ul class="cusNavList">
		<!--
		<li><a href="./?menuType=community&amp;b_code=NOTICE">136601 소식</a></li>
		<li><a href="./?menuType=community&amp;b_code=MY_QNA">1:1문의</a></li>
		<li><a href="./?menuType=community&amp;b_code=FAQ">자주묻는 질문</a></li>
		<li><a href="./?menuType=contents&amp;mode=userPage&amp;id=00009">입점 및 제휴안내</a></li>
		<li><a href="./?menuType=shop&amp;mode=shopApplyReg" class="selected">입점신청</a></li>
		<li><a href="./?menuType=member&amp;mode=agreement">이용약관</a></li>
		<li><a href="./?menuType=member&amp;mode=private">개인정보취급방침</a></li>
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
	<div class="commNavInfo">
			<!--
			<a href="#" class="btn_cus_1"><span class="ico_cus_1"></span>고객센터</a>
			<a href="#" class="btn_cus_2"><span class="ico_cus_2"></span>통역서비스</a>
			<a href="#" class="btn_cus_3"><span class="ico_cus_3"></span>번역서비스</a>
			<a href="#" class="btn_cus_4"><span class="ico_cus_4"></span>고객센터</a>
			<a href="#" class="btn_cus_5"><span class="ico_cus_5"></span>통역서비스</a>
			<a href="#" class="btn_cus_6"><span class="ico_cus_6"></span>번역서비스</a>-->
			<a href="#" class="btn_cus_1"><span class="ico_cus_1"></span><?= $LNG_TRANS_CHAR["CW00134"]; //고객센터 ?></a> 
			<a href="#" class="btn_cus_2"><span class="ico_cus_2"></span><?= $LNG_TRANS_CHAR["CW00135"]; //통역서비스 ?></a>
			<a href="#" class="btn_cus_3"><span class="ico_cus_3"></span><?= $LNG_TRANS_CHAR["CW00136"]; //번역서비스 ?></a>
			<a href="#" class="btn_cus_4"><span class="ico_cus_4"></span><?= $LNG_TRANS_CHAR["CW00137"]; //구매대행 ?></a>
			<a href="#" class="btn_cus_5"><span class="ico_cus_5"></span><?= $LNG_TRANS_CHAR["CW00138"]; //해외배송 ?></a>
			<a href="#" class="btn_cus_6"><span class="ico_cus_6"></span><?= $LNG_TRANS_CHAR["CW00139"]; //통관자문 ?></a>
			<div class="clr"></div>
		</div>

</div>
<div class="rightContentWrap">
	<div class="prodTopAreaView">
		<h2><?= $LNG_TRANS_CHAR["CW00108"]; //입점신청 ?></h2>
		<div class="locationWrap">
			<ul>
				<li class="home">H</li>
				<li><?= $LNG_TRANS_CHAR["CW00104"]; //고객센터 ?></li>
				<li class="end"><?= $LNG_TRANS_CHAR["CW00108"]; //입점신청 ?></li>
			</ul>
		</div>
		<div class="clr"></div>
	</div>
	<div><? include "{$S_DOCUMENT_ROOT}www/web/shop/shop_shopApplyReg.inc.php"; ?></div>

</div>
<div class="clr"></div>
