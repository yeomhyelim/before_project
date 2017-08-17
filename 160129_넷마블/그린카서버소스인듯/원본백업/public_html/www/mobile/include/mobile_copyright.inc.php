<div id="bottomWraper">
	<div class="bottomNavi">
			<?if ($g_member_no && $g_member_login){?>
				<a href="./?menuType=member&mode=act&act=logout"><?=$LNG_TRANS_CHAR["CW00049"]//로그아웃?></a>
			<?}else{?>
				<a href="./?menuType=member&mode=login"><?=$LNG_TRANS_CHAR["CW00045"]//로그인?></a>
			<?}?>
			<a href="./?menuType=html&mode=customer"><?=$LNG_TRANS_CHAR["CW00043"]//고객센터?></a>
			<a href="./?menuType=html&mode=guide"><?=$LNG_TRANS_CHAR["CW00080"]//이용안내?> </a>
			<a href="javascript:C_getHostTypeChangeActEvent('web')" target="_blank"><?=$LNG_TRANS_CHAR["CW00081"]//PC버전?></a>
	</div>

	<div class="copyright">
		<?php
		$EUMSHOP_APP_INFO					= "";
		$EUMSHOP_APP_INFO['name']			= "언어별 카피라이트 페이지 include";
		$EUMSHOP_APP_INFO['mode']			= "include";
		$EUMSHOP_APP_INFO['home']			= "mobile";
		$EUMSHOP_APP_INFO['siteLang']		= $S_SITE_LNG;
		$EUMSHOP_APP_INFO['homeLang']		= "KR";
		$EUMSHOP_APP_INFO['path']			= "/inc/copyright.{@siteLang@}.php";
		include "{$S_DOCUMENT_ROOT}www/web/app/index.php";
		?>
	</div>
</div>