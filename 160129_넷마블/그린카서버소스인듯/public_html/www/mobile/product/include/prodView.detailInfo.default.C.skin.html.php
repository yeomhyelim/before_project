<?
	# 관련상품 + 상세정보 
	# prodView.detailInfo.default.C.skin.html.php
	$intCLSizeW = 788;	// contentLayout 가로 사이즈
?>



<div class="contentLayout">
	<div class="detailInfoArea"><!-- 상세정보 -->
	<!-- start: 탭버튼 -->
		<div class="detailInfoTabWrap">
			<div class="tabBox">
				<span id="prodINfo"><?=$LNG_TRANS_CHAR["OW00001"] //상세정보?></span>
				<?if ($S_PRODUCT_BBS_REVIEW_USE == "Y"){?>
					<a href="#review" class="scroll leftLine"><?=$LNG_TRANS_CHAR["CW00031"] //사용후기?></a>
				<?}?>
				<?if ($S_PRODUCT_BBS_QNA_USE == "Y"){?>
					<a href="#prodQna" class="scroll"><?=$LNG_TRANS_CHAR["CW00024"] //상품Q&A?></a>
				<?}?>
				<a href="#delivery"><?=$LNG_TRANS_CHAR["CW00032"] //배송&교환반품안내?></a>
				<!-- a href="#return"><img src="./himg/product/A0001/tab_prod_5.gif"/></a -->
				<div class="clear"></div>
			</div>
		</div>
	<!-- end: 탭버튼 -->
		<div class="sideExp mt20">
			<?=$prodRow[P_WEB_TEXT]?>
		</div>
		<div class="sideRelationList mt20"><!-- 관련상품 -->
			<? include "relationList.index.inc.php" // 관련상품 ?>
		</div>
		<div class="clear"></div>
	</div>

</div>

<div style="clear:both"></div>