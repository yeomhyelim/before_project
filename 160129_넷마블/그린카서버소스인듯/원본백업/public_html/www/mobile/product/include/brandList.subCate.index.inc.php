<?
	# 브랜드 상품 리스트 / 서브 카테고리
	# prodList.subCate.index.inc.php
?>


<?
	$strUse			= $S_BRAND_LIST_SUB_CATE_USE;
	$strView		= $S_BRAND_LIST_SUB_CATE_VIEW;	
	$strCate1Mode	= $S_BRAND_LIST_CATE_L1_MODE;
	$strCate2Mode	= $S_BRAND_LIST_CATE_L2_MODE;
	$strCate3Mode	= $S_BRAND_LIST_CATE_L3_MODE;
	$strCate4Mode	= $S_BRAND_LIST_CATE_L4_MODE;

	if($strUse == "Y"):
		// 서브 카테고리 사용
		if(is_array($S_ARY_CATE1)) :

		if($S_BRAND_LIST_CATE_L1_MODE != "N") :
			// 1차 카테고리
			$cate1Html	= "";
			$cateLink	= "<a href=\"./?menuType=product&mode=brandList&pr_no=$intPR_NO&lcate=%s&mcate=%s\"%s>%s</a>";
			$cateImg	= "<img src='%s' onmouseout=\"cateMouseOverOut(this,'%s')\" onmouseover=\"cateMouseOverOut(this,'%s')\"/>"; 
			echo "<div class=\"prodBrandCateWrap\">";
			if (is_array($S_ARY_CATE1)) :
				echo "<ul>";
				for($i = 0;$i < sizeof($S_ARY_CATE1); $i++):
					$cate1Html = $S_ARY_CATE1[$i]['NAME'];
					if(!$cate1Html) { continue; }
					if($S_BRAND_LIST_CATE_L1_MODE == "I") :
						$cate1Html = sprintf($cateImg, $S_ARY_CATE1[$i]['IMG1'], $S_ARY_CATE1[$i]['IMG1'], $S_ARY_CATE1[$i]['IMG2']);
					endif;
					$selectedNavi	= ($strSearchHCode1 == $S_ARY_CATE1[$i]['CODE']) ? " class=\"selectedNavi\"" : "";
					$cate1Html = sprintf($cateLink, $S_ARY_CATE1[$i]['CODE'], "", $selectedNavi, $cate1Html);
					echo "<li class='cate1'>";
					echo $cate1Html;
					if($S_BRAND_LIST_CATE_L2_MODE != "N") :
						// 2차 카테고리
						if (is_array($S_ARY_CATE2)) :
							for($j = 0;$j < sizeof($S_ARY_CATE2); $j++):
								$cate2Html = $S_ARY_CATE2[$i][$j]['NAME'];
								if(!$cate2Html) { continue; }
								if($S_BRAND_LIST_CATE_L2_MODE == "I") :
									$cate2Html = sprintf($cateImg, $S_ARY_CATE2[$i][$j]['IMG1'], $S_ARY_CATE2[$i][$j]['IMG1'], $S_ARY_CATE2[$i][$j]['IMG2']);
								endif;
								$selectedNavi	= ($strSearchHCode2 == $S_ARY_CATE2[$i][$j]['CODE']) ? " class=\"selectedNavi\"" : "";
								$cate2Html = sprintf($cateLink, $S_ARY_CATE2[$i][$j]['CODE'], "", $selectedNavi, $cate2Html);
								echo "<li class='cate2'>";
								echo $cate2Html;
								echo "</li>";
							endfor;
						endif;
						// 2차 카테고리
					endif;
					echo "</li>";
				endfor;
				echo "</ul><div class=\"clr\"></div>";
			endif;
			echo "</div>";
			// 1차 카테고리
		endif;

		endif;
	endif;

?>



