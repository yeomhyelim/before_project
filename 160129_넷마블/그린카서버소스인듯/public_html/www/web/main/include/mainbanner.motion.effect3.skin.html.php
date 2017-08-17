	<script language="javascript" type="text/javascript" src="../common/js/slides.jquery.js"></script>
	<script>
		$(function(){
			// Initialize Slides
			$('#mainbanner_motion2').slides({
				container: 'mainbanner_container',
				generatePagination:false,
				prependPagination:false,
				paginationClass:"bannerTab",
				currentClass:"selected",
				play: 4000,
				pause: 4000,
				slideSpeed: 1000,
				start: 1,
				effect:'<?=$effect?>',
				ways:'<?=$sliderMotionType?>'
			});
		});
	</script>

	<div id="mainbanner_motion2" class="mainbanner_motion2">
		<div class="mainbanner_container">
		<!-- 해당샵의 등록된 이미지 -->
			<?	$intCnt=1;
				foreach($img as $key => $fileName) :
				if(!$fileName) { continue; }			?>
			<div class="slide" <?=($key>0)?"style=\"display:none\"":"";?>>
				<?if($link[$key]): // URL 사용?>
				<a href="<?=$link[$key]?>" target="<?=$linkType?>"><img src="/upload/slider/<?=$fileName?>"/></a>
				<?else:?>
				<img src="/upload/slider/<?=$fileName?>"/>
				<?endif;?>
			</div>	
			<?	endforeach; ?>
		<!-- 해당샵의 등록된 이미지 -->
		</div>
		<!-- 해당샵의 등록된 이미지 -->
		<div class="bannerTab">
			<ul class="tabBtn_<?=sizeof($img);?>">	
			<?	foreach($img as $key => $fileName) :  ?>
				<li><a href="#"><?=$text[$key]?></a></li>
			<?	endforeach; ?>
			</ul>
		</div>
		<!-- 해당샵의 등록된 이미지 -->
	</div>

