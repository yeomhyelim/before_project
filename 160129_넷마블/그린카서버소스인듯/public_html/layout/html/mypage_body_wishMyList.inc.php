<div class="mypageWrap">
	<div class="subNavWrap">
		<div class="navTit">
			<strong>MyPage</strong>
			<p><?=$LNG_TRANS_CHAR["MW00048"] //마이페이지 ?></p>
		</div>
	</div>
	<div class="mypageSubNaviWrap">
                    	<? include MALL_WEB_PATH . "navi/sub_navi_A0001_mypage.inc.php"; ?>
	</div>

	<div class="mypageContentsWrap buyListBodyWrap">
		<div class="prodTopAreaView">
			<h2><?=$LNG_TRANS_CHAR["CW00086"] //담아둔 목록 ?></h2>
			<div class="locationWrap">
				<ul>
					<li class="home">H</li>
					<li><?=$LNG_TRANS_CHAR["MW00048"] //마이페이지 ?></li>
					<li class="end"><?=$LNG_TRANS_CHAR["CW00086"] //담아둔 목록 ?></li>
				</ul>
			</div>
			<div class="clr"></div>
		</div>
		<div class="clr"></div>
		<div class="myT30"><? include "{$S_DOCUMENT_ROOT}www/web/mypage/mypage_wishMyList.inc.php"; ?></div>
	</div>
	<div class="clear"></div>
</div>