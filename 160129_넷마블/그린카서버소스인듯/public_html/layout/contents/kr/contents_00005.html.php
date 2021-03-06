<div id="contentWrap">
	<div class="subNavWrap">
		<div class="navTit">
			<a href="./?menuType=contents&mode=userPage&id=00005">
			<strong>Customer</strong>
			<p>고객센터</p>
			</a>
		</div>
		<ul class="cusNavList">
			<li><a href="./?menuType=community&amp;b_code=NOTICE"><?= $LNG_TRANS_CHAR["CW00105"]; //136601 소식 ?></a></li>
			<li><a href="./?menuType=community&amp;b_code=MY_QNA">1:1문의</a></li>
			<li><a href="./?menuType=community&amp;b_code=FAQ">자주묻는 질문</a></li>
			<li><a href="./?menuType=contents&amp;mode=userPage&amp;id=00009">입점 및 제휴안내</a></li>
			<li><a href="./?menuType=shop&amp;mode=shopApplyReg">입점신청</a></li>
			<li><a href="./?menuType=member&amp;mode=agreement">이용약관</a></li>
			<li><a href="./?menuType=member&amp;mode=private">개인정보취급방침</a></li>
		</ul>
		<div class="navBottomLine"></div>
		<? include sprintf ( "%s%s/layout/html/customer_ico.inc.php", $S_DOCUMENT_ROOT, $S_SHOP_HOME ); ?>

	</div>
	<div class="rightContentWrap">
		<div class="prodTopAreaView">
			<h2>고객센터</h2>
			<div class="locationWrap">
				<ul>
					<li class="home">H</li>
					<li>고객센터</li>
					<li class="end">고객센터</li>
				</ul>
			</div>
			<div class="clr"></div>
		</div>
		<div class="clr"></div>
		<div class="customerImgWrap mt10">
			<ul>
				<li><img src="/upload/images/img_customer_1_kr.jpg"><a href="./?menuType=community&amp;b_code=MY_QNA" class="btnShopOk">1:1 문의하기 ></a></li>
				<li class="endList"><img src="/upload/images/img_customer_2_kr.jpg"><a href="./?menuType=shop&amp;mode=shopApplyReg" class="btnShopOk">입점신청하기 ></a></li>
			</ul>
		</div>
		<div class="customerBbsList">
			<div class="tit">
				<h2>자주 묻는 질문 TOP 5</h2>
				<a href="./?menuType=community&b_code=FAQ" class="more">더보기</a>
			</div>
			<div class="bbsList qnaBbsList">
			<?
			  $EUMSHOP_APP_INFO = "";
			  $EUMSHOP_APP_INFO['name'] = "FAQ";
			  $EUMSHOP_APP_INFO['mode'] = "communityWidget";
			  $EUMSHOP_APP_INFO['b_code'] = "FAQ";
			  $EUMSHOP_APP_INFO['limitStart'] = "0";
			  $EUMSHOP_APP_INFO['limitEnd'] = "5";
			  $EUMSHOP_APP_INFO['column'] = "제목";
			  $EUMSHOP_APP_INFO['titleMaxLeng'] = "35";
			  include "{$S_DOCUMENT_ROOT}www/web/app/index.php";
			?>
			</div>
		</div>

		<div class="customerBbsList">
			<div class="tit">
				<h2><?= $LNG_TRANS_CHAR["CW00105"]; //136601 소식 ?></h2>
				<a href="./?menuType=community&b_code=NOTICE" class="more">더보기</a>
			</div>
			<div class="bbsList">
			<?
			  $EUMSHOP_APP_INFO = "";
			  $EUMSHOP_APP_INFO['name'] = "공지사항";
			  $EUMSHOP_APP_INFO['mode'] = "communityWidget";
			  $EUMSHOP_APP_INFO['b_code'] = "NOTICE";
			  $EUMSHOP_APP_INFO['limitStart'] = "0";
			  $EUMSHOP_APP_INFO['limitEnd'] = "5";
			  $EUMSHOP_APP_INFO['column'] = "제목;작성일";
			  $EUMSHOP_APP_INFO['titleMaxLeng'] = "35";
			  include "{$S_DOCUMENT_ROOT}www/web/app/index.php";
			?>
			</div>
		</div>
	</div>
	<div class="clr"></div>
</div>