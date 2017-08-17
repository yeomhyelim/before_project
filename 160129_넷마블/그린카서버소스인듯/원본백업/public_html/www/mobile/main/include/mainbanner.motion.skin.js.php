<script language="javascript" type="text/javascript" src="../common/js/slides.jquery.js"></script>
<script>
	$(function(){
		// Initialize Slides
		$('#mainbanner_motion2').slides({
			container: 'mainbanner_container',
			generatePagination: false,
			play: 2000,
			pause: 1000,
			start: 1,
			ways:'<?=$sliderMotionType?>'
		});
	});
</script>