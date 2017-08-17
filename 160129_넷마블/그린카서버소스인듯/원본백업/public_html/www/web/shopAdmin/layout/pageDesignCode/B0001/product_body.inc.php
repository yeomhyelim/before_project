구분 문구입니다. 이곳은 product_body 영역입니다. B0002
<!-- ******* 서브 본문영역 시작 ************************* -->
		<!-- 서브 카테고리 입니다. 삭제하지 마세요. -->
		<div id="subCategory">
			<? include sprintf ( "%swww/include/Menu/categoryStyle.0001.php", $S_DOCUMENT_ROOT  ); ?>
		</div>
		<!-- 서브 카테고리 입니다. 삭제하지 마세요. -->

		<? include sprintf ( "%swww/web/%s/%s_form_start.inc.php", $S_DOCUMENT_ROOT, $strMenuType, $strMenuType  ); ?>
			<!-- (1) 서브메인영역 -->
					<? include sprintf ( "%swww/include/subBody.inc.php", $S_DOCUMENT_ROOT  ); ?>
			<!-- (1) 서브메인영역 -->
		<? include sprintf ( "%swww/web/%s/%s_form_end.inc.php", $S_DOCUMENT_ROOT, $strMenuType, $strMenuType  ); ?>
<!-- ******* 서브 본문영역 끝 ************************* -->