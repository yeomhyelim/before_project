<div class="contentTop">
	<h2>추가페이지 관리</h2>
</div>

<br>

<div class="tabImgWrap">
<!--<a href="?menuType=design&mode=prodpageList" <?= ($strPV_PAGE == "") ? "class='selected'" : "";?>>전체</a>  -->
	<a href="?menuType=design&mode=prodpageList&pv_page=main" <?= ($strPV_PAGE == "main") ? "class='selected'" : "";?>>메인추천</a>
	<a href="?menuType=design&mode=prodpageList&pv_page=subpage" <?= ($strPV_PAGE == "subpage") ? "class='selected'" : "";?>>서브추천</a>	
<!--<a href="?menuType=design&mode=prodpageList&pv_page=prodmain" <?= ($strPV_PAGE == "prodmain") ? "class='selected'" : "";?>>카테고리메인</a> -->	
	<a href="?menuType=design&mode=prodpageList&pv_page=prodlist" <?= ($strPV_PAGE == "prodlist") ? "class='selected'" : "";?>>상품목록</a>	
	<a href="?menuType=design&mode=prodpageList&pv_page=prodview" <?= ($strPV_PAGE == "prodview") ? "class='selected'" : "";?>>상품상세</a>	
</div>

	<!-- ******** 컨텐츠 ********* -->	
	<div class="imageListTable mt20">
		<table>
			<tr>
			<?
				$cnt = 1;
				while($row = mysql_fetch_array($result)){
					if($cnt%3 == "0") echo "<tr>";
					$img = "";
					if($row['DM_SAMPLE_IMAGE_1']) :
						$img = "<img src='" . DESIGN_LAYOUT_HOME . $row['DM_SAMPLE_IMAGE_1'] . "' style=\"width:400px;\" />";
					endif;
			?>
				<td style="vertical-align:top;">
					<div><?=$img?></div>
					<dl class="tdListUl">
						<dd><?=$row[PV_MODUL_NAME]?></dd>
						<? if ( $row['PV_PAGE'] != "subpage" ) : ?>
						<dd>{{__<?=$row[PV_PAGE]?>_<?=$row[PV_MODUL_TYPE]?>__}}</dd>
						<? else : ?>
						<dd><?= ( $row['PV_USE'] == "Y" ) ? "사용중" : "사용안함"; ?></dd>
						<? endif; ?>		
						<dd><span class="spanTitle" style="width:80px;">이미지크기</span><?=$row[PV_IMAGE_SIZE_W]?>px x <?=$row[PV_IMAGE_SIZE_H]?>px</dd>
						<dd><span class="spanTitle" style="width:80px;">상품배열</span><?=$row[PV_IMAGE_CNT_W]?>개 x <?=$row[PV_IMAGE_CNT_H]?>개</dd>
						<dd><a class="btn_sml" href="javascript:goMoveUrl('prodpageModify',<?=$row[PV_NO]?>)" id="menu_auth_m"><span>관리</span></a> </dd>
					</dl>				
			<?
				//echo $cnt%6;
				if($cnt%3 == "2") echo "</tr>";	
				$cnt++;
				}//while ?>
		</table>
	</div>
	<!-- tableList -->

	<!-- Pagenate object --> 
	<div class="paginate" style="width:400px;padding:0px 5px;">  
		<?=drawPaging($intPage,$intPageLine,$intPageBlock,$intTotal,$intTotPage,$linkPage,"","")?> 
	</div>  
	<!-- Pagenate object -->

	<div style="text-align:left;margin-top:3px;">
		<!-- a class="btn_big" href="./?menuType=design&mode=prodpageWrite" id="menu_auth_m"><strong>페이지 추가</strong></a -->
		<!-- a class="btn_blue_big" href="javascript:goMoveUrl('prodpageMake');" id="menu_auth_w"><strong>설정상태 쇼핑몰에 적용하기</strong></a -->
	</div>

	