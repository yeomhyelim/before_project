<!-- ******* 본문영역 시작 ************************* -->
<div class="mainTopEventBanner">
<? include sprintf ( "%swww/web/main/include/mainbanner.index.inc.php", $S_DOCUMENT_ROOT ); ?>
</div>
		<? include sprintf ( "%swww/include/formStart.inc.php", $S_DOCUMENT_ROOT  ); ?>

			<!-- (3) 추천아이템 예약어입니다. 삭제하지 마세요. -->
                                <img src="/images/call_info.gif"/>
				<div class="mainProdList">
					<? $no = 1; include sprintf ( "%swww/web/product/include/bestList.index.inc.php", $S_DOCUMENT_ROOT ); ?>
					<? $no = 2; include sprintf ( "%swww/web/product/include/bestList.index.inc.php", $S_DOCUMENT_ROOT ); ?>
					<? $no = 3; include sprintf ( "%swww/web/product/include/bestList.index.inc.php", $S_DOCUMENT_ROOT ); ?>
					<? $no = 4; include sprintf ( "%swww/web/product/include/bestList.index.inc.php", $S_DOCUMENT_ROOT ); ?>
					<? $no = 5; include sprintf ( "%swww/web/product/include/bestList.index.inc.php", $S_DOCUMENT_ROOT ); ?>
				</div>
			<!-- (3) 추천아이템 예약어입니다. 삭제하지 마세요. -->

			<!-- (5) 고객센터안내 -->
				<div class="bottomCustomerWrap mt10">
					<? include sprintf ( "%swww/include/customerCenter.inc.php", $S_DOCUMENT_ROOT ); ?>
				</div>		
			<!-- (5) 고객센터안내 -->

		<? include sprintf ( "%swww/include/formEnd.inc.php", $S_DOCUMENT_ROOT ); ?>
<!-- ******* 본문영역 끝 ************************* -->