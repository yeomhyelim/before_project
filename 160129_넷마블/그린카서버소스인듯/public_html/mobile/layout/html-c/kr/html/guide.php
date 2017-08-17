




<div class="contentBodyWrap">
	<h2><?= $LNG_TRANS_CHAR["MW00041"]; //이용약관 ?>/<?= $LNG_TRANS_CHAR["CW00109"]; //개인정보보호약관 ?></h2>
	<div class="tabBtnWrap">
		<a class="btn1 on" href="#;" onclick="C_getTabChange('tab','1')" id="btn-tab1"><?= $LNG_TRANS_CHAR["MW00041"]; //이용약관 ?></a>
		<a class="btn2" href="#;" onclick="C_getTabChange('tab','2')" id="btn-tab2"><?= $LNG_TRANS_CHAR["CW00109"]; //개인정보보호약관 ?></a>
	</div>

	<!-- Start. 이용약관 -->
	<div id="tab1" class="contentBox">
		<div class="policyWrap">
			<div class="policy">
				<?
				#이용약관
				include "{$S_DOCUMENT_ROOT}{$S_SHOP_HOME}/conf/policy.use.{$S_SITE_LNG_PATH}.inc.php";
				?>
			</div>
		</div>
	</div>
	<!-- End. 이용약관 -->

	<!-- Start. 개인정보취급방침 -->
	<div id="tab2" class="contentBox" style="display:none;">
		<div class="policyWrap">
			<div class="policy">
				<?
				#개인정보취급방침
				include "{$S_DOCUMENT_ROOT}{$S_SHOP_HOME}/conf/policy.person.{$S_SITE_LNG_PATH}.inc.php";
				?>
			</div>
		</div>
	</div>
	<!-- start. 개인정보취급방침 -->
</div>