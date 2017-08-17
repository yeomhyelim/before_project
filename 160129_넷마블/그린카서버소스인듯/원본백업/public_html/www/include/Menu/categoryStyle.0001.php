<?
	## STEP 1.
	## 설정
	$category_use	= $S_MAIN_SUB_CATE_USE1; // 사용유무
	$category_1_use = $S_MAIN_CATE_L1_MODE1; // 카테고리 레벨1 사용 유무
	$category_2_use = $S_MAIN_CATE_L2_MODE1; // 카테고리 레벨2 사용 유무
	$category_3_use = $S_MAIN_CATE_L3_MODE1; // 카테고리 레벨3 사용 유무
	$category_4_use = $S_MAIN_CATE_L4_MODE1; // 카테고리 레벨4 사용 유무

	if(!$strSearchHCode1) { $strHCode1 = "001"; }
	else { $strHCode1 = $strSearchHCode1; }
 
?>

<? if($category_use == "Y"): ?>
<? $hrefFmt		= "./?menuType=product&mode=list&lcate=%s&mcate=%s&scate=%s&fcate=%s"; ?>
<? for($i = 0;$i < sizeof($S_ARY_CATE1); $i++):	// 카테고리1?>
<? if($S_ARY_CATE1[$i]['SHARE'] == "Y") { continue; } ?>
<? $href		= sprintf($hrefFmt, $S_ARY_CATE1[$i]['CODE'], "", "", ""); ?>
<? $className1	= ($strHCode1 ==  $S_ARY_CATE1[$i]['CODE']) ? "selectedNavi" : ""; ?>
<ul class="cate1">
	<? if($category_1_use == "T") : ?>	
		<!-- html -->
		<? if($S_ARY_CATE1[$i]['IMG1']): // 이미지1가 있을 때 ?>
			<? if($S_ARY_CATE1[$i]['IMG2']): // 이미지2가 있을때 ?>
				<li><a href="<?=$href?>" class="<?=$className1?>"><img src="<?=$S_ARY_CATE1[$i]['IMG1']?>" 
					   onmouseover="cateMouseOverOut(this,'<?=$S_ARY_CATE1[$i]['IMG2']?>')" onmouseout="cateMouseOverOut(this,'<?=$S_ARY_CATE1[$i]['IMG1']?>')"></a><!--/li-->
			<? else: // 이미지2가 없을 때 ?>
				<li><a href="<?=$href?>" class="<?=$className1?>"><img src="<?=$S_ARY_CATE1[$i]['IMG1']?>"></a><!--/li-->
			<? endif;?>
		<? else: // 이미지1가 없을 때 ?>
			<li><a href="<?=$href?>" class="<?=$className1?>"><?=$S_ARY_CATE1[$i]['NAME']?></a><!--/li-->
		<? endif; ?>
		<!-- html -->
	<? endif; ?>
	<!--li-->
		<ul class="cate2">
		<? for($j = 0;$j < sizeof($S_ARY_CATE2[$i]); $j++): // 카테고리2?>	
		<? if($S_ARY_CATE1[$i]['CODE'] == substr($S_ARY_CATE2[$i][$j]['CODE'], 0, 3)): ?>
		<? $href = sprintf($hrefFmt, $S_ARY_CATE1[$i]['CODE'], substr($S_ARY_CATE2[$i][$j]['CODE'], 3, 6), "", ""); ?>
		<? $className2	= ($strHCode1.$strSearchHCode2 ==  $S_ARY_CATE2[$i][$j]['CODE']) ? "selectedNavi" : ""; ?>
			<? if($category_2_use == "T") : ?>
				<? if($category_1_use == "T" || ($category_1_use == "N" && $strHCode1 == $S_ARY_CATE1[$i]['CODE'])):?>
					<!-- html -->
					<? if($S_ARY_CATE2[$i][$j]['IMG1']): // 이미지1가 있을 때 ?>
						<? if($S_ARY_CATE2[$i][$j]['IMG2']): // 이미지2가 있을때 ?>
							<li><a href="<?=$href?>" class="<?=$className2?>"><img src="<?=$S_ARY_CATE2[$i][$j]['IMG1']?>" 
								   onmouseover="cateMouseOverOut(this,'<?=$S_ARY_CATE2[$i][$j]['IMG2']?>')" onmouseout="cateMouseOverOut(this,'<?=$S_ARY_CATE2[$i][$j]['IMG1']?>')"></a><!--/li-->
						<? else: // 이미지2가 없을 때 ?>
							<li><a href="<?=$href?>" class="<?=$className2?>"><img src="<?=$S_ARY_CATE2[$i][$j]['IMG1']?>"></a><!--/li-->
						<? endif;?>
					<? else: // 이미지1가 없을 때 ?>
						<li><a href="<?=$href?>" class="<?=$className2?>"><?=$S_ARY_CATE2[$i][$j]['NAME']?></a><!--/li-->
					<? endif; ?>
					<!-- html -->
				<? endif; ?>
			<? endif; ?>
			<!--li-->
				<ul class="cate3">
				<? for($k = 0;$k < sizeof($S_ARY_CATE3[$i][$j]); $k++): // 카테고리3?>
				<? if($S_ARY_CATE2[$i][$j]['CODE'] == substr($S_ARY_CATE3[$i][$j][$k]['CODE'], 0, 6)): ?>
				<? $href = sprintf($hrefFmt, $S_ARY_CATE1[$i]['CODE'], substr($S_ARY_CATE2[$i][$j]['CODE'], 3, 6), substr($S_ARY_CATE3[$i][$j][$k]['CODE'], 6, 9), ""); ?>
				<? $className3	= ($strHCode1.$strSearchHCode2.$strSearchHCode3 ==  $S_ARY_CATE3[$i][$j][$k]['CODE']) ? "selectedNavi" : ""; ?>
					<? if($category_3_use == "T") : ?>
					<? if($category_1_use == "T" || ($category_1_use == "N" && $strHCode1 == $S_ARY_CATE1[$i]['CODE'])):?>
						<!-- html -->
						<? if($S_ARY_CATE3[$i][$j][$k]['IMG1']): // 이미지1가 있을 때 ?>
							<? if($S_ARY_CATE3[$i][$j][$k]['IMG2']): // 이미지2가 있을때 ?>
								<li><a href="<?=$href?>" class="<?=$className3?>"><img src="<?=$S_ARY_CATE3[$i][$j][$k]['IMG1']?>" 
									   onmouseover="cateMouseOverOut(this,'<?=$S_ARY_CATE3[$i][$j][$k]['IMG2']?>')" onmouseout="cateMouseOverOut(this,'<?=$S_ARY_CATE3[$i][$j][$k]['IMG1']?>')"></a><!--/li-->
							<? else: // 이미지2가 없을 때 ?>
								<li><a href="<?=$href?>" class="<?=$className3?>"><img src="<?=$S_ARY_CATE3[$i][$j][$k]['IMG1']?>"></a><!--/li-->
							<? endif;?>
						<? else: // 이미지1가 없을 때 ?>
							<li><a href="<?=$href?>" class="<?=$className3?>"><?=$S_ARY_CATE3[$i][$j][$k]['NAME']?></a><!--/li-->
						<? endif; ?>
						<!-- html -->
					<? endif; ?>
					<? endif; ?>
					<!--li-->
						<ul class="cate4">
						<? for($l = 0;$l < sizeof($S_ARY_CATE4[$i][$j][$k]); $l++): // 카테고리4?>
						<? if($S_ARY_CATE3[$i][$j][$k]['CODE'] == substr($S_ARY_CATE4[$i][$j][$k][$l]['CODE'], 0, 9)): ?>
						<? $href = sprintf($hrefFmt, $S_ARY_CATE1[$i]['CODE'], substr($S_ARY_CATE2[$i][$j]['CODE'], 3, 6), substr($S_ARY_CATE3[$i][$j][$k]['CODE'], 6, 9), substr($S_ARY_CATE4[$i][$j][$k][$l]['CODE'], 9, 12)); ?>
						<? $className4	= ($strHCode1.$strSearchHCode2.$strSearchHCode3.$strSearchHCode4 ==  $S_ARY_CATE4[$i][$j][$k][$l]['CODE']) ? "selectedNavi" : ""; ?>
							<? if($category_4_use == "T") : ?>
							<? if($category_1_use == "T" || ($category_1_use == "N" && $strHCode1 == $S_ARY_CATE1[$i]['CODE'])):?>
							<!-- html -->
							<? if($S_ARY_CATE4[$i][$j][$k][$l]['IMG1']): // 이미지1가 있을 때 ?>
								<? if($S_ARY_CATE4[$i][$j][$k][$l]['IMG2']): // 이미지2가 있을때 ?>
									<li><a href="<?=$href?>" class="<?=$className4?>"><img src="<?=$S_ARY_CATE4[$i][$j][$k][$l]['IMG1']?>" 
										   onmouseover="cateMouseOverOut(this,'<?=$S_ARY_CATE4[$i][$j][$k][$l]['IMG2']?>')" onmouseout="cateMouseOverOut(this,'<?=$S_ARY_CATE4[$i][$j][$k][$l]['IMG1']?>')"></a><!--/li-->
								<? else: // 이미지2가 없을 때 ?>
									<li><a href="<?=$href?>" class="<?=$className4?>"><img src="<?=$S_ARY_CATE4[$i][$j][$k][$l]['IMG1']?>"></a><!--/li-->
								<? endif;?>
							<? else: // 이미지1가 없을 때 ?>
								<li><a href="<?=$href?>" class="<?=$className4?>"><?=$S_ARY_CATE4[$i][$j][$k][$l]['NAME']?></a><!--/li-->
							<? endif; ?>
							<!-- html -->
							<? endif; ?>
							<? endif; ?>
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
<? endif;?>