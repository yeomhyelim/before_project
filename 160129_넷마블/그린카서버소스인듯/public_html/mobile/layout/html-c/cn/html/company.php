
<div class="contentBodyWrap">
	<h2><?= $LNG_TRANS_CHAR["PW00089"]; //회사소개 ?></h2>
	<div class="tabBtnWrap">
		<a class="btn1 on" href="#;" onclick="C_getTabChange('tab','1')" id="btn-tab1"><?=$LNG_TRANS_CHAR["CW00110"]//136601 소개?></a>
		<a class="btn2" href="#;" onclick="C_getTabChange('tab','2')" id="btn-tab2">经营理念</a>
	</div>

	<!-- Start. 회사소개 -->
	<div id="tab1" class="contentBox">
		<?
		#회사소개
		include "{$S_DOCUMENT_ROOT}{$S_SHOP_HOME}/conf/company.{$S_SITE_LNG_PATH}.inc.php";
		?>
	</div>
	<!-- End. 회사소개 -->

	<!-- Start. 136601 소개 -->
	<div id="tab2" class="contentBox" style="display:none;">
		<?
		#오시는길
		include "{$S_DOCUMENT_ROOT}{$S_SHOP_HOME}/conf/info.{$S_SITE_LNG_PATH}.inc.php";
		?>
	</div>
	<!-- start. 136601 소개 -->
</div>