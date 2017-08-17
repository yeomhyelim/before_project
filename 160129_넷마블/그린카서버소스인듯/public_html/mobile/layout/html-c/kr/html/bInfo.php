
<div class="contentBodyWrap">
	<h2><?= $LNG_TRANS_CHAR["CW00107"]; //입점 및 제휴안내 ?></h2>

	<div class="bannerBox"><? include sprintf ( "%s%s/layout/banner/%s/%s", $S_DOCUMENT_ROOT, $S_SHOP_HOME, $S_SITE_LNG_PATH, "banner_5.html.php" ); ?></div>
	
	<div class="grayImgBox">
		<img src="/upload/images/img_m_bInfo1_<?= $S_SITE_LNG_PATH ?>.jpg" alt="입점신청안내" />
		<div class="btnBox"><a href="./?menuType=shop&mode=shopApplyReg" class="btn_red"><?= $LNG_TRANS_CHAR["CW00127"]; //입점신청하기 ?></a></div>
	</div>

	<div class="grayImgBox">
		<img src="/upload/images/img_m_bInfo2_<?= $S_SITE_LNG_PATH ?>.jpg" alt="제휴문의안내" />
		<div class="btnBox"><a href="tel:031-705-1700" class="btn_red"><?= $LNG_TRANS_CHAR["PW00093"]; //전화문의 //전화연결하기 ?></a></div>
	</div>
</div>