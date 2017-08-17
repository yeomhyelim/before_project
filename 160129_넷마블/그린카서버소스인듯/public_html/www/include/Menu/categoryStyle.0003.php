<?
	$aryMainBanner		= array(		"{$S_DOCUMENT_ROOT}{$S_SHOP_HOME}/layout/banner/banner_23.html.php",
										"{$S_DOCUMENT_ROOT}{$S_SHOP_HOME}/layout/banner/banner_24.html.php",
										"{$S_DOCUMENT_ROOT}{$S_SHOP_HOME}/layout/banner/banner_25.html.php",
										"{$S_DOCUMENT_ROOT}{$S_SHOP_HOME}/layout/banner/banner_26.html.php",
										"{$S_DOCUMENT_ROOT}{$S_SHOP_HOME}/layout/banner/banner_27.html.php"			);

	/* 2013.04.18 prodBrand 추가 */
	/* 2013.04.22 링스데이 전용페이지로 구분됨. (기능 필요 없을때 삭제 가능) */
	$prodBrandConfName	= "{$S_DOCUMENT_ROOT}{$S_SHOP_HOME}/conf/prodBrand.conf.inc.php";
	if(is_file($prodBrandConfName)) { require_once 	$prodBrandConfName; }
?>

<script>
	function goTabMenu(no) {
		var img					= $("#MainBanner_"+no).find("img");	
		$("<img/>").attr("src", $(img).attr("src")).load(function() {
			$("#MainBanner_"+no).find("img").css("bottom","-"+this.height+"px");
		});
	}
</script>

<? $hrefFmt				= "./?menuType=product&mode=list&lcate=%s&mcate=%s&scate=%s&fcate=%s"; ?>
<? $prodBrandHrefFmt	= "./?menuType=product&mode=brandList&pr_no=%s";?>
<div id="menu-outer" class="pre-load" role="navigation" aria-label="Site Navigation">
	<ul id="menu">
		<!--loof//-->
		<? for($i = 0;$i < sizeof($S_ARY_CATE1); $i++):	// 카테고리1?>
		<? $href = sprintf($hrefFmt, $S_ARY_CATE1[$i]['CODE'], '', '', ''); ?>
		<li id="women" class="tab selected cols<?=sizeof($S_ARY_CATE2[$i])?>" onmouseOver="goTabMenu(<?=$i?>)"><a href="<?=$href?>" class="<?=$className1?>"><?=$S_ARY_CATE1[$i]['NAME']?></a>
		<div class="menu">
			<? if($S_ARY_CATE1[$i]['NAME'] == "BRAND"): // 2013.04.18 브랜드 영역 추가?>
			<? foreach($PROD_BRAND as $pr_no => $prodBrand):?>
			<? $prodBrandHref = sprintf($prodBrandHrefFmt, $pr_no);?>
			<div><ul><li class="sub-heading h4"><a href="<?=$prodBrandHref?>" class="<?=$className2?>"><?=$prodBrand['PR_NAME']?></a></li></ul>
			</div>		
			<? endforeach;?>
			<? else:?>
			<? for($j = 0;$j < sizeof($S_ARY_CATE2[$i]); $j++): // 카테고리2?>
			<? if($S_ARY_CATE1[$i]['CODE'] != substr($S_ARY_CATE2[$i][$j]['CODE'], 0, 3)){ continue; } ?>
			<? $href = sprintf($hrefFmt, $S_ARY_CATE1[$i]['CODE'], substr($S_ARY_CATE2[$i][$j]['CODE'], 3, 6), '', ''); ?>
			<div>
			<ul>
				<li class="sub-heading h4"><a href="<?=$href?>" class="<?=$className2?>"><?=$S_ARY_CATE2[$i][$j]['NAME']?></a></li>
					<? for($k = 0;$k < sizeof($S_ARY_CATE3[$i][$j]); $k++): // 카테고리3?>
					<? if($S_ARY_CATE2[$i][$j]['CODE'] != substr($S_ARY_CATE3[$i][$j][$k]['CODE'], 0, 6)){ continue; } ?>
					<? $href = sprintf($hrefFmt, $S_ARY_CATE1[$i]['CODE'], substr($S_ARY_CATE2[$i][$j]['CODE'], 3, 6), substr($S_ARY_CATE3[$i][$j][$k]['CODE'], 6, 9), ''); ?>
					<li><a href="<?=$href?>" class="<?=$className3?>"><?=$S_ARY_CATE3[$i][$j][$k]['NAME']?></a></li>
					<? endfor; // 카테고리3?>
				</ul>
			</div>
			<? endfor; // 카테고리2?>
			<? endif;?>
		<!-- BEGIN: Promotion -->
		<div id="MainBanner_<?=$i?>" class="<?=sizeof($S_ARY_CATE2[$i])?>" style="">
			<?include $aryMainBanner[$i] ?>
		</div>
		</li>
		<? endfor; // 카테고리1?>
		<!--loof//-->
	</ul>
	
<div>



