<div class="detailInfoArea"><!-- 상세정보 -->
	<!-- start: 탭버튼 -->
		<div class="detailInfoTabWrap">
			<div class="tabBox">
				<span id="prodINfo" class="detailTab_1"><?=$LNG_TRANS_CHAR["OW00001"] //상세정보?></span>
				<?if ($S_PRODUCT_BBS_REVIEW_USE == "Y"){?>
					<a href="#review" class="scroll leftLine detailTab_2"><?=$LNG_TRANS_CHAR["CW00031"] //사용후기?></a>
				<?}?>
				<?if ($S_PRODUCT_BBS_QNA_USE == "Y"){?>
					<a href="#prodQna" class="scroll detailTab_3"><?=$LNG_TRANS_CHAR["CW00024"] //상품Q&A?></a>
				<?}?>
				<a href="#delivery" class="detailTab_4"><?=$LNG_TRANS_CHAR["CW00032"] //배송&교환반품안내?></a>
				<!-- a href="#return"><img src="./himg/product/A0001/tab_prod_5.gif"/></a -->
				<div class="clear"></div>
			</div>
		</div>
	<!-- end: 탭버튼 -->

	<div class="mt20">
		<?=$prodRow[P_WEB_TEXT]?>
		<?if ($S_FIX_PROD_BASIC_ITEM_USE == "Y"){?>
		<!-- 상품스팩 -->
		<h4 class="ex_tit">상품 상세스펙</h4>
		<div class="spec_Wrap">
			<table>
				<tr>
					<th class="col_1">구분</th>
					<th class="col_2">상세설명</th>
				</tr>
				<?
				if (is_array($aryProdItem)){

					for($i=0;$i<sizeof($aryProdItem);$i++){
				?>
				<tr>
					<td><?=$aryProdItem[$i][PI_NAME]?> </td>
					<td><?=$aryProdItem[$i][PI_TEXT]?> </td>
				</tr>
				<?	}}?>
			</table>
		</div>
<!-- 상품스팩 -->
		<?}?>
	</div>

</div>