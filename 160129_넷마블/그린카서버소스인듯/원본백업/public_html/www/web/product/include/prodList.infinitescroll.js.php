<?
$tpagenum			= isset ( $intAppTotPage ) ? $intAppTotPage : $intTotPage ;
$infinite_tagselect = isset ( $intAppTotPage ) ? 'eq(1)' : 'first' ;
?>
<script language="javascript" type="text/javascript" src="/common/js/jquery.infinitescroll.min.js"></script>
<script type='text/javascript'>
$(document).ready(function(){

	$('.prodNewListWrapA table').infinitescroll({
		loading: {
			finished: false ,
            img: '/himg/etc/icon_loading.gif' ,
            msg: null,
			msgText: '',
			selector: '#contentWrap' ,
            speed: 'fast',
            start: undefined
        },
		state: {
            isDuringAjax: false,
            isInvalidPage: false,
            isDestroyed: false,
            isDone: false, // For when it goes all the way through the archive.
            isPaused: false,
            isBeyondMaxPage: false,
            currPage: 1
        },
		maxPage:'<?=$tpagenum ?>' ,
		navSelector: '#pagenate',
		nextSelector:'#pagenate a:<?=$infinite_tagselect?>',
		itemSelector: '.prodNewListWrapA table tbody tr' ,
		nextBtn : '#btnProductMore',
		debug: false,
		dataType: 'html',
		path: function(index) {
			var url = window.location.search.substring(1).replace (/\&page=[0-9]*/ , '') ;
			return '?' + url + '&page=' + index ;
		},
		errorCallback: function () {
			$('#btnProductMore , #infscr-loading').remove();
			$(window).unbind('.infscr');
		},
	});
	<?
	// infinite scroll type A
	if ( $S_SHOP_MORE_VIEW_USE == 'A' ) {
	?>
	$('#pagenate').css('display','none');
	$(window).unbind('.infscr');
	$(document).on('click','a#btnProductMore',function(){
		$('.prodNewListWrapA table').infinitescroll('retrieve');
		return false;
	});
	<? } ?>
});
</script>