<div id="contentArea">
	<div id="contentWrap">
		<div class="locationMapWrap"><? include sprintf ( "%swww/include/location.php", $S_DOCUMENT_ROOT  ); ?></div>
		<div class="prodViewBodyWrap">
			<? include sprintf ( "%swww/web/%s/%s_form_start.inc.php", $S_DOCUMENT_ROOT, $strMenuType, $strMenuType  ); ?>
				<!-- (1) 서브메인영역 -->
						<? include sprintf ( "%swww/include/subBody.inc.php", $S_DOCUMENT_ROOT  ); ?>
				<!-- (1) 서브메인영역 -->
			<? include sprintf ( "%swww/web/%s/%s_form_end.inc.php", $S_DOCUMENT_ROOT, $strMenuType, $strMenuType  ); ?>
		</div>
		<div class="clear"></div>
	</div><!-- 본문영역 -->
</div>
<!-- ******* 서브 본문영역 끝 ************************* -->