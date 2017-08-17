<script type="text/javascript">
<!--
	$(document).ready(function(){

		/*-- 이벤트 --*/
		onPageLoad();
	});

	/*-- 이벤트 --*/
	function postPaperListMoveClickEvent()	{ goFirstPageMove('postPaperList'); }			// 뒤로

	/*-- 이벤트 정의 --*/
	function onPageLoad() {

	}



	/*-- 기능 함수 --*/
	function goFirstPageMove(mode) {
		document.form.page.value = "";
		goMove(mode);
	}

	function goSelectMove(mode, no) {
		// 이동
		document.form.pm_no.value = no;
		goMove(mode);
	}

	function goMove(mode) {
		// 이동
		C_getMoveUrl(mode,"get","<?=$PHP_SELF?>");
	}

	function goSelectAct(mode, no) {
		// 액션
		document.form.pm_no.value = no;
		goAct(mode);
	}

	function goAct(mode) {
		// 액션
		C_getAction(mode,"<?=$PHP_SELF?>");
	}
//-->
</script>