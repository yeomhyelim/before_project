<!-- ******* 서브 본문영역 시작 ************************* -->
<!-- 서브 카테고리  -->
<div id="subCategory">
	<? include sprintf ( "%swww/include/Menu/categoryStyle.0001.php", $S_DOCUMENT_ROOT  ); ?>
</div>
<!-- 서브 카테고리  -->

		<? include sprintf ( "%swww/web/%s/%s_form_start.inc.php", $S_DOCUMENT_ROOT, $strMenuType, $strMenuType  ); ?>
			<!-- (1) 서브메인영역 -->
				<div class="contentWrap">
					<? include sprintf ( "%swww/include/subBody.inc.php", $S_DOCUMENT_ROOT  ); ?>
				</div>
			<!-- (1) 서브메인영역 -->
		<? include sprintf ( "%swww/web/%s/%s_form_end.inc.php", $S_DOCUMENT_ROOT, $strMenuType, $strMenuType  ); ?>

<!-- ******* 서브 본문영역 끝 ************************* -->