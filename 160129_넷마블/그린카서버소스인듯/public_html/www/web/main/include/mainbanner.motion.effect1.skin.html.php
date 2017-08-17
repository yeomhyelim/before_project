<?
	# 메인 이미지 배너 스킨
	# mainbanner.motion.effect1.skin.html.php
	include "mainbanner.motion.skin.js.php";
?>

	<div id="mainbanner_motion2" class="mainbanner_motion2">
		<div class="mainbanner_container">
		<!-- 해당샵의 등록된 이미지 -->
			<?	$intCnt=1;
				foreach($img as $key => $fileName) :
				if(!$fileName) { continue; }			?>
			<div class="slide">
			<?if($link[$key]): // URL 사용?>
			<a href="<?=$link[$key]?>" target="<?=$linkType?>"><img src="/upload/slider/<?=$fileName?>"/></a>
			<?else:?>
			<img src="/upload/slider/<?=$fileName?>"/>
			<?endif;?>
			</div>	
			<?	endforeach; ?>
		<!-- 해당샵의 등록된 이미지 -->
		</div>
	</div>

