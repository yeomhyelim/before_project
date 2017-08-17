<script type="text/javascript">
<!--
	$(document).ready(function(){

		/*-- 이벤트 --*/
		onPageLoad();
	});

	/*-- 이벤트 --*/
	function postSmsSendActClickEvent()	{ goAct('postSmsSend'); }			// 발송
	function postSmsCloseClickEvent()	{ goPopClose(); }					// 팝업닫기

	/*-- 이벤트 정의 --*/
	function onPageLoad() {

	}



	/*-- 기능 함수 --*/
	function goSelectMove(mode, no) {
		// 이동
		document.form.pm_no.value = no;
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

	function goPopClose() {
		// 팝업 닫기
		parent.goPopClose();
	}
//-->
</script>