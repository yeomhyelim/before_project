<div id="contentArea">
	<div id="contentWrap">
		<? include sprintf ( "%swww/web/%s/%s_form_start.inc.php", $S_DOCUMENT_ROOT, $strMenuType, $strMenuType  ); ?>
			<!-- (1) 서브메인영역 mypage_body.inc.php -->
					<? include sprintf ( "%swww/include/subBody.inc.php", $S_DOCUMENT_ROOT  ); ?>
			<!-- (2) 서브메인영역 mypage_body.inc.php -->
		<? include sprintf ( "%swww/web/%s/%s_form_end.inc.php", $S_DOCUMENT_ROOT, $strMenuType, $strMenuType  ); ?>
	</div><!-- 본문영역 -->
</div>
