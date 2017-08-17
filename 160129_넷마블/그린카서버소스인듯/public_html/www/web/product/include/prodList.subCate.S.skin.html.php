<?
	# 상품리스트 / 선택 카테고리 사용 (S)
	# prodList.subCate.skin.S.html.php
?>



<div class="prodSubCateWrap">
<?
	$aryCate		= "";
	$strImgSrc1		= "<img src='%s' />";
	$strImgSrc2		= "<img src='%s' onmouseout=\"cateMouseOverOut(this,'%s');\" onmouseover=\"cateMouseOverOut(this,'%s');\"/>";
	$strPageHref	= "<a href='?menuType=product&mode=list&lcate=%s&mcate=%s&scate=%s&fcate=%s'>%s</a>";
	foreach($aryCateList as $cateList1):
		if($cateList1['CODE']):
			// 1차 카테고리
			echo "1";
		else:
			foreach($cateList1 as $cateList2):
			if($cateList2['CODE']):
				// 2차 카테고리
				if($strSearchHCode1 == substr($cateList2['CODE'],0,3)):
					$strHtml = $cateList2['NAME'];
					if($cateList2['IMG1'] && !$cateList2['IMG2']):
						$strHtml = sprintf($strImgSrc1, $cateList2['IMG1']);
					elseif($cateList2['IMG1'] && $cateList2['IMG2']):
						$strHtml = sprintf($strImgSrc2, $cateList2['IMG1'], $cateList2['IMG1'], $cateList2['IMG2']);
					endif;
					$strHtml = sprintf($strPageHref, $strSearchHCode1, substr($cateList2['CODE'],3),"","",$strHtml);
					echo $strHtml;
				endif;
			else:
				foreach($cateList2 as $cateList3):
					if($cateList3['CODE']):
						// 3차 카테고리
					else:
						foreach($cateList3 as $cateList4):
							// 4차 카테고리
						endforeach;
					endif;
				endforeach;
			endif;
			endforeach;
		endif;
	endforeach;
?>
</div>
