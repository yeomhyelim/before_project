<?
	# 상품리스트 / 선택 카테고리 사용 (S)
	# prodList.subCate.skin.S.html.php
?>

<?
	if(is_array($aryCate1List)):		
		$strImgSrc1		= "<img src='%s' />";
		$strImgSrc2		= "<img src='%s' onmouseout=\"cateMouseOverOut(this,'%s');\" onmouseover=\"cateMouseOverOut(this,'%s');\"/>";
		$strPageHref	= "<a href='?menuType=product&mode=list&lcate=%s&mcate=%s&scate=%s&fcate=%s'%s>%s</a>";
		echo "<div class=\"prodSubCateWrap\"><ul>";
		foreach($aryCate1List as $cateList1):
			// 1차 카테고리 출력
			$lcate = $cateList1['CATE_CODE'];
			echo "<li>";
			if($strCate1Mode == "I"):	
				if($cateList1['CATE_IMG1']):
					if($cateList1['CATE_IMG2']):
						$cateList1['CATE_NAME'] = sprintf($strImgSrc2, $cateList1['CATE_IMG1'], $cateList1['CATE_IMG2'], $cateList1['CATE_IMG1']);
					else:
						$cateList1['CATE_NAME'] = sprintf($strImgSrc1, $cateList1['CATE_IMG1']);
					endif;
				endif;
			endif;
			$selectedNavi	= ($strSearchHCode1 == $lcate) ? " class=\"selectedNavi\"" : "";
			echo sprintf($strPageHref, $lcate, $mcate, $scate, $fcate, $selectedNavi, $cateList1['CATE_NAME']);
			if(is_array($aryCate2List)):
				foreach($aryCate2List as $cateList2):
					// 2차 카테고리 출력
					if($lcate == $cateList2['CATE_HCODE']):
						$mcate = $cateList2['CATE_CODE'];
						echo "<li>";
						if($strCate2Mode == "I"):	
							if($cateList2['CATE_IMG1']):
								if($cateList2['CATE_IMG2']):
									$cateList2['CATE_NAME'] = sprintf($strImgSrc2, $cateList2['CATE_IMG1'], $cateList2['CATE_IMG2'], $cateList2['CATE_IMG1']);
								else:
									$cateList2['CATE_NAME'] = sprintf($strImgSrc1, $cateList2['CATE_IMG1']);
								endif;
							endif;
						endif;
						$selectedNavi	= ($strSearchHCode2 == $mcate) ? " class=\"selectedNavi\"" : "";
						echo sprintf($strPageHref, $lcate, $mcate, $scate, $fcate, $selectedNavi, $cateList2['CATE_NAME']);
						echo "</li>";
					endif;
				endforeach;
			endif;
			echo "</li>";
		endforeach;
		echo "</ul><div class='clr'></div></div>";
	elseif(is_array($aryCate2List)):
		if($strSearchHCode1):
			$lcate			= $strSearchHCode1;
			$strImgSrc1		= "<img src='%s' />";
			$strImgSrc2		= "<img src='%s' onmouseout=\"cateMouseOverOut(this,'%s');\" onmouseover=\"cateMouseOverOut(this,'%s');\"/>";
			$strPageHref	= "<a href='?menuType=product&mode=list&lcate=%s&mcate=%s&scate=%s&fcate=%s'%s>%s</a>";
			echo "<div class=\"prodSubCateWrap\"><ul>";
			foreach($aryCate2List as $cateList2):
				// 2차 카테고리 출력
				if($lcate == $cateList2['CATE_HCODE']):
					$mcate = $cateList2['CATE_CODE'];
					echo "<li>";
					if($strCate2Mode == "I"):	
						if($cateList2['CATE_IMG1']):
							if($cateList2['CATE_IMG2']):
								$cateList2['CATE_NAME'] = sprintf($strImgSrc2, $cateList2['CATE_IMG1'], $cateList2['CATE_IMG2'], $cateList2['CATE_IMG1']);
							else:
								$cateList2['CATE_NAME'] = sprintf($strImgSrc1, $cateList2['CATE_IMG1']);
							endif;
						endif;
					endif;
					$selectedNavi	= ($strSearchHCode2 == $mcate) ? " class=\"selectedNavi\"" : "";
					echo sprintf($strPageHref, $lcate, $mcate, $scate, $fcate, $selectedNavi, $cateList2['CATE_NAME']);
					echo "</li>";
				endif;
			endforeach;
			echo "</ul><div class='clr'></div></div>";
		endif;
	endif;



?>