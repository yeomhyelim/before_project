<div class="contentBodyWrap">
	<h2><?= $LNG_TRANS_CHAR["CW00104"]; //고객센터 ?></h2>

	<div class="bannerBox"><? include sprintf ( "%s%s/layout/banner/%s/%s", $S_DOCUMENT_ROOT, $S_SHOP_HOME, $S_SITE_LNG_PATH, "banner_2.html.php" ); ?></div>

	<div class="numberListBox">
		<ul>
			<li>
				<div class="number">
				  <?= $LNG_TRANS_CHAR["PW00097"]; //전화문의 ?>
					<p>&nbsp;&nbsp;&nbsp;031-705-1700</p>
				</div>

				<div class="btnBox">
					<a href="tel:031-705-1700" class="btn_red"><?= $LNG_TRANS_CHAR["PW00098"]; //전화걸기 ?></a>
				</div>
				<div class="clr"></div>
			</li>
			
			<li>
				<div class="number">
				  <?= $LNG_TRANS_CHAR["CW00023"]; //1:1문의 ?>
					<p>&nbsp;&nbsp;&nbsp;</p>
				</div>

				<div class="btnBox">
					<a href="./?menuType=community&amp;mode=dataWrite&amp;b_code=MY_QNA" class="btn_red"><?= $LNG_TRANS_CHAR["CW00052"]; //1:1문의 ?></a>
				</div>
				<div class="clr"></div>
			</li>
<!--
			<li>
				<div class="number">
					<?= $LNG_TRANS_CHAR["PW00097"]; //제휴문의 ?>
					<p>031-705-1700</p>
				</div>

				<div class="btnBox">
					<a href="tel:031-705-1700" class="btn_red"><?= $LNG_TRANS_CHAR["PW00098"]; //전화걸기 ?></a>
				</div>
				<div class="clr"></div>
			</li>
-->
		</ul>
	</div>
</div>