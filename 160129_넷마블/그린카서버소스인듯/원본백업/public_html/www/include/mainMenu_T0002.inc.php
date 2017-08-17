
<? $hrefFmt = "./?menuType=product&mode=list&lcate=%s&mcate=%s&scate=%s&fcate=%s"; ?>
<? for($i = 0;$i < sizeof($S_ARY_CATE1); $i++):	// 카테고리1?>
<? $href = sprintf($hrefFmt, $S_ARY_CATE1[$i]['CODE'], "", "", ""); ?>
<ul class="cate1">
	<li><a href="<?=$href?>"><?=$S_ARY_CATE1[$i]['NAME']?></a></li>
	<li>
		<ul class="cate2">
		<? for($j = 0;$j < sizeof($S_ARY_CATE2[$i]); $j++): // 카테고리2?>
		<? if($S_ARY_CATE1[$i]['CODE'] == substr($S_ARY_CATE2[$i][$j]['CODE'], 0, 3)): ?>
		<? $href = sprintf($hrefFmt, $S_ARY_CATE1[$i]['CODE'], substr($S_ARY_CATE2[$i][$j]['CODE'], 3, 6), "", ""); ?>
			<li><a href="<?=$href?>"><?=$S_ARY_CATE2[$i][$j]['NAME']?></a></li>
			<li>
				<ul class="cate3">
				<? for($k = 0;$k < sizeof($S_ARY_CATE3[$i][$j]); $k++): // 카테고리3?>
				<? if($S_ARY_CATE2[$i][$j]['CODE'] == substr($S_ARY_CATE3[$i][$j][$k]['CODE'], 0, 6)): ?>
				<? $href = sprintf($hrefFmt, $S_ARY_CATE1[$i]['CODE'], substr($S_ARY_CATE2[$i][$j]['CODE'], 3, 6), substr($S_ARY_CATE3[$i][$j][$k]['CODE'], 6, 9), ""); ?>
					<li><a href="<?=$href?>"><?=$S_ARY_CATE3[$i][$j][$k]['NAME']?></a></li>
					<li>
						<ul class="cate3">
						<? for($l = 0;$l < sizeof($S_ARY_CATE4[$i][$j][$k][$l]); $l++): // 카테고리4?>
						<? if($S_ARY_CATE3[$i][$j][$k]['CODE'] == substr($S_ARY_CATE4[$i][$j][$k][$l]['CODE'], 0, 9)): ?>
						<? $href = sprintf($hrefFmt, $S_ARY_CATE1[$i]['CODE'], substr($S_ARY_CATE2[$i][$j]['CODE'], 3, 6), substr($S_ARY_CATE3[$i][$j][$k]['CODE'], 6, 9), substr($S_ARY_CATE4[$i][$j][$k][$l]['CODE'], 9, 12)); ?>
							<li><a href="<?=$href?>"><?=$S_ARY_CATE4[$i][$j][$k][$l]['NAME']?></a></li>
						<? endif;?>
						<? endfor; // 카테고리4?>
						</ul>
					</li>
				<? endif; ?>
				<? endfor; // 카테고리3?>
				</ul>
			</li>
		<? endif;?>
		<? endfor; // 카테고리2?>
		</ul>
	</li>
</ul>
<? endfor; // 카테고리1?>













<?






//	$S_PRODUCT_CATE_L1_MODE = "Y";
//	$S_PRODUCT_CATE_L2_MODE	= "Y";
//
//		if($S_PRODUCT_CATE_L1_MODE != "N") :
//			// 1차 카테고리
//			$cate1Html	= "";
//			$cateLink	= "<a href=\"./?menuType=product&mode=list&lcate=%s&mcate=%s\">%s</a>";
//			$cateImg	= "<img src='%s' onmouseout=\"cateMouseOverOut(this,'%s')\" onmouseover=\"cateMouseOverOut(this,'%s')\"/>"; 
//			if (is_array($S_ARY_CATE1)) :
//				for($i = 0;$i < sizeof($S_ARY_CATE1); $i++):
//					if($S_ARY_CATE1[$i]['CODE'] == $strSearchHCode1) :
//						$cate1HtmlTemp = $S_ARY_CATE1[$i]['NAME'];
//						if($S_PRODUCT_CATE_L1_MODE == "I") :
//							$cate1HtmlTemp = sprintf($cateImg, $S_ARY_CATE1[$i]['IMG1'], $S_ARY_CATE1[$i]['IMG1'], $S_ARY_CATE1[$i]['IMG2']);
//						endif;
//						$cate1Html .= sprintf($cateLink, $S_ARY_CATE1[$i]['CODE'], "", $cate1HtmlTemp);
//					endif;
//				endfor;
//			endif;
//
//			if($S_PRODUCT_CATE_L2_MODE != "N") :
//				// 2차 카테고리
//				$cate2Html	= "";
//				if (is_array($S_ARY_CATE2[$i])) :
//					for($j = 0;$j < sizeof($S_ARY_CATE2[$i]); $j++):
//						$cate2Html_Temp = $S_ARY_CATE2[$i][$j]['NAME'];
//						if($S_PRODUCT_CATE_L2_MODE == "I") :
//							$cate2Html_Temp = sprintf($cateImg, $S_ARY_CATE2[$i][$j]['IMG1'], $S_ARY_CATE2[$i][$j]['IMG1'], $S_ARY_CATE2[$i][$j]['IMG2']);
//						endif;
//						$cate2Html_Temp = sprintf($cateLink, $S_ARY_CATE2[$i][$j]['CODE'], "", $cate2Html_Temp);
//						$cate2Html		.= ($cate2Html) ? " | " : "";
//						$cate2Html		.= $cate2Html_Temp;
//					endfor;
//				endif;			
//			endif;
//		endif;


?>

<div class="prodSubCateWrap">
<?=$cate1Html?><?=$cate2Html?>
</div>
<br>