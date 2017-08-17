<script type="text/javascript">
<!--
	$(document).ready(function(){

		/*-- 이벤트 --*/
		onPageLoad();
	});

	/*-- 이벤트 --*/
	function postPaperModifyMoveClickEvent()		{ goMove('postPaperModify'); }			// 수정
	function postPaperShotMoveClickEvent()			{ goMove('postPaperShot'); }			// 대량 쪽지 보내기
	function postPaperListMoveClickEvent()			{ goSelectMove('postPaperList',''); }	// 목록

	/*-- 이벤트 정의 --*/
	function onPageLoad() {

	}

	/*-- 기능 함수 --*/
	function goSelectMove(mode, no) {
		// 이동
		document.form.pp_no.value = no;
		C_getMoveUrl(mode,"get","<?=$PHP_SELF?>");
	}

	function goMove(mode) {
		// 이동
		C_getMoveUrl(mode,"get","<?=$PHP_SELF?>");
	}

	function goAct(mode) {
		// 액션
		C_getAction(mode,"<?=$PHP_SELF?>");
	}
//-->
</script>