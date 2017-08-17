<?
	# 메인 이미지 배너 스킨
	# mainbanner.motion.effect1.skin.html.php
	include "mainbanner.motion.skin.js.php";
?>



<style>
/*--
	.mainbanner_motion2 .slide {width:<?=$sliderWidth?>px;height:<?=$sliderHeight?>px;display:block;}
	.mainbanner_motion2 .slides_container {width:<?=$sliderWidth?>px;height:<?=$sliderHeight?>px;overflow:hidden;position:relative;display:none;}
	.mainbanner_motion2 .pagination li {float:left;margin:0 1px;list-style:none;}
	.mainbanner_motion2 .pagination li.current a {float:left;margin:0 1px;list-style:none;border:1px solid #555555;}
--*/
</style>

	<div id="mainbanner_motion2" class="mainbanner_motion2">
		<div class="mainbanner_container">
		<!-- 해당샵의 등록된 이미지 -->
			<?	$intCnt=1;
				foreach($img as $fileName) :  
					$html = sprintf("<img src='../upload/slider/%s'/>", $fileName);  ?>
			<div class="slide">
			<?=$html?>
			</div>	
			<?	endforeach; ?>
		<!-- 해당샵의 등록된 이미지 -->
		</div>
		<ul class="pagination">
		<!-- 해당샵의 등록된 이미지 -->
			<?	foreach($img as $fileName) :  
					$html = sprintf("<img src='../upload/slider/%s' width='55'/>", $fileName);  ?>
			<li><a href="#"><?=$html?></a></li>
			<?	endforeach; ?>
		<!-- 해당샵의 등록된 이미지 -->
		</ul>
	</div>

