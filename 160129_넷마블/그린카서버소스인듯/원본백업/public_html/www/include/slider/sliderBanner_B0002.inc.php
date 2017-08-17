<?
	
	$sb_no				= $ARY_VAL['SB_NO'];
	$im_code			= $ARY_VAL['IM_CODE'];
	
	include sprintf ( "%s%s/conf/sliderBanner/sliderBanner_%s_%d.conf.inc.php", $S_DOCUMENT_ROOT, $S_SHOP_HOME, $im_code, $sb_no );

	$sliderWidth		= $S_SLIDER_INFO[$sb_no]['SB_W_SIZE'];
	$sliderHeight		= $S_SLIDER_INFO[$sb_no]['SB_H_SIZE'];
	$linkType			= $S_SLIDER_INFO[$sb_no]['SB_LINK_TYPE'];		// M => 현재 페이지 열기, B => 새창으로 열기, N => 연결 없음
	$img				= $S_SLIDER_INFO[$sb_no]['SI_IMG'];
	$text				= $S_SLIDER_INFO[$sb_no]['SI_TEXT'];
	$link				= $S_SLIDER_INFO[$sb_no]['SI_LINK'];	


?>

<style>
	#container		{width: <?=$sliderWidth?>px;;position: relative;}
	div#slideshow	{width: <?=$sliderWidth?>px; height: <?=$sliderHeight?>px;overflow: scroll; /* Allows the slides to be viewed using scrollbar if Javascript isn't available */ 
					 position: relative; z-index: 5;}

	div#slideshow ul#nav {display: none;list-style: none;position: relative; top: 210px; z-index: 15;}
	div#slideshow ul#nav li#prev {float: left; margin: 0 0 0 40px;}
	div#slideshow ul#nav li#next {float: right; margin: 0 0px 0 0;}
	div#slideshow ul#nav li a {display: block; width: 80px; height: 80px; text-indent: -9999px;}
	div#slideshow ul#nav li#prev a {background: url(/himg/slider/A0002/btn_slider_prev.png) no-repeat;}
	div#slideshow ul#nav li#next a {background: url(/himg/slider/A0002/btn_slider_next.png) no-repeat;}

	div#slideshow ul#slides {list-style: none;}
	div#slideshow ul#slides li {margin: 0 0 20px 0;}
</style>

<script>
	$(document).ready(function() {
		$("#slideshow").css("overflow", "hidden");

		$("ul#slides").cycle({
			fx: 'fade',
			pause: 1,
			prev: '#prev',
			next: '#next'
		});

		$("#slideshow").hover(function() {
			$("ul#nav").fadeIn();
			},
				function() {
			$("ul#nav").fadeOut();
			});
	});
</script>

<div id="container">
	<div id="slideshow">
		<ul id="nav">
			<li id="prev"><a href="#">Previous</a></li>
			<li id="next"><a href="#">Next</a></li>
		</ul>
	
		<ul id="slides">
			<!-- 해당샵의 등록된 이미지 -->
					<?	$intCnt=1;
						foreach($img as $fileName) : 
							$html = sprintf("<img id='slide-img-%d' src='../upload/slider/%s'  width='%dpx' height='%dpx' class='slide'/>", $intCnt, $fileName, $sliderWidth, $sliderHeight);
							if($link[$intCnt-1] && $linkType != "N") :
								$target = ($linkType == "B") ? " target=\"_blank\"" : ""; 
								$html	= sprintf("<a href=\"%s\"%s>%s</a>", $link[$intCnt-1], $target, $html);
							endif;
							echo $html;
							$intCnt++;
						endforeach; ?>
			<!-- 해당샵의 등록된 이미지 -->
		</ul>
	</div>
</div>

