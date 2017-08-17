<div class="detailInfoArea">
	<!-- 상세정보 -->
		<div class="detailArea">
			<!-- start: 탭버튼 -->
			<?php $select='detail'; include MALL_HOME . "/web/product/include/tabMenu.inc.php";?>
			<!-- end: 탭버튼 -->
			<div class="mt20">
				<?=$prodRow['P_WEB_TEXT']?>
			</div>

			<!-- start: 상품고시 -->
			<?php if($S_PRODUCT_NOTIFY_USE && $strLang == "KR"):?>
				<div class="prodAdInfoWrap">
					<h3></h3>
					<table class="infoTable">
					<?
							if (is_array($arrProdNotifyInfo)){
								foreach($arrProdNotifyInfo as $key => $prodNotifyInfoRow){
									?>
									<tr>
										<th class="txtName"><?=$prodNotifyInfoRow['PN_NAME']?></th>
										<td class="txtInfo"><?=$prodNotifyInfoRow['PN_TEXT']?></td>
									</tr>
									<?
								
								}
							}
						?>
					</table>
				</div>
			<?php endif;?>
			<!-- end: 상품고시 -->
		</div>
	<!-- 상세정보 -->

	<!-- 관련상품 -->
		<div class="relationListArea">
			<? include "relationList.index.inc.php" // 관련상품 ?>
		</div>
	<!-- 관련상품 -->
</div>