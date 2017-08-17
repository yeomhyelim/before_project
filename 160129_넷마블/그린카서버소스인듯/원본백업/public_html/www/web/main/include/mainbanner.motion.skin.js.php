<?
	## 설정

	## 2013.07.12 kim hee sung 추가
	## 슬라이더 이미지 네비 사용 유무
	$generatePagination = "true";
	if($MAIN_SLIDER_IMG_NAVI == "HIDE") { $generatePagination = "false"; }
?>
<script language="javascript" type="text/javascript" src="../common/js/slides.jquery.js"></script>
<script>
	$(function(){
		// Initialize Slides
		$('#mainbanner_motion2').slides({
			container: 'mainbanner_container',
			generatePagination: <?=$generatePagination?>,
			play: 4000,
			pause: 4000,
			slideSpeed: 1000,
			start: 1,
			effect:'<?=$effect?>'
			<?if($effect=="fade"){?>
			,fadeSpeed:1000
			<?}?>
			<?if($sliderMotionType){?>
			,ways:'<?=$sliderMotionType?>'
			<?}?>
		});
	});
</script>

