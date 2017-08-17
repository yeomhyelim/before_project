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
	div.wrap {width:<?=$sliderWidth?>px;margin:0 auto;text-align:left;}
	div#header div#slide-holder {z-index:40;position:absolute;}

	/** 슬라이드 이미지 **/
	div#header div#slide-holder div#slide-runner{top:0px;left:0px;overflow:hidden;position:absolute;}
	div#header div#slide-holder img {margin : 0;display : none;position : absolute;}

	/** 텍스트 배경 **/
	div#header div#slide-holder div#slide-controls {left:0;bottom:0px;width:<?=$sliderWidth?>px;height:46px;display:none;position:absolute;background : url(/himg/slider/A0001/slide-bg.png) 0 0;}
	div#header div#slide-holder div#slide-controls p.text{float:left;color:#fff;display:inline;font-size:11px;line-height:16px;margin:15px 0 0 20px;text-transform:uppercase;}
	div#header div#slide-holder div#slide-controls p#slide-nav{float:right;height: 24px;display: inline;margin: 11px 15px 0 0;}
	div#header div#slide-holder div#slide-controls p#slide-nav a{float:left;width:24px;height:24px;display: inline;font-size: 11px;margin: 0 5px 0 0;line-height: 24px;font-weight: bold;text-align: center;text-decoration: none;background-position: 0 0;background-repeat: no-repeat;}

	/** 버튼 숫자 **/
	div#header div#slide-holder div#slide-controls p#slide-nav a.on {background-position : 0 -24px;}
	div#header div#slide-holder div#slide-controls p#slide-nav a{color:#FFF;background-image : url(/himg/slider/A0001/silde-nav.png);}
	div#nav ul li a{color:#FFF;background : url(/himg/slider/A0001/nav.png) no-repeat;}

	div#header div#slide-holder div#slide-runner{width:<?=$sliderWidth?>px;height:<?=$sliderHeight?>px;} /* 이미지 크기 지정*/
	div#header div.wrap{height:<?=$sliderHeight?>px;}
	div#header div#slide-holder {width:<?=$sliderWidth?>px;height:<?=$sliderHeight?>px;}
</style>
<!--/top-->
  <div id="header">
	<div class="wrap">
	   <div id="slide-holder">
			<div id="slide-runner">
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
				<div id="slide-controls">
				 <p id="slide-desc" class="text"></p>
				 <p id="slide-nav"></p>
				</div>
			</div>	
		<!--content featured gallery here -->
	   </div><!-- slide-holder -->
	   <script type="text/javascript">
		if(!window.slider) var slider={};slider.data=[
		<?	$intCnt=1;
			foreach($img as $fileName) : ?>
		{"id":"slide-img-<?=$intCnt?>","client":"eumshop","desc":"<?=$text[$intCnt-1]?>"}<?=(sizeof($img) > $intCnt) ? ",\r\n" : "\r\n";?>
		<?	$intCnt++;
			endforeach; ?>
		];
	   </script>
  </div><!-- wrap -->
</div><!--/header-->