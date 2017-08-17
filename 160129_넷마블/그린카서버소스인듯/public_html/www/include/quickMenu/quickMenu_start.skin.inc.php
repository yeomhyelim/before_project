<?
	## 설명
	## 작성자 : kim hee sung
	## 작성일 : 2013.06.11
	## 내  용 : 퀵메뉴

	if($S_QUICK_MENU_USE_1=="Y") : 

		if(!$S_QUICK_MENU_TOP_1)		{ $S_QUICK_MENU_TOP_1	= 0; }
		if(!$S_QUICK_MENU_LEF_1)		{ $S_QUICK_MENU_LEF_1	= 0; }
		if(!$$S_QUICK_MENU_SPE_1)		{ $S_QUICK_MENU_SPE_1	= 500; }
		if(!$S_QUICK_MENU_PIMG_SIZ_1)	{ $S_QUICK_MENU_PIMG_SIZ_1 = "60*90"; } 
		$aryQuickMenuProdImg		= explode("*", $S_QUICK_MENU_PIMG_SIZ_1);	

?>
	<script type="text/javascript">
		<!--
			var intTopPos			= <?=$S_QUICK_MENU_TOP_1?>;		// 상단 위치
			var intSpeed			= <?=$S_QUICK_MENU_SPE_1?>;		// 속도

			$(document).ready(function() {
			<?if($S_QUICK_MENU_EFFECT_1 == "F"): // 상단 메뉴 고정?>

			<?elseif($S_QUICK_MENU_EFFECT_1 == "S"): // 퀵메뉴 항상 보임?>
				var intQuickTopPos	= intTopPos;
				$("div#quickMenu").css({'position':'fixed', 'top':intQuickTopPos + 'px'});
			//	$(window).scroll(function() {	
			//			var intQuickTopPos	= intTopPos;
			//			$("div#quickMenu").css({'position':'fixed', 'top':intQuickTopPos + 'px'});
			//	});
			<?elseif($S_QUICK_MENU_EFFECT_1 == "A"): // 퀵메뉴 효과 A?>
				var intQuickTopPos	= intTopPos;
				$("div#quickMenu").css({'position':'absolute', 'top':intQuickTopPos + 'px'});
				$(window).scroll(function() {
					var intQuickTopPos	= ($(document).scrollTop() < intTopPos) ? intTopPos : $(document).scrollTop() + 10;
					$("div#quickMenu").stop();
					$("div#quickMenu").animate({ "top": intQuickTopPos + "px" }, intSpeed ); 
				});
			<?endif;?>
			});
		//-->
	</script>

	<div class="quickWrap" id="quickMenu" style="top:<?=$S_QUICK_MENU_TOP_1?>px;<?php if($S_QUICK_MENU_LEF_1){echo "margin-left:{$S_QUICK_MENU_LEF_1}px;";}?>">
<? endif; ?>